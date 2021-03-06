<?php

// testing
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class productOffers extends CI_Controller {
  
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
         $this->lang->load('headerNav_lang',$language);
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
        // $checkbox=' <input type="checkbox" id="select_all" />';
       // $this->table->set_heading('Sl no','Name','City','Franchise','Applicable On','Offer Type','Discount','Minimum Purchase Quantity','Start Date','End Date','Global Usage Count','ACTION','SELECT');
       $this->table->set_heading($this->lang->line('col_slno'),$this->lang->line('col_name'),$this->lang->line('col_city'),$this->lang->line('col_franchise'),$this->lang->line('col_store'),$this->lang->line('col_applicableOn'),$this->lang->line('col_offerType'),$this->lang->line('col_discount'),$this->lang->line('col_minimumPurchaseQuantity'),$this->lang->line('col_startDate'),$this->lang->line('col_endDate'),$this->lang->line('col_globalUsageCount'),$this->lang->line('col_action'),$this->lang->line('col_select'));
    
        $data['pagename'] = "Offers/productOffers";
       $this->load->view("template", $data);
    }
    
    public function addNewOffer() {

        $data['language'] = $this->productOffersmodal->getlanguageText();
        $data['cities'] = $this->productOffersmodal->getAllCities();
        $data['storeId']=$this->session->userdata('badmin')['BizId'];
        $data['pagename'] = "Offers/addNewOffer";
        $this->load->view("template", $data);
    }
    
    //fetch all details
    public function offer_details($status,$stDate ='',$enDate =''){

         
        $offset=(int)$_POST['iDisplayStart']/10;
        $limit=(int)$_POST['iDisplayLength'];
        
        $cityId = $_POST['cityId'];
        $name = $_POST['sSearch'];

       // var_dump( $cityId);
       //  die;
       
        if (isset($_POST['cityId'])) {
           $cityId = $_POST['cityId'];
         }else{
           $cityId = "";
         }

         if (!$name) {
            $name = ""; 
         }
       // var_dump( $name);
       //  die;
      

       $draw = intval($this->input->get("draw"));
       $start = intval($this->input->get("start"));
       $length = intval($this->input->get("length"));

           $productoffers=$this->productOffersmodal->offer_details($status,$offset, $limit, $cityId, $name, $stDate, $enDate);
          
         

           $dataOffers = json_decode($productoffers,true);
            //print_r($dataOffers);die;
         
          $sno =$_POST['iDisplayStart']+1;
          $data = [];
          foreach( $dataOffers['data'] as $campaignData) {
          

           // print_r( $campaignData);die;

               if($campaignData['franchise']=='' || $campaignData['franchise'] == null){
                   $campData = "N/A";
               }else{
                   $campData =$campaignData['franchise'];
               }

                    $data[] = [
                           $sno,
                          
                          // '<a class="" href="'.base_url()."index.php?/productOffers/claimDetails/". $campaignData['offerId'].'/'. $campaignData['name']['en'] .'" style="color: royalblue;"  id="'.$campaignData['offerId'].'">' . $campaignData['name']['en'] .  '</a>',                
                          '<a class="" href="'.base_url()."index.php?/productOffers/claimDetails/". $campaignData['offerId'].'" style="color: royalblue; text-decoration:underline;"  id="'.$campaignData['offerId'].'">' . $campaignData['name']['en'] .  '</a>',                
                           $campaignData['city'],
                           $campData,
                           $campaignData['storeName'],
                           $campaignData['applicableOnStatus'],
                           $campaignData['offerTypeString'],
                           $campaignData['discountValue'],
                           $campaignData['minimumPurchaseQty'],
                           //$campaignData['startDateTimeISO'],
                          // $campaignData['endDateTimeISO'],
                       //    date( "Y-m-d H:i:s", strtotime($campaignData['startDateTimeISO'])),
                       //      date( "Y-m-d H:i:s", strtotime($campaignData['endDateTimeISO'])),
                            date("F  d, Y h:i:s A",$campaignData['startDateTime']),
                            date("F  d, Y h:i:s A",$campaignData['endDateTime']),
                           $campaignData['globalClaimCount'],
                          // $campaignData['status'],
                           '<center>'.
                           '<a href="'. base_url() .'index.php?/productOffers/editCampaigns/'.$campaignData['offerId'].'"> <button class="btn btnedit btn-primary cls111 " id="edit" style="width:35px; border-radius: 25px;""><i class="fa fa-edit" style="font-size:12px;"></i></button></a>
                           </center>',
                           '<center>
                             <input type="checkbox" class="checkbox1" name="checkbox[]" value="' . $campaignData['offerId'].'"/>
                         </center>'
                    ];
                         
                   $sno=$sno+1;

           // }
       }
           
           $output = array(    
               "draw" => $draw,
               "recordsTotal" => $dataOffers['totalCount'],
               // "recordsFiltered" => count($campaignDatas['data']),
               "recordsFiltered" => $dataOffers['totalCount'],
               "data" => $data
           );
       
       echo json_encode($output);
       exit();
    }



    // public function offer_details($status,$stDate ='',$enDate =''){

         
    //     $offset=(int)$_POST['iDisplayStart']/10;
    //     $limit=(int)$_POST['iDisplayLength'];
        
    //     $cityId = $_POST['cityId'];
    //     $name=$_POST['name'];

    //    // var_dump( $cityId);
    //    //  die;
       
    //     if (isset($_POST['cityId'])) {
    //        $cityId = $_POST['cityId'];
    //      }else{
    //        $cityId = "";
    //      }

    //      if (isset($_POST['name'])) {
    //        $name = $_POST['name'];  
    //      }else{
    //        $name = "";
    //      }
    //    // var_dump( $name);
    //    //  die;
      

    //    $draw = intval($this->input->get("draw"));
    //    $start = intval($this->input->get("start"));
    //    $length = intval($this->input->get("length"));

    //        $productoffers=$this->productOffersmodal->offer_details($status,$offset, $limit, $cityId, $name, $stDate, $enDate);
          
         

    //        $dataOffers = json_decode($productoffers,true);
    //         //print_r($dataOffers);die;
         
    //       $sno =$_POST['iDisplayStart']+1;
    //       $data = [];
    //       foreach( $dataOffers['data'] as $campaignData) {
          

    //        // print_r( $campaignData);die;

    //            if($campaignData['franchise']=='' || $campaignData['franchise'] == null){
    //                $campData = "N/A";
    //            }else{
    //                $campData =$campaignData['franchise'];
    //            }

    //                 $data[] = [
    //                        $sno,
                          
    //                       // '<a class="" href="'.base_url()."index.php?/productOffers/claimDetails/". $campaignData['offerId'].'/'. $campaignData['name']['en'] .'" style="color: royalblue;"  id="'.$campaignData['offerId'].'">' . $campaignData['name']['en'] .  '</a>',                
    //                       '<a class="" href="'.base_url()."index.php?/productOffers/claimDetails/". $campaignData['offerId'].'" style="color: royalblue;"  id="'.$campaignData['offerId'].'">' . $campaignData['name']['en'] .  '</a>',                
    //                        $campaignData['city'],
    //                        $campData,
    //                        $campaignData['storeName'],
    //                        $campaignData['applicableOnStatus'],
    //                        $campaignData['offerTypeString'],
    //                        $campaignData['discountValue'],
    //                        $campaignData['minimumPurchaseQty'],
    //                        //$campaignData['startDateTimeISO'],
    //                       // $campaignData['endDateTimeISO'],
    //                    //    date( "Y-m-d H:i:s", strtotime($campaignData['startDateTimeISO'])),
    //                    //      date( "Y-m-d H:i:s", strtotime($campaignData['endDateTimeISO'])),
    //                         date("F  d, Y h:i:s A",$campaignData['startDateTime']),
    //                         date("F  d, Y h:i:s A",$campaignData['endDateTime']),
    //                        $campaignData['globalClaimCount'],
    //                       // $campaignData['status'],
    //                        '<center>'.
    //                        '<a href="'. base_url() .'index.php?/productOffers/editCampaigns/'.$campaignData['offerId'].'"> <button class="btn btnedit btn-primary cls111 " id="edit" style="width:35px; border-radius: 25px;""><i class="fa fa-edit" style="font-size:12px;"></i></button></a>
    //                        </center>',
    //                        '<center>
    //                          <input type="checkbox" class="checkbox1" name="checkbox[]" value="' . $campaignData['offerId'].'"/>
    //                      </center>'
    //                 ];
                         
    //                $sno=$sno+1;

    //        // }
    //    }
           
    //        $output = array(    
    //            "draw" => $draw,
    //            "recordsTotal" => $dataOffers['totalCount'],
    //            // "recordsFiltered" => count($campaignDatas['data']),
    //            "recordsFiltered" => $dataOffers['totalCount'],
    //            "data" => $data
    //        );
       
    //    echo json_encode($output);
    //    exit();
    // }


    //get redemtion details 
    
    public function claimDetails($campaignId,$campaignname=""){
      
      //  $campaignname= utf8_decode(urldecode("$campaignname"));
      

        // $campaignnames=$this->productOffersmodal->getCampaignname($campaignId);
     
             /*changes strt*/
            $this->load->library('Datatables');
            $this->load->library('table');
          
          $tmpl = array('table_open' => '<table id="campaigns-datatable" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="promotableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
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
           $this->table->set_heading($this->lang->line('col_slno'),$this->lang->line('col_bookingId'),$this->lang->line('col_userId'),$this->lang->line('col_offerAmount'),$this->lang->line('col_date'));
           $data['pagename'] = 'Offers/ProductOffersredemtionview';
           $data['campaignId'] = $campaignId;
           $data['campaignname'] = $campaignnames;
        //    $this->load->view("company", $data);
        $this->load->view("template", $data);
         
            /*changes end*/
        }

        //to get all redemtion details
       
       public function getclaimDetails($campaignId){
       
                // $_POST['iColumns'] = 4;
                // $_POST['mDataProp_0'] = "brandName";
                // $_POST['mDataProp_1'] = "brandDescription";
                // $_POST['mDataProp_2'] = "statusMsg";
                // $_POST['mDataProp_3'] = "statusMsg";

                $draw = intval($this->input->get("draw"));
                $start = intval($this->input->get("start"));
                $length = intval($this->input->get("length"));
      
      
               $offerData1 = $this->productOffersmodal->getClaimdDetailsByCampaignId($campaignId);
            //    echo '<pre>';
            //    print_r($offerData1);
               
                $data = [];
                $sno = 1;
                foreach($offerData1['data'] as $offerData) {
                $data[] = [
                                $sno,
                                $offerData['bookingID'],
                               // $offerData['offerId'],
                                $offerData['userID'],
                                $offerData['discount'],
                                date("Y-m-d H:i:s",strtotime($offerData['timeStampISO'])),
                           ];
                    $sno=$sno+1;
                }
      
                $output = array(
                     "draw" => $draw,
                       "recordsTotal" => count($offerData),
                       "recordsFiltered" => count($offerData['data']),
                       "data" => $data
                  );
                
                echo json_encode($output);
                exit();
      
          }




    //status update
    public function updatecouponCodeStatus(){
        $offerIds = $this->input->post("offerId");
        $status   = $this->input->post("status");
        // print_r($offerIds);die;
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

        $data['language'] = $this->productOffersmodal->getlanguageText();
        $data['cities'] = $this->productOffersmodal->getAllCities();
        /*changes required*/
        $data['pagename'] = "Offers/editNewOffer";
        $data['storeId']=$this->session->userdata('badmin')['BizId'];
        $data['campaignId'] = $id;
        $this->load->view("template", $data);
    }
    
}
