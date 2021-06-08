<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");
//require __DIR__ . '/../../vendor/autoload.php';//Composer installed

class Dashboard_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
         $this->load->library('mongo_db');
    }

    function get_trip_chart_data() {
       
        
        $max_days = 30;
        $toDate = time();
        $fromDate = strtotime('-' . $max_days . ' day', $toDate);

        $statusArr = [10, 3, 4, 11];
        

        $aggregateObj = array(
            array(
                '$match' => array(
                    'status' => array('$in' => $statusArr),
                    'timpeStamp_booking_time' => array('$gte' => $fromDate, '$lte' => $toDate)
                )
            ),
            array(
                '$project' => array(
                    'status' => '$status',
                    'date' =>  array('$add' => array(new MongoDB\BSON\UTCDateTime(0),array('$multiply' => ['$timpeStamp_booking_time', 1000])))
                )
            ),
            array(
                '$sort' => array('date' => -1)
            )
            ,
            array(
                '$group' => array(
                    '_id' => array(
                        'status' => '$status',
                        'year' => array('$year' => '$date'),
                        'month' => array('$month' => '$date'),
                        'day' => array('$dayOfMonth' => '$date')
                    ),
                    'count' => array('$sum' => 1)
                )
            )
        );
        try {

            $db= database;
            $client = new MongoDB\Client("mongodb://".username.":".password."@".hostname.":27017/".$db);
            $dataFromQuery = $client->$db->ShipmentDetails->aggregate($aggregateObj);

        } catch (Exception $ex) {
            print_r($ex);
        }
       
        $data_trips = array();
        foreach ($dataFromQuery as $data) {
            $ind = array_search((int) $data['_id']['status'], $statusArr);
            $data_trips[$ind][strtotime($data['_id']['year'] . "-" . $data['_id']['month'] . "-" . $data['_id']['day'])] = $data['count'];
        }

        $dataToSend = array(
            array(
                'key' => 'Completed Jobs',
                'values' => array()
            ),
            array(
                'key' => 'Passenger Cancelled',
                'values' => array()
            ),
            array(
                'key' => 'Driver Cancelled',
                'values' => array()
            ),
            array(
                'key' => 'Expired Booking',
                'values' => array()
            )
        );
        $time = strtotime(date('Y-m-d', $toDate));
        for ($i = $max_days; $i >= 0; $i--) {
            $new_time = strtotime('-' . $i . ' day', $time);
            $pushArr = array(
                $new_time * 1000,
                0
            );
            foreach ($dataToSend as $key => $value) {
                $pushArr[1] = 0;
                if (isset($data_trips[$key][$new_time]))
                    $pushArr[1] = $data_trips[$key][$new_time];

                $dataToSend[$key]['values'][] = $pushArr;
            }
        }
        echo json_encode($dataToSend);
    }

}
