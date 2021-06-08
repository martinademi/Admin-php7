<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class StoreCustomer extends CI_Controller {

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
        $this->load->model("StoreCustomermodel");
        
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('headerNav_lang',$language);
        $this->lang->load('storeCustomer_lang', $language);

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index() {
        //print_r($this->session->userdata["badmin"]['BizId']);
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
        // $this->table->set_heading($this->lang->line('col_slno'), $this->lang->line('col_name'), $this->lang->line('col_mobile'), $this->lang->line('col_email'),$this->lang->line('col_city'),$this->lang->line('col_orderCount'),$this->lang->line('col_totalRevenue'),$this->lang->line('col_action'));
        $this->table->set_heading($this->lang->line('col_slno'), $this->lang->line('col_name'), $this->lang->line('col_mobile'), $this->lang->line('col_email'),$this->lang->line('col_city'),$this->lang->line('col_orderCount'),$this->lang->line('col_totalRevenue'));

        $data['pagename'] = "admin/storecustomer";
        $this->load->view("SuperAdmin_Dashbord", $data);
    }
    public function getCustomerCount() {
        $this->StoreCustomermodel->getCustomerCount();
    }
    public function getDeviceLogs($userType = '') {
        $this->StoreCustomermodel->getDeviceLogs($userType);
    }

    public function dt_passenger($status) {
 
        $this->StoreCustomermodel->dt_passenger($status,$this->session->userdata["badmin"]['BizId']);
    }
    public function profile($id = '') {
        $return['data'] = $this->StoreCustomermodel->getCustomer($id);  
        $return['cid'] = $id;
        $return['pagename'] = 'customer/profile';  
        $this->load->view("company", $return);
    }
    public function save_driver_data() {
        $this->StoreCustomermodel->save_driver_data();
        
    }
    
     public function rejectCustomers() {


        $data['result'] = $this->StoreCustomermodel->rejectCustomers();
    }
     public function banCustomer() {


        $data['result'] = $this->StoreCustomermodel->banCustomer();
    }
    public function activateRejectedCustomer() {

     
        $data['result'] = $this->StoreCustomermodel->activateRejectedCustomer();
    }
    public function activepassengers() {

     
        $data['active'] = $this->StoreCustomermodel->activepassengers();
    }
    public function deletepassengers() {

        $data['deleted'] = $this->StoreCustomermodel->deletepassengers();
    }
    public function uploadMMJCard() {

        $data['uploadCard'] = $this->StoreCustomermodel->uploadMMJCard();
    }
    public function rejectMMJCard() {

        $data['rejectCard'] = $this->StoreCustomermodel->rejectMMJCard();
    }
    public function approveMMJCard() {

        $data['approveCard'] = $this->StoreCustomermodel->approveMMJCard();
    }
    public function uploadSIICard() {

        $data['uploadSIICard'] = $this->StoreCustomermodel->uploadSIICard();
    }
    public function rejectSIICard() {

        $data['rejectSIICard'] = $this->StoreCustomermodel->rejectSIICard();
    }
    public function approveSIICard() {

        $data['approveSIICard'] = $this->StoreCustomermodel->approveSIICard();
    }

    /*Change password from admin side. No verification required*/
    public function adminUpdateUserPassword(){
        $userId = trim($this->input->post('userId'));
        $password = $this->input->post('password');
        // var_dump($userId);
        // var_dump($password);
        if (empty($userId) || empty($password)) {
        echo json_encode(array('status' => false, 'message' => 'Unable to update . Plese try again'));
        }
        $this->StoreCustomermodel->adminUpdateUserPassword($userId, $password);
    }

     
    

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */