<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Cancellationmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
    }

    public function datatable_language() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $respo = $this->datatables->datatable_mongodb('languages');
        $aaData = $respo["aaData"];
        $datatosend = array();

        $index = 1;
        foreach ($aaData as $value) {
            $arr = array();
            if ($value['active'] == 1) {
                $active = 'Enabled';
            } else {
                $active = 'Disabled';
            }
            $arr[] = $index++;
            $arr[] = '<span style="text-transform: capitalize;">' . $value['name'] . '</span>';
            $arr[] = '<span style="text-transform: capitalize;">' . $value['code'] . '</span>';
            $arr[] = $active;
            $arr[] = ($value['active'] == 0) ? '<button class="btn btn-success btnenable cls111" id="btnenable" value="' . $value['languageId'] . '"  data-id=' . $value['languageId'] . '>Enable </button><button class="btn btn-primary edit_new_lang cls111" id="edit_new_lang"  value="' . $value['languageId'] . '"  data-id=' . $value['languageId'] . '>Edit</button>' : '<button class="btn btn-warning btndisable" id="btndisable" value="' . $value['languageId'] . '" data-id=' . $value['languageId'] . '>Disable </button><button class="btn btn-primary edit_new_lang" id="edit_new_lang" value="' . $value['languageId'] . '" data-id=' . $value['languageId'] . '>Edit</button>';
            //First <button class="btn btn-danger btndelete cls111" id="btndelete" value="' . $value['languageId'] . '" data-id=' . $value['languageId'] . '>Delete</button>
            //Second<button class="btn btn-danger btndelete" id="btndelete" value="' . $value['languageId'] . '" data-id=' . $value['languageId'] . '>Delete</button>
            $datatosend[] = $arr;
        }


        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function datatable_canreason($reason, $reasonFor){
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "reasonObj.en";

        $respo = $this->datatables->datatable_mongodb('can_reason', array('res_for' => $reasonFor), '', 1);
        $aaData = $respo["aaData"];
        $datatosend = array();

        $index = 1;
        $getLanguage = $this->mongo_db->where(array('active' => 1 ))->get('languages');
         
        foreach ($aaData as $value) {
           
            $arr = array();

            $arr[] = $index++;
            $arr[] = '<a class="cancelReson"  style="cursor: pointer" data-id="' . $value['_id']['$oid'] . '">' .$value['reasonObj']['en']. '</a>';
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '">';


            $datatosend[] = $arr;
        }


        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }
    
    function get_lan_hlpTextone($param = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('languageId' => (int) $param))->find_one('languages');
        echo json_encode($res);
    }


    function get_lan_hlpText($param = '') {
        $this->load->library('mongo_db');
        
        if ($param == '') {
            $res = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
             
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('langCode' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function deleteCan() {
        $this->load->library('mongo_db');
        $ids = $this->input->post('id');
        $reason = $this->input->post('res');
        foreach ($ids as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('can_reason');
        }
        echo json_encode(array('msg' => '1'));
    }

    function getDescription($cat_id = '',$languageCode='') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('cat_id' => (int) $cat_id))->find_one('supportText');
        return $res['desc'][$languageCode];
    }

    function getsubDescription($cat_id = '', $subcatID = '',$languageCode='') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('cat_id' => (int) $cat_id, 'sub_cat.id' => new MongoDB\BSON\ObjectID($subcatID)))->find_one('supportText');
        foreach ($res['sub_cat'] as $data) {
            if ($data['id']['$oid'] == $subcatID)
                return $data['desc'][$languageCode];
        }
    }

    function lan_action() {
        $this->load->library('mongo_db');
        $edit_id = $this->input->post('edit_id');
        $name = $this->input->post('lan_name');
        $msg = $this->input->post('lan_msg');
        $code = $this->input->post('lan_code');

        if ($edit_id == '') {
            $cursor = $this->mongo_db->get('languages');
            $data = array();
            foreach ($cursor as $res) {
                $data = $res;
            }


            if (!empty($data))
                $edit_id = $data['languageId'] + 1;
            else
                $edit_id = 1;


            $this->mongo_db->insert('languages', array('languageId' => (int) $edit_id, "name" => $name, "code" => $code,"active" => 1));
            echo json_encode(array('msg' => '1', 'insert' => $edit_id));
        }else {
            $this->mongo_db->where(array('languageId' => (int) $edit_id))->set(array("name" => $name,"code" => $code))->update('languages');
            echo json_encode(array('msg' => '1', 'insert' => '0'));
        }
    }
    
    function add_lan_action() {
        $this->load->library('mongo_db');
 
        $name = $this->input->post('lang_name');
        $code = $this->input->post('lang_code');
        $edit_id = 1;
        $cursor = $this->mongo_db->get('languages');
        $data = array();
        foreach ($cursor as $res) {
            $data = $res;
        }


        if (!empty($data))
            $edit_id = $data['languageId'] + 1;
            

        $this->mongo_db->insert('languages', array('languageId' => (int) $edit_id, "name" => $name, "code" => $code,"active" => 1));
        echo json_encode(array('msg' => '1', 'insert' => $edit_id));
        
    }
    function edit_lan_action() {
        $this->load->library('mongo_db');
 
        $name = $this->input->post('lang_name');
        $id=$this->input->post('lang_id');
        
        
        $res = $this->mongo_db->where(array('languageId' => (int) $id))->set(array('name' => $name))->update('languages');

                
        echo json_encode(array('msg' => '1', 'update' => $id));
        
    }
    

    function enable_lang() {
        $this->load->library('mongo_db');
        $val = $this->input->post('id');
        $res = $this->mongo_db->where(array('languageId' => (int) $val))->set(array('active' => 1))->update('languages');
        echo json_encode($res);
    }

    function deleteLang($param) {
        $this->load->library('mongo_db');
        if ($param == 'del') {
            $this->mongo_db->where(array('languageId' => (int) $this->input->post('id')))->delete('languages');
            echo json_encode(array('msg' => '1'));
        }
    }

    function disable_lang() {
        $this->load->library('mongo_db');
        $val = $this->input->post('id');
        $res = $this->mongo_db->where(array('languageId' => (int) $val))->set(array('active' => 0))->update('languages');
        echo json_encode($res);
    }

    
    function get_can_reasons() {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->get('can_reason');
        return $res;
    }

    function getCanData() {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        $res = $this->input->post('res');
        foreach ($id as $ids) {
            $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($ids)))->find_one('can_reason');
        }
        echo json_encode(array('data' => $res));
    }

    function cancell_act() {
        $this->load->library('mongo_db');
        $edit_id = $this->input->post('edit_id');
        $reasons = $this->input->post('reasons');
        $reason = $this->input->post('res');
        $res_for = $this->input->post('res_for');
        $id = $this->input->post('id');
        if ($edit_id == '') {

            $cursor = $this->mongo_db->get('can_reason');
            $data = array();
            foreach ($cursor as $res) {
                $data = $res;
            }
            if (!empty($data))
                $edit_id = $data['res_id'] + 1;
            else
                $edit_id = 1;

            $this->mongo_db->insert('can_reason', array('res_id' => $edit_id, "reasonObj" => $reasons, 'res_for' => $res_for));
            echo json_encode(array('msg' => '1', 'insert' => $edit_id, 'reason' => $reasons));
            die;
        }else {

            $this->mongo_db->where(array('res_id' => (int) $edit_id))->set(array("reasonObj" => $reasons))->update('can_reason');
            echo json_encode(array('msg' => '1'));
            die;
        }
        echo json_encode(array('msg' => '0'));
    }

    function get_cat_supportCustomer($param = '', $param2 = '') {
        $this->load->library('mongo_db');

        if ($param == '') {

            $res = $this->mongo_db->where(array('usertype' => "1"))->get('supportText');
        } else {
            if ($param2 == '')
                $res = $this->mongo_db->get_where('supportText', array('_id' => new MongoDB\BSON\ObjectID($param)));
            else
                $res = $this->mongo_db->where(array('cat_id' => (int) $param))->find_one('supportText');
        }

        return $res;
    }
    function get_cat_SubCategory($catid) {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('cat_id' => (int) $catid))->find_one('supportText');
        
        return $res;
    }

    function get_cat_support($param = '', $param2 = '') {

        $this->load->library('mongo_db');
        if ($param == '') {

            $res = $this->mongo_db->where(array('usertype' => "2"))->get('supportText');
        } else {
            if ($param2 == '')
                $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->get('supportText');
            else
                $res = $this->mongo_db->where(array('cat_id' => (int) $param))->find_one('supportText');
        }

        return $res;
    }

    function get_subcat_support($param = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->find_one('supportText');


        return $res[sub_cat];
    }

    function support_actionCustomer() {
        // echo "<pre>";
        // print_r($_POST);
        // exit();
        $this->load->library('mongo_db');
        $edit_id = $this->input->post('edit_id');
        $cat_id = $this->input->post('cat_id');

        $data['usertype'] = "1";
        $data['name'] = $this->input->post('cat_name');
        $data['has_scat'] = $this->input->post('cat_subcat');
        if ($data['has_scat'] == false) {
            $data['has_scat'] = false;
            $data['desc'] = $this->input->post('desc');
        } else {
            $data['has_scat'] = true;
            $data['sub_cat'] = array();
        }


        if ($edit_id == '') {
            if ($cat_id == '') {
                $cursor = $this->mongo_db->get('supportText');
                $data1 = array();
                foreach ($cursor as $res) {
                    $data1 = $res;
                }
                if (!empty($data1)) {
                    $data['cat_id'] = $data1['cat_id'] + 1;
                } else {
                    $data['cat_id'] = 1;
                }
                $this->mongo_db->insert('supportText', $data);
            } else {
                unset($data['has_scat']);
                unset($data['sub_cat']);

                $data['id'] = new MongoDB\BSON\ObjectId();
                $result = $this->mongo_db->where(array('cat_id' => (int) $cat_id))->push(array('sub_cat' => $data))->update('supportText');
            }
        } else {
            unset($data['sub_cat']);
            $scat_id = $this->input->post('scat_id');
//            $data['id'] = new MongoDB/BSON/ObjectID();
            if ($scat_id == '') {
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->set($data)->update('supportText');
            } else {
                $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectID($scat_id)))->pull('sub_cat', array('id' => new MongoDB\BSON\ObjectID($scat_id)))->update('supportText');
                unset($data['sub_cat']);
                unset($data['has_scat']);
                $data['id'] = new MongoDB\BSON\ObjectID($scat_id);
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->push(array('sub_cat' => $data))->update('supportText');
            }
        }
    }

    function support_actionDriver() {
        $this->load->library('mongo_db');
        $edit_id = $this->input->post('edit_id');
        $cat_id = $this->input->post('cat_id');

        $data['usertype'] = "2";
        $data['name'] = $this->input->post('cat_name');
        $data['has_scat'] = $this->input->post('cat_subcat');
        if ($data['has_scat'] == false) {
            $data['has_scat'] = false;
            $data['desc'] = $this->input->post('desc');
        } else {
            $data['has_scat'] = true;
            $data['sub_cat'] = array();
        }


        if ($edit_id == '') {
            if ($cat_id == '') {
                $cursor = $this->mongo_db->get('supportText');
                $data1 = array();
                foreach ($cursor as $res) {
                    $data1 = $res;
                }
                if (!empty($data1)) {
                    $data['cat_id'] = $data1['cat_id'] + 1;
                } else {
                    $data['cat_id'] = 1;
                }
                $this->mongo_db->insert('supportText', $data);
            } else {
                unset($data['has_scat']);
                unset($data['sub_cat']);

                $data['id'] = new MongoDB\BSON\ObjectId();
                $result = $this->mongo_db->where(array('cat_id' => (int) $cat_id))->push(array('sub_cat' => $data))->update('supportText');
            }
        } else {
            unset($data['sub_cat']);
            $scat_id = $this->input->post('scat_id');
//            $data['id'] = new MongoDB/BSON/ObjectID();
            if ($scat_id == '') {
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->set($data)->update('supportText');
            } else {
                $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectID($scat_id)))->pull('sub_cat', array('id' => new MongoDB\BSON\ObjectID($scat_id)))->update('supportText');
                unset($data['sub_cat']);
                unset($data['has_scat']);
                $data['id'] = new MongoDB\BSON\ObjectID($scat_id);
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->push(array('sub_cat' => $data))->update('supportText');
            }
        }
    }
    function email_template_action(){
         $this->load->library('mongo_db');
        $fdata = $this->input->post('fdata');
        if($fdata['type'] == 'post'){
            $data = $this->mongo_db->where(array("temp_type" => $fdata['temp_type']))->find_one("email_template");
            $fdata['body'] = $this->input->post('body_editor');
            if(is_array($data)){
                $this->mongo_db->where(array("temp_type" => $fdata['temp_type']))->set($fdata)->update('email_template');
            }else{
                $this->mongo_db->insert("email_template", $fdata);
            }
            redirect(base_url() . "index.php/utilities/email_template");
        }else if($fdata['type'] == 'get'){
            $data = $this->mongo_db->where(array("temp_type" => $fdata['temp_type']))->find_one("email_template");
            if(!is_array($data)){
                $data = array(
                    "subject" => "",
                    "from_name" => "",
                    "from_email" => "",
                    "body" => "",
                    "temp_type" => $fdata['temp_type']
                );
            }
            echo json_encode(array('flg' => 1, 'data' => $data));
        }else{
            redirect(base_url() . "index.php/utilities/email_template");
        }
    }
    
    function actionCustomer($param = '', $param2 = ''){
       
        $this->load->library('mongo_db');
        if($param == 'subdel'){
            if ($param2 == '') {
                 $this->mongo_db->where(array('sub_cat.id' =>new MongoDB\BSON\ObjectId($this->input->post('id'))))->pull('sub_cat',array('id' =>new MongoDB\BSON\ObjectId($this->input->post('id'))))->update('supportText');
                 echo json_encode(array('msg' => '1'));
                die;
            }    
        } else if ($param2 == '') {
             $this->mongo_db->where(array('cat_id' =>(int)$this->input->post('id')))->delete('supportText');              
             echo json_encode(array('msg' => '1'));
             die;
        }
    }
    function actionDriver($param = '', $param2 = ''){
        $this->load->library('mongo_db');
//          if ($param2 == '') {
//             $this->mongo_db->where(array('cat_id' =>(int)$this->input->post('id')))->delete('supportText');              
//             echo json_encode(array('msg' => '1'));
//             die;
//        } else if($param == 'subdel'){
//            if ($param2 == '') {
//                 $this->mongo_db->where(array('sub_cat.id' =>new MongoDB\BSON\ObjectId($this->input->post('id'))))->pull('sub_cat',array('id' =>new MongoDB\BSON\ObjectId($this->input->post('id'))))->update('supportText');
//                 echo json_encode(array('msg' => '1'));
//                die;
//            }
//         }
        if($param == 'subdel'){
            if ($param2 == '') {
                 $this->mongo_db->where(array('sub_cat.id' =>new MongoDB\BSON\ObjectId($this->input->post('id'))))->pull('sub_cat',array('id' =>new MongoDB\BSON\ObjectId($this->input->post('id'))))->update('supportText');
                 echo json_encode(array('msg' => '1'));
                die;
            }    
        } else if ($param2 == '') {
             $this->mongo_db->where(array('cat_id' =>(int)$this->input->post('id')))->delete('supportText');              
             echo json_encode(array('msg' => '1'));
             die;
        }
    }
    
    function getEmailTemplate(){
       $data = $this->mongo_db->where(array("temp_type" => "Passenger_Signup"))->find_one("email_template");
       return $data; 
    }
    
    function validatelanguagename(){
        $lanname = $this->input->post('lang');
       $data = $this->mongo_db->where(array("name" => $lanname))->find_one("languages");
       if(count($data)=='0')
       {
            echo json_encode(array('flag' => '0','data'=>$data));
       }
       else
       {
            echo json_encode(array('flag' => '1','data'=>$data));
       }
    }
    
    function validatelanguagecode(){
        $langcode = $this->input->post('langcode');
       $data = $this->mongo_db->where(array("code" => $langcode))->find_one("languages");
       if(count($data)=='0')
       {
            echo json_encode(array('flag' => '0','data'=>$data));
       }
       else
       {
            echo json_encode(array('flag' => '1','data'=>$data));
       }
    }
    
    function getCustomerSupportLanguage() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('supportId'))))->find_one('supportText');
        $getLanguages = $this->mongo_db->where(array('active'=> 1))->get('languages');
        echo json_encode(array('data' => $getAll, 'lang' => $getLanguages));
    }
     function getSubCustomerSupportLanguage() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectID($this->input->post('supportId'))))->find_one('supportText');
        $getLanguages = $this->mongo_db->where(array('active'=> 1))->get('languages');
        echo json_encode(array('data' => $getAll, 'lang' => $getLanguages));
    }

    function getCancelResonsSupportLanguage() {
        $this->load->library('mongo_db');
        $type=$this->input->post('reson');
       //print_r($type);die;
        if($type=='Customer')
        {
            $getAll = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('canId'))))->find_one('can_reason');
        }else  if($type=='Driver')
        {
            $getAll = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('canId'))))->find_one('can_reason');
        }else 
        {
            $getAll = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('canId'))))->find_one('can_reason');
        }
        
        $getLanguages = $this->mongo_db->where(array('Active'=> 1))->get('lang_hlp');
       echo json_encode(array('data' => $getAll, 'lang' => $getLanguages));
    }
}
