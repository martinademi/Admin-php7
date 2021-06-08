<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Sizemodal extends CI_Model {

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

    function size_details($status) {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "sizeName";
        $_POST['mDataProp_1'] = "categoryName";
        $_POST['mDataProp_2'] = "subCategoryName";
        $_POST['mDataProp_3'] = "subSubCategoryName";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('sizeGroup', array("status" => (int) $status), 'seqId', -1);

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();

            // if ($value['sizeName'] != '') {
            //     $sizeName = implode(',', $value['sizeName']);
            // } else {
            //     $sizeName = 'N/A';
            // }


            if(count($respo['lang'])<1){               
                $sizeName=($value['name']['en'] != "" || $value['name']['en'] != null) ? $value['name']['en']: 'N/A'; 
                $description=($value['description']['en'] != "" || $value['description']['en'] != null) ? $value['description']['en']: 'N/A'; 
                
               }else{                
                $sizeName=($value['name']['en'] != "" || $value['name']['en'] != null) ? $value['name']['en']: 'N/A';  
                $description=($value['description']['en'] != "" || $value['description']['en'] != null) ? $value['description']['en']: 'N/A';   
                foreach( $respo['lang'] as $lang){    
                    $lan= $lang['langCode'];
                    $sizeNames=($value['name'][$lan] != "" || $value['name'][$lan] != null) ? $value['name'][$lan]: '';   
                    $descriptions=($value['description']['en'] != "" || $value['description']['en'] != null) ? $value['description']['en']: 'N/A';                 
                   if(strlen( $sizeNames)>0){
                    $sizeName.= ',' . $sizeNames;
                   }
                   if(strlen( $sizeNames)>0){
                    $description.= ',' . $descriptions;
                   }
                }
             }

             


            if (count($value['sizeDesc']) != 0) {
                $sizeDesc = implode(',', $value['sizeDesc']);
            } else {
                $sizeDesc = 'N/A';
            }

            $arr[] = $sl++;
            $arr[] = $sizeName;
            $arr[] = $value['categoryName'];
            $arr[]=($value['subCategoryName']!="" || $value['subCategoryName']!=null) ? $value['subCategoryName']:'N/A';
            $arr[]=($value['subSubCategoryName']!="" || $value['subSubCategoryName']!=null) ? $value['subSubCategoryName']:'N/A';
            $arr[] = $description;
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function addSizeGroup() {
        $data = $_POST;
        $i;
        $k;
       /* $encount = count($data['sizeAttr']['en']);
        for ($i = 0; $i < $encount; $i++) {
            $data1['sizeAttr'][$i + 1] = array('en' => $data['sizeAttr']['en'][$i],'attrId'=>new MongoDB\BSON\ObjectID());
        }

        $lang = $this->mongo_db->get('lang_hlp');
        foreach ($lang as $glan) {
            if ($glan['Active'] == 1) {

                $langcount = count($data['sizeAttr'][$glan['langCode']]);
                for ($k = 0; $k < $langcount; $k++) {
                    $data1['sizeAttr'][$k + 1][$glan['langCode']] = $data['sizeAttr'][$glan['langCode']][$k];
                }
            }
        } */

        ///////////////////////////////////


        $encount = count($data['sizeAttr']['en']);
        for ($j = 0; $j < $encount; $j++) {
            $data1['sizeAttr'][$j + 1]['sAttrLng']['en'] = $data['sizeAttr']['en'][$j];
        }

        $lang = $this->mongo_db->get('lang_hlp');
        foreach ($lang as $glan) {
            if ($glan['Active'] == 1) {
            $langcount = count($data['sizeAttr'][$glan['langCode']]);
            for ($k = 0; $k < $langcount; $k++) {
            $data1['sizeAttr'][$k + 1]['sAttrLng'][$glan['langCode']] = $data['sizeAttr'][$glan['langCode']][$k];
            }
          }
        }


        $totcount = count($data['sizeAttr']['en']);
        for ($i = 0; $i < $totcount; $i++) {
            $data1['sizeAttr'][$i + 1] = array('attrId'=>new MongoDB\BSON\ObjectID(),'sAttrLng' => $data1['sizeAttr'][$i+1]['sAttrLng']);
        }

        ////////////////////////////////////////

        $data['sizeAttr'] = $data1['sizeAttr'];

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

        if (count($lanCodeArr) == count($data['sizeName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['sizeName']);
        } else if (count($lanCodeArr) < count($data['sizeName'])) {
            $data['name']['en'] = $data['sizeName'][0];

            foreach ($data['sizeName'] as $key => $val) {
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
            $data['name']['en'] = $data['sizeName'][0];
        }

        if (count($lanCodeArr) == count($data['sizeDesc'])) {
            $data['description'] = array_combine($lanCodeArr, $data['sizeDesc']);
        } else if (count($lanCodeArr) < count($data['sizeDesc'])) {
            $data['description']['en'] = $data['sizeDesc'][0];

            foreach ($data['sizeDesc'] as $key => $val) {
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
            $data['description']['en'] = $data['sizeDesc'][0];
        }
//        echo '<pre>'; print_r($data); die;
        $data['status'] = 1;
        $data['statusMsg'] = 'Active';

        $time = time();
        $data['createdTimeStamp'] = $time;
        $data['isoDate'] = $this->mongo_db->date();

        $cursor = $this->mongo_db->get("sizeGroup");
        $arr = [];
        $arrName = [];
        foreach ($cursor as $cdata) {
            array_push($arr, $cdata['seqId']);
            array_push($arrName, $cdata['sizeName'][0]);
        }
        $max = max($arr);
        $seq = $max + 1;

        $data['seqId'] = $seq;

        if (!in_array($data['sizeName'][0], $arrName)) {
            $data = $this->mongo_db->insert('sizeGroup', $data);
            echo json_encode(array('data' => $data, 'flag' => 1));
        } else {
            echo json_encode(array('data' => $data, 'flag' => 0));
        }
    }

    function getSize() {
        $Id = $this->input->post('Id');

        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->find_one('sizeGroup');

        return $data;
    }

    function getSubCategoryData($cid = '', $sid = '') {
        if ($cid != '' || $cid != null) {
            $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($cid)))->get('secondCategory');
            echo json_encode(array('data' => $cursor));
        } else {
            $val = $this->input->post('categoryId');
            $sval = $this->input->post('subCategoryId');
            $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($val)))->get('secondCategory');
            $entities = array();
            $entities = '<select class="form-control error-box-class"  id="subCategory" name="subCategory">
                     <option value="">Select Sub-Category</option>';
            foreach ($cursor as $d) {
                if ($sval == $d['_id']['$oid']) {
                    $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '" selected>' . implode($d['name'], ',') . '</option>';
                } else {
                    $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '">' . implode($d['name'], ',') . '</option>';
                }
            }
            $entities .= '</select>';
//        print_r($entities);die;
            echo $entities;
        }
    }

    function getSubsubCategoryDataList($sid = '', $ssid = '') {

        if ($sid != '' || $sid != null) {

            $cursor = $this->mongo_db->where(array("subCategoryId" => new MongoDB\BSON\ObjectID($sid)))->get('thirdCategory');
            echo json_encode(array('data' => $cursor));
        } else {
            if ($val != '' || $val != null) {
                $val = $this->input->post('subCategoryId');
                $ssval = $this->input->post('subSubCategoryId');

                $cursor = $this->mongo_db->where(array("subCategoryId" => new MongoDB\BSON\ObjectID($val)))->get('thirdCategory');
                $entities = array();
                $entities = '<select class="form-control error-box-class"  id="subSubCategory" name="subSubCategory">
                     <option value="">Select Sub-SubCategory</option>';
                foreach ($cursor as $d) {
                    if ($ssval == $d['_id']['$oid']) {
                        $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '" selected>' . implode($d['name'], ',') . '</option>';
                    } else {
                        $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '">' . implode($d['name'], ',') . '</option>';
                    }
                }
                $entities .= '</select>';
            } else {
                $entities = array();
                $entities = '<select class="form-control error-box-class"  id="subSubCategory" name="subSubCategory">
                     <option value="">Select Sub-SubCategory</option>';

                $entities .= '</select>';
            }
            echo $entities;
        }
    }

    function editSize() {
        $data = $_POST;
        // echo '<pre>';
        // print_r($data['sizeAttr']['en']);
        

         $encount = count($data['sizeAttr']['en']);
                for ($j = 0; $j < $encount; $j++) {
                    $data1['sizeAttr'][$j + 1]['sAttrLng']['en'] = $data['sizeAttr']['en'][$j];
                }

        $lang = $this->mongo_db->get('lang_hlp');
        foreach ($lang as $glan) {
            if ($glan['Active'] == 1) {

                $langcount = count($data['sizeAttr'][$glan['langCode']]);
                for ($k = 0; $k < $langcount; $k++) {
                    $data1['sizeAttr'][$k + 1]['sAttrLng'][$glan['langCode']] = $data['sizeAttr'][$glan['langCode']][$k];
                }
            }
        }


        $totcount = count($data['sizeAttr']['en']);
        for ($i = 0; $i < $totcount; $i++) {
            if($i < count($data['sizeAttr']['attrId'])){
                $data1['sizeAttr'][$i + 1] = array('attrId'=>new MongoDB\BSON\ObjectID($data['sizeAttr']['attrId'][$i]),'sAttrLng' => $data1['sizeAttr'][$i+1]['sAttrLng']);
            }
            else{
            $data1['sizeAttr'][$i + 1] = array('attrId'=>new MongoDB\BSON\ObjectID(),'sAttrLng' => $data1['sizeAttr'][$i+1]['sAttrLng']);
            }
        }

        $data['sizeAttr'] = $data1['sizeAttr'];
     
      // echo '<pre>';
    //    print_r($data);
       //die;
        $id = $data['sizeId'];
        unset($data['sizeId']);

       // $lang = $this->mongo_db->get('lang_hlp');
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

        if (count($lanCodeArr) == count($data['sizeName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['sizeName']);
        } else if (count($lanCodeArr) < count($data['sizeName'])) {
            $data['name']['en'] = $data['sizeName'][0];

            foreach ($data['sizeName'] as $key => $val) {
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
            $data['name']['en'] = $data['sizeName'][0];
        }

        if (count($lanCodeArr) == count($data['sizeDesc'])) {
            $data['description'] = array_combine($lanCodeArr, $data['sizeDesc']);
        } else if (count($lanCodeArr) < count($data['sizeDesc'])) {
            $data['description']['en'] = $data['sizeDesc'][0];

            foreach ($data['sizeDesc'] as $key => $val) {
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
            $data['description']['en'] = $data['sizeDesc'][0];
        }

        try {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('sizeGroup');
        } catch (Exception $ex) {
            print_r($ex);
        }
    }

    function activateColor() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1, 'statusMsg' => 'Active'))->update('sizeGroup');
        }

        echo json_encode(array("msg" => "Selected size group has been activated successfully", "flag" => 0));
    }

    function deactivateColor() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 2, 'statusMsg' => 'Inactive'))->update('sizeGroup');
        }

        echo json_encode(array("msg" => "Selected size group has been deactivated successfully", "flag" => 0));
    }

}

?>
