<?php

error_reporting(false);
if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Supperadmin extends CI_Model {

    function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = '3embed softaware technologies';
        $secret_iv = '3embed 123456s';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    function validateSuperAdmin() {

        $this->load->library('mongo_db');

        $testEmail = $this->input->post("email");
        $email = $this->input->post("email");
        $password = $this->input->post("password");       
        $cursor = $this->mongo_db->get_where('MasterData', array('Email' => $email, 'Password' => $password));
        $Email = '';
        foreach ($cursor as $data) {
            $Email = $data['Email'];
            $ProfilePic = $data['ImageUrl'];
            $pass = $data['Password'];
            $MyId = (string) $data['_id'];
            $name = $data['MasterName'];
            if ($Email == $testEmail) {
                $sessiondata = array(
                    'emailid' => $Email,
                    'MasterBizId' => $MyId,
                    'MasterBusinessName' => $name,
                    'validate' => true,
                    'profile_pic' => $ProfilePic,
                    'Currency' => 'SAR',
                    'Admin' => '0'
                );
                $tests = array('fadmin' => $sessiondata);
                $this->session->set_userdata($tests);
//                $this->session->set_userdata($sessiondata);
                return $MyId;
            } else
                return false;
        }
    }

    function changeOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->get_one('Master_ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))));
        $Prevecountval = $this->mongo_db->get_one('Master_ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))));

        $currcount = $Curruntcountval['count'];
        $prevcount = $Prevecountval['count'];

        $this->mongo_db->update('Master_ProductCategory', array('count' => $prevcount), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))));
        $this->mongo_db->update('Master_ProductCategory', array('count' => $currcount), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))));
    }

    function ResetPwd() {
//        die('hi');
        $this->load->library('mongo_db');
        $res = $this->mongo_db->update('ProviderData', $this->input->post("FData"), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("CenterId"))));
