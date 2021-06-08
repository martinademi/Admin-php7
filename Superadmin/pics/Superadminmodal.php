<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");
  ini_set('display_errors', '1');
    error_reporting(E_ALL);
require_once 'S3.php';
//require_once 'StripeModule.php';
//require 'aws.phar';
//require_once 'AwsPush.php';

class Superadminmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
         $this->load->library('mongo_db');
    
    }

    function validateSuperAdmin() {

         $email = $this->input->post("email");
        $password = $this->input->post("password");

//        $this->load->library('mongo_db');
        $result = $this->mongo_db->get_where('admin_users', array('email' => $email, 'pass' => md5($password)));

        $role = 'Super Admin';
        if ($result['role'] != $role) {
            $role = $this->mongo_db->get_where('admin_roles', array('_id' => new MongoDB\BSON\ObjectID($result['role'])));
            $role = $role['role_name'];
        }

        if (count($result) > 0) {
            $tablename = 'company_info';
            $LoginId = 'company_id';
            $sessiondata = array(
                'emailid' => $email,
                'password' => $password,
                'LoginId' => $LoginId,
                'adminId' => (string) $result['_id'],
                'profile_pic' => $result['logo'],
                'first_name' => $result['name'],
                'access_rights' => $result['access'],
                'table' => $tablename,
                'city_id' => $result['city'],
                'city' => $result['city'],
                'role' => $role,
                'company_id' => '0',
                'validate' => true,
                'superadmin' => '1',
                'mainAdmin' => $result['superadmin']
            );
            $this->session->set_userdata($sessiondata);
            return true;
        }

        return false;
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
            $fdata['_id'] = new MongoId();
            $this->mongo_db->insert('admin_roles',$fdata);
            echo json_encode(array('msg' => '1', 'insert' => (String)$fdata['_id'], 'access' => $fdata['access']));
            die;
        }else {
            $this->mongo_db->update('admin_roles', $fdata, array('_id' => new MongoId($edit_id)));
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
    function forgotPasswordFromadmin() {
        $email =$this->input->post('email');
        $this->load->library('mongo_db');
        $result = $this->mongo_db->get_one('admin_users', array('email' =>$email));
       
        if ($result['role'] != '') {
            $randNum = substr($result['name'],0,3).mt_rand(1000, 99999);
            $this->emailForResetPasswordForadmin($result['email'],$result['name'],$randNum);
            $this->mongo_db->update('admin_users', array('pass' =>md5($randNum)),array('email'=>$email));
           echo json_encode(array('flag'=>0,'msg'=>'New password sent to '.$email));
           return;
        }
        else{
           echo json_encode(array('flag'=>1,'msg'=>'Entered email id doesnot exist in database'));
            return;
        }

    }
    
    
    function user_action() {
         $this->load->library('mongo_db');
        $edit_id = $this->input->post('edit_id');
        $fdata = $this->input->post('fdata');
        foreach ($fdata['access'] as $key => $val) {
            $fdata['access'][$key] = (int) $val;
        }
//        print_r($fdata);die;
        if ($edit_id == '') {
            $fdata['pass'] = md5($fdata['pass']);
            $this->mongo_db->insert('admin_users', $fdata);
//            echo json_encode(array('msg' => '1', 'insert' => $edit_id));
//            die;
        }else {
            $this->mongo_db->update('admin_users', $fdata, array('_id' => new MongoId($edit_id)));
//            echo json_encode(array('msg' => '1', 'insert' => '0'));
//            die;
        }
//        echo json_encode(array('msg' => '0'));
        redirect(base_url() . "index.php/accessctrl/manageRole");
    }
    
    function updateMake() {
        $make = $this->input->post('m_name');
        $m_id = $this->input->post('id');
        
   
       $this->db->query("update vehicleType set vehicletype ='" . $make . "' where id =".$m_id."");
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "Updated  succesfully", 'flag' => 0));
            return;
        }
        else
        {
             echo json_encode(array('msg' => "Updating failed...", 'flag' => 1));
            return;
            
        }
    }
    
    function getDispatcerData() {
    $dis_id = $this->input->post('val');
        foreach ($dis_id as $id)
        {
            $dispatcher_data= $this->db->query("select * from dispatcher where dis_id = '" . $id . "'")->result();
            echo json_encode($dispatcher_data);
            return;
        }
        
    }
    function upload_images_on_amazon() {
        $name = $_FILES['OtherPhoto']['name']; // filename to get file's extension
        $size = $_FILES['OtherPhoto']['size'];

        $fold_name =$_REQUEST['folder'];
        $type = $_REQUEST['type'];

        $ext = substr($name, strrpos($name, '.') + 1);


        $dat = getdate();
        $rename_file = "file" . $dat['year'] . $dat['mon'] . $dat['mday'] . $dat['hours'] . $dat['minutes'] . $dat['seconds'] . "." . $ext;
        $flag = FALSE;

        $tmp1 = $_FILES['OtherPhoto']['tmp_name'];

        $uploadFile = $tmp1;
        $bucketName = bucketName;

        if (!file_exists($uploadFile) || !is_file($uploadFile)){
            echo 'if-1';
            exit("\nERROR: No such file: $uploadFile\n\n");

        }
        if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll')){
            exit("\nERROR: CURL extension not loaded\n\n");

        }
      
        if (AMAZON_AWS_ACCESS_KEY == 'change-this' || AMAZON_AWS_AUTH_SECRET == 'change-this'){
            exit("\nERROR: AWS access information required\n\nPlease edit the following lines in this file:\n\n" .
                "define('AMAZON_AWS_ACCESS_KEY', 'change-me');\ndefine('AMAZON_AWS_AUTH_SECRET', 'change-me');\n\n");
        }
        
        
        // Instantiate the class
        $s3 = new S3(AMAZON_AWS_ACCESS_KEY, AMAZON_AWS_AUTH_SECRET);
       

        //// Put our file (also with public read access)
        if ($s3->putObjectFile($uploadFile, $bucketName,$type . '/'.$fold_name.'/'. $rename_file, S3::ACL_PUBLIC_READ)) {
            $flag = true;
        }

        if ($flag) {
            echo json_encode(array('msg' => '1', 'fileName' => $bucketName . '/'.$type.'/'.$fold_name. '/'. $rename_file));
        } else {
            echo json_encode(array('msg' => '2', 'folder' => $fold_name));
        }
        return;
    }
    
    
     function updateModel() {
        $make_name = $this->input->post('m_name');
        $model_name = $this->input->post('model_name');
        $model_id = $this->input->post('model_id');
        
   
       $this->db->query("update vehiclemodel set vehicletypeid ='" . $make_name . "',vehiclemodel = '".$model_name."' where id =".$model_id."");
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "Updated  succesfully", 'flag' => 0));
            return;
        }
        else
        {
             echo json_encode(array('msg' => "Updating failed...", 'flag' => 1));
            return;
            
        }
    }

    
    function getZoneCity() {

        $this->load->library('table');
        $this->load->library('mongo_db');
        
        
        $city_id = $this->input->post('city_id');
        $db = $this->mongo_db->db;
        $zoneData = $db->selectCollection('zones')->find(array('_id' =>new MongoId($city_id)))->limit(1);
        
       $c = '';
        
        foreach ($zoneData as $res)
            $c = $res['city'];
        
        echo json_encode(array('city'=>$c));
        return;
        
    }
    function vehicleTypeData() {
        
        $vehicleData = $this->db->query("select type_id,type_name,type_desc from workplace_types")->result();
        return $vehicleData;

    }
    function getGoodTypes() {
        
       $this->load->library('mongo_db');
       $selectedGoodTypes = $this->mongo_db->get_one('vehicleTypes',array('type'=>(int)$this->input->post('vehicleTypeID')));
       $allGoodTypes = $this->mongo_db->get('Driver_specialities');
       
        echo "<option value=''>Select</option>";
             foreach ($allGoodTypes as $goodType) {
                 if(in_array($goodType['_id'],$selectedGoodTypes['goodTypes']))
                    echo "<option value='" . $goodType['_id'] . "'>" .$goodType['name']."</option>";
            }

    }
    function getAllGoodTypes() {
        
       $this->load->library('mongo_db');
//       $selectedGoodTypes = $this->mongo_db->get_one('vehicleTypes',array('type'=>(int)$this->input->post('vehicleTypeID')));
       $allGoodTypes = $this->mongo_db->get('Driver_specialities');
       return $allGoodTypes;

    }
    function get_appointment_details() {
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
       $allDocs = array();

        $city = $this->session->userdata('city_id');
        $company = $this->session->userdata('company_id');

        $comp_ids = array();
        if($city != '0')
        {
            
            $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
            foreach ($query as $row)
                $comp_ids[] =  (int)$row->company_id;
            
             $comp_ids = implode(',',$comp_ids);
             
             if(empty($comp_ids))
                $comp_ids = 0;
            
            if($company != '0')
                $comp_ids = $company;
             
             $mysqlDataApp = $this->db->query("select mas_id from master where company_id in (".$comp_ids.")")->result();
             
            
        }
        else{
            $mysqlDataApp = $this->db->query("select mas_id from master")->result();
        }

      
         $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('order_id'=>(int)$this->input->post('app_id')));
        
       
         $datatosend1 = array();
         $Apptstatus = array('0'=>'Status Unavailable','1'=>'Request','2'=>'Driver Accepted the Job','3'=>'Driver Rejected the Job','4'=>'Customer Cancelled After Booking',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','21'=>'Driver Unloaded the Vehicle','22'=>'Completed');
         
          $adminActionStatus = array('1'=>'Force Completed by Admin','2'=>'Force Cancelled by Admin');
       
          
          foreach ($mysqlDataApp as $sqlData)
              $mas_ids[]=$sqlData->mas_id;
          
           
                foreach ($mongoData as $row)
                {
                   
                     foreach ($row['receivers'] as $rec)
                    {
                        
                           $allDocs[] = array('appointment_id'=>$row['order_id'],'mas_id'=>$row['driverDetails']['entityId'],'first_name'=>$row['driverDetails']['firstName'],'mobile'=>$row['driverDetails']['mobile'],'passenger_id'=>$row['slave_id'],'passanger_fname'=>$row['slaveName'],'phone'=>$row['slavemobile'],'appointment_dt'=>date('j-M-Y H:i:s',strtotime($row['booking_time'])),'address_line1'=>$row['address_line1'],'drop_addr1'=>$row['drop_addr1'],'status'=>$Apptstatus[$rec['status']],'type_name'=>$row['vehicleType']['type_name'],'payment_type'=>$row['payment_type'],'bookingType'=>$row['appt_type']);
                           
                    }
                }

        echo json_encode(array('data' => $allDocs));
    }

    function insert_vehicle_price($param1 ='',$param2 = '') {
        $this->load->library('mongo_db');
        $vehiclePrice = $this->input->post('price');
//        $insertArr[$param2] = $vehiclePrice;
        
         $this->mongo_db->update('zones',array('zones_price.'.$param2=>$vehiclePrice),array('_id' =>new MongoId($param1)));
//         $this->mongo_db->updatewithpush('zones',array('zones_price'=>$insertArr),array('_id' =>new MongoId($param1))); 
        
        return;
       
//
//        $db = $this->mongo_db->db;
//        $get = $db->selectCollection('zones');
//        $data = $get->findOne(array('zones_price.'.$param2=>array('$exists'=>1)));
        
//       if($data)
//       {
//           $this->mongo_db->update('zones',array('zones_price.'.$param2=>$vehiclePrice),array('_id' =>new MongoId($param1)));
//       }
//       else
//          $this->mongo_db->updatewithpush('zones',array('zones_price'=>$insertArr),array('_id' =>new MongoId($param1))); 
        
        
    }
    function GetRechargedata_ajax() {

        $this->load->library('Datatables');
        $this->load->library('table');
        $this->datatables->select("m.last_name,m.mas_id,m.first_name,ROUND(((select sum(RechargeAmount) from DriverRecharge where m.mas_id = mas_id) - (select COALESCE(sum(app_owner_pl),0) from appointment where status = 9  and mas_id = m.mas_id)),2),(select RechargeDate from DriverRecharge where m.mas_id = mas_id order by id desc limit 1)", false)
                ->edit_column('m.last_name', 'counter/$1', 'm.mas_id')
                ->add_column('OPERATION', '<a href="' . base_url("index.php/superadmin/DriverRechargeStatement/$1") . '"><button class="btn btn-success btn-cons" style="min-width: 83px !important;">STATEMENT</button></a>
            <a href="' . base_url("index.php/superadmin/Recharge/$1") . '"><button class="btn btn-success btn-cons" style="min-width: 83px !important;">RECHARGE</button>', 'm.mas_id')
                ->from('master m');

        echo $this->datatables->generate();
    }

    function DriverRechargeStatement($id) {

        $this->load->library('Datatables');
        $this->load->library('table');
        $this->datatables->select("ap.OpeningBal,ap.appointment_id,ROUND(ap.app_owner_pl,2),ap.ClosingBal", false)
                ->from('appointment ap')
                ->where('ap.mas_id', $id);
        echo $this->datatables->generate();
    }
     function getInvoice($id) {

        $this->load->library('mongo_db');

        $db = $this->mongo_db->db;
        $get_shipment_details = $db->selectCollection('ShipmentDetails');
        $shipment_data = $get_shipment_details->findOne(array('order_id' => (int)$id));
        
        $Txn_id = $this->db->query("select * from appointment where appointment_id = '".$id."'")->row_array();
       

        $amount =  0;
        $counter = 2;
        $paymentType = '';
        
          $appDate = date('d-m-Y',  strtotime($shipment_data['appointment_date']));
        foreach($shipment_data['receivers'] as $res)
           $amount = $amount + $res['Accounting']['amount'];
        
        foreach ($shipment_data['invoice'] as $apptDet) {
            $paymentType = $apptDet['payment_status'];
            
//            $amount = $amount + $shipement['Accounting']['amount'];
            
            
            $innderhtml .= '<table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;max-width:640px;border-bottom-width:1px;border-bottom-color:#f0f0f0;border-bottom-style:solid;padding:0;" id="yui_3_16_0_1_1449814152286_3229"><tbody id="yui_3_16_0_1_1449814152286_3228"><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3227"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:inline-block;width:300px;padding:25px 10px 25px 5px;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3226">
                                                            <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;margin-left:19px;padding:0;" id="yui_3_16_0_1_1449814152286_3225">
                                                                <tbody id="yui_3_16_0_1_1449814152286_3224">
<!--                                                                    <tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3223"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:inline-block;width:300px;padding:0;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3222">
                                                                            <img width="279" height="217" src="" style="outline:none;text-decoration:none;float:none;clear:none;display:block;width:279px;min-height:217px;border-radius:3px 3px 0 0;border:1px solid #d7d7d7;" id="yui_3_16_0_1_1449814152286_3221"></td>
                                                                    </tr>-->



                                                                    <tr style="vertical-align:top;text-align:left;width:279px;display:block;background-color:#fafafa;padding:20px 0;border-color:#e3e3e3;border-style:solid;border-width:1px 1px 0px;" align="left" bgcolor="#FAFAFA" id="yui_3_16_0_1_1449814152286_3255"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:inline-block;width:279px;padding:0;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3254">
                                                                            <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:auto;padding:0;" id="yui_3_16_0_1_1449814152286_3253"><tbody id="yui_3_16_0_1_1449814152286_3252"><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3258"><td rowspan="2" style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:17px!important;padding:3px 10px 10px 17px;" align="left" valign="top">
                                                                                            <img width="13" height="80" src="'.base_url().'../../images/route.png" style="outline:none;text-decoration:none;float:left;clear:both;display:block;" align="left"></td>
                                                                                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:279px;line-height:16px;min-height:57px;padding:0 10px 10px 0;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3257">
                                                                                            <span style="font-size:15px;font-weight:500;color:#000000!important;">
                                                                                                ' . date('h:i', strtotime($apptDet['DriverLoadedStartedTime'])) . '
                                                                                            </span><br><span style="font-size:11px;color:#999999!important;line-height:16px;text-decoration:none;" id="yui_3_16_0_1_1449814152286_3256">' . $apptDet['pickupAddress'] . '</span>
                                                                                        </td>
                                                                                    </tr><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3251"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:279px;line-height:16px;min-height:auto;padding:0 0px 0 0;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3250">
                                                                                            <span style="font-size:15px;font-weight:500;color:#000000!important;">

                                                                                                ' . date('h:i', strtotime($apptDet['completedTime'])) . '

                                                                                            </span><br><span style="font-size:11px;color:#999999!important;line-height:16px;text-decoration:none;" id="yui_3_16_0_1_1449814152286_3249">' . $apptDet['dropAddress'] . '</span>
                                                                                        </td>
                                                                                    </tr></tbody></table></td>
                                                                    </tr><tr style="vertical-align:top;text-align:left;width:279px;display:block;background-color:#fafafa;padding:0;border:1px solid #e3e3e3;" align="left" bgcolor="#FAFAFA"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell!important;width:279px!important;padding:0;" align="left" valign="top">
                                                                            <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;color:#959595;line-height:14px;padding:0;"><tbody><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left"><td style="border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell!important;width:33%!important;line-height:16px;padding:6px 10px 10px;" align="center" valign="top">
                                                                                            <span style="font-size:9px;text-transform:uppercase;">VEHICLE</span><br><span style="font-size:13px;color:#111125;font-weight:normal;">
                                                                                                ' . $apptDet['vehicleType'] . '
                                                                                            </span>
                                                                                        </td>
                                                                                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell!important;width:33%!important;line-height:16px;padding:6px 10px 10px;" align="center" valign="top">
                                                                                            <span style="font-size:9px;text-transform:uppercase;">' . APP_DISTANCE_METRIC . '</span><br><span style="font-size:13px;color:#111125;font-weight:normal;">
                                                                                                ' .$apptDet['distance'] . '
                                                                                            </span>
                                                                                        </td>
                                                                                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell!important;width:33%!important;line-height:16px;padding:6px 10px 10px;" align="center" valign="top">
                                                                                            <span style="font-size:9px;text-transform:uppercase;">TRIP TIME</span><br><span style="font-size:13px;color:#111125;font-weight:normal;">
                                                                                                ' . $apptDet['TripTIme'] . '

                                                                                            </span>
                                                                                        </td>
                                                                                    </tr></tbody></table></td>
                                                                    </tr>

                                                                </tbody></table></td>


                                                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:inline-block;width:300px;padding:10px;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3259">
                                                            <span style="display:block;padding:0px 8px 0 10px;" id="yui_3_16_0_1_1449814152286_3264">




                                                                <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%!important;padding:0;" id="yui_3_16_0_1_1449814152286_3268"><tbody id="yui_3_16_0_1_1449814152286_3267"><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3266"><td style="border-collapse:collapse!important;vertical-align:middle;text-align:left;display:table-cell;width:auto!important;padding:12px 0 5px;" align="left" valign="middle"><p style="color:#222222;font-weight:normal;text-align:left;line-height:0;font-size:14px;border-bottom-style:solid;border-bottom-width:1px;border-bottom-color:#e3e3e3;display:block;margin:0;padding:0;" align="left"></p></td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:middle;text-align:center;display:table-cell;width:120px!important;font-size:11px;white-space:pre-wrap;padding:12px 10px 5px;" align="center" valign="middle" id="yui_3_16_0_1_1449814152286_3265">FARE BREAKDOWN</td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:middle;text-align:left;display:table-cell;width:auto!important;padding:12px 0 5px;" align="left" valign="middle"><p style="color:#222222;font-weight:normal;text-align:left;line-height:0;font-size:14px;border-bottom-style:solid;border-bottom-width:1px;border-bottom-color:#e3e3e3;display:block;margin:0;padding:0;" align="left"></p></td>
                                                                        </tr></tbody></table><table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;margin-top:15px;width:auto;padding:0;" id="yui_3_16_0_1_1449814152286_3263">



                                                                    <tbody id="yui_3_16_0_1_1449814152286_3262">
                                                                        <tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3271"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:300px;color:#808080;padding:4px;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3270">
                                                                                Delivery Fee
                                                                            </td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;padding:4px;" align="right" valign="top">
                                                                                ' . ($apptDet['amount'] + $apptDet['gotDiscount']) . '
                                                                                
                                                                            </td>
                                                                        </tr>';
            if ($apptDet['gotDiscount'] != 0) {
                $innderhtml .= '<tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3271"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:300px;color:#808080;padding:4px;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3270">
                                                                               Discount
                                                                            </td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;padding:4px;" align="right" valign="top">
                                                                               ' . $apptDet['gotDiscount'] . '   
                                                                            </td>
                                                                        </tr>';
            }

            $innderhtml .='<tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:300px;color:#808080;padding:4px;" align="left" valign="top">
                                                                                Distance
                                                                            </td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;padding:4px;" align="right" valign="top">
                                                                                ' . $apptDet['distance'] . '   
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="vertical-align:top;text-align:left;border-bottom-width:1px;border-bottom-color:#f0f0f0;border-bottom-style:solid;width:100%;padding:0;" align="left"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:300px;color:#808080;padding:4px 4px 15px;" align="left" valign="top">
                                                                                Time                                                                           

                                                                            </td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;padding:4px 4px 15px;" align="right" valign="top">
                                                                                ' . $apptDet['TripTIme'] . '
                                                                            </td>
                                                                        </tr>



                                                                        <tr style="vertical-align:top;text-align:left;font-weight:bold;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3261"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:300px;color:#111125;padding:15px 4px 4px;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3260">Subtotal</td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;padding:15px 4px 4px;" align="right" valign="top">' . currency . ' &nbsp;' . $apptDet['amount'] . '</td>
                                                                        </tr>

<!--                                                                        <tr style="vertical-align:top;text-align:left;border-bottom-width:1px;border-bottom-color:#f0f0f0;border-bottom-style:solid;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3280"><td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:300px;color:#808080;font-size:11px;padding:4px 4px 15px;" align="right" valign="top" id="yui_3_16_0_1_1449814152286_3279">
                                                                                Rounding Down
                                                                            </td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;color:#1fbad6;padding:4px 4px 15px;" align="right" valign="top">
                                                                                -0.36
                                                                            </td>
                                                                        </tr>-->





                                                                        <tr style="vertical-align:top;text-align:left;border-bottom-width:1px;border-bottom-color:#f0f0f0;border-bottom-style:solid;width:100%;padding:0;" align="left">
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:300px;color:#808080;line-height:18px;padding:15px 4px;" align="left" valign="top">';
            if ($apptDet['payment_type'] == 2) {
                $innderhtml .= '<span style="font-size:9px;line-height:7px;">CHARGED</span>
                                                                                    <br>
                                                                                    <img src="' . APP_SERVER_HOST . 'images/cash_24.png" width="17" height="12" style="outline:none;text-decoration:none;float:left;clear:both;display:block;width:17px!important;min-height:12px;margin-right:5px;margin-top:3px;" align="left">
                                                                                    <span style="font-size:13px;">
                                                                                        Cash
                                                                                    </span>';
            } else {
                $innderhtml .='<span style="font-size:9px;line-height:7px;">CHARGED</span>
                                                                                    <br>
                                                                                    <img src="' . APP_SERVER_HOST . 'images/cash_24.png" width="17" height="12" style="outline:none;text-decoration:none;float:left;clear:both;display:block;width:17px!important;min-height:12px;margin-right:5px;margin-top:3px;" align="left">
                                                                                    <span style="font-size:13px;">
                                                                                        Card
                                                                                    </span>';
            }

            $innderhtml .='</td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;font-size:19px;font-weight:bold;line-height:30px;padding:26px 4px 15px;" align="right" valign="top">
                                                                                ' . currency . '&nbsp;' . $apptDet['amount'] . '
                                                                            </td>
                                                                        </tr></tbody></table>
                                                                        <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:auto;padding:0;" id="yui_3_16_0_1_1449814152286_3284"><tbody id="yui_3_16_0_1_1449814152286_3283"><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3282"><td style="border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell;width:300px;font-size:15px;padding:16px 10px 0px;" align="center" valign="top" id="yui_3_16_0_1_1449814152286_3281">
                                                                                <span></span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody></table>

                                                                <span style="line-height:1px;font-size:1px;color:#ffffff;"></span>
                                                                <br><span style="line-height:1px;font-size:1px;color:#ffffff;"></span>
                                                            </span>
                                                        </td>
                                                    </tr></tbody>';
            $counter++;
        }
//        }


        $html = '<div style="width:100%!important;color:#222222;font-weight:normal;text-align:left;line-height:19px;font-size:14px;background-color:#111125;margin:0;padding:0;" id="yui_3_16_0_1_1449814152286_3243">
    <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;min-height:100%;width:100%;color:#222222;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" id="yui_3_16_0_1_1449814152286_3242">
        <tbody id="yui_3_16_0_1_1449814152286_3241">
            <tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3240">
                <td align="center" valign="top" style="border-collapse:collapse!important;vertical-align:top;text-align:center;padding:0;" id="yui_3_16_0_1_1449814152286_3239">
        <center style="width:100%;min-width:580px;margin-top:2%" id="yui_3_16_0_1_1449814152286_3238">
			<table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:640px;margin:0 10px;padding:0">
				<tbody>
				<tr style="vertical-align:top;text-align:left;width:100%;padding:0" align:"left;">
					<td style="width:127px;border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;padding:28px 0;">
					<img src="'.base_url().'theme/icon/shypr-admin.jpg" width:60px; height:60px; style="outline:none;text-decoration:none;float:left;clear:both;display:block;" align:"left;">
					</td>
					
					<td rowspan="2" style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;font-size:11px;color:#999999;line-height:15px;text-transform:uppercase;padding:30px 0 26px" align:"right;">
					<input type="button" value="Print" onClick="window.print()">
                                          <br><br><br><br><span style="font-size: 15px">'.$appDate.'</span>
					</td>
                                       
				</tr>
                                
				</tbody>
			</table>

            <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:660px;margin:0 auto;padding:0;" id="yui_3_16_0_1_1449814152286_3237">
                <tbody id="yui_3_16_0_1_1449814152286_3236">
                    <tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3235">
                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;padding:0;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3234">

                            <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:640px;max-width:640px;border-radius:2px;background-color:#ffffff;margin:0 10px;padding:0;" bgcolor="#ffffff" id="yui_3_16_0_1_1449814152286_3233">
                                <tbody id="yui_3_16_0_1_1449814152286_3232">
                                    <tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3231">
                                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:inline-block;width:100%;padding:0;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3230">
                                            <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;max-width:640px;border-bottom-width:1px;border-bottom-color:#e3e3e3;border-bottom-style:solid;padding:0;"><tbody><tr style="vertical-align:top;text-align:left;width:100%;background-color:rgb(250,250,250);padding:0;" align="left">
                                                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:inline-block;width:299px;border-radius:3px 0 0 0;background-color:#fafafa;padding:26px 10px 20px;" align="left" bgcolor="#FAFAFA" valign="top">
                                                            <span style="font-weight:bold;font-size:32px;color:#000;line-height:30px;padding-left:15px;">
                                                                ' . currency . ' ' . $amount . '
                                                            </span>
                                                           
                                                            <span style="font-weight:bold;font-size:12px;color:grey;line-height:30px;padding-left:45%;">
                                                               TXN ID :' . $Txn_id['txn_id'] . '
                                                            </span>


                                                        </td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>

' . $innderhtml . '






                                            












                                                                <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:auto;padding:0;" id="yui_3_16_0_1_1449814152286_3284"><tbody id="yui_3_16_0_1_1449814152286_3283"><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3282"><td style="border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell;width:300px;font-size:15px;padding:16px 10px 0px;" align="center" valign="top" id="yui_3_16_0_1_1449814152286_3281">
                                                                                <span></span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody></table>

                                                                <span style="line-height:1px;font-size:1px;color:#ffffff;"></span>
                                                                <br><span style="line-height:1px;font-size:1px;color:#ffffff;"></span>
                                                            </span>
                                                        </td>
                                                    </tr></tbody></table></td>
													
											
													
                                    </tr></tbody></table></td>
                    </tr></tbody></table></td>
			
                    </tr></tbody></table>           



        </center>
        </td>
        </tr></tbody></table>

</div>';

        echo $html;
    }
    
    
     function getInvoiceForcompleted($id) {

        $this->load->library('mongo_db');

        $db = $this->mongo_db->db;
        $get_shipment_details = $db->selectCollection('ShipmentDetails');
        $shipment_data = $get_shipment_details->findOne(array('order_id' => (int)$id));
        
        $Txn_id = $this->db->query("select * from appointment where appointment_id = '".$id."'")->row_array();
       

        $amount =  0;
        $counter = 2;
        $paymentType = '';
        
           $appDate = date('d-m-Y',  strtotime($shipment_data['appointment_date']));
        foreach($shipment_data['receivers'] as $res)
           $amount = $amount + $res['Accounting']['amount'];
        
        foreach ($shipment_data['invoice'] as $apptDet) {
            $paymentType = $apptDet['payment_status'];
            
//            $amount = $amount + $shipement['Accounting']['amount'];
            
            
            $innderhtml .= '<table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;max-width:640px;border-bottom-width:1px;border-bottom-color:#f0f0f0;border-bottom-style:solid;padding:0;" id="yui_3_16_0_1_1449814152286_3229"><tbody id="yui_3_16_0_1_1449814152286_3228"><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3227"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:inline-block;width:300px;padding:25px 10px 25px 5px;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3226">
                                                            <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;margin-left:19px;padding:0;" id="yui_3_16_0_1_1449814152286_3225">
                                                                <tbody id="yui_3_16_0_1_1449814152286_3224">
<!--                                                                    <tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3223"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:inline-block;width:300px;padding:0;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3222">
                                                                            <img width="279" height="217" src="'.App_image.'" style="outline:none;text-decoration:none;float:none;clear:none;display:block;width:279px;min-height:217px;border-radius:3px 3px 0 0;border:1px solid #d7d7d7;" id="yui_3_16_0_1_1449814152286_3221"></td>
                                                                    </tr>-->



                                                                    <tr style="vertical-align:top;text-align:left;width:279px;display:block;background-color:#fafafa;padding:20px 0;border-color:#e3e3e3;border-style:solid;border-width:1px 1px 0px;" align="left" bgcolor="#FAFAFA" id="yui_3_16_0_1_1449814152286_3255"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:inline-block;width:279px;padding:0;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3254">
                                                                            <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:auto;padding:0;" id="yui_3_16_0_1_1449814152286_3253"><tbody id="yui_3_16_0_1_1449814152286_3252"><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3258"><td rowspan="2" style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:17px!important;padding:3px 10px 10px 17px;" align="left" valign="top">
                                                                                            <img width="13" height="80" src="' . APP_SERVER_HOST . 'images/route.png" style="outline:none;text-decoration:none;float:left;clear:both;display:block;" align="left"></td>
                                                                                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:279px;line-height:16px;min-height:57px;padding:0 10px 10px 0;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3257">
                                                                                            <span style="font-size:15px;font-weight:500;color:#000000!important;">
                                                                                                ' . date('h:i', strtotime($apptDet['DriverLoadedStartedTime'])) . '
                                                                                            </span><br><span style="font-size:11px;color:#999999!important;line-height:16px;text-decoration:none;" id="yui_3_16_0_1_1449814152286_3256">' . $apptDet['pickupAddress'] . '</span>
                                                                                        </td>
                                                                                    </tr><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3251"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:279px;line-height:16px;min-height:auto;padding:0 0px 0 0;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3250">
                                                                                            <span style="font-size:15px;font-weight:500;color:#000000!important;">

                                                                                                ' . date('h:i', strtotime($apptDet['completedTime'])) . '

                                                                                            </span><br><span style="font-size:11px;color:#999999!important;line-height:16px;text-decoration:none;" id="yui_3_16_0_1_1449814152286_3249">' . $apptDet['dropAddress'] . '</span>
                                                                                        </td>
                                                                                    </tr></tbody></table></td>
                                                                    </tr><tr style="vertical-align:top;text-align:left;width:279px;display:block;background-color:#fafafa;padding:0;border:1px solid #e3e3e3;" align="left" bgcolor="#FAFAFA"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell!important;width:279px!important;padding:0;" align="left" valign="top">
                                                                            <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;color:#959595;line-height:14px;padding:0;"><tbody><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left"><td style="border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell!important;width:33%!important;line-height:16px;padding:6px 10px 10px;" align="center" valign="top">
                                                                                            <span style="font-size:9px;text-transform:uppercase;">VEHICLE</span><br><span style="font-size:13px;color:#111125;font-weight:normal;">
                                                                                                ' . $apptDet['vehicleType'] . '
                                                                                            </span>
                                                                                        </td>
                                                                                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell!important;width:33%!important;line-height:16px;padding:6px 10px 10px;" align="center" valign="top">
                                                                                            <span style="font-size:9px;text-transform:uppercase;">' . APP_DISTANCE_METRIC . '</span><br><span style="font-size:13px;color:#111125;font-weight:normal;">
                                                                                                ' .$apptDet['distance'] . '
                                                                                            </span>
                                                                                        </td>
                                                                                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell!important;width:33%!important;line-height:16px;padding:6px 10px 10px;" align="center" valign="top">
                                                                                            <span style="font-size:9px;text-transform:uppercase;">TRIP TIME</span><br><span style="font-size:13px;color:#111125;font-weight:normal;">
                                                                                                ' . $apptDet['TripTIme'] . '

                                                                                            </span>
                                                                                        </td>
                                                                                    </tr></tbody></table></td>
                                                                    </tr>

                                                                </tbody></table></td>


                                                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:inline-block;width:300px;padding:10px;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3259">
                                                            <span style="display:block;padding:0px 8px 0 10px;" id="yui_3_16_0_1_1449814152286_3264">




                                                                <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%!important;padding:0;" id="yui_3_16_0_1_1449814152286_3268"><tbody id="yui_3_16_0_1_1449814152286_3267"><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3266"><td style="border-collapse:collapse!important;vertical-align:middle;text-align:left;display:table-cell;width:auto!important;padding:12px 0 5px;" align="left" valign="middle"><p style="color:#222222;font-weight:normal;text-align:left;line-height:0;font-size:14px;border-bottom-style:solid;border-bottom-width:1px;border-bottom-color:#e3e3e3;display:block;margin:0;padding:0;" align="left"></p></td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:middle;text-align:center;display:table-cell;width:120px!important;font-size:11px;white-space:pre-wrap;padding:12px 10px 5px;" align="center" valign="middle" id="yui_3_16_0_1_1449814152286_3265">FARE BREAKDOWN</td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:middle;text-align:left;display:table-cell;width:auto!important;padding:12px 0 5px;" align="left" valign="middle"><p style="color:#222222;font-weight:normal;text-align:left;line-height:0;font-size:14px;border-bottom-style:solid;border-bottom-width:1px;border-bottom-color:#e3e3e3;display:block;margin:0;padding:0;" align="left"></p></td>
                                                                        </tr></tbody></table><table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;margin-top:15px;width:auto;padding:0;" id="yui_3_16_0_1_1449814152286_3263">



                                                                    <tbody id="yui_3_16_0_1_1449814152286_3262">
                                                                        <tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3271"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:300px;color:#808080;padding:4px;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3270">
                                                                                Delivery Fee
                                                                            </td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;padding:4px;" align="right" valign="top">
                                                                                ' . ($apptDet['amount'] + $apptDet['gotDiscount']) . '
                                                                                
                                                                            </td>
                                                                        </tr>';
            if ($apptDet['gotDiscount'] != 0) {
                $innderhtml .= '<tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3271"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:300px;color:#808080;padding:4px;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3270">
                                                                               Discount
                                                                            </td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;padding:4px;" align="right" valign="top">
                                                                               ' . $apptDet['gotDiscount'] . '   
                                                                            </td>
                                                                        </tr>';
            }

            $innderhtml .='<tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:300px;color:#808080;padding:4px;" align="left" valign="top">
                                                                                Distance
                                                                            </td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;padding:4px;" align="right" valign="top">
                                                                                ' . $apptDet['distance'] . '   
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="vertical-align:top;text-align:left;border-bottom-width:1px;border-bottom-color:#f0f0f0;border-bottom-style:solid;width:100%;padding:0;" align="left"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:300px;color:#808080;padding:4px 4px 15px;" align="left" valign="top">
                                                                                Time                                                                           

                                                                            </td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;padding:4px 4px 15px;" align="right" valign="top">
                                                                                ' . $apptDet['TripTIme'] . '
                                                                            </td>
                                                                        </tr>



                                                                        <tr style="vertical-align:top;text-align:left;font-weight:bold;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3261"><td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:300px;color:#111125;padding:15px 4px 4px;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3260">Subtotal</td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;padding:15px 4px 4px;" align="right" valign="top">' . currency . ' &nbsp;' . $apptDet['amount'] . '</td>
                                                                        </tr>

<!--                                                                        <tr style="vertical-align:top;text-align:left;border-bottom-width:1px;border-bottom-color:#f0f0f0;border-bottom-style:solid;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3280"><td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:300px;color:#808080;font-size:11px;padding:4px 4px 15px;" align="right" valign="top" id="yui_3_16_0_1_1449814152286_3279">
                                                                                Rounding Down
                                                                            </td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;color:#1fbad6;padding:4px 4px 15px;" align="right" valign="top">
                                                                                -0.36
                                                                            </td>
                                                                        </tr>-->





                                                                        <tr style="vertical-align:top;text-align:left;border-bottom-width:1px;border-bottom-color:#f0f0f0;border-bottom-style:solid;width:100%;padding:0;" align="left">
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;width:300px;color:#808080;line-height:18px;padding:15px 4px;" align="left" valign="top">';
            if ($apptDet['payment_type'] == 2) {
                $innderhtml .= '<span style="font-size:9px;line-height:7px;">CHARGED</span>
                                                                                    <br>
                                                                                    <img src="' . APP_SERVER_HOST . 'images/cash_24.png" width="17" height="12" style="outline:none;text-decoration:none;float:left;clear:both;display:block;width:17px!important;min-height:12px;margin-right:5px;margin-top:3px;" align="left">
                                                                                    <span style="font-size:13px;">
                                                                                        Cash
                                                                                    </span>';
            } else {
                $innderhtml .='<span style="font-size:9px;line-height:7px;">CHARGED</span>
                                                                                    <br>
                                                                                    <img src="' . APP_SERVER_HOST . 'images/cash_24.png" width="17" height="12" style="outline:none;text-decoration:none;float:left;clear:both;display:block;width:17px!important;min-height:12px;margin-right:5px;margin-top:3px;" align="left">
                                                                                    <span style="font-size:13px;">
                                                                                        Card
                                                                                    </span>';
            }

            $innderhtml .='</td>
                                                                            <td style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;width:90px;white-space:nowrap;font-size:19px;font-weight:bold;line-height:30px;padding:26px 4px 15px;" align="right" valign="top">
                                                                                ' . currency . '&nbsp;' . $apptDet['amount'] . '
                                                                            </td>
                                                                        </tr></tbody></table>
                                                                        <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:auto;padding:0;" id="yui_3_16_0_1_1449814152286_3284"><tbody id="yui_3_16_0_1_1449814152286_3283"><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3282"><td style="border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell;width:300px;font-size:15px;padding:16px 10px 0px;" align="center" valign="top" id="yui_3_16_0_1_1449814152286_3281">
                                                                                <span></span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody></table>

                                                                <span style="line-height:1px;font-size:1px;color:#ffffff;"></span>
                                                                <br><span style="line-height:1px;font-size:1px;color:#ffffff;"></span>
                                                            </span>
                                                        </td>
                                                    </tr></tbody>';
            $counter++;
        }
//        }


        $html = '<div style="width:100%!important;color:#222222;font-weight:normal;text-align:left;line-height:19px;font-size:14px;background-color:#111125;margin:0;padding:0;" id="yui_3_16_0_1_1449814152286_3243">
    <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;min-height:100%;width:100%;color:#222222;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0;" id="yui_3_16_0_1_1449814152286_3242">
        <tbody id="yui_3_16_0_1_1449814152286_3241">
            <tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3240">
                <td align="center" valign="top" style="border-collapse:collapse!important;vertical-align:top;text-align:center;padding:0;" id="yui_3_16_0_1_1449814152286_3239">
        <center style="width:100%;min-width:580px;margin-top:2%" id="yui_3_16_0_1_1449814152286_3238">
			<table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:640px;margin:0 10px;padding:0">
				<tbody>
				<tr style="vertical-align:top;text-align:left;width:100%;padding:0" align:"left;">
					<td style="width:127px;border-collapse:collapse!important;vertical-align:top;text-align:left;display:table-cell;padding:28px 0;">
					<img src="'.Favicon_icon.'" width:50px; height:50px; style="outline:none;text-decoration:none;float:left;clear:both;display:block;" align:"left;">
					</td>
					
					<td rowspan="2" style="border-collapse:collapse!important;vertical-align:top;text-align:right;display:table-cell;font-size:11px;color:#999999;line-height:15px;text-transform:uppercase;padding:30px 0 26px" align:"right;">
					</td>
				</tr>
                                
				</tbody>
			</table>

            <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:660px;margin:0 auto;padding:0;" id="yui_3_16_0_1_1449814152286_3237">
                <tbody id="yui_3_16_0_1_1449814152286_3236">
                    <tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3235">
                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;padding:0;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3234">

                            <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:640px;max-width:640px;border-radius:2px;background-color:#ffffff;margin:0 10px;padding:0;" bgcolor="#ffffff" id="yui_3_16_0_1_1449814152286_3233">
                                <tbody id="yui_3_16_0_1_1449814152286_3232">
                                    <tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3231">
                                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:inline-block;width:100%;padding:0;" align="left" valign="top" id="yui_3_16_0_1_1449814152286_3230">
                                            <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;max-width:640px;border-bottom-width:1px;border-bottom-color:#e3e3e3;border-bottom-style:solid;padding:0;"><tbody><tr style="vertical-align:top;text-align:left;width:100%;background-color:rgb(250,250,250);padding:0;" align="left">
                                                        <td style="border-collapse:collapse!important;vertical-align:top;text-align:left;display:inline-block;width:299px;border-radius:3px 0 0 0;background-color:#fafafa;padding:26px 10px 20px;" align="left" bgcolor="#FAFAFA" valign="top">
                                                            <span style="font-weight:bold;font-size:32px;color:#000;line-height:30px;padding-left:15px;">
                                                                ' . currency . ' ' . $amount . '
                                                            </span>
                                                           
                                                            <span style="font-weight:bold;font-size:12px;color:grey;line-height:30px;padding-left:45%;">
                                                               TXN ID :' . $Txn_id['txn_id'] . '
                                                            </span>


                                                        </td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>

' . $innderhtml . '






                                            












                                                                <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:auto;padding:0;" id="yui_3_16_0_1_1449814152286_3284"><tbody id="yui_3_16_0_1_1449814152286_3283"><tr style="vertical-align:top;text-align:left;width:100%;padding:0;" align="left" id="yui_3_16_0_1_1449814152286_3282"><td style="border-collapse:collapse!important;vertical-align:top;text-align:center;display:table-cell;width:300px;font-size:15px;padding:16px 10px 0px;" align="center" valign="top" id="yui_3_16_0_1_1449814152286_3281">
                                                                                <span></span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody></table>

                                                                <span style="line-height:1px;font-size:1px;color:#ffffff;"></span>
                                                                <br><span style="line-height:1px;font-size:1px;color:#ffffff;"></span>
                                                            </span>
                                                        </td>
                                                    </tr></tbody></table></td>
													
											
													
                                    </tr></tbody></table></td>
                    </tr></tbody></table></td>
			
                    </tr></tbody></table>           



        </center>
        </td>
        </tr></tbody></table>

</div>';

        echo $html;
    }


    function RechargeOperation($for, $id, $masid) {

        $message = "something went wrong try after some time.";

        if ($for == 0) {
            $amount = $id; // here id is nothing but amount
            $query = "insert into DriverRecharge(mas_id,RechargeDate,RechargeAmount)values('" . $masid . "',now(),'" . $amount . "')";
            $flag = $this->db->query($query);
            if ($flag)
                $message = 'Added Amount to wallet.';
        }
        else if ($for == 1) {
            // $id is nothing but amount
            $query = "update DriverRecharge set RechargeAmount = '" . $id . "' where  id ='" . $masid . "'";
            $flag = $this->db->query($query);
            if ($flag)
                $message = 'Updated Amount.';
        }
        else if ($for == 2) {
            // here id is nothing but amount
            $query = "delete from DriverRecharge where id ='" . $id . "'";
            $flag = $this->db->query($query);
            if ($flag)
                $message = 'Deleted Amount.';
            return 44;
        }

        echo json_encode(array('error' => $message));
    }

    function GetDriverDetils($id) {

        $mas = $this->db->query("select * from master where mas_id = '" . $id . "'")->row();
        return $mas;
    }

    function zones_data($param1 = '') {
        
         $this->load->library('mongo_db');
        if($param1 == '')
             $res = $this->mongo_db->get('zones');
        else
            $res = $this->mongo_db->get_where('zones',array('city_ID'=>$param1));
        return $res;
    }
    
    function zones_specific_data($param1 = '') {

       $this->load->library('mongo_db');
        $res = $this->mongo_db->get_one('zones',array('_id'=>new MongoId($param1)));
       
        return $res;
    }
    function zone_name($param1 = '') {

       $this->load->library('mongo_db');
        $res = $this->mongo_db->get_one('zones',array('_id'=>new MongoId($param1)));
       
        return $res['title'];
    }
     function deleteZone() {
            $this->load->library('mongo_db');
       $zone_id = $this->input->post('zone_id');
       
       foreach ($zone_id as $id)
          $this->mongo_db->delete('zones',array('_id'=>new MongoId($id)));
       
     
    }

    function getZoneCities() {
        $city_id = $this->input->post('city_id');
        $this->load->library('mongo_db');

        $res = $this->mongo_db->get('zones', array('city' => $city_id));

        $data = array();
        foreach ($res as $r) {
            $data [] = $r;
        }

        echo '<pre>';
        echo json_encode($data);
        echo '</pre>';
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

    function NotificationDataAll() {
//        $city_id = $this->input->post('city_id');
        $this->load->library('mongo_db');

        $dbinstance = $this->mongo_db->get_where('AdminNotifications');

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

//        function compareByName($a, $b) {
//            return strcmp($a["dname"], $b["dname"]);
//        }

        usort($datatosend, 'compareByName');


        return $datatosend;
    }

    function cityForZones() {
        $this->load->library('mongo_db');
        $cityData = $this->mongo_db->get('cities');
        return $cityData;
    }
    function cityAdd() {
     
        $this->load->library('mongo_db');
        $contry = ucwords(strtolower($this->input->post('contry')));
        $city = ucwords(strtolower($this->input->post('city')));
        $cityData = $this->mongo_db->get_one('cities', array('country'=>$contry,'city'=>$city,'city'=>$city));
        
        if(empty($cityData))
        {
            $insertArr = array('country'=>$contry,'city'=>$city,'pointsProps'=>$this->input->post('pointsProps'),'points'=>$this->input->post('points'));
            $this->mongo_db->insert('cities', $insertArr);
            echo json_encode(array('msg'=>'City is added','flag'=>0));
        }
        else{
            echo json_encode(array('msg'=>'City is already exists','flag'=>1));
        }
        return; 
    }
    
    function updateOperating_zones()
    {
        $this->load->library('mongo_db');
        $insertArr = array('title'=> ucwords(strtolower($this->input->post('title'))),'points'=>$this->input->post('points'),'pointsProps'=>$this->input->post('pointsProps'));
        $this->mongo_db->insert('Opearting_zone', $insertArr);
        echo json_encode(array('msg'=>'Operating zone is updated','flag'=>0));
        return; 
    }
    
    function getCities_zone($param = '')
    {
        $this->load->library('mongo_db');
        if($param == '')
        {
            return $this->mongo_db->get('cities');
        }
        else
             return $this->mongo_db->get_one('cities',array('_id'=>new MongoId($param)));
    }
    function getSpecificCities_zone($param = '')
    {
        $this->load->library('mongo_db');
        return $this->mongo_db->get_one('cities',array('_id'=>new MongoId($param)));
    }
    function getOperating_zone()
    {
        $this->load->library('mongo_db');
        return $this->mongo_db->get('Opearting_zone');
    }
    function getOperating_zones()
    {
        $this->load->library('mongo_db');
        echo json_encode($this->mongo_db->get('Opearting_zone'));
    }
    function datatable_operatingZone()
    {
        $this->load->library('mongo_db');
        $operating_zone = $this->mongo_db->get_one('Opearting_zone');
        $sl = 0;
        echo $this->datatables->getdataFromMongo(array(++$sl,$operating_zone['title']));
    }
    
    
       function tripDetails($param) {
        $this->load->library('mongo_db');
        $data['res'] = $this->mongo_db->get_one('ShipmentDetails', array('order_id' =>(int)$param));
        
        $tarrm = $this->mongo_db->get_where('booking_route', array('bid' =>(int)$param));
        $tarr = array();
        foreach ($tarrm as $value) {
            foreach ($value['route'] as $val) {
                $tarr[$val['subid']]=  json_decode($val['ent_shipment_latlogs']);
            }
        }
        $data['trip_route'] = $tarr;
        
//        $data['appt_data'] = $this->db->query("select * from appointment where appointment_id = '" . $param . "'")->row();

        $driver_id = $data['appt_data']->mas_id;
        $data['driver_data'] = $this->db->query("select * from master where mas_id = '" . $driver_id . "'")->row();

        $slave_id = $data['appt_data']->slave_id;
        $data['customer_data'] = $this->db->query("select * from slave where slave_id = '" . $slave_id . "'")->row();

        $type_id = $data['appt_data']->type_id;
        $data['car_data'] = $this->db->query("select * from workplace_types where type_id = '" . $type_id . "'")->row();

//        print_r($data['res']);
//      echo $data['appt_data']->mas_id;
//      exit();
        return $data;
    }
     function shipment($param) {
        $this->load->library('mongo_db');
        $ShipmentDetails = $this->mongo_db->get_one('ShipmentDetails', array('order_id' =>(int)$param));
        
        
        
        return $ShipmentDetails;
    }

    function DriverRechargeDetails($id) {

        $this->load->library('Datatables');
        $this->load->library('table');
        $this->datatables->select("id,RechargeAmount,DATE_FORMAT(RechargeDate, '%b %d %Y %h:%i %p') as rdat,mas_id", false)
                ->add_column('OPERATION', '<button class="btn btn-success btn-cons-onclick" style="min-width: 83px !important;" id="$1">EDIT</button>
            <a href="' . base_url("index.php/superadmin/RechargeOperation/2/$1/$2") . '"><button class="btn btn-success btn-cons" style="min-width: 83px !important;">DELETE</button>', 'id,mas_id')
                ->unset_column('mas_id')
                ->from('DriverRecharge')
                ->where('mas_id', $id);

        echo $this->datatables->generate();
    }

//    function compareByName($a, $b) {
//            return strcmp($a["dname"], $b["dname"]);
//          } 
    function get_notifieduser($usertype) {

        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
        $dbinstance = $db->selectCollection('AdminNotifications')->find(array('user_type' => (int) $usertype));



        foreach ($dbinstance as $res)
            $dataInprocess[] = $res;

//        print_r($dataInprocess);
//         $this->db->query("select * from city_available where City_Id = )->result();


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
                    $datatosend[] = array('city_name' => $City_name['City_Name'], 'user_type' => $res['user_type'], 'dname' => $row->first_name, 'demail' => $row->email, 'dmobile' => $row->mobile, 'msg' => $res['msg'], 'ddate' => $res['DateTime'], 'city_id' => $res['city'], 'd_id' => $row->mas_id);
                }
            } else {
                $d = $this->db->query("select * from slave where slave_id in (" . $mas_ids . ")")->result();
                foreach ($d as $row) {

                    $datatosend[] = array('city_name' => $City_name['City_Name'], 'user_type' => $res['user_type'], 'dname' => $row->first_name, 'pemail' => $row->email, 'pmobile' => $row->phone, 'msg' => $res['msg'], 'pdate' => $res['DateTime'], 'city_id' => $res['city'], 'p_id' => $row->slave_id);
                }
            }
        }


//          usort($datatosend, 'compareByName');


        return $datatosend;
    }

    //Get the email ids
    function show_allEmails() {
        $userType = $this->input->post('userType');
        if ($userType == 1) {
            $Result = $this->db->query("select email from master")->result();
            return $Result;
        } else {
            $Result = $this->db->query("select email from slave")->result();
            return $Result;
        }
    }

    function ForgotPassword() {

        $useremail = $this->input->post('resetemail');
    }

    //* naveena models *//


    function dt_passenger($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');


//$_POST['sColumns'] ="rahul,s.first_name,s.last_name,s.phone,s.email,rate,s.created_dt";

        $this->datatables->select("s.slave_id as rahul,s.first_name,s.phone,s.email,s.created_dt,s.profile_pic,"
                        . "(select (case type when 2 then 'android_new.png' when 1 then 'apple_new.png' END) from user_sessions where oid = rahul and user_type = 2 order by oid DESC limit 0,1) as dtype", FALSE)
                ->unset_column('dtype')
                ->unset_column('s.profile_pic')
                ->add_column('PROFILE PIC', '<img src="$1" width="50px" height="50px;" class="imageborder" onerror="this.src=\'http://shypr.in/Shypr/pics/user.jpg\'">', 's.profile_pic')
//                    ->add_column('PROFILE PIC', 'get_profile_pic/$1', 'rahul')
//                ->add_column('DEVICE TYPE', '<img src="' . base_url() . '../../admin/assets/$1" width="30px" >', 'dtype')
                 ->add_column('DEVICE TYPE', 'getSlaveDeviceInfo/$1', 'rahul')
                ->add_column('select', '<input type="checkbox" class="checkbox" name="checkbox" value= "$1"/>', 'rahul')
                ->from('slave s')
                ->where('s.status', $status);
        $this->db->order_by("rahul", "desc");

        echo $this->datatables->generate();
    }
    
    
     function datatable_onGoingBookings() {
         $this->load->library('Datatables');
        $this->load->library('table');
        
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;

        $company_id = $this->session->userdata('company_id');
        $city = $this->session->userdata('city_id');
        
        $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('receivers.status'=>array('$in'=>array('6','7','8','21'))))->sort(array('order_id'=>-1));
        
         $datatosend1 = array();
         $Apptstatus = array('0'=>'Status Unavailable','1'=>'Request','2'=>'Driver Accepted the Job','3'=>'Driver Rejected the Job','4'=>'Customer Cancelled After Booking',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver Loaded the Vehicle And On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','21'=>'Driver Arried At Drop And Unloaded the Vehicle','22'=>'Completed');
         
          $adminActionStatus = array('1'=>'Force Completed by Admin','2'=>'Force Cancelled by Admin');
       
       

        $comp_ids = array();
        if($city != '0')
        {
            
            $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
            foreach ($query as $row)
                $comp_ids[] =  (int)$row->company_id;
            
             $comp_ids = implode(',',$comp_ids);
             
             if(empty($comp_ids))
                $comp_ids = 0;
            
            if($company_id != '0')
                $comp_ids = $company_id;
             
             $mysqlDataApp = $this->db->query("select mas_id from master where company_id in (".$comp_ids.")")->result();
             
             foreach ($mysqlDataApp as $sqlData)
              $mas_ids[]=$sqlData->mas_id;
          
           
                foreach ($mongoData as $row)
                {
                         foreach ($row['receivers'] as $rec)
                        {
                           if(in_array($row['mas_id'],$mas_ids))
                                $datatosend1[] = array('<a class="idonclick" data="'.$row['order_id'].'" style="cursor: pointer">'.$row['order_id'].'</a>',$row['driverDetails']['entityId'],$row['driverDetails']['firstName'],$row['driverDetails']['mobile'],$row['slaveName'],$row['slavemobile'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),$row['address_line1'],$row['drop_addr1'],'<span class="app_id_'.$row['order_id'].'">'.$Apptstatus[$rec['status']].'</span>','<button class="btn btn-info assignDriver" bid="'.$row['order_id'].'" driver_id="'.$row['driverDetails']['entityId'].'" customer_id="'.$row['slave_id'].'" style="width: inherit;">Assign Order</button>');
                           
                        }
                }
            
        }
        else{
           
             foreach ($mongoData as $row)
                {
                         foreach ($row['receivers'] as $rec)
                                $datatosend1[] = array('<a class="idonclick" data="'.$row['order_id'].'" style="cursor: pointer">'.$row['order_id'].'</a>',$row['driverDetails']['entityId'],$row['driverDetails']['firstName'],$row['driverDetails']['mobile'],$row['slaveName'],$row['slavemobile'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),$row['address_line1'],$row['drop_addr1'],'<span class="app_id_'.$row['order_id'].'">'.$Apptstatus[$rec['status']].'</span>','<button class="btn btn-info assignDriver" bid="'.$row['order_id'].'" driver_id="'.$row['driverDetails']['entityId'].'" customer_id="'.$row['slave_id'].'" style="width: inherit;">Assign Order</button>');
                           
                        
                }
        }

        
        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($datatosend1 as $row)
            {
                $needle = strtoupper($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(strtoupper($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($datatosend1);
    }

    function get_joblogsdata($value = '') {

//        
        $m = new MongoClient();
        $this->load->library('mongo_db');

        $db1 = $this->mongo_db->db;
        $logs = $db1->selectCollection('driver_log');

//        $masId = $_REQUEST['MasId'];

        $mas = $this->db->query("select email from master where mas_id = '" . $value . "'")->row();

//        $getMasEmail = "select email from master where mas_id=" . $masId;
//        $result1 = mysql_query($getMasEmail, $db1->conn);
//        $mas = mysql_fetch_assoc($result1);



        $getAllLogs = $logs->find(array('mas_email' => $mas->email))->sort(array("on_time" => 1));
        foreach ($getAllLogs as $l) {
            $minimumTimeStamp = $l['on_time'];
            break;
        }
        $currentDate = date('Y-m-d');
        $startDate = date('Y-m-d', $minimumTimeStamp);

//                $date1 = date_create($currentDate);
//                $date2 = date_create($startDate);
//                $diff = date_diff($currentDate, $startDate);
        $diff = abs(strtotime($currentDate) - strtotime($startDate));
        $days = floor($diff / (60 * 60 * 24));
//                echo $startDate . '-' . $currentDate . '-' . $days;

        $NextDay = $startDate;
        $totalData = 0;
        $dataByDay = array();
        for ($i = 0; $i <= $days; $i++) {


            $startTime = strtotime($NextDay . ' 00:00:01');
            $endTime = strtotime($NextDay . ' 23:23:59');
//                    echo $startTime . '-' . $endTime . '-' . $NextDay . '-----';
            $getAllTodayLogs = $logs->find(array('mas_email' => $mas->email,
                'on_time' => array('$gte' => $startTime),
                'off_time' => array('$lte' => $endTime)));
            $dataByDay[$i]['Date'] = $NextDay;
            $getData = array();
            $ii = 0;

            $lat1 = 0;
            $long1 = 0;
            $lat2 = 0;
            $long2 = 0;
            $dictance = 0;
            foreach ($getAllTodayLogs as $oneDay) {

                foreach ($oneDay['location'] as $latlngs) {
                    if ($lat1 == 0 && $long1 == 0) {
                        $lat1 = $latlngs['latitude'];
                        $long1 = $latlngs['longitude'];
                    } else {
                        $lat2 = $latlngs['latitude'];
                        $long2 = $latlngs['longitude'];
                        $dictance+=(double) $this->distance($lat1, $long1, $lat2, $long2, 'M');
                    }
                }
//                        $oneDay['Distance'] = $dictance;
//                        $getData[] = $oneDay;
                $ii++;
            }
            $dataByDay[$i]['Distance'] = $dictance;
            $dataByDay[$i]['total'] = $ii;
            $totalData = $i;
            $date1 = str_replace('-', '/', $NextDay);
            $NextDay = date('Y-m-d', strtotime($date1 . "+1 days"));
        }
//                print_r($dataByDay);


        $getLogs = $logs->find(array('mas_email' => $mas->email))->sort(array("on_time" => -1));
        $count = 1;

        $data = array();

        for ($Count = $totalData; $Count >= 0; $Count--) {
            if ($dataByDay[$Count]['total'] > 0) {


//                echo '<tr>';
                $sr = $Count + 1;

                $data[] = array('sr' => $sr, 'Date' => $dataByDay[$Count]['Date'], 'total' => $dataByDay[$Count]['total'], 'distance' => number_format($dataByDay[$Count]['Distance'], 2, '.', ','), 'view' => '<input type="button" value="Log" id="' . $value . '!' . $dataByDay[$Count]['Date'] . '" onclick="viewLog(this);">');


//                echo '<td>' . $sr . '</td>';
//                echo '<td>' . $dataByDay[$Count]['Date'] . '</td>';
//                echo '<td>' . $dataByDay[$Count]['total'] . '</td>';
//                echo '<td>' . number_format($dataByDay[$Count]['Distance'], 2, '.', ',') . '</td>';
//                echo '<td><input type="button" value="Log" id="' . $masId . '!' . $dataByDay[$Count]['Date'] . '" onclick="viewLog(this);"></td>';
//                echo '</tr>';
            }
        }

        return $data;
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    function get_sessiondetails($value = '') {

        $db1 = new ConDB();
        $logs = $db1->mongo->selectCollection('driver_log');
        $exp = explode('!', $_REQUEST['MasId']);
        $MasId = $exp[0];
        $Date = $exp[1];



        $startTime = strtotime($Date . ' 00:00:01');
        $endTime = strtotime($Date . ' 23:23:59');
        $getAllTodayLogs = $logs->find(array('mas_email' => $mas['email'],
            'on_time' => array('$gte' => $startTime),
            'off_time' => array('$lte' => $endTime)));

        $getLogs = $logs->find(array('mas_email' => $mas['email']))->sort(array("on_time" => -1));
        $count = 1;


        foreach ($getAllTodayLogs as $log) {
            $lat1 = 0;
            $long1 = 0;
            $lat2 = 0;
            $long2 = 0;
            $dictance = 0;
            echo '<tr>';
            echo '<td>' . $count . '</td>';
//                    echo '<td>' . $log['mas_email'] . '</td>';
            echo '<td>' . date('Y, M dS g:i a', $log['on_time']) . '</td>';
            if ($log['off_time'] == '') {
                echo '<td>Online Now</td>';
                echo '<td>-</td>';
            } else {
                echo '<td>' . date('Y, M dS g:i a', $log['off_time']) . '</td>';
                $diff = $log['off_time'] - $log['on_time'];
                $tm = explode('.', number_format(($diff / 60), 2, '.', ','));
                if ($tm[1] > 60) {
                    $tm[0] ++;
                    $tm[1] = $tm[1] - 60;
                }
                if (strlen($tm[1]) == 1) {
                    $tm[1] = $tm[1] . '0';
                }
                echo '<td>' . $tm[0] . ':' . $tm[1] . ' Mins' . '</td>';
            }

            //calculate distnce
            foreach ($log['location'] as $latlngs) {
                if ($lat1 == 0 && $long1 == 0) {
                    $lat1 = $latlngs['latitude'];
                    $long1 = $latlngs['longitude'];
                } else {
                    $lat2 = $latlngs['latitude'];
                    $long2 = $latlngs['longitude'];
//                            $gotDis = GetDrivingDistance($lat1, $lat2, $long1, $long2);
//                            $dictance+=(double) $gotDis['distance'];
                    $dictance+=(double) distance($lat1, $long1, $lat2, $long2, 'M');
                }
            }
            echo '<td>' . number_format($dictance, 2, '.', ',') . ' Miles</td>';
            echo '</tr>';
            $count++;
        }
    }

    function get_city_available() {
        return $this->db->query("select *from city_available ORDER BY City_Name ASC")->result();
    }

    function deletepassengers() {

        $pass_ids = $this->input->post('val');
        foreach ($pass_ids as $id) {
            $this->db->query("delete from slave where slave_id = '" . $id . "'");
            $this->db->query("delete from user_sessions where oid = '" . $id . "' and user_type = 2");
            $this->db->query("delete from passenger_rating where slave_id = '" . $id . "'");
        }
        return;
    }

    function addcountry() {

        $var = $this->input->post('data2');
        $string = strtoupper($var);

        $query = $this->db->query("select * from country where Country_Name= '" . $string . "'");
        if ($query->num_rows() > 0) {
            echo json_encode(array('msg' => "country already exists", 'flag' => 0));
            return;
        } else {


            $data2 = $this->input->post('data2');
            $string = strtoupper($data2);

            $this->db->query("insert into country(Country_Name)  values('" . $string . "')");

            $countryId = $this->db->insert_id();

            if ($countryId > 0) {
                echo json_encode(array('msg' => "country added successfully", 'flag' => 0, 'id' => $countryId));
                return;
            } else {
                echo json_encode(array('msg' => "Unable to add country", 'flag' => 1));
                return;
            }
        }
    }

    function deletecity() {
        $this->load->library('mongo_db');
        $cityID = $this->input->post('cityID');
        $db = $this->mongo_db->db;

            $city = $this->db->query("select * from city_available where City_Id ='" . $cityID . "'");
          
            if ($city->num_rows() > 0) {
                
                  $company_id = $this->db->query("select company_id from company_info where city ='" . $cityID . "'")->row()->company_id;

                  $this->db->query("delete from city_available where City_Id ='" . $cityID . "'");
                  if($company_id)
                  {
//                        $workplace_ids = $this->db->query("select workplace_id from workplace where company ='" . $company_id . "'")->result();
                        $drivers_id = $this->db->query("select mas_id from master where company_id ='" . $company_id . "'")->result();
                        foreach ($workplace_ids as $id)
                            $vehicle_ids[]=$id->workplace_id;
                        
                        foreach ($drivers_id as $id)
                            $master_ids[]=(int)$id->mas_id;
                        
                        $this->db->query("delete from  company_info where city ='" . $cityID . "'"); 
//                        $this->db->query("delete from  workplace where company ='" . $company_id . "'");
//                        $this->db->query("delete from  dispatcher where city ='" . $city_id . "'");
                        
                        $dbcorsor = $db->selectCollection('vehicles');
                        $dbcorsor->remove(array('company' =>$company_id));
                        
                       
//                        $this->db->query("delete from vechiledoc where vechileid in (". implode(',',$vehicle_ids) .")"); 
                        $this->db->query("delete from master where company_id ='" . $company_id . "'"); 
                        $dbcorsor = $db->selectCollection('location');
                        $dbcorsor->remove(array('user' =>array('$in'=>$master_ids)));
                    
                  }
                
            } else {
                echo json_encode(array("msg" => "Selected cities not deleted,retry!", "flag" => 1));
                return;
            }
            
            
        
        echo json_encode(array("msg" => "Selected city has been deleted successfully", "flag" => 0));
        return;
    }

    function get_vehivletype() {
        $query = $this->db->query("select * from workplace_types order by type_name")->result();
        return $query;
    }
    function getComapnyDetails() {
        $operatorData = $this->mongo_db->get_where('operators', array('_id' => new MongoDB\BSON\ObjectID($this->input->post('companyID'))));
        foreach ($operatorData as $each)
        {
//          $cityData = $this->mongo_db->get_where('cities', array('_id' => new MongoDB\BSON\ObjectID($each['cityID'])));
//          foreach ($cityData as $city)
           echo json_encode(array("data" =>$operatorData));
            return;
        }
    }


    function insert_payment($mas_id = '') {
        $currunEarnigs = $this->input->post('currunEarnigs');
        $amoutpaid = $this->input->post('paid_amount');
        $curuntdate = $this->input->post('ctime');
        $closingamt = $currunEarnigs - $amoutpaid;
        $lastAppointmentId = $this->input->post('last_unsettled_appointment_id');


        $getWhere = $this->db->get_where("master", array('mas_id' => $mas_id))->result_array();


        $query = "insert into payroll(mas_id,opening_balance,pay_date,pay_amount,closing_balance,due_amount,trasaction_id) VALUES (
        '" . $mas_id . "',
        '" . $currunEarnigs . "',
        '" . $curuntdate . "',
        '" . $amoutpaid . "',
        '" . $closingamt . "','" . $closingamt . "','" . $transfer['id'] . "')";
        $this->db->query($query);




        if ($this->db->insert_id() > 0) {


            $this->db->query("update appointment set settled_flag = 1 where appointment_id <= '" . $lastAppointmentId . "' and mas_id = '" . $mas_id . "' and settled_flag = 0 and status = 9 ");
            if ($this->db->affected_rows() > 0) {
                return array("msg" => "Success");
            } else {
                 $this->session->set_userdata(array('pay_error' => 'Error while upateing in db.'));
                return;
            }
        } else {
            $this->session->set_userdata(array('pay_error' => 'Error while processing your request.'));
            return;
        }


        return array("error" => "");
        
    }

    function insertCity() {
        
      
        $getcityname = $this->db->query("select * from city_available where  City_Name = '" . $this->input->post('cityNameOnly') . "' and City_Lat ='".$this->input->post('latitude')."' and City_Long ='".$this->input->post('longitude')."'");

        if ($getcityname->num_rows() > 0) {
            echo json_encode(array('msg' => "City already exists", 'flag' => 1));
            return;
        } else {
            $this->db->query("insert into city_available(Country_Name,City_Name,City_Lat,City_Long,Currency) values('".$this->input->post('coutryName')."','".$this->input->post('cityNameOnly')."','".$this->input->post('latitude')."','".$this->input->post('longitude')."','".strtoupper($this->input->post('currency'))."')");
            if ($this->db->affected_rows() > 0) {
                echo json_encode(array('msg' => "City has been added successfully", 'flag' => 0));
                return;
            }

        }
    }

    function activate_company() {
        $val = $this->input->post('val');
        foreach ($val as $id) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status'=>3))->update('operators');
            
        }
        if ($result) {
            echo json_encode(array('msg' => "your selected company/companies activated succesfully", 'flag' => 1));
            return;
        }
    }

    function activate_vehicle() {
        $val = $this->input->post('val');
        foreach ($val as $result) {
            $this->db->query("update workplace set status=2  where workplace_id='" . $result . "'");
        }
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "your selected vehicle/vehicles activated succesfully", 'flag' => 1));
            return;
        }
    }

    function reject_vehicle() {
        $val = $this->input->post('val');


        foreach ($val as $result) {
            $this->db->query("update workplace set Status = 4 where workplace_id ='" . $result . "'");

            if ($this->db->affected_rows() > 0) {
                $getTokensQry = $this->db->query("select * from user_sessions where oid IN (select mas_id from master where workplace_id = '" . $result . "') and loggedIn = 1 and user_type = 1 and LENGTH(push_token) > 63")->result();
                $this->load->library('mongo_db');
                foreach ($getTokensQry as $token) {

                    $query = "update appointment set status = '5',extra_notes = 'Admin rejected vehicle, so cancelled the booking',cancel_status = '8' where mas_id = '" . $token->oid . "' and status IN (6,7,8)";
                    $this->db->query($query);

                    $query_mas = "update master set workplace_id = '0' where workplace_id = '" . $result . "'";
                    $this->db->query($query_mas);

                    $this->mongo_db->update('location', array("status" => 4, 'carId' => 0, 'type' => 0), array('user' => (int) $token->oid));

                    $this->db->query("update user_sessions set loggedIn = 2 where oid = '" . $token->oid . "' and loggedIn = 1 and user_type = 1");
                }
            }
        }
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "your selected Vehicle rejected Successfully", 'flag' => 1, 'res' => $res));
            return;
        }
    }

    function acceptdrivers() {
        $val = $this->input->post('val');
        $company_id = $this->input->post('company_id');
        $data = array();

        foreach ($val as $val1) {
            $data = $this->db->query('select * from  master where mas_id = "' . $val1 . '" and status = 1')->result();
        }

        foreach ($data as $t) {
            if ($t->vehicle_id != '') {
                $this->db->query("update workplace set status = 2  where uniq_identity='" . $t->vehicle_id . "' ");
            }
        }

        foreach ($val as $result) {
            $this->db->query("update master set status = 3 , company_id = '" . $company_id . "'  where mas_id='" . $result . "' ");
        }
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "your selected driver/drivers accepted succesfully", 'flag' => 1, 'l' => $l));
            $email = '';
            $firstname = '';
            foreach ($data as $rec) {
                $email = $rec->email;
                $firstname = $rec->first_name;
            }
