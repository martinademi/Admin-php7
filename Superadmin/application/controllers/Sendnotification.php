<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Sendnotification extends CI_Controller {
/**
* This controller is used for send the notifiaction to the user.
**/
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
	   
       $this->lang->load('sendNotification_lang',$language);
      //  $this->load->model("Home_m");
        
        $this->load->model("Sendnotification_m");
        $this->load->library('CallAPI');
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

    }
       public function index() {    
        $this->load->library('Datatables');
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr role="row">',
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

        $this->table->set_heading($this->lang->line('col_notication_type'), $this->lang->line('col_date'), $this->lang->line('title'), $this->lang->line('message'));
        $data['pagename'] = "notification/index";
        $this->load->view("company", $data);
    }

  public function datatable_getPushDetails($userType = ''){
      
    //  if ($this->session->userdata('table') != 'company_info') {
        //    $this->Logout();
        //}

        $this->Sendnotification_m->datatable_getPushDetails($userType);
  }
   
  public function getDriversBySerach(){
      
     // if ($this->session->userdata('table') != 'company_info') {
       //     $this->Logout();
       // }

        $this->Sendnotification_m->getDriversBySerach();
  }
  public function getCustomersBySerach(){
      
      //if ($this->session->userdata('table') != 'company_info') {
      //      $this->Logout();
       // }

        $this->Sendnotification_m->getCustomersBySerach();
  }
  public function getStoreManagerBySerach(){
      
    //if ($this->session->userdata('table') != 'company_info') {
    //      $this->Logout();
    //  }

      $this->Sendnotification_m->getStoreManagerBySerach();
}
   public function getCities(){
      
     // if ($this->session->userdata('table') != 'company_info') {
    //        $this->Logout();
    //    }

        $this->Sendnotification_m->getCities();
  }

}
