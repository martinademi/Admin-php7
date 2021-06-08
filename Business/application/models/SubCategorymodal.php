
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
        $this->load->library('CallAPI');
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
        $searchTermsAny[] = array('name' => new MongoDB\BSON\Regex($sRegex, "i"),'visibility'=>1);      
        $searchTerms = array();
        $searchTerms['$or'] = $searchTermsAny;  
       
        
      
        
        $parentId=$this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($pCatId)))->select(array('parentCatId'=>'parentCatId',))->find_one('storefirstCategory');    
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
        
        
        //$respo = $this->datatables->datatable_mongodb('secondCategory', array('storeid' => $this->session->userdata('badmin')['BizId'],'categoryId' => new MongoDB\BSON\ObjectID($param),'visibility' => (int)$status), 'seqId', -1); //1->ASCE -1->DESC
        $respo = $this->datatables->datatable_mongodb('storesecondCategory', array('storeid' => $this->session->userdata('badmin')['BizId'],'categoryId' => new MongoDB\BSON\ObjectID($param),'status' => (int)$status), 'seqId', -1); //1->ASCE -1->DESC

        $aaData = $respo["aaData"];
        
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;

        foreach ($aaData as $value) {
            $count = $this->mongo_db->where(array('subCategoryId' => new MongoDB\BSON\ObjectID($value['_id']['$oid'])))->count('storethirdCategory');
            $count1 = $this->mongo_db->where(array('categoryId' => $param,'subCategoryId' => $value['_id']['$oid']))->count('metaTags');

            if($status!=2){
                $btn = '<button class="btn btnedit cls111" id="btnedit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #286090;color: white;width: 45px !important;"><i class="fa fa-edit" style="font-size:12px;"></i></button>
            <button class="btn btndelete cls111" id="btndelete"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #cd3613;color: white;width: 45px !important;"><i class="fa fa-trash" style="font-size:12px;"></i></button>';
            }else{
                $btn = ' <button class="btn btnactive cls111" id="btnactive"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #1ABB9C;color: white;width: 45px !important;"><i class="fa fa-bars" style="font-size:12px;"></i></button>';
            }

            $arr = array();
            $arr[] = $sl++;
            $arr[] = '<img src="' . $value['imageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'' . base_url('../') . '/pics/user.jpg\';"   width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            $arr[] = $value['name'][0];
//            $arr[] = ($value['visibility'] == 1) ? 'Unhidden' : 'Hidden';
            $arr[] = $value['description'][0];
            $arr[] = '<a class="badge bg-green"  href="' . base_url() . 'index.php?/SubsubCategory/subSubCategory/' . (string) $value['_id']['$oid'] . '/' . $data1['id'] . '" style="cursor :pointer; "  > ' . $count . '</a>';
            //$arr[] = '<a class="badge bg-green"  href="' . base_url() . 'index.php?/Metatags/meta_tags/' . $data1['id'] . '/' . (string) $value['_id']['$oid'] . ' ">' . $count1 . '</a>';
            $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
            $arr[]=  $btn ;
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
            $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($id),'visibility'=>1))->get('storesecondCategory');
            echo json_encode(array('data' => $cursor));
        } else {
            $val = $this->input->post('val');
            $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($val),'visibility'=>1))->get('storesecondCategory');
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
            $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('storesecondCategory');
