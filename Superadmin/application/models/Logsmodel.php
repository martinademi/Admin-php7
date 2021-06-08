<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");
date_default_timezone_set('Asia/Kolkata');

//require_once 'superModel/S3.php';
//require_once 'superModel/StripeModuleNew.php';
//require_once 'superModel/AwsPush.php';

class Logsmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('CallAPI');
        $this->load->model("Home_m"); 
    }

    function smsLog() {
        $this->load->library('Datatables');
        $this->load->library('table');

        $url = APILink . 'logs/sms';
        $response = json_decode($this->callapi->CallAPI('GET', $url), true);

        $slno = 0;
        foreach ($response['data'] as $sms) {
          
          
            $arr[] = array(++$slno, $this->Home_m->maskFileds($sms['to'], 2), $sms['msg'], $sms['trigger'], $sms['status'], date('j-M-Y g:i A', $sms['createDate']));
        }
        if ($this->input->post('sSearch') != '') {

            $FilterArr = array();
            foreach ($arr as $row) {
                $needle = ucwords($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle) {
                            return strpos(ucwords($var), $needle) !== false;
                        }));
                if (!empty($ret)) {
                    $FilterArr [] = $row;
                }
            }
            echo $this->datatables->getdataFromMongo($FilterArr);
        }

        if ($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($arr);
    }

    function stripeLog() {
        $this->load->library('Datatables');
        $this->load->library('table');

        $url = APILink . 'logs/stripe';
        $response = json_decode($this->callapi->CallAPI('GET', $url), true);
//        print_r($response['data']);
//        die;
        $slno = 0;
        foreach ($response['data'] as $sms) {


            $arr[] = array(++$slno, $sms['to'], $sms['msg'], $sms['trigger'], $sms['status'], date('j-M-Y g:i A', $sms['createDate']));
        }
        if ($this->input->post('sSearch') != '') {

            $FilterArr = array();
            foreach ($arr as $row) {
                $needle = ucwords($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle) {
                            return strpos(ucwords($var), $needle) !== false;
                        }));
                if (!empty($ret)) {
                    $FilterArr [] = $row;
                }
            }
            echo $this->datatables->getdataFromMongo($FilterArr);
        }

        if ($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($arr);
    }

    function emailLog() {
        $this->load->library('Datatables');
        $this->load->library('table');

        $url = APILink . 'logs/email';
        $response = json_decode($this->callapi->CallAPI('GET', $url), true);
//        print_r($response['data']);
//        die;
        $slno = 0;
        foreach ($response['data'] as $sms) {


            $arr[] = array(++$slno, $this->Home_m->maskFileds($sms['to'], 1), $sms['subject'], $sms['trigger'], $sms['status'], date('j-M-Y g:i A', $sms['createDate']));
        }
        if ($this->input->post('sSearch') != '') {

            $FilterArr = array();
            foreach ($arr as $row) {
                $needle = ucwords($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle) {
                            return strpos(ucwords($var), $needle) !== false;
                        }));
                if (!empty($ret)) {
                    $FilterArr [] = $row;
                }
            }
            echo $this->datatables->getdataFromMongo($FilterArr);
        }

        if ($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($arr);
    }

    function claimsLog() {

        $url = APILink . "allCalims";

        $claimLogs = $this->callapi->CallAPI('GET', $url);


        return $claimLogs['data'];
    }

    function inputTripLogs() {

        $url = APILink . "allInputTripLogs";

        $claimLogs = $this->callapi->CallAPI('GET', $url, array(), TRUE);


        return $claimLogs['data'];
    }

}

?>
