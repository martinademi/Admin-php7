<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Utilities extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model("utilmodal");
        $this->load->library('session');
//        $this->load->library('excel');
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    

    function show_help($cat_id, $lan = 0, $scat_id = '') {
        $return['helpText'] = $this->utilmodal->get_cat_hlpText($cat_id);
        $return['lan'] = $lan;
        $this->load->view("show_help", $return);
    }

    function submit_help($lan = '0', $sid = '0') {
        $slaveInfo = $this->utilmodal->get_SlaveDetails($sid);
        $desc = implode("\n", $this->input->post('fDesc'));

        if ($sid > 0) {
            // CREATE JSON FORMATTED VARIABLE TO PASS AS PARAMETER TO API  
            $create = json_encode(
                    array(
                'ticket' => array(
                    'requester' => array(
                        'name' => $slaveInfo->first_name,
                        'email' => $slaveInfo->email
                    ),
                    'group_id' => $this->input->post('zGroup'),
//                'assignee_id' => $arr['new_tick_assignee'],
                    'subject' => $this->input->post('fTitle'),
                    'description' => $desc
                )
                    ), JSON_FORCE_OBJECT
            );

            $data = $this->curlWrap("/tickets.json", $create, "POST");
            $return['msg'] = 'Your requested successfully submitted.';
            $return['flag'] = 0;
            $this->load->view("submit_help", $return);
        } else {
            $return['msg'] = 'Something went wrong try again.';
            $return['flag'] = 1;
            $this->load->view("submit_help", $return);
        }
    }

    public function curlWrap($url, $json, $action) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_URL, ZDURL . $url);
        curl_setopt($ch, CURLOPT_USERPWD, ZDUSER . "/token:" . ZDAPIKEY);
        switch ($action) {
            case "POST":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                break;
            case "GET":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                break;
            case "PUT":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                break;
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                break;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        curl_close($ch);
        $decoded = json_decode($output);
        return $decoded;
    }

    public function helpText() {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }

        $return['language'] = $this->utilmodal->get_lan_hlpText();
        $return['group'] = $this->utilmodal->get_grp_hlpText();
        $return['helpText'] = $this->utilmodal->get_cat_hlpText();
        error_reporting(0);

        $return['pagename'] = "utilities/helpText";
        $this->load->view("company", $return);
    }

    function get_subcat() {
        error_reporting(0);
        $this->load->library('mongo_db');
        $res = $this->mongo_db->get_one('hlp_txt', array('cat_id' => (int) $this->input->post('cat_id')));
        echo json_encode($res);
    }

    function grp_action($param = '') {
        error_reporting(0);
        if ($param == 'del') {
            $this->load->library('mongo_db');
            $this->mongo_db->delete('group_hlp', array('grp_id' => (int) $this->input->post('id')));
            echo json_encode(array('msg' => '1'));
            die;
        }
        $this->utilmodal->grp_action();
    }

    function help_cat($param = '', $param2 = '') {
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->utilmodal->get_lan_hlpText();
        $return['group'] = $this->utilmodal->get_grp_hlpText();
        $return['helpText'] = '';
        if ($param == 0) {
            $return['edit_id'] = '';
            $return['cat_id'] = $param2;
            $return['helpText'] = $this->utilmodal->get_cat_hlpText($param2, 'add');
        } else {
            
        }

        $return['pagename'] = "utilities/add_help_cat";
        $this->load->view("company", $return);
    }

    function help_edit($param = '', $param2 = '') {
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->utilmodal->get_lan_hlpText();
        $return['group'] = $this->utilmodal->get_grp_hlpText();
//        if($param2 == ''){
        $return['edit_id'] = $param;
        $return['scat_id'] = $param2;
//        }else{
//        }
        $return['helpText'] = $this->utilmodal->get_cat_hlpText($param);
        $return['pagename'] = "utilities/edit_help_cat";
        $this->load->view("company", $return);
    }

    function help_cat_action($param = '', $param2 = '') {
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        if ($param == 'del') {
            $this->load->library('mongo_db');
            if ($param2 == '') {
                $this->mongo_db->delete('hlp_txt', array('cat_id' => (int) $this->input->post('id')));
                echo json_encode(array('msg' => '1'));
                die;
            } else {
                $this->mongo_db->updatewithpull('hlp_txt', array('sub_cat' => array('scat_id' => new MongoId($this->input->post('id')))), array('sub_cat.scat_id' => new MongoId($this->input->post('id'))));
                echo json_encode(array('msg' => '1'));
                die;
            }
        }
        $return['language'] = $this->utilmodal->help_cat_action();

        redirect(base_url() . "index.php?/utilities/helpText");
    }

    function lan_help() {
          error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
       
        $return['language'] = $this->utilmodal->get_lan_hlpText1();
        $return['pagename'] = "utilities/hlp_language";
//        print_r($return);die;
        $this->load->view("company", $return);
    }

    function lan_action($param = '') {
        error_reporting(0);
        if($param == 'del'){
            $this->load->library('mongo_db');
            $this->mongo_db->delete('lang_hlp',array('lan_id' => (int)$this->input->post('id')));
            echo json_encode(array('msg' => '1'));die;
       }
        $this->utilmodal->lan_action();
    }
    
      public function enable_lang() {
           error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->utilmodal->enable_lang();
    }
    
      public function disable_lang() {
           error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->utilmodal->disable_lang();
    }

    function cancellation() {
        
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->utilmodal->get_lan_hlpText();
        $return['reasons'] = $this->utilmodal->get_can_reasons();
        $return['pagename'] = "utilities/cancell_reasons";
        $this->load->view("company", $return);
    }

    function cancell_act($param = '') {
        error_reporting(0);
        if ($param == 'del') {
            $this->load->library('mongo_db');
            $this->mongo_db->delete('can_reason', array('res_id' => (int) $this->input->post('id')));
            echo json_encode(array('msg' => '1'));
            die;
        }
        $this->utilmodal->cancell_act();
    }
    
    function gaurantee() {
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['gaurantee'] = $this->utilmodal->get_gaurantee();
        $return['pagename'] = "utilities/gaurantee";
        $this->load->view("company", $return);
    }
    
    function get_gaurantee($param = '') {
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data = $this->utilmodal->get_gaurantee($param);
        echo json_encode(array('msg' => '1', 'data' => $data));
        die;
    }

    function gaurantee_act($param = '') {
        error_reporting(0);
        if ($param == 'del') {
            $this->load->library('mongo_db');
            $this->mongo_db->delete('gaurantee', array('_id' => new MongoId($this->input->post('id'))));
            echo json_encode(array('msg' => '1'));
            die;
        }
        $this->utilmodal->gaurantee_act();
    }

    public function supportText() {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['language'] = $this->utilmodal->get_lan_hlpText();
        $return['suppText'] = $this->utilmodal->get_cat_support();
   
        $return['pagename'] = "utilities/supportText";
        $this->load->view("company", $return);
    }
     public function getDescription($cat_id = '') {
       
//        if ($this->session->userdata('table') != 'company_info') {
//            redirect(base_url());
//        }
        error_reporting(0);
        $return['desc'] = $this->utilmodal->getDescription($cat_id);
     
        $this->load->view("utilities/description", $return);
    }
    
     public function getsubDescription($cat_id = '', $subcatID = '') {
       
//        if ($this->session->userdata('table') != 'company_info') {
//            redirect(base_url());
//        }
        error_reporting(0);
        $return['desc'] = $this->utilmodal->getsubDescription($cat_id,$subcatID);
       
      
        $this->load->view("utilities/subdescription", $return);
    }

    function support_cat($param2 = '', $param = '') {
       
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->utilmodal->get_lan_hlpText();
        $return['group'] = $this->utilmodal->get_grp_hlpText();
        $return['helpText'] = '';
        if ($param2 == 0) {
            $return['edit_id'] = '';
            $return['cat_id'] = $param;
            $return['helpText'] = $this->utilmodal->get_cat_support($param, 'add');
        } else {
            
        }

        $return['pagename'] = "utilities/add_support_cat";
        $this->load->view("company", $return);
    }

    function support_edit($param = '', $param2 = '') {
       
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['language'] = $this->utilmodal->get_lan_hlpText();
        $data['group'] = $this->utilmodal->get_grp_hlpText();
        if($param2 == ''){
        $data['edit_id'] = $param;
        $data['scat_id'] = $param2;
        }else{
        }
        $data['helpText'] = $this->utilmodal->get_cat_support($param);
        
        $data['pagename'] = "utilities/edit_support_text";
        $this->load->view("company", $data);
    }

    function get_subcat_support() {
        error_reporting(0);
        $this->load->library('mongo_db');
//        $res = $this->mongo_db->get_one('support_txt', array('cat_id' => (int) $this->input->post('cat_id')));
        $res = $this->mongo_db->where(array('cat_id' => (int) $this->input->post('cat_id')))->find_one('support_txt'); 

        echo json_encode($res);
    }

    function support_action($param = '', $param2 = '') {
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        
          $this->load->library('mongo_db');
        if ($param == 'del') {
            
            if ($param2 == '') {
             $this->mongo_db->where(array('cat_id' =>(int)$this->input->post('id')))->delete('support_txt');              
             echo json_encode(array('msg' => '1'));
             die;
            }
            
        }else if($param == 'subdel'){
            if ($param2 == '') {
                 $this->mongo_db->where(array('sub_cat.id' =>new MongoDB\BSON\ObjectId($this->input->post('id'))))->pull('sub_cat',array('id' =>new MongoDB\BSON\ObjectId($this->input->post('id'))))->update('support_txt');
                 echo json_encode(array('msg' => '1'));
                die;
            }
            
        }
        else{
        $return['language'] = $this->utilmodal->support_action();
        }
        redirect(base_url() . "index.php?/utilities/supportText");
    }
    
    
}
