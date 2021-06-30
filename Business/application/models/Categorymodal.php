<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Categorymodal extends CI_Model {

    //chag

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('Datatables1');
        $this->load->library('table');
        $this->load->library('utility_library');
        $this->load->library('CallAPI');
    }

    function datatable_category($status) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "description";

//        $count1 = count($cat);


        //$respo = $this->datatables->datatable_mongodb('firstCategory', array('storeid' => $this->session->userdata('badmin')['BizId'],'status' => (int) $status), 'seqID', 1); //1->ASCE -1->DESC
        $respo = $this->datatables->datatable_mongodb('storefirstCategory', array('storeid' => $this->session->userdata('badmin')['BizId'],'status' => (int) $status), 'seqID', 1); //1->ASCE -1->DESC

        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;

        foreach ($aaData as $value) {
            $count = $this->mongo_db->where(array('categoryId' => new MongoDB\BSON\ObjectID($value['_id']['$oid']),'status'=>1))->count('storesecondCategory');
//                $count = count($cat);
            $count1 = $this->mongo_db->where(array('categoryId' => $value['_id']['$oid']))->count('metaTags');

            if($status!=2){
                $btn = '<button class="btn btnedit cls111" id="btnedit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #286090;color: white;width: 45px !important;"><i class="fa fa-edit" style="font-size:12px;"></i></button>
                <button class="btn btndelete cls111" id="btndelete"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #cd3613;color: white;width: 45px !important;"><i class="fa fa-trash" style="font-size:12px;"></i></button>';
            }else{
                $btn = ' <button class="btn btnactive cls111" id="btnactive"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #1ABB9C;color: white;width: 45px !important;"><i class="fa fa-bars" style="font-size:12px;"></i></button>';
            }

            $arr = array();
            $arr[] = $sl++;
            $arr[] = '<img src="' . $value['imageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'' . ServiceLink. '/pics/user.jpg\';"   width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            $arr[] = $value['name'][0];
          //  $arr[] = ($value['visibility'] == 0) ? 'Hidden' : 'Unhidden';
            $arr[] = $value['description'][0];
            $arr[] = '<a class="badge bg-green" href="' . base_url() . 'index.php?/SubCategory/SubCategory/' . (string) $value['_id']['$oid'] . '" style="cursor :pointer; "  > ' . $count . '</a>';
            //$arr[] = '<a class="badge bg-green" href="' . base_url() . 'index.php?/Metatags/meta_tags/' . (string) $value['_id']['$oid'] . ' ">' . $count1 . '</a>';
            $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
            $arr[] = $btn;
           
            //$arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }


      //search product
      public function getProductsBySerach() {
        $this->load->library('mongo_db');
        $sSearch = $this->input->post('serachData');
        $sRegex = quotemeta($sSearch);
        $sRegex = '^'.$sRegex;
        $sRegex = "$sRegex";
        $searchTermsAny[] = array('name' => new MongoDB\BSON\Regex($sRegex, "i"),'visibility'=>1);      
        $searchTerms = array();
        $searchTerms['$or'] = $searchTermsAny;  
      
       
        $mastersData =  $this->mongo_db->where($searchTerms)->select(array('name'=>'name'))->get('firstCategory');    
     
        echo json_encode(array('data'=>$mastersData));

    }

    function getProductDataDetail($id = '') {
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('firstCategory');
        echo json_encode(array('data' => $data));
    }
    

    function insertCategory() {
        $storeId=$this->session->userdata('badmin')['BizId']; 
        $previousCategory = $this->mongo_db->where(array('name' => $_REQUEST['name'],'storeid'=>(string)$storeId))->find_one('storefirstCategory');
      
        if ($previousCategory) {
           echo json_encode(array('msg' => 0));
        } else {
            $data = $_POST;
            // echo '<pre>';print_r($data);die;
            $data['storeid'] = $this->session->userdata('badmin')['BizId'];
            $storeName=$this->mongo_db->where(array('_id'=> new MongoDB\BSON\ObjectID($data['storeid'])))->select(array('sName'=>'sName'))->find_one('stores');
            $data['storeName']=$storeName['sName']['en'];
            $cursor = $this->mongo_db->get("storefirstCategory");
            
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

            if($data['parentCatId']!="" || $data['parentCatId']!=null){
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }

            $id = new MongoDB\BSON\ObjectID();
            $this->load->model("Seomodel");
            $xmlres = $this->Seomodel->createXmlFile((string) $id);
            // $data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $id . '.xml';
            $data['fileName'] = dirname(__DIR__)."/../../../xml/" . $id . '.xml';

            $data['_id'] = $id;

            $arr = [];
            foreach ($cursor as $catdata) {
                array_push($arr, $catdata['seqID']);
            }
            $max = max($arr);
            $seq = $max + 1;
            $data['seqID'] = $seq;
           
            $data['statusMsg'] = "New";
            $data['appId'] = "";

            // echo '<pre>';print_r($data);die;

        // chnages done for API 
        $storeFirstCategory['firstCategory'] = array('id'=>(string)$id,'imageUrl'=>$data['imageUrl'],'categoryName'=>$data['categoryName'],'categoryDesc'=> $data['categoryDesc'],'status'=> $data['status']);
        $storeFirstCategory['storeId'] =$this->session->userdata('badmin')['BizId'];
        $url = APILink. 'store/update/categorires';
        $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);
        // echo '<pre>';print_r($storeFirstCategory);
        // echo '<pre>';print_r($response);
       

        $res = $this->mongo_db->insert('storefirstCategory', $data);
        echo json_encode(array('msg' => 1));
      //  die;
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

        if (!$catdata['fileName'] || empty($catdata['fileName'])) {
            $this->load->model("Seomodel");
            $xmlres = $this->Seomodel->createXmlFile((string) $id);
            $data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $id . '.xml';
        }
        
         if ($data['fileName']) {
            $data['fileName'] = $data['fileName'];
        }

        $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($data)->update('storefirstCategory');

        // edit category 
        $storeFirstCategory['_id'] = $id;
        $storeFirstCategory['type'] =1;
        $storeFirstCategory['storeId'] =$this->session->userdata('badmin')['BizId'];
        
        
        // echo '<pre>';print_r($storeFirstCategory);die;
        $url = APILink. 'updateToStoreProduct';
        $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);
        

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

     
        $data['status']=2;
        $data['visibility']=1;
        $data['visibilityMsg']="deleted";
      

        $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->set($data)->update('storefirstCategory');
        if($result){

            $storeFirstCategory['_id'] =$val;
            $storeFirstCategory['type'] =1;
            $storeFirstCategory['storeId'] =$this->session->userdata('badmin')['BizId'];              
            $url = APILink. 'updateToStoreProduct';
            $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);

            echo json_encode($response);

        }
        
        // foreach ($val as $row) {
        //     $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('storefirstCategory');
        // }
        // $image = $data['imageUrl'];
        // foreach ($val as $row) {
        //     $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->delete('storefirstCategory');
        //     $this->mongo_db->where(array('categoryId' => $row))->delete('secondCategory');
        //     $this->mongo_db->where(array('categoryId' => $row))->delete('thirdCategory');
        // }
        // $foldername = 'first_level_category';
        // $resu = $this->utility_library->deleteImage($foldername, $image);
        // echo json_encode($result);

    }


    function activeCategory() {

        $this->load->library('utility_library');
        $val = $this->input->post('val');

     
        $data['status']=1;
        $data['visibility']=1;
        $data['visibilityMsg']="Unhidden";
        
      

        $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->set($data)->update('storefirstCategory');
        if($result){

            $storeFirstCategory['_id'] =$val;
            $storeFirstCategory['type'] =1;
            $storeFirstCategory['storeId'] =$this->session->userdata('badmin')['BizId'];              
            $url = APILink. 'updateToStoreProduct';
            $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);

            echo json_encode($response);

        }       
        
    }

    

    public function getCategoryData() {

        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('storefirstCategory');

        echo json_encode(array('data' => $cursor));
    }

    // function unhideCategory() {

    //     $val = $this->input->post('val');
    //     foreach ($val as $row) {
    //         $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('firstCategory');
    //         if ($getdata['visibility'] == 0 || $getdata['visibility'] == '') {
    //             $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 1, 'visibilityMsg' => "Unhidden"))->update('firstCategory');
    //             echo json_encode(array('msg' => 'Selected category unhided successfully', 'flag' => 1));
    //         } else if ($getdata['visibility'] == 1) {
    //             echo json_encode(array('msg' => 'Selected category is unhided already', 'flag' => 0));
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

    // function hideCategory() {

    //     $val = $this->input->post('val');
    //     foreach ($val as $row) {
    //         $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('firstCategory');
    //         if ($getdata['visibility'] == 1) {
    //             $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 0, 'visibilityMsg' => "Hidden"))->update('firstCategory');
    //             echo json_encode(array('msg' => 'Selected category hided successfully', 'flag' => 1));
    //         } else if ($getdata['visibility'] == 0) {
    //             echo json_encode(array('msg' => 'Selected category is hided already', 'flag' => 0));
    //         }
    //     }
    // }

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
// //        $resultData = $this->mongo_db->order_by(array('seqID' => 'ASC'))->get('firstCategory');
//         $resultData = $this->mongo_db->where(array('visibility' => 1))->order_by(array('seqID' => 'ASC'))->get('firstCategory');
//         $data = array();

