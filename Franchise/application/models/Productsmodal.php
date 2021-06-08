<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Productsmodal extends CI_Model {

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
            $arr[] = ($value['productName'] != '') ? $value['productName'] : 'N/A';
            $arr[] = ($value['firstCategoryName'] != '') ? $value['firstCategoryName'] : 'N/A';
            $arr[] = ($value['secondCategoryName'] != '') ? $value['secondCategoryName'] : 'N/A';
            $arr[] = ($value['thirdCategoryName'] != '') ? $value['thirdCategoryName'] : 'N/A';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function product_detailsProducts() {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "pName.en";
        $_POST['mDataProp_1'] = "catName.en";
        $_POST['mDataProp_2'] = "subCatName.en";
        $_POST['mDataProp_3'] = "subSubCatName.en";

        $sl = $_POST['iDisplayStart'] + 1;

      //  $respo = $this->datatables->datatable_mongodb('products', array('status' => 1), '');
        $respo = $this->datatables->datatable_mongodbAggregate('products', array(array('$match'=>array('status' => 1)),array('$sort'=>array('_id'=>-1))),
        array(array('$match'=>array('status' => 1)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1))))
    );
        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $id = (string)$value->_id;
            $value = json_decode(json_encode($value), TRUE);

            $value['_id']['$oid'] =   $id;
            
            $arr = array();
            $productname='';
            $catname ='';
            $subcatname ='';
            $subsubcatname ='';
            if(count($respo['lang'])<1){
               
                $productname=($value['pName']['en'] != "" || $value['pName']['en'] != null) ? $value['pName']['en']: 'N/A';
                $catname = ($value['catName']['en'] != '') ? $value['catName']['en'] : 'N/A';
                $subcatname =($value['subCatName']['en'] != '') ? $value['subCatName']['en'] : 'N/A';
                $subsubcatname =($value['subSubCatName']['en'] != '') ? $value['subSubCatName']['en'] : 'N/A';
            }
                else{
                
                $productname=($value['pName']['en'] != "" || $value['pName']['en'] != null) ? $value['pName']['en']: 'N/A';
                $catname =$catname = ($value['catName']['en'] != '') ? $value['catName']['en'] : 'N/A';
                $subcatname = ($value['subCatName']['en'] != '') ? $value['subCatName']['en'] : 'N/A';
                $subsubcatname =($value['subSubCatName']['en'] != '') ? $value['subSubCatName']['en'] : 'N/A';
                foreach( $respo['lang'] as $lang){
    
                    $lan= $lang['langCode'];
                    $productnames=($value['pName'][$lan] != "" || $value['pName'][$lan] != null) ? $value['pName'][$lan]: '';
                    $catnames = ($value['catName'][$lan] != '') ? $value['catName'][$lan] : '';
                    $subcatnames = ($value['subCatName'][$lan] != '') ? $value['subCatName'][$lan] : '';
                    $subsubcatnames =($value['subSubCatName'][$lan] != '') ? $value['subSubCatName'][$lan] : '';
                    if(strlen( $productnames)>0){
                    $productname.= ',' . $productnames;
                   }
                   if(strlen($catnames)>0)
                   {
                    $catname.= ',' .$catnames;
                   }
                   if(strlen($subcatnames)>0)
                   {
                    $subcatname.= ',' .$subcatnames;
                   }
                   if(strlen($subsubcatnames)>0)
                   {
                    $subsubcatname.= ',' .$subsubcatnames;
                   }
                }
    
    
               }
            $arr[] = $sl++;
            $arr[] = $productname; //($value['pName']['en'] != '') ? $value['pName']['en'] : 'N/A';
            $arr[] = $catname; //($value['catName']['en'] != '') ? $value['catName']['en'] : 'N/A';
            $arr[] = $subcatname; //($value['subCatName']['en'] != '') ? $value['subCatName']['en'] : 'N/A';
            $arr[] = $subsubcatname ; //($value['subSubCatName']['en'] != '') ? $value['subSubCatName']['en'] : 'N/A';
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
       
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('franchiseProducts');
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

        $_POST['franchiseId'] = (string)$this->session->userdata('fadmin')['MasterBizId'];;
        $getFranchiseData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($_POST['franchiseId'])))->find_one('franchise');
        $_POST['cityId'] = $getFranchiseData['cityId'];

        $getCityData = $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($_POST['cityId'])))->find_one('cities');
        foreach ($getCityData['cities'] as $cities)
            if ($_POST['cityId'] == $cities['cityId']['$oid']) {
                $taxdetails = $cities['taxDetails'];
            }

        if ($_POST['tax']) {
            foreach ($_POST['tax'] as $taxId) {
                $taxData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($taxId)))->find_one('taxes');
                foreach ($taxdetails as $taxids) {
                    if ($taxids['Id'] == $taxId) {
                        $taxvalue = floatval($taxids['value']);
                    }
                }

                $taxes[] = array('taxId' => $taxId, 'taxname' => $taxData['name'], 'taxCode' => $taxData['taxCode'], 'taxValue' => $taxvalue);
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
        $_POST['shortDesc'] = $_POST['shortDescription'];
        $_POST['POSNam'] = $_POST['POSName'];
        $_POST['detailedDesc'] = $_POST['detailedDescription'];
        $_POST['shortDescription'] = $_POST['shortDescription'][0];
        $_POST['detailedDescription'] = $_POST['detailedDescription'][0];
        $_POST['POSName'] = $_POST['POSName'][0];

        unset($_POST['color'], $_POST['size'], $_POST['tax'], $_POST['taxFlag']);
        unset($_POST['colorData'], $_POST['colorName'], $_POST['color'], $_POST['sizeName'], $_POST['sizeData']);

        $data = $_POST;

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
                $storeAddOnData = $this->mongo_db->where(array("_id"=> new MongoDb\BSON\ObjectID($idaddOn)))->find_one('franchiseAddOns');
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

        $url = APILink.'franchise/product';
        $fields = $data;
        $fields = json_encode($fields);
        $headers = array(
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        curl_close($ch);

       print_r($result); die;
        return $result;
    }

    public function getUnitsEdit($id) {

        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('franchiseProducts');

        echo json_encode(array('result' => $res['units'], 'data' => $res['images']));
    }

    function delete_product() {
        $id = $this->input->post('val');

        $fields = implode(',', $id);
        $fields = json_encode($fields);
        $headers = array(
            'Content-Type: application/json'
        );
       // print_r($fields);
     //   die;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.deliv-x.com/child/product/" . $fields);
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

        $res = $this->mongo_db->where(array('status' => 1))->get('manufacturer');

        return $res;
    }

    public function getBrands() {

        $res = $this->mongo_db->where(array('status' => 1))->get('brands');
        return $res;
    }

    public function getTaxData($franchiseId) {
        $storeData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($franchiseId)))->find_one('franchise');

        $res = $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($storeData['cityId'])))->get('cities');
