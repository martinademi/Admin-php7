<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//echo 222222; die;
class Franchisemodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('utility_library');
        $this->load->library('CallAPI');
        $this->load->model("Customermodel"); 
    }

    function deleteFranchise() {
        $id = $this->input->post('val');
        foreach ($id as $row) {
            echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array("status" => (int) 4, 'statusMsg' => "Deleted"))->update('franchise');
        }
    }

    function businessData() {

        $MAsterData = $this->mongo_db->get('stores');
        $data = array();

        foreach ($MAsterData as $driver) {
            $data[] = array('businessname' => $driver['ProviderName'], 'masterid' => ($driver['_id']['$oid']));
        }

        return $data;
    }

    function get_lan_hlpText($param = '') {

        if ($param == '') {
            $where = array('Active' => 1);
            $res = $this->mongo_db->get_where('lang_hlp', $where);
        } else {
            $where = array('$and' => array(array('lan_id' => (int) $param), array('Active' => 1)));
            $res = $this->mongo_db->get_where('lang_hlp', $where);
        }
        return $res;
    }

    function getFranchisedata($id) {

        $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('franchise');
//        foreach ($getData as $data) {
//            $res[] = $data;
//        }
        return $getData;
    }

    function getCountryCities() {

        $country = $this->mongo_db->get("cities");
        foreach ($country as $coun) {
            $res[] = $coun;
        }
        return $res;
    }

    function storecategoryData() {

        $country = $this->mongo_db->get("storeCategory");
        foreach ($country as $coun) {
            $res[] = $coun;
        }
        return $res;
    }

    function getZonesWithCities() {

        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("city_ID" => $val,'status'=>1))->get('zones');
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
//            $entities = array();
//            $entities = '<option value="">Select Zones</option>';
//            $entities .= '<option data-name="" value="">' . 'No zones to select' . '</option>';
//            echo $entities;
            echo json_encode(array('data' => 0));
        }
    }

    function datatable_business($status = '') {

        
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "franchiseName";
        $_POST['mDataProp_1'] = "storeCategory.categoryName.en";
        $_POST['mDataProp_2'] = "storeSubCategory.subCategoryName.en";
        $_POST['mDataProp_3'] = "email";

        $respo = $this->datatables->datatable_mongodb('franchise', array('status' => (int) $status), 'seqId', -1);
        $timeOffset = (int)$this->session->userdata("timeOffset");
       
        $aaData = $respo["aaData"];
        $datatosend = array();
        $index = $_POST['iDisplayStart'] + 1;
        foreach ($aaData as $value) {
            if ($value['status'] == '1') {
                $string = "Active";
            } else if ($value['status'] == '3') {
                $string = "New";
            } else if ($value['status'] == '5') {
                $string = "Inactive";
            } else if ($value['status'] == '6') {
                $string = "Active";
            }

            $categoryName = $subCategoryName = '';
            foreach ($value['storeCategory'] as $cat) {
                $categoryName = $cat['categoryName']['en'];
            }
            foreach ($value['storeSubCategory'] as $subcat) {
                $subCategoryName = $subcat['subCategoryName']['en'];
            }

            $arr = array();
            $arr[] = $index++;
            $arr[] = '<a target="_blank" href="' . franchiseLink . 'index.php?/Franchise/FromAdmin/' . (string) $value['_id']['$oid'] . '/'.$timeOffset.'"  data-toggle="modal">' . implode($value['franchiseName'], ',') . ' </a>';
            $arr[] = ($categoryName != '') ? $categoryName : '-';
            $arr[] = ($subCategoryName != '') ? $subCategoryName : '-';
            $arr[] = $this->Customermodel->maskFileds($value['email'], 1);
            $arr[] = '<button class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = '<input type="checkbox"  data-id="' . $value['seqID'] . '" class="checkbox" value=' . $value['_id']['$oid'] . ' >';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function inactivefranchise() {

        $val = $this->input->post('val');

        foreach ($val as $row) {
            echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array("status" => 3, 'statusMsg' => "Inactive"))->update('franchise');
        }
//        echo json_encode(array("_id" => $val ));
    }

    function validateEmail() {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('email' => $this->input->post('email'),'status'=>array('$nin'=>[4])))->get('franchise');
        $cout = count($res);

//        $cout = $this->mongo_db->count_all_results('stores', array('email' => $this->input->post('email')));
        $result = 0;
