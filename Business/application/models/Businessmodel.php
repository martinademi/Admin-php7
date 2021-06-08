<?php

error_reporting(false);
if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}

require_once 'S3.php';

class Businessmodel extends CI_Model {

    public function __construct() {

        parent::__construct();
        $this->load->library('session');
        
        $this->load->library('mongo_db');
    }

    function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = '3embed softaware technologies';
        $secret_iv = '3embed 123456s';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    function get_zonelist($cityid = '') {

        $zones = $this->mongo_db->where(array('city_id' => $cityid))->get('zones');

        $res = array();
        foreach ($zones as $zone) {
            $res[] = $zone;
        }

        return $res;
    }

    function getZones() {

        $zones = $this->mongo_db->get('zones');

        return $zones;
    }

    function update_tslot() {

        $this->load->library('mongo_db');
        $week = $this->input->post('day');
        $BusinessId = $this->input->post('businessId');
        $status = $this->input->post('status');

        $data = json_decode(stripslashes($_POST['slot_time']));

        if ($week == 1) {
            $dayofweeek = 'Monday';
        } else if (($week == 2)) {
            $dayofweeek = 'Tuesday';
        } else if (($week == 3)) {
            $dayofweeek = 'Wednesday';
        } else if (($week == 4)) {
            $dayofweeek = 'Thursday';
        } else if (($week == 5)) {
            $dayofweeek = 'Friday';
        } else if (($week == 6)) {
            $dayofweeek = 'Saturday';
        } else {
            $dayofweeek = 'Sunday';
        }

        foreach ($data as $val)
            $dayof[$val->slot] = array('from' => $val->From, 'to' => $val->To);

        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($BusinessId)))->push(array('WorkingHours.' . $dayofweeek => $dayof, 'driver_type' => $status))->update('ProviderData');

        $row = $this->mongo_db->get('grocertime_config');

        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row['_id']['$oid'])))->set(array('flag' => 0))->update('grocertime_config');
    }

    function update_storetslot() {

        $this->load->library('mongo_db');
        $week = $this->input->post('day');
        $BusinessId = $this->input->post('businessId');
        $status = $this->input->post('status');

        $data = json_decode(stripslashes($_POST['slot_time']));

        if ($week == 1) {
            $dayofweeek = 'Monday';
        } else if (($week == 2)) {
            $dayofweeek = 'Tuesday';
        } else if (($week == 3)) {
            $dayofweeek = 'Wednesday';
        } else if (($week == 4)) {
            $dayofweeek = 'Thursday';
        } else if (($week == 5)) {
            $dayofweeek = 'Friday';
        } else if (($week == 6)) {
            $dayofweeek = 'Saturday';
        } else {
            $dayofweeek = 'Sunday';
        }

        foreach ($data as $val)
            $dayof[$val->slot] = array('from' => $val->From, 'to' => $val->To);

        $this->mongo_db->update(array('_id' => new MongoDB\BSON\ObjectID($BusinessId)))->push(array('StoreWorkingHours.' . $dayofweeek => $dayof, 'driver_type' => $status))->update('ProviderData');
    }

    function get_selectedcountry($countryid) {
        $this->load->library('mongo_db');
        $country = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($countryid)))->find_one('Country');
        return $country;
    }

    function get_selectedcity($cityid) {
        $this->load->library('mongo_db');
        $city = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($cityid)))->find_one('City');
        return $city;
    }

    function GetCountryCities() {
        $this->load->library('mongo_db');
        $country = $this->mongo_db->get("cities");
        $res = array();
        foreach ($country as $coun) {
            $res[] = $coun;
        }
        return $res;
    }

    function get_city() {
        $this->load->library('mongo_db');
        $countryid = $this->input->post('country');
        $CityId = $this->input->post('CityId');

        $country = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($countryid)))->find_one('cities');
        $entities = ' <select class="form-control" id="city" name="FData[City]"  required>
                                                <option value="0">Select City</option>';

        foreach ($country['cities'] as $cityData) {
            if ($CityId == $cityData['cityId']['$oid']) {
                $entities .= ' <option value="' . $cityData['cityId']['$oid'] . '" selected>' . $cityData['cityName'] . '</option>';
            } else {
                $entities .= ' <option value="' . $cityData['cityId']['$oid'] . '" >' . $cityData['cityName'] . '</option>';
            }
        }
        $entities .= ' </select>';

        return $entities;
    }

    function slot_timedata() {
        $this->load->library('mongo_db');
        $data1 = $this->mongo_db->get('timeslot');

        return $data1;
    }

    function storetime_config() {
        $this->load->library('mongo_db');
        $data1 = $this->mongo_db->get('storedriver_config');
        return $data1;
    }

    function grocertime_config() {
        $this->load->library('mongo_db');
        $data1 = $this->mongo_db->get('timeConfig');
        return $data1;
    }

    function get_lan_hlpText($param = '') {
        $this->load->library('mongo_db');
        if ($param == '')
            $res = $this->mongo_db->get('lang_hlp');
        else
            $res = $this->mongo_db->where(array('lan_id' => (int) $param))->find_one('lang_hlp');

        return $res;
    }

    function storecategoryData() {

        $country = $this->mongo_db->where(array("visibility" => 1))->get("storeCategory");
        foreach ($country as $coun) {
            $res[] = $coun;
        }
        return $res;
    }

    public function getSubcatList() {
        $val = $this->input->post('val');

        $cursor = $this->mongo_db->where(array("categoryId" => $val))->get('storeSubCategory');
        $res = array();
        foreach ($cursor as $d) {
            $res[] = $d;
        }

        echo json_encode($res);
    }

    function validateSuperAdmin() {

        $this->load->library('mongo_db');
        $this->load->library('CallAPI');

        $testEmail = $this->input->post("email");
        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $timeOffset = $this->input->post('timeOffset');
        
        $cursor = $this->mongo_db->where(array('ownerEmail' => $email, 'password' => $password,'status'=>array('$nin'=>[7])))->get('stores');
//        print_r($cursor); die;
        $Email = '';

        foreach ($cursor as $data) {
            $Email = $data['ownerEmail'];
            $pass = $data['password'];
            $ownername = $data['ownerName'];
            $MyId = $data['_id']['$oid'];
			$storeType = $data['storeType'];
            $ProfilePic = $data['profileLogos']['logoImage'];
            $name = $data['name'][0];
            $ImageFlag = $data['ImageFlag'];
            $Driver_session = $data['Driver_exist'];
            $CityDetails = $this->GetCity($data['cityId']);

            foreach ($CityDetails['cities'] as $cities) {
                if ($cities['cityId']['$oid'] == $data['cityId']) {
                    $currency = $cities['currencySymbol'];
                    $currencyShortHand= $cities['currency'];
                }
            }
            $pricing_status = $data['pricing_status'];
            $cityid = $data['cityId'];
            $countryid = $data['countryId'];

            $Businesszone = $data['Zonename'];
             /// call api for token
           $apidata['email'] = $Email;
           $apidata['password'] = $pass;
           $url = APILink .'admin/store/signIn';        
           $apiToken =""; 
           $response = json_decode($this->callapi->CallAPI('POST', $url, $apidata), true); 
           if($response['statusCode']==200){
                $apiToken = $response['data']['token'];
           }


            if ($Email == $testEmail) {
                $sessiondata = array(
                    'emailid' => $Email,
					'storeType'=>$storeType,
                    'BizId' => $MyId,
                    'validate' => true,
                    'profile_pic' => $ProfilePic,
                    'Currency' => $currency,
                    'CurrencyShortHand'=>$currencyShortHand,
                    'ImageFlag' => $ImageFlag,
                    'BusinessName' => $name,
                    'Ownername' => $ownername,
                    'currencySymbol'=>$currency,
                    'Businesszone' => $Businesszone,
                    'Driver' => $Driver_session,
                    'Admin' => '0',
                    'apiToken'=>$apiToken,
                    'timeOffset'=>  $timeOffset
                );
                $badmin = array('table'=>'company_info','badmin' => $sessiondata);
              
                $this->session->set_userdata($badmin);
                return $MyId;
            } else
                return false;
        }
    }

    function updateSession($bizId) {

        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($bizId)))->find_one('stores');
        $Email = $data['Email'];
        $ProfilePic = $data['profileLogos']['logoImage'];
        $pass = $data['Password'];
        $MyId = $data['_id']['$oid'];
        $ImageFlag = $data['ImageFlag'];
        $name = $data['name'][0];
        $ownername = $data['ownerName'];
        $Businesszone = $data['Zonename'];
        $CityDetails = $this->GetCity($data['cityId']);
        $timeOffset = $this->session->userdata('badmin')['timeOffset'];

        foreach ($CityDetails['cities'] as $cities) {
           if ($cities['cityId']['$oid'] == $data['cityId']) {
                $currency = $cities['currencySymbol'];
                $currencyShortHand= $cities['currency'];
            }
        }

      $admin= $this->session->userdata('badmin')['Admin'];  
      $apiToken =$this->session->userdata('badmin')['apiToken'];

    
        $sessiondata = array(
            'emailid' => $Email,
            'BizId' => $MyId,
            'validate' => true,
            'profile_pic' => $ProfilePic,
            'Currency' => $currency,
            'ImageFlag' => $ImageFlag,
            'BusinessName' => $name,
            'Ownername' => $ownername,
            'Businesszone' => $Businesszone,
            'Admin' =>  $admin,
            'CurrencyShortHand'=>$currencyShortHand,
             'currencySymbol'=>$currency,
            'apiToken'=>$apiToken,
            'timeOffset' => $timeOffset
        );
        // $sessiondata = array(
        //     'BizId' => $bizId,
        //     'validate' => true,
        //     'profile_pic' => $ProfilePic,
        //     'BusinessName' => $name,
        //     'Ownername' => $ownername,
        //     'ImageFlag' => $ImageFlag,
        //     'Currency' => $currency,
        //     'CurrencyShortHand'=>$currencyShortHand,
        //   //  'Admin' => '1'
        // );
        $badmin = array('table'=>'company_info','badmin' => $sessiondata);
        $this->session->set_userdata($badmin);

        return $MyId;
    }

    function changeOrder() {

        $this->load->library('mongo_db');
        $Curruntcountval = $this->mongo_db->get_one('ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))));
        $Prevecountval = $this->mongo_db->get_one('ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))));
        $currcount = (int) $Curruntcountval['count'];
        $prevcount = (int) $Prevecountval['count'];
        $this->mongo_db->update('ProductCategory', array('count' => $prevcount), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))));
        $this->mongo_db->update('ProductCategory', array('count' => $currcount), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))));
    }

    function CopyBusiness() {

        $this->load->library('mongo_db');
        $data = array();
        $id = '';
        $From = array('BizId' => '55dc782effba4e3556ad33a5', 'ProviderName' => 'Suvadee1');
        $CopyFrom = $From['BizId'];
        $MAsterData = $this->mongo_db->get_where('ProviderData', array("_id" => new MongoDB\BSON\ObjectID($CopyFrom)));
        foreach ($MAsterData as $Mas) {

            foreach ($Mas as $key => $val) {
                if ($key != '_id') {

                    $data[$key] = $val;
                }
                $id = new MongoDB\BSON\ObjectID();
                $data['_id'] = $id;
            }
        }
        $data['ProviderName'] = $From['ProviderName'];
        $this->mongo_db->insert('ProviderData', $data);
        $BizId = $id;
        $this->load->model('Msuperadmin');
        $this->Msuperadmin->copy_data_table('ProductCategory', 'ProductCategory', $CopyFrom, $BizId);
    }

    function changeSubCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->get_one('ProductSubCategory', array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))));
        $Prevecountval = $this->mongo_db->get_one('ProductSubCategory', array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))));

        $currcount = $Curruntcountval['count'];
        $prevcount = $Prevecountval['count'];

        $this->mongo_db->update('ProductSubCategory', array('count' => $prevcount), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))));
        $this->mongo_db->update('ProductSubCategory', array('count' => $currcount), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))));
    }

    function changeProductCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->get_one('products', array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))));
        $Prevecountval = $this->mongo_db->get_one('products', array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))));

        $currcount = $Curruntcountval['count'];
        $prevcount = $Prevecountval['count'];
        $this->mongo_db->update('products', array('count' => $prevcount), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))));
        $this->mongo_db->update('products', array('count' => $currcount), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))));
    }

    function get_product_count($bizid = '') {

        $this->load->library('mongo_db');

        $array = $this->mongo_db->where(array('BusinessId' => $bizid))->get('products');
        $count = 0;
        foreach ($array as $total) {
            $count++;
        }
        $count++;

        return $count;
    }

    public function GetCity($cityid = '') {
        $this->load->library('mongo_db');
        if ($cityid != NULL)
            $query = $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($cityid)))->find_one('cities');
           
        return $query;
    }

    /*   status -> 0 = new
     *             1 = accepted
     *             2 = rejected
     *             3 =  online
     *              4 = offline
     *              5 = booked */

    public function datatable_drivers($d = '', $status = '') {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');
//        print_r($d);
//        print_r($status);
//     
//        foreach ($id as $d) {

        if ($status == 0) {
            $Status = 1;
//                $whererc = "m.status IN ('" . (int) $Status . "') and m.businessid = '" . $d . "' ";

            $whererc = array('$and' => array(array('acc_status' => (int) $Status), array('businessid' => $d)));
        } else if ($status == 1) {
            $Status = 3;
//                $whererc = "m.status IN ('" . (int) $Status . "') and m.businessid = '" . $d . "' ";
            $whererc = array('$and' => array(array('acc_status' => (int) $Status), array('businessid' => $d)));
        } else if ($status == 2) {
            $Status = 4;
//                $whererc = "m.status IN ('" . (int) $Status . "') and m.businessid = '" . $d . "' ";
            $whererc = array('$and' => array(array('acc_status' => (int) $Status), array('businessid' => $d)));
        } else if ($status == 3) {
//                       $Status = 1;
            $whererc = array('$and' => array(array('status' => (int) $status), array('businessid' => $d)));
            ;
        } else if ($status == 4) {
//                       $Status = 1;
            $whererc = array('$and' => array(array('status' => (int) $status), array('businessid' => $d)));
            ;
        } else if ($status == 5) {
//                       $Status = 1;
            $whererc = array('$and' => array(array('status' => 3), array("app_id" => array('$ne' => null)), array('businessid' => $d)));
        }
//         $qry = $this->db->query("select * from master where businessid = '" . $id . "'")->result();

        $array = $this->mongo_db->get_where('Drivers', $whererc);

        foreach ($array as $Drivdata) {

            $data[] = array($Drivdata['driverseqId'], ucwords($Drivdata['name']), $Drivdata['lname'], $Drivdata['phone'], $Drivdata['email'],
                "<input type='checkbox' class='checkbox' value='" . $Drivdata['_id'] . "'>");
//            echo '<pre>';
//            print_r($Drivdata);
        }

        $needle = $this->input->post('sSearch');
        if ($needle != '') {

            $FilterArr = array();
            foreach ($data as $row) {
                $search = strtoupper($needle);

                $ret = array_keys(array_filter($row, function($var) use ($search) {
                            return strpos(strtoupper(strtoupper($var)), $search) !== false;
                        }));
                if (!empty($ret)) {
                    $FilterArr[] = $row;
                }
            }

            echo $this->datatables->franchise_Data($FilterArr);
        }
        if ($needle == '')
            echo $this->datatables->franchise_Data($data);
//            echo $this->datatables->generate();
//         print_r($qry);
//     exit();  
//           return $qry;
//        }
    }

    public function datatableProducts() {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');


        $array = $this->mongo_db->get('childProducts');

        foreach ($array as $Drivdata) {
            $data[] = array();
        }

        $needle = $this->input->post('sSearch');
        if ($needle != '') {

            $FilterArr = array();
            foreach ($data as $row) {
                $search = strtoupper($needle);

                $ret = array_keys(array_filter($row, function($var) use ($search) {
                            return strpos(strtoupper(strtoupper($var)), $search) !== false;
                        }));
                if (!empty($ret)) {
                    $FilterArr[] = $row;
                }
            }

            echo $this->datatables->franchise_Data($FilterArr);
        }
        if ($needle == '')
            echo $this->datatables->franchise_Data($data);
    }

    function delete_Drivers($did = "") {
        $this->load->library('mongo_db');
        foreach ($did as $id) {

            $this->db->query("update master set businessid = '',status = 1  where mas_id ='" . $id . "' ");
        }
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => 'deleted successfully', 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => 'update failed', 'flag' => 1));
            return;
        }
    }

    function addNewDriverData($bid) {
        $this->load->library('mongo_db');
//        $this->load->database();

        $datai['first_name'] = $this->input->post('firstname');
        $datai['last_name'] = $this->input->post('lastname');
        $pass = $this->input->post('password');
        $datai['password'] = md5($pass);
        $datai['created_dt'] = $this->input->post('current_dt');
        $datai['type_id'] = 1;
        $datai['status'] = 1;

        $datai['email'] = $this->input->post('email');
        $datai['mobile'] = $this->input->post('mobile');
        $datai['zipcode'] = $this->input->post('zipcode');
        $datai['bank_country'] = $this->input->post('country_select');
        $datai['Routing_num'] = $this->input->post('route_num');
        $datai['Account_num'] = $this->input->post('bank_accnum');
        $datai['bank_name'] = $this->input->post('bankname');
        $businessid = $bid;

        foreach ($businessid as $Bid)
            $datai['businessid'] = $Bid;

        $expirationrc = $this->input->post('expirationrc');

        $expiration = $this->input->post('expiration');
//        $datai['company_id'] = $this->session->userdata('LoginId');

        $name = $_FILES["certificate"]["name"];

        $ext = substr($name, strrpos($name, '.') + 1); //explode(".", $name); # extra () to prevent notice //1  doctype
        $cert_name = (rand(1000, 9999) * time()) . '.' . $ext;

        $insurname = $_FILES["photos"]["name"];
        $ext1 = substr($insurname, strrpos($insurname, '.') + 1); //explode(".", $insurname);
        $insurance_name = (rand(1000, 9999) * time()) . '.' . $ext1;

        $carriagecert = $_FILES["passbook"]["name"];
        $ext2 = substr($carriagecert, strrpos($carriagecert, '.') + 1); //explode(".", $carriagecert); 2 doctype
        $carriage_name = (rand(1000, 9999) * time()) . '.' . $ext2;

        $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/Tebsenewtheme/pics/';
//        
//        echo $documentfolder;
//        exit();

        try {
            move_uploaded_file($_FILES['certificate']['tmp_name'], $documentfolder . $cert_name);
            if (move_uploaded_file($_FILES['photos']['tmp_name'], $documentfolder . $insurance_name)) {
                $this->uploadimage_diffrent_redulation($documentfolder . $insurance_name, $insurance_name, $_SERVER['DOCUMENT_ROOT'] . '/' . mainfolder . '/', $ext1);
            }
            move_uploaded_file($_FILES['passbook']['tmp_name'], $documentfolder . $carriage_name);
        } catch (Exception $ex) {
            print_r($ex);
            return false;
        }
        $datai['license_pic'] = base_url() . 'sadmin/../../pics/' . $cert_name;
        $datai['passbook'] = base_url() . 'sadmin/../../pics/' . $carriage_name;
        $datai['profile_pic'] = base_url() . 'sadmin/../../pics/' . $insurance_name;
//             $datai['profile_pic']=$carriage_name;
//        print_r($datai);
//        exit();
        $count = $this->mongo_db->get_where('counters', array('_id' => 'driverid'));
        foreach ($count as $c) {
            $drivseq = $c['seq'] + 1;
        }
        $this->mongo_db->update('counters', array('seq' => $drivseq), array('_id' => "driverid"));

        $DrivArr = array("businessid" => $datai['businessid'], "driverseqId" => (int) $drivseq, "name" => $datai['first_name'], "lname" => $datai['last_name'], "email" => strtolower($datai['email']), "password" => $pass,
            "type_id" => $datai['type_id'], "acc_status" => $datai['status'], "phone" => $datai['mobile'], "created_dt" => $datai['created_dt'], "last_active_dt" => '',
            "profilePic" => $datai['profile_pic'], 'lic_expiry_dt' => $expirationrc, "license_pic" => $datai['license_pic'], "bank_passbook" => $datai['passbook'], "bank_country" => $datai['bank_country'],
            "Account_num" => $datai['Account_num'], "Routing_num" => $datai['Routing_num'], "bank_name" => $datai['bank_name']);
//            print_r($DrivArr);
//            exit();
        $this->mongo_db->insert('Drivers', $DrivArr);
        $newdriverid = $this->db->insert_id();

        $docdetail = array('url' => $cert_name, 'expirydate' => date("Y-m-d", strtotime($expirationrc)), 'doctype' => 1, 'driverid' => $newdriverid);
        $this->db->insert('docdetail', $docdetail);
        $docdetails = array('url' => $carriage_name, 'expirydate' => date("Y-m-d", strtotime($expiration)), 'doctype' => 2, 'driverid' => $newdriverid);
        $this->db->insert('docdetail', $docdetails);

//        $this->load->library('mongo_db');
//        $curr_date = time();
//        $curr_gmt_dates = gmdate('Y-m-d H:i:s', $curr_date);
//        $curr_gmt_date = new MongoDate(strtotime($curr_gmt_dates));
//        $mongoArr = array("type" => 0, "user" => (int) $newdriverid, "name" => $datai['first_name'], "lname" => $datai['last_name'],
//            "location" => array(
//                "longitude" => 0,
//                "latitude" => 0
//            ), "image" => $carriage_name, "rating" => 0, 'status' => 1, 'email' => strtolower($datai['email']), 'dt' => $curr_gmt_date
//        );
//
//        $this->mongo_db->insert('location', $mongoArr);
        return true;
    }

    function Editdriver($val = '') {
        $this->load->library('mongo_db');
//        $this->load->database();
//            $this->load->library('mongo_db');
//        $driverid = $this->input->post('val');
        $masterdata = $this->mongo_db->get_one('Drivers', array('_id' => new MongoDB\BSON\ObjectID($val)));
//       print_r($data);
//       exit();
        return $masterdata;

//        $data['masterdata'] = $this->db->query("select * from master where mas_id ='" . $val . "' ")->result();
    }

    function editdriverdata($bid) {

//        $this->load->database();
        $this->load->library('mongo_db');
        $driverid = $this->input->post('driver_id');

        $first_name = $this->input->post('firstname');
        $last_name = $this->input->post('lastname');
        $pass = $this->input->post('password');
        $password = md5($pass);
        $created_dt = date('Y-m-d H:i:s', time());
        $type_id = 1;

        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $zipcode = $this->input->post('zipcode');
        $expirationrc = $this->input->post('expirationrc');
        $bank_country = $this->input->post('country_selected');
        $Routing_num = $this->input->post('route_num');
        $Account_num = $this->input->post('bank_accnum');
        $bank_name = $this->input->post('bankname');
        $businessid = $bid;
        foreach ($businessid as $Bid)
            $iid = $Bid;
//        $expiration = $this->input->post('expiration');
//        $datai['company_id'] = $this->session->userdata('LoginId');

        $name = $_FILES["certificate"]["name"];
//        print_r($name);
//        exit();
        if ($name != '') {
            $ext = substr($name, strrpos($name, '.') + 1); //explode(".", $name); # extra () to prevent notice //1  doctype
            $cert_name = (rand(1000, 9999) * time()) . '.' . $ext;
        }
        $insurname = $_FILES["photos"]["name"];
        $ext1 = substr($insurname, strrpos($insurname, '.') + 1); //explode(".", $insurname);
        $profilepic = (rand(1000, 9999) * time()) . '.' . $ext1;

        $carriagecert = $_FILES["passbook"]["name"];
        if ($carriagecert != '') {
            $ext2 = substr($carriagecert, strrpos($carriagecert, '.') + 1); //explode(".", $carriagecert); 2 doctype
            $carriage_name = (rand(1000, 9999) * time()) . '.' . $ext2;
        }
        $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/Tebsenewtheme/pics/';
//        print_r($documentfolder);
        try {
            move_uploaded_file($_FILES['certificate']['tmp_name'], $documentfolder . $cert_name);
            if (move_uploaded_file($_FILES['photos']['tmp_name'], $documentfolder . $profilepic)) {
                $this->uploadimage_diffrent_redulation($documentfolder . $profilepic, $profilepic, $_SERVER['DOCUMENT_ROOT'] . '/' . mainfolder . '/', $ext1);
            }
            move_uploaded_file($_FILES['passbook']['tmp_name'], $documentfolder . $carriage_name);

//               echo '1';
        } catch (Exception $ex) {
//                echo '2';
            print_r($ex);
            return false;
        }

        $license_pic = base_url() . 'sadmin/../../pics/' . $cert_name;
        $passbook_pic = base_url() . 'sadmin/../../pics/' . $carriage_name;
        $profile_pic = base_url() . 'sadmin/../../pics/' . $profilepic;
//             $datai['profile_pic']=$carriage_name;


        if ($insurname != '') {
            $driverdetails = array('name' => $first_name, 'lname' => $last_name, 'profilePic' => $profile_pic, 'license_pic' => $license_pic,
                'password' => $pass, 'created_dt' => $created_dt, 'type_id' => $type_id, 'phone' => $mobile, 'email' => $email,
                'lic_expiry_dt' => $expirationrc, "bank_passbook" => $passbook_pic, 'bank_country' => $bank_country, 'Routing_num' => $Routing_num, 'Account_num' => $Account_num, 'bank_name' => $bank_name);
        } else {
            $driverdetails = array('name' => $first_name, 'lname' => $last_name,
                'password' => $pass, 'created_dt' => $created_dt, 'type_id' => $type_id, 'phone' => $mobile, 'email' => $email,
                'lic_expiry_dt' => $expirationrc, 'bank_country' => $bank_country, 'Routing_num' => $Routing_num, 'Account_num' => $Account_num, 'bank_name' => $bank_name);
        }


        $this->mongo_db->update('Drivers', $driverdetails, array('_id' => new MongoDB\BSON\ObjectID($driverid)));


        if ($name != '') {
            $data = $this->db->query("select * from docdetail where driverid = '" . $driverid . "' and doctype = 1");


            if ($data->num_rows() > 0) {

                $docdetail = array('url' => $license_pic, 'expirydate' => date("Y-m-d", strtotime($expirationrc)));
                $this->db->where('driverid', $driverid);
                $this->db->where('doctype', 1);
                $this->db->update('docdetail', $docdetail);
            } else {
                $this->db->insert('docdetail', array('doctype' => 1, 'driverid' => $driverid, 'url' => $license_pic, 'expirydate' => date("Y-m-d", strtotime($expirationrc))));
            }
        }

        if ($carriagecert != '') {
            $data = $this->db->query("select * from docdetail where driverid = '" . $driverid . "' and doctype = 2");

            if ($data->num_rows > 0) {
                $docdet = array('url' => $carriage_name, 'expirydate' => date("Y-m-d", strtotime($expiration)));
                $this->db->where('driverid', $driverid);
                $this->db->where('doctype', 2);
                $this->db->update('docdetail', $docdet);
            } else {
                $this->db->insert('docdetail', array('doctype' => 2, 'driverid' => $driverid, 'url' => $carriage_name, 'expirydate' => date("Y-m-d", strtotime($expiration))));
            }
        }
//       

        $curr_date = time();
        $curr_gmt_dates = gmdate('Y-m-d H:i:s', $curr_date);
        $curr_gmt_date = new MongoDate(strtotime($curr_gmt_dates));

        if ($insurname != '')
            $mongoArr = array("name" => $first_name, "lname" => $last_name, "image" => $insurname);
        else
            $mongoArr = array("name" => $first_name, "lname" => $last_name);

        $this->mongo_db->update('location', $mongoArr, array('user' => $driverid));

//        $mail = new sendAMail($db1->host);
//        $err = $mail->sendMasWelcomeMail(strtolower($email), ucwords($firstname));


        return true;
    }

    function uploadimage_diffrent_redulation($file_to_open, $imagename, $servername, $ext) {

        list($width, $height) = getimagesize($file_to_open);

        $ratio = $height / $width;

        /* mdpi 36*36 */
        $mdpi_nw = 36;
        $mdpi_nh = $ratio * 36;

        $mtmp = imagecreatetruecolor($mdpi_nw, $mdpi_nh);

        if ($ext == "jpg" || $ext == "jpeg") {
            $new_image = imagecreatefromjpeg($file_to_open);
        } else if ($ext == "gif") {
            $new_image = imagecreatefromgif($file_to_open);
        } else if ($ext == "png") {
            $new_image = imagecreatefrompng($file_to_open);
        }
        imagecopyresampled($mtmp, $new_image, 0, 0, 0, 0, $mdpi_nw, $mdpi_nh, $width, $height);

        $mdpi_file = $servername . 'pics/mdpi/' . $imagename;

        imagejpeg($mtmp, $mdpi_file, 100);

        /* HDPI Image creation 55*55 */
        $hdpi_nw = 55;
        $hdpi_nh = $ratio * 55;

        $tmp = imagecreatetruecolor($hdpi_nw, $hdpi_nh);

        if ($ext == "jpg" || $ext == "jpeg") {
            $new_image = imagecreatefromjpeg($file_to_open);
        } else if ($ext == "gif") {
            $new_image = imagecreatefromgif($file_to_open);
        } else if ($ext == "png") {
            $new_image = imagecreatefrompng($file_to_open);
        }
        imagecopyresampled($tmp, $new_image, 0, 0, 0, 0, $hdpi_nw, $hdpi_nh, $width, $height);

        $hdpi_file = $servername . 'pics/hdpi/' . $imagename;

        imagejpeg($tmp, $hdpi_file, 100);

        /* XHDPI 84*84 */
        $xhdpi_nw = 84;
        $xhdpi_nh = $ratio * 84;

        $xtmp = imagecreatetruecolor($xhdpi_nw, $xhdpi_nh);

        if ($ext == "jpg" || $ext == "jpeg") {
            $new_image = imagecreatefromjpeg($file_to_open);
        } else if ($ext == "gif") {
            $new_image = imagecreatefromgif($file_to_open);
        } else if ($ext == "png") {
            $new_image = imagecreatefrompng($file_to_open);
        }
        imagecopyresampled($xtmp, $new_image, 0, 0, 0, 0, $xhdpi_nw, $xhdpi_nh, $width, $height);

        $xhdpi_file = $servername . 'pics/xhdpi/' . $imagename;

        imagejpeg($xtmp, $xhdpi_file, 100);

        /* xXHDPI 125*125 */
        $xxhdpi_nw = 125;
        $xxhdpi_nh = $ratio * 125;

        $xxtmp = imagecreatetruecolor($xxhdpi_nw, $xxhdpi_nh);

        if ($ext == "jpg" || $ext == "jpeg") {
            $new_image = imagecreatefromjpeg($file_to_open);
        } else if ($ext == "gif") {
            $new_image = imagecreatefromgif($file_to_open);
        } else if ($ext == "png") {
            $new_image = imagecreatefrompng($file_to_open);
        }
        imagecopyresampled($xxtmp, $new_image, 0, 0, 0, 0, $xxhdpi_nw, $xxhdpi_nh, $width, $height);

        $xxhdpi_file = $servername . 'pics/xxhdpi/' . $imagename;

        imagejpeg($xxtmp, $xxhdpi_file, 100);
    }

    public function GetUserDetails($BizId = '') {
        $this->load->library('mongo_db');
//        print_r($BizId);
//        exit();
        $cursor = $this->mongo_db->where(array('storeID' => $BizId), array('count' => 1))->get('storeManagers');
////        $cursor = $this->mongo_db->get_where('products');
//print_r($cursor); die;
        $entities = array();
        $i = 0;
//
        foreach ($cursor as $data) {
//            print_r($data); 
            $catName = '-';
            $SubcatName = '-';
            if ($data['storeID'] != '') {
                $Categroy = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['storeID'])))->find_one('ProviderData');
                $catName = $Categroy['ProviderName'];
            }
