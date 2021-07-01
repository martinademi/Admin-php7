<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class CartsModal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
    }

    function datatable_carts($stDate = '', $endDate = '') {
        // $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "items.storeName";
        $_POST['mDataProp_1'] = "cityName";
        $_POST['mDataProp_2'] = "userName";
        $_POST['mDataProp_3'] = "createdTimeStamp";

        if ($stDate && $endDate) {
            $bookingDate = array('$gte' => strtotime($stDate . " 00:00:00"), '$lte' => strtotime($endDate . ' 23:59:59'));
            $respo = $this->datatables->datatable_mongodb('cart', array('createdTimeStamp' => $bookingDate));
        } else {
            $respo = $this->datatables->datatable_mongodb('cart', array(), 'createdTimeStamp', -1);
        }



        $aaData = $respo["aaData"];
        $datatosend = array();
        $index = $_POST['iDisplayStart'] + 1;

        foreach ($aaData as $data) {
            // echo '<pre>';print_r($data);die;
            $cartTotal = 0;
            $count = 0;
            $cnt = 0;
            foreach ($data['items'] as $items) {   
                   //echo '<pre>';print_r($items);die;

                if(!array_key_exists('unitPrice',$items)){
                    $items['unitPrice']=0;
                }
                $cartTotal = $cartTotal + ($items['quantity'] * $items['unitPrice']);

                if(!array_key_exists('storeName',$items)){
                    $storeName = 'N/A';
                }else{
                    $storeName = $items['storeName'];
                }
                
                $cartActions = count($items['actions']);
                $count = $cnt + $cartActions;
                foreach ($items['actions'] as $actions) {
                    $lastActive = $actions['timeStamp'];
                }
                $cnt = $count;
				$currencySymbol = $items['currencySymbol'];
            }

            if(!array_key_exists('storeType',$data)){
                $storeType="N/A";
            }else{
                switch($data['storeType']){

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
                    default:
                        $storeType="N/A";
                        break;
                }

            }
             


            $arr = array();

            // $arr[] = $index++;
            // $arr[] = '<a href="' . base_url() . 'index.php?/CartsController/getCartDetailsData/' . $data['_id']['$oid'] . '" style="cursor: pointer;text-decoration: underline;"  cartId="' . $data['_id']['$oid'] . '">' . $data['_id']['$oid'] . '</a>';
            // $arr[] = (!isset($data['userName']) || $data['userName'] == '') ? "Guest User" : $data['userName'];
            // $arr[] = "N/A";
            // $arr[] = ($storeName == '') ? "N/A" : $storeName;
            // $arr[] = (!isset($data['cityName']) || $data['cityName'] == '') ? "N/A" : $data['cityName'];
            // $arr[] = $storeType;
            // $arr[] = date('d-M-Y h:i:s a ', ($data['createdTimeStamp']) - ($this->session->userdata('timeOffset') * 60));
            // $arr[] = $currencySymbol." ".$cartTotal;
            // $arr[] = '<a href="' . base_url() . 'index.php?/CartsController/getActionDetails/' . $data['_id']['$oid'] . '" style="cursor: pointer;text-decoration: none;" class="badge bg-green" cartId="' . $data['_id']['$oid'] . '">' . $cnt . '</a>';
            // $arr[] = ($data['statusMsg'] == '') ? "N/A" : $data['statusMsg'];
            // $arr[] =  date('d-M-Y h:i:s a ', ($lastActive) - ($this->session->userdata('timeOffset') * 60));

            // NEW
            $arr[] = $index++;
            $arr[] = '<a href="' . base_url() . 'index.php?/CartsController/getCartDetailsData/' . $data['_id']['$oid'] . '" style="cursor: pointer;text-decoration: underline;"  cartId="' . $data['_id']['$oid'] . '">' . $data['_id']['$oid'] . '</a>';
            $arr[] = (!isset($data['userName']) || $data['userName'] == '') ? "Guest User" : $data['userName'];
            $arr[] = "N/A";
            $arr[] = ($storeName == '') ? "N/A" : $storeName;
            $arr[] = (!isset($data['cityName']) || $data['cityName'] == '') ? "N/A" : $data['cityName'];
            $arr[] = $storeType;
            $arr[] = date('d-M-Y h:i:s a ', ($data['createdTimeStamp']) - ($this->session->userdata('timeOffset') * 60));
            $arr[] = $currencySymbol." ".$cartTotal;
            $arr[] = ($data['statusMsg'] == '') ? "N/A" : $data['statusMsg'];
            $arr[] = '<a href="' . base_url() . 'index.php?/CartsController/getActionDetails/' . $data['_id']['$oid'] . '" style="cursor: pointer;text-decoration: none;" class="badge bg-green" cartId="' . $data['_id']['$oid'] . '">' . $cnt . '</a>';


            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);

//        
    }

    function getCompleteCartDetails($param) {
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->find_one('cart');
		$result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($res['userId'])))->select(array('countryCode'=>'countryCode','phone'=>'phone','email'=>'email'))->find_one('customer');
		$res['customerPhone']=$result['phone'];
		$res['customerCountryCode']=$result['countryCode'];
		$res['customerEmail']=$result['email'];
        return $res;
    }
    function getCartDetails($param) {
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->find_one('cart');
        $data1 = array();
        $x = 0;
        foreach ($res['items'] as $result) {
            $data = array();
            $data['storeName'] = ($result['storeName'] == '' || $result['storeName'] == null) ? "N/A" : $result['storeName'];
            $data['itemName'] = ($result['itemName'] == '' || $result['itemName'] == null) ? "N/A" : $result['itemName'];
            $data['qty'] = ($result['quantity'] == '' || $result['quantity'] == null) ? "N/A" : $result['quantity'];
            $data['unitPrice'] = ($result['unitPrice'] == '' || $result['unitPrice'] == null) ? "N/A" : $result['unitPrice'].' '.$result['currencySymbol'];
            $data['total'] = (int) $result['quantity'] * (float) $result['unitPrice'].' '.$result['currencySymbol'];
            $data1[] = $data;
        }

        echo json_encode(['status' => true, 'data' => $data1]);
    }

    function datatableActionDetails($param) {

        $this->load->library('Datatables');
        $this->load->library('table');

        $respo = $this->datatables->datatable_mongodb('cart', array("_id" => new MongoDB\BSON\ObjectID($param)), '', -1);

        $aaData = $respo["aaData"];
        $index = $_POST['iDisplayStart'] + 1;
        $data1 = array();
        foreach ($aaData as $res) {
            
            foreach ($res['items'] as $result1) {
                foreach ($result1['actions'] as $result) {

                    if(!array_key_exists('storeName',$result1)){
                        $storeName = 'N/A';
                    }else{
                        $storeName = $result1['storeName'];;
                    }

                    if(!array_key_exists('unitPrice',$result1)){
                        $uPrice='N/A';
                       $up= 0;
                    }else{
                        
                        $uPrice=($result1['unitPrice'] == null)?"N/A":$result1['currencySymbol'].' '.$result1['unitPrice'];
                        $up= (float) $result1['unitPrice'];
                    }
                    

                    $data = array();
                    $data[] = $index++;
                    $data[] = $storeName;
                    $data[] = $result1['itemName'];
                    $data[] = ($result1['quantity'] == null)?"N/A":$result1['quantity'];
                    $data[] = 'N/A';                    
                    $data[] = $uPrice;
                 //   $data[] = (int) $result1['quantity'] *  $up.' '.$result1['currencySymbol'];
                    $data[] = $result1['currencySymbol'].' '.(int) $result1['finalPrice'];
                    $data[] = $result['actionBy'];
                    $data[] = ($result['actorName'] =='')?"N/A":$result['actorName'];
                    $data[] = $result['type'];
                   // $data[] = date('j-M-Y g:i:s A', $result['timeStamp']);
                    $data[] = date('d-M-Y h:i:s a ', ($result['timeStamp']) - ($this->session->userdata('timeOffset') * 60));

                    $data1[] = $data;
                }
            }
        }
        $respo["aaData"] = $data1;
        echo json_encode($respo);
    }
    function datatableCartDetails($param) {

        $this->load->library('Datatables');
        $this->load->library('table');

        $respo = $this->datatables->datatable_mongodb('cart', array("_id" => new MongoDB\BSON\ObjectID($param)), '', -1);

        $aaData = $respo["aaData"];
        $index = $_POST['iDisplayStart'] + 1;
        $data1 = array();
        foreach ($aaData as $res) {
            
            foreach ($res['items'] as $result1) {
                
                    $data = array(); 
                    $data[] = $index++;
                    $data[] = $result1['storeName'];
//                    $data[] = $res['userName'];
                    $data[] = '<a class="getCustomerDetails" style="cursor: pointer;text-decoration: underline;" slave="'.$res['userId'].'" cartId="' . $res['_id']['$oid'] . '">' . $res['userName'] . '</a>';
                    $data[] = $result1['itemName'];
                    $data[] = ($result1['quantity'] == null)?"N/A":$result1['quantity'];
                    $data[] = ($result1['unitPrice'] == null)?"N/A":$result1['unitPrice'].' '.$result1['currencySymbol'];
                    $data[] = (int) $result1['quantity'] * (float) $result1['unitPrice'].' '.$result1['currencySymbol'];
                   
                    $data1[] = $data;
                
            }
        }
        $respo["aaData"] = $data1;
        echo json_encode($respo);
    }

}

?>
