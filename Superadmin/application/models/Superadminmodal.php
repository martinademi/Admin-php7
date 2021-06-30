<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

require_once 'S3.php';

//require __DIR__.'../../../vendor/autoload.php';//Composer installed
//require_once 'StripeModuleNew.php';

class Superadminmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
//        $this->load->library('mongo_db');
//        $this->load->database();
        $this->load->library('CallAPI');
        $this->load->model("Home_m");
    }

    function datatable_DriverAcceptanceRate() {
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');


        //Serachable feilds
        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "firstName";
        $_POST['mDataProp_1'] = "lastName";
        $_POST['mDataProp_2'] = "mobile";
        $_POST['mDataProp_3'] = "email";
        $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [2, 3, 4])));

        $aaData = $respo["aaData"];
        $datatosend = array();
        $slno = 0;

        foreach ($aaData as $res) {
            if ($res['driverType'] == 1) {
                $res['driverType'] = "Freelancer";
            } else {
                $res['driverType'] = "Operator";
            }

            $Accepted = $this->mongo_db->where(array('mas_id' => new MongoDB\BSON\ObjectID($res['_id']['$oid']), 'status' => array('$ne' => 4), 'dispatched.Status' => 'Accepted'))->count('ShipmentDetails');
            $Rejected = $this->mongo_db->where(array('dispatched.DriverId' => new MongoDB\BSON\ObjectID($res['_id']['$oid']), 'dispatched.Status' => 'Rejected'))->count('ShipmentDetails');
            $Cancelled = $this->mongo_db->where(array('status' => 4, 'dispatched.DriverId' => new MongoDB\BSON\ObjectID($res['_id']['$oid']), 'dispatched.Status' => 'Accepted'))->count('ShipmentDetails');
            $NotReceiced = $this->mongo_db->where(array('dispatched.DriverId' => new MongoDB\BSON\ObjectID($res['_id']['$oid']), 'dispatched.Status' => 'Received But Didn\'t Respond'))->count('ShipmentDetails');

            $grandres = $Accepted + $Rejected + $NotReceiced + $Cancelled;
            $acceptanceRate = 0;
            if ($grandres != 0)
                $acceptanceRate = number_format(($Accepted / $grandres) * 100, 2);

            $arr = array();
            $arr[] = '<a style="cursor: pointer;" id="driverID' . $res['_id']['$oid'] . '"  class="getDriverDetails" mas_id="' . $res['_id']['$oid'] . '">' . $res['firstName'] . ' ' . $res['lastName'] . '</a>';
            $arr[] = $res['mobile'];
            $arr[] = $res['email'];
            $arr[] = $res['driverType'];
            $arr[] = '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/DriverAcceptanceRate_controller/totalBookings/' . $res['_id']['$oid'] . '">' . $grandres . '</a>';
            $arr[] = '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/DriverAcceptanceRate_controller/acceptedBookings/' . $res['_id']['$oid'] . '">' . $Accepted . '</a>';
            $arr[] = '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/DriverAcceptanceRate_controller/rejectedBookings/' . $res['_id']['$oid'] . '">' . $Rejected . '</a>';
            $arr[] = '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/DriverAcceptanceRate_controller/cancelledBookings/' . $res['_id']['$oid'] . '">' . $Cancelled . '</a>';
            $arr[] = '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/DriverAcceptanceRate_controller/didNotRespondBookings/' . $res['_id']['$oid'] . '">' . $NotReceiced . '</a>';
            $arr[] = $acceptanceRate;
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function get_dispatchers_data($status = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->get_where('dispatcher', array('status' => $status));
        return $res;
    }

    function getStoreZones($status = '') {
        $this->load->library('mongo_db');
        $val = $this->input->post("val");

        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->find_one('zones');

        $entities = array();
        $entities = '<option value="">Select Store</option>';

        foreach ($res['servicingStores'] as $d) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($d)))->find_one('stores');
            $entities .= '<option data-name="' . implode(',', $result['name']) . '" value="' . $result['_id']['$oid'] . '">' . implode(',', $result['name']) . '</option>';
        }
        echo $entities;
        return $res;
    }

    function getStoreDataBasedOnCity() {
        $this->load->library('mongo_db');
        $cityId = $this->input->post("cityId");

        $res = $this->mongo_db->where(array('cityId' => $cityId, 'status' => 1))->get('stores');
//        print_r($res);die;
        echo json_encode(array('data' => $res));
    }

    function getZonesBasedOnStores() {
        $this->load->library('mongo_db');
        $storeId = $this->input->post("storeId");
        $uniques = array();
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($storeId)))->find_one('stores');
        foreach ($res['serviceZones'] as $zoneId) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($zoneId)))->find_one('zones');
            $uniques[$result['_id']['$oid']] = $result['title'];
        }
//        print_r($uniques);die;

        echo json_encode(array('data' => $uniques));
    }

    function validateSuperAdmin() {
        $this->load->library('mongo_db');
        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $timeOffset = $this->input->post('timeOffset');


        $result = $this->mongo_db->where(array('email' => $email, 'pass' => md5($password)))->find_one('admin_users');    
//        $role = 'Super Admin';
//        if ($result['role'] != $role) {
        $role = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($result['role']['$oid'])))->find_one('admin_roles');
        $role = $role['role_name'];
//        }

        if (count($result) > 0) {

            //Get the token by calling an API for godsview to login

            // $url = APILink . 'dispatcher/token/' . $email . '/' . md5($password);
            // $response = json_decode($this->callapi->CallAPI('GET', $url), true);

            $url = APILink . 'admin/signIn';
            $apiData['email'] =$email;
            $apiData['password'] =  md5($password);
    
            $response = json_decode($this->callapi->CallAPI('POST', $url,$apiData), true);
            $token ="";
            if($response && $response['statusCode'] == 200){
                $token = $response['data']['token'];
            }

            $tablename = 'company_info';
            $LoginId = 'company_id';
            $sessiondata = array(
                'emailid' => $email,
                'password' => $password,
                'LoginId' => $LoginId,
                'adminId' => (string) $result['_id'],   
                'userid' => (string)$result['_id']['$oid'],             
                'profile_pic' => $result['logo'],
                'first_name' => $result['name'],
                'access_rights' => $result['access'],
                'table' => $tablename,
                'city_id' => $result['city'],
                'city' => $result['city'],
                'role' => $role,
                'company_id' => '0',
              //  'godsviewToken' => $response['data']['token'],
                'godsviewToken' =>  $token,
                'validate' => true,
                'superadmin' => '1',
                'mainAdmin' => $result['superadmin'],
                'timeOffset'=>  $timeOffset,
                'emailMask' => $result['emailMask'],
            );

            $this->session->set_userdata($sessiondata);


            return true;
        }

        return false;
    }

    public function dt_customerVerification() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "givenInput";
        $_POST['mDataProp_1'] = "randNumber";


        $respo = $this->datatables->datatable_mongodb('forgotpassword', array('userType' => 1), 'serverTime');


        $aaData = $respo["aaData"];
        $datatosend = array();


        foreach ($aaData as $value) {
            $arr = array();
            $arr[] = $value['email'];
            $arr[] = $value['mobile'];
            $arr[] = $value['randNumber'];
            $arr[] = date('d-m-Y H:i:s', $value['serverTime']);
            $datatosend[] = $arr;
        }


        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function dt_driverVerification() {
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "email";
        $_POST['mDataProp_1'] = "givenInput";
        $_POST['mDataProp_2'] = "randNumber";

        $respo = $this->datatables->datatable_mongodb('forgotpassword', array('userType' => 2), 'serverTime');


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();

            $arr[] = $value['email'];
            $arr[] = $value['mobile'];
            $arr[] = $value['randNumber'];
            $arr[] = date('d-m-Y H:i:s', $value['serverTime']);
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function datatablePaymentCycle() {
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "_id";

        $respo = $this->datatables->datatable_mongodb('paymentCycles', array(), 'timestamp');

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();

            $arr[] = $value['_id'];
            $arr[] = date('d-m-Y H:i:s', $value['startDate']);
            $arr[] = date('d-m-Y H:i:s', $value['endDate']);
            $arr[] = $value['totalRevenue'];
            $arr[] = '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/superadmin/paymentCycleDriversList/' . $value['_id'] . '"  docID="' . $value['_id'] . '">' . $value['drivers'] . '</a>';
            $arr[] = $value['operators'];
            $arr[] = unserialize(PaymentCycleStatus)[$value['status']]; //Defined in config
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function datatable_paymentCycleDriversList($cycleID = '') {
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "mobile";

        $respo = $this->datatables->datatable_mongodb('paymentsProcessed', array('pcId' => $cycleID), 'billed');

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();

            $arr[] = $value['name'];
            $arr[] = $value['mobile'];
            $arr[] = ($value['trips'] != 0) ? '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/superadmin/driverCompletedBookingList/' . $cycleID . '/' . $value['masId']['$oid'] . '">' . $value['trips'] . '</a>' : '0';
            $arr[] = $value['billed'];
            $arr[] = ($value['earnings'] != 0) ? '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/superadmin/driverCompletedBookingList/' . $cycleID . '/' . $value['masId']['$oid'] . '">' . $value['earnings'] . '</a>' : '0';
            $arr[] = ($value['referralEarnings'] != 0) ? '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/superadmin/referralEarningList/' . $cycleID . '/' . $value['masId']['$oid'] . '">' . $value['referralEarnings'] . '</a>' : '0';
            $arr[] = $value['payable'];
            $arr[] = unserialize(PaymentCycleStatus)[$value['paymentStatus']]; //Defined in config

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function licenceplaetno() {
        $this->load->library('mongo_db');

        $licenceplaetno = $this->input->post('licenceplaetno');
        $query = $this->mongo_db->where(array('platNo' => $licenceplaetno))->count('vehicles');

        if ($query > 0) {
            echo json_encode(array('msg' => '1'));
            return;
        } else {
            echo json_encode(array('msg' => '0'));
            return;
        }
    }

    function updateDriverRating() {
        $this->load->library('mongo_db');

        $data['DriverRating.1'] = ($this->input->post('OneStartDesc') == NULL) ? array() : $this->input->post('OneStartDesc');
        $data['DriverRating.2'] = ($this->input->post('SecondStartDesc') == NULL) ? array() : $this->input->post('SecondStartDesc');
        $data['DriverRating.3'] = ($this->input->post('ThirdStarDesc') == NULL) ? array() : $this->input->post('ThirdStarDesc');
        $data['DriverRating.4'] = ($this->input->post('FourthStarDesc') == NULL) ? array() : $this->input->post('FourthStarDesc');
        $data['DriverRating.5'] = ($this->input->post('FiveStartDesc') == NULL) ? array() : $this->input->post('FiveStartDesc');
        $query = $this->mongo_db->where(array())->set($data)->update('appConfig');
        return;
    }

    public function datatable_driverCompletedBookingList($driverID = '', $cycleID = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 7;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "driverDetails.fName";
        $_POST['mDataProp_2'] = "slaveName";
        $_POST['mDataProp_3'] = "address_line1";
        $_POST['mDataProp_4'] = "appointment_dt";
        $_POST['mDataProp_5'] = "drop_addr1";
        $_POST['mDataProp_6'] = "pricingModel";

        $cycledata = $this->getPaymentDetails($cycleID);

        $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('mas_id' => new MongoDB\BSON\ObjectID($driverID), 'completedTimeStamp' => array('$gte' => $cycledata['startDate'], '$lte' => $cycledata['endDate'])));


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            //if zoneType=1 then Long Haul if zoneType=0 then Short Haul
            $collectionName = 'zones';
            if ($value['zoneType'] == '1')
                $collectionName = 'cities';

            if ($value['pickupzoneId'] == '' || $value['pickupzoneId'] == '0' || $value['dorpzoneId'] == '' || $value['dorpzoneId'] == '0') {
                $zoneType = $value['pricingModel'] . '-OZ';
            } else {
                $zoneType = ($value['zoneType'] == '1') ? $value['pricingModel'] . '-' . 'LH' : $value['pricingModel'] . '-' . 'SH';
            }

            //Get pick up zone
            $pickUpZone = '';
            if ($value['pickupzoneId'] != '0' && $value['pickupzoneId'] != '' && $value['pickupzoneId'] != NULL && $value['pickupzoneId'] != 'default')
                $pickUpZone = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['pickupzoneId'])))->find_one($collectionName);

            //Get drop zone
            $dropZone = '';
            if ($value['dorpzoneId'] != '0' && $value['dorpzoneId'] != '' && $value['dorpzoneId'] != NULL && $value['dorpzoneId'] != 'default')
                $dropZone = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['dorpzoneId'])))->find_one($collectionName);

            $pickUpZone = ($value['zoneType'] == '1') ? $pickUpZone['city'] : $pickUpZone['title'];
            $dropZone = ($value['zoneType'] == '1') ? $dropZone['city'] : $dropZone['title'];

            if ($pickUpZone != '')
                $pickUpZoneAndAddr = '(Zone-' . $pickUpZone . ') ' . $value['address_line1'];
            else
                $pickUpZoneAndAddr = '(Zone-Out Zone) ' . $value['address_line1'];

            if ($dropZone != '')
                $dropZoneAndAddr = '(Zone-' . $dropZone . ') ' . $value['drop_addr1'];
            else
                $dropZoneAndAddr = '(Zone-Out Zone) ' . $value['drop_addr1'];

            $arr = array();
            $arr[] = $value['order_id'];
            $arr[] = $value['slaveName'];
            $arr[] = $pickUpZoneAndAddr;
            $arr[] = $dropZoneAndAddr;
            $arr[] = number_format($value['invoice']['distance'], 0);
            $arr[] = $value['invoice']['total'];
            $arr[] = $value['invoice']['masEarning'];
            $arr[] = unserialize(paymentMethod)[$value['payment_type']];
            $arr[] = '<a target="_blank" href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['order_id'] . '"><button type="button" class="btn btn-success"><i class="fa fa-truck" aria-hidden="true"></i>  Show</button></a>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function datatable_referralEarningList($driverID = '', $cycleID = '') {
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 7;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "driverDetails.fName";
        $_POST['mDataProp_2'] = "slaveName";
        $_POST['mDataProp_3'] = "address_line1";
        $_POST['mDataProp_4'] = "appointment_dt";
        $_POST['mDataProp_5'] = "drop_addr1";
        $_POST['mDataProp_6'] = "pricingModel";

        $cycledata = $this->getPaymentDetails($cycleID);

        $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('accouting.MasterReferralEarnings' => array('$exists' => TRUE), 'mas_id' => new MongoDB\BSON\ObjectID($driverID), 'completedTimeStamp' => array('$gte' => $cycledata['startDate'], '$lte' => $cycledata['endDate'])));


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $master = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['accouting']['MasterId'])))->find_one('driver');
            //if zoneType=1 then Long Haul if zoneType=1 then Short Haul
            $collectionName = 'zones';
            if ($value['zoneType'] == '1')
                $collectionName = 'cities';

            if ($value['pickupzoneId'] == '' || $value['pickupzoneId'] == '0' || $value['dorpzoneId'] == '' || $value['dorpzoneId'] == '0') {
                $zoneType = $value['pricingModel'] . '-OZ';
            } else {
                $zoneType = ($value['zoneType'] == '1') ? $value['pricingModel'] . '-' . 'LH' : $value['pricingModel'] . '-' . 'SH';
            }

            //Get pick up zone
            if ($value['pickupzoneId'] != '0' && $value['pickupzoneId'] != '' && $value['pickupzoneId'] != NULL && $value['pickupzoneId'] != 'default')
                $pickUpZone = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['pickupzoneId'])))->find_one($collectionName);

            //Get drop zone
            if ($value['dorpzoneId'] != '0' && $value['dorpzoneId'] != '' && $value['dorpzoneId'] != NULL && $value['dorpzoneId'] != 'default')
                $dropZone = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['dorpzoneId'])))->find_one($collectionName);

            $arr = array();
            $arr[] = $value['order_id'];
            $arr[] = $master['firstName'] . ' ' . $master['lastName'];
            $arr[] = $value['slaveName'];
            $arr[] = $pickUpZone['city'];
            $arr[] = $dropZone['city'];
            $arr[] = number_format($value['invoice']['distance'], 0);
            $arr[] = $value['invoice']['total'];
            $arr[] = $value['accouting']['MasterReferralEarnings'];
            $arr[] = unserialize(paymentMethod)[$value['payment_type']];
            $arr[] = '<a target="_blank" href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['order_id'] . '"><button type="button" class="btn btn-success"><i class="fa fa-truck" aria-hidden="true"></i>  Show</button></a>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function getPaymentDetails($cycleID = '') {
        $this->load->library('mongo_db');
        return $this->mongo_db->where(array('_id' => $cycleID))->find_one('paymentCycles');
    }

    public function exportPaymentCycle($cycleID = '') {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('pcId' => $cycleID))->order_by(array('_id' => -1))->get('paymentsProcessed');
        $arr = array();
        foreach ($data as $row)
            $arr[] = array('Driver Name' => $row['name'], 'Driver Phone' => $row['mobile'], 'Completed Trips' => $row['trips'], 'Total Billing' => $row['billed'], 'Driver Earnings' => $row['earnings'], 'Referral Earnings' => $row['referralEarnings'], 'Net Receivable' => $row['receiveable'], 'Payment Status' => unserialize(PaymentCycleStatus)[$row['paymentStatus']]);

        return $arr;
    }

    //Manage Access
    function get_roles($param = '') {
        $this->load->library('mongo_db');
        if ($param == '')
            $res = $this->mongo_db->get('admin_roles');
        else
            $res = $this->mongo_db->get_one('admin_roles', array('_id' => new MongoId($param)));


        return $res;
    }

    function role_action() {
        $this->load->library('mongo_db');
        $edit_id = $this->input->post('edit_id');
        $fdata = $this->input->post('fdata');
        if ($edit_id == '') {

            $fdata['_id'] = new MongoDB\BSON\ObjectID();

            $this->mongo_db->insert('admin_roles', $fdata);
            echo json_encode(array('msg' => '1', 'insert' => (String) $fdata['_id'], 'access' => $fdata['access']));
            die;
        } else {
            $this->mongo_db->update('admin_roles', $fdata, array('_id' => new MongoDB\BSON\ObjectID($edit_id)));
            echo json_encode(array('msg' => '1', 'insert' => '0', 'access' => $fdata['access']));
            die;
        }
        echo json_encode(array('msg' => '0'));
    }

    function get_users($param = '') {
        $this->load->library('mongo_db');
        if ($param == '')
            $res = $this->mongo_db->get_where('admin_users', array('superadmin' => array('$exists' => false)));
        else
            $res = $this->mongo_db->get_one('admin_users', array('_id' => new MongoId($param)));
        return $res;
    }

    function delete_role() {
        $this->load->library('mongo_db');
        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id'))))->delete('admin_roles');
        $this->mongo_db->where(array('role' => new MongoDB\BSON\ObjectID($this->input->post('id'))))->delete('admin_users');
        echo json_encode(array('msg' => '1'));
    }

    function delete_user() {
        $this->load->library('mongo_db');
        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id'))))->delete('admin_users');
        echo json_encode(array('msg' => '1'));
    }

    function forgotPasswordFromadmin() {
        $this->load->library('mongo_db');
        $email = $this->input->post('email');
        $result = $this->mongo_db->get_one('admin_users', array('email' => $email));

        if ($result['role'] != '') {
            $randNum = substr($result['name'], 0, 3) . mt_rand(1000, 99999);
            $this->emailForResetPasswordForadmin($result['email'], $result['name'], $randNum);
            $this->mongo_db->update('admin_users', array('pass' => md5($randNum)), array('email' => $email));
            echo json_encode(array('flag' => 0, 'msg' => 'New password sent to ' . $email));
            return;
        } else {
            echo json_encode(array('flag' => 1, 'msg' => 'Entered email id doesnot exist in database'));
            return;
        }
    }

    function user_action() {
        $this->load->library('mongo_db');
        $edit_id = $this->input->post('edit_id');
        $fdata = $this->input->post('fdata');
        $fdata['role'] = new MongoDB\BSON\ObjectID($fdata['role']);

        foreach ($fdata['access'] as $key => $val) {
            $fdata['access'][$key] = (int) $val;
        }

       
        

        if(!isset($fdata['emailMask'])){
            $fdata['emailMask']="off";
        }

       

        if ($edit_id == '') {
            $fdata['role'] = new MongoDB\BSON\ObjectID($fdata['role']);
            $fdata['pass'] = md5($fdata['pass']);
            $this->mongo_db->insert('admin_users', $fdata);
//            echo json_encode(array('msg' => '1', 'insert' => $edit_id));
//            die;
        } else {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->set($fdata)->update('admin_users');
//            echo json_encode(array('msg' => '1', 'insert' => '0'));
//            die;
        }
        redirect(base_url() . "index.php?/superadmin/manageRole");
    }

    

    function upload_images_on_amazon() {
        $name = $_FILES['OtherPhoto']['name']; // filename to get file's extension
        $size = $_FILES['OtherPhoto']['size'];

        $fold_name = $_REQUEST['folder'];
        $type = $_REQUEST['type'];

        $ext = substr($name, strrpos($name, '.') + 1);

//       $reducedImage = $this->compress($name,$name,90);
//       
//       echo getimagesize($reducedImage);
//       exit();



        $dat = getdate();
        $rename_file = "file" . $dat['year'] . $dat['mon'] . $dat['mday'] . $dat['hours'] . $dat['minutes'] . $dat['seconds'] . "." . $ext;
        $flag = FALSE;

        $tmp1 = $_FILES['OtherPhoto']['tmp_name'];

        $uploadFile = $tmp1;
        $bucketName = bucketName;

        if (!file_exists($uploadFile) || !is_file($uploadFile)) {
            echo 'if-1';
            exit("\nERROR: No such file: $uploadFile\n\n");
        }
        if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll')) {
            exit("\nERROR: CURL extension not loaded\n\n");
        }

        if (AMAZON_AWS_ACCESS_KEY == 'change-this' || AMAZON_AWS_AUTH_SECRET == 'change-this') {
            exit("\nERROR: AWS access information required\n\nPlease edit the following lines in this file:\n\n" .
                    "define('AMAZON_AWS_ACCESS_KEY', 'change-me');\ndefine('AMAZON_AWS_AUTH_SECRET', 'change-me');\n\n");
        }


        // Instantiate the class
        $s3 = new S3(AMAZON_AWS_ACCESS_KEY, AMAZON_AWS_AUTH_SECRET);


        //// Put our file (also with public read access)
        if ($s3->putObjectFile($uploadFile, $bucketName, $type . '/' . $fold_name . '/' . $rename_file, S3::ACL_PUBLIC_READ)) {
            $flag = true;
        }

        if ($flag) {
            echo json_encode(array('msg' => '1', 'fileName' => $bucketName . '/' . $type . '/' . $fold_name . '/' . $rename_file));
        } else {
            echo json_encode(array('msg' => '2', 'folder' => $fold_name));
        }
        return;
    }

    
    function getCitiesList() {
        $this->load->library('mongo_db');

        $cities = $this->mongo_db->get('cities');
        echo "<option value=''>Select</option>";
        foreach ($cities as $city) {
            echo "<option value='" . $city['_id']['$oid'] . "'>" . $city['city'] . "</option>";
        }

        return;
    }

    function getZoneCity() {
        $this->load->library('mongo_db');
        $city_id = $this->input->post('city_id');
        $zoneData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($city_id)))->find_one('cities');

//        foreach ($zoneData as $res)
//            $c = $res['city'];

        echo json_encode(array('city' => $zoneData['city'], 'id' => $zoneData['_id']['$oid'], 'country' => $zoneData['country']));
        return;
    }

    function getCityZones() {
        $this->load->library('mongo_db');
        $this->load->library('table');
        $city_id = $this->input->post('city_id');
        $zoneData = $this->mongo_db->where(array('city_ID' => $city_id))->get('zones');

        echo json_encode(array('data' => $zoneData));
        return;
    }

    function vehicleTypeData() {
        $this->load->library('mongo_db');
        $vehicleTypes = $this->mongo_db->get('vehicleTypes');
        return $vehicleTypes;
    }

    function getGoodTypes() {
        $this->load->library('mongo_db');
        $selectedGoodTypes = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('vehicleTypeID'))))->find_one('vehicleTypes');
        $allGoodTypes = $this->mongo_db->get('Driver_specialities');

        echo json_encode(array('allGoodTypes' => $allGoodTypes, 'vehicleTypGoodTypes' => $selectedGoodTypes['goodTypes']));
        return;

    }

    function getVehicleModel() {
        $this->load->library('mongo_db');
        $vehicleModel = $this->mongo_db->where(array('Makeid' => new MongoDB\BSON\ObjectID($this->input->post('adv'))))->get('vehicleModel');
        echo "<option value=''>Select</option>";
        foreach ($vehicleModel as $model) {
            echo "<option value='" . $model['_id']['$oid'] . "' name='" . $model['Name'] . "'>" . $model['Name'] . "</option>";
        }
    }

    function getAllGoodTypes() {
        $this->load->library('mongo_db');
        $allGoodTypes = $this->mongo_db->get('Driver_specialities');
        return $allGoodTypes;
    }

    function get_appointment_details() {
        $this->load->library('mongo_db');
        $ShipmentDetails = $this->mongo_db->where(array('order_id' => (int) $this->input->post('order_id')))->find_one('ShipmentDetails');

        $ShipmentDetails['paymentType'] = unserialize(paymentMethod)[$ShipmentDetails['payment_type']];
        $ShipmentDetails['pickUpTime'] = date('j-M-Y H:i:s', $ShipmentDetails['receivers'][0]['DriverLoadedStartedTime']);
        //if zoneType=1 then Long Haul if zoneType=0 then Short Haul
        $collectionName = 'zones';
        if ($ShipmentDetails['zoneType'] == '1')
            $collectionName = 'cities';

        $ShipmentDetails['attemptCount'] = count($ShipmentDetails['dispatched']);

        $ShipmentDetails['estimateId'] = '<a style="cursor: pointer;" class="showEstimatedFareDetials" bid="' . $value['order_id'] . '" estimateFare="' . $value['accouting']['estimateFare'] . '" estimatedTime="' . $value['accouting']['time'] . '">' . $value['accouting']['estimateId'] . '</a>';
        $ShipmentDetails['masName'] = '<span id="driverID' . $value['_id']['$oid'] . '" style="color:indianred;font-weight:600;">Unassigned</span>';
        if ($ShipmentDetails['driverDetails']['fName'])
            $ShipmentDetails['masName'] = '<a style="cursor: pointer;" id="driverID' . $ShipmentDetails['_id']['$oid'] . '"  class="getDriverDetails" mas_id="' . $ShipmentDetails['mas_id']['$oid'] . '">' . $ShipmentDetails['driverDetails']['fName'] . '</a>';

        $ShipmentDetails['pickUpTime'] = date('j-M-Y h:i:s A', $ShipmentDetails['receivers'][0]['DriverLoadedStartedTime']);

        //Get pick up zone
        if ($ShipmentDetails['pickupzoneId'] != '0' && $ShipmentDetails['pickupzoneId'] != '' && $ShipmentDetails['pickupzoneId'] != NULL && $ShipmentDetails['pickupzoneId'] != 'default')
            $pickUpZone = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($ShipmentDetails['pickupzoneId'])))->find_one($collectionName);

        //Get drop zone
        if ($ShipmentDetails['dorpzoneId'] != '0' && $ShipmentDetails['dorpzoneId'] != '' && $ShipmentDetails['dorpzoneId'] != NULL && $ShipmentDetails['dorpzoneId'] != 'default')
            $dropZone = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($ShipmentDetails['dorpzoneId'])))->find_one($collectionName);

        echo json_encode(array('shipmentData' => $ShipmentDetails, 'pickUpZone' => ($ShipmentDetails['zoneType'] == '1') ? $pickUpZone['city'] : $pickUpZone['title'], 'dropZone' => ($ShipmentDetails['zoneType'] == '1') ? $dropZone['city'] : $dropZone['title']));
        return;
    }

    function insert_vehicle_price($param1 = '', $param2 = '') {
        $this->load->library('mongo_db');
        $this->load->library('mongo_db');
        $vehiclePrice = $this->input->post('price');
//        $insertArr[$param2] = $vehiclePrice;

        $this->mongo_db->update('zones', array('zones_price.' . $param2 => $vehiclePrice), array('_id' => new MongoId($param1)));
//         $this->mongo_db->updatewithpush('zones',array('zones_price'=>$insertArr),array('_id' =>new MongoId($param1))); 

        return;
    }

    function getCustomerName($id) {
        $this->load->library('mongo_db');

        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('slaves');
        return $res['name'];
    }

    function zones_data($param1 = '') {
        $this->load->library('mongo_db');
        if ($param1 == '')
            $res = $this->mongo_db->get('zones');
        else
            $res = $this->mongo_db->get_where('zones', array('city_ID' => $param1));
        return $res;
    }

    function zones_specific_data($param1 = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param1)))->find_one('zones');

        return $res;
    }

    function zone_name($param1 = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param1)))->find_one('zones');

        return $res['title'];
    }

    function deleteZone() {
        $this->load->library('mongo_db');
        $zone_id = $this->input->post('zone_id');
        foreach ($zone_id as $id)
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('isDeleted' => TRUE))->update('cities');
//          $this->mongo_db->where(array('_id'=>new MongoDB\BSON\ObjectID($id)))->delete('cities');

        echo json_encode(array('msg' => 'City/cities deleted..!'));
        return;
    }

    
    function getZoneCities() {
        $this->load->library('mongo_db');
        $city_id = $this->input->post('city_id');
        $this->load->library('mongo_db');

        $res = $this->mongo_db->get('zones', array('city' => $city_id));

        $data = array();
        foreach ($res as $r) {
            $data [] = $r;
        }

        return $data;
    }

    function NotificationData() {
        $city_id = $this->input->post('city_id');
        $this->load->library('mongo_db');

        $dbinstance = $this->mongo_db->get_where('AdminNotifications', array('city' => $city_id));

        foreach ($dbinstance as $res)
            $dataInprocess[] = $res;

        $datatosend = array();
        $Mas_ids = array();

        foreach ($dataInprocess as $res) {

            $City_name = $this->db->query("select * from city_available where City_Id ='" . $res['city'] . "'")->row_array();
            foreach ($res['user_ids'] as $a)
                $Mas_ids [] = $a;


            $mas_ids = implode(',', array_filter(array_unique($Mas_ids)));

            if ($res['user_type'] == 1) {
                $d = $this->db->query("select * from master where mas_id in (" . $mas_ids . ")")->result();
                foreach ($d as $row) {
                    $datatosend[] = array('city_name' => $City_name['City_Name'], 'user_type' => $res['user_type'], 'dname' => $row->first_name, 'demail' => $row->email, 'dmobile' => $row->mobile, 'ddate' => $res['DateTime'], 'msg' => $res['msg'], 'city_id' => $res['city'], 'd_id' => $row->mas_id);
                }
            } else {
                $d = $this->db->query("select * from slave where slave_id in (" . $mas_ids . ")")->result();
                foreach ($d as $row) {
                    $datatosend[] = array('city_name' => $City_name['City_Name'], 'user_type' => $res['user_type'], 'dname' => $row->first_name, 'pemail' => $row->email, 'pmobile' => $row->phone, 'pdate' => $res['DateTime'], 'msg' => $res['msg'], 'city_id' => $res['city'], 'p_id' => $row->slave_id);
                }
            }
        }

        function compareByName($a, $b) {
            return strcmp($a["dname"], $b["dname"]);
        }

        usort($datatosend, 'compareByName');

        return $datatosend;
    }

    function cityForZones() {
        $this->load->library('mongo_db');
        $cityData = $this->mongo_db->get('cities');
        return $cityData;
    }

    function cityforZonesNew() {
        $this->load->library('mongo_db');
        $cityData = $this->mongo_db->get('cities');
        $arr = array();

        foreach ($cityData as $data) {

            foreach ($data['cities'] as $ciity) {
                $dat = array();
                $dat['cityId'] = $ciity['cityId']['$oid'];
                $dat['cityName'] = $ciity['cityName'];
                $arr[] = $dat;
            }
        }
        return $arr;
    }

    function cityForZonesData($id = '') {
        $this->load->library('mongo_db');
        $cityId = $this->input->post('cityId');
        $uniques = array();
        $uniques1 = array();
        if($id){
        $getData = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($id)))->find_one('driver');
        $cityId = $getData['cityId'];
        }
        
//        print_r($cityId);die;
        if ($cityId) {
            $cityData1 = $this->mongo_db->where(array('city_ID' => $cityId,'status'=>1))->get('zones');
            foreach ($cityData1 as $obj) {
                $uniques[$obj['_id']['$oid']] = $obj['title'];
            }
            if($id){
                return $uniques;
            }else{
                echo json_encode(array('data' => $uniques));
            }
            
        } else {
            $cityData1 = $this->mongo_db->get('zones');
            foreach ($cityData1 as $obj) {
                $uniques[$obj['_id']['$oid']] = $obj['title'];
            }
            return $uniques;
        }
    }

    function city_get() {
        $this->load->library('mongo_db');
        $cityData = $this->mongo_db->where(array('isDeleted' => FALSE))->get('cities');
        return $cityData;
    }

    function updateOperating_zones() {
        $this->load->library('mongo_db');
        $insertArr = array('title' => ucwords(strtolower($this->input->post('title'))), 'points' => $this->input->post('points'), 'pointsProps' => $this->input->post('pointsProps'));
        $this->mongo_db->insert('Opearting_zone', $insertArr);
        echo json_encode(array('msg' => 'Operating zone is updated', 'flag' => 0));
        return;
    }

    function getCities_zone($param = '') {
        $this->load->library('mongo_db');
        if ($param == '') {
            $return = $this->mongo_db->get('cities');
            foreach ($return['cities'] as $city) {
                $res = array();
                if ($city['isDeleted'] == FALSE) {
                    $res[] = $city;
                }
            }
            return $res;
        } else
            return $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->find_one('cities');
    }

    function getSpecificCities_zone($param = '') {

        $this->load->library('mongo_db');
        return $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->find_one('cities');
    }

    function getOperating_zone() {
        $this->load->library('mongo_db');
        return $this->mongo_db->get('Opearting_zone');
    }

    function getOperating_zones() {
        $this->load->library('mongo_db');
        echo json_encode($this->mongo_db->get('Opearting_zone'));
    }

