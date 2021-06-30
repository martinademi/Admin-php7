<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Superadmin extends CI_Controller {

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
      
        $this->load->model("Superadminmodal");
        $this->load->model("ProductsModel");
        
        $this->load->library('CallAPI');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
      
        

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
            redirect(base_url() . "index.php?/superadmin/Dashboard");
        } else
            $this->load->view('login', $data);
    }
           public function getOperatorList() {
        $this->Superadminmodal->getOperatorList();
    }
    public function getCustomerDetails() {
        $this->Superadminmodal->getCustomerDetails();
    }

    //Manage Access
    public function manageRole() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $return['roles'] = $this->Superadminmodal->get_roles();
        $return['users'] = $this->Superadminmodal->get_users();

        $return['pagename'] = "manageRole";
        $this->load->view("company", $return);
    }

    public function datatable_DriverAcceptanceRate() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_DriverAcceptanceRate();
    }
    public function getZones() {

        $this->Superadminmodal->getZonesWithCities();
    }

    public function DriverAcceptanceRate() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;


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
        $this->table->set_heading('DRIVER NAME', 'DRIVER PHONE', 'DRIVER EMAIL', 'TYPE', 'TOTAL BOOKING ', 'TOTAL ACCEPTED', 'TOTAL REJECTED', 'TOTAL CANCELLED', 'DID NOT RESPOND', 'ACCEPTANCE RATE( % )');
        $data['pagename'] = "DriverAcceptanceRate";
        $this->load->view("company", $data);
    }

    function role_action($param = '') {
        error_reporting(0);
        if ($param == 'del')
            $this->Superadminmodal->delete_role();
        else
            $this->Superadminmodal->role_action();
    }

    function user_action($param = '') {
        error_reporting(0);
        if ($param == 'del')
            $this->Superadminmodal->delete_user();
        else
            $this->Superadminmodal->user_action();
    }

//    function access_denied() {
//        
//        echo 'here';
//        exit();
//        $return['pagename'] = "accessDeniedPage";
//        $this->load->view("company", $return);
//    }

    public function upload_images_on_amazon() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->upload_images_on_amazon();
    }

    public function insertCity() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $error = $this->Superadminmodal->insertCity();
    }

    public function Driver_collect($id = '', $error = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['error'] = $error['error'];

        $data['totalAmount'] = $this->Superadminmodal->getDueAmount($id);


        $data['driverdata'] = $this->Superadminmodal->Driver_pay($id);
        $data['payrolldata'] = $this->Superadminmodal->get_payrolldata($id);
        $data['totalamountpaid'] = $this->Superadminmodal->Totalamountpaid($id);
        $data['mas_id'] = $id;

        $data['pagename'] = 'collectFromDriver';
        $this->load->view("company", $data);
    }

    public function updateMake() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->updateMake();
    }

    public function getMakeDetails() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->getMakeDetails();
    }

    public function updateModel() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->updateModel();
    }

    public function setcity_session() {
        $store = $this->input->post('store');
        $company = $this->input->post('company');
        $meta = array('city_id' => $this->input->post('city'), 'operatorType' => $this->input->post('operatorType'), 'storeId' => $store,'company_id' => $company, 'plan' => $this->input->post('plan'), 'vehicleType' => $this->input->post('vehicleType'));
        $this->session->set_userdata($meta);
        echo json_encode(array(''));
    }

    function getCities() {
        $cities = $this->Superadminmodal->getCities_zone();
        echo json_encode(array('cities' => $cities));
    }

    function getDispatcerData() {
        $this->Superadminmodal->getDispatcerData();
    }

    public function datatable_onGoingBookings($status = '', $stDate = '', $endDate = '') {
        $this->Superadminmodal->datatable_onGoingBookings($status, $stDate, $endDate);
    }

    function selectCityZone() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $res = $this->Superadminmodal->getZoneCities();
    }

    public function get_appointment_details() {
        $this->Superadminmodal->get_appointment_details();
    }

    public function zones() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $appConfig = $this->Superadminmodal->getAppConfigOne();

        if ($appConfig['pricing_model']['shortHaul'] == 0) {
            $data['zones_data'] = $this->Superadminmodal->zones_data();
            
//            $data['stores'] = $this->Superadminmodal->getStores();
            $data['cities'] = $this->Superadminmodal->cityForZones();
            $data['citiesNew'] = $this->Superadminmodal->cityforZonesNew();
            
            $data['pagename'] = "zones_new";
        } else {
            $data['pagename'] = "shortHaulDisabledPage";
        }
        $this->load->view("company", $data);
    }

    public function zone_pricing($param1 = '', $param2 = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['appConfig'] = $this->Superadminmodal->getAppConfigOne();

        $data['zones_data'] = $this->Superadminmodal->zones_data($param1);
        $data['zones_price'] = $this->Superadminmodal->zones_specific_data($param2);
        $data['ID'] = $param2;
        $data['cities'] = $this->Superadminmodal->getCities_zone($param1);
//       
        $data['vehicleTypes'] = $this->Superadminmodal->getVehicleTypes();

        $data['pagename'] = "zones_pricing";
        $this->load->view("company", $data);
    }

    public function vehicle_pricing($param1 = '', $param2 = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['zones_data'] = $this->Superadminmodal->zones_specific_data($param1);
        $data['vehicleType_data'] = $this->Superadminmodal->vehicleTypeData();
        $data['Fromzone_name'] = $this->Superadminmodal->zone_name($param2);


        $data['zone_from_id'] = $param1;
        $data['zone_to_id'] = $param2;

        $data['pagename'] = "vehicle_pricing";
        $this->load->view("company", $data);
    }

    public function insert_vehicle_price($param1 = '', $param2 = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->insert_vehicle_price($param1, $param2);
        redirect(base_url() . "index.php?/superadmin/zone_pricing/" . $param1);
    }

    public function getAllCities() {
        $this->Superadminmodal->getAllCities();
    }
    public function getStoreZones() {
        $this->Superadminmodal->getStoreZones();
    }
    public function updateZone() {
        $this->Superadminmodal->updateZone();
    }

    public function zonemapsapi() {
        $this->Superadminmodal->zonemapsapi();
    }

    public function checkCityExists() {
        $this->Superadminmodal->checkCityExists();
    }


    public function operating_zonesAPI() {
        $this->Superadminmodal->operating_zonesAPI();
    }

//    public function getOperating_zones() {
//        $this->Superadminmodal->getOperating_zones();
//    }
    public function shortHaul_zonesAPI() {
        $this->Superadminmodal->shortHaul_zonesAPI();
    }

    public function zones_new() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['zones_data'] = $this->Superadminmodal->zones_data();
        
        $data['cities'] = $this->Superadminmodal->cityForZones();

        $data['pagename'] = "zones";
        $this->load->view("company", $data);
    }

    public function deleteZone() {
        $this->Superadminmodal->deleteZone();
    }

    public function deleteShortHaul() {
        $this->Superadminmodal->deleteShortHaul();
    }

    public function getAllVehicleType() {
        $this->Superadminmodal->getAllVehicleType();
    }

    public function getAllVehicleTypesForDrivers() {
        $this->Superadminmodal->getAllVehicleTypesForDrivers();
    }

    public function getLong_haul_data() {
        $this->Superadminmodal->getLong_haul_data();
    }

    public function tripDetails($param) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $return['data'] = $this->Superadminmodal->tripDetails($param);
        $return['order_id'] = $param;


        $return['pagename'] = "trip_details";
