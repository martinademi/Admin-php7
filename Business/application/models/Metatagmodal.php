<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Metatagmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
    }

    function metatags($status) {

        $MAsterData = $this->mongo_db->get('metaTags');
        $data = array();

        foreach ($MAsterData as $driver) {
            $data[] = array('value' => $driver['value'], 'type' => $driver['type'], 'categoryId' => $driver['categoryId']);
        }

        return $data;
    }

    function datatable_Metatags($param1, $param2) {
//        print_r($param2);
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "value";
        
        if ($param1 && $param2) {
            $respo = $this->datatables->datatable_mongodb('metaTags', array('storeid' => $this->session->userdata('badmin')['BizId'],'categoryId' => $param1, 'subCategoryId' => $param2), 'seqID', -1); //1->ASCE -1->DESC  
        } else {
            $respo = $this->datatables->datatable_mongodb('metaTags', array('storeid' => $this->session->userdata('badmin')['BizId'],'categoryId' => $param1), 'seqID', -1); //1->ASCE -1->DESC
        }
        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = 1;

        foreach ($aaData as $value) {
            $arr = array();
            $arr[] = $sl++;
            $arr[] = $value['value'];
            $arr[] = $value['type'];
            $arr[] = '<button class="btn btnedit cls111" id="btnedit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #606b71;color: white;width: 45px !important;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function getmetadata() {

        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('metaTags');
        return $cursor;
    }

    function deletemetadata() {

        $val = $this->input->post('val');

        foreach ($val as $row) {
            echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->delete('metaTags');
        }
    }

    function insert_metadata() {

        $data = $_POST;
        $data['storeid'] = $this->session->userdata('badmin')['BizId'];

        $cursor = $this->mongo_db->get('metaTags');

        $arr = [];
        foreach ($cursor as $catdata) {
            array_push($arr, $catdata['seqID']);
        }
        $max = max($arr);
        $data['seqID'] = $max + 1;
        $data['appId'] = "";

        return $this->mongo_db->insert('metaTags', $data);
//        echo '<pre>'; print_r($data); die;
    }

    function editmetadata() {
        $data = $_POST;

        $id = $data['editId'];
        unset($data['editId']);

        if ($data['type'] == "number") {
            $data['type'] = "Number";
        } else {
            $data['type'] = "String";
        }
//        echo '<pre>'; print_r($data); die;
        return $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($data)->update('metaTags');
    }

}
