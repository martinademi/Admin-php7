<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Centralmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');
    }

    function getlanguageText($param = '') {

        if ($param == '') {
            $res=$this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function table_details($status) {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "name.en";
        $_POST['mDataProp_1'] = "description.en";
        $_POST['mDataProp_2'] = "taxCode";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('addOns', array("status" => (int) $status), 'seqId', -1);

        $aaData = $respo["aaData"];
        $datatosend = array();
        // 1 - active, 2 - inactive
        foreach ($aaData as $value) {
            $arr = array();

            $arr[] = $sl++;
            $arr[] = $value['name']['en'];
            $arr[] = ($value['description']['en']!="" || $value['description']['en']!=null) ? $value['description']['en'] : 'N/A' ;
            $arr[] = '<a class="addOnsList" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
            $arr[] = '<button class="btn btnedit btn-primary cls111" id="editCentral"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function AddNewCentral() {

        // $data = $_POST;
        // $data['timeStamp'] = time();
        // $data['isoDate'] = $this->mongo_db->date();
        // $data['status'] = 1;
        // $data['statusMsg'] = 'Active';
        // $cursor = $this->mongo_db->get("addOns");
        // $arr = [];
        // $arrName = [];
        // foreach ($cursor as $cdata) {
        //     array_push($arr, $cdata['seqId']);
        //     array_push($arrName, $cdata['name']['en']);
        // }
        // $max = max($arr);
        // $seq = $max + 1;
        // $data['seqId'] = $seq;
        // if (!in_array($data['name']['en'], $arrName)) {
        //     $dat = $this->mongo_db->insert('addOns', $data);
        //     return true;
        // } else {
        //     return;
        // }
        $this->load->library('mongo_db');
        $data = $_POST;       
        $data['timeStamp'] = time();
        $data['isoDate'] = $this->mongo_db->date();
        $data['status'] = 1;
        $data['statusMsg'] = 'Active';
        $cursor = $this->mongo_db->get("addOns");       
        $arr = [];
        $arrName = [];
        foreach ($cursor as $cdata) {
            array_push($arr, $cdata['seqId']);
            array_push($arrName, $cdata['name']['en']);
        }
        $max = max($arr);
        $seq = $max + 1;
        $data['seqId'] = $seq;      
        $data['addOnLimit']=1;
        $data['mandatory']=1;
        $dataAddOns=[];
        
        foreach($data['addOns'] as $addOn){ 
            $id=new MongoDB\BSON\ObjectID();
            $dataAddOn = (object) array("id"=>$id,"name"=> $addOn['name']);          
            array_push($dataAddOns, $dataAddOn);
        }
        $data['addOns']=$dataAddOns;
       if (!in_array($data['name']['en'], $arrName)) {
            $dat = $this->mongo_db->insert('addOns', $data);
            return true;
        } else {
            return;
        }

    }

    function addOnsList($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('addOns');
        $data = $result['addOns'];

        echo json_encode(array('data' => $data));
    }

    function getAddOnData($Id = '') {
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->find_one('addOns');

        return $data;
    }

    public function getAddOnsEdit($id) {

        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('addOns');

        echo json_encode(array('result' => $res['addOns']));
    }

    function editCentralData($id='') {
        $data = $_POST;
       $dataAddOns=[];  
          try {    
  
              foreach($data['addOns'] as $addOn){ 
                  $idAddOn=new MongoDB\BSON\ObjectID($addOn['id']);
                  $dataAddOn = (object) array("id"=>$idAddOn,"name"=> $addOn['name']);          
                  array_push($dataAddOns, $dataAddOn);
              }
        $data['addOns']=$dataAddOns;       
        $dat = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('addOns');
        } catch (Exception $ex) {
              print_r($ex);
          }
          return json_encode($dat);
    }

    function activateActon() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1, 'statusMsg' => "Active"))->update('addOns');
        }

        echo json_encode(array("msg" => "Selected central has been activated successfully", "flag" => 0));
    }

    function deactivateAction() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 2, 'statusMsg' => "Inactive"))->update('addOns');
        }

        echo json_encode(array("msg" => "Selected central has been deactivated successfully", "flag" => 0));
    }

    function deleteAction() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 3, 'statusMsg' => "Deleted"))->update('addOns');
        }

        echo json_encode(array("msg" => "Selected central has been deleted successfully", "flag" => 0));
    }

}

?>
