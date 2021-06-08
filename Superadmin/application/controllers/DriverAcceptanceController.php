<?php
error_reporting(E_ALL);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// error_reporting(false);

class DriverAcceptanceController extends CI_Controller {

	    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->model('DriverAcceptancemodel');
       
       

        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
$this->lang->load('header_lang',$language); 
$this->lang->load('driverAcceptanceRate_lang', $language);
       
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
       $this->table->set_heading('SL No','DRIVER NAME' ,'DRIVER PHONE' ,'DRIVER EMAIL' ,  'TYPE' ,  'TOTAL BOOKINGS' , 'TOTAL ACCEPTED','TOTAL REJECTED','TOTAL CANCELLED','TOTAL IGNORED','ACCEPTANCE RATE');
       $data['pagename'] = 'driveracceptance/driverAcceptanceList';
       $data['status'] = $status;
       $this->load->view("company", $data);
     
    }

    public function get_driverList(){

        $this->DriverAcceptancemodel->get_driverList();

    }

    public function getDriverinfo($driverId){

        $this->DriverAcceptancemodel->getDriverinfo($driverId);

    }

    public function bookingDetails($type = '',$driverID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        
        $data['type'] = $type;
        $data['driverID'] = $driverID;
        $data['driverData'] = $this->DriverAcceptancemodel->getDriverData($driverID);
        
        $data['pagename'] = "driveracceptance/bookings";
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
        $this->table->set_heading($this->lang->line('col_booking_id'),$this->lang->line('col_customer_name'),$this->lang->line('col_customer_phone'),$this->lang->line('col_received_on'),$this->lang->line('col_accepted_on'),$this->lang->line('col_rejected_on'),$this->lang->line('col_cancelled_on'),$this->lang->line('col_ignored_on'),$this->lang->line('col_status'));
        $this->load->view("company", $data);
    }

    public function datatable_bookingDetails($type= '',$driverId = ''){
        $this->DriverAcceptancemodel->datatable_bookingDetails($type,$driverId);
    }
    


}