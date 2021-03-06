<?php

// testing
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ProductOffersredemtion extends CI_Controller {
  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model('productOffersmodal');
        $this->load->model('Categorymodal');
        $this->load->model('SubCategorymodal');
        $this->load->model('SubsubCategorymodal');
        
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        $this->lang->load('offer_lang', $language);
        
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
       public function index($status = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        
        $data['language'] = $this->productOffersmodal->getlanguageText();
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
        $this->table->set_heading('Sl no','Booking ID','Offer ID','User ID','Total Value','Discount','Time Stamp');
    
        $data['pagename'] = "Offers/ProductOffersredemtionview";
        $this->load->view("company", $data);
    }
    
    public function addNewOffer() {

        $data['language'] = $this->productOffersmodal->getlanguageText();
        $data['cities'] = $this->productOffersmodal->getAllCities();
//        echo '<pre>'; print_r($data['cities']); die;
//        $data['stores'] = $this->Categorymodal->getStores();
        // $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        
        
        $data['pagename'] = "Offers/addNewOffer";
        $this->load->view("company", $data);
    }
    
    //fetch all details
    public function offer_details($status){

         
         $offset=(int)$_POST['iDisplayStart']/10;
         $limit=(int)$_POST['iDisplayLength'];
        
        // $offset=0;
        // $limit=10;

        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

            $productoffers=$this->productOffersmodal->offer_details($status,$offset, $limit);
             
            $data = [];
            $sno =$_POST['iDisplayStart']+1;
           foreach($productoffers["data"] as $campaignData) {
              // print_r($campaignData);
             
                     $data[] = [
                            $sno,
                            $campaignData['name'][0],
                            $campaignData['city'],
                            $campaignData['franchise'],
                            $campaignData['storeName'],
                            $campaignData['applicableOnStatus'],
                            $campaignData['offerTypeString'],
                            $campaignData['discountValue'],
                            $campaignData['minimumPurchaseQty'],
                            //$campaignData['startDateTimeISO'],
                           // $campaignData['endDateTimeISO'],
                           date( "Y-m-d H:i:s", strtotime($campaignData['startDateTimeISO'])),
                             date( "Y-m-d H:i:s", strtotime($campaignData['endDateTimeISO'])),
                            $campaignData['globalClaimCount'],
                            $campaignData['status'],
                            '<center>'.
                            '<a href="'. base_url() .'index.php?/productOffers/editCampaigns/'.$campaignData['offerId'].'"> <button class="btn btnedit btn-primary cls111 " id="edit" style="width:35px; border-radius: 25px;""><i class="fa fa-edit" style="font-size:12px;"></i></button></a>
                            </center>',
                            '<center>
                              <input type="checkbox" class="checkbox1" name="checkbox[]" value="' . $campaignData['offerId'].'"/>
                          </center>'
                          ];
                    $sno=$sno+1;

            }
            
            $output = array(    
                "draw" => $draw,
                "recordsTotal" => $productoffers['totalCount'],
                // "recordsFiltered" => count($campaignDatas['data']),
                "recordsFiltered" => $productoffers['totalCount'],
                "data" => $data
            );
        
        echo json_encode($output);
        exit();
    }

    //status update
    public function updatecouponCodeStatus(){
        $offerIds = $this->input->post("offerId");
        $status   = $this->input->post("status");
        $response = $this->productOffersmodal->updateOfferStatus($status, $offerIds);
        echo json_encode(array('msg' => $response));
      }

     public function data_details($status = '') {
        $this->productOffersmodal->data_details($status);
    }
    
     public function getFranchiseData($id) { 
        $this->productOffersmodal->getFranchiseData($id);
    }
     public function getStoreData($id) {
        $this->productOffersmodal->getStoreData($id);
    }
     public function getProductData($id) {
        $this->productOffersmodal->getProductData($id);
    }
    public function getUnitsData($id) {
        $this->productOffersmodal->getUnitsData($id);
    }
    public function getCategoryData($id) {
        $this->productOffersmodal->getCategoryData($id);
    }
    public function getSubCategoryData($id) {
        $this->productOffersmodal->getSubCategoryData($id);
    }
    public function getSubSubCategoryData($id) {
        $this->productOffersmodal->getSubSubCategoryData($id);
    }
     public function AddNewOffersData() {
        $this->productOffersmodal->AddNewOffersData();
        //redirect('ProductOffers/index');
    }
    public function editNewOffersData() {
        $this->productOffersmodal->editNewOffersData();
        //redirect('ProductOffers/index');
    }


     public function getBrand($id = '') {
        $data1 = $this->productOffersmodal->getBrand($id);
        echo json_encode(array('data' => $data1));
    }
     public function editBrand() {
        $this->productOffersmodal->editBrand();
    }
     public function activateBrand() {
        $this->productOffersmodal->activateBrand();
    }
     public function deactivateBrand() {
        $this->productOffersmodal->deactivateBrand();
    }
   
    public function editCampaigns($id){
        /*changes required*/
        $data['pagename'] = "Offers/editNewOffer";
        $data['campaignId'] = $id;
        $this->load->view("company", $data);
    }
    
}