//        }
        return $cursor;
    }

    function insertSubCategory() {
        $previousCategory = $this->mongo_db->where(array('categoryId' => new MongoDB\BSON\ObjectID($_REQUEST['cateid']), 'name' => array('$in' => $_REQUEST['name'])))->find_one('secondCategory');


        if ($previousCategory) {
            echo json_encode(array('msg' => 0));
        } else {
            $data = $_POST;
            $data['storeid'] = $this->session->userdata('badmin')['BizId'];
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

            // commented during APi call

            // if($data['parentCatId']!="" || $data['parentCatId']!=null){
            //     $data['status'] = 1;
            // }else{
            //     $data['status'] = 1;
            // }


            $cursor = $this->mongo_db->get('storesecondCategory');
            $arr = [];
            foreach ($cursor as $catdata) {
                array_push($arr, $catdata['seqId']);
            }
            $max = max($arr);
            $data['seqId'] = $max + 1;
            $data['appId'] = "";
			$data['status'] = 1;
     
        $id = new MongoDB\BSON\ObjectID();
        $data['_id'] = $id;

        $res = $this->mongo_db->insert('storesecondCategory', $data);
     
        // chnages done for API
        $storeSecondCategory['secondCategory'] = array('id'=>(string)$id,'imageUrl'=>$data['imageUrl'],'subCategoryName'=>$data['subCategoryName'],'categoryId'=>(string)$data['categoryId'],'subCategoryDesc'=> $data['subCategoryDesc'],'status'=> $data['status']);
        $storeSecondCategory['storeId'] =$this->session->userdata('badmin')['BizId'];             
        $url = APILink. 'store/update/categorires';
        $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeSecondCategory), true);

     
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

        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($data)->update('storesecondCategory');
     

        $storeFirstCategory['_id'] = $id;
        $storeFirstCategory['type'] =2;
        $storeFirstCategory['storeId'] =$this->session->userdata('badmin')['BizId'];
        $url = APILink. 'updateToStoreProduct';
        $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);
        return true;

    }

    function deleteSubCategory() {
        $this->load->library('utility_library');
        $val = $this->input->post('val');

        foreach ($val as $row) {
            $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('storesecondCategory');
        }
        $image = $data['imageUrl'];
        foreach ($val as $row) {
            $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->delete('storesecondCategory');
        }

        $foldername = 'second_level_category';
        $resu = $this->utility_library->deleteImage($foldername, $image);
        echo json_encode($resu);
    }

    function unhideSubCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 1, 'visibilityMsg' => "Unhidden"))->update('storesecondCategory');
        }
        echo json_encode(array('msg' => 'Selected category unhided successfully', 'flag' => 1));
    }

    function hideSubCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 0, 'visibilityMsg' => "Hidden"))->update('storesecondCategory');
        }
        echo json_encode(array('msg' => 'Selected category hided successfully', 'flag' => 1));
    }

    function changeCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->find_one('storesecondCategory');
        $Prevecountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->find_one('storesecondCategory');
        $currcount = $Curruntcountval['seqId'];
        $prevcount = $Prevecountval['seqId'];
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->set(array('seqId' => $prevcount))->update('storesecondCategory');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->set(array('seqId' => $currcount))->update('storesecondCategory');

        $catSeqId=[$this->input->post("curr_id"),$this->input->post("prev_id")];

        foreach($catSeqId as $catId){
            $storeFirstCategory['_id'] = $catId;
            $storeFirstCategory['type'] =2;
            $storeFirstCategory['storeId'] =$this->session->userdata('badmin')['BizId'];                    
            $url = APILink. 'updateToStoreProduct';
            $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);
        } 
    }

    function getSubCategoryByCategoryId(){
        $cateId = $this->input->post('categoryId');
        $subcateDetails = array();
        $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($cateId),'visibility'=>1))->get('storesecondCategory');
        foreach($cursor as $subcateData){
            $subcateDetails[]=array('subcateName'=>$subcateData['subCategoryName'],'subCategoryId'=>$subcateData['subCategoryId']);
        }
        return $subcateDetails;
}


        function deleteCategory() {

            $this->load->library('utility_library');
            $val = $this->input->post('val');

        
            $data['status']=2;
            $data['visibility']=1;
            $data['visibilityMsg']="deleted";

            $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->set($data)->update('storesecondCategory');
            if($result){

                $storeFirstCategory['_id'] =$val;
                $storeFirstCategory['type'] =2;
                $storeFirstCategory['storeId'] =$this->session->userdata('badmin')['BizId'];              
                $url = APILink. 'updateToStoreProduct';
                $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);

                echo json_encode($response);

            }   
        }


        function activeCategory() {
            $this->load->library('utility_library');
            $val = $this->input->post('val');        
            $data['status']=1;
            $data['visibility']=1;
            $data['visibilityMsg']="Unhidden";         
            $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->set($data)->update('storesecondCategory');
            if($result){
                $storeFirstCategory['_id'] =$val;
                $storeFirstCategory['type'] =2;
                $storeFirstCategory['storeId'] =$this->session->userdata('badmin')['BizId'];              
                $url = APILink. 'updateToStoreProduct';
                $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);
                echo json_encode($response);
            }                  
        }

}

?>