//          
            $this->sendMailToDriverAfterAccept($email, $firstname);
            return;
        }



        return $data;
    }

    //Manually logout the driver from admin panel
    function driver_logout() {
        $val = $this->input->post('val');
        $this->load->library('mongo_db');


        foreach ($val as $mas_ids) {

            $getTokensQry = $this->db->query("select us.*,(select workplace_id from master where mas_id = '" . $mas_ids . "') as workplace_id from user_sessions us where oid = '" . $mas_ids . "' and loggedIn = 1 and user_type = 1")->result();
            $this->load->library('mongo_db');
            foreach ($getTokensQry as $token) {

                $query = "update appointment set status = '5',extra_notes = 'Admin rejected vehicle, so cancelled the booking',cancel_status = '8' where mas_id = '" . $token->oid . "' and status IN (6,7,8)";
                $this->db->query($query);

                $query_mas = "update master set workplace_id = '0' where mas_id = '" . $token->oid . "'";
                $this->db->query($query_mas);

                $this->mongo_db->update('location', array("status" => 4, 'carId' => 0, 'type' => 0), array('user' => (int) $token->oid));

                $this->db->query("update workplace set Status= 2   where workplace_id='" . $token->workplace_id . "'");
                $this->db->query("update user_sessions set loggedIn = 2 where oid = '" . $token->oid . "' and loggedIn = 1 and user_type = 1");
            }
        }

        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "your selected driver/drivers loggedout succesfully", 'flag' => 1));
            return;
        }

        return;
    }

    function getdrivervehicle() {
        $val = $this->input->post('masterid');
        foreach ($val as $val1) {
            $master = $val1;
        }

        $qu = "select * from  master where mas_id = '" . $master . "'";


        $data = $this->db->query("select vehicle_id from  master where mas_id = '" . $master . "' and status=1")->result();
        echo json_encode(array('data' => $qu, 'mas' => $val[0], 'vehicle' => $data['vehicle_id']));
        foreach ($data as $data1) {
            if ($data1->vehicle_id != '') {
                $data1 = $this->db->query('select * from  workplace where uniq_identity = "' . $data1->vehicle_id . '" and status = 5')->result();
                echo json_encode(array('data' => $data1, 'flag' => 0));
            } else {

                echo json_encode(array('data' => $data1, 'flag' => 1));
            }
        }
    }

    function rejectdrivers() {
        $val = $this->input->post('val');
        $this->load->library('mongo_db');


        foreach ($val as $mas_ids) {

            $getTokensQry = $this->db->query("select us.*,(select workplace_id from master where mas_id = '" . $mas_ids . "') as workplace_id from user_sessions us where oid = '" . $mas_ids . "' and loggedIn = 1 and user_type = 1")->result();
            $this->load->library('mongo_db');


            if (!empty($getTokensQry)) {
                foreach ($getTokensQry as $token) {
                    
                  
                    $query = "update appointment set status = '5',extra_notes = 'Admin rejected vehicle, so cancelled the booking',cancel_status = '8' where mas_id = '" . $token->oid . "' and status IN (6,7,8)";
                    $this->db->query($query);

                    $query_mas = "update master set workplace_id = '0',status = '4' where mas_id = '" . $token->oid . "'";
                 
    
                    $this->db->query($query_mas);

                    $this->mongo_db->update('location', array("status" => 4, 'carId' => 0, 'type' => 0), array('user' => (int) $token->oid));

//                    $this->db->query("update workplace set Status= 2   where workplace_id='" . $token->workplace_id . "'");
                    $this->db->query("update user_sessions set loggedIn = 2 where oid = '" . $token->oid . "' and loggedIn = 1 and user_type = 1");
                }
            } else {

                foreach ($val as $user) {
                    $userList[] = (int) $user;
                    $masterstring = $user . ",";
                }

                $this->db->query("update master set status = '4' where mas_id IN (" . rtrim($masterstring, ',') . ")");
                if ($this->db->affected_rows() > 0) {

                    $db = $this->mongo_db->db;

                    $selecttb = $db->location;

                    $selecttb->update(array('user' => array('$in' => $userList)), array('$set' => array('status' => 4, 'carId' => 0, 'type' => 0)));

                    $this->db->query("update user_sessions set loggedIn = 2 where oid in (" . rtrim($masterstring, ',') . ") and loggedIn = 1 and user_type = 1");
                }
            }
        }

        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "your selected driver/drivers rejected Successfully", 'flag' => 1, 'res' => $res));
            return;
        }
    }

    function get_ongoing_bookings() {
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
        $selecttb = $db->selectCollection('ShipmentDetails');
       $allDocs = array();

        $city = $this->session->userdata('city_id');
        $company = $this->session->userdata('company_id');
  
      
        foreach ($query as $appData)
        {
           
            $find = $selecttb->find(array('order_id'=>(int)$appData->appointment_id));
            
            foreach ($find as $shipment)
            {
                      
                 foreach ($shipment['receivers'] as $reciver)
                {
                           
                    $allDocs[] = array('sub_id'=>$reciver['subid'],'appointment_id'=>$appData->appointment_id,'mas_id'=>$appData->mas_id,'first_name'=>$appData->first_name,'dphone'=>$appData->dphone,'mobile'=>$appData->mobile,'pessanger_fname'=>$appData->pessanger_fname,'phone'=>$appData->phone,'appointment_dt'=>$appData->appointment_dt,'address_line1'=>$appData->address_line1,'drop_addr1'=>$appData->drop_addr1,'status'=>$appData->status,'address'=>$reciver['address']);
 
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
        $newpass = $this->input->post('newpass');
        $val = $this->input->post('val');

        $pass = $this->db->query("select password from master where mas_id='" . $val . "' ")->row()->password;

        if ($pass == md5($newpass)) {
            echo json_encode(array('msg' => "this password already exists. Enter new password", 'flag' => 1));
            return;
        } else {
            $this->db->query("update master set password = md5('" . $newpass . "') where mas_id = '" . $val . "' ");

            if ($this->db->affected_rows() > 0) {
                echo json_encode(array('msg' => "your new password updated successfully", 'flag' => 0));
                return;
            }
        }
    }

//    function editsuperpassword() {
//        $newpass = $this->input->post('newpass');
////        $currentpassword = $this->input->post('currentpassword');
//        $ids = $this->input->post('val');
//        foreach ($ids as $id) {
//            $pass = $this->db->query("select * from dispatcher where id = '" . $id . "'")->result()->dis_pass;
//
//            if ($pass == $newpass) {
//                echo json_encode(array('msg' => "this password already exists. Enter new password", 'flag' => 1));
//                return;
//            } else {
//                $this->db->query("update dispatcher set password = '" . $newpass . "' where dis_id = '" . $id . "'");
//
//                if ($this->db->affected_rows() > 0) {
//                    echo json_encode(array('msg' => "your new password updated successfully", 'flag' => 0));
//                    return;
//                }
//            }
////    
//        }
//    }
    function editsuperpassword() {
       
        $newpass = $this->input->post('newpass');
         $email = $this->session->userdata('emailid');
        $currentpassword = $this->input->post('currentpassword');
        
        $this->load->library('mongo_db');
        $admin_users = $this->mongo_db->get_one('admin_users', array('email' =>$email,'pass'=>md5($currentpassword)));
        
        if ($admin_users['email']) {
                    $this->mongo_db->update('admin_users', array("pass" =>md5($newpass)));
                    echo json_encode(array('msg' => "Your new password updated has been updated successfully", 'flag' => 0));
                    return;
                }
                else{
                     echo json_encode(array('msg' => "Incorrect current password", 'flag' => 1));
                    return;
                }
            
//    
        
    }
    
    function getDriversCount() {
         $data['New'] = $this->db->query("select count(*) as NewDriver from master where status = 1")->row()->NewDriver;
         $data['Accepted'] = $this->db->query("select count(*) as AcceptedDriver from master where status = 3")->row()->AcceptedDriver;
         $data['Rejepted'] = $this->db->query("select count(*) as RejeptedDriver from master where status = 4")->row()->RejeptedDriver;
         return $data;
    }

    function editvehicle($status) {

        $data['vehicle'] = $this->db->query("select w.*,wt.city_id,v.id,v.vehiclemodel from  workplace w ,workplace_types wt,vehiclemodel v where workplace_id='" . $status . "' and w.type_id = wt.type_id and v.id = w.Vehicle_Model ")->result();

        $cityId = $data['vehicle'][0]->city_id;
        $account_type = $data['vehicle'][0]->account_type;

        if ($cityId == '')
            return array('flag' => 1);

        
        if($account_type == 1)
            $data['drivers'] = $this->db->query("select * from master where account_type = 1")->result();
        else
            $data['drivers'] = $this->db->query("select * from master where  account_type = 2")->result();
        
        $data['company'] = $this->db->query("select * from company_info where status = 3")->result();

        $data['cityList'] = $this->db->query("select City_Name,City_Id from city_available")->result();

        $data['workplaceTypes'] = $this->db->query("select * from workplace_types where city_id = '" . $cityId . "'")->result();

        $data['vehicleTypes'] = $this->db->query("select * from vehicleType")->result();


        $data['vehicleDoc'] = $this->db->query("select * from vechiledoc where vechileid = '" . $status . "'")->result();

        $this->load->library('mongo_db');


        return $data;
    }

    function deactivate_company() {
          $val = $this->input->post('val');
        foreach ($val as $id) {
            $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status'=>4))->update('operators');
            
        }
        if ($result) {
            echo json_encode(array('msg' => "your selected company/companies activated succesfully", 'flag' => 1));
            return;
        }
    }

    function suspend_company() {
        $val = $this->input->post('val');
        foreach ($val as $result) {
            $this->db->query("update company_info set status=6  where company_id='" . $result . "'");
        }
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "your selected company/companies suspended succesfully", 'flag' => 1));
            return;
        }
    }

    function get_vehicle_data() {
        $query = $this->db->query("select w.*,cty.City_Name from workplace_types w, city_available cty where w.city_id = cty.City_Id")->result();

        return $query;
    }
    function location_data($status = '') {
      $this->load->library('mongo_db');

        $db = $this->mongo_db->db;
         $selecttb = $db->selectCollection('location');
        $find = $selecttb->findOne(array('user'=>(int)$status));

        return $find;
    }

    function logoutdriver() {
        $driverid = $this->input->post('driverid');
        $this->load->library('mongo_db');
        $this->db->query("update user_sessions  set loggedIn = 2 where user_type = '1' and oid = '" . $driverid . "' and loggedIn = 1");

        $this->mongo_db->update('location', array('status' => 4), array('user' => (int) $driverid));
    }

    function insert_vehicletype() {
        
        $vehicle_length = $this->input->post('vehicle_length').$this->input->post('vehicle_length_metric');
        $vehicle_width = $this->input->post('vehicle_width'). $this->input->post('vehicle_width_metric');
        $vehicle_height = $this->input->post('vehicle_height').$this->input->post('vehicle_height_metric');
        
        $mileage_metric = $this->input->post('mileage_metric');
        $mileage_price = $this->input->post('mileage');
        
        $x_minutesTripDuration = $this->input->post('x_minutesTripDuration');
        $price_after_x_minutesTripDuration = $this->input->post('price_after_x_minutesTripDuration');
        
        $x_minutesWaiting = $this->input->post('x_minutesWaiting');
        $price_after_x_minWaiting = $this->input->post('price_after_x_minWaiting');
        
        $x_minutesCancel = $this->input->post('x_minutesCancel');
        $price_after_x_minCancel = $this->input->post('price_after_x_minCancel');
        
        $x_km_mileMinimumFee = $this->input->post('x_km_mileMinimumFee');
        $price_MinimumFee = $this->input->post('price_MinimumFee');
        
        $x_zonal_km_miles = $this->input->post('x_zonal_km_miles');
        $zonal_km_miles_greater_less = $this->input->post('zonal_km_miles_greater_less');
        
         $zonalEnableFlag = '0';
        if($this->input->post('zonalEnableFlag') == 'on')
            $zonalEnableFlag = '1';
        
        $vehicle_capacity = $this->input->post('vehicle_capacity');
        
        $vehicletype = $this->input->post('vehicletypename');
        $discription = $this->input->post('descrption');
        
        $type_on_image = $this->input->post('onImageAWS');
        $type_off_image = $this->input->post('offImageAWS');
        $type_map_image = $this->input->post('mapImageAWS');
      

      $result = $this->mongo_db->get('vehicleTypes');
      $type_id = 1;
      if(!empty($result))
      {
          foreach ($result as $each)
              $type_id = $each['type'];
      }
       $appConfig = $this->mongo_db->find_one('appConfig'); 
            
        if($type_map_image != '')
        {
      
             $insertArr = array('type' => (int) $type_id+1, 'type_name' => $vehicletype,'vehicle_length'=>$vehicle_length,'vehicle_width'=>$vehicle_width,'vehicle_height'=>$vehicle_height,'vehicle_capacity'=>$vehicle_capacity,'min_fare'=>(float)$price_MinimumFee,'min_distance'=>(int)$x_km_mileMinimumFee,'cancellation_fee'=>(float)$price_after_x_minCancel,'cancenlation_min'=>(int)$x_minutesCancel,'waiting_time_min'=>(int)$x_minutesWaiting,'waiting_charge'=>(float)$price_after_x_minWaiting,'mileage_price'=>(float)$mileage_price,'mileage_metrc'=>$appConfig['mileage_metric'], "currencySbl" =>$appConfig['currencySymbol'],'xminuts'=>$x_minutesTripDuration,'xmilage'=>$price_after_x_minutesTripDuration,'x_zonal_km_miles'=>(int)$x_zonal_km_miles,'zonalEnable'=>(int)$zonalEnableFlag,'zonal_km_miles_greater_or_less'=>(int)$zonal_km_miles_greater_less,"order" => (int) $type_id,'type_desc' => $discription,
                "vehicle_img" => $type_on_image, "vehicle_img_off" => $type_off_image, "MapIcon" =>$type_map_image,'goodTypes'=>$this->input->post('goodType'));
          
            
        }  else {
             $insertArr = array('type' => (int) $type_id+1, 'type_name' => $vehicletype,'vehicle_length'=>$vehicle_length,'vehicle_width'=>$vehicle_width,'vehicle_height'=>$vehicle_height,'vehicle_capacity'=>$vehicle_capacity,'min_fare'=>(float)$price_MinimumFee,'min_distance'=>(int)$x_km_mileMinimumFee,'cancellation_fee'=>(float)$price_after_x_minCancel,'cancenlation_min'=>(int)$x_minutesCancel,'waiting_time_min'=>(int)$x_minutesWaiting,'waiting_charge'=>(float)$price_after_x_minWaiting,'mileage_price'=>(float)$mileage_price,'mileage_metrc'=>$appConfig['mileage_metric'], "currencySbl" =>$appConfig['currencySymbol'],'xminuts'=>$x_minutesTripDuration,'xmilage'=>$price_after_x_minutesTripDuration,'x_zonal_km_miles'=>(int)$x_zonal_km_miles,'zonalEnable'=>(int)$zonalEnableFlag,'zonal_km_miles_greater_or_less'=>(int)$zonal_km_miles_greater_less,"order" => (int)$type_id,'type_desc' => $discription,
                "vehicle_img" => $type_on_image, "vehicle_img_off" => $type_off_image, "MapIcon" => '','goodTypes'=>$this->input->post('goodType'));
           
        }
        $result = $this->mongo_db->insert('vehicleTypes',$insertArr);
      
        return;

    }
    
    function testID()
    {
        
      $result = $this->mongo_db->find_one('appConfig');
     
         print_r($result['currencySymbol']);
    }
                

    function update_vehicletype($param) {
     
        
        $vehicle_length = $this->input->post('vehicle_length').$this->input->post('vehicle_length_metric');
        $vehicle_width = $this->input->post('vehicle_width'). $this->input->post('vehicle_width_metric');
        $vehicle_height = $this->input->post('vehicle_height').$this->input->post('vehicle_height_metric');
        
        $mileage_metric = $this->input->post('mileage_metric');
        $mileage_price = $this->input->post('mileage');
        
        $x_minutesTripDuration = $this->input->post('x_minutesTripDuration');
        $price_after_x_minutesTripDuration = $this->input->post('price_after_x_minutesTripDuration');
        
        $x_minutesWaiting = $this->input->post('x_minutesWaiting');
        $price_after_x_minWaiting = $this->input->post('price_after_x_minWaiting');
        
        $x_minutesCancel = $this->input->post('x_minutesCancel');
        $price_after_x_minCancel = $this->input->post('price_after_x_minCancel');
        
        $x_km_mileMinimumFee = $this->input->post('x_km_mileMinimumFee');
        $price_MinimumFee = $this->input->post('price_MinimumFee');
        
        $x_zonal_km_miles = $this->input->post('x_zonal_km_miles');
        $zonal_km_miles_greater_less = $this->input->post('zonal_km_miles_greater_less');
        
        //Images
        $onImageAWS = $this->input->post('onImageAWS');
        $offImageAWS = $this->input->post('offImageAWS');
        $mapImageAWS = $this->input->post('mapImageAWS');
        
         $zonalEnableFlag = '0';
        if($this->input->post('zonalEnableFlag') == 'on')
            $zonalEnableFlag = '1';
        
        $vehicle_capacity = $this->input->post('vehicle_capacity');
        
        $vehicletype = $this->input->post('vehicletypename');
        $discription = $this->input->post('descrption');
        
       
        $update_mongo_data =  array('xminuts'=>$x_minutesTripDuration,'xmilage'=>$price_after_x_minutesTripDuration,'type_name' => $vehicletype,'vehicle_length'=>$vehicle_length,'vehicle_width'=>$vehicle_width,'vehicle_height'=>$vehicle_height,'vehicle_capacity'=>$vehicle_capacity,'min_fare'=>(float)$price_MinimumFee,'min_distance'=>(int)$x_km_mileMinimumFee,'cancellation_fee'=>(float)$price_after_x_minCancel,'cancenlation_min'=>(int)$x_minutesCancel,'waiting_time_min'=>(int)$x_minutesWaiting,'waiting_charge'=>(float)$price_after_x_minWaiting,'mileage_price'=>(float)$mileage_price,'mileage_metrc'=>$mileage_metric,'x_zonal_km_miles'=>(int)$x_zonal_km_miles,'zonalEnable'=>(int)$zonalEnableFlag,'zonal_km_miles_greater_or_less'=>(int)$zonal_km_miles_greater_less,"order" =>(int)$type_id,'type_desc' => $discription,
                'goodTypes'=>$this->input->post('goodType'));
           
        
        if($onImageAWS)
           $update_mongo_data['vehicle_img'] = $onImageAWS;
        
        if($offImageAWS)
           $update_mongo_data['vehicle_img_off'] = $offImageAWS;
        
        if($mapImageAWS)
            $update_mongo_data['MapIcon'] = $mapImageAWS;
         
         $this->mongo_db->where( array('type'=>(int)$param))->set($update_mongo_data)->update('vehicleTypes');

        return;
    }

    function getMongoVehicleType($param = '')
    {
        $result = $this->mongo_db->get_where('vehicleTypes', array('type' =>(int)$param));
        return $result;
        
    }

    function getAllVehicleType()
    { 
         $this->load->library('mongo_db');
        $res = $this->mongo_db->get('vehicleTypes');
        
       echo json_encode(iterator_to_array($res, false), true);
        return;
    }
    function getVehicleTypes()
    { 
         $this->load->library('mongo_db');
        $res = $this->mongo_db->get('vehicleTypes');
      
        return $res;
    }
    function long_haul_pricing_set($param = '')
    { 
         $this->load->library('mongo_db');
        $this->mongo_db->update("cities",array('LongHaulPrice'=>$this->input->post('pricing')), array("_id" => new MongoId($param)));
        return;
    }
    function short_haul_pricing_set($param = '')
    { 
         $this->load->library('mongo_db');
        $this->mongo_db->update("zones",array('ShortHaulPrice'=>$this->input->post('pricing')), array("_id" => new MongoId($param)));
        return;
    }
       
    
    function get_vehiclemodal() {
        return $this->db->query("select vm.*,vt.vehicletype from vehiclemodel vm,vehicleType vt where vm.vehicletypeid= vt.id")->result();
    }

    function vehiclemodal() {
        return $this->db->query("select *  from vehiclemodel order by vehiclemodel")->result();
    }
    
    
    function get_vehiclemake() {
        
        $getAll = $this->mongo_db->get('VehicleMake');
           return $getAll;
        
    }
    function getMakeDetails() {
        $getAll = $this->mongo_db->get_where('VehicleModel',array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id'))));
        echo json_encode(array('data' =>$getAll));
        return ;
        
    }

    function addVehicleMake() {
        
        $getAllDriversCursor = $this->mongo_db->get_where('VehicleMake',array('Name'=>ucfirst(strtolower($this->input->post('typename')))));

        if (!empty($getAllDriversCursor)) {
            echo json_encode(array('msg' => "Brand name already exists", 'flag' => 1));
            return;
        } else {
          $result = $this->mongo_db->insert('VehicleMake',array('Name'=>ucfirst(strtolower($this->input->post('typename')))));
         
                if ($result) {
                    echo json_encode(array('msg' => "Brand name inserted successfully", 'flag' =>0));
                    return;
                }
                else{
                     echo json_encode(array('msg' => "Failed to insert", 'flag' =>1));
                    return;
                }
        }
        
    }
    function editVehicleMake() {
       
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id'))))->set(array('Name'=>ucfirst(strtolower($this->input->post('m_name')))))->update('VehicleMake');
        
        if ($result) {
            echo json_encode(array('msg' => "Brand name updated", 'flag' =>0));
            return;
        } else { 
            echo json_encode(array('msg' => "Failed to insert", 'flag' =>1));
            return;
        }
    }
    function deleteVehicleMake() {
        
        foreach ($this->input->post('val') as $id)
        {
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('VehicleMake');
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('VehicleModel');
        }
       
            echo json_encode(array('msg' => "Brand name deleted", 'flag' =>0));
            return;
     
    }
    function addVehicleModel() {
        
        $getAllDriversCursor = $this->mongo_db->get_where('VehicleModel',array('Name'=>ucfirst(strtolower($this->input->post('modal'))),'Makeid'=>$this->input->post('typeid')));

        if (!empty($getAllDriversCursor)) {
            echo json_encode(array('msg' => "Brand model already exists", 'flag' => 1));
            return;
        } else {
          $result = $this->mongo_db->insert('VehicleModel',array('Name'=>ucfirst(strtolower($this->input->post('modal'))),'Makeid'=>$this->input->post('typeid')));
         
                if ($result) {
                    echo json_encode(array('msg' => "Brand model inserted successfully", 'flag' =>0));
                    return;
                }
                else{
                     echo json_encode(array('msg' => "Failed to insert", 'flag' =>1));
                    return;
                }
        }
        
    }
    function editVehicleModel() {
       
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('model_id'))))->set(array('Name'=>ucfirst(strtolower($this->input->post('model_name'))),'Makeid'=>$this->input->post('makeID')))->update('VehicleModel');
        
        if ($result) {
            echo json_encode(array('msg' => "Brand model updated", 'flag' =>0));
            return;
        } else { 
            echo json_encode(array('msg' => "Failed to insert", 'flag' =>1));
            return;
        }
    }
    function deleteVehicleModel() {
        
        foreach ($this->input->post('id') as $id)
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('VehicleModel');
       
            echo json_encode(array('msg' => "Brand model deleted", 'flag' =>0));
            return;
     
    }
    
    

    function deletetype() {
        $vehicleid = $this->input->post('vehicletypeid');

        $result = $this->db->query("delete from workplace_types where type_id ='" . $vehicleid . "'");
    }

    function deletecompany() {
        $companyid = $this->input->post('companyid');

//        $result = $this->db->query("delete from company_info where company_id ='" . $companyid . "' ");

        $affectedRows = 0;

        $deleteVehicleTypes = $this->db->query("delete from company_info where company_id = " . $companyid)->row_array();
        $affectedRows += $this->db->affected_rows();

        if ($affectedRows <= 0) {

            echo json_encode(array('flag' => 1, 'affectedRows' => $affectedRows, 'msg' => 'Failed to delete'));
            return false;
        }

        $selectType = $this->db->query("select type_id from workplace where company_id = '" . $companyid . "'")->result();


        foreach ($selectType as $type) {
            $type_ids[] = (int) $type['type_id'];
        }

        $deleteAllVehicles = $this->db->query("delete from workplace_types where type_id  in (" . implode(',', $type_ids) . ")");
        $affectedRows += $this->db->affected_rows();

        $deleteAllVehicles = $this->db->query("delete from workplace where type_id  in (" . implode(',', $type_ids) . ")");
        $affectedRows += $this->db->affected_rows();


        $this->load->library('mongo_db');

        $return[] = $this->mongo_db->delete('vehicleTypes', array('type' => array('$in' => $type_ids)));

        $getAllDriversCursor = $this->mongo_db->get('vehicleTypes', array('type' => array('$in' => $type_ids)));

        $mas_id = array();

        foreach ($getAllDriversCursor as $driver) {
            $mas_id[] = (int) $driver['user'];
        }

        $return[] = $this->mongo_db->delete('location', array('user' => array('$in' => $mas_id)));

        $updateMysqlDriverQry = $this->db->query("delete from master where mas_id in (" . implode(',', $mas_id) . ")");
        $affectedRows += $this->db->affected_rows();

        $updateMysqlApptQry = $this->db->query("delete from appointment where mas_id in (" . implode(',', $mas_id) . ")");
        $affectedRows += $this->db->affected_rows();

        $updateMysqlReviewQry = $this->db->query("delete from passenger_rating where mas_id in (" . implode(',', $mas_id) . ")");
        $affectedRows += $this->db->affected_rows();

        $updateMysqlReviewQry = $this->db->query("delete from master_ratings where mas_id in (" . implode(',', $mas_id) . ")");
        $affectedRows += $this->db->affected_rows();

        $updateMysqlReviewQry = $this->db->query("delete from user_sessions where user_type = 1 and oid in (" . implode(',', $mas_id) . ")");
        $affectedRows += $this->db->affected_rows();

        echo json_encode(array('flag' => 0, 'affectedRows' => $deleteAllVehicles . $deleteVehicleTypes . $updateMysqlDriverQry));
    }

    function deletecountry() {
        $countryid = $this->input->post('countryid');

        $result = $this->db->query("delete from country where Country_Id ='" . $countryid . "'");
    }

    function deletepagecity() {
        $cityid = $this->input->post('cityid');
        $this->load->library('mongo_db');


//        $result = $this->db->query("delete from city_available where City_Id ='" . $cityid . "'");

        $result = $this->db->query("select * from company_info where city = '" . $cityid . "'")->result();
        $City_Name = $this->db->query("select * from city_available where City_Id = '" . $cityid . "'")->result();



        $companies = array();
        foreach ($result as $company) {

            $companies[] = $company->company_id;
        }

        $cities = '';
        foreach ($City_Name as $c) {
            $cities = $c->City_Name;
        }

        $result1 = $this->db->query("select type_id from workplace_types where city_id = '" . $cityid . "'")->result();

        $vehicleTypes = array();

        foreach ($result1 as $company) {
            $vehicleTypes[] = $company->type_id;
        }
        $this->db->query("delete from city_available where City_Id = '" . $cityid . "'");

        if (!empty($companies))
            $this->db->query("delete from company_info where company_id in (" . implode(',', $companies) . ")");

        if (!empty($cityid))
            $this->db->query("delete from dispatcher where city ='" . $cityid . "'");

        if (!empty($vehicleTypes))
            $this->db->query("delete from workplace where type_id in (" . implode(',', $vehicleTypes) . ")");

        if (!empty($vehicleTypes))
            $this->db->query("delete from workplace_types where type_id in (" . implode(',', $vehicleTypes) . ")");

        //$this->db->query("delete from coupons where city_id ='" . $cityid . "'");

        $this->mongo_db->delete('coupons', array('city_id' => $cityid));
        $this->mongo_db->delete('zones', array('city' => $City_Name));

        if (!empty($companies))
            $this->db->query("delete from master where company_id  in (" . implode(',', $companies) . ")");
    }

    function deletedriver() {
        $masterid = $this->input->post('masterid');
        $this->load->library('mongo_db');
        $affectedRows = 0;

        foreach ($masterid as $row) {

            $getMasterDet = $this->db->query("select * from master where mas_id = '" . $row . "'")->row_array();

            if (!is_array($getMasterDet)) {

                echo json_encode(array('flag' => 1, 'affectedRows' => $affectedRows, 'msg' => 'Driver not available'));
                return false;
            }
            $location = $this->mongo_db->delete('location', array('user' => (int) $row));

            $updateCarQry = $this->db->query("update workplace set status = 2 where workplace_id = '" . $getMasterDet['workplace_id'] . "'");
            $affectedRows += $this->db->affected_rows();

            $updateMysqlDriverQry = $this->db->query("delete from master where mas_id = '" . $row . "'");
            $affectedRows += $this->db->affected_rows();

            $updateMysqlApptQry = $this->db->query("delete from appointment where mas_id = '" . $row . "'");
            $affectedRows += $this->db->affected_rows();

            $updateMysqlReviewQry = $this->db->query("delete from passenger_rating where mas_id = '" . $row . "'");
            $affectedRows += $this->db->affected_rows();
            
            $updateMysqlReviewQry = $this->db->query("delete from docdetail where driverid = '" . $row . "'");
            $affectedRows += $this->db->affected_rows();

            $updateMysqlReviewQry = $this->db->query("delete from master_ratings where mas_id = '" . $row . "'");
            $affectedRows += $this->db->affected_rows();

            $updateMysqlReviewQry = $this->db->query("delete from user_sessions where user_type = 1 and oid = '" . $row . "'");
            $affectedRows += $this->db->affected_rows();
        }

        echo json_encode(array('flag' => 0, 'affectedRows' => $affectedRows, 'msg' => 'Process completed.'));
    }

    function deletemodal() {
        $modalid = $this->input->post('modalid');

        $result = $this->db->query("delete from vehiclemodel where id ='" . $modalid . "'");
    }

    function insert_modal() {
        $typeid = $this->input->post('typeid');
         $modal = $this->input->post('modal');
         
        $r = $this->db->query("select * from vehiclemodel where vehiclemodel ='".ucfirst(strtolower($modal))."' and vehicletypeid = '".$typeid."'");
        
        if ($r->num_rows() > 0) {
          
            echo json_encode(array('msg' => "Brand model already exists", 'flag' => 1));
            return;
        } else {
            
            $this->db->query("insert into vehiclemodel(vehiclemodel,vehicletypeid) values('" .ucfirst(strtolower($modal)) . "','" . $typeid . "')");
                if ($this->db->affected_rows() > 0) {
                    echo json_encode(array('msg' => "Brand model inserted successfully", 'flag' =>0));
                    return;
                }

        }

    }

    function deletevehicletype() {
        $val = $this->input->post('val');
        $this->load->library('mongo_db');
        foreach ($val as $row) {
//            $this->db->query("delete  from vehicleType where id = '" . $row . "' ");

            $affectedRows = 0;


            $deleteAllVehicles = $this->db->query("delete from workplace_types where type_id  = '" . $row . "'");

            $affectedRows += $this->db->affected_rows();

            if ($affectedRows <= 0) {

                echo json_encode(array('flag' => 1, 'affectedRows' => $affectedRows, 'msg' => 'Failed to delete'));
                return false;
            }

            $deleteAllVehicles = $this->db->query("delete from workplace where type_id = '" . $row . "'");
            $affectedRows += $this->db->affected_rows();




            $return[] = $this->mongo_db->delete('vehicleTypes', array('type' => (int) $row));

            $getAllDriversCursor = $this->mongo_db->get('location', array('type' => (int) $row));

            $mas_id = array();

            foreach ($getAllDriversCursor as $driver) {
                $mas_id[] = (int) $driver['user'];
            }

            $return[] = $this->mongo_db->delete('location', array('user' => array('$in' => $mas_id)));

            $updateMysqlDriverQry = $this->db->query("delete from master where mas_id in (" . implode(',', $mas_id) . ")");
            $affectedRows += $this->db->affected_rows();

            $updateMysqlApptQry = $this->db->query("delete from appointment where mas_id in (" . implode(',', $mas_id) . ")");
            $affectedRows += $this->db->affected_rows();

            $updateMysqlReviewQry = $this->db->query("delete from passenger_rating where mas_id in (" . implode(',', $mas_id) . ")");
            $affectedRows += $this->db->affected_rows();

            $updateMysqlReviewQry = $this->db->query("delete from master_ratings where mas_id in (" . implode(',', $mas_id) . ")");
            $affectedRows += $this->db->affected_rows();

            $updateMysqlReviewQry = $this->db->query("delete from user_sessions where user_type = 1 and oid in (" . implode(',', $mas_id) . ")");
            $affectedRows += $this->db->affected_rows();
        }

        echo json_encode(array('flag' => 0, 'affectedRows' => $affectedRows, 'msg' => 'Process completed.'));
    }

    function deletevehiclemodal() {
        $val = $this->input->post('val');
        foreach ($val as $row) {
            $this->db->query("delete  from vehiclemodel where id = '" . $row . "' ");
        }
    }

    function deletevehicletypemodel() {
        $val = $this->input->post('val');
        foreach ($val as $row) {

            $this->db->query("delete  from vehiclemodel where vehicletypeid = '" . $row . "' ");
             $this->db->query("delete from vehicleType where id = '" . $row . "' ");
        }
        if($this->db->affected_rows() > 0){
             echo json_encode(array('msg' => 'Vehicle make has been deleted successfully', 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => 'Deletion is failed', 'flag' => 1));
            return;
        }
//        
    }

    function editlonglat() {
        $val = $this->input->post('cityID');
        $lat = $this->input->post('lat');
        $lon = $this->input->post('lon');

//        foreach ($val as $rowid) {
        $this->db->query("update city_available set City_Lat = '" . $lat . "',City_Long = '" . $lon . "' where City_Id ='" . $val . "' ");
//        }
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => 'City latitude and longitude updated successfully', 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => 'Failed to update', 'flag' => 1));
            return;
        }
    }

    function insert_city_available() {
        $lat = $this->input->post('lat');
        $lng = $this->input->post('lng');
        $country = $this->input->post('country');
        $city = $this->input->post('city');

        $query = $this->db->query("select * from city_available where City_Id ='" . $city . "' ");

        if ($query->num_rows() > 0) {
            echo json_encode(array('msg' => "city  already exists", 'flag' => 0));
            return;
        } else {

            $selectCity = "select City_Name from city where City_Id = '" . $city . "'";

            $Result = $this->db->query($selectCity)->result_array();

            $this->db->query("insert into city_available(City_Id,Country_Id,City_Name,City_Lat,City_Long) values('" . $city . "','" . $country . "','" . $Result[0]['City_Name'] . "','" . $lat . "','" . $lng . "')");

            if ($this->db->affected_rows() > 0) {
                echo json_encode(array('msg' => "City has been configured successfully", 'flag' => 1));
                return;
            }
        }
    }

    function cityinsert_company() {
        return $this->db->query("select City_Name,City_Id from city_available ORDER BY City_Name ASC ")->result();
    }

    function getCityList()
    {
         $getAll = $this->mongo_db->get('cities');
         return $getAll;
    }
                function get_driver() {
        return $this->db->query("select * from master ORDER BY last_name")->result();
    }

    function insert_company() {
        
        $registered = $this->input->post('registered');
        $companyname = $this->input->post('companyname');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $mobile = $this->input->post('mobilenumber');
        $city = $this->input->post('cityname');
        $state = $this->input->post('state');
        $postcode = $this->input->post('pincode');
        $vatnumber = $this->input->post('vatnumber');

        $status = 1;
        $companylogo = $_FILES["companylogo"]["name"];
        $extra = substr($companylogo, strrpos($companylogo, '.') + 1); //explode(".", $insurname);
        $logo = (rand(1000, 9999) * time()) . '.' . $extra;

        $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/pics/';

        try {
            if($companylogo)
                move_uploaded_file($_FILES['companylogo']['tmp_name'], $documentfolder . $logo);
        } catch (Exception $ex) {
            print_r($ex);
            return false;
        }
        
      $result = $this->mongo_db->get('operators');
      $operatorID = 1;
      if(!empty($result))
      {
          foreach ($result as $each)
              $operatorID = $each['operatorID'];
      }
         
        $result = $this->mongo_db->insert('operators',array('registered'=>(int)$registered,'operatorName'=>ucfirst(strtolower($companyname)),'operatorID'=>(int)$operatorID+1,'email'=> strtolower($email),'cityID'=>$city,'state'=>$state,'address'=>$address,'postcode'=>$postcode,'vatnumber'=>$vatnumber,'fname'=>$firstname,'lname'=>$lastname,'mobile'=>$mobile,'status'=>(int)$status,'operatorLogo'=>$logo));

        return;
    }

    function update_company() {
        
        $registered = $this->input->post('registered');
        $companyID = $this->input->post('companyID');
        $companyname = $this->input->post('companyname');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $mobile = $this->input->post('mobilenumber');
        $city = $this->input->post('cityname');
        $state = $this->input->post('state');
        $postcode = $this->input->post('pincode');
        $vatnumber = $this->input->post('vatnumber');

        $companylogo = $_FILES["e_companylog"]["name"];
        $extra = substr($companylogo, strrpos($companylogo, '.') + 1); //explode(".", $insurname);
        $logo = (rand(1000, 9999) * time()) . '.' . $extra;

        $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/pics/';

        try {
             if($companylogo != '')
                move_uploaded_file($_FILES['e_companylog']['tmp_name'], $documentfolder . $logo);
        } catch (Exception $ex) {
            print_r($ex);
            return false;
        }

        
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($companyID)))->set(array('registered'=>(int)$registered,'operatorName'=>ucfirst(strtolower($companyname)),'email'=> strtolower($email),'cityID'=>$city,'state'=>$state,'address'=>$address,'postcode'=>$postcode,'vatnumber'=>$vatnumber,'fname'=>$firstname,'lname'=>$lastname,'mobile'=>$mobile,'operatorLogo'=>$logo))->update('operators');
        
        echo json_encode(array('msg' => "Successfully updated", 'flag' => 1));
        return;
        
    }

    function get_passengerinfo($status) {
        $varToShowData = $this->db->query("select * from slave where status='" . $status . "'order by slave_id DESC")->result();

        return $varToShowData;
    }

    function inactivepassengers() {
        $val = $this->input->post('val');

        foreach ($val as $result) {
            $this->db->query("update slave set status= 4 where slave_id='" . $result . "'");
        }
    }

