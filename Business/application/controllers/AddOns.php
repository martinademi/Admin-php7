<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class AddOns extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model("AddOnsmodal");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('headerNav_lang',$language);
        $this->lang->load('AddOn_lang', $language);
//        $this->load->model("Superadminmodal");

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index() {
        if ($this->issessionset()) {
//            $data['business'] = $this->AddOnsmodal->CategoryData();

            $this->load->library('Datatables');
            $this->load->library('table');

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
          // $checkbox=' <input type="checkbox" class="selectbox" value="0" id="select_all" />';
            $this->table->set_heading('SL NO', 'ADD-ON NAME', 'DESCRIPTION','ACTION', 'SELECT');
           // $data['language'] = $this->AddOnsmodal->get_lan_hlpText();
         
            $data['pagename'] = 'AddOns/addons';
            $this->load->view("template", $data);
        } else {
            redirect(base_url() . "index.php/Business");
        }
    }
    
    public function getProductsBySerach(){
      
        $this->AddOnsmodal->getProductsBySerach();
    }

    public function getProductDataDetail($id = '') {
        $this->AddOnsmodal->getProductDataDetail($id);

    }


//    addNewaddOn
     public function addNewaddOn() {
       
        $data['language'] = $this->AddOnsmodal->get_lan_hlpText();
        $data['BizId'] = $this->session->userdata('badmin')['BizId'];
        $data['addOnGroup'] = $this->AddOnsmodal->getAddOnGroup();
//        echo '<pre>'; print_r($data['addOnGroup']); die;
        $data['pagename'] = "AddOns/addNewaddOn";
        $data['language']= $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        $countlan= count($data['language']);
           $data['countlang']=$countlan+1;
        //    echo $data['countlang'];die;
        $this->load->view("template", $data);
    }
	
	 public function calender() {
       
        $data['pagename'] = "calendar";
        $this->load->view("template", $data);
    }
    
    public function AddnewAddOnData(){
        $data = $this->AddOnsmodal->AddnewAddOnData();
        if ($data) {
            redirect(base_url()."index.php?/AddOns"); 
//            exit;
        }
    }

    
    public function editAddOnData(){
        $data['BizId'] = $this->session->userdata('badmin')['BizId'];      
        $data = $this->AddOnsmodal->editAddOnData();
      
        if ($data) {
            redirect(base_url()."index.php?/AddOns"); 

        }
    }

    public function operationCategory($param = '', $status = '') {
        // print_r($param);die;

        switch ($param) {
            case 'insert':$this->AddOnsmodal->insertCategory();
                break;

            case 'edit': $this->AddOnsmodal->editCategory();
                break;

            case 'delete':$this->AddOnsmodal->deleteCategory();
                break;

            case 'get': $this->AddOnsmodal->getCategoryData();
                break;

            case 'table': $this->AddOnsmodal->datatable_addons($status);
                break;

            case 'unhide': $this->AddOnsmodal->unhideCategory($status);
                break;

            case 'hide': $this->AddOnsmodal->hideCategory($status);
                break;

            case 'order': $this->AddOnsmodal->changeCatOrder($status);
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
        $data['BizId'] = $this->session->userdata('badmin')['BizId'];
        $data['language'] = $this->AddOnsmodal->get_lan_hlpText();
        $data['pagename'] = "AddOns/editAddOn";
        $data['addOnId']=$addOnsId;
        $this->load->view("template", $data);
     }


     //function to get all detail
     public function getAddOnDetail($addOnId){
        // echo 'hi';
        // print_r($addOnId);die;
        $this->AddOnsmodal->getAddOnDetail($addOnId);

     }

     public function getAddonChange($status){

        $this->AddOnsmodal->getAddonChange($status);
     }

     //update addon info
	function update_addOnDetails(){
		$addOnIds = $this->input->post("addOnIds");
        $status   = $this->input->post("status");
       
		$this->AddOnsmodal->update_addOnDetails($addOnIds, $status);
		// echo json_encode(array('msg' => $response));
		

    }
    

    public function permanentDelete() {

        $this->AddOnsmodal->permanentDelete();
  
    }

}
