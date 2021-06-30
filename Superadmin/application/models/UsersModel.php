<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class UsersModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->model("Customermodel");
    }

function getCities() {
        $data = $this->mongo_db->get('cities');
        $res = array();
        foreach ($data as $cities) {
            foreach ($cities['cities'] as $city) {
				if($city['isDeleted']==FALSE){
                $res[] = $city;
				}
            }
        }

        return $res;
    }
function datatable_users($for = '', $status = '') {
    
    
        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "phone";
        $_POST['mDataProp_2'] = "email";
        $_POST['mDataProp_3'] = "cityName";
        

            switch ($status) {

                    case 1:
					$role = $this->session->userdata("role");
					   if($role!="ArialPartner"){
                       $respo = $this->datatables->datatable_mongodb('users', array('status' => array('$in'=>[1,2,3,4])));
					   }else{
						   $respo = $this->datatables->datatable_mongodb('users', array('cityId'=>(string)$this->session->userdata("cityId"),'status' => array('$in'=>[1,2,3,4])));
					   }
					   
                       break;

                    case 2:
                    $respo = $this->datatables->datatable_mongodb('users', array('status' => 2));
                    
                    break;
                    
                    case 3:
                    $respo = $this->datatables->datatable_mongodb('users', array('status' => 3));
                    
                    break;

                    case 4:
                    $respo = $this->datatables->datatable_mongodb('users', array('status' => 4));
                       break;
                    case 5:
                       $respo = $this->datatables->datatable_mongodb('users', array('status' => 5));
                       break;
                    
                    
            }
        
        
        $aaData = $respo["aaData"];
        $datatosend = array();
        $i = 1;
        foreach ($aaData as $value) {

            $mobile = $value['countryCode'] . $value['phone'];

            $arr = array();
            $arr[] = $i++;
			$arr[] = $value['cityName'];
            $arr[] = $value['name'];
            //$arr[] = ($value['franchiseName'] == "")?"N/A":$value['franchiseName'];
            $arr[] = ($value['storeName'] == "")?"N/A":$value['storeName'];
            $arr[] = $this->Customermodel->maskFileds($value['email'], 1);
            $arr[] = $this->Customermodel->maskFileds($mobile, 2); 
            $arr[] = '<button class="btn btnEditUsers cls111" id="btnedit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: rgb(136, 142, 156);color: white;width: 45px !important;"><i class="fa fa-edit" style="font-size:12px;"></i></button>'.
                      '<button class="btn resetPassword cls111" id="resetPassword"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: rgb(136, 142, 156);color: white;width: 45px !important;"><i class="glyphicon glyphicon-refresh" style="font-size:12px;"></i></button>';
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
    function getFranchiseStores() {
        $val = $this->input->post('val');
        
        $data = $this->mongo_db->where(array("franchiseId" => $val,'status' => 1))->get('stores');
        echo json_encode($data);
    }
    function addusers(){
		//print_r($_POST);die;
        
		$cursorCheck = $this->mongo_db->where(array("email"=> strtolower($this->input->post('email'))))->get("users");
		
		if(!$cursorCheck){
        $name = $this->input->post('name');
        $email =strtolower ($this->input->post('email'));
        $pass = $this->input->post('password');
        $franchiseId = $this->input->post('franchiseId');
        $franchiseName = $this->input->post('franchiseName');
        $storeId = $this->input->post('storeId');
        $storeName = $this->input->post('storeName');
        $userType = $this->input->post('userType');
        $userTypeMsg = $this->input->post('userTypeMsg');
        $password1 = password_hash($pass,PASSWORD_BCRYPT);
        $password =  str_replace("$2y$","$2a$",$password1);
        $dispatcherUserType=(int)$this->input->post('dispatchusertype');
        $dispatcherUserTypeMsg=$this->input->post('dispatchusertypeMsg');
        $storeType=(int)$this->input->post('storeType');
        $storeTypeMsg=$this->input->post('storeTypeMsg');
        if($userType == 0){
            $passwordAdmin = md5($pass);
        }else{
            $passwordAdmin = "";
        }
      

        
        
        $mobile = $this->input->post('mobile');
        $cityId = $this->input->post('cityId');
        $cityName = $this->input->post('cityName');            
        $countryCode = '+'.$this->input->post('countryCode');  
       
         $cursor = $this->mongo_db->get("users");
            $arr = [];
            foreach ($cursor as $catdata) {
                array_push($arr, $catdata['seqId']);
            }
            $max = max($arr);
            $seq = $max + 1;
            if($franchiseId == null){
                $franchiseId = "";
            }
            if($franchiseName == null){
                $franchiseName = "";
            }
            if($storeId == null){
                $storeId = "";
            }
            if($storeName == null){
                $storeName = "";
            }

          
            $id = new MongoDB\BSON\ObjectID();
         //   $data['_id'] = $id;

             $result = array('_id'=>$id,'name' => $name, 'seqId' => $seq, 'email' => $email,'passwordAdmin'=>$passwordAdmin,'password'=>$password, 'phone' => $mobile, 'countryCode' => $countryCode, 'cityId' => $cityId, 'cityName' => $cityName,'franchiseId'=>$franchiseId,'franchiseName'=>$franchiseName,'storeId'=>$storeId,'storeName'=>$storeName,"userType"=>(int)$userType,'userTypeMsg'=>$userTypeMsg,'status' => 1,'dispatcherUserType'=>$dispatcherUserType,'dispatcherUserTypeMsg'=>$dispatcherUserTypeMsg,
             'storeType' => $storeType,'storeTypeMsg'=>$storeTypeMsg,'userId'=>(string)$id);
            
             $data = $this->mongo_db->insert('users',$result);
             
             $con=str_replace("+","",$countryCode);         
             $mob=$con.$mobile;
           
             $rel=array('userId'=>(string)$id,'mobile' => $mob,'name' => $name,'email' => $email,'status'=>17,'reason1'=>'Created from admin');
           

             
              $url = APILink . 'admin/email';
              $response = json_decode($this->callapi->CallAPI('POST', $url, $rel), true);
            //   echo '<pre>';print_r($response);die;
              if($userType == 0){
                $result['userType'] = 1;
				$result['wallet'] = array("balance"=>0,"blocked"=>0,"hardLimit"=>0,"softLimit"=>0,"softLimitHit"=>false,"hardLimitHit"=>false);
                $data1 = $this->mongo_db->insert('arialPartner',$result);
				
              }
                echo json_encode(array('data'=>$data,"flag"=>1));
                }else{
                    echo json_encode(array("flag"=>0));
                }
    }
    
    function getusersData($BizId){
       
        $cursor = $this->mongo_db->get_where('users');
        $entities = array();
        $i = 0;
        foreach ($cursor as $data) {

            $entities[] = $data;
            $i++;
        }
        return $entities;
        
    }
	
	
	function checkCityExistsForPartner(){
		$val = $this->input->post('val');
		$type = $this->input->post('type');
		 $data = $this->mongo_db->where(array('cityId' => new MongoDB\BSON\ObjectID($val),"userType"=>$type))->find_one('users');
		 if($data){
			 $flag = 1;
		 }else{
			$flag = 0; 
		 }
		 echo json_encode(array("flag"=>$flag));
	}
     
   function getusers() {
        $managerid = $this->input->post('managerid');
//        print_r($managerid); die;
            $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($managerid)))->find_one('users');
//        echo json_encode(array('data'=>$data));
      return $data;
    }
    
    function editusers() {
      
        $managerId = $this->input->post('managerId');
      
        $name = $this->input->post('name');
        $email = $this->input->post('email');
     
        $mobile = $this->input->post('mobile');
        $cityId = $this->input->post('cityId');
        $cityName = $this->input->post('cityName');
        $countryCode = $this->input->post('countryCode');
        $dispatcherUserType=(int)$this->input->post('editdispatchusertype');
        $dispatcherUserTypeMsg=$this->input->post('editdispatchusertypeMsg');

        $storeType=(int)$this->input->post('storeType');
        $storeTypeMsg=$this->input->post('storeTypeMsg');

           
        $result = array('name' => $name,'email' => $email, 'phone' => $mobile, 'countryCode' => $countryCode, 'cityId' => $cityId, 'cityName' => $cityName,'dispatcherUserType'=>$dispatcherUserType,'dispatcherUserTypeMsg'=>$dispatcherUserTypeMsg,
        'storeType' => $storeType,'storeTypeMsg'=>$storeTypeMsg); 

    //    echo 'nowww'; print_r($result);die;
        $data = $this->mongo_db->where(array('_id'=>new MongoDB\BSON\ObjectID($managerId)))->set($result)->update('users');
      
        echo json_encode($data);
    }
    
    function deleteusers() {
        // deactivate user
        $this->load->library('mongo_db');
        $masterid = $this->input->post('masterid');
        $deletedBy = $this->input->post('deletedBy');
        $affectedRows = 0;
        foreach ($masterid as $id) {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 4,'statusMsg'=>"Inactive",'deletedOn'=>time(),'deletedBy'=>$deletedBy))->update('users');
        }

        echo json_encode(array("msg" => "Selected users has been deleted successfully", "flag" => 0));
        return;
    }
    function activateusers() {
        $this->load->library('mongo_db');
        $masterid = $this->input->post('val');
        $affectedRows = 0;
        foreach ($masterid as $id) {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1,"statusMsg"=>"Activated"))->update('users');
        }

        echo json_encode(array("msg" => "Selected users has been activated successfully", "flag" => 0));
        return;
    }

    function DeleteTempUsers() {
        $this->load->library('mongo_db');
        $masterid = $this->input->post('val');
        $deletedBy = "Superadmin";
        $affectedRows = 0;      
        foreach ($masterid as $id) {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 5,'statusMsg'=>"Delete",'deletedOn'=>time(),'deletedBy'=>$deletedBy))->update('users');
        }

        echo json_encode(array("msg" => "Selected users has been deleted successfully", "flag" => 0));
        return;
    }
	
	
	 function checkusersExists() {
        $this->load->library('mongo_db');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $check = $this->mongo_db->get('users');
        $emailArray = array();
        $phoneArray = array();
        foreach ($check as $checkPartner) {
            $emailArray[] = $checkPartner['email'];
            $phoneArray[] = $checkPartner['phone'];
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

        // if ($data['oldpass'] !== $curs['password']) {
        //     $cout = 1;
        // }

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

    function getManagerCount() {
        $this->load->library('mongo_db');
      
    
        $data['approved'] = $this->mongo_db->where(array('status'=>array('$in'=>[1,2,3,4])))->count('users');
        $data['login'] = $this->mongo_db->where(array('status'=>2))->count('users');
        $data['logout'] = $this->mongo_db->where(array('status'=>3))->count('users');
        $data['deactive'] = $this->mongo_db->where(array('status'=>4))->count('users');
        $data['deleted'] = $this->mongo_db->where(array('status'=>5))->count('users');

       


        echo json_encode(array('data' => $data));
        
    }

    function permanentDelete() {
      
        $id = $this->input->post('val');
        $storeId=$this->session->userdata('badmin')['BizId'];
    

        foreach ($id as $dataId) {
            
        $result=   $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($dataId)))->delete('users');
        
        }
        echo json_encode($result);
    }

}

?>
