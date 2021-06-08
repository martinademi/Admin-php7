<?php

require __DIR__ . '/../vendor/autoload.php';

// $collection = new MongoDB\Client("mongodb://Dayrunner:ShmdeUGtdbwg5esN@localhost:27017/Dayrunner");
try {

    $client = new MongoDB\Client("mongodb://Dayrunner:ShmdeUGtdbwg5esN@localhost:27017/Dayrunner");

//    $r = $client->Dayrunner->ShipmentDetails->aggregate([array('$match' => array('dispatched.DriverId' => new MongoDB\BSON\ObjectID("5976f1e8750e20ca6b1fda64"))), 
//        array('$unwind' => '$dispatched'), array('$match' => array('dispatched.DriverId' => new MongoDB\BSON\ObjectID("5976f1e8750e20ca6b1fda64"))), array('$project' => array('id' => '$dispatched.DriverId', 'status' => '$dispatched.Status')), array('$group' => array(_id => '$status', count => array('$sum' => 1)))]);
    $r = $client->Dayrunner->ShipmentDetails->aggregate([array('$group'=>array(_id=>'$slaveEmail',count=>array('$sum'=>1))),array('$sort'=>array('count'=>-1))]);
    
    echo '<pre>';
    foreach ($r as $a)
        print_r($a);
    echo '</pre>';
} catch (Exception $ex) {
    print_r($ex);
}


exit();
?>