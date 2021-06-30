<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");


class Customermodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('CallAPI');
    }

    function dt_passenger($status = '') {

       
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
            case 0:$respo = $this->datatables->datatable_mongodb('customer', array('status' => 0, 'userType' => 1),'createdDate',-1);
                break;
            case 1:$respo = $this->datatables->datatable_mongodb('customer', array('status' => 1, 'userType' => 1),'deactivateDate',-1);
                break;
                //changes made for sorting of name
            //case 2:$respo = $this->datatables->datatable_mongodb('customer', array('status' => 2, 'userType' => 1), 'approvedDate',-1);
            case 2:$respo = $this->datatables->datatable_mongodb('customer', array('status' => 2, 'userType' => array('$in'=>[1,4])));            
                break;
            case 3:$respo = $this->datatables->datatable_mongodb('customer', array('status' => 3, 'userType' => 1),'banDate',-1);
                break;
            case 4:
                $respo = $this->datatables->datatable_mongodb('mobileDevices', array('userType'=>3));
                break;
            case 5:
                $respo = $this->datatables->datatable_mongodb('customer', array('status' => 4, 'userType' => 1),'',-1);
                break;
        }

        $aaData = $respo["aaData"];
        $datatosend = array();
        $slno = $_POST['iDisplayStart']+1;
        
        foreach ($aaData as $value) {
            $arr = array();
            $mobile = '';
            foreach ($value['mobileDevices'] as $val) {
                if ($val['currentlyActive'] == TRUE)
                    $mobile = $value['countryCode'] . $value['phone'];
            }

            $setCreditEn = ($value['wallet']['isEnabled'] == TRUE) ? 'checked' : '';
            $setCreditButton = ($value['wallet']['isEnabled'] == TRUE) ? 'display:block;' : 'display:none;';

            $arr[] = $slno++;
            $profile = "<a href='" . base_url() . "index.php?/customer/profile/" . $value['_id']['$oid'] . "'>" . $value['name'] . "</a>";
            $arr[] = ($profile == '' || $profile == null) ? "N/A" : $profile;
            $arr[] = ($mobile == '' || $mobile == null) ? "N/A" : $this->Customermodel->maskFileds($mobile, 2);
            $arr[] = ($value['email'] == '' || $value['email'] == null) ? "N/A" : $this->Customermodel->maskFileds($value['email'], 1);
            $arr[] = ($value['registeredFromCity'] == '' || $value['registeredFromCity'] == null) ? "N/A" : $value['registeredFromCity'];
            $arr[] = ($value['mobileDevices']['appVersion'] == '' || $value['mobileDevices']['appVersion'] == null) ? "N/A" : $value['mobileDevices']['appVersion'];
            //$arr[] = ($value['approvedDate'] == '' || $value['approvedDate'] == null) ? "N/A" :  date('F  d, Y h:i:s A ', ($value['approvedDate']) - ($this->session->userdata('timeOffset') * 60));
            $arr[] = date('F  d, Y h:i:s A ', ($value['createdDate']) - ($this->session->userdata('timeOffset') * 60));
            // $arr[] = date('F  d, Y h:i:s A ', ($value['deactivateDate']) - ($this->session->userdata('timeOffset') * 60));
            $arr[] = date('F  d, Y h:i:s A ', ($value['banDate']) - ($this->session->userdata('timeOffset') * 60));
            $arr[] = ($value['deactivateReason'] != '') ? $value['deactivateReason'] : "No reason specified";
            $arr[] = ($value['deviceId'] == '' || $value['deviceId'] == null)?'N/A':$value['deviceId'];
            $arr[] = ($value['deviceMake'] == '' || $value['deviceMake'] == null)?'N/A':$value['deviceMake'];
            $arr[] = ($value['deviceModel'] == '' || ($value['deviceModel'])== null)?'N/A':$value['deviceModel'];
            $arr[] = ($value['registerTime'] == '' || $value['registerTime'] == null)?'N/A': date('F  d, Y h:i:s A ',$value['registerTime']);
            $arr[] = ($value['coordinates']!='')?$value['coordinates']['latitude'].','.$value['coordinates']['longitude']:'Not Available';
            $arr[] = ($value['lastLogin'] == '' || $value['lastLogin'] == null)?'N/A': date('F  d, Y h:i:s A', $value['lastLogin']);
            $arr[] = '<button style="width:35px !important;" class="btn btn-primary btnWidth resetPasswordICON cls111"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-refresh"></i></button>'
                   .'<button style="width:35px !important;" class="btn btn-primary btnWidth deviceLogsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-phone"></i></button>';
            $arr[] = '<div class="switch cls111" data-id="' . $value['_id']['$oid'] . '" style="margin-top: 14px;float: left;"><input id="' . $value['_id']['$oid'] . '"  class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;" ' . $setCreditEn . '><label for="' . $value['_id']['$oid'] . '"></label></div><div class="pull-right m-t-10 new_button cls111" style="' . $setCreditButton . '"> <button class="walletSettings credbtn btn-info" style="width: 45px;" slaveID = "' . $value['_id']['$oid'] . '">Set</button></div>'; 
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" imgmmj="' . $value['mmjCard']['url'] . '" idcard="' . $value['identityCard']['url'] . '" value="' . $value['_id']['$oid'] . '" />';
            $datatosend[] = $arr;
        }



        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function getCustomer($id) {
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');
        $data['createdDt'] = date('F  d, Y ', $data['createdDt']);
        $data['dateOfBirth'] = date('F  d, Y ', $data['dateOfBirth'] / 1000);
        foreach ($data['phone'] as $phone) {
            if ($phone['is_Currently_Active'] == TRUE) {
                $data['phone'] = $phone['phone'];
                $data['countryCode'] = $phone['countryCode'];
            }
        }
        if (!array_key_exists("orders",$data)){
            $data['orders']['ordersCount']='N/A';
            $data['orders']['ordersAmount']='N/A';
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
        $data['New'] = $this->mongo_db->where(array('status' => array('$in' => [0, '0']), 'userType' => array('$in' => [1, '1'])))->count('customer');
        $data['Rejepted'] = $this->mongo_db->where(array('status' => array('$in' => [1, '1']), 'userType' => array('$in' => [1, '1'])))->count('customer');
        $data['Approved'] = $this->mongo_db->where(array('status' => array('$in' => [2, '2']), 'userType' => array('$in' => [1, '1'])))->count('customer');
        $data['Ban'] = $this->mongo_db->where(array('status' => array('$in' => [3, '3']), 'userType' => array('$in' => [1, '1'])))->count('customer');
        $data['Deleted'] = $this->mongo_db->where(array('status' => array('$in' => [4, '4']), 'userType' => array('$in' => [1, '1'])))->count('customer');
        $data['Guest'] = $this->mongo_db->where(array( 'userType' => array('$in' => [3, '3'])))->count('customer');

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
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1,'statusMsg'=>"Rejected" ,'deactivateReason' => $reason, 'deactivateDate' => $deactivateDate))->update('customer');
            $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');
            $dat = array('name' => $getData['name'],'userId'=>$id, 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['phone'], 'status' => 2, 'reason1' => (!isset($getData['banReason']) || $getData['banReason'] == '') ? "N/A" : $getData['banReason']);
            $url = APILink . 'admin/email';
            $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        }
        echo json_encode(array('msg' => 'Customers have been deactivated'));
        
    }

    function activateRejectedCustomer() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        foreach ($val as $id)
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 0,'statusMsg'=>"New" ,'mmjCard' => array('verified' => FALSE), 'identityCard' => array('verified' => FALSE), 'activatedfromRejectDate' => time()))->update('customer');

        echo json_encode(array('msg' => "Customer have been activated", 'flag' => 0));
        return;
    }

    function activepassengers() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        $mmjCard = $this->input->post('mmjCard');
        $identityCard = $this->input->post('identityCard');
        $ban = $this->input->post('ban');
		

        if (($val != '' && $val != '') || ($val != null && $val != null)) {
            foreach ($val as $id) {
                
				$res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');
               if(($res['identityCard']['verified'] == false && $res['mmjCard']['verified'] == false)||($res['identityCard']['verified'] == true && $res['mmjCard']['verified'] == true)){
				   $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 2,"statusMsg"=>"Approved", 'mmjCard' => array('url' => $mmjCard, 'verified' => TRUE), 'identityCard' => array('url' => $identityCard, 'verified' => TRUE), 'approvedDate' => time()))->update('customer');
			   if ($ban == '' || $ban == null) {
                    $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');
                    $dat = array('name' => $getData['name'], 'userId'=>$id,'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['phone'], 'status' => 6, 'reason1' => (!isset($getData['banReason']) || $getData['banReason'] == '') ? "N/A" : $getData['banReason']);
                    $url = APILink . 'admin/email';
                    $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
                } else {
                    $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');
                    $dat = array('name' => $getData['name'],'userId'=>$id, 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['phone'], 'status' => 6, 'reason1' => (!isset($getData['banReason']) || $getData['banReason'] == '') ? "N/A" : $getData['banReason']);
                    $url = APILink . 'admin/email';
                    $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
                }
				echo json_encode(array('msg' => "Customer have been activated", 'flag' => 0));
			   }else{
				    echo json_encode(array('msg' => "something went wrong", 'flag' => 1));
			   }
            }
		
            
        } else {
            echo json_encode(array('msg' => "something went wrong", 'flag' => 1));
        }
    }

    function banCustomer() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
