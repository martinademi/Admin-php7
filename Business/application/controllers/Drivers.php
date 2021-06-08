<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Drivers extends CI_Controller {

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
        $this->load->model("DriversModel");
        $this->load->library('CallAPI');

        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('headerNav_lang',$language);
        $this->lang->load('storeDriver_lang',$language);

//        $this->load->library('Excel');

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index($loginerrormsg = NULL) {


        $data['loginerrormsg'] = $loginerrormsg;

        if ($this->session->userdata('table') == 'company_info') {
            redirect(base_url() . "index.php?/Drivers/Dashboard");
        } else
            $this->load->view('login', $data);
    }
           public function getOperatorList() {
        $this->DriversModel->getOperatorList();
    }
    public function getCustomerDetails() {
        $this->DriversModel->getCustomerDetails();
    }

   
    public function getZones() {

        $this->DriversModel->getZonesWithCities();
    }



    public function upload_images_on_amazon() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->upload_images_on_amazon();
    }

   
    public function setcity_session() {
        $store = $this->input->post('store');
        $template = $this->input->post('company');

        $meta = array('city_id' => $this->input->post('city'), 'operatorType' => $this->input->post('operatorType'), 'storeId' => $store,'company_id' => $company, 'plan' => $this->input->post('plan'), 'vehicleType' => $this->input->post('vehicleType'));
        $this->session->set_userdata($meta);
        echo json_encode(array(''));
    }

    public function getAllCities() {
        $this->DriversModel->getAllCities();
    }
    public function getStoreZones() {
        $this->DriversModel->getStoreZones();
    }

    public function checkCityExists() {
        $this->DriversModel->checkCityExists();
    }


    public function shiftLogsStore($driverID = '')
    {
       
        

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['driverData'] =  $this->DriversModel->getDriver($driverID);
      
        $data['driverID'] = $driverID;

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

        $this->table->set_heading('SHIFT NO.', 'START', 'END', 'DURATION');


        $data['pagename'] = 'storeDrivers/shiftLogsStore';
        $this->load->view("template", $data);
    }


    public function getShiftLogs() {
       

        $this->DriversModel->getShiftLogs();
    }

    public function sendPushToSpecific() {

        $this->load->library('mongo_db');

        $mongo = $this->mongo_db->db;

        $driversArrAndroid = array();
        $driversArrIos = array();
        $User_ids = array();
        $user_data = array();


//        $emails = $this->input->post('emails');
        $User_id = $this->input->post('User_id');
        $message = $this->input->post('message');
        $city_id = $this->input->post('city_id');

//          foreach ($User_id as $a)
//                 $user_data [] = $a;
//           $users = implode(',', array_filter(array_unique($User_id)));


        $msg = "Driver";
        $query = "";
        $usertype = $this->input->post('usertype');

        if ($usertype == 2) {
            $query = "select * from slave where slave_id in ('" . $User_id . "')"; //If the passengers are deleted so for that check user exist on not
            $msg = "Passanger";
            $data = $this->db->query($query)->result();
            foreach ($data as $res) {
//                $driversArrAndroid[] = $res->push_token;
                $User_ids[] = $res->slave_id;
            }

            $query1 = "select * from user_sessions where oid in ('" . $User_ids . "') and user_type = 2 and loggedIn = 1";
            $data1 = $this->db->query($query1)->result();
            foreach ($data1 as $res) {

                if ($res->type == 1)
                    $driversArrIos[] = $res->push_token;
                else if ($res->type == 2)
                    $driversArrAndroid[] = $res->push_token;
            }
        } else {

            $query = "select * from master where mas_id in ('" . $User_id . "')";
            $msg = "Driver";
            $data = $this->db->query($query)->result();
            foreach ($data as $res) {
//                print_r($res);
//                $driversArrAndroid[] = $res->push_token;
                $User_ids[] = $res->mas_id;
            }
//            print_r($User_ids);

            $d = $users = implode(',', array_filter(array_unique($User_ids)));

            $query1 = "select * from user_sessions where oid in ('" . $d . "') and user_type = 1 and loggedIn = 1";
            $data1 = $this->db->query($query1)->result();

            foreach ($data1 as $res) {

                if ($res->type == 1)
                    $driversArrIos[] = $res->push_token;
                else if ($res->type == 2)
                    $driversArrAndroid[] = $res->push_token;
            }


            if (empty(array_filter($driversArrAndroid)) && empty(array_filter($driversArrIos))) {// || empty(array_filter($driversArrIos))) {
                echo json_encode(array('flag' => 2, 'msg' => 'No user found'));
                return;
            }
        }

        $aplTokenArr = array_values(array_filter(array_unique($driversArrIos)));
        $andiTokenArr = array_values(array_filter(array_unique($driversArrAndroid)));
//            
//          foreach ($driversArrAndroid as $val) {
//            if (!in_array($val,$array)) {
//                $array[] = $val;
//            }
//        }
//        $driversArrAndroid = $array;

        $data = $this->DriversModel->senPushToDriver($aplTokenArr, $andiTokenArr, $message, $city_id, $usertype, $User_ids);
        if ($data['errorNo'] == 44)
            echo json_encode(array('count' => $data['count'], 'user_id' => $User_ids, 'IOS' => $data['test1'], 'msg' => $msg, 'flag' => 1, 'err' => $data['err'], 'array' => $data));
        else
            echo json_encode(array('count' => $data['count'], 'dataFrompush' => $data, 'user_id' => $User_ids, 'flag' => 3, 'err' => "Something went wrong.", 'array' => array('and' => $driversArrAndroid, 'ios' => $driversArrIos)));
    }

    public function getOperatorsAjax($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->getOperatorsAjax($param);
    }
    public function getStores($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        echo json_encode(array('data'=>$this->DriversModel->getStores($param)));
    }

    public function Dashboard() {
        $sessionsetornot = $this->DriversModel->issessionset();
        if ($sessionsetornot) {
            $data['dashboardData'] = $this->DriversModel->Getdashboarddata();
            $data['pagename'] = "Dashboard";
            $this->load->view("template", $data);
        } else {
            redirect(base_url() . "index.php?/Drivers");
        }
    }

    function datatable() {
        $this->DriversModel->datatable();
    }

    public function driverReferral() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['pagename'] = "driverReferralTracker";

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
        $this->table->set_heading('DRIVER NAME', 'DRIVER MOBILE', 'DRIVER EMAIL', 'CURRENT PLAN', 'REFERRAL CODE', 'NO. OF REFERRALS');
        $this->load->view("template", $data);
    }

    

   


   

   

    //Used in Send Notificaion Page
    function getAppConfigOneAjax() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $appConfig = $this->DriversModel->getAppConfigOne();
        echo json_encode(array('data' => $appConfig));
    }

    public function driverCompletedBookingList($cycleID = '', $driverID = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['pagename'] = "paymentCycle/driverCompletedBookingList";
        $data['driverID'] = $driverID;
        $data['cycleID'] = $cycleID;
        $data['driverDetail'] = $this->DriversModel->getDriver($driverID);
        $appConfig = $this->DriversModel->getAppConfigOne();
        $data['paymentCycleDetails'] = $this->DriversModel->getPaymentDetails($cycleID);

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
        $this->table->set_heading('BOOKING ID', 'CUSTOMER NAME', 'FROM ADDRESS', 'TO ADDRESS', '(' . ($appConfig['mileage_metric'] == 0) ? 'DISTANCE (KM)' : 'DISTANCE (MILE)' . ')', 'BILLED AMOUNT (' . $appConfig['currencySymbol'] . ')', 'DRIVER EARNINGS', 'PAYMENT METHOD', 'VIEW');
        $this->load->view("template", $data);
    }

    function datatable_driverCompletedBookingList($driverID = '', $cycleID = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->datatable_driverCompletedBookingList($driverID, $cycleID);
    }

    public function referralEarningList($cycleID = '', $driverID = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['pagename'] = "paymentCycle/driverEarningList";
        $data['driverID'] = $driverID;
        $data['cycleID'] = $cycleID;
        $data['driverDetail'] = $this->DriversModel->getDriver($driverID);
        $appConfig = $this->DriversModel->getAppConfigOne();
        $data['paymentCycleDetails'] = $this->DriversModel->getPaymentDetails($cycleID);

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
        $this->table->set_heading('BOOKING ID', 'REFERRER NAME', 'CUSTOMER NAME', 'FROM ADDRESS', 'TO ADDRESS', '(' . ($appConfig['mileage_metric'] == 0) ? 'DISTANCE (KM)' : 'DISTANCE (MILE)' . ')', 'BILLED AMOUNT (' . $appConfig['currencySymbol'] . ')', 'REFERRAL EARNINGS', 'PAYMENT METHOD', 'VIEW');
        $this->load->view("template", $data);
    }

    function datatable_referralEarningList($driverID = '', $cycleID = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->datatable_referralEarningList($driverID, $cycleID);
    }

    public function licenceplaetno() {

     
        return $this->DriversModel->licenceplaetno();
    }

    public function accounting() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['appConfig'] = $appConfig = $this->DriversModel->getAppConfigOne();
        $data['pagename'] = "accounting";

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
        $this->table->set_heading('BOOKING ID', 'BOOKING DATE & TIME', 'DRIVER NAME', 'CUSTOMER NAME', 'FARE (' . $appConfig['currencySymbol'] . ')', 'DISCOUNT (' . $appConfig['currencySymbol'] . ')', 'ADJUSTMENTS', 'BILLED (' . $appConfig['currencySymbol'] . ')', 'APP EARNINGS (' . $appConfig['currencySymbol'] . ')', 'PAYMENT GATEWAY COMMISSION (' . $appConfig['currencySymbol'] . ')', 'APP PROFIT-LOSS (' . $appConfig['currencySymbol'] . ')', 'DRIVER EARNINGS (' . $appConfig['currencySymbol'] . ')', 'REFERRER EARNINGS', 'PAYMENT METHOD', 'BOOKING STATUS', 'INVOICE');
        $this->load->view("template", $data);
    }

    function updateBookingDetails($order_id = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->updateBookingDetails($order_id);
        redirect(base_url() . 'index.php?/Drivers/tripDetails/' . $order_id);
    }

    function getShipmentData() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->getShipmentData();
    }

    public function customerVerification() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->load->library('Datatables');
        $this->load->library('table');
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

        $this->table->set_heading('EMAIL', 'MOBILE', 'CODE', 'DATE');

        $data['pagename'] = 'customerVerification';
        $this->load->view("template", $data);
    }

    public function dt_customerVerification() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->DriversModel->dt_customerVerification();
    }

    public function driverVerification() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->load->library('Datatables');
        $this->load->library('table');
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

        $this->table->set_heading('EMAIL', 'MOBILE', 'CODE', 'DATE');

        $data['pagename'] = 'driverVerification';
        $this->load->view("template", $data);
    }

    public function dt_driverVerification() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->DriversModel->dt_driverVerification();
    }

    // driver wallet

    public function DriverRecharge() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['gat_way'] = "2";
        $data['pagename'] = "DriverRechargeList";
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->table->clear();

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
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
        $this->table->set_heading('SLNO', 'DRIVER ID', 'DRIVER NAME', 'CURRENT BALANCE', 'LAST RECHARGE DATE', 'OPERATION');
        $this->load->view("template", $data);
    }

    public function DriverRechargeStatement($id) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['driverId'] = $id;
        $data['driverinfo'] = $this->DriversModel->GetDriverDetils($id);
        $data['pagename'] = "DriverRechargeStatement";
        $this->load->library('Datatables');
        $this->load->library('table');


        $this->table->clear();
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
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
        $this->table->set_heading('OPENING BALANCE', 'BOOKINGID', 'COMISSION', 'COLSING BALANCE');
        $this->load->view("template", $data);
    }

    public function DriverRechargeStatement_ajax($param) {
        $this->DriversModel->DriverRechargeStatement($param);
    }

    public function Recharge($id) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['driverId'] = $id;
        $data['driverinfo'] = $this->DriversModel->GetDriverDetils($id);
        $data['pagename'] = "DriverRechargeDetails";
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->table->clear();
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
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
        $this->table->set_heading('SLNO', 'RECHARGE AMOUNT', 'RECHARGE DATE', 'OPERATION');
        $this->load->view("template", $data);
    }

    public function DriverRechargeDetails_ajax($param) {

        $this->DriversModel->DriverRechargeDetails($param);
    }

    public function RechargeOperation($for, $id, $masid = '') {

        $data = $this->DriversModel->RechargeOperation($for, $id, $masid);
        if ($data == 44)
            redirect(base_url() . "index.php?/Drivers/Recharge/" . $masid);
    }

    public function GetRechargedata_ajax($param) {

        $this->DriversModel->GetRechargedata_ajax();
    }

    // end driver wallet
    //* my controllers name is naveena *//


    public function showAvailableCities() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data = $this->DriversModel->loadAvailableCity();
        echo json_encode($data);
    }

  

    function dt_passenger($status) {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->dt_passenger($status);
    }

    public function editdispatchers_city() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['editingcity'] = $this->DriversModel->editdispatchers_city();
    }

    public function datatable_cities() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->datatable_cities();
    }

    public function datatable_operator($status) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->datatable_operator($status);
    }

    public function datatable_vehicletype() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->datatable_vehicletype();
    }

    public function datatable_vehicles($status) {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->datatable_vehicles($status);
    }

    public function datatable_driver($status) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->datatable_driver($status);
    }

    public function datatable_dispatcher($status) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->datatable_dispatcher($status);
    }

  
    

   
   
    
   
    

    

   
    Public function checkeDriverIsOnTrip() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->checkeDriverIsOnTrip();
    }

    
    
    

    public function editdriverpassword() {

       
        $data = $this->DriversModel->editdriverpassword();
    }

    
    
   
   

    public function getWalletForDriver() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['result'] = $this->DriversModel->getWalletForDriver();
    }

 

    public function acceptdrivers() {

       
//        print_r($_POST);die;

        $id = $this->input->post('val');
        $company_id = $this->input->post('company_id');
        $planID = $this->input->post('planID');
        $planName = $this->input->post('planName');
        $planActiveDate = $this->input->post('planActiveDate');
        $storeId = $this->input->post('storeId');
        $storeName = $this->input->post('storeName');
        $operatorId = $this->input->post('operatorId');
        $operatorName = $this->input->post('operatorName');
        $zoneIds = $this->input->post('zoneIds');
        $ban = $this->input->post('banDriver');
        $cityId = $this->input->post('cityId');
        $cityName = $this->input->post('cityName');
        
        if (empty($id) && !is_string($id) && empty($planID) && !is_string($planID)&& empty($storeId) && !is_string($storeId)) {
            echo json_encode(array('msg' => "Unable to update plan id or data id not found", 'flag' => 1));
            
        }else{
            $data['result'] = $this->DriversModel->acceptdrivers($id, 
                                                                    $company_id, 
                                                                    $planID, 
                                                                    $planName, 
                                                                    $operatorName, 
                                                                    $operatorId, 
                                                                    $storeName, 
                                                                    $storeId, 
                                                                    $planActiveDate, 
                                                                    $zoneIds,
                                                                    $ban,
                                                                    $cityId,
                                                                    $cityName
                                                                );            
        }

    }

    

    public function enDisCreditDriver() {

        
        $this->DriversModel->enDisCreditDriver();
    }

    //Manually logout the driver from admin panel
    public function driver_logout() {      

         $this->DriversModel->driver_logout();
    }

    public function driver_logoutsingle() {      

        $this->DriversModel->driver_logoutsingle();
   }

    public function makeDriverOffline() {

       

         $this->DriversModel->makeDriverOffline();
    }

    
   

    public function banDrivers() {

       
        $this->DriversModel->banDrivers();
    }

    public function rejectdrivers() {

       
        $this->DriversModel->rejectdrivers();
    }

 

    public function getCitiesList() {

       
        $this->DriversModel->getCitiesList();
    }


   
  
    

  
    public function cityForZonesData() {

        
        $this->DriversModel->cityForZonesData();
    }

   
    public function getStoreDataBasedOnCity() {

        
        $this->DriversModel->getStoreDataBasedOnCity();
    }
    public function getZonesBasedOnStores() {

       
        $this->DriversModel->getZonesBasedOnStores();
    }

  

    public function datatable_storedrivers($for = '', $status = '') {

        $data = $this->DriversModel->datatable_storedrivers($for, $status);
    }
 public function storeDrivers($for = '', $status = '') {
      

        $this->load->library('Datatables');
        $this->load->library('table');

        $data['Operators'] = $this->DriversModel->getOperators();
        $data['appCofig'] = $this->DriversModel->getAppConfigOne();
        
        $data['status'] = $status;

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
        $checkbox=' <input type="checkbox" id="select_all" />';
            
      
       $this->table->set_heading('DRIVER TYPE', 'APP VERSION', 'DRIVER NAME', 'CITY','EMAIL','MOBILE NUMBER', 'STORE','PLAN NAME', 'REFERRAL CODE', 'RENEWAL DATE', 'AVERAGE RATING', 'CREDIT LINE', 'WALLET (SET LIMIT)', 'REJECTED ON', 'REGISTERED ON', 'ONLINE STATUS','LAST UPDATED LOCATION', 'SHIFT LOGS','REASON', 'BANNED ON','ACTION', 'SELECT');
    //     $this->table->set_heading($this->lang->line('col_driverType'),$this->lang->line('col_appVersion'),$this->lang->line('col_driverName'),$this->lang->line('col_city'),
    //     $this->lang->line('col_email'),$this->lang->line('col_mobnum'),$this->lang->line('col_store'),
    //     $this->lang->line('col_planName'),$this->lang->line('col_referalcode'),$this->lang->line('col_averageRating'),
    //     $this->lang->line('col_creditLine'),$this->lang->line('col_wallet'),$this->lang->line('col_rejOn'),
    //     $this->lang->line('col_regOn'),$this->lang->line('col_onlineStatus'),$this->lang->line('col_lastUpdate'),
    //     $this->lang->line('col_reason'),$this->lang->line('col_bannedon'),$this->lang->line('col_action'),
    //     $this->lang->line('col_select')
    //    ); 22/20 correct th ecolumn count
       


        $data['pagename'] = 'storeDrivers/storeDrivers';
        $this->load->view("template", $data);
    }

    public function getDriversCountForStore() {
        $this->DriversModel->getDriversCountForStore();
    }

  
    public function getDeviceLogs($userType = '') {
        $this->DriversModel->getDeviceLogs($userType);
    }


	
	 public function addnewstoredriver() {
		 $this->load->library('mongo_db');
		 $data['storeId'] = $this->session->userdata('badmin')['BizId'];
		
		//$storeData = $this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($storeId)))->find_one('stores');

        $data['appCofig'] = $this->DriversModel->getAppConfigOne();
        $data['cities'] = $this->DriversModel->cityForZones();
//        $data['cityForZones'] = $this->DriversModel->cityForZones();
        $data['cityForZonesData'] = $this->DriversModel->cityForZonesData($storeData['cityId']);
        
        //$data['store'] = $this->DriversModel->getStores();
       

        $data['pagename'] = 'storeDrivers/addNewStoreDriver';

        $this->load->view("template", $data);
    }

   
    public function editStoreDriver($id = '',$id2 = '') {
        $this->load->library('mongo_db');
        $storeId = $this->session->userdata('badmin')['BizId'];
        $return['storeId']=$storeId;        
        $storeData = $this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($storeId)))->find_one('stores');      
        $return['data'] = $this->DriversModel->editdriver($id); 
      // echo '<pre>';print_r($return['data']);die;
        $return['appCofig'] = $this->DriversModel->getAppConfigOne();
        $return['cityForZones'] = $this->DriversModel->cityForZones();
        //$return['cityForZonesData'] = $this->DriversModel->cityForZonesData($storeData['cityId']);
        $return['cityForZonesData']= $this->DriversModel->editgetZonesBasedOnStores($storeId);
        $return['Operators'] = $this->DriversModel->getOperators();
        $return['store'] = $this->DriversModel->getStores();
        $return['driverid'] = $id;
        $return['pagename'] = 'storeDrivers/editStoreDriver';
        $this->load->view("template", $return);
    }
    
 public function deleteDrivers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->deletedriver();
    }

  public function getBookingHistory() {
        $this->DriversModel->getBookingHistory();
    }

    public function getDriversReferralsList() {
        $this->DriversModel->getDriversReferralsList();
    }

    public function getCustomerReferralsList() {
        $this->DriversModel->getCustomerReferralsList();
    }

    public function getDriverDetails() {
        $this->DriversModel->getDriverDetails();
    }

    public function getAllDriversDetails() {
        $this->DriversModel->getAllDriversDetails();
    }

  

    public function getReferralDetails() {
        $this->DriversModel->getReferralDetails();
    }

    

    public function getZoneCity() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->getZoneCity();
    }

    public function getCityZones() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->getCityZones();
    }

    public function addRediousPrice() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $from_ = $this->input->post('from_');
        $to_ = $this->input->post('to_');
        $price = $this->input->post('price');
        $cityid = $this->input->post('cityid');

