<?php

error_reporting(E_ALL);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// error_reporting(false);

class Campaigns extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->model('Campaignsmodel');
        $this->load->model("Citymodal");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language); 
        $this->lang->load('topnav_lang', $language);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index($status) {
        /*  if ($this->session->userdata('table') != 'company_info') {
          $this->Logout();
          }
          //
          $data['pagename'] = 'marketing/campaignsList';
          $data['status'] = $status;
          $this->load->view("company", $data); */
        /* changes made */
        $this->load->library('Datatables');
        $this->load->library('table');
        // $data['status'] = 1;

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
        $this->table->set_heading('SL No', 'TITLE', 'START DATE', 'END DATE', 'CITY',  'QUALIFYING TRIPS', 'UNLOCKED COUNT', 'CLAIMS', 'ACTION', 'SELECT');
        $data['pagename'] = 'camp/marketing/campaignsList';
        $data['status'] = $status;
        $this->load->view("company", $data);
        /* end of changes */
    }

    function Logout() {

        $this->session->sess_destroy();
        redirect(base_url() . "index.php?/Home");
    }

    public function addNewCampaign($pageType, $campaignIdForEdit) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        // Load the page
        // Page flag for edit campaign
        $data['pagename'] = "camp/marketing/addNewCampaign";
        $data['pageFlag'] = 1;
        $data['pageType'] = $pageType;
        if ($pageType == 2) {
            $data['campaignId'] = $campaignIdForEdit;
        } else {
            $data['campaignId'] = '0';
        }
        $this->load->view("company", $data);
    }

    public function editNewCampaign() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        // Load the page
        // Page flag for edit campaign
        $data['pagename'] = "camp/marketing/editNewCampaign";
        $data['pageFlag'] = 1;
        $data['pageType'] = $pageType;
        if ($pageType == 2) {
            $data['campaignId'] = $campaignIdForEdit;
        } else {
            $data['campaignId'] = '0';
        }
        $this->load->view("company", $data);
    }

    public function getAllCampaigns($status,$datetime='') {
        // error_reporting(0);
        if (isset($_POST['search']['value'])) {
            $sSearch = $_POST['search']['value'];
        } else {
            $sSearch = "";
        }
        if (isset($_POST['cityId'])) {
            $cityId = $_POST['cityId'];
        } else {
            $cityId = "";
        }



        $offset = $_POST['start'] / 10;
        $limit = $_POST['length'];

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $campaignDatas = $this->Campaignsmodel->getAllCampaigns($status, $offset, $limit, $sSearch, $cityId,$datetime);

        
        $data = [];
        $sno = $_POST['start'] + 1;

        foreach ($campaignDatas['data'] as $campaignData) {
            
         
            $cityIds = [];
            foreach ($campaignData['cities'] as $cityData) {
              // print_r($cityData['cityId']);
              array_push($cityIds, $cityData['cityId']);
          
            }
            $cityIdStrings = implode(',', $cityIds);
            $catids = [];

           
            
            $catIdString = implode(',', $catids);
            $cityIdStrings = implode(',', $cityIds);

            if ($campaignData['code']) {
                $couponCode = $campaignData['code'];
            } else {
                $couponCode = 'N/A';
            }
            /*
              Check for unlocked count = 0 or not
             */
            if ($campaignData['unlockedCodes'] == 0) {
                $unlockedData = '<span>' . $campaignData['unlockedCodes'] . '</span>';
            } else {
                $unlockedData = '<a href="' . base_url() . "index.php?/Campaigns/unlockedDetails/" . $campaignData['id'] . '" class="unlockedCount" style="color: blue; cursor: pointer;" id=' . $campaignData['id'] . '>' . $campaignData['unlockedCodes'] . '</span>';
            }

            /*
              Check for claim count = 0 or not changes
             */


            if ($campaignData['totalClaims'] == 0) {
                $claimsData = '<span>' . $campaignData['totalClaims'] . '</span>';
            } else {
                $claimsData = '<a href="' . base_url() . "index.php?/campaigns/claimDetails/" . $campaignData['id'] . '" class="unlockedCount" style="color: blue; cursor: pointer;" id=' . $campaignData['id'] . '>' . $campaignData['totalClaims'] . ' / ' . $campaignData['globalUsageLimit'] . '</span>';
            }



            if ($campaignData['qualifiedTrips'] == 0) {
                $qualifiedData = '<span>' . $campaignData['qualifiedTrips'] . '</span>';
            } else {
                $qualifiedData = '<a href="' . base_url() . "index.php?/campaigns/qualifyingTripData/" . $campaignData['id'] . '" class="qualifiedTrips" style="color: blue; cursor: pointer;" id=' . $campaignData['id'] . '>' . $campaignData['qualifiedTrips'] . '</a>';
            }


            $data[] = [
                $sno,
                $campaignData['title'],
                date('j-M-Y g:i A', strtotime($campaignData['startDate']) - ($this->session->userdata('timeOffset') * 60)),
                date('j-M-Y g:i A', strtotime($campaignData['endDate']) - ($this->session->userdata('timeOffset') * 60)),
                '<span class="cityDetails" style="color: blue; cursor: pointer;" city_ids='.$cityIdStrings.' val='.$cityIdStrings.'>'.'View'.'</span>',
                $qualifiedData,
                $unlockedData,
                $claimsData,
                '<center>' .
                '<a href="' . base_url() . 'index.php?/campaigns/editCampaigns/' . $campaignData['id'] . '"> <button class="btn btnedit btn-primary cls111 " id="edit" style="width:35px; border-radius: 25px;""><i class="fa fa-edit" style="font-size:12px;"></i></button></a>
                          </center>',
                '<center>
                              <input type="checkbox" class="checkbox1" name="checkbox[]" value="' . $campaignData['id'] . '"/>
                          </center>'
            ];
            $sno = $sno + 1;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $campaignDatas['totalCount'],
            // "recordsFiltered" => count($campaignDatas['data']),
            "recordsFiltered" => $campaignDatas['totalCount'],
            "data" => $data
        );

        echo json_encode($output);
        exit();
    }

    //edit promocode
    public function editCampaigns($campaignId) {
        error_reporting(0);
        $data['pagename'] = "camp/marketing/editNewCampaign";
        $data['campaignId'] = $campaignId;
        $this->load->view("company", $data);
    }

    public function updateCampaignStatus() {
        $campaignId = $this->input->post("couponId");
        $status = $this->input->post("status");
        $response = $this->Campaignsmodel->updateCampaignStatus($status, $campaignId);

        echo json_encode(array('msg' => $response));
        return;
    }

    public function claimDetails($campaignId) {
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
        $this->table->set_heading('SL No', 'CLAIM ID', 'USER NAME', 'CART ID ', 'DATE TIME', 'CART VALUE', 'DISCOUNT VALUE');
        $data['pagename'] = 'camp/marketing/claimsList';
        $data['campaignId'] = $campaignId;
        $this->load->view("company", $data);

        /* changes end */
    }

    public function getClaimDetailsByClaimId($campaignId) {

        $offset = $_POST['start'] / 10;
        $limit = $_POST['length'];
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $campaignDatas = $this->Campaignsmodel->getClaimdDetailsByCampaignId($campaignId, $offset, $limit);

        $data = [];
        $sno = $_POST['start'] + 1;
        foreach ($campaignDatas['data'] as $campaignData) {

            $data[] = [
                $sno,
                $campaignData['id'],
                $campaignData['userName'],
                $campaignData['cartId'],
                date('j-M-Y g:i A', strtotime($campaignData['unlockedTimeStamp']) - ($this->session->userdata('timeOffset') * 60)),
                $campaignData['currencySymbol'] . ' ' . $campaignData['cartValue'],
                $campaignData['currencySymbol'] . ' ' . $campaignData['discountValue'],
//                      $campaignData['status']
            ];
            $sno = $sno + 1;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $campaignDatas['totalCount'],
            "recordsFiltered" => count($campaignDatas['data']),
            "data" => $data
        );

        echo json_encode($output);
        exit();
    }

    /* For unlocked code details */

    public function unlockedDetails($campaignId) {
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
        $this->table->set_heading('SL No', 'PROMO ID', 'USER NAME', 'CART ID ', 'TIME', 'UNLOCKED CODE', 'WALLET CREDIT AMOUNT', 'CAMPAIGN REWARD TYPE');
        $data['pagename'] = 'camp/marketing/unlockedList';
        $data['campaignId'] = $campaignId;
        $this->load->view("company", $data);
        /* changes end */
    }

    public function getUnlockedDetailsById($campaignId) {

        $offset = $_POST['start'] / 10;
        $limit = $_POST['length'];

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $campaignDatas = $this->Campaignsmodel->getUnlockedDetailsByCampaignId($campaignId, $offset, $limit);
        // echo '<pre>';
        // print_r($campaignDatas);
        // exit;
        $data = [];
        $sno = 1;
        foreach ($campaignDatas['data'] as $campaignData) {

            /*
              "promoId" : "5a942900062a396277e8c670",
              "promoTitle" : "Check trip count",
              "userName" : "Wilton1 Customer1",
              "cartId" : "5a955fe0d3bc441f52ff2f24",
              "bookingId" : "1519738854550",
              "timeStamp" : "2018-02-27 19:10:54",
              "unlockedCode" : "M4R2M",
              "walletCreditAmount" : 0,
              "campaignRewardType" : "Coupon Delivery",
              "timestamp" : ISODate("2018-02-27T13:44:57.089Z")
             */
            $data[] = [
                $sno,
                $campaignData['promoId'],
                $campaignData['userName'],
                $campaignData['cartId'],
                date('j-M-Y g:i A', strtotime($campaignData['timestamp']) - ($this->session->userdata('timeOffset') * 60)),
//                      date( "Y-m-d H:i:s", strtotime($campaignData['timestamp'])),
                $campaignData['unlockedCode'],
                $campaignData['currencySymbol'] . ' ' . $campaignData['walletCreditAmount'],
                $campaignData['campaignRewardType']
            ];
            $sno = $sno + 1;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $campaignDatas['totalCount'],
            "recordsFiltered" => count($campaignDatas['data']),
            "data" => $data
        );

        echo json_encode($output);
        exit();
    }

    /* For qualifying trips  code details */

    public function qualifyingTripData($campaignId) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        /* change */
        $this->load->library('Datatables');
        $this->load->library('table');
        $data['campaignId'] = $campaignId;

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
        $this->table->set_heading('SL No', 'CAMPAIGN TITLE', 'USER NAME', 'BOOKING TIME', 'BOOKING ID', 'CART VALUE', 'PAYMENT METHOD');
        $data['pagename'] = 'camp/marketing/qualifiedTrips';
        $this->load->view("company", $data);
        /* change end */
    }

    public function getQualifiedTripDatas($campaignId) {

        $offset = $_POST['start'] / 10;
        $limit = $_POST['length'];
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $campaignDatas = $this->Campaignsmodel->getQualifiedTripDetails($campaignId, $offset, $limit);

        $data = [];
        $sno = 1;
        foreach ($campaignDatas['data'] as $campaignData) {

            $data[] = [
                $sno,
                $campaignData['campaignTitle'],
                $campaignData['customerName'],
                date('j-M-Y g:i A', $campaignData['bookingTime'] - ($this->session->userdata('timeOffset') * 60)),
//                      $campaignData['bookingTime'],                      
                $campaignData['bookingId'],
                $campaignData['currencySymbol'] . ' ' . $campaignData['cartValue'],
                $campaignData['paymentMethodString']
            ];

            /*
              <th>S. NO.</th>
              <th>CAMPAIGN TITLE</th>
              <th>USER NAME</th>
              <th>BOOKING TIME</th>
              <th>BOOKING ID</th>
              <th>CART VALUE</th>
              <th>DISCOUNT VALUE</th>
              <th>DELIVERY FEE</th>
             */
            $sno = $sno + 1;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $campaignDatas['totalCount'],
            "recordsFiltered" => count($campaignDatas['data']),
            "data" => $data
        );

        echo json_encode($output);
        exit();
    }

    function editCampaign($campaignId) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        /* Get details of the campaign for editing */
        $campaignDatas = $this->Campaignsmodel->getCampaignDetailsById($campaignId);
        // Load the page
        // Page flag for edit campaign
        $data['pagename'] = "camp/marketing/addNewCampaign";
        $data['pageFlag'] = 0;
        $data['campaignData'] = $campaignDatas['data'][0];
        $this->load->view("company", $data);
    }

}
