<?php

// testing
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class policyController extends CI_Controller {
  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model('Policymodal');
        
         $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
         $this->lang->load('header_lang',$language);
         $this->lang->load('policy_lang', $language);
      
        
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
    public function terms($params = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        $data['language'] = $this->Policymodal->getlanguageText();
        $data['allData'] = $this->Policymodal->gettermsdata($params);
        if($params == 'customer'){
            $data['pagename'] = "AppWebPages/cterms";
        }else if($params == 'driver'){
            $data['pagename'] = "AppWebPages/dterms";
        }
        else if($params == 'website'){
            $data['pagename'] = "AppWebPages/websiteTerms";
        }
        else if($params == 'store'){
            $data['pagename'] = "AppWebPages/storeTerms";
        }
        
        $this->load->view("company", $data);
    }
    
     public function update_terms() {
        $this->Policymodal->update_terms();
    }
    public function website_update_terms() {
        $this->Policymodal->website_update_terms();
    }
    public function store_update_terms() {
        $this->Policymodal->store_update_terms();
    }
     public function update_dterms() {
        $this->Policymodal->update_dterms();
    }
    
    public function privacy($params = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        $data['language'] = $this->Policymodal->getlanguageText();
        $data['allData'] = $this->Policymodal->gettermsdata($params);
        if($params == 'customer'){
            $data['pagename'] = "AppWebPages/cprivacy";
        }else if($params == 'driver'){
            $data['pagename'] = "AppWebPages/dprivacy";
        }
        else if($params == 'website'){
            $data['pagename'] = "AppWebPages/website_privacy";
        }
        else if($params == 'store'){
            $data['pagename'] = "AppWebPages/store_privacy";
        }
        
        $this->load->view("company", $data);
    }
    
     public function update_cprivacy() {
        $this->Policymodal->update_cprivacy();
    }
    public function website_update_privacy() {
        $this->Policymodal->website_update_privacy();
    }
    public function store_update_privacy() {
        $this->Policymodal->store_update_privacy();
    }
     public function update_dprivacy() {
        $this->Policymodal->update_dprivacy();
    }
     public function getBrand($id = '') {
        $data1 = $this->Brandsmodal->getBrand($id);
        echo json_encode(array('data' => $data1));
    }
     public function editBrand() {
        $this->Brandsmodal->editBrand();
    }
     public function activateBrand() {
        $this->Brandsmodal->activateBrand();
    }
     public function deactivateBrand() {
        $this->Brandsmodal->deactivateBrand();
    }
   
    
}
