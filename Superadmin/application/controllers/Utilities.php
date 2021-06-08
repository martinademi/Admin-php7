<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Utilities extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        
        $this->load->model('Utilmodal');
        $this->load->library('session');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
      public function email_template() {
        $this->Logoutmodal->logout();
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $this->load->library('mongo_db');
        $return['temp_type'] = [
            "Passenger_Signup",
            "Passenger_Reset_Password", 
            "Coupons",
            "Driver_Signup",
            "Driver_Activation",
            "Invoice"
        ];
        $return['temp_data'] = $this->Utilmodal->getEmailTemplate();
        $return['pagename'] = "utilities/email_template";
        $this->load->view("company", $return);
    }
     public function email_template_action() {
        $this->Logoutmodal->logout();
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $this->Utilmodal->email_template_action();
    }
    public function other_pages() {
        $this->Logoutmodal->logout();
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['pagename'] = "utilities/other_pages";
        $this->load->view("company", $return);
    }
    
    public function other_page_action() {
        $this->Logoutmodal->logout();
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $fdata = $this->input->post('fdata');
        if($fdata['type'] == 'post'){
            $fdata['temp_type'] = $this->input->post('page_name');
            $fdata['body'] = $this->input->post('body_editor');
            echo file_put_contents($fdata['temp_type'] . ".php", $fdata['body']);
            redirect(base_url() . "index.php?/utilities/other_pages");
        }else if($fdata['type'] == 'get'){
            $data = file_get_contents($fdata['temp_type'] . ".php");
            echo json_encode(array('flg' => 1, 'data' => $data));
        }else{
            redirect(base_url() . "index.php?/utilities/other_pages");
        }
    }


    function lan_help() {
        $this->Logoutmodal->logout();
          error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        
        $return['allLanguage'] = $this->Utilmodal->get_allLan();
//        echo '<pre>'; print_r($return['allLanguage'] ); die;
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
        $this->table->set_heading('SLNO','LANGUAGE','STATUS','ACTION');

        $return['pagename'] = "utilities/hlp_language";
        $this->load->view("company", $return);
    }
    
    
     public function datatable_language() {
        $this->Logoutmodal->logout();
        $this->Utilmodal->datatable_language(); 
    }
    
    
     public function datatable_canreasonCustomer() {
        $this->Logoutmodal->logout();
        $this->Utilmodal->datatable_canreasonCustomer(); 
    }
    
    
      public function datatable_canreasonDriver() {
        $this->Logoutmodal->logout();
        $this->Utilmodal->datatable_canreasonDriver(); 
    }
    
      public function datatable_canreasonDispatcher() {
        $this->Logoutmodal->logout();
        $this->Utilmodal->datatable_canreasonDispatcher(); 
    }
    
     function get_lan_hlpText($param = ''){
        $this->Logoutmodal->logout();
          $this->Utilmodal->get_lan_hlpTextone($param); 
     }
     
     function get_lan_hlpTextone($param = ''){
        $this->Logoutmodal->logout();
          $this->Utilmodal->get_lan_hlpTextone($param); 
     }

    function lan_action($param = '') {
        $this->Logoutmodal->logout();

                if($param == '' || $param == null){ 
                    
                   $this->Utilmodal->lan_action();
                   
                }else{
                    $this->Utilmodal->deleteLang($param);
                }
    }
    
      public function enable_lang() {
        $this->Logoutmodal->logout();

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Utilmodal->enable_lang();
    }
    
      public function disable_lang() {
        $this->Logoutmodal->logout();
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Utilmodal->disable_lang();
    }

    function cancellation() {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
        $return['reasons'] = $this->Utilmodal->get_can_reasons();
        $return['pagename'] = "utilities/cancell_reasons";
        $this->load->view("company", $return);
    }
    
    function cancellationCustomer() {
        $this->Logoutmodal->logout();
        
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
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


        $this->table->set_heading('SL NO.','REASONS','SELECT');
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
        $return['reasons'] = $this->Utilmodal->get_can_reasons();
        $return['pagename'] = "utilities/cancell_reasonsCustomer";
        $this->load->view("company", $return);
    }
    
    function cancellationDriver() {
        $this->Logoutmodal->logout();
        
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
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

        $this->table->set_heading('SL NO.','REASONS','SELECT');
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
        $return['reasons'] = $this->Utilmodal->get_can_reasons();
        $return['pagename'] = "utilities/cancell_reasonsDriver";
        $this->load->view("company", $return);
    }

     function cancellationDispatcher() {
        $this->Logoutmodal->logout();
        
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
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


        $this->table->set_heading('SL NO.','REASONS','SELECT');
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
        $return['reasons'] = $this->Utilmodal->get_can_reasons();
        $return['pagename'] = "utilities/cancell_reasonsDispatcher";
        $this->load->view("company", $return);
    }
    function cancell_act($param = '') {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($param == 'del') {
           $this->Utilmodal->deleteCan();  

        }else{
        $this->Utilmodal->cancell_act();
        }
    }
    function getCanData(){
        $this->Logoutmodal->logout();
         $this->Utilmodal->getCanData();  
    }
    
    //customer support trxt
    public function supportTextCustomer() {
        $this->Logoutmodal->logout();
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
       
        $return['suppTextCustomer'] = $this->Utilmodal->get_cat_supportCustomer();
   
        $return['pagename'] = "utilities/supportTextCustomer";
        $this->load->view("company", $return);
    }

    public function supportTextCustomerSubCategory($catid) {
        $this->Logoutmodal->logout();
        
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
        $return['catId']=$catid;
        $return['suppTextCustomer'] = $this->Utilmodal->get_cat_SubCategory($catid);
        
        $return['pagename'] = "utilities/supportTextCustomerSubCategory";
        $this->load->view("company", $return);
    }

    
    public function supportTextDriverSubCategory($catid) {
        $this->Logoutmodal->logout();
        
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
        $return['catId']=$catid;
        $return['suppTextCustomer'] = $this->Utilmodal->get_cat_SubCategory($catid);
        
        $return['pagename'] = "utilities/supportTextDriverSubCategory";
        $this->load->view("company", $return);
    }

    public function supportTextStoreSubCategory($catid) {
        $this->Logoutmodal->logout();
        
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
        $return['catId']=$catid;
        $return['suppTextCustomer'] = $this->Utilmodal->get_cat_SubCategory($catid);
        
        $return['pagename'] = "utilities/supportTextStoreSubCategory";
        $this->load->view("company", $return);
    }


      public function supportTextDriver() {
        $this->Logoutmodal->logout();
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
        $return['suppText'] = $this->Utilmodal->get_cat_support();
   
        $return['pagename'] = "utilities/supportTextDriver";
        $this->load->view("company", $return);
    }

    
    public function supportTextStore() {
        $this->Logoutmodal->logout();
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
        //CHANGES   
        $return['suppText'] = $this->Utilmodal->get_cat_store();

        $return['pagename'] = "utilities/supportTextStore";
        $this->load->view("company", $return);
    }

    public function getDescription($cat_id = '') {
       
        $return['desc'] = $this->Utilmodal->getDescription($cat_id);
     
        $this->load->view("utilities/description", $return);
    }
    
     public function getsubDescription($cat_id = '', $subcatID = '',$languageCode='') {
      
        error_reporting(0);
        $return['desc'] = $this->Utilmodal->getsubDescription($cat_id,$subcatID,$languageCode);
   
        $this->load->view("utilities/subdescription", $return);
    }

    function support_catCustomer($param2 = '', $param = '') {
        $this->Logoutmodal->logout();
       
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
      
        $return['helpText'] = '';
        if ($param2 == 0) {
            $return['edit_id'] = '';
            $return['cat_id'] = $param;
            $return['helpText'] = $this->Utilmodal->get_cat_support($param, 'add');
        } else {
            
        }

        $return['pagename'] = "utilities/add_support_catCustomer";
        $this->load->view("company", $return);
    }

    //sub cat for customer
    function support_catSubCustomer($param2 = '', $param = '') {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
      
        $return['helpText'] = '';
        if ($param2 == 0) {
            $return['edit_id'] = '';
            $return['cat_id'] = $param;
            $return['helpText'] = $this->Utilmodal->get_cat_support($param, 'add');
        } else {
            
        }

        $return['pagename'] = "utilities/add_support_catSubCustomer";
        $this->load->view("company", $return);
    }

    //sub cat for driver
    function support_catSubStore($param2 = '', $param = '') {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
      
        $return['helpText'] = '';
        if ($param2 == 0) {
            $return['edit_id'] = '';
            $return['cat_id'] = $param;
            $return['helpText'] = $this->Utilmodal->get_cat_support($param, 'add');
        } else {
            
        }

        $return['pagename'] = "utilities/add_support_catSubStore";
        $this->load->view("company", $return);
    }

    