//
//    function get_compaigns_data($status = '') {
//
//        return $this->db->query(" select cp.*,c.city_name,c.Currency as currency from coupons cp, city c where cp.city_id = c.city_id and cp.coupon_type = '" . $status . "' and cp.status = '0' and user_type = 2")->result();
//    }

    function get_compaigns_data($status = '') {

        $this->load->library('mongo_db');

        $db = $this->mongo_db->db;

        $selecttb = $db->selectCollection('coupons');

        if ($status == '1' || $status == '')
            $cond = array('coupon_type' => 1, 'coupon_code' => 'REFERRAL', 'user_type' => 2, 'status' => 0);
        else if ($status == '2')
            $cond = array('coupon_type' => 2, 'user_type' => 2, 'status' => 0);
        else if ($status == '3')
            $cond = array('coupon_type' => 3, 'user_type' => 1,'status'=>1);

        $find = $selecttb->find($cond);

        $allDocs = array();

        foreach ($find as $doc) {
            $allDocs[] = $doc;
        }

//        print_r($allDocs);exit();

        return $allDocs;

//        return $this->db->query(" select cp.*,c.city_name,c.Currency as currency from coupons cp, city c where cp.city_id = c.city_id and cp.coupon_type = '" . $status . "' and cp.status = '0' and user_type = 2")->result();
    }

    function get_compaigns_data_ajax($for = '',$status = '') {
//            $date =  date('Y-m-d');

        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
        $selecttb = $db->selectCollection('coupons');
        $st = $this->input->post('value');
        $allDocs = array();
        if ($for == '1') {
            if ($st == '0') {
                $cond = array('status' => (int) $st, 'coupon_type' => 1, 'coupon_code' => 'REFERRAL', 'user_type' => 2);
            } else if ($st == '1') {
                $cond = array('status' => (int) $st, 'coupon_type' => 1, 'coupon_code' => 'REFERRAL', 'user_type' => 2);
                //$res = $this->db->query(" select cp.*,c.city_name,c.Currency as currency from coupons cp, city c where cp.city_id = c.city_id and cp.coupon_type = '" . $for . "' and cp.status = '" . $st . "' and user_type = 2")->result();
            }
        } else if ($for == '2') {
            if ($st == '0')
                $cond = array('coupon_type' => 2, 'user_type' => 2, 'status' => 0);
            else if ($st == '10')
                $cond = array('coupon_type' => 2, 'user_type' => 2, 'status' => 1);
        } 
        else
        {  
            if($status == 31)
             $cond = array('coupon_type' => 3, 'user_type' => 1,'status'=>1);
            else if($status == 32)
             $cond = array('coupon_type' => 3, 'user_type' => 1,'status'=>0);
            else
               $cond = array('coupon_type' => 3,'expiry_date' => array('$gte' => time()));
     
        }

        $res = $selecttb->find($cond);
        foreach ($res as $doc) {
            $allDocs[] = $doc;
        }
         echo json_encode(array('data' => $allDocs));
    }

    function deactivecompaigns() {
        $this->load->library('mongo_db');


        $val = $this->input->post('val');
        $fdata = array('status' => 1,);
        foreach ($val as $row) {
            //$this->$db->update("update coupons set status = 1   where id='" . $row . "'");
            $this->mongo_db->update("coupons", $fdata, array("_id" => new MongoId($row)));
        }
//        if ($this->db->affected_rows() > 0) {
//            echo json_encode(array('msg' => "your selected discount deactivated successfully", 'flag' => 0));
//            return;
//        }
    }

    function activepassengers() {
        $val = $this->input->post('val');

        foreach ($val as $result) {
            $this->db->query("update slave set status=3 where slave_id='" . $result . "'");
        }
    }

    function insertdispatches() {
        $name = $this->input->post('name');
        $city = $this->input->post('city');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $status = 1;
        $res = $this->db->query("insert into dispatcher(dis_name,dis_email,dis_pass,city) values('" . $name . "','" . $email . "','" . $password . "','" . $city . "')");

        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => '0'));
            return;
        } else {
            echo json_encode(array('msg' => '1'));
            return;
        }
    }

    function inactivedispatchers() {
        $status = $this->input->post('val');
        foreach ($status as $row) {
            $result = $this->db->query("update dispatcher set status=2 where dis_id='" . $row . "'");
        }
    }

    function activedispatchers() {
        $status = $this->input->post('val');
        foreach ($status as $row) {
            $result = $this->db->query("update dispatcher set status=1 where dis_id='" . $row . "'");
        }
    }

    function deletedispatchers() {
        $status = $this->input->post('val');
        foreach ($status as $row) {
            $result = $this->db->query("delete from dispatcher  where dis_id='" . $row . "'");
        }
    }

    function editdispatchers() {
        $city = $this->input->post('cityval');
        $val = $this->input->post('val');
        $email = $this->input->post('email');
        $name = $this->input->post('name');

        $this->db->query("update dispatcher set city='" . $city . "', dis_name = '".$name."', dis_email = '".$email."'  where dis_id='" . $val . "'");

        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => 'Updated successfully', 'flag' => 0));
            return;
        } else {
            echo json_encode(array('msg' => 'Updation failed', 'flag' => 1));
            return;
        }
    }

    function editpass() {
        $newpass = $this->input->post('newpass');
        $val = $this->input->post('val');

//        $this->db->query("select * from dispatcher where dis_pass='" . $newpass . "' ")->result();

        $this->db->query("update dispatcher set dis_pass='" . $newpass . "' where dis_id = '" . $val . "' ");
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "this password already exists. Enter new password", 'flag' => 1));
            return;
        }
