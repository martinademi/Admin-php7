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
            $data[] = array('value' => $driver['value'], 'type' => $driver['type'], 'categoryId' =>  $driver['categoryId']);
        }
       
        return $data;
    }
    
    
    
     function datatable_Metatags($status) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "value";
		$_POST['mDataProp_1'] = "type";

        $respo = $this->datatables->datatable_mongodb('metaTags', array('categoryId' => $status), '', 1); //1->ASCE -1->DESC

        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = 1;

        foreach ($aaData as $value) { 
            $arr = array(); 
            $arr[] = $sl++;
            $arr[] = $value['value'];
            $arr[] = $value['type'];
             $arr[] = '<button style="width:35px;" class="btn btn-primary btnWidth editICON"  value=' . $value['_id']['$oid'] . '><i class="fa fa-edit"></i></button>';
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;

        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
    
    
    
      public function getmetadata(){

        $val = $this->input->post('val');

   
                $cursor =  $this->mongo_db->where( array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('metaTags'); 
        
            return $cursor;
    }
      function deletemetadata() {
        
        $val = $this->input->post('val');
  
        foreach ($val as $row) {
           echo $this->mongo_db->where(array("_id" =>  new MongoDB\BSON\ObjectID($row)))->delete('metaTags');
        }
    }
    
        function insert_metadata() {

        $Name = $_REQUEST['value'];
        $value = $_REQUEST['type'];
        $cateid = $_REQUEST['categoryId'];
     
        $cursor = $this->mongo_db->get('metaTags');
        
        $arr = [];
        foreach ($cursor as $catdata) {
            array_push($arr, $catdata['seqID']);
        }
        $max = max($arr);
        $seq =  $max + 1;

        $insertIntoChatArr = array( 'seqID'=>$seq,'value' => $Name, 'type' => $value, 'categoryId' => $cateid);

        return $this->mongo_db->insert('metaTags',$insertIntoChatArr);
    }
    
     
    function editmetadata() {

        $Name = $_REQUEST['metaname'];
        $value = $_REQUEST['metaId'];
        $id = $_REQUEST['editId'];
        if($value == "number"){
            $value = "Number";
        }else{
            $value = "String";
        }

       $insertIntoChatArr = array('value' => $Name,'type' => $value);
        return $this->mongo_db->where(array("_id" =>  new MongoDB\BSON\ObjectID($id)))->set($insertIntoChatArr)->update('metaTags');

     }
 


}
