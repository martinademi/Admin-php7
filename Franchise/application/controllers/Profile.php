<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("Profilemodel");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
      //  $this->lang->load('headerNav_lang',$language);
        $this->lang->load('franchiseProfile_lang',$language);
       

        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function profile() {
        if ($this->issessionset()) {

            $data['ProfileData'] = $this->Profilemodel->getProfileData($this->session->userdata('fadmin')['MasterBizId']);
            $data['Admin'] = $this->session->userdata('fadmin')['Admin'];
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['language'] = $this->Profilemodel->get_lan_hlpText();
            $data['CountryList'] = $this->Profilemodel->GetCountryCities();
            $data['category'] = $this->Profilemodel->getAllCategories();
            $data['SubCats'] = $this->Profilemodel->getAllsubCategories();
            $data['pagename'] = "Profile/MyProfile";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else{
            redirect(base_url() . "index.php?/Franchise");
        }
        
    }
    
    public function getSubcatList() {
        $this->Profilemodel->getSubcatList();
    }
    
     public function get_city() {
        $data = $this->Profilemodel->get_city();
        print_r($data);
    }
     public function getZones() {
        $this->Profilemodel->getZonesWithCities();
    }

  function issessionset() {
        if ($this->session->userdata('fadmin')['MasterBizId']) {
            return true;
        }
        return false;
    }
    public function getCityList() {

        $this->Profilemodel->getCityList();
    }
    
// Upload images on amazon
    public function uploadImagesToAws(){
        
        $this->Profilemodel->uploadImageToAmazone();
    }
    
    public function UpdateProfile() {
         $this->load->model("Franchisemodal");
        $this->Profilemodel->UpdateProfile();
        $this->Franchisemodal->updateSession($this->input->post("BusinessId"));
        redirect(base_url() . "index.php?/Profile/profile");
    }

}
