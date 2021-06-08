<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");
  ini_set('display_errors', '1');
    error_reporting(E_ALL);
require_once 'S3.php';
//require_once 'StripeModule.php';
//require 'aws.phar';
//require_once 'AwsPush.php';

class WelcomeModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
//        $this->load->database();
         $this->load->library('mongo_db');
    
    }
    public function dt_customerVerification() {

        $this->load->library('Datatables');
        $this->load->library('table');
        $custDispatcherData = $this->mongo_db->get('verification');
  
        foreach ($custDispatcherData as $res){
            $dt = $res['time'];
            $date = new DateTime("@$dt");  
            $datetime = $date->format('Y-m-d H:i:s');
            $arr[]= array($res['mobile'],$datetime,$res['code'],$res['count'] );
            
        }
       
        if($this->input->post('sSearch') != '')
        {
            foreach ($arr as $row)
            {
                $needle = ucwords($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(ucwords($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
        
        if($this->input->post('sSearch') == '')
        echo $this->datatables->getdataFromMongo($arr);
    }
    
 function datatable_dispatcher($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        
        $result =  $this->mongo_db->get_where('dispatcher',array('status'=>(int)$status));
        
        $slno = 0;
        foreach($result as $res){
              
            $data[] = array($res['city_name'],$res['name'],$res['email'],$res['lastlogin'],'<input type="checkbox" class="checkbox" value="'.$res['_id']['$oid'].'" id="disp"/>');
        }
          if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($data as $row)
            {
                $needle = ucwords($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(ucwords($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
        
        if($this->input->post('sSearch') == '')
        echo $this->datatables->getdataFromMongo($data);
    }
    
     function get_dispatchers_data($status = '') {
        $res = $this->mongo_db->get_where('dispatcher',array('status'=>$status));
        return $res;
    }
     function city_get() {
        $cityData = $this->mongo_db->get('cities');
        return $cityData;
    }
    
    function inactivedispatchers() {
        $status = $this->input->post('val');
        foreach ($status as $row) {
           
             $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->set(array('status' => 2))->update('dispatcher');
        }
    }

    function activedispatchers() {
        $status = $this->input->post('val');
        foreach ($status as $row) {
            
             $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->set(array('status' => 1))->update('dispatcher');
        }
    }
    
    function insertdispatches() {
        $this->load->library('mongo_db');
        $name = $this->input->post('name');
        $city_name = $this->input->post('city_name');
        $city = $this->input->post('city');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $status = 1;
        $res = $this->mongo_db->insert('dispatcher',array('name'=>$name,'city'=>$city,'city_name'=>$city_name,'email'=>$email,'password'=>$password,'status'=>$status));
        

        if ($res > 0) {
            echo json_encode(array('msg' => '0'));
            return;
        } else {
            echo json_encode(array('msg' => '1'));
            return;
        }
    }
    function getDispatcerData() {
          $this->load->library('mongo_db');
          
              $dis_id = $this->input->post('val');
              
             foreach ($dis_id as $id)
            {
            $res = $this->mongo_db->where(array('_id'=> new MongoDB\BSON\ObjectID($id)))->find_one('dispatcher');  
            }
            echo json_encode($res);
           
        }
         
        
        function editdispatchers() {
        $city_name = $this->input->post('city_name');
        $city = $this->input->post('cityval');
        $val = $this->input->post('val');
        $email = $this->input->post('email');
        $name = $this->input->post('name');
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->set(array('city'=>$city,'name'=>$name,'email'=>$email,'city_name'=>$city_name))->update('dispatcher');
        if ($res > 0) {
            echo json_encode(array('msg' => 'Updated successfully', 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => 'Updation failed', 'flag' => 1));
            return;
        }
    }
    function cityAdd() {
     
        $contry = ucwords(strtolower($this->input->post('contry')));
        $city = ucwords(strtolower($this->input->post('city')));
        $cityData = $this->mongo_db->where( array('country'=>$contry,'city'=>$city,'city'=>$city))->find_one('cities');
        
        if(empty($cityData))
        {
            $insertArr = array('country'=>$contry,'city'=>$city,'pointsProps'=>$this->input->post('pointsProps'),'points'=>$this->input->post('points'));
            $this->mongo_db->insert('cities', $insertArr);
            echo json_encode(array('msg'=>'City is added','flag'=>0));
        }
        else{
            echo json_encode(array('msg'=>'City is already exists','flag'=>1));
        }
        return; 
    }
    function deletedispatchers() {
        $status = $this->input->post('val');
        foreach ($status as $row) {
//            $result = $this->db->query("delete from dispatcher  where dis_id='" . $row . "'");
             $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->delete('dispatcher');

        }

    }
        
//    }

}