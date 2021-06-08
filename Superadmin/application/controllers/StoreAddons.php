<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class StoreAddons extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model("StoreAddonsModel");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
//        $this->load->model("Superadminmodal");

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index($status = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        
       
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:12px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:12px;">',
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
        $this->table->set_heading('SL NO','ADD-ON NAME','DESCIPTION','STORE NAME','VIEW','SELECT');
    
        // $data['pagename'] = "Central/central";
        $data['pagename'] = 'AddOns/addons';
        $this->load->view("company", $data);
    }
    
//    addNewaddOn
     public function addNewaddOn() {
       
        $data['language'] = $this->StoreAddonsModel->get_lan_hlpText();
        $data['BizId'] = $this->session->userdata('badmin')['BizId'];
        $data['addOnGroup'] = $this->StoreAddonsModel->getAddOnGroup();
//        echo '<pre>'; print_r($data['addOnGroup']); die;
        $data['pagename'] = "AddOns/addNewaddOn";
        $this->load->view("template", $data);
    }
	
	 public function calender() {
       
        $data['pagename'] = "calendar";
        $this->load->view("template", $data);
    }
    
    public function AddnewAddOnData(){
        $data = $this->StoreAddonsModel->AddnewAddOnData();
        if ($data) {
            redirect(base_url()."index.php?/AddOns"); 
//            exit;
        }
    }

    public function operationCategory($param = '', $status = '') {
        // print_r($param);die;

        switch ($param) {
            case 'insert':$this->StoreAddonsModel->insertCategory();
                break;

            case 'edit': $this->StoreAddonsModel->editCategory();
                break;

            case 'delete':$this->StoreAddonsModel->deleteCategory();
                break;

            case 'get': $this->StoreAddonsModel->getCategoryData();
                break;

            case 'table': $this->StoreAddonsModel->datatable_addons($status);
                break;

            case 'unhide': $this->StoreAddonsModel->unhideCategory($status);
                break;

            case 'hide': $this->StoreAddonsModel->hideCategory($status);
                break;

            case 'order': $this->StoreAddonsModel->changeCatOrder($status);
                break;
        }
    }

    function issessionset() {
        if ($this->session->userdata('badmin')['BizId']) {
            return true;
        }
        return false;
    }

    //edit Addons
    public function editAddons($addOnsId){
        // print_r($addOnsId);
        // die;
        $data['pagename'] = "AddOns/editAddOn";
        $data['addOnId']=$addOnsId;
        $this->load->view("template", $data);
     }


     //function to get all detail
     public function getAddOnDetail($addOnId){
        // echo 'hi';
        // print_r($addOnId);die;
        $this->StoreAddonsModel->getAddOnDetail($addOnId);

     }

     public function getAddonChange($status){

        $this->StoreAddonsModel->getAddonChange($status);
     }

     //update addon info
	function update_addOnDetails(){
		$addOnIds = $this->input->post("addOnIds");
        $status   = $this->input->post("status");
       
		$this->StoreAddonsModel->update_addOnDetails($addOnIds, $status);
		// echo json_encode(array('msg' => $response));
		

    }
    
    public function addOnsList($id = '') {
        
        $this->StoreAddonsModel->addOnsList($id);
    }

}
