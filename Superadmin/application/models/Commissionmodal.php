<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Commissionmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');
    }

    function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function getstore() {
        $res = $this->mongo_db->get_where('stores', array('status' => 1));
        return $res;
    }

    function getDefaultCommission() {

        $res = $this->mongo_db->get('appConfig');
        $arr = array();

        foreach ($res as $r) {
            $arr = $r;
        }

        return $arr;
    }

    function commission_details($status) {
     
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "commissionType";
        $_POST['mDataProp_2'] = "commission";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('stores', array("status" => 1), '_id', -1);

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();

            if ($value['commissionType'] == 1) {
                $commissionString = 'Fixed';
            } else {
                $commissionString = 'Percentage';
            }
            
            $categoryName = $subCategoryName = '';
            foreach ($value['storeCategory'] as $cat) {
                $categoryName = $cat['categoryName']['en'];
            }
            foreach ($value['storeSubCategory'] as $subcat) {
                $subCategoryName = $subcat['subCategoryName']['en'];
            }

            // language check
            $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));

            if(count($respo['lang'])<1){                
             $storeName=($value['sName']['en'] != "" || $value['sName']['en'] != null) ? $value['sName']['en']: 'N/A';           
            }else{             
             $storeName=($value['sName']['en'] != "" || $value['sName']['en'] != null) ? $value['sName']['en']: 'N/A'; 
             foreach( $respo['lang'] as $lang){ 
                 $lan= $lang['langCode'];
                 $storeNames=($value['sName'][$lan] != "" || $value['sName'][$lan] != null) ? $value['sName'][$lan]: '';               
                if(strlen( $storeNames)>0){
                 $storeName.= ',' . $storeNames;
                }
             } 
            }

            $arr[] = $sl++;
           // $arr[] = implode($value['name'], ',');
           $arr[]=$storeName;
            $arr[] = ($categoryName != '') ? $categoryName : 'N/A';
            $arr[] = $commissionString;
            $arr[] = $value['commission'];
            $arr[] = '<button class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function addCommission() {
        // commission type - 0: percentage,1: fixed
        $data = $_POST;
        $data['commissionType'] = (int) $data['commissionType'];
        $data['commission'] = (float) $data['commission'];

        if ($data['commissionType'] == 0) {
            $data['commissionString'] = "Percentage";
        } else if ($data['commissionType'] == 1) {
            $data['commissionString'] = "Fixed";
        }

        $data['status'] = 0;
        $data['statusMsg'] = 'Active';

        $time = time();
        $data['createdTimeStamp'] = $time;
        $data['isoDate'] = $this->mongo_db->date();

        $cursor = $this->mongo_db->get("storeCommission");
        $arr = [];
        $arrName = [];
        foreach ($cursor as $cdata) {
            array_push($arr, $cdata['seqId']);
            array_push($arrName, $cdata['storeName']);
        }
        $max = max($arr);
        $seq = $max + 1;

        $data['seqId'] = $seq;

        if (!in_array($data['storeName'], $arrName)) {
            $data = $this->mongo_db->insert('storeCommission', $data);
            echo json_encode(array('data' => $data, 'flag' => 1));
        } else {
            echo json_encode(array('data' => $data, 'flag' => 0));
        }
    }

    function editCommission() {
        $data = $_POST;
        $id = $data['commId'];
        $data['commissionType'] = (int) $data['commissionType'];
        $data['commission'] = (float) $data['commission'];

        if ($data['commissionType'] == 0) {
            $data['commissionString'] = "Percentage";
        } else if ($data['commissionType'] == 1) {
            $data['commissionString'] = "Fixed";
        }

        unset($data['commId']);
        unset($data['storeId']);

        try {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('stores');
        } catch (Exception $ex) {
            print_r($ex);
        }
    }

    function setDefaultCommission() {
        $data = $_POST;
        $id = $data['Id'];
        $defaultComm = $this->mongo_db->get('appConfig');
        $commarr = [];
        foreach ($defaultComm as $comm) {
            $commarr = $comm;
        }
        $commission = $commarr['storeDefaultCommission'];
        $commissionType = 0;
        $arr = array('commission' => $commission, 'commissionType' => $commissionType);
        try {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($arr)->update('stores');
        } catch (Exception $ex) {
            print_r($ex);
        }
    }

    function getCommissionData() {
        $Id = $this->input->post('Id');

        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->find_one('stores');

        return $data;
    }

}

?>
