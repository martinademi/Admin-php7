<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class policymodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');
    }

    function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->where(array('Active' => 1))->get('lang_hlp');
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function update_terms() {
        $data = $_POST;
        
        
        $data['termsObj']= array();
        $data['termsObj'] = $data['terms'];
        
        foreach ($data['termsObj'] as $key => $val) {
            $dataTo='<!DOCTYPE html><head><meta charset="utf-8" /></head><html><body>'.$val.'</body></html>';
            $path = '/var/www/html/Admin/admin/Superadmin/appWebPages/Customer/';
            if (!file_exists($path . "Terms" .$key. ".html")) {
               // file_put_contents($path . "Terms" .$key. ".html", $val);
               file_put_contents($path . "Terms" .$key. ".html", $dataTo);
            }else{
                $myfile = fopen($path . "Terms" . $key . ".html", "w");
                fwrite($myfile,  $dataTo);
                fclose($myfile);
            } 
            
        }
        unset($data['terms']);
        $appdata = $this->mongo_db->where(array('for' => 'customer'))->find_one('webPageData');
         
        if (count($appdata) == 0) {
            $data['for'] = 'customer';
            $this->mongo_db->insert('webPageData', $data);
        } else {
            $this->mongo_db->where(array('for' => 'customer'))->set($data)->update('webPageData');
        }
    }

    function website_update_terms() {
        $data = $_POST;
        
        
        $data['termsObj']= array();
        $data['termsObj'] = $data['terms'];
        
        foreach ($data['termsObj'] as $key => $val) {
            $dataTo='<!DOCTYPE html><head><meta charset="utf-8" /></head><html><body>'.$val.'</body></html>';
            $path = '/var/www/html/Admin/admin/Superadmin/appWebPages/website/';
            if (!file_exists($path . "website_Terms" .$key. ".html")) {
                // file_put_contents($path . "website_Terms" .$key. ".html", $val);
                file_put_contents($path . "website_Terms" .$key. ".html", $dataTo);
                
            }else{
                $myfile = fopen($path . "website_Terms" . $key . ".html", "w");
                fwrite($myfile,  $dataTo);
                fclose($myfile);
            } 
            
        }
        unset($data['terms']);
        $appdata = $this->mongo_db->where(array('for' => 'website'))->find_one('webPageData');
         
        if (count($appdata) == 0) {
            $data['for'] = 'website';
            $this->mongo_db->insert('webPageData', $data);
            $this->mongo_db->set($data)->update('appConfig');
        } else {
            $this->mongo_db->where(array('for' => 'website'))->set($data)->update('webPageData');
            $this->mongo_db->set($data)->update('appConfig');
        }
    }

    function store_update_terms() {
        $data = $_POST;
        
        $data['termsObj']= array();
        $data['termsObj'] = $data['terms'];
        
        foreach ($data['termsObj'] as $key => $val) {
            $dataTo='<!DOCTYPE html><head><meta charset="utf-8" /></head><html><body>'.$val.'</body></html>';
            $path = '/var/www/html/Admin/admin/Superadmin/appWebPages/Store/';

            if (!file_exists($path . "store_Terms" .$key. ".html")) {
                // file_put_contents($path . "store_Terms" .$key. ".html", $val);
                file_put_contents($path . "store_Terms" .$key. ".html", $dataTo);
            }else{
                $myfile = fopen($path . "store_Terms" . $key . ".html", "w");
                fwrite($myfile,  $dataTo);
                fclose($myfile);
            } 
            
        }
        unset($data['terms']);

        $appdata = $this->mongo_db->where(array('for' => 'store'))->find_one('webPageData');
         
        if (count($appdata) == 0) {
            $data['for'] = 'store';
            $this->mongo_db->insert('webPageData', $data);
            // $this->mongo_db->set(array('termsCondition'=>$data))->update('appConfig'); 
        } else {
            $this->mongo_db->where(array('for' => 'store'))->set($data)->update('webPageData');
            // $this->mongo_db->set(array('termsCondition'=>$data))->update('appConfig');
        }
    }


    function update_dterms() {
        $data = $_POST;

        $data['termsObj']= array();
        $data['termsObj'] = $data['terms'];
        
        foreach ($data['termsObj'] as $key => $val) {
            $dataTo='<!DOCTYPE html><head><meta charset="utf-8" /></head><html><body>'.$val.'</body></html>';
            $path = '/var/www/html/Admin/admin/Superadmin/appWebPages/Driver/';
            if (!file_exists($path . "Terms" .$key. ".html")) {
                //file_put_contents($path . "Terms" .$key. ".html", $val);
                file_put_contents($path . "Terms" .$key. ".html",$dataTo);
            }else{
                $myfile = fopen($path . "Terms" . $key . ".html", "w");
                fwrite($myfile,   $dataTo);
                fclose($myfile);
            } 
            
        }
        unset($data['terms']);

         $appdata = $this->mongo_db->where(array('for' => 'driver'))->find_one('webPageData');
        if (count($appdata) == 0) {
            $data['for'] = 'driver';
            $this->mongo_db->insert('webPageData', $data);
        } else {
            $this->mongo_db->where(array('for' => 'driver'))->set($data)->update('webPageData');
        }
        
    }
    
     function update_cprivacy() {
        $data = $_POST;

        $data['privacyObj']= array();
        $data['privacyObj'] = $data['privacy'];
        
        foreach ($data['privacyObj'] as $key => $val) {
            $dataTo='<!DOCTYPE html><head><meta charset="utf-8" /></head><html><body>'.$val.'</body></html>';
            $path = '/var/www/html/Admin/admin/Superadmin/appWebPages/Customer/';
            if (!file_exists($path . "Privacy" .$key. ".html")) {
                // file_put_contents($path . "Privacy" .$key. ".html", $val);
                file_put_contents($path . "Privacy" .$key. ".html",  $dataTo);
            }else{
                $myfile = fopen($path . "Privacy" . $key . ".html", "w");
                fwrite($myfile, $dataTo);
                fclose($myfile);
            } 
            
        }
        unset($data['privacy']);

        $appdata = $this->mongo_db->where(array('for' => 'customer'))->find_one('webPageData');
        if (count($appdata) == 0) {
            $data['for'] = 'customer';
            $this->mongo_db->insert('webPageData', $data);
        } else {
            $this->mongo_db->where(array('for' => 'customer'))->set($data)->update('webPageData');
        }
    }
    function website_update_privacy() {
        $data = $_POST;
    
        $data['privacyObj']= array();
        $data['privacyObj'] = $data['privacy'];
       
        foreach ($data['privacyObj'] as $key => $val) {
            $dataTo='<!DOCTYPE html><head><meta charset="utf-8" /></head><html><body>'.$val.'</body></html>';
            $path = '/var/www/html/Admin/admin/Superadmin/appWebPages/website/';
            if (!file_exists($path . "Privacy" .$key. ".html")) {
                file_put_contents($path . "Privacy" .$key. ".html", $val);
            }else{
                $myfile = fopen($path . "Privacy" . $key . ".html", "w");
                fwrite($myfile,  $dataTo);
                fclose($myfile);
            } 
            
        }
        unset($data['privacy']);

        $appdata = $this->mongo_db->where(array('for' => 'website'))->find_one('webPageData');
         
        if (count($appdata) == 0) {
            $data['for'] = 'website';
            $this->mongo_db->insert('webPageData', $data);
            $this->mongo_db->set($data)->update('appConfig');
        } else {
            $this->mongo_db->where(array('for' => 'website'))->set($data)->update('webPageData');
            $this->mongo_db->set($data)->update('appConfig');
        }
    }


    function store_update_privacy() {
        $data = $_POST;
        $data['privacyObj']= array();
        $data['privacyObj'] = $data['privacy'];
        
        foreach ($data['privacyObj'] as $key => $val) {
            $dataTo='<!DOCTYPE html><head><meta charset="utf-8" /></head><html><body>'.$val.'</body></html>';
            $path = '/var/www/html/Admin/admin/Superadmin/appWebPages/Store/';
            if (!file_exists($path . "Privacy" .$key. ".html")) {
                // file_put_contents($path . "Privacy" .$key. ".html", $val);
                file_put_contents($path . "Privacy" .$key. ".html",  $dataTo);
            }else{
                $myfile = fopen($path . "Privacy" . $key . ".html", "w");
                fwrite($myfile,  $dataTo);
                fclose($myfile);
            } 
            
        }
        unset($data['privacy']);

        $appdata = $this->mongo_db->where(array('for' => 'store'))->find_one('webPageData');
         
        if (count($appdata) == 0) {
            $data['for'] = 'store';
            $this->mongo_db->insert('webPageData', $data);
            // $this->mongo_db->set(array("privacyPolicy"=>$data))->update('appConfig');
        } else {
            $this->mongo_db->where(array('for' => 'store'))->set($data)->update('webPageData');
            // $this->mongo_db->set(array("privacyPolicy"=>$data))->update('appConfig');
        }
    }
    
     function update_dprivacy() {
        $data = $_POST;

        $data['privacyObj']= array();
        $data['privacyObj'] = $data['privacy'];
        
        foreach ($data['privacyObj'] as $key => $val) {
            $dataTo='<!DOCTYPE html><head><meta charset="utf-8" /></head><html><body>'.$val.'</body></html>';
            $path = '/var/www/html/Admin/admin/Superadmin/appWebPages/Driver/';
            if (!file_exists($path . "Privacy" .$key. ".html")) {
                // file_put_contents($path . "Privacy" .$key. ".html", $val);
                file_put_contents($path . "Privacy" .$key. ".html",  $dataTo);
            }else{
                $myfile = fopen($path . "Privacy" . $key . ".html", "w");
                fwrite($myfile,$dataTo);
                fclose($myfile);
            } 
            
        }
        unset($data['privacy']);
        
        $appdata = $this->mongo_db->where(array('for' => 'driver'))->find_one('webPageData');
         
        if (count($appdata) == 0) {
            $data['for'] = 'driver';
            $this->mongo_db->insert('webPageData', $data);
        } else {
            $this->mongo_db->where(array('for' => 'driver'))->set($data)->update('webPageData');
        }
    }
    
    function gettermsdata($params = ''){
        $data = $this->mongo_db->where(array('for' => $params))->find_one('webPageData');
//        print_r($params); print_r($data); die;
        return $data;
    }

    function addBrand() {
        $data = $_POST;

        $data['timeStamp'] = time();
        $data['isoDate'] = $this->mongo_db->date();

        if (!$data['description']) {
            $data['description'] = [];
        }
        $cursor = $this->mongo_db->get("brands");
        $arr = [];
        $arrName = [];
        foreach ($cursor as $cdata) {
            array_push($arr, $cdata['seqId']);
            array_push($arrName, $cdata['name'][0]);
        }
        $max = max($arr);
        $data['seqId'] = $max + 1;
        $data['status'] = 1;
        $data['statusString'] = 'Active';
//         echo '<pre>'; print_r($data); die;
        if (!in_array($name[0], $arrName)) {
            $data = $this->mongo_db->insert('brands', $data);
            echo json_encode(array('data' => $data, 'flag' => 1));
        } else {
            echo json_encode(array('data' => $data, 'flag' => 0));
        }
    }

    function getBrand() {
        $Id = $this->input->post('Id');

        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->find_one('brands');

        return $data;
    }

    function editBrand() {
        $data = $_POST;
//        echo '<pre>'; print_r($data); die;
        $Id = $data['Id'];
        unset($data['Id']);

        try {
            $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($Id)))->set($data)->update('brands');
        } catch (Exception $ex) {
            print_r($ex);
        }
        echo json_encode($data);
    }

    function activateBrand() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1, 'statusString' => "Active"))->update('brands');
        }

        echo json_encode(array("msg" => "Selected brand has been activated successfully", "flag" => 0));
    }

    function deactivateBrand() {
        $Id = $this->input->post('Id');

        foreach ($Id as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 0, 'statusString' => "Inactive"))->update('brands');
        }

        echo json_encode(array("msg" => "Selected brand has been deactivated successfully", "flag" => 0));
    }

}

?>
