<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Sendnotificationmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }
    
    public function getDriversBySerach() {
        $this->load->library('mongo_db');
        $sSearch = $this->input->post('serachData');
        $sRegex = preg_quote($sSearch, '/');
        $searchTermsAny[] = array('firstName' => new MongoDB\BSON\Regex($sRegex, "i"));
        $searchTermsAny[] = array('lastName' => new MongoDB\BSON\Regex($sRegex, "i"));
        $searchTermsAny[] = array('email' => new MongoDB\BSON\Regex($sRegex, "i"));
        
        $searchTerms = array();
        $searchTerms['$or'] = $searchTermsAny;

        $mastersData =  $this->mongo_db->where($searchTerms)->get('masters');
        echo json_encode(array('data'=>$mastersData));
    }
    public function getCustomersBySerach() {
        $this->load->library('mongo_db');
        $sSearch = $this->input->post('serachData');
        $sRegex = preg_quote($sSearch, '/');
        $searchTermsAny[] = array('name' => new MongoDB\BSON\Regex($sRegex, "i"));
        $searchTermsAny[] = array('email' => new MongoDB\BSON\Regex($sRegex, "i"));
        
        $searchTerms = array();
        $searchTerms['$or'] = $searchTermsAny;

        $mastersData =  $this->mongo_db->where($searchTerms)->get('slaves');
        echo json_encode(array('data'=>$mastersData));
    }

    public function datatable_Sendnotification() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "";
        $_POST['mDataProp_1'] = "name";
        $_POST['mDataProp_2'] = "mobile";

        $respo = $this->datatables->datatable_mongodb('abc');
        $aaData = $respo["aaData"];
        $datatosend = array();

        $index = 1;
        foreach ($aaData as $value) {
            $arr = array();

            $arr[] = $index++;
            $arr[] = $value['name'];
            $arr[] = $value['mobile'];
//            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['pushTopic'] . '">';


            $datatosend[] = $arr;
        }


        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
    
    public function datatable_SendToDrivers() {
       $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        
        
        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "firstName";
        $_POST['mDataProp_1'] = "email";
        $_POST['mDataProp_2'] = "mobile";

        $respo = $this->datatables->datatable_mongodb('masters');
        $aaData = $respo["aaData"];
        $datatosend = array();

        $index = 1;
        foreach ($aaData as $value) {
            $arr = array();

            $arr[] = $index++;
            $arr[] = $value['firstName']. ' '.$value['lastName'];
            $arr[] = $value['email'];
            $arr[] = $value['mobile'];
//            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['pushTopic'] . '">';


            $datatosend[] = $arr;
        }


        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
    public function datatable_SendToCustomers() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        
        
        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "email";
        $_POST['mDataProp_2'] = "phone";

        $respo = $this->datatables->datatable_mongodb('slaves');
        $aaData = $respo["aaData"];
        $datatosend = array();

        $index = 1;
        foreach ($aaData as $value) {
            $arr = array();

            $arr[] = $index++;
            $arr[] = $value['name'];
            $arr[] = $value['email'];
            $arr[] = $value['phone'];
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['pushTopic'] . '">';


            $datatosend[] = $arr;
        }


        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

 
}
