<?php

error_reporting(false);

class ContactUsCity extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        // $this->load->helper('url');
        // $this->load->library('session');
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->load->model("ContactUsCitymodal");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        $this->lang->load('paymentGateways_lang', $language);
        $this->lang->load('topnav_lang', $language);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index() {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" class="table table-hover demo-table-search">',
            'heading_row_start' => '<tr role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
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
        $this->table->set_heading("Title of Office","phone", "Address", "City", "State", "Zipcode", "Select");
        $data['pagename'] = "contactUs/index";
        $this->load->view("company", $data);
    }

    public function datatable_ContactUsCity() {
        $this->ContactUsCitymodal->datatable_ContactUsCity();
    }

    public function operations($operation = '') {
        switch ($operation) {
            case 'insert':$this->ContactUsCitymodal->insert();
                break;
            case 'get':$this->ContactUsCitymodal->get();
                break;

            case 'update':$this->ContactUsCitymodal->update();
                break;
            case 'delete':$this->ContactUsCitymodal->delete();
                break;
        }
    }

    public function aboutUs() {        
        $data['pagename'] = "websitePages/aboutUs";
        $this->load->view("company", $data);
    }
    function Logout() {

        $this->session->sess_destroy();
        redirect(base_url() . "index.php?/superadmin");
    }
}
