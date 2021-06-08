<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");


class OrdersModel extends CI_Model {

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
		$orderCategoryStaus=$this->input->post('orderCategoryStaus');
		
		$_POST['iColumns'] = 8;
        $_POST['mDataProp_0'] = "slno";	
        $_POST['mDataProp_1'] = "orderId";
        $_POST['mDataProp_2'] = "email";
        $_POST['mDataProp_3'] = "customerDetails.name";
        $_POST['mDataProp_4'] = "customerDetails.mobile";
        $_POST['mDataProp_5'] = "pickup.city"; 
		$_POST['mDataProp_6'] = "storeName";
		$_POST['mDataProp_7'] = "storeTypeMsg";


				if ($stDate != '' && $endDate != ''){
								
								if($stDate == 1 || $stDate == 2){
									switch ($status) {
											case 0:
												$respo = $this->datatables->datatable_mongodb('newOrder', array("bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate),'',-1);
												break;
											case 1:
												$respo = $this->datatables->datatable_mongodb('unassignOrders', array("bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate),'',-1);
												break;
											case 2:
												$respo = $this->datatables->datatable_mongodb('assignOrders', array("bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate), '',-1);
												break;
											case 3:
												$respo = $this->datatables->datatable_mongodb('completedOrders', array("status"=>array('$in' => [7,15]),"bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate),'',-1);
												break;
											case 4:
												$respo = $this->datatables->datatable_mongodb('completedOrders', array("status" => array('$in' => [2,3,16]),"bookingType"=>(int)$stDate,"serviceType"=>(int)$endDate),'',-1);
												break;
										
										}
									
								}else if($stDate == 0 || $stDate == 0){
								
									switch ($status) {
												case 0:$respo = $this->datatables->datatable_mongodb('newOrder', array(),'',-1);
													break;
												case 1:$respo = $this->datatables->datatable_mongodb('unassignOrders', array(),'',-1);
													break;
												case 2:$respo = $this->datatables->datatable_mongodb('assignOrders', array(), '',-1);
													break;
												case 3:$respo = $this->datatables->datatable_mongodb('completedOrders', array("status"=>array('$in' => [7,15])),'',-1);
												break;
													case 4:$respo = $this->datatables->datatable_mongodb('completedOrders', array("status" => array('$in' => [2,3,16])),'',-1);
												break;
											
											}
									
								}else{						
								
									switch ($status) {
											case 0:$respo = $this->datatables->datatable_mongodb('newOrder', array("status"=>1,'timeStamp.created.isoDate' => array('$gte' => $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
												break;
											case 1:
												$respo1 = $this->datatables->datatable_mongodb('unassignOrders', array("status"=>array('$in' => [4,40]),'timeStamp.created.isoDate' => array('$gte' => $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
												$respo2 = $this->datatables->datatable_mongodb('pickupOrders', array("status"=>array('$in' => [4]),'timeStamp.created.isoDate' => array('$gte' => $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
												$respo3 = $this->datatables->datatable_mongodb('assignOrders', array("status"=>array('$in' => [8,10,11]),'timeStamp.created.isoDate' => array('$gte' => $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
												$respo['sEcho']= $respo1['sEcho']  + $respo2['sEcho'] +  $respo3['sEcho'];
												$respo['iTotalRecords']= $respo1['iTotalRecords']  + $respo2['iTotalRecords'] +  $respo3['iTotalRecords'];
												$respo['iTotalDisplayRecords']= $respo1['iTotalDisplayRecords']  + $respo2['iTotalDisplayRecords'] +  $respo3['iTotalDisplayRecords'];
												$respo['aaData']=array_merge($respo1['aaData'],$respo2['aaData'],$respo3['aaData']);
												break;
											case 2:$respo = $this->datatables->datatable_mongodb('unassignOrders', array("status"=>array('$in' => [40]),'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))), '',-1);
												break;
											case 3:$respo = $this->datatables->datatable_mongodb('assignOrders', array("status"=>array('$in' => [12,13,14]),'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
												break;
											case 4:$respo = $this->datatables->datatable_mongodb('pickupOrders', array("status" => array('$in' => [5,6]),'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
												break;
											case 5:$respo = $this->datatables->datatable_mongodb('completedOrders', array("status" => array('$in' => [7,15]),'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
												break;
											case 6:$respo = $this->datatables->datatable_mongodb('completedOrders', array("status" => array('$in' => [2,3,16]),'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))),'',-1);
												break;
										
										}			
								}
	 
				}else{
					

					// switch ($status) {
					// 		case 0:$respo = $this->datatables->datatable_mongodb('newOrder', array('status'=>1),'',-1);
					// 			break;
					// 		case 1:
					// 				$respo1 = $this->datatables->datatable_mongodb('unassignOrders', array('visiableInAccept'=>true,'status'=>array('$in'=>[4,40])),'',-1);
					// 				$respo2 = $this->datatables->datatable_mongodb('pickupOrders', array('status'=>array('$in'=>[4])),'',-1);
					// 				$respo3 = $this->datatables->datatable_mongodb('assignOrders', array('status'=>array('$in'=>[8,10,11])),'',-1);
					// 				$respo['sEcho']= $respo1['sEcho']  + $respo2['sEcho'] +  $respo3['sEcho'];
					// 				$respo['iTotalRecords']= $respo1['iTotalRecords']  + $respo2['iTotalRecords'] +  $respo3['iTotalRecords'];
					// 				$respo['iTotalDisplayRecords']= $respo1['iTotalDisplayRecords']  + $respo2['iTotalDisplayRecords'] +  $respo3['iTotalDisplayRecords'];
					// 				$respo['aaData']=array_merge($respo1['aaData'],$respo2['aaData'],$respo3['aaData']);
					// 				break;
					// 		case 2:$respo = $this->datatables->datatable_mongodb('unassignOrders', array('status'=>array('$in'=>[40])), '',-1);
					// 			break;
					// 		case 3:$respo = $this->datatables->datatable_mongodb('assignOrders', array('status'=>array('$in'=>[12,13,14])),'',-1);
					// 			break;
					// 		case 4:$respo = $this->datatables->datatable_mongodb('pickupOrders', array('status'=>array('$in'=>[5,6])),'',-1);
					// 			break;
					// 		case 5:$respo = $this->datatables->datatable_mongodb('completedOrders', array("status" => array('$in' => [7,15])),'',-1);
					// 			break;	
					// 		case 6:$respo = $this->datatables->datatable_mongodb('completedOrders', array("status" => array('$in' => [2,3,16])),'',-1);
					// 			break;					
							
					// 	}

					if($orderCategoryStaus!=111){
							$storeType=(int)$orderCategoryStaus;	
							$condition=array('storeType'=>$storeType);							
						}else{
							$condition=array('storeType'=>array('$in'=>[1,2,3,4,5,6,7]));								
						}

						
						
						switch ($status) {
								case 0:$respo = $this->datatables->datatable_mongodb('newOrder', array_merge(array('status'=>1),$condition),'',-1);							
									break;
								case 1:
										$respo1 = $this->datatables->datatable_mongodb('unassignOrders', array_merge(array('visiableInAccept'=>true,'status'=>array('$in'=>[4,40])),$condition) ,'',-1);
										$respo2 = $this->datatables->datatable_mongodb('pickupOrders', array_merge(array('status'=>array('$in'=>[4])),$condition) ,'',-1);
										$respo3 = $this->datatables->datatable_mongodb('assignOrders', array_merge(array('status'=>array('$in'=>[8,10,11])),$condition) ,'',-1);
										$respo['sEcho']= $respo1['sEcho']  + $respo2['sEcho'] +  $respo3['sEcho'];
										$respo['iTotalRecords']= $respo1['iTotalRecords']  + $respo2['iTotalRecords'] +  $respo3['iTotalRecords'];
										$respo['iTotalDisplayRecords']= $respo1['iTotalDisplayRecords']  + $respo2['iTotalDisplayRecords'] +  $respo3['iTotalDisplayRecords'];
										$respo['aaData']=array_merge($respo1['aaData'],$respo2['aaData'],$respo3['aaData']);
										break;
								case 2:$respo = $this->datatables->datatable_mongodb('unassignOrders', array_merge(array('status'=>array('$in'=>[40])),$condition) , '',-1);
									break;
								case 3:$respo = $this->datatables->datatable_mongodb('assignOrders', array_merge(array('status'=>array('$in'=>[12,13,14])),$condition) ,'',-1);
									break;
								case 4:$respo = $this->datatables->datatable_mongodb('pickupOrders', array_merge(array('status'=>array('$in'=>[5,6])),$condition) ,'',-1);
									break;
								case 5:$respo = $this->datatables->datatable_mongodb('completedOrders', array_merge(array("status" => array('$in' => [7,15])),$condition) ,'',-1);
									break;	
								case 6:$respo = $this->datatables->datatable_mongodb('completedOrders', array_merge(array("status" => array('$in' => [2,3,16])),$condition),'',-1);
									break;					
								
							}
							
				}
		
		

        $aaData = $respo["aaData"];
        $datatosend = array();
        $slno = $_POST['iDisplayStart']+1;
        
        foreach ($aaData as $value) {
			// echo '<pre>';print_r($value);die;
            $arr = array();
            switch($value['paymentType']){
				case 1: $paymentType = "Card";
					break;
					case 2: $paymentType = "Cash";
					break;
					case 3: $paymentType = "Wallet";
					break;
					case 4: $paymentType = "Coin Payment";
					break;
			}
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

			// store type

			if(!array_key_exists('storeType',$value)){
                $storeType="N/A";
            }else{
                switch($value['storeType']){

                    case 1:
                        $storeType="Food";
                        break;
                    case 2:
                        $storeType="Grocery";
                        break;
                    case 3:
                        $storeType="Fashion";
                        break;
                    case 4:
                        $storeType="Send Package";
                        break;
                    case 5:
                        $storeType="Laundry";
                        break;
                    case 6:
                        $storeType="Pharmacy";
                        break;
                    case 7:
                        $storeType="Order Anything";
                        break;
                }

            }

			
		
			
		if($status==3){
			$path='<a style="cursor:pointer;" href="'. $value['invoiceUrl'].'" target="_blank" class="orderDetailsPdfData"   >Invoice PDF</a>';
			$pdfLink=($value['invoiceUrl'] != "" || $value['invoiceUrl'] != null) ? $path : 'N/A';
		
		}else{
			$path='<a style="cursor:pointer;" href="'. $value['invoicePdfUrl'].'" target="_blank" class="orderDetailsPdfData"   >Invoice PDF</a>';
			$pdfLink=($value['invoicePdfUrl'] != "" || $value['invoicePdfUrl'] != null) ? $path: 'N/A';
		}
		    $mobile=$value['customerDetails']['countryCode'].$value['customerDetails']['mobile'];
		
			//********** */ old data**************
            // $arr[] = $slno++;
			// $arr[] = '<a style="cursor:pointer;" class="orderDetails" value="'.$value['orderId'].'" orderId="'.$value['orderId'].'" storeType="'.$value['storeType'].'">' . $value['orderId'] . '</a>';
			// $arr[] = $value['pickup']['city'] ;
			// $arr[] = $value['customerDetails']['name'] ;
			// $arr[] = $this->Home_m->maskFileds($mobile, 2);
			// $arr[] = $value['storeName'] ;
			// $arr[] = ($value['driverDetails']['fName'] == "" || $value['driverDetails']['fName'] == null)?"N/A":$value['driverDetails']['fName'] ;
			// $arr[] = $bookingType;
			// $arr[] = $storeType;
			// $arr[] =date('d-M-Y h:i:s a ', ($value['bookingDateTimeStamp']) - ($this->session->userdata('timeOffset') * 60));
			// $arr[] =date('d-M-Y h:i:s a ', ($value['dueDatetimeTimeStamp']) - ($this->session->userdata('timeOffset') * 60));
			// $arr[] = ($value['drop']['addressLine1'] == "" && $value['drop']['addressLine1']== null)?"N/A":$value['drop']['addressLine1'].$value['drop']['addressLine2'] ;
			// $arr[] = $paymentType ;
			// if($value['abbrevation'] == "1"){
			// $arr[] ='<a class="getBreakDownDetails" orderId="'.$value['orderId'].'"  value="'.$value['orderId'].'" style="cursor:pointer;" >'.$value["currencySymbol"].number_format($value['subTotalAmount'] , 2, '.', '').'</a>';
			// }else{
			// $arr[] ='<a class="getBreakDownDetails" orderId="'.$value['orderId'].'"  value="'.$value['orderId'].'" style="cursor:pointer;" >'.number_format($value['subTotalAmount'] , 2, '.', '').$value['currencySymbol'].'</a>';	
			// }
			// if($value['abbrevation'] == "1"){
			// 	if($value['storeType']!=5){
			// 		$arr[] =$value['currencySymbol'].number_format($value['deliveryCharge'], 2, '.', '');
			// 	}else{
			// 		$arr[] ="Pickup : ".$value['currencySymbol'].number_format($value['deliveryCharge'], 2, '.', '')."<br/>"."Drop : ".$value['currencySymbol'].number_format($value['deliveryCharge'], 2, '.', '');
			// 	}				
			// }else{
			// 	if($value['storeType']!=5){
			// 		$arr[] =number_format($value['deliveryCharge'], 2, '.', '').$value['currencySymbol'];
			// 	}else{
			// 		$arr[] ="Pickup : ".number_format($value['deliveryCharge'], 2, '.', '').$value['currencySymbol']."<br/>"."Drop : ".number_format($value['deliveryCharge'], 2, '.', '').$value['currencySymbol'];
			// 	}
			// }
			// $arr[] = ($value['timeStamp']['accepted']['timeStamp'] == "" || $value['timeStamp']['accepted']['timeStamp'] == null)?"N/A":date('d-M-Y h:i:s a ', ($value['timeStamp']['accepted']['timeStamp']) - ($this->session->userdata('timeOffset') * 60));;
			// $arr[] = ($value['timeStamp']['accepted']['stausUpdatedBy'] == "" || $value['timeStamp']['accepted']['stausUpdatedBy'] == null)?"N/A":$dispatchedName;
			// $arr[] = '<button style="width:35px !important;" class="btn btn-primary btnWidth manageOrder"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-asterisk"></i></i></button>' ;
			// $arr[] = $value['statusMsg'] ;
			// $arr[] = '<button style="width:35px !important;" class="btn btn-primary btnWidth orderAction"  value=' . $value['orderId'] . '><i class="glyphicon glyphicon-refresh"></i></button>' ;
			// $arr[]=	  $pdfLink;
			// $datatosend[] = $arr;
			
			// new changes
			$arr[] = $slno++;
			$arr[] = '<a style="cursor:pointer;" class="orderDetails" value="'.$value['orderId'].'" orderId="'.$value['orderId'].'" storeType="'.$value['storeType'].'">' . $value['orderId'] . '</a>';
			$arr[] = $value['pickup']['city'] ;
			$arr[] = $storeType;
			$arr[] = $value['statusMsg'] ;
			$arr[] = $bookingType;
			$arr[] = 'N/A';
			$arr[] = $value['customerDetails']['name'] ;
			$arr[] = $value['storeName'] ;
			$arr[] = ($value['driverDetails']['fName'] == "" || $value['driverDetails']['fName'] == null)?"N/A":$value['driverDetails']['fName'] ;
			$arr[] =date('d-M-Y h:i:s a ', ($value['bookingDateTimeStamp']) - ($this->session->userdata('timeOffset') * 60));
			$arr[] = 'N/A';
			$arr[] = $paymentType ;

			if($value['abbrevation'] == "1"){
				$arr[] ='<a class="getBreakDownDetails" orderId="'.$value['orderId'].'"  value="'.$value['orderId'].'" style="cursor:pointer;" >'.$value["currencySymbol"].number_format($value['subTotalAmount'] , 2, '.', '').'</a>';
				}else{
				$arr[] ='<a class="getBreakDownDetails" orderId="'.$value['orderId'].'"  value="'.$value['orderId'].'" style="cursor:pointer;" >'.number_format($value['subTotalAmount'] , 2, '.', '').$value['currencySymbol'].'</a>';	
			}
			
			if($value['abbrevation'] == "1"){
				if($value['storeType']!=5){
						$arr[] =$value['currencySymbol'].number_format($value['deliveryCharge'], 2, '.', '');
					}else{
						$arr[] ="Pickup : ".$value['currencySymbol'].number_format($value['deliveryCharge'], 2, '.', '')."<br/>"."Drop : ".$value['currencySymbol'].number_format($value['deliveryCharge'], 2, '.', '');
					}				
				}else{
					if($value['storeType']!=5){
						$arr[] =number_format($value['deliveryCharge'], 2, '.', '').$value['currencySymbol'];
					}else{
						$arr[] ="Pickup : ".number_format($value['deliveryCharge'], 2, '.', '').$value['currencySymbol']."<br/>"."Drop : ".number_format($value['deliveryCharge'], 2, '.', '').$value['currencySymbol'];
					}
			}

			$datatosend[] = $arr;
        }



        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
	
	 function getOrdersCount() {
		$this->load->library('mongo_db');
		$data['New'] = $this->mongo_db->count('newOrder');
		$data['Assigned'] = $this->mongo_db->where(array('status'=>array('$in'=>[40])))->count('assignOrders');
		$data['orderPicked'] = $this->mongo_db->where(array('status'=>array('$in'=>[12,13,14])))->count('assignOrders');
		$data['pickupReady'] = $this->mongo_db->where(array('status'=>array('$in'=>[5,6])))->count('pickupOrders');
		$data['Completed'] = $this->mongo_db->where(array('status'=>array('$in'=>[7,15])))->count('completedOrders');
		$data['Cancelled'] = $this->mongo_db->where(array('status'=>array('$in'=>[2,3,16])))->count('completedOrders');
		$data['Unassigned'] = $this->mongo_db->where(array('status'=>array('$in'=>[8,10,11])))->count('assignOrders');
       echo json_encode(array('data' => $data));
        
    }
	
	function acceptOrder(){
		
        $this->load->library('CallAPI');
		$val = $this->input->post('val');
		$status = $this->input->post('status');
		$headerData['authorization'] =$this->session->userdata('godsviewToken'); 
		$bodyData['status'] =$status;
		$bodyData['timestamp'] = time();
		$bodyData['orderId'] = (int)$val;
		$bodyData['reason'] = "action by Superadmin Admin";
		$url = APILink .'franchise/order/status';        
	
		$response = json_decode($this->callapi->CallAPI('PATCH', $url, $bodyData,$headerData), true); 

		echo json_encode(array("response"=>$response));

		
		
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
	function orderDetailsForDriverLocations($param){
		
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
		//$role = $this->session->userdata("role");
		
		$role =$this->input->post('role');
		$city =$this->input->post('city');
	
	 	if($role!="ArialPartner"){
		   $data = $this->mongo_db->where(array("status"=>1))->get('stores');
		}else{
		 
		  	$data = $this->mongo_db->where(array('cityId'=>$city,"status"=>1))->get('stores');
		    $entities = array();
            $entities = '<select class="form-control error-box-class" style="width: 145px;"  id="storeFilter" name="storeFilter">
                         <option selected="selected" value="">Select Store</option>';
           
            foreach( $data as $store){ 
                
                $entities .= '<option value="' . $store['_id']['$oid'] . '" storeName="'.$store['name']['0'].'"  >' . $store['name']['0'] . '</option>';			
				
               }
                
            
			$entities .= '</select>';
			echo $entities;        
			
		}
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
	
	//export data
	   function exportAccData($status = '',$stDate = '', $endDate = '') {
		 
		$this->load->library('mongo_db');
		$datatosend = array();
	
		
	if ($stDate != '' && $endDate != ''){
			
		 			  switch ($status) {								
									case 0:								
								$respo = $this->mongo_db->where(array("status"=>1,'timeStamp.created.isoDate' => array('$gte' => $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))))->get('newOrder');								
										break;								
									case 1:
										$respo1 = $this->mongo_db->where(array("status"=>array('$in' => [4,40]),'timeStamp.created.isoDate' => array('$gte' => $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))))->get('unassignOrders');
										$respo2= $this->mongo_db->where(array("status"=>array('$in' => [4]),'timeStamp.created.isoDate' => array('$gte' => $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))))->get('pickupOrders');
										$respo3 = $this->mongo_db->where(array("status"=>array('$in' => [8,10,11]),'timeStamp.created.isoDate' => array('$gte' => $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))))->get('assignOrders');
										$respo=array_merge($respo1,$respo2,$respo3);
										break;								
									case 2:$respo = $this->mongo_db->where(array("status"=>array('$in' => [40]),'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))))->get('assignOrders');
										break;								
									case 3:$respo = $this->mongo_db->where(array("status"=>array("status"=>array('$in' => [12,13,14]),'$in' => [7,15]),'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))))->get('completedOrders');
										break;								
									case 4:$respo = $this->mongo_db->where(array("status" => array('$in' => [5,6]),'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))))->get('completedOrders');
										break;
									case 5:$respo = $this->mongo_db->where(array("status" => array('$in' => [7,15]),'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))))->get('completedOrders');
										break;
									case 6:$respo = $this->mongo_db->where(array("status" => array('$in' => [2,3,16]),'timeStamp.created.isoDate' => array('$gte' =>  $this->mongo_db->date(strtotime($stDate . '00:00:00') * 1000), '$lte' =>  $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000))))->get('completedOrders');
										break;
																	   
								}

							 }else{

									switch ($status) {
										case 0:$respo = $this->mongo_db->where(array("status"=>1))->get('newOrder');
											break;
										case 1:
												$respo1 = $this->mongo_db->where(array('visiableInAccept'=>true,'status'=>array('$in'=>[4,40])))->get('unassignOrders');
												$respo2 = $this->mongo_db->where(array('status'=>array('$in'=>[4])))->get('pickupOrders');
												$respo3 = $this->mongo_db->where(array( 'status'=>array('$in'=>[8,10,11]) ))->get('assignOrders');
												$respo=array_merge($respo1,$respo2,$respo3);
											 break;
										case 2:$respo = $this->mongo_db->where(array('status'=>array('$in'=>[40])))->get('unassignOrders');
											break;
										case 3:$respo = $this->mongo_db->where(array('status'=>array('$in'=>[12,13,14])))->get('assignOrders');
											break;
										case 4:$respo = $this->mongo_db->where(array('status'=>array('$in'=>[5,6])) )->get('pickupOrders');
											break;
										case 5:$respo = $this->mongo_db->where(array("status" => array('$in' => [7,15])))->get('completedOrders');
											break;	
										case 6:$respo = $this->mongo_db->where(array("status" => array('$in' => [2,3,16])))->get('completedOrders');
											break;					
									   
									}
							 }
			
			
	
			$aaData = $respo;
			$datatosend = array();
			
			foreach ($aaData as $value) {
				// echo '<pre>';print_r($value);die;
				$arr = array();
				switch($value['paymentType']){
					case 1: $paymentType = "Card";
						break;
						case 2: $paymentType = "Cash";
						break;
						case 3: $paymentType = "Wallet";
						break;
						case 4: $paymentType = "Coin Payment";
						break;
				}
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
			
			    $arr['Order Id'] = $value['orderId'];
				$arr['City'] = $value['pickup']['city'] ;
				$arr['Customer Name'] = $value['customerDetails']['name'];
				$arr['Customer Mobile Number'] = $value['customerDetails']['countryCode'].$value['customerDetails']['mobile'];
				$arr['Store Name'] = $value['storeName'] ;
				$arr['Driver Name'] = ($value['driverDetails']['fName'] == "" || $value['driverDetails']['fName'] == null)?"N/A":$value['driverDetails']['fName'] ;
				$arr['Booking Type'] = $bookingType ;
				$arr['Booking Date'] = $value['bookingDate'];
				$arr['Requested Date and Time'] = $value['dueDatetime'];
				$arr['Address'] = ($value['drop']['addressLine1'] == "" && $value['drop']['addressLine1']== null)?"N/A":$value['drop']['addressLine1'].$value['drop']['addressLine2'] ;
				$arr['Payment Type'] = $paymentType ;
				if($value['abbrevation'] == "1"){
				$arr['Net Value'] =$value["currencySymbol"].number_format($value['subTotalAmount'] , 2, '.', '');
				}else{
				$arr['Net Value'] =number_format($value['subTotalAmount'] , 2, '.', '').$value['currencySymbol'];	
				}
				if($value['abbrevation'] == "1"){
					$arr['Delivery Fee'] =$value['currencySymbol'].number_format($value['deliveryCharge'], 2, '.', '');
				}else{
					$arr['Delivery Fee'] =number_format($value['deliveryCharge'], 2, '.', '').$value['currencySymbol'];
				}
				
				$arr['Accepted date & time'] = ($value['timeStamp']['accepted']['timeStamp'] == "" || $value['timeStamp']['accepted']['timeStamp'] == null)?"N/A":date("F d,Y",$value['timeStamp']['accepted']['timeStamp']);
				$arr['Accepted By'] = ($value['timeStamp']['accepted']['stausUpdatedBy'] == "" || $value['timeStamp']['accepted']['stausUpdatedBy'] == null)?"N/A":$dispatchedName;
				$arr['Status '] = $value['statusMsg'] ;
				$datatosend[] = $arr;
			}
		
	
			return $datatosend;
	   }

   
}

?>