//             $data[] = array('ItemName' => $items['ItemName'],
//                                "ItemId" => $items['ItemId'], "Qty" => $qty,
//                                "PrtionId" => $items['PrtionId'], "PortionTitle" => $items['PortionTitle'],
//                                "PortionPrice" => $items['PortionPrice'], "AddOns" => $items['AddOns']);
//            $data['CatName'] = $catName;
//            $data['SubCatName'] = $SubcatName;
            $entities[] = $data;


            $i++;
        }
//        print_r(json_encode($entities));
//        exit();
        return $entities;
    }

    public function GetDriverDetails($BizId = '') {
        $this->load->library('mongo_db');
//        print_r($BizId);
//        exit();
        $cursor = $this->mongo_db->where(array('ProviderId' => $BizId), array('count' => 1))->get('Offlinedrivers');
////        $cursor = $this->mongo_db->get_where('products');
//
//        $entities = array();
//        $i = 0;
//
        foreach ($cursor as $data) {
            $catName = '-';
            $SubcatName = '-';
            if ($data['ProviderId'] != '') {
                $Categroy = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['ProviderId'])))->find_one('ProviderData');
                $catName = $Categroy['ProviderName'];
            }
//             $data[] = array('ItemName' => $items['ItemName'],
//                                "ItemId" => $items['ItemId'], "Qty" => $qty,
//                                "PrtionId" => $items['PrtionId'], "PortionTitle" => $items['PortionTitle'],
//                                "PortionPrice" => $items['PortionPrice'], "AddOns" => $items['AddOns']);
//            $data['CatName'] = $catName;
//            $data['SubCatName'] = $SubcatName;
            $entities[] = $data;


            $i++;
        }
