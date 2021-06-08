<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Manufacturer_Model extends CI_Model {

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

    function datatableManufacturer($status) {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "Name";
        $_POST['mDataProp_0'] = "Description";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('manufacturer', array("status" => (int) $status), 'seqId', -1);
        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));

        $aaData = $respo["aaData"];
        $datatosend = array();
        // 1 - active, 2 - inactive
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
                    $Desc.= ',' .  $Descs;
                   }
                }   
            }

           

            $arr[] = $sl++;
            $arr[] = $Name;
            $arr[] = $Desc;
            $arr[] = '<button class="btn btnedit btn-primary cls111 btneditManufacturer"   value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function addManufacturer() {
        $name = $this->input->post('Name');
        $desc = $this->input->post('Description');

        // print_r($name);
        // print_r($desc);die;
      $lang = $this->mongo_db->get('lang_hlp');
        
      
        $lanCodeArr = [];
        $lanIdArr = [];

        // foreach ($lang as $lan) {
        //     $lanCodeArr[0] = "en";
        //     $lanIdArr[0] = "0";
        //         if ($lan['Active'] == 1) {
        //             echo 'Active';
        //                 array_push($lanCodeArr, $lan['langCode']);
        //                 array_push($lanIdArr, $lan['lan_id']);        
        //                      if (count($lanCodeArr) == count($name)) {
        //                          echo 'if';die;
        //                             $data['name'] = array_combine($lanCodeArr, $name);                          
        //                         } else {
        //                             echo 'else';die;
        //                             $data['name']['en'] = $name[0];                            
        //                         }
                                
        //                         if (count($lanCodeArr) == count($desc)) {
        //                             $data['description'] = array_combine($lanCodeArr, $desc);
        //                         } else {
        //                             $data['description']['en'] = $desc[0];
        //                         }
        //                     }   
        //     }

        foreach ($lang as $lan) {
            $lanCodeArr[0] = "en";
            $lanIdArr[0] = "0";
            array_push($lanCodeArr, $lan['langCode']);
            array_push($lanIdArr, $lan['lan_id']);
        }

        if (count($lanCodeArr) == count($name)) {
            $data['name'] = array_combine($lanCodeArr, $name);
        } else if (count($lanCodeArr) < count($name)) {
            $data['name']['en'] = $name[0];

            foreach ($name as $key => $val) {
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
            $data['name']['en'] = $name[0];
        }

        if (count($lanCodeArr) == count($desc)) {
            $data['description'] = array_combine($lanCodeArr, $desc);
        } else if (count($lanCodeArr) < count($desc)) {
            $data['description']['en'] = $desc[0];

            foreach ($desc as $key => $val) {
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
            $data['description']['en'] = $desc[0];
        }

        $time = time();
        $datetime = $this->mongo_db->date();

        if (!$desc) {
            $desc = [];
        }

        $cursor = $this->mongo_db->get("manufacturer");
        $arr = [];
        $arrName = [];
        foreach ($cursor as $cdata) {
            array_push($arr, $cdata['seqId']);
            array_push($arrName, $cdata['Name'][0]);
        }
        $max = max($arr); 
        $seq = $max + 1;

        if (!in_array($name[0], $arrName)) {
            $result = array('Name' => $name, 'name' => $data['name'], 'description' => $data['description'], 'Description' => $desc, 'seqId' => $seq, 'status' => 1, 'statusMsg' => "Active", 'timeStamp' => $time, 'isoDate' => $datetime);
            // echo '<pre>';print_r($result);die;
            $data = $this->mongo_db->insert('manufacturer', $result);
            echo json_encode(array('data' => $data, 'flag' => 1));
        } else {
            echo json_encode(array('data' => $data, 'flag' => 0));
        }
    }

    function getOneManufacturer() {
        $Id = $this->input->post('Id');

        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->find_one('manufacturer');

        return $data;
    }

    function editManufacturer() {
		//print_r($_POST);die;
        $Id = $this->input->post('Id');
        $name = $this->input->post('Name');
        $desc = $this->input->post('Desc');
        $lang = $this->mongo_db->get('lang_hlp');
        $lanCodeArr = [];
        $lanIdArr = [];
        foreach ($lang as $lan) {
            $lanCodeArr[0] = "en";
            $lanIdArr[0] = "0";
            array_push($lanCodeArr, $lan['langCode']);
            array_push($lanIdArr, $lan['lan_id']);
        }
       
//        if (count($lanCodeArr) == count($name)) {
//            $data['name'] = array_combine($lanCodeArr, $name);
//        } else {
//            $data['name']['en'] = $name[0];
//        }
        if (count($lanCodeArr) == count($name)) {
            $data['name'] = array_combine($lanCodeArr, $name);
        } else if (count($lanCodeArr) < count($name)) {
            $data['name']['en'] = $name[0];

            foreach ($name as $key => $val) {
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
            $data['name']['en'] = $name[0];
        }
//         echo '<pre>'; print_r( $data['name']); die;
        if (count($lanCodeArr) == count($desc)) {
            $data['description'] = array_combine($lanCodeArr, $desc);
        } else if (count($lanCodeArr) < count($desc)) {
            $data['description']['en'] = $desc[0];

            foreach ($desc as $key => $val) {
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
            $data['description']['en'] = $desc[0];
        }
        
//        if (count($lanCodeArr) == count($desc)) {
//            $data['description'] = array_combine($lanCodeArr, $desc);
//        } else {
//            $data['description']['en'] = $desc[0];
//        }

        $result = array('Name' => $name,'name'=>$data['name'],'description'=>$data['description'], 'Description' => $desc);
//        echo '<pre>'; print_r($result); die;
        
        try {
            $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->set($result)->update('manufacturer');


            if($data){
                $valData['_id'] =$Id;                        
                $url = APILink. 'manufacturer';                
                $response = json_decode($this->callapi->CallAPI('PATCH', $url, $valData), true);
              
            }

        } catch (Exception $ex) {
            print_r($ex);
        }
        echo json_encode($data);
    }

    function activateManufacturer() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $data=  $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1, 'currentStatus' => "Active"))->update('manufacturer');

            if($data){
                $valData['_id'] =$id;                        
                $url = APILink. 'manufacturer';                
                $response = json_decode($this->callapi->CallAPI('PATCH', $url, $valData), true);          
            }
        }

        echo json_encode(array("msg" => "Selected manufacturer has been activated successfully", "flag" => 0));
    }

    function deactivateManufacturer() {
        $Id = $this->input->post('Id');

        foreach ($Id as $ids) {
            $data=   $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($ids)))->set(array('status' => 2, 'currentStatus' => "Inactive"))->update('manufacturer');

            if($data){
                $valData['_id'] =$id;                        
                $url = APILink. 'manufacturer';                
                $response = json_decode($this->callapi->CallAPI('PATCH', $url, $valData), true);          
            }

        }

        echo json_encode(array("msg" => "Selected manufacturer has been deactivated successfully", "flag" => 0));
    }

}

?>
