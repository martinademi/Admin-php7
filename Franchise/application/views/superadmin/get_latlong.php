<?php

//echo "<script type='text/javascript'>alert('here i m');</script>";
//echo json_encode(array('test' => $_POST['Address']));


$geocode = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($_REQUEST['Address']) . '&sensor=true');

$output = json_decode($geocode);
//    $message = "Restaurant is closed this time. Try again later.";
//echo "<script type='text/javascript'>alert('$geocode');</script>";
$latlong[0] = $output->results[0]->geometry->location->lat;
$latlong[1] = $output->results[0]->geometry->location->lng;
echo json_encode(array('Lat' => $latlong[0], 'Long' => $latlong[1]));
?>
