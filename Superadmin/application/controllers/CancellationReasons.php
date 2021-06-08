<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CancellationReasons extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model('Cancellationmodal');
        $this->load->library('session');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
$this->lang->load('header_lang',$language); 
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
  
    
    
     public function datatable_canreasonCustomer() {
        $this->Cancellationmodal->datatable_canreasonCustomer(); 
    }
    
    
      public function datatable_canreasonDriver() {
        $this->Cancellationmodal->datatable_canreasonDriver(); 
    }
    
      public function datatable_canreasonDispatcher() {
        $this->Cancellationmodal->datatable_canreasonDispatcher(); 
    }
    
     function get_lan_hlpText($param = ''){
          $this->Cancellationmodal->get_lan_hlpTextone($param); 
     }
     
     function get_lan_hlpTextone($param = ''){
          $this->Cancellationmodal->get_lan_hlpTextone($param); 
     }

  
     
    function cancellation() {
        
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->Cancellationmodal->get_lan_hlpText();
        $return['reasons'] = $this->Cancellationmodal->get_can_reasons();
        $return['pagename'] = "Cancellation/cancell_reasons";
        $this->load->view("company", $return);
    }
    
    function cancellationCustomer() {
        
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
            $this->load->library('Datatables');
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 0px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;">',
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


        $this->table->set_heading('SL NO.','REASONS','SELECT');
        $return['language'] = $this->Cancellationmodal->get_lan_hlpText();
        $return['reasons'] = $this->Cancellationmodal->get_can_reasons();
        $return['pagename'] = "Cancellation/cancell_reasonsCustomer";
        $this->load->view("company", $return);
    }
    
    function cancellationDriver() {
        
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
            $this->load->library('Datatables');
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 0px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;">',
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


        $this->table->set_heading('SL NO.','REASONS','SELECT');
        $return['language'] = $this->Cancellationmodal->get_lan_hlpText();
        $return['reasons'] = $this->Cancellationmodal->get_can_reasons();
        $return['pagename'] = "Cancellation/cancell_reasonsDriver";
        $this->load->view("company", $return);
    }

     function cancellationDispatcher() {
        
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
         $this->load->library('Datatables');
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 0px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;">',
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


        $this->table->set_heading('SL NO.','REASONS','SELECT');
        $return['language'] = $this->Cancellationmodal->get_lan_hlpText();
        $return['reasons'] = $this->Cancellationmodal->get_can_reasons();
        $return['pagename'] = "Cancellation/cancell_reasonsDispatcher";
        $this->load->view("company", $return);
    }
    function cancell_act($param = '') {
        error_reporting(0);
        if ($param == 'del') {
           $this->Cancellationmodal->deleteCan();  

        }else{
        $this->Cancellationmodal->cancell_act();
        }
    }
    function getCanData(){
         $this->Cancellationmodal->getCanData();  
    }
    
  
}
