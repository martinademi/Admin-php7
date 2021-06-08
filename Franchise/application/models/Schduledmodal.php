<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Schduledmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('CallAPI');
    }

    public function datatable_getProviderDetails($status = '',$timeOffset = '') {
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

        $timeOffset = $this->session->userdata('fadmin')['timeOffset'];
        $timeOffset = $timeOffset * 60; // now it convert  in minutes

            $date= date("Y-m-d h:i:sa");
           // $dateTimestamp = strtotime('+5 hour +30 minutes',strtotime($date));
           $dateTimestamp = strtotime($date);
            $workingHourStoreDoc = $this->mongo_db->where(array('status'=> 1,'franchiseId'=>$this->session->userdata('fadmin')['MasterBizId'], 'endDateTimestamp'=>['$lt'=>$dateTimestamp]))->get('workingHour') ;
            if(count($workingHourStoreDoc)){
                foreach($workingHourStoreDoc as $whDoc){
                    $whOid= (string)$whDoc['_id']['$oid'];
                    $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($whOid)))->set(array('status'=>2,'statusMsg'=>"expire"))->update('workingHour');
                }
            }
            


        $sl = $_POST['iDisplayStart'] + 1;

        switch((int)$status){
            case 1:
            $respo = $this->datatables->datatable_mongodb('workingHour',array('franchiseId'=>$this->session->userdata('fadmin')['MasterBizId'],'status'=> 1),'','');
            break;
            case 2:
            $respo = $this->datatables->datatable_mongodb('workingHour', array('franchiseId'=>$this->session->userdata('fadmin')['MasterBizId'],'status' => 2),'','');
            break;
            case 3:
            $respo = $this->datatables->datatable_mongodb('workingHour', array('franchiseId'=>$this->session->userdata('fadmin')['MasterBizId'],'status' => 3),'','');
            break;


        }

        $aaData = $respo["aaData"];
    //    echo '<pre>';print_r($respo);die;
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();
            $selectedDays ='';
            // foreach($value['day'] as $days=>$value11){
                foreach($value['day'] as $days){

                $selectedDays.=(string)$days." ";
            }
            $startDateTimeForClient = date('Y-m-d H:i:s',($value['startDateTimestamp'] - ($timeOffset) ));//date("Y-m-d H:i:s",strtotime($timeOffset.'minutes',strtotime($value['startDate'])));
            $endDateTimeForClient = date('Y-m-d H:i:s',($value['endDateTimestamp'] - ($timeOffset) ));
            //date("Y-m-d H:i:s",strtotime($timeOffset.'minutes',strtotime($value['endDate'])));
      


            $arr[] = $sl++;
            //$arr[] = ($value['startDate'] != '') ? substr($value['startDate'],0,10) : 'N/A';
            $arr[] = ($startDateTimeForClient != '') ? substr($startDateTimeForClient,0,10) : 'N/A';
            //$arr[] = ($value['endDate'] != '') ? substr($value['endDate'],0,10) : 'N/A';
            $arr[] = ($endDateTimeForClient != '') ? substr($endDateTimeForClient,0,10) : 'N/A';
            $arr[] = ($startDateTimeForClient != '') ? substr($startDateTimeForClient,11,5) : 'N/A';
            $arr[] = ($endDateTimeForClient != '') ? substr($endDateTimeForClient,11,5) : 'N/A';
            $arr[] = $selectedDays;
            $arr[] = ($value['notes'] != '') ? $value['notes'] : 'N/A';
            $arr[] = "<button class='btn btnslot btn-primary cls111' style='width:35px; border-radius: 25px;' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-plus-square-o' aria-hidden='true'></i></button> <button class='btn btnview btn-primary cls111' style='width:35px; border-radius: 25px;' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-eye' aria-hidden='true'></i></button> <button class='btn btndelete btn-primary cls111' style='width:35px; border-radius: 25px;' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-trash' style='font-size:12px;'></i> </button>";
            // <button class='btn btnedit btn-primary cls111' style='width:35px; border-radius: 25px;' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-edit' style='font-size:12px;'></i> </button>
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);

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


        $url = APILink . "admin/schdule/" . $cityid . '/' . $catid . '/' . $userType . '/' . $stDate;

        $respo = json_decode($this->callapi->CallAPI('GET', $url), true);
      
