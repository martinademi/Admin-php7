<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class productOffersmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');
    }

    function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->get('lang_hlp');
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function data_details($status) {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "brandName";
        $_POST['mDataProp_1'] = "brandDescription";
        $_POST['mDataProp_2'] = "statusMsg";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('brands', array("status" => (int) $status), 'seqId', -1);

        $aaData = $respo["aaData"];
        $datatosend = array();
        // 1 - active, 0 - inactive
        foreach ($aaData as $value) {
            $arr = array();

            if (count($value['brandName']) != 0) {
                $Name = implode(',', $value['brandName']);
            } else {
                $Name = 'N/A';
            }
            if (count($value['brandDescription']) != 0) {
                $Desc = implode(',', $value['brandDescription']);
            } else {
                $Desc = 'N/A';
            }

            $arr[] = $sl++;
            $arr[] = $Name;
            $arr[] = $Desc;
            $arr[] = $value['statusMsg'];
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function getAllCities() {
//        $cityArr = [];
        $CityData = $this->mongo_db->get('cities');
        foreach ($CityData as $CIties) {
            foreach ($CIties['cities'] as $city)
                $cityArr[] = $city;
        }
        return $cityArr;
    }

    function getFranchiseData($id = '',$fid) {
         /*api pending*/
        if ($id != '' || $id != null) {
            $url =  ProductOffers."franchise/".  $val;
            $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);

           // $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->get('franchise');
            echo json_encode(array('data' => $cursor));
           
        } else {
            // print_r($fid);die;
            $val = $this->input->post('val');
            $fid = $this->input->post('fid');

            $url =  ProductOffers."franchise/".  $val;
            $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
           
           // $cursor = $this->mongo_db->where(array("cityId" => $val))->get('franchise');
            
            $entities = array();
            $entities = '<select class="form-control error-box-class"  id="franchise" name="franchiseId">
                     <option value="">Select Franchise</option>';
            foreach ($cursor as $d) {
                if($fid == $d['_id']['$oid']){
                    $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '"selected>' . implode($d['name'], ',') . '</option>';
                }else{
                    $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '">' . implode($d['name'], ',') . '</option>';
                }
                
            }
            $entities .= '</select>';
            echo $entities;
           
        }
    }

    // function getStoreData($id = '') {
        
    //     if ($id != '' || $id != null) {
    //         $url =  ProductOffers."stores/".  $val;
    //         $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
           
    //         echo json_encode(array('data' => $cursor));
    //     } else {
    //         $val = $this->input->post('val'); //ProductOffers
           
    //         $curl = curl_init();

    //         curl_setopt_array($curl, array(
    //             CURLOPT_PORT => "8089",
    //             CURLOPT_URL => ProductOffers."stores/",
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => "",
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 30,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => "POST",
    //             CURLOPT_POSTFIELDS => json_encode(array('zoneIds' =>$val, 'flag' => 0)),
    //             CURLOPT_HTTPHEADER => array(
    //                 "cache-control: no-cache",
    //                 "content-type: application/json"
    //             ),
    //         ));
    
            
    //         $response = curl_exec($curl);
    //         $err = curl_error($curl);
            
           
       
          
    //     $cursor = json_decode($response,true);
       
            
           
       
    //         $entities = array();
    //         $entities = '<select class="form-control error-box-class"  id="store" name="storeId">
    //                  <option value="">Select Store</option>';
    //                //  $lang =  $this->mongo_db->where(array("Active"=>1))->get('lang_hlp');
    //         // foreach ($cursor as $d) {
    //         //     $entities .= '<option data-name="' . $d['sName']['en'] . '" value="' . $d['_id']['$oid'] . '">' .$d['sName']['en'] . '</option>';
    //         //     foreach($lang as $lan){
    //         //     // if($d['sName'][$lan['langCode']])
    //         //     $entities .= '<option data-name="' . implode($d['sName'][$lan['langCode']],",") . '" value="' . $d['_id']['$oid'] . '">' .implode($d['sName'][$lan['langCode']],",") . '</option>';
    //         // }
    //         // }
    //         //$entities .= '<option data-name="' . implode($d['name'], '/') . '" value="' . $d['_id']['$oid'] . '">' . implode($d['name'], '/') . '</option>';
    //         foreach ($cursor as $d) {

    //             $entities .= '<option data-name="' . $d['sName']['en'] . '" value="' . $d['_id']['$oid'] . '">' .  $d['sName']['en']  . '</option>';
    //         }
    //         $entities .= '</select>';
    //         echo $entities;
    //     }

       
    // }

    function getStoreData($id = '') {
        
        if ($id != '' || $id != null) {
			$val = $this->input->post('val'); 
            $url =  ProductOffers."stores/";
            $cursor = json_decode($this->callapi->CallAPI('POST',$url,$val),true);
           
            echo json_encode(array('data' => $cursor));
        } else {
            $val = $this->input->post('val'); //ProductOffers
			$url =  ProductOffers."stores/";
            $response = json_decode($this->callapi->CallAPI('POST',$url,array('zoneIds' =>$val, 'flag' => 0)),true);

			$cursor =  $response;
          
            $entities = array();
            $entities = '<select class="form-control error-box-class"  id="store" name="storeId">
                     <option value="">Select Store</option>';
                 
            foreach ($cursor as $d) {

                $entities .= '<option data-name="' . $d['sName']['en'] . '" value="' . $d['_id']['$oid'] . '">' .  $d['sName']['en']  . '</option>';
            }
            $entities .= '</select>';
            echo $entities;
        }

       
    }


    //zones************
    function getZonesWithCities() {

        $this->load->library('mongo_db');
        $val = $this->input->post('val');
       
        $url =  ProductOffers."zones/".$val;
        //print_r( $url);die;
        $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);

       // $cursor = $this->mongo_db->where(array("city_ID" => $val))->get('zones');
        if ($cursor) {
            $entitiesData = array();
            $entityData = [];
            foreach ($cursor as $dat) {
                $entityData['id'] = $dat['_id']['$oid'];
                $entityData['title'] = $dat['title'];
                array_push($entitiesData, $entityData);
                // array_push($entities, '<option data-name="' . $dat['title'] . '" value="' . $dat['_id']['$oid'] . '">' . $dat['title'] . '</option>');
            }

            echo json_encode(array('data' => $entitiesData));
        } else {
            $entities = array();
            $entities = '<option value="">Select Zones</option>';
            $entities .= '<option data-name="" value="">' . 'No zones to select' . '</option>';
            echo $entities;
        }
    }


    //store patch
    function getZonesWithStore() {

        
           
        if ($id != '' || $id != null) {
            $url =  ProductOffers."stores/".  $val;
            $cursor = json_decode($this->callapi->CallAPI('POST',$url),true);
            //$cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->get('stores');
            echo json_encode(array('data' => $cursor));
        } else {
            $val = $this->input->post('val'); //ProductOffers
            $url =  ProductOffers."stores/".  $val;
            $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
            $entities = array();
            $entities = '<select class="form-control error-box-class"  id="store" name="storeId">
                     <option value="">Select Store</option>';
            foreach ($cursor as $d) {

                $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '">' . implode($d['name'], ',') . '</option>';
            }
            $entities .= '</select>';
            echo $entities;
        }
    }

    function getProductData($id = '') {

        if ($id != '' || $id != null) {
           
            $url =  ProductOffers."products/".  $val;
            $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
            echo json_encode(array('data' => $cursor));
        } else {
           
            $val = $this->input->post('val');
            $url =  ProductOffers."products/".  $val;
            $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
            if ($cursor) {
                $entitiesData = array();
                $entityData = [];
                foreach ($cursor as $dat) {
                    $entityData['id'] = $dat['_id']['$oid'];
                    $entityData['title'] = $dat['productname']['en'];
                    array_push($entitiesData, $entityData);
                }

                echo json_encode(array('data' => $entitiesData));
            } else {
                $entities = array();
                $entities = '<option value="">Select Products</option>';
                $entities .= '<option data-name="" value="">' . 'No product to select' . '</option>';
                echo $entities;
            }

        }
    }


    //function to fetch units data
    function  getUnitsData($id = ''){
        //$val = $this->input->post('val');

        if ($id != '' || $id != null) {
            $val = $this->input->post('val');
            $url =  ProductOffers."produnits/".  $val;
            $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
          
            echo json_encode(array('data' => $cursor));
        } else {
            $val = $this->input->post('val');
            // echo '****';
            // var_dump($val);
            $url =  ProductOffers."produnits/".  $val;
           
            $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
            
        //    echo "hiiii" ;
       
     
       
            if ($cursor) {
                $entitiesData = array();
                $entityData = [];
                foreach ($cursor as $dat) {

                    foreach ($dat['units'] as $data) {
                        $untiData = [];
                        $untiData["id"] = $data["unitId"];
                        $untiData["title"] = $data["name"]["en"];
                      array_push($entitiesData, $untiData);                      
                    }
                 
                    
                }

                echo json_encode(array('data' => $entitiesData));
            } else {
                $entities = array();
                $entities = '<option value="">Select Products</option>';
                $entities .= '<option data-name="" value="">' . 'No product to select' . '</option>';
                echo $entities;
            }

        }
        


    }





    function getCategoryData($id = '') {

                if ($id != '' || $id != null) {
                        $url =  ProductOffers."category/".  $val;
                        $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
                    // $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->get('childProducts');
                        echo json_encode(array('data' => $cursor));
                    } else {
                        $val = $this->input->post('val');
                        $url =  ProductOffers."category/".  $val;
                        $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
                        //$cursor = $this->mongo_db->where(array("storeId" => new MongoDB\BSON\ObjectID($val), 'status' => 1))->get('childProducts');

                        if ($cursor) {
                            $entitiesData = array();
                            $entityData = [];
                            foreach ($cursor as $dat) {
                                $entityData['id'] = $dat['_id']['$oid'];
                                $entityData['title'] = $dat['categoryName']['en'];
                                array_push($entitiesData, $entityData);
                            }

                            echo json_encode(array('data' => $entitiesData));
                        } else {
                            $entities = array();
                            $entities = '<option value="">Select Products</option>';
                            $entities .= '<option data-name="" value="">' . 'No product to select' . '</option>';
                            echo $entities;
                        }
                    }
             }

     function getSubCategoryData($id = ''){
                 
                        if ($id != '' || $id != null) {
                            $url =  ProductOffers."subcategory/".  $val;
                            $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
                           // $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->get('childProducts');
                            echo json_encode(array('data' => $cursor));
                        } else {
                            $val = $this->input->post('val');
                            $url =  ProductOffers."subcategory/".  $val;
                            $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
                            //$cursor = $this->mongo_db->where(array("storeId" => new MongoDB\BSON\ObjectID($val), 'status' => 1))->get('childProducts');
                            
                            if ($cursor) {
                                $entitiesData = array();
                                $entityData = [];
                                foreach ($cursor as $dat) {
                                    $entityData['id'] = $dat['categoryId']['$oid'];
                                    $entityData['title'] = $dat['subCategoryName']['en'];
                                    array_push($entitiesData, $entityData);
                                }
                
                                echo json_encode(array('data' => $entitiesData));
                            } else {
                                $entities = array();
                                $entities = '<option value="">Select Sub category</option>';
                                $entities .= '<option data-name="" value="">' . 'No product to select' . '</option>';
                                echo $entities;
                            }
                
                        }
                }

      function getSubSubCategoryData($id = ''){
        if ($id != '' || $id != null) {
            $url =  ProductOffers."subsubcategory/".  $val;
            $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
           // $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->get('childProducts');
            echo json_encode(array('data' => $cursor));
        } else {
            $val = $this->input->post('val');
            $url =  ProductOffers."subsubcategory/".  $val;
            $cursor = json_decode($this->callapi->CallAPI('GET',$url),true);
            //$cursor = $this->mongo_db->where(array("storeId" => new MongoDB\BSON\ObjectID($val), 'status' => 1))->get('childProducts');
            
            if ($cursor) {
                $entitiesData = array();
                $entityData = [];
                foreach ($cursor as $dat) {
                    $entityData['id'] = $dat['subCategoryId']['$oid'];
                    $entityData['title'] = $dat['subSubCategoryName']['en'];
                    array_push($entitiesData, $entityData);
                }

                echo json_encode(array('data' => $entitiesData));
            } else {
                $entities = array();
                $entities = '<option value="">Select sub-sub category</option>';
                $entities .= '<option data-name="" value="">' . 'No product to select' . '</option>';
                echo $entities;
            }

        }

      }          
           

/*insert str*/
    function AddNewOffersData() {
        
        $data = $_POST;        
        $data['createdOn'] = strtotime($data['current_dt']);
        $data['startDateTimeISO'] = strtotime($data['startDate'].' '.$data['starttime']);
        $data['endDateTimeISO'] = strtotime($data['endDate'].' '.$data['endtime']);
        $data['status'] = 0;
        $data['statusString'] = "New";
        
        //offerType
        if($data['offerType'] == 0){
            $data['offerTypeString'] = "Flat Discount";
        }
        else if($data['offerType'] == 1){
            $data['offerTypeString'] = "Percentage Discount";
        }
        else if($data['offerType'] == 2){
            $data['offerTypeString'] = "Combo";
        }
        // applicableOn
        if($data['applicableOn'] == 0){
            $data['applicableOnStatus'] = "Product";
        }
        else if($data['applicableOn'] == 1){
            $data['applicableOnStatus'] = "Unit";
        }
        else if($data['applicableOn'] == 2){
            $data['applicableOnStatus'] = "Category";
        }
        else if($data['applicableOn'] == 3){
            $data['applicableOnStatus'] = "Sub Category";
        }
        else if($data['applicableOn'] == 4){
            $data['applicableOnStatus'] = "Sub-Sub Category";
        }
        
        $data['zones'] = $data['serviceZones'];
        $data['minimumPurchaseQty'] = (float)$data['minimumPurchaseQuantity'];
        $data['globalUsageLimit'] = (float)$data['globalUsageLimit'];
        $data['percentageDiscount'] = (float)$data['percentageDiscount'];
        $data['flatDiscount'] = (float)$data['flatDiscount'];      
        $data['perUserLimit'] = (int)$data['perUserLimit'];
        $data['termscond'] = $data['termscond'];       
        
        unset($data['serviceZones'],$data['current_dt'],$data['startDate'],$data['start_timepicker'],$data['endDate'],$data['end_timepicker'],$data['hour'],$data['minute']);
    
        
 
    $url=ProductOffers."createOffers/";
    $response = json_decode($this->callapi->CallAPI('POST',$url,array('data' => $data, 'flag' => 0)),true);
    $valu = json_decode($response,true);
    foreach($valu["Rejected"] as $value){
        $valueData[] =  $value;
    }
       curl_close($curl);
        
        $cursor = $this->mongo_db->get("brands");
        $arr = [];
        $arrName = [];
        foreach ($cursor as $cdata) {
            array_push($arr, $cdata['seqId']);
            array_push($arrName, $cdata['brandName'][0]);
        }
        $max = max($arr);
        $data['seqId'] = $max + 1;
        $data['status'] = 0;
        $data['statusMsg'] = 'New';

        if (!in_array($data['brandName'][0], $arrName)) {
            $data = $this->mongo_db->insert('brands', $data);
          
        } 
      
        if ( $valueData != "") {
            echo json_encode(array('data' =>$valueData, 'flag' => 1));
        } else {
            echo json_encode(array('data' =>$valueData, 'flag' => 0));
            
         }

    }

function editNewOffersData() {

    $data = $_POST; 
    // print_r($data);die;
    $data['createdOn'] = strtotime($data['current_dt']);
    $data['startDateTimeISO'] = strtotime($data['startDate'].' '.$data['starttime']);
    $data['endDateTimeISO'] = strtotime($data['endDate'].' '.$data['endtime']);    
    $data['status'] = 0;
    $data['statusString'] = "New";    
    
    if($data['offerType'] == 0){
        $data['offerTypeString'] = "Flat Discount";
    }
    else if($data['offerType'] == 1){
        $data['offerTypeString'] = "Percent)ge Discount";
    }
    else if($data['offerType'] == 2){
        $data['offerTypeString'] = "Combo";
    }
    // applicableOn
    if($data['applicableOn'] == 0){
        $data['applicableOnStatus'] = "Product";
    }
    else if($data['applicableOn'] == 1){
        $data['applicableOnStatus'] = "Unit";
    }
    else if($data['applicableOn'] == 2){
        $data['applicableOnStatus'] = "Category";
    }
    else if($data['applicableOn'] == 3){
        $data['applicableOnStatus'] = "Sub Category";
    }
    else if($data['applicableOn'] == 4){
        $data['applicableOnStatus'] = "Sub-Sub Category";
    }
    
    $data['offerId']=$data['offerId'];

    $data['zones'] = $data['serviceZones'];
    $data['minimumPurchaseQty'] = (float)$data['minimumPurchaseQuantity'];
    $data['globalUsageLimit'] = (float)$data['globalUsageLimit'];
    $data['percentageDiscount'] = (float)$data['percentageDiscount'];
    $data['flatDiscount'] = (float)$data['flatDiscount'];
    $data['perUserLimit'] = (int)$data['perUserLimit'];
    $data['termscond'] = $data['termscond'];

    
    unset($data['serviceZones'],$data['current_dt'],$data['startDate'],$data['start_timepicker'],$data['endDate'],$data['end_timepicker'],$data['hour'],$data['minute']);

   // print_r($data);die;
    $curl = curl_init();
    curl_setopt_array($curl, array(
            CURLOPT_URL => ProductOffers."patchOffers/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PATCH",
            CURLOPT_POSTFIELDS => json_encode(array('data' => $data, 'flag' => 0)),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

  
    
    $response = curl_exec($curl);
    $err = curl_error($curl);

    $valu = json_decode($response,true);

    foreach($valu as $value){
        $valueData =  $value;
    }

    curl_close($curl);  
    $max = max($arr);
    $data['seqId'] = $max + 1;
    $data['status'] = 0;
    $data['statusMsg'] = 'New';

    echo json_encode(array('data' =>$valueData, 'flag' => 1));
    

}

    function updateOfferStatus($status, $offerIds)
            {  

                foreach($offerIds as $offerid){
                    $data_inside['offerId'] = $offerid;
                    $data_inside['status'] = (int) $status;
                    $data['data'] = $data_inside;
                    $url = ProductOffers . 'offerStatus/';
                    $response = json_decode($this->callapi->CallAPI('PATCH',$url, $data),true);
                   }
                   
                    return  $response;

            }

    function getBrand() {
        $Id = $this->input->post('Id');

        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->find_one('brands');

        return $data;
    }



    function editBrand() {
        $Id = $this->input->post('Id');
        $data = $_POST;

        unset($data['Id']);
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

        if (count($lanCodeArr) == count($data['brandName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['brandName']);
        } else if (count($lanCodeArr) < count($data['brandName'])) {
            $data['name']['en'] = $data['brandName'][0];

            foreach ($data['brandName'] as $key => $val) {
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
            $data['name']['en'] = $data['brandName'][0];
        }

        if (count($lanCodeArr) == count($data['brandDescription'])) {
            $data['description'] = array_combine($lanCodeArr, $data['brandDescription']);
        } else if (count($lanCodeArr) < count($data['brandDescription'])) {
            $data['description']['en'] = $data['brandDescription'][0];

            foreach ($data['brandDescription'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['description'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['description'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['description']['en'] = $data['brandDescription'][0];
        }

        try {
            $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->set($data)->update('brands');
        } catch (Exception $ex) {
            print_r($ex);
        }
        echo json_encode($data);
    }

    function activateBrand() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1, 'statusMsg' => "Active"))->update('brands');
        }

        echo json_encode(array("msg" => "Selected brand has been activated successfully", "flag" => 0));
    }

    function deactivateBrand() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 0, 'statusMsg' => "Inactive"))->update('brands');
        }

        echo json_encode(array("msg" => "Selected brand has been deactivated successfully", "flag" => 0));
    }

    /*fetch all details*/
    function offer_details($status, $offset, $limit,$cityId = '', $name = '',$stDate = '', $enDate = ''){
      
       
       
        $stDateData = strtotime($stDate . '00:00:00');
        $enDateData = strtotime($enDate . '23:59:59'); 
      

        $offset=$_POST['iDisplayStart'];
        $limit=$_POST['iDisplayLength'];
       
        $reqArr = array('status' =>(int)$status,'skip'=>(int)$offset,'limit'=>(int)$limit);

        if($cityId != ''){
            $reqArr['cityId'] = $cityId;
        }
        if($name != ''){
            $reqArr['name'] = $name;
        }
        if($stDate != ''){
            $reqArr['startDate'] = $stDateData;
        }
        if($enDate != ''){
            $reqArr['endDate'] = $enDateData;
        }
    
        $url= ProductOffers."offersFilter/";
        $response = json_decode($this->callapi->CallAPI('POST',$url,$reqArr),true);
        return $response;
        
 }



function getClaimdDetailsByCampaignId($campaignId,$stDate='',$enDate=''){
    $stDateData = strtotime($stDate . '00:00:00');
    $enDateData = strtotime($enDate . '23:59:59');    
    $url = ProductOffers . "listredemptions/". $campaignId;    
    $response = json_decode($this->callapi->CallAPI('GET',$url, ''),true);    
    return  $response;
 }


}

?>
