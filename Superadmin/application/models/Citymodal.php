<?php
if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Citymodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');

        $this->unitArr = array(
            'KM' => 1000,
            'Miles' => 1603.03,
            'Yards' => 1.09
        );
    }

    function datatable_cities() {
        $this->load->library('mongo_db');
        error_reporting(false);
        $this->load->library('Datatables');

        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "cities.cityName";
        $_POST['mDataProp_1'] = "cities.state";
        $_POST['mDataProp_2'] = "country";
        $_POST['mDataProp_3'] = "cities.currency";
       // $_POST['mDataProp_4'] = "distanceMetrics";

    //    $respo = $this->datatables->datatable_mongodbCities('cities', array(), '', -1);
       $respo = $this->datatables->datatable_mongodbAggregate('cities', array(array('$unwind' => '$cities'),
       array('$match'=>array('cities.isDeleted'=>FALSE)),
       array('$project'=>array("country"=>1,"cities.cityId"=>1,"cities.cityName"=>1,"cities.state"=>1,"cities.currency"=>1,"cities.currencySymbol"=>1,"cities.weightMetricText"=>1,"cities.mileageMetric"=>1,"cities.paymentMethods"=>1,"cities.isDeleted"=>1)),
        array('$sort'=>array('cities.cityId'=> -1))
    ),

    array(array('$unwind' => '$cities'),array('$match'=>array('cities.isDeleted'=>FALSE)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1))))


);
        
        $datatosend = array(); 

        foreach ($respo["aaData"] as $val) {
           $myId=((string)$val->cities->cityId);
           $val->cities->cityId = (string)$val->cities->cityId;
            $val = json_decode(json_encode($val),TRUE);
            $result = $val['cities'];
            $paymentGateways = '';
            $paymentGateways = rtrim($paymentGateways, ',');

            // foreach ($val['cities'] as $result) {
                if ($result['isDeleted'] == FALSE) {
                    $arr = array();
                    if ($result['mileageMetric'] == "0") {
                        $metric = "KM";
                    } else {
                        $metric = "Miles";
                    }
                    //$arr[] = (string)$result['cityId']['$oid'];
                    $arr[] = $result['cityName'];
                    $arr[] = ($result['state'] == null || $result['state'] == '') ? "N/A" : $result['state'];
                    $arr[] = $val['country'];
                    $arr[] = $result['currency'];
                    $arr[] = $result['currencySymbol'];
                    $arr[] = $metric;
                    $arr[] = ($result['paymentMethods'] == '' || $result['paymentMethods'] == null || !isset($result['paymentMethods'])) ? "N/A" : implode(",   ", $result['paymentMethods']);
                    // $arr[] = '<a class="cityAreaName textDec" id="' . $result['cityId'] . '" style="cursor:pointer;">View</a>';
                    // $arr[] = "<a href = '".base_url()."index.php?/Packaging_Controller/index/".$result['cityId'] ."' class='btn btn-success' style='text-decoration:none;'>Add</a> ";
                    // $arr[] = "<a href = '".base_url()."index.php?/Pricing_Controller/index/".$result['cityId'] ."' class='btn btn-success' style='text-decoration:none;'>Set</a> ";
                    $arr[] = "<a class='btn btn-primary  cls111 editBtn' style='width:35px;' href='" . base_url('index.php?/city') . "/editCity/" . $result['cityId'] . "'> 
                    <i class='fa fa-edit'></i> 
               </a> <a class='btn btn-danger  cls111 deleteCity' style='width:35px;' data-id='" . $result['cityId'] . "'>
                    <i class='fa fa-trash'></i>
                </a> 
               ";

            //    <a class='btn btn-primary  cls111 laundryPopUp' style='width:35px;' data-currencySymbol='".$result['currencySymbol']."' data-weightMetricText='".$result['weightMetricText']."' data-id='" . $result['cityId'] . "'><i class='fa fa-truck' aria-hidden='true'></i></a>
                    $datatosend[] = $arr;
                // }
            }
        }
  
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function getCityList() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');

        $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->find_one('cities');

        $entities = array();
        $entities = '<option value="">Select City</option>';
        foreach ($cursor['cities'] as $dat) {
            $entities .= '<option data-name="' . $dat['cityName'] . '" value="' . $dat['cityId']['$oid'] . '">' . $dat['cityName'] . ', ' . $dat['state'] . '</option>';
        }

        echo $entities;
    }

    public function getAllCityList() {
        $this->load->library('mongo_db');


        $cursor1 = $this->mongo_db->get('cities');

        $entities = array();
        $entities = '<option value="">Select City</option>';
        foreach ($cursor1 as $cursor) {
            foreach ($cursor['cities'] as $dat) {
                $entities .= '<option data-name="' . $dat['cityName'] . '" value="' . $dat['cityId']['$oid'] . '">' . $dat['cityName'] . ', ' . $dat['state'] . ', ' . $cursor['country'] . '</option>';
            }
        }

        echo $entities;
    }

    function del_city() {
        $this->load->library('mongo_db');
        $id = $this->input->post('del_id');

        $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($id)))->set(array('cities.$.isDeleted' => TRUE))->update('cities');
        $data['cityId']=$id;
		    $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, APILink . 'admin/city');
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        // $result = curl_exec($ch);
        // curl_close($ch);
        curl_setopt($ch, CURLOPT_URL, APILink . 'city/' . $data);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        curl_close($ch);
        return array("error" => 0, "msg" => "Deleted.");
    }

    //If the city is already exists and it was marked as deleted then reactivate it again
    public function checkCityExists() {
        $this->load->library('mongo_db');
        $result = $this->mongo_db->where(array("cities.cityName" => (string) $this->input->post('city')))->set(array('cities.$.isDeleted' => FALSE))->update('cities');

        if ($result)
            $result = 0;
        else
            $result = 1;

        echo json_encode(array('flag' => $result));
    }

    function getCitydata($param = '') {
        $this->load->library('mongo_db');
        if ($param == '') {
//            $data = $this->mongo_db->get('cities');
            $reponse = $this->mongo_db->aggregate('cities',array(array('$unwind'=>'$cities')));
            foreach ($reponse as $r)
                $data1[] = json_decode(json_encode ($r),true);
        } else {
            $data = $this->mongo_db->where(array("cities.cityId" => new MongoDB\BSON\ObjectID($param)))->find_one('cities');

            foreach ($data['cities'] as $city) {

                if ($param == $city['cityId']['$oid']) {
//                    echo "<pre>";
//            print_r($city);die;
                    $data1 = array();
                    $data1['country'] = $data['country'];
                    $data1['id'] = $data['_id']['$oid'];
                    $data1['abbrevation'] = $city['abbrevation'];
                    $data1['abbrevationText'] = $city['abbrevationText'];
                    $data1['state'] = $city['state'];
                    $data1['tax'] = $city['tax'];
                    $data1['paymentDetails'] = $city['paymentDetails'];
                    $data1['taxDetails'] = $city['taxDetails'];
                    $data1['cityName'] = $city['cityName'];
                    $data1['cityId'] = $city['cityId']['$oid'];
                    $data1['currency'] = $city['currency'];
                    $data1['currencySymbol'] = $city['currencySymbol'];
                    $data1['isDeleted'] = $city['isDeleted'];
                    $data1['mileageMetric'] = $city['mileageMetric'];
                    $data1['mileageMetricText'] = $city['mileageMetricText'];
                    $data1['weightMetricText'] = $city['weightMetricText'];
                    $data1['weightMetric'] = $city['weightMetric'];
                    $data1['paymentMethods'] = $city['paymentMethods'];
                    $data1['coordinates']['longitude'] = $city['coordinates']['longitude'];
                    $data1['coordinates']['latitude'] = $city['coordinates']['latitude'];
                    $data1['laundry']['lowerWeightLimit'] = $city['laundry']['lowerWeightLimit'];
                    $data1['laundry']['upperWeightLimit'] = $city['laundry']['upperWeightLimit'];
                    $data1['laundry']['Price'] = $city['laundry']['Price'];
                    $data1['laundry']['extraFeeForExpressDelivery'] = $city['laundry']['extraFeeForExpressDelivery'];
                    $data1['laundry']['taxesApplicable'] = $city['laundry']['taxesApplicable'];
                    $data1['baseFare'] = $city['baseFare'];
                    $data1['mileagePrice'] = $city['mileagePrice'];
                    $data1['timeFee'] = $city['timeFee'];
                    $data1['waitingFee'] = $city['waitingFee'];
                    $data1['minimumFare'] = $city['minimumFare'];
                    $data1['onDemandBookingsCancellationFee'] = $city['onDemandBookingsCancellationFee'];
                    $data1['scheduledBookingsCancellationFee'] = $city['scheduledBookingsCancellationFee'];
                    $data1['onDemandBookingsCancellationFeeAfterMinutes'] = $city['onDemandBookingsCancellationFeeAfterMinutes'];
                    $data1['scheduledBookingsCancellationFeeBeforeMinutes'] = $city['scheduledBookingsCancellationFeeBeforeMinutes'];
                    $data1['mileagePriceAfterDistance'] = $city['mileagePriceAfterDistance'];
                    $data1['timeFeeAfterMinutes'] = $city['timeFeeAfterMinutes'];
                    $data1['waitingFeeAfterMinutes'] = $city['waitingFeeAfterMinutes'];
                    $data1['convenienceFee'] = $city['convenienceFee'];
                    $data1['convenienceType'] = $city['convenienceType'];
                    $data1['temperature'] = $city['temperature'];
                    $data1['height'] = $city['height'];
                    $data1['width'] = $city['width'];
                    $data1['length'] = $city['length'];
                    $data1['polygonProps'] = $city['polygonProps'];
                    $data1['polygons'] = $city['polygons'];
                    $data1['driverWalletLimits']['softLimitForDriver'] = $city['driverWalletLimits']['softLimitForDriver'];
                    $data1['driverWalletLimits']['hardLimitForDriver'] = $city['driverWalletLimits']['hardLimitForDriver'];
                    $data1['customerWalletLimits']['softLimitForCustomer'] = $city['customerWalletLimits']['softLimitForCustomer'];
                    $data1['customerWalletLimits']['hardLimitForCustomer'] = $city['customerWalletLimits']['hardLimitForCustomer'];

                    $data1['typeOfAccount'] = $city['typeOfAccount'];
                    $data1['isIdeal'] = $city['isIdeal'];
                    $data1['isStripeEnabled'] = $city['isStripeEnabled'];

                }
            }
        }
        
        return $data1;
    }

    public function getCityListWallet() {
       
        $cursor1 = $this->mongo_db->get('cities');
        $res = array();
        foreach($cursor1 as $cursor){
        foreach ($cursor['cities'] as $d) {

            $res[] = $d;
        }
    }
        return $res;
       
    }
    //Check the city is deleted
       function checkCityDeleted() {
        $this->load->library('mongo_db');
        $result = $this->mongo_db->where(array('cities'=>array('$elemMatch'=>array("cityName" => $this->input->post('city'), 'isDeleted' => TRUE))))->find_one('cities');
        if ($result)
            echo json_encode(array('data' => $result, 'errorFlag' => TRUE));
        else
            echo json_encode(array('data' => $result, 'errorFlag' => FALSE));
        return;
    }

    function getpaymentGateways() {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('isDeleted' => FALSE))->get('paymentGateway');
        return $data;
    }

    function getTax() {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('status'=>1))->get('taxes');
        return $data;
    }

    function city_create() {
        $this->load->library('mongo_db');
        $fdata = $this->input->post('fdata');
        // echo '<pre>';  print_r($fdata);die;
        $payment = array();
        $payment1 = array();
        $paymentId = array();
        $taxData = array();
        $taxDataDetails = array();
        $paymentDetails = array();
        $dataTaxes = array();
        $dataTaxId = array();
        $lang = $this->mongo_db->get('lang_hlp');
        $lanCodeArr = [];
        $lanIdArr = [];
        foreach ($lang as $lan) {
            $lanCodeArr[0] = "en";
            $lanIdArr[0] = "0";
            array_push($lanCodeArr, $lan['langCode']);
            array_push($lanIdArr, $lan['lan_id']);
        }

        foreach ($fdata['taxes'] as $resultTax) {
            $dataTax = explode("_", $resultTax);
            $dataTaxes[] = explode(',', $dataTax[0]);
            $dataTaxes1[] = $dataTax[0];
            $dataTaxId[] = $dataTax[1];
            $dataTaxValue = $dataTax[2];
        }

        foreach ($fdata['payment'] as $result) {
            $data = explode("_", $result);
            $payment[] = explode(',', $data[0]);
            $pay = explode(',', $data[0]);
            $payment1[] = $pay[0];
            $paymentId[] = $data[1];
        }
        $maximum = count($payment1);
        for ($paymentCount = 0; $paymentCount < $maximum; $paymentCount++) {
            if (count($lanCodeArr) == count($payment1[$paymentCount])) {
                $paymentData['paymentName'] = array_combine($lanCodeArr, $payment1[$paymentCount]);
            } else {
                $paymentData['paymentName']['en'] = $payment1[$paymentCount];
            }
            $paymentDetails['details'][$paymentCount]['paymentName'] = $paymentData['paymentName'];
            $paymentDetails['details'][$paymentCount]['paymentId'] = $paymentId[$paymentCount];

        }


       

        $max = count($fdata['taxes']);
        for ($count = 0; $count < $max; $count++) {
            $taxData[$dataTaxes1[$count]];

            if (count($lanCodeArr) == count($dataTaxes[$count])) {
                $dat['name'] = array_combine($lanCodeArr, $dataTaxes[$count]);
            } else {
                $dat['name']['en'] = $dataTaxes[$count][0];
            }

            $taxDataDetails['taxes'][$count]['name'] = $dat['name'];
            $taxDataDetails['taxes'][$count]['Id'] = $dataTaxId[$count];
            $taxDataDetails['taxes'][$count]['value'] = (float) $dataTaxValue;
        }

        if($fdata['taxesApplicable'] == 1){
            $fdata['taxesApplicable'] = true;
        }else{
            $fdata['taxesApplicable'] = false;
        }

        if($fdata['typeOfAccount'] == 1){
            $fdata['typeOfAccount']=1;
            $fdata['defaultExternalAccount']['accountNumber']="Iban Number";
        }else{
            $fdata['typeOfAccount']=2;
            $fdata['defaultExternalAccount']['accountNumber']="Account Number";
        }

        if($fdata['isStripeEnabled'] == 1){
            $fdata['isStripeEnabled']=1;            
        }else{
            $fdata['isStripeEnabled']=0;
            
        }

        if($fdata['isIdeal'] == 1){
            $fdata['isIdeal']=1;
            
        }else{
            $fdata['isIdeal']=0;
            
        }

        if ($fdata['distance_metrics'] == "KM") {
            $mileageMetric = "0";
        } else if ($fdata['distance_metrics'] == "Miles") {
            $mileageMetric = "1";
        } else if ($fdata['distance_metrics'] == "Yards") {
            $mileageMetric = "2";
        }
        if ($fdata['currenct_abbr'] == 2 || $fdata['currenct_abbr'] == '2') {
            $abbrevation = 'Suffix';
        } else {
            $abbrevation = 'Prefix';
        }
        if ($fdata['weightMetric'] == "KG") {
            $weightMetric = "0";
        } else {
            $weightMetric = "1";
        }

        $data['currency'] = strtoupper($fdata['currency']);
        $data['isDeleted'] = FALSE;
        $details['cities'] = array('cityId' => new MongoDB\BSON\ObjectID(), 'taxDetails' => $taxDataDetails['taxes'], 'paymentDetails' => $paymentDetails['details'], 'temperature' => $fdata['temperature'], 'height' => $fdata['height'], 'width' => $fdata['width'], 'length' => $fdata['length'], 'abbrevation' => $fdata['currenct_abbr'], 'abbrevationText' => $abbrevation, 'state' => $fdata['state'], 'cityName' => $fdata['city'], 'currency' => strtoupper($fdata['currency']), 'currencySymbol' => $fdata['currency_symbol'], 'coordinates' => array('longitude' => (double) $fdata['longitude'], 'latitude' => (double) $fdata['latitude']), 'isDeleted' => $data['isDeleted'], 'mileageMetric' => $mileageMetric, 'mileageMetricText' => $fdata['distance_metrics'], 'weightMetricText' => $fdata['weightMetric'], 'weightMetric' => $weightMetric, 'paymentMethods' => $payment1, 'paymentId' => $paymentId, 'tax' => $taxData,
            'taxId' => $dataTaxId, 'baseFare' =>  $fdata['baseFare'], 'mileagePrice' => $fdata['mileagePrice'], 'mileagePriceAfterDistance' =>  $fdata['mileagePriceAfterMinutes'], 'timeFee' =>  $fdata['timeFee'], 'timeFeeAfterMinutes' =>  $fdata['timeFeeAfterMinutes'], 'waitingFee' =>  $fdata['waitingFee'], 'waitingFeeAfterMinutes' =>  $fdata['waitingFeeAfterMinutes'], 'minimumFare' =>  $fdata['minimumFare'], 'onDemandBookingsCancellationFee' =>  $fdata['onDemandBookingsCancellationFee'], 'onDemandBookingsCancellationFeeAfterMinutes' =>  $fdata['onDemandBookingsCancellationFeeAfterMinutes'], 'scheduledBookingsCancellationFee' =>  $fdata['ScheduledBookingsCancellationFee'], 'scheduledBookingsCancellationFeeBeforeMinutes' =>  $fdata['ScheduledBookingsCancellationFeeAfterMinutes'], 'convenienceFee' =>  (float)$fdata['convenienceFee'],
            'polygons' => json_decode($fdata['location']), 'polygonProps' => json_decode($fdata['path']), 'latitude' => $fdata['latitude'], 'longitude' => $fdata['longitude'],
            'defaultExternalAccount' => $fdata['defaultExternalAccount'],'typeOfAccount' => $fdata['typeOfAccount'],'countryCode'=>$fdata['shortCountryCode'],'bankAccountingLinking'=>1,
            'isStripeEnabled' => $fdata['isStripeEnabled'],'isIdeal' => $fdata['isIdeal'],'timeZoneId'=> $fdata['timeZoneId'],'convenienceType'=>(int) $fdata['convenienceType'],
            'laundry'=>array('lowerWeightLimit'=>(float)$fdata['lowerWeightLimit'],'upperWeightLimit'=>(float)$fdata['upperWeightLimit'],'Price'=>(float)$fdata['Price'],'extraFeeForExpressDelivery'=>(float)$fdata['extraFeeForExpressDelivery'],'taxesApplicable'=>$fdata['taxesApplicable']),
            'driverWalletLimits'=>array('softLimitForDriver'=>(float)$fdata['driverWalletLimits']['softLimitForDriver'],'hardLimitForDriver'=>(float)$fdata['driverWalletLimits']['hardLimitForDriver']),
            'customerWalletLimits'=>array('softLimitForCustomer'=>(float)$fdata['customerWalletLimits']['softLimitForCustomer'],'hardLimitForCustomer'=>(float)$fdata['customerWalletLimits']['hardLimitForCustomer']),
            
        );

        
        $country = $fdata['country'];
       // print_r($details['cities']);die;
        $res = $this->mongo_db->where(array("country" => $fdata['country']))->find_one('cities');

        if ($fdata['country'] == $res['country']) {

            foreach ($res['cities'] as $dat) {
				
                $arr[$dat['cityName']] = $dat['isDeleted'];
                $arr1[$dat['coordinates']['latitude']] = $dat['coordinates']['latitude'];
                $arr2[$dat['coordinates']['longitude']] = $dat['coordinates']['longitude'];
				
            }


            if (array_key_exists($fdata['latitude'], $arr1) && array_key_exists($data['longitude'], $arr2)) {
				
				
                if (array_key_exists($fdata['city'], $arr) && $arr[$fdata['city']] == FALSE) {
                    $response_array['flag'] = 2;
                    return array('msg' => "City already exists", 'flag' => 2);
                } else {
					
					
                    $updateArray = array('cities.$.isDeleted' => FALSE, 'taxDetails' => $taxDataDetails['taxes'], 'paymentDetails' => $paymentDetails['details'], 'cities.$.abbrevation' => $fdata['currenct_abbr'], 'cities.$.abbrevationText' => $abbrevation, 'cities.$.state' => $fdata['state'], 'cities.$.cityName' => $fdata['city'], 'cities.$.currency' => strtoupper($fdata['currency']), 'cities.$.currencySymbol' => $fdata['currency_symbol'], 'cities.$.coordinates' => array('longitude' => (double) $fdata['longitude'], 'latitude' => (double) $fdata['latitude']), 'cities.$.mileageMetric' => $mileageMetric, 'cities.$.mileageMetricText' => $fdata['distance_metrics'], 'cities.$.weightMetricText' => $fdata['weightMetric'], 'cities.$.weightMetric' => $weightMetric, 'cities.$.paymentMethods' => $payment1, 'cities.$.paymentId' => $paymentId, 'cities.$.tax' => $taxData,
                        'cities.$.polygons' => json_decode($fdata['location']), 'cities.$.polygonProps' => json_decode($fdata['path']),'cities.$.temperature' => $fdata['temperature'], 'cities.$.height' => $fdata['height'], 'cities.$.length' => $fdata['length'], 'cities.$.width' => $fdata['width'], 'cities.$.taxId' => $dataTaxId, 'cities.$.baseFare' =>  $fdata['baseFare'], 'cities.$.mileagePrice' =>  $fdata['mileagePrice'], 'cities.$.mileagePriceAfterDistance' =>  $fdata['mileagePriceAfterDistance'], 'cities.$.timeFee' =>  $fdata['timeFee'], 'cities.$.timeFeeAfterMinutes' =>  $fdata['timeFeeAfterMinutes'], 'cities.$.waitingFee' =>  $fdata['waitingFee'], 'cities.$.waitingFeeAfterMinutes' =>  $fdata['waitingFeeAfterMinutes'], 'cities.$.minimumFare' =>  $fdata['minimumFare'], 'cities.$.onDemandBookingsCancellationFee' =>  $fdata['onDemandBookingsCancellationFee'], 'cities.$.onDemandBookingsCancellationFeeAfterMinutes' =>  $fdata['onDemandBookingsCancellationFeeAfterMinutes'], 'cities.$.scheduledBookingsCancellationFee' =>  $fdata['ScheduledBookingsCancellationFee'], 'cities.$.scheduledBookingsCancellationFeeBeforeMinutes' => $fdata['ScheduledBookingsCancellationFeeAfterMinutes'], 'cities.$.convenienceFee' =>(float)$fdata['convenienceFee']);
                   
				   $resTRUE = $this->mongo_db->where(array('cities.cityName' => $fdata['city'], 'cities.isDeleted' => TRUE))->set($updateArray)->update('cities');

                    $response_array['flag'] = 1;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, APILink . 'admin/city');
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

					$result = curl_exec($ch);
					curl_close($ch);
                    return array('msg' => "Success", 'flag' => 0);
                }
            } else {
				

                $rec = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($res['_id']['$oid'])))->push('cities', $details['cities'])->update('cities');

                $response_array['flag'] = 0;
				 $ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, APILink . 'admin/city');
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

				$result = curl_exec($ch);
				curl_close($ch);
                return array('msg' => "City Successfully Created.", 'flag' => 0);
            }
        } else {
            $insertData['country'] = $country;
            $insertData['cities'] = array($details['cities']);
            $result = $this->mongo_db->insert('cities', $insertData);
			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, APILink . 'admin/city');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            curl_close($ch);
            foreach ($dataTaxId as $id) {
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->push(array("cities" => array('cityId' => $result, "cityName" => $fdata['city'])))->update('taxes');
            }
            $response_array['status'] = 'success';
            $response_array['data'] = $input;
            $response_array['flag'] = 0;
            return array('msg' => "City Successfully Created.", 'flag' => 0);
        }
    }

    function city_update() {
	//	echo "<pre>";
   //   print_r($this->input->post('fdata'));die;
        $this->load->library('mongo_db');
        $id = $this->input->post('edit_id');
        $docid = $this->input->post('docid');
        $fdata = $this->input->post('fdata');
        $payment = array();
        $payment1 = array();
        $paymentId = array();
        $taxData = array();
        $taxDataDetails = array();
        $paymentDetails = array();
        $dataTaxes = array();
        $dataTaxId = array();
        $lang = $this->mongo_db->get('lang_hlp');
        $lanCodeArr = [];
        $lanIdArr = [];
        foreach ($lang as $lan) {
            $lanCodeArr[0] = "en";
            $lanIdArr[0] = "0";
            array_push($lanCodeArr, $lan['langCode']);
            array_push($lanIdArr, $lan['lan_id']);
        }

        foreach ($fdata['payment'] as $result) {
            $data = explode("_", $result);
            $payment[] = explode(',', $data[0]);
            $pay = explode(',', $data[0]);
            $payment1[] = $pay[0];
            $paymentId[] = $data[1];
        }
        
        $maximum = count($payment1);
        for ($paymentCount = 0; $paymentCount < $maximum; $paymentCount++) {
            if (count($lanCodeArr) == count($payment1[$paymentCount])) {
                $paymentData['paymentName'] = array_combine($lanCodeArr, $payment1[$paymentCount]);
            } else {
                $paymentData['paymentName']['en'] = $payment1[$paymentCount];
            }
            $paymentDetails['details'][$paymentCount]['paymentName'] = $paymentData['paymentName'];
            $paymentDetails['details'][$paymentCount]['paymentId'] = $paymentId[$paymentCount];
        }

        foreach ($fdata['taxes'] as $resultTax) {
            $dataTax = explode("_", $resultTax);
            $dataTaxes[] = explode(',', $dataTax[0]);
            $dataTaxes1[] = $dataTax[0];
            $dataTaxId[] = $dataTax[1];
            $dataTaxValue = $dataTax[2];
        }
        $max = count($fdata['taxes']);
        for ($count = 0; $count < $max; $count++) {
            $taxData[$dataTaxes1[$count]];

            if (count($lanCodeArr) == count($dataTaxes[$count])) {
                $dat['name'] = array_combine($lanCodeArr, $dataTaxes[$count]);
            } else {
                $dat['name']['en'] = $dataTaxes[$count][0];
            }

            $taxDataDetails['taxes'][$count]['name'] = $dat['name'];
            $taxDataDetails['taxes'][$count]['Id'] = $dataTaxId[$count];
            $taxDataDetails['taxes'][$count]['value'] = (float) $dataTaxValue;
        }

        $taxData = array();
        $max = count($fdata['taxValues']);
        for ($count = 0; $count < $max; $count++) {
            $taxData[$dataTaxes[$count]] = $fdata['taxValues'][$count];
        }


        switch ($fdata['distance_metrics']) {
            case "KM":
                $mileageMetric = "0";
                break;
            case "Miles":
                $mileageMetric = "1";
                break;
            case "Yards":
                $mileageMetric = "2";
                break;
        }
        if ($fdata['currenct_abbr'] == 2 || $fdata['currenct_abbr'] == '2') {
            $abbrevation = 'Suffix';
        } else {
            $abbrevation = 'Prefix';
        }

        if($fdata['taxesApplicable'] == 1){
            $fdata['taxesApplicable'] = true;
        }else{
            $fdata['taxesApplicable'] = false;
        }

        if($fdata['typeOfAccount'] == 1){
            $fdata['typeOfAccount']=1;
            $fdata['defaultExternalAccount']['accountNumber']="Iban Number";
        }else{
            $fdata['typeOfAccount']=2;
            $fdata['defaultExternalAccount']['accountNumber']="Account Number";
        }


        if($fdata['isStripeEnabled'] == 1){
            $fdata['isStripeEnabled']=1;            
        }else{
            $fdata['isStripeEnabled']=0;
            
        }

        if($fdata['isIdeal'] == 1){
            $fdata['isIdeal']=1;
            
        }else{
            $fdata['isIdeal']=0;
            
        }


       



        if ($fdata['weightMetric'] == "KG") {
            $weightMetric = "0";
        } else {
            $weightMetric = "1";
        }

        $data['currency'] = strtoupper($fdata['currency']);
        $data['isDeleted'] = FALSE;
        $details = array('cities.$.isDeleted' => $data['isDeleted'], "cities.$.paymentMethods"=>$payment1,'cities.$.abbrevation' => $fdata['currenct_abbr'], 'cities.$.abbrevationText' => $abbrevation, 'cities.$.state' => $fdata['state'], 'cities.$.cityName' => $fdata['city'], 'cities.$.currency' => strtoupper($fdata['currency']), 'cities.$.currencySymbol' => $fdata['currency_symbol'], 'cities.$.coordinates' => array('longitude' => (double) $fdata['longitude'], 'latitude' => (double) $fdata['latitude']), 'cities.$.mileageMetric' => $mileageMetric, 'cities.$.mileageMetricText' => $fdata['distance_metrics'], 'cities.$.weightMetricText' => $fdata['weightMetric'], 'cities.$.weightMetric' => $weightMetric, 'cities.$.paymentDetails' => $paymentDetails['details'], 'cities.$.taxDetails' => $taxDataDetails['taxes'],
            'cities.$.temperature' => $fdata['temperature'], 'cities.$.height' => $fdata['height'], 'cities.$.length' => $fdata['length'], 'cities.$.width' => $fdata['width'], 'cities.$.baseFare' => $fdata['baseFare'], 'cities.$.mileagePrice' =>  $fdata['mileagePrice'], 'cities.$.mileagePriceAfterDistance' =>  $fdata['mileagePriceAfterMinutes'], 'cities.$.timeFee' => $fdata['timeFee'], 'cities.$.timeFeeAfterMinutes' =>  $fdata['timeFeeAfterMinutes'], 'cities.$.waitingFee' =>  $fdata['waitingFee'], 'cities.$.waitingFeeAfterMinutes' =>  $fdata['waitingFeeAfterMinutes'], 'cities.$.minimumFare' =>  $fdata['minimumFare'], 'cities.$.onDemandBookingsCancellationFee' =>  $fdata['onDemandBookingsCancellationFee'], 'cities.$.onDemandBookingsCancellationFeeAfterMinutes' =>  $fdata['onDemandBookingsCancellationFeeAfterMinutes'], 'cities.$.scheduledBookingsCancellationFee' =>  $fdata['ScheduledBookingsCancellationFee'], 'cities.$.scheduledBookingsCancellationFeeBeforeMinutes' =>  $fdata['ScheduledBookingsCancellationFeeBeforeMinutes'], 'cities.$.convenienceFee' =>(float) $fdata['convenienceFee'],
            'cities.$.polygons' => json_decode($fdata['location']), 'cities.$.polygonProps' => json_decode($fdata['path']), 'cities.$.latitude' => $fdata['latitude'], 'cities.$.longitude' => $fdata['longitude'],
            'cities.$.defaultExternalAccount' => $fdata['defaultExternalAccount'],'cities.$.typeOfAccount' => $fdata['typeOfAccount'], 'cities.$.countryCode'=>$fdata['shortCountryCode'], 
            'cities.$.isStripeEnabled' => $fdata['isStripeEnabled'],'cities.$.isIdeal' => $fdata['isIdeal'],'cities.$.convenienceType'=>(int) $fdata['convenienceType'],
            'cities.$.laundry'=>array('lowerWeightLimit'=>(float)$fdata['lowerWeightLimit'],'upperWeightLimit'=>(float)$fdata['upperWeightLimit'],'Price'=>(float)$fdata['Price'],'extraFeeForExpressDelivery'=>(float)$fdata['extraFeeForExpressDelivery'],'taxesApplicable'=>$fdata['taxesApplicable']),
            'cities.$.driverWalletLimits'=>array('softLimitForDriver'=>(float)$fdata['driverWalletLimits']['softLimitForDriver'],'hardLimitForDriver'=>(float)$fdata['driverWalletLimits']['hardLimitForDriver']),
            'cities.$.customerWalletLimits'=>array('softLimitForCustomer'=>(float)$fdata['customerWalletLimits']['softLimitForCustomer'],'hardLimitForCustomer'=>(float)$fdata['customerWalletLimits']['hardLimitForCustomer'])
        );
      

 foreach ($dataTaxId as $tid) {
            $taxData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($tid)))->find_one('taxes');

            if (!in_array($id, $taxData['cityId'])) {
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($tid)))->push(array('cities' => array("cityId" => $id, "cityName" => $fdata['city'])))->update('taxes');
            }
        }

        // echo '<pre>';print_r( $details);die;
        $query = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($docid), 'cities.cityId' => new MongoDB\BSON\ObjectID($id)))->set($details)->update('cities');
        // echo '<pre>';print_r($query);die;
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, APILink . 'admin/city');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

            $result = curl_exec($ch);
            curl_close($ch);
		return array('msg' => "City Successfully Updated.", 'flag' => 0);
    }


    function getAreaForCity($id){
      

        $cityData = $this->mongo_db->aggregate('cities',[
            ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($id)]],
            ['$unwind'=>'$cities'],
            ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($id)]],
            ['$project'=>['cities.currencySymbol'=>1]]
            ]);

        foreach($cityData as $city){
            $cityData=$city;

        }

        
       
        // output ata
        echo json_encode(array('data' => $cityData));

    }

}
?>