//    function tripDetails($param) {
//        $this->load->library('mongo_db');
//        $data['res'] = $this->mongo_db->where(array('order_id' => (int) $param))->find_one('completedOrders');
//
//        $data['appConfig'] = $this->mongo_db->find_one('appConfig');
//        $tarr = array();
////        foreach ($tarrm as $value) {
//        foreach ($data['res']['appRouts'] as $val) {
//            $tarr[$val['subid']] = json_decode($val['ent_shipment_latlogs']);
//        }
////        }
//        $data['trip_route'] = $tarr;
//
//        $url = APILink . 'dispatcher/tasks/livePath/' . $param; //GET /dispatcher/tasks/livePath/{bid}
//        $r = $this->callapi->CallAPI('GET', $url);
//        $jsonResponse = json_decode($r, true);
////        print_r($jsonResponse);die;
//        $data['pickUpLatLong'] = $data['res']['pickup_location'];
//        $data['dropLatLong'] = $data['res']['drop_location'];
//
//        $data['appRoute'] = $jsonResponse;
//
////        $type_id = $data['res']['vehicleType'][0]['_id']['$oid'];
////        $data['car_data'] = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($type_id)))->find_one('ShipmentDetails');
//
//        return $data;
//    }


    function tripDetails($param) {
        $this->load->library('mongo_db');
        $data['res'] = $this->mongo_db->where(array('orderId' => (int) $param))->find_one('completedOrders');

        $data['appConfig'] = $this->mongo_db->find_one('appConfig');
        $tarr = array();
//        foreach ($tarrm as $value) {
        foreach ($data['res']['appRouts'] as $val) {
            $tarr[$val['subid']] = json_decode($val['ent_shipment_latlogs']);
        }

        $data['trip_route'] = $tarr;

        $data['pickUpLatLong'] = $data['res']['pickup_location'];
        $data['dropLatLong'] = $data['res']['drop_location'];

        $data['appRoute'] = $jsonResponse;

        return $data;
    }

    function getAllUsersForPlan() {
        $this->load->library('mongo_db');
        $planId = $this->input->post('id');
        foreach ($planId as $pid)
            $planIDS[] = new MongoDB\BSON\ObjectID($pid);

        $result = $this->mongo_db->where(array('planID' => array('$in' => $planIDS)))->count('driver');

        echo json_encode(array('driversCount' => $result));
        return;
    }

    function getComapnyDetails() {
        $this->load->library('mongo_db');
        $operatorData = $this->mongo_db->get_where('operators', array('_id' => new MongoDB\BSON\ObjectID($this->input->post('companyID'))));

        echo json_encode(array("data" => $operatorData));
        return;
    }

    function checkeDriverIsOnTrip() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        $result = 0;
        foreach ($val as $id) {
            $result += $this->mongo_db->where(array('vehicleId' => new MongoDB\BSON\ObjectID($id), 'onJob' => TRUE))->count('driver');
        }

        echo json_encode(array('msg' => "These driver are in trip", 'driverOnTrip' => $result));
        return;
    }

    function enDisCreditCustomer() {
        $this->load->library('mongo_db');
        $slave_id = $this->input->post('slave_id');

        $appConfig = $this->mongo_db->find_one('appConfig');

        $setCreditEn = ($this->input->post('flag') == 1) ? TRUE : FALSE;


        if ($setCreditEn) {

            $customerData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($slave_id)))->find_one('slaves');

            //Update the default app config credit soft and hard limit if it not set yet
            if (!isset($customerData['walletSoftLimit']) && !isset($customerData['walletHardLimit']))
                $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($slave_id)))->set(array('setCreditEnable' => $setCreditEn, 'walletSoftLimit' => $appConfig['walletSettings']['softLimitShipper'], 'walletHardLimit' => $appConfig['walletSettings']['hardLimitShipper']))->update('slaves');
            else
                $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($slave_id)))->set(array('setCreditEnable' => $setCreditEn))->update('slaves');
        }else {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($slave_id)))->set(array('setCreditEnable' => $setCreditEn))->update('slaves');
        }


        if ($result) {
            $status = 54;
            if ($setCreditEn)
                $status = 53;

            //Sending a push
            $url = APILink . 'wallet/walletConfiguration';
            $r = $this->callapi->CallAPI('POST', $url, array('userId' => $slave_id, 'userType' => 2, 'status' => $status));

            echo json_encode(array('msg' => "Success", 'flag' => 1));
            return;
        }
    }

    function enDisCreditDriver() {
        $this->load->library('mongo_db');
        $mas_id = $this->input->post('mas_id');
        $appConfig = $this->mongo_db->find_one('appConfig');

        $setCreditEn = ($this->input->post('flag') == 1) ? TRUE : FALSE;
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mas_id)))->set(array('setCreditEnable' => $setCreditEn))->update('driver');

        if ($setCreditEn) {

            $masterData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mas_id)))->find_one('driver');

            //Update the default app config credit soft and hard limit if it not set yet
            if (!isset($masterData['walletSoftLimit']) && !isset($masterData['walletHardLimit']))
                $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mas_id)))->set(array('setCreditEnable' => $setCreditEn, 'walletSoftLimit' => $appConfig['walletSettings']['softLimitDriver'], 'walletHardLimit' => $appConfig['walletSettings']['hardLimitDriver']))->update('driver');
            else
                $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mas_id)))->set(array('setCreditEnable' => $setCreditEn))->update('driver');
        }else {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mas_id)))->set(array('setCreditEnable' => $setCreditEn))->update('driver');
        }

        if ($result) {
            $status = 54;
            if ($setCreditEn)
                $status = 53;

            //Sending a push
            $url = APILink . 'wallet/walletConfiguration';
            $r = $this->callapi->CallAPI('POST', $url, array('userId' => $mas_id, 'userType' => 1, 'status' => $status));

            echo json_encode(array('msg' => "Success", 'flag' => 1));
            return;
        }
    }

    function acceptdrivers($id, $company_id, $planID, $planName, $operatorName, $operatorId, $storeName, $storeId, $planActiveDate, $zoneIds, $ban, $cityId, $cityName) {
        $this->load->library('mongo_db');

        $masterData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('driver');
        if ($operatorId) {

            if (isset($masterData['planActivedOn']) && $masterData['planActivedOn'] != '')
                $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 8, 'statusMsg' => "logged out", 'planName' => $planName, 'planID' => new MongoDB\BSON\ObjectID($planID), 'operatorId' => $operatorId, 'operatorName' => $operatorName, 'zoneIds' => $zoneIds, 'driverType' => 2))->update('driver');
            else
                $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 8, 'statusMsg' => "logged out", 'driverType' => 2, 'planActivedOn' => strtotime($planActiveDate), 'planName' => $planName, 'planID' => new MongoDB\BSON\ObjectID($planID), 'operatorId' => $operatorId, 'operatorName' => $operatorName, 'zoneIds' => $zoneIds))->update('driver');
        }

        if ($storeId) {
            if (isset($masterData['planActivedOn']) && $masterData['planActivedOn'] != '')
                $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 8, 'statusMsg' => "logged out"))->update('driver');
            else
                $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 8, 'statusMsg' => "logged out"))->update('driver');
        }

        if ($storeId == '' && $operatorId == '' || $storeId == null && $operatorId == null) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array( 'planName' => $planName, 'planID' => new MongoDB\BSON\ObjectID($planID),'status' => 8, 'statusMsg' => "logged out", 'driverType' => 1, "approvedTimeStamp" => time(), "approvedISODate" => $this->mongo_db->date($timestamp)))->update('driver');
        }
//            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 2))->update('driver');
        if ($result) {

            //Sending an email
            if ($ban == 'bannedToActive') {
                $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('driver');
                $dat = array('name' => $getData['firstName'] . ' ' . $getData['lastName'], 'userId' => $id, 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['mobile'], 'status' => 10, 'reason1' => ($getData['reason'] == '') ? "N/A" : $getData['reason']);
                $url = APILink . 'admin/email';
                $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
            } else {
                $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('driver');
                $dat = array('name' => $getData['firstName'] . ' ' . $getData['lastName'], 'userId' => $id, 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['mobile'], 'status' => 7, 'reason1' => ($getData['reason'] == '') ? "N/A" : $getData['reason']);
                $url = APILink . 'admin/email';
                $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
            }
            echo json_encode(array('msg' => "Selected driver/drivers accepted succesfully", 'flag' => 0));
            return;
        } else
            echo json_encode(array('msg' => "Failed to update", 'flag' => 1));
    }

    //Manually logout the driver from admin panel
    function driver_logout() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
    
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->set(array('status' => 8, 'statusMsg' => "logged out"))->update('driver');
            $urlLogout = APILink . 'admin/operations';
            $this->callapi->CallAPI('POST', $urlLogout, array('userId' => $val, 'status' => 5));
        

        echo json_encode(array('msg' => "Your selected driver/drivers loggedout succesfully", 'flag' => 1));
    }

    function makeDriverOffline() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
       
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->set(array('status' => 4, 'statusMsg' => "offline"))->update('driver');
            $urloffline = APILink . 'admin/operations';
            $this->callapi->CallAPI('POST', $urloffline, array('userId' => $val, 'status' => 4));
        

        echo json_encode(array('msg' => "Your selected driver/drivers offline succesfully", 'flag' => 1));
    }

    function banDrivers() {
        $this->load->library('mongo_db');
        $ids = $this->input->post('val');
        $reason = $this->input->post('reason');

        $val = $this->input->post('val');

        foreach ($val as $mas_ids) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mas_ids)))->set(array('status' => 7, 'statusMsg' => 'banned', 'bannedOn' => time(), 'reason' => $reason))->update('driver');
            $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mas_ids)))->find_one('driver');
            $dat = array('name' => $getData['firstName'] . ' ' . $getData['lastName'], 'userId' => $mas_ids, 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['mobile'], 'status' => 3, 'reason1' => ($getData['reason'] == '') ? "N/A" : $getData['reason']);
            $url = APILink . 'admin/email';
            $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        }
        echo json_encode(array('msg' => "Selected have been banned succesfully", 'flag' => 1));
    }

    function rejectdrivers() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        $reason = $this->input->post('reason');
//        print_r($reason);die;
        foreach ($val as $mas_ids) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mas_ids)))->set(array('status' => 6, 'statusMsg' => 'rejected','reason'=>$reason ,'rejectedOn' => (int) $this->input->post('date')))->update('driver');
            $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mas_ids)))->find_one('driver');
            $dat = array('name' => $getData['firstName'] . ' ' . $getData['lastName'], 'userId' => $mas_ids, 'email' => $getData['email'], 'mobile' => $getData['countryCode'] . $getData['mobile'], 'status' => 4, 'reason1' => (!isset($getData['rejectReason']) || $getData['rejectReason'] == '') ? "N/A" : $getData['rejectReason']);
            $url = APILink . 'admin/email';
            $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        }
        if ($result) {
            echo json_encode(array('msg' => "Selected driver/drivers rejected succesfully", 'flag' => 0));
//                   $this->sendMailToDriverAfterAccept($email, $firstname);
            return;
        } else
            echo json_encode(array('msg' => "Failed to update", 'flag' => 1));
    }

    function get_ongoing_bookings() {
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
        $selecttb = $db->selectCollection('ShipmentDetails');
        $allDocs = array();

        $city = $this->session->userdata('city_id');
        $company = $this->session->userdata('company_id');


        foreach ($query as $appData) {

            $find = $selecttb->find(array('order_id' => (int) $appData->appointment_id));

            foreach ($find as $shipment) {

                foreach ($shipment['receivers'] as $reciver) {

                    $allDocs[] = array('sub_id' => $reciver['subid'], 'appointment_id' => $appData->appointment_id, 'mas_id' => $appData->mas_id, 'first_name' => $appData->first_name, 'dphone' => $appData->dphone, 'mobile' => $appData->mobile, 'pessanger_fname' => $appData->pessanger_fname, 'phone' => $appData->phone, 'appointment_dt' => $appData->appointment_dt, 'address_line1' => $appData->address_line1, 'drop_addr1' => $appData->drop_addr1, 'status' => $appData->status, 'address' => $reciver['address']);
                }
            }
        }

        return $allDocs;
    }

    function sendAndroidPush($tokenArr, $andrContent, $apiKey) {

        $fields = array(
            'registration_ids' => $tokenArr,
            'data' => $andrContent,
        );

        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );
// Open connection
        $ch = curl_init();

// Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, 'http://android.googleapis.com/gcm/send');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

// Execute post
        $result = curl_exec($ch);

        curl_close($ch);
