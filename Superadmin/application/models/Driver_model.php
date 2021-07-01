<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Driver_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('CallAPI');
    }

    function datatable_shiftLogs($driverID = '') {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $respo = $this->datatables->datatable_mongodb('locationLogs', array('master' => new MongoDB\BSON\ObjectID($driverID)));
        $aaData = $respo["aaData"];
        $datatosend = array();


//        foreach ($aaData as $value) {

        $arr = array();
        $arr[] = '1';
        $arr[] = '00:30';
        $arr[] = '02:30';
        $arr[] = '2 Hour';
        $datatosend[] = $arr;

        $arr = array();
        $arr[] = '2';
        $arr[] = '05:30';
        $arr[] = '09:30';
        $arr[] = '4 Hour';
        $datatosend[] = $arr;

        $arr = array();
        $arr[] = '3';
        $arr[] = '15:30';
        $arr[] = '22:30';
        $arr[] = '7 Hour';
        $datatosend[] = $arr;
//        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function getDriver($driverID = '') {
        $this->load->library('mongo_db');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($driverID)))->find_one('driver');
        return $result;
    }

    function getShiftLogs() {
        $this->load->library('Datatables');
        //API CALL
        $url = APILink . 'admin/shiftlogs';
        if ($this->input->post('to') != '')
            $r = $this->callapi->CallAPI('POST', $url, array('userId' => $this->input->post('masterId'), 'from' => $this->input->post('from'), 'to' => $this->input->post('to')));
        else
            $r = $this->callapi->CallAPI('POST', $url, array('userId' => $this->input->post('masterId'), 'from' => $this->input->post('from')));

        $jsonResponse = json_decode($r, true);

        foreach ($jsonResponse['data'] as $result) {
            
               //Total Online time
                $timeAgo = $this->datatables->secondsToTime($result['totalOnline']);

                $totalOnlineTime =  $timeAgo['m'] . ' Min';
                if ((int) $timeAgo['h'] > 0)
                    $totalOnlineTime = $timeAgo['h'] . ' Hour ' . $totalOnlineTime;
         
            foreach ($result['shifts'] as $shifts) {
                //duration 
                $timeAgo = $this->datatables->secondsToTime($shifts['d']);
                $diffTime = $timeAgo['s'] . ' Sec';
                if ((int) $timeAgo['m'] > 0)
                    $diffTime =  $timeAgo['m'] . ' Min '.$diffTime;
                if ((int) $timeAgo['h'] > 0)
                    $diffTime = $timeAgo['h'] . ' Hour ' . $diffTime;
                
             

                $shiftsArr[] = array('st' => date('Y-m-d H:i:s', $shifts['s']), 'end' => date('Y-m-d H:i:s', $shifts['e']), 'dur' => $diffTime,'totalOnlineTime'=>$totalOnlineTime,'stTime'=>date('h:i: A', $shifts['s']), 'endTime' => date('h:i A', $shifts['e']));
            }
              
        }
        echo json_encode(array('response' => $shiftsArr));
    }

}
