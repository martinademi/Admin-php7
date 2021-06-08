<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class VoucherModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('CallAPI');
    }

    function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function voucher_details($timeOffset,$status) {
        $timeOffset = -$timeOffset;
        // $this->load->library('mongo_db');

        // $this->load->library('Datatables');
        // $this->load->library('table');
        $status=(int)$status;
        // echo $status;die;
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "value";

        $sl = $_POST['iDisplayStart'] + 1;
        // $res = $this->mongo_db->get('vouchers');
        $respo = $this->datatables->datatable_mongodb('vouchers',array('status'=>$status),'createdOnTimeStamp',-1);
       
        $aaData = $respo["aaData"];
       
        $datatosend = array();

        foreach ($aaData as $value) {
            $datetimeval = date('d-m-Y h:i:s A',$value['createdOnTimeStamp']);
            $dateExpiry= gmdate('d-m-Y h:i:s A',$value['expiryDateTimeStamp']);
            //$datetimeval = date('d-m-Y h:i:s A',strtotime("+$timeOffset minutes" , strtotime($datetimeval)));
            $arr = array();
            $redeemed =0;
            
            foreach($value['vouchersList'] as $voucherList){
                if($voucherList['status'] != 1){
                    $redeemed+=1;
                }

                
            }
            $arr[] = $sl++;
            $arr[] = $value['name'];
            $arr[] = $datetimeval;
            $arr[] = '<a href="'.base_url().'index.php?/Voucher/couponDetails/'. $value['_id']['$oid'].'/'.$value['name'].'" >'.$value['count'].'</a>';
            $arr[] = $value['value'];
            $arr[] = ($redeemed == 0)? 0 : '<a href="'.base_url().'index.php?/Voucher/redeemDetails/'. $value['_id']['$oid'].'/'.$value['name'].'" >'.$redeemed.'</a>';
            $arr[] =  $dateExpiry;
           // $arr[] = '<button class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['_id']['$oid'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function addVoucher() {
        // commission type - 0: percentage,1: fixed
        $data = $_POST;
        $postdata['name'] = $data['vouchername'];
        $postdata['codePrefix'] =$data['codeprefix'];
        $postdata['codePostfix'] = $data['codepostfix'];
        $postdata['count'] = $data['noofcoupon'];
        $postdata['value'] = $data['couponvalue'];
        // $dateTime = $data['expiryDate'].' '.$data['expiryTime'];
        // print_r($data['expiryDate']);
        // $dateTime=date_create($dateTime);
        $postdata['expiryDate'] = date("Y-m-d H:i:s", strtotime($data['expiryDate']));
        $url = APILink . 'voucher';  
        $response = json_decode($this->callapi->CallAPI('POST', $url, $postdata), true);  
        // print_r($response);die;
        echo json_encode($response);
        
    }
    function getCouponDetails($id){
     
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "vouchersList.name";
        $_POST['mDataProp_1'] = "vouchersList.statusMsg";

        $sl = $_POST['iDisplayStart'] + 1;
            $id = new MongoDB\BSON\ObjectID($id);
        $respo = $this->datatables->datatable_mongodbAggregate('vouchers', array(array('$unwind' => '$vouchersList'),array('$match'=>array('_id'=>$id)),
       array('$project'=>array("vouchersList"=>1)),array('$sort'=>array('createdOnTimeStamp'=> -1))
    ),
    array(array('$unwind' => '$vouchersList'),array('$match'=>array('_id'=>$id)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1))))

);
       
        $aaData = $respo["aaData"];
       
        $datatosend = array();
        // print_r($aaData);die;
        foreach ($aaData as $value) {
           $value = json_encode($value);
            $value = json_decode($value,true);
            //$datetimeval = date('d-m-Y h:i:s A',strtotime("+$timeOffset minutes" , strtotime($datetimeval)));
            $arr = array();
            // $redeemed =0;
            // foreach($value['vouchersList'] as $voucherList){
            //     if($voucherList['status'] != 1){
            //         $redeemed+=1;
            //     }
            // }
            $arr[] = $sl++;
            $arr[] = $value['vouchersList']['name'];
            $arr[] = $value['vouchersList']['statusMsg'];
            
            // $arr[] = $value['value'];
            // $arr[] = $redeemed;
           // $arr[] = '<button class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            // $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }
      
      
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }


    function getRedeemDetails($id){
     
        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "vouchersList.name";
        $_POST['mDataProp_1'] = "vouchersList.statusMsg";

        $sl = $_POST['iDisplayStart'] + 1;
            $id = new MongoDB\BSON\ObjectID($id);
        $respo = $this->datatables->datatable_mongodbAggregate('vouchers', array(array('$unwind' => '$vouchersList'),array('$match'=>array('_id'=>$id,"vouchersList.status"=>2)),
       array('$project'=>array("vouchersList"=>1)),array('$sort'=>array('createdOnTimeStamp'=> -1))
    ),
    array(array('$unwind' => '$vouchersList'),array('$match'=>array('_id'=>$id,"vouchersList.status"=>2)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1))))

);
       
        $aaData = $respo["aaData"];
       
        $datatosend = array();
        // print_r($aaData);die;
        foreach ($aaData as $value) {
           $value = json_encode($value);
            $value = json_decode($value,true);
            //$datetimeval = date('d-m-Y h:i:s A',strtotime("+$timeOffset minutes" , strtotime($datetimeval)));
            $arr = array();
            $datetimeval = date('d-m-Y h:i:s A',$value['vouchersList']['actions'][0]['redeemedOn']);
            $arr[] = $sl++;
            $arr[] = $value['vouchersList']['name'];
            $arr[] = $value['vouchersList']['actions'][0]['redeemedByName'];
            $arr[] = $datetimeval;
            
            // $arr[] = $value['value'];
            // $arr[] = $redeemed;
           // $arr[] = '<button class="btn btnedit btn-primary cls111" id="btnEdit"  value="' . $value['_id']['$oid'] . '"  data-id=' . $value['_id']['$oid'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>';
            // $arr[] = "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $value['seqId'] . "' data='" . $value['_id']['$oid'] . "' value='" . $value['_id']['$oid'] . "'>";

            $datatosend[] = $arr;
        }
      
      
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }


     //update status
     function updateOfferStatus($status, $offerIds)
     {  

         $data_inside['voucherId'] = $offerIds;
         $data_inside['status'] = (int) $status;
         $data = $data_inside;
       
        //  $url = ProductOffers . 'offerStatus/';
        //  $response = json_decode($this->callapi->CallAPI('PATCH',$url, $data),true);
        foreach($data['voucherId'] as $id){
            // echo '<pre>';print_r($id);die;
            $response = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set(array("status"=> $data['status']))->update('vouchers');             
        }
        
        return  $response;

     }
   

}

?>
