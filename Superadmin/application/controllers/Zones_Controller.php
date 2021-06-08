<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Class Zones_Controller extends CI_Controller {

    public function __construct() {

        parent::__construct();
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        $this->lang->load('zone_lang', $language);
        $this->lang->load('packagingPlan_lang', $language);
         $this->load->model("Zonemodel");
        
     
    }

    public function PricingSetForCity() {
        $this->Zonemodel->PricingSetForCity();
    }

    public function ceateZone() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status']=1;
        $data['zones_data'] = $this->Zonemodel->zones_data();
        $data['cities'] = $this->Zonemodel->cityForZones();
        $data['allcities'] = $this->Zonemodel->cityforZonesNew();


        $data['pagename'] = "Zones/create";

        $this->load->view("company", $data);
    }
    public function editZone($param='',$param1='') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['zones_data'] = $this->Zonemodel->zones_data($param,$param1);
        if (array_key_exists("packagingPlanDetails",$data['zones_data']))
        {
          $data['hasPackage']=1;
        }
         else
        {
            $data['hasPackage']=0;
        }
        $data['cities'] = $this->Zonemodel->cityForZones();
        $data['allcities'] = $this->Zonemodel->cityforZonesNew();


        $data['pagename'] = "Zones/edit";

        $this->load->view("company", $data);
    }

    public function Logout($loginerrormsg = NULL) {

        $this->session->sess_destroy();
        $data['loginerrormsg'] = $loginerrormsg;

        $this->load->view('Login/login', $data);
//        redirect(base_url());
    }
     public function deleteZone() {
        $this->Zonemodel->deleteZone();
    }
     public function datatable_zones($status) {
        $this->Zonemodel->datatable_zones($status);
    }

    
    public function index() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->helper('cookie');
       
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
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
        $checkbox=' <input type="checkbox" id="select_all" />';
        $this->table->set_heading($this->lang->line('SLNO'),
                                  $this->lang->line('City'),$this->lang->line('TITLE'),$this->lang->line('ACTION'),$this->lang->line('SELECT'));
        $data['status']=1;
        $data['cities'] = $this->Zonemodel->cityForZones();
        $data['allcities'] = $this->Zonemodel->cityforZonesNew();
            
            $data['pagename'] = "Zones/index";
           
        $this->load->view("company", $data);
    }
    
    public function getCityZone(){
        
        $this->Zonemodel->getCityZones();
    }
    public function addAreaZone(){
        
        $data = $this->Zonemodel->addAreaZone();
    }
    public function editAreaZone(){
        
        $data = $this->Zonemodel->editAreaZone();
    }

    public function setPricing($city_id,$zone_id) {
        $data['data'] = $this->Zonemodel->getZonedata($city_id,$zone_id);
        $data['zoneName'] = $this->Zonemodel->getZoneName($zone_id);    
        $data['pricingData'] = $this->Zonemodel->getPricingData($zone_id);
        $data['pagename'] = 'Zones/setPrice';
       $this->load->view("company", $data);
    }

    public function setShiftTimings($city_id,$zone_id) {
        $data['data'] = $this->Zonemodel->getZonedata($city_id,$zone_id);
        $data['zoneName'] = $this->Zonemodel->getZoneName($zone_id);    
        $data['pricingData'] = $this->Zonemodel->getPricingData($zone_id);
        $data['pagename'] = 'Zones/setPrice';
       $this->load->view("company", $data);
    }

  
}
