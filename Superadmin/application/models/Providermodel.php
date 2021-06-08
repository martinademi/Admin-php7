<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

//require_once 'superModel/S3.php';
//require_once 'superModel/StripeModuleNew.php';
//require_once 'superModel/AwsPush.php';

class Providermodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
//        $this->load->database();
        $this->load->library('mongo_db');
        $this->load->library('CallAPI');
        date_default_timezone_set('Asia/Kolkata');
    }

    function datatable_provider($for = '', $status = '') {


        $this->load->library('Datatables');
        $this->load->library('table');
        if ($for == 'my') {
            switch ($status) {
                case 1:$cond = array('status' => 1);
                    break;
                case 3:$cond = array('status' => array('$in' => [2, 3, 4]));
                    break;
                case 4:$cond = array('status' => 6);
                    break;
            }
        } else if ($for == 'mo') {
            if ($status == 3) { //online or free
                $respo = $cond = array('status' => 3);
            } else if ($status == 567) {//logged out
                $respo = $cond = array('status' => 4, 'loggedIn' => FALSE);
            } elseif ($status == 30) {//OFFLINE
                $respo = $cond = array('status' => 4, 'loggedIn' => TRUE);
            }
        }
        $datatosend1 = $this->mongo_db->where($cond)->get('driver');

        $slno = 0;
        foreach ($datatosend1 as $pro) {
            if ($pro['location']['latitude'] === 0)
                $elapsed = '';
            else {
                if ($pro['lastTs'] != NULL || $pro['lastTs'] != '') {
                    $time = (int) (time() - $pro['lastTs']);
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

         
            $LatLong = number_format($pro['location']['latitude'], 6) . ', ' . number_format($pro['location']['longitude'], 6) . $elapsed;

            $link = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $pro['_id']['$oid'] . '">';
            $profile = "<a href='" . base_url() . "index.php?/provider/profile/" . $pro['_id']['$oid'] . "'>" . $pro['firstName'] . "</a>";
//            $img ='<img src="'.$pro['image'].'" width="50px" height="50px" class="imageborder" onerror="this.src=\'' . base_url() . 'pics/user.jpg\'">';
            $arr[] = array(++$slno, $profile, $pro['countryCode'] .'-'. $pro['mobile'],($pro['type']== '' || null)?"N/A":$pro['type'],date('d-F-Y',strtotime($pro['createdDt'])), $LatLong, $link);
        }
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
    }

    function getDriversCount() {
        $data['New'] = $this->mongo_db->where(array('status' => 1))->count('driver');
        $data['Accepted'] = $this->mongo_db->where_in('status', array(2, 3, 4, 5))->count('driver');
        $data['Rejepted'] = $this->mongo_db->where(array('status' => 6))->count('driver');
        $data['Online'] = $this->mongo_db->where(array('status' => 3))->count('driver');
        $data['offline'] = $this->mongo_db->where(array('status' => 4, 'loggedIn' => TRUE))->count('driver');
        $data['loggedOut'] = $this->mongo_db->where(array('status' => 4, 'loggedIn' => FALSE))->count('driver');

        echo json_encode(array('data' => $data));
        return;
    }

    function getCityList() {
        $getAll = $this->mongo_db->get('cities');
        return $getAll;
    }

    function getCatbyCity() {
        $id = $this->input->post('id');
        $cursor = $this->mongo_db->where(array('city_id' => $id))->get('category');
        $type = array();
        foreach ($cursor as $cur) {
            $sub = $this->mongo_db->where(array('cat_id' => $cur['_id']['$oid']))->get('subCategory');
            $type[] = array('cat_id' => $cur['_id']['$oid'], 'cat_name' => $cur['cat_name'], 'sub_cat' => $sub);
        }
        echo json_encode(array('Fixed' => $type));
        return;
    }

    function getAllCatforPro() {
        $id = $this->input->post('val');
        $pData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->find_one('driver');

        $cData = $this->mongo_db->where(array('city_id' => $pData['cityId']))->get('Category');
        $dataarr = array();
        $catarr = array();
        foreach ($cData as $cat) {
            $catarr[] = array('id' => $cat['_id']['$oid'], 'cat_name' => $cat['cat_name']);
        }
        $type = array();
        foreach ($pData['catlist'] as $cat) {
            foreach ($catarr as $ccat) {
                if ($ccat['id'] == $cat['cid']) {
                    $subaarr = array();
                    if ($pData['subCatlist']) {
                        foreach ($pData['subCatlist'] as $scat) {
                            $pdatas = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($scat['sub_cid'])))->find_one('subCategory');
                            if ($pdatas['cat_id'] == $cat['cid']) {
                                $subaarr[] = array('sub_cid' => $pdatas['_id']['$oid'], 'sub_cat_name' => $pdatas['sub_cat_name']);
                            }
                        }
                    }
                    $dataarr[] = array('id' => $ccat['id'], 'cat_name' => $ccat['cat_name'], 'subcat' => $subaarr);
                }
            }
        }
        echo json_encode(array('catarr' => $dataarr, 'cityName' => $City_Name->City_Name));
        return;
    }

    function AddNewDriverData() {

        $field = $this->input->post('field');



        $city_id = $this->input->post('city_id');
        $account_type = (int) $this->input->post('driverType');
        $company_id = $this->input->post('company_select');
        $operatorName = $this->input->post('operatorName');
        $firstname = $this->input->post('firstname');
        $last_name = $this->input->post('lastname');
        $date_of_birth = date('Y-m-d', strtotime($this->input->post('dob')));
        $profile_pic = $this->input->post('driverImage');
        $email = $this->input->post('email');
        $countryCode = '+' . $this->input->post('coutry-code');
        $mobile = $this->input->post('mobile');
        $password = $this->input->post('paswordEncrypted');
        $created_dt = $this->input->post('current_dt');

        $radius = (int) 10;
        $status = (int) 1;
        $token = (int) 0;
        $catArr = explode(",", $this->input->post('catArr'));
        $sel_cat = array();
        foreach ($catArr as $type) {
            $sel_cat[] = array('cid' => $type, 'status' => 0);
        }
        $subcatArr = explode(",", $this->input->post('subCatArr'));
        $sub_cat = array();
        foreach ($subcatArr as $type) {
            $sub_cat[] = array('sub_cid' => $type, 'status' => 0);
        }
        $date = new DateTime();
        
        $phonearr[] = array('countryCode' => $countryCode, 'phone' => $mobile, 'is_Currently_Active' => true);
        $address = $this->input->post('address');
        $add_city = $this->input->post('add_city');
        $add_state = $this->input->post('add_state');
        $add_zip = $this->input->post('add_zip');
        $about = $this->input->post('about');
        $lanKnow = $this->input->post('lanKnow');
        $experties = $this->input->post('experties');
        $mongoArr = array(
            "cityId" => $city_id,
            'catlist' => $sel_cat,
            'subCatlist' => $sub_cat,
            'companyId' => new MongoDB\BSON\ObjectID($this->input->post('company_select')),
            'companyName' => $operatorName,
            'accountType' => (int) $this->input->post('driverType'),
            "firstName" => $firstname,
            "lastName" => $last_name,
            "location" => array("longitude" => 0, "latitude" => 0),
            'dob' => $date_of_birth,
            "image" => $this->input->post('driverImage'),
            'status' => 1,
            'phone' => $phonearr,
            'email' => strtolower($email),
            'password' => $password,
            'radius' => $radius,
            'token' => $token,
            'createdDt' => $date->getTimestamp(),
            'document' => $document,
            'address' => $address, 'add_city' => $add_city, 'add_state' => $add_state, 'add_zip' => $add_zip, 'about' => $about, 'lanKnow' => $lanKnow, 'experties' => $experties
        );

        $res = $this->mongo_db->insert('driver', $mongoArr);
        $url = APILink . 'admin/email';
        $r = $this->callapi->CallAPI('POST', $url, array('userType' => 2, 'id' => $res, 'type' => 1));
        foreach ($field as $key => $value) {
            $document[] = array('fid' => $key, 'data' => $value);
        }
        $docArr = array(
            'master_id' => new MongoDB\BSON\ObjectID($res),
            'Fields' => $document
        );
        $res = $this->mongo_db->insert('Documents', $docArr);

        return true;
    }
                
    function editproviderdata() {



        $driverid = $this->input->post('driver_id');


        $account_type = $this->input->post('driverType');
        $first_name = $this->input->post('firstname');
        $last_name = $this->input->post('lastname');
        $password = $this->input->post('password');
        $address = $this->input->post('address');
        $add_city = $this->input->post('add_city');
        $add_state = $this->input->post('add_state');
        $add_zip = $this->input->post('add_zip');
        $about = $this->input->post('about');
        $lanKnow = $this->input->post('lanKnow');
        $experties = $this->input->post('experties');

        $email = $this->input->post('email');
        $dob = date('Y-m-d', strtotime($this->input->post('dob')));
        $mobile = $this->input->post('mobile');
        $countryCode = '+' . $this->input->post('coutry-code');

        $cond = array('_id' => new MongoDB\BSON\ObjectID($driverid));

        $pData = $this->mongo_db->where($cond)->find_one('driver');
        $phoneNumber = array();
        foreach ($pData['phone'] as $val) {
            if ($val['phone'] != $mobile) {
                $val['is_Currently_Active'] = false;
                array_push($phoneNumber, $val);
            }
        }
        $phn = array('countryCode' => $countryCode, 'phone' => $mobile, 'is_Currently_Active' => true);
        array_push($phoneNumber, $phn);


        $profile_pic = $this->input->post('driverImage');
        if ($profile_pic != '')
            $mongoArr = array('dob' => $dob, 'phone' => $phoneNumber, 'accountType' => (int) $account_type, "firstName" => $first_name, "lastName" => $last_name, "image" => $profile_pic, 'address' => $address, 'add_city' => $add_city, 'add_state' => $add_state, 'add_zip' => $add_zip, 'about' => $about, 'lanKnow' => $lanKnow, 'experties' => $experties);
        else
            $mongoArr = array('dob' => $dob, 'phone' => $phoneNumber, 'accountType' => (int) $account_type, "firstName" => $first_name, "lastName" => $last_name, 'address' => $address, 'add_city' => $add_city, 'add_state' => $add_state, 'add_zip' => $add_zip, 'about' => $about, 'lanKnow' => $lanKnow, 'experties' => $experties);
//        print_r($mongoArr);die;
        if ($license_pic != '')
            $mongoArr['driverLicense'] = $license_pic;


        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($driverid)))->set($mongoArr)->update('driver');
        return true;
    }

    function save_driver_data() {
        $driverid = $this->input->post('mas_id');
        $fdata = $this->input->post('fdata');
        $radius = (int) $this->input->post('radius');
        $status = 0;
        if ($this->input->post('profileStatus') == 'on')
            $status = 1;
        $fdata['profileStatus'] = $status;
        $fdata['radius'] = $radius;

        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($driverid)))->set($fdata)->update('driver');
        echo json_encode(array('msg' => "Selected provider data save succesfully", 'flag' => 0));
        return true;
    }

    function save_rate_data() {
        $mins = $this->input->post('mins');
        $price = (int) $this->input->post('price');
        $slot_id = $this->input->post('slot_id');
        if ($slot_id) {
            $this->mongo_db->where(array('rateCard.slot_id' => new MongoDB\BSON\ObjectID($slot_id)))->pull('rateCard', array('slot_id' => new MongoDB\BSON\ObjectID($slot_id)))->update('driver');
        }
        $push_date = array('slot_id' => new MongoDB\BSON\ObjectID(),
            'size' => $mins, 'currency' => '$', 'rate' => $price);

        $cond = array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id')));
        $result = $this->mongo_db->where($cond)->push(array('rateCard' => $push_date))->update('driver');
        echo json_encode(array('msg' => "Selected provider data save succesfully", 'flag' => 0));
        return true;
    }

    function get_rate_data() {
        $data = array();
        $cond = array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id')));
        $mData = $this->mongo_db->where($cond)->find_one('driver');
        foreach ($mData['rateCard'] as $val) {
            $val['id'] = $val['slot_id']['$oid'];
            array_push($data, $val);
        }
        echo json_encode(array('msg' => "Selected provider data save succesfully", 'flag' => 0, 'rateCard' => $data));
        return true;
    }

    function editRateCard() {
        $masterid = $this->input->post('id');
        $cond = array('rateCard.slot_id' => new MongoDB\BSON\ObjectID($this->input->post('id')));
        $mData = $this->mongo_db->where($cond)->find_one('driver');
        foreach ($mData['rateCard'] as $val) {
            if ($masterid == $val['slot_id']['$oid']) {
                $id = $val['slot_id']['$oid'];
                $size = $val['size'];
                $rate = $val['rate'];
            }
        }
        echo json_encode(array('msg' => "Selected provider data save succesfully", 'flag' => 0, 'id' => $id, 'size' => $size, 'rate' => $rate));
        return true;
    }

    function deleteRateCard() {
        $masterid = $this->input->post('id');
        $this->mongo_db->where(array('rateCard.slot_id' => new MongoDB\BSON\ObjectID($masterid)))->pull('rateCard', array('slot_id' => new MongoDB\BSON\ObjectID($masterid)))->update('driver');

        echo json_encode(array('msg' => "Selected provider data save succesfully", 'flag' => 0, 'rateCard' => $data));
        return true;
    }

    function acceptProvider() {
        $id = $this->input->post('val');
        $catlist = $this->input->post('catlist');
        $sub = $this->input->post('sub');
        foreach ($catlist as $cat) {
            $sData = array('catlist.$.status' => 1);
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id), 'catlist.cid' => $cat))->set($sData)->update('driver');
        }
        foreach ($sub as $cat) {
            $sData = array('subCatlist.$.status' => 1);
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id), 'catlist.sub_cid' => $cat))->set($sData)->update('driver');
        }

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 2))->update('driver');
        if ($result) {
            echo json_encode(array('msg' => "Selected provider accepted succesfully", 'flag' => 0));
//           $this->sendMailToDriverAfterAccept($email, $firstname);
            return;
        } else
            echo json_encode(array('msg' => "Failed to update", 'flag' => 1));
    }

    function allDocument() {
        $catArr = explode(",", $this->input->post('allCat'));
        $proid = $this->input->post('proid');
        $doc = array();
        foreach ($catArr as $type) {
            $pData = $this->mongo_db->where(array('Service_category_id' => new MongoDB\BSON\ObjectID($type)))->find_one('DocumentType');
            if ($pData)
                array_push($doc, $pData);
        }
        $upload = array();
        if ($proid) {
            $mData = $this->mongo_db->where(array('master_id' => new MongoDB\BSON\ObjectID($proid)))->find_one('Documents');
            if ($mData['Fields'])
                array_push($upload, $mData);
        }

        echo json_encode(array('msg' => "all document", 'flag' => 0, 'doc' => $doc, 'upload' => $upload));
    }

    function editprovider($status = '') {
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($status)))->find_one('driver');
        return $data;
    }

    function deleteProvider() {
        $this->load->library('mongo_db');
        $masterid = $this->input->post('masterid');
        $affectedRows = 0;

        foreach ($masterid as $id)
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('driver');

        echo json_encode(array("msg" => "Selected driver has been deleted successfully", "flag" => 0));
        return;
    }
    function rejectdrivers() {
        $this->load->library('mongo_db');
        $val = $this->input->post('val');

        foreach ($val as $mas_ids)
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($mas_ids)))->set(array('status' => 6, 'rejectedOn' => (int) $this->input->post('date')))->update('provider');

        if ($result) {
            echo json_encode(array('msg' => "Selected driver/drivers rejected succesfully", 'flag' => 0));
//                   $this->sendMailToDriverAfterAccept($email, $firstname);
            return;
        } else
            echo json_encode(array('msg' => "Failed to update", 'flag' => 1));
    }

}

?>
