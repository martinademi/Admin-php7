<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//echo 1;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class SubsubCategory extends CI_Controller {

  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model("Categorymodal");
        $this->load->model("SubCategorymodal");
        $this->load->model("SubsubCategorymodal");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('headerNav_lang',$language);

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
 
    public function datatable_subsubcategory($param = '',$status = '') {

        $this->SubsubCategorymodal->datatable_subsubcategory($param,$status);
    }

    public function getProductsBySerach(){
      
        $this->SubsubCategorymodal->getProductsBySerach();
        }

        public function getProductDataDetail($id = '') {
            $this->SubsubCategorymodal->getProductDataDetail($id);

        }

      public function subSubCategory( $params = '' , $id = '') {
       
        $data['businesssub'] = $this->SubCategorymodal->SubCategoryData();
        $data['business'] = $this->Categorymodal->CategoryData(); 
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

        $this->table->set_heading('SL NO', 'IMAGE', 'SUB-SUBCATEGORY NAME','DESCRIPTION', 'SORT','ACTION','SELECT');
        $data['language'] = $this->Categorymodal->get_lan_hlpText();
        $data['bid'] = $params;
        $data['id'] = $id;
        $data['pagename'] = 'SubsubCategory/subsubcategory';
        $this->load->view("SuperAdmin_Dashbord", $data);
    }
     public function deleteSubSubCategory() {

        $data = $this->SubsubCategorymodal->deleteSubSubCategory();
        return data;
    }
     public function editSubSubCategory() {
        echo $this->SubsubCategorymodal->editSubSubCategory();
    }
    public function insertSubSubCategory() {

        $this->SubsubCategorymodal->insertSubSubCategory();
        
    }
     public function getSubSubCategoryData() {

        $data[] = $this->SubsubCategorymodal->getSubSubCategoryData();

        echo json_encode($data);
    }
     public function getSubSubCategoryDataList($id = '') {

        $this->SubsubCategorymodal->getSubSubCategoryDataList($id);

    }
     public function hideSubsubCategory() {
        echo $this->SubsubCategorymodal->hideSubsubCategory();
    }
     public function unhideSubsubCategory() {
        echo $this->SubsubCategorymodal->unhideSubsubCategory();
    }
     public function changeCatOrder() {
        echo $this->SubsubCategorymodal->changeCatOrder();
    }
    
     
}