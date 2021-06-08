<?php

class StripeFeeds_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
      //  $this->load->library('mongo_db');
      //  $this->load->database();
        $this->load->library('CallAPI');
		  $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
    }

    function datatable_stripeFeeds($stdate = '', $enddate = '') {
      


        //Serachable feilds
        $_POST['iColumns'] = 8;
        $_POST['mDataProp_0'] = "bid";
        $_POST['mDataProp_1'] = "name";
        $_POST['mDataProp_2'] = "customerId";
        $_POST['mDataProp_3'] = "cardId";
        $_POST['mDataProp_4'] = "chargeId";
        $_POST['mDataProp_5'] = "cardType";
        $_POST['mDataProp_6'] = "card";
        $_POST['mDataProp_7'] = "phone";

        if ($stdate != '' && $enddate != ''){
            $respo = $this->datatables->datatable_mongodb('stripeCharges', array("chargeDate" => array('$gte' => strtotime($stdate), '$lte' => strtotime($enddate . ' 23:59:59'))));
        }else{
            $respo = $this->datatables->datatable_mongodb('stripeCharges');
		}
        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $status = '';
            if ($value['captured'] == FALSE) {
                if ($value['refund'] == TRUE)
                    $status =  date('d-M-Y h:i:s a ', ($value['refundDate']) - ($this->session->userdata('timeOffset') * 60)) . '<br><span style="color:#5bc0de;font-weight:600;">Refund</span>';
                else
                    $status =  date('d-M-Y h:i:s a ', ($value['chargeDate']) - ($this->session->userdata('timeOffset') * 60)). '<br><span style="color:red;font-weight:600;">Authorized</span>';
            } else
                $status = date('d-M-Y h:i:s a ', ($value['captureDate']) - ($this->session->userdata('timeOffset') * 60)) . '<br><span style="color:#1ABB9C;font-weight:600;">Received</span>';

            $arr = array();
            $arr[] = ($value['bookingId']=="")?"N/A":'<a style="cursor: pointer;" target="_blank" href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['bookingId'] . '">' . $value['bookingId'] . '</a>';
            $arr[] = date('d-M-Y h:i:s a ', ($value['chargeDate']) - ($this->session->userdata('timeOffset') * 60));
            $arr[] = ($value['customerId'] == "")?"N/A":$value['customerId'];
            $arr[] = ($value['customerName'] == "")?"N/A":$value['customerName'];
            $arr[] = ($value['customerPhone'] == "" )?"N/A":$value['customerPhone'];
            $arr[] = ($value['chargeId'] == "")?"N/A":$value['chargeId'];
            $arr[] = ($value['amount'] == "")?"N/A": $value['amount'];
            $arr[] = $value['brand'];
            $arr[] = '**** **** **** '.$value['last4'];
            $arr[] = $value['status'];

            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

}