function support_catStore($param2 = '', $param = '') {
    $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
      
        $return['helpText'] = '';
        if ($param2 == 0) {
            $return['edit_id'] = '';
            $return['cat_id'] = $param;
            $return['helpText'] = $this->Utilmodal->get_cat_store($param, 'add');
        } else {
            
        }

        $return['pagename'] = "utilities/add_support_catStore";
        $this->load->view("company", $return);
    }

    
     function support_catDriver($param2 = '', $param = '') {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
        $return['helpText'] = '';
        if ($param2 == 0) {
            $return['edit_id'] = '';
            $return['cat_id'] = $param;
            $return['helpText'] = $this->Utilmodal->get_cat_support($param, 'add');
        } else {
            
        }

        $return['pagename'] = "utilities/add_support_catDriver";
        $this->load->view("company", $return);
    }

    //sub cat driver
    function support_catSubDriver($param2 = '', $param = '') {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->Utilmodal->get_lan_hlpText();
        $return['helpText'] = '';
        if ($param2 == 0) {
            $return['edit_id'] = '';
            $return['cat_id'] = $param;
            $return['helpText'] = $this->Utilmodal->get_cat_support($param, 'add');
        } else {
            
        }

        $return['pagename'] = "utilities/add_support_catSubDriver";
        $this->load->view("company", $return);
    }


    function support_editDriver($param = '', $param2 = '') {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['language'] = $this->Utilmodal->get_lan_hlpText();
      
        if($param2 == ''){
        $data['edit_id'] = $param;
        $data['scat_id'] = $param2;
        }else{
        }
        $data['helpText'] = $this->Utilmodal->get_cat_support($param);
        
        $data['pagename'] = "utilities/edit_support_text_Driver";
        $this->load->view("company", $data);
    }
     function support_editCustomer($param = '', $param2 = '') {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['language'] = $this->Utilmodal->get_lan_hlpText();
       
        if($param2 == ''){
        $data['edit_id'] = $param;
        $data['scat_id'] = $param2;
        }else{
        }
        $data['helpText'] = $this->Utilmodal->get_cat_support($param);
        
        $data['pagename'] = "utilities/edit_support_text_Customer";
        // echo '<pre>';
        // print_r($data);
        // exit;
        $this->load->view("company", $data);
    }

    //driver
    function support_editStore($param = '', $param2 = '') {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['language'] = $this->Utilmodal->get_lan_hlpText();
       
        if($param2 == ''){
        $data['edit_id'] = $param;
        $data['scat_id'] = $param2;
        }else{
        }
        $data['helpText'] = $this->Utilmodal->get_cat_support($param);
        
        $data['pagename'] = "utilities/edit_support_text_Store";
        $this->load->view("company", $data);
    }

    function Subcat_editCustomer($param = '', $param2 = '',$catId='') {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['language'] = $this->Utilmodal->get_lan_hlpText();
        
        if($param2){
        $data['edit_id'] = $param;
        $data['scat_id'] = $param2;
        $data['catid']=$catId;
        }else{
        }
        $data['helpText'] = $this->Utilmodal->get_subcat_support($param);
        
        $data['pagename'] = "utilities/Subcat_editCustomer";
        $this->load->view("company", $data);
    }
    function Subcat_editDriver($param = '', $param2 = '',$catId='') {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['language'] = $this->Utilmodal->get_lan_hlpText();
       
        if($param2){
        $data['edit_id'] = $param;
        $data['scat_id'] = $param2;
        $data['catid']=$catId;
        }else{
        }
        $data['helpText'] = $this->Utilmodal->get_subcat_support($param);
        
        $data['pagename'] = "utilities/Subcat_editDriver";
        $this->load->view("company", $data);
    }

    //subcat edit store  
    function Subcat_editStore($param = '', $param2 = '',$catId='') {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['language'] = $this->Utilmodal->get_lan_hlpText();
       
        if($param2){
        $data['edit_id'] = $param;
        $data['scat_id'] = $param2;
        $data['catid']=$catId;
        }else{
        }
        $data['helpText'] = $this->Utilmodal->get_subcat_support($param);
        
        $data['pagename'] = "utilities/Subcat_editStore";
        $this->load->view("company", $data);
    }


    function get_subcat_support() {
        $this->Logoutmodal->logout();
        error_reporting(0);
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('cat_id' => (int) $this->input->post('cat_id')))->find_one('support_txt'); 

        echo json_encode($res);
    }

    function support_actionCustomer($param = '', $param2 = '') {
        $this->Logoutmodal->logout();
       //$deleteId = $this->input->post("couponId");
      
       //print_r($deleteId);die;
      
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        
        if ($param == 'subdel') {
            $this->Utilmodal->actionCustomer($param,$param2);
            
        }
        else if ($param == 'del') {
            $this->Utilmodal->actionCustomer($param,$param2);
            
        }
        else{
        $return['language'] = $this->Utilmodal->support_actionCustomer();
        }
        redirect(base_url() . "index.php?/utilities/supportTextCustomer");
    }
    
    function support_actionStore($param = '', $param2 = '') {
        $this->Logoutmodal->logout();
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        
        if ($param == 'subdel') {
            $this->Utilmodal->actionCustomer($param,$param2);
            
        }
        else if ($param == 'del') {
            $this->Utilmodal->actionCustomer($param,$param2);
            
        }
        else{
        $return['language'] = $this->Utilmodal->support_actionStore();
        }
        redirect(base_url() . "index.php?/utilities/supportTextStore");
    }

    // function support_actionDriver($param = '', $param2 = '') {
    //     error_reporting(0);
    //     if ($this->session->userdata('table') != 'company_info') {
    //         redirect(base_url());
    //     }
        
    //       $this->load->library('mongo_db');
    //     if ($param == 'del') {
    //         $this->Utilmodal->actionDriver();  
    //     }
    //     else{
    //     $return['language'] = $this->Utilmodal->support_actionDriver();
    //     }
    //     redirect(base_url() . "index.php/utilities/supportTextDriver");
    // }

    
    function support_actionDriver($param = '', $param2 = '') {
       
        $this->Logoutmodal->logout();
       
         error_reporting(0);
         if ($this->session->userdata('table') != 'company_info') {
             redirect(base_url());
         }
         
         if ($param == 'subdel') {
             $this->Utilmodal->actionDriver($param,$param2);
             
         }
         else if ($param == 'del') {
             $this->Utilmodal->actionDriver($param,$param2);
             
         }
         else{
         $return['language'] = $this->Utilmodal->support_actionDriver();
         }
         redirect(base_url() . "index.php?/utilities/supportTextDriver");
     }

    //language
    public function getCustomerSupportLanguage() {
        $this->Logoutmodal->logout();
        
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Utilmodal->getCustomerSupportLanguage();
    }

    //sub category language
    public function getSubCustomerSupportLanguage() {

        $this->Logoutmodal->logout();
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Utilmodal->getSubCustomerSupportLanguage();
    }
}
