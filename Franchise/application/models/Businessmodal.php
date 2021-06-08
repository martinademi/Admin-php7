<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Businessmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('utility_library');
        $this->load->library('CallAPI');
    }

    function deleteStore() {
        $id = $this->input->post('val');
        $ids = $this->input->post('id');
        $url = 'https://api.deliv-x.com/store/';
        foreach ($id as $row) {
            $fields = $row;
            $fields = json_encode($fields);
            $headers = array(
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url . $row);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
//               print_r($result); die;
            curl_close($ch);
//            $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->delete('stores');
        }
//        $this->elasticsearch->delete("stores", $ids);
        echo json_encode(array('msg' => 1));
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

    function getBusinessdata($id) {

        $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('stores');
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

        $country = $this->mongo_db->where(array("visibility" => 1))->get("storeCategory");
        foreach ($country as $coun) {
            $res[] = $coun;
        }
        return $res;
    }

    function getZonesWithCities() {

        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("city_ID" => $val, 'status' => 1))->get('zones');
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

        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "categoryName";
        $_POST['mDataProp_2'] = "subCategoryName";
        $_POST['mDataProp_3'] = "ownerEmail";

        $respo = $this->datatables->datatable_mongodb('stores', array('franchiseId' => $this->session->userdata('fadmin')['MasterBizId'], 'status' => (int) $status), 'seqId', -1);

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
            $arr[] = '<a target="_blank" href="' . businessLink . 'Business/FromAdmin/' . (string) $value['_id']['$oid'] . '"  data-toggle="modal" style="color:blue;text-decoration: underline;">' . implode($value['name'], ',') . ' </a>';
            $arr[] = ($categoryName != '') ? $categoryName : '-';
            $arr[] = ($subCategoryName != '') ? $subCategoryName : '-';
            $arr[] = ($value['franchiseName']) ? $value['franchiseName'] : "N/A";
            $arr[] = $value['ownerEmail'];
            $arr[] = ($value['averageRating'] != '') ? $value['averageRating'] : 'N/A';
           $arr[] = '<button class="btn btnedit cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="background-color: #606b71;color: white;width: 45px !important;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
//            $arr[] = '<button class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = '<input type="checkbox"  data-id="' . $value['seqID'] . '" class="checkbox" value=' . $value['_id']['$oid'] . ' >';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function inactivebusinessmgt() {

        $val = $this->input->post('val');

        foreach ($val as $row) {

            $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->find_one('stores');
            $dat = array('name' => $getData['ownerName'], 'email' => $getData['ownerEmail'], 'storeName' => $getData['name'][0], 'mobile' => $getData['countryCode'] . $getData['businessNumber'], 'status' => 5);
            $url = APILink . 'admin/email';
            $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
            echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array("status" => 5, 'statusMsg' => "Inactive"))->update('stores');
        }
//        echo json_encode(array("_id" => $val ));
    }

    function validateEmail() {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('ownerEmail' => $this->input->post('email')))->get('stores');
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
        $franchiseId = $this->session->userdata('fadmin')['MasterBizId'];
        $franchiseData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($franchiseId)))->find_one('franchise');
        $categoryId = $franchiseData['categoryId'];
        $subCategoryId = $franchiseData['subCategoryId'];
        $data['addressCompo']=json_decode($data['addressCompo']);
        if($data['addressCompo']==""){
            $data['addressCompo']=new stdClass();
          }

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

        if ($categoryId) {
            $categoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($categoryId)))->find_one('storeCategory');

            $category[] = array('categoryId' => $categoryId, 'categoryName' => $categoryData['storeCategoryName']);

            $data['storeCategory'] = $category;
        } else {
            $data['storeCategory'] = [];
        }
        $data['cartsAllowed']=$categoryData['cartsAllowed'];
        $data['cartsAllowedMsg']=$categoryData['cartsAllowedMsg'];

        $data['storeType'] = $categoryData['type'];
        $data['storeTypeMsg'] = $categoryData['typeName'];
       
        if ($subCategoryId) {
            $subcategoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($subCategoryId)))->find_one('storeSubCategory');
            $subcategory[] = array('subCategoryId' => $subCategoryId, 'subCategoryName' => $subcategoryData['storeSubCategoryName']);
            $data['storeSubCategory'] = $subcategory;
            $data['subCateId'] = $subCategoryId;
        } else {
            $data['storeSubCategory'] = [];
        }
        unset($data['CategoryId'], $data['SubCategoryId']);

        if ($data['forcedAccept'] == 'on') {
            $data['forcedAccept'] = 1; // enable
            $data['forcedAcceptMsg'] = "Enable";
        } else {
            $data['forcedAccept'] = 2; // disable
            $data['forcedAcceptMsg'] = "Disable";
        }
        if ($data['autoDispatch'] == 'on') {
            $data['autoDispatch'] = 1; // enable
            $data['autoDispatchMsg'] = "Enable";
        } else {
            $data['autoDispatch'] = 0; // disable
            $data['autoDispatchMsg'] = "Disable";
        }

        if ($data['Autoapproval'] == 'on') {
            $data['autoApproval'] = 1; // enable
            $data['autoApprovalMsg'] = "Enable";
        } else {
            $data['autoApproval'] = 0; // disable
            $data['autoApprovalMsg'] = "Disable";
        }

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

        if (count($lanCodeArr) == count($data['BusinessName'])) {
            $data['storeName'] = array_combine($lanCodeArr, $data['BusinessName']);
        } else if (count($lanCodeArr) < count($data['BusinessName'])) {
            $data['storeName']['en'] = $data['BusinessName'][0];

            foreach ($data['BusinessName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['storeName'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['storeName'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['storeName']['en'] = $data['BusinessName'][0];
        }

        if ($data['Description']) {
            if (count($lanCodeArr) == count($data['Description'])) {
                $data['storeDescription'] = array_combine($lanCodeArr, $data['Description']);
            } else if (count($lanCodeArr) < count($data['Description'])) {
                $data['storeDescription']['en'] = $data['Description'][0];

                foreach ($data['Description'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['storeDescription'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['storeDescription'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['storeDescription']['en'] = $data['Description'][0];
            }
        } else {
            $data['storeDescription']['en'] = '';
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
        if ($data['bCountryCode']) {
            $data['bCountryCode'] = '+' . $data['bCountryCode'];
        } else {
            $data['bCountryCode'] = '+91';
        }
        if ($data['Description']) {
            $data['Description'] = $data['Description'];
        } else {
            $data['Description'] = [];
        }
        if ($data['billingAddress']) {
            $data['billingAddress'] = $data['billingAddress'];
        } else {
            $data['billingAddress'] = [];
        }

        $data['pricingStatus'] = (string) $data['pricing'];
        if ($data['pricingStatus'] == 0) {
            $data['pricingStatusMsg'] = "zonalPricing";
        } else {
            $data['pricingStatusMsg'] = "mileagePricing";
        }
        $data['minimumOrder'] = $data['minorderVal'];
        $data['freeDeliveryAbove'] = $data['freedelVal'];
        $data['avgDeliveryTime'] = $data['avgDeliveryTime'];


        $data['locationId'] = (int) $data['select'];
        $data['coordinates']['longitude'] = (double) $data['Longitude'];
        $data['coordinates']['latitude'] = (double) $data['Latitude'];

        $data['pickupCash'] = (int) $data['Pcash'];
        if ($data['pickupCash'] == 1) {
            $data['pickupCashMsg'] = "Enable";
        } else {
            $data['pickupCashMsg'] = "Disable";
        }
        $data['pickupCard'] = (int) $data['Pcredit_card'];
        if ($data['pickupCard'] == 1) {
            $data['pickupCardMsg'] = "Enable";
        } else {
            $data['pickupCardMsg'] = "Disable";
        }
        $data['deliveryCash'] = (int) $data['Dcash'];
        if ($data['deliveryCash'] == 1) {
            $data['deliveryCashMsg'] = "Enable";
        } else {
            $data['deliveryCashMsg'] = "Disable";
        }
        $data['deliveryCard'] = (int) $data['Dcredit_card'];
        if ($data['deliveryCard'] == 1) {
            $data['deliveryCardMsg'] = "Enable";
        } else {
            $data['deliveryCardMsg'] = "Disable";
        }

        $data['orderType'] = (string) $data['select'];

        $data['orderType'] = (string) $data['select'];

        if ($data['orderType'] == 1) {
            $data['orderTypeMsg'] = "pickupOrder";

            $data['deliveryCash'] = 0;
            $data['deliveryCashMsg'] = "Disable";
            $data['deliveryCard'] = 0;
            $data['deliveryCardMsg'] = "Disable";
        } else if ($data['orderType'] == 2) {
            $data['orderTypeMsg'] = "deliveryOrder";

            $data['pickupCash'] = 0;
            $data['pickupCashMsg'] = "Disable";
            $data['pickupCard'] = 0;
            $data['pickupCardMsg'] = "Disable";
        } else {
            $data['orderTypeMsg'] = "bothOtder";
        }


        $data['baseFare'] = (int) $data['basefare'];
        $data['range'] = (string) $data['range'];
        $data['pricePerMile'] = (int) $data['priceperkm'];
        $data['orderEmail'] = "";
        $data['driverType'] = (int) $data['driverType'];
        if ($data['driverType'] == 1) {
            $data['driverTypeMsg'] = "StoreDriver";
        } else {
            $data['driverTypeMsg'] = "Freelance";
        }
        $serviceZones = $data['serviceZones'];

        // pos system data
        $posID = $this->input->post('posID');
        $locationId = $this->input->post('locationId');
        $urlData = $this->input->post('urlData');
        $walletID = $this->input->post('walletID');
        $paymentsEnabled = $this->input->post('paymentsEnabled');
        $locationName = $this->input->post('locationName');
        $externalCreditCard1 = $this->input->post('externalCreditCard');
        $internalCreditCard1 = $this->input->post('internalCreditCard');
        $check1 = $this->input->post('check');
        $quickCard1 = $this->input->post('quickCard');
        $giftCard1 = $this->input->post('giftCard');


        $giftCard = ($giftCard1 == '') ? "00" : "$giftCard1";
        $quickCard = ($quickCard1 == '') ? "00" : "$quickCard1";
        $check = ($check1 == '') ? "00" : "$check1";
        $internalCreditCard = ($internalCreditCard1 == '') ? "00" : "$internalCreditCard1";
        $externalCreditCard = ($externalCreditCard1 == '') ? "00" : "$externalCreditCard1";

        $postalcode = "0";

        if ($serviceZones == '' || $serviceZones == null) {
            $serviceZones = array();
        }

//        $this->load->library('elasticsearch');
        $this->load->library('session');
        $this->session->set_userdata(array('Driver_session' => $drivers));

        $allMasters = $this->mongo_db->get('stores');
        $arr = [];

        foreach ($allMasters as $data1) {
            array_push($arr, $data1['seqID']);
        }
        $max = max($arr);
        $Buniqid = $max + 1;
        $dat = array('latitude' => $Latitude, 'longitude' => $Longitude);
        $url = APILink . 'business/zones';

        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);

        if ($response['data']['_id']) {
            $businessZoneId = $response['data']['_id'];
            $businessZoneName = $response['data']['title'];
            $currency = $response['data']['currency'];
            $currencySymbol = $response['data']['currencySymbol'];
        } else {
            $businessZoneId = '0';
            $businessZoneName = 'Non working Zone';
            $currency = "";
            $currencySymbol = $data['currencySymbol'];
        }
        $defaultComm = $this->mongo_db->get('appConfig');
        $commarr = [];
        foreach ($defaultComm as $comm) {
            $commarr = $comm;
        }
        $commission = (int)$commarr['storeDefaultCommission'];
        $franchiseId = $this->session->userdata('fadmin')['MasterBizId'];
        $franchiseName = $this->session->userdata('fadmin')['MasterBusinessName'];

        $storesData = $this->mongo_db->get('stores');
        foreach ($storesData as $stores) {
            array_push($arr, $stores['seqId']);
        }
        $max = max($arr);
        $seq = $max + 1;

        if ($posID == '' || $posID == null) {

            $resData = array("profileLogos" => $data['profileLogos'], "bannerLogos" => $data['bannerLogos'],
                "name" => $data['BusinessName'], "ownerName" => $data['OwnerName'], 'countryCode' => $data['countryCode'],
                "ownerPhone" => $data['Phone'], "ownerEmail" => $data['Email'], "password" => $data['Password'],
                'bcountryCode' => $data['bCountryCode'], "businessNumber" => $data['businessNumber'],
                "website" => $data['Website'], "description" => $data['Description'], "storeAddr" => $data['storeaddress'],
                "storeBillingAddr" =>(string) $data['billingAddress'], "cityId" => $data['city'], "cityName" => $data['cityName'], 'countryId' => $data['Country'],
                "coordinates" => $data['coordinates'], 'businessZoneId' => $businessZoneId, 'businessZoneName' => $businessZoneName, 'serviceZones' => $serviceZones,
                "status" => 3, 'statusMsg' => 'New', 'pricingStatus' => $data['pricingStatus'], 'pricingStatusMsg' => $data['pricingStatusMsg'], "minimumOrder" => $data['minimumOrder'], "freeDeliveryAbove" => $data['freeDeliveryAbove'],
                'pickupCash' => $data['pickupCash'], 'pickupCashMsg' => $data['pickupCashMsg'], 'pickupCard' => $data['pickupCard'], 'pickupCardMsg' => $data['pickupCardMsg'],
                'deliveryCard' => $data['deliveryCard'], 'deliveryCardMsg' => $data['deliveryCardMsg'], 'deliveryCash' => $data['deliveryCash'], 'deliveryCashMsg' => $data['deliveryCashMsg'],
                'orderType' => $data['orderType'], 'orderTypeMsg' => $data['orderTypeMsg'], 'orderEmail' => $data['orderEmail'], 'baseFare' => $data['baseFare'], 'pricePerMile' => $data['pricePerMile'], 'range' => $data['range'],
                'companyDriver' => $data['grocerDriver'], 'storeDriver' => $data['storeDriver'], 'currency' => $currency, 'currencySymbol' => $currencySymbol,
                'driverType' => $data['driverType'], 'driverTypeMsg' => $data['driverTypeMsg'], 'forcedAccept' => $data['forcedAccept'], 'forcedAcceptMsg' => $data['forcedAcceptMsg'], 'baseFare' => (int) $data['baseFare'], 'mileagePrice' => (int) $data['mileagePrice'],
                'mileagePriceAfterMinutes' => (int) $data['mileagePriceAfterMinutes'], 'timeFee' => (int) $data['timeFee'], 'timeFeeAfterMinutes' => (int) $data['timeFeeAfterMinutes'], 'waitingFee' => (int) $data['waitingFee'],
                'waitingFeeAfterMinutes' => (int) $data['waitingFeeAfterMinutes'], 'minimumFare' => (int) $data['minimumFare'], 'onDemandBookingsCancellationFee' => (int) $data['onDemandBookingsCancellationFee'],
                'onDemandBookingsCancellationFeeAfterMinutes' => (int) $data['onDemandBookingsCancellationFeeAfterMinutes'], 'scheduledBookingsCancellationFee' => (int) $data['scheduledBookingsCancellationFee'],
                'scheduledBookingsCancellationFeeAfterMinutes' => (int) $data['scheduledBookingsCancellationFeeAfterMinutes'], 'convenienceFee' => (int) $data['convenienceFee'],
                'commission' => $commission, 'commissionType' => 0, 'commissionTypeMsg' => 'Percentage',
                'sName' => $data['storeName'], 'storedescription' => $data['storeDescription'],
                'autoApproval' => (int) $data['autoApproval'], 'autoApprovalMsg' => $data['autoApprovalMsg'],
                'autoDispatch' => $data['autoDispatch'], 'autoDispatchMsg' => $data['autoDispatchMsg'],
                'posID' => '', 'locationId' => '', 'urlData' => '', 'walletID' => '', 'paymentsEnabled' => '', 'locationName' => '', 'externalCreditCard' => '', 'internalCreditCard' => '', 'check' => '', 'quickCard' => '', 'giftCard' => '',
                'storeCategory' => $data['storeCategory'], 'storeSubCategory' => $data['storeSubCategory'], 'cartsAllowed'=>(int) $data['cartsAllowed'],'cartsAllowedMsg'=> $data['cartsAllowedMsg'],
                'socialLinks' => $data['socialLinks'], 'avgDeliveryTime' => $data['avgDeliveryTime'], 'appId' => '', 'storeType' =>(int) $data['storeType'], 'storeTypeMsg'=> (string)$data['storeTypeMsg'],
                'franchiseId' => $franchiseId, 'franchiseName' => $franchiseName,  'streetName'=>$data['streetname'],'localityName'=>$data['localityname'],'areaName'=>$data['areaname'],"costForTwo"=>$data['costForTwo'], 'addressCompo'=>(object)$data['addressCompo']);

           $dispatchUrl = APILink . 'store';
           $addToMongo = json_decode($this->callapi->CallAPI('POST', $dispatchUrl, $resData), true);

            $datEmail = array('name' => $data['OwnerName'], 'email' => $data['Email'], 'password' => $data['Password'], 'storeName' => $data['BusinessName'][0], 'mobile' => $data['bCountryCode'] . $data['businessNumber'], 'status' => 12);
            $urlEmail = APILink . 'admin/email';
            $responseEmail = json_decode($this->callapi->CallAPI('POST', $urlEmail, $datEmail), true);
            echo json_encode($responseEmail);
        } else {

            $countryCode = "0";
            if ($Phone == '' || $Phone == null) {
                $Phone = "0";
            }
            if ($Website == '' || $Website == null) {
                $Website = "0";
            }
            if ($Description == '' || $Description == null || !(isset($Description))) {
                $Description = array("");
            }
            if ($billingAddress == '' || $billingAddress == null) {
                $billingAddress = array("");
            }


            $resData = array("name" => $data['BusinessName'], "status" => 3, "ownerName" => $data['OwnerName'], 'countryId' => $data['Country'], 'countryCode' => $data['countryCode'],
                'posID' => $posID, 'walletID' => $walletID, 'paymentsEnabled' => $paymentsEnabled, 'locationName' => $locationName,
                "ownerPhone" => $data['Phone'], "ownerEmail" => $data['OwnerName'], "businessNumber" => $data['businessNumber'], "password" => $data['Password'], "website" => $data['Website'],
                "description" => $data['Description'], "businessAddress" => $data['storeaddress'],
                "billingAddress" => $data['billingAddress'], "cityId" => $data['city'], "cityName" => $data['cityName'],
                "coordinates" => $data['coordinates'], 'businessZoneId' => $businessZoneId, 'businessZoneName' => $businessZoneName, 'serviceZones' => $serviceZones,
                'pricingStatus' => (string) $data['pricingStatus'], "minimumOrder" => $data['minimumOrder'], "freeDeliveryAbove" => $data['freeDeliveryAbove'],
                'pickupCash' => $data['pickupCash'], 'pickupCard' => $data['pickupCard'], 'deliveryCard' => $data['deliveryCard'], 'deliveryCash' => $data['deliveryCash'],
                'orderType' => (string) $data['orderType'], 'orderEmail' => $data['orderEmail'], 'baseFare' => $data['baseFare'], 'pricePerMile' => $data['pricePerMile'], 'range' => (string) $data['range'],
                "locationId" => $locationId, "giftCard" => $giftCard, "quickCard" => $quickCard, "check" => $check, "internalCreditCard" => $internalCreditCard, "externalCreditCard" => $externalCreditCard
            );

//            $url1 = DispatchLink . 'store';
//            $response1 = json_decode($this->callapi->CallAPI('POST', $url1, $resData), true);
            ////
            $res = $this->mongo_db->insert('stores', $resData);

            $dat2 = array('name' => $data['OwnerName'], 'email' => $data['Email'], 'password' => $data['Password'], 'storeName' => $data['BusinessName'][0], 'mobile' => $data['bCountryCode'] . $data['businessNumber'], 'status' => 12);
            $url2 = APILink . 'admin/email';
            $response2 = json_decode($this->callapi->CallAPI('POST', $url2, $dat2), true);
            echo json_encode($response2);
        }
    }

    function edit() {

        $data = $_POST;
        $franchiseId = $this->session->userdata('fadmin')['MasterBizId'];
        $franchiseData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($franchiseId)))->find_one('franchise');
        $categoryId = $franchiseData['categoryId'];
        $subCategoryId = $franchiseData['subCategoryId'];
        $data['addressCompo']=json_decode($data['addressCompo']);

        if($data['addressCompo']==""){
          $data['addressCompo']=new stdClass();
        }
        
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

        if ($categoryId) {
            $categoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($categoryId)))->find_one('storeCategory');
            $category[] = array('categoryId' => $categoryId, 'categoryName' => $categoryData['storeCategoryName']);
            $data['storeCategory'] = $category;
            $data['cateId'] = $categoryId;
        } else {
            $data['storeCategory'] = [];
        }
        $data['cartsAllowed']=$categoryData['cartsAllowed'];
        $data['cartsAllowedMsg']=$categoryData['cartsAllowedMsg'];
        $data['storeType'] = $categoryData['type'];
        $data['storeTypeMsg'] = $categoryData['typeName'];
        
        
        if ($subCategoryId) {
            $subcategoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($subCategoryId)))->find_one('storeSubCategory');
            $subcategory[] = array('subCategoryId' => $subCategoryId, 'subCategoryName' => $subcategoryData['storeSubCategoryName']);
            $data['storeSubCategory'] = $subcategory;
            $data['subCateId'] = $subCategoryId;
        } else {
            $data['storeSubCategory'] = [];
        }
        unset($data['CategoryId'], $data['SubCategoryId']);

        if ($data['forcedAccept'] == 'on') {
            $data['forcedAccept'] = 1; // enable
            $data['forcedAcceptMsg'] = "Enable";
        } else {
            $data['forcedAccept'] = 2; // disable
            $data['forcedAcceptMsg'] = "Disable";
        }

        if ($data['autoDispatch'] == 'on') {
            $data['autoDispatch'] = 1; // enable
            $data['autoDispatchMsg'] = "Enable";
        } else {
            $data['autoDispatch'] = 0; // disable
            $data['autoDispatchMsg'] = "Disable";
        }

        if ($data['Autoapproval'] == 'on') {
            $data['autoApproval'] = 1; // enable
            $data['autoApprovalMsg'] = "Enable";
        } else {
            $data['autoApproval'] = 0; // disable
            $data['autoApprovalMsg'] = "Disable";
        }

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

        if (count($lanCodeArr) == count($data['BusinessName'])) {
            $data['storeName'] = array_combine($lanCodeArr, $data['BusinessName']);
        } else if (count($lanCodeArr) < count($data['BusinessName'])) {
            $data['storeName']['en'] = $data['BusinessName'][0];

            foreach ($data['BusinessName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $data['storeName'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $data['storeName'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $data['storeName']['en'] = $data['BusinessName'][0];
        }

        if ($data['Description']) {
            if (count($lanCodeArr) == count($data['Description'])) {
                $data['storeDescription'] = array_combine($lanCodeArr, $data['Description']);
            } else if (count($lanCodeArr) < count($data['Description'])) {
                $data['storeDescription']['en'] = $data['Description'][0];

                foreach ($data['Description'] as $key => $val) {
                    foreach ($lang as $lan) {

                        if ($lan['Active'] == 1) {
                            if ($key == $lan['lan_id']) {
                                $data['storeDescription'][$lan['langCode']] = $val;
                            }
                        } else {
                            if ($key == $lan['lan_id']) {
                                $data['storeDescription'][$lan['langCode']] = $val;
                            }
                        }
                    }
                }
            } else {
                $data['storeDescription']['en'] = $data['Description'][0];
            }
        } else {
            $data['storeDescription']['en'] = '';
        }

        $data['driverType'] = (int) $data['driverType'];
        if ($data['driverType'] == 1) {
            $data['driverTypeMsg'] = "StoreDriver";
        } else {
            $data['driverTypeMsg'] = "Freelance";
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
            $data['code'] = explode('+', $data['countryCode']);
            if (count($data['code']) > 1)
                $data['countryCode'] = '+' . $data['code'][1];
            else
                $data['countryCode'] = '+' . $data['countryCode'];
        } else {
            $data['countryCode'] = '+91';
        }
        if ($data['bCountryCode']) {
            $data['code1'] = explode('+', $data['bCountryCode']);
            if (count($data['code1']) > 1)
                $data['bCountryCode'] = '+' . $data['code1'][1];
            else
                $data['bCountryCode'] = '+' . $data['bCountryCode'];
        } else {
            $data['bCountryCode'] = '+91';
        }

        if ($data['Description']) {
            $data['Description'] = $data['Description'];
        } else {
            $data['Description'] = [];
        }
        if ($data['billingAddress']) {
            $data['billingAddress'] = $data['billingAddress'];
        } else {
            $data['billingAddress'] = [];
        }

        $data['pricingStatus'] = (string) $data['pricing'];
        if ($data['pricingStatus'] == 0) {
            $data['pricingStatusMsg'] = "zonalPricing";
        } else {
            $data['pricingStatusMsg'] = "mileagePricing";
        }
        $data['minimumOrder'] = $data['minorderVal'];
        $data['freeDeliveryAbove'] = $data['freedelVal'];

        $data['pickupCash'] = (int) $data['Pcash'];
        if ($data['pickupCash'] == 1) {
            $data['pickupCashMsg'] = "Enable";
        } else {
            $data['pickupCashMsg'] = "Disable";
        }
        $data['pickupCard'] = (int) $data['Pcredit_card'];
        if ($data['pickupCard'] == 1) {
            $data['pickupCardMsg'] = "Enable";
        } else {
            $data['pickupCardMsg'] = "Disable";
        }
        $data['deliveryCash'] = (int) $data['Dcash'];
        if ($data['deliveryCash'] == 1) {
            $data['deliveryCashMsg'] = "Enable";
        } else {
            $data['deliveryCashMsg'] = "Disable";
        }
        $data['deliveryCard'] = (int) $data['Dcredit_card'];
        if ($data['deliveryCard'] == 1) {
            $data['deliveryCardMsg'] = "Enable";
        } else {
            $data['deliveryCardMsg'] = "Disable";
        }

        $data['orderType'] = (string) $data['select'];

        if ($data['orderType'] == 1) {
            $data['orderTypeMsg'] = "pickupOrder";

            $data['deliveryCash'] = 0;
            $data['deliveryCashMsg'] = "Disable";
            $data['deliveryCard'] = 0;
            $data['deliveryCardMsg'] = "Disable";
        } else if ($data['orderType'] == 2) {
            $data['orderTypeMsg'] = "deliveryOrder";

            $data['pickupCash'] = 0;
            $data['pickupCashMsg'] = "Disable";
            $data['pickupCard'] = 0;
            $data['pickupCardMsg'] = "Disable";
        } else {
            $data['orderTypeMsg'] = "bothOtder";
        }

        $data['locationId'] = (int) $data['select'];
        $data['coordinates']['longitude'] = (double) $data['Longitude'];
        $data['coordinates']['latitude'] = (double) $data['Latitude'];

        $data['baseFare'] = (int) $data['basefare'];
        $data['range'] = (string) $data['range'];
        $data['pricePerMile'] = (int) $data['priceperkm'];
        $data['orderEmail'] = "";

        $serviceZones = $data['serviceZones'];
//        echo '<pre>'; print_r($serviceZones); die;
        // pos system data
        $posID = $this->input->post('posID');
        $locationId = $this->input->post('locationId');
        $urlData = $this->input->post('urlData');
        $walletID = $this->input->post('walletID');
        $paymentsEnabled = $this->input->post('paymentsEnabled');
        $locationName = $this->input->post('locationName');
        $externalCreditCard1 = $this->input->post('externalCreditCard');
        $internalCreditCard1 = $this->input->post('internalCreditCard');
        $check1 = $this->input->post('check');
        $quickCard1 = $this->input->post('quickCard');
        $giftCard1 = $this->input->post('giftCard');

        $giftCard = ($giftCard1 == '') ? "00" : "$giftCard1";
        $quickCard = ($quickCard1 == '') ? "00" : "$quickCard1";
        $check = ($check1 == '') ? "00" : "$check1";
        $internalCreditCard = ($internalCreditCard1 == '') ? "00" : "$internalCreditCard1";
        $externalCreditCard = ($externalCreditCard1 == '') ? "00" : "$externalCreditCard1";

        $postalcode = "0";

        if ($serviceZones == '' || $serviceZones == null) {
            $serviceZones = array();
        }

//        $this->load->library('elasticsearch');
        $this->load->library('session');
        $this->session->set_userdata(array('Driver_session' => $drivers));

        $allMasters = $this->mongo_db->get('stores');
        $arr = [];

        foreach ($allMasters as $data1) {
            array_push($arr, $data1['seqID']);
        }
        $max = max($arr);
        $Buniqid = $max + 1;
        $dat = array('latitude' => $Latitude, 'longitude' => $Longitude);
        $url = APILink . 'business/zones';

        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);

        if ($response['data']['_id']) {
            $businessZoneId = $response['data']['_id'];
            $businessZoneName = $response['data']['title'];
            $currency = $response['data']['currency'];
            $currencySymbol = $response['data']['currencySymbol'];
        } else {
            $businessZoneId = '0';
            $businessZoneName = 'Non working Zone';
            $currency = "";
            $currencySymbol = $data['currencySymbol'];
        }
        if ($data['commissionType'] && $data['commission']) {
            $commission = $data['commission'];
            $commissionType = (int) $data['commissionType'];
        } else {
            $defaultComm = $this->mongo_db->get('appConfig');
            $commarr = [];
            foreach ($defaultComm as $comm) {
                $commarr = $comm;
            }
            $commission = $commarr['storeDefaultCommission'];
            $commissionType = 0;
        }

        if ($commissionType == 0) {
            $commissionTypeMsg = 'Percentage';
        } else {
            $commissionTypeMsg = 'Fixed';
        }


        if ($posID == '' || $posID == null) {

            $resData = array(//"storeId" => (string) $data['storeId'],
                "profileLogos" => $data['profileLogos'], "bannerLogos" => $data['bannerLogos'],
                "name" => $data['BusinessName'], "ownerName" => $data['OwnerName'], 'countryCode' => $data['countryCode'],
                "ownerPhone" => $data['Phone'], "ownerEmail" => $data['Email'],
                'bcountryCode' => $data['bCountryCode'], "businessNumber" => $data['businessNumber'],
                "website" => $data['Website'], "description" => $data['Description'], "storeAddr" => $data['storeaddress'],
                "storeBillingAddr" => (string)$data['billingAddress'], "cityId" => $data['city'], "cityName" => $data['cityName'], 'countryId' => $data['Country'],
                "coordinates" => $data['coordinates'], 'businessZoneId' => $businessZoneId, 'businessZoneName' => $businessZoneName, 'serviceZones' => $serviceZones,
                'pricingStatus' => $data['pricingStatus'], 'pricingStatusMsg' => $data['pricingStatusMsg'], "minimumOrder" => $data['minimumOrder'], "freeDeliveryAbove" => $data['freeDeliveryAbove'],
                'pickupCash' => $data['pickupCash'], 'pickupCashMsg' => $data['pickupCashMsg'], 'pickupCard' => $data['pickupCard'], 'pickupCardMsg' => $data['pickupCardMsg'],
                'deliveryCard' => $data['deliveryCard'], 'deliveryCardMsg' => $data['deliveryCardMsg'], 'deliveryCash' => $data['deliveryCash'], 'deliveryCashMsg' => $data['deliveryCashMsg'],
                'orderType' => $data['orderType'], 'orderTypeMsg' => $data['orderTypeMsg'], 'orderEmail' => $data['orderEmail'], 'baseFare' => $data['baseFare'], 'pricePerMile' => $data['pricePerMile'], 'range' => $data['range'],
                'companyDriver' => $data['grocerDriver'], 'storeDriver' => $data['storeDriver'], 'currency' => $currency, 'currencySymbol' => $currencySymbol,
                'driverType' => $data['driverType'], 'driverTypeMsg' => $data['driverTypeMsg'], 'forcedAccept' => $data['forcedAccept'], 'forcedAcceptMsg' => $data['forcedAcceptMsg'], 'baseFare' => (int) $data['baseFare'], 'mileagePrice' => (int) $data['mileagePrice'],
                'mileagePriceAfterMinutes' => (int) $data['mileagePriceAfterMinutes'], 'timeFee' => (int) $data['timeFee'], 'timeFeeAfterMinutes' => (int) $data['timeFeeAfterMinutes'], 'waitingFee' => (int) $data['waitingFee'],
                'waitingFeeAfterMinutes' => (int) $data['waitingFeeAfterMinutes'], 'minimumFare' => (int) $data['minimumFare'], 'onDemandBookingsCancellationFee' => (int) $data['onDemandBookingsCancellationFee'],
                'onDemandBookingsCancellationFeeAfterMinutes' => (int) $data['onDemandBookingsCancellationFeeAfterMinutes'], 'scheduledBookingsCancellationFee' => (int) $data['scheduledBookingsCancellationFee'],
                'scheduledBookingsCancellationFeeAfterMinutes' => (int) $data['scheduledBookingsCancellationFeeAfterMinutes'], 'convenienceFee' => (int) $data['convenienceFee'],
                'autoApproval' => (int) $data['autoApproval'], 'autoApprovalMsg' => $data['autoApprovalMsg'],
                'autoDispatch' => $data['autoDispatch'], 'autoDispatchMsg' => $data['autoDispatchMsg'],
                'commission' => $commission, 'commissionType' => $commissionType, 'commissionTypeMsg' => $commissionTypeMsg, 'sName' => $data['storeName'], 'storedescription' => $data['storeDescription'],
                'categoryId' => $data['cateId'],'subCategoryId' => $data['subCateId'],'storeCategory' => $data['storeCategory'], 'storeSubCategory' => $data['storeSubCategory'],
                'socialLinks' => $data['socialLinks'], 'avgDeliveryTime' => $data['avgDeliveryTime'],
                'addressCompo'=>(object)$data['addressCompo'], 'streetName'=>$data['streetname'],'localityName'=>$data['localityname'],'areaName'=>$data['areaname']); 
                //
//            without api call
            echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($data['storeId'])))->set($resData)->update('stores');
