<?php

error_reporting(true);
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Storemanagers extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model("StoremanagersModel");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        
    }

    public function index($for = '', $status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        
        $data['cities'] =   $this->StoremanagersModel->getCities();
        $data['status'] = 1;
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

//        $this->table->set_heading('SL No','Franchise Name' , 'Store Name' , 'City' , 'Manager Name' , 'Email' , 'phone' , 'status (logged in/out )' , 'Responsible For ( Pickup/ Delivery / Both )' , 'App Version ','Total Sessions' ,' Last  Logged In On' , 'Current Session Time ','Deleted On ',' Deleted By  ( Admin / Store )','option'
        $this->table->set_heading('SL No','City' ,'Manager Name' ,'Franchise Name' ,  'Store Name' ,  'Email' , 'phone' ,  'Responsibility' ,'Action','select');
	$data['status']=1;
        $data['pagename'] = 'Storemanagers/storeManagers';
        $this->load->view("company", $data);
    }
    
    public function getManagerDetails() {
        $this->StoremanagersModel->getManagerDetails();
    }
    public function editManager() {
        $this->StoremanagersModel->editManager();
    }
     public function datatable_storeManagers($for = '',$status = '') {
        $this->StoremanagersModel->datatable_storeManagers($for,$status);
    }
     public function getStores() {
        $this->StoremanagersModel->getStores();
    }
     public function getFranchise() {
        $this->StoremanagersModel->getFranchise();
    }
     public function getDeviceLogs($userType = '') {
        $this->StoremanagersModel->getDeviceLogs($userType);
    }
     public function addManager() {
        $this->StoremanagersModel->addManager();
    }
     public function getManagers() {
       $r  = $this->StoremanagersModel->getManagers();
       echo json_encode(array('data'=>$r));
    }
    public function getManagersCount() {
        $this->StoremanagersModel->getManagersCount();
    }
    public function deleteManagers() {

        $this->StoremanagersModel->deleteManagers();
    }
    public function resetPassword() {

        $this->StoremanagersModel->resetPassword();
    }
    public function activateManagers() {

        $this->StoremanagersModel->activateManagers();
    }
    public function logoutManagers() {

        $this->StoremanagersModel->logoutManagers();
    }
    public function checkManagerExists() {

        $this->StoremanagersModel->checkManagerExists();
    }

   
   
    


}
