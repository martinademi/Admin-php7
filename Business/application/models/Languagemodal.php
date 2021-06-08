<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Languagemodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function datatable_language() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $respo = $this->datatables->datatable_mongodb('lang_hlp');
        $aaData = $respo["aaData"];
        $datatosend = array();

        $index = 1;
        foreach ($aaData as $value) {
            $arr = array();
            if ($value['Active'] == 1) {
                $active = 'Enabled';
            } else {
                $active = 'Disabled';
            }
            $arr[] = $index++;
            $arr[] = $value['lan_name'];
            $arr[] = $active;
            $arr[] = ($value['Active'] == 0) ? '<button class="btn btn-success btnenable" id="btnenable" value="' . $value['lan_id'] . '"  data-id=' . $value['lan_id'] . '>Enable </button><button class="btn btn-primary btnedit" id="btnedit"  value="' . $value['lan_id'] . '"  data-id=' . $value['lan_id'] . '>Edit</button><button class="btn btn-danger btndelete" id="btndelete" value="' . $value['lan_id'] . '" data-id=' . $value['lan_id'] . '>Delete</button>' : '<button class="btn btn-warning btndisable" id="btndisable" value="' . $value['lan_id'] . '" data-id=' . $value['lan_id'] . '>Disable </button><button class="btn btn-primary btnedit" id="btnedit" value="' . $value['lan_id'] . '" data-id=' . $value['lan_id'] . '>Edit</button>' . '<button class="btn btn-danger btndelete" id="btndelete" value="' . $value['lan_id'] . '" data-id=' . $value['lan_id'] . '>Delete</button>';


            $datatosend[] = $arr;
        }


        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

  

    function get_lan_hlpTextone($param = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('lan_id' => (int) $param))->find_one('lang_hlp');
        echo json_encode($res);
    }


    function get_lan_hlpText($param = '') {
        $this->load->library('mongo_db');
        if ($param == '') {

            $res = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    
    function lan_action() {
        $this->load->library('mongo_db');
        $edit_id = $this->input->post('edit_id');
        $lan_name = $this->input->post('lan_name');
        $msg = $this->input->post('lan_msg');

        if ($edit_id == '') {
            $cursor = $this->mongo_db->get('lang_hlp');
            $data = array();
            foreach ($cursor as $res) {
                $data = $res;
            }


            if (!empty($data))
                $edit_id = $data['lan_id'] + 1;
            else
                $edit_id = 1;


            $this->mongo_db->insert('lang_hlp', array('lan_id' => (int) $edit_id, "lan_name" => $lan_name, "Active" => 1));
            echo json_encode(array('msg' => '1', 'insert' => $edit_id));
        }else {
            $this->mongo_db->where(array('lan_id' => (int) $edit_id))->set(array("lan_name" => $lan_name))->update('lang_hlp');
            echo json_encode(array('msg' => '1', 'insert' => '0'));
        }
    }

    function enable_lang() {
        $this->load->library('mongo_db');
        $val = $this->input->post('id');
        $res = $this->mongo_db->where(array('lan_id' => (int) $val))->set(array('Active' => 1))->update('lang_hlp');
        echo json_encode($res);
    }

    function deleteLang($param) {
        $this->load->library('mongo_db');
        if ($param == 'del') {
            $this->mongo_db->where(array('lan_id' => (int) $this->input->post('id')))->delete('lang_hlp');
            echo json_encode(array('msg' => '1'));
        }
    }

    function disable_lang() {
        $this->load->library('mongo_db');
        $val = $this->input->post('id');
        $res = $this->mongo_db->where(array('lan_id' => (int) $val))->set(array('Active' => 0))->update('lang_hlp');
        echo json_encode($res);
    }

}
