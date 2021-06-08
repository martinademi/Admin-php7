<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Schduled extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php?/welcome
     * 	- or -
     * 		http://example.com/index.php?/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php?/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model("Schduledmodal");
       // $this->load->model("superModel/Logout");
        $this->load->library('CallAPI');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('headerNav_lang',$language);
        $this->lang->load('workinghour_lang',$language);
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index() {
        $this->load->library('Datatables');
        $this->load->library('table');
        //$data['citiesData'] = $this->Schduledmodal->getCityList();
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px; font-size:11px;">',
            'heading_row_start' => '<tr role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="">',
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

        $this->table->set_heading($this->lang->line('col_slno'),$this->lang->line('col_stDate'),$this->lang->line('col_enDate'),$this->lang->line('col_stTime'),$this->lang->line('col_enTime')
        ,$this->lang->line('col_workingDays'),$this->lang->line('col_notes'),$this->lang->line('col_action'));

        $data['pagename'] = "Schduled/Schduled";
        $this->load->view("SuperAdmin_Dashbord", $data);
    }

    public function datatable_getProviderDetails($status = '',$timeOffset= '') {

        $this->Schduledmodal->datatable_getProviderDetails($status,$timeOffset);
    }

    public function getProviderDetailsCount($cityid = '', $catid = '', $userType = '', $sdate = '') {

        $this->Schduledmodal->getProviderDetailsCount($cityid, $catid, $userType, $sdate);
    }

    public function addSchduled() {

        $this->Schduledmodal->addSchduled();

    }
    
    public function deleteSchduled() {

        $this->Schduledmodal->deleteSchduled();

    }
    public function deleteParticularSlot() {

        $this->Schduledmodal->deleteParticularSlot();

    }
    public function addSlotSchduled(){
        $this->Schduledmodal->addSlotSchduled();
    }
    public function getSlotSchduled(){
        $this->Schduledmodal->getSlotSchduled();
    }

    // public function loadCategoryByCity() {
    //     $this->Schduledmodal->loadCategoryByCity();
    // }

}
