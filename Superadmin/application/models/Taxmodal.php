<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Taxmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');
    }
    
      function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->get('lang_hlp');
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function tax_details($status) {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "taxName";
        $_POST['mDataProp_1'] = "taxDescription";
        $_POST['mDataProp_2'] = "taxCode";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('taxes', array("status" => (int) $status), 'seqId', -1);

        $aaData = $respo["aaData"];
        $datatosend = array();
        // 1 - active, 2 - inactive
        foreach ($aaData as $value) {
            $arr = array();
			$lang = $this->mongo_db->where(array("Active"=>1))->get('lang_hlp');
			
			if(count($lang) !=0){
				 $taxNam[] = $value['name']['en'];
				 $taxDes[] = $value['description']['en'];
			  foreach($lang as $lan){
				  if($value['name'][$lan['langCode']] == ""){}else{
					  $taxNam[] = $value['name'][$lan['langCode']];
				  }
				  if($value['description'][$lan['langCode']] == ""){}else{
					  $taxDes[] = $value['description'][$lan['langCode']];
				  }
				  
			  }
			  if(count($taxNam) == 1){
				 $taxName =  $taxNam[0];
			  }else{
				$taxName = implode(",",$taxNam);  
			  }
			  if(count($taxDes) == 1){
				 $taxDesc =  $taxDes[0];
			  }else{
				$taxDesc = implode(",",$taxDes);  
			  }
			  
			  unset($taxNam);
			   unset($taxDes);
            } else {
				if($value['name']['en'] == ""){
					$taxName = "N/A";
				}else{
					$taxName = $value['name']['en'];
				}
                if($value['description']['en'] == ""){
					$taxDesc = "N/A";
				}else{
				$taxDesc = $value['description']['en'];
				}
            }
			
            
            $arr[] = $sl++;
			
			$arr[] = $taxName;	
			
            $arr[] = ($value['taxCode'] != '')? $value['taxCode']:'-';
            $arr[] = $value['taxValue'];
            $arr[] = $taxDesc;
            $arr[] = '<button class="btn btnedit btn-primary cls111" id="editTax"  value="' .$value['_id']['$oid']  . '"  data-id=' .$value['_id']['$oid'] .' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function addTax() {
       
        $data = $_POST;
        
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

         if (count($lanCodeArr) == count($data['taxName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['taxName']);
        } else if (count($lanCodeArr) < count($data['taxName']) ) {
            $data['name']['en'] = $data['taxName'][0];
            
            foreach ($data['taxName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']){
                            $data['name'][$lan['langCode']] = $val;
                        }
                    }else{
                       if ($key == $lan['lan_id']){
                            $data['name'][$lan['langCode']] = $val;
                        } 
                    }
                }
                
            }
        } else {
            $data['name']['en'] = $data['taxName'][0];
        }
        
        if (count($lanCodeArr) == count($data['taxDescription'])) {
            $data['description'] = array_combine($lanCodeArr, $data['taxDescription']);
        } else if (count($lanCodeArr) < count($data['taxDescription']) ) {
            $data['description']['en'] = $data['taxDescription'][0];
            
            foreach ($data['taxDescription'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']){
                            $data['description'][$lan['langCode']] = $val;
                        }
                    }else{
                       if ($key == $lan['lan_id']){
                            $data['description'][$lan['langCode']] = $val;
                        } 
                    }
                }
                
            }
        } else {
            $data['description']['en'] = $data['taxDescription'][0];
        }
        
        
        $data['taxValue'] = (float)$data['taxValue'];
        $data['timeStamp'] = time();
        $data['isoDate'] = $this->mongo_db->date();
        $data['status'] = 1;
        $data['statusMsg'] = 'Active';
       
        if(!$data['taxDescription']){
             $data['taxDescription'] = [];
        }
        if(!$data['description']){
             $data['description'] = [];
        }

        $cursor = $this->mongo_db->get("taxes");
        $arr = [];
        $arrName = [];
        foreach ($cursor as $cdata) {
            array_push($arr, $cdata['seqId']);
            array_push($arrName, $cdata['taxName'][0]);
        }
        $max = max($arr);
        $seq = $max + 1;
        $data['seqId'] = $seq;
        
        if (!in_array($name[0], $arrName)) {
            $dat = $this->mongo_db->insert('taxes', $data);
            echo json_encode(array('data' => $dat, 'flag' => 1));
        } else {
            echo json_encode(array('data' => $dat, 'flag' => 0));
        }
    }
    
    function getTax(){
        $Id = $this->input->post('Id');

        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->find_one('taxes');
        
        return $data;
    }
    
    function editTax() {
        $Id = $this->input->post('Id');
      
        $data = $_POST;
        unset($data['Id']);
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
       
        if (count($lanCodeArr) == count($data['taxName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['taxName']);
        } else if (count($lanCodeArr) < count($data['taxName']) ) {
            $data['name']['en'] = $data['taxName'][0];
            
            foreach ($data['taxName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']){
                            $data['name'][$lan['langCode']] = $val;
                        }
                    }else{
                       if ($key == $lan['lan_id']){
                            $data['name'][$lan['langCode']] = $val;
                        } 
                    }
                }
                
            }
        } else {
            $data['name']['en'] = $data['taxName'][0];
        }
        
        if (count($lanCodeArr) == count($data['taxDescription'])) {
            $data['description'] = array_combine($lanCodeArr, $data['taxDescription']);
        } else if (count($lanCodeArr) < count($data['taxDescription']) ) {
            $data['description']['en'] = $data['taxDescription'][0];
            
            foreach ($data['taxDescription'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']){
                            $data['description'][$lan['langCode']] = $val;
                        }
                    }else{
                       if ($key == $lan['lan_id']){
                            $data['description'][$lan['langCode']] = $val;
                        } 
                    }
                }
                
            }
        } else {
            $data['description']['en'] = $data['taxDescription'][0];
        }
        
        if($data['taxCode']){
            $data['taxCode'] = $data['taxCode'];
        }
        if($data['taxValue']){
            $data['taxValue'] = (float)$data['taxValue'];
        }
       try{
        $dat = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->set($data)->update('taxes');
       }catch(Exception $ex){
           print_r($ex);
       }
       echo json_encode($dat);
    }
    
    function activateTax() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1,'statusMsg' => "Active"))->update('taxes');
        }

        echo json_encode(array("msg" => "Selected tax has been activated successfully", "flag" => 0));
        
    }
    function deactivateTax() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
             $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 2, 'statusMsg' => "Inactive"))->update('taxes');
        }

        echo json_encode(array("msg" => "Selected tax has been deactivated successfully", "flag" => 0));
        
    }
  

}

?>