//        print_r(json_encode($entities));
//        exit();
        return $entities;
    }

    function insertmanager($BizId = '') {

        $this->load->library('mongo_db');

        $username = $this->input->post("username");
        $phone = $this->input->post("phone");

        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $selected = $this->input->post("Accepts");

        $cursor = $this->mongo_db->get('storeManagers');
        foreach ($cursor as $count) {
            
        }

        $seq = $count['seqID'] + 1;
//        print_r($selected); die;
        $Status = 0;
        $Lastlogin = '';
//        $lastactive = $this->input->post("last_active");

        $array = array("seqID" => $seq,
            "storeID" => $BizId,
            "managerName" => $username,
            "phone" => $phone,
            "email" => $email,
            "password" => $password,
            "currentStatus" => $Status,
            "devices" => array(),
            "accepts" => $selected
        );

        $this->mongo_db->insert('storeManagers', $array);
    }

    function insertoffdrivr($BizId = '') {

        $this->load->library('mongo_db');

        $username = $this->input->post("username");
        $phone = $this->input->post("phone");

        $email = $this->input->post("email");
        $password = $this->input->post("password");
//        $selected = $this->input->post("Accepts");

        $cursor = $this->mongo_db->get('Offlinedrivers');
        $arr = [];
        foreach ($cursor as $count) {

            $sep = explode('_', $count['Drseq']);
//            print_r($sep);
            array_push($arr, $sep[1]);
        }
//        print_r($arr);
        $maxseq = max($arr);
//        print_r($maxseq);
//        exit();
        $seq = $maxseq + 1;
//        print_r($selected); die;
        $Status = '0';
        $Lastlogin = '';
//        $lastactive = $this->input->post("last_active");

        $array = array("Drseq" => 'OFD_' . $seq,
            "ProviderId" => $BizId,
            "DriverName" => $username,
            "Phone" => $phone,
            "Email" => $email,
            "Password" => $password,
//                        "CurrentStatus" => $Status,
//                        "Devices" => array(),
//                        "Accepts" => $selected
        );

        $this->mongo_db->insert('Offlinedrivers', $array);
    }

    function insertmileageset($BizId = '', $cityid = '') {

        $this->load->library('mongo_db');

        $Drivertype = $this->input->post("Drivertype");
        $basefare = $this->input->post("basefare");
        $range = $this->input->post("range");
        $priceperkm = $this->input->post("priceperkm");
        $miniorder = $this->input->post("miniorder");
        $freeorder = $this->input->post("freeorder");
        $Defult = $this->input->post("Default");

        if ($Defult == "1") {
            $mileagedata = $this->mongo_db->get_where('pro_mileagedata', array("ProviderId" => $BizId));
            foreach ($mileagedata as $mil) {
                if ($mil['Default'] == "1") {
                    $id = $mil['_id'];
                    $Default = "0";
                    $this->mongo_db->update('pro_mileagedata', array("Default" => $Default), array("_id" => new MongoDB\BSON\ObjectID($id)));
                }
            }
        } else {
            $Defult = "0";
        }

        $cursor = $this->mongo_db->get('pro_mileagedata');
        $arr = [];
        foreach ($cursor as $count) {
            $sep = $count['Mseq'];
//            print_r($sep);
            array_push($arr, $sep);
        }
//        print_r($arr);
        $maxseq = max($arr);
        $seq = $maxseq + 1;

        $array = array("Mseq" => $seq,
            "ProviderId" => $BizId,
            "Cityid" => $cityid,
            "DriverType" => $Drivertype,
            "Basefare" => $basefare,
            "Range" => $range,
            "Priceperkm" => $priceperkm,
            "Miniorder" => $miniorder,
            "Freeorder" => $freeorder,
            "Default" => $Defult
        );

        $this->mongo_db->insert('pro_mileagedata', $array);
    }

    function insertzonalset($BizId = '', $cityid = '') {

        $this->load->library('mongo_db');

        $Drivertype = $this->input->post("Drivertype");
        $zone = $this->input->post("zone");
        $deliverychrg = $this->input->post("deliverychrg");
        $miniorder = $this->input->post("miniorder");
        $freeorder = $this->input->post("freeorder");


        $cursor = $this->mongo_db->get('pro_zonaldata');
        $arr = [];
        foreach ($cursor as $count) {
            $sep = $count['Zseq'];
//            print_r($sep);
            array_push($arr, $sep);
        }
//        print_r($arr);
        $maxseq = max($arr);
        $seq = $maxseq + 1;

        $array = array("Zseq" => $seq,
            "ProviderId" => $BizId,
            "Cityid" => $cityid,
            "DriverType" => $Drivertype,
            "Zoneid" => $zone,
            "Deliverycharge" => $deliverychrg,
            "Miniorder" => $miniorder,
            "Freeorder" => $freeorder,
        );

        $this->mongo_db->insert('pro_zonaldata', $array);
    }

    public function get_managerdata() {
        $this->load->library('mongo_db');
        $data = $this->input->post("val");
        $id = "";
        foreach ($data as $row) {
//            echo $row; exit();
            $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->get('storeManagers');
            $id = $row;
        }

//     print_r($cursor); exit();
        return $cursor;
    }

    public function get_driverdata() {
        $this->load->library('mongo_db');
        $data = $this->input->post("val");
        $id = "";
        foreach ($data as $row) {
//            echo $row; exit();
            $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('Offlinedrivers');
            $id = $row;
        }

//     print_r($cursor); exit();
        return $cursor;
    }

    public function get_mileagedata() {
        $this->load->library('mongo_db');
        $data = $this->input->post("val");
        $id = "";
        foreach ($data as $row) {
//            echo $row; exit();
            $cursor = $this->mongo_db->get_one('pro_mileagedata', array("_id" => new MongoDB\BSON\ObjectID($row)));
            $id = $row;
        }

//     print_r($cursor); exit();
        return $cursor;
    }

    public function get_zonaldata() {
        $this->load->library('mongo_db');
        $data = $this->input->post("val");
        $id = "";
        foreach ($data as $row) {
//            echo $row; exit();
            $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('pro_zonaldata');
            $id = $row;
        }

//     print_r($cursor); exit();
        return $cursor;
    }

    public function get_mileagealldata($pid = '') {
//         print_r($pid);exit();
        $this->load->library('mongo_db');

        $cursor = $this->mongo_db->get_where('pro_mileagedata', array("ProviderId" => $pid));

//     print_r($cursor->count()); exit();
        return array("count" => count($cursor));
    }

    public function getcatdetails() {
        $this->load->library('mongo_db');
        $data = $this->input->post("id");
        $id = "";
//        foreach ($data as $row) {
//            echo $data; exit();
        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($data)))->find_one('firstCategory');
        $id = $data;
//        }
//            echo'<pre>';
//     print_r($cursor); exit();
        return $cursor;
    }

    public function getsubcatdetails() {
        $this->load->library('mongo_db');
        $data = $this->input->post("id");
        $id = "";
//        foreach ($data as $row) {
//            echo $data; exit();
        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($data)))->find_one('firstCategory');
        ;
        $id = $data;
//        }
//            echo'<pre>';
//     print_r($cursor); exit();
        return $cursor;
    }

    function editmanager() {

        $this->load->library('mongo_db');
        $user_id = $this->input->post("user_id");
//       echo $user_id; exit();
        $username = $this->input->post("username");
        $phone = $this->input->post("phone");
        $email = $this->input->post("email");
//        $pass = $this->input->post("Password");
//
//        echo $email;        exit();
        $status = '';
//        $lastactive = $this->input->post("last_active");

        $array = array("ManagerName" => $username,
            "Phone" => $phone,
            "Email" => $email,
        );

        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($user_id)))->set($array)->update('storeManagers');
    }

    function editofflinedriver() {

        $this->load->library('mongo_db');
        $user_id = $this->input->post("user_id");
//       echo $user_id; exit();
        $username = $this->input->post("username");
        $phone = $this->input->post("phone");
        $email = $this->input->post("email");
        $pass = $this->input->post("password");

//        echo $email;        exit();
        $status = '';
//        $lastactive = $this->input->post("last_active");

        $array = array("DriverName" => $username,
            "Phone" => $phone,
            "Email" => $email,
            "Password" => $pass,
        );
//        print_r($user_id);
//        print_r($array);
//        exit();
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($user_id)))->set($array)->update('Offlinedrivers');
    }

    function editmileageset() {

        $this->load->library('mongo_db');
        $pid = $this->session->userdata('badmin')['BizId'];
        $user_id = $this->input->post("user_id");
//       echo $pid; exit();
        $Drivertype = $this->input->post("Drivertype");
        $basefare = $this->input->post("basefare");
        $range = $this->input->post("range");
        $priceperkm = $this->input->post("priceperkm");
        $miniorder = $this->input->post("miniorder");
        $freeorder = $this->input->post("freeorder");
        $Default = $this->input->post("Default");

        if ($Defult == "1") {
            $mileagedata = $this->mongo_db->get_where('pro_mileagedata', array("ProviderId" => $pid));
            foreach ($mileagedata as $mil) {
                if ($mil['Default'] == "1") {
                    $id = $mil['_id'];
                    $Default = "0";
                    $this->mongo_db->update('pro_mileagedata', array("Default" => $Default), array("_id" => new MongoDB\BSON\ObjectID($id)));
                }
            }
        } else {
            $Default = "0";
        }

        $array = array(
            "DriverType" => $Drivertype,
            "Basefare" => $basefare,
            "Range" => $range,
            "Priceperkm" => $priceperkm,
            "Miniorder" => $miniorder,
            "Freeorder" => $freeorder,
            "Default" => $Default
        );
//        print_r($user_id);
//        print_r($array);
//        exit();
        $this->mongo_db->update('pro_mileagedata', $array, array("_id" => new MongoDB\BSON\ObjectID($user_id)));
    }

    function editzonalset() {

        $this->load->library('mongo_db');

        $user_id = $this->input->post("user_id");
        $Drivertype = $this->input->post("Drivertype");
        $zone = $this->input->post("zone");
        $deliverychrg = $this->input->post("deliverychrg");
        $miniorder = $this->input->post("miniorder");
        $freeorder = $this->input->post("freeorder");

        $array = array(
            "DriverType" => $Drivertype,
            "Zoneid" => $zone,
            "Deliverycharge" => $deliverychrg,
            "Miniorder" => $miniorder,
            "Freeorder" => $freeorder,
        );

//        print_r($user_id);
//        print_r($array);
//        exit();
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($user_id)))->set($array)->update('pro_zonaldata');
    }

    function change_password() {

        $this->load->library('mongo_db');
        $user_id = $this->input->post("user_id1");
//       echo $user_id; exit();
        $newpassword = $this->input->post("newpassword");
        $renewpassword = $this->input->post("renewpassword");

        $array = array("Password" => $renewpassword);

        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($user_id)))->set($array)->update('storeManagers');
        ;
    }

    function delete_User($providerid) {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        foreach ($id as $val) {
//            print_r($val); exit();
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->delete('storeManagers');
//        $this->mongo_db->delete('ProviderData', array('Users._id' => new MongoDB\BSON\ObjectID($val)));
        }
    }

    function delete_Driver($providerid) {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        foreach ($id as $val) {

            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->delete('Offlinedrivers');
        }
    }

    function delete_mileage($providerid) {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        foreach ($id as $val) {
//            print_r($val); exit();
            $this->mongo_db->delete('pro_mileagedata', array('_id' => new MongoDB\BSON\ObjectID($val)));
//        $this->mongo_db->delete('ProviderData', array('Users._id' => new MongoDB\BSON\ObjectID($val)));
        }
    }

    function delete_zonal($providerid) {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        foreach ($id as $val) {
//            print_r($val); exit();

            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->delete('pro_zonaldata');
        }
    }

    function validateEmail_user() {
        $this->load->library('mongo_db');
        $cout = $this->mongo_db->where(array('Email' => $this->input->post('email')))->count('storeManagers');
        $result = 0;
//        print_r($cout);
        if ($cout > 0) {
            $result = 1;
        }

        echo json_encode(array('msg' => $result));
    }

    function validateEmail_driver() {
        $this->load->library('mongo_db');
        $cout = $this->mongo_db->where(array('Email' => $this->input->post('email')))->count('Offlinedrivers');
        $result = 0;
//        print_r($cout);
        if ($cout > 0) {
            $result = 1;
        }

        echo json_encode(array('msg' => $result));
    }

    public function storedriver_config($id = '') {

        $this->load->library('mongo_db');
        $data1 = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('timeslot');

        return $data1['store_time_config'];
    }

    function update_storetimeslots() {
        $this->load->library('mongo_db');

        $tslot = $_REQUEST['tslot'];
        $perslotperdriver = $_REQUEST['perslotperdriver'];
        $dispatch_method = $_REQUEST['selecteddispatch'];
        $start_time = $_REQUEST['start_time'];
        $end_time = $_REQUEST['end_time'];
        $businessId = $_REQUEST['businessId'];

        $insertIntoChatArr = array('storeTimeConfig' => array('tslot' => $tslot, 'perSlotPerDriver' => $perslotperdriver, 'dispatchMethod' => $dispatch_method, 'startTime' => $start_time, 'endTime' => $end_time));
        $result = $this->mongo_db->count('timeslot');
        if ($result > 0)
            $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($businessId)))->set($insertIntoChatArr)->update('timeslot');
        else
            $res = $this->mongo_db->insert('timeslot', $insertIntoChatArr);
        echo json_encode($res);
    }

    function validate_username() {
        $this->load->library('mongo_db');
        $cout = $this->mongo_db->where(array('ManagerName' => $this->input->post('username')))->count('storeManagers');
        $result = 0;
//        print_r($cout);
        if ($cout > 0) {
            $result = 1;
        }

        echo json_encode(array('msg' => $result));
    }

    function validatePassword($Bizid = '') {

        $this->load->library('mongo_db');
        $data = $_POST;
        $curs = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Bizid)))->find_one('stores');
        if ($data['oldpass'] !== $curs['password']) {
            $cout = 1;
        }
        $result = 0;
        if ($cout > 0) {
            $result = 1;
        }

        echo json_encode(array('msg' => $result));
    }

    function SetSeesionFromAdmin($BizId = '') {

        $this->load->library('mongo_db');
        $this->load->library('CallAPI');


        $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($BizId)))->get('stores');
        // $1data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($BizId)))->find_one('stores');
        
        foreach ($cursor as $data) {

            $OwnerName = $data['ownerName'];
            $Website = $data['Website'];
            $Email = $data['ownerEmail'];
            $Status = $data['status'];

            $ProfilePic = $data['profileLogos']['logoImage'];
            $name = $data['name'][0];
            $ImageFlag = $data['ImageFlag'];
            $Driver_session = $data['Driver_exist'];
            $CityDetails = $this->GetCity($data['cityId']);

            foreach ($CityDetails['cities'] as $cities) {
                if ($cities['cityId']['$oid'] == $data['cityId']) {
                    $currency = $cities['currencySymbol'];
                    $currencyShortHand= $cities['currency'];
                    $abbrevation=$cities['abbrevation'];
                    $abbrevationText=$cities['abbrevationText'];

                }
            }

            $pricing_status = $data['pricing_status'];
            $cityid = $data['cityId'];
            $countryid = $data['countryId'];
        }

        $sessiondata = array(
            'BizId' => $BizId,
            'validate' => true,
            'profile_pic' => $ProfilePic,
            'BusinessName' => $name,
            'Ownername' => $OwnerName,
            'ImageFlag' => $ImageFlag,
//            'Currency' => 'SAR',
            'Currency' => $currency,
            'Driver' => $Driver_session,
            'Admin' => '1',
            'pricing_status' => $pricing_status,
            'cityid' => $cityid,
            'CurrencyShortHand'=>$currencyShortHand,
            'currencySymbol'=>$currency,
            'Countryid' => $countryid,
            'abbrevation'=>$abbrevation,
            'abbrevationText'=>$abbrevationText
        );

        $badmin = array('badmin' => $sessiondata);
