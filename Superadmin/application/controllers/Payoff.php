<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payoff extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model("PayoffModel");
        $this->load->library('CallAPI');
        $this->load->library('session');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
       
        // $language = $this->session->userdata('lang');
        // $this->lang->load('topnav_lang', $language);
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        // $this->walletUsers = array(
        //     'driver' => 'driver',
        //     'operator' => 'driver'
        // );

        // $this->walletDetails = array(
        //     'driver' => 'walletDriver',
        //     'operator' => 'walletDriver'
        // );
        
        // $this->payoff = array(
        //     'driver' => 'payoffDriver',
        //     'operator' => 'payoffDriver'
        // );

        $this->walletUsers = array(
            'driver' => 'driver',
            'operator' => 'driver',
            'stores' => 'stores',
            'store' => 'stores'
        );

        $this->walletDetails = array(
            'driver' => 'walletDriver',
            'operator' => 'walletDriver',
            'stores' => 'walletStore'
        );
        
        $this->payoff = array(
            'driver' => 'payoffDriver',
            'operator' => 'payoffDriver',
            'stores' => 'payoffStores',
            'store' => 'payoffStores'
            
        );
    }
    
    public function index() {
       

        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" class="table table-hover demo-table-search">',
            'heading_row_start' => '<tr role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
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
        $this->table->set_heading('SL NO', 'CITY NAME', 'FREELANCER','STORE');

        $data['pagename'] = "payoff/index";
        $this->load->view("company", $data);
    }

    public function datatable_payoff() {
        $this->PayoffModel->datatable_payoff();
    }
    
    public function details($userType = '', $cityId = '') {
        
       
        if($cityId == '')
            redirect(base_url() . "index.php?/payoff");

            $this->load->library('table');
            $tmpl = array('table_open' => '<table id="big_table" class="table table-hover demo-table-search">',
                'heading_row_start' => '<tr role="row">',
                'heading_row_end' => '</tr>',
                'heading_cell_start' => '<th>',
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
        $this->table->set_heading('START DATE', 'END DATE', 'TRIPS', 'TOTAL BILLING', strtoupper($userType . "s"), 'CASH COLLECTION', 'PAYABLE', 'SUCCESS PAYMENT', 'FAILED PAYMENT', 'CASH COLLECTION', 'ACTION');
        
        $this->load->model("citymodal");
        $data['cityData'] = $this->citymodal->getCitydata($cityId);
        $data['cityId'] = $cityId;
        $data['userType'] = $userType;
        $data['pagename'] = "payoff/details";
        $this->load->view("company", $data);
    }
    
    public function datatable_payoff_details() {
        $userType = $_POST['userType'];
        $tableName = $this->payoff[strtolower($userType)];
        // echo $userType ;
        // echo '<br>';
        // echo $tableName ;die;
        $this->PayoffModel->datatable_payoff_details($userType, $tableName);
    }

    public function payoff(){
        $resData = $this->PayoffModel->payoff();
        echo json_encode($resData);
       
    }
    
    public function payoffReport($userType = '', $cityId = '', $cycleId = ''){
        $userTable = $this->walletUsers[strtolower($userType)];
        $tableName = $this->payoff[strtolower($userType)];

      
        $this->PayoffModel->payoffReport($userTable, $tableName, $cityId, $cycleId);
    }
    
    public function userDetails($userType = '', $payoffId = '') {
        
        
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" class="table table-hover demo-table-search">',
            'heading_row_start' => '<tr role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
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
        $this->table->set_heading('SL No.', 'Name', 'Email', 'Mobile', 'Currency', 'Balance', 'Status', 'TXN ID');
        // $this->table->set_heading('SL No.', 'Name', 'Email', 'Mobile',  'Balance', 'Status', 'TXN ID');
        
        $tableName = $this->payoff[strtolower($userType)];
        
        $payoffData = $this->PayoffModel->getPayoffDetails($tableName, $payoffId);
        $data['payoffData'] = $payoffData;
        
        $this->load->model("citymodal");
        $data['cityData'] = $this->citymodal->getCitydata($payoffData['cityId']['$oid']);
        
        $data['cityId'] = $payoffData['cityId']['$oid'];
        $data['userType'] = $userType;
        $data['pagename'] = "payoff/userDetails";
        $this->load->view("company", $data);
    }
    
    public function datatable_user_details() {
        $userType = $_POST['userType'];
        $userTable = $this->walletUsers[strtolower($userType)];
        $tableName = $this->payoff[strtolower($userType)];
        
        $this->PayoffModel->datatable_user_details($userTable, $tableName);
    }
}

?>