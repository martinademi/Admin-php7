<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DispatchLogs extends CI_Controller {

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
           $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model("DispatchLogsmodel");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
$this->lang->load('header_lang',$language); 
//        $this->load->model("superModel/Logout");

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index() {
          
//       $data['status'] = 1;
        $this->load->library('Datatables');
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
        $data['citiesData'] = $this->DispatchLogsmodel->getCityList();


        // $this->table->set_heading('SL NO','ORDER ID','BOOKING TYPE','ORDER TYPE','DISPATCH TYPE','STORE NAME','CUSTOMER NAME','DRIVER NAME','DISPATCH TIME','BOOKING ACK TIME','RESPONSE TIME','BOOKING EXPIRY TIME','RESPONSE');

        $this->table->set_heading('DISPATCH NO.','ORDER ID','ORDER CAPACITY','DISPATCH TYPE','ORDER TYPE','DELIVERY TYPE','CUSTOMER NAME',
                                    'STORE NAME','DRIVER NAME','DISPATCH TIME','BOOKING ACK TIME','DRIVER RESPONSE TIME','BOOKING EXPIRY TIME','DRIVER RESPONSE');                            
                              
        $data['pagename'] = "dispatchLogs/dispatchLogs";
        $this->load->view("company", $data);
    }

    public function DispatchLogsOperation($stDate = '',$endDate= '') { 
        switch ($param) {
            case 'add':
                $this->DispatchLogsmodel->add();
                break;
            case 'edit':
                $this->DispatchLogsmodel->edit();
                break;
            case 'get':
                $this->DispatchLogsmodel->get();
                break;
            case 'delete':
                $this->DispatchLogsmodel->delete();
                break;
            
            default :
                $this->DispatchLogsmodel->datatable($stDate,$endDate);
                break;
        }
            
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */