<?php

// testing
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Voucher extends CI_Controller {
  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model('VoucherModel');
        
         $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('voucher_lang', $language);
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
       public function index($status = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        
        $data['language'] = $this->VoucherModel->getlanguageText();
        
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:12px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:12px;">',
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
        $checkbox=' <input type="checkbox" id="select_all" />';
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_Name'),$this->lang->line('col_createdon'),$this->lang->line('col_noofcoupon'),$this->lang->line('col_Value'),$this->lang->line('col_redeemed'),'Expiry Date',$checkbox);
    
        $data['pagename'] = "marketing/voucher";
        $this->load->view("company", $data);
    }
    
     public function voucher_details($timeOffset = '',$status= '') {
         
        $this->VoucherModel->voucher_details($timeOffset,$status);
    }


    public function updatecouponCodeStatus(){
        $offerIds = $this->input->post("offerId");
        $status   = $this->input->post("status");
        $response = $this->VoucherModel->updateOfferStatus($status, $offerIds);
        echo json_encode(array('msg' => $response));
      }
    
     public function addVoucher() {
        $this->VoucherModel->addVoucher();
    }
    public function couponDetails($id,$voucherName){
       
        $this->load->library('Datatables');
        $this->load->library('table');
        
        $data['language'] = $this->VoucherModel->getlanguageText();
        
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:12px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:12px;">',
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
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_Name'),$this->lang->line('col_Status'));
        $data['id'] = $id;
        $data['voucherName'] = $voucherName;
        $data['pagename'] = "marketing/particularVoucher";
        $this->load->view("company", $data);
    }
    public function redeemDetails($id,$voucherName){
       
        $this->load->library('Datatables');
        $this->load->library('table');
        
        $data['language'] = $this->VoucherModel->getlanguageText();
        
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:12px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:12px;">',
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
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_Name'),$this->lang->line('col_redeemedBy'),$this->lang->line('col_redeemedDate'));
        $data['id'] = $id;
        $data['voucherName'] = $voucherName;
        $data['pagename'] = "marketing/redeemVoucher";
        $this->load->view("company", $data);
    }
    public function getCouponDetails($id){
         $this->VoucherModel->getCouponDetails($id);
    }
    public function getRedeemDetails($id){
        $this->VoucherModel->getRedeemDetails($id);
   }
    
}
