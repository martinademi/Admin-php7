<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");


class DriverRoasterAddModal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
		$this->load->library('CallAPI');
		$this->load->model("Home_m"); 
    }

    function datatableOrders($status = '', $stDate = '', $endDate = '') {
	
        $this->load->library('Datatables');
		$this->load->library('table');
		$cityId = $this->input->post('cityId');
		$zoneId = $this->input->post('zoneId');
		$shiftTimimgs = $this->input->post('shiftTimimgs');

	

        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "slno";	
      


		if($status!=9){
		

			if($cityId !='' && $zoneId =='' && $shiftTimimgs == ''){
				$respo = $this->datatables->datatable_mongodb('driver', array("status" => array('$nin' => [4,5]),'cityId'=>$cityId),'',-1);

			}else if($cityId !='' && $zoneId !='' && $shiftTimimgs == '' ){
				$respo = $this->datatables->datatable_mongodb('driver', array("status" => array('$nin' => [4,5]),'cityId'=>$cityId,'serviceZones'=>array('$in'=>[$zoneId])),'',-1);
				
			}else if($cityId !='' && $zoneId !='' && $shiftTimimgs != ''){
				// $respo = $this->datatables->datatable_mongodb('driver', array("status" => array('$nin' => [4,5]),'cityId'=>$cityId,'serviceZones'=>array('$in'=>[$zoneId]),''),'',-1);
				$respo = $this->datatables->datatable_mongodb('driver', array("status" => array('$nin' => [4,5]),'cityId'=>$cityId,'serviceZones'=>array('$in'=>[$zoneId])),'',-1);
				
			}

		}else{
			$respo =[];
		}
						 
		

        $aaData = $respo["aaData"];
        $datatosend = array();
        $slno = $_POST['iDisplayStart']+1;
        
        foreach ($aaData as $value) {
			
            $arr = array();           
				
			$arr[] = $slno++;	
			$arr[] = $value['firstName'].' '.$value['lastName'];
			$arr[] = $value['countryCode'].' '.$value['mobile'];
			$arr[] = $value['email'];
			$arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";
			$datatosend[] = $arr;
        }



        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
	}

	
	
	function updateShiftTimimgs(){

		$cityId = $this->input->post("cityId");
		$zoneId = $this->input->post("zoneId");
		$shiftTimimgsId = $this->input->post("shiftTimimgs");
		$driverId = $this->input->post("driverId");
		$shiftDetails=$this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($shiftTimimgsId)))->find_one('shiftTimingsZones');
		$shiftTimimgsId=$shiftDetails['_id']['$oid'];
		$shiftName=$shiftDetails['shiftName'];
		$startTime=$shiftDetails['startTime'];
		$endTime=$shiftDetails['endTime'];
		$status=$shiftDetails['status'];
		$time=time();
		$startDate=$this->input->post('startDate');
		$endDate=$this->input->post('endDate');

		// time stamp conversion start and end date
		$stDate = strtotime($startDate);
		$stDate = strtotime(date('d-m-Y', $stDate) . '00:00:00');
		$edDate = strtotime($endDate);
		$edDate = strtotime(date('d-m-Y', $edDate) . '23:59:59');

		
		$data=array('shiftId'=>$shiftTimimgsId,'shiftName'=>$shiftName,'startTime'=>$startTime,'endTime'=>$endTime,
					'createdOn'=>$time,'startDate'=>$startDate,'endDate'=>$endDate,'zoneId'=>$zoneId,'status'=>$status,
					'startDateTimeStamp'=>$stDate,'endDateTimeStamp'=>$edDate);
		foreach($driverId as $driver){			

			$shiftDetail = $this->mongo_db->aggregate('driver',[
                ['$match'=>["_id"=>new MongoDB\BSON\ObjectID($driver),'driverRoster.shiftId'=>$shiftTimimgsId]],
                ['$unwind'=>'$driverRoster'],
                ['$match'=>["_id"=>new MongoDB\BSON\ObjectID($driver),'driverRoster.shiftId'=>$shiftTimimgsId]],
                ['$project'=>['driverRoster'=>1]]
				]);
				
            foreach($shiftDetail as $cData){			   
			   $cData=$cData;               
            }	
		
			if(!$cData){	
				$driverUpdate = $this->mongo_db->where(array('_id'=>new MongoDB\BSON\ObjectID($driver),'cityId' => $cityId,'serviceZones'=>array('$in'=>[$zoneId]) ))->push(array('driverRoster'=>$data))->update('driver',array('multi'=>TRUE,'upsert'=>TRUE)); 		
			}else{				
				$driverUpdate = $this->mongo_db->where(array('_id'=>new MongoDB\BSON\ObjectID($driver),'driverRoster.shiftId'=>$shiftTimimgsId ))->set(array('driverRoster.$.startDate'=>$startDate,'driverRoster.$.endDate'=>$endDate,
								'driverRoster.$.startDateTimeStamp'=>$stDate,'driverRoster.$.endDateTimeStamp'=>$edDate))->update('driver'); 		
			}				

		}
		

		if($driverUpdate){
			echo json_encode(array('flag'=>1));
		}else{
			echo json_encode(array('flag'=>0));
		}	
		
	}
	
	 
	
	
	
	
	function orderDetails($param,$status,$storeType) {
		$this->load->library('mongo_db');
		
		

		
		
		// new
		switch($status){
			// done
			case 0:
			$data['res'] = $this->mongo_db->where(array('orderId' => (int) $param))->find_one('newOrder');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;
			
			// done
			case 1:
			$data['res'] = $this->mongo_db->where(array('orderId' => (int) $param))->find_one('unassignOrders');

			if(!$data['res']){
				$data1 = $this->mongo_db->where(array('orderId' => (int) $param))->find_one('pickupOrders');
				$data['res']=$data1;
			}	

			if(!$data['res']){
				$data2 = $this->mongo_db->where(array('orderId' => (int) $param))->find_one('assignOrders');
				$data['res']=$data2;
			}

			if($data['res']['storeId']!=0){
				$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
				foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
					$data['storeData']['category']=$dataStore;
			}

			
			}
			break;
			
			case 2:
			$data['res'] = $this->mongo_db->where(array('orderId' => (int) $param))->find_one('unassignOrders');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;
			
			// done
			case 3:
			$data['res'] = $this->mongo_db->where(array('orderId' => (int) $param))->find_one('assignOrders');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;

			// done
			case 4:
			$data['res'] = $this->mongo_db->where(array('orderId' => (int) $param))->find_one('pickupOrders');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;

			// done
			case 5:
			$data['res'] = $this->mongo_db->where(array('orderId' => (int) $param))->find_one('completedOrders');
			if($data['res']['storeId']!=0){
				$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
				foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
				$data['storeData']['category']=$dataStore;
				}
			}
			
			break;
			case 6:
			$data['res'] = $this->mongo_db->where(array('orderId' => (int) $param))->find_one('completedOrders');
			$data['storeData'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($data['res']['storeId'])))->select(array("ownerEmail"=>"ownerEmail","storeCategory"=>"storeCategory","name"=>"name","countryCode"=>"countryCode","businessNumber"=>"businessNumber"))->find_one('stores');
			foreach($data['storeData']['storeCategory'] as $storeCategoryData){
					$dataStore = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($storeCategoryData['categoryId'])))->find_one('storeCategory');
			$data['storeData']['category']=$dataStore;
			}
			break;

			
			
			
		}

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
		$role = $this->session->userdata("role");
			if($role!="ArialPartner"){
				$data = $this->mongo_db->where(array("status"=>1))->get('stores');
				// echo '<pre>';print_r($data);die;
			}else{
				$data = $this->mongo_db->where(array('cityId'=>(string)$this->session->userdata("cityId"),"status"=>1))->get('stores');
			}
