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
        $this->lang->load('headerNav_lang',$language);
        $this->lang->load('wallet_lang', $language);
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
        $tmpl = array('table_open' => '<table id="big_table" class=" table table-striped table-bordered dataTable no-footer">',
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
        $this->table->set_heading($this->lang->line('col_slno'), $this->lang->line('col_name'), $this->lang->line('col_email'),$this->lang->line('col_phone'), $this->lang->line('col_walletBalance'),$this->lang->line('col_select'), $this->lang->line('col_operation'));
    
        
        $data['userType'] = $userType;
        $data['pagename'] = "wallet/index";
        $this->load->view("template", $data);
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
        $tmpl = array('table_open' => '<table id="big_table" class=" table table-striped table-bordered dataTable no-footer">',
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
        $this->table->set_heading( $this->lang->line('col_txnId'),$this->lang->line('col_opening'),$this->lang->line('col_txnType'),$this->lang->line('col_trigger'),$this->lang->line('col_bookingId'),$this->lang->line('col_txnDate'),$this->lang->line('col_city'),$this->lang->line('col_pgName'),$this->lang->line('col_initiated'),$this->lang->line('col_reason'),$this->lang->line('col_amount'),$this->lang->line('col_closingBalance'));
       

        
        if(array_search($userType, $this->entities) === false)
            $data['userData'] = $this->WalletModel->getUserDetails($userID, $this->walletUsers[strtolower($userType)]);
        $data['isEntity'] = (array_search($userType, $this->entities) === false)?false:true;
        $data['userType'] = $userType;
        $data['pagename'] = "wallet/walletDetails";
        if($userType == 'store'){
            $data['closingBalance'] = $this->session->userdata('badmin')['currencySymbol']." ".$this->WalletModel->getClosingBalance($userType, 'stores', $userID);
        }
        
        $this->load->view("template", $data);
    }
    
    public function datatable_details($export = false){
        $userType = $_POST['userType'];
        $userId = $_POST['userId'];
        $tableName = $this->walletDetails[strtolower($userType)];
        
        $this->WalletModel->datatable_details(strtolower($userType), $tableName, $userId, $export);
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


    //export  data
    public function exportAccData($export = false) {

        $userType = $_POST['userType'];
        $userId = $_POST['userId'];
        $tableName = $this->walletDetails[strtolower($userType)];        
        $data = $this->WalletModel->exportAccData(strtolower($userType), $tableName, $userId);     
     
        $fileName = "Wallet" . date('Y-m-d') . ".xls";        
        $this->load->library('excel');               
        $this->excel->setActiveSheetIndex(0);
        $this->excel->stream($fileName, $data);   
    
           
        }
}
?>