<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 require_once '/var/www/html/Admin/admin/Superadmin/application/models/S3.php';
Class Utility_library
{

    private $CI;

    function __construct()
    {
        $this->CI =& get_instance();
    }

    public function uploadImage($fname, $pre, $folder_name) {
        /*
         *  For more details refer -> amazon_s3_php/example.php
         *  $fname = Post File Name
         *  $pre =  Prefix for File
         *  $folder_name = Folder Name to Upload
         */
        $uploadFile = $_FILES[$fname]['name']; // filename to get file's extension
        $size = $_FILES[$fname]['size'];
        $ext = substr($uploadFile, strrpos($uploadFile, '.') + 1);
        $rename_file = $pre . "_" . time() . "." . $ext;
        $uploadFile = $_FILES[$fname]['tmp_name']; 

        $upload_type = $this->CI->config->item('UPLOAD_TYPE');

        if ($upload_type == 'AMAZONE') {
             
      
            
            $flag = FALSE;
            $bucketName = AMAZON_S3_BUCKET_NAME;

            if (!file_exists($uploadFile) || !is_file($uploadFile)) {
                return array('msg' => '2', 'folder' => 'no file selected' . $name);
            }
            if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll')) {
                return array('msg' => '2', 'folder' => 'CURL Not Loaded');
            }
            if (AMAZON_AWS_ACCESS_KEY == 'change-this' || AMAZON_AWS_AUTH_SECRET == 'change-this') {
                return array('msg' => '2', 'folder' => 'Invalid AWS Keys');
            }
            // Instantiate the class
            $s3 = new S3(AMAZON_AWS_ACCESS_KEY, AMAZON_AWS_AUTH_SECRET);
//            print_r($s3);die;
            $result = $s3->putObjectFile($uploadFile, $bucketName, $folder_name . '/' . $rename_file, S3::ACL_PUBLIC_READ, array("Cache-Control" => "max-age=864000", "Expires" => gmdate("D, d M Y H:i:s T", time() + 864000)),"image/jpeg");
            print_r($result);die;
            //// Put our file (also with public read access)
            if ($result) {
                $flag = true;
            }

            if ($flag) {
//                return array('msg' => '1', 'fileName' => 'https://s3.amazonaws.com/' . $bucketName . '/' . $folder_name . '/' . $rename_file);
                return array('msg' => '1', 'fileName' => AMAZON_URL . $folder_name . '/' . $rename_file);
            } else {
                return array('msg' => '2', 'fileName' => $folder_name);
            }
        } else {
            $project_folder = $this->CI->config->item('PROJECT_DIRECTORY');

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

    public function deleteImage($imgurl,$image) {
        
        $str = (explode("/",$image));
        $imgname = $str[5];
        $imgurl = "first_level_category/".$imgname;
        $bucket = AMAZON_S3_BUCKET_NAME;
        //  $s3 = new S3('awsAccessKey', 'awsSecretKey');
        $s3 = new S3(AMAZON_AWS_ACCESS_KEY, AMAZON_AWS_AUTH_SECRET);
        
        $result = $s3->deleteObject($bucket, $imgurl);
       
            return $result;
    }

    function sendMail($template, $to, $from, $subject) {
        try {

            $mandrill = new Mandrill(MANDRILL_KEY);
            $message = array(
                'html' => ($template),
                'text' => 'Example text content',
                'subject' => $subject,
                'from_email' => $from,
                'from_name' => 'Ryland Insurence',
                'to' => $to,
                'headers' => array('Reply-To' => "abcxyz@gmail.com"),
                'important' => false,
                'track_opens' => null,
                'track_clicks' => null,
                'auto_text' => null,
                'auto_html' => null,
                'inline_css' => null,
                'url_strip_qs' => null,
                'preserve_recipients' => null,
                'view_content_link' => null,
                'bcc_address' => 'message.bcc_address@example.com',
                'tracking_domain' => null,
                'signing_domain' => null,
                'return_path_domain' => null,
                'merge' => true,
                'merge_language' => 'mailchimp',
                'metadata' => array('website' => 'www.RylandIncurence.com'),
            );

            $async = false;
            $ip_pool = 'Main Pool';
            $result = $mandrill->messages->send($message, $async, $ip_pool);
            $result['flag'] = 0;
            $result['message'] = $message;

            return true;
        } catch (Mandrill_Error $e) {
            print_r($e);
            return false;
        }
    }
}