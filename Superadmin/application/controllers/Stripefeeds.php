<?php

class Stripefeeds extends CI_Controller {

   
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
     * @see http://codeigniter.com/user_guide/general/urls.html chang
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model("StripeFeeds_model");
        $this->load->model("Superadminmodal");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
     public function index() {
        
      

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');
       // $appConfig = $appConfig = $this->Superadminmodal->getAppConfigOne();

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => ' <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;">',
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

        $this->table->set_heading('BOOKING ID', 'CHARGED DATE', 'CUSTOMER STRIPE ID','CUSTOMER NAME','PHONE','TXN ID','AMOUNT ('.$appConfig['currency'].')','CARD TYPE','CARD NO.','STATUS');


        $data['pagename'] = 'stripeFeeds/stripeFeeds';
        $this->load->view("company", $data);
    }
    
    function Logout() {

        $this->session->sess_destroy();
        redirect(base_url() . "index.php?/superadmin");
    }
    
    
    public function datatable_stripeFeeds($stdate = '', $enddate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
		if(($stdate == 0 || $stdate == "0") && ($enddate == 0 || $enddate == "0")){
			$stdate = "";
			$enddate = "";
		}

        $this->StripeFeeds_model->datatable_stripeFeeds($stdate, $enddate);
    }
}