//        print_r($cout);
        if ($cout > 0) {
            $result = 1;
        }

        echo json_encode(array('msg' => $result));
    }
    function validatePhone() {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('phone' => $this->input->post('phoneval'),'status'=>array('$nin'=>[4])))->get('franchise');
        $cout = count($res);

//        $cout = $this->mongo_db->count_all_results('stores', array('email' => $this->input->post('email')));
        $result = 0;
//        print_r($cout);
        if ($cout > 0) {
            $result = 1;
        }

        echo json_encode(array('msg' => $result));
    }

    function insert() {

        $data = $_POST;
      

        if ($data['Facebook'])
            $data['socialLinks']['Facebook'] = $data['Facebook'];
        else
            $data['socialLinks']['Facebook'] = '';
        if ($data['Twitter'])
            $data['socialLinks']['Twitter'] = $data['Twitter'];
        else
            $data['socialLinks']['Twitter'] = '';
        if ($data['Instagram'])
            $data['socialLinks']['Instagram'] = $data['Instagram'];
        else
            $data['socialLinks']['Instagram'] = '';
        if ($data['LinkedIn'])
            $data['socialLinks']['LinkedIn'] = $data['LinkedIn'];
        else
            $data['socialLinks']['LinkedIn'] = '';
        if ($data['Google'])
            $data['socialLinks']['Google'] = $data['Google'];
        else
            $data['socialLinks']['Google'] = '';

        unset($data['Facebook'], $data['Twitter'], $data['Instagram'], $data['LinkedIn'], $data['Google']);

        if ($data['categoryId']) {
            $categoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['categoryId'])))->find_one('storeCategory');
            $category[] = array('categoryId' => $data['categoryId'], 'categoryName' => $categoryData['storeCategoryName']);
            $data['storeCategory'] = $category;
        } else {
            $data['storeCategory'] = [];
        }

        $data['storeType'] = $categoryData['type'];
        $data['storeTypeMsg'] = $categoryData['typeName'];

        if ($data['subCategoryId']) {
            $subcategoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['subCategoryId'])))->find_one('storeSubCategory');
            $subcategory[] = array('subCategoryId' => $data['subCategoryId'], 'subCategoryName' => $subcategoryData['storeSubCategoryName']);
            $data['storeSubCategory'] = $subcategory;
        } else {
            $data['storeSubCategory'] = [];
        }
        unset($data['CategoryId'], $data['SubCategoryId']);

        if ($data['Autoapproval'] == 'on') {
            $data['autoApproval'] = 1; // enable
            $data['autoApprovalMsg'] = "Enable";
        } else {
            $data['autoApproval'] = 0; // disable
            $data['autoApprovalMsg'] = "Disable";
        }
        unset($data['Autoapproval']);

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

        if (count($lanCodeArr) == count($data['franchiseName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['franchiseName']);
        } else if (count($lanCodeArr) < count($data['franchiseName'])) {
            $data['name']['en'] = $data['franchiseName'][0];

            foreach ($data['franchiseName'] as $key => $val) {
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
            $data['name']['en'] = $data['franchiseName'][0];
        }

        if ($data['franchiseDescription']) {
            if (count($lanCodeArr) == count($data['franchiseDescription'])) {
                $data['description'] = array_combine($lanCodeArr, $data['franchiseDescription']);
            } else if (count($lanCodeArr) < count($data['franchiseDescription'])) {
                $data['description']['en'] = $data['franchiseDescription'][0];

                foreach ($data['franchiseDescription'] as $key => $val) {
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
                $data['description']['en'] = $data['franchiseDescription'][0];
            }
        } else {
            $data['description']['en'] = '';
            $data['franchiseDescription'] = [];
        }

        $data['profileLogos']['logoImage'] = $data['profileImage'];
        if ($data['profileAllText']) {
            $data['profileLogos']['seoAllText'] = $data['profileAllText'];
        } else {
            $data['profileLogos']['seoAllText'] = '';
        }
        if ($data['profileSeoTitle']) {
            $data['profileLogos']['seoTitle'] = $data['profileSeoTitle'];
        } else {
            $data['profileLogos']['seoTitle'] = '';
        }
        if ($data['profileSeoTitle']) {
            $data['profileLogos']['seoDescription'] = $data['profileSeoDesc'];
        } else {
            $data['profileLogos']['seoDescription'] = '';
        }
        if ($data['profileSeoKeyword']) {
            $data['profileLogos']['seoKeyword'] = $data['profileSeoKeyword'];
        } else {
            $data['profileLogos']['seoKeyword'] = '';
        }

        $data['bannerLogos']['bannerimage'] = $data['bannerImage'];
        if ($data['bannerAllText']) {
            $data['bannerLogos']['seoAllText'] = $data['bannerAllText'];
        } else {
            $data['bannerLogos']['seoAllText'] = '';
        }
        if ($data['bannerSeoTitle']) {
            $data['bannerLogos']['seoTitle'] = $data['bannerSeoTitle'];
        } else {
            $data['bannerLogos']['seoTitle'] = '';
        }
        if ($data['bannerSeoDesc']) {
            $data['bannerLogos']['seoDescription'] = $data['bannerSeoDesc'];
        } else {
            $data['bannerLogos']['seoDescription'] = '';
        }
        if ($data['bannerSeoKeyword']) {
            $data['bannerLogos']['seoKeyword'] = $data['bannerSeoKeyword'];
        } else {
            $data['bannerLogos']['seoKeyword'] = '';
        }

        unset($data['profileImage'], $data['profileAllText'], $data['profileSeoTitle'], $data['profileSeoDesc'], $data['profileSeoKeyword']);
        unset($data['bannerImage'], $data['bannerAllText'], $data['bannerSeoTitle'], $data['bannerSeoDesc'], $data['bannerSeoKeyword']);

        if ($data['countryCode']) {
            $data['countryCode'] = '+' . $data['countryCode'];
        } else {
            $data['countryCode'] = '+91';
        }

        // if ($data['serviceZones'] == '' || $data['serviceZones'] == null) {
        //     $data['serviceZones'] = array();
        // }

        $data['coordinates']['longitude'] = (double) $data['longitude'];
        $data['coordinates']['latitude'] = (double) $data['latitude'];
        
        unset($data['latitude'],$data['longitude']);
        
        $allMasters = $this->mongo_db->get('franchise');
        $arr = [];

        foreach ($allMasters as $data1) {
            array_push($arr, $data1['seqId']);
        }
        $max = max($arr);
        $Buniqid = $max + 1;
        $data['seqId'] = $Buniqid;

        $defaultComm = $this->mongo_db->get('appConfig');
        $commarr = [];
        foreach ($defaultComm as $comm) {
            $commarr = $comm;
        }
        $data['commission'] = (float) $commarr['storeDefaultCommission'];
        $data['commissionType'] = 0;
        $data['commissionTypeMsg'] = 'Percentage';
        $data['appId'] = '';
        $data['status'] = 1;
        $data['statusMsg'] = "New";
		$data['password'] = md5($data['password']);
      

        $resp = $this->mongo_db->insert('franchise', $data);
        echo json_encode($resp);


        // $dispatchUrl = APILink . 'store';
        // $addToMongo = json_decode($this->callapi->CallAPI('POST', $dispatchUrl, $resData), true);
        // $datEmail = array('name' => $data['OwnerName'], 'email' => $data['Email'], 'password' => $data['Password'], 'storeName' => $data['BusinessName'][0], 'mobile' => $data['bCountryCode'] . $data['businessNumber'], 'status' => 12);
        // $urlEmail = APILink . 'admin/email';
        // $responseEmail = json_decode($this->callapi->CallAPI('POST', $urlEmail, $datEmail), true);
        // echo json_encode(array('status' =>$addToMongo));
    }

    function edit() {

        $data = $_POST;

//        print_r($data['avgDeliveryTime']); die;
        if ($data['Facebook'])
            $data['socialLinks']['Facebook'] = $data['Facebook'];
        else
            $data['socialLinks']['Facebook'] = '';
        if ($data['Twitter'])
            $data['socialLinks']['Twitter'] = $data['Twitter'];
        else
            $data['socialLinks']['Twitter'] = '';
        if ($data['Instagram'])
            $data['socialLinks']['Instagram'] = $data['Instagram'];
        else
            $data['socialLinks']['Instagram'] = '';
        if ($data['LinkedIn'])
            $data['socialLinks']['LinkedIn'] = $data['LinkedIn'];
        else
            $data['socialLinks']['LinkedIn'] = '';
        if ($data['Google'])
            $data['socialLinks']['Google'] = $data['Google'];
        else
            $data['socialLinks']['Google'] = '';

        if ($data['categoryId']) {
            $categoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['categoryId'])))->find_one('storeCategory');
            $category[] = array('categoryId' => $data['categoryId'], 'categoryName' => $categoryData['storeCategoryName']);
            $data['storeCategory'] = $category;
        } else {
            $data['storeCategory'] = [];
        }
        if ($data['subCategoryId']) {
            $subcategoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['subCategoryId'])))->find_one('storeSubCategory');
            $subcategory[] = array('subCategoryId' => $data['subCategoryId'], 'subCategoryName' => $subcategoryData['storeSubCategoryName']);
            $data['storeSubCategory'] = $subcategory;
        } else {
            $data['storeSubCategory'] = [];
        }

        if ($data['autoapproval'] == 'on') {
            $data['autoApproval'] = 1; // enable
            $data['autoApprovalMsg'] = "Enable";
        } else {
            $data['autoApproval'] = 0; // disable
            $data['autoApprovalMsg'] = "Disable";
        }
        unset($data['autoapproval']);

        $data['coordinates']['longitude'] = (double) $data['longitude'];
        $data['coordinates']['latitude'] = (double) $data['latitude'];

