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
    }

    function datatable_category($status) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "description";




     
        $respo = $this->datatables->datatable_mongodb('franchisefirstCategory', array('franchiseId' => $this->session->userdata('fadmin')['MasterBizId'],'status' => (int) $status), 'seqID', 1); //1->ASCE -1->DESC

        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;

        foreach ($aaData as $value) {
            $count = $this->mongo_db->where(array('categoryId' => new MongoDB\BSON\ObjectID($value['_id']['$oid'])))->count('secondCategory');

            $count1 = $this->mongo_db->where(array('categoryId' => $value['_id']['$oid']))->count('metaTags');
            $arr = array();
            $arr[] = $sl++;
            $arr[] = '<img src="' . $value['imageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'' . base_url('../') . 'pics/user.jpg\';"   width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            $arr[] = $value['name'][0];
            $arr[] = ($value['visibility'] == 0) ? 'Hidden' : 'Unhidden';
            $arr[] = $value['description'][0];
            $arr[] = '<a class="badge bg-green" href="' . base_url() . 'index.php?/SubCategory/SubCategory/' . (string) $value['_id']['$oid'] . '" style="cursor :pointer; "  > ' . $count . '</a>';

            $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
            $arr[] = '<button class="btn btnedit cls111" id="btnedit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #606b71;color: white;width: 45px !important;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }


      //search product chnage
      public function getProductsBySerach() {
        $this->load->library('mongo_db');
        $sSearch = $this->input->post('serachData');
        $sRegex = quotemeta($sSearch);
        $sRegex = '^'.$sRegex;
        $sRegex = "$sRegex";
        $searchTermsAny[] = array('name' => new MongoDB\BSON\Regex($sRegex, "i"));      
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
        $id=$this->session->userdata('fadmin')['MasterBizId'];
        $previousCategory = $this->mongo_db->where(array('name' => $_REQUEST['name'],'franchiseId'=>$id))->find_one('franchisefirstCategory');
        
        // echo $id;
        // echo '<pre>';print_r($previousCategory);die;
        if ($previousCategory) {
            echo json_encode(array('msg' => 0));
        } else {
            $data = $_POST;

            // echo '<pre>';print_r($data);die;
          
            $data['franchiseId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $cursor = $this->mongo_db->get("franchisefirstCategory");
            
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
            $data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $id . '.xml';

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

             // chnages done for API  not needed as discussed
        // $storeFirstCategory['firstCategory'] = array('id'=>(string)$id,'imageUrl'=>$data['imageUrl'],'categoryName'=>$data['categoryName'],'categoryDesc'=> $data['categoryDesc']);
        // $storeFirstCategory['franchiseId'] =$this->session->userdata('fadmin')['MasterBizId'];
        // $url = APILink. 'store/update/categorires';
        // $response = json_decode($this->callapi->CallAPI('PATCH', $url, $storeFirstCategory), true);
       
        $res = $this->mongo_db->insert('franchisefirstCategory', $data);
        echo json_encode(array('msg' => 1));
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

        $catdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('franchisefirstCategory');

        if (!$catdata['fileName'] || empty($catdata['fileName'])) {
            $this->load->model("Seomodel");
            $xmlres = $this->Seomodel->createXmlFile((string) $id);
            $data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $id . '.xml';
        }
        
         if ($data['fileName']) {
            $data['fileName'] = $data['fileName'];
        }
//        echo '<pre>';       print_r($data);   die;
        $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($data)->update('franchisefirstCategory');
        echo json_encode($result);
    }

    function CategoryData() {
        $MAsterData = $this->mongo_db->get('firstCategory');
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
            $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('franchisefirstCategory');
        }
        $image = $data['imageUrl'];
        foreach ($val as $row) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->delete('franchisefirstCategory');
            $this->mongo_db->where(array('categoryId' => $row))->delete('franchisesecondCategory');
            $this->mongo_db->where(array('categoryId' => $row))->delete('franchisethirdCategory');
        }
        $foldername = 'first_level_category';
        $resu = $this->utility_library->deleteImage($foldername, $image);
        echo json_encode($result);
    }

    public function getCategoryData() {

        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('franchisefirstCategory');

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
        $resultData = $this->mongo_db->where(array('visibility'=>1,'status'=>1))->order_by(array('seqID' => 'ASC'))->get('franchisefirstCategory');
        $data = array();
        foreach ($resultData as $res) {
            $data[] = array('name' => $res['categoryName'], 'description' => $res['categoryDesc'], 'categoryId' => $res['_id']['$oid']);
        }
        return $data;
    }

    function getCategoryForFranchise_and_BusinessId() {

                $id=$this->session->userdata('fadmin')['MasterBizId'];
                $resultData = $this->mongo_db->where(array('visibility'=>1,'franchiseId' =>$id,"status" => 1, ))->order_by(array('seqID' => 'ASC'))->get('franchisefirstCategory');
                $data = array();
                foreach ($resultData as $res) {
                    $data[] = array('name' => $res['categoryName'], 'description' => $res['categoryDesc'], 'categoryId' => $res['_id']['$oid']);
                }
                return $data;
            }

    function changeCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->find_one('franchisefirstCategory');
        $Prevecountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->find_one('franchisefirstCategory');
        $currcount = $Curruntcountval['seqID'];
        $prevcount = $Prevecountval['seqID'];
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->set(array('seqID' => $prevcount))->update('franchisefirstCategory');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->set(array('seqID' => $currcount))->update('franchisefirstCategory');
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
