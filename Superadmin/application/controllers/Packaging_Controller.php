<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Packaging_Controller extends CI_Controller {

  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model("PackagingPlanModel");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
//        $this->load->model("Superadminmodal");

        error_reporting(0);
         $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('packagingPlan_lang', $language);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
 

    public function index($cityId ='') {

        $data['storeCategory'] = $this->PackagingPlanModel->CategoryData();

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

       
        $checkbox=' <input type="checkbox" id="select_all" />';
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_LL'),$this->lang->line('col_UL'),
        $this->lang->line('col_Price'),$this->lang->line('col_TaxesApplicable'),$this->lang->line('col_extraFee'),$this->lang->line('col_actions'),$checkbox);
        $data['cityId'] = $cityId;
        $data['language'] = $this->PackagingPlanModel->get_lan_hlpText();
        $data['pagename'] = 'PackagingPlan/index';
        $this->load->view("company", $data);
    }
    public function SubCategory($params = '') {

        $data['business'] = $this->PackagingPlanModel->CategoryData();
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



$checkbox=' <input type="checkbox" id="select_all" />';
$this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_Name'),$this->lang->line('col_Weight'),$this->lang->line('col_Price'),$this->lang->line('col_UL'),
$this->lang->line('col_LL'),$this->lang->line('col_actions'),$checkbox);

        $data['language'] = $this->PackagingPlanModel->get_lan_hlpText();
        $data['bid1'] = $params;
        $data['pagename'] = 'PackagingPlan/index';
        $this->load->view("company", $data);       
    }
       
            
     public function operationCategory($param = '',$status = '',$cityId=''){
       
        
        switch ($param) {
            case 'insert':$this->PackagingPlanModel->insertCategory();
                break;

            case 'edit': $this->PackagingPlanModel->editCategory();
                break;

            case 'delete':$this->PackagingPlanModel->deleteCategory();
                break;

            case 'get': $this->PackagingPlanModel->getCategoryData();
                break;
            
            case 'table': $this->PackagingPlanModel->datatable_category($status,$cityId);
                break;
            
            case 'unhide': $this->PackagingPlanModel->unhideCategory($status);
                break;
            
            case 'hide': $this->PackagingPlanModel->hideCategory($status);
                break;
            
            case 'order': $this->PackagingPlanModel->changeCatOrder($status);
                break;
        }
    }
    
     public function operationSubCategory($param = '',$status1 = '',$status2 = ''){
       
        
        switch ($param) {
            case 'insert':$this->PackagingPlanModel->insertSubCategory();
                break;

            case 'edit': $this->PackagingPlanModel->editSubCategory();
                break;

            case 'delete':$this->PackagingPlanModel->deleteSubCategory();
                break;

            case 'get': $this->PackagingPlanModel->getSubCategoryData();
                break;
            
            case 'table': $this->PackagingPlanModel->datatable_Subcategory($status1,$status2);
                break;
            
            case 'unhide': $this->PackagingPlanModel->unhideSubCategory($status1);
                break;
            
            case 'hide': $this->PackagingPlanModel->hideSubCategory($status1);
                break;
            
            case 'order': $this->PackagingPlanModel->changeSubCatOrder($status1);
                break;
        }
    }
}