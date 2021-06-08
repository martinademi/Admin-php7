<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class HelpTextModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('CallAPI');
    }

    function getLanguages($param = '') {
        $this->load->library('mongo_db');
        if ($param == '') {

            $res = $this->mongo_db->get_where('languages', array('active' => 1));
        } else {
            $res = $this->mongo_db->get_where('languages', array(array('languageId' => (int) $param), array('active' => 1)));
        }
        return $res;
    }

    function get() {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->get('helpText');
        return $res;
    }
    function get_subCategory($catid) {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('cat_id' => (int) $catid))->find_one('helpText');
        
        return $res;
    }

    function getOne($docID = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($docID)))->get('helpText');
        return $res;
    }

    function add() {

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
                $cursor = $this->mongo_db->get('helpText');
                $data1 = array();
                foreach ($cursor as $res) {
                    $data1 = $res;
                }
                if (!empty($data1)) {
                    $data['cat_id'] = $data1['cat_id'] + 1;
                } else {
                    $data['cat_id'] = 1;
                }
                $this->mongo_db->insert('helpText', $data);
            } else {
                unset($data['has_scat']);
                unset($data['sub_cat']);

                $data['id'] = new MongoDB\BSON\ObjectId();
                $result = $this->mongo_db->where(array('cat_id' => (int) $cat_id))->push(array('sub_cat' => $data))->update('helpText');
            }
        } else {
            unset($data['sub_cat']);
            $scat_id = $this->input->post('scat_id');
            if ($scat_id == '') {
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->set($data)->update('helpText');
            } else {
                $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectID($scat_id)))->pull('sub_cat', array('id' => new MongoDB\BSON\ObjectID($scat_id)))->update('helpText');
                unset($data['sub_cat']);
                unset($data['has_scat']);
                $data['id'] = new MongoDB\BSON\ObjectID($scat_id);
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->push(array('sub_cat' => $data))->update('helpText');
            }
        }
    }
    function getSubHelpSupportLanguage() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectID($this->input->post('helpId'))))->find_one('helpText');
        $getLanguages = $this->mongo_db->where(array('active'=> 1))->get('languages');
        echo json_encode(array('data' => $getAll, 'lang' => $getLanguages));
    }
    function delete() {

        $this->load->library('mongo_db');
        $this->mongo_db->where(array('cat_id' => (int) $this->input->post('id')))->delete('helpText');
        echo json_encode(array('msg' => '1'));
        return;
    }
      function getDescription($cat_id = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('cat_id' => (int) $cat_id))->find_one('helpText');
        return $res['desc'];
    }
    //add help Text
    
    function get_lan_hlpText($param = '') {
        $this->load->library('mongo_db');
        if ($param == '') {
            $res = $this->mongo_db->get_where('languages', array('active' => 1));
        } else {
            $res = $this->mongo_db->get_where('languages', array(array('languageId' => (int) $param), array('active' => 1)));
        }
        return $res;
    }
    function get_help_support($param = '', $param2 = '') {

        $this->load->library('mongo_db');
        if ($param == '') {

            $res = $this->mongo_db->where(array('usertype' => "2"))->get('helpText');
        } else {
            if ($param2 == '')
                $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->get('helpText');
            else
                $res = $this->mongo_db->where(array('cat_id' => (int) $param))->find_one('helpText');
        }

        return $res;
    }
    
    function actionCustomer($param = '', $param2 = ''){
       
        $this->load->library('mongo_db');
        if($param == 'subdel'){
            if ($param2 == '') {
                 $this->mongo_db->where(array('sub_cat.id' =>new MongoDB\BSON\ObjectId($this->input->post('id'))))->pull('sub_cat',array('id' =>new MongoDB\BSON\ObjectId($this->input->post('id'))))->update('helpText');
                 echo json_encode(array('msg' => '1'));
                die;
            }
            
        }
        else if ($param2 == '') {
             $this->mongo_db->where(array('cat_id' =>(int)$this->input->post('id')))->delete('helpText');              
             echo json_encode(array('msg' => '1'));
             die;
            }
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
                $cursor = $this->mongo_db->get('helpText');
                $data1 = array();
                foreach ($cursor as $res) {
                    $data1 = $res;
                }
                if (!empty($data1)) {
                    $data['cat_id'] = $data1['cat_id'] + 1;
                } else {
                    $data['cat_id'] = 1;
                }
                $this->mongo_db->insert('helpText', $data);
            } else {
                unset($data['has_scat']);
                unset($data['sub_cat']);

                $data['id'] = new MongoDB\BSON\ObjectId();
                $result = $this->mongo_db->where(array('cat_id' => (int) $cat_id))->push(array('sub_cat' => $data))->update('helpText');
            }
        } else {
            unset($data['sub_cat']);
            $scat_id = $this->input->post('scat_id');
//            $data['id'] = new MongoDB/BSON/ObjectID();
            if ($scat_id == '') {
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->set($data)->update('helpText');
            } else {
                $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectID($scat_id)))->pull('sub_cat', array('id' => new MongoDB\BSON\ObjectID($scat_id)))->update('helpText');
                unset($data['sub_cat']);
                unset($data['has_scat']);
                $data['id'] = new MongoDB\BSON\ObjectID($scat_id);
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->push(array('sub_cat' => $data))->update('helpText');
            }
        }
    }
    
    function get_subcat_support($param = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->find_one('helpText');


        return $res[sub_cat];
    }
    function getHelpSupportLanguage() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('helpId'))))->find_one('helpText');
        $getLanguages = $this->mongo_db->where(array('active'=> 1))->get('languages');
        echo json_encode(array('data' => $getAll, 'lang' => $getLanguages));
    }

}
