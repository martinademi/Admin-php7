<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$m = new MongoClient();
$db = $m->roadyo_live;
$location = $db->selectCollection('location');
$userDet = $location->findOne(array('user' => (int) $_REQUEST['uid']));

if($userDet['status'] != 3){
    $data['status'] = 2;
}
else{
    $data['status'] = 1;
}


//echo 'data:'. json_encode($data)."\n\n";
//echo "data:".{$booking};
//echo json_encode(array('data' => $data));






echo 'data:'. json_encode($data)."\n\n";
//echo "data:".{$booking};
//echo json_encode(array('data' => '0'));
flush();
?>