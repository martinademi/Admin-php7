<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class StoremanagersModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('Bcrypt');
        $this->load->library('CallAPI');
    }

    function datatable_storeManagers($for = '', $status = '') {

        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "storeName";
        $_POST['mDataProp_1'] = "cityName";
        $_POST['mDataProp_2'] = "name";
        $_POST['mDataProp_3'] = "phone";
        $_POST['mDataProp_4'] = "email";

        if ($for == 'my') {
            switch ($status) {

                case 1:
                    $respo = $this->datatables->datatable_mongodb('storeManagers', array('status' => 1), '', -1);
                    break;
                case 2:
                    $respo = $this->datatables->datatable_mongodb('storeManagers', array('status' => 2), '', -1);
                    break;
                case 3:
                    $respo = $this->datatables->datatable_mongodb('storeManagers', array('status' => 3), '', -1);
                    break;
                case 4:
                    $respo = $this->datatables->datatable_mongodb('storeManagers', array('status' => 4), '', -1);
                    break;
            }
        }

        $aaData = $respo["aaData"];
        $datatosend = array();
        $i = $_POST['iDisplayStart'] + 1;
        foreach ($aaData as $value) {
            switch ($value['accepts']) {
                case '1':
                    $accepts = "Pickup";
                    break;
                case '2':
                    $accepts = "Delivery";
                    break;
                case '3':
                    $accepts = "Pickup & Delivery";
                    break;
            }

            $arr = array();
            $arr[] = $i++;
            $arr[] = $value['cityName'];
            $arr[] = "<a class='getManagerDetails' style='cursor: pointer;' managerId='".$value['_id']['$oid']."'>" . $value['name'] . "</a>";
            $arr[] = "N/A";
            $arr[] = $value['storeName'];
            $arr[] = $value['email'];
            $arr[] = $value['countryCode'] . ' ' . $value['phone'];
            $arr[] = $accepts;
            $arr[] = '<button style="width:35px;" class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="border-radius: 0px;"><i class="fa fa-edit"></i></button>'
                    .'<button style="width:35px;" class="btn btndeviceLogs btn-info cls111" id="btndeviceLogs"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="border-radius: 0px;"><i class="glyphicon glyphicon-phone"></i></button>'
                    .'<button style="width:35px;" class="btn btnresetpwd cls111" id="btnResetPwd"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="border-radius: 0px;"><i class="glyphicon glyphicon-refresh"></i></button>';
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function getDeviceLogs($userType = '') {

        if ($userType == "manager") {
            $deviceLogs = $this->mongo_db->where(array('userId' => new MongoDB\BSON\ObjectID($this->input->post('mas_id'))))->get('mobileDevices');
            $name = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('mas_id'))))->find_one('storeManagers');
        }
//        print_r($deviceLogs);exit();
        echo json_encode(array('data' => $deviceLogs, 'user' => $name['name']));
    }

    function getStores() {
        $val = $this->input->post('val');
        $data = $this->mongo_db->where(array("cityId" => $val,'status' => 1))->get('stores');
        echo json_encode($data);
    }
    function getFranchise() {
        $val = $this->input->post('val');
        $data = $this->mongo_db->where(array("cityId" => $val,'status' => 2))->get('franchise');
        echo json_encode($data);
    }

    function getCities() {
        $data = $this->mongo_db->get('cities');
        $res = array();
        foreach ($data as $cities) {
            foreach ($cities['cities'] as $city) {
                $res[] = $city;
            }
        }

        return $res;
    }

    function resetPassword() {
        $pass = $this->input->post('newpass');
        $val = $this->input->post('val');
        $password1 = password_hash($pass, PASSWORD_BCRYPT);
        $password = str_replace("$2y$", "$2a$", $password1);
       
       
        //chnages made 
        //comment-->it was not entering into foreach
        $id=$val;
        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('password' => $password))->update('storeManagers');
        $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('storeManagers');
        $dat = array('name' => $getData['name'], 'password' => $pass, 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['phone'], 'status' => 13, 'reason1' => (!isset($getData['reason']) || $getData['reason'] == '') ? "N/A" : $getData['reason']);
        $url = APILink . 'admin/email';
        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);

        // foreach ($val as $id) {
        //     print_r($id);die;
        //     $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('password' => $password))->update('storeManagers');
        //     $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('storeManagers');
        //     $dat = array('name' => $getData['name'], 'password' => $pass, 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['phone'], 'status' => 13, 'reason1' => (!isset($getData['reason']) || $getData['reason'] == '') ? "N/A" : $getData['reason']);
        //     $url = APILink . 'admin/email';
        //     $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        // }
        echo json_encode(array('msg' => 1));
    }

    function getManagers() {
        $managerid = $this->input->post('managerid');

        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($managerid)))->find_one('storeManagers');