//        print_r($badmin);  die;
        $this->session->set_userdata($badmin);
    }

    function setSessionFromAdmin($BizId = '',$timeOffset = '') {

    
        $this->load->library('mongo_db');
        $this->load->library('CallAPI');
        $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($BizId)))->get('Franchise');

        if (empty($cursor)) {
            $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($BizId)))->get('stores');
        }

        foreach ($cursor as $data) {

            $OwnerName = $data['ownerName'];
            $Website = $data['Website'];
            $Email = $data['ownerEmail'];
            $Status = $data['status'];
            $currencySymbol=$data['currencySymbol'];
			$storeType = $data['storeType'];
            $ProfilePic = $data['profileLogos']['logoImage'];
            $name = $data['name'][0];
            $ImageFlag = $data['ImageFlag'];
            $Driver_session = $data['Driver_exist'];
            $CityDetails = $this->GetCity($data['cityId']);
            
            foreach ($CityDetails['cities'] as $cities) {
                if ($cities['cityId']['$oid'] == $data['cityId']) {
                    $currency = $cities['currencySymbol'];
                    $currencyShortHand= $cities['currency'];
                    $abbrevation=$cities['abbrevation'];
                    $abbrevationText=$cities['abbrevationText'];
                }
            }

            $pricing_status = $data['pricing_status'];
            $cityid = $data['cityId'];
            $countryid = $data['countryId'];
            $pwd = $data['password'];
            $autoDispatch=$data['autoDispatch'];
            $forcedAccept=$data['forcedAccept'];
        }

        /// call api for token
           $apidata['email'] = $Email;
           $apidata['password'] = $pwd;
           $url = APILink .'admin/store/signIn';        
           $apiToken =""; 
           $response = json_decode($this->callapi->CallAPI('POST', $url, $apidata), true); 
           if($response['statusCode']==200){
                $apiToken = $response['data']['token'];
           }


        $sessiondata = array(
            'BizId' => $BizId,
            'profile_pic' => $ProfilePic,
			'storeType'=>$storeType,
            'validate' => true,
            'BusinessName' => $name,
            'Ownername' => $OwnerName,
            'Currency' => $currency,
            'CurrencyShortHand'=>$currencyShortHand,
            'OwnerName' => $OwnerName,
            'Email' => $Email,
            'Status' => $Status,
            'Admin' => '1',
           // 'currencySymbol'=>$currencySymbol,
            'currencySymbol'=>$currency,
            'apiToken'=>$apiToken,
            'timeOffset' => $timeOffset,
            'autoDispatch' =>  $autoDispatch,
            'forcedAccept' => $forcedAccept,
            'abbrevation'=>$abbrevation,
            'abbrevationText'=>$abbrevationText

        );

        $badmin = array('table'=>'company_info','badmin' => $sessiondata);
		//print_r($badmin);die;
        $this->session->set_userdata($badmin);
    }

    function getjaiecom_details() {
        $this->load->library('mongo_db');
        $cityid = $this->input->post("cityid");
//          print_r($cityid); die;
        $cursor = $this->mongo_db->get_one('mielagesetting', array('Cityid' => $cityid));
//          print_r($cursor); die;
        return $cursor;
    }

    function getjaiecom_deliverychg() {
        $this->load->library('mongo_db');
        $zoneid = $this->input->post("zoneid");
//          print_r($cityid); die;
        $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($zoneid)))->find_one('zones');
//        echo '<pre>'; 
        foreach ($cursor['pricing'] as $price) {
            if ($price['id'] == $zoneid) {
                $deliverychrg = $price['price'];
            }
        }
        print_r($deliverychrg);
       // die;
        return array("deliverychrg" => $deliverychrg);
    }

    /**
     *
     *  get admin list
     *
     *
     */
    function LoadAdminList() {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_where('Col_Manage_Admin', array('Role' => $this->encrypt_decrypt('encrypt', "Admin")));

        $admins = array();
        $i = 0;
        foreach ($cursor as $data) {
            $data['Fname'] = $this->encrypt_decrypt('decrypt', $data['Fname']);
            $data['Lname'] = $this->encrypt_decrypt('decrypt', $data['Lname']);
            $data['Email'] = $this->encrypt_decrypt('decrypt', $data['Email']);
            $data['Password'] = $this->encrypt_decrypt('decrypt', $data['Password']);
            $data['Type'] = $this->encrypt_decrypt('decrypt', $data['Type']);
            $data['Role'] = $this->encrypt_decrypt('decrypt', $data['Role']);
            $data['Parent'] = $this->encrypt_decrypt('decrypt', $data['Parent']);

            $admins[$i] = $data;
            $i++;
        }

        return $admins;
    }

    /**
     *
     *  get brokers list
     *
     *
     */
    /* function LoadBrokerList(){

      $this->load->library('mongo_db');
      $cursor = $this->mongo_db->get_where('Col_Manage_Admin',array('Role' => "Broker"));
      return $cursor;
      } */

    /**
     *
     *  get dashboard data like total nuber of admin extra
     *
     *
     */
    function get_Dashbord_data($BizId = '') {
        $this->load->library('mongo_db');
//        $cat = $this->mongo_db->count_all_results('ProductCategory', array('BusinessId' => $BizId));
//        $SubCat = $this->mongo_db->count_all_results('ProductSubCategory', array('BusinessId' => $BizId));
//        $Products = $this->mongo_db->count_all_results('products', array('BusinessId' => $BizId));
//        $AddOns = $this->mongo_db->count_all_results('AddOns', array('BusinessId' => $BizId));
//        $AddOns = $this->mongo_db->count_all_results('AddOns', array('Orders' => $BizId,));
//        echo $SubCat;
        $tz_date = new DateTime("now", new DateTimeZone('asia/kolkata'));
        $tz_date->format('Y-m-d H:m:s');

        $date = $tz_date->format('Y-m-d H:m:s');
        $dateOnly = $tz_date->format('Y-m-d');
        $SOM = date('Y-m-01') . ' 00:00:01';
        $EOM = date('Y-m-t') . ' 23:59:59';

        $EOW = date("Y-m-d", strtotime(date("Y") . 'W' . date('W') . "7"));
        $SOW = date("Y-m-d", strtotime(date("Y") . 'W' . date('W') . "1")) . ' 00:00:01';
        $SOD = $dateOnly . ' 00:00:01';
        $EOD = $dateOnly . ' 23:59:59';

        $TodayTotalOrders = 0;
        $WeekTotalOrders = 0;
        $MonthTotalOrders = 0;
        $TotalOrders = 0;
        $TOdayTotalErnings = 0;
        $WeekTotalErnings = 0;
        $MonthTotalErnings = 0;
        $TotalErnings = 0;

        $details = $this->mongo_db->get_where('appointment', array('BusinessId' => $BizId));
        $entities = array();
        foreach ($details as $data) {
//            $this->load->database();
            $query = $this->db->query("select * from appointment where status in (9) and  appointment_id='" . $data['appointment_id'] . "' and created_dt>='" . $SOD . "' and created_dt<='" . $EOD . "' order by appointment_id desc")->result();
            foreach ($query as $OrderDta) {
                $TodayTotalOrders++;
                $TOdayTotalErnings = (double) $TOdayTotalErnings + (double) $OrderDta->amount;
            }
            $query1 = $this->db->query("select * from appointment where status in (9) and  appointment_id='" . $data['appointment_id'] . "' and created_dt>='" . $SOW . "' and created_dt<='" . $EOW . "' order by appointment_id desc")->result();
            foreach ($query1 as $OrderDta) {
                $WeekTotalOrders++;
                $WeekTotalErnings = (double) $WeekTotalErnings + (double) $OrderDta->amount;
            }
            $query2 = $this->db->query("select * from appointment where status in (9) and  appointment_id='" . $data['appointment_id'] . "' and created_dt>='" . $SOM . "' and created_dt<='" . $EOM . "' order by appointment_id desc")->result();
            foreach ($query2 as $OrderDta) {
                $MonthTotalOrders++;
                $MonthTotalErnings = (double) $MonthTotalErnings + (double) $OrderDta->amount;
            }
            $query3 = $this->db->query("select * from appointment where status in (9) and  appointment_id='" . $data['appointment_id'] . "' order by appointment_id desc")->result();
            foreach ($query3 as $OrderDta) {
                $TotalOrders++;
                $TotalErnings = (double) $TotalErnings + (double) $OrderDta->amount;
            }
        }

        return array('TodayTotalOrders' => $TodayTotalOrders, 'TOdayTotalErnings' => round($TOdayTotalErnings, 2),
            'WeekTotalOrders' => $WeekTotalOrders, 'WeekTotalErnings' => round($WeekTotalErnings, 2),
            'MonthTotalOrders' => $MonthTotalOrders, 'MonthTotalErnings' => round($MonthTotalErnings, 2),
            'TotalOrders' => $TotalOrders, 'TotalErnings' => round($TotalErnings, 2), 'SOW' => $SOM, 'EOW' => $EOM);
    }

    public function GetAllCategories($BizId = '') {

        $cursor = $this->mongo_db->where(array('BusinessId' => $BizId, 'count' => '1'))->get('ProductCategory');

        $entities = array();

        $i = 0;

        foreach ($cursor as $data) {
            $entities[] = $data;
            $i++;
        }

        return $entities;
    }

    public function GetmileageDetails($BizId = '') {
        $this->load->library('mongo_db');

        $cursor = $this->mongo_db->get_where('pro_mileagedata', array("ProviderId" => $BizId));
        $entities = array();
        $i = 0;

        foreach ($cursor as $data) {

            $entities[] = $data;
            $i++;
        }
        return $entities;
    }

    public function GetzonalDetails($BizId = '') {
        $this->load->library('mongo_db');

        $cursor = $this->mongo_db->where(array('ProviderId' => $BizId))->get('pro_zonaldata');
//        print_r($cursor);die;
        $entities = array();
        $i = 0;

        foreach ($cursor as $data) {

            $zonedata = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['Zoneid'])))->find_one('zones');
//            print_r($zonedata); die;
            $data['zonetitle'] = $zonedata['title'];
            $entities[] = $data;
            $i++;
        }
