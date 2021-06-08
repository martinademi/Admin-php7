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

        $this->load->library('Datatables');
        $this->load->library('table');
//        $this->load->library('utility_library');
        $this->load->library('CallAPI');
    }

    function product_details() {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "productName";
        $_POST['mDataProp_6'] = "POSName";
        $_POST['mDataProp_1'] = "firstCategoryName";
        $_POST['mDataProp_2'] = "secondCategoryName";
        $_POST['mDataProp_3'] = "thirdCategoryName";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('products', array("status" => 1), 'seqId', -1);

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();

            if ($value['productName'] != '') {
                if ($value['productName'] != '' && $value['title'] != '') {
                    $productName = $value['productName'][0] . ' - ' . $value['title'];
                }
                if ($value['productName'] != '' && $value['title'] == '') {
                    $productName = $value['productName'][0];
                }
            } else {
                $productName = 'N/A';
            }
            if ($value['POSName'] == '.') {
                $value['POSName'] = $val['POSNam'][0];
            }


            $arr[] = $sl++;
//            $arr[] = '<a class="" href="' . base_url() . 'index.php?/AddNewProducts/productDetails/' . (string) $value['_id']['$oid'] . '" style="cursor :pointer; "  > ' . $productName . '</a>';
            $arr[] = '<img src="' . $value['images'][0]['image'] . '"  width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
            $arr[] = $productName;
//            $arr[] = $productName;
//            $arr[] = ($value['POSName'] != '') ? $value['POSName'] : 'N/A';
            $arr[] = ($value['firstCategoryName'] != '') ? $value['firstCategoryName'] : 'N/A';
            $arr[] = ($value['secondCategoryName'] != '') ? $value['secondCategoryName'] : 'N/A';
            $arr[] = ($value['thirdCategoryName'] != '') ? $value['thirdCategoryName'] : 'N/A';
//            $arr[] = '<a class="unitsList" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = ($value['sku'] != '') ? $value['sku'] : 'N/A';
//            $arr[] = ($value['barcode'] != '') ? $value['barcode'] : 'N/A';
//            $arr[] = '<a class="viewShortDescriptionlist" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            ($value['shortDescription'] != '') ? $value['shortDescription'] : 'N/A';
//            $arr[] = '<a class="viewDetailedDescriptionlist" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = ($value['barcodeFormat'] != '') ? $value['barcodeFormat'] : 'N/A';
//            $arr[] = ($value['THC'] != '') ? $value['THC'] : 'N/A';
//            $arr[] = ($value['CBD'] != '') ? $value['CBD'] : 'N/A';
//            $arr[] = '<a class="imglist" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = '<a class="strainEffects" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = '<a class="medicalAttributes" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = '<a class="negativeAttributes" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
//            $arr[] = '<a class="flavours" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
            $arr[] = '<a class="moveDown btn-padding" id=' . $value['_id']['$oid'] . ' ><button id="' . $value['_id']['$oid'] . '" onclick="moveDown(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9;width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-down"></i> </button></a><a class="moveUp btn-padding" id=' . $value['_id']['$oid'] . '><button id="' . $value['_id']['$oid'] . '" onclick="moveUp(this)" type="button" style="color: #ffffff !important;background-color: #0090d9;border: 1px solid #0090d9; width:37px !important;" class="btn btn-success"><i class="fa fa-arrow-up"></i></button></a>';
            $arr[] = '<button class="btn btn-primary btnWidth editProducts" style="width:35px;"  value=' . $value['_id']['$oid'] . '><i class="fa fa-edit"></i></button>';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatableStoreDetails($status) {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 6;
        $_POST['mDataProp_0'] = "productName";
        $_POST['mDataProp_1'] = "firstCategoryName";
        $_POST['mDataProp_2'] = "secondCategoryName";
        $_POST['mDataProp_3'] = "thirdCategoryName";
        $_POST['mDataProp_4'] = "POSName";
        $_POST['mDataProp_5'] = "storeName";

        $sl = $_POST['iDisplayStart'] + 1;
        switch ($status) {
            case 0:
                $respo = $this->datatables->datatable_mongodb('childProducts', array("status" => 0), 'seqId', -1);
                break;

            case 1:
                $respo = $this->datatables->datatable_mongodb('childProducts', array("status" => 1), 'seqId', -1);
                break;

            case 2:
                $respo = $this->datatables->datatable_mongodb('childProducts', array("status" => 2), 'seqId', -1);
                break;

            case 3:
                $respo = $this->datatables->datatable_mongodb('childProducts', array("status" => 3), 'seqId', -1);
                break;

            case 4:
                $respo = $this->datatables->datatable_mongodb('childProducts', array("status" => 4), 'seqId', -1);
                break;
        }
        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();

            if ($value['productName'] != '') {
                if ($value['productName'] != '' && $value['title'] != '') {
                    $productName = implode(',', $value['productName']) . ' - ' . $value['title'];
                }
                if ($value['productName'] != '' && $value['title'] == '') {
                    $productName = implode(',', $value['productName']);
                }
            } else {
                $productName = 'N/A';
            }

            $arr[] = $sl++;
             $arr[] = '<img src="' . $value['images'][0]['image'] . '"  width="50px" height="50px" class="imageborder" style="border-radius:50%;">';
//            $arr[] = '<a class="" href="' . base_url() . 'index.php?/AddNewProducts/productDetails/' . (string) $value['_id']['$oid'] . '" style="cursor :pointer; "  > ' . $productName . '</a>';
            $arr[] = $productName;
//            $arr[] = ($value['POSNam'] != '') ? implode($value['POSNam'],',') : 'N/A';
            $arr[] = ($value['storeName'] != '') ? $value['storeName'] : 'N/A';
            $arr[] = ($value['createdTimestamp'] != '') ?  date('j-M-Y H:i:s', $value['createdTimestamp']) : 'N/A';
            $arr[] = ($value['firstCategoryName'] != '') ? $value['firstCategoryName'] : 'N/A';
            $arr[] = ($value['secondCategoryName'] != '') ? $value['secondCategoryName'] : 'N/A';
            $arr[] = ($value['thirdCategoryName'] != '') ? $value['thirdCategoryName'] : 'N/A';
            $arr[] = '<a class="storeUnitsList" id="' . $value['_id']['$oid'] . '" style="cursor:pointer;">View</a>';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
     public function getUnitsEdit($id) {

        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');

        echo json_encode(array('result' => $res['units'], 'data' => $res['images']));
    }

    function getData($id = '') {
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('products');
        return $data;
    }

    function getStores() {
        $data = $this->mongo_db->where(array('status' => 1))->get('stores');
        return $data;
    }

    function getAppConfigData() {
        $data = $this->mongo_db->get('appConfig');
        foreach ($data as $result) {
            $res = $result['currencySymbol'];
        }
        return $res;
    }

    function delete_product() {
        $id = $this->input->post('val');
        $ids = $this->input->post('id');

        foreach ($id as $data) {

            $fields = $data;
            $fields = json_encode($fields);
            $headers = array(
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, DispatchLink . 'product/' . $data);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
//               print_r($result); die;
            curl_close($ch);
        }
        echo json_encode($result);
    }

    function banStoreProduct() {
        $id = $this->input->post('val');
        $status = 4;


        foreach ($id as $data) {

            $fields = $data;
            $fields = json_encode($fields);
            $headers = array(
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, DispatchLink . 'child/product/' . $data . '/' . $status);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
//               print_r($result); die;
            curl_close($ch);
        }
        echo json_encode($result);
    }

    function rejectStoreProduct() {
        $id = $this->input->post('val');
        $status = 3;


        foreach ($id as $data) {

            $fields = $data;
            $fields = json_encode($fields);
            $headers = array(
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, DispatchLink . 'child/product/' . $data . '/' . $status);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
//               print_r($result); die;
            curl_close($ch);
        }
        echo json_encode($result);
    }

    function deleteStoreProduct() {
        $id = $this->input->post('val');


        foreach ($id as $data) {

            $fields = $data;
            $fields = json_encode($fields);
            $headers = array(
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, DispatchLink . 'child/product/' . $data);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
//               print_r($result); die;
            curl_close($ch);
        }
        echo json_encode($result);
    }

    function approveStoreProduct() {
        $id = $this->input->post('val');
        $status = 1;

        foreach ($id as $data) {

            $fields = $data;
            $fields = json_encode($fields);
            $headers = array(
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, DispatchLink . 'child/product/' . $data . '/' . $status);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
//               print_r($result); die;
            curl_close($ch);
        }
        echo json_encode($result);
    }

    function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->get('lang_hlp');
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function savealltext() {
        $this->load->library('elasticsearch');
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

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id), 'images.imageId' => (string) $imageid))->set($arr)->update('products');

        return $result;
    }

    function AddNewProductData() {
        
        $x = 0;
        echo "<pre>";
//        print_r($_POST);die;
        $data = $_POST;

        $data['categoryName'] = explode(',', $data['firstCategoryName']);
        $data['subCategoryName'] = explode(',', $data['secondCategoryName']);
        $data['subSubCategoryName'] = explode(',', $data['thirdCategoryName']);
        $data['manufactureName'] = explode(',', $data['manufacturerName']);
        $data['brandTitle'] = explode(',', $data['brandName']);
//        $sizeName = explode(',', $data['sizeName']);
//        $colorName = explode(',', $data['colorName']);
        
//        $data['sizeData'] = array_combine($data['size'], $sizeName);
//        $data['colorData'] = array_combine($data['color'], $colorName);
        
        $lang = $this->mongo_db->get('lang_hlp');
        $lanCodeArr = [];
        $lanIdArr = [];
        foreach ($lang as $lan) {
            $lanCodeArr[0] = "en";
            $lanIdArr[0] = "0";
            array_push($lanCodeArr, $lan['langCode']);
            array_push($lanIdArr, $lan['lan_id']);
        }

        if (count($lanCodeArr) == count($data['productName'])) {
            $data['pName'] = array_combine($lanCodeArr, $data['productName']);
        } else {
            $data['pName']['en'] = $data['productName'][0];
        }
        if (count($lanCodeArr) == count($data['shortDescription'])) {
            $data['sDescription'] = array_combine($lanCodeArr, $data['shortDescription']);
        } else {
            $data['sDescription']['en'] = $data['shortDescription'][0];
        }
        if (count($lanCodeArr) == count($data['detailedDescription'])) {
            $data['detailDescription'] = array_combine($lanCodeArr, $data['detailedDescription']);
        } else {
            $data['detailDescription']['en'] = $data['detailedDescription'][0];
        }

        if (count($lanCodeArr) == count($data['categoryName'])) {
            $data['catName'] = array_combine($lanCodeArr, $data['categoryName']);
        } else {
            $data['catName']['en'] = $data['categoryName'][0];
        }
        if (count($lanCodeArr) == count($data['subCategoryName'])) {
            $data['subCatName'] = array_combine($lanCodeArr, $data['subCategoryName']);
        } else {
            $data['subCatName']['en'] = $data['subCategoryName'][0];
        }
        if (count($lanCodeArr) == count($data['subSubCategoryName'])) {
            $data['subSubCatName'] = array_combine($lanCodeArr, $data['subSubCategoryName']);
        } else {
            $data['subSubCatName']['en'] = $data['subSubCategoryName'][0];
        }
        if (count($lanCodeArr) == count($data['POSName'])) {
            $data['pos'] = array_combine($lanCodeArr, $data['POSName']);
        } else {
            $data['pos']['en'] = $data['POSName'][0];
        }
        if (count($lanCodeArr) == count($data['manufactureName'])) {
            $data['manufactureName'] = array_combine($lanCodeArr, $data['manufactureName']);
        } else {
            $data['manufactureName']['en'] = $data['manufactureName'][0];
        }
        if (count($lanCodeArr) == count($data['brandTitle'])) {
            $data['brandTitle'] = array_combine($lanCodeArr, $data['brandTitle']);
        } else {
            $data['brandTitle']['en'] = $data['brandTitle'][0];
        }
       

        $sizes = array();
        $colors = array();

//        foreach ($data['sizeData'] as $key => $value) {
//            $values = explode("/", $value);
//            if (count($lanCodeArr) == count($values)) {
//                $sizeNam['data'] = array_combine($lanCodeArr, $values);
//            } else {
//                $sizeNam['data']['en'] = $values[0];
//            }
//
//            $sizes[] = array('sizeId' => $key, 'size' => $sizeNam['data']);
//        }
//        foreach ($data['colorData'] as $key => $value) {
//            $values = explode("_", $value);
//             if (count($lanCodeArr) == count($values)) {
//            $colorNam['data'] = array_combine($lanCodeArr, $values);
//        } else {
//            $colorNam['data']['en'] = $values[0];
//        }
//
//            $colors[] = array('colorId' => $key, 'color' => $colorNam['data']);
//        }
    
        foreach ($data['size'] as $sizeids) {
                $sizeData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($sizeids)))->find_one('sizeGroup');
                $sizes[] = array('sizeId' => $sizeids, 'size' => $sizeData['name']);
            }
            foreach ($data['color'] as $colorId) {
                $colorData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($colorId)))->find_one('colors');
                $colors[] = array('colorId' => $colorId, 'color' => $colorData['colorName']);
            }

        $data['sizes'] = $sizes;
        $data['colors'] = $colors;
        $data['shortDesc'] = $data['shortDescription'];
        $data['POSNam'] = $data['POSName'];
        $data['detailedDesc'] = $data['detailedDescription'];
        $data['shortDescription'] = ".";
        $data['detailedDescription'] = ".";
        $data['POSName'] = ".";