//print_r($data);die;
        echo json_encode(array('data'=>$data));
    }
	
	function ordersData(){
		$orderId = $this->input->post('orderId');
		$status = $this->input->post('status');
	
		switch($status){
									case 0:
									$orderData = $this->mongo_db->where(array('orderId'=>(int)$orderId))->find_one('newOrder');
										break;
									case 1:
									$orderData = $this->mongo_db->where(array('orderId'=>(int)$orderId))->find_one('unassignOrders');
										break;
									case 2:
									$orderData = $this->mongo_db->where(array('orderId'=>(int)$orderId))->find_one('assignOrders');
										break;
									case 3:
									$orderData = $this->mongo_db->where(array('orderId'=>(int)$orderId))->find_one('completedOrders');
										break;
								   
		}
		
		echo json_encode(array('data'=>$orderData));
		
	}

	function ordersFilter(){
		$cityFilter=$this->input->post('city');
		$storeFilter=$this->input->post('storeName');
		
		$_SESSION['cityFilter']=$cityFilter;
		$_SESSION['storeFilter']=$storeFilter;		

	}
	
	//     zone dynamicalyy
	   public function getZone(){

		$this->load->library('mongo_db');
		$cityId = $this->input->post('cityId');
		

		if($cityId!='' || $cityId!=null){

		$data=$this->mongo_db->where(array('city_ID'=> $cityId))->select(array('title'=>'title'))->get('zones');
		

		 $entities = array();
		$entities = '<select class="form-control error-box-class"  id="zoneFilter" name="zoneFilter">
				 <option selected="selected" value="">Select Zone </option>';
	   
		foreach( $data as $zone){ 
			
			$entities .= '<option value="' . $zone['_id']['$oid'] . '" data-name="'.$zone['title'].'" catName="'.$zone['title'].'" >' . $zone['title'] . '</option>';

		   }
			
		
		$entities .= '</select>';
		echo $entities;

		}
		else{
			
			$entities = array();
			$entities = '<select class="form-control error-box-class"  id="zoneFilter" name="zoneFilter">
					 <option value="">Select Zone </option>';
					 $entities .= '</select>';
					 echo $entities;

		}
		//return $data;

	}

	// //category
    // public function getShiftTimings(){

	// 	$this->load->library('mongo_db');	
	// 	$zoneId=$this->input->post('zoneId');
	// 	$data=$this->mongo_db->where(array('status'=>1,'zoneId'=>$zoneId))->get('shiftTimings');
	   
	// 	return $data;
 
	//  }


	 //     zone dynamicalyy
	 public function getShiftTimings(){

		$this->load->library('mongo_db');
		$zoneId=$this->input->post('zoneId');
		

		if($zoneId!='' || $zoneId!=null){

		$data=$this->mongo_db->where(array('status'=>1,'zoneId'=>$zoneId))->get('shiftTimingsZones');
		

		 $entities = array();
		$entities = '<select class="form-control error-box-class"  id="shiftTimings" name="zoneFilter">
				 <option selected="selected" value="">Select Shifts </option>';
	   
		foreach( $data as $shift){ 
			
			$entities .= '<option value="' . $shift['_id']['$oid'] . '" data-name="'.$shift['shiftName'].'" catName="'.$shift['shiftName'].'" >' . $shift['shiftName'] . '</option>';

		   }
			
		
		$entities .= '</select>';
		echo $entities;

		}
		else{
			
			$entities = array();
			$entities = '<select class="form-control error-box-class"  id="shiftTimings" name="shiftTimings">
					 <option value="">Select Shifts </option>';
					 $entities .= '</select>';
					 echo $entities;

		}
		//return $data;

	}

   
}

?>
