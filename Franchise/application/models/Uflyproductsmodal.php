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

    function getCurrentStoreData($id) {
	
	
        $getStoreDetails = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->select(array("cityId"=>"cityId","serviceZones"=>"serviceZones","coordinates"=>"coordinates","sName"=>"sName","averageRating"=>"averageRating"))->find_one('stores');
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
//        $_POST['mDataProp_4'] = "SKU";
//        $_POST['mDataProp_5'] = "barcode";
//        $_POST['mDataProp_6'] = "POSName";
//        $_POST['mDataProp_7'] = "THC";
//        $_POST['mDataProp_8'] = "CBD";
//        $_POST['mDataProp_9'] = "shortDescription";

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

//            $arr[] = ($value['sku'] != '') ? $value['sku'] : 'N/A';
//            $arr[] = ($value['barcode'] != '') ? $value['barcode'] : 'N/A';
//            $arr[] = ($value['shortDescription'] != '') ? $value['shortDescription'] : 'N/A';
//
//            $arr[] = '<a class="viewDetailedDescriptionlist" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//
//            $arr[] = ($value['POSName'] != '') ? $value['POSName'] : 'N/A';
//            $arr[] = ($value['barcodeFormat'] != '') ? $value['barcodeFormat'] : 'N/A';
//            $arr[] = ($value['THC'] != '') ? $value['THC'] : 'N/A';
//            $arr[] = ($value['CBD'] != '') ? $value['CBD'] : 'N/A';
//            $arr[] = '<a class="imglist" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//
//            $arr[] = '<a class="strainEffects" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = '<a class="medicalAttributes" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = '<a class="negativeAttributes" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = '<a class="flavours" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';

            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";


            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
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
//        $_POST['mDataProp_4'] = "SKU";
//        $_POST['mDataProp_5'] = "barcode";
//        $_POST['mDataProp_6'] = "POSName";
//        $_POST['mDataProp_7'] = "THC";
//        $_POST['mDataProp_8'] = "CBD";
//        $_POST['mDataProp_9'] = "shortDescription";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('products', array('status' => 1), '');

        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));

        // print_r($respo['lang']);die;

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
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
//            $arr[] = ($value['sku'] != '') ? $value['sku'] : 'N/A';
//            $arr[] = ($value['barcode'] != '') ? $value['barcode'] : 'N/A';
//            $arr[] = '<a class="viewShortDescriptionlistProducts" style="cursor: pointer;" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//
//            $arr[] = '<a class="viewDetailedDescriptionlistProducts" style="cursor: pointer;" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//
//            $arr[] = ($value['POSName'] != '') ? $value['POSName'] : 'N/A';
//            $arr[] = ($value['barcodeFormat'] != '') ? $value['barcodeFormat'] : 'N/A';
//            $arr[] = ($value['THC'] != '') ? $value['THC'] : 'N/A';
//            $arr[] = ($value['CBD'] != '') ? $value['CBD'] : 'N/A';
//            $arr[] = '<a class="imglistProducts" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//
//            $arr[] = '<a class="strainEffectsProducts"  id="' . $value['_id']['$oid'] . '" style="cursor:pointer; color:#0090d9; text-decoration: underline">View</a>';
//            $arr[] = '<a class="medicalAttributesProducts"  id="' . $value['_id']['$oid'] . '" style="cursor:pointer;color:#0090d9; text-decoration: underline">View</a>';
//            $arr[] = '<a class="negativeAttributesProducts"  id="' . $value['_id']['$oid'] . '" style="cursor:pointer;color:#0090d9; text-decoration: underline">View</a>';
//            $arr[] = '<a class="flavoursProducts"  id="' . $value['_id']['$oid'] . '" style="cursor:pointer;color:#0090d9; text-decoration: underline">View</a>';

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
   
    function getUnitsForFranchise($id = '') {
            //repo
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('franchiseProducts');
        $arr = array();
        $x = 0;
        foreach ($data['units'] as $result) {
            // print_r($result);die;
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
    //print_r($data);die;
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
        
        $_POST['categoryName'] = explode(';', $_POST['firstCategoryName']);
        $_POST['subCategoryName'] = explode(';', $_POST['secondCategoryName']);
        $_POST['subSubCategoryName'] = explode(';', $_POST['thirdCategoryName']);

//        echo '<pre>'; print_r($_POST); die;
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
        $_POST['sDescription']['en'] = $_POST['shortDescription'][0];
        $_POST['POSNam'] = array_values($_POST['POSName']);
        $_POST['detailDescription']['en'] = $_POST['detailedDescription'][0];
        $_POST['shortDescription'] = $_POST['shortDescription'][0];
        $_POST['detailedDescription'] = $_POST['detailedDescription'][0];
        $_POST['POSName'] = $_POST['POSName'][0];

        unset($_POST['color'], $_POST['size'], $_POST['tax'], $_POST['taxFlag']);
        unset($_POST['colorData'], $_POST['colorName'], $_POST['color'], $_POST['sizeName'], $_POST['sizeData']);

        $data = $_POST;

        foreach ($data['units'] as $res) {
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
            $data['negativeAttributes']['dryMouth'] = (float) number_format($data['negativeAttributes']['dryMouth'], 2);
        }
        if ($data['negativeAttributes']['dryEyes'] != '') {
            $data['negativeAttributes']['dryEyes'] = (float) number_format($data['negativeAttributes']['dryEyes'], 2);
        }
        if ($data['negativeAttributes']['anxious'] != '') {
            $data['negativeAttributes']['anxious'] = (float) number_format($data['negativeAttributes']['anxious'], 2);
        }
        if ($data['negativeAttributes']['paranoid'] != '') {
            $data['negativeAttributes']['paranoid'] = (float) number_format($data['negativeAttributes']['paranoid'], 2);
        }
        if ($data['negativeAttributes']['dizzy'] != '') {
            $data['negativeAttributes']['dizzy'] = (float) number_format($data['negativeAttributes']['dizzy'], 2);
        }

        $productName = implode(',', $data['productName']);
        $itemKey = str_replace(' ', '-', $productName);
        $data['itemKey'] = str_replace('/', '-', $itemKey);
        $data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $data['firstCategoryId'] . '.xml';

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
         foreach($addon as $addOnData){
       
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
             $storeAddOnData['isoDate']= $this->mongo_db->date();
             $storeAddOnData['timeStamp']=$date->getTimestamp();
             unset($storeAddOnData['_id']); 
             $storeAddOnData['addOns'] = $addOnunique;
             array_push($addOnDetails,(object)$storeAddOnData);            
         }        
         $data['addOns'] = $addOnDetails;  
         $data['productName'] = array_values($_POST['productName']);

        
        // call node api to add product
        $fields = $data;               
        $fields = json_encode($fields);
        $headers = array(
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.flexyapp.com/child/product');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
    //   echo '<pre>';print_r($result);die;
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
        curl_setopt($ch, CURLOPT_URL, "https://api.flexyapp.com/child/product/" . $fields);
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

        $res = $this->mongo_db->get('brands');
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





    function AddNewProductData_old($data1, $category) {
        // pass working
        // echo '<pre>';print_r($_POST);die;
        
        $ids = $this->input->post('val');
        $productData = $this->input->post('productData');
        $unitsValue = $this->input->post('unitsValue');
        $unitsValueNew = $this->input->post('unitsValueNew');
        $unitsTitle = $this->input->post('unitsTitle');
        $unitsTitleNew = $this->input->post('unitsTitleNew');
        $unitarr = $this->input->post('unitarr');
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

     if ($productData) {
            $response = json_decode($productData, true);
            $resONE = $this->mongo_db->where(array("parentProductId" => $response['_id']['$oid'], 'storeId' => new MongoDB\BSON\ObjectID($data1['storeId'])))->find_one('childProducts');
        } else {
            $sizes = array();
            $colors = array();
            $taxes = array();

            if ($_POST['brand']) {
                $brandData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($_POST['brand'])))->find_one('brands');
                $_POST['brandTitle'] = $brandData['name'];
            }

            if ($_POST['size']) {
                foreach ($_POST['size'] as $sizeids) {
                    $sizeData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($sizeids)))->find_one('sizeGroup');
                    $sizes[] = array('sizeId' => $sizeids, 'size' => $sizeData['name']);
                }
            }
            if ($_POST['color']) {
                foreach ($_POST['color'] as $colorId) {
                    $colorData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($colorId)))->find_one('colors');
                    $colors[] = array('colorId' => $colorId, 'color' => $colorData['colorName']);
                }
            }


            $_POST['sizes'] = $sizes;
            $_POST['colors'] = $colors;
            $_POST['categoryName'] = explode(';', $_POST['firstCategoryName']);
            $_POST['subCategoryName'] = explode(';', $_POST['secondCategoryName']);
            $_POST['subSubCategoryName'] = explode(';', $_POST['thirdCategoryName']);

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
            //$_POST['sDescription']['en'] = $_POST['shortDescription'][0];   
            $_POST['POSNam'] =array_values( $_POST['POSName']);
          //  $_POST['detailDescription']['en'] = $_POST['detailedDescription'][0];
            // $_POST['sDescription']['en'] = $_POST['shortDescription'][0];
            // $_POST['detailDescription']['en'] = $_POST['detailedDescription'][0];
            //$_POST['shortDescription'] = $_POST['shortDescription'][0];
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

            $_POST['shortDescription']['en']="Details";
            $_POST['detailedDescription']['en']="Detail desc";
        $_POST['shortDescription'] =(string) $_POST['shortDescription']['en'];
        $_POST['detailedDescription'] =(string) $_POST['detailedDescription']['en'];

            unset($_POST['color'], $_POST['size']); // $_POST['tax'], $_POST['taxFlag']
            unset($_POST['colorData'], $_POST['colorName'], $_POST['color'], $_POST['sizeName'], $_POST['sizeData']);

            $response = $_POST;
            $resONE = '';
        }

        $count = count($response['units']);
        $x = 0;
        $y = 0;
        $a = 0;
        $b = 0;
        $xy = 1;
       

        // foreach ($response['units'] as $res) {

        //     if ($ids) {
        //         foreach ($ids as $id) {

        //             $response['units'][$y]['unitId'] = (string) (new MongoDB\BSON\ObjectID());
        //             if ($res['unitId'] == $id) {
        //                 $response['units'][$y]['status'] = "active";
        //                 $unitsData = $this->mongo_db->where(array('units.unitId' => $id))->find_one('products');
        //                 foreach ($unitsData['units'] as $units) {
        //                     if ($units['unitId'] == $id) {
        //                         $response['units'][$y]['name'] = $units['name'];
        //                         $response['units'][$y]['price'] = $units['price'];
        //                         $response['units'][$y]['floatValue'] = (float) $units['price']['en'];

        //                         $response['units'][$y]['price']["en"] = ($unitsValue[$y]);
        //                     }
        //                 }
        //             }
        //         }
        //         $y++;
        //     } else {
        //         $oldid = $response['units'][$a]['unitId'];
        //         $unitsData = $this->mongo_db->where(array('units.unitId' => $oldid))->find_one('products');
        //         if ($unitsData) {
        //             foreach ($unitsData['units'] as $units) {
        //                 if ($units['unitId'] == $oldid) {
        //                     $response['units'][$a]['name'] = $units['name'];
        //                     $response['units'][$a]['price'] = $units['price'];
        //                     $response['units'][$a]['floatValue'] = (float) $units['price']['en'];

        //                     $response['units'][$a]['price']["en"] = $response['units'][$a]['price'];
        //                 }
        //             }
        //         } else {

        //             foreach ($response['units'] as $units) {

        //                 $response['units'][$a]['name'] = $units['name'];
        //                 $response['units'][$a]['price'] = $units['price'];
        //                 $response['units'][$a]['floatValue'] = (float) $units['price']['en'];

        //             }
        //         }

        //         $da = new MongoDB\BSON\ObjectID();
        //         $response['units'][$a]['unitId'] = (string) $da;

        //         $sizeAttrs = array();

        //         foreach ($response['units'][$a]['sizeAttr'] as $attrids) {  // loop through each id
        //             for ($i = 1;; $i++) {
        //                 $sizedata = $this->mongo_db->where(array('sizeAttr.' . $i . '.attrId' => new MongoDB\BSON\ObjectID($attrids)))->find_one('sizeGroup');
        //                 // check for success case and break the loop    
        //                 if ($sizedata) {
        //                     foreach ($lanCodeArr as $code) {
        //                         $sizear['attribute'][$code] = $sizedata['sizeAttr'][$i][$code];
        //                     }
        //                     $sizeAttrs[] = array('attrId' => $attrids, 'attribute' => $sizear['attribute']);
        //                     break;
        //                 }
        //             }
        //         }

        //         $response['units'][$a]['sizeAttributes'] = $sizeAttrs;
        //         $response['units'][$a]['status'] = "active";
        //         unset($response['units'][$a]['sizeAttr']);

        //         $a++;
        //     }
        // }


        foreach ($response['units'] as $res) {

            if ($ids) {
                foreach ($ids as $id) {

                    $response['units'][$y]['unitId'] = (string) (new MongoDB\BSON\ObjectID());
                    if ($res['unitId'] == $id) {
                        $response['units'][$y]['status'] = "active";
                        $unitsData = $this->mongo_db->where(array('units.unitId' => $id))->find_one('products');
                        foreach ($unitsData['units'] as $units) {
                            if ($units['unitId'] == $id) {
                                $response['units'][$y]['name'] = $units['name'];
                                $response['units'][$y]['price'] = $units['price'];
                                $response['units'][$y]['floatValue'] = (float)$unitsValue[$y];

                                $response['units'][$y]['price']["en"] = $unitsValue[$y];
						
								 $unitIdwithQty[$response['units'][$y]['unitId']] = (int)$unitsQuantity[$y];
								
                            }
                        }
                    }
                }
                $y++;
            } else {
			
                $oldid = $response['units'][$a]['unitId'];
                $unitsData = $this->mongo_db->where(array('units.unitId' => $oldid))->find_one('products');
                $da = new MongoDB\BSON\ObjectID();
                $response['units'][$a]['unitId'] = (string) $da;
                if ($unitsData) {
                    foreach ($unitsData['units'] as $units) {
                        if ($units['unitId'] == $oldid) {
                            $response['units'][$a]['name'] = $units['name'];
                            $response['units'][$a]['price'] = $units['price'];
                            $response['units'][$a]['floatValue'] = (float) $units['price']['en'];
						
                            $response['units'][$a]['price']["en"] = $response['units'][$a]['price'];
						
							
                        }
                    }
                } else {

               

                        $response['units'][$a]['name'] = $res['name'];
                        $response['units'][$a]['price'] = $res['price'];
                        $response['units'][$a]['floatValue'] = (float) $res['price']['en'];
                      
                       
                      

                }
                
             

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
        }

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

        $response['franchiseId'] = $data1['franchiseId'];
        $response['parentProductId'] = $response['_id']['$oid'];
        $response['seqId'] = $data1['seqId'];
        $response['currentDate'] = $data1['currentDate'];
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

        $data['strainEffects']['relaxed'] = (float) number_format($data['strainEffects']['relaxed'], 2);
        $data['strainEffects']['happy'] = (float) number_format($data['strainEffects']['happy'], 2);
        $data['strainEffects']['euphoric'] = (float) number_format($data['strainEffects']['euphoric'], 2);
        $data['strainEffects']['uplifted'] = (float) number_format($data['strainEffects']['uplifted'], 2);
        $data['strainEffects']['creative'] = (float) number_format($data['strainEffects']['creative'], 2);

        $data['medicalAttributes']['stress'] = (float) number_format($data['medicalAttributes']['stress'], 2);
        $data['medicalAttributes']['depression'] = (float) number_format($data['medicalAttributes']['depression'], 2);
        $data['medicalAttributes']['pain'] = (float) number_format($data['medicalAttributes']['pain'], 2);
        $data['medicalAttributes']['headaches'] = (float) number_format($data['medicalAttributes']['headaches'], 2);
        $data['medicalAttributes']['fatigue'] = (float) number_format($data['medicalAttributes']['fatigue'], 2);

        $data['negativeAttributes']['dryMouth'] = (float) number_format($data['negativeAttributes']['dryMouth'], 2);
        $data['negativeAttributes']['dryEyes'] = (float) number_format($data['negativeAttributes']['dryEyes'], 2);
        $data['negativeAttributes']['anxious'] = (float) number_format($data['negativeAttributes']['anxious'], 2);
        $data['negativeAttributes']['paranoid'] = (float) number_format($data['negativeAttributes']['paranoid'], 2);
        $data['negativeAttributes']['dizzy'] = (float) number_format($data['negativeAttributes']['dizzy'], 2);

        if ($data['current_dt']) {
            $data['currentDate'] = $data['current_dt'];
        } else {
            $data['currentDate'] = $data['currentDate'];
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
        //$data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $data['firstCategoryId'] . '.xml';
        $data['fileName'] = dirname(__DIR__)."/../../../xml/" . $data['firstCategoryId'] . '.xml';

        $url = $itemKey . "/" . (string) $pid;
        $this->load->model('Seomodel');
        $this->Seomodel->addContentSitemap($url, $data['fileName']);

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

      //  $data['storeId'] = (string) $data['storeId'];
	
	
       // $getStoreData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['storeId'])))->find_one('stores');
       
		// $data['storeIdArr'] = array((string) $data['storeId']); 
		// $data['storeId'];
		
        // $data['cityId'] = $getStoreData['cityId'];
        // $data['zoneId'] = $getStoreData['serviceZones'];
		
        // $data['storeLatitude'] =(double) $getStoreData['coordinates']['latitude'];
        // $data['storeLongitude'] = (double) $getStoreData['coordinates']['longitude'];
        // $data['storeName'] = $getStoreData['name'];
        // $data['store'] = $getStoreData['sName'];
        // $data['storeAverageRating'] = '';

        // $data['storeType'] = $getStoreData['storeType'];
        // $data['storeTypeMsg'] = $getStoreData['storeTypeMsg'];
        // $data['storeCategoryId'] = $getStoreData['storeCategory'][0]['categoryId'];
        // $data['storeCategoryName'] =(object) $getStoreData['storeCategory'][0]['categoryName'];   
        
         //  $data['storeId'] = (string) $data['storeId'];
	
	
       $getFranchiseData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['franchiseId'])))->find_one('franchise');
        
		$data['storeIdArr'] = array((string) $data['storeId']); 
		$data['storeId'];
		
        $data['cityId'] = $getFranchiseData['cityId'];
        $data['zoneId'] = $getFranchiseData['serviceZones'];
		
        $data['storeLatitude'] =(double) $getFranchiseData['coordinates']['latitude'];
        $data['storeLongitude'] = (double) $getFranchiseData['coordinates']['longitude'];
        $data['storeName'] = $getFranchiseData['name'];
        $data['store'] = $getFranchiseData['sName'];
        $data['storeAverageRating'] = '';

        $data['storeType'] = $getFranchiseData['storeType'];
        $data['storeTypeMsg'] = $getFranchiseData['storeTypeMsg'];
        $data['storeCategoryId'] = $getFranchiseData['storeCategory'][0]['categoryId'];
        $data['storeCategoryName'] =(object) $getFranchiseData['storeCategory'][0]['categoryName'];   
        
       $getCityData = $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($data['cityId'])))->find_one('cities');
        foreach ($getCityData['cities'] as $cities)
            if ($data['cityId'] == $cities['cityId']['$oid']) {
                $taxdetails = $cities['taxDetails'];
//                print_r($taxdetails);
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
              
              //  $uniqueAddonId['storeAddOnId']= $uniqueAddonId['id']['$oid'];
              $uniqueAddonId['storeAddOnId']= $uniqueAddonId['id'];
                unset($uniqueAddonId['id']);
                $uniqueAddonId['id']=(string)new MongoDB\BSON\ObjectID();

                array_push($addOnunique,$uniqueAddonId);
            }
            
            unset($storeAddOnData['isoDate']);
           // $storeAddOnData['isoDate']= $this->mongo_db->date();
            $storeAddOnData['timeStamp']=$date->getTimestamp();
            unset($storeAddOnData['_id']); 
            $storeAddOnData['addOns'] = $addOnunique;           
            array_push($addOnDetails,(object)$storeAddOnData);              
                
        }
      
        $data['addOns'] = $addOnDetails; 
        //changes made 
        unset($data['storeName']);

        // $storeType = $this->session->userdata('badmin')['storeType'];
        // if($storeType==6 || $storeType=="6" ){
        //    $data['rx']=$_POST['rx'];
        //    $data['soldOnline']=$_POST['soldOnline'];
        //    $data['prescriptionRequired']=$_POST['prescriptionRequired'];
        //    $data['productType']=$_POST['productType'];
        //    $data['serialNumber']=$_POST['serialNumber'];
        //    $data['symptoms']=$_POST['symptoms'];
        //    $data['professionalUsageFile']=$_POST['professionalUsageFile'];
        //    $data['personalUsageFile']=$_POST['personalUsageFile']; 
           

        //         if(!isset($data['symptoms'])){

        //             $data['symptoms']=[];
        //         }
        //             if($data['rx']==1 || $data['rx'] == "1"){
        //                 $data['rx'] = TRUE;
        //             }else{
        //                 $data['rx'] = FALSE;
        //             }
                    
        //             if($data['soldOnline']==1 || $data['soldOnline'] == "1"){
        //                 $data['soldOnline'] = TRUE;
                    
        //             }else{
        //                 $data['soldOnline'] = FALSE;
                    
        //             }

        //             if($data['productType']==1 || $data['productType']=="1" ){
        //                 $data['productType']=1;
        //                 $data['productTypeMsg']="Generic";
        //             }else{
        //                 $data['productType']=2;
        //                 $data['productTypeMsg']="Branded";
        //             }

        //             if($data['prescriptionRequired']==1 || $data['prescriptionRequired']=="1" ){
        //                 $data['prescriptionRequired']=TRUE;            
        //             }else{
        //                 $data['prescriptionRequired']=FALSE;            
        //             }

        // }else{
                
        // }
       

    //    echo 'if'; echo '<pre>';print_r($data);die;
          
        if (!$resONE) {
           $data['_id'] = (string) new MongoDB\BSON\ObjectID();
           $url = APILink .'franchise/product';        
           $response = json_decode($this->callapi->CallAPI('POST', $url, $data), true);     
        //    echo '<pre>';print_r($response);die;
        
            return true;
        } else {
            if ($resONE['status'] == 2) {
               $data['_id'] = $resONE['_id']['$oid'];
		
            //    print_r($data); die;     
                $url = $DispatchLink . 'child/product';
                $response = json_decode($this->callapi->CallAPI('POST', $url, $data), true);
              
                return true;
            } else {
                return;
            }
        }
    }


    function AddNewProductData($data1, $category) {
     
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

            if ($_POST['brand']) {
                $brandData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($_POST['brand'])))->find_one('brands');
                $_POST['brandTitle'] = $brandData['name'];
            }

            if ($_POST['size']) {
                foreach ($_POST['size'] as $sizeids) {
                    $sizeData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($sizeids)))->find_one('sizeGroup');
                    $sizes[] = array('sizeId' => $sizeids, 'size' => $sizeData['name']);
                }
            }
            if ($_POST['color']) {
                foreach ($_POST['color'] as $colorId) {
                    $colorData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($colorId)))->find_one('colors');
                    $colors[] = array('colorId' => $colorId, 'color' => $colorData['colorName']);
                }
            }


            $_POST['sizes'] = $sizes;
            $_POST['colors'] = $colors;
            $_POST['categoryName'] = explode(';', $_POST['firstCategoryName']);
            $_POST['subCategoryName'] = explode(';', $_POST['secondCategoryName']);
            $_POST['subSubCategoryName'] = explode(';', $_POST['thirdCategoryName']);

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

            $_POST['POSNam'] =array_values( $_POST['POSName']);
            $_POST['POSName'] = $_POST['POSName'][0];

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


        $_POST['shortDescription'] = $_POST['shortDescription']['en'];
        $_POST['detailedDescription'] = $_POST['detailedDescription']['en'];

            unset($_POST['color'], $_POST['size']); // $_POST['tax'], $_POST['taxFlag']
            unset($_POST['colorData'], $_POST['colorName'], $_POST['color'], $_POST['sizeName'], $_POST['sizeData']);

            $response = $_POST;
            $resONE = '';
        

        $count = count($response['units']);
        $x = 0;
        $y = 0;
        $a = 0;
        $b = 0;
        $xy = 1;
       

        foreach ($response['units'] as $res) {
         
                // $response['units'][$a]['name'] = $res['name'];
                // $response['units'][$a]['price'] = $res['price'];
                $response['units'][$a]['floatValue'] = (float) $res['price']['en'];
                      
            
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

        //changed from store
        $response['franchiseId'] = $data1['franchiseId'];

        $response['parentProductId'] = $data1['parentProductId']; //$response['_id']['$oid'];

        $response['currentDate'] = $data1['currentDate'];
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

        $data['strainEffects']['relaxed'] = (float) number_format($data['strainEffects']['relaxed'], 2);
        $data['strainEffects']['happy'] = (float) number_format($data['strainEffects']['happy'], 2);
        $data['strainEffects']['euphoric'] = (float) number_format($data['strainEffects']['euphoric'], 2);
        $data['strainEffects']['uplifted'] = (float) number_format($data['strainEffects']['uplifted'], 2);
        $data['strainEffects']['creative'] = (float) number_format($data['strainEffects']['creative'], 2);

        $data['medicalAttributes']['stress'] = (float) number_format($data['medicalAttributes']['stress'], 2);
        $data['medicalAttributes']['depression'] = (float) number_format($data['medicalAttributes']['depression'], 2);
        $data['medicalAttributes']['pain'] = (float) number_format($data['medicalAttributes']['pain'], 2);
        $data['medicalAttributes']['headaches'] = (float) number_format($data['medicalAttributes']['headaches'], 2);
        $data['medicalAttributes']['fatigue'] = (float) number_format($data['medicalAttributes']['fatigue'], 2);

        $data['negativeAttributes']['dryMouth'] = (float) number_format($data['negativeAttributes']['dryMouth'], 2);
        $data['negativeAttributes']['dryEyes'] = (float) number_format($data['negativeAttributes']['dryEyes'], 2);
        $data['negativeAttributes']['anxious'] = (float) number_format($data['negativeAttributes']['anxious'], 2);
        $data['negativeAttributes']['paranoid'] = (float) number_format($data['negativeAttributes']['paranoid'], 2);
        $data['negativeAttributes']['dizzy'] = (float) number_format($data['negativeAttributes']['dizzy'], 2);

        if ($data['current_dt']) {
            $data['currentDate'] = $data['current_dt'];
        } else {
            $data['currentDate'] = $data['currentDate'];
        }

        unset($data['status']);
        unset($data['seqId']);
        unset($data['current_dt']);

        $productName = implode(',', $data['productName']);
        $itemKey = str_replace(' ', '-', $productName);
        $data['itemKey'] = str_replace('/', '-', $itemKey);
        //$data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $data['firstCategoryId'] . '.xml';
        $data['fileName'] = dirname(__DIR__)."/../../../xml/" . $data['firstCategoryId'] . '.xml';

        $url = $itemKey . "/" . (string) $pid;
        $this->load->model('Seomodel');
        $this->Seomodel->addContentSitemap($url, $data['fileName']);

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

        // $data['franchiseId'] = (string) $data['franchiseId'];
	
	
        $getFranchiseData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['franchiseId'])))->find_one('franchise');      
	   
        
        
        // $franchiseId = $data['franchiseId']; //$this->session->userdata('fadmin')['MasterBizId'];
        // $data['franchiseId']=$this->session->userdata('fadmin')['MasterBizId'];
        // $data['franchiseId'] = $franchiseId;
        $productName = implode(',', $data['productName']);
        $itemKey = str_replace(' ', '-', $productName);
        $data['itemKey'] = str_replace('/', '-', $itemKey);
        $data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $data['firstCategoryId'] . '.xml';

        $data['parentProductId']='';
        $data['cityId'] = $getFranchiseData['cityId'];
      //  $data['zoneId'] = $getFranchiseData['serviceZones'];
        if ($getFranchiseData['autoApproval'] == 0) {
            $data['status'] = 0;
        } else if ($getFranchiseData['autoApproval'] == 1) {
            $data['status'] = 1;
        }

        
       $getCityData = $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($data['cityId'])))->find_one('cities');
        foreach ($getCityData['cities'] as $cities)
            if ($data['cityId'] == $cities['cityId']['$oid']) {
                $taxdetails = $cities['taxDetails'];
            }
            //  $data['cityId'] =(string) $getFranchiseData['cityId'];
             
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
        unset($data['addOnIds']);
       $date = new DateTime();
     
        $addOnDetails=[];
        $addOnunique=[];
        $tempaddOnunique = [];
        foreach($addon as $addOnData){
            $addOnunique =  [];
         
            $id=$addOnData;           
            $storeAddOnData=$this->mongo_db->where(array("_id"=> new MongoDb\BSON\ObjectID($id)))->find_one('franchiseAddOns');
           
            $storeAddOnData['id']=$storeAddOnData['_id']['$oid'];
          
            foreach($storeAddOnData['addOns'] as $uniqueAddonId){ 
              
              //  $uniqueAddonId['storeAddOnId']= $uniqueAddonId['id']['$oid'];
              $uniqueAddonId['storeAddOnId']= $uniqueAddonId['id'];
                unset($uniqueAddonId['id']);
                $uniqueAddonId['id']=(string)new MongoDB\BSON\ObjectID();

                array_push($addOnunique,$uniqueAddonId);
            }
            
            unset($storeAddOnData['isoDate']);
           // $storeAddOnData['isoDate']= $this->mongo_db->date();
            $storeAddOnData['timeStamp']=$date->getTimestamp();
            unset($storeAddOnData['_id']); 
            $storeAddOnData['addOns'] = $addOnunique;           
            array_push($addOnDetails,(object)$storeAddOnData);              
                
        }
      
        $data['addOns'] = $addOnDetails; 
        //changes made 
        unset($data['storeName']);
            // echo "<pre>"; print_r($data);die;
           $data['_id'] = (string) new MongoDB\BSON\ObjectID();
           $url = APILink .'franchise/product';        
           $response = json_decode($this->callapi->CallAPI('POST', $url, $data), true);     
         
       
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
        
        $result=$this->mongo_db->where(array('status' => 1))->get('franchiseAddOns');
       
        $storeId = $this->session->userdata('fadmin')['MasterBizId'];
        $res=[];
        foreach($result as $storeAddOn){
            if(array_key_exists("centralAddOnId",$storeAddOn) && $storeId==$storeAddOn['storeId'] ){         
                
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

    // Ufly product details modal repo
    function uflyStoreProductDetails($status = '') {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "productName";
        $_POST['mDataProp_1'] = "firstCategoryName";
        $_POST['mDataProp_2'] = "secondCategoryName";
        $_POST['mDataProp_3'] = "thirdCategoryName";
//        $_POST['mDataProp_4'] = "SKU";
//        $_POST['mDataProp_5'] = "barcode";
//        $_POST['mDataProp_6'] = "POSName";
//        $_POST['mDataProp_7'] = "THC";
//        $_POST['mDataProp_8'] = "CBD";
//        $_POST['mDataProp_9'] = "shortDescription";

        $sl = $_POST['iDisplayStart'] + 1;
        $storeSession = $this->session->all_userdata();
        $storeId = $storeSession['badmin']['BizId'];
		if($status == 5 || $status == "5"){
			$status = 1;
		}	
		if($status == 6 || $status == "6"){
			$status = 5;
		}	

        $respo = $this->datatables1->datatable_mongodb('childProducts', array("storeId" => new MongoDB\BSON\ObjectID($storeId), 'status' => (int) $status), 'seqId', -1);

        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
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
          //  $arr[] = '<a class="unitListForStoreProducts textDec" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = ($value['sku'] != '') ? $value['sku'] : 'N/A';
//            $arr[] = ($value['barcode'] != '') ? $value['barcode'] : 'N/A';
//            $arr[] = '<a class="viewShortDescriptionlist textDec" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
////            $arr[] = ($value['detailedDescription'] != '') ? $value['detailedDescription'] : '--';
//            $arr[] = '<a class="viewDetailedDescriptionlist textDec" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = ($value['POSName'] != '') ? $value['POSName'] : 'N/A';
//            $arr[] = ($value['barcodeFormat'] != '') ? $value['barcodeFormat'] : 'N/A';
//            $arr[] = ($value['THC'] != '') ? $value['THC'] : 'N/A';
//            $arr[] = ($value['CBD'] != '') ? $value['CBD'] : 'N/A';
//            $arr[] = '<a class="imglist textDec" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = '<a class="strainEffects textDec" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = '<a class="medicalAttributes textDec" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = '<a class="negativeAttributes textDec" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = '<a class="flavours textDec" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
            $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";


            $datatosend[] = $arr;
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
        $storeId = $this->session->userdata('fadmin')['MasterBizId'];;
        $addOnData=[];
        $storeAddOnCentralId=[];
        $storeAddOn=$this->mongo_db->where(array("status"=>1))->get('franchiseAddOns'); 
        // echo '<pre>';print_r($storeAddOn);die;
        //Fetch all storeAddOn data and centralAddOn present in it and store it in array and conver centralADdonID(String into Object ID for 
        // futher comparisoon) cool
        foreach($storeAddOn as $storeAddOns){
         
          if($storeAddOns['franchiseId']== $storeId){
                             if(array_key_exists("centralAddOnId",$storeAddOns) && $storeId==$storeAddOns['franchiseId'] ){
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
            if(array_key_exists("centralAddOnId",$value) && ($storeId==$value['franchiseId'])){
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
        $data1['franchiseId']=$data['storeId'];
        $data1['addOns']=$addOnList;
        unset($data['storeId']);
        unset($data1['_id']);
        unset($data1['isoDate']);
        $data1['isoDate']= $this->mongo_db->date();
        $data1['timeStamp']=$date->getTimestamp();
       
       $inserted=$this->mongo_db->insert('franchiseAddOns', $data1);
       if($inserted){
           $arr="Success";
       echo json_encode(array('data' => $arr));
       }
    }

    //fetch edit Addon price detail
    function editAddOnsList($id = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('franchiseAddOns');
        $data = $result['addOns'];
        echo json_encode(array('data' => $data));
    }

    // edit Addon price data

    function editAddnewAddOnData(){
        
        $data=$_POST;
        // echo '<pre>';print_r($data);die;
        $id=$data['centralAddOnids'];    
        $storeId=$data['storeId'];        
        $addOnStore=$data['addOnPrice'];
        $addOnStoreCount=count($data['addOnPrice']);       
        
        foreach($data['addOnPrice'] as $addOndata){           
           $priceupdate=$addOndata['value'];          
           $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id),"franchiseId"=>$storeId,"addOns.id"=>$addOndata['addOnId']))->set(array("addOns.$.price"=> $priceupdate))->update('franchiseAddOns');         
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

      //search product
      public function getProductsBySerach() {
        $this->load->library('mongo_db');
        $sSearch = $this->input->post('serachData');
      
        $sRegex = quotemeta($sSearch);
        $sRegex = '^'.$sRegex;
        $sRegex = "$sRegex";
        $searchTermsAny[] = array('productName' => new MongoDB\BSON\Regex($sRegex, "i"));      
        $searchTerms = array();
        $searchTerms['$or'] = $searchTermsAny;  
        $mastersData =  $this->mongo_db->where($searchTerms)->select(array('productName'=>'productName'))->get('products');    
        echo json_encode(array('data'=>$mastersData));

    }

    function getProductDataDetail($id = '') {
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('products');
        echo json_encode(array('data' => $data));
    }

       //store List
       function getAddonData($addOnIds) {
 
        
        $addId=[];
         foreach($addOnIds as $Id){
              if($Id != "multiselect-all")
              $addId[]=new MongoDB\BSON\ObjectID($Id);
         }
    
           $cursor = $this->mongo_db->where(array("_id" =>array('$in'=>$addId) ))->get('franchiseAddOns');
           echo json_encode(array('data' => $cursor));
    
         
         
      
  }

}

?>
 