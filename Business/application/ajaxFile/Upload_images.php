<?PHP

require_once 'S3.php';
header('Content-Type: image/png');
// AWS access info
if (!defined('awsAccessKey'))
    define('awsAccessKey', 'AKIAJQIRAYGRWQXSRRLQ');
if (!defined('awsSecretKey'))
    define('awsSecretKey', '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');
// Instantiate the class

$bucketName = 'tebseapp';
$folder = 'images';
$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
$randomString = '';
for ($i = 0; $i < 10; $i++) {
    $randomString .= $characters[rand(0, strlen($characters) - 1)];
}
$filename = 'File_' . round(microtime(true) * 1000) . '.png';

$s3 = new S3(awsAccessKey, awsSecretKey);
try {
    $imagedata = explode(',', $_POST['data']);
    // Put our file (also with public read access)
    $test = $s3->putObject(base64_decode($imagedata[1]), $bucketName, $folder . '/' . $filename, S3::ACL_PUBLIC_READ);
//    print_r(array('flag' => '0'));
    echo json_encode(array('flag' => '0', 'fileName' => 'https://s3-us-west-2.amazonaws.com/' . $bucketName . '/' . $folder . '/' . $filename));
} catch (Exception $ex) {
    echo json_encode(array('flag' => '1'));
}
?>