$xy =1;
        foreach ($data['units'] as $response) {

            if (strlen($response['name']['en']) != 0 && strlen($response['price']['en']) != 0) {

                $da = new MongoDB\BSON\ObjectID();
                $data1['units'][$x]['name'] = $response['name'];
                $data1['units'][$x]['unitId'] = (string) $da;
                $data1['units'][$x]['price'] = $response['price'];
                $data1['units'][$x]['status'] = "active";
                $sizeAttrs = array();
                foreach ($response['sizeAttr'] as $attrids) {
                    $sizedata = $this->mongo_db->where(array('sizeAttr.' . $xy . '.attrId' => new MongoDB\BSON\ObjectID($attrids)))->find_one('sizeGroup');
                        foreach ($lanCodeArr as $code) {
                         $sizear['attribute'][$code] = $sizedata['sizeAttr'][$xy][$code];
                        }
                         $sizeAttrs[] = array('attrId' => $attrids, 'attribute' => $sizear['attribute'] );
                    $xy++;
                }
               
                $data1['units'][$x]['sizeAttributes'] = $sizeAttrs;
                $x++;
            }
        }

        $data['units'] = $data1['units'];

        if ($data['strainEffects']['relaxed'] != '') {
            $data['strainEffects']['relaxed'] = (float) number_format($data['strainEffects']['relaxed'], 2);
        } else {
            $data['strainEffects']['relaxed'] = 0.00;
        }
        if ($data['strainEffects']['happy'] != '') {
            $data['strainEffects']['happy'] = (float) number_format($data['strainEffects']['happy'], 2);
        } else {
            $data['strainEffects']['happy'] = 0.00;
        }
        if ($data['strainEffects']['euphoric'] != '') {
            $data['strainEffects']['euphoric'] = (float) number_format($data['strainEffects']['euphoric'], 2);
        } else {
            $data['strainEffects']['euphoric'] = 0.00;
        }
        if ($data['strainEffects']['uplifted'] != '') {
            $data['strainEffects']['uplifted'] = (float) number_format($data['strainEffects']['uplifted'], 2);
        } else {
            $data['strainEffects']['uplifted'] = 0.00;
        }
        if ($data['strainEffects']['creative'] != '') {
            $data['strainEffects']['creative'] = (float) number_format($data['strainEffects']['creative'], 2);
        } else {
            $data['strainEffects']['creative'] = 0.00;
        }
        if ($data['medicalAttributes']['stress'] != '') {
            $data['medicalAttributes']['stress'] = (float) number_format($data['medicalAttributes']['stress'], 2);
        } else {
            $data['medicalAttributes']['stress'] = 0.00;
        }
        if ($data['medicalAttributes']['depression'] != '') {
            $data['medicalAttributes']['depression'] = (float) number_format($data['medicalAttributes']['depression'], 2);
        } else {
            $data['medicalAttributes']['depression'] = 0.00;
        }
        if ($data['medicalAttributes']['pain'] != '') {
            $data['medicalAttributes']['pain'] = (float) number_format($data['medicalAttributes']['pain'], 2);
        } else {
            $data['medicalAttributes']['pain'] = 0.00;
        }
        if ($data['medicalAttributes']['headaches'] != '') {
            $data['medicalAttributes']['headaches'] = (float) number_format($data['medicalAttributes']['headaches'], 2);
        } else {
            $data['medicalAttributes']['headaches'] = 0.00;
        }
        if ($data['medicalAttributes']['fatigue'] != '') {
            $data['medicalAttributes']['fatigue'] = (float) number_format($data['medicalAttributes']['fatigue'], 2);
        } else {
            $data['medicalAttributes']['fatigue'] = 0.00;
        }
        if ($data['negativeAttributes']['dryMouth'] != '') {
            $data['negativeAttributes']['dryMouth'] = (float) number_format($data['negativeAttributes']['dryMouth'], 2);
        } else {
            $data['negativeAttributes']['dryMouth'] = 0.00;
        }
        if ($data['negativeAttributes']['dryEyes'] != '') {
            $data['negativeAttributes']['dryEyes'] = (float) number_format($data['negativeAttributes']['dryEyes'], 2);
        } else {
            $data['negativeAttributes']['dryEyes'] = 0.00;
        }
        if ($data['negativeAttributes']['anxious'] != '') {
            $data['negativeAttributes']['anxious'] = (float) number_format($data['negativeAttributes']['anxious'], 2);
        } else {
            $data['negativeAttributes']['anxious'] = 0.00;
        }
        if ($data['negativeAttributes']['paranoid'] != '') {
            $data['negativeAttributes']['paranoid'] = (float) number_format($data['negativeAttributes']['paranoid'], 2);
        } else {
            $data['negativeAttributes']['paranoid'] = 0.00;
        }
        if ($data['negativeAttributes']['dizzy'] != '') {
            $data['negativeAttributes']['dizzy'] = (float) number_format($data['negativeAttributes']['dizzy'], 2);
        } else {
            $data['negativeAttributes']['dizzy'] = 0.00;
        }

        $data['currentDate'] = $data['current_dt'];
        unset($data['current_dt']);
        unset($data['colorData']);
        unset($data['colorName']);
        unset($data['color']);
        unset($data['size']);
        unset($data['sizeName']);
        unset($data['sizeData']);