//         print_r($data['autoApproval']); exit();
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

        if (count($lanCodeArr) == count($data['franchiseName'])) {
            $data['name'] = array_combine($lanCodeArr, $data['franchiseName']);
        } else if (count($lanCodeArr) < count($data['franchiseName'])) {
            $data['name']['en'] = $data['franchiseName'][0];

            foreach ($data['franchiseName'] as $key => $val) {
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
            $data['name']['en'] = $data['franchiseName'][0];
        }

        if ($data['franchiseDescription']) {
            if (count($lanCodeArr) == count($data['franchiseDescription'])) {
                $data['description'] = array_combine($lanCodeArr, $data['franchiseDescription']);
            } else if (count($lanCodeArr) < count($data['franchiseDescription'])) {
                $data['description']['en'] = $data['franchiseDescription'][0];

                foreach ($data['franchiseDescription'] as $key => $val) {
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
                $data['description']['en'] = $data['franchiseDescription'][0];
            }
        } else {
            $data['description']['en'] = '';
            $data['franchiseDescription'] = [];
        }


        $data['profileLogos']['logoImage'] = $data['profileImage'];
        if ($data['profileAllText']) {
            $data['profileLogos']['seoAllText'] = $data['profileAllText'];
        } else {
            $data['profileLogos']['seoAllText'] = '';
        }
        if ($data['profileSeoTitle']) {
            $data['profileLogos']['seoTitle'] = $data['profileSeoTitle'];
        } else {
            $data['profileLogos']['seoTitle'] = '';
        }
        if ($data['profileSeoTitle']) {
            $data['profileLogos']['seoDescription'] = $data['profileSeoDesc'];
        } else {
            $data['profileLogos']['seoDescription'] = '';
        }
        if ($data['profileSeoKeyword']) {
            $data['profileLogos']['seoKeyword'] = $data['profileSeoKeyword'];
        } else {
            $data['profileLogos']['seoKeyword'] = '';
        }

        $data['bannerLogos']['bannerimage'] = $data['bannerImage'];
        if ($data['bannerAllText']) {
            $data['bannerLogos']['seoAllText'] = $data['bannerAllText'];
        } else {
            $data['bannerLogos']['seoAllText'] = '';
        }
        if ($data['bannerSeoTitle']) {
            $data['bannerLogos']['seoTitle'] = $data['bannerSeoTitle'];
        } else {
            $data['bannerLogos']['seoTitle'] = '';
        }
        if ($data['bannerSeoDesc']) {
            $data['bannerLogos']['seoDescription'] = $data['bannerSeoDesc'];
        } else {
            $data['bannerLogos']['seoDescription'] = '';
        }
        if ($data['bannerSeoKeyword']) {
            $data['bannerLogos']['seoKeyword'] = $data['bannerSeoKeyword'];
        } else {
            $data['bannerLogos']['seoKeyword'] = '';
        }

        unset($data['profileImage'], $data['profileAllText'], $data['profileSeoTitle'], $data['profileSeoDesc'], $data['profileSeoKeyword']);
        unset($data['bannerImage'], $data['bannerAllText'], $data['bannerSeoTitle'], $data['bannerSeoDesc'], $data['bannerSeoKeyword']);

        if ($data['countryCode']) {
            $code = explode('+', $data['countryCode']);
            if (count($code) > 1)
                $data['countryCode'] = '+' . $code[1];
            else
                $data['countryCode'] = '+' . $data['countryCode'];
        } else {
            $data['countryCode'] = '+91';
        }

        if ($data['commissionType'] && $data['commission']) {
            $data['commission'] = (float) $data['commission'];
            $data['commissionType'] = (int) $data['commissionType'];
        } else {
            $defaultComm = $this->mongo_db->get('appConfig');
            $commarr = [];
            foreach ($defaultComm as $comm) {
                $commarr = $comm;
            }
            $data['commission'] = (float) $commarr['storeDefaultCommission'];
            $data['commissionType'] = 0;
        }

        if ($commissionType == 0) {
            $data['commissionTypeMsg'] = 'Percentage';
        } else {
            $data['commissionTypeMsg'] = 'Fixed';
        }
        $franchiseId = $data['franchiseId'];
        unset($data['franchiseId']);
        unset($data['latitude'],$data['longitude']);
//        echo '<pre>'; print_r($data); die;
        $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($franchiseId)))->set($data)->update('franchise');