//        $data['rediousPrices'] = 
        $this->DriversModel->addRediousPrice($from_, $to_, $price, $cityid);
//        $data['pagename'] = "RediousPrice";
//        $this->load->view("template", $data);
    }

    public function editRediousPrice() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $mid = $this->input->post('mid');
        $status = $this->input->post('status');
        if ($status == 'del') {
            $this->DriversModel->DeleteRediousPrice($mid);
        } else {
            $from_ = $this->input->post('from');
            $to_ = $this->input->post('to');
            $price = $this->input->post('price');
            $cityid = $this->input->post('cityid');

//        $data['rediousPrices'] =
            $this->DriversModel->editRediousPrice($from_, $to_, $price, $mid, $cityid);
        }
//        $data['pagename'] = "RediousPrice";
//        $this->load->view("template", $data);
    }

    public function dispatched($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['city'] = $this->DriversModel->city_get();
        $data['getdata'] = $this->DriversModel->get_dispatchers_data($status);

        $this->load->library('Datatables');
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;font-size:12px">',
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

       // $this->table->set_heading('DISPATCHER NAME','MANAGER','CITY', 'USERNAME', 'STATUS', 'CURRENT IP ADDRESS', 'OPTION');
        $this->table->set_heading($this->lang->line('col_dispatchername'),$this->lang->line('col_manager'),$this->lang->line('col_city'),$this->lang->line('col_username'),
        $this->lang->line('col_status'),$this->lang->line('col_currentIp'),$this->lang->line('col_option'));



        $data['pagename'] = "dispatched";

        $this->load->view("template", $data);
    }

    public function finance($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['pagename'] = "finance";
        $this->load->view("template", $data);
    }

    public function joblogs($value = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['value'] = $value;
        $data['joblogs'] = $this->DriversModel->get_joblogsdata($value);
//        
//        print_r($data);
//        exit();
        $data['pagename'] = "joblogs";
        $this->load->view("template", $data);
    }

    public function sessiondetails($value = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['value'] = $value;
        $data['session_details'] = $this->DriversModel->get_sessiondetails($value);

        $data['pagename'] = "sessiondetails";
        $this->load->view("template", $data);
    }

    public function document($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['status'] = $status;

        $data['master'] = $this->DriversModel->driver();

        $data['document_data'] = $this->DriversModel->get_documentdata($status);

        $data['workname'] = $this->DriversModel->get_workplace();


        $data['pagename'] = "document";
        $this->load->view("template", $data);
    }

    public function passenger_rating() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['passenger_rating'] = $this->DriversModel->passenger_rating();



        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
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

        //$this->table->set_heading('PASSENGER ID', 'PASSENGER NAME', 'PASSENGER EMAIL', 'AVG RATING');
        $this->table->set_heading($this->lang->line('col_passengerId'),$this->lang->line('col_passengerName'),$this->lang->line('col_passengerEmail'),$this->lang->line('col_avgRating'));


        $data['pagename'] = "passenger_rating";
        $this->load->view("template", $data);
    }

    public function datatable_passengerrating() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->datatable_passengerrating();
    }

    public function getmap_values() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->getmap_values();
    }

    public function driver_review($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['driver_review'] = $this->DriversModel->driver_review($status);

        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
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

        // $this->table->set_heading('BOOKING ID', 'BOOKING DATE AND TIME', 'DRIVER NAME', 'CUSTOMER NAME', 'REVIEW', 'RATING');
        $this->table->set_heading($this->lang->line('col_bookingId'),$this->lang->line('col_bookingDateTime'),$this->lang->line('col_driverName'),
        $this->lang->line('col_customerName'),$this->lang->line('col_review'),$this->lang->line('col_rating'));

        $data['pagename'] = "driver_review";
        $this->load->view("template", $data);
    }

    public function driverRating() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['appConfig'] = $this->DriversModel->getAppConfigOne();
        $data['pagename'] = "driverRatingNew";
        $this->load->view("template", $data);
    }

    public function updateDriverRating() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->updateDriverRating();
        redirect(base_url() . "index.php?/Drivers/driverRating");
    }

    public function disputes($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['city'] = $this->DriversModel->get_city();
        $data['disputesdata'] = $this->DriversModel->get_disputesdata($status);
        $data['master'] = $this->DriversModel->driver();
        $data['slave'] = $this->DriversModel->passenger();



        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
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

        $this->table->set_heading('DISPUTE ID', 'PASSENGER ID', 'PASSENGER NAME', 'DRIVER ID', 'DRIVER NAME', 'DISPUTE MESSAGE', 'DISPUTE DATE', 'BOOKING ID', 'SELECT');



        $data['pagename'] = "disputes";
        $this->load->view("template", $data);
    }

    public function datatable_disputes($status) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->datatable_disputes($status);
    }

    public function documentgetdata() {


        echo json_encode($this->DriversModel->documentgetdata());
        exit();
    }

    public function documentgetdatavehicles() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->documentgetdatavehicles();
    }

    public function resolvedisputes() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->DriversModel->resolvedisputes();
    }

    public function delete() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['getvehicletype'] = $this->DriversModel->get_vehivletype();
        $data['getcompany'] = $this->DriversModel->get_company();
        $data['city_ram'] = $this->DriversModel->city_sorted();
        $data['driver'] = $this->DriversModel->get_driver();
        $data['vehiclemodal'] = $this->DriversModel->vehiclemodal();
        $data['country'] = $this->DriversModel->get_country();
