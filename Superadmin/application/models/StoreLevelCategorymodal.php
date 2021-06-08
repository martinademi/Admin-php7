<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class StoreLevelCategorymodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('utility_library');
        $this->load->library('CallAPI');
    }

    function datatable_category($status) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "description";
        $_POST['mDataProp_2'] = "storeName";

//        $count1 = count($cat);


        //$respo = $this->datatables->datatable_mongodb('firstCategory', array("addedFrom"=>"store",'status' => (int) $status), 'seqID', 1); //1->ASCE -1->DESC
        $respo = $this->datatables->datatable_mongodb('storefirstCategory', array("addedFrom"=>"store",'status' => (int) $status), '_id', -1); //1->ASCE -1->DESC

        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;

        foreach ($aaData as $value) {   
           
            // $storeName=$this->mongo_db->where(array('firstCategoryId'=>$value['_id']['$oid']))->select(array("storeName"=>"storeName"))->find_one('childProducts'); 
            $storeName=$this->mongo_db->where(array('_id'=>new MongoDB\BSON\ObjectID($value['storeid'])))->select(array("name"=>"name"))->find_one('stores'); 
            // echo '<pre>';print_r($storeName);die;
            $count = $this->mongo_db->where(array('categoryId' => new MongoDB\BSON\ObjectID($value['_id']['$oid'])))->count('storesecondCategory');
            $count1 = $this->mongo_db->where(array('categoryId' => $value['_id']['$oid']))->count('metaTags');
            $arr = array();
            $arr[] = $sl++;
            $arr[] = '<img src="' . $value['imageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'' . base_url('../../') . '/pics/user.jpg\';"   width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            $arr[] = $value['name'][0];
            $arr[] = ($value['visibility'] == 0) ? 'Hidden' : 'Unhidden';
            $arr[] = $value['description'][0];
            $arr[] = '<a class="badge bg-green" href="' . base_url() . 'index.php?/ProductSubCategory/SubCategory/' . (string) $value['_id']['$oid'] . '" style="cursor :pointer; "  > ' . $count . '</a>';
            // $arr[] = '<a class="badge bg-green" href="' . base_url() . 'index.php?/StoreMetatags/meta_tags/' . (string) $value['_id']['$oid'] . ' ">' . $count1 . '</a>';
           // $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
            $arr[]= $storeName['name'][0];
            $arr[] = '<button class="btn btnedit cls111" id="btnedit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #606b71;color: white;width: 45px !important;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function insertCategory() {
        $previousCategory = $this->mongo_db->where(array('name' => $_REQUEST['name']))->find_one('firstCategory');
        if ($previousCategory) {
            echo json_encode(array('msg' => 0));
        } else {
            $data = $_POST;

            $data['storeid'] = $this->session->userdata('badmin')['BizId'];
            $cursor = $this->mongo_db->get("firstCategory");
            
             $data['visibility'] = (int)$data['visibility'];
            if ($visibility == 1) {
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
                $data['categoryName'] = array_combine($lanCodeArr, $data['name']);
            } else if (count($lanCodeArr) < count($data['name'])) {
                $data['categoryName']['en'] = $data['name'][0];

                foreach ($data['name'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['categoryName'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['categoryName'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['categoryName']['en'] = $data['name'][0];
            }

            if (count($lanCodeArr) == count($data['description'])) {
                $data['categoryDesc'] = array_combine($lanCodeArr, $data['description']);
            } else if (count($lanCodeArr) < count($data['description'])) {
                $data['categoryDesc']['en'] = $data['description'][0];

                foreach ($data['description'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['categoryDesc'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['categoryDesc'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['categoryDesc']['en'] = $data['description'][0];
            }

            $id = new MongoDB\BSON\ObjectID();
            $this->load->model("Seomodel");
            $xmlres = $this->Seomodel->createXmlFile((string) $id);
            $data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $id . '.xml';

            $data['_id'] = $id;

            $arr = [];
            foreach ($cursor as $catdata) {
                array_push($arr, $catdata['seqID']);
            }
            $max = max($arr);
            $seq = $max + 1;
            $data['seqID'] = $seq;
            $data['status'] = 0;
            $data['statusMsg'] = "New";
            $data['appId'] = "";

//            echo '<pre>';    print_r($data); die;

            $res = $this->mongo_db->insert('firstCategory', $data);
            echo json_encode(array('msg' => 1));
        }
    }
	
	function approveCategory(){
		 $val = $this->input->post('val');
		 foreach($val as $id){

            $catdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('storefirstCategory');
            $storeId = $catdata['storeid'];

            $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set(array('status'=>1))->update('storefirstCategory');
            
            if($res){
            
                $storeFirstCategory['_id'] = $id;
                $storeFirstCategory['type'] =1;
                $storeFirstCategory['storeId'] = $storeId ;                      
                $url = APILink. 'updateToStoreProduct';
                $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);                   

            }
           
		 }
		 if($res){
			 echo json_encode(array('msg'=>1));
		 }else{
			 echo json_encode(array('msg'=>0));
		 }
	}
	function banCategory(){
		 $val = $this->input->post('val');
		 $reason = $this->input->post('reason');
		 foreach($val as $id){
			$res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set(array('status'=>4,'reason'=>$reason))->update('storefirstCategory');
		 }
		 if($res){
			 echo json_encode(array('msg'=>1));
		 }else{
			 echo json_encode(array('msg'=>0));
		 }
	}
	function rejectCategory(){
		 $val = $this->input->post('val');
		 $reason = $this->input->post('reason');
		 foreach($val as $id){
			$res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set(array('status'=>3,'reason'=>$reason))->update('storefirstCategory');
		 }
		 if($res){
			 echo json_encode(array('msg'=>1));
		 }else{
			 echo json_encode(array('msg'=>0));
		 }
	}

    function editCategory() {

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
            $data['categoryName'] = array_combine($lanCodeArr, $data['name']);
        } else if (count($lanCodeArr) < count($data['name'])) {
            $data['categoryName']['en'] = $data['name'][0];

            foreach ($data['name'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['categoryName'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['categoryName'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['categoryName']['en'] = $data['name'][0];
        }

        if (count($lanCodeArr) == count($data['description'])) {
            $data['categoryDesc'] = array_combine($lanCodeArr, $data['description']);
        } else if (count($lanCodeArr) < count($data['description'])) {
            $data['categoryDesc']['en'] = $data['description'][0];

            foreach ($data['description'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['categoryDesc'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['categoryDesc'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['categoryDesc']['en'] = $data['description'][0];
        }

        $catdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('storefirstCategory');
        $storeId = $catdata['storeid'];
        
        if (!$catdata['fileName'] || empty($catdata['fileName'])) {
            $this->load->model("Seomodel");
            $xmlres = $this->Seomodel->createXmlFile((string) $id);
            $data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $id . '.xml';
        }
        
         if ($data['fileName']) {
            $data['fileName'] = $data['fileName'];
        }
//        echo '<pre>';       print_r($data);   die;
        $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($data)->update('storefirstCategory');

        if($result){
            
            $storeFirstCategory['_id'] = $id;
            $storeFirstCategory['type'] =1;
            $storeFirstCategory['storeId'] = $storeId ;                      
            $url = APILink. 'updateToStoreProduct';
            $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);    
          
        }

        echo json_encode($result);
    }

    function CategoryData() {
        $MAsterData = $this->mongo_db->get('storefirstCategory');
        $data = array();

        foreach ($MAsterData as $driver) {
            $data[] = array('name' => $driver['name'], 'description' => $driver['description'], 'categoryId' => $driver['_id']['$oid']);
        }
        return $data;
    }

    function deleteCategory() {
        $this->load->library('utility_library');
        $val = $this->input->post('val');

        foreach ($val as $row) {

            $catdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('storefirstCategory');
            $storeId = $catdata['storeid'];

           // $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('storefirstCategory');
            $data['status']=2;
            $data['visibility']=1;
            $data['visibilityMsg']="deleted";
          
    
            $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set($data)->update('storefirstCategory');

            if($result){
            
                $storeFirstCategory['_id'] = (string)$row;
                $storeFirstCategory['type'] =1;
                $storeFirstCategory['storeId'] = $storeId ;                      
                $url = APILink. 'updateToStoreProduct';
                $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);                   
                echo json_encode($response);
            }

        }
        // $image = $data['imageUrl'];
        // foreach ($val as $row) {
        //     $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->set(array("status"=>2))->update('storefirstCategory');
        //     $this->mongo_db->where(array('categoryId' => $row))->set(array("status"=>2))->update('storefirstCategory');
        //     $this->mongo_db->where(array('categoryId' => $row))->set(array("status"=>2))->update('storefirstCategory');
        // }
        // $foldername = 'first_level_category';
        // $resu = $this->utility_library->deleteImage($foldername, $image);
        // echo json_encode($result);
    }

    public function getCategoryData() {

        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('storefirstCategory');

        echo json_encode(array('data' => $cursor));
    }

    function unhideCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('storefirstCategory');
            if ($getdata['visibility'] == 0 || $getdata['visibility'] == '') {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 1, 'visibilityMsg' => "Unhidden"))->update('storefirstCategory');
                echo json_encode(array('msg' => 'Selected category unhided successfully', 'flag' => 1));
            } else if ($getdata['visibility'] == 1) {
                echo json_encode(array('msg' => 'Selected category is unhided already', 'flag' => 0));
            }
        }
    }

    function hideCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('storefirstCategory');
            if ($getdata['visibility'] == 1) {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 0, 'visibilityMsg' => "Hidden"))->update('storefirstCategory');
                echo json_encode(array('msg' => 'Selected category hided successfully', 'flag' => 1));
            } else if ($getdata['visibility'] == 0) {
                echo json_encode(array('msg' => 'Selected category is hided already', 'flag' => 0));
            }
        }
    }

    function getCategoryForFranchise_and_Business() {
//        $resultData = $this->mongo_db->order_by(array('seqID' => 'ASC'))->get('firstCategory');
        $resultData = $this->mongo_db->where(array('visibility' => 1))->order_by(array('seqID' => 'ASC'))->get('storefirstCategory');
        $data = array();

        foreach ($resultData as $res) {
            $data[] = array('name' => $res['name'], 'description' => $res['description'], 'categoryId' => $res['_id']['$oid']);
        }
//        print_r($data); die;
        return $data;
    }

    function changeCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->find_one('storefirstCategory');
        $Prevecountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->find_one('storefirstCategory');
        $currcount = $Curruntcountval['seqID'];
        $prevcount = $Prevecountval['seqID'];
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->set(array('seqID' => $prevcount))->update('storefirstCategory');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->set(array('seqID' => $currcount))->update('storefirstCategory');
    }

    function getCategory($param1 = '', $param2 = '', $param3 = '') {
        $category = $this->mongo_db->where()->find_one();
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

}

?>
