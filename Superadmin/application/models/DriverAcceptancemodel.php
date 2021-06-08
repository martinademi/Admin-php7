<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class DriverAcceptancemodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('CallAPI');
        $this->load->model("Home_m"); 
    }


    // function get_estimateList(){

    //   $this->load->library('mongo_db');
    //   $res=$this->mongo_db->get('estimationFare');
     
    //   return $res;
    //  }

    function getDriverinfo($driverId){

       $res=$this->mongo_db->where(array('_id'=> new MOngoDB\BSON\ObjectID($driverId)))->find_one('driver');
        
       echo json_encode($res);

    }

     function get_driverList($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

         $_POST['iColumns'] = 1;

         $_POST['mDataProp_0'] = "firstName";
        // $_POST['mDataProp_1'] = "storeWiseFare.orderId";

        
     
  
       //$respo =  $this->datatables->datatable_mongodb('driver', array('serviceType'=>1,'status'=> array('$nin'=>[2,3,16,17] ) ),'_id',-1);
       $respo =  $this->datatables->datatable_mongodb('driver', array( ),'_id',-1);
    

        $aaData = $respo["aaData"];
        $datatosend = array();
        $slno = $_POST['iDisplayStart']+1;
        
        foreach ($aaData as $value) {
         //  echo '<pre>';print_r($value);die;
           
            if($value['driverType']==1){
                    $type="Freelancer";
            }else{
                $type="Store Driver";
            }
         $arr = array();
         $na='N/A';

     //    $arr[] = (isset($res['acceptance']['totalBookings']) && $res['acceptance']['totalBookings'] != 0) ? '<a style="cursor: pointer;color: dodgerblue;" href="' . base_url() . 'index.php?/driverAcceptanceRate/bookingDetails/totalBookings/' . $res['_id']['$oid'] . '">' . $res['acceptance']['totalBookings'] . '</a>' : '0';

        $mobile=$value['countryCode'].' '.$value['mobile'];
      
        $driverName='<a style="cursor:pointer;color:blue" id="'.$value['_id']['$oid'].'" class="getDriverInfo">'.$value['firstName'].' '.$value['lastName'].'</a>';
        $driverPhone='<a style="cursor:pointer;color:blue" id="" href="#">'.$this->Home_m->maskFileds($mobile, 2).'</a>';
        $driverEmail= $this->Home_m->maskFileds($value['email'], 1);;
        $arr[] = $slno++;
        $arr[]=  $driverName;
        $arr[]=  $driverPhone;
        $arr[]= $driverEmail;
        $arr[]=   $type;
        $arr[] = (isset($value['acceptance']['totalBookings']) && $value['acceptance']['totalBookings'] != 0) ? '<a style="cursor: pointer;color: dodgerblue;" href="' . base_url() . 'index.php?/DriverAcceptanceController/bookingDetails/totalBookings/' . $value['_id']['$oid'] . '">' . $value['acceptance']['totalBookings'] . '</a>' : '0';
        //$arr[]=   $value['acceptance']['totalBookings'];
        $arr[]=(isset($value['acceptance']['acceptedBookings']) && $value['acceptance']['acceptedBookings'] != 0) ? '<a style="cursor: pointer;color: dodgerblue;" href="' . base_url() . 'index.php?/DriverAcceptanceController/bookingDetails/acceptedBookings/' . $value['_id']['$oid'] . '">' . $value['acceptance']['acceptedBookings'] . '</a>' : '0';
        $arr[]=(isset($value['acceptance']['rejectedBookings']) && $value['acceptance']['rejectedBookings'] != 0) ? '<a style="cursor: pointer;color: dodgerblue;" href="' . base_url() . 'index.php?/DriverAcceptanceController/bookingDetails/rejectedBookings/' . $value['_id']['$oid'] . '">' . $value['acceptance']['rejectedBookings'] . '</a>' : '0';
        $arr[]=(isset($value['acceptance']['cancelledBookings']) && $value['acceptance']['cancelledBookings'] != 0) ? '<a style="cursor: pointer;color: dodgerblue;" href="' . base_url() . 'index.php?/DriverAcceptanceController/bookingDetails/cancelledBookings/' . $value['_id']['$oid'] . '">' . $value['acceptance']['cancelledBookings'] . '</a>' : '0';
        $arr[]=(isset($value['acceptance']['ignoredBookings']) && $value['acceptance']['ignoredBookings'] != 0) ? '<a style="cursor: pointer;color: dodgerblue;" href="' . base_url() . 'index.php?/DriverAcceptanceController/bookingDetails/ignoredBookings/' . $value['_id']['$oid'] . '">' . $value['acceptance']['ignoredBookings'] . '</a>' : '0';
        //$arr[]=  $value['acceptance']['acceptanceRate'];
        $arr[]=(isset($value['acceptance']['acceptanceRate']) ) ?    $value['acceptance']['acceptanceRate']: 'N/A';
        
        
          $datatosend[] =$arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function getDriverData($id = '') {
        $this->load->library('mongo_db');
        $response = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->select(array('firstName', 'lastName'))->find_one('driver');
        return $response;
    }

    
    function datatable_bookingDetails($type = '', $driverId = '') {
       
        $this->load->library('Datatables');
        $this->load->library('table');

        //Serachable feilds
        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "firstName";
        $_POST['mDataProp_1'] = "lastName";
        $_POST['mDataProp_2'] = "phone.phone";
        $_POST['mDataProp_3'] = "email";
        

        $condition = array('dispatched.driverId' => new MongoDB\BSON\ObjectID($driverId));
      
        //Tab types
        switch ($type) {
            case 'totalBookings':$respo = $this->datatables->datatable_mongodb('completedOrders', $condition);
                // echo '<pre>';print_r($respo);die;
                $aaData = $respo["aaData"];
                $condition = array("dispatched" => array('$elemMatch' => array('driverId' => new MongoDB\BSON\ObjectID($driverId))));
                $totalUnAssingedBooking = $this->mongo_db->where($condition)->get('unassignOrders');
                $totalAssingedBooking = $this->mongo_db->where($condition)->get('assignOrders');
                $aaData = array_merge($totalUnAssingedBooking,$totalAssingedBooking,$aaData);               
                break;
            case 'acceptedBookings':$condition = array('bookingStatus'=>array('$nin'=>[5]),'driverDetails.driverId' => new MongoDB\BSON\ObjectID($driverId));
                $respo = $this->datatables->datatable_mongodb('completedOrders', $condition);
                $aaData = $respo["aaData"];
                $acceptedBooking = $this->mongo_db->where($condition)->get('assignOrders');
                $aaData = array_merge($aaData,$acceptedBooking);
                break;
            case 'rejectedBookings':$condition = array("dispatched" => array('$elemMatch' => array('driverId' => new MongoDB\BSON\ObjectID($driverId), 'status' => "Rejected")));
                $respo = $this->datatables->datatable_mongodb('completedOrders', $condition);
                $aaData = $respo["aaData"];
                $rejectedBooking = $this->mongo_db->where($condition)->get('unassignOrders');
                $aaData = array_merge($aaData,$rejectedBooking);
                break;
            case 'cancelledBookings':
                $condition['bookingStatus'] = 5;
                $respo = $this->datatables->datatable_mongodb('completedOrders', $condition);
                $aaData = $respo["aaData"];
                break;
            case 'ignoredBookings':$condition = array("dispatched" => array('$elemMatch' => array('driverId' => new MongoDB\BSON\ObjectID($driverId), 'status' => "Ignored")));
                $respo = $this->datatables->datatable_mongodb('completedOrders', $condition);
                $aaData = $respo["aaData"];
                $ingoredBooking = $this->mongo_db->where($condition)->get('bookingsUnassigned');
                $aaData = array_merge($aaData,$ingoredBooking);
                break;
        }

        $datatosend = array();
        $slno = 0;

        foreach ($aaData as $res) {
            //Mask the email and phone for demo user
           // echo '<pre>';print_r($res);die;
            // if ($this->session->userdata('maskEmail') == TRUE) {
            //     $mobile = $this->maskFileds($res['slaveDetails']['countryCode'] . $res['slaveDetails']['mobile'], 2);
            // } else
            //     $mobile = $res['slaveDetails']['countryCode'] . $res['slaveDetails']['mobile'];

            $receivedDate = '';
            $rejectedTime = 'N/A';
            $ignoredTime = 'N/A';
            foreach ($res['dispatched'] as $dispatched) {
              
                if ($driverId == $dispatched['driverId']['$oid']) {
                   // $receivedDate = date('d-m-Y h:i:s A', (($dispatched['receiveDt']['$date'] / 1000) - ($this->session->userdata('timeOffset') * 60)));
                    $receivedDate=$dispatched['receiveDt'];
                    // echo '<pre>';print_r($dispatched);die;
                    if (isset($dispatched['rejectedTime']))
                        //$rejectedTime = date('d-m-Y h:i:s A', (($dispatched['rejectedTime']['$date']) / 1000 - ($this->session->userdata('timeOffset') * 60)));
                        $rejectedTime = $dispatched['rejectedTime'];
                    if (isset($dispatched['expiryTime']))
                       // $ignoredTime = date('d-m-Y h:i:s A', ($dispatched['expiryTime'] - ($this->session->userdata('timeOffset') * 60)));                       
                       $ignoredTime=date('m/d/Y H:i:s' ,$dispatched['expiryTime']);                      

                    break;
                }
            }

            $arr = array();
            $arr[] = (isset($res['orderId'])?$res['orderId'] :"N/A");
            $arr[] = $res['customerDetails']['name'];
            $arr[] = $res['customerDetails']['countryCode'].$res['customerDetails']['mobile'];
            $arr[] =  $receivedDate;
            // $arr[] = (isset($res['timeStamp']['accepted']) && $res['timeStamp']['accepted'] != 0 && $res['timeStamp']['accepted'] != "") ? date('d-m-Y h:i:s A', ($res['timeStamp']['accepted'] - ($this->session->userdata('timeOffset') * 60))) : 'N/A';
            $arr[] ="N/A";
             $arr[] = $rejectedTime;
            $arr[] = (isset($res['timeStamp']['cancelledBy']['timeStamp']) && $res['timeStamp']['cancelledBy']['timeStamp'] != 0 && $res['timeStamp']['cancelledBy']['timeStamp'] != "") ? date('d-m-Y h:i:s A', ($res['timeStamp']['cancelledBy']['timeStamp'] - ($this->session->userdata('timeOffset') * 60))) : 'N/A';
           // $arr[] ="N/A";
             $arr[] = $ignoredTime;
            $arr[] = $res['statusMsg'];
            
   

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
     

}
?>