<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");


class OrdersModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('CallAPI');
    }

    function datatableOrders($status = '', $stDate = '', $endDate = '') {

        $this->load->library('Datatables');
		$this->load->library('table');
		$franchiseId = $this->session->userdata('fadmin')['MasterBizId'];
		// $storeId = $this->session->userdata('badmin')['BizId'];
        $_POST['iColumns'] = 7;

        $_POST['mDataProp_0'] = "slno";
        $_POST['mDataProp_1'] = "orderId";
        $_POST['mDataProp_2'] = "email";
        $_POST['mDataProp_3'] = "customerDetails.name";
        $_POST['mDataProp_4'] = "customerDetails.mobile";
        $_POST['mDataProp_5'] = "pickup.city"; 
		$_POST['mDataProp_6'] = "storeName";

// print_r($_POST['sSearch']);die;
				if ($stDate != '' && $endDate != ''){
					if($stDate == 1 || $stDate == 2){
						
						switch ($status) {
								case 0:$respo = $this->datatables->datatable_mongodb('newOrder', array("franchiseId"=>$franchiseId,"bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate),'',-1);
									break;
								case 1:$respo = $this->datatables->datatable_mongodb('unassignOrders', array("franchiseId"=>$franchiseId,"bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate),'',-1);
									break;
								case 2:$respo = $this->datatables->datatable_mongodb('assignOrders', array("franchiseId"=>$franchiseId,"bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate), '',-1);
									break;
								case 3:$respo = $this->datatables->datatable_mongodb('completedOrders', array("franchiseId"=>$franchiseId,"bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate),'',-1);
									break;
							   
							}
						
					}else if($stDate == 0 || $stDate == 0){
						switch ($status) {
									case 0:$respo = $this->datatables->datatable_mongodb('newOrder', array("franchiseId"=>$franchiseId,),'',-1);
										break;
									case 1:$respo = $this->datatables->datatable_mongodb('unassignOrders', array("franchiseId"=>$franchiseId,),'',-1);
										break;
									case 2:$respo = $this->datatables->datatable_mongodb('assignOrders', array("franchiseId"=>$franchiseId,), '',-1);
										break;
									case 3:$respo = $this->datatables->datatable_mongodb('completedOrders', array("franchiseId"=>$franchiseId,),'',-1);
										break;
								   
								}
						
					}else{
	 
						  switch ($status) {
								case 0:$respo = $this->datatables->datatable_mongodb('newOrder', array("franchiseId"=>$franchiseId,'timeStamp.created.isoDate' => array('$gte' => $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
									break;
								case 1:$respo = $this->datatables->datatable_mongodb('unassignOrders', array("franchiseId"=>$franchiseId,'timeStamp.created.isoDate' => array('$gte' => $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
									break;
								case 2:$respo = $this->datatables->datatable_mongodb('assignOrders', array("franchiseId"=>$franchiseId,'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))), '',-1);
									break;
								case 3:$respo = $this->datatables->datatable_mongodb('completedOrders', array("franchiseId"=>$franchiseId,'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
									break;
							   
							}
					}
	 
						 }else{
							 
								switch ($status) {
									case 0:$respo = $this->datatables->datatable_mongodb('newOrder', array("franchiseId"=>$franchiseId,),'',-1);
										break;
									case 1:$respo = $this->datatables->datatable_mongodb('unassignOrders', array("franchiseId"=>$franchiseId,),'',-1);
										break;
									case 2:$respo = $this->datatables->datatable_mongodb('assignOrders', array("franchiseId"=>$franchiseId,), '',-1);
										break;
									case 3:$respo = $this->datatables->datatable_mongodb('completedOrders', array("franchiseId"=>$franchiseId,),'',-1);
										break;
								   
								}
						 }
		
		

        $aaData = $respo["aaData"];
        $datatosend = array();
        $slno = $_POST['iDisplayStart']+1;
        
        foreach ($aaData as $value) {
            $arr = array();
            // switch($value['paymentType']){
			// 	case 1: $paymentType = "Card";
			// 		break;
			// 		case 2: $paymentType = "Cash";
			// 		break;
			// 		case 3: $paymentType = "Wallet";
			// 		break;
			// 		case 4: $paymentType = "Coin Payment";
			// 		break;
			// }
			if($value['bookingType'] == 1 && $value['serviceType'] == 1){
				$bookingType = "ASAP Delivery";
			}
			if($value['bookingType'] == 1 && $value['serviceType'] == 2){
				$bookingType = "ASAP Pickup";
			}
			if($value['bookingType'] == 2 && $value['serviceType'] == 2){
				$bookingType = "Scheduled Pickup";
			}
			if($value['bookingType'] == 2 && $value['serviceType'] == 1){
				$bookingType = "Scheduled Delivery";
			}
			foreach($value['dispatched'] as $dispatched){
				if($dispatched['status'] == "Accepted" ){
					$dispatchedName = $dispatched['fName'].' '.$dispatched['lName'];
				}
			}
            $arr[] = $slno++;
			// if($status == 3){
            // $arr[] = '<a target="_blank" href="' . base_url() . 'index.php?/Orders/orderDetails/' . $value['orderId'] . '">' . $value['orderId'] . '</a>';
			// }else{
			// $arr[] = $value['orderId'];
			// }
			//  hide contact details
			$arr[] = '<a style="cursor:pointer;text-decoration: underline; color:blue" class="orderDetails" value="'.$value['orderId'].'" orderId="'.$value['orderId'].'" >' . $value['orderId'] . '</a>';
			$arr[] = $value['pickup']['city'] ;
			$arr[] = $value['customerDetails']['name'] ;
			// $arr[] = $value['customerDetails']['countryCode'].$value['customerDetails']['mobile'];
			$arr[] = $value['storeName'] ;
			$arr[] = ($value['driverDetails']['fName'] == "" || $value['driverDetails']['fName'] == null)?"N/A":$value['driverDetails']['fName'] ;
			$arr[] = $bookingType ;
			// $arr[] = $value['bookingDate'];
			// $arr[] = $value['dueDatetime'];
			$arr[] =date('d-M-Y h:i:s a ', ($value['bookingDateTimeStamp']) - ($this->session->userdata('badmin')['timeOffset'] * 60));
			$arr[] =date('d-M-Y h:i:s a ', ($value['dueDatetimeTimeStamp']) - ($this->session->userdata('badmin')['timeOffset'] * 60));
			$arr[] = ($value['drop']['addressLine1'] == "" && $value['drop']['addressLine1']== null)?"N/A":$value['drop']['addressLine1'].$value['drop']['addressLine2'] ;
			$arr[] = $value['paymentTypeMsg'];
			if($value['abbrevation'] == "1"){
			$arr[] ='<a class="getBreakDownDetails" orderId="'.$value['orderId'].'"  value="'.$value['orderId'].'" style="cursor:pointer;" >'.$value["currencySymbol"].number_format($value['subTotalAmount'] , 2, '.', '').'</a>';
			}else{
			$arr[] ='<a class="getBreakDownDetails" orderId="'.$value['orderId'].'"  value="'.$value['orderId'].'" style="cursor:pointer;" >'.number_format($value['subTotalAmount'] , 2, '.', '').$value['currencySymbol'].'</a>';	
			}
			if($value['abbrevation'] == "1"){
				$arr[] =$value['currencySymbol'].number_format($value['deliveryCharge'], 2, '.', '');
			}else{
				$arr[] =number_format($value['deliveryCharge'], 2, '.', '').$value['currencySymbol'];
			}
			
			// $arr[] = ($value['timeStamp']['accepted']['timeStamp'] == "" || $value['timeStamp']['accepted']['timeStamp'] == null)?"N/A":date("F d,Y",$value['timeStamp']['accepted']['timeStamp']);
			$arr[] = ($value['timeStamp']['accepted']['timeStamp'] == "" || $value['timeStamp']['accepted']['timeStamp'] == null)?"N/A":date('d-M-Y h:i:s a ', ($value['timeStamp']['accepted']['timeStamp']) - ($this->session->userdata('badmin')['timeOffset'] * 60));;
			$arr[] = ($value['timeStamp']['accepted']['stausUpdatedBy'] == "" || $value['timeStamp']['accepted']['stausUpdatedBy'] == null)?"N/A":$dispatchedName;
			$arr[] = '<button style="width:35px !important;" class="btn btn-primary btnWidth manageOrder"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-asterisk"></i></i></button>' ;
			$arr[] = $value['statusMsg'] ;
			$arr[] = '<button style="width:35px !important;" class="btn btn-primary btnWidth orderAction"  value=' . $value['orderId'] . '><i class="glyphicon glyphicon-refresh"></i></button>' ;
            $datatosend[] = $arr;
        }



        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
	
	 function getOrdersCount() {
		 $franchiseId = $this->session->userdata('fadmin')['MasterBizId'];
        $this->load->library('mongo_db');
        $data['New'] = $this->mongo_db->where(array("franchiseId"=>$franchiseId))->count('newOrder');
        $data['Assigned'] = $this->mongo_db->where(array("franchiseId"=>$franchiseId))->count('assignOrders');
        $data['Unassigned'] = $this->mongo_db->where(array("franchiseId"=>$franchiseId))->count('unassignOrders');
        $data['Completed'] = $this->mongo_db->where(array("franchiseId"=>$franchiseId))->count('completedOrders');


        echo json_encode(array('data' => $data));
        
    }
	
	function acceptOrder(){
		 // $this->load->library('mongo_db');
		// $this->load->library('CallAPI');
		// $val = $this->input->post('val');
		// $status = $this->input->post('status');
		// $headerData['authorization'] =$this->session->userdata('fadmin')['apiToken']; 
		// $bodyData['status'] =$status;
		// $bodyData['timestamp'] = time();
		// $bodyData['orderId'] = (int)$val;
		// $bodyData['reason'] = "action by Atore Admin";
		// $url = APILink .'franchise/order/status';        
		// $response = json_decode($this->callapi->CallAPI('PATCH', $url, $bodyData,$headerData), true); 
		// if($response['statusCode'] == 200){
		// 	echo json_encode(array("statusCode"=>200));
		// }
		// else{
		// 	echo json_encode(array("statusCode"=>500));
		// }
	
	}
	
	
	function orderDetails($param,$status) {
		$franchiseId = $this->session->userdata('fadmin')['MasterBizId'];
        $this->load->library('mongo_db');
		switch($status){
			case 0:
			$data['res'] = $this->mongo_db->where(array("franchiseId"=>$franchiseId,'orderId' => (int) $param))->find_one('newOrder');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['franchiseId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;
			
			case 1:
			$data['res'] = $this->mongo_db->where(array("franchiseId"=>$franchiseId,'orderId' => (int) $param))->find_one('unassignOrders');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['franchiseId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;
			
			case 2:
			$data['res'] = $this->mongo_db->where(array("franchiseId"=>$franchiseId,'orderId' => (int) $param))->find_one('assignOrders');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['franchiseId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;
			
			case 3:
			$data['res'] = $this->mongo_db->where(array("franchiseId"=>$franchiseId,'orderId' => (int) $param))->find_one('completedOrders');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['franchiseId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;
			
			
		}
        
		// echo "<pre>";
		// print_r($data);die;
        // $tarr = array();
       // foreach ($tarrm as $value) {
        // foreach ($data['res']['appRouts'] as $val) {
            // $tarr[$val['subid']] = json_decode($val['ent_shipment_latlogs']);
        // }

        // $data['trip_route'] = $tarr;

        // $data['pickUpLatLong'] = $data['res']['pickup_location'];
        // $data['dropLatLong'] = $data['res']['drop_location'];

        // $data['appRoute'] = $jsonResponse;

        return $data;
    }
	function orderDetailsForDriverLocations($param){
			$franchiseId = $this->session->userdata('fadmin')['MasterBizId'];
		$this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('bid' => (int) $param))->find_one('locationLogs');
		return $data;
	}
	
	function getCities() {
		$this->load->library('mongo_db');
        $data = $this->mongo_db->get('cities');
        $res = array();
        foreach ($data as $cities) {
            foreach ($cities['cities'] as $city) {
				if($city['isDeleted'] == false){
                $res[] = $city;
				}
            }
        }

        echo json_encode(array('data'=>$res));
    }
	
	function getStores(){
		$this->load->library('mongo_db');
        $data = $this->mongo_db->where(array("status"=>1))->get('stores');

        echo json_encode(array('data'=>$data));
    }
	
	function ordersData(){
		$orderId = $this->input->post('orderId');
		$status = $this->input->post('status');
	$franchiseId = $this->session->userdata('fadmin')['MasterBizId'];
		switch($status){
									case 0:
									$orderData = $this->mongo_db->where(array("franchiseId"=>$franchiseId,'orderId'=>(int)$orderId))->find_one('newOrder');
										break;
									case 1:
									$orderData = $this->mongo_db->where(array("franchiseId"=>$franchiseId,'orderId'=>(int)$orderId))->find_one('unassignOrders');
										break;
									case 2:
									$orderData = $this->mongo_db->where(array("franchiseId"=>$franchiseId,'orderId'=>(int)$orderId))->find_one('assignOrders');
										break;
									case 3:
									$orderData = $this->mongo_db->where(array("franchiseId"=>$franchiseId,'orderId'=>(int)$orderId))->find_one('completedOrders');
										break;
								   
		}
		
		echo json_encode(array('data'=>$orderData));
		
	}

   
}

?>