// echo '<pre>'; print_r($data['images']);  die;
        $y = 0;

        foreach ($data['images'] as $response) {
//            print_r(strlen($response['image']));
            if (strlen($response['image']) != 0) {
                $id = new MongoDB\BSON\ObjectID();
                $data2['images'][$y]['imageId'] = (string) $id;
                $data2['images'][$y]['thumbnail'] = $response['thumbnail'];
                $data2['images'][$y]['mobile'] = $response['mobile'];
                $data2['images'][$y]['image'] = $response['image'];
                if ($response['imageText'])
                    $data2['images'][$y]['imageText'] = $response['imageText'];
                else
                    $data2['images'][$y]['imageText'] = '';

                if ($response['title'])
                    $data2['images'][$y]['title'] = $response['title'];
                else
                    $data2['images'][$y]['title'] = '';

                if ($response['description'])
                    $data2['images'][$y]['description'] = $response['description'];
                else
                    $data2['images'][$y]['description'] = '';

                if ($response['keyword'])
                    $data2['images'][$y]['keyword'] = $response['keyword'];
                else
                    $data2['images'][$y]['keyword'] = '';

                $y++;
            }
        };

        $data['images'] = $data2['images'];


        $productName = implode(',', $data['productName']);
        $itemKey = str_replace(' ', '-', $productName);
        $data['itemKey'] = str_replace('/', '-', $itemKey);
        // $data['fileName'] = $_SERVER["DOCUMENT_ROOT"] . '/../xml/' . $data['firstCategoryId'] . '.xml';
        $data['fileName'] = dirname(__DIR__)."/../../../xml/" . $data['firstCategoryId'] . '.xml';

