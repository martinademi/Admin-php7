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
		 $this->load->library('CallAPI');
    }


function datatable_storeManagers($for = '', $status = '') {
    
    
        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "phone";
        $_POST['mDataProp_2'] = "email";
        

            switch ($status) {

                    case 1:
                       $respo = $this->datatables->datatable_mongodb('users', array('storeId' => $for,'status' => 1));
                       break;
                    case 2:
                       $respo = $this->datatables->datatable_mongodb('users', array('storeId' => $for,"status" =>array('$in'=>[2,3,4])));        
                       break;
                    case 3:
                       $respo = $this->datatables->datatable_mongodb('users', array('storeId' => $for,'status' => 3));   
                       break;
                    case 4:
                       $respo = $this->datatables->datatable_mongodb('users', array('storeId' => $for,'status' => 4));   
                       break;
                    
            }
        
        
        $aaData = $respo["aaData"];
        $datatosend = array();
        $i = 1;
        foreach ($aaData as $value) {

            $arr = array();
            $arr[] = $i++;
            $arr[] = $value['name'];
            $arr[] = $value['email'];
            $arr[] = $value['countryCode'].' '.$value['phone'];
            $arr[] = '-';
            $arr[] = '<button class="btn btnedit cls111" id="btnedit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: rgb(136, 142, 156);color: white;width: 45px !important;"><i class="fa fa-edit" style="font-size:12px;"></i></button>'
                    .'<button class="btn btndevicelogs cls111" id="btndevicelogs"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: rgb(0, 144, 222);color:white ;width: 45px !important;"><i class="fa fa-mobile " style="font-size:12px;"></i></button>'
                    .'<button class="btn resetPassword cls111" id="resetPassword"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: rgb(136, 142, 156);color: white;width: 45px !important;"><i class="glyphicon glyphicon-refresh" style="font-size:12px;"></i></button>';;
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
    function getDeviceLogs($userType = '') {
        $arr = [];
        if ($userType == "manager") {
            $deviceLogs = $this->mongo_db->where(array('userId' => new MongoDB\BSON\ObjectID($this->input->post('mas_id'))))->get('mobileDevices');
            foreach ($deviceLogs as $dev){
                $arr[] = $dev;
            }
            $name = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('mas_id'))))->find_one('users');
        }
        echo json_encode(array('data' => $arr, 'user' => $name['name']));
        return;
    }
    function getStores($BizId = ''){
        
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($BizId)))->find_one('stores');
        
        return $data;
    }
    function addManager(){

      
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        
        $pass = $this->input->post('password');
        $password1 = password_hash($pass,PASSWORD_BCRYPT);
        $password =  str_replace("$2y$","$2a$",$password1);
        
        $storeId = $this->input->post('storeId');
        $storeName = $this->input->post('storeName');
        $accepts = $this->input->post('accepts');
        $mobile = $this->input->post('mobile');
        $cityId = $this->input->post('cityId');
        $cityName = $this->input->post('cityName');            
        $userType=(int)$this->input->post('userType');            
        $countryCode = '+'.$this->input->post('countryCode');  
        $receivedOrderEmail = $this->input->post('receiveEmail');
        $dispatcherUserType=(int)$this->input->post('dispatchusertype');
        $dispatcherUserTypeMsg=$this->input->post('dispatchusertypeMsg');
        
        
        if(!$countryCode){
            $countryCode = '+91';
        }
         $cursor = $this->mongo_db->get("users");
            $arr = [];
            foreach ($cursor as $catdata) {
                array_push($arr, $catdata['seqId']);
            }
            $max = max($arr);
            $seq = $max + 1;
        $result = array('name' => $name, 'seqId' => $seq, 'email' => $email, 'password' => $password, 'storeId' => $storeId, 'storeName' => $storeName, 'phone' => $mobile, 'countryCode' => $countryCode, 'cityId' => $cityId, 'cityName' => $cityName, 'status' => 1 ,'addedBy' => 'Store','accepts' => $accepts,'userType' => $userType,'receivedOrderEmail'=>$receivedOrderEmail,'dispatcherUserType'=>$dispatcherUserType,'dispatcherUserTypeMsg'=>$dispatcherUserTypeMsg);//,
      
        $data = $this->mongo_db->insert('users',$result);
       
    }
    
    function getmanagersdata($BizId){
       
        $cursor = $this->mongo_db->get_where('users',array('storeId' => $BizId));
        $entities = array();
        $i = 0;
        foreach ($cursor as $data) {

            $entities[] = $data;
            $i++;
        }
        return $entities;
        
    }

    function validateEmail() {
        
        $id=$this->input->post('id');
        if($id==''){
                $res = $this->mongo_db->where(array('email' => $this->input->post('email'),'status'=>array('$nin'=>[4])))->get('users');
                $cout = count($res);
                $result = 0;
                if ($cout > 0) {
                    $result = 1;
                }

                echo json_encode(array('msg' => $result));

        }else{

           $email = $this->input->post('email');
           $id=$this->input->post('id');

           $conditions=array('$and'=>array(array('email'=>$email),array('_id'=> new MongoDB\BSON\ObjectID($id))));
           $res = $this->mongo_db->where($conditions)->get('users');

           if(!$res){
               $res2=$this->mongo_db->where(array('email' =>  $email,'status'=>array('$nin'=>[4])))->get('users');
               $result=1;

               if(!$res2)
               $result=0;

           }else{
               $result=0;
           }          

           echo json_encode(array('msg' => $result));     
           
        }
        
    }
    
   function getManagers() {
        $managerid = $this->input->post('managerid');
//        print_r($managerid); die;
            $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($managerid)))->find_one('users');