//        print_r($data);die;
        return $entities;
    }

    public function get_drivertype($id) {
        $this->load->library('mongo_db');

        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('ProviderData');

        return $cursor;
    }

    public function AllProviderCategories() {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get('firstCategory');
        $entities = array();
        $i = 0;

        foreach ($cursor as $data) {
            $entities[] = $data;
            $i++;
        }
        return $entities;
    }

    public function AllProvidersubCategories() {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get('secondCategory');
        $entities = array();
        $i = 0;

        foreach ($cursor as $data) {
            $entities[] = $data;
            $i++;
        }
        return $entities;
    }

    public function GetAllOrders($BizId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get('orders');
        $customerdetail = $this->mongo_db->get('customer');
        $driverdetail = $this->mongo_db->get('driver');
        $data = array();
        $rec = array();
        foreach ($cursor as $details) {

            if (array_key_exists('menu', $details)) {
                foreach ($details['menu'] as $detail) {
//                   echo $BizId.'--'.$detail['storeId'];
                    if (array_key_exists('storeId', $detail)) {


                        if ($detail['storeId'] == trim($BizId)) {

                            $rec['orderid'] = $details['orderseqId'];
                            $rec['date'] = $details['order_datetime'];
                            $rec['status'] = $details['status'];
                            $rec['total'] = $details['total_amount'];

                            foreach ($customerdetail as $customer) {
                                if ($customer['_id']['$oid'] == $details['userId']) {
                                    $customername = $customer['First_name'];
                                    $rec['cus_name'] = $customername;
                                }
                            }
                            $drivername = '';
                            foreach ($details['driversLog'] as $driv) {
                                foreach ($driverdetail as $driver) {
                                    if ($driver['_id']['$oid'] == $driv['driverid'] && $driv['status'] == "7") {
                                        $drivername = $driver['name'];
//                                        $rec['driv_name'] = $drivername;
                                    }
                                }
                            }
                            $rec['driv_name'] = $drivername;

                            array_push($data, $rec);
                        }
                    }
                }
            }
        }
        return $data;
    }

    function datatableOrderHistory($status = '') {

        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "";
        $_POST['mDataProp_1'] = "";
        $_POST['mDataProp_2'] = "";

        $respo = $this->datatables->datatable_mongodb('completedOrders', array("storeId" => $status), '', -1);
        $aaData = $respo["aaData"];

        $datatosend = array();
        $index = $_POST['iDisplayStart'] + 1;
        foreach ($aaData as $value) {

            if ($value['status'] == 15) {
                $status = "Completed";
            }
            if ($value['status'] == 2) {
                $status = "Cancelled";
            }
            if ($value['status'] == 3) {
                $status = "Rejected";
            }
            $arr = array();
            $arr[] = $index++;
            $arr[] = '<a href="' . base_url() . 'index.php?/Business/oneOrderDetails/' . $value['orderId'] . '" style="cursor :pointer;color:#0693e0; "  >' . $value['orderId'] . '</a>';
//            $arr[] = '<a href="" style="cursor :pointer;color:#0693e0; "  >' . $value['orderId'] . '</a>';
            $arr[] = '<a style="cursor: pointer;" id="driverID' . $value['driverDetails']['driverId']['$oid'] . '" class="getDriverDetails" mas_id=' . $value['driverDetails']['driverId']['$oid'] . ' >' . $value['driverDetails']['fName'] . '</a>';


            $arr[] = $value['customerDetails']['name'];
            $arr[] = $value['accouting']['masEarning'];
            $arr[] = $value['deliveryCharge'];
            $arr[] = $value['accouting']['appCom'];

            $arr[] = $value['storeDeliveryFee'];
            $arr[] = $value['totalAmount'];

            $arr[] = $value['bookingDate'];
            $arr[] = date('Y-m-d H:i:s', $value['timeStamp']['completed']['timeStamp']);
            $arr[] = $status;
            $arr[] = '<a href="" style="cursor :pointer; "  ><button  id="' . $value['orderid'] . '"  type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;" class="btn btn-success"><i class="fa fa-arrow-right"></i></button></a>';
//            $arr[] = '<a href="' . base_url() . 'index.php?/Business/OrderDetails/' . $value['orderid'] . '" style="cursor :pointer; "  ><button  type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;" class="btn btn-success"><i class="fa fa-arrow-right"></i></button></a>';
//
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function tripDetails($param) {
        $this->load->library('mongo_db');
        $data['res'] = $this->mongo_db->where(array('orderId' => (int) $param))->find_one('completedOrders');

        $data['appConfig'] = $this->mongo_db->find_one('appConfig');
        $tarr = array();
//        foreach ($tarrm as $value) {
        foreach ($data['res']['appRouts'] as $val) {
            $tarr[$val['subid']] = json_decode($val['ent_shipment_latlogs']);
        }

        $data['trip_route'] = $tarr;

//        $url = APILink . 'dispatcher/tasks/livePath/' . $param; //GET /dispatcher/tasks/livePath/{bid}
//        $r = $this->callapi->CallAPI('GET', $url);
//        $jsonResponse = json_decode($r, true);
//        print_r($jsonResponse);die;
        $data['pickUpLatLong'] = $data['res']['pickup_location'];
        $data['dropLatLong'] = $data['res']['drop_location'];

        $data['appRoute'] = $jsonResponse;

//        $type_id = $data['res']['vehicleType'][0]['_id']['$oid'];
//        $data['car_data'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($type_id)))->find_one('ShipmentDetails');

        return $data;
    }

    public function GetOrderHistory($BizId = '') {
//        print_r($BizId);die;
        $this->load->library('mongo_db');
        $details = $this->mongo_db->where(array('storeId' => $BizId))->get('completedOrders');

//        return $details;
    }

    public function SalesAnalytics($BizId = '') {

        $this->load->library('mongo_db');
        $AllDBPro = $this->mongo_db->get_where('products', array('BusinessId' => $BizId)); //, '_id' => new MongoDB\BSON\ObjectID('55e7da7c80a0b2e1794413fb')
        $i = 0;
        $mainArray = array();
        foreach ($AllDBPro as $DBPro) {
            $MainItemId = $DBPro['_id']['$oid'];
            $analytics = array();
            $details = $this->mongo_db->get_where('Orders', array('menu.ItemId' => $DBPro['_id']['$oid']));
            $entities = array();
            $allItemIds = array();

            foreach ($details as $data) {

                $query = $this->mongo_db->get_where('Orders', array('status' => 14));

                foreach ($query as $OrderDta) {
                    if ($OrderDta['status'] === 14) {
                        $allitemsfromDb = $data['menu'];
                        foreach ($allitemsfromDb as $items) {
                            if ($items['ItemId'] == $MainItemId) {

                                if (count($analytics) > 0) {
                                    $count = 0;
                                    foreach ($analytics as $any) {
                                        if ($any['ItemId'] == $items['ItemId'] && $any['PortionTitle'] == $items['PortionTitle']) {
//                                                echo (int) $items['ItemId']; exit(); 
//                                            echo (int)$items['PortionQuantity']; exit();
//                                             echo (int) $DBPro['count']; exit();
                                            $total = (int) $any['ItemId'] + (int) $items['PortionQuantity'];
                                            $analytics[$count] = array('ItemId' => $items['ItemId'], 'ItemName' => $items['ItemName'] . ' (' . $items['PortionTitle'] . ')', 'Total' => (int) $total, 'PortionPrice' => $items['PortionPrice'], 'PortionTitle' => $items['PortionTitle']);
                                        } else
                                        if (!in_array($items['ItemId'] . '-' . $items['PortionTitle'], $allItemIds)) {
                                            $allItemIds[] = $items['ItemId'] . '-' . $items['PortionTitle'];
                                            $analytics[] = array('ItemId' => $items['ItemId'], 'ItemName' => $items['ItemName'] . ' (' . $items['PortionTitle'] . ')', 'Total' => (int) $items['PortionQuantity'], 'PortionPrice' => $items['PortionPrice'], 'PortionTitle' => $items['PortionTitle']);
                                        }
                                        $count++;
                                    }
                                } else {
                                    $allItemIds[] = $items['ItemId'] . '-' . $items['PortionTitle'];
                                    $analytics[] = array('ItemId' => $items['ItemId'], 'ItemName' => $items['ItemName'] . ' (' . $items['PortionTitle'] . ')', 'Total' => (int) $items['PortionQuantity'], 'PortionPrice' => $items['PortionPrice'], 'PortionTitle' => $items['PortionTitle']);
                                }
                            }
                        }
                    }
                }
                $i++;
            }
            $mainArray = array_merge($mainArray, $analytics);
        }
//       print_r(json_encode($mainArray));
//        exit();
//        sort($mainArray);
        return $mainArray;
    }

    public function DeleteCat($entityid = '') {
        $this->load->library('mongo_db');
        $this->mongo_db->delete('ProductSubCategory', array("CategoryId" => $entityid));
        $this->mongo_db->delete('products', array("CategoryId" => $entityid));
        $this->mongo_db->delete('ProductCategory', array("_id" => new MongoDB\BSON\ObjectID($entityid)));
    }

    public function GetAllSubCategories($BizId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_where('ProductSubCategory', array('BusinessId' => $BizId), array('count' => 1));

        $entities = array();
        $i = 0;
        foreach ($cursor as $data) {
            $Cat = $this->mongo_db->get_one('ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($data['CategoryId'])));

            $data['Category'] = $Cat['Category'];
            $data['SubCategory'] = $data['SubCategory'];
            $data['Description'] = $data['Description'];
            $data['CategoryId'] = $data['CategoryId'];
            $data['id'] = $data['_id']['$oid'];
            $entities[$i] = $data;
            $i++;
        }
        return $entities;
    }

    public function CheckOldPwd($BizId = '') {
        $this->load->library('mongo_db');
        $Cat = $this->mongo_db->count_all_results('ProviderData', array('_id' => new MongoDB\BSON\ObjectID($BizId), 'Password' => $this->input->post("oldPwd")));

        if ($Cat > 0) {
            $entities = array('flag' => 0);
        } else {
            $entities = array('flag' => 1);
        }

        return $entities;
    }

    public function checkLink($Resetlink = '') {
        $this->load->library('mongo_db');
        $Check = $this->mongo_db->count_all_results('ProviderData', array('resetlink' => $Resetlink));

        if ($Check > 0) {
            $entities = array('flag' => 0);
        } else {
            $entities = array('flag' => 1);
        }

        return $entities;
    }

    public function GetAllAddOnCats($BizId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->where(array('BusinessId' => $BizId))->get('AddOns');

        $entities = array();
        $i = 0;
        foreach ($cursor as $data) {

            $entities[] = $data;
        }
        return $entities;
    }

    public function GetMongoid() {
        $this->load->library('mongo_db');
    }

    public function GetAllAddOns($BizId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_where('AddOns', array('BusinessId' => $BizId));

        $entities = array();
        $i = 0;
        foreach ($cursor as $data) {

            $entities[] = $data;
            $i++;
        }
        return $entities;
    }

    public function DeleteSubCat($entityid = '') {
        $this->load->library('mongo_db');
        $this->mongo_db->delete('products', array("SubCategoryId" => $entityid));
        $this->mongo_db->delete('ProductSubCategory', array("_id" => new MongoDB\BSON\ObjectID($entityid)));
    }

    public function DeleteAddOnCat($entityid = '') {
        $this->load->library('mongo_db');
        $this->mongo_db->delete('AddOns', array("_id" => new MongoDB\BSON\ObjectID($entityid)));
    }

    public function DeleteProduct() {

        $this->load->library('mongo_db');
        $PId = $this->input->post("val");

        foreach ($PId as $pid) {
            echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($pid)))->delete('products');
        }
    }

    public function GetSubCatfromCat() {
        $this->load->library('mongo_db');
        $CatId = $this->input->post("catId");
//        echo $CatId;
//        die();
        $SubCat = $this->input->post("SubCat");
        $cursor = $this->mongo_db->where(array('CategoryId' => $CatId))->get('ProductSubCategory');
//        echo $SubCat;
//        $entities = array();
        $i = 0;
        $entities = ' <select class="form-control" id="SubCategoryId" name="FData[SubCategoryId]" required>
                                                <option value="0">All</option>';
        foreach ($cursor as $data) {
//            echo $data['SubCategory'];

            if ($SubCat == $data['_id']['$oid']) {
                $entities .= ' <option value="' . $data['_id']['$oid'] . '" selected>' . implode($data['SubCategory'], ",") . '</option>';
            } else {
                $entities .= ' <option value="' . $data['_id']['$oid'] . '">' . implode($data['SubCategory'], ",") . '</option>';
            }
        }

        $entities .= ' </select>';
        return $entities;
    }

    public function GetProductDetails($productId = '') {
        $this->load->library('mongo_db');
//        $cursor = $this->mongo_db->get_where('products', array('BusinessId' => $BizId));
        if ($productId != '')
            $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($productId)))->find_one('products');
        else
            $cursor = $this->mongo_db->get('products');
        return $cursor;
    }

    public function GetProfileData($productId = '') {

        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($productId)))->find_one('stores');

        return $cursor;
    }

    public function GetAddonDetails($AddonId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_one('AddOns', array('_id' => new MongoDB\BSON\ObjectID($AddonId)));
        return $cursor;
    }

    function loadsubcat() {
        $catid = $this->input->post('cat');
//       echo $catid;
//        echo $catid; exit();
//        $Result = $this->db->query("select * from company_info where city=" . $cityid . " and status = 3 ")->result_array();
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_where('ProductSubCategory', array('CategoryId' => $catid));
//        $arr = array();
//        foreach ($cursor as $sub)
//            $arr[] = $sub;
//        print_r($arr);        exit();

        return $cursor;
    }

    public function GetAllProducts($BizId = '') {
        $this->load->library('mongo_db');
//      echo '<pre>';
//        print_r($BizId);
        $i = 0;
        $entities = array();
        $cursor = $this->mongo_db->where(array('BusinessId' => $BizId))->get('ProductCategory');
        foreach ($cursor as $data) {
            $SubCategroy = $this->mongo_db->where(array('CategoryId' => ($data['_id']['$oid'])))->get('ProductSubCategory');
            if (count($SubCategroy) > 0) {

                foreach ($SubCategroy as $subcat) {
                    $product = $this->mongo_db->where(array('SubCategoryId' => ($subcat['_id']['$oid'])))->order_by(array('count' => "1"))->get('products');
                    foreach ($product as $pro) {
                        $pro['CatName'] = $data['Category'];
                        $pro['SubCatName'] = $subcat['SubCategory'];

                        $entities[] = $pro;
                        $i++;
                    }
                }
            } else {
                $product = $this->mongo_db->where(array('CategoryId' => ($data['_id']['$oid'])))->get('products');
                foreach ($product as $pro) {
                    $pro['CatName'] = $data['Category'];
                    $pro['SubCatName'] = '';
                    $entities[] = $pro;
                    $i++;
                }
            }
        }
//        print_r(($entities)); exit();
        return $entities;
    }

    function getdata() {
        $catid = $this->input->post('cat');
        $sid = $this->input->post('sid');
//       echo $sid; echo $catid; exit();
        $this->load->library('mongo_db');

        $i = 0;
        $arr = array();
        $entities = array();

        if ($sid == 1 || $sid == 0) {
//            echo 1111;
            $cursor = $this->mongo_db->get_where('ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($catid)));
            foreach ($cursor as $data) {
                $SubCategroy = $this->mongo_db->get_where('ProductSubCategory', array('CategoryId' => ($data['_id']['$oid'])));
                if ($SubCategroy->count() > 0) {
                    foreach ($SubCategroy as $subcat) {
                        $product = $this->mongo_db->get_where('products', array('SubCategoryId' => ($subcat['_id']['$oid'])))->sort(array('count' => 1));
                        foreach ($product as $pro) {
                            $pro['CatName'] = $data['Category'];
                            $pro['SubCatName'] = $subcat['SubCategory'];
                            $entities[] = $pro;

                            $i++;
                        }
                    }
                } else {
                    $product = $this->mongo_db->get_where('products', array('CategoryId' => ($data['_id']['$oid'])))->sort(array('count' => 1));
                    foreach ($product as $pro) {
                        $pro['CatName'] = $data['Category'];
                        $pro['SubCatName'] = '';
                        $entities[] = $pro;

                        $i++;
                    }
                }
            }
        } else {
//            echo 2222;
            $whererc = array('$and' => array(array('CategoryId' => $catid), array('SubCategoryId' => $sid)));
            $product = $this->mongo_db->get_where('products', $whererc)->sort(array('count' => 1));
            $catdata = $this->mongo_db->get_one('ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($catid)));
            $SubCategroy = $this->mongo_db->get_one('ProductSubCategory', array('_id' => new MongoDB\BSON\ObjectID($sid)));

            foreach ($product as $p) {
                $p['CatName'] = $catdata['Category'];
                $p['SubCatName'] = $SubCategroy['SubCategory'];
//                print_r($p);
                $entities[] = $p;
                $i++;
            }
        }
        foreach ($entities as $e) {
//                     print_r($e);
            if (count($e['Portion']) == 1) {
                foreach ($e['Portion'] as $Por) {
                    $Price = $Por['price'];
                }
            } else {
                foreach ($e['Portion'] as $Por) {
                    $allprice[] = $Por['price'];
                }
                $Price = min($allprice);
            }
            $arr[] = array('img' => $e['Masterimageurl']['Url'], 'pname' => $e['ProductName'], 'cat' => $e['CatName'], 'subcat' => $e['SubCatName'], 'price' => $Price, 'p_id' => $e['_id']['$oid']);
        }
//          print_r($arr);
//          exit();
        return $arr;
    }

//    public function GetAllProducts($BizId = '') {
//        $this->load->library('mongo_db');
//        
//        $cursor = $this->mongo_db->get_where('products', array('BusinessId' => $BizId));
////        $cursor = $this->mongo_db->get_where('products', array('BusinessId' => $BizId), array('count' => 1));
////        $cursor = $this->mongo_db->get_where('products');
//
//        $entities = array();
//        $i = 0;
////         echo '<pre>';
//        foreach ($cursor as $data) {
////             echo '<pre>';
////              print_r(($data));
//            $catName = '-';
//            $SubcatName = '-';
//            if ($data['CategoryId'] != '') {
//                $Categroy = $this->mongo_db->get_one('ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($data['CategoryId'])));
//                $catName = $Categroy['Category'];
//            }
//            if ($data['SubCategoryId'] != '') {
//                $SubCategroy = $this->mongo_db->get_one('ProductSubCategory', array('_id' => new MongoDB\BSON\ObjectID($data['SubCategoryId'])));
//                $SubcatName = $SubCategroy['SubCategory'];
//            }
//            $data['CatName'] = $catName;
//            $data['SubCatName'] = $SubcatName;
//            $entities[] = $data;
//
//
//            $i++;
//        }
////        die();
//       
////        print_r(($entities)); exit();
//        return $entities;
//    }

    public function GetOrderDetails($OrderId = '') {
        $this->load->library('mongo_db');
//        print_r($OrderId);

        $cursor = $this->mongo_db->where(array('orderId' => $OrderId))->get('completedOrders');

        $rec = array();

        $Items = array();

        foreach ($cursor['menu'] as $items) {
//            $Product = $this->mongo_db->get_one('products', array('_id' => new MongoDB\BSON\ObjectID($items['ItemId'])));
            if ($items['PortionQuantity'] == '' || $items['PortionQuantity'] < 1) {
                $qty = 1;
            } else {
                $qty = $items['PortionQuantity'];
            }
            $Items[] = array('ItemName' => $items['ItemName'],
                "ItemId" => $items['ItemId'], "Qty" => $qty,
                "PrtionId" => $items['PrtionId'], "PortionTitle" => $items['PortionTitle'],
                "PortionPrice" => $items['PortionPrice'], "AddOns" => $items['AddOns']);

            $rec['orderid'] = $cursor['orderseqId'];
            $rec['date'] = $cursor['order_datetime'];
            $rec['status'] = $cursor['status'];
            $rec['total'] = $cursor['total_amount'];
            $rec['address'] = $cursor['address1'] . ' ' . $cursor['address2'];
            $rec['tip_amount'] = $cursor['tip_amount'];
            $rec['subtotal_amount'] = $cursor['subtotal_amount'];
            $rec['servicecharge'] = $cursor['servicecharge'];
            $rec['tax_amount'] = $cursor['tax_amount'];
            $rec['deliverycharge'] = $cursor['deliverycharge'];
            $rec['discount'] = $cursor['discount'];

            foreach ($customerdetail as $customer) {
                if ($customer['_id']['$oid'] == $cursor['userId']) {
                    $customername = $customer['First_name'];
                    $rec['cus_name'] = $customername;
                    $rec['cus_id'] = $cursor['userId'];
                    $rec['phone'] = $customer['Phone'];
                    foreach ($customer['AddressLog'] as $add)
                        $rec['address'] = $add['address1'] . ' ' . $add['address2'];
                }
            }
            foreach ($cursor['driversLog'] as $driv) {
                foreach ($driverdetail as $driver) {
                    if ($driver['_id']['$oid'] == $driv['driverid'] && $driv['status'] == "7") {
                        $drivername = $driver['name'] . ' ' . $driver['lname'];
                        $rec['driv_name'] = $drivername;
                        $rec['driv_id'] = $driv['driverid'];
                        $rec['completed_dt'] = $driver['datetime'];
                    }
                }
            }
        }


        $order = array('UserId' => $rec['cus_id'], 'Amount' => $rec['subtotal_amount'], 'mas_fee' => $rec['deliverycharge'], 'tip_amount' => $rec['tip_amount'], 'app_commission' => $cursor['app_commission_amount']
            , 'Tax' => $rec['tax_amount'], 'Total' => $rec['total'], 'discount' => $rec['discount'], 'complete_dt' => $rec['completed_dt'],
            'DeleveredById' => $rec['driv_id'], 'DeleveredBy' => $rec['driv_name'], 'DeleveredAt' => $rec['completed_dt'], 'CustomerId' => $rec['cus_id'], 'CustomerNumber' => $rec['phone'],
            'CustomerName' => $rec['cus_name'], 'CustomerProfilePic' => 'http://postmenu.cloudapp.net/iDeliver/pics/' . $Slaveprofile_pic, 'InvoiceDate' => $rec['date'], 'InvoiceNo' => $OrderId,
            'Status' => $rec['status'], 'DateTime' => $rec['date'], 'id' => $cursor['_id']['$oid'], 'Items' => $Items);
        return $order;
    }

    /**
     *
     * add new broker in db
     *
     */
    /* function AddNewBroker(){

      $this->load->library('mongo_db');
      $document = array(
      "Fname" => $this->input->post("Firstname"),
      "Lname" => $this->input->post("Lastname"),
      "Email" => $this->input->post("Email"),
      "Password" => md5($this->input->post("Password")),
      "Role" => "Broker",
      "Parent" => "SuperAdmin",
      "Last_Login_Time" => NULL,
      "Last_Login_Ip" => NULL,
      "resetlink" => NULL

      );
      $this->mongo_db->insert('Col_Manage_Admin',$document);

      $template = "<h3>you are added as Admin  here is your login details</h3><br>"
      ."Emailid: ".$this->input->post("Email")."<br>".
      "Password: ".$this->input->post("Password")."<br>";
      $to[] = array(
      'email' =>$this->input->post("Email"),
      'name' => "prakash",
      'type' => "to");

      $from = "prakashjoshi9090@gmail.com";

      $subject ="Login Details";

      $this->mongo_db->sendMail($template, $to, $from,$subject);

      } */

//    function AddNewCategory() {
//
//        $this->load->library('mongo_db');
//
//
//        $CategoryId = $this->input->post("CategoryId");
//
//
////        echo $CategoryId;
//        if ($CategoryId != '') {
//             $array['Category'] = $this->input->post("Category");
//            $array['Description'] = $this->input->post("Description");
//            $array['BusinessId'] = $this->input->post("BusinessId");
//          echo  $this->mongo_db->update('ProductCategory', $array, array("_id" => new MongoDB\BSON\ObjectID($CategoryId)));
//        } else {
//            $count = $this->input->post("count");
////            $array = $this->input->post("FData");
//            $array['Category'] = $this->input->post("Category");
//            $array['Description'] = $this->input->post("Description");
//            $array['BusinessId'] = $this->input->post("BusinessId");
//            $array['count'] = (int) $count;
//           echo $this->mongo_db->insert('ProductCategory', $array);
//        }
//    }

    function AddNewCategory() {

        $this->load->library('mongo_db');


        $CategoryId = $this->input->post("CategoryId");


//        echo $CategoryId;
        if ($CategoryId != '') {
            $array = $this->input->post("FData");
            echo $this->mongo_db->update('ProductCategory', $array, array("_id" => new MongoDB\BSON\ObjectID($CategoryId)));
        } else {
            $count = $this->input->post("count");
            $array = $this->input->post("FData");
            $array['count'] = (int) $count;
            echo $this->mongo_db->insert('ProductCategory', $array);
        }
    }

    function AddNewSubCategory() {

        $this->load->library('mongo_db');

        $SubCategoryId = $this->input->post("SubCategoryId");

        if ($SubCategoryId != '') {
            $array = $this->input->post("FData");
//            print_r($array);
//            exit();
            echo $this->mongo_db->update('ProductSubCategory', $array, array("_id" => new MongoDB\BSON\ObjectID($SubCategoryId)));
        } else {
            $count = $this->input->post("count");
            $array = $this->input->post("FData");
//            print_r($array);
//            exit();
            $array['count'] = (int) $count;
            echo $this->mongo_db->insert('ProductSubCategory', $array);
        }
    }

    function AddNewAddOns() {

        $this->load->library('mongo_db');
        $AddOnId = $this->input->post("AddOnId");
        $Fdata = $this->input->post("FData");
        $man = '0';
        if (isset($Fdata['Mandatory'])) {
            $man = '1';
        }
        $multi = '0';
        if (isset($Fdata['Multiple'])) {
            $multi = '1';
        }
        $Fdata['Mandatory'] = $man;
        $Fdata['Multiple'] = $multi;

//        echo '<pre>';
//        print_r($Fdata);
//        exit();
//        
        if ($AddOnId != '') {
            $this->mongo_db->update('AddOns', $Fdata, array("_id" => new MongoDB\BSON\ObjectID($AddOnId)));
        } else {
            $this->mongo_db->insert('AddOns', $Fdata);
        }
    }

    function AddnewProduct() {

        $this->load->library('mongo_db');
        $ProductId = $this->input->post("ProductId");
//        echo $ProductId;
//        print_r($this->input->post("FData"));
        if ($ProductId != '') {
            $array = array('AddOns' => array());
            $this->mongo_db->update('products', $array, array("_id" => new MongoDB\BSON\ObjectID($ProductId)));
            $array = $this->input->post("FData");
//            echo'<pre>';
//            print_r($array);
//           exit();
            $this->mongo_db->update('products', $array, array("_id" => new MongoDB\BSON\ObjectID($ProductId)));
//            $this->mongo_db->update('products', array("_id" => new MongoDB\BSON\ObjectID($ProductId)), array('$set' => $this->input->post("FData")), array("multiple" => true));
        } else {
            $count = $this->input->post("count");
            $array = $this->input->post("FData");
//            echo'<pre>';
//             print_r($array);
//              exit();
            $array['count'] = (int) $count;
            $this->mongo_db->insert('products', $array);
        }
    }

    public function getsubcat() {
        $this->load->library('mongo_db');

        $val = $this->input->post('catID');

        $cursor = $this->mongo_db->get_where('ProvidersubCategory', array("Catid" => $val));

        $entities = '<select multiple class="form-control ui fluid dropdown"  id="subCatId" name="FData[subCategory][]" >
                                     <option value="">Select Sub-category</option>';
        foreach ($cursor as $d) {

            $entities .= '
                   <option value="' . $d['_id'] . '">' . implode($d['Subcategory'], ',') . '</option>';
        }
        $entities .= ' </select>';

        return $entities;
    }

    function UpdateProfile() {

        $this->load->library('mongo_db');
        $this->load->library('CallAPI');
        $BusinessId = $this->input->post("BusinessId");

        $senddata = $this->input->post("FData");     
    //    echo '<pre>';print_r( $senddata);die;
        $senddata['addressCompo']=json_decode($senddata['addressCompo']);
    
        
      if ($senddata['Category']) {
        $categoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($senddata['Category'])))->find_one('storeCategory');       
        $category[] = array('categoryId' => $data['CategoryId'], 'categoryName' => $categoryData['storeCategoryName'],'cartsAllowed' =>$categoryData['cartsAllowed'],'cartsAllowedMsg' =>$categoryData['cartsAllowedMsg']);
       
        } 

    $senddata['cartsAllowed']=$categoryData['cartsAllowed'];
    $senddata['cartsAllowedMsg']=$categoryData['cartsAllowedMsg'];


     

        if ($senddata['forcedAccept'] == 'on') {
            $senddata['forcedAccept'] = 1; // enable
            $senddata['forcedAcceptMsg'] = "Enable";
        } else {
            $senddata['forcedAccept'] = 2; // disable
            $senddata['forcedAcceptMsg'] = "Disable";
        }

        if ($senddata['autoDispatch'] == 'on') {
            $senddata['autoDispatch'] = 1; // enable
            $senddata['autoDispatchMsg'] = "Enable";
        } else {
            $senddata['autoDispatch'] = 0; // disable
            $senddata['autoDispatchMsg'] = "Disable";
        }

        if ($senddata['description']) {
            $senddata['description'] = $senddata['description'];
        } else {
            $senddata['description'] = [];
        }
        if ($senddata['billingAddress']) {
            $senddata['billingAddress'] = $senddata['billingAddress'];
        } else {
            $senddata['billingAddress'] = [];
        }

        $lang = $this->mongo_db->get('lang_hlp');
        $lanCodeArr = [];
        $lanIdArr = [];
        foreach ($lang as $lan) {
            $lanCodeArr[0] = "en";
            $lanIdArr[0] = "0";
            if ($lan['Active'] == 1) {
                array_push($lanCodeArr, $lan['langCode']);
                array_push($lanIdArr, $lan['lan_id']);
            }
        }

        if (count($lanCodeArr) == count($senddata['name'])) {
            $senddata['sName'] = array_combine($lanCodeArr, $senddata['name']);
        } else if (count($lanCodeArr) < count($senddata['name'])) {
            $senddata['sName']['en'] = $senddata['name'][0];

            foreach ($senddata['name'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $senddata['sName'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $senddata['sName'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $senddata['sName']['en'] = $senddata['name'][0];
        }

        if (count($lanCodeArr) == count($senddata['description'])) {
            $senddata['storedescription'] = array_combine($lanCodeArr, $senddata['description']);
        } else if (count($lanCodeArr) < count($senddata['description'])) {
            $senddata['storedescription']['en'] = $senddata['description'][0];

            foreach ($senddata['description'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $senddata['storedescription'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $senddata['storedescription'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $senddata['storedescription']['en'] = $senddata['description'][0];
        }

        if (count($lanCodeArr) == count($senddata['businessAddress'])) {
            $senddata['storeAddr'] = array_combine($lanCodeArr, $senddata['businessAddress']);
        } else if (count($lanCodeArr) < count($senddata['businessAddress'])) {
            $senddata['storeAddr']['en'] = $senddata['businessAddress'][0];

            foreach ($senddata['businessAddress'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $senddata['storeAddr'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $senddata['storeAddr'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $senddata['storeAddr']['en'] = $senddata['businessAddress'][0];
        }

        if (count($lanCodeArr) == count($senddata['billingAddress'])) {
            $senddata['storeBillingAddr'] = array_combine($lanCodeArr, $senddata['billingAddress']);
        } else if (count($lanCodeArr) < count($senddata['billingAddress'])) {
            $senddata['storeBillingAddr']['en'] = $senddata['billingAddress'][0];

            foreach ($senddata['billingAddress'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $senddata['storeBillingAddr'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $senddata['storeBillingAddr'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $senddata['storeBillingAddr']['en'] = $senddata['billingAddress'][0];
        }

        $this->session->set_userdata('profileimg', $senddata['profileLogos']['logoImage']);

        //$senddata['driverType'] = (int) $senddata['driverType'];
        $senddata['driverType'] = 1;
       if ($senddata['driverType'] == 1) {
           $senddata['driverTypeMsg'] = "Freelance";
       } else {
           $senddata['driverTypeMsg'] = "storeDriver";
       }

        $senddata['profileLogos']['logoImage'] = $senddata['profileLogos']['logoImage'];
        if ($senddata['profileLogos']['seoAllText']) {
            $senddata['profileLogos']['seoAllText'] = $senddata['profileLogos']['seoAllText'];
        } else {
            $senddata['profileLogos']['seoAllText'] = '';
        }
        if ($senddata['profileLogos']['seoTitle']) {
            $senddata['profileLogos']['seoTitle'] = $senddata['profileLogos']['seoTitle'];
        } else {
            $senddata['profileLogos']['seoTitle'] = '';
        }
        if ($senddata['profileLogos']['seoDescription']) {
            $senddata['profileLogos']['seoDescription'] = $senddata['profileLogos']['seoDescription'];
        } else {
            $senddata['profileLogos']['seoDescription'] = '';
        }
        if ($senddata['profileLogos']['seoKeyword']) {
            $senddata['profileLogos']['seoKeyword'] = $senddata['profileLogos']['seoKeyword'];
        } else {
            $senddata['profileLogos']['seoKeyword'] = '';
        }

        $senddata['bannerLogos']['bannerimage'] = $senddata['bannerLogos']['bannerimage'];
        if ($senddata['bannerLogos']['seoAllText']) {
            $senddata['bannerLogos']['seoAllText'] = $senddata['bannerLogos']['seoAllText'];
        } else {
            $senddata['bannerLogos']['seoAllText'] = '';
        }
        if ($senddata['bannerLogos']['seoTitle']) {
            $senddata['bannerLogos']['seoTitle'] = $senddata['bannerLogos']['seoTitle'];
        } else {
            $senddata['bannerLogos']['seoTitle'] = '';
        }
        if ($senddata['bannerLogos']['seoDescription']) {
            $senddata['bannerLogos']['seoDescription'] = $senddata['bannerLogos']['seoDescription'];
        } else {
            $senddata['bannerLogos']['seoDescription'] = '';
        }
        if ($senddata['bannerLogos']['seoKeyword']) {
            $senddata['bannerLogos']['seoKeyword'] = $senddata['bannerLogos']['seoKeyword'];
        } else {
            $senddata['bannerLogos']['seoKeyword'] = '';
        }

        if ($senddata['countryCode']) {
            $send1['code'] = explode('+', $senddata['countryCode']);
            if (count($send1['code']) > 1)
                $senddata['countryCode'] = '+' . $send1['code'][1];
            else
                $senddata['countryCode'] = '+' . $senddata['countryCode'];
        } else {
            $senddata['countryCode'] = '+91';
        }
        if ($senddata['bCountryCode']) {
            $send['code1'] = explode('+', $senddata['bCountryCode']);
            if (count($send['code1']) > 1)
                $senddata['bCountryCode'] = '+' . $send['code1'][1];
            else
                $senddata['bCountryCode'] = '+' . $senddata['bCountryCode'];
        } else {
            $senddata['bCountryCode'] = '+91';
        }

        $senddata['countryId'] = (string) $senddata['countryId'];


        $senddata['pricingStatus'] = (string) $senddata['pricingStatus'];
        if ($senddata['pricingStatus'] == 0) {
            $senddata['pricingStatusMsg'] = "zonalPricing";
        } else {
            $senddata['pricingStatusMsg'] = "mileagePricing";
        }

        if ($senddata['pickupCash']) {
            $senddata['pickupCashMsg'] = "Enable";
        } else {
            $senddata['pickupCash'] = 0;
            $senddata['pickupCashMsg'] = "Disable";
        }
        if ($senddata['pickupCard']) {
            $senddata['pickupCardMsg'] = "Enable";
        } else {
            $senddata['pickupCard'] = 0;
            $senddata['pickupCardMsg'] = "Disable";
        }

        if ($senddata['deliveryCash']) {
            $senddata['deliveryCashMsg'] = "Enable";
        } else {
            $senddata['deliveryCash'] = 0;
            $senddata['deliveryCashMsg'] = "Disable";
        }
        if ($senddata['deliveryCard']) {
            $senddata['deliveryCardMsg'] = "Enable";
        } else {
            $senddata['deliveryCard'] = 0;
            $senddata['deliveryCardMsg'] = "Disable";
        }

        if ($senddata['orderType'] == 2) {
            $senddata['orderTypeMsg'] = "pickupOrder";          

            $senddata['pickupCash'] = 0;
            $senddata['pickupCashMsg'] = "Disable";
            $senddata['pickupCard'] = 0;
            $senddata['pickupCardMsg'] = "Disable";

        } else if ($senddata['orderType'] == 1) {

            $senddata['orderTypeMsg'] = "deliveryOrder";
            $senddata['deliveryCash'] = 0;
            $senddata['deliveryCashMsg'] = "Disable";
            $senddata['deliveryCard'] = 0;
            $senddata['deliveryCardMsg'] = "Disable";
          
        } else {
            $senddata['orderTypeMsg'] = "bothOtder";
        }
       // echo '<pre>';print_r( $senddata['coordinates']);die;
        $dat = array('latitude' => $senddata['coordinates']['latitude'], 'longitude' => $senddata['coordinates']['longitude']);       
        $url = APILink . 'business/zones';
        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        // echo '<pre>';print_r( $senddata['coordinates']);die;
        // print_r($response);
        if ($response['data']['_id']) {
            $senddata['businessZoneId'] = $response['data']['_id'];
            $senddata['businessZoneName'] = $response['data']['title'];
        } else {
            $senddata['businessZoneId'] = '';
            $senddata['businessZoneName'] = 'Non working Zone';
        }
        if ($senddata['businessZoneId'] != '') {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($senddata['businessZoneId'])))->push(array('zoneStores' => $BusinessId))->update('zones');
        }
        foreach ($senddata['serviceZones'] as $data) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data)))->push(array('servicingStores' => $BusinessId))->update('zones');
        }

        $senddata['storeAddr']= (string)$senddata['businessAddress'][0];
        $senddata['storeBillingAddr']= (string)$senddata['billingAddress'][0];
        $senddata['bcountryCode']= $senddata['bCountryCode'];

        $senddata['businessZoneId'] = '0';
        $senddata['coordinates']['longitude'] = (double) $senddata['coordinates']['longitude'];
        $senddata['coordinates']['latitude'] = (double) $senddata['coordinates']['latitude'];
        $senddata['orderEmail']=$senddata['OrderEmail'];
        // string changes
        $senddata['storeId']=(string)$BusinessId;
        $senddata['commission']=0;
        $senddata[ 'commissionType'] = 0;
        $senddata[ 'storeType'] =  $senddata[ 'storeType'];
        $senddata[ 'storeTypeMsg'] =  $senddata[ 'storeTypeMsg'];
        $senddata[ 'addressCompo']=(object)$senddata[ 'addressCompo'];
       // echo '<pre>';print_r( $senddata['coordinates']);die;
       
        $senddata['minimumOrder'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'minimumOrder']));
        $senddata['freeDeliveryAbove'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'freeDeliveryAbove']));
        $senddata['avgDeliveryTime'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'avgDeliveryTime']));
        $senddata['baseFare'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'baseFare']));
        $senddata['mileagePrice'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'mileagePrice']));
        $senddata['mileagePriceAfterMinutes'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'mileagePriceAfterMinutes']));
        $senddata['timeFee'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'timeFee']));
        $senddata['timeFeeAfterMinutes'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'timeFeeAfterMinutes']));
        $senddata['waitingFee'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'waitingFee']));
        $senddata['waitingFeeAfterMinutes'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'waitingFeeAfterMinutes']));
        $senddata['minimumFare'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'minimumFare']));
        $senddata['onDemandBookingsCancellationFee'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'onDemandBookingsCancellationFee']));
        $senddata['onDemandBookingsCancellationFeeAfterMinutes'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'onDemandBookingsCancellationFeeAfterMinutes']));
        $senddata['scheduledBookingsCancellationFee'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'scheduledBookingsCancellationFee']));
        $senddata['scheduledBookingsCancellationFeeAfterMinutes'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'scheduledBookingsCancellationFeeAfterMinutes']));
        $senddata['convenienceFee'] = preg_replace('/[ ,]+/', '', trim($senddata[ 'convenienceFee']));
        $senddata['convenienceFee']=(float)$senddata['convenienceFee'];
        $senddata['convenienceType']=(int)$senddata['convenienceType'];
        if($senddata['billingAddress'][0]==""){
           
            $senddata['storeBillingAddr']=" ";
        }else{
           
            $senddata['storeBillingAddr']= $senddata['billingAddress'][0];
        }

      
        unset($senddata['bCountryCode']);
        unset($senddata['businessAddress']);
        unset($senddata['billingAddress']);
        unset($senddata['OrderEmail']);
        unset($senddata['Category']);
        
       // unset($senddata['addressCompo']);
       
       // echo '<pre>';print_r($senddata);die;
        $dispatchUrl = APILink . 'store';       
        $addToMongo = json_decode($this->callapi->CallAPI('PATCH', $dispatchUrl, $senddata), true);
        // echo '<pre>';print_r($addToMongo);die;
       echo json_encode($addToMongo);
  

        //echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($BusinessId)))->set($senddata)->update('stores');

    }

    function getZonesWithCities() {

        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("city_ID" => $val))->get('zones');
        if ($cursor) {
            $entitiesData = array();
            $entityData = [];
            foreach ($cursor as $dat) {
                $entityData['id'] = $dat['_id']['$oid'];
                $entityData['title'] = $dat['title'];
                array_push($entitiesData, $entityData);
                // array_push($entities, '<option data-name="' . $dat['title'] . '" value="' . $dat['_id']['$oid'] . '">' . $dat['title'] . '</option>');
            }

            echo json_encode(array('data' => $entitiesData));
        } else {
            $entities = array();
            $entities = '<option value="">Select Zones</option>';
            $entities .= '<option data-name="" value="">' . 'No zones to select' . '</option>';
            echo $entities;
        }
    }

    function editpassword() {

        $this->load->library('mongo_db');
        $BusinessId = $this->session->userdata('badmin')['BizId'];
        $senddata = $_POST;

        echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($BusinessId)))->set($senddata)->update('stores');
        
    }

    function ResetPwd() {

        $this->load->library('mongo_db');
        $resetlink = $this->input->post('For');
        $senddata = $this->input->post("reNewPwd");
        $check = $this->mongo_db->update('ProviderData', array('Password' => $senddata, 'resetlink' => ''), array("resetlink" => $resetlink));
        if ($check) {
            $entities = array('flag' => 0);
        } else {
            $entities = array('flag' => 1);
        }

        return $entities;
    }

    /**
     *
     * add new admin in db
     *
     */
    function AddNewAdmin() {

        $this->load->library('mongo_db');

        $email = $this->input->post("FData");
        $password = $this->input->post("Password");
        $document = array(
            "Fname" => $this->encrypt_decrypt('encrypt', $this->input->post("Firstname")),
            "Lname" => $this->encrypt_decrypt('encrypt', $this->input->post("Lastname")),
            "Email" => $this->encrypt_decrypt('encrypt', $email),
            "Password" => $this->encrypt_decrypt('encrypt', $password),
            "Type" => $this->encrypt_decrypt('encrypt', $this->input->post("type")),
            "Role" => $this->encrypt_decrypt('encrypt', "Admin"),
            "Parent" => $this->encrypt_decrypt('encrypt', "SuperAdmin"),
            "Last_Login_Time" => NULL,
            "Last_Login_Ip" => NULL,
            "resetlink" => NULL
        );

        $this->mongo_db->insert('Col_Manage_Admin', $document);

        $template = "<h3>you are added as Admin  here is your login details</h3><br>"
                . "Emailid: " . $email . "<br>" .
                "Password: " . $password . "<br>";
        $to[] = array(
            'email' => $email,
            'name' => "prakash",
            'type' => "to");

        $from = "prakashjoshi9090@gmail.com";

        $subject = "Login Details";

        $this->mongo_db->sendMail($template, $to, $from, $subject);
    }

    function ChangePassword($NewPassword, $EmailId) {
        $this->load->library('mongo_db');
        $this->mongo_db->update('Col_Manage_Admin', array("Email" => $EmailId), array('$set' => array("Password" => md5($NewPassword))), array("multiple" => true));
        $this->session->set_userdata('password', $NewPassword);
    }

    function ForgotPassword($useremail) {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->count_all_results('ProviderData', array('Email' => $useremail));

        if ($cursor > 0) {
            $data = $this->mongo_db->get_one('ProviderData', array('Email' => $useremail));

            $rlink = uniqid(md5(mt_rand()));
            $this->mongo_db->update('ProviderData', array("resetlink" => ($rlink)), array("Email" => $useremail));

            $resetlink = base_url() . "index.php/Admin/ResetPwd/" . $rlink;

//            echo $resetlink;

            $template = "<h3> <a href='" . $resetlink . "'>Click Here</a> to reset your password</h3><br>";
            $to[] = array(
                'email' => $useremail,
                'name' => $data['ProviderName'],
                'type' => "to");

            $from = "noreply@iDeliver.mobi";
            $subject = "Reset Password Link";
            $this->mongo_db->sendMail($template, $to, $from, $subject);

            return true;
        }
        return false;
    }

    function VerifyResetLink($vlink) {
        $this->load->library('mongo_db');

        $cursor = $this->mongo_db->get_where('Col_Manage_Admin', array('resetlink' => $vlink));

        if ($cursor) {
            $password = md5("joshi");
            $this->mongo_db->update('Col_Manage_Admin', array("resetlink" => $vlink), array("Password" => $password));


            return true;
        }
        return false;
    }

    /**
     *
     * validate email is available in database
     */
    function validateEmail() {
        $this->load->library('mongo_db');
        $cout = $this->mongo_db->count_all_results('Col_Manage_Admin', array('Email' => $this->encrypt_decrypt('encryt', $this->input->post('email'))));
        $result = 0;
        if ($cout > 0) {
            $result = 1;
            if ($this->input->post('dofor') == 2) {
                $secount = $this->mongo_db->count_all_results('Col_Manage_Admin', array('Email' => $this->encrypt_decrypt('encryt', $this->input->post('email')), '_id' => new MongoDB\BSON\ObjectID($this->input->post('m_id'))));
                if ($secount > 0)
                    $result = 0;
                else
                    $result = 1;
            }
        }
        echo json_encode(array('msg' => $result));
    }

    /*
     *
     * Edit admin and broker Creation details
     *
     */

    function EditNewAdmin() {

        $this->load->library('mongo_db');
        $fdata = $this->input->post('fdata');
        $this->mongo_db->update('Col_Manage_Admin', array("Fname" => $this->encrypt_decrypt('encrypt', $fdata['Firstname']), "Lname" => $this->encrypt_decrypt('encrypt', $fdata['Lastname']), "Email" => $this->encrypt_decrypt('encrypt', $fdata['Email']), "Password" => $this->encrypt_decrypt('encrypt', $fdata['Password'])), array("_id" => new MongoDB\BSON\ObjectID($fdata['mongoidtoupdate'])));
    }

    /*
     *
     * Delete admin and broker Creation details
     *
     */

    function DeleteUser() {
        $this->load->library('mongo_db');
        $this->mongo_db->delete('Col_Manage_Admin', array('_id' => new MongoDB\BSON\ObjectID($this->input->post('mongo_id_del'))));
    }

    /*
     *
     * Add different entities to db with an encryption
     *
     */

    function AddNewEntity($tablename) {
        $this->load->library('mongo_db');
//uploading documents to document folder
        $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/apps/RylandInsurence/Documents/';
        $doumentname = $_FILES['entitydocfile']['name'];
        $docext = substr($doumentname, strrpos($doumentname, '.') + 1);

        $documentfilename = md5(uniqid() . time()) . "." . $docext;
        $docfiletostore = $documentfolder . $documentfilename;

        $Documentpath = $documentfolder . $documentfilename;

        try {

            $move = move_uploaded_file($_FILES['entitydocfile']['tmp_name'], $docfiletostore);
        } catch (Exception $ex) {
            print_r($ex);
            return false;
        }


//upload signatory image to signatory folder
        $Signatoryfolder = $_SERVER['DOCUMENT_ROOT'] . '/apps/RylandInsurence/Signatory/';
        $signatoryimagename = $_FILES['entitysignatoryfile']['name'];

        $signatoryext = substr($signatoryimagename, strrpos($signatoryimagename, '.') + 1);

        $signatoryimagename = md5(uniqid() . time()) . "." . $signatoryext;
        $signatoryfiletostore = $Signatoryfolder . $signatoryimagename;

        $Signatorypath = $Signatoryfolder . $signatoryimagename;

        try {
            $move = move_uploaded_file($_FILES['entitysignatoryfile']['tmp_name'], $signatoryfiletostore);
        } catch (Exception $ex) {
            print_r($ex);
            return false;
        }




        $id = new MongoDB\BSON\ObjectID();

        $ids = array("_id" => $id);
        $this->mongo_db->insert('documents', $ids);
        $this->mongo_db->insert('signatory', $ids);

        $document = array('documentdetails' => array(
                'DocumentId' => new MongoDB\BSON\ObjectID(),
                'Documentname' => $this->encrypt_decrypt('encrypt', $this->input->post("entitydocname")),
                'Documentdescription' => $this->encrypt_decrypt('encrypt', $this->input->post("entitydescription")),
                'Documentpath' => $this->encrypt_decrypt('encrypt', $Documentpath),
                'Issuedate' => $this->encrypt_decrypt('encrypt', $this->input->post("entityissuedate")),
                'Expirydate' => $this->encrypt_decrypt('encrypt', $this->input->post("entityexpirydate"))
            ),
        );

        $this->mongo_db->updatewithpush('documents', $document, array("_id" => $id));

        $signatory = array('signatorydetails' => array(
                'SignatoryId' => new MongoDB\BSON\ObjectID(),
                'Signatorypname' => $this->encrypt_decrypt('encrypt', $this->input->post("entitypersonname")),
                'Signatorydescription' => $this->encrypt_decrypt('encrypt', $this->input->post("entitysignatorydescription")),
                'Signatorypath' => $this->encrypt_decrypt('encrypt', $Signatorypath),
                'Signatorypmobileno' => $this->encrypt_decrypt('encrypt', $this->input->post("entitysignatorymobileno")),
                'Spdesignation' => $this->encrypt_decrypt('encrypt', $this->input->post("entitydegination")),
                'Spemail' => $this->encrypt_decrypt('encrypt', $this->input->post("entitysignatoryemail"))
        ));

        $this->mongo_db->updatewithpush('signatory', $signatory, array("_id" => $id));

        $entitydata = array
            (
            "_id" => $id,
            "Name" => $this->encrypt_decrypt('encrypt', $this->input->post("entityname")),
            "Email" => $this->encrypt_decrypt('encrypt', $this->input->post("entityemail")),
            "Status" => $this->encrypt_decrypt('encrypt', $this->input->post("entitystatus")),
            "Registration_No" => $this->encrypt_decrypt('encrypt', $this->input->post("entityregno")),
            "Address" => $this->encrypt_decrypt('encrypt', $this->input->post("entityaddress")),
            "Town" => $this->encrypt_decrypt('encrypt', $this->input->post("entitytown")),
            "State" => $this->encrypt_decrypt('encrypt', $this->input->post("entitystate")),
            "Country" => $this->encrypt_decrypt('encrypt', $this->input->post("entitycountry")),
            "PObox" => $this->encrypt_decrypt('encrypt', $this->input->post("entitypobox")),
            "Zipcode" => $this->encrypt_decrypt('encrypt', $this->input->post("entityzipcode")),
            "Countrycode" => $this->encrypt_decrypt('encrypt', $this->input->post("countrycode")),
            "Last_Login_Time" => $this->encrypt_decrypt('encrypt', "NULL"),
            "Last_Login_Ip" => $this->encrypt_decrypt('encrypt', "NULL")
        );

        $this->mongo_db->insert($tablename, $entitydata);
    }

