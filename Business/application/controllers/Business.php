<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Businessmodel');
       
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        // $language = $this->session->userdata('lang');
        $this->lang->load('headerNav_lang',$language);
        $this->lang->load('store_lang', $language);
        //$this->lang->load('dashboard_lang', $language);

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index($loginerrormsg = NULL) {

        $data['loginerrormsg'] = $loginerrormsg;
        $this->load->view('login', $data);
    }

    public function storedriver_config() {
        if ($this->issessionset()) {
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['storedriverconfig'] = $this->Businessmodel->storedriver_config($this->session->userdata('badmin')['BizId']);
            $data['pagename'] = 'admin/storedriver_config';

            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }
    
   

    public function profile() {

        if ($this->issessionset()) {
            $data['language'] = $this->Businessmodel->get_lan_hlpText();
            
            $data['ProfileData'] = $this->Businessmodel->GetProfileData($this->session->userdata('badmin')['BizId']);
           // echo '<pre>';    print_r($data['ProfileData']);die;
        
            $data['Admin'] = $this->session->userdata('badmin')['Admin'];
            $data['CountryList'] = $this->Businessmodel->GetCountryCities();
            $data['category'] = $this->Businessmodel->storecategoryData();
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['ProCats'] = $this->Businessmodel->AllProviderCategories();
            $data['ProsubCats'] = $this->Businessmodel->AllProvidersubCategories();
            $data['tslotdata'] = $this->Businessmodel->grocertime_config();
            $data['slot_timedata'] = $this->Businessmodel->slot_timedata();
            $data['zones'] = $this->Businessmodel->getZones();
            $data['pagename'] = 'admin/MyProfile';
            $this->load->view('template', $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }
    
    public function getSubcatList() {
        $this->Businessmodel->getSubcatList();
    }

    public function AuthenticateUser() {
        $this->load->model("Businessmodel");
        $status = $this->Businessmodel->ValidateSuperAdmin();
        if ($status) {
            redirect(base_url() . "index.php?/Business/loadDashbord");
        } else {
            $loginerrormsg = "invalid email or password";
            $this->index($loginerrormsg);
        }
    }

    public function changeOrder() {
        $this->load->model("Businessmodel");
        $Subs = $this->Businessmodel->changeOrder();
    }

    public function update_tslot() {

        $this->load->model("Businessmodel");

        $slots = $this->Businessmodel->update_tslot();
    }

    public function update_storetslot() {

        $this->load->model("Businessmodel");
        $slots = $this->Businessmodel->update_storetslot();
    }

    public function changeSubCatOrder() {
        $this->load->model("Businessmodel");
        $Subs = $this->Businessmodel->changeSubCatOrder();
//        print_r($Subs);
//        redirect(base_url() . "index.php?/superadmin/SubCategories");
    }

    public function changeProductCatOrder() {
        $this->load->model("Businessmodel");
        $Subs = $this->Businessmodel->changeProductCatOrder();
//        print_r($Subs);
//        redirect(base_url() . "index.php?/superadmin/SubCategories");
    }

    public function FromAdmin($param = '',$timeOffset='') {
        if ($param != '') {
            // $this->load->model('Businessmodel');
            // $this->Businessmodel->setSessionFromAdmin($param);
            // redirect(base_url() . "index.php?/Business/loadDashbord");
          
            $this->load->model('Businessmodel');
            $this->Businessmodel->setSessionFromAdmin($param , $timeOffset);
            redirect(base_url() . "index.php?/Business/loadDashbord");
        }
    }

    public function update_storetimeslots() {

        $this->load->model("Businessmodel");
        $res = $this->Businessmodel->update_storetimeslots();
    }

    public function loadDashbord() {

//      echo 1; die;
        if ($this->issessionset()) {
            $this->load->model("Businessmodel");

            $data['dashborddata'] = $this->Businessmodel->get_Dashbord_data($this->session->userdata('badmin')['BizId']);
            $data['tslotdata'] = $this->Businessmodel->grocertime_config();
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/V_AdminList";

            $this->load->view("template", $data);
//            echo 3;
        } else
//if session expired
            redirect(base_url() . "index.php?/Business");
    }

    public function mileage() {
        if ($this->issessionset()) {
            $this->load->model("Businessmodel");
            $data['cityId'] = $this->session->userdata('badmin')['cityid'];
            $data['countryId'] = $this->session->userdata('badmin')['Countryid'];

            $data['country'] = $this->Businessmodel->get_selectedcountry($data['countryId']);
            $data['city_list'] = $this->Businessmodel->get_selectedcity($data['cityId']);

            $data['Drivertype'] = $this->Businessmodel->get_drivertype($this->session->userdata('badmin')['BizId']);

            $data['table'] = $this->Businessmodel->GetmileageDetails($this->session->userdata('badmin')['BizId']);
            $data['pagename'] = "admin/mileage";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }

    public function zonal() {
        if ($this->issessionset()) {
            $this->load->model("Businessmodel");
            $data['cityId'] = $this->session->userdata('badmin')['cityid'];

            $data['countryId'] = $this->session->userdata('badmin')['Countryid'];
//      
            $data['country'] = $this->Businessmodel->get_selectedcountry($data['countryId']);

            $data['city_list'] = $this->Businessmodel->get_selectedcity($data['cityId']);

            $data['Admin'] = $this->session->userdata('badmin')['Admin'];

            $data['Drivertype'] = $this->Businessmodel->get_drivertype($this->session->userdata('badmin')['BizId']);
//        print_r($data['Drivertype']);exit();

            $data['zonelist'] = $this->Businessmodel->get_zonelist($data['cityId']);

            $data['table'] = $this->Businessmodel->GetzonalDetails($this->session->userdata('badmin')['BizId']);
//        print_r($data['table']); exit();
            $data['pagename'] = "admin/zonal";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }

//categories controller
    public function Categories() {
//check the session.
        if ($this->issessionset()) {
//select applied model
            $this->load->model("Businessmodel");
            $data['language'] = $this->Businessmodel->get_lan_hlpText();
            $data['ProfileData'] = $this->Businessmodel->GetProfileData($this->session->userdata('badmin')['BizId']);

//get data from model
            $data['entitylist'] = $this->Businessmodel->GetAllCategories($this->session->userdata('badmin')['BizId']);
//get id from session
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
//select the page
            $data['pagename'] = "admin/Categories";
//open the view
            $this->load->view("template", $data);
        } else
//if session expired
            redirect(base_url() . "index.php?/Business");
    }

//delete cat controller
    public function DeleteCat($CatId = '') {
//select model
        $this->load->model("Businessmodel");
//call delete method from model
        $this->Businessmodel->DeleteCat($CatId);
//redirect
        redirect(base_url() . "index.php?/Admin/Categories");
    }

    public function ChangePwd() {

        $data['BizId'] = $this->session->userdata('badmin')['BizId'];
        $data['pagename'] = "admin/ChangePwd";
        $this->load->view("template", $data);
    }

    public function SubCategories() {

        if ($this->issessionset()) {
            $this->load->model("Businessmodel");
            $data['language'] = $this->Businessmodel->get_lan_hlpText();
//            echo $this->session->userdata('badmin')['BizId'];
//            $data['dashborddata'] = $this->Businessmodel->get_Dashbord_data($this->session->userdata('badmin')['BizId']);
            $data['entitylist'] = $this->Businessmodel->GetAllSubCategories($this->session->userdata('badmin')['BizId']);
            $data['AllCats'] = $this->Businessmodel->GetAllCategories($this->session->userdata('badmin')['BizId']);


            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/SubCategories";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }

    public function DeleteSubCat($subCatId = '') {
        $this->load->model("Businessmodel");
        $this->Businessmodel->DeleteSubCat($subCatId);
        redirect(base_url() . "index.php?/Business/SubCategories");
    }

    public function DeleteProduct() {

        $this->load->model("Businessmodel");
        $this->Businessmodel->DeleteProduct();
//        redirect(base_url() . "index.php?/Admin/Products");
    }

    public function Products() {

        if ($this->issessionset()) {
            $this->load->model("Businessmodel");
            $this->load->library('table');
            $data['status'] = $status;
//        require 'datatableVariable.php';
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

            $this->table->set_heading('SLNO', 'NAME', 'FRANCHISE NAME', 'EMAIL ID', 'STATUS', 'SELECT');
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/Products";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }

    public function showsubcat() {

        $this->load->model("Businessmodel");
        $data = $this->Businessmodel->loadsubcat();
        $vt = $this->input->post('vt');

//        echo json_encode($vt);
        $return1 = array();

        if ($vt == '1')
            $this->session->set_userdata(array('BusinessId' => $this->input->post('cat')));

        $return1[] = "<option value=''>Select Subcategory</option>";
        $return1[] = "<option value=''>All</option>";
//        echo $return;

        foreach ($data as $cat)
            $return1[] = "<option value='" . $cat['BusinessId'] . "'>" . implode($cat['SubCategory'], ',') . "</option>";

        print_r($return1);
//        } 
//        echo $return1;
//        echo $return1;
    }

    public function filtercat() {

        $this->load->model("Businessmodel");
        $catid = $this->input->post('cat');
        $scatid = $this->input->post('sid');
        $data = array();
        if ($catid == '0') {
            $data1 = $this->Businessmodel->GetAllProducts($this->session->userdata('badmin')['BizId']);

            foreach ($data1 as $val) {
//                print_r($val);
                foreach ($val['Portion'] as $price) {
                    
                }
//                        }
//                         echo 'hy  ';
                $data[] = array(
                    'img' => $val['Masterimageurl']['Url'],
                    'p_id' => (string) $val['_id'],
                    'pname' => $val['ProductName'],
                    'cat' => $val['CatName'],
                    'subcat' => $val['SubCatName'],
                    'price' => $price['price']
                );
            }
        } else {
            $data = $this->Businessmodel->getdata();
        }
//        echo '<pre>'; print_r($data); die();

        echo json_encode(array('res' => $data));
    }

    public function SalesAnalytics() {
        if ($this->issessionset()) {
            $this->load->model("Businessmodel");
            $data['entitylist'] = $this->Businessmodel->SalesAnalytics($this->session->userdata('badmin')['BizId']);
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/SalesAnalytics";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }

    public function drivers() {
//////////////
        if ($this->issessionset()) {
            $this->load->library('Datatables');
            $this->load->library('table');
//            $data['BizId'] = $this->session->userdata('BizId');
            $data['id'] = $this->session->userdata('BizId');

            $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="driver table table-striped table-bordered table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
                'heading_row_start' => '<tr style= "" role="row">',
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
            $this->table->set_heading('DRIVER ID', 'FIRST NAME', 'LAST NAME', 'PHONE', 'EMAIL', 'SELECT');

            $data['pagename'] = "admin/drivers";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }

    public function offlinedrivers() {
//////////////
        if ($this->issessionset()) {
//           print_r($this->session->userdata('badmin')['BizId']);
            $this->load->model("Businessmodel");
//            echo $this->session->userdata('badmin')['BizId'];
            $data['table'] = $this->Businessmodel->GetDriverDetails($this->session->userdata('badmin')['BizId']);
//            $data['ProfileData'] = $this->Businessmodel->GetProfileData($this->session->userdata('badmin')['BizId']);
//            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/offlinedrivers";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }

    public function user() {

        if ($this->issessionset()) {

            $this->load->model("Businessmodel");
            $data['table'] = $this->Businessmodel->GetUserDetails($this->session->userdata('badmin')['BizId']);
            $data['pagename'] = "admin/users";
            $this->load->view("template", $data);
        } else {
            redirect(base_url() . "index.php?/Business");
        }
    }

    public function insertmanager($BizId = '') {
//       $this->IsDirectUrl();
        $this->load->model("Businessmodel");
        $this->Businessmodel->insertmanager($this->session->userdata('badmin')['BizId']);
        redirect(base_url() . "index.php?/Business/user");
    }

    public function insertoffdrivr($BizId = '') {
//       $this->IsDirectUrl();
        $this->load->model("Businessmodel");
        $this->Businessmodel->insertoffdrivr($this->session->userdata('badmin')['BizId']);
        redirect(base_url() . "index.php?/Business/offlinedrivers");
    }

    public function insertzonalset($BizId = '', $cityid = '') {
//       $this->IsDirectUrl();
        $this->load->model("Businessmodel");
        $this->Businessmodel->insertzonalset($this->session->userdata('badmin')['BizId'], $this->session->userdata('badmin')['cityid']);
        redirect(base_url() . "index.php?/Business/zonal");
    }

    public function insertmileageset($BizId = '', $cityid = '') {
//       $this->IsDirectUrl();
        $this->load->model("Businessmodel");
        $this->Businessmodel->insertmileageset($this->session->userdata('badmin')['BizId'], $this->session->userdata('badmin')['cityid']);
        redirect(base_url() . "index.php?/Business/mileage");
    }

    public function get_managerdata() {
//        echo 'hi';
        $this->load->model("Businessmodel");
        $data[] = $this->Businessmodel->get_managerdata();
        echo json_encode($data);
//        redirect(base_url() . "index.php?/superadmin/ServiceCharge");
    }

    public function getjaiecom_details() {
//        echo 'hi';
        $this->load->model("Businessmodel");
        $data[] = $this->Businessmodel->getjaiecom_details();
//        print_r($data); die;
        echo json_encode($data);
//        redirect(base_url() . "index.php?/superadmin/ServiceCharge");
    }

    public function getjaiecom_deliverychg() {
//        echo 'hi';
        $this->load->model("Businessmodel");
        $data[] = $this->Businessmodel->getjaiecom_deliverychg();
//        print_r($data); die;
        echo json_encode($data);
//        redirect(base_url() . "index.php?/superadmin/ServiceCharge");
    }

    public function get_driverdata() {
//        echo 'hi';
        $this->load->model("Businessmodel");
        $data = $this->Businessmodel->get_driverdata();
        echo json_encode($data);
//        redirect(base_url() . "index.php?/superadmin/ServiceCharge");
    }

    public function get_mileagedata() {
//        echo 'hi';
        $this->load->model("Businessmodel");
        $data[] = $this->Businessmodel->get_mileagedata();
        echo json_encode($data);
//        redirect(base_url() . "index.php?/superadmin/ServiceCharge");
    }

    public function get_zonaldata() {
//        echo 'hi';
        $this->load->model("Businessmodel");
        $data[] = $this->Businessmodel->get_zonaldata();
        echo json_encode($data);
//        redirect(base_url() . "index.php?/superadmin/ServiceCharge");
    }

    public function get_mileagealldata($Bizid = '') {

//        echo 'hi';
        $this->load->model("Businessmodel");
        $data[] = $this->Businessmodel->get_mileagealldata($this->session->userdata('badmin')['BizId']);
        echo json_encode($data);
//        redirect(base_url() . "index.php?/superadmin/ServiceCharge");
    }

    public function getcatdetails() {
//        echo 'hi';
        $this->load->model("Businessmodel");
        $data[] = $this->Businessmodel->getcatdetails();
        echo json_encode($data);
//        redirect(base_url() . "index.php?/superadmin/ServiceCharge");
    }

    public function getsubcatdetails() {
//        echo 'hi';
        $this->load->model("Businessmodel");
        $data[] = $this->Businessmodel->getsubcatdetails();
        echo json_encode($data);
//        redirect(base_url() . "index.php?/superadmin/ServiceCharge");
    }

    public function editmanager() {
//       $this->IsDirectUrl();
        $this->load->model("Businessmodel");
        $this->Businessmodel->editmanager();
        redirect(base_url() . "index.php?/Business/user");
    }

    public function editofflinedriver() {
//       $this->IsDirectUrl();
        $this->load->model("Businessmodel");
        $this->Businessmodel->editofflinedriver();
        redirect(base_url() . "index.php?/Business/offlinedrivers");
    }

    public function editmileageset() {
//       $this->IsDirectUrl();
        $this->load->model("Businessmodel");
        $this->Businessmodel->editmileageset();
        redirect(base_url() . "index.php?/Business/mileage");
    }

    public function editzonalset() {
//       $this->IsDirectUrl();
        $this->load->model("Businessmodel");
        $this->Businessmodel->editzonalset();
        redirect(base_url() . "index.php?/Business/zonal");
    }

    public function change_password() {
//        echo 'admin';
//        die();
//       $this->IsDirectUrl();
        $this->load->model("Businessmodel");
        $this->Businessmodel->change_password();
        redirect(base_url() . "index.php?/Business/user");
    }

    public function delete_User($id = '') {
//select model
        $this->load->model("Businessmodel");
//call delete method from model
        $this->Businessmodel->delete_User($id);
//redirect
//        redirect(base_url() . "index.php?/Business/user");
    }

    public function delete_Driver($id = '') {
//select model
        $this->load->model("Businessmodel");
//call delete method from model
        $this->Businessmodel->delete_Driver($id);
//redirect
//        redirect(base_url() . "index.php?/Business/user");
    }

    public function delete_mileage($id = '') {
//select model
        $this->load->model("Businessmodel");
//call delete method from model
        $this->Businessmodel->delete_mileage($id);
//redirect
//        redirect(base_url() . "index.php?/Business/user");
    }

    public function delete_zonal($id = '') {
//select model
        $this->load->model("Businessmodel");
//call delete method from model
        $this->Businessmodel->delete_zonal($id);
//redirect
//        redirect(base_url() . "index.php?/Business/user");
    }

    public function validateEmail_user() {
        $this->load->model("Businessmodel");
        return $this->Businessmodel->validateEmail_user();
    }

    public function validateEmail_driver() {
        $this->load->model("Businessmodel");
        return $this->Businessmodel->validateEmail_driver();
    }

    public function validate_username() {
        $this->load->model("Businessmodel");
        return $this->Businessmodel->validate_username();
    }
    public function validatePassword() {
        $this->load->model("Businessmodel");
        return $this->Businessmodel->validatePassword($this->session->userdata('badmin')['BizId']);
    }

    public function datatable_drivers($status = "") {

        $this->load->model("Businessmodel");

//              $data['id'] = $this->session->userdata('badmin')['BizId'];
        $data = $this->session->userdata('badmin')['BizId'];
//              print_r($status);
//              print_r($data);
//              exit();
//        echo 'admin';
//        if ($this->session->userdata('table') != 'company_info') {
//            $this->Logout();
//        }

        $this->Businessmodel->datatable_drivers($data, $status);
//        echo json_encode($res);
    }

    public function datatableProducts() {

        $this->load->model("Businessmodel");

        $this->Businessmodel->datatableProducts();
    }

    public function addnewdriver() {

//        $this->load->helper('cookie');
//        delete_cookie("emailid");
//        delete_cookie("password");

        if ($this->issessionset()) {
            $this->load->model("Businessmodel");
//            $data['entitylist'] = $this->Businessmodel->SalesAnalytics($this->session->userdata('badmin')['BizId']);
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['country'] = $this->Businessmodel->GetCountry();
            $data['pagename'] = "admin/addnewdriver";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }

    public function editdriver($val = '', $status = '') {

//        $this->load->helper('cookie');
//        delete_cookie("emailid");
//        delete_cookie("password");

        if ($this->issessionset()) {
            $this->load->model("Businessmodel");
//            $data['entitylist'] = $this->Businessmodel->SalesAnalytics($this->session->userdata('badmin')['BizId']);
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['driverid'] = $val;
            $data['status'] = $status;
            $data['dat'] = $this->Businessmodel->Editdriver($val);
            $data['country'] = $this->Businessmodel->get_country();
            $data['pagename'] = "admin/editdriver";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }

    public function editdriverdata() {
        $this->load->model("Businessmodel");

        $data['BizId'] = $this->session->userdata('badmin')['BizId'];
//         print_r($data); exit();
        $this->Businessmodel->editdriverdata($data);
        redirect(base_url() . "index.php?/Business/drivers");
    }

    public function AddNewDriverData() {

        $this->load->model("Businessmodel");

        $data['BizId'] = $this->session->userdata('badmin')['BizId'];
//         print_r($data); exit();
        $this->Businessmodel->addNewDriverData($data);
        redirect(base_url() . "index.php?/Business/drivers");
    }

    public function delete_Drivers() {
        $drivid = $this->input->post('val');
        $this->load->model("Businessmodel");


        $this->Businessmodel->delete_Drivers($drivid);

//        echo json_encode($res);
    }

    public function get_city() {
//        $drivid = $this->input->post('val');
        $this->load->model("Businessmodel");


        $data = $this->Businessmodel->get_city();
        print_r($data);
//        echo json_encode($res);
    }

    public function OrderDetails($param = '') {
        if ($this->issessionset()) {
            $this->load->model("Businessmodel");
//            echo $this->session->userdata('badmin')['BizId'];
            $data['OrderDetails'] = $this->Businessmodel->GetOrderDetails($param);
            $data['ProfileData'] = $this->Businessmodel->GetProfileData($this->session->userdata('badmin')['BizId']);
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/OrderDetail";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }

    public function NotificationDetails($param = '') {

        $this->load->model("Businessmodel");

        $OrderDetails = $this->Businessmodel->GetOrderDetails($param);
        print_r(json_encode($OrderDetails));
    }

    public function Orders() {
//        echo 'con';
        if ($this->issessionset()) {

            $this->load->model("Businessmodel");
//              echo 'con';
//            $data['dashborddata'] = $this->Businessmodel->get_Dashbord_data($this->session->userdata('badmin')['BizId']);
            $data['OrderList'] = $this->Businessmodel->GetAllOrders($this->session->userdata('badmin')['BizId']['$oid']);

            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/Orders";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }
    public function datatableOrderHistory($param) {
         $this->Businessmodel->datatableOrderHistory($param);
    }
    public function OrderHistory() {
        if ($this->issessionset()) {
            $this->load->library('Datatables');
        $this->load->library('table');
            $this->load->model("Businessmodel");
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
        $this->table->set_heading('SL NO.','ORDER ID', 'DRIVER NAME', 'CUSTOMER NAME', 'ORDER VALUE','DELIVERY FEE','APP COMMISSION','STORE EARNINGS','TOTAL', 'ORDER PLACED ON','ORDER COMPLETED ON','STATUS','INVOICE');

//            $data['dashborddata'] = $this->Businessmodel->get_Dashbord_data($this->session->userdata('badmin')['BizId']);
            $data['OrderList'] = $this->Businessmodel->GetOrderHistory($this->session->userdata('badmin')['BizId']);
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/OrderHistory";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }
    public function allOrderDetails() {
        if ($this->issessionset()) {
        
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/orderDetails";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }


    public function admin_list() {
        if ($this->issessionset()) {
            $this->load->model("Businessmodel");
            $data['Admin_list'] = $this->Businessmodel->LoadAdminList();
            $data['pagename'] = "admin/adminlist";
            $this->load->view("template", $data);
        } else {
            redirect(base_url() . "index.php?/Business");
        }
    }

    public function LoadAdminList() {
//       $this->IsDirectUrl();
        $this->load->model("Businessmodel");
        $data['Admin_list'] = $this->Businessmodel->LoadAdminList();
        $data['pagename'] = "admin/adminlist";
        $this->load->view("template", $data);
    }

    public function AddNewAdmin() {
//       $this->IsDirectUrl();
        $this->load->model("Businessmodel");
        $this->Businessmodel->AddNewAdmin();
        redirect(base_url() . "index.php?/Business/admin_controller");
    }



    public function UpdateProfile() {
        $this->load->model("Businessmodel");

//         $BusinessId = $this->input->post("BusinessId");
        $this->Businessmodel->UpdateProfile();
        // echo 'hii';print_r($this->input->post("BusinessId"));die;
        $this->Businessmodel->updateSession($this->input->post("BusinessId"));
        redirect(base_url() . "index.php?/Business/profile");
    }
    public function editpassword() {
        $this->load->model("Businessmodel");
        $this->Businessmodel->editpassword();
//        redirect(base_url() . "index.php?/Business");
    }

    public function UpdatePwd() {
        $this->load->model("Businessmodel");
        $this->Businessmodel->UpdatePwd();
        redirect(base_url() . "index.php?/Business/profile");
    }

    public function CheckOldPwd() {
        $this->load->model("Businessmodel");
//        ECHO $this->session->userdata('badmin')['BizId'];
        $data = $this->Businessmodel->CheckOldPwd($this->session->userdata('badmin')['BizId']);
        print_r(json_encode($data));
//        redirect(base_url() . "index.php?/Business/profile");
    }

    public function getZones() {
        $this->load->model("Businessmodel");
        $this->Businessmodel->getZonesWithCities();
    }
 

    public function ChangePassword() {
        $this->IsDirectUrl();
        $currenpassword = $this->input->post("CurrentPassword");
        $adminpassword = $this->session->userdata['password'];
        $email = $this->session->userdata['emailid'];

        if (md5($currenpassword) == $adminpassword) {
            $newpassword = $this->input->post("NewPassword");
            $this->load->model("Businessmodel");
            $this->Businessmodel->ChangePassword($newpassword, $email);
            echo "Password changed successfully";
        } else {
            echo "Current password is wrong";
        }
    }

    /*
     *
     * logout
     *
     */

    public function logout() {
        $array_items = array('emailid' => '', 'email' => '', 'validate' => false);
        $this->session->unset_userdata($array_items);
        redirect(base_url() . "index.php?/Business");
    }

    public function forgotPassword() {
        $useremail = $this->input->post("resetemail");
        $this->load->model("Businessmodel");
        $data = $this->Businessmodel->ForgotPassword($useremail);

        if ($data) {
            echo "Reset password link is sent to you in mail";
        } else {
            echo "Email is not available";
        }
    }

    public function ResetPwd($param1) {
//        if ($this->issessionset()) {
        $this->load->model("Businessmodel");
        $check = $this->Businessmodel->checkLink($param1);
        if ($check['flag'] == 1) {
            $this->load->view('error.php');
        } else {
            $data['pagename'] = "ReSetPwd";
            $data['For'] = $param1;

            $this->load->view("ResetPassword", $data);
        }
//        } else
//            redirect(base_url() . "index.php?/Business");
    }

    public function ResetPassword() {
        $this->load->model("Businessmodel");
        $data = $this->Businessmodel->ResetPwd();
        print_r(json_encode($data));
    }

    public function VerifyResetLink($param) {
        if ($param) {
            $this->load->model("Businessmodel");
            $data = $this->Businessmodel->VerifyResetLink($param);
        }
        if ($data)
            redirect(base_url() . "index.php?/Business");
        else
            echo "error while resetting password try again forgot password option";
    }

// call Admin control clicked

    public function admin_controller() {
        if ($this->issessionset()) {
            $this->load->model("Businessmodel");
            $data['Admin_list'] = $this->Businessmodel->LoadAdminList();
            $data['pagename'] = "superadmin/adminlist";
            $this->load->view("template", $data);
        } else
            redirect(base_url() . "index.php?/Business");
    }

// end of admin control

    /**
     *
     * add new broker
     *
     */
    public function AddNewBroker() {
        if ($this->issessionset()) {
            if ($this->input->post()) {

                $this->load->model("Businessmodel");
                $this->Businessmodel->AddNewBroker();
                redirect(base_url() . "index.php?/Business/broker_controller");
            } else
                redirect(base_url() . "index.php?/Business/broker_controller");
        } else
            redirect(base_url() . "index.php?/Business");
    }

    /*
     *
     * Edit admin and broker Creation details
     *
     */

    function EditNewAdmin($user = '') {

        $this->load->model("Businessmodel");
        $this->Businessmodel->EditNewAdmin();
        if ($user == 'admin')
            redirect(base_url() . "index.php?/Business/admin_controller");
        else if ($user == 'broker')
            redirect(base_url() . "index.php?/Business/broker_controller");
    }

    /*
     *
     * Delete admin and broker Creation details
     *
     */

    function DeleteUser($user = '') {

        $this->load->model("Businessmodel");
        $this->Businessmodel->DeleteUser();
        if ($user == 'admin')
            redirect(base_url() . "index.php?/Business/admin_controller");
        else if ($user == 'broker')
            redirect(base_url() . "index.php?/Business/broker_controller");
    }

    /**
     *
     * validate email is available in database
     */
    public function validateEmail() {
        $this->load->model("Businessmodel");
        return $this->Businessmodel->validateEmail();
    }
    

    /*
     *
     *
     * check session
     */

    function issessionset() {
        if ($this->session->userdata('badmin')['BizId']) {

//        if ($this->session->userdata('emailid') && $this->session->userdata('badmin')['BizId']) {

            return true;
        }
        return false;
    }


// Upload images on amazon

    public function uploadImagesToAws(){
        
        $this->Businessmodel->uploadImageToAmazone();
    }

     public function getStoreCurrency(){
       $storeSession = $this->session->all_userdata();
       $storeId = $storeSession['badmin']['BizId'];

        if (!isset($storeId) || empty($storeId)) {
            echo json_encode(array('status' => false, 'message' => 'Store id not found'));
        }else{
            $response = $this->Businessmodel->getStoreCurrency($storeId);

        }
        
    }
    public function checkCurrentTime(){
        $now = new DateTime();
        echo $now->format('Y-m-d H:i:s');    // MySQL datetime format
        // echo $now->getTimestamp(); 
    }
    
     public function oneOrderDetails($param) {


        $return['data'] = $this->Businessmodel->tripDetails($param);
        $return['order_id'] = $param; 


        $return['pagename'] = "admin/trip_details";
//         $return['pagename'] = "trip_details_pathTest";
        $this->load->view("template", $return);
        //$this->Superadminmodal->tripDetails();
    }


}
