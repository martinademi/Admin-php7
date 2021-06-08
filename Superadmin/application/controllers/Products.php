<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//echo 1;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Products extends CI_Controller {

  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model('Productsmodal');
        $this->load->model('Categorymodal');
        $this->load->model('SubCategorymodal');
        $this->load->model('SubsubCategorymodal');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
 
     public function product_details() {
        $this->Productsmodal->product_details();
    }
      public function index($status = '') {
        $data['product_data'] = $this->Productsmodal->getProductData();
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
        $this->table->set_heading('SL NO','SKU','BARCODE','TYPE','MPN','MODEL','Product Name','SHORT Description ','POSName','Barcode Formats','First Category',
                                  'Second Category','Third Category','Genre','Clothing_Size','Color','Manufacturer','Brand',
                                  'Publisher','Author','Label','Artist','Director','Actor','Container','Size','servings per container','Height',
                                  'Width','Length','Weight','Detailed Description','Features','Images','Reviews','Ingredients','shelf life',
                                  'storage Tempearture','warning','allergy information','Nutrition facts','currency','price value','select');
        
     
                
        $data['pagename'] = "Products/products";
        $this->load->view("company", $data);
    }
    public function addNewProduct() {

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
             
        $data['pagename'] = "Products/addNewProducts";
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

                            
                              $insertexcel = $this->Productsmodal->insertExcel($data); 
                      
                    
                       }
                      }
                      
                      
                     fclose($file);
                                redirect(base_url()."index.php?/Products");  
                                 $this->session->set_flashdata('message', 'Data are imported successfully..');
                       }else{
                            $this->session->set_flashdata('message', 'Please select the .csv or .xls file');
                            redirect(base_url()."index.php?/Products");
                   }
                  }

        
    }
    
      public function delete_product() {

        $this->Productsmodal->delete_product();
  
    }
      public function AddNewProductData() {

        $data = $this->Productsmodal->AddNewProductData();
           
    }
    
       public function reviewlist($id = '') {
     
         $this->Productsmodal->reviewlist($id);
       
    }
    public function imagelist($id = '') {

         $this->Productsmodal->imagelist($id);
       
    }
    public function nutrilist($id = '') {

         $this->Productsmodal->nutrilist($id);
       
    }
     public function get_cities() {
        $data = $this->Productsmodal->getCities();
        print_r($data);
//        echo json_encode($data); 
    }
    
}