//         else {
//              $this->db->query("update dispatcher set dis_pass='" . $newpass . "' ");
//
//        }
    }

    function get_disputesdata($status) {
        $result = $this->db->query(" select mas.first_name as mas_fname,mas.last_name as mas_lname,mas.mas_id,slv.slave_id,slv.first_name as slv_name,slv.last_name as slv_lname,rep.report_msg,rep.report_id,rep.report_dt,rep.appointment_id from master mas,slave slv, reports rep where rep.mas_id = mas.mas_id   and rep.slave_id = slv.slave_id and rep.report_status = '" . $status . "' order by rep.report_id DESC")->result();

        return $result;
    }

    function resolvedisputes() {
        $value = $this->input->post('val');
        $mesage = $this->input->post('message');

        $this->db->query("update reports set report_status=2, report_msg='" . $mesage . "' where report_id='" . $value . "'");
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "your selected dispute resolved succesfully", 'flag' => 1));
            return;
        }
    }

    function driver() {
        $res = $this->db->query("select * from master order by first_name")->result();
        return $res;
    }

    function passenger() {
        $res = $this->db->query("select * from slave")->result();
        return $res;
    }

    function insertcampaigns() {



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

//    function insertcampaigns() {
//        $codes = $this->input->post('codes');
//        $city = $this->input->post('city');
//        $coupon_type = $this->input->post('coupon_type');
//        $discount = $this->input->post('discount');
//        $discounttype = $this->input->post('discountradio');
//        $referaldiscount = $this->input->post('referaldiscount');
//        $refferaldiscounttype = $this->input->post('refferalradio');
//        $message = $this->input->post('message');
//        $title = $this->input->post('title');
//
//
//        $citys = $this->input->post('citys');
//        $discounts = $this->input->post('discounts');
//        $messages = $this->input->post('messages');
//        $discounttypes = $this->input->post('discounttypes');
//
//        if ($coupon_type == '1') {
//            $res = $this->db->query("select * from coupons where coupon_type=1 and status=0 and city_id='" . $city . "' ");
//
//            if ($res->num_rows() > 0) {
//                return json_encode(array('msg' => "Referral already exists in this city ", 'flag' => 1));
//            }
//        }
//        if ($coupon_type == '2') {
//            $res = $this->db->query("select * from coupons where coupon_type=2 and status=0 and city_id='" . $city . "' and coupon_code = '" . $codes . "' and expiry_date < '" . date('Y-m-d', time()) . "'");
//
//            if ($res->num_rows() > 0) {
//                return json_encode(array('msg' => "Coupon already exists in this city ", 'flag' => 1));
//            }
//        }
//
//        if ($coupon_type == '1') {
//            $this->db->query("insert into coupons(coupon_code,coupon_type,discount_type,discount,referral_discount_type,referral_discount,message,city_id,user_type,title)
//        values('REFERRAL','1','" . $discounttype . "','" . $discount . "','" . $refferaldiscounttype . "','" . $referaldiscount . "','" . $message . "','" . $city . "','2','" . $title . "') ");
//        } else if ($coupon_type == '2') {
//            $this->db->query("insert into coupons(coupon_code,start_date,expiry_date,coupon_type,discount_type,discount,message,city_id,user_type,title)
//                    values('" . $codes . "','" . date("Y-m-d", strtotime($this->input->post('sdate'))) . "','" . date("Y-m-d", strtotime($this->input->post('edate'))) . "','2','" . $discounttypes . "','" . $discounts . "','" . $messages . "','" . $citys . "','2','" . $title . "') ");
//        }
////         else{
//        return json_encode(array('msg' => "Great! Your referrals has been added sucessfully for this city", 'flag' => 0));
////            }
//    }

    function updatecompaigns() {
       
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

    function SignupEmail($email, $firstname) {


        $toemail = $email;
        $toname = $firstname;

        $reply = REPLY_EMAIL_ID;
        $subject = 'Thank you for registering with ' . Appname;

        $body = '<div style="padding:45px 45px 15px">          
  <div style="font-size:20px;font-weight:normal;margin-bottom:30px">
    <strong>Hello ' . ucwords($firstname) . '</strong>
  </div>

  <div style="font-size:24px;font-weight:normal;margin-bottom:15px;color:#1fbad6">
    Thank you for registering with ' . Appname . '!<br><br>
    One of our representatives will get in touch with you in the next 24 hours to setup your profile and get all the necessary documents.
  </div>

  <table style="width:460px;margin:30px auto 30px;border-spacing:0px;line-height:0px">
    <tbody><tr>
      <td style="border-bottom-width:1px;border-bottom-color:#c0c0c8;border-bottom-style:solid">&nbsp;</td>
      <td style="border-bottom-width:1px;border-bottom-color:#c0c0c8;border-bottom-style:solid">&nbsp;</td>
    </tr>
    <tr>
      <td style="border-top-width:1px;border-top-color:#ffffff;border-top-style:solid">&nbsp;</td>
      <td style="border-top-width:1px;border-top-color:#ffffff;border-top-style:solid">&nbsp;</td>
    </tr>
  </tbody></table>
  <div>Regards,  </div>
  <div>Team ' . Appname . '.</div>
  </div>';
//
////                exit();
        try {

            $config = array();


           $config['api_key'] = api_key_for_mail;

            $config['api_url'] = api_url_for_email;

            $message = array();

            $message['from'] = $reply;

            $message['toname'] = rtrim($toname, ',');

            $message['to'] = rtrim($toemail, ',');

            $message['h:Reply-To'] = $reply;

            $message['subject'] = $subject;

            $message['html'] = $body; //file_get_contents("http://www.domain.com/email/html");

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $config['api_url']);

            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            curl_setopt($ch, CURLOPT_USERPWD, "api:{$config['api_key']}");

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $message);

            $result = curl_exec($ch);

            curl_close($ch);

            return $result;
        } catch (Mandrill_Error $e) {
            return array('msg' => $e->getMessage(), 'status' => 'failed', 'flag' => 1);
        }

    }
    function emailForResetPasswordForadmin($email, $firstname,$randNum) {


        $toemail = $email;
        $toname = $firstname;

        $reply = REPLY_EMAIL_ID;
        $subject = 'Reset password for ' . Appname.' admin panel';

        $body = '<div style="padding:45px 45px 15px">          
  <div style="font-size:20px;font-weight:normal;margin-bottom:30px">
    <strong>Hello ' . ucwords($firstname) . '</strong>
  </div>

  <div style="font-size:14px;font-weight:normal;margin-bottom:15px;color:#1fbad6">
    Your new password for '.Appname.' admin panel is : <b>'.$randNum.'</b>
</div>


  <div>Regards,  </div>
  <div>Team ' . Appname . '.</div>
  </div>';
//
////                exit();
        try {

            $config = array();


           $config['api_key'] = api_key_for_mail;

            $config['api_url'] = api_url_for_email;

            $message = array();

            $message['from'] = $reply;

            $message['toname'] = rtrim($toname, ',');

            $message['to'] = rtrim($toemail, ',');

            $message['h:Reply-To'] = $reply;

            $message['subject'] = $subject;

            $message['html'] = $body; //file_get_contents("http://www.domain.com/email/html");

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $config['api_url']);

            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            curl_setopt($ch, CURLOPT_USERPWD, "api:{$config['api_key']}");

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $message);

            $result = curl_exec($ch);

            curl_close($ch);

            return $result;
        } catch (Mandrill_Error $e) {
            return array('msg' => $e->getMessage(), 'status' => 'failed', 'flag' => 1);
        }

    }

    function sendMailToDriverAfterAccept($email, $firstname) {


        $toemail = $email;
        $toname = $firstname;

        $reply = emailFrom;

        $subject = 'Thank you for registering with ' . Appname;

        $body = '<div style="padding:45px 45px 15px">          
  <div style="font-size:20px;font-weight:normal;margin-bottom:30px">
    <strong>Hello ' . ucwords($firstname) . '</strong>
  </div>

  <div style="font-size:24px;font-weight:normal;margin-bottom:15px;color:#1fbad6">
    You are accepted by our team ' . Appname . '!<br><br>
    
  </div>

  <table style="width:460px;margin:30px auto 30px;border-spacing:0px;line-height:0px">
    <tbody><tr>
      <td style="border-bottom-width:1px;border-bottom-color:#c0c0c8;border-bottom-style:solid">&nbsp;</td>
      <td style="border-bottom-width:1px;border-bottom-color:#c0c0c8;border-bottom-style:solid">&nbsp;</td>
    </tr>
    <tr>
      <td style="border-top-width:1px;border-top-color:#ffffff;border-top-style:solid">&nbsp;</td>
      <td style="border-top-width:1px;border-top-color:#ffffff;border-top-style:solid">&nbsp;</td>
    </tr>
  </tbody></table>
  <div>Regards,  </div>
  <div>Team ' . Appname . '.</div>
  </div>';

//                exit();
        try {

            $config = array();


          $config['api_key'] = api_key_for_mail;

            $config['api_url'] = api_url_for_email;

            $message = array();

            $message['from'] = $reply;

            $message['toname'] = rtrim($toname, ',');

            $message['to'] = rtrim($toemail, ',');

            $message['h:Reply-To'] = $reply;

            $message['subject'] = $subject;

            $message['html'] = $body; //file_get_contents("http://www.domain.com/email/html");

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $config['api_url']);

            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            curl_setopt($ch, CURLOPT_USERPWD, "api:{$config['api_key']}");

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $message);

            $result = curl_exec($ch);

            curl_close($ch);

            return $result;
        } catch (Mandrill_Error $e) {
            return array('msg' => $e->getMessage(), 'status' => 'failed', 'flag' => 1);
        }
    }

    public function sendMasWelcomeMail($toMail, $toName) {

        $subject = 'Thank you for registering with ' . Appname;

        $body = '<div style="padding:45px 45px 15px">          
  <div style="font-size:20px;font-weight:normal;margin-bottom:30px">
    <strong>Hello ' . ucwords($toName) . '</strong>
  </div>

  <div style="font-size:24px;font-weight:normal;margin-bottom:15px;color:#1fbad6">
    Thank you for registering with ' . Appname . '!<br><br>
    One of our representatives will get in touch with you in the next 24 hours to setup your profile and get all the necessary documents.
  </div>

  <table style="width:460px;margin:30px auto 30px;border-spacing:0px;line-height:0px">
    <tbody><tr>
      <td style="border-bottom-width:1px;border-bottom-color:#c0c0c8;border-bottom-style:solid">&nbsp;</td>
      <td style="border-bottom-width:1px;border-bottom-color:#c0c0c8;border-bottom-style:solid">&nbsp;</td>
    </tr>
    <tr>
      <td style="border-top-width:1px;border-top-color:#ffffff;border-top-style:solid">&nbsp;</td>
      <td style="border-top-width:1px;border-top-color:#ffffff;border-top-style:solid">&nbsp;</td>
    </tr>
  </tbody></table>
  <div>Regards,  </div>
  <div>Team ' . Appname . '.</div>
  </div>';

        $recipients = array($toMail => $toName);

        return $this->mailFun($recipients, $subject, $body);
    }

    function mailFun($recipients, $subject, $body, $reply = MANDRILL_FROM_EMAIL) {

        $toemail = $toname = "";
        foreach ($recipients as $email => $name) {

            if ($email != '') {
                $toemail .= $email . ",";
                $toname .= $name . ",";
            }
        }
        try {

            $config = array();


            $config['api_key'] = "key-eb2fbb7432506149c63b2edcdd4f9185";

            $config['api_url'] = "https://api.mailgun.net/v3/roadyo.in/messages";

            $message = array();

            $message['from'] = $reply;

            $message['toname'] = rtrim($toname, ',');

            $message['to'] = rtrim($toemail, ',');

            $message['h:Reply-To'] = $reply;

            $message['subject'] = $subject;

            $message['html'] = $body; //file_get_contents("http://www.domain.com/email/html");

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $config['api_url']);

            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            curl_setopt($ch, CURLOPT_USERPWD, "api:{$config['api_key']}");

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $message);

            $result = curl_exec($ch);

            curl_close($ch);

            return $result;
        } catch (Mandrill_Error $e) {
            return array('msg' => $e->getMessage(), 'status' => 'failed', 'flag' => 1);
        }
    }

