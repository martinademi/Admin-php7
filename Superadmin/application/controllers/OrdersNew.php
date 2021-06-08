<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders extends CI_Controller {

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
        $this->load->model("OrdersModel");
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
        // $this->table->set_heading('SL NO.','Order ID', 'City', 'Customer Name ','Customer Number','Store Name','Driver Name','Order Type ','Order Type Category', 'Order Date & Time','Requested Date & Time','Delivery Address','Payment Type','Net Value','Delivery Fee','Accepted Date & Time','Accepted By','Manage','Status','Action','Print Slip');           

        $this->table->set_heading('SL NO.','Order ID','City','Caegory','Status','Type','Delivery Type','Customer Name','Store Name','Driver Name','Order Placed on',
                                    'Order Requested for','Payment method','Cart Value','Delivery Fee');

        $data['pagename'] = "Orders/index";
        $this->load->view("company", $data);
        unset($_SESSION['cityFilter']);
        unset($_SESSION['storeFilter']);


    }
	
	public function datatableOrders($status = '', $stDate = '', $endDate = ''){
		$this->OrdersModel->datatableOrders($status,$stDate,$endDate);
	}
	
	public function getOrdersCount() {
        $this->OrdersModel->getOrdersCount();
    }
	
	public function acceptOrder() {
        $this->OrdersModel->acceptOrder();
    }
	public function getCities() {
        $this->OrdersModel->getCities();
    }
	public function getStores() {
        $this->OrdersModel->getStores();
    }
	
	public function ordersData() { 
        $this->OrdersModel->ordersData(); 
    }

    public function ordersFilter() { 
        $this->OrdersModel->ordersFilter(); 
    }


	
	 public function orderDetails($param,$status,$storeType="") {

		$return['tabStatus'] = $status;
        $return['data'] = $this->OrdersModel->orderDetails($param,$status,$storeType);
        $return['dataLocation'] = $this->OrdersModel->orderDetailsForDriverLocations($param);
        $return['order_id'] = $param;

    

        $return['pagename'] = "trip_details";
    
		$this->load->view("company", $return);

    }


     //export  data
     public function exportAccData($status='',$stdate = '', $enddate = '') {
        
        $data = $this->OrdersModel->exportAccData($status,$stdate, $enddate);
        
            // print_r(json_decode ($data));die; 
        $fileName = "Order" . date('Y-m-d') . ".xls";
        
        $this->load->library('excel');
               
        $this->excel->setActiveSheetIndex(0);
        $this->excel->stream($fileName, $data);   
    
           
        }

}