//         $return['pagename'] = "trip_details_pathTest";
        $this->load->view("company", $return);
        //$this->Superadminmodal->tripDetails();
    }

    public function Invoice($id) {
        $this->Superadminmodal->getInvoice($id);
    }

    public function getInvoiceForcompleted($id) {
        $this->Superadminmodal->getInvoiceForcompleted($id);
    }

    public function AuthenticateUser() {
        $email = $this->input->post("email");
        $password = $this->input->post("password");


        if ($email && $password) {

            $status = $this->Superadminmodal->validateSuperAdmin();

            if ($status) {
                if ($this->session->userdata('table') == 'company_info')
                    redirect(base_url() . "index.php?/superadmin/Dashboard");
            } else {
                $loginerrormsg = "Invalid email or password";
//                $data['pagename'] = "login";
//                $this->load->view("company", $data);
                $this->index($loginerrormsg);
            }
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    function ForgotPassword() {
        $this->Superadminmodal->ForgotPassword();
    }

    public function uniq_val() {

        $this->Superadminmodal->uniq_val_chk();
    }

    public function startpage() {

        $data['pagename'] = 'startpage';

        $this->load->view("company", $data);
    }

    public function allDispatchedJobs($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');
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

        $this->table->set_heading('BOOKING ID', 'SUB ID', 'DRIVER ID', 'DRIVER NAME', 'CUSTOMER NAME', 'PICKUP ADDRESS', 'SHIPPING ADDRESS', 'RECEIVED BOOKING TIME', 'STATUS');

        $data['pagename'] = 'allDispatch_job';
        $this->load->view("company", $data);
    }

    //Get the All Dispatched Jobs
    public function datatable_allDispatchedJobs() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_allDispatchedJobs();
    }

//    public function ajax_NotifyiConsole($id) {
//        $this->Superadminmodal->get_notifieduser($id);
//    }
    //Get driver email id
    public function show_allEmails() {
        $data = $this->Superadminmodal->show_allEmails();
        echo json_encode($data);
    }

    public function SendPush() {

        $this->load->library('mongo_db');

        $mongo = $this->mongo_db->db;

        $driversArrAndroid = array();
        $driversArrIos = $array = array();
        $User_ids = array();

        $citylatlon = explode('-', $this->input->post('city'));
        $message = $this->input->post('message');

        $msg = "Driver";
        $query = "";
        $usertype = $this->input->post('usertype');
        $city_id = $this->input->post('city');
        if ($usertype == 2) {
            $query = '(SELECT us.push_token FROM slave s,user_sessions us WHERE (3956 * ACOS( COS( RADIANS(' . $citylatlon[0] . ') ) * COS( RADIANS(s.latitude) ) * COS( RADIANS(s.longitude) - RADIANS(' . $citylatlon[1] . ')) + SIN( RADIANS(' . $citylatlon[0] . ')) * SIN( RADIANS(s.latitude) ) ) ) <= ' . PUSH_PASSANGER_REDIUOS . ' AND us.oid = s.slave_id AND us.user_type = "2")';
            $msg = "Passanger";
            $data = $this->db->query($query)->result();
            foreach ($data as $res) {
                $driversArrAndroid[] = $res->push_token;
                $User_ids[] = $res->oid;
            }
        } else {
            $resultArr = $mongo->selectCollection('$cmd')->findOne(array(
                'geoNear' => 'location',
                'near' => array(
                    (double) $citylatlon[1], (double) $citylatlon[0]
                //  (double) $_REQUEST['lat'], (double) $_REQUEST['lon']
                ), 'spherical' => true, 'maxDistance' => 50000 / 6378137, 'distanceMultiplier' => 6378137)
            );


            foreach ($resultArr['results'] as $res) {

                $doc = $res['obj'];

                if ($doc['User_type'] == 1) {
                    $driversArrIos[] = $doc['pushToken'];
                    $User_ids[] = $doc['user'];
                }
                if ($doc['User_type'] == 2) {
                    $driversArrAndroid[] = $doc['pushToken'];
                    $User_ids[] = $doc['user'];
                }
            }

            if (empty(array_filter($driversArrAndroid))) {// || empty(array_filter($driversArrIos))) {
                echo json_encode(array('flag' => 2, 'msg' => $msg));
                return;
            }
        }

        foreach ($driversArrAndroid as $val) {
            if (!in_array($val, $array)) {
                $array[] = $val;
            }
        }

        $driversArrAndroid = $array;

        $data = $this->Superadminmodal->senPushToDriver($driversArrIos, $driversArrAndroid, $message, $city_id, $usertype, $User_ids);
        if ($data['errorNo'] == 44)
            echo json_encode(array('count' => $data['count'], 'user_id' => $User_ids, 'IOS' => $data['test1'], 'msg' => $msg, 'flag' => 1, 'err' => $data['err'], 'array' => $data));
        else
            echo json_encode(array('count' => $data['count'], 'dataFrompush' => $data, 'user_id' => $User_ids, 'flag' => 3, 'err' => "Something went wrong.", 'array' => array('and' => $driversArrAndroid, 'ios' => $driversArrIos)));
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

        $data = $this->Superadminmodal->senPushToDriver($aplTokenArr, $andiTokenArr, $message, $city_id, $usertype, $User_ids);
        if ($data['errorNo'] == 44)
            echo json_encode(array('count' => $data['count'], 'user_id' => $User_ids, 'IOS' => $data['test1'], 'msg' => $msg, 'flag' => 1, 'err' => $data['err'], 'array' => $data));
        else
            echo json_encode(array('count' => $data['count'], 'dataFrompush' => $data, 'user_id' => $User_ids, 'flag' => 3, 'err' => "Something went wrong.", 'array' => array('and' => $driversArrAndroid, 'ios' => $driversArrIos)));
    }

    public function getOperatorsAjax($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getOperatorsAjax($param);
    }
    public function getStores($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        echo json_encode(array('data'=>$this->Superadminmodal->getStores($param)));
    }

    public function Dashboard() {

         if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $sessionsetornot = $this->Superadminmodal->issessionset();
        if ($sessionsetornot) {
            $data['dashboardData'] = $this->Superadminmodal->Getdashboarddata();
            $report=$this->Superadminmodal->getIfraneUrl('1');
            $data['iframeUrl']=$report['data']['report'];
            $data['pageTitle']="Dashboard";
            $data['pagename'] = "Dashboard";
            $data['pagename'] = "Dashboard";
            $this->load->view("company", $data);
        } else {
            redirect(base_url() . "index.php?/superadmin");
        }
    }

    function datatable() {
        $this->Superadminmodal->datatable();
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
        $this->load->view("company", $data);
    }

    public function datatable_driverReferrals() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_driverReferrals();
    }

    public function paymentCycle() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['pagename'] = "paymentCycle/paymentCycle";

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
        $this->table->set_heading('PAYMENT CYCLE ID', 'START DATE & TIME', 'END DATE & TIME', 'TOTAL REVENUE', 'NO. OF DRIVERS', 'NO. OF OPERATORS', 'CYCLE STATUS');
        $this->load->view("company", $data);
    }

    function datatablePaymentCycle() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatablePaymentCycle();
    }

    public function paymentCycleDriversList($cycleID) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['pagename'] = "paymentCycle/paymentCycleDriversList";
        $data['CycleID'] = $cycleID;
        $data['paymentCycleDetails'] = $this->Superadminmodal->getPaymentDetails($cycleID);

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
        $this->table->set_heading('DRIVER NAME', 'DRIVER PHONE', 'COMPLETED TRIPS', 'TOTAL BILLING', 'DRIVER EARNINGS', 'REFERRAL EARNINGS', 'NET PAYABLE', 'PAYMENT STATUS');
        $this->load->view("company", $data);
    }

    function datatable_paymentCycleDriversList($cycleID = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_paymentCycleDriversList($cycleID);
    }

    //Used in Send Notificaion Page
    function getAppConfigOneAjax() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $appConfig = $this->Superadminmodal->getAppConfigOne();
        echo json_encode(array('data' => $appConfig));
    }

    public function driverCompletedBookingList($cycleID = '', $driverID = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['pagename'] = "paymentCycle/driverCompletedBookingList";
        $data['driverID'] = $driverID;
        $data['cycleID'] = $cycleID;
        $data['driverDetail'] = $this->Superadminmodal->getDriver($driverID);
        $appConfig = $this->Superadminmodal->getAppConfigOne();
        $data['paymentCycleDetails'] = $this->Superadminmodal->getPaymentDetails($cycleID);

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
        $this->load->view("company", $data);
    }

    function datatable_driverCompletedBookingList($driverID = '', $cycleID = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_driverCompletedBookingList($driverID, $cycleID);
    }

    public function referralEarningList($cycleID = '', $driverID = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['pagename'] = "paymentCycle/driverEarningList";
        $data['driverID'] = $driverID;
        $data['cycleID'] = $cycleID;
        $data['driverDetail'] = $this->Superadminmodal->getDriver($driverID);
        $appConfig = $this->Superadminmodal->getAppConfigOne();
        $data['paymentCycleDetails'] = $this->Superadminmodal->getPaymentDetails($cycleID);

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
        $this->load->view("company", $data);
    }

    function datatable_referralEarningList($driverID = '', $cycleID = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_referralEarningList($driverID, $cycleID);
    }

    public function licenceplaetno() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        return $this->Superadminmodal->licenceplaetno();
    }

    public function accounting() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['appConfig'] = $appConfig = $this->Superadminmodal->getAppConfigOne();
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
        $this->table->set_heading('ORDER ID','ORDER TYPE & BUSINESS TYPE', 'ORDER DATE & TIME', 'CITY','DRIVER NAME', 'CUSTOMER NAME','STORE NAME', 'APP EARNINGS', 'PAYMENT GATEWAY EARNINGS', 'DRIVER EARNINGS', 'STORE EARNINGS','DISCOUNT','TOTAL AMOUNT', 'PAYMENT METHOD', 'ORDER STATUS', 'INVOICE');
        $this->load->view("company", $data);
    }

    function updateBookingDetails($order_id = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->updateBookingDetails($order_id);
        redirect(base_url() . 'index.php?/superadmin/tripDetails/' . $order_id);
    }

    function getOrderDetails() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getOrderDetails();
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
        $this->load->view("company", $data);
    }

    public function dt_customerVerification() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->dt_customerVerification();
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
        $this->load->view("company", $data);
    }

    public function dt_driverVerification() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->dt_driverVerification();
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
        $this->load->view("company", $data);
    }

    public function DriverRechargeStatement($id) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['driverId'] = $id;
        $data['driverinfo'] = $this->Superadminmodal->GetDriverDetils($id);
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
        $this->load->view("company", $data);
    }

    public function DriverRechargeStatement_ajax($param) {
        $this->Superadminmodal->DriverRechargeStatement($param);
    }

    public function Recharge($id) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['driverId'] = $id;
        $data['driverinfo'] = $this->Superadminmodal->GetDriverDetils($id);
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
        $this->load->view("company", $data);
    }

    public function DriverRechargeDetails_ajax($param) {

        $this->Superadminmodal->DriverRechargeDetails($param);
    }

    public function RechargeOperation($for, $id, $masid = '') {

        $data = $this->Superadminmodal->RechargeOperation($for, $id, $masid);
        if ($data == 44)
            redirect(base_url() . "index.php?/superadmin/Recharge/" . $masid);
    }

    public function GetRechargedata_ajax($param) {

        $this->Superadminmodal->GetRechargedata_ajax();
    }

    // end driver wallet
    //* my controllers name is naveena *//


    public function showAvailableCities() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data = $this->Superadminmodal->loadAvailableCity();
        echo json_encode($data);
    }

    public function validateCompanyEmail() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        return $this->Superadminmodal->validateCompanyEmail();
    }

    function dt_passenger($status) {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->dt_passenger($status);
    }

    public function editdispatchers_city() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['editingcity'] = $this->Superadminmodal->editdispatchers_city();
    }

    public function datatable_cities() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_cities();
    }

    public function datatable_operator($status) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_operator($status);
    }

    public function datatable_vehicletype() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_vehicletype();
    }

    public function datatable_vehicles($status) {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_vehicles($status);
    }

    public function datatable_driver($status) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_driver($status);
    }

    public function datatable_dispatcher($status) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_dispatcher($status);
    }

    public function datatable_document($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_document($status);
    }

    public function datatable_driverreview($status) {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_driverreview($status);
    }

    public function datatable_bookings($status) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_bookings($status);
    }

    public function datatable_compaigns($status) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_compaigns($status);
    }

    public function datatable_promodetails($id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_promodetails($id);
    }

    public function get_appointmentDetials() {
        $this->Superadminmodal->get_appointmentDetials();
    }

    public function CompleteBooking() {
        $this->Superadminmodal->CompleteBooking();
    }

    public function cancelBooking() {
        $this->Superadminmodal->cancelBooking();
    }

    public function cities() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }


        $this->load->library('Datatables');
        $this->load->library('table');
        $data['cities'] = $this->Superadminmodal->cityForZones();

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


        $this->table->set_heading('SL NO.', 'CITY', 'COUNTRY', 'SELECT');

        $data['pagename'] = "cities";


        $this->load->view("company", $data);
    }

    public function long_haul_zone() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $appConfig = $this->Superadminmodal->getAppConfigOne();

        if ($appConfig['pricing_model']['longHaul'] == 0) {

            $this->load->library('Datatables');
            $this->load->library('table');
            $data['cities'] = $this->Superadminmodal->cityForZones();

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
            $this->table->set_heading('SL NO.', 'COUNTRY', 'CITY', 'ZONAL PRICE');
            $data['pagename'] = "long_haul_zone";
        } else {
            $data['pagename'] = "longHaulDisabledPage";
        }


        $this->load->view("company", $data);
    }

    function long_haul_Pricing($param = '') {
        $data['ID'] = $param;
        $data['cities'] = $this->Superadminmodal->getCities_zone();
        $data['citySpecific'] = $this->Superadminmodal->getSpecificCities_zone($param);
        $data['appConfig'] = $this->Superadminmodal->getAppConfigOne();
        $data['vehicleTypes'] = $this->Superadminmodal->getVehicleTypes();
        $data['pagename'] = "long_haul_zonePricing";
        $this->load->view("company", $data);
    }

    function long_haul_pricing_set($param = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->long_haul_pricing_set($param);

        redirect(base_url() . "index.php?/superadmin/long_haul_Pricing/" . $param);
    }

    function short_haul_pricing_set($param = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->short_haul_pricing_set($param);

        redirect(base_url() . "index.php?/superadmin/zones");
    }

    public function datatable_long_haul_zone() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_long_haul_zone();
    }

    public function cityAdd() {

        $data = $this->Superadminmodal->cityAdd();
    }

    public function showcities() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->loadcity();
        echo json_encode($data);
    }

    public function logoutdriver() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->logoutdriver();
    }

    public function showcompanys() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->loadcompany();

        $this->session->set_userdata(array('city_id' => $this->input->post('city'), 'company_id' => '0'));

        $return = "<option value='0'>Select Opetaror ...</option><option value='0'>None</option>";

        foreach ($data as $city) {
            $return .= "<option value='" . $city['company_id'] . "'>" . $city['companyname'] . "</option>";
        }

        echo $return;
    }

    public function insertcities() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->insert_city_available();
        return;
    }

    public function editlonglat() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['edit'] = $this->Superadminmodal->editlonglat();
    }

    public function addingcountry() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        return $this->Superadminmodal->addcountry();
    }

    public function addingcity() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['addingc'] = $this->Superadminmodal->addcity();
    }

    public function addnewcity($status = "") {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;

        $data['country'] = $this->Superadminmodal->get_country();

        $data['pagename'] = 'addnewcity';

        $this->load->view("company", $data);
    }

    public function add_operator($status = "", $param = '', $param2 = '') {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['param'] = "";
        $data['citiesData'] = $this->Superadminmodal->getCityList();
        $data['status'] = $status;
        $data['param'] = "";
        $data['pagename'] = 'operator_add';
        $this->load->view("company", $data);
    }

    public function operating_zone() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['operating_zone'] = $this->Superadminmodal->getOperating_zone();
        $data['pagename'] = 'operating_zone';

        $this->load->view("company", $data);
    }

    public function getOperating_zones() {

        $this->Superadminmodal->getOperating_zones();
    }

    public function updateOperating_zones() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->updateOperating_zones();
    }

    public function activatecompany() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->activate_company();
    }

    public function delete_dispatcher() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['delete'] = $this->Superadminmodal->delete_dispatcher();
    }

    public function suspendcompany() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['suspend'] = $this->Superadminmodal->suspend_company();
    }

    public function deactivatecompany() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['deactivate'] = $this->Superadminmodal->deactivate_company();
    }

    public function insertcompany() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->insert_company();
        redirect(base_url() . "index.php?/superadmin/operators/1");
    }

    public function updatecompany() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->update_company();
    }

    public function operators($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['citiesData'] = $this->Superadminmodal->getCityList();

        $this->load->library('Datatables');
        $this->load->library('table');

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

        $this->table->set_heading('SL NO.', 'CITY ', 'OPERATOR NAME', 'OPERATOR TYPE', 'VEHICLES', 'DRIVERS', 'ADDRESS', 'POST CODE', 'EMAIL', 'MOBILE', 'SELECT');

        $data['pagename'] = "operators";
        $this->load->view("company", $data);
//        $this->load->view("cities");
    }

    public function vehicletype_reordering() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->vehicletype_reordering();
    }

    public function active_deactiveCity($param = '') {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        if ($param == '1')
            $this->Superadminmodal->dectivateCity();
        else
            $this->Superadminmodal->activateCity();
    }

    public function testpush() {
        $this->Superadminmodal->testpush();
    }

    public function vehicle_type() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['appConfigData'] = $this->Superadminmodal->getAppConfigOne();

        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:12px"role="row">',
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
        $this->table->set_heading('TYPE ID', 'VEHICLE TYPE NAME', 'VEHICLE DETAILS', 'PRICING', 'IMAGES', 'DESCRIPTION', 'ORDER', 'SELECT');

        $data['pagename'] = "vehicle_type";
        $this->load->view("company", $data);
