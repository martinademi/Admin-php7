<?php

error_reporting(E_ALL);

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");



class Referralmodel extends CI_Model {


    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('CallAPI');

    }

    function referralCampaignsByStatus($status, $offset, $limit, $sSearch, $cityId)
    {   
        $offset=$_POST['start']/10;
        $limit=$_POST['length'];
        $data = ['status'=> $status, 'offset' => $offset, 'limit' => $limit, 'sSearch' =>$sSearch, 'cityId' =>  $cityId];
        $url = APILink . 'getReferralCampaignsByStatus';
        $offerDetails = json_decode($this->callapi->CallAPI('POST',$url, $data),true);
       
        return $offerDetails;
    }
// Update offer status
    function updateOfferStatus($status, $offerIds)
    {
        $data = array('campaignId' => $offerIds, 'status' => $status );
        $url = APILink . 'updateReferralCode';
       // $response = $this->callapi->CallAPI('PATCH',$url, $data,false,$contentType = 'application/json');
        $response = json_decode($this->callapi->CallAPI('PATCH',$url, $data),true);
        return  $response;
    }
    function getStoreDetails($storeID){
        $data = iterator_to_array($this->mongo_db->get_where('ProviderData', array('_id' => new MongoId($storeID))));
        return $data;
    }

     function getAllReferralCodesCount(){
        $allCodeCount = $this->mongo_db->count('referralCampaign', array( "promoType" => "referralCampaign"));
        return $allCodeCount;
    }

    function referralCodesByCampaignId($campaignId){

        $offset=$_POST['start']/10;
        $limit=$_POST['length'];
        $data = ['campaignId' => $campaignId, 'offset' => $offset, 'limit' => $limit ];
        $url = APILink . 'referralCodesGeneratedByCampaignId' . '/'. $campaignId. '/'. $offset . '/' . $limit;
        //$response = $this->callapi->CallAPI('GET',$url);
        $response = json_decode($this->callapi->CallAPI('GET',$url),true);
        return  $response;
    }

    function campaignQualifiedReferralCodes($userId, $campaignId, $offset, $limit){
        
        $data = ['campaignId' => $campaignId, 'offset' => $offset, 'limit' => $limit ];
        
        $url = APILink . 'referralsByUsersIdAndCampaignId' . '/'. $userId. '/'. $campaignId . '/' . $offset. '/'. $limit;
        
       // $response = $this->callapi->CallAPI('GET',$url);
        $response = json_decode($this->callapi->CallAPI('GET',$url),true);
        
        return  $response;
    }

    function referralCampQulTripLogs($campaignId){

        $offset=$_POST['start']/10;
        $limit=$_POST['length'];
        $data = ['campaignId' => $campaignId, 'offset' => $offset, 'limit' => $limit ];
        
        $url = APILink . 'unlockedDataByCampaignId' . '/'. $campaignId . '/' . $offset. '/'. $limit;
        
       // $response = $this->callapi->CallAPI('GET',$url);
        $response = json_decode($this->callapi->CallAPI('GET',$url),true);
       
        return  $response;
    }
}