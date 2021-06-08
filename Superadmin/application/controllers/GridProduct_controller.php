<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GridProduct_controller extends CI_Controller {

    public function __construct() {
           
        parent::__construct();
      $this->load->helper('url');
      $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
      $this->load->model('GridProductModel');
      $this->load->model('ProductsModel');
      $this->load->model('Categorymodal');

      $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
      $this->lang->load('header_lang',$language);
      $this->lang->load('product_lang', $language);

      error_reporting(0);
      header("cache-Control: no-store, no-cache, must-revalidate");
      header("cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");
      header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
     
    }

    public function index($status=''){

        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
       
        $data['products'] = $this->GridProductModel->get_product();
        $count=$this->GridProductModel->get_productCount();
        $data['productCount']=ceil($count/10);         
        $data['category']=$this->GridProductModel->getCategory();
        $data['brand']=$this->GridProductModel->getBrand();
        $data['manufacturer']=$this->GridProductModel->getManufacturerlist();
        $data['pagename'] = "Gridproducts/GridProductView";
        $this->load->view("company", $data);

    }

    //deleted products for display
    public function deleted($status=''){

        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
       
        $data['products'] = $this->GridProductModel->get_productdeleted();
        $data['pagename'] = "Gridproducts/GridProductView";
        $this->load->view("company", $data);

    }

    //delete product
    public function deleteProduct($productId=''){

        
        $data['products'] = $this->GridProductModel->deleteProduct($productId);
        echo json_encode($data['products']) ;

    }

    //edit category
    public function EditProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['currencySymbol'] = $this->GridProductModel->getAppConfigData();
        $data['color'] = $this->GridProductModel->getActiveColors();
        $data['size'] = $this->GridProductModel->getActiveSize();
        $data['language'] = $this->GridProductModel->getlanguageText();
        $data['manufacturer'] = $this->GridProductModel->getManufacturer();
        $data['brands'] = $this->GridProductModel->getBrands();
        $data['productId'] = $id;
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        $data['productsData'] = $this->GridProductModel->getData($id);
             
        $data['pagename'] = "Gridproducts/editProducts";
        $this->load->view("company", $data);
    }

    

     //fetch product details in page
     public function get_productDetails($productId=''){
        $data['data'] = $this->GridProductModel->get_productDetails($productId);       
        $data['pagename'] = "Gridproducts/viewProductsDetails";
        $this->load->view("company", $data);
       }

   
       //pagination 
     public function get_productPagination($offset=''){        
        $data['data'] = $this->GridProductModel->get_productPagination($offset);
       }

       //view product details
       public function ViewProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['currencySymbol'] = $this->GridProductModel->getAppConfigData();
        $data['color'] = $this->GridProductModel->getActiveColors();
        $data['size'] = $this->GridProductModel->getActiveSize();
        $data['language'] = $this->GridProductModel->getlanguageText();
        $data['manufacturer'] = $this->GridProductModel->getManufacturer();
        $data['brands'] = $this->GridProductModel->getBrands();
        $data['productId'] = $id;
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        $data['productsData'] = $this->GridProductModel->getData($id);
     //  echo '<pre>';print_r($data['productsData']);die;
             
        $data['pagename'] = "Gridproducts/viewProductsDetails";
        $this->load->view("company", $data);
    }

    //sub cat dynamic
    public function getSubCategory(){

        $this->GridProductModel->getSubCategory();
    }

     //get category
     public function getCategorylist($categoryId='',$offset=''){

       // $storeId=$this->session->userdata('badmin')['BizId'];
        $data['category']=$this->GridProductModel->getCategorylist($categoryId,$offset);
      }

       //sub sub cat dynamic
    public function getSubSubCategory(){

        $this->GridProductModel->getSubSubCategory();
    }

    //sub category
    
    public function getSubCategorylist($categoryId){

        //$storeId=$this->session->userdata('badmin')['BizId'];
        $data['category']=$this->GridProductModel->getSubCategorylist($categoryId);
      }  

      //subsub category
    
     public function getSubSubCategorylist($categoryId){

        //$storeId=$this->session->userdata('badmin')['BizId'];
        $data['category']=$this->GridProductModel->getSubSubCategorylist($categoryId);
      } 

       //get brand product dispaly
     public function getBrandlistDetails($brandId){

        //$storeId=$this->session->userdata('badmin')['BizId'];
        $data['category']=$this->GridProductModel->getBrandlistDetails($brandId);
     }

     //manufracture
     public function getManufacturerslist($manufracturerId){

        //$storeId=$this->session->userdata('badmin')['BizId'];
        $data['category']=$this->GridProductModel->getManufacturerslist($manufracturerId);
     }

      //get data based on click
    public function productGridDisplay($status=''){

        

       // $storeId=$this->session->userdata('badmin')['BizId'];                
        $data['products'] = $this->GridProductModel->get_productGrid($status);
        

    }

    //fetch product details in model
    public function getUnitDetails($productId=''){

        $this->GridProductModel->getUnitDetails($productId);
        
         
 
     }
}
?>