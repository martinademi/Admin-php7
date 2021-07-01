<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// error_reporting(false);

class ReferralController extends CI_Controller {
      public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->library('session');

        $this->load->library('mongo_db');
        
        
         $language = $this->session->userdata('lang');
        $this->lang->load('topnav_lang', $language);

        // $this->load->model('couponsmodal');
        // $this->load->model('offersmodal');
        $this->load->model('Campaignsmodel');
        $this->load->model('Referralmodel');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);

        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
    function Logout() {

        $this->session->sess_destroy();
        redirect(base_url() . "index.php?/Home");
    }
   

   public function index($status){
    
     if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
    

// // Get all status counts

     /*   $getCounts = $this->Referralmodel->getAllReferralCodesCount();
          $data['pagename'] = 'marketing/referralCodeList';
          $data['countData'] = $getCounts;
          $data['status'] = $status;

        $this->load->library('Datatables');
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 10px;">',
            'heading_row_start' => '<tr style= ""role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px; ;">',
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
        $this->table->set_heading('SL No.', 'TITLE', 'START DATE', 'END DATE', 'CITIES', 'ZONES', 'CODES', 'UNLOCKED COUNT', 'CLAIMSss', 'ACTION');
         $this->load->view("company", $data);*/

        /*changes strt*/
        $getCounts = $this->Referralmodel->getAllReferralCodesCount();
        $data['countData'] = $getCounts;
        $data['status'] = $status;

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
       $this->table->set_heading('SL No.', 'TITLE', 'START DATE', 'END DATE', 'CITY', 'DISCOUNT', 'CODES', 'UNLOCKED COUNT', 'CLAIMS', 'ACTION','SELECT');
       $data['pagename'] = 'camp/marketing/referralCodeList';
       $this->load->view("company", $data);
        /*changes end*/
    }

    public function referralCampaignsByStatus($status){
        error_reporting(0);
        $offset=$_POST['start']/10;
        $limit=$_POST['length'];
        $data=[];

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
        
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $offersData = $this->Referralmodel->referralCampaignsByStatus($status, $offset, $limit, $sSearch, $cityId);
        // echo '<pre>';
        // print_r($offersData);
        // exit;
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $slNo = 1;
       foreach ($offersData['data'] as $campaignData) {
          $cityIds = [];       
          
       foreach ($campaignData['cities'] as $cityDetails) {
         array_push($cityIds, $cityDetails['cityId']);
         $cityname = $cityDetails['cityName'];
       }
        $cityIdStrings = implode(',', $cityIds);
       
          
         /*
         flag 1 for referral codes
         flag 2 for user referral codes
          */
         if ($campaignData['codesGenerated'] == 0) {
             $codesGenerated = $campaignData['codesGenerated'];
           }else{
            $codesGenerated = '<a href="'.base_url()."index.php?/ReferralController/referralCodeList/".$campaignData['id'].'/0/10 " class="unlockedCount" style="color: blue; cursor: pointer;" id='.$campaignData['id'].'>'.$campaignData['codesGenerated'].'</span>';
           }
           if ($campaignData['unlockedCount'] == 0) {
             
             $unlockedCount = 0;

           }else{
            
            $unlockedCount = '<a href="'.base_url()."index.php?/ReferralController/getReferralCampaignnQualifiedLog/".$campaignData['id'].' " class="unlockedCount" style="color: blue; cursor: pointer;" id='.$campaignData['id'].'>'.$campaignData['unlockedCount'].'</span>';
           
           }

          
               $data[] = [
                $slNo,
                $campaignData['title'],
                   date('j-M-Y g:i A', strtotime($campaignData['startTime']) - ((int)$_COOKIE['timeOffset'] * 60)),
                   date('j-M-Y g:i A', strtotime($campaignData['endTime']) - ((int)$_COOKIE['timeOffset'] * 60)),
//                date( "d-m-Y H:i:s", strtotime($campaignData['startTime'])),
//                date( "d-m-Y H:i:s", strtotime($campaignData['endTime'])),
                '<span class="cityDetails" style="color: blue; cursor: pointer;" city_ids='.$cityIdStrings.' val='.$cityIdStrings.'>'.$cityname.'</span>',
                '<span class="newUserDetails" style="color: blue; cursor: pointer;" campaignId='.$campaignData['id'].' val='.$campaignData['id'].'>'.'View'.'</span>',
                $codesGenerated,
                $unlockedCount,
                $campaignData['totalClaims'],
                '<center>'.
                '<a href="'. base_url() .'index.php?/ReferralController/editReferalCampaign/'.$campaignData['id'].'"> <button class="btn btnedit btn-primary cls111 " id="edit" style="width:35px; border-radius: 25px;""><i class="fa fa-edit" style="font-size:12px;"></i></button></a>
                </center>',
                '<center>
                    <input type="checkbox" class="checkbox1" name="checkbox[]" value="' . $campaignData['id'].'"/>
                </center>'
            ];


           $slNo++;
       }
        $output = array(
        "draw" => $draw,
        "recordsTotal" => $offersData['totalCount'],
        "recordsFiltered" => $offersData['totalCount'],
        "data" => $data
        );
        echo json_encode($output);

    }
    //update coupo code
  public function updatecouponCodeStatus(){
    $offerIds = $this->input->post("couponId");
    $status   = $this->input->post("status");
    $response = $this->Referralmodel->updateOfferStatus($status, $offerIds);
    echo json_encode(array('msg' => $response));
  }

   public function addNewReferralCampaign(){
      if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        // Load the page
        $data['pagename'] = "camp/marketing/addNewReferralCampaign";
        $this->load->view("company", $data);
    }

    public function editReferalCampaign($campaignId){
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        // Load the page
        $data['pagename'] = "camp/marketing/editReferalCampaign";
        $data['campaignId'] = $campaignId;
        $this->load->view("company", $data);
    }

    public function referralCodeList($campaignId, $flag){

      if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
      
        /*changes*/
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
       $this->table->set_heading('SL No','CUSTOMER NAME' ,'EMAIL' ,'CONTACT NUMBER ' ,  'REGISTERD ON' ,  'REFERRAL CODE' , 'REFERRED BY');
       $data['pagename'] = "camp/marketing/referralList";
       $data['campaignId'] = $campaignId;
       $this->load->view("company", $data);
     
        /*changes end*/
        /*changes end*/

    }

    public function referralCodesByCampaignId($campaignId){

        $offset=$_POST['start']/10;
        $limit=$_POST['length'];
      if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        
        $offersData = $this->Referralmodel->referralCodesByCampaignId($campaignId, $offset, $limit);
        
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $slNo = 1;
       foreach ($offersData['data'] as $campaignData) {
        

         if ($campaignData['totalRefers'] == 0) {
             $codesGenerated = $campaignData['totalRefers'];
           }else{
            $codesGenerated = '<a href="'.base_url()."index.php?/referralController/referralCode/1/".$campaignData['id'].'" class="unlockedCount" style="color: blue; cursor: pointer;" id='.$campaignData['id'].'>'.$campaignData['totalRefers'].'</span>';
           }
           /*
           Find user total referrs during a campaign .
           find the count by campaign id and user id
            */
           
           // $offersData = $this->Referralmodel->campaignQualifiedReferralCodes($campaignData['userId'], $campaignId, $offset, $limit);
            // var_dump('pass1');
            // var_dump($offersData);

           // if ($offersData) {
           //   $totalCodesGenerated = 0;
           // }else{
           //  $totalCodesGenerated = 0;
           // }
               $data[] = [
                $slNo,
                $campaignData['firstName'],
                $campaignData['email'],
                $campaignData['phoneNumber'],
                date('j-M-Y g:i A', strtotime($campaignData['registeredOn']) - ($this->session->userdata('timeOffset') * 60)),
//                date( "d-m-Y H:i:s", strtotime($campaignData['registeredOn'])),
                $campaignData['referralCode'],
                // $totalCodesGenerated,
                $campaignData['referrerName']
                // '<a href="'.base_url()."index.php?/referralController/referralCode/1/".$campaignData['referrerName'].'" class="unlockedCount" style="color: blue; cursor: pointer;" id='.$campaignData['referrerName'].'>'.$campaignData['referrerName'].'</span>'
            ];


           $slNo++;
       }
        $output = array(
        "draw" => $draw,
        "recordsTotal" => count($offersData['data']),
        "recordsFiltered" => count($offersData['data']),
        "data" => $data
        );
        echo json_encode($output);
    }

    /*Get all the referral details by user id and campaign id*/

    public function getAllRefCodeListByCamp($campaignId, $flag){

      if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['pagename'] = "camp/marketing/refCodesByCampAndUserId";
        $data['campaignId'] = $campaignId;
        $this->load->view("company", $data);

    }
    public function getAllCamRefCodesByUser($userId, $campaignId, $offset, $limit){


       if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        
        $offersData = $this->Referralmodel->campaignQualifiedReferralCodes($userId, $campaignId, $offset, $limit);

        
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $slNo = 1;
       foreach ($offersData['data'] as $campaignData) {

               $data[] = [
                $slNo,
                $campaignData['firstname'].'  '.$campaignData['lastName'] ,
                $campaignData['email'],
                $campaignData['phoneNumber'],
                date( "d-m-Y H:i:s", strtotime($campaignData['registeredOn'])),
                $campaignData['referralCode'],
                // '<a href="'.base_url()."index.php?/referralController/referralCode/1/".$campaignData['referrerName'].'" class="unlockedCount" style="color: blue; cursor: pointer;" id='.$campaignData['referrerName'].'>'.$campaignData['referrerName'].'</span>'
            ];


           $slNo++;
       }
        $output = array(
        "draw" => $draw,
        "recordsTotal" => count($offersData['data']),
        "recordsFiltered" => count($offersData['data']),
        "data" => $data
        );
        echo json_encode($output);





    }

    public function getReferralCampaignnQualifiedLog($campaignId){
      
      if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
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
       $this->table->set_heading('SL No','USER NAME' ,'REFERRAL CODE' ,'REWARD TYPE ' ,  'COUPON CODE' ,  'DELIVERED TO' , 'UNLOCKED TIME');
       $data['pagename'] = "camp/marketing/referalQulTripLogs";
       $data['campaignId'] = $campaignId;
       $this->load->view("company", $data);
     
        /*changes end*/
    }

    public function referralQualifiedTripLog($campaignId){

        $offset=$_POST['start']/10;
        $limit=$_POST['length'];
        if ($this->session->userdata('table') != 'company_info') {
            
            $this->Logout();

        }
        
        $offersData = $this->Referralmodel->referralCampQulTripLogs($campaignId, $offset, $limit);


        
        $draw = intval($this->input->get("draw"));
        
        $start = intval($this->input->get("start"));
        
        $length = intval($this->input->get("length"));
        
        $slNo = 1;
       
       foreach ($offersData['data'] as $campaignData) {
       



               $data[] = [
                $slNo,
                $campaignData['userName'],
                $campaignData['referralCode'],
                $campaignData['rewardType'],
                $campaignData['couponCode'],
                $campaignData['deliveredTo'],
                 date('j-M-Y g:i A', strtotime($campaignData['timeStamp']) - ($this->session->userdata('timeOffset') * 60)),  
//                date( "d-m-Y H:i:s", strtotime($campaignData['timeStamp']))
            ];


           $slNo++;
       }
        $output = array(
          "draw" => $draw,
          "recordsTotal" => count($offersData['data']),
          "recordsFiltered" => count($offersData['data']),
          "data" => $data
        );
        
        echo json_encode($output);
    }




}