<?php

class AppConfigModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('CallAPI');
    }
    function getAppConfig() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->get('appConfig');
        return $getAll;
    }
}
