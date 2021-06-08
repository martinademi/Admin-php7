<?php
if (!defined("BASEPATH"))
  exit("Direct access to this page is not allowed");

class Referralmodal extends CI_Model {

  public function __construct() {
    parent::__construct();
//    $this->load->database();
     
  }

    
    function datatable_Refferral($param = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        
        
       $respo = $this->datatables->datatable_mongodb('Campanians',array("couponType" =>"REFERRAL",'status' =>(int)$param)); 
       
        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            
            $arr = array();

            $arr[] = $value['title'];
            $arr[] = $value['cityName'];
            $arr[] = '<a href="'.base_url().'index.php?/Referral/refferalHistory/'. $value['_id']['$oid'].'" style="cursor: pointer;"/>'.($value['usedCount']).'</a>';
            $arr[] = '<input type="checkbox" id="promoID" class="checkbox" name="checkbox" data-id="'.$value['_id']['$oid'].'" value="'.$value['_id']['$oid'].'_'.$value['cityId']['$oid'].'">';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function referralData(){
        $this->load->library('mongo_db');
        $canpaningData = $this->Referralmodal->getCampanians("REFERREL");
         
            $campData = [];
            foreach ($canpaningData as $value) {
                $cmpUsed = $this->mongo_db->get_where('Campanians',array("coupon_type" => "USERCAMPAIN", "campainId" => (string)$value['_id']['$oid']));
                $campuData = [];
                foreach ($cmpUsed as $val) {
                    $campuData[] = $val;
                }
                $value['Used'] = count($campuData);
                $campData[] = $value;
            }
            return $campData;
    }
     function cityForZones($city_ID = null) {
      $this->load->library('mongo_db');
    if ($city_ID != null)
        return $this->mongo_db->get_where('cities',array('_id'=>new MongoDB\BSON\ObjectID($city_ID)));
    else
        return $this->mongo_db->get('cities');
  }
    
  
 function getData() {
    $this->load->library('mongo_db');
     $cityData = $this->mongo_db->get('cities');
        return $cityData;
  }
  function activeReferral() {
 
       $this->load->library('mongo_db');
        $mongoid = explode("_", $this->input->post('mongoid'));
        $cursorNew = $this->mongo_db->where(array('couponType' => "REFERRAL", 'cityId' =>new MongoDB\BSON\ObjectID($mongoid[1])))->set(array('status' =>2))->update('Campanians',array('multi' =>TRUE));
        $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mongoid[0])))->set(array('status' =>1))->update('Campanians');
        
        $msg = 1;
        if ($cursor && $cursorNew) {
            $msg = 0;
        }
        echo json_encode(array('msg' => $msg));
  }
  function inactiveReferral(){
   $this->load->library('mongo_db');
        $mongoid = explode("_", $this->input->post('mongoid'));
//        $cursorNew = $this->mongo_db-> where(array( "couponType" => "REFERRAL", "cityId" => $mongoid[1]))->set(array('status' => 1))->update('Campanians');
        $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mongoid[0])))->set( array('status' => 2))->update('Campanians');
        $msg = 1;
        if ($cursor && $cursorNew) {
            $msg = 0;
        }
        echo json_encode(array('msg' => $msg));
  }
  function getCampanians($param = null, $mongoId = null) {
 $this->load->library('mongo_db');
    if ($param == "REFERREL") {
      $city = array();
      $citiesname = $this->cityForZones();
     
      foreach ($citiesname as $res){
        $city[$res['_id']['$oid']] = $res['city'];
      }
     
      if ($mongoId != null){
        $res_ = $this->mongo_db->get_where("Campanians", array('couponType' => "REFERRAL", "_id" =>  new MongoDB\BSON\ObjectID($mongoId)));
      }
      else
      {
        $res_ = $this->mongo_db->get_where("Campanians", array('couponType' => "REFERRAL"));
      }
      foreach ($res_ as $data) {
        $data['cityname'] = $city[$data['cityId']['$oid']];
        $return[] = $data;
      }
    }
    if ($param == "PROMOTION") {
      $city = array();
      $citiesname = $this->cityForZones();
      
      foreach ($citiesname as $res)
      {
        $city[$res['_id']['$oid']] = $res['city'];
      }
      
      if ($mongoId != null)
      {
        $res_ = $this->mongo_db->get_where('Campanians', array('couponType' => "PROMOTION", '_id' =>  new MongoDB\BSON\ObjectID($mongoId)));
      }
      else {
        $res_1 = $this->mongo_db->get_where('Campanians', array('couponType' => 'PROMOTION', "promotionType" => '2'));
        $res_2 = $this->mongo_db->get_where('Campanians', array('couponType' => 'PROMOTION', "promotionType" => '2'));
      }
      if ($mongoId != null) {
        foreach ($res_ as $data) {
          $data['cityname'] = $city[$data['cityId']['$oid']];
          $data['stdate'] = date('m/d/Y|H : m', $data['startDate']);
          $data['enddate'] = date('m/d/Y|H : m', $data['endDate']);
          $return[] = $data;
        }
      } else {
        $return_1 = [];
        foreach ($res_1 as $data) {
          $data['cityname'] = $city[$data['cityId']['$oid']];
          $return_1[] = $data;
        }
        $return_2 = [];
        foreach ($res_2 as $data) {
          $data['cityname'] = $city[$data['cityId']['$oid']];
          $return_2[] = $data;
        }
        $return['promotion'] = $return_1;
        $return['promotionWallete'] = $return_2;
      }
    }
//    echo '<pre>';
//    print_r($return);
//    echo '</pre>';
//    exit();
    return $return;
  }
  function gerHistoryData($param = ''){
      $this->load->library('mongo_db');
          $this->mongo_db->where(array('_id'=>new MongoDB\BSON\ObjectID($param)))->get('Campanians');
  }

  function datatable_refferalHistory($param) {
    $this->load->library('mongo_db');
    $this->load->library('Datatables');

    $datatosend = array();

    $_POST['iColumns'] = 5;
    $_POST['mDataProp_0'] = "UserName";
    $_POST['mDataProp_1'] = "Coupon_code";
    $_POST['mDataProp_2'] = "UserEmail";
    $_POST['mDataProp_3'] = "UserId";
    $_POST['mDataProp_3'] = "UserMobile";

//        $_POST['sSortDir_4'] = "desc";
    $respo = $this->datatables->datatable_mongodb('Campanians', array("coupon_type" => "REFERRAL"));
   $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            
            $arr = array();
            $arr[] = $value['title'];
            $arr[] = $value['cityName'];
            $arr[] = '<a href="'.base_url().'index.php?/Referral/refferalHistory/'. $value['_id']['$oid'].'" style="cursor: pointer;"/>'.($value['usedCount']).'</a>';
            $arr[] = '<input type="checkbox" id="promoID" class="checkbox" name="checkbox" data-id="" value="'.$value['_id']['$oid'].'_'.$value['cityId']['$oid'].'">';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
}

