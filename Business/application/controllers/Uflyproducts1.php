<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//echo 1;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Uflyproducts extends CI_Controller {

  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Uflyproductsmodal');
        $this->load->model('Categorymodal');
        $this->load->model('SubCategorymodal');
        $this->load->model('SubsubCategorymodal');
        $this->load->library('mongo_db');
        

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
 
     public function product_details() {
        $this->Uflyproductsmodal->product_details();
    }
     public function product_detailsProducts() {
        $this->Uflyproductsmodal->product_detailsProducts();
    }
    public function updateProductData($id = '') {
        $data = $this->Uflyproductsmodal->updateProductData($id);
        redirect(base_url()."index.php?/Uflyproducts/uflyStoreProducts"); 
        exit;
    }
    public function unitsList($id = '') {
     
         $this->Uflyproductsmodal->unitsList($id);
       
    }
    public function getUnitsEdit($id = '') {
     
         $this->Uflyproductsmodal->getUnitsEdit($id);
       
    }
      public function index($status = '') {
        $data['product_data'] = $this->Uflyproductsmodal->getProductData();
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
        $this->table->set_heading('SL NO','Product Name','Category','SUB-Category','SUB-SUB Category','UNITS','SKU','BARCODE','SHORT Description ','Detailed Description ','POS NAME','Barcode Format','THC %','CBD %','Images','Strain Effects','Medical Attributes
','Negatives Attributes','Flavors','select');
        
     
                
        $data['pagename'] = "Uflyproducts/uflyProducts";
        $this->load->view("template", $data);
    }
    public function addNewProduct() {
       $data['storeID'] = $this->session->userdata('badmin')['BizId'];
       $data['zoneId'] = $this->Uflyproductsmodal->getZoneId($data['storeID']);
        $this->load->library('Datatables');
        $this->load->library('table');
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
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
             
        $data['pagename'] = "Uflyproducts/uflyAddNewProducts";
        $this->load->view("template", $data);
    }
    public function uflyEditProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['addon']=$this->Uflyproductsmodal->getAddOns();
        print_r( $data['addon']);die;
        $data['productId'] = $id;
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        $data['productsData'] = $this->Uflyproductsmodal->getData($id);
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
             
        $data['pagename'] = "Uflyproducts/uflyEditProducts";
        $this->load->view("template", $data);
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

                            
                              $insertexcel = $this->Uflyproductsmodal->insertExcel($data); 
                      
                    
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

        $this->Uflyproductsmodal->delete_product();
  
    }
      public function newProductData() {
       $storeSession = $this->session->all_userdata();
        $storeId = $storeSession['badmin']['BizId'];
           
        $this->Uflyproductsmodal->newProductData($storeId);
        redirect(base_url()."index.php?/Uflyproducts/uflyStoreProducts"); 
        exit;
  
    }
      public function AddNewProductData() {
        $now = new DateTime();
        $currentTime = $now->format('Y-m-d H:i:s');

        $cursor = $this->mongo_db->get('childProducts');
        $arr = [];
   
        foreach ($cursor as $catdata) {
            array_push($arr, $catdata['seqId']);
        }
        $max = max($arr);
        $seq = $max + 1;

        $data1 = $_POST;
     
        
        $category = $_POST['firstCategoryId'];
        
        $data1['parentProductId'] = $_POST['parentProductId'];
        $data1['seqId'] = $seq;
        $data1['currentDate'] = $currentTime;
        $storeSession = $this->session->all_userdata();
        $storeId = $storeSession['badmin']['BizId'];
        $data1['storeId'] = new MongoDB\BSON\ObjectID($storeId);
        
        $data = $this->Uflyproductsmodal->AddNewProductData($data1,$category);
        
        if ($data) {
            echo json_encode(array('status' => true, 'message' => 'Product added successfully'));
        }else{
            echo json_encode(array('status' => false, 'massage' => 'Unable to add product'));
        }
           
    }
    
       public function getUnits() {
     
         $this->Uflyproductsmodal->getUnits();
       
    }
       public function reviewlist($id = '') {
     
         $this->Uflyproductsmodal->reviewlist($id);
       
    }
       public function reviewlistProducts($id = '') {
     
         $this->Uflyproductsmodal->reviewlistProducts($id);
       
    }
       public function viewDescriptionlist($id = '') {
     
         $this->Uflyproductsmodal->viewDescriptionlist($id);
       
    }
       public function viewShortDescriptionlist($id = '') {
     
         $this->Uflyproductsmodal->viewShortDescriptionlist($id);
       
    }
       public function viewDescriptionlistProducts($id = '') {
     
         $this->Uflyproductsmodal->viewDescriptionlistProducts($id);
       
    }
       public function viewShortDescriptionlistProducts($id = '') {
     
         $this->Uflyproductsmodal->viewShortDescriptionlistProducts($id);
       
    }
    public function imagelist($id = '') {

         $this->Uflyproductsmodal->imagelist($id);
       
    }
    public function imagelistProducts($id = '') {

         $this->Uflyproductsmodal->imagelistProducts($id);
       
    }
    public function nutrilist($id = '') {

         $this->Uflyproductsmodal->nutrilist($id);
       
    }
    public function nutrilistProducts($id = '') {

         $this->Uflyproductsmodal->nutrilistProducts($id);
       
    }
    public function strainEffects($id = '') {

         $this->Uflyproductsmodal->strainEffects($id);
       
    }
    public function strainEffectsProducts($id = '') {

         $this->Uflyproductsmodal->strainEffectsProducts($id);
       
    }
    public function medicalAttributes($id = '') {

         $this->Uflyproductsmodal->medicalAttributes($id);
       
    }
    public function medicalAttributesProducts($id = '') {

         $this->Uflyproductsmodal->medicalAttributesProducts($id);
       
    }
    public function negativeAttributes($id = '') {

         $this->Uflyproductsmodal->negativeAttributes($id);
       
    }
    public function negativeAttributesProducts($id = '') {

         $this->Uflyproductsmodal->negativeAttributesProducts($id);
       
    }
    public function flavours($id = '') {

         $this->Uflyproductsmodal->flavours($id);
       
    }
    public function flavoursProducts($id = '') {

         $this->Uflyproductsmodal->flavoursProducts($id);
       
    }
     public function get_cities() {
        $data = $this->Uflyproductsmodal->getCities();
        print_r($data);
//        echo json_encode($data); 
    }
    public function getProductDetailsById($id=""){
        if (!isset($id) || empty($id)) {
            echo json_encode(array("status" => false, 'message' => 'Mandatory field ID is missing'));

        }else{
            $response = $this->Uflyproductsmodal->getProductDetailsById($id);
        }
    }

    public function uflyStoreProducts(){
        // $data['product_data'] = $this->Uflyproductsmodal->getStoreProductData();
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
        $this->table->set_heading('SL NO','Product Name','Category','SUB-Category','SUB-SUB Category','UNITS','SKU','BARCODE','SHORT Description ','Detailed Description ','POS NAME','Barcode Format','THC %','CBD %','Images','Strain Effects','Medical Attributes','Negatives Attributes','Flavors','SORT','select');
                
        $data['pagename'] = "admin/uflyStoreProducts";
        $this->load->view("template", $data);

    }
    public function uflyStoreProductDetails() {
        $this->Uflyproductsmodal->uflyStoreProductDetails();
    }
    public function getUnitsForStore($id) {
        $this->Uflyproductsmodal->getUnitsForStore($id);
    }

    
}
