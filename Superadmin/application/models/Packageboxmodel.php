<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Packageboxmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('CallAPI');
        $this->load->library('Datatables');
        $this->load->library('table');
    }

    function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->where(array('Active'=>1))->get('lang_hlp');
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function size_details($status) {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "name.en";
        // $_POST['mDataProp_1'] = "categoryName";
        // $_POST['mDataProp_2'] = "subCategoryName";
        // $_POST['mDataProp_3'] = "subSubCategoryName";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('packageBox', array("status" => (int) $status), '_id', -1);
        $respo['lang'] = $this->mongo_db->where(array('Active'=>1))->get('lang_hlp');
        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();


            if(count($respo['lang'])<1){               
                $sizeName=($value['name']['en'] != "" || $value['name']['en'] != null) ? $value['name']['en']: 'N/A'; 
                
               }else{      

                $sizeName=($value['name']['en'] != "" || $value['name']['en'] != null) ? $value['name']['en']: 'N/A';  
                  
                foreach( $respo['lang'] as $lang){    
                    $lan= $lang['langCode'];
                    $sizeNames=($value['name'][$lan] != "" || $value['name'][$lan] != null) ? $value['name'][$lan]: '';   
                    
                   if(strlen( $sizeNames)>0){
                    $sizeName .= ',' . $sizeNames;
                   }
                   
                }
             }
             $weightUnit='';
             $volumeUnit='';
             if($value['weightCapacityUnitName'] !=''){
                 $weightUnit=$value['weightCapacityUnitName'];
             }
             if($value['voulumeCapacityUnitName'] !=''){
                $volumeUnit=$value['voulumeCapacityUnitName'];
            }


            $arr[] = $sl++;
            $arr[] = $sizeName;
            $arr[] = $value['weight'].' '.$weightUnit;
            $arr[] = $value['volumeCapacity'].' '.$volumeUnit;
            // $arr[] = $value['categoryName'];
            // $arr[]=($value['subCategoryName']!="" || $value['subCategoryName']!=null) ? $value['subCategoryName']:'N/A';
            // $arr[]=($value['subSubCategoryName']!="" || $value['subSubCategoryName']!=null) ? $value['subSubCategoryName']:'N/A';
            // $arr[] = $description;
            // $arr[] = '<button class="sizechartview" data-id ="'. $value['_id']['$oid'] .'"style="background:transparent;border:none;color:blue;text-decoration: underline;">View</button>';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
    function getSizeChart($id){
        $data = $this->mongo_db->where(array('_id'=> new MongoDB\BSON\ObjectID($id)))->select(array("sizeChart"=>"sizeChart"))->get('packageBox');
       
       echo json_encode($data);
    }

    function getStoreCategory(){
        $data = $this->mongo_db->select(array("storeCategoryName"=>"storeCategoryName","type"=>"type"))->get('storeCategory');
        $record =[];
        foreach($data as $rec){
            $record[] = $rec; 
        }
       return($record);
     }
     function sizeUrl(){
        $data = $_POST;
       
       
        $url = pythonAPILink . 'sizeUrl/';
       
        $response = json_decode($this->callapi->CallAPI('POST', $url, $data), true);
       
        if($response['statusCode'] == 200){
            echo json_encode(array('data' => $response, 'flag' => 1));
        }
        else{
            echo json_encode(array('data' => $data, 'flag' => 0));
        }
     }

    function addSizeGroup() {
        // $data = $_POST;

        $lang = $this->mongo_db->where(array('Active'=>1))->get('lang_hlp');
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
    
        // language wise size name and description
        $Name = $this->input->post('name');
        $data['weight'] = (float)$this->input->post('weight');
        $data['weightCapacityUnit'] = $this->input->post('weightCapacityUnit');
        $data['volumeCapacity'] = (float)$this->input->post('volumeCapacity');      
        $data['voulumeCapacityUnit'] = $this->input->post('voulumeCapacityUnit');
        $data['weightCapacityUnitName'] = $this->input->post('weightCapacityUnitName');
        $data['voulumeCapacityUnitName'] = $this->input->post('voulumeCapacityUnitName');
        
        

        // $description = $this->input->post('description');
        if (count($lanCodeArr) == count($Name)) {
            $data['name'] = array_combine($lanCodeArr, $Name);
        } else if (count($lanCodeArr) < count($Name)) {
            $data['name']['en'] = $Name[0];

            foreach ($Name as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['name'][$lan['langCode']] = $val;
                        }
                    }
                    else {
                      if ($key == $lan['lan_id']) {
                          $data['name'][$lan['langCode']] = $val;
                      }
                  } 
                }
            }
        } else {
            $data['name']['en'] = $Name[0];
        }
        $data['status']= 1;
        $data['statusMsg'] = 'Active';
        $cursor = $this->mongo_db->select(array('name'=>'name'))->get('packageBox');
        $arr = [];
        $arrName = [];
        foreach ($cursor as $cdata) {
            // array_push($arr, $cdata['seqId']);
            array_push($arrName, $cdata['name']['en']);
        }
        // $max = max($arr);
        // $seq = $max + 1;

        // $data['seqId'] = $seq;
            
       
         if (!in_array($data['name']['en'], $arrName)) {
            $data = $this->mongo_db->insert('packageBox', $data);
            echo json_encode(array('data' => $data, 'flag' => 1));
        } else {
            echo json_encode(array('data' => $data, 'flag' => 0));
        }
       


        // // description
        // if (count($lanCodeArr) == count($description)) {
        //     $data['description'] = array_combine($lanCodeArr, $description);
        // } else if (count($lanCodeArr) < count($description)) {
        //     $data['description']['en'] = $description[0];

        //     foreach ($description as $key => $val) {
        //         foreach ($lang as $lan) {

        //             if ($lan['Active'] == 1) {
        //                 if ($key == $lan['lan_id']) {
        //                     $data['description'][$lan['langCode']] = $val;
        //                 }
        //             } else {
        //                 if ($key == $lan['lan_id']) {
        //                     $data['name'][$lan['langCode']] = $val;
        //                 }
        //             }
        //         }
        //     }
        // } else {
        //     $data['description']['en'] = $description[0];
        // }

        // end

       
        // if($response['statusCode'] == 200){
        //     echo json_encode(array('data' => $data, 'flag' => 1));
        // }
        // else{
        //     echo json_encode(array('data' => $data, 'flag' => 0));
        // }
        


        // $i;
        // $k;
       

        // ///////////////////////////////////


        // $encount = count($data['sizeAttr']['en']);
        // for ($j = 0; $j < $encount; $j++) {
        //     $data1['sizeAttr'][$j + 1]['sAttrLng']['en'] = $data['sizeAttr']['en'][$j];
        // }

        // $lang = $this->mongo_db->get('lang_hlp');
        // foreach ($lang as $glan) {
        //     if ($glan['Active'] == 1) {
        //     $langcount = count($data['sizeAttr'][$glan['langCode']]);
        //     for ($k = 0; $k < $langcount; $k++) {
        //     $data1['sizeAttr'][$k + 1]['sAttrLng'][$glan['langCode']] = $data['sizeAttr'][$glan['langCode']][$k];
        //     }
        //   }
        // }


        // $totcount = count($data['sizeAttr']['en']);
        // for ($i = 0; $i < $totcount; $i++) {
        //     $data1['sizeAttr'][$i + 1] = array('attrId'=>new MongoDB\BSON\ObjectID(),'sAttrLng' => $data1['sizeAttr'][$i+1]['sAttrLng']);
        // }

        // ////////////////////////////////////////

        // $data['sizeAttr'] = $data1['sizeAttr'];

        // $lanCodeArr = [];
        // $lanIdArr = [];
        // foreach ($lang as $lan) {
        //     $lanCodeArr[0] = "en";
        //     $lanIdArr[0] = "0";
        //     if ($lan['Active'] == 1) {
        //         array_push($lanCodeArr, $lan['langCode']);
        //         array_push($lanIdArr, $lan['lan_id']);
        //     }
        // }

        // if (count($lanCodeArr) == count($data['sizeName'])) {
        //     $data['name'] = array_combine($lanCodeArr, $data['sizeName']);
        // } else if (count($lanCodeArr) < count($data['sizeName'])) {
        //     $data['name']['en'] = $data['sizeName'][0];

        //     foreach ($data['sizeName'] as $key => $val) {
        //         foreach ($lang as $lan) {

        //             if ($lan['Active'] == 1) {
        //                 if ($key == $lan['lan_id']) {
        //                     $data['name'][$lan['langCode']] = $val;
        //                 }
        //             } else {
        //                 if ($key == $lan['lan_id']) {
        //                     $data['name'][$lan['langCode']] = $val;
        //                 }
        //             }
        //         }
        //     }
        // } else {
        //     $data['name']['en'] = $data['sizeName'][0];
        // }

        // if (count($lanCodeArr) == count($data['sizeDesc'])) {
        //     $data['description'] = array_combine($lanCodeArr, $data['sizeDesc']);
        // } else if (count($lanCodeArr) < count($data['sizeDesc'])) {
        //     $data['description']['en'] = $data['sizeDesc'][0];

        //     foreach ($data['sizeDesc'] as $key => $val) {
        //         foreach ($lang as $lan) {

        //             if ($lan['Active'] == 1) {
        //                 if ($key == $lan['lan_id']) {
        //                     $data['description'][$lan['langCode']] = $val;
        //                 }
        //             } else {
        //                 if ($key == $lan['lan_id']) {
        //                     $data['description'][$lan['langCode']] = $val;
        //                 }
        //             }
        //         }
        //     }
        // } else {
        //     $data['description']['en'] = $data['sizeDesc'][0];
        // }

        // $data['status'] = 1;
        // $data['statusMsg'] = 'Active';

        // $time = time();
        // $data['createdTimeStamp'] = $time;
        // $data['isoDate'] = $this->mongo_db->date();

        // $cursor = $this->mongo_db->get("sizeGroup");
        // $arr = [];
        // $arrName = [];
        // foreach ($cursor as $cdata) {
        //     array_push($arr, $cdata['seqId']);
        //     array_push($arrName, $cdata['sizeName'][0]);
        // }
        // $max = max($arr);
        // $seq = $max + 1;

        // $data['seqId'] = $seq;

        // if (!in_array($data['sizeName'][0], $arrName)) {
        //     $data = $this->mongo_db->insert('packageBox', $data);
        //     echo json_encode(array('data' => $data, 'flag' => 1));
        // } else {
        //     echo json_encode(array('data' => $data, 'flag' => 0));
        // }
    }
    function editSize() {
      $data = $_POST;
  

      $lang = $this->mongo_db->get('lang_hlp');
  
      $id = $data['sizeId'];
      unset($data['sizeId']);

     // $lang = $this->mongo_db->get('lang_hlp');
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

      if (count($lanCodeArr) == count($data['sizeName'])) {
          $data['name'] = array_combine($lanCodeArr, $data['sizeName']);
      } else if (count($lanCodeArr) < count($data['sizeName'])) {
          $data['name']['en'] = $data['sizeName'][0];

          foreach ($data['sizeName'] as $key => $val) {
              foreach ($lang as $lan) {

                  if ($lan['Active'] == 1) {
                      if ($key == $lan['lan_id']) {
                          $data['name'][$lan['langCode']] = $val;
                      }
                  } else {
                      if ($key == $lan['lan_id']) {
                          $data['name'][$lan['langCode']] = $val;
                      }
                  }
              }
          }
      } else {
          $data['name']['en'] = $data['sizeName'][0];
      }
      $data['weight'] = (float)$this->input->post('weight');
      $data['weightCapacityUnit'] = $this->input->post('weightCapacityUnit');
      $data['volumeCapacity'] = (float)$this->input->post('volumeCapacity');      
      $data['voulumeCapacityUnit'] = $this->input->post('voulumeCapacityUnit');
      $data['weightCapacityUnitName'] = $this->input->post('weightCapacityUnitName');
      $data['voulumeCapacityUnitName'] = $this->input->post('voulumeCapacityUnitName');
      unset($data['sizeName']);
      unset($data['sizeDesc']);
      
      try {
          echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('packageBox');
      } catch (Exception $ex) {
          print_r($ex);
      }
  }

    function getSize() {
        $Id = $this->input->post('Id');

        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->find_one('packageBox');

        return $data;
    }

    function getCategoryData($scid = '') {
            $lang =  $this->mongo_db->where(array('Active'=>1))->get('lang_hlp');
            $storeCategory = $this->input->post('storeCategoryId');
            $categoryId = $this->input->post('categoryId');
            $where=array(
                "storeCategory.storeCategoryId"=>$storeCategory
            );
            $cursor = $this->mongo_db->where($where)->select(array("categoryName"=>"categoryName"))->get('firstCategory');
            $entities = array();
            $entities = '<select class="form-control error-box-class"  id="editcategory" name="Category">
                     <option value="">Select Category</option>';
            foreach ($cursor as $d) {
                $catName =$d['categoryName']['en'];
                
                foreach($lang as $lng){
                    $catName .=  $d['categoryName'][$lng['langCode']]? ', '.$d['categoryName'][$lng['langCode']]:'';
                    
                }
                if ($categoryId == $d['_id']['$oid']) {
                    $entities .= '<option data-name="' .$d['categoryName']['en'] . '" value="' . $d['_id']['$oid'] . '" selected>' . $catName . '</option>';
                }
                else{
                    $entities .= '<option data-name="' .$d['categoryName']['en'] . '" value="' . $d['_id']['$oid'] . '">' . $catName . '</option>';
                }   
            }
            $entities .= '</select>';
//        print_r($entities);die;
            echo $entities;
        
    }
    function getSubCategoryData($cid = '', $sid = '') {
        $lang =  $this->mongo_db->where(array('Active'=>1))->get('lang_hlp');
        if ($cid != '' || $cid != null) {
            $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($cid)))->get('secondCategory');
            echo json_encode(array('data' => $cursor));
        } else {
            $val = $this->input->post('categoryId');
            $sval = $this->input->post('subCategoryId');
            $cursor = $this->mongo_db->where(array("categoryId" => new MongoDB\BSON\ObjectID($val)))->get('secondCategory');
            $entities = array();
            $entities = '<select class="form-control error-box-class"  id="subCategory" name="subCategory">
                     <option value="">Select Sub-Category</option>';
            foreach ($cursor as $d) {
                $subcatName =$d['subCategoryName']['en'];
                
                foreach($lang as $lng){
                    $subcatName .=  $d['subCategoryName'][$lng['langCode']]? ', '.$d['subCategoryName'][$lng['langCode']]:'';
                    
                }

                if ($sval == $d['_id']['$oid']) {
                    $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '" selected>' . $subcatName . '</option>';
                } else {
                    $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '">' . $subcatName . '</option>';
                }
            }
            $entities .= '</select>';
//        print_r($entities);die;
            echo $entities;
        }
    }

    function getSubsubCategoryDataList($sid = '', $ssid = '') {
        $lang =  $this->mongo_db->where(array('Active'=>1))->get('lang_hlp');
        if ($sid != '' || $sid != null) {

            $cursor = $this->mongo_db->where(array("subCategoryId" => new MongoDB\BSON\ObjectID($sid)))->get('thirdCategory');
            echo json_encode(array('data' => $cursor));
        } else {
                $val = $this->input->post('subCategoryId');
                $ssval = $this->input->post('subSubCategoryId');
            if ($val != '' || $val != null) {
                

                $cursor = $this->mongo_db->where(array("subCategoryId" => new MongoDB\BSON\ObjectID($val)))->get('thirdCategory');
                $entities = array();
                $entities = '<select class="form-control error-box-class"  id="subSubCategory" name="subSubCategory">
                     <option value="">Select Sub-SubCategory</option>';
                foreach ($cursor as $d) {
                    $subsubcatName =$d['subSubCategoryName']['en'];
                
                    foreach($lang as $lng){
                        $subsubcatName .=  $d['subSubCategoryName'][$lng['langCode']]? ', '.$d['subSubCategoryName'][$lng['langCode']]:'';
                        
                    }
                    if ($ssval == $d['_id']['$oid']) {
                        $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '" selected>' .$subsubcatName . '</option>';
                    } else {
                        $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '">' . $subsubcatName. '</option>';
                    }
                }
                $entities .= '</select>';
            } else {
                $entities = array();
                $entities = '<select class="form-control error-box-class"  id="subSubCategory" name="subSubCategory">
                     <option value="">Select Sub-SubCategory</option>';

                $entities .= '</select>';
            }
            echo $entities;
        }
    }

    

    function activateColor() {
      $ids= $this->input->post('ids');
        // $data['status'] = 1;


        foreach ($ids as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1, 'statusMsg' => 'Active'))->update('packageBox');
        }

        echo json_encode(array("msg" => "Selected package type has been activated successfully", "flag" => 0));
    }

    function deactivateColor() {
        $ids= $this->input->post('ids');
        // $data['status'] = 2;


        foreach ($ids as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 2, 'statusMsg' => 'Inactive'))->update('packageBox');
        }

        echo json_encode(array("msg" => "Selected package type has been deactivated successfully", "flag" => 0));
    }

}

?>
