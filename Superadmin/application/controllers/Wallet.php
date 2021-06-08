<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wallet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->library('session');
        $this->load->model("WalletModel");
        $this->load->library('CallAPI');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
       // $language = $this->session->userdata('lang');
       // $this->lang->load('topnav_lang', $language);
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        
        $this->walletUsers = array(
            'customer' => 'customer',
            'driver' => 'driver',
            'store' => 'stores',
            'app' => 'app',
            'pg' => 'pg',
           
        );
        
        $this->walletDetails = array(
            'customer' => 'walletCustomer',
            'driver' => 'walletDriver',
            'store' => 'walletStore',
            'app' => 'walletApp',
            'pg' => 'walletPg',
            'dm' => 'walletCustomer',
           
        );
        
        $this->entities = array('app', 'pg');
    }
    
    function index() {
        redirect(base_url('index.php?/wallet/user/customer'));
    }
    
    function getBadgeCount() {
        $userType = $_POST['userType'];
        $userType = $this->walletUsers[strtolower($userType)];
        
        $this->WalletModel->getBadgeCount($userType);
    }
    
    public function user($userType = ''){
        // if ($this->session->userdata('table') != 'company_info') {
        //     redirect(base_url());
        // }
      
        $userType = ($this->walletUsers[strtolower($userType)] == '')?'customer':strtolower($userType);
        
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
        $this->table->set_heading('SL NO', 'NAME', 'EMAIL', 'PHONE', 'WALLET BALANCE', 'SOFT LIMIT', 'HARD LIMIT', 'Select', 'OPERATION');
        
        $data['userType'] = $userType;
        $data['pagename'] = "wallet/index";
        $this->load->view("company", $data);
    }
    
    public function datatable_user(){
        $userType = $_POST['userType'];
       
        $tabType = $_POST['tabType'];
        
        $tableName = $this->walletUsers[$userType];
        $this->WalletModel->datatable_user($userType, $tableName, $tabType);
    }
    
    public function details($userType = '', $userID = ''){
        // if ($this->session->userdata('table') != 'company_info') {
        //     redirect(base_url());
        // }
       
        $userType = ($this->walletUsers[strtolower($userType)] == '')?'customer':strtolower($userType);
        
        if($userID == '' && array_search($userType, $this->entities) === false)
            redirect(base_url('index.php?/wallet/user/' . $userType));
        
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
        $this->table->set_heading('TXN ID', 'OPENING', 'TXN TYPE', 'TRIGGER', 'BOOKING ID', 'TXN DATE', 'CITY','PG NAME','INITIATED', 'REASON', 'AMOUNT', 'CLOSING');
        
        if(array_search($userType, $this->entities) === false)
        $data['userData'] = $this->WalletModel->getUserDetails($userID, $this->walletUsers[strtolower($userType)]);
        $data['isEntity'] = (array_search($userType, $this->entities) === false)?false:true;
        $data['userType'] = $userType;
        $data['pagename'] = "wallet/walletDetails";
        $this->load->view("company", $data);
    }
    
    public function datatable_details($export = false){
        $userType = $_POST['userType'];
        $userId = $_POST['userId'];
        $tableName = $this->walletDetails[strtolower($userType)];
        
        $this->WalletModel->datatable_details(strtolower($userType), $tableName, $userId, $export);
    }

    public function exportAccData($stdate = '', $enddate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data = $this->WalletModel->exportAccData($stdate, $enddate);

        // file name for download
        $fileName = "Wallet" . date('Ymd') . ".xls";

        // headers for download
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Type: application/vnd.ms-excel");

        $flag = false;
        foreach ($data as $row) {
            if (!$flag) {
                // display column names as first row
                echo implode("\t", array_keys($row)) . "\n";
                $flag = true;
            }
            // filter data
            array_walk($row, 'filterData');
            echo implode("\t", array_values($row)) . "\n";
        }
    }

    public function getZone(){

        $this->WalletModel->getZone();

    }


    public function transection_data_form_date($stdate = '', $enddate = '', $paymentType = '') {

        

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->WalletModel->transection_data_form_date($stdate, $enddate, $paymentType);
    }

       public function getCitydata() {
        $this->load->model("citymodal");
        $cities = $this->citymodal->getCityListWallet();
           

 
        $dataToSend = [];

        foreach ($cities as $value) {
           
            if (!$value['isDeleted'])
                $dataToSend[] = array(
                    "_id" => $value['cityId']['$oid'],
                    "city" => $value['cityName']
                );
        }
        
        echo json_encode(array('data' => $dataToSend));
    }
}
?>