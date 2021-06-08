<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

require_once 'S3.php';

//require_once 'StripeModuleNew.php';

class DriverAcceptanceRate_modal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
//        $this->load->library('mongo_db');
//        $this->load->database();
        $this->load->library('CallAPI');
    }

    function datatable_totalBookings($driverID = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "slaveName";
        $_POST['mDataProp_2'] = "slavemobile";

        $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('dispatched.DriverId' => new MongoDB\BSON\ObjectID($driverID)));


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $receivedDate = '';
            foreach ($value['dispatched'] as $dispatched) {
                if ($dispatched['DriverId']['$oid'] == $value['mas_id']['$oid']) {
                    $receivedDate = date('j-M-Y H:i:s', $dispatched['Received_Act_serverTime']);
                    break;
                }
            }

            $arr = array();
            $arr[] = $value['order_id'];
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slave_id']['$oid'] . '">' . $value['slaveName'] . '</a>';

            $arr[] = $value['slavemobile'];
            $arr[] = ($receivedDate != '') ? $receivedDate : 'N/A';
            $arr[] = ($value['receivers'][0]['DriverAcceptedTime'] != '0' && $value['receivers'][0]['DriverAcceptedTime'] != '') ? date('j-M-Y H:i:s', $value['receivers'][0]['DriverAcceptedTime']) : 'N/A';

            $arr[] = unserialize(JobStatus)[$value['status']];
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_acceptedBookings($driverID = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "slaveName";
        $_POST['mDataProp_2'] = "slavemobile";

        $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('mas_id' => new MongoDB\BSON\ObjectID($driverID), 'status' => array('$ne' => 4), 'dispatched.Status' => 'Accepted'));


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $receivedDate = '';
            foreach ($value['dispatched'] as $dispatched) {
                if ($dispatched['DriverId']['$oid'] == $value['mas_id']['$oid']) {
                    $receivedDate = date('j-M-Y H:i:s', $dispatched['Received_Act_serverTime']);
                    break;
                }
            }

            $arr = array();
            $arr[] = $value['order_id'];
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slave_id']['$oid'] . '">' . $value['slaveName'] . '</a>';

            $arr[] = $value['slavemobile'];
            $arr[] = ($receivedDate != '') ? $receivedDate : 'N/A';
            $arr[] = ($value['receivers'][0]['DriverAcceptedTime'] != '0' && $value['receivers'][0]['DriverAcceptedTime'] != '') ? date('j-M-Y H:i:s', $value['receivers'][0]['DriverAcceptedTime']) : 'N/A';

            $arr[] = unserialize(JobStatus)[$value['status']];
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_rejectedBookings($driverID = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "slaveName";
        $_POST['mDataProp_2'] = "slavemobile";


        $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('dispatched.DriverId' => new MongoDB\BSON\ObjectID($driverID), 'dispatched.Status' => 'Rejected'));


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $receivedDate = '';
            $rejectedDate = '';
            foreach ($value['dispatched'] as $dispatched) {
                if ($dispatched['DriverId']['$oid'] == $value['mas_id']['$oid']) {
                    $receivedDate = date('j-M-Y H:i:s', $dispatched['Received_Act_serverTime']);
                    $rejectedDate = date('j-M-Y H:i:s', $dispatched['rejectedTime']);
                    break;
                }
            }

            $arr = array();
            $arr[] = $value['order_id'];
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slave_id']['$oid'] . '">' . $value['slaveName'] . '</a>';

            $arr[] = $value['slavemobile'];
            $arr[] = ($receivedDate != '') ? $receivedDate : 'N/A';
            $arr[] = ($rejectedDate != '') ? $rejectedDate : 'N/A';

            $arr[] = unserialize(JobStatus)[$value['status']];
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_cancelledBookings($driverID = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "slaveName";
        $_POST['mDataProp_2'] = "slavemobile";


        $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('status' => 4, 'dispatched.DriverId' => new MongoDB\BSON\ObjectID($driverID), 'dispatched.Status' => 'Accepted'));


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $receivedDate = '';
            $cancelledDate = '';
            foreach ($value['dispatched'] as $dispatched) {
                if ($dispatched['DriverId']['$oid'] == $value['mas_id']['$oid']) {
                    $receivedDate = date('j-M-Y H:i:s', $dispatched['Received_Act_serverTime']);
                    $cancelledDate = date('j-M-Y H:i:s', $dispatched['serverTime']);
                    break;
                }
            }

            $arr = array();
            $arr[] = $value['order_id'];
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slave_id']['$oid'] . '">' . $value['slaveName'] . '</a>';

            $arr[] = $value['slavemobile'];
            $arr[] = ($receivedDate != '') ? $receivedDate : 'N/A';
            $arr[] = ($cancelledDate != '') ? $cancelledDate : 'N/A';

            $arr[] = unserialize(JobStatus)[$value['status']];
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_didNotRespondBookings($driverID = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "slaveName";
        $_POST['mDataProp_2'] = "slavemobile";


        $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('dispatched.DriverId' => new MongoDB\BSON\ObjectID($driverID), 'dispatched.Status' => 'Received But Didn\'t Respond'));


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $receivedDate = '';
            foreach ($value['dispatched'] as $dispatched) {
                if ($dispatched['DriverId']['$oid'] == $driverID) {
                    $receivedDate = date('j-M-Y H:i:s', $dispatched['Received_Act_serverTime']);
                    break;
                }
            }
            
            $arr = array();
            $arr[] = $value['order_id'];
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slave_id']['$oid'] . '">' . $value['slaveName'] . '</a>';

            $arr[] = $value['slavemobile'];
            $arr[] = ($receivedDate != '') ? $receivedDate : 'N/A';

            $arr[] = unserialize(JobStatus)[$value['status']];
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function getDriverData($driverID = '') {

        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($driverID)))->find_one('masters');
        return $data;
    }

}
