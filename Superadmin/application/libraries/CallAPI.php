<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Ignited Datatables
 *
 * This is a wrapper class/library based on the native Datatables server-side implementation by Allan Jardine
 * found at http://datatables.net/examples/data_sources/server_side.html for CodeIgniter
 *
 * @package    CodeIgniter
 * @subpackage libraries
 * @category   library
 * @version    0.7
 * @author     Vincent Bambico <metal.conspiracy@gmail.com>
 *             Yusuf Ozdemir <yusuf@ozdemir.be>
 * @link       http://codeigniter.com/forums/viewthread/160896/
 */
class CallAPI {

    /**
     * Global container variables for chained argument results
     *
     */
    protected $ci;

    public function __construct() {
        $this->ci = & get_instance();
        $this->counter = 1;
    }

    // Method: POST, PUT, GET etc
    // Data: array("param" => "value")
    public function CallAPI($method, $url, $data = false , $headerData=false) {
        $curl = curl_init();
        $data_string = json_encode($data);

        $header = array(
            "cache-control: no-cache",
            "Content-Type: application/json", 
            "language: en"
            
        );
        if($headerData){
            $header[] = 'authorization: '.$headerData['authorization']; // array_merge($header,$headerData);
        }
        switch ($method) {
            case "POST":
                $header[] = 'Content-Length: ' . strlen($data_string);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                break;
            case "PATCH":
                $header[] = 'Content-Length: ' . strlen($data_string);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data_string));
        }

        try {
            // Optional Authentication:
            
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

            // $result = curl_exec($curl);
            // curl_close($curl);
            // return $result;
            if($method!='GET'){
                $response = json_decode(curl_exec($curl), true);
                $response['statusCode'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                return json_encode($response);
             }else{
                $result = curl_exec($curl);
                curl_close($curl);
                return $result;               
             }      

        } catch (Exception $e) {
            return $e;
        }
    }

}
