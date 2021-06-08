<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class aceessmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->library('mongo_db');
    }

    function get_roles($param = '') {
        if ($param == '')
            $res = $this->mongo_db->get('admin_roles');
        else
            $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->find_one('admin_roles');
        return $res;
    }

    function role_action() {
        $edit_id = $this->input->post('edit_id');
        $fdata = $this->input->post('fdata');
        if ($edit_id == '') {
            $fdata['_id'] =new MongoDB\BSON\ObjectID();
            $this->mongo_db->insert('admin_roles',$fdata);
            echo json_encode(array('msg' => '1', 'insert' => (String)$fdata['_id'], 'access' => $fdata['access']));
            die;
        }else {
            $this->mongo_db->update('admin_roles', $fdata, array('_id' => new MongoDB\BSON\ObjectID($edit_id)));
            echo json_encode(array('msg' => '1', 'insert' => '0', 'access' => $fdata['access']));
            die;
        }
        echo json_encode(array('msg' => '0'));
    }
    
    function get_users($param = '') {
      if ($param == '')
            $res = $this->mongo_db->where(array('superadmin' => array('$exists' => false)))->get('admin_users');
        else
            $res = $this->mongo_db->where(array('_id' =>new MongoDB\BSON\ObjectID($param)))->find_one('admin_users');
        return $res;
    }
    function get_cities() {
//        return $this->db->query("select * from city_available ORDER BY City_Name ASC")->result();
    }
    
    function user_action() {
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
            $this->mongo_db->update('admin_users', $fdata, array('_id' =>new MongoDB\BSON\ObjectID($edit_id)));
//            echo json_encode(array('msg' => '1', 'insert' => '0'));
//            die;
        }
//        echo json_encode(array('msg' => '0'));
        redirect(base_url() . "index.php?/superadmin/manageRole");
    }
}

?>
