<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class parametersmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');
    }

    function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->get('lang_hlp');
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function datatable_parameters($status) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "pName";
        $_POST['mDataProp_1'] = "status";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('RatingParams', array('status' => (int)$status), 'seqId', -1);

        $Data = $respo["aaData"];
        $datatosend = array();
    //    print_r($Data); die;
        $i = 1;
        foreach ($Data as $row) {
            $arr = array();

            if ($row['status'] == 1) {
                $status = 'Enabled';
            } else {
                $status = 'Disabled';
            }
            if ($row['associated'] == 1) {
                $associated = 'Driver';
            } else {
                $associated  = 'Order';
            }

            if(array_key_exists("storeTypeMsg",$row)){
              $storeType=$row['storeTypeMsg'];
            }else{
                $storeType='N/A';
            }

            $arr[] = $i++;
            $arr[] = "<a href ='" . base_url() . "index.php?/parametersController/driverRating/" . $row['_id']['$oid'] . "' >" . $row['pName'][0] . "</a>";
            $arr[] = $associated;
            $arr[] = $storeType;
            $arr[] = '<button class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $row['_id']['$oid'] . '"  data-id=' . $row['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxParam' data-id='" . $row['seqId'] . "' data='" . $row['_id']['$oid'] . "' value='" . $row['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
	function datatable_driverreview($status = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

		 $sl = $_POST['iDisplayStart'] + 1;
        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "firstName";
        $_POST['mDataProp_1'] = "averageRatingCount";
        $_POST['mDataProp_2'] = "averageRating";


        //$respo = $this->datatables->datatable_mongodb('driver', array(),'',-1);
        $respo = $this->datatables->datatable_mongodb('driver');

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
			//$rating = $this->mongo_db->where(array("driverDetails.driverId.$oid"=>$value['_id']['$oid']))->get('completedOrders');
            $arr = array();
            $arr[] = $sl++;
            $arr[] = $value['firstName']." ".$value['lastName'];
            $arr[] = ($value['averageRatingCount'] == "" || $value['averageRatingCount'] == null) ? "0": $value['averageRatingCount'] ;
			$arr[] = ($value['averageRating'] == "" || $value['averageRating'] == null) ? "N/A" : "<a href='" . base_url() . "index.php?/parametersController/rating_details/" . $value['_id']['$oid'] . "'>" .number_format($value['averageRating'],2,".",""). "</a>";
			//$arr[] = ($rating == "" || $rating == null)?"N/A":count($rating);
			//$arr[] = $value['customerDetails']['name'];
			//$arr[] = $value['driverDetails']['fName']." ". $value['driverDetails']['lName'];
			//$arr[] = $value['storeName'];
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_customerreview($status = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

		 $sl = $_POST['iDisplayStart'] + 1;
        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "averageRatingCount";
        $_POST['mDataProp_2'] = "averageRating";

        $respo = $this->datatables->datatable_mongodb('customer',array('name' => array('$exists'=>true)));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
		    $arr = array();
           
            $arr[] = $sl++;
            $arr[] = $value['name'];
            $arr[] = $value['countryCode'].' '.$value['phone'];
            $arr[] = ($value['ordersCount'] == "" || $value['ordersCount'] == null) ? "0": $value['ordersCount'] ;
            $arr[] = ($value['averageRating'] == "" || $value['averageRating'] == null) ? "N/A" : "<a href='" . base_url() . "index.php?/parametersController/cutomerrating_details/" . $value['_id']['$oid'] . "'>" .number_format($value['averageRating'],2,".",""). "</a>";
            
		    $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

// method for orderwise driver rating
function datatable_driverreviewdetails($driverId,$drivertabId) {
    $this->load->library('mongo_db');
    $this->load->library('Datatables');
    $this->load->library('table');

     $sl = $_POST['iDisplayStart'] + 1;
    $_POST['iColumns'] = 5;
    $_POST['mDataProp_0'] = "orderId";
    $_POST['mDataProp_1'] = "bookingDate";
    $_POST['mDataProp_2'] = "customerDetails.name";
    $_POST['mDataProp_3'] = "driverDetails.fName";
    $_POST['mDataProp_4'] = "driverDetails.lName";

   
    
    // $respo = $this->datatables->datatable_mongodb('completedOrders',array("driverDetails.driverId" => new MongoDB\BSON\ObjectID($driverId),'reviewByCustomer' => array('$exists'=>true)));
    
    // echo '<pre>';print_r($driverId);die;

   $dId=(string)$drivertabId;
    
    $respo = $this->datatables->datatable_mongodbAggregate('completedOrders', array(
        array('$match'=>array("driverDetails.driverId" => new MongoDB\BSON\ObjectID($driverId),'reviewByCustomer' => array('$exists'=>true))),
        array('$project'=>array('reviewByCustomer'=>1,'customerDetails'=>1,'orderId'=>1,'bookingDate'=>1,'driverDetails'=>1,'driverDetails'=>1,'storeName'=>1)),
        array('$unwind'=>'$reviewByCustomer.toDriver'),
        array('$match'=>array("reviewByCustomer.toDriver.id" => ($dId))),
        array('$sort'=>array('_id'=>-1))),
        array(array('$match'=>array("driverDetails.driverId" => new MongoDB\BSON\ObjectID($driverId),'reviewByCustomer' => array('$exists'=>true))),
        array('$unwind'=>'$reviewByCustomer.toDriver'),
        array('$match'=>array("reviewByCustomer.toDriver.id" => ($dId))),
        array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))
        ));
    
    //echo '<pre>';print_r($respo);die;
  
    $aaData = $respo["aaData"];
    $datatosend = array();
    $ratingData='';
    foreach ($aaData as $value) {

        $id = (string)$value->_id;
        $value = json_decode(json_encode($value), TRUE);

        $value['_id']['$oid'] =   $id;

        foreach($value['reviewByCustomer']['review'] as $rating){
            $ratingData= $rating['rating'];
        }
       
        //$rating = $this->mongo_db->where(array("driverDetails.driverId.$oid"=>$value['_id']['$oid']))->get('completedOrders');
        $arr = array();
        $arr[] = $sl++;
        $arr[] = $value['orderId'];
        $arr[] = $value['bookingDate'];
        $arr[] = ($ratingData =="" || $ratingData == null)? "0":$ratingData;
        $arr[] = $value['customerDetails']['name'];
        $arr[] = $value['driverDetails']['fName']." ". $value['driverDetails']['lName'];
        $arr[] = $value['storeName'];
        $datatosend[] = $arr;
    }

    $respo["aaData"] = $datatosend;
    echo json_encode($respo);
}



function datatable_orderreview($status = '') {
    $this->load->library('mongo_db');
    $this->load->library('Datatables');
    $this->load->library('table');

     $sl = $_POST['iDisplayStart'] + 1;
    $_POST['iColumns'] = 3;
    $_POST['mDataProp_0'] = "name";
    $_POST['mDataProp_1'] = "orderCount";
    $_POST['mDataProp_2'] = "averageRating";


    //$respo = $this->datatables->datatable_mongodb('driver', array(),'',-1);
    $respo = $this->datatables->datatable_mongodb('stores');

    $aaData = $respo["aaData"];
    $datatosend = array();

    foreach ($aaData as $value) {
        //$rating = $this->mongo_db->where(array("driverDetails.driverId.$oid"=>$value['_id']['$oid']))->get('completedOrders');
        $arr = array();
        $arr[] = $sl++;
        $arr[] = $value['name'];
        $arr[] = ($value['orderCount'] == "" || $value['orderCount'] == null) ? "0": $value['orderCount'] ;
        $arr[] = ($value['averageRating'] == "" || $value['averageRating'] == null) ? "N/A" : "<a href='" . base_url() . "index.php?/parametersController/orderRating_details/" . $value['_id']['$oid'] . "'>" .number_format($value['averageRating'],2,".",""). "</a>";
        //$arr[] = ($rating == "" || $rating == null)?"N/A":count($rating);
        //$arr[] = $value['customerDetails']['name'];
        //$arr[] = $value['driverDetails']['fName']." ". $value['driverDetails']['lName'];
        //$arr[] = $value['storeName'];
        $datatosend[] = $arr;
    }

    $respo["aaData"] = $datatosend;
    echo json_encode($respo);
}

// method for orderwise driver rating
function datatable_orderreviewdetails($storeId) {
    $this->load->library('mongo_db');
    $this->load->library('Datatables');
    $this->load->library('table');

     $sl = $_POST['iDisplayStart'] + 1;
    $_POST['iColumns'] = 6;
    $_POST['mDataProp_0'] = "orderId";
    $_POST['mDataProp_1'] = "customerDetails.name";
    $_POST['mDataProp_2'] = "rating";
    $_POST['mDataProp_3'] = "bookingDate";
    $_POST['mDataProp_4'] = "driverDetails.fName";
    $_POST['mDataProp_5'] = "driverDetails.lName";
   
    //$respo = $this->datatables->datatable_mongodb('driver', array(),'',-1);
    //$respo = $this->datatables->datatable_mongodb('completedOrders',array("storeId" => $storeId, '$or'=>[["status"=>15],["status"=>7]]));
   // print_r($storeId);die;

    $respo = $this->datatables->datatable_mongodbAggregate('completedOrders', 
        array(
            array('$match'=>array("storeId"=>$storeId,"status"=>array('$in'=>[15,7]))),array('$unwind' => '$reviewByCustomer.toOrder'),array('$project'=>array('orderId'=>1,'bookingDateTimeStamp'=>1,'customerDetails'=>1,'driverDetails'=>1,'totalAmount'=>1,
                'reviewByCustomer'=>1))),
        array(array('$match'=>array("storeId" => $storeId,"status"=>array('$in'=>[15,7]))),array('$group'=>array('_id'=>1,count=>array('$sum'=>1))))
    );

    

    $aaData = $respo["aaData"];
    $datatosend = array();
    $ratingData='';
    foreach ($aaData as $value) {
       
       $value = json_decode(json_encode($value),TRUE);
        $arr = array();
        $arr[] = $sl++;
        $arr[] = $value['orderId'];
        $arr[] = date('d-M-Y h:i:s a ', ($value['bookingDateTimeStamp']) - ($this->session->userdata('timeOffset') * 60));
        $arr[] = $value['reviewByCustomer']['toOrder']['rating'];
        $arr[] = $value['customerDetails']['name'];
        $arr[] = $value['driverDetails']['fName']." ". $value['driverDetails']['lName'];
        $arr[] = ($value['totalAmount'] == ''|| $value['totalAmount'] == null)? "0" :$value['currencySymbol'].$value['totalAmount'];
        $datatosend[] = $arr;
    }

    $respo["aaData"] = $datatosend;
    echo json_encode($respo);
}


// for customer
function datatable_customerreviewdetails($storeId) {
    
    $this->load->library('mongo_db');
    $this->load->library('Datatables');
    $this->load->library('table');

     $sl = $_POST['iDisplayStart'] + 1;
    $_POST['iColumns'] = 6;
    $_POST['mDataProp_0'] = "orderId";
    $_POST['mDataProp_1'] = "customerDetails.name";
    $_POST['mDataProp_2'] = "rating";
    $_POST['mDataProp_3'] = "bookingDate";
    $_POST['mDataProp_4'] = "driverDetails.fName";
    $_POST['mDataProp_5'] = "driverDetails.lName";
   
    
    //$respo = $this->datatables->datatable_mongodb('completedOrders',array("storeId" => $storeId, '$or'=>[["status"=>15],["status"=>7]]));
    
    $respo = $this->datatables->datatable_mongodb('completedOrders',array("customerDetails.customerId" => ($storeId),"status"=>15),'_id',1);
    

    $aaData = $respo["aaData"];
    $datatosend = array();
    $ratingData='';
    foreach ($aaData as $value) {
        // echo '<pre>';print_r($value);die;
        foreach($value['reviewByProvider'] as $key=>$rating){
            // echo '<pre>';print_r($rating);
            if($key=='rating'){
                $ratingData= $rating;
            }
           
        }
       //die;
        //$rating = $this->mongo_db->where(array("driverDetails.driverId.$oid"=>$value['_id']['$oid']))->get('completedOrders');
        $arr = array();
        $arr[] = $sl++;
        $arr[] = $value['orderId'];
        $arr[] = $value['bookingDate'];
        $arr[] = ($ratingData =="" || $ratingData == null)? "0":$ratingData;
        $arr[] = $value['customerDetails']['name'];
        $arr[] = $value['driverDetails']['fName']." ". $value['driverDetails']['lName'];
       // $arr[] = ($value['totalAmount'] == ''|| $value['totalAmount'] == null)? "0" :$value['currencySymbol'].$value['totalAmount'];
        $datatosend[] = $arr;
    }

    $respo["aaData"] = $datatosend;
    echo json_encode($respo);
}

    /* insert parameters for rating */

    function insert_param() {

        $data = $_POST;

        // echo '<pre>';print_r($data);die;

        $data['associated'] = (int)$data['associated'];
        if($data['associated'] == 1){
            $data['associatedMsg'] = "Associated with Driver";
        }else{
            $data['associatedMsg'] = "Associated with Order";
        }
        
//        echo '<pre>'; print_r($data); die;

        $lang = $this->mongo_db->get('lang_hlp');
        $lanCodeArr = [];
        $lanIdArr = [];
        foreach ($lang as $lan) {
            $lanCodeArr[0] = "en";
            $lanIdArr[0] = "0";
            if ($lan['Active'] == 1) {
                array_push($lanCodeArr, $lan['langCode']);
                array_push($lanIdArr, $lan['lan_id']);
            }
        }

        if (count($lanCodeArr) == count($data['pName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['pName']);
        } else if (count($lanCodeArr) < count($data['pName'])) {
            $data['name']['en'] = $data['pName'][0];

            foreach ($data['pName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['name'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['name'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['name']['en'] = $data['pName'][0];
        }
        
        $data['status'] = 1;
        $data['statusMsg'] = "Active";
 
        $Rdata = $this->mongo_db->get('RatingParams');

        $arr = [];
        $arrName = [];
        foreach ($Rdata as $d) {
            array_push($arr, $d['seqId']);
            array_push($arrName, $d['pName'][0]);
        }
        $max = max($arr);
        $seq = $max + 1;
        $data['seqId'] = (int) $seq;
    //  echo '<pre>'; print_r($data); die;

        try {
            if (!in_array($data['pName'][0], $arrName)) {
              
                $data = $this->mongo_db->insert('RatingParams', $data);
                echo json_encode(array('data' => $data, 'flag' => 1));
            } else {
              
                echo json_encode(array('data' => $data, 'flag' => 0));
            }
            return true;
        } catch (Exception $ex) {
            print_r($ex);
        }
    }

    public function getparam() {

        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('RatingParams');
 
        return $cursor;
    }
    public function getparams() {

        $val = $this->input->post('val');
        foreach ($val as $row){
        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('RatingParams');
        }
        return $cursor;
    }

    function editparams() {

        $data = $_POST;
        
        $id = $data['editId'];
        unset($data['editId']);
        
        $data['associated'] = (int)$data['associated'];
        if($data['associated'] == 1){
            $data['associatedMsg'] = "Associated with Driver";
        }else{
            $data['associatedMsg'] = "Associated with Order";
        }
        
//        echo '<pre>'; print_r($data); die;
        
        $lang = $this->mongo_db->get('lang_hlp');
        $lanCodeArr = [];
        $lanIdArr = [];
        foreach ($lang as $lan) {
            $lanCodeArr[0] = "en";
            $lanIdArr[0] = "0";
            if ($lan['Active'] == 1) {
                array_push($lanCodeArr, $lan['langCode']);
                array_push($lanIdArr, $lan['lan_id']);
            }
        }

        if (count($lanCodeArr) == count($data['pName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['pName']);
        } else if (count($lanCodeArr) < count($data['pName'])) {
            $data['name']['en'] = $data['pName'][0];

            foreach ($data['pName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['name'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['name'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['name']['en'] = $data['pName'][0];
        }
//        echo '<pre>'; print_r($data); die;
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('RatingParams');
    }

    function deleteparams() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->set(array('status' => 2,'statusMsg'=>"Deleted"))->update('RatingParams');
//        echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->delete('RatingParams');
        }
    }

    function hideparams() {

        $val = $this->input->post('val');
//        echo '<pre>'; print_r($val); die;
        foreach ($val as $row) {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->set(array('status' => 0,'statusMsg'=>"Inactive"))->update('RatingParams');
//            echo $this->mongo_db->update('RatingParams', array('Active' => 0), array("_id" => new MongoId($row)));
        }
    }

    function unhideparams() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->set(array('status' => 1,'statusMsg'=>"Active"))->update('RatingParams');
//            echo $this->mongo_db->update('RatingParams', array('Active' => 1), array("_id" => new MongoId($row)));
        }
    }

    function getConfigOne($id) {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('RatingParams');
        return $getAll;
    }
    
     function updateDriverRating($id) {
       
       $this->load->library('mongo_db');
       
        $getAllLanguages = $this->mongo_db->where(array('Active' => 1))->get('lang_hlp');

        $data['attributes']['en']['1'] = ($this->input->post('OneStartDesc') == NULL) ? array() : $this->input->post('OneStartDesc');
        $data['attributes']['en']['2'] = ($this->input->post('SecondStartDesc') == NULL) ? array() : $this->input->post('SecondStartDesc');
        $data['attributes']['en']['3'] = ($this->input->post('ThirdStarDesc') == NULL) ? array() : $this->input->post('ThirdStarDesc');
        $data['attributes']['en']['4'] = ($this->input->post('FourthStarDesc') == NULL) ? array() : $this->input->post('FourthStarDesc');
        $data['attributes']['en']['5'] = ($this->input->post('FiveStartDesc') == NULL) ? array() : $this->input->post('FiveStartDesc');

        foreach ($getAllLanguages as $lang) {
            $data['attributes'][$lang['langCode']]['1'] = ($this->input->post($lang['langCode'] . '_OneStartDesc') == NULL) ? array() : $this->input->post($lang['langCode'] . '_OneStartDesc');
            $data['attributes'][$lang['langCode']]['2'] = ($this->input->post($lang['langCode'] . '_SecondStartDesc') == NULL) ? array() : $this->input->post($lang['langCode'] . '_SecondStartDesc');
            $data['attributes'][$lang['langCode']]['3'] = ($this->input->post($lang['langCode'] . '_ThirdStarDesc') == NULL) ? array() : $this->input->post($lang['langCode'] . '_ThirdStarDesc');
            $data['attributes'][$lang['langCode']]['4'] = ($this->input->post($lang['langCode'] . '_FourthStarDesc') == NULL) ? array() : $this->input->post($lang['langCode'] . '_FourthStarDesc');
            $data['attributes'][$lang['langCode']]['5'] = ($this->input->post($lang['langCode'] . '_FiveStartDesc') == NULL) ? array() : $this->input->post($lang['langCode'] . '_FiveStartDesc');
        }
//        echo '<pre>'; print_r($this->input->post('parameterId'));  print_r($data); die;
        
        $query = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('RatingParams');
        return;
    }


    function driverAttr(){
       $respo=  $this->mongo_db->where(array("associated" => 1,'status'=>1))->select(array('name'=>'name'))->get('RatingParams');
    //    $respo=  $this->mongo_db->where(array("associated" => 1))->select(array('name'=>'name'))->get('RatingParams');
       return $respo; 

    }

    function customerName($driverId){
        $respo=  $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($driverId)))->select(array('name'=>'name'))->get('customer');
        return $respo; 
    }

    function driverName($driverId){
        $respo=  $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($driverId)))->select(array('firstName'=>'firstName','lastName'=>'lastName'))->get('driver');
        return $respo; 
    }

    
    function storeName($storeId){
        $respo=  $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($storeId)))->select(array('sName'=>'sName'))->get('stores');
        return $respo; 
    }
}

?>
