<?php

error_reporting(true);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Business extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model("Categorymodal");
        $this->load->model("Businessmodal");
        $this->load->model("SubCategorymodal");
        $this->load->model("Superadminmodal");
        
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('dispensary_lang', $language);
        $this->lang->load('city_lang', $language);
       $this->lang->load('header_lang',$language);
        
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index($status = '') {


        //$data['business'] = $this->Businessmodal->businessData();

        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        $this->load->library('Datatables');
        $this->load->library('table');
        $data['status'] = $status;
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

        // $this->lang->line('col_select')
        $checkbox=' <input type="checkbox" id="select_all" />';
        $this->table->set_heading($this->lang->line('col_sino'), $this->lang->line('col_Name'),
                                  $this->lang->line('col_storeCat'),$this->lang->line('col_storeSubCat'),
                                  $this->lang->line('col_franchiseName'), $this->lang->line('col_emailId'), 
                                  $this->lang->line('col_avgrating'), 
                                  $this->lang->line('col_action') ,  'Select');

        $data['pagename'] = 'Business/business';
        $this->load->view("company", $data);
    }

    public function addnewbusiness() {

        $this->load->helper('cookie');
        delete_cookie("emailid");
        delete_cookie("password");
        $data['language'] = $this->Businessmodal->get_lan_hlpText();
        $data['country'] = $this->Businessmodal->getCountryCities();
        $data['appConfig'] = $this->Superadminmodal->getAppConfig();
        $data['business'] = $this->Businessmodal->businessData();
        $data['category'] = $this->Businessmodal->storecategoryData();
        $data['dp'] = $this->Businessmodal->dpData();
//        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        $data['pagename'] = 'Business/addNewStore';

        $this->load->view("company", $data);
    }
    
     public function getZones() {

        $this->Businessmodal->getZonesWithCities();
    }
    
    public function editbusiness($id) {
       
        $this->load->helper('cookie');
        delete_cookie("emailid");
        delete_cookie("password");
        $data['language'] = $this->Businessmodal->get_lan_hlpText();
        $data['storedata'] = $this->Businessmodal->getBusinessdata($id);
      // echo '<pre>'; print_r($data['storedata']);die;
        $data['country'] = $this->Businessmodal->getCountryCities();
        $data['appConfig'] = $this->Superadminmodal->getAppConfig();
        // $data['business'] = $this->Businessmodal->businessData();
        $data['category'] = $this->Businessmodal->storecategoryData();
        $data['pagename'] = 'Business/editbusiness';

        $this->load->view("company", $data);
    }

    public function addnewbusinessPos($locationId, $urlData, $address, $emailAddress, $phone, $locationName, $paymentsEnabled, $posID, $walletID) {

        $replacements = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
        $entity_arr = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
        
        $addres = str_replace($replacements, $entity_arr, $address);

        $locationNam = str_replace("%20", " ", $locationName);
        $paymentsEnable = str_split($paymentsEnabled, 2);
        $external_credit_card = $paymentsEnable[0];
        $internal_credit_card = $paymentsEnable[1];
        $check = $paymentsEnable[2];
        $quickcard = $paymentsEnable[3];
        $gift_card = $paymentsEnable[4];

        $x = explode(".", $urlData);
        $str = str_replace("___", "://", $x[0]);
        $str1 = str_replace("__", "/", $x[1]);
        $str2 = str_replace("__", "/", $x[2]);
        $urlData = $str . '.' . $str1 . '.' . $str2;

        $emailAddress = str_replace("__", "@", $emailAddress);

        $this->load->helper('cookie');

        $data['externalCreditCard'] = $external_credit_card;
        $data['internalCreditCard'] = $internal_credit_card;
        $data['check'] = $check;
        $data['quickCard'] = $quickcard;
        $data['giftCard'] = $gift_card;
        $data['locationId'] = $locationId;
        $data['posID'] = $posID;
        $data['walletID'] = $walletID;
        $data['paymentsEnabled'] = $paymentsEnabled;
        $data['locationName'] = $locationNam;
        $data['addressPos'] = urldecode($addres);
        $data['emailAddressPos'] = $emailAddress;
        $data['phonePos'] = $phone;
        $data['urlData'] = $urlData;
        $data['language'] = $this->Businessmodal->get_lan_hlpText();
        $data['country'] = $this->Businessmodal->getCountryCities();
        $data['appConfig'] = $this->Superadminmodal->getAppConfig();
        $data['business'] = $this->Businessmodal->businessData();
        $data['category'] = $this->Categorymodal->getCategoryForFranchise_and_Business();
        $data['pagename'] = 'Business/addNewStorePos';

        $this->load->view("company_1", $data);
    }

    public function getSubcatList() {
        $this->Businessmodal->getSubcatList();
    }
    public function inactivebusinessmgt() {

        $this->Businessmodal->inactivebusinessmgt();
    }

    public function activebusinessmgt() {
        $this->Businessmodal->activebusinessmgt();
    }

    public function viewnote_businessmgt() {
        $this->Businessmodal->viewnote_businessmgt();
    }

    public function deleteStore() {
        $this->Businessmodal->deleteStore();
    }

    public function validateEmail() {
       $this->Businessmodal->validateEmail();
    }
    public function operationBusiness($param = '', $status = '') {

        switch ($param) {
            case 'insert':
                $this->Businessmodal->insert();
                break;

            case 'edit': $this->Businessmodal->edit();
                break;

            case 'delete':$this->Businessmodal->deleteStore();
                break;

            case 'get': $this->Businessmodal->get();
                break;

            case 'table': $this->Businessmodal->datatable_business($status);
                break;
        }
    }

    public function getCityList() {

        $this->Businessmodal->getCityList();
    }

    public function getStorelist($param) {
        $this->Businessmodal->getStorelist($param);
    }
    public function getFranchise() {
        $this->Businessmodal->getFranchise();
    }

    public function getStoresCount() {
        $this->Businessmodal->getStoresCount();
    }

}
