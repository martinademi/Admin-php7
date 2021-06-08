
<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class SubsubCategorymodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->model("Superadminmodal");
        $this->load->model("Categorymodal");
        $this->load->model("SubCategorymodal");
        $this->load->library('utility_library');
    }

    function datatable_subsubcategory($status,$visibility) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $data1['id'] = $status;
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "description";

        switch($visibility){
            case 0:
                 $respo = $this->datatables->datatable_mongodb('thirdCategory', array('subCategoryId' => new MongoDB\BSON\ObjectID($status),'visibility'=>0), 'seqID', 1); //1->ASCE -1->DESC
                break;
            case 1:
                 $respo = $this->datatables->datatable_mongodb('thirdCategory', array('subCategoryId' => new MongoDB\BSON\ObjectID($status),'visibility'=>1), 'seqID', 1); //1->ASCE -1->DESC
                break;
        }

        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));

        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;

        foreach ($aaData as $value) {

            if(count($respo['lang'])<1){               
                $productname=($value['subSubCategoryName']['en'] != "" || $value['subSubCategoryName']['en'] != null) ? $value['subSubCategoryName']['en']: 'N/A';  
                $productdesc=($value['subSubCategoryDesc']['en'] != "" || $value['subSubCategoryDesc']['en'] != null) ? $value['subSubCategoryDesc']['en']: 'N/A';                              
               }else{                
                $productname=($value['subSubCategoryName']['en'] != "" || $value['subSubCategoryName']['en'] != null) ? $value['subSubCategoryName']['en']: 'N/A';    
                $productdesc=($value['subSubCategoryDesc']['en'] != "" || $value['subSubCategoryDesc']['en'] != null) ? $value['subSubCategoryDesc']['en']: 'N/A';                              
                foreach( $respo['lang'] as $lang){    
                    $lan= $lang['langCode'];
                    $productnames=($value['subSubCategoryName'][$lan] != "" || $value['subSubCategoryName'][$lan] != null) ? $value['subSubCategoryName'][$lan]: '';
                    $productdescs=($value['subSubCategoryDesc'][$lan] != "" || $value['subSubCategoryDesc'][$lan] != null) ? $value['subSubCategoryDesc'][$lan]: '';                                                  
                   if(strlen( $productnames)>0){
                    $productname.= ',' . $productnames;
                   }
                   if(strlen($productdescs)>0){
                    $productdesc.= ',' .$productdescs;
                   }
                }
            }

            $arr = array();
            $arr[] = $sl++;
            $arr[] = '<img src="' . $value['imageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'' . base_url('../') . '/pics/user.jpg\';"   width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            $arr[] =  $productname;
//            $arr[] = ($value['visibility'] == 1) ? 'Unhidden' : 'Hidden';
            $arr[] =  $productdesc;
            $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
            $arr[] = '<button style="width:35px;" class="btn btn-primary btnWidth editICON cls111"  value=' . $value['_id']['$oid'] . '><i class="fa fa-edit"></i></button>';
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function subSubCategory() {

        $MAsterData = $this->mongo_db->get('thirdCategory');
        $data = array();

        foreach ($MAsterData as $driver) {
//            $GetMAster = $this->mongo_db->get_one('ProviderData');
            $data[] = array('Categoryname' => $driver['Category'], 'CategoryDescription' => $driver['Description'], 'Categoryid' => $driver['_id']['$oid']);
        }
        return $data;
    }

    function insertSubSubCategory() {
        $previousCategory = $this->mongo_db->where(array('subCategoryId' => new MongoDB\BSON\ObjectID($_REQUEST['cateid']), 'name' =>  $_REQUEST['name'][0]))->find_one('thirdCategory');

        if ($previousCategory) {
            echo json_encode(array('msg' => 0));
        } else {
            $subcateid = $_REQUEST['cateid'];
            $id = $_REQUEST['id'];
            $Name = $_REQUEST['catname'];
            $cat_photosaa = $_REQUEST['cat_photosaa'];
            $Description = $_REQUEST['catDescription'];
            $catPhoto = $_REQUEST['cat_photosamz'];

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

            if (count($lanCodeArr) == count($Name)) {
                $data['subSubCategoryName'] = array_combine($lanCodeArr, $Name);
            } else if (count($lanCodeArr) < count($Name)) {
                $data['subSubCategoryName']['en'] = $Name[0];

                foreach ($Name as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['subSubCategoryName'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['subSubCategoryName'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['subSubCategoryName']['en'] = $Name[0];
            }

            if (count($lanCodeArr) == count($Name)) {
                $data['subSubCategoryDesc'] = array_combine($lanCodeArr, $Description);
            } else if (count($lanCodeArr) < count($Description)) {
                $data['subSubCategoryDesc']['en'] = $Description[0];

                foreach ($Name as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['subSubCategoryDesc'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['subSubCategoryDesc'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['subSubCategoryDesc']['en'] = $Description[0];
            }

            $cursor = $this->mongo_db->get('thirdCategory');
            $arr = [];
            foreach ($cursor as $catdata) {
                array_push($arr, $catdata['seqID']);
            }
            $max = max($arr);
            $seq = $max + 1;

            $insertIntoArr = array('seqID' => $seq, 'name' => $Name, 'subCategoryId' => new MongoDB\BSON\ObjectID($subcateid), 'categoryId' => new MongoDB\BSON\ObjectID($id), 'description' => $Description, 'imageUrl' => $catPhoto, 'visibility' => 1,"visibilityMsg"=>"Unhidden", 'subSubCategoryName' => $data['subSubCategoryName'], 'subSubCategoryDesc' => $data['subSubCategoryDesc']);

            $res = $this->mongo_db->insert('thirdCategory', $insertIntoArr);
            echo json_encode(array('msg' => 1));
        }
    }

    function editSubSubCategory() {

        // $Catid = $_REQUEST['Catid'];
        $Name = $_REQUEST['catname'];
        $Description = $_REQUEST['catDescription'];
        $id = $_REQUEST['editId'];
        $catPhoto = $_REQUEST['cat_photosamz'];

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

        if (count($lanCodeArr) == count($Name)) {
            $data['subSubCategoryName'] = array_combine($lanCodeArr, $Name);
        } else if (count($lanCodeArr) < count($Name)) {
            $data['subSubCategoryName']['en'] = $Name[0];

            foreach ($Name as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['subSubCategoryName'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['subSubCategoryName'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['subSubCategoryName']['en'] = $Name[0];
        }

        if (count($lanCodeArr) == count($Name)) {
            $data['subSubCategoryDesc'] = array_combine($lanCodeArr, $Description);
        } else if (count($lanCodeArr) < count($Description)) {
            $data['subSubCategoryDesc']['en'] = $Description[0];

            foreach ($Name as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['subSubCategoryDesc'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['subSubCategoryDesc'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['subSubCategoryDesc']['en'] = $Description[0];
        }

        if ($catPhoto != null && $catPhoto != "")
            $insertIntoArr = array('name' => $Name, 'description' => $Description, 'imageUrl' => $catPhoto, 'subSubCategoryName' => $data['subSubCategoryName'], 'subSubCategoryDesc' => $data['subSubCategoryDesc']);
        else
            $insertIntoArr = array('name' => $Name, 'description' => $Description, 'subSubCategoryName' => $data['subSubCategoryName'], 'subSubCategoryDesc' => $data['subSubCategoryDesc']);

        $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($insertIntoArr)->update('thirdCategory');
        echo json_encode($res);
    }

    function deleteSubSubCategory() {

        $val = $this->input->post('val');

        foreach ($val as $row) {
            $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('thirdCategory');
        }
        $image = $data['Image'];
        foreach ($val as $row) {
            $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->delete('thirdCategory');
        }
        $foldername = 'third_level_category';
        $resu = $this->utility_library->deleteImage($foldername, $image);
        echo json_encode($resu);
    }

    public function getSubSubCategoryData() {

        $val = $this->input->post('val');

       

            $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('thirdCategory');
        
        return $cursor;
    }

    function hideSubsubCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('thirdCategory');
            if ($getdata['visibility'] == 1) {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 0, 'visibilityMsg' => "Unhidden"))->update('thirdCategory');
                echo json_encode(array('msg' => 'Selected category hided successfully', 'flag' => 1));
            } else if ($getdata['visibility'] == 0) {
                echo json_encode(array('msg' => 'Selected category is hided already', 'flag' => 0));
            }
        }
    }

    function unhideSubsubCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('thirdCategory');
            if ($getdata['visibility'] == 0 || $getdata['visibility'] == '') {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 1, 'visibilityMsg' => "Unhidden"))->update('thirdCategory');
                echo json_encode(array('msg' => 'Selected category unhided successfully', 'flag' => 1));
            } else if ($getdata['visibility'] == 1) {
                echo json_encode(array('msg' => 'Selected category is unhided already', 'flag' => 0));
            }
        }
    }

    function changeCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->find_one('thirdCategory');
        $Prevecountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->find_one('thirdCategory');
        $currcount = $Curruntcountval['seqID'];
        $prevcount = $Prevecountval['seqID'];
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->set(array('seqID' => $prevcount))->update('thirdCategory');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->set(array('seqID' => $currcount))->update('thirdCategory');
    }

    function getSubsubCategoryDataList($id = '') {
        if ($id != '' || $id != null) {
            $cursor = $this->mongo_db->where(array("subCategoryId" => new MongoDB\BSON\ObjectID($id)))->get('thirdCategory');
            echo json_encode(array('data' => $cursor));
        } else {
            $val = $this->input->post('val');
            $cursor = $this->mongo_db->where(array("subCategoryId" => new MongoDB\BSON\ObjectID($val),'visibility'=>1))->get('thirdCategory');
            $entities = array();
            $entities = '<select class="form-control error-box-class"  id="subSubCategory" name="subSubCategory">
                     <option value="">Select Sub-SubCategory</option>';
            foreach ($cursor as $d) {

                $entities .= '<option data-name="' . implode($d['name'], ';') . '" value="' . $d['_id']['$oid'] . '">' . implode($d['name'], ',') . '</option>';
            }
            $entities .= '</select>';
            echo $entities;
        }
    }

}

?>