//load different entities
    public function LoadEntity($tablename = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get($tablename);

        $entities = array();
        $i = 0;
        foreach ($cursor as $data) {
            $data['Name'] = $this->encrypt_decrypt('decrypt', $data['Name']);
            $data['Email'] = $this->encrypt_decrypt('decrypt', $data['Email']);
            $data['Status'] = $this->encrypt_decrypt('decrypt', $data['Status']);
            $data['Last_Login_Time'] = $this->encrypt_decrypt('decrypt', $data['Last_Login_Time']);
            $data['Last_Login_Ip'] = $this->encrypt_decrypt('decrypt', $data['Last_Login_Ip']);
            $entities[$i] = $data;
            $i++;
        }
        return $entities;
    }

    public function loadOneEntity($tablename = '', $entityid = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_one($tablename, array("_id" => new MongoDB\BSON\ObjectID($entityid)));

        $cursor['Name'] = $this->encrypt_decrypt('decrypt', $cursor['Name']);
        $cursor['Email'] = $this->encrypt_decrypt('decrypt', $cursor['Email']);
        $cursor['Status'] = $this->encrypt_decrypt('decrypt', $cursor['Status']);
        $cursor['Registration_No'] = $this->encrypt_decrypt('decrypt', $cursor['Registration_No']);
        $cursor['Address'] = $this->encrypt_decrypt('decrypt', $cursor['Address']);
        $cursor['Town'] = $this->encrypt_decrypt('decrypt', $cursor['Town']);
        $cursor['State'] = $this->encrypt_decrypt('decrypt', $cursor['State']);
        $cursor['Country'] = $this->encrypt_decrypt('decrypt', $cursor['Country']);
        $cursor['PObox'] = $this->encrypt_decrypt('decrypt', $cursor['PObox']);
        $cursor['Zipcode'] = $this->encrypt_decrypt('decrypt', $cursor['Zipcode']);
        $cursor['Countrycode'] = $this->encrypt_decrypt('decrypt', $cursor['Countrycode']);

        $documents = $this->mongo_db->get_one('documents', array("_id" => new MongoDB\BSON\ObjectID($entityid)));

        $cursor['DocumentId'] = $documents['documentdetails'][0]['DocumentId'];
        $cursor['Documentname'] = $this->encrypt_decrypt('decrypt', $documents['documentdetails'][0]['Documentname']);
        $cursor['Documentdescription'] = $this->encrypt_decrypt('decrypt', $documents['documentdetails'][0]['Documentdescription']);
        $cursor['Documentpath'] = $this->encrypt_decrypt('decrypt', $documents['documentdetails'][0]['Documentpath']);
        $cursor['Issuedate'] = $this->encrypt_decrypt('decrypt', $documents['documentdetails'][0]['Issuedate']);
        $cursor['Expirydate'] = $this->encrypt_decrypt('decrypt', $documents['documentdetails'][0]['Expirydate']);

        $signatory = $this->mongo_db->get_one('signatory', array("_id" => new MongoDB\BSON\ObjectID($entityid)));

        $cursor['SignatoryId'] = $signatory['signatorydetails'][0]['SignatoryId'];
        $cursor['Signatorypname'] = $this->encrypt_decrypt('decrypt', $signatory['signatorydetails'][0]['Signatorypname']);
        $cursor['Signatorydescription'] = $this->encrypt_decrypt('decrypt', $signatory['signatorydetails'][0]['Signatorydescription']);
        $cursor['Signatorypath'] = $this->encrypt_decrypt('decrypt', $signatory['signatorydetails'][0]['Signatorypath']);
        $cursor['Signatorypmobileno'] = $this->encrypt_decrypt('decrypt', $signatory['signatorydetails'][0]['Signatorypmobileno']);
        $cursor['Spdesignation'] = $this->encrypt_decrypt('decrypt', $signatory['signatorydetails'][0]['Spdesignation']);
        $cursor['Spemail'] = $this->encrypt_decrypt('decrypt', $signatory['signatorydetails'][0]['Spemail']);

        return $cursor;
    }

    public function DeleteEntity($tablename = '', $entityid = '') {
        $this->load->library('mongo_db');

//first delete all stored documents of related entity
        $documents = $this->mongo_db->get_one('documents', array("_id" => new MongoDB\BSON\ObjectID($entityid)));

        foreach ($documents['documentdetails'] as $data) {
            $documentsfile = $this->encrypt_decrypt('decrypt', $data['Documentpath']);
            if (file_exists($documentsfile)) {
                unlink($documentsfile);
            }
        }

        $signatory = $this->mongo_db->get_one('signatory', array("_id" => new MongoDB\BSON\ObjectID($entityid)));

        foreach ($signatory['signatorydetails'] as $data) {
            $signatoryfile = $this->encrypt_decrypt('decrypt', $data['Signatorypath']);
            if (file_exists($signatoryfile)) {
                unlink($signatoryfile);
            }
        }

//now delete all the records for entity from different collections

        $this->mongo_db->delete('documents', array("_id" => new MongoDB\BSON\ObjectID($entityid)));
        $this->mongo_db->delete('signatory', array("_id" => new MongoDB\BSON\ObjectID($entityid)));
        $this->mongo_db->delete($tablename, array("_id" => new MongoDB\BSON\ObjectID($entityid)));
    }

