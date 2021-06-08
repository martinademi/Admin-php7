<?php

error_reporting(true);
ini_set('display_errors', 1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model("UsersModel");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        $this->lang->load('user_lang',$language);
        
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        
    }
    public function getFranchiseStores() {
        $this->UsersModel->getFranchiseStores(); 
    }

    public function index($for = '', $status = '',$bizId = '') {
       
        $this->load->library('Datatables');
        $this->load->library('table');
       $data['BizId'] = $this->session->userdata('badmin')['BizId'];
//        print_r($data['BizId']); die;
       //$data['managersdata'] =   $this->UsersModel->getUsersData($data['BizId']);
      
        $data['cities'] =   $this->UsersModel->getCities();
        $data['status'] = 1;
		$data['role'] = $this->session->userdata("role");
		$data['cityId'] = (string)$this->session->userdata("cityId");
		$data['cityName'] = $this->session->userdata("cityName");
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
        $checkbox=' <input type="checkbox" id="select_all" />';
        

        $this->table->set_heading( $this->lang->line('SLNO'),$this->lang->line('City'),$this->lang->line('Name'),$this->lang->line('Franchise'),$this->lang->line('Store'),$this->lang->line('Email'),$this->lang->line('Phone'),$this->lang->line('option'),$this->lang->line('Select'));


        
        $data['pagename'] = 'Users/Users';
        $this->load->view("company", $data);
    }
    
     public function datatable_Users($for = '',$status = '') {
        $this->UsersModel->datatable_users($for,$status);
    }
     public function getDeviceLogs($userType = '') {
        $this->UsersModel->getDeviceLogs($userType);
    }
     public function addUsers() {
        $this->UsersModel->addUsers();
    }
     public function editUsers() {
        $this->UsersModel->editusers();
    }
    
    public function deleteUsers() {
        $this->UsersModel->deleteUsers();
    }
    public function activateUsers() {
        $this->UsersModel->activateUsers();
    }

    public function DeleteTempUsers() {
        $this->UsersModel->DeleteTempUsers();
    }
	
	 public function checkCityExistsForPartner() {
        $this->UsersModel->checkCityExistsForPartner();
    }
    
    public function getUsers() {
       $r  = $this->UsersModel->getUsers();
       echo json_encode(array('data'=>$r));
    }
	
	  public function checkUsersExists() {

        $this->UsersModel->checkUsersExists();
    }

    public function validatePassword() {       
        return $this->UsersModel->validatePassword();
    }

    public function editpassword() {

        $this->UsersModel->editpassword();

    }

    public function getManagerCount() {
        $this->UsersModel->getManagerCount();
    }

    public function permanentDelete() {

        $this->UsersModel->permanentDelete();
  
    }
   
   
    


}
