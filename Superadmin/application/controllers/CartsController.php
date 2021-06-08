<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CartsController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->library('session');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
$this->lang->load('header_lang',$language); 
        // $this->load->model("Citymodal");
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        header('Access-Control-Allow-Origin: *');
    }
    
    public function index() {
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
        // $this->table->set_heading('SLNO','CART ID','CUSTOMER NAME','FRANCHISE NAME', 'STORE NAME','CITY','CART CAEGORY','CREATED', 'CART TOTAL', 'CART ACTIONS', 'STATUS', 'LAST ACTIVE ON');

        $this->table->set_heading('SLNO','CART ID','CUSTOMER NAME','FRANCHISE NAME', 'STORE NAME','CITY','ORDER CATEGORY','CREATED ON','CART VALUE','STATUS', 'CART ACTIONS');
        $data['pagename'] = "cart/carts";
        $this->load->view("company", $data);
    }
    
    public function datatable_carts($stDate = '',$endDate= '') {      
        $this->load->model('CartsModal');
        $this->CartsModal->datatable_carts($stDate,$endDate);
    }
    public function datatableActionDetails($cartId) {      
        $this->load->model('CartsModal');
        $this->CartsModal->datatableActionDetails($cartId);
    }
    public function datatableCartDetails($cartId) {      
        $this->load->model('CartsModal');
        $this->CartsModal->datatableCartDetails($cartId);
    }

    public function getCartDetails($params){
         $this->load->library('table');
         $this->load->library('Datatables');
        $data['cartId'] = $params;
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
        $this->table->set_heading('SLNO','STORE NAME','CUSTOMER NAME','ITEM NAME', 'QUANTITY','UNIT PRICE','TOTAL');
        $data['pagename'] = "cart/cartDetails";
        $this->load->view("company", $data);
    }
    public function getCartDetailsData($params){
         $this->load->model('CartsModal');
         $this->load->library('table');
         $this->load->library('Datatables');
        $data['cartId'] = $params;
         $data['cartDetails'] = $this->CartsModal->getCompleteCartDetails($params);  
        $data['pagename'] = "cart/cartInfo";
        $this->load->view("company", $data);
    }
    public function getActionDetails($params){
        $this->load->library('table');
         $this->load->library('Datatables');
        $data['cartId'] = $params;
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
        // $this->table->set_heading('SLNO','STORE NAME','ITEM NAME', 'QUANTITY','UNIT PRICE','TOTAL','ACTION BY','ACTOR NAME','ACTION','ACTION TIME');
        $this->table->set_heading('SLNO','STORE NAME','ITEM NAME', 'OPEN QUANTITY','CLOSE QUANTITY','UNIT PRICE','FINAL VALUE','ACTION BY','ACTOR NAME','ACTION','ACTION TIME');
        $data['pagename'] = "cart/cartsAction";
        $this->load->view("company", $data);

         
    }
    
     
    
    
}

