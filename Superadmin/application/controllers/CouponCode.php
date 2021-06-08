<?php

error_reporting(E_ALL);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// error_reporting(false);



class CouponCode extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->model('logsmodel');
        $this->load->model('promoCodeModel');
        $this->load->model("Citymodal");


        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language); 
        $this->lang->load('topnav_lang', $language);

       


        // $this->load->model('offersmodal');
        // $this->load->model('campaignsmodal');

        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index($status) {

        $getCounts = $this->promoCodeModel->getAllCodeCounts();
        $getAllCounts = $this->promoCodeModel->getAllCouponCodeCount();
        $data['codeCounts'] = $getAllCounts;
        $data['countData'] = $getCounts;


        $this->load->library('Datatables');
        $this->load->library('table');
        $data['status'] = 1;
        $tmpl = array('table_open' => '<table id="promo_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="promotableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
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
        $this->table->set_heading('SL No','Title' ,'Code' ,'Start Date' ,  'End Date' ,  'Cities' ,'Claims','Action', 'Select');
        $data['pagename'] = 'camp/marketing/couponCodeList';
        $this->load->view("company", $data);
    }

    public function getAllcouponCodes($status){
        error_reporting(0);
        if (isset($_POST['search']['value'])) {
          $sSearch = $_POST['search']['value'];  
        }else{
          $sSearch = "";
        }
        if (isset($_POST['cityId'])) {
          $cityId = $_POST['cityId'];
        }else{
          $cityId = "";
        }

      
         $offset=$_POST['start']/10;
         $limit=$_POST['length'];
      
        if ($this->session->userdata('table') != 'company_info') {
        
            $this->Logout();
        
        }
      
        $offersData = $this->promoCodeModel->getAllCouponCodes($status, $offset, $limit, $sSearch, $cityId);
        $getAllCounts = $this->promoCodeModel->getAllCouponCodeCount();
        // print_r($offersData);
        $data = [];
        $draw = intval($this->input->get("draw"));
        
        $start = intval($this->input->get("start"));
        
        $length = intval($this->input->get("length"));
        
        //$slNo = 1;
        $slNo=$_POST['start']+1;
        foreach ($offersData['data'] as $campaignData) {
               
           
            $cityIds = [];
            foreach ($campaignData['cities'] as $cityData) {
              // print_r($cityData['cityId']);
              array_push($cityIds, $cityData['cityId']);
          
            }
            $cityIdStrings = implode(',', $cityIds);
               
          $cityNames ='' ;

          foreach ($campaignData['cities'] as $cityName) {
            $cityNames = $cityNames.', ' . $cityName['cityName'];
          }
        
          
            $zoneName = "N/A";
         
           if ($status == "1") {
               $status = 'Pending';
          
               
           }
           if ($status == '2') {
               $status = 'Active';
          $countcode=$getAllCounts['activeCount'];
             }
           if ($status == "3") {
               $status = 'Expired';
          
           }
           if ($status == "4") {
               $status = 'Inactive';
              // $countcode=$getAllCounts['inActiveCount'];
            
           }
           if ($status == "5") {
               $status = 'Deleted';
              // $countcode=$getAllCounts['deleteCount'];
           }

           if ( !$campaignData['code']) {
               $couponCode = "N/A";
           }else{
                $couponCode = $campaignData['code'];
           }

           $sDate=strtotime($campaignData['startDate']);
           $eDate=strtotime($campaignData['endDate']);

            $stDate= date('d-M-Y h:i:s', ($sDate) - ($this->session->userdata('timeOffset') * 60));
            $sndDate= date('d-M-Y h:i:s', ($eDate) - ($this->session->userdata('timeOffset') * 60));

               $data[] = [
                $slNo,
                $campaignData['title'],
                $couponCode,
                $stDate,
                $sndDate,               
                //$cityNames,
                '<span class="cityDetails" style="color: blue; cursor: pointer;" city_ids='.$cityIdStrings.' val='.$cityIdStrings.'>'.'View'.'</span>',
                
              //  $zoneName,
                // '<span class="qualifiedTrips" style="color: blue; cursor: pointer;" onClick="getQualifiedTripDetails(\''.$campaignData['id'].'\')" id='.$campaignData['id'].'>'.$getQualifiedTripCount['count'].'</span>',
                // '<span class="unlockedCount" style="color: blue; cursor: pointer;" id='.$campaignData['id'].'>'.$getUnlockedCount['count'].'</span>',
                //'<span class="unlockedCount" style="color: blue; cursor: pointer;" id='.$campaignData['id'].'>' . '0'.'</span>',
                '<a class="" href="'.base_url()."index.php?/couponCode/claimDetails/".$campaignData['id'].'" style="color: royalblue;" onClick="getClaimDetails(\''.$campaignData['id'].'\')" id="'.$campaignData['id'].'">' .$campaignData['totalClaims'] . ' / '. $campaignData['globalUsageLimit'] . '</a>',                
                '<center>'.
                '<a href="'. base_url() .'index.php?/couponCode/editPromoCode/'.$campaignData['id'].'"> <button class="btn btnedit btn-primary cls111 " id="edit" style="width:35px; border-radius: 25px;""><i class="fa fa-edit" style="font-size:12px;"></i></button></a>
                </center>',
                '<center>
                <input type="checkbox" class="checkbox1" name="checkbox[]" value="' . $campaignData['id'].'"/>
                </center>'
            ];


           $slNo++;
       }
       /*echo "<pre>";
       print_r($offersData['totalCount']);*/

        $output = array(
        "draw" => $draw,
        //"recordsTotal" =>  $countcode,
        "recordsTotal" => $offersData['totalCount'],
       // "recordsFiltered" => count($offersData['data']),
        "recordsFiltered" =>$offersData['totalCount'],
        "data" => $data
        );
        
        echo json_encode($output);

    }

    public function claimDetails($campaignId) {
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        /* changes strt */
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
        $this->table->set_heading('SL No', 'CLAIM ID', 'USER NAME', 'DATE TIME', 'BILLED AMOUNT', 'DISCOUNT VALUE', 'STATUS');
        $data['pagename'] = 'camp/marketing/promoclaimlist';
        $data['campaignId'] = $campaignId;
        $this->load->view("company", $data);

        /* changes end */
    }

    public function updatecouponCodeStatus() {
        $offerIds = $this->input->post("couponId");
        $status = $this->input->post("status");
        $response = $this->promoCodeModel->updateCodeStatus($status, $offerIds);
        echo json_encode(array('msg' => $response));
    }

    public function getStoreData() {
        $cityIds = $this->input->post("val");
        $this->promoCodeModel->getStoreData($cityIds);
    }

    public function addNewCode() {
        // var_dump("expression");
        // exit;
        // Load the page
        $data['pagename'] = "camp/marketing/addNewPromoCode";
        $this->load->view("company", $data);
    }

    //edit promocode
    public function editPromoCode($campaignId) {
        //error_reporting(0);
        $data['pagename'] = "camp/marketing/editPromoCode";
        $data['campaignId'] = $campaignId;
        $this->load->view("company", $data);
    }

    public function logs() {
        // var_dump("expression");
        // exit;

        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 0px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;">',
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
        $this->table->set_heading('SL NO', 'COUPON CODE', 'CART ID', 'CLAIM STATUS', 'DISCOUNT TYPE', 'CART VALUE', 'DELIVERY FEE', 'DISCOUNT VALUE', 'FINAL VALUE', 'LOCKED TIME', 'UNLOCKED TIME', 'CLAIMED TIME');
        // Load the page
        $data['pagename'] = "camp/marketing/logs";
        $this->load->view("company", $data);
    }

    public function getCalimsData() {
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $logsData = $this->logsmodel->claimsLog();

        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $slNo = 1;
        // echo '<pre>';
        // print_r($offersData);
        $data = array();
        foreach ($logsData as $logData) {
            //fetch username
            $userdetails = $this->promoCodeModel->getUserDetails($logData['userId']);

            if (!empty($userdetails)) {
                $customerName = $userdetails[0]['firstName'];
            } else {
                $customerName = '';
            }

            // echo '<pre>';
            //   var_dump($claimTimeStamp); 
            //   exit;
            if (!$logData['couponCode']) {
                $couponCode = "N/A";
            } else {
                $couponCode = $logData['couponCode'];
            }

            /*
              Locked timestamp
             */

            if ($logData['lockedTimeStamp'] == "N/A") {
                $lockedTimeStamp = "N/A";
            } else {
                $lockedTimeStamp = date("j-M-Y g:i A", strtotime($logData['lockedTimeStamp']));
            }

            /*
              Unlocked timestamp
             */
            if ($logData['unlockTimeStamp'] == "N/A") {
                $unlockedTimeStamp = "N/A";
            } else {
                $unlockedTimeStamp = date("j-M-Y g:i A", strtotime($logData['unlockTimeStamp']));
            }
            /*
              Claimed timestamp
             */
            if ($logData['claimTimeStamp'] == "N/A") {
                $claimTimeStamp = "N/A";
            } else {
                $claimTimeStamp = date("j-M-Y g:i A", strtotime($logData['claimTimeStamp']));
            }
            $currencySymbol = $logData['currencySymbol'] ? $logData['currencySymbol'] : '$';

            $data[] = [
                $slNo,
                $couponCode,
                $logData['cartId'],
                //'<span class="inputTripLogs" style="color: blue; cursor: pointer;" userId='.$logData['userId'].'>'.$logData['userName'].'</span>',
                //  '<span class="inputTripLogs" style="color: blue; cursor: pointer;" userId='.$logData['userId'].'/>',
                $logData['claimStatus'],
                $customerName,
                $currencySymbol . ' ' . $logData['cartValue'],
                $logData['discountValue'] . ' ' . ucwords($logData['discountType']),
                $currencySymbol . ' ' . $logData['finalValue'],
                $lockedTimeStamp,
                $unlockedTimeStamp,
                $claimTimeStamp
            ];

            $slNo++;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($logsData),
            "recordsFiltered" => count($logsData),
            "data" => $data
        );
        echo json_encode($output);
    }

    public function datatable_search() {


        $searchval = $_POST['searchval'];

        // echo $searchval;
        $this->promoCodeModel->datatable_search($searchval);
    }

    /* chnages */

    public function getClaimDetailsByClaimId($campaignId){
          
           
        if ($this->session->userdata('table') != 'company_info') {
              $this->Logout();
          }
  
            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));
  
  
           $campaignDatas = $this->promoCodeModel->getClaimdDetailsByCampaignId($campaignId);
        //    echo '<pre>';print_r($campaignDatas);die;
          
           
            $data = [];
            $sno = 1;
            foreach($campaignDatas['data'] as $campaignData) {
             $userdetails=$this->promoCodeModel->getUserDetails( $campaignData['userId']); 
              
              if ($campaignData['lockedTimeStamp'] == "N/A") {
                  $unlockedTimeStamp = "N/A"; 
               }else{
                $unlockedTimeStamp = date( "Y-m-d H:i:s", strtotime($campaignData['lockedTimeStamp']));
               }
  
                 $data[] = [
                        $sno,
                        $campaignData['_id'],
                        $userdetails[0]['name'],
                        $campaignData['cartId'],
                       // date( "Y-m-d H:i:s", strtotime($campaignData['unlockedTimeStamp'])),
                       $unlockedTimeStamp,
                        $campaignData['cartValue'],
                        $campaignData['deliveryFee'],
                        $campaignData['discountValue'],
                        $campaignData['status']
  
                            
                          ];
                $sno=$sno+1;
            }
  
            $output = array(
                 "draw" => $draw,
                   "recordsTotal" => count($campaignDatas),
                   "recordsFiltered" => count($campaignDatas['data']),
                   "data" => $data
              );
            
            echo json_encode($output);
            exit();
  
      }

    public function getCatList() {

        $this->promoCodeModel->getCatList();
    }

}