//            print_r($addToMongo); die;
        echo json_encode($res);
    }

    function activefranchise() {

        $val = $this->input->post('val');
//        $mode = $this->input->post('mode');

        foreach ($val as $row) {
            echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array("status" => (int) 2, 'statusMsg' => "Active"))->update('franchise');
        }
    }

    function viewnote_businessmgt() {
        $val = $this->input->post('val');
//         print_r($val);
        foreach ($val as $bid) {
            $unique = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($bid)))->find_one('franchise');
        }

        echo json_encode(array('data' => $unique));
        return;
    }

    public function getCityList() {
        $val = $this->input->post('val');

        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('cities');
        $res = array();
        foreach ($cursor['cities'] as $d) {

            $res[] = $d;
        }

        echo json_encode($res);
    }

    public function getSubcatList() {
        $val = $this->input->post('val');

        $cursor = $this->mongo_db->where(array("categoryId" => $val))->get('storeSubCategory');
        $res = array();
        foreach ($cursor as $d) {
            $res[] = $d;
        }

        echo json_encode($res);
    }

    public function getStoreList() {


        $cursor = $this->mongo_db->where(array("status" => array('$in' => array(1, 3, 4))))->get('franchise');
        $entities = array();
        $entities = '<select class="form-control error-box-class"  id="storeList" name="storeList">
                     <option value="">Select Stores</option>';
        foreach ($cursor as $d) {

            $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '">' . implode($d['name'], ',') . '</option>';
        }
        $entities .= '</select>';
        echo $entities;
    }

    function getfranchise() {
        $res = $this->mongo_db->where(array('status' => 2))->get('franchise');
        return $res;
    }

    function commission_details($status) {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "name.en";
        $_POST['mDataProp_1'] = "commissionType";
        $_POST['mDataProp_2'] = "commission";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('franchise', array("status" => 2), 'seqId', 1);

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();

            if ($value['commissionType'] == 1) {
                $commissionString = 'Fixed';
            } else {
                $commissionString = 'Percentage';
            }

            $categoryName = $subCategoryName = '';
            foreach ($value['storeCategory'] as $cat) {
                $categoryName = $cat['categoryName']['en'];
            }
            foreach ($value['storeSubCategory'] as $subcat) {
                $subCategoryName = $subcat['subCategoryName']['en'];
            }

            $arr[] = $sl++;
            $arr[] = implode($value['franchiseName'], ',');
            $arr[] = ($categoryName != '') ? $categoryName : 'N/A';
            $arr[] = $commissionString;
            $arr[] = $value['commission'];
            $arr[] = '<button class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function getCommissionData() {
        $Id = $this->input->post('Id');

        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->find_one('franchise');

        return $data;
    }

    function editCommission() {
        $data = $_POST;
        $id = $data['commId'];
        $data['commissionType'] = (int) $data['commissionType'];
        $data['commission'] = (float) $data['commission'];

        if ($data['commissionType'] == 0) {
            $data['commissionTypeMsg'] = "Percentage";
        } else if ($data['commissionType'] == 1) {
            $data['commissionTypeMsg'] = "Fixed";
        }

        unset($data['commId']);
        unset($data['storeId']);

        try {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($data)->update('franchise');
        } catch (Exception $ex) {
            print_r($ex);
        }
    }

    function setDefaultCommission() {
        $data = $_POST;
        $id = $data['Id'];
        $defaultComm = $this->mongo_db->get('appConfig');
        $commarr = [];
        foreach ($defaultComm as $comm) {
            $commarr = $comm;
        }
        $commission = $commarr['storeDefaultCommission'];
        $commissionType = 0;
        $arr = array('commission' => $commission, 'commissionType' => $commissionType);
        try {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($arr)->update('franchise');
        } catch (Exception $ex) {
            print_r($ex);
        }
    }

}

?>