//        echo 'Result from google:' . $result . '---';
        $res_dec = json_decode($result);

        if ($res_dec->success >= 1)
            return array('errorNo' => 44, 'result' => $result);
        else
            return array('errorNo' => 46, 'result' => $result);
    }

    function editdriverpassword() {
        $this->load->library('mongo_db');
        $newpass1 = $this->input->post('newpass');
        $val = $this->input->post('val');
        $password1 = password_hash($newpass1, PASSWORD_BCRYPT);
        $newpass = str_replace("$2y$", "$2a$", $password1);

        $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->find_one('driver');
        $dat = array('name' => $getData['firstName'] . ' ' . $getData['lastName'], 'userId' => $val, 'email' => $getData['email'], 'password' => $newpass1, 'mobile' => $getData['countryCode'] . $getData['mobile'], 'status' => 16, 'reason1' => ($getData['reason'] == '') ? "N/A" : $getData['reason']);
        $url = APILink . 'admin/email';
        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->set(array('password' => $newpass))->update('driver');


        if ($result) {
            echo json_encode(array('msg' => "New password has benn updated succesfully", 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => "Failed to update the password", 'flag' => 1));
            return;
        }
    }

    function editsuperpassword() {
        $this->load->library('mongo_db');
        $newpass = $this->input->post('newpass');
        $email = $this->session->userdata('emailid');
        $currentpassword = $this->input->post('currentpassword');

        $this->load->library('mongo_db');
        $admin_users = $this->mongo_db->get_one('admin_users', array('email' => $email, 'pass' => md5($currentpassword)));

        if ($admin_users['email']) {
            $this->mongo_db->update('admin_users', array("pass" => md5($newpass)));
            echo json_encode(array('msg' => "Your new password updated has been updated successfully", 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => "Incorrect current password", 'flag' => 1));
            return;
        }
    }

    function getDriversCountForStore() {
        $this->load->library('mongo_db');

        $driverType = $this->session->userdata('operatorType');
        $operator = $this->session->userdata('company_id');
        $plan = $this->session->userdata('plan');
        $store = $this->session->userdata('storeId');


        $data['New'] = $this->mongo_db->where(array('status' => 1, 'driverType' => 2))->count('driver');
        $data['Approved'] = $this->mongo_db->where(array('driverType' => 2, 'status' => array('$in' => [2, 3, 4, 8, 9])))->count('driver');
        $data['Rejected'] = $this->mongo_db->where(array('driverType' => 2, 'status' => 6))->count('driver');
        $data['Banned'] = $this->mongo_db->where(array('driverType' => 2, 'status' => 7))->count('driver');
        $data['timedOut'] = $this->mongo_db->where(array('driverType' => 2, 'status' => 9))->count('driver');


        $data['Accepted'] = $this->mongo_db->where(array('driverType' => 2, 'status' => array('$in' => [3, 4])))->count('driver');
        $data['Inactive'] = $this->mongo_db->where(array('driverType' => 2, 'status' => array('$in' => [2, 7])))->count('driver');
       
        
        $data['Online'] = $this->mongo_db->where(array('driverType' => 2, 'status' => 3))->count('driver');
        $data['offline'] = $this->mongo_db->where(array('driverType' => 2, 'status' => 4))->count('driver');
        $data['loggedOut'] = $this->mongo_db->where(array('driverType' => 2, 'status' => 8))->count('driver');
        


        // switch ($driverType) {

        //     case '':
        //         if ($plan == '') {

        //             $data['New'] = $this->mongo_db->where(array('status' => 1, 'driverType' => 2))->count('driver');
        //             $data['Approved'] = $this->mongo_db->where(array('driverType' => 2, 'status' => array('$in' => [2, 3, 4, 8, 9])))->count('driver');
        //             $data['Accepted'] = $this->mongo_db->where(array('driverType' => 2, 'status' => array('$in' => [3, 4])))->count('driver');
        //             $data['Inactive'] = $this->mongo_db->where(array('driverType' => 2, 'status' => array('$in' => [2, 7])))->count('driver');
        //             $data['Rejepted'] = $this->mongo_db->where(array('driverType' => 2, 'status' => 6))->count('driver');
        //             $data['Banned'] = $this->mongo_db->where(array('driverType' => 2, 'status' => 7))->count('driver');
        //             $data['Online'] = $this->mongo_db->where(array('driverType' => 2, 'status' => 3))->count('driver');
        //             $data['offline'] = $this->mongo_db->where(array('driverType' => 2, 'status' => 4))->count('driver');
        //             $data['loggedOut'] = $this->mongo_db->where(array('driverType' => 2, 'status' => 8))->count('driver');
        //             $data['timedOut'] = $this->mongo_db->where(array('driverType' => 2, 'status' => 9))->count('driver');
        //         } else {


        //             $data['New'] = $this->mongo_db->where(array('status' => 1, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
        //             $data['Approved'] = $this->mongo_db->where(array('status' => array('$in' => [2, 3, 4, 8, 9]), 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
        //             $data['Accepted'] = $this->mongo_db->where(array('status' => array('$in' => [3, 4]), 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
        //             $data['Inactive'] = $this->mongo_db->where(array('status' => array('$in' => [2, 7]), 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
        //             $data['Rejepted'] = $this->mongo_db->where(array('status' => 6, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
        //             $data['Banned'] = $this->mongo_db->where(array('status' => 7, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
        //             $data['Online'] = $this->mongo_db->where(array('status' => 3, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
        //             $data['offline'] = $this->mongo_db->where(array('status' => 4, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
        //             $data['loggedOut'] = $this->mongo_db->where(array('status' => 8, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
        //             $data['timedOut'] = $this->mongo_db->where(array('status' => 9, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
        //         }
        //         break;

        //     case '3':
        //         if ($store == '') {


        //             $data['New'] = $this->mongo_db->where(array('status' => 1, 'driverType' => 2))->count('driver');
        //             $data['Approved'] = $this->mongo_db->where(array('status' => array('$in' => [2, 3, 4, 8, 9]), 'driverType' => 2))->count('driver');
        //             $data['Accepted'] = $this->mongo_db->where(array('status' => array('$in' => [3, 4]), 'driverType' => 2))->count('driver');
        //             $data['Inactive'] = $this->mongo_db->where(array('status' => array('$in' => [2, 7]), 'driverType' => 2))->count('driver');
        //             $data['Rejepted'] = $this->mongo_db->where(array('status' => 6, 'driverType' => 2))->count('driver');
        //             $data['Banned'] = $this->mongo_db->where(array('status' => 7, 'driverType' => 2))->count('driver');
        //             $data['Online'] = $this->mongo_db->where(array('status' => 3, 'driverType' => 2))->count('driver');
        //             $data['offline'] = $this->mongo_db->where(array('status' => 4, 'driverType' => 2))->count('driver');
        //             $data['loggedOut'] = $this->mongo_db->where(array('status' => 8, 'driverType' => 2))->count('driver');
        //             $data['timedOut'] = $this->mongo_db->where(array('status' => 9, 'driverType' => 2))->count('driver');
        //         } else {


        //             $data['New'] = $this->mongo_db->where(array('status' => 1, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
        //             $data['Approved'] = $this->mongo_db->where(array('status' => array('$in' => [2, 3, 4, 8, 9]), 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
        //             $data['Accepted'] = $this->mongo_db->where(array('status' => array('$in' => [3, 4]), 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
        //             $data['Inactive'] = $this->mongo_db->where(array('status' => array('$in' => [2, 7]), 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
        //             $data['Rejepted'] = $this->mongo_db->where(array('status' => 6, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
        //             $data['Banned'] = $this->mongo_db->where(array('status' => 7, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
        //             $data['Online'] = $this->mongo_db->where(array('status' => 3, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
        //             $data['offline'] = $this->mongo_db->where(array('status' => 4, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
        //             $data['loggedOut'] = $this->mongo_db->where(array('status' => 8, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
        //             $data['timedOut'] = $this->mongo_db->where(array('status' => 9, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
        //         }

        //         break;
        // }


        echo json_encode(array('data' => $data));
        return;
    }

    function getDriversCount() {
        $this->load->library('mongo_db');

        $driverType = $this->session->userdata('operatorType');
        $operator = $this->session->userdata('company_id');
        $plan = $this->session->userdata('plan');
        $store = $this->session->userdata('storeId');



        switch ($driverType) {

            case '':
                if ($plan == '') {

                    $data['New'] = $this->mongo_db->where(array('status' => 1, 'driverType' => 1))->count('driver');
                    $data['Approved'] = $this->mongo_db->where(array('driverType' => 1, 'status' => array('$in' => [3, 4, 5, 9, 8])))->count('driver');
                    $data['Accepted'] = $this->mongo_db->where(array('driverType' => 1, 'status' => array('$in' => [3, 4])))->count('driver');
                    $data['Inactive'] = $this->mongo_db->where(array('driverType' => 1, 'status' => array('$in' => [2, 7])))->count('driver');
                    $data['Rejepted'] = $this->mongo_db->where(array('driverType' => 1, 'status' => 6))->count('driver');
                    $data['Banned'] = $this->mongo_db->where(array('driverType' => 1, 'status' => 7))->count('driver');
                    $data['Online'] = $this->mongo_db->where(array('driverType' => 1, 'status' => 3))->count('driver');
                    $data['offline'] = $this->mongo_db->where(array('driverType' => 1, 'status' => 4))->count('driver');
                    $data['loggedOut'] = $this->mongo_db->where(array('driverType' => 1, 'status' => 8))->count('driver');
                    $data['timedOut'] = $this->mongo_db->where(array('driverType' => 1, 'status' => 9))->count('driver');
                } else {
//                    $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1, 'planID' => new MongoDB\BSON\ObjectID($plan)));

                    $data['New'] = $this->mongo_db->where(array('status' => 1, 'driverType' => 1, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
                    $data['Approved'] = $this->mongo_db->where(array('status' => array('$in' => [3, 4, 5, 9, 8]), 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
                    $data['Accepted'] = $this->mongo_db->where(array('status' => array('$in' => [3, 4]), 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
                    $data['Inactive'] = $this->mongo_db->where(array('status' => array('$in' => [2, 7]), 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
                    $data['Rejepted'] = $this->mongo_db->where(array('status' => 6, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
                    $data['Banned'] = $this->mongo_db->where(array('status' => 7, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
                    $data['Online'] = $this->mongo_db->where(array('status' => 3, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
                    $data['offline'] = $this->mongo_db->where(array('status' => 4, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
                    $data['loggedOut'] = $this->mongo_db->where(array('status' => 8, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
                    $data['timedOut'] = $this->mongo_db->where(array('status' => 9, 'planID' => new MongoDB\BSON\ObjectID($plan)))->count('driver');
                }
                break;
            case '1':
//                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1, 'driverType' => 1));

                $data['New'] = $this->mongo_db->where(array('status' => 1, 'driverType' => 1))->count('driver');
                $data['Approved'] = $this->mongo_db->where(array('status' => array('$in' => [2, 3, 4, 8, 9]), 'driverType' => 1))->count('driver');
                $data['Accepted'] = $this->mongo_db->where(array('status' => array('$in' => [3, 4]), 'driverType' => 1))->count('driver');
                $data['Inactive'] = $this->mongo_db->where(array('status' => array('$in' => [2, 7]), 'driverType' => 1))->count('driver');
                $data['Rejepted'] = $this->mongo_db->where(array('status' => 6, 'driverType' => 1))->count('driver');
                $data['Banned'] = $this->mongo_db->where(array('status' => 7, 'driverType' => 1))->count('driver');
                $data['Online'] = $this->mongo_db->where(array('status' => 3, 'driverType' => 1))->count('driver');
                $data['offline'] = $this->mongo_db->where(array('status' => 4, 'driverType' => 1))->count('driver');
                $data['loggedOut'] = $this->mongo_db->where(array('status' => 8, 'driverType' => 1))->count('driver');
                $data['timedOut'] = $this->mongo_db->where(array('status' => 9, 'driverType' => 1))->count('driver');

                break;
//            case '2':
//                if ($operator == '') {
////                    $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1, 'driverType' => 2));
//
//                    $data['New'] = $this->mongo_db->where(array('status' => 1, 'driverType' => 2))->count('driver');
//                    $data['Approved'] = $this->mongo_db->where(array('status' => array('$in' => [2, 3, 4, 8, 9]), 'driverType' => 2))->count('driver');
//                    $data['Accepted'] = $this->mongo_db->where(array('status' => array('$in' => [3, 4]), 'driverType' => 2))->count('driver');
//                    $data['Inactive'] = $this->mongo_db->where(array('status' => array('$in' => [2, 7]), 'driverType' => 2))->count('driver');
//                    $data['Rejepted'] = $this->mongo_db->where(array('status' => 6, 'driverType' => 2))->count('driver');
//                    $data['Banned'] = $this->mongo_db->where(array('status' => 7, 'driverType' => 2))->count('driver');
//                    $data['Online'] = $this->mongo_db->where(array('status' => 3, 'driverType' => 2))->count('driver');
//                    $data['offline'] = $this->mongo_db->where(array('status' => 4, 'driverType' => 2))->count('driver');
//                    $data['loggedOut'] = $this->mongo_db->where(array('status' => 8, 'driverType' => 2))->count('driver');
//                    $data['timedOut'] = $this->mongo_db->where(array('status' => 9, 'driverType' => 2))->count('driver');
//                } else {
////                    $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1, 'driverType' => 2, 'companyId' => new MongoDB\BSON\ObjectID($operator)));
//
//                    $data['New'] = $this->mongo_db->where(array('status' => 1, 'driverType' => 2, 'companyId' => new MongoDB\BSON\ObjectID($operator)))->count('driver');
//                    $data['Approved'] = $this->mongo_db->where(array('status' => array('$in' => [2, 3, 4, 8, 9]), 'driverType' => 2, 'companyId' => new MongoDB\BSON\ObjectID($operator)))->count('driver');
//                    $data['Accepted'] = $this->mongo_db->where(array('status' => array('$in' => [3, 4]), 'driverType' => 2, 'companyId' => new MongoDB\BSON\ObjectID($operator)))->count('driver');
//                    $data['Inactive'] = $this->mongo_db->where(array('status' => array('$in' => [2, 7]), 'driverType' => 2, 'companyId' => new MongoDB\BSON\ObjectID($operator)))->count('driver');
//                    $data['Rejepted'] = $this->mongo_db->where(array('status' => 6, 'driverType' => 2, 'companyId' => new MongoDB\BSON\ObjectID($operator)))->count('driver');
//                    $data['Banned'] = $this->mongo_db->where(array('status' => 7, 'driverType' => 2, 'companyId' => new MongoDB\BSON\ObjectID($operator)))->count('driver');
//                    $data['Online'] = $this->mongo_db->where(array('status' => 3, 'driverType' => 2, 'companyId' => new MongoDB\BSON\ObjectID($operator)))->count('driver');
//                    $data['offline'] = $this->mongo_db->where(array('status' => 4, 'driverType' => 2, 'companyId' => new MongoDB\BSON\ObjectID($operator)))->count('driver');
//                    $data['loggedOut'] = $this->mongo_db->where(array('status' => 8, 'driverType' => 2, 'companyId' => new MongoDB\BSON\ObjectID($operator)))->count('driver');
//                    $data['timedOut'] = $this->mongo_db->where(array('status' => 9, 'driverType' => 2, 'companyId' => new MongoDB\BSON\ObjectID($operator)))->count('driver');
//                }
//
//                break;
//            case '3':
//                if ($store == '') {
////                    $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1, 'driverType' => 2));
//
//                    $data['New'] = $this->mongo_db->where(array('status' => 1, 'driverType' => 3))->count('driver');
//                    $data['Approved'] = $this->mongo_db->where(array('status' => array('$in' => [2, 3, 4, 8, 9]), 'driverType' => 3))->count('driver');
//                    $data['Accepted'] = $this->mongo_db->where(array('status' => array('$in' => [3, 4]), 'driverType' => 3))->count('driver');
//                    $data['Inactive'] = $this->mongo_db->where(array('status' => array('$in' => [2, 7]), 'driverType' => 3))->count('driver');
//                    $data['Rejepted'] = $this->mongo_db->where(array('status' => 6, 'driverType' => 3))->count('driver');
//                    $data['Banned'] = $this->mongo_db->where(array('status' => 7, 'driverType' => 3))->count('driver');
//                    $data['Online'] = $this->mongo_db->where(array('status' => 3, 'driverType' => 3))->count('driver');
//                    $data['offline'] = $this->mongo_db->where(array('status' => 4, 'driverType' => 3))->count('driver');
//                    $data['loggedOut'] = $this->mongo_db->where(array('status' => 8, 'driverType' => 3))->count('driver');
//                    $data['timedOut'] = $this->mongo_db->where(array('status' => 9, 'driverType' => 3))->count('driver');
//                } else {
////                    $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1, 'driverType' => 2, 'companyId' => new MongoDB\BSON\ObjectID($operator)));
//
//                    $data['New'] = $this->mongo_db->where(array('status' => 1, 'driverType' => 3, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
//                    $data['Approved'] = $this->mongo_db->where(array('status' => array('$in' => [2, 3, 4, 8, 9]), 'driverType' => 3, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
//                    $data['Accepted'] = $this->mongo_db->where(array('status' => array('$in' => [3, 4]), 'driverType' => 3, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
//                    $data['Inactive'] = $this->mongo_db->where(array('status' => array('$in' => [2, 7]), 'driverType' => 3, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
//                    $data['Rejepted'] = $this->mongo_db->where(array('status' => 6, 'driverType' => 3, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
//                    $data['Banned'] = $this->mongo_db->where(array('status' => 7, 'driverType' => 3, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
//                    $data['Online'] = $this->mongo_db->where(array('status' => 3, 'driverType' => 3, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
//                    $data['offline'] = $this->mongo_db->where(array('status' => 4, 'driverType' => 3, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
//                    $data['loggedOut'] = $this->mongo_db->where(array('status' => 8, 'driverType' => 3, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
//                    $data['timedOut'] = $this->mongo_db->where(array('status' => 9, 'driverType' => 3, 'storeId' => new MongoDB\BSON\ObjectID($store)))->count('driver');
//                }
//
//                break;
        }


        echo json_encode(array('data' => $data));
        return;
    }

    function getvehicleCount() {
        $this->load->library('mongo_db');
        $data['New'] = $this->mongo_db->where(array('status' => 1))->count('vehicles');
        $data['Accepted'] = $this->mongo_db->where('status', array('$in' => [2, 4, 5]))->count('vehicles');
        $data['Rejepted'] = $this->mongo_db->where(array('status' => 3))->count('vehicles');
        $data['Free'] = $this->mongo_db->where(array('status' => 4))->count('vehicles');
        $data['Assigned'] = $this->mongo_db->where(array('status' => 5))->count('vehicles');

        echo json_encode(array('data' => $data));
        return;
    }

    function getCustomerCount() {
        $this->load->library('mongo_db');
        $data['Accepted'] = $this->mongo_db->where(array('status' => array('$in' => [3, '3'])))->count('slaves');
        $data['Rejepted'] = $this->mongo_db->where(array('status' => array('$in' => [4, '4'])))->count('slaves');
        $data['unregistered'] = $this->mongo_db->where(array('createdBy' => 'dispatcher'))->count('slaves');

        echo json_encode(array('data' => $data));
        return;
    }

    function getBookingCount() {
        $this->load->library('mongo_db');
        //$value['driverDetails']['fName']

        $data['Assigned'] = $this->mongo_db->where(array('status' => array('$in' => [6, 7, 8, 9])))->count('ShipmentDetails');
        $data['Unassigned'] = $this->mongo_db->where(array('status' => array('$in' => [1, 11])))->count('ShipmentDetails');


        echo json_encode(array('data' => $data));
        return;
    }

    function editvehicle($status) {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($status)))->find_one('vehicles');
        return $data;
    }

    function getModel($id) {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('vehicleModel');
        return $data;
    }

//    

    function deactivate_company() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        foreach ($val as $id) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 4))->update('operators');
        }
        if ($result) {
            echo json_encode(array('msg' => "your selected company/companies activated succesfully", 'flag' => 1));
            return;
        }
    }

    function location_data($status = '') {
        $this->load->library('mongo_db');
        $find = $this->mongo_db->where(array('user' => (int) $status))->get('location');
        return $find;
    }

    function insert_vehicletype() {
        $this->load->library('mongo_db');

        $vehicle_length = $this->input->post('vehicle_length') . $this->input->post('vehicle_length_metric');
        $vehicle_width = $this->input->post('vehicle_width') . $this->input->post('vehicle_width_metric');
        $vehicle_height = $this->input->post('vehicle_height') . $this->input->post('vehicle_height_metric');

        $bookingTypeSelected = $this->input->post('bookingTypeSelected');


        $baseFare = $this->input->post('baseFare');
        $mileage_after_x_km_mile = $this->input->post('mileage_after_x_km_mile');
        $mileage_metric = $this->input->post('mileage_metric');
        $mileage_price = $this->input->post('mileage');

        $x_minutesTripDuration = $this->input->post('x_minutesTripDuration');
        $price_after_x_minutesTripDuration = $this->input->post('price_after_x_minutesTripDuration');

        $x_minutesWaiting = $this->input->post('x_minutesWaiting');
        $price_after_x_minWaiting = $this->input->post('price_after_x_minWaiting');

        //On demand bookings
        $x_minutesCancel = $this->input->post('x_minutesCancel');
        $price_after_x_minCancel = $this->input->post('price_after_x_minCancel');


        //Scheduled bookings
        $x_minutesCancelScheduledBookings = $this->input->post('x_minutesCancelScheduledBookings');
        $price_after_x_minCancelScheduledBookings = $this->input->post('price_after_x_minCancelScheduledBookings');


        $x_km_mileMinimumFee = $this->input->post('x_km_mileMinimumFee');
        $price_MinimumFee = $this->input->post('price_MinimumFee');

        $longHaulEnDis = '0';
        if ($this->input->post('longHaulEnDis') == 'on')
            $longHaulEnDis = '1';

        $vehicle_capacity = $this->input->post('vehicle_capacity');

        $vehicletype = $this->input->post('vehicletypename');
        $discription = $this->input->post('descrption');

        $type_on_image = $this->input->post('onImageAWS');
        $type_off_image = $this->input->post('offImageAWS');
        $type_map_image = $this->input->post('mapImageAWS');


        $result = $this->mongo_db->get('vehicleTypes');
        $type_id = 1;
        if (!empty($result)) {
            foreach ($result as $each)
                $type_id = $each['type'];
        }
        $appConfig = $this->mongo_db->find_one('appConfig');

//        if($type_map_image != '')
//        {
        $insertArr = array('bookingType' => $bookingTypeSelected, 'baseFare' => (float) $baseFare, 'mileage_after_x_km_mile' => (int) $mileage_after_x_km_mile, 'type' => (int) $type_id + 1, 'type_name' => $vehicletype, 'vehicle_length' => $vehicle_length, 'vehicle_width' => $vehicle_width, 'vehicle_height' => $vehicle_height, 'vehicle_capacity' => $vehicle_capacity, 'min_fare' => (float) $price_MinimumFee, 'min_distance' => (int) $x_km_mileMinimumFee, 'cancellation_fee' => (float) $price_after_x_minCancel, 'cancenlation_min' => (int) $x_minutesCancel, 'scheduledBookingCancellationMin' => (int) $x_minutesCancelScheduledBookings, 'scheduledBookingCancellationFee' => (float) $price_after_x_minCancelScheduledBookings, 'waiting_time_min' => (int) $x_minutesWaiting, 'waiting_charge' => (float) $price_after_x_minWaiting, 'mileage_price' => (float) $mileage_price, 'mileage_metrc' => ($appConfig['mileage_metric'] == 1) ? 'Mile' : 'Km', "currencySbl" => $appConfig['currencySymbol'], 'weight_metric' => ($appConfig['weight_metric'] == 0) ? 'Kg' : 'Pound', 'xminuts' => $x_minutesTripDuration, 'xmilage' => $price_after_x_minutesTripDuration, 'longHaulEnDis' => (int) $longHaulEnDis, "order" => (int) $type_id, 'type_desc' => $discription,
            "vehicle_img" => $type_on_image, "vehicle_img_off" => $type_off_image, "MapIcon" => $type_map_image, 'goodTypes' => $this->input->post('goodType'), 'order' => (int) $type_id + 1);

//        }  else {
//             $insertArr = array('type' => (int) $type_id+1, 'type_name' => $vehicletype,'vehicle_length'=>$vehicle_length,'vehicle_width'=>$vehicle_width,'vehicle_height'=>$vehicle_height,'vehicle_capacity'=>$vehicle_capacity,'min_fare'=>(float)$price_MinimumFee,'min_distance'=>(int)$x_km_mileMinimumFee,'cancellation_fee'=>(float)$price_after_x_minCancel,'cancenlation_min'=>(int)$x_minutesCancel,'scheduledBookingCancellationMin'=>(int)$x_minutesCancelScheduledBookings,'scheduledBookingCancellationFee'=>(float)$price_after_x_minCancelScheduledBookings,'waiting_time_min'=>(int)$x_minutesWaiting,'waiting_charge'=>(float)$price_after_x_minWaiting,'mileage_price'=>(float)$mileage_price,'mileage_metrc'=>($appConfig['mileage_metric'] == 1)?'Mile':'Km',"currencySbl" =>$appConfig['currencySymbol'],'xminuts'=>$x_minutesTripDuration,'xmilage'=>$price_after_x_minutesTripDuration,'longHaulEnDis'=>(int)$longHaulEnDis,"order" => (int)$type_id,'type_desc' => $discription,
//                "vehicle_img" => $type_on_image, "vehicle_img_off" => $type_off_image, "MapIcon" => '','goodTypes'=>$this->input->post('goodType'));
//           
//        }
        $result = $this->mongo_db->insert('vehicleTypes', $insertArr);

        return;
    }

    function testID() {
        $this->load->library('mongo_db');


        echo date("d-M-Y h:i:s A", 1505413800);
        echo '<br>';
        echo 'End:' . strtotime('2017-09-15 23:59:59');
        echo '<br>';

        $r = $this->mongo_db->where(array('status' => 10, 'timpeStamp_appointment_date' => array('$gte' => 1505413800, '$lte' => strtotime('2017-09-15 23:59:59'))))->count('ShipmentDetails');
        echo $r;
        exit();
//        $result = $this->mongo_db->aggregate('driver', array('$match' => array('status' => array('$in' => [6, 10]))));

        foreach ($result as $r) {
            print_r($r);
        }
//        foreach ($result as $r) {
//            if (isset($r['planID']) && $r['planID'] != '') {
//                $plan = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($r['planID']['$oid'])))->find_one('Driver_plans');
//                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($r['_id']['$oid'])))->set(array('planName' => $plan['plan_name']))->update('driver');
//            }
//        }
//        try {
//            echo 'here';
//            $this->load->library('mongo_db_php7');
//            $r = $this->mongo_db_php7->DbOperations('retrieve', 'verification');
//            var_dump($r);
//        } catch (Exception $ex) {
//            print_r($ex);
//        }
//
//        $manager = new MongoDB\Driver\Manager("mongodb:Dayrunner:ShmdeUGtdbwg5esN@localhost:27017");
//        $bulk = new MongoDB\Driver\BulkWrite;
//        $bulk->find(array('_id' => new MongoDB\BSON\ObjectID('598b14d6c39f45b4313bb0c5')));
//        $result = $manager->executeBulkWrite('Dayrunner.estimates', $bulk);
//        print_r($result);
//       $this->load->library('mongo_db');
//       $result = $this->mongo_db->db->executeQuery('Dayrunner' . '.' .'driver',new MongoDB\Driver\Query(array('_id'=>new MongoDB\BSON\ObjectID('5976e797695489d647455ca1'))),new MongoDB\Driver\ReadPreference(MongoDB\Driver\ReadPreference::RP_PRIMARY));
//            $result = $this->mongo_db->get('cities');
//        foreach ($result as $r)
//        {
//                   
//                $this->mongo_db->where(array('_id'=>new MongoDB\BSON\ObjectID($r['_id']['$oid'])))->set(array('isDeleted'=>FALSE))->update('cities');
//                $this->mongo_db->where(array('status'=>5))->set(array('status'=>1))->update('vehicles');
//        }

        exit();
    }

    function update_vehicletype($param) {
        $this->load->library('mongo_db');
        $bookingTypeSelected = $this->input->post('bookingTypeSelected');

        $vehicle_length = $this->input->post('vehicle_length') . $this->input->post('vehicle_length_metric');
        $vehicle_width = $this->input->post('vehicle_width') . $this->input->post('vehicle_width_metric');
        $vehicle_height = $this->input->post('vehicle_height') . $this->input->post('vehicle_height_metric');

        $baseFare = $this->input->post('baseFare');
        $mileage_metric = $this->input->post('mileage_metric');
        $mileage_price = $this->input->post('mileage');
        $mileage_after_x_km_mile = $this->input->post('mileage_after_x_km_mile');

        $x_minutesTripDuration = $this->input->post('x_minutesTripDuration');
        $price_after_x_minutesTripDuration = $this->input->post('price_after_x_minutesTripDuration');

        //On demand bookings
        $x_minutesWaiting = $this->input->post('x_minutesWaiting');
        $price_after_x_minWaiting = $this->input->post('price_after_x_minWaiting');

        $x_minutesCancel = $this->input->post('x_minutesCancel');
        $price_after_x_minCancel = $this->input->post('price_after_x_minCancel');

        //Scheduled bookings
        $x_minutesCancelScheduledBookings = $this->input->post('x_minutesCancelScheduledBookings');
        $price_after_x_minCancelScheduledBookings = $this->input->post('price_after_x_minCancelScheduledBookings');


        $x_km_mileMinimumFee = $this->input->post('x_km_mileMinimumFee');
        $price_MinimumFee = $this->input->post('price_MinimumFee');



        //Images
        $onImageAWS = $this->input->post('onImageAWS');
        $offImageAWS = $this->input->post('offImageAWS');
        $mapImageAWS = $this->input->post('mapImageAWS');


        $longHaulEnDis = '0';
        if ($this->input->post('longHaulEnDis') == 'on')
            $longHaulEnDis = '1';


        $vehicle_capacity = $this->input->post('vehicle_capacity');

        $vehicletype = $this->input->post('vehicletypename');
        $discription = $this->input->post('descrption');


        $appConfig = $this->mongo_db->find_one('appConfig');


        $update_mongo_data = array('bookingType' => $bookingTypeSelected, 'baseFare' => (float) $baseFare, 'mileage_after_x_km_mile' => (int) $mileage_after_x_km_mile, 'xminuts' => $x_minutesTripDuration, 'xmilage' => $price_after_x_minutesTripDuration, 'type_name' => $vehicletype, 'vehicle_length' => $vehicle_length, 'vehicle_width' => $vehicle_width, 'vehicle_height' => $vehicle_height, 'vehicle_capacity' => $vehicle_capacity, 'min_fare' => (float) $price_MinimumFee, 'min_distance' => (int) $x_km_mileMinimumFee, 'cancellation_fee' => (float) $price_after_x_minCancel, 'cancenlation_min' => (int) $x_minutesCancel, 'scheduledBookingCancellationMin' => (int) $x_minutesCancelScheduledBookings, 'scheduledBookingCancellationFee' => (float) $price_after_x_minCancelScheduledBookings, 'waiting_time_min' => (int) $x_minutesWaiting, 'waiting_charge' => (float) $price_after_x_minWaiting, 'mileage_price' => (float) $mileage_price, 'mileage_metrc' => ($appConfig['mileage_metric'] == 1) ? 'Mile' : 'Km', "currencySbl" => $appConfig['currencySymbol'], 'weight_metric' => ($appConfig['weight_metric'] == 0) ? 'Kg' : 'Pound', 'longHaulEnDis' => (int) $longHaulEnDis, "order" => (int) $type_id, 'type_desc' => $discription,
            'goodTypes' => $this->input->post('goodType'));


        if ($onImageAWS)
            $update_mongo_data['vehicle_img'] = $onImageAWS;

        if ($offImageAWS)
            $update_mongo_data['vehicle_img_off'] = $offImageAWS;

        if ($mapImageAWS)
            $update_mongo_data['MapIcon'] = $mapImageAWS;

        $this->mongo_db->where(array('type' => (int) $param))->set($update_mongo_data)->update('vehicleTypes');

        $vehicleTypeData = $this->mongo_db->where(array('type' => (int) $param))->find_one('vehicleTypes');

        $this->mongo_db->where(array('type_id' => new MongoDB\BSON\ObjectID($vehicleTypeData['_id']['$oid'])))->set(array('type' => $vehicleTypeData['type_name']))->update('vehicles', array('multi' => TRUE));

        return;
    }

    function getMongoVehicleType($param = '') {
        $this->load->library('mongo_db');
        $result = $this->mongo_db->get_where('vehicleTypes', array('type' => (int) $param));
        return $result;
    }

    function getAllVehicleType() {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->get('vehicleTypes');

        echo json_encode(iterator_to_array($res, false), true);
        return;
    }

    function getVehicleTypes() {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->get('vehicleTypes');
        return $res;
    }

    //used in driver page 
    function getAllVehicleTypesForDrivers() {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->get('vehicleTypes');
        echo json_encode(array('data' => $res));
        return $res;
    }

    function long_haul_pricing_set($param = '') {
        $this->load->library('mongo_db');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($param)))->set(array('LongHaulPrice' => $this->input->post('pricing')))->update("cities");
        return;
    }

    function short_haul_pricing_set($param = '') {
        $this->load->library('mongo_db');
        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($param)))->set(array('ShortHaulPrice' => $this->input->post('pricing')))->update("zones");
        return;
    }

    function get_vehiclemake() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->get('vehicleMake');
        return $getAll;
    }

    function getMakeDetails() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id'))))->get('vehicleModel');
        echo json_encode(array('data' => $getAll));
        return;
    }

    function addVehicleMake() {
        $this->load->library('mongo_db');
        $getAllDriversCursor = $this->mongo_db->get_where('vehicleMake', array('Name' => ucfirst(strtolower($this->input->post('typename')))));

        if (!empty($getAllDriversCursor)) {
            echo json_encode(array('msg' => "Brand name already exists", 'flag' => 1));
            return;
        } else {
            $result = $this->mongo_db->insert('vehicleMake', array('Name' => ucfirst(strtolower($this->input->post('typename')))));

            if ($result) {
                echo json_encode(array('msg' => "Brand name inserted successfully", 'flag' => 0));
                return;
            } else {
                echo json_encode(array('msg' => "Failed to insert", 'flag' => 1));
                return;
            }
        }
    }

    function editVehicleMake() {
        $this->load->library('mongo_db');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id'))))->set(array('Name' => ucfirst(strtolower($this->input->post('m_name')))))->update('vehicleMake');

        if ($result) {
            echo json_encode(array('msg' => "Brand name updated", 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => "Failed to insert", 'flag' => 1));
            return;
        }
    }

    function deleteVehicleMake() {
        $this->load->library('mongo_db');
        foreach ($this->input->post('val') as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('vehicleMake');
            $this->mongo_db->where(array('Makeid' => new MongoDB\BSON\ObjectID($id)))->delete('vehicleModel');
        }

        echo json_encode(array('msg' => "Brand name deleted", 'flag' => 0));
        return;
    }

    function addVehicleModel() {
        $this->load->library('mongo_db');
        $getAllDriversCursor = $this->mongo_db->get_where('vehicleModel', array('Name' => ucfirst(strtolower($this->input->post('modal'))), 'Makeid' => new MongoDB\BSON\ObjectID($this->input->post('typeid'))));

        if (!empty($getAllDriversCursor)) {
            echo json_encode(array('msg' => "Brand model already exists", 'flag' => 1));
            return;
        } else {
            $result = $this->mongo_db->insert('vehicleModel', array('Name' => ucfirst(strtolower($this->input->post('modal'))), 'Makeid' => new MongoDB\BSON\ObjectID($this->input->post('typeid'))));

            if ($result) {
                echo json_encode(array('msg' => "Brand model inserted successfully", 'flag' => 0));
                return;
            } else {
                echo json_encode(array('msg' => "Failed to insert", 'flag' => 1));
                return;
            }
        }
    }

    function editVehicleModel() {
        $this->load->library('mongo_db');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('model_id'))))->set(array('Name' => ucfirst(strtolower($this->input->post('model_name'))), 'Makeid' => new MongoDB\BSON\ObjectID($this->input->post('makeID'))))->update('VehicleModel');

        if ($result) {
            echo json_encode(array('msg' => "Brand model updated", 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => "Failed to insert", 'flag' => 1));
            return;
        }
    }

    function deleteVehicleModel() {
        $this->load->library('mongo_db');
        foreach ($this->input->post('id') as $id)
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('vehicleModel');

        echo json_encode(array('msg' => "Brand model deleted", 'flag' => 0));
        return;
    }

    function deletedriver() {
        $this->load->library('mongo_db');
        $masterid = $this->input->post('masterid');
        $affectedRows = 0;
        foreach ($masterid as $id) {
            echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('driver');
        }

        echo json_encode(array("msg" => "Selected driver has been deleted successfully", "flag" => 0));
        return;
    }

    function getAllPlans() {
        $this->load->library('mongo_db');
        $driver = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id'))))->find_one('driver');
        $res = $this->mongo_db->where(array("isDeleted" => false,"cityId" => isset($driver['cityId']) ? $driver['cityId'] : "" ))->get('Driver_plans');
        echo json_encode(array('data' => $res, 'driverData' => $driver));
    }

    function updateNewPlan() {
        $this->load->library('mongo_db');

        $id = $this->input->post('val');
        $planID = $this->input->post('planID');
        $planName = $this->input->post('planName');
        $planActiveDate = $this->input->post('newPlanActiveDate');
        $data = array('id' => new MongoDB\BSON\ObjectID(), 'planName' => $planName, 'planID' => new MongoDB\BSON\ObjectID($planID), 'activatedOn' => strtotime($planActiveDate));
        $dataSpe=array('planID' => new MongoDB\BSON\ObjectID($planID),'planName'=> $planName);
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($dataSpe)->push(array('newPlans' => $data))->update('driver',array('multi'=>TRUE));
        if ($result) {

            //Sending an email
            $url = APILink . 'master/email';
            $r = $this->callapi->CallAPI('POST', $url, array('id' => $id, 'type' => 2));

            echo json_encode(array('msg' => "Selected driver/drivers accepted succesfully", 'flag' => 0));
            return;
        } else
            echo json_encode(array('msg' => "Failed to update", 'flag' => 1));
    }

    function getCityList() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->get('cities');
        return $getAll;
    }

    function insert_company() {

//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';
//        exit();
        $this->load->library('mongo_db');
        $registered = $this->input->post('registered');
        $companyname = $this->input->post('companyname');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $mobile = '+' . $this->input->post('coutry-code') . '-' . $this->input->post('mobilenumber');
        $city = $this->input->post('cityName');
        $countryName = $this->input->post('countryName');
        $state = $this->input->post('state');
        $postcode = $this->input->post('pincode');
        $vatnumber = $this->input->post('vatnumber');
        $logo = $this->input->post('operatorImage');

        $status = 1;


        $result = $this->mongo_db->get('operators');
        $operatorID = 1;
        if (!empty($result)) {
            foreach ($result as $each)
                $operatorID = $each['operatorID'];
        }

        $result = $this->mongo_db->insert('operators', array('registered' => (int) $registered, 'operatorName' => ucfirst(strtolower($companyname)), 'password' => md5($password), 'operatorID' => (int) $operatorID + 1, 'email' => strtolower($email), 'cityID' => $city, 'countryID' => $countryName, 'state' => $state, 'address' => $address, 'postcode' => $postcode, 'vatnumber' => $vatnumber, 'fname' => $firstname, 'lname' => $lastname, 'mobile' => $mobile, 'status' => (int) $status, 'operatorLogo' => $logo));

        return;
    }

    function update_company() {
        $this->load->library('mongo_db');

        $registered = $this->input->post('registered');
        $companyID = $this->input->post('companyID');
        $companyname = $this->input->post('companyname');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $mobile = '+' . $this->input->post('coutry-code') . '-' . $this->input->post('mobilenumber');

        $state = $this->input->post('state');
        $postcode = $this->input->post('pincode');
        $vatnumber = $this->input->post('vatnumber');

        $logo = $this->input->post('operatorImage');

        if ($logo != '')
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($companyID)))->set(array('registered' => (int) $registered, 'operatorName' => ucfirst(strtolower($companyname)), 'email' => strtolower($email), 'state' => $state, 'address' => $address, 'postcode' => $postcode, 'vatnumber' => $vatnumber, 'fname' => $firstname, 'lname' => $lastname, 'mobile' => $mobile, 'operatorLogo' => $logo))->update('operators');
        else
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($companyID)))->set(array('registered' => (int) $registered, 'operatorName' => ucfirst(strtolower($companyname)), 'email' => strtolower($email), 'state' => $state, 'address' => $address, 'postcode' => $postcode, 'vatnumber' => $vatnumber, 'fname' => $firstname, 'lname' => $lastname, 'mobile' => $mobile))->update('operators');

        $result = $this->mongo_db->where(array('operator' => new MongoDB\BSON\ObjectID($companyID)))->set(array('operatorName' => ucfirst(strtolower($companyname))))->update('vehicles', array('multi' => TRUE));

        echo json_encode(array('msg' => "Successfully updated", 'flag' => 1));
        return;
    }

    function activepassengers() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        foreach ($val as $id)
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 3, 'statusMsg' => 'online'))->update('slaves');

        echo json_encode(array('msg' => "Custome have been activated", 'flag' => 0));
        return;
    }

    function insertdispatches() {
        $this->load->library('mongo_db');
        $name = $this->input->post('name');
        $city_name = $this->input->post('city_name');
        $city = $this->input->post('city');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $manager = $this->input->post('manager');
        $managerID = $this->input->post('managerID');
        $status = 1;
        $res = $this->mongo_db->insert('dispatcher', array('managerName' => $manager, 'managerId' => new MongoDB\BSON\ObjectID($managerID), 'name' => $name, 'city' => $city, 'city_name' => $city_name, 'email' => $email, 'password' => md5($password), 'status' => $status));


        if ($res > 0) {
            echo json_encode(array('msg' => '0'));
            return;
        } else {
            echo json_encode(array('msg' => '1'));
            return;
        }
    }

    function getManager($param = '') {

        $this->load->library('mongo_db');
        if ($this->input->post('id') != '') {
            $getallmanager = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id'))))->find_one('Managers');
            echo json_encode(array('data' => $getallmanager));
            return;
        } else {
            $getallmanager = $this->mongo_db->get('Managers');
            return $getallmanager;
        }
    }

    function inactivedispatchers() {
        $this->load->library('mongo_db');
        $status = $this->input->post('val');
        foreach ($status as $row) {

            $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->set(array('status' => 2))->update('dispatcher');
        }
    }

    function activedispatchers() {
        $this->load->library('mongo_db');
        $status = $this->input->post('val');
        foreach ($status as $row) {

            $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->set(array('status' => 1))->update('dispatcher');
        }
    }

    function deletedispatchers() {
        $this->load->library('mongo_db');
        $status = $this->input->post('val');
        foreach ($status as $row) {
//            $result = $this->db->query("delete from dispatcher  where dis_id='" . $row . "'");
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($row)))->delete('dispatcher');
        }
    }

    function editdispatchers() {
        $this->load->library('mongo_db');

        $city_name = $this->input->post('city_name');
        $city = $this->input->post('cityval');
        $val = $this->input->post('val');
        $email = $this->input->post('email');
        $name = $this->input->post('name');
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->set(array('managerName' => $this->input->post('manager'), 'managerId' => new MongoDB\BSON\ObjectID($this->input->post('managerId')), 'city' => $city, 'name' => $name, 'email' => $email, 'city_name' => $city_name))->update('dispatcher');
        if ($res > 0) {
            echo json_encode(array('msg' => 'Updated successfully', 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => 'Updation failed', 'flag' => 1));
            return;
        }
    }

    function editpass() {
        $this->load->library('mongo_db');
        $newpass = $this->input->post('newpass');
        $val = $this->input->post('val');

//        $this->db->query("select * from dispatcher where dis_pass='" . $newpass . "' ")->result();
        //    $this->db->query("update dispatcher set dis_pass='" . $newpass . "' where dis_id = '" . $val . "' ");
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->set(array('password' => $newpass))->update('dispatcher');
        if ($res > 0) {
            echo json_encode(array('msg' => "this password already exists. Enter new password", 'flag' => 1));
            return;
        }
//         else {
//              $this->db->query("update dispatcher set dis_pass='" . $newpass . "' ");
//
//        }
    }

    function insertcampaigns() {
        $this->load->library('mongo_db');
        //$coupon_type == '1'
        $city = $this->input->post('city');
        $coupon_type = $this->input->post('coupon_type');
        $discount = $this->input->post('discount');
        $discounttype = $this->input->post('discountradio');
        $referaldiscount = $this->input->post('referaldiscount');
        $refferaldiscounttype = $this->input->post('refferalradio');
        $message = $this->input->post('message');
        $title = $this->input->post('title');

//$coupon_type == '2'
        $codes = $this->input->post('codes');
        $citys = $this->input->post('citys');
        $discounts = $this->input->post('discounts');
        $messages = $this->input->post('messages');
        $discounttypes = $this->input->post('discounttypes');


        $this->load->library('mongo_db');

        $db = $this->mongo_db->db;

        $selecttb = $db->selectCollection('coupons');

        if ($coupon_type == '1') {
            $cond = array('coupon_type' => 1, 'coupon_code' => 'REFERRAL', 'city_id' => (int) $city, 'status' => 0);
            $find = $selecttb->findOne($cond);

            if (is_array($find)) {
                return json_encode(array('msg' => "Referral campaign already exists in this city ", 'flag' => 1));
            }
        }

        if ($coupon_type == '2') {
            $city = $citys;
            $cond = array('coupon_type' => 2, 'coupon_code' => $codes, 'city_id' => (int) $city, 'status' => 0, 'expiry_date' => array('$gt' => time()));
            $find = $selecttb->findOne($cond);

            if (is_array($find)) {
                return json_encode(array('msg' => "Same coupon already exists in this city", 'flag' => 1));
            }
        }

        $cityDet = $this->db->query("select * from city_available where City_Id = '" . $city . "'")->result();
        $cityCurrency = $this->db->query("select * from city where City_Id = '" . $city . "'")->result();


        if ($coupon_type == '1') {

            $insert = array(
                "coupon_code" => "REFERRAL",
                "coupon_type" => 1,
                "discount_type" => (int) $discounttype,
                "discount" => (float) $discount,
                "referral_discount_type" => (int) $refferaldiscounttype,
                "referral_discount" => (float) $referaldiscount,
                "message" => $message,
                "status" => 0,
                "title" => $title,
                "city_id" => (int) $city,
                "currency" => $cityCurrency[0]->Currency, // $cityDet['Currency'],
                "city_name" => $cityDet[0]->City_Name,
                "location" => array(
                    "longitude" => (double) $cityDet[0]->City_Long,
                    "latitude" => (double) $cityDet[0]->City_Lat
                ),
                "user_type" => 2
            );

            $selecttb->insert($insert);
        } else if ($coupon_type == '2') {
            $insert = array(
                "coupon_code" => $codes,
                "coupon_type" => 2,
                "start_date" => strtotime($this->input->post('sdate')),
                "expiry_date" => strtotime($this->input->post('edate')),
                "discount_type" => (int) $discounttypes,
                "discount" => (float) $discounts,
                "message" => $messages,
                "status" => 0,
                "title" => $title,
                "city_id" => (int) $city,
                "currency" => $cityCurrency[0]->Currency,
                "city_name" => $cityDet[0]->City_Name,
                "location" => array(
                    "longitude" => (double) $cityDet[0]->City_Long,
                    "latitude" => (double) $cityDet[0]->City_Lat
                ),
                "user_type" => 2
            );
            $selecttb->insert($insert);
        }
//         else{
        return json_encode(array('msg' => "Great! Your referrals has been added sucessfully for this city", 'flag' => 0, 'data' => $insert));
//            }
    }

    function updatecompaigns() {
        $this->load->library('mongo_db');

        $coupon_type = $this->input->post('coupon_type');
        $discount = $this->input->post('discount');
        $discounttype = $this->input->post('discountradio');
        $referaldiscount = $this->input->post('referaldiscount');
        $refferaldiscounttype = $this->input->post('refferalradio');
        $message = $this->input->post('message');
        $title = $this->input->post('title');
        $cuponid = $this->input->post('val');

        // for coupon types 2
        $cuponids = $this->input->post('val2');
        $discounts = $this->input->post('discounts');
        $messages = $this->input->post('messages');
        $codes = $this->input->post('codes');
        $discounttypes = $this->input->post('discounttypes');

        $this->load->library('mongo_db');

        $db = $this->mongo_db->db;

        $selecttb = $db->selectCollection('coupons');

        if ($coupon_type == '1') {

            $selecttb->update(array('_id' => new MongoId($cuponid)), array(
                '$set' => array(
                    "discount_type" => (int) $discounttype,
                    "discount" => (float) $discount,
                    "referral_discount_type" => (int) $refferaldiscounttype,
                    "referral_discount" => (float) $referaldiscount,
                    "message" => $message,
                    "title" => $title,
                    "status" => 0
            )));
        } else if ($coupon_type == '2') {
            $selecttb->update(array('_id' => new MongoId($cuponids)), array(
                '$set' => array(
                    "coupon_code" => $codes,
                    "start_date" => (int) strtotime($this->input->post('sdate')),
                    "expiry_date" => (int) strtotime($this->input->post('edate')),
                    "discount_type" => (int) $discounttypes,
                    "discount" => (float) $discounts,
                    "message" => $messages,
                    "status" => 0,
                    "title" => $title,
                    "user_type" => 2
            )));
        }

        return json_encode(array('msg' => "Updated successfully"));
    }

    function get_referral_details($id, $page) {
        $this->load->library('mongo_db');

        $db = $this->mongo_db->db;

        $selecttb = $db->selectCollection('coupons');

//        error_reporting(E_ALL);
        $find = $selecttb->find(array('_id' => new MongoId($id)));

        $all = array();

        foreach ($find as $cur)
            $all[] = $cur;

        return $all;
    }