//        $this->load->view("cities");
    }

    public function uploadVehicleTypeImage() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->uploadVehicleTypeImage();
        redirect(base_url() . "index.php?/superadmin/vehicle_type");
    }

    public function delete_vehicletype() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['delete'] = $this->Superadminmodal->delete_vehicletype();
    }

    public function activate_vehicle() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->activate_vehicle();
    }

    Public function reject_vehicle() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->reject_vehicle();
    }

    Public function checkeDriverIsOnTrip() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->checkeDriverIsOnTrip();
    }

    public function refered($code = '', $refCode = '', $page = 1) {

        $data['refered'] = $this->Superadminmodal->refered($code, $refCode, $page);
//        print_r($data);
//        exit();

        $data['coupon_id'] = $code;

        $data['pagename'] = "refered";

        $this->load->view("company", $data);
    }

    public function inactivedriver_review() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['driver_review'] = $this->Superadminmodal->inactivedriver_review();
    }

    //Delete Passenger
    public function deletepassengers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->deletepassengers();
    }

    public function activedriver_review() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['driver_review'] = $this->Superadminmodal->activedriver_review();
    }

    public function vehicletype_addedit($status = '', $param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }


        $data['param'] = "";
        $data['operation'] = $status;
        $data['speciality_data'] = $this->Superadminmodal->getSpecialityData();
//         $data['appConfig'] = $this->Superadminmodal->getAppConfig();
        if ($status == 'edit') {
            $data['appConfigData'] = $this->Superadminmodal->getAppConfigOne();
            $data['mongoData'] = $this->Superadminmodal->getMongoVehicleType($param);

            $data['status'] = $status;
            $data['param'] = $param;
            $data['pagename'] = "vehicletype_edit";
        } elseif ($status == 'add') {
            $data['appConfigData'] = $this->Superadminmodal->getAppConfig();
            $data['status'] = $status;
            $data['param'] = "";
            $data['pagename'] = "vehicletype_add";
        }
        $this->load->view("company", $data);
    }

    public function editvehicle($status = '', $editFrom = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $return['speciality_data'] = $this->Superadminmodal->getSpecialityData();
        $return['Operators'] = $this->Superadminmodal->getOperators();
        $return['store'] = $this->Superadminmodal->getStores();
        $return['vehicleTypes'] = $this->Superadminmodal->vehicleTypeData();
        $return['vehiclemake'] = $this->Superadminmodal->get_vehiclemake();
        $return['vehicleData'] = $this->Superadminmodal->editvehicle($status);

        $return['modalData'] = $this->Superadminmodal->getModel($return['vehicleData']['modelId']['$oid']);


        if ($return['vehicleData']['mas_id'] != '' && $return['vehicleData']['mas_id'] != '0')
            $return['driversList'] = $this->Superadminmodal->getDriverList();

        $return['goodTypes'] = $this->Superadminmodal->getAllGoodTypes();

        $return['vehId'] = $status;

        switch ($editFrom) {
            case '':$return['pagename'] = "editvehicle";
                break;
            case 1:$return['pagename'] = "editvehicleForDriver";
                break;
        }

        $this->load->view("company", $return);
    }

    public function insert_vehicletype() {

        $data = $this->Superadminmodal->insert_vehicletype();
        redirect(base_url() . "index.php?/superadmin/vehicle_type");
    }

    public function update_vehicletype($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['updatevehicletype'] = $this->Superadminmodal->update_vehicletype($param);
        redirect(base_url() . "index.php?/superadmin/vehicle_type");
    }

    public function inactivedispatchers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->inactivedispatchers();
    }

    public function activedispatchers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->activedispatchers();
    }

    public function deletedispatchers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->deletedispatchers();
    }

    public function editdispatchers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data = $this->Superadminmodal->editdispatchers();
    }

    public function getManager() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data = $this->Superadminmodal->getManager();
        echo json_encode(array('data' => $data));
    }

    public function insertdispatches() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->insertdispatches();
    }

    public function editpass() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->editpass();
    }

    public function editdriverpassword() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->editdriverpassword();
    }

    public function editsuperpassword() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->editsuperpassword();
    }

    public function customers($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['status'] = $status;
        $data['appCofig'] = $this->Superadminmodal->getAppConfigOne();

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
        $this->table->set_heading('ACCOUNT TYPE', 'NAME', 'MOBILE', 'EMAIL', 'REFERRAL CODE', 'AVERAGE RATING', 'CREDIT LINES', 'CREDIT SETTINGS', 'DISPATCHERS', 'REGISTRATION DATE', 'PROFILE IMAGE', 'SELECT');

        $data['pagename'] = "passengers";
        $this->load->view("company", $data);
    }

    public function customerRate($ID = '') {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');

        $data['ID'] = $ID;
        $data['customerData'] = $this->Superadminmodal->getCustomerData($ID);

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

        $this->table->set_heading('BOOKING ID', 'BOOKING DATE AND TIME', 'DRIVER NAME', 'RATING');

        $data['pagename'] = 'customerRateForIndividual';
        $this->load->view("company", $data);
    }

    public function datatable_customerRateForIndividual($ID = '', $stDate = '', $endDate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_customerRateForIndividual($ID, $stDate, $endDate);
    }

    public function walletUpdateForShipper() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['result'] = $this->Superadminmodal->walletUpdateForShipper();
    }

    public function walletUpdateForDriver() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['result'] = $this->Superadminmodal->walletUpdateForDriver();
    }

    public function getWalletForShipper() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['result'] = $this->Superadminmodal->getWalletForShipper();
    }

    public function getWalletForDriver() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['result'] = $this->Superadminmodal->getWallet();
    }

    public function rejectCustomers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['result'] = $this->Superadminmodal->rejectCustomers();
    }

    public function acceptdrivers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        

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
            $data['result'] = $this->Superadminmodal->acceptdrivers($id, 
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

    public function enDisCreditCustomer() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->enDisCreditCustomer();
    }

    public function enDisCreditDriver() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->enDisCreditDriver();
    }

    //Manually logout the driver from admin panel
    public function driver_logout() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

         $this->Superadminmodal->driver_logout();
    }
    public function makeDriverOffline() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

         $this->Superadminmodal->makeDriverOffline();
    }

    public function getAllUsersForPlan() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['result'] = $this->Superadminmodal->getAllUsersForPlan();
    }

    public function getdrivervehicle() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['result'] = $this->Superadminmodal->getdrivervehicle();
    }

    public function banDrivers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->banDrivers();
    }

    public function rejectdrivers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->rejectdrivers();
    }

    public function activepassengers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['inactive'] = $this->Superadminmodal->activepassengers();
    }

    public function getCitiesList() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getCitiesList();
    }

    //////////////////
    public function customerDispatch($param = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['custID'] = $param;
        $data['customerName'] = $this->Superadminmodal->getCustomerName($param);
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
        $this->table->set_heading('DISPATCHER ID', 'NAME', 'EMAIL', 'LAST LOGIN DATE', 'STATUS', 'SELECT');

        $data['pagename'] = "customerDispatcher";
        $this->load->view("company", $data);
    }

    function PushTest() {
        $data['pagename'] = "sendNotification";
        $this->load->view("company", $data);
    }

    function dt_customerDispatch($id = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->dt_customerDispatch($id);
    }

    function resetpassDispatch() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->resetpassDispatch();
    }

    public function banDispatch() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->banDispatch();
    }

    public function activeDispatch() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->activeDispatch();
    }

    public function deleteDispatch() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->deleteDispatch();
    }

    public function insertDispatch() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->insertDispatch();
    }

    public function insertpass() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['pass'] = $this->Superadminmodal->insertpass();
//        print_r($res);
    }

    public function Vehicles($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
//        $data['company'] = $this->Superadminmodal->company_data();
//        $data['vehicles'] = $this->Superadminmodal->Vehicles($status);


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

//        $this->table->set_heading('VEHICLE MAKE', 'VEHICLE MODEL', 'VEHICLE TYPE', 'OWNERSHIP TYPE', 'DRIVER NAME', 'DRIVER PHONE', 'OPERATOR NAME', 'LICENCE PLATE NUMBER', 'SELECT');
        $this->table->set_heading('PLATE NO.', 'MAKE', 'MODEL', 'DRIVER NAME', 'PHONE', 'LAST UPDATED LOCATION', 'LOGGED IN ON', 'OWNERSHIP TYPE','Operator Name / Store Name', 'SELECT');


        $data['pagename'] = 'vehicles';
        $data['status'] = $status;
        $this->load->view("company", $data);
    }

    public function showDriverVehicles($Id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');

        $masDetails = $this->Superadminmodal->editdriver($Id); //Just get the drivers name

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

        $this->table->set_heading('VEHICLE MAKE', 'VEHICLE MODEL', 'VEHICLE TYPE', 'LICENCE PLATE NUMBER', 'STATUS', 'SELECT');


        $data['pagename'] = 'driverVehicles';
        $data['id'] = $Id;
        $data['Name'] = $masDetails['firstName'] . ' ' . $masDetails['lastName'];
        $this->load->view("company", $data);
    }

    public function datatable_showDriverVehicles($id = '', $status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_showDriverVehicles($id, $status);
    }

    public function app_config() {
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('appconfig_lang', $language);
      //  $this->lang->load('topnav_lang', $language);

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['appConfigData'] = $this->Superadminmodal->getAppConfig();
        $data['shiftBufferTimings']=$data['appConfigData'][0]['shiftBufferTimings'];
        $data['pagename'] = 'app_confi';
        $this->load->view("company", $data);
    }

    public function gettermsAndConditions_ajax() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->readTermsAndConditions();
    }

    public function getAppConfig_ajax() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getAppConfig_ajax();
    }

    public function updateAppConfigNew() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->updateAppConfigNew();
        redirect(base_url() . "index.php?/superadmin/app_config");
    }

    public function specialities() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:12px"role="row">',
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
        $this->table->set_heading('SL.NO', 'GOOD TYPES', 'SELECT');

        $data['pagename'] = "specialies";
        $this->load->view("company", $data);
//        $this->load->view("cities");
    }

    public function getplandata() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getplandata();
    }

    public function driverPlans() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['appCofig'] = $this->Superadminmodal->getAppConfigOne();
        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:12px"role="row">',
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
        $data['status']=1;
      //  $this->table->set_heading('SL.NO','CITY', 'PLAN NAME', 'DESCRIPTION','APP COMMISSON TYPE' ,'APP COMMISSION ( % / fixed )', 'ACTION', 'SELECT');
      $checkbox=' <input type="checkbox" id="select_all" />';
      $this->table->set_heading('SL.NO','CITY', 'PLAN NAME', 'DESCRIPTION','APP COMMISSON TYPE' ,'APP COMMISSION ( % / fixed )', 'ACTION',$checkbox );
        $data['cities'] = $this->Superadminmodal->cityForZones();
        $data['pagename'] = "plans";
        $this->load->view("company", $data);
//        $this->load->view("cities");
    }

   

    public function datatable_driverPlans($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_driverPlans($status);
    }

    

    public function addPlans($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->addPlans($param);
    }

  
    public function updatePlans() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->updatePlans();
    }
    public function cityForZonesData() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->cityForZonesData();
    }

    public function getplans() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getPlans();
    }

    

    public function deletePlans() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->deletePlans();
    }
    public function getStoreDataBasedOnCity() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getStoreDataBasedOnCity();
    }
    public function getZonesBasedOnStores() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getZonesBasedOnStores();
    }

  

//    public function datatable_drivers($for = '', $status = '',$driverType = '',$operator = '') {
//       
//        if ($this->session->userdata('table') != 'company_info') {
//            $this->Logout();
//        }
//        $data = $this->Superadminmodal->datatable_drivers($for, $status,$driverType,$operator);
//    }
    public function datatable_drivers($for = '', $status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        // $id=$this->session->userdata('plan');
        // echo '<pre>';print_r($id);die;
        $data = $this->Superadminmodal->datatable_drivers($for, $status);
    }
    public function datatable_storedrivers($for = '', $status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->datatable_storedrivers($for, $status);
    }


    public function driverRate($ID = '') {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');

        $data['ID'] = $ID;
        $data['driverData'] = $this->Superadminmodal->editdriver($ID);

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

        $this->table->set_heading('BOOKING ID', 'BOOKING DATE AND TIME', 'CUSTOMER NAME', 'REVIEW', 'RATING');

        $data['pagename'] = 'driverRateForIndividual';
        $this->load->view("company", $data);
    }

    public function datatable_driverRateForIndividual($ID = '', $stDate = '', $endDate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_driverRateForIndividual($ID, $stDate, $endDate);
    }

    public function Drivers($for = '', $status = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');

        $data['Operators'] = $this->Superadminmodal->getOperators();
        $data['appCofig'] = $this->Superadminmodal->getAppConfigOne();
        
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
            

        //$this->table->set_heading('DRIVER TYPE', 'APP VERSION', 'DRIVER NAME', 'CITY','EMAIL','MOBILE NUMBER', 'STORE','PLAN NAME', 'REFERRAL CODE', 'RENEWAL DATE', 'AVERAGE RATING', 'CREDIT LINE', 'WALLET (SET LIMIT)', 'REJECTED ON', 'REGISTERED ON', 'ONLINE STATUS','LAST UPDATED LOCATION', 'SHIFT LOGS','REASON', 'BANNED ON','ACTION','SELECT');
        $checkbox=' <input type="checkbox" id="select_all" />';
        $this->table->set_heading('DRIVER TYPE', 'APP VERSION', 'DRIVER NAME', 'CITY','EMAIL','MOBILE NUMBER', 'STORE','PLAN NAME', 'REFERRAL CODE', 'RENEWAL DATE', 'AVERAGE RATING', 'CREDIT LINE', 'WALLET (SET LIMIT)', 'REJECTED ON', 'REGISTERED ON', 'ONLINE STATUS','LAST UPDATED LOCATION', 'SHIFT LOGS','REASON', 'BANNED ON','ACTION', 'CREDIT LINE',$checkbox);


        $data['pagename'] = 'drivers_1';
        $this->load->view("company", $data);
    }
 public function storeDrivers($for = '', $status = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');

        $data['Operators'] = $this->Superadminmodal->getOperators();
        $data['appCofig'] = $this->Superadminmodal->getAppConfigOne();
        
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
            

        //$this->table->set_heading('DRIVER TYPE', 'APP VERSION', 'DRIVER NAME', 'CITY','EMAIL','MOBILE NUMBER', 'STORE','PLAN NAME', 'REFERRAL CODE', 'RENEWAL DATE', 'AVERAGE RATING', 'CREDIT LINE', 'WALLET (SET LIMIT)', 'REJECTED ON', 'REGISTERED ON', 'ONLINE STATUS','LAST UPDATED LOCATION', 'SHIFT LOGS','REASON', 'BANNED ON','ACTION','SELECT');
        $checkbox=' <input type="checkbox" id="select_all" />';
        $this->table->set_heading('DRIVER TYPE', 'APP VERSION', 'DRIVER NAME', 'CITY','EMAIL','MOBILE NUMBER', 'STORE','PLAN NAME', 'REFERRAL CODE', 'RENEWAL DATE', 'AVERAGE RATING', 'CREDIT LINE', 'WALLET (SET LIMIT)', 'REJECTED ON', 'REGISTERED ON', 'ONLINE STATUS','LAST UPDATED LOCATION', 'SHIFT LOGS','REASON', 'BANNED ON','ACTION', $checkbox);


        $data['pagename'] = 'storeDrivers/storeDrivers';
        $this->load->view("company", $data);
    }

  

    public function getDriversCount() {
        $this->Superadminmodal->getDriversCount();
    }
    public function getDriversCountForStore() {
        $this->Superadminmodal->getDriversCountForStore();
    }

  
    public function getDeviceLogs($userType = '') {
        $this->Superadminmodal->getDeviceLogs($userType);
    }

    public function addnewdriver() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['appCofig'] = $this->Superadminmodal->getAppConfigOne();
        $data['cities'] = $this->Superadminmodal->cityForZones();
//        $data['cityForZones'] = $this->Superadminmodal->cityForZones();
        $data['cityForZonesData'] = $this->Superadminmodal->cityForZonesData();
        $data['Operators'] = $this->Superadminmodal->getOperators();
        $data['store'] = $this->Superadminmodal->getStores();
        $data['plans'] = $this->Superadminmodal->getAllPlansForDrivers();
        $data['boxtype']=$this->ProductsModel->getboxtype();
        

        $data['pagename'] = 'addnewdriver';

        $this->load->view("company", $data);
    }
	
	 public function addnewstoredriver() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['appCofig'] = $this->Superadminmodal->getAppConfigOne();
        $data['cities'] = $this->Superadminmodal->cityForZones();
