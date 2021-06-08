<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Language extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('language');
        $this->load->library('session');

        

    }

    public function index($lang) {
        $data = array('lang' => $lang);
        $this->session->set_userdata($data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    function Logout() {
        $this->session->sess_destroy();
        redirect(base_url() . "index.php?/Home");
    }

}
