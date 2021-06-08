
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
        $this->load->model("Categorymodal");
        $this->load->model("SubCategorymodal");
        $this->load->library('utility_library');
    }


      //search product
      public function getProductsBySerach() {
        $this->load->library('mongo_db');
        $sSearch = $this->input->post('serachData');
        $pCatId=$this->input->post('pCatId');
        $sCatId=$this->input->post('scatId');
        $sRegex = quotemeta($sSearch);
        $sRegex = '^'.$sRegex;
        $sRegex = "$sRegex";
        $searchTermsAny[] = array('name' => new MongoDB\BSON\Regex($sRegex, "i"));      
        $searchTerms = array();
        $searchTerms['$or'] = $searchTermsAny;  
        
        

        $parentId=$this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($pCatId)))->select(array('parentCatId'=>'parentCatId',))->find_one('firstCategory');    
        $serchPId=$parentId['parentCatId'];
      
        $subparentId=$this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($sCatId)))->select(array('parentCatId'=>'parentCatId',))->find_one('secondCategory');
        $serchPIdsub=$subparentId['parentCatId'];
       
        $searchTermsProduct['$and'] = array($searchTerms,array("categoryId" => new MongoDB\BSON\ObjectID($serchPId),"subCategoryId" => new MongoDB\BSON\ObjectID($serchPIdsub) ));

      

       
      
        
       // $mastersData =  $this->mongo_db->where($searchTerms)->select(array('name'=>'name','subSubCategoryDesc'=>'subSubCategoryDesc'))->get('thirdCategory');    
       $mastersData =  $this->mongo_db->where($searchTermsProduct)->select(array('name'=>'name','subSubCategoryDesc'=>'subSubCategoryDesc'))->get('thirdCategory');    
     
        echo json_encode(array('data'=>$mastersData));

    }

    function getProductDataDetail($id = '') {
       
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('thirdCategory');
       
        echo json_encode(array('data' => $data));
    }


    function datatable_subsubcategory($param, $status) {

        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $data1['id'] = $param;
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "description";

        $respo = $this->datatables->datatable_mongodb('franchisethirdCategory', array('franchiseId' => $this->session->userdata('fadmin')['MasterBizId'],'subCategoryId' => new MongoDB\BSON\ObjectID($param), 'visibility' => (int) $status), 'seqID', 1); //1->ASCE -1->DESC

        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;

        foreach ($aaData as $value) {
            $arr = array();
            $arr[] = $sl++;
            $arr[] = '<img src="' . $value['imageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'' . base_url('../') . '/pics/user.jpg\';"   width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            $arr[] = $value['name'][0];
//            $arr[] = ($value['visibility'] == 1) ? 'Unhidden' : 'Hidden';
            $arr[] = $value['description'][0];
            $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
            $arr[] = '<button class="btn btnedit cls111" id="btnedit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #606b71;color: white;width: 45px !important;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
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
        $previousCategory = $this->mongo_db->where(array('subCategoryId' => new MongoDB\BSON\ObjectID($_REQUEST['subCategoryId']), 'subSubCategoryName.en' => $_REQUEST['name'][0]))->find_one('franchisethirdCategory');//array('$in' => $_REQUEST['name'])
//       echo '<pre>'; print_r( $_REQUEST['name']); print_r($previousCategory); die;
        if ($previousCategory) {
            echo json_encode(array('msg' => 0));
        } else {
            $data = $_POST;
            $data['franchiseId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['categoryId'] = new MongoDB\BSON\ObjectID($data['categoryId']);
            $data['subCategoryId'] = new MongoDB\BSON\ObjectID($data['subCategoryId']);
            $data['visibility'] = (int)$data['visibility'];
            if ($data['visibility'] == 1) {
                $data['visibilityMsg'] = "Unhidden";
            } else {
                $data['visibilityMsg'] = "Hidden";
            }

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

            if (count($lanCodeArr) == count($data['name'])) {
                $data['subSubCategoryName'] = array_combine($lanCodeArr, $data['name']);
            } else if (count($lanCodeArr) < count($data['name'])) {
                $data['subSubCategoryName']['en'] = $data['name'][0];

                foreach ($data['name'] as $key => $val) {
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
                $data['subSubCategoryName']['en'] = $data['name'][0];
            }

            if (count($lanCodeArr) == count($data['description'])) {
                $data['subSubCategoryDesc'] = array_combine($lanCodeArr, $data['description']);
            } else if (count($lanCodeArr) < count($data['description'])) {
                $data['subSubCategoryDesc']['en'] = $data['description'][0];

                foreach ($data['description'] as $key => $val) {
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
                $data['subSubCategoryDesc']['en'] = $data['description'][0];
            }

            $cursor = $this->mongo_db->get('franchisethirdCategory');
            $arr = [];
            foreach ($cursor as $catdata) {
                array_push($arr, $catdata['seqID']);
            }
            $max = max($arr);
            $data['seqID'] = $max + 1;
            $data['appId'] = "";
			$data['status'] =0;
        //    echo '<pre>'; print_r($data); die;

            $id = new MongoDB\BSON\ObjectID();
            $data['_id'] = $id;

            $res = $this->mongo_db->insert('franchisethirdCategory', $data);

            // $storeThirdCategory['thirdCategory'] = array('id'=>(string)$id,'imageUrl'=>$data['imageUrl'],'subSubCategoryName'=>$data['subCategoryName'],'categoryId'=>(string)$data['categoryId'],'subCategoryId'=>(string)$data['subCategoryId'],'subSubCategoryDesc'=> $data['subSubCategoryDesc']);
            // $storeThirdCategory['franchiseId'] =$this->session->userdata('fadmin')['MasterBizId'];           
            // $url = APILink. 'store/update/categorires';
            // $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeThirdCategory), true);

            echo json_encode(array('msg' => 1));
        }
    }

    function editSubSubCategory() {
        $data = $_POST;
      
        // $Catid = $_REQUEST['Catid'];
       
        $id = $data['editId'];
        unset($data['editId']);
       
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

         if (count($lanCodeArr) == count($data['name'])) {
                $data['subSubCategoryName'] = array_combine($lanCodeArr, $data['name']);
            } else if (count($lanCodeArr) < count($data['name'])) {
                $data['subSubCategoryName']['en'] = $data['name'][0];

                foreach ($data['name'] as $key => $val) {
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
                $data['subSubCategoryName']['en'] = $data['name'][0];
            }

            if (count($lanCodeArr) == count($data['description'])) {
                $data['subSubCategoryDesc'] = array_combine($lanCodeArr, $data['description']);
            } else if (count($lanCodeArr) < count($data['description'])) {
                $data['subSubCategoryDesc']['en'] = $data['description'][0];

                foreach ($data['description'] as $key => $val) {
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
                $data['subSubCategoryDesc']['en'] = $data['description'][0];
            }
//          echo '<pre>'; print_r($data); die;

        $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($data)->update('franchisethirdCategory');
        echo json_encode($res);
    }

    function deleteSubSubCategory() {

        $val = $this->input->post('val');

        foreach ($val as $row) {
            $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('franchisethirdCategory');
        }
        $image = $data['Image'];
        foreach ($val as $row) {
            $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->delete('franchisethirdCategory');
        }
        $foldername = 'third_level_category';
        $resu = $this->utility_library->deleteImage($foldername, $image);
        echo json_encode($resu);
    }

    public function getSubSubCategoryData() {

        $val = $this->input->post('val');
            $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('franchisethirdCategory');
        return $cursor;
    }

    function hideSubsubCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 0, 'visibilityMsg' => "Unhidden"))->update('franchisethirdCategory');
        }
        echo json_encode(array('msg' => 'Selected category hided successfully', 'flag' => 1));
    }

    function unhideSubsubCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 1, 'visibilityMsg' => "Unhidden"))->update('franchisethirdCategory');
        }
        echo json_encode(array('msg' => 'Selected category unhided successfully', 'flag' => 1));
    }

    function changeCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->find_one('franchisethirdCategory');
        $Prevecountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->find_one('franchisethirdCategory');
        $currcount = $Curruntcountval['seqID'];
        $prevcount = $Prevecountval['seqID'];
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->set(array('seqID' => $prevcount))->update('franchisethirdCategory');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->set(array('seqID' => $currcount))->update('franchisethirdCategory');
    }

    function getSubsubCategoryDataList($id = '') {
        if ($id != '' || $id != null) {
            $cursor = $this->mongo_db->where(array("subCategoryId" => new MongoDB\BSON\ObjectID($id),'visibility'=>1))->get('franchisethirdCategory');
            echo json_encode(array('data' => $cursor));
        } else {
            $val = $this->input->post('val');
            $cursor = $this->mongo_db->where(array("subCategoryId" => new MongoDB\BSON\ObjectID($val),'visibility'=>1))->get('franchisethirdCategory');
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

    function getSubSubCategoryByCategoryId(){
        $cateId = $this->input->post('categoryId');
        $subcateId = $this->input->post('subCategoryId');
        $subSubcateDetails = array();
        $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($cateId),"subCategoryId" => new MongoDB\BSON\ObjectID($subcateId),'visibility'=>1))->get('franchisethirdCategory');
        foreach($cursor as $subSubcateData){
            $subSubcateDetails[]=array('subSubcateName'=>$subSubcateData['subSubCategoryName'],'subSubCategoryId'=>$subSubcateData['_id']['$oid']);
        }
        return $subSubcateDetails;
}

}

?>
