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
		$storeId = $this->session->userdata('badmin')['BizId'];
		$_POST['iColumns'] = 7;
		$timeOffset = $this->session->userdata('badmin')['timeOffset'];
	
		
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
								case 0:$respo = $this->datatables->datatable_mongodb('newOrder', array("storeId"=>$storeId,"bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate),'',-1);
									break;
								case 1:$respo = $this->datatables->datatable_mongodb('unassignOrders', array("storeId"=>$storeId,"bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate),'',-1);
									break;
								case 2:$respo = $this->datatables->datatable_mongodb('assignOrders', array("storeId"=>$storeId,"bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate), '',-1);
									break;
								case 3:$respo = $this->datatables->datatable_mongodb('completedOrders', array("storeId"=>$storeId,"bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate),'',-1);
									break;
							   
							}
						
					}else if($stDate == 0 || $stDate == 0){
						switch ($status) {
									case 0:$respo = $this->datatables->datatable_mongodb('newOrder', array("storeId"=>$storeId,),'',-1);
										break;
									case 1:$respo = $this->datatables->datatable_mongodb('unassignOrders', array("storeId"=>$storeId,),'',-1);
										break;
									case 2:$respo = $this->datatables->datatable_mongodb('assignOrders', array("storeId"=>$storeId,), '',-1);
										break;
									case 3:$respo = $this->datatables->datatable_mongodb('completedOrders', array("storeId"=>$storeId,),'',-1);
										break;
								   
								}
						
					}else{
	 
						  switch ($status) {
								case 0:$respo = $this->datatables->datatable_mongodb('newOrder', array("storeId"=>$storeId,'timeStamp.created.isoDate' => array('$gte' => $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
									break;
								case 1:$respo = $this->datatables->datatable_mongodb('unassignOrders', array("storeId"=>$storeId,'timeStamp.created.isoDate' => array('$gte' => $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
									break;
								case 2:$respo = $this->datatables->datatable_mongodb('assignOrders', array("storeId"=>$storeId,'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))), '',-1);
									break;
								case 3:$respo = $this->datatables->datatable_mongodb('completedOrders', array("storeId"=>$storeId,'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
									break;
							   
							}
					}
	 
						 }else{
								
						
							// echo $storeId;die;
								switch ($status) {
									case 0:$respo = $this->datatables->datatable_mongodb('newOrder', array("storeId"=>$storeId,'status'=>1),'',-1);
										break;
									case 1:
										    $respo1 = $this->datatables->datatable_mongodb('unassignOrders', array("storeId"=>$storeId,'visiableInAccept'=>true,'status'=>array('$in'=>[4,40])),'',-1);
											$respo2 = $this->datatables->datatable_mongodb('pickupOrders', array("storeId"=>$storeId,'status'=>array('$in'=>[4])),'',-1);
											$respo3 = $this->datatables->datatable_mongodb('assignOrders', array("storeId"=>$storeId,'status'=>array('$in'=>[8,10,11])),'',-1);
											$respo['sEcho']= $respo1['sEcho']  + $respo2['sEcho'] +  $respo3['sEcho'];
											$respo['iTotalRecords']= $respo1['iTotalRecords']  + $respo2['iTotalRecords'] +  $respo3['iTotalRecords'];
											$respo['iTotalDisplayRecords']= $respo1['iTotalDisplayRecords']  + $respo2['iTotalDisplayRecords'] +  $respo3['iTotalDisplayRecords'];
											$respo['aaData']=array_merge($respo1['aaData'],$respo2['aaData'],$respo3['aaData']);
											// print_r($respo);die;
										   break;
									case 2:$respo = $this->datatables->datatable_mongodb('unassignOrders', array("storeId"=>$storeId,'status'=>array('$in'=>[40])), '',-1);
										break;
									case 3:$respo = $this->datatables->datatable_mongodb('assignOrders', array("storeId"=>$storeId,'status'=>array('$in'=>[12,13,14])),'',-1);
										break;
									case 4:$respo = $this->datatables->datatable_mongodb('pickupOrders', array("storeId"=>$storeId,'status'=>array('$in'=>[5,6])),'',-1);
										break;
									case 5:$respo = $this->datatables->datatable_mongodb('completedOrders', array("storeId"=>$storeId),'',-1);
										break;								
								   
								}
						 }
		
		

		$aaData = $respo["aaData"];
		// print_r($aaData);die;
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
			$arr[] =date('d-M-Y h:i:s a ', ($value['bookingDateTimeStamp']) - ($this->session->userdata('badmin')['timeOffset'] * 60));
			$arr[] =date('d-M-Y h:i:s a ', ($value['dueDatetimeTimeStamp']) - ($this->session->userdata('badmin')['timeOffset'] * 60));
			// $arr[] = $value['bookingDate'];
			// $arr[] = $value['dueDatetime'];
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
			$arr[] = '<button style="width:71px !important;" class="btn btn-primary btnWidth orderAction"  value=' . $value['orderId'] . '><i class="glyphicon glyphicon-list-alt"></i></button>' ;
            $datatosend[] = $arr;
        }



        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
	
	// cool
	 function getOrdersCount() {
		 $storeId = $this->session->userdata('badmin')['BizId'];
		$this->load->library('mongo_db');
		
		$data['New'] = $this->mongo_db->where(array("storeId"=>$storeId))->count('newOrder');
		$data['Assigned'] = $this->mongo_db->where(array("storeId"=>$storeId,'status'=>array('$in'=>[40])))->count('assignOrders');
		$data['orderPicked'] = $this->mongo_db->where(array("storeId"=>$storeId,'status'=>array('$in'=>[12,13,14])))->count('assignOrders');
		$data['pickupReady'] = $this->mongo_db->where(array("storeId"=>$storeId,'status'=>array('$in'=>[5,6])))->count('pickupOrders');
		$data['Completed'] = $this->mongo_db->where(array("storeId"=>$storeId))->count('completedOrders');

		// // changes
		// $data['Unassigned'] = $this->mongo_db->where(array("storeId"=>$storeId,'status'=>array('$in'=>[8,10,11])))->count('assignOrders');

		// if(!$data['Unassigned']){
		// 	$data1 = $this->mongo_db->where(array("storeId"=>$storeId,'status'=>array('$in'=>[4])))->find_one('pickupOrders');
		// 	$data['Unassigned']=$data1;
		// }	

		// if(!$data['Unassigned']){
		// 	$data2 = $this->mongo_db->where(array("storeId"=>$storeId,'visiableInAccept'=>true,'status'=>array('$in'=>[4,40])))->find_one('unassignOrders');
		// 	$data['Unassigned']=$data2;
		// }

		// // implemented new
		// if(!$data2){
		// 	$data['Unassigned']=0;
		// }

		$respo1 = $this->mongo_db->where(array("storeId"=>$storeId,'status'=>array('$in'=>[4,40,20])))->count('unassignOrders');
		$respo2 = $this->mongo_db->where(array("storeId"=>$storeId,'status'=>array('$in'=>[4])))->count('pickupOrders');
		$respo3 = $this->mongo_db->where(array("storeId"=>$storeId,'status'=>array('$in'=>[8,10,11])))->count('assignOrders');	
		$data['Unassigned']= $respo1+$respo2+$respo3;	
		
	

    echo json_encode(array('data' => $data));
        
    }
	
	function acceptOrder(){
		 // $this->load->library('mongo_db');
		 $this->load->library('CallAPI');
		$val = $this->input->post('val');
		$status = $this->input->post('status');
		$headerData['authorization'] =$this->session->userdata('badmin')['apiToken']; 
		$bodyData['status'] =$status;
		$bodyData['timestamp'] = time();
		$bodyData['orderId'] = (int)$val;
		$bodyData['reason'] = "action by Atore Admin";
		$url = APILink .'franchise/order/status';        
		$response = json_decode($this->callapi->CallAPI('PATCH', $url, $bodyData,$headerData), true); 
		if($response['statusCode'] == 200){
			echo json_encode(array("statusCode"=>200));
		}
		else{
			echo json_encode(array("statusCode"=>500));
		}
	
	}
	
	// pass1
	function orderDetails($param,$status) {
		$storeId = $this->session->userdata('badmin')['BizId'];
		$this->load->library('mongo_db');
		
		// switch($status){
		// 	case 0:
		// 	$data['res'] = $this->mongo_db->where(array("storeId"=>$storeId,'orderId' => (int) $param))->find_one('newOrder');
		// 	$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
		// 	foreach($data['storeData']['storeCategory'] as $storeCategoryData){
		// 			$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
		// 	$data['storeData']['category']=$dataStore;
		// 	}
		// 	break;
			
		// 	case 1:
		// 	$data['res'] = $this->mongo_db->where(array("storeId"=>$storeId,'orderId' => (int) $param))->find_one('unassignOrders');
		// 	$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
		// 	foreach($data['storeData']['storeCategory'] as $storeCategoryData){
		// 			$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
		// 	$data['storeData']['category']=$dataStore;
		// 	}
		// 	break;
			
		// 	case 2:
		// 	$data['res'] = $this->mongo_db->where(array("storeId"=>$storeId,'orderId' => (int) $param))->find_one('assignOrders');
		// 	$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
		// 	foreach($data['storeData']['storeCategory'] as $storeCategoryData){
		// 			$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
		// 	$data['storeData']['category']=$dataStore;
		// 	}
		// 	break;
			
		// 	case 3:
		// 	$data['res'] = $this->mongo_db->where(array("storeId"=>$storeId,'orderId' => (int) $param))->find_one('completedOrders');
		// 	$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
		// 	foreach($data['storeData']['storeCategory'] as $storeCategoryData){
		// 			$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
		// 	$data['storeData']['category']=$dataStore;
		// 	}
		// 	break;
			
			
		// }

		// new data
		switch($status){
			// done
			case 0:
			$data['res'] = $this->mongo_db->where(array("storeId"=>$storeId,'orderId' => (int) $param))->find_one('newOrder');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;
			
			// done
			case 1:
			$data['res'] = $this->mongo_db->where(array("storeId"=>$storeId,'orderId' => (int) $param))->find_one('unassignOrders');

			if(!$data['res']){
				$data1 = $this->mongo_db->where(array("storeId"=>$storeId,'orderId' => (int) $param))->find_one('pickupOrders');
				$data['res']=$data1;
			}	

			if(!$data['res']){
				$data2 = $this->mongo_db->where(array("storeId"=>$storeId,'orderId' => (int) $param))->find_one('assignOrders');
				$data['res']=$data2;
			}

			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;
			
			case 2:
			$data['res'] = $this->mongo_db->where(array("storeId"=>$storeId,'orderId' => (int) $param))->find_one('unassignOrders');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;
			
			// done
			case 3:
			$data['res'] = $this->mongo_db->where(array("storeId"=>$storeId,'orderId' => (int) $param))->find_one('assignOrders');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;

			// done
			case 4:
			$data['res'] = $this->mongo_db->where(array("storeId"=>$storeId,'orderId' => (int) $param))->find_one('pickupOrders');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;

			// done
			case 5:
			$data['res'] = $this->mongo_db->where(array("storeId"=>$storeId,'orderId' => (int) $param))->find_one('completedOrders');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;

			
			
			
		}
        
		

        return $data;
    }
	function orderDetailsForDriverLocations($param){
			$storeId = $this->session->userdata('badmin')['BizId'];
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
	$storeId = $this->session->userdata('badmin')['BizId'];
		switch($status){
									case 0:
									$orderData = $this->mongo_db->where(array("storeId"=>$storeId,'orderId'=>(int)$orderId))->find_one('newOrder');
										break;
									case 1:
									$orderData = $this->mongo_db->where(array("storeId"=>$storeId,'orderId'=>(int)$orderId))->find_one('unassignOrders');
										break;
									case 2:
									$orderData = $this->mongo_db->where(array("storeId"=>$storeId,'orderId'=>(int)$orderId))->find_one('assignOrders');
										break;
									case 3:
									$orderData = $this->mongo_db->where(array("storeId"=>$storeId,'orderId'=>(int)$orderId))->find_one('completedOrders');
										break;
								   
		}
		
		echo json_encode(array('data'=>$orderData));
		
	}

   
}

?>
