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
        $this->lang->load('headerNav_lang',$language);
        $this->lang->load('storemanager_lang',$language);
        
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        
    }

    public function index($for = '', $status = '',$bizId = '') {
       
        $this->load->library('Datatables');
        $this->load->library('table');
       $data['BizId'] = $this->session->userdata('badmin')['BizId'];
//        print_r($data['BizId']); die;
       $data['managersdata'] =   $this->StoremanagersModel->getmanagersdata($data['BizId']);
       $data['stores'] =   $this->StoremanagersModel->getStores($data['BizId']);
       
        $data['status'] = 1;
         $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:11px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => ' <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:11px;">',
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
       // $this->table->set_heading( 'Sl.No' , 'Name' ,'Email' , 'Phone' , 'App Version ','option', 'SELECT');

        $this->table->set_heading($this->lang->line('col_slno'),$this->lang->line('col_Name'),$this->lang->line('col_email'),$this->lang->line('col_phone'),$this->lang->line('col_appVersion')
        ,$this->lang->line('col_option'),$this->lang->line('col_select'));
        $data['pagename'] = 'Storemanagers/storeManagers';
        $this->load->view("template", $data);
    }
    
     public function datatable_storeManagers($for = '',$status = '') {
        $this->StoremanagersModel->datatable_storeManagers($for,$status);
    }
     public function getDeviceLogs($userType = '') {
        $this->StoremanagersModel->getDeviceLogs($userType);
    }
     public function addManager() {
        $this->StoremanagersModel->addManager();
    }
     public function editManager() {
        $this->StoremanagersModel->editManager();
    }
    
    public function deleteManagers() {
        $this->StoremanagersModel->deleteManagers();
    }
    public function activateManager() {
        $this->StoremanagersModel->activateManager();
    }
    
    public function getManagers() {
       $r  = $this->StoremanagersModel->getManagers();
       echo json_encode(array('data'=>$r));
    }
	  public function logoutManagers() {

        $this->StoremanagersModel->logoutManagers();
    }

    public function validatePassword() {       
        return $this->StoremanagersModel->validatePassword();
    }

    public function editpassword() {

        $this->StoremanagersModel->editpassword();

    }

    public function permanentDelete() {

        $this->StoremanagersModel->permanentDelete();
  
    }

    public function getManagerCount() {
        $this->StoremanagersModel->getManagerCount();
    }

   
   
    


}