//          print_r($data['getvehicletype']);


        $data['pagename'] = "delete";

        $this->load->view("template", $data);
    }

    public function deactivecompaigns() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['deactivate'] = $this->DriversModel->deactivecompaigns();
    }

    public function deletetype() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->DriversModel->deletetype();
    }

    public function godsview() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['pagename'] = "godsview";
        $data['cities'] = $this->DriversModel->get_cities();
        $this->load->view("template", $data);
    }

    public function getDtiverDetail() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->getDtiverDetail();
    }

    //    ajax call for getting Driver arround customer
    public function getDtiversArround() {


        $this->load->library('mongo_db');

        $mongo = $this->mongo_db->db;
        $query = array();
        $apptStatusVals = array(2, 3, 4);
        if ($this->input->post('type_id') != "")
            $query['type'] = (int) $this->input->post('type_id');
        if (in_array($this->input->post('selected'), $apptStatusVals)) {

            $query['apptStatus'] = $this->input->post('selected') == '2' ? 6 : ( $this->input->post('selected') == '3' ? 7 : 8);
            $query['status'] = 5;
        } else {
            $query['status'] = 3;
        }

        $resultArr = $mongo->selectCollection('$cmd')->findOne(array(
            'geoNear' => 'location',
            'near' => array(
                (double) $this->input->post('longitude'), (double) $this->input->post('lattitude')
            //  (double) $_REQUEST['lat'], (double) $_REQUEST['lon']
            ), 'spherical' => true, 'maxDistance' => 50000 / 6378137, 'distanceMultiplier' => 6378137, 'query' => $query)
        );

//print_r($resultArr);
        $driversArr = array();


//        $statusColors = array("3" => "green.png", "6" => 'blue.png', "7" => 'yellow.png', "8" => 'red.png');

        foreach ($resultArr['results'] as $res) {
            $doc = $res['obj'];
            $dis = $res['dis'];

            $iconPath = ServiceLink . '/images/';
            $switch = ($doc['status'] != 3) ? (int) $doc['apptStatus'] : 3;
            $ico = $iconPath . "Vehicle_";
            $icon = '';
            switch ($switch) {
                case 6: $icon = $ico . "blue.png"; //driver accepted.png
                    break;
                case 7: $icon = $ico . "yellow.png"; //on the way.png
                    break;
                case 8: $icon = $ico . "red.png"; //reached.png
                    break;
                default : $icon = $ico . "green.png"; //item picked and enroute to delivery address.png
                    break;                           //available.png
            }

            $driversArr[] = array('lat' => (double) $doc['location']['latitude'], 'lon' => (double) $doc['location']['longitude'], 'id' => $doc['user'], 'type_id' => $doc['type'], 'status' => (int) $doc['status'], 'icon' => $icon);
        }

//  print_r($driversArr);

        echo json_encode(array('result' => $driversArr));
    }

    public function refreshMap($param = '') {
        $this->load->library('mongo_db');
        $this->load->database();
        $mongo = $this->mongo_db->db;
        $query = array();
        $apptStatusVals = array(2, 3, 4);

        if ($this->input->post('type_id') != "")
            $query['type'] = (int) $this->input->post('type_id');

        if (in_array($this->input->post('selected'), $apptStatusVals)) {

            $query['apptStatus'] = $this->input->post('selected') == '2' ? 6 : ( $this->input->post('selected') == '3' ? 7 : 8);
            $query['status'] = 5;
        } else {
            $query['status'] = 3;
        }

        $resultArr = $mongo->selectCollection('$cmd')->findOne(array(
            'geoNear' => 'location',
            'near' => array(
                (double) $this->input->post('longitude'), (double) $this->input->post('lattitude')
            //  (double) $_REQUEST['lat'], (double) $_REQUEST['lon']
            ), 'spherical' => true, 'maxDistance' => 50000 / 6378137, 'distanceMultiplier' => 6378137, 'query' => $query)
        );

        foreach ($resultArr['results'] as $res) {
            $doc = $res['obj'];
            $driversArr[] = $doc['user']; //'u'.
//            $query = $this->db->query("select type_icon from workplace_types where type_id ='".$doc['type']."'")->row_array();
            $iconPath = ServiceLink . '/images/';
            $switch = ($doc['status'] != 3) ? (int) $doc['apptStatus'] : 3;
            $ico = $iconPath . "Vehicle_";
            $icon = '';
            switch ($switch) {
                case 6: $icon = $ico . "blue.png"; //driver accepted.png
                    break;
                case 7: $icon = $ico . "yellow.png"; //on the way.png
                    break;
                case 8: $icon = $ico . "red.png"; //reached.png
                    break;
                default : $icon = $ico . "green.png"; //item picked and enroute to delivery address.png
                    break;                           //available.png
            }

            $dreiverdata[$doc['user']] = array('lat' => (double) $doc['location']['latitude'], 'lon' => (double) $doc['location']['longitude'], 'id' => $doc['user'], 'type_id' => $doc['type'], 'status' => (int) $doc['status'], 'icon' => $icon);
        }
        echo json_encode(array('online' => $driversArr, 'master_data' => $dreiverdata));
    }

    public function get_vehicle_type() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }


        $this->load->library('mongo_db');

        $mongo = $this->mongo_db->db;
        $typesData = array();
        $cond = array(
            'geoNear' => 'vehicleTypes',
            'near' => array(
                (double) $this->input->post('pic_long'), (double) $this->input->post('pic_lat')
            ), 'spherical' => true, 'maxDistance' => 50000 / 6378137, 'distanceMultiplier' => 6378137);

        $resultArr1 = $mongo->selectCollection('$cmd')->findOne($cond);

        foreach ($resultArr1['results'] as $res) {
            $doc = $res['obj'];

            $types[] = (int) $doc['type'];

            $typesData[$doc['type']] = array(
                'type_id' => (int) $doc['type'],
                'type_name' => $doc['type_name'],
                'max_size' => (int) $doc['max_size'],
                'basefare' => (float) $doc['basefare'],
                'min_fare' => (float) $doc['min_fare'],
                'price_per_min' => (float) $doc['price_per_min'],
                'price_per_km' => (float) $doc['price_per_km'],
                'type_desc' => $doc['type_desc']
            );
        }

        echo json_encode($typesData);
    }

    public function vehicle_models($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['vehiclemake'] = $this->DriversModel->get_vehiclemake();

        if ($status == 1) {

            $this->load->library('Datatables');
            $this->load->library('table');

            $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
                'heading_row_start' => '<tr style= "font-size:10px"role="row">',
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


            $this->table->set_heading('SL NO.', 'BRAND NAME', 'SELECT');
        } else if ($status == 2) {

            $this->load->library('Datatables');
            $this->load->library('table');

            $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
                'heading_row_start' => '<tr style= "font-size:10px"role="row">',
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

            $this->table->set_heading('ID', 'BRAND NAME', 'MODEL', 'SELECT');
        }


        $data['pagename'] = "vehicle_models";
        $this->load->view("template", $data);
    }

    function datatable_vehiclemodels($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        if ($status == 1) {
            $this->DriversModel->datatable_vehicleMake();
        } else if ($status == 2) {
            $this->DriversModel->datatable_vehicleModel();
        }
    }

    public function testID() {

        $this->DriversModel->testID();
//         $url = APILink.'master/email';
//        $r = $this->callapi->CallAPI('POST',$url,array('id'=>"5971ab7625489636ef76fdf3",'type'=>1));
////        
//        print_r($r);
    }

    //Add/Edit Vehicle make
    public function addEditVehicleMake($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        if ($param == 'add')
            $this->DriversModel->addVehicleMake();
        else if ($param == 'edit')
            $this->DriversModel->editVehicleMake();
        else
            $this->DriversModel->deleteVehicleMake();
    }

    //Add/Edit Vehicle make
    public function addEditVehicleModel($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        if ($param == 'add')
            $this->DriversModel->addVehicleModel();
        else if ($param == 'edit')
            $this->DriversModel->editVehicleModel();
        else
            $this->DriversModel->deleteVehicleModel();
    }

    public function getComapnyDetails() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data = $this->DriversModel->getComapnyDetails();
    }

    public function insertmodal() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->DriversModel->insert_modal();
    }

    public function deletevehicletype() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->DriversModel->deletevehicletype();
    }

    public function delete_company() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->DriversModel->delete_company();
    }

    public function deletevehiclemodal() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->DriversModel->deletevehiclemodal();
    }

    public function deletevehicletypemodel() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->DriversModel->deletevehicletypemodel();
    }

    public function forgotPasswordFromadmin() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->DriversModel->forgotPasswordFromadmin();
    }

    public function deletedriver() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->DriversModel->deletedriver();
    }

    public function deletemodal() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->DriversModel->deletemodal();
    }

    public function promo_details($id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
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

        $this->table->set_heading('INVOICE VALUE', 'DISCOUNT', 'VALUE AFTER DISCOUNT', 'USED ON', 'BOOKING ID', 'CUSTOMER ID', 'CUSTOMER EMAIL');

        $data['pagename'] = "promo_details";
        $data['mid'] = $id;
        $this->load->view("template", $data);
    }

    public function referral_details($id = '', $page = 1) {

        $data['referral_details'] = $this->DriversModel->get_referral_details($id, $page);

        $data['coupon_id'] = $id;

        $data['pagename'] = "referral_details";

        $this->load->view("template", $data);
    }

    public function compaigns($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['city'] = $this->DriversModel->get_city();
        $data['compaign'] = $this->DriversModel->get_compaigns_data($status);

        $data['pagename'] = "compaigns";
        $this->load->view("template", $data);
    }

    public function compaigns_ajax($for = '', $status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->get_compaigns_data_ajax($for, $status);
    }

    public function insertcompaigns() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        echo $this->DriversModel->insertcampaigns();
    }

    public function updatecompaigns() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        echo $this->DriversModel->updatecompaigns();
    }

    public function editcompaigns() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->editcompaigns();
    }

    public function cancled_booking() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['pagename'] = "cancled_booking";
        $this->load->view("template", $data);
