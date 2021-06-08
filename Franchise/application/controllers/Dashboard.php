<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');

        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
 function issessionset() {
        if ($this->session->userdata('fadmin')['MasterBizId']) {
            return true;
        }
        return false;
    }
  

    public function loadDashbord() {

        if ($this->issessionset()) {
            $this->load->model("Dashboardmodal");
            $data['dashborddata'] = $this->Dashboardmodal->getDashbordData($this->session->userdata('fadmin')['MasterBizId']);
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['pagename'] = "Dashboard/V_AdminList";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/superadmin");
    }


}