//        $data['cityForZones'] = $this->Superadminmodal->cityForZones();
        $data['cityForZonesData'] = $this->Superadminmodal->cityForZonesData();
    
        $data['store'] = $this->Superadminmodal->getStores();
       

        $data['pagename'] = 'storeDrivers/addNewStoreDriver';

        $this->load->view("company", $data);
    }

    public function editdriver($id = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $return['data'] = $this->Superadminmodal->editdriver($id);
        // $return['data']['currency']=$this->Superadminmodal->getCurrencyforCity($return['data']['cityId']);
        $return['appCofig'] = $this->Superadminmodal->getAppConfigOne();
        $return['cityForZones'] = $this->Superadminmodal->cityForZones();
        $return['cityForZonesData'] = $this->Superadminmodal->cityForZonesData($id);
        $return['Operators'] = $this->Superadminmodal->getOperators();
        $return['store'] = $this->Superadminmodal->getStores();
        $return['boxtype']=$this->ProductsModel->getboxtype();
        $return['driverid'] = $id;
        $return['pagename'] = 'editdriver';
        $this->load->view("company", $return);
    }
    public function editStoreDriver($id = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $return['data'] = $this->Superadminmodal->editdriver($id);
        $return['appCofig'] = $this->Superadminmodal->getAppConfigOne();
        $return['cityForZones'] = $this->Superadminmodal->cityForZones();
        $return['cityForZonesData'] = $this->Superadminmodal->cityForZonesData();
        $return['Operators'] = $this->Superadminmodal->getOperators();
        $return['store'] = $this->Superadminmodal->getStores();

        $return['driverid'] = $id;

        $return['pagename'] = 'storeDrivers/editStoreDriver';

        $this->load->view("company", $return);
    }

   

    public function transection_data_ajax($paymentType = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->getTransectionData($paymentType);
    }

    public function transection_data_form_date($stdate = '', $enddate = '', $paymentType = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->transection_data_form_date($stdate, $enddate, $paymentType);
    }

    public function exportAccData($stdate = '', $enddate = '',$city='',$store='') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data = $this->Superadminmodal->exportAccData($stdate, $enddate,$city,$store);

        // file name for download
        $fileName = "Accouting" . date('Ymd') . ".xls";
        $file_name = $fileName = "Accouting" . time() . ".xls";          
        $this->load->library('excel');       
        $this->excel->setActiveSheetIndex(0);
        $this->excel->stream($file_name, $data);
        // // headers for download
        // header("Content-Disposition: attachment; filename=\"$fileName\"");
        // header("Content-Type: application/vnd.ms-excel");

        // $flag = false;
        // foreach ($data as $row) {
        //     if (!$flag) {
        //         // display column names as first row
        //         echo implode("\t", array_keys($row)) . "\n";
        //         $flag = true;
        //     }
        //     // filter data
        //     array_walk($row, 'filterData');
        //     echo implode("\t", array_values($row)) . "\n";
        // }
    }

    public function exportPaymentCycle($cylecID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data = $this->Superadminmodal->exportPaymentCycle($cylecID);

        // file name for download
        $fileName = "PaymentCycle" . date('Ymd') . ".xls";

        // headers for download
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Type: application/vnd.ms-excel");

        $flag = false;
        foreach ($data as $row) {
            if (!$flag) {
                // display column names as first row
                echo implode("\t", array_keys($row)) . "\n";
                $flag = true;
            }
            // filter data
            array_walk($row, 'filterData');
            echo implode("\t", array_values($row)) . "\n";
        }
    }

    public function allBookingsDataExport($stdate = '', $enddate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }



        $this->excel->setActiveSheetIndex(0);
        $data = $this->Superadminmodal->allBookingsDataExport($stdate, $enddate);

//        print_r( array (new ArrayObject (array ('name'=> 'ashish','call' => '123') )) );
        $this->excel->stream('Transaction.xls', $data);
    }

    public function getAllPlans() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getAllPlans();
    }

    public function updateNewPlan() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->updateNewPlan();
    }

    public function deleteDrivers() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->deletedriver();
    }

    public function callExel_payroll() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $value = $this->adminmodel->payroll();
        $slno = 1;
        foreach ($value as $result) {
            $data[] = array(
                'slno' => $slno,
                'Driver_Id' => $result->mas_id,
                'Driver_Name' => $result->first_name,
                'Today_earning' => $result->today_earnings,
                'Week_earning' => $result->week_earnings,
                'Month_earning' => $result->month_earnings,
                'Total_earning' => $result->total_earnings,
            );
            $slno++;
        }

//        print_r( array (new ArrayObject (array ('name'=> 'ashish','call' => '123') )) );
        $this->excel->stream('Transaction.xls', $data);
    }

    public function bookings($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['appConfig'] = $this->Superadminmodal->getAppConfigOne();

        $data['pagename'] = "bookings";
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
$this->table->set_heading('Order ID', 'Booking Type', 'Order Type', 'Booking Date','Customer Name', 'Store Name', 'Driver Name', 'Pickup Address', 'Delivery Address', 'Order Value', 'Delivery Fee', 'Payment Type','Status');
//        $this->table->set_heading('BOOKING ID', 'ESTIMATE ID', 'DRIVER NAME', 'CUSTOMER NAME', 'PICKUP', 'PICKUP DATE&TIME', 'DROP AT', 'DISPATCHED BY', 'PRICING MODEL & TRIP TYPE', 'STATUS', 'TRIP');
//        $this->table->set_heading('BOOKING ID', 'DRIVER ID', 'DRIVER NAME', 'PASSENGER NAME', 'PICKUP ADDRESS',  'PICKUP TIME & DATE','STATUS');

        $this->load->view("company", $data);
    }

    public function bookings_data_ajax($status = '', $stDate = '', $endDate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getbooking_data($status, $stDate, $endDate);
    }

    public function getBookingHistory() {
        $this->Superadminmodal->getBookingHistory();
    }

    public function getDriversReferralsList() {
        $this->Superadminmodal->getDriversReferralsList();
    }

    public function getCustomerReferralsList() {
        $this->Superadminmodal->getCustomerReferralsList();
    }

    public function getDriverDetails() {
        $this->Superadminmodal->getDriverDetails();
    }

    public function getAllDriversDetails() {
        $this->Superadminmodal->getAllDriversDetails();
    }

  

    public function getReferralDetails() {
        $this->Superadminmodal->getReferralDetails();
    }

    public function RediousPrice() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }


        $this->load->library('Datatables');
        $this->load->library('table');
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;font-size:10px">',
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

        $this->table->set_heading('SL NO.', 'CITY (' . currency . ')', 'FROM (' . currency . ')', 'TO (' . currency . ')', 'COMMISSION %', 'ACTIONS');



        $data['pagename'] = "RediousPrice";
        $this->load->view("company", $data);
    }

    public function datatable_RediousPrice() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->getRediousPrice();
    }

    public function getZoneCity() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getZoneCity();
    }

    public function getCityZones() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getCityZones();
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
        $this->Superadminmodal->addRediousPrice($from_, $to_, $price, $cityid);
//        $data['pagename'] = "RediousPrice";
//        $this->load->view("company", $data);
    }

    public function editRediousPrice() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $mid = $this->input->post('mid');
        $status = $this->input->post('status');
        if ($status == 'del') {
            $this->Superadminmodal->DeleteRediousPrice($mid);
        } else {
            $from_ = $this->input->post('from');
            $to_ = $this->input->post('to');
            $price = $this->input->post('price');
            $cityid = $this->input->post('cityid');

//        $data['rediousPrices'] =
            $this->Superadminmodal->editRediousPrice($from_, $to_, $price, $mid, $cityid);
        }
