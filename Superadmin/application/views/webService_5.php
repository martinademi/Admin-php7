<?php

error_reporting(0);
require_once 'Models/API.php';
require_once 'Models/ConDB.php';
require_once 'Models/getErrorMsg.php';
require_once 'Models/ManageToken.php';
require_once 'Models/class.verifyEmail.php';
require_once 'Models/StripeModule.php';
require_once 'Models/InvoiceHtml.php';
require_once 'Models/mandrill/src/Mandrill.php';
require_once 'Models/sendAMail.php';
require_once 'Models/class.phpmailer.php';
//require_once 'Models/MPDF56/mpdf.php';
require_once 'Models/Pubnub.php';
require_once 'Models/PushWoosh.php';

class MyAPI extends API {

    protected $User;
    private $db;
    private $mongo;
    private $appName = "Roadyo";
    private $host = 'http://107.170.66.211/roadyo_live/';
    private $api_key = '2ee51574176b15c2e';
    private $ios_roadyo_pas = 'cert/FreetaxiPassenger.pem'; //'cert/RoadyoPassenger_Dist.pem';
    private $ios_roadyo_driver = 'cert/freetaxiDriver.pem'; //'cert/Driver_Dist.pem';
    private $ios_cert_path;
    private $ios_pas_pwd = '3embed';
    private $ios_dri_pwd = '3Embed';
    private $ios_cert_pwd;
    private $androidApiKey;
    private $slaveApiKey = 'AIzaSyDNg8sRIT2XYg4oDJMdiKXaKlz_WnoAbfw';
    private $masterApiKey = 'AIzaSyAOUTMFFPrQr61VLeppGEib7jhqnxRL1zQ';
    private $androidUrl = 'http://android.googleapis.com/gcm/send';
    private $default_profile_pic = 'aa_default_profile_pic.gif';
    private $ios_cert_server = "ssl://gateway.sandbox.push.apple.com:2195";
//    private $ios_cert_server = "ssl://gateway.push.apple.com:2195";
    private $stripe;
    private $curr_date_time;
    private $maxChunkSize = 1048576;
    private $reviewsPageSize = 5;
    private $historyPageSize = 5;
    private $avgSpeedForDistanceCalculationInKms = 45;
    private $cancellationTimeInSec = 300; //cancellation time for free in seconds
    private $pubnubChannelForDriver = "roadyo_alltypes";
    private $publish_key = "pub-c-56562a22-37c6-4c39-aad7-c740242df47f";
    private $subscribe_key = "sub-c-980258f2-3b4e-11e4-8947-02ee2ddab7fe";
    private $pubnub;
    private $promoCodeRadius = 50;
    private $distanceMetersByUnits = 1000; //KMPH, for MPH give 1609.34
    private $bookingInactivityExpireTime = 36000;
    private $share = "http://107.170.66.211/roadyo_live/Wko8TuOH/track.php?id=";

    /*
      Development -- ssl://gateway.sandbox.push.apple.com:2195
      Production -- ssl://gateway.push.apple.com:2195
     */

    public function __construct($request_uri, $postData, $origin) {

        parent::__construct($request_uri, $postData);

        $this->db = new ConDB();

        $con = new Mongo();
        $this->mongo = $con->roadyo_live;
        $this->stripe = new StripeModule();

        $this->pubnub = new Pubnub($this->publish_key, $this->subscribe_key);
    }

    /*              ----------------                SERVICE METHODS             ---------------------               */
    /*
     * Method name: masterSignup1
     * Desc: Driver Sign up for the app step 1
     * Input: Request data
     * Output: Success flag with data array if completed successfully, else data array with error flag
     */

    protected function masterSignup1($args) {

        if ($args['ent_first_name'] == '' || $args['ent_last_name'] == '' || $args['ent_email'] == '' || $args['ent_password'] == '' || $args['ent_mobile'] == '' || $args['ent_dev_id'] == '' ||
                $args['ent_push_token'] == '' || $args['ent_device_type'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1); //$args['ent_tax_num'] == ''  //_getStatusMessage($errNo, $test_num);        //|| ($args['ent_comp_id'] == '0' && $args['ent_comp_name'] == '') 

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $devTypeNameArr = $this->_getDeviceTypeName($args['ent_device_type']);

        if (!$devTypeNameArr['flag'])
            return $this->_getStatusMessage(4, 4); //_getStatusMessage($errNo, $test_num);

        $verifyEmail = $this->_verifyEmail($args['ent_email'], 'mas_id', 'master'); //_verifyEmail($email,$field,$table);

        if (is_array($verifyEmail))
            return $this->_getStatusMessage(2, 2); //_getStatusMessage($errNo, $test_num);

        $args['ent_first_name'] = ucfirst($args['ent_first_name']);
//        $args['ent_last_name'] = ($args['ent_last_name'] == '') ? 'Lastname' : ucfirst($args['ent_last_name']);
//        if ($args['ent_comp_id'] == '0') {
//            $insertCompanyQry = "insert into company_info(companyname,vat_number,Status) values('" . $args['ent_comp_name'] . "','" . $args['ent_tax_num'] . "','5')";
//            mysql_query($insertCompanyQry, $this->db->conn);
//            $comp_id = mysql_insert_id();
//        } else {
//        $comp_id = $args['ent_comp_id'];
//        }

        $insertMasterQry = "
                        insert into 
                        master(first_name,last_name,email,password,mobile,
                        zipcode,created_dt,last_active_dt,status) 
                        values('" . $args['ent_first_name'] . "','" . $args['ent_last_name'] . "','" . $args['ent_email'] . "','" . $args['ent_password'] . "','" . $args['ent_mobile'] . "',
                            '" . $args['ent_zipcode'] . "','" . $this->curr_date_time . "','" . $this->curr_date_time . "','1')"; //,'" . $comp_id . "'

        mysql_query($insertMasterQry, $this->db->conn);
//echo $insertMasterQry;
        if (mysql_error($this->db->conn) != '')
            return $this->_getStatusMessage(3, $insertMasterQry); //_getStatusMessage($errNo, $test_num);

        $newDriver = mysql_insert_id($this->db->conn);

        if ($newDriver <= 0)
            return $this->_getStatusMessage(3, 4); //_getStatusMessage($errNo, $test_num);

        $token_obj = new ManageToken();

        $location = $this->mongo->selectCollection('location');

        $curr_gmt_date = new MongoDate(strtotime($this->curr_date_time));

        $mongoArr = array("type" => 0, "user" => (int) $newDriver, "name" => $args['ent_first_name'], "lname" => $args['ent_last_name'],
            "location" => array(
                "longitude" => (double) $args['ent_longitude'],
                "latitude" => (double) $args['ent_latitude']
            ), "image" => "", "rating" => 0, 'status' => 1, 'email' => strtolower($args['ent_email']), 'dt' => $curr_gmt_date->sec, 'chn' => 'qd_' . $args['ent_dev_id'], 'listner' => 'qdl_' . $args['ent_dev_id'], 'carId' => 0
        );

        $location->insert($mongoArr);

        $createRecipientArr = array('name' => $args['ent_first_name'] . ' ' . $args['ent_last_name'], 'type' => 'individual', 'email' => $args['ent_email'], 'tax_id' => '000000000', 'account_number' => '000123456789', 'routing_number' => '110000000', 'country' => 'US', 'description' => 'For ' . $args['ent_email']);

        $recipient = $this->stripe->apiStripe('createRecipient', $createRecipientArr);

        if ($recipient['error']) {
            $cardRes = array('errFlag' => 1, 'errMsg' => $recipient['error']['message']);
        } else {
            $updateQry = "update master set stripe_id = '" . $recipient['id'] . "' where mas_id = '" . $newDriver . "'";
            mysql_query($updateQry, $this->db->conn);

            if (mysql_affected_rows() <= 0)
                $cardRes = $this->_getStatusMessage(3, 50);
            else
                $cardRes = array('errFlag' => 0, 'errMsg' => 'Recipient created');
        }

        $mail = new sendAMail($this->host);
        $mailArr = $mail->sendMasWelcomeMail($args['ent_email'], $args['ent_first_name']);

//        $coupon = $this->_createCoupon();
//
//        $couponData = array('id' => $coupon, 'duration' => 'forever', 'percent_off' => 15);
//
//        $couponRes = $this->stripe->apiStripe('createCoupon', $couponData);
//
//        $insertCouponQry = "insert into coupon values ('" . $couponRes['id'] . "','" . $newDriver . "','1','15',0)";
//        mysql_query($insertCouponQry, $this->db->conn);

        /* createSessToken($obj_id, $dev_name, $mac_addr, $push_token); */
        $createSessArr = $token_obj->createSessToken($newDriver, $devTypeNameArr['name'], $args['ent_dev_id'], $args['ent_push_token'], '1', $this->curr_date_time);

        $errMsgArr = $this->_getStatusMessage(12, 5); //_getStatusMessage($errNo, $test_num);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'data' => array('token' => $createSessArr['Token'], 'expiryLocal' => $createSessArr['Expiry_local'], 'expiryGMT' => $createSessArr['Expiry_GMT'], 'flag' => $createSessArr['Flag'], 'joined' => $this->curr_date_time, 'chn' => $this->pubnubChannelForDriver, 'email' => $args['ent_email'], 'mFlg' => $mailArr['flag'], 'susbChn' => 'qd_' . $args['ent_dev_id'], 'listner' => 'qdl_' . $args['ent_dev_id'], 'coupon' => $coupon));
    }

    /*
     * Method name: masterLogin
     * Desc: Driver login on the app
     * Input: Request data
     * Output:  Success flag with data array if completed successfully, else data array with error flag
     */

    protected function masterLogin($args) {

        if ($args['ent_email'] == '' || $args['ent_password'] == '' || $args['ent_dev_id'] == '' || $args['ent_push_token'] == '' || $args['ent_device_type'] == '' || $args['ent_date_time'] == '' || $args['ent_lat'] == '' || $args['ent_long'] == '')
            return $this->_getStatusMessage(1, 6); //_getStatusMessage($errNo, $test_num);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $devTypeNameArr = $this->_getDeviceTypeName($args['ent_device_type']);

        if (!$devTypeNameArr['flag'])
            return $this->_getStatusMessage(5, 108);

        $searchDriverQry = "select m.company_id,m.mas_id,m.profile_pic,m.first_name,m.last_name,m.created_dt,m.license_num,m.status,m.workplace_id,(select status from company_info where company_id = m.company_id) as company_status from master m where m.email = '" . $args['ent_email'] . "' and m.password = '" . $args['ent_password'] . "'";
        $searchDriverRes = mysql_query($searchDriverQry, $this->db->conn);
//echo $searchDriverQry;

        if (mysql_num_rows($searchDriverRes) <= 0)
            return $this->_getStatusMessage(8, $searchDriverQry); //_getStatusMessage($errNo, $test_num);

        $driverRow = mysql_fetch_assoc($searchDriverRes);

        if ($driverRow['company_status'] != '3')
            return $this->_getStatusMessage(92, 17); //_getStatusMessage($errNo, $test_num);

        if ($driverRow['status'] == '2' || $driverRow['status'] == '1')
            return $this->_getStatusMessage(10, 17); //_getStatusMessage($errNo, $test_num);

        if ($driverRow['status'] == '4')
            return $this->_getStatusMessage(79, 79); //_getStatusMessage($errNo, $test_num);

        $location = $this->mongo->selectCollection('location');

        $masterDet = $location->findOne(array('user' => (int) $driverRow['mas_id']));

        $checkCarAvailabilityQry = "select w.type_id,w.Status,w.company,w.workplace_id,(select type_icon from workplace_types where type_id = w.type_id) as type_icon from workplace w where w.uniq_identity = '" . $args['ent_car_id'] . "'";
        $checkCarAvailabilityRes = mysql_query($checkCarAvailabilityQry, $this->db->conn);

        if (mysql_num_rows($searchDriverRes) <= 0)
            return $this->_getStatusMessage(8, $searchDriverQry); //_getStatusMessage($errNo, $test_num);

        $carRow = mysql_fetch_assoc($checkCarAvailabilityRes);

        if ($carRow['company'] != $driverRow['company_id'])
            return $this->_getStatusMessage(77, 77); //_getStatusMessage($errNo, $test_num);

        if ($carRow['workplace_id'] != $driverRow['workplace_id'] && $carRow['Status'] == '1')
            return $this->_getStatusMessage(76, 76); //_getStatusMessage($errNo, $test_num);

        if ($carRow['workplace_id'] != $driverRow['workplace_id']) {

            $updateCarIdForDriverQry = "update master set workplace_id = '" . $carRow['workplace_id'] . "',type_id='" . $carRow['type_id'] . "' where mas_id = '" . $driverRow['mas_id'] . "'";
            mysql_query($updateCarIdForDriverQry, $this->db->conn);

            if (mysql_affected_rows() <= 0)
                return $this->_getStatusMessage(3, 17); //_getStatusMessage($errNo, $test_num);

            $location->update(array('user' => (int) $driverRow['mas_id']), array('$set' => array('type' => (int) $carRow['type_id'], 'carId' => (int) $carRow['workplace_id'], 'chn' => 'qd_' . $args['ent_dev_id'], 'listner' => 'qdl_' . $args['ent_dev_id'])));

            $updateCarStatusQry = "update workplace set Status = 1,last_login_lat = '" . $args['ent_lat'] . "',last_login_long = '" . $args['ent_long'] . "' where workplace_id = '" . $carRow['workplace_id'] . "'";
            mysql_query($updateCarStatusQry, $this->db->conn);

            $updatePrevCarStatusQry = "update workplace set Status = 2,last_login_lat = '" . $args['ent_lat'] . "',last_login_long = '" . $args['ent_long'] . "' where workplace_id = '" . $driverRow['workplace_id'] . "'";
            mysql_query($updatePrevCarStatusQry, $this->db->conn);
        }

        mysql_query("update user_sessions set loggedIn = 2 where device = '" . $args['ent_dev_id'] . "' and user_type = 1 and oid != '" . $driverRow['mas_id'] . "'", $this->db->conn);
        mysql_query("update user_sessions set loggedIn = 3 where device != '" . $args['ent_dev_id'] . "' and user_type = 1 and oid = '" . $driverRow['mas_id'] . "'", $this->db->conn);
        /*
         * Sending last workplace id in an array for the current user, if he is logged in this car, then that will be freed for others
         */
        $sessDet = $this->_checkSession($args, $driverRow['mas_id'], '1', $devTypeNameArr['name'], null); // ($carRow['workplace_id'] == $driverRow['workplace_id']) ? NULL : array('workplaceId' => $driverRow['workplace_id'], 'lat' => $args['ent_lat'], 'lng' => $args['ent_long'])); //_checkSession($args, $oid, $user_type);

        $location->update(array('user' => (int) $driverRow['mas_id']), array('$set' => array('carId' => (int) $carRow['workplace_id'], 'chn' => 'qd_' . $args['ent_dev_id'], 'listner' => 'qdl_' . $args['ent_dev_id'], 'status' => 3)));

        $errMsgArr = $this->_getStatusMessage(9, 8);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'data' => array('token' => $sessDet['Token'], 'expiryLocal' => $sessDet['Expiry_local'], 'expiryGMT' => $sessDet['Expiry_GMT'], 'fname' => $driverRow['first_name'], 'lname' => $driverRow['last_name'], 'profilePic' => $driverRow['profile_pic'], 'medicalLicenseNum' => $driverRow['license_num'], 'flag' => $sessDet['Flag'], 'joined' => $driverRow['created_dt'], 'email' => $args['ent_email'], 'susbChn' => 'qd_' . $args['ent_dev_id'], 'chn' => $this->pubnubChannelForDriver, 'listner' => 'qdl_' . $args['ent_dev_id'], 'status' => $masterDet['status'], 'vehTypeId' => ($carRow['type_id'] != '' ? $carRow['type_id'] : $masterDet['type']), 'typeImage' => $carRow['type_icon']));
    }

    /*
     * Method name: slaveSignup
     * Desc: Passenger signup
     * Input: Request data
     * Output:  Success flag with data array if completed successfully, else data array with error flag
     */

    protected function slaveSignup($args) {

        if ($args['ent_first_name'] == '' || $args['ent_email'] == '' || $args['ent_password'] == '' || $args['ent_mobile'] == '' || $args['ent_dev_id'] == '' ||
                $args['ent_push_token'] == '' || $args['ent_device_type'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1); //_getStatusMessage($errNo, $test_num);
            /* $args['ent_cc_num'] == '' || $args['ent_cc_exp'] == '' || $args['ent_cc_cvv'] == '') */

        $this->curr_date_time = urldecode($args['ent_date_time']);

        if ($args['ent_terms_cond'] == '0')
            return $this->_getStatusMessage(14, 14); //_getStatusMessage($errNo, $test_num);

        if ($args['ent_pricing_cond'] == '0')
            return $this->_getStatusMessage(15, 15); //_getStatusMessage($errNo, $test_num);

        if ($args['ent_latitude'] == '')
            $args['ent_latitude'] = '0';

        if ($args['ent_longitude'] == '')
            $args['ent_longitude'] = '0';

        $devTypeNameArr = $this->_getDeviceTypeName($args['ent_device_type']);

        if (!$devTypeNameArr['flag'])
            return $this->_getStatusMessage(4, 4); //_getStatusMessage($errNo, $test_num);

        $carTypes = $this->getWorkplaceTypes($args['ent_city'], $args['ent_latitude'], $args['ent_longitude']);

//        if (!is_array($carTypes))
//            return $this->_getStatusMessage(80, 80);

        $verifyEmail = $this->_verifyEmail($args['ent_email'], 'slave_id', 'slave'); //_verifyEmail($email,$field,$table);

        if (is_array($verifyEmail))
            return $this->_getStatusMessage(2, 2); //_getStatusMessage($errNo, $test_num);

        $insertSlaveQry = "
                        insert into 
                        slave(first_name,last_name,email,password,phone,zipcode,status,
                        created_dt,last_active_dt,latitude,longitude) 
                        values('" . $args['ent_first_name'] . "','" . $args['ent_last_name'] . "','" . $args['ent_email'] . "','" . $args['ent_password'] . "','" . $args['ent_mobile'] . "','" . $args['ent_zipcode'] . "','3',
                                '" . $this->curr_date_time . "','" . $this->curr_date_time . "','" . $args['ent_latitude'] . "','" . $args['ent_longitude'] . "')";

        mysql_query($insertSlaveQry, $this->db->conn);

        if (mysql_error($this->db->conn) != '')
            return $this->_getStatusMessage(3, $insertSlaveQry); //_getStatusMessage($errNo, $test_num);

        $newPassenger = mysql_insert_id($this->db->conn);

        if ($newPassenger <= 0)
            return $this->_getStatusMessage(3, 3); //_getStatusMessage($errNo, $test_num);

        $cardRes = array('errFlag' => 1, 'errMsg' => 'Card not added', 'errNum' => 16);

        if ($args['ent_token'] != '') {

            $createCustomerArr = array('token' => $args['ent_token'], 'email' => $args['ent_email']);

            $customer = $this->stripe->apiStripe('createCustomer', $createCustomerArr);

            if ($customer['error']) {
                $cardRes = array('errFlag' => 1, 'errMsg' => $customer['error']['message'], 'errNum' => 16);
            } else {
                $updateQry = "update slave set stripe_id = '" . $customer['id'] . "' where slave_id = '" . $newPassenger . "'";
                mysql_query($updateQry, $this->db->conn);
                if (mysql_affected_rows() <= 0)
                    $cardRes = $this->_getStatusMessage(3, 50);
                else {

                    $getCardArr = array('stripe_id' => $customer['id']);

                    $card = $this->stripe->apiStripe('getCustomer', $getCardArr);

                    if ($card['error'])
                        $cardRes = array(); //'errNum' => 16, 'errFlag' => 1, 'errMsg' => $card['error']['message'], 'test' => 2);

                    foreach ($card['cards']['data'] as $c) {
                        $cardRes = array('errFlag' => 0, 'id' => $c['id'], 'last4' => $c['last4'], 'type' => $c['brand'], 'exp_month' => $c['exp_month'], 'exp_year' => $c['exp_year']);
                    }
                }
//                $cardError = array('id' => $customer['data']['id'], 'last4' => $customer['data']['last4'], 'type' => $customer['data']['type'], 'exp_month' => $customer['data']['exp_month'], 'exp_year' => $customer['data']['exp_year']);
            }
        }
        $referralUsageMsg = $couponId = "";
        $referralCode = $discountCode = $mailArr = array();
        $mail = new sendAMail($this->host);

        $checkReferralAvailability = "select cp.*,(select Currency from city where city_id = cp.city_id) as currency from coupons cp where cp.coupon_code = 'REFERRAL' and cp.coupon_type = 1 and cp.user_type = 2 and cp.status = 0 and cp.city_id in (select ca.City_Id from city_available ca where (3956 * acos( cos( radians('" . $args['ent_latitude'] . "') ) * cos( radians(ca.City_Lat) ) * cos( radians(ca.City_Long) - radians('" . $args['ent_longitude'] . "') ) + sin( radians('" . $args['ent_latitude'] . "') ) * sin( radians(ca.City_Lat) ) ) ) <= " . $this->promoCodeRadius . ")";

        $referralRes = mysql_query($checkReferralAvailability, $this->db->conn);

        if (mysql_num_rows($referralRes) > 0) {

            $referralData = mysql_fetch_assoc($referralRes);

            $coupon = $this->_createCoupon();

            $discountCoupon = $this->_createCoupon();

            $insertCouponQry = "insert into coupons(coupon_code,start_date,expiry_date,coupon_type,discount_type,discount,referral_discount_type,referral_discount,message,city_id,user_id,user_type) "
                    . "values ('" . $coupon . "','" . date('Y-m-d', time()) . "','" . date('Y-m-d', strtotime('+30 days', time())) . "','1','" . $referralData['discount_type'] . "','" . $referralData['discount'] . "','" . $referralData['referral_discount_type'] . "','" . $referralData['referral_discount'] . "','" . $referralData['message'] . "','" . $referralData['city_id'] . "','" . $newPassenger . "','1'),"
                    . " ('" . $discountCoupon . "','" . date('Y-m-d', time()) . "','" . date('Y-m-d', strtotime('+30 days', time())) . "','3','" . $referralData['discount_type'] . "','" . $referralData['discount'] . "','0','0','" . $referralData['message'] . "','" . $referralData['city_id'] . "','" . $newPassenger . "','1')";
            mysql_query($insertCouponQry, $this->db->conn);
//echo $insertCouponQry;
            if (mysql_affected_rows() > 0) {
                $referralCode = array('code' => $coupon, 'referralData' => $referralData);
                $couponId = $coupon;

                $mailArr[] = $mail->sendDiscountCoupon($args['ent_email'], $args['ent_first_name'], array('code' => $discountCoupon, 'refCoupon' => $coupon, 'discountData' => $referralData)); //$couponId
            }

            if ($args['ent_referral_code'] != '') {

                $checkCouponQry = "select cp.*,sl.first_name,sl.email,(select Currency from city where city_id = cp.city_id) as currency from coupons cp,slave sl where cp.user_id = sl.slave_id and cp.coupon_code = '" . $args['ent_referral_code'] . "' and cp.coupon_type = 1 and cp.user_type = 1 and cp.status = 0 and cp.expiry_date > '" . date('Y-m-d', time()) . "' and cp.city_id in (select ca.City_Id from city_available ca where (3956 * acos( cos( radians('" . $args['ent_latitude'] . "') ) * cos( radians(ca.City_Lat) ) * cos( radians(ca.City_Long) - radians('" . $args['ent_longitude'] . "') ) + sin( radians('" . $args['ent_latitude'] . "') ) * sin( radians(ca.City_Lat) ) ) ) <= " . $this->promoCodeRadius . ") limit 0,1";
                $checkCouponRes = mysql_query($checkCouponQry, $this->db->conn);

                if (mysql_num_rows($checkCouponRes) > 0) {
                    $couponData = mysql_fetch_assoc($checkCouponRes);

                    $insertCouponQry1 = "insert into coupons(coupon_code,start_date,expiry_date,coupon_type,discount_type,discount,message,city_id,user_id,user_type) values "
                            . " ('" . $discountCoupon . "','" . date('Y-m-d') . "','" . date('Y-m-d', strtotime('+30 days', time())) . "','3','" . $couponData['referral_discount_type'] . "','" . $couponData['referral_discount'] . "','" . $couponData['message'] . "','" . $couponData['city_id'] . "','" . $couponData['user_id'] . "','1')";
                    mysql_query($insertCouponQry1, $this->db->conn);
//echo $insertCouponQry1;
                    if (mysql_affected_rows() > 0) {
                        $mailArr[] = $mail->discountOnFriendSignup($couponData['email'], $couponData['first_name'], array('code' => $discountCoupon, 'discountData' => $couponData, 'uname' => $args['ent_first_name'])); //$couponId
                        $discountCode = $coupon;
                    } else {
//                        echo $insertCouponQry;
                    }
                } else {
                    $error = $this->_getStatusMessage(100, 99);
                    $referralUsageMsg = $error['errMsg'];
                }
            } else {
                
            }
        } else {
            $mailArr[] = $mail->sendSlvWelcomeMail($args['ent_email'], $args['ent_first_name']); //$couponId
//            echo $checkReferralAvailability;
        }

        /* createSessToken($obj_id, $dev_name, $mac_addr, $push_token); */
        $createSessArr = $this->_checkSession($args, $newPassenger, '2', $devTypeNameArr['name']); //$token_obj->createSessToken($newPassenger, $devTypeNameArr['name'], $args['ent_dev_id'], $args['ent_push_token'], '2');

        $errMsgArr = $this->_getStatusMessage(5, 5); //_getStatusMessage($errNo, $test_num);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'coupon' => $coupon,
            'token' => $createSessArr['Token'], 'expiryLocal' => $createSessArr['Expiry_local'], 'expiryGMT' => $createSessArr['Expiry_GMT'], 'email' => $args['ent_email'],
            'flag' => $createSessArr['Flag'], 'joined' => $this->curr_date_time, 'apiKey' => $this->api_key, 'card' => array($cardRes), 'mail' => $mailArr['flag'], 'types' => $carTypes, 'serverChn' => $this->pubnubChannelForDriver, 'chn' => 'qp_' . $args['ent_dev_id'],
            'noVehicleType' => strtoupper("Thank you for signing up! Unfortunately we are not in your city yet, please do send us an email at info@roadyo.net, if you will like us there!"));
    }

    /*
     * Method name: slaveLogin
     * Desc: Passenger login on the app
     * Input: Request data
     * Output:  Success flag with data array if completed successfully, else data array with error flag
     */

    protected function slaveLogin($args) {
//return $this->_getStatusMessage(5, 108);
        if ($args['ent_email'] == '' || $args['ent_password'] == '' || $args['ent_dev_id'] == '' || $args['ent_push_token'] == '' || $args['ent_device_type'] == '' || $args['ent_date_time'] == '')// || $args['ent_city'] == ''
            return $this->_getStatusMessage(1, 6); //_getStatusMessage($errNo, $test_num);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $devTypeNameArr = $this->_getDeviceTypeName($args['ent_device_type']);

        if (!$devTypeNameArr['flag'])
            return $this->_getStatusMessage(5, 108);

        $carTypes = $this->getWorkplaceTypes($args['ent_city'], $args['ent_latitude'], $args['ent_longitude']);

//        if (count($carTypes) <= 0)
//            return $this->_getStatusMessage(80, 80);
//        if (!is_array($carTypes))
//            $carTypes = array();

        $searchPassengerQry = "select p.slave_id,p.profile_pic,p.first_name,p.created_dt,p.status,p.stripe_id,(select coupon_code from coupons where user_type = 1 and status = 0 and coupon_type = 1 and user_id = p.slave_id) as coupon_id  from slave p where p.email = '" . $args['ent_email'] . "' and p.password = '" . $args['ent_password'] . "'";
        $searchPassengerRes = mysql_query($searchPassengerQry, $this->db->conn);

        if (mysql_num_rows($searchPassengerRes) <= 0)
            return $this->_getStatusMessage(8, $searchPassengerQry); //_getStatusMessage($errNo, $test_num);

        $passengerRow = mysql_fetch_assoc($searchPassengerRes);

        if ($passengerRow['status'] == '1')
            return $this->_getStatusMessage(11, 18); //_getStatusMessage($errNo, $test_num);

        $cardsArr = array();
        if ($passengerRow['stripe_id'] != '') {

            $getCardArr = array('stripe_id' => $passengerRow['stripe_id']);

            $card = $this->stripe->apiStripe('getCustomer', $getCardArr);
            if ($card['error'])
                $cardsArr = array('errNum' => 16, 'errFlag' => 1, 'errMsg' => $card['error']['message'], 'test' => 2);
            else
                foreach ($card['cards']['data'] as $c) {
                    $cardsArr[] = array('id' => $c['id'], 'last4' => $c['last4'], 'type' => $c['brand'], 'exp_month' => $c['exp_month'], 'exp_year' => $c['exp_year']);
                }
        }

        $sessDet = $this->_checkSession($args, $passengerRow['slave_id'], '2', $devTypeNameArr['name']); //_checkSession($args, $oid, $user_type);

        $errMsgArr = $this->_getStatusMessage(9, 8);

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'coupon' => $passengerRow['coupon_id'],
            'token' => $sessDet['Token'], 'expiryLocal' => $sessDet['Expiry_local'], 'expiryGMT' => $sessDet['Expiry_GMT'], 'email' => $args['ent_email'],
            'profilePic' => ($passengerRow['profile_pic'] == '') ? $this->default_profile_pic : $passengerRow['profile_pic'], 'flag' => $sessDet['Flag'], 'joined' => $passengerRow['created_dt'], 'apiKey' => $this->api_key, 'cards' => $cardsArr, 'types' => $carTypes, 'serverChn' => $this->pubnubChannelForDriver, 'chn' => 'qp_' . $args['ent_dev_id'],
            'noVehicleType' => strtoupper("Thank you for signing up! Unfortunately we are not in your city yet, please do send us an email at info@roadyo.net, if you will like us there!"));
    }

    /*
     * Method name: uploadImage
     * Desc: Uploads media to the server folder named "pics"
     * Input: Request data
     * Output:  image name if uploaded and status message according to the result
     */

    protected function uploadImage($args) {

        if ($args['ent_sess_token'] == '' || $args['ent_dev_id'] == '' || $args['ent_snap_name'] == '' || $args['ent_snap_type'] == '' ||
                $args['ent_snap_chunk'] == '' || $args['ent_upld_from'] == '' || $args['ent_offset'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 204);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $valid_exts = array("jpg", "jpeg", "gif", "png");
// Select the extension from the file.
        $ext = end(explode(".", strtolower(trim($args['ent_snap_name']))));

        if (!in_array($ext, $valid_exts))
            return $this->_getStatusMessage(26, 12);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], $args['ent_upld_from'], '2');

        if (is_array($returned))
            return $returned;

        if (filter_var($args['ent_snap_chunk'], FILTER_VALIDATE_URL)) {
            $args['ent_snap_chunk'] = base64_encode(file_get_contents($args['ent_snap_chunk']));
        }

        if ($args['ent_upld_from'] == '1') {
            $table = 'master';
            $field = 'mas_id';
        } else {
            $table = 'slave';
            $field = 'slave_id';
        }

        $file_to_open = 'pics/' . $args['ent_snap_name'];