//        echo json_encode(array('data'=>$data));
        return $data;
    }

    function addManager() {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $pass = $this->input->post('password');
//        print_r($pass);die;
        $password1 = password_hash($pass, PASSWORD_BCRYPT);
        $password = str_replace("$2y$", "$2a$", $password1);

        $profilePic = $this->input->post('profilePic');
        $franchiseId = $this->input->post('franchiseId');
        $storeId = $this->input->post('storeId');
        $storeName = $this->input->post('storeName');
        $accepts = $this->input->post('accepts');
        $mobile = $this->input->post('mobile');
        $cityId = $this->input->post('cityId');
        $cityName = $this->input->post('cityName');
        $countryCode = '+' . $this->input->post('countryCode');
        $cursor = $this->mongo_db->get("storeManagers");
        $arr = [];
        foreach ($cursor as $catdata) {
            array_push($arr, $catdata['seqId']);
        }
        $max = max($arr);
        $seq = $max + 1;
        $objectId1 = new MongoDB\BSON\ObjectID();
        
        $mqtt = 'mqttTopic-' . $objectId1 . time();
        $FCM = 'FCM-' . $objectId1 . time();
        $fcmManagerTopic = 'FCM-MANAGER-'. $objectId1 . time(); 
        $fcmStoreTopic = 'FCM-STORE-' . $objectId1 . time(); 
        $mqttManagerTopic = 'MQTT-MANAGER-' . $objectId1 . time(); 
        $mqttStoreTopic = 'MQTT-STORE-' . $objectId1 . time(); 
        $result = array('profilePic'=>$profilePic,'name' => $name, 'seqId' => $seq, 'email' => $email, 'password' => $password,'franchiseId' => $franchiseId, 'storeId' => $storeId, 'storeName' => $storeName, 'accepts' => $accepts, 'phone' => $mobile, 'countryCode' => $countryCode, 'cityId' => $cityId, 'cityName' => $cityName, 'status' => 1, 'mqttTopic' => $mqtt, 'fcmTopic' => $FCM,'fcmManagerTopic'=>$fcmManagerTopic,
            'fcmStoreTopic'=>$fcmStoreTopic,'mqttManagerTopic'=>$mqttManagerTopic,'mqttStoreTopic'=>$mqttStoreTopic);
// print_r($result); die;
        $res = $this->mongo_db->where(array("email" => $email))->find_one('storeManagers');
//        print_r($res);exit();

        if (empty($res)) {
            $data = $this->mongo_db->insert('storeManagers', $result);
            $dat = array('name' => $name, 'userId' => $data, 'email' => $email, 'mobile' => $countryCode . $mobile, 'status' => 17);
            $url = APILink . 'admin/email';
            $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
            echo json_encode(array('data' => $data, 'flag' => 1));
        } else {
            echo json_encode(array('flag' => 0));
        }
    }

    function editManager() {
        $managerId = $this->input->post('managerId');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $storeId = $this->input->post('storeId');
        $storeName = $this->input->post('storeName');
        $accepts = $this->input->post('accepts');
        $mobile = $this->input->post('mobile');
        $cityId = $this->input->post('cityId');
        $cityName = $this->input->post('cityName');
        $countryCode = '+' . $this->input->post('countryCode');
        $profilePic = $this->input->post('profilePic');
   
        $result = array('profilePic'=>$profilePic,'name' => $name, 'email' =>(string)$email, 'storeId' => $storeId, 'storeName' => $storeName, 'accepts' => $accepts, 'phone' => $mobile, 'countryCode' => $countryCode, 'cityId' => $cityId, 'cityName' => $cityName);
// print_r($result); die;
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($managerId)))->set($result)->update('storeManagers');
        echo json_encode(array("msg"=>"success","flag"=>1));
        return;
    }

    function getManagersCount() {
        $this->load->library('mongo_db');
        $data['New'] = $this->mongo_db->where(array('status' => 1))->count('storeManagers');
        $data['loggedin'] = $this->mongo_db->where(array('status' => 2))->count('storeManagers');
        $data['loggedout'] = $this->mongo_db->where(array('status' => 3))->count('storeManagers');
        $data['deleted'] = $this->mongo_db->where(array('status' => 4))->count('storeManagers');

        echo json_encode(array('data' => $data));
        return;
    }

    function deleteManagers() {
        $this->load->library('mongo_db');
        $masterid = $this->input->post('masterid');
        $deletedBy = $this->input->post('deletedBy');
        $affectedRows = 0;
        foreach ($masterid as $id) {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 4, 'deletedOn' => new DateTime(), 'deletedBy' => $deletedBy))->update('storeManagers');
        }

        echo json_encode(array("msg" => "Selected driver has been deleted successfully", "flag" => 0));
        return;
    }

    function activateManagers() {
        $this->load->library('mongo_db');
        $masterid = $this->input->post('masterid');

        $affectedRows = 0;
        foreach ($masterid as $id) {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1, 'fromDeletedToActivateOn' => time()))->update('storeManagers');
        }

        echo json_encode(array("msg" => "Selected driver has been activated successfully", "flag" => 0));
        return;
    }

    function logoutManagers() {
        $this->load->library('mongo_db');
        $masterid = $this->input->post('masterid');

        $affectedRows = 0;
        foreach ($masterid as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 3))->update('storeManagers');
            $url = DispatchLink.'manual/logout';
            $dat = array("managerId" => $id);
            $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        }

        echo json_encode(array("msg" => "Selected driver has been logged-out successfully", "flag" => 0));
        return;
    }

    function checkManagerExists() {
        $this->load->library('mongo_db');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $check = $this->mongo_db->get('storeManagers');
        $emailArray = array();
        $phoneArray = array();
        foreach ($check as $checkManager) {
            $emailArray[] = $checkManager['email'];
            $phoneArray[] = $checkManager['phone'];
        }
        if (in_array($mobile, $phoneArray))  {
            $flag = 2;
        } else if(in_array($email, $emailArray)){
            $flag=1;
        }
        else{
            $flag=0;
        }

        echo json_encode(array('flag' => $flag));
    }
    
     function getManagerDetails() {

        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('managerId'))))->find_one('storeManagers');

        echo json_encode(array('managerData' => $data));
        return;
    }

}

?>
