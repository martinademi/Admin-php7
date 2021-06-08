<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class PaymentGatewayModal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('utility_library');
        $this->load->library('CallAPI');
    }

    public function datatablePaymentGateway($status) {

        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "gatewayName";
   
        switch($status){
            case 1;
                $respo = $this->datatables->datatable_mongodb('paymentGateway',array('isDeleted' => false),'',-1);
                break;
            case 2;
                $respo = $this->datatables->datatable_mongodb('paymentGateway',array('isDeleted' => true),'',-1);
                break;
                
        }

//        $respo = $this->datatables->datatable_mongodb('paymentGateway',array('isDeleted' => false),'',-1);


        $aaData = $respo["aaData"];
        $datatosend = array();
        $index = $_POST['iDisplayStart'] + 1;
        foreach ($aaData as $value) {

            $arr = array();
            $arr[] = $index++;
            $arr[] = ($value['gatewayName'] == '' || $value['gatewayName'] == null) ? "N/A" : strtoupper($value['gatewayName']);
            $arr[] = ($value['percentageCommission'] == '' || $value['percentageCommission'] == null) ? "N/A" : $value['percentageCommission'];
            $arr[] = ($value['fixedCommission'] == '' || $value['fixedCommission'] == null) ? "N/A" : $value['fixedCommission'];
            $arr[] = '<button class="btn btn-primary btnWidth editPaymentGateway cls111"  value=' . $value['_id']['$oid'] . '><i class="fa fa-edit"></i></button>';
//            $arr[] = ($value['totalCommission'] == '' || $value['totalCommission'] == null) ? "N/A" : $value['totalCommission'];
            $arr[] = '<input type="checkbox"  class="checkbox" value=' . $value['_id']['$oid'] . ' >';
            $arr[] = '<button class="btn btn-success btnWidth approvePaymentGateway"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-ok"></i></button>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
    function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->get('lang_hlp');
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    public function addPaymentGateway() {
        $gatewayName = $this->input->post('gatewayName');
        $commission = $this->input->post('commission');
        $fixedCommission = $this->input->post('fixedCommission');

        $bankAccountingLinking=$this->input->post('bankAccountLinking');
        $iban=$this->input->post('iban');
        $accountNumber=$this->input->post('accNum');

        if($bankAccountingLinking=="enabled"){
            $bankAccountingLinking=1;
        }else{
            $bankAccountingLinking=0;
        }

        if($iban=="true"){
            $iban=1;
        }else{
            $iban=0;
        }

        if($accountNumber=="true"){
            $accountNumber=1;
        }else{
            $accountNumber=0;
        }
        
        
        

        $previousGateway = $this->mongo_db->where(array('gatewayName' => $gatewayName))->find_one('paymentGateway');

        if (!$previousGateway) {
            $data = array('status'=>1,'statusMsg'=>"Active",'gatewayName' => $gatewayName,'percentageCommission' => (float) $commission, 'fixedCommission' => (int) $fixedCommission, 'isDeleted' => FALSE,
            'bankAccountingLinking'=> $bankAccountingLinking,'iban'=>$iban,'accountNumber'=>$accountNumber);
            // echo '<pre>';print_r($data);die;
            $result = $this->mongo_db->insert('paymentGateway', $data);
            echo json_encode(array('flag'=>1,'data'=>$result));
        } else {         
            echo json_encode(array('flag'=>0));
            
        }
      
        
//        $totalCommission = $commission + $fixedCommission;
       
    }

    public function updatePaymentGateway() {
        $val = $this->input->post('val');
//        print_r($val);die;
        $gatewayName = $this->input->post('gatewayName');
        $commission = $this->input->post('commission');
        $fixedCommission = $this->input->post('fixedCommission');
        $bankAccountingLinking=$this->input->post('editbankAccountLinking');
        $iban=$this->input->post('editiban');
        $accountNumber=$this->input->post('editaccNum');

        if($bankAccountingLinking=="enabled"){
            $bankAccountingLinking=1;
        }else{
            $bankAccountingLinking=0;
        }

        if($iban=="true"){
            $iban=1;
        }else{
            $iban=0;
        }

        if($accountNumber=="true"){
            $accountNumber=1;
        }else{
            $accountNumber=0;
        }
        
        $data = array('gatewayName' => $gatewayName, 'percentageCommission' => (float) $commission, 'fixedCommission' => (int) $fixedCommission, 'isDeleted' => FALSE,
        'bankAccountingLinking'=> $bankAccountingLinking,'iban'=>$iban,'accountNumber'=>$accountNumber );
        // echo '<pre>';print_r($data);die;
            $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->set($data)->update('paymentGateway');
        
        echo json_encode(array('flag'=>1,'data'=>$result));
    }

    public function deletePaymentGateway() {
        $val = $this->input->post('val');
        foreach ($val as $id) {
            $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set(array('status'=>2,'statusMsg'=>"Deleted",'isDeleted' => true))->update('paymentGateway');
        }
        echo json_encode(array('flag'=>1));
    }
    public function approvePaymentGateway() {
        $val = $this->input->post('val');
        foreach($val as $id){
              $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set(array('status'=>1,'statusMsg'=>"Active",'isDeleted' => FALSE))->update('paymentGateway');
        }
        echo json_encode(array('flag'=>1));
    }
//    public function deletePaymentGateway() {
//        $val = $this->input->post('val');
//        foreach ($val as $id) {
//            $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->delete('paymentGateway');
//        }
//        echo json_encode(array('flag'=>1));
//    }
    public function getOnePaymentGateway() {
 
        $val = $this->input->post('val');
//               print_r($val);die;
      
           $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('paymentGateway');
        
        echo json_encode(array('data'=>$data));
    }

}

?>
