<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Businessmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('utility_library');
    }

    function deleteStore() {
        $this->load->library('elasticsearch');
        $id = $this->input->post('val');
        $ids = $this->input->post('id');
        foreach ($id as $row) {
            $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->delete('stores');
        }
        $this->elasticsearch->delete("stores", $ids);
        echo json_encode(array('msg' => 1));
    }

    function businessData() {

        $MAsterData = $this->mongo_db->get('stores');
        $data = array();

        foreach ($MAsterData as $driver) {
            $data[] = array('businessname' => $driver['ProviderName'], 'masterid' => ($driver['_id']['$oid']));
        }

        return $data;
    }

    function get_lan_hlpText($param = '') {

        if ($param == '') {
            $where = array('Active' => 1);
            $res = $this->mongo_db->get_where('lang_hlp', $where);
        } else {
            $where = array('$and' => array(array('lan_id' => (int) $param), array('Active' => 1)));
            $res = $this->mongo_db->get_where('lang_hlp', $where);
        }
        return $res;
    }

    function getCountryCities() {

        $country = $this->mongo_db->get("cities");
        foreach ($country as $coun) {
            $res[] = $coun;
        }
        return $res;
    }

    function datatable_business($status = '') {

        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "Category";
        $_POST['mDataProp_2'] = "Email";

        $respo = $this->datatables->datatable_mongodb('stores', array('status' => (int) $status), '', 1);


        $aaData = $respo["aaData"];
        $datatosend = array();
        $index = 0;
        foreach ($aaData as $value) {
            if ($value['status'] == '1') {
                $string = "Active";
            } else if ($value['status'] == '3') {
                $string = "New";
            } else if ($value['status'] == '5') {
                $string = "Inctive";
            } else if ($value['status'] == '6') {
                $string = "Active";
            }

            $arr = array();
            $arr[] = ++$index;
//            $arr[] = $value['name'];
            $arr[] = '<a target="_blank" href="' . businessLink . 'Business/FromAdmin/' . (string) $value['_id']['$oid'] . '"  data-toggle="modal">' . implode($value['name'], ',') . ' </a>';
            $arr[] = ($value['franchiseName']) ? $value['franchiseName'] : "-";
//            $arr[] = '-';
            $arr[] = $value['ownerEmail'];
            $arr[] = $string;
            $arr[] = '<input type="checkbox"  data-id=' . $value['seqID'] . ' class="checkbox" value=' . $value['_id']['$oid'] . ' >';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function inactivebusinessmgt() {

        $val = $this->input->post('val');

        foreach ($val as $row) {
            echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array("status" => 5))->update('stores');
        }
//        echo json_encode(array("_id" => $val ));
    }

    function insert() {

        $this->load->library('CallAPI');
        $businessname = $this->input->post('BusinessName');
        $ownername = $this->input->post('OwnerName');
        $Phone = $this->input->post('Phone');
        $countryCode = $this->input->post('countryCode');
        $uemail = $this->input->post('Email');
        $businessNumber = $this->input->post('businessNumber');
        $password = $this->input->post('Password');
        $Website = $this->input->post('Website');
        $Description = $this->input->post('Description');
        $Address = $this->input->post('Address');
        $billingAddress = $this->input->post('billingAddress');
        $Longitude = $this->input->post('Longitude');
        $Latitude = $this->input->post('Latitude');
        $Country = $this->input->post('Country');
        $city = $this->input->post('city');
        $cityName = $this->input->post('cityName');
        $Postalcode = $this->input->post('Postalcode');
        $BusinessCategory = $this->input->post('CatId');
        $subCatId = $this->input->post('subCatId');
        $drivers = $this->input->post('drivers');
        $pricing = (int) $this->input->post('pricing');
        $minorderVal = $this->input->post('minorderVal');
        $freedelVal = $this->input->post('freedelVal');
        $Pcash = (int) $this->input->post('Pcash');
        $Pcredit = (int) $this->input->post('Pcredit_card');
        $Psadad = (int) $this->input->post('Psadad');
        $Dcash = (int) $this->input->post('Dcash');
        $Dcredit = (int) $this->input->post('Dcredit_card');
        $tier1 = (int) $this->input->post('tier1');
        $tier2 = (int) $this->input->post('tier2');
        $tier3 = (int) $this->input->post('tier3');

        $select = (int) $this->input->post('select');
        $basefare = (int) $this->input->post('basefare');
        $range = (int) $this->input->post('range');
        $priceperkm = (int) $this->input->post('priceperkm');
        $notes = $this->input->post('notes');
        $avgcooktime = $this->input->post('avgcooktime');
        $Budget = $this->input->post('Budget');
        $appDriver = $this->input->post('grocerDriver');
        $Storedriver = $this->input->post('storeDriver');
        $Offlinedriver = $this->input->post('Offlinedriver');
        $serviceZones = $this->input->post('serviceZones');


        if (!$drivers) {
            $drivers = 0;
        }
        $this->load->library('elasticsearch');
        $this->load->library('session');
        $this->session->set_userdata(array('Driver_session' => $drivers));

        $allMasters = $this->mongo_db->get('stores');
        $arr = [];

        foreach ($allMasters as $data) {
            array_push($arr, $data['seqID']);
        }
        $max = max($arr);
        $Buniqid = $max + 1;
        $dat = array('latitude' => $Latitude, 'longitude' => $Longitude);
        $url = APILink . 'business/zones';

        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);

        if ($response['data']['_id']) {
            $businessZoneId = $response['data']['_id'];
            $businessZoneName = $response['data']['title'];
        } else {
            $businessZoneId = '0';
            $businessZoneName = 'Non working Zone';
        }
        $resData = array("seqID" => $Buniqid, "name" => $businessname, "ownerName" => $ownername, 'countryCode' => $countryCode,
            "ownerPhone" => $Phone, "ownerEmail" => $uemail, "businessNumber" => $businessNumber, "password" => $password, "website" => $Website, "description" => $Description, "businessAddress" => $Address,
            "billingAddress" => $billingAddress,"cityId" => $city, "cityName" => $cityName,
            "driverExist" => $drivers, "coordinates" => array(
                "longitude" => (double) $Longitude,
                "latitude" => (double) $Latitude
            ), 'businessZoneId' => $businessZoneId, 'businessZoneName' => $businessZoneName, 'serviceZones' => $serviceZones,
            "status" => 3, 'pricingStatus' => $pricing, "minimumOrder" => $minorderVal, "freeDeliveryAbove" => $freedelVal, 'pickupCash' => $Pcash, 'pickupCard' => $Pcredit,
             'orderType' => $select, 'baseFare' => $basefare, 'pricePerMile' => $priceperkm, 'range' => $priceperkm,
           'grocerDriver' => $appDriver, 'storeDriver' => $Storedriver);

        $res = $this->mongo_db->insert('stores', $resData);
        $resData['mongoID'] = $res;
        $resData['seqID'] = (string)$Buniqid;
        if($resData['countryCode'] == '' || $resData['countryCode'] == null){
            $resData['countryCode']= "91";
        }
        if($resData['postalCode'] == '' || $resData['postalCode'] == null){
            $resData['postalCode']= "0";
        }
        if($resData['driverExist'] == '' || $resData['driverExist'] == null){
            $resData['driverExist']= "0";
        }
        if($resData['businessNumber'] == '' || $resData['businessNumber'] == null){
            $resData['businessNumber']= "0";
        }
        if($resData['budget'] == '' || $resData['budget'] == null){
            $resData['budget']= "";
        }
        if($resData['offlineDriver'] == '' || $resData['offlineDriver'] == null){
            $resData['offlineDriver']= "";
        }
        
        $resData['locs']['lat'] = $resData['coordinates']['latitude'];
        $resData['locs']['lon'] = $resData['coordinates']['longitude'];
        unset($resData['coordinates']);

        $url = elasticAPILink . 'admin/store';


        $response = json_decode($this->callapi->CallAPI('POST', $url, $resData), true);
//        print_r($response);exit();

        echo json_encode($res);
    }

    function activebusinessmgt() {

        $val = $this->input->post('val');
        $mode = $this->input->post('mode');

        foreach ($val as $row) {
            echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array("status" => (int) $mode))->update('stores');
        }
    }

    function viewnote_businessmgt() {
        $val = $this->input->post('val');
//         print_r($val);
        foreach ($val as $bid) {
            $unique = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($bid)))->find_one('stores');
        }

        echo json_encode(array('data' => $unique));
        return;
    }

    public function getCityList($id) {
        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('cities');
        $res = array();
        foreach ($cursor['cities'] as $d) {

            $res[] = $d;
        }


        echo json_encode($res);
    }

    public function getStoreList() {


        $cursor = $this->mongo_db->where(array("status" => array('$in' => array(1, 3, 4))))->get('stores');
        $entities = array();
        $entities = '<select class="form-control error-box-class"  id="storeList" name="storeList">
                     <option value="">Select Stores</option>';
        foreach ($cursor as $d) {

            $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '">' . implode($d['name'], ',') . '</option>';
        }
        $entities .= '</select>';
        echo $entities;
    }

    


}

?>
