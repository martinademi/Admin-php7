<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');

        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    
    public function DeleteProduct() {
        $this->load->model("Productsmodel");
        $this->Productsmodel->DeleteProduct();
    }

    public function index() {
        if ($this->issessionset()) {
            $this->load->model("Productsmodel");
            $data['language'] = $this->Productsmodel->get_lan_hlpText();
            $data['entitylist'] = $this->Productsmodel->GetAllProducts($this->session->userdata('fadmin')['MasterBizId']);
            $data['productlist'] = $this->Productsmodel->GetAllCategories($this->session->userdata('fadmin')['MasterBizId']);
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['pagename'] = "Products/Products";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Products");
    }
  function issessionset() {
        if ($this->session->userdata('fadmin')['MasterBizId']) {
            return true;
        }
        return false;
    }
      public function NewProduct() {
        if ($this->issessionset()) {
            $this->load->model("Productsmodel");
            $data['language'] = $this->Productsmodel->get_lan_hlpText();
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['ProfileData'] = $this->Productsmodel->GetProfileData($this->session->userdata('fadmin')['MasterBizId']);
            $data['AllBusinesses'] = $this->Productsmodel->GetAllBusinesses($this->session->userdata('fadmin')['MasterBizId']);
            $data['AllCats'] = $this->Productsmodel->GetAllCategories($this->session->userdata('fadmin')['MasterBizId']);
            $data['AllAddonCats'] = $this->Productsmodel->GetAllAddOnCats($this->session->userdata('fadmin')['MasterBizId']);
            $data['count'] = $this->Productsmodel->get_product_count($this->session->userdata('fadmin')['MasterBizId']);
            $data['pagename'] = "Products/ProductDetails";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/superadmin");
    }
     public function AddnewProduct() {
        $this->load->model("Productsmodel");
        $this->Productsmodel->AddnewProduct();
        redirect(base_url() . "index.php/Products");
    }
    
}