//        echo '<pre>'; print_r($data);  die;

        $pid = new MongoDB\BSON\ObjectID();
        $data['_id'] = (string) $pid;
        $url = $itemKey . "/" . (string) $pid;
        $this->load->model('Seomodel');
        $this->Seomodel->addContentSitemap($url, $data['fileName']);

        // call node api to add product
        $fields = $data;

        $data['productName'] = array_values($_POST['productName']);
//        $this->mongo_db->insert('testProduct',$data);
    
        $url = DispatchLink . 'product';
        $response = json_decode($this->callapi->CallAPI('POST', $url, $data), true);
//        print_r($response);die;
////        $fields = json_encode($fields);
//         
//        $headers = array(
//            'Content-Type: application/json'
//        );
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, DispatchLink . 'product');
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
//
//        $result = curl_exec($ch);
//           print_r($result); die;
//        curl_close($ch);
    }

    function updateProductData($id = '') {
     
        $data = $_POST; 
        
        $data['categoryName'] = explode(',', $data['firstCategoryName']);
        $data['subCategoryName'] = explode(',', $data['secondCategoryName']);
        $data['subSubCategoryName'] = explode(',', $data['thirdCategoryName']);
        $data['manufactureName'] = explode(',', $data['manufacturerName']);
        $data['brandTitle'] = explode(',', $data['brandName']);
        $lang = $this->mongo_db->get('lang_hlp');
        $lanCodeArr = [];
        $lanIdArr = [];
        foreach ($lang as $lan) {
            $lanCodeArr[0] = "en";
            $lanIdArr[0] = "0";
            array_push($lanCodeArr, $lan['langCode']);
            array_push($lanIdArr, $lan['lan_id']);
        }

        if (count($lanCodeArr) == count($data['productName'])) {
            $data['pName'] = array_combine($lanCodeArr, $data['productName']);
        } else {
            $data['pName']['en'] = $data['productName'][0];
        }
        if (count($lanCodeArr) == count($data['shortDescription'])) {
            $data['sDescription'] = array_combine($lanCodeArr, $data['shortDescription']);
        } else {
            $data['sDescription']['en'] = $data['shortDescription'][0];
        }
        if (count($lanCodeArr) == count($data['detailedDescription'])) {
            $data['detailDescription'] = array_combine($lanCodeArr, $data['detailedDescription']);
        } else {
            $data['detailDescription']['en'] = $data['detailedDescription'][0];
        }

        if (count($lanCodeArr) == count($data['categoryName'])) {
            $data['catName'] = array_combine($lanCodeArr, $data['categoryName']);
        } else {
            $data['catName']['en'] = $data['categoryName'][0];
        }
        if (count($lanCodeArr) == count($data['subCategoryName'])) {
            $data['subCatName'] = array_combine($lanCodeArr, $data['subCategoryName']);
        } else {
            $data['subCatName']['en'] = $data['subCategoryName'][0];
        }
        if (count($lanCodeArr) == count($data['subSubCategoryName'])) {
            $data['subSubCatName'] = array_combine($lanCodeArr, $data['subSubCategoryName']);
        } else {
            $data['subSubCatName']['en'] = $data['subSubCategoryName'][0];
        }
        if (count($lanCodeArr) == count($data['POSName'])) {
            $data['pos'] = array_combine($lanCodeArr, $data['POSName']);
        } else {
            $data['pos']['en'] = $data['POSName'][0];
        }
        if (count($lanCodeArr) == count($data['manufactureName'])) {
            $data['manufactureName'] = array_combine($lanCodeArr, $data['manufactureName']);
        } else {
            $data['manufactureName']['en'] = $data['manufactureName'][0];
        }
        if (count($lanCodeArr) == count($data['brandTitle'])) {
            $data['brandTitle'] = array_combine($lanCodeArr, $data['brandTitle']);
        } else {
            $data['brandTitle']['en'] = $data['brandTitle'][0];
        }
        
         foreach ($data['size'] as $sizeids) {
                $sizeData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($sizeids)))->find_one('sizeGroup');
                $sizes[] = array('sizeId' => $sizeids, 'size' => $sizeData['name']);
            }
            foreach ($data['color'] as $colorId) {
                $colorData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($colorId)))->find_one('colors');
                $colors[] = array('colorId' => $colorId, 'color' => $colorData['colorName']);
            }
