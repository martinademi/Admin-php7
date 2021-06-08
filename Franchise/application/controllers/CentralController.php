<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class CentralController extends CI_Controller {
  
    public function __construct() {
           
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Centralmodal');
       
        
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('central_lang', $language);
        
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
    public function index($status = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        
        $data['language'] = $this->Centralmodal->getlanguageText();
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="font-size:11px !important;margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:11px !important;"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => ' <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:11px !important;">',
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
        //$this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_Name'),$this->lang->line('col_desc'),$this->lang->line('col_addOns'),$this->lang->line('col_action'),$this->lang->line('col_select'));
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_Name'),$this->lang->line('col_desc'),$this->lang->line('col_addOns'),"Action");
    
        $data['pagename'] = "Central/central";
        $this->load->view("SuperAdmin_Dashbord", $data);
    }
    
     public function tax_details($status = '') {
        $this->Centralmodal->table_details($status);
    }
    
     public function addCentral($addCentralId) {
       
        $data['language'] = $this->Centralmodal->getlanguageText();
        $data['addCentralId']=$addCentralId;
        $data['currencySymbol']=$this->session->userdata('badmin')['currencySymbol'];
        // print_r($data);die;
        
        $data['pagename'] = "Central/addCentral";
        $this->load->view("SuperAdmin_Dashbord", $data);
    }
     public function editCentral($id) {
       
        $data['language'] = $this->Centralmodal->getlanguageText();
        $data['dataId'] = $id;
        $data['addOnData'] = $this->Centralmodal->getAddOnData($id);
//        echo '<pre>'; print_r($data['addOnData']); die;
        
        $data['pagename'] = "Central/editCentral";
        $this->load->view("SuperAdmin_Dashbord", $data);
    }
     public function AddNewCentral() {
      $data = $this->Centralmodal->AddNewCentral();
        if ($data) {
            echo json_encode(array('status' => true, 'message' => 'Central addons added successfully'));
            redirect(base_url()."index.php?/CentralController"); 
//            exit;
        }else{
            echo json_encode(array('status' => true, 'message' => 'Central addons already'));

            redirect(base_url()."index.php?/CentralController"); 

        }
    }
     public function editCentralData($id) {
      $data = $this->Centralmodal->editCentralData($id);
//      print_r($data); die;
        if ($data) {
//            echo json_encode(array('status' => true, 'message' => 'Central addons added successfully'));
            redirect(base_url()."index.php?/CentralController"); 
//            exit;
        }
    }
    public function getAddOnsEdit($id = '') {
        $this->Centralmodal->getAddOnsEdit($id);
    }
    public function addOnsList($id = '') {
        $this->Centralmodal->addOnsList($id);
    }
    public function getselectedData($id = '') {
        $data1 = $this->Centralmodal->getselectedData($id);
        echo json_encode(array('data' => $data1));
    }
    
     public function activateActon() {
        $this->Centralmodal->activateActon();
    }
     public function deactivateAction() {
        $this->Centralmodal->deactivateAction();
    }
     public function deleteAction() {
        $this->Centralmodal->deleteAction();
    }

    public function getCentralDetail($addCentralId){
        $this->Centralmodal->getCentralDetail($addCentralId);
    }
   
    
}