//        $this->load->view("cities");
    }

    public function Get_dataformdate($stdate = '', $enddate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
//        $data = $this->DriversModel->get_all_data();
        $data['transection_data'] = $this->DriversModel->getDatafromdate($stdate, $enddate);
        $data['stdate'] = $stdate;
        $data['enddate'] = $enddate;
        $data['gat_way'] = '2';
        $data['pagename'] = "Transection";
        $this->load->view("template", $data);
    }

    public function Get_dataformdate_for_all_bookingspg($stdate = '', $enddate = '', $status = '', $company_id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->getDatafromdate_for_all_bookings($stdate, $enddate, $status, $company_id);
    }

    public function search_by_select($selectdval = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->getDataSelected($selectdval);
    }

    public function profile() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $sessionsetornot = $this->DriversModel->issessionset();
        if ($sessionsetornot) {
            $data['userinfo'] = $this->DriversModel->getuserinfo();
            $data['pagename'] = "profile";
            $this->load->view("template", $data);
        } else {
            redirect(base_url() . "index.php?/Drivers");
        }
    }

    public function services() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $sessionsetornot = $this->DriversModel->issessionset();
        if ($sessionsetornot) {

            $data['service'] = $this->DriversModel->getActiveservicedata();
            $data['pagename'] = "Addservice";
            $this->load->view("template", $data);
        } else {
            redirect(base_url() . "index.php?/Drivers");
        }
    }

    public function updateservices($tablename = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->updateservices($tablename);
        redirect(base_url() . "index.php?/Drivers/services");
    }

    function deleteservices($tablename = "") {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->deleteservices($tablename);
        redirect(base_url() . "index.php?/Drivers/services");
    }

    function Banking() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $sessionsetornot = $this->DriversModel->issessionset();
        if ($sessionsetornot) {

//            $data['service'] = $this->DriversModel->getActiveservicedata();
            $data['pagename'] = "banking";
            $this->load->view("template", $data);
        } else {
            redirect(base_url() . "index.php?/Drivers");
        }
    }

    public function addservices() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['service'] = $this->DriversModel->addservices();
        redirect(base_url() . "index.php?/Drivers/services");
    }

    public function booking() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $sessionsetornot = $this->madmin->issessionset();
        if ($sessionsetornot) {
            $data['bookinlist'] = $this->madmin->getPassangerBooking();
            $data['pagename'] = "booking";
            $this->load->view("index", $data);
        } else {
            redirect(base_url() . "index.php?/Drivers");
        }
    }

    function Logout() {

        $this->session->sess_destroy();
        redirect(base_url() . "index.php?/Drivers");
    }

    function udpadedataProfile() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->updateDataProfile();

        if ($this->input->post('val')) {
            $filename = "demo.png";
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], base_url() . 'files/' . $filename)) {
                echo $filename;
            }
        }
        redirect(base_url() . "index.php?/Drivers/profile");
    }

    function udpadedata($IdToChange = '', $databasename = '', $db_field_id_name = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->madmin->updateData($IdToChange, $databasename, $db_field_id_name);
        redirect(base_url() . "index.php?/Drivers/profile");
    }

    public function updateMasterBank() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