//    function editcompaigns() {
//        $value = $this->input->post('val');
//
//        $resu = $this->db->query("select * from coupons where id='" . $value . "'")->result();
//        echo json_encode($resu);
//    }

    function editcompaigns() {
        $value = $this->input->post('val');

        $this->load->library('mongo_db');

        $db = $this->mongo_db->db;

        $selecttb = $db->selectCollection('coupons');

        $resu = $selecttb->findOne(array('_id' => new MongoId($value)));

//        print_r($resu);exit();

        echo json_encode($resu);
    }

    function insertpass() {
        $password = $this->input->post('newpass');
        $val = $this->input->post('val');

        $res = $this->db->query("update slave set password = md5('" . $password . "')  where slave_id='" . $val . "'");
//        return $res;
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "Password updated successfully", 'flag' => 1));
            return;
        }
    }

    function get_company_data($param) {
        $result = $this->db->query("select * from company_info where company_id='" . $param . "' ")->result();
        return $result;
    }

    function company_data() {
        $result = $this->db->query("select * from company_info")->result();
        return $result;
    }

    function get_dispatchers_data($status) {

        $res = $this->db->query("select * from dispatcher where status='" . $status . "'")->result();
        return $res;
    }

    function delete_dispatcher() {
        $var = $this->input->post('val');

        foreach ($var as $row) {
            $this->db->query("delete  from dispatcher where dis_id ='" . $row . "'");
        }
    }

    function get_country() {
        return $this->db->query("select * from country order by Country_Name")->result();
    }

    function datatable_cities() {

        $this->load->library('Datatables');
        $this->load->library('table');

        $datatosend1 = $this->mongo_db->get('cities');
        
        $slno = 0;
        foreach ($datatosend1 as $city)
            $arr[]= array(++$slno,$city['country'],$city['city']);
        
        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($arr as $row)
            {
                $needle = ucwords($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(ucwords($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
        
        if($this->input->post('sSearch') == '')
        echo $this->datatables->getdataFromMongo($arr);
    }
    function datatable_long_haul_zone() {

        $this->load->library('Datatables');
        $this->load->library('table');
        
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;

        $datatosend1 = $this->mongo_db->get('cities');
        
        $slno = 0;
        foreach ($datatosend1 as $city)
            $arr[]= array(++$slno,$city['country'],$city['city'],"<a style='cursor:pointer; text-decoration: none;color:white'   class='btn btn-info' href='".base_url()."index.php/superadmin/long_haul_Pricing/".$city['_id']."'>SET PRICE</a>");
        
         if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($arr as $row)
            {
                $needle = ucwords($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(ucwords($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
        
        if($this->input->post('sSearch') == '')
         echo $this->datatables->getdataFromMongo($arr);
    }

    function datatable_referrals() {
        $this->load->library('Datatables');
        $this->load->library('table');

        $this->datatables->select('c.referred_user_id,c.user_id,s.created_dt,s.slave_id,s.first_name')
                ->unset_column('')
                ->add_column('')
                ->from('')
                ->where('');
        $this->db->order_by("", "desc");
        echo $this->datatables->generate();
    }

    function datatable_promodetails($id) {
        $this->load->library('Datatables');
        $this->load->library('table');


        $this->load->library('mongo_db');

        $db = $this->mongo_db->db->selectCollection('coupons');
        $getBookingIds = $db->findOne(array('_id' => new MongoId($id)));

        $ids = '';
        foreach ($getBookingIds['bookings'] as $res) {
            $ids .= $res['booking_id'] . ',';
        }


        $MasId = rtrim($ids, ',');

//        echo $MasId;
//        exit();
        $query = "a.appointment_id in ('" . $MasId . "') and a.status = 9 and a.slave_id = s.slave_id";

        $this->datatables->select('(a.amount + a.discount),a.discount,a.amount AS Afterdiscount,a.appointment_dt,a.appointment_id,a.slave_id,s.email')
                ->from('appointment a,slave s', false)
                ->where($query);
        $this->db->order_by("a.appointment_id", "desc");

        echo $this->datatables->generate();
    }

    function get_appointmentDetials() {
        $arr = explode('_',$this->input->post('app_id'));
        $bid = $arr[0];
        $query = "select a.appointment_id,(
    case a.status when 1 then 'Request'
     when 2   then
    'Driver accepted.'
     when 3  then
     'Driver rejected.'
     when 4  then
    'Passenger has cancelled.'
     when 5   then
    'Driver has cancelled.'
     when 6   then
    'Driver is on the way.'
     when 7  then
    'Driver arrived.'
     when 8   then
    'Appointment started.'
     when 9   then
    'Appointment completed.'
    when 10 then
    'Appointment timed out.'
    else
    'Status Unavailable.'
    END) as status_result,(case a.payment_type  when 1 then 'card' when 2 then 'cash' END) as paymentstatus,(select type_name from workplace_types where  type_id = m.type_id) as typename,(select basefare from workplace_types where  type_id = m.type_id) as basefare,(select price_per_min from workplace_types where  type_id = m.type_id) as price_per_min,a.appt_lat,a.appt_long,m.first_name,m.mas_id,m.mobile,s.phone,s.first_name as sname,a.address_line1,a.drop_addr1,a.appointment_dt from appointment a,master m,slave s where a.mas_id = m.mas_id and s.slave_id =  a.slave_id and a.appointment_id ='" . $bid . "' ";

        $res = $this->db->query($query)->result();

        foreach ($res as $result) {
            $pickupLat = $result->appt_lat;
            $pickupLong = $result->appt_long;
            $mas_id = $result->mas_id;
            $basefare = $result->basefare;
            $price_per_min = $result->price_per_min;
            $returnJson = $result;
        }


        $this->load->library('mongo_db');
        $returnJson = json_decode(json_encode($returnJson), true);
        $db = $this->mongo_db->db->selectCollection('location');
        $getBookingIds = $db->findOne(array('user' => (int) $returnJson['mas_id']));
       

        $distance = $this->distance($returnJson['appt_lat'], $returnJson['appt_long'], $getBookingIds['location']['latitude'], $getBookingIds['location']['longitude'], '');



        $approxamt = $basefare + ($distance * $price_per_min);

        $datetime1 = strtotime($returnJson['appointment_dt']);
        $datetime2 = time();
        $interval = abs($datetime2 - $datetime1);
        $duration_in_mts_old = $minutes = round($interval / 60);
        if ($minutes >= 60) {
            $returnJson['appointment_dt'] = round(($minutes / 60), 2) . ' hour';
        } else {
            $returnJson['appointment_dt'] = $minutes . ' minutes';
        }


        $returnJson['apprxAmt'] = currency . " " . round($approxamt);
        $returnJson['droplat'] = $getBookingIds['location']['latitude'];
        $returnJson['droplong'] = $getBookingIds['location']['longitude'];


        echo json_encode($returnJson); //json_encode($returnJson);
    }

    function CompleteBooking() {
         $this->load->library('mongo_db');
        $bid = $this->input->post('bid');
        $type = $this->input->post('type');
        $amount = $this->input->post('amount');
        $amountToupdate = 0;
        if($amount)
            $amountToupdate=  floatval ($amount);
      
        $ShipmentDetails = $this->mongo_db->get_one('ShipmentDetails',array('order_id' => (int)$bid));
        $accArr = array('mas_earning'=>0,'pg_commission'=>0,'app_commission'=>0,'cc_fee'=>0,'tip_amount'=>0,'discount'=>0,'amount'=>$amountToupdate);
   

        $res_mongo1 = $this->mongo_db->update('ShipmentDetails', array('receivers.0.status' =>'11','receivers.0.Accounting'=>$accArr,'status'=>11,'actionByAdmin'=>1,'actionDate'=>time()), array('order_id' => (int)$bid));
        $res_mongo2 = $this->mongo_db->update('location', array('status' =>3,'apptStatus'=>0), array('user' => (int)$ShipmentDetails['mas_id']));
        echo json_encode(array('msg'=>'Updated successfully','flag'=>0));  
    }

    function cancelBooking() {
         $this->load->library('mongo_db');
        $bid = $this->input->post('bid');
        $type = $this->input->post('type');
        $amount = $this->input->post('amount');
        
        $amountToupdate = 0;
        if($amount)
            $amountToupdate=  floatval ($amount);
      
        $ShipmentDetails = $this->mongo_db->get_one('ShipmentDetails',array('order_id' => (int)$bid));
        $accArr = array('mas_earning'=>0,'pg_commission'=>0,'app_commission'=>0,'cc_fee'=>0,'tip_amount'=>0,'discount'=>0,'amount'=>$amountToupdate);
        $res_mongo1 = $this->mongo_db->update('ShipmentDetails', array('receivers.0.status' =>'12','receivers.0.Accounting'=>$accArr,'status'=>12,'actionByAdmin'=>1,'actionDate'=>time()), array('order_id' => (int)$bid));
        $res_mongo2 = $this->mongo_db->update('location', array('status' =>3,'apptStatus'=>0), array('user' => (int)$ShipmentDetails['mas_id']));
        echo json_encode(array('msg'=>'Updated successfully','flag'=>0));
    }


    function datatable_operator($status = '') {
         $this->load->library('Datatables');
        $this->load->library('table');
        
             $operatorsData = $this->mongo_db->get_where('operators',array('status'=>(int)$status));
             $slno=0;
             foreach ($operatorsData as $each)
             {
                 $type = 'Unregistered';
                 if($each['registered'] == 0)
                   $type = 'Registered'; 
                 
                 $citiesData = $this->mongo_db->get_where('cities', array('_id' => new MongoDB\BSON\ObjectID($each['cityID'])));
                    foreach ($citiesData as $city)
                        $arr[] = array(++$slno,$city['city'],$each['operatorName'],$type,$each['address'],$each['state'],$each['postcode'],$each['fname'],$each['email'],$each['mobile'],'<input type="checkbox" class="checkbox" name="checkbox" value="'.$each['_id']['$oid'].'">');
             }
                     
                    if($this->input->post('sSearch') != '')
                   {

                       $FilterArr = array();
                       foreach ($arr as $row)
                       {
                           $needle = strtoupper($this->input->post('sSearch'));
                           $ret = array_keys(array_filter($row, function($var) use ($needle){
                               return strpos(strtoupper($var), $needle) !== false;
                           }));
                          if (!empty($ret)) 
                          {
                              $FilterArr [] = $row;
                          }

                       }
                            echo $this->datatables->getdataFromMongo($arr);
                      }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($arr);
    }

    public function vehicletype_reordering() {
//        
        $this->load->library('mongo_db');
        $res = $this->mongo_db->get_one('vehicleTypes', array('type' => (int) $_REQUEST['curr_id']));
        $res1 = $this->mongo_db->get_one('vehicleTypes', array('type' => (int) $_REQUEST['prev_id']));



        $currcount = $res['order'];
        $prevcount = $res1['order'];



        $res_mongo1 = $this->mongo_db->update('vehicleTypes', array('order' => $prevcount), array('type' => (int) $_REQUEST['curr_id']));
        $res_mongo2 = $this->mongo_db->update('vehicleTypes', array('order' => $currcount), array('type' => (int) $_REQUEST['prev_id']));

//            
        $res_mysql1 = $this->db->query("update workplace_types set vehicle_order = '" . $prevcount . "'  where type_id = '" . $_REQUEST['curr_id'] . "'");
        $res_mysql2 = $this->db->query("update workplace_types set vehicle_order = '" . $currcount . "'  where type_id = '" . $_REQUEST['prev_id'] . "'");
//            
//             echo $res_mysql1;
//            echo $res_mysql2;
//            $mongo_flag = 1;
//            if ($restuet['ok'] == 1 && $restuet_['ok'] == 1)
//                $mongo_flag = 0;
//            
        $mysql_flag = 0;
        if ($this->db->affected_rows > 0)
            $mysql_flag = 1;

//            echo json_encode(array('mongo_flag' => $res_mongo2,'mysql_flag' => $res_mysql2,"currcount"=>$currcount,"prevcount"=>$prevcount));
        echo json_encode(array('flag' => 1));
        return true;
    }

    function datatable_vehicletype($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->get('vehicleTypes');
        foreach ($result as $r)
              $arr[] = array($r['type'],$r['type_name'],'<a class="vehicleDetails"   length="'.substr($r['vehicle_length'],0,-1).'" length_metric = "'.substr($r['vehicle_length'],-1).'" width="'.substr($r['vehicle_width'],0,-1).'" width_metric = "'.substr($r['vehicle_width'],-1).'" height="'.substr($r['vehicle_height'],0,-1).'" height_metric = "'.substr($r['vehicle_height'],-1).'" capacity="'.$r['vehicle_capacity'].'"  style="cursor: pointer"> <button class="btn btn-info btn-sm" style="width:inherit;"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>', '<a class="pricing"  min_fare="' . $r['min_fare'] . '" waiting_charge="' . $r['waiting_charge']. '"  cancellation_fee="' . $r['cancellation_fee'] . '" mileagePrice="' .  $r['mileage_price']  . '" waiting_minutes ="'.$r['waiting_time_min'].'" cancellation_minutes ="'.$r['cancenlation_min'].'"  minimum_km_miles ="'.$r['min_distance'].'" x_zonal_km_miles ="'.$r['x_zonal_km_miles'].'" mileageMetric = "'.$r['mileage_metrc'].'" zonalEnable="'.$r['zonalEnable'].'" zonal_km_miles_greater_or_less ="'.$r['zonal_km_miles_greater_or_less'].'" style="cursor: pointer; "> <button class="btn btn-warning" style="width:inherit; background-color: palevioletred;border-color: palevioletred;"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>','<a class="images" type_id="'.$r['type'].'" on_image="'.$r['vehicle_img'].'" off_image="'.$r['vehicle_img_off'].'" map_image="'.$r['MapIcon'].'" style="cursor: pointer"> <button style="width:inherit;" class="btn btn-warning btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i> View</button></a>',$r['type_desc'],'<input type="checkbox" class="checkbox" name="checkbox" value= "'.$r['type'].'"/>');

        
        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($arr as $row)
            {
                $needle = ucwords($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(ucwords($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
        
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($arr);
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
        
        if($type_on_img)
        {
            $this->db->query("update workplace_types set vehicle_img ='".$type_on_image."' where type_id = ".$this->input->post('vehicleType_id')."");
            $fdata = array('vehicle_img' => $type_on_image);
        }
        if($type_off_img)
        {
            $this->db->query("update workplace_types set vehicle_img_off ='".$type_off_image."' where type_id = ".$this->input->post('vehicleType_id')."");
            $fdata = array('vehicle_img_off' => $type_off_image);
        }
        if($type_map_img)
        {
            $this->db->query("update workplace_types set MapIcon ='".$type_map_image."' where type_id = ".$this->input->post('vehicleType_id')."");
            $fdata = array('MapIcon' => $type_map_image);
        }
        
         $this->mongo_db->update("vehicleTypes", $fdata, array("type" =>(int)$this->input->post('vehicleType_id')));
         return;
       
    }



    function documentgetdata() {
        $val = $this->input->post("val");
        /* \
         * [doc_ids] => 367
          [driverid] => 830
          [url] => 8204124114494.jpg
          [expirydate] => 2014-05-31
          [doctype] => 1
         */
        $return = array();
        foreach ($val as $row) {
            $data = $this->db->query("select * from docdetail where driverid = '" . $row . "'")->result();
        }
        foreach ($data as $doc) {
            $return[] = array('doctype' => $doc->doctype, 'url' => $doc->url, 'expirydate' => $doc->expirydate);
        }
        return $return;
    }

    function datatable_vehicles($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $city = $this->session->userdata('city_id');
        $company = $this->session->userdata('company_id');
        if (($city != '0') && ($company == '0'))
            $citylist = ' and wt.city_id = "' . $city . '"';
        else if (($city != '0') && ($company != '0'))
            $citylist = ' and wt.city_id = "' . $city . '" and w.company = "' . $company . '"';


        if ($status == '12') {
            $status = '1,2';

            $this->datatables->select('w.workplace_id,w.uniq_identity,'
                            . '(select vehicletype from vehicleType where id = w.Title),'
                            . '(select vehiclemodel from vehiclemodel where id = w.Vehicle_Model),'
                            . '(select type_name from workplace_types  where type_id = w.type_id),'
                            . '(case w.account_type when 1 then "Freelancer" when 2 then "Operator" end),'
                            . '(select first_name from master  where mas_id = w.mas_id),'
                            . '(select mobile from master  where mas_id = w.mas_id),'
                            . '(select companyname from company_info  where company_id = w.company),'
                            . 'w.License_Plate_No')
//                            . '(select City_Name from city where City_Id = wt.city_id)')
                    ->unset_column('w.workplace_id')
                    ->add_column('select', '<input type="checkbox" class="checkbox" name="checkbox" value= "$1"/>', 'w.workplace_id')
                    ->from('workplace w,vehicleType vt,vehiclemodel vm,workplace_types wt')
                    ->where('vt.id = w.title and vm.id=w.Vehicle_Model and wt.type_id = w.type_id  and w.Status in (' . $status . ')'); //order by slave_id DESC ",false);
            $this->db->order_by("w.workplace_id", "desc");
        } else if ($status == '2') {
            $this->datatables->select('w.workplace_id,w.uniq_identity,'
                            . '(select vehicletype from vehicleType where id = w.Title),'
                            . '(select vehiclemodel from vehiclemodel where id = w.Vehicle_Model),'
                            . '(select type_name from workplace_types  where type_id = w.type_id),'
                            . '(case w.account_type when 1 then "Freelancer" when 2 then "Operator" end),'
                             . '(select first_name from master  where mas_id = w.mas_id),'
                            . '(select mobile from master  where mas_id = w.mas_id),'
                            . '(select companyname from company_info  where company_id = w.company),'
                            . 'w.License_Plate_No')
//                            . '(select City_Name from city where City_Id = wt.city_id)')
                    ->unset_column('w.workplace_id')
                    ->add_column('select', '<input type="checkbox" class="checkbox" name="checkbox" value= "$1"/>', 'w.workplace_id')
                    ->from('workplace w,vehicleType vt,vehiclemodel vm,workplace_types wt')
                    ->where('vt.id = w.title and  vm.id=w.Vehicle_Model and wt.type_id = w.type_id  and w.Status in (' . $status . ')'); //order by slave_id DESC ",false);
            $this->db->order_by("w.workplace_id", "desc");
        } else {
            $this->datatables->select('w.workplace_id,w.uniq_identity,'
                            . '(select vehicletype from vehicleType where id = w.Title),'
                            . '(select vehiclemodel from vehiclemodel where id = w.Vehicle_Model),'
                            . '(select type_name from workplace_types  where type_id = w.type_id),'
                     . '(case w.account_type when 1 then "Freelancer" when 2 then "Operator" end),'
                           . '(select first_name from master  where mas_id = w.mas_id),'
                            . '(select mobile from master  where mas_id = w.mas_id),'
                            . '(select companyname from company_info  where company_id = w.company),'
                            . 'w.License_Plate_No')
//                            . '(select City_Name from city where City_Id = wt.city_id)')
                    ->unset_column('w.workplace_id')
                    ->add_column('select', '<input type="checkbox" class="checkbox" name="checkbox" value= "$1"/>', 'w.workplace_id')
                    ->from('workplace w,vehicleType vt,vehiclemodel vm,workplace_types wt')
                    ->where('vt.id = w.title and vm.id=w.Vehicle_Model and wt.type_id = w.type_id  and w.Status in (' . $status . ')'); //order by slave_id DESC ",false);
            $this->db->order_by("w.workplace_id", "desc");
        }


        echo $this->datatables->generate();
    }
    
    function getAppConfig() {
       
        $getAll = $this->mongo_db->get('appConfig');
        return $getAll;
        
    }
    function getAppConfigOne() {
       
        $getAll =  $this->mongo_db->find_one('appConfig'); 
        return $getAll;
        
    }
    
     function getOperators() {
       
        $getAll = $this->mongo_db->where(array('status'=>3))->get('operators');
        return $getAll;
        
    }
    function getAppConfig_ajax() {
       
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
        $selecttb = $db->selectCollection('appConfig');

        $data = $selecttb->findOne();
        echo json_encode(array('data'=>$data));
        
       
        
    }
    function updateAppConfig() {
        
       $driverGoogleKey = $this->input->post('driverGoogleKey');
       $customerGoogleKey = $this->input->post('customerGoogleKey');
        
        $paymentMode = 0;
        if($this->input->post('paymentMode') == 'on')//1-Stripe
            $paymentMode = 1;
        $googleKeys = array();
        
        for ($i=0;$i<count($driverGoogleKey);$i++)
        {
            $googleKeys[]=array('driverKey'=>$driverGoogleKey[$i],'customerKey'=>$customerGoogleKey[$i],'order'=>(int)$i);
        }
        
        $mileagePricing = 0;
        if($this->input->post('mileagePricing') == 'on')
            $mileagePricing = 1;
        
        $zonalPricing = 0;
        if($this->input->post('zonalPricing') == 'on')
            $zonalPricing = 1;
        
        $scheduledBookingsOnOFF = 0;
        if($this->input->post('scheduledBookingsOnOFF') == 'on')
            $scheduledBookingsOnOFF = 1;
        
      $pricing_mode = array('zonalPricing'=>(int)$zonalPricing,'mileagePricing'=>(int)$mileagePricing,'longHaul'=>(int)$this->input->post('longHaul'),'shortHaul'=>(int)$this->input->post('shortHaul'),'paymentMode'=>$paymentMode);
      $dispatch_settings = array('driverAcceptTime'=>(int)$this->input->post('timeForacceptBooking'),'dispatchStartHour'=>(int)$this->input->post('dispatchHourStartTime'),'dispatchStartMinutes'=>(int)$this->input->post('dispatchMinStartTime'),'dispatchDuration'=>(int)$this->input->post('dispatchDuration'),'scheduledBookingsOnOFF'=>$scheduledBookingsOnOFF);
     
       
        $this->load->library('mongo_db');
        $mongoArr = array('currencySymbol'=>$this->input->post('currencySymbol'),'currency'=> strtoupper($this->input->post('currency')),'mileage_metric'=>$this->input->post('mileage_metric'),'weight_metric'=>$this->input->post('weightMetric'),'appCommission'=>(int)$this->input->post('appCommission'),'appCommissionPayBy'=>(int)$this->input->post('appCommissionPayBy'),'pubnubkeys'=>$this->input->post('pubnubkeys'),'pricing_model'=>$pricing_mode,'dispatch_settings'=>$dispatch_settings,'googleKeys'=>$googleKeys);


        $this->mongo_db->where(array())->set($mongoArr)->update('appConfig');
       
        return;
        
    }
    
    function datatable_specialies()
    {
         $this->load->library('Datatables');
        $this->load->library('table');
        
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
         $mongoData =  $db->selectCollection('Driver_specialities')->find();
         
         $sl_no = 0;
         foreach ($mongoData as $row)
             $arrData[] = array(++$sl_no,$row['name'],'<input type="checkbox" class="checkbox" name="checkbox" value= "'.$row['_id'].'">');
        
          if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($arrData as $row)
            {
                $needle = strtoupper($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(strtoupper($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
        
        if($this->input->post('sSearch') == '')
          echo $this->datatables->getdataFromMongo($arrData);
        
    }
    
    
    function addSpeciality()
    {
         $this->load->library('Datatables');
        $this->load->library('table');
        
        $this->load->library('mongo_db');
        $mongoArr =array('name'=>ucwords(strtolower($this->input->post('name'))));
        $result = $this->mongo_db->get_one('Driver_specialities', array('name' =>ucwords(strtolower($this->input->post('name')))));
        if(empty($result))
        {
             $this->mongo_db->insert('Driver_specialities', $mongoArr);
             echo json_encode(array('msg'=>'Good type is added','flag'=>0));
        }
        else{
             echo json_encode(array('msg'=>'Already good type exists','flag'=>1));
        }
         return;
        
    }
    function getSpecialityData()
    {
          $getAll = $this->mongo_db->get('Driver_specialities');
           return $getAll;
        
    }
    function updateSpeciality()
    {
         $this->load->library('Datatables');
        $this->load->library('table');
        $ids = $this->input->post('id');
        foreach ($ids as $one)
        {
        
            $this->load->library('mongo_db');
            $mongoArr =array('name'=>$this->input->post('name'));
             $this->mongo_db->update('Driver_specialities', $mongoArr,array('_id'=>new MongoId($one)));
             return;
        }
        
    }
    function deleteSpeciality()
    {
        $this->load->library('mongo_db');
        $ids = $this->input->post('id');
        foreach ($ids as $id)  
            $respon = $this->mongo_db->delete('Driver_specialities', array('_id' => new MongoId($id)));
        
        return;
        
    }

    function loadAvailableCity() {
        $countryid = $this->input->post('country');
        $Result = $this->db->query("select c.* from city c where c.Country_Id = '" . $countryid . "' and c.City_Id not in (select City_Id from city_available where Country_Id = '" . $countryid . "')")->result();
        return $Result;
    }

//    function datatable_disputes($status = '') {
//
//        $this->load->library('Datatables');
//        $this->load->library('table');
//
//        $company_id = $this->session->userdata('company_id');
//        $compCond = "";
//        if ($company_id != 0)
//            $compCond = " and mas.company_id = '" . $company_id . "'";
//
//        $this->datatables->select("rep.report_id,slv.slave_id,slv.first_name,mas.mas_id,mas.first_name as name,rep.report_msg,rep.report_dt,rep.appointment_id")
//            ->add_column('select', '<input type="checkbox" class="checkbox" name="checkbox" value="$1"/>', 'rep.report_id')
//            ->from("master mas,slave slv, reports rep")
//            ->where("rep.mas_id = mas.mas_id   and rep.slave_id = slv.slave_id and rep.report_status = '" . $status . "'" . $compCond);
//
//        echo $this->datatables->generate();
//    }

    function datatable_disputes($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $company_id = $this->session->userdata('company_id');
        $compCond = "";
        if ($company_id != 0)
            $compCond = " and mas.company_id = '" . $company_id . "'";

        $this->datatables->select("rep.report_id,slv.slave_id,slv.first_name,mas.mas_id,mas.first_name as name,rep.report_msg,rep.report_dt,rep.appointment_id")
                ->add_column('select', '<input type="checkbox" class="checkbox" name="checkbox" value="$1"/>', 'rep.report_id')
                ->from("master mas,slave slv, reports rep")
                ->where("rep.mas_id = mas.mas_id   and rep.slave_id = slv.slave_id and rep.report_status = '" . $status . "'" . $compCond);
        $this->db->order_by("rep.report_dt", "desc");
        echo $this->datatables->generate();
    }

    function refered($code, $refCode, $page) {


        $this->load->library('mongo_db');

        $db = $this->mongo_db->db;

        $selecttb = $db->selectCollection('coupons');

        $find = $selecttb->find(array('_id' => new MongoId($code), 'signups.coupon_code' => $refCode), array('signups.$' => 1));

        $all = array();

        foreach ($find as $cur) {
            $all[] = $cur;
        }

//        print_r($all);

        return $all;
    }

    function validateCompanyEmail() {

        $query = $this->db->query("select company_id from company_info where email='" . $this->input->post('email') . "'");
        if ($query->num_rows() > 0) {

            echo json_encode(array('msg' => '1'));
            return;
        } else {
            echo json_encode(array('msg' => '0'));
        }
    }

    function datatable_vehicleMake() {
        $this->load->library('Datatables');
        $this->load->library('table');
        
             $vehicleMakeData = $this->mongo_db->get('VehicleMake');
             $slno=0;
             foreach ($vehicleMakeData as $each)
                 $arr[] = array(++$slno,$each['Name'],'<input type="checkbox" class="checkbox" name="checkbox" value="'.$each['_id']['$oid'].'">');
            
                     
                    if($this->input->post('sSearch') != '')
                   {

                       $FilterArr = array();
                       foreach ($arr as $row)
                       {
                           $needle = strtoupper($this->input->post('sSearch'));
                           $ret = array_keys(array_filter($row, function($var) use ($needle){
                               return strpos(strtoupper($var), $needle) !== false;
                           }));
                          if (!empty($ret)) 
                          {
                              $FilterArr [] = $row;
                          }

                       }
                            echo $this->datatables->getdataFromMongo($arr);
                      }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($arr);
        
    }
    function datatable_vehicleModel() {
        $this->load->library('Datatables');
        $this->load->library('table');
        
             $vehicleModelData = $this->mongo_db->get('VehicleModel');
             
             $slno=0;
             foreach ($vehicleModelData as $each)
             {
                 $vehicleMakeData = $this->mongo_db->get_where('VehicleMake', array('_id' => new MongoDB\BSON\ObjectID($each['Makeid'])));
                    foreach ($vehicleMakeData as $make)
                        $arr[] = array(++$slno,$make['Name'],$each['Name'],'<input type="checkbox" class="checkbox" name="checkbox" value="'.$each['_id']['$oid'].'">');
             }
                     
                    if($this->input->post('sSearch') != '')
                   {

                       $FilterArr = array();
                       foreach ($arr as $row)
                       {
                           $needle = strtoupper($this->input->post('sSearch'));
                           $ret = array_keys(array_filter($row, function($var) use ($needle){
                               return strpos(strtoupper($var), $needle) !== false;
                           }));
                          if (!empty($ret)) 
                          {
                              $FilterArr [] = $row;
                          }

                       }
                            echo $this->datatables->getdataFromMongo($arr);
                      }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($arr);
        
    }
    
    function datatable_drivers($for = '', $status = '') {
         $this->load->library('Datatables');
        $this->load->library('table');
        $company = $this->session->userdata('company_id');
        $city = $this->session->userdata('city_id');
        
        
        
        if ($for == 'my') {
            
            switch ($status)
            {
                case 1:
                        $query = $this->db->query('select * from master where status = '.$status.'')->result();
                        foreach ($query as $driver)
                            $arr[] = array($driver->mas_id,$driver->first_name.' '.$driver->last_name,$driver->mobile,$driver->email,'',date('d-m-Y H:i:s',  strtotime($driver->created_dt)),$driver->companyName,'<img src="'.$driver->profile_pic.'" width="50px" height="50px" class="imageborder" onerror="this.src=\'' . base_url() . '../../pics/user.jpg\'">','<img src="" width="50px" height="50px" class="imageborder" onerror="this.src=\'' . base_url() . '../../pics/cross.png\'">','','<input type="checkbox" class="checkbox" name="checkbox" value="'.$driver->mas_id.'"/>');
                        break;
                case 3:
                        $query = $this->db->query('select * from master where status = '.$status.'')->result();
                        foreach ($query as $driver)
                            $arr[] = array($driver->mas_id,$driver->first_name.' '.$driver->last_name,$driver->mobile,$driver->email,'',date('d-m-Y H:i:s',  strtotime($driver->created_dt)),$driver->companyName,'<img src="'.$driver->profile_pic.'" width="50px" height="50px" class="imageborder" onerror="this.src=\'' . base_url() . '../../pics/user.jpg\'">','<img src="" width="50px" height="50px" class="imageborder" onerror="this.src=\'' . base_url() . '../../pics/cross.png\'">','','<input type="checkbox" class="checkbox" name="checkbox" value="'.$driver->mas_id.'"/>');
                        break;
            }
            
            
        }
    
     if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($arr as $row)
            {
                $needle = $this->input->post('sSearch');
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos($var, $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($arr);
    }

    function datatable_drivers1($for = '', $status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $company = $this->session->userdata('company_id');
        $city = $this->session->userdata('city_id');
        
        if ($for == 'my') {
            $query = $this->db->query('select * from master where status = 3')->result();
            
            
            foreach ($query as $driver)
            {
                $arr[] = array($driver->mas_id,$driver->first_name.' '.$driver->last_name,$driver->mobile,$driver->email,'',date('d-m-Y H:i:s',  strtotime($driver->created_dt)),$driver->companyName,'<img src="'.$driver->profile_pic.'" width="50px" height="50px" class="imageborder" onerror="this.src=\'' . base_url() . '../../pics/user.jpg\'">','','','<input type="checkbox" class="checkbox" name="checkbox" value="'.$driver->mas_id.'"/>');
            }
//            if($city != '0' && $company == '0'){
//                
//                 $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
//                    foreach ($query as $row)
//                         $comp_ids_arr[] = $row->company_id;
//                    
//                    if(!empty($comp_ids_arr) ){
//                        $comp_ids = implode(',',$comp_ids_arr);
//                        $whererc = "mas.status IN ('" . $status . "') and mas.company_id IN (" . rtrim($comp_ids,',') . ") ";
//                    }else{
//                        $whererc = "mas.status IN ('" . $status . "') and mas.company_id = 5000050005 ";
//                    } 
//                    
//            }
//           else  if ($company != '0') {
//                $whererc = "mas.status IN ('" . $status . "') and mas.company_id = '" . $company . "' ";
//            } else {
//
//                $whererc = "mas.status IN ('" . $status . "')";
//            }
            if ($status == 1) {

                $this->datatables->select("mas.mas_id as rahul,CONCAT(mas.first_name,' ',mas.last_name),mas.mobile, mas.email,mas.company_id as vehicleID,"
                                . "DATE_FORMAT(mas.created_dt,'%d-%b-%Y %h:%i %p'),mas.profile_pic as pp,"
                                . "mas.companyName,"
                                . "mas.companyName as r,"
                                . "mas.company_id", false)
            
//                        ->unset_column('type_img')
                        ->unset_column('pp')
                        ->add_column('PROFILE PIC', '<img src="$1" width="50px" height="50px" class="imageborder" onerror="this.src=\'' . base_url() . '../../pics/user.jpg\'">', 'pp')
//                        ->add_column('DEVICE TYPE', '<img src="' . base_url() . '../../admin/assets/$1" width="30px" onerror="this.src=\'' . base_url() . '../../admin/assets/cross.png\'">', 'type_img')
                  
//                        ->add_column('LATITUDE', "get_lat/$1", 'rahul')
                        ->add_column('SELECT', '<input type="checkbox" class="checkbox" name="checkbox" value="$1"/>', 'rahul')
                        ->from("master mas")
                        ->where("mas.status IN ('" . $status . "')");
            } else if ($status == 3 || $status == 4) {
                $this->datatables->select("mas.mas_id as rahul,CONCAT(mas.first_name,' ',mas.last_name),mas.mobile, mas.email,"
                                . "(select uniq_identity from workplace where mas.mas_id = mas_id limit 1),"
                                . "DATE_FORMAT(mas.created_dt,'%d-%b-%Y %h:%i %p'),mas.profile_pic as pp,"
//                               . "round(COALESCE((select avg(star_rating) from master_ratings where mas_id = mas.mas_id),0),1),"
                                    . "(select companyname from company_info where company_id = mas.company_id ) as companyname1,"
                                . "(select (case type when 2 then 'android_new.png' when 1 then 'apple_new.png' END) from user_sessions where oid = mas.mas_id and user_type = 1  order by sid DESC limit 1) as type_img", false)
                      
                        ->unset_column('type_img')
                        ->unset_column('pp')
                        ->add_column('PROFILE PIC', '<img src="$1" width="50px" height="50px" class="imageborder" onerror="this.src=\'' . base_url() . '../../pics/user.jpg\'">', 'pp')
                        
                        ->add_column('DEVICE TYPE','getMasterDeviceInfo/$1', 'rahul')
                       
                        ->add_column('LATITUDE', "get_lat/$1", 'rahul')
                        ->add_column('SELECT', '<input type="checkbox" class="checkbox" name="checkbox" value="$1"/>', 'rahul')
                        ->from("master mas")
                        ->where($whererc);
            }
        } else if ($for == 'mo') {
            $this->load->library('mongo_db');

            $db = $this->mongo_db->db;

            $selecttb = $db->selectCollection('location');

            $darray = $latlong = array();
            if ($status == 3) { //online or free
                $drivers = $selecttb->find(array('$or'=>array(array('status' =>(int)$status,'apptStatus'=>array('$exists'=>FALSE)),array('status' =>(int)$status,'apptStatus'=>0))));

                foreach ($drivers as $mas_id) {
                    $darray[] = $mas_id['user'];
                    $latlong[$mas_id['user']] = array($mas_id['location']['latitude'], $mas_id['location']['longitude']);
                }
            } elseif ($status == 567) {//booked
                $drivers = $selecttb->find(array('apptStatus' => array('$in' => array(5,6,7,8))));
                foreach ($drivers as $mas_id) {
                    $darray[] = $mas_id['user'];

                    $latlong[$mas_id['user']] = array($mas_id['location']['latitude'], $mas_id['location']['longitude']);
                }
            } elseif ($status == 30) {//OFFLINE
                $drivers = $selecttb->find(array('$or'=>array(array('status' =>4,'apptStatus'=>array('$exists'=>FALSE)),array('status' =>4,'apptStatus'=>0))));
                foreach ($drivers as $mas_id) {
                    $darray[] = $mas_id['user'];
                    $latlong[$mas_id['user']] = array($mas_id['location']['latitude'], $mas_id['location']['longitude']);
                }
            }

            $mas_ids = implode(',', array_filter(array_unique($darray)));
            if ($mas_ids == '')
                $mas_ids = 0;
            $companywhere = '';
            if ($company != '0') {
                $companywhere = "and mas.company_id=" . $company;
            }
           else
            {
                
                  $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
                    foreach ($query as $row)
                         $comp_ids_arr[] = $row->company_id;
                    
                    if(!empty($comp_ids_arr) ){
                        $comp_ids = implode(',',$comp_ids_arr);
                        $companywhere = "and mas.company_id IN (" . rtrim($comp_ids,',') . ") ";
                    }else if($city != '0'){
                        $companywhere = "and mas.company_id = 0";
                    } 
                    else
                        $companywhere = '';
            }
//            
            $this->datatables->select("mas.mas_id as rahul,CONCAT(mas.first_name,' ',mas.last_name),mas.mobile, mas.email,"
                            . "(select uniq_identity from workplace where mas.mas_id = mas_id limit 1),"
                            . "DATE_FORMAT(mas.created_dt,'%d-%b-%Y %h:%i %p'),mas.profile_pic as pp,"
//                           . "round(COALESCE((select avg(star_rating) from master_ratings where mas_id = mas.mas_id),0),1)," 
                           . "(select companyname from company_info where company_id = mas.company_id),"
                            . "(select (case type when 2 then 'android_new.png' when 1 then 'apple_new.png'  END) from user_sessions where oid = mas.mas_id  and user_type = 1 order by sid DESC limit 1) as type_img", false)

                    ->unset_column('type_img')
                    ->unset_column('pp')
                    ->add_column('PROFILE PIC', '<img src="$1" width="50px" height="50px" class="imageborder" onerror="this.src=\'' . base_url() . '../../pics/user.jpg\'">', 'pp')

                    ->add_column('DEVICE TYPE', 'getMasterDeviceInfo/$1', 'rahul')
                    ->add_column('LATLONG', "get_lat/$1", 'rahul')
                    ->add_column('SELECT', '<input type="checkbox" class="checkbox" name="checkbox" value="$1"/>', 'rahul')
                    ->from("master mas")
                    ->where("mas.mas_id in (" . $mas_ids . ")" . $companywhere);


        }



        $this->db->order_by("mas.mas_id", "desc");
        echo $this->datatables->generate();
    }

    function uniq_val_chk() {

        $query = $this->db->query('select * from workplace where uniq_identity = "' . $this->input->post('uniq_id') . '"');
        if ($query->num_rows() > 0) {

            echo json_encode(array('msg' => "This vehicleId Is Already Allocated", 'flag' => '1'));
        } else {
            echo json_encode(array('msg' => "", 'flag' => '0'));
        }
        return;
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

    function datatable_bookings($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $this->datatables->select("a.appointment_id,m.mas_id,m.first_name,s.first_name,a.address_line1,a.drop_addr1,a.appointment_dt,a.distance_in_mts")->from("appointment a,master m,slave s")->where("a.slave_id = s.slave_id and a.mas_id = m.mas_id"); //order by slave_id DESC ",false);

        echo $this->datatables->generate();
    }

    function datatable_dispatcher($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');


        $city = $this->session->userdata('city_id');

        $cityCond = "";

        if ($city != 0) {
            $cityCond = ' and city = "' . $city . '"';
        } else {
            
        }

        $this->datatables->select('dis_id,(select City_Name from city where City_Id = city),dis_email,dis_name')
                ->add_column('select', '<input type="checkbox" class="checkbox" name="checkbox" value="$1"/>', 'dis_id')
                ->from('dispatcher')
                ->where('status = "' . $status . '"' . $cityCond); //order by slave_id DESC ",false);

        echo $this->datatables->generate();
    }

    function datatable_document($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $company = $this->session->userdata('company_id');

        if ($status == '1') {

            $this->datatables->select("d.doc_ids,c.first_name,c.last_name,d.expirydate,d.url")
                    ->unset_column('d.url')
                    ->add_column('VIEW', '<button type="button" name="view"  width="50px">'
                            . '<a target="_blank" href="' . base_url() . ServiceLink . '/$1">view</a><a target="_blank" href="' . base_url() . ServiceLink . '/$1"></button><button type="button" name="view"  width="50px">download</button></a>', 'd.url'
                    )
                    ->from("master c,docdetail d")
                    ->where("c.mas_id = d.driverid and d.doctype=1" . ($company != 0 ? ' and c.company_id = "' . $company . '"' : '')); //order by slave_id DESC ",false);
        } else if ($status == '2') {

            $this->datatables->select("d.doc_ids,c.first_name,c.last_name,d.expirydate,d.url")
                    ->unset_column('d.url')
                    ->add_column('VIEW', '<a target="_blank" href="' . base_url() . ServiceLink . '/$1"><button type="button" name="view"  width="50px">view</button></a><a target="_blank" href="' . base_url() . ServiceLink . '/$1"><button type="button" name="view"  width="50px">download</button></a>', 'd.url'
                    )
                    ->from("master c,docdetail d")->where("c.mas_id = d.driverid and d.doctype=2" . ($company != 0 ? ' and c.company_id = "' . $company . '"' : '')); //order by slave_id DESC ",false);
        } else if ($status == '3') {


            $this->datatables->select("d.docid,d.vechileid,(select companyname from company_info where company_id = w.company) as companyname,d.expirydate,d.url")
                    ->unset_column('d.url')
                    ->add_column('VIEW', '<button type="button" name="view"  width="50px"><a target="_blank" href="' . base_url() . ServiceLink . '/$1">view</button></a><a target="_blank" href="' . base_url() . ServiceLink . '/$1"><button type="button" name="view"  width="50px">download</button></a>', 'd.url'
                    )
//                     ->select("(select companyname from company_info where company_id = w.company) as companyname",false)
                    ->from("workplace w,vechiledoc d,vehicleType v")
                    ->where("w.title = v.id and w.workplace_id = d.vechileid and d.doctype = 2" . ($company != 0 ? ' and w.company = "' . $company . '"' : '')); //order by slave_id DESC ",false);
        } else if ($status == '4') {

            $this->datatables->select("d.docid,d.vechileid,(select companyname from company_info where company_id = w.company) as companyname,d.url,d.expirydate")
                    ->unset_column('d.url')
                    ->add_column('VIEW', '<a target="_blank" href="' . base_url() . ServiceLink . '/$1"><button type="button" name="view"  width="50px">view</button></a><a target="_blank" href="' . base_url() . ServiceLink . '/$1"><button type="button" name="view"  width="50px">download</button></a>', 'd.url'
                    )
//                     ->select("(select companyname from company_info where company_id = w.company) as companyname",false)
                    ->from("workplace w,vechiledoc d,vehicleType v")
                    ->where("w.title = v.id and w.workplace_id = d.vechileid and d.doctype = 3" . ($company != 0 ? ' and w.company = "' . $company . '"' : '')); //order by slave_id DESC ",false);
        } else if ($status == '5') {

            $this->datatables->select("d.docid,d.vechileid,(select companyname from company_info where company_id = w.company) as companyname,d.url,d.expirydate")
                    ->select("(select companyname from company_info where company_id = w.company) as companyname", false)
                    ->unset_column('d.url')
                    ->add_column('VIEW', '<a target="_blank" href="' . base_url() . ServiceLink . '/$1"><button type="button" name="view"  width="50px">view</button></a><a target="_blank" target="_blank" href="' . base_url() . ServiceLink . '/$1"><button type="button" name="view"  width="50px">download</button></a>', 'd.url'
                    )
                    ->from("workplace w,vechiledoc d,vehicleType v")
                    ->where("w.title = v.id and w.workplace_id = d.vechileid and d.doctype = 1" . ($company != 0 ? ' and w.company = "' . $company . '"' : '')); //order by slave_id DESC ",false);
        }

        echo $this->datatables->generate();
    }

    function datatable_driverreview($status = '') {


        $this->load->library('Datatables');
        $this->load->library('table');

        $this->datatables->select("r.appointment_id,a.appointment_dt, d.first_name,r.slave_id,r.review, r.star_rating")
//                ->unset_column('$i')
//                ->add_column('sl.no','value="$1"', '$i++')
//                ->unset_column('r.appointment_id')
                ->add_column('select', '<input type="checkbox" class="checkbox" name="checkbox" value="$1"/>', 'r.appointment_id')
                ->from("master_ratings r, master d, slave p,appointment a", false)
                ->where("r.slave_id = p.slave_id  AND r.mas_id = d.mas_id  AND r.status ='" . $status . "'AND r.review<>'' AND a.appointment_id = r.appointment_id"); //order by slave_id DESC ",false);
// ->where("r.slave_id = p.slave_id  AND r.mas_id = d.mas_id  AND r.status ='" . $status . "' AND a.appointment_id = r.appointment_id"); //order by slave_id DESC ",false);
        $this->db->order_by("r.appointment_id", "desc");
        echo $this->datatables->generate();
    }

    function editdispatchers_city() {
        $val = $this->input->post('val');

        $var = $this->db->query("select city from dispatcher where dis_id='" . $val . "'")->result();
        return $var;
    }

    function datatable_passengerrating() {

        $this->load->library('Datatables');
        $this->load->library('table');
        $status = 1;
        $this->datatables->select('p.slave_id, p.first_name ,p.email,IFNULL((select round(avg(rating),1)  from passenger_rating where p.slave_id =slave_id), 0) as rating', false)
                ->from('slave p'); //->where('r.status =" ' . $status . '"'); //order by slave_id DESC ",false);
        $this->db->order_by("p.slave_id", "desc");
        echo $this->datatables->generate();
    }

    function datatable_compaigns($status) {

        $this->load->library('Datatables');
        $this->load->library('table');
        if ($status == 1) {
            $this->datatables->select("cp.id,cp.discount,cp.referral_discount,cp.message,c.city_name")
                    ->unset_column('cp.id')
                    ->add_column('select', '<input type="checkbox" class="checkbox" name="checkbox" value="$1"/>', ' cp.id')
                    ->from(" coupons cp, city c")
                    ->where('cp.city_id = c.city_id and cp.coupon_type = " ' . $status . ' " and cp.status = "0" and user_type = 2'); //order by slave_id DESC ",false);
        } elseif ($status == 2) {

            $this->datatables->select("cp.id,cp.coupon_code,cp.start_date,cp.expiry_date, cp.discount,cp.message,c.city_name")
                    ->unset_column('cp.id')
                    ->add_column('select', '<input type="checkbox" class="checkbox" name="checkbox" value="$1"/>', ' cp.id')
                    ->from(" coupons cp, city c")
                    ->where('cp.city_id = c.city_id and cp.coupon_type = " ' . $status . ' " and cp.status = "0" and user_type = 2'); //order by slave_id DESC ",false);
        } else if ($status == 3) {
            $this->datatables->select("cp.id,cp.coupon_code,cp.start_date,cp.expiry_date, cp.discount,cp.message,c.city_name")
                    ->unset_column('cp.id')
                    ->add_column('select', '<input type="checkbox" class="checkbox" name="checkbox" value="$1"/>', ' cp.id')
                    ->from(" coupons cp, city c")
                    ->where('cp.city_id = c.city_id and cp.coupon_type = " ' . $status . ' " and cp.status = "0" and user_type = 2'); //order by slave_id DESC ",false);
        }
        echo $this->datatables->generate();
    }

    function editNewVehicleData() {

        $accountType = $this->input->post('OwnershipType');
        $goodType = $this->input->post('goodType');
        
        $selected_driver = $this->input->post('selected_driver');
        $mobile = $this->input->post('selected_driver_mobile');
        
        $vehicle_id = $this->input->post('vehicle_id');
        $title = $this->input->post('title');
        $vehiclemodel = $this->input->post('vehiclemodel');
        $vechileregno = $this->input->post('vechileregno');
        $licenceplaetno = $this->input->post('licenceplaetno');
        $vechilecolor = $this->input->post('vechilecolor');
        $type_id = $this->input->post('getvechiletype');
        $expirationrc = $this->input->post('expirationrc');
        $expirationinsurance = $this->input->post('expirationinsurance');
        $expirationpermit = $this->input->post('expirationpermit');
        $companyid = $this->input->post('company_id'); //$this->session->userdata('LoginId');
        
        if($companyid == '')
            $companyid = '0';

        $insuranceno = $this->input->post('Vehicle_Insurance_No'); //$_REQUEST['Vehicle_Insurance_No'];
//        $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/roadyo_live/pics/';


        $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/pics/';


        if ($_FILES["certificate"]["name"] != '' && $_FILES["certificate"]["size"] > 0) {
            $name = $_FILES["certificate"]["name"];
            $ext = substr($name, strrpos($name, '.') + 1); //explode(".", $name); # extra () to prevent notice
            $cert_name = (rand(1000, 9999) * time()) . '.' . $ext;
            move_uploaded_file($_FILES['certificate']['tmp_name'], $documentfolder . $cert_name);
            $this->db->query("update vechiledoc set expirydate = '" . $expirationrc . "', url = '" . $cert_name . "' where doctype = 1 and vechileid = '" . $vehicle_id . "'");
        } else {
            $this->db->query("update vechiledoc set expirydate = '" . $expirationrc . "' where doctype = 1 and vechileid = '" . $vehicle_id . "'");
        }
        if ($_FILES["insurcertificate"]["name"] != '' && $_FILES["insurcertificate"]["size"] > 0) {
            $name = $_FILES["insurcertificate"]["name"];
            $ext = substr($name, strrpos($name, '.') + 1); //explode(".", $name); # extra () to prevent notice
            $cert_name = (rand(1000, 9999) * time()) . '.' . $ext;
            move_uploaded_file($_FILES['insurcertificate']['tmp_name'], $documentfolder . $cert_name);
            $this->db->query("update vechiledoc set expirydate = '" . $expirationinsurance . "', url = '" . $cert_name . "' where doctype = 2 and vechileid = '" . $vehicle_id . "'");
        } else {
            $this->db->query("update vechiledoc set expirydate = '" . $expirationinsurance . "' where doctype = 2 and vechileid = '" . $vehicle_id . "'");
        }
        if ($_FILES["carriagecertificate"]["name"] != '' && $_FILES["carriagecertificate"]["size"] > 0) {
            $name = $_FILES["carriagecertificate"]["name"];
            $ext = substr($name, strrpos($name, '.') + 1); //explode(".", $name); # extra () to prevent notice
            $cert_name = (rand(1000, 9999) * time()) . '.' . $ext;
            move_uploaded_file($_FILES['carriagecertificate']['tmp_name'], $documentfolder . $cert_name);
            $this->db->query("update vechiledoc set expirydate = '" . $expirationpermit . "', url = '" . $cert_name . "' where doctype = 3 and vechileid = '" . $vehicle_id . "'");
        } else {
            $this->db->query("update vechiledoc set expirydate = '" . $expirationpermit . "' where doctype = 3 and vechileid = '" . $vehicle_id . "'");
        }

        if ($_FILES["imagefile"]["name"] != '' && $_FILES["imagefile"]["size"] > 0) {
            $name = $_FILES["imagefile"]["name"];
            $ext = substr($name, strrpos($name, '.') + 1); //explode(".", $name); # extra () to prevent notice
            $cert_name = (rand(1000, 9999) * time()) . '.' . $ext;
            move_uploaded_file($_FILES['imagefile']['tmp_name'], $documentfolder . $cert_name);
            $updateImageString = ", Vehicle_Image = '" . $cert_name . "'";
           
        }
        
    


         $this->load->library('mongo_db');
         
         if($name)
            $fdata = array('goodType'=>$goodType,'account_type'=>(int)$accountType,'company'=>$companyid,'assignedDriver'=>$selected_driver,'mobile'=>$mobile,'make'=>$title,'model'=>$vehiclemodel,'color'=>$vechilecolor,'type_id'=>(int)$type_id,'v_image'=>$cert_name,'reg_number'=>$vechileregno,'licence_numer'=>$licenceplaetno,'insurance_number'=>$insuranceno);
         else
            $fdata = array('goodType'=>$goodType,'account_type'=>(int)$accountType,'company'=>$companyid,'assignedDriver'=>$selected_driver,'mobile'=>$mobile,'make'=>$title,'model'=>$vehiclemodel,'color'=>$vechilecolor,'type_id'=>(int)$type_id,'reg_number'=>$vechileregno,'licence_numer'=>$licenceplaetno,'insurance_number'=>$insuranceno);
        $this->mongo_db->update("vehicles", $fdata, array("workplace_id" =>(int)$vehicle_id));

        $this->db->query("update workplace set goodType='".$goodType."',account_type= ".(int)$accountType.",mas_id = ".(int)$selected_driver.",type_id = " . (int)$type_id . ",Title = '" . $title . "',Vehicle_Model = '" . $vehiclemodel . "',Vehicle_Reg_No = '" . $vechileregno . "', License_Plate_No = '" . $licenceplaetno . "',Vehicle_Color = '" . $vechilecolor . "',company = '" . $companyid . "',Vehicle_Insurance_No = '" . $insuranceno . "'" . $updateImageString . " where workplace_id = " .(int)$vehicle_id . "");

        if ($this->db->affected_rows > 0) {
            return true;
        } else {
            return false;
        }


        return;
    }

    function delete_vehicletype() {
        $val = $this->input->post('val');
        
         foreach ($val as $id)
             $vehicleTypeID[]= (int)$id;
         
          $this->mongo_db->where_in('type',$vehicleTypeID)->delete('vehicleTypes');
       
        echo json_encode(array('msg' => "vehicle type deleted successfully", 'flag' =>0));
        return;
    }

    function delete_company() {
        $query = $this->input->post('val');
        foreach ($query as $id)
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('operators');
       
        echo json_encode(array("msg" => "Your selected company has been deleted successfully", "flag" => 0));
        return;
    }

    function get_documentdata($status) {
        if ($status == 1) {
            $result = $this->db->query("select c.first_name,c.last_name,d.url,d.doc_ids,d.expirydate from master c,docdetail d where c.mas_id=d.driverid and d.doctype=1")->result();
            return $result;
        } else if ($status == 2) {
            $result = $this->db->query("select c.first_name,c.last_name,d.url,d.doc_ids,d.expirydate from master c,docdetail d where c.mas_id=d.driverid and d.doctype=2")->result();
            return $result;
        } else if ($status == 3) {
            $result = $this->db->query("SELECT d.docid,v.vehicletype,d.expirydate,d.vechileid,d.url,w.company,(select companyname from company_info where company_id = w.company) as companyname FROM workplace w,vechiledoc d,vehicleType v where w.title=v.id and w.workplace_id = d.vechileid and d.doctype=2")->result();
            return $result;
        } else if ($status == 4) {
            $result = $this->db->query("SELECT d.docid,v.vehicletype,d.expirydate,d.vechileid,d.url,w.company,(select companyname from company_info where company_id = w.company) as companyname FROM workplace w,vechiledoc d,vehicleType v where w.title=v.id and w.workplace_id = d.vechileid and d.doctype=3")->result();
            return $result;
        } else if ($status == 5) {
            $result = $this->db->query("SELECT d.docid,v.vehicletype,d.expirydate,d.vechileid,d.url,w.company,(select companyname from company_info where company_id = w.company) as companyname FROM workplace w,vechiledoc d,vehicleType v where w.title=v.id and w.workplace_id = d.vechileid and d.doctype=2")->result();
            return $result;
        } else if ($status == 5) {
            $result = $this->db->query("SELECT d.docid,v.vehicletype,d.expirydate,d.vechileid,d.url,w.company,(select companyname from company_info where company_id = w.company) as companyname FROM workplace w,vechiledoc d,vehicleType v where w.title=v.id and w.workplace_id = d.vechileid and d.doctype=2")->result();
            return $result;
        } else if ($status == 6) {
            $result = $this->db->query("SELECT d.url,d.docid,v.vehicletype,d.expirydate,d.vechileid,d.url,w.company,(select companyname from company_info where company_id = w.company) as companyname FROM workplace w,vechiledoc d,vehicleType v where w.title=v.id and w.workplace_id = d.vechileid and d.doctype=2")->result();
            return $result;
        }
    }

    //* naveena models *//







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

    function Drivers($status = '') {

        $quaery = $this->db->query("SELECT mas.mas_id, mas.first_name ,mas.zipcode, mas.profile_pic, mas.last_name, mas.email, mas.mobile, mas.status,mas.created_dt,(select type from user_sessions where oid = mas.mas_id order by oid DESC limit 0,1) as dev_type FROM master mas where  mas.status IN (" . $status . ") and mas.company_id IN (" . $this->session->userdata('LoginId') . ") order by mas.mas_id DESC")->result();
        return $quaery;
    }

    function datatable($status = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

//        $explodeDateTime = explode(' ', date("Y-m-d H:s:i"));
//        $explodeDate = explode('-', $explodeDateTime[0]);
//        $weekData = $this->week_start_end_by_date(date("Y-m-d H:s:i"));
//        $this->datatables->query("select doc.mas_id,doc.first_name,doc.workplace_id, doc.last_name, doc.email, doc.license_num,doc.license_exp,
//                                          doc.board_certification_expiry_dt, doc.mobile, doc.status, doc.profile_pic,
//                                           (select count(appointment_id) from appointment where mas_id = doc.mas_id and status = 9) as cmpltApts,
//                                            (select sum(amount) from appointment where mas_id = doc.mas_id and DATE(appointment_dt) = '" . $explodeDateTime[0] . "' and status = 9) as today_earnings,
//                                             (select amount from appointment where mas_id = doc.mas_id and status = 9 order by appointment_id DESC limit 0, 1) as last_billed_amount,
//                                              (select sum(amount) from appointment where mas_id = doc.mas_id and status = 9 and DATE(appointment_dt) BETWEEN '" . $weekData['first_day_of_week'] . "' and '" . $weekData['last_day_of_week'] . "') as week_earnings,
//                                              (select sum(amount) from appointment where mas_id = doc.mas_id and status = 9 and DATE_FORMAT(appointment_dt, '%Y-%m') = '" . $explodeDate[0] . '-' . $explodeDate[1] . "') as month_earnings,
//                                               (select sum(amount) from appointment where mas_id = doc.mas_id and status = 9) as total_earnings
//                                               from master doc where doc.company_id = '" . $this->session->userdata("LoginId") . "'");
//        $this->datatables->query('select * from city');
//        $this->datatables->select('doc.mas_id,doc.first_name,doc.workplace_id, doc.last_name, doc.email, doc.license_num,doc.license_exp,doc.board_certification_expiry_dt, doc.mobile, doc.status, doc.profile_pic')
//            ->select('(select count(appointment_id) from appointment where mas_id = doc.mas_id and status = 9) as cmpltApts')
//            ->select("(select sum(amount) from appointment where mas_id = doc.mas_id and DATE(appointment_dt) = '" . $explodeDateTime[0] . "' and status = 9) as today_earnings")
//            ->select('(select amount from appointment where mas_id = doc.mas_id and status = 9 order by appointment_id DESC limit 0'.','.'1) as last_billed_amount',false)
//            ->select("(select sum(amount) from appointment where mas_id = doc.mas_id and status = 9 and DATE(appointment_dt) BETWEEN '" . $weekData['first_day_of_week'] . "' and '" . $weekData['last_day_of_week'] . "') as week_earnings")
//            ->select("(select sum(amount) from appointment where mas_id = doc.mas_id and status = 9 and DATE_FORMAT(appointment_dt,  '%Y-%m') = '" . $explodeDate[0] . '-' . $explodeDate[1] . "' ) as month_earnings",false)
//            ->select("(select sum(amount) from appointment where mas_id = doc.mas_id and status = 9) as total_earnings")
//            ->from('master doc');
//        $this->datatables->select('count(appointment_id) as cmpltApts')->from('appointment')->where('mas_id = doc.mas_id and status = 9');
//        $this->datatables->select('sum(amount) as today_earnings')->from('appointment')->where('mas_id = doc.mas_id DATE(appointment_dt) = "' . $explodeDateTime[0] . '"and status = 9');


        $this->datatables->select("*")->from('slave')->where('status', 3); //order by slave_id DESC ",false);

        echo $this->datatables->generate();
    }

    function validateEmail() {

        $query = $this->db->query("select mas_id from master where email='" . $this->input->post('email') . "'");
        if ($query->num_rows() > 0) {
            echo json_encode(array('msg' => '1'));
            return;
        } else {
            echo json_encode(array('msg' => '0'));
        }
    }

    function validatedispatchEmail() {

        $query = $this->db->query("select dis_id from dispatcher where dis_email='" . $this->input->post('email') . "'");
        if ($query->num_rows() > 0) {
            echo json_encode(array('msg' => '1'));
            return;
        } else {
            echo json_encode(array('msg' => '0'));
            return;
        }
    }
    function editpassDispatcher() {
        $pass = $this->input->post('newpass');
        $dis_id = $this->input->post('val');
        $query = $this->db->query("update dispatcher set dis_pass = '".$pass."'  where $dis_id = " .$dis_id. "");
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('flag' => '0','msg'=>'New password has been updated succesfully'));
            return;
        } else {
            echo json_encode(array('flag' => '1','msg'=>'Updation failed'));
            return;
        }
    }

    function get_workplace() {
        $res = $this->db->query("select * from workplace_types")->result();
        return $res;
    }

    function get_cities() {
        $query = $this->db->query('select * from city_available')->result();
        return $query;
    }

    function loadcity() {
        $countryid = $this->input->post('country');
        $Result = $this->db->query("select * from city where Country_Id=" . $countryid . "")->result();
        return $Result;
    }

    function loadcompany() {
        $cityid = $this->input->post('city');
        $Result = $this->db->query("select * from company_info where city=" . $cityid . " and status = 3 ")->result_array();
        return $Result;
    }

    function get_city() {
        return $this->db->query("select ci.*,co.Country_Name from city_available ci,country co where ci.country_id = co.country_id ORDER BY ci.City_Name ASC")->result();
    }

    function get_companyinfo($status) {
        return $this->db->query("select * from company_info where status = '" . $status . "' ")->result();
    }

    function editdriver($status = '') {
//        $driverid = $this->input->post('val');

        $data['masterdata'] = $this->db->query("select * from master where mas_id ='" . $status . "' ")->result();

        $data['masterdoc'] = $this->db->query("select * from docdetail where driverid ='" . $status . "' ")->result();

        return $data;
    }

    function datatable_allDispatchedJobs() {

        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
        
         $city = $this->session->userdata('city_id');

        $comp_ids = array();
         $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
        foreach ($query as $row)
             $comp_ids[] =  (int)$row->company_id;

        $comp_ids = implode(',',$comp_ids);
        
        $mongoData =  $db->selectCollection('ShipmentDetails')->find();

       
        
         if($this->session->userdata('company_id') != '0')
            $query = "ap.mas_id = d.mas_id and ap.slave_id = p.slave_id and d.company_id ='".$this->session->userdata('company_id')."'";
          else if(!empty ($comp_ids))
            $query = "ap.mas_id = d.mas_id and ap.slave_id = p.slave_id and d.company_id in (".$comp_ids.")";
          else if($city == '0')
              $query = "ap.mas_id = d.mas_id and ap.slave_id = p.slave_id"; 
          else
             $query = "ap.mas_id = d.mas_id and ap.slave_id = p.slave_id and d.company_id = '0'";
              
            $mysqlDataApp = $this->db->query("select ap.push_rec_dt,ap.appointment_id,ap.appointment_dt,d.mas_id,d.first_name,p.first_name as slave_name,ap.address_line1,ap.status from appointment ap,master d,slave p where ".$query."")->result();
         
        
            $datatosend1 = array();
         $Apptstatus = array('2'=>'Driver Accepted the Job','3'=>'Driver Rejected the Job','4'=>'Customer Cancelled After Booking',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver Loaded the Vehicle And On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','21'=>'Driver Arried At Drop And Unloaded the Vehicle','22'=>'Completed','0'=>'Appointment Timed Out');
         
          $adminActionStatus = array('1'=>'Force Completed by Admin','2'=>'Force Cancelled by Admin','0'=>'Appointment Timed Out','10'=>'Appointment Timed Out');
       
      
         foreach ($mongoData as $row)
         {

             foreach ($mysqlDataApp as $appnt)
             {
                 if($appnt->appointment_id == $row['order_id'])
                 {
                      
                        if($appnt->status != '10')
                        {
                            foreach ($row['receivers'] as $rec)
                            {
                                if($appnt->status == '8')
                                {
                                       
                                        if($rec['status'] != '21')
                                            $datatosend1[] = array($row['order_id'],$rec['subid'],$appnt->mas_id,$appnt->first_name,$appnt->slave_name,$appnt->address_line1,$rec['address'],$rec['DriverAcceptedTime'],$Apptstatus[$appnt->status]);
                                        else
                                             $datatosend1[] = array($row['order_id'],$rec['subid'],$appnt->mas_id,$appnt->first_name,$appnt->slave_name,$appnt->address_line1,$rec['address'],$rec['DriverAcceptedTime'],$Apptstatus[$rec['status']]);
                              
                                }
                                else
                                {        
                                    $datatosend1[] = array($row['order_id'],$rec['subid'],$appnt->mas_id,$appnt->first_name,$appnt->slave_name,$appnt->address_line1,$rec['address'],$rec['DriverAcceptedTime'],$Apptstatus[$appnt->status]);
                                         
                                }
                            }
                        }
                        else
                        {
                           
                                $datatosend1[] = array($row['order_id'],$rec['subid'],$appnt->mas_id,$appnt->first_name,$appnt->slave_name,$appnt->address_line1,$rec['address'],$rec['DriverAcceptedTime'],$adminActionStatus[$appnt->status]);
                        }              
                 }
             }
             
         }
         
      
     
         for($i = 0;$i< count($datatosend1);$i++)
        {
            for($j = 0;$j< count($datatosend1);$j++)
            {
                if($datatosend1[$i]['0'] > $datatosend1[$j][0])
                {
                    $temp = $datatosend1[$i];
                    $datatosend1[$i] = $datatosend1[$j];
                    $datatosend1[$j] = $temp;                                                        
                }
            }                                        
        }
        
        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($datatosend1 as $row)
            {
                $needle = $this->input->post('sSearch');
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos($var, $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($datatosend1);
       
      
    }
    
    function  getBookingHistory()
    {
        
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
        $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('order_id'=>(int)$this->input->post('order_id')));
        
        $dispatcheStatus = array('0'=>'Declined By Admin','1'=>'Did not respond','2'=>'Declined','3'=>'Accepted');
        
        foreach($mongoData as $row)
                {
                    foreach ($row['dispatched'] as $dispatchedBooking)
                    {
                       if($dispatchedBooking['DriverId'] != $row['driverDetails']['entityId'])
                             $datatosend1[] = array('order_id'=>$row['order_id'],'driver_id'=>$dispatchedBooking['DriverId'],'driverName'=>$dispatchedBooking['fName'],'driverPhone'=>$dispatchedBooking['mobile'],'bookingReceivedTime'=>date('j-M-Y h:i:s',$dispatchedBooking['receiveDt']),'status'=>$dispatcheStatus[$dispatchedBooking['Status']]);

                     }
                        
                }
                
              echo json_encode(array('bookingHistoryData'=>$datatosend1));
              return;
    }
            
    function getbooking_data($status = '', $companyid = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;

        $company_id = $this->session->userdata('company_id');
        $city = $this->session->userdata('city_id');
        
         if($status == '13')
         $mongoData =  $db->selectCollection('ShipmentDetails')->find()->sort(array('order_id'=>-1));
       else
            $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('receivers.status'=>array('$in'=>[$status,(int)$status])))->sort(array('order_id'=>-1));
        
       
         $datatosend1 = array();
         $Apptstatus = array('0'=>'Request','1'=>'Request','2'=>'Driver Accepted the Job','4'=>'Driver Rejected the Job','3'=>'Customer Cancelled',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver Loaded the Vehicle And On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','11'=>'Completed By Admin','12'=>'Cancelled By Admin','21'=>'Driver Arried At Drop And Unloaded the Vehicle','22'=>'Completed');
         
          $dispatchedStatus = array('1'=>'Appointment Timed out','2'=>'Driver Rejected the Job');
     
        $comp_ids = array();
        if($city != '0')
        {
            
            $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
            foreach ($query as $row)
                $comp_ids[] =  (int)$row->company_id;
            
             $comp_ids = implode(',',$comp_ids);
             
             if(empty($comp_ids))
                $comp_ids = 0;
            
            if($company_id != '0')
                $comp_ids = $company_id;
             
             $mysqlDataApp = $this->db->query("select mas_id from master where company_id in (".$comp_ids.")")->result();
             
             foreach ($mysqlDataApp as $sqlData)
              $mas_ids[]=$sqlData->mas_id;
      
          
                foreach ($mongoData as $row)
                {
                    foreach ($row['receivers'] as $receiverData)
                     {
                             if(in_array($row['mas_id'],$mas_ids))
                                 $datatosend1[] = array('<a style="cursor: pointer;" data-toggle="tooltip" title="Booking Sent History" class="bookingHistory" order_id="'.$row['order_id'].'">'.$row['order_id'].'</a>',$row['driverDetails']['firstName'],$row['driverDetails']['mobile'],$row['slaveName'],$row['slavemobile'],$row['extra_notes'],$row['address_line1'],$row['drop_addr1'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),$Apptstatus[$receiverData['status']]);
                             
                     }

                }
            
        }
        else{
                foreach ($mongoData as $row)
                {
                    foreach ($row['receivers'] as $receiverData)
                                 $datatosend1[] = array('<a style="cursor: pointer;" data-toggle="tooltip" title="Booking Sent History" class="bookingHistory" order_id="'.$row['order_id'].'">'.$row['order_id'].'</a>',$row['driverDetails']['firstName'],$row['driverDetails']['mobile'],$row['slaveName'],$row['slavemobile'],$row['extra_notes'],$row['address_line1'],$row['drop_addr1'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),$Apptstatus[$receiverData['status']]);
                }
        }
         
        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($datatosend1 as $row)
            {
                $needle = strtoupper($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(strtoupper($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($datatosend1);
         
    }
    

    public function getDatafromdate_for_all_bookings($stdate = '', $enddate = '', $status = '', $company_id = '') {
  
        $this->load->library('Datatables');
        $this->load->library('table');
        
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;

        $company_id = $this->session->userdata('company_id');
        $city = $this->session->userdata('city_id');
        
        if($status == '13')
         $mongoData =  $db->selectCollection('ShipmentDetails')->find(array("timpeStamp_appointment_date" => array('$gte' =>strtotime($stdate), '$lte' => strtotime($enddate.date('H:i:s')))))->sort(array('order_id'=>-1));
       else
            $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('receivers.status'=>$status,"timpeStamp_appointment_date" =>array('$gte' =>strtotime($stdate.date('H:i:s')), '$lte' => strtotime($enddate))))->sort(array('order_id'=>-1));
        
       
         $datatosend1 = array();
         $Apptstatus = array('0'=>'Request','1'=>'Request','2'=>'Driver Accepted the Job','4'=>'Driver Rejected the Job','3'=>'Customer Cancelled',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver Loaded the Vehicle And On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','11'=>'Completed By Admin','12'=>'Cancelled By Admin','21'=>'Driver Arried At Drop And Unloaded the Vehicle','22'=>'Completed');
         
          $adminActionStatus = array('1'=>'Force Completed by Admin','2'=>'Force Cancelled by Admin');
 
     

        $comp_ids = array();
        if($city != '0')
        {
            
            $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
            foreach ($query as $row)
                $comp_ids[] =  (int)$row->company_id;
            
             $comp_ids = implode(',',$comp_ids);
             
             if(empty($comp_ids))
                $comp_ids = 0;
            
            if($company_id != '0')
                $comp_ids = $company_id;
             
             $mysqlDataApp = $this->db->query("select mas_id from master where company_id in (".$comp_ids.")")->result();
             
             foreach ($mysqlDataApp as $sqlData)
              $mas_ids[]=$sqlData->mas_id;
          
                foreach ($mongoData as $row)
                {
                    foreach ($row['receivers'] as $receiverData)
                     {
                         if($row['driverDetails']['entityId'])
                         {
                             if(in_array($row['mas_id'],$mas_ids))
                                 $datatosend1[] = array('<a style="cursor: pointer;" data-toggle="tooltip" title="Booking Sent History" class="bookingHistory" order_id="'.$row['order_id'].'">'.$row['order_id'].'</a>',$row['driverDetails']['firstName'],$row['driverDetails']['mobile'],$row['slaveName'],$row['slavemobile'],$row['extra_notes'],$row['address_line1'],$row['drop_addr1'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),$Apptstatus[$receiverData['status']]);
                         }

                     }

                }
            
        }
        else{
              foreach ($mongoData as $row)
                {
                    foreach ($row['receivers'] as $receiverData)
                                 $datatosend1[] = array('<a style="cursor: pointer;" data-toggle="tooltip" title="Booking Sent History" class="bookingHistory" order_id="'.$row['order_id'].'">'.$row['order_id'].'</a>',$row['driverDetails']['firstName'],$row['driverDetails']['mobile'],$row['slaveName'],$row['slavemobile'],$row['extra_notes'],$row['address_line1'],$row['drop_addr1'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),$Apptstatus[$receiverData['status']]);
                 }
        }
        
        
        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($datatosend1 as $row)
            {
                $needle = strtoupper($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(strtoupper($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($datatosend1);
    }
    
     function getDueAmount($id) {
   
        $dueAmount = $this->db->query("select TRUNCATE(coalesce((select sum(app_commission) FROM appointment WHERE  mas_id  = ".$id."  AND  STATUS = 9 and payment_type = 2),0) - coalesce((SELECT SUM(pay_amount) FROM payroll WHERE mas_id  = ".$id."),0)- coalesce((select sum(mas_earning) FROM appointment WHERE  mas_id  = ".$id."  AND  STATUS = 9 and payment_type = 1),0),2) as dueAmount from master where mas_id = ".$id."")->row()->dueAmount;
       
        return $dueAmount;
    }
    
       function Driver_pay($masid = '') {

//      $query = "select * from payroll wehre company_id='".$this->session->userdata('LoginId')."'";

        $query = "select COALESCE( TRUNCATE(((SELECT COALESCE(SUM(mas_earning),0) FROM appointment WHERE  m.mas_id  = mas_id  AND  STATUS = 9 and payment_type = 1)) - (SELECT COALESCE(SUM(mas_earning),0) FROM appointment WHERE   m.mas_id  = mas_id and payment_type = 2 and status = 9) - (SELECT COALESCE( SUM(pay_amount) ,0) FROM payroll WHERE m.mas_id  = mas_id ),2),0) as total,m.first_name,"
                . "(select count(settled_flag) from appointment where settled_flag = 0 and mas_id = a.mas_id and mas_earning != 0 and status = 9 and payment_status IN (1,3)) as unsettled_amount_count,"
                . "(select appointment_id from appointment where settled_flag = 0 and mas_id = a.mas_id and status = 9 and payment_status IN (1,3) order by appointment_id DESC limit 0,1) as last_unsettled_appointment_id from appointment a,master m where a.mas_id = '" . $masid . "' and a.mas_id = m.mas_id and settled_flag = 0 and a.status = 9 and a.payment_status in (1,3)";
        return $this->db->query($query)->result();
    }

    function payroll() {

        $explodeDateTime = explode(' ', date("Y-m-d H:s:i"));
        $explodeDate = explode('-', $explodeDateTime[0]);
        $weekData = $this->week_start_end_by_date(date("Y-m-d H:s:i"));

        $this->load->library('Datatables');
        $this->load->library('table');
        $wereclousetocome = ';';
        if ($this->session->userdata('company_id') != '0') {
            $wereclousetocome = "a.mas_id = doc.mas_id and  doc.company_id ='" . $this->session->userdata('company_id') . "'";

            $this->datatables->select('doc.mas_id,doc.first_name,'
                            . "(case  when TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  payment_type = 2 and doc.mas_id  = mas_id and status = 9),2)  IS NULL then '--'  else TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  payment_type = 2 and doc.mas_id  = mas_id and status = 9),2) END) as MAS_CASH_EARNINGS ,"
                     
                            . "(case  when TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  payment_type = 1 and doc.mas_id  = mas_id and status = 9),2)  IS NULL then '--'  else TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  payment_type = 1 and doc.mas_id  = mas_id and status = 9),2) END) as MAS_CARD_EARNINGS ,"
                            . "(case  when TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE   doc.mas_id  = mas_id and status = 9),2)  IS NULL then '--'  else TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE    doc.mas_id  = mas_id and  status = 9),2) END) as DRIVER_EARNINGS ,"
                            . "(case  when TRUNCATE((SELECT (SUM(amount) + SUM(tip_amount)) FROM appointment WHERE   doc.mas_id  = mas_id and payment_type = 2 and status = 9),2)  IS NULL then '--'  else TRUNCATE((SELECT (SUM(amount) + SUM(tip_amount)) FROM appointment WHERE    doc.mas_id  = mas_id and payment_type = 2 and status = 9),2) END) as DRIVER_COLLECTED,"
                            . "TRUNCATE((SELECT COALESCE( SUM(pay_amount) ,0) FROM payroll WHERE doc.mas_id  = mas_id),2) as TOTALRECIVED,"
                             . "TRUNCATE((SELECT COALESCE(round(SUM(app_commission),2),0) FROM appointment WHERE   doc.mas_id  = mas_id and payment_type = 2 and status = 9) - (SELECT COALESCE( round(SUM(pay_amount),2) - ((SELECT COALESCE(round(SUM(mas_earning),2),0) FROM appointment WHERE  doc.mas_id  = mas_id  AND  STATUS = 9 and payment_type = 1)),0) FROM payroll WHERE doc.mas_id  = mas_id ),2) AS due", false)
//                    ->add_column('SHOW', '<a href="' . base_url("index.php/superadmin/DriverDetails/$1") . '"><button class="btn btn-info btn-cons" style="min-width: 83px !important;">DETAILS</button></a>
//            <a href="' . base_url("index.php/superadmin/Driver_pay/$1") . '"><button class="btn btn-success btn-cons" style="min-width: 83px !important;">Pay</button>', 'doc.mas_id ')
                    ->add_column('SHOW',"getPayrollButton/$1",'doc.mas_id ')
                    ->from('master doc', false)
                    ->where($wereclousetocome);
        } else {

            $this->datatables->select('doc.mas_id,doc.first_name,'
                            . "(case  when TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  payment_type = 2 and doc.mas_id  = mas_id and status = 9),2)  IS NULL then '--'  else TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  payment_type = 2 and doc.mas_id  = mas_id and status = 9),2) END) as MAS_CASH_EARNINGS ,"
                           
                            . "(case  when TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  payment_type = 1 and doc.mas_id  = mas_id and status = 9),2)  IS NULL then '--'  else TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  payment_type = 1 and doc.mas_id  = mas_id and status = 9),2) END) as MAS_CARD_EARNINGS ,"
                            . "(case  when TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE   doc.mas_id  = mas_id and status = 9),2)  IS NULL then '--'  else TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE    doc.mas_id  = mas_id and  status = 9),2) END) as DRIVER_EARNINGS ,"
                            . "(case  when TRUNCATE((SELECT (SUM(amount) + SUM(tip_amount)) FROM appointment WHERE   doc.mas_id  = mas_id and payment_type = 2 and status = 9),2)  IS NULL then '--'  else TRUNCATE((SELECT (SUM(amount) + SUM(tip_amount)) FROM appointment WHERE    doc.mas_id  = mas_id and payment_type = 2 and status = 9),2) END) as DRIVER_COLLECTED,"
                            . "TRUNCATE((SELECT COALESCE( SUM(pay_amount) ,0) FROM payroll WHERE doc.mas_id  = mas_id),2) as TOTALRECIVED,"
                             . "TRUNCATE((SELECT COALESCE(round(SUM(app_commission),2),0) FROM appointment WHERE   doc.mas_id  = mas_id and payment_type = 2 and status = 9) - (SELECT COALESCE( round(SUM(pay_amount),2) - ((SELECT COALESCE(round(SUM(mas_earning),2),0) FROM appointment WHERE  doc.mas_id  = mas_id  AND  STATUS = 9 and payment_type = 1)),0) FROM payroll WHERE doc.mas_id  = mas_id ),2) AS due", false)
//                    ->add_column('SHOW', '<a href="' . base_url("index.php/superadmin/DriverDetails/$1") . '"><button class="btn btn-info btn-cons" style="min-width: 83px !important;">DETAILS</button></a>
//            <a href="' . base_url("index.php/superadmin/Driver_pay/$1") . '"><button class="btn btn-success btn-cons" style="min-width: 83px !important;">Pay</button>', 'doc.mas_id ')
                     ->add_column('SHOW',"getPayrollButton/$1",'doc.mas_id ')
                    ->from('master doc', false);
        }
        $this->db->order_by('doc.mas_id', 'DESC');
        echo $this->datatables->generate();
    }

    function getmap_values() {

        $m = new MongoClient();
        $this->load->library('mongo_db');

        $db = $this->mongo_db->db;

        $bookingid = $this->input->post('mapval');


        $data = $this->mongo_db->get_one('booking_route', array('bid' => (int) $bookingid));

        echo json_encode($data["route"]);
    }

    function payroll_data_form_date($stdate = '', $enddate = '', $company_id = '') {

        
        $explodeDateTime = explode(' ', date("Y-m-d H:s:i"));
        $explodeDate = explode('-', $explodeDateTime[0]);
        $weekData = $this->week_start_end_by_date(date("Y-m-d H:s:i"));

        $this->load->library('Datatables');
        $this->load->library('table');

        if ($company_id == '0')
            $query = 'a.mas_id = doc.mas_id and DATE(a.appointment_dt) BETWEEN "' . date('Y-m-d', strtotime($stdate)) . '" AND "' . date('Y-m-d', strtotime($enddate)) . '"';
        else
            $query = 'a.mas_id = doc.mas_id and  DATE(a.appointment_dt) BETWEEN "' . date('Y-m-d', strtotime($stdate)) . '" AND "' . date('Y-m-d', strtotime($enddate)) . '" and doc.company_id ="' . $company_id . '"';

        $this->datatables->select('distinct doc.mas_id as masid,doc.first_name,'
                        . "(case  when TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  payment_type = 2 and masid = mas_id and status = 9),2)  IS NULL then '--'  else TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  payment_type = 2 and masid = mas_id and status = 9),2) END) as MAS_CASH_EARNINGS ,"
                        . "TRUNCATE((SELECT SUM(tip_amount) FROM appointment WHERE  doc.mas_id  = mas_id  AND  STATUS = 9),2) as TIP,"
                        . "(case  when TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  payment_type = 1 and masid = mas_id and status = 9),2)  IS NULL then '--'  else TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  payment_type = 1 and masid = mas_id and status = 9),2) END) as MAS_CARD_EARNINGS ,"
                        . "(case  when TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE   masid = mas_id and status = 9),2)  IS NULL then '--'  else TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE    masid = mas_id and  status = 9),2) END) as DRIVER_EARNINGS ,"
                        . "(case  when TRUNCATE((SELECT SUM(amount) FROM appointment WHERE   masid = mas_id and payment_type = 2 and status = 9),2)  IS NULL then '--'  else TRUNCATE((SELECT SUM(amount) FROM appointment WHERE    masid = mas_id and payment_type = 2 and status = 9),2) END) as DRIVER_COLLECTED,"
                        . "(SELECT COALESCE( SUM(pay_amount) ,0) FROM payroll WHERE masid = mas_id) as TOTALRECIVED,"
                        . "COALESCE( TRUNCATE((SELECT SUM(mas_earning) FROM appointment WHERE  masid = mas_id  AND  STATUS = 9) - (SELECT SUM(amount) FROM appointment WHERE   masid = mas_id and payment_type = 2 and status = 9) - (SELECT COALESCE( SUM(pay_amount) ,0) FROM payroll WHERE masid = mas_id ),2),0) AS due", false)
//                ->add_column('SHOW', '<a href="' . base_url("index.php/superadmin/DriverDetails/$1") . '"><button class="btn btn-success btn-cons" style="min-width: 83px !important;">DETAILS</button></a>
//            <a href="' . base_url("index.php/superadmin/Driver_pay/$1") . '"><button class="btn btn-success btn-cons" style="min-width: 83px !important;">Pay</button>', 'masid')
                 ->add_column('SHOW',"getPayrollButton/$1",'masid')
                ->from(' master doc,appointment a ', false)
                ->where($query);
          echo $this->datatables->generate();
    }

    function AddNewDriverData() {
        
        $datai['account_type'] = (int)$this->input->post('driverType');
        $datai['company_id'] = $this->input->post('company_select');
       
        $operatorName = $this->input->post('operatorName');
        $firstname = $this->input->post('firstname');
        $datai['last_name'] = $this->input->post('lastname');
        $pass = $this->input->post('password');
        $datai['password'] = md5($pass);
        $datai['created_dt'] = $this->input->post('current_dt');
        $datai['type_id'] = (int)1;
        $datai['status'] = (int)1;
        $datai['email'] = $this->input->post('email');
        $datai['date_of_birth'] = date('Y-m-d',  strtotime($this->input->post('dob')));
        $email = $this->input->post('email');
        $datai['mobile'] = $this->input->post('coutry-code').'-'.$this->input->post('mobile');
        $expirationrc = $this->input->post('expirationrc');

        $datai['license_pic'] = $this->input->post('driverLicence');
        $datai['profile_pic'] = $this->input->post('driverImage');
       
       $this->db->query("insert into master(companyName,license_exp,first_name,last_name,email,password,type_id,status,mobile,date_of_birth,created_dt,account_type,company_id,license_pic,profile_pic) values('".$operatorName."','".date("Y-m-d", strtotime($expirationrc))."','".$firstname."','".$datai['last_name']."','".$datai['email']."','".$datai['password']."',1,1,'".$datai['mobile']."','". $datai['date_of_birth']."','". $datai['created_dt'] ."','".(int)$datai['account_type']."','".$datai['company_id']."','".$datai['license_pic']."','".$datai['profile_pic']."')");

       
        $curr_gmt_date =  time();
        $mongoArr = array("type" => 0, "user" => (int) $newdriverid,'companyId'=>$datai['company_id'],'companyName'=>$operatorName,'account_type'=>(int)$this->input->post('driverType'),'zones'=>$this->input->post('checkboxs'),"name" => $datai['first_name'], "lname" => $datai['last_name'],
            "location" => array(
                "longitude" => 0,
                "latitude" => 0
            ), "image" => $this->input->post('driverImage'), "rating" => 0, 'status' => 1, 'email' => strtolower($datai['email']), 'dt' => $curr_gmt_date
        );

        $this->mongo_db->insert('location', $mongoArr);


//        $this->SignupEmail($email, $firstname);

        return true;
    }
    function editdriverdata() {
      
     
      $zonesSelected = array();
       $account_type = $this->input->post('driverType');
//       $account_type = 0;
        $company_id = (int)$this->input->post('company_select');

      if(!empty($this->input->post('checkboxs')))
          $zonesSelected = $this->input->post('checkboxs');

        $driverid = $this->input->post('driver_id');

        $first_name = $this->input->post('firstname');
        $last_name = $this->input->post('lastname');
        $password = $this->input->post('password');
        $created_dt = date('Y-m-d H:i:s', time());
        $type_id = 1;
        
        
        $email = $this->input->post('email');
         $dob = date('Y-m-d',  strtotime($this->input->post('dob')));
        $mobile = $this->input->post('coutry-code').'-'.$this->input->post('mobile');
        $zipcode = $this->input->post('zipcode');
        $expirationrc = $this->input->post('expirationrc');

//
//        $name = $_FILES["certificate"]["name"];
//        $ext = substr($name, strrpos($name, '.') + 1); //explode(".", $name); # extra () to prevent notice //1  doctype
//        $cert_name = (rand(1000, 9999) * time()) . '.' . $ext;
//
//        $insurname = $_FILES["photos"]["name"];
//        $ext1 = substr($insurname, strrpos($insurname, '.') + 1); //explode(".", $insurname);
//        $profilepic = (rand(1000, 9999) * time()) . '.' . $ext1;
//
//        $carriagecert = $_FILES["passbook"]["name"];
//        $ext2 = substr($carriagecert, strrpos($carriagecert, '.') + 1); //explode(".", $carriagecert); 2 doctype
//        $carriage_name = (rand(1000, 9999) * time()) . '.' . $ext2;
//
//
//
//        $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/pics/';
//
//        try {
//            move_uploaded_file($_FILES['certificate']['tmp_name'], $documentfolder . $cert_name);
//            move_uploaded_file($_FILES['photos']['tmp_name'], $documentfolder . $profilepic);
////                $this->uploadimage_diffrent_redulation($documentfolder . $profilepic, $profilepic, $_SERVER['DOCUMENT_ROOT'] . '/', $ext1);
//            
//            move_uploaded_file($_FILES['passbook']['tmp_name'], $documentfolder . $carriage_name);
//        } catch (Exception $ex) {
//            print_r($ex);
//            return false;
//        }
//        
       

        $license_pic =  $this->input->post('driverLicence');;
        $profile_pic = $this->input->post('driverImage');

        if ($profile_pic != '')
            $driverdetails = array('company_id'=>$company_id,'account_type'=>(int)$account_type,'first_name' => $first_name,'date_of_birth'=>$dob, 'last_name' => $last_name, 'profile_pic' => $profile_pic, 'license_pic' => $license_pic,
                'password' => $password, 'created_dt' => $created_dt, 'type_id' => $type_id, 'mobile' => $mobile, 'zipcode' => $zipcode);
        else
            $driverdetails = array('company_id'=>$company_id,'account_type'=>$account_type,'first_name' => $first_name, 'date_of_birth'=>$dob,'last_name' => $last_name, 'license_pic' => $license_pic,
                'password' => $password, 'created_dt' => $created_dt, 'type_id' => $type_id, 'mobile' => $mobile, 'zipcode' => $zipcode);

        $this->db->query("update master set first_name = '".$first_name."',last_name = '".$last_name."',email = '".$email."',password = '".$password."',mobile = '".$mobile."',date_of_birth = '".$dob."',account_type = ".$account_type.",company_id = ".$company_id.",license_pic = '".$license_pic."',profile_pic = '".$profile_pic."' where mas_id = ".(int)$driverid."");
      
//        $this->db->where('mas_id', $driverid);
//        $this->db->update('master', $driverdetails);

        if ($license_pic != '') {
            $data = $this->db->query("select * from docdetail where driverid = '" . $driverid . "' and doctype = 1");


            if ($data->num_rows() > 0) {

                $docdetail = array('url' => $license_pic, 'expirydate' => date("Y-m-d", strtotime($expirationrc)));
                $this->db->where('driverid', $driverid);
                $this->db->where('doctype', 1);
                $this->db->update('docdetail', $docdetail);
            } else {
                $this->db->insert('docdetail', array('doctype' => 1, 'driverid' => $driverid, 'url' => $license_pic, 'expirydate' => date("Y-m-d", strtotime($expirationrc))));
            }
        }

        
        $this->load->library('mongo_db');

        if ($insurname != '')
            $mongoArr = array('account_type'=>(int)$account_type,"name" => $first_name, "lname" => $last_name, "image" => $profile_pic,'zones'=>$zonesSelected);
        else
            $mongoArr = array('account_type'=>(int)$account_type,"name" => $first_name, "lname" => $last_name,'zones'=>$zonesSelected);

        $this->mongo_db->update('location', $mongoArr, array('user' => (int) $driverid));

//        $mail = new sendAMail($db1->host);
//        $err = $mail->sendMasWelcomeMail(strtolower($email), ucwords($firstname));


        return true;
    }



    //Get the all the Dispatched jobs by filter by company
    function filter_AllOnGoing_jobs() {
        
         $this->load->library('Datatables');
        $this->load->library('table');
        
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;

        $company_id = $this->session->userdata('company_id');
        
        $city = $this->session->userdata('city_id');

        $comp_ids = array();
        if($city != '0')
        {
            
            $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
            foreach ($query as $row)
                $comp_ids[] =  (int)$row->company_id;
            
             $comp_ids = implode(',',$comp_ids);
             
             if(empty($comp_ids))
                $comp_ids = 0;
            
            if($company_id != '0')
                $comp_ids = $company_id;
             
             $mysqlDataApp = $this->db->query("select mas_id from master where company_id in (".$comp_ids.")")->result();
             
            
        }
        else{
            $mysqlDataApp = $this->db->query("select mas_id from master")->result();
        }

      
         $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('order_id'=>(int)$this->input->post('app_id')));
        
       
         $datatosend1 = array();
         $Apptstatus = array('0'=>'Status Unavailable','1'=>'Request','2'=>'Driver Accepted the Job','3'=>'Driver Rejected the Job','4'=>'Customer Cancelled After Booking',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver Loaded the Vehicle And On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','21'=>'Driver Arried At Drop And Unloaded the Vehicle','22'=>'Completed');
         
          $adminActionStatus = array('1'=>'Force Completed by Admin','2'=>'Force Cancelled by Admin');
       
          
          foreach ($mysqlDataApp as $sqlData)
              $mas_ids[]=$sqlData->mas_id;
          
           
                foreach ($mongoData as $row)
                {
                        foreach ($row['receivers'] as $rec)
                        {
                            if(rch($row['driverDetails']['entityId'],$mas_ids))
                            $datatosend1[] = array('appointment_id'=>$row['order_id'],'mas_id'=>$row['driverDetails']['entityId'],'first_name'=>$row['driverDetails']['firstName'],'mobile'=>$row['driverDetails']['mobile'],'pessanger_fname'=>$row['slaveName'],'phone'=>$row['slavemobile'],'appointment_dt'=>date('j-M-Y H:i:s',strtotime($row['booking_time'])),'address_line1'=>$row['address_line1'],'drop_addr1'=>$row['drop_addr1'],'status'=>$Apptstatus[$rec['status']]);
                        }

                }  
 
        echo json_encode(array('aaData' => $datatosend1, 'query' => $query_new));
    }
    function shippingData() {
       
        
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;

        $company_id = $this->session->userdata('company_id');
        
        $city = $this->session->userdata('city_id');

        $comp_ids = array();
        if($city != '0')
        {
            
            $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
            foreach ($query as $row)
                $comp_ids[] =  (int)$row->company_id;
            
             $comp_ids = implode(',',$comp_ids);
             
             if(empty($comp_ids))
                $comp_ids = 0;
            
            if($company_id != '0')
                $comp_ids = $company_id;
             
             $mysqlDataApp = $this->db->query("select mas_id from master where company_id in (".$comp_ids.")")->result();
             
            
        }
        else{
            $mysqlDataApp = $this->db->query("select mas_id from master")->result();
        }

      
         $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('receivers.status'=>array('$in'=>array('6','7','8','21'))));
        
       
         $datatosend1 = array();
         $Apptstatus = array('0'=>'Status Unavailable','1'=>'Request','2'=>'Driver Accepted the Job','3'=>'Driver Rejected the Job','4'=>'Customer Cancelled After Booking',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver Loaded the Vehicle And On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','21'=>'Driver Arried At Drop And Unloaded the Vehicle','22'=>'Completed');
         
          $adminActionStatus = array('1'=>'Force Completed by Admin','2'=>'Force Cancelled by Admin');
       
          
          foreach ($mysqlDataApp as $sqlData)
              $mas_ids[]=$sqlData->mas_id;
          
           
                foreach ($mongoData as $row)
                {
                        foreach ($row['receivers'] as $rec)
                        {
                            if(in_array($row['mas_id'],$mas_ids))
                                $datatosend1[] = array('order_id'=>$row['order_id']);
                        }

                }  
 
                return $datatosend1;
    }

    public function testpush() {
         echo 'before';
        $this->db->query("ALTER TABLE city_available ADD COLUMN Status INT DEFAULT 0");
        echo 'done';
        exit();

//        echo '1';
//        $resids = array("4535466yVP5mRysz5hPt7EOvVz45443635462D353542412D344633442D423744382D3132334645433443394644456yVP5mRysz5hPt7EOvVz");
//        $this->load->library('PushNotifications');
//        // $deviceType = "",$usertype = "",$message = ""
//        echo '1';
//        $data = $this->PushNotifications->sendPush($resids, 1, 1, 'hi');
//        var_dump($data);
//        echo '1';
//        exit();
    }
    public function dectivateCity() {
        
         $this->db->query("update city_available set Status = 1 where City_Id =".$this->input->post('cityID')."");
        
         if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "City Deactivated", 'flag' =>0));
            return;
        } else {
                echo json_encode(array('msg' => "Failed to upadte", 'flag' =>1));
                return;
        }

    }
    public function activateCity() {
        
         $this->db->query("update city_available set Status = 0 where City_Id =".$this->input->post('cityID')."");
        
         if ($this->db->affected_rows() > 0) {
            echo json_encode(array('msg' => "City Activated", 'flag' =>0));
            return;
        } else {
                echo json_encode(array('msg' => "Failed to upadte", 'flag' =>1));
                return;
        }

    }

    function datatable_onGoing_jobs() {

        $this->load->library('Datatables');
        $this->load->library('table');

        if ($this->session->userdata('company_id') != '0')
            $query = "ap.mas_id = d.mas_id and ap.slave_id = p.slave_id and ap.status not in (9,10,3,4,5,11,12) and d.company_id ='" . $this->session->userdata('company_id') . "'";
        else
            $query = "ap.mas_id = d.mas_id and ap.slave_id = p.slave_id and ap.status not in (9,10,3,4,5,11,12)";
        $this->datatables->select("ap.appointment_id,ap.mas_id,d.first_name,p.slave_id,p.first_name as sname,ap.address_line1,ap.appointment_dt as rec_time,
               (case ap.status when 1 then 'Request'
     when 2   then
    'Driver accepted.'
     when 3  then
     'Driver rejected.'
     when 4  then
    'Passenger has cancelled.'
     when 5   then
    'Driver has cancelled.'
     when 6   then
    'Driver is on the way.'
     when 7  then
    'Appointment started.'
     when 8   then
    'Driver arrived.'
     when 9   then
    'Appointment completed.'
    when 10 then
    'Appointment timed out.'
    else
    'Status Unavailable.'
    END) as status_result", false)
                ->edit_column('rec_time', 'getRec_time/$1', 'ap.appointment_id')
//                 ->add_column('NO. OF DELIVERIES', "get_deliveriescount/$1",'ap.appointment_id')
//                ->add_column('UPDATE STATUS', '<a href="' . base_url("index.php/superadmin/updateStatus_OnGoing_jobs/1/$1").'"  target=""> <button class="btn btn-success btn-cons" style="width:50px">Complete</button></a> <div style="clear: both; height: 5px;">&nbsp;</div><a href="' . base_url("index.php/superadmin/updateStatus_OnGoing_jobs/2/$1").'" target=""> <button class="btn btn-success btn-cons" style="width:50px">Cancel</button></a>', 'ap.appointment_id', 'ap.appointment_id')
//                            ->add_column('UPDATE', '<a href="" target="_blank"> <button class="btn btn-success btn-cons" style="width:50px">Cancel</button></a>', 'ap.appointment_id')
//                ->add_column('JOB DETAILS', '<a href="' . base_url("index.php/superadmin/showJob_details/$1") . '" target="_blank">Show</a>', 'ap.appointment_id')
                ->from('appointment ap,master d,slave p')
                ->where($query);

        $this->db->order_by('ap.appointment_id', 'DESC');
        echo $this->datatables->generate();
    }

    //Get the all completed jobs by filter by company
    function filter_Allcompleted_jobs() {

        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('mongo_db');


        if ($this->session->userdata('company_id') != '0')
            $query = "ap.mas_id = d.mas_id and ap.slave_id = p.slave_id and ap.status = '9' and d.company_id ='" . $this->session->userdata('company_id') . "'";
        else
            $query = "ap.mas_id = d.mas_id and ap.slave_id = p.slave_id and ap.status = '9'";
        $this->datatables->select("ap.appointment_id,ap.mas_id,d.first_name,p.slave_id,p.first_name as sname,ap.address_line1,ap.appointment_dt as rec_time,
               (case ap.status when 1 then 'Request'
     when 2   then
    'Driver accepted.'
     when 3  then
     'Driver rejected.'
     when 4  then
    'Passenger has cancelled.'
     when 5   then
    'Driver has cancelled.'
     when 6   then
    'Driver is on the way.'
     when 7  then
    'Appointment started.'
     when 8   then
    'Driver arrived.'
     when 9   then
    'Appointment completed.'
    when 10 then
    'Appointment timed out.'
    else
    'Status Unavailable.'
    END) as status_result", false)
                ->edit_column('rec_time', 'getRec_time/$1', 'ap.appointment_id')
//                          ->add_column('NO. OF DELIVERIES', "get_deliveriescount/$1",'ap.appointment_id')
//                ->add_column('UPDATE STATUS', '<a href="" target="_blank"> <button class="btn btn-success btn-cons" style="width:50px">Complete</button></a> <div style="clear: both; height: 5px;">&nbsp;</div><a href="" target="_blank"> <button class="btn btn-success btn-cons" style="width:50px">Cancel</button></a>', 'ap.appointment_id', 'ap.appointment_id')
//                            ->add_column('UPDATE', '<a href="" target="_blank"> <button class="btn btn-success btn-cons" style="width:50px">Cancel</button></a>', 'ap.appointment_id')
                ->add_column('JOB DETAILS', '<a href="' . base_url("index.php/superadmin/tripDetails/$1") . '" target="_blank">Show</a>', 'ap.appointment_id')
                ->from('appointment ap,master d,slave p')
                ->where($query);

        $this->db->order_by('ap.appointment_id', 'DESC');
        echo $this->datatables->generate();
    }

    function datatable_completed_jobs() {

         $this->load->library('Datatables');
        $this->load->library('table');
        
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;

        $company_id = $this->session->userdata('company_id');
        $city = $this->session->userdata('city_id');
        
        $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('receivers.status'=>array('$in'=>['22','11'])))->sort(array('order_id'=>-1));
        
        $datatosend1 = array();
         $Apptstatus = array('0'=>'Status Unavailable','1'=>'Request','2'=>'Driver Accepted the Job','3'=>'Driver Rejected the Job','4'=>'Customer Cancelled After Booking',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver Loaded the Vehicle And On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','11'=>'Completed By Admin','12'=>'Cancelled By Admin','21'=>'Driver Arried At Drop And Unloaded the Vehicle','22'=>'Completed');
         
        $adminActionStatus = array('1'=>'Force Completed by Admin','2'=>'Force Cancelled by Admin');
       

        $comp_ids = array();
        if($city != '0')
        {
            
            $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
            foreach ($query as $row)
                $comp_ids[] =  (int)$row->company_id;
            
             $comp_ids = implode(',',$comp_ids);
             
             if(empty($comp_ids))
                $comp_ids = 0;
            
            if($company_id != '0')
                $comp_ids = $company_id;
             
             $mysqlDataApp = $this->db->query("select mas_id from master where company_id in (".$comp_ids.")")->result();
             
             foreach ($mysqlDataApp as $sqlData)
              $mas_ids[]=$sqlData->mas_id;
           
                foreach ($mongoData as $row)
                {
                       if(in_array($row['mas_id'],$mas_ids))
                            $datatosend1[] = array('<a style="cursor: pointer;" data-toggle="tooltip" title="Booking Sent History" class="bookingHistory" order_id="'.$row['order_id'].'">'.$row['order_id'].'</a>',$row['driverDetails']['entityId'],$row['driverDetails']['firstName'],$row['driverDetails']['mobile'],$row['slaveName'],$row['slavemobile'],$row['address_line1'],$row['drop_addr1'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),'<a href="'.base_url().'index.php/superadmin/tripDetails/'.$row['order_id'].'" target="_blank">View</a>');
                           

                }
            
        }
        else{
                 foreach($mongoData as $row)
                       $datatosend1[] = array('<a style="cursor: pointer;" data-toggle="tooltip" title="Booking Sent History" class="bookingHistory" order_id="'.$row['order_id'].'">'.$row['order_id'].'</a>',$row['driverDetails']['entityId'],$row['driverDetails']['firstName'],$row['driverDetails']['mobile'],$row['slaveName'],$row['slavemobile'],$row['address_line1'],$row['drop_addr1'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),'<a href="'.base_url().'index.php/superadmin/tripDetails/'.$row['order_id'].'" target="_blank">View</a>');
               
        }


        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($datatosend1 as $row)
            {
                $needle = strtoupper($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(strtoupper($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($datatosend1);
     
        
    }

    function documentgetdatavehicles() {
        $val = $this->input->post("val");

        $vehicleImage = array();

        $return = $data = array();
        foreach ($val as $row) {
            $data = $this->db->query("select * from vechiledoc where vechileid = '" . $row . "'")->result();
//            return $data;
        }
        foreach ($data as $vehicle) {


            $return[] = array('doctype' => $vehicle->doctype, 'url' => $vehicle->url, 'expirydate' => $vehicle->expirydate);
        }
        $vehicleImage = $this->db->query("select Vehicle_Image from workplace where workplace_id = '" . $val[0] . "'")->row_array();
        $return[] = array('doctype' => '99', 'url' => $vehicleImage['Vehicle_Image'], 'expirydate' => "");

        return $return;
    }

    function uploadimage_diffrent_redulation($file_to_open, $imagename, $servername, $ext) {


        list($width, $height) = getimagesize($file_to_open);

        $ratio = $height / $width;



        /* mdpi 36*36 */
        $mdpi_nw = 36;
        $mdpi_nh = $ratio * 36;

        $mtmp = imagecreatetruecolor($mdpi_nw, $mdpi_nh);

        if ($ext == "jpg" || $ext == "jpeg") {
            $new_image = imagecreatefromjpeg($file_to_open);
        } else if ($ext == "gif") {
            $new_image = imagecreatefromgif($file_to_open);
        } else if ($ext == "png") {
            $new_image = imagecreatefrompng($file_to_open);
        }
        imagecopyresampled($mtmp, $new_image, 0, 0, 0, 0, $mdpi_nw, $mdpi_nh, $width, $height);

        $mdpi_file = $servername . 'pics/mdpi/' . $imagename;

        imagejpeg($mtmp, $mdpi_file, 100);

        /* HDPI Image creation 55*55 */
        $hdpi_nw = 55;
        $hdpi_nh = $ratio * 55;

        $tmp = imagecreatetruecolor($hdpi_nw, $hdpi_nh);

        if ($ext == "jpg" || $ext == "jpeg") {
            $new_image = imagecreatefromjpeg($file_to_open);
        } else if ($ext == "gif") {
            $new_image = imagecreatefromgif($file_to_open);
        } else if ($ext == "png") {
            $new_image = imagecreatefrompng($file_to_open);
        }
        imagecopyresampled($tmp, $new_image, 0, 0, 0, 0, $hdpi_nw, $hdpi_nh, $width, $height);

        $hdpi_file = $servername . 'pics/hdpi/' . $imagename;

        imagejpeg($tmp, $hdpi_file, 100);

        /* XHDPI 84*84 */
        $xhdpi_nw = 84;
        $xhdpi_nh = $ratio * 84;

        $xtmp = imagecreatetruecolor($xhdpi_nw, $xhdpi_nh);

        if ($ext == "jpg" || $ext == "jpeg") {
            $new_image = imagecreatefromjpeg($file_to_open);
        } else if ($ext == "gif") {
            $new_image = imagecreatefromgif($file_to_open);
        } else if ($ext == "png") {
            $new_image = imagecreatefrompng($file_to_open);
        }
        imagecopyresampled($xtmp, $new_image, 0, 0, 0, 0, $xhdpi_nw, $xhdpi_nh, $width, $height);

        $xhdpi_file = $servername . 'pics/xhdpi/' . $imagename;

        imagejpeg($xtmp, $xhdpi_file, 100);

        /* xXHDPI 125*125 */
        $xxhdpi_nw = 125;
        $xxhdpi_nh = $ratio * 125;

        $xxtmp = imagecreatetruecolor($xxhdpi_nw, $xxhdpi_nh);

        if ($ext == "jpg" || $ext == "jpeg") {
            $new_image = imagecreatefromjpeg($file_to_open);
        } else if ($ext == "gif") {
            $new_image = imagecreatefromgif($file_to_open);
        } else if ($ext == "png") {
            $new_image = imagecreatefrompng($file_to_open);
        }
        imagecopyresampled($xxtmp, $new_image, 0, 0, 0, 0, $xxhdpi_nw, $xxhdpi_nh, $width, $height);

        $xxhdpi_file = $servername . 'pics/xxhdpi/' . $imagename;

        imagejpeg($xxtmp, $xxhdpi_file, 100);
    }

   function AddNewVehicleData() {
        
        $OwnershipType = $this->input->post('OwnershipType');
        
        $goodType = $this->input->post('goodType');
        $selected_driver = $this->input->post('selected_driver');
        $title = $this->input->post('title');
        $vehiclemodel = $this->input->post('vehiclemodel');
        $vechileregno = $this->input->post('vechileregno');
        $licenceplaetno = $this->input->post('licenceplaetno');
        $vechilecolor = $this->input->post('vechilecolor');
        $type_id = $this->input->post('getvechiletype');
        $expirationrc = $this->input->post('expirationrc');

        $expirationinsurance = $this->input->post('expirationinsurance');
        $expirationpermit = $this->input->post('expirationpermit');
        
        $companyname = $this->input->post('company_select');
        
      
        
        if(empty($companyname))
            $companyname = 0;
      
        $vehicleid = $this->input->post('vehicleid'); //$this->session->userdata('LoginId');

        $insuranceno = $_REQUEST['Vehicle_Insurance_No'];


        $name = $_FILES["certificate"]["name"];
        $ext = substr($name, strrpos($name, '.') + 1); //explode(".", $name); # extra () to prevent notice
        $cert_name = (rand(1000, 9999) * time()) . '.' . $ext;

        $insurname = $_FILES["insurcertificate"]["name"];
        $ext1 = substr($insurname, strrpos($insurname, '.') + 1); //explode(".", $insurname);
        $insurance_name = (rand(1000, 9999) * time()) . '.' . $ext1;

        $carriagecert = $_FILES["carriagecertificate"]["name"];
        $ext2 = substr($carriagecert, strrpos($carriagecert, '.') + 1); //explode(".", $carriagecert);
        $carriage_name = (rand(1000, 9999) * time()) . '.' . $ext2;

        $vehicleimage = $_FILES["imagefile"]["name"];
        $text3 = substr($vehicleimage, strrpos($vehicleimage, '.') + 1);
        $image_name = (rand(1000, 999) * time()) . '.' . $text3;



        $documentfolder = $_SERVER['DOCUMENT_ROOT'] . '/pics/';

        try {
            move_uploaded_file($_FILES['certificate']['tmp_name'], $documentfolder . $cert_name);
            move_uploaded_file($_FILES['insurcertificate']['tmp_name'], $documentfolder . $insurance_name);
            move_uploaded_file($_FILES['carriagecertificate']['tmp_name'], $documentfolder . $carriage_name);
            move_uploaded_file($_FILES['imagefile']['tmp_name'], $documentfolder . $image_name);
        } catch (Exception $ex) {
            print_r($ex);
            return false;
        }

        $selectPrefixQry = $this->db->query("select (select LEFT(companyname,2) from company_info where company_id = '" . $companyname . "') as company_prefix,(select LEFT(type_name,2) from workplace_types where type_id = '" . $type_id . "') as type_prefix from dual")->result();

        $vehiclePrefix = strtoupper($selectPrefixQry->company_prefix) . strtoupper($selectPrefixQry->type_prefix);

        $get_last_inserted_id = $this->insertQuery($goodType,$OwnershipType,$selected_driver,$vehiclePrefix, $type_id, $title, $vehiclemodel, $vechileregno, $licenceplaetno, $vechilecolor, $companyname, $insuranceno, $image_name, $vehicleid,$mobile);

       

        $insert_doc = $this->db->query("INSERT INTO `vechiledoc`(`url`, `expirydate`, `doctype`,`vechileid`) VALUES ('" . $insurance_name . "','" . (date("Y-m-d", strtotime($expirationinsurance))) . "','2','" . $get_last_inserted_id . "'),
	('" . $cert_name . "','" . (date("Y-m-d", strtotime($expirationrc))) . "','1','" . $get_last_inserted_id . "'),
	('" . $carriage_name . "','" . (date("Y-m-d", strtotime($expirationpermit))) . "','3','" . $get_last_inserted_id . "')");



        return;
    }

    function insertQuery($goodType,$OwnershipType,$selected_driver,$vehiclePrefix, $type_id, $title, $vehiclemodel, $vechileregno, $licenceplaetno, $vechilecolor, $companyname, $insuranceno, $image_name, $vehicleid,$mobile) {

       
        if ($vehicleid != '') {
            $uniq_id = $vehicleid;
        } else {
            $rand = rand(100000, 999999);
            $uniq_id = $vehiclePrefix . $rand; //str_pad($rand, 6, '0', STR_PAD_LEFT);
        }
 
        
        $this->db->query("insert into workplace(goodType,account_type,mas_id,uniq_identity,type_id,Title,Vehicle_Model,Vehicle_Reg_No, License_Plate_No,Vehicle_Color,company,Status,Vehicle_Insurance_No,Vehicle_Image,driver_phone)  values('".$goodType."',".(int)$OwnershipType.",'".$selected_driver ."','" .$uniq_id. "','" .$type_id . "','" .$title. "','" .$vehiclemodel. "','" .$vechileregno. "','" . $licenceplaetno . "','" . $vechilecolor . "',".(int)$companyname.",'5','" . $insuranceno . "','" . $image_name . "','". $mobile ."')");

         $this->load->library('mongo_db');
        $insertArr = array('goodTypes'=>$goodType,'account_type'=>(int)$OwnershipType,'company'=>$companyname,'assignedDriver' =>$selected_driver, 'mobile' => $mobile, 'make' =>$title, 'model' => $vehiclemodel,'color'=>$vechilecolor, 'type_id' =>(int)$type_id,'workplace_id'=>(int)$this->db->insert_id(),'uniq_identity' => $uniq_id,'v_image'=>$image_name,'reg_number'=>$vechileregno,'licence_numer'=>$licenceplaetno,'insurance_number'=>$insuranceno);
        $this->mongo_db->insert('vehicles', $insertArr);    
        
        if ($this->db->_error_number() == 1586) {
            if ($vehicleid != '') {
                return false;
            }
            return $this->insertQuery($goodType,$OwnershipType,$selected_driver,$uniq_id, $type_id, $title, $vehiclemodel, $vechileregno, $licenceplaetno, $vechilecolor, $companyname, $insuranceno, $vehicleid,$mobile);
        } else {
            return $this->db->insert_id();
        }
    }


     function getTransectionData() {
         $this->load->library('Datatables');
        $this->load->library('table');
        
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;

        $company_id = $this->session->userdata('company_id');
        $city = $this->session->userdata('city_id');
        
        $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('receivers.status'=>array('$in'=>['22','11'])))->sort(array('order_id'=>-1));
        
         $datatosend1 = array();
         $Apptstatus = array('0'=>'Request','1'=>'Request','2'=>'Driver Accepted the Job','3'=>'Driver Rejected the Job','4'=>'Customer Cancelled After Booking',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver Loaded the Vehicle And On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','11'=>'Completed By Admin','12'=>'Cancelled By Admin','21'=>'Driver Arried At Drop And Unloaded the Vehicle','22'=>'Completed');
         
          $paymentType = array('1'=>'Card','2'=>'Cash');
          $deviceType = array('1'=>'<img src="'.base_url().'../../admin/assets/apple_new.png" width="30px">','2'=>'<img src="'.base_url().'../../admin/assets/android_new.png" width="30px">');
   
     

        $comp_ids = array();
        if($city != '0')
        {
            
            $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
            foreach ($query as $row)
                $comp_ids[] =  (int)$row->company_id;
            
             $comp_ids = implode(',',$comp_ids);
             
             if(empty($comp_ids))
                $comp_ids = 0;
            
            if($company_id != '0')
                $comp_ids = $company_id;
             
             $mysqlDataApp = $this->db->query("select mas_id from master where company_id in (".$comp_ids.")")->result();
             
              foreach ($mysqlDataApp as $sqlData)
                $mas_ids[]=$sqlData->mas_id;
              
                foreach ($mongoData as $row)
                {
                    foreach ($row['receivers'] as $receiverData)
                     {
                         if($row['driverDetails']['entityId'])
                         {
                              if(in_array($row['mas_id'],$mas_ids))
                                 $datatosend1[] = array($row['order_id'],$deviceType[$row['driverDetails']['deviceType']],$row['driverDetails']['entityId'],$row['driverDetails']['firstName'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),number_format ($receiverData['Accounting']['amount'],2),number_format ($receiverData['Accounting']['app_commission'],2),number_format ($receiverData['Accounting']['pg_commission'],2),number_format ($receiverData['Accounting']['mas_earning'],2),$paymentType[$row['payment_type']],$Apptstatus[$receiverData['status']],'<a href="'.base_url().'../../invoice.php?Order_id='.$row['order_id'].'" target="_blank">View</a>');
                         }
                     }
                       
                }
             
         }
        else{
            
                foreach ($mongoData as $row)
                {
                    foreach ($row['receivers'] as $receiverData)
                               $datatosend1[] = array($row['order_id'],$deviceType[$row['driverDetails']['deviceType']],$row['driverDetails']['entityId'],$row['driverDetails']['firstName'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),number_format ($receiverData['Accounting']['amount'],2),number_format ($receiverData['Accounting']['app_commission'],2),number_format ($receiverData['Accounting']['pg_commission'],2),number_format ($receiverData['Accounting']['mas_earning'],2),$paymentType[$row['payment_type']],$Apptstatus[$receiverData['status']],'<a href="'.base_url().'../../invoice.php?Order_id='.$row['order_id'].'" target="_blank">View</a>');
                      
                }
        }
        
     
        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($datatosend1 as $row)
            {
                $needle = strtoupper($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(strtoupper($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($datatosend1);
    }

    function transection_data_form_date($stdate = '', $enddate = '', $paymentType = '', $company_id = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;

        $company_id = $this->session->userdata('company_id');
        $city = $this->session->userdata('city_id');
        
        if($paymentType != '0')
            $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('receivers.status'=>array('$in'=>['22','11']),'payment_type'=>$paymentType,"timpeStamp_appointment_date" =>array('$gte' =>strtotime($stdate), '$lte' => strtotime($enddate.date('H:i:s')))))->sort(array('order_id'=>-1));
        else
            $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('receivers.status'=>array('$in'=>['22','11']),"timpeStamp_appointment_date" =>array('$gte' =>strtotime($stdate), '$lte' => strtotime($enddate.date('H:i:s')))))->sort(array('order_id'=>-1));
        
         $datatosend1 = array();
         $Apptstatus = array('0'=>'Request','1'=>'Request','2'=>'Driver Accepted the Job','3'=>'Driver Rejected the Job','4'=>'Customer Cancelled After Booking',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver Loaded the Vehicle And On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','11'=>'Completed By Admin','12'=>'Cancelled By Admin','21'=>'Driver Arried At Drop And Unloaded the Vehicle','22'=>'Completed');
         
          $adminActionStatus = array('1'=>'Force Completed by Admin','2'=>'Force Cancelled by Admin');
          $paymentType = array('1'=>'Card','2'=>'Cash');
           $deviceType = array('1'=>'<img src="'.base_url().'../../admin/assets/apple_new.png" width="30px">','2'=>'<img src="'.base_url().'../../admin/assets/android_new.png" width="30px">');
 
     

        $comp_ids = array();
        if($city != '0')
        {
            
            $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
            foreach ($query as $row)
                $comp_ids[] =  (int)$row->company_id;
            
             $comp_ids = implode(',',$comp_ids);
             
             if(empty($comp_ids))
                $comp_ids = 0;
            
            if($company_id != '0')
                $comp_ids = $company_id;
             
             $mysqlDataApp = $this->db->query("select mas_id from master where company_id in (".$comp_ids.")")->result();
             
             
             foreach ($mysqlDataApp as $sqlData)
                $mas_ids[]=$sqlData->mas_id;
          
                foreach ($mongoData as $row)
                {
                    foreach ($row['receivers'] as $receiverData)
                     {
                         if($row['driverDetails']['entityId'])
                         {
                              if(in_array($row['mas_id'],$mas_ids))
                                 $datatosend1[] = array($row['order_id'],$deviceType[$row['driverDetails']['deviceType']],$row['driverDetails']['entityId'],$row['driverDetails']['firstName'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),number_format ($receiverData['Accounting']['amount'],2),number_format ($receiverData['Accounting']['app_commission'],2),number_format ($receiverData['Accounting']['pg_commission'],2),number_format ($receiverData['Accounting']['mas_earning'],2),$paymentType[$row['payment_type']],$Apptstatus[$receiverData['status']],'<a href="'.base_url().'../../invoice.php?Order_id='.$row['order_id'].'" target="_blank">View</a>');
                         }
                     }
                       
                }
            
        }
        else{
            
                foreach ($mongoData as $row)
                {
                    foreach ($row['receivers'] as $receiverData)
                                 $datatosend1[] = array($row['order_id'],$deviceType[$row['driverDetails']['deviceType']],$row['driverDetails']['entityId'],$row['driverDetails']['firstName'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),number_format ($receiverData['Accounting']['amount'],2),number_format ($receiverData['Accounting']['app_commission'],2),number_format ($receiverData['Accounting']['pg_commission'],2),number_format ($receiverData['Accounting']['mas_earning'],2),$paymentType[$row['payment_type']],$Apptstatus[$receiverData['status']],'<a href="'.base_url().'../../invoice.php?Order_id='.$row['order_id'].'" target="_blank">View</a>');
                        
                 }
        }  
     
        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($datatosend1 as $row)
            {
                $needle = strtoupper($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(strtoupper($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($datatosend1);
    }

    function getDataSelected($selectdval = '') {
         $this->load->library('Datatables');
        $this->load->library('table');
        
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;

        $company_id = $this->session->userdata('company_id');
        $city = $this->session->userdata('city_id');
        
        if($selectdval == '0')
            $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('receivers.status'=>array('$in'=>['22','11'])))->sort(array('order_id'=>-1));
        else
            $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('receivers.status'=>array('$in'=>['22','11']),'payment_type'=>$selectdval))->sort(array('order_id'=>-1));
        
        
       
         $datatosend1 = array();
         $Apptstatus = array('0'=>'Request','1'=>'Request','2'=>'Driver Accepted the Job','3'=>'Driver Rejected the Job','4'=>'Customer Cancelled After Booking',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver Loaded the Vehicle And On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','11'=>'Completed By Admin','12'=>'Cancelled By Admin','21'=>'Driver Arried At Drop And Unloaded the Vehicle','22'=>'Completed');
         
          $adminActionStatus = array('1'=>'Force Completed by Admin','2'=>'Force Cancelled by Admin');
          $paymentType = array('1'=>'Card','2'=>'Cash');
            $deviceType = array('1'=>'<img src="'.base_url().'../../admin/assets/apple_new.png" width="30px">','2'=>'<img src="'.base_url().'../../admin/assets/android_new.png" width="30px">');

     

        $comp_ids = array();
        if($city != '0')
        {
            
            $query = $this->db->query('select * from company_info where Status = 3 and city = "' . $city . '"')->result();
            foreach ($query as $row)
                $comp_ids[] =  (int)$row->company_id;
            
             $comp_ids = implode(',',$comp_ids);
             
             if(empty($comp_ids))
                $comp_ids = 0;
            
            if($company_id != '0')
                $comp_ids = $company_id;
             
             $mysqlDataApp = $this->db->query("select mas_id from master where company_id in (".$comp_ids.")")->result();
             
             foreach ($mysqlDataApp as $sqlData)
              $mas_ids[]=$sqlData->mas_id;
          
                foreach ($mongoData as $row)
                {
                    foreach ($row['receivers'] as $receiverData)
                     {
                         if($row['driverDetails']['entityId'])
                         {
                              if(in_array($row['mas_id'],$mas_ids))
                                 $datatosend1[] = array($row['order_id'],$deviceType[$row['driverDetails']['deviceType']],$row['driverDetails']['entityId'],$row['driverDetails']['firstName'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),number_format ($receiverData['Accounting']['amount'],2),number_format ($receiverData['Accounting']['discount'],2),number_format ($receiverData['Accounting']['app_commission'],2),number_format ($receiverData['Accounting']['pg_commission'],2),number_format ($receiverData['Accounting']['mas_earning'],2),$paymentType[$row['payment_type']],$Apptstatus[$receiverData['status']],'<a href="'.base_url().'../../invoice.php?Order_id='.$row['order_id'].'" target="_blank">View</a>');
                         }
                     }
                       
                }
            
        }
        else{
                foreach ($mongoData as $row)
                {
                    foreach ($row['receivers'] as $receiverData)
                                $datatosend1[] = array($row['order_id'],$deviceType[$row['driverDetails']['deviceType']],$row['driverDetails']['entityId'],$row['driverDetails']['firstName'],date('j-M-Y H:i:s',strtotime($row['booking_time'])),number_format ($receiverData['Accounting']['amount'],2),number_format ($receiverData['Accounting']['discount'],2),number_format ($receiverData['Accounting']['app_commission'],2),number_format ($receiverData['Accounting']['pg_commission'],2),number_format ($receiverData['Accounting']['mas_earning'],2),$paymentType[$row['payment_type']],$Apptstatus[$receiverData['status']],'<a href="'.base_url().'../../invoice.php?Order_id='.$row['order_id'].'" target="_blank">View</a>');
                }
           
        }
        
     
        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($datatosend1 as $row)
            {
                $needle = strtoupper($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(strtoupper($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($datatosend1);
    }
    function passenger_rating() {
        $status = 1;
        $query = $this->db->query(" SELECT p.slave_id, p.first_name ,p.email,(select avg(rating) from passenger_rating where slave_id = p.slave_id) as rating FROM passenger_rating r, slave p WHERE r.slave_id = p.slave_id  AND r.status ='" . $status . "'")->result();
        return $query;
    }

    function driver_review($status) {


        $query = $this->db->query(" SELECT r.review, r.status,r.star_rating, r.review_dt,r.appointment_id, r.mas_id, d.first_name AS mastername, p. slave_id,a.appointment_dt  FROM master_ratings r, master d, slave p,appointment a WHERE r.slave_id = p.slave_id  AND r.mas_id = d.mas_id  AND r.status ='" . $status . "' AND r.review <>'' AND a.appointment_id = r.appointment_id ")->result();
        return $query;
    }

    function DriverDetails($mas_id = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
        $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('receivers.status'=>'22','mas_id'=>(int)$mas_id))->sort(array('order_id'=>-1));
        
        $datatosend1 = array();
        foreach ($mongoData as $row)
        {
            foreach ($row['receivers'] as $receiverData)
                     $datatosend1[] = array($row['order_id'],date('j-M-Y H:i:s',$row['timpeStamp_appointment_date']),$row['slaveName'],number_format ($receiverData['Accounting']['amount'],2),number_format ($receiverData['Accounting']['app_commission'],2),number_format ($receiverData['Accounting']['pg_commission'],2),number_format ($receiverData['Accounting']['mas_earning'],2));
        }    
        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($datatosend1 as $row)
            {
                $needle = strtoupper($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(strtoupper($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($datatosend1);
    }

    function DriverDetails_form_Date($stdate = '', $enddate = '', $company_id = '', $mas_id = '') {

         $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
        $mongoData =  $db->selectCollection('ShipmentDetails')->find(array('receivers.status'=>'22','mas_id'=>(int)$mas_id,'timpeStamp_appointment_date'=>array('$gte'=>  strtotime($stdate),'$lte'=>strtotime($enddate))))->sort(array('order_id'=>-1));
        
        $datatosend1 = array();
        foreach ($mongoData as $row)
        {
            foreach ($row['receivers'] as $receiverData)
                     $datatosend1[] = array($row['order_id'],date('j-M-Y H:i:s',$row['timpeStamp_appointment_date']),$row['slaveName'],number_format ($receiverData['Accounting']['amount'],2),number_format ($receiverData['Accounting']['app_commission'],2),number_format ($receiverData['Accounting']['pg_commission'],2),number_format ($receiverData['Accounting']['mas_earning'],2));
        }    
        if($this->input->post('sSearch') != '')
        {
               
            $FilterArr = array();
            foreach ($datatosend1 as $row)
            {
                $needle = strtoupper($this->input->post('sSearch'));
                $ret = array_keys(array_filter($row, function($var) use ($needle){
                    return strpos(strtoupper($var), $needle) !== false;
                }));
               if (!empty($ret)) 
               {
                   $FilterArr [] = $row;
               }
               
            }
              echo $this->datatables->getdataFromMongo($FilterArr);
        }
       
        if($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($datatosend1);
    }

    function inactivedriver_review() {
        $val = $this->input->post('val');

        foreach ($val as $row) {
            $values = explode(",", $row);
            $query = $this->db->query("update master_ratings set status = 2 where appointment_id= '" . $row . "'");
        }
    }

    function activedriver_review() {
        $val = $this->input->post('val');

        foreach ($val as $row) {
            $values = explode(",", $row);
            $query = $this->db->query("update master_ratings set status=1 where  appointment_id= '" . $row . "'");
        }
    }

    function get_Drivers_from_mongo($status) {

        $m = new MongoClient();
        $this->load->library('mongo_db');

        $db = $this->mongo_db->db;

        $selecttb = $db->location;
        $darray = array();
        if ($status == 3) { //online or free
            $drivers = $selecttb->find(array('status' => (int) $status));

            foreach ($drivers as $mas_id) {
                $darray[] = $mas_id['user'];
            }
        } elseif ($status == 567) {//booked
            $drivers = $selecttb->find(array('status' => array('$in' => array(5, 6, 7))));
            foreach ($drivers as $mas_id) {
                $darray[] = $mas_id['user'];
            }
        } elseif ($status == 30) {//OFFLINE
            $drivers = $selecttb->find(array('status' => (int) 4));
            foreach ($drivers as $mas_id) {
                $darray[] = $mas_id['user'];
            }
        }

        $mas_ids = implode(', ', $darray);

        $quaery = $this->db->query("SELECT mas.mas_id, mas.first_name ,mas.zipcode, mas.profile_pic, mas.last_name, mas.email, mas.mobile, mas.status,mas.created_dt,(select type from user_sessions where oid = mas.mas_id order by oid DESC limit 0,1) as dev_type FROM master mas where  mas.mas_id IN (" . $mas_ids . ")  order by mas.mas_id DESC")->result();
        return $quaery;

//        print_r($mas_ids);
    }

    function getDtiverDetail() {

        $did = $this->input->post("did");

        $queryM = $this->db->query("select * from master where mas_id ='" . $did . "'")->result();
        $queryV = $this->db->query("select w.Title,w.Vehicle_Model,vm.vehiclemodel,vt.vehicletype from master m,vehicleType vt,vehiclemodel vm,workplace w where m.mas_id='" . $did . "' and m.workplace_id=w.workplace_id and w.Title =vt.id and w.Vehicle_Model = vm.id")->result();
        $queryapp = $this->db->query("select appointment_id,appointment_dt,address_line1,drop_addr1 from appointment  where mas_id='" . $did . "' and status  in(1,2,6,7,8)")->result();


        foreach ($queryM as $master) {
            $name = $master->first_name . $master->last_name;
            $mobile = $master->mobile;
            $license = $master->license_num;
            $profile = $master->profile_pic;
        }
        foreach ($queryV as $vehicle) {
            $vtype = $vehicle->vehicletype;
            $vmodel = $vehicle->vehiclemodel;
        }

        if ($profile) {
            $img = ServiceLink . '/pics/' . $profile;
        } else {
            $img = ServiceLink . '/pics/aa_default_profile_pic.gif';
        }
        $html = '<div id="quickview" class="quickview-wrapper open" data-pages="quickview" style="max-height: 487px;margin-top: 39px;">

<ul class="nav nav-tabs" style="padding: 0 14px;">
    <a data-view-animation="push-parrallax" data-view-port="#chat" data-navigate="view" class="" href="#">
                                                                 <span class="col-xs-height col-middle">
                                                                <span class="thumbnail-wrapper d32 circular bg-success">
                                                                    <img width="34" height="34" alt="" data-src-retina="' . $img . '" data-src="' . $img . '" src="' . $img . '" class="col-top">
                                                                </span>
                                                                </span>
        <p class="p-l-20 col-xs-height col-middle col-xs-12">
            <span class="text-master" style="color: #ffffff !important;">' . $name . '</span>
            <span class="block text-master hint-text fs-12" style="color: #ffffff !important;">+91' . $mobile . '</span>
        </p>
    </a>


</ul>
<p class="close_quick"> <a class="btn-link quickview-toggle"><i class="pg-close" style="color: #ffffff ! important;" ></i></a></p>

<div class="tab-content" style="top: 21px !important;">


<div class="list-view-group-container" >

<ul>

<li class="chat-user-list clearfix">
        <div class="form-control">
            <label class="col-sm-5 control-label">Model</label><label class="col-sm-7 control-label">' . $vmodel . '</label>
        </div>

    </li>
    <li class="chat-user-list clearfix">

        <div class="form-control">
            <label class="col-sm-5 control-label">Car Type</label><label class="col-sm-7 control-label">' . $vtype . '</label>
        </div>


    </li>

    <li class="chat-user-list clearfix">

        <div class="form-control">
            <label class="col-sm-5 control-label">License no</label><label class="col-sm-7 control-label">' . $license . '</label>
        </div>

    </li>


</ul>


<div class="list-view-group-container" style="overflow-y: scroll;max-height: 314px;">
<div class="list-view-group-header text-uppercase" style="background-color: #f0f0f0;padding: 10px;">
            ASSIGNED JOBS</div>';
        foreach ($queryapp as $result) {

            $html.='<div style="overflow: auto;background: #fff;">
    <ul style="margin-top: 15px;">

        <li class="chat-user-list clearfix">


            <div class="item share share-self col1" data-social="item" style="border: 2px solid #e5e8e9;">
                <div class="pull-right" style="margin: 5px 5px 0px 11px;width: 157px;">
                ' . date("M d Y g:i A", strtotime($result->appointment_dt)) . '

            </div>
                <div class="item-header clearfix" style="margin: 5px 8px 11px 12px;">

                ' . $result->appointment_id . '

            </div>
                <div class="item-description" style="">

                    <ul>

                        <li class="chat-user-list clearfix">


                             <div class=""  style="border: 1px solid rgba(0, 0, 0, 0.07);">
                             <p style="padding: 8px;">' . $result->address_line1 . '</p>


                            </div>


                        </li>
                        <li class="chat-user-list clearfix">



                        <div class="" style="border: 1px solid rgba(0, 0, 0, 0.07);">
                             <p style="padding: 8px;">' . $result->drop_addr1 . '</p>


                            </div>
                        </li>

                    </ul>
                </div>
            </div>



        </li>


    </ul>

</div>';
        }




        $html.='</div></div></div></div>';


        echo json_encode(array('html' => $html));
    }

    function get_payrolldata($id = '') {
        $quaery = $this->db->query("SELECT * from payroll WHERE  mas_id = '" . $id . "'")->result();
//        $quaery = $this->db->query("SELECT due_amount,closing_balance,pay_date,pay_date,opening_balance,mas_id,trasaction_id,payroll_id,sum(pay_amount) as totalpaid from payroll  WHERE  mas_id = '" . $id . "'")->result();
        return $quaery;
    }
    function Totalamountpaid($id = '') {
        $quaery = $this->db->query("SELECT sum(pay_amount) as totalamt from payroll WHERE  mas_id = '" . $id . "'")->result();
//        $quaery = $this->db->query("SELECT due_amount,closing_balance,pay_date,pay_date,opening_balance,mas_id,trasaction_id,payroll_id,sum(pay_amount) as totalpaid from payroll  WHERE  mas_id = '" . $id . "'")->result();
        return $quaery;
    }

    function get_all_data($stdate, $enddate) {
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;

//        $mysqlDataApp = $this->db->query("select mas_id from master")->result();
       if($stdate || $enddate)
         $mongoData =  $db->selectCollection('ShipmentDetails')->find(array("receivers.status"=>array('$in'=>['22','11']),"timpeStamp_appointment_date" => array('$gte' => strtotime($stdate), '$lte' =>strtotime($enddate))))->sort(array('order_id'=>-1));
       else
            $mongoData =  $db->selectCollection('ShipmentDetails')->find(array("receivers.status"=>array('$in'=>['22','11'])))->sort(array('order_id'=>-1));
        
       
         $datatosend1 = array();
         $Apptstatus = array('0'=>'Request','1'=>'Request','2'=>'Driver Accepted the Job','3'=>'Driver Rejected the Job','4'=>'Customer Cancelled After Booking',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver Loaded the Vehicle And On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','11'=>'Completed By Admin','12'=>'Cancelled By Admin','21'=>'Driver Arried At Drop And Unloaded the Vehicle','22'=>'Completed');
         
          $adminActionStatus = array('1'=>'Force Completed by Admin','2'=>'Force Cancelled by Admin');
          $deviceType = array('1'=>'Apple','2'=>'Andriod');
          $paymentType = array('1'=>'Card','2'=>'Cash');
       
          
          foreach ($mysqlDataApp as $sqlData)
              $mas_ids[]=$sqlData->mas_id;
          
               foreach ($mongoData as $row)
                {
                    foreach ($row['receivers'] as $receiverData)
                     {
//                         if($row['driverDetails']['entityId'])
//                         {
//                             if(in_array($row['mas_id'],$mas_ids))
                                 $datatosend1[] = array('Order Id'=>$row['order_id'],'Device Type'=>$deviceType[$row['driverDetails']['deviceType']],'Driver Id'=>$row['driverDetails']['entityId'],'Driver Name'=>$row['driverDetails']['firstName'],'Driver Email'=>$row['driverDetails']['email'],'Driver Phone'=>$row['driverDetails']['mobile'],'Customer Name'=>$row['slaveName'],'Customer Email'=>$row['slaveEmail'],'Customer Phone'=>$row['slavemobile'],'Receiver Name'=>$receiverData['name'],'Receiver Email'=>$receiverData['email'],'Receiver Phone'=>$receiverData['mobile'],'Vehicle Type'=>$row['vehicleType']['type_name'],'Pickup Date & Time'=>date('j-M-Y H:i:s',strtotime($row['DriverArrivedTime'])),'Drop Date & Time'=>date('j-M-Y H:i:s',strtotime($receiverData['DriverDropedTime'])),'Pickup'=>$row['address_line1'],'Drop At'=>$row['drop_addr1'],'Billed Amount'=>number_format($receiverData['Accounting']['amount'],2),'App Commission'=>number_format($receiverData['Accounting']['app_commission'],2),'PG Commission'=>number_format ($receiverData['Accounting']['pg_commission'],2),'Driver Earnings'=>number_format ($receiverData['Accounting']['mas_earning'],2),'Payment Type'=>$paymentType[$row['payment_type']],'Status'=>$Apptstatus[$receiverData['status']]);
//                         }
                     }
                       
                }
                
        return $datatosend1;
    }
    function allBookingsDataExport($stdate, $enddate) {
        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;

//        $mysqlDataApp = $this->db->query("select mas_id from master")->result();
       if($stdate || $enddate)
         $mongoData =  $db->selectCollection('ShipmentDetails')->find(array("timpeStamp_appointment_date" => array('$gte' => strtotime($stdate), '$lte' =>strtotime($enddate))))->sort(array('order_id'=>-1));
       else
            $mongoData =  $db->selectCollection('ShipmentDetails')->find()->sort(array('order_id'=>-1));
        
       
         $datatosend1 = array();
         $Apptstatus = array('0'=>'Request','1'=>'Request','2'=>'Driver Accepted the Job','3'=>'Driver Rejected the Job','4'=>'Customer Cancelled After Booking',
             '5'=>'Driver Cancelled After Booking','6'=>'Driver On the Way','7'=>'Driver Arrived At Pickup Point',
             '8'=>'Driver Loaded the Vehicle And On the Way to Drop','9'=>'Completed','10'=>'Appointment Timed Out','11'=>'Completed By Admin','12'=>'Cancelled By Admin','21'=>'Driver Arried At Drop And Unloaded the Vehicle','22'=>'Completed');
         
          $adminActionStatus = array('1'=>'Force Completed by Admin','2'=>'Force Cancelled by Admin');
          $deviceType = array('1'=>'Apple','2'=>'Andriod');
          $paymentType = array('1'=>'Card','2'=>'Cash');
       
          $sl =0;
          $statusArr = array('6','7','8','22');
               foreach ($mongoData as $row)
                {
                   $pickupDate = '';
                   $dropDate = '';
                    if($row['pickupzoneId'] != '')
                        $pickupZone =  $db->selectCollection('zones')->findOne(array("_id" =>new MongoId($row['pickupzoneId'])));

                    if($row['dorpzoneId'] != '')
                        $dropZone =  $db->selectCollection('zones')->findOne(array("_id" =>new MongoId($row['dorpzoneId'])));
//                  
                   
                    foreach ($row['receivers'] as $receiverData)
                     {
                        if(in_array($receiverData['status'],$statusArr))
                        {
                            $pickupDate=date('j-M-Y H:i:s',strtotime($receiverData['DriverArrivedTime']));
                        }
                        if($receiverData['status'] == '22')
                             $dropDate=date('j-M-Y H:i:s',strtotime($receiverData['DriverDropedTime']));
                            
                      
                         if($row['driverDetails']['entityId'] == $row['mas_id'])
                            $datatosend1[] = array('Order Id'=>$row['order_id'],'Driver Name'=>$row['driverDetails']['firstName'],'Driver Email'=>$row['driverDetails']['email'],'Driver Phone'=>$row['driverDetails']['mobile'],'Customer Name'=>$row['slaveName'],'Customer Email'=>$row['slaveEmail'],'Customer Phone'=>$row['slavemobile'],'Receiver Name'=>$receiverData['name'],'Receiver Email'=>$receiverData['email'],'Receiver Phone'=>$receiverData['mobile'],'Vehicle Type'=>$row['vehicleType']['type_name'],'Requesting Fare'=>$receiverData['Fare'],'Payment Type'=>$paymentType[$row['payment_type']],'weight'=>$receiverData['weight'],'Extra note'=>$row['extra_notes'],'Pickup'=>$row['address_line1'],'Pickup Date & Time'=>$pickupDate,'Drop At'=>$row['drop_addr1'],'Drop Date & Time'=>$dropDate,'Pickup zone'=>$pickupZone['title'],'Drop zone'=>$dropZone['title'],'Distance'=>$receiverData['ApproxDistance'],'ETA'=>'','Status'=>$Apptstatus[$receiverData['status']]);
                         
                     }
                       
                }  
             
        return $datatosend1;
    }

    function getDatafromdate($stdate, $enddate) {
        $query = $this->db->query("select ap.appointment_dt,ap.appointment_id,ap.inv_id,ap.txn_id as tr_id,ap.status,ap.amount,d.email as mas_email,d.first_name as mas_fname,d.last_name as mas_lname,p.email as slv_email,p.first_name as slv_fname,p.last_name as slv_lname,c.company_id from appointment ap,master d,slave p,company_info c where c.company_id = d.company_id and ap.mas_id = d.mas_id and ap.slave_id = p.slave_id and DATE(ap.appointment_dt) BETWEEN '" . date('Y-m-d', strtotime($stdate)) . "' AND '" . date('Y-m-d', strtotime($enddate)) . "' order by ap.appointment_id DESC LIMIT 200")->result(); //get_where('slave', array('email' => $email, 'password' => $password));
        return $query;
    }

    function getuserinfo() {
        $query = $this->db->query("select * from company_info  ")->row();
        return $query;
    }

//    function getPassangerBooking() {
//        $query = $this->db->query("select a.appointment_id,a.complete_dt,a.amount,a.inv_id,a.distance_in_mts,a.appointment_dt,a.drop_addr1,a.drop_addr2,a.mas_id,a.slave_id,d.first_name as doc_firstname,d.profile_pic as doc_profile,d.last_name as doc_lastname,p.first_name as patient_firstname,p.last_name as patient_lastname,a.address_line1,a.address_line2,a.status from appointment a,master d,slave p where a.slave_id=p.slave_id and d.mas_id=a.mas_id and a.status IN (9) and a.slave_id='" . $this->session->userdata("LoginId") . "' order by a.appointment_id desc")->result(); //get_where('slave', array('email' => $email, 'password' => $password));
//        return $query;
//    }
//    function addservices() {
//        $data = $this->input->post('servicedata');
//        $this->db->insert('services', $data);
//    }
//
//    function updateservices($table = '') {
//        $formdataarray = $this->input->post('editservicedata');
//        $id = $this->input->post('id');
//        $this->db->update($table, $formdataarray, array('service_id' => $id));
//    }
//
//    function deleteservices($table = '') {
//        $id = $this->input->post('id');
//        $this->db->where('service_id', $id);
//        $this->db->delete($table);
//    }
//    function getActiveservicedata() {
//        $query = $this->db->query("select * from services")->result(); //get_where('slave', array('email' => $email, 'password' => $password));
//        return $query;
//    }

    function Vehicles($status = '') {
        $quaery = $this->db->query("select w.workplace_id,w.uniq_identity,w.Title,w.Vehicle_Model,w.type_id,w.Vehicle_Reg_No,w.License_Plate_No,w.Vehicle_Insurance_No,w.Vehicle_Color,vt.vehicletype,vm.vehiclemodel,wt.type_id,wt.type_name,ci.companyname FROM workplace w,vehicleType vt,vehiclemodel vm,workplace_types wt,company_info ci where vt.id=w.title and w.company = ci.company_id and vm.id=w.Vehicle_Model and wt.type_id =w.type_id  and w.status ='" . $status . "' order by w.workplace_id desc")->result();
        return $quaery;
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

        $formdataarray = $this->input->post('fdata');
        $this->db->update('company_info', $formdataarray, array('company_id' => $this->session->userdata("LoginId")));

        $this->session->set_userdata(array('profile_pic' => $formdataarray['logo'],
            'first_name' => $formdataarray['first_name'],
            'last_name' => $formdataarray['last_name']));
    }

    function getRediousPrice() {
        
            $this->load->library('Datatables');
        $this->load->library('table');

        $this->load->library('mongo_db');
        $db = $this->mongo_db->db->selectCollection('RediousPrice');
      
        $data = array();
  
        
        if ($this->session->userdata('city_id') != 0) {
            $data =   $db->find(array('cityid' => $this->session->userdata('city_id')))->limit(1);
        } else {

           $data =  $db->find();
        }
        $senddata = array();
        
        
        $sln =0;
      
        foreach ($data as $res)
        {  
          
            $City_Name = $this->db->query("select * from city where City_Id = ".$res['cityid']."")->row()->City_Name;
            $senddata[] = array(++$sln,$City_Name,$res['from_'],$res['to_'],$res['price'],'<button type="button" id="'.$res['_id'].'" city-id="'.$res['cityid'].'" class="btn btn-info btn-cons editPrice">Edit</button><button type="button" id="'.$res['_id'].'" class="btn btn-danger btn-cons deletePrice">Delete</button>');
        }
        
//      
        if ($this->input->post('sSearch') != '') {

            $FilterArr = array();
            foreach ($senddata as $row) {
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
            echo $this->datatables->getdataFromMongo($senddata);

    }

    public function senPushToDriver($driversArrIos, $driversArrAndroid, $message, $city_id, $usertype, $User_ids, $query = '') {


        $driversArrIos1 = array_values(array_filter(array_unique($driversArrIos)));
        $driversArrAndroid1 = array_values(array_filter(array_unique($driversArrAndroid)));

        $amazon = new AwsPush();
        $pushReturn = array();
        foreach ($driversArrIos1 as $endpointArn)
            $pushReturn[] = $amazon->publishJson(array(
                'MessageStructure' => 'json',
                'TargetArn' => $endpointArn,
                'Message' => json_encode(array(
                    'APNS' => json_encode(array(
                        'aps' => array(
                            'alert' => $message,
                            'nt' => 420
                        )
                    ))
                )),
            ));


        $count = count($driversArrAndroid1) + count($driversArrIos1);

        if ($query != '') {

            $data = $this->db->query($query)->result();
            foreach ($data as $res)
                $driversArrAndroid[] = $res->push_token;
        }


        $fields = array(
            'registration_ids' => $driversArrAndroid1,
            'data' => array('payload' => $message, 'action' => 420),
        );

        if ($usertype == 1)
            $apiKey = ANDROID_DRIVER_PUSH_KEY;
        else if ($usertype == 2)
            $apiKey = ANDROID_PASSENGER_PUSH_KEY;

        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://android.googleapis.com/gcm/send');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);

        curl_close($ch);
        $res_dec = json_decode($result);



        if ($res_dec->success >= 1) {

//            $query = "insert into DriverNotification(city,message,date,NumOfDriver,user_type)  values('" . $citylatlon . "','" . $message . "',now(),'" . count($driversArrAndroid) . "','" . $usertype . "')";
//            $this->db->query($query);
            $this->load->library('mongo_db');

            $insertArr = array('user_type' => (int) $usertype, 'DateTime' => date('Y-m-d H:i:s'), 'msg' => $message, 'city' => $city_id, 'user_ids' => $User_ids);
            $lastid = $this->mongo_db->insert('AdminNotifications', $insertArr);


            return array('errorNo' => 44, 'result' => $driversArrAndroid1, 'count' => count($driversArrAndroid1), 'test1' => $pushReturn[0]['MessageId'], 'test' => $query);
        } else
            return array('errorNo' => 46, 'result' => $driversArrAndroid1, 'test' => $result);
    }

    function addRediousPrice($from, $to, $price, $cityid) {

        $this->load->library('mongo_db');

        $dbins = $this->mongo_db->db;
        $dbsname = $dbins->selectCollection('RediousPrice');
        $data = $dbsname->findOne(
                array(
                    'cityid' => $cityid,
                    '$or' => array(
                        array('$and' =>
                            array(
                                array('from_' =>
                                    array('$gte' => (int) $from)
                                ),
                                array('from_' => array('$lte' => (int) $to))
                            )
                        ),
                        array('$and' =>
                            array(
                                array('to_' =>
                                    array('$lte' => (int) $to)
                                ),
                                array('to_' =>
                                    array('$gt' => (int) $from)
                                )
                            )
                        )
                    )
                )
        );
//        foreach ($cursor as $r){
//            $data[]  = $r;
//        }
        if (!empty($data)) {
            echo json_encode(array('flag' => 1, 'error' => 'This redious is already defined.'));
        } else {
            $insertArr = array('from_' => (int) $from, 'to_' => (int) $to, 'price' => (int) $price, 'cityid' => $cityid);
            $lastid = $this->mongo_db->insert('RediousPrice', $insertArr);
            echo json_encode(array('flag' => 0, 'error' => 'Redious price has been added.', 'mid' => (string) $lastid));
        }
    }

       function editRediousPrice($from, $to, $price, $mongoId, $cityid) {

        $this->load->library('mongo_db');
        $update = array('from_' => (int) $from, 'to_' => (int) $to, 'price' => (int) $price, "cityid" => $cityid);
     
        $respon = $this->mongo_db->update('RediousPrice', $update, array('_id' => new MongoId($mongoId)));
        if ($respon == TRUE)
            echo json_encode(array('flag' => 0, 'error' => 'Redious price has been Updated.'));
        else {
            echo json_encode(array('flag' => 1, 'error' => 'Not Updated.'));
        }
    }

     function DeleteRediousPrice($mid) {
        $this->load->library('mongo_db');
        $respon = $this->mongo_db->delete('RediousPrice', array('_id' => new MongoId($mid)));
        echo json_encode(array('flag' => 0, 'error' => 'Deleted Succesfully.', 'rest' => $respon));
    }

    function updateMasterBank() {

        $stripe = new StripeModule();

        $checkStripeId = $this->db->query("SELECT stripe_id from master where mas_id = " . $this->session->userdata("LoginId"))->row();

//        if (!is_array($checkStripeId)) {
//            return array('flag' => 2);
//        }

        $userData = $this->input->post('fdata');

        if ($checkStripeId->stripe_id == '') {
            $createRecipientArr = array('name' => $userData['name'], 'type' => 'individual', 'email' => $userData['email'], 'tax_id' => $userData['tax_id'], 'bank_account' => $userData['account_number'], 'routing_number' => $userData['routing_number'], 'description' => 'For ' . $userData['email']);
            $recipient = $stripe->apiStripe('createRecipient', $createRecipientArr);
        } else {
            $updateRecipientArr = array('name' => $userData['name'], 'email' => $userData['email'], 'tax_id' => $userData['tax_id'], 'bank_account' => $userData['account_number'], 'routing_number' => $userData['routing_number'], 'description' => 'For ' . $userData['email']);
            $recipient = $stripe->apiStripe('updateRecipient', $updateRecipientArr);
        }
        if (isset($recipient['error']))
            return array('flag' => 1, 'message' => $recipient['err']['error']['message'], 'data' => $userData); //, 'args' => $recipient);
        else if ($recipient['verified'] === FALSE)
            return array('flag' => 1, 'message' => "Need your full, legal name, you can check the details with the below link<br>https://support.stripe.com/questions/how-do-i-verify-transfer-recipients", 'link' => 'https://support.stripe.com/questions/how-do-i-verify-transfer-recipients', 'data' => $userData);
        else if ($recipient['verified'] === TRUE)
            return array('flag' => 0, 'message' => "Updated bank details successfully", 'data' => $userData);
    }

    function Getdashboarddata() {
        $this->load->library('mongo_db');

        $dbins = $this->mongo_db->db;

        $dbsname = $dbins->selectCollection('ShipmentDetails');

        
        $dashboard['customers'] = $this->db->query("SELECT COUNT(*) as customers  FROM slave")->row()->customers;
        $dashboard['drivers'] = $this->db->query("SELECT COUNT(*) as drivers  FROM master")->row()->drivers;
     
        $currTime = time();
        
        // today completed booking count
        $today = date('Y-m-d', $currTime);
        $weekArr = $this->week_start_end_by_date($currTime);
        
        $dashboard['today'] = $dbsname->find(array('timpeStamp_appointment_date' =>array('$gte'=>strtotime('today midnight')),'receivers.status'=>'22'))->count();
        
        $dashboard['week'] = $dbsname->find(array('timpeStamp_appointment_date' =>array('$gte'=>strtotime($weekArr['first_day_of_week'])),'receivers.status'=>'22'))->count();

        $dashboard['month']  =$dbsname->find(array('timpeStamp_appointment_date' =>array('$gte'=>strtotime( 'first day of ' . date( 'F Y')),'$lte'=>strtotime(date('Y-m-t'))),'receivers.status'=>'22'))->count();
        
        $dashboard['lifetime'] = $dbsname->find(array('receivers.status'=>'22'))->count();
       
       $dashboard['apple'] = $this->db->query("SELECT COUNT(DISTINCT(oid)) as apple  FROM user_sessions where type=1 and user_type = 2")->row()->apple;
       $dashboard['andriod'] = $this->db->query("SELECT COUNT(DISTINCT(oid)) as andriod FROM user_sessions where type=2  and user_type = 2")->row()->andriod;
       $dashboard['totalUser'] = $this->db->query("SELECT COUNT(*) as totalUser FROM slave")->row()->totalUser;
  
       
       
         
        return $dashboard;
    }

    function updateData($IdToChange = '', $databasename = '', $db_field_id_name = '') {
        $formdataarray = $this->input->post('fdata');
        $this->db->update($databasename, $formdataarray, array($db_field_id_name => $IdToChange));
    }
    function updateBookingDetails($order_id = '') {
         $this->load->library('mongo_db');
      
        $slaveName = $this->input->post('slaveName');
        $receiverName = $this->input->post('receiverName');
        $slavePhone = $this->input->post('slavePhone');
        $receiverPhone = $this->input->post('receiverPhone');
        $slaveEmail = $this->input->post('slaveEmail');
        $receiverEmail = $this->input->post('receiverEmail');
        
        $pickupAddr = $this->input->post('pickupAddr');
        $dropAddr = $this->input->post('dropAddr');
        
        $weight = $this->input->post('weight');
        $qty = $this->input->post('qty');
        
        $dateToUpdate = array('slaveName'=>$slaveName,'slavemobile'=>$slavePhone,'slaveEmail'=>$slaveEmail,'address_line1'=>$pickupAddr,'drop_addr1'=>$dropAddr,'receivers.0.name'=>$receiverName,'receivers.0.mobile'=>$receiverPhone,'receivers.0.email'=>$receiverEmail,'receivers.0.weight'=>$weight,'receivers.0.quantity'=>$qty);
         $respon = $this->mongo_db->update('ShipmentDetails', $dateToUpdate, array('order_id' =>(int)$order_id));
         return;
    }

    function LoadAdminList() {
        $db = new MongoClient();
        $mongoDB = $db->db_Ryland_Insurence;
        $collection = $mongoDB->Col_Manage_Admin;
        $cursor = $collection->find(array('Role' => "SubAdmin"));
//        $db->close();
        return $cursor;
    }

    function issessionset() {

        if ($this->session->userdata('emailid') && $this->session->userdata('password')) {

            return true;
        }
        return false;
    }

}

?>