//        $data['pagename'] = "RediousPrice";
//        $this->load->view("company", $data);
    }

    public function dispatched($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['city'] = $this->Superadminmodal->city_get();
        $data['getdata'] = $this->Superadminmodal->get_dispatchers_data($status);

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

        $this->table->set_heading('DISPATCHER NAME','MANAGER','CITY', 'USERNAME', 'STATUS', 'CURRENT IP ADDRESS', 'OPTION');




        $data['pagename'] = "dispatched";

        $this->load->view("company", $data);
    }

    public function finance($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['pagename'] = "finance";
        $this->load->view("company", $data);
    }

    public function joblogs($value = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['value'] = $value;
        $data['joblogs'] = $this->Superadminmodal->get_joblogsdata($value);
//        
//        print_r($data);
//        exit();
        $data['pagename'] = "joblogs";
        $this->load->view("company", $data);
    }

    public function sessiondetails($value = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['value'] = $value;
        $data['session_details'] = $this->Superadminmodal->get_sessiondetails($value);

        $data['pagename'] = "sessiondetails";
        $this->load->view("company", $data);
    }

    public function document($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['status'] = $status;

        $data['master'] = $this->Superadminmodal->driver();

        $data['document_data'] = $this->Superadminmodal->get_documentdata($status);

        $data['workname'] = $this->Superadminmodal->get_workplace();


        $data['pagename'] = "document";
        $this->load->view("company", $data);
    }

    public function passenger_rating() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['passenger_rating'] = $this->Superadminmodal->passenger_rating();



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

        $this->table->set_heading('PASSENGER ID', 'PASSENGER NAME', 'PASSENGER EMAIL', 'AVG RATING');


        $data['pagename'] = "passenger_rating";
        $this->load->view("company", $data);
    }

    public function datatable_passengerrating() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_passengerrating();
    }

    public function getmap_values() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->getmap_values();
    }

    public function driver_review($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['driver_review'] = $this->Superadminmodal->driver_review($status);

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

        $this->table->set_heading('BOOKING ID', 'BOOKING DATE AND TIME', 'DRIVER NAME', 'CUSTOMER NAME', 'REVIEW', 'RATING');


        $data['pagename'] = "driver_review";
        $this->load->view("company", $data);
    }

    public function driverRating() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['appConfig'] = $this->Superadminmodal->getAppConfigOne();
        $data['pagename'] = "driverRatingNew";
        $this->load->view("company", $data);
    }

    public function updateDriverRating() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->updateDriverRating();
        redirect(base_url() . "index.php?/superadmin/driverRating");
    }

    public function disputes($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['city'] = $this->Superadminmodal->get_city();
        $data['disputesdata'] = $this->Superadminmodal->get_disputesdata($status);
        $data['master'] = $this->Superadminmodal->driver();
        $data['slave'] = $this->Superadminmodal->passenger();



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
        $this->load->view("company", $data);
    }

    public function datatable_disputes($status) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_disputes($status);
    }

    public function documentgetdata() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        echo json_encode($this->Superadminmodal->documentgetdata());
        exit();
    }

    public function documentgetdatavehicles() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->documentgetdatavehicles();
    }

    public function resolvedisputes() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->resolvedisputes();
    }

    public function delete() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['getvehicletype'] = $this->Superadminmodal->get_vehivletype();
        $data['getcompany'] = $this->Superadminmodal->get_company();
        $data['city_ram'] = $this->Superadminmodal->city_sorted();
        $data['driver'] = $this->Superadminmodal->get_driver();
        $data['vehiclemodal'] = $this->Superadminmodal->vehiclemodal();
        $data['country'] = $this->Superadminmodal->get_country();
//          print_r($data['getvehicletype']);


        $data['pagename'] = "delete";

        $this->load->view("company", $data);
    }

    public function deactivecompaigns() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['deactivate'] = $this->Superadminmodal->deactivecompaigns();
    }

    public function deletetype() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->deletetype();
    }

    public function godsview() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['pagename'] = "godsview";
        $data['cities'] = $this->Superadminmodal->get_cities();
        $this->load->view("company", $data);
    }

    public function getDtiverDetail() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getDtiverDetail();
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
        $data['vehiclemake'] = $this->Superadminmodal->get_vehiclemake();

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
        $this->load->view("company", $data);
    }

    function datatable_vehiclemodels($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        if ($status == 1) {
            $this->Superadminmodal->datatable_vehicleMake();
        } else if ($status == 2) {
            $this->Superadminmodal->datatable_vehicleModel();
        }
    }

    public function testID() {

        $this->Superadminmodal->testID();
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
            $this->Superadminmodal->addVehicleMake();
        else if ($param == 'edit')
            $this->Superadminmodal->editVehicleMake();
        else
            $this->Superadminmodal->deleteVehicleMake();
    }

    //Add/Edit Vehicle make
    public function addEditVehicleModel($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        if ($param == 'add')
            $this->Superadminmodal->addVehicleModel();
        else if ($param == 'edit')
            $this->Superadminmodal->editVehicleModel();
        else
            $this->Superadminmodal->deleteVehicleModel();
    }

    public function getComapnyDetails() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data = $this->Superadminmodal->getComapnyDetails();
    }

    public function insertmodal() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->insert_modal();
    }

    public function deletevehicletype() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->deletevehicletype();
    }

    public function delete_company() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->delete_company();
    }

    public function deletevehiclemodal() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->deletevehiclemodal();
    }

    public function deletevehicletypemodel() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->deletevehicletypemodel();
    }

    public function forgotPasswordFromadmin() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->forgotPasswordFromadmin();
    }

    public function deletedriver() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->deletedriver();
    }

    public function deletemodal() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Superadminmodal->deletemodal();
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
        $this->load->view("company", $data);
    }

    public function referral_details($id = '', $page = 1) {

        $data['referral_details'] = $this->Superadminmodal->get_referral_details($id, $page);

        $data['coupon_id'] = $id;

        $data['pagename'] = "referral_details";

        $this->load->view("company", $data);
    }

    public function compaigns($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['city'] = $this->Superadminmodal->get_city();
        $data['compaign'] = $this->Superadminmodal->get_compaigns_data($status);

        $data['pagename'] = "compaigns";
        $this->load->view("company", $data);
    }

    public function compaigns_ajax($for = '', $status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->get_compaigns_data_ajax($for, $status);
    }

    public function insertcompaigns() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        echo $this->Superadminmodal->insertcampaigns();
    }

    public function updatecompaigns() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        echo $this->Superadminmodal->updatecompaigns();
    }

    public function editcompaigns() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->editcompaigns();
    }

    public function cancled_booking() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['pagename'] = "cancled_booking";
        $this->load->view("company", $data);
//        $this->load->view("cities");
    }

    public function Get_dataformdate($stdate = '', $enddate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
//        $data = $this->Superadminmodal->get_all_data();
        $data['transection_data'] = $this->Superadminmodal->getDatafromdate($stdate, $enddate);
        $data['stdate'] = $stdate;
        $data['enddate'] = $enddate;
        $data['gat_way'] = '2';
        $data['pagename'] = "Transection";
        $this->load->view("company", $data);
    }

    public function Get_dataformdate_for_all_bookingspg($stdate = '', $enddate = '', $status = '', $company_id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getDatafromdate_for_all_bookings($stdate, $enddate, $status, $company_id);
    }

    public function search_by_select($selectdval = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->getDataSelected($selectdval);
    }

    public function profile() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $sessionsetornot = $this->Superadminmodal->issessionset();
        if ($sessionsetornot) {
            $data['userinfo'] = $this->Superadminmodal->getuserinfo();
            $data['pagename'] = "profile";
            $this->load->view("company", $data);
        } else {
            redirect(base_url() . "index.php?/superadmin");
        }
    }

    public function services() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $sessionsetornot = $this->Superadminmodal->issessionset();
        if ($sessionsetornot) {

            $data['service'] = $this->Superadminmodal->getActiveservicedata();
            $data['pagename'] = "Addservice";
            $this->load->view("company", $data);
        } else {
            redirect(base_url() . "index.php?/superadmin");
        }
    }

    public function updateservices($tablename = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->updateservices($tablename);
        redirect(base_url() . "index.php?/superadmin/services");
    }

    function deleteservices($tablename = "") {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->deleteservices($tablename);
        redirect(base_url() . "index.php?/superadmin/services");
    }

    function Banking() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $sessionsetornot = $this->Superadminmodal->issessionset();
        if ($sessionsetornot) {

//            $data['service'] = $this->Superadminmodal->getActiveservicedata();
            $data['pagename'] = "banking";
            $this->load->view("company", $data);
        } else {
            redirect(base_url() . "index.php?/superadmin");
        }
    }

    public function addservices() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['service'] = $this->Superadminmodal->addservices();
        redirect(base_url() . "index.php?/superadmin/services");
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
            redirect(base_url() . "index.php?/superadmin");
        }
    }

    function Logout() {
        $this->session->sess_destroy();
        redirect(base_url() . "index.php?/superadmin");
    }

    function udpadedataProfile() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->updateDataProfile();

        if ($this->input->post('val')) {
            $filename = "demo.png";
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], base_url() . 'files/' . $filename)) {
                echo $filename;
            }
        }
        redirect(base_url() . "index.php?/superadmin/profile");
    }

    function udpadedata($IdToChange = '', $databasename = '', $db_field_id_name = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->madmin->updateData($IdToChange, $databasename, $db_field_id_name);
        redirect(base_url() . "index.php?/superadmin/profile");
    }

    public function updateMasterBank() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
