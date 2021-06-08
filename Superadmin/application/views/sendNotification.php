<?php
    	require_once('PushNotifications.php');
	// Message payload
	$msg_payload = array (
		'mtitle' => 'Test push notification title',
		'mdesc' => 'Test push notification body',
	);
	
	// For Android
	$regId = 'APA91bHdOmMHiRo5jJRM1jvxmGqhComcpVFDqBcPfLVvaieHeFI9WVrwoDeVVD1nPZ82rV2DxcyVv-oMMl5CJPhVXnLrzKiacR99eQ_irrYogy7typHQDb5sg4NB8zn6rFpiBuikNuwDQzr-2abV6Gl_VWDZlJOf4w';
	// For iOS
	$deviceToken = 'ekhtPC6VDfE:APA91bHy4Ms2hggMwcq6PyxtDiDs2l7pD14HwNMNbJ-d6K7LKw2h6kq-1VPElbJh1BVK4bo2gTRDwdt_6zxFVj3ps9HtuMTbW6kpasvyEB86vMWQPnnLP3kQGfzMCJ4ycXu4Z06wHAK4';
	// For WP8
	$uri = 'http://s.notify.live.net/u/1/sin/HmQAAAD1XJMXfQ8SR0b580NcxIoD6G7hIYP9oHvjjpMC2etA7U_xy_xtSAh8tWx7Dul2AZlHqoYzsSQ8jQRQ-pQLAtKW/d2luZG93c3Bob25lZGVmYXVsdA/EKTs2gmt5BG_GB8lKdN_Rg/WuhpYBv02fAmB7tjUfF7DG9aUL4';
	
	// Replace the above variable values
	
	
//    	PushNotifications::android($msg_payload, $regId);
//    	
//    	PushNotifications::WP8($msg_payload, $uri);
        $np= new PushNotifications();
    	
    	$np->iOS($msg_payload, $deviceToken);
?>