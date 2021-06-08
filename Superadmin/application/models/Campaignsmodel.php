<?php


error_reporting(E_ALL);

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Campaignsmodel extends CI_Model {


    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('CallAPI');

    }

    // function getAllCampaigns($status, $offset, $limit, $sSearch, $cityId)
    // {
    //     $offset=$_POST['start']/10;
    //     $limit=$_POST['length'];
    //     $data = ['status'=> $status, 'offset' => $offset, 'limit' => $limit, 'sSearch' =>$sSearch, 'cityId' =>  $cityId];
    //     $url = APILINKPROMO . "getCampaignsByStatus";
    //     // var_dump($url);
    //     $offerDetails = $this->callapi->CallAPI('POST',$url, $data);
    //     return $offerDetails; 
    // changes
    // }

    function getAllCampaigns($status, $offset, $limit, $sSearch, $cityId,$datetime)
    {
        $offset=$_POST['start']/10;
        $limit=$_POST['length'];
        $data = ['status'=> $status, 'offset' => $offset, 'limit' => $limit, 'sSearch' =>$sSearch, 'cityId' =>  $cityId,'dateTime'=>$datetime];

        $url = APILink . "getCampaignsByStatus";
        // var_dump($url);
        $offerDetails = json_decode($this->callapi->CallAPI('POST',$url, $data),true);
        return $offerDetails;
    }
// Update offer status
    function updateCampaignStatus($status, $offerIds)
    {
        $data = array('campaignId' => $offerIds, 'status' => $status);
        $url = APILINKPROMO ."updateCampaigns" ;
        $response = $this->callapi->CallAPI('PATCH',$url, $data,false,$contentType = 'application/json');
        return  $response;
    }
    
    // Get city details
    function getCityDetails($cityIds)
    {
       
        // $data = ['cityIds' => $cityIds];
        $url = APILINKPROMO . "citiesDetails/". $cityIds;
        $response = $this->callapi->CallAPI('GET',$url, '');
        return  $response;
    }
    
    // // Get zone details
    function getZoneDetails($zoneIds)
    {
        $url = APILINKPROMO . "zoneDetails/". $zoneIds;
        $response = $this->callapi->CallAPI('GET',$url, '');
        return  $response;
    }
    function getQualifiedTripCount($campaignId){
        $url = APILINKPROMO . "qualifiedTripCount/". $campaignId;
        $response = $this->callapi->CallAPI('GET',$url, '');
        return  $response;
    }
    function getUnlockedCount($campaignId){
        $url = APILINKPROMO . "getUnlockedCount/". $campaignId;
        $response = json_decode($this->callapi->CallAPI('GET',$url, ''),true);
        return  $response;
    }
    function getUnlockedDetailsByCampaignId($campaignId){

        $offset=$_POST['start']/10;
        $limit=$_POST['length'];     
        $url = APILINKPROMO . "unlockedTripLogsById/". $campaignId . "/" . $offset ."/" . $limit;
        
        $response = $this->callapi->CallAPI('GET',$url, '');

      
        return  $response;
    }

    function getClaimdDetailsByCampaignId($campaignId){
        
        $offset=$_POST['start']/10;
        $limit=$_POST['length'];
        $url = APILINKPROMO . "claimedCodeDetailsByCampaignId/". $campaignId .'/'.$offset . '/' . $limit;
         $response = $this->callapi->CallAPI('GET',$url, '');
        return  $response;
    }

    function getQualifiedTripDetails($campaignId){
        $offset=$_POST['start']/10;
        $limit=$_POST['length'];
        $url = APILINKPROMO . "qualifiedTripLogsByCampaignId/". $campaignId .'/'.$offset . '/' . $limit;
        $response = $this->callapi->CallAPI('GET',$url, '');
        return  $response;
    }

    function getCampaignDetailsById($campaignId) {
        $url = APILINKPROMO . "campaignById/". $campaignId;
        $response = json_decode($this->callapi->CallAPI('GET',$url, ''),true);
        return  $response;
    }

    // function getClaimdDetailsByCampaignId($campaignId, $offset, $limit){
    //     $url = APILink . "claimedCodeCountByCampaignId/". $campaignId .'/'.$offset . '/' . $limit;
    //     $response = json_decode($this->callapi->CallAPI('GET',$url, ''),true);
    //     return  $response;
    // }
}

// https://api.instacart-clone.com/qualifiedTripLogsByCampaignId/5a8ffbf6fd7ff35e3779c14a/0/10
// https://api.instacart-clone.com/claimedCodeCountByCampaignId/5a8ffbf6fd7ff35e3779c14a/0/10