//    function datatable_cities() {
//
//        $this->load->library('Datatables');
//        $this->load->library('table');
//
//        $datatosend1 = $this->mongo_db->get('cities');
//        
//        $slno = 0;
//        foreach ($datatosend1 as $city)
//            $arr[]= array(++$slno,$city['country'],$city['city'],'<input type="checkbox" class="checkbox" name="checkbox" value="'.$city['_id']['$oid'].'">');
//        
//        if($this->input->post('sSearch') != '')
//        {
//               
//            $FilterArr = array();
//            foreach ($arr as $row)
//            {
//                $needle = ucwords($this->input->post('sSearch'));
//                $ret = array_keys(array_filter($row, function($var) use ($needle){
//                    return strpos(ucwords($var), $needle) !== false;
//                }));
//               if (!empty($ret)) 
//               {
//                   $FilterArr [] = $row;
//               }
//               
//            }
//              echo $this->datatables->getdataFromMongo($FilterArr);
//        }
//        
//        if($this->input->post('sSearch') == '')
//        echo $this->datatables->getdataFromMongo($arr);
//    }
    function datatable_cities() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "country";
        $_POST['mDataProp_1'] = "city";



        $respo = $this->datatables->datatable_mongodb('cities', array('isDeleted' => FALSE), 'country', 1); //1->ASCE -1->DESC

        $aaData = $respo["aaData"];
        $datatosend = array();

        $sl = 1;
        foreach ($aaData as $value) {


            $arr = array();

            $arr[] = $sl++;
            $arr[] = $value['city'];
            $arr[] = $value['country'];
            $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_long_haul_zone() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $datatosend1 = $this->mongo_db->where(array('isDeleted' => FALSE))->get('cities');

        $slno = 0;
        foreach ($datatosend1 as $city)
            $arr[] = array(++$slno, $city['country'], $city['city'], "<a style='cursor:pointer; text-decoration: none;color:white'   class='btn btn-info' href='" . base_url() . "index.php?/superadmin/long_haul_Pricing/" . $city['_id']['$oid'] . "'>SET PRICE</a>");

        if ($this->input->post('sSearch') != '') {

            $FilterArr = array();
            foreach ($arr as $row) {
                $needle = ucwords($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle) {
                            return strpos(ucwords($var), $needle) !== false;
                        }));
                if (!empty($ret)) {
                    $FilterArr [] = $row;
                }
            }
            echo $this->datatables->getdataFromMongo($FilterArr);
        }

        if ($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($arr);

//         $respo = $this->datatables->datatable_mongodb('cities', array('isDeleted' => FALSE), 'country', 1); //1->ASCE -1->DESC
//
//        $aaData = $respo["aaData"];
//        $datatosend = array();
//
//        $sl = 1;
//        foreach ($aaData as $value) {
//
//
//            $arr = array();
//
//            $arr[] = $sl++;
//            $arr[] = $value['country'];
//            $arr[] = $value['city'];
//            $arr[] = "<a style='cursor:pointer; text-decoration: none;color:white'   class='btn btn-info' href='" . base_url() . "index.php?/superadmin/long_haul_Pricing/" . $city['_id']['$oid'] . "'>SET PRICE</a>";
//            $datatosend[] = $arr;
//        }
//
//        $respo["aaData"] = $datatosend;
//        echo json_encode($respo);
    }

    function CompleteBooking() {
        $this->load->library('mongo_db');
        $bid = $this->input->post('bid');
        $type = $this->input->post('type');
        $amount = $this->input->post('amount');
        $amountToupdate = 0;

        print_r($_POST);
        exit();

        $ShipmentDetails = $this->mongo_db->where(array('order_id' => (int) $bid))->find_one('ShipmentDetails');
        if (!empty($ShipmentDetails)) {

            $result = $this->mongo_db->where(array('order_id' => (int) $bid))->set(array('status' => 10, 'actionByAdmin' => "Admin", 'actionDate' => time(), 'invoice.total' => floatval($amount)))->update('ShipmentDetails');
            echo json_encode(array('msg' => 'This booking has been completed by admin', 'flag' => 0));
        } else {
            echo json_encode(array('msg' => 'There is no booking to update', 'flag' => 1));
        }
    }

    function cancelBooking() {
        $this->load->library('mongo_db');
        $bid = $this->input->post('bid');
        $type = $this->input->post('type');
        $amount = $this->input->post('amount');

        $amountToupdate = 0;
        if ($amount)
            $amountToupdate = floatval($amount);

        $ShipmentDetails = $this->mongo_db->get_one('ShipmentDetails', array('order_id' => (int) $bid));
        $accArr = array('mas_earning' => 0, 'pg_commission' => 0, 'app_commission' => 0, 'cc_fee' => 0, 'tip_amount' => 0, 'discount' => 0, 'amount' => $amountToupdate);
        $res_mongo1 = $this->mongo_db->update('ShipmentDetails', array('receivers.0.status' => '12', 'receivers.0.Accounting' => $accArr, 'status' => 12, 'actionByAdmin' => 1, 'actionDate' => time()), array('order_id' => (int) $bid));
        $res_mongo2 = $this->mongo_db->update('location', array('status' => 3, 'apptStatus' => 0), array('user' => (int) $ShipmentDetails['mas_id']));
        echo json_encode(array('msg' => 'Updated successfully', 'flag' => 0));
    }

    function datatable_operator($status = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "operatorName";
        $_POST['mDataProp_1'] = "address";
        $_POST['mDataProp_2'] = "email";
        $_POST['mDataProp_3'] = "mobile";
        switch ((int) $status) {
            case 1:
                $respo = $this->datatables->datatable_mongodb('operators', array('status' => 1), '', -1);
                break;
            case 3:
                $respo = $this->datatables->datatable_mongodb('operators', array('status' => 3), '', -1);
                break;
            case 4:
                $respo = $this->datatables->datatable_mongodb('operators', array('status' => 4), '', -1);
                break;
        }
//        $respo = $this->datatables->datatable_mongodb('operators', array('status' => (int) $status),'',-1);

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $type = 'Unregistered';
            if ($value['registered'] == 0)
                $type = 'Registered';
            $city = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['countryID'])))->find_one('cities');
            $vehiclesCount = $this->mongo_db->where(array('operator' => new MongoDB\BSON\ObjectID($value['_id']['$oid'])))->count('vehicles');
            $driverCount = $this->mongo_db->where(array('companyId' => new MongoDB\BSON\ObjectID($value['_id']['$oid'])))->count('driver');
            foreach ($city['cities'] as $result) {
                if ($result['cityId']['$oid'] == $value['cityID']) {
                    $arr = array();
                    $arr[] = ++$slno;
                    $arr[] = $result['cityName'];
                    $arr[] = $value['operatorName'];
                    $arr[] = $type;
                    $arr[] = '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/superadmin/getvehiclesForOperators/' . $value['_id']['$oid'] . '"><span class="badge bg-green">' . $vehiclesCount . '</span></a>';
                    $arr[] = '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/superadmin/getDriversForOperators/' . $value['_id']['$oid'] . '"><span class="badge bg-green">' . $driverCount . '</span></a>';
                    $arr[] = $value['address'];
                    $arr[] = $value['postcode'];
                    $arr[] = $value['email'];
                    $arr[] = $value['mobile'];
                    $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '">';

                    $datatosend[] = $arr;
                }
            }
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function vehicletype_reordering() {
        $this->load->library('mongo_db');

        $res = $this->mongo_db->where(array('type' => (int) $_REQUEST['curr_id']))->find_one('vehicleTypes');
        $res1 = $this->mongo_db->where(array('type' => (int) $_REQUEST['prev_id']))->find_one('vehicleTypes');

        $currcount = $res['order'];
        $prevcount = $res1['order'];

        $this->mongo_db->where(array('type' => (int) $_REQUEST['curr_id']))->set(array('order' => (int) $prevcount))->update('vehicleTypes');
        $this->mongo_db->where(array('type' => (int) $_REQUEST['prev_id']))->set(array('order' => (int) $currcount))->update('vehicleTypes');

        echo json_encode(array('flag' => 1));
        return true;
    }

    function datatable_vehicletype($status = '') {
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->get('vehicleTypes');

        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "type_name";

        $respo = $this->datatables->datatable_mongodb('vehicleTypes', array(), 'order');

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $r) {
            $arr = array();
            $arr[] = $r['type'];
            $arr[] = $r['type_name'];
            $arr[] = '<a class="vehicleDetails"   length="' . substr($r['vehicle_length'], 0, -1) . '" length_metric = "' . substr($r['vehicle_length'], -1) . '" width="' . substr($r['vehicle_width'], 0, -1) . '" width_metric = "' . substr($r['vehicle_width'], -1) . '" height="' . substr($r['vehicle_height'], 0, -1) . '" height_metric = "' . substr($r['vehicle_height'], -1) . '" capacity="' . $r['vehicle_capacity'] . '"  style="cursor: pointer"> <button class="btn btn-info btn-sm" style="width:inherit;"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>';
            $arr[] = '<a class="pricing"  min_fare="' . $r['min_fare'] . '" waiting_charge="' . $r['waiting_charge'] . '"  cancellation_fee="' . $r['cancellation_fee'] . '" mileagePrice="' . $r['mileage_price'] . '" waiting_minutes ="' . $r['waiting_time_min'] . '" scheduledBookingCancellationFee="' . $r['scheduledBookingCancellationFee'] . '" scheduledBookingCancellationMin="' . $r['scheduledBookingCancellationMin'] . '" longHaulEnDis="' . $r['longHaulEnDis'] . '" cancellation_minutes ="' . $r['cancenlation_min'] . '"  minimum_km_miles ="' . $r['min_distance'] . '" x_zonal_km_miles ="' . $r['x_zonal_km_miles'] . '" mileageMetric = "' . $r['mileage_metrc'] . '" zonalEnable="' . $r['zonalEnable'] . '" zonal_km_miles_greater_or_less ="' . $r['zonal_km_miles_greater_or_less'] . '" style="cursor: pointer; "> <button class="btn btn-warning" style="width:inherit; background-color: palevioletred;border-color: palevioletred;"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>';
            $arr[] = '<a class="images" type_id="' . $r['type'] . '" on_image="' . $r['vehicle_img'] . '" off_image="' . $r['vehicle_img_off'] . '" map_image="' . $r['MapIcon'] . '" style="cursor: pointer"> <button style="width:inherit;" class="btn btn-warning btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i> View</button></a>';
            $arr[] = $r['type_desc'];
            $arr[] = '<img style="width:30px;" src="' . base_url() . 'theme/assets/img/uparrow.png" data-id="' . $r['type'] . '" data="1" class="ordering"><img style="width:30px;" src="' . base_url() . 'theme/assets/img/downarrow.png"  data-id="' . $r['type'] . '" data="2"  class="ordering">';
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value= "' . $r['type'] . '"/>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function uploadVehicleTypeImage() {
        $this->load->library('mongo_db');
        //$type_on_img = $this->input->post('type_on_image');
        $type_on_img = $_FILES['on_image_upload']['name'];
        $ext1 = substr($type_on_img, strrpos($type_on_img, '.') + 1); //explode(".", $insurname);
        $type_on_image = (rand(1000, 9999) * time()) . '.' . $ext1;


        //$type_off_img = $this->input->post('type_off_image');
        $type_off_img = $_FILES['off_image_upload']['name'];
        $ext2 = substr($type_off_img, strrpos($type_off_img, '.') + 1); //explode(".", $insurname);
        $type_off_image = (rand(1000, 9999) * time()) . '.' . $ext2;


        //$type_map_img = $this->input->post('type_map_image');
        $type_map_img = $_FILES['map_image_upload']['name'];
        $ext3 = substr($type_map_img, strrpos($type_map_img, '.') + 1); //explode(".", $insurname);
        $type_map_image = (rand(1000, 9999) * time()) . '.' . $ext3;



        $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/pics/';

        try {
            move_uploaded_file($_FILES['on_image_upload']['tmp_name'], $documentfolder . $type_on_image);
            move_uploaded_file($_FILES['off_image_upload']['tmp_name'], $documentfolder . $type_off_image);
            move_uploaded_file($_FILES['map_image_upload']['tmp_name'], $documentfolder . $type_map_image);
        } catch (Exception $ex) {
            print_r($ex);
            return false;
        }

        if ($type_on_img) {
            $this->db->query("update workplace_types set vehicle_img ='" . $type_on_image . "' where type_id = " . $this->input->post('vehicleType_id') . "");
            $fdata = array('vehicle_img' => $type_on_image);
        }
        if ($type_off_img) {
            $this->db->query("update workplace_types set vehicle_img_off ='" . $type_off_image . "' where type_id = " . $this->input->post('vehicleType_id') . "");
            $fdata = array('vehicle_img_off' => $type_off_image);
        }
        if ($type_map_img) {
            $this->db->query("update workplace_types set MapIcon ='" . $type_map_image . "' where type_id = " . $this->input->post('vehicleType_id') . "");
            $fdata = array('MapIcon' => $type_map_image);
        }

        $this->mongo_db->update("vehicleTypes", $fdata, array("type" => (int) $this->input->post('vehicleType_id')));
        return;
    }

    function documentgetdata() {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("mas_id"))))->get('driver');
//        $data = $this->db->query("select profile_pic,license_pic,license_exp from master where mas_id = '" . $mas_id . "'")->result();

        return $data;
    }

    function getfreelanceDrivers() {
        $this->load->library('mongo_db');
        $driver = $this->mongo_db->where(array('status' => 2, 'driverType' => 1))->get('driver');
        $entities = "<option value=''>Select</option>";
        foreach ($driver as $driver) {
            $entities .= "<option value='" . $driver['_id']['$oid'] . "' driverMobile='" . $driver['mobile'] . "' driverName='" . trim($driver['firstName']) . ' ' . trim($driver['lastName']) . "'>" . trim($driver['firstName']) . ' ' . trim($driver['lastName']) . '-' . $driver['email'] . '-' . $driver['mobile'] . "</option>";
        }

        echo $entities;
    }

    function getStoreDrivers() {
        $this->load->library('mongo_db');
        $driver = $this->mongo_db->where(array('status' => 2, 'driverType' => 3, 'storeId' => new MongoDB\BSON\ObjectID($id)))->get('driver');
        $entities = "<option value=''>Select</option>";
        foreach ($driver as $driver) {
            $entities .= "<option value='" . $driver['_id']['$oid'] . "' driverMobile='" . $driver['mobile'] . "' driverName='" . trim($driver['firstName']) . ' ' . trim($driver['lastName']) . "'>" . trim($driver['firstName']) . ' ' . trim($driver['lastName']) . '-' . $driver['email'] . '-' . $driver['mobile'] . "</option>";
        }

        echo $entities;
    }

    function datatable_vehicles($status = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 7;
        $_POST['mDataProp_0'] = "make";
        $_POST['mDataProp_1'] = "modal";
        $_POST['mDataProp_2'] = "type";
        $_POST['mDataProp_3'] = "driverName";
        $_POST['mDataProp_4'] = "driverMobile";
        $_POST['mDataProp_5'] = "operatorName";
        $_POST['mDataProp_6'] = "platNo";


        if ($status == '2')
            $respo = $this->datatables->datatable_mongodb('vehicles', array('status' => array('$in' => [2, 4, 5])));
        else if ($status == '4')
            $respo = $this->datatables->datatable_mongodb('vehicles', array('status' => 4));
        else
            $respo = $this->datatables->datatable_mongodb('vehicles', array('status' => (int) $status));


        $aaData = $respo["aaData"];
        $datatosend = array();

        $sl = 0;
        foreach ($aaData as $value) {

            if (isset($value['driverId']) && $value['driverId']['$oid'] != "")
                $masterData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['driverId']['$oid'])))->find_one('driver');
            if ($status == '5') {

                if ($masterData['location']['latitude'] === 0.0)
                    $elapsed = '';
                else {
                    if ($masterData['mobileDevices']['lastLogin'] != NULL || $masterData['mobileDevices']['lastLogin'] != '') {
                        $time = (int) (time() - $masterData['mobileDevices']['lastLogin']);
                        $timeAgo = $this->datatables->secondsToTime($time);

                        $diffTime = $timeAgo['m'] . ' min ago';

                        if ((int) $timeAgo['h'] > 0)
                            $diffTime = $timeAgo['h'] . ' hour ' . $diffTime;

                        if ((int) $timeAgo['d'] > 0)
                            $diffTime = $timeAgo['d'] . ' day ' . $diffTime;

                        $elapsed = '<br> <b><span style="color:#1ABB9C;font-style: italic;font-size: 10px;">' . $diffTime . '</span></b>';
                    } else
                        $elapsed = '';
                }
            }
            if ($value['account_type'] == 2 || $value['account_type'] == "2") {
                $accType = "Operator";
                $Name = $value['operatorName'];
            } else if ($value['account_type'] == 3 || $value['account_type'] == "3") {
                $accType = "store";
                $Name = $value['storeName'];
            } else {
                $accType = "Freelancer";
                $Name = "N/A";
            }

            $arr = array();
            $arr[] = $value['platNo'];
            $arr[] = $value['make'];
            $arr[] = $value['model'];
//            $arr[] = $value['color'];
            $arr[] = ($value['account_type'] == 2 || $value['account_type'] == 3) ? 'N/A' : '<a style="cursor: pointer;" id="driverID' . $value['mas_id']['$oid'] . '"  class="getDriverDetails" mas_id="' . $value['mas_id']['$oid'] . '">' . $value['driverName'] . '</a>';
            $arr[] = ($value['account_type'] == 2 || $value['account_type'] == 3) ? 'N/A' : $masterData['countryCode'] . $value['driverMobile'];

            $arr[] = number_format($masterData['location']['latitude'], 6) . ', ' . number_format($masterData['location']['longitude'], 6);
            $arr[] = ($masterData['mobileDevices']['lastLogin'] != '' || $masterData['mobileDevices']['lastLogin'] != null) ? date('j-M-Y g:i A', $masterData['mobileDevices']['lastLogin']) : 'N/A';
            $arr[] = $accType;
            $arr[] = $Name;
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_showDriverVehicles($id = '', $status = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 7;
//        $_POST['mDataProp_0'] = "sl";
        $_POST['mDataProp_0'] = "make";
        $_POST['mDataProp_1'] = "modal";
        $_POST['mDataProp_2'] = "type";

        if ($status == '')
            $respo = $this->datatables->datatable_mongodb('vehicles', array('mas_id' => new MongoDB\BSON\ObjectID($id)));
        else {
            if ($status == '2')
                $respo = $this->datatables->datatable_mongodb('vehicles', array('mas_id' => new MongoDB\BSON\ObjectID($id), 'status' => array('$in' => ['2', 2, '4', 4, '5', 5])));
            else
                $respo = $this->datatables->datatable_mongodb('vehicles', array('mas_id' => new MongoDB\BSON\ObjectID($id), 'status' => array('$in' => [(int) $status, $status])));
        }

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $arr = array();
            $arr[] = $value['make'];
            $arr[] = $value['model'];
            $arr[] = $value['type'];
            $arr[] = $value['platNo'];
            $arr[] = unserialize(vehicleStatus)[$value['status']];
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function getAllPlansForDrivers() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->where(array('isDeleted' => false))->get('Driver_plans');
        return $getAll;
    }

    function getAppConfig() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->get('appConfig');
        return $getAll;
    }

    function getAppConfigOne() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->find_one('appConfig');
        return $getAll;
    }

    function getAppConfigOneAjax() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->find_one('appConfig');
        echo json_encode(array('data' => $getAll));
        return;
    }

    function getOperators($OperatorID = '') {
        $this->load->library('mongo_db');
        if ($OperatorID == '')
            $operatorData = $this->mongo_db->where(array('status' => 3))->get('operators');
        else
            $operatorData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($OperatorID)))->find_one('operators');

        return $operatorData;
    }

    function getStores($storeID = '') {
        $this->load->library('mongo_db');
        if ($storeID == '')
            $storeData = $this->mongo_db->get('stores');
        else
            $storeData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($storeID),'driverType'=>2))->find_one('stores');

        return $storeData;
    }

    function getAppConfig_ajax() {

        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
        $selecttb = $db->selectCollection('appConfig');

        $data = $selecttb->findOne();
        echo json_encode(array('data' => $data));
    }

    function getZonesWithCities() {

        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("city_ID" => $val))->get('zones');
        if ($cursor) {
            $entitiesData = array();
            $entityData = [];
            foreach ($cursor as $dat) {
                $entityData['id'] = $dat['_id']['$oid'];
                $entityData['title'] = $dat['title'];
                array_push($entitiesData, $entityData);
                // array_push($entities, '<option data-name="' . $dat['title'] . '" value="' . $dat['_id']['$oid'] . '">' . $dat['title'] . '</option>');
            }

            echo json_encode(array('data' => $entitiesData));
        } else {
            $entities = array();
            $entities = '<option value="">Select Zones</option>';
            $entities .= '<option data-name="" value="">' . 'No zones to select' . '</option>';
            echo $entities;
        }
    }

    function readTermsAndConditions() {
        $this->load->library('mongo_db');
        //Read termsAndConditions
        $my_file = 'termsAndCondions.php';
        $handle = fopen($my_file, 'r');
        $termsAndConditions = fread($handle, filesize($my_file));

        //Read Privacy Policy
        $my_file = 'privacyPolicy.php';
        $handle = fopen($my_file, 'r');
        $privacyPolicy = fread($handle, filesize($my_file));
        echo json_encode(array('termsAndConditions' => $termsAndConditions, 'privacyPolicy' => $privacyPolicy, 'appConfig' => unserialize(file_get_contents("appConfig.php"))));
        return;
    }

    function updateAppConfigNew() {
        $this->load->library('mongo_db');

        $driverGoogleMapKey = $this->input->post('driverGoogleMapKey');
        $customerGoogleMapKey = $this->input->post('customerGoogleMapKey');
        $customerGooglePlaceKey = $this->input->post('customerGooglePlaceKey');

        $googleKeys = array();

        $driverGoogleMapKeyArr = array();
        for ($i = 0; $i < count($driverGoogleMapKey); $i++) {
            if ($driverGoogleMapKey[$i] != '')
                $driverGoogleMapKeyArr[] = $driverGoogleMapKey[$i];
        }

        $customerGoogleMapKeyArr = array();
        for ($i = 0; $i < count($customerGoogleMapKey); $i++) {
            if ($customerGoogleMapKey[$i] != '')
                $customerGoogleMapKeyArr[] = $customerGoogleMapKey[$i];
        }

        $customerGooglePlaceKeyArr = array();
        for ($i = 0; $i < count($customerGooglePlaceKey); $i++) {
            if ($customerGooglePlaceKey[$i] != '')
                $customerGooglePlaceKeyArr[] = $customerGooglePlaceKey[$i];
        }


        $DispatchRadius = $this->input->post('DispatchRadius');


        //Push Topics
        $pushTopics = array('allDrivers' => $this->input->post('inputAllDriverPushTopic'), 'allCitiesDrivers' => $this->input->post('inputAllCitiesPushTopic'), 'outZoneDrivers' => $this->input->post('inputAllOutZonePushTopic'), 'allCustomers' => $this->input->post('inputAllCustomersPushTopic'), 'allCitiesCustomers' => $this->input->post('inputAllCitiesCustomerPushTopic'), 'outZoneCustomers' => $this->input->post('inputAllOutZoneCustomersPushTopic'));

        $securitySettings = array('accessToken' => (int) $this->input->post('accessToken'));

        $laundrySettings = array('timeForNormalDelivery' => (int) $this->input->post('timeForNormalDelivery'),'timeForExpressDelivery' => (int) $this->input->post('timeForExpressDelivery'),
        'defaultFeeForNormalDelivery' => (int) $this->input->post('defaultFeeForNormalDelivery'),'defaultFeeForExpressDelivery' => (int) $this->input->post('defaultFeeForExpressDelivery'));


        $forgotPasswordSettings = array('resetPasswordLinkExpiry'=>(int) $this->input->post('resetPasswordLinkExpiry'),'maxAttemptForgotPassword' => (int) $this->input->post('maxAttemptForgotPassword'), 'maxAttemptOtp' => (int) $this->input->post('maxAttemptOtp'), 'otpExpiryTime' => (int) $this->input->post('otpExpiryTime'));


        $ReferralSettings = array('sendByEmail' => (int) $this->input->post('referralCodeSendByEmail'), 'sendByTestMsg' => (int) $this->input->post('referralCodeSendByTestMsg'));
        $presenceSettings = array('presenceTime' => (int) $this->input->post('presenceTime'), 'DistanceForLogingLatLongs' => (int) $this->input->post('routeDistance'));

        $publishSettings = array('timedOutTimeInterval' => (int) $this->input->post('timedOutTimeInterval'), 'homePageInterval' => (int) $this->input->post('homePageInterval'), 'onJobInterval' => (int) $this->input->post('onJobInterval'), 'tripStartedInterval' => (int) $this->input->post('tripStartedInterval'), 'customerHomePageInterval' => (int) $this->input->post('customerHomePageInterval'));

        // earlire key whixh was removed later
            /*
                 'staffAcceptTime' => (int) $this->input->post('staffAcceptTime'),'centralDispatchExpriryTime' => (int) $this->input->post('centralDispatchExpriryTime'),
                 'centralDispatchTime' => (int) $this->input->post('centralDispatchTime'), 'dispatchTime' => (int) $this->input->post('dispatchTime')
             */

        $scheduleBook=$this->input->post('scheduledBookingsOnOFF');
        if($scheduleBook=="on"){
            $scheduleBookVal=1;
        }else{
            $scheduleBookVal=0;
        }

        



        $dispatch_settings = array('dispatchMode' => (int) $this->input->post('dipatchModeValue'),
         'nowBookingAutoDispatchRatio' => (int) $this->input->post('autoBookNowDispatchRation'),
         'nowBookingCentralDispatchRatio' => (int) $this->input->post('centralBookNowDispatchRation'), 
         'laterBookingAutoDispatchRatio' => (int) $this->input->post('autoDispatchRation'), 
         'laterBookingCentralDispatchRatio' => (int) $this->input->post('centralDispatchRation'),
         'laterBookingDispatchBeforeHours' => (int) $this->input->post('laterBookingDispatchBeforeHours'),
         'laterBookingDispatchBeforeMinutes' => (int) $this->input->post('laterBookingDispatchBeforeMinutes'), 
         'DispatchRadius' => (int) $DispatchRadius, 'longHaulDispatchRadius' => (int) $longHaulDispatchRadius, 
         'shortHaulDispatchRadius' => (int) $shortHaulDispatchRadius, 'bookLaterExpQueueMin' => (int) $this->input->post('bookLaterExpQueueMin'),
         'driverAcceptTime' => (int) $this->input->post('timeForacceptBooking'), 'timeForDriverAck' => (int) $this->input->post('timeForDriverAck'),
         'laterBookingBufferHour' => (int) $this->input->post('laterBookingBufferHour'), 'laterBookingBufferMinute' => (int) $this->input->post('laterBookingBufferMinute'),
         'dispatchExpireTime' => (int) $this->input->post('dispatchExpireTime'),'scheduledBookingsOnOFF' => $scheduleBookVal,
         'nowBookingStoreExpireTime' => (int) $this->input->post('nowBookingStoreExpireTime'),'laterBookingStoreExpireTime' => (int) $this->input->post('laterBookingStoreExpireTime'));
          /* recommanded for consumption times */
        
         
          $consumptionTime = array('breakfast'=>array('startTime'=>$this->input->post('breakfasttime').':59','endTime'=>$this->input->post('breakfastEndtime').':59'),
          'brunch'=>array('startTime'=>$this->input->post('brunchtime').':59','endTime'=>$this->input->post('brunchEndtime').':59'),
          'lunch'=>array('startTime'=>$this->input->post('lunchtime').':59','endTime'=>$this->input->post('lunchEndtime').':59'),
          'tea'=>array('startTime'=>$this->input->post('teatime').':59','endTime'=>$this->input->post('teaEndtime').':59'),
          'dinner'=>array('startTime'=>$this->input->post('dinnertime').':59','endTime'=>$this->input->post('dinnerEndtime').':59'),
          'latenightDinner'=>array('startTime'=>$this->input->post('latenightdinnertime').':59','endTime'=>$this->input->post('latenightdinnerEndtime').':59')
        );  

        $shiftBufferTimings=$this->input->post('shiftBufferTimings');
        

        $this->load->library('mongo_db');
        $mongoArr = array('laundry'=>$laundrySettings,'pushTopics' => $pushTopics, 'referralSettings' => $ReferralSettings, 'securitySettings' => $securitySettings, 'forgotPasswordSettings' => $forgotPasswordSettings, 'presenceSettings' => $presenceSettings, 'pubnubSettings' => $publishSettings, 'dispatch_settings' => $dispatch_settings, 'DriverGoogleMapKeys' => $driverGoogleMapKeyArr, 'custGoogleMapKeys' => $customerGoogleMapKeyArr, 'custGooglePlaceKeys' => $customerGooglePlaceKeyArr, 'storeDefaultCommission' => $this->input->post('storeDefaultCommission'),'consumptionTime'=>$consumptionTime,'storeCommisionOnDeliveryFee'=>$this->input->post('storeCommisionOnDeliveryFee'),'shiftBufferTimings'=>$shiftBufferTimings);


        
        $string_data = serialize($mongoArr);

        //Check if the form data is empty or not.Sometimes it is updating as a blank when intenet goes off
        if ($_POST)
            file_put_contents('appConfig.php', $string_data);

        //Check if the form data is empty or not.Sometimes it is updating as a blank when intenet goes off
        if ($_POST)
            $this->mongo_db->where(array())->set($mongoArr)->update('appConfig', array('upsert' => TRUE));

        $mileageMetric = 'Mile';
        if ($this->input->post('mileage_metric') == 0)
            $mileageMetric = 'Km';

        $weightMetric = 'Pound';
        if ($this->input->post('weightMetric') == 0)
            $weightMetric = 'Kg';


        return;
    }

    function datatable_driverPlans($status = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "planName";
        $_POST['mDataProp_0'] = "cityName";
        switch ($status) {
            case 0:
                $respo = $this->datatables->datatable_mongodb('Driver_plans', array('isDeleted' => TRUE), '', -1);
                break;
            case 1:
                $respo = $this->datatables->datatable_mongodb('Driver_plans', array('isDeleted' => FALSE), '', -1);
                break;
        }
//        $appConfig = $this->mongo_db->where(array())->find_one('appConfig');

        $aaData = $respo["aaData"];
        $datatosend = array();
        $sl_no = 0;

        foreach ($aaData as $value) {
            $arr = array();
            $arr[] = ++$sl_no;
            $arr[] = $value['cityName'];
            $arr[] = $value['planName'];
            $arr[] = '<button class="btn btn-info btn-sm dtdescriptionplan" style="width:inherit;" id="' . $value['_id']['$oid'] . '"  value="' . $value['_id']['$oid'] . '"><i class="fa fa-eye" aria-hidden="true"></i> </button>';

//            $arr[] = $value['membershipType'];
//            $arr[] = ($value['membershipType'] == 'Paid') ? $value['membershipfee'] : '-';
            $arr[] = ($value['commissionTypeMsg'] == "%") ? "Percentage" : $value['commissionTypeMsg'];
            $arr[] = $value['appCommissionValue'];
            $arr[] = '<button style="width:35px;" class="btn btn-primary btnWidth editICON cls111"  value=' . $value['_id']['$oid'] . '><i class="fa fa-edit"></i></button>';
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value= "' . $value['_id']['$oid'] . '">';

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function addPlans($param = '') {
			if($this->input->post('memfee') == "fixed"){
				$commType= 1;
			}else{
				$commType= 2;
			}
//        print_r($_POST);die;
        $this->load->library('mongo_db');
        $requestData = $this->mongo_db->where(array('planName' => $this->input->post('plan_name')))->find_one('Driver_plans');
        $mongoarr = array('planName' => $this->input->post('plan_name'), 'cityId' => $this->input->post('cityId'), 'cityName' => $this->input->post('cityName'), 'currency' => $this->input->post('currency'),
            'isDeleted'=>FALSE,'currencySymbol' => $this->input->post('currencySymbol'), 'description' => $this->input->post('descrip'),"commissionType"=>$commType, 'commissionTypeMsg' => $this->input->post('memfee'), 'appCommissionValue' => $this->input->post('appCommission'));
        if (empty($requestData)) {

            $this->mongo_db->insert('Driver_plans', $mongoarr);
            echo json_encode(array('msg' => 'Drivers Plan is added', 'flag' => 0));
        } else {
            echo json_encode(array('msg' => 'Already plan exists', 'flag' => 1));
        }
        return;
    }

    function getAllDriverVehicle($id) {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->where(array('mas_id' => new MongoDB\BSON\ObjectID($id)))->get('vehicles');
        return $getAll;
    }

    function getplandata() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');

        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->find_one('Driver_plans');

        echo json_encode($res['description']);
    }

    function getPlans() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');
       
            $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->find_one('Driver_plans');
        
        echo json_encode($res);
    }

    function updatePlans() {
        $this->load->library('mongo_db');

        $membeFee = (float) 0;
        if ($this->input->post('membershipEdit') == 'Paid')
            $membeFee = (float) $this->input->post('custmemfeeEdit');

        $ids = $this->input->post('idToEdit');
		if($this->input->post('memfee') == "fixed"){
				$commType= 1;
			}else{
				$commType= 2;
			}
        $mongoarr = array('plan_name' => ucwords(strtolower($this->input->post('editplan_name'))), 'description' => $this->input->post('editdescrip'),'commissionType'=>$commType, 'commissionTypeMsg' => $this->input->post('memfee'), 'membershipfee' => $membeFee, 'appCommissionValue' => (float) $this->input->post('editappCommission'), 'referEarnings' => (float) $this->input->post('editreferEarning'));

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($ids)))->set($mongoarr)->update('Driver_plans');
        echo json_encode(array('msg' => 'Driver plans is updated', 'flag' => 0));
        return;
    }

    function deletePlans() {
        $this->load->library('mongo_db');
        $ids = $this->input->post('id');
        foreach ($ids as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('isDeleted' => TRUE))->update('Driver_plans');
        }

        echo json_encode(array('msg' => 'Deleted successfully', 'flag' => 0));
        return;
    }

    // cool
    function datatable_storedrivers($for = '', $status = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "firstName";
        $_POST['mDataProp_1'] = "mobile";
        $_POST['mDataProp_2'] = "email";
        $_POST['mDataProp_3'] = "plateNo";
        $_POST['mDataProp_4'] = "referralCode";

        $driverType = $this->session->userdata('operatorType');
        $operator = $this->session->userdata('company_id');
        $store = $this->session->userdata('storeId');
        $plan = $this->session->userdata('plan');

// Driver status 1 : New , 3:online , 4:offline , 6:Rejected, 7 : Banned , 8: logged out 

        if ($for == 'my') {

            switch ($status) {
                case 0:switch ($driverType) {

                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 9, 'driverType' => 2), 'mobileDevices.lastISOdate', -1);
                                
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 9, 'driverType' => 2), 'mobileDevices.lastISOdate', -1);
                                
                            }
                            break;

                        case '3':
                            if ($store == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 9, 'driverType' => 2), 'mobileDevices.lastISOdate', -1);
                                $respo['status'] = 0;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 9, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)), 'mobileDevices.lastISOdate', -1);
                                $respo['status'] = 0;
                            }

                            break;
                    }
                    break;

                case 1:switch ($driverType) {

                        case '':
                            if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1, 'driverType' => 2));
                                $respo['status'] = 1;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1,'driverType' => 2 ));
                                $respo['status'] = 1;
                            }
                            break;


                        case '3':
                        
                            if ($store == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1, 'driverType' => 2));
                                $respo['status'] = 1;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)));
                                $respo['status'] = 1;
                            }
                            break;
                    }
                    break;
                case 3:switch ($driverType) {
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [3, 4], 'driverType' => 2)));
                                $respo['status'] = 3;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('planID' => new MongoDB\BSON\ObjectID($plan), 'status' => array('$in' => [3, 4])));
                                $respo['status'] = 3;
                            }


                        case '3':
                            if ($store == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [3, 4])));
                                $respo['status'] = 3;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [3, 4]), 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)));
                                $respo['status'] = 3;
                            }

                            break;
                    }
                    break;
                case 4:switch ($driverType) {
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 6, 'driverType' => 2));
                              
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('driverType' => 2,'status' => 6));
                              
                            } break;

                        case '3':
                            if ($store == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 6, 'driverType' => 2));
                              
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 6, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)));
                              
                            }
                            break;
                    }
                    break;
                case 5:switch ($driverType) {
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 7, 'driverType' => 2));
                                
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('driverType' => 2,'status' => 7));
                                
                            }break;



                        case '3':
                            if ($store == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 7, 'driverType' => 2));
                                $respo['status'] = 5;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 7, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)));
                                $respo['status'] = 5;
                            }
                            break;
                    }
                    break;
                case 8:switch ($driverType) {
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [2, 7]), 'driverType' => 2));
                                $respo['status'] = 8;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('planID' => new MongoDB\BSON\ObjectID($plan), 'status' => array('$in' => [2, 7])));
                                $respo['status'] = 8;
                            }break;

                        case '3':
                            if ($store == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [2, 7]), 'driverType' => 2));
                                $respo['status'] = 8;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [2, 7]), 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)));
                                $respo['status'] = 8;
                            }
                            break;
                    }
                    break;
                case 9:switch ($driverType) {
                        case '':if ($plan == '') {
                           
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [2,3,4,8,9]), 'driverType' => 2));
                                $respo['status'] = 9;
                            } else {
                                
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [2,3,4,8,9]),'driverType' => 2));
                                // $respo['status'] = 9;
                            }break;


                        case '3':
                            if ($store == '') {
                                echo '3';die;
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [2, 3, 4, 8, 9]), 'driverType' => 2));
                                $respo['status'] = 9;
                            } else {
                                echo '4';die;
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [2, 3, 4, 8, 9]), 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)));
                                $respo['status'] = 9;
                            }
                            break;
                    }
                    break;
            }
        } else if ($for == 'mo') {

            switch ($status) {
                case 3:switch ($driverType) {//online or free
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 3, 'driverType' => 2));
                               
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 3,  'driverType' => 2));
                                
                            }
                            break;


                        case '3':
                            if ($store == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 3, 'driverType' => 2));
                                $respo['status'] = 11;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 3, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)));
                                $respo['status'] = 11;
                            }

                            break;
                    }
                    break;
                case 567:switch ($driverType) {//logged out
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 8, 'driverType' => 2));
                                
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 8, 'driverType' => 2));
                                
                            }
                            break;


                        case '3':
                            if ($store == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 8, 'driverType' => 2));
                                $respo['status'] = 12;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 8, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)));
                                $respo['status'] = 12;
                            }

                            break;
                    }
                    break;
                case 30:switch ($driverType) {
                        //offline
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 4, 'driverType' => 2));
                                
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 4, 'driverType' => 2));
                                
                            }


                        case '3':
                            if ($store == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 4, 'driverType' => 2));
                                $respo['status'] = 13;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 4, 'driverType' => 2, 'storeId' => new MongoDB\BSON\ObjectID($store)));
                                $respo['status'] = 13;
                            }


                            break;
                    }
                    break;
            }
        }

        //get data from App config for wallet
        $appConfig = $this->mongo_db->where(array())->find_one('appConfig');

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            //Location LatLong
            if ($value['location']['latitude'] === 0.0)
                $elapsed = '';
            else {
                if ($value['mobileDevices']['lastLogin'] != NULL || $value['mobileDevices']['lastLogin'] != '') {
                    $time = (int) (time() - $value['mobileDevices']['lastLogin']);
                    $timeAgo = $this->datatables->secondsToTime($time);

                    $diffTime = $timeAgo['m'] . ' min ago';

                    if ((int) $timeAgo['h'] > 0)
                        $diffTime = $timeAgo['h'] . ' hour ' . $diffTime;

                    if ((int) $timeAgo['d'] > 0)
                        $diffTime = $timeAgo['d'] . ' day ' . $diffTime;

                    $elapsed = '<br> <b><span style="color:#1ABB9C;font-style: italic;font-size: 10px;">' . $diffTime . '</span></b>';
                } else
                    $elapsed = '';
            }

            //CREDIT LINE
            $walletSoftLimit = '(' . $appConfig['currencySymbol'] . ' ' . $appConfig['walletSettings']['softLimitDriver'] . ') ';
            if (isset($value['walletSoftLimit']) && $value['walletSoftLimit'] != NULL && $value['walletSoftLimit'] != '')
                $walletSoftLimit = '(' . $appConfig['currencySymbol'] . ' ' . $value['walletSoftLimit'] . ') ';

            $walletHardLimit = $appConfig['currencySymbol'] . ' ' . $appConfig['walletSettings']['hardLimitDriver'];
            if (isset($value['walletHardLimit']) && $value['walletHardLimit'] != NULL && $value['walletHardLimit'] != '')
                $walletHardLimit = $appConfig['currencySymbol'] . ' ' . $value['walletHardLimit'];

            $plan = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['planID']['$oid'])))->find_one('Driver_plans');
            $vehicleTypes = '';


            //Setting credit line
            $setCreditEn = ($value['setCreditEnable'] == TRUE) ? (($appConfig['walletSettings']['walletDriverEnable'] == TRUE) ? 'checked' : '') : '';
            $setCreditButton = ($value['setCreditEnable'] == TRUE) ? (($appConfig['walletSettings']['walletDriverEnable'] == TRUE) ? 'display:block;' : 'display:none;') : 'display:none;';

            //check if the new plan updated
            $plan = $plan['plan_name'];
            if (count($value['newPlans']) > 0) {
                foreach ($value['newPlans'] as $eachNewPlan)
                    $plan = $eachNewPlan['planName'];
            } else {
                $plan = "N/A";
            }
            switch ($value['driverType']) {
                case 1:
                    $accType = 'Freelancer';
                    $nam = "N/A";
                    $citName = $value['citName'];
                    break;
                case 3:
                    $accType = 'Store';
                    $nam = ($value['storeName'] == "") ? "N/A" : $value['storeName'];
                    break;
            }


            if ($value['cityId'] == '' || $value['cityId'] == null || $value['cityId'] == 0 || $value['cityId'] == '0') {
                $citName = 'N/A';
            } else {
                // $cityName = $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($value['cityId']['$oid'])))->find_one('cities');
                foreach ($cityName['cities'] as $city) {
                    if ($value['cityId']['$oid'] == $city['cityId']['$oid']) {
                        $citName = $city['cityName'];
                    }
                }
            }
            switch ($value['status']) {

                case 3:
                    $status = "Online";

                    break;
                case "3":
                    $status = "Online";

                    break;
                case 4:
                    $status = "Offline";

                    break;
                case "4":
                    $status = "Offline";

                    break;
                case 6:
                    $status = "Rejected";


                    break;
                case "6":
                    $status = "Rejected";

                    break;
                case 7:
                    $status = "Banned";

                    break;
                case "7":
                    $status = "Banned";

                    break;
                case 8:
                    $status = "Logged Out";

                    break;
                case "8":
                    $status = "Logged Out";

                    break;
                case 9:
                    $status = "Timed Out";

                    break;
                case "9":
                    $status = "Timed Out";

                    break;
                default :
                    $status = "Approved";

                    break;
            }
            switch ($respo['status']) {
                case 0:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth deviceLogsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-phone"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth manualLogoutICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-file"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth resetPasswordICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-refresh"></i></button>';
                    break;
                case 1:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth editICON cls111"  value=' . $value['_id']['$oid'] . '><i class="fa fa-edit"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth documentsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-file"></i></button>';
                    break;
                case 4:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth documentsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-file"></i></button>';
                    break;
                case 5:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth deviceLogsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-phone"></i></button>';
                    break;
                case 9:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth editICON cls111"  value=' . $value['_id']['$oid'] . '><i class="fa fa-edit"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth documentsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-file"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth deviceLogsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-phone"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth shiftLogsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-sort"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth resetPasswordICON cls111"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-refresh"></i></button>';
                    break;
                case 11:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth deviceLogsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-phone"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth manualLogoutICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-log-out"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth makeOfflineICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-eye-close"></i></button>';

                    break;
                case 12:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth documentsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-file"></i></button>';
                    break;
                case 13:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth documentsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-file"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth deviceLogsICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-phone"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth manualLogoutICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-log-out"></i></button>';
                    break;
            }


            $mobile = $value['countryCode'] . $value['mobile'];

            $arr = array();
            $arr[] = $accType;
            $arr[] = isset($value['registerFrom']) ? 'Web' : $value['mobileDevices']['appVersion'];
            $arr[] = '<a style="cursor: pointer;" id="driverID' . $value['_id']['$oid'] . '"  class="getDriverDetails" mas_id="' . $value['_id']['$oid'] . '">' . $value['firstName'] . ' ' . $value['lastName'] . '</a>';
            $arr[] = ($value['cityName'] == '' || $value['cityName'] == null) ? "N/A" : $value['cityName'];
            $arr[] = $this->Home_m->maskFileds($value['email'], 1);
            $arr[] = $this->Home_m->maskFileds($mobile, 2);            
            $arr[] = ($value['storeName'] == '' || $value['storeName'] == null) ? "N/A" : $value['storeName'];
            $arr[] = $plan;
            $arr[] = ($value['referralCode'] == '') ? "N/A" : $value['referralCode'];
            $arr[] = (isset($value['memberRenewalDate']) && $value['memberRenewalDate'] != '') ? date('d-M-Y h:i:s a ', ($value['memberRenewalDate']) - ($this->session->userdata('timeOffset') * 60)): 'Free Account';
            $arr[] = ($value['avgRating'] != '' || $value['avgRating'] != null) ? '<a href="' . base_url() . 'index.php?/superadmin/driverRate/' . $value['_id']['$oid'] . '" style="cursor: pointer;">4</a>' : '0';
            $arr[] = $walletSoftLimit . $walletHardLimit;
            $arr[] = '<div class="switch" data-id="' . $value['_id']['$oid'] . '" style="margin-top: 14px;float: left;"><input id="' . $value['_id']['$oid'] . '"  class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;" ' . $setCreditEn . '><label for="' . $value['_id']['$oid'] . '"></label></div><div class="pull-right m-t-10 new_button cls111" style="' . $setCreditButton . '"> <button class="walletSettings btn btn-info" style="width: 45px;" driverID = "' . $value['_id']['$oid'] . '">Set</button></div>';
            $arr[] = (isset($value['rejectedOn']) && $value['rejectedOn'] != '') ?  date('d-M-Y h:i:s a ', ($value['rejectedOn']) - ($this->session->userdata('timeOffset') * 60)) : 'N/A'; //Rejected date
            $arr[] = date('j-M-Y g:i A', $value['createdDate']);
            $arr[] = $status;
