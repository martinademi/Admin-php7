<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$time = date('r');




 $serverName = "localhost";
     $userName = "root";
     $pass = "3Embed123";
     $database = "roadyo_live";




        $conn = mysql_connect($serverName, $userName, $pass);

        if ($conn) {
            if (mysql_select_db($database, $conn)) {
                $booking = 1;
                $today = date('Y-m-d');
               mysql_query("SELECT * FROM appointment WHERE appointment_dt like  '".$today."%' and status in  (1,2,3,4,5,6,7,8) and appt_type = 2 ");
                $data['booking'] = mysql_affected_rows();


            }
        } else {
            $this->flag_conn = 1;
            die(print_r(mysql_error(), true));
        }







echo 'data:'. json_encode($data)."\n\n";
//echo "data:".{$booking};
//echo json_encode(array('data' => '0'));
flush();
?>