//        $res = $this->mongo_db->where(array('cities.cityId' => $storeData['cityId']))->get('taxes');
        
        foreach ($res as $r) {
            foreach ($r['cities'] as $taxData) {
                if ($storeData['cityId'] == $taxData['cityId']['$oid']) {
                    $arr = $taxData['taxDetails'];
                }
            }
        }
//        print_r($arr);
//        die;
        return $arr;
    }

    public function copy_firstcategory_for_new_product($categoryId, $storeIds) {

//        print_r($categoryId);
//        print_r($storeIds);
        $setData = [];
        foreach ($storeIds as $storeId) {
            $checkCategory = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($categoryId)))->find_one('firstCategory');

            if (count($checkCategory) > 0) {
                if ($checkCategory['addedFrom'])
                    $setData['addedFrom'] = "franchise";

                if ($checkCategory['franchiseId'])
                    $setData['franchiseId'] = $this->session->userdata('fadmin')['MasterBizId'];

                if (!$checkCategory['storeId']) {
                    $setData['storeId'][] = $storeId;
                } else {
                    if (!in_array($checkCategory['storeId'], $storeId)) {
                        $setData['storeId'][] = $storeId;
                    }
                }
//                print_r($checkCategory['_id']); die;
                $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($checkCategory['_id']['$oid'])))->set($setData)->update('firstCategory');
//                print_r($result); die;
            }
        }
//        die;
    }

    public function copy_secondcategory_for_new_product($secondcategoryId, $storeIds) {

//        print_r($secondcategoryId);
//        print_r($storeIds);
        $setData = [];
        foreach ($storeIds as $storeId) {
            $checkCategory = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($secondcategoryId)))->find_one('secondCategory');