//            print_r($data['color']);die;
        $data['sizes'] = $sizes;
        $data['size'] = "";
        
        $data['colors'] = $colors;
        $data['color'] = "";


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
        } else {
            $url = $itemKey . "/" . (string) $id;
            $this->Seomodel->addContentSitemap($url, $data['fileName']);
        }

        $imagearr = [];
        foreach ($data['images'] as $images) {

            if (strlen($images['image']) != 0) {
                if ($images['imageId'] != "") {
                    $images['imageId'] = (string) ($images['imageId']);
                    $images = $images;
                    array_push($imagearr, $images);
                } else {
                    $images['imageId'] = (string) new MongoDB\BSON\ObjectID();
                    $images = $images;
                    array_push($imagearr, $images);
                }
            }
        }
//echo "<pre>";
//        print_r($data);die;
        $data['images'] = $imagearr;
        $data['productId'] = $id;
       
        $data['shortDescription']=$data['shortDescription'][0];
        $data['detailedDesc']=$data['detailedDescription'];
        $data['detailedDescription']=$data['detailedDescription'][0];
        $data['POSName']=$data['POSName'][0];
//        echo '<pre>';
//        print_r($data);
//        die;
        // call node api to add product
        $fields = $data;
        $fields = json_encode($fields);
        $headers = array(
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, DispatchLink . 'product');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
           
        curl_close($ch);
