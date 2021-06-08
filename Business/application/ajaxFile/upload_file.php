<?php

/*
 * For more details refer->    amazon_s3_php/example.php
 * 
 * vinay
  AKIAJQOFVZTEZ7BA4B4Q
  FK8jaSo9p+s6pgsmoNccwRIefVv/GE2kyHIMxRGp
 * patel
  AKIAJVBH46WUTDMIJHGQ
  W4SSFTsWFSkdxD+AJtSCPDLjVhN7TNmKi6kW+scL
 *  */

require_once 'S3.php';

function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if ($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if ($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if ($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if ($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

$ip = get_client_ip(); // the IP address to query
$query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));









$name = $_FILES['myfile']['name']; // filename to get file's extension
$size = $_FILES['myfile']['size'];

$fold_name = $_REQUEST['uploadType'];
$school_id = $_REQUEST['school_id'];

$ext = substr($name, strrpos($name, '.') + 1);

//$ext_arr = array('png','jpg','gif');
//$filepath = 'file_uploads/' . $fold_name . '/';

$dat = getdate();
//echo $dat['year'].$dat['mon'].$dat['mday'].$dat['hours'].$dat['minutes'];
$rename_file = "file" . $dat['year'] . $dat['mon'] . $dat['mday'] . $dat['hours'] . $dat['minutes'] . $dat['seconds'] . "." . $ext;

//$file_to_open = $filepath . $rename_pic;
$tmp1 = $_FILES['myfile']['tmp_name'];
//$move = move_uploaded_file($tmp1, $file_to_open);

$flag = FALSE;

// AWS access info
if (!defined('awsAccessKey'))
    define('awsAccessKey', 'AKIAJQIRAYGRWQXSRRLQ');
if (!defined('awsSecretKey'))
    define('awsSecretKey', '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');

$uploadFile = $tmp1;

//echo $uploadFile . '<br>';
$bucketName = 'tebseapp';
$folder = "images";
//echo json_encode(array('msg' => '2', 'folder' => $folder));




// Check if our upload file exists
if (!file_exists($uploadFile) || !is_file($uploadFile))
    exit("\nERROR: No such file: $uploadFile\n\n");

// Check for CURL
if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll'))
    exit("\nERROR: CURL extension not loaded\n\n");

// Pointless without your keys!
if (awsAccessKey == 'change-this' || awsSecretKey == 'change-this')
    exit("\nERROR: AWS access information required\n\nPlease edit the following lines in this file:\n\n" .
            "define('awsAccessKey', 'change-me');\ndefine('awsSecretKey', 'change-me');\n\n");

// Instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

// Put our file (also with public read access)
if ($s3->putObjectFile($uploadFile, $bucketName, $folder . '/' . $rename_file, S3::ACL_PUBLIC_READ)) {
    $flag = true;
}

if ($flag) {
    echo json_encode(array('msg' => '1', 'fileName' => $bucketName . '/' . $folder . '/' . $rename_file));
} else {
    echo json_encode(array('msg' => '2', 'folder' => $uploadFile . '--' . $bucketName . '--' . $rename_file));
}

