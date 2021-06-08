<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Sendnotification_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getDriversBySerach() {
        $this->load->library('mongo_db');
        $sSearch = $this->input->post('serachData');
        $sRegex = preg_quote($sSearch, '/');
        $searchTermsAny[] = array('firstName' => new MongoDB\BSON\Regex($sRegex, "i"));
        $searchTermsAny[] = array('lastName' => new MongoDB\BSON\Regex($sRegex, "i"));
        $searchTermsAny[] = array('email' => new MongoDB\BSON\Regex($sRegex, "i"));
        $searchTermsAny[] = array('mobile' => new MongoDB\BSON\Regex($sRegex, "i"));
        
        $searchTerms = array();
        $searchTerms['$or'] = $searchTermsAny;

        $mastersData =  $this->mongo_db->where($searchTerms)->get('driver');
        echo json_encode(array('data'=>$mastersData));
    }
    public function getCustomersBySerach() {
        $this->load->library('mongo_db');
        $sSearch = $this->input->post('serachData');
        $sRegex = preg_quote($sSearch, '/');
        $searchTermsAny[] = array('name' => new MongoDB\BSON\Regex($sRegex, "i"),'status' => array('$in' => [0, 2]));
        $searchTermsAny[] = array('email' => new MongoDB\BSON\Regex($sRegex, "i"),'status' => array('$in' => [0, 2]));
        $searchTermsAny[] = array('phone' => new MongoDB\BSON\Regex($sRegex, "i"),'status' => array('$in' => [0, 2]));
        
        $searchTerms = array();
        $searchTerms['$or'] = $searchTermsAny;

        $mastersData =  $this->mongo_db->where($searchTerms)->get('customer');
        echo json_encode(array('data'=>$mastersData));
    }
    public function getStoreManagerBySerach() {
        $this->load->library('mongo_db');
        $sSearch = $this->input->post('serachData');
        $sRegex = preg_quote($sSearch, '/');
        $searchTermsAny[] = array('name' => new MongoDB\BSON\Regex($sRegex, "i"));
        $searchTermsAny[] = array('email' => new MongoDB\BSON\Regex($sRegex, "i"));
        
        $searchTerms = array();
        $searchTerms['$or'] = $searchTermsAny;

        $mastersData =  $this->mongo_db->where($searchTerms)->get('storeManagers');
        echo json_encode(array('data'=>$mastersData));
    }
    
    // public function getCities() {
    //     $this->load->library('mongo_db');
    //    // $cities =  $this->mongo_db->where(array('isDeleted'=>false))->get('cities');
    //    $data = $this->mongo_db->get('cities');
    //     $areaZones =  $this->mongo_db->get('areaZones');
    //     echo json_encode(array('cities'=>$cities,'areaZones'=>$areaZones));
    //     return;
    // }

    function getCities() {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->get('cities');
        $res = array();
        foreach ($data as $cities) {

            foreach ($cities['cities'] as $city) {
                if($city['isDeleted']==FALSE){
                 
                $res[] = $city;
                }
            }
        }
        $areaZones =  $this->mongo_db->get('zones');

        echo json_encode(array('cities'=>$res,'areaZones'=>$areaZones));
        return $res;
    }

   
    
    public function datatable_getPushDetails($userType = '') {
       $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        
        
//        $_POST['iColumns'] = 3;
//        $_POST['mDataProp_0'] = "firstName";

        $respo = $this->datatables->datatable_mongodb('fcmNotification',array('userTypeStatus'=>(int)$userType));
        $aaData = $respo["aaData"];
        $datatosend = array();

        $index = 1;
        foreach ($aaData as $value) {
            
                       //Mask the email and phone for demo user
//            if ($this->session->userdata('maskEmail') == TRUE) {
//                $value['email'] = $this->maskFileds($value['email'], 1);
//                $value['countryCode'] = $this->maskFileds($value['countryCode'] . $value['mobile'], 2);
//                $value['mobile'] = '';
//            }
            $arr = array();

           
            $arr[] = $value['notificationTypeMsg'];
            $arr[] = date('d-m-Y g:i:s A',$value['createdTimeStamp']- ($this->session->userdata('timeOffset') * 60));
            $arr[] = $value['title'];
            $arr[] = $value['body'];
            $datatosend[] = $arr;
        }


        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
     function maskFileds($string, $emailOrPohne) {
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
    }
    public function datatable_SendToCustomers() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        
        
        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "email";
        $_POST['mDataProp_2'] = "phone";

//        $respo = $this->datatables->datatable_mongodb('slaves');
        $aaData = $respo["aaData"];
        $datatosend = array();

        $index = 1;
        foreach ($aaData as $value) {
            
                 //Mask the email and phone for demo user
            if ($this->session->userdata('maskEmail') == TRUE) {
                $value['email'] = $this->maskFileds($value['email'], 1);
                $value['countryCode'] = $this->maskFileds($value['countryCode'] . $value['phone'], 2);
                $value['phone'] = '';
            }
            $arr = array();

            $arr[] = $index++;
            $arr[] = $value['name'];
            $arr[] = $value['email'];
            $arr[] = $value['countryCode'].$value['phone'];
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['pushTopic'] . '">';


            $datatosend[] = $arr;
        }


        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

 
}
