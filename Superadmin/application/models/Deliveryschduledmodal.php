<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Deliveryschduledmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('CallAPI');
    }

    public function datatable_getProviderDetails($zoneId,$status,$timeOffset) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        // $timeOffset =-($timeOffset);

        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "startDate";
        $_POST['mDataProp_1'] = "endDate";
        $_POST['mDataProp_2'] = "startTime";
        $_POST['mDataProp_3'] = "endTime";
        //$_POST['mDataProp_4'] = "day";
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
            $respo = $this->datatables->datatable_mongodb('zonesDeliveryWorking',array('zoneId'=>$zoneId,'status'=> 1));
            break;
            case 2:
            $respo = $this->datatables->datatable_mongodb('zonesDeliveryWorking', array('zoneId'=>$zoneId,'status' => 2));
            break;
            case 3:
            $respo = $this->datatables->datatable_mongodb('zonesDeliveryWorking', array('zoneId'=>$zoneId,'status' => 3));
            break;


        }

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();
            $selectedDays ='';
            // foreach($value['day'] as $days=>$value11){
                foreach($value['day'] as $days){
                $selectedDays.=(string)$days." ";
            }

            $startDateTimeForClient = date("Y-m-d H:i:s",($value['startDateTimestamp'] - ($timeOffset) ));
            $endDateTimeForClient = date("Y-m-d H:i:s",($value['endDateTimestamp'] - ($timeOffset) ));           
            $arr[] = $sl++;
            $arr[] = ($startDateTimeForClient != '') ? substr($startDateTimeForClient,0,10) : 'N/A';
            $arr[] = ($startDateTimeForClient != '') ? substr($startDateTimeForClient,11,5) : 'N/A';
            $arr[] = ($endDateTimeForClient != '') ? substr($endDateTimeForClient,0,10) : 'N/A';          
            $arr[] = ($endDateTimeForClient != '') ? substr($endDateTimeForClient,11,5) : 'N/A';
            $arr[] = $selectedDays;
           // $arr[] =  $deliveryDetails='<a class="" href="'.base_url()."index.php?/Deliveryschduled/slotDetails/".$value['_id']['$oid'].'" style="color: royalblue;"  id="'.$value['_id'].'">View</a>';
            $arr[] = "<a href='".base_url()."index.php?/Deliveryschduled/slotDetails/".$value['_id']['$oid']."'><button class='btn btnview btn-primary cls111' style='width:35px; border-radius: 25px;display:none' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-eye' aria-hidden='true'></i></button></a> <button class='btn btndelete btn-primary cls111' style='width:35px; border-radius: 25px;' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-trash' style='font-size:12px;'></i> </button>";
          //  $arr[] = "<button class='btn btn-primary cls111 scheduleModal' style='width:45px; border-radius: 25px;'>Add</button>";
            
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        //echo json_encode($respo);

       
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
        $timeOffset = $this->session->userdata('timeOffset');
        $timeOffset = $timeOffset * 60; // now it convert  in minutes

        $startTimestamp  = (strtotime($this->input->post('startTime4TS')) + ($timeOffset));
        $endTimestamp =  (strtotime($this->input->post('endTime4TS')) + ($timeOffset));
        $startDate = date('Y-m-d H:i:s',$startTimestamp);
        $endDate = date('Y-m-d H:i:s',$endTimestamp);
        $startTime =  date('H:i:s',$startTimestamp);
        $endTime = date('H:i:s',$endTimestamp);

        
        $data['zoneId'] = $zoneId;
        $data['cityId'] = $cityId;
        $data['startTime'] = $startTime; // $this->input->post('startTime');
        $data['endTime'] = $endTime; // $this->input->post('endTime');
        $data['startDateTimestamp']= $startTimestamp; //(strtotime($this->input->post('startTime4TS')) + ($timeOffset));
        $data['endDateTimestamp'] = $endTimestamp; //(strtotime($this->input->post('endTime4TS')) + ($timeOffset) );

        $originalStartTime =  $startTime; 
        $originalEndTime =  $endTime;


        $data['startDate'] = $startDate; //$this->input->post('startDate');
        $data['endDate'] = $endDate; //$this->input->post('endDate');
		$data['startTimeDate'] = $startDate; //$this->input->post('startDate');
        $data['endTimeDate'] = $endDate; 
        $data['deviceTime'] = $this->input->post('deviceTime');
        $data['status'] = (int)$this->input->post('status');
        $data['statusMsg'] ='Active';
        $data['noofdelivery'] = $this->input->post('noofdelivery');

        $data['fromDateChanged']=$this->input->post('fromDateChanged');
        $data['toDateChanged']=$this->input->post('toDateChanged');
       
        $data['startDateISO'] =  $this->mongo_db->date($startTimestamp*1000);
        $data['endDateISO'] = $this->mongo_db->date($endTimestamp*1000);
  
        $startWtGmt = $startDate; // $this->input->post('startDate');
        $endDateWtGmt = $endDate ; //$this->input->post('endDate');


        $onlystartDate = $startDate;
        $onlyendDate = $endDate;
  

        $startdiff=date_diff(date_create(date("Y-m-d", strtotime($startWtGmt))),date_create(date("Y-m-d", strtotime($data['startTimeDate']))));

        $enddiff=date_diff(date_create(date("Y-m-d", strtotime($endDateWtGmt))),date_create(date("Y-m-d", strtotime($data['endTimeDate']))));
        $fromdatacount=$startdiff->format("%a");
        $enddatecount=$enddiff->format("%a");

       

        if($fromdatacount==1 ||  $fromdatacount=="1"){
            $data['fromDateChanged']="-". (string)$fromdatacount;
           
        }else{
            $data['fromDateChanged']="";
          
        }

        if($enddatecount==1 ||  $enddatecount=="1"){
            $data['toDateChanged']="+".(string)$enddatecount;
           
        }else{
            $data['toDateChanged']="";
           
        }

        foreach($this->input->post('days') as $day){
            $data['day'][]= $day;
        }
        $data['date']=(object)array();
          
        $queryObj = array(
            "zoneId"=>$data['zoneId'],
            "status" =>1,
            '$or'=>[
                    [
                        "startDateTimestamp"=>[
                            '$gte'=>$data['startDateTimestamp'],'$lte'=>$data['endDateTimestamp']
                        ]
                    ],
                    [
                        "endDateTimestamp"=>[
                            '$gte'=>$data['startDateTimestamp'],'$lte'=>$data['endDateTimestamp']
                        ]
                    ],
                    [
                        '$and'=>[
                            ["startDateTimestamp"=>['$gte'=>$data['startDateTimestamp']]],
                            ["endDateTimestamp"=>['$lte'=>$data['endDateTimestamp']]]
                        ]
                        ],
                    [
                        '$and'=>[
                            ["startDateTimestamp"=>['$lte'=>$data['endDateTimestamp']]],
                            ["endDateTimestamp"=>['$gte'=>$data['startDateTimestamp']]]
                        ]
                    ]
            ]
        );
        $workingHourStoreData = $this->mongo_db->where($queryObj)->get('zonesDeliveryWorking');

        $insertFlag = 0;
        $msg ='';
        if(count($workingHourStoreData)){
        foreach($workingHourStoreData as $whData){
               if($data['startDateTimestamp'] >= $whData['startDateTimestamp'] && $data['endDateTimestamp'] <= $whData['endDateTimestamp']  ) {
                      if(strcmp($data['startTime'],$whData['endTime'])>0 || strcmp($data['endTime'],$whData['startTime'])<0){
                        $msg="pass1";
                        $insertFlag =1;
                      }
                      else{
                        $dayflag=0;
                          foreach($this->input->post('days') as $comingday){
                              if( $dayflag==1){
                                break;
                              }
                              else{

                                foreach($whData['day'] as $whday){
                                    if($whday == $comingday ){
                                        $dayflag=1;
                                        break;
                                    }
                                
                                  }
                              }
                             
                          }
                          if($dayflag==0){
                            $msg="Slot successfylly added pass8";
                            $insertFlag =1;
                          }
                          else{
                            $insertFlag =0;
                            $msg= "Slot is already exist";
                            break;
                          }
                      
                      }
                        
                    }
                    else if($data['endDateTimestamp'] < $whData['startDateTimestamp']  || $data['startDateTimestamp'] > $whData['endDateTimestamp'] ){
                            // insert flag =1
                            $msg="pass2";
                            $insertFlag =1;
                    }
                    else if($data['startDateTimestamp'] < $whData['startDateTimestamp'] && $data['endDateTimestamp'] < $whData['endDateTimestamp'] ){
                        if(strcmp($data['startTime'],$whData['endTime'])>0 || strcmp($data['endTime'],$whData['startTime'])<0){
                            $msg="pass3";
                            $insertFlag =1;
                          }
                          else{
                            $dayflag=0;
                            foreach($this->input->post('days') as $comingday){
                                if( $dayflag==1){
                                  break;
                                }
                                else{
                                //   foreach($whData['day'] as $whday=>$whdayval){
                                    foreach($whData['day'] as $whday){
                                      if($whday == $comingday ){
                                          $dayflag=1;
                                          break;
                                      }
                                  
                                    }
                                }
                               
                            }
                            if($dayflag==0){
                              $msg="Slot successfylly added pass9";
                              $insertFlag =1;
                            }
                            else{
                                $insertFlag =0;
                              $msg= "end datetime exist please change the end date time";
                              break;
                            }
                            // $msg= "end datetime exist please change the end date time";
                            // break;    
                          }
                             
                    }
                    else if($data['startDateTimestamp'] > $whData['startDateTimestamp'] && $data['endDateTimestamp'] > $whData['endDateTimestamp'] ){
                        
                        if(strcmp($data['startTime'],$whData['endTime'])>0 || strcmp($data['endTime'],$whData['startTime'])<0){
                            $insertFlag =1;
                            $msg="Slot successfylly added";
                          }
                          else{
                            $dayflag=0;
                            foreach($this->input->post('days') as $comingday){
                                if( $dayflag==1){
                                  break;
                                }
                                else{
                                //   foreach($whData['day'] as $whday=>$whdayval){
                                    foreach($whData['day'] as $whday){
                                      if($whday == $comingday ){
                                          $dayflag=1;
                                          break;
                                      }
                                  
                                    }
                                }
                               
                            }
                            if($dayflag==0){
                              $msg="Slot successfylly added pass10";
                              $insertFlag =1;
                            }
                            else{
                                $insertFlag =0;
                              $msg= "start datetime exist please change the end date time";
                              break;
                            }
                            // $msg= "start datetime exist please change the start date time"; 
                            // break;
                          }
                           
                    }
                    else if($data['startDateTimestamp'] <= $whData['startDateTimestamp'] && $data['endDateTimestamp'] >= $whData['endDateTimestamp']  ) {
                        if(strcmp($data['startTime'],$whData['endTime'])>0 || strcmp($data['endTime'],$whData['startTime'])<0){
                          $msg="pass1";
                          $insertFlag =1;
                        }
                        else{
                          $dayflag=0;
                            foreach($this->input->post('days') as $comingday){
                                if( $dayflag==1){
                                  break;
                                }
                                else{
                                  // foreach($whData['day'] as $whday=>$whdayval){
                                  foreach($whData['day'] as $whday){
                                      if($whday == $comingday ){
                                          $dayflag=1;
                                          break;
                                      }
                                  
                                    }
                                }
                               
                            }
                            if($dayflag==0){
                              $msg="Slot successfylly added pass8";
                              $insertFlag =1;
                            }
                            else{
                              $insertFlag =0;
                              $msg= "Slot is already exist";
                              break;
                            }
                         
                        }
                          
                      }
                    else{
                        //$insertFlag =1;
                        $insertFlag =0;
                        $msg ="Slot is already exist";
                    }
               }
            
          }
          else{
                $msg="Slot successfylly added";
              $insertFlag =1;
          }
          
        
          $data["_id"]=new MongoDB\BSON\ObjectID();
          $id=(string)$data["_id"];
          $dataLin=array('_id'=> $id);
        
          if($insertFlag == 1){

            $this->mongo_db->insert('zonesDeliveryWorking',$data);
            $date_from = $onlystartDate;   
            $date_from = strtotime($date_from); 
            $date_to = $onlyendDate;  
            $date_to = strtotime($date_to); 
            $daysArray= $data['day'];
            for ($i=$date_from; $i<=$date_to; $i+=86400) {  
                $data['date']= date("Y-m-d", $i);
                $datetime = DateTime::createFromFormat('Y-m-d', $data['date']);
                $dayName = $datetime->format('D');
                
                if(in_array($dayName, $daysArray)){
                    $startDateTS = date("Y-m-d", $i).' '.$originalStartTime;
                    $endDateTS = date("Y-m-d", $i).' '.$originalEndTime;
                    $data['startDateTimestamp'] = strtotime($startDateTS);
                    $data['endDateTimestamp'] = strtotime($endDateTS);
                    $data['startDateISO'] = $this->mongo_db->date(strtotime($startDateTS)*1000);
                    $data['endDateISO']= $this->mongo_db->date(strtotime($endDateTS)*1000);
                    $data['dayName'] = $dayName;
                    $data['zonesDeliveryWorkingId'] = $id;
                    $data['availableDelivery'] = (int)$data['noofdelivery'];
                    $data['bookedDelivery'] = 0;
                    $data['driver']=[];
                    unset($data['startTimeDate']);
                    unset($data['endTimeDate']);
                    unset($data['startDate']);
                    unset($data['endDate']);
                    unset($data['fromDateChanged']);
                    unset($data['toDateChanged']);
                    unset($data['day']);
                    unset($data['_id']);
                    $this->mongo_db->insert('zonesDeliverySlots',$data);

                }
                
               
            }  
            echo json_encode(array('msg'=> $msg,'flag' => 1));
            return;

              
          }
          else{
              // not insert
              echo json_encode(array('msg'=> $msg,'flag' => 2));
              return;
          } 
        
       
    }
    
    function deleteSchduled() {
        $this->load->library('mongo_db');
        $whId = $this->input->post('whId');
      $dltdata= $this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($whId)))->set(array('status'=>3,'statusMsg'=>"Deleted"))->update('zonesDeliveryWorking');
      $this->mongo_db->where(array("zonesDeliveryWorkingId"=> $whId))->set(array('status'=>3,'statusMsg'=>"Deleted"))->update('zonesDeliverySlots',array('multi'=>TRUE));

        echo json_encode($dltdata);
    }
    

}

