<?php

error_reporting(false);
if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

require_once 'S3.php';
class Profilemodel extends CI_Model {

    public function getProfileData($productId = '') {
        $this->load->library('mongo_db');
        $cursor = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($productId)))->find_one('franchise');
        return $cursor;
    }


    public function getAllCategories() {
        $this->load->library('mongo_db');
//        echo '1';
        $cursor = $this->mongo_db->get('storeCategory');
//           echo '1';
        $entities = array();
        $i = 0;

        foreach ($cursor as $data) {
            $entities[] = $data;
            $i++;
        }
        return $entities;
    }

    public function getAllsubCategories() {
        $this->load->library('mongo_db');
//        echo '1';
        $cursor = $this->mongo_db->get('storeSubCategory');
//           echo '1';
        $entities = array();
        $i = 0;

        foreach ($cursor as $data) {
            $entities[] = $data;
            $i++;
        }
        return $entities;
    }
    
    function GetCountryCities() {
        $this->load->library('mongo_db');
        $country = $this->mongo_db->get("cities");
        $res = array();
        foreach ($country as $coun) {
            $res[] = $coun;
        }
        return $res;
    }
    
      public function getCityList() {
           $this->load->library('mongo_db');
        $val = $this->input->post('val');

        $cursor = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($val)))->find_one('cities');
        $res = array();
        foreach ($cursor['cities'] as $d) {

            $res[] = $d;
        }

        echo json_encode($res);
    }
    
     public function getSubcatList() {
         $this->load->library('mongo_db');
        $val = $this->input->post('val');
//        print_r($val); die;
        $cursor = $this->mongo_db->where(array("categoryId" => $val))->get('storeSubCategory');
        $res = array();
        foreach ($cursor as $d) {
            $res[] = $d;
        }
        echo json_encode($res);
    }
    
     function get_city() {
        $this->load->library('mongo_db');
        $countryid = $this->input->post('country');
        $CityId = $this->input->post('CityId');
        
        $country = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($countryid)))->find_one('cities');
        
        $entities = ' <select class="form-control" id="city" name="FData[cityId]"  required>
                                                <option value="0">Select City</option>';
        if($country){
        foreach ($country['cities'] as $cityData) {
            if ($CityId == $cityData['cityId']['$oid']) {
                $entities .= ' <option value="' . $cityData['cityId']['$oid'] . '" selected>' . $cityData['cityName'] . '</option>';
            } else {
                $entities .= ' <option value="' . $cityData['cityId']['$oid'] . '" >' . $cityData['cityName'] . '</option>';
            }
        }
        }
        $entities .= ' </select>';

        return $entities;
    }
    
    function getZonesWithCities() {

        $this->load->library('mongo_db');
        $val = $this->input->post('val');
        $cursor = $this->mongo_db->where(array("city_ID" => $val,'status'=>1))->get('zones');
        if ($cursor) {
            $entitiesData = array();
            $entityData = [];
            foreach ($cursor as $dat) {
                $entityData['id'] = $dat['_id']['$oid'];
                $entityData['title'] = $dat['title'];
                array_push($entitiesData, $entityData);
            }

            echo json_encode(array('data' => $entitiesData));
        } else {
            $entities = array();
            $entities = '<option value="">Select Zones</option>';
            $entities .= '<option data-name="" value="">' . 'No zones to select' . '</option>';
            echo $entities;
        }
    }
    
    
    function UpdateProfile() {

        $this->load->library('mongo_db');
        $BusinessId = $this->input->post("BusinessId");
        
        $senddata = $this->input->post("FData");
       
       // $data['coordinates']['longitude'] = (double) $data['longitude'];
        //$data['coordinates']['latitude'] = (double) $data['latitude'];
        
        unset($data['latitude'],$data['longitude']);
        
        
        if ($senddata['autoApproval'] == 'on') {
            $senddata['autoApproval'] = 1; // enable
            $senddata['autoApprovalMsg'] = "Enable";
        } else {
            $senddata['autoApproval'] = 0; // disable
            $senddata['autoApprovalMsg'] = "Disable";
        }
       
        
        if ($senddata['description']) {
            $senddata['description'] = $senddata['description'];
        } else {
            $senddata['description'] = [];
        }
        if ($senddata['billingAddress']) {
            $senddata['billingAddress'] = $senddata['billingAddress'];
        } else {
            $senddata['billingAddress'] = '';
        }
        
        $lang = $this->mongo_db->get('lang_hlp');
        $lanCodeArr = [];
        $lanIdArr = [];
        foreach ($lang as $lan) {
            $lanCodeArr[0] = "en";
            $lanIdArr[0] = "0";
            if ($lan['Active'] == 1) {
                array_push($lanCodeArr, $lan['langCode']);
                array_push($lanIdArr, $lan['lan_id']);
            }
        }

        if (count($lanCodeArr) == count($senddata['franchiseName'])) {
            $senddata['name'] = array_combine($lanCodeArr, $senddata['franchiseName']);
        } else if (count($lanCodeArr) < count($senddata['franchiseName'])) {
            $senddata['name']['en'] = $senddata['franchiseName'][0];

            foreach ($senddata['franchiseName'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $senddata['name'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $senddata['name'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $senddata['name']['en'] = $senddata['franchiseName'][0];
        }

        if (count($lanCodeArr) == count($senddata['franchiseDescription'])) {
            $senddata['description'] = array_combine($lanCodeArr, $senddata['franchiseDescription']);
        } else if (count($lanCodeArr) < count($senddata['franchiseDescription'])) {
            $senddata['description']['en'] = $senddata['franchiseDescription'][0];

            foreach ($senddata['franchiseDescription'] as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']) {
                            $senddata['description'][$lan['langCode']] = $val;
                        }
                    } else {
                        if ($key == $lan['lan_id']) {
                            $senddata['description'][$lan['langCode']] = $val;
                        }
                    }
                }
            }
        } else {
            $senddata['description']['en'] = $senddata['franchiseDescription'][0];
        }
        
        $this->session->set_userdata('profileimg', $senddata['profileLogos']['logoImage']);
        
        $senddata['profileLogos']['logoImage'] = $senddata['profileLogos']['logoImage'];
        if ($senddata['profileLogos']['seoAllText']) {
            $senddata['profileLogos']['seoAllText'] = $senddata['profileLogos']['seoAllText'];
        } else {
            $senddata['profileLogos']['seoAllText'] = '';
        }
        if ($senddata['profileLogos']['seoTitle']) {
            $senddata['profileLogos']['seoTitle'] = $senddata['profileLogos']['seoTitle'];
        } else {
            $senddata['profileLogos']['seoTitle'] = '';
        }
        if ($senddata['profileLogos']['seoDescription']) {
            $senddata['profileLogos']['seoDescription'] = $senddata['profileLogos']['seoDescription'];
        } else {
            $senddata['profileLogos']['seoDescription'] = '';
        }
        if ($senddata['profileLogos']['seoKeyword']) {
            $senddata['profileLogos']['seoKeyword'] = $senddata['profileLogos']['seoKeyword'];
        } else {
            $senddata['profileLogos']['seoKeyword'] = '';
        }
        
        $senddata['bannerLogos']['bannerimage'] = $senddata['bannerLogos']['bannerimage'];
        if ($senddata['bannerLogos']['seoAllText']) {
            $senddata['bannerLogos']['seoAllText'] = $senddata['bannerLogos']['seoAllText'];
        } else {
            $senddata['bannerLogos']['seoAllText'] = '';
        }
        if ($senddata['bannerLogos']['seoTitle']) {
            $senddata['bannerLogos']['seoTitle'] = $senddata['bannerLogos']['seoTitle'];
        } else {
            $senddata['bannerLogos']['seoTitle'] = '';
        }
        if ($senddata['bannerLogos']['seoDescription']) {
            $senddata['bannerLogos']['seoDescription'] = $senddata['bannerLogos']['seoDescription'];
        } else {
            $senddata['bannerLogos']['seoDescription'] = '';
        }
        if ($senddata['bannerLogos']['seoKeyword']) {
            $senddata['bannerLogos']['seoKeyword'] = $senddata['bannerLogos']['seoKeyword'];
        } else {
            $senddata['bannerLogos']['seoKeyword'] = '';
        }
        
        if ($senddata['countryCode']) {
            $send1['code'] = explode('+', $senddata['countryCode']);
            if (count($send1['code']) > 1)
                $senddata['countryCode'] = '+' . $send1['code'][1];
            else
                $senddata['countryCode'] = '+' . $senddata['countryCode'];
        } else {
            $senddata['countryCode'] = '+91';
        }
        
        $senddata['countryId']  = (string)$senddata['countryId'] ;
      //echo '<pre>'; print_r($senddata); die;
      
        echo $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($BusinessId)))->set($senddata)->update('franchise');
        }
    
    
    // image uploading to aws
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
    }
    function get_lan_hlpText($param = '') {

        if ($param == '') {
            $where = array('Active' => 1);
            $res = $this->mongo_db->get_where('lang_hlp', $where);
        } else {
            $where = array('$and' => array(array('lan_id' => (int) $param), array('Active' => 1)));
            $res = $this->mongo_db->get_where('lang_hlp', $where);
        }
        return $res;
    }


  
}

?>
