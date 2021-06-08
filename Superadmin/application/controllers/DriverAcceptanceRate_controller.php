<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DriverAcceptanceRate_controller extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php?/welcome
     * 	- or -
     * 		http://example.com/index.php?/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php?/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model("DriverAcceptanceRate_modal");
        $this->load->library('CallAPI');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
$this->lang->load('header_lang',$language); 

//        $this->load->library('Excel');

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
    public function totalBookings($driverID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        
        $data['driverID'] = $driverID;
        $data['driverData'] = $this->DriverAcceptanceRate_modal->getDriverData($driverID);
     

        $data['pagename'] = "DriverAcceptanceRateBookings/totalBooking";
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
        $this->table->set_heading('BOOKING ID','CUSTOMER NAME', 'PHONE', 'RECEIVED ON','ACCEPTED ON','STATUS');
        $this->load->view("company", $data);
    }
    public function datatable_totalBookings($driverID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriverAcceptanceRate_modal->datatable_totalBookings($driverID);
    }
    public function acceptedBookings($driverID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        
        $data['driverID'] = $driverID;
        $data['driverData'] = $this->DriverAcceptanceRate_modal->getDriverData($driverID);
     

        $data['pagename'] = "DriverAcceptanceRateBookings/acceptedBookings";
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
        $this->table->set_heading('BOOKING ID','CUSTOMER NAME', 'PHONE', 'RECEIVED ON','ACCEPTED ON','STATUS');
        $this->load->view("company", $data);
    }
    public function datatable_acceptedBookings($driverID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriverAcceptanceRate_modal->datatable_acceptedBookings($driverID);
    }
    public function rejectedBookings($driverID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        
        $data['driverID'] = $driverID;
        $data['driverData'] = $this->DriverAcceptanceRate_modal->getDriverData($driverID);
     

        $data['pagename'] = "DriverAcceptanceRateBookings/rejectedBookings";
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
        $this->table->set_heading('BOOKING ID','CUSTOMER NAME', 'PHONE', 'RECEIVED ON','REJECTED ON','STATUS');
        $this->load->view("company", $data);
    }
    public function datatable_rejectedBookings($driverID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriverAcceptanceRate_modal->datatable_rejectedBookings($driverID);
    }
    public function cancelledBookings($driverID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        
        $data['driverID'] = $driverID;
        $data['driverData'] = $this->DriverAcceptanceRate_modal->getDriverData($driverID);
     

        $data['pagename'] = "DriverAcceptanceRateBookings/cancelledBookings";
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
        $this->table->set_heading('BOOKING ID','CUSTOMER NAME', 'PHONE', 'RECEIVED ON','CANCELLED ON','STATUS');
        $this->load->view("company", $data);
    }
    public function datatable_cancelledBookings($driverID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriverAcceptanceRate_modal->datatable_cancelledBookings($driverID);
    }
    public function didNotRespondBookings($driverID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        
        $data['driverID'] = $driverID;
        $data['driverData'] = $this->DriverAcceptanceRate_modal->getDriverData($driverID);
     

        $data['pagename'] = "DriverAcceptanceRateBookings/didNotRespondBookings";
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
        $this->table->set_heading('BOOKING ID','CUSTOMER NAME', 'PHONE', 'RECEIVED ON','STATUS');
        $this->load->view("company", $data);
    }
    public function datatable_didNotRespondBookings($driverID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriverAcceptanceRate_modal->datatable_didNotRespondBookings($driverID);
    }
}