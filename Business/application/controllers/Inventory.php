<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Inventory extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model('Inventorymodal');
        $this->load->model('Categorymodal');
        $this->load->model('SubCategorymodal');
        $this->load->model('SubsubCategorymodal');
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('headerNav_lang',$language);
        $this->lang->load('product_lang', $language);

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    



    public function InventoryProductDetails($productId,$unitsId,$timeOffset) {
        $this->Inventorymodal->InventoryProductDetails($productId,$unitsId,$timeOffset);
    }

    public function getUnitsForItem($id,$unitId) {
        $this->Inventorymodal->getUnitsForItem($id,$unitId);
    }

    
    public function getUnitsForStore($id) {
        $this->Inventorymodal->getUnitsForStore($id);
    }


    //Edit inventory
    public function editInventory($id){

       // $data['language'] = $this->productOffersmodal->getlanguageText();
        $data['cities'] = $this->productOffersmodal->getAllCities();
        /*changes required*/
        $data['pagename'] = "Offers/editNewOffer";
        $data['storeId']=$this->session->userdata('badmin')['BizId'];
        $data['campaignId'] = $id;
        $this->load->view("template", $data);
    }

    // view inventory
    public function viewInventory($id,$unitsId){

    //    echo '<pre>'; print_r($id);
    //   echo 'unitId'; print_r($unitsId);die;

        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
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
        $this->table->set_heading($this->lang->line('col_openingBalance'), $this->lang->line('col_triggerType'), $this->lang->line('col_orderNo'), $this->lang->line('col_inventoryCount'), $this->lang->line('col_date'), $this->lang->line('col_closingBalance'));

        $data['productId']=$id;
        $data['unitId']=$unitsId;
        $data['pagename'] = "Inventory/viewInventory";
        $this->load->view("template", $data);

        
    }

    //delete inventory
    public function deleteInventory($id){

        //$data['language'] = $this->productOffersmodal->getlanguageText();
        $data['cities'] = $this->productOffersmodal->getAllCities();
        /*changes required*/
        $data['pagename'] = "Offers/editNewOffer";
        $data['storeId']=$this->session->userdata('badmin')['BizId'];
        $data['campaignId'] = $id;
        $this->load->view("template", $data);
    }

 
    
  

    //add product 
    
    public function addProductQuantity(){

        $this->Inventorymodal->addProductQuantity();
    }

    
    public function removeProductQuantity(){

        $this->Inventorymodal->removeProductQuantity();
    }


    // ****************************
    public function index($status = '') {
        $this->load->model('GridProductModel');
        $data['category']=$this->GridProductModel->getCategory();
       // $data['product_data'] = $this->Inventorymodal->getProductData();
        $this->load->library('Datatables');
        $this->load->library('table');
        $data['language'] = $this->Inventorymodal->getlanguageText();
       
      $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
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
        // $this->table->set_heading('BARCODE','Units','QUANTITY' ,'Product Name', 'Category', 'SUB-Category', 'SUB-SUB Category', 'ACTION');
        $this->table->set_heading($this->lang->line('col_slno'),$this->lang->line('col_ProductName'),$this->lang->line('col_barcode') ,$this->lang->line('col_Category'),$this->lang->line('col_SubCategory'), $this->lang->line('col_SubSubCategory'),$this->lang->line('col_unit'),$this->lang->line('col_qty'),$this->lang->line('col_action'));

        $data['pagename'] = "Inventory/inventoryProducts";
        $this->load->view("template", $data);
    }

    public function inventoryProductList($status='',$sortby='',$type=''){

        $this->Inventorymodal->inventoryProductList($status,$sortby,$type);

        
    }

    //export  data
     public function exportAccData() {

        $this->Inventorymodal->exportAccData();

    }

}