//        echo '<img src="data:image/jpg;base64,'.$args['ent_snap_chunk'].'" />';

        $newphrase_plus = str_replace('-', '+', $args['ent_snap_chunk']);
        $newphrase = str_replace('_', '/', $newphrase_plus);

        $base64_de = base64_decode($newphrase); //base64_decode($media_chunk);

        if (strlen($base64_de) > $this->maxChunkSize)
            return $this->_getStatusMessage(18, 205);

        $handle = fopen($file_to_open, 'a');
        $fwrite = fwrite($handle, $base64_de);
        fclose($handle);

        if ($fwrite === false)
            return $this->_getStatusMessage(19, 224);
        else if ($args['ent_snap_type'] == '1')
            mysql_query("update $table set profile_pic = '" . $args['ent_snap_name'] . "' where $field = '" . $this->User['entityId'] . "'", $this->db->conn);

        $file_size = filesize($file_to_open);
        $number_of_chunks = ceil($file_size / $this->maxChunkSize);

        if ((int) $args['ent_offset'] == $number_of_chunks) {

            if ($args['ent_upld_from'] == '1' && $args['ent_snap_type'] == '2') {
                mysql_query("insert into images(mas_id,image) values ('" . $this->User['entityId'] . "','" . $args['ent_snap_name'] . "')", $this->db->conn);
            }

            if ($args['ent_snap_type'] == '1' && $args['ent_upld_from'] == '1') {
                $location = $this->mongo->selectCollection('location');

                $newdata = array('$set' => array("image" => $args['ent_snap_name']));
                $location->update(array("user" => (int) $this->User['entityId']), $newdata);
            }

            list($width, $height) = getimagesize($file_to_open);

            $ratio = $height / $width;

            /* mdpi 36*36 */
            $mdpi_nw = 36;
            $mdpi_nh = $ratio * 36;

            $mtmp = imagecreatetruecolor($mdpi_nw, $mdpi_nh);

            $mdpi_image = imagecreatefromjpeg($file_to_open);

            imagecopyresampled($mtmp, $mdpi_image, 0, 0, 0, 0, $mdpi_nw, $mdpi_nh, $width, $height);

            $mdpi_file = 'pics/mdpi/' . $args['ent_snap_name'];

            imagejpeg($mtmp, $mdpi_file, 100);

            /* HDPI Image creation 55*55 */
            $hdpi_nw = 55;
            $hdpi_nh = $ratio * 55;

            $tmp = imagecreatetruecolor($hdpi_nw, $hdpi_nh);

            $hdpi_image = imagecreatefromjpeg($file_to_open);

            imagecopyresampled($tmp, $hdpi_image, 0, 0, 0, 0, $hdpi_nw, $hdpi_nh, $width, $height);

            $hdpi_file = 'pics/hdpi/' . $args['ent_snap_name'];

            imagejpeg($tmp, $hdpi_file, 100);

            /* XHDPI 84*84 */
            $xhdpi_nw = 84;
            $xhdpi_nh = $ratio * 84;

            $xtmp = imagecreatetruecolor($xhdpi_nw, $xhdpi_nh);

            $xhdpi_image = imagecreatefromjpeg($file_to_open);

            imagecopyresampled($xtmp, $xhdpi_image, 0, 0, 0, 0, $xhdpi_nw, $xhdpi_nh, $width, $height);

            $xhdpi_file = 'pics/xhdpi/' . $args['ent_snap_name'];

            imagejpeg($xtmp, $xhdpi_file, 100);

            /* xXHDPI 125*125 */
            $xxhdpi_nw = 125;
            $xxhdpi_nh = $ratio * 125;

            $xxtmp = imagecreatetruecolor($xxhdpi_nw, $xxhdpi_nh);

            $xxhdpi_image = imagecreatefromjpeg($file_to_open);

            imagecopyresampled($xxtmp, $xxhdpi_image, 0, 0, 0, 0, $xxhdpi_nw, $xxhdpi_nh, $width, $height);

            $xxhdpi_file = 'pics/xxhdpi/' . $args['ent_snap_name'];

            imagejpeg($xxtmp, $xxhdpi_file, 100);
        }

        $errMsgArr = $this->_getStatusMessage(17, 122);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'data' => array('picURL' => $file_to_open, 'writeFlag' => $fwrite));
    }

    /*
     * Method name: getMasters
     * Desc: Get masters around an area
     * Input: Request data
     * Output:  master location if available and status message according to the result
     */

    protected function getMasters($args) {

        if ($args['ent_api_key'] == '' || $args['ent_latitude'] == '' || $args['ent_longitude'] == '' || $args['ent_search_type'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        if ($args['ent_api_key'] != $this->api_key)
            return $this->_getStatusMessage(1, 2);

        $resultArr = $this->mongo->selectCollection('$cmd')->findOne(array(
            'geoNear' => 'location',
            'near' => array(
                (double) $args['ent_longitude'], (double) $args['ent_latitude']
            ), 'spherical' => true, 'maxDistance' => 50000 / 6378137, 'distanceMultiplier' => 6378137,
            'query' => array('status' => 3, 'type' => (int) $args['ent_search_type']))
        );

        $md_arr = $nurse_arr = array();
//                    
        foreach ($resultArr['results'] as $res) {
            $doc = $res['obj'];
            $md_arr[] = array("name" => $doc["name"], 'lname' => $doc['lname'], "image" => $doc['image'], "rating" => (float) $doc['rating'],
                'email' => $doc['email'], 'lat' => $doc['location']['latitude'], 'lon' => $doc['location']['longitude'], 'dis' => number_format((float) $res['dis'] / $this->distanceMetersByUnits, 2, '.', ''));
        }


        if (count($md_arr) > 0 || count($nurse_arr) > 0)
            return array('errNum' => "101", 'errFlag' => 0, 'errMsg' => "Drivers found!", 'docs' => $md_arr, 'nurses' => $nurse_arr, 'test' => $args['ent_search_type']);

        return array('errNum' => "102", 'errFlag' => 1, 'errMsg' => "Drivers not found!", 'test' => $resultArr);
    }

    /*
     * Method name: getMasterDetails
     * Desc: Server sends the master details according to the email id that is sent by the client
     * Input: Request data
     * Output:  driver data if available and status message according to the result
     */

    protected function getMasterDetails($args) {

        if ($args['ent_sess_token'] == '' || $args['ent_dev_id'] == '' || $args['ent_dri_email'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $getDetailsQry = "select doc.mas_id,doc.first_name,doc.last_name,doc.mobile,doc.about,doc.profile_pic,doc.last_active_dt,doc.expertise,";
        $getDetailsQry .= "(select avg(star_rating) from master_ratings where mas_id = doc.mas_id) as rating,";
        $getDetailsQry .= "(select group_concat(image) from images where mas_id = doc.mas_id) as images ";
        $getDetailsQry .= "from master doc where doc.email = '" . $args['ent_dri_email'] . "'";
        $getDetailsRes = mysql_query($getDetailsQry, $this->db->conn);

        if (mysql_error($this->db->conn) != '')
            return $this->_getStatusMessage(3, $getDetailsQry); //_getStatusMessage($errNo, $test_num);

        $num_rows = mysql_num_rows($getDetailsRes);

        if ($num_rows <= 0)
            return $this->_getStatusMessage(20, $getDetailsQry); //_getStatusMessage($errNo, $test_num);

        $doc_data = mysql_fetch_assoc($getDetailsRes);

        $reviewsArr = $this->_getMasterReviews($args);

        if (!isset($reviewsArr[0]['rating']))
            $reviewsArr = array();

        $eduArr = array();

        $getEducationQry = "select edu.degree,edu.start_year,edu.end_year,edu.institute from master_education edu,master doc where doc.mas_id = edu.mas_id and doc.email = '" . $args['ent_dri_email'] . "'";
        $getEducationRes = mysql_query($getEducationQry, $this->db->conn);

        while ($edu = mysql_fetch_assoc($getEducationRes)) {
            $eduArr[] = array('deg' => $edu['degree'], 'start' => $edu['start_year'], 'end' => $edu['end_year'], 'inst' => $edu['institute']);
        }

        $errMsgArr = $this->_getStatusMessage(21, 122);

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'],
            'fName' => $doc_data['first_name'], 'lName' => $doc_data['last_name'], 'mobile' => $doc_data['mobile'], 'pPic' => $doc_data['profile_pic'], 'about' => ($doc_data['about'] == '' ? ' ' : $doc_data['about']), 'expertise' => $doc_data['expertise'],
            'ladt' => $doc_data['last_active_dt'], 'rating' => (float) $doc_data['rating'], 'images' => explode(',', $doc_data['images']), 'totalRev' => $reviewsArr[0]['total'], 'reviews' => $reviewsArr, 'education' => $eduArr);
    }

    /*
     * Method name: updateMasterLocation
     * Desc: Update master location
     * Input: Request data
     * Output:  success if changed else error according to the result
     */

    protected function updateMasterLocation($args) {

        if ($args['ent_latitude'] == '' || $args['ent_longitude'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $location = $this->mongo->selectCollection('location');

        $newdata = array('$set' => array("location" => array("longitude" => (float) $args['ent_longitude'], "latitude" => (float) $args['ent_latitude'])));
        $updated = $location->update(array("user" => (int) $this->User['entityId']), $newdata);

        if ($updated)
            return $this->_getStatusMessage(23, 2);
        else
            return $this->_getStatusMessage(22, 3);
    }

    /*
     * Method name: getMasterReviews
     * Desc: Get driver reviews by pagination
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function getMasterReviews($args) {

        if ($args['ent_dri_email'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $reviewsArr = $this->_getMasterReviews($args);

        if (!isset($reviewsArr[0]['rating']))
            return $reviewsArr;

        $errMsgArr = $this->_getStatusMessage(27, 122);

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'reviews' => $reviewsArr);
    }

    /*
     * Method name: getMasterAppointments
     * Desc: Get Driver appointments
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function getMasterAppointments($args) {

        if ($args['ent_appnt_dt'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

        $dates = explode('-', $args['ent_appnt_dt']);

        if (count($dates) == 3) {
            $endDate = date('Y-m-d', strtotime('+7 day', strtotime($args['ent_appnt_dt'])));
            $selectStr = " DATE(a.appointment_dt) between '" . $args['ent_appnt_dt'] . "' and '" . $endDate . "'";
        } else {
            $args['ent_appnt_dt'] = $args['ent_appnt_dt'] . '-01';
            $endDate = date('Y-m-d', strtotime('+1 month', strtotime($args['ent_appnt_dt'])));
            $selectStr = " YEAR(a.appointment_dt) = '" . (int) $dates[0] . "' and MONTH(a.appointment_dt) = '" . (int) $dates[1] . "'";
        }

        $selectAppntsQry = "select p.profile_pic,p.first_name,p.phone,p.email,a.appointment_id,a.appt_lat,a.appt_long,a.appointment_dt,a.extra_notes,a.address_line1,a.address_line2,a.drop_addr1,a.drop_addr2,a.drop_lat,a.drop_long,a.complete_dt,a.start_dt,a.arrive_dt,a.status,a.payment_status,a.amount,a.distance_in_mts,(select count(appointment_id) from appointment where status = 1 and mas_id = '" . $this->User['entityId'] . "') as pen_count from appointment a, slave p ";
        $selectAppntsQry .= " where p.slave_id = a.slave_id and a.mas_id = '" . $this->User['entityId'] . "' and " . $selectStr . " and a.status NOT IN (1,3,4,5,10) order by a.appointment_id DESC"; // and a.appointment_dt >= '" . $curr_date_bfr_1hr . "'        a.status NOT in (1,3,4,7) and

        $selectAppntsRes = mysql_query($selectAppntsQry, $this->db->conn);

        if (mysql_num_rows($selectAppntsRes) <= 0) {

            $selectPenCountQry = "select count(*) as count from appointment where status = 1 and mas_id = '" . $this->User['entityId'] . "'";
            $countArr = mysql_fetch_assoc(mysql_query($selectPenCountQry, $this->db->conn));
            $errMsgArr = $this->_getStatusMessage(30, 2);

            $date = $args['ent_appnt_dt'];

            while ($date <= $endDate) {

                $sortedApnts[] = array('date' => $date, 'appt' => array());
                $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
            }

            return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'penCount' => $countArr['count'], 'refIndex' => array(), 'appointments' => $sortedApnts, 't' => $selectAppntsQry);
        }

        $appointments = $daysArr = array();

        $pendingCount = 0;

        while ($appnt = mysql_fetch_assoc($selectAppntsRes)) {

            if ($appnt['profile_pic'] == '')
                $appnt['profile_pic'] = $this->default_profile_pic;

            $pendingCount = $appnt['pen_count'];

            $aptdate = date('Y-m-d', strtotime($appnt['appointment_dt']));

            $durationSec = (abs(strtotime($appnt['complete_dt']) - strtotime($appnt['start_dt'])) / 60);

            $durationMin = round($durationSec, 2);

//            if ($appnt['status'] == '1')
//                $status = 'Booking requested';
//            else if ($appnt['status'] == '2')
//                $status = 'Driver accepted.';
//            else if ($appnt['status'] == '3')
//                $status = 'Driver rejected.';
//            else if ($appnt['status'] == '4')
//                $status = 'You have cancelled.';
//            else if ($appnt['status'] == '5')
//                $status = 'Driver have cancelled.';
//            else
            if ($appnt['status'] == '6')
                $status = 'Driver is on the way.';
            else if ($appnt['status'] == '7')
                $status = 'Driver arrived.';
            else if ($appnt['status'] == '8')
                $status = 'Booking started.';
            else if ($appnt['status'] == '9')
                $status = 'Booking completed.';
//            else if ($appnt['status'] == '10')
//                $status = 'Booking expired.';
            else
                $status = 'Status unavailable.';

            $appointments[$aptdate][] = array('pPic' => $appnt['profile_pic'], 'email' => $appnt['email'], 'statCode' => $appnt['status'], 'status' => $status,
                'fname' => $appnt['first_name'], 'apntTime' => date('h:i a', strtotime($appnt['appointment_dt'])), 'bid' => $appnt['appointment_id'], 'apptDt' => $appnt['appointment_dt'],
                'addrLine1' => urldecode($appnt['address_line1']), 'payStatus' => ($appnt['payment_status'] == '') ? 0 : $appnt['payment_status'],
                'dropLine1' => urldecode($appnt['drop_addr1']), 'duration' => round($durationMin, 2), 'distance' => round($appnt['distance_in_mts'] / $this->distanceMetersByUnits, 2), 'amount' => $appnt['amount']);


//            $appointments[$aptdate][] = array('apntDt' => $appnt['appointment_dt'], 'pPic' => $appnt['profile_pic'], 'email' => $appnt['email'], 'status' => $appnt['status'], 'pickupDt' => $appnt['arrive_dt'], 'dropDt' => $appnt['complete_dt'],
//                'fname' => $appnt['first_name'], 'phone' => $appnt['phone'], 'apntTime' => date('h:i a', strtotime($appnt['appointment_dt'])),
//                'apntDate' => date('Y-m-d', strtotime($appnt['appointment_dt'])), 'apptLat' => (double) $appnt['appt_lat'], 'apptLong' => (double) $appnt['appt_long'],
//                'addrLine1' => urldecode($appnt['address_line1']), 'addrLine2' => urldecode($appnt['address_line2']), 'notes' => $appnt['extra_notes'],
//                'dropLine1' => urldecode($appnt['drop_addr1']), 'dropLine2' => urldecode($appnt['drop_addr2']), 'dropLat' => (double) $appnt['drop_lat'], 'dropLong' => (double) $appnt['drop_long'], 'duration' => $durationMin, 'distanceMts' => $appnt['distance_in_mts'], 'amount' => $appnt['amount']);
        }
        $refIndexes = $sortedApnts = array();
        $date = date('Y-m-d', strtotime($args['ent_appnt_dt']));

        while ($date < $endDate) {

            $empty_arr = array();

            if (is_array($appointments[$date])) {
                $sortedApnts[] = array('date' => $date, 'appt' => $appointments[$date]);
                $num = date('j', strtotime($date));
                $refIndexes[] = $num;
            } else {
                $sortedApnts[] = array('date' => $date, 'appt' => $empty_arr);
            }

            $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        }
//print_r($sortedApnts);

        $errMsgArr = $this->_getStatusMessage(31, 2);

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'penCount' => $pendingCount, 'refIndex' => $refIndexes, 'appointments' => $sortedApnts); //,'test'=>$selectAppntsQry,'test1'=>$appointments);
    }

    /*
     * Method name: getPendingAppointments
     * Desc: Get Driver appointments
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function getPendingAppts($args) {

        if ($args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

//        $curr_date = date('Y-m-d H:i:s', time());
//        $curr_date_bfr_30min = date('Y-m-d H:i:s', time() - 1800);
//        $curr_date_bfr_1hr = date('Y-m-d H:i:s', time() - 3600);


        $selectAppntsQry = "select p.profile_pic,p.first_name,p.phone,p.email,a.appt_lat,a.appt_long,a.appointment_dt,a.appointment_id,a.drop_addr2,a.drop_addr1,a.extra_notes,a.address_line1,a.address_line2,a.status,a.appt_type from appointment a, slave p ";
        $selectAppntsQry .= " where p.slave_id = a.slave_id and a.status = 2 and a.appt_type = 2 and a.mas_id = '" . $this->User['entityId'] . "' order by a.appointment_dt DESC"; // and a.appointment_dt >= '" . $curr_date_bfr_1hr . "'

        $selectAppntsRes = mysql_query($selectAppntsQry, $this->db->conn);

        if (mysql_num_rows($selectAppntsRes) <= 0)
            return $this->_getStatusMessage(30, $selectAppntsQry);

        $pending_appt = array();

        while ($appnt = mysql_fetch_assoc($selectAppntsRes)) {

            if ($appnt['profile_pic'] == '')
                $appnt['profile_pic'] = $this->default_profile_pic;

            $pending_appt[date('Y-m-d', strtotime($appnt['appointment_dt']))][] = array('apntDt' => $appnt['appointment_dt'], 'pPic' => $appnt['profile_pic'], 'email' => $appnt['email'], 'bid' => $appnt['appointment_id'],
                'fname' => $appnt['first_name'], 'phone' => $appnt['phone'], 'apntTime' => date('H:i', strtotime($appnt['appointment_dt'])), 'dropLine1' => urldecode($appnt['drop_addr1']), 'dropLine2' => urldecode($appnt['drop_addr2']),
                'apntDate' => date('Y-m-d', strtotime($appnt['appointment_dt'])), 'apptLat' => (double) $appnt['appt_lat'], 'apptLong' => (double) $appnt['appt_long'],
                'addrLine1' => urldecode($appnt['address_line1']), 'addrLine2' => urldecode($appnt['address_line2']), 'notes' => $appnt['extra_notes'], 'bookType' => $appnt['booking_type']);
        }

        $finalArr = array();

        foreach ($pending_appt as $date => $penAppt) {
            $finalArr[] = array('date' => $date, 'appt' => $penAppt);
        }

        $errMsgArr = $this->_getStatusMessage(31, 2);

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'appointments' => $finalArr); //,'test'=>$selectAppntsQry,'test1'=>$appointments);
    }

    /*
     * Method name: getPendingAppointments
     * Desc: Get Driver appointments
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function getPendingAppointments($args) {

        if ($args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

//        $curr_date = date('Y-m-d H:i:s', time());
//        $curr_date_bfr_30min = date('Y-m-d H:i:s', time() - 1800);
//        $curr_date_bfr_1hr = date('Y-m-d H:i:s', time() - 3600);


        $selectAppntsQry = "select p.profile_pic,p.first_name,p.phone,p.email,a.appt_lat,a.appt_long,a.appointment_dt,a.extra_notes,a.address_line1,a.address_line2,a.status,a.booking_type from appointment a, slave p ";
        $selectAppntsQry .= " where p.slave_id = a.slave_id and a.status = 1 and a.mas_id = '" . $this->User['entityId'] . "' order by a.appointment_dt DESC"; // and a.appointment_dt >= '" . $curr_date_bfr_1hr . "'

        $selectAppntsRes = mysql_query($selectAppntsQry, $this->db->conn);

        if (mysql_num_rows($selectAppntsRes) <= 0)
            return $this->_getStatusMessage(30, $selectAppntsQry);

        $pending_appt = array();

        while ($appnt = mysql_fetch_assoc($selectAppntsRes)) {

            if ($appnt['profile_pic'] == '')
                $appnt['profile_pic'] = $this->default_profile_pic;

            $pending_appt[] = array('apntDt' => $appnt['appointment_dt'], 'pPic' => $appnt['profile_pic'], 'email' => $appnt['email'],
                'fname' => $appnt['first_name'], 'phone' => $appnt['phone'], 'apntTime' => date('H:i', strtotime($appnt['appointment_dt'])),
                'apntDate' => date('Y-m-d', strtotime($appnt['appointment_dt'])), 'apptLat' => (double) $appnt['appt_lat'], 'apptLong' => (double) $appnt['appt_long'],
                'addrLine1' => urldecode($appnt['address_line1']), 'addrLine2' => urldecode($appnt['address_line2']), 'notes' => $appnt['extra_notes'], 'bookType' => $appnt['booking_type']);
        }


        $errMsgArr = $this->_getStatusMessage(31, 2);

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'appointments' => $pending_appt); //,'test'=>$selectAppntsQry,'test1'=>$appointments);
    }

    /*
     * Method name: getHistoryWith
     * Desc: Get appointment details
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function getHistoryWith($args) {

        if ($args['ent_pas_email'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

        $pageNum = (int) $args['ent_page'];

        if ($args['ent_page'] == '')
            $pageNum = 1;

        $lowerLimit = ($this->historyPageSize * $pageNum) - $this->historyPageSize;
        $upperLimit = $this->historyPageSize * $pageNum;

        $selectAppntsQry = "select a.remarks,a.appointment_dt from appointment a,slave p ";
        $selectAppntsQry .= "where a.slave_id = p.slave_id and a.mas_id = '" . $this->User['entityId'] . "' and p.email = '" . $args['ent_pas_email'] . "' ";
        $selectAppntsQry .= "limit $lowerLimit,$upperLimit";

        $selectAppntsRes = mysql_query($selectAppntsQry, $this->db->conn);

        if (mysql_num_rows($selectAppntsRes) <= 0)
            return $this->_getStatusMessage(32, 12);

        $data = array();

        while ($details = mysql_fetch_assoc($selectAppntsRes)) {
            $data[] = array('apptDt' => $details['appointment_dt'], 'remarks' => $details['remarks']);
        }

        $errMsgArr = $this->_getStatusMessage(33, 2);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'history' => $data);
    }

    /*
     * Method name: fareCalculator
     * Desc: calculates fare for the given pick up to drop off
     * Input: Request data
     * Output: success if got it else error according to the result
     */

    protected function fareCalculator($args) {

        if ($args['ent_type_id'] == '' || $args['ent_from_lat'] == '' || $args['ent_from_long'] == '' || $args['ent_from_lat'] == '' || $args['ent_from_long'] == '' || $args['ent_to_lat'] == '' || $args['ent_to_long'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

//        $arr = array();

        $getTypeDataQry = "select * from workplace_types where type_id = '" . $args['ent_type_id'] . "'";
        $getTypeDataRes = mysql_query($getTypeDataQry, $this->db->conn);

        $cur_to_pick_arr = $this->_getDirectionsData(array('lat' => $args['ent_curr_lat'], 'long' => $args['ent_curr_long']), array('lat' => $args['ent_from_lat'], 'long' => $args['ent_from_long']));

        $cur_to_pick_distance_text = $cur_to_pick_arr['routes'][0]['legs'][0]['distance']['text'];

        $arr = $this->_getDirectionsData(array('lat' => $args['ent_from_lat'], 'long' => $args['ent_from_long']), array('lat' => $args['ent_to_lat'], 'long' => $args['ent_to_long']));

        $distance_in_mtr = $arr['routes'][0]['legs'][0]['distance']['value'];
        $distance_text = $arr['routes'][0]['legs'][0]['distance']['text'];

        $typeData = mysql_fetch_assoc($getTypeDataRes);

        $fare1 = number_format($typeData['basefare'] + (float) (($distance_in_mtr / $this->distanceMetersByUnits) * $typeData['price_per_km']), 2, '.', '');

//        $distance_in_mts = $arr['routes'][0]['legs'][0]['distance']['value'];
//        $dis_in_km = (float) ($distance_in_mts / $this->distanceMetersByUnits);

        $calculatedAmount = $typeData['min_fare']; //(float) $dis_in_km * $typeData['price_per_km'];

        $fare = ($calculatedAmount < $fare1) ? $fare1 : $calculatedAmount;

        $errMsgArr = $this->_getStatusMessage(21, 2);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'dis' => $distance_text, 'fare' => $fare, 'curDis' => $cur_to_pick_distance_text, 't' => $arr, 't1' => $arr);
    }

    /*
     * Method name: liveBooking
     * Desc: Book appointment live in a given slot
     * Input: Request data
     * Output: success if got it else error according to the result
     */

    protected function liveBooking($args) {

        if ($args['ent_wrk_type'] == '' || $args['ent_addr_line1'] == '' || $args['ent_lat'] == '' || $args['ent_long'] == '' ||
                $args['ent_zipcode'] == '' || $args['ent_date_time'] == '' || $args['ent_payment_type'] == '')
            return $this->_getStatusMessage(1, $args);

        $args['ent_appnt_dt'] = $args['ent_date_time'];
        $args['ent_appnt_dt_to'] = date('Y-m-d H:i:s', date('+1 hour', strtotime($args['ent_date_time'])));

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

        $getAmountQry = "select min_fare from workplace_types where type_id = '" . $args['ent_wrk_type'] . "'";
        $typeAmount = mysql_fetch_assoc(mysql_query($getAmountQry, $this->db->conn));

        if (!is_array($typeAmount))
            return $this->_getStatusMessage(38, 38);

        $checkSlaveBookingsQry = "select * from appointment where appointment_dt = '" . (($args['ent_later_dt'] == '') ? $this->curr_date_time : $args['ent_later_dt']) . "' and slave_id = '" . $this->User['entityId'] . "' and status != 10";
        if (mysql_num_rows(mysql_query($checkSlaveBookingsQry, $this->db->conn)) > 0) {
            return $this->_getStatusMessage(124, 2);
        }

        if ($args['ent_later_dt'] != '') {

            $insertAppointmentQry = "insert into appointment(mas_id,slave_id,created_dt,last_modified_dt,status,appointment_dt,address_line1,address_line2,appt_lat,appt_long,drop_addr1,drop_addr2,drop_lat,drop_long,extra_notes,amount,zipcode,user_device,appt_type,payment_type,type_id) 
            values('0','" . $this->User['entityId'] . "','" . $this->curr_date_time . "','" . $this->curr_date_time . "','1',
                '" . $args['ent_later_dt'] . "','" . $args['ent_addr_line1'] . "','" . $args['ent_addr_line2'] . "','" . $args['ent_lat'] . "',
                '" . $args['ent_long'] . "','" . $args['ent_drop_addr_line1'] . "','" . $args['ent_drop_addr_line2'] . "','" . $args['ent_drop_lat'] . "',
                '" . $args['ent_drop_long'] . "','" . $args['ent_extra_notes'] . "','" . $typeAmount['min_fare'] . "','" . $args['ent_zipcode'] . "','" . $args['ent_dev_id'] . "','2','" . $args['ent_payment_type'] . "','" . $args['ent_wrk_type'] . "')";

            mysql_query($insertAppointmentQry, $this->db->conn);

            $pubnubContent1 = array('a' => 12, 'bid' => mysql_insert_id());

            $pushNum['pubnub'] = $this->pubnub->publish(array(
                'channel' => 'dispatcher',
                'message' => $pubnubContent1
            ));

            return $this->_getStatusMessage(78, 78);
        }

        if ($args['ent_dri_email'] == '')
            return $this->_getStatusMessage(1, $args);

        $location = $this->mongo->selectCollection('location');

        $location->ensureIndex(array('location' => '2d'));

        $doc = $location->findOne(array('email' => $args['ent_dri_email']));

        $notifications = $this->mongo->selectCollection('notifications');

        $notifications->insert($args);

        if (count($doc) <= 0)
            return $this->_getStatusMessage(64, 64);

        if ((int) $doc['user'] == 0)
            return $this->_getStatusMessage(64, 64);

        $updateStatus = $this->_updateSlvApptStatus($this->User['entityId'], "1");

        $pushNum = array();

        $master = array("id" => $doc["user"], 'rating' => $doc['rating'], 'fname' => $doc['name'], 'image' => $doc['image'], 'email' => $doc['email'], 'lat' => $doc['location']['latitude'], 'lon' => $doc['location']['longitude'], 'carId' => $doc['carId'], 'chn' => $doc['chn'], 'listner' => $doc['listner'], 'type_id' => $doc['type']);

        if ($doc['inBooking'] == 2)
            return $this->_getStatusMessage(71, $pushNum);

        if ((int) $doc['status'] != 3) {
//do nothing
        } else {

            $checkAppointmentQry = "select * from appointment where appointment_dt = '" . (($args['ent_later_dt'] == '') ? $this->curr_date_time : $args['ent_later_dt']) . "' and mas_id = '" . $master['id'] . "' and status IN (1,2)";
            if (mysql_num_rows(mysql_query($checkAppointmentQry, $this->db->conn)) > 0) {
                $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
                return $this->_getStatusMessage(71, $pushNum);
            }

            $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 2)));

            $insertAppointmentQry = "insert into appointment(mas_id,slave_id,created_dt,last_modified_dt,status,appointment_dt,address_line1,address_line2,appt_lat,appt_long,drop_addr1,drop_addr2,drop_lat,drop_long,extra_notes,amount,zipcode,user_device,appt_type,car_id,payment_type,type_id,coupon_code) 
            values('" . $master['id'] . "','" . $this->User['entityId'] . "','" . $this->curr_date_time . "','" . $this->curr_date_time . "','1',
                '" . (($args['ent_later_dt'] == '') ? $this->curr_date_time : $args['ent_later_dt']) . "','" . $args['ent_addr_line1'] . "','" . $args['ent_addr_line2'] . "','" . $args['ent_lat'] . "',
                '" . $args['ent_long'] . "','" . $args['ent_drop_addr_line1'] . "','" . $args['ent_drop_addr_line2'] . "','" . $args['ent_drop_lat'] . "',
                '" . $args['ent_drop_long'] . "','" . $args['ent_extra_notes'] . "','" . $typeAmount['min_fare'] . "','" . $args['ent_zipcode'] . "','" . $args['ent_dev_id'] . "','" . (($args['ent_later_dt'] == '') ? '1' : '2') . "','" . $master['carId'] . "','" . $args['ent_payment_type'] . "','" . $master['type_id'] . "','" . $args['ent_coupon'] . "')";

            mysql_query($insertAppointmentQry, $this->db->conn);

            $apptId = mysql_insert_id();

            if ($apptId <= 0)
                return $this->_getStatusMessage(3, $insertAppointmentQry);

            if ($args['ent_later_dt'] == '' && $args['ent_addr_line2'] == '') {
                $message = "You got a new job request from " . $this->User['firstName'];
            } else if ($args['ent_later_dt'] == '' && $args['ent_addr_line2'] != '') {
                $exploded = explode(" ", $args['ent_addr_line2']);
                $message = "You got a new job request in " . $exploded[0] . $exploded[1] . " from " . $this->User['firstName'];
            } else if ($args['ent_later_dt'] != '' && $args['ent_addr_line2'] == '') {
                $message = "New Job from " . $this->User['firstName'] . " for " . date('jS M \a\t g:i A', strtotime($args['ent_later_dt']));
            } else if ($args['ent_later_dt'] != '' && $args['ent_addr_line2'] != '') {
                $exploded = explode(" ", $args['ent_addr_line2']);
                $message = "New Job in " . $exploded[0] . $exploded[1] . " from " . $this->User['firstName'] . " for " . date('jS M \a\t g:i A', strtotime($args['ent_later_dt']));
            }

            $this->ios_cert_path = $this->ios_roadyo_driver;
            $this->ios_cert_pwd = $this->ios_dri_pwd;
            $this->androidApiKey = $this->masterApiKey;

            $aplPushContent = array('alert' => $message, 'nt' => (($args['ent_later_dt'] == '') ? '7' : '51'), 'sname' => $this->User['firstName'], 'dt' => (($args['ent_later_dt'] == '') ? $this->curr_date_time : $args['ent_later_dt']), 'e' => $this->User['email'], 'sound' => 'taxina.wav', 'bid' => $apptId);
            $andrPushContent = array("payload" => $message, 'action' => (($args['ent_later_dt'] == '') ? '7' : '51'), 'sname' => $this->User['firstName'], 'dt' => (($args['ent_later_dt'] == '') ? $this->curr_date_time : $args['ent_later_dt']), 'e' => $this->User['email'], 'bid' => $apptId);

            $pubnubContent = array('a' => 11, 'dt' => (($args['ent_later_dt'] == '') ? $this->curr_date_time : $args['ent_later_dt']), 'e' => $this->User['email'], 'bid' => $apptId, 'nt' => (($args['ent_later_dt'] == '') ? '' : '51'));

            $pushNum['pubnub'] = $this->pubnub->publish(array(
                'channel' => 'dispatcher',
                'message' => $pubnubContent
            ));

            if (!is_null($master['listner']))
                $pushNum['pubnub'] = $this->pubnub->publish(array(
                    'channel' => $master['listner'],
                    'message' => $pubnubContent
                ));

            $pushNum['push'] = $this->_sendPush($this->User['entityId'], array($master['id']), $message, '7', $this->User['firstName'], $this->curr_date_time, '1', $aplPushContent, $andrPushContent);

            for ($j = 1; $j < 40; $j++) {
                if ($j < 40)
                    usleep(500000);
                $getStatus = $this->_getSlvApptStatus($this->User['entityId']);

                if ($getStatus['booking_status'] == '3') {

                    mysql_query("update appointment set status = '4', cancel_status = '1', cancel_dt = '" . $this->curr_date_time . "' where appointment_id = '" . $apptId . "'", $this->db->conn);

                    $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
                    $update = $this->_updateSlvApptStatus($this->User['entityId'], "0");
                    return $this->_getStatusMessage(74, $update);
                }

                $statusCheckQry = "select status from appointment where appointment_id = '" . $apptId . "'";
                $statusArr = mysql_fetch_assoc(mysql_query($statusCheckQry, $this->db->conn));

                if ($j == 39 && $statusArr['status'] == '1')
                    mysql_query("update appointment set status = '10' where appointment_id = '" . $apptId . "'", $this->db->conn);


                if ($statusArr['status'] == '6' || $statusArr['status'] == '2' || $statusArr['status'] == '7') {

                    if ($args['ent_coupon'] != '') {
                        $updateCouponStatusQry = "update coupons set status = 1 where coupon_code = '" . $args['ent_coupon'] . "'";
                        mysql_query($updateCouponStatusQry, $this->db->conn);
                    }

                    $location->update(array('user' => (int) $master['id']), array('$set' => array('status' => ($args['ent_later_dt'] == '') ? 5 : 3, 'inBooking' => 1)));

                    $getVehicleDataQry = "select wrk.workplace_id, wrk.License_Plate_No, (select v.vehiclemodel from vehiclemodel v, workplace w where w.Vehicle_Model = v.id and w.workplace_id = wrk.workplace_id) as vehicle_model from workplace wrk, master m where m.workplace_id = wrk.workplace_id and m.mas_id = '" . $master['id'] . "'";

                    $getVehicleDataRes = mysql_query($getVehicleDataQry, $this->db->conn);

                    $vehicleData = mysql_fetch_assoc($getVehicleDataRes);

                    $errMsgArr = $this->_getStatusMessage(($args['ent_later_dt'] == '') ? 39 : 78, $pushNum);

                    return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'email' => $master['email'], 'apptDt' => $this->curr_date_time, 'dt' => str_replace(' ', '', str_replace('-', '', str_replace(':', '', $this->curr_date_time))), 'model' => $vehicleData['vehicle_model'], 'plateNo' => $vehicleData['License_Plate_No'], 'rating' => round($master['rating'], 1), 't' => $pushNum, 'chn' => $master['chn'], 'bid' => $apptId);
                }

                if ($statusArr['status'] == '3') {
                    $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
                    return $this->_getStatusMessage(71, $pushNum);
                }
            }
        }
        $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
        return $this->_getStatusMessage(71, $pushNum);
    }

    /*
     * Method name: liveBooking
     * Desc: Book appointment live in a given slot
     * Input: Request data
     * Output: success if got it else error according to the result
     */

    protected function phoneBooking($args) {

        if ($args['ent_dri_email'] == '' || $args['ent_wrk_type'] == '' || $args['ent_addr_line1'] == '' || $args['ent_lat'] == '' || $args['ent_long'] == '' ||
                $args['ent_zipcode'] == '' || $args['ent_date_time'] == '' || $args['ent_payment_type'] == '')
            return $this->_getStatusMessage(1, $args);

        $args['ent_appnt_dt'] = $args['ent_date_time'];
        $args['ent_appnt_dt_to'] = date('Y-m-d H:i:s', date('+1 hour', strtotime($args['ent_date_time'])));

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

        $getAmountQry = "select min_fare from workplace_types where type_id = '" . $args['ent_wrk_type'] . "'";
        $typeAmount = mysql_fetch_assoc(mysql_query($getAmountQry, $this->db->conn));

        if (!is_array($typeAmount))
            return $this->_getStatusMessage(38, 38);

        $getDetQry = "select pat.slave_id,pat.first_name,pat.last_name,pat.profile_pic,pat.email,pat.stripe_id,pat.phone,pat.status as mobile from slave pat where slave_id = '" . $args['ent_slave_id'] . "'"; // and us.loggedIn = 1
        $getDetRes = mysql_query($getDetQry, $this->db->conn);

        if (mysql_num_rows($getDetRes) <= 0)
            return $this->_getStatusMessage(64, 64);

        $sessDet = mysql_fetch_assoc($getDetRes);

        $this->User = array('entityId' => $sessDet['slave_id'], 'firstName' => $sessDet['first_name'], 'last_name' => $sessDet['last_name'], 'pPic' => $sessDet['profile_pic'], 'email' => $sessDet['email'], 'stripe_id' => $sessDet['stripe_id'], 'mobile' => $sessDet['mobile'], 'workplaceId' => $sessDet['workplace_id']);

        $location = $this->mongo->selectCollection('location');

        $location->ensureIndex(array('location' => '2d'));

        $doc = $location->findOne(array('email' => $args['ent_dri_email']));

        if (count($doc) <= 0)
            return $this->_getStatusMessage(64, 64);

        if ((int) $doc['user'] == 0)
            return $this->_getStatusMessage(64, 64);

        $updateStatus = $this->_updateSlvApptStatus($this->User['entityId'], "1");

        $pushNum = array();

        $master = array("id" => $doc["user"], 'rating' => $doc['rating'], 'fname' => $doc['name'], 'image' => $doc['image'], 'email' => $doc['email'], 'lat' => $doc['location']['latitude'], 'lon' => $doc['location']['longitude'], 'carId' => $doc['carId'], 'chn' => $doc['chn'], 'listner' => $doc['listner'], 'type_id' => $doc['type']);

        if ($doc['inBooking'] == 2)
            return $this->_getStatusMessage(71, $pushNum);

        if ((int) $doc['status'] != 3) {
//do nothing
        } else {

            $checkAppointmentQry = "select * from appointment where appointment_dt = '" . (($args['ent_later_dt'] == '') ? $this->curr_date_time : $args['ent_later_dt']) . "' and mas_id = '" . $master['id'] . "' and status IN (1,2)";
            if (mysql_num_rows(mysql_query($checkAppointmentQry, $this->db->conn)) > 0) {
                $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
                return $this->_getStatusMessage(71, $pushNum);
            }

            $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 2)));

            $insertAppointmentQry = "insert into appointment(mas_id,slave_id,created_dt,last_modified_dt,status,appointment_dt,address_line1,address_line2,appt_lat,appt_long,drop_addr1,drop_addr2,drop_lat,drop_long,extra_notes,amount,zipcode,user_device,appt_type,car_id,payment_type,type_id,coupon_code) 
            values('" . $master['id'] . "','" . $this->User['entityId'] . "','" . $this->curr_date_time . "','" . $this->curr_date_time . "','1',
                '" . (($args['ent_later_dt'] == '') ? $this->curr_date_time : $args['ent_later_dt']) . "','" . $args['ent_addr_line1'] . "','" . $args['ent_addr_line2'] . "','" . $args['ent_lat'] . "',
                '" . $args['ent_long'] . "','" . $args['ent_drop_addr_line1'] . "','" . $args['ent_drop_addr_line2'] . "','" . $args['ent_drop_lat'] . "',
                '" . $args['ent_drop_long'] . "','" . $args['ent_extra_notes'] . "','" . $typeAmount['min_fare'] . "','" . $args['ent_zipcode'] . "','" . $args['ent_dev_id'] . "','" . (($args['ent_later_dt'] == '') ? '1' : '2') . "','" . $master['carId'] . "','" . $args['ent_payment_type'] . "','" . $master['type_id'] . "','" . $args['ent_coupon'] . "')";

            mysql_query($insertAppointmentQry, $this->db->conn);

            $apptId = mysql_insert_id();

            if ($apptId <= 0)
                return $this->_getStatusMessage(3, $insertAppointmentQry);

            if ($args['ent_later_dt'] == '' && $args['ent_addr_line2'] == '') {
                $message = "You got a new job request from " . $this->User['firstName'];
            } else if ($args['ent_later_dt'] == '' && $args['ent_addr_line2'] != '') {
                $exploded = explode(" ", $args['ent_addr_line2']);
                $message = "You got a new job request in " . $exploded[0] . $exploded[1] . " from " . $this->User['firstName'];
            } else if ($args['ent_later_dt'] != '' && $args['ent_addr_line2'] == '') {
                $message = "New Job from " . $this->User['firstName'] . " for " . date('jS M \a\t g:i A', strtotime($args['ent_later_dt']));
            } else if ($args['ent_later_dt'] != '' && $args['ent_addr_line2'] != '') {
                $exploded = explode(" ", $args['ent_addr_line2']);
                $message = "New Job in " . $exploded[0] . $exploded[1] . " from " . $this->User['firstName'] . " for " . date('jS M \a\t g:i A', strtotime($args['ent_later_dt']));
            }

            $this->ios_cert_path = $this->ios_roadyo_driver;
            $this->ios_cert_pwd = $this->ios_dri_pwd;
            $this->androidApiKey = $this->masterApiKey;

            $aplPushContent = array('alert' => $message, 'nt' => (($args['ent_later_dt'] == '') ? '7' : '51'), 'sname' => $this->User['firstName'], 'dt' => (($args['ent_later_dt'] == '') ? $this->curr_date_time : $args['ent_later_dt']), 'e' => $this->User['email'], 'sound' => 'taxina.wav', 'bid' => $apptId);
            $andrPushContent = array("payload" => $message, 'action' => (($args['ent_later_dt'] == '') ? '7' : '51'), 'sname' => $this->User['firstName'], 'dt' => (($args['ent_later_dt'] == '') ? $this->curr_date_time : $args['ent_later_dt']), 'e' => $this->User['email'], 'bid' => $apptId);

            $pubnubContent = array('a' => 11, 'dt' => (($args['ent_later_dt'] == '') ? $this->curr_date_time : $args['ent_later_dt']), 'e' => $this->User['email'], 'bid' => $apptId, 'nt' => (($args['ent_later_dt'] == '') ? '' : '51'));

            $pushNum['pubnub'] = $this->pubnub->publish(array(
                'channel' => 'dispatcher',
                'message' => $pubnubContent
            ));

            if (!is_null($master['listner']))
                $pushNum['pubnub'] = $this->pubnub->publish(array(
                    'channel' => $master['listner'],
                    'message' => $pubnubContent
                ));

            $pushNum['push'] = $this->_sendPush($this->User['entityId'], array($master['id']), $message, '7', $this->User['firstName'], $this->curr_date_time, '1', $aplPushContent, $andrPushContent);

            for ($j = 1; $j < 40; $j++) {
                if ($j < 40)
                    usleep(500000);
                $getStatus = $this->_getSlvApptStatus($this->User['entityId']);

                if ($getStatus['booking_status'] == '3') {

                    mysql_query("update appointment set status = '4', cancel_status = '1', cancel_dt = '" . $this->curr_date_time . "' where appointment_id = '" . $apptId . "'", $this->db->conn);

                    $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
                    $update = $this->_updateSlvApptStatus($this->User['entityId'], "0");
                    return $this->_getStatusMessage(74, $update);
                }

                $statusCheckQry = "select status from appointment where appointment_id = '" . $apptId . "'";
                $statusArr = mysql_fetch_assoc(mysql_query($statusCheckQry, $this->db->conn));

                if ($j == 39 && $statusArr['status'] == '1')
                    mysql_query("update appointment set status = '10' where appointment_id = '" . $apptId . "'", $this->db->conn);


                if ($statusArr['status'] == '6' || $statusArr['status'] == '2' || $statusArr['status'] == '7') {

                    if ($args['ent_coupon'] != '') {
                        $updateCouponStatusQry = "update coupons set status = 1 where coupon_code = '" . $args['ent_coupon'] . "'";
                        mysql_query($updateCouponStatusQry, $this->db->conn);
                    }

                    $location->update(array('user' => (int) $master['id']), array('$set' => array('status' => ($args['ent_later_dt'] == '') ? 5 : 3, 'inBooking' => 1)));

                    $getVehicleDataQry = "select wrk.workplace_id, wrk.License_Plate_No, (select v.vehiclemodel from vehiclemodel v, workplace w where w.Vehicle_Model = v.id and w.workplace_id = wrk.workplace_id) as vehicle_model from workplace wrk, master m where m.workplace_id = wrk.workplace_id and m.mas_id = '" . $master['id'] . "'";

                    $getVehicleDataRes = mysql_query($getVehicleDataQry, $this->db->conn);

                    $vehicleData = mysql_fetch_assoc($getVehicleDataRes);

                    $errMsgArr = $this->_getStatusMessage(($args['ent_later_dt'] == '') ? 39 : 78, $pushNum);

                    return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'email' => $master['email'], 'apptDt' => $this->curr_date_time, 'dt' => str_replace(' ', '', str_replace('-', '', str_replace(':', '', $this->curr_date_time))), 'model' => $vehicleData['vehicle_model'], 'plateNo' => $vehicleData['License_Plate_No'], 'rating' => round($master['rating'], 1), 't' => $pushNum, 'chn' => $master['chn'], 'bid' => $apptId);
                }

                if ($statusArr['status'] == '3') {
                    $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
                    return $this->_getStatusMessage(71, $pushNum);
                }
            }
        }
        $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
        return $this->_getStatusMessage(71, $pushNum);
    }

    /*
     * Method name: liveBooking
     * Desc: Book appointment live in a given slot
     * Input: Request data
     * Output: success if got it else error according to the result
     */

    protected function dispatchJob($args) {

        if ($args['ent_mas_id'] == '' || $args['ent_appointment_id'] == '')
            return $this->_getStatusMessage(1, $args);

        $checkAppointmentQry = "select a.*,p.* from appointment a,slave p where a.slave_id = p.slave_id and a.appointment_id = '" . $args['ent_appointment_id'] . "'";

        $checkAppointmentRes = mysql_query($checkAppointmentQry, $this->db->conn);

        if (mysql_num_rows($checkAppointmentRes) <= 0)
            return $this->_getStatusMessage(71, 1);

        $apptId = $args['ent_appointment_id'];

        $apptDetails = mysql_fetch_assoc($checkAppointmentRes);

        $location = $this->mongo->selectCollection('location');

        $location->ensureIndex(array('location' => '2d'));

        $doc = $location->findOne(array('user' => (int) $args['ent_mas_id']));

        if (count($doc) <= 0)
            return $this->_getStatusMessage(64, 64);

        $updateQry = "update appointment set mas_id = '" . $args['ent_mas_id'] . "' where appointment_id = '" . $apptId . "'";
        mysql_query($updateQry, $this->db->conn);

        if (mysql_affected_rows() < 0)
            return $this->_getStatusMessage(3, $updateQry);

        $pushNum = array();

        $master = array("id" => $doc["user"], 'rating' => $doc['rating'], 'fname' => $doc['name'], 'image' => $doc['image'], 'email' => $doc['email'], 'lat' => $doc['location']['latitude'], 'lon' => $doc['location']['longitude'], 'carId' => $doc['carId'], 'chn' => $doc['chn'], 'listner' => $doc['listner'], 'type_id' => $doc['type']);

        if ($doc['inBooking'] == 2)
            return $this->_getStatusMessage(71, $pushNum);

        if ((int) $doc['status'] != 3) {
//do nothing
        } else {

            $checkAppointmentQry = "select * from appointment where appointment_dt = '" . $apptDetails['appointment_dt'] . "' and mas_id = '" . $master['id'] . "' and status = 2";
            if (mysql_num_rows(mysql_query($checkAppointmentQry, $this->db->conn)) > 0) {
                $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
                return $this->_getStatusMessage(71, $pushNum);
            }

            $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 2)));

            if ($apptId <= 0)
                return $this->_getStatusMessage(3, $insertAppointmentQry);

            if ($args['ent_addr_line2'] == '') {
                $message = "New Job from " . $apptDetails['first_name'] . " for " . date('jS M \a\t g:i A', strtotime($apptDetails['appointment_dt']));
            } else {
                $exploded = explode(" ", $args['ent_addr_line2']);
                $message = "New Job in " . $exploded[0] . $exploded[1] . " from " . $apptDetails['first_name'] . " for " . date('jS M \a\t g:i A', strtotime($apptDetails['appointment_dt']));
            }

            $this->ios_cert_path = $this->ios_roadyo_driver;
            $this->ios_cert_pwd = $this->ios_dri_pwd;
            $this->androidApiKey = $this->masterApiKey;

            $aplPushContent = array('alert' => $message, 'nt' => 51, 'sname' => $apptDetails['first_name'], 'dt' => $apptDetails['appointment_dt'], 'e' => $apptDetails['email'], 'sound' => 'taxina.wav', 'bid' => $apptId);
            $andrPushContent = array("payload" => $message, 'action' => 51, 'sname' => $apptDetails['first_name'], 'dt' => $apptDetails['appointment_dt'], 'e' => $apptDetails['email'], 'bid' => $apptId);

            $pubnubContent = array('a' => 11, 'dt' => $apptDetails['appointment_dt'], 'e' => $apptDetails['email'], 'bid' => $apptId, 'nt' => 51);

            if (!is_null($master['listner']))
                $pushNum['pubnub'] = $this->pubnub->publish(array(
                    'channel' => $master['listner'],
                    'message' => $pubnubContent
                ));

            $pushNum['push'] = $this->_sendPush('0001', array($master['id']), $message, '7', $apptDetails['first_name'], $apptDetails['appointment_id'], '1', $aplPushContent, $andrPushContent);

            for ($j = 1; $j < 40; $j++) {
                if ($j < 40)
                    usleep(500000);

                $statusCheckQry = "select status from appointment where appointment_id = '" . $apptId . "'";
                $statusArr = mysql_fetch_assoc(mysql_query($statusCheckQry, $this->db->conn));

                if ($statusArr['status'] == '4') {
                    $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
                    return $this->_getStatusMessage(74, $update);
                }

                if ($j == 39 && $statusArr['status'] == '1')
                    mysql_query("update appointment set status = '1',mas_id = 0 where appointment_id = '" . $apptId . "'", $this->db->conn);

                if ($statusArr['status'] == '6' || $statusArr['status'] == '2' || $statusArr['status'] == '7') {
                    $this->ios_cert_path = $this->ios_roadyo_pas;
                    $this->ios_cert_pwd = $this->ios_pas_pwd;
                    $this->androidApiKey = $this->slaveApiKey;

                    $message = 'Driver named ' . $master['fname'] . ' will pick you up at ' . date('h:i a, d M', strtotime($apptDetails['appointment_dt'])) . '.';

                    $aplPushContent = array('alert' => $message, 't' => '2', 'nt' => '5', 'e' => $apptDetails['email'], 'd' => $apptDetails['appointment_dt'], 'sound' => 'default'); //, 'n' => $this->User['firstName'] . ' ' . $this->User['last_name']//, 'pic' => $this->User['pPic'], 'ph' => $this->User['mobile']//, 'id' => $apptDet['appointment_id']
                    $andrPushContent = array("payload" => $message, 't' => '2', 'action' => '5', 'dt' => $apptDetails['appointment_dt'], 'id' => $apptDetails['appointment_id']);

                    $push['push'] = $this->_sendPush('0', array($apptDetails['slave_id']), $message, '5', $apptDetails['email'], $this->curr_date_time, '2', $aplPushContent, $andrPushContent);

                    $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
                    return $this->_getStatusMessage(39, $pushNum);
                }

                if ($statusArr['status'] == '3') {
                    mysql_query("update appointment set status = '1',mas_id = 0 where appointment_id = '" . $apptId . "'", $this->db->conn);
                    $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
                    return $this->_getStatusMessage(71, $pushNum);
                }
            }
        }
        mysql_query("update appointment set status = '1',mas_id = 0 where appointment_id = '" . $apptId . "'", $this->db->conn);
        $location->update(array('user' => (int) $master['id']), array('$set' => array('inBooking' => 1)));
        return $this->_getStatusMessage(71, $pushNum);
    }

    /*
     * Method name: getAppointmentDetails
     * Desc: Get appointment details of a given slot
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function getAppointmentDetails($args) {

        if ($args['ent_appnt_dt'] == '' || $args['ent_email'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, $args);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        if ($args['ent_user_type'] == '')
            $args['ent_user_type'] = '2';

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], $args['ent_user_type']);

        if (is_array($returned))
            return $returned;

        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

        $docDet = $this->_getEntityDet($args['ent_email'], ($args['ent_user_type'] == '1') ? '2' : '1');

        if (!is_array($docDet))
            return $this->_getStatusMessage(37, 37);

        if ($args['ent_user_type'] == '2') {
            $selectAppntsQry = "select a.coupon_code,a.discount,a.tip_amount,a.tip_percent,a.waiting_mts,a.start_dt,a.meter_fee,a.toll_fee,a.airport_fee,a.parking_fee,a.apprxAmt, a.distance_in_mts, a.payment_type, a.payment_status, a.status, a.amount, a.address_line1, a.address_line2, a.drop_addr1, a.drop_addr2, a.duration, a.appt_lat, a.appt_long, a.drop_lat, a.arrive_dt, a.complete_dt, a.drop_long, a.appointment_id, a.appt_type, a.mas_id, d.profile_pic, d.mobile, d.first_name, d.last_name, d.email, ";
            $selectAppntsQry .= "(select License_Plate_No from workplace where workplace_id = a.car_id) as licencePlate, ";
            $selectAppntsQry .= "(select report_msg from reports where appointment_id = a.appointment_id limit 0, 1) as report_msg, ";
            $selectAppntsQry .= "(select v.vehiclemodel from vehiclemodel v, workplace w where w.Vehicle_Model = v.id and w.workplace_id = a.car_id) as vehicle_model, ";
            $selectAppntsQry .= "(select wt.price_per_km from workplace_types wt, workplace w where w.type_id = wt.type_id and w.workplace_id = a.car_id) as price_per_km from appointment a, master d ";
            $selectAppntsQry .= " where a.mas_id = d.mas_id and a.appointment_dt = '" . $args['ent_appnt_dt'] . "' and d.email = '" . $args['ent_email'] . "' and a.status != 10 order by a.appointment_id DESC"; // and a.status IN (2,5,6,7)

            list($date, $time) = explode(' ', $args['ent_appnt_dt']);
            list($year, $month, $day) = explode('-', $date);
            list($hour, $minute, $second) = explode(':', $time);

            $dateNumber = $year . $month . $day . $hour . $minute . $second;
        } else {
            $selectAppntsQry = "select a.coupon_code,a.discount,a.tip_amount,a.tip_percent,a.waiting_mts,a.start_dt,a.meter_fee,a.toll_fee,a.airport_fee,a.parking_fee,a.apprxAmt, a.distance_in_mts, a.payment_type, a.payment_status, a.status, a.amount, a.address_line1, a.address_line2, a.drop_addr1, a.drop_addr2, a.duration, a.appt_lat, a.appt_long, a.drop_lat, a.drop_long, a.arrive_dt, a.complete_dt, a.appointment_id, a.appt_type, a.user_device, a.mas_id, s.profile_pic, s.phone as mobile, s.first_name, s.last_name, s.email, ";
            $selectAppntsQry .= "(select report_msg from reports where appointment_id = a.appointment_id limit 0, 1) as report_msg, ";
            $selectAppntsQry .= "(select rating from passenger_rating where appointment_id = a.appointment_id limit 0, 1) as rating, ";
            $selectAppntsQry .= "(select wt.price_per_km from workplace_types wt, workplace w, master d where w.type_id = wt.type_id and w.workplace_id = d.workplace_id and d.mas_id = a.mas_id) as price_per_km ";
            $selectAppntsQry .= " from appointment a, slave s where a.slave_id = s.slave_id and a.slave_id = '" . $docDet['slave_id'] . "' and a.appointment_dt = '" . $args['ent_appnt_dt'] . "' and a.mas_id = '" . $this->User['entityId'] . "' and a.status != 10 order by a.appointment_id DESC "; // and a.status NOT IN (3,8)
        }
        $selectAppntsRes = mysql_query($selectAppntsQry, $this->db->conn);

        if (mysql_num_rows($selectAppntsRes) <= 0)
            return $this->_getStatusMessage(62, $selectAppntsQry);

        $apptData = mysql_fetch_assoc($selectAppntsRes);

        if ($apptData['status'] == '10')
            return $this->_getStatusMessage(72, 72);

        if ($apptData['status'] == '3' && $args['ent_user_type'] == '1')
            return $this->_getStatusMessage(104, 72);
        /*
          if ($apptData['status'] == '9') {

          $arr = $this->_getDirectionsData(array('lat' => $apptData['appt_lat'], 'long' => $apptData['appt_long']), array('lat' => $apptData['drop_lat'], 'long' => $apptData['drop_long']));

          $distance_in_mts = $arr['routes'][0]['legs'][0]['distance']['value'];

          $dis_in_km = (float) ($distance_in_mts / $this->distanceMetersByUnits);

          $dis_in_miles = (float) ($distance_in_mts / $this->distanceMetersByUnits);

          $calculatedAmount = (float) $dis_in_km * $apptData['price_per_km'];
          $fare = ($calculatedAmount < $apptData['amount']) ? $apptData['amount'] : $calculatedAmount;
          $fare = $apptData['amount'];
          } else {
          $fare = $apptData['amount'];

          $distance_in_mts = 0;

          $dis_in_miles = (float) ($distance_in_mts / $this->distanceMetersByUnits);
          $avgSpeedKmHour = 0;
          }
         */

        $avgSpeedKmHour = ($apptData['distance_in_mts'] / ($apptData['duration'] * 60)) * 3.6;
        $dis_in_miles = (float) ($apptData['distance_in_mts'] / $this->distanceMetersByUnits);

        $errMsgArr = $this->_getStatusMessage(21, 2);

        $location = $this->mongo->selectCollection('location');
        $masterData = $location->findOne(array('user' => (int) $apptData['mas_id']));

        if ($args['ent_user_type'] == '2') {

            if ($apptData['status'] == '4' && $apptData['payment_status'] == '' && $apptData['cancel_status'] == '3')
                $payStatus = 0;
            else if ($apptData['status'] == '9' && ($apptData['payment_status'] == '' || $apptData['payment_status'] == '2'))
                $payStatus = 0;
            else
                $payStatus = 1;

            return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'code' => $apptData['coupon_code'], 'tip' => $apptData['tip_amount'], 'waitTime' => $apptData['waiting_mts'], 'statCode' => $apptData['status'], 'meterFee' => $apptData['meter_fee'], 'tollFee' => $apptData['toll_fee'], 'airportFee' => $apptData['airport_fee'], 'parkingFee' => $apptData['parking_fee'], 'fName' => $apptData['first_name'], 'lName' => $apptData['last_name'], 'mobile' => $apptData['mobile'], 'addr1' => urldecode($apptData['address_line1']), 'addr2' => urldecode($apptData['address_line2']), 'dropAddr1' => urldecode($apptData['drop_addr1']), 'dropAddr2' => urldecode($apptData['drop_addr2']), 'amount' => number_format($apptData['amount'], 2, '.', ''), 'pPic' => ($apptData['profile_pic'] == '') ? $this->default_profile_pic : $apptData['profile_pic'], 'dis' => round($dis_in_miles, 2), 'dur' => $apptData['duration'], 'fare' => ($apptData['meter_fee'] + $apptData['toll_fee'] + $apptData['parking_fee'] + $apptData['airport_fee'] + $apptData['tip_fee']), 'pickLat' => $apptData['appt_lat'], 'pickLong' => $apptData['appt_long'], 'ltg' => $masterData['location']['latitude'] . ',' . $masterData['location']['longitude'], 'dropLat' => $apptData['drop_lat'], 'dropLong' => $apptData['drop_long'], 'apptDt' => $args['ent_appnt_dt'], 'pickupDt' => $apptData['start_dt'], 'dropDt' => $apptData['complete_dt'], 'discount' => '0.00', 'email' => $apptData['email'], 'dt' => $dateNumber, 'bid' => $apptData['appointment_id'], 'apptType' => $apptData['appt_type'], 'chn' => $masterData['chn'], 'plateNo' => $apptData['licencePlate'], 'model' => $apptData['vehicle_model'], 'payStatus' => $payStatus, 'reportMsg' => $apptData['report_msg'], 'payType' => $apptData['payment_type'], 'avgSpeed' => $avgSpeedKmHour, 'share' => $this->share . $apptData['appointment_id'], 'discount' => $apptData['discount']);
        } else {

            $arrCP = $this->_getDirectionsData(array('lat' => $masterData['location']['latitude'], 'long' => $masterData['location']['longitude']), array('lat' => $apptData['appt_lat'], 'long' => $apptData['appt_long']));

            $curr_to_pick_dis_in_km = round((float) $arrCP['routes'][0]['legs'][0]['distance']['value'] / $this->distanceMetersByUnits, 2);

            return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'data' => array('rating' => (float) $apptData['rating'], 'code' => $apptData['coupon_code'], 'discount' => $apptData['discount'], 'tip' => $apptData['tip_amount'], 'tipPercent' => $apptData['tip_percent'], 'waitTime' => $apptData['waiting_mts'], 'statCode' => $apptData['status'], 'meterFee' => $apptData['meter_fee'], 'tollFee' => $apptData['toll_fee'], 'airportFee' => $apptData['airport_fee'], 'parkingFee' => $apptData['parking_fee'], 'fName' => $apptData['first_name'], 'lName' => $apptData['last_name'], 'mobile' => $apptData['mobile'], 'addr1' => urldecode($apptData['address_line1']), 'addr2' => urldecode($apptData['address_line2']), 'dropAddr1' => urldecode($apptData['drop_addr1']), 'dropAddr2' => urldecode($apptData['drop_addr2']), 'amount' => number_format($apptData['amount'], 2, '.', ''), 'pPic' => ($apptData['profile_pic'] == '') ? $this->default_profile_pic : $apptData['profile_pic'], 'apptDis' => $curr_to_pick_dis_in_km, 'dis' => round($dis_in_miles, 2), 'dur' => $apptData['duration'], 'fare' => ($apptData['meter_fee'] + $apptData['toll_fee'] + $apptData['parking_fee'] + $apptData['airport_fee'] + $apptData['tip_fee']), 'pickLat' => $apptData['appt_lat'], 'pickLong' => $apptData['appt_long'], 'dropLat' => $apptData['drop_lat'], 'dropLong' => $apptData['drop_long'], 'apptDt' => $args['ent_appnt_dt'], 'pickupDt' => $apptData['start_dt'], 'dropDt' => $apptData['complete_dt'], 'email' => $apptData['email'], 'discount' => '0.00', 'apptType' => $apptData['appt_type'], 'bid' => $apptData['appointment_id'], 'pasChn' => 'qp_' . $apptData['user_device'], 'payStatus' => ($apptData['payment_status'] == '') ? 0 : $apptData['payment_status'], 'reportMsg' => $apptData['report_msg'], 'payType' => $apptData['payment_type'], 'avgSpeed' => $avgSpeedKmHour, 'apprAmount' => $apptData['apprxAmt']));
        }
    }

    /*
     * Method name: updateSlaveReview
     * Desc: Update appointment review of an appointment
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function updateSlaveReview($args) {

        if ($args['ent_appnt_dt'] == '' || $args['ent_dri_email'] == '' || $args['ent_date_time'] == '' || $args['ent_rating_num'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

        $masDet = $this->_getEntityDet($args['ent_dri_email'], '1');

        if (!is_array($masDet))
            return $this->_getStatusMessage(37, 37);

        $selectApptQry = "select appointment_id from appointment where slave_id = '" . $this->User['entityId'] . "' and mas_id = '" . $masDet['mas_id'] . "' and appointment_dt = '" . $args['ent_appnt_dt'] . "'";
        $selectApptRes = mysql_query($selectApptQry, $this->db->conn);

        if (mysql_num_rows($selectApptRes) <= 0)
            return $this->_getStatusMessage(62, 62);

        $appt = mysql_fetch_assoc($selectApptRes);

        $insertReviewQry = "insert into master_ratings(mas_id, slave_id, review_dt, star_rating, review, appointment_id) values('" . $masDet['mas_id'] . "', '" . $this->User['entityId'] . "', '" . $this->curr_date_time . "', '" . $args['ent_rating_num'] . "', '" . $args['ent_review_msg'] . "', '" . $appt['appointment_id'] . "')";
        mysql_query($insertReviewQry, $this->db->conn);

        $selectAvgRatQry = "select avg(star_rating) as avg from master_ratings where mas_id = '" . $masDet['mas_id'] . "' and status = 1";
        $selectAvgRatRes = mysql_query($selectAvgRatQry, $this->db->conn);

        $avgRow = mysql_fetch_assoc($selectAvgRatRes);

        if ($args['ent_fav'] == '0') {
            $favourite = $this->mongo->selectCollection('favourite');
            $insertData = array('passenger' => (int) $this->User['entityId'], 'driver' => (int) $masDet['mas_id'], 'pasEmail' => $this->User['email']);
            if (!is_array($favourite->findOne($insertData)))
                $favourite->insert($insertData);
        }

        $location = $this->mongo->selectCollection('location');

        $location->update(array('user' => (int) $masDet['mas_id']), array('$set' => array('rating' => (float) $avgRow['avg'])));

//        if (mysql_affected_rows($insertReviewRes) > 0)
        return $this->_getStatusMessage(63, 12);
//        else
//            return $this->_getStatusMessage(3, $insertReviewQry);
    }

    /*
     * Method name: getSlaveAppointments
     * Desc: Get Passenger appointments
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function getSlaveAppointments($args) {

        if ($args['ent_appnt_dt'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

        $dates = explode('-', $args['ent_appnt_dt']);

        $args['ent_appnt_dt'] = $args['ent_appnt_dt'] . '-01';
        $endDate = date('Y-m-d', strtotime('+1 month', strtotime($args['ent_appnt_dt'])));
        $selectStr = " YEAR(a.appointment_dt) = '" . $dates[0] . "' and MONTH(a.appointment_dt) = '" . $dates[1] . "'";

        $selectAppntsQry = "select d.profile_pic, d.first_name, d.mobile, d.email, a.appt_lat, a.appt_long, a.appointment_dt, a.amount, a.extra_notes, a.address_line1, a.payment_status, a.address_line2, a.drop_addr1, a.drop_addr2, a.status, a.distance_in_mts, a.appt_type, (select count(appointment_id) from appointment where status = 1 and slave_id = '" . $this->User['entityId'] . "') as pen_count from appointment a, master d ";
        $selectAppntsQry .= " where d.mas_id = a.mas_id and a.slave_id = '" . $this->User['entityId'] . "' and " . $selectStr . " and ((a.status in (4,5,9) and a.appt_type = 1) or ((a.status NOT in (3,10) and a.appt_type = 2)) ) order by a.appointment_dt DESC"; // and a.appointment_dt >= '" . $curr_date_bfr_1hr . "'//a.status NOT in (3,4,7) 

        $selectAppntsRes = mysql_query($selectAppntsQry, $this->db->conn);

        if (mysql_num_rows($selectAppntsRes) <= 0)
            return $this->_getStatusMessage(65, $selectAppntsQry);

        $appointments = $daysArr = $sortedApnts = array();

        $pendingCount = 0;

        while ($appnt = mysql_fetch_assoc($selectAppntsRes)) {

            if ($appnt['profile_pic'] == '')
                $appnt['profile_pic'] = $this->default_profile_pic;

            $pendingCount = $appnt['pen_count'];

            $aptdate = date('Y-m-d', strtotime($appnt['appointment_dt']));

            if ($appnt['status'] == '1')
                $status = 'Booking requested';
            else if ($appnt['status'] == '2')
                $status = 'Driver accepted.';
            else if ($appnt['status'] == '3')
                $status = 'Driver rejected.';
            else if ($appnt['status'] == '4')
                $status = 'You have cancelled.';
            else if ($appnt['status'] == '5')
                $status = 'Driver have cancelled.';
            else if ($appnt['status'] == '6')
                $status = 'Driver is on the way.';
            else if ($appnt['status'] == '7')
                $status = 'Driver arrived.';
            else if ($appnt['status'] == '8')
                $status = 'Booking started.';
            else if ($appnt['status'] == '9' && $appnt['payment_status'] == '')
                $status = 'Completed, Payment not done.';
            else if ($appnt['status'] == '9' && ($appnt['payment_status'] == '1' || $appnt['payment_status'] == '3'))
                $status = 'Completed, Payment done.';
            else if ($appnt['status'] == '9' && $appnt['payment_status'] == '2')
                $status = 'Completed, Payment done.';
            else if ($appnt['status'] == '10')
                $status = 'Booking expired.';
            else
                $status = 'Status unavailable.';

            $appointments[$aptdate][] = array('apntDt' => $appnt['appointment_dt'], 'pPic' => $appnt['profile_pic'], 'email' => $appnt['email'], 'status' => $status, 'apptType' => $appnt['appt_type'],
                'fname' => $appnt['first_name'], 'phone' => $appnt['mobile'], 'apntTime' => date('h:i a', strtotime($appnt['appointment_dt'])),
                'apntDate' => date('Y-m-d', strtotime($appnt['appointment_dt'])), 'apptLat' => (double) $appnt['appt_lat'], 'apptLong' => (double) $appnt['appt_long'], 'payStatus' => ($appnt['payment_status'] == '' || $appnt['payment_status'] == '2') ? 0 : $appnt['payment_status'],
                'addrLine1' => urldecode($appnt['address_line1']), 'addrLine2' => urldecode($appnt['address_line2']), 'dropLine1' => urldecode($appnt['drop_addr1']), 'dropLine2' => urldecode($appnt['drop_addr2']), 'notes' => $appnt['extra_notes'], 'bookType' => $args['booking_type'], 'amount' => ((in_array($appnt['payment_status'], array(1, 3))) ? round($appnt['amount'], 2) : 0), 'statCode' => $appnt['status'], 'distance' => round(($appnt['distance_in_mts'] / $this->distanceMetersByUnits), 2));
        }

        $i = 1;
        $refIndexes = array();
        $date = $args['ent_appnt_dt'];

        while ($date < $endDate) {

//            $empty_arr = array();

            if (is_array($appointments[$date])) {
                $sortedApnts[] = array('date' => $date, 'appt' => $appointments[$date]);
                $refIndexes[] = $i;
            }
//            else {
//                $sortedApnts[$i] = $empty_arr;
//            }

            $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));

            $i++;
        }

        $errNum = 31;
        if (count($sortedApnts) <= 0)
            $errNum = 30;

        $errMsgArr = $this->_getStatusMessage($errNum, 2);

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'penCount' => $pendingCount, 'refIndex' => $refIndexes, 'appointments' => $sortedApnts); //,'test'=>$selectAppntsQry,'test1'=>$appointments);
    }

    /*
     * Method name: getSlaveAppts
     * Desc: Get Passenger appointments
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function getSlaveAppts($args) {

        if ($args['ent_appnt_dt'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

//        $dates = explode('-', $args['ent_appnt_dt']);

        $args['ent_appnt_dt'] = $args['ent_appnt_dt'] . '-01';
//        $endDate = date('Y-m-d', strtotime('+1 month', strtotime($args['ent_appnt_dt'])));
//        $selectStr = " YEAR(a.appointment_dt) = '" . $dates[0] . "' and MONTH(a.appointment_dt) = '" . $dates[1] . "'";

        $selectAppntsQry = "select d.profile_pic, d.first_name, d.mobile, d.email, a.appt_lat, a.appt_long, a.appointment_dt, a.amount, a.extra_notes, a.address_line1, a.payment_status, a.address_line2, a.drop_addr1, a.drop_addr2, a.status, a.distance_in_mts, a.appt_type, (select count(appointment_id) from appointment where status = 1 and slave_id = '" . $this->User['entityId'] . "') as pen_count from appointment a, master d ";
        $selectAppntsQry .= " where d.mas_id = a.mas_id and a.slave_id = '" . $this->User['entityId'] . "' and ((a.status in (4,5,9) and a.appt_type = 1) or ((a.status NOT in (3,10) and a.appt_type = 2)) ) order by a.appointment_dt DESC"; // and a.appointment_dt >= '" . $curr_date_bfr_1hr . "'//a.status NOT in (3,4,7) 

        $selectAppntsRes = mysql_query($selectAppntsQry, $this->db->conn);

        if (mysql_num_rows($selectAppntsRes) <= 0)
            return $this->_getStatusMessage(65, $selectAppntsQry);

        $appointments = $daysArr = $sortedApnts = array();

        $pendingCount = 0;

        while ($appnt = mysql_fetch_assoc($selectAppntsRes)) {

            if ($appnt['profile_pic'] == '')
                $appnt['profile_pic'] = $this->default_profile_pic;

            $pendingCount = $appnt['pen_count'];

//            $aptdate = date('Y-m-d', strtotime($appnt['appointment_dt']));

            if ($appnt['status'] == '1')
                $status = 'Booking requested';
            else if ($appnt['status'] == '2')
                $status = 'Driver accepted.';
            else if ($appnt['status'] == '3')
                $status = 'Driver rejected.';
            else if ($appnt['status'] == '4')
                $status = 'You have cancelled.';
            else if ($appnt['status'] == '5')
                $status = 'Driver have cancelled.';
            else if ($appnt['status'] == '6')
                $status = 'Driver is on the way.';
            else if ($appnt['status'] == '7')
                $status = 'Driver arrived.';
            else if ($appnt['status'] == '8')
                $status = 'Booking started.';
            else if ($appnt['status'] == '9' && $appnt['payment_status'] == '')
                $status = 'Completed, Payment not done.';
            else if ($appnt['status'] == '9' && ($appnt['payment_status'] == '1' || $appnt['payment_status'] == '3'))
                $status = 'Completed, Payment done.';
            else if ($appnt['status'] == '9' && $appnt['payment_status'] == '2')
                $status = 'Completed, Payment done.';
            else if ($appnt['status'] == '10')
                $status = 'Booking expired.';
            else
                $status = 'Status unavailable.';

            $appointments[] = array('apntDt' => $appnt['appointment_dt'], 'pPic' => $appnt['profile_pic'], 'email' => $appnt['email'], 'status' => $status, 'apptType' => $appnt['appt_type'],
                'fname' => $appnt['first_name'], 'phone' => $appnt['mobile'], 'apntTime' => date('h:i a', strtotime($appnt['appointment_dt'])),
                'apntDate' => date('Y-m-d', strtotime($appnt['appointment_dt'])), 'apptLat' => (double) $appnt['appt_lat'], 'apptLong' => (double) $appnt['appt_long'], 'payStatus' => ($appnt['payment_status'] == '') ? 0 : $appnt['payment_status'],
                'addrLine1' => urldecode($appnt['address_line1']), 'addrLine2' => urldecode($appnt['address_line2']), 'dropLine1' => urldecode($appnt['drop_addr1']), 'dropLine2' => urldecode($appnt['drop_addr2']), 'notes' => $appnt['extra_notes'], 'bookType' => $args['booking_type'], 'amount' => ((in_array($appnt['payment_status'], array(1, 3))) ? round($appnt['amount'], 2) : 0), 'statCode' => $appnt['status'], 'distance' => round(($appnt['distance_in_mts'] / $this->distanceMetersByUnits), 2));
        }

//        $i = 1;
//        $refIndexes = array();
//        $date = $args['ent_appnt_dt'];
//
//        while ($date < $endDate) {
//
////            $empty_arr = array();
//
//            if (is_array($appointments[$date])) {
//                $sortedApnts[] = array('date' => $date, 'appt' => $appointments[$date]);
//                $refIndexes[] = $i;
//            }
////            else {
////                $sortedApnts[$i] = $empty_arr;
////            }
//
//            $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
//
//            $i++;
//        }

        $errNum = 31;
        if (count($sortedApnts) <= 0)
            $errNum = 30;

        $errMsgArr = $this->_getStatusMessage($errNum, 2);

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'penCount' => $pendingCount, 'refIndex' => $refIndexes, 'appointments' => $appointments); //,'test'=>$selectAppntsQry,'test1'=>$appointments);
    }

    /*
     * Method name: respondToAppointment
     * Desc: Respond to appointment requeted
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function respondToAppointment($args) {

        if ($args['ent_appnt_dt'] == '' || $args['ent_response'] == '' || $args['ent_pas_email'] == '' || $args['ent_book_type'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

        $patData = $this->_getEntityDet($args['ent_pas_email'], '2');

        $oneHourBefore = date('Y-m-d H:i:s', strtotime('-1 hour', strtotime($args['ent_appnt_dt'])));

        if ($args['ent_book_type'] == '1')
            $checkApptStr = " and appointment_dt between ('" . $oneHourBefore . "' and '" . $args['ent_appnt_dt'] . "')";
        else
            $checkApptStr = " and appointment_dt = '" . $args['ent_appnt_dt'] . "'";

        $getApptDetQry = "select status from appointments where mas_id = '" . $this->User['entityId'] . "' and status = '2'" . $checkApptStr;

        if (mysql_num_rows(mysql_query($getApptDetQry, $this->db->conn)) > 0)
            return $this->_getStatusMessage(60, 60);

        $getApptDetQry = "select status, appt_type from appointments where mas_id = '" . $this->User['entityId'] . "' and appointment_dt = '" . $args['ent_appnt_dt'] . "' and slave_id = '" . $patData['slave_id'] . "' order by appointment_id DESC";
        $apptDet = mysql_fetch_assoc(mysql_query($getApptDetQry, $this->db->conn));

        if ($apptDet['status'] == '4')
            return $this->_getStatusMessage(41, 3);

        if ($apptDet['status'] == '10')
            return $this->_getStatusMessage(72, 72);

        if ($apptDet['status'] > '1')
            return $this->_getStatusMessage(40, 40);

        $updateString = '';

//        if ($args['ent_book_type'] == '1')
//            $updateString = ", appointment_dt = '" . $this->curr_date_time . "'";

        $updateResponseQry = "update appointment set status = '" . $args['ent_response'] . "'" . $updateString . " where mas_id = '" . $this->User['entityId'] . "' and slave_id = '" . $patData['slave_id'] . "' and appointment_dt = '" . $args['ent_appnt_dt'] . "' and status = 1";
        mysql_query($updateResponseQry, $this->db->conn);

        if (mysql_affected_rows() <= 0)
            return $this->_getStatusMessage(102, $updateResponseQry);

//        if ($args['ent_response'] == '2') {
//            $notifType = 2;
//            $message = "Your appointment with " . $this->User['firstName'] . " is confirmed for " . date('m/d/Y h:i a', strtotime($args['ent_appnt_dt'])) . " on " . $this->appName . "!";
//        } else {
//            $notifType = 10;
//            $message = "Your appointment with " . $this->User['firstName'] . " is rejected for " . date('m/d/Y h:i a', strtotime($args['ent_appnt_dt'])) . " on " . $this->appName . "!";
//        }

        if ($args['ent_book_type'] == '1' && $args['ent_response'] == '2') {
//            $deleteAllSessionsQry = "update master set status = '5' where mas_id = '" . $this->User['entityId'] . "'";
//            mysql_query($deleteAllSessionsQry, $this->db->conn);
//            if (mysql_affected_rows() < 0)
//                return $this->_getStatusMessage(70, $deleteAllSessionsQry);

            $location = $this->mongo->selectCollection('location');

            $location->update(array('user' => (int) $this->User['entityId']), array('$set' => array('status' => 4)));
        } else if ($args['ent_book_type'] == '2' && $args['ent_response'] == '2') {
            
        }

//        $this->ios_cert_path = $this->ios_roadyo_pas;
//        $this->ios_cert_pwd = $this->ios_pas_pwd;
//        $aplPushContent = array('alert' => $message, 'nt' => $notifType, 'sname' => $this->User['firstName'], 'dt' => $this->curr_date_time, 'sound' => 'default');
//        $andrPushContent = array("payload" => $message, 'action' => $notifType, 'sname' => $this->User['firstName'], 'dt' => $this->curr_date_time);
//        $pushNum = $this->_sendPush($this->User['entityId'], array($patData['slave_id']), $message, '2', $this->User['firstName'], $this->curr_date_time, '2', $aplPushContent, $andrPushContent);

        return $this->_getStatusMessage(40, 40);
    }

    /*
     * Method name: updateApptDetails
     * Desc: Update appointment details
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function updateApptDetails($args) {

        if ($args['ent_appnt_id'] == '' || $args['ent_drop_addr_line1'] == '' || $args['ent_distance'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

        $getApptDetQry = "select a.status, a.appt_lat, a.appt_long, a.payment_type, a.drop_lat, a.drop_long, a.address_line1, a.address_line2, a.drop_addr1, a.drop_addr2, a.created_dt, a.arrive_dt, a.start_dt, a.appointment_dt, a.amount, a.appointment_id, a.last_modified_dt, a.user_device, ";
        $getApptDetQry .= "(select email from slave where slave_id = a.slave_id) as pas_email, ";
        $getApptDetQry .= "(select wt.price_per_km from workplace_types wt, workplace w, master d where w.type_id = wt.type_id and w.workplace_id = d.workplace_id and d.mas_id = a.mas_id) as price_per_km, ";
        $getApptDetQry .= "(select wt.price_per_min from workplace_types wt, workplace w, master d where w.type_id = wt.type_id and w.workplace_id = d.workplace_id and d.mas_id = a.mas_id) as price_per_min, ";
        $getApptDetQry .= "(select wt.basefare from workplace_types wt, workplace w, master d where w.type_id = wt.type_id and w.workplace_id = d.workplace_id and d.mas_id = a.mas_id) as base_fare, ";
        $getApptDetQry .= "(select avg(star_rating) from master_ratings where mas_id = a.mas_id) as avg_rating from appointment a where a.appointment_id = '" . $args['ent_appnt_id'] . "'";

        $apptDet = mysql_fetch_assoc(mysql_query($getApptDetQry, $this->db->conn));

        if ($apptDet['status'] != '8')
            return $this->_getStatusMessage(91, $getApptDetQry);

        $duration_in_mts_old = round(abs(strtotime($this->curr_date_time) - strtotime($apptDet['start_dt'])) / 60, 2);

        $duration_in_mts = ((int) $duration_in_mts_old == 0) ? 1 : $duration_in_mts_old;

        $distance_in_mts = $args['ent_distance']; //0

        $dis_in_km = (float) ($distance_in_mts / 1000);

        $avgSpeed = $dis_in_km / ($duration_in_mts / 60);

//        if ($avgSpeed > $this->avgSpeedForDistanceCalculationInKms)
        $amount = $dis_in_km * $apptDet['price_per_km'];
//        else
//            $amount = $duration_in_mts * $apptDet['price_per_min'];

        $newFare = $amount + $apptDet['base_fare'];

        $finalAmount = ($newFare > $apptDet['amount']) ? $newFare : $apptDet['amount'];

        $updateDetailsQry = "update appointment set apprxAmt = '" . $finalAmount . "',amount = '" . $finalAmount . "', duration = '" . $duration_in_mts . "', distance_in_mts = '" . $args['ent_distance'] . "', drop_addr1 = '" . $args['ent_drop_addr_line1'] . "', drop_addr2 = '" . $args['ent_drop_addr_line2'] . "', drop_lat = '" . $args['ent_drop_lat'] . "', drop_long = '" . $args['ent_drop_long'] . "',complete_dt = '" . $this->curr_date_time . "' where appointment_id = '" . $apptDet['appointment_id'] . "'";
        mysql_query($updateDetailsQry, $this->db->conn);

        if (mysql_affected_rows() <= 0)
            return $this->_getStatusMessage(3, $updateDetailsQry);

//        $mail = new sendAMail($this->host);

        $speed_in_mts = $dis_in_km / ($duration_in_mts / 60);

        $apptDet['invoice_id'] = 'RY' . str_pad($apptDet['appointment_id'], 6, '0', STR_PAD_LEFT);

        $apptDet['speed_in_mts'] = $speed_in_mts;

        $apptDet['appt_duration'] = $duration_in_mts;

        $apptDet['appt_distance'] = $dis_in_km;

//        $pasData = $this->_getEntityDet($apptDet['pas_email'], '2');
//        $invoMail = $mail->sendInvoice($this->User, $pasData, $apptDet);

        $errMsgArr = $this->_getStatusMessage(88, 1);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'apprAmount' => $finalAmount, 'dis' => round(($args['ent_distance'] / $this->distanceMetersByUnits), 2), 'avgSpeed' => round($avgSpeed, 2), 'qr' => $updateDetailsQry); //, 'calculatedAmount' => $amount
    }

    /*
     * Method name: updateApptStatus
     * Desc: Update appointment status
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function updateApptStatus($args) {

        if ($args['ent_appnt_dt'] == '' || $args['ent_response'] == '' || $args['ent_pas_email'] == '' || $args['ent_date_time'] == '' || ($args['ent_reponse'] == '9' && $args['ent_amount'] == ''))
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

        $pasData = $this->_getEntityDet($args['ent_pas_email'], '2');

        $getApptDetQry = "select a.coupon_code,a.tip_amount,a.apprxAmt,a.appt_type, a.status, a.distance_in_mts, a.appt_lat, a.appt_long, a.payment_type, a.drop_lat, a.drop_long, a.address_line1, a.address_line2, a.drop_addr1, a.drop_addr2, a.created_dt, a.arrive_dt, a.start_dt, a.appointment_dt, a.amount, a.appointment_id, a.last_modified_dt, a.user_device, ";
        $getApptDetQry .= "(select wt.price_per_km from workplace_types wt, workplace w, master d where w.type_id = wt.type_id and w.workplace_id = d.workplace_id and d.mas_id = a.mas_id) as price_per_km, ";
        $getApptDetQry .= "(select wt.price_per_min from workplace_types wt, workplace w, master d where w.type_id = wt.type_id and w.workplace_id = d.workplace_id and d.mas_id = a.mas_id) as price_per_min, ";
        $getApptDetQry .= "(select avg(star_rating) from master_ratings where mas_id = a.mas_id) as avg_rating from appointment a where a.mas_id = '" . $this->User['entityId'] . "' and a.appointment_dt = '" . $args['ent_appnt_dt'] . "' and a.slave_id = '" . $pasData['slave_id'] . "' order by a.appointment_id DESC";

        $apptDet = mysql_fetch_assoc(mysql_query($getApptDetQry, $this->db->conn));

        if ($apptDet['status'] == '4')
            return $this->_getStatusMessage(41, 3);

        if ($apptDet['status'] == '5')
            return $this->_getStatusMessage(82, 82);

        if ($apptDet['status'] == '10')
            return $this->_getStatusMessage(72, 72);

        $updateStr = '';

        if ($args['ent_response'] == '6') {
            $message = 'Driver on way';
            $noteType = '6';
            $errNum = 57;

//            $getWorkplaceDataQry = "select wt.type_name, w.Title, w.Vehicle_Reg_No from workplace w, workplace_types wt where wt.workplace_id = w.workplace_id and w.workplace_id = '".$apptDet['workplace_id']."'";
//            $workPlaceData = mysql_fetch_assoc(mysql_query($getWorkplaceDataQry, $this->db->conn));

            list($date, $time) = explode(' ', $apptDet['appointment_dt']);
            list($year, $month, $day) = explode('-', $date);
            list($hour, $minute, $second) = explode(':', $time);

            $dateNumber = $year . $month . $day . $hour . $minute . $second;

            $location = $this->mongo->selectCollection('location');
            $masterData = $location->findOne(array('user' => (int) $this->User['entityId']));

            $updateStr = ", expire_ts = '" . (time() + $this->bookingInactivityExpireTime) . "'";

            $aplPushContent = array('alert' => $message, 't' => $apptDet['appt_type'], 'nt' => $noteType, 'd' => $apptDet['appointment_dt'], 'e' => $this->User['email'], 'sound' => 'default', 'ltg' => number_format($masterData['location']['latitude'], '8', '.', '') . ',' . number_format($masterData['location']['longitude'], '6', '.', '')); // 'dis' => ($distance == NULL) ? 0 : $distance, 'eta' => ($duration == NULL) ? 0 : $duration);//'alert' => $message, 'd' => $apptDet['appointment_dt'],//, 'r' => number_format($apptDet['avg_rating'], '2', '.', '')//, 'id' => $apptDet['appointment_id']
            $andrPushContent = array("payload" => $message, 't' => $apptDet['appt_type'], 'action' => $noteType, 'sname' => $this->User['firstName'] . ' ' . $this->User['last_name'], 'dt' => (string) $dateNumber, 'pic' => $this->User['pPic'], 'ph' => $this->User['mobile'], 'e' => $this->User['email'], 'ltg' => $masterData['location']['latitude'] . ',' . $masterData['location']['longitude'], 'd' => $apptDet['appointment_dt'], 'r' => $apptDet['avg_rating'], 'id' => $apptDet['appointment_id']); //    'dis' => $distance, 'eta' => $duration);
        } else if ($args['ent_response'] == '7') {
            $message = 'Driver arrived';
            $noteType = '7';
            $errNum = 58;
            $updateStr = ", arrive_dt = '" . $this->curr_date_time . "', expire_ts = '" . (time() + $this->bookingInactivityExpireTime) . "'";
            $aplPushContent = array('alert' => $message, 't' => $apptDet['appt_type'], 'nt' => $noteType, 'e' => $this->User['email'], 'd' => $apptDet['appointment_dt'], 'sound' => 'default'); //, 'n' => $this->User['firstName'] . ' ' . $this->User['last_name']//, 'pic' => $this->User['pPic'], 'ph' => $this->User['mobile']//, 'id' => $apptDet['appointment_id']
            $andrPushContent = array("payload" => $message, 't' => $apptDet['appt_type'], 'action' => $noteType, 'sname' => $this->User['firstName'] . ' ' . $this->User['last_name'], 'dt' => $args['ent_appnt_dt'], 'pic' => $this->User['pPic'], 'ph' => $this->User['mobile'], 'smail' => $this->User['email'], 'id' => $apptDet['appointment_id']);
        } else if ($args['ent_response'] == '8') {
            $message = 'Journey started';
            $noteType = '8';
            $errNum = 83;
            $duration_in_mts = round(abs(strtotime($this->curr_date_time) - strtotime($apptDet['arrive_dt'])) / 60);
            $updateStr = ",waiting_mts = '" . $duration_in_mts . "', start_dt = '" . $this->curr_date_time . "', expire_ts = '" . (time() + $this->bookingInactivityExpireTime) . "'";
            $aplPushContent = array('alert' => $message, 't' => $apptDet['appt_type'], 'nt' => $noteType, 'e' => $this->User['email'], 'd' => $apptDet['appointment_dt'], 'sound' => 'default'); //, 'n' => $this->User['firstName'] . ' ' . $this->User['last_name']//, 'pic' => $this->User['pPic'], 'ph' => $this->User['mobile']//, 'id' => $apptDet['appointment_id']
            $andrPushContent = array("payload" => $message, 't' => $apptDet['appt_type'], 'action' => $noteType, 'sname' => $this->User['firstName'] . ' ' . $this->User['last_name'], 'dt' => $args['ent_appnt_dt'], 'pic' => $this->User['pPic'], 'ph' => $this->User['mobile'], 'smail' => $this->User['email'], 'id' => $apptDet['appointment_id']);
        } else if ($args['ent_response'] == '9') {
            $message = 'Appointment completed';
            $noteType = '9';
            $errNum = 59;

            $finalAmount = round((double) $args['ent_amount'] + (float) $args['ent_toll'] + (float) $args['ent_airport'] + (float) $args['ent_parking'], 2);

            $discount = 0;

            if ($apptDet['coupon_code'] != '') {
                $getCouponDet = "select discount_type,discount from coupons where coupon_code = '" . $apptDet['coupon_code'] . "'";
                $getCouponDetRes = mysql_query($getCouponDet, $this->db->conn);
                $couponDet = mysql_fetch_assoc($getCouponDetRes);
                if ($couponDet['discount_type'] == '1') {
                    $discount = $finalAmount * ($couponDet['discount'] / 100);
                    $finalAmount = $finalAmount - $discount;
                } else {
                    $discount = $couponDet['discount'];
                    $finalAmount = $finalAmount - $discount;
                }
            }

//            if ($finalAmount > ($apptDet['apprxAmt'] + 50))
//                return $this->_getStatusMessage(95, 95);

            $updateStr .= ",discount = '" . $discount . "',amount = '" . $finalAmount . "',meter_fee = '" . $args['ent_amount'] . "',toll_fee = '" . $args['ent_toll'] . "',airport_fee = '" . $args['ent_airport'] . "',parking_fee = '" . $args['ent_parking'] . "',remarks = '" . $args['ent_doc_remarks'] . "', expire_ts = '" . (time() + $this->bookingInactivityExpireTime) . "'";

            $aplPushContent = array('alert' => $message, 't' => $apptDet['appt_type'], 'nt' => $noteType, 'd' => $apptDet['appointment_dt'], 'e' => $this->User['email'], 'sound' => 'default', 'id' => $apptDet['appointment_id']); //, 'n' => $this->User['firstName'] . ' ' . $this->User['last_name']
            $andrPushContent = array("payload" => $message, 't' => $apptDet['appt_type'], 'action' => $noteType, 'sname' => $this->User['firstName'] . ' ' . $this->User['last_name'], 'dt' => $args['ent_appnt_dt'], 'smail' => $this->User['email'], 'id' => $apptDet['appointment_id']);
        } else {
            return $this->_getStatusMessage(56, 56);
        }

        $updateAppointmentStatusQry = "update appointment set status = '" . $args['ent_response'] . "', last_modified_dt = '" . $this->curr_date_time . "'" . $updateStr . " where mas_id = '" . $this->User['entityId'] . "' and slave_id = '" . $pasData['slave_id'] . "' and appointment_dt = '" . $args['ent_appnt_dt'] . "'";
        $updateAppointmentStatusRes = mysql_query($updateAppointmentStatusQry, $this->db->conn);

        if (mysql_affected_rows() > 0) {

            $this->ios_cert_path = $this->ios_roadyo_pas;
            $this->ios_cert_pwd = $this->ios_pas_pwd;
            $this->androidApiKey = $this->slaveApiKey;

            $location = $this->mongo->selectCollection('location');

            if ($args['ent_response'] == '9') {

                $updateReviewQry = "insert into passenger_rating(mas_id, slave_id, rating, status, rating_dt, appointment_id) values ('" . $this->User['entityId'] . "', '" . $pasData['slave_id'] . "', '" . $args['ent_rating'] . "', '1', '" . $this->curr_date_time . "', '" . $apptDet['appointment_id'] . "')";
                mysql_query($updateReviewQry, $this->db->conn);

                $cond = array('status' => 3, 'apptStatus' => 0);
            } else {
                $cond = array('apptStatus' => (int) $args['ent_response'], 'status' => 5);
            }
            $location->update(array('user' => (int) $this->User['entityId']), array('$set' => $cond));
//            else if ($args['ent_response'] == '7' || $args['ent_response'] == '8') {
            $push['push'] = $this->_sendPush($this->User['entityId'], array($pasData['slave_id']), $message, $noteType, $this->User['email'], $this->curr_date_time, '2', $aplPushContent, $andrPushContent, $apptDet['user_device']);
//            }

            $pubnubContent = array('a' => 14, 'bid' => $apptDet['appointment_id'], 's' => $args['ent_response']);

            $pushNum['pubnub'] = $this->pubnub->publish(array(
                'channel' => 'dispatcher',
                'message' => $pubnubContent
            ));


            $out = array('push1' => $push, 'push' => $aplPushContent);
            return $this->_getStatusMessage($errNum, 2);
        } else if ($updateAppointmentStatusRes) {
            return $this->_getStatusMessage($errNum, $errNum);
        } else {
            return $this->_getStatusMessage(3, $updateAppointmentStatusQry);
        }
    }

    /*
     * Method name: getMySlots
     * Desc: get master slots
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function updateTip($args) {

        if ($args['ent_booking_id'] == '' || $args['ent_tip'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $getDetailsQry = "select amount,meter_fee,toll_fee,parking_fee,airport_fee,coupon_code,discount from appointment where appointment_id = '" . $args['ent_booking_id'] . "'";

        $getDetailsRes = mysql_query($getDetailsQry, $this->db->conn);

        $apptData = mysql_fetch_assoc($getDetailsRes);

        $total = $apptData['airport_fee'] + $apptData['parking_fee'] + $apptData['toll_fee'] + $apptData['meter_fee'];

        $amount = $total - $apptData['discount'];

        $tip = $amount * ((float) $args['ent_tip'] / 100);

        $fare = $amount + $tip;
//        $checkingDate = explode('-', $args['ent_slots_for']);

        $getScheduleQry = "update appointment set tip_amount = '" . $tip . "',tip_percent = '" . $args['ent_tip'] . "',amount = '" . $fare . "' where appointment_id = '" . $args['ent_booking_id'] . "' and slave_id = '" . $this->User['entityId'] . "'";
        mysql_query($getScheduleQry, $this->db->conn); //$getScheduleRes = 
//        if (mysql_affected_rows() >= 0)
//            $errMsgArr = $this->_getStatusMessage(102, 2);
//        else
        $errMsgArr = $this->_getStatusMessage(98, 2);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'fare' => $total, 'tip' => $tip, 'amount' => $fare, 'discount' => $apptData['discount'], 'code' => $apptData['coupon_code']);
    }

    /*
     * Method name: getMySlots
     * Desc: get master slots
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function getMySlots($args) {

        if ($args['ent_slots_for'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

//        $checkingDate = explode('-', $args['ent_slots_for']);

        $getScheduleQry = "select sh.id, sh.day_number, sh.start, sh.mas_id, sh.duration_in_mts, sh.ref_count from master_schedule sh, master doc ";
        $getScheduleQry .= "where sh.mas_id = doc.mas_id and doc.mas_id = '" . $this->User['entityId'] . "' order by sh.start asc";

        $getScheduleRes = mysql_query($getScheduleQry, $this->db->conn);

        $appts = $daysAvlb = $avlbSlots = $avlbDates = array();

        while ($appointment = mysql_fetch_assoc($getScheduleRes)) {

            $appts[$appointment['day_number']]['day'] = $appointment['day_number'];
            $appts[$appointment['day_number']]['time'][] = array('from' => date('h:i a', strtotime($appointment['start'])), 'to' => date("h:i a", strtotime('+' . (int) $appointment['duration_in_mts'] . ' minutes', strtotime($appointment['start']))), 'flag' => $appointment['ref_count']);
        }

        $errMsgArr = $this->_getStatusMessage(21, 2);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'slots' => $appts);
    }

    /*
     * Method name: getMasterProfile
     * Desc: get master profile
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function getMasterProfile($args) {

        if ($args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

        $explodeDateTime = explode(' ', $this->curr_date_time);
        $explodeDate = explode('-', $explodeDateTime[0]);

        $weekData = $this->week_start_end_by_date($this->curr_date_time);

        $selectMasterProfileQry = "select doc.first_name, doc.workplace_id, doc.last_name, doc.email, doc.license_num,doc.license_exp, doc.board_certification_expiry_dt, doc.mobile, doc.status, doc.profile_pic, avg(rat.star_rating) as avgRate, count(rat.review_dt) as totRats, (select count(appointment_id) from appointment where mas_id = doc.mas_id and status = 9) as cmpltApts, (select sum(amount) from appointment where mas_id = doc.mas_id and DATE(appointment_dt) = '" . $explodeDateTime[0] . "' and status = 9) as today_earnings, (select amount from appointment where mas_id = doc.mas_id and status = 9 order by appointment_id DESC limit 0, 1) as last_billed_amount, (select sum(amount) from appointment where mas_id = doc.mas_id and status = 9 and DATE(appointment_dt) BETWEEN '" . $weekData['first_day_of_week'] . "' and '" . $weekData['last_day_of_week'] . "') as week_earnings, (select sum(amount) from appointment where mas_id = doc.mas_id and status = 9 and DATE_FORMAT(appointment_dt, '%Y-%m') = '" . $explodeDate[0] . '-' . $explodeDate[1] . "') as month_earnings, (select sum(amount) from appointment where mas_id = doc.mas_id and status = 9) as total_earnings from master doc, master_ratings rat where doc.mas_id = rat.mas_id and doc.mas_id = '" . $this->User['entityId'] . "'";
        $selectMasterProfileRes = mysql_query($selectMasterProfileQry, $this->db->conn);

        if (mysql_num_fields($selectMasterProfileRes) <= 0)
            return $this->_getStatusMessage(3, $selectMasterProfileQry);

        $docData = mysql_fetch_assoc($selectMasterProfileRes);

        $getVehicleDataQry = "select wrk.workplace_id, wrk.Vehicle_Insurance_No, wrk.Vehicle_Insurance_Dt, wrk.License_Plate_No, (select wt.max_size from workplace_types wt, workplace w where w.type_id = wt.type_id and w.workplace_id = wrk.workplace_id) as capacity, (select v.vehiclemodel from vehiclemodel v, workplace w where w.Vehicle_Model = v.id and w.workplace_id = wrk.workplace_id) as vehicle_model, (select wt.type_name from workplace_types wt, workplace w where w.type_id = wt.type_id and w.workplace_id = wrk.workplace_id) as vehicle_type, wrk.Vehicle_Color from workplace wrk where wrk.workplace_id = '" . $docData['workplace_id'] . "'";

        $getVehicleDataRes = mysql_query($getVehicleDataQry, $this->db->conn);

        $vehicleData = mysql_fetch_assoc($getVehicleDataRes);

        $errMsgArr = $this->_getStatusMessage(21, 2);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'data' => array('fName' => $docData['first_name'],
                'lName' => $docData['last_name'], 'email' => $docData['email'], 'type' => $docData['type_name'], 'mobile' => $docData['mobile'], 'status' => $docData['status'],
                'pPic' => $docData['profile_pic'], 'expertise' => $docData['expertise'], 'vehicleType' => $vehicleData['vehicle_type'],
                'licNo' => $docData['license_num'], 'licExp' => ($docData['license_exp'] == '') ? '' : date('F d, Y', strtotime($docData['license_exp'])),
                'vehMake' => $vehicleData['vehicle_model'] . ' ' . $vehicleData['Vehicle_Color'], 'licPlateNum' => $vehicleData['License_Plate_No'], 'seatCapacity' => $vehicleData['capacity'], 'vehicleInsuranceNum' => $vehicleData['Vehicle_Insurance_No'], 'vehicleInsuranceExp' => $vehicleData['Vehicle_Insurance_Dt'],
                'avgRate' => round($docData['avgRate'], 1), 'totRats' => $docData['totRats'], 'cmpltApts' => $docData['cmpltApts'], 'todayAmt' => round($docData['today_earnings'], 2), 'lastBilledAmt' => round($docData['last_billed_amount'], 2), 'weekAmt' => round($docData['week_earnings'], 2), 'monthAmt' => round($docData['month_earnings'], 2), 'totalAmt' => round($docData['total_earnings'], 2)
        ));
    }

    /*
     * Method name: cancelAppointment
     * Desc: Passenger can Cancel an appointment requested
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function cancelAppointment($args) {

        if ($args['ent_appnt_dt'] == '' || $args['ent_dri_email'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, $args);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

        $getApptDetQry = "select a.appointment_dt, a.appt_type, a.status, a.mas_id, a.appointment_id, a.user_device from appointment a, master d where a.mas_id = d.mas_id and d.email = '" . $args['ent_dri_email'] . "' and a.appointment_dt = '" . $args['ent_appnt_dt'] . "' and a.slave_id = '" . $this->User['entityId'] . "' order by a.appointment_id DESC";
        $getApptDetRes = mysql_query($getApptDetQry, $this->db->conn);

        if (mysql_affected_rows() <= 0)
            return $this->_getStatusMessage(32, 32);

        $apptDet = mysql_fetch_assoc($getApptDetRes);

        if (!is_array($apptDet))
            return $this->_getStatusMessage(32, 32);

        if ($apptDet['status'] == '3')
            return $this->_getStatusMessage(44, 44);

        if ($apptDet['status'] == '4')
            return $this->_getStatusMessage(41, $getApptDetQry);

        if ($apptDet['status'] == '5')
            return $this->_getStatusMessage(82, 3);

        if ($apptDet['status'] == '9')
            return $this->_getStatusMessage(75, 3);

//        $docData = $this->_getEntityDet($args['ent_dri_email'], '1');

        $after_5min = date('Y-m-d H:i:s', (strtotime($apptDet['appointment_dt']) + $this->cancellationTimeInSec));

        if ($this->curr_date_time >= $after_5min)
            $cancelStatus = "cancel_status = '3', ";
        else
            $cancelStatus = "cancel_status = '2', ";

        $cancelApntQry = "update appointment set status = 4, " . $cancelStatus . " last_modified_dt = '" . $this->curr_date_time . "', cancel_dt = '" . $this->curr_date_time . "' where appointment_id = '" . $apptDet['appointment_id'] . "'"; // slave_id = '" . $this->User['entityId'] . "' and mas_id = '" . $apptDet['mas_id'] . "' and appointment_dt = '" . $args['ent_appnt_dt'] . "'";
        mysql_query($cancelApntQry, $this->db->conn);

        if (mysql_affected_rows() <= 0)
            return $this->_getStatusMessage(3, $cancelApntQry);

        $location = $this->mongo->selectCollection('location');

        $master = $location->findOne(array('user' => (int) $apptDet['mas_id']));

        $pubnubContent = array('a' => 10, 'dt' => $apptDet['appointment_dt'], 'e' => $this->User['email'], 'bid' => $apptDet['appointment_id'], 't' => $apptDet['appt_type'],);

        if (!is_null($master['listner']))
            $pushNum['pubnub'] = $this->pubnub->publish(array(
                'channel' => $master['listner'],
                'message' => $pubnubContent
            ));

        $message = "Passenger cancelled the appointment on " . $this->appName . "!";

        $this->ios_cert_path = $this->ios_roadyo_driver;
        $this->ios_cert_pwd = $this->ios_dri_pwd;
        $this->androidApiKey = $this->masterApiKey;
        $aplPushContent = array('alert' => $message, 'nt' => '10', 'd' => $apptDet['appointment_dt'], 'e' => $this->User['email'], 'sound' => 'default', 'id' => $apptDet['appointment_id'], 'r' => $args['ent_cancel_type'], 't' => $apptDet['appt_type']);
        $andrPushContent = array('payload' => $message, 'action' => '10', 'sname' => $this->User['firstName'], 'dt' => $apptDet['appointment_dt'], 'e' => $this->User['email'], 'bid' => $apptDet['appointment_id'], 'r' => $args['ent_cancel_type'], 't' => $apptDet['appt_type']);
        $pushNum['push'] = $this->_sendPush($this->User['entityId'], array($apptDet['mas_id']), $message, '10', $this->User['firstName'], $this->curr_date_time, '1', $aplPushContent, $andrPushContent);

        $deleteAllSessionsQry = "update master set status = '3' where mas_id = '" . $apptDet['mas_id'] . "'";
        mysql_query($deleteAllSessionsQry, $this->db->conn);

        $location->update(array('user' => (int) $apptDet['mas_id']), array('$set' => array('status' => 3, 'apptStatus' => 0)));

        if ($this->curr_date_time >= $after_5min)
            return $this->_getStatusMessage(43, $cancelApntQry . $after_5min);
        else
            return $this->_getStatusMessage(42, $cancelApntQry . $after_5min);
    }

    /*
     * Method name: abortJourney
     * Desc: Driver can Cancel an appointment in any time
     * Input: Request data
     * Output:  success if got it else error according to the result
     */

    protected function abortJourney($args) {

        if ($args['ent_appnt_dt'] == '' || $args['ent_pas_email'] == '' || $args['ent_date_time'] == '' || $args['ent_cancel_type'] == '')
            return $this->_getStatusMessage(1, $args);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

        $getApptDetQry = "select a.appointment_dt,a.appointment_id,a.appt_type,a.status,a.slave_id,a.user_device from appointment a where a.mas_id = '" . $this->User['entityId'] . "' and a.appointment_dt = '" . $args['ent_appnt_dt'] . "'";
        $getApptDetRes = mysql_query($getApptDetQry, $this->db->conn);

        if (mysql_affected_rows() <= 0)
            return $this->_getStatusMessage(32, 32);

        $apptDet = mysql_fetch_assoc($getApptDetRes);

        if (!is_array($apptDet))
            return $this->_getStatusMessage(32, 32);

        if ($apptDet['status'] == '3')
            return $this->_getStatusMessage(44, 44);

        if ($apptDet['status'] == '4')
            return $this->_getStatusMessage(41, 3);

        if ($apptDet['status'] == '9')
            return $this->_getStatusMessage(75, 75);

//        $pasData = $this->_getEntityDet($args['ent_pas_email'], '2');

        $cancelApntQry = "update appointment set status = 5,cancel_status = '" . $args['ent_cancel_type'] . "',last_modified_dt = '" . $this->curr_date_time . "',cancel_dt = '" . $this->curr_date_time . "' where slave_id = '" . $apptDet['slave_id'] . "' and mas_id = '" . $this->User['entityId'] . "' and appointment_dt = '" . $args['ent_appnt_dt'] . "'";
        mysql_query($cancelApntQry, $this->db->conn);

        if (mysql_affected_rows() <= 0)
            return $this->_getStatusMessage(3, $cancelApntQry);

        $message = "Driver cancelled the appointment on " . $this->appName . "!";

        $this->ios_cert_path = $this->ios_roadyo_pas;
        $this->ios_cert_pwd = $this->ios_pas_pwd;
        $this->androidApiKey = $this->slaveApiKey;

        $aplPushContent = array('alert' => $message, 'nt' => '10', 't' => $apptDet['appt_type'], 'sound' => 'default', 'id' => $apptDet['appointment_id'], 'r' => (int) $args['ent_cancel_type']); //, 'd' => $apptDet['appointment_dt'], 'e' => $this->User['email']
        $andrPushContent = array('payload' => $message, 'action' => '10', 't' => $apptDet['appt_type'], 'sname' => $this->User['firstName'], 'dt' => $apptDet['appointment_dt'], 'e' => $this->User['email'], 'bid' => $apptDet['appointment_id']);
        $pushNum['push'] = $this->_sendPush($this->User['entityId'], array($apptDet['slave_id']), $message, '10', $this->User['firstName'], $this->curr_date_time, '2', $aplPushContent, $andrPushContent, $apptDet['user_device']);

        $location = $this->mongo->selectCollection('location');

        $location->update(array('user' => (int) $this->User['entityId']), array('$set' => array('status' => 3)));

        return $this->_getStatusMessage(42, $cancelApntQry . $pushNum);
    }

    /*
     * Method name: cancelAppointmentRequest
     * Desc: Passenger can Cancel an appointment requested
     * Input: Request data
     * Output:  success if cancelled else error according to the result
     */

    protected function cancelAppointmentRequest($args) {

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $checkBookingsQry = "select appointment_id from appointment where slave_id = '" . $this->User['entityId'] . "' and status IN (6,7,8)";
        $checkBookingsRes = mysql_query($checkBookingsQry, $this->db->conn);

        if (mysql_num_rows($checkBookingsRes) > 0)
            return $this->_getStatusMessage(93, 93);

        if ($this->_updateSlvApptStatus($this->User['entityId'], '3') == 0)
            return $this->_getStatusMessage(74, 74);
        else
            return $this->_getStatusMessage(3, 1);
    }

    /*
     * Method name: payForBooking
     * Desc: Passenger can pay for the journey
     * Input: Request data
     * Output:  success array if got it else error according to the result
     */

    protected function payForBooking($args) {

        if ($args['ent_appnt_dt'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $getApptDetQry = "select a.duration,a.distance_in_mts,a.coupon_code,a.tip_amount as tip,a.discount,a.meter_fee as meter,a.parking_fee as parking,a.toll_fee as toll,a.airport_fee as airport,a.status,a.payment_type,a.appt_lat,a.appt_long,a.drop_lat,a.drop_long,a.address_line1,a.address_line2,a.created_dt,a.arrive_dt,a.appointment_dt,a.amount,a.appointment_id,a.last_modified_dt,(select email from master where mas_id = a.mas_id) as master_email from appointment a where a.appointment_dt = '" . $args['ent_appnt_dt'] . "' and a.slave_id = '" . $this->User['entityId'] . "' and a.status = 9";
        $apptDet = mysql_fetch_assoc(mysql_query($getApptDetQry, $this->db->conn));

        if ($apptDet['status'] == '4')
            return $this->_getStatusMessage(41, 3);

        if ($apptDet['status'] == '5')
            return $this->_getStatusMessage(82, 3);

        $masData = $this->_getEntityDet($apptDet['master_email'], '1');


        $transferString = '';

//        $message = "Payment completed for booking dated " . date('d-m-Y h:i a', strtotime($apptDet['appointment_dt'])) . " on " . $this->appName . "!";

        $tipText = "";

        if ($apptDet['tip'] > 0)
            $tipText = " with tip " . $apptDet['tip'];

        $transferAmt = (((float) $apptDet['amount']) * (90 / 100));

        if ($apptDet['payment_type'] == '1') {

            $message = "You have received payment via card for booking id " . $apptDet['appointment_id'] . " on " . $tipText . date('d-m-Y h:i a', strtotime($apptDet['appointment_dt'])) . ".";

            $chargeCustomerArr = array('stripe_id' => $this->User['stripe_id'], 'amount' => (int) ((float) $apptDet['amount'] * 100), 'currency' => 'USD', 'description' => 'From ' . $this->User['email']);

            $customer = $this->stripe->apiStripe('chargeCard', $chargeCustomerArr);

            if ($customer['error'])
                $charge = array('errNum' => 16, 'errFlag' => 1, 'errMsg' => $customer['error']['message'], 'test' => 1);

            $gatewayCommision = (float)($apptDet['amount'] * (2.9 / 100)) + 0.3;

            $appCommision = (float)(($apptDet['amount']) * (10 / 100));//$apptDet['amount'] - $transferAmt;

            $mas = (((float) ($apptDet['amount']) - $appCommision) - $gatewayCommision); //$transferAmt - $appCommision - $gatewayCommision;

            $transferString = ", mas_earning = '" . round($mas, 2) . "', pg_commission = '" . $gatewayCommision . "',app_commission = '" . $appCommision . "'";
        }else if ($apptDet['payment_type'] == '2') {

            $appCommision = $apptDet['amount'] - $transferAmt;

            $transferString = ", mas_earning = '" . round($transferAmt, 2) . "', app_commission = '" . $appCommision . "'";

            $message = "You have received payment via cash for booking id " . $apptDet['appointment_id'] . " on " . $tipText . date('d-m-Y h:i a', strtotime($apptDet['appointment_dt'])) . ".";
        }

        $duration_in_mts = $apptDet['duration']; //round(abs(strtotime($this->curr_date_time) - strtotime($apptDet['arrive_dt'])) / 60, 2);
//            $fare = number_format((float) (($distance_in_mtr / $this->distanceMetersByUnits) * $typeData['price_per_km']), 2, '.', '');
//            $distance_in_mts = $apptDet['distance_in_mts'];

        $dis_in_km = (float) ($apptDet['distance_in_mts'] / $this->distanceMetersByUnits);

//        $dis_in_miles = (float) ($distance_in_mts / 1609.36);

        $speed_in_mts = $dis_in_km / ($duration_in_mts / 60);

        $apptDet['invoice_id'] = 'RY' . str_pad($apptDet['appointment_id'], 6, '0', STR_PAD_LEFT);

        $apptDet['speed_in_mts'] = $speed_in_mts;

        $apptDet['appt_duration'] = $duration_in_mts;

        $apptDet['appt_distance'] = round($dis_in_km, 4);

        $apptDet['final_amount'] = $apptDet['amount'];

        $mail = new sendAMail($this->host);
        $invoMail = $mail->sendInvoice($masData, $this->User, $apptDet);

        $updateInvoiceDetailsQry = "update appointment set payment_status = '1',inv_id = '" . $apptDet['invoice_id'] . "'" . $transferString . " where appointment_id = '" . $apptDet['appointment_id'] . "'"; //mas_id = '" . $masData['mas_id'] . "' and slave_id = '" . $this->User['entityId'] . "' and 
        mysql_query($updateInvoiceDetailsQry, $this->db->conn);

        $aplPushContent = array('alert' => $message, 'nt' => '11', 'n' => $this->User['firstName'] . ' ' . $this->User['last_name'], 'd' => $args['ent_appnt_dt'], 'e' => $this->User['email']);
        $andrPushContent = array("payload" => $message, 'action' => '11', 'sname' => $this->User['firstName'] . ' ' . $this->User['last_name'], 'dt' => $args['ent_appnt_dt'], 'smail' => $this->User['email']);

        $this->ios_cert_path = $this->ios_roadyo_pas;
        $this->ios_cert_pwd = $this->ios_pas_pwd;
        $this->androidApiKey = $this->slaveApiKey;
        $push = $this->_sendPush($this->User['entityId'], array($masData['mas_id']), $message, '11', $this->User['email'], $this->curr_date_time, '1', $aplPushContent, $andrPushContent);
        $out = array('push' => $push, 'charge' => $charge, 'tr' => $transfer, 'invoice' => $invoMail, 'qry' => $updateInvoiceDetailsQry . $getApptDetQry);
        return $this->_getStatusMessage(84, $out);
    }

    /*
     * Method name: reportDispute
     * Desc: Get workplace types data
     * Input: Request data
     * Output:  success array if got it else error according to the result
     */

    protected function reportDispute($args) {

        if ($args['ent_date_time'] == '' || $args['ent_report_msg'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);
        $args['ent_appnt_dt'] = urldecode($args['ent_appnt_dt']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $getApptDetQry = "select a.status,a.appt_lat,a.appt_long,a.address_line1,a.address_line2,a.created_dt,a.arrive_dt,a.appointment_dt,a.amount,a.appointment_id,a.last_modified_dt,a.mas_id from appointment a where a.appointment_dt = '" . $args['ent_appnt_dt'] . "' and a.slave_id = '" . $this->User['entityId'] . "'";
        $apptDet = mysql_fetch_assoc(mysql_query($getApptDetQry, $this->db->conn));

        if ($apptDet['status'] == '4')
            return $this->_getStatusMessage(41, 3);

        $insertIntoReportQry = "insert into reports(mas_id,slave_id,appointment_id,report_msg,report_dt) values('" . $apptDet['mas_id'] . "','" . $this->User['entityId'] . "','" . $apptDet['appointment_id'] . "','" . $args['ent_report_msg'] . "','" . $this->curr_date_time . "')";
        mysql_query($insertIntoReportQry, $this->db->conn);

        if (mysql_insert_id() > 0) {
            $updateQryReq = "update appointment set payment_status = '2' where appointment_id = '" . $apptDet['appointment_id'] . "'";
            mysql_query($updateQryReq, $this->db->conn);

            $message = "Dispute reported for appointment dated " . date('d-m-Y h:i a', strtotime($apptDet['appointment_dt'])) . " on " . $this->appName . "!";

            $aplPushContent = array('alert' => $message, 'nt' => '13', 'n' => $this->User['firstName'] . ' ' . $this->User['last_name'], 'd' => $args['ent_appnt_dt'], 'e' => $this->User['email'], 'bid' => $apptDet['appointment_id']);
            $andrPushContent = array("payload" => $message, 'action' => '13', 'sname' => $this->User['firstName'] . ' ' . $this->User['last_name'], 'dt' => $args['ent_appnt_dt'], 'smail' => $this->User['email'], 'bid' => $apptDet['appointment_id']);

            $this->ios_cert_path = $this->ios_uberx_driver;
            $this->ios_cert_pwd = $this->ios_mas_pwd;
            $this->androidApiKey = $this->masterApiKey;
            $push = $this->_sendPush($this->User['entityId'], array($apptDet['mas_id']), $message, '13', $this->User['email'], $this->curr_date_time, '1', $aplPushContent, $andrPushContent);

            $errMsgArr = $this->_getStatusMessage(85, $push);
        } else {
            $errMsgArr = $this->_getStatusMessage(86, 76);
        }

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 't' => $insertIntoReportQry);
    }

    /*
     * Method name: getProfile
     * Desc: Get slave profile data
     * Input: Request data
     * Output:  success array if got it else error according to the result
     */

    protected function getProfile($args) {

        if ($args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $selectProfileQry = "select * from slave where slave_id = '" . $this->User['entityId'] . "'";
        $profileData = mysql_fetch_assoc(mysql_query($selectProfileQry, $this->db->conn));

        if (!is_array($profileData))
            $errMsgArr = $this->_getStatusMessage(20, 20);

        $errMsgArr = $this->_getStatusMessage(33, 2);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'fName' => $profileData['first_name'], 'lName' => $profileData['last_name'], 'email' => $profileData['email'], 'phone' => $profileData['phone'], 'pPic' => ($profileData['profile_pic'] == '' ? $this->default_profile_pic : $profileData['profile_pic']));
    }

    /*
     * Method name: getWorkplaces
     * Desc: Get workplace types data
     * Input: Request data
     * Output:  success array if got it else error according to the result
     */

    protected function getWorkplaces($args) {

        if ($args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $errMsgArr = $this->_getStatusMessage(33, 2);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'types' => $this->getWorkplaceTypes());
    }

    /*
     * Method name: updateProfile
     * Desc: Update slave profile data
     * Input: Request data
     * Output:  success array if got it else error according to the result
     */

    protected function updateProfile($args) {

        if ($args['ent_first_name'] == '' && $args['ent_email'] == '' && $args['ent_last_name'] == '' && $args['ent_phone'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        if ($args['ent_first_name'] != '')
            $update_name = " first_name = '" . $args['ent_first_name'] . "',";

        if ($args['ent_phone'] != '')
            $update_phone = " phone = '" . $args['ent_phone'] . "',";

        if ($args['ent_last_name'] != '')
            $update_lname = " last_name = '" . $args['ent_last_name'] . "',";

        if ($args['ent_email'] != '') {

            $checkEmailQry = "select slave_id from user where email = '" . $args['ent_email'] . "' and slave_id != '" . $this->User['entityId'] . "'";
            $checkEmailRes = mysql_query($checkEmailQry, $this->db->conn);

            if (mysql_num_rows($checkEmailRes) > 0)
                return $this->_getStatusMessage(2, 10);

            $update_email = " email = '" . $args['ent_email'] . "',";
        }

        $update_str = rtrim($update_name . $update_email . $update_phone . $update_lname, ',');

        $updateQry = "update slave set " . $update_str . ",last_active_dt = '" . $this->curr_date_time . "' where slave_id = '" . $this->User['entityId'] . "'";
        $updateRes = mysql_query($updateQry, $this->db->conn);

        if (mysql_affected_rows() > 0)
            return $this->_getStatusMessage(54, 39);
        else if ($updateRes)
            return $this->_getStatusMessage(54, 40);
        else
            return $this->_getStatusMessage(3, $updateQry);
    }

    /*
     * Method name: getMasterCarDetails
     * Desc: Get master car details that are active currently
     * Input: Request data
     * Output:  success array if got it else error according to the result
     */

    protected function getMasterCarDetails($args) {

        if ($args['ent_email'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $masDet = $this->_getEntityDet($args['ent_email'], '1');

        if (!is_array($masDet))
            return $this->_getStatusMessage(37, 37);

        if ($masDet['workplace_id'] == 0)
            return $this->_getStatusMessage(37, 37);

        $getVehicleDataQry = "select wrk.workplace_id,wrk.License_Plate_No,(select v.vehiclemodel from vehiclemodel v,workplace w where w.Vehicle_Model = v.id  and w.workplace_id = wrk.workplace_id) as vehicle_model from workplace wrk,master m where m.workplace_id = wrk.workplace_id and m.mas_id = '" . $masDet['mas_id'] . "'";

        $getVehicleDataRes = mysql_query($getVehicleDataQry, $this->db->conn);

        $vehicleData = mysql_fetch_assoc($getVehicleDataRes);

        $errMsgArr = $this->_getStatusMessage(21, 50);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'model' => $vehicleData['vehicle_model'], 'plateNo' => $vehicleData['License_Plate_No']);
    }

    /*
     * Method name: addCard
     * Desc: Add a card to the passenger profile
     * Input: Request data
     * Output:  success array if got it else error according to the result
     */

    protected function addCard($args) {

        if ($args['ent_token'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        if ($this->User['stripe_id'] == '') {
            $createCustomerArr = array('token' => $args['ent_token'], 'email' => $this->User['email']);

            $customer = $this->stripe->apiStripe('createCustomer', $createCustomerArr);

            if ($customer['error'])
                return array('errNum' => 16, 'errFlag' => 1, 'errMsg' => $customer['error']['message'], 'test' => 1);

            $updateQry = "update slave set stripe_id = '" . $customer['id'] . "',last_active_dt = '" . $this->curr_date_time . "' where slave_id = '" . $this->User['entityId'] . "'";
            mysql_query($updateQry, $this->db->conn);
            if (mysql_affected_rows() <= 0)
                return $this->_getStatusMessage(51, 50);

            $getCardArr = array('stripe_id' => $customer['id']);

            $card = $this->stripe->apiStripe('getCustomer', $getCardArr);

            if ($card['error'])
                return array('errNum' => 16, 'errFlag' => 1, 'errMsg' => $card['error']['message'], 'test' => 2);

            foreach ($card['cards']['data'] as $c) {
                $cardRes = array('id' => $c['id'], 'last4' => $c['last4'], 'type' => $c['brand'], 'exp_month' => $c['exp_month'], 'exp_year' => $c['exp_year']);
            }

            $errMsgArr = $this->_getStatusMessage(50, 50);
            return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'cards' => array($cardRes), 'def' => $card['default_card']); //, 'cards' => array('id' => $customer['data']['id'], 'last4' => $customer['data']['last4'], 'type' => $customer['data']['type'], 'exp_month' => $customer['data']['exp_month'], 'exp_year' => $customer['data']['exp_year']));
        }

        $addCardArr = array('stripe_id' => $this->User['stripe_id'], 'token' => $args['ent_token']);

        $card = $this->stripe->apiStripe('addCard', $addCardArr);

        if ($card['error'])
            return array('errNum' => 16, 'errFlag' => 1, 'errMsg' => $card['error']['message'], 'test' => 2);

        $getCard = $this->stripe->apiStripe('getCustomer', $addCardArr);

        foreach ($getCard['cards']['data'] as $card) {
            $cardsArr[] = array('id' => $card['id'], 'last4' => $card['last4'], 'type' => $card['brand'], 'exp_month' => $card['exp_month'], 'exp_year' => $card['exp_year']);
        }

        $errMsgArr = $this->_getStatusMessage(50, 50);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'cards' => $cardsArr, 'def' => $getCard['default_card']);
    }

    /*
     * Method name: getCards
     * Desc: Add a card to the passenger profile
     * Input: Request data
     * Output:  success array if got it else error according to the result
     */

    protected function getCards($args) {

        if ($args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        if ($this->User['stripe_id'] == '')
            return $this->_getStatusMessage(51, 51);

        $getCardArr = array('stripe_id' => $this->User['stripe_id']);

        $cardsArr = array();

        $card = $this->stripe->apiStripe('getCustomer', $getCardArr);

        if ($card['error'])
            return array('errNum' => 16, 'errFlag' => 1, 'errMsg' => $card['error']['message'], 'test' => 2);

        foreach ($card['cards']['data'] as $c) {
            $cardsArr[] = array('id' => $c['id'], 'last4' => $c['last4'], 'type' => $c['brand'], 'exp_month' => $c['exp_month'], 'exp_year' => $c['exp_year']);
        }

        if (count($cardsArr) > 0)
            $errNum = 52;
        else
            $errNum = 51;

        $errMsgArr = $this->_getStatusMessage($errNum, 52);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'cards' => $cardsArr, 'def' => $card['default_card']);
    }

    /*
     * Method name: removeCard
     * Desc: Add a card to the passenger profile
     * Input: Request data
     * Output:  success array if got it else error according to the result
     */

    protected function removeCard($args) {

        if ($args['ent_cc_id'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        if ($this->User['stripe_id'] == '')
            return $this->_getStatusMessage(51, 51);

        $remCardArr = array('stripe_id' => $this->User['stripe_id'], 'card_id' => $args['ent_cc_id']);

        $cardsArr = array();

        $card = $this->stripe->apiStripe('deleteCard', $remCardArr);

        if ($card->error)
            return array('errNum' => 16, 'errFlag' => 1, 'errMsg' => $card->error->message);

        foreach ($card->data as $card) {
            $cardsArr = array('id' => $card->data->id, 'last4' => $card->data->last4, 'type' => $card->data->brand, 'exp_month' => $card->data->exp_month, 'exp_year' => $card->data->exp_year);
        }

        $errMsgArr = $this->_getStatusMessage(52, 52);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'cards' => $cardsArr);
    }

    /*
     * Method name: makeCardDefault
     * Desc: Make a card default in the passenger profile
     * Input: Request data
     * Output:  success array if got it else error according to the result
     */

    protected function makeCardDefault($args) {

        if ($args['ent_cc_id'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        if ($this->User['stripe_id'] == '')
            return $this->_getStatusMessage(51, 51);

        $remCardArr = array('stripe_id' => $this->User['stripe_id'], 'card_id' => $args['ent_cc_id']);

        $cardsArr = array();

        $card = $this->stripe->apiStripe('updateCustomerDefCard', $remCardArr);

        if ($card->error)
            return array('errNum' => 16, 'errFlag' => 1, 'errMsg' => $card->error->message);

        foreach ($card->cards->data as $c) {
            $cardsArr[] = array('id' => $c->id, 'last4' => $c->last4, 'type' => $c->brand, 'exp_month' => $c->exp_month, 'exp_year' => $c->exp_year);
        }

        $errMsgArr = $this->_getStatusMessage(52, 52);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'cards' => $cardsArr, 'def' => $card->default_card);
    }

    /*
     * Method name: validateEmailZip
     * Desc: Validates the email and zipcode
     * Input: Token
     * Output:  gives error array if unavailable
     */

    protected function validateEmailZip($args) {

        if ($args['ent_email'] == '' || $args['ent_user_type'] == '')//$args['zip_code'] == '' || 
            return $this->_getStatusMessage(1, 1);


        if ($args['ent_user_type'] == '1')
            $verifyEmail = $this->_verifyEmail($args['ent_email'], 'mas_id', 'master'); //_verifyEmail($email,$field,$table);
        else
            $verifyEmail = $this->_verifyEmail($args['ent_email'], 'slave_id', 'slave'); //_verifyEmail($email,$field,$table);

        if (is_array($verifyEmail))
            $email = array('errFlag' => 1);
        else
            $email = array('errFlag' => 0);


//                $vmail = new verifyEmail();
//
//                if ($vmail->check($args['ent_email'])) {
//                    $email = $this->_getStatusMessage(34, $args['ent_email']);
//                } else if ($vmail->isValid($args['ent_email'])) {
//                    $email = $this->_getStatusMessage(24, $args['ent_email']); //_getStatusMessage($errNo, $test_num);
//                    //echo 'email valid, but not exist!';
//                } else {
//                    $email = $this->_getStatusMessage(25, $args['ent_email']); //_getStatusMessage($errNo, $test_num);
//                    //echo 'email not valid and not exist!';
//                }
//        $selectZipQry = "select zipcode from zipcodes where zipcode = '" . $args['zip_code'] . "'";
//        $selectZipRes = mysql_query($selectZipQry, $this->db->conn);
//        if (mysql_num_rows($selectZipRes) > 0)
        $zip = array('errFlag' => 0);
//        else
//            $zip = array('errFlag' => 1);


        if ($email['errFlag'] == 0 && $zip['errFlag'] == 0)
            return $this->_getStatusMessage(47, $verifyEmail);
        else if ($email['errFlag'] == 1 && $zip['errFlag'] == 1)
            return $this->_getStatusMessage(46, $verifyEmail);
        else if ($email['errFlag'] == 0 && $zip['errFlag'] == 1)
            return $this->_getStatusMessage(46, $verifyEmail);
        else if ($email['errFlag'] == 1 && $zip['errFlag'] == 0)
            return $this->_getStatusMessage(2, $verifyEmail);
    }

    /*
     * Method name: validateEmail
     * Desc: Validates the email
     * Input: Token
     * Output:  gives error array if unavailable
     */

    protected function validateEmail($args) {

        if ($args['ent_email'] == '')
            return $this->_getStatusMessage(1, 1);

        $vmail = new verifyEmail();

        if ($vmail->check($args['ent_email'])) {
            return $this->_getStatusMessage(34, $args['ent_email']);
        } else if ($vmail->isValid($args['ent_email'])) {
            return $this->_getStatusMessage(24, $args['ent_email']); //_getStatusMessage($errNo, $test_num);
//echo 'email valid, but not exist!';
        } else {
            return $this->_getStatusMessage(25, $args['ent_email']); //_getStatusMessage($errNo, $test_num);
//echo 'email not valid and not exist!';
        }
    }

    /*
     * Method name: resetPassword
     * Desc: User can reset the password from with in the app
     * Input: Token
     * Output:  gives error array if failed
     */

    protected function resetPassword($args) {

        if ($args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

        $deleteAllSessionsQry = "update user_sessions set loggedIn = 2 where oid = '" . $this->User['entityId'] . "' and user_type = '1'";
        mysql_query($deleteAllSessionsQry, $this->db->conn);

        if (mysql_affected_rows() <= 0)
            return $this->_getStatusMessage(6, $deleteAllSessionsQry);

        $randData = $this->_generateRandomString(20) . '_1';

        $mail = new sendAMail($this->host);
        $resetRes = $mail->forgotPassword($this->User, $randData);

        if ($resetRes['flag'] == 0) {
            $updateResetDataQry = "update master set resetData = '" . $randData . "', resetFlag = 1 where email = '" . $this->User['email'] . "'";
            mysql_query($updateResetDataQry, $this->db->conn);
//            $resetRes['update'] = $updateResetDataQry;
            return $this->_getStatusMessage(67, $resetRes);
        } else {
            return $this->_getStatusMessage(68, $resetRes);
        }
    }

    /*
     * Method name: updateMasterStatus
     * Desc: Update master status
     * Input: Token
     * Output:  gives error array if failed
     */

    protected function updateMasterStatus($args) {

        $arr = array('3', '4');

        if ($args['ent_date_time'] == '' || $args['ent_status'] == '' || !in_array($args['ent_status'], $arr))
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

//        $deleteAllSessionsQry = "update master set status = '" . $args['ent_status'] . "' where mas_id = '" . $this->User['entityId'] . "'";
//        mysql_query($deleteAllSessionsQry, $this->db->conn);
//
//        if (mysql_affected_rows() < 0)
//            return $this->_getStatusMessage(70, $deleteAllSessionsQry);

        $location = $this->mongo->selectCollection('location');

        $update = $location->update(array('user' => (int) $this->User['entityId']), array('$set' => array('status' => (int) $args['ent_status'])));

        return $this->_getStatusMessage(69, $update);
    }

    /*
     * Method name: forgotPassword
     * Desc: send mail for forgot password
     * Input: Token
     * Output:  gives error array if failed
     */

    protected function forgotPassword($args) {

        if ($args['ent_email'] == '' || $args['ent_user_type'] == '')
            return $this->_getStatusMessage(1, 1);

        if ($args['ent_user_type'] == '1') {
            $table = 'master';
            $uid = 'mas_id';
        } else if ($args['ent_user_type'] == '2') {
            $table = 'slave';
            $uid = 'slave_id';
        } else {
            return $this->_getStatusMessage(1, 1);
        }

        $selectUserQry = "select email,password,$uid from $table where email = '" . $args['ent_email'] . "'";
        $selectUserRes = mysql_query($selectUserQry, $this->db->conn);

        if (mysql_num_rows($selectUserRes) <= 0)
            return $this->_getStatusMessage(66, $selectUserQry);

        $userData = mysql_fetch_assoc($selectUserRes);

        $randData = $this->_generateRandomString(20) . '_' . $args['ent_user_type'];

        $mail = new sendAMail($this->host);
        $resetRes = $mail->forgotPassword($userData, $randData);

        if ($resetRes['flag'] == 0) {
            $updateResetDataQry = "update $table set resetData = '" . $randData . "', resetFlag = 1 where email = '" . $args['ent_email'] . "'";
            mysql_query($updateResetDataQry, $this->db->conn);
//$resetRes['update'] = $updateResetDataQry;
            return $this->_getStatusMessage(67, $resetRes);
        } else {
            return $this->_getStatusMessage(68, $resetRes);
        }
    }

    /*
     * Method name: checkSession
     * Desc: Check session of any users
     * Input: Request data
     * Output:  Complete profile details if available, else error message
     */

    protected function checkSession($args) {

        if ($args['ent_user_type'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 15);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], $args['ent_user_type']);

        if (is_array($returned))
            return $returned;
        else
            return $this->_getStatusMessage(73, 15);
    }

    /*
     * Method name: checkCoupon
     * Desc: Check coupon exists or not, if exists check the expirty
     * Input: Request data
     * Output:  Success if available else error
     */

    protected function checkCoupon($args) {

        if ($args['ent_coupon'] == '' || $args['ent_lat'] == '' || $args['ent_long'] == '')
            return $this->_getStatusMessage(1, 15);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;
//        $checkCouponQry = "select cp.*,sl.first_name,sl.email,(select Currency from city where city_id = cp.city_id) as currency from coupons cp,slave sl,city_available ca where cp.user_id = sl.slave_id and cp.city_id = ca.city_id and cp.coupon_code = '" . $args['ent_referral_code'] . "' and cp.coupon_type = 1 and cp.user_type = 1 and cp.status = 0 and cp.expiry_date > '" . date('Y-m-d', time()) . "' and cp.city_id in (select City_Id from city_available where (3956 * acos( cos( radians('" . $args['ent_latitude'] . "') ) * cos( radians(ca.City_Lat) ) * cos( radians(ca.City_Long) - radians('" . $args['ent_longitude'] . "') ) + sin( radians('" . $args['ent_latitude'] . "') ) * sin( radians(ca.City_Lat) ) ) ) <= " . $this->promoCodeRadius . ") limit 0,1";
        $checkCouponQry = "select id from coupons where coupon_code = '" . $args['ent_coupon'] . "' and (coupon_type = 3 or (coupon_type = 2 and city_id in (select ca.City_Id from city_available ca where (3956 * acos( cos( radians('" . $args['ent_lat'] . "') ) * cos( radians(ca.City_Lat) ) * cos( radians(ca.City_Long) - radians('" . $args['ent_long'] . "') ) + sin( radians('" . $args['ent_lat'] . "') ) * sin( radians(ca.City_Lat) ) ) ) <= " . $this->promoCodeRadius . "))) and status = 0 and expiry_date > '" . date('Y-m-d', time()) . "'";
        if (mysql_num_rows(mysql_query($checkCouponQry, $this->db->conn)) > 0) {
            return $this->_getStatusMessage(101, 15);
        } else {
            return $this->_getStatusMessage(100, $checkCouponQry);
        }
    }

    /*
     * Method name: verifyCode
     * Desc: Check coupon exists or not, if exists check the expirty
     * Input: Request data
     * Output:  Success if available else error
     */

    protected function verifyCode($args) {

        if ($args['ent_coupon'] == '' || $args['ent_lat'] == '' || $args['ent_long'] == '')
            return $this->_getStatusMessage(1, $args);

        $checkCouponQry = "select cp.id from coupons cp where cp.coupon_code = '" . $args['ent_coupon'] . "' and cp.coupon_type = 1 and cp.user_type = 1 and cp.status = 0 and cp.expiry_date > '" . date('Y-m-d', time()) . "'"; // and cp.city_id in (select ca.City_Id from city_available ca where (3956 * acos( cos( radians('" . $args['ent_lat'] . "') ) * cos( radians(ca.City_Lat) ) * cos( radians(ca.City_Long) - radians('" . $args['ent_long'] . "') ) + sin( radians('" . $args['ent_lat'] . "') ) * sin( radians(ca.City_Lat) ) ) ) <= " . $this->promoCodeRadius . ") limit 0,1";
        if (mysql_num_rows(mysql_query($checkCouponQry, $this->db->conn)) > 0) {
            return $this->_getStatusMessage(101, $checkCouponQry);
        } else {
            return $this->_getStatusMessage(100, $checkCouponQry);
        }
    }

    /*
     * Method name: getApptStatus
     * Desc: Get appointment status
     * Input: nothing
     * Output:  gives status if available else error msg
     */

    protected function getApptStatus($args) {

        if ($args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 15);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], $args['ent_user_type']);

        if (is_array($returned))
            return $returned;

        $location = $this->mongo->selectCollection('location');

        if ($args['ent_appnt_dt'] != '') {

            if ($args['ent_user_type'] == '1') {

                $selectStatusQry = "select a.status,a.appointment_id,a.payment_status,a.user_device,a.appt_type,(select status from master where mas_id = '" . $this->User['entityId'] . "') as master_status from appointment a where a.mas_id = '" . $this->User['entityId'] . "' and a.appointment_dt = '" . $args['ent_appnt_dt'] . "' and a.status != '10'";
            } else {
                $selectStatusQry = "select a.payment_status,a.appointment_dt,a.user_device,a.cancel_status,a.amount,a.address_line1,a.address_line2,a.drop_addr1,a.drop_addr2,a.duration,a.appt_lat,a.appt_long,a.drop_lat,a.arrive_dt,a.complete_dt,a.drop_long,a.appointment_id,a.status,a.mas_id,d.profile_pic,d.mobile,d.first_name,d.last_name,d.email,";
                $selectStatusQry .= "(select report_msg from reports where appointment_id = a.appointment_id limit 0,1) as report_msg,(select License_Plate_No from workplace where workplace_id = a.car_id) as licencePlate,(select v.vehiclemodel from vehiclemodel v, workplace w where w.Vehicle_Model = v.id and w.workplace_id = a.car_id) as vehicle_model, ";
                $selectStatusQry .= "(select wt.price_per_km from workplace_types wt,workplace w where w.type_id = wt.type_id and w.workplace_id = d.workplace_id) as price_per_km,(select mas_id from master_ratings where appointment_id = a.appointment_id) as rateStatus from appointment a,master d ";
                $selectStatusQry .= " where a.mas_id = d.mas_id  and a.slave_id = '" . $this->User['entityId'] . "' and a.status != 10 and a.appointment_dt = '" . $args['ent_appnt_dt'] . "' order by appointment_id DESC";
            }
            $selectStatusRes = mysql_query($selectStatusQry, $this->db->conn);
            $statArr = mysql_fetch_assoc($selectStatusRes);

            if (is_array($statArr))
                $errMsgArr = $this->_getStatusMessage(21, 52);
            else
                $errMsgArr = $this->_getStatusMessage(49, 52);

            if ($args['ent_user_type'] == '2') {
                $masterData = $location->findOne(array('user' => (int) $statArr['mas_id']));
            }

            if ($args['ent_user_type'] == '2') {
                return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'pasChn' => 'qp_' . $statArr['user_device'], 'plateNo' => $statArr['licencePlate'], 'model' => $statArr['vehicle_model'], 'chn' => $masterData['chn'], 'r' => round($masterData['rating'], 1), 'ltg' => $masterData['location']['latitude'] . ',' . $masterData['location']['longitude'], 'bid' => $statArr['appointment_id'], 'status' => $statArr['status'], 'bid' => $statArr['appointment_id'], 'fName' => $statArr['first_name'], 'lName' => $statArr['last_name'], 'mobile' => $statArr['mobile'], 'addr1' => urldecode($statArr['address_line1']), 'addr2' => urldecode($statArr['address_line2']), 'dropAddr1' => urldecode($statArr['drop_addr1']), 'dropAddr2' => urldecode($statArr['drop_addr2']), 'amount' => number_format($statArr['amount'], 2, '.', ''), 'pPic' => (($statArr['profile_pic'] === '') ? $this->default_profile_pic : $statArr['profile_pic']), 'dur' => $statArr['duration'], 'pickLat' => $statArr['appt_lat'], 'pickLong' => $statArr['appt_long'], 'dropLat' => $statArr['drop_lat'], 'dropLong' => $statArr['drop_long'], 'apptDt' => $statArr['appointment_dt'], 'pickupDt' => $statArr['arrive_dt'], 'dropDt' => $statArr['complete_dt'], 'email' => $statArr['email'], 'discount' => '0.00', 'rateStatus' => ($statArr['rateStatus'] === '') ? 1 : 2, 'payStatus' => ($statArr['payment_status'] == '') ? 0 : $statArr['payment_status'], 'reportMsg' => $statArr['report_msg'], 'share' => $this->share . $statArr['appointment_id']); //,'t'=>$selectStatusQry);
            } else {
                return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'pasChn' => 'qp_' . $statArr['user_device'], 'plateNo' => $statArr['licencePlate'], 'model' => $statArr['vehicle_model'], 'bid' => $statArr['appointment_id'], 'chn' => $masterData['chn'], 'r' => round($masterData['rating'], 1), 'ltg' => $masterData['location']['latitude'] . ',' . $masterData['location']['longitude'], 'status' => $statArr['status'], 'bid' => $statArr['appointment_id'], 'rateStatus' => ($statArr['rateStatus'] == '') ? 1 : 2, 'payStatus' => ($statArr['payment_status'] == '') ? 0 : 1, 'pPic' => (($statArr['profile_pic'] === '') ? $this->default_profile_pic : $statArr['profile_pic']), 'mobile' => $statArr['mobile'], 'email' => $statArr['email'], 'fName' => $statArr['first_name'], 'apptDt' => $statArr['appointment_dt'], 'masStatus' => $statArr['master_status'], 'share' => $this->share . $statArr['appointment_id'], 'nt' => ($statArr['appt_type'] == '1' ? '' : '51')); //,'t'=>$selectStatusQry);
            }
        }

        if ($args['ent_user_type'] == '2') {
            $selectAppntsQry = "select a.payment_status,a.appointment_dt,a.user_device,a.cancel_status,a.amount,a.address_line1,a.address_line2,a.drop_addr1,a.drop_addr2,a.duration,a.appt_lat,a.appt_long,a.drop_lat,a.arrive_dt,a.complete_dt,a.drop_long,a.appointment_id,a.status,a.mas_id,d.profile_pic,d.mobile,d.first_name,d.last_name,d.email,";
            $selectAppntsQry .= "(select report_msg from reports where appointment_id = a.appointment_id limit 0,1) as report_msg,(select License_Plate_No from workplace where workplace_id = a.car_id) as licencePlate,(select v.vehiclemodel from vehiclemodel v, workplace w where w.Vehicle_Model = v.id and w.workplace_id = a.car_id) as vehicle_model, ";
            $selectAppntsQry .= "(select wt.price_per_km from workplace_types wt,workplace w where w.type_id = wt.type_id and w.workplace_id = d.workplace_id) as price_per_km,(select mas_id from master_ratings where appointment_id = a.appointment_id) as rateStatus from appointment a,master d ";
            $selectAppntsQry .= " where a.mas_id = d.mas_id  and a.slave_id = '" . $this->User['entityId'] . "' and a.status IN (6,7,8) order by appointment_id DESC limit 0,1";
        } else {
            $selectAppntsQry = "select a.appt_type,a.payment_status,a.appointment_dt,a.user_device,a.amount,a.address_line1,a.address_line2,a.drop_addr1,a.drop_addr2,a.appointment_dt,a.duration,a.appt_lat,a.appt_long,a.appointment_id,a.drop_lat,a.drop_long,a.arrive_dt,a.complete_dt,a.status,s.profile_pic,s.phone as mobile,s.first_name,s.last_name,s.email,(select status from master where mas_id = '" . $this->User['entityId'] . "') as master_status ,";
            $selectAppntsQry .= "(select report_msg from reports where appointment_id = a.appointment_id limit 0,1) as report_msg,";
            $selectAppntsQry .= "(select wt.price_per_km from workplace_types wt,workplace w,master d where w.type_id = wt.type_id and w.workplace_id = d.workplace_id and d.mas_id = a.mas_id) as price_per_km ";
            $selectAppntsQry .= " from appointment a,slave s  where a.slave_id = s.slave_id and a.mas_id = '" . $this->User['entityId'] . "' and a.status IN (1,6,7,8) ";
        }

        $selectStatusRes = mysql_query($selectAppntsQry, $this->db->conn);

        $appts = array();

//        $location = $this->mongo->selectCollection('location');
//        $location->ensureIndex(array('user' => 1));

        while ($apptData = mysql_fetch_assoc($selectStatusRes)) {

            $masterData = array();

            $masterStatus = $apptData['master_status'];

            if ($args['ent_user_type'] == '2') {
                $masterData = $location->findOne(array('user' => (int) $apptData['mas_id']));
            }

            $appts[] = array('pasChn' => 'qp_' . $apptData['user_device'], 'nt' => ($apptData['appt_type'] == '1' ? '' : '51'), 'plateNo' => $apptData['licencePlate'], 'model' => $apptData['vehicle_model'], 'chn' => $masterData['chn'], 'r' => round($masterData['rating'], 1), 'ltg' => $masterData['location']['latitude'] . ',' . $masterData['location']['longitude'], 'bid' => $apptData['appointment_id'], 'status' => $apptData['status'], 'bid' => $apptData['appointment_id'], 'fName' => $apptData['first_name'], 'lName' => $apptData['last_name'], 'mobile' => $apptData['mobile'], 'addr1' => urldecode($apptData['address_line1']), 'addr2' => urldecode($apptData['address_line2']), 'dropAddr1' => urldecode($apptData['drop_addr1']), 'dropAddr2' => urldecode($apptData['drop_addr2']), 'amount' => number_format($apptData['amount'], 2, '.', ''), 'pPic' => (($apptData['profile_pic'] === '') ? $this->default_profile_pic : $apptData['profile_pic']), 'dur' => $apptData['duration'], 'pickLat' => $apptData['appt_lat'], 'pickLong' => $apptData['appt_long'], 'dropLat' => $apptData['drop_lat'], 'dropLong' => $apptData['drop_long'], 'apptDt' => $apptData['appointment_dt'], 'pickupDt' => $apptData['arrive_dt'], 'dropDt' => $apptData['complete_dt'], 'email' => $apptData['email'], 'discount' => '0.00', 'rateStatus' => ($apptData['rateStatus'] === '') ? 1 : 2, 'payStatus' => ($apptData['payment_status'] == '') ? 0 : $apptData['payment_status'], 'reportMsg' => $apptData['report_msg'], 'share' => $this->share . $apptData['appointment_id']);
        }

        if (count($appts) > 0) {
            $errMsgArr = $this->_getStatusMessage(21, 52);
        } else {
            if ($args['ent_user_type'] == '1') {
                $getMasterStatusQry = "select status from master where mas_id = '" . $this->User['entityId'] . "'";
                $status = mysql_fetch_assoc(mysql_query($getMasterStatusQry, $this->db->conn));
                $masterStatus = $status['status'];
            }
            $errMsgArr = $this->_getStatusMessage(49, 52);
        }

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'data' => $appts, 't' => $selectAppntsQry, 'masStatus' => $masterStatus);
    }

    /*
     * Method name: updateMasterRating
     * Desc: Update master rating for slave
     * Input: Rating
     * Output:  gives error array if failed
     */

    protected function getMasterStatus($args) {
        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

        $location = $this->mongo->selectCollection('location');

        $findOne = $location->findOne(array('user' => (int) $this->User['entityId']));

        $errMsgArr = $this->_getStatusMessage(103, 52);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'status' => $findOne['status']);
    }

    /*
     * Method name: updateMasterRating
     * Desc: Update master rating for slave
     * Input: Rating
     * Output:  gives error array if failed
     */

    protected function updateMasterRating($args) {

        if ($args['ent_date_time'] == '' || $args['ent_rating'] == '' || $args['ent_appnt_dt'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

        $slvDet = $this->_getEntityDet($args['ent_slv_email'], '2');

        $selectApptQry = "select appointment_id from appointment where slave_id = '" . $slvDet['slave_id'] . "' and mas_id = '" . $this->User['entityId'] . "' and appointment_dt = '" . $args['ent_appnt_dt'] . "'";
        $selectApptRes = mysql_query($selectApptQry, $this->db->conn);

        if (mysql_num_rows($selectApptRes) <= 0)
            return $this->_getStatusMessage(62, 62);

        $appt = mysql_fetch_assoc($selectApptRes);

        $updateReviewQry = "insert into passenger_rating(mas_id,slave_id,rating,status,rating_dt,appointment_id) values ('" . $this->User['entityId'] . "','" . $slvDet['slave_id'] . "','" . $args['ent_rating'] . "','1','" . $this->curr_date_time . "','" . $appt['appointment_id'] . "')";
        mysql_query($updateReviewQry, $this->db->conn);

        if (mysql_affected_rows() < 0)
            return $this->_getStatusMessage(70, $updateReviewQry);

        return $this->_getStatusMessage(69, $updateReviewQry);
    }

    /*
     * Method name: getFavourites
     * Desc: Get all favourite drivers
     * Input: Request data
     * Output:  Complete details if available, else error message
     */

    protected function getFavourites($args) {

        if ($args['ent_date_time'] == '' || $args['ent_latitude'] == '' || $args['ent_longitude'] == '')
            return $this->_getStatusMessage(1, 15);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $favourites = $this->mongo->selectCollection('favourite');

        $getCursor = $favourites->find(array('passenger' => (int) $this->User['entityId']));

        $driversArr = array();

        foreach ($getCursor as $fav) {
            $driversArr[] = $fav['driver'];
        }

        if (count($driversArr) <= 0)
            return $this->_getStatusMessage(95, 15);

        $resultArr = $this->mongo->selectCollection('$cmd')->findOne(array(
            'geoNear' => 'location',
            'near' => array(
                (double) $args['ent_longitude'], (double) $args['ent_latitude']
            ), 'spherical' => true, 'maxDistance' => 1, 'distanceMultiplier' => 6378137,
            'query' => array('user' => array('$in' => $driversArr)))
        );

        $md_arr = array();
//                    
        foreach ($resultArr['results'] as $res) {
            $doc = $res['obj'];
            $md_arr[] = array("name" => $doc["name"], 'lname' => $doc['lname'], "image" => $doc['image'], "rating" => (float) $doc['rating'],
                'email' => $doc['email'], 'lat' => $doc['location']['latitude'], 'lon' => $doc['location']['longitude'], 'dis' => number_format((float) $res['dis'] / $this->distanceMetersByUnits, 2, '.', ''));
        }

        if (count($md_arr) > 0)
            $errMsgArr = $this->_getStatusMessage(94, 52);
        else
            $errMsgArr = $this->_getStatusMessage(95, 52);

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'masters' => $md_arr);
    }

    /*
     * Method name: removeFavourites
     * Desc: Remove driver from favorites
     * Input: Request data
     * Output:  success if removed, else error message
     */

    protected function removeFavourites($args) {

        if ($args['ent_date_time'] == '' || $args['ent_mas_email'] == '')
            return $this->_getStatusMessage(1, 15);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '2');

        if (is_array($returned))
            return $returned;

        $location = $this->mongo->selectCollection('location');

        $masDet = $location->findOne(array('email' => $args['ent_mas_email']));

        $favorite = $this->mongo->selectCollection('favourite');
        $favorite->remove(array('driver' => (int) $masDet['user']));

        return $this->_getStatusMessage(96, 52);
    }

    /*
     * Method name: logout
     * Desc: Edit profile of any users
     * Input: Request data
     * Output:  Complete profile details if available, else error message
     */

    protected function logout($args) {

        if ($args['ent_user_type'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 15);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], $args['ent_user_type'], '1');

        if (is_array($returned))
            return $returned;

        $logoutQry = "update user_sessions set loggedIn = '2' where oid = '" . $this->User['entityId'] . "' and sid = '" . $this->User['sid'] . "' and user_type = '" . $args['ent_user_type'] . "'";
        $logoutRes = mysql_query($logoutQry, $this->db->conn);

        if (mysql_affected_rows() > 0 || $logoutRes) {

            if ($args['ent_user_type'] == '1') {
                $updateWorkplaceIdQry = "update master set workplace_id = '' where mas_id = '" . $this->User['entityId'] . "'";
                mysql_query($updateWorkplaceIdQry, $this->db->conn);

                $updateWorkplaceQry = "update workplace set Status = 2,last_logout_lat = '" . $args['ent_lat'] . "',last_logout_long = '" . $args['ent_long'] . "' where workplace_id = '" . $this->User['workplaceId'] . "'";
                mysql_query($updateWorkplaceQry, $this->db->conn);

                $location = $this->mongo->selectCollection('location');

                $location->update(array('user' => (int) $this->User['entityId']), array('$set' => array('status' => 4, 'type' => 0, 'carId' => 0, 'chn' => '', 'listner' => '')));
            }
            return $this->_getStatusMessage(29, 55);
        } else {
            return $this->_getStatusMessage(3, $logoutQry);
        }
    }

    /*     * *********************************
      /*pendingrequest
     */

    protected function getPendingRequests($args) {

        if ($args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = urldecode($args['ent_date_time']);

        $dateExploded = explode(' ', $this->curr_date_time);

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], '1');

        if (is_array($returned))
            return $returned;

        $selectAppntsQry = "select p.profile_pic,p.first_name,p.phone,p.email,p.phone,a.appt_lat,a.appt_long,a.appointment_dt,a.appointment_id,a.extra_notes,a.address_line1,a.address_line2,a.drop_addr1,a.drop_addr2,a.drop_lat,a.drop_long,a.complete_dt,a.arrive_dt,a.status,a.payment_status,a.amount,a.distance_in_mts,a.appt_type from appointment a, slave p ";
        $selectAppntsQry .= " where p.slave_id = a.slave_id and a.mas_id = '" . $this->User['entityId'] . "' and a.status IN (1,2,6,7,8)  order by a.appointment_dt ASC"; // and a.appointment_dt >= '" . $curr_date_bfr_1hr . "'        a.status NOT in (1,3,4,7) and



        /*
          $selectAppntsQry = "select p.profile_pic,p.first_name,p.phone,p.email,p.phone,a.appt_lat,a.appt_long,a.appointment_dt,a.appointment_id,a.extra_notes,a.address_line1,a.address_line2,a.drop_addr1,a.drop_addr2,a.drop_lat,a.drop_long,a.complete_dt,a.arrive_dt,a.status,a.payment_status,a.amount,a.distance_in_mts,a.appt_type from appointment a, slave p ";
          $selectAppntsQry .= " where p.slave_id = a.slave_id and (" . $pendingString . " (a.mas_id = '" . $this->User['entityId'] . "' and a.status IN (2,6,7,8))) and DATE(a.appointment_dt) = '" . $dateExploded[0] . "' order by a.appointment_dt ASC"; // and a.appointment_dt >= '" . $curr_date_bfr_1hr . "'        a.status NOT in (1,3,4,7) and
         */

        $selectAppntsRes = mysql_query($selectAppntsQry, $this->db->conn);

        if (mysql_num_rows($selectAppntsRes) <= 0)
            return $this->_getStatusMessage(30, $selectAppntsQry);

        $appointments = $daysArr = array();


        while ($appnt = mysql_fetch_assoc($selectAppntsRes)) {

            if ($appnt['profile_pic'] == '')
                $appnt['profile_pic'] = $this->default_profile_pic;

            $durationSec = abs(strtotime($appnt['complete_dt']) - strtotime($appnt['start_dt']));

            $durationMin = round($durationSec / 60);

            if ($appnt['status'] == '1')
                $status = 'Booking requested';
            else if ($appnt['status'] == '2')
                $status = 'Driver accepted.';
//            else if ($appnt['status'] == '3')
//                $status = 'Driver rejected.';
//            else if ($appnt['status'] == '4')
//                $status = 'You have cancelled.';
//            else if ($appnt['status'] == '5')
//                $status = 'Driver have cancelled.';
//            else
            else if ($appnt['status'] == '6')
                $status = 'Driver is on the way.';
            else if ($appnt['status'] == '7')
                $status = 'Driver arrived.';
            else if ($appnt['status'] == '8')
                $status = 'Booking started.';
            else if ($appnt['status'] == '9')
                $status = 'Booking completed.';
//            else if ($appnt['status'] == '10')
//                $status = 'Booking expired.';
            else
                $status = 'Status unavailable.';

            $appointments[] = array('bid' => $appnt['appointment_id'], 'pPic' => $appnt['profile_pic'], 'email' => $appnt['email'], 'statCode' => $appnt['status'], 'status' => $status,
                'fname' => $appnt['first_name'], 'apntTime' => date('h:i a', strtotime($appnt['appointment_dt'])), 'apntDt' => $appnt['appointment_dt'], 'mobile' => $appnt['phone'],
                'addrLine1' => urldecode($appnt['address_line1']), 'payStatus' => ($appnt['payment_status'] == '') ? 0 : $appnt['payment_status'], 'apptLat' => $appnt['appt_lat'], 'apptLong' => $appnt['appt_long'],
                'dropLine1' => urldecode($appnt['drop_addr1']), 'duration' => $durationMin, 'distance' => round($appnt['distance_in_mts'] / $this->distanceMetersByUnits, 2), 'amount' => $appnt['amount']);
        }

        $errMsgArr = $this->_getStatusMessage(31, 2);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'appointments' => $appointments); //,'test'=>$selectAppntsQry,'test1'=>$appointments);
    }

    /*     * *********************************



      /*
     * Method name: getWorkplaceTypes
     * Desc: Get workplace data
     * Input: nothing
     * Output:  gives workplace details if available else error msg
     */

    protected function getWorkplaceTypes($cityName = NULL, $lat = NULL, $long = NULL) {

        if ($lat != NULL && $long != NULL) {
            $typesData = $types = $typesData1 = array();
            $cond = array(
                'geoNear' => 'vehicleTypes',
                'near' => array(
                    (double) $long, (double) $lat
                ), 'spherical' => true, 'maxDistance' => 50000 / 6378137, 'distanceMultiplier' => 6378137);

            $resultArr1 = $this->mongo->selectCollection('$cmd')->findOne($cond);

            foreach ($resultArr1['results'] as $res) {
                $doc = $res['obj'];

                $types[] = (int) $doc['type'];

                $typesData[$doc['type']] = array(
                    'type_id' => (int) $doc['type'],
                    'type_name' => $doc['type_name'],
                    'max_size' => (int) $doc['max_size'],
                    'basefare' => (float) $doc['basefare'],
                    'min_fare' => (float) $doc['min_fare'],
                    'price_per_min' => (float) $doc['price_per_min'],
                    'price_per_km' => (float) $doc['price_per_km'],
                    'type_desc' => $doc['type_desc']
                );
            }

            sort($types);

            foreach ($types as $type) {
                $typesData1[] = $typesData[$type];
            }

            return $typesData1;
        }

        if ($cityName == NULL)
            $selectWkTypesQry = "select wt.type_id,wt.type_name,wt.max_size,wt.basefare,wt.min_fare,wt.price_per_min,wt.price_per_km,wt.type_desc from workplace_types wt";
        else
            $selectWkTypesQry = "select wt.type_id,wt.type_name,wt.max_size,wt.basefare,wt.min_fare,wt.price_per_min,wt.price_per_km,wt.type_desc from workplace_types wt,city c where wt.city_id = c.City_Id and c.City_Name = '" . $cityName . "'";

        $selectWkTypesRes = mysql_query($selectWkTypesQry, $this->db->conn);

        $reviewsArr = array();

        while ($review = mysql_fetch_assoc($selectWkTypesRes)) {
            $reviewsArr[] = $review;
        }

        return $reviewsArr;
    }

    protected function getTypes($args) {

        $getCompQry = "select company_id,companyname from company_info where Status = 3";
        $getCompRes = mysql_query($getCompQry, $this->db->conn);

        while ($type = mysql_fetch_assoc($getCompRes)) {
            $compList[] = $type;
        }
        $compList[] = array('company_id' => 0, 'companyname' => 'Other');
        $errMsgArr = $this->_getStatusMessage(21, 52);
        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'types' => $compList);
    }

    /*
     * Method name: checkCity
     * Desc: Check the cars available in this area or not.
     * Input: Request data
     * Output:  image name if uploaded and status message according to the result
     */

    protected function checkCity($args) {

        if ($args['ent_city'] == '')
            return $this->_getStatusMessage(1, 15);

        if (count($this->getWorkplaceTypes($args['ent_city'])) <= 0)
            return $this->_getStatusMessage(80, 80);
        else
            return $this->_getStatusMessage(81, 51);
    }

    /*
     * Method name: updateSession
     * Desc: Updates user session
     * Input: Request data
     * Output:  Complete profile details if available, else error message
     */

    protected function updateSession($args) {

        if ($args['ent_user_type'] == '' || $args['ent_date_time'] == '')
            return $this->_getStatusMessage(1, 1);

        $this->curr_date_time = $args['ent_date_time'];

        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id'], $args['ent_user_type']);
//print_r($returned);

        if (!is_array($returned)) {
            return $this->_getStatusMessage(73, $this->testing);
        } else if ((is_array($returned) && $returned['errNum'] == 6)) {// || 
            $token_obj = new ManageToken($this->db);

            $updateArr = $token_obj->updateSessToken($this->User['entityId'], $args['ent_dev_id'], '0', $args['ent_user_type'], $args['ent_date_time']);

            $errMsgArr = $this->_getStatusMessage(89, 71);
            return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'token' => $updateArr['Token'], 'expiryLocal' => $updateArr['Expiry_local'], 'expiryGMT' => $updateArr['Expiry_GMT'], 'flag' => $updateArr['Flag'], 'status' => ($this->User['status'] == '') ? $returned['status'] : $this->User['status']); //, 't' => $updateArr);
        } else {
            return $this->_getStatusMessage(90, 72);
        }
    }

    /*
     * Method name: truncateDB
     * Desc: Uploads media to the server folder named "pics"
     * Input: Request data
     * Output:  image name if uploaded and status message according to the result
     */

    protected function _truncateDB($args) {

        $num = 0;

        $qry2 = "truncate table master";
        mysql_query($qry2, $this->db->conn);
        $num += mysql_affected_rows();

        $qry12 = "truncate table slave";
        mysql_query($qry12, $this->db->conn);
        $num += mysql_affected_rows();

        $qry21 = "truncate table user_sessions";
        mysql_query($qry21, $this->db->conn);
        $num += mysql_affected_rows();

        $qry22 = "truncate table master_ratings";
        mysql_query($qry22, $this->db->conn);
        $num += mysql_affected_rows();

        $qry23 = "truncate table appointment";
        mysql_query($qry23, $this->db->conn);
        $num += mysql_affected_rows();

        $qry25 = "truncate table images";
        mysql_query($qry25, $this->db->conn);
        $num += mysql_affected_rows();

        $qry24 = "truncate table workplace";
        mysql_query($qry24, $this->db->conn);
        $num += mysql_affected_rows();

        $qry26 = "truncate table appointments_later";
        mysql_query($qry26, $this->db->conn);
        $num += mysql_affected_rows();

        $qry27 = "truncate table company_info";
        mysql_query($qry27, $this->db->conn);
        $num += mysql_affected_rows();

        $qry28 = "truncate table vehicledoc";
        mysql_query($qry28, $this->db->conn);
        $num += mysql_affected_rows();

        $qry29 = "truncate table docdetail";
        mysql_query($qry29, $this->db->conn);
        $num += mysql_affected_rows();

        $qry30 = "truncate table workplace_types";
        mysql_query($qry30, $this->db->conn);
        $num += mysql_affected_rows();


        $location = $this->mongo->selectCollection('location');
        $response = $location->drop();

        $pat = $this->mongo->selectCollection('pat');
        $response1 = $pat->drop();

        $notifications = $this->mongo->selectCollection('notifications');
        $response2 = $notifications->drop();

        $vTypes = $this->mongo->selectCollection('vehicleTypes');
        $response3 = $vTypes->drop();

        $location->ensureIndex(array("location" => "2d"));

        $cursor = $location->find();

        $data = array();

        foreach ($cursor as $doc) {
            $data[] = $doc;
        }

        $cursor1 = $pat->find();

        foreach ($cursor1 as $doc) {
            $data[] = $doc;
        }

        $dir = 'pics/';
        $leave_files = array('aa_default_profile_pic.gif');

        $image = 0;

        foreach (glob("$dir/*") as $file) {
            if (is_dir($file)) {
                foreach (glob("$dir/$file/*") as $file1) {
                    if (!in_array(basename($file1), $leave_files)) {
                        unlink($file);
                        $image++;
                    }
                }
            } else if (!in_array(basename($file), $leave_files)) {
                unlink($file);
                $image++;
            }
        }
        $dir = 'pics/mdpi/';
        $leave_files = array('aa_default_profile_pic.gif');

        $image = 0;

        foreach (glob("$dir/*") as $file) {
            if (is_dir($file)) {
                foreach (glob("$dir/$file/*") as $file1) {
                    if (!in_array(basename($file1), $leave_files)) {
                        unlink($file);
                        $image++;
                    }
                }
            } else if (!in_array(basename($file), $leave_files)) {
                unlink($file);
                $image++;
            }
        }
        $dir = 'pics/hdpi/';
        $leave_files = array('aa_default_profile_pic.gif');

        $image = 0;

        foreach (glob("$dir/*") as $file) {
            if (is_dir($file)) {
                foreach (glob("$dir/$file/*") as $file1) {
                    if (!in_array(basename($file1), $leave_files)) {
                        unlink($file);
                        $image++;
                    }
                }
            } else if (!in_array(basename($file), $leave_files)) {
                unlink($file);
                $image++;
            }
        }
        $dir = 'pics/xhdpi/';
        $leave_files = array('aa_default_profile_pic.gif');

        $image = 0;

        foreach (glob("$dir/*") as $file) {
            if (is_dir($file)) {
                foreach (glob("$dir/$file/*") as $file1) {
                    if (!in_array(basename($file1), $leave_files)) {
                        unlink($file);
                        $image++;
                    }
                }
            } else if (!in_array(basename($file), $leave_files)) {
                unlink($file);
                $image++;
            }
        }
        $dir = 'pics/xxhdpi/';
        $leave_files = array('aa_default_profile_pic.gif');

        $image = 0;

        foreach (glob("$dir/*") as $file) {
            if (is_dir($file)) {
                foreach (glob("$dir/$file/*") as $file1) {
                    if (!in_array(basename($file1), $leave_files)) {
                        unlink($file);
                        $image++;
                    }
                }
            } else if (!in_array(basename($file), $leave_files)) {
                unlink($file);
                $image++;
            }
        }


        $dir1 = 'invoice/';

        foreach (glob("$dir1/*") as $file) {
            if (is_dir($file)) {
                foreach (glob("$dir1/$file/*") as $file1) {
                    unlink($file);
                    $image++;
                }
            } else if (!in_array(basename($file), $leave_files)) {
                unlink($file);
                $image++;
            }
        }

        $dir2 = 'admin/pics/';

        foreach (glob("$dir2/*") as $file) {
            if (is_dir($file)) {
                foreach (glob("$dir2/$file/*") as $file1) {
                    unlink($file);
                    $image++;
                }
            } else if (!in_array(basename($file), $leave_files)) {
                unlink($file);
                $image++;
            }
        }

        $dir3 = 'admin/upload_images/';

        foreach (glob("$dir3/*") as $file) {
            if (is_dir($file)) {
                foreach (glob("$dir3/$file/*") as $file1) {
                    unlink($file);
                    $image++;
                }
            } else if (!in_array(basename($file), $leave_files)) {
                unlink($file);
                $image++;
            }
        }

        return array('mongodb' => $response . '--' . $response1 . '--' . $response2 . '--' . $response3, 'data' => $data, 'rows' => $num, 'images' => $image);
    }

    protected function testMon($args) {

        $location = $this->mongo->selectCollection('location');
        $types = $this->mongo->selectCollection('vehicleTypes');

//        $location->remove(array('type' => array('$in' => array(16, 17, 91, 92))), array('multiple' => 1));
//        $types->remove(array('type' => array('$in' => array(16, 17, 91, 92))), array('multiple' => 1));

        $arr = array();
        $arr[] = time();
        $arr[] = date('Y-m-d H:i:s', time());
//        $response = $location->drop();
//        
        $location->ensureIndex(array("location" => "2d"));

        $cursor1 = $types->find();
        $cursor2 = $location->find();

        foreach ($cursor1 as $doc) {
            $arr[] = $doc;
        }
        foreach ($cursor2 as $doc) {
            $arr[] = $doc;
        }

        return $arr;
    }

    protected function pushSent($args) {
        $notifications = $this->mongo->selectCollection('notifications');

        $cursor2 = $notifications->find();

        foreach ($cursor2 as $doc) {
            $arr[] = $doc;
        }
        $notifications->drop();
        return $arr;
    }

    protected function testMon1($args) {
        $location1 = $this->mongo->selectCollection('testTable');
        return $location1->drop();
    }

    /*             ----------------                 HELPER METHODS             ------------------             */

    protected function _createCoupon() {

        $coupOn = $this->_generateRandomString(7);
        $checkPrevCouponQry = "select id from coupons where coupon_code = '" . $coupOn . "' and coupon_type IN (1,3) and user_type = 1";

        $res = mysql_query($checkPrevCouponQry, $this->db->conn);

        if (mysql_num_rows($res) > 0) {
            return $this->_createCoupon();
        } else {
            return $coupOn;
        }
    }

    private function week_start_end_by_date($date, $format = 'Y-m-d') {

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

    /*
     * Method name: _getSlvApptStatus
     * Desc: Get user appointment booking status
     * Input: Slave id
     * Output:  status available
     */

    protected function _getSlvApptStatus($slave) {

        $getApptStatusQry = "select booking_status from slave where slave_id = '" . $slave . "'";
        $getApptStatusres = mysql_query($getApptStatusQry, $this->db->conn);
        return mysql_fetch_assoc($getApptStatusres);
    }

    /*
     * Method name: _updateSlvApptStatus
     * Desc: Update user appointment booking status
     * Input: Slave id and status
     * Output:  true if updated else false
     */

    protected function _updateSlvApptStatus($slave, $status) {

        $getApptStatusQry = "update slave set booking_status = '" . $status . "' where slave_id = '" . $slave . "'";
        mysql_query($getApptStatusQry, $this->db->conn);
        if (mysql_affected_rows() > 0)
            return 0;
        else
            return 1;
    }

    /*
     * Method name: _getDirectionsData
     * Desc: Get google directions data from and to latlongs
     * Input: Keys, form and to latlongs
     * Output:  gives directions details if available else error msg
     */

    protected function _getDirectionsData($from, $to, $key = NULL) {

        if (is_null($key))
            $index = 0;
        else
            $index = $key;

        $keys_all = array('AIzaSyAp_1Skip1qbBmuou068YulGux7SJQdlaw', 'AIzaSyDczTv9Cu9c0vPkLoZtyJuCYPYRzYcx738', 'AIzaSyBZtOXPwL4hmjyq2JqOsd0qrQ-Vv0JtCO4', 'AIzaSyDXdyLHngG-zGUPj7wBYRKefFwcv2wnk7g', 'AIzaSyCibRhPUiPw5kOZd-nxN4fgEODzPgcBAqg', 'AIzaSyB1Twhseoyz5Z6o5OcPZ-3FqFNxne2SnyQ', 'AIzaSyCgHxcZuDslVJNvWxLs8ge4syxLNbokA6c', 'AIzaSyDH-y04IGsMRfn4z9vBis4O4LVLusWYdMk', 'AIzaSyB1Twhseoyz5Z6o5OcPZ-3FqFNxne2SnyQ', 'AIzaSyBQ4dTEeJlU-neooM6aOz4HlqPKZKfyTOc'); //$this->dirKeys;

        $url = 'https://maps.googleapis.com/maps/api/directions/json?origin=' . $from['lat'] . ',' . $from['long'] . '&destination=' . $to['lat'] . ',' . $to['long'] . '&sensor=false&key=' . $keys_all[$index];

        $ch = curl_init();
// Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
// Execute
        $result = curl_exec($ch);

// echo $result->routes;
// Will dump a beauty json :3
        $arr = json_decode($result, true);

        if (!is_array($arr['routes'][0])) {

            $index++;

            $arr['key_arr'] = array('key' => $keys_all[$index], 'index' => $index, 'all' => $keys_all);

            if (count($keys_all) > $index)
                return $this->_getDirectionsData($from, $to, $index);
            else
                return $arr;
        }

        $arr['key_arr'] = array('key' => $keys_all[$index], 'index' => $index, 'all' => $keys_all);

        return $arr;
    }

    /*
     * Method name: _getMasterReviews
     * Desc: Get master reviews with pagination
     * Input: Master email, page number
     * Output:  gives review details if available else error msg
     */

    protected function _getMasterReviews($args) {

        $pageNum = (int) $args['ent_page'];
        $reviewsArr = array();

        if ($args['ent_page'] == '')
            $pageNum = 1;

        $lowerLimit = ($this->reviewsPageSize * $pageNum) - $this->reviewsPageSize;
        $upperLimit = $this->reviewsPageSize * $pageNum;

        $selectReviewsQry = "select rev.mas_id,rev.slave_id,rev.review_dt,rev.star_rating,rev.review,(select count(*) from master_ratings where mas_id = rev.mas_id) as total_rows,(select first_name from slave where slave_id = rev.slave_id) as slave_name,d.profile_pic from slave_ratings rev,master d where d.email = '" . $args['ent_dri_email'] . "' and d.mas_id = rev.mas_id and rev.status = 1 order by rev.star_rating DESC limit $lowerLimit,$upperLimit";
        $selectReviewsRes = mysql_query($selectReviewsQry, $this->db->conn);

        if (mysql_num_rows($selectReviewsRes) <= 0)
            return $this->_getStatusMessage(28, $selectReviewsQry);

        while ($review = mysql_fetch_assoc($selectReviewsRes)) {
            $reviewsArr[] = array('docPic' => $review['profile_pic'], 'rating' => $review['star_rating'], 'review' => $review['review'], 'by' => $review['slave_name'], 'dt' => $review['review_dt'], 'total' => $review['total_rows']);
        }
        return $reviewsArr;
    }

    /*
     * Method name: _validate_token
     * Desc: Authorizes the user with token provided
     * Input: Token
     * Output:  gives entity details if available else error msg
     */

    protected function _validate_token($ent_sess_token, $ent_dev_id, $user_type, $extra = NULL) {

        if ($ent_sess_token == '' || $ent_dev_id == '') {

            return $this->_getStatusMessage(1, 101);
        } else {

            $sessDetArr = $this->_getSessDetails($ent_sess_token, $ent_dev_id, $user_type, $extra);
//            print_r($sessDetArr);
            if ($sessDetArr['flag'] == '0') {
                $this->_updateActiveDateTime($sessDetArr['entityId'], $user_type);
                $this->User = $sessDetArr;
            } else if ($sessDetArr['flag'] == '3') {
                return $this->_getStatusMessage($sessDetArr['errNum'], 999);
            } else if ($sessDetArr['flag'] == '1') {
                $this->User = $sessDetArr;
                return $this->_getStatusMessage(6, 102);
            } else {
                return $this->_getStatusMessage(7, $sessDetArr);
            }
        }
    }

    /*
     * Method name: _checkEntityLogin
     * Desc: Checks the unique id with the authentication type
     * Input: Unique id and the auth type
     * Output:  entity details if true, else false
     */

    protected function _checkEntityLogin($id, $auth_type) {

        $checkFBIdQry = "select ent.Entity_Id as entId,edet.Profile_Pic_Url,ent.Create_Dt,ent.Status from entity ent,entity_details edet where ent.Entity_Id = edet.Entity_Id and ent.Unique_Identifier = '" . $id . "' and ent.authType = '" . $auth_type . "'";
        $checkFBIdRes = mysql_query($checkFBIdQry, $this->db->conn);

        if (mysql_num_rows($checkFBIdRes) == 1) {

            $userDet = mysql_fetch_assoc($checkFBIdRes);

            if ($userDet['Profile_Pic_Url'] == "")
                $userDet['Profile_Pic_Url'] = $this->default_profile_pic;

            return array('flag' => '1', 'entityId' => $userDet['entId'], 'profilePic' => $userDet['Profile_Pic_Url'], 'joined' => $userDet['Create_Dt'], 'status' => $userDet['Status'], 'test' => $checkFBIdQry);
        } else {

            return array('flag' => '0', 'test' => $checkFBIdQry);
        }
    }

    /*
     * Method name: _getDeviceTypeName
     * Desc: Returns device name using device type id
     * Input: Device type id
     * Output:  Array with Device type name if true, else false
     */

    protected function _getDeviceTypeName($devTypeId) {

        $getDeviceNameQry = "select name from dev_type where dev_id = '" . $devTypeId . "'";
        $devNameRes = mysql_query($getDeviceNameQry, $this->db->conn);
        if (mysql_num_rows($devNameRes) > 0) {

            $devNameArr = mysql_fetch_assoc($devNameRes);
            return array('flag' => true, 'name' => $devNameArr['name']);
        } else {

            return array('flag' => false);
        }
    }

    /*
     * Method name: _verifyEmail
     * Desc: Checks email for uniqueness
     * Input: Email id to be checked
     * Output:  true if available else false
     */

    protected function _verifyEmail($email, $field, $table) {

        $searchEmailQry = "select $field,status from $table where email = '" . $email . "'";
        $searchEmailRes = mysql_query($searchEmailQry, $this->db->conn);

        if (mysql_num_rows($searchEmailRes) > 0)
            return mysql_fetch_assoc($searchEmailRes);
        else
            return false;
    }

    /*
     * Method name: _getStatusMessage
     * Desc: Get details of an error from db
     * Input: Error number that need details
     * Output:  Returns an array with error details
     */

    protected function _getStatusMessage($errNo, $test_num) {

        $msg = new getErrorMsg($errNo);
        return array('errNum' => $msg->errId, 'errFlag' => $msg->errFlag, 'errMsg' => $msg->errMsg, 'test' => $test_num);
    }

    /*
     * Method name: _getSessDetails
     * Desc: retrieves a session details
     * Input: Object Id, Token and user_type
     * Output: 1 for Success and 0 for Failure
     */

    protected function _getSessDetails($token, $device_id, $user_type, $extra = NULL) {

        if ($user_type == '1')
            $getDetQry = "select  us.oid, us.expiry, us.device, us.type, us.loggedIn, us.sid,doc.first_name,doc.last_name,doc.profile_pic,doc.email,doc.stripe_id,doc.mobile,doc.workplace_id,doc.status from user_sessions us, master doc where us.oid = doc.mas_id and us.token = '" . $token . "' and us.device = '" . $device_id . "' and us.user_type = '" . $user_type . "'"; // and us.loggedIn = 1
        else if ($user_type == '2')
            $getDetQry = "select  us.oid, us.expiry, us.device, us.type, us.loggedIn, us.sid,pat.first_name,pat.last_name,pat.profile_pic,pat.email,pat.stripe_id,pat.phone,pat.status as mobile from user_sessions us, slave pat where us.oid = pat.slave_id and us.token = '" . $token . "' and us.device = '" . $device_id . "' and us.user_type = '" . $user_type . "'"; // and us.loggedIn = 1
//echo $getDetQry;
        $getDetRes = mysql_query($getDetQry, $this->db->conn);

        if (mysql_num_rows($getDetRes) > 0) {

            $sessDet = mysql_fetch_assoc($getDetRes);
//print_r($sessDet);

            if ($sessDet['loggedIn'] == '2')
                return array('flag' => '2', 'test' => $getDetQry);
            else if ($sessDet['loggedIn'] == '3')
                return array('flag' => '3', 'errNum' => 96);

            if ($sessDet['profile_pic'] == "")
                $sessDet['profile_pic'] = $this->default_profile_pic;

            if ($extra == NULL)
                if ($sessDet['status'] == '4')
                    return array('flag' => '3', 'errNum' => 94);
                else if ($sessDet['status'] == '2' || $sessDet['status'] == '1')
                    return array('flag' => '3', 'errNum' => 10);

            if ($sessDet['expiry'] > $this->curr_date_time)
                return array('flag' => '0', 'sid' => $sessDet['sid'], 'entityId' => $sessDet['oid'], 'deviceId' => $sessDet['device'], 'deviceType' => $sessDet['type'], 'firstName' => $sessDet['first_name'], 'last_name' => $sessDet['last_name'], 'pPic' => $sessDet['profile_pic'], 'email' => $sessDet['email'], 'stripe_id' => $sessDet['stripe_id'], 'mobile' => $sessDet['mobile'], 'workplaceId' => $sessDet['workplace_id']); // 'currLat' => $sessDet['Current_Lat'], 'currLong' => $sessDet['Current_Long'],
            else
                return array('flag' => '1', 'entityId' => $sessDet['oid']);
        } else {
            return array('flag' => '2', 'test' => $getDetQry);
        }
    }

    /*
     * Method name: _checkSession
     * Desc: Check a session details
     * Input: Object Id, Token and user_type
     * Output: returns array of updated session details or new session details
     */

    protected function _checkSession($args, $oid, $user_type, $device_name, $workplaceArr = NULL) {

        $token_obj = new ManageToken();

        if ($user_type == '1') {
            $checkUserSessionQry = "select sid, token, expiry,device from user_sessions where oid = '" . $oid . "' and user_type = '" . $user_type . "' and loggedIn = '1'"; // and device != '" . $args['ent_dev_id'] . "'

            $checkUserSessionRes = mysql_query($checkUserSessionQry, $this->db->conn);

            $num = mysql_num_rows($checkUserSessionRes);

            $res = mysql_fetch_assoc($checkUserSessionRes);

            if ($num == 1 && $res['device'] == $args['ent_dev_id']) {
                return $token_obj->updateSessToken($oid, $args['ent_dev_id'], $args['ent_push_token'], $user_type, $this->curr_date_time);
            } else if ($num >= 1 && $res['device'] != $args['ent_dev_id']) {
                $deleteAllOtherSessionsQry = "update user_sessions set loggedIn = '2' where user_type = '" . $user_type . "' and oid = '" . $oid . "'";
                mysql_query($deleteAllOtherSessionsQry, $this->db->conn);

                if (is_array($workplaceArr)) {
                    $updateWorkplaceQry = "update workplace set Status = 2,last_logout_lat = '" . $workplaceArr['lat'] . "',last_logout_long = '" . $workplaceArr['lng'] . "' where workplace_id = '" . $workplaceArr['workplaceId'] . "'";
                    mysql_query($updateWorkplaceQry, $this->db->conn);
                }

                return $token_obj->createSessToken($oid, $device_name, $args['ent_dev_id'], $args['ent_push_token'], $user_type, $this->curr_date_time);
//                return $this->_getStatusMessage(13, 108);
            } else {
                return $token_obj->createSessToken($oid, $device_name, $args['ent_dev_id'], $args['ent_push_token'], $user_type, $this->curr_date_time);
            }
        } else {

            $checkUserSessionQry = "select sid, token, expiry from user_sessions where oid = '" . $oid . "' and device = '" . $args['ent_dev_id'] . "' and user_type = '" . $user_type . "'";
            $checkUserSessionRes = mysql_query($checkUserSessionQry, $this->db->conn);

            if (mysql_num_rows($checkUserSessionRes) == 1)
                return $token_obj->updateSessToken($oid, $args['ent_dev_id'], $args['ent_push_token'], $user_type, $this->curr_date_time);
            else
                return $token_obj->createSessToken($oid, $device_name, $args['ent_dev_id'], $args['ent_push_token'], $user_type, $this->curr_date_time);
        }
    }

    /*
     * Method name: _getEntityDet
     * Desc: Gives facebook id for entity id 
     * Input: Request data, entity_id
     * Output: entity details for success or error array
     */

    protected function _getEntityDet($eid, $userType) {

        if ($userType == '1')
            $getEntityDetQry = "select profile_pic,first_name,last_name,mas_id,workplace_id,stripe_id from master where email = '" . $eid . "'";
        else
            $getEntityDetQry = "select profile_pic,first_name,slave_id,last_name,email,stripe_id from slave where email = '" . $eid . "'";

        $getEntityDetRes = mysql_query($getEntityDetQry, $this->db->conn);

        if (mysql_num_rows($getEntityDetRes) > 0) {

            $det = mysql_fetch_assoc($getEntityDetRes);

            if ($det['profile_pic'] == '')
                $det['profile_pic'] = $this->default_profile_pic;

            return $det;
        } else {
            return false;
        }
    }

    /*
     * Method name: _sendPush
     * Desc: Divides the tokens according to device type and sends a push accordingly
     * Input: Request data, entity_id
     * Output: 1 - success, 0 - failure
     */

    protected function _sendPush($senderId, $recEntityArr, $message, $notifType, $sname, $datetime, $user_type, $aplContent, $andrContent, $user_device = NULL) {

        $entity_string = '';
        $aplTokenArr = array();
        $andiTokenArr = array();
        $return_arr = array();

        $notifications = $this->mongo->selectCollection('notifications');

        foreach ($recEntityArr as $entity) {

            $entity_string = $entity . ',';
        }

        $entity_comma = rtrim($entity_string, ',');
//echo '--'.$entity_comma.'--';

        $device_check = '';
        if ($user_device != NULL)
            $device_check = " and device = '" . $user_device . "'";

        $getUserDevTypeQry = "select distinct type,push_token from user_sessions where oid in (" . $entity_comma . ") and loggedIn = '1' and user_type = '" . $user_type . "' and LENGTH(push_token) > 63" . $device_check;
        $getUserDevTypeRes = mysql_query($getUserDevTypeQry, $this->db->conn);

        if (mysql_num_rows($getUserDevTypeRes) > 0) {

            while ($tokenArr = mysql_fetch_assoc($getUserDevTypeRes)) {

                if ($tokenArr['type'] == 1)
                    $aplTokenArr[] = $tokenArr['push_token'];
                else if ($tokenArr['type'] == 2)
                    $andiTokenArr[] = $tokenArr['push_token'];
            }

            $aplTokenArr = array_values(array_filter(array_unique($aplTokenArr)));
            $andiTokenArr = array_values(array_filter(array_unique($andiTokenArr)));
//            print_r($andiTokenArr);
            if (count($aplTokenArr) > 0)
                $aplResponse = $this->_sendApplePush($aplTokenArr, $aplContent, $user_type);

            if (count($andiTokenArr) > 0)
                $andiResponse = $this->_sendAndroidPush($andiTokenArr, $andrContent, $user_type);

            foreach ($recEntityArr as $entity) {

                $ins_arr = array('notif_type' => (int) $notifType, 'sender' => (int) $senderId, 'reciever' => (int) $entity, 'message' => $message, 'notif_dt' => $datetime, 'apl' => $aplTokenArr, 'andr' => $andiTokenArr); //'aplTokens' => $aplTokenArr, 'andiTokens' => $andiTokenArr, 'andiRes' => $andiResponse, 

                $notifications->insert($ins_arr);

                $newDocID = $ins_arr['_id'];

                $return_arr[] = array($entity => $newDocID);
            }

            $return_arr[] = $aplResponse;
            $return_arr[] = $aplTokenArr;
            $return_arr[] = $recEntityArr;

            if ($aplResponse['errorNo'] != '')
                $errNum = $aplResponse['errorNo'];
            else if ($andiResponse['errorNo'] != '')
                $errNum = $andiResponse['errorNo'];
            else
                $errNum = 46;

            return array('insEnt' => $return_arr, 'errNum' => $errNum, 'andiRes' => $andiResponse);
        } else {
            return array('insEnt' => $return_arr, 'errNum' => 45, 'andiRes' => $andiResponse); //means push not sent
        }
    }

    protected function _sendApplePush($tokenArr, $aplContent, $user_type) {

        $pushwoosh = new PushWoosh();

        $title = $aplContent['alert'];

        unset($aplContent['alert']);

        if ($user_type == '1')
            $pushReturn = $pushwoosh->pushDriver($title, $aplContent, $tokenArr);
        else
            $pushReturn = $pushwoosh->pushPassenger($title, $aplContent, $tokenArr);

        if ($pushReturn['info']['http_code'] == 200)
            return array('errorNo' => 44, 't' => $aplContent, 'tok' => $tokenArr, 'ret' => $pushReturn);
        else
            return array('errorNo' => 46);

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->ios_cert_path);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->ios_cert_pwd);

        $apns_fp = stream_socket_client($this->ios_cert_server, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if ($apns_fp) {


            $body['aps'] = $aplContent;

            $payload = json_encode($body);

            $msg = '';
            foreach ($tokenArr as $token) {
                $msg .= chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;
            }

            $result = fwrite($apns_fp, $msg, strlen($msg));

            if (!$result)
                return array('errorNo' => 46);
            else
                return array('errorNo' => 44);
        } else {
            return array('errorNo' => 30, 'error' => $errstr);
        }
    }

    protected function _sendAndroidPush($tokenArr, $andrContent, $user_type) {

//        print_r($tokenArr);
//        $pushwoosh = new PushWoosh();
//
//        $title = $andrContent['payload'];
//
//        unset($andrContent['payload']);
//
//        if ($user_type == '1')
//            $pushReturn = $pushwoosh->pushDriver($title, $andrContent, $tokenArr);
//        else
//            $pushReturn = $pushwoosh->pushPassenger($title, $andrContent, $tokenArr);
//
//        if ($pushReturn['info']['http_code'] == 200)
//            return array('errorNo' => 44, 't' => $andrContent, 'tok' => $tokenArr, 'ret' => $pushReturn);
//        else
//            return array('errorNo' => 46);

        $fields = array(
            'registration_ids' => $tokenArr,
            'data' => $andrContent,
        );

        if ($user_type == '1')
            $apiKey = $this->masterApiKey;
        else
            $apiKey = $this->slaveApiKey;

        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );
// Open connection
        $ch = curl_init();

// Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $this->androidUrl);

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
            return array('errorNo' => 44, 'result' => $tokenArr, 'key' => $apiKey);
        else
            return array('errorNo' => 46, 'result' => $tokenArr);
    }

    /*
     * method name: generateRandomString
     * Desc: Generates a random string according to the length of the characters passed
     * Input: length of the string
     * Output: Random string
     */

    protected function _generateRandomString($length) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    protected function _updateActiveDateTime($entId, $user_type) {

        if ($user_type == '1')
            $updateQry = "update master set last_active_dt = '" . $this->curr_date_time . "' where mas_id = '" . $entId . "'";
        else if ($user_type == '2')
            $updateQry = "update slave set last_active_dt = '" . $this->curr_date_time . "' where slave_id = '" . $entId . "'";

        mysql_query($updateQry, $this->db->conn);

        if (mysql_affected_rows() > 0)
            return true;
        else
            return false;
    }

    /*
     * Method name: _check_zip
     * Desc: Authorizes the user with token provided
     * Input: Zipcode
     * Output:  gives entity details if available else error msg
     */

    protected function _check_zip($zip_code) {

        $selectZipQry = "select zipcode from zipcodes where zipcode = '" . $zip_code . "'";
        $selectZipRes = mysql_query($selectZipQry, $this->db->conn);
        if (mysql_num_rows($selectZipRes) > 0)
            return true;
        else
            return false;
    }

    protected function testUpdateLoc($args) {

        $location = $this->mongo->selectCollection('location');

        if ($args['ent_lat'] != '' && $args['ent_long'] != '')
            $setArr['location'] = array('longitude' => (float) $args['ent_long'], 'latitude' => (float) $args['ent_lat']);

        if ($args['ent_status'] != '')
            $setArr['status'] = (int) $args['ent_status'];

        $data = $location->findOne(array("user" => (int) $args['ent_doc']));

        $setArr['email'] = strtolower($data['email']);

        $newdata1 = array('$set' => $setArr);

        $location->update(array("user" => (int) $args['ent_doc']), $newdata1);

        $cursor2 = $location->find(array("user" => (int) $args['ent_doc']));

        foreach ($cursor2 as $doc) {
            var_dump($doc);
        }
    }

    /*
     * Method name: testIosPush
     * Desc: To test push for apple
     * Input: Request data
     * Output:  success if sent, else error message
     */

    protected function testIosPush($args) {

        if ($_FILES['ent_ios_cer'] == '' || $args['ent_cer_pass'] == '' || $args['ent_message'] == '' || $args['ent_push_token'] == '')
            return $this->_getStatusMessage(1, 58);

        $allowedExts = array("pem");
        $_FILES["file"] = $_FILES['ent_ios_cer'];

        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
        if (in_array($extension, $allowedExts)) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Error: " . $_FILES["file"]["error"] . "<br>";
            } else {

                if (file_exists("test/" . $_FILES["file"]["name"]))
                    unlink($_FILES["file"]["name"]);

                move_uploaded_file($_FILES["file"]["tmp_name"], "test/" . $_FILES["file"]["name"]);
                echo $_FILES["file"]["name"] . " -->Stored";

                $this->ios_cert_path = "test/" . $_FILES["file"]["name"];
                $this->ios_cert_pwd = $args['ent_cer_pass'];

                if ($args['ent_cer_type'] == '1')
                    $this->ios_cert_server = "ssl://gateway.sandbox.push.apple.com:2195";
                else
                    $this->ios_cert_server = "ssl://gateway.push.apple.com:2195";


                echo 'Path:' . $this->ios_cert_path . ',Pwd:' . $this->ios_cert_pwd . ',Server:' . $this->ios_cert_server;

                $tokenArr = array($args['ent_push_token']);

                print_r($tokenArr);

                $return_res = $this->_sendApplePush($tokenArr, array('alert' => $args['ent_message']));
                print_r($return_res);
                if ($return_res['errorNo'] == 44)
                    return array('push' => 'sent');
                else if ($return_res['errorNo'] == 30)
                    return array('error' => "Connection failed", 'msg' => $return_res['error']);
                else
                    return array('push' => 'failed');
            }
        } else {
            return array('error' => "Please provice a .pem file");
        }
    }

    public function testBooking($args) {
        $insertAppointmentQry = "insert into appointment(mas_id,slave_id,created_dt,last_modified_dt,status,appointment_dt,address_line1,address_line2,appt_lat,appt_long,drop_addr1,drop_addr2,drop_lat,drop_long,extra_notes,amount,zipcode) 
            values('1','1','2014-05-21 20:25:00','2014-05-21 20:25:00','1',
                '2014-05-21 20:25:00','4, 4th Main Rd, Chamundi Nagar, Hebbal','Hebbal','13.0317',
                '77.5992','730, 6th B Cross Rd, Koramangala 3 Block, Koramangala','Koramangala','13.031747',
                '77.59919','Testing','200','90210')";

        mysql_query($insertAppointmentQry, $this->db->conn);

        $apptId = mysql_insert_id();

        if ($apptId <= 0)
            return $this->_getStatusMessage(3, $insertAppointmentQry);

        $message = "You got an live appointment request on " . $this->appName . "!";

        $this->ios_cert_path = $this->ios_roadyo_driver;
        $this->ios_cert_pwd = $this->ios_dri_pwd;
        $aplPushContent = array('alert' => $message, 'nt' => '7', 'sname' => 'Varun', 'dt' => '2014-05-21 20:25:00', 'e' => 'varun13@gmail.com', 'sound' => 'default');
        $andrPushContent = array("payload" => $message, 'action' => '7', 'sname' => 'Varun', 'dt' => '2014-05-21 20:25:00', 'e' => 'varun13@gmail.com');
        $pushNum['push'] = $this->_sendPush('1', array(1), $message, '7', 'Varun', '2014-05-21 20:25:00', '1', $aplPushContent, $andrPushContent);

        return array('message' => 'sent', $pushNum);
    }

    public function logoutAllDrivers($args) {
        $insertAppointmentQry = "delete from user_sessions where user_type = 1";

        mysql_query($insertAppointmentQry, $this->db->conn);

        $location = $this->mongo->selectCollection('location');

        $masterDet = $location->update(array(), array('$set' => array('status' => 4)), array('multi' => 1));

        return array('message' => $masterDet);
    }

    public function checkAvlblCarsInCompany($args) {
        $getCarsQry = "select w.workplace_id,(select type_name from workplace_types where type_id = w.type_id) as type_name from workplace w where w.company = '" . $args['ent_comp_id'] . "' and w.status IN (2,3)";
        $getCarsRes = mysql_query($getCarsQry, $this->db->conn);

        $cars = array();

        while ($car = mysql_fetch_assoc($getCarsRes)) {
            $cars[] = array('carId' => $car['workplace_id'], 'type' => $car['type_name']);
        }
        return array('available_car_ids' => $cars);
    }

    protected function testPushWoosh($args) {
        return $this->_sendApplePush(array($args['token']), array('alert' => $args['message'], 't' => 1, 'sound' => 'default'), $args['type']);
    }

}

if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {

    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {

//    echo json_encode(array('errMsg' => 'Server is under maintainance, will get back in few minutes..!', 'errNum' => 999, 'errFlag' => 1));
//    return false;

    $API = new MyAPI($_SERVER['REQUEST_URI'], $_REQUEST, $_SERVER['HTTP_ORIGIN']);

    echo $API->processAPI();
} catch (Exception $e) {

    echo json_encode(Array('error' => $e->getMessage()));
}
?>
