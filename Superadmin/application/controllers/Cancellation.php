<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cancellation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        //$language = $this->session->userdata('lang');
		// $this->lang->load('topnav_lang', $language);
        // $this->lang->load('appTextSetting_lang', $language);
        // $this->lang->load('sendNotification_lang',$language);
        $this->load->model('cancellationmodel');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language); 
        $this->lang->load('cancellation_lang',$language); 
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function email_template() {
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
        $return['temp_data'] = $this->cancellationmodel->getEmailTemplate();
        $return['pagename'] = "utilities/email_template";
        $this->load->view("company", $return);
    }

    public function email_template_action() {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $this->cancellationmodel->email_template_action();
    }

    public function other_pages() {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['pagename'] = "utilities/other_pages";
        $this->load->view("company", $return);
    }

    public function other_page_action() {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $fdata = $this->input->post('fdata');
        if ($fdata['type'] == 'post') {
            $fdata['temp_type'] = $this->input->post('page_name');
            $fdata['body'] = $this->input->post('body_editor');
            echo file_put_contents($fdata['temp_type'] . ".php", $fdata['body']);
            redirect(base_url() . "index.php?/utilities/other_pages");
        } else if ($fdata['type'] == 'get') {
            $data = file_get_contents($fdata['temp_type'] . ".php");
            echo json_encode(array('flg' => 1, 'data' => $data));
        } else {
            redirect(base_url() . "index.php?/utilities/other_pages");
        }
    }
 
    function lan_help() {
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
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
        $this->table->set_heading('SLNO', 'LANGUAGE','LANGUAGE CODE', 'STATUS', 'ACTION');

        $return['pagename'] = "utilities/hlp_language";
        $this->load->view("company", $return);
    }

    public function datatable_language() {
        $this->cancellationmodel->datatable_language();
    }

    function cancellationReason($reason = '', $reasonFor = '') {

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

        $this->table->set_heading('SL NO.', 'REASONS','SELECT');
        $return['reasonFor'] = $reasonFor;
      
        $return['reason'] = $reason;
        $return['language'] = $this->cancellationmodel->get_lan_hlpText();
        $return['pagename'] = "cancellation/cancellationReasons";
        $this->load->view("company", $return);
    }
    
    public function datatable_canreason($reason, $reasonFor) {
        $this->cancellationmodel->datatable_canreason($reason, $reasonFor);
    }
    
    function get_lan_hlpText($param = '') {
        $this->cancellationmodel->get_lan_hlpTextone($param);
    }

    function get_lan_hlpTextone($param = '') {
        $this->cancellationmodel->get_lan_hlpTextone($param);
    }

    function lan_action($param = '') {
        if ($param != '' || $param != null) {
            $this->cancellationmodel->deleteLang($param);
        }
    }
    function add_lan_action() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->cancellationmodel->add_lan_action();
    }
    
    function edit_lan_action() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->cancellationmodel->edit_lan_action();
    }

    public function enable_lang() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->cancellationmodel->enable_lang();
    }

    public function disable_lang() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->cancellationmodel->disable_lang();
    }

    function cancellation() {
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->cancellationmodel->get_lan_hlpText();
        $return['reasons'] = $this->cancellationmodel->get_can_reasons();
        $return['pagename'] = "utilities/cancell_reasons";
        $this->load->view("company", $return);
    }

    function cancell_act($param = '') {
        error_reporting(0);
        if ($param == 'del') {
            $this->cancellationmodel->deleteCan();
        } else {
            $this->cancellationmodel->cancell_act();
        }
    }

    function getCanData() {
        $this->cancellationmodel->getCanData();
    }

    public function supportTextCustomer() {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['language'] = $this->cancellationmodel->get_lan_hlpText();
        $return['suppTextCustomer'] = $this->cancellationmodel->get_cat_supportCustomer();
        
        $return['pagename'] = "utilities/supportTextCustomer";
        $this->load->view("company", $return);
    }
    
    public function supportTextCustomerSubCategory($catid) {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['language'] = $this->cancellationmodel->get_lan_hlpText();
        $return['catId']=$catid;
        $return['suppTextCustomer'] = $this->cancellationmodel->get_cat_SubCategory($catid);
        
        $return['pagename'] = "utilities/supportTextCustomerSubCategory";
        $this->load->view("company", $return);
    }
    

    public function supportTextDriver() {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['language'] = $this->cancellationmodel->get_lan_hlpText();
        $return['suppText'] = $this->cancellationmodel->get_cat_support();

        $return['pagename'] = "utilities/supportTextDriver";
        $this->load->view("company", $return);
    }
    public function supportTextDriverSubCategory($catid) {
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        error_reporting(0);
        $return['language'] = $this->cancellationmodel->get_lan_hlpText();
        $return['catId']=$catid;
        $return['suppTextCustomer'] = $this->cancellationmodel->get_cat_SubCategory($catid);

        $return['pagename'] = "utilities/supportTextDriverSubCategory";
        $this->load->view("company", $return);
    }

    public function getDescription($cat_id = '',$languageCode='') {

        $return['desc'] = $this->cancellationmodel->getDescription($cat_id,$languageCode);
        $this->load->view("utilities/description", $return);
    }

    public function getsubDescription($cat_id = '', $subcatID = '',$languageCode='') {

        error_reporting(0);
        $return['desc'] = $this->cancellationmodel->getsubDescription($cat_id, $subcatID,$languageCode);
        $this->load->view("utilities/subdescription", $return);
    }

    function support_catCustomer($param2 = '', $param = '') {

        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->cancellationmodel->get_lan_hlpText();

        $return['helpText'] = '';
        if ($param2 == 0) {
            $return['edit_id'] = '';
            $return['cat_id'] = $param;
            $return['helpText'] = $this->cancellationmodel->get_cat_support($param, 'add');
        } else {
            
        }

        $return['pagename'] = "utilities/add_support_catCustomer";
        $this->load->view("company", $return);
    }

    function support_catDriver($param2 = '', $param = '') {

        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $return['language'] = $this->cancellationmodel->get_lan_hlpText();
        $return['helpText'] = '';
        if ($param2 == 0) {
            $return['edit_id'] = '';
            $return['cat_id'] = $param;
            $return['helpText'] = $this->cancellationmodel->get_cat_support($param, 'add');
        } else {
            
        }

        $return['pagename'] = "utilities/add_support_catDriver";
        $this->load->view("company", $return);
    }

    function support_editDriver($param = '', $param2 = '') {

        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['language'] = $this->cancellationmodel->get_lan_hlpText();

        if ($param2 == '') {
            $data['edit_id'] = $param;
            $data['scat_id'] = $param2;
        } else {
            
        }
        $data['helpText'] = $this->cancellationmodel->get_cat_support($param);

        $data['pagename'] = "utilities/edit_support_text_Driver";
        $this->load->view("company", $data);
    }

    function support_editCustomer($param = '', $param2 = '') {

        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['language'] = $this->cancellationmodel->get_lan_hlpText();

        if ($param2 == '') {
            $data['edit_id'] = $param;
            $data['scat_id'] = $param2;
        } else {
            
        }
        $data['helpText'] = $this->cancellationmodel->get_cat_support($param);

        $data['pagename'] = "utilities/edit_support_text_Customer";
        $this->load->view("company", $data);
    }

    function Subcat_editCustomer($param = '', $param2 = '',$param3='') {

        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['language'] = $this->cancellationmodel->get_lan_hlpText();
        if ($param2) {
            $data['edit_id'] = $param;
            $data['scat_id'] = $param2;
            $data['cat_id'] = $param3;
        } else {
            
        }
        $data['helpText'] = $this->cancellationmodel->get_subcat_support($param);

        $data['pagename'] = "utilities/Subcat_editCustomer";
        
        $this->load->view("company", $data);
    }

    function Subcat_editDriver($param = '', $param2 = '',$param3='') {

        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }
        $data['language'] = $this->cancellationmodel->get_lan_hlpText();

        if ($param2) {
            $data['edit_id'] = $param;
            $data['scat_id'] = $param2;
            $data['cat_id'] = $param3;
        } else {
            
        }
        $data['helpText'] = $this->cancellationmodel->get_subcat_support($param);

        $data['pagename'] = "utilities/Subcat_editDriver";
        $this->load->view("company", $data);
    }

    function get_subcat_support() {
        error_reporting(0);
        $this->load->library('mongo_db');
        $res['data'] = $this->mongo_db->where(array('cat_id' => (int) $this->input->post('cat_id')))->find_one('supportText');
        $res['langauge']=$this->cancellationmodel->get_lan_hlpText();
        echo json_encode($res);
    }

    function support_actionCustomer($param = '', $param2 = '') {
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }

        if ($param == 'subdel'){
            $this->cancellationmodel->actionCustomer($param, $param2);
        } else if ($param == 'del') {
            $this->cancellationmodel->actionCustomer($param, $param2);
            redirect(base_url() . "index.php?/utilities/supportTextCustomer");
            
        } else {
            if($param2!='')
            {
                $return['language'] = $this->cancellationmodel->support_actionCustomer();
                redirect(base_url() . "index.php?/utilities/supportTextCustomerSubCategory/".$param2);
            }
            else
            {
                $return['language'] = $this->cancellationmodel->support_actionCustomer();
                redirect(base_url() . "index.php?/utilities/supportTextCustomer");
            }
            
        }
        
    }
    
    function support_actionDriver($param = '', $param2 = '') {
        error_reporting(0);
        if ($this->session->userdata('table') != 'company_info') {
            redirect(base_url());
        }

        $this->load->library('mongo_db');
        if ($param == 'subdel'){
            $this->cancellationmodel->actionDriver($param, $param2);
        } else if ($param == 'del') {
            $this->cancellationmodel->actionDriver($param, $param2);
            redirect(base_url() . "index.php?/utilities/supportTextCustomer");
            
        } else {
            if($param2!='')
            {
                $return['language'] = $this->cancellationmodel->support_actionDriver();
                redirect(base_url() . "index.php?/utilities/supportTextDriverSubCategory/".$param2);
            }
            else
            {
                $return['language'] = $this->cancellationmodel->support_actionDriver();
                 redirect(base_url() . "index.php?/utilities/supportTextDriver");
            }
        }
       
    }

    function transection_data_ajax($reason, $reasonFor,$search_by_language = '')
    {
       if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->cancellationmodel->getlanguageData($reason, $reasonFor,$search_by_language);
    }
    
    function validatelanguagename()
    {
       if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->cancellationmodel->validatelanguagename();
    }
    function validatelanguagecode()
    {
       if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $this->cancellationmodel->validatelanguagecode();
    }
    
    public function getCustomerSupportLanguage() {

        
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->cancellationmodel->getCustomerSupportLanguage();
    }
    public function getSubCustomerSupportLanguage() {

        
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->cancellationmodel->getSubCustomerSupportLanguage();
    }
    
    
    public function getCancelResonsSupportLanguage() {

        
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->cancellationmodel->getCancelResonsSupportLanguage();
    }

}