//           echo '<pre>'; 
            if (count($checkCategory) > 0) {
                if (!$checkCategory['addedFrom'])
                    $setData['addedFrom'] = "franchise";

                if (!$checkCategory['franchiseId'])
                    $setData['franchiseId'] = $this->session->userdata('fadmin')['MasterBizId'];

                if (!$checkCategory['storeId']) {
                    $setData['storeId'][] = $storeId;
                } else {
                    if (!in_array($checkCategory['storeId'], $storeId)) {
                        $setData['storeId'][] = $storeId;
                    }
                }
//                print_r($setData);
                $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($checkCategory['_id']['$oid'])))->set($setData)->update('secondCategory');
            }
        }
//        die;
    }

    public function copy_thirdcategory_for_new_product($thirdcategoryId, $storeIds) {

//        print_r($thirdcategoryId);
//        print_r($storeIds);
        $setData = [];
        foreach ($storeIds as $storeId) {
            $checkCategory = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($thirdcategoryId)))->find_one('thirdCategory');
//           echo '<pre>'; 
            if (count($checkCategory) > 0) {
                if (!$checkCategory['addedFrom'])
                    $setData['addedFrom'] = "franchise";

                if (!$checkCategory['franchiseId'])
                    $setData['franchiseId'] = $this->session->userdata('fadmin')['MasterBizId'];

                if (!$checkCategory['storeId']) {
                    $setData['storeId'][] = $storeId;
                } else {
                    if (!in_array($checkCategory['storeId'], $storeId)) {
                        $setData['storeId'][] = $storeId;
                    }
                }
//                print_r($setData);
                $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID(($checkCategory['_id']['$oid']))))->set($setData)->update('secondCategory');
            }
        }
