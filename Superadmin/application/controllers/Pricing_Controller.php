<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Pricing_Controller extends CI_Controller {

  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model("PricingPlanModel");
        $this->load->model("Citymodal");
        
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        $this->lang->load('vehicleSetting_lang', $language);
//        $this->load->model("Superadminmodal");

        error_reporting(0);
         $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('pricingPlan_lang', $language);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
 

    public function index($cityId ='') {

        $data['storeCategory'] = $this->PricingPlanModel->CategoryData();

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

        $this->table->set_heading($this->lang->line('col_sino'),'Name','Pricing');

        $data['citydata'] = $this->Citymodal->getCitydata($cityId);
        //echo '<pre>';print_r($data['citydata']);die;
        $data['cityId'] = $cityId;
        $data['language'] = $this->PricingPlanModel->get_lan_hlpText();
        $data['pagename'] = 'PricingPlan/index';
        $this->load->view("company", $data);
    }
    public function SubCategory($params = '') {

        $data['business'] = $this->PricingPlanModel->CategoryData();
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

        $data['language'] = $this->PricingPlanModel->get_lan_hlpText();
        $data['bid1'] = $params;
        $data['pagename'] = 'PricingPlan/index';
        $this->load->view("company", $data);       
    }
       
            
     public function operationCategory($param = '',$status = '',$cityId=''){
       
        
        switch ($param) {
            case 'insert':$this->PricingPlanModel->insertCategory();
                break;

            case 'edit': $this->PricingPlanModel->editCategory();
                break;

            case 'delete':$this->PricingPlanModel->deleteCategory();
                break;

            case 'get': $this->PricingPlanModel->getCategoryData();
                break;
            
            case 'table': $this->PricingPlanModel->datatable_category($status,$cityId);
                break;
            
            case 'unhide': $this->PricingPlanModel->unhideCategory($status);
                break;
            
            case 'hide': $this->PricingPlanModel->hideCategory($status);
                break;
            
            case 'order': $this->PricingPlanModel->changeCatOrder($status);
                break;
        }
    }
    
     public function operationSubCategory($param = '',$status1 = '',$status2 = ''){
       
        
        switch ($param) {
            case 'insert':$this->PricingPlanModel->insertSubCategory();
                break;

            case 'edit': $this->PricingPlanModel->editSubCategory();
                break;

            case 'delete':$this->PricingPlanModel->deleteSubCategory();
                break;

            case 'get': $this->PricingPlanModel->getSubCategoryData();
                break;
            
            case 'table': $this->PricingPlanModel->datatable_Subcategory($status1,$status2);
                break;
            
            case 'unhide': $this->PricingPlanModel->unhideSubCategory($status1);
                break;
            
            case 'hide': $this->PricingPlanModel->hideSubCategory($status1);
                break;
            
            case 'order': $this->PricingPlanModel->changeSubCatOrder($status1);
                break;
        }
    }

    public function updateTypePrice() {
       
        $this->PricingPlanModel->updateTypePrice();
    }

    public function updateTypePricefixed() {
       
        $this->PricingPlanModel->updateTypePricefixed();
    }

    

    public function getPriceByType($storeType,$cityId) {
        
        $this->PricingPlanModel->getPriceByType($storeType,$cityId);
        
    }

    public function getPriceByTypefixed($storeType,$cityId) {
        
        $this->PricingPlanModel->getPriceByTypefixed($storeType,$cityId);
        
    }
}