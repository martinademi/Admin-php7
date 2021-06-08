<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//echo 1;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class AddNewProducts extends CI_Controller {

  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model('ProductsModel');
        $this->load->model('Categorymodal');
        $this->load->model('SubCategorymodal');
        $this->load->model('SubsubCategorymodal');

        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        $this->lang->load('product_lang', $language);
        
        
 
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
 
     public function product_details($status = '') {
        $this->ProductsModel->product_details($status);
    }
     public function getUnits($id = '') {
        $this->ProductsModel->getUnits($id);
    }
      public function index($status = '') {
//        $data['product_data'] = $this->ProductsModel->getProductData();
//			changes done removed
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
        $checkbox=' <input type="checkbox" id="select_all" />';
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_ProductImage'),$this->lang->line('col_ProductName'),$this->lang->line('col_Category'),
        $this->lang->line('col_SubCategory'),$this->lang->line('col_SubSubCategory'),$this->lang->line('col_Action'),'Created on','Success','Failed','Repeated', $checkbox,'Status');                              
       
         $data['status'] = 1;
        $data['pagename'] = "Products/products";
        $this->load->view("company", $data);
    }

    public function getBulkinfo($bulkId){

        $this->ProductsModel->getBulkinfo($bulkId);

    }
    
      public function storeProducts() {
//        $data['product_data'] = $this->ProductsModel->getProductData();
        $this->load->library('Datatables');
        $this->load->library('table');
        $data['status'] = 0;

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
        $checkbox=' <input type="checkbox" id="select_all" />';
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_ProductImage'),$this->lang->line('col_ProductName'),

        
                $this->lang->line('col_Storename'),$this->lang->line('col_Approval_Request_Date'),$this->lang->line('col_Category'),
                                $this->lang->line('col_SubCategory'),$this->lang->line('col_SubSubCategory'),$this->lang->line('col_Units'),$checkbox);

        
     
                
        $data['pagename'] = "Products/storeProducts";
        $this->load->view("company", $data);
    }
    public function getUnitsEdit($id = '') {
     
         $this->ProductsModel->getUnitsEdit($id);
       
    }
    public function datatableStoreDetails($status = ''){
        $this->ProductsModel->datatableStoreDetails($status);
    }
    public function reorderProductSequence(){
        $this->ProductsModel->reorderProductSequence();
    }

    public function addNewProduct() {

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['currencySymbol'] = $this->ProductsModel->getAppConfigData();
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        //   echo '<pre>';print_r($data['category']);die;
        $data['color'] = $this->ProductsModel->getActiveColors();
        $data['addon']=$this->ProductsModel->getAddOns();
       // $data['size'] = $this->ProductsModel->getActiveSize();
        // echo '<pre>';print_r($data['size']);die;
        $data['manufacturer'] = $this->ProductsModel->getManufacturer();
        $data['brands'] = $this->ProductsModel->getBrands();       
        $data['language'] = $this->ProductsModel->getlanguageText();
        $data['pagename'] = "Products/AddNewProducts";
        $this->load->view("company", $data);
    }
    public function addNewProductStore() {

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['currencySymbol'] = $this->ProductsModel->getAppConfigData();
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        $data['color'] = $this->ProductsModel->getActiveColors();
        $data['size'] = $this->ProductsModel->getActiveSize();
        $data['manufacturer'] = $this->ProductsModel->getManufacturer();
        $data['brands'] = $this->ProductsModel->getBrands();
        
        $data['stores'] = $this->ProductsModel->getStores();
        $data['language'] = $this->ProductsModel->getlanguageText();
        $data['pagename'] = "Products/AddNewStoreProducts";
        $this->load->view("company", $data);
    }
    public function EditProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['currencySymbol'] = $this->ProductsModel->getAppConfigData();
        $data['color'] = $this->ProductsModel->getActiveColors();
       // $data['size'] = $this->ProductsModel->getActiveSize();
       
        $data['language'] = $this->ProductsModel->getlanguageText();
        $data['manufacturer'] = $this->ProductsModel->getManufacturer();
        $data['brands'] = $this->ProductsModel->getBrands();
        $data['productId'] = $id;
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
       

        $data['productsData'] = $this->ProductsModel->getData($id);
           //   echo '<pre>'; print_r($data['productsData']);die;
     
 
             
        $data['pagename'] = "Products/editProducts";
       
        $this->load->view("company", $data);
    }
    
    public function productDetails($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['currencySymbol'] = $this->ProductsModel->getAppConfigData();
        $data['productId'] = $id;
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        $data['productsData'] = $this->ProductsModel->getData($id);
             
        $data['pagename'] = "Products/productDetails";
        $this->load->view("company", $data);
    }
    
    public function importExcel() {

       
            if(isset($_POST["import"]))
             {
                 $filename=$_FILES["file"]["tmp_name"];
                 if($_FILES["file"]["size"] > 0)
                   {
                     $row =0;
                     $file = fopen($filename, "r");
                      while (($importdata = fgetcsv($file)) !== FALSE)
                      {    
//                         $category = $this->Categorymodal->getCategory($importdata[9],$importdata[34],$importdata[6]); 
//                         $subcategory = $this->SubCategorymodal->getSubCategory($importdata[10],$category); 
//                         $subSubcategory = $this->SubsubCategorymodal->getsubSubCategory($importdata[11],$subcategory); 
                        
                          $num = count($importdata);
                        
                          $row++;
                          if($row > 1){
                           
                          
                             $data = array(

                                 'createdDate' => date('Y-m-d h:i:sa'),                                
                                 'SKU' => $importdata[0], 
                                 'barcode' => (int)$importdata[1],
                                 'type' => $importdata[2], 
                                 'MPN' => $importdata[3],
                                 'model' => $importdata[4],
                                 'productName' =>$importdata[5],
                                 'shortDescription'=>$importdata[6], 
                                 'POSName' =>$importdata[5] .str_repeat('&nbsp;', 2) . $importdata[24].str_repeat('&nbsp;', 2).  $importdata[25].str_repeat('&nbsp;', 2) .$importdata[26],
                                 'barcodeFormats' =>$importdata[8],
                                 'firstCategory'=> $importdata[9],
                                 'secondCategory'=> $importdata[10],
                                 'thirdCategory'=> $importdata[11],
                                 'firstCategoryId'=> $category,
                                 'secondCategoryId'=> $subcategory,
                                 'thirdCategoryId'=> $subSubcategory,
                                 'genre'=> $importdata[12], 
                                 'clothingSize'=> $importdata[13],                              
                                 'color' => $importdata[14], 
                                 'features' => $importdata[15],
                                 'manufacturer' => $importdata[16],
                                 'brand' => $importdata[17], 
                                 'publisher' => $importdata[18], 
                                 'author' =>$importdata[19],
                                 'label' =>$importdata[20],
                                 'artist' =>$importdata[21],
                                 'director' =>$importdata[22],
                                 'actor'=> $importdata[23],
                                 'container'=> $importdata[24],
                                 'size'=> $importdata[25].str_repeat('&nbsp;', 2).$importdata[26],
                                 'servingsPerContainer' => (int)$importdata[27] ,
                                 'height' => $importdata[28],
                                 'width' => $importdata[29],
                                 'length' => $importdata[30],
                                 'weight' =>$importdata[31],
                                 'detailedDescription' =>$importdata[32],
                                 'Features' =>explode(',',$importdata[33]),
                                 'images' =>explode(',',$importdata[34]),
                                 'reviews'=> explode(',',$importdata[35]),
                                 'ingredients'=> $importdata[36],                        
                                 'shelfLife' => (int)$importdata[37].$importdata[38],
                             
                                 'storageTemperature' => (int)$importdata[39]. $importdata[40],
                                 
                                 'warning' =>$importdata[41],
                                 'allergyInformation' =>$importdata[42],
                                 
                                 'nutritionFacts' =>explode(',',$importdata[43]),
                                 
                                 'currency'=> $importdata[44],
                                 'priceValue'=>(int)$importdata[45],
                                 
                                 );

                            
                              $insertexcel = $this->ProductsModel->insertExcel($data); 
                      
                    
                       }
                      }
                      
                      
                     fclose($file);
                                redirect(base_url()."index.php?/Uflyproducts");  
                                 $this->session->set_flashdata('message', 'Data are imported successfully..');
                       }else{
                            $this->session->set_flashdata('message', 'Please select the .csv or .xls file');
                            redirect(base_url()."index.php?/Uflyproducts");
                   }
                  }

        
    }
    
      public function delete_product() {

        $this->ProductsModel->delete_product();
  
    }
    public function permanentDeleteProduct() {

        $this->ProductsModel->permanentDeleteProduct();
  
    }

    
      public function deleteStoreProduct() {

        $this->ProductsModel->deleteStoreProduct();
  
    }
      public function banStoreProduct() {

        $this->ProductsModel->banStoreProduct();
  
    }
      public function rejectStoreProduct() {

        $this->ProductsModel->rejectStoreProduct();
  
    }
      public function approveStoreProduct() {

        $this->ProductsModel->approveStoreProduct();
  
    }
      public function AddNewProductData() {
        $data = $this->ProductsModel->AddNewProductData();
        redirect(base_url()."index.php?/AddNewProducts"); 
        exit;
    }
      public function updateProductData($id = '') {
        $data = $this->ProductsModel->updateProductData($id);
        redirect(base_url()."index.php?/AddNewProducts"); 
        exit;
    }
    
       public function unitsList($id = '') {
     
         $this->ProductsModel->unitsList($id);
       
    }
       public function storeUnitsList($id = '') {
     
         $this->ProductsModel->storeUnitsList($id);
       
    }
       public function reviewlist($id = '') {
     
         $this->ProductsModel->reviewlist($id);
       
    }
     public function viewDescriptionlist($id = '') {
     
         $this->ProductsModel->viewDescriptionlist($id);
       
    }
     public function viewShortDescriptionlist($id = '') {
     
         $this->ProductsModel->viewShortDescriptionlist($id);
       
    }
    public function imagelist($id = '') {

         $this->ProductsModel->imagelist($id);
       
    }
    public function nutrilist($id = '') {

         $this->ProductsModel->nutrilist($id);
       
    }
    public function strainEffects($id = '') {

         $this->ProductsModel->strainEffects($id);
       
    }
    public function medicalAttributes($id = '') {

         $this->ProductsModel->medicalAttributes($id);
       
    }
    public function negativeAttributes($id = '') {

         $this->ProductsModel->negativeAttributes($id);
       
    }
    public function flavours($id = '') {

         $this->ProductsModel->flavours($id);
       
    }
     public function get_cities() {
        $data = $this->ProductsModel->getCities();
        print_r($data);
//        echo json_encode($data); 
    }
    // Get products count
   
    
}
