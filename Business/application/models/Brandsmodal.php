<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class brandsmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('CallAPI');
    }

    function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->get('lang_hlp');
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function data_details($status) {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "name.en";
        $_POST['mDataProp_1'] = "brandDescription";
        $_POST['mDataProp_2'] = "statusMsg";

        $sl = $_POST['iDisplayStart'] + 1;

        $storeId=$this->session->userdata('badmin')['BizId']; 
        $respo = $this->datatables->datatable_mongodb('storeBrands', array("status" => (int) $status,'storeId'=>$storeId), '_id', -1);
        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));

        $aaData = $respo["aaData"];
        $datatosend = array();
        // 1 - active, 0 - inactive
        foreach ($aaData as $value) {
            $arr = array();

                      
           if(count($respo['lang'])<1){               
            $Name=($value['name']['en'] != "" || $value['name']['en'] != null) ? $value['name']['en']: 'N/A';          
            $Desc=($value['description']['en'] != "" || $value['description']['en'] != null) ? $value['description']['en']: 'N/A';          
           }else{            
            $Name=($value['name']['en'] != "" || $value['name']['en'] != null) ? $value['name']['en']: 'N/A';
            $Desc=($value['description']['en'] != "" || $value['description']['en'] != null) ? $value['description']['en']: 'N/A';          
            foreach( $respo['lang'] as $lang){
                $lan= $lang['langCode'];
                $Names=($value['name'][$lan] != "" || $value['name'][$lan] != null) ? $value['name'][$lan]: '';  
                $Descs=($value['description'][$lan] != "" || $value['description'][$lan] != null) ? $value['description'][$lan]: '';                        
               if(strlen(  $Names)>0){
                $Name.= ',' .  $Names;
               }
               if(strlen(  $Descs)>0){
                $Desc.= ',' .   $Descs;
               }
            }
        }


            
            $arr[] = $sl++;
            $arr[] = $Name;
            $arr[] = $Desc;
//            $arr[] = $value['statusMsg'];
            if ($value['logoImage']) {
                $arr[] = '<img src="' . $value['logoImage'] . '" width="50px" height="50px" class="imageborder" style="border-radius:50%;"></img>';
            } else {
                $arr[] = 'N/A';
            }
            $arr[] = '<button class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function addBrand() {
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

        if (count($lanCodeArr) == count($data['brandName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['brandName']);
        } else if (count($lanCodeArr) < count($data['brandName'])) {
            $data['name']['en'] = $data['brandName'][0];

            foreach ($data['brandName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['name'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['name'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['name']['en'] = $data['brandName'][0];
        }

        if (count($lanCodeArr) == count($data['brandDescription'])) {
            $data['description'] = array_combine($lanCodeArr, $data['brandDescription']);
        } else if (count($lanCodeArr) < count($data['brandDescription'])) {
            $data['description']['en'] = $data['brandDescription'][0];

            foreach ($data['brandDescription'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['description'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['description'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['description']['en'] = $data['brandDescription'][0];
        }

        $data['timeStamp'] = time();
        $data['isoDate'] = $this->mongo_db->date();

        if (!$data['description']) {
            $data['description'] = [];
        }
        if (!$data['brandDescription']) {
            $data['brandDescription'] = [];
        }
        $cursor = $this->mongo_db->get("brands");
        $arr = [];
        $arrName = [];
        foreach ($cursor as $cdata) {
            array_push($arr, $cdata['seqId']);
            array_push($arrName, $cdata['brandName'][0]);
        }
        $max = max($arr);
        $data['seqId'] = $max + 1;
        $data['status'] = 1;
        $data['statusMsg'] = 'Active';
        $data['storeId']= $this->session->userdata('badmin')['BizId'];
//         echo '<pre>'; print_r($data); die;
        if (!in_array($data['brandName'][0], $arrName)) {
            $data = $this->mongo_db->insert('storeBrands', $data);
            echo json_encode(array('data' => $data, 'flag' => 1));
        } else {
            echo json_encode(array('data' => $data, 'flag' => 0));
        }
    }

    function getBrand() {
        $Id = $this->input->post('Id');

        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id),'storeId'=> $this->session->userdata('badmin')['BizId']))->find_one('storeBrands');

        return $data;
    }

    function editBrand() {
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

        if (count($lanCodeArr) == count($data['brandName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['brandName']);
        } else if (count($lanCodeArr) < count($data['brandName'])) {
            $data['name']['en'] = $data['brandName'][0];

            foreach ($data['brandName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['name'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['name'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['name']['en'] = $data['brandName'][0];
        }

        if (count($lanCodeArr) == count($data['brandDescription'])) {
            $data['description'] = array_combine($lanCodeArr, $data['brandDescription']);
        } else if (count($lanCodeArr) < count($data['brandDescription'])) {
            $data['description']['en'] = $data['brandDescription'][0];

            foreach ($data['brandDescription'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['description'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['description'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['description']['en'] = $data['brandDescription'][0];
        }

        try {
            $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->set($data)->update('storeBrands');

            if($data){
                $valData['_id'] =$Id;                        
                $url = APILink. 'brand';                
                $response = json_decode($this->callapi->CallAPI('PATCH', $url, $valData), true);
              
            }

        } catch (Exception $ex) {
            print_r($ex);
        }
        echo json_encode($data);
    }

    function activateBrand() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $data=   $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1, 'statusMsg' => "Active"))->update('storeBrands');

            if($data){
                $valData['_id'] =$id;                        
                $url = APILink. 'brand';                
                $response = json_decode($this->callapi->CallAPI('PATCH', $url, $valData), true);          
            }
        }

        echo json_encode(array("msg" => "Selected brand has been activated successfully", "flag" => 0));
    }

    function deactivateBrand() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
           $data= $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 0, 'statusMsg' => "Inactive"))->update('storeBrands');

           if($data){
                $valData['_id'] =$id;                        
                $url = APILink. 'brand';                
                $response = json_decode($this->callapi->CallAPI('PATCH', $url, $valData), true);          
            }

        }

        echo json_encode(array("msg" => "Selected brand has been deactivated successfully", "flag" => 0));
    }

// get Brand
    function getBrands(){

        $val=$this->mongo_db->where(array("status"=> 1))->get('centralBrands');
        return $val;
    }

     function addBrands() {
        
        $this->load->library('mongo_db');        
        $shiftData=  json_decode($this->input->post('shiftDetails'),true);
        

        foreach( $shiftData as $brand ){
            $id=(string)$brand['shiftId'];
            $brandDetails=$this->mongo_db->where(array('_id'=>  new MongoDB\BSON\ObjectID($id)))->find_one('centralBrands');
            $brandDetails['centralBrandId']=(string)$brandDetails['_id']['$oid'];
            $brandDetails['storeId']=$this->session->userdata('badmin')['BizId'];
            unset($brandDetails['_id']);
            unset($brandDetails['isoDate']);
            $storeId=$this->session->userdata('badmin')['BizId'];
            $validate=$this->mongo_db->where(array('centralBrandId'=>$id,'storeId'=>$storeId))->find_one('storeBrands');
            
            if(!$validate){
                $rel= $this->mongo_db->insert('storeBrands',$brandDetails); 
            }
       
        }   
      
        if($rel){
            $msg="Brand added successfully";
            echo json_encode(array('msg'=> $msg,'flag' => 1));
            return;
        }else{
            $msg="Brnad already exist";
            echo json_encode(array('msg'=> $msg,'flag' => 2));
            return;
        }
   
        
       
    }

}

?>
