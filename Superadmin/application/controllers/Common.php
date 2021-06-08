<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Class Common extends CI_Controller {

    public function __construct() {
        
        parent::__construct();
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
$this->lang->load('header_lang',$language); 
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        $this->load->helper('url');

        $this->load->library('session');
        $this->load->model('Commonutilitymodel');
    }

    public function callUtility_services($param) {
        $this->load->library('utility_library');
        $type = $this->input->post('type');
        $folderName = $this->input->post('foldername');
        $pre = $this->input->post('Image');
//       $subject = $this->input->post();
//       $from =  $this->input->post();
//       $to =  $this->input->post();
//       $temp = $this->input->post();

        switch ($type) {

            case 'uploadImage':
                $result =  $this->utility_library->uploadImage($param, $pre, $folderName);
                break;

            case 'sendMail':
                $result = $this->utility_library->sendMail($temp, $to, $from, $subject);
                return $result;
                break;
        }
        echo json_encode($result);
    }
    
    public function Logout( $loginerrormsg = NULL) {
        
        $this->session->sess_destroy();
        $data['loginerrormsg'] = $loginerrormsg;

        $this->load->view('Login/login', $data);
//        redirect(base_url());
    }
     public function uploadImagesToAws(){
         $type = $this->input->post('type');
        $folderName = $this->input->post('folder');
        $pre = $this->input->post('Image');
        
        $this->Commonutilitymodel->uploadImageToAmazone();
    }
    public function uploadPDFToAws(){
        $type = $this->input->post('type');
       $folderName = $this->input->post('folder');
       $pre = $this->input->post('Image');
       
       $this->Commonutilitymodel->uploadPDFToAmazone();
   }
	
}