//          $arr[] = '<img src="'.$value['image'].'" width="50px" height="50px" class="imageborder" onerror="this.src=\'' . base_url() . 'pics/user.jpg\'">';
            $arr[] = number_format($value['location']['latitude'], 6) . ', ' . number_format($value['location']['longitude'], 6).$elapsed;
            $arr[] = '<a  class="btn btn-info pull-right m-t-10 " style="margin-top: 5px;" href="' . base_url() . 'index.php?/driver_controller/shiftLogs/' . $value['_id']['$oid'] . '">Logs</a>';
            $arr[] = ($value['reason'] == '' || $value['reason'] == null) ? 'N/A' : $value['reason'];
            $arr[] = (isset($value['bannedOn']) && $value['bannedOn'] != '') ?  date('d-M-Y h:i:s a ', ($value['bannedOn']) - ($this->session->userdata('timeOffset') * 60)) : 'N/A'; //Rejected date
//            $arr[] =  "";
            $arr[] = $action;
            $arr[] = '<input type="checkbox" class="checkbox checkboxAccept" name="checkbox" storeId="' . $value['storeId']['$oid'] . '" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_drivers($for = '', $status = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        // echo $for;die;
        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "firstName";
        $_POST['mDataProp_1'] = "mobile";
        $_POST['mDataProp_2'] = "email";
        $_POST['mDataProp_3'] = "planName";
        $_POST['mDataProp_4'] = "referralCode";

        $driverType = $this->session->userdata('operatorType');
        $operator = $this->session->userdata('company_id');
        $store = $this->session->userdata('storeId');
        $plan = $this->session->userdata('plan');
       
       
        if ($for == 'my') {

            switch ($status) {
                case 0:switch ($driverType) {

                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 9, 'driverType' => 1), 'mobileDevices.lastISOdate', -1);
                           $respo['status'] = 0;
                                } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 9, 'planID' => new MongoDB\BSON\ObjectID($plan)), 'mobileDevices.lastISOdate', -1);
                            
                                $respo['status'] = 0;
                            }
                            break;

                        case '1':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 9, 'driverType' => 1), 'mobileDevices.lastISOdate', -1);
                            
                                $respo['status'] = 0;
                        } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 9, 'planID' => new MongoDB\BSON\ObjectID($plan)), 'mobileDevices.lastISOdate', -1);
                            
                                $respo['status'] = 0;
                            }
                            break;

                    }
                    break;

                case 1:switch ($driverType) {

                        case '':
                            if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1, 'driverType' => 1));
                            $respo['status'] = 1;
                                
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1,'driverType' => 1));
                           $respo['status'] = 1;
                                }
                            break;

                        case '1':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1, 'driverType' => 1));
                            
                                $respo['status'] = 1;
                        } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 1,'driverType' => 1 ));
                            
                                $respo['status'] = 1;
                            }
                            break;


                    }
                    break;
                case 3:switch ($driverType) {
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [3])));
                           $respo['status'] = 3;
                                } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('planID' => new MongoDB\BSON\ObjectID($plan), 'status' => array('$in' => [3]), 'driverType' => 1));
                           $respo['status'] = 3;
                                }
                            break;

                        case '1':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [3]), 'driverType' => 1));
                            $respo['status'] = 3;
                                
                        } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('planID' => new MongoDB\BSON\ObjectID($plan), 'status' => array('$in' => [3])));
                                var_dump('pass4');
                                $respo['status'] = 3;
                            }
                            break;

                    }
                    break;
                case 4:switch ($driverType) {
                        case '':if ($plan == ''){
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 6, 'driverType' => 1));
                        
                                  $respo['status'] = 4;
                        }else{
                                $respo = $this->datatables->datatable_mongodb('driver', array('planID' => new MongoDB\BSON\ObjectID($plan), 'status' => 6));
                        
                                  $respo['status'] = 4;
                        }break;
                        case '1':if ($plan == ''){
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 6, 'driverType' => 1));
                        
                                $respo['status'] = 4;
                        } else{
                                $respo = $this->datatables->datatable_mongodb('driver', array('planID' => new MongoDB\BSON\ObjectID($plan), 'status' => 6));
                        
                                $respo['status'] = 4;
                        } break;

                    }
                    break;
                case 5:switch ($driverType) {
                        case '':if ($plan == ''){
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 7, 'driverType' => 1));
                        
                                  $respo['status'] = 5;
                        }else{
                                $respo = $this->datatables->datatable_mongodb('driver', array('planID' => new MongoDB\BSON\ObjectID($plan), 'status' => 7));
                              $respo['status'] = 5;
                                
                            }break;

                        case '1':if ($plan == ''){
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 7, 'driverType' => 1));
                          $respo['status'] = 5;
                                
                        }else{
                                $respo = $this->datatables->datatable_mongodb('driver', array('planID' => new MongoDB\BSON\ObjectID($plan), 'status' => 7));
                                 $respo['status'] = 5;
                                
                        }break;


                    }
                    break;
                case 8:switch ($driverType) {
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [2, 7]), 'driverType' => 1));

                                $respo['status'] = 8;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('planID' => new MongoDB\BSON\ObjectID($plan), 'status' => array('$in' => [2, 7])));
                                $respo['status'] = 8;
                            }break;
                        case '1':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [2, 7]), 'driverType' => 1));
                                $respo['status'] = 8;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('planID' => new MongoDB\BSON\ObjectID($plan), 'status' => array('$in' => [2, 7])));
                                $respo['status'] = 8;
                            } break;

                    }
                    break;
                case 9:switch ($driverType) {
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('driverType' => 1, 'status' => array('$in' => [3, 4, 5, 9, 8])));
                                $respo['status'] = 9;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('planID' => new MongoDB\BSON\ObjectID($plan), 'status' => array('$in' => [3, 4, 8])));
                                $respo['status'] = 9;
                            } break;

                        case '1':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [3, 4, 5, 9, 8]), 'driverType' => 1));
                                $respo['status'] = 9;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('planID' => new MongoDB\BSON\ObjectID($plan), 'status' => array('$in' => [3, 4, 8])));
                                $respo['status'] = 9;
                            } break;


                    }
                    break;
            }
        } else if ($for == 'mo') {

            switch ($status) {
                case 3:switch ($driverType) {//online or free
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 3, 'driverType' => 1));
                                // var_dump($respo);
                                // exit;
                                $respo['status'] = 11;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 3, 'planID' => new MongoDB\BSON\ObjectID($plan)));
                                $respo['status'] = 11;
                            }
                            break;
                        case '1':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 3, 'driverType' => 1));
                                $respo['status'] = 11;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 3, 'planID' => new MongoDB\BSON\ObjectID($plan)));
                                $respo['status'] = 11;
                            }
                            break;


                    }
                    break;
                case 567:switch ($driverType) {//logged out
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 8, 'driverType' => 1));
                                $respo['status'] = 12;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 8, 'planID' => new MongoDB\BSON\ObjectID($plan)));
                                $respo['status'] = 12;
                            }
                            break;
                        case '1':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 8, 'driverType' => 1));
                                $respo['status'] = 12;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 8, 'planID' => new MongoDB\BSON\ObjectID($plan)));
                                $respo['status'] = 12;
                            }
                            break;


                    }
                    break;
                case 30:switch ($driverType) {
                        //offline
                        case '':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 4, 'driverType' => 1));
                                $respo['status'] = 13;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 4, 'planID' => new MongoDB\BSON\ObjectID($plan)));
                                $respo['status'] = 13;
                            }
                            break;
                        case '1':if ($plan == '') {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 4, 'driverType' => 1));
                                $respo['status'] = 13;
                            } else {
                                $respo = $this->datatables->datatable_mongodb('driver', array('status' => 4, 'planID' => new MongoDB\BSON\ObjectID($plan)));
                                $respo['status'] = 13;
                            }
                            break;


                    }
                    break;
            }
        }

        //get data from App config for wallet
        $appConfig = $this->mongo_db->where(array())->find_one('appConfig');

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            //Location LatLong
            if ($value['location']['latitude'] === 0.0)
                $elapsed = '';
            else {
                if ($value['mobileDevices']['lastLogin'] != NULL || $value['mobileDevices']['lastLogin'] != '') {
                    $time = (int) (time() - $value['mobileDevices']['lastLogin']);
                    $timeAgo = $this->datatables->secondsToTime($time);

                    $diffTime = $timeAgo['m'] . ' min ago';

                    if ((int) $timeAgo['h'] > 0)
                        $diffTime = $timeAgo['h'] . ' hour ' . $diffTime;

                    if ((int) $timeAgo['d'] > 0)
                        $diffTime = $timeAgo['d'] . ' day ' . $diffTime;

                    $elapsed = '<br> <b><span style="color:#1ABB9C;font-style: italic;font-size: 10px;">' . $diffTime . '</span></b>';
                } else
                    $elapsed = '';
            }

            //CREDIT LINE
            $walletSoftLimit = '(' . $appConfig['currencySymbol'] . ' ' . $appConfig['walletSettings']['softLimitDriver'] . ') ';
            if (isset($value['walletSoftLimit']) && $value['walletSoftLimit'] != NULL && $value['walletSoftLimit'] != '')
                $walletSoftLimit = '(' . $appConfig['currencySymbol'] . ' ' . $value['walletSoftLimit'] . ') ';

            $walletHardLimit = $appConfig['currencySymbol'] . ' ' . $appConfig['walletSettings']['hardLimitDriver'];
            if (isset($value['walletHardLimit']) && $value['walletHardLimit'] != NULL && $value['walletHardLimit'] != '')
                $walletHardLimit = $appConfig['currencySymbol'] . ' ' . $value['walletHardLimit'];

            $plan = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['planID']['$oid'])))->find_one('Driver_plans');
            $vehicleTypes = '';


            //Setting credit line
            $setCreditEn = ($value['setCreditEnable'] == TRUE) ? (($appConfig['walletSettings']['walletDriverEnable'] == TRUE) ? 'checked' : '') : '';
            $setCreditButton = ($value['setCreditEnable'] == TRUE) ? (($appConfig['walletSettings']['walletDriverEnable'] == TRUE) ? 'display:block;' : 'display:none;') : 'display:none;';

            //check if the new plan updated
            
            if (count($value['newPlans']) > 0) {
                foreach ($value['newPlans'] as $eachNewPlan)
                    $plan = $eachNewPlan['planName'];
            } else if($plan['planName'] == "" || $plan['planName'] == null){
                $plan = "N/A";
            }else{
                $plan = $plan['planName'];
            }
            switch ($value['driverType']) {
                case 1:
                    $accType = 'Freelancer';
                    $nam = "N/A";
                    $citName = $value['citName'];
                    break;
                case 3:
                    $accType = 'Store';
                    $nam = $value['storeName'];
                    break;
            }


            if ($value['cityId'] == '' || $value['cityId'] == null || $value['cityId'] == 0 || $value['cityId'] == '0') {
                $citName = 'N/A';
            } else {
                // $cityName = $this->mongo_db->where(array('cities.cityId' => new MongoDB\BSON\ObjectID($value['cityId']['$oid'])))->find_one('cities');
                foreach ($cityName['cities'] as $city) {
                    if ($value['cityId']['$oid'] == $city['cityId']['$oid']) {
                        $citName = $city['cityName'];
                    }
                }
            }
            switch ($value['status']) {
                case 3:
                    $status = "Online";
                    break;
                case "3":
                    $status = "Online";
                    break;
                case 4:
                    $status = "Offline";
                    break;
                case "4":
                    $status = "Offline";
                    break;
                case 6:
                    $status = "Rejected";
                    break;
                case "6":
                    $status = "Rejected";
                    break;
                case 7:
                    $status = "Banned";
                case "7":
                    $status = "Banned";
                    break;
                case 8:
                    $status = "Logged Out";
                    break;
                case "8":
                    $status = "Logged Out";
                    break;
                case 9:
                    $status = "Timed Out";
                    break;
                case "9":
                    $status = "Timed Out";
                    break;
                default :
                    $status = "Approved";
                    break;
            }
            switch ($respo['status']) {
                case 0:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth deviceLogsStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-phone"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth manualLogoutStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-file"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth resetPasswordStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-refresh"></i></button>';
                    break;
                case 1:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth editStoreICON cls111"  value=' . $value['_id']['$oid'] . '><i class="fa fa-edit"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth documentsStoreICON cls111"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-file"></i></button>';
                    break;
                case 4:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth documentsStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-file"></i></button>';
                    break;
                case 5:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth deviceLogsStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-phone"></i></button>';
                    break;
                case 9:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth editStoreICON"  value=' . $value['_id']['$oid'] . '><i class="fa fa-edit"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth documentsStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-file"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth deviceLogsStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-phone"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth shiftLogsStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-sort"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth resetPasswordStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-refresh"></i></button>';
                    break;
                case 11:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth deviceLogsStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-phone"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth manualLogoutStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-log-out"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth makeOfflineStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-eye-close"></i></button>'
							. '<button style="width:35px;" class="btn btn-primary btnWidth shiftLogsStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-sort"></i></button>';
                    break;
                case 12:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth documentsStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-file"></i></button>';
                    break;
                case 13:
                    $action = '<button style="width:35px;" class="btn btn-primary btnWidth documentsStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-file"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth deviceLogsStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-phone"></i></button>'
                            . '<button style="width:35px;" class="btn btn-primary btnWidth manualLogoutStoreICON"  value=' . $value['_id']['$oid'] . '><i class="glyphicon glyphicon-log-out"></i></button>';
                    break;
            }

            $currentWalletBalance = '<span style="font-size: 9px;font-weight: 600;color: #1ABB9C;">Wallet Bal (' . $value['currency'] . ' ' . $value['wallet']['balance'] . ')</span><br>';
            $walletSoftLimit = '<span style="font-size: 9px;font-weight: 600;color: dodgerblue;">SL (' . $value['currency'] . ' ' . $value['wallet']['softLimit'] . ') </span><br>';
            $walletHardLimit = '<span style="font-size: 9px;font-weight: 600;color: #d03c70;">HL (' . $value['currency'] . ' ' . $value['wallet']['hardLimit'] . ') </span>';



            $arr = array();
            $arr[] = $accType;
            $arr[] = isset($value['registerFrom']) ? 'Web' : $value['mobileDevices']['appVersion'];
            $arr[] = '<a style="cursor: pointer;" id="driverID' . $value['_id']['$oid'] . '"  class="getDriverDetails" mas_id="' . $value['_id']['$oid'] . '">' . $value['firstName'] . ' ' . $value['lastName'] . '</a>';
            $arr[] = ($value['cityName'] == "")?"N/A":$value['cityName'];
            $arr[] = $this->Home_m->maskFileds($value['email'], 1);;
            $arr[] = $this->Home_m->maskFileds($value['countryCode'] . $value['mobile'], 2);;
            $arr[] = $nam;
            $arr[] = $plan;
            $arr[] = ($value['referralCode'] == '') ? "N/A" : $value['referralCode'];
            $arr[] = (isset($value['memberRenewalDate']) && $value['memberRenewalDate'] != '') ?  date('d-M-Y h:i:s a ', ($value['memberRenewalDate']) - ($this->session->userdata('timeOffset') * 60)) : 'Free Account';
            $arr[] = ($value['avgRating'] != '' || $value['avgRating'] != null) ? '<a href="' . base_url() . 'index.php?/superadmin/driverRate/' . $value['_id']['$oid'] . '" style="cursor: pointer;">4</a>' : '0';
            $arr[] = $walletSoftLimit . $walletHardLimit;
            $arr[] = '<div class="switch" data-id="' . $value['_id']['$oid'] . '" style="margin-top: 14px;float: left;"><input id="' . $value['_id']['$oid'] . '"  class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;" ' . $setCreditEn . '><label for="' . $value['_id']['$oid'] . '"></label></div><div class="pull-right m-t-10 new_button cls111" style="' . $setCreditButton . '"> <button class="walletSettings btn btn-info" style="width: 45px;" driverID = "' . $value['_id']['$oid'] . '">Set</button></div>';
            $arr[] = (isset($value['rejectedOn']) && $value['rejectedOn'] != '') ?  date('d-M-Y h:i:s a ', ($value['rejectedOn']) - ($this->session->userdata('timeOffset') * 60)) : 'N/A'; //Rejected date
            $arr[] = date('j-M-Y g:i A', $value['createdDate']);
            $arr[] = $status;
            $arr[] = number_format($value['location']['latitude'], 6) . ', ' . number_format($value['location']['longitude'], 6).$elapsed;
            $arr[] = '<a  class="btn btn-info pull-right m-t-10 " style="margin-top: 5px;" href="' . base_url() . 'index.php?/driver_controller/shiftLogs/' . $value['_id']['$oid'] . '">Logs</a>';
            $arr[] = ($value['reason'] == '' || $value['reason'] == null) ? 'N/A' : $value['reason'];
            $arr[] = (isset($value['bannedOn']) && $value['bannedOn'] != '') ?  date('d-M-Y h:i:s a ', ($value['bannedOn']) - ($this->session->userdata('timeOffset') * 60)) : 'N/A'; //Rejected date
            $arr[] = $action;//20
            $arr[] = $currentWalletBalance . $walletSoftLimit . $walletHardLimit . '<div class=" m-t-10 new_button cls111"> <button class="walletSettings btn btn-info" style="width: 45px;" driverID = "' . $value['_id']['$oid'] . '">Set</button></div>';
            $arr[] = '<input type="checkbox" class="checkbox " name="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_getDriversForOperators($operatorID = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "firstName";
        $_POST['mDataProp_1'] = "mobile";
        $_POST['mDataProp_2'] = "email";
        $_POST['mDataProp_3'] = "plateNo";
        $_POST['mDataProp_4'] = "referralCode";

        $driverType = $this->session->userdata('operatorType');
        $operator = $this->session->userdata('company_id');
        $plan = $this->session->userdata('plan');

        $respo = $this->datatables->datatable_mongodb('driver', array('companyId' => new MongoDB\BSON\ObjectID($operatorID)));


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            if ($value['location']['latitude'] === 0.0)
                $elapsed = '';
            else {
                if ($value['lastTs'] != NULL || $value['lastTs'] != '') {
                    $time = (int) (time() - $value['lastTs']);
                    $timeAgo = $this->datatables->secondsToTime($time);

                    $diffTime = $timeAgo['m'] . ' min ago';

                    if ((int) $timeAgo['h'] > 0)
                        $diffTime = $timeAgo['h'] . ' hour ' . $diffTime;

                    if ((int) $timeAgo['d'] > 0)
                        $diffTime = $timeAgo['d'] . ' day ' . $diffTime;

                    $elapsed = '<br> <b><span style="color:#1ABB9C;font-style: italic;font-size: 10px;">' . $diffTime . '</span></b>';
                } else
                    $elapsed = '';
            }

            $plan = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['planID']['$oid'])))->find_one('Driver_plans');
            $vehicleTypes = '';
            if ($value['type']['$oid'] != '' && $value['type']['$oid'] != '')
                $vehicleTypes = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['type']['$oid'])))->find_one('vehicleTypes');


            $vehiclesCount = $this->mongo_db->where(array('mas_id' => new MongoDB\BSON\ObjectID($value['_id']['$oid'])))->count('vehicles');

            $arr = array();

            $arr[] = '<a style="cursor: pointer;" id="driverID' . $value['_id']['$oid'] . '"  class="getDriverDetails" mas_id="' . $value['_id']['$oid'] . '">' . $value['firstName'] . ' ' . $value['lastName'] . '</a>';
            $arr[] = $value['countryCode'] . $value['mobile'];

            $arr[] = $vehicleTypes['type_name'];
            $arr[] = $plan['plan_name'];

            $arr[] = '<a href="' . base_url() . 'index.php?/superadmin/driverRate/' . $value['_id']['$oid'] . '" style="cursor: pointer;">4</a>';
            $arr[] = (!in_array($value['status'], array(3, 4))) ? unserialize(DriverStatus)[$value['status']] : unserialize(DriverStatus)[$value['status']] . '<br>' . number_format($value['location']['latitude'], 6) . ', ' . number_format($value['location']['longitude'], 6) . $elapsed;



            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '"/>';

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_getVehiclesForOperators($operatorID = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

//        $_POST['iColumns'] = 5;
//        $_POST['mDataProp_0'] = "firstName";
//        $_POST['mDataProp_1'] = "mobile";
//        $_POST['mDataProp_2'] = "email";
//        $_POST['mDataProp_3'] = "plateNo";
//        $_POST['mDataProp_4'] = "referralCode";

        $driverType = $this->session->userdata('operatorType');
        $operator = $this->session->userdata('company_id');
        $plan = $this->session->userdata('plan');

        $respo = $this->datatables->datatable_mongodb('vehicles', array('operator' => new MongoDB\BSON\ObjectID($operatorID), 'account_type' => 2));


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $masterData = '';
            if (isset($value['mas_id']) && $value['mas_id']['$oid'] != "")
                $masterData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['mas_id']['$oid'])))->find_one('driver');
            if ($value['status'] == '5') {

                if ($masterData['location']['latitude'] === 0.0)
                    $elapsed = '';
                else {
                    if ($masterData['lastTs'] != NULL || $masterData['lastTs'] != '') {
                        $time = (int) (time() - $masterData['lastTs']);
                        $timeAgo = $this->datatables->secondsToTime($time);

                        $diffTime = $timeAgo['m'] . ' min ago';

                        if ((int) $timeAgo['h'] > 0)
                            $diffTime = $timeAgo['h'] . ' hour ' . $diffTime;

                        if ((int) $timeAgo['d'] > 0)
                            $diffTime = $timeAgo['d'] . ' day ' . $diffTime;

                        $elapsed = '<br> <b><span style="color:#1ABB9C;font-style: italic;font-size: 10px;">' . $diffTime . '</span></b>';
                    } else
                        $elapsed = '';
                }
            }

            $arr = array();
            $arr[] = $value['platNo'];
            $arr[] = $value['make'];
            $arr[] = $value['model'];
            $arr[] = ($value['status'] != 5) ? 'N/A' : '<a style="cursor: pointer;" id="driverID' . $value['mas_id']['$oid'] . '"  class="getDriverDetails" mas_id="' . $value['mas_id']['$oid'] . '">' . $value['driverName'] . '</a>';
            $arr[] = ($value['status'] != 5) ? 'N/A' : $masterData['countryCode'] . $value['driverMobile'];

            $arr[] = ($value['status'] == 5) ? (!in_array($masterData['status'], array(3, 4))) ? unserialize(vehicleStatus)[$value['status']] : unserialize(vehicleStatus)[$value['status']] . '<br>' . number_format($masterData['location']['latitude'], 6) . ', ' . number_format($masterData['location']['longitude'], 6) . $elapsed : unserialize(vehicleStatus)[$value['status']];
            $arr[] = ($masterData['lastLogin'] != '' && isset($masterData['lastLogin'])) ? date('j-M-Y g:i A', $masterData['lastLogin']['$date'] / 1000) : 'N/A';
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_driverRateForIndividual($ID = '', $stDate = '', $endDate = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "driverDetails.fName";
        $_POST['mDataProp_2'] = "slaveName";



        if ($stDate != '' && $endDate != '')
            $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('status' => 10, 'mas_id' => new MongoDB\BSON\ObjectID($ID), 'timpeStamp_appointment_date' => array('$gte' => strtotime($stDate), '$lte' => strtotime($endDate . ' 23:59:59'))));
        else
            $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('status' => 10, 'mas_id' => new MongoDB\BSON\ObjectID($ID)));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $arr = array();
            $arr[] = '<a target="_blank" href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['order_id'] . '">' . $value['order_id'] . '</a>';
            $arr[] = date('j-M-Y g:i A', $value['timpeStamp_booking_time']);
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slave_id']['$oid'] . '">' . $value['slaveName'] . '</a>';
            $arr[] = $value['customerReview'];
            $arr[] = $value['CustomerRating'];
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_customerRateForIndividual($ID = '', $stDate = '', $endDate = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "driverDetails.fName";
        $_POST['mDataProp_2'] = "slaveName";

        if ($stDate != '' && $endDate != '')
            $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('status' => 10, 'slave_id' => new MongoDB\BSON\ObjectID($ID), 'timpeStamp_appointment_date' => array('$gte' => strtotime($stDate), '$lte' => strtotime($endDate . ' 23:59:59'))));
        else
            $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('status' => 10, 'slave_id' => new MongoDB\BSON\ObjectID($ID)));


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $arr = array();
            $arr[] = '<a target="_blank" href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['order_id'] . '">' . $value['order_id'] . '</a>';
            $arr[] = date('j-M-Y g:i A', $value['timpeStamp_booking_time']);
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slave_id']['$oid'] . '">' . $value['slaveName'] . '</a>';
            $arr[] = $value['CustomerRating'];
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function get_options($id) {

        if ($id != '')
            return '<img src="' . base_url() . ServiceLink . '/' . $id . '" width="50px">';
        else
            return '<img src="' . base_url() . '../../admin/img/user.jpg" width="50px">';
    }

    function get_devicetype($id) {
//return $id;

        if ($id)
            return '<img src="' . base_url() . '../../admin/assets/' . $id . '" width="50px" class="imageborder" >';
        else
            return '<img src="' . base_url() . '../../admin/img/user.jpg" width="50px" class="imageborder">';
    }

    function datatable_dispatcher($status = '') {

        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "name";
        $_POST['mDataProp_1'] = "email";
        $_POST['mDataProp_2'] = "city_name";


        $respo = $this->datatables->datatable_mongodb('dispatcher', array('status' => (int) $status));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $arr = array();
            $arr[] = $value['name'];
            $arr[] = (isset($value['managerName'])) ? $value['managerName'] : '';
            $arr[] = $value['city_name'];
            $arr[] = $value['email'];
            $arr[] = unserialize(DispatcherStatus)[$value['status']];
            $arr[] = $value['currentIPAddress'];
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_driverreview($status = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "driverDetails.fName";
        $_POST['mDataProp_2'] = "slaveName";


        $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('status' => 10));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $arr = array();
            $arr[] = '<a target="_blank" href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['order_id'] . '">' . $value['order_id'] . '</a>';
            $arr[] = date('j-M-Y H:i:s', $value['timpeStamp_booking_time']);
            $arr[] = '<a style="cursor: pointer;" id="driverID' . $value['_id']['$oid'] . '"  class="getDriverDetails" mas_id="' . $value['mas_id']['$oid'] . '">' . $value['driverDetails']['fName'] . '</a>';
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slave_id']['$oid'] . '">' . $value['slaveName'] . '</a>';
            $arr[] = $value['customerReview'];
            $arr[] = $value['CustomerRating'];
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function editNewVehicleData($id) {
        $this->load->library('mongo_db');

        $OwnershipType = $this->input->post('OwnershipType');
        $goodType = $this->input->post('goodType');
        $selected_driver = $this->input->post('selected_driver');
        $driverName = $this->input->post('driverName');
        $driverMobile = $this->input->post('driverMobile');
        $title = $this->input->post('title');

//        $color = $this->input->post('color');

        $vehiclemodel = $this->input->post('vehiclemodel');
        $vechileregno = $this->input->post('vechileregno');
        $licenceplaetno = $this->input->post('licenceplaetno');
        $type_id = $this->input->post('getvechiletype');
        $Vehicle_Insurance_No = $this->input->post('Vehicle_Insurance_No');
        $vehicleTypeName = $this->input->post('vehicleTypeName');
        $expirationrc = $this->input->post('expirationrc');

        //Images
        $image_name = $this->input->post('vehicleImage');
        $registationCertificate = $this->input->post('registationCertificate');
        $motorCertificate = $this->input->post('motorCertificate');
        $PermitCertificate = $this->input->post('PermitCertificate');

        $expirationinsurance = $this->input->post('expirationinsurance');
        $expirationpermit = $this->input->post('expirationpermit');

        $companyname = $this->input->post('company_id');
        $operatorName = $this->input->post('operatorName');

        if ($OwnershipType == 1)
            $fdata = array('operator' => new MongoDB\BSON\ObjectID($companyname), 'operatorName' => $this->input->post('operatorName'), 'modelId' => new MongoDB\BSON\ObjectID($vehiclemodel), 'model' => $this->input->post('vehicleModelName'), 'makeId' => new MongoDB\BSON\ObjectID($title), 'make' => $this->input->post('vehicleMakeName'), 'platNo' => $licenceplaetno, 'goodTypes' => $goodType, 'account_type' => (int) $OwnershipType, 'type_id' => new MongoDB\BSON\ObjectID($type_id), 'type' => $this->input->post('vehicleTypeName'), 'mas_id' => new MongoDB\BSON\ObjectID($selected_driver), 'driverName' => $this->input->post('driverName'), 'driverMobile' => $driverMobile, 'reg_number' => $vechileregno, 'licence_numer' => $licenceplaetno, 'insurance_number' => $Vehicle_Insurance_No, 'regCertExpr' => $expirationrc, 'motorInsuExpr' => $expirationinsurance, 'permitExpr' => $expirationpermit);
        else
            $fdata = array('operator' => new MongoDB\BSON\ObjectID($companyname), 'operatorName' => $this->input->post('operatorName'), 'modelId' => new MongoDB\BSON\ObjectID($vehiclemodel), 'model' => $this->input->post('vehicleModelName'), 'makeId' => new MongoDB\BSON\ObjectID($title), 'make' => $this->input->post('vehicleMakeName'), 'platNo' => $licenceplaetno, 'goodTypes' => $goodType, 'account_type' => (int) $OwnershipType, 'type_id' => new MongoDB\BSON\ObjectID($type_id), 'type' => $this->input->post('vehicleTypeName'), 'mas_id' => '', 'driverName' => '', 'driverMobile' => '', 'reg_number' => $vechileregno, 'licence_numer' => $licenceplaetno, 'insurance_number' => $Vehicle_Insurance_No, 'regCertExpr' => $expirationrc, 'motorInsuExpr' => $expirationinsurance, 'permitExpr' => $expirationpermit);

        if ($image_name)
            $fdata['image'] = $image_name;
        else if ($registationCertificate)
            $fdata['regCertImage'] = $registationCertificate;
        else if ($motorCertificate)
            $fdata['motorInsuImage'] = $motorCertificate;
        else if ($PermitCertificate)
            $fdata['permitImage'] = $PermitCertificate;

        $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->set($fdata)->update("vehicles");

        if ($OwnershipType == 1)
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($selected_driver)))->set(array('plateNo' => $licenceplaetno, 'vehicleTypeName' => $this->input->post('vehicleTypeName'), 'type' => new MongoDB\BSON\ObjectID($type_id)))->update('driver');


        return $selected_driver;
    }

    function delete_vehicletype() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');

        foreach ($val as $id)
            $this->mongo_db->where(array('type' => (int) $id))->delete('vehicleTypes');

        echo json_encode(array('msg' => "vehicle type deleted successfully", 'flag' => 0));
        return;
    }

    function delete_company() {
        $this->load->library('mongo_db');
        $query = $this->input->post('val');
        foreach ($query as $id)
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('operators');

        echo json_encode(array("msg" => "Your selected company has been deleted successfully", "flag" => 0));
        return;
    }

