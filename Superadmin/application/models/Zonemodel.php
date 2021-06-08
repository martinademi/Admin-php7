<?php

error_reporting(E_ERROR | E_PARSE);

class Zonemodel extends CI_Model {

    function __construct() {
        parent::__construct();
         $this->load->library('CallAPI');
         $this->load->library('mongo_db');
    }

    function cityForZones() {
        $this->load->library('mongo_db');
        $cityData = $this->mongo_db->get('cities');
        return $cityData;
    }
    
    function datatable_zones($status) {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "city";
        $_POST['mDataProp_1'] = "title";
        switch($status){
            case 0;
                $respo = $this->datatables->datatable_mongodb('zones', array('status' => 2), '', -1); //1->ASCE -1->DESC
                break;
            case 1;
                $respo = $this->datatables->datatable_mongodb('zones', array('status' => 1), '', -1); //1->ASCE -1->DESC
                break;
        }
        

        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl = $_POST['iDisplayStart']+1;

        foreach ($aaData as $value) { 

            // $date= date("Y-m-d h:i:sa");
            // $dateTimestamp = strtotime($date);
            //  $workingHourStoreDoc = $this->mongo_db->where(array('status'=> 1,'zoneId'=>$zoneId, 'endDateTimestamp'=>['$lt'=>$dateTimestamp]))->get('zonesDeliveryWorking') ;
            $deliveryCount=0;
            $countres = $this->mongo_db->aggregate('zonesDeliveryWorking', array(array('$match'=>array('status' => 1,'zoneId'=>$value['_id']['$oid'])),array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))));
            foreach($countres as $res){
                $deliveryCount= json_decode(json_encode($res->count,true));
    
            }
            
            $arr = array(); 
            $arr[] = $sl++;
            $arr[] = $value['city'];
            $arr[] = $value['title'];
            // $arr[] = "<a class='btn btn-primary btnWidth setPricing' data-toggle='tooltip' title='setPricing'  data-id='".$value['city_ID']."'  href='" . base_url('index.php?/Zones_Controller') . "/setPricing/" . $value['city_ID'] ."/".$value['_id']['$oid'] . "' style='text-decoration:none;'> 
            // SET PRICING  
            //     </a>";
            // $arr[] = "<a class='btn btn-primary btnWidth setShiftTimings' data-toggle='tooltip' title='setShiftTimings'  data-id='".$value['city_ID']."'  value='" . $value['_id']['$oid'] . "'  data-zone='" . $value['_id']['$oid'] . "' style='text-decoration:none;width:102px'> 
            // SHIFT TIMINGS  
            //     </a>";
            // $arr[] = ($deliveryCount!=0) ? '<a class="deliverySlots" data-id="'.$value['city_ID'].'" data-zoneid="'.$value['_id']['$oid'].'" value="' . $value['_id']['$oid'] . '" style="color: royalblue; cursor: pointer;"  >' . $deliveryCount . '</a>' : '0';
            // $arr[] = '<a class="deliverySchedule" data-id="'.$value['city_ID'].'"  value="' . $value['_id']['$oid'] . '" data-zone="' . $value['_id']['$oid'] . '" style="color: royalblue; cursor: pointer;"  >View  </a>';
            $arr[] = '<button style="width:35px;" class="btn btn-primary btnWidth editTurfZone cls111" data-id="'.$value['city_ID'].'"  value=' . $value['_id']['$oid'] . '><i class="fa fa-edit"></i></button>';          
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
          
