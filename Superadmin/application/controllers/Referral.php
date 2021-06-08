<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Referral extends CI_Controller {

    public function __construct() {

        parent::__construct();
        error_reporting(0);
        $this->load->library('mongo_db');
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->helper('security');
        $this->load->model("Referralmodal");
        $this->load->library('session');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
    }

    public function index() {
        $data['pagename'] = "Coupons/coupons";
        $this->load->view("company", $data);
    }

    public function refferal($param = '') {
       
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->table->clear();
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;">',
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
        $this->table->set_heading('REFFERRAL NAME','CITY','NO OF CLAIMS','SELECT');
        $data['pagename'] = "Refferral/refferal";
     
        if ($param == ''){
            $data['canpaningData'] = $this->Referralmodal->referralData();
        } else
            $data['canpaningData'] = $this->Referralmodal->getCampanians($param);
        $this->load->view("company", $data);
    }

    public function refferalHistory($param) {
        $data['referralId'] = $param;
        $data['pagename'] = "Refferral/refferalhistory";
        
        $this->load->library('Datatables');
        $this->load->library('table');
         $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;">',
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
        $this->table->set_heading(
                'Referred By',  
                'New Joiner', 
                'Referred On',
                'Referred Reward Type ',               
                'New Joinee Reward Type'
               );

        $this->load->view("company", $data);
    }
    
    public function datatable_refferalHistory($param = '') {
        $this->Referralmodal->datatable_refferalHistory($param);
    }
    
     public function datatable_Refferral($param = '') {
        $this->Referralmodal->datatable_Refferral($param);
    }
    
     public function datatable_Promotions($param = '') {
        $this->Referralmodal->datatable_Promotions($param);
    }
    
    public function refererHistory($param) {
        $this->load->library('mongo_db');

        $data['refData'] = $this->Referralmodal->getHistoryData($param);
        $data['refId'] = $param;
        $data['pagename'] = "Refferral/refererHistory";
        
        $this->load->library('Datatables');
        $this->load->library('table');
         $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;">',
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
        $this->table->set_heading('Customer Id', 
                'Customer Name',  
                'Phone Number', 
                'Customer Registration Date',
                'Gender', 
                'Email');
        
        $this->load->view("company", $data);
    }

    public function datatable_refererHistory($param) {
        $this->Referralmodal->datatable_refererHistory($param);
    }    
    public function createReferal() {
        $data['pagename'] = "Refferral/createrefferal";
         $citydata = $this->Referralmodal->getData();
        $city_html = "<option value='0'>Select City</option>";
        foreach ($citydata as $value) {
            
            $city_html .= "<option value='".$value['_id']['$oid']."' data-name='".$value['city']."'>".$value['city']."</option>";
            }
        
        $data['cities_html'] = $city_html;        
        $this->load->view("company", $data);
    }

    public function AddRefferal() {
        $this->load->library('mongo_db');
        $postdata = $this->input->post();
        $citydata = $this->Referralmodal->cityForZones($this->input->post('cityId'));
        $postdata['location']['latitude'] = (double) $citydata['lat'];
        $postdata['location']['longitude'] = (double) $citydata['lng'];
        if($postdata['couponType'] == "PROMOTION"){
            $postdata['status'] = 1;
        }else{
        $postdata['status'] = 2;
        }
        $cityID = $postdata['cityId'];
        $postdata['cityId'] = new MongoDB\BSON\ObjectID($cityID) ;
 $postdata['usedCount'] = (int)$postdata['usedCount'];
        if ($this->mongo_db->insert("Campanians", $postdata))
            echo json_encode(array('msg' => 0));
        else
            echo json_encode(array('msg' => 1));
        return;
    }

    
    public function validateCoupon(){
        $this->load->library('mongo_db');
        $coupon = $this->input->post('coupon');
        $cData = $this->mongo_db->get_where("Campanians", array('coupon_type' => "PROMOTION", 'coupon_code' => $coupon));
        $cdt = array();
        foreach ($cData as $val) {
            $cdt[] = $val;
        }
        echo json_encode(array("msg" => count($cdt)));
    }

    public function viewrefferal($param = '') {
        $data['pagename'] = "Refferral/viewrefferal";
        $data['canpaningData'] = $this->Referralmodal->getCampanians('REFERREL', $param);
        $this->load->view("company", $data);
    }

    public function editrefferal($param = '') {
        $data['pagename'] = "Refferral/editrefferal";
        $data['canpaningData'] = $this->Referralmodal->getCampanians('REFERREL', $param);
         $cityData = $this->mongo_db->get('cities');
        

        foreach ($cityData as $value) {
            $city_html .= "<option value='".$value['_id']['$oid']."' data-name='".$value['city']."'>".$value['city']."</option>";
        }
        
        $data['cities_html'] = $city_html;
        $this->load->view("company", $data);
    }

    public function UpdateRefferal() {
        $this->load->library('mongo_db');
        $postdata = $this->input->post();
        $citydata = $this->Referralmodal->cityForZones($this->input->post('city_id'));
        $postdata['location']['latitude'] = (double) $citydata->City_Lat;
        $postdata['location']['longitude'] = (double) $citydata->City_Long;

         $cityID = $postdata['cityId'];
        $postdata['cityId'] = new MongoDB\BSON\ObjectID($cityID) ;
        $id = $postdata['Id'];
       
        unset($postdata['Id']);
      
        if ($this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($id)))->set($postdata)->update("Campanians"))
            echo json_encode(array('msg' => 0));
        else
            echo json_encode(array('msg' => 1));
        return;
    }


   

     public function activeReferral() {
                   $this->Referralmodal->activeReferral();
               
    }
    public function activeReferraltype() {
        $this->load->library('mongo_db');
        $mongoid = explode("_", $this->input->post('mongoid'));
        
        $cursorNew = $this->mongo_db-> where(array( "couponType" => "REFERRAL", "cityId" => $mongoid[1]))->set(array('status' => 2))->update('Campanians');
        $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mongoid[0])))->set( array('status' => 1))->update('Campanians');
        $msg = 1;
        if ($cursor && $cursorNew) {
            $msg = 0;
        }
        echo json_encode(array('msg' => $msg));
    }
     public function inactiveReferral() {
         $this->Referralmodal->inactiveReferral();
    }
    
    public function exportData($stdate = '', $enddate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        
       $data = $this->Utilmodal->exportData($stdate, $enddate);
  
        // file name for download
        $fileName = "Promodetails" . date('Ymd') . ".xls";

        // headers for download
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Type: application/vnd.ms-excel");

        $flag = false;
        foreach($data as $row) {
            if(!$flag) {
                // display column names as first row
                echo implode("\t", array_keys($row)) . "\n";
                $flag = true;
            }
            // filter data
            array_walk($row, 'filterData');
            echo implode("\t", array_values($row)) . "\n";

        }
    }

    // zone end here
}
