<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class StoreCategoryModel extends CI_Model {

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
//        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 6;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "description";
        $_POST['mDataProp_2'] = "typeMsg";
        $respo = $this->datatables->datatable_mongodb('storeCategory', array('visibility' => (int)$status), 'seqId', -1); //1->ASCE -1->DESC
        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;
        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        foreach ($aaData as $value) {
            if(count($respo['lang'])<1){           

                $productname=($value['storeCategoryName']['en'] != "" || $value['storeCategoryName']['en'] != null) ? $value['storeCategoryName']['en']: 'N/A';    
                $storeCatDesc=($value['storeCategoryDescription']['en'] != "" || $value['storeCategoryDescription']['en'] != null) ? $value['storeCategoryDescription']['en']: 'N/A'; 
                
               }else{                
                $productname=($value['storeCategoryName']['en'] != "" || $value['storeCategoryName']['en'] != null) ? $value['storeCategoryName']['en']: 'N/A';    
                $storeCatDesc=($value['storeCategoryDescription']['en'] != "" || $value['storeCategoryDescription']['en'] != null) ? $value['storeCategoryDescription']['en']: 'N/A';  
                
                foreach( $respo['lang'] as $lang){    
                    $lan= $lang['langCode'];
                    $productnames=($value['storeCategoryName'][$lan] != "" || $value['storeCategoryName'][$lan] != null) ? $value['storeCategoryName'][$lan]: '';
                    $storeCatDescs=($value['storeCategoryDescription'][$lan] != "" || $value['storeCategoryDescription'][$lan] != null) ? $value['storeCategoryDescription'][$lan]: '';   
                   
                    
                   if(strlen( $productnames)>0){
                    $productname.= ',' . $productnames;
                  }
                   if(strlen( $storeCatDescs)>0){
                    $storeCatDesc.= ',' . $storeCatDescs;
                  }
                }
             }

            if ($value['logoImage']) {
                $imageField = '<img src="' . $value['logoImage'] . '"  width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            } else {
                $imageField = '<img src="' . base_url('') . 'pics/user.jpg\';"   width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            }  
            $count = $this->mongo_db->where(array('categoryId' => $value['_id']['$oid']))->count('storeSubCategory');
//            $count = count($cat);
           
            $arr = array();
            $arr[] = $sl++; 
            $arr[] = $productname;  
            $arr[] = $imageField;
            $arr[] = $storeCatDesc;
            $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
            $arr[] = $value['typeMsg'];
            $arr[] = '<a class="badge bg-green" href="' . base_url() . 'index.php?/StoreCategoryController/SubCategory/' . (string) $value['_id']['$oid'] . '" style="cursor :pointer; "  > ' . $count . '</a>';
            $arr[] = '<a href="' . base_url() . 'index.php?/StoreCategoryController/attributes/'.$value['storeCategoryName']['en'].'/' . (string) $value['_id']['$oid'] . '" style="cursor :pointer;color:blue; "  > view </a>';
            $arr[] = '<button class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }




    function datatable_attributes($status,$status1,$status2) {
        //        $this->load->library('mongo_db');
                $this->load->library('Datatables');
                $this->load->library('table');
                $_POST['iColumns'] = 6;
                $_POST['mDataProp_0'] = "name";
                $respo = $this->datatables->datatable_mongodb('storeCategoryAttributes', array('storeCategoryId'=>$status2,'status' => (int)$status), 'seqId', -1); //1->ASCE -1->DESC
        
                $aaData = $respo["aaData"];
                $datatosend = array();
                $sl = $_POST['iDisplayStart'] + 1;
                $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        
        
                foreach ($aaData as $value) {  
        
        
                    if(count($respo['lang'])<1){           
        
                        $productname=($value['name']['en'] != "" || $value['name']['en'] != null) ? $value['name']['en']: 'N/A';  
                        $productnames2=($value['name']['en'] != "" || $value['name']['en'] != null) ? $value['name']['en']: 'N/A';      
                     
                       }else{                
                        $productname=($value['name']['en'] != "" || $value['name']['en'] != null) ? $value['name']['en']: 'N/A';  
                        $productnames2=($value['name']['en'] != "" || $value['name']['en'] != null) ? $value['name']['en']: 'N/A';      
                        foreach( $respo['lang'] as $lang){    
                            $lan= $lang['langCode'];
                            $productnames=($value['name'][$lan] != "" || $value['name'][$lan] != null) ? $value['name'][$lan]: '';
                           if(strlen( $productnames)>0){
                            $productname.= ',' . $productnames;
                            $productnames2.= '-' . $productnames;
                          }    
                             
                        }
                     }
        
                     
                    $count = $this->mongo_db->where(array('categoryId' => $value['_id']['$oid']))->count('storeSubCategory');
                    $arr = array();
                    $arr[] = $sl++;
                    $arr[] = $productname;
                    $arr[] = '<a class="badge bg-green" href="' . base_url() . 'index.php?/StoreCategoryController/attributeList/' . (string) $value['_id']['$oid'] . '/'.$status1.'/'.$status2.'/'.$productnames2.'" style="cursor :pointer; "  > ' . count($value['attributes']) . '</a>';
                    $arr[] = '<button class="btn editAttributes btn-primary cls111" id="editAttributes"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
                    $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
                    $datatosend[] = $arr;
                }
                $respo["aaData"] = $datatosend;
                echo json_encode($respo);
            }


            function datatable_attributesList($status,$id) {
                //        $this->load->library('mongo_db');
                        $this->load->library('Datatables');
                        $this->load->library('table');
                        $_POST['iColumns'] = 6;
                        $_POST['mDataProp_0'] = "name";
                        $respo = $this->datatables->datatable_mongodb('storeCategoryAttributes', array('_id'=> new MongoDB\BSON\ObjectID($id),'status' => (int)$status), 'seqId', -1); //1->ASCE -1->DESC
                
                        $aaData = $respo["aaData"];
                        $datatosend = array();
                        $sl = $_POST['iDisplayStart'] + 1;
                        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
                
                
                        foreach ($aaData as $value1) {  
                           foreach($value1['attributes'] as $value){
                
                            if(count($respo['lang'])<1){           
                
                                $productname=($value['name']['en'] != "" || $value['name']['en'] != null) ? $value['name']['en']: 'N/A';    
                             
                               }else{                
                                $productname=($value['name']['en'] != "" || $value['name']['en'] != null) ? $value['name']['en']: 'N/A';    
                                foreach( $respo['lang'] as $lang){    
                                    $lan= $lang['langCode'];
                                    $productnames=($value['name'][$lan] != "" || $value['name'][$lan] != null) ? $value['name'][$lan]: '';
                                   if(strlen( $productnames)>0){
                                    $productname.= ',' . $productnames;
                                  }
                                  
                                }
                             }
                
                             
                            
                            $arr = array();
                            $arr[] = $sl++;
                            $arr[] = $productname;
                            $datatosend[] = $arr;
                            }
                        }
                        $respo["aaData"] = $datatosend;
                        echo json_encode($respo);
                    }

            


            function editAttributeData($id='') {
                $data = $_POST;
               
               $dataAttrib=[];  
                  try {    
          
                      foreach($data['attributes'] as $addOn){ 
                          $idAddOn=new MongoDB\BSON\ObjectID($addOn['id']);
                          $dataAddOn = (object) array("id"=>$idAddOn,"name"=> $addOn['name']);          
                          array_push($dataAttrib, $dataAddOn);
                      }
                $data['attributes']=$dataAttrib;  
                $dat = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('storeCategoryAttributes');
                } catch (Exception $ex) {
                      print_r($ex);
                  }
                  return json_encode($dat);
            }

            function getAtrributesData($Id = '',$param ='') {
                $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->find_one('storeCategoryAttributes');
               
                if($param ==1){
                    echo json_encode(array('result' => $data['attributes']));
                }else{
                    return $data;
                }
                
            }

    public function activateAttribute(){
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1, 'statusMsg' => "Active"))->update('storeCategoryAttributes');
        }

        echo json_encode(array("msg" => "Selected Attribute has been activated successfully", "flag" => 0));
    }

    public function deleteAttribute(){
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 3, 'statusMsg' => "Deleted"))->update('storeCategoryAttributes');
        }

        echo json_encode(array("msg" => "Selected Attribute has been deleted successfully", "flag" => 0));
    }

    public function deactivateAttribute(){
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 2, 'statusMsg' => "Inactive"))->update('storeCategoryAttributes');
        }

        echo json_encode(array("msg" => "Selected Attribute has been deactivated successfully", "flag" => 0));
        
    }


    function insertCategory() {
        $previousCategory = $this->mongo_db->where(array('name' => $_REQUEST['name']))->find_one('storeCategory');

        if ($previousCategory) {
            echo json_encode(array('msg' => 0));
        } else {
            $data = $_POST;
            $citiesList = explode(",",$data['availableInCities']);

            $data['visibleInApp'] = (bool)$data['visibleInApp'];
            $data['visibleInWeb'] = (bool)$data['visibleInWeb'];

            $data['availableInCities']= $citiesList;
           
            $cursor = $this->mongo_db->get("storeCategory");

            $id = new MongoDB\BSON\ObjectID();
            //$this->load->model("Seomodel");
            //$xmlres = $this->Seomodel->createXmlFile((string) $id);
            //$fileName = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $id . '.xml';
            //$data['fileName'] = $fileName;

            $arr = [];
            foreach ($cursor as $catdata) {
                array_push($arr, $catdata['seqId']);
            }

            $max = max($arr);
            $seq = $max + 1;

            $data['seqId'] = (int) $seq;

            $lang = $this->mongo_db->get('lang_hlp');
            $lanCodeArr = [];
            $lanIdArr = [];
            foreach ($lang as $lan) {
                $lanCodeArr[0] = "en";
                $lanIdArr[0] = "0";
                array_push($lanCodeArr, $lan['langCode']);
                array_push($lanIdArr, $lan['lan_id']);
            }

            if (count($lanCodeArr) == count($data['name'])) {
                $data['storeCategoryName'] = array_combine($lanCodeArr, $data['name']);
            } else if (count($lanCodeArr) < count($data['name'])) {
                $data['storeCategoryName']['en'] = $data['name'][0];

                foreach ($data['name'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['storeCategoryName'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['storeCategoryName'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['storeCategoryName']['en'] = $data['name'][0];
            }

            if (count($lanCodeArr) == count($data['description'])) {
                $data['storeCategoryDescription'] = array_combine($lanCodeArr, $data['description']);
            } else if (count($lanCodeArr) < count($data['description'])) {
                $data['storeCategoryDescription']['en'] = $data['description'][0];

                foreach ($data['description'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['storeCategoryDescription'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['storeCategoryDescription'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['storeCategoryDescription']['en'] = $data['description'][0];
            }
            $data['_id'] = $id;
            $data['type'] = (int) $data['type'];
            $data['typeMsg'] = $data['typeName'];
            $data['deliverTo'] = (int) $data['deliverTo'];
            $data['deliverToMsg'] = $data['deliverToMsg'];
            
            $data['visibility'] = (int) $data['visibility'];
            if ($data['visibility'] == 1) {
                $data['visibilityMsg'] = "Unhidden";
            } else {
                $data['visibilityMsg'] = "Hidden";
            }

            if($data['cartsAllowed']==1){
                $data['cartsAllowed']=1;
                $data['cartsAllowedMsg']="Singlecartsinglestore";
            }else  if($data['cartsAllowed']==2) {
                $data['cartsAllowed']=2;
                $data['cartsAllowedMsg']="SinglecartMultiplestore";
            }else{
                $data['cartsAllowed']=3;
                $data['cartsAllowedMsg']="SinglecartMultipleStoreCategory";
            }
            
        //    echo '<pre>';print_r($data);die;
            $res = $this->mongo_db->insert('storeCategory', $data);
            echo json_encode(array('msg' => 1));
        }
    }

    function CategoryData() {
        $MAsterData = $this->mongo_db->get('storeCategory');
        $data = array();

        foreach ($MAsterData as $driver) {
            $data[] = array('name' => $driver['name'], 'description' => $driver['description'], 'categoryId' => $driver['_id']['$oid']);
        }
        return $data;  
    }

    function getStoreCategoryData() {
        $MAsterData = $this->mongo_db->where(array("visibility" => 1))->get('storeCategory');
        return $MAsterData;
    }


    function editCategory() {
        $data = $_POST;
        $citiesList = explode(",",$data['availableInCities']);
            
        $data['availableInCities']= $citiesList;
        
        $data['visibleInApp'] = (bool)$data['editvisibleInApp'];
        $data['visibleInWeb'] = (bool)$data['editvisibleInWeb'];

        $lang = $this->mongo_db->get('lang_hlp');
            $lanCodeArr = [];
            $lanIdArr = [];
            foreach ($lang as $lan) {
                $lanCodeArr[0] = "en";
                $lanIdArr[0] = "0";
                array_push($lanCodeArr, $lan['langCode']);
                array_push($lanIdArr, $lan['lan_id']);
            }

            if (count($lanCodeArr) == count($data['name'])) {
                $data['storeCategoryName'] = array_combine($lanCodeArr, $data['name']);
            } else if (count($lanCodeArr) < count($data['name'])) {
                $data['storeCategoryName']['en'] = $data['name'][0];

                foreach ($data['name'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['storeCategoryName'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['storeCategoryName'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['storeCategoryName']['en'] = $data['name'][0];
            }

            if (count($lanCodeArr) == count($data['description'])) {
                $data['storeCategoryDescription'] = array_combine($lanCodeArr, $data['description']);
            } else if (count($lanCodeArr) < count($data['description'])) {
                $data['storeCategoryDescription']['en'] = $data['description'][0];

                foreach ($data['description'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['storeCategoryDescription'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['storeCategoryDescription'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['storeCategoryDescription']['en'] = $data['description'][0];
            }
        
        $id = $data['editId'];
        $data['type'] = (int) $data['type'];
        $data['typeMsg'] = $data['typeName'];
        $data['deliverTo'] = (int) $data['deliverTo'];
        $data['deliverToMsg'] = $data['deliverToMsg'];
        unset($data['editId']);
//        echo '<pre>'; print_r($data); die;
        $catdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('storeCategory');

        if (!$catdata['fileName'] || empty($catdata['fileName'])) {
            // $this->load->model("Seomodel");
            // $xmlres = $this->Seomodel->createXmlFile((string) $id);
            // $fileName = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $id . '.xml';
        }

        if ($fileName) {
            $data['fileName'] = $fileName;
        }

        // if($data['cartsAllowed']==0){
        //     $data['cartsAllowed']=false;
        //     $data['cartsAllowedMsg']="single";
        // }else{
        //     $data['cartsAllowed']=true;
        //     $data['cartsAllowedMsg']="multiple";
        // }

        
        if($data['cartsAllowed']==1){
            $data['cartsAllowed']=1;
            $data['cartsAllowedMsg']="Singlecartsinglestore";
        }else  if($data['cartsAllowed']==2) {
            $data['cartsAllowed']=2;
            $data['cartsAllowedMsg']="SinglecartMultiplestore";
        }else{
            $data['cartsAllowed']=3;
            $data['cartsAllowedMsg']="SinglecartMultipleStoreCategory";
        }



        // echo '<pre>';print_r($data);die;
        $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($data)->update('storeCategory');
       
        //cool
        $dataApi['_id']=$id;
        $dataApi['type']="1";
        
      
        if($result){
            
            $url = APILink . 'updateToStore';      
            // $url = 'https://apiDev.deliv-x.com/updateToStore';      
            $response = json_decode($this->callapi->CallAPI('PATCH', $url, $dataApi), true);
          

        }
        
        echo json_encode($result);
    }

    function deleteCategory() {
        $this->load->library('utility_library');
        $val = $this->input->post('val');

        foreach ($val as $row) {
            $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('storeCategory');
        }
        $image = $data['imageUrl'];

        foreach ($val as $row) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->delete('storeCategory');
            $this->mongo_db->where(array('categoryId' => $row))->delete('secondCategory');
            $this->mongo_db->where(array('categoryId' => $row))->delete('thirdCategory');
        }
        $foldername = 'first_level_category';
        $resu = $this->utility_library->deleteImage($foldername, $image);
        echo json_encode($result);
    }

    public function getCategoryData() {
        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('storeCategory');
        echo json_encode(array('data' => $cursor));
    }

    function unhideCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('storeCategory');
            if ($getdata['visibility'] == 0 || $getdata['visibility'] == '') {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 1))->update('storeCategory');
                echo json_encode(array('msg' => 'Selected category unhided successfully', 'flag' => 1));
            } else if ($getdata['visibility'] == 1) {
                echo json_encode(array('msg' => 'Selected category is unhided already', 'flag' => 0));
            }
        }
    }

    function hideCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('storeCategory');
            if ($getdata['visibility'] == 1) {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 0))->update('storeCategory');
                echo json_encode(array('msg' => 'Selected category hided successfully', 'flag' => 1));
            } else if ($getdata['visibility'] == 0) {
                echo json_encode(array('msg' => 'Selected category is hided already', 'flag' => 0));
            }
        }
    }

    function getCategoryForFranchise_and_Business() {
        $resultData = $this->mongo_db->order_by(array('seqID' => 'ASC'))->get('storeCategory');
        $data = array();

        foreach ($resultData as $res) {
            $data[] = array('name' => $res['name'], 'description' => $res['description'], 'categoryId' => $res['_id']['$oid']);
        }
//        print_r($data); die;
        return $data;
    }

    function changeCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->find_one('storeCategory');
        $Prevecountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->find_one('storeCategory');
        $currcount = $Curruntcountval['seqId'];
        $prevcount = $Prevecountval['seqId'];
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->set(array('seqId' => $prevcount))->update('storeCategory');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->set(array('seqId' => $currcount))->update('storeCategory');
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
    
    function datatable_Subcategory($status1,$status2) {
//        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "description";

//        $count1 = count($cat);
      
        $respo = $this->datatables->datatable_mongodb('storeSubCategory', array('categoryId' => $status1,'visibility' => (int)$status2), 'seqId', -1); //1->ASCE -1->DESC

        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;
        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));

        foreach ($aaData as $value) {
        
            if ($value['logoImage']) {
                $imageField = '<img src="' . $value['logoImage'] . '"  width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            } else {
                $imageField = '<img src="' . base_url('') . 'pics/user.jpg\';"   width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            }
        // $productName=($value['storeSubCategoryName']['en']!='' || $value['storeSubCategoryName']['en']!=null ) ? $value['storeSubCategoryName']['en']: 'N/A'; 




        if(count($respo['lang'])<1){           

            $productname=($value['storeSubCategoryName']['en'] != "" || $value['storeSubCategoryName']['en'] != null) ? $value['storeSubCategoryName']['en']: 'N/A';    
            $storeCatDesc=($value['storeSubCategoryDescription']['en'] != "" || $value['storeSubCategoryDescription']['en'] != null) ? $value['storeSubCategoryDescription']['en']: 'N/A'; 
            
           }else{                
            $productname=($value['storeSubCategoryName']['en'] != "" || $value['storeSubCategoryName']['en'] != null) ? $value['storeSubCategoryName']['en']: 'N/A';    
            $storeCatDesc=($value['storeSubCategoryDescription']['en'] != "" || $value['storeSubCategoryDescription']['en'] != null) ? $value['storeSubCategoryDescription']['en']: 'N/A';  
            
            foreach( $respo['lang'] as $lang){    
                $lan= $lang['langCode'];
                $productnames=($value['storeSubCategoryName'][$lan] != "" || $value['storeSubCategoryName'][$lan] != null) ? $value['storeSubCategoryName'][$lan]: '';
                $storeCatDescs=($value['storeSubCategoryDescription'][$lan] != "" || $value['storeSubCategoryDescription'][$lan] != null) ? $value['storeSubCategoryDescription'][$lan]: '';   
               if(strlen( $productnames)>0){
                $productname.= ',' . $productnames;
              }
               if(strlen( $storeCatDescs)>0){
                $storeCatDesc.= ',' . $storeCatDescs;
              }
            }
         }
            
            $arr = array();
            $arr[] = $sl++;
           // $arr[] = implode(',',$value['name']);
            $arr[]= $productname;
            $arr[] = $imageField;
            //$arr[] = $value['description'][0];
            $arr[]=$storeCatDesc;
            $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
            $arr[] = '<button class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function insertSubCategory() {
        $previousCategory = $this->mongo_db->where(array('name' => $_REQUEST['name']))->find_one('storeSubCategory');

        if ($previousCategory) {
            echo json_encode(array('msg' => 0));
        } else {
            $data = $_POST;
          
            $cursor = $this->mongo_db->get("storeSubCategory");

            $arr = [];
            foreach ($cursor as $catdata) {
                array_push($arr, $catdata['seqId']);
            }

            $max = max($arr);
            $seq = $max + 1;

            $data['seqId'] = (int) $seq;

            $lang = $this->mongo_db->get('lang_hlp');
            $lanCodeArr = [];
            $lanIdArr = [];
            foreach ($lang as $lan) {
                $lanCodeArr[0] = "en";
                $lanIdArr[0] = "0";
                array_push($lanCodeArr, $lan['langCode']);
                array_push($lanIdArr, $lan['lan_id']);
            }

            if (count($lanCodeArr) == count($data['name'])) {
                $data['storeSubCategoryName'] = array_combine($lanCodeArr, $data['name']);
            } else if (count($lanCodeArr) < count($data['name'])) {
                $data['storeSubCategoryName']['en'] = $data['name'][0];

                foreach ($data['name'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['storeSubCategoryName'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['storeSubCategoryName'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['storeSubCategoryName']['en'] = $data['name'][0];
            }

            if (count($lanCodeArr) == count($data['description'])) {
                $data['storeSubCategoryDescription'] = array_combine($lanCodeArr, $data['description']);
            } else if (count($lanCodeArr) < count($data['description'])) {
                $data['storeSubCategoryDescription']['en'] = $data['description'][0];

                foreach ($data['description'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['storeSubCategoryDescription'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['storeSubCategoryDescription'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['storeSubCategoryDescription']['en'] = $data['description'][0];
            }
            
            $data['visibility'] = (int) $data['visibility'];
            if ($data['visibility'] == 1) {
                $data['visibilityMsg'] = "Unhidden";
            } else {
                $data['visibilityMsg'] = "Hidden";
            }
//           echo '<pre>'; print_r($data); die;

//            $insertIntoChatArr = array('_id' => $id, 'storeCategoryName' => $data['name'], 'storeCategoryDescription' => $data['description'], 'type' => (int) $type, 'typeMsg' => $typeMsg, 'seqID' => $seq, 'name' => $Name, 'description' => $Description, 'imageUrl' => $catPhoto, 'visibility' => (int) $visibility, 'visibilityMsg' => "Unhidden", 'fileName' => $fileName);
            $res = $this->mongo_db->insert('storeSubCategory', $data);
            echo json_encode(array('msg' => 1));
        }
    }

    function SubCategoryData() {
        $MAsterData = $this->mongo_db->get('storeSubCategory');
        $data = array();

        foreach ($MAsterData as $driver) {
            $data[] = array('name' => $driver['name'], 'description' => $driver['description'], 'categoryId' => $driver['_id']['$oid']);
        }
        return $data;
    }

    function editSubCategory() {
        $data = $_POST;
       
        $lang = $this->mongo_db->get('lang_hlp');
            $lanCodeArr = [];
            $lanIdArr = [];
            foreach ($lang as $lan) {
                $lanCodeArr[0] = "en";
                $lanIdArr[0] = "0";
                array_push($lanCodeArr, $lan['langCode']);
                array_push($lanIdArr, $lan['lan_id']);
            }

            if (count($lanCodeArr) == count($data['name'])) {
                $data['storeSubCategoryName'] = array_combine($lanCodeArr, $data['name']);
            } else if (count($lanCodeArr) < count($data['name'])) {
                $data['storeSubCategoryName']['en'] = $data['name'][0];

                foreach ($data['name'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['storeSubCategoryName'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['storeSubCategoryName'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['storeSubCategoryName']['en'] = $data['name'][0];
            }

            if (count($lanCodeArr) == count($data['description'])) {
                $data['storeSubCategoryDescription'] = array_combine($lanCodeArr, $data['description']);
            } else if (count($lanCodeArr) < count($data['description'])) {
                $data['storeSubCategoryDescription']['en'] = $data['description'][0];

                foreach ($data['description'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['storeSubCategoryDescription'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['storeSubCategoryDescription'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['storeSubCategoryDescription']['en'] = $data['description'][0];
            }
        
        $id = $data['editId'];
        unset($data['editId']);

      

        $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($data)->update('storeSubCategory');

        $dataApi['_id']=$id;
        $dataApi['type']="2";

        if($result){
            
            //$url = APILink . 'updateToStore';      
            $url = 'https://apiDev.deliv-x.com/updateToStore';      
            $response = json_decode($this->callapi->CallAPI('PATCH', $url, $dataApi), true);
          

        }
        echo json_encode($result);
    }

    function deleteSubCategory() {
        $this->load->library('utility_library');
        $val = $this->input->post('val');

        foreach ($val as $row) {
            $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('storeSubCategory');
        }
        $image = $data['imageUrl'];

        foreach ($val as $row) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->delete('storeSubCategory');
            $this->mongo_db->where(array('categoryId' => $row))->delete('secondCategory');
            $this->mongo_db->where(array('categoryId' => $row))->delete('thirdCategory');
        }
        $foldername = 'first_level_category';
        $resu = $this->utility_library->deleteImage($foldername, $image);
        echo json_encode($result);
    }

    public function getSubCategoryData() {
        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('storeSubCategory');
        echo json_encode(array('data' => $cursor));
    }

    function unhideSubCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('storeSubCategory');
            if ($getdata['visibility'] == 0 || $getdata['visibility'] == '') {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 1))->update('storeSubCategory');
                echo json_encode(array('msg' => 'Selected category unhided successfully', 'flag' => 1));
            } else if ($getdata['visibility'] == 1) {
                echo json_encode(array('msg' => 'Selected category is unhided already', 'flag' => 0));
            }
        }
    }

    function hideSubCategory() {

        $val = $this->input->post('val');
        foreach ($val as $row) {
            $getdata = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->find_one('storeSubCategory');
            if ($getdata['visibility'] == 1) {
                $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array('visibility' => 0))->update('storeSubCategory');
                echo json_encode(array('msg' => 'Selected category hided successfully', 'flag' => 1));
            } else if ($getdata['visibility'] == 0) {
                echo json_encode(array('msg' => 'Selected category is hided already', 'flag' => 0));
            }
        }
    }

    function getSubCategoryForFranchise_and_Business() {
        $resultData = $this->mongo_db->order_by(array('seqID' => 'ASC'))->get('storeSubCategory');
        $data = array();

        foreach ($resultData as $res) {
            $data[] = array('name' => $res['name'], 'description' => $res['description'], 'categoryId' => $res['_id']['$oid']);
        }
//        print_r($data); die;
        return $data;
    }

    function changeSubCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->find_one('storeSubCategory');
        $Prevecountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->find_one('storeSubCategory');
        $currcount = $Curruntcountval['seqID'];
        $prevcount = $Prevecountval['seqID'];
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->set(array('seqID' => $prevcount))->update('storeSubCategory');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->set(array('seqID' => $currcount))->update('storeSubCategory');
    }

    function getSubCategory($param1 = '', $param2 = '', $param3 = '') {
        $category = $this->mongo_db->where()->find_one();
    }

    
    

        function AddNewAttributes($param1,$param2) {
            $this->load->library('mongo_db');
            $data = $_POST;       
            $data['timeStamp'] = time(); 
            $data['isoDate'] = $this->mongo_db->date();
            $data['status'] = 1;
            $data['storeCategoryId'] = $param2;
            $data['statusMsg'] = 'Active';
            $cursor = $this->mongo_db->get("storeCategoryAttributes");       
            $arr = [];
            $arrName = [];
            foreach ($cursor as $cdata) {
                array_push($arr, $cdata['seqId']);
                array_push($arrName, $cdata['name']['en']);
            }
            $max = max($arr);
            $seq = $max + 1;
            $data['seqId'] = $seq; 
            $dataAttributes=[];
            
            foreach($data['attributes'] as $attributesData){ 
                $id=new MongoDB\BSON\ObjectID();
                $dataAttr = (object) array("id"=>$id,"name"=> $attributesData['name']);          
                array_push($dataAttributes, $dataAttr);
            }
            $data['attributes']=$dataAttributes;
           if (!in_array($data['name']['en'], $arrName)) {
                $dat = $this->mongo_db->insert('storeCategoryAttributes', $data);
                return true;
            } else {
                return;
            }
    
        }
    

}

?>