//        die;
    }
    function AddNewProductDataold(){
        $postdata = $_POST;
        $ids = $postdata['val'];
       
        $productData = json_decode($postdata['productData'],true);
       // $productData['_id']=(string) $productData['_id']['$oid'];
        unset($productData['seqId']);
        $productData['franchiseId']= $this->session->userdata('fadmin')['MasterBizId'];

       // print_r($productData['units']);
        $unitarr = $postdata['unitarr'];
        $counter=0;
        foreach($productData['units'] as $pdata){
            $activeFlag=0;
          
            foreach($ids as $uid){
                if($pdata['unitId'] == $uid){
                    $productData['units'][$counter]['status']="active";
                    $activeFlag=1;
                    break;
                }
               
                
            }
            if(!$activeFlag){
                $productData['units'][$counter]['status']="inactive";
            }
           $counter++;

        }
        $counter=0;
        foreach($unitarr as $addedunits){
            $newuid=(string) new MongoDB\BSON\ObjectID();
            $unitarr[$counter]['unitId']=$newuid;
            $unitarr[$counter]['status']="active";
            $unitarr[$counter]['floatValue']=(float) $addedunits['price'][0];
            $unitarr[$counter]['sizeAttributes'] = $addedunits['sizeAttr'];
            array_push($productData['units'],$unitarr[$counter]);
            $counter++;
        }
     
        $productData['storeIdArr']=["0"];
        unset($productData['_id']);
    
        $url =  'https://api.deliv-x.com/child/product';
        $response = json_decode($this->callapi->CallAPI('POST', $url, $productData), true);
        // echo '<pre>';print_r($response);die;
        echo json_encode($response);

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
       

        // foreach ($response['units'] as $res) {
         
        //         $response['units'][$a]['floatValue'] = (float) $res['price']['en'];
        //         $sizeAttrs = array();

        //         foreach ($response['units'][$a]['sizeAttr'] as $attrids) { 
        //             for ($i = 1;; $i++) {
        //                 $sizedata = $this->mongo_db->where(array('sizeAttr.' . $i . '.attrId' => new MongoDB\BSON\ObjectID($attrids)))->find_one('sizeGroup');             
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
        // }

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
                $storeAddOnData = $this->mongo_db->where(array("_id"=> new MongoDb\BSON\ObjectID($id)))->find_one('franchiseAddOns');
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
            $response['units'][$a]['availableQuantity']=0;
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
        // $productName = implode(',', $data['productName']);
        // $itemKey = str_replace(' ', '-', $productName);
        // $data['itemKey'] = str_replace('/', '-', $itemKey);
        // $data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $data['firstCategoryId'] . '.xml';

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
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('franchise');
        $res = $result['serviceZones'];
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
        $id = $this->input->post('val');
//        foreach ($ids as $id) {
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');
//        }
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

    function GetAllBusinesses($masId) {
        $this->load->library('mongo_db');
        $data = array();
        $det = $this->mongo_db->get_where('stores', array('status' => 1, "franchiseId" => $masId));
        foreach ($det as $detail) {
            $data[] = $detail;
        }
        return $data;
    }

    // Ufly product details modal
    function StoreProductDetails($status = '') {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "productName";
        $_POST['mDataProp_1'] = "firstCategoryName";
        $_POST['mDataProp_2'] = "secondCategoryName";
        $_POST['mDataProp_3'] = "thirdCategoryName";

        $sl = $_POST['iDisplayStart'] + 1;
//        $storeSession = $this->session->all_userdata();
        $franchiseId = $this->session->userdata('fadmin')['MasterBizId'];


        $respo = $this->datatables->datatable_mongodb('franchiseProducts', array("franchiseId" => $franchiseId, 'status' => (int) $status), 'seqId', -1);
        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        $aaData = $respo["aaData"];
        $datatosend = array();

     
        foreach ($aaData as $value) {
            $arr = array();
            $productname='';
            $catname ='';
            $subcatname ='';
            $subsubcatname ='';
            if(count($respo['lang'])<1){
               
                $productname=($value['productname']['en'] != "" || $value['productname']['en'] != null) ? $value['productname']['en']: 'N/A';
                $catname = ($value['catName']['en'] != '') ? $value['catName']['en'] : 'N/A';
                $subcatname =($value['subCatName']['en'] != '') ? $value['subCatName']['en'] : 'N/A';
                $subsubcatname =($value['subSubCatName']['en'] != '') ? $value['subSubCatName']['en'] : 'N/A';
            }
                else{
                
                $productname=($value['productname']['en'] != "" || $value['productname']['en'] != null) ? $value['productname']['en']: 'N/A';
                $catname =$catname = ($value['catName']['en'] != '') ? $value['catName']['en'] : 'N/A';
                $subcatname = ($value['subCatName']['en'] != '') ? $value['subCatName']['en'] : 'N/A';
                $subsubcatname =($value['subSubCatName']['en'] != '') ? $value['subSubCatName']['en'] : 'N/A';
                foreach( $respo['lang'] as $lang){
    
                    $lan= $lang['langCode'];
                    $productnames=($value['productname'][$lan] != "" || $value['productname'][$lan] != null) ? $value['productname'][$lan]: '';
                    $catnames = ($value['catName'][$lan] != '') ? $value['catName'][$lan] : '';
                    $subcatnames = ($value['subCatName'][$lan] != '') ? $value['subCatName'][$lan] : '';
                    $subsubcatnames =($value['subSubCatName'][$lan] != '') ? $value['subSubCatName'][$lan] : '';
                    if(strlen( $productnames)>0){
                    $productname.= ',' . $productnames;
                   }
                   if(strlen($catnames)>0)
                   {
                    $catname.= ',' .$catnames;
                   }
                   if(strlen($subcatnames)>0)
                   {
                    $subcatname.= ',' .$subcatnames;
                   }
                   if(strlen($subsubcatnames)>0)
                   {
                    $subsubcatname.= ',' .$subsubcatnames;
                   }
                }
    
    
               }
            $arr[] = $sl++;
            $arr[] = $productname; //($value['pName']['en'] != '') ? $value['pName']['en'] : 'N/A';
            $arr[] = $catname; //($value['catName']['en'] != '') ? $value['catName']['en'] : 'N/A';
            $arr[] = $subcatname; //($value['subCatName']['en'] != '') ? $value['subCatName']['en'] : 'N/A';
            $arr[] = $subsubcatname ; //($value['subSubCatName']['en'] != '') ? $value['subSubCatName']['en'] : 'N/A';
            $arr[] = '<a class="unitListForStoreProducts textDec" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
            $arr[] = '<button class="btn btn-success addToStores" data-id="' . $value['_id']['$oid'] . '" style="font-size:11px !important;" >Add to stores</button>';
			$arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
	function StoreListDetails($status = '') {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "productName";
        $_POST['mDataProp_1'] = "firstCategoryName";
        $_POST['mDataProp_2'] = "secondCategoryName";
        $_POST['mDataProp_3'] = "thirdCategoryName";

        $sl = $_POST['iDisplayStart'] + 1;
//        $storeSession = $this->session->all_userdata();
        $franchiseId = $this->session->userdata('fadmin')['MasterBizId'];


        $respo = $this->datatables->datatable_mongodb('stores', array("franchiseId" => $franchiseId, 'status' => 1), 'seqId', -1);
        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        $aaData = $respo["aaData"];
        $datatosend = array();

       
        foreach ($aaData as $value) {
            $arr = array();
            $productname='';
            $catname ='';
            $subcatname ='';
            $subsubcatname ='';
            if(count($respo['lang'])<1){
               
                $productname=($value['sName']['en'] != "" || $value['sName']['en'] != null) ? $value['sName']['en']: 'N/A';
                
            }
                else{
                
                $productname=($value['sName']['en'] != "" || $value['sName']['en'] != null) ? $value['sName']['en']: 'N/A';
               
                foreach( $respo['lang'] as $lang){
    
                    $lan= $lang['langCode'];
                    $productnames=($value['sName'][$lan] != "" || $value['sName'][$lan] != null) ? $value['sName'][$lan]: '';
                    
                    if(strlen( $productnames)>0){
                    $productname.= ',' . $productnames;
                   }
                  
                }
    
    
               }
            $arr[] = $sl++;
            $arr[] = $productname; //($value['pName']['en'] != '') ? $value['pName']['en'] : 'N/A';
            $arr[] = $value['storeTypeMsg'];
           
            //$arr[] = '<button class="btn btn-success pushToStores" data-id="' . $value['_id']['$oid'] . '" style="font-size:11px !important;" >Add to stores</button>';
			$arr[] = "<input type='checkbox' class='checkbox checkboxProductToPush' id='checkboxProductToPush' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
	public function getProductName($id){
		$res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('franchiseProducts');
		
		return $res['productname']['en'];
	}
	// public function pushFranchiseProductsToStores(){
	// 	 $val = $this->input->post("val");
	// 	 $productId = $this->input->post("productId");
	// 	 $productData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($productId)))->find_one('childProducts');
	// 	 unset($productData['_id']);
	// 	 unset($productData['storeId']);
	// 	 unset($productData['statusMsg']);
	// 	 unset($productData['seqId']);
	// 	 unset($productData['productname']);
	// 	 unset($productData['location']);
    //      unset($productData['actions']);
    //      $productData['productName']=array();
    //      $productData['zoneId']=array();
    //      unset($productData['addOns']);
	// 	 $productData['storeIdArr'] = $val;
	// 	 $fields = json_encode($productData);
    //     $headers = array(
    //         'Content-Type: application/json'
    //     );
   

    //     $url =  'https://api.flexyapp.com/child/product';
    //     $response = json_decode($this->callapi->CallAPI('POST', $url, $productData), true);
    //     echo '<pre>';print_r($response);die;
    //     echo json_encode($response);         
		
    // }
    
    public function pushFranchiseProductsToStores(){
      
        $val = $this->input->post("val");
        $productId = $this->input->post("productId");
        $productDataResult = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($productId)))->find_one('franchiseProducts');      
       // echo '<pre>';print_r($productDataResult);die;
        $productDataResult['firstCategoryName']="firstCategoryName";
        $resultArray = array();
        $x = 0;
        foreach($val as $storeId){
        $productData = $productDataResult;
        $i =0;
        $flag = 0;
        $childProductId = '';
        $childResult = array();
        // echo '<pre>';print_r($productData['productname']);die;
            
        $data['store'] = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($storeId)))->find_one('stores');         
        // echo '<pre>';print_r($data['store']);die;

        $productData['brand']=(string)$productData['brand']['$oid'];
        $productData['_id']=(string)new MongoDB\BSON\ObjectID();
        $productData['franciseProductId']= (string) $productData['_id']['$oid'];
        $productData['storeId']=$data['store']['_id']['$oid'];
        $productData['storeLatitude']=$data['store']['coordinates']['latitude'];
        $productData['storeLongitude']=$data['store']['coordinates']['longitude'];
        $productData['storeAverageRating']=(int)$data['store']['storeAverageRating'];
        $productData['storeType']=$data['store']['storeType'];
        $productData['storeTypeMsg']=$data['store']['storeTypeMsg'];
        $productData['storeCategoryId']=(string)$data['store']['storeCategory'][0]['categoryId'];
        $productData['storeCategoryName']=$data['store']['storeCategory'][0]['categoryName'];
        $productData['storeName'] = $data['store']['name'];
        $productData['cityId'] =  $data['store']['cityId'];
        $productData['zoneId'] = $data['store']['serviceZones'];		
        $productData['name'] = $productData['productname'];		
        unset($productData['productname']);
        unset($productData['seqId']);
        unset($productData['statusMsg']);
        unset($productData['actions']);
       
    //    echo '<pre>';print_r($productData);

    $url =  APILink.'franchise/productToStore';

    $fields =$productData;
    $fields = json_encode($fields);
    $headers = array(
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    //    print_r($result); die;

    curl_close($ch);

  
   // return $result;
   

       
        // // echo $url;die;
        // $response = json_decode($this->callapi->CallAPI('POST', $url, $productData), true);
        // echo '<pre>';print_r($response);
        // // $resultArray[$x] =$response; 
        // $resultArray[$x] =array('msg'=>'units updated','storeName'=>$storeData['sName']['en']); 


       


    //    if($childProductId && $flag == 0){
    //        // add more units in child product
    //        foreach($productData['units'] as $extraunits){
    //            array_push($childResult['units'] , $extraunits);
    //        }
           
    //            $url =  APILink.'franchise/productToStore';
    //            $response = json_decode($this->callapi->CallAPI('PATCH', $url, $childResult), true);
              
    //            // $resultArray[$x] =$response; 
    //            $resultArray[$x] =array('msg'=>'units updated','storeName'=>$storeData['sName']['en']); 
               
               
    //    }else if($childProductId && $flag == 1){
    //        // $x++;
    //        $resultArray[$x] =array('msg'=>'product existed','storeName'=>$storeData['sName']['en']); 
    //        // continue;
    //    }
    //    else{

    //     $productData['name']= $productData['pName'];
    //     unset($productData['_id']);
    //     unset($productData['storeId']);
    //     unset($productData['statusMsg']);
    //     unset($productData['seqId']);
    //     unset($productData['productname']);
    //     unset($productData['location']);
    //     unset($productData['actions']);
    //    //  $productData['productName']=array();
    //     $productData['zoneId']=$storeData['serviceZones'];
    //     $productData['_id']= (string)new MongoDB\BSON\ObjectID();
    //     $productData['parentProductId'] = $this->session->userdata('fadmin')['MasterBizId'];
    //     $productData['storeId']=$storeId;
    //     unset($productData['createdBy']);
    //     unset($productData['productId']);

    //    $url =  APILink.'franchise/productToStore';
    //    $response = json_decode($this->callapi->CallAPI('POST', $url, $productData), true);
    //    $resultArray[$x] =array('msg'=>'product added','storeName'=>$storeData['sName']['en']); 

    //    }

       $x++;
   }
        
      
   echo json_encode(array("statusCode" =>200));
        
       
   }

   public function getAddOns(){
        
    $result=$this->mongo_db->where(array('status' => 1))->get('franchiseAddOns');
    $storeId = $this->session->userdata('fadmin')['MasterBizId'];
    $res=[];
    foreach($result as $storeAddOn){
        if(array_key_exists("centralAddOnId",$storeAddOn) && $storeId==$storeAddOn['franchiseId'] ){         
            
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

    function editAddOnsList($id = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('franchiseAddOns');
        $data = $result['addOns'];
        echo json_encode(array('data' => $data));
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

  function getStore(){

    $data = $this->mongo_db->where(array('franchiseId' => $this->session->userdata('fadmin')['MasterBizId'], 'status' => 1))->select(array('sName'=>'sName'))->get('stores');
    echo json_encode(array('data'=>$data));
}



    function pullProductToStore(){  

            $id = $this->input->post('val');
            $sid=$this->input->post('id');
            $fid=$this->session->userdata('fadmin')['MasterBizId'];


            foreach($sid as $stId){
                $storeId=$stId;
                    foreach( $storeId as $storeIds){
                        $storeId1=$storeIds;
                    }
             }

            // data to be sent
            $data['franciseId']= $fid;
            $data['franchiseStoreIDS']=$storeId1;
            $data['franchiseProductIDS']=$id ;

            // echo '<pre>';print_r($data);die;
            $fields = $data;
            $fields = json_encode($fields);
            $headers = array(
                'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, APILink . 'franchise/multiproductToStore');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    
            $result = curl_exec($ch);
            curl_close($ch);
                
            echo json_encode($result);

    }



}

?>
 