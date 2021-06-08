<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class WebsitePagesmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
    }

    public function getLanguages() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->get('lang_hlp');
        return $getAll;
    }

    public function getTermsAndConditions() {
        $my_file = 'supportText/provider/en_termsAndConditions.php';
        $handle = fopen($my_file, 'r');
        $driver['en'] = fread($handle, filesize($my_file));

        $my_file = 'supportText/customer/en_termsAndConditions.php';
        $handle = fopen($my_file, 'r');
        $customer['en'] = fread($handle, filesize($my_file));

        $langauage = $this->mongo_db->get('lang_hlp');

        foreach ($langauage as $lang) {

            if (isset($lang['code'])) {
                $my_file = 'supportText/provider/' . $lang['code'] . '_termsAndCondions.php';
                $handle = fopen($my_file, 'r');
                $driver[$lang['code']] = fread($handle, filesize($my_file));

                $my_file = 'supportText/customer/' . $lang['code'] . '_termsAndConditions.php';
                $handle = fopen($my_file, 'r');
                $customer[$lang['code']] = fread($handle, filesize($my_file));
            }
        }

        echo json_encode(array('driver' => $driver, 'customer' => $customer));
        return;
    }

    function updateTermsAndCondition() {

        if (!empty($_POST)) {

            if (!file_exists('supportText')) {
                mkdir('supportText/provider', 0777, true);
            }
            if (!file_exists('supportText/customer')) {
                mkdir('supportText/customer', 0777, true);
            }
            //terms and Conditions
            $myfile = fopen("supportText/provider/en_termsAndConditions.php", "w");
            $txt = $this->input->post('driverTC');
            fwrite($myfile, $txt);
            fclose($myfile);

            //terms and Conditions
            $myfile = fopen("supportText/customer/en_termsAndConditions.php", "w");
            $txt = $this->input->post('customerTC');
            fwrite($myfile, $txt);
            fclose($myfile);

            $langauage = $this->mongo_db->get('lang_hlp');

            foreach ($langauage as $lang) {

                if (isset($lang['code'])) {

                    $myfile = fopen('supportText/provider/' . $lang['code'] . '_termsAndCondions.php', "w");
                    $txt = $this->input->post($lang['code'] . '_driverTC');
                    fwrite($myfile, $txt);
                    fclose($myfile);

                    $myfile = fopen('supportText/customer/' . $lang['code'] . '_termsAndConditions.php', "w");
                    $txt = $this->input->post($lang['code'] . '_customerTC');
                    fwrite($myfile, $txt);
                    fclose($myfile);
                }
            }
        }
    }

    public function updateAboutUs() {
        $mongoArr = array(
            'question' => $this->input->post('question'),
            'visinor' => $this->input->post('visinor'),
            'investor' => $this->input->post('investor')
        );
        $appConfigAboutus = array("aboutUs"=>$mongoArr);
        $this->mongo_db->where(array())->set($mongoArr)->update('aboutUs', array('upsert' => TRUE));
        $this->mongo_db->where(array())->set($appConfigAboutus)->update('appConfig');
        $aboutUs = $this->mongo_db->where(array())->find_one('aboutUs');
        echo json_encode($aboutUs);
        return;
    }

    public function getAboutUsData() {
        $aboutUs = $this->mongo_db->where(array())->find_one('aboutUs');
        echo json_encode($aboutUs);
        return;
    }

    function getCityList() {
        $getAll = $this->mongo_db->get('cities');
        return $getAll;
    }

    public function getPrivacyPolicy() {

        $my_file = 'supportText/provider/en_privacyPolicy.php';
        $handle = fopen($my_file, 'r');
        $driver['en'] = fread($handle, filesize($my_file));

        $my_file = 'supportText/customer/en_privacyPolicy.php';
        $handle = fopen($my_file, 'r');
        $customer['en'] = fread($handle, filesize($my_file));

        $langauage = $this->mongo_db->get('lang_hlp');

        foreach ($langauage as $lang) {

            if (isset($lang['code'])) {
                $my_file = 'supportText/provider/' . $lang['code'] . '_privacyPolicy.php';
                $handle = fopen($my_file, 'r');
                $driver[$lang['code']] = fread($handle, filesize($my_file));

                $my_file = 'supportText/customer/' . $lang['code'] . '_privacyPolicy.php';
                $handle = fopen($my_file, 'r');
                $customer[$lang['code']] = fread($handle, filesize($my_file));
            }
        }

        echo json_encode(array('driver' => $driver, 'customer' => $customer));
        return;
    }

    function updatePrivacyPolicy() {

        if (!empty($_POST)) {
            if (!file_exists('supportText')) {
                mkdir('supportText/provider', 0777, true);
            }
            if (!file_exists('supportText/customer')) {
                mkdir('supportText/customer', 0777, true);
            }

            //terms and Conditions
            $myfile = fopen("supportText/provider/en_privacyPolicy.php", "w");
            $txt = $this->input->post('driverPP');
            fwrite($myfile, $txt);
            fclose($myfile);

            //terms and Conditions
            $myfile = fopen("supportText/customer/en_privacyPolicy.php", "w");
            $txt = $this->input->post('customerPP');
            fwrite($myfile, $txt);
            fclose($myfile);

            $langauage = $this->mongo_db->get('lang_hlp');

            foreach ($langauage as $lang) {

                if (isset($lang['code'])) {

                    $myfile = fopen('supportText/provider/' . $lang['code'] . '_privacyPolicy.php', "w");
                    $txt = $this->input->post($lang['code'] . '_driverPP');
                    fwrite($myfile, $txt);
                    fclose($myfile);

                    $myfile = fopen('supportText/customer/' . $lang['code'] . '_privacyPolicy.php', "w");
                    $txt = $this->input->post($lang['code'] . '_customerPP');
                    fwrite($myfile, $txt);
                    fclose($myfile);
                }
            }
        }
    }

    function datatable_driverreview($status = '', $cityId = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "bookingId";
        $_POST['mDataProp_1'] = "providerData.firstName";
        $_POST['mDataProp_2'] = "cityName";
        if ($cityId && $cityId != "0") {
            $respo = $this->datatables->datatable_mongodb('bookings', array('cityId' => new MongoDB\BSON\ObjectID($cityId), 'status' => 10, 'reviewByProvider' => array('$exists' => TRUE), 'reviewByProvider.review' => array('$ne' => "")));
        } else {

            $respo = $this->datatables->datatable_mongodb('bookings', array('status' => 10, 'reviewByProvider' => array('$exists' => TRUE), 'reviewByProvider.review' => array('$ne' => "")));
        }
        $aaData = $respo["aaData"];
        $datatosend = array();
        foreach ($aaData as $value) {

            $setCreditEn = ($value['reviewByProvider']['webStatus'] == "1") ? 'checked' : '';
            $pdata = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['providerId'])))->find_one('provider');
            $sdata = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['slaveId'])))->find_one('slaves');
            $arr = array();
            $arr[] = '<a target="_blank" href="' . base_url() . 'index.php?/Accounting/trip_details/' . $value['bookingId'] . '">' . $value['bookingId'] . '</a>';
            $arr[] = date('j-M-Y H:i:s', $value['bookingRequestedAt'] - ((int) $_COOKIE['timeOffset'] * 60));
            $arr[] = '<a style="cursor: pointer;" id="driverID' . $value['providerId'] . '"  class="getDriverDetails" mas_id="' . $value['providerId'] . '">' . $value['providerData']['firstName'] . '</a>';
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slaveId'] . '">' . $value['customerData']['firstName'] . '</a>';
            $arr[] = $value['reviewByProvider']['review'] ? $value['reviewByProvider']['review'] : 'N/A';
            $arr[] = $value['reviewByProvider']['rating'] ? $value['reviewByProvider']['rating'] : 'N/A';
            $arr[] = '<div class="switch" data-id="' . $value['_id']['$oid'] . '" style="margin-top: 14px;float: left;"><input id="' . $value['_id']['$oid'] . '"  class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;" ' . $setCreditEn . '><label for="' . $value['_id']['$oid'] . '"></label></div>';
            $arr[] = $value['cityName'];
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_customerReview($status = '', $cityId = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "bookingId";
        $_POST['mDataProp_1'] = "providerData.firstName";
        $_POST['mDataProp_2'] = "cityName";
        if ($cityId && $cityId != "0") {
            $respo = $this->datatables->datatable_mongodb('bookings', array('cityId' => new MongoDB\BSON\ObjectID($cityId), 'status' => 10, 'reviewByCustomer' => array('$exists' => TRUE), 'reviewByCustomer.review' => array('$ne' => "")));
        } else {
            $respo = $this->datatables->datatable_mongodb('bookings', array('status' => 10, 'reviewByCustomer' => array('$exists' => TRUE), 'reviewByCustomer.review' => array('$ne' => "")));
        }
        $aaData = $respo["aaData"];
        $datatosend = array();
        foreach ($aaData as $value) {
            $setCreditEn = ($value['reviewByCustomer']['webStatus'] == "1") ? 'checked' : '';
            $pdata = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['providerId'])))->find_one('provider');
            $sdata = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['slaveId'])))->find_one('slaves');
            $arr = array();
            $arr[] = '<a target="_blank" href="' . base_url() . 'index.php?/Accounting/trip_details/' . $value['bookingId'] . '">' . $value['bookingId'] . '</a>';
            $arr[] = date('j-M-Y H:i:s', $value['bookingRequestedAt'] - ((int) $_COOKIE['timeOffset'] * 60));
            $arr[] = '<a style="cursor: pointer;" id="driverID' . $value['providerId'] . '"  class="getDriverDetails" mas_id="' . $value['providerId'] . '">' . $value['providerData']['firstName'] . '</a>';
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slaveId'] . '">' . $value['customerData']['firstName'] . '</a>';
            $arr[] = $value['reviewByCustomer']['review'] ? $value['reviewByCustomer']['review'] : 'N/A';
            $arr[] = $value['reviewByCustomer']['rating'] ? $value['reviewByCustomer']['rating'] : 'N/A';
            $arr[] = '<div class="switch" data-id="' . $value['_id']['$oid'] . '" style="margin-top: 14px;float: left;"><input id="' . $value['_id']['$oid'] . '"  class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;" ' . $setCreditEn . '><label for="' . $value['_id']['$oid'] . '"></label></div>';
            $arr[] = $value['cityName'];
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function viewWebsiteUpadateCustomer() {
        $id = $this->input->post('id');
        $updateArray = array("reviewByCustomer.webStatus" => $this->input->post('flag'));
        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($updateArray)->update('bookings');
    }

    function viewWebsiteUpadateProvider() {
        $id = $this->input->post('id');
        $updateArray = array("reviewByProvider.webStatus" => $this->input->post('flag'));
        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($updateArray)->update('bookings');
    }

}
