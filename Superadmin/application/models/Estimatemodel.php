<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Estimatemodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('CallAPI');
    }


    // function get_estimateList(){

    //   $this->load->library('mongo_db');
    //   $res=$this->mongo_db->get('estimationFare');
     
    //   return $res;
    //  }

    function getCustomerInfo($custId){

       $res=$this->mongo_db->where(array('_id'=> new MOngoDB\BSON\ObjectID($custId)))->find_one('customer');
       
       echo json_encode($res);

    }

     function get_estimateList($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

         $_POST['iColumns'] = 2;

         $_POST['mDataProp_0'] = "storeWiseFare.customerName";
         $_POST['mDataProp_1'] = "storeWiseFare.orderId";
        


       $respo =  $this->datatables->datatable_mongodb('estimationFare', array(), '_id', -1);
       
        $aaData = $respo["aaData"];
        $datatosend = array();
        $slno = $_POST['iDisplayStart']+1;
        
        foreach ($aaData as $value) {
       
          
         $arr = array();

          foreach($value['storeWiseFare'] as $val){
           
            $na='N/A';
           
             $estId=$val['estimateId'];
             $deliveryFee=$val['deliveryPrice'];
             //$currencySymbol=$val['currencySymbol'];

            if(array_key_exists('customerName',$val) ){
               // $cName=$val['customerName'];
               //  $customerName=($val['customerName']!="")? $val['customerName']:'N/A';

                if($val['customerName']!=""){
                //  $cName='<a style="cursor: pointer;" id="' . $value['userId'] . '"  class="getCustInfo" >' .  $val['customerName'] . '</a>';
                $cName=$val['customerName'];
                }else{
                  $cName='N/A';
                }

                
             }else{
                $cName='N/A';
             }

             if(array_key_exists('orderValue',$val) ){
                $oValue=$val['orderValue'];
                
             }else{
                $oValue='N/A';
             }

             if(array_key_exists('orderCategory',$val) ){
               $orderCategory=$val['orderCategory'];
                
             }else{
               $orderCategory='N/A';
             }

             if(array_key_exists('cartId',$val) ){
                $cartId=$val['cartId']['$oid'];
                
             }else{
                $cartId='N/A';
             }

             if(array_key_exists('currencySymbol',$val) ){
                $currencySymbol=$val['currencySymbol'];
                
             }else{
                $currencySymbol=' ';
             }
            
            //$oValue=$val['orderValue'];
          }

          foreach($value['actions'] as $data){

            $createdOn=$data['timestamp'];
          }

        

           $arr[] = $slno++;
           $arr[]=  $estId;
           $arr[]=  date('d-M-Y h:i:s a ', (($value['actions'][0]['timestamp'])/1000) - ($this->session->userdata('timeOffset') * 60));
           $arr[]=   $cartId;
           $arr[]= $currencySymbol.' '. $oValue;
           $arr[]=  $cName;
           $arr[]=  $orderCategory;
           $arr[]=  $currencySymbol.' '.$deliveryFee;


         
           $datatosend[] =$arr;
        }



        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

     

}
?>