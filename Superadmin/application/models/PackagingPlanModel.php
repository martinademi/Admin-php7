<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class PackagingPlanModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('utility_library');
    }

    function datatable_category($status,$cityId) {
//        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 6;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "description";
        $_POST['mDataProp_2'] = "typeMsg";

//        $count1 = count($cat);

        // $respo = $this->datatables->datatable_mongodb('packagingPlan', array('status' => (int)$status), 'seqId', -1); //1->ASCE -1->DESC

        $condition=[

            ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($cityId)]],
            ['$unwind'=>'$cities'],
            ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($cityId)]],
            ['$unwind' =>'$cities.laundry'],
            ['$match'=>["cities.laundry.status" => (int)$status]],
            ['$project'=>['_id'=>1,'cities.cityId'=>1,'cities.laundry'=>1]]
            
        ];
        $countQuery = 
        [

            ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($cityId)]],
            ['$unwind'=>'$cities'],
            ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($cityId)]],
            ['$unwind' =>'$cities.laundry'],
            ['$match'=>["cities.laundry.status" => (int)$status]],
            ['$group'=>['_id'=>1,count=>['$sum'=>1]]]
            
        ];
        

        $respo = $this->datatables->datatable_mongodbAggregate('cities',$condition,$countQuery);
        // print_r("test");
        // print_r($respo);die;

        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = $_POST['iDisplayStart'] + 1;
        // $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        $aaData = json_decode(json_encode($aaData),true);
        // print_r($aaData);die;
        // $value = $aaData[0]['cities']['laundry'];
        foreach ($aaData as $value) {
            $value= $value['cities']['laundry'];
            $arr = array();
            $arr[] = $sl++;          
            $arr[] = $value['lowerLimit'];
            $arr[] = $value['upperLimit'];
            $arr[] = $value['price'];
            $arr[] = $value['taxesApplicable'];
            $arr[] = $value['extraFeeForExpressDelivery'];
            $arr[] = '<button class="btn btnedit btn-primary cls111"  value="' . $cityId . '"  package-id=' .$value['packageId'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $cityId . '" package-id=' .$value['packageId'] . ' />';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function insertCategory() {       

       
            $data = $_POST;
            // $citiesList = explode(",",$data['availableInCities']);
            // $data['availableInCities']= $citiesList;
          
            $lang = $this->mongo_db->get('lang_hlp');
            $lanCodeArr = [];
            $lanIdArr = [];
            foreach ($lang as $lan) {
                $lanCodeArr[0] = "en";
                $lanIdArr[0] = "0";
                array_push($lanCodeArr, $lan['langCode']);
                array_push($lanIdArr, $lan['lan_id']);
            }

            // if (count($lanCodeArr) == count($data['name'])) {
            //     $data['packagingPlanName'] = array_combine($lanCodeArr, $data['name']);
            // } else if (count($lanCodeArr) < count($data['name'])) {
            //     $data['packagingPlanName']['en'] = $data['name'][0];

            //     foreach ($data['name'] as $key => $val) {
            //         foreach ($lang as $lan) {

            //             if ($lan['Active'] == 1) {
            //                 if ($key == $lan['lan_id']) {
            //                     $data['packagingPlanName'][$lan['langCode']] = $val;
            //                 }
            //             } else {
            //                 if ($key == $lan['lan_id']) {
            //                     $data['packagingPlanName'][$lan['langCode']] = $val;
            //                 }
            //             }
            //         }
            //     }
            // } else {
            //     $data['packagingPlanName']['en'] = $data['name'][0];
            // }

            // unset($data['name']);       
            $data['packageId'] =(string)new MongoDB\BSON\ObjectID();;
            // $data['weight']= (float) $data['weight'];
            $data['price']=  (float)$data['price'];
            $data['upperLimit']=  (float)$data['upperLimit'];
            $data['lowerLimit']=  (float)$data['lowerLimit'];
            $data['extraFeeForExpressDelivery'] = (float)$data['extraFeeForExpressDelivery'];
            $data['taxesApplicable'] = (int)$data['taxesApplicable'];
            $data['status']=1;
            $data['statusMsg']="Active";
            $data['addedFrom']=1;
            $data['addedFromMsg']="AddedfromPlan";

            // insert into particular city
            $cityId = $data['cityId'];
            unset($data['cityId']);
            // print_r($cityId);
            $cityData = $this->mongo_db->aggregate('cities',[
                ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($cityId)]],
                ['$unwind'=>'$cities'],
                ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($cityId)]],
                ['$project'=>['cities.laundry'=>1]]
                ]);
            foreach($cityData as $cData){
                // $cDat= json_decode(json_encode($cData),true);
                $doc = json_decode(json_encode($cData),TRUE)['cities'];
            }
        //    if(!count($doc)){
        //     $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($cityId)))->set(array("cities.$.laundry"=>array()))->update('cities');
        //    }
            $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($cityId)))->push(array("cities.$.laundry"=>$data))->update('cities');


            
            // echo  '<pre>';print_r($data);die;

        //    $res = $this->mongo_db->insert('packagingPlan', $data);
        //     unset( $data['_id']);
        //     $data['packagingPlanId']=(string)$id;
        //    // $data['hasPackage']=true;
        //     $pdata['packagingPlanDetails']=(object)$data;

            //echo  '<pre>';print_r($pdata);die;
           
            // if($res){
            //     foreach( $data['availableInCities'] as $zoneId){
            //         $zoneData = $this->mongo_db->where(array("city_ID"=> $zoneId))->set($pdata)->update('zones',array('multi'=>TRUE));    
            //     }
            // }


            echo json_encode(array('msg' => 1));
        
    }

    function CategoryData() {
        $MAsterData = $this->mongo_db->get('storeCategory');
        $data = array();

        foreach ($MAsterData as $driver) {
            $data[] = array('name' => $driver['name'], 'description' => $driver['description'], 'categoryId' => $driver['_id']['$oid']);
        }
        return $data;
    }

    function editCategory() {
        $data = $_POST;
       
        // $citiesList = explode(",",$data['availableInCities']);
            
        // $data['availableInCities']= $citiesList;
        
     
        // $lang = $this->mongo_db->get('lang_hlp');
        //     $lanCodeArr = [];
        //     $lanIdArr = [];
        //     foreach ($lang as $lan) {
        //         $lanCodeArr[0] = "en";
        //         $lanIdArr[0] = "0";
        //         array_push($lanCodeArr, $lan['langCode']);
        //         array_push($lanIdArr, $lan['lan_id']);
        //     }

        
            // if (count($lanCodeArr) == count($data['name'])) {
            //     $data['packagingPlanName'] = array_combine($lanCodeArr, $data['name']);
            // } else if (count($lanCodeArr) < count($data['name'])) {
            //     $data['packagingPlanName']['en'] = $data['name'][0];

            //     foreach ($data['name'] as $key => $val) {
            //         foreach ($lang as $lan) {

            //             if ($lan['Active'] == 1) {
            //                 if ($key == $lan['lan_id']) {
            //                     $data['packagingPlanName'][$lan['langCode']] = $val;
            //                 }
            //             } else {
            //                 if ($key == $lan['lan_id']) {
            //                     $data['packagingPlanName'][$lan['langCode']] = $val;
            //                 }
            //             }
            //         }
            //     }
            // } else {
            //     $data['packagingPlanName']['en'] = $data['name'][0];
            // }

        
        
        $cityId = $data['cityId'];
        $packageId = $data['packageId'];
        unset($data['cityId']);

        $data['price']=  (float)$data['price'];
        $data['upperLimit']=  (float)$data['upperLimit'];
        $data['lowerLimit']=  (float)$data['lowerLimit'];
        $data['extraFeeForExpressDelivery']=  (float)$data['extrafee'];
        $data['taxesApplicable']=  (int)$data['taxesApplicable'];
        $data['status']=1;
        $data['statusMsg']="Active";
        $data['addedFrom']=1;
        $data['addedFromMsg']="AddedfromPlan";
        unset($data['extrafee']);

       $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($cityId)))->pull('cities.$.laundry',array("packageId"=>$packageId))->update('cities');
       
        $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($cityId)))->push(array("cities.$.laundry"=>$data))->update('cities');

    //    $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($data)->update('packagingPlan');

    //    $data['packagingPlanId']=(string)$id;
      // $data['hasPackage']=true;
    //    $pdata['packagingPlanDetails']=(object)$data;
      
        
        
    //    if($result){
    //        foreach( $data['availableInCities'] as $zoneId){            
    //            $zoneDataVerify = $this->mongo_db->where(array("city_ID"=> $zoneId))->select(array('packagingPlanDetails'=>'packagingPlanDetails'))->get('zones');               

    //             foreach($zoneDataVerify as $zone){
    //                     if($zone['packagingPlanDetails']['addedFrom']==1){       
    //                         $zoneData = $this->mongo_db->where(array("city_ID"=> $zoneId))->set($pdata)->update('zones');    
    //                     }else{
        
    //                     }
    //             }
    //          }
    //    }
     
            
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
        $cityId = $this->input->post('val');
        $packageId = $this->input->post('packageId');
        $condition=[

            ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($cityId)]],
            ['$unwind'=>'$cities'],
            ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($cityId)]],
            ['$unwind'=>'$cities.laundry'],
            ['$match'=>["cities.laundry.packageId"=>($packageId)]],
            ['$project'=>['cities.laundry'=>1]]
        ];

        $cursor = $this->mongo_db->aggregate('cities',$condition);
        // $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('packagingPlan');
        foreach($cursor as $cData){
            $doc = json_decode(json_encode($cData),TRUE)['cities'];
        }
        echo json_encode(array('data' => $doc,'cityId'=>$cityId));
    }

    function unhideCategory() {
        $cityList = $this->input->post('cityList');
        $packageList = $this->input->post('packageList');
        $count=0;
        foreach ($packageList as $packageId) {
            $cityId = $cityList[$count++];
            $result = $this->mongo_db->aggregate('cities',[
            ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($cityId)]],
            ['$unwind'=>'$cities'],
            ['$match'=>['cities.cityId'=>new MongoDB\BSON\ObjectID($cityId)]],
            ['$unwind'=>'$cities.laundry'],
            ['$match'=>['cities.laundry.packageId'=>$packageId]],
            ['$project'=>['cities.laundry'=>1]]
            ]);
            foreach($result as $resData){
                $doc= json_decode(json_encode($resData),true);
            }
            $resDoc = $doc['cities']['laundry'];
            $resDoc['status'] = 1;
            $resDoc['statusMsg'] = 'Active';

            $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($cityId)))->pull('cities.$.laundry',array("packageId"=>$packageId))->update('cities');
       
            $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($cityId)))->push(array("cities.$.laundry"=>$resDoc))->update('cities');
            echo json_encode(array('msg' => 'Selected plan inactive successfully', 'flag' => 1));
        }
    }

    function hideCategory() {
     
        $cityList = $this->input->post('cityList');
        $packageList = $this->input->post('packageList');
        $count=0;
        foreach ($packageList as $packageId) {
            $cityId = $cityList[$count++];
            $result = $this->mongo_db->aggregate('cities',[
            ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($cityId)]],
            ['$unwind'=>'$cities'],
            ['$match'=>['cities.cityId'=>new MongoDB\BSON\ObjectID($cityId)]],
            ['$unwind'=>'$cities.laundry'],
            ['$match'=>['cities.laundry.packageId'=>$packageId]],
            ['$project'=>['cities.laundry'=>1]]
            ]);
            foreach($result as $resData){
                $doc= json_decode(json_encode($resData),true);
            }
            $resDoc = $doc['cities']['laundry'];
            $resDoc['status'] = 0;
            $resDoc['statusMsg'] = 'Inactive';

            $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($cityId)))->pull('cities.$.laundry',array("packageId"=>$packageId))->update('cities');
       
            $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($cityId)))->push(array("cities.$.laundry"=>$resDoc))->update('cities');
            echo json_encode(array('msg' => 'Selected plan inactive successfully', 'flag' => 1));
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


        foreach ($aaData as $value) {
        
            if ($value['logoImage']) {
                $imageField = '<img src="' . $value['logoImage'] . '"  width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            } else {
                $imageField = '<img src="' . base_url('') . 'pics/user.jpg\';"   width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            }
        $productName=($value['storeSubCategoryName']['en']!='' || $value['storeSubCategoryName']['en']!=null ) ? $value['storeSubCategoryName']['en']: 'N/A'; 
            
            $arr = array();
            $arr[] = $sl++;
           // $arr[] = implode(',',$value['name']);
            $arr[]= $productName;
            $arr[] = $imageField;
            //$arr[] = $value['description'][0];
            $arr[]=($value['storeSubCategoryDescription']['en'] != "" || $value['storeSubCategoryDescription']['en'] != null) ? $value['storeSubCategoryDescription']['en']: 'N/A';
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
        echo '<pre>';print_r($data);die;
       
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

}

?>