// edit different entities with entityid
    function EditEntity($tablename, $entityid) {
//remove old uploaded documents signatory and upload newly added on server if not updated then
//remove keep old document as it is

        $olddocpath = $this->input->post("olddocpath");
        $oldsignatorypath = $this->input->post("oldsignatorypath");

        $did = $this->input->post("documentid");
        $sid = $this->input->post("signatoryid");

        $this->load->library('mongo_db');

        if ($_FILES['entitydocfile']['name']) {
            if (file_exists($olddocpath)) {
                unlink($olddocpath);
            }

            $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/apps/RylandInsurence/Documents/';
            $doumentname = $_FILES['entitydocfile']['name'];
            $docext = substr($doumentname, strrpos($doumentname, '.') + 1);

            $documentfilename = md5(uniqid() . time()) . "." . $docext;
            $docfiletostore = $documentfolder . $documentfilename;

            $Documentpath = $documentfolder . $documentfilename;

            try {

                $move = move_uploaded_file($_FILES['entitydocfile']['tmp_name'], $docfiletostore);
            } catch (Exception $ex) {
                print_r($ex);
                return false;
            }
        } else {
            $Documentpath = $olddocpath;
        }

        if ($_FILES['entitysignatoryfile']['name']) {
            if (file_exists($oldsignatorypath)) {
                unlink($oldsignatorypath);
            }

            $Signatoryfolder = $_SERVER['DOCUMENT_ROOT'] . '/apps/RylandInsurence/Signatory/';
            $signatoryimagename = $_FILES['entitysignatoryfile']['name'];

            $signatoryext = substr($signatoryimagename, strrpos($signatoryimagename, '.') + 1);

            $signatoryimagename = md5(uniqid() . time()) . "." . $signatoryext;
            $signatoryfiletostore = $Signatoryfolder . $signatoryimagename;

            $Signatorypath = $Signatoryfolder . $signatoryimagename;

            try {
                $move = move_uploaded_file($_FILES['entitysignatoryfile']['tmp_name'], $signatoryfiletostore);
            } catch (Exception $ex) {
                print_r($ex);
                return false;
            }
        } else {
            $Signatorypath = $oldsignatorypath;
        }

        /* $updateData = array('productsetup.$.size' => $size, 'productsetup.$.color' => $color, 'productsetup.$.price' => $price,'productsetup.$.offerprice' => $offerprice,'productsetup.$.taxids' => $taxid, 'productsetup.$.taxvalues' => $taxvalue);
          $cond = array('_id' => new MongoDB\BSON\ObjectID($pre_id), 'productsetup' => array('$elemMatch' => array('setup_id' => new MongoDB\BSON\ObjectID($setupid))));
          $SubCats->update($cond, array('$set' => $updateData), array('multiple' => 1)); */

        $updatedocument = array(
            'documentdetails.$.Documentname' => $this->encrypt_decrypt('encrypt', $this->input->post("entitydocname")),
            'documentdetails.$.Documentdescription' => $this->encrypt_decrypt('encrypt', $this->input->post("entitydescription")),
            'documentdetails.$.Documentpath' => $this->encrypt_decrypt('encrypt', $Documentpath),
            'documentdetails.$.Issuedate' => $this->encrypt_decrypt('encrypt', $this->input->post("entityissuedate")),
            'documentdetails.$.Expirydate' => $this->encrypt_decrypt('encrypt', $this->input->post("entityexpirydate"))
        );

        $cond = array('_id' => new MongoDB\BSON\ObjectID($entityid), 'documentdetails' => array('$elemMatch' => array('DocumentId' => new MongoDB\BSON\ObjectID($did))));
        $this->mongo_db->update('documents', $updatedocument, $cond);

        $updatesignatory = array(
            'signatorydetails.$.Signatorypname' => $this->encrypt_decrypt('encrypt', $this->input->post("entitypersonname")),
            'signatorydetails.$.Signatorydescription' => $this->encrypt_decrypt('encrypt', $this->input->post("entitysignatorydescription")),
            'signatorydetails.$.Signatorypath' => $this->encrypt_decrypt('encrypt', $Signatorypath),
            'signatorydetails.$.Signatorypmobileno' => $this->encrypt_decrypt('encrypt', $this->input->post("entitysignatorymobileno")),
            'signatorydetails.$.Spdesignation' => $this->encrypt_decrypt('encrypt', $this->input->post("entitydegination")),
            'signatorydetails.$.Spemail' => $this->encrypt_decrypt('encrypt', $this->input->post("entitysignatoryemail"))
        );

        $scond = array('_id' => new MongoDB\BSON\ObjectID($entityid), 'signatorydetails' => array('$elemMatch' => array('SignatoryId' => new MongoDB\BSON\ObjectID($sid))));
        $this->mongo_db->update('signatory', $updatesignatory, $scond);

        $updateentitydata = array
            (
            "Name" => $this->encrypt_decrypt('encrypt', $this->input->post("entityname")),
            "Email" => $this->encrypt_decrypt('encrypt', $this->input->post("entityemail")),
            "Status" => $this->encrypt_decrypt('encrypt', $this->input->post("entitystatus")),
            "Registration_No" => $this->encrypt_decrypt('encrypt', $this->input->post("entityregno")),
            "Address" => $this->encrypt_decrypt('encrypt', $this->input->post("entityaddress")),
            "Town" => $this->encrypt_decrypt('encrypt', $this->input->post("entitytown")),
            "State" => $this->encrypt_decrypt('encrypt', $this->input->post("entitystate")),
            "Country" => $this->encrypt_decrypt('encrypt', $this->input->post("entitycountry")),
            "PObox" => $this->encrypt_decrypt('encrypt', $this->input->post("entitypobox")),
            "Zipcode" => $this->encrypt_decrypt('encrypt', $this->input->post("entityzipcode")),
            "Countrycode" => $this->encrypt_decrypt('encrypt', $this->input->post("countrycode")),
            "Last_Login_Time" => $this->encrypt_decrypt('encrypt', "NULL"),
            "Last_Login_Ip" => $this->encrypt_decrypt('encrypt', "NULL")
        );

        $this->mongo_db->update($tablename, $updateentitydata, array("_id" => new MongoDB\BSON\ObjectID($entityid)));
    }

