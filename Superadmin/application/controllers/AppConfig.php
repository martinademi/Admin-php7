<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//echo 1;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class AppConfig extends CI_Controller {

  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language); 
        $this->lang->load('appconfig_lang', $language);
        $this->lang->load('topnav_lang', $language);
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    public function index(){
        
    }
    public function app_config() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['appConfigData'] = $this->AppConfigModel->getAppConfig();

        $data['pagename'] = 'app_confi';
        $this->load->view("company", $data);
    }

 
   
    
}
