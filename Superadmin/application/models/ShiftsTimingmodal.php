<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class ShiftsTimingmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('CallAPI');
        $this->load->library('mongo_db');
    }

    public function datatable_getProviderDetails($zoneId,$status,$timeOffset) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        // $timeOffset =-($timeOffset);

        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "shiftName";
     
        $timeOffset = $this->session->userdata('timeOffset');
        $timeOffset = $timeOffset * 60; // now it convert  in minutes



            $date= date("Y-m-d h:i:sa");
           // $dateTimestamp = strtotime('+5 hour +30 minutes',strtotime($date));
           $dateTimestamp = strtotime($date);
            $workingHourStoreDoc = $this->mongo_db->where(array('status'=> 1,'zoneId'=>$zoneId, 'endDateTimestamp'=>['$lt'=>$dateTimestamp]))->get('zonesDeliveryWorking') ;
            if(count($workingHourStoreDoc)){
                foreach($workingHourStoreDoc as $whDoc){
                    $whOid= (string)$whDoc['_id']['$oid'];
                    $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($whOid)))->set(array('status'=>2,'statusMsg'=>"expire"))->update('zonesDeliveryWorking');
                }
            }
            


        $sl = $_POST['iDisplayStart'] + 1;

        switch((int)$status){
            case 1:
            $respo = $this->datatables->datatable_mongodb('shiftTimingsZones',array('zoneId'=>$zoneId,'status'=> 1),'_id',1);
            break;
            case 2:
            $respo = $this->datatables->datatable_mongodb('shiftTimingsZones', array('zoneId'=>$zoneId,'status' => 2),'_id',1);
            break;
            case 3:
            $respo = $this->datatables->datatable_mongodb('shiftTimingsZones', array('zoneId'=>$zoneId,'status' => 3),'_id',1);
            break;


        }

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            
            $arr = array();

            if($status == 1){
                $showbtn = "<a href='".base_url()."index.php?/ShiftTimings/slotDetails/".$value['_id']['$oid']."'><button class='btn btnview btn-primary cls111' style='width:35px; border-radius: 25px;display:none' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-eye' aria-hidden='true'></i></button></a> <button class='btn btndelete btn-primary cls111' style='width:35px; border-radius: 25px;' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-trash' style='font-size:12px;'></i> </button>";               
            }   
            else{
               $showbtn =  "<a href='".base_url()."index.php?/ShiftTimings/slotDetails/".$value['_id']['$oid']."'><button class='btn btnview btn-primary cls111' style='width:35px; border-radius: 25px;display:none' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-reply' aria-hidden='true'></i></button></a> <button class='btn btnactivate btn-primary cls111' style='width:35px; border-radius: 25px;' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-reply' style='font-size:12px;'></i> </button>";               
            }

            $arr[] = $sl++;
            $arr[] = $value['shiftName'];
            $arr[] = $value['startTime'];
            $arr[] = $value['endTime'];
            $arr[] = $showbtn;
       
            
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
        

    }


    public function datatable_getSlotSchduled($id,$timeOffset) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $timeOffset =-($timeOffset);

        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "date";
        $_POST['mDataProp_1'] = "startTime";
        $_POST['mDataProp_2'] = "endTime";
        $_POST['mDataProp_3'] = "dayName";
        $sl = $_POST['iDisplayStart'] + 1;
        $respo = $this->datatables->datatable_mongodb('zonesDeliverySlots',array('storeId'=>$this->session->userdata('badmin')['BizId'],'zonesDeliveryWorkingId'=>$id,'status'=> 1));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();

            if($value['bookedDelivery']>0){
                $deliveryDetails='<a class="" href="'.base_url()."index.php?/Deliveryschduled/bookingSlotdetails/".$id.'/'.$value['_id']['$oid'].'" style="color: royalblue;"  id="'.$value['_id'].'">' .$value['bookedDelivery']  . '</a>';
            }else{
                $deliveryDetails='<a class="" id="'.$value['_id'].'">' .$value['bookedDelivery']  . '</a>';

            }

            $startDateTimeForClient = date("Y-m-d H:i:s",strtotime($timeOffset.'minutes',strtotime($value['startDate'])));
            $endDateTimeForClient = date("Y-m-d H:i:s",strtotime($timeOffset.'minutes',strtotime($value['endDate'])));
     
            $arr[] = $sl++;
            $arr[] = $value['date'];
            $arr[] = date("H:i:s",strtotime($timeOffset.'minutes',strtotime($value['startTime'])));
            $arr[] = date("H:i:s",strtotime($timeOffset.'minutes',strtotime($value['endTime'])));
            $arr[] = $value['dayName'];
            $arr[] = $value['noofdelivery'];
            //$arr[] = ($value['bookedDelivery'])?$value['bookedDelivery']:0;
            $arr[] = $deliveryDetails;
            $arr[] = ($value['availableDelivery'])?$value['availableDelivery']:0;
            $arr[] = " <button class='btn dltSlot btn-primary cls111' style='width:35px; border-radius: 25px;' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-trash' style='font-size:12px;'></i> </button>";
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
      if ($this->input->post('sSearch') != '') {

            $FilterArr = array();
            foreach ($datatosend as $row) {
                $needle = ucwords(strtolower($this->input->post('sSearch')));

                $ret = array_keys(array_filter($row, function($var) use ($needle) {
                            return strpos(ucwords($var), $needle) !== false;
                        }));
                if (!empty($ret)) {
                    $FilterArr [] = $row;
                }
            }

            echo $this->datatables->getdataFromMongo($FilterArr);
        }

        if ($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($datatosend);
    }

    public function datatable_getBookingDetails($id,$timeOffset) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $timeOffset =-($timeOffset);

        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "date";
        $_POST['mDataProp_1'] = "startTime";
        $_POST['mDataProp_2'] = "endTime";
        $_POST['mDataProp_3'] = "dayName";
        $sl = $_POST['iDisplayStart'] + 1;
        $respo = $this->datatables->datatable_mongodb('zonesDeliverySlots',array('zonesDeliveryWorkingId'=>$id,'status'=> 1));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();

           

            $startDateTimeForClient = date("Y-m-d H:i:s",strtotime($timeOffset.'minutes',strtotime($value['startDate'])));
            $endDateTimeForClient = date("Y-m-d H:i:s",strtotime($timeOffset.'minutes',strtotime($value['endDate'])));
     
            $arr[] = $sl++;
            $arr[] = $value['orderId'];
            $arr[] = $value['customerName'];
            $arr[] = $value['driverName'];
            $arr[] = date("H:i:s",strtotime($timeOffset.'minutes',strtotime($value['orderDateTime'])));
            $arr[] = $value['status'];          
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
      if ($this->input->post('sSearch') != '') {

            $FilterArr = array();
            foreach ($datatosend as $row) {
                $needle = ucwords(strtolower($this->input->post('sSearch')));

                $ret = array_keys(array_filter($row, function($var) use ($needle) {
                            return strpos(ucwords($var), $needle) !== false;
                        }));
                if (!empty($ret)) {
                    $FilterArr [] = $row;
                }
            }

            echo $this->datatables->getdataFromMongo($FilterArr);
        }

        if ($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($datatosend);
    }

    public function getProviderDetailsCount($cityid = '', $catid = '', $userType = '', $stDate = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        if ($stDate != "0") {
            $stDate = strtotime($stDate);
            $stDate = strtotime(date('Y-m-d', $stDate) . '00:00:00');
        } else {
            $stDate = strtotime(date('Y-m-d', time()) . '00:00:00');
        }


        $url = APILINK . "admin/schdule/" . $cityid . '/' . $catid . '/' . $userType . '/' . $stDate;

        $respo = json_decode($this->callapi->CallAPI('GET', $url), true);

        echo json_encode(array('response' => $respo));
    }

    function getSlotSchduled(){
        $this->load->library('mongo_db');
        $objId = new MongoDB\BSON\ObjectID($this->input->post('whId'));
        $sDate=$this->input->post('date');
        
        $timeOffset =$this->input->post('offset');
        $timeOffset = -($timeOffset);
        
        $oId = (string)$objId;
        if($sDate){
            $whData = $this->mongo_db->where(array('zonesDeliveryWorkingId'=> $oId,'date'=>$sDate))->get('zonesDeliverySlots');
        }
        else{
            $whData = $this->mongo_db->where(array('zonesDeliveryWorkingId'=> $oId))->get('zonesDeliverySlots');
        }      
        echo json_encode($htmlData);
    }

    function deleteParticularSlot(){
        $this->load->library('mongo_db');
        $objId = new MongoDB\BSON\ObjectID($this->input->post('whId'));
        
     $info = $this->mongo_db->where(array("_id"=> $objId))->set(array('status'=>3,'statusMsg'=>"Deleted"))->update('zonesDeliverySlots');

       echo json_encode($info);
    }

    function addSlotSchduled(){
        $this->load->library('mongo_db');
        $objId = new MongoDB\BSON\ObjectID($this->input->post('objId'));
        //$data['storeId'] = $this->session->userdata('badmin')['BizId'];
        $data['startTime'] = $this->input->post('sTimeSlot');
		
        $data['endTime'] = $this->input->post('eTimeSlot');
        $data['slotDate'] = $this->input->post('slotDate');
		$slotKey = $this->input->post('slotDate');
        $data['startTimeDate'] =$data['slotDate']." ". $data['startTime'];
		$data['endTimeDate'] =$data['slotDate']." ". $data['endTime'];
		
        $data['startDateTimestamp'] = strtotime($this->input->post('slotDate4StartTS'));
        $data['endDateTimestamp'] = strtotime($this->input->post('slotDate4EndTS'));
        $dateandstarttime = $this->input->post('slotDate4StartTS');
        
        // changes 
        $startWtGmt = $this->input->post('slotDate4StartTS'); 
        $startdiff=date_diff(date_create(date("Y-m-d", strtotime($startWtGmt))),date_create(date("Y-m-d", strtotime($data['startTimeDate']))));
        $fromdatacount=$startdiff->format("%a");

        if(   $fromdatacount==1 ||  $fromdatacount=="1"){
            $data['fromDateChanged']="-". (string)$fromdatacount;

        }else{
            $data['fromDateChanged']="";

        }
       $dateTimestamp = strtotime($dateandstarttime);

        $nameOfDay = date('D', strtotime($this->input->post('slotDate')));
        $days = $this->mongo_db->where(array('_id'=> $objId))->find_one('zonesDeliveryWorking');
        $key =0;
        $msg='';
       if(($dateTimestamp < $days['startDateTimestamp']) || ($dateTimestamp > $days['endDateTimestamp']))
       {
        $key =0;
        $msg="Selected date not in between Start Date and End Date";
       }
        else{
            // foreach($days['day'] as $weekday=>$value){
                foreach($days['day'] as $weekday){
                //print_r($weekday);
                if($weekday == $nameOfDay){
                    if(count($days['date'])  && $days['date'][$this->input->post('slotDate')]){
                        $particularSlot = $days['date'][$this->input->post('slotDate')];
                        foreach($particularSlot as $parSlot){
                            if($data['startDateTimestamp'] > $parSlot['endDateTimestamp'] || $data['endDateTimestamp'] < $parSlot['startDateTimestamp']  ){
                                $key =1;
                            }
                            else{
                                $msg="Slot overlaping...";
                                $key =0;
                            }
                        }
                    }
                    
                    else{
                        $key =1;
                    }
                    
                   break;
                }
                else{
                    $key =0;
                    $msg = "The selected day is not belongs to your working days";
                }
                   
            }
        }
      
        if($key == 1){
           $key1 = 'date.'.$slotKey;
            
             $this->mongo_db->where(array("_id"=> $objId))->push(array($key1=>$data))->update('zonesDeliveryWorking');
            echo json_encode(array("msg"=>"Slot created successflly","flag"=>1));

        }
        else{
            echo json_encode(array("msg"=>$msg,"flag"=>2));
        }
       
        
    }

    function addSchduled($zoneId,$cityId) {

        
        $this->load->library('mongo_db');
        
        $data['zoneId'] =$zoneId;
        $shiftData=  json_decode($this->input->post('shiftDetails'),true);
        

        foreach( $shiftData as $shift ){
            $id=(string)$shift['shiftId'];
            $shiftDetails=$this->mongo_db->where(array('_id'=>  new MongoDB\BSON\ObjectID($id)))->find_one('shiftTimings');
            $data['shiftId']=$shiftDetails['_id']['$oid'];
            $data['startTime']=$shiftDetails['startTime'];
            $data['endTime']=$shiftDetails['endTime'];
            $data['shiftName']=$shiftDetails['shiftName'];
            $data['status']=$shiftDetails['status'];
            $data['statusMsg']=$shiftDetails['statusMsg'];

            $validate=$this->mongo_db->where(array('zoneId'=>$zoneId,'shiftId'=>$data['shiftId']))->find_one('shiftTimingsZones');

            if(!$validate){
                $rel= $this->mongo_db->insert('shiftTimingsZones',$data); 
            }
        //    $rel= $this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($zoneId)))->push(array('shiftTimings'=>$data))->update('zones',array('upsert'=>TRUE));
              

            

        }   
      
        if($rel){
            $msg="Shift created successfully";
            echo json_encode(array('msg'=> $msg,'flag' => 1));
            return;
        }else{
            $msg="Shift already exist";
            echo json_encode(array('msg'=> $msg,'flag' => 2));
            return;
        }
   
        
       
    }
    
    function deleteSchduled() {
        $this->load->library('mongo_db');
        $whId = $this->input->post('whId');   
        $status=$this->input->post('status');   
        if($status==1){
            $dltdata= $this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($whId)))->set(array('status'=>2,'statusMsg'=>"Deleted"))->update('shiftTimingsZones'); 
            $rel=2;   

            $data['driverRoster.$.status']=2;
            $driver=$this->mongo_db->where(array('driverRoster.shiftId'=>$whId ))->set($data)->update('driver',array('multi'=>TRUE));       
            
        }else{
            $dltdata= $this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($whId)))->set(array('status'=>1,'statusMsg'=>"Activated"))->update('shiftTimingsZones');                  
            $rel=1;

            $data['driverRoster.$.status']=1;
            $driver=$this->mongo_db->where(array('driverRoster.shiftId'=>$whId ))->set($data)->update('driver',array('multi'=>TRUE));
        }

        echo json_encode(array('msg'=>$rel));
    }

    function getShiftTimings(){

        $val=$this->mongo_db->where(array("status"=> 1))->get('shiftTimings');
        return $val;
    }
    

}