// image uploading to aws


    function uploadImageToAmazone() {
        $name = $_FILES['OtherPhoto']['name']; // filename to get file's extension
        $size = $_FILES['OtherPhoto']['size'];

        $fold_name = $_REQUEST['folder'];
        $type = $_REQUEST['type'];

        $ext = substr($name, strrpos($name, '.') + 1);

        $currentDate = getdate();
        $rename_file = "file" . $currentDate['year'] . $currentDate['mon'] . $currentDate['mday'] . $currentDate['hours'] . $currentDate['minutes'] . $currentDate['seconds'] . "." . $ext;
        $flag = FALSE;

        $tmp1 = $_FILES['OtherPhoto']['tmp_name'];

        $uploadFile = $tmp1;
        $bucketName = AMAZON_S3_BUCKET_NAME;
//        print_r($uploadFile);
//        die;
        if (!file_exists($uploadFile) || !is_file($uploadFile)) {
            echo 'if-1';
            exit("\nERROR: No such file: $uploadFile\n\n");
        }
        if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll')) {
            exit("\nERROR: CURL extension not loaded\n\n");
        }

        if (AMAZON_AWS_ACCESS_KEY == 'change-this' || AMAZON_AWS_AUTH_SECRET == 'change-this') {
            exit("\nERROR: AWS access information required\n\nPlease edit the following lines in this file:\n\n" .
                    "define('AMAZON_AWS_ACCESS_KEY', 'change-me');\ndefine('AMAZON_AWS_AUTH_SECRET', 'change-me');\n\n");
        }


        // Instantiate the class
        $s3 = new S3(AMAZON_AWS_ACCESS_KEY, AMAZON_AWS_AUTH_SECRET);
//        print_r($uploadFile); die;
        //// Put our file (also with public read access)
        if ($s3->putObjectFile($uploadFile, $bcketName, $type . '/' . $fold_name . '/' . $rename_file, S3::ACL_PUBLIC_READ)) {
            $flag = true;
        }

        if ($flag) {
            echo json_encode(array('msg' => '1', 'fileName' => $bucketName . '/' . $type . '/' . $fold_name . '/' . $rename_file));
        } else {
            echo json_encode(array('msg' => '2', 'folder' => $fold_name));
        }
        // return;
    }

    public function getStoreCurrency($id) {
        $getStoreDetails = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('stores');
        $cityId = new MongoDB\BSON\ObjectID($getStoreDetails['cityId']);
        $getCityDetails = $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($cityId)))->find_one('cities');
        echo json_encode(array('data' => $getCityDetails));
    }

}

?>