//        return;
        $ret = $this->Superadminmodal->updateMasterBank();
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
        $this->load->view("company", $data);
    }

    public function payroll_ajax() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->payroll();
    }

    public function payroll_data_form_date($stdate = '', $enddate = '', $company_id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->payroll_data_form_date($stdate, $enddate, $company_id);
    }

    public function DriverDetails_form_Date($stdate = '', $enddate = '', $company_id = '', $mas_id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->DriverDetails_form_Date($stdate, $enddate, $company_id, $mas_id);
    }

    public function Driver_pay($id = '', $error = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['error_data_fromInvoice'] = $error['error'];

        $data['driverdata'] = $this->Superadminmodal->Driver_pay($id);
        $data['payrolldata'] = $this->Superadminmodal->get_payrolldata($id);
        $data['totalamountpaid'] = $this->Superadminmodal->Totalamountpaid($id);
        $data['mas_id'] = $id;
        $data['pagename'] = 'driverpayment';
        $this->load->view("company", $data);
    }

    public function pay_driver_amount($id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $error = $this->Superadminmodal->insert_payment($id);
//       print_r($error);
//       exit();
        redirect(base_url() . "index.php?/superadmin/Driver_pay/" . $id . '/' . $error);
    }

    public function validateEmail() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        return $this->Superadminmodal->validateEmail();
    }

    public function validateMobileNo() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        return $this->Superadminmodal->validateMobileNo();
    }
    public function validateMobileNoEditDriver() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        return $this->Superadminmodal->validateMobileNoEditDriver();
    }

    public function validatedispatchEmail() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        return $this->Superadminmodal->validatedispatchEmail();
    }

    public function shipment($param) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['ongoing_booking'] = $this->Superadminmodal->shipment($param);

        $data['pagename'] = 'shipment';
        $this->load->view("company", $data);
    }

    //Get the all On-Going jobs by filtered city
    public function filter_AllOnGoing_jobs() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->filter_AllOnGoing_jobs();
    }

    //Set the Table header/columns for On Going Jobs
    public function onGoing_jobs($status = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['appConfig'] = $this->Superadminmodal->getAppConfigOne();
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


//        $data['ongoing_booking'] = $this->Superadminmodal->get_ongoing_bookings();
        $data['pagename'] = 'onGoing_jobs';
        $this->load->view("company", $data);
    }

    public function estimateRequested($status = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['appConfig'] = $this->Superadminmodal->getAppConfigOne();
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
        $this->load->view("company", $data);
    }

    public function datatable_estimateRequested($stDate = '', $endDate = '') {
        $data = $this->Superadminmodal->datatable_estimateRequested($stDate, $endDate);
    }

    public function getBookingCount() {
        $data = $this->Superadminmodal->getBookingCount();
    }

    public function getOngoingBookingAjax() {
        $data = $this->Superadminmodal->get_ongoing_bookings();
        echo json_encode(array('data' => $data));
    }

    //Get the all Completed jobs by filtered city
    public function filter_Allcompleted_jobs() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->filter_Allcompleted_jobs();
    }

    //Get the All Coppleted Jobs
    public function datatable_completed_jobs($stDate = '', $endDate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_completed_jobs($stDate, $endDate);
    }

    //Set the Table header/columns for All Completed Jobs
    public function completed_jobs($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['status'] = $status;
        $data['appConfig'] = $this->Superadminmodal->getAppConfigOne();

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
        $this->load->view("company", $data);
    }

    public function cancelledBookings() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['appConfig'] = $this->Superadminmodal->getAppConfigOne();
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
        $this->load->view("company", $data);
    }

    public function datatable_cancelledBookings($stDate = '', $endDate = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_cancelledBookings($stDate, $endDate);
    }

    public function unassignedBookings() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['appConfig'] = $this->Superadminmodal->getAppConfigOne();

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
        $this->load->view("company", $data);
    }

    public function datatable_unassignedBookings() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_unassignedBookings();
    }

    public function expiredBookings() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['appConfig'] = $this->Superadminmodal->getAppConfigOne();

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
        $this->load->view("company", $data);
    }

    public function datatable_expiredBookings() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_expiredBookings();
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
        $this->load->view("company", $data);
    }

    public function datatable_bookingDispatchedList($orderID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->datatable_bookingDispatchedList($orderID);
    }

    //Shows the Each Job Details
    public function showJob_details($param) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $return['data'] = $this->Superadminmodal->tripDetails($param);

        $return['pagename'] = 'showJob_details';
        $this->load->view("company", $return);
    }

    public function AddNewDriverData() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $redirect = $this->Superadminmodal->AddNewDriverData();
        if($redirect == "stores"){
            redirect(base_url() . "index.php?/superadmin/storeDrivers/my/1");
        }else{
            redirect(base_url() . "index.php?/superadmin/Drivers/my/1");
        }
    }

    public function editdriverdata() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->editdriverdata();
        redirect(base_url() . "index.php?/superadmin/Drivers/my/1");
    }
	
	    public function editStoreDriverData() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->editStoreDriverData();
        redirect(base_url() . "index.php?/superadmin/storeDrivers/my/1");
    }

    public function AddNewVehicleData($fromAdding = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $selected_driver = $this->Superadminmodal->AddNewVehicleData();

        if ($fromAdding == 1)
            redirect(base_url() . "index.php?/superadmin/showDriverVehicles/" . $selected_driver);
        else
            redirect(base_url() . "index.php?/superadmin/Vehicles/1");
    }

    public function DriverDetails($mas_id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
//        $data['driverdetails'] = $this->Superadminmodal->DriverDetails($mas_id);
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

        $this->load->view("company", $data);
    }

    public function DriverDetails_ajax($mas_id = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->DriverDetails($mas_id);
    }

    public function editpassDispatcher() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->editpassDispatcher();
    }

    public function deletecities() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->deletecity();
    }

    public function testmon($email, $firstname) {

        $this->Superadminmodal->testmon($email, $firstname);
    }

    public function testMailGun() {

        $this->Superadminmodal->mailGunTest();
    }

    public function invoiceDetails($param) {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['invoiceDetails'] = $this->Superadminmodal->getInvoiceDetails($param);
//              print_r($data);exit();
        $this->load->view('Invoice', $data);
    }

    public function deleteVehicles() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->deleteVehicles();
    }

    public function ajax_call_to_get_types($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        //All freelancer drivers
        if ($param == 'vmodel') {
            $this->Superadminmodal->getVehicleModel();
        
        } else if ($param == 'freelanceDrivers') {
            $this->Superadminmodal->getfreelanceDrivers();
            
        }
    }

    public function getAllZones(){
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Superadminmodal->getAllZones();
         
    }

    public function getZonesByStoreId($param){
        $this->Superadminmodal->getZonesByStoreId($param);
    }
    public function getZonesByCity($param){
        $this->Superadminmodal->getZonesByCity($param);
    }

    // google key rotation
    function googleKeys() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

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
        $this->table->set_heading('SNO', 'KEY', 'TOTAL DISTANCE QUOTA', 'TOTAL PLACE QUOTA', 'TOTAL DIRECTION QUOTA', 'DISTANCE', 'PLACE', 'DIRECTION','ACCOUNT ID', 'ACTION');
        $data['pagename'] = 'googleKey';
        $this->load->view("company", $data);
    }

    function datatable_googleKey() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->datatable_googleKey();
    }

    function addEditGoogleKey($operation) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        switch ($operation) {
            case 'insert':$this->Superadminmodal->insertKeys();
                break;
            case 'edit':$this->Superadminmodal->updateKeys();
                break;
            case 'delete':$this->Superadminmodal->deleteKeys();
                break;
        }
    }

    function fetchKeyDetails($id) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->Superadminmodal->fetchKeyDetails($id);
    }


    public function editpassword() {
        $this->Superadminmodal->editpassword();
    }

    public function validatePassword() {
        return $this->Superadminmodal->validatePassword($this->session->userdata('userid'));
    }

 
    // end

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */