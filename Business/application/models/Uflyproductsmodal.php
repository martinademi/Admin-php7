<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Uflyproductsmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables1');
        $this->load->library('table');
        $this->load->library('utility_library');
        $this->load->library('CallAPI');
    }

	 
    function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->where(array('Active'=>1))->get('lang_hlp');
        } else {
            $res = $this->mongo_db->where(array('lan_id' => (int) $param), array('Active' => 1))->get('lang_hlp');
        }
        return $res;
    }

    //search product
    public function getProductsBySerach() {
        $this->load->library('mongo_db');
        $sSearch = $this->input->post('serachData');
      
        $sRegex = quotemeta($sSearch);
        $sRegex = '^'.$sRegex;
        $sRegex = "$sRegex";
        $searchTermsAny[] = array('productName' => new MongoDB\BSON\Regex($sRegex, "i"),'status'=>1);      
        $searchTerms = array();
        $searchTerms['$or'] = $searchTermsAny;  
      
        // echo '<pre>';
        // print_r(json_encode( $searchTerms ));
        // die;
        // chnags
        $mastersData =  $this->mongo_db->where($searchTerms)->select(array('productName'=>'productName'))->get('products');    
        echo json_encode(array('data'=>$mastersData));

    }

    function getCurrentStoreData($id) {
	
	
        $getStoreDetails = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->select(array("cityId"=>"cityId","serviceZones"=>"serviceZones","coordinates"=>"coordinates","sName"=>"sName","averageRating"=>"averageRating","storeCategory"=>"storeCategory","storeType"=>"storeType","storeTypeMsg"=>"storeTypeMsg","bannerLogos"=>"bannerLogos"))->find_one('stores');
        return $getStoreDetails;
    }

    function product_details() {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "productName";
        $_POST['mDataProp_1'] = "firstCategoryName";
        $_POST['mDataProp_2'] = "secondCategoryName";
        $_POST['mDataProp_3'] = "thirdCategoryName";


        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('products', array('status' => 1), 'seqId', -1);

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();

            $arr[] = $sl++;
            $arr[] = ($value['productName'] == "") ? "N/A":$value['productName'];
            $arr[] = ($value['firstCategoryName'] == "") ? "N/A":$value['firstCategoryName'];
            $arr[] = ($value['secondCategoryName'] == "") ? "N/A":$value['secondCategoryName'];
            $arr[] = ($value['thirdCategoryName'] == "") ? "N/A": $value['thirdCategoryName'];
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";


            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function getSymptoms(){
         
        $status=1;
        $result=$this->mongo_db->where(array( "status" => (int)$status))->get('symptom');
        return $result;

    }


    public function getGeneric(){
        
        $bizId = $this->session->userdata('badmin')['BizId'];
        $bizId = new MongoDB\BSON\ObjectID($bizId);
        $status=1;
        $result=$this->mongo_db->where(array( "status" => (int)$status,"storeId"=>$bizId))->select(array("Name"=>"productname"))->get('childProducts');
      
       
        return $result;

    }

    public function getBranded(){
         
        $bizId = $this->session->userdata('badmin')['BizId'];
        $bizId = new MongoDB\BSON\ObjectID($bizId);
        $status=1;
        $result=$this->mongo_db->where(array( "status" => (int)$status,"storeId"=>$bizId))->select(array("Name"=>"productname"))->get('childProducts');
        return $result;

    }


    //language
    function get_lan_hlpText($param = '') {
        $this->load->library('mongo_db');
        if ($param == '') {
            $res = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    //repo
    function product_detailsProducts() {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "productName";
        $_POST['mDataProp_1'] = "firstCategoryName";
        $_POST['mDataProp_2'] = "secondCategoryName";
        $_POST['mDataProp_3'] = "thirdCategoryName";


        $sl = $_POST['iDisplayStart'] + 1;

        //$respo = $this->datatables->datatable_mongodb('products', array('status' => 1), '');
        $respo = $this->datatables->datatable_mongodbAggregate('products', array(array('$match'=>array('status' => 1)),array('$sort'=>array('_id'=>-1))),
        array(array('$match'=>array('status' => 1)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1))))
    
    );

        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));

      //  echo '<pre>';print_r($respo);die;
        // print_r($respo['lang']);die;

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $id = (string)$value->_id;
            $value = json_decode(json_encode($value), TRUE);

            $value['_id']['$oid'] =   $id;
            $arr = array();

            $arr[] = $sl++;
          

           if(count($respo['lang'])<1){
               
            $productname=($value['pName']['en'] != "" || $value['pName']['en'] != null) ? $value['pName']['en']: 'N/A';
          
           }else{
            
            $productname=($value['pName']['en'] != "" || $value['pName']['en'] != null) ? $value['pName']['en']: 'N/A';

            foreach( $respo['lang'] as $lang){

                $lan= $lang['langCode'];
                $productnames=($value['pName'][$lan] != "" || $value['pName'][$lan] != null) ? $value['pName'][$lan]: '';
                
                
               if(strlen( $productnames)>0){
                $productname.= ',' . $productnames;
               }
            }


           }

            $arr[]=$productname;

            $arr[] = ($value['catName']['en'] != "") ? $value['catName']['en'] : 'N/A';
            $arr[] = ($value['subCatName']['en'] != "") ? $value['subCatName']['en'] : 'N/A';
            $arr[] = ($value['subSubCatName']['en'] != "") ? $value['subSubCatName']['en'] : 'N/A';
            $arr[] = '<a class="unitsList" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
            $arr[] = "<input type='checkbox' class='checkbox checkboxProduct'  id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function reorderProducts() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->find_one('childProducts');
        $Prevecountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->find_one('childProducts');

        $currcount = $Curruntcountval['seqId'];
        $prevcount = $Prevecountval['seqId'];
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->set(array('seqId' => $prevcount))->update('childProducts');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->set(array('seqId' => $currcount))->update('childProducts');
    }

    function getData($id = '') {
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('childProducts');
        return $data;
    }


    function getProductDataDetail($id = '') {
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('products');
        echo json_encode(array('data' => $data));
    }


   
    function getUnitsForStore($id = '') {
        
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('childProducts');
        $arr = array();
        $x = 0;
        foreach ($data['units'] as $result) {
          
            if ($result['status'] == "active") {

                $respo['lang'] = $this->mongo_db->where(array('Active' => 1))->get('lang_hlp');

                if(count($respo['lang'])<1){               
                    $unitname=($result['name']['en'] != "" || $result['name']['en'] != null) ? $result['name']['en']: 'N/A';
                    $unitprice=($result['price']['en'] != "" || $result['price']['en'] != null) ? $result['price']['en']: 'N/A';                    
                   }else{                    
                    $unitname=($result['name']['en'] != "" || $result['name']['en'] != null) ? $result['name']['en']: 'N/A';            
                    $unitprice=($result['price']['en'] != "" || $result['price']['en'] != null) ? $result['price']['en']: 'N/A';                    
                    foreach( $respo['lang'] as $lang){        
                        $lan= $lang['langCode'];
                        $unitnames=($result['name'][$lan] != "" || $result['name'][$lan] != null) ? $result['name'][$lan]: '';     
                        $unitprices=($result['price'][$lan] != "" || $result['price'][$lan] != null) ? $result['price'][$lan]: 'N/A';                                     
                       if(strlen(  $unitnames)>0){
                        $unitname.= ',' . $unitnames;
                       }
                       if(strlen(  $unitprice)>0){
                        $unitprice.= ',' . $unitprices;
                       }

                    }
                 }

               

                $arr[$x]['title'] = $unitname ;
                $arr[$x]['value'] = $unitprice ;
                $x++;
            }
        }
        echo json_encode(array('data' => $arr));
    }

    // Addon detail
    function getAddonForStore($id = '') {
        //repo
    $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('childProducts');
  
    $arr = array();
    $x = 0;
    foreach ($data['addOnIds'] as $id) {

        $addOnName = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('addOns');    
        $arr[$x]['title'] = $addOnName['name']['en'] ;
        $x++;
    }
    echo json_encode(array('data' => $arr));
}



    function savealltext() {
        $imageid = $this->input->post('imageid');
        $seq = $this->input->post('seq');
        $id = $this->input->post('id');
        $imgText = $this->input->post('imgText');
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $keyword = $this->input->post('keyword');

        $arr = array('images.$.imageText' => $imgText,
            'images.$.title' => $title,
            'images.$.description' => $description,
            'images.$.keyword' => $keyword,
        );

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id), 'images.imageId' => (string) $imageid))->set($arr)->update('childProducts');

        return $result;
    }

    function updateProductData($id = '') {

        
        $addon=$this->input->post('addOnIds');
       
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

        $sizes = array();
        $colors = array();
        $taxes = array();

        foreach ($_POST['size'] as $sizeids) {
            $sizeData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($sizeids)))->find_one('sizeGroup');
            $sizes[] = array('sizeId' => $sizeids, 'sizeName' => $sizeData['sizeName'][0]);
        }
        foreach ($_POST['color'] as $colorId) {
            $colorData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($colorId)))->find_one('colors');
            $colors[] = array('colorId' => $colorId, 'colorName' => $colorData['name'][0]);
        }

        $_POST['storeId'] = (string) $this->session->userdata('badmin')['BizId'];
        $getStoreData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($_POST['storeId'])))->find_one('stores');
        $_POST['cityId'] = $getStoreData['cityId'];
		 $_POST['store'] = $getStoreData['sName'];
          $_POST['storeName'] = array($getStoreData['sName']);
          unset($_POST['storeName']);

        $getCityData = $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($_POST['cityId'])))->find_one('cities');
        foreach ($getCityData['cities'] as $cities)
            if ($_POST['cityId'] == $cities['cityId']['$oid']) {
                $taxdetails = $cities['taxDetails'];
            }

        if ($_POST['tax']) {
            foreach ($_POST['tax'] as $taxId) {
                $taxData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($taxId)))->find_one('taxes');

                $taxes[] = array('taxId' => $taxId, 'taxname' => $taxData['name'], 'taxCode' => $taxData['taxCode'], 'taxValue' => $taxData['taxValue']);
            }

            $count = count($_POST['tax']);
            for ($i = 0; $i < $count; $i++) {
                $taxes[$i]['taxFlag'] = (int) $_POST['taxFlag'][$i];
                if ($taxes[$i]['taxFlag'] == 0) {
                    $taxes[$i]['taxMsg'] = 'Inclusive';
                } else if ($taxes[$i]['taxFlag'] == 1) {
                    $taxes[$i]['taxMsg'] = 'Exclusive';
                }
            }
        }

        


        $_POST['sizes'] = $sizes;
        $_POST['colors'] = $colors;
        $_POST['taxes'] = $taxes;
        
        $_POST['categoryName'] = explode(',', $_POST['firstCategoryName']);
        $_POST['subCategoryName'] = explode(',', $_POST['secondCategoryName']);
        $_POST['subSubCategoryName'] = explode(',', $_POST['thirdCategoryName']);


        if (count($lanCodeArr) == count($_POST['categoryName'])) {
            $_POST['catName'] = array_combine($lanCodeArr, $_POST['categoryName']);
        } else if (count($lanCodeArr) <> count($_POST['categoryName'])) {
            $_POST['catName']['en'] = $_POST['categoryName'][0];

            foreach ($_POST['categoryName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $_POST['catName'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $_POST['catName'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $_POST['catName']['en'] = $_POST['categoryName'][0];
        }
        if (count($lanCodeArr) == count($_POST['subCategoryName'])) {
            $_POST['subCatName'] = array_combine($lanCodeArr, $_POST['subCategoryName']);
        } else if (count($lanCodeArr) <> count($_POST['subCategoryName'])) {
            $_POST['subCatName']['en'] = $_POST['subCategoryName'][0];

            foreach ($_POST['subCategoryName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $_POST['subCatName'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $_POST['subCatName'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $_POST['subCatName']['en'] = $_POST['subCategoryName'][0];
        }
        if (count($lanCodeArr) == count($_POST['subSubCategoryName'])) {
            $_POST['subSubCatName'] = array_combine($lanCodeArr, $_POST['subSubCategoryName']);
        } else if (count($lanCodeArr) <> count($_POST['subSubCategoryName'])) {
            $_POST['subSubCatName']['en'] = $_POST['subSubCategoryName'][0];

            foreach ($_POST['subSubCategoryName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $_POST['subSubCatName'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $_POST['subSubCatName'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $_POST['subSubCatName']['en'] = $_POST['subSubCategoryName'][0];
        }

        if (count($lanCodeArr) == count($_POST['POSName'])) {
            $_POST['pos'] = array_combine($lanCodeArr, $_POST['POSName']);
        } else if (count($lanCodeArr) <> count($_POST['POSName'])) {
            $_POST['pos']['en'] = $_POST['POSName'][0];

            foreach ($_POST['POSName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $_POST['pos'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $_POST['pos'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $_POST['pos']['en'] = $_POST['POSName'][0];
        }
        $i = 0;
      //  $_POST['sDescription']['en'] = $_POST['shortDescription'][0];
        $_POST['POSNam'] = array_values($_POST['POSName']);
       // $_POST['detailDescription']['en'] = $_POST['detailedDescription'][0];
      //  $_POST['shortDescription'] = $_POST['shortDescription'][0];
        //$_POST['detailedDescription'] = $_POST['detailedDescription'][0];
        $_POST['POSName'] = $_POST['POSName'][0];

        
// shortt Desc
            if (count($lanCodeArr) == count($_POST['shortDescription'])) {
                $_POST['sDescription'] = array_combine($lanCodeArr, $_POST['shortDescription']);               
            } else if (count($lanCodeArr) <> count($_POST['shortDescription'])) {
                $_POST['sDescription']['en'] = $_POST['shortDescription'][0];

                foreach ($_POST['shortDescription'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $_POST['sDescription'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $_POST['sDescription'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $_POST['sDescription']['en'] = $_POST['shortDescription'][0];
            }

            $_POST['shortDescription'] =$_POST['shortDescription'][0];

// Detail desc
            
            if (count($lanCodeArr) == count($_POST['detailedDescription'])) {
                $_POST['detailDescription'] = array_combine($lanCodeArr, $_POST['detailedDescription']);               
            } else if (count($lanCodeArr) <> count($_POST['detailedDescription'])) {
                $_POST['detailDescription']['en'] = $_POST['detailedDescription'][0];

                foreach ($_POST['detailDescription'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $_POST['detailDescription'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $_POST['detailDescription'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $_POST['detailDescription']['en'] = $_POST['detailedDescription'][0];
            }


            $_POST['detailedDescription'] = $_POST['detailedDescription']['en'];
        

        unset($_POST['color'], $_POST['size'], $_POST['tax'], $_POST['taxFlag']);
        unset($_POST['colorData'], $_POST['colorName'], $_POST['color'], $_POST['sizeName'], $_POST['sizeData']);

        $data = $_POST;
            // echo '<pre>';print_r($data);die;
        foreach ($data['units'] as $res) {
            
            $addonNew=json_decode($res['addOns'],true);         
            $addGroupId = [];
            $addOnIdArray=[];
            $addOnFinalArray = [];

            foreach( $addonNew as $addOnID){
                if(!isset($addOnIdArray[$addOnID['groupID']])){
                    $addOnIdArray[$addOnID['groupID']] = [
                        'gid' => $addOnID['groupID'],
                        'aid' => [$addOnID['addOnId']],
                        'price' => [$addOnID['price']]
                    ];
                } else {
                    $addOnIdArray[$addOnID['groupID']]['aid'][] = $addOnID['addOnId'];
                     $addOnIdArray[$addOnID['groupID']]['price'][] = $addOnID['price'];
                }
            }
          
            foreach($addOnIdArray as $idaddOn => $value){ 
                $storeAddOnData = $this->mongo_db->where(array("_id"=> new MongoDb\BSON\ObjectID($idaddOn)))->find_one('storeAddOns');
                $storeAddOnDataDB = $storeAddOnData;
                $storeAddOnData['addOns'] = [];
                foreach($storeAddOnDataDB['addOns'] as $key => $addOnDataDB){
                    if(array_search($addOnDataDB['id'], $value['aid']) !== false){
                        $ind = array_search($addOnDataDB['id'], $value['aid']);
                        $addOnDataDB['price'] = $value['price'][$ind];
                        $storeAddOnData['addOns'][] = $addOnDataDB;
                    }
                } 
                
                $unitAddOnId=(string)$storeAddOnData['_id']['$oid'];
                $storeAddOnData['unitAddOnId']= $unitAddOnId;
                unset($storeAddOnData['_id']);
                $addOnFinalArray[] = $storeAddOnData;
            }

            if ($res['name'] != "" && $res['price'] != "") {
                if (!$res['unitId']) {
                    $da = new MongoDB\BSON\ObjectID();
                    $res['unitId'] = (string) $da;
                } else {
                    $res['unitId'] = (string) ($res['unitId']);
                }
                $res['status'] = "active";
                $res['price'] = $res['price'];
                $res['floatValue'] = (float) $res['price']['en'];
                $res['availableQuantity'] = (int)$res['availableQuantity'];
                $res['addOns']=$addOnFinalArray;


                $sizeAttrs = array();

                foreach ($res['sizeAttr'] as $attrids) {  // loop through each id
                    for ($i = 1;; $i++) {
                        $sizedata = $this->mongo_db->where(array('sizeAttr.' . $i . '.attrId' => new MongoDB\BSON\ObjectID($attrids)))->find_one('sizeGroup');
                        // check for success case and break the loop    
                        if ($sizedata) {
                            foreach ($lanCodeArr as $code) {
                                $sizear['attribute'][$code] = $sizedata['sizeAttr'][$i][$code];
                            }
                            $sizeAttrs[] = array('attrId' => $attrids, 'attribute' => $sizear['attribute']);
                            break;
                        }
                    }
                }

                $res['sizeAttributes'] = $sizeAttrs;
                unset($res['sizeAttr']);

                $data1[] = $res;
            }
        }
        $data['units'] = $data1;

        if ($data['strainEffects']['relaxed'] != '') {
            $data['strainEffects']['relaxed'] = (float) number_format($data['strainEffects']['relaxed'], 2);
        }else {
            $data['strainEffects']['relaxed'] = 0.00;
        }

        if ($data['strainEffects']['happy'] != '') {
            $data['strainEffects']['happy'] = (float) number_format($data['strainEffects']['happy'], 2);
        }else {
            $data['strainEffects']['happy'] = 0.00;
        }

        if ($data['strainEffects']['euphoric'] != '') {
            $data['strainEffects']['euphoric'] = (float) number_format($data['strainEffects']['euphoric'], 2);
        } else {
            $data['strainEffects']['euphoric'] = 0.00;
        }

        if ($data['strainEffects']['uplifted'] != '') {
            $data['strainEffects']['uplifted'] = (float) number_format($data['strainEffects']['uplifted'], 2);
        }else {
            $data['strainEffects']['uplifted'] = 0.00;
        }

        if ($data['strainEffects']['creative'] != '') {
            $data['strainEffects']['creative'] = (float) number_format($data['strainEffects']['creative'], 2);
        } else {
            $data['strainEffects']['creative'] = 0.00;
        }

        if ($data['medicalAttributes']['stress'] != '') {
            $data['medicalAttributes']['stress'] = (float) number_format($data['medicalAttributes']['stress'], 2);
        }else {
            $data['medicalAttributes']['stress'] = 0.00;
        }

        if ($data['medicalAttributes']['depression'] != '') {
            $data['medicalAttributes']['depression'] = (float) number_format($data['medicalAttributes']['depression'], 2);
        } else {
            $data['medicalAttributes']['depression'] = 0.00;
        }

        if ($data['medicalAttributes']['pain'] != '') {
            $data['medicalAttributes']['pain'] = (float) number_format($data['medicalAttributes']['pain'], 2);
        }else {
            $data['medicalAttributes']['pain'] = 0.00;
        }

        if ($data['medicalAttributes']['headaches'] != '') {
            $data['medicalAttributes']['headaches'] = (float) number_format($data['medicalAttributes']['headaches'], 2);
        }else {
            $data['medicalAttributes']['headaches'] = 0.00;
        }

        if ($data['medicalAttributes']['fatigue'] != '') {
            $data['medicalAttributes']['fatigue'] = (float) number_format($data['medicalAttributes']['fatigue'], 2);
        }else {
            $data['medicalAttributes']['fatigue'] = 0.00;
        }

        if ($data['negativeAttributes']['dryMouth'] != '') {
            $data['negativeAttributes']['dryMouth'] = (float) number_format($data['negativeAttributes']['dryMouth'], 2);
        }else {
            $data['negativeAttributes']['dryMouth'] = 0.00;
        }

        if ($data['negativeAttributes']['dryEyes'] != '') {
            $data['negativeAttributes']['dryEyes'] = (float) number_format($data['negativeAttributes']['dryEyes'], 2);
        }else {
            $data['negativeAttributes']['dryEyes'] = 0.00;
        }

        if ($data['negativeAttributes']['anxious'] != '') {
            $data['negativeAttributes']['anxious'] = (float) number_format($data['negativeAttributes']['anxious'], 2);
        }else {
            $data['negativeAttributes']['anxious'] = 0.00;
        }

        if ($data['negativeAttributes']['paranoid'] != '') {
            $data['negativeAttributes']['paranoid'] = (float) number_format($data['negativeAttributes']['paranoid'], 2);
        } else {
            $data['negativeAttributes']['paranoid'] = 0.00;
        }

        if ($data['negativeAttributes']['dizzy'] != '') {
            $data['negativeAttributes']['dizzy'] = (float) number_format($data['negativeAttributes']['dizzy'], 2);
        }else {
            $data['negativeAttributes']['dizzy'] = 0.00;
        }

        $productName = implode(',', $data['productName']);
        $itemKey = str_replace(' ', '-', $productName);
        $data['itemKey'] = str_replace('/', '-', $itemKey);
        // $data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $data['firstCategoryId'] . '.xml';
        $data['fileName'] = dirname(__DIR__)."/../../../xml/" . $data['firstCategoryId'] . '.xml';
        $pdetails = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('products');

        $this->load->model('Seomodel');
        if ($pdetails['itemKey']) {
            $url = $pdetails['itemKey'] . "/" . (string) $pdetails['_id'];
            $this->Seomodel->removeContentSitemap($url, $pdetails['fileName']);
            $url = $itemKey . "/" . (string) $id;
            $this->Seomodel->addContentSitemap($url, $data['fileName']);
        }

        $imagearr = [];
        foreach ($data['images'] as $images) {
            $images['imageId'] = (string) ($images['imageId']);
            $images = $images;
            array_push($imagearr, $images);
        }

        $data['images'] = $imagearr;
        $data['productId'] = $id;


        if (count($lanCodeArr) == count($data['productName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['productName']);
        } else if (count($lanCodeArr) <> count($data['productName'])) {
            $data['name']['en'] = $data['productName'][0];

            foreach ($data['productName'] as $key => $val) {
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
            $data['name']['en'] = $data['productName'][0];
        }

      
       
        unset($data['addOnIds']);
       $date = new DateTime();
     
        $addOnDetails=[];
        $addOnunique=[];
        $tempaddOnunique = [];
        foreach($addon as $addOnData){
            $addOnunique =  [];
         
            $id=$addOnData;           
            $storeAddOnData=$this->mongo_db->where(array("_id"=> new MongoDb\BSON\ObjectID($id)))->find_one('storeAddOns');
           
            $storeAddOnData['id']=$storeAddOnData['_id']['$oid'];
          
            foreach($storeAddOnData['addOns'] as $uniqueAddonId){ 
              
              //  $uniqueAddonId['storeAddOnId']= $uniqueAddonId['id']['$oid'];
              $uniqueAddonId['storeAddOnId']= $uniqueAddonId['id'];
                unset($uniqueAddonId['id']);
                $uniqueAddonId['id']=(string)new MongoDB\BSON\ObjectID();

                array_push($addOnunique,$uniqueAddonId);
            }
            
            unset($storeAddOnData['isoDate']);
         //   $storeAddOnData['isoDate']= $this->mongo_db->date();
            $storeAddOnData['timeStamp']=$date->getTimestamp();
            unset($storeAddOnData['_id']); 
            $storeAddOnData['addOns'] = $addOnunique;           
            array_push($addOnDetails,(object)$storeAddOnData);              
                
        }

        $storeId = $this->session->userdata('badmin')['BizId']; 
        $getStoreData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($storeId)))->find_one('stores');
     
        $data['storeLatitude'] =(double) $getStoreData['coordinates']['latitude'];
        $data['storeLongitude'] = (double) $getStoreData['coordinates']['longitude'];
        
        $data['storeType'] = $getStoreData['storeType'];
        $data['storeTypeMsg'] = $getStoreData['storeTypeMsg'];
        $data['storeCategoryId'] = $getStoreData['storeCategory'][0]['categoryId'];
        $data['storeCategoryName'] =(object) $getStoreData['storeCategory'][0]['categoryName']; 
        $data['storeLogoImage'] =  $getStoreData['bannerLogos']['bannerimage']  ;
      
        //echo '<pre>';print_r( $data);die;
       
         $data['addOns'] = $addOnDetails;  
         $data['productName'] = array_values($_POST['productName']);

         $storeType = $this->session->userdata('badmin')['storeType'];
        if($storeType==6 || $storeType=="6" ){
           $data['rx']=$_POST['rx'];
           $data['soldOnline']=$_POST['soldOnline'];
           $data['prescriptionRequired']=$_POST['prescriptionRequired'];
           $data['productType']=$_POST['productType'];
           //$data['serialNumber']=$_POST['serialNumber'];
           //$data['symptoms']=(array)$_POST['symptoms'];
           $data['professionalUsageFile']=$_POST['professionalUsageFile'];
           $data['personalUsageFile']=$_POST['personalUsageFile']; 


           if(!isset($data['symptoms'])){

            $data['symptoms']=[];
        }
           
                    if($data['rx']==1 || $data['rx'] == "1"){
                        $data['rx'] = TRUE;
                    }else{
                        $data['rx'] = FALSE;
                    }
                    
                    if($data['soldOnline']==1 || $data['soldOnline'] == "1"){
                        $data['soldOnline'] = TRUE;
                    
                    }else{
                        $data['soldOnline'] = FALSE;
                    
                    }

                    if($data['productType']==1 || $data['productType']=="1" ){
                        $data['productType']=1;
                        $data['productTypeMsg']="Generic";
                    }else{
                        $data['productType']=2;
                        $data['productTypeMsg']="Branded";
                    }

                    if($data['prescriptionRequired']==1 || $data['prescriptionRequired']=="1" ){
                        $data['prescriptionRequired']=TRUE;            
                    }else{
                        $data['prescriptionRequired']=FALSE;            
                    }

        }else{
                
        }

        $consumptionTime=$_POST['consumptionTime'];
        
        if(count($consumptionTime)){
            foreach($consumptionTime as $cTime){
                $consumptionArr[$cTime]=TRUE;              
            }
        }else{
            $array = array();
            $consumptionArr =(object)$array;
        }

       $data['consumptionTime']=$consumptionArr;

        // call node api to add product
        $fields = $data;  
    //    echo '<pre>';print_r( $fields); die;    
       
        $fields = json_encode($fields);
       
        $headers = array(
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, APILink .'child/product');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
    //    echo '<pre>';print_r( $result);die; 
    
        curl_close($ch);
        return $result;
    }

    public function getUnitsEdit($id) {

        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('childProducts');

        echo json_encode(array('result' => $res['units'], 'data' => $res['images']));
    }

    function delete_product() {
        $id = $this->input->post('val');

        $fields = implode(',', $id);
        $fields = json_encode($fields);
        $headers = array(
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, APILink.'child/product/' .$fields);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        curl_close($ch);
        echo json_encode($result);
    }

    function getAppConfigData() {
        $data = $this->mongo_db->get('appConfig');
        foreach ($data as $result) {
            $res = $result['currencySymbol'];
        }
        return $res;
    }

    public function getProductData() {

        $res = $this->mongo_db->get('products');

        return $res;
    }

    public function getActiveColors() {

        $res = $this->mongo_db->where(array('status' => 1))->get('colors');

        return $res;
    }

    public function getActiveSize() {

        $res = $this->mongo_db->where(array('status' => 1))->get('sizeGroup');

        return $res;
    }

    public function getManufacturer() {

        $res = $this->mongo_db->get('manufacturer');

        return $res;
    }

    public function getBrands() {

        $res = $this->mongo_db->get('storeBrands');
        return $res;
    }

    public function getTaxData($storeId) {
        $storeData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($storeId)))->find_one('stores');
       
        $res = $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($storeData['cityId'])))->get('cities');
//        $res = $this->mongo_db->where(array('cities.cityId' => $storeData['cityId']))->get('taxes');

        foreach ($res as $r) {
            foreach ($r['cities'] as $taxData) {
                if ($storeData['cityId'] == $taxData['cityId']['$oid']) {
                    $arr = $taxData['taxDetails'];
                }
            }
        }

        return $arr;
    }

    function AddNewProductData($postData, $category) {
       
    
            $addon=$postData['addOnIds'];        
            $lang = $this->mongo_db->where(array("Active"=>1))->get('lang_hlp');
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

            $sizes = array();
            $colors = array();
            $taxes = array();

            if ($postData['brand']) {
                $brandData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($postData['brand'])))->find_one('storeBrands');
                $postData['brandTitle'] = $brandData['name'];
            }

            if ($postData['size']) {
                foreach ($postData['size'] as $sizeids) {
                    $sizeData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($sizeids)))->find_one('sizeGroup');
                    $sizes[] = array('sizeId' => $sizeids, 'size' => $sizeData['name']);
                }
            }
            if ($postData['color']) {
                foreach ($postData['color'] as $colorId) {
                    $colorData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($colorId)))->find_one('colors');
                    $colors[] = array('colorId' => $colorId, 'color' => $colorData['colorName']);
                }
            }


            $consumptionTime=$postData['consumptionTime'];

            if(count($consumptionTime)){
                foreach($consumptionTime as $cTime){
                    $consumptionArr[$cTime]=TRUE;
                  
                }
            }else{
                $array = array();
                $consumptionArr =(object)$array;
            }
    
            $postData['consumptionTime']=$consumptionArr;



            $postData['sizes'] = $sizes;
            $postData['colors'] = $colors;
            $postData['categoryName'] = explode(',', $postData['firstCategoryName']);
            $postData['subCategoryName'] = explode(',', $postData['secondCategoryName']);
            $postData['subSubCategoryName'] = explode(',', $postData['thirdCategoryName']);

            if (count($lanCodeArr) == count($postData['categoryName'])) {
                $postData['catName'] = array_combine($lanCodeArr, $postData['categoryName']);
            } else if (count($lanCodeArr) <> count($postData['categoryName'])) {
                $postData['catName']['en'] = $postData['categoryName'][0];

                foreach ($postData['categoryName'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $postData['catName'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $postData['catName'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $postData['catName']['en'] = $postData['categoryName'][0];
            }
            if (count($lanCodeArr) == count($postData['subCategoryName'])) {
                $postData['subCatName'] = array_combine($lanCodeArr, $postData['subCategoryName']);
            } else if (count($lanCodeArr) <> count($postData['subCategoryName'])) {
                $postData['subCatName']['en'] = $postData['subCategoryName'][0];

                foreach ($postData['subCategoryName'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $postData['subCatName'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $postData['subCatName'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $postData['subCatName']['en'] = $postData['subCategoryName'][0];
            }
            if (count($lanCodeArr) == count($postData['subSubCategoryName'])) {
                $postData['subSubCatName'] = array_combine($lanCodeArr, $postData['subSubCategoryName']);
            } else if (count($lanCodeArr) <> count($postData['subSubCategoryName'])) {
                $postData['subSubCatName']['en'] = $postData['subSubCategoryName'][0];

                foreach ($postData['subSubCategoryName'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $postData['subSubCatName'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $postData['subSubCatName'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $postData['subSubCatName']['en'] = $postData['subSubCategoryName'][0];
            }
            // end cate, sub cate ,and sub sub cat

            if (count($lanCodeArr) == count($postData['POSName'])) {
                $postData['pos'] = array_combine($lanCodeArr, $postData['POSName']);
            } else if (count($lanCodeArr) <> count($postData['POSName'])) {
                $postData['pos']['en'] = $postData['POSName'][0];

                foreach ($postData['POSName'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $postData['pos'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $postData['pos'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $postData['pos']['en'] = $postData['POSName'][0];
            }

            $i = 0;
            $postData['POSNam'] =array_values( $postData['POSName']);
            $postData['POSName'] = $postData['POSName'][0];

            // shortt Desc
            if (count($lanCodeArr) == count($postData['shortDescription'])) {
                $postData['sDescription'] = array_combine($lanCodeArr, $postData['shortDescription']);               
            } else if (count($lanCodeArr) <> count($postData['shortDescription'])) {
                $postData['sDescription']['en'] = $postData['shortDescription'][0];

                foreach ($postData['shortDescription'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $postData['sDescription'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $postData['sDescription'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $postData['sDescription']['en'] = $postData['shortDescription'][0];
            }

            $postData['shortDescription'] =$_POST['shortDescription'][0];


            // Detail desc
            
            if (count($lanCodeArr) == count($postData['detailedDescription'])) {
                $postData['detailDescription'] = array_combine($lanCodeArr, $postData['detailedDescription']);               
            } else if (count($lanCodeArr) <> count($postData['detailedDescription'])) {
                $postData['detailDescription']['en'] = $postData['detailedDescription'][0];

                foreach ($postData['detailDescription'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $postData['detailDescription'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $postData['detailDescription'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $postData['detailDescription']['en'] = $postData['detailedDescription'][0];
            }

            $postData['detailedDescription'] = $_POST['detailedDescription'][0];

            unset($postData['color'], $postData['size']); // $postData['tax'], $postData['taxFlag']
            unset($postData['colorData'], $postData['colorName'], $postData['color'], $postData['sizeName'], $postData['sizeData']);

            $response = $postData;
            // $resONE = '';
        // }

        $count = count($response['units']);
        $x = 0;
        $y = 0;
        $a = 0;
        $b = 0;
        $xy = 1;

        foreach ($response['units'] as $res) {

            // cool12
            $addonNew=json_decode($res['addOns'],true);         
            $addGroupId = [];
            $addOnIdArray=[];
            $addOnFinalArray = [];

            foreach( $addonNew as $addOnID){
                if(!isset($addOnIdArray[$addOnID['groupID']])){
                    $addOnIdArray[$addOnID['groupID']] = [
                        'gid' => $addOnID['groupID'],
                        'aid' => [$addOnID['addOnId']],
                        'price' => [$addOnID['price']]
                    ];
                } else {
                    $addOnIdArray[$addOnID['groupID']]['aid'][] = $addOnID['addOnId'];
                     $addOnIdArray[$addOnID['groupID']]['price'][] = $addOnID['price'];
                }
            }
          
            foreach($addOnIdArray as $id => $value){ 
                $storeAddOnData = $this->mongo_db->where(array("_id"=> new MongoDb\BSON\ObjectID($id)))->find_one('storeAddOns');
                $storeAddOnDataDB = $storeAddOnData;
                $storeAddOnData['addOns'] = [];
                foreach($storeAddOnDataDB['addOns'] as $key => $addOnDataDB){
                    if(array_search($addOnDataDB['id'], $value['aid']) !== false){
                        $ind = array_search($addOnDataDB['id'], $value['aid']);
                        $addOnDataDB['price'] = $value['price'][$ind];
                        $storeAddOnData['addOns'][] = $addOnDataDB;
                    }
                } 
                
                $unitAddOnId=(string)$storeAddOnData['_id']['$oid'];
                $storeAddOnData['unitAddOnId']= $unitAddOnId;
                unset($storeAddOnData['_id']);
                $addOnFinalArray[] = $storeAddOnData;
            }     
            
            $response['units'][$a]['unitId'] = (string) new MongoDB\BSON\ObjectID();
            $response['units'][$a]['name'] = $res['name'];
            $response['units'][$a]['price'] = $res['price'];
            $response['units'][$a]['floatValue'] = (float) $res['price']['en'];
            // $response['units'][$a]['availableQuantity']=0;
            $response['units'][$a]['availableQuantity']=(int)$res['quantity']['en'];
            $response['units'][$a]['addOns']=$addOnFinalArray;
            $unitIdwithQty[$response['units'][$a]['unitId']] = (int)$res['quantity']['en'];
          
           
                $sizeAttrs = array();

                foreach ($response['units'][$a]['sizeAttr'] as $attrids) {  // loop through each id
                    for ($i = 1;; $i++) {
                        $sizedata = $this->mongo_db->where(array('sizeAttr.' . $i . '.attrId' => new MongoDB\BSON\ObjectID($attrids)))->find_one('sizeGroup');
                        // check for success case and break the loop    
                        if ($sizedata) {
                            foreach ($lanCodeArr as $code) {
                                $sizear['attribute'][$code] = $sizedata['sizeAttr'][$i][$code];
                            }
                            $sizeAttrs[] = array('attrId' => $attrids, 'attribute' => $sizear['attribute']);
                            break;
                        }
                    }
                }

                $response['units'][$a]['sizeAttributes'] = $sizeAttrs;
                $response['units'][$a]['status'] = "active";
                unset($response['units'][$a]['sizeAttr']);

                $a++;
            }
        // }
        $unitarr = $response['unitarr'];
        if ($unitarr) {

            foreach ($unitarr as $addnew) {

                if (count($lanCodeArr) == count($addnew['name'])) {
                    $response['units'][$count]['name'] = array_combine($lanCodeArr, $addnew['name']);
                } else if (count($lanCodeArr) <> count($addnew['name'])) {
                    $response['units'][$count]['name']['en'] = $addnew['name'][0];

                    foreach ($addnew['name'] as $key => $val) {
                        foreach ($lang as $lan) {

                            if ($lan['Active'] == 1) {
                                if ($key == $lan['lan_id']) {
                                    $response['units'][$count]['name'][$lan['langCode']] = $val;
                                }
                            } else {
                                if ($key == $lan['lan_id']) {
                                    $response['units'][$count]['name'][$lan['langCode']] = $val;
                                }
                            }
                        }
                    }
                } else {
                    $response['units'][$count]['name']['en'] = $addnew['name'][0];
                }

                if (count($lanCodeArr) == count($addnew['price'])) {
                    $response['units'][$count]['price'] = array_combine($lanCodeArr, $addnew['price']);
                } else if (count($lanCodeArr) <> count($addnew['price'])) {
                    $response['units'][$count]['price']['en'] = $addnew['price'][0];

                    foreach ($addnew['price'] as $key => $val) {
                        foreach ($lang as $lan) {

                            if ($lan['Active'] == 1) {
                                if ($key == $lan['lan_id']) {
                                    $response['units'][$count]['price'][$lan['langCode']] = $val;
                                }
                            } else {
                                if ($key == $lan['lan_id']) {
                                    $response['units'][$count]['price'][$lan['langCode']] = $val;
                                }
                            }
                        }
                    }
                } else {
                    $response['units'][$count]['price']['en'] = $addnew['price'][0];
                }

                $response['units'][$count]['floatValue'] = (float) $addnew['price'][0];
                $response['units'][$count]['unitId'] = (string) (new MongoDB\BSON\ObjectID());
                $response['units'][$count]['status'] = "active";

                $sizeAttrs = array();

                foreach ($addnew['sizeAttr'] as $attrids) {  // loop through each id
                    for ($i = 1;; $i++) {
                        $sizedata = $this->mongo_db->where(array('sizeAttr.' . $i . '.attrId' => new MongoDB\BSON\ObjectID($attrids)))->find_one('sizeGroup');
                        // check for success case and break the loop    
                        if ($sizedata) {
                            foreach ($lanCodeArr as $code) {
                                $sizear['attribute'][$code] = $sizedata['sizeAttr'][$i][$code];
                            }
                            $sizeAttrs[] = array('attrId' => $attrids, 'attribute' => $sizear['attribute']);
                            break;
                        }
                    }
                }

                $response['units'][$count]['sizeAttributes'] = $sizeAttrs;

                $x++;
                $count++;
            }
        }

        $data = $response;

        

        foreach ($data['images'] as $response) {
            $id = new MongoDB\BSON\ObjectID();
            $data['images'][$b]['imageId'] = (string) $id;
            $data['images'][$b]['imageText'] = '';
            $data['images'][$b]['title'] = '';
            $data['images'][$b]['description'] = '';
            $data['images'][$b]['keyword'] = '';
            $b++;
        };
        
        


        if ($data['strainEffects']['relaxed'] != '') {
            $data['strainEffects']['relaxed'] = (float) number_format($data['strainEffects']['relaxed'], 2);
        }else {
            $data['strainEffects']['relaxed'] = 0.00;
        }

        if ($data['strainEffects']['happy'] != '') {
            $data['strainEffects']['happy'] = (float) number_format($data['strainEffects']['happy'], 2);
        }else {
            $data['strainEffects']['happy'] = 0.00;
        }

        if ($data['strainEffects']['euphoric'] != '') {
            $data['strainEffects']['euphoric'] = (float) number_format($data['strainEffects']['euphoric'], 2);
        } else {
            $data['strainEffects']['euphoric'] = 0.00;
        }

        if ($data['strainEffects']['uplifted'] != '') {
            $data['strainEffects']['uplifted'] = (float) number_format($data['strainEffects']['uplifted'], 2);
        }else {
            $data['strainEffects']['uplifted'] = 0.00;
        }

        if ($data['strainEffects']['creative'] != '') {
            $data['strainEffects']['creative'] = (float) number_format($data['strainEffects']['creative'], 2);
        } else {
            $data['strainEffects']['creative'] = 0.00;
        }

        if ($data['medicalAttributes']['stress'] != '') {
            $data['medicalAttributes']['stress'] = (float) number_format($data['medicalAttributes']['stress'], 2);
        }else {
            $data['medicalAttributes']['stress'] = 0.00;
        }

        if ($data['medicalAttributes']['depression'] != '') {
            $data['medicalAttributes']['depression'] = (float) number_format($data['medicalAttributes']['depression'], 2);
        } else {
            $data['medicalAttributes']['depression'] = 0.00;
        }

        if ($data['medicalAttributes']['pain'] != '') {
            $data['medicalAttributes']['pain'] = (float) number_format($data['medicalAttributes']['pain'], 2);
        }else {
            $data['medicalAttributes']['pain'] = 0.00;
        }

        if ($data['medicalAttributes']['headaches'] != '') {
            $data['medicalAttributes']['headaches'] = (float) number_format($data['medicalAttributes']['headaches'], 2);
        }else {
            $data['medicalAttributes']['headaches'] = 0.00;
        }

        if ($data['medicalAttributes']['fatigue'] != '') {
            $data['medicalAttributes']['fatigue'] = (float) number_format($data['medicalAttributes']['fatigue'], 2);
        }else {
            $data['medicalAttributes']['fatigue'] = 0.00;
        }

        if ($data['negativeAttributes']['dryMouth'] != '') {
            $data['negativeAttributes']['dryMouth'] = (float) number_format($data['negativeAttributes']['dryMouth'], 2);
        }else {
            $data['negativeAttributes']['dryMouth'] = 0.00;
        }

        if ($data['negativeAttributes']['dryEyes'] != '') {
            $data['negativeAttributes']['dryEyes'] = (float) number_format($data['negativeAttributes']['dryEyes'], 2);
        }else {
            $data['negativeAttributes']['dryEyes'] = 0.00;
        }

        if ($data['negativeAttributes']['anxious'] != '') {
            $data['negativeAttributes']['anxious'] = (float) number_format($data['negativeAttributes']['anxious'], 2);
        }else {
            $data['negativeAttributes']['anxious'] = 0.00;
        }

        if ($data['negativeAttributes']['paranoid'] != '') {
            $data['negativeAttributes']['paranoid'] = (float) number_format($data['negativeAttributes']['paranoid'], 2);
        } else {
            $data['negativeAttributes']['paranoid'] = 0.00;
        }

        if ($data['negativeAttributes']['dizzy'] != '') {
            $data['negativeAttributes']['dizzy'] = (float) number_format($data['negativeAttributes']['dizzy'], 2);
        }else {
            $data['negativeAttributes']['dizzy'] = 0.00;
        }

        unset($data['status']);
        unset($data['seqId']);
        unset($data['current_dt']);

        if ($data['parentProductId']) {
            $data['parentProductId'] = (string) ($data['parentProductId']);
        } else {
            $data['parentProductId'] = '';
        }

        $productName = implode(',', $data['productName']);
        $itemKey = str_replace(' ', '-', $productName);
        $data['itemKey'] = str_replace('/', '-', $itemKey);
       

        if (count($lanCodeArr) == count($data['productName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['productName']);
        } else if (count($lanCodeArr) <> count($data['productName'])) {
            $data['name']['en'] = $data['productName'][0];

            foreach ($data['productName'] as $key => $val) {
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
            $data['name']['en'] = array_values($data['productName'][0]);
        }

        $data['storeId'] = (string) $data['storeId'];
	
	
        $getStoreData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['storeId'])))->find_one('stores');
		
        $data['cityId'] = $getStoreData['cityId'];
        $data['zoneId'] = $getStoreData['serviceZones'];
		
        $data['storeLatitude'] =(double) $getStoreData['coordinates']['latitude'];
        $data['storeLongitude'] = (double) $getStoreData['coordinates']['longitude'];
        $data['storeName'] = $getStoreData['name'];
        $data['store'] = $getStoreData['sName'];
        $data['storeAverageRating'] = '';

        $data['storeType'] = $getStoreData['storeType'];
        $data['storeTypeMsg'] = $getStoreData['storeTypeMsg'];
        $data['storeCategoryId'] = $getStoreData['storeCategory'][0]['categoryId'];
        $data['storeCategoryName'] =(object) $getStoreData['storeCategory'][0]['categoryName'];     
        $data['storeLogoImage'] =  $getStoreData['bannerLogos']['bannerimage']  ;
        
       $getCityData = $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($data['cityId'])))->find_one('cities');
        foreach ($getCityData['cities'] as $cities)
            if ($data['cityId'] == $cities['cityId']['$oid']) {
                $taxdetails = $cities['taxDetails'];

            }
			 $data['cityId'] =(string) $getStoreData['cityId'];
        if ($data['tax'] || $data['taxes']) {
            foreach ($data['tax'] as $taxId) {
                $taxData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($taxId)))->find_one('taxes');

                $taxes[] = array('taxId' => $taxId, 'taxname' => $taxData['name'], 'taxCode' => $taxData['taxCode'], 'taxValue' => $taxData['taxValue']);
            }

            $count = count($data['tax']);
            for ($i = 0; $i < $count; $i++) {
                $taxes[$i]['taxFlag'] = (int) $data['taxFlag'][$i];
                if ($taxes[$i]['taxFlag'] == 0) {
                    $taxes[$i]['taxMsg'] = 'Inclusive';
                } else if ($taxes[$i]['taxFlag'] == 1) {
                    $taxes[$i]['taxMsg'] = 'Exclusive';
                }
            }
        } else {
            $taxes = [];
        }
        $data['taxes'] = $taxes;
		 
		
        unset($data['tax'], $data['taxFlag']);

       
        if ($getStoreData['autoApproval'] == 0) {
            $data['status'] = 0;
        } else if ($getStoreData['autoApproval'] == 1) {
            $data['status'] = 1;
        }
        unset($data['addOnIds']);
        $date = new DateTime();
     
        $addOnDetails=[];
        $addOnunique=[];
        $tempaddOnunique = [];
        foreach($addon as $addOnData){
            $addOnunique =  [];
         
            $id=$addOnData;           
            $storeAddOnData=$this->mongo_db->where(array("_id"=> new MongoDb\BSON\ObjectID($id)))->find_one('storeAddOns');
           
            $storeAddOnData['id']=$storeAddOnData['_id']['$oid'];
          
            foreach($storeAddOnData['addOns'] as $uniqueAddonId){ 
              
              
              $uniqueAddonId['storeAddOnId']= $uniqueAddonId['id'];
                unset($uniqueAddonId['id']);
                $uniqueAddonId['id']=(string)new MongoDB\BSON\ObjectID();

                array_push($addOnunique,$uniqueAddonId);
            }
            
            unset($storeAddOnData['isoDate']);
            $storeAddOnData['timeStamp']=$date->getTimestamp();
            unset($storeAddOnData['_id']); 
            $storeAddOnData['addOns'] = $addOnunique;           
            array_push($addOnDetails,(object)$storeAddOnData);              
                
        }
      
        $data['addOns'] = $addOnDetails; 
     //  $data['costForTwo']=(float)$_POST['costForTwo'];
       $data['currencySymbol'] = $this->session->userdata('badmin')['currencySymbol'];
       $data['currency'] = $this->session->userdata('badmin')['CurrencyShortHand'];

  

        //changes made 
        unset($data['storeName']);

        $storeType = $this->session->userdata('badmin')['storeType'];
        if($storeType==6 || $storeType=="6" ){
     

                if(!isset($data['symptoms'])){

                    $data['symptoms']=[];
                }
                    if($data['rx']==1 || $data['rx'] == "1"){
                        $data['rx'] = TRUE;
                    }else{
                        $data['rx'] = FALSE;
                    }
                    
                    if($data['soldOnline']==1 || $data['soldOnline'] == "1"){
                        $data['soldOnline'] = TRUE;
                    
                    }else{
                        $data['soldOnline'] = FALSE;
                    
                    }

                    if($data['productType']==1 || $data['productType']=="1" ){
                        $data['productType']=1;
                        $data['productTypeMsg']="Generic";
                    }else{
                        $data['productType']=2;
                        $data['productTypeMsg']="Branded";
                    }

                    if($data['prescriptionRequired']==1 || $data['prescriptionRequired']=="1" ){
                        $data['prescriptionRequired']=TRUE;            
                    }else{
                        $data['prescriptionRequired']=FALSE;            
                    }

        }
      
           $data['_id'] = (string) new MongoDB\BSON\ObjectID();

           // echo "<pre>";print_r($data) ;die;
         
            $resArray=array();
           $url = APILink .'child/product';        
           $response1 = json_decode($this->callapi->CallAPI('POST', $url, $data), true);     
        //    echo '<pre>';print_r($response1);die;

        //    if($response1['statusCode'] == 200){
        //     $storeType = (int)$this->session->userdata('badmin')['storeType'];
        //         if($storeType && $storeType != 1){
        //             $productId=$response1['data']['lastErrorObject']['upserted'];
        //             $invurl = APILink . 'child/product/quantity';
        //         foreach($unitIdwithQty as $unitId=>$qty){
        //             $invData['productId']=$productId;
        //             $invData['unitId']=$unitId;
        //             $invData['quantity']=$qty;
        //             $invData['triggerType']=1;
        //             $invResponse = json_decode($this->callapi->CallAPI('PATCH', $invurl, $invData), true);
        //             $resArray=$invResponse;
        //           }
        //         }
            
        // }
            // print_r($resArray);
            return true;
    }

    function newProductData($storeId = '') {

        $this->load->library('elasticsearch');
        $cursor = $this->mongo_db->get('childProducts');
        $arr = [];

        foreach ($cursor as $catdata) {
            array_push($arr, $catdata['seqId']);
        }
        $max = max($arr);
        $seq = $max + 1;
        $x = 0;
        $data = $_POST;
        $data['storeId'] = new MongoDB\BSON\ObjectID($storeId);
        foreach ($data['units'] as $response) {
            $da = new MongoDB\BSON\ObjectID();
            $data['units'][$x]['unitId'] = $da;
            $data['units'][$x]['value'] = (float) number_format($data['units'][$x]['value'], 2);
            $data['units'][$x]['status'] = "active";
            $x++;
        };

        if ($data['strainEffects']['relaxed'] != '') {
            $data['strainEffects']['relaxed'] = (float) number_format($data['strainEffects']['relaxed'], 2);
        }
        if ($data['strainEffects']['happy'] != '') {
            $data['strainEffects']['happy'] = (float) number_format($data['strainEffects']['happy'], 2);
        }
        if ($data['strainEffects']['euphoric'] != '') {
            $data['strainEffects']['euphoric'] = (float) number_format($data['strainEffects']['euphoric'], 2);
        }
        if ($data['strainEffects']['uplifted'] != '') {
            $data['strainEffects']['uplifted'] = (float) number_format($data['strainEffects']['uplifted'], 2);
        }
        if ($data['strainEffects']['creative'] != '') {
            $data['strainEffects']['creative'] = (float) number_format($data['strainEffects']['creative'], 2);
        }


        if ($data['medicalAttributes']['stress'] != '') {
            $data['medicalAttributes']['stress'] = (float) number_format($data['medicalAttributes']['stress'], 2);
        }
        if ($data['medicalAttributes']['depression'] != '') {
            $data['medicalAttributes']['depression'] = (float) number_format($data['medicalAttributes']['depression'], 2);
        }
        if ($data['medicalAttributes']['pain'] != '') {
            $data['medicalAttributes']['pain'] = (float) number_format($data['medicalAttributes']['pain'], 2);
        }
        if ($data['medicalAttributes']['headaches'] != '') {
            $data['medicalAttributes']['headaches'] = (float) number_format($data['medicalAttributes']['headaches'], 2);
        }
        if ($data['medicalAttributes']['fatigue'] != '') {
            $data['medicalAttributes']['fatigue'] = (float) number_format($data['medicalAttributes']['fatigue'], 2);
        }

        if ($data['negativeAttributes']['dryMouth'] != '') {
            $data['negativeAttributes']['dryMouth'] = (float) number_format($data['medicalAttributes']['dryMouth'], 2);
        }
        if ($data['negativeAttributes']['dryEyes'] != '') {
            $data['negativeAttributes']['dryEyes'] = (float) number_format($data['medicalAttributes']['dryEyes'], 2);
        }
        if ($data['negativeAttributes']['anxious'] != '') {
            $data['negativeAttributes']['anxious'] = (float) number_format($data['medicalAttributes']['anxious'], 2);
        }
        if ($data['negativeAttributes']['paranoid'] != '') {
            $data['negativeAttributes']['paranoid'] = (float) number_format($data['medicalAttributes']['paranoid'], 2);
        }
        if ($data['negativeAttributes']['dizzy'] != '') {
            $data['negativeAttributes']['dizzy'] = (float) number_format($data['medicalAttributes']['dizzy'], 2);
        }


//       echo '<pre>';
//       print_r($data['units']);
//       exit();

        $data['currentDate'] = $data['current_dt'];
        unset($data['current_dt']);
//        unset( $data['barcode']);
//        unset( $data['nutritionFacts']);

        $data['seqId'] = $seq;
        $result = $this->mongo_db->insert('childProducts', $data);
        $resultData = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($data['storeId'])))->push(array('firstCategory' => new MongoDB\BSON\ObjectID($data['firstCategoryId'])))->update('stores');

//        $res = $this->mongo_db->where('')->update('products');
//                                                                                                                                                                           
//        print_r($response);die;
    }

    function getZoneId($id) {
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('stores');
        $res = $result['serviceZones'];
        return $res;
    }

    public function getAddOns(){
        $storeId = $this->session->userdata('badmin')['BizId'];
        $result=$this->mongo_db->where(array('status' => 1,'storeId'=> $storeId))->get('storeAddOns');
        // echo '<pre>';print_r( $result);die;
       
        $res=[];
        foreach($result as $storeAddOn){
            if(array_key_exists("centralAddOnId",$storeAddOn) && $storeId==$storeAddOn['storeId'] ){         
                array_push($res,$storeAddOn);
             }else{
                array_push($res,$storeAddOn);
             }
        }     

        return $res;

    }

    public function getStoreType($storeId){
        // $res = $this->mongo_db->where(array("status" => 2))->select(array("name"=>"name"))->get("franchise");

        $res=$this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($storeId)))->select(array("storeType"=>"storeType","currencySymbol"=>"currencySymbol"),array('_id'=>'_id'))->find_one("stores");
        
       return $res;

    }

    function insertExcel($data) {

        $this->load->library('elasticsearch');
        $data1 = $data;
        $cursor = $this->mongo_db->get('childProducts');
        $arr = [];

        foreach ($cursor as $catdata) {
            array_push($arr, $catdata['seqId']);
        }
        $max = max($arr);
        $seq = $max + 1;

        $data['seqId'] = $seq;
        $result = $this->mongo_db->insert('childProducts', $data);
        $data['mongoId'] = (string) $result;
        $elasticdata = $data;
        $return = $this->elasticsearch->add('childProducts', $seq, $elasticdata);
    }

    function unitsList($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');
        $data = $result['units'];

        echo json_encode(array('data' => $data));
    }

    function reviewlist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('childProducts');
        $i = 1;
        foreach ($result as $row)
            $data[] = array($i++, 'Product_Name' => $row['productName'], 'Manufacturer' => $row['manufacturer'], 'Model' => $row['model'], 'Description' => $row['shortDescription']);

        echo json_encode(array('data' => $data));
    }

    function getUnits() {

        
        $this->load->library('Datatables');
        $this->load->library('table');
        $ids = $this->input->post('val');
      
        foreach ($ids as $id) {
      
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');
            
        }
        $x = 0;
        foreach ($result['units'] as $res) {

            $result['units'][$x]['status'] = "inactive";
            $x++;
        }

        echo json_encode(array('data' => $result['units'], 'result' => $result));
    }

    

    function getUnitsList() {

        
        $this->load->library('Datatables');
        $this->load->library('table');
        $ids = $this->input->post('val');
      
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($ids)))->find_one('products');
      
        $x = 0;
        foreach ($result['units'] as $res) {

            $result['units'][$x]['status'] = "inactive";
            $x++;
        }

        echo json_encode(array('data' => $result['units'], 'result' => $result));
    }

    function reviewlistProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('products');
        $i = 1;
        foreach ($result as $row)
            $data[] = array($i++, 'Product_Name' => $row['productName'], 'Manufacturer' => $row['manufacturer'], 'Model' => $row['model'], 'Description' => $row['shortDescription']);

        echo json_encode(array('data' => $data));
    }

    function viewDescriptionlist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('childProducts');

        $data = $result['detailedDescription'];


        echo json_encode(array('data' => $data));
    }

    function viewShortDescriptionlist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('childProducts');

        $data = $result['shortDescription'];


        echo json_encode(array('data' => $data));
    }

    function viewDescriptionlistProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');

        $data = $result['detailedDescription'];


        echo json_encode(array('data' => $data));
    }

    function viewShortDescriptionlistProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');

        $data = $result['shortDescription'];


        echo json_encode(array('data' => $data));
    }

    function imagelist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('childProducts');

//        foreach ($result as $row) {
//            $data = $row['images'];
//        }

        echo json_encode(array('data' => $result['images']));
    }

    function imagelistProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');

//        foreach ($result as $row) {
//            $data = $row['images'];
//        }
        echo json_encode(array('data' => $result['images']));
//        echo json_encode(array('data' => $data));
    }

    function nutrilist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('childProducts');

        $i = 1;

        foreach ($result as $row) {
            $data = $row['nutritionFacts'];
        }

        echo json_encode(array('data' => $data));
    }

    function nutrilistProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('products');

        $i = 1;

        foreach ($result as $row) {
            $data = $row['nutritionFacts'];
        }

        echo json_encode(array('data' => $data));
    }

    function strainEffects($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('childProducts');

        $i = 1;

        foreach ($result as $row) {
            $data = $row['strainEffects'];
        }

        echo json_encode(array('data' => $data));
    }

    function strainEffectsProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('products');

        $i = 1;

        foreach ($result as $row) {
            $data = $row['strainEffects'];
        }

        echo json_encode(array('data' => $data));
    }

    function medicalAttributes($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('childProducts');

        $i = 1;

        foreach ($result as $row) {
            $data = $row['medicalAttributes'];
        }

        echo json_encode(array('data' => $data));
    }

    function medicalAttributesProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('products');

        $i = 1;

        foreach ($result as $row) {
            $data = $row['medicalAttributes'];
        }

        echo json_encode(array('data' => $data));
    }

    function negativeAttributes($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('childProducts');

        $i = 1;

        foreach ($result as $row) {
            $data = $row['negativeAttributes'];
        }

        echo json_encode(array('data' => $data));
    }

    function negativeAttributesProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('products');

        $i = 1;

        foreach ($result as $row) {
            $data = $row['negativeAttributes'];
        }

        echo json_encode(array('data' => $data));
    }

    function flavours($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('childProducts');

        $i = 1;

        foreach ($result as $row) {
            $data = $row['flavours'];
        }

        echo json_encode(array('data' => $data));
    }

    function flavoursProducts($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('products');

        $i = 1;

        foreach ($result as $row) {
            $data = $row['flavours'];
        }

        echo json_encode(array('data' => $data));
    }

    function getCities() {
        $val = $this->input->post("country");

        $cData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->find_one('Country');
        $entities = ' <select class="form-control" id="cityLists" name="FData[city_select]"  required>
                                                <option value="0">Select City</option>';
        foreach ($cData['cities'] as $city) {
            $cityData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($city)))->find_one('City');
            $entities .= ' <option value="' . $cityData['_id']['$oid'] . '" >' . implode($cityData['name']) . '</option>';
        }
        $entities .= ' </select>';
        return $entities;
    }

    function getProductDetailsById($id) {
        $getProductDetails = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');
        if (empty($getProductDetails)) {
            echo json_encode(array('status' => false, 'message' => 'Unable to get product details'));
        } else {
            echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $getProductDetails));
        }
    }

   

    function uflyStoreProductDetails($status = '') {
      
        
        
        $this->load->library('mongo_db');
        $proSort = (int) $this->input->post("productList");
        $this->load->library('Datatables');
        $this->load->library('table');
        $catId = $this->input->post("category");
        $subCat= $this->input->post('subCat');
        $subSubCat=$this->input->post('subSubCat');
        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "productname.en";
        $_POST['mDataProp_1'] = "firstCategoryName";
        $_POST['mDataProp_2'] = "secondCategoryName";
        $_POST['mDataProp_3'] = "thirdCategoryName";
      

        $sl = $_POST['iDisplayStart'] + 1;
        // $storeSession = $this->session->all_userdata();
        $storeId = $this->session->userdata('badmin')['BizId'];
      
        if($status!=8){

            if($status==1){               
                if($catId==''){
                  $val= array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status' => array('$in'=>[1,6]));
                }
                else{
                        if($catId!='' && $subCat!='' && $subSubCat!=''){
                            $val= array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status' => array('$in'=>[1,6]),
                            'firstCategoryId'=>(string)$catId,'secondCategoryId'=>(string)$subCat,
                            'thirdCategoryId'=>$subSubCat);
                        }else if ($catId!='' && $subCat!=''){
                            $val= array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status' => array('$in'=>[1,6]),
                            'firstCategoryId'=>(string)$catId,'secondCategoryId'=>(string)$subCat);
                        }else if($catId!=''){
                            $val= array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status' => array('$in'=>[1,6]),
                            'firstCategoryId'=>(string)$catId);
                        }           
                    }              
            }else{

                if($catId==''){
                    $val= array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status' => (int)$status);
                }else{
                    $val= array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status' => (int)$status,'firstCategoryId'=>$catId);
                }               
            }

            if($proSort != ''){
                $conditionQuery = array(array('$match'=>$val),array('$sort'=>array('productname.en'=>$proSort)));
            }else{
                $conditionQuery = array(array('$match'=>$val),array('$sort'=>array('seqId'=>-1)));
            }
            
            $countQuery = array(array('$match'=>$val),array('$group'=>array('_id'=>1,count=>array('$sum'=>1))));
    
           
            $respo = $this->datatables->datatable_mongodbAggregate('childProducts',$conditionQuery,$countQuery);
            
            $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
            $aaData = $respo["aaData"];
            $datatosend = array();
            $createdOn="N/A";
            $success="N/A";
            $failed="N/A";
            $repeated="N/A";
    
            foreach ($aaData as $value) {
                $id = (string)$value->_id;
                $value = json_decode(json_encode($value), TRUE);
                $value['_id']['$oid'] =   $id;
                $arr = array();
    
                if(count($respo['lang'])<1){
                   
                    $productname=($value['productname']['en'] != "" || $value['productname']['en'] != null) ? $value['productname']['en']: 'N/A';
                    $category=($value['catName']['en']!="" || $value['catName']['en']!= null) ? $value['catName']['en']:'N/A';
                    $subCat=($value['subCatName']['en']!="" || $value['subCatName']['en']!= null) ? $value['subCatName']['en']:'N/A';
                    $subSubCat=($value['subSubCatName']['en']!="" || $value['subSubCatName']['en']!= null) ? $value['subSubCatName']['en']:'N/A';
    
                   }else{
                    
                    $productname=($value['productname']['en'] != "" || $value['productname']['en'] != null) ? $value['productname']['en']: 'N/A';
                    $category=($value['catName']['en']!="" || $value['catName']['en']!= null) ? $value['catName']['en']:'N/A';
                    $subCat=($value['subCatName']['en']!="" || $value['subCatName']['en']!= null) ? $value['subCatName']['en']:'N/A';
                    $subSubCat=($value['subSubCatName']['en']!="" || $value['subSubCatName']['en']!= null) ? $value['subSubCatName']['en']:'N/A';
    
        
                    foreach( $respo['lang'] as $lang){
        
                        $lan= $lang['langCode'];
                        $productnames=($value['productname'][$lan] != "" || $value['productname'][$lan] != null) ? $value['productname'][$lan]: '';
                        $categorys=($value['catName'][$lan]!="" || $value['catName'][$lan]!= null) ? $value['catName'][$lan]:'';
                        $subCats=($value['subCatName'][$lan]!="" || $value['subCatName'][$lan]!= null) ? $value['subCatName'][$lan]:'';
                        $subSubCats=($value['subSubCatName'][$lan]!="" || $value['subSubCatName'][$lan]!= null) ? $value['subSubCatName'][$lan]:'';
    
                        
                       if(strlen( $productnames)>0){
                        $productname.= ',' . $productnames;
                       }
    
                       if(strlen($categorys)>0){
                        $category.=','. $categorys;
                       }
                       if(strlen(  $subCats)>0){
                        $subCat.=','. $subCats;
                       }
                       if(strlen( $subSubCats)>0){
                        $subSubCat.=','. $subSubCats;
                       }
    
    
                    }
        
        
                   }
    
                $arr[] = $sl++;
                $arr[] = $productname;
                $arr[] =  $category;
                $arr[] =  $subCat;
                $arr[] = $subSubCat;
                $arr[] = '<a class="unitListForStoreProducts textDec" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
                $arr[] = '<a class="addOnListForStoreProducts textDec" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
             
                $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
                $arr[] =$createdOn;
                $arr[] =$success;
                $arr[] = $failed;
                $arr[] =$repeated;  
                $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";
                $arr[]="";   
    
                $datatosend[] = $arr;
            }
        }
            else{

                $respo = $this->datatables->datatable_mongodb('BulkImports', array("storeId" => $this->session->userdata('badmin')['BizId']), '_id', -1);

                $aaData = $respo["aaData"];      
                $datatosend = array(); 
                
                foreach ($aaData as $value) {  
               
                    $success=count($value['successImports']);
                    $repeated=count($value['repeatedImports']);
                    $failure=count($value['failedImports']);               
                    $arr = array();
    
                    $arr[] = $sl++;   
                    $arr[] = '';
                    $arr[] = '';    
                    $arr[] = '';
                    $arr[] =  '';
                    $arr[] = '';
                    $arr[] = '';
                    $arr[] = '';
                    $arr[] =$value['createdOn'];
                    $arr[]=($success>0)? '<a style="cursor:  pointer;color: dodgerblue;" class="getBulkInfo" bulkType="Success"  id="'.$value['_id']['$oid'].'" >' .  $success  . '</a>' : '0';
                    $arr[]= ($failure>0)? '<a style="cursor:  pointer;color: dodgerblue;" class="getBulkInfo" bulkType="Failed"  id="'.$value['_id']['$oid'].'" >' .  $failure  . '</a>' : '0';
                    $arr[]= ($repeated>0)? '<a style="cursor:  pointer;color: dodgerblue;" class="getBulkInfo" bulkType="Repeated"  id="'.$value['_id']['$oid'].'" >' .  $repeated  . '</a>' : '0';
                    $arr[] =''; 
                    $arr[]=$value['statusMsg'];
        
                    $datatosend[] = $arr;
                  
                }

            }

        
        

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }


    function addOn_details($status) {

        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "taxName";
        $_POST['mDataProp_1'] = "taxDescription";
        $_POST['mDataProp_2'] = "taxCode";
        $sl = $_POST['iDisplayStart'] + 1;
        $storeId = $this->session->userdata('badmin')['BizId'];
        $addOnData=[];
        $storeAddOnCentralId=[];
        $storeAddOn=$this->mongo_db->where(array("status"=>1))->get('storeAddOns'); 

        //Fetch all storeAddOn data and centralAddOn present in it and store it in array and conver centralADdonID(String into Object ID for 
        // futher comparisoon) cool
        foreach($storeAddOn as $storeAddOns){
         
          if($storeAddOns['storeId']== $storeId){
                             if(array_key_exists("centralAddOnId",$storeAddOns) && $storeId==$storeAddOns['storeId'] ){
                                    $storeCentrald=new  MongoDB\BSON\ObjectID($storeAddOns['centralAddOnId']);
                                    array_push($storeAddOnCentralId,$storeCentrald);
                            }
            $storeAddOns['centralAddOnId']="0";                    
            array_push($addOnData,$storeAddOns);   
                } 
        }
       
        // Fetch only data which are not in Storecentral ID
        $centralAddOn=$this->mongo_db->where(array("status"=>(int)$status , "_id" => array('$nin' =>$storeAddOnCentralId )))->get('addOns');

        foreach($centralAddOn as $addOn){ 
            array_push($addOnData,$addOn);
        }  
       
        $aaData = $addOnData;
        $datatosend = array();       
        // 1 - active, 2 - inactive   
        
        foreach ($aaData as $value) {
            $isAllow = "";
            if(array_key_exists("centralAddOnId",$value) && ($storeId==$value['storeId'])){
                $price = '<a class="viewAddOnsList" id="' . $value['_id']['$oid'] . '" setPriceId="'.$value['_id']['$oid'].'" style="cursor:pointer;">View/Edit</a>'; 
                $isAllow = "";   
             }else{
                $price = '<a class="addOnsList"  id="' . $value['_id']['$oid'] . '" setPriceId="'.$value['_id']['$oid'].'" style="cursor:pointer;">Set Price</a>';
                $isAllow = "disabled"; 
             }

            $arr = array();
            $arr[] = $sl++;
            $arr[] = $value['name']['en'];
            $arr[] = ($value['description']['en'] !="" || $value['description']['en'] !=null ) ? $value['description']['en'] : 'N/A';
            $arr[] =$price;
            $arr[] = "<input type='checkbox' $isAllow class='checkbox checkboxProduct' data-toggle='tooltip' title='Please set price before adding AddOn'  id='checkboxProduct' data-id='" . $value['_id']['$oid'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";
            $datatosend[] = $arr;
        }
       
         $respo["aaData"] = $datatosend;
        // echo json_encode($respo);

                      if ($this->input->post('sSearch') != '') {
                           $FilterArr = array();
                           foreach ($datatosend as $row) {
                               $needle = strtoupper($this->input->post('sSearch'));
                               $ret = array_keys(array_filter($row, function($var) use ($needle) {
                                           return strpos(strtoupper($var), $needle) !== false;
                                       }));
                               if (!empty($ret)) {
                                   $FilterArr [] = $row;
                               }
                           }
                           echo $this->datatables->getdataFromMongo($FilterArr);
                       }
                       if ($this->input->post('sSearch') == '')
                           echo $this->datatables->getdataFromMongo($datatosend);

        
    }

    //***********serprice modal********
    function AddnewAddOnData(){
    // pass
        $date = new DateTime();
        $data=$_POST;
        $id=$data['centralAddOnids'];        
        $data1=$this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($id)))->find_one('addOns');
       
    //     echo $date->getTimestamp();
    //    echo 'pass';print_r($date);die;
        $addOnStore=$data['addOnPrice'];
        $addOnStoreCount=count($data['addOnPrice']);
        $addOnCentral=$data1['addOns'];
        // print_r($addOnCentral);die;
        $addOnCentralCount=count($data1['addOns']);
       
        $addOnList=[];
        for($i=0;$i<$addOnStoreCount;$i++){
           for($j=0;$j<$addOnCentralCount;$j++){            
            if($addOnStore[$i]['addOnId']== $addOnCentral[$j]['id']['$oid']){
                $addOne=$addOnCentral[$j];
                $addOne['id']=$addOnCentral[$j]['id']['$oid'];
                unset($addOnCentral[$j]['id']['$oid']);
                $addOne['price']=$addOnStore[$i]['value'];
                array_push($addOnList,$addOne);                
            }
           }
        }        
        unset($data['addOnPrice']);
        unset($data['centralAddOnids']); 
        $data1['centralAddOnId']=$data1['_id']['$oid'];
        $data1['storeId']=$data['storeId'];
        $data1['addOns']=$addOnList;
        unset($data['storeId']);
        unset($data1['_id']);
        unset($data1['isoDate']);
        $data1['isoDate']= $this->mongo_db->date();
        $data1['timeStamp']=$date->getTimestamp();
       // print_r($data1);die;
       $inserted=$this->mongo_db->insert('storeAddOns', $data1);
       if($inserted){
           $arr="Success";
       echo json_encode(array('data' => $arr));
       }
    }

    //fetch edit Addon price detail
    function editAddOnsList($id = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('storeAddOns');
        $data = $result['addOns'];
        echo json_encode(array('data' => $data));
    }

    // edit Addon price data

    function editAddnewAddOnData(){
        
        $data=$_POST;
        $id=$data['centralAddOnids'];    
        $storeId=$data['storeId'];        
        $addOnStore=$data['addOnPrice'];
        $addOnStoreCount=count($data['addOnPrice']);       
        
        foreach($data['addOnPrice'] as $addOndata){           
           $priceupdate=$addOndata['value'];          
           $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id),"storeId"=>$storeId,"addOns.id"=>$addOndata['addOnId']))->set(array("addOns.$.price"=> $priceupdate))->update('storeAddOns');         
         }    
      }

    //Addon modal popup
    function addOnsList($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
       
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('addOns');
       
        if(!$result){
            
            $result1 = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('storeAddOns');
            $data = $result1['addOns'];  

        }else{
            $data = $result['addOns']; 
        }
       
          
        
        echo json_encode(array('data' => $data));
    }

    function getBulkinfo($bulkId){

        $res=$this->mongo_db->where(array('_id'=> new MOngoDB\BSON\ObjectID($bulkId)))->find_one('BulkImports');
      
        echo json_encode($res);
 
     }


     function permanentDeleteProduct() {
      
        $id = $this->input->post('val');
        $ids = $this->input->post('id');
        $storeId=$this->session->userdata('badmin')['BizId'];
      

        foreach ($id as $data) {

            $fields = $data;
            $fields = json_encode($fields);
            $headers = array(
                'Content-Type: application/json'
            );
          
          

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, APILink . 'productDelete/' . $data .'/'. $storeId);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);             
            curl_close($ch);
           
        }
        echo json_encode($result);
    }

     //update status
     function updatecouponCodeStatus($status, $offerIds)
     {  

         
        $id = $this->input->post('val');
        $status = $this->input->post('status');
       
        //$ids = $this->input->post('Id');
       // print_r($id);die;

         foreach ($id as $data) {

            $fields = $data;
            $fields = json_encode($fields);
            $headers = array(
                'Content-Type: application/json'
            );
          
          

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, APILink . 'child/product/' . $data .'/'. $status);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);             
            curl_close($ch);
            
           
        }
        echo json_encode($result);

     }

     function getChildProductCount($storeId){

        

        $countQuery = array(array('$match'=>array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status' => array('$in'=>[1,6]))),array('$group'=>array('_id'=>1,count=>array('$sum'=>1))));
        $respo = $this->mongo_db->aggregate('childProducts',$countQuery);
        foreach($respo as $res){
            $doc = $res;
        }
        $res = json_decode(json_encode($doc,true));
        return ceil(($res->count)/10) ;
     }


     //store List
     function getAddonData($addOnIds) {
 
        
        $addId=[];
         foreach($addOnIds as $Id){
              if($Id != "multiselect-all")
              $addId[]=new MongoDB\BSON\ObjectID($Id);
         }
    
           $cursor = $this->mongo_db->where(array("_id" =>array('$in'=>$addId) ))->get('storeAddOns');
           echo json_encode(array('data' => $cursor));
    
         
         
      
  }


}

?>
 