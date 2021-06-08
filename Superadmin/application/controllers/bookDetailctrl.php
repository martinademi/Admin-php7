<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class bookDetailctrl extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model("bookdetailmodal");
        $this->load->library('session');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
$this->lang->load('header_lang',$language); 
//        $this->load->library('excel');
        header('Access-Control-Allow-Origin: *');
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    function addInfo() {
        $data = $this->bookdetailmodal->updateinfo();
        echo json_encode($data);
    }

    function getInfo() {
        $this->bookdetailmodal->getbookinginfo();
    }
}
