<?php

class StripeFeeds_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
//        $this->load->library('mongo_db');
//        $this->load->database();
        $this->load->library('CallAPI');
    }

    function datatable_stripeFeeds($stdate = '', $enddate = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


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

        if ($stdate != '' && $enddate != '')
            $respo = $this->datatables->datatable_mongodb('stripeCharges', array("chargeDate" => array('$gte' => strtotime($stdate), '$lte' => strtotime($enddate . ' 23:59:59'))));
        else
            $respo = $this->datatables->datatable_mongodb('stripeCharges');

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $status = '';
            if ($value['captured'] == FALSE) {
                if ($value['refund'] == TRUE)
                    $status = date('j-M-Y g:i A', $value['refundDate']) . '<br><span style="color:#5bc0de;font-weight:600;">Refund</span>';
                else
                    $status = date('j-M-Y g:i A', $value['chargeDate']) . '<br><span style="color:red;font-weight:600;">Authorized</span>';
            } else
                $status = date('j-M-Yg:i A', $value['captureDate']) . '<br><span style="color:#1ABB9C;font-weight:600;">Received</span>';

            $arr = array();
            $arr[] = '<a style="cursor: pointer;" target="_blank" href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['bid'] . '">' . $value['bid'] . '</a>';
            $arr[] = date('j-M-Y g:i A', $value['chargeDate']);
            $arr[] = $value['customerId'];
            $arr[] = $value['name'];
            $arr[] = $value['phone'];

            $arr[] = $value['chargeId'];
            $arr[] = $value['amount'];
            $arr[] = $value['cardType'];
            $arr[] = '**** **** **** '.$value['card'];
            $arr[] = $status;

            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

}
