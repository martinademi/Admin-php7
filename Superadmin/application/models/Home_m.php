<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");


class Home_m extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('CallAPI');
    }

    function maskFileds($string, $emailOrPohne) {
        
        $emailSession=$this->session->userdata('emailMask');
        if($emailSession=="on"){
             //If email 
            if ($emailOrPohne == 1) {
                $r = explode('@', $string);
                $len = strlen(substr($r[0], 1));
                $replaceChar = "";
                for ($i = 0; $i < $len; $i++)
                    $replaceChar .= "*";
                return substr($r[0], 0, 1) . $replaceChar . '@' . $r[1];
            }//phone
            else {

                $len = strlen($string);
                $replaceChar = "";
                for ($i = 5; $i < $len; $i++)
                    $replaceChar .= "*";
                return substr($string, 0, 5) . $replaceChar;
            }
        }else{
            return $string;
        }
        
       
    }

}

?>