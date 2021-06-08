<?php
error_reporting(E_ALL);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// error_reporting(false);

class EstimateController extends CI_Controller {

	    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->model('Estimatemodel');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
$this->lang->load('header_lang',$language); 
       
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index($status=''){

        $this->load->library('Datatables');
        $this->load->library('table');

      
        $tmpl = array('table_open' => '<table id="campaigns-datatable" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="promotableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
           'heading_row_start' => '<tr style= "font-size:12px"role="row">',
           'heading_row_end' => '</tr>',
           'heading_cell_start' => ' <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:12px;">',
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
    //    $this->table->set_heading('SL No','ESTIMATE-ID' ,'CART ID' ,'ORDER VALUE' ,  'CUSTOMER NAME' ,  'DELIVERY FEE' , 'DATE/TIME');

       $this->table->set_heading('SL No','ID','DATE/TIME','CART ID','CART VALUE','CUSTOMER NAME' ,'ORDER CATEGORY','DELIVERY FEE');

       $data['pagename'] = 'estimate/estimateList';
       $data['status'] = $status;
       $this->load->view("company", $data);
     
    }

    

    public function get_estimateList(){

        $this->Estimatemodel->get_estimateList();

    }

    public function getCustomerinfo($custId){

        $cusInfo=$this->Estimatemodel->getCustomerInfo($custId);
    }




}