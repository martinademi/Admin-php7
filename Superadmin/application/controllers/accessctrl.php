<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class accessctrl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model("aceessmodal");
        $this->load->library('session');
        $this->load->database();
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
//        $this->load->library('excel');
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
    public function manageRole() {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }

        $return['roles'] = $this->aceessmodal->get_roles();
        $return['users'] = $this->aceessmodal->get_users();
//        $return['cities'] = $this->aceessmodal->get_cities();
        error_reporting(0);


        $return['pagename'] = "manageRole";
        $this->load->view("company", $return);
    }
    
    function role_action($param = '') {
        error_reporting(0);
        if ($param == 'del') {
            $this->load->library('mongo_db');
            $this->mongo_db->delete('admin_roles', array('_id' => new MongoId($this->db->escape_str($this->input->post('id')))));
            $this->mongo_db->delete('admin_users', array('role' => $this->db->escape_str($this->input->post('id'))));
            echo json_encode(array('msg' => '1'));
            die;
        }
        $this->aceessmodal->role_action();
    }
    
    function user_action($param = '') {
        error_reporting(0);
        if ($param == 'del') {
            $this->load->library('mongo_db');
            $this->mongo_db->delete('admin_users', array('_id' => new MongoId($this->db->escape_str($this->input->post('id')))));
            echo json_encode(array('msg' => '1'));
            die;
        }
        $this->aceessmodal->user_action();
    }
    
    function Reports($param = '') {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        
        redirect(base_url()."../reports");
    }

}