//    function getDeviceLogs($userType = '') {
//        $this->load->library('mongo_db');
//        if ($userType == "driver") {
//            $deviceLogs = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('mas_id'))))->find_one('driver');
//        } else {
//            $deviceLogs = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('slave_id'))))->find_one('slaves');
//        }
//        echo json_encode(array("data" => $deviceLogs));
//        return;
//    }

    function getDeviceLogs($userType = '') {
        $this->load->library('mongo_db');
        if ($userType == "driver") {
            $deviceLogs = $this->mongo_db->where(array('userId' => new MongoDB\BSON\ObjectID($this->input->post('mas_id')), 'userType' => 2))->get('mobileDevices');
            $name = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('mas_id'))))->find_one('driver');
        }
        echo json_encode(array('data' => $deviceLogs, 'user' => $name));
    }

    function setsessiondata($tablename, $LoginId, $res, $email, $password) {
        $sessiondata = array(
            'emailid' => $email,
            'password' => $password,
            'LoginId' => $res->$LoginId,
            'profile_pic' => $res->logo,
            'first_name' => $res->companyname,
            'table' => $tablename,
            'city_id' => '0', 'company_id' => '0',
            'validate' => true
        );
        return $sessiondata;
    }

    function validateEmail() {
        $this->load->library('mongo_db');
        $query = $this->mongo_db->where(array('email' => $this->input->post('email')))->find_one('driver');
        if (!empty($query)) {
            echo json_encode(array('msg' => '1'));
            return;
        } else {
            echo json_encode(array('msg' => '0'));
        }
    }

    function validateMobileNo() {
        $this->load->library('mongo_db');
        $query = $this->mongo_db->where(array('mobile' => $this->input->post('onlyMobileNo')))->find_one('driver');
        if (!empty($query)) {
            echo json_encode(array('msg' => '1'));
            return;
        } else {
            echo json_encode(array('msg' => '0'));
        }
    }

    function validateMobileNoEditDriver() {
        $this->load->library('mongo_db');
        $query = $this->mongo_db->where(array('mobile' => $this->input->post('onlyMobileNo')))->find_one('driver');
        $getData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('driverId'))))->find_one('driver');

        if (!empty($query)) {
            if ($getData['mobile'] == $query['mobile']) {
                echo json_encode(array('msg' => '0'));
            } else {
                echo json_encode(array('msg' => '1'));
            }
        } else {
            echo json_encode(array('msg' => '0'));
        }
    }

    function validatedispatchEmail() {

        $this->load->library('mongo_db');
        $row = $this->input->post('email');
        $res = $this->mongo_db->get_where('dispatcher', array('email' => $row));
        foreach ($res as $data) {
            
        }
        if ($data > 0) {
            echo json_encode(array('msg' => 1));
            return;
        } else {
            echo json_encode(array('msg' => 0));
            return;
        }
    }

    function editpassDispatcher() {
        $this->load->library('mongo_db');
        $pass = $this->input->post('newpass');
        $dis_id = $this->input->post('val');
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($dis_id)))->set(array('password' => md5($pass)))->update('dispatcher');
        if ($res > 0) {
            echo json_encode(array('flag' => '0', 'msg' => 'New password has been updated succesfully'));
            return;
        } else {
            echo json_encode(array('flag' => '1', 'msg' => 'Updation failed'));
            return;
        }
    }

    function editdriver($status = '') {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($status)))->find_one('driver');
        return $data;
    }

    function getBookingHistory() {
        $this->load->library('mongo_db');
        $mongoData = $this->mongo_db->where(array('orderId' => (int) $this->input->post('order_id')))->find_one('unassignOrders');

        $dispatcheStatus = array('0' => 'Declined By Admin', '1' => 'Did not respond', '2' => 'Declined', '3' => 'Accepted');

        foreach ($mongoData['dispatched'] as $dispatchedBooking) {
//               if($mongoData['mas_id'] != $dispatchedBooking['DriverId'])
            $datatosend1[] = array('order_id' => $mongoData['orderId'], 'driver_id' => $dispatchedBooking['driverId']['$oid'], 'driverName' => $dispatchedBooking['fName'] . ' ' . $dispatchedBooking['lName'], 'driverPhone' => $dispatchedBooking['mobile'], 'bookingReceivedTime' => ($dispatchedBooking['serverTime'] != '') ? date('j-M-Y h:i:s', $dispatchedBooking['serverTime']) : '', 'status' => ($dispatchedBooking['status'] == 1) ? 'In-Dispatch' : $dispatchedBooking['status']);
        }

        echo json_encode(array('bookingHistoryData' => $datatosend1, 'bookingType' => ($mongoData['bookingType'] == '1') ? 'NOW' : 'LATER'));
        return;
    }

//     function maskEmail($input) {
//         $email = explode('@',$input);
//         $email = substr($email[0], 1);
//     }

    function getDriverDetails() {

        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('mas_id'))))->find_one('driver');


//        if($this->session->userdata('emailid') == 'demo@yahoo.com')
//        {
//            $data['email'] = $data['email'];
//        }
//      $data['createdDt'] = date('j-M-Y g:i A',(int)($data['createdDt']['$date']/1000));
        $data['createdDt'] = (int) ($data['createdDt']['$date'] / 1000);

        if (count($data['newPlans']) > 0) {
            $Driver_plans = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['newPlans'][count($data['newPlans']) - 1]['planID']['$oid'])))->find_one('Driver_plans');
        } else
            $Driver_plans = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($data['planID']['$oid'])))->find_one('Driver_plans');

        echo json_encode(array('driverData' => $data, 'driverPlan' => $Driver_plans));
        return;
    }

    function getAllDriversDetails() {
        $this->load->library('mongo_db');
        $ids = $this->input->post('mas_id');
        foreach ($ids as $id) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id), 'status' => 3))->find_one('driver');
            if ($result)
                $data[] = $result;
        }

        echo json_encode(array('driverData' => $data, 'driverCount' => count($data)));
        return;
    }

    function getDriver($driverID = '') {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($driverID)))->find_one('driver');
        return $data;
    }

    function getCustomerData($customerID = '') {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($customerID)))->find_one('slaves');
        return $data;
    }

    function getDriversReferralsList() {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('mas_id'))))->find_one('driver');
        if (isset($data['referralUsedBy']) && count($data['referralUsedBy']) > 0) {
            foreach ($data['referralUsedBy'] as $referral) {
                $response = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($referral['$oid'])))->find_one('driver');
                if ($response)
                    $result [] = $response;
            }
        }
        echo json_encode(array('driverData' => $result));
        return;
    }

    function getCustomerReferralsList() {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('slave_id'))))->find_one('slaves');
        if (isset($data['referralUsedBy']) && count($data['referralUsedBy']) > 0) {
            foreach ($data['referralUsedBy'] as $referral) {
                $response = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($referral['$oid'])))->find_one('slaves');
                if ($response)
                    $result [] = $response;
            }
        }
        echo json_encode(array('customerData' => $result));
        return;
    }

    function getReferralDetails() {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('masterId'))))->find_one('driver');
//      print_r($data);exit();
        echo json_encode(array('masterData' => $data));
        return;
    }

    function getCustomerDetails() {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('slave_id'))))->find_one('customer');
        echo json_encode(array('driverData' => $data));
        return;
    }

    function getbooking_data($status = '', $stDate = '', $endDate = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 7;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "driverDetails.fName";
        $_POST['mDataProp_2'] = "slaveName";
        $_POST['mDataProp_3'] = "address_line1";
        $_POST['mDataProp_4'] = "appointment_dt";
        $_POST['mDataProp_5'] = "drop_addr1";
        $_POST['mDataProp_6'] = "pricingModel";


        //Check if filter by date 
        $condition = array();
        if ($status != '' && $status != '20')
            $condition ['status'] = (int) $status;

        if ($stDate != '' || $endDate != '') {
            $condition ['$or'][] = array('timpeStamp_appointment_date' => array('$gte' => strtotime($stDate), '$lte' => strtotime($endDate . ' 23:59:59')));
        }

        $respo = $this->datatables->datatable_mongodb('completedOrders', $condition);


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {


            if ($value['bookingType'] == 1) {
                $bookingType = 'Now';
            } else {
                $bookingType = 'Later';
            }
            if ($value['serviceType'] == 1) {
                $servicetype = "Delivery";
            } else if ($value['serviceType'] == 2) {
                $servicetype = "Pick UP";
            }
            if ($value['paymentType'] == 1) {
                $paymentType = "Card";
            } else if ($value['paymentType'] == 2) {
                $paymentType = "Cash";
            }


            //Booking Type with order id
//            $bookingType = ($value['appt_type'] == '2')?$value['order_id'].' (<b>Later</b>)':$value['order_id'].' (<b>Now</b>)';


            $arr = array();
            $arr[] = '<a href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['orderId'] . '" style="cursor: pointer;" id="' . $value['orderId'] . '"  bid="' . $value['orderId'] . '">' . $value['orderId'] . '</a>';
            $arr[] = ($bookingType == '') ? 'N/A' : $bookingType;
            $arr[] = ($servicetype == '') ? 'N/A' : $servicetype;
            $arr[] = ($value['bookingDate'] == '') ? 'N/A' : $value['bookingDate'];
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['customerDetails']['customerId'] . '">' . $value['customerDetails']['name'] . '</a>';
            $arr[] = ($value['storeName']) ? 'N/A' : $value['storeName'];
            $arr[] = '<a style="cursor: pointer;" class="getDriverDetails" slave="' . $value['driverDetails']['driverId']['$oid'] . '">' . $value['driverDetails']['fName'] . ' ' . $value['driverDetails']['lName'] . '</a>';
            $arr[] = $value['pickup']['addressLine1'] . '<br/>' . $value['pickup']['addressLine2'];
            $arr[] = $value['drop']['addressLine1'] . '<br/>' . $value['drop']['addressLine2'];
            $arr[] = ($value['totalAmount'] == '') ? 'N/A' : $value['totalAmount'] . '' . $value['currencySymbol'];
            $arr[] = ($value['deliveryCharge'] == '') ? 'N/A' : $value['deliveryCharge'] . '' . $value['currencySymbol'];
            $arr[] = ($paymentType == '') ? 'N/A' : $paymentType;
            $arr[] = '<p class="status' . $value['orderId'] . '">' . unserialize(JobStatus)[$value['status']] . '</p>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;

//        print_r($respo["aaData"]);
        echo json_encode($respo);
    }

    //Generate Random String for referrel code
    function generateRandomString($length) {
        return strtoupper(substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length));
    }

    function checkReferralIfExist($referralCode) {
        $this->load->library('mongo_db');
        $result = $this->mongo_db->where(array('referralCode' => $referralCode))->find_one('driver');
        if (!empty($result)) {
            $referralCode = $this->generateRandomString(6);
            $result = $this->checkReferralIfExist($referralCode);
        } else
            return $referralCode;
    }

    function AddNewDriverData() {
//         echo "<pre>";
//         print_r($_POST);
//         die;
        $this->load->library('mongo_db');
        $account_type = (int) $this->input->post('driverType');
//        $company_id = $this->input->post('company_select');
        $storeId = $this->input->post('store_select');
        $cityId = $this->input->post('city_select');
        $cityName = $this->input->post('cityName');

//        $operatorName = $this->input->post('operatorName');
        $storeName = $this->input->post('storeName');
        $firstname = $this->input->post('firstname');
        $last_name = $this->input->post('lastname');
        $password = $this->input->post('password');
        $password1 = password_hash($password, PASSWORD_BCRYPT);
        $password2 = str_replace("$2y$", "$2a$", $password1);
        $serviceZones = $this->input->post('checkboxs');
        $created_dt = $this->input->post('current_dt');
        $type_id = (int) 1;
        $status = (int) 1;
        //$date_of_birth = date('Y-m-d', strtotime($this->input->post('dob')));
        $date_of_birth = date('d-m-Y', strtotime($this->input->post('dob')));
        $email = $this->input->post('email');
        $countryCode = '+' . $this->input->post('coutry-code');
        $mobile = $this->input->post('mobile');
        $expirationrc = $this->input->post('expirationrc');
        $license_pic = $this->input->post('driverLicence');
        $license_picBack = $this->input->post('driverLicenceBack');
        $profile_pic = $this->input->post('driverImage');
        $wallet = array("balance" => 0,"blocked" => 0,"hardLimit" => 0,"softLimit" => 0,"softLimitHit" => false,"hardLimitHit" => false);

        $boxType = $this->input->post('packageBoxType');
        $packageBoxTypeId = $this->input->post('packageBoxTypeId');
        $deliveryType= $this->input->post('deliveryType');
        $deliveryTypeMsg= $this->input->post('deliveryTypeMsg');     
        
      
     
        if ($account_type == 3) {
            $mongoArr = array("pushToken"=>new MongoDB\BSON\ObjectID()."-".time(),"publishChn"=>new MongoDB\BSON\ObjectID()."-".time(),"listner"=>"driver_".new MongoDB\BSON\ObjectID().time(),'registerFrom' => 'web', "memberRenewalDate" => strtotime($memberRenewalDate), 'referralCode' => $getReferralCode,
                'storeName' => $storeName, 'storeId' => new MongoDB\BSON\ObjectID($this->input->post('store_select')), 'cityId' => $cityId, 'cityName' => $cityName, 'driverType' => (int) $this->input->post('driverType'), 'preferredZones' => $this->input->post('checkboxs'), 'serviceZones' => $this->input->post('checkboxs'), "firstName" => $firstname, "lastName" => $last_name,
                "location" => array("longitude" => 0, "latitude" => 0), 'dob' => $date_of_birth, "profilePic" => $this->input->post('driverImage'),
                'status' => 1, 'statusMsg' => "New",'wallet'=>$wallet, 'mobile' => $mobile, 'countryCode' => $countryCode, 'email' => strtolower($email), 'password' => $password2, 'createdDate' => time(), 'createdISODate' => $this->mongo_db->date($timestamp), 'driverLicense' => $license_pic, 'driverLicenseFront' => $license_pic, 'driverLicenseBack' => $license_picBack, 'driverLicenseExpiry' => $expirationrc,
                'boxType'=>$boxType,'packageBoxTypeId'=>$packageBoxTypeId,'deliveryType'=>$deliveryType,'deliveryTypeMsg'=> $deliveryTypeMsg,'planName'=>$this->input->post('planName') );
        } else {
            $mongoArr = array("pushToken"=>new MongoDB\BSON\ObjectID()."-".time(),"publishChn"=>new MongoDB\BSON\ObjectID()."-".time(),"listner"=>"driver_".new MongoDB\BSON\ObjectID().time(),'planID' => new MongoDB\BSON\ObjectID($this->input->post('plan')), 'cityId' => $cityId, 'cityName' => $cityName, 'registerFrom' => 'web', 'driverType' => (int) $this->input->post('driverType'),
                'preferredZones' => $this->input->post('checkboxs'), 'serviceZones' => $this->input->post('checkboxs'), "firstName" => $firstname, "lastName" => $last_name, "location" => array("longitude" => 0, "latitude" => 0),
                'dob' => $date_of_birth, "profilePic" => $this->input->post('driverImage'), 'status' => 1, 'statusMsg' => "New",'wallet'=>$wallet,				
                'mobile' => $mobile, 'countryCode' => $countryCode, 'email' => strtolower($email), 'password' => $password2, 'createdDate' => time(), 'createdISODate' => $this->mongo_db->date($timestamp), 'driverLicense' => $license_pic, 'driverLicenseFront' => $license_pic, 'driverLicenseBack' => $license_picBack, 'driverLicenseExpiry' => $expirationrc,
                'boxType'=>$boxType,'packageBoxTypeId'=>$packageBoxTypeId,'deliveryType'=>$deliveryType,'deliveryTypeMsg'=> $deliveryTypeMsg,'planName'=>$this->input->post('planName') );
        }        
        $return = $this->mongo_db->insert('driver', $mongoArr);

        //Sending an email
        $dat = array('name' => $firstname . '  ' . $last_name, 'userId' => $return, 'email' => $email, 'mobile' => $countryCode . $mobile, 'status' => 11, 'reason1' => ($getData['reason'] == '') ? "N/A" : $getData['reason'], 'password' => $password);
        $url = APILink . 'admin/email';
        $response = json_decode($this->callapi->CallAPI('POST', $url, $dat), true);
        if($storeId !="" || $storeId !=null){
             $redirect ="stores";
             return $redirect;
        }else{
            $redirect ="drivers";
        return $redirect;
        }
    }

    function editdriverdata() {
        $this->load->library('mongo_db');
      
	   $account_type = 1;
        
        $storeId = $this->input->post('store_select');
        $storeName = $this->input->post('storeName');

        if (!empty($this->input->post('checkboxs'))){
            $zonesSelected = $this->input->post('checkboxs');
		}
        $driverid = $this->input->post('driver_id');
        

        $first_name = $this->input->post('firstname');
        $last_name = $this->input->post('lastname');
        $password = $this->input->post('password');

        $email = $this->input->post('email');
       // $dob = date('Y-m-d', strtotime($this->input->post('dob')));
        $dob = date('d-m-Y', strtotime($this->input->post('dob')));
        $mobile = $this->input->post('mobile');
        $countryCode = '+' . $this->input->post('coutry-code');
        $expirationrc = $this->input->post('expirationrc');


        $license_pic = $this->input->post('driverLicence');
		$license_picBack = $this->input->post('driverLicenceBack');
        $profile_pic = $this->input->post('driverImage');
        $boxType = $this->input->post('packageBoxType');
        $packageBoxTypeId = $this->input->post('packageBoxTypeId');
        $deliveryType= $this->input->post('deliveryType');
        $deliveryTypeMsg= $this->input->post('deliveryTypeMsg');

       


        if ($profile_pic != ''){
            $mongoArr = array('dob' => $dob, 'mobile' => $mobile, 'countryCode' => $countryCode, 'driverType' => (int) $account_type, "firstName" => $first_name, "lastName" => $last_name, "profilePic" => $profile_pic, 'serviceZones' => $zonesSelected, 'driverLicenseExpiry' => $expirationrc,'driverLicenseFront'=>$license_pic,'driverLicenseBack'=>$license_picBack,
                            'boxType'=>$boxType,'packageBoxTypeId'=>$packageBoxTypeId,'deliveryType'=>$deliveryType,'deliveryTypeMsg'=> $deliveryTypeMsg);
		} else{
            $mongoArr = array('driverLicenseFront'=>$license_pic,'driverLicenseBack'=>$license_picBack,'dob' => $dob, 'mobile' => $mobile, 'countryCode' => $countryCode, 'driverType' => (int) $account_type, "firstName" => $first_name, "lastName" => $last_name, 'serviceZones' => $zonesSelected, 'driverLicenseExpiry' => $expirationrc,
                            'boxType'=>$boxType,'packageBoxTypeId'=>$packageBoxTypeId,'deliveryType'=>$deliveryType,'deliveryTypeMsg'=> $deliveryTypeMsg);
		}
        if ($license_pic != ''){
            $mongoArr['driverLicense'] = $license_pic;
        }
        
        // echo '<pre>';print_r($mongoArr);die;
        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($driverid)))->set($mongoArr)->update('driver');
       
        return true;
    }
	
	
	function editStoreDriverData() {
        $this->load->library('mongo_db');
       
		$account_type =2;
        $storeId = $this->input->post('store_select');
        $storeName = $this->input->post('storeName');

        if (!empty($this->input->post('checkboxs'))){
            $zonesSelected = $this->input->post('checkboxs');
		}

        $driverid = $this->input->post('driver_id');
        $first_name = $this->input->post('firstname');
        $last_name = $this->input->post('lastname');
        $password = $this->input->post('password');

        $email = $this->input->post('email');
        $dob = date('Y-m-d', strtotime($this->input->post('dob')));
        $mobile = $this->input->post('mobile');
        $countryCode = '+' . $this->input->post('coutry-code');
        $expirationrc = $this->input->post('expirationrc');


        $license_pic = $this->input->post('driverLicence');
		$license_picBack = $this->input->post('driverLicenceBack');
        $profile_pic = $this->input->post('driverImage');

      


        if ($profile_pic != ''){
            $mongoArr = array('dob' => $dob,  'storeId' => new MongoDB\BSON\ObjectID($storeId), 'storeName' => $storeName, "driverLicenseFront"=>$license_pic,"driverLicenseBack"=>$license_picBack,'mobile' => $mobile, 'countryCode' => $countryCode, 'driverType' => (int) $account_type, "firstName" => $first_name, "lastName" => $last_name, "profilePic" => $profile_pic,'preferredZones' => $zonesSelected, 'serviceZones' => $zonesSelected, 'driverLicenseExp' => $expirationrc);
        }else{
            $mongoArr = array('dob' => $dob, 'storeId' => new MongoDB\BSON\ObjectID($storeId),'preferredZones' => $zonesSelected, 'storeName' => $storeName, "driverLicenseFront"=>$license_pic,"driverLicenseBack"=>$license_picBack, 'mobile' => $mobile, 'countryCode' => $countryCode, 'driverType' => (int) $account_type, "firstName" => $first_name, "lastName" => $last_name, 'serviceZones' => $zonesSelected, 'driverLicenseExp' => $expirationrc);
		}
        if ($license_pic != ''){
            $mongoArr['driverLicense'] = $license_pic;
		}

        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($driverid)))->set($mongoArr)->update('driver');
        


        return true;
    }
	
	
	

    //If the city is already exists and it was marked as deleted then reactivate it again
    public function checkCityExists() {
        $this->load->library('mongo_db');
        $result = $this->mongo_db->where(array("city" => (string) $this->input->post('city')))->set(array('isDeleted' => FALSE))->update('cities');

        if ($result)
            $result = 0;
        else
            $result = 1;

        echo json_encode(array('flag' => $result));
    }

    public function getAllCities() {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get('cities');

        echo json_encode(array('data' => $cursor));
    }

    public function zonemapsapi() {
        $this->load->library('mongo_db');
        $method = $_SERVER['REQUEST_METHOD'];
        $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
        $input = json_decode(file_get_contents('php://input'), true);

        switch ($method) {
            case 'GET': {
                    $cursor = $this->mongo_db->where(array('isDeleted' => FALSE))->get('cities');

                    echo json_encode(array('data' => $cursor));
                }break;
            case 'PUT': {

                    $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($input[id])))->set($input[details])->update('cities');

                    if ($result == true) {
                        $response_array['status'] = 'success';
                    } else {
                        $response_array['status'] = 'error';
                    }
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                }break;
            case 'POST': {

                    $isRecord = $this->mongo_db->where(array("city" => $input[city]))->count('cities');
                    if ($isRecord > 0) {
                        $response_array['flag'] = 1;
                    } else {
                        $result = $this->mongo_db->insert('cities', $input);
                        $response_array['status'] = 'success';
                        $response_array['data'] = $input;
                        $response_array['id'] = $result['_id'];
                        $response_array['flag'] = 0;
                    }

                    header('Content-type: application/json');
                    echo json_encode($response_array);
                }break;
        }
    }

    public function shortHaul_zonesAPI() {
        $this->load->library('mongo_db');
        $method = $_SERVER['REQUEST_METHOD'];
        $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
        $input = json_decode(file_get_contents('php://input'), true);


        switch ($method) {
            case 'GET': {
                    $cursor = $this->mongo_db->get('zones');

                    /* foreach ($cursor as $x) {
                      echo "name:" . json_encode($x[name]) . ",place:", json_encode($x[place]) . "\n";
                      } */

                    echo json_encode(array('data' => $cursor));
                }break;
            case 'PUT': {
                    $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($input[id])))->set($input[details])->update('zones');
                    $url = APILink . 'admin/zone';
                    $respon = json_decode($this->callapi->CallAPI('POST', $url), true);
                    if ($result == true) {
                        $response_array['status'] = 'success';
                    } else {
                        $response_array['status'] = 'error';
                    }
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                }break;
            case 'POST': {

                    $result = $this->mongo_db->insert('zones', $input);
                    $url = APILink . 'admin/zone';
                    $respon = json_decode($this->callapi->CallAPI('POST', $url), true);

//                    $res = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($result)))->find_one('zones');
//                    $res['title'];
                    $response_array['status'] = 'success';
                    $response_array['data'] = $input;
                    $response_array['id'] = $result['_id'];

                    header('Content-type: application/json');
                    echo json_encode($response_array);
                }break;
            case 'DELETE': {
                    //$result = $collection->remove($input);
                    $result = $collection->remove(array("_id" => new MongoId($input[id])), array("justOne" => true));
                    if ($result == true) {
                        $response_array['status'] = 'success';
                    } else {
                        $response_array['status'] = 'error';
                    }
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                }break;
        }
    }

    function operating_zonesAPI() {
        $this->load->library('mongo_db');
        $method = $_SERVER['REQUEST_METHOD'];
        $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
        $input = json_decode(file_get_contents('php://input'), true);
        switch ($method) {
            case 'GET': {
                    $cursor = $this->mongo_db->get('Opearting_zone');

                    echo json_encode(array('data' => $cursor));
                }break;
            case 'PUT': {
                    //$collection->update(array("name" => "MongoDB"), array('$set' => array("name" => "MongoDB Tutorial")));
                    //$collection->update(array("_id"=>new MongoId('56e93d30e8408f773819b709')), array('$set' => array("polygonProps.draggable" => false)));
                    $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($input[id])))->set($input[details])->update('Opearting_zone');

                    if ($result == true) {
                        $response_array['status'] = 'success';
                    } else {
                        $response_array['status'] = 'error';
                    }
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                }break;
            case 'POST': {


                    $isRecord = $this->mongo_db->where(array("title" => $input[title]))->count('Opearting_zone');
                    if ($isRecord > 0) {
                        $response_array['flag'] = 1;
                    } else {
                        $result = $this->mongo_db->insert('Opearting_zone', $input);
                        $response_array['status'] = 'success';
                        $response_array['data'] = $input;
                        $response_array['id'] = $result['_id']['$oid'];
                        $response_array['flag'] = 0;
                    }
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                }break;
            case 'DELETE': {
                    //$result = $collection->remove($input);
                    $result = $collection->remove(array("_id" => new MongoId($input[id])), array("justOne" => true));
                    if ($result == true) {
                        $response_array['status'] = 'success';
                    } else {
                        $response_array['status'] = 'error';
                    }
                    header('Content-type: application/json');
                    echo json_encode($response_array);
                }break;
        }
    }

    function deleteOperatingZone() {
        $this->load->library('mongo_db');
        $ids = $this->input->post('zone_id');
        foreach ($ids as $id)
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('Opearting_zone');

        echo json_encode(array('msg' => 'Deleted..!'));
    }

    function datatable_onGoingBookings($status = '', $stDate = '', $endDate = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 7;
        $_POST['mDataProp_0'] = "orderId";
        $_POST['mDataProp_1'] = "driverDetails.fName";
        $_POST['mDataProp_2'] = "pickup.addressLine1";
        $_POST['mDataProp_3'] = "drop.addressLine1";
        $_POST['mDataProp_4'] = "customerDetails.name";
        $_POST['mDataProp_5'] = "driverDetails.lName";
        $_POST['mDataProp_6'] = "storeName";

//$condition['bookingDate'] = array('$gte' => $this->mongo_db->date(strtotime($stDate . " 00:00:00") * 1000), '$lte' => $this->mongo_db->date(strtotime($endDate . ' 23:59:59') * 1000));

        if ($status == 1) {//Assinged booking only
            if ($stDate != '' && $endDate != '')
                $respo = $this->datatables->datatable_mongodb('assignOrders', array('status' => array('$in' => [5, 6, 8, 9, 11, 12, 13]), 'bookingDate' => array('$gte' => date(strtotime($stDate . '00:00:00') * 1000), '$lte' => date(strtotime($endDate . ' 23:59:59') * 1000))));
            else
                $respo = $this->datatables->datatable_mongodb('assignOrders', array('status' => array('$in' => [5, 6, 8, 9, 11, 12, 13])));
        } else //Unassigned 
            $respo = $this->datatables->datatable_mongodb('assignOrders', array('status' => array('$in' => [1, 11])));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $paymentType = unserialize(paymentMethod)[$value['payment_type']];



            if ($value['bookingType'] == 1) {
                $bookingType = 'Now';
            } else {
                $bookingType = 'Later';
            }
            if ($value['serviceType'] == 1) {
                $servicetype = "Delivery";
            } else if ($value['serviceType'] == 2) {
                $servicetype = "Pick UP";
            }
            if ($value['paymentType'] == 1) {
                $paymentType = "Card";
            } else if ($value['paymentType'] == 2) {
                $paymentType = "Cash";
            }

            $arr = array();
            $arr[] = '<a href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['orderId'] . '" style="cursor: pointer;" id="' . $value['orderId'] . '"  bid="' . $value['orderId'] . '">' . $value['orderId'] . '</a>';
//            $arr[] = '<a href="" style="cursor: pointer;" id="' . $value['orderId'] . '"  bid="' . $value['orderId'] . '">' . $value['orderId'] . '</a>';
            $arr[] = $bookingType;
            $arr[] = $servicetype;
            $arr[] = $value['bookingDate'];
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['customerDetails']['customerId'] . '">' . $value['customerDetails']['name'] . '</a>';
            $arr[] = $value['storeName'];
            $arr[] = '<a style="cursor: pointer;" class="getDriverDetails" mas_id="' . $value['driverDetails']['driverId']['$oid'] . '">' . $value['driverDetails']['fName'] . ' ' . $value['driverDetails']['lName'] . '</a>';
            $arr[] = $value['pickup']['addressLine1'] . '<br/>' . $value['pickup']['addressLine2'];
            $arr[] = $value['drop']['addressLine1'] . '<br/>' . $value['drop']['addressLine2'];
            $arr[] = $value['totalAmount'] . '' . $value['currencySymbol'];
            $arr[] = $value['deliveryCharge'] . '' . $value['currencySymbol'];
            $arr[] = $paymentType;
            $arr[] = '<p class="status' . $value['orderId'] . '">' . unserialize(JobStatus)[$value['status']] . '</p>';
//            $arr[] = '<a href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['order_id'] . '"><button type="button" class="btn btn-success"><i class="fa fa-truck" aria-hidden="true"></i>  Show</button></a><button type="button" style="padding:6px 4px;" order_id="' . $value['order_id'] . '" paymentType="' . $paymentType . '" cancelAmount ="' . $value['vehicleType'][0]['cancellation_fee'] . '"  billedAmount="' . $value['invoice']['total'] . '" class="btn btn-success manageBooking">Manage Booking</button>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_estimateRequested($stDate = '', $endDate = '') {

        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "_id";
        $_POST['mDataProp_1'] = "uName";
        $_POST['mDataProp_2'] = "vtName";


        if ($stDate != '' && $endDate != '')
            $respo = $this->datatables->datatable_mongodb('estimates', array('time' => array('$gte' => strtotime($stDate), '$lte' => strtotime($endDate . ' 23:59:59'))));
        else
            $respo = $this->datatables->datatable_mongodb('estimates');

        $aaData = $respo["aaData"];
//        print_r($aaData);die;
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();
            $arr[] = $value['_id'];
            $arr[] = (isset($value['orderId'])) ? $value['orderId'] : 'N/A';
            $arr[] = '<a style="cursor: pointer;" class="getCustomer" sname="' . $value['uName'] . '" semail="' . $value['email'] . '" sphone="' . $value['phone'] . '">' . $value['uName'] . '</a>';
            $arr[] = $value['vtName'];
            $arr[] = date('j-M-Y g:i A', $value['time']);
            $arr[] = $value['pickup'];
            $arr[] = $value['drop'];
            $arr[] = $value['dis'];
            $arr[] = $value['durationTxt'];
            $arr[] = $value['finalAmt'];

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_completed_jobs($stDate = '', $endDate = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        $_POST['iColumns'] = 10;
        $_POST['mDataProp_0'] = "orderId";
        $_POST['mDataProp_1'] = "mas_id";
        $_POST['mDataProp_2'] = "driverName";
        $_POST['mDataProp_3'] = "driverPhone";
        $_POST['mDataProp_4'] = "slaveName";
        $_POST['mDataProp_5'] = "slavemobile";
        $_POST['mDataProp_6'] = "address_line1";
        $_POST['mDataProp_7'] = "appointment_dt";
        $_POST['mDataProp_8'] = "drop_addr1";
        $_POST['mDataProp_9'] = "status";

        if ($stDate != '' && $endDate != '')
            $respo = $this->datatables->datatable_mongodb('completedOrders', array('status' => 15, 'timpeStamp_appointment_date' => array('$gte' => strtotime($stDate), '$lte' => strtotime($endDate . ' 23:59:59'))));
        else
            $respo = $this->datatables->datatable_mongodb('completedOrders', array('status' => 15));

        $aaData = $respo["aaData"];
//        print_r($aaData);die;
        $datatosend = array();

        foreach ($aaData as $value) {

            //if zoneType=1 then Long Haul if zoneType=0 then Short Haul
            $collectionName = 'zones';
            if ($value['zoneType'] == '1')
                $collectionName = 'cities';

            if ($value['pickupzoneId'] == '' || $value['pickupzoneId'] == '0' || $value['dorpzoneId'] == '' || $value['dorpzoneId'] == '0') {
                $zoneType = $value['pricingModel'] . '-OZ';
            } else {
                $zoneType = ($value['zoneType'] == '1') ? $value['pricingModel'] . '-' . 'LH' : $value['pricingModel'] . '-' . 'SH';
            }

            //Get pick up zone
            $pickUpZone = '';
            if ($value['pickupzoneId'] != '0' && $value['pickupzoneId'] != '' && $value['pickupzoneId'] != NULL && $value['pickupzoneId'] != 'default')
                $pickUpZone = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['pickupzoneId'])))->find_one($collectionName);

            //Get drop zone
            $dropZone = '';
            if ($value['dorpzoneId'] != 'false' && $value['dorpzoneId'] != FALSE && $value['dorpzoneId'] != '0' && $value['dorpzoneId'] != '' && $value['dorpzoneId'] != NULL && $value['dorpzoneId'] != 'default')
                $dropZone = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['dorpzoneId'])))->find_one($collectionName);

            $pickUpZone = ($value['zoneType'] == '1') ? $pickUpZone['city'] : $pickUpZone['title'];
            $dropZone = ($value['zoneType'] == '1') ? $dropZone['city'] : $dropZone['title'];

            if ($pickUpZone != '')
                $pickUpZoneAndAddr = '(Zone-' . $pickUpZone . ') ' . $value['address_line1'];
            else
                $pickUpZoneAndAddr = '(Zone-Out Zone) ' . $value['address_line1'];

            if ($dropZone != '')
                $dropZoneAndAddr = '(Zone-' . $dropZone . ') ' . $value['drop_addr1'];
            else
                $dropZoneAndAddr = '(Zone-Out Zone) ' . $value['drop_addr1'];

            if ($value['bookingType'] == 1) {
                $bookingType = 'Now';
            } else {
                $bookingType = 'Later';
            }
            if ($value['serviceType'] == 1) {
                $servicetype = "Delivery";
            } else if ($value['serviceType'] == 2) {
                $servicetype = "Pick UP";
            }
            if ($value['paymentType'] == 1) {
                $paymentType = "Card";
            } else if ($value['paymentType'] == 2) {
                $paymentType = "Cash";
            }



            $arr = array();
            $arr[] = '<a href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['orderId'] . '" style="cursor: pointer;" id="' . $value['orderId'] . '"  bid="' . $value['orderId'] . '">' . $value['orderId'] . '</a>';
