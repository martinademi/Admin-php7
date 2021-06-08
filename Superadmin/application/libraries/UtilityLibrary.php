<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


require_once 'S3.php';

Class UtilityLibrary {

    private $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    public function uploadImage() {

        $upload_type = $this->CI->config->item('imagesUploadOn');
        if ($upload_type == 'Amazon') {

            $name = $_FILES['OtherPhoto']['name']; // filename to get file's extension
            $size = $_FILES['OtherPhoto']['size']; //OtherPhoto ->form element

            $fold_name = $_REQUEST['folder'];
            $type = $_REQUEST['type'];

            $ext = substr($name, strrpos($name, '.') + 1);


            $dat = getdate();
            $rename_file = "file" . $dat['year'] . $dat['mon'] . $dat['mday'] . $dat['hours'] . $dat['minutes'] . $dat['seconds'] . "." . $ext;
            $flag = FALSE;

//            $source_img = $_FILES['OtherPhoto']['name'];
//            $destination_img = $_FILES['OtherPhoto']['name'];
//            $d = $this->compress($source_img, $destination_img, 75);

            $tmp1 = $_FILES['OtherPhoto']['tmp_name'];

            $uploadFile = $tmp1;
            $bucketName = bucketName;


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


            //// Put our file (also with public read access)
            if ($s3->putObjectFile($uploadFile, $bucketName, $type . '/' . $fold_name . '/' . $rename_file, S3::ACL_PUBLIC_READ)) {
                $flag = true;
            }

            if ($flag) {
                echo json_encode(array('msg' => '1', 'fileName' => $bucketName . '/' . $type . '/' . $fold_name . '/' . $rename_file));
            } else {
                echo json_encode(array('msg' => '2', 'folder' => $fold_name));
            }
            return;
        } else {
            $project_folder = $this->CI->config->item('ProjectDirectory');

            $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/' . $project_folder . '/images/' . $folder_name . "/";

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            if (move_uploaded_file($uploadFile, $target_dir . $rename_file)) {
                return array('msg' => '1', 'fileName' => base_url() . 'images/' . $folder_name . "/" . $rename_file);
            } else {
                return array('msg' => '2', 'fileName' => $folder_name);
            }
        }
    }

    public function deleteImage($imgurl) {
        $url = explode(bucketName, $imgurl);

        $s3 = new S3(AMAZON_AWS_ACCESS_KEY, AMAZON_AWS_AUTH_SECRET);
        $result = $s3->deleteObject(bucketName, ltrim($url[1], '/'));

        if ($result)
            echo json_encode(array('msg' => TRUE, 'response' => $result));
        else
            echo json_encode(array('msg' => FALSE, 'response' => $result));
    }

    public function compress($source, $destination, $quality) {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);

        return $destination;
    }
    



}
