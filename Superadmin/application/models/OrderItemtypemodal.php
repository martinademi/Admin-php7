<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class OrderItemtypemodal extends CI_Model {

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

    function data_details($status) {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "orderName";
        $_POST['mDataProp_1'] = "brandDescription";
        $_POST['mDataProp_2'] = "statusMsg";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('orderItemType', array("status" => (int) $status), 'seqId', -1);
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
            if ($value['bannerImage']) {
                $arr[] = '<img src="' . $value['bannerImage'] . '" width="50px" height="50px" class="imageborder" style="border-radius:50%;"></img>';
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

        if (count($lanCodeArr) == count($data['orderName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['orderName']);
        } else if (count($lanCodeArr) < count($data['orderName'])) {
            $data['name']['en'] = $data['orderName'][0];

            foreach ($data['orderName'] as $key => $val) {
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
            $data['name']['en'] = $data['orderName'][0];
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
        unset( $data['brandDescription']);
        unset( $data['orderName']);
        
        $cursor = $this->mongo_db->get("orderItemType");
        $arr = [];
        $arrName = [];
        foreach ($cursor as $cdata) {
            array_push($arr, $cdata['seqId']);
            array_push($arrName, $cdata['name']['en']);
        }
        $max = max($arr);
        $data['seqId'] = $max + 1;
        $data['status'] = 1;
        $data['statusMsg'] = 'Active';
        $data['type']= (int)$data['type'];

       
        if (!in_array($data['orderName'][0], $arrName)) {
            $data = $this->mongo_db->insert('orderItemType', $data);
            echo json_encode(array('data' => $data, 'flag' => 1));
        } else {
            echo json_encode(array('data' => $data, 'flag' => 0));
        }
    }

    function getBrand() {
        $Id = $this->input->post('Id');

        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->find_one('orderItemType');

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

        if (count($lanCodeArr) == count($data['orderName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['orderName']);
        } else if (count($lanCodeArr) < count($data['orderName'])) {
            $data['name']['en'] = $data['orderName'][0];

            foreach ($data['orderName'] as $key => $val) {
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
            $data['name']['en'] = $data['orderName'][0];
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

        $data['type']= (int)$data['type'];

        try {
            $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->set($data)->update('orderItemType');
        } catch (Exception $ex) {
            print_r($ex);
        }
        echo json_encode($data);
    }

    function activateBrand() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1, 'statusMsg' => "Active"))->update('orderItemType');
        }

        echo json_encode(array("msg" => "Selected brand has been activated successfully", "flag" => 0));
    }

    function deactivateBrand() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 0, 'statusMsg' => "Inactive"))->update('orderItemType');
        }

        echo json_encode(array("msg" => "Selected brand has been deactivated successfully", "flag" => 0));
    }


    function deleteSymtom() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 2, 'statusMsg' => "Deleted"))->update('orderItemType');
        }

        echo json_encode(array("msg" => "Selected brand has been deactivated successfully", "flag" => 0));
    }

}

?>