//        echo json_encode(array('data'=>$data));
      return $data;
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
        $countryCode = $this->input->post('countryCode');
        $dispatcherUserType=(int)$this->input->post('editdispatchusertype');
        $dispatcherUserTypeMsg=$this->input->post('editdispatchusertypeMsg');
        if ($countryCode) {
            $code = explode('+', $countryCode);
            if (count($code) > 1)
                $countryCode = '+' . $code[1];
            else
                $countryCode = '+' . $countryCode;
        } else {
           $countryCode = '+91';
        }
       // $result = array('name' => $name,'email' => $email,'storeId' => $storeId, 'storeName' => $storeName, 'phone' => $mobile, 'countryCode' => $countryCode, 'cityId' => $cityId, 'cityName' => $cityName);//'accepts' => $accepts, 
       $result = array('name' => $name,'email' => $email,'storeId' => $storeId, 'storeName' => $storeName, 'phone' => $mobile, 'countryCode' => $countryCode, 'cityId' => $cityId, 'cityName' => $cityName,'accepts' => $accepts,'dispatcherUserType'=>$dispatcherUserType,'dispatcherUserTypeMsg'=>$dispatcherUserTypeMsg);
// print_r($result); print_r($managerId); die;
        $data = $this->mongo_db->where(array('_id'=>new MongoDB\BSON\ObjectID($managerId)))->set($result)->update('users');
        echo json_encode($data);
    }
    
    function deleteManagers() {
        $this->load->library('mongo_db');
        $masterid = $this->input->post('masterid');
        $deletedBy = $this->input->post('deletedBy');
        $affectedRows = 0;
        foreach ($masterid as $id) {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 4,'deletedOn'=>new DateTime(),'deletedBy'=>$deletedBy))->update('users');
        }

        echo json_encode(array("msg" => "Selected manager has been deleted successfully", "flag" => 0));
        return;
    }
    function activateManager() {
        $this->load->library('mongo_db');
        $masterid = $this->input->post('val');
        $affectedRows = 0;
        foreach ($masterid as $id) {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1))->update('users');
        }

        echo json_encode(array("msg" => "Selected manager has been activated successfully", "flag" => 0));
        return;
    }
	 function logoutManagers() {
        $this->load->library('mongo_db');
        $masterid = $this->input->post('masterid');

        $affectedRows = 0;
        foreach ($masterid as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 3))->update('users');
            $url = DispatchLink.'manual/logout';
            $dat = array("managerId" => $id);
            $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        }

        echo json_encode(array("msg" => "Selected driver has been logged-out successfully", "flag" => 0));
        return;
    }


    function validatePassword($Bizid = '') {

        $this->load->library('mongo_db');

        $data = $_POST;
        
        $pass=$data['oldpass'];
        $password1 = password_hash($pass,PASSWORD_BCRYPT);
        $password =  str_replace("$2y$","$2a$",$password1);
      

        $curs = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['mId'])))->find_one('users');
      
      if (password_verify($pass, $curs['password'])) {
            $cout = 1;
        } 

      
        $result = 0;
        if ($cout > 0) {
            $result = 1;
        }

        echo json_encode(array('msg' => $result));
    }

    function editpassword() {

        $this->load->library('mongo_db');
       
        $senddata = $_POST;

        $mId= $senddata['mId'];
        
        $pass = $senddata['password'];
        $password1 = password_hash($pass,PASSWORD_BCRYPT);
        $password =  str_replace("$2y$","$2a$",$password1);
        $senddata['password']=$password;
        
        // echo '<pre>';print_r($senddata);die;

        echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($mId)))->set(array('password'=>$password))->update('users');
        
    }

    function permanentDelete() {
      
        $id = $this->input->post('val');
        $storeId=$this->session->userdata('badmin')['BizId'];
    

        foreach ($id as $dataId) {
            
        $result=   $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($dataId)))->delete('users');
        
        }
        echo json_encode($result);
    }

    function getManagerCount() {
        $this->load->library('mongo_db');
        $storeId=$this->session->userdata('badmin')['BizId'];
    
        $data['approved'] = $this->mongo_db->where(array('status'=>1,'storeId'=>$storeId))->count('users');
        $data['login'] = $this->mongo_db->where(array('status'=>2,'storeId'=>$storeId))->count('users');
        $data['logout'] = $this->mongo_db->where(array('status'=>3,'storeId'=>$storeId))->count('users');
        $data['deleted'] = $this->mongo_db->where(array('status'=>4,'storeId'=>$storeId))->count('users');

       


        echo json_encode(array('data' => $data));
        
    }

}

?>
