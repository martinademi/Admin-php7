<?php

class ContactUsCitymodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('CallAPI');
    }

    function datatable_ContactUsCity() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "name";
        $respo = $this->datatables->datatable_mongodb('contactUsCity', array('isDeleted' => array('$ne' => TRUE)));
        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();
            $arr[] = $value['title'];
            $arr[] = $value['phone'];
            $arr[] = $value['address'];
            $arr[] = $value['city'];
            $arr[] = $value['state'];
            $arr[] = $value['zipCode'];
            $arr[] = '<input type="checkbox" class="checkbox1" name="checkbox1" value="' . $value['_id']['$oid'] . '">';
            $datatosend[] = $arr;
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function insert() {
        $this->load->library('mongo_db');
        $updateArray = array('address' => $_POST['address'],
            'title' => $_POST['cityTitle'],
            'city' => $_POST['add_city'],
            'state' => $_POST['add_state'],
            'zipCode' => $_POST['add_zip'],
            'phone'=>$_POST['phone'],
            'createdAt' => $this->mongo_db->date());
		$id	= $this->mongo_db->insert('contactUsCity', $updateArray); 
		$updateArray['id'] = $id;
		 $this->mongo_db->push(array("contactUs"=>$updateArray))->update('appConfig');
       
    }

    function update() {
        $this->load->library('mongo_db');
        $id = $_POST['docID'];
        $updateArray = array('address' => $_POST['eaddress'],
            'title' => $_POST['ecityTitle'],
            'city' => $_POST['eadd_city'],
            'state' => $_POST['eadd_state'],
            'phone'=>$_POST['editphone'],
            'zipCode' => $_POST['eadd_zip']
			);
			$updateConfigArray = array('contactUs.$.address' => $_POST['eaddress'],
            'contactUs.$.title' => $_POST['ecityTitle'],
            'contactUs.$.city' => $_POST['eadd_city'],
            'contactUs.$.state' => $_POST['eadd_state'],
            'contactUs.$.phone'=>$_POST['editphone'],
            'contactUs.$.zipCode' => $_POST['eadd_zip']);
        unset($_POST['docID']);
        $response = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set($updateArray)->update('contactUsCity');
		$response1 = $this->mongo_db->where(array('contactUs.id' => $id))->set($updateConfigArray)->update('appConfig');
        //update city colletion for payment gateway

        if ($response)
            echo json_encode(array('msg' => 'updated successfully'));
        else
            echo json_encode(array('msg' => 'Failed to update'));
        return;
    }

    function get() {
        $this->load->library('mongo_db');
        $response = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('id'))))->find_one('contactUsCity');
        echo json_encode(array('data' => $response));
        return;
    }

    function delete() {
        $this->load->library('mongo_db');
        $ids = $this->input->post('ids');
        foreach ($ids as $id) {
			$response1 = $this->mongo_db->where(array('contactUs.id' => $id))->pull("contactUs",array("id"=>$id))->update('appConfig');
            $response = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('isDeleted' => TRUE))->update('contactUsCity');
        }

        echo json_encode(array('msg' => $response));
        return;
    }

}
