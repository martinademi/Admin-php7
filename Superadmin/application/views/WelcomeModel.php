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
        $this->load->database();
         $this->load->library('mongo_db');
    
    }
     function get_passengerinfo($status) {
//        $varToShowData = $this->db->query("select * from slave where status='" . $status . "'order by slave_id DESC")->result();
         $varToShowData = $this->mongo_db->get_where('customers',array('status'=>$status));
         foreach($varToShowData as $data){}

        return $data;
    }
//    function dt_passenger($status = '') {
//
//        $this->load->library('Datatables');
//        $this->load->library('table');
//
//
//        $this->datatables->select("s.slave_id as rahul,s.first_name,s.phone,s.email,s.created_dt,s.profile_pic", FALSE)
//                ->unset_column('dtype')
//                ->unset_column('s.profile_pic')
//                ->add_column('PROFILE PIC', '<img src="$1" width="50px" height="50px;" class="imageborder" onerror="this.src=\'http://shypr.in/Shypr/pics/user.jpg\'">', 's.profile_pic')
////                    ->add_column('PROFILE PIC', 'get_profile_pic/$1', 'rahul')
////                ->add_column('DEVICE TYPE', '<img src="' . base_url() . '../../admin/assets/$1" width="30px" >', 'dtype')
//                 ->add_column('DEVICE TYPE', 'getSlaveDeviceInfo/$1', 'rahul')
//                ->add_column('select', '<input type="checkbox" class="checkbox" name="checkbox" value= "$1"/>', 'rahul')
//                ->from('slave s')
//                ->where('s.status', $status);
//        $this->db->order_by("rahul", "desc");
//
//        echo $this->datatables->generate();
//        
//    }     
        
        
        function dt_passenger($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $datatosend1 = $this->mongo_db->get_where('customers',array('status'=>(int)$status));
        
        
        $slno = 0;
        foreach ($datatosend1 as $res){
            $arr[]= array('<a data-toggle="modal" href="#myModal">'.$res['_id']['$oid'].'</a>',
                           $res['type'],$res['name'],$res['phone'],$res['email'], '<a href="" class="disp" >'.$res['dispatcher'].'</a>',
                             $res['profile_pic'],$res['reg_date'],'<input type="checkbox" class="checkbox" id="'.$res['cust_id'].'"/>');
       }
        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
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
    
    
    
    function inactivepassengers() {
        $val = $this->input->post('val');

        foreach ($val as $result) {
             $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->set(array('status'=> 4))->update('customers');
            
        }
    }
    function activepassengers() {
        $val = $this->input->post('val');

        foreach ($val as $result) {
           $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->set(array('status'=> 3))->update('customers');
        }
    }
     function deletepassengers() {

        $pass_ids = $this->input->post('val');
        foreach ($pass_ids as $id) {
             $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('customers');
        }
        return;
    }
   function insertpass() {
        $password = $this->input->post('newpass');
        $val = $this->input->post('val');

        
         $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->set(array('password'=> $password))->update('customers');
//        return $res;
        if ($result > 0) {
            echo json_encode(array('msg' => "Password updated successfully", 'flag' => 1));
            return;
        }
    }
    function App_Configuration() {

        $MAsterData = $this->mongo_db->get('App_Configuration');
        $data = array();

        foreach ($MAsterData as $configs) {
//            $GetMAster = $this->mongo_db->get_one('ProviderData');
            $data = $configs;
        }
        return $data;
    }
     function get_lan_hlpText($param = '') {

        if ($param == ''){
           
            $res = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        }else{
//            $where = array('lan_id' => (int) $param);
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
//        foreach($res as $r)
//                print_r($r); die;
        return $res;
    }
        

}