function datatable_refererHistory($param) {
  $this->load->library('mongo_db');
  $this->load->library('Datatables');

  $referralData = $this->mongo_db->get_one('Campanians', array("UserId" => (int) $param));

  $datatosend = array();

  if (is_array($referralData['referred'])) {
    $refData = $referralData['referred'];
    foreach ($refData as $value) {
      $slave_data = $this->db->query("select * from slave where slave_id ='" . $this->db->escape_str($value['userId']) . "'")->row_array();

      $arr = array(
        $value['userId'],
        $slave_data['first_name'] . $slave_data['last_name'],
        $slave_data['phone'],
        date('d-M-Y', strtotime($slave_data['created_dt'])),
        ($slave_data['gender'] == '1') ? "Male" : (($slave_data['gender'] == '2') ? "Female" : "--"),
        ($slave_data['email'] == '') ? "--" : $slave_data['email']
        );
      $flg = 0;
      if ($this->input->post('sSearch') != '') {
        $needle = ucwords($this->input->post('sSearch'));
        $ret = array_keys(array_filter($arr, function($var) use ($needle) {
          return strpos(ucwords($var), $needle) !== false;
        }));
        if (empty($ret)) {
          $flg = 1;
        }
      }
      if ($flg == 0) {
        $arr[1] = "<a target='_blank' href=" . base_url() . "index.php/superadmin/passenger_pofile/" . $arr[0] . ">" . $arr[1] . "</a>";
        $datatosend[] = $arr;
      }
    }
  }

  echo $this->datatables->getdataFromMongo_notify($datatosend);
}


function exportData($stdate = '',$enddate = '') {
  $this->load->library('mongo_db');
      
        $datatosend = array();
        
        if($stdate != '' && $enddate != '')
            $aaData = $this->mongo_db->where(array('status'=>array('$in'=>[3,10]),'payment_type'=>array('$in'=>["1","2"]),'timpeStamp_appointment_date'=>array('$gte'=>strtotime($stdate),'$lte'=>strtotime($enddate.' 23:59:59'))))->order_by(array('_id'=>-1))->get('ShipmentDetails');
        else
           $aaData = $this->mongo_db->where(array('status'=>array('$in'=>[3,10]),'payment_type'=>array('$in'=>["1","2"])))->order_by(array('_id'=>-1))->get('ShipmentDetails');
        
        
        $appConfig =  $this->mongo_db->find_one('appConfig'); 

    
        foreach ($aaData as $value) {
          
            
            $arr = array();
            $arr['Booking ID'] = $value['order_id'];
            $arr['Booking Date & Time'] = ($value['booking_time'] == '0')?'':date('j-M-Y H:i:s',strtotime($value['booking_time']));
            $arr['Driver Name'] = $value['driverDetails']['fName'].''.$value['driverDetails']['lName'];
            $arr['Customer Name'] = $value['slaveName'];
         
            $arr['Billed Amount'] = ($value['status'] == 3)?$appConfig['currencySymbol'].' '.$value['invoice']['cancelationFee']:$appConfig['currencySymbol'].' '.number_format($value['invoice']['total'],2);
            $arr['Discount'] =   $appConfig['currencySymbol'].' '.number_format($value['invoice']['Discount'],2);
            $arr['App Earnings'] =  $appConfig['currencySymbol'].' '.number_format($value['invoice']['appcom'],2);
            $arr['App Profit-Lose'] =   $appConfig['currencySymbol'].' '.number_format($value['invoice']['appProfitLoss'],2);
            $arr['Payment Gateway Commission'] =  $appConfig['currencySymbol'].' '.number_format($value['invoice']['pgComm'],2);
            $arr['Driver Earnings'] =   $appConfig['currencySymbol'].' '.number_format($value['invoice']['masEarning'],2);
            $arr['Referrer Earnings'] =  $appConfig['currencySymbol'].' '.number_format($value['accouting']['MasterReferralEarnings'],2);
            $arr['Payment Method'] = ($value['payment_type'] == '1')?'Card':'Cash';
           
            $arr['Status'] = unserialize(JobStatus)[$value['status']];
            
            
            $datatosend[] = $arr;
        }
       
        return $datatosend;
    }

    // end of zonnel concept
}
?>
