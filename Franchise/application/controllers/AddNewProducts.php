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
        $this->load->model('Productsmodal');
        $this->load->model('Categorymodal');
        $this->load->model('SubCategorymodal');
        $this->load->model('SubsubCategorymodal');
        $this->load->model('Productsmodal');
        $this->load->model('GridProductModel');
        $this->load->library('mongo_db');
        
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('product_lang', $language);
     

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function product_details() {
        $this->Productsmodal->product_details();
    }

    public function product_detailsProducts() {
        $this->Productsmodal->product_detailsProducts();
    }

    public function updateProductData($id = '') {
        $data = $this->Productsmodal->updateProductData($id);
        redirect(base_url() . "index.php?/Uflyproducts/uflyStoreProducts");
        exit;
    }

    public function unitsList($id = '') {
        $this->Productsmodal->unitsList($id);
    }

    public function getUnitsEdit($id = '') {
        $this->Productsmodal->getUnitsEdit($id);
    }

    public function index($status = '') {
        $data['product_data'] = $this->Productsmodal->getProductData();
        $this->load->library('Datatables');
        $this->load->library('table');
        $data['language'] = $this->Productsmodal->getlanguageText();
        $data['size'] = $this->Productsmodal->getActiveSize();
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127PX;">',
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
        $this->table->set_heading('SL NO', 'Product Name', 'Category', 'SUB-Category', 'SUB-SUB Category', 'UNITS');

        $data['pagename'] = "Uflyproducts/mainProducts";
        $this->load->view("SuperAdmin_Dashbord", $data);
    }
	 public function FranchiseProducts() {
        // $data['product_data'] = $this->Productsmodal->getStoreProductData();

        $franchiseId=$this->session->userdata('fadmin')['MasterBizId'];
        $data['products'] = $this->GridProductModel->get_product($franchiseId);
        $data['category']=$this->GridProductModel->getCategory();
       

        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;font-size:11px;">',
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
        $this->table->set_heading('Sl No', 'Product Name', 'Category', 'Sub-Category', 'Sub-Sub Category', 'Units', 'Action' ,'Select');

        $data['pagename'] = "Uflyproducts/childProducts";
        $this->load->view("SuperAdmin_Dashbord", $data);
    }
	 public function StoreList($productid = '') {
        // $data['product_data'] = $this->Productsmodal->getStoreProductData();
		
        $this->load->library('Datatables');
        $this->load->library('table');
        $data['productName'] = $this->Productsmodal->getProductName($productid);
		$data['productId'] = $productid;
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;font-size:11px;">',
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
        $this->table->set_heading('Sl No', 'Store Name', 'Store Type', 'Select' );

        $data['pagename'] = "Uflyproducts/pushToChildProducts";
        $this->load->view("SuperAdmin_Dashbord", $data);
    }
	public function pushFranchiseProductsToStores(){
		 $this->Productsmodal->pushFranchiseProductsToStores();
		
	}

    public function addNewProduct() {
      
        $data['franchiseId'] = $this->session->userdata('fadmin')['MasterBizId'];

        $data['AllBusinesses'] = $this->Productsmodal->GetAllBusinesses($data['franchiseId']);
        $data['currencySymbol'] = $this->session->userdata('fadmin')['Currency'];
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_BusinessId();  
        $data['color'] = $this->Productsmodal->getActiveColors();
       // $data['size'] = $this->Productsmodal->getActiveSize();
       $data['storeType'] = $this->session->userdata('fadmin')['storeType'];
        $data['manufacturer'] = $this->Productsmodal->getManufacturer();
        $data['brands'] = $this->Productsmodal->getBrands();
        $data['language'] = $this->Productsmodal->getlanguageText();
        $data['addon']=$this->Productsmodal->getAddOns();
        $data['taxData'] = $this->Productsmodal->getTaxData($data['franchiseId']);
        $data['zoneId'] = $this->Productsmodal->getZoneId($data['franchiseId']);
        $this->load->library('Datatables');
        $this->load->library('table');
       // $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        
       // $data['pagename'] = "Uflyproducts/AddNewChildProduct";
       $data['pagename'] = "Uflyproducts/uflyAddNewProducts";
        $this->load->view("SuperAdmin_Dashbord", $data);
    }

      // edit add on page
      public function editAddOns($val) {
        
        $data['storeID'] = $this->session->userdata('fadmin')['MasterBizId'];
        $data['language'] = $this->Productsmodal->getlanguageText();
        $data['size'] = $this->Productsmodal->getActiveSize();
        $data['addon']=$this->Productsmodal->getAddOns();
        $storeId = $this->session->userdata('badmin')['BizId'];
        $data['storeType']=$this->Productsmodal->getStoreType($storeId);
        $data['currencySymbol'] = $this->Productsmodal->getAppConfigData();
        
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
       $this->table->set_heading('SL NO','NAME','DESCRIPTION','ADDONS','SELECT');
       $data['unitId']=$val;
       $data['pagename'] = "Uflyproducts/uflyAddOnAdd";
       $this->load->view("SuperAdmin_Dashbord", $data);
      
    }

    public function addProductFromMain($id = '') {
        $data['productId'] = $id;
//        print_r($data['productId']); die;
        $data['franchiseId'] = $this->session->userdata('fadmin')['MasterBizId'];
        $data['AllBusinesses'] = $this->Productsmodal->GetAllBusinesses($this->session->userdata('fadmin')['MasterBizId']);

        $data['currencySymbol'] = $this->Productsmodal->getAppConfigData();
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        $data['color'] = $this->Productsmodal->getActiveColors();
        $data['size'] = $this->Productsmodal->getActiveSize();
        $data['manufacturer'] = $this->Productsmodal->getManufacturer();
        $data['brands'] = $this->Productsmodal->getBrands();
        $data['language'] = $this->Productsmodal->getlanguageText();
        
        $data['taxData'] = $this->Productsmodal->getTaxData($data['franchiseId']);

        $data['zoneId'] = $this->Productsmodal->getZoneId($data['franchiseId']);
        $this->load->library('Datatables');
        $this->load->library('table');
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        
        $data['pagename'] = "Uflyproducts/AddChildProduct";
        $this->load->view("SuperAdmin_Dashbord", $data);
    }