            $datatosend[] = $arr;

        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function zones_data($param = '',$param1='') {
        $this->load->library('mongo_db');
        if ($param == '' && $param1 == ''){
          
            $res = $this->mongo_db->where(array('status'=>1))->get('zones');
        }
        else if($param != '' && $param1 != ''){
          
             $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param),"status"=>1))->find_one('zones');
        }else{
          
            $res = $this->mongo_db->where(array('city_ID' => $param1,"status"=>1))->order_by(array('desc'=>-1))->find_one('zones');
        }
        
        return $res;
    }
    
    function deleteZone() {
        $this->load->library('mongo_db');
        $zone_id = $this->input->post('zone_id');
        foreach ($zone_id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status'=>2,'statusMsg'=>"Deleted"))->update('zones');
            
        }
        $headers = array(
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.deliv-x.com/admin/zone");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");

            $result = curl_exec($ch);
//               print_r($result); die;
            curl_close($ch);
//        $url = 'https://api.instacart-clone.com/admin/zone';
//        $respon = json_decode($this->callapi->CallAPI('POST', $url), true);
        echo json_encode(array('msg' => 'zones deleted..!'));
    }


    function cityforZonesNew() {
        $this->load->library('mongo_db');
        $cityData = $this->mongo_db->get('cities');
        $arr = array();
        error_reporting(0);
        foreach ($cityData as $data) {

            foreach ($data['cities'] as $ciity) {
                $dat = array();
                $dat['cityId'] = $ciity['cityId']['$oid'];
                $dat['isDeleted'] = $ciity['isDeleted'];
                $dat['cityName'] = $ciity['cityName'];
                $dat['currency'] = $ciity['currency'];
                $dat['currencySymbol'] = $ciity['currencySymbol'];
                $dat['mileageMetricText'] = $ciity['mileageMetricText'];
                $dat['mileageMetric'] = $ciity['mileageMetric'];
                $dat['weightMetricText'] = $ciity['weightMetricText'];
                $dat['weightMetric'] = $ciity['weightMetric'];
                $dat['longitude'] = $ciity['coordinates']['longitude'];
                $dat['latitude'] = $ciity['coordinates']['latitude'];
                $dat['polygonProps'] = $ciity['polygonProps'];
                $dat['polygons'] = $ciity['polygons'];
                $arr[] = $dat;
            }
        }
//        echo "<pre>";
//        print_r($arr);die;
        return $arr;
    }

    function getCityZones() {

        $this->load->library('mongo_db');
        $this->load->library('table');

        $city_id = $this->input->post('cityId');

        $zoneData = $this->mongo_db->where(array('city_ID' => $city_id,'status' => 1))->get('zones');

        echo json_encode(array('data' => $zoneData, 'flag' => 0));
    }

    public function addAreaZone() {
//        print_r($_POST);die;
        $this->load->library('mongo_db');
        unset($_POST['fdata']['zoneLocationName']);
        unset($_POST['fdata']['zoneLocationLat']);
        unset($_POST['fdata']['zoneLocationLng']);
        $_POST['fdata']['status'] =1;
        $_POST['fdata']['statusMsg'] ="created";
        $_POST['fdata']['polygons'] = json_decode($_POST['fdata']['polygons']);
        $_POST['fdata']['polygonProps'] = json_decode($_POST['fdata']['polygonProps']);
        $zoneData = $this->mongo_db->insert('zones', $_POST['fdata']);
//        $url = 'https://api.instacart-clone.com/admin/zone';
//        $respon = json_decode($this->callapi->CallAPI('POST', $url), true);
         $headers = array(
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.deliv-x.com/admin/zone");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");

            $result = curl_exec($ch);
//               print_r($result); die;
            curl_close($ch);
        echo json_encode(array('flag' => '0'));
    }
    public function editAreaZone() {
        $this->load->library('mongo_db');
      
        $id = $_POST['fdata']['id'];
        unset($_POST['fdata']['zoneLocationName']);
        unset($_POST['fdata']['zoneLocationLat']);
        unset($_POST['fdata']['zoneLocationLng']);
        unset($_POST['fdata']['id']);
        $_POST['fdata']['updatedFromMsg']="Zone";
        $_POST['fdata']['updatedFrom']=1;
        $_POST['fdata']['polygons'] = json_decode($_POST['fdata']['polygons']);
        $_POST['fdata']['polygonProps'] = json_decode($_POST['fdata']['polygonProps']);

        if($_POST['fdata']['hasPackage']==1){
            $_POST['fdata']['packagingPlanDetails.weight']=(float)$_POST['fdata']['packagingPlanDetails']['weight'];
            $_POST['fdata']['packagingPlanDetails.price']=(float)$_POST['fdata']['packagingPlanDetails']['price'];
            $_POST['fdata']['packagingPlanDetails.upperLimit']=(float)$_POST['fdata']['packagingPlanDetails']['upperLimit'];
            $_POST['fdata']['packagingPlanDetails.lowerLimit']=(float)$_POST['fdata']['packagingPlanDetails']['lowerLimit'];
            $_POST['fdata']['packagingPlanDetails.addedFrom']=2;
            $_POST['fdata']['packagingPlanDetails.addedFromMsg']="UpdatedFromZone";
            unset($_POST['fdata']['packagingPlanDetails']);  
           
        }else{
           
        }
       

      
       

        $zoneData = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($id)))->set($_POST['fdata'])->update('zones');
   
      $headers = array(
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.deliv-x.com/admin/zone");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");

            $result = curl_exec($ch);
