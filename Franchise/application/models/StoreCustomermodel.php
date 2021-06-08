<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

//require_once 'superModel/S3.php';
//require_once 'superModel/StripeModuleNew.php';
//require_once 'superModel/AwsPush.php';

class StoreCustomermodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
//        $this->load->database();
        $this->load->library('mongo_db');
        $this->load->library('CallAPI');
    }

    function dt_passenger($status = '',$BizId) {

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 6;

        $_POST['mDataProp_0'] = "slno";
        $_POST['mDataProp_1'] = "name";
        $_POST['mDataProp_2'] = "email";
        $_POST['mDataProp_3'] = "phone";
        $_POST['mDataProp_4'] = "cityName";
        $_POST['mDataProp_5'] = "registeredFromCity";
//        $_POST['mDataProp_4'] = "city";

        switch ($status) {
            // case 0:$respo = $this->datatables->datatable_mongodb('customer', array('status' => 2, 'userType' => 1, 'storesBelongTo'=> array('storeId' => $BizId)),'',-1); 
            // break;
            case 0:$respo = $this->datatables->datatable_mongodb('customer', array('userType' => 4, 'storesBelongTo'=> array('storeId' => $BizId)),'',-1);
                break;
           /* case 2:$respo = $this->datatables->datatable_mongodb('customer', array('status' => 2, 'userType' => 1), 'approvedDate',-1);
                break;
            case 3:$respo = $this->datatables->datatable_mongodb('customer', array('status' => 3, 'userType' => 1),'',-1);
                break;
                */
        }
        // echo '<pre>';
        // print_r($respo);
        $aaData = $respo["aaData"];
        $datatosend = array();
        $slno = 1;

        foreach ($aaData as $value) {
            $arr = array();
            /*foreach ($value['mobileDevices'] as $val) {
                if ($val['currentlyActive'] == TRUE)
                    $mobile = $value['countryCode'] . $value['phone'];
            }*/
            $mobile = $value['countryCode'] . $value['phone'];
            $orderCount=0;
            $tot_revenue =0;
            $currencySymbol='';
            foreach($value['completedOrders'] as $orderDetails){
                    if($orderDetails['storeId'] == $this->session->userdata["badmin"]['BizId'] ){
                        $tot_revenue += $tot_revenue +$orderDetails['orderTotal'];
                        $orderCount++;
                        $currencySymbol=($orderDetails['currencySymbol']) ? $orderDetails['currencySymbol'] :"$" ;
                    }
                    
            }
            $cityName = ($value['registeredFromCity']) ? $value['registeredFromCity'] :$value['cityName'] ;
            $arr[] = $slno++;
            //$profile = "<a href='" . base_url() . "index.php?/customer/profile/" . $value['_id']['$oid'] . "'>" . $value['name'] . "</a>";
            $profile = $value['name'];
            $arr[] = ($profile == '' || $profile == null) ? "N/A" : $profile;
            $arr[] = ($mobile == '' || $mobile == null) ? "N/A" : $mobile;
            $arr[] = ($value['email'] == '' || $value['email'] == null) ? "N/A" : $value['email'];
           // $arr[] = ($value['registeredFromCity'] == '' || $value['registeredFromCity'] == null) ? "N/A" : $value['registeredFromCity'];
           $arr[] = ($cityName == '' || $cityName == null) ? "N/A" : $cityName;
           // $arr[] = ($value['mobileDevices']['appVersion'] == '' || $value['mobileDevices']['appVersion'] == null) ? "N/A" : $value['mobileDevices']['appVersion'];
           $arr[] = ( $orderCount == 0) ? "0" : '<span  style="font-size:12px;">'.$orderCount.'</span>';
           $arr[] = ( $tot_revenue == 0) ? "0" : '<span  style="font-size:12px;">'.$currencySymbol.number_format($tot_revenue,2,'.',',').'</span>';
        //    $arr[] = ($value['mmjCard']['url'] == '') ? 'N/A' : '<img style="-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);width:50px;height: 50px;" class="img-thumbnail"  src=' . $value['mmjCard']['url'] . '>';
        //    $arr[] = ($value['identityCard']['url'] == '') ? 'N/A' : '<img style="-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);width:50px;height: 50px;" class="img-thumbnail"  src=' . $value['identityCard']['url'] . '>';
           //$arr[] = ($value['approvedDate'] == '' || $value['approvedDate'] == null) ? "N/A" : date('F  d, Y h:i:s A', $value['approvedDate']);
           
           // $arr[] = date('F  d, Y h:i:s A', $value['createdDate']);
           // $arr[] = date('F  d, Y h:i:s A', $value['deactivateDate']);
           // $arr[] = date('F  d, Y h:i:s A', $value['banDate']);
           // $arr[] = ($value['deactivateReason'] != '') ? $value['deactivateReason'] : "No reason specified";
           
            //$arr[] = ($value['identityCard']['url'] == '') ? 'N/A' : '<img style="-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);width:50px;height: 50px;" class="img-thumbnail"  src=' . $value['identityCard']['url'] . '>';

           // $arr[] = '<button style="width:35px !important;" class="btn btn-primary deviceLogsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-phone"></i></button>';
            $datatosend[] = $arr;
        }



        $respo["aaData"] = $datatosend;
        // print_r($respo);die;
        echo json_encode($respo);
    }

    public function getCustomer($id) {
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');
//        print_r($data['createdDt']);exit();
        $data['createdDt'] = date('F  d, Y ', $data['createdDt']);
        $data['dateOfBirth'] = date('F  d, Y ', $data['dateOfBirth'] / 1000);
        foreach ($data['phone'] as $phone) {
            if ($phone['is_Currently_Active'] == TRUE) {
                $data['phone'] = $phone['phone'];
                $data['countryCode'] = $phone['countryCode'];
            }
        }

        return $data;
    }

    function getDeviceLogs($userType = '') {
        $this->load->library('mongo_db');
        if ($userType == "customer") {
            $con = array('userType' => 1, 'userId' => new MongoDB\BSON\ObjectID($this->input->post('slave_id')));
            $deviceLogs = $this->mongo_db->where($con)->get('mobileDevices');
            $name = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('slave_id'))))->find_one('customer');
        }
        echo json_encode(array('data' => $deviceLogs, 'user' => $name));
    }

    public function save_driver_data() {
        $driverid = $this->input->post('mas_id');
        $fdata = $this->input->post('fdata');

        unset($fdata['0']);
        unset($fdata['dateOfBirth']);
        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($driverid)))->set($fdata)->update('customer');
        echo json_encode(array('msg' => "Selected provider data save succesfully", 'flag' => 0));
    }

    function getCustomerCount() {
        $this->load->library('mongo_db');
        $BizId= $this->session->userdata["badmin"]['BizId'];
        $data['appcustomer'] = $this->mongo_db->where(array('status' => 2, 'userType' => 1,  'storesBelongTo'=> array('storeId' => $BizId)))->count('customer');
        $data['addedbystore'] = $this->mongo_db->where(array('userType' => 4, 'storesBelongTo'=> array('storeId' => $BizId)))->count('customer');
       // $data['Approved'] = $this->mongo_db->where(array('status' => array('$in' => [2, '2']), 'userType' => array('$in' => [1, '1'])))->count('customer');
       // $data['Ban'] = $this->mongo_db->where(array('status' => array('$in' => [3, '3']), 'userType' => array('$in' => [1, '1'])))->count('customer');

        echo json_encode(array('data' => $data));
        return;
    }

    function rejectCustomers() {
        $this->load->library('mongo_db');
        $ids = $this->input->post('pass_id');
        $reason = $this->input->post('reason');
        $ids = $this->input->post('pass_id');
        $deactivateDate = time();
        foreach ($ids as $id) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1, 'deactivateReason' => $reason, 'deactivateDate' => $deactivateDate))->update('customer');
            $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');
            $dat = array('name' => $getData['name'], 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['phone'], 'status' => 2, 'reason1' => (!isset($getData['banReason']) || $getData['banReason'] == '') ? "N/A" : $getData['banReason']);
            $url = APILink . 'admin/email';
            $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        }
        echo json_encode(array('msg' => 'Customers have been deactivated'));
        return;
    }

    function activateRejectedCustomer() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        foreach ($val as $id)
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 0, 'mmjCard' => array('verified' => FALSE), 'identityCard' => array('verified' => FALSE), 'activatedfromRejectDate' => time()))->update('customer');

        echo json_encode(array('msg' => "Customer have been activated", 'flag' => 0));
        return;
    }

    function activepassengers() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        $mmjCard = $this->input->post('mmjCard');
        $identityCard = $this->input->post('identityCard');
        $ban = $this->input->post('ban');

        if (($mmjCard != '' && $identityCard != '') || ($mmjCard != null && $identityCard != null)) {
            foreach ($val as $id) {
                $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 2, 'mmjCard' => array('url' => $mmjCard, 'verified' => TRUE), 'identityCard' => array('url' => $identityCard, 'verified' => TRUE), 'approvedDate' => time()))->update('customer');
                if ($ban == '' || $ban == null) {
                    $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');
                    $dat = array('name' => $getData['name'], 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['phone'], 'status' => 6, 'reason1' => (!isset($getData['banReason']) || $getData['banReason'] == '') ? "N/A" : $getData['banReason']);
                    $url = APILink . 'admin/email';
                    $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
                } else {
                    $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');
                    $dat = array('name' => $getData['name'], 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['phone'], 'status' => 6, 'reason1' => (!isset($getData['banReason']) || $getData['banReason'] == '') ? "N/A" : $getData['banReason']);
                    $url = APILink . 'admin/email';
                    $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
                }
            }

            echo json_encode(array('msg' => "Customer have been activated", 'flag' => 0));
        } else {
            echo json_encode(array('msg' => "something went wrong", 'flag' => 1));
        }
    }

    function banCustomer() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        foreach ($val as $id) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 3, 'banDate' => time()))->update('customer');
            $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');

            $dat = array('name' => $getData['name'], 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['phone'], 'status' => 1, 'reason1' => (!isset($getData['banReason']) || $getData['banReason'] == '') ? "N/A" : $getData['banReason']);
            $url = APILink . 'admin/email';

            $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        }
        echo json_encode(array('msg' => "Customer have been banned", 'flag' => 0));
        return;
    }

    function deletepassengers() {
        $this->load->library('mongo_db');
        $customers = $this->input->post('val');
        $affectedRows = 0;

        foreach ($customers as $id) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('customer');
//            $this->mongo_db->where(array('customerID' => new MongoDB\BSON\ObjectID($id)))->delete('Customer_dispatcher');
        }

        echo json_encode(array("msg" => "Customer have been deleted", "flag" => 0));
        return;
    }

    function uploadMMJCard() {
        $this->load->library('mongo_db');
        $card = $this->input->post('mmjImage');
        $id = $this->input->post('id');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('mmjCard' => array('url' => $card, 'verified' => FALSE)))->update('customer');

        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

    function rejectMMJCard() {
        $this->load->library('mongo_db');
        $card = $this->input->post('reason');
        $id = $this->input->post('id');

        $data = array('rejectCardReason' => $card, 'mmjCard.verified' => FALSE, 'status' => 0);

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('customer');

        $resultData = $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');


        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

    function approveMMJCard() {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('mmjCard.verified' => TRUE))->update('customer');

        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

    function uploadSIICard() {
        $this->load->library('mongo_db');
        $card = $this->input->post('idImage');
        $id = $this->input->post('id');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('identityCard' => array('url' => $card, 'verified' => FALSE)))->update('customer');

        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

    function rejectSIICard() {
        $this->load->library('mongo_db');
        $card = $this->input->post('reason');
        $id = $this->input->post('id');
        $data = array('rejectSIIReason' => $card, 'identityCard.verified' => FALSE, 'status' => 0);

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('customer');

        $resultData = $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');

        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

    function approveSIICard() {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('identityCard.verified' => TRUE))->update('customer');

        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

    function adminUpdateUserPassword($userId, $password) {
        $this->load->library('bcrypt');

        $password1 = password_hash($password, PASSWORD_BCRYPT);
        $hashedPassowrd = str_replace("$2y$", "$2a$", $password1);
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($userId)))->set(array('password' => $hashedPassowrd, 'mobileVerified' => true))->update('customer');
        $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($userId)))->find_one('customer');

        $dat = array('name' => $getData['name'], 'email' => $getData['email'],'password'=>$password ,'mobile' => $getData['countryCode'] . $getData['phone'], 'status' => 15, 'reason1' => (!isset($getData['banReason']) || $getData['banReason'] == '') ? "N/A" : $getData['banReason']);
        $url = APILink . 'admin/email';

        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        if ($result == 1) {
            echo json_encode(array("msg" => "success", "flag" => 0));
        } else {
            echo json_encode(array("msg" => "failed", "flag" => 0));
        }
        return;
    }

}

?>