//        return;
        $ret = $this->DriversModel->updateMasterBank();
        $data['error'] = $ret['flag'];
        $data['error_message'] = $ret['message'];
        $data['error_array'] = $ret;
        $data['userData'] = $ret['data'];
        $data['pagename'] = "master/banking";
        $this->load->view("master", $data);
    }

    public function payroll() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

//        $data['payroll']=$this->adminmodel->payroll();
        $data['pagename'] = 'payroll';

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

//        $this->table->set_heading('DRIVER ID', 'NAME', 'TODAY EARNINGS (' . currency . ')', 'WEEK EARNINGS (' . currency . ')', 'MONTH EARNINGS (' . currency . ')', 'LIFE TIME EARNINGS (' . currency . ')', 'PAID (' . currency . ')', 'DUE (' . currency . ')', 'SHOW');
//        $this->table->set_heading('DRIVER ID', 'NAME', 'CARD EARNINGS(' . currency . ')','CASH EARNINGS(' . currency . ')','PG COMISSION(' . currency . ')', 'APP EARNINGS (' . currency . ')', 'DRIVER EARNINGS (' . currency . ')','DUE AMOUNT (' . currency . ')', 'SHOW');
        $this->table->set_heading('DRIVER ID', 'NAME', 'CASH EARNINGS(' . currency . ')', 'CARD EARNINGS(' . currency . ')', 'DRIVER EARNINGS (' . currency . ')', 'CASH COLLECTED(' . currency . ')', 'TOTAL RECEIVED (' . currency . ')', 'DUE AMOUNT (' . currency . ')', 'SHOW');
        $this->load->view("template", $data);
    }

    public function payroll_ajax() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->payroll();
    }

    public function payroll_data_form_date($stdate = '', $enddate = '', $company_id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->payroll_data_form_date($stdate, $enddate, $company_id);
    }

    public function DriverDetails_form_Date($stdate = '', $enddate = '', $company_id = '', $mas_id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->DriverDetails_form_Date($stdate, $enddate, $company_id, $mas_id);
    }

    public function Driver_pay($id = '', $error = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['error_data_fromInvoice'] = $error['error'];

        $data['driverdata'] = $this->DriversModel->Driver_pay($id);
        $data['payrolldata'] = $this->DriversModel->get_payrolldata($id);
        $data['totalamountpaid'] = $this->DriversModel->Totalamountpaid($id);
        $data['mas_id'] = $id;
        $data['pagename'] = 'driverpayment';
        $this->load->view("template", $data);
    }

    public function pay_driver_amount($id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $error = $this->DriversModel->insert_payment($id);
//       print_r($error);
//       exit();
        redirect(base_url() . "index.php?/Drivers/Driver_pay/" . $id . '/' . $error);
    }

    public function validateEmail() {

       
        return $this->DriversModel->validateEmail();
    }

    public function validateMobileNo() {

       
        return $this->DriversModel->validateMobileNo();
    }
    public function validateMobileNoEditDriver() {

        // if ($this->session->userdata('table') != 'company_info') {
        //     $this->Logout();
        // }
        return $this->DriversModel->validateMobileNoEditDriver();
    }

    public function validatedispatchEmail() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        return $this->DriversModel->validatedispatchEmail();
    }

    public function shipment($param) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['ongoing_booking'] = $this->DriversModel->shipment($param);

        $data['pagename'] = 'shipment';
        $this->load->view("template", $data);
    }

    //Get the all On-Going jobs by filtered city
    public function filter_AllOnGoing_jobs() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->filter_AllOnGoing_jobs();
    }

    //Set the Table header/columns for On Going Jobs
    public function onGoing_jobs($status = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['appConfig'] = $this->DriversModel->getAppConfigOne();
        $data['status'] = $status;

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="display: none;">',
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
        
        
        $this->table->set_heading('Order ID', 'Booking Type', 'Order Type', 'Booking Date','Customer Name', 'Store Name', 'Driver Name', 'Pickup Address', 'Delivery Address', 'Order Value', 'Delivery Fee', 'Payment Type','Status');


//        $data['ongoing_booking'] = $this->DriversModel->get_ongoing_bookings();
        $data['pagename'] = 'onGoing_jobs';
        $this->load->view("template", $data);
    }

    public function estimateRequested($status = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['appConfig'] = $this->DriversModel->getAppConfigOne();
        $data['status'] = $status;

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="display: none;">',
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
        $this->table->set_heading('ESTIMATE ID', 'BOOKING ID', 'CUSTOMER NAME', 'VEHICLE TYPE', 'REQUESTED DATE & TIME', 'PICKUP ADDRESS', 'DROP ADDRESS', ($data['appConfig']['weight_metric'] == 0) ? 'DISTANCE (Km)' : 'DISTANCE (Mile)', 'TIME', 'ESTIMATED FARE (' . $data['appConfig']['currencySymbol'] . ')');

        $data['pagename'] = 'estimateRequested';
        $this->load->view("template", $data);
    }

    public function datatable_estimateRequested($stDate = '', $endDate = '') {
        $data = $this->DriversModel->datatable_estimateRequested($stDate, $endDate);
    }

    public function getBookingCount() {
        $data = $this->DriversModel->getBookingCount();
    }

    public function getOngoingBookingAjax() {
        $data = $this->DriversModel->get_ongoing_bookings();
        echo json_encode(array('data' => $data));
    }

    //Get the all Completed jobs by filtered city
    public function filter_Allcompleted_jobs() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->filter_Allcompleted_jobs();
    }

    //Get the All Coppleted Jobs
    public function datatable_completed_jobs($stDate = '', $endDate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->datatable_completed_jobs($stDate, $endDate);
    }

    //Set the Table header/columns for All Completed Jobs
    public function completed_jobs($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['status'] = $status;
        $data['appConfig'] = $this->DriversModel->getAppConfigOne();

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
//        $this->table->set_heading('BOOKING ID', 'ESTIMATE ID', 'DRIVER NAME', 'CUSTOMER NAME', 'PICKUP', 'PICKUP DATE&TIME', 'DROP AT', 'STATUS', 'TRIP', 'INVOICE');
        
        $this->table->set_heading('Order ID','Booking Type', 'Order Type', 'Booking Date', 'Customer Name', 'Store Name', ' Driver Name', 'Pickup Address', 'Delivery Address','Order Value','Delivery Fee','Payment Type','Delivered Date','Invoice');

        $data['pagename'] = 'completed_jobs';
        $this->load->view("template", $data);
    }

    public function cancelledBookings() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['appConfig'] = $this->DriversModel->getAppConfigOne();
        $data['pagename'] = "cancelledBookings";
        $this->load->library('Datatables');
        $this->load->library('table');
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
        
 
        $this->table->set_heading('Order ID', 'Booking Type', 'Order Type', 'Booking Date', 'Customer Name', ' Store Name', 'Driver Name', 'Pickup Address', 'Delivery Address', 'Order Value','Delivery Fee','Payment Type','Cancellation Date','Cancelled By','Cancellation Reason');
        $this->load->view("template", $data);
    }

    public function datatable_cancelledBookings($stDate = '', $endDate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->datatable_cancelledBookings($stDate, $endDate);
    }

    public function unassignedBookings() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['appConfig'] = $this->DriversModel->getAppConfigOne();

        $data['pagename'] = "unassignedBookings";
        $this->load->library('Datatables');
        $this->load->library('table');
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
        $this->table->set_heading(' Order ID','Booking Type','Order Type','Booking Date','Customer Name', 'Store Name','Pickup Address','Delivery Address', 'Order Value','Delivery Fee','Payment Type','Dispatch Attempts');
        $this->load->view("template", $data);
    }

    public function datatable_unassignedBookings() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->datatable_unassignedBookings();
    }

    public function expiredBookings() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['appConfig'] = $this->DriversModel->getAppConfigOne();

        $data['pagename'] = "expiredBookings";
        $this->load->library('Datatables');
        $this->load->library('table');
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
        $this->table->set_heading('BOOKING ID', 'CUSTOMER NAME', 'PHONE', 'BOOKING REQUESTED ON', 'BOOKING REQUESTED FOR', 'FROM', 'TO', 'ATTEMPT COUNT', 'PRICING MODEL');
        $this->load->view("template", $data);
    }

    public function datatable_expiredBookings() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->datatable_expiredBookings();
    }

    public function bookingDispatchedList($orderID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['orderID'] = $orderID;

        $data['pagename'] = "bookingDispatchedList";
        $this->load->library('Datatables');
        $this->load->library('table');
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
        $this->table->set_heading('DRIVER NAME', 'CUSTOMER NAME', 'CUSTOMER PHONE', 'BOOKING RECEIVED ON', 'STATUS');
        $this->load->view("template", $data);
    }

    public function datatable_bookingDispatchedList($orderID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->datatable_bookingDispatchedList($orderID);
    }

    //Shows the Each Job Details
    public function showJob_details($param) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $return['data'] = $this->DriversModel->tripDetails($param);

        $return['pagename'] = 'showJob_details';
        $this->load->view("template", $return);
    }

    public function AddNewDriverData() {

        
        $redirect = $this->DriversModel->AddNewDriverData();
        if($redirect == "stores"){
			 redirect(base_url() . "index.php?/Drivers/storeDrivers/my/1");
		}
	}
    public function editdriverdata() {

        // if ($this->session->userdata('table') != 'company_info') {
        //     $this->Logout();
        // }
        $this->DriversModel->editdriverdata();
        
         redirect(base_url() . "index.php?/Drivers/storeDrivers/my/1");
    }

    public function AddNewVehicleData($fromAdding = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $selected_driver = $this->DriversModel->AddNewVehicleData();

        if ($fromAdding == 1)
            redirect(base_url() . "index.php?/Drivers/showDriverVehicles/" . $selected_driver);
        else
            redirect(base_url() . "index.php?/Drivers/Vehicles/1");
    }

    public function DriverDetails($mas_id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
//        $data['driverdetails'] = $this->DriversModel->DriverDetails($mas_id);
        $data['pagename'] = 'driverDetails';
        $data['mas_id'] = $mas_id;
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

        $this->table->set_heading('BOOKING ID', 'BOOKING DATE & TIME', 'CUSTOMER NAME', 'CUSTOMER PAID (' . currency . ')', 'APP COMMISSION (' . currency . ')', 'PAYMENT GATEWAY COMM. (' . currency . ')', 'DRIVER EARNING (' . currency . ')');

        $this->load->view("template", $data);
    }

    public function DriverDetails_ajax($mas_id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->DriverDetails($mas_id);
    }

    public function editpassDispatcher() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->editpassDispatcher();
    }

    public function deletecities() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->DriversModel->deletecity();
    }

    public function testmon($email, $firstname) {

        $this->DriversModel->testmon($email, $firstname);
    }

    public function testMailGun() {

        $this->DriversModel->mailGunTest();
    }

    public function invoiceDetails($param) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['invoiceDetails'] = $this->DriversModel->getInvoiceDetails($param);
//              print_r($data);exit();
        $this->load->view('Invoice', $data);
    }

    public function deleteVehicles() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->deleteVehicles();
    }

    public function ajax_call_to_get_types($param = '') {

        // if ($this->session->userdata('table') != 'company_info') {
        //     $this->Logout();
        // }

        //All freelancer drivers
        if ($param == 'vmodel') {
            $this->DriversModel->getVehicleModel();
        
        } else if ($param == 'freelanceDrivers') {
            $this->DriversModel->getfreelanceDrivers();
            
        }
    }

    public function getAllZones(){
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->DriversModel->getAllZones();
         
    }

    public function getZonesByStoreId($param){
        $this->DriversModel->getZonesByStoreId($param);
    }
    public function getZonesByCity($param){
        $this->DriversModel->getZonesByCity($param);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */