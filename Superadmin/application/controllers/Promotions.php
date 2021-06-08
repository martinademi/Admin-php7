<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Promotions extends CI_Controller {

    public function __construct() {

        parent::__construct();
        error_reporting(0);
        $this->load->library('mongo_db');
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->helper('security');
        $this->load->model("Promotionmodal");
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

   

    public function promotion($param = '') {
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
        $this->table->set_heading('SLNO','PROMO NAME','PROMO TYPE','PROMO APPLIED','( AMOUNT / % )','CITY','START DATE','END DATE','NO OF CLAIMS','SELECT');
       
        $data['actionFor'] = $param;
        $data['promotions'] = $this->Promotionmodal->getCampanians('PROMOTION');
     
         $data['pagename'] = "Promotion/Promotions";
        $this->load->view("company", $data);
    }

    public function promoused($mongoId) {
        $data['pagename'] = "Promotion/promotionshistory";
        $data['promotions'] = $this->Promotionmodal->getPromoData($mongoId);
        $data['promoId'] = $mongoId;
        
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
                'Customer Name', 
                'Used On', 
                'Booking ID', 
                'Total Invoice',
                'Discount', 
                'Net Payable');

        $this->load->view("company", $data);
    }
    
    public function datatable_promoused($param) {
        $this->Promotionmodal->datatable_promoused($param);
    }
    
    
     public function inactivePromotion() {
        $this->Promotionmodal->inactivePromotion();
    }
    
    
     public function activePromotion() {
        $this->Promotionmodal->activePromotion();
    }
    public function datatable_Promotions($param = '') {
        $this->Promotionmodal->datatable_Promotions($param);
    } 

    public function Createpromotion($param = '') {
        if ($param == 1)
            $data['pagename'] = "Promotion/createpromotions";
        else if ($param == 2) {
            $data['pagename'] = "Promotion/createpromotionsForwallet";
        }
        
            $cityData = $this->mongo_db->get('cities');
        
        $city_html = "<option value='0'>Select City</option>";
        foreach ($cityData as $value) {
            $city_html .= "<option value='".$value['_id']['$oid']."' data-name='".$value['city']."'>".$value['city']."</option>";
        }
        
        $data['cities_html'] = $city_html;
        
        $data['actionFor'] = $param;
        
        $this->load->view("company", $data);
    }

    public function editrpromotion($param = '', $param2 = '') {
        if ($param == 1)
            $data['pagename'] = "Promotion/editpromotions";
        else if ($param == 2) {
            $data['pagename'] = "Promotion/editpromotionsForwallet";
        }
        $data['canpaningData'] = $this->Promotionmodal->getCampanians('PROMOTION', $param2);
        $this->load->view("company", $data);
    }
    public function viewPromotion($param = '', $param2 = '') {
        if ($param == 1)
            $data['pagename'] = "/viewPromotions";
        else if ($param == 2) {
            $data['pagename'] = "Promotion/editpromotionsForwallet";
        }
        $data['canpaningData'] = $this->Promotionmodal->getCampanians('PROMOTION', $param2);
        $this->load->view("company", $data);
    }
    
    public function delpromotion($param = '') {
//        $param = $this->input->post('val');
         $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->delete('Campanians'); 
        echo json_encode(array('msg'=>1));
    }

}
