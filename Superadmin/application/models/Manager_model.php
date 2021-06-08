<?php

class Manager_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    function addManager() {

        $this->load->library('mongo_db');
        $mongoArr = array('fname' => $this->input->post('first_name'), "lname" => $this->input->post('last_name'), "email" => $this->input->post('email'), 'phone' => '+' . $this->input->post('coutry-code').$this->input->post('phone'), 'created_dt' => time());

        $this->mongo_db->insert('Managers', $mongoArr);
        echo json_encode(array('Msg' => 'Successfully inserted', 'flag' => 0));
        return;
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

    function updateManager() {

        $this->load->library('mongo_db');
        $mongoArr = array('fname' => $this->input->post('first_nameEdit'), "lname" => $this->input->post('last_nameEdit'), "email" => $this->input->post('emailEdit'), 'phone' => '+' . $this->input->post('coutry-codeEdit').$this->input->post('phoneEdit'));

        $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('mongoIDToEdit'))))->set($mongoArr)->update('Managers');
        $this->mongo_db->where(array('managerId' => new MongoDB\BSON\ObjectID($this->input->post('mongoIDToEdit'))))->set(array('managerName'=>$this->input->post('first_nameEdit').' '.$this->input->post('last_nameEdit')))->update('dispatcher');
       
        echo json_encode(array('Msg' => 'Successfully inserted', 'flag' => 0));
        return;
    }

    function deleteManager() {

        $this->load->library('mongo_db');
        $db = $this->mongo_db->db;
        $_ids = $this->input->post('val');

        foreach ($_ids as $id)
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->delete('Managers');
           
        echo json_encode(array('flag' => 0, 'msg' => 'Successfully deleted'));
        return;
    }

    function datatable_managers() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 4;
        $_POST['mDataProp_0'] = "fname";
        $_POST['mDataProp_1'] = "lname";
        $_POST['mDataProp_2'] = "email";
        $_POST['mDataProp_3'] = "phone";

         $respo = $this->datatables->datatable_mongodb('Managers');

        $aaData = $respo["aaData"];
        $datatosend = array();
        
        $slno= 0;

        foreach ($aaData as $value) {
            
            $arr = array();
            $arr[] = ++$slno;
            $arr[] = $value['fname'].' '.$value['lname'];
            $arr[] = $value['email'];
            $arr[] = $value['phone'];
             $arr[] = '<input type="checkbox" class="checkbox" value="' . $value['_id']['$oid'] . '"/>';
            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

}
