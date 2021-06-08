<?php
error_reporting(false);

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class City extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->library('session');
        $this->load->model("Citymodal");
        $this->load->model("Zonemodel");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('city_lang', $language);
        $this->lang->load('topnav_lang', $language);
        $this->lang->load('header_lang',$language);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
    public function index() {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" class="table table-hover demo-table-search">',
            'heading_row_start' => '<tr role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
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
        $this->table->set_heading($this->lang->line('col_city'), $this->lang->line('col_state'), $this->lang->line('col_country'), $this->lang->line('col_currency'), $this->lang->line('col_currencySymbol'), $this->lang->line('col_distance_metric'),
        $this->lang->line('col_payment_type'),$this->lang->line('col_action'));
        $data['pagename'] = "city/index";
        $this->load->view("company", $data);
    }
    
    public function datatable_cities() {
        $this->Citymodal->datatable_cities();
    }
     public function checkCityExists() {
        $this->Citymodal->checkCityExists();
    }
    
    public function addnewcity() {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['allCities'] = $this->Citymodal->getCitydata();
        $data['paymentGateways'] = $this->Citymodal->getpaymentGateways();
        $data['taxes'] = $this->Citymodal->getTax();
        
        $data['pagename'] = 'city/createCity';
        $this->load->view("company", $data);
    }
    
     public function checkCityDeleted() {
        $this->Citymodal->checkCityDeleted();
    }
    
    public function city_create() {
        
        if ($this->session->userdata('table') != 'company_info') {
            echo json_encode(array("flag" => 1, "msg" => "Unauthorised User"));
        }
        if(isset($_POST)){
            $data = $this->Citymodal->city_create();
            echo json_encode($data);
        }else{
            echo json_encode(array("flag" => 1, "msg" => "No Data"));
        }
    }
     public function getCityList() {
     $this->Citymodal->getCityList();

    }
     public function getAllCityList() {
     $this->Citymodal->getAllCityList();

    }
    
    public function editCity($city_id) {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['cityId'] = $city_id;
        $data['data'] = $this->Citymodal->getCitydata($city_id);
      // echo '<pre>'; print_r($data['data']);die;
        $data['allcities'] = $this->Zonemodel->cityforZonesNew();
        $data['paymentGateways'] = $this->Citymodal->getpaymentGateways();
        $data['taxes'] = $this->Citymodal->getTax();
        $data['pagename'] = 'city/editCity';
        $this->load->view("company", $data);
    }
    
    public function city_update() {
        if ($this->session->userdata('table') != 'company_info') {
            echo json_encode(array("flag" => 1, "msg" => "Unauthorised User"));
        }
        if(isset($_POST)){
            $this->Citymodal->city_update();
            echo json_encode(array("flag" => 0));
        }else{
            echo json_encode(array("flag" => 1, "msg" => "No Data"));
        }
    }
    
    public function del_city() {
        if ($this->session->userdata('table') != 'company_info') {
            echo json_encode(array("flag" => 1, "msg" => "Unauthorised User"));
        }
        if(isset($_POST)){
            $return = $this->Citymodal->del_city();
            echo json_encode($return);
        }else{
            echo json_encode(array("flag" => 1, "msg" => "No data"));
        }
    }


    public function getAreaForCity($id) {
        $this->Citymodal->getAreaForCity($id);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */