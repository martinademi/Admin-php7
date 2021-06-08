<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'S3.php';

class Commonutilitymodel extends CI_Model {

    public function __construct() {
        parent::__construct();
//        $this->load->config('config');
        $this->load->library('session');
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('S3');
        $this->load->library('table');
      
    }
//    function uploadImageToAmazone1($fname, $pre, $folder_name) {
//       $uploadFile = $_FILES[$fname]['name']; // filename to get file's extension
//        $size = $_FILES[$fname]['size'];
//        $ext = substr($uploadFile, strrpos($uploadFile, '.') + 1);
//        $rename_file = $pre . "_" . time() . "." . $ext;
//        $uploadFile = $_FILES[$fname]['tmp_name'];
//
//        $upload_type =  'AMAZONE';
//
//        if ($upload_type == 'AMAZONE') {
//            
//    
//            
//            $flag = FALSE;
//            $bucketName = AMAZON_S3_BUCKET_NAME;
//
//            if (!file_exists($uploadFile) || !is_file($uploadFile)) {
//                return array('msg' => '2', 'folder' => 'no file selected' . $name);
//            }
//            if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll')) {
//                return array('msg' => '2', 'folder' => 'CURL Not Loaded');
//            }
//            if (AMAZON_AWS_ACCESS_KEY == 'change-this' || AMAZON_AWS_AUTH_SECRET == 'change-this') {
//                return array('msg' => '2', 'folder' => 'Invalid AWS Keys');
//            }
//            // Instantiate the class
//            $s3 = new S3(AMAZON_AWS_ACCESS_KEY, AMAZON_AWS_AUTH_SECRET);
////            print_r($s3);die;
//            $result = $s3->putObjectFile($uploadFile, $bucketName, $folder_name . '/' . $rename_file, S3::ACL_PUBLIC_READ);
// 
//            //// Put our file (also with public read access)
//            if ($result) {
//                $flag = true;
//            }
//
//            if ($flag) {
//                return array('msg' => '1', 'fileName' => 'https://s3.amazonaws.com/' . $bucketName . '/' . $folder_name . '/' . $rename_file);
////                return array('msg' => '1', 'fileName' => 'https://dlvqdo6lna6y.cloudfront.net/' . $folder_name . '/' . $rename_file);
//            } else {
//                return array('msg' => '2', 'fileName' => $folder_name);
//            }
//        } else {
//            $project_folder = $this->CI->config->item('PROJECT_DIRECTORY');
//
//            $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/' . $project_folder . '/images/' . $folder_name . "/";
//
//            if (!file_exists($target_dir)) {
//                mkdir($target_dir, 0777, true);
//            }
//
//            if (move_uploaded_file($uploadFile, $target_dir . $rename_file)) {
//                return array('msg' => '1', 'fileName' => base_url() . 'images/' . $folder_name . "/" . $rename_file);
//            } else {
//                return array('msg' => '2', 'fileName' => $folder_name);
//            }
//        }
//
//   
//}
    
    function uploadImageToAmazone() {
        $name = $_FILES['OtherPhoto']['name']; // filename to get file's extension
        $size = $_FILES['OtherPhoto']['size'];
        
        $fold_name = $_REQUEST['folder'];
        $type = $_REQUEST['type'];

        $ext = substr($name, strrpos($name, '.') + 1);

        $currentDate = getdate();
        $rename_file = "file" . $currentDate['year'] . $currentDate['mon'] . $currentDate['mday'] . $currentDate['hours'] . $currentDate['minutes'] . $currentDate['seconds'] . "." . $ext;
        $flag = FALSE;

        $tmp1 = $_FILES['OtherPhoto']['tmp_name'];

        $uploadFile = $tmp1;
        $bucketName = AMAZON_S3_BUCKET_NAME;
        
//        print_r($uploadFile);
//        die;
        if (!file_exists($uploadFile) || !is_file($uploadFile)) {
            echo 'if-1';
            exit("\nERROR: No such file: $uploadFile\n\n");
        }
        if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll')) {
            exit("\nERROR: CURL extension not loaded\n\n");
        }

