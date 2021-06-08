<?php

// testing
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class parametersController extends CI_Controller {
  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model('Parametersmodal');
        
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        $this->lang->load('param_lang', $language);
        
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
       public function index($status = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        
        $data['language'] = $this->Parametersmodal->getlanguageText();
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
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_Name'),$this->lang->line('col_Associated'),'Store Type',$this->lang->line('col_Actions'),$checkbox);
    
        $data['pagename'] = "Parameters/parameters";
        $this->load->view("company", $data);
    }
    
    public function driver_review($status = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        
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
      //  $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_bookingId'),$this->lang->line('col_dateAndTime'),$this->lang->line('col_rating'),$this->lang->line('col_customerName'),$this->lang->line('col_driverName'),$this->lang->line('col_store'));
      $this->table->set_heading("SL No.","Driver Name","Orders Served","Average Rating");
        
        $data['pagename'] = "Parameters/driverReview";
        $this->load->view("company", $data);
    }
	 public function datatable_driverreview($status ='') {

        $this->Parametersmodal->datatable_driverreview($status);
    }
    public function datatable_orderreview($status ='') {

        $this->Parametersmodal->datatable_orderreview($status);
    }

    public function datatable_customerreview($status ='') {

        $this->Parametersmodal->datatable_customerreview($status);
    }


    public function customer_review($status = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        
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
        // $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_bookingId'),$this->lang->line('col_dateAndTime'),$this->lang->line('col_customerName'),$this->lang->line('col_driverName'),$this->lang->line('col_review'),$this->lang->line('col_rating'));
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_customerName'),'Mobile No.','No. of Order',$this->lang->line('col_rating'));
    
        $data['pagename'] = "Parameters/customerReview";
        $this->load->view("company", $data);
    }

    // rating on each order ID
    public function rating_details($driverId) {
        $this->load->library('Datatables');
        $this->load->library('table');
        
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
        $this->table->set_heading($this->lang->line('col_sino'),"ORDER ID",$this->lang->line('col_dateAndTime'),"RATING",$this->lang->line('col_customerName'),$this->lang->line('col_driverName'),$this->lang->line('col_store'));
      //$this->table->set_heading("SL No.","Driver Name","Orders Served","Average Rating");
        
        $attr=$this->Parametersmodal->driverAttr();
        $data['driverAttr']=$attr;
        $orderTabId = "";
        foreach($attr[0]["_id"] as $id){
           $orderTabId = $id;
        }
        $data['pagename'] = "Parameters/driverReviewDetails";
        $data['driverId'] = $driverId;
        $data['orderTabId'] = $orderTabId;
        $driverName=$this->Parametersmodal->driverName($driverId);
        $data['driverName']=$driverName[0]['firstName'].' '.$driverName[0]['lastName'];
        $this->load->view("company", $data);
    }

     // rating on each order ID
     public function cutomerrating_details($driverId) {
        $this->load->library('Datatables');
        $this->load->library('table');
        
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
        // $this->table->set_heading($this->lang->line('col_sino'),"ORDER ID",$this->lang->line('col_dateAndTime'),"RATING",$this->lang->line('col_customerName'),$this->lang->line('col_driverName'),$this->lang->line('col_store'));
        $this->table->set_heading($this->lang->line('col_sino'),"ORDER ID",$this->lang->line('col_dateAndTime'),"RATING",$this->lang->line('col_customerName'),$this->lang->line('col_driverName'));
        $data['pagename'] = "Parameters/customerReviewDetails";
        $data['driverId'] = $driverId;
        $customerName=$this->Parametersmodal->customerName($driverId);
        $data['customerName']=$customerName[0]['name'];
        // echo '<pre>';print_r($customerName[0]['name']);die;
        $this->load->view("company", $data);
    }

    // datatable method for rating details
    public function datatable_driverreviewdetails($status ='',$drivertabId='') {

      
        $this->Parametersmodal->datatable_driverreviewdetails($status,$drivertabId);
    }

     // datatable method for rating details
     public function datatable_customerreviewdetails($status ='',$drivertabId='') {

      
        $this->Parametersmodal->datatable_customerreviewdetails($status,$drivertabId);
    }


    
    public function order_review($status = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        
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
       // $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_bookingId'),$this->lang->line('col_dateAndTime'),$this->lang->line('col_customerName'),$this->lang->line('col_driverName'),$this->lang->line('col_review'),$this->lang->line('col_rating'),$this->lang->line('col_store'));
       $this->table->set_heading("SL NO.","STORE NAME","ORDER COMPLETED","AVERAGE RATING");
        $data['pagename'] = "Parameters/orderReview";
        $this->load->view("company", $data);
    }
    // orderwise store rating
    public function orderRating_details($storeId) {
        $this->load->library('Datatables');
        $this->load->library('table');
        
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
        $this->table->set_heading($this->lang->line('col_sino'),"ORDER ID",$this->lang->line('col_dateAndTime'),"RATING",$this->lang->line('col_customerName'),$this->lang->line('col_driverName'),"ORDER VALUE");
      //$this->table->set_heading("SL No.","Driver Name","Orders Served","Average Rating");
        
        $data['pagename'] = "Parameters/orderReviewDetails";
        $data['storeId'] = $storeId;

        $storeName=$this->Parametersmodal->storeName($storeId);
        //echo '<pre>';print_r($storeName[0]['sName']['en']);die;
         $data['storeName']=$storeName[0]['sName']['en'];
       
        $this->load->view("company", $data);
    }
    
     // datatable method for rating details
     public function datatable_orderreviewdetails($storeId = '') {

        $this->Parametersmodal->datatable_orderreviewdetails($storeId);
    }
    public function datatable_parameters($status) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Parametersmodal->datatable_parameters($status);
    }

    public function insert_param() {
        $this->Parametersmodal->insert_param();
    }

    public function getparams() {

        $data[] = $this->Parametersmodal->getparams();
        echo json_encode($data);
    }
    public function getparam() {

        $data[] = $this->Parametersmodal->getparam();
        echo json_encode($data);
    }

    public function editparams() {
       
        $this->Parametersmodal->editparams();
    }

    public function deleteparams() {

        $data = $this->Parametersmodal->deleteparams();
    }

    public function hideparams() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Parametersmodal->hideparams();
    }

    public function unhideparams() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Parametersmodal->unhideparams();
    }
    
    public function driverRating($id) {
//        print_r($id); die;

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['appConfig'] = $this->Parametersmodal->getConfigOne($id);
        $data['language'] = $this->Parametersmodal->getlanguageText();
        $data['parameterId'] = $id;
        $data['pagename'] = "Parameters/driverRatingNew";
        $this->load->view("company", $data);
    }
    
    public function updateDriverRating() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $id = $this->input->post('parameterId');
        $this->Parametersmodal->updateDriverRating($id);
        redirect(base_url() . "index.php?/parametersController/driverRating/".$id);
    }
    
    
    function Logout() {

        $this->session->sess_destroy();
        redirect(base_url() . "index.php?");
    }

   
    
}
