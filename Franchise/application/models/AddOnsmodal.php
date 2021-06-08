<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class AddOnsmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('Datatables1');
        $this->load->library('table');
        $this->load->library('utility_library');
        $this->load->library('CallAPI');
    }

    function datatable_addons($status) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "name.en";
        $_POST['mDataProp_1'] = "description.en";

//        $count1 = count($cat);

        switch($status){
            case 0 : 
            $respo = $this->datatables->datatable_mongodb('franchiseAddOns', array("status"=>0,'franchiseId' => $this->session->userdata('fadmin')['MasterBizId']), 'seqId', 1); //1->ASCE -1->DESC
            break; 

            case 1 : 
            $respo = $this->datatables->datatable_mongodb('franchiseAddOns', array("status"=>1,'franchiseId' => $this->session->userdata('fadmin')['MasterBizId']), 'seqId', 1); //1->ASCE -1->DESC
            break;  
            
            case 2 : 
            $respo = $this->datatables->datatable_mongodb('franchiseAddOns', array("status"=>2,'franchiseId' => $this->session->userdata('fadmin')['MasterBizId']), 'seqId', 1); //1->ASCE -1->DESC
            break; 

            case 3 : 
            $respo = $this->datatables->datatable_mongodb('franchiseAddOns', array("status"=>3,'franchiseId' => $this->session->userdata('fadmin')['MasterBizId']), 'seqId', 1); //1->ASCE -1->DESC
            break;

        }
        

        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;

        foreach ($aaData as $value) {

            $arr = array();
            $arr[] = $sl++;
         // $arr[]= '<span class="addOnDetails" style="color: blue; cursor: pointer;" val='.$value['_id']['$oid'].'>'.$value['category']['en'].'</span>';
         $arr[]=($value['name']['en'] !="" || $value['name']['en']!=null ) ? $value['name']['en']:'N/A';
         $arr[]=($value['description']['en'] !="" || $value['description']['en']!=null ) ? $value['description']['en']:'N/A';
           // $arr[] = $value['description']['en'];
         //   $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
            //$arr[] = '<button class="btn btnedit cls111" id="btnedit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #606b71;color: white;width: 45px !important;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = '<center>'.
            '<a href="'. base_url() .'index.php?/AddOns/editAddons/'.$value['_id']['$oid'].'"> <button class="btn btnedit btn-primary cls111 " id="edit" style="width:35px; border-radius: 25px;""><i class="fa fa-edit" style="font-size:12px;"></i></button></a>
            </center>';
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
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
        $searchTermsAny[] = array('name.en' => new MongoDB\BSON\Regex($sRegex, "i"));      
        $searchTerms = array();
        $searchTerms['$or'] = $searchTermsAny;  
      
        // echo '<pre>';
        // print_r(json_encode( $searchTerms ));
        // die;
        $mastersData =  $this->mongo_db->where($searchTerms)->select(array('name'=>'name'))->get('addOns');    
        
        echo json_encode(array('data'=>$mastersData));

    }

    function getProductDataDetail($id = '') {
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('addOns');
        echo json_encode(array('data' => $data));
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
        
      

    //    language
      $langres=$this->mongo_db->get_where('lang_hlp', array('Active' => 1));
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

        //echo '<pre>';print_r($Fdata);die;  
      
        $dataAddOns=[];     

        $man = '0';
        if (isset($Fdata['mandatory'])) {
            $man = '1';
        }
        $multi = '0';
        if (isset($Fdata['multiple'])) {
            $multi = '1';
        }
        $Fdata['mandatory'] =(int) $man;
        $Fdata['multiple'] = (int)$multi;
        
       
        $i = 0;

       

        // new code
        foreach($Fdata['addOns'] as $AddOns){           
            $languageArray = [];
            if(count($langres)>=1){
                if(count($AddOns['name'])==1){
                    $languageArray['en'] =  $AddOns['name'][0]; 
                }else{
                    $languageArray = array_combine($lanCodeArr, $AddOns['name']);
                }               
            }else{
                $languageArray['en'] =  $AddOns['name'][0]; 
            }

            if (array_key_exists("id",$AddOns))
                {
                   $id=$AddOns['id'];
                }else{
                    $id=(string)new MongoDB\BSON\ObjectID();
                }         
            $addname=(object)$AddOns['name']; 
            $languageArray = (object)$languageArray;        
            $dataAddOn = (object) array("id"=>$id,"name"=> $languageArray,"price"=>$AddOns['price']);          
            array_push($dataAddOns, $dataAddOn);
        }

        
        $Fdata['addOns']=$dataAddOns;      
        $arr = [];
        $dataforseq = $this->mongo_db->get('franchiseAddOns');
        foreach ($dataforseq as $datas){
            array_push($arr, $datas['seqId']); 
        }
        $Fdata['seqId'] = max($arr) + 1;
        $Fdata['status'] = 0;

        $Fdata['minimumLimit']=(int)$Fdata['minimumLimit'];
        $Fdata['maximumLimit']=(int)$Fdata['maximumLimit'];

               
      if ($AddOnId != '') {
            $res=$this->mongo_db->update('franchiseAddOns', $Fdata, array("_id" => new MongoId($AddOnId)));
            //print_r($res);die;
            return true;
        } else {
            $this->mongo_db->insert('franchiseAddOns', $Fdata);
            return true;
            
        }
    }

    
    function editAddOnData(){
        $this->load->library('mongo_db');
        $AddOnId = $this->input->post("addOnId");
        $Fdata = $this->input->post("FData");
   

     //    language
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
        $dataAddOns=[];

        $man = '0';
        if (isset($Fdata['mandatory'])) {
            $man = '1';
        }
        $multi = '0';
        if (isset($Fdata['multiple'])) {
            $multi = '1';
        }
        $Fdata['mandatory'] =(int) $man;
        $Fdata['multiple'] = (int)$multi;
        $i = 0;
        
        // to be removed
        if (!$Fdata['addOnLimit']) {
            $Fdata['addOnLimit'] = '0';
        }

       
        

        // new code
        foreach($Fdata['addOns'] as $AddOns){           
            $languageArray = [];
            if(count($langres)>=1){
                if(count($AddOns['name'])==1){
                    $languageArray['en'] =  $AddOns['name'][0]; 
                }else{
                    $languageArray = array_combine($lanCodeArr, $AddOns['name']);
                }               
            }else{
                $languageArray['en'] =  $AddOns['name'][0]; 
            }

            if (array_key_exists("id",$AddOns))
                {
                   $id=$AddOns['id'];
                }else{
                    $id=(string)new MongoDB\BSON\ObjectID();
                }         
            $addname=(object)$AddOns['name']; 
            $languageArray = (object)$languageArray;        
            $dataAddOn = (object) array("id"=>$id,"name"=> $languageArray,"price"=>$AddOns['price']);          
            array_push($dataAddOns, $dataAddOn);
        }

        $Fdata['addOns']=$dataAddOns;
        $Fdata['minimumLimit']=(int)$Fdata['minimumLimit'];
        $Fdata['maximumLimit']=(int)$Fdata['maximumLimit'];
        
        echo '<pre>';print_r($Fdata);die;
        $data= json_encode($Fdata);     
        $url = APILink . 'addOn';         
        $response = json_decode($this->callapi->CallAPI('PATCH', $url, $data), true);    
        return true;

        
       

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
            // $res = $this->mongo_db->get('lang_hlp');
            $res=$this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        } else {
            // $where = array('$and' => array(array('lan_id' => (int) $param), array('Active' => 1)));
            // $res = $this->mongo_db->get_where('lang_hlp', $where);
            $res=$this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        }
       //echo '<pre>';print_r($res);die;
        return $res;
    }

    //function to get all details

    function getAddOnDetail($addOnId){
        //print_r($addOnId);die;
       $data=$this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($addOnId)))->find_one('franchiseAddOns');
      
       echo json_encode($data);

    }

    //update the status
	function update_addOnDetails($addOnIds, $status){
				
        $mongoArr = array('status' =>(int)$status);
        foreach($addOnIds as $addOnId)
        {      
            $res=$this->mongo_db->where(array('_id'=> new MongoDB\BSON\ObjectID($addOnId)))->set($mongoArr)->update('franchiseAddOns');         
        }

        echo json_encode('status updated');
}


function permanentDelete() {
      
            $id = $this->input->post('val');
            $storeId=$this->session->userdata('fadmin')['MasterBizId'];
           

        foreach ($id as $dataId) {

            $data['addOnId']=$dataId;
            $data['storeId']=$storeId;
            $Fdata= json_encode($data);


            $headers = array(
                'Content-Type: application/json'
            );
          
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, APILink . 'addOn');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $Fdata);

            $result = curl_exec($ch);             
            curl_close($ch);
           
        }

      
          
            echo json_encode($result);
    }

}

?>