//            $arr[] = '<a href="" style="cursor: pointer;" id="' . $value['orderId'] . '"  bid="' . $value['orderId'] . '">' . $value['orderId'] . '</a>';
            $arr[] = $bookingType;
            $arr[] = $servicetype;
            $arr[] = $value['bookingDate'];
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['customerDetails']['customerId'] . '">' . $value['customerDetails']['name'] . '</a>';
            $arr[] = $value['storeName'];
            $arr[] = '<a style="cursor: pointer;" class="getDriverDetails" mas_id="' . $value['driverDetails']['driverId']['$oid'] . '">' . $value['driverDetails']['fName'] . ' ' . $value['driverDetails']['lName'] . '</a>';
            $arr[] = $value['pickup']['addressLine1'] . '<br/>' . $value['pickup']['addressLine2'];
            $arr[] = $value['drop']['addressLine1'] . '<br/>' . $value['drop']['addressLine2'];
            $arr[] = $value['totalAmount'] . '' . $value['currencySymbol'];
            $arr[] = $value['deliveryCharge'] . '' . $value['currencySymbol'];
            $arr[] = $paymentType;
            $arr[] = date('j-M-Y h:i:s A', $value['timeStamp']['journeyComplete']);
//            $arr[] = '<p class="status' . $value['orderId'] . '">' . unserialize(JobStatus)[$value['status']] . '</p>';
//            $arr[] = '<a href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['orderId'] . '"><button type="button" class="btn btn-success"><i class="fa fa-truck" aria-hidden="true"></i>  Show</button></a>';
//            $arr[] = '<a target="_blank" href="' . base_url() . 'index.php?/superadmin/invoiceDetails/' . $value['orderId'] . '">View</a>';
            $arr[] = '<a target="_blank" href="">View</a>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_cancelledBookings($stDate = '', $endDate = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 7;
        $_POST['mDataProp_0'] = "orderId";
        $_POST['mDataProp_1'] = "driverDetails.fName";
        $_POST['mDataProp_2'] = "driverDetails.mobile";
        $_POST['mDataProp_3'] = "slaveName";
        $_POST['mDataProp_4'] = "slavemobile";
        $_POST['mDataProp_5'] = "address_line1";
        $_POST['mDataProp_6'] = "drop_addr1";

        if ($stDate != '' && $endDate != '')
            $respo = $this->datatables->datatable_mongodb('completedOrders', array('status' => array('$in' => [2, 3, 16]), 'timpeStamp_appointment_date' => array('$gte' => strtotime($stDate), '$lte' => strtotime($endDate . ' 23:59:59'))));
        else
            $respo = $this->datatables->datatable_mongodb('completedOrders', array('status' => array('$in' => [2, 3, 16])));


        $aaData = $respo["aaData"];
//        print_r($aaData);die;
        $datatosend = array();

        foreach ($aaData as $value) {


            if ($value['bookingType'] == 1) {
                $bookingType = 'Now';
            } else {
                $bookingType = 'Later';
            }

            if ($value['serviceType'] == 1) {
                $servicetype = "Delivery";
            } else if ($value['serviceType'] == 2) {
                $servicetype = "Pick UP";
            }

            if ($value['paymentType'] == 1) {
                $paymentType = "Card";
            } else if ($value['paymentType'] == 2) {
                $paymentType = "Cash";
            }

            if ($value['status'] == 2 || $value['status'] == 3) {
                $cancelledBy = "Manager";
            } else if ($value['status'] == 16) {
                $cancelledBy = "Customer";
            } else if ($value['status'] == 17) {
                $cancelledBy = "Driver";
            } else {
                $cancelledBy = "N/A";
            }


            $arr = array();
            $arr[] = '<a href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['orderId'] . '" style="cursor: pointer;" id="' . $value['orderId'] . '"  bid="' . $value['orderId'] . '">' . $value['orderId'] . '</a>';
//            $arr[] = '<a href="" style="cursor: pointer;" id="' . $value['orderId'] . '"  bid="' . $value['orderId'] . '">' . $value['orderId'] . '</a>';
            $arr[] = $bookingType;
            $arr[] = $servicetype;
            $arr[] = $value['bookingDate'];
            $arr[] = ($value['customerDetails']['name'] == '') ? 'N/A' : '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['customerDetails']['customerId'] . '">' . $value['customerDetails']['name'] . '</a>';
            $arr[] = $value['storeName'];
            $arr[] = ($value['driverDetails']['fName'] == '') ? 'N/A' : '<a style="cursor: pointer;" class="getDriverDetails" mas_id="' . $value['driverDetails']['driverId']['$oid'] . '">' . $value['driverDetails']['fName'] . ' ' . $value['driverDetails']['lName'] . '</a>';
            $arr[] = $value['pickup']['addressLine1'] . '<br/>' . $value['pickup']['addressLine2'];
            $arr[] = $value['drop']['addressLine1'] . '<br/>' . $value['drop']['addressLine2'];
            $arr[] = $value['totalAmount'] . '' . $value['currencySymbol'];
            $arr[] = $value['deliveryCharge'] . '' . $value['currencySymbol'];
            $arr[] = $paymentType;
            $arr[] = ($value['cancelledDate'] == '') ? 'N/A' : $value['cancelledDate'];
            $arr[] = $cancelledBy;
            $arr[] = ($value['cancelledReason'] == '') ? 'N/A' : $value['cancelledReason'];
//            $arr[] = '<a href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['orderId'] . '"><button type="button" class="btn btn-success"><i class="fa fa-truck" aria-hidden="true"></i>  Show</button></a>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_unassignedBookings() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "slaveName";
        $_POST['mDataProp_2'] = "slavemobile";
        $_POST['mDataProp_3'] = "address_line1";
        $_POST['mDataProp_4'] = "drop_addr1";

        $respo = $this->datatables->datatable_mongodb('unassignOrders', array('status' => 4));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            //if zoneType=1 then Long Haul if zoneType=0 then Short Haul
            $collectionName = 'zones';
            if ($value['zoneType'] == '1')
                $collectionName = 'cities';

            //Get pick up zone
            $pickUpZone = '';
            if ($value['pickupzoneId'] != '0' && $value['pickupzoneId'] != '' && $value['pickupzoneId'] != NULL && $value['pickupzoneId'] != 'default')
                $pickUpZone = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['pickupzoneId'])))->find_one($collectionName);

            //Get drop zone
            $dropZone = '';
            if ($value['dorpzoneId'] != 'false' && $value['dorpzoneId'] != FALSE && $value['dorpzoneId'] != '0' && $value['dorpzoneId'] != '' && $value['dorpzoneId'] != NULL && $value['dorpzoneId'] != 'default')
                $dropZone = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['dorpzoneId'])))->find_one($collectionName);

            $pickUpZone = ($value['zoneType'] == '1') ? $pickUpZone['city'] : $pickUpZone['title'];
            $dropZone = ($value['zoneType'] == '1') ? $dropZone['city'] : $dropZone['title'];

            if ($pickUpZone != '')
                $pickUpZoneAndAddr = '(Zone-' . $pickUpZone . ') ' . $value['address_line1'];
            else
                $pickUpZoneAndAddr = '(Zone-Out Zone) ' . $value['address_line1'];

            if ($dropZone != '')
                $dropZoneAndAddr = '(Zone-' . $dropZone . ') ' . $value['drop_addr1'];
            else
                $dropZoneAndAddr = '(Zone-Out Zone) ' . $value['drop_addr1'];

            //Time left to expire the booking
            $to_time = $value['expiryDate'];
            $from_time = time();
            $leftTime = round(($to_time - $from_time) / 60, 0);

            if ($leftTime == 0)
                $leftTime = $to_time - $from_time . ' seconds';
            else if ($leftTime < 0)
                $leftTime = '0 minutes';
            else
                $leftTime .= ' minutes';

            if ($value['bookingType'] == 1) {
                $bookingType = 'Now';
            } else {
                $bookingType = 'Later';
            }
            if ($value['serviceType'] == 1) {
                $servicetype = "Delivery";
            } else if ($value['serviceType'] == 2) {
                $servicetype = "Pick UP";
            }
            if ($value['paymentType'] == 1) {
                $paymentType = "Card";
            } else if ($value['paymentType'] == 2) {
                $paymentType = "Cash";
            }



            $arr = array();
            $arr[] = '<a href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['orderId'] . '" style="cursor: pointer;" id="' . $value['orderId'] . '"  bid="' . $value['orderId'] . '">' . $value['orderId'] . '</a>';
            $arr[] = $bookingType;
            $arr[] = $servicetype;
            $arr[] = ($value['bookingDate'] == '' || $value['bookingDate'] == null) ? 'N/A' : $value['bookingDate'];
            $arr[] = ($value['customerDetails']['name'] == '' || $value['customerDetails']['name'] == null) ? 'N/A' : '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['customerDetails']['customerId'] . '">' . $value['customerDetails']['name'] . '</a>';
            $arr[] = ($value['storeName'] == '' || $value['storeName'] == null) ? 'N/A' : $value['storeName'];
            $arr[] = ($value['pickup']['addressLine1'] == '' || $value['pickup']['addressLine2'] == '') ? 'N/A' : $value['pickup']['addressLine1'] . '<br/>' . $value['pickup']['addressLine2'];
            $arr[] = ($value['drop']['addressLine1'] == '' || $value['drop']['addressLine2'] == '') ? 'N/A' : $value['drop']['addressLine1'] . '<br/>' . $value['drop']['addressLine2'];
            $arr[] = ($value['totalAmount'] == '') ? 'N/A' : $value['totalAmount'] . '' . $value['currencySymbol'];
            $arr[] = ($value['deliveryCharge'] == '') ? 'N/A' : $value['deliveryCharge'] . '' . $value['currencySymbol'];
            $arr[] = $paymentType;

            $arr[] = '<a style="cursor: pointer;" id="' . $value['orderId'] . '" class="getDriverHistory" bid="' . $value['orderId'] . '">' . count($value['dispatched']) . '</a>';

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_expiredBookings() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "slaveName";
        $_POST['mDataProp_2'] = "slavemobile";
        $_POST['mDataProp_3'] = "address_line1";
        $_POST['mDataProp_4'] = "drop_addr1";

        $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('status' => 11));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            //if zoneType=1 then Long Haul if zoneType=0 then Short Haul
            $collectionName = 'zones';
            if ($value['zoneType'] == '1')
                $collectionName = 'cities';

            //Get pick up zone
            $pickUpZone = '';
            if ($value['pickupzoneId'] != '0' && $value['pickupzoneId'] != '' && $value['pickupzoneId'] != NULL && $value['pickupzoneId'] != 'default')
                $pickUpZone = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['pickupzoneId'])))->find_one($collectionName);

            //Get drop zone
            $dropZone = '';
            if ($value['dorpzoneId'] != 'false' && $value['dorpzoneId'] != FALSE && $value['dorpzoneId'] != '0' && $value['dorpzoneId'] != '' && $value['dorpzoneId'] != NULL && $value['dorpzoneId'] != 'default')
                $dropZone = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($value['dorpzoneId'])))->find_one($collectionName);

            $pickUpZone = ($value['zoneType'] == '1') ? $pickUpZone['city'] : $pickUpZone['title'];
            $dropZone = ($value['zoneType'] == '1') ? $dropZone['city'] : $dropZone['title'];

            if ($pickUpZone != '')
                $pickUpZoneAndAddr = '(Zone-' . $pickUpZone . ') ' . $value['address_line1'];
            else
                $pickUpZoneAndAddr = '(Zone-Out Zone) ' . $value['address_line1'];

            if ($dropZone != '')
                $dropZoneAndAddr = '(Zone-' . $dropZone . ') ' . $value['drop_addr1'];
            else
                $dropZoneAndAddr = '(Zone-Out Zone) ' . $value['drop_addr1'];




            $arr = array();
            $arr[] = '<a style="cursor: pointer;" id="' . $value['order_id'] . '" class="getDriverHistory" bid="' . $value['order_id'] . '">' . $value['order_id'] . '</a>';
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slave_id']['$oid'] . '">' . $value['slaveName'] . '</a>';
            $arr[] = $value['slaveCountryCode'] . $value['slavemobile'];
            $arr[] = date('j-M-Y h:i:s A', $value['created_dt']);
            $arr[] = ($value['appt_type'] == '1') ? 'Now' : 'Later';


            $arr[] = $pickUpZoneAndAddr;
            $arr[] = $dropZoneAndAddr;
