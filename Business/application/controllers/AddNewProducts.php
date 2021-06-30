<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class AddNewProducts extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
		$this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model('Uflyproductsmodal');
        $this->load->model('Categorymodal');
        $this->load->model('SubCategorymodal');
        $this->load->model('SubsubCategorymodal');
        $this->load->library('mongo_db');
        $this->load->model('Centralmodal');
        $this->load->library('session');
        $this->load->model('GridProductModel');
        
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('headerNav_lang',$language);
        $this->lang->load('product_lang', $language);

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
        redirect(base_url() . "index.php?/AddNewProducts/StoreProducts");
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
		$this->load->library('session');
		
        $data['language'] = $this->Uflyproductsmodal->getlanguageText();
      //  $data['size'] = $this->Uflyproductsmodal->getActiveSize();
    //   chnages done
        $data['addon']=$this->Uflyproductsmodal->getAddOns();
        
        $storeId = $this->session->userdata('badmin')['BizId'];
		
        $data['storeType']=$this->Uflyproductsmodal->getStoreType($storeId);
        $data['currencySymbol'] = $this->Uflyproductsmodal->getAppConfigData();
     
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
      //  $this->table->set_heading('SL NO', 'Product Name', 'Category', 'SUB-Category', 'SUB-SUB Category', 'UNITS', 'select');

        $this->table->set_heading($this->lang->line('col_slno'),$this->lang->line('col_productName'),$this->lang->line('col_catname'),$this->lang->line('col_subcat'),
        $this->lang->line('col_subsubcat'),$this->lang->line('col_units'),$this->lang->line('col_addons')
        );

        $data['pagename'] = "Uflyproducts/uflyProducts";
        $this->load->view("template", $data);
    }

    public function addNewProduct() {
		
        $data['storeID'] = $this->session->userdata('badmin')['BizId'];
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_BusinessId();            
        $data['color'] = $this->Uflyproductsmodal->getActiveColors();
        $data['manufacturer'] = $this->Uflyproductsmodal->getManufacturer();
        $data['brands'] = $this->Uflyproductsmodal->getBrands($data['storeID']);   
        $data['language'] = $this->Uflyproductsmodal->getlanguageText();
        $data['storeType'] = $this->session->userdata('badmin')['storeType'];
        $data['currencySymbol'] = $this->session->userdata('badmin')['currencySymbol'];
        $data['addon']=$this->Uflyproductsmodal->getAddOns();
        $data['taxData'] = $this->Uflyproductsmodal->getTaxData($data['storeID']);       
        $data['zoneId'] = $this->Uflyproductsmodal->getZoneId($data['storeID']);
        $data['symptoms']=$this->Uflyproductsmodal->getSymptoms();
        $data['generic']=$this->Uflyproductsmodal->getGeneric();
        $data['branded']=$this->Uflyproductsmodal->getBranded();
        $this->load->library('Datatables');
        $this->load->library('table');

        // has some junk data stored comment if page loading inceases need to check
        $data['size'] = $this->Uflyproductsmodal->getActiveSize();
        
        $data['pagename'] = "Uflyproducts/uflyAddNewProducts";
        $this->load->view("template", $data);
    }

    public function EditProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['productId'] = $id;
        $data['currencySymbol'] = $this->session->userdata('badmin')['currencySymbol'];
        $data['storeID'] = $this->session->userdata('badmin')['BizId'];
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_BusinessId();
        $data['productsData'] = $this->Uflyproductsmodal->getData($id);
        $data['language'] = $this->Uflyproductsmodal->getlanguageText();
        $data['addon']=$this->Uflyproductsmodal->getAddOns();
        $data['pagename'] = "Uflyproducts/uflyEditProducts";
        $data['taxData'] = $this->Uflyproductsmodal->getTaxData($data['storeID']);
        $data['symptoms']=$this->Uflyproductsmodal->getSymptoms();
        $data['generic']=$this->Uflyproductsmodal->getGeneric();
        $data['branded']=$this->Uflyproductsmodal->getBranded();
        $data['storeType'] = $this->session->userdata('badmin')['storeType'];
        $data['manufacturer'] = $this->Uflyproductsmodal->getManufacturer();
        $data['brands'] = $this->Uflyproductsmodal->getBrands($data['storeID']); 
        $data['color'] = $this->Uflyproductsmodal->getActiveColors();
        // has some junk data stored comment if page loading inceases need to check
        $data['size'] = $this->Uflyproductsmodal->getActiveSize();
        $this->load->view("template", $data);
    }

    public function getProductDataDetail($id = '') {
        $this->Uflyproductsmodal->getProductDataDetail($id);

    }

    public function loadCategory(){
        $cateData = $this->Categorymodal->getCategoryForFranchise_and_Business();
        echo json_encode(array("Category"=>$cateData));
     }
     public function loadSubCategory(){
         $subcateData = $this->SubCategorymodal->getSubCategoryByCategoryId();
         echo json_encode(array("subCategory"=>$subcateData));
     }
     public function loadSubSubCategory(){
         $subSubcateData = $this->SubsubCategorymodal->getSubSubCategoryByCategoryId();
         echo json_encode(array("subSubCategory"=>$subSubcateData));
     }
     public function loadManufacture(){
        $manuData =  $this->ProductsModel->getManufacturer();
        echo json_encode(array("manufacturer"=>$manuData));
     }
     public function loadBrand(){
         $brandData =  $this->ProductsModel->getBrands();
         echo json_encode(array("brand"=>$brandData));
      }

    function reorderProducts() {
        $this->Uflyproductsmodal->reorderProducts();
    }

    public function getProductsBySerach(){
      
           $this->Uflyproductsmodal->getProductsBySerach();
     }

    public function importExcel() {


        if (isset($_POST["import"])) {
            $filename = $_FILES["file"]["tmp_name"];
            if ($_FILES["file"]["size"] > 0) {
                $row = 0;
                $file = fopen($filename, "r");
                while (($importdata = fgetcsv($file)) !== FALSE) {
//                         $category = $this->Categorymodal->getCategory($importdata[9],$importdata[34],$importdata[6]); 
//                         $subcategory = $this->SubCategorymodal->getSubCategory($importdata[10],$category); 
//                         $subSubcategory = $this->SubsubCategorymodal->getsubSubCategory($importdata[11],$subcategory); 

                    $num = count($importdata);

                    $row++;
                    if ($row > 1) {


                        $data = array(
                            'createdDate' => date('Y-m-d h:i:sa'),
                            'SKU' => $importdata[0],
                            'barcode' => (int) $importdata[1],
                            'type' => $importdata[2],
                            'MPN' => $importdata[3],
                            'model' => $importdata[4],
                            'productName' => $importdata[5],
                            'shortDescription' => $importdata[6],
                            'POSName' => $importdata[5] . str_repeat('&nbsp;', 2) . $importdata[24] . str_repeat('&nbsp;', 2) . $importdata[25] . str_repeat('&nbsp;', 2) . $importdata[26],
                            'barcodeFormats' => $importdata[8],
                            'firstCategory' => $importdata[9],
                            'secondCategory' => $importdata[10],
                            'thirdCategory' => $importdata[11],
                            'firstCategoryId' => $category,
                            'secondCategoryId' => $subcategory,
                            'thirdCategoryId' => $subSubcategory,
                            'genre' => $importdata[12],
                            'clothingSize' => $importdata[13],
                            'color' => $importdata[14],
                            'features' => $importdata[15],
                            'manufacturer' => $importdata[16],
                            'brand' => $importdata[17],
                            'publisher' => $importdata[18],
                            'author' => $importdata[19],
                            'label' => $importdata[20],
                            'artist' => $importdata[21],
                            'director' => $importdata[22],
                            'actor' => $importdata[23],
                            'container' => $importdata[24],
                            'size' => $importdata[25] . str_repeat('&nbsp;', 2) . $importdata[26],
                            'servingsPerContainer' => (int) $importdata[27],
                            'height' => $importdata[28],
                            'width' => $importdata[29],
                            'length' => $importdata[30],
                            'weight' => $importdata[31],
                            'detailedDescription' => $importdata[32],
                            'Features' => explode(',', $importdata[33]),
                            'images' => explode(',', $importdata[34]),
                            'reviews' => explode(',', $importdata[35]),
                            'ingredients' => $importdata[36],
                            'shelfLife' => (int) $importdata[37] . $importdata[38],
                            'storageTemperature' => (int) $importdata[39] . $importdata[40],
                            'warning' => $importdata[41],
                            'allergyInformation' => $importdata[42],
                            'nutritionFacts' => explode(',', $importdata[43]),
                            'currency' => $importdata[44],
                            'priceValue' => (int) $importdata[45],
                        );


                        $insertexcel = $this->Uflyproductsmodal->insertExcel($data);
                    }
                }


                fclose($file);
                redirect(base_url() . "index.php?/Uflyproducts");
                $this->session->set_flashdata('message', 'Data are imported successfully..');
            } else {
                $this->session->set_flashdata('message', 'Please select the .csv or .xls file');
                redirect(base_url() . "index.php?/Uflyproducts");
            }
        }
    }

    public function delete_product() {

        $this->Uflyproductsmodal->delete_product();
    }

     //status update
    //  public function updatecouponCodeStatus(){
    //     $offerIds = $this->input->post("Id");
    //     $status   = $this->input->post("status");
    //     $response = $this->Uflyproductsmodal->updateOfferStatus($status, $offerIds);
    //     echo json_encode(array('msg' => $response));
    //   }

    public function updatecouponCodeStatus() {

        $this->Uflyproductsmodal->updatecouponCodeStatus();
  
    }

    public function permanentDeleteProduct() {

        $this->Uflyproductsmodal->permanentDeleteProduct();
  
    }

    public function newProductData() {
        $storeSession = $this->session->all_userdata();
        $storeId = $storeSession['badmin']['BizId'];

        $this->Uflyproductsmodal->newProductData($storeId);
        redirect(base_url() . "index.php?/Uflyproducts/uflyStoreProducts");
        exit;
    }

    public function AddNewProductData() {
		
        $now = new DateTime();
        $currentTime = $now->format('Y-m-d H:i:s');

        $data1 = $_POST;
        // echo '<pre>';print_r($data1);die;

        $category = $_POST['firstCategoryId'];

        $data1['parentProductId'] = $_POST['parentProductId'];
        $data1['seqId'] = $seq;
        $data1['currentDate'] = $currentTime;
        $storeSession = $this->session->all_userdata();
        $storeId = $storeSession['badmin']['BizId'];
        $data1['storeId'] = (string) (new MongoDB\BSON\ObjectID($storeId));

//        echo '<pre>'; print_r($data1); die;

        $data = $this->Uflyproductsmodal->AddNewProductData($data1, $category);

        if ($data) {
            echo json_encode(array('status' => true, 'message' => 'Product added successfully'));
             redirect(base_url()."index.php?/AddNewProducts/StoreProducts"); 
        } else {
            echo json_encode(array('status' => false, 'massage' => 'Unable to add product'));
        }
    }

    public function AddNewProductDataList() {
        $now = new DateTime();
        $currentTime = $now->format('Y-m-d H:i:s');

        $data1 = $_POST;
        

        $category = $_POST['firstCategoryId'];

        $data1['parentProductId'] = $_POST['parentProductId'];
        $data1['seqId'] = $seq;
        $data1['currentDate'] = $currentTime;
        $storeSession = $this->session->all_userdata();
        $storeId = $storeSession['badmin']['BizId'];
        $data1['storeId'] = (string) (new MongoDB\BSON\ObjectID($storeId));

//        echo '<pre>'; print_r($data1); die;

        $data = $this->Uflyproductsmodal->AddNewProductData($data1, $category);

        if ($data) {
            echo json_encode(array('status' => true, 'message' => 'Product added successfully'));
            //  redirect(base_url()."index.php?/AddNewProducts"); 
        } else {
            echo json_encode(array('status' => false, 'massage' => 'Unable to add product'));
        }
    }

    public function getUnits() {

        $this->Uflyproductsmodal->getUnits();
    }
    
    public function getUnitsList() {

        $this->Uflyproductsmodal->getUnitsList();
    }

    
    // edit add on page
    public function editAddOns($val) {
        
        $data['storeID'] = $this->session->userdata('badmin')['BizId'];
        $data['language'] = $this->Uflyproductsmodal->getlanguageText();
        $data['size'] = $this->Uflyproductsmodal->getActiveSize();
        $data['addon']=$this->Uflyproductsmodal->getAddOns();
        $storeId = $this->session->userdata('badmin')['BizId'];
        $data['storeType']=$this->Uflyproductsmodal->getStoreType($storeId);
        $data['currencySymbol'] = $this->Uflyproductsmodal->getAppConfigData();
        
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
       //$this->table->set_heading('SL NO','NAME','DESCRIPTION','ADDONS','SELECT');
       
       $this->table->set_heading($this->lang->line('col_slno'),$this->lang->line('col_name'),$this->lang->line('col_description'),$this->lang->line('col_addons'),
       $this->lang->line('col_select'));

       $data['unitId']=$val;
       $data['pagename'] = "Uflyproducts/uflyAddOnAdd";
       $this->load->view("template", $data);
      
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

    public function getProductDetailsById($id = "") {
        if (!isset($id) || empty($id)) {
            echo json_encode(array("status" => false, 'message' => 'Mandatory field ID is missing'));
        } else {
            $response = $this->Uflyproductsmodal->getProductDetailsById($id);
        }
    }

    //repo
    public function StoreProducts() {
     
        
        // Grid view changes
        $storeId=$this->session->userdata('badmin')['BizId'];
        //$data['products'] = $this->GridProductModel->get_product($storeId);
        $data['productsCount'] = $this->Uflyproductsmodal->getChildProductCount($storeId);
        // print_r($data['productsCount']);die;
        $data['category']=$this->GridProductModel->getCategory();
       
        $this->load->library('Datatables');
        $this->load->library('table');
        $data['storeId']=$this->session->userdata('badmin')['BizId'];
        $data['storeData'] = $this->Uflyproductsmodal->getCurrentStoreData($data['storeId']);
      
       
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
        $checkbox=' <input type="checkbox" id="select_all" />';
        //$this->table->set_heading('SL NO', 'Product Name', 'Category', 'SUB-Category', 'SUB-SUB Category', 'UNITS','Add-Ons','Sort','Created on','Success','Failed','Repeated',  'Select' ,'Status');
        $this->table->set_heading($this->lang->line('col_slno'),$this->lang->line('col_productName'),$this->lang->line('col_catname'),$this->lang->line('col_subcat'),
        $this->lang->line('col_subsubcat'),$this->lang->line('col_units'),$this->lang->line('col_addons'),
        $this->lang->line('col_sort'),$this->lang->line('col_createdOn'),$this->lang->line('col_success'),
        $this->lang->line('col_failed'),$this->lang->line('col_repeated'),$this->lang->line('col_select'),$this->lang->line('col_status'));

        $data['pagename'] = "admin/uflyStoreProducts";
        $this->load->view("template", $data);
    }

     

    public function StoreProductDetails($status) {
       
        $this->Uflyproductsmodal->uflyStoreProductDetails($status);
    }

    public function getUnitsForStore($id) {
        $this->Uflyproductsmodal->getUnitsForStore($id);
    }

    
    public function getAddonForStore($id) {
        $this->Uflyproductsmodal->getAddonForStore($id);
    }

    public function getBulkinfo($bulkId){

        $this->Uflyproductsmodal->getBulkinfo($bulkId);

    }

    //Add on detail cool
    public function addOn_details($status = '') {
        $this->Uflyproductsmodal->addOn_details($status);
    }

    //set price insert
    public function AddnewAddOnData(){
        $data = $this->Uflyproductsmodal->AddnewAddOnData();
        // if ($data) {
        //     redirect(base_url()."index.php?/AddOns"); 
        // }
    }

    public function editAddOnsList($id = '') {
        $this->Uflyproductsmodal->editAddOnsList($id);
    }

    // edit Addon price 
    public function editAddnewAddOnData(){
        $data = $this->Uflyproductsmodal->editAddnewAddOnData();
       
    }

    //addon list
    public function addOnsList($id = '') {
        $this->Uflyproductsmodal->addOnsList($id);
    }

     // ************ changes done for grid product*********

      //get data based on click
      public function productGridDisplay($status=''){       

        $storeId=$this->session->userdata('badmin')['BizId'];                
        $data['products'] = $this->GridProductModel->get_productGrid($status,$storeId);        

    }

      //pagination 
      public function get_productPagination($offset=''){ 
           
        $data['data'] = $this->GridProductModel->get_productPagination($offset);
       }

        //onclick of Grid button cool
    public function productGridView($status=''){      

        $storeId=$this->session->userdata('badmin')['BizId'];                
        $data['products'] = $this->GridProductModel->productGridView($status,$storeId);        

    }

    public function getAddonData() {
        $addOnIds = $this->input->post("val");
        $this->Uflyproductsmodal->getAddonData($addOnIds);
    }

}
