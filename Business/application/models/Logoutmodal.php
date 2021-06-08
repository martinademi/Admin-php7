<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}

class Logoutmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }
    function logout(){
      if ($this->session->userdata('table') != 'company_info') {
          redirect(base_url()."index.php?/Business");
      }
    } 
}

?>