//            $arr[] = (count($value['dispatched']) > 0) ? '<a id="attemptCount'.$value['order_id'].'" href="' . base_url() . 'index.php?/superadmin/bookingDispatchedList/' . $value['order_id'] . '">' . count($value['dispatched']) . '</a>' : '<span id="attemptCount'.$value['order_id'].'">'.count($value['dispatched']).'</span>';
            $arr[] = '<a id="attemptCount' . $value['order_id'] . '" href="' . base_url() . 'index.php?/superadmin/bookingDispatchedList/' . $value['order_id'] . '">' . count($value['dispatched']) . '</a>';
            $arr[] = $value['pricingModel'];
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_bookingDispatchedList($orderID = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "dispatched.fName";
        $_POST['mDataProp_1'] = "dispatched.lName";
        $_POST['mDataProp_2'] = "slaveName";
        $_POST['mDataProp_3'] = "slavemobile";

        $respo = $this->datatables->datatable_mongodb('completedOrders', array('orderId' => (int) $orderID));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            if ($value['dispatched'] > 0) {
                foreach ($value['dispatched'] as $dispatched) {

                    $arr = array();
                    $arr[] = '<a style="cursor: pointer;" id="driverID' . $dispatched['DriverId']['$oid'] . '"  class="getDriverDetails" mas_id="' . $dispatched['DriverId']['$oid'] . '">' . $dispatched['fName'] . ' ' . $dispatched['lName'] . '</a>';
                    $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slave_id']['$oid'] . '">' . $value['slaveName'] . '</a>';
                    $arr[] = $value['slaveCountryCode'] . $value['slavemobile'];
                    $arr[] = date('j-M-Y h:i:s A', $dispatched['Received_Act_serverTime']);
                    $arr[] = $dispatched['Status'];

                    $datatosend[] = $arr;
                }
            }
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function documentgetdatavehicles() {
        $this->load->library('mongo_db');
        $vehicleData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post("val"))))->get('vehicles');
        echo json_encode(array('data' => $vehicleData));
        return;
    }

    function AddNewVehicleData() {
        $this->load->library('mongo_db');
//        print_r($_POST);die;
        $OwnershipType = $this->input->post('OwnershipType');
//        $goodType = $this->input->post('goodType');
        $selected_driver = $this->input->post('selected_driver');
        $driverName = $this->input->post('driverName');
        $driverMobile = $this->input->post('driverMobile');
        $title = $this->input->post('title');
        $vehiclemodel = $this->input->post('vehiclemodel');
        $vechileregno = $this->input->post('vechileregno');

//        $color = $this->input->post('color');

        $licenceplaetno = $this->input->post('licenceplaetno');
//        $vechilecolor = $this->input->post('vechilecolor');
        $type_id = $this->input->post('getvechiletype');
        $vehicleTypeName = $this->input->post('vehicleTypeName');
        $expirationrc = $this->input->post('expirationrc');
        $Vehicle_Insurance_No = $this->input->post('Vehicle_Insurance_No');

        //Images
        $image_name = $this->input->post('vehicleImage');
        $registationCertificate = $this->input->post('registationCertificate');
        $motorCertificate = $this->input->post('motorCertificate');
        $PermitCertificate = $this->input->post('PermitCertificate');

        $expirationinsurance = $this->input->post('expirationinsurance');
        $expirationpermit = $this->input->post('expirationpermit');

        $companyname = $this->input->post('company_select');
        $storeId = $this->input->post('store_select');
        $operatorName = $this->input->post('operatorName');
        $storeName = $this->input->post('storeName');

        if ($OwnershipType == 1) {
            $insertArr = array('status' => 1, 'modelId' => new MongoDB\BSON\ObjectID($vehiclemodel), 'model' => $this->input->post('vehicleModelName'), 'makeId' => new MongoDB\BSON\ObjectID($title), 'make' => $this->input->post('vehicleMakeName'), 'platNo' => $licenceplaetno, 'account_type' => (int) $OwnershipType, 'operator' => new MongoDB\BSON\ObjectID($companyname), 'operatorName' => $this->input->post('operatorName'), 'mas_id' => new MongoDB\BSON\ObjectID($selected_driver), 'driverName' => $this->input->post('driverName'), 'driverMobile' => $driverMobile, 'type_id' => new MongoDB\BSON\ObjectID($type_id), 'type' => $this->input->post('vehicleTypeName'), 'profilePic' => $image_name, 'reg_number' => $vechileregno, 'licence_numer' => $licenceplaetno, 'insurance_number' => $Vehicle_Insurance_No, 'regCertExpr' => $expirationrc, 'motorInsuExpr' => $expirationinsurance, 'permitExpr' => $expirationpermit, 'regCertImage' => $registationCertificate, 'motorInsuImage' => $motorCertificate, 'permitImage' => $PermitCertificate);
        } else if ($OwnershipType == 2) {
            $insertArr = array('status' => 1, 'modelId' => new MongoDB\BSON\ObjectID($vehiclemodel), 'model' => $this->input->post('vehicleModelName'), 'makeId' => new MongoDB\BSON\ObjectID($title), 'make' => $this->input->post('vehicleMakeName'), 'platNo' => $licenceplaetno, 'account_type' => (int) $OwnershipType, 'operator' => new MongoDB\BSON\ObjectID($companyname), 'operatorName' => $this->input->post('operatorName'), 'mas_id' => '', 'driverName' => $this->input->post('driverName'), 'driverMobile' => $driverMobile, 'type_id' => new MongoDB\BSON\ObjectID($type_id), 'type' => $this->input->post('vehicleTypeName'), 'profilePic' => $image_name, 'reg_number' => $vechileregno, 'licence_numer' => $licenceplaetno, 'insurance_number' => $Vehicle_Insurance_No, 'regCertExpr' => $expirationrc, 'motorInsuExpr' => $expirationinsurance, 'permitExpr' => $expirationpermit, 'regCertImage' => $registationCertificate, 'motorInsuImage' => $motorCertificate, 'permitImage' => $PermitCertificate);
        } else if ($OwnershipType == 3) {
            $insertArr = array('status' => 1, 'storeId' => new MongoDB\BSON\ObjectID($storeId), 'storeName' => $storeName, 'modelId' => new MongoDB\BSON\ObjectID($vehiclemodel), 'model' => $this->input->post('vehicleModelName'), 'makeId' => new MongoDB\BSON\ObjectID($title), 'make' => $this->input->post('vehicleMakeName'), 'platNo' => $licenceplaetno, 'account_type' => (int) $OwnershipType, 'driverName' => $this->input->post('driverName'), 'driverMobile' => $driverMobile, 'type_id' => new MongoDB\BSON\ObjectID($type_id), 'type' => $this->input->post('vehicleTypeName'), 'profilePic' => $image_name, 'reg_number' => $vechileregno, 'licence_numer' => $licenceplaetno, 'insurance_number' => $Vehicle_Insurance_No, 'regCertExpr' => $expirationrc, 'motorInsuExpr' => $expirationinsurance, 'permitExpr' => $expirationpermit, 'regCertImage' => $registationCertificate, 'motorInsuImage' => $motorCertificate, 'permitImage' => $PermitCertificate);
        }

        $_id = $this->mongo_db->insert('vehicles', $insertArr);

        if ($OwnershipType == 1)
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($selected_driver)))->set(array('plateNo' => $licenceplaetno, 'vehicleTypeName' => $this->input->post('vehicleTypeName'), 'type' => new MongoDB\BSON\ObjectID($type_id)))->update('driver');

        return $selected_driver;
    }

    function getTransectionData($paymentType = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        // print_r($_POST['sSearch']);die;

//      $paymentType = array('1'=>'Card','2'=>'Cash');
//        $company_id = $this->session->userdata('company_id');
//        $city = $this->session->userdata('city_id');


        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "orderId";
        $_POST['mDataProp_1'] = "driverDetails.fName";
        $_POST['mDataProp_2'] = "customerDetails.name";
		 $_POST['mDataProp_3'] = "storeName";
		  $_POST['mDataProp_4'] = "pickup.city";


        $respo = $this->datatables->datatable_mongodbAggregate('completedOrders', array(array('$sort'=>array('_id'=>-1))),
        array(array('$group'=>array('_id'=>1,count=>array('$sum'=>1))))
        );
      
       
        $aaData = $respo["aaData"];
        $datatosend = array();
        // $pdfLink="https://flexyapp.s3.amazonaws.com/invoices/";
        // $pdfExt=".pdf";

        foreach ($aaData as $value) {
            
            $id = (string)$value->_id;
            $value = json_decode(json_encode($value), TRUE);
            $value['_id']['$oid'] =   $id;
			
			if($value['bookingType'] == 1 && $value['serviceType'] == 1){
															$orderType="ASAP Delivery";
														}
														if($value['bookingType'] == 1 && $value['serviceType'] == 2){
															$orderType= "ASAP Pickup";
														}
														if($value['bookingType'] == 2 && $value['serviceType'] == 2){
															$orderType= "Scheduled Pickup";
														}
														if($value['bookingType'] == 2 && $value['serviceType'] == 1){
															$orderType= "Scheduled Delivery";
														}
			
			
			
            switch($value['paymentType']){
            case 0: 
                if($value['payByWallet'] == 1){
                $paymentType = "Wallet";
                }
            break;
            case 1: 
                if($value['payByWallet'] == 1){
                $paymentType = "Card + Wallet";
                }else{
                $paymentType = "Card";
                }
            break;
            case 2:
                if($value['payByWallet'] == 1){
                $paymentType = "Cash + Wallet";
                }else{
                $paymentType = "Cash";
                }
            break;
            case 24 :
                $paymentType = "Razorpay";
            break;
        }                                                      
            if($value['status']==16){    
                      
            $pdfLink='N/A';
          }else{
            $path='<a target="_blank" href="' .$value['invoiceUrl'].  '">View</a>'; 
            $pdfLink=($value['invoiceUrl'] != "" || $value['invoiceUrl'] != null) ? $path: 'N/A';
            }

            $arr = array();
            $arr[] = '<a style="cursor: pointer;"  href="' . base_url() . 'index.php?/Orders/orderDetails/' . $value['orderId'] . '/5">' . $value['orderId'] . '</a>';
            $arr[] =$orderType;
            //$arr[] = ($value['bookingDate'] == '') ? 'N/A' : $value['bookingDate'];
            $arr[] = date('d-M-Y h:i:s a ', ($value['bookingDateTimeStamp']) - ($this->session->userdata('timeOffset') * 60));
			$arr[] = ($value['pickup']['city'] == "")?"N/A":$value['pickup']['city'];
            $arr[] =(($value['driverDetails']['fName'] =="" || $value['driverDetails']['fName']==null) && ( $value['driverDetails']['lName'] == "" || $value['driverDetails']['lName'] == null))?"N/A": '<a style="cursor: pointer;" id="driverID' . $value['_id']['$oid'] . '"  class="getDriverDetailsData" mas_id="' . $value['driverId']['$oid'] . '">' . $value['driverDetails']['fName'] . ' ' . $value['driverDetails']['lName'] . '</a>';
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['customerDetails']['customerId'] . '">' . $value['customerDetails']['name'] . '</a>';
            $arr[] = ($value['storeName'] == "" || $value['storeName'] == null)?"N/A":'<a class="getStoreDetails" orderId="'.$value['orderId'].'" style="cursor: pointer;">' . $value['storeName'] . '</a>';
			
		  if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr[] = ($value['accouting']['appEarningValue'] == "") ? "N/A" : '<b><a style="cursor: pointer;" orderId="'.$value['orderId'].'" class="getBillingDetails" >' . $value['currencySymbol']." ".number_format($value['accouting']['appEarningValue'], 2) . '</a></b>';
		  }else{
			 $arr[] = ($value['accouting']['appEarningValue'] == "") ? "N/A" : '<b><a style="cursor: pointer;" orderId="'.$value['orderId'].'" class="getBillingDetails" >' . number_format($value['accouting']['appEarningValue'], 2)." ".$value['currencySymbol'] . '</a></b>'; 
		  }

		  
		    if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr[] = ($value['accouting']['pgEarningValue'] =="")?"N/A":'<a style="cursor: pointer;" orderId="'.$value['orderId'].'"  class="getPgCommDetails" >' . $value['currencySymbol']." ".number_format($value['accouting']['pgEarningValue'], 2) . '</a>';
			}else{
			$arr[] = ($value['accouting']['pgEarningValue'] =="")?"N/A":'<a style="cursor: pointer;" orderId="'.$value['orderId'].'"  class="getPgCommDetails">' . number_format($value['accouting']['pgEarningValue'], 2)." ".$value['currencySymbol'] . '</a>';	
			}
			
			
			 if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
			$arr[] = ($value['accouting']['driverEarningValue'] =="")?"N/A":'<a style="cursor: pointer;" class="getDriverCommDetails" orderId="' . $value['orderId'] . '">' . $value['currencySymbol']." ".number_format($value['accouting']['driverEarningValue'], 2) . '</a>';
			 }else{
			$arr[] = ($value['accouting']['driverEarningValue'] =="")?"N/A":'<a style="cursor: pointer;" class="getDriverCommDetails" orderId="' . $value['orderId'] . '">' . number_format($value['accouting']['driverEarningValue'], 2)." ".$value['currencySymbol'] . '</a>';	 
			 }

			if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr[] = ($value['accouting']['storeEarningValue'] == "")?"N/A":'<a style="cursor: pointer;" class="getStoreCommDetails" orderId="' . $value['orderId'] . '">' .$value['currencySymbol']." ".number_format($value['accouting']['storeEarningValue'], 2) . '</a>';
			}else{
			$arr[] = ($value['accouting']['storeEarningValue'] == "")?"N/A":'<a style="cursor: pointer;" class="getStoreCommDetails" orderId="' . $value['orderId'] . '">' . number_format($value['accouting']['storeEarningValue'], 2)." ".$value['currencySymbol'] . '</a>';	
			}
			
			
			if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr[] = ($value['discount'] == 0) ? "N/A": '<b><a style="cursor: pointer;"  orderId="'.$value['orderId'].'" class="getDiscountDetails" >' . $value['currencySymbol']." ".number_format($value['discount'], 2). '</a></b>';
			}else{
			 $arr[] = ($value['discount'] == 0) ? "N/A":'<b><a style="cursor: pointer;"  orderId="'.$value['orderId'].'" class="getDiscountDetails">' . number_format($value['discount'], 2)." ".$value['currencySymbol']. '</a></b>';	
			}
			
			if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
				if($value['invoice']['cancelationFee'] == "" || $value['invoice']['cancelationFee'] == null){
					$arr[] = '<a class="getNetAmountDetails" orderId="'.$value['orderId'].'" style="cursor: pointer;">' . $value['currencySymbol']." ".number_format($value['totalAmount'], 2) . '</a>'; 
				}else{
					$arr[] = '<a class="getNetAmountDetails" orderId="'.$value['orderId'].'" style="cursor: pointer;">' . $value['currencySymbol']." ".number_format($value['invoice']['cancelationFee'], 2) . '</a>'; 
				}
            
			}else{
				if($value['invoice']['cancelationFee'] == "" || $value['invoice']['cancelationFee'] == null){
				$arr[]= '<a class="getNetAmountDetails" orderId="'.$value['orderId'].'" style="cursor: pointer;">' .number_format($value['totalAmount'], 2)." ".$value['currencySymbol']. '</a>'; 
				}else{
					$arr[]= '<a class="getNetAmountDetails" orderId="'.$value['orderId'].'" style="cursor: pointer;">' .number_format($value['invoice']['cancelationFee'], 2)." ".$value['currencySymbol']. '</a>'; 
				}
			}
		   $arr[] = $paymentType;

            //$arr[] = '<p class="status' . $value['_id']['$oid'] . '">' .$value['statusMsg'] . '</p>';
            $arr[] = $value['statusMsg'];

            //$arr[] = '<a target="_blank" href="' .$value['invoiceUrl'].  '">View</a>';
            $arr[] =$pdfLink ;
            $datatosend[] = $arr;
        }
		  

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
	
	function getOrderDetails(){
		 $this->load->library('mongo_db');
		$orderId = $this->input->post('orderId');
		$data = $this->mongo_db->where(array("orderId"=>(int)$orderId))->find_one('completedOrders');
		$storeDetails = $this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($data['storeId'])))->select(array("profileLogos"=>"profileLogos","ownerPhone"=>"ownerPhone","ownerEmail"=>"ownerEmail","countryCode"=>"countryCode","storeTypeMsg"=>"storeTypeMsg"))->find_one('stores');
		$data['storeDetails']= $storeDetails;
		echo json_encode(array('data'=>$data));
	}

    function exportAccData($stdate = '', $enddate = '',$city='',$store='') {
        $this->load->library('mongo_db');


        $datatosend = array();

        if($stdate != '' && $stdate != "null"  && $enddate != '' && $enddate != "null" && $city!="undefined" && $store!="undefined" ){
            $aaData = $this->mongo_db->where(array('cityId'=>$city,'storeId'=>$store,'bookingDateTimeStamp' => array('$gte' => strtotime($stdate), '$lte' => strtotime($enddate . ' 23:59:59'))))->order_by(array('_id' => -1))->get('completedOrders');
        }else if($stdate != '' && $stdate != "null"  && $enddate != '' && $enddate != "null" && $city!="undefined"){
            $aaData = $this->mongo_db->where(array('cityId'=>$city,'bookingDateTimeStamp' => array('$gte' => strtotime($stdate), '$lte' => strtotime($enddate . ' 23:59:59'))))->order_by(array('_id' => -1))->get('completedOrders');
        }else if($stdate != '' && $stdate != "null"  && $enddate != '' && $enddate != "null" && $store!="undefined"){
            $aaData = $this->mongo_db->where(array('storeId'=>$store,'bookingDateTimeStamp' => array('$gte' => strtotime($stdate), '$lte' => strtotime($enddate . ' 23:59:59'))))->order_by(array('_id' => -1))->get('completedOrders');
        }
        else if ($stdate != '' && $stdate != "null"  && $enddate != '' && $enddate != "null" ){
            $aaData = $this->mongo_db->where(array('bookingDateTimeStamp' => array('$gte' => strtotime($stdate), '$lte' => strtotime($enddate . ' 23:59:59'))))->order_by(array('_id' => -1))->get('completedOrders');
		}else if($city!="undefined" && $store!="undefined" ){
            $aaData = $this->mongo_db->where(array('cityId'=>$city,'storeId'=>$store))->order_by(array('_id' => -1))->get('completedOrders');
        }else if($city!="undefined"){
            $aaData = $this->mongo_db->where(array('cityId'=>$city))->order_by(array('_id' => -1))->get('completedOrders');
        }else{
            $aaData = $this->mongo_db->order_by(array('_id' => -1))->get('completedOrders');
		}

        foreach ($aaData as $value) {
           // echo '<pre>';print_r($value['statusMsg']);die;
                                                        if($value['bookingType'] == 1 && $value['serviceType'] == 1){
															$orderType="ASAP Delivery";
														}
														if($value['bookingType'] == 1 && $value['serviceType'] == 2){
															$orderType= "ASAP Pickup";
														}
														if($value['bookingType'] == 2 && $value['serviceType'] == 2){
															$orderType= "Scheduled Pickup";
														}
														if($value['bookingType'] == 2 && $value['serviceType'] == 1){
															$orderType= "Scheduled Delivery";
														}
			
			
			
                                                    switch($value['paymentType']){
														   case 1: $paymentType="Card";
														   break;
														   case 2:  $paymentType="Cash";
														   break;
														   case 3:  $paymentType="Wallet";
														   break;
														   case 4:  $paymentType="Coin Payments";
														   break;
													   }
            $arr = array();
            $arr['OrderId'] = $value['orderId'];
            $arr['Order Type'] =$orderType;
			$arr['Order Date & Time'] = ($value['bookingDateTimeStamp'] == '') ? 'N/A' : date('d-M-Y h:i:s a ', ($value['bookingDateTimeStamp']) - ($this->session->userdata('timeOffset') * 60));
			$arr['City'] = ($value['pickup']['city'] == "")?"N/A":$value['pickup']['city'];
            $arr['Driver Name'] =($value['driverDetails']['fName'] =="" && $value['driverDetails']['fName']==null && $value['driverDetails']['lName'] == "" && $value['driverDetails']['lName'] == null)?"N/A": $value['driverDetails']['fName'] . ' ' . $value['driverDetails']['lName'];
            $arr['Customer Name'] = $value['customerDetails']['name'];
            $arr['Store Name'] = $value['storeName'];
			
			if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
           // $arr['Total Amount'] =$value['currencySymbol']." ".number_format($value['subTotalAmount'], 2); 
           $arr['Total Amount'] =$value['currencySymbol']." ".$value['totalAmount']; 
			}else{
				$arr['Total Amount']= number_format($value['totalAmount'], 2)." ".$value['currencySymbol']; 
				
            }
            
			
			
			if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr['Discount'] = $value['currencySymbol']." ".number_format($value['discount'], 2);
			}else{
			 $arr['Discount'] = number_format($value['discount'], 2)." ".$value['currencySymbol'];	
			}
          
		  if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr['App Earning'] =$value['currencySymbol']." ".number_format($value['accouting']['appEarningValue'], 2);
		  }else{
			 $arr['App Earning'] =number_format($value['accouting']['appEarningValue'], 2)." ".$value['currencySymbol']; 
		  }

		  
		    if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr['PG Commission'] =$value['currencySymbol']." ".number_format($value['accouting']['pgComm'], 2);
			}else{
			$arr['PG Commission'] = number_format($value['accouting']['pgComm'], 2)." ".$value['currencySymbol'];	
			}
			
			
			 if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
			$arr['Driver Commission'] = $value['currencySymbol']." ".number_format($value['accouting']['driverTotalEarningValue'], 2);
			 }else{
			$arr['Driver Commission'] =number_format($value['accouting']['driverTotalEarningValue'], 2)." ".$value['currencySymbol'];	 
			 }

			if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr['Store Earning'] = $value['currencySymbol']." ".number_format($value['accouting']['storeEarningValue'], 2);
			}else{
			$arr['Store Earning'] =number_format($value['accouting']['storeEarningValue'], 2)." ".$value['currencySymbol'];	
			}
		   $arr['Payment Method'] = $paymentType;

            $arr['Status'] = $value['statusMsg'];

           


            $datatosend[] = $arr;
        }
      

        return $datatosend;
    }

    function getInvoiceDetails($param) {
        $this->load->library('Datatables');
        $this->load->library('mongo_db');
        $invoiceData = $this->mongo_db->where(array('order_id' => (int) $param))->find_one('ShipmentDetails');
        $seconds = (int) $invoiceData['accouting']['time'] * 60;
        $timeDuration = $this->datatables->secondsToTime($seconds);
        $invoiceData['timeDurationDay'] = $timeDuration['d'];
        $invoiceData['timeDurationHour'] = $timeDuration['h'];
        $invoiceData['timeDurationMinutes'] = $timeDuration['m'];
        $invoiceData['timeDurationSeconds'] = $timeDuration['s'];
        
        return $invoiceData;
    }

    function transection_data_form_date($stdate = '', $enddate = '', $paymentType = '') {

        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 3;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "driverDetails.fName";
        $_POST['mDataProp_2'] = "slaveName";
        $city=$this->input->post('city');
        $store=$this->input->post('store');
      
        
       
        if($city!="" && $store!="" ){
            $respo = $this->datatables->datatable_mongodb('completedOrders', array('bookingDateTimeStamp' => array('$gte' => strtotime($stdate), '$lte' => strtotime($enddate . ' 23:59:59')),'cityId'=>$city,'storeId'=>$store));
        }else if($city!=""){
            $respo = $this->datatables->datatable_mongodb('completedOrders', array('bookingDateTimeStamp' => array('$gte' => strtotime($stdate), '$lte' => strtotime($enddate . ' 23:59:59')),'cityId'=>$city));
        }else{
            $respo = $this->datatables->datatable_mongodb('completedOrders', array('bookingDateTimeStamp' => array('$gte' => strtotime($stdate), '$lte' => strtotime($enddate . ' 23:59:59'))));
        }
       

        $aaData = $respo["aaData"];
        $datatosend = array();

       foreach ($aaData as $value) {
			
			if($value['bookingType'] == 1 && $value['serviceType'] == 1){
															$orderType="ASAP Delivery";
														}
														if($value['bookingType'] == 1 && $value['serviceType'] == 2){
															$orderType= "ASAP Pickup";
														}
														if($value['bookingType'] == 2 && $value['serviceType'] == 2){
															$orderType= "Scheduled Pickup";
														}
														if($value['bookingType'] == 2 && $value['serviceType'] == 1){
															$orderType= "Scheduled Delivery";
														}
			
			
			
            switch($value['paymentType']){
														   case 1: $paymentType="Card";
														   break;
														   case 2:  $paymentType="Cash";
														   break;
														   case 3:  $paymentType="Wallet";
														   break;
														   case 4:  $paymentType="Coin Payments";
														   break;
													   }


		  
            $arr = array();
            $arr[] = '<a style="cursor: pointer;" target="_blank" href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['orderId'] . '">' . $value['orderId'] . '</a>';
            $arr[] =$orderType;
			$arr[] = ($value['bookingDate'] == '') ? 'N/A' : $value['bookingDate'];
			$arr[] = ($value['pickup']['city'] == "")?"N/A":$value['pickup']['city'];
            $arr[] =($value['driverDetails']['fName'] =="" || $value['driverDetails']['fName']==null || $value['driverDetails']['lName'] == "" || $value['driverDetails']['lName'] == null)?"N/A": '<a style="cursor: pointer;" id="driverID' . $value['_id']['$oid'] . '"  class="getDriverDetailsData" mas_id="' . $value['driverId']['$oid'] . '">' . $value['driverDetails']['fName'] . ' ' . $value['driverDetails']['lName'] . '</a>';
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['customerDetails']['customerId'] . '">' . $value['customerDetails']['name'] . '</a>';
            $arr[] = ($value['storeName'] == "" || $value['storeName'] == null)?"N/A":'<a class="getStoreDetails" orderId="'.$value['orderId'].'" style="cursor: pointer;">' . $value['storeName'] . '</a>';
			
			if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr[] = '<a class="getNetAmountDetails" orderId="'.$value['orderId'].'" style="cursor: pointer;">' . $value['currencySymbol']." ".number_format($value['subTotalAmount'], 2) . '</a>'; 
			}else{
				$arr[]= '<a class="getNetAmountDetails" orderId="'.$value['orderId'].'" style="cursor: pointer;">' .number_format($value['subTotalAmount'], 2)." ".$value['currencySymbol']. '</a>'; 
				
			}
			
			
			if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr[] = ($value['discount'] == 0) ? "N/A": '<b><a style="cursor: pointer;"  orderId="'.$value['orderId'].'" class="getDiscountDetails" >' . $value['currencySymbol']." ".number_format($value['discount'], 2). '</a></b>';
			}else{
			 $arr[] = ($value['discount'] == 0) ? "N/A":'<b><a style="cursor: pointer;"  orderId="'.$value['orderId'].'" class="getDiscountDetails">' . number_format($value['discount'], 2)." ".$value['currencySymbol']. '</a></b>';	
			}
          
		  if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr[] = ($value['accouting']['appEarningValue'] == "") ? "N/A" : '<b><a style="cursor: pointer;" orderId="'.$value['orderId'].'" class="getBillingDetails" >' . $value['currencySymbol']." ".number_format($value['accouting']['appEarningValue'], 2) . '</a></b>';
		  }else{
			 $arr[] = ($value['accouting']['appEarningValue'] == "") ? "N/A" : '<b><a style="cursor: pointer;" orderId="'.$value['orderId'].'" class="getBillingDetails" >' . number_format($value['accouting']['appEarningValue'], 2)." ".$value['currencySymbol'] . '</a></b>'; 
		  }

		  
		    if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr[] = ($value['accouting']['pgComm'] =="")?"N/A":'<a style="cursor: pointer;" orderId="'.$value['orderId'].'"  class="getPgCommDetails" >' . $value['currencySymbol']." ".number_format($value['accouting']['pgComm'], 2) . '</a>';
			}else{
			$arr[] = ($value['accouting']['pgComm'] =="")?"N/A":'<a style="cursor: pointer;" orderId="'.$value['orderId'].'"  class="getPgCommDetails">' . number_format($value['accouting']['pgComm'], 2)." ".$value['currencySymbol'] . '</a>';	
			}
			
			
			 if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
			$arr[] = ($value['accouting']['driverEarningValue'] =="")?"N/A":'<a style="cursor: pointer;" class="getDriverCommDetails" orderId="' . $value['orderId'] . '">' . $value['currencySymbol']." ".number_format($value['accouting']['driverTotalEarningValue'], 2) . '</a>';
			 }else{
			$arr[] = ($value['accouting']['driverEarningValue'] =="")?"N/A":'<a style="cursor: pointer;" class="getDriverCommDetails" orderId="' . $value['orderId'] . '">' . number_format($value['accouting']['driverTotalEarningValue'], 2)." ".$value['currencySymbol'] . '</a>';	 
			 }

			if($value['abbrevation'] == "1" || $value['abbrevation'] == 1){
            $arr[] = ($value['accouting']['storeEarningValue'] == "")?"N/A":'<a style="cursor: pointer;" class="getStoreCommDetails" orderId="' . $value['orderId'] . '">' .$value['currencySymbol']." ".number_format($value['accouting']['storeEarningValue'], 2) . '</a>';
			}else{
			$arr[] = ($value['accouting']['storeEarningValue'] == "")?"N/A":'<a style="cursor: pointer;" class="getStoreCommDetails" orderId="' . $value['orderId'] . '">' . number_format($value['accouting']['storeEarningValue'], 2)." ".$value['currencySymbol'] . '</a>';	
			}
		   $arr[] = $paymentType;

            $arr[] = '<p class="status' . $value['_id']['$oid'] . '">' .$value['statusMsg'] . '</p>';

            $arr[] = '<a target="_blank" href="' . base_url() . 'index.php?/superadmin/invoiceDetails/' . $value['orderId'] . '">View</a>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function getDataSelected($selectdval = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

//        $company_id = $this->session->userdata('company_id');
//        $city = $this->session->userdata('city_id');

        $paymentType = array('1' => 'Card', '2' => 'Cash');
//        $deviceType = array('1'=>'<img src="'.base_url().'../../admin/assets/apple_new.png" width="30px">','2'=>'<img src="'.base_url().'../../admin/assets/android_new.png" width="30px">');



        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "order_id";
        $_POST['mDataProp_1'] = "booking_time";
        $_POST['mDataProp_2'] = "driverDetails.fName";
        $_POST['mDataProp_3'] = "slaveName";
        $_POST['mDataProp_4'] = "invoice.total";

        if ($selectdval != 0)
            $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('status' => 10, 'payment_type' => $selectdval));
        else
            $respo = $this->datatables->datatable_mongodb('ShipmentDetails', array('status' => 10));


        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $arr = array();
            $arr[] = '<a style="cursor: pointer;" target="_blank" href="' . base_url() . 'index.php?/superadmin/tripDetails/' . $value['order_id'] . '">' . $value['order_id'] . '</a>';
            $arr[] = ($value['booking_time'] == '0') ? '' : date('j-M-Y H:i:s', strtotime($value['booking_time']));
            $arr[] = '<a style="cursor: pointer;" id="driverID' . $value['_id']['$oid'] . '"  class="getDriverDetails" mas_id="' . $value['mas_id']['$oid'] . '">' . $value['driverDetails']['fName'] . '' . $value['driverDetails']['lName'] . '</a>';
            $arr[] = '<a style="cursor: pointer;" class="getCustomerDetails" slave="' . $value['slave_id']['$oid'] . '">' . $value['slaveName'] . '</a>';

            $arr[] = number_format($value['invoice']['total'], 2);
            $arr[] = number_format($value['invoice']['appcom'], 2);
            $arr[] = '';
            $arr[] = number_format($value['invoice']['masEarning'], 2);
            $arr[] = '';
            $arr[] = unserialize(paymentMethod)[$value['payment_type']];

            $arr[] = '<p class="status' . $value['_id']['$oid'] . '">' . unserialize(JobStatus)[$value['status']] . '</p>';

            $arr[] = '<a target="_blank" href="' . base_url() . 'invoice.php?Order_id=' . $value['order_id'] . '">View</a>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function driver_review($status) {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->get_where('ShipmentDetails', array('status' => (int) $status));
//        $query = $this->db->query(" SELECT r.review, r.status,r.star_rating, r.review_dt,r.appointment_id, r.mas_id, d.first_name AS mastername, p. slave_id,a.appointment_dt  FROM master_ratings r, master d, slave p,appointment a WHERE r.slave_id = p.slave_id  AND r.mas_id = d.mas_id  AND r.status ='" . $status . "' AND r.review <>'' AND a.appointment_id = r.appointment_id ")->result();
        return $res;
    }

    function week_start_end_by_date($date, $format = 'Y-m-d') {

        //Is $date timestamp or date?
        if (is_numeric($date) AND strlen($date) == 10) {
            $time = $date;
        } else {
            $time = strtotime($date);
        }

        $week['week'] = date('W', $time);
        $week['year'] = date('o', $time);
        $week['year_week'] = date('oW', $time);
        $first_day_of_week_timestamp = strtotime($week['year'] . "W" . str_pad($week['week'], 2, "0", STR_PAD_LEFT));
        $week['first_day_of_week'] = date($format, $first_day_of_week_timestamp);
        $week['first_day_of_week_timestamp'] = $first_day_of_week_timestamp;
        $last_day_of_week_timestamp = strtotime($week['first_day_of_week'] . " +6 days");
        $week['last_day_of_week'] = date($format, $last_day_of_week_timestamp);
        $week['last_day_of_week_timestamp'] = $last_day_of_week_timestamp;

        return $week;
    }

    function updateDataProfile() {
        $this->load->library('mongo_db');
        $formdataarray = $this->input->post('fdata');
        $this->db->update('company_info', $formdataarray, array('company_id' => $this->session->userdata("LoginId")));

        $this->session->set_userdata(array('profile_pic' => $formdataarray['logo'],
            'first_name' => $formdataarray['first_name'],
            'last_name' => $formdataarray['last_name']));
    }

    function getDriverList() {
        $this->load->library('mongo_db');
        $data = $this->mongo_db->get('driver');
        return $data;
    }

    function Getdashboarddata() {
        $this->load->library('mongo_db');
        $dashboard['customers'] = $this->mongo_db->count('slaves');
        $dashboard['drivers'] = $this->mongo_db->count('driver');

        $currTime = time();

        // today completed booking count
        $today = date('Y-m-d', $currTime);
        $weekArr = $this->week_start_end_by_date($currTime);

        $dashboard['today'] = $this->mongo_db->where(array('timpeStamp_appointment_date' => array('$gte' => strtotime('today midnight')), 'status' => 10))->count('ShipmentDetails');

        $dashboard['week'] = $this->mongo_db->where(array('timpeStamp_appointment_date' => array('$gte' => strtotime($weekArr['first_day_of_week'])), 'status' => 10))->count('ShipmentDetails');


        $dashboard['month'] = $this->mongo_db->where(array('timpeStamp_appointment_date' => array('$gte' => strtotime('first day of ' . date('F Y')), '$lte' => strtotime(date('Y-m-t'))), 'status' => 10))->count('ShipmentDetails');

        $dashboard['lifetime'] = $this->mongo_db->where(array('status' => 10))->count('ShipmentDetails');

        $dashboard['apple'] = $this->mongo_db->where(array('devices.deviceType' => 1))->count('slaves');
        $dashboard['andriod'] = $this->mongo_db->where(array('devices.deviceType' => 2))->count('slaves');
        $dashboard['totalUser'] = $this->mongo_db->count('slaves');

//       echo '<pre>';
//       print_r($dashboard);
//       
//       echo '</pre>';
//       exit();
        return $dashboard;
    }

    function getOperatorsAjax($param = '') {
        $this->load->library('mongo_db');
        if ($param != '')
            $getAll = $this->mongo_db->where(array('cityID' => new MongoDB\BSON\ObjectID($param)))->get('operators');
        else
            $getAll = $this->mongo_db->get('operators');
        echo json_encode(array('data' => $getAll));
        return;
    }

    function datatable_driverReferrals() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "firstName";
        $_POST['mDataProp_1'] = "firstName";
        $_POST['mDataProp_2'] = "mobile";
        $_POST['mDataProp_3'] = "email";
        $_POST['mDataProp_4'] = "referralCode";

//        $city = $this->session->userdata('city');
//        $operator = $this->session->userdata('company_id');
//        if ($city != '') {
//            $getAllOperatorsForCity = $this->mongo_db->where(array('cityID' => new MongoDB\BSON\ObjectID($city)))->get('operators');
//            $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [2, 3, 4])));
//        }
//             'companyId' => new MongoDB\BSON\ObjectID($operator)

        $respo = $this->datatables->datatable_mongodb('driver', array('status' => array('$in' => [2, 3, 4])));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $arr = array();
            $arr[] = '<a style="cursor: pointer;" class="getDriverDetails" mas_id="' . $value['_id']['$oid'] . '"/>' . $value['firstName'] . ' ' . $value['lastName'] . '</a>';
            $arr[] = $value['countryCode'] . $value['mobile'];
            $arr[] = $value['email'];
            $arr[] = $value['planName'];
            $arr[] = ($value['driverType'] == 2) ? 'N/A' : $value['referralCode'];
            $arr[] = (count($value['referralUsedBy']) > 0) ? '<a style="cursor: pointer;" driverReferralCount="' . count($value['referralUsedBy']) . '" class="getDriversReferralsList" mas_id="' . $value['_id']['$oid'] . '"/>' . count($value['referralUsedBy']) . '</a>' : '0';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function issessionset() {

        if ($this->session->userdata('emailid') && $this->session->userdata('password')) {

            return true;
        }
        return false;
    }

    /*
      Get all zones
      Usage - While activating a driver
     */

    function getAllZones() {

        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get('zones');

        echo json_encode(array('data' => $cursor));
    }

//    public function getZonesByStoreId($param) {
//        $this->load->library('mongo_db');
//
//        $cursor = $this->mongo_db->where(array("zoneStores" => $param))->get('zones');
//
//        echo json_encode(array('data' => $cursor));s
//    }
    public function getZonesByStoreId($param) {
        $this->load->library('mongo_db');

        $cursorStore = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($param)))->find_one('stores');
        foreach ($cursorStore['serviceZones'] as $zoneId) {
            $cursor = array();
            $cursor[] = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($zoneId)))->find_one('zones');
        }
//        echo '<pre>';
//        print_r($cursor);die;
        echo json_encode(array('data' => $cursor));
    }

    public function getZonesByCity($param) {
        $this->load->library('mongo_db');

        $cursor = $this->mongo_db->where(array("city_ID" => $param))->get('zones');

        echo json_encode(array('data' => $cursor));
    }

    public function getIfraneUrl($reportId)
    {
        $url = APILink . 'admin/dashbord/report/'.$reportId;
        // print_r($url); die;
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Postman-Token: fd9bcc49-7d20-477e-ae58-dcfe7351ee1d"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return json_decode($response, true);

    }
    // google key rotation
    function datatable_googleKey() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "keyRotationArray.currentKey";
        $respo = $this->datatables->datatable_mongodb('appConfig', array());
        $aaData = $respo["aaData"][0];
        $datatosend = array();
        $sno = 1;
        //print_r($respo);
        foreach ($aaData['keyRotationArray'] as $key => $value) {
            $style = "";
            $style1 = "";
            $hide = "";
            if ($aaData['currentKeyIndex'] === $key) {
                $style = "text-success";
                $hide = "display : none";
                $style1 = "font-weight:bold";
            } else if ($aaData['currentKeyIndex'] > $key) {
                $style = "text-danger";
                $hide = "";
                $style1 = "font-weight:bold";
            } else {
                $style = "";
                $hide = "";
                $style1 = "";
            }
            $arr = array();
            $arr[] = $sno++;
            $arr[] = '<span style="' . $style1 . '" class="' . $style . '">' . $value['currentKey'] . '</span>';
            $arr[] = $value['totalDistanceLimit'];
            $arr[] = $value['totalPlacesLimit'];
            $arr[] = $value['totalDirectionLimit'];
            $arr[] = $value['distanceHit'];
            $arr[] = $value['placesHit'];
            $arr[] = $value['directionHit'];
            $arr[] = $value['billingAccountId'];
            $arr[] = "<button style='border-color: #4d90fe;background-color: #4d90fe;color: #fff;" . $stylesBanButton . "' class='buttonCss btn  btn-info editKey cls111' data-toggle='tooltip' title='Ban' data-id='" . $value['_id']['$oid'] . "'><i class='fa  fa-pencil-square-o'></i></button>"
                    . "<button style='" . $hide . "' class='buttonCss btn btn-danger btn-cons deleteOne cls111' data-toggle='tooltip' title='Delete' data-index = '" . $key . "' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-trash'></i></button>";
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function insertKeys() {
        $getAll = $this->mongo_db->find_one('appConfig');
        $data = array(
            "_id" => new MongoDB\BSON\ObjectID(),
            "currentKey" => $this->input->post('key'),
            "directionHit" => 0,
            "distanceHit" => 0,
            "placesHit" => 0,
            "totalDirectionLimit" => (int) $this->input->post('direction'),
            "totalDistanceLimit" => (int) $this->input->post('distance'),
            "totalPlacesLimit" => (int) $this->input->post('places'),
            "billingAccountId"=>$this->input->post('billingAccountId'),
            "completeQuotaLimit"=>false,
            
        );
        if (!$getAll['currentKeyIndex']) {
            $this->mongo_db->where(array())->set(array('currentKeyIndex' => 0))->update('appConfig');
        }

        $totalKeys = 1;
        if ($getAll['keyRotationArray']) {
            $totalKeys = $totalKeys + count($getAll['keyRotationArray']);
        }

        $this->mongo_db->where(array())->set(array('totalKeys' => $totalKeys))->update('appConfig');
        
        $result = $this->mongo_db->where(array())->push('keyRotationArray', $data)->update('appConfig');

        if (!$result) {
            echo json_encode(array('msg' => FALSE));
        } else {
            echo json_encode(array('msg' => TRUE));
        }
    }

    function updateKeys() {
        $data = array(
            "keyRotationArray.$.currentKey" => $this->input->post('key'),
            "keyRotationArray.$.totalDirectionLimit" => (int) $this->input->post('direction'),
            "keyRotationArray.$.totalDistanceLimit" => (int) $this->input->post('distance'),
            "keyRotationArray.$.totalPlacesLimit" => (int) $this->input->post('places'),
            "keyRotationArray.$.billingAccountId" =>$this->input->post('billingAccountId'),  
            "keyRotationArray.$.completeQuotaLimit" =>false,          


        );
        $result = $this->mongo_db->where(array("keyRotationArray._id" => new MongoDB\BSON\ObjectID($this->input->post('id'))))->set($data)->update('appConfig');

        if (!$result) {
            echo json_encode(array('msg' => FALSE));
        } else {
            echo json_encode(array('msg' => TRUE));
        }
    }

    function fetchKeyDetails($id) {
        $this->load->library('mongo_db');
        $condition = array(
            array(
                '$unwind' => '$keyRotationArray'
            ),
            array('$match' => array('keyRotationArray._id' => new MongoDB\BSON\ObjectID($id)))
        );

        $respo = $this->mongo_db->aggregate('appConfig', $condition);
        foreach ($respo as $data) {
            
        }

        echo json_encode(array('data' => $data->keyRotationArray));
        return;
//        foreach($respo as $data) {
//            echo json_encode(array('data' => $data['keyRotationArray']));
//            return;
//        }
    }

    function deleteKeys() {
        $id = $this->input->post('id');
        $getAll = $this->mongo_db->find_one('appConfig');
        $result = $this->mongo_db->where(array('keyRotationArray._id' => new MongoDB\BSON\ObjectID($id)))->pull('keyRotationArray', array("_id" => new MongoDB\BSON\ObjectID($id)))->update('appConfig');
        $totalKeys = 1;
        if ($getAll['keyRotationArray']) {
            $totalKeys = count($getAll['keyRotationArray']) - 1;
        }

        $this->mongo_db->where(array())->set(array('totalKeys' => $totalKeys))->update('appConfig');
        if ((int) $this->input->post('index') < $getAll['currentKeyIndex']) {
            $this->mongo_db->where(array())->set(array('currentKeyIndex' => $getAll['currentKeyIndex'] - 1))->update('appConfig');
        }
        if (!$result) {
            echo json_encode(array('msg' => FALSE));
        } else {
            echo json_encode(array('msg' => TRUE));
        }
    }

    //end

    function getWallet() {
        $this->load->library('mongo_db');
        $mas_id = $this->input->post('mas_id');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mas_id), 'wallet' => array('$exists' => TRUE)))->find_one('driver');

        if ($result['wallet']['softLimit'] !== 0 && $result['wallet']['hardLimit'] !== 0)
            $data = array('data' => $result, 'flag' => 0);
        else {
            //get data from city as deafault for wallet
           // $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($result['cityId']['$oid'])))->find_one('cities');

            $cityData = $this->mongo_db->aggregate('cities',[
                ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($result['cityId'])]],
                ['$unwind'=>'$cities'],
                ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($result['cityId'])]]                
                ]);

            foreach($cityData as $cData){
                $doc = json_decode(json_encode($cData),TRUE)['cities'];
            }

            $data = array('data' => $doc, 'flag' => 1);
        }
        echo json_encode($data);
        return;
    }

    function walletUpdateForDriver() {
        $this->load->library('mongo_db');
        $driverID = $this->input->post('driverID');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($driverID)))->find_one('driver');

        if ($result) {


            $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($driverID)))->set(array('wallet.softLimit' => (float) $this->input->post('softLimit'), 'wallet.hardLimit' => (float) $this->input->post('hardLimit')))->update('driver');

            //API calling
            $url = APILink . 'admin/walletLimit';
            $r = $this->callapi->CallAPI('POST', $url, array('userId' => $driverID, 'userType' => 2));
        }

        echo json_encode(array('Msg' => $data, 'apiResponse' => $r));
        return;
    }

    function validatePassword($id = '') {

        $this->load->library('mongo_db');
        $data = $_POST;
        $curs = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('admin_users');
        if (md5($data['oldpass']) !== $curs['pass']) {
            $cout = 1;
        }
        $result = 0;
        if ($cout > 0) {
            $result = 1;
        }
        echo json_encode(array('msg' => $result));
    }

    function editpassword() {

        $this->load->library('mongo_db');
        $adminId = $this->session->userdata('userid');       
        $pwd['pass']=md5($_POST['password']);
        echo $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($adminId)))->set($pwd)->update('admin_users');
        
    }

}

?>
