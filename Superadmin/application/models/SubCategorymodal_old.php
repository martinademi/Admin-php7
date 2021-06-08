
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

    function datatable_subcategory($status) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $data1['id'] = $status;
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "description";

        $respo = $this->datatables->datatable_mongodb('secondCategory', array('categoryId' => new MongoDB\BSON\ObjectID($status)), 'seqId', 1); //1->ASCE -1->DESC

        $aaData = $respo["aaData"];
        $datatosend = array();
         $sl = $_POST['iDisplayStart']+1;

        foreach ($aaData as $value) {
            $count = $this->mongo_db->where(array('subCategoryId' =>new MongoDB\BSON\ObjectID( $value['_id']['$oid'])))->count('thirdCategory');
            $count1 = $this->mongo_db->where(array('categoryId' => $value['_id']['$oid']))->count('metaTags');
            $arr = array();
            $arr[] = $sl++;
            $arr[] = '<img src="' . $value['imageUrl'] . '" onerror="if (this.src != \'error.jpg\') this.src = \'' . base_url('../') . '/pics/user.jpg\';"   width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            $arr[] = implode(",",$value['name']);
            $arr[] = ($value['visibility'] == 1) ? 'Unhidden' : 'Hidden';
            $arr[] = implode(",",$value['description']);
            $arr[] = '<a class="badge bg-green"  href="' . base_url() . 'index.php?/SubsubCategory/subSubCategory/' . (string) $value['_id']['$oid'] . '/' . $data1['id'] . '" style="cursor :pointer; "  > ' . $count . '</a>';
            $arr[] = '<a class="badge bg-green"  href="' . base_url() . 'index.php?/Metatags/meta_tags/'.$data1['id'] .'/'.(string) $value['_id']['$oid'].' ">' . $count1 . '</a>';
            $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
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
            $data[] = array('id'=>$driver['_id']['$oid'],'name' => $driver['name'], 'description' => $driver['description'], 'categoryId' => $driver['categoryId']);
        }
        return $data;
    }

    function getSubCategoryData($id = '') {
        
      
        
if($id!= ''|| $id != null){
    $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($id)))->get('secondCategory');
    echo json_encode(array('data'=>$cursor));
}else{
    $val = $this->input->post('val');
    $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($val)))->get('secondCategory');
        $entities=array();
        $entities='<select class="form-control error-box-class"  id="subCategory" name="subCategory">
                     <option value="">Select Sub-Category</option>';
        foreach ($cursor as $d) {

            $entities.='<option data-name="'.implode($d['name'], ',').'" value="'.$d['_id']['$oid'].'">'.implode($d['name'], ',').'</option>';
        }
        $entities.='</select>';
//        print_r($entities);die;
        echo $entities;
}
        
    }

    public function getbusiness_catdataTwo() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('secondCategory');
        }
        return $cursor;
    }

    function insertSubCategory() {
        print_r($_POST);
         $previousCategory = $this->mongo_db->where(array('categoryId' => new MongoDB\BSON\ObjectID($_REQUEST['cateid']),'name' =>$_REQUEST['catname']['en']))->find_one('secondCategory');
         
         print_r($previousCategory);die;
         if($previousCategory){
              echo json_encode(array('msg' => 0));
         }else{
        
        $cateid = $_REQUEST['cateid'];
        $Name = $_REQUEST['catname'];
        $cat_photosaa = $_REQUEST['cat_photosaa'];
        $Description = $_REQUEST['catDescription'];

        $catPhoto = $_REQUEST['cat_photosamz'];
        $cursor = $this->mongo_db->get('secondCategory');
        $arr = [];
        foreach ($cursor as $catdata) {
            array_push($arr, $catdata['seqId']);
        }
        $max = max($arr);
        $seq = $max + 1;
        $insertIntoChatArr = array('seqId' => $seq, 'name' => $Name, 'categoryId' => new MongoDB\BSON\ObjectID($cateid), 'description' => array($Description), 'imageUrl' => $catPhoto, 'visibility' => 1);
        $res = $this->mongo_db->insert('secondCategory', $insertIntoChatArr);
         echo json_encode(array('msg' => 1));
         }
    }

    function editSubCategory() {

        $Name = $_REQUEST['catname'];
        $Description = $_REQUEST['catDescription'];
        $id = $_REQUEST['editId'];
        $catPhoto = $_REQUEST['cat_photosamz'];

        if ($catPhoto != null && $catPhoto != ""){
            $insertIntoChatArr = array('name' => $Name, 'description' =>array( $Description), 'imageUrl' => $catPhoto);
			 echo json_encode(array("msg" => '1'));
		} else{
            $insertIntoChatArr = array('name' => $Name, 'description' => array($Description));
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($insertIntoChatArr)->update('secondCategory');
		 echo json_encode(array("msg" => '1'));
		}
		 
    }

    function deleteSubCategory() {
        $this->load->library('utility_library');
        $val = $this->input->post('val');

        foreach ($val as $row) {
            $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('secondCategory');
        }
        $image = $data['imageUrl'];
        foreach ($val as $row) {
            $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->delete('secondCategory');
        }

        $foldername = 'second_level_category';
        $resu = $this->utility_library->deleteImage($foldername, $image);
        echo json_encode($resu);
    }

  
    
     function unhideSubCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('secondCategory');
            if ($getdata['visibility'] == 0 || $getdata['visibility'] == '') {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 1))->update('secondCategory');
                echo json_encode(array('msg' => 'Selected category unhided successfully', 'flag' => 1));
            } else if ($getdata['visibility'] == 1) {
                echo json_encode(array('msg' => 'Selected category is unhided already', 'flag' => 0));
            }
        }
    }

    function hideSubCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('secondCategory');
            if($getdata['visibility'] == 1) {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 0))->update('secondCategory');
                echo json_encode(array('msg' => 'Selected category hided successfully', 'flag' => 1));
            } else if ($getdata['visibility'] == 0) {
                echo json_encode(array('msg' => 'Selected category is hided already', 'flag' => 0));
            }
        }
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

}

?>
