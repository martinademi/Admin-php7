<?php

error_reporting(true);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class DemoSetup extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model("PaymentGatewayModal");
        
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index() {

        $this->load->library('Datatables');
        $this->load->library('table');
//        require 'datatableVariable.php';
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
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
         $data['language'] = $this->PaymentGatewayModal->getlanguageText();
         $data['status'] = 1;
//        $this->table->set_heading('SLNO', 'Gateway Name', '% Commission', 'Fixed Commission','Total Commission' ,'SELECT');
        $this->table->set_heading('SLNO', 'Gateway Name', '% Commission', 'Fixed Commission','Action','SELECT','Action');

        $data['pagename'] = 'paymentGateway/index';
        $this->load->view("company", $data);
    }
    public function datatablePaymentGateway($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->PaymentGatewayModal->datatablePaymentGateway($status);
    }
    public function addPaymentGateway() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->PaymentGatewayModal->addPaymentGateway();
    }
    public function deletePaymentGateway() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->PaymentGatewayModal->deletePaymentGateway();
    }
    public function approvePaymentGateway() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->PaymentGatewayModal->approvePaymentGateway();
    }
    public function getOnePaymentGateway() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->PaymentGatewayModal->getOnePaymentGateway();
    }
    public function updatePaymentGateway() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->PaymentGatewayModal->updatePaymentGateway();
    }
    

}