//      public function getSelectedBrands() {
//        $this->Productsmodal->getSelectedBrands();
//    }
    
    public function EditProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['productId'] = $id;
        $data['franchiseID'] = $this->session->userdata('fadmin')['MasterBizId'];
        $data['currencySymbol'] = $this->session->userdata('fadmin')['Currency'];
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        $data['color'] = $this->Productsmodal->getActiveColors();
        $data['storeType'] = $this->session->userdata('fadmin')['storeType'];
        // $data['size'] = $this->Productsmodal->getActiveSize();
        $data['manufacturer'] = $this->Productsmodal->getManufacturer();
        $data['brands'] = $this->Productsmodal->getBrands();
        $data['language'] = $this->Productsmodal->getlanguageText();
        $data['taxData'] = $this->Productsmodal->getTaxData($data['franchiseID']);
        $data['zoneId'] = $this->Productsmodal->getZoneId($data['franchiseID']);
        $data['productsData'] = $this->Productsmodal->getData($id);
      // echo '<pre>'; print_r($data);die;
        $data['pagename'] = "Uflyproducts/EditChildProduct";
        $this->load->view("SuperAdmin_Dashbord", $data);
       
    }

    function reorderProducts() {
        $this->Productsmodal->reorderProducts();
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


                        $insertexcel = $this->Productsmodal->insertExcel($data);
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

        $this->Productsmodal->delete_product();
    }

    public function newProductData() {
        $storeSession = $this->session->all_userdata();
        $storeId = $storeSession['badmin']['BizId'];

        $this->Productsmodal->newProductData($storeId);
        redirect(base_url() . "index.php?/Uflyproducts/uflyStoreProducts");
        exit;
    }



    public function AddNewProductData() {
        $now = new DateTime();
        $currentTime = $now->format('Y-m-d H:i:s');
        $data1 = $_POST;
        $category = $_POST['firstCategoryId'];
        
        $data1['parentProductId'] = $_POST['parentProductId'];
//        $data1['seqId'] = $seq;
        $data1['currentDate'] = $currentTime;
        // $storeSession = $this->session->all_userdata();
        $franchiseId =$this->session->userdata('fadmin')['MasterBizId'];
        $data1['franchiseId'] = (string)(new MongoDB\BSON\ObjectID($franchiseId));
       
        $data = $this->Productsmodal->AddNewProductData($data1,$category);
//       print_r($data); die;
        if ($data) {
            echo json_encode(array('status' => true, 'message' => 'Product added successfully'));
            redirect(base_url()."index.php?/AddNewProducts/FranchiseProducts"); 
//            exit;
        }else{
            echo json_encode(array('status' => false, 'massage' => 'Unable to add product'));
        }
           
    }

    public function getUnits() {

        $this->Productsmodal->getUnits();
    }

    public function reviewlist($id = '') {

        $this->Productsmodal->reviewlist($id);
    }

    public function reviewlistProducts($id = '') {

        $this->Productsmodal->reviewlistProducts($id);
    }

    public function viewDescriptionlist($id = '') {

        $this->Productsmodal->viewDescriptionlist($id);
    }

    public function viewShortDescriptionlist($id = '') {

        $this->Productsmodal->viewShortDescriptionlist($id);
    }

    public function viewDescriptionlistProducts($id = '') {

        $this->Productsmodal->viewDescriptionlistProducts($id);
    }

    public function viewShortDescriptionlistProducts($id = '') {

        $this->Productsmodal->viewShortDescriptionlistProducts($id);
    }

    public function imagelist($id = '') {

        $this->Productsmodal->imagelist($id);
    }

    public function imagelistProducts($id = '') {

        $this->Productsmodal->imagelistProducts($id);
    }

    public function nutrilist($id = '') {

        $this->Productsmodal->nutrilist($id);
    }

    public function nutrilistProducts($id = '') {

        $this->Productsmodal->nutrilistProducts($id);
    }

    public function strainEffects($id = '') {

        $this->Productsmodal->strainEffects($id);
    }

    public function strainEffectsProducts($id = '') {

        $this->Productsmodal->strainEffectsProducts($id);
    }

    public function medicalAttributes($id = '') {

        $this->Productsmodal->medicalAttributes($id);
    }

    public function medicalAttributesProducts($id = '') {

        $this->Productsmodal->medicalAttributesProducts($id);
    }

    public function negativeAttributes($id = '') {

        $this->Productsmodal->negativeAttributes($id);
    }

    public function negativeAttributesProducts($id = '') {

        $this->Productsmodal->negativeAttributesProducts($id);
    }

    public function flavours($id = '') {

        $this->Productsmodal->flavours($id);
    }

    public function flavoursProducts($id = '') {

        $this->Productsmodal->flavoursProducts($id);
    }

    public function get_cities() {
        $data = $this->Productsmodal->getCities();
        print_r($data);
//        echo json_encode($data); 
    }

    public function getProductDetailsById($id = "") {
        if (!isset($id) || empty($id)) {
            echo json_encode(array("status" => false, 'message' => 'Mandatory field ID is missing'));
        } else {
            $response = $this->Productsmodal->getProductDetailsById($id);
        }
    }

    public function StoreProducts() {
        // $data['product_data'] = $this->Productsmodal->getStoreProductData();
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
        $this->table->set_heading('SL NO', 'Product Name', 'Category', 'SUB-Category', 'SUB-SUB Category', 'UNITS',  'select');

        $data['pagename'] = "Uflyproducts/childProducts";
        $this->load->view("SuperAdmin_Dashbord", $data);
    }

    public function StoreProductDetails($status) {
        $this->Productsmodal->StoreProductDetails($status);
    }
	  public function StoreListDetails($status) {
        $this->Productsmodal->StoreListDetails($status);
    }

    public function getUnitsForFranchise($id) {
        $this->Productsmodal->getUnitsForFranchise($id);
    }

      //Add on detail cool
      public function addOn_details($status = '') {
        $this->Productsmodal->addOn_details($status);
    }

    
    public function editAddOnsList($id = '') {
        $this->Productsmodal->editAddOnsList($id);
    }
       
    public function getUnitsList() {

        $this->Productsmodal->getUnitsList();
    }

      //addon list
      public function addOnsList($id = '') {
        $this->Productsmodal->addOnsList($id);
    }

      // edit Addon price 
      public function editAddnewAddOnData(){
        $data = $this->Productsmodal->editAddnewAddOnData();
       
    }

     //set price insert
     public function AddnewAddOnData(){
        $data = $this->Productsmodal->AddnewAddOnData();
        // if ($data) {
        //     redirect(base_url()."index.php?/AddOns"); 
        // }
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
        $franchiseId = $this->session->userdata('fadmin')['MasterBizId'];
        $data1['franchiseId'] = (string) (new MongoDB\BSON\ObjectID($franchiseId));

//        echo '<pre>'; print_r($data1); die;

        $data = $this->Productsmodal->AddNewProductData($data1, $category);

        if ($data) {
            echo json_encode(array('status' => true, 'message' => 'Product added successfully'));
            //  redirect(base_url()."index.php?/AddNewProducts"); 
        } else {
            echo json_encode(array('status' => false, 'massage' => 'Unable to add product'));
        }
    }

    public function getProductsBySerach(){
      
        $this->Productsmodal->getProductsBySerach();
  }

  public function getProductDataDetail($id = '') {
    $this->Productsmodal->getProductDataDetail($id);

    }

    public function getAddonData() {
        $addOnIds = $this->input->post("val");
        $this->Productsmodal->getAddonData($addOnIds);
    }

    public function getStore(){
        $this->Productsmodal->getStore();
    }  

    public function pullProductToStore(){
        $this->Productsmodal->pullProductToStore();
    } 

   

}
