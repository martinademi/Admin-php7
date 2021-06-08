<?php

error_reporting(false);
if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Loginmodel extends CI_Model {

      function SetSeesionFromAdmin($BizId = '') {

        $this->load->library('mongo_db');

        $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($BizId)))->get('Franchise');

        foreach ($cursor as $data) {
            $ProfilePic = $data['ImageUrl'];
            $name = $data['MasterName'];
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
    
     function ValidateSuperAdmin() {

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

  
}

?>