//               print_r($result); die;
            curl_close($ch);
        echo json_encode(array('flag' => '0'));
    }
    
    function getZonedata($param = '',$paramZone="") {

       //$data = $this->mongo_db->where(array("city_ID" =>$param,"status"=>1, "_id" =>array('$nin'=>[new MongoDB\BSON\ObjectID($paramZone)]) ))->get('zones');
       $data = $this->mongo_db->where(array("city_ID" =>$param,"status"=>1 ))->get('zones');
       return $data;
    }

    function getZoneName($zone_id) {
        
        $zoneName = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($zone_id)))->select(array('city'=>'city',"currencySymbol"=>"currencySymbol","title"=>"title"))->find_one('zones');
         return $zoneName;
    }


    function PricingSetForCity() {
            $this->load->library('mongo_db');
            $price =$this->input->post('pricing');
            $fromZone= $this->input->post('fromzoneId');
            $toZone=$this->input->post('tozoneId');
            $fromZoneName= $this->input->post('fromzoneName');
            $toZonename=$this->input->post('tozoneName');
            $currencySymbol=$this->input->post('currency');
            
            $priceArr = array();
    
        
            $data = $this->mongo_db->where(array('fromZone' => $fromZone, 'toZone' => $toZone ))->find_one('zonalPricing');
           
            if (count($data) > 0) {
            
                $MongoArr = array(
                    'pricing' => $price
                );
             
                $query = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['_id']['$oid'])))->set($MongoArr)->update('zonalPricing');
            } else {
               
            $MongoArr = array(
                    'fromZone' =>  $fromZone,
                    'toZone' =>  $toZone,
                    'pricing' =>(float) $price,
                    'currencySymbol' => $currencySymbol,
                    'fromZoneName' => $fromZoneName,
                    'toZonename' => $toZonename
                );
               
                // echo '<pre>';print_r($MongoArr);die;
            
                $query = $this->mongo_db->insert('zonalPricing', $MongoArr);
            }
            if ($query)
                echo json_encode(array('data' => $query, 'flag' => 0));
            else
                echo json_encode(array('data' => $query, 'flag' => 1));
            return;
    }

    function getPricingData($zone_id) {
       
        $data = $this->mongo_db->where(array('fromZone' => $zone_id))->get('zonalPricing');
        $PriceArr = array();
        // echo '<pre>';print_r($data);die;
        if($data){
            foreach ($data as $value) {
                
                $PriceArr[$value['toZone']] =$value['pricing'];
            }    
        }else{
            $PriceArr=0;
        }
     
     
        return $PriceArr;
    }


    

    
    

}

?>
