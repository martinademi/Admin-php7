
<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class SubCategorymodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('utility_library');
    }

    function get_lan_hlpText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->get('lang_hlp');
        } else {
            $where = array('$and' => array(array('lan_id' => (int) $param), array('Active' => 1)));
            $res = $this->mongo_db->get_where('lang_hlp', $where);
        }
        return $res;
    }

      //search product
      public function getProductsBySerach() {
        $this->load->library('mongo_db');
        $sSearch = $this->input->post('serachData');
        $pCatId=$this->input->post('pCatId');
        $sRegex = quotemeta($sSearch);
        $sRegex = '^'.$sRegex;
        $sRegex = "$sRegex";
        $searchTermsAny[] = array('name' => new MongoDB\BSON\Regex($sRegex, "i"));      
        $searchTerms = array();
        $searchTerms['$or'] = $searchTermsAny;  
       
        
      
        
        $parentId=$this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($pCatId)))->select(array('parentCatId'=>'parentCatId',))->find_one('firstCategory');    
        $serchPId=$parentId['parentCatId'];
        $searchTermsProduct['$and'] = array($searchTerms,array("categoryId" => new MongoDB\BSON\ObjectID($serchPId)));  
        
        // $mastersData =  $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($serchPId)))->select(array('name'=>'name','description'=>'description'))->find_one('secondCategory');    
        // echo '<pre>';print_r($mastersData);die;
        
         $mastersData =  $this->mongo_db->where($searchTermsProduct)->select(array('name'=>'name','description'=>'description'))->get('secondCategory');    
       
        echo json_encode(array('data'=>$mastersData));

    }

    function getProductDataDetail($id = '') {
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('secondCategory');
        echo json_encode(array('data' => $data));
    }

    function datatable_subcategory($param,$status) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $data1['id'] = $param;
        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "description";
        $_POST['mDataProp_2'] = "visibility";
        
        
      
        $respo = $this->datatables->datatable_mongodb('franchisesecondCategory', array('franchiseId' => $this->session->userdata('fadmin')['MasterBizId'],'categoryId' => new MongoDB\BSON\ObjectID($param),'visibility' => (int)$status), 'seqId', -1); //1->ASCE -1->DESC

        $aaData = $respo["aaData"];
        
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;

        foreach ($aaData as $value) {
            $count = $this->mongo_db->where(array('subCategoryId' => new MongoDB\BSON\ObjectID($value['_id']['$oid'])))->count('thirdCategory');
            $count1 = $this->mongo_db->where(array('categoryId' => $param,'subCategoryId' => $value['_id']['$oid']))->count('metaTags');
            $arr = array();
            $arr[] = $sl++;
            $arr[] = '<img src="' . $value['imageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'' . base_url('../') . '/pics/user.jpg\';"   width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            $arr[] = $value['name'][0];

            $arr[] = $value['description'][0];
            $arr[] = '<a class="badge bg-green"  href="' . base_url() . 'index.php?/SubsubCategory/subSubCategory/' . (string) $value['_id']['$oid'] . '/' . $data1['id'] . '" style="cursor :pointer; "  > ' . $count . '</a>';

            $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
            $arr[] = '<button class="btn btnedit cls111" id="btnedit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #606b71;color: white;width: 45px !important;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function SubCategory($param = '') {
        if ($param != '' || $param != null) {

            $cursor = $this->mongo_db->where(array('categoryId' => $param))->get('secondCategory');

            $entities = '<select class="form-control ui fluid dropdown"  id="subCatId" name="subcat_select[]" >
                                     <option data-name="Select Sub-Category" value="">Select Sub-Category</option>';
            foreach ($cursor as $d) {
                $entities .= '<option data-name="' . $d['name'] . '" value="' . $d['_id']['$oid'] . '">' . $d['name'] . '</option>';
            }
            $entities .= ' </select>';

            return $entities;
        } else {
            $MAsterData = $this->mongo_db->get('secondCategory');
            $data = array();

            foreach ($MAsterData as $driver) {
                $data[] = array('name' => $driver['name'], 'description' => $driver['description'], 'categoryId' => $driver['categoryId'], 'subCategoryId' => $driver['_id']['$oid']);
            }
            return $data;
        }
    }

    function SubCategoryData() {
        $MAsterData = $this->mongo_db->get('secondCategory');
        $data = array();

        foreach ($MAsterData as $driver) {
            $data[] = array('id' => $driver['_id']['$oid'], 'name' => $driver['name'], 'description' => $driver['description'], 'categoryId' => $driver['categoryId']);
        }
        return $data;
    }

    function getSubCategoryData($id = '') {



        if ($id != '' || $id != null) {
            $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($id),'visibility'=>1))->get('franchisesecondCategory');
            echo json_encode(array('data' => $cursor));
        } else {
            $val = $this->input->post('val');
            $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($val),'visibility'=>1))->get('franchisesecondCategory');
            $entities = array();
            $entities = '<select class="form-control error-box-class"  id="subCategory" name="subCategory">
                     <option value="">Select Sub-Category</option>';
            foreach ($cursor as $d) {

                $entities .= '<option data-name="' . implode($d['name'], ';') . '" value="' . $d['_id']['$oid'] . '">' . implode($d['name'], ',') . '</option>';
            }
            $entities .= '</select>';
//        print_r($entities);die;
            echo $entities;
        }
    }

    public function getbusiness_catdataTwo() {

        $val = $this->input->post('val');
//        foreach ($val as $row) {
            $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('franchisesecondCategory');
//        }
        return $cursor;
    }

    function insertSubCategory() {
        $previousCategory = $this->mongo_db->where(array('categoryId' => new MongoDB\BSON\ObjectID($_REQUEST['cateid']), 'name' => array('$in' => $_REQUEST['name'])))->find_one('franchisesecondCategory');


        if ($previousCategory) {
            echo json_encode(array('msg' => 0));
        } else {
            $data = $_POST;
          
            $data['franchiseId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['categoryId'] = new MongoDB\BSON\ObjectID($data['categoryId']);
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
                $data['subCategoryName'] = array_combine($lanCodeArr, $data['name']);
            } else if (count($lanCodeArr) < count($data['name'])) {
                $data['subCategoryName']['en'] = $data['name'][0];

                foreach ($data['name'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['subCategoryName'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['subCategoryName'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['subCategoryName']['en'] = $data['name'][0];
            }

            if (count($lanCodeArr) == count($data['description'])) {
                $data['subCategoryDesc'] = array_combine($lanCodeArr, $data['description']);
            } else if (count($lanCodeArr) < count($data['description'])) {
                $data['subCategoryDesc']['en'] = $data['description'][0];

                foreach ($data['description'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['subCategoryDesc'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['subCategoryDesc'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['subCategoryDesc']['en'] = $data['description'][0];
            }

            if($data['parentCatId']!="" || $data['parentCatId']!=null){
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }


            $cursor = $this->mongo_db->get('franchisesecondCategory');
            $arr = [];
            foreach ($cursor as $catdata) {
                array_push($arr, $catdata['seqId']);
            }
            $max = max($arr);
            $data['seqId'] = $max + 1;
            $data['appId'] = "";
		//	$data['status'] = 0;
         

            $id = new MongoDB\BSON\ObjectID();
            $data['_id'] = $id;

            // echo '<pre>'; print_r($data); die;
            $res = $this->mongo_db->insert('franchisesecondCategory', $data);

            // $storeSecondCategory['secondCategory'] = array('id'=>(string)$id,'imageUrl'=>$data['imageUrl'],'subCategoryName'=>$data['subCategoryName'],'categoryId'=>(string)$data['categoryId'],'subCategoryDesc'=> $data['subCategoryDesc']);
            // $storeSecondCategory['franchiseId'] =$this->session->userdata('fadmin')['MasterBizId'];          
            // $url = APILink. 'store/update/categorires';
            // $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeSecondCategory), true);
            
            echo json_encode(array('msg' => 1));
        }
    }

    function editSubCategory() {
        
        $data = $_POST;
        
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
            $data['subCategoryName'] = array_combine($lanCodeArr, $data['name']);
        } else if (count($lanCodeArr) < count($data['name'])) {
            $data['subCategoryName']['en'] = $data['name'][0];

            foreach ($data['name'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['subCategoryName'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['subCategoryName'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['subCategoryName']['en'] = $data['name'][0];
        }

        if (count($lanCodeArr) == count($data['description'])) {
                $data['subCategoryDesc'] = array_combine($lanCodeArr, $data['description']);
            } else if (count($lanCodeArr) < count($data['description'])) {
                $data['subCategoryDesc']['en'] = $data['description'][0];

                foreach ($data['description'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['subCategoryDesc'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['subCategoryDesc'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['subCategoryDesc']['en'] = $data['description'][0];
            }
//            echo '<pre>'; print_r($data); die;
        
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($data)->update('franchisesecondCategory');
        return true;
    }

    function deleteSubCategory() {
        $this->load->library('utility_library');
        $val = $this->input->post('val');

        foreach ($val as $row) {
            $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('franchisesecondCategory');
        }
        $image = $data['imageUrl'];
        foreach ($val as $row) {
            $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->delete('franchisesecondCategory');
        }

        $foldername = 'second_level_category';
        $resu = $this->utility_library->deleteImage($foldername, $image);
        echo json_encode($resu);
    }

    function unhideSubCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 1, 'visibilityMsg' => "Unhidden"))->update('secondCategory');
        }
        echo json_encode(array('msg' => 'Selected category unhided successfully', 'flag' => 1));
    }

    function hideSubCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 0, 'visibilityMsg' => "Hidden"))->update('secondCategory');
        }
        echo json_encode(array('msg' => 'Selected category hided successfully', 'flag' => 1));
    }

    function changeCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->find_one('secondCategory');
        $Prevecountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->find_one('secondCategory');
        $currcount = $Curruntcountval['seqId'];
        $prevcount = $Prevecountval['seqId'];
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->set(array('seqId' => $prevcount))->update('secondCategory');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->set(array('seqId' => $currcount))->update('secondCategory');
    }

    function getSubCategoryByCategoryId(){
        $cateId = $this->input->post('categoryId');
        $subcateDetails = array();
        $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($cateId),'visibility'=>1))->get('secondCategory');
        foreach($cursor as $subcateData){
            $subcateDetails[]=array('subcateName'=>$subcateData['subCategoryName'],'subCategoryId'=>$subcateData['subCategoryId']);
        }
        return $subcateDetails;
}

}

?>