//        print_r($result);die;
        return $result;
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

    public function getUnits($id) {

        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');

        echo json_encode(array('result' => $res['units'], 'data' => $res['images']));
    }

    function insertExcel($data) {

        $this->load->library('elasticsearch');
        $data1 = $data;
        $cursor = $this->mongo_db->get('products');
        $arr = [];

        foreach ($cursor as $catdata) {
            array_push($arr, $catdata['seqId']);
        }
        $max = max($arr);
        $seq = $max + 1;

        $data['seqId'] = $seq;
        $result = $this->mongo_db->insert('products', $data);
        $data['mongoId'] = (string) $result;
        $elasticdata = $data;
        $return = $this->elasticsearch->add('products', $seq, $elasticdata);
    }

    function unitsList($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');
        $data = $result['units'];

        echo json_encode(array('data' => $data));
    }

    function storeUnitsList($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('childProducts');
        $data = $result['units'];
        

        echo json_encode(array('data' => $data));
    }

    function reviewlist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');
        $i = 1;
        foreach ($result as $row)
            $data[] = array($i++, 'Product_Name' => $row['productName'], 'Manufacturer' => $row['manufacturer'], 'Model' => $row['model'], 'Description' => $row['shortDescription']);

        echo json_encode(array('data' => $data));
    }

    function viewDescriptionlist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');

        $data = $result['detailedDescription'];


        echo json_encode(array('data' => $data));
    }

    function viewShortDescriptionlist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');

        $data = $result['shortDescription'];


        echo json_encode(array('data' => $data));
    }

    function imagelist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');
        echo json_encode(array('data' => $result['images']));
    }

    function nutrilist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');

        $i = 1;

        foreach ($result as $row) {
            $data = $row['nutritionFacts'];
        }

        echo json_encode(array('data' => $data));
    }

    function strainEffects($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');
        $data = $result['strainEffects'];

        echo json_encode(array('data' => $data));
    }

    function medicalAttributes($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');
        $data = $result['medicalAttributes'];

        echo json_encode(array('data' => $data));
    }

    function negativeAttributes($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');

        $data = $result['negativeAttributes'];


        echo json_encode(array('data' => $data));
    }

    function flavours($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('products');
        $data = $result['flavours'];

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

    function reorderProductSequence() {
        $Curruntcountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->find_one('products');
        $Prevecountval = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->find_one('products');
        $currcount = $Curruntcountval['seqId'];
        $prevcount = $Prevecountval['seqId'];
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))))->set(array('seqId' => $prevcount))->update('products');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))))->set(array('seqId' => $currcount))->update('products');
    }

}

?>
