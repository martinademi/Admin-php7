<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Categorymodal extends CI_Model {

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
       // print_r($status);die;
//        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "description";
        $_POST['mDataProp_2'] = "visibility";

//        $count1 = count($cat);

        switch($status){
            case 0:	
			// print_r("visibility zero");die;
			
        $respo = $this->datatables->datatable_mongodb('firstCategory', array('visibility'=>0), '_id', -1);//1->ASCE -1->DESC
         $respo['lang'] = $this->mongo_db->where(array('Active' => 1))->get('lang_hlp');
		break;
            case 1:
			// print_r("visibility one");die;
        $respo = $this->datatables->datatable_mongodb('firstCategory', array('visibility'=>1), 'seqID', -1);//1->ASCE -1->DESC
        $respo['lang'] = $this->mongo_db->where(array('Active' => 1))->get('lang_hlp');
		break;
            
        }
        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;


        foreach ($aaData as $value) {
            if ($value['imageUrl']) {
                $imageField = '<img src="' . $value['imageUrl'] . '"  width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            } else {
                $imageField = '<img src="' . base_url('') . 'pics/user.jpg\';"   width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            }
            $count = $this->mongo_db->where(array('categoryId' => new MongoDB\BSON\ObjectID($value['_id']['$oid'])))->count('secondCategory');
//            $count = count($cat);
            $count1 = $this->mongo_db->where(array('categoryId' => $value['_id']['$oid']))->count('metaTags');
            $arr = array();
            $arr[] = $sl++;
            $arr[] = $imageField;
			if(count($respo['lang'])<1){
               
            $categoryName=($value['categoryName']['en'] != "" || $value['categoryName']['en'] != null) ? $value['categoryName']['en']: 'N/A';
			$categoryDesc=($value['categoryDesc']['en'] != "" || $value['categoryDesc']['en'] != null) ? $value['categoryDesc']['en']: 'N/A';
          
           }else{
            
            $categoryName=($value['categoryName']['en'] != "" || $value['categoryName']['en'] != null) ? $value['categoryName']['en']: 'N/A';
			$categoryDesc=($value['categoryDesc']['en'] != "" || $value['categoryDesc']['en'] != null) ? $value['categoryDesc']['en']: 'N/A';

            foreach( $respo['lang'] as $lang){

                $lan= $lang['langCode'];
                $categoryNames=($value['categoryName'][$lan] != "" || $value['categoryName'][$lan] != null) ? $value['categoryName'][$lan]: '';
				$categoryDescs=($value['categoryDesc'][$lan] != "" || $value['categoryDesc'][$lan] != null) ? $value['categoryDesc'][$lan]: '';
                
                
               if(strlen( $categoryNames)>0){
                $categoryName.= ',' . $categoryNames;
               }
			   if(strlen( $categoryDescs)>0){
                $categoryDesc.= ',' . $categoryDescs;
               }
            }


           }
			
            $arr[] = $categoryName;
//            $arr[] = ($value['visibility'] == 0) ? 'Hidden' : 'Unhidden';
            $arr[] = $categoryDesc;
            $arr[] = '<a class="badge bg-green" href="' . base_url() . 'index.php?/SubCategory/SubCategory/' . (string) $value['_id']['$oid'] . '" style="cursor :pointer; "  > ' . $count . '</a>';
            // $arr[] = '<a class="badge bg-green" href="' . base_url() . 'index.php?/Metatags/meta_tags/' . (string) $value['_id']['$oid'] . ' ">' . $count1 . '</a>';
            $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
             $arr[] = '<button style="width:35px;" class="btn btn-primary btnWidth editICON cls111"  value=' . $value['_id']['$oid'] . '><i class="fa fa-edit"></i></button>';
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
            $Name = $_REQUEST['name'];
            $cat_photosaa = $_REQUEST['cat_photosaa'];
            $Description = $_REQUEST['description'];
            $catPhoto = $_REQUEST['imageUrl'];
            $visibility = $_REQUEST['visibility'];
            $storeCategory =  json_decode($_REQUEST['storeCategory']);
            if($visibility == 1){
                $visibilityMsg = "Unhidden";
            }else{
                $visibilityMsg = "Hidden";
            }
            
            $cursor = $this->mongo_db->get("firstCategory");

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
            $data['categoryName'] = array_combine($lanCodeArr, $Name);
        } else if (count($lanCodeArr) < count($Name) ) {
            $data['categoryName']['en'] = $Name[0];
            
            foreach ($Name as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']){
                            $data['categoryName'][$lan['langCode']] = $val;
                        }
                    }else{
                       if ($key == $lan['lan_id']){
                            $data['categoryName'][$lan['langCode']] = $val;
                        } 
                    }
                }
                
            }
        } else {
            $data['categoryName']['en'] = $Name[0];
        }
        
        if (count($lanCodeArr) == count($Description)) {
            $data['categoryDesc'] = array_combine($lanCodeArr, $Description);
        } else if (count($lanCodeArr) < count($Description) ) {
            $data['categoryDesc']['en'] = $Description[0];
            
            foreach ($Description as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']){
                            $data['categoryDesc'][$lan['langCode']] = $val;
                        }
                    }else{
                       if ($key == $lan['lan_id']){
                            $data['categoryDesc'][$lan['langCode']] = $val;
                        } 
                    }
                }
                
            }
        } else {
            $data['categoryDesc']['en'] = $Description[0];
        }


            $id = new MongoDB\BSON\ObjectID();
            $this->load->model("Seomodel");
            $xmlres = $this->Seomodel->createXmlFile((string) $id);
          //  $fileName = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $id . '.xml';
          
          $fileName = dirname(__DIR__)."/../../../xml/" . $id . '.xml';
          //$fileName = base_url() . '../xml/' . $id . '.xml';
            $arr = [];
            foreach ($cursor as $catdata) {
                array_push($arr, $catdata['seqID']);
            }

            $max = max($arr);
            $seq = $max + 1;
            $insertIntoChatArr = array('_id' => $id, 'seqID' => $seq, 'name' => $Name, 'description' => $Description, 'imageUrl' => $catPhoto,
                                       'visibility' => (int) $visibility,'visibilityMsg' => $visibilityMsg,
                                        'fileName' => $fileName, 'categoryName' =>$data['categoryName'],
                                        'categoryDesc'=> $data['categoryDesc'],'storeCategory'=>$storeCategory);
