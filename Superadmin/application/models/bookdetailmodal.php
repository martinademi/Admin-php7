<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

require_once 'StripeModuleNew.php';

class bookdetailmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
//        $this->load->model('mastermodal');
        $this->load->database();
        $this->load->library('mongo_db');
    }

    public function updateinfo(){
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/tow_tray/temp/';
        $id = $this->input->post("id");
        $fname = $this->input->post("u_fname");
        $lname = $this->input->post("u_lname");
        $cityname = $this->input->post("cityname");
        $Address = $this->input->post("Address");
        $postalcode = $this->input->post("postalcode");
        $state = $this->input->post("state");
        $presnalid = $this->input->post("presnalid");
        $day = $this->input->post("dob_day");
        $month = $this->input->post("dob_month");
        $year = $this->input->post("dob_year");
        $idproof = $this->input->post("old_idproof");
        $stripeId = $this->input->post("stripeid");
        
        $userRecord = array(
//            'u_id' => $id, 
            'day' => $day, 
            'month' => $month, 
            'year' => $year,
            'first_name' => $fname, 
            'last_name' => $lname,
            'city' => $cityname,
            'line1' => $Address,
            'postal_code' => $postalcode,
            'state' => $state, 
            'personal_id_number' => $presnalid,
//            'idProof' => $idproof,
            'acc_id' => $stripeId,
            'verify' => 0);

        if(isset($_FILES['myfile'])){
            $name = $_FILES['myfile']['name'];
            $ext = substr($name, strrpos($name, '.') + 1);
            $dat = getdate();
            $dp = "PAY_" . $dat['year'] . $dat['mon'] . $dat['mday'] . $dat['hours'] . $dat['minutes'] . $dat['seconds'] . "." . $ext;
            $tmp1 = $_FILES['myfile']['tmp_name'];
            if (move_uploaded_file($tmp1, $target_dir . $dp)) {
                $idproof  = $dp;//= $userRecord['idProof']
            }
        }
//        $data = $this->mongo_db->get_one('bankingDetails',array('u_id' => $id));
//        if (count($data) > 0) {
//            $this->mongo_db->update('bankingDetails', $userRecord, array('u_id' => $id));
//        } else {
//            $this->mongo_db->insert('bankingDetails',$userRecord);
//        }
        
        
                
        $stripe = new StripeModuleNew();
        
        $res = $stripe->apiStripe('updateAccountInfo', $userRecord);
        if ($res['error']) {
//                  $arr = json_decode($res['error']['e']['httpBody'], true);
            $errorObj = $res['error']['e'];
            $array = array('flag' => 1, 'msg' => $errorObj->jsonBody['error']['message'], 'status' => "while updateing account Info", 'fullres' => $res);
            return $array;
        }
        
        $verification = $stripe->apiStripe('IdentifyiVerification', array('acc_id' => $stripeId, 'IdProoF' => $target_dir . $idproof));
        if ($verification['flag'] == 1) {
            $array = array('flag' => 1, 'msg' => $verification['msg'], 'status' => "while updateing Bank Idproof", 'fullres' => $verification);
            return $array;
        }
        
        return array("error" => "0");
    }
    
    function getbookinginfo() {
        $stripe = new StripeModuleNew();
        $stripeId = $this->input->post('stripeId');
        $GetUser = array();
        if($stripeId != ''){
            $GetUser = $stripe->apiStripe('RetriveStripConnectAccount', array('accountId' => $stripeId));
//            echo json_encode($GetUser);
        }
//        $id = $this->input->post("id");
//        $GetUser = $this->mongo_db->get_one('bankingDetails',array('u_id' => $id));
//        if(count($data)>0){
//            if($GetUser['verify'] == 0){
//                
//            }
//        }
        echo json_encode($GetUser);
    }
}

?>