        if (AMAZON_AWS_ACCESS_KEY == 'change-this' || AMAZON_AWS_AUTH_SECRET == 'change-this') {
            exit("\nERROR: AWS access information required\n\nPlease edit the following lines in this file:\n\n" .
                    "define('AMAZON_AWS_ACCESS_KEY', 'change-me');\ndefine('AMAZON_AWS_AUTH_SECRET', 'change-me');\n\n");
        }


        // Instantiate the class
        $s3 = new S3(AMAZON_AWS_ACCESS_KEY, AMAZON_AWS_AUTH_SECRET);
//        print_r($uploadFile); die;

        //// Put our file (also with public read access)
        if ($s3->putObjectFile($uploadFile, $bucketName, $type . '/' . $fold_name . '/' . $rename_file, S3::ACL_PUBLIC_READ, array("Cache-Control" => "max-age=864000", "Expires" => gmdate("D, d M Y H:i:s T", time() + 864000)),"image/jpeg")) {
            $flag = true;
        }

        if ($flag) {
            echo json_encode(array('msg' => '1', 'fileName' => AMAZON_URL.$type . '/' . $fold_name . '/' . $rename_file));
        } else {
            echo json_encode(array('msg' => '2', 'folder' => $fold_name));
        }
        // return;
    }
    function uploadPDFToAmazone() {
        $name = $_FILES['OtherPhoto']['name']; // filename to get file's extension
        $size = $_FILES['OtherPhoto']['size'];
        
        $fold_name = $_REQUEST['folder'];
        $type = $_REQUEST['type'];

        $ext = substr($name, strrpos($name, '.') + 1);

        $currentDate = getdate();
        $rename_file = "file" . $currentDate['year'] . $currentDate['mon'] . $currentDate['mday'] . $currentDate['hours'] . $currentDate['minutes'] . $currentDate['seconds'] . "." . $ext;
        $flag = FALSE;

        $tmp1 = $_FILES['OtherPhoto']['tmp_name'];

        $uploadFile = $tmp1;
        $bucketName = AMAZON_S3_BUCKET_NAME;
        
//        print_r($uploadFile);
//        die;
        if (!file_exists($uploadFile) || !is_file($uploadFile)) {
            echo 'if-1';
            exit("\nERROR: No such file: $uploadFile\n\n");
        }
        if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll')) {
            exit("\nERROR: CURL extension not loaded\n\n");
        }

        if (AMAZON_AWS_ACCESS_KEY == 'change-this' || AMAZON_AWS_AUTH_SECRET == 'change-this') {
            exit("\nERROR: AWS access information required\n\nPlease edit the following lines in this file:\n\n" .
                    "define('AMAZON_AWS_ACCESS_KEY', 'change-me');\ndefine('AMAZON_AWS_AUTH_SECRET', 'change-me');\n\n");
        }


        // Instantiate the class
        $s3 = new S3(AMAZON_AWS_ACCESS_KEY, AMAZON_AWS_AUTH_SECRET);
    //    print_r(AMAZON_AWS_ACCESS_KEY, AMAZON_AWS_AUTH_SECRET); die;

        //// Put our file (also with public read access)
        if ($s3->putObjectFile($uploadFile, $bucketName, $type . '/' . $fold_name . '/' . $rename_file, S3::ACL_PUBLIC_READ)) {
            $flag = true;
        }

        if ($flag) {
            echo json_encode(array('msg' => '1', 'fileName' => AMAZON_URLPDF.$bucketName . '/'. $type . '/' . $fold_name . '/' . $rename_file));
        } else {
            echo json_encode(array('msg' => '2', 'folder' => $fold_name));
        }
        // return;
    }
}

?>
