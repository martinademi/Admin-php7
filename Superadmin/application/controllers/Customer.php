<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends CI_Controller {

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
        $this->load->model("Customermodel");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
$this->lang->load('header_lang',$language); 


        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index() {
       
        $data['status'] = 2;

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
        $this->table->set_heading('SL NO.', 'NAME', 'MOBILE', 'EMAIL','CITY','APP VERSION',/*'APPROVED DATE',*/ 'REGISTERED DATE',/* 'REJECTED DATE', */'BAN DATE','REASON','DEVICE ID', 'DEVICE MAKE', 'DEVICE MODEL', 'REGISTRATION DATE','LOCATION','LAST ACTIVE','Action','CREDIT SETTINGS',$checkbox);


        $data['pagename'] = "customer/customer";
        $this->load->view("company", $data);
    }
    public function getCustomerCount() {
        $this->Customermodel->getCustomerCount();
    }
    public function getDeviceLogs($userType = '') {
        $this->Customermodel->getDeviceLogs($userType);
    }

    public function dt_passenger($status) {
 
        $this->Customermodel->dt_passenger($status);
    }
    public function profile($id = '') {
        $return['data'] = $this->Customermodel->getCustomer($id);  
        $return['cid'] = $id;
        $return['pagename'] = 'customer/profile';  
        $this->load->view("company", $return);
    }
    public function save_driver_data() {
        $this->Customermodel->save_driver_data();
        
    }
    
     public function rejectCustomers() {


        $data['result'] = $this->Customermodel->rejectCustomers();
    }
     public function banCustomer() {


        $data['result'] = $this->Customermodel->banCustomer();
    }
    public function activateRejectedCustomer() {

     
        $data['result'] = $this->Customermodel->activateRejectedCustomer();
    }
    public function activepassengers() {

     
        $data['active'] = $this->Customermodel->activepassengers();
    }
    public function deletepassengers() {

        $data['deleted'] = $this->Customermodel->deletepassengers();
    }
    public function uploadMMJCard() {

        $data['uploadCard'] = $this->Customermodel->uploadMMJCard();
    }
    public function rejectMMJCard() {

        $data['rejectCard'] = $this->Customermodel->rejectMMJCard();
    }
    public function approveMMJCard() {

        $data['approveCard'] = $this->Customermodel->approveMMJCard();
    }
    public function uploadSIICard() {

        $data['uploadSIICard'] = $this->Customermodel->uploadSIICard();
    }
    public function rejectSIICard() {

        $data['rejectSIICard'] = $this->Customermodel->rejectSIICard();
    }
    public function approveSIICard() {

        $data['approveSIICard'] = $this->Customermodel->approveSIICard();
    }

    /*Change password from admin side. No verification required*/
    public function adminUpdateUserPassword(){
        $userId = $this->input->post('userId');
        $password = $this->input->post('password');
        if (empty($userId) || empty($password)) {
        echo json_encode(array('status' => false, 'message' => 'Unable to update . Plese try again'));
        }
        $this->Customermodel->adminUpdateUserPassword($userId, $password);
    }

    public function operations($operation = '',$id = '') {
        switch ($operation) {
            case 'enDisCredit':$this->Customermodel->enDisCreditCustomer();
                 break;
            case 'getWallet':$this->Customermodel->getWalletForShipper();
                 break;
            case 'walletUpdate':$this->Customermodel->walletUpdateForShipper();
                break;
        }
    }

     
    

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */