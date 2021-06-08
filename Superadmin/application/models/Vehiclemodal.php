<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Vehiclemodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('CallAPI');
        $this->load->library('UtilityLibrary');
        $this->load->model("Home_m");
    }

    function getPackage($minutes) {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;
        $text = '';
        if ($hours > 0)
            $text = $hours . ' Hour ';
        if ($minutes > 0)
            $text = $text . $minutes . ' Minute ';
        return $text;
    }

    function getAppConfig() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->get('appConfig');
        return $getAll;
    }

    function getCities() {
        $this->load->library('mongo_db');

        $datatosend1 = $this->mongo_db->aggregate('cities',array(array('$unwind'=>'$cities'),
        array('$match'=>array("cities.isDeleted"=>false)),
        array('$project'=>array("cities.cityId"=>1,'_id'=>0,'cities.cityName'=>1))
        ));

        $getAll=[];
        foreach($datatosend1 as $city){
           $value = json_decode(json_encode($city), TRUE);
           array_push($getAll,$value);          
        }

        // $getAll = $this->mongo_db->where(array('isDeleted' => FALSE))->get('cities');
         return $getAll;
    }

    function getPromotedVehicleTypes() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->where(array('prices.cityId' => $this->input->post('cityId'), 'ride.isEnabled' => TRUE))->get('vehicleTypes');
        echo json_encode(array('datat' => $getAll));
    }

    function uploadVehicleTypeImage() {
        $this->load->library('mongo_db');
        if ($_POST['onImageAWS'])
            $data['vehicleImgOn'] = $_POST['onImageAWS'];
        if ($_POST['offImageAWS'])
            $data['vehicleImgOff'] = $_POST['offImageAWS'];
        if ($_POST['mapImageAWS'])
            $data['vehicleMapIcon'] = $_POST['mapImageAWS'];

        $this->mongo_db->where(array('typeId' => (int) $_POST['docId']))->set($data)->update('vehicleTypes');
        return;
    }

    function getAppConfigOne() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->find_one('appConfig');
        return $getAll;
    }

    function getVehicleTypeLanguageDate() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('vehicleTypeId'))))->find_one('vehicleTypes');
        $getLanguages = $this->mongo_db->get('languages');
        echo json_encode(array('data' => $getAll, 'lang' => $getLanguages));
    }

    function getLanguages() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->get('languages');
        return $getAll;
    }

    function datatable_vehicleOrdering($status = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $city = $this->session->userdata('cityId');

//Serachable feilds
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "typeName.en";



        if ($city != '')
            $respo = $this->datatables->datatable_mongodb('vehicleTypes', array('prices' => array('$elemMatch' => array('cityId' => $city, 'ride.isEnabled' => TRUE))), 'prices.ride.order');
        else
            $respo = $this->datatables->datatable_mongodb('vehicleTypes', array(), 'order');

        $aaData = $respo["aaData"];
        $datatosend = array();
        $slno = 0;

        foreach ($aaData as $r) {

            $city_price_url = base_url() . "index.php?/vehicle/typeCityPrice/" . $r['typeId'];

            $arr = array();
            $arr[] = $r['typeId'];
            $arr[] = $r['typeName']['en'];
            $arr[] = $r['typeDesc']['en'];
            $arr[] = '<img style="width:30px;" src="' . base_url() . 'theme/assets/img/uparrow.png" data-id="' . $r['typeId'] . '" data="1" class="ordering"><img style="width:30px;" src="' . base_url() . 'theme/assets/img/downarrow.png"  data-id="' . $r['typeId'] . '" data="2"  class="ordering">';

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_vehicletype($status = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $city = $this->session->userdata('cityId');

//Serachable feilds
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "typeName.en";

        if ($city != '')
            $respo = $this->datatables->datatable_mongodbAggregate('vehicleTypes', array(array('$match' => array('prices' => array('$elemMatch' => array('cityId' => $city, '$or' => array(array('ride.isEnabled' => TRUE), array('delivery.isEnabled' => TRUE), array('towtruck.isEnabled' => TRUE)))))),
                array('$unwind' => '$prices'),
                array('$match' => array('prices.cityId' => $city, '$or' => array(array('prices.ride.isEnabled' => TRUE), array('prices.delivery.isEnabled' => TRUE), array('prices.towtruck.isEnabled' => TRUE)))),
                array('$sort' => array('prices.ride.order' => -1))));
        else
            $respo = $this->datatables->datatable_mongodb('vehicleTypes');

        $aaData = $respo["aaData"];
        $datatosend = array();
        $slno = 0;

        foreach ($aaData as $r) {

            $r = json_decode(json_encode($r), TRUE);
            //Check if the vehicle type is special
            if ($city != '')
                $isSpecial = $r['prices']['ride']['isSpecialTypeEnable'];

            $city_price_url = base_url() . "index.php?/vehicle/typeCityPrice/" . $r['typeId'];

            $arr = array();
            $arr[] = $r['typeId'];
            if ($isSpecial)
                $arr[] = $r['typeName']['en'] . '<i title="Special Type" style="cursor: pointer;margin-left: 8px;" class="fa fa-circle text-success"></i>';
            else
                $arr[] = $r['typeName']['en'];
            $arr[] = $r['typeDesc']['en'];
            $arr[] = '<img style="width:30px;" src="' . base_url() . 'theme/assets/img/uparrow.png" data-id="' . $r['typeId'] . '" data="1" class="ordering cls111"><img style="width:30px;" src="' . base_url() . 'theme/assets/img/downarrow.png"  data-id="' . $r['typeId'] . '" data="2"  class="ordering cls111">';

            $arr[] = '<a class="images btn btn-warning " data-toggle="tooltip" title="View Images"  style="text-decoration: none;" data-id="' . $r['typeId'] . '" docId="' . $r['typeId'] . '" type_id="' . $r['typeId'] . '" on_image="' . $r['vehicleImgOn'] . '" off_image="' . $r['vehicleImgOff'] . '" map_image="' . $r['vehicleMapIcon'] . '" style="cursor: pointer"> <i class="fa fa-file-image-o" aria-hidden="true"></i>&nbsp;</a>'
                    . "<a class='btn edit-button button_action cls111 editBtn' data-toggle='tooltip' title='Edit'  href='" . base_url('index.php?/vehicle/vehicletype_addedit/edit/') . $r['typeId'] . "'> <i class='fa fa-edit'></i></a>"
                    . "<button style='display:none;' class='btn btn-danger btn-cons deleteOne cls111' data-toggle='tooltip' title='Delete' data-id='" . $r['_id']['$oid'] . "'><i class='fa fa-trash'></i></button>"
//                    .'<a class="vehicleDetails" length="' . substr($r['vehicleLength']['en'], 0, -1) . '" length_metric = "' . substr($r['vehicleLength']['en'], -1) . '" width="' . substr($r['vehicleWidth']['en'], 0, -1) . '" width_metric = "' . substr($r['vehicleWidth']['en'], -1) . '" height="' . substr($r['vehicleHeight']['en'], 0, -1) . '" height_metric = "' . substr($r['vehicleHeight']['en'], -1) . '" capacity="' . $r['vehicleCapacity']['en'] . '"  style="cursor: pointer;text-decoration: none;"> <button class="btn btn-info btn-sm" style="width:inherit;">' . $this->lang->line('col_button_details') . '</button></a>'
                    . '<a href="' . $city_price_url . '"><button class="btn btn-primary btn-cons cls111" >' . $this->lang->line('col_button_edit_pricing') . '</button></a>';


//            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" data-id="' . $r['_id']['$oid'] . '" value= "' . $r['typeId'] . '"/>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function vehicletype_reordering() {
//        
        $this->load->library('mongo_db');
        $city = $this->session->userdata('cityId');
        $vehicleTypeFirst = $this->mongo_db->where(array('typeId' => (int) $_REQUEST['curr_id']))->find_one('vehicleTypes');
        $vehicleTypeSecond = $this->mongo_db->where(array('typeId' => (int) $_REQUEST['prev_id']))->find_one('vehicleTypes');


        foreach ($vehicleTypeFirst['prices'] as $row) {
            if ($row['cityId'] == $city) {
                $currcount = $row['ride']['order'];
                break;
            }
        }

        foreach ($vehicleTypeSecond['prices'] as $row) {
            if ($row['cityId'] == $city) {
                $prevcount = $row['ride']['order'];
                break;
            }
        }

        $res_mongo1 = $this->mongo_db->where(array('typeId' => (int) $_REQUEST['curr_id'], 'prices.cityId' => $city))->set(array('prices.$.ride.order' => (int) $prevcount))->update('vehicleTypes');
        $res_mongo2 = $this->mongo_db->where(array('typeId' => (int) $_REQUEST['prev_id'], 'prices.cityId' => $city))->set(array('prices.$.ride.order' => (int) $currcount))->update('vehicleTypes');

        if ($res_mongo1 == TRUE && $res_mongo2 == TRUE)
            echo json_encode(array('flag' => 0));
        else
            echo json_encode(array('flag' => 1));
        return true;
    }

    public function cityVehicleOrdering() {
//        
        $this->load->library('mongo_db');
        $city = $this->session->userdata('cityId');
        $res = $this->mongo_db->where(array('typeId' => (int) $_REQUEST['curr_id']))->find_one('vehicleTypes');
        $res1 = $this->mongo_db->where(array('typeId' => (int) $_REQUEST['prev_id']))->find_one('vehicleTypes');

        $currcount = $res['order'];
        $prevcount = $res1['order'];


        $res_mongo1 = $this->mongo_db->where(array('typeId' => (int) $_REQUEST['curr_id'], 'prices.cityId' => $city))->set(array('prices.$.ride.order' => 3))->update('vehicleTypes');
        $res_mongo2 = $this->mongo_db->where(array('typeId' => (int) $_REQUEST['prev_id'], 'prices.cityId' => $city))->set(array('prices.$.ride.order' => 9))->update('vehicleTypes');

        if ($res_mongo1 == TRUE && $res_mongo2 == TRUE)
            echo json_encode(array('flag' => 0));
        else
            echo json_encode(array('flag' => 1));
        return true;
    }

    function getSpecialityData() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->get('masterSpecialities');
        return $getAll;
    }

    function delete_vehicletype() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');

        foreach ($val as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('vehicleTypes');
//            $this->mongo_db->where(array('specialTypes' => array('$in' => [$id])))->pull('specialTypes', array('$in' => [$id]))->update('vehicleTypes', array('multi' => TRUE));
        }

        echo json_encode(array('msg' => "vehicle type deleted successfully", 'flag' => 0));
        return;
    }

    function cityForZones() {
        $cityData = $this->mongo_db->get('cities');
        return $cityData;
    }

    function update_vehicletype($param) {
        $bookingTypeSelected = $this->input->post('bookingTypeSelected');
        $vehicleLength = $this->input->post('vehicle_length') . $this->input->post('vehicle_length_metric');
        $vehicleWidth = $this->input->post('vehicle_width') . $this->input->post('vehicle_width_metric');
        $vehicleHeight = $this->input->post('vehicle_height') . $this->input->post('vehicle_height_metric');

        $vehicleCapacity = $this->input->post('vehicle_capacity');

        $vehicletype = $this->input->post('vehicletypename');
        $discription = $this->input->post('descrption');

        $isDropLocationMandatory = FALSE;
        if ($this->input->post('isDropLocationMandatory') == 'on')
            $isDropLocationMandatory = TRUE;

//Images
        $onImageAWS = $this->input->post('onImageAWS');
        $offImageAWS = $this->input->post('offImageAWS');
        $mapImageAWS = $this->input->post('mapImageAWS');

//English
        $typeName['typeName']['en'] = $vehicletype;
        $vehicleL['vehicleLength']['en'] = $vehicleLength;
        $vehicleW['vehicleWidth']['en'] = $vehicleWidth;
        $vehicleH['vehicleHeight']['en'] = $vehicleHeight;
        $vehicleC['vehicleCapacity']['en'] = $vehicleCapacity;
        $typeDesc['typeDesc']['en'] = $discription;

        $allLanguages = $this->mongo_db->get('languages');
        foreach ($allLanguages as $lang) {
            $typeName['typeName'][$lang['code']] = $this->input->post($lang['name'] . '_vehicletypename');
            $vehicleL['vehicleLength'][$lang['code']] = $this->input->post($lang['name'] . '_vehicle_length') . $this->input->post('vehicle_length_metric');
            $vehicleW['vehicleWidth'][$lang['code']] = $this->input->post($lang['name'] . '_vehicle_width') . $this->input->post('vehicle_width_metric');
            $vehicleH['vehicleHeight'][$lang['code']] = $this->input->post($lang['name'] . '_vehicle_height') . $this->input->post('vehicle_height_metric');
            $vehicleC['vehicleCapacity'][$lang['code']] = $this->input->post($lang['name'] . '_vehicle_capacity');
            $typeDesc['typeDesc'][$lang['code']] = $this->input->post($lang['name'] . '_descrption');
        }

        $update_mongo_data = array(
            'bookingType' => (int) $bookingTypeSelected,
            'isDropLocationMandatory' => $isDropLocationMandatory,
//            'isSpecialType' => $isSpecialType,
            'typeName' => $typeName['typeName'],
            'vehicleLength' => $vehicleL['vehicleLength'],
            'vehicleWidth' => $vehicleW['vehicleWidth'],
            'vehicleHeight' => $vehicleH['vehicleHeight'],
            'vehicleCapacity' => $vehicleC['vehicleCapacity'],
            'typeDesc' => $typeDesc['typeDesc'],
//            'specialTypes' => $specialTypeArr,
            'goodTypes' => $this->input->post('goodType'));


        if ($onImageAWS)
            $update_mongo_data['vehicleImgOn'] = $onImageAWS;

        if ($offImageAWS)
            $update_mongo_data['vehicleImgOff'] = $offImageAWS;

        if ($mapImageAWS)
            $update_mongo_data['vehicleMapIcon'] = $mapImageAWS;

        $this->mongo_db->where(array('typeId' => (int) $param))->set($update_mongo_data)->update('vehicleTypes');

        return;
    }

    function getMongoVehicleType($param = '') {
        $this->load->library('mongo_db');
        $result = $this->mongo_db->where(array('typeId' => (int) $param))->find_one('vehicleTypes');
        return $result;
    }

    function datatable_typeCityPrice($typeId) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        //Serachable feilds
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "city";
        $cityId = $this->session->userdata('cityId');

        if ($cityId !== "")
            $respo = $this->datatables->datatable_mongodb('cities', array('isDeleted' => false, '_id' => new MongoDB\BSON\ObjectID($cityId)));
            
        else
            $respo = $this->datatables->datatable_mongodb('cities', array('isDeleted' => false));
            
            $respo = $this->datatables->datatable_mongodbAggregate('cities', array(array('$unwind' => '$cities'),
       array('$match'=>array('cities.isDeleted'=>FALSE)),
      //    array('$project'=>array("country"=>1,"cities.cityId"=>1,"cities.cityName"=>1,"cities.state"=>1,"cities.currency"=>1,"cities.currencySymbol"=>1,"cities.weightMetricText"=>1,"cities.mileageMetric"=>1,"cities.paymentMethods"=>1,"cities.isDeleted"=>1)),
       array('$sort'=>array('cities.cityId'=> -1))
       ),array(array('$unwind' => '$cities'),array('$match'=>array('cities.isDeleted'=>FALSE)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1))))
    );

    
        $vehicleTypes = $this->mongo_db->where(array('typeId' => (int) $typeId))->find_one('vehicleTypes');
      

        $aaData = $respo["aaData"];
        $datatosend = array();
        $slno = 0;

        foreach ($aaData as $city) {

            $myId=((string)$city->cities->cityId);
            $city->cities->cityId = (string)$city->cities->cityId;
            $city = json_decode(json_encode($city),TRUE);
            $result = $city['cities'];

            //echo '<pre>';print_r( $result['cityId']);die;
            //echo '<pre>';print_r($result);die;

             $ride_type_city = "ride" . "_" . $typeId . "_" . $result['cityId'];
             $delivery_type_city = "delivery" . "_" . $typeId . "_" . $result['cityId'];
            // $towtruck_type_city = "towtruck" . "_" . $typeId . "_" . $city['_id']['$oid'];

            // $delivery_enable = "";
            // $ride_enable = "";
            // $towtruck_enable = "";
            // foreach ($vehicleTypes['prices'] as $prices) {
            //     if ($prices['cityId'] == $city['_id']['$oid']) {
            //         $delivery_enable = $prices['delivery']['isEnabled'];
            //         $ride_enable = $prices['ride']['isEnabled'];
            //         $towtruck_enable = $prices['towtruck']['isEnabled'];
            //     }
            // }
            // if ($delivery_enable)
            //     $delivery_enable = "checked";
            // if ($ride_enable)
            //     $ride_enable = "checked";
            // if ($towtruck_enable)
            //     $towtruck_enable = "checked";

            // $rideEnable = '-';
            // $deliveryEnable = '-';
            // $towTruckEnable = '-';

            $action = '';
            if ($vehicleTypes['isTowingEnable'] == true) {
                //$towTruckEnable = '<div class="switch"><input onclick="return updateTypeStatus(this)" ' . $towtruck_enable . '  id="' . $towtruck_type_city . '" name="' . $towtruck_type_city . '" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;"><label for="' . $towtruck_type_city . '" style="position:relative"></label></div>';
                $action = '<a class="images" style="cursor: pointer"> <button onclick="getRidePriceByType(this)" id="' . $towtruck_type_city . '" style="width:inherit;" cityId="' .  $result['cityId'] . '" class="btn btn-info btn-sm">TOWTRUCK PRICE</button></a>';
            } else {
               //getDeliveryPriceByType
                $action = '<a class="images" style="cursor: pointer"> <button onclick="getRidePriceByType(this)" id="' . $ride_type_city . '" style="width:inherit;" cityId="' .  $result['cityId'] . '" class="btn btn-info btn-sm">FOOD</button></a>
                <a class="images" style="cursor: pointer;text-decoration: none;"> <button id="' . $delivery_type_city . '" onclick="getRidePriceByType(this)" style="width:inherit;background-color: #f3ac62;border-color: #f3ac62;" class="btn btn-info btn-sm">GROCERY</button></a>';
            }
            
            $action =$action . '<a class="images" style="cursor: pointer"> <button onclick="getRidePriceByType(this)" id="' . $ride_type_city . '" style="width:inherit;" cityId="' .  $result['cityId'] . '" class="btn btn-success btn-sm">SEND PACKAGES</button></a>
            <a class="images" style="cursor: pointer;text-decoration: none;"> <button id="' . $delivery_type_city . '" onclick="getRidePriceByType(this)" style="width:inherit;border-color: #f3ac62;" class="btn btn-info btn-sm">LAUNDRY</button></a>';

            $action =$action . '<a class="images" style="cursor: pointer"> <button onclick="getRidePriceByType(this)" id="' . $ride_type_city . '" style="width:inherit;" cityId="' .  $result['cityId'] . '" class="btn btn-warning btn-sm">PHARMACY</button></a>
            <a class="images" style="cursor: pointer;text-decoration: none;"> <button id="' . $delivery_type_city . '" onclick="getRidePriceByType(this)" style="width:inherit;border-color: #f3ac62;" class="btn btn-danger btn-sm">ORDER ANYTHING</button></a>';

            // $action = $action . '<button style="width:inherit;" data-id="' . $ride_type_city . '" cityId="' .  $result['cityId'] . '" class="btn btn-success btn-sm" onclick="getRidePriceByType(this)" id="' . $towtruck_type_city . '">SEND PACKAGES</button>';
            // $action = $action . '<button style="width:inherit;" data-id="' . $ride_type_city . '" cityId="' .  $result['cityId'] . '" class="btn btn-info btn-sm" onclick="getRidePriceByType(this)" id="' . $towtruck_type_city . '">LAUNDRY</button>';
            // $action = $action . '<button style="width:inherit;" data-id="' . $ride_type_city . '" cityId="' .  $result['cityId'] . '" class="btn btn-warning btn-sm" onclick="getRidePriceByType(this)" id="' . $towtruck_type_city . '">PHARMACY</button>';
            // $action = $action . '<button style="width:inherit;" data-id="' . $ride_type_city . '" cityId="' .  $result['cityId'] . '" class="btn btn-danger btn-sm" onclick="getRidePriceByType(this)" >ORDER ANYTHING</button>';
            


            if (isset($city['isRentalEnabled']) && $city['isRentalEnabled']) {
                $action = $action . '<button style="width:inherit;background-color:#ca6023;border-color:#ca6023" data-id="' . $vehicleTypes['_id']['$oid'] . '" cityId="' . $city['_id']['$oid'] . '" class="setRentalPackages btn btn-success btn-sm">RENTAL PACKAGES</button>';
            }

            $arr = array();
            $arr[] = ++$slno;
            $arr[] = $result['cityName'];
            $arr[] = $action;

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function getRentalPackages() {
        $cityDetails = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($_POST['cityId'])))->find_one('cities');
        $cityPkgIds = [];
        if (isset($cityDetails['rentalPackages']) && !empty($cityDetails['rentalPackages'])) {
            foreach ($cityDetails['rentalPackages'] as $pkgId)
                $cityPkgIds[] = new MongoDB\BSON\ObjectID($pkgId['$oid']);
        }
        $response = $this->mongo_db->where(array('isDeleted' => FALSE, '_id' => array('$in' => $cityPkgIds)))->get('rentalPackages');

        $allRentalPackages = array();
        foreach ($response as $pks) {
            $pks['pkgName'] = $this->getPackage($pks['packageMinutes']);
            $allRentalPackages[] = $pks;
        }
        $vehicleTypeRentalPackages = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($_POST['id']), 'prices.cityId' => $_POST['cityId']))->find_one('vehicleTypes');
        $rentalPackages = [];
        foreach ($vehicleTypeRentalPackages['prices'] as $pref) {
           
            if ($pref['cityId'] == $_POST['cityId']) {
                $rentalPackages = $pref['ride']['rentalPackages'];
            }
        }
        echo json_encode(array('data' => $allRentalPackages, 'rentalPackages' => ($rentalPackages == NULL)?[]:$rentalPackages,'cityDetails'=>$cityDetails));
        return;
    }

    function getPreferences() {
        $bookingPreferences = $this->mongo_db->where(array('isDeleted' => FALSE, 'preferenceFor' => 1))->get('bookingPreferences');
        $selectedPreferences = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($_POST['id']), 'prices.cityId' => $_POST['cityId']))->find_one('vehicleTypes');
        $preference = [];
        foreach ($selectedPreferences['prices'] as $pref) {
            if ($pref['cityId'] == $_POST['cityId']) {
                if (count($pref['ride']['bookingPreferences']) > 0) {
                    foreach ($pref['ride']['bookingPreferences'] as $id)
                        $preference[] = $id['$oid'];
                }
                break;
            }
        }
        echo json_encode(array('data' => $bookingPreferences, 'selectedPreferences' => $preference));
        return;
    }

    function getPreferenceSelected() {

        $vehiclePreferences = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($_POST['vehicleId'])))->find_one('vehicles');
        $selectedPreferences = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($_POST['vehicleTypeId']), 'prices.cityId' => $vehiclePreferences['cityId']['$oid']))->find_one('vehicleTypes');
        $preference = [];
        $preferenceIds = [];
        foreach ($selectedPreferences['prices'] as $pref) {
            if ($pref['cityId'] == $vehiclePreferences['cityId']['$oid']) {
                if (count($pref['ride']['bookingPreferences']) > 0) {
                    foreach ($pref['ride']['bookingPreferences'] as $id) {
                        $preference[] = $id['$oid'];
                        $preferenceIds[] = new MongoDB\BSON\ObjectID($id['$oid']);
                    }
                }
                break;
            }
        }
        $bookingPreferences = $this->mongo_db->where(array('isDeleted' => FALSE, 'preferenceFor' => 1, '_id' => array('$in' => $preferenceIds)))->get('bookingPreferences');
        echo json_encode(array('bookingPreferences' => $bookingPreferences, 'vehicleTypePreferences' => $preference, 'vehiclePreference' => $vehiclePreferences['vehiclePreference']));
        return;
    }

    function getVehiclePreferences($preferenceIds = '') {

        $selectedPreferences = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($_POST['id']), 'prices.cityId' => $_POST['cityId']))->find_one('vehicleTypes');
        $preference = [];
        foreach ($selectedPreferences['prices'] as $pref) {
            if ($pref['cityId'] == $_POST['cityId']) {
                if (count($pref['ride']['bookingPreferences']) > 0) {
                    foreach ($pref['ride']['bookingPreferences'] as $id)
                        $preference[] = new MongoDB\BSON\ObjectID($id['$oid']);
                }
                break;
            }
        }
        if ($preference)
            $vehiclePreferences = $this->mongo_db->where(array('_id' => array('$in' => $preference), 'isDeleted' => FALSE, 'preferenceFor' => 1))->get('bookingPreferences');
        return $vehiclePreferences;
    }

    function updateRentalPackages() {

        $rentalPackages = [];
//         $response = $this->mongo_db->where(array('isDeleted' => FALSE, '_id' => array('$in' => $cityPkgIds)))->get('rentalPackages');
        foreach ($_POST['rentalPackagesEnable'] as $pkgId) {
            $packages = [];
            $packages['rentalPackageId'] = new MongoDB\BSON\ObjectID($pkgId);
            $packages['baseFare'] = (float) $_POST['baseFare'][$pkgId];
            $packages['timeFare'] = (float) $_POST['timeFare'][$pkgId];
            $packages['distanceFare'] = (float) $_POST['distanceFare'][$pkgId];
            $rentalPackages[] = $packages;
        }

        $data = array('prices.$.ride.rentalPackages' => $rentalPackages);
        $bookingPreferences = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($_POST['documentId']), 'prices.cityId' => $_POST['cityId']))->set($data)->update('vehicleTypes');
        echo json_encode(array('msg' => 'Updated Preference', 'flag' => 0));
        return;
    }

    function updatePreferences() {
        $ids = [];
        foreach ($_POST['preference'] as $pref)
            $ids[] = new MongoDB\BSON\ObjectID($pref);

        $data = array('prices.$.ride.bookingPreferences' => $ids, 'prices.$.towtruck.bookingPreferences' => $ids);
        $bookingPreferences = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($_POST['documentId']), 'prices.cityId' => $_POST['cityId']))->set($data)->update('vehicleTypes');
        echo json_encode(array('msg' => 'Updated Preference', 'flag' => 0));
        return;
    }

    function insert_vehicletype() {

        $vehicleTypes = $this->mongo_db->where(array('typeName.en' => $_POST['vehicletypename']))->find_one('vehicleTypes');

        if (!empty($vehicleTypes)) {//if the vehicle type is already exists
            echo json_encode(array('errorCode' => 1, 'msg' => 'This vehicle type is aready exists'));
        } else {

            $vehicleLength = $this->input->post('vehicle_length') . $this->input->post('vehicle_length_metric');
            $vehicleWidth = $this->input->post('vehicle_width') . $this->input->post('vehicle_width_metric');
            $vehicleHeight = $this->input->post('vehicle_height') . $this->input->post('vehicle_height_metric');
            $vehicleCapacity = $this->input->post('vehicle_capacity');
            $vehicletype = $this->input->post('vehicletypename');
            $discription = $this->input->post('descrption');

            // $isDropLocationMandatory = FALSE;
            // if ($this->input->post('isDropLocationMandatory') == 'on')
            //     $isDropLocationMandatory = TRUE;



            // $isMeterBookingEnable = FALSE;
            // if ($this->input->post('isMeterBookingEnable') == 'on')
            //     $isMeterBookingEnable = TRUE;

            // $isTowingEnable = FALSE;
            // if ($this->input->post('isTowingEnable') == 'on')
            //     $isTowingEnable = TRUE;

            $type_on_image = $this->input->post('onImageAWS');
            $type_off_image = $this->input->post('offImageAWS');
            $type_map_image = $this->input->post('mapImageAWS');

            $rideBookingTypeSelected = $this->input->post('bookingTypeSelected');
            $rideBookingTypeText = '';

            //Ride
            $rideAdvanceBookingFee = (float) 0;
            switch ($rideBookingTypeSelected) {
                case 0:$rideBookingTypeText = 'Book Now And Later';
                    $rideAdvanceBookingFee = $this->input->post('advanceBookingFeeRide');
                    break;
                case 1:$rideBookingTypeText = 'Book Now';
                    break;
                case 2:$rideBookingTypeText = 'Book Later';
                    $rideAdvanceBookingFee = $this->input->post('advanceBookingFeeRide');
                    break;
            }

            $deliveryBookingTypeSelected = $this->input->post('bookingTypeDeliverySelected');
            $deliveryBookingTypeText = '';

            //Delievry
            $deliveryAdvanceBookingFee = (float) 0;
            switch ($deliveryBookingTypeSelected) {
                case 0:$deliveryBookingTypeText = 'Book Now And Later';
                    $deliveryAdvanceBookingFee = $this->input->post('advanceBookingFeeDelivery');
                    break;
                case 1:$deliveryBookingTypeText = 'Book Now';
                    break;
                case 2:$deliveryBookingTypeText = 'Book Later';
                    $deliveryAdvanceBookingFee = $this->input->post('advanceBookingFeeDelivery');
                    break;
            }


//DELIVERY DATA
            $baseFare = $this->input->post('baseFare');
            $mileage_after_x_km_mile = $this->input->post('mileage_after_x_km_mile');
            $mileage_metric = $this->input->post('mileage_metric');
            $mileage_price = $this->input->post('mileage');

            $x_minutesTripDuration = $this->input->post('x_minutesTripDuration');
            $price_after_x_minutesTripDuration = $this->input->post('price_after_x_minutesTripDuration');

            $x_minutesWaiting = $this->input->post('x_minutesWaiting');
            $price_after_x_minWaiting = $this->input->post('price_after_x_minWaiting');

//On demand bookings
            $x_minutesCancel = $this->input->post('x_minutesCancel');
            $price_after_x_minCancel = $this->input->post('price_after_x_minCancel');

//Scheduled bookings
            $x_minutesCancelScheduledBookings = $this->input->post('x_minutesCancelScheduledBookings');
            $price_after_x_minCancelScheduledBookings = $this->input->post('price_after_x_minCancelScheduledBookings');


            $x_km_mileMinimumFee = $this->input->post('x_km_mileMinimumFee');
            $price_MinimumFee = $this->input->post('price_MinimumFee');

            $longHaulEnDis = FALSE;
            if ($this->input->post('longHaulEnDis') == 'on')
                $longHaulEnDis = TRUE;


//RIDE DATA
            $seatingCapacity = $this->input->post('seatingCapacity');
            $ride_baseFare = $this->input->post('ride_baseFare');
            $ride_mileage_after_x_km_mile = $this->input->post('ride_mileage_after_x_km_mile');
            $ride_mileage_metric = $this->input->post('ride_mileage_metric');
            $ride_mileage_price = $this->input->post('ride_mileage');

            $ride_x_minutesTripDuration = $this->input->post('ride_x_minutesTripDuration');
            $ride_price_after_x_minutesTripDuration = $this->input->post('ride_price_after_x_minutesTripDuration');

            $ride_x_minutesWaiting = $this->input->post('ride_x_minutesWaiting');
          //  $ride_price_after_x_minWaiting = $this->input->post('ride_price_after_x_minWaiting');

//On demand bookings
            $ride_x_minutesCancel = $this->input->post('ride_x_minutesCancel');
            $ride_price_after_x_minCancel = $this->input->post('ride_price_after_x_minCancel');


//Scheduled bookings
            $ride_x_minutesCancelScheduledBookings = $this->input->post('ride_x_minutesCancelScheduledBookings');
            $ride_price_after_x_minCancelScheduledBookings = $this->input->post('ride_price_after_x_minCancelScheduledBookings');

            $ride_x_km_mileMinimumFee = $this->input->post('ride_x_km_mileMinimumFee');
            $ride_price_MinimumFee = $this->input->post('ride_price_MinimumFee');

            $result = $this->mongo_db->get('vehicleTypes');
            $type_id = 1;
            if (!empty($result)) {
                foreach ($result as $each)
                    $type_id = (int) $each['typeId'];
            }

            $serviceType = $this->input->post('serviceTypeSelected'); //1->Ride 2 ->Delivery

            $appConfig = $this->mongo_db->find_one('appConfig');

            // $datatosend1 = $this->mongo_db->get('cities');

            $datatosend1 = $this->mongo_db->aggregate('cities',array(array('$unwind'=>'$cities'),
            array('$match'=>array("cities.isDeleted"=>false)),
            array('$project'=>array("cities.cityId"=>1,'_id'=>0))
            ));


            

         
            foreach ($datatosend1 as $city) {

                $id = (string)$city->_id;
                $value = json_decode(json_encode($city), TRUE);

                // echo '<pre>';print_r($value);
                // echo '<pre>';print_r($value['cities']['cityId']['$oid']);die;
             
                $city_id = $value['cities']['cityId']['$oid'];             
                 
                $delivery_id = new MongoDB\BSON\ObjectID();
                $ride_id = new MongoDB\BSON\ObjectID();
                $towtruck_id = new MongoDB\BSON\ObjectID();

                $price_arr[] = array(
                    'cityId' => $city_id,
                    'ride' =>
                    array(
                        '_id' => $ride_id,
                        'isEnabled' => FALSE,
                        'isSpecialTypeEnable' => FALSE,
                        'specialTypes' => [],
                        'isVehicleTypePromotedEnable' => FALSE,
                        'promotedTypes' => [],
                        'bookingType' => (int) $rideBookingTypeSelected,
                        'bookingTypeText' => $rideBookingTypeText,
                        'seatingCapacity' => (int) $seatingCapacity,
                        'baseFee' => (float) $ride_baseFare,
                        'laterBookingAdvanceFee' => (float) $rideAdvanceBookingFee,
                        'mileageAfterXMetric' => (int) $ride_mileage_after_x_km_mile,
                        'minFee' => (float) $ride_price_MinimumFee,
                        'minDistance' => (int) $ride_x_km_mileMinimumFee,
                        'cancellationFee' => (float) $ride_price_after_x_minCancel,
                        'cancellationXMinute' => (int) $ride_x_minutesCancel,
                        'scheduledBookingCancellationXMinute' => (int) $ride_x_minutesCancelScheduledBookings,
                        'scheduledBookingCancellationFee' => (float) $ride_price_after_x_minCancelScheduledBookings,
                        'waitingTimeXMinute' => (int) $ride_x_minutesWaiting,
                    //    'waitingFee' => (float) $ride_price_after_x_minWaiting,
                        'mileagePrice' => (float) $ride_mileage_price,
                        'timeFeeXMinute' => $ride_x_minutesTripDuration,
                        'timeFee' => $ride_price_after_x_minutesTripDuration,
                      // 'isDropLocationMandatory' => $isDropLocationMandatory,
                     //   'isMeterBookingEnable' => $isMeterBookingEnable,
                        "order" => (int) $type_id + 1,
                    ),
                    'towtruck' =>
                    array(
                        '_id' => $towtruck_id,
                        'isEnabled' => FALSE,
                        'isSpecialTypeEnable' => FALSE,
                        'specialTypes' => [],
                        'isVehicleTypePromotedEnable' => FALSE,
                        'promotedTypes' => [],
                        'bookingType' => (int) $rideBookingTypeSelected,
                        'bookingTypeText' => $rideBookingTypeText,
                        'seatingCapacity' => (int) $seatingCapacity,
                        'baseFee' => (float) $ride_baseFare,
                        'laterBookingAdvanceFee' => (float) $rideAdvanceBookingFee,
                        'mileageAfterXMetric' => (int) $ride_mileage_after_x_km_mile,
                        'minFee' => (float) $ride_price_MinimumFee,
                        'minDistance' => (int) $ride_x_km_mileMinimumFee,
                        'cancellationFee' => (float) $ride_price_after_x_minCancel,
                        'cancellationXMinute' => (int) $ride_x_minutesCancel,
                        'scheduledBookingCancellationXMinute' => (int) $ride_x_minutesCancelScheduledBookings,
                        'scheduledBookingCancellationFee' => (float) $ride_price_after_x_minCancelScheduledBookings,
                        'waitingTimeXMinute' => (int) $ride_x_minutesWaiting,
                     //   'waitingFee' => (float) $ride_price_after_x_minWaiting,
                        'mileagePrice' => (float) $ride_mileage_price,
                        'timeFeeXMinute' => $ride_x_minutesTripDuration,
                        'timeFee' => $ride_price_after_x_minutesTripDuration,
                       // 'isDropLocationMandatory' => $isDropLocationMandatory,
                      //  'isMeterBookingEnable' => $isMeterBookingEnable,
                        "order" => (int) $type_id + 1,
                    ),
                    'delivery' =>
                    array(
                        '_id' => $delivery_id,
                        'isEnabled' => FALSE,
                        'bookingType' => (int) $deliveryBookingTypeSelected,
                        'bookingTypeText' => $deliveryBookingTypeText,
                        'baseFee' => (float) $baseFare,
                        'laterBookingAdvanceFee' => (float) $deliveryAdvanceBookingFee,
                        'mileageAfterXMetric' => (int) $mileage_after_x_km_mile,
                        'minFee' => (float) $price_MinimumFee,
                        'minDistance' => (int) $x_km_mileMinimumFee,
                        'cancellationFee' => (float) $price_after_x_minCancel,
                        'cancellationXMinute' => (int) $x_minutesCancel,
                        'scheduledBookingCancellationXMinute' => (int) $x_minutesCancelScheduledBookings,
                        'scheduledBookingCancellationFee' => (float) $price_after_x_minCancelScheduledBookings,
                        'waitingTimeXMinute' => (int) $x_minutesWaiting,
                        'waitingFee' => (float) $price_after_x_minWaiting,
                        'mileagePrice' => (float) $mileage_price,
                        'timeFeeXMinute' => $x_minutesTripDuration,
                        'timeFee' => $price_after_x_minutesTripDuration,
                        'longHaulEnDis' => (int) $longHaulEnDis
                    )
                );
            }


            $defualt_price = array(
                'ride' =>
                array(
                    'baseFee' => (float) $ride_baseFare,
                    'bookingType' => (int) $rideBookingTypeSelected,
                    'bookingTypeText' => $rideBookingTypeText,
                    'seatingCapacity' => (int) $seatingCapacity,
                    'mileageAfterXMetric' => (int) $ride_mileage_after_x_km_mile,
                    'minFee' => (float) $ride_price_MinimumFee,
                    'minDistance' => (int) $ride_x_km_mileMinimumFee,
                    'cancellationFee' => (float) $ride_price_after_x_minCancel,
                    'cancellationXMinute' => (int) $ride_x_minutesCancel,
                    'scheduledBookingCancellationXMinute' => (int) $ride_x_minutesCancelScheduledBookings,
                    'scheduledBookingCancellationFee' => (float) $ride_price_after_x_minCancelScheduledBookings,
                    'waitingTimeXMinute' => (int) $ride_x_minutesWaiting,
                //    'waitingFee' => (float) $ride_price_after_x_minWaiting,
                    'mileagePrice' => (float) $ride_mileage_price,
                    'timeFeeXMinute' => $ride_x_minutesTripDuration,
                    'timeFee' => $ride_price_after_x_minutesTripDuration,
                  //  'isDropLocationMandatory' => $isDropLocationMandatory,
                  //  'isMeterBookingEnable' => $isMeterBookingEnable
                ),
                'towtruck' =>
                array(
                    'baseFee' => (float) $ride_baseFare,
                    'bookingType' => (int) $rideBookingTypeSelected,
                    'bookingTypeText' => $rideBookingTypeText,
                    'seatingCapacity' => (int) $seatingCapacity,
                    'mileageAfterXMetric' => (int) $ride_mileage_after_x_km_mile,
                    'minFee' => (float) $ride_price_MinimumFee,
                    'minDistance' => (int) $ride_x_km_mileMinimumFee,
                    'cancellationFee' => (float) $ride_price_after_x_minCancel,
                    'cancellationXMinute' => (int) $ride_x_minutesCancel,
                    'scheduledBookingCancellationXMinute' => (int) $ride_x_minutesCancelScheduledBookings,
                    'scheduledBookingCancellationFee' => (float) $ride_price_after_x_minCancelScheduledBookings,
                    'waitingTimeXMinute' => (int) $ride_x_minutesWaiting,
                //    'waitingFee' => (float) $ride_price_after_x_minWaiting,
                    'mileagePrice' => (float) $ride_mileage_price,
                    'timeFeeXMinute' => $ride_x_minutesTripDuration,
                    'timeFee' => $ride_price_after_x_minutesTripDuration,
                  //  'isDropLocationMandatory' => $isDropLocationMandatory,
                  //  'isMeterBookingEnable' => $isMeterBookingEnable
                ),
                'delivery' =>
                array(
                    'baseFee' => (float) $baseFare,
                    'bookingType' => (int) $deliveryBookingTypeSelected,
                    'bookingTypeText' => $deliveryBookingTypeText,
                    'mileageAfterXMetric' => (int) $mileage_after_x_km_mile,
                    'minFee' => (float) $price_MinimumFee,
                    'minDistance' => (int) $x_km_mileMinimumFee,
                    'cancellationFee' => (float) $price_after_x_minCancel,
                    'cancellationXMinute' => (int) $x_minutesCancel,
                    'scheduledBookingCancellationXMinute' => (int) $x_minutesCancelScheduledBookings,
                    'scheduledBookingCancellationFee' => (float) $price_after_x_minCancelScheduledBookings,
                    'waitingTimeXMinute' => (int) $x_minutesWaiting,
                    'waitingFee' => (float) $price_after_x_minWaiting,
                    'mileagePrice' => (float) $mileage_price,
                    'timeFeeXMinute' => $x_minutesTripDuration,
                    'timeFee' => $price_after_x_minutesTripDuration,
                    'longHaulEnDis' => (int) $longHaulEnDis
                )
            );


            $isSpecialType = FALSE;
            $specialTypeArr = array();
            if ($this->input->post('specialTypeInputValue') == 1) {
                $isSpecialType = TRUE;
                $specialTypeArr = $this->input->post('specialType');
            }

//English
            $typeName['typeName']['en'] = $vehicletype;
            $vehicleL['vehicleLength']['en'] = $vehicleLength;
            $vehicleW['vehicleWidth']['en'] = $vehicleWidth;
            $vehicleH['vehicleHeight']['en'] = $vehicleHeight;
            $vehicleC['vehicleCapacity']['en'] = $vehicleCapacity;
            $typeDesc['typeDesc']['en'] = $discription;

            $allLanguages = $this->mongo_db->get('languages');
            foreach ($allLanguages as $lang) {
                $typeName['typeName'][$lang['code']] = $this->input->post($lang['name'] . '_vehicletypename');
                $vehicleL['vehicleLength'][$lang['code']] = $this->input->post($lang['name'] . '_vehicle_length') . $this->input->post('vehicle_length_metric');
                $vehicleW['vehicleWidth'][$lang['code']] = $this->input->post($lang['name'] . '_vehicle_width') . $this->input->post('vehicle_width_metric');
                $vehicleH['vehicleHeight'][$lang['code']] = $this->input->post($lang['name'] . '_vehicle_height') . $this->input->post('vehicle_height_metric');
                $vehicleC['vehicleCapacity'][$lang['code']] = $this->input->post($lang['name'] . '_vehicle_capacity');
                $typeDesc['typeDesc'][$lang['code']] = $this->input->post($lang['name'] . '_descrption');
            }


            $insertArr = array(
//                'isSpecialType' => $isSpecialType,
                'typeId' => (int) $type_id + 1,
                'typeName' => $typeName['typeName'],
                'vehicleLength' => $vehicleL['vehicleLength'],
                'vehicleWidth' => $vehicleW['vehicleWidth'],
                'vehicleHeight' => $vehicleH['vehicleHeight'],
                'vehicleCapacity' => $vehicleC['vehicleCapacity'],
                'typeDesc' => $typeDesc['typeDesc'],
                "order" => (int) $type_id + 1,
                "vehicleImgOn" => $type_on_image,
                "vehicleImgOff" => $type_off_image,
                "vehicleMapIcon" => $type_map_image,
              //  'isTowingEnable' => $isTowingEnable,
                'goodTypes' => $this->input->post('goodType'),
//                'specialTypes' => $specialTypeArr,
                'prices' => $price_arr,
                'defualtPrice' => $defualt_price
            );

            // echo '<pre>';print_r($insertArr);die;
            $result = $this->mongo_db->insert('vehicleTypes', $insertArr);

            if ($result)
                echo json_encode(array('errorCode' => 0, 'msg' => 'success'));
            else
                echo json_encode(array('errorCode' => 1, 'msg' => 'Error'));
        }

        return;
    }

    function uploadImage() {
        $this->utilitylibrary->uploadImage();
    }

    function deleteImage() {
        $this->utilitylibrary->deleteImage($this->input->post('imgUrl'));
    }

    function updateTypeStatus() {
        $type_city = $this->input->post('type_city');
        $isEnabled = $this->input->post('isEnabled');
        $type_city_arr = explode("_", $type_city);

        if ($isEnabled)
            $isEnabled = true;
        else
            $isEnabled = false;


        $vehicleTypes = $this->mongo_db->get_where('vehicleTypes', array('typeId' => (int) $type_city_arr[1]));
        $vehicleTypes = $vehicleTypes[0];
        $updateIndex = -1;
        $isCityFoundInType = 0;
        foreach ($vehicleTypes['prices'] as $prices) {
            $updateIndex++;
            if ($prices['cityId'] == $type_city_arr[2]) {
                $isCityFoundInType = 1;
                break;
            }
        }

        if ($isCityFoundInType == 1) {

            $update_data = array('prices.' . $updateIndex . '.' . $type_city_arr[0] . '.isEnabled' => $isEnabled, 'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.isSpecialTypeEnable' => FALSE, 'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.specialTypes' => []);

            $cond = array('prices.' . $updateIndex . '.cityId' => $type_city_arr[2], 'typeId' => (int) $type_city_arr[1]);
            $res_enamble = $this->mongo_db->where($cond)->set($update_data)->update('vehicleTypes');
        } else {

            $errFlag = 1;
            $errMsg = "Please  set default price first then you can enable/disable";
            echo json_encode(array(
                'errMsg' => $errMsg,
                'errFlag' => $errFlag
            ));
            return;
        }
        $errFlag = 0;
        $errMsg = "status updated";
        if ($updateIndex == -1) {
            $errFlag = 1;
            $errMsg = "error occured while update status";
        }
        echo json_encode(array(
            'errMsg' => $errMsg,
            'errFlag' => $errFlag,
            'res' => $res_enamble,
            'cond' => $cond,
            'updateIndex' => $updateIndex,
            'update_data' => $update_data
        ));
        return;
    }

    function getPriceByType() {
        $type_city = $this->input->post('type_city');
     
        $type_city_arr = explode("_", $type_city);
        $result = $this->mongo_db->where(array('typeId' => (int) $type_city_arr[1]))->find_one('vehicleTypes');

        $errFlag = 0;
        if ($type_city_arr[0] == "" || $type_city_arr[1] == "" || $type_city_arr[2] == "")
            $errFlag = 1;

        $local_price = 0;
        $data = '';
        $cityData = '';
        foreach ($result['prices'] as $price) {

            if ($price['cityId'] == $type_city_arr[2]) {
                $cityData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($price['cityId'])))->find_one('cities');
                $local_price = 1;
                $data = $price;
                break;
            }
        }

        if ($local_price == 0) {
            $data = $result['defualtPrice'];
        }

        $cityDetails = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($type_city_arr[2])))->find_one('cities');
        $specialType = $this->mongo_db->where(array('prices' => array('$elemMatch' => array('cityId' => $type_city_arr[2], 'ride.isSpecialTypeEnable' => TRUE, 'ride.isEnabled' => TRUE)), 'typeId' => array('$nin' => [(int) $type_city_arr[1]])))->get('vehicleTypes');

//        $promotedTypes = $this->mongo_db->where(array('prices' => array('$elemMatch' => array('cityId' => $type_city_arr[2], 'ride.isVehicleTypePromotedEnable' => FALSE, 'ride.isSpecialTypeEnable' => FALSE, 'ride.isEnabled' => TRUE)), 'typeId' => array('$nin' => [(int) $type_city_arr[1]])))->get('vehicleTypes');
        $promotedTypes = $this->mongo_db->where(array('prices' => array('$elemMatch' => array('cityId' => $type_city_arr[2], '$or' => array(array('ride.isVehicleTypePromotedEnable' => FALSE), array('ride.isVehicleTypePromotedEnable' => array('$exists' => FALSE))), '$or' => array(array('ride.isSpecialTypeEnable' => FALSE), array('ride.isSpecialTypeEnable' => array('$exists' => FALSE))), 'ride.isEnabled' => TRUE)), 'typeId' => array('$nin' => [(int) $type_city_arr[1]])))->get('vehicleTypes');
        $isSpecialAlreadyExist = FALSE;
        if ($specialType)
            $isSpecialAlreadyExist = TRUE;
        echo json_encode(array(
            'errFlag' => $errFlag,
            'data' => $data[$type_city_arr[0]],
            'cityData' => $cityData,
            'vehicleTypes' => $promotedTypes,
            'promotedVehicleTypes' => $promotedTypes,
            'type' => $type_city_arr[0],
            'currency' => $cityDetails['currency'],
            'currencySymbol' => $cityDetails['currencySymbol'],
            'id' => $result['_id']['$oid'],
            'isSpecialAlreadyExist' => $isSpecialAlreadyExist
        ));
    }

    function updateTypePrice() {

        $type_city = $this->input->post('updateRidePriceId');
        $type_city_arr = explode("_", $type_city);

        $vehicleTypes = $this->mongo_db->get_where('vehicleTypes', array('typeId' => (int) $type_city_arr[1]));
        $vehicleTypes = $vehicleTypes[0];
        $updateIndex = -1;
        $isCityIdFoundInType = 0;
        foreach ($vehicleTypes['prices'] as $prices) {
            $updateIndex++;
            if ($prices['cityId'] == $type_city_arr[2]) {
                $isCityIdFoundInType = 1;
                break;
            }
        }

        $seatingCapacity = $this->input->post('seatingCapacity');
        $baseFare = $this->input->post('baseFare');
        $bookingType = $this->input->post('bookingTypeSelected');

        switch ($bookingType) {
            case 0:$bookingTypeText = 'Book Now And Later';
                $feeAdvance = (float) $this->input->post('advanceFee');
                break;
            case 1:$bookingTypeText = 'Book Now';
                $feeAdvance = (float) 0;

                break;
            case 2:$bookingTypeText = 'Book Later';
                $feeAdvance = (float) $this->input->post('advanceFee');
                break;
        }

        $mileage_after_x_km_mile = $this->input->post('mileage_after_x_km_mile');
        $mileage_metric = $this->input->post('mileage_metric');
        $mileage_price = $this->input->post('mileage');

        $x_minutesTripDuration = $this->input->post('x_minutesTripDuration');
        $price_after_x_minutesTripDuration = $this->input->post('price_after_x_minutesTripDuration');

        $x_minutesWaiting = $this->input->post('x_minutesWaiting');
        $price_after_x_minWaiting = $this->input->post('price_after_x_minWaiting');

//On demand bookings
        $x_minutesCancel = $this->input->post('x_minutesCancel');
        $price_after_x_minCancel = $this->input->post('price_after_x_minCancel');

//Scheduled bookings
        $x_minutesCancelScheduledBookings = $this->input->post('x_minutesCancelScheduledBookings');
        $price_after_x_minCancelScheduledBookings = $this->input->post('price_after_x_minCancelScheduledBookings');

        $x_km_mileMinimumFee = $this->input->post('x_km_mileMinimumFee');
        $price_MinimumFee = $this->input->post('price_MinimumFee');
        $longHaulEnDis = FALSE;
        if ($this->input->post('longHaulEnDis') == 'on')
            $longHaulEnDis = TRUE;

        // $isDropLocationMandatory = FALSE;
        // if ($this->input->post('isDropLocationMandatory') == 'on')
        //     $isDropLocationMandatory = TRUE;

        // $isMeterBookingEnable = FALSE;
        // if ($this->input->post('isMeterBookingEnable') == 'on')
        //     $isMeterBookingEnable = TRUE;

        $specialTypes = ($this->input->post('specialType')) ? $this->input->post('specialType') : array();
        $promotedType = ($this->input->post('promotedType')) ? $this->input->post('promotedType') : array();

        switch ($this->input->post('isSpecialOrPromoted')) {
            case 1:
                $specialType = $this->mongo_db->where(array('prices' => array('$elemMatch' => array('cityId' => $type_city_arr[2], 'ride.isSpecialTypeEnable' => TRUE, 'ride.isEnabled' => TRUE)), 'typeId' => array('$nin' => [(int) $type_city_arr[1]])))->get('vehicleTypes');

                if ($specialType) {
                    echo json_encode(array('errMsg' => 'Already special type exists', 'errFlag' => 1));
                    return;
                }
                $isSpecialType = TRUE;
                $isVehicleTypePromotedEnable = FALSE;
                $specialTypes[] = $_POST['documentId'];
                break;
            case 2:$isVehicleTypePromotedEnable = TRUE;
                $isSpecialType = FALSE;
                array_unshift($promotedType, $_POST['documentId']);
                break;
            case 3:$isVehicleTypePromotedEnable = FALSE;
                $isSpecialType = FALSE;
                break;
        }

        if ($type_city_arr[0] == 'ride') {

            $update_data = array(
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.seatingCapacity' => (int) $seatingCapacity,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.isVehicleTypePromotedEnable' => $isVehicleTypePromotedEnable,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.promotedTypes' => $promotedType,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.isSpecialTypeEnable' => $isSpecialType,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.specialTypes' => $specialTypes,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.baseFee' => (float) $baseFare,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.bookingType' => (int) $bookingType,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.bookingTypeText' => $bookingTypeText,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.mileageAfterXMetric' => (int) $mileage_after_x_km_mile,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.minFee' => (float) $price_MinimumFee,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.minDistance' => (int) $x_km_mileMinimumFee,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.cancellationFee' => (float) $price_after_x_minCancel,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.cancellationXMinute' => (int) $x_minutesCancel,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.scheduledBookingCancellationXMinute' => (int) $x_minutesCancelScheduledBookings,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.scheduledBookingCancellationFee' => (float) $price_after_x_minCancelScheduledBookings,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.waitingTimeXMinute' => (int) $x_minutesWaiting,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.waitingFee' => (float) $price_after_x_minWaiting,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.mileagePrice' => (float) $mileage_price,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.timeFeeXMinute' => $x_minutesTripDuration,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.timeFee' => $price_after_x_minutesTripDuration,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.isDropLocationMandatory' => $isDropLocationMandatory,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.isMeterBookingEnable' => $isMeterBookingEnable
            );

            //Advance booking fee
            switch ($bookingType) {
                case 0:$bookingTypeText = 'Book Now And Later';
                    $feeAdvance = (float) $this->input->post('advanceFee');
                    $update_data = array_merge($update_data, array('prices.' . $updateIndex . '.' . $type_city_arr[0] . '.laterBookingAdvanceFee' => (float) $feeAdvance));
                    break;
                case 1:$bookingTypeText = 'Book Now';
                    $feeAdvance = (float) 0;
                    break;
                case 2:$bookingTypeText = 'Book Later';
                    $feeAdvance = (float) $this->input->post('advanceFee');
                    $update_data = array_merge($update_data, array('prices.' . $updateIndex . '.' . $type_city_arr[0] . '.laterBookingAdvanceFee' => (float) $feeAdvance));
                    break;
            }
        } else if ($type_city_arr[0] == 'towtruck') {

            $update_data = array(
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.seatingCapacity' => (int) $seatingCapacity,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.isVehicleTypePromotedEnable' => $isVehicleTypePromotedEnable,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.promotedTypes' => $promotedType,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.isSpecialTypeEnable' => $isSpecialType,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.specialTypes' => $specialTypes,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.baseFee' => (float) $baseFare,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.bookingType' => (int) $bookingType,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.bookingTypeText' => $bookingTypeText,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.mileageAfterXMetric' => (int) $mileage_after_x_km_mile,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.minFee' => (float) $price_MinimumFee,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.minDistance' => (int) $x_km_mileMinimumFee,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.cancellationFee' => (float) $price_after_x_minCancel,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.cancellationXMinute' => (int) $x_minutesCancel,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.scheduledBookingCancellationXMinute' => (int) $x_minutesCancelScheduledBookings,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.scheduledBookingCancellationFee' => (float) $price_after_x_minCancelScheduledBookings,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.waitingTimeXMinute' => (int) $x_minutesWaiting,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.waitingFee' => (float) $price_after_x_minWaiting,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.mileagePrice' => (float) $mileage_price,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.timeFeeXMinute' => $x_minutesTripDuration,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.timeFee' => $price_after_x_minutesTripDuration,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.isDropLocationMandatory' => $isDropLocationMandatory,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.isMeterBookingEnable' => $isMeterBookingEnable
            );

            //Advance booking fee
            switch ($bookingType) {
                case 0:$bookingTypeText = 'Book Now And Later';
                    $feeAdvance = (float) $this->input->post('advanceFee');
                    $update_data = array_merge($update_data, array('prices.' . $updateIndex . '.' . $type_city_arr[0] . '.laterBookingAdvanceFee' => (float) $feeAdvance));
                    break;
                case 1:$bookingTypeText = 'Book Now';
                    $feeAdvance = (float) 0;
                    break;
                case 2:$bookingTypeText = 'Book Later';
                    $feeAdvance = (float) $this->input->post('advanceFee');
                    $update_data = array_merge($update_data, array('prices.' . $updateIndex . '.' . $type_city_arr[0] . '.laterBookingAdvanceFee' => (float) $feeAdvance));
                    break;
            }
        } else {
            $update_data = array(
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.baseFee' => (float) $baseFare,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.bookingType' => (int) $bookingType,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.bookingTypeText' => $bookingTypeText,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.mileageAfterXMetric' => (int) $mileage_after_x_km_mile,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.minFee' => (float) $price_MinimumFee,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.minDistance' => (int) $x_km_mileMinimumFee,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.cancellationFee' => (float) $price_after_x_minCancel,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.cancellationXMinute' => (int) $x_minutesCancel,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.scheduledBookingCancellationXMinute' => (int) $x_minutesCancelScheduledBookings,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.scheduledBookingCancellationFee' => (float) $price_after_x_minCancelScheduledBookings,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.waitingTimeXMinute' => (int) $x_minutesWaiting,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.waitingFee' => (float) $price_after_x_minWaiting,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.mileagePrice' => (float) $mileage_price,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.timeFeeXMinute' => $x_minutesTripDuration,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.timeFee' => $price_after_x_minutesTripDuration,
                'prices.' . $updateIndex . '.' . $type_city_arr[0] . '.longHaulEnDis' => $longHaulEnDis
            );

            //Advance booking fee
            switch ($bookingType) {
                case 0:$bookingTypeText = 'Book Now And Later';
                    $feeAdvance = (float) $this->input->post('advanceFee');
                    $update_data = array_merge($update_data, array('prices.' . $updateIndex . '.' . $type_city_arr[0] . '.laterBookingAdvanceFee' => (float) $feeAdvance));
                    break;
                case 1:$bookingTypeText = 'Book Now';
                    $feeAdvance = (float) 0;
                    break;
                case 2:$bookingTypeText = 'Book Later';
                    $feeAdvance = (float) $this->input->post('advanceFee');
                    $update_data = array_merge($update_data, array('prices.' . $updateIndex . '.' . $type_city_arr[0] . '.laterBookingAdvanceFee' => (float) $feeAdvance));
                    break;
            }
        }



        if ($isCityIdFoundInType == 1) {
            $cond = array('prices.' . $updateIndex . '.cityId' => $type_city_arr[2], 'typeId' => (int) $type_city_arr[1]);
            $res_enamble = $this->mongo_db->where($cond)->set($update_data)->update('vehicleTypes');
        } else {
            $cond = array('typeId' => (int) $type_city_arr[1]);

            $delivery_data = array(
                '_id' => new MongoDB\BSON\ObjectID(),
                'isEnabled' => false,
                'baseFee' => (float) $baseFare,
                'mileageAfterXMetric' => (int) $mileage_after_x_km_mile,
                'minFee' => (float) $price_MinimumFee,
                'minDistance' => (int) $x_km_mileMinimumFee,
                'cancellationFee' => (float) $price_after_x_minCancel,
                'cancellationXMinute' => (int) $x_minutesCancel,
                'scheduledBookingCancellationXMinute' => (int) $x_minutesCancelScheduledBookings,
                'scheduledBookingCancellationFee' => (float) $price_after_x_minCancelScheduledBookings,
                'waitingTimeXMinute' => (int) $x_minutesWaiting,
              //  'waitingFee' => (float) $price_after_x_minWaiting,
                'mileagePrice' => (float) $mileage_price,
                'timeFeeXMinute' => $x_minutesTripDuration,
                'timeFee' => $price_after_x_minutesTripDuration,
               // 'isDropLocationMandatory' => $isDropLocationMandatory
            );
            $ride_data = array(
                '_id' => new MongoDB\BSON\ObjectID(),
                'isEnabled' => false,
                'seatingCapacity' => (int) $seatingCapacity,
                'baseFee' => (float) $baseFare,
                'mileageAfterXMetric' => (int) $mileage_after_x_km_mile,
                'minFee' => (float) $price_MinimumFee,
                'minDistance' => (int) $x_km_mileMinimumFee,
                'cancellationFee' => (float) $price_after_x_minCancel,
                'cancellationXMinute' => (int) $x_minutesCancel,
                'scheduledBookingCancellationXMinute' => (int) $x_minutesCancelScheduledBookings,
                'scheduledBookingCancellationFee' => (float) $price_after_x_minCancelScheduledBookings,
                'waitingTimeXMinute' => (int) $x_minutesWaiting,
             //   'waitingFee' => (float) $price_after_x_minWaiting,
                'mileagePrice' => (float) $mileage_price,
                'timeFeeXMinute' => $x_minutesTripDuration,
                'timeFee' => $price_after_x_minutesTripDuration,
                'longHaulEnDis' => $longHaulEnDis
            );
            $push_date = array(
                'cityId' => $type_city_arr[2],
                'delivery' => $delivery_data,
                'ride' => $ride_data
            );
            $res_enamble = $this->mongo_db->where($cond)->push(array('prices' => $push_date))->update('vehicleTypes');
        }
        $errFlag = 0; //5ad9f863f9a60e16fd26657f
        $errMsg = "Changes updated";
        if ($updateIndex == -1) {
            $errFlag = 1;
            $errMsg = "error occured while update data";
        }
        echo json_encode(array(
            'errMsg' => $errMsg,
            'errFlag' => $errFlag,
            'res' => $res_enamble,
            'cond' => $cond,
            'updateIndex' => $updateIndex,
            'update_data' => $update_data
        ));
        return;
    }

    function updateNote() {
        //if internet goes off 
        if ($_POST) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('vehicleId'))))->set(array('notes' => $_POST['notes']))->update('vehicles');
        }
        return true;
    }

    function getNote($id) {
        $response = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->select(array('notes'))->find_one('vehicles');
        echo json_encode(array('data' => $response));
        return true;
    }

    function datatable_vehicles($status = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "make";
        $_POST['mDataProp_1'] = "model";
        $_POST['mDataProp_2'] = "type";
        $_POST['mDataProp_3'] = "driverName";
        $_POST['mDataProp_4'] = "driverMobile";
        $_POST['mDataProp_5'] = "operatorName";
        $_POST['mDataProp_6'] = "plateNo";
        $_POST['mDataProp_7'] = "plateNoActual";
        $_POST['mDataProp_8'] = "vehicleId";
        $_POST['mDataProp_9'] = "services.serviceName";


        if ($status == '2')
            $respo = $this->datatables->datatable_mongodb('vehicles', array('accountType' => 1, 'status' => array('$in' => [2, 4, 5])));
        else if ($status == '4')
            $respo = $this->datatables->datatable_mongodb('vehicles', array('accountType' => 1, 'status' => array('$in' => [2, 4])));
        else
            $respo = $this->datatables->datatable_mongodb('vehicles', array('accountType' => 1, 'status' => (int) $status));


        $aaData = $respo["aaData"];
        $datatosend = array();

        $sl = 0;
        foreach ($aaData as $value) {

            if (isset($value['masterId']) && $value['masterId']['$oid'] != "" && $value['masterId']['$oid'] != NULL)
                $masterData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['masterId']['$oid'])))->find_one('masters');
            if ($status == '5') {

                if ($masterData['location']['latitude'] === 0.0)
                    $elapsed = '';
                else {
                    if ($masterData['lastActive']) {
                        $time = (int) (time() - $masterData['lastActive']);
                        $timeAgo = $this->datatables->secondsToTime($time);

                        $diffTime = $timeAgo['m'] . ' min ago';

                        if ((int) $timeAgo['h'] > 0)
                            $diffTime = $timeAgo['h'] . ' hour ' . $diffTime;

                        if ((int) $timeAgo['d'] > 0)
                            $diffTime = $timeAgo['d'] . ' day ' . $diffTime;

                        $elapsed = '<br> <b><span style="color:#1ABB9C;font-style: italic;font-size: 10px;">' . $diffTime . '</span></b>';
                    } else
                        $elapsed = '';
                }
            }

            $masterName = 'N/A';
            $masterPhone = 'N/A';
            if (!empty($masterData)) {
                //Mask the email and phone for demo user
                if ($this->session->userdata('maskEmail') == TRUE) {
                    $masterData['email'] = $this->Home_m->maskFileds($masterData['email'], 1);
                    $masterData['phone']['phone'] = $this->Home_m->maskFileds($masterData['phone']['countryCode'] . $masterData['phone']['phone'], 2);
                    $masterData['phone']['countryCode'] = '';
                }
//                $masterName = '<a style="cursor: pointer;color: dodgerblue;" id="driverID' . $masterData['_id']['$oid'] . '"  class="getDriverDetails" mas_id="' . $masterData['_id']['$oid'] . '">' . $masterData['firstName'] . ' ' . $masterData['lastName'] . '</a>';
                $masterName = '<a target="_blank" href="' . base_url('index.php?/drivers/profile/') . $masterData['_id']['$oid'] . '" style="cursor: pointer;color: dodgerblue;" id="driverID' . $masterData['_id']['$oid'] . '"  class="" mas_id="' . $masterData['_id']['$oid'] . '">' . $masterData['firstName'] . ' ' . $masterData['lastName'] . '</a>';
                $masterPhone = $masterData['phone']['countryCode'] . $masterData['phone']['phone'];
            }

            $index = 0;
            $businesType = '';
            foreach ($value['services'] as $service) {
                $businesType .= $service['serviceName'];
                if (count($value['services']) == 2 && $index == 0)
                    $businesType .= ' & ';
                $index++;
            }

            $view_document = '<a class="documentsView btn btn-info" data-toggle="tooltip" title="View Documents"  style="text-decoration: none;" data-id="' . $value['_id']['$oid'] . '" style="cursor: pointer"> <i class="fa fa-file-image-o" aria-hidden="true"></i>&nbsp;</a>';
            $activate = "<button class='btn btn-success btn-cons activateVehicles cls111' data-toggle='tooltip' title='Activate' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-check-circle'></i></button>";
            $deactivate = "<button class='btn btn-warning btn-cons deactivateVehicles cls111' data-toggle='tooltip' title='Deactivate' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-times-circle'></i></button>";
            $edit = "<a class='btn btn-info edit-button button_action cls111 editBtn' data-toggle='tooltip' href='" . base_url('index.php?/vehicle/vehicleOperations/edit/') . $value['_id']['$oid'] . "' title='Edit' data-id=" . $value['_id']['$oid'] . "> <i class='fa fa-edit'></i></a>";
            $delete = "<button class='btn btn-danger btn-cons deleteOne cls111' data-toggle='tooltip' title='Delete' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-trash'></i></button>";
            $notes = "<button style='width: 50px;' class='buttonCss btn btn-info btn-cons notes cls111' data-toggle='tooltip' title='Notes' data-id='" . $value['_id']['$oid'] . "'>Notes</button>";

            if($status == 2)
            {
                $action = $view_document . $deactivate . $edit . $delete . $notes;
            }
            elseif ($status == 3) 
            {
                $action = $view_document . $activate . $delete . $notes;
            }
            else
            {
                $action = $view_document . $activate . $deactivate . $edit . $delete . $notes;
            }

            $arr = array();
            $arr[] = $value['vehicleId'];
            $arr[] = $value['typeName']['en'];
            $arr[] = $value['plateNo'];
            $arr[] = $value['make'];
            $arr[] = $value['model'];
            $arr[] = $value['colour'];
            $arr[] = $businesType;
            $arr[] = ($value['account_type'] == 2) ? 'N/A' : $masterName;
            $arr[] = ($value['account_type'] == 2) ? 'N/A' : $masterPhone;

            $arr[] = '<span style="color: #13a5d0;">' . (isset($masterData['mobileDevices']['lastLogin']) && $masterData['mobileDevices']['lastLogin'] != '') ? date('j-M-Y g:i A', (($masterData['mobileDevices']['lastLogin']['$date'] / 1000) - ($this->session->userdata('timeOffset') * 60))) : '' . '</span><br>' . number_format($masterData['location']['latitude'], 6) . ', ' . number_format($masterData['location']['longitude'], 6) . $elapsed;
            $arr[] = '<span style="color: #13a5d0;">' . (isset($masterData['mobileDevices']['lastLogin']) && $masterData['mobileDevices']['lastLogin'] != '') ? date('j-M-Y g:i A', (($masterData['mobileDevices']['lastLogin']['$date'] / 1000) - ($this->session->userdata('timeOffset') * 60))) : '' . '</span><br>' . number_format($masterData['location']['latitude'], 6) . ', ' . number_format($masterData['location']['longitude'], 6) . $elapsed;
            $arr[] = ($value['accountType'] == 2) ? 'Operator' : 'Private';
            $arr[] = $value['notes'];
            $arr[] = $action;
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function getvehicleCount() {
        $this->load->library('mongo_db');
        $data['New'] = $this->mongo_db->where(array('status' => 1, 'accountType' => 1))->count('vehicles');
        $data['Accepted'] = $this->mongo_db->where(array('accountType' => 1, 'status' => array('$in' => [2, 4, 5])))->count('vehicles');
        $data['Rejepted'] = $this->mongo_db->where(array('accountType' => 1, 'status' => 3))->count('vehicles');
        $data['Free'] = $this->mongo_db->where(array('accountType' => 1, 'status' => array('$in' => [2, 4])))->count('vehicles');
        $data['Assigned'] = $this->mongo_db->where(array('accountType' => 1, 'status' => 5))->count('vehicles');
        $data['deletedVehicleCount'] = $this->mongo_db->where(array('accountType' => 1, 'status' => 6))->count('vehicles');

        echo json_encode(array('data' => $data));
        return;
    }

    function getOperators($OperatorID = '') {
        $this->load->library('mongo_db');
        if ($OperatorID == '')
            $operatorData = $this->mongo_db->where(array('status' => 3))->get('operators');
        else
            $operatorData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($OperatorID)))->find_one('operators');

        return $operatorData;
    }

    function vehicleTypeData() {
        $this->load->library('mongo_db');
        $vehicleTypes = $this->mongo_db->get('vehicleTypes');
        return $vehicleTypes;
    }

    function getCityVehicleTypeData($cityId) {
        $this->load->library('mongo_db');
        $cityVehicleTypes = $this->mongo_db->where(array('prices' => array('$elemMatch' => array('cityId' => $cityId, '$or' => array(array('ride.isEnabled' => TRUE), array('delivery.isEnabled' => TRUE), array('towtruck.isEnabled' => TRUE))))))->get('vehicleTypes');

        return $cityVehicleTypes;
    }

    function getSpecificVehicleType($vehicleTypeId) {
        $this->load->library('mongo_db');
        $vehicleTypes = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($vehicleTypeId)))->find_one('vehicleTypes');

        return $vehicleTypes;
    }

    function getVehicleType() {
        $this->load->library('mongo_db');
        $vehicleTypes = $this->mongo_db->where(array('isSpecialType' => FALSE))->get('vehicleTypes');
        return $vehicleTypes;
    }

    function get_vehiclemake() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->get('vehicleMake');
        return $getAll;
    }

    function getDriverDetails() {

        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('mas_id'))))->find_one('masters');


        if ($this->session->userdata('maskEmail') == TRUE) {
            $data['email'] = $this->maskFileds($data['email'], 1);
            $data['countryCode'] = $this->maskFileds($data['countryCode'] . $data['mobile'], 2);
            $data['mobile'] = '';
        }
//      $data['createdDt'] = date('j-M-Y g:i A',(int)($data['createdDt']['$date']/1000));
        $data['createdDt'] = (int) ($data['createdDt']['$date'] / 1000);

        if (count($data['newPlans']) > 0) {
            $Driver_plans = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['newPlans'][count($data['newPlans']) - 1]['planID']['$oid'])))->find_one('Driver_plans');
        } else
            $Driver_plans = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['planID']['$oid'])))->find_one('Driver_plans');

        echo json_encode(array('driverData' => $data, 'driverPlan' => $Driver_plans));
        return;
    }

    function getVehicleModel() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $condition = array(
            array(
                '$unwind' => '$models'
            ),
            array(
                '$match' => array(
                    '_id' => new MongoDB\BSON\ObjectID($this->input->post('adv')),
                    'models.year' => $this->input->post('year')
                )
            )
        );

        $vehicleModelData = $this->mongo_db->aggregate('vehicleMake', $condition);

        $arr = [];
        foreach ($vehicleModelData as $doc) {
            $arr[] = $doc;
        }
        echo "<option value=''>Select</option>";
        foreach ($arr as $model) {
            echo "<option value='" . $model->models->_id . "' name='" . $model->models->name->en . "'>" . $model->models->name->en . "</option>";
        }
        die;
    }

    function getGoodTypes() {
        $this->load->library('mongo_db');
        $vehicleType = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('vehicleTypeID'))))->find_one('vehicleTypes');
        $allGoodTypes = $this->mongo_db->get('masterSpecialities');
        $vehicleTypePreferences = $this->mongo_db->aggregate('vehicleTypes', array(array('$match' => array('_id' => new MongoDB\BSON\ObjectID($this->input->post('vehicleTypeID')))), array('$unwind' => '$prices'), array('$match' => array('prices.cityId' => $this->input->post('cityId')))));
        $vehiclePreferences = [];
        foreach ($vehicleTypePreferences as $row) {
           
            $ids = $row->prices->ride->bookingPreferences;
           
            if (count($ids) > 0) {
                foreach ($ids as $id)
                    $preferenceIds[] = new MongoDB\BSON\ObjectID($id);
                $vehiclePreferences = $this->mongo_db->where(array('_id' => array('$in' => $preferenceIds)))->get('bookingPreferences');
            }
        }

        echo json_encode(array('allGoodTypes' => $allGoodTypes, 'vehicleTypGoodTypes' => $vehicleType['goodTypes'], 'vehicleTypePrice' => $vehicleType['prices'], 'vehiclePreference' => $vehiclePreferences));
        return;
    }

    function getVehicleMake() {
        $this->load->library('mongo_db');
        $vehicleModel = $this->mongo_db->where(array('models.year' => $this->input->post('adv')))->get('vehicleMake');
        echo "<option value=''>Select</option>";
        foreach ($vehicleModel as $model) {
            echo "<option value='" . $model['_id']['$oid'] . "' name='" . $model['makeName']['en'] . "'>" . $model['makeName']['en'] . "</option>";
        }
        die;
    }

    function addVehicleMake() {
        $this->load->library('mongo_db');

        $t = time();
        $typename = $this->input->post('typename');
        $condition = array(
            "makeName.en" => new MongoDB\BSON\Regex('^' . $typename['en'] . '$', "i")
        );
        $data = $this->mongo_db->where($condition)->find_one('vehicleMake');

        $models = array();

        if (count($data) != 0) {
            echo json_encode(array('msg' => "Entered brand name is already exist, please try again with other brand name", 'flag' => 1));
            return;
        } else {
            $insertArr = array(
                'makeName' => $typename, //$typeName['makeName']
                'models' => $models,
                'updatedOn' => $t
            );
            $result = $this->mongo_db->insert('vehicleMake', $insertArr);

            if ($result) {
                echo json_encode(array('msg' => "Brand name inserted successfully", 'flag' => 0));
                return;
            } else {
                echo json_encode(array('msg' => "Failed to insert", 'flag' => 1));
                return;
            }
        }
    }

    function editVehicleMake() {
        $this->load->library('mongo_db');
        $t = time();
        $typename = $this->input->post('typename_e');
        $insertArr = array(
            'makeName' => $typename,
            'updatedOn' => $t
        );
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id'))))->set($insertArr)->update('vehicleMake');

        if ($result) {
            echo json_encode(array('msg' => "Brand name updated", 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => "Failed to insert", 'flag' => 1));
            return;
        }
    }

    function deletemakeVehicleMake() {
        $this->load->library('mongo_db');
        $id = $this->input->post('val');
        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('vehicleMake');

        echo json_encode(array('msg' => "Brand name deleted", 'flag' => 0));
        return;
    }

    function validateMake() {
        $this->load->library('mongo_db');


        $makename = $this->input->post('makename');
        // print_r($typename);
        $condition = array(
            "makeName.en" => new MongoDB\BSON\Regex('^' . $makename . '$', "i")
        );
        $data = $this->mongo_db->where($condition)->find_one('vehicleMake');

        $models = array();

        if (count($data) != 0) {
            echo json_encode(array('msg' => "Entered brand name is already exist, please try again with other brand name", 'flag' => 1));
            return;
        } else {
            echo json_encode(array('msg' => "Brand name inserted successfully", 'flag' => 0));
            return;
        }
    }

    function deleteVehicleModel() {
        $this->load->library('mongo_db');
        foreach ($this->input->post('id') as $id)
            $this->mongo_db->where(array('models._id' => new MongoDB\BSON\ObjectID($id)))->pull('models', array('_id' => new MongoDB\BSON\ObjectID($id)))->update('vehicleMake');

        // $result = $this->mongo_db->where(array('models._id' => new MongoDB\BSON\ObjectID($this->input->post('model_id'))))->set($modelData)->update('vehicleMake');
        echo json_encode(array('msg' => "Brand model deleted", 'flag' => 0));
        return;
    }

    function deleteVehicleMake() {
        $this->load->library('mongo_db');
        foreach ($this->input->post('val') as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('vehicleMake');
            $this->mongo_db->where(array('Makeid' => new MongoDB\BSON\ObjectID($id)))->delete('vehicleModel');
        }

        echo json_encode(array('msg' => "Brand name deleted", 'flag' => 0));
        return;
    }

    function getMakeData() {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id'))))->find_one('vehicleMake');
        // echo json_encode(array('data' => $getAll));
        return $res;
    }

    function addVehicleModel() {

        $this->load->library('mongo_db');
        $year = $this->input->post('country_select_year');
        $t = time();
        $modelName = $this->input->post('modalname');
        $modelId = new MongoDB\BSON\ObjectID();
        $modelData = array(
            'name' => $modelName,
            '_id' => $modelId,
            'year' => $year,
            'updatedOnModel' => $t
        );
        $condition = array(
            '_id' => new MongoDB\BSON\ObjectID($this->input->post('country_select')),
            "models" => array(
                '$elemMatch' => array(
                    "name.en" => new MongoDB\BSON\Regex('^' . $modelName['en'] . '$', "i"),
                    "year" => "2018"
                )
            )
        );
        $data = $this->mongo_db->where($condition)->find_one('vehicleMake');
        // print_r($data);die;

        if (count($data) > 0) {
            echo json_encode(array('msg' => "Entered Model name is already exist, please try again with other Model name", 'flag' => 1));
            return;
        } else {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('country_select'))))->push('models', $modelData)->update('vehicleMake');
            if ($result) {
                echo json_encode(array('msg' => "Brand name inserted successfully", 'flag' => 0));
                return;
            } else {
                echo json_encode(array('msg' => "Failed to insert", 'flag' => 1));
                return;
            }
        }
    }

    function editVehicleModel() {

        $this->load->library('mongo_db');
        $year = $this->input->post('country_select_year_e');
        $t = time();
        $modelName = $this->input->post('brandname_e_edit');
        $modelData = array(
            'models.$.name' => $modelName,
            'models.$.year' => $year,
            'models.$.updatedOnModel' => $t
        );
        $result = $this->mongo_db->where(array('models._id' => new MongoDB\BSON\ObjectID($this->input->post('model_id'))))->set($modelData)->update('vehicleMake');

        if ($result) {
            echo json_encode(array('msg' => "Brand model updated", 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => "Failed to insert", 'flag' => 1));
            return;
        }
    }

    function deletemakeVehicleModel() {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        $this->mongo_db->where(array('models._id' => new MongoDB\BSON\ObjectID($id)))->pull('models', array('_id' => new MongoDB\BSON\ObjectID($id)))->update('vehicleMake');

        echo json_encode(array('msg' => "Brand model deleted", 'flag' => 0));
        return;
    }

    function getfreelanceDrivers() {
        $this->load->library('mongo_db');
        $masters = $this->mongo_db->where(array('status' => array('$in' => [2, 3, 4, 5, 8, 9]), 'accountType' => 1))->get('masters');
        echo "<option value=''>Select</option>";
        foreach ($masters as $driver) {
            echo "<option value='" . $driver['_id']['$oid'] . "' driverMobile='" . $driver['phone']['phone'] . "' driverCountryCode='" . $driver['phone']['countryCode'] . "' driverName='" . trim($driver['firstName']) . ' ' . trim($driver['lastName']) . "'>" . trim($driver['firstName']) . ' ' . trim($driver['lastName']) . ' - ' . $driver['email'] . ' - ' . $driver['phone']['countryCode'] . $driver['phone']['phone'] . "</option>";
        }

        return;
    }

    function getCityVehicleType() {
        $this->load->library('mongo_db');
        $response = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('vehicleTypeID'))))->find_one('vehicleTypes');
        $cityDrivers = $this->mongo_db->where(array('cityId' => new MongoDB\BSON\ObjectID($this->input->post('cityId'))))->get('masters');
        echo json_encode(array('data' => $response['prices'], 'drivers' => $cityDrivers));
        return;
    }

    function getCityDrivers() {
        $this->load->library('mongo_db');
        
        $cityDrivers = $this->mongo_db->where(array('cityId' => ($this->input->post('cityId')), 'status' => array('$in' => [2, 3, 4, 8, 9])))->
        select(array('firstName'=>'firstName','lastName'=>'lastName','email'=>'email','mobile'=>'mobile','countryCode'=>'countryCode'))->get('driver');
        
        $cityVehicleTypes = $this->mongo_db->where(array('prices' => array('$elemMatch' => array('cityId' => $this->input->post('cityId'), '$or' => array(array('ride.isEnabled' => false),
         array('delivery.isEnabled' => false),
         array('towtruck.isEnabled' => false))))))->get('vehicleTypes');
        echo json_encode(array('drivers' => $cityDrivers, 'vehicleTypes' => $cityVehicleTypes));
        return;
    }

    function licenceplaetno() {
        $this->load->library('mongo_db');

        $licenceplaetno = $this->input->post('licenceplaetno');
        $query = $this->mongo_db->where(array('plateNo' => $licenceplaetno))->count('vehicles');

        if ($query > 0) {
            echo json_encode(array('msg' => '1'));
            return;
        } else {
            echo json_encode(array('msg' => '0'));
            return;
        }
    }

    function validatePlateNumber() {
        $this->load->library('mongo_db');
        $query = $this->mongo_db->where(array('status' => array('$nin' => [6]), '$or' => array(array('plateNo' => $this->input->post('plateNum')), array('plateNoActual' => strtoupper(preg_replace("/[^a-zA-Z0-9]+/", "", $this->input->post('plateNum')))))))->find_one('vehicles');
        if (!empty($query)) {
            echo json_encode(array('msg' => FALSE));
            return;
        } else {
            echo json_encode(array('msg' => TRUE));
        }
    }

    //Generate Random String 
    function generateRandomString($length) {
        return strtoupper(substr(str_shuffle(str_repeat($x = '012345678987654321', ceil($length / strlen($x)))), 1, $length));
    }

    function checkVehicleIDExist($vehicleID, $randNum) {
        $this->load->library('mongo_db');
        $result = $this->mongo_db->where(array('vehicleId' => $randNum))->find_one('vehicles');
        if (!empty($result)) {
            $randNum = $vehicleID . $this->generateRandomString(5);
            return $this->checkVehicleIDExist($vehicleID, $randNum);
        } else
            return $randNum;
    }

    function AddNewVehicleData() {
        $this->load->library('mongo_db');
        $OwnershipType = $this->input->post('OwnershipType');
        $goodType = $this->input->post('goodType');
        $selected_driver = $this->input->post('selected_driver');
        $driverName = $this->input->post('driverName');
        $driverMobile = $this->input->post('driverMobile');
        $driverCountryCode = $this->input->post('driverCountryCode');

        $vechileregno = $this->input->post('vechileregno');

        $licenceplaetno = $this->input->post('licenceplaetno');
        $type_id = $this->input->post('getvechiletype');
        $vehicleTypeName = $this->input->post('vehicleTypeName');
        $expirationrc = $this->input->post('expirationrc');
        $Vehicle_Insurance_No = $this->input->post('Vehicle_Insurance_No');


        $makes = $this->input->post('car-makes');
        $models = $this->input->post('car-models');
        $years = $this->input->post('car-years');

        //Images
        $image_name = $this->input->post('vehicleImage');
        $registationCertificate = $this->input->post('registationCertificate');
        $motorCertificate = $this->input->post('motorCertificate');
        $inspectionReport = $this->input->post('inspection_report');

        $expirationinsurance = $this->input->post('expirationinsurance');
        $expirationinspection = $this->input->post('inspectiondate');

        $goodsInTransitImg = $this->input->post('goodsInTransit-img');
        $goodsInTransitExpireDate = $this->input->post('goodsInTransitExpireDate');

        $companyname = $this->input->post('company_select');
        $operatorName = $this->input->post('operatorName');
        $year = $this->input->post('year');

        $vehicleTypesData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($type_id)))->find_one('vehicleTypes');

        $vehicleID = strtoupper(substr($vehicleTypesData['typeName']['en'], 0, 2));
        $randNum = $vehicleID . $this->generateRandomString(5);
        $uniqueId = strtolower($this->checkVehicleIDExist($vehicleID, $randNum));


        foreach ($vehicleTypesData['prices'] as $prices) {
            if ($prices['cityId'] == $this->input->post('city')) {
                if (in_array($prices['ride']['_id']['$oid'], $this->input->post('businessType'))) {
                    $isMeterBooking = (isset($prices['ride']['isMeterBookingEnable'])) ? $prices['ride']['isMeterBookingEnable'] : FALSE;
                    $services[] = array('serviceName' => 'Ride', 'isMeterBookingEnable' => $isMeterBooking, 'serviceType' => 2, 'serviceId' => $prices['ride']['_id']['$oid']);
                }
                if (in_array($prices['delivery']['_id']['$oid'], $this->input->post('businessType'))) {

                    $isMeterBooking = (isset($prices['delivery']['isMeterBookingEnable'])) ? $prices['delivery']['isMeterBookingEnable'] : FALSE;
                    $services[] = array('serviceName' => 'Delivery', 'isMeterBookingEnable' => $isMeterBooking, 'serviceType' => 1, 'serviceId' => $prices['delivery']['_id']['$oid']);
                }
                if (isset($prices['towtruck']) && in_array($prices['towtruck']['_id']['$oid'], $this->input->post('businessType'))) {

                    $isMeterBooking = (isset($prices['towtruck']['isMeterBookingEnable'])) ? $prices['towtruck']['isMeterBookingEnable'] : FALSE;
                    $services[] = array('serviceName' => 'TowTruck', 'isMeterBookingEnable' => $isMeterBooking, 'serviceType' => 2, 'serviceId' => $prices['towtruck']['_id']['$oid']);
                }
            }
        }

        $cityDetails = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('city'))))->find_one('cities');

        if ($OwnershipType == 1)
            $insertArr = array('cityId' => new MongoDB\BSON\ObjectID($this->input->post('city')), 'cityName' => $cityDetails['city'], 'services' => $services, 'vehicleId' => $uniqueId, 'status' => 1, 'statusText' => unserialize(vehicleStatusText)[1], 'modelId' => new MongoDB\BSON\ObjectID($models), 'model' => $this->input->post('vehicleModelName'), 'makeId' => new MongoDB\BSON\ObjectID($makes), 'make' => $this->input->post('vehicleMakeName'), 'year' => $years, 'colour' => $this->input->post('color'), 'plateNo' => $licenceplaetno, 'plateNoActual' => strtoupper(preg_replace("/[^a-zA-Z0-9]+/", "", $licenceplaetno)), 'goodTypes' => (empty($goodType)) ? array() : $goodType, 'accountType' => (int) $OwnershipType, 'acountTypeText' => unserialize(driverAccountTypes)[$OwnershipType], 'operatorId' => "", 'operatorName' => '', 'masterId' => new MongoDB\BSON\ObjectID($selected_driver), 'typeId' => new MongoDB\BSON\ObjectID($type_id), 'typeName' => $vehicleTypesData['typeName'], 'vehicleImage' => $image_name, 'registrationCertExpiry' => $this->mongo_db->date(strtotime($expirationrc) * 1000), 'motorInsuImageDate' => $this->mongo_db->date(strtotime($expirationinsurance) * 1000), 'registrationCertImage' => $registationCertificate, 'motorInsuImage' => $motorCertificate, 'inspectionReport' => $inspectionReport, 'goodsInTransit' => $goodsInTransitImg);
        else
            $insertArr = array('cityId' => new MongoDB\BSON\ObjectID($this->input->post('city')), 'cityName' => $cityDetails['city'], 'services' => $services, 'vehicleId' => $uniqueId, 'status' => 1, 'statusText' => unserialize(vehicleStatusText)[1], 'modelId' => new MongoDB\BSON\ObjectID($models), 'model' => $this->input->post('vehicleModelName'), 'makeId' => new MongoDB\BSON\ObjectID($makes), 'make' => $this->input->post('vehicleMakeName'), 'year' => $years, 'colour' => $this->input->post('color'), 'plateNo' => $licenceplaetno, 'plateNoActual' => strtoupper(preg_replace("/[^a-zA-Z0-9]+/", "", $licenceplaetno)), 'goodTypes' => (empty($goodType)) ? array() : $goodType, 'accountType' => (int) $OwnershipType, 'acountTypeText' => unserialize(driverAccountTypes)[$OwnershipType], 'operatorId' => new MongoDB\BSON\ObjectID($companyname), 'operatorName' => $this->input->post('operatorName'), 'masterId' => '', 'typeId' => new MongoDB\BSON\ObjectID($type_id), 'typeName' => $vehicleTypesData['typeName'], 'vehicleImage' => $image_name, 'registrationCertExpiry' => $this->mongo_db->date(strtotime($expirationrc) * 1000), 'motorInsuImageDate' => $this->mongo_db->date(strtotime($expirationinsurance) * 1000), 'registrationCertImage' => $registationCertificate, 'motorInsuImage' => $motorCertificate, 'inspectionReport' => $inspectionReport, 'goodsInTransit' => $goodsInTransitImg);


        if ($expirationinspection)
            $insertArr['inspectionReportDate'] = $this->mongo_db->date(strtotime($expirationinspection) * 1000);
        else
            $insertArr['inspectionReportDate'] = '';
        if ($goodsInTransitExpireDate)
            $insertArr['goodsInTransitDate'] = $this->mongo_db->date(strtotime($goodsInTransitExpireDate) * 1000);
        else
            $insertArr['goodsInTransitDate'] = '';

        $insertArr['vehiclePreference'] = [];
        if (isset($_POST['preference']) && count($_POST['preference']) > 0)
            $insertArr['vehiclePreference'] = $_POST['preference'];


//        if ($_POST['wheelChairSupport'] == 'on')
//            $insertArr['wheelChairSupport'] = TRUE;
//        else
        $insertArr['wheelChairSupport'] = FALSE;


//        if ($_POST['boosterSeatSupport'] == 'on')
//            $insertArr['boosterSeatSupport'] = TRUE;
//        else
        $insertArr['boosterSeatSupport'] = FALSE;

//        if ($_POST['extraBagSupport'] == 'on')
//            $insertArr['extraBagSupport'] = TRUE;
//        else
        $insertArr['extraBagSupport'] = FALSE;

        $_id = $this->mongo_db->insert('vehicles', $insertArr);

//        if ($OwnershipType == 1)
//            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($selected_driver)))->set(array('plateNo' => $licenceplaetno, 'vehicleTypeName' => $this->input->post('vehicleTypeName'), 'type' => new MongoDB\BSON\ObjectID($type_id)))->update('masters');

        return $selected_driver;
    }

    function editvehicle($status) {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($status)))->find_one('vehicles');
        return $data;
    }

    function getModel($id) {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('vehicleModel');
        return $data;
    }

    function getDriverList($id) {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('cityId' => new MongoDB\BSON\ObjectID($id)))->get('masters');
        return $data;
    }

    function getAllGoodTypes() {
        $this->load->library('mongo_db');
        $allGoodTypes = $this->mongo_db->get('masterSpecialities');
        return $allGoodTypes;
    }

    function editNewVehicleData($id) {

        $this->load->library('mongo_db');
        $OwnershipType = $this->input->post('OwnershipType');
        $goodType = $this->input->post('goodType');
        $selected_driver = $this->input->post('selected_driver');
        $driverName = $this->input->post('driverName');
        $driverMobile = $this->input->post('driverMobile');
        $driverCountryCode = $this->input->post('driverCountryCode');

        $makes = $this->input->post('car-makes');
        $models = $this->input->post('car-models');
        $years = $this->input->post('car-years');
//        $title = $this->input->post('title');
//        $vehiclemodel = $this->input->post('vehiclemodel');
        $vechileregno = $this->input->post('vechileregno');
        $licenceplaetno = $this->input->post('licenceplaetno');
        $type_id = $this->input->post('getvechiletype');
        $Vehicle_Insurance_No = $this->input->post('Vehicle_Insurance_No');
        $vehicleTypeName = $this->input->post('vehicleTypeName');
        $expirationrc = $this->input->post('expirationrc');

//Images
        $image_name = $this->input->post('vehicleImage');
        $registationCertificate = $this->input->post('registationCertificate');
        $motorCertificate = $this->input->post('motorCertificate');
        $inspectionReport = $this->input->post('PermitCertificate');

        $expirationinsurance = $this->input->post('expirationinsurance');
        $expirationinspection = $this->input->post('inspectiondate');

        $companyname = $this->input->post('company_id');
        $operatorName = $this->input->post('operatorName');
        $year = $this->input->post('year');

        $vehicleTypesData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($type_id)))->find_one('vehicleTypes');

        foreach ($vehicleTypesData['prices'] as $prices) {
            if ($prices['cityId'] == $this->input->post('city')) {
                if (in_array($prices['ride']['_id']['$oid'], $this->input->post('businessType'))) {
                    $isMeterBooking = (isset($prices['ride']['isMeterBookingEnable'])) ? $prices['ride']['isMeterBookingEnable'] : FALSE;
                    $services[] = array('serviceName' => 'Ride', 'isMeterBookingEnable' => $isMeterBooking, 'serviceType' => 2, 'serviceId' => $prices['ride']['_id']['$oid']);
                }
                if (in_array($prices['delivery']['_id']['$oid'], $this->input->post('businessType'))) {

                    $isMeterBooking = (isset($prices['delivery']['isMeterBookingEnable'])) ? $prices['delivery']['isMeterBookingEnable'] : FALSE;
                    $services[] = array('serviceName' => 'Delivery', 'isMeterBookingEnable' => $isMeterBooking, 'serviceType' => 1, 'serviceId' => $prices['delivery']['_id']['$oid']);
                }
                if (isset($prices['towtruck']) && in_array($prices['towtruck']['_id']['$oid'], $this->input->post('businessType'))) {

                    $isMeterBooking = (isset($prices['towtruck']['isMeterBookingEnable'])) ? $prices['towtruck']['isMeterBookingEnable'] : FALSE;
                    $services[] = array('serviceName' => 'TowTruck', 'isMeterBookingEnable' => $isMeterBooking, 'serviceType' => 2, 'serviceId' => $prices['towtruck']['_id']['$oid']);
                }
            }
        }

        $cityDetails = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('city'))))->find_one('cities');


        if ($OwnershipType == 1)
            $fdata = array('cityId' => new MongoDB\BSON\ObjectID($this->input->post('city')), 'cityName' => $cityDetails['city'], 'services' => $services, 'operator' => '', 'operatorName' => '', 'modelId' => new MongoDB\BSON\ObjectID($models), 'model' => $this->input->post('vehicleModelName'), 'makeId' => new MongoDB\BSON\ObjectID($makes), 'make' => $this->input->post('vehicleMakeName'), 'year' => $years, 'colour' => $this->input->post('color'), 'plateNo' => $licenceplaetno, 'goodTypes' => $goodType, 'accountType' => (int) $OwnershipType, 'typeId' => new MongoDB\BSON\ObjectID($type_id), 'typeName' => $vehicleTypesData['typeName'], 'masterId' => new MongoDB\BSON\ObjectID($selected_driver), 'registrationCertExpiry' => $this->mongo_db->date(strtotime($expirationrc) * 1000), 'motorInsuImageDate' => $this->mongo_db->date(strtotime($expirationinsurance) * 1000), 'inspectionReportDate' => $this->mongo_db->date(strtotime($expirationinspection) * 1000));
        else
            $fdata = array('cityId' => new MongoDB\BSON\ObjectID($this->input->post('city')), 'cityName' => $cityDetails['city'], 'services' => $services, 'operator' => new MongoDB\BSON\ObjectID($companyname), 'operatorName' => $this->input->post('operatorName'), 'modelId' => new MongoDB\BSON\ObjectID($models), 'model' => $this->input->post('vehicleModelName'), 'makeId' => new MongoDB\BSON\ObjectID($makes), 'make' => $this->input->post('vehicleMakeName'), 'year' => $years, 'colour' => $this->input->post('color'), 'plateNo' => $licenceplaetno, 'goodTypes' => $goodType, 'accountType' => (int) $OwnershipType, 'typeId' => new MongoDB\BSON\ObjectID($type_id), 'typeName' => $vehicleTypesData['typeName'], 'masterId' => '', 'registrationCertExpiry' => $this->mongo_db->date(strtotime($expirationrc) * 1000), 'motorInsuImageDate' => $this->mongo_db->date(strtotime($expirationinsurance) * 1000), 'inspectionReportDate' => $this->mongo_db->date(strtotime($expirationinspection) * 1000),);

        if ($image_name)
            $fdata['vehicleImage'] = $image_name;
        if ($registationCertificate)
            $fdata['registrationCertImage'] = $registationCertificate;
        if ($motorCertificate)
            $fdata['motorInsuImage'] = $motorCertificate;
        if ($inspectionReport)
            $fdata['inspectionReport'] = $inspectionReport;
        if ($this->input->post('goodsInTransit-img'))
            $fdata['goodsInTransit'] = $this->input->post('goodsInTransit-img');


        //Date
        if ($this->input->post('inspectiondate'))
            $fdata['inspectionReportDate'] = $this->mongo_db->date(strtotime($this->input->post('inspectiondate')) * 1000);
        else
            $fdata['inspectionReportDate'] = '';

        if ($this->input->post('goodsInTransitExpireDate'))
            $fdata['goodsInTransitDate'] = $this->mongo_db->date(strtotime($this->input->post('goodsInTransitExpireDate')) * 1000);
        else
            $fdata['goodsInTransitDate'] = '';

        $fdata['vehiclePreference'] = [];
        if (isset($_POST['preference']) && count($_POST['preference']) > 0) {
            $fdata['vehiclePreference'] = $_POST['preference'];
            $masterData = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($selected_driver)))->find_one("masters");
            if (isset($masterData['bookingPreference']))
                $preferenceData['bookingPreference'] = array_merge($fdata['vehiclePreference'], $masterData['driverPreference']);
            else
                $preferenceData['bookingPreference'] = $fdata['vehiclePreference'];

            $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($selected_driver)))->set($preferenceData)->update("masters");
        }




//        if ($_POST['wheelChairSupport'] == 'on') {
//            $fdata['wheelChairSupport'] = TRUE;
//            $driverData = array('vehicleDetail.wheelChairSupport' => TRUE);
//        } else {
////            $driverData['vehicleDetail']['wheelChairSupport'] = FALSE;
//            $driverData = array('vehicleDetail.wheelChairSupport' => FALSE);
//            $fdata['wheelChairSupport'] = FALSE;
//        }
//
//
//        if ($_POST['boosterSeatSupport'] == 'on') {
//            $fdata['boosterSeatSupport'] = TRUE;
////            $driverData['vehicleDetail']['boosterSeatSupport'] = TRUE;
//            $driverData = array_merge($driverData, array('vehicleDetail.boosterSeatSupport' => TRUE));
//        } else {
//            $fdata['boosterSeatSupport'] = FALSE;
////            $driverData['vehicleDetail']['boosterSeatSupport'] = FALSE;
//            $driverData = array_merge($driverData, array('vehicleDetail.boosterSeatSupport' => FALSE));
//        }
//
//        if ($_POST['extraBagSupport'] == 'on') {
//            $fdata['extraBagSupport'] = TRUE;
////            $driverData['vehicleDetail']['extraBagSupport'] = TRUE;
//            $driverData = array_merge($driverData, array('vehicleDetail.extraBagSupport' => TRUE));
//        } else {
//            $fdata['extraBagSupport'] = FALSE;
////            $driverData['vehicleDetail']['extraBagSupport'] = FALSE;
//            $driverData = array_merge($driverData, array('vehicleDetail.extraBagSupport' => FALSE));
//        }

        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($fdata)->update("vehicles");
//        if ($selected_driver)
//            $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($selected_driver)))->set($driverData)->update("masters");


        return $selected_driver;
    }

//    function getCarAPIInfo() {
//
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://www.carqueryapi.com/api/0.3/?callback=?&cmd=getYears",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "GET",
//            CURLOPT_POSTFIELDS => "",
//            CURLOPT_HTTPHEADER => array(
//                "Cache-Control: no-cache",
//                "Content-Type: application/json",
//                "Postman-Token: fb12b89c-04d2-5fe1-0388-ebb61f4ee8b9"
//            ),
//        ));
//
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//
//        curl_close($curl);
//
//        if ($err) {
//             return "cURL Error #:" . $err;
//        } else {
//            return $response;
//        }
//
//    }

    function activate_vehicle() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        foreach ($val as $id) {
            $vehicle = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('vehicles');
            $driver = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($vehicle['masterId']['$oid']), 'status' => array('$ne' => 1)))->find_one('masters');

            if (!empty($driver))
                $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 2, 'statusText' => unserialize(vehicleStatusText)[2],))->update('vehicles');
        }
        if ($result) {
            echo json_encode(array('msg' => "Selected vehicle/vehicles activated succesfully", 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => "Please activate the driver first", 'flag' => 1));
            return;
        }
    }

    function checkDriverIsOnTrip() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        $type = $this->input->post('type');
        $result = 0;
        foreach ($val as $id) {
            if ($type == 'vehicleType')
                $result += $this->mongo_db->where(array('type' => new MongoDB\BSON\ObjectID($id), 'busyInRide' => TRUE))->count('masters');
            else
                $result += $this->mongo_db->where(array('vehicleId' => new MongoDB\BSON\ObjectID($id), 'busyInRide' => TRUE))->count('masters');
        }

        echo json_encode(array('msg' => "These driver are in trip", 'driverOnTrip' => $result));
        return;
    }

    function reject_vehicle() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        foreach ($val as $id) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 3, 'statusText' => unserialize(vehicleStatusText)[3],))->update('vehicles');
        }
        if ($result) {
            echo json_encode(array('msg' => "Selected Vehicle rejected Successfully", 'flag' => 1, 'res' => $res));
            return;
        }
    }

    function getVehicleDocuments() {
        $this->load->library('mongo_db');
        $vehicleData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("val"))))->get('vehicles');
        echo json_encode(array('data' => $vehicleData));
        return;
    }

    function deleteVehicles() {
        $this->load->library('mongo_db');
        $ids = $this->input->post('val');

        foreach ($ids as $id)
//            $vehicleModel = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('vehicles');
            $vehicleModel = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 6, 'statusText' => "Deleted"))->update('vehicles');

        if ($vehicleModel) {
            echo json_encode(array('msg' => "Updated  succesfully", 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => "Deletion failed...", 'flag' => 1));
            return;
        }
    }

    function getVehicleYear() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $condition = array(
            array(
                '$unwind' => '$models'
            ),
            array(
                '$group' => array(
                    '_id' => '$models.year'
                )
            ),
            array(
                '$sort' => array(
                    '_id' => -1
                )
            )
        );
        $vehicleYearData = $this->mongo_db->aggregate('vehicleMake', $condition);

        $arr = [];
        foreach ($vehicleYearData as $doc) {
            $arr[] = $doc;
        }
        $year = [];
        foreach ($arr as $key => $value) {
            $year[$value->_id] = $value->_id;
        }
        return $year;
    }

    function datatable_vehicleMake() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['mDataProp_0'] = "makeName.en";
        $i = 1;
        $language = $this->mongo_db->where(array('active' => 1))->get('languages');
        foreach ($language as $lang) {
            $_POST['mDataProp_' . $i] = "makeName." . $lang['code'];
            $i += 1;
        }
        $_POST['iColumns'] = $i;

        $respo = $this->datatables->datatable_mongodb('vehicleMake');

        $aaData = $respo["aaData"];
        $datatosend = array();
        $slno = $_POST['iDisplayStart'];
        foreach ($aaData as $value) {

            $arr = array();
            $arr[] = ++$slno;
            $arr[] = '<a class="vehicleMake"  style="cursor: pointer" data-id="' . $value['_id']['$oid'] . '">' . $value['makeName']['en'] . '</a>';
            $arr[] = '<button class="btn btn-info edit-button btn-cons cls111" id="editMakeData" data="' . $value['_id']['$oid'] . '" title="Edit"><i class="fa fa-edit"></i></button><button class="btn btn-danger btn-cons cls111" id="deleteMakeData" data="' . $value['_id']['$oid'] . '" title="Delete"><i class="fa fa-trash"></i></button>';
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '">';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_vehicleModel() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "models.name.en";

        // $vehicleModelData = $this->mongo_db->get('vehicleMake');
        $condition = array(
            array(
                '$unwind' => '$models'
            ),
            array(
                '$sort' => array(
                    'models.updatedOnModel' => -1
                )
            )
        );



//            '$sort' => array(
//                    'models.updatedOnModel' => -1
//                )
//            )
//        $vehicleModelData = $this->datatables->datatable_mongodbAggregate('vehicleMake', $condition);
        // $vehicleModelData = $this->datatables->datatable_mongodbAggregateNew('vehicleMake', $condition);
        $vehicleModelData = $this->datatables->datatable_mongodbAggregate('vehicleMake', $condition);
//         echo "<pre>";
//            print_r($vehicleModelData);
//            die;

        $slno = $_POST['iDisplayStart'];
        $arr = array();
        foreach ($vehicleModelData['aaData'] as $each) {
            $arr[] = array(
                ++$slno,
                '<a class="vehicleMake"  style="cursor: pointer" data-id="' . $each->_id . '">' . $each->makeName->en . '</a>',
                '<a class="vehicleModel"  style="cursor: pointer" data-id="' . $each->models->_id . '">' . $each->models->name->en . '</a>',
                $each->models->year,
                '<button class="btn btn-info edit-button btn-cons cls111" id="editModelData" data="' . $each->models->_id . '" data-make="' . $each->_id . '" title="Edit"><i class="fa fa-edit"></i></button><button class="btn btn-danger btn-cons cls111" id="deleteModelData" data="' . $each->models->_id . '" data-make="' . $each->_id . '" title="Delete"><i class="fa fa-trash"></i></button>',
                '<input type="checkbox" class="checkbox" name="checkbox" value="' . $each->models->_id . '" data="' . $each->_id . '">'
            );
        }

        $vehicleModelData['aaData'] = $arr;
        echo json_encode($vehicleModelData);
//        echo $vehicleModelData;
    }

    function getMakeDetails() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->get_where('vehicleMake', array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id'))));
        echo json_encode(array('data' => $getAll));
        return;
    }

}

?>