//        print_r($this->input->post('reason'));die;
        foreach ($val as $id) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 3,'statusMsg'=>"Banned",'banReason'=>$this->input->post('reason') ,'banDate' => time()))->update('customer');
            $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('customer');

            $dat = array('name' => $getData['name'],'userId'=>$id, 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['phone'], 'status' => 1, 'reason1' => (!isset($getData['banReason']) || $getData['banReason'] == '') ? "N/A" : $getData['banReason']);
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
             $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status'=>4,'statusMsg'=>"Deleted"))->update('customer');
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

        $dat = array('userId'=>$id,'status'=>18);
        $url = APILink . 'admin/email';
        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        
        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

    function rejectMMJCard() {
        $this->load->library('mongo_db');
        $card = $this->input->post('reason');
        $id = $this->input->post('id');

        $data = array('rejectCardReason' => $card, 'mmjCard.verified' => FALSE, 'status' => 0);

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('customer');
        $dat = array('userId'=>$id,'status'=>18);
        $url = APILink . 'admin/email';
        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        
        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

    function approveMMJCard() {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('mmjCard.verified' => TRUE))->update('customer');
        $dat = array('userId'=>$id,'status'=>18);
        $url = APILink . 'admin/email';
        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        
        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

    function uploadSIICard() {
        $this->load->library('mongo_db');
        $card = $this->input->post('idImage');
        $id = $this->input->post('id');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('identityCard' => array('url' => $card, 'verified' => FALSE)))->update('customer');
        $dat = array('userId'=>$id,'status'=>18);
        $url = APILink . 'admin/email';
        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        
        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

    function rejectSIICard() {
        $this->load->library('mongo_db');
        $card = $this->input->post('reason');
        $id = $this->input->post('id');
        $data = array('rejectSIIReason' => $card, 'identityCard.verified' => FALSE, 'status' => 0);

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('customer');
        $dat = array('userId'=>$id,'status'=>18);
        $url = APILink . 'admin/email';
        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        
        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

    function approveSIICard() {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('identityCard.verified' => TRUE))->update('customer');
        $dat = array('userId'=>$id,'status'=>18);
        $url = APILink . 'admin/email';
        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        
        echo json_encode(array("msg" => "1", "flag" => 0));
        return;
    }

    function adminUpdateUserPassword($userId, $password) {
        $this->load->library('bcrypt');

        $password1 = password_hash($password, PASSWORD_BCRYPT);
        $hashedPassowrd = str_replace("$2y$", "$2a$", $password1);
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($userId)))->set(array('password' => $hashedPassowrd, 'mobileVerified' => true))->update('customer');
        $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($userId)))->find_one('customer');

        $dat = array('name' => $getData['name'],'userId'=>$userId, 'email' => $getData['email'],'password'=>$password ,'mobile' => $getData['countryCode'] . $getData['phone'], 'status' => 15, 'reason1' => (!isset($getData['banReason']) || $getData['banReason'] == '') ? "N/A" : $getData['banReason']);
        $url = APILink . 'admin/email';

        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        if ($result == 1) {
            echo json_encode(array("msg" => "success", "flag" => 0));
        } else {
            echo json_encode(array("msg" => "failed", "flag" => 0));
        }
        return;
    }

    function maskFileds($string, $emailOrPohne) {
        
        $emailSession=$this->session->userdata('emailMask');
        if($emailSession=="on"){
             //If email 
            if ($emailOrPohne == 1) {
                $r = explode('@', $string);
                $len = strlen(substr($r[0], 1));
                $replaceChar = "";
                for ($i = 0; $i < $len; $i++)
                    $replaceChar .= "*";
                return substr($r[0], 0, 1) . $replaceChar . '@' . $r[1];
            }//phone
            else {

                $len = strlen($string);
                $replaceChar = "";
                for ($i = 5; $i < $len; $i++)
                    $replaceChar .= "*";
                return substr($string, 0, 5) . $replaceChar;
            }
        }else{
            return $string;
        }
        
       
    }

    function enDisCreditCustomer() {
        $this->load->library('mongo_db');
        $slave_id = $this->input->post('slave_id');
        $setCreditEn = ($this->input->post('flag') == 1) ? TRUE : FALSE;

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($slave_id)))->set(array('wallet.isEnabled' => $setCreditEn))->update('customer');

        echo json_encode(array('msg' => "Success", 'flag' => 1));
        return;
    }

    function getWalletForShipper() {
        $this->load->library('mongo_db');
        $pass_id = $this->input->post('pass_id');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($pass_id), 'wallet' => array('$exists' => TRUE)))->find_one('customer');
        
        if ($result['wallet']['softLimit'] !== 0 && $result['wallet']['hardLimit'] !== 0)
            $data = array('data' => $result, 'flag' => 0);
        else {
            //get data from city as deafault for wallet
            //$result = $this->mongo_db->where(array('cities.cityId'=>new MongoDB\BSON\ObjectID($result['cityId'])))->find_one('cities');

            $cityData = $this->mongo_db->aggregate('cities',[
                ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($result['cityId'])]],
                ['$unwind'=>'$cities'],
                ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($result['cityId'])]]                
                ]);

            foreach($cityData as $cData){
                $doc = json_decode(json_encode($cData),TRUE)['cities'];
            }

            $data = array('data' => $doc, 'flag' => 1);
        }
        echo json_encode($data);
        return;
    }

    function walletUpdateForShipper() {
        $this->load->library('mongo_db');
        $pass_id = $this->input->post('pass_id');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($pass_id)))->find_one('customer');

        if ($result) {
            $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($pass_id)))->set(array('wallet.softLimit' => (float) $this->input->post('softLimit'), 'wallet.hardLimit' => (float) $this->input->post('hardLimit')))->update('customer');

            //API calling
            $url = APILink . 'admin/walletLimit';
            $r = $this->callapi->CallAPI('POST', $url, array('userId' => $pass_id, 'userType' => 1));
            
        }

        echo json_encode(array('Msg' => $result, 'apiResponse' => $r));
        return;
    }

}

?>
