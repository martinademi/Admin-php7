<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model("WelcomeModel");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

    }
        public function customerVerification(){
          if ($this->session->userdata('table') != 'company_info') {
             $this->Logout();
          }
           $this->load->library('Datatables');
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => ' <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;">',
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
       
          $this->table->set_heading('EMAIL','MOBILE','CODE','DATE');
    
        $data['pagename'] = 'customerVerification';
        $this->load->view("company", $data);
        }
          public function dt_customerVerification() {
              if ($this->session->userdata('table') != 'company_info') {
             $this->Logout();
             }
               $data = $this->WelcomeModel->dt_customerVerification();
          }
           public function datatable_dispatcher($status) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->WelcomeModel->datatable_dispatcher($status);
    }
     public function dispatched($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['city'] = $this->WelcomeModel->city_get();
        $data['getdata'] = $this->WelcomeModel->get_dispatchers_data($status);

        $this->load->library('Datatables');
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;font-size:12px">',
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

        $this->table->set_heading( 'CITY', 'DISPATCHER NAME', 'EMAIL','LAST LOGIN DATE', 'OPTION');




        $data['pagename'] = "dispatched";

        $this->load->view("company", $data);
    }
     public function inactivedispatchers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->WelcomeModel->inactivedispatchers();
    }

    public function activedispatchers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->WelcomeModel->activedispatchers();
    }
     public function insertdispatches() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->WelcomeModel->insertdispatches();
    }
    public function getDispatcerData() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->WelcomeModel->getDispatcerData();
    }
     public function editdispatchers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

//        $data['city'] = $this->WelcomeModel->city();
        $data = $this->WelcomeModel->editdispatchers();
    }
     public function cityAdd() {
        
       $data = $this->WelcomeModel->cityAdd();
    }
    public function deletedispatchers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->WelcomeModel->deletedispatchers();
    }

}
