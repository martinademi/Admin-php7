<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class StoreAddonsModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
       
        $this->load->library('table');
        $this->load->library('utility_library');
    }

    function datatable_addons($status) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "description";

//        $count1 = count($cat);
        switch($status){
            case 0 : 
            $respo = $this->datatables->datatable_mongodb('storeAddOns', array("status"=>0),'seqId', 1); //1->ASCE -1->DESC
            break; 

            case 1 : 
            $respo = $this->datatables->datatable_mongodb('storeAddOns', array("status"=>1), 'seqId', 1); //1->ASCE -1->DESC
            break;  
            
            case 2 : 
            $respo = $this->datatables->datatable_mongodb('storeAddOns', array("status"=>2),'seqId', 1); //1->ASCE -1->DESC
            break; 

            case 3 : 
            $respo = $this->datatables->datatable_mongodb('storeAddOns', array("status"=>3), 'seqId', 1); //1->ASCE -1->DESC
            break;

        }
        

        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;

        foreach ($aaData as $value) {
        //    echo '<pre>';print_r($value);die;
            $storeID=$value['storeId'];
            $storeName=$this->mongo_db->where(array('_id'=> new MongoDB\BSON\ObjectID($storeID)))->find_one('stores');           
            $sName=$storeName['sName']['en'];         
            $arr = array();
            $arr[] = $sl++;      
            $arr[]=($value['name']['en'] !="" || $value['name']['en'] !=null) ? $value['name']['en']:'N/A';
            $arr[] = ($value['description']['en']!='' ||  $value['description']['en']!=NULL) ? $value['description']['en'] : 'N/A';         
            $arr[]= $sName;
            $arr[]='<a class="addOnDetailmodal" id="'.$value['_id']['$oid'] .'" style="cursor:pointer;color:blue">'.View.'</a>';
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
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

        $catdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('firstCategory');

        if (!$catdata['fileName'] || empty($catdata['fileName'])) {
            $this->load->model("Seomodel");
            $xmlres = $this->Seomodel->createXmlFile((string) $id);
            $data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $id . '.xml';
        }
        
         if ($data['fileName']) {
            $data['fileName'] = $data['fileName'];
        }
//        echo '<pre>';       print_r($data);   die;
        $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($data)->update('firstCategory');
        echo json_encode($result);
    }

    function getAddOnGroup() {
        $addOnData = $this->mongo_db->get('addOns');
        $data = array();

        foreach ($addOnData as $d) {
            $data[] = array('name' => $d['name'], 'description' => $d['description'], 'groupId' => $d['_id']['$oid']);
        }
        return $data;
    }
    
    function AddnewAddOnData(){
        $this->load->library('mongo_db');
        $AddOnId = $this->input->post("AddOnId");
        $Fdata = $this->input->post("FData");
     
        $man = '0';
        if (isset($Fdata['mandatory'])) {
            $man = '1';
        }
        $multi = '0';
        if (isset($Fdata['multiple'])) {
            $multi = '1';
        }
        $Fdata['mandatory'] = $man;
        $Fdata['multiple'] = $multi;
        
          if (!$Fdata['quantityLimit']) {
            $Fdata['quantityLimit'] = '0';
        }
        $i = 0;
        foreach($Fdata['addOns'] as $AddOns){
           
            // $addOnsdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($AddOns['titleId'])))->find_one('addOns');
            $Fdata['addOns'][$i]['name'] = $AddOns['name'];
        //   $i++;  
        }
        $arr = [];
        $dataforseq = $this->mongo_db->get('storeAddOns');
        foreach ($dataforseq as $datas){
            array_push($arr, $datas['seqId']); 
        }
        $Fdata['seqId'] = max($arr) + 1;
        $Fdata['status'] = 0;

        //  echo '<pre>'; print_r($Fdata); die;

        if ($AddOnId != '') {
            $this->mongo_db->update('storeAddOns', $Fdata, array("_id" => new MongoId($AddOnId)));
            return true;
        } else {
            $this->mongo_db->insert('storeAddOns', $Fdata);
            return true;
            
        }
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
        
        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('storeAddOns');
       
        echo json_encode(array('data' => $cursor));
    }

    function unhideCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('firstCategory');
            if ($getdata['visibility'] == 0 || $getdata['visibility'] == '') {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 1, 'visibilityMsg' => "Unhidden"))->update('firstCategory');
                echo json_encode(array('msg' => 'Selected category unhided successfully', 'flag' => 1));
            } else if ($getdata['visibility'] == 1) {
                echo json_encode(array('msg' => 'Selected category is unhided already', 'flag' => 0));
            }
        }
    }

    function hideCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('firstCategory');
            if ($getdata['visibility'] == 1) {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 0, 'visibilityMsg' => "Hidden"))->update('firstCategory');
                echo json_encode(array('msg' => 'Selected category hided successfully', 'flag' => 1));
            } else if ($getdata['visibility'] == 0) {
                echo json_encode(array('msg' => 'Selected category is hided already', 'flag' => 0));
            }
        }
    }

    function getCategoryForFranchise_and_Business() {
//        $resultData = $this->mongo_db->order_by(array('seqID' => 'ASC'))->get('firstCategory');
        $resultData = $this->mongo_db->where(array('visibility' => 1))->order_by(array('seqID' => 'ASC'))->get('firstCategory');
        $data = array();

        foreach ($resultData as $res) {
            $data[] = array('name' => $res['name'], 'description' => $res['description'], 'categoryId' => $res['_id']['$oid']);
        }
//        print_r($data); die;
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
            $res = $this->mongo_db->get('lang_hlp');
        } else {
            $where = array('$and' => array(array('lan_id' => (int) $param), array('Active' => 1)));
            $res = $this->mongo_db->get_where('lang_hlp', $where);
        }
        return $res;
    }

    //function to get all details

    function getAddOnDetail($addOnId){
        //print_r($addOnId);die;
       $data=$this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($addOnId)))->find_one('storeAddOns');
      
       echo json_encode($data);

    }

    //update the status
	function update_addOnDetails($addOnIds, $status){

				
        $mongoArr = array('status' =>(int)$status);

        foreach($addOnIds as $addOnId)
        {
      
            $res=$this->mongo_db->where(array('_id'=> new MongoDB\BSON\ObjectID($addOnId)))->set($mongoArr)->update('storeAddOns');
         
        }

        echo json_encode('status updated');
}

function addOnsList($id = '') {

    $this->load->library('Datatables');
    $this->load->library('table');
    $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('storeAddOns');
    $currencySymbol=$this->mongo_db->where(array('_id'=>new MongoDB\BSON\ObjectID($result['storeId'])))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
    $currency=$currencySymbol['currencySymbol'];
    $data = $result['addOns'];

    echo json_encode(array('data' => $data,'currencySymbol'=>$currency));
}

}

?>