//            
//            with api call
//            $dispatchUrl = 'https://apidispatcher.instacart-clone.com/store/';
//            $addToMongo = json_decode($this->callapi->CallAPI('PATCH', $dispatchUrl, $resData), true);
//            print_r($addToMongo); die;
//            echo json_encode($addToMongo);
        }
    }

    function activebusinessmgt() {

        $val = $this->input->post('val');
//        $mode = $this->input->post('mode');

        foreach ($val as $row) {
            $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->find_one('stores');
            $dat = array('name' => $getData['ownerName'], 'email' => $getData['ownerEmail'], 'storeName' => $getData['name'][0], 'mobile' => $getData['countryCode'] . $getData['businessNumber'], 'status' => 8);
            $url = APILink . 'admin/email';
            $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
            echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array("status" => (int) 1, 'statusMsg' => "active"))->update('stores');
        }
    }

    function viewnote_businessmgt() {
        $val = $this->input->post('val');
//         print_r($val);
        foreach ($val as $bid) {
            $unique = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($bid)))->find_one('stores');
        }

        echo json_encode(array('data' => $unique));
        return;
    }

    public function getCityList() {
        $val = $this->input->post('val');

        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('cities');
        $res = array();
        foreach ($cursor['cities'] as $d) {
            if ($d['isDeleted'] == false) {
                $res[] = $d;
            }
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


        $cursor = $this->mongo_db->where(array("status" => array('$in' => array(1, 3, 4))))->get('stores');
        $entities = array();
        $entities = '<select class="form-control error-box-class"  id="storeList" name="storeList">
                     <option value="">Select Stores</option>';
        foreach ($cursor as $d) {

            $entities .= '<option data-name="' . implode($d['name'], ',') . '" value="' . $d['_id']['$oid'] . '">' . implode($d['name'], ',') . '</option>';
        }
        $entities .= '</select>';
        echo $entities;
    }


    function getStoresCount() {
        $this->load->library('mongo_db');

        $id=$this->session->userdata('fadmin')['MasterBizId']; 
        $data['Pending'] = $this->mongo_db->where(array('status'=>3,'franchiseId' => $this->session->userdata('fadmin')['MasterBizId']))->count('stores');
        $data['Active'] = $this->mongo_db->where(array('status'=>1,'franchiseId' => $this->session->userdata('fadmin')['MasterBizId']))->count('stores');
        $data['Inactive'] = $this->mongo_db->where(array('status'=>5,'franchiseId' => $this->session->userdata('fadmin')['MasterBizId']))->count('stores');
        $data['deleted'] = $this->mongo_db->where(array('status'=>7,'franchiseId' => $this->session->userdata('fadmin')['MasterBizId']))->count('stores');

        //$respo = $this->datatables->datatable_mongodb('stores', array('franchiseId' => $this->session->userdata('fadmin')['MasterBizId'], 'status' => (int) $status), 'seqId', -1);


        echo json_encode(array('data' => $data));
        
    }

}

?>
