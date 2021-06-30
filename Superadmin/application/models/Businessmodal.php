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
        $this->load->model("Customermodel");
    }

    function deleteStore() {
        $this->load->library('elasticsearch');
        $id = $this->input->post('val');
        $ids = $this->input->post('id');
        $url = APILink . 'store/';
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
        $this->load->library('mongo_db');

        // $datatosend1 = $this->mongo_db->aggregate('cities',array(array('$unwind'=>'$cities'),
        // array('$match'=>array("cities.isDeleted"=>false)),
        // array('$project'=>array('country'=>1))
        // ));
        
        // $getAll=[];
        // foreach($datatosend1 as $city){
            
        //    $value = json_decode(json_encode($city), TRUE);
        //    array_push($getAll,$value);          
        // }
        // return $getAll;

        $country = $this->mongo_db->get("cities");
        foreach ($country as $coun) {
            $res[] = $coun;
        }
        return $res;
    }

    function storecategoryData() {

        $country = $this->mongo_db->where(array( "visibility" => 1))->get("storeCategory");
        foreach ($country as $coun) {
            $res[] = $coun;
        }
        return $res;
    }
    function dpData() {

        $dp = $this->mongo_db->get("dp"); 
        return $dp;
    }
    
    function getFranchise(){
        $res = $this->mongo_db->where(array("status" => 2))->select(array("name"=>"name"))->get("franchise");
        echo json_encode($res);
    }

    function getZonesWithCities() {

        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("city_ID" => $val,'status' => 1))->get('zones');
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
		$this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 6;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "storeCategory.categoryName.en";
        $_POST['mDataProp_2'] = "storeSubCategory.subCategoryName.en";
        $_POST['mDataProp_3'] = "ownerEmail";
        $_POST['mDataProp_4'] = "cityName";
        $_POST['mDataProp_5'] = "franchiseName";

        //$respo = $this->datatables->datatable_mongodb('stores', array('status' => (int) $status), '',-1);

        $respo = $this->datatables->datatable_mongodbAggregate('stores', array(array('$match'=>array('status' => (int) $status)),array('$sort'=>array('_id'=>-1)),array('$project'=>
            array('sName'=>1,'storeCategory'=>1,'storeSubCategory'=>1,'franchiseName'=>1,'ownerEmail'=>1,'seqId'=>1))),
        array(array('$match'=>array('status' => (int) $status)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1))))
        );

        $timeOffset = (int)$this->session->userdata("timeOffset");


        $aaData = $respo["aaData"];
        $datatosend = array();
        $index = $_POST['iDisplayStart'] + 1;
        foreach ($aaData as $value) {

            $id = (string)$value->_id;
            $value = json_decode(json_encode($value), TRUE);
            $value['_id']['$oid'] =   $id;

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
            $arr[] = '<a target="_blank" href="' . businessLink . 'Business/FromAdmin/' . (string) $value['_id']['$oid'] .'/'.$timeOffset.'"  data-toggle="modal">' . $value['sName']['en'] . ' </a>';
            $arr[] = ($categoryName != '') ? $categoryName : 'N/A';
            $arr[] = ($subCategoryName != '') ? $subCategoryName : 'N/A';
            $arr[] = ($value['franchiseName']) ? $value['franchiseName'] : "N/A";
           // $arr[] = $value['ownerEmail'];
            $arr[] = $this->Customermodel->maskFileds($value['ownerEmail'], 1);
            $arr[] = ($value['averageRating'] != '') ? $value['averageRating'] : 'N/A';
            $arr[] = '<button class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = '<input type="checkbox"  data-id="' . $value['seqID'] . '" class="checkbox" value=' . $value['_id']['$oid'] . ' >';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        // Checking whether there is a search term defined or not
        // It's needed here because the data is being filtered above
        if (isset($_POST['sSearch']) && $_POST['sSearch'] !== '') {
            $respo["iTotalDisplayRecords"] = count($respo["aaData"]);
        }
        echo json_encode($respo);
    }

    function inactivebusinessmgt() {

        $val = $this->input->post('val');

        foreach ($val as $row) {

            $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->find_one('stores');
            $dat = array('name' => $getData['ownerName'], 'email' => $getData['ownerEmail'], 'storeName' => $getData['name'][0], 'mobile' => $getData['countryCode'] . $getData['businessNumber'], 'status' => 5);
            $url = APILink . 'admin/email';
            $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);

             //call api for active/inactive store
             $dataToSend = array('storeId'=>$row,'status'=>5,'statusMsg'=>"Inactive");
             $apiUrl = APILink.'storeToUpdateStatus';
             $response1 = json_decode($this->callapi->CallAPI('PATCH', $apiUrl, $dataToSend), true);
             if($response1['statusCode'] == 200)
             echo true;
             else
             echo false;

            // echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array("status" => 5, 'statusMsg' => "Inactive"))->update('stores');
        }
    }
    
     function validateEmail() {
        $this->load->library('mongo_db');
        if(isset($_POST['id']) && $_POST['id'] != null && $_POST['id'] != ''){
            $res = $this->mongo_db->where(array('ownerEmail' => $this->input->post('email'),'_id' => array('$nin'=>[new MongoDB\BSON\ObjectID( $_POST['id'] )]) ,'status'=>array('$nin'=>[7])))->get('stores');
        }else{
            $res = $this->mongo_db->where(array('ownerEmail' => $this->input->post('email'),'status'=>array('$nin'=>[7])))->get('stores');
        }
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
        // echo '<pre>';print_r($data);die;
       $data['addressCompo']=json_decode($data['addressCompo']);
       
       
		
	
        
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

        if ($data['CategoryId']) {
            $categoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['CategoryId'])))->find_one('storeCategory');
            $category[] = array('categoryId' => $data['CategoryId'], 'categoryName' => $categoryData['storeCategoryName'],'cartsAllowed' =>$categoryData['cartsAllowed'],'cartsAllowedMsg' =>$categoryData['cartsAllowedMsg']);
            $data['storeCategory'] = $category;
        } else {
            $data['storeCategory'] = [];
        }

        $data['cartsAllowed']=$categoryData['cartsAllowed'];
        $data['cartsAllowedMsg']=$categoryData['cartsAllowedMsg'];

        $data['storeType'] = $categoryData['type'];
        $data['storeTypeMsg'] = $categoryData['typeName'];
        
        if ($data['SubCategoryId']) {
            $subcategoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['SubCategoryId'])))->find_one('storeSubCategory');
            $subcategory[] = array('subCategoryId' => $data['SubCategoryId'], 'subCategoryName' => $subcategoryData['storeSubCategoryName'],'iconImage' =>$subcategoryData['iconImage'] );
            $data['storeSubCategory'] = $subcategory;
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

        if ($data['popularStore'] == 'on') {
            $data['popularStore'] = 1; // enable 
                       
        } else {
            $data['popularStore'] = 0; // disable
            
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

        //cool
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
          //  $data['billingAddress'] = [];
            $data['billingAddress'] = "";
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


        $data['baseFare'] = (float)$data['basefare'];
        $data['range'] = (string) $data['range'];
        $data['pricePerMile'] =  $data['priceperkm'];
        $data['orderEmail'] = "";
        $data['driverType'] = (int) $data['driverType'];
		
        if ($data['driverType'] == 1) {
            $data['driverTypeMsg'] = "Freelance";
        } else {
            $data['driverTypeMsg'] = "StoreDriver";
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

        $this->load->library('elasticsearch');
        $this->load->library('session');
        $this->session->set_userdata(array('Driver_session' => $drivers));

        //$allMasters = $this->mongo_db->get('stores');
        $allMasters = $this->mongo_db->select(array('seqId'=>'seqId'))->get('stores');
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
            $currency = $data['currency'];
            $currencySymbol = $data['currencySymbol'];
        }
        $defaultComm = $this->mongo_db->get('appConfig');
        $commarr = [];
        foreach ($defaultComm as $comm) {
            $commarr = $comm;
        }
        $commission = $commarr['storeDefaultCommission'];
        $consumptionTime = $this->input->post('consumptionTime');

        // $consumptionArr=array();
        // if(count($consumptionTime)){
        //     foreach($consumptionTime as $cTime){
        //         $consumptionArr[$cTime]=TRUE;
        //     }
        // }

        if(count($consumptionTime)){
            foreach($consumptionTime as $cTime){
                $consumptionArr[$cTime]=TRUE;
            }
        }else{
            $array = array();
            $consumptionArr =(object)$array;
        }

        $data['foodTypeMsg']='';
        $data['foodtype']='';
        if($data['foodtype']=='1'){
            $data['foodTypeMsg']="VEG";
        }
        else if($data['foodtype']=='2'){
            $data['foodTypeMsg']="NON-VEG";
        }
        else if($data['foodtype']=='3'){
            $data['foodTypeMsg']="VEG AND NON-VEG";
        }
        else{
            $data['foodTypeMsg']="Not Applicable";
        }

       // $data['costForTwo']="0";
      //  $data['costForTwo'] = (int)$data['costForTwo'];

        if( $data['costForTwo']=="" ){
            $data['costForTwo'] = "";
        }else{
            $data['costForTwo'] = (float)$data['costForTwo'];
        }
        
        if($data['dp_id']){
            $dpId=$data['dp_id'];
        }else{
            $dpId="";
        }

        if($data['dp_email']){
            $dpEmail=$data['dp_email'];
        }else{
            $dpEmail="";
        }

        if($data['dp_name']){
            $dpName=$data['dp_name'];
        }else{
            $dpName="";
        }

       
       // $franchise=""; cool

       


        if ($posID == '' || $posID == null) {

            $resData = array("profileLogos" => $data['profileLogos'], "bannerLogos" => $data['bannerLogos'],
                "name" => $data['BusinessName'], "ownerName" => $data['OwnerName'], 'countryCode' => $data['countryCode'],
                "ownerPhone" => $data['Phone'], "ownerEmail" => $data['Email'], "password" => $data['Password'],
                'bcountryCode' => $data['bCountryCode'], "businessNumber" => $data['businessNumber'],
                "website" => $data['Website'], "description" => $data['Description'], "storeAddr" => $data['storeaddress'],
                "storeBillingAddr" => (string)$data['billingAddress'], "cityId" => $data['city'], "cityName" => $data['cityName'], 'countryId' => $data['Country'],
                "coordinates" => $data['coordinates'], 'businessZoneId' => $businessZoneId, 'businessZoneName' => $businessZoneName, 'serviceZones' => $serviceZones,
                "status" => 3, 'statusMsg' => 'New', 'pricingStatus' => $data['pricingStatus'], 'pricingStatusMsg' => $data['pricingStatusMsg'], "minimumOrder" => $data['minimumOrder'], "freeDeliveryAbove" => $data['freeDeliveryAbove'],
                'pickupCash' => $data['pickupCash'], 'pickupCashMsg' => $data['pickupCashMsg'], 'pickupCard' => $data['pickupCard'], 'pickupCardMsg' => $data['pickupCardMsg'],
                'deliveryCard' => $data['deliveryCard'], 'deliveryCardMsg' => $data['deliveryCardMsg'], 'deliveryCash' => $data['deliveryCash'], 'deliveryCashMsg' => $data['deliveryCashMsg'],
                'orderType' => $data['orderType'], 'orderTypeMsg' => $data['orderTypeMsg'], 'orderEmail' => $data['orderEmail'], 'baseFare' =>(float) $data['baseFare'], 'pricePerMile' => $data['pricePerMile'], 'range' => $data['range'],
                'companyDriver' => $data['grocerDriver'], 'storeDriver' => $data['storeDriver'], 'currency' => $currency, 'currencySymbol' => $currencySymbol,
                'driverType' => $data['driverType'], 'driverTypeMsg' => $data['driverTypeMsg'], 'forcedAccept' => $data['forcedAccept'], 'forcedAcceptMsg' => $data['forcedAcceptMsg'], 'baseFare' =>  $data['baseFare'], 'mileagePrice' =>  $data['mileagePrice'],
                'mileagePriceAfterMinutes' => (int) $data['mileagePriceAfterMinutes'], 'timeFee' =>  $data['timeFee'], 'timeFeeAfterMinutes' =>  $data['timeFeeAfterMinutes'], 'waitingFee' =>(int)  $data['waitingFee'],
                'waitingFeeAfterMinutes' => (int) $data['waitingFeeAfterMinutes'], 'minimumFare' => $data['minimumFare'], 'onDemandBookingsCancellationFee' =>  $data['onDemandBookingsCancellationFee'],
                'onDemandBookingsCancellationFeeAfterMinutes' =>  $data['onDemandBookingsCancellationFeeAfterMinutes'], 'scheduledBookingsCancellationFee' =>  $data['scheduledBookingsCancellationFee'],
                'scheduledBookingsCancellationFeeAfterMinutes' => (float) $data['scheduledBookingsCancellationFeeAfterMinutes'], 'convenienceFee' => (float) $data['convenienceFee'],'convenienceType' =>(int)$data['convenienceType'],'conEnable' => (int)$data['conEnable'],
                'commission' => $commission, 'commissionType' => 0, 'commissionTypeMsg' => 'Percentage',
                'sName' => $data['storeName'], 'storedescription' => $data['storeDescription'],
                'autoApproval' => (int) $data['autoApproval'], 'popularStore'=>$data['popularStore'], 'autoApprovalMsg' => $data['autoApprovalMsg'],
                'autoDispatch' => $data['autoDispatch'], 'autoDispatchMsg' => $data['autoDispatchMsg'],
                'posID' => '', 'locationId' => '', 'urlData' => '', 'walletID' => '', 'paymentsEnabled' => '', 'locationName' => '', 'externalCreditCard' => '', 'internalCreditCard' => '', 'check' => '', 'quickCard' => '', 'giftCard' => '',
                'storeCategory' => $data['storeCategory'], 'storeSubCategory' => $data['storeSubCategory'],
                'socialLinks' => $data['socialLinks'], 'avgDeliveryTime'=>$data['avgDeliveryTime'],'appId' => '',
                'storeType' => (int)$data['storeType'], 'storeTypeMsg'=>(string) $data['storeTypeMsg'] ,
                'dp_id'=>$dpId,
                'dp_email'=>$dpEmail,
                'dp_name'=>$dpName, 'cartsAllowed'=>(int) $data['cartsAllowed'],'cartsAllowedMsg'=> $data['cartsAllowedMsg'],
                'foodType'=>$data['foodtype'],'foodTypeName'=>$data['foodTypeMsg'],"franchiseId"=>"","franchiseName"=>"","costForTwo"=>$data['costForTwo'],'addressCompo'=>$data['addressCompo'],
                'streetName'=>$data['streetname'],'localityName'=>$data['localityname'],'areaName'=>$data['areaname']
            );
           

            $dispatchUrl = APILink . 'store';     
            //echo '<pre>';print_r($resData);die;      
            $addToMongo = json_decode($this->callapi->CallAPI('POST', $dispatchUrl, $resData), true);
            // print_r($addToMongo);die;
            $datEmail = array('name' => $data['OwnerName'], 'email' => $data['Email'], 'password' => $data['Password'], 'storeName' => $data['BusinessName'][0], 'mobile' => $data['bCountryCode'] . $data['businessNumber'], 'status' => 12);
            $urlEmail = APILink . 'admin/email';
            
            // store manager creation
            if($addToMongo['data']['storeId']){
                $password1 = password_hash($data['Password'], PASSWORD_BCRYPT);
                $password = str_replace("$2y$", "$2a$", $password1);
                
                        $cursor = $this->mongo_db->get("users");
                  $arr = [];
                  foreach ($cursor as $catdata) {
                      array_push($arr, $catdata['seqId']);
                  }
                  $max = max($arr);
                  $seq = $max + 1;
              
              $StoreAsManager = array("seqId"=>$seq ,"userType"=>2,"userTypeMsg"=>"Store Manager","name"=>$data['OwnerName'],"status"=>1,
              "email"=>$data['Email'],"password"=>$password,'countryCode' => $data['countryCode'],"cityId" => $data['city'], "cityName" => $data['cityName'],
                  "phone" => $data['businessNumber'],"storeName"=>$data['BusinessName'][0],"storeId"=>$addToMongo['data']['storeId']);
              
                  $userData = $this->mongo_db->insert("users",$StoreAsManager);
                  
              }



            $responseEmail = json_decode($this->callapi->CallAPI('POST', $urlEmail, $datEmail), true);
            echo json_encode(array('status' =>$addToMongo));
            
        //    echo json_encode($addToMongo);
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
                "locationId" => $locationId, "giftCard" => $giftCard, "quickCard" => $quickCard, "check" => $check, "internalCreditCard" => $internalCreditCard, "externalCreditCard" => $externalCreditCard,
                'dp_id'=>$data['dp_id'],
                'dp_email'=>$data['dp_email'],
                'dp_name'=>$data['dp_name'] 
				
            );

            
            $url1 = APILink . 'store';
            $response1 = json_decode($this->callapi->CallAPI('POST', $url1, $resData), true);
            $dat2 = array('name' => $data['OwnerName'], 'email' => $data['Email'], 'password' => $data['Password'], 'storeName' => $data['BusinessName'][0], 'mobile' => $data['bCountryCode'] . $data['businessNumber'], 'status' => 12);
            $url2 = APILink . 'admin/email';
            $response2 = json_decode($this->callapi->CallAPI('POST', $url2, $dat2), true);
            echo json_encode($response2);
        }
    }

    function edit() {

        $data = $_POST;
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
        
        if ($data['CategoryId']) {
            $categoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['CategoryId'])))->find_one('storeCategory');
            $category[] = array('categoryId' => $data['CategoryId'], 'categoryName' => $categoryData['storeCategoryName'],'cartsAllowed' =>$categoryData['cartsAllowed'],'cartsAllowedMsg' =>$categoryData['cartsAllowedMsg']);
            $data['storeCategory'] = $category;
        } else {
            $data['storeCategory'] = [];
        }

        $data['cartsAllowed']=$categoryData['cartsAllowed'];
        $data['cartsAllowedMsg']=$categoryData['cartsAllowedMsg'];

        $data['foodTypeMsg']='';
        if($data['foodType']=='1'){
            $data['foodTypeMsg']="VEG";
        }
        else if($data['foodType']=='2'){
            $data['foodTypeMsg']="NON-VEG";
        }
        else if($data['foodType']=='3'){
            $data['foodTypeMsg']="VEG AND NON-VEG";
        }
        else{
            $data['foodTypeMsg']="Not Applicable";
        }
        
        $data['storeType'] = $categoryData['type'];
        $data['storeTypeMsg'] = $categoryData['typeName'];
        
        if ($data['SubCategoryId']) {
            $subcategoryData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['SubCategoryId'])))->find_one('storeSubCategory');
            $subcategory[] = array('subCategoryId' => $data['SubCategoryId'], 'subCategoryName' => $subcategoryData['storeSubCategoryName']);
            $data['storeSubCategory'] = $subcategory;
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

        if ($data['popularStore'] == 'on') {
            $data['popularStore'] = 1; // enable 
                       
        } else {
            $data['popularStore'] = 0; // disable
            
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

       // $data['driverType'] = (int) $data['driverType'];
      //  if ($data['driverType'] == 1) {
       //     $data['driverTypeMsg'] = "DispensaryDriver";
     //  } else {
      //      $data['driverTypeMsg'] = "Freelance";
      //  }

      $data['driverType'] = (int) $data['driverType'];
		
        if ($data['driverType'] == 1) {
            $data['driverTypeMsg'] = "Freelance";
        } else {
            $data['driverTypeMsg'] = "StoreDriver";
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

       

        $data['baseFare'] =  $data['basefare'];
        $data['range'] = (string) $data['range'];
        $data['pricePerMile'] =  $data['priceperkm'];
        $data['orderEmail'] = "0";

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

        $this->load->library('elasticsearch');
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
        /* if ($data['commissionType'] && $data['commission']) {
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
        } */
        $commission = $data['commission'];
        $commissionType = (int) $data['commissionType'];
        if ($commissionType == 0) {
            $commissionTypeMsg = 'Percentage';
        } else {
            $commissionTypeMsg = 'Fixed';
        }

        //cool
        // $data['costForTwo']="0";
        // $data['costForTwo'] = (int)$data['costForTwo'];

        if( $data['costForTwo']=="" ){
            $data['costForTwo'] = "";
        }else{
            $data['costForTwo'] = (float)$data['costForTwo'];
        }
        
      
        if($data['dp_id']){
            $dpId=$data['dp_id'];
        }else{
            $dpId="";
        }

        if($data['dp_email']){
            $dpEmail=$data['dp_email'];
        }else{
            $dpEmail="";
        }

        if($data['dp_name']){
            $dpName=$data['dp_name'];
        }else{
            $dpName="";
        }

        if ($posID == '' || $posID == null) {

            $resData = array("storeId" => (string) $data['storeId'],
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
                'companyDriver' => (string)$data['grocerDriver'], 'storeDriver' => (string)$data['storeDriver'], 'currency' => $currency, 'currencySymbol' => $currencySymbol,
                'driverType' => $data['driverType'], 'driverTypeMsg' => $data['driverTypeMsg'], 'forcedAccept' => $data['forcedAccept'], 'forcedAcceptMsg' => $data['forcedAcceptMsg'], 'baseFare' => $data['baseFare'], 'mileagePrice' => $data['mileagePrice'],
                'mileagePriceAfterMinutes' => (int) $data['mileagePriceAfterMinutes'], 'timeFee' =>  $data['timeFee'], 'timeFeeAfterMinutes' =>  $data['timeFeeAfterMinutes'], 'waitingFee' => (int) $data['waitingFee'],
                'waitingFeeAfterMinutes' => (int) $data['waitingFeeAfterMinutes'], 'minimumFare' => $data['minimumFare'], 'onDemandBookingsCancellationFee' =>  $data['onDemandBookingsCancellationFee'],
                'onDemandBookingsCancellationFeeAfterMinutes' =>  $data['onDemandBookingsCancellationFeeAfterMinutes'], 'scheduledBookingsCancellationFee' =>  $data['scheduledBookingsCancellationFee'],
                'scheduledBookingsCancellationFeeAfterMinutes' => (float) $data['scheduledBookingsCancellationFeeAfterMinutes'], 'convenienceFee' => (float) $data['convenienceFee'],'convenienceType' =>(int)$data['convenienceType'],'conEnable' => (int)$data['conEnable'],
                'autoApproval' => (int) $data['autoApproval'], 'autoApprovalMsg' => $data['autoApprovalMsg'], 'popularStore' => $data['popularStore'],
                'autoDispatch' => $data['autoDispatch'], 'autoDispatchMsg' => $data['autoDispatchMsg'],
                'commission' => $commission, 'commissionType' => $commissionType, 'commissionTypeMsg' => $commissionTypeMsg, 'sName' => $data['storeName'], 'storedescription' => $data['storeDescription'],
                'storeCategory' => $data['storeCategory'], 'storeSubCategory' => $data['storeSubCategory'],
                'socialLinks' => $data['socialLinks'],'avgDeliveryTime'=>$data['avgDeliveryTime'],
                'storeType' => $data['storeType'], 'storeTypeMsg'=> $data['storeTypeMsg'],
                'foodType'=>$data['foodType'],'foodTypeName'=>$data['foodTypeMsg'],'cartsAllowed'=> (int)$data['cartsAllowed'],'cartsAllowedMsg'=> $data['cartsAllowedMsg'],
                "franchiseId"=>"","franchiseName"=>"","costForTwo"=>$data['costForTwo'],'addressCompo'=>(object)$data['addressCompo'], 'streetName'=>$data['streetname'],'localityName'=>$data['localityname'],'areaName'=>$data['areaname'] );//

        //echo '<pre>'; print_r($resData);die; 
            $dispatchUrl = APILink . 'store';
         
            $addToMongo = json_decode($this->callapi->CallAPI('PATCH', $dispatchUrl, $resData), true);
             //echo '<pre>'      ;print_r($addToMongo);die;
          
            echo json_encode($addToMongo);
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
            //call api for active/inactive store
            $dataToSend = array('storeId'=>$row,'status'=>1,'statusMsg'=>"active");
            $apiUrl = APILink.'storeToUpdateStatus';
            
            $response1 = json_decode($this->callapi->CallAPI('PATCH', $apiUrl, $dataToSend), true);
            // echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($row)))->set(array("status" => (int) 1, 'statusMsg' => "active"))->update('stores');
            if($response1['statusCode'] == 200)
            echo true;
            else
            echo false;
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
            if($d['isDeleted'] == false){
                $res[] = $d;
            }
        }

        echo json_encode($res);
    }

   public function getSubcatList() {
        $val = $this->input->post('val');

        $cursor = $this->mongo_db->where(array("categoryId" => $val,"visibility"=>1))->get('storeSubCategory');
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
        
        // $data['Pending'] = $this->mongo_db->where(array('status'=>3))->count('stores');
        // $data['Active'] = $this->mongo_db->where(array('status'=>1))->count('stores');
        // $data['Inactive'] = $this->mongo_db->where(array('status'=>5))->count('stores');
        // $data['deleted'] = $this->mongo_db->where(array('status'=>7))->count('stores');

       
        $respo = $this->mongo_db->aggregate('stores', array(array('$match'=>array('status' => 3)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))));
        foreach($respo as $res){
            $data['Pending']= json_decode(json_encode($res->count,true));

        }

        $respo = $this->mongo_db->aggregate('stores', array(array('$match'=>array('status' => 1)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))));
        foreach($respo as $res){
            $data['Active']= json_decode(json_encode($res->count,true));

        }

        $respo = $this->mongo_db->aggregate('stores', array(array('$match'=>array('status' => 5)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))));
        foreach($respo as $res){
            $data['Inactive']= json_decode(json_encode($res->count,true));

        }

        $respo = $this->mongo_db->aggregate('stores', array(array('$match'=>array('status' => 7)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))));
        foreach($respo as $res){
            $data['deleted']= json_decode(json_encode($res->count,true));

        }
       

        

        echo json_encode(array('data' => $data));
        
    }
    public function ConvenienceDataCityWise(){
        $this->load->library('mongo_db');
        $cityId=$this->input->post('val');
        $data = $this->mongo_db->where(array("cities.cityId"=>new MongoDB\BSON\ObjectID($cityId)))->find_one('cities');
        foreach ($data['cities'] as $city) {
            if ($cityId == $city['cityId']['$oid']) {
                $data1 = array();
                $data1['convenienceFee'] = $city['convenienceFee'];
                $data1['convenienceType'] = $city['convenienceType'];
            }
        }
        echo json_encode(array('data' => $data1));
    }

}

?>
