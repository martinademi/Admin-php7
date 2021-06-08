<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class WebsitePages extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model("WebsitePagesmodal");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        $this->lang->load('websitePages_lang', $language);

        $this->lang->load('topnav_lang', $language);

        // Load form helper library
        $this->load->helper('form');

        // Load form validation library
        $this->load->library('form_validation');
        // $this->load->model("superModel/Logout");

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    function termsAndConditions() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['languages'] = $this->WebsitePagesmodal->getLanguages();
        $data['pagename'] = 'websitePages/termsAndConditions/index';
        $this->load->view("company", $data);
    }

    function privacyPolicy() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['languages'] = $this->WebsitePagesmodal->getLanguages();
        $data['pagename'] = 'websitePages/privacyPolicy/index';
        $this->load->view("company", $data);
    }

    public function getTermsAndConditions() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->WebsitePagesmodal->getTermsAndConditions();
    }

    public function getPrivacyPolicy() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->WebsitePagesmodal->getPrivacyPolicy();
    }
    public function aboutUs() {
        $data['pagename'] = 'aboutUs/index';
        $this->load->view("company", $data);
    }
    public function updateTermsAndCondition() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->WebsitePagesmodal->updateTermsAndCondition();
        redirect(base_url() . "index.php?/websitePages/termsAndConditions");
    }

    public function updateAboutUs() {
        $this->WebsitePagesmodal->updateAboutUs();
//        redirect(base_url() . "index.php?/WebsitePages/aboutUs");
    }

    public function getAboutUsData() {
        $this->WebsitePagesmodal->getAboutUsData();
    }

    public function updatePrivacyPolicy() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->WebsitePagesmodal->updatePrivacyPolicy();
        redirect(base_url() . "index.php?/websitePages/privacyPolicy");
    }

    function Logout() {

        $this->session->sess_destroy();
        redirect(base_url() . "index.php?/Home");
    }

    function providerReview() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $this->load->model("Superadminmodal");
        $data['driver_review'] = $this->Superadminmodal->driver_review($status);
        $this->load->library('Datatables');
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;">',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );
        $this->table->set_template($tmpl);
        $this->table->set_heading('BOOKING ID', 'BOOKING DATE AND TIME', 'PROVIDER NAME', 'CUSTOMER NAME', 'REVIEW', 'RATING', 'SHOW IN WEBSITE');
        $data['pagename'] = 'websitePages/reviewAndRating/providerReview';
        $data['citiesData'] = $this->WebsitePagesmodal->getCityList();
        $this->load->view("company", $data);
    }

    function datatable_driverreview($param = '', $cityId = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->WebsitePagesmodal->datatable_driverreview($param, $cityId);
    }

    function customerReview() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $this->load->model("Superadminmodal");
        $data['driver_review'] = $this->Superadminmodal->driver_review($status);
        $this->load->library('Datatables');
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;">',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );
        $this->table->set_template($tmpl);
        $this->table->set_heading('BOOKING ID', 'BOOKING DATE AND TIME', 'PROVIDER NAME', 'CUSTOMER NAME', 'REVIEW', 'RATING', 'SHOW IN WEBSITE');
        $data['pagename'] = 'websitePages/reviewAndRating/customerReview';
        $data['citiesData'] = $this->WebsitePagesmodal->getCityList();
        $this->load->view("company", $data);
    }

    function datatable_Customerreview($param, $cityId) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->WebsitePagesmodal->datatable_customerReview($param, $cityId);
    }

    function viewWebsiteUpadateCustomer() {
        $this->WebsitePagesmodal->viewWebsiteUpadateCustomer();
    }

    function viewWebsiteUpadateProvider() {
        $this->WebsitePagesmodal->viewWebsiteUpadateProvider();
    }

}
