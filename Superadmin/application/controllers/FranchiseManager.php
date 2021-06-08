<?php

error_reporting(true);
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class franchiseManager extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model("FranchiseManagersModel");
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
        
        $data['cities'] =   $this->FranchiseManagersModel->getCities();
		 $data['franchise'] =   $this->FranchiseManagersModel->getFranchise();
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


        // $this->table->set_heading('SL No','City' ,'Manager Name' ,'Franchise Name'  ,  'Email' , 'phone' ,  'Responsibility' ,'Action','select');
        $checkbox=' <input type="checkbox" id="select_all" />';
        $this->table->set_heading('SL No','City' ,'Manager Name' ,'Franchise Name'  ,  'Email' , 'phone' ,  'Responsibility' ,'Action',$checkbox);

        $data['pagename'] = 'franchiseManager/franchiseManager';
        $this->load->view("company", $data);
    }
    
    public function getManagerDetails() {
        $this->FranchiseManagersModel->getManagerDetails();
    }
    public function editManager() {
        $this->FranchiseManagersModel->editManager();
    }
     public function datatable_FranchiseManager($for = '',$status = '') {
        $this->FranchiseManagersModel->datatable_FranchiseManagers($for,$status);
    }
     public function getStores() {
        $this->FranchiseManagersModel->getStores();
    }
     public function getFranchise() {
        $this->FranchiseManagersModel->getFranchise();
    }
     public function getDeviceLogs($userType = '') {
        $this->FranchiseManagersModel->getDeviceLogs($userType);
    }
     public function addManager() {
        $this->FranchiseManagersModel->addManager();
    }
     public function getManagers() {
       $r  = $this->FranchiseManagersModel->getManagers();
       echo json_encode(array('data'=>$r));
    }
    public function getManagersCount() {
        $this->FranchiseManagersModel->getManagersCount();
    }
    public function deleteManagers() {

        $this->FranchiseManagersModel->deleteManagers();
    }
    public function resetPassword() {

        $this->FranchiseManagersModel->resetPassword();
    }
    public function activateManagers() {

        $this->FranchiseManagersModel->activateManagers();
    }
    public function logoutManagers() {

        $this->FranchiseManagersModel->logoutManagers();
    }
    public function checkManagerExists() {

        $this->FranchiseManagersModel->checkManagerExists();
    }

   
   
    


}
