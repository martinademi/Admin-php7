<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supporttext extends CI_Controller {

    public function __construct() {

        parent::__construct();
        error_reporting(0);
        $this->load->library('mongo_db');
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->helper('security');
        $this->load->model("Supporttextmodal");
        $this->load->library('session');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
    }

    public function index() {
        
       
    }
    
    public function viewDescription($id = '',$subid = '')
    {
            $data['desc'] = $this->Supporttextmodal->viewDescription($id,$subid);
         
            $this->load->view('SupportText/SupportTextDescription', $data);
    }

}