//        print_r($res);
        echo json_encode($res);
    }

    function changeSubCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->get_one('Master_ProductSubCategory', array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))));
        $Prevecountval = $this->mongo_db->get_one('Master_ProductSubCategory', array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))));

        $currcount = $Curruntcountval['count'];
        $prevcount = $Prevecountval['count'];

        $this->mongo_db->update('Master_ProductSubCategory', array('count' => $prevcount), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))));
        $this->mongo_db->update('Master_ProductSubCategory', array('count' => $currcount), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))));
    }

    function changeProductCatOrder() {

        $this->load->library('mongo_db');

        $Curruntcountval = $this->mongo_db->get_one('Master_products', array('_id' => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))));
        $Prevecountval = $this->mongo_db->get_one('Master_products', array('_id' => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))));

        $currcount = $Curruntcountval['count'];
        $prevcount = $Prevecountval['count'];

        $this->mongo_db->update('Master_products', array('count' => $prevcount), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("curr_id"))));
        $this->mongo_db->update('Master_products', array('count' => $currcount), array("_id" => new MongoDB\BSON\ObjectID($this->input->post("prev_id"))));
    }

    function get_lan_hlpText($param = '') {
        $this->load->library('mongo_db');
        if ($param == '')
            $res = $this->mongo_db->get('lang_hlp');
        else
            $res = $this->mongo_db->where(array('lan_id' => (int) $param))->find_one('lang_hlp');
        return $res;
    }

    public function getcatdetails() {
        $this->load->library('mongo_db');
        $data = $this->input->post("id");
        $id = "";
//        foreach ($data as $row) {
//            echo $data; exit();
        $cursor = $this->mongo_db->get_one('Master_ProductCategory', array("_id" => new MongoDB\BSON\ObjectID($data)));
        $id = $data;
//        }
//            echo'<pre>';
//     print_r($cursor); exit();
        return $cursor;
    }

    public function getsubcatdetails() {
        $this->load->library('mongo_db');
        $data = $this->input->post("id");
        $id = "";
//        foreach ($data as $row) {
//            echo $data; exit();
        $cursor = $this->mongo_db->get_one('Master_ProductSubCategory', array("_id" => new MongoDB\BSON\ObjectID($data)));
        $id = $data;
//        }
//            echo'<pre>';
//     print_r($cursor); exit();
        return $cursor;
    }

    public function GetCity($cityid = '') {
        $this->load->database();

        $query = $this->db->query("select * from city where City_Id='" . $cityid . "'")->result();
        return $query;
    }

    function SetSeesionFromAdmin($BizId = '') {

        $this->load->library('mongo_db');

        $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($BizId)))->get('Franchise');

        foreach ($cursor as $data) {
            $ProfilePic = $data['ImageUrl'];
            $name = $data['MasterName'];
//            $CityDetails = $this->GetCity($data['City']);
//
//            foreach ($CityDetails as $curr) {
//                $symb = $curr->Currency;
//            }
        }
        $sessiondata = array(
            'MasterBizId' => $BizId,
            'validate' => true,
            'profile_pic' => $ProfilePic,
            'MasterBusinessName' => $name,
            'Currency' => 'SAR',
            'Admin' => '1'
        );

        $fadmin = array('fadmin' => $sessiondata);
        $this->session->set_userdata($fadmin);
    }

    /**
     *
     *  get admin list
     *
     *
     */
    function LoadAdminList() {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_where('Col_Manage_Admin', array('Role' => $this->encrypt_decrypt('encrypt', "Admin")));

        $admins = array();
        $i = 0;
        foreach ($cursor as $data) {
            $data['Fname'] = $this->encrypt_decrypt('decrypt', $data['Fname']);
            $data['Lname'] = $this->encrypt_decrypt('decrypt', $data['Lname']);
            $data['Email'] = $this->encrypt_decrypt('decrypt', $data['Email']);
            $data['Password'] = $this->encrypt_decrypt('decrypt', $data['Password']);
            $data['Type'] = $this->encrypt_decrypt('decrypt', $data['Type']);
            $data['Role'] = $this->encrypt_decrypt('decrypt', $data['Role']);
            $data['Parent'] = $this->encrypt_decrypt('decrypt', $data['Parent']);

            $admins[$i] = $data;
            $i++;
        }

        return $admins;
    }

    /**
     *
     *  get brokers list
     *
     *
     */
    /* function LoadBrokerList(){

      $this->load->library('mongo_db');
      $cursor = $this->mongo_db->get_where('Col_Manage_Admin',array('Role' => "Broker"));
      return $cursor;
      } */

    /**
     *
     *  get dashboard data like total nuber of admin extra
     *
     *
     */
    function get_Dashbord_data($BizId = '') {
        $this->load->library('mongo_db');
//        $cat = $this->mongo_db->count_all_results('Master_ProductCategory', array('BusinessId' => $BizId));
//        $SubCat = $this->mongo_db->count_all_results('Master_ProductSubCategory', array('BusinessId' => $BizId));
//        $Products = $this->mongo_db->count_all_results('Master_products', array('BusinessId' => $BizId));
//        $AddOns = $this->mongo_db->count_all_results('Master_AddOns', array('BusinessId' => $BizId));
//        $AddOns = $this->mongo_db->count_all_results('AddOns', array('Orders' => $BizId,));
//        echo $SubCat;
//        return array('TotalCat' => $cat, 'TotalSubCat' => $SubCat, 'TotalProducts' => $Products, 'TotalAddOns' => $AddOns);
        $tz_date = new DateTime("now", new DateTimeZone('asia/kolkata'));
        $tz_date->format('Y-m-d H:m:s');

        $date = $tz_date->format('Y-m-d H:m:s');
        $dateOnly = $tz_date->format('Y-m-d');
        $SOM = date('Y-m-01') . ' 00:00:01';
        $EOM = date('Y-m-t') . ' 23:59:59';

        $EOW = date("Y-m-d", strtotime(date("Y") . 'W' . date('W') . "7"));
        $SOW = date("Y-m-d", strtotime(date("Y") . 'W' . date('W') . "1")) . ' 00:00:01';
        $SOD = $dateOnly . ' 00:00:01';
        $EOD = $dateOnly . ' 23:59:59';

        $TodayTotalOrders = 0;
        $WeekTotalOrders = 0;
        $MonthTotalOrders = 0;
        $TotalOrders = 0;
//        $TOdayTotalErnings = 0;
//        $WeekTotalErnings = 0;
//        $MonthTotalErnings = 0;
//        $TotalErnings = 0;
        $details = $this->mongo_db->get_where('ProviderData', array('Master' => $BizId));
        foreach ($details as $BizId) {
            $details = $this->mongo_db->get_where('appointment', array('BusinessId' => (string) $BizId['_id']));
            $entities = array();
            foreach ($details as $data) {
                $this->load->database();
                $query = $this->db->query("select * from appointment where status in (9) and  appointment_id='" . $data['appointment_id'] . "' and created_dt>='" . $SOD . "' and created_dt<='" . $EOD . "' order by appointment_id desc")->result();
                foreach ($query as $OrderDta) {
                    $TodayTotalOrders++;
                    //  $TOdayTotalErnings = (double) $TOdayTotalErnings + (double) $OrderDta->amount;
                }
                $query1 = $this->db->query("select * from appointment where status in (9) and  appointment_id='" . $data['appointment_id'] . "' and created_dt>='" . $SOW . "' and created_dt<='" . $EOW . "' order by appointment_id desc")->result();
                foreach ($query1 as $OrderDta) {
                    $WeekTotalOrders++;
                    // $WeekTotalErnings = (double) $WeekTotalErnings + (double) $OrderDta->amount;
                }
                $query2 = $this->db->query("select * from appointment where status in (9) and  appointment_id='" . $data['appointment_id'] . "' and created_dt>='" . $SOM . "' and created_dt<='" . $EOM . "' order by appointment_id desc")->result();
                foreach ($query2 as $OrderDta) {
                    $MonthTotalOrders++;
                    /// $MonthTotalErnings = (double) $MonthTotalErnings + (double) $OrderDta->amount;
                }
                $query3 = $this->db->query("select * from appointment where status in (9) and  appointment_id='" . $data['appointment_id'] . "' order by appointment_id desc")->result();
                foreach ($query3 as $OrderDta) {
                    $TotalOrders++;
                    ///  $TotalErnings = (double) $TotalErnings + (double) $OrderDta->amount;
                }
            }
        }

        return array('TodayTotalOrders' => $TodayTotalOrders,
            'WeekTotalOrders' => $WeekTotalOrders,
            'MonthTotalOrders' => $MonthTotalOrders,
            'TotalOrders' => $TotalOrders, 'SOW' => $SOM, 'EOW' => $EOM);
    }

    public function GetAllCategories($BizId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_where('Master_ProductCategory', array('BusinessId' => $BizId), array('count' => 1));
        $entities = array();
        $i = 0;

        foreach ($cursor as $data) {
            $entities[] = $data;
            $i++;
        }

//        print_r($entities);
        return $entities;
    }

    public function AllProviderCategories() {
        $this->load->library('mongo_db');
//        echo '1';
        $cursor = $this->mongo_db->get('Category');
//           echo '1';
        $entities = array();
        $i = 0;

        foreach ($cursor as $data) {
            $entities[] = $data;
            $i++;
        }
        return $entities;
    }

    public function AllProvidersubCategories() {
        $this->load->library('mongo_db');
//        echo '1';
        $cursor = $this->mongo_db->get('subCategory');
//           echo '1';
        $entities = array();
        $i = 0;

        foreach ($cursor as $data) {
            $entities[] = $data;
            $i++;
        }
        return $entities;
    }

    public function ProviderCategory() {
        $this->load->library('mongo_db');

        $MAsterData = $this->mongo_db->order_by(array('Category' => 1))->get('Category');
        $data = array();

        foreach ($MAsterData as $driver) {
//            $GetMAster = $this->mongo_db->get_one('ProviderData');
            $data[] = array('Categoryname' => $driver['Category'], 'CategoryDescription' => $driver['Description'], 'Categoryid' => new MongoDB\BSON\ObjectID($driver['_id']['$oid']));
        }
        return $data;
    }

    public function getsubcat() {
        $this->load->library('mongo_db');
        $val = $this->input->post('catID');
//           print_r($val);
//               die;
//        foreach ($val as $row) {

        $cursor = $this->mongo_db->where( array("Catid" => $val))->get('subCategory');
//        }

        $entities = '<select multiple class="form-control ui fluid dropdown"  id="subCatId" name="subcat_select[]" >
                                     <option value="">Select Sub-cuisines</option>';
        foreach ($cursor as $d) {

            $entities .= '
                   <option value="' . $d['_id']['$oid'] . '">' . implode($d['Subcategory'], ',') . '</option>';
        }
        $entities .= ' </select>';

        return $entities;
//            echo '<option value="'.$d['_id'].'">'.$d['Subcategory'].'</option>';
//        print_r($d); exit();
//            return $d;
    }

    function insertbusiness() {
//        echo 2;
//        exit();
        $this->load->library('mongo_db');

        $data = array();

        $data['Master'] = $this->input->post('Master');
        $data['ProviderName'] = $this->input->post('BusinessName');
        $data['OwnerName'] = $this->input->post('OwnerName');
        $data['Phone'] = $this->input->post('Phone');
        $data['Email'] = $this->input->post('Email');
        $data['Password'] = $this->input->post('Password');
        $data['Status'] = "3";

        $data['Website'] = $this->input->post('Website');
        $data['Description'] = $this->input->post('Description');
        $data['Address'] = $this->input->post('Address');
        $data['Location']['Longitude'] = doubleval($this->input->post('Longitude'));
        $data['Location']['Latitude'] = doubleval($this->input->post('Latitude'));

        $data['Country'] = $this->input->post('Country');
        $data['City'] = $this->input->post('city');
        $data['PostalCode'] = $this->input->post('Postalcode');

////        $BusinessCategory = $this->input->post('CatId');
////        $subCatId = $this->input->post('subCatId');
        $data['Driver_exist'] = $this->input->post('drivers');
        $data['pricing_status'] = (int) $this->input->post('pricing');
        $data['MinimumOrderValue'] = $this->input->post('minorderVal');
        $data['FreeDeliveryAbove'] = $this->input->post('freedelVal');

        $data['P_cash'] = (int) $this->input->post('Pcash');
        $data['P_card'] = (int) $this->input->post('Pcredit_card');
        $data['P_sadad'] = (int) $this->input->post('Psadad');
        $data['D_cash'] = (int) $this->input->post('Dcash');
        $data['D_card'] = (int) $this->input->post('Dcredit_card');
        $data['D_sadad'] = (int) $this->input->post('Dsadad');
        $data['tier1'] = (int) $this->input->post('tier1');
        $data['tier2'] = (int) $this->input->post('tier2');
        $data['tier3'] = (int) $this->input->post('tier3');
        $data['Notes'] = $this->input->post('notes');
        $data['avg_cook_time'] = $this->input->post('avgcooktime');
        $data['Budget'] = $this->input->post('Budget');


        if (!$data['Driver_exist']) {
            $data['Driver_exist'] = 0;
        }

        $MAsterData = $this->mongo_db->get_one('MasterData', array("_id" => new MongoDB\BSON\ObjectID($data['Master'])));
        $data['BannerImageUrl'] = $MAsterData['BannerImageUrl'];
        $data['ImageUrl'] = $MAsterData['ImageUrl'];
        $data['WorkingHours'] = $MAsterData['WorkingHours'];
        $data['FacebookLink'] = $MAsterData['FacebookLink'];
        $data['GoogleLink'] = $MAsterData['GoogleLink'];
        $data['TwitterLink'] = $MAsterData['TwitterLink'];
        $data['Instagram'] = $MAsterData['Instagram'];
//        $data['Website'] = $MAsterData['Website'];
        $data['BusinessCategory'] = $MAsterData['BusinessCategory'];
        $data['subCategory'] = $MAsterData['subCategory'];

        $data['Bseq'] = $this->Supperadmin->Funiqueseq($MAsterData['Fseq'], $data['Master']);
//      echo $data;
//         exit();
//       echo $this->mongo_db->insert('ProviderData', array("Bseq"=>$Bunqid,"ProviderName" => $businessname, "OwnerName" => $ownername,
//            "Phone"=>$Phone,"Email" => $uemail, "Password" => $password,"Website"=>$Website,"Description"=>$Description,"Address"=>$Address,
//            "Country"=>$Country,"City"=>$city,"PostalCode"=>$Postalcode,"BusinessCategory" => ($BusinessCategory),"subCategory"=>$subCatId, 
//            "Driver_exist" => $drivers,"Location" => array(
//                                                        "Longitude" => (double) $Longitude,
//                                                        "Latitude" => (double) $Latitude
//                                                        ),
//            "Status" => '3','pricing_status' => $pricing,"MinimumOrderValue"=>$minorderVal,"FreeDeliveryAbove"=>$freedelVal, 'P_cash' => $Pcash,'P_card'=>$Pcredit,'P_sadad'=>$Psadad,
//            'D_cash' => $Dcash,'D_card'=>$Dcredit,'D_sadad'=>$Dsadad,"tier1"=>$tier1,"tier2"=>$tier2,"tier3"=>$tier3));
//         echo '<pre>';
//         print_r($data);
//         exit();
        $this->mongo_db->where(array())->set($data)->update('Franchise');
        $BizId = $data['_id'];
//        echo $BizId;
//exit();
        $this->Supperadmin->copy_data_table('Master_ProductCategory', 'ProductCategory', $data['Master'], $BizId);

        //    echo '1';
    }

    function Funiqueseq($uid, $masid) {
        $this->load->library('mongo_db');
//         print_r($uid);
//         print_r("---".$masid);

        $getseq = $this->mongo_db->get_where('ProviderData', array('Master' => $masid))->sort(array('Bseq' => -1))->limit(1);
//         print_r($getseq);
//         exit();
        $data = array();
        foreach ($getseq as $res) {
            $data = $res;
//                echo '<pre>';
//                print_r($data);
        }
//          exit();
        if (!empty($data)) {

            $edit_id = $data['Bseq'];
            $unq1 = explode('_', $edit_id);
            $sp = str_split($edit_id);

//              $seqno = end($sp);
            $seqno = $edit_id[1];

            $seqno = $seqno + 1;
//              print_r($seqno);
            $uniqueid = $unq1['0'] . "_" . sprintf('%04d', $seqno);
//             print_r($uniqueid);
//             exit();
        } else {
            $edit_id = $uid;
            $unq1 = explode('_', $edit_id);
//              print_r($unq1);
            $sp = str_split($edit_id);
//               $seqno = end($sp);
            $seqno = $edit_id[1];
            $seqno = $seqno + 1;
            //                    print_r($seqno);
            $uniqueid = $unq1['0'] . "_" . sprintf('%04d', $seqno);
//                       print_r($uniqueid);
        }
//          exit();
        return $uniqueid;
    }

    public function GetAllOrders($BizId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_where('Orders', array('BusinessId' => $BizId));
        $entities = array();
        $i = 0;

        foreach ($cursor as $data) {
            $entities[] = $data;
            $i++;
        }
        return $entities;
    }

    public function DeleteCat($entityid = '') {
        $this->load->library('mongo_db');
        $this->mongo_db->delete('Master_ProductCategory', array("_id" => new MongoDB\BSON\ObjectID($entityid)));
        $this->mongo_db->delete('ProductCategory', array("MasterId" => $entityid));
    }

    public function GetAllSubCategories($BizId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_where('Master_ProductSubCategory', array('BusinessId' => $BizId), array('count' => 1));

        $entities = array();
        $i = 0;
        foreach ($cursor as $data) {
            try {
                if ($data['CategoryId'] != '') {
                    $Cat = $this->mongo_db->get_one('Master_ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($data['CategoryId'])));

                    $data['Category'] = $Cat['Category'];
                } else {
                    $data['Category'] = '-';
                }
                $data['SubCategory'] = $data['SubCategory'];
                $data['Description'] = $data['Description'];
                $data['CategoryId'] = $data['CategoryId'];
                $data['id'] = (string) $data['_id'];
                $entities[$i] = $data;
                $i++;
            } catch (Exception $ex) {
                
            }
        }
        return $entities;
    }

    public function GetAllAddOnCats($BizId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_where('Master_AddOns', array('BusinessId' => $BizId));

        $entities = array();
        $i = 0;
        foreach ($cursor as $data) {

            $entities[] = $data;
        }
        return $entities;
    }

    public function checkCenterEmail($Email = '') {
//        echo $Email;
        $this->load->library('mongo_db');
//        echo base64_decode($Email);
        $cursor = $this->mongo_db->count_all_results('ProviderData', array('Email' => base64_decode($Email)));
        if ($cursor > 0) {
            echo json_encode(array('flag' => 1));
        } else {
            echo json_encode(array('flag' => 0));
        }

//        return $entities;
    }

    public function GetMongoid() {
        $this->load->library('mongo_db');
    }

    public function GetAllAddOns($BizId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_where('Master_AddOns', array('BusinessId' => $BizId));

        $entities = array();
        $i = 0;
        foreach ($cursor as $data) {

            $entities[] = $data;
            $i++;
        }
        return $entities;
    }

    public function GetAllCenters($BizId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->where(array('Master' => $BizId))->get('ProviderData');

        $entities = array();
        $i = 0;
        foreach ($cursor as $data) {

            $entities[] = $data;
            $i++;
        }
//        print_r($entities);

        return $entities;
    }

    public function DeleteSubCat($entityid = '') {
        $this->load->library('mongo_db');
        $this->mongo_db->delete('Master_ProductSubCategory', array("_id" => new MongoDB\BSON\ObjectID($entityid)));
        $this->mongo_db->delete('ProductSubCategory', array("MasterId" => $entityid));
    }

    public function DeleteAddOnCat($entityid = '') {
        $this->load->library('mongo_db');
        $this->mongo_db->delete('Master_AddOns', array("_id" => new MongoDB\BSON\ObjectID($entityid)));
        $this->mongo_db->delete('AddOns', array("MasterId" => $entityid));
    }

    public function DeleteProduct() {
        $this->load->library('mongo_db');
        $PId = $this->input->post("val");

        foreach ($PId as $pid) {
//              print_r($pid);
            $this->mongo_db->delete('Master_products', array("_id" => new MongoDB\BSON\ObjectID($pid)));
            echo $this->mongo_db->delete('products', array("MasterId" => (string) $pid));
        }
//        $this->mongo_db->delete('Master_products', array("_id" => new MongoDB\BSON\ObjectID($entityid)));
//        $this->mongo_db->delete('products', array("MasterId" => $entityid));
    }

    public function GetSubCatfromCat() {
        $this->load->library('mongo_db');
        $CatId = $this->input->post("catId");
        $SubCat = $this->input->post("SubCat");
        $cursor = $this->mongo_db->get_where('Master_ProductSubCategory', array('CategoryId' => $CatId));

//        $entities = array();
        $i = 0;
        $entities = ' <select class="form-control" id="SubCategoryId" name="FData[SubCategoryId]" required>
                                                <option value="0">All</option>';
        foreach ($cursor as $data) {
            if ($SubCat == (string) $data['_id']) {
                $entities .= ' <option value="' . (string) $data['_id'] . '" selected>' . implode($data['SubCategory'], ',') . '</option>';
            } else {
                $entities .= ' <option value="' . (string) $data['_id'] . '">' . implode($data['SubCategory'], ',') . '</option>';
            }
        }

        $entities .= ' </select>';
        return $entities;
    }

    public function GetProductDetails($productId = '') {
        $this->load->library('mongo_db');
//        $cursor = $this->mongo_db->get_where('products', array('BusinessId' => $BizId));
        $cursor = $this->mongo_db->get_one('Master_products', array('_id' => new MongoDB\BSON\ObjectID($productId)));
        $allpro = $this->mongo_db->get_where('products', array('MasterId' => $productId));
//        $allpro = array();
        $allbusinesses = array();
        $adddedBiz = array();
        foreach ($allpro as $Products) {
//            echo '1';
            $bizs = $this->mongo_db->get_where('ProviderData', array('Master' => $cursor['BusinessId']));
            foreach ($bizs as $businesses) {
//                echo '2';
                if ((string) $businesses['_id'] == $Products['BusinessId']) {
                    if (!in_array($businesses['_id'], $adddedBiz)) {
                        $adddedBiz[] = $businesses['_id'];
                        $businesses['added'] = '1';
                        $allbusinesses[] = $businesses;
                    }
                }
            }
        }

        $bizs = $this->mongo_db->get_where('ProviderData', array('$and' => array(array('_id' => array('$nin' => $adddedBiz)), array('Master' => $cursor['BusinessId']))));
        foreach ($bizs as $biz) {
            $biz['added'] = '0';
            $allbusinesses[] = $biz;
        }
        $cursor['Businesses'] = $allbusinesses;
//  print_r($allbusinesses);
//        die();
//        $entities = array();
//
//        foreach ($cursor as $data) {
//            
//            $entities[] = $data;
//        }
        return $cursor;
    }

    public function GetProfileData($productId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($productId)))->find_one('MasterData');
        return $cursor;
    }

    function GetCountry() {
     
        $query = $this->mongo_db->get('Country');
//        print_r($query);die;
        return $query; 
    }

    public function GetAddonDetails($AddonId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_one('Master_AddOns', array('_id' => new MongoDB\BSON\ObjectID($AddonId)));
        return $cursor;
    }

    function loadsubcat() {
        $catid = $this->input->post('cat');
//       echo $catid;
//        echo $catid; exit();
//        $Result = $this->db->query("select * from company_info where city=" . $cityid . " and status = 3 ")->result_array();
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_where('Master_ProductSubCategory', array('CategoryId' => $catid));
//        $arr = array();
//        foreach ($cursor as $sub)
//            $arr[] = $sub;
//        print_r($arr);        exit();

        return $cursor;
    }

    function getdata() {

        $this->load->library('mongo_db');

        $catid = $this->input->post('cat');
        $sid = $this->input->post('sid');
//       echo $sid; echo $catid; exit();

        $i = 0;
        $arr = array();
        $entities = array();

        if ($sid == 1 || $sid == 0) {
//            echo 1111;
            $cursor = $this->mongo_db->get_where('Master_ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($catid)));
            foreach ($cursor as $data) {
                $SubCategroy = $this->mongo_db->get_where('Master_ProductSubCategory', array('CategoryId' => (string) ($data['_id'])));
                if ($SubCategroy->count() > 0) {
                    foreach ($SubCategroy as $subcat) {
                        $product = $this->mongo_db->get_where('Master_products', array('SubCategoryId' => (string) ($subcat['_id'])))->sort(array('count' => 1));
                        foreach ($product as $pro) {
                            $pro['CatName'] = $data['Category'];
                            $pro['SubCatName'] = $subcat['SubCategory'];
                            $entities[] = $pro;

                            $i++;
                        }
                    }
                } else {
                    $product = $this->mongo_db->get_where('Master_products', array('CategoryId' => (string) ($data['_id'])))->sort(array('count' => 1));
                    foreach ($product as $pro) {
                        $pro['CatName'] = $data['Category'];
                        $pro['SubCatName'] = '';
                        $entities[] = $pro;

                        $i++;
                    }
                }
            }
        } else {
//            echo 2222;
            $whererc = array('$and' => array(array('CategoryId' => $catid), array('SubCategoryId' => $sid)));
            $product = $this->mongo_db->get_where('Master_products', $whererc)->sort(array('count' => 1));
            $catdata = $this->mongo_db->get_one('Master_ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($catid)));
            $SubCategroy = $this->mongo_db->get_one('Master_ProductSubCategory', array('_id' => new MongoDB\BSON\ObjectID($sid)));

            foreach ($product as $p) {
                $p['CatName'] = $catdata['Category'];
                $p['SubCatName'] = $SubCategroy['SubCategory'];
//                print_r($p);
                $entities[] = $p;
                $i++;
            }
        }
        foreach ($entities as $e) {
//                     print_r($e);
            if (count($e['Portion']) == 1) {
                foreach ($e['Portion'] as $Por) {
                    $Price = $Por['price'];
                }
            } else {
                foreach ($e['Portion'] as $Por) {
                    $allprice[] = $Por['price'];
                }
                $Price = min($allprice);
            }
            $arr[] = array('img' => $e['Masterimageurl']['Url'], 'pname' => $e['ProductName'], 'cat' => $e['CatName'], 'subcat' => $e['SubCatName'], 'price' => $Price, 'p_id' => (string) $e['_id']);
        }
//          print_r($arr);
//          exit();
        return $arr;

//        
//        
//        
//        $product = $this->mongo_db->get_where('Master_products', array('CategoryId' => $catid));
//        $subcategory = $this->mongo_db->get_where('Master_ProductSubCategory', array('CategoryId' => (string) $catid));
//        $category = $this->mongo_db->get_where('Master_ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($catid)));
//
//        $cat = '';
//        foreach ($category as $p)
//            $cat = $p['Category'];
//
//        $subcat = '';
//        foreach ($subcategory as $p)
//            $subcat = $p['SubCategory'];
//
//        $arr = array();
//        foreach ($product as $p) {
//
//            $allprice = array();
//            $Price = '';
//
//            if (count($p['Portion']) == 1) {
//                foreach ($p['Portion'] as $Por) {
//                    $Price = $Por['price'];
//                }
//            } else {
//                foreach ($p['Portion'] as $Por) {
//                    $allprice[] = $Por['price'];
//                }
//                $Price = min($allprice);
//            }
//
//            $arr[] = array('img' => $p['Masterimageurl']['Url'], 'pname' => $p['ProductName'], 'cat' => $cat, 'subcat' => $subcat, 'price' => $Price, 'p_id' => (string) $p['_id']);
//        }
//
//        return $arr;
    }

    public function GetAllProducts($BizId = '') {
        $this->load->library('mongo_db');
//        print_r($BizId);
        $i = 0;
        $entities = array();
        $cursor = $this->mongo_db->where(array('BusinessId' => $BizId))->order_by(array('count' => 1))->get('Master_ProductCategory');
//        echo '<pre>';
        foreach ($cursor as $data) {
//            print_r($data);
            $SubCategroy = $this->mongo_db->get_where('Master_ProductSubCategory', array('CategoryId' => (string) ($data['_id'])));
//           print_r($SubCategroy->count());
            if ($SubCategroy->count() > 0) {
                foreach ($SubCategroy as $subcat) {
//               print_r($subcat);
                    $product = $this->mongo_db->get_where('Master_products', array('SubCategoryId' => (string) ($subcat['_id'])));
                    foreach ($product as $pro) {
                        $pro['CatName'] = $data['Category'];
                        $pro['SubCatName'] = $subcat['SubCategory'];

                        $entities[] = $pro;
//               print_r($entities);
                        $i++;
                    }
                }
            } else {

                $product = $this->mongo_db->get_where('Master_products', array('CategoryId' => (string) ($data['_id'])))->sort(array('count' => 1));
                foreach ($product as $pro) {
                    $pro['CatName'] = $data['Category'];
                    $pro['SubCatName'] = '';
//                  print_r($pro);
                    $entities[] = $pro;
                    $i++;
                }
            }
        }
//        print_r($entities);
//        exit();
//        print_r(($entities)); exit();
        return $entities;
    }

//    public function GetAllProducts($BizId = '') {
//        $this->load->library('mongo_db');
//        $cursor = $this->mongo_db->get_where('Master_products', array('BusinessId' => $BizId), array('count' => 1));
////        $cursor = $this->mongo_db->get_where('products');
//
//        $entities = array();
//        $i = 0;
////        echo '<pre>';
//        foreach ($cursor as $data) {
//
//
//            $catName = '-';
//            $SubcatName = '-';
//            if ($data['CategoryId'] != '') {
//                $Categroy = $this->mongo_db->get_one('Master_ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($data['CategoryId'])));
//                $catName = $Categroy['Category'];
//            }
//            if ($data['SubCategoryId'] != '') {
//                $SubCategroy = $this->mongo_db->get_one('Master_ProductSubCategory', array('_id' => new MongoDB\BSON\ObjectID($data['SubCategoryId'])));
//                $SubcatName = $SubCategroy['SubCategory'];
//            }
//            $data['CatName'] = $catName;
//            $data['SubCatName'] = $SubcatName;
//            $entities[] = $data;
//
//
//            $i++;
//        }
//        return $entities;
//    }

    public function GetOrderDetails($OrderId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_one('Orders', array('_id' => new MongoDB\BSON\ObjectID($OrderId)));
//        $cursor = $this->mongo_db->get_where('products');
        $Items = array();
        echo '1';
        foreach ($cursor['Items'] as $items) {
            $Product = $this->mongo_db->get_one('products', array('_id' => new MongoDB\BSON\ObjectID($items['ItemId'])));
            $Items[] = array('ProductName' => $Product['ProductName'],
                "ItemId" => $items['ItemId'], "Qty" => $items['Qty'],
                "PrtionId" => $items['PrtionId'], "PortionTitle" => $items['PortionTitle'],
                "PortionPrice" => $items['PortionPrice'], "AddOns" => $items['AddOns']);
        }
        echo '1';
//         {
//            "UserId":"12234", "Amount":"120", "Tax":"20", "Total":"120", "Status":"1",
//            "BusinessId":"549511f0467b87295b8b4871", "DateTime":"2014-04-16 11:02:00",
//            "Items":[{"ItemId":"123123", "Qty":"2", "PrtionId":"2123", "PortionTitle":"asdsd", "PortionPrice":"100",
//            "AddOns":[{"id":"223", "Title":"qeqe", "Price":"qwweqwe"}]}]
//        }
        $order = array('UserId' => $cursor['UserId'], 'Amount' => $cursor['Amount']
            , 'Tax' => $cursor['Tax'], 'Total' => $cursor['Total'],
            'Status' => $cursor['Status'], 'DateTime' => $cursor['DateTime'], 'id' => (string) $cursor['_id'], 'Items' => $Items);
        return $order;
    }

    /**
     *
     * add new broker in db
     *
     */
    /* function AddNewBroker(){

      $this->load->library('mongo_db');
      $document = array(
      "Fname" => $this->input->post("Firstname"),
      "Lname" => $this->input->post("Lastname"),
      "Email" => $this->input->post("Email"),
      "Password" => md5($this->input->post("Password")),
      "Role" => "Broker",
      "Parent" => "SuperAdmin",
      "Last_Login_Time" => NULL,
      "Last_Login_Ip" => NULL,
      "resetlink" => NULL

      );
      $this->mongo_db->insert('Col_Manage_Admin',$document);

      $template = "<h3>you are added as Admin  here is your login details</h3><br>"
      ."Emailid: ".$this->input->post("Email")."<br>".
      "Password: ".$this->input->post("Password")."<br>";
      $to[] = array(
      'email' =>$this->input->post("Email"),
      'name' => "prakash",
      'type' => "to");

      $from = "prakashjoshi9090@gmail.com";

      $subject ="Login Details";

      $this->mongo_db->sendMail($template, $to, $from,$subject);

      } */


    function AddNewCategory() {

        $this->load->library('mongo_db');


        $CategoryId = $this->input->post("CategoryId");
        $fdata = $this->input->post("FData");
        $fdata['count'] = (int) $fdata['count'];
        if ($CategoryId != '') {

            $this->mongo_db->update('Master_ProductCategory', $fdata, array("_id" => new MongoDB\BSON\ObjectID($CategoryId)));
            $getDetail = $this->mongo_db->get_one('Master_ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($CategoryId)));
            $this->mongo_db->update('ProductCategory', array('Category' => $getDetail['Category'], 'Description' => $getDetail['Description']), array("MasterId" => $CategoryId));
        } else {
            $this->mongo_db->insert('Master_ProductCategory', $fdata);
        }
    }

    function ChangeStatus($center = '', $status = '') {

        $this->load->library('mongo_db');




        if ($center != '') {
            $this->mongo_db->update('ProviderData', array('Status' => $status), array("_id" => new MongoDB\BSON\ObjectID($center)));
//            $this->mongo_db->delete('ProviderData', array('Status' => $status));
        }
    }

    function AddNewAddOns() {

        $this->load->library('mongo_db');
        $AddOnId = $this->input->post("AddOnId");
        $Fdata = $this->input->post("FData");
        $man = '0';
        if (isset($Fdata['Mandatory'])) {
            $man = '1';
        }
        $multi = '0';
        if (isset($Fdata['Multiple'])) {
            $multi = '1';
        }
        $Fdata['Mandatory'] = $man;
        $Fdata['Multiple'] = $multi;
        if ($AddOnId != '') {
            $this->mongo_db->update('Master_AddOns', $Fdata, array("_id" => new MongoDB\BSON\ObjectID($AddOnId)));
            $getDetail = $this->mongo_db->get_one('Master_AddOns', array('_id' => new MongoDB\BSON\ObjectID($AddOnId)));
            $this->mongo_db->update('AddOns', array('Category' => $getDetail['Category'],
                'Description' => $getDetail['Description'], 'Mandatory' => $getDetail['Mandatory'],
                'Multiple' => $getDetail['Multiple'], 'AddOns' => $getDetail['AddOns']), array("MasterId" => $AddOnId));
        } else {
            $this->mongo_db->insert('Master_AddOns', $Fdata);
        }
    }

    function AddnewProduct() {

        $this->load->library('mongo_db');
        $ProductId = $this->input->post("ProductId");
//        echo $ProductId;

        $fdata = $this->input->post("FData");

        $businesses = $this->input->post('businesses');
//        print_r($businesses);
//        die();
        if ($ProductId != '') {
            $array = array('AddOns' => array());
            $this->mongo_db->update('Master_products', $array, array("_id" => new MongoDB\BSON\ObjectID($ProductId)));
            $this->mongo_db->update('Master_products', $fdata, array("_id" => new MongoDB\BSON\ObjectID($ProductId)));
            $fdata['_id'] = new MongoDB\BSON\ObjectID($ProductId);
            $fdata['businesses'] = $businesses;
            $this->Supperadmin->copy_category_for_new_product($fdata);
        } else {
            $fdata['_id'] = new MongoDB\BSON\ObjectID();
            $count = $this->input->post("count");
            $fdata['count'] = (int) $count;
            $fdata['businesses'] = $businesses;
            $this->Supperadmin->copy_category_for_new_product($fdata);
            unset($fdata['businesses']);
            //check category of that product available in businesses?
            $this->mongo_db->insert('Master_products', $fdata);
        }
    }

    public function copy_category_for_new_product($data) {
//        print_r($data['businesses']);
//        die();

        $data['Master_Cat'] = $data['CategoryId'];
        foreach ($data['businesses'] as $copyTo) {
            $data['BusinessId'] = $copyTo;
            $checkCategory = $this->mongo_db->get_one('ProductCategory', array('$and' => array(array('MasterId' => $data['Master_Cat']), array('BusinessId' => $copyTo))));
            if (count($checkCategory) > 0) {
                $getDetail = $this->mongo_db->get_one('Master_ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($data['Master_Cat'])));
//                print_r(array('Category' => $getDetail['Category'], 'Description' => $getDetail['Description']));
                $this->mongo_db->update('ProductCategory', array('Category' => $getDetail['Category'], 'Description' => $getDetail['Description']), array("_id" => new MongoDB\BSON\ObjectID($checkCategory['_id'])));
//                $checkCategory['Category'] = $getDetail['Category'];
//                $checkCategory['Description'] = $getDetail['Description'];
//                $deletethis = $checkCategory['_id'];
//                $checkCategory['_id'] = new MongoDB\BSON\ObjectID();
//                print_r($checkCategory);
//                $this->mongo_db->insert('ProductCategory', $checkCategory);
//                $this->mongo_db->delete('ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($deletethis)));
//                print_r($data['SubCategoryId']);
//                die();
                $data['CategoryId'] = (string) $checkCategory['_id'];
                if ($data['SubCategoryId'] != '' && $data['SubCategoryId'] != '0' && $data['SubCategoryId'] != 0) {
//                    echo 1;
//                    die();
                    $this->Supperadmin->copy_sub_category_for_new_product($data);
                } else {
//                    echo 2;
//                    die();
                    $data['AddOns'] = $this->Supperadmin->copy_addon_for_new_product($data);
                    $this->Supperadmin->copy_product($data);
                }
            } else {
                $checkCategory = $this->mongo_db->get_one('Master_ProductCategory', array('_id' => new MongoDB\BSON\ObjectID($data['Master_Cat'])));
                $count = $this->mongo_db->count_all_results('ProductCategory', array('BusinessId' => $copyTo));

                $checkCategory['MasterId'] = (string) $checkCategory['_id'];
                $catId = new MongoDB\BSON\ObjectID();
                $checkCategory['_id'] = $catId;
                $checkCategory['count'] = (int) $count + 1;
                $checkCategory['BusinessId'] = $copyTo;

//                echo '2';
                $this->mongo_db->insert('ProductCategory', $checkCategory);
                $data['CategoryId'] = (string) $catId;
                if ($data['SubCategoryId'] != '') {
                    $this->Supperadmin->copy_sub_category_for_new_product($data);
                } else {
                    $data['AddOns'] = $this->Supperadmin->copy_addon_for_new_product($data);
                    $this->Supperadmin->copy_product($data);
                }
            }
        }
//        die();
    }

    public function copy_sub_category_for_new_product($data) {
        $data['master_SubCategoryId'] = $data['SubCategoryId'];
        $checkCategory = $this->mongo_db->get_one('ProductSubCategory', array('$and' => array(array('MasterId' => $data['master_SubCategoryId']), array('BusinessId' => $data['BusinessId']))));
        if (count($checkCategory) > 0) {


            $getDetail = $this->mongo_db->get_one('Master_ProductSubCategory', array('_id' => new MongoDB\BSON\ObjectID($data['master_SubCategoryId'])));
            $this->mongo_db->update('ProductSubCategory', array('SubCategory' => $getDetail['SubCategory'], 'Description' => $getDetail['Description']), array("_id" => new MongoDB\BSON\ObjectID($checkCategory['_id'])));
            $data['SubCategoryId'] = (string) $checkCategory['_id'];
            $data['AddOns'] = $this->Supperadmin->copy_addon_for_new_product($data);
            $this->Supperadmin->copy_product($data);
        } else {
            $checkCategory = $this->mongo_db->get_one('Master_ProductSubCategory', array('_id' => new MongoDB\BSON\ObjectID($data['master_SubCategoryId'])));
            $count = $this->mongo_db->count_all_results('ProductSubCategory', array('BusinessId' => $data['BusinessId']));

            $checkCategory['MasterId'] = (string) $checkCategory['_id'];
            $checkCategory['CategoryId'] = $data['CategoryId'];
            $checkCategory['BusinessId'] = $data['BusinessId'];
            $checkCategory['_id'] = new MongoDB\BSON\ObjectID();
            $checkCategory['count'] = (int) $count + 1;
            $this->mongo_db->insert('ProductSubCategory', $checkCategory);
            $data['SubCategoryId'] = (string) $checkCategory['_id'];
            $data['AddOns'] = $this->Supperadmin->copy_addon_for_new_product($data);
            $this->Supperadmin->copy_product($data);
        }
    }

    public function copy_addon_for_new_product($data) {
        $addons_for_pro = array();
        foreach ($data['AddOns'] as $addons) {
            $checkCategory = $this->mongo_db->get_one('AddOns', array('$and' => array(array('MasterId' => $addons['AddOn']), array('BusinessId' => $data['BusinessId']))));
            if (count($checkCategory) > 0) {
                $getDetail = $this->mongo_db->get_one('Master_AddOns', array('_id' => new MongoDB\BSON\ObjectID($addons['AddOn'])));
                $this->mongo_db->update('AddOns', array('Category' => $getDetail['Category'], 'Description' => $getDetail['Description'], 'AddOns' => $getDetail['AddOns'], 'Multiple' => $getDetail['Multiple'], 'Mandatory' => $getDetail['Mandatory']), array("_id" => $checkCategory['_id']));
                $addons_for_pro[] = array('AddOn' => (string) $checkCategory['_id']);
                $this->Supperadmin->copy_product($data);
            } else {
                $checkCategory = $this->mongo_db->get_one('Master_AddOns', array('_id' => new MongoDB\BSON\ObjectID($addons['AddOn'])));
                $count = $this->mongo_db->count_all_results('AddOns', array('BusinessId' => $data['BusinessId']));
                $checkCategory['MasterId'] = (string) $checkCategory['_id'];
                $checkCategory['BusinessId'] = $data['BusinessId'];
                $checkCategory['_id'] = new MongoDB\BSON\ObjectID();
                $checkCategory['count'] = (int) $count + 1;
                $this->mongo_db->insert('AddOns', $checkCategory);
                $addons_for_pro[] = array('AddOn' => (string) $checkCategory['_id']);
            }
        }
        return $addons_for_pro;
    }

    public function copy_product($data) {
        $checkCategory = $this->mongo_db->get_one('products', array('$and' => array(array('MasterId' => (string) $data['_id']), array('BusinessId' => $data['BusinessId']))));
        if (count($checkCategory) > 0) {


            $getDetail = $this->mongo_db->get_one('Master_products', array('_id' => new MongoDB\BSON\ObjectID($data['_id'])));
            unset($getDetail['_id']);
            unset($getDetail['count']);
            unset($getDetail['BusinessId']);
            $getDetail['CategoryId'] = $data['CategoryId'];
            $getDetail['SubCategoryId'] = $data['SubCategoryId'];
            $this->mongo_db->update('products', $getDetail, array("_id" => new MongoDB\BSON\ObjectID($checkCategory['_id'])));
        } else {
            $count = $this->mongo_db->count_all_results('products', array('BusinessId' => $data['BusinessId']));

            $data['MasterId'] = (string) $data['_id'];
            $data['_id'] = new MongoDB\BSON\ObjectID();
            $data['count'] = (int) $count + 1;
            unset($data['businesses']);
            $checkCategory = $this->mongo_db->insert('products', $data);
        }
    }

    public function copy_data_table($from = '', $to = '', $MasterId = '', $BizId = '') {
        $this->load->library('mongo_db');
        ///addons
        $AllAdons = $this->mongo_db->get_where('Master_AddOns', array('BusinessId' => $MasterId));

        foreach ($AllAdons as $adons) {
            $All_Addons = array();
            foreach ($adons as $Adonkey => $Adonvalue1) {
                if ($Adonkey != '_id') {

                    $All_Addons[$Adonkey] = $Adonvalue1;
                }
                $All_Addons['BusinessId'] = (string) $BizId;
                $All_Addons['MasterId'] = (string) $adons['_id'];
                $AdonId = new MongoDB\BSON\ObjectID();
                $All_Addons['_id'] = $AdonId;
            }

            $this->mongo_db->insert('AddOns', $All_Addons);
        }

        //////category subcategroy and products
        $Allcats = $this->mongo_db->get_where($from, array('BusinessId' => $MasterId));

        foreach ($Allcats as $cats) {
            $All_categories = array();
            foreach ($cats as $key => $value) {
                if ($key != '_id') {

                    $All_categories[$key] = $value;
                } else {
                    $All_categories['MasterId'] = $value;
                }
            }
            $All_categories['BusinessId'] = (string) $BizId;

            $id = new MongoDB\BSON\ObjectID();
            $All_categories['_id'] = $id;
            //copy sub category

            $CountAllSubCats = $this->mongo_db->count_all_results('Master_ProductSubCategory', array('CategoryId' => (string) $cats['_id']));

            if ($CountAllSubCats > 0) {


                $AllSubCats = $this->mongo_db->get_where('Master_ProductSubCategory', array('CategoryId' => (string) $cats['_id']));

                foreach ($AllSubCats as $Subcats) {


                    $All_Sub_categories = array();
                    foreach ($Subcats as $key1 => $value1) {

                        if ($key1 != '_id') {

                            $All_Sub_categories[$key1] = $value1;
                        } else {
                            $All_Sub_categories['MasterId'] = $value1;
                        }
                    }
                    $All_Sub_categories['BusinessId'] = (string) $BizId;
                    $All_Sub_categories['CategoryId'] = (string) $All_categories['_id'];
                    $Subid = new MongoDB\BSON\ObjectID();
                    $All_Sub_categories['_id'] = $Subid;
                    ///copy products
                    $masterArray = array('CategoryId' => (string) $cats['_id'], 'SubCategoryId' => (string) $Subcats['_id']);
//                    print_r(json_encode($masterArray));
                    $AllProducts = $this->mongo_db->get_where('Master_products', $masterArray);
                    foreach ($AllProducts as $produts) {
                        $All_products = array();
                        foreach ($produts as $key11 => $value11) {
                            if ($key11 != '_id' && $key11 != 'AddOns') {

                                $All_products[$key11] = $value11;
                            } else {
                                $All_products['MasterId'] = $value11;
                            }
                        }
                        $Product_Portions = array();
                        foreach ($produts['AddOns'] as $Prod_Por) {

                            $qry = array('BusinessId' => (string) $BizId,
                                'MasterId' => $Prod_Por['AddOn']);
                            $AllAdons = $this->mongo_db->get_where('AddOns', $qry);
                            foreach ($AllAdons as $GotIt) {
                                $Product_Portions[] = array('AddOn' => (string) $GotIt['_id']);
                            }
                        }
                        $All_products['AddOns'] = $Product_Portions;
                        $All_products['BusinessId'] = (string) $BizId;
                        $All_products['CategoryId'] = (string) $All_categories['_id'];

                        $All_products['SubCategoryId'] = (string) $All_Sub_categories['_id'];
                        $ProId = new MongoDB\BSON\ObjectID();
                        $All_products['_id'] = $ProId;
                        $this->mongo_db->insert('products', $All_products);
//                            print_r($All_products);
//                            return;
//                    return;
                        ////////
                    }



                    $this->mongo_db->insert('ProductSubCategory', $All_Sub_categories);
                }
            } else {


                ////
                ////now copy the products from the catgory
                ///copy products
                $AllProductsInCat = $this->mongo_db->get_where('Master_products', array('CategoryId' => (string) $cats['_id']));
                foreach ($AllProductsInCat as $produtsinCat) {
                    $All_products_In_cat = array();
                    foreach ($produtsinCat as $key111 => $value111) {
                        if ($key111 != '_id' && $key111 != 'AddOns') {

                            $All_products_In_cat[$key111] = $value111;
                        } else {
                            $All_products_In_cat['MasterId'] = $value111;
                        }
                    }

                    $Product_Portions = array();
                    foreach ($produtsinCat['AddOns'] as $Prod_Por) {
                        $qry = array('BusinessId' => (string) $BizId,
                            'MasterId' => $Prod_Por['AddOn']);
                        $AllAdons = $this->mongo_db->get_where('AddOns', $qry);
                        foreach ($AllAdons as $GotIt) {
                            $Product_Portions[] = array('AddOn' => (string) $GotIt['_id']);
                        }
                    }

                    $All_products_In_cat['AddOns'] = $Product_Portions;
                    $All_products_In_cat['BusinessId'] = (string) $BizId;
                    $All_products_In_cat['CategoryId'] = (string) $All_categories['_id'];
                    $All_products_In_cat['SubCategoryId'] = '';
                    $ProId1 = new MongoDB\BSON\ObjectID();
                    $All_products_In_cat['_id'] = $ProId1;
                    $this->mongo_db->insert('products', $All_products_In_cat);
                }
            }
            ////////
            $this->mongo_db->insert($to, $All_categories);
        }
    }

    function AddNewCenter() {
        $this->load->model('Supperadmin');
        $this->load->library('mongo_db');

        $data = $this->input->post("FData");
        $data['cash'] = (int) $data['cash'];
        $data['card'] = (int) $data['credit_card'];
        $data['sadad'] = (int) $data['SADAD'];

        $Fdata = $this->mongo_db->get_one('MasterData', array('_id' => new MongoDB\BSON\ObjectID($data['Master'])));
//        print_r($Fdata['Fseq']);
//        $seq = $this->superadminmodal->Funiqueseq();
        $data['Bseq'] = $this->Supperadmin->Funiqueseq($Fdata['Fseq'], $data['Master']);
//        print_r($data['Bseq']);
//        exit();

        $data['Location'] = array('Longitude' => (double) $this->input->post("Longitude"), 'Latitude' => (double) $this->input->post("Latitude"));
        $MasterId = $this->input->post("MasterId");
        $MAsterData = $this->mongo_db->get_one('MasterData', array("_id" => new MongoDB\BSON\ObjectID($MasterId)));
        $data['BannerImageUrl'] = $MAsterData['BannerImageUrl'];
        $data['ImageUrl'] = $MAsterData['ImageUrl'];
        $data['WorkingHours'] = $MAsterData['WorkingHours'];
        $data['FacebookLink'] = $MAsterData['FacebookLink'];
        $data['GoogleLink'] = $MAsterData['GoogleLink'];
        $data['TwitterLink'] = $MAsterData['TwitterLink'];
        $data['Instagram'] = $MAsterData['Instagram'];
        $data['Website'] = $MAsterData['Website'];
        $data['BusinessCategory'] = $MAsterData['BusinessCategory'];

        $this->mongo_db->insert('ProviderData', $data);
        $BizId = $data['_id'];
//        echo $BizId;

        $this->Supperadmin->copy_data_table('Master_ProductCategory', 'ProductCategory', $MasterId, $BizId);
        //copy categories from master to slave
    }

    function GetAllBusinesses($masId) {
        $this->load->library('mongo_db');
        $data = array();
        $det = $this->mongo_db->get_where('ProviderData', array("Master" => $masId));
        foreach ($det as $detail) {
            $data[] = $detail;
        }
        return $data;
    }

    function CopyBusiness() {

        $this->load->library('mongo_db');
        $data = array();
        $id = '';

        $CopyFrom = $this->input->post("BizId");
        $MAsterData = $this->mongo_db->get_where('ProviderData', array("_id" => new MongoDB\BSON\ObjectID($CopyFrom)));
        foreach ($MAsterData as $Mas) {

            foreach ($Mas as $key => $val) {
                if ($key != '_id') {

                    $data[$key] = $val;
                }
                $id = new MongoDB\BSON\ObjectID();
                $data['_id'] = $id;
            }
        }
        $data['ProviderName'] = $this->input->post("BusinessName");
        $data['OwnerName'] = $this->input->post("OwnerName");
        $data['Email'] = $this->input->post("Email");
        $data['Password'] = $this->input->post("Password");
        $data['Status'] = '3';
        $this->mongo_db->insert('ProviderData', $data);
        $BizId = $id;
//        echo $BizId;

        $this->load->model('Supperadmin');
        $this->Supperadmin->copy_data_table1('ProductCategory', 'ProductCategory', $CopyFrom, $BizId);
        //copy categories from master to slave
    }

    public function copy_data_table1($from = '', $to = '', $MasterId = '', $BizId = '') {
        $this->load->library('mongo_db');
        ///addons
        $AllAdons = $this->mongo_db->get_where('AddOns', array('BusinessId' => $MasterId));

        foreach ($AllAdons as $adons) {
            $All_Addons = array();
            foreach ($adons as $Adonkey => $Adonvalue1) {
                if ($Adonkey != '_id') {

                    $All_Addons[$Adonkey] = $Adonvalue1;
                }
                $All_Addons['BusinessId'] = (string) $BizId;
                $AdonId = new MongoDB\BSON\ObjectID();
                $All_Addons['_id'] = $AdonId;
            }

            $this->mongo_db->insert('AddOns', $All_Addons);
        }

        //////category subcategroy and products
        $Allcats = $this->mongo_db->get_where($from, array('BusinessId' => $MasterId));

        foreach ($Allcats as $cats) {
            $All_categories = array();
            foreach ($cats as $key => $value) {
                if ($key != '_id') {

                    $All_categories[$key] = $value;
                }
            }
            $All_categories['BusinessId'] = (string) $BizId;
            $id = new MongoDB\BSON\ObjectID();
            $All_categories['_id'] = $id;
            //copy sub category

            $CountAllSubCats = $this->mongo_db->count_all_results('ProductSubCategory', array('CategoryId' => (string) $cats['_id']));

            if ($CountAllSubCats > 0) {


                $AllSubCats = $this->mongo_db->get_where('ProductSubCategory', array('CategoryId' => (string) $cats['_id']));

                foreach ($AllSubCats as $Subcats) {


                    $All_Sub_categories = array();
                    foreach ($Subcats as $key1 => $value1) {

                        if ($key1 != '_id') {

                            $All_Sub_categories[$key1] = $value1;
                        }
                    }
                    $All_Sub_categories['BusinessId'] = (string) $BizId;
                    $All_Sub_categories['CategoryId'] = (string) $All_categories['_id'];
                    $Subid = new MongoDB\BSON\ObjectID();
                    $All_Sub_categories['_id'] = $Subid;
                    ///copy products
                    $masterArray = array('CategoryId' => (string) $cats['_id'], 'SubCategoryId' => (string) $Subcats['_id']);
//                    print_r(json_encode($masterArray));
                    $AllProducts = $this->mongo_db->get_where('products', $masterArray);
                    foreach ($AllProducts as $produts) {
                        $All_products = array();
                        foreach ($produts as $key11 => $value11) {
                            if ($key11 != '_id') {

                                $All_products[$key11] = $value11;
                            }
                        }

                        $All_products['BusinessId'] = (string) $BizId;
                        $All_products['CategoryId'] = (string) $All_categories['_id'];
                        $All_products['SubCategoryId'] = (string) $All_Sub_categories['_id'];
                        $ProId = new MongoDB\BSON\ObjectID();
                        $All_products['_id'] = $ProId;
                        $this->mongo_db->insert('products', $All_products);
                    }
                    $this->mongo_db->insert('ProductSubCategory', $All_Sub_categories);
                }
            } else {


                ////
                ////now copy the products from the catgory
                ///copy products
                $AllProductsInCat = $this->mongo_db->get_where('products', array('CategoryId' => (string) $cats['_id']));
                foreach ($AllProductsInCat as $produtsinCat) {
                    $All_products_In_cat = array();
                    foreach ($produtsinCat as $key111 => $value111) {
                        if ($key111 != '_id') {

                            $All_products_In_cat[$key111] = $value111;
                        }
                    }
                    $All_products_In_cat['BusinessId'] = (string) $BizId;
                    $All_products_In_cat['CategoryId'] = (string) $All_categories['_id'];
                    $All_products_In_cat['SubCategoryId'] = '';
                    $ProId1 = new MongoDB\BSON\ObjectID();
                    $All_products_In_cat['_id'] = $ProId1;
                    $this->mongo_db->insert('products', $All_products_In_cat);
                }
            }
            ////////
            $this->mongo_db->insert($to, $All_categories);
        }
    }

    function get_product_count($bizid = '') {

        $this->load->library('mongo_db');

        $array = $this->mongo_db->get_where('Master_products', array('BusinessId' => $bizid));
        $count = 0;
        foreach ($array as $total) {
            $count++;
        }
        $count++;

        return $count;
    }

    function UpdateProfile() {

        $this->load->library('mongo_db');
        $BusinessId = $this->input->post("BusinessId");

        $senddata = $this->input->post("FData");
//        print_r($senddata['ImageUrl']);
//        exit();
        $this->session->set_userdata('profileimg', $senddata['ImageUrl']);
        if (isset($senddata['ImageFlag'])) {
            $senddata['ImageFlag'] = '1';
        } else {
            $senddata['ImageFlag'] = '0';
        }

        echo $BusinessId . '';
        $this->mongo_db->update('MasterData', $senddata, array("_id" => new MongoDB\BSON\ObjectID($BusinessId)));
    }

    function UpdateEmail() {

        $this->load->library('mongo_db');
        $EmailId = $this->input->post("EmailId");
        echo $EmailId . '';
        $this->mongo_db->update('MasterData', $this->input->post("FData"), array("_id" => new MongoDB\BSON\ObjectID($EmailId)));
    }

    function AddNewSubCategory() {

        $this->load->library('mongo_db');

        $fdata = $this->input->post("FData");
        $fdata['count'] = (int) $fdata['count'];
        $SubCategoryId = $this->input->post("SubCategoryId");
        if ($SubCategoryId != '') {
            $this->mongo_db->update('Master_ProductSubCategory', $fdata, array("_id" => new MongoDB\BSON\ObjectID($SubCategoryId)));
            $getDetail = $this->mongo_db->get_one('Master_ProductSubCategory', array('_id' => new MongoDB\BSON\ObjectID($SubCategoryId)));
            $this->mongo_db->update('ProductSubCategory', array('SubCategory' => $getDetail['SubCategory'], 'Description' => $getDetail['Description']), array("MasterId" => $SubCategoryId));
        } else {
            $this->mongo_db->insert('Master_ProductSubCategory', $fdata);
        }
    }

    /**
     *
     * add new admin in db
     *
     */
    function AddNewAdmin() {

        $this->load->library('mongo_db');

        $email = $this->input->post("FData");
        $password = $this->input->post("Password");
        $document = array(
            "Fname" => $this->encrypt_decrypt('encrypt', $this->input->post("Firstname")),
            "Lname" => $this->encrypt_decrypt('encrypt', $this->input->post("Lastname")),
            "Email" => $this->encrypt_decrypt('encrypt', $email),
            "Password" => $this->encrypt_decrypt('encrypt', $password),
            "Type" => $this->encrypt_decrypt('encrypt', $this->input->post("type")),
            "Role" => $this->encrypt_decrypt('encrypt', "Admin"),
            "Parent" => $this->encrypt_decrypt('encrypt', "SuperAdmin"),
            "Last_Login_Time" => NULL,
            "Last_Login_Ip" => NULL,
            "resetlink" => NULL
        );

        $this->mongo_db->insert('Col_Manage_Admin', $document);

        $template = "<h3>you are added as Admin  here is your login details</h3><br>"
                . "Emailid: " . $email . "<br>" .
                "Password: " . $password . "<br>";
        $to[] = array(
            'email' => $email,
            'name' => "prakash",
            'type' => "to");

        $from = "prakashjoshi9090@gmail.com";

        $subject = "Login Details";

        $this->mongo_db->sendMail($template, $to, $from, $subject);
    }

    function ChangePassword($NewPassword, $EmailId) {
        $this->load->library('mongo_db');
        $this->mongo_db->update('Col_Manage_Admin', array("Email" => $EmailId), array('$set' => array("Password" => md5($NewPassword))), array("multiple" => true));
        $this->session->set_userdata('password', $NewPassword);
    }

    function ForgotPassword($useremail) {
//      
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->count_all_results('ProviderData', array('Email' => $useremail));

        if ($cursor > 0) {
            $data = $this->mongo_db->get_one('ProviderData', array('Email' => $useremail));

            $rlink = uniqid(md5(mt_rand()));

            $this->mongo_db->update('ProviderData', array("resetlink" => ($rlink)), array("Email" => $useremail));

            $resetlink = base_url() . "index.php/Admin/ResetPwd/" . $rlink;

            $template = "<h3> <a href='" . $resetlink . "'>Click Here</a> to reset your password</h3><br>";
            $to[] = array(
                'email' => $useremail,
                'name' => $data['ProviderName'],
                'type' => "to");

            $from = "noreply@iDeliver.mobi";
            $subject = "Reset Password Link";
            $this->mongo_db->sendMail($template, $to, $from, $subject);
//            $this->mongo_db->update('Col_Manage_Admin', array("Email" => $useremail), array("resetlink" => ($rlink)));
            return true;
        }
        return false;
    }

    public function checkLink($Resetlink = '') {
        $this->load->library('mongo_db');
        $Check = $this->mongo_db->count_all_results('ProviderData', array('resetlink' => $Resetlink));

        if ($Check > 0) {
            $entities = array('flag' => 0);
        } else {
            $entities = array('flag' => 1);
        }

        return $entities;
    }

    function VerifyResetLink($vlink) {
        $this->load->library('mongo_db');

        $cursor = $this->mongo_db->get_where('Col_Manage_Admin', array('resetlink' => $vlink));

        if ($cursor) {
            $password = md5("joshi");
            $this->mongo_db->update('Col_Manage_Admin', array("resetlink" => $vlink), array("Password" => $password));


            return true;
        }
        return false;
    }

    /**
     *
     * validate email is available in database
     */
    function validateEmail() {
        $this->load->library('mongo_db');
        $cout = $this->mongo_db->count_all_results('Col_Manage_Admin', array('Email' => $this->encrypt_decrypt('encryt', $this->input->post('email'))));
        $result = 0;
        if ($cout > 0) {
            $result = 1;
            if ($this->input->post('dofor') == 2) {
                $secount = $this->mongo_db->count_all_results('Col_Manage_Admin', array('Email' => $this->encrypt_decrypt('encryt', $this->input->post('email')), '_id' => new MongoDB\BSON\ObjectID($this->input->post('m_id'))));
                if ($secount > 0)
                    $result = 0;
                else
                    $result = 1;
            }
        }
        echo json_encode(array('msg' => $result));
    }

    /*
     *
     * Edit admin and broker Creation details
     *
     */

    function EditNewAdmin() {

        $this->load->library('mongo_db');
        $fdata = $this->input->post('fdata');
        $this->mongo_db->update('Col_Manage_Admin', array("Fname" => $this->encrypt_decrypt('encrypt', $fdata['Firstname']), "Lname" => $this->encrypt_decrypt('encrypt', $fdata['Lastname']), "Email" => $this->encrypt_decrypt('encrypt', $fdata['Email']), "Password" => $this->encrypt_decrypt('encrypt', $fdata['Password'])), array("_id" => new MongoDB\BSON\ObjectID($fdata['mongoidtoupdate'])));
    }

    /*
     *
     * Delete admin and broker Creation details
     *
     */

    function DeleteUser() {
        $this->load->library('mongo_db');
        $this->mongo_db->delete('Col_Manage_Admin', array('_id' => new MongoDB\BSON\ObjectID($this->input->post('mongo_id_del'))));
    }

    /*
     *
     * Add different entities to db with an encryption
     *
     */

    function AddNewEntity($tablename) {
        $this->load->library('mongo_db');
//uploading documents to document folder
        $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/apps/RylandInsurence/Documents/';
        $doumentname = $_FILES['entitydocfile']['name'];
        $docext = substr($doumentname, strrpos($doumentname, '.') + 1);

        $documentfilename = md5(uniqid() . time()) . "." . $docext;
        $docfiletostore = $documentfolder . $documentfilename;

        $Documentpath = $documentfolder . $documentfilename;

        try {

            $move = move_uploaded_file($_FILES['entitydocfile']['tmp_name'], $docfiletostore);
        } catch (Exception $ex) {
            print_r($ex);
            return false;
        }


//upload signatory image to signatory folder
        $Signatoryfolder = $_SERVER['DOCUMENT_ROOT'] . '/apps/RylandInsurence/Signatory/';
        $signatoryimagename = $_FILES['entitysignatoryfile']['name'];

        $signatoryext = substr($signatoryimagename, strrpos($signatoryimagename, '.') + 1);

        $signatoryimagename = md5(uniqid() . time()) . "." . $signatoryext;
        $signatoryfiletostore = $Signatoryfolder . $signatoryimagename;

        $Signatorypath = $Signatoryfolder . $signatoryimagename;

        try {
            $move = move_uploaded_file($_FILES['entitysignatoryfile']['tmp_name'], $signatoryfiletostore);
        } catch (Exception $ex) {
            print_r($ex);
            return false;
        }




        $id = new MongoDB\BSON\ObjectID();

        $ids = array("_id" => $id);
        $this->mongo_db->insert('documents', $ids);
        $this->mongo_db->insert('signatory', $ids);

        $document = array('documentdetails' => array(
                'DocumentId' => new MongoDB\BSON\ObjectID(),
                'Documentname' => $this->encrypt_decrypt('encrypt', $this->input->post("entitydocname")),
                'Documentdescription' => $this->encrypt_decrypt('encrypt', $this->input->post("entitydescription")),
                'Documentpath' => $this->encrypt_decrypt('encrypt', $Documentpath),
                'Issuedate' => $this->encrypt_decrypt('encrypt', $this->input->post("entityissuedate")),
                'Expirydate' => $this->encrypt_decrypt('encrypt', $this->input->post("entityexpirydate"))
            ),
        );

        $this->mongo_db->updatewithpush('documents', $document, array("_id" => $id));

        $signatory = array('signatorydetails' => array(
                'SignatoryId' => new MongoDB\BSON\ObjectID(),
                'Signatorypname' => $this->encrypt_decrypt('encrypt', $this->input->post("entitypersonname")),
                'Signatorydescription' => $this->encrypt_decrypt('encrypt', $this->input->post("entitysignatorydescription")),
                'Signatorypath' => $this->encrypt_decrypt('encrypt', $Signatorypath),
                'Signatorypmobileno' => $this->encrypt_decrypt('encrypt', $this->input->post("entitysignatorymobileno")),
                'Spdesignation' => $this->encrypt_decrypt('encrypt', $this->input->post("entitydegination")),
                'Spemail' => $this->encrypt_decrypt('encrypt', $this->input->post("entitysignatoryemail"))
        ));

        $this->mongo_db->updatewithpush('signatory', $signatory, array("_id" => $id));

        $entitydata = array
            (
            "_id" => $id,
            "Name" => $this->encrypt_decrypt('encrypt', $this->input->post("entityname")),
            "Email" => $this->encrypt_decrypt('encrypt', $this->input->post("entityemail")),
            "Status" => $this->encrypt_decrypt('encrypt', $this->input->post("entitystatus")),
            "Registration_No" => $this->encrypt_decrypt('encrypt', $this->input->post("entityregno")),
            "Address" => $this->encrypt_decrypt('encrypt', $this->input->post("entityaddress")),
            "Town" => $this->encrypt_decrypt('encrypt', $this->input->post("entitytown")),
            "State" => $this->encrypt_decrypt('encrypt', $this->input->post("entitystate")),
            "Country" => $this->encrypt_decrypt('encrypt', $this->input->post("entitycountry")),
            "PObox" => $this->encrypt_decrypt('encrypt', $this->input->post("entitypobox")),
            "Zipcode" => $this->encrypt_decrypt('encrypt', $this->input->post("entityzipcode")),
            "Countrycode" => $this->encrypt_decrypt('encrypt', $this->input->post("countrycode")),
            "Last_Login_Time" => $this->encrypt_decrypt('encrypt', "NULL"),
            "Last_Login_Ip" => $this->encrypt_decrypt('encrypt', "NULL")
        );

        $this->mongo_db->insert($tablename, $entitydata);
    }

//load different entities
    public function LoadEntity($tablename = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get($tablename);

        $entities = array();
        $i = 0;
        foreach ($cursor as $data) {
            $data['Name'] = $this->encrypt_decrypt('decrypt', $data['Name']);
            $data['Email'] = $this->encrypt_decrypt('decrypt', $data['Email']);
            $data['Status'] = $this->encrypt_decrypt('decrypt', $data['Status']);
            $data['Last_Login_Time'] = $this->encrypt_decrypt('decrypt', $data['Last_Login_Time']);
            $data['Last_Login_Ip'] = $this->encrypt_decrypt('decrypt', $data['Last_Login_Ip']);
            $entities[$i] = $data;
            $i++;
        }
        return $entities;
    }

    public function loadOneEntity($tablename = '', $entityid = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->get_one($tablename, array("_id" => new MongoDB\BSON\ObjectID($entityid)));

        $cursor['Name'] = $this->encrypt_decrypt('decrypt', $cursor['Name']);
        $cursor['Email'] = $this->encrypt_decrypt('decrypt', $cursor['Email']);
        $cursor['Status'] = $this->encrypt_decrypt('decrypt', $cursor['Status']);
        $cursor['Registration_No'] = $this->encrypt_decrypt('decrypt', $cursor['Registration_No']);
        $cursor['Address'] = $this->encrypt_decrypt('decrypt', $cursor['Address']);
        $cursor['Town'] = $this->encrypt_decrypt('decrypt', $cursor['Town']);
        $cursor['State'] = $this->encrypt_decrypt('decrypt', $cursor['State']);
        $cursor['Country'] = $this->encrypt_decrypt('decrypt', $cursor['Country']);
        $cursor['PObox'] = $this->encrypt_decrypt('decrypt', $cursor['PObox']);
        $cursor['Zipcode'] = $this->encrypt_decrypt('decrypt', $cursor['Zipcode']);
        $cursor['Countrycode'] = $this->encrypt_decrypt('decrypt', $cursor['Countrycode']);

        $documents = $this->mongo_db->get_one('documents', array("_id" => new MongoDB\BSON\ObjectID($entityid)));

        $cursor['DocumentId'] = $documents['documentdetails'][0]['DocumentId'];
        $cursor['Documentname'] = $this->encrypt_decrypt('decrypt', $documents['documentdetails'][0]['Documentname']);
        $cursor['Documentdescription'] = $this->encrypt_decrypt('decrypt', $documents['documentdetails'][0]['Documentdescription']);
        $cursor['Documentpath'] = $this->encrypt_decrypt('decrypt', $documents['documentdetails'][0]['Documentpath']);
        $cursor['Issuedate'] = $this->encrypt_decrypt('decrypt', $documents['documentdetails'][0]['Issuedate']);
        $cursor['Expirydate'] = $this->encrypt_decrypt('decrypt', $documents['documentdetails'][0]['Expirydate']);

        $signatory = $this->mongo_db->get_one('signatory', array("_id" => new MongoDB\BSON\ObjectID($entityid)));

        $cursor['SignatoryId'] = $signatory['signatorydetails'][0]['SignatoryId'];
        $cursor['Signatorypname'] = $this->encrypt_decrypt('decrypt', $signatory['signatorydetails'][0]['Signatorypname']);
        $cursor['Signatorydescription'] = $this->encrypt_decrypt('decrypt', $signatory['signatorydetails'][0]['Signatorydescription']);
        $cursor['Signatorypath'] = $this->encrypt_decrypt('decrypt', $signatory['signatorydetails'][0]['Signatorypath']);
        $cursor['Signatorypmobileno'] = $this->encrypt_decrypt('decrypt', $signatory['signatorydetails'][0]['Signatorypmobileno']);
        $cursor['Spdesignation'] = $this->encrypt_decrypt('decrypt', $signatory['signatorydetails'][0]['Spdesignation']);
        $cursor['Spemail'] = $this->encrypt_decrypt('decrypt', $signatory['signatorydetails'][0]['Spemail']);

        return $cursor;
    }

    public function DeleteEntity($tablename = '', $entityid = '') {
        $this->load->library('mongo_db');

//first delete all stored documents of related entity
        $documents = $this->mongo_db->get_one('documents', array("_id" => new MongoDB\BSON\ObjectID($entityid)));

        foreach ($documents['documentdetails'] as $data) {
            $documentsfile = $this->encrypt_decrypt('decrypt', $data['Documentpath']);
            if (file_exists($documentsfile)) {
                unlink($documentsfile);
            }
        }

        $signatory = $this->mongo_db->get_one('signatory', array("_id" => new MongoDB\BSON\ObjectID($entityid)));

        foreach ($signatory['signatorydetails'] as $data) {
            $signatoryfile = $this->encrypt_decrypt('decrypt', $data['Signatorypath']);
            if (file_exists($signatoryfile)) {
                unlink($signatoryfile);
            }
        }

//now delete all the records for entity from different collections

        $this->mongo_db->delete('documents', array("_id" => new MongoDB\BSON\ObjectID($entityid)));
        $this->mongo_db->delete('signatory', array("_id" => new MongoDB\BSON\ObjectID($entityid)));
        $this->mongo_db->delete($tablename, array("_id" => new MongoDB\BSON\ObjectID($entityid)));
    }

// edit different entities with entityid
    function EditEntity($tablename, $entityid) {
//remove old uploaded documents signatory and upload newly added on server if not updated then
//remove keep old document as it is

        $olddocpath = $this->input->post("olddocpath");
        $oldsignatorypath = $this->input->post("oldsignatorypath");

        $did = $this->input->post("documentid");
        $sid = $this->input->post("signatoryid");

        $this->load->library('mongo_db');

        if ($_FILES['entitydocfile']['name']) {
            if (file_exists($olddocpath)) {
                unlink($olddocpath);
            }

            $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/apps/RylandInsurence/Documents/';
            $doumentname = $_FILES['entitydocfile']['name'];
            $docext = substr($doumentname, strrpos($doumentname, '.') + 1);

            $documentfilename = md5(uniqid() . time()) . "." . $docext;
            $docfiletostore = $documentfolder . $documentfilename;

            $Documentpath = $documentfolder . $documentfilename;

            try {

                $move = move_uploaded_file($_FILES['entitydocfile']['tmp_name'], $docfiletostore);
            } catch (Exception $ex) {
                print_r($ex);
                return false;
            }
        } else {
            $Documentpath = $olddocpath;
        }

        if ($_FILES['entitysignatoryfile']['name']) {
            if (file_exists($oldsignatorypath)) {
                unlink($oldsignatorypath);
            }

            $Signatoryfolder = $_SERVER['DOCUMENT_ROOT'] . '/apps/RylandInsurence/Signatory/';
            $signatoryimagename = $_FILES['entitysignatoryfile']['name'];

            $signatoryext = substr($signatoryimagename, strrpos($signatoryimagename, '.') + 1);

            $signatoryimagename = md5(uniqid() . time()) . "." . $signatoryext;
            $signatoryfiletostore = $Signatoryfolder . $signatoryimagename;

            $Signatorypath = $Signatoryfolder . $signatoryimagename;

            try {
                $move = move_uploaded_file($_FILES['entitysignatoryfile']['tmp_name'], $signatoryfiletostore);
            } catch (Exception $ex) {
                print_r($ex);
                return false;
            }
        } else {
            $Signatorypath = $oldsignatorypath;
        }

        /* $updateData = array('productsetup.$.size' => $size, 'productsetup.$.color' => $color, 'productsetup.$.price' => $price,'productsetup.$.offerprice' => $offerprice,'productsetup.$.taxids' => $taxid, 'productsetup.$.taxvalues' => $taxvalue);
          $cond = array('_id' => new MongoDB\BSON\ObjectID($pre_id), 'productsetup' => array('$elemMatch' => array('setup_id' => new MongoDB\BSON\ObjectID($setupid))));
          $SubCats->update($cond, array('$set' => $updateData), array('multiple' => 1)); */

        $updatedocument = array(
            'documentdetails.$.Documentname' => $this->encrypt_decrypt('encrypt', $this->input->post("entitydocname")),
            'documentdetails.$.Documentdescription' => $this->encrypt_decrypt('encrypt', $this->input->post("entitydescription")),
            'documentdetails.$.Documentpath' => $this->encrypt_decrypt('encrypt', $Documentpath),
            'documentdetails.$.Issuedate' => $this->encrypt_decrypt('encrypt', $this->input->post("entityissuedate")),
            'documentdetails.$.Expirydate' => $this->encrypt_decrypt('encrypt', $this->input->post("entityexpirydate"))
        );

        $cond = array('_id' => new MongoDB\BSON\ObjectID($entityid), 'documentdetails' => array('$elemMatch' => array('DocumentId' => new MongoDB\BSON\ObjectID($did))));
        $this->mongo_db->update('documents', $updatedocument, $cond);

        $updatesignatory = array(
            'signatorydetails.$.Signatorypname' => $this->encrypt_decrypt('encrypt', $this->input->post("entitypersonname")),
            'signatorydetails.$.Signatorydescription' => $this->encrypt_decrypt('encrypt', $this->input->post("entitysignatorydescription")),
            'signatorydetails.$.Signatorypath' => $this->encrypt_decrypt('encrypt', $Signatorypath),
            'signatorydetails.$.Signatorypmobileno' => $this->encrypt_decrypt('encrypt', $this->input->post("entitysignatorymobileno")),
            'signatorydetails.$.Spdesignation' => $this->encrypt_decrypt('encrypt', $this->input->post("entitydegination")),
            'signatorydetails.$.Spemail' => $this->encrypt_decrypt('encrypt', $this->input->post("entitysignatoryemail"))
        );

        $scond = array('_id' => new MongoDB\BSON\ObjectID($entityid), 'signatorydetails' => array('$elemMatch' => array('SignatoryId' => new MongoDB\BSON\ObjectID($sid))));
        $this->mongo_db->update('signatory', $updatesignatory, $scond);

        $updateentitydata = array
            (
            "Name" => $this->encrypt_decrypt('encrypt', $this->input->post("entityname")),
            "Email" => $this->encrypt_decrypt('encrypt', $this->input->post("entityemail")),
            "Status" => $this->encrypt_decrypt('encrypt', $this->input->post("entitystatus")),
            "Registration_No" => $this->encrypt_decrypt('encrypt', $this->input->post("entityregno")),
            "Address" => $this->encrypt_decrypt('encrypt', $this->input->post("entityaddress")),
            "Town" => $this->encrypt_decrypt('encrypt', $this->input->post("entitytown")),
            "State" => $this->encrypt_decrypt('encrypt', $this->input->post("entitystate")),
            "Country" => $this->encrypt_decrypt('encrypt', $this->input->post("entitycountry")),
            "PObox" => $this->encrypt_decrypt('encrypt', $this->input->post("entitypobox")),
            "Zipcode" => $this->encrypt_decrypt('encrypt', $this->input->post("entityzipcode")),
            "Countrycode" => $this->encrypt_decrypt('encrypt', $this->input->post("countrycode")),
            "Last_Login_Time" => $this->encrypt_decrypt('encrypt', "NULL"),
            "Last_Login_Ip" => $this->encrypt_decrypt('encrypt', "NULL")
        );

        $this->mongo_db->update($tablename, $updateentitydata, array("_id" => new MongoDB\BSON\ObjectID($entityid)));
    }

}

?>