//         foreach ($resultData as $res) {
//             $data[] = array('name' => $res['name'], 'description' => $res['description'], 'categoryId' => $res['_id']['$oid']);
//         }
// //        print_r($data); die;
//         return $data;
        $resultData = $this->mongo_db->where(array('visibility'=>1))->order_by(array('seqID' => 'ASC'))->get('firstCategory');
        $data = array();
        foreach ($resultData as $res) {
            $data[] = array('name' => $res['categoryName'], 'description' => $res['categoryDesc'], 'categoryId' => $res['_id']['$oid']);
        }
        return $data;
    }

    function getCategoryForFranchise_and_BusinessId() {

                $id=$this->session->userdata('badmin')['BizId'];
                $resultData = $this->mongo_db->where(array('visibility'=>1,'storeid' =>$id,"status" => 1, ))->order_by(array('seqID' => 'ASC'))->get('storefirstCategory');
                $data = array();
                foreach ($resultData as $res) {
                    $data[] = array('name' => $res['categoryName'], 'description' => $res['categoryDesc'], 'categoryId' => $res['_id']['$oid']);
                }
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

        $catSeqId=[$this->input->post("curr_id"),$this->input->post("prev_id")];

        foreach($catSeqId as $catId){
            $storeFirstCategory['_id'] = $catId;
            $storeFirstCategory['type'] =1;
            $storeFirstCategory['storeId'] =$this->session->userdata('badmin')['BizId'];                    
            $url = APILink. 'updateToStoreProduct';
            $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);
        }
        
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
