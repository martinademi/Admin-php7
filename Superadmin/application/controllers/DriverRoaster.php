<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DriverRoaster extends CI_Controller {

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
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model("DriverRoasterModal");
        $this->load->model("Zonemodel");        
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);


        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index() {
       
        $data['status'] = 0;

        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127PX;">',
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
        $this->table->set_heading('SL NO.','DRIVER NAME','PHONE','E-MAIL','ACTION');

        $data['pagename'] = "DriverRoaster/index";
        $data['cities'] = $this->Zonemodel->cityForZones();
        $data['allcities'] = $this->Zonemodel->cityforZonesNew();
        // $data['shiftTimimgs']=$this->DriverRoasterModal->getShiftTimings();
        

        $this->load->view("company", $data);
        unset($_SESSION['cityFilter']);
        unset($_SESSION['storeFilter']);


    }
	
	public function datatableOrders($status = '', $stDate = '', $endDate = ''){
		$this->DriverRoasterModal->datatableOrders($status,$stDate,$endDate);
	}
	
	public function getOrdersCount() {
        $this->DriverRoasterModal->getOrdersCount();
    }
	
	public function acceptOrder() {
        $this->DriverRoasterModal->acceptOrder();
    }
	public function getCities() {
        $this->DriverRoasterModal->getCities();
    }
	public function getStores() {
        $this->DriverRoasterModal->getStores();
    }
	
	public function ordersData() { 
        $this->DriverRoasterModal->ordersData(); 
    }

    public function ordersFilter() { 
        $this->DriverRoasterModal->ordersFilter(); 
    }

    public function updateShiftTimimgs() { 
        $this->DriverRoasterModal->updateShiftTimimgs(); 
    }

    public function unassignShift() { 
        $this->DriverRoasterModal->unassignShift(); 
    }

    

    


	
	 public function orderDetails($param,$status,$storeType="") {

		$return['tabStatus'] = $status;
        $return['data'] = $this->DriverRoasterModal->orderDetails($param,$status,$storeType);
        $return['dataLocation'] = $this->DriverRoasterModal->orderDetailsForDriverLocations($param);
        $return['order_id'] = $param;

    

        $return['pagename'] = "trip_details";
    
		$this->load->view("company", $return);

    }


     //export  data
     public function exportAccData($status='',$stdate = '', $enddate = '') {
        
        $data = $this->DriverRoasterModal->exportAccData($status,$stdate, $enddate);      
        $fileName = "Order" . date('Y-m-d') . ".xls";
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->stream($fileName, $data);   
    
           
        }

    //zone details
    public function getZone(){

        $this->DriverRoasterModal->getZone();

    }

     //get shift details details
     public function getShiftTimings(){

        $this->DriverRoasterModal->getShiftTimings();

    }

}

