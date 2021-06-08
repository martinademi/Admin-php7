<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

//require_once 'superModel/S3.php';
//require_once 'superModel/StripeModuleNew.php';
//require_once 'superModel/AwsPush.php';

class GuestCustomermodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
//        $this->load->database();
        $this->load->library('mongo_db');
    }

    function datatableGuest($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 3;

        $_POST['mDataProp_0'] = "slno";
        $_POST['mDataProp_1'] = "deviceId";
        $_POST['mDataProp_2'] = "devMake";
        $_POST['mDataProp_3'] = "devModel";


      
$respo = $this->datatables->datatable_mongodb('mobileDevices', array('userType'=>3));
             


        $aaData = $respo["aaData"];
        $datatosend = array();
           $sl = $_POST['iDisplayStart'] + 1;
        foreach ($aaData as $value) {
            
            $arr = array();

            $arr[] =$sl++;
            $arr[] = ($value['deviceId'] == '' || $value['deviceId'] == null)?'N/A':$value['deviceId'];
            $arr[] = ($value['deviceMake'] == '' || $value['deviceMake'] == null)?'N/A':$value['deviceMake'];
            $arr[] = ($value['deviceModel'] == '' || ($value['deviceModel'])== null)?'N/A':$value['deviceModel'];
            $arr[] = ($value['registerTime'] == '' || $value['registerTime'] == null)?'N/A': date('F  d, Y h:i:s A ',$value['registerTime']);
            $arr[] = ($value['coordinates']!='')?$value['coordinates']['latitude'].','.$value['coordinates']['longitude']:'Not Available';
            $arr[] = ($value['lastLogin'] == '' || $value['lastLogin'] == null)?'N/A': date('F  d, Y h:i:s A', $value['lastLogin']);
           
             $datatosend[] = $arr;
        }

       

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function getCustomer($id) {
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');
//        print_r($data['createdDt']);exit();
        $data['createdDt'] = date('F  d, Y ', $data['createdDt']);    
        $data['dateOfBirth'] = date('F  d, Y ', $data['dateOfBirth']/1000);
        foreach ($data['phone'] as $phone) {
            if ($phone['is_Currently_Active'] == TRUE){
                $data['phone'] = $phone['phone'];
                $data['countryCode'] = $phone['countryCode'];
            }
            
        }
        
        return $data;
    }
    
     function getDeviceLogs($userType = '') {
        $this->load->library('mongo_db');
        if ($userType == "driver") {
            $deviceLogs = $this->mongo_db->where(array('user_Id' => new MongoDB\BSON\ObjectID($this->input->post('mas_id'))))->find('mobileDevices');
        } else {
            $con = array('userType' => 1, 'userId' => new MongoDB\BSON\ObjectID($this->input->post('slave_id')));
            $deviceLogs = $this->mongo_db->where($con)->get('mobileDevices');
            $name = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('slave_id'))))->find_one('customer');
        }
        echo json_encode(array('data' => $deviceLogs, 'user' => $name));
        return;
    }

    public function save_driver_data() {
        $driverid = $this->input->post('mas_id');
        $fdata = $this->input->post('fdata');
        $fdata['phone']= array(array('phone'=> $fdata['phone'],'is_Currently_Active'=>TRUE,'countryCode'=>$fdata['countryCode']));
         unset($fdata['dateOfBirth']);   
        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($driverid)))->set($fdata)->update('customer');
        echo json_encode(array('msg' => "Selected provider data save succesfully", 'flag' => 0));
        return true;
    }

    function getCustomerCount() {
        $this->load->library('mongo_db');
        $data['Accepted'] = $this->mongo_db->where(array('status' => array('$in' => [3, '3']),'userType'=> array('$in' => [1, '1'])))->count('customer');
        $data['Rejepted'] = $this->mongo_db->where(array('status' => array('$in' => [4, '4']),'userType'=> array('$in' => [1, '1'])))->count('customer');

        echo json_encode(array('data' => $data));
        return;
    }

    function rejectCustomers() {
        $this->load->library('mongo_db');
        $ids = $this->input->post('pass_id');
        $reason = $this->input->post('reason');
        $ids = $this->input->post('pass_id');
        $deactivateDate = time();
        foreach ($ids as $id)
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => '4', 'deactivateReason' => $reason, 'deactivateDate' => $deactivateDate))->update('customer');

        echo json_encode(array('msg' => 'Customers have been deactivated'));
        return;
    }

    function activepassengers() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        foreach ($val as $id)
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => "3"))->update('customer');

        echo json_encode(array('msg' => "Custome have been activated", 'flag' => 0));
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
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('mmjImage'=>$card))->update('customer');

        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }
    function rejectMMJCard() {
        $this->load->library('mongo_db');
        $card = $this->input->post('reason');
        $id = $this->input->post('id');
        $data = array('rejectCardReason'=>$card,'isApprovedMMJ'=>2);

            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('customer');


        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }
    function approveMMJCard() {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('isApprovedMMJ'=>1))->update('customer');

        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }
    function uploadSIICard() {
        $this->load->library('mongo_db');
        $card = $this->input->post('idImage');
        $id = $this->input->post('id');
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('idImage'=>$card))->update('customer');

        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }
    function rejectSIICard() {
        $this->load->library('mongo_db');
        $card = $this->input->post('reason');
        $id = $this->input->post('id');
        $data = array('rejectSIIReason'=>$card,'isApprovedSII'=>2);

            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('customer');


        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }
    function approveSIICard() {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('isApprovedSII'=>1))->update('customer');

        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

}

?>
