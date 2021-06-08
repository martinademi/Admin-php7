<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');

        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

   public function AuthenticateUser() {
        $this->load->model("Loginmodel");
        $status = $this->Loginmodel->ValidateSuperAdmin();
        if ($status) {
            redirect(base_url() . "index.php?/Dashboard/loadDashbord");
        } else {
            $loginerrormsg = "invalid email or password";
            $this->index($loginerrormsg);
        }
    }

    public function FromAdmin($param = '') {
        if ($param != '') {
            $this->load->model("Loginmodel");
            $this->Loginmodel->SetSeesionFromAdmin($param);
            redirect(base_url()."index.php?/Dashboard/loadDashbord");
        }
    }
}
