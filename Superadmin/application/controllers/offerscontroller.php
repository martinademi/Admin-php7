<?php
error_reporting(E_ALL);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// error_reporting(false);

class Offerscontroller extends CI_Controller {

	    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->model('offersmodal');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language); 

        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index(){
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        // Load the page
        $data['pagename'] = "company/addOffers";
        $this->load->view("company", $data);

    }

   public function offerDetails($status, $userType){
    if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
//        $data['driverdetails'] = $this->superadminmodal->DriverDetails($mas_id);
        if ($userType == 1) {
        $data['pagename'] = 'company/offersList';
        }
        else{
          $data['pagename'] = 'company/storeOffersList';
        }
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
        $this->table->set_heading('SL Number', 'Offer Title', 'Offer Code', 'Start Date', 'End Date', 'Status');

        $this->load->view("company", $data);
    }

    public function getAllOffers($status, $userType){
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $offersData = $this->offersmodal->getAllOffers($status, $userType);
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $slNo = 1;
        // echo '<pre>';
        // print_r($offersData);
       foreach ($offersData['data'] as $offerData) {

           if ($offerData['status'] == 1) {
               $status = 'Pending';
           }
           if ($offerData['status'] == 2) {
               $status = 'Active';
           }
           if ($offerData['status'] == 3) {
               $status = 'Expired';
           }
           if ($offerData['status'] == 4) {
               $status = 'Inactive';
           }
           if ($offerData['status'] == 5) {
               $status = 'Deleted';
           }

           if ( !$offerData['couponCode']) {
               $couponCode = "N/A";
           }else{
                $couponCode = $offerData['couponCode'];
           }
           if ($userType == 1) {
               $data[] = [
                $slNo,
                $offerData['title'],
                $couponCode,
                $offerData['schedule']['startDate'],
                $offerData['schedule']['endDate'],
                $status,
                 '<center>
                    <input type="checkbox" class="checkbox1" name="checkbox[]" value="' . $offerData['_id'].'"/>
                </center>'
            ];
           }else{
              $storeID = $offerData['storeId'][0];
              $storeDetails = $this->offersmodal->getStoreDetails($storeID);
              $storeName = $storeDetails[$storeID]['ProviderName'][0];
                $data[] = [
                $slNo,
                $offerData['title'],
                $storeName,
                $couponCode,
                $offerData['schedule']['startDate'],
                $offerData['schedule']['endDate'],
                $status,
                 '<center>
                    <input type="checkbox" class="checkbox1" name="checkbox[]" value="' . $offerData['_id'].'"/>
                </center>'
               ];

           }
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
  public function updateOfferStatus(){
    $offerIds = $this->input->post("couponId");
    $status   = $this->input->post("status");
    $response = $this->offersmodal->updateOfferStatus($status, $offerIds);
    echo json_encode(array('msg' => $response));
  }


}