//           echo '<pre>'; print_r($insertIntoChatArr); die;
            $res = $this->mongo_db->insert('firstCategory', $insertIntoChatArr);
            echo json_encode(array('msg' => 1));
        }
    }

    function CategoryData() {
        $MAsterData = $this->mongo_db->get('firstCategory');
        $data = array();

        foreach ($MAsterData as $driver) {
            $data[] = array('name' => $driver['name'], 'description' => $driver['description'], 'categoryId' => $driver['_id']['$oid']);
        }
        return $data;
    }

    function editCategory() {
        $Name = $_REQUEST['name'];
        $Description = $_REQUEST['description'];
        $id = $_REQUEST['editId'];
        $catPhoto = $_REQUEST['imageUrl'];
        $storeCategory =  json_decode($_REQUEST['storeCategory']);
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
            $data['categoryName'] = array_combine($lanCodeArr, $Name);
        } else if (count($lanCodeArr) < count($Name) ) {
            $data['categoryName']['en'] = $Name[0];
            
            foreach ($Name as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']){
                            $data['categoryName'][$lan['langCode']] = $val;
                        }
                    }else{
                       if ($key == $lan['lan_id']){
                            $data['categoryName'][$lan['langCode']] = $val;
                        } 
                    }
                }
                
            }
        } else {
            $data['categoryName']['en'] = $Name[0];
        }
        
        if (count($lanCodeArr) == count($Description)) {
            $data['categoryDesc'] = array_combine($lanCodeArr, $Description);
        } else if (count($lanCodeArr) < count($Description) ) {
            $data['categoryDesc']['en'] = $Description[0];
            
            foreach ($Description as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']){
                            $data['categoryDesc'][$lan['langCode']] = $val;
                        }
                    }else{
                       if ($key == $lan['lan_id']){
                            $data['categoryDesc'][$lan['langCode']] = $val;
                        } 
                    }
                }
                
            }
        } else {
            $data['categoryDesc']['en'] = $Description[0];
        }
        
        $catdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('firstCategory');

        if (!$catdata['fileName'] || empty($catdata['fileName'])) {
            $this->load->model("Seomodel");
            $xmlres = $this->Seomodel->createXmlFile((string) $id);
            $fileName = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $id . '.xml';
        }

        if ($catPhoto != null && $catPhoto != "") {
            $insertIntoArr = array('name' => $Name, 'description' => $Description, 'imageUrl' => $catPhoto, 'categoryName' => $data['categoryName'],'categoryDesc'=> $data['categoryDesc'],'storeCategory'=>$storeCategory);
        } else {
            $insertIntoArr = array('name' => $Name, 'description' => $Description, 'categoryName' => $data['categoryName'],'categoryDesc'=> $data['categoryDesc'],'storeCategory'=>$storeCategory);
        }

        if ($fileName) {
            $insertIntoArr['fileName'] = $fileName;
        }
//        print_r( $insertIntoArr['fileName']); die;
        $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($insertIntoArr)->update('firstCategory');

        if($result == 1 || $result == "1"){
            $url = APILink."updateToProduct";
            $data11["_id"]=$id;
            $data11["type"]="1";
            $response = json_decode($this->callapi->CallAPI('PATCH', $url, $data11), true);
        }

        
        echo json_encode($result);
    }

    function deleteCategory() {
        $this->load->library('utility_library');
        $val = $this->input->post('val');

        foreach ($val as $row) {
            $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('firstCategory');
        }
        $image = $data['imageUrl'];

        foreach ($val as $row) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->delete('firstCategory');
            $this->mongo_db->where(array('categoryId' => $row))->delete('secondCategory');
            $this->mongo_db->where(array('categoryId' => $row))->delete('thirdCategory');
        }
        $foldername = 'first_level_category';
        $resu = $this->utility_library->deleteImage($foldername, $image);
        echo json_encode($result);
    }

    public function getCategoryData() {

        $val = $this->input->post('val');
//        foreach ($val as $row) {

            $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('firstCategory');
//        }
        echo json_encode(array('data' => $cursor));
    }

    // function unhideCategory() {

    //     $val = $this->input->post('val');
    //     foreach ($val as $row) {
    //         $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('firstCategory');
    //         if ($getdata['visibility'] == 0 || $getdata['visibility'] == '') {
    //             $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 1,'visibilityMsg' => "Unhidden"))->update('firstCategory');
    //             echo json_encode(array('msg' => 'Selected category unhided successfully', 'flag' => 1));
    //         } else if ($getdata['visibility'] == 1) {
    //             echo json_encode(array('msg' => 'Selected category is unhided already', 'flag' => 0));
    //         }
    //     }
    // }

    // function hideCategory() {

    //     $val = $this->input->post('val');
    //     foreach ($val as $row) {
    //         $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('firstCategory');
    //         if ($getdata['visibility'] == 1) {
    //             $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 0,'visibilityMsg' => "Hidden"))->update('firstCategory');
    //             echo json_encode(array('msg' => 'Selected category hided successfully', 'flag' => 1));
    //         } else if ($getdata['visibility'] == 0) {
    //             echo json_encode(array('msg' => 'Selected category is hided already', 'flag' => 0));
    //         }
    //     }
    // }

    function unhideCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('firstCategory');
            if ($getdata['visibility'] == 0 || $getdata['visibility'] == '') {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 1,'visibilityMsg' => "Unhidden"))->update('firstCategory');
            } 
        }
        echo json_encode(array('msg' => 'Selected category unhided successfully', 'flag' => 1));
    }

    function hideCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('firstCategory');           
            if ($getdata['visibility'] == 1) {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 0,'visibilityMsg' => "Hidden"))->update('firstCategory');
            }            
        }
        echo json_encode(array('msg' => 'Selected category hided successfully', 'flag' => 1));
    }

    function getCategoryForFranchise_and_Business() {
        $resultData = $this->mongo_db->where(array('visibility'=>1))->order_by(array('seqID' => 'ASC'))->get('firstCategory');
       
        $data = array();

        foreach ($resultData as $res) {
            $storeCategoryId = [];
            if($res['storeCategory']){
                foreach($res['storeCategory'] as $resData){
                    $storeCategoryId[] = $resData['storeCategoryId'];
                }    

            }
            
            $data[] = array('name' => $res['categoryName'], 'description' => $res['categoryDesc'], 'categoryId' => $res['_id']['$oid'],'storeCategoryId'=>implode(',',$storeCategoryId));
        }
        return $data;
    }

    function changeCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->find_one('firstCategory');
        $Prevecountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->find_one('firstCategory');
        $currcount = $Curruntcountval['seqID'];
        $prevcount = $Prevecountval['seqID'];
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->set(array('seqID' => $prevcount))->update('firstCategory');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->set(array('seqID' => $currcount))->update('firstCategory');
    }

    function getCategory($param1 = '', $param2 = '', $param3 = '') {
        $category = $this->mongo_db->where()->find_one();
    }

    function get_lan_hlpText($param = '') {

        if ($param == '') {
            $where = array('Active' => 1);
            $res = $this->mongo_db->get('lang_hlp');
        } else {
            $where = array('$and' => array(array('lan_id' => (int) $param), array('Active' => 1)));
            $res = $this->mongo_db->get_where('lang_hlp', $where);
        }
        return $res;
    }

}

?>
