<?php

class AppVersionsModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
//        $this->load->library('mongo_db');
//        $this->load->database();
        $this->load->library('CallAPI');
    }

//    function datatable_appVersions($param = '') {
//        $this->load->library('mongo_db');
//        $this->load->library('Datatables');
//        $this->load->library('table');
//
//
//        //Serachable feilds
//        $_POST['iColumns'] = 1;
//        $_POST['mDataProp_0'] = "versionNo";
//
//        switch ($param) {
//            case 1: $condtion = array('platform' => 'ios', 'appType' => 'driver');
//                break;
//            case 2: $condtion = array('platform' => 'ios', 'appType' => 'customer');
//                break;
//            case 3: $condtion = array('platform' => 'android', 'appType' => 'driver');
//                break;
//            case 4: $condtion = array('platform' => 'android', 'appType' => 'customer');
//                break;
//        }
//
//
//        $respo = $this->datatables->datatable_mongodb('appVersions', $condtion);
//        $aaData = $respo["aaData"];
//        $datatosend = array();
//
//        foreach ($aaData as $value) {
//
//            $arr = array();
//            $arr[] = '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/appVersions/showAllUsersAppVersion/' . $value['versionNo'] . '/' . $param . '">' . $value['versionNo'] . '</a>';
//            $arr[] = date('j-M-Y h:i:a', $value['date']);
//            $arr[] = ($value['mandatory'] == TRUE) ? '<span style="color:#1ABB9C;font-weight:600;">Yes</span>' : '<span style="color:indianred;font-weight:600;">No</span>';
//            $datatosend[] = $arr;
//        }
//        $respo["aaData"] = $datatosend;
//        echo json_encode($respo);
//    }
    function datatable_appVersions($param = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');


        //Serachable feilds
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "versionNo";

        switch ($param) {
            case '21':
                $url = APILink . 'logs/appVersion/' . $param;
                $respo = json_decode($this->callapi->CallAPI('GET', $url), true);
                break;
            case '22': $url = APILink . 'logs/appVersion/' . $param;
                $respo = json_decode($this->callapi->CallAPI('GET', $url), true);
                break;
            case '23': $url = APILink . 'logs/appVersion/' . $param;
                $respo = json_decode($this->callapi->CallAPI('GET', $url), true);
                break;
            case '11': $url = APILink . 'logs/appVersion/' . $param;
                $respo = json_decode($this->callapi->CallAPI('GET', $url), true);
                break;
            case '12': $url = APILink . 'logs/appVersion/' . $param;
                $respo = json_decode($this->callapi->CallAPI('GET', $url), true);
                break;
            case '13': $url = APILink . 'logs/appVersion/' . $param;
                $respo = json_decode($this->callapi->CallAPI('GET', $url), true);
                break;
        }
//        print_r($respo);die;

        $aaData = $respo['data'];
        $datatosend = array();

        foreach ($aaData as $value) {
            $count = 0;
            foreach ($value['versions'] as $version) {
                $count++;


                $arr = array();
                $arr[] = '<a style="cursor: pointer;" href="' . base_url() . 'index.php?/appVersions/showAllUsersAppVersion/' . $version['version'] . '/' . $param . '">' . $version['version'] . '</a>';
                //$arr[] = date('j-M-Y h:i:s A', $version['timestamp']);
                $arr[] = date('d-M-Y h:i:s a ', ($value['timestamp']) - ($this->session->userdata('timeOffset') * 60));

                if (count($value['versions']) == $count) {
                    if ($version['mandatory'] == TRUE)
                        $arr[] = '<div class="switch" type="'.$param.'" versionNo="'.$version['version'].'" data-id="' . $value['_id']. '" style="margin-top: 14px;float: left;"><input id="' . $value['_id'] . '"  class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;" checked><label for="' . $value['_id']. '"></label></div>';
                    else
                        $arr[] = '<div class="switch" type="'.$param.'" versionNo="'.$version['version'].'" data-id="' . $value['_id']. '" style="margin-top: 14px;float: left;"><input id="' . $value['_id']. '"  class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;"><label for="' . $value['_id']. '"></label></div>';
                } else
                    $arr[] = ($version['mandatory'] == TRUE) ? '<span style="color:#1ABB9C;font-weight:600;">Yes</span>' : '<span style="color:indianred;font-weight:600;">No</span>';


                $datatosend[] = $arr;
            }
        }
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function datatable_showAllUsersAppVersion($appversion = '', $param = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        //Serachable feilds
        $_POST['iColumns'] = 6;
        $_POST['mDataProp_0'] = "firstName";
        $_POST['mDataProp_1'] = "lastName";
        $_POST['mDataProp_1'] = "name";
        $_POST['mDataProp_2'] = "mobile";
        $_POST['mDataProp_2'] = "phone";
        $_POST['mDataProp_3'] = "email";

//        switch ($param) {
//            case 21: $condtion = array('platform' => 'ios', 'app_version' => $appversion);
//                $collectionName = 'masters';
//                break;
//            case 22: $condtion = array('platform' => 'ios', 'app_version' => $appversion);
//                $collectionName = 'slaves';
//                break;
//            case 11: $condtion = array('app_version' => $appversion);
//                $collectionName = 'masters';
//                break;
//            case 12: $condtion = array('platform' => 'android', 'app_version' => $appversion);
//                $collectionName = 'slaves';
//                break;
//        }

        $url = APILink . 'logs/versions/' . $param.'/'.$appversion.'/'.$_POST['iDisplayStart'].'/'.$_POST['iDisplayLength'];
        $respo = json_decode($this->callapi->CallAPI('GET', $url, array()),true);
        
      
        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {

            $arr = array();
            $arr[] = $value['name'];
            $arr[] = $value['email'];
            $arr[] = $value['phone'];
            $arr[] = '<button class="deviceLogs btn btn-info" style="width: 45px;"  mas_id="'.$value['_id'].'">View</button>';
            $datatosend[] = $arr;
        }
        
        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    //Now not using
//    function addAppVersion($param = '') {
//        $this->load->library('mongo_db');
//
//        $arr = $_POST;
//        $arr['date'] = strtotime($this->input->post('date'));
//        $arr['mandatory'] = FALSE;
//        if ($this->input->post('mandatory') == 'on')
//            $arr['mandatory'] = TRUE;
//
//        $res = $this->mongo_db->insert('appVersions', $arr);
//        if ($res)
//            echo json_encode(array('flag' => 0, 'data' => $res));
//    }

}