//        print_r($respo);
//        exit();
//     

        echo json_encode(array('response' => $respo));
    }

    function getSlotSchduled(){
        $this->load->library('mongo_db');
        $objId = new MongoDB\BSON\ObjectID($this->input->post('whId'));
        $sDate=$this->input->post('date');
        
        $timeOffset =$this->input->post('offset');
        $timeOffset = -($timeOffset);
        
        $oId = (string)$objId;
        
        $whData = $this->mongo_db->where(array('_id'=> $objId))->find_one('workingHour');
        // print_r($sDate);
        // print_r("-------");
        // print_r($whData);
        // die;
        $htmlData='<table class="sTable"><thead><tr><th>Day</th><th>Date</th><th>Start Time</th><th>End Time</th><th>Delete</th></tr></thead><tbody>';
        // foreach($whData['day'] as $key=>$value){
           
            
            //foreach($whData['date'] as $key){
            //if(count($value)){
                if($sDate!=''|| $sDate!=null){
                    $selectedDay = date('D', strtotime($this->input->post('date')));
                    if(in_array($selectedDay,$whData['day']) && count($whData['date'][$sDate])){
                        foreach($whData['date'][$sDate] as $valData ){
                            $startDateTimeForClient = date("Y-m-d H:i:s",strtotime($timeOffset.'minutes',strtotime($valData['startTimeDate'])));
                            $endDateTimeForClient = date("Y-m-d H:i:s",strtotime($timeOffset.'minutes',strtotime($valData['endTimeDate'])));
                           

                            $startDate = substr($startDateTimeForClient,0,10);
                            $startTime = substr($startDateTimeForClient,11,5);
                            $endTime =   substr($endDateTimeForClient,11,5);
                            $htmlData.= '<tr>';
                            $htmlData.='<td>'.$selectedDay.'</td>';
                            $htmlData.= '<td>'.$startDate.'</td><td>'.$startTime.'</td><td>'.$endTime.'</td><td><button class="btn btn-primary dltSlot" data-id="'.$oId.'" data-date="'.$valData['slotDate'].'" data-startTime="'.$valData['startTime'].'" data-endTime="'.$valData['endTime'].'"><i class="fa fa-trash"></i></button></td>';
                            $htmlData.= '</tr>';
                        }
                      
                    }
                    else{
                        $htmlData.= '<tr>';
                        $htmlData.= '<td>No Record Found</td>';
                        $htmlData.= '</tr>';
                    }
                }
                else{
                    foreach($whData['date'] as $allslotData){
                       foreach($allslotData as  $valData){
                        $startDateTimeForClient = date("Y-m-d H:i:s",strtotime($timeOffset.'minutes',strtotime($valData['startTimeDate'])));
                        $endDateTimeForClient = date("Y-m-d H:i:s",strtotime($timeOffset.'minutes',strtotime($valData['endTimeDate'])));
                        $startDate = substr($startDateTimeForClient,0,10);
                        $startTime = substr($startDateTimeForClient,11,5);
                        $endTime =   substr($endDateTimeForClient,11,5);
                        $htmlData.= '<tr>';
                        $htmlData.='<td>'.date('D', strtotime($startDate)).'</td>';
                        $htmlData.= '<td>'.$startDate.'</td><td>'.$startTime.'</td><td>'.$endTime.'</td><td><button class="btn btn-primary dltSlot" data-id="'.$oId.'" data-date="'.$valData['slotDate'].'" data-startTime="'.$valData['startTime'].'" data-endTime="'.$valData['endTime'].'"><i class="fa fa-trash"></i></button></td>';
                        $htmlData.= '</tr>';
                       }
                    }

                }
        $htmlData.='</tbody></table>';
        echo json_encode($htmlData);
    }

    function deleteParticularSlot(){
        $this->load->library('mongo_db');
        $objId = new MongoDB\BSON\ObjectID($this->input->post('whId'));
        
        $data['date'] = $this->input->post('date');
        $data['sTime'] = $this->input->post('sTime');
        $data['eTime'] = $this->input->post('eTime');
        $nameOfDay = date('D', strtotime($this->input->post('date')));
        //$key1 = 'day.'.$nameOfDay;
        $key1 = 'date.'.$data['date'];
       $info=$this->mongo_db->where(array('_id'=> $objId))->pull($key1, array('startTime'=>$data['sTime'],'endTime'=>$data['eTime'],'slotDate'=>$data['date']))->update('workingHour');
       print_r($info);
    }

    function addSlotSchduled(){
        $this->load->library('mongo_db');

        $timeOffset = $this->session->userdata('fadmin')['timeOffset'];
        $timeOffset = $timeOffset * 60; // now it convert  in minutes


        $objId = new MongoDB\BSON\ObjectID($this->input->post('objId'));

        $data['startTime'] = $this->input->post('sTimeSlot');
		
        $data['endTime'] = $this->input->post('eTimeSlot');
        $data['slotDate'] = $this->input->post('slotDate');
		$slotKey = $this->input->post('slotDate');
        $data['startTimeDate'] =$data['slotDate']." ". $data['startTime'];
		$data['endTimeDate'] =$data['slotDate']." ". $data['endTime'];
		
        $data['startDateTimestamp'] = (strtotime($this->input->post('slotDate4StartTS')) + ($timeOffset));
        $data['endDateTimestamp'] = (strtotime($this->input->post('slotDate4EndTS')) + ($timeOffset) );

        $data['startDateISO'] =  $this->mongo_db->date($data['startDateTimestamp']*1000);
        $data['endDateISO'] = $this->mongo_db->date($data['endDateTimestamp']*1000);
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
        // print_r($this->input->post('slotDate4StartTS'));
        // print_r($dateandstarttime);
        // die;
       // $dateTimestamp = strtotime($this->input->post('slotDate'));
       $dateTimestamp = strtotime($dateandstarttime);

        $nameOfDay = date('D', strtotime($this->input->post('slotDate')));
        $days = $this->mongo_db->where(array('_id'=> $objId))->find_one('workingHour');
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
            
            // $key1 = 'day.'.$nameOfDay;
           $key1 = 'date.'.$slotKey;
            // $this->mongo_db->where(array("_id"=> $objId))->push(array($key1=>$data))->update('workingHour');
            // echo json_encode(array("msg"=>"Slot created successflly","flag"=>1));
             $this->mongo_db->where(array("_id"=> $objId))->push(array($key1=>$data))->update('workingHour');
            echo json_encode(array("msg"=>"Slot created successflly","flag"=>1));

        }
        else{
            //echo json_encode(array("msg"=>"Slot already exist","flag"=>2));
            echo json_encode(array("msg"=>$msg,"flag"=>2));
        }
       
        
    }

    function addSchduled() {
        $this->load->library('mongo_db');
        $timeOffset = $this->session->userdata('fadmin')['timeOffset'];
        $timeOffset = $timeOffset * 60; // now it convert  in minutes

        $startTimestamp  = (strtotime($this->input->post('startTime4TS')) + ($timeOffset));
        $endTimestamp =  (strtotime($this->input->post('endTime4TS')) + ($timeOffset));
        $startDate = date('Y-m-d H:i:s',$startTimestamp);
        $endDate = date('Y-m-d H:i:s',$endTimestamp);
        $startTime =  date('H:i:s',$startTimestamp);
        $endTime = date('H:i:s',$endTimestamp);


        $data['franchiseId'] = $this->session->userdata('fadmin')['MasterBizId'];
        $data['startTime'] = $startTime; // $this->input->post('startTime');
        $data['endTime'] = $endTime; // $this->input->post('endTime');
        $data['startDateTimestamp']= $startTimestamp; //(strtotime($this->input->post('startTime4TS')) + ($timeOffset));
        $data['endDateTimestamp'] = $endTimestamp; //(strtotime($this->input->post('endTime4TS')) + ($timeOffset) );
      
        $data['startDate'] = $startDate; //$this->input->post('startDate');
        $data['endDate'] = $endDate; //$this->input->post('endDate');
		$data['startTimeDate'] = $startDate; //$this->input->post('startDate');
        $data['endTimeDate'] = $endDate; 
        $data['deviceTime'] = $this->input->post('deviceTime');
        $data['status'] = (int)$this->input->post('status');
        $data['statusMsg'] ='Active';
        $data['notes'] = $this->input->post('notes');
        $data['fromDateChanged']=$this->input->post('fromDateChanged');
        $data['toDateChanged']=$this->input->post('toDateChanged');
       
        $data['startDateISO'] =  $this->mongo_db->date($startTimestamp*1000);
        $data['endDateISO'] = $this->mongo_db->date($endTimestamp*1000);
  
        $startWtGmt = $startDate; // $this->input->post('startDate');
        $endDateWtGmt = $endDate ; //$this->input->post('endDate');

        $startdiff=date_diff(date_create(date("Y-m-d", strtotime($startWtGmt))),date_create(date("Y-m-d", strtotime($data['startTimeDate']))));

        $enddiff=date_diff(date_create(date("Y-m-d", strtotime($endDateWtGmt))),date_create(date("Y-m-d", strtotime($data['endTimeDate']))));
        $fromdatacount=$startdiff->format("%a");
        $enddatecount=$enddiff->format("%a");

       

        if(   $fromdatacount==1 ||  $fromdatacount=="1"){
            $data['fromDateChanged']="-". (string)$fromdatacount;
           
        }else{
            $data['fromDateChanged']="";
          
        }

        if(  $enddatecount==1 ||  $enddatecount=="1"){
            $data['toDateChanged']="+".(string)$enddatecount;
           
        }else{
            $data['toDateChanged']="";
           
        }
      
       // $data['repeatDay'] = $this->input->post('repeatDay');
        //$data['day'] =array_combine($this->input->post('days'),$this->input->post('days'));
        foreach($this->input->post('days') as $day){
            //$data['day'][$day] = array();
           
            $data['day'][]= $day;
        }
        $data['date']=(object)array();
          
       // $data['duration'] = $this->input->post('duration');
    
        //$workingHourStoreData =  $this->mongo_db->where(array("storeId"=>$data['storeId']))->get('workingHour');
        $queryObj = array(
            "franchiseId"=>$data['franchiseId'],
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
        $workingHourStoreData = $this->mongo_db->where($queryObj)->get('workingHour');
        
        //print_r($workingHourStoreData);
        // // print_r($queryObj);
        // die;
        
        
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
                            $msg= "Slot already exist";
                            break;
                          }
                        // $msg= "Slot is already exist";
                        // break;
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
                          // $msg= "Slot is already exist";
                          // break;
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
         //echo '<pre>';print_r( $dataLin);die;

          
          if($insertFlag == 1){
            

            $this->mongo_db->insert('workingHour',$data);

            // storing data in particular store
            $url = APILink .'store/workingHour'; 
            $response = json_decode($this->callapi->CallAPI('POST', $url, $dataLin), true);
           // echo'if';   echo '<pre>';print_r($response);die;

        //  calling API to store the data in Particular stores
            $data['id']=(string)$data["_id"];
            unset($data['_id']);
            $hour['workingHours']=$data;
            $hour['franchiseId'] =$this->session->userdata('fadmin')['MasterBizId'];
            $url = APILink. 'store/update/categorires';
            $response1 = json_decode($this->callapi->CallAPI('PATCH', $url, $hour), true);
            //echo'if'; echo '<pre>';print_r($response1);die;
            
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
      // print_r($whId);die;
      $dltdata= $this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($whId)))->set(array('status'=>3,'statusMsg'=>"Deleted"))->update('workingHour');
      $dataLin=array();
      $url = APILink .'/store/workingHour/'.$whId; 
      $response = json_decode($this->callapi->CallAPI('DELETE', $url, $dataLin), true);
       echo json_encode(array('statusCode'=>200));
    }
    

}

