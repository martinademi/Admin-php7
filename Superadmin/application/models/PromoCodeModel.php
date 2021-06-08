<?php

error_reporting(E_ALL);

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

require_once 'S3.php';

//require_once 'AwsPush.php';

class PromoCodeModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('CallAPI');
        $this->load->library('Datatables');
        $this->load->library('table');
    }

  
  function getAllCouponCodes($status, $offset, $limit, $sSearch, $cityId)
    {
        $offset=$_POST['start']/10;
        $limit=$_POST['length'];
        $data = ['status'=> $status, 'offset' => $offset, 'limit' => $limit, 'sSearch' =>$sSearch, 'cityId' =>  $cityId];
        // print_r($data);
        $url = APILink . "couponCodesByStatus/";
        $offerDetails = json_decode($this->callapi->CallAPI('POST',$url, $data),true);
        return $offerDetails;
    }

   

       //store List
       function getStoreData($cityIds="") {
 
        // print_r($cityIds);die;
             $cursor = $this->mongo_db->where(array("cityId" =>array('$in'=>$cityIds), "status" => 1 ))->select(array('sName'=>'sName'))->get('stores');
            // print_r($cursor);die;
           
            if ($cursor) {
                $entitiesData = array();
                $entityData = [];
                // echo '<pre>';print_r($cursor);die;
                foreach ($cursor as $dat) {
                    $entityData['id'] = $dat['_id']['$oid'];
                    $entityData['title'] = $dat['sName']['en'];
                    array_push($entitiesData, $entityData);
                }
              
                echo json_encode(array('data' => $entitiesData));
                // echo json_encode($entitiesData);
            } else {
                $entities = array();
                $entities = '<option value="">Select </option>';
                $entities .= '<option data-name="" value="">' . 'No product to select' . '</option>';
                echo $entities;
            }

        
    }

    // Update offer status
    function updateCodeStatus($status, $offerIds) {
        $data = ['promoCodeId' => $offerIds, 'status' => $status];
        $url = APILink . "updatePromoCode";
        $response = json_decode($this->callapi->CallAPI('PATCH', $url, $data, false, $contentType = 'application/json'), true);
        return $response;
    }

    //get claims logs
    function getAllClaimsLogs($campaignId) {
        $id = $campaignId;
        $data = $this->mongo_db->where(array("promoId" => $id, 'status' => "claimed"))->get('claims');
        echo json_encode($data);
    }

    //get claims logs

 

    function getClaimdDetailsByCampaignId($campaignId){
        $url = APILink . "allCalimsByOfferId/". $campaignId ;
         $response = json_decode($this->callapi->CallAPI('GET',$url, ''),true);
         return  $response;
     }

   
     function getUserDetails($userId){
       
        // var_dump($userId);
    $data=$this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($userId)))->get('customer');
    return $data;

    }

    // Get city details
    function getCityDetails($cityIds) {
        // $data = ['cityIds' => $cityIds];
        $url = APILink . "citiesDetails/" . $cityIds;
        $response = json_decode($this->callapi->CallAPI('GET', $url, ''), true);
        return $response;
    }

    // // Get zone details
    function getZoneDetails($zoneIds) {
        $url = APILink . "zoneDetails/" . $zoneIds;
        $response = json_decode($this->callapi->CallAPI('GET', $url, ''), true);
        return $response;
    }

    function getQualifiedTripCount($campaignId) {
        $url = APILink . "qualifiedTripCount/" . $campaignId;
        $response = json_decode($this->callapi->CallAPI('GET', $url, ''), true);
        return $response;
    }

    function getUnlockedCount($campaignId) {
        $url = APILink . "getUnlockedCount/" . $campaignId;
        $response = json_decode($this->callapi->CallAPI('GET', $url, ''), true);
        return $response;
    }

    function getQualifiedTripDetails($campaignId) {
        $url = APILink . "qualifiedTripsDetail/" . $campaignId;
        $response = json_decode($this->callapi->CallAPI('GET', $url, ''), true);
        return $response;
    }

    // Get counts by status
    function getAllCouponCodeCount() {
        // Get new count
        $newCount = $this->mongo_db->count('promoCodes', array('status' => 1));
        // Get active count
        $activeCount = $this->mongo_db->count('promoCodes', array('status' => 2));
        // Get inactive count
        $inActiveCount = $this->mongo_db->count('promoCodes', array('status' => 3));
        // Get deleted count
        $deleteCount = $this->mongo_db->count('promoCodes', array('status' => 4));

        $countData = [
            "newCount" => $newCount,
            "activeCount" => $activeCount,
            "inActiveCount" => $inActiveCount,
            "deleteCount" => $deleteCount
        ];
        return $countData;
    }

    // Get all data count result from referralCampaigns collection for data table count
    function getAllCodeCounts() {
        $allCodeCount = $this->mongo_db->count('promoCodes', array("promoType" => "couponCode"));
        return $allCodeCount;
    }

    function datatable_search($searchval) {
        $_POST['sEcho'] = 1;
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "title";
        $_POST['iSortCol_0'] = "title";
        // $data = $this->mongo_db->where(array("title" => new \MongoDB\BSON\Regex($searchval, 'i')),array("title" => new \MongoDB\BSON\Regex($searchval, 'i')))->get('promoCodes');

        $data = $this->datatables->datatable_mongodb('promoCodes', array());
        $resArr = [];
        $i = 1;
        foreach ($data['aaData'] as $val) {
            $resArr[] = array(
                $i++,
                $val['title'],
                $val['title'],
                $val['title'],
                $val['title'],
                $val['title'],
                $val['title'],
                $val['title'],
                $val['title'],
                $val['title']
            );
        }
        $data['aaData'] = $resArr;
        echo json_encode($data);
    }

    function getCatList() {
        $id = $this->input->post('cityid');
        if ($id)
            $result = $this->mongo_db->where(array('prices' => array('$elemMatch' => array('cityId' => $id, "ride.isEnabled" => TRUE))))->get('vehicleTypes');
        else
            $result = $this->mongo_db->get('vehicleTypes');
        echo json_encode(array('data' => $result));
        return;
    }

}
