<?php

error_reporting(false);
if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class Dashboardmodal extends CI_Model {


    function getDashbordData($BizId = '') {
      $this->load->library('mongo_db');

        $tz_date = new DateTime("now", new DateTimeZone('asia/kolkata'));
        $tz_date->format('Y-m-d H:m:s');

        $date = $tz_date->format('Y-m-d H:m:s');
        $dateOnly = $tz_date->format('Y-m-d');
        $SOM = date('Y-m-01') . ' 00:00:01';
        $EOM = date('Y-m-t') . ' 23:59:59';

        $EOW = date("Y-m-d", strtotime(date("Y") . 'W' . date('W') . "7"));
        $SOW = date("Y-m-d", strtotime(date("Y") . 'W' . date('W') . "1")) . ' 00:00:01';
        $SOD = $dateOnly . ' 00:00:01';
        $EOD = $dateOnly . ' 23:59:59';

        $TodayTotalOrders = 0;
        $WeekTotalOrders = 0;
        $MonthTotalOrders = 0;
        $TotalOrders = 0;
        $TOdayTotalErnings = 0;
        $WeekTotalErnings = 0;
        $MonthTotalErnings = 0;
        $TotalErnings = 0;
        
//      print_r($BizId); die;
      
      $franchisedata = $this->mongo_db->where(array('Master'=>$BizId))->get('Stores');
      foreach ($franchisedata as $frdata){
       
      
        $where = array('$and' => array(array('$or' => array(array('status' => 4),array('status' => 14))),array('storeId' => (string)$frdata['_id'])));
      
        $detailstoday = $this->mongo_db->where($where)->get('Orders');
        
//        $detailstoday = $this->mongo_db->get_where('Orders', array('$and' => array(array('status' => 4), array('storeId' => $BizId),array('order_datetime'=>array('$gte'=>$SOD)),array('order_datetime'=>array('$lte'=>$EOD)))));
        foreach ($detailstoday as $data) {
          
            foreach ($data['eventLog'] as $event) {
                //life time
                if ($event['status'] == "4" || $event['status'] == "14") {
                    $TotalOrders++;
                    $TotalErnings = (double) $TotalErnings + (double) $data['total_amount'];
                }
                // today
                if (($event['status'] == "4" || $event['status'] == "14") && ($event['datetime'] >= $SOD && $event['datetime'] <= $EOD)) {
                    $TodayTotalOrders++;
                    $TOdayTotalErnings = (double) $TOdayTotalErnings + (double) $data['total_amount'];
                }
                // weekly
                if (($event['status'] == "4" || $event['status'] == "14") && ($event['datetime'] >= $SOW && $event['datetime'] <= $EOW)) {
                    $WeekTotalOrders++;
                    $WeekTotalErnings = (double) $WeekTotalErnings + (double) $data['total_amount'];
                }
                //monthly
                if (($event['status'] == "4" || $event['status'] == "14") && ($event['datetime'] >= $SOM && $event['datetime'] <= $EOM)) {
                    $MonthTotalOrders++;
                    $MonthTotalErnings = (double) $MonthTotalErnings + (double) $data['total_amount'];
                }
            }
        }
     }

        $detail = array('TodayTotalOrders' => $TodayTotalOrders, 'TOdayTotalErnings' => round($TOdayTotalErnings, 2),
            'WeekTotalOrders' => $WeekTotalOrders, 'WeekTotalErnings' => round($WeekTotalErnings, 2),
            'MonthTotalOrders' => $MonthTotalOrders, 'MonthTotalErnings' => round($MonthTotalErnings, 2),
            'TotalOrders' => $TotalOrders, 'TotalErnings' => round($TotalErnings, 2), 'SOW' => $SOM, 'EOW' => $EOM);

//        print_r($detail);
//        die;
        return $detail;
     }

  

}

?>
