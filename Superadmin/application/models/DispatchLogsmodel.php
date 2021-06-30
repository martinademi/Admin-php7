<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

//require_once $_SERVER['DOCUMENT_ROOT'] . '/superadmin/application/models/S3.php';

class DispatchLogsmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('CallAPI');
        $this->load->library('mongo_db');
    }

    function datatable($stDate = '', $endDate = '') {



        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "providerName";
        $_POST['mDataProp_1'] = "bookingId";
        $_POST['mDataProp_2'] = "customerName";
        $_POST['mDataProp_3'] = "driverName";


       

       
        $sl = $_POST['iDisplayStart'] + 1;

        $timeOffSet=($this->session->userdata('timeOffset') * 60);
        if ($stDate && $endDate) {
            $strtTimeOff=(strtotime($stDate . '00:00:00')+$timeOffSet );
            $endTimeOff=(strtotime($endDate . ' 23:59:59') +$timeOffSet);          

            $respo = $this->datatables->datatable_mongodb('dispatchLogs', array('dispatchedByServerAt' => array('$gte' => $strtTimeOff, '$lte' =>  $endTimeOff)),'',-1);
        } else {
            $respo = $this->datatables->datatable_mongodb('dispatchLogs',array(),'',-1);
        }

        //echo '<pre>';print_r( $respo);die;

       // $respo = $this->datatables->datatable_mongodb('dispatchLogs',array(),'',-1);

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) { 
            $arr = array();

          
            if ($value['bookingType'] == 1) {
                $bookingtype = "now";
            } else if ($value['bookingType'] == 2) {
                $bookingtype = "scheduled";
            }
            if ($value['serviceType'] == 1) {
                $servicetype = "Delivery";
            } else if ($value['serviceType'] == 2) {
                $servicetype = "Pick UP";
            }
            if ($value['dispatchMode'] == 1) {
                $dispatchMode = "Manual";
            } else if ($value['dispatchMode'] == 2) {
                $dispatchMode = "Automatic";
            }else{
                $dispatchMode = '--';
            }
            
            // $arr[] = $sl++;
            // $arr[] = ($value['bookingId']!="")?$value['bookingId']:'N/A';
            // $arr[] = $bookingtype;
            // $arr[] = $servicetype;
            // $arr[] = $dispatchMode;
            // $arr[] = $value['providerName'];
            // $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="'.$value['customerId'].'">'.$value['customerName'].'</a>';
            // $arr[] = '<a style="cursor: pointer;" id="driverID' . $value['driverId']['$oid'] . '"  class="getDriverDetails" mas_id="' . $value['driverId']['$oid'] . '">' . $value['driverName'] . '</a>';
            // $arr[] = date('j-M-Y g:i:s A',$value['dispatchedByServerAt']);
            // $arr[] = ($value['ackTime'] == '')? 'N/A' : date('j-M-Y g:i:s A',$value['ackTime']);
            // $arr[] = ($value['responseTime'] == '')? 'N/A' : date('j-M-Y g:i:s A',$value['responseTime']);
            // $arr[] = date('j-M-Y g:i:s A',$value['expiryTimestamp']);
            // $arr[] = $value['statusMsg'];

           // $arr[] = $sl++;
            $arr[] = ($value['dispatcherId']!="")?$value['dispatcherId']:'N/A';
            $arr[] = ($value['bookingId']!="")?$value['bookingId']:'N/A';
            $arr[] = ($value['orderCategory']!="")?$value['orderCategory']:'N/A';            
            $arr[] = $dispatchMode;
            $arr[] = $servicetype;
            $arr[] = $bookingtype;
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="'.$value['customerId'].'">'.$value['customerName'].'</a>';
            $arr[] =  $value['providerName'];
            $arr[] =  '<a style="cursor: pointer;" id="driverID' . $value['driverId']['$oid'] . '"  class="getDriverDetails" mas_id="' . $value['driverId']['$oid'] . '">' . $value['driverName'] . '</a>';
            $arr[] = date('j-M-Y g:i:s A',$value['dispatchedByServerAt'] - $timeOffSet);
            $arr[] = ($value['ackTime'] == '')? 'N/A' : date('j-M-Y g:i:s A',$value['ackTime'] - $timeOffSet);
            $arr[] = ($value['responseTime'] == '')? 'N/A' : date('j-M-Y g:i:s A',$value['responseTime'] - $timeOffSet);
            $arr[] = date('j-M-Y g:i:s A',$value['expiryTimestamp'] - $timeOffSet);
            $arr[] = $value['statusMsg'];
            $arr[] = 'N/A';

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function getCityList() {
        $getAll = $this->mongo_db->get('cities');
        return $getAll;
    }

}

?>
