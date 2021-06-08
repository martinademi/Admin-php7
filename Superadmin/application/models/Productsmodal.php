<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Productsmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->library('utility_library');
    }

    function product_details() {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->get('products', array());

        $i = 1;

        foreach ($result as $row) {

            $data[] = array($i++, $row['SKU'], $row['barcode'], $row['type'], $row['MPN'], $row['model'], $row['productName'], $row['shortDescription'], $row['POSName'], $row['barcodeFormats'],
                $row['firstCategoryName'], $row['secondCategoryName'], $row['thirdCategoryName'], $row['genre'], $row['clothingSize'], $row['color'], $row['manufacturer'],
                $row['brand'], $row['publisher'], $row['author'], $row['label'], $row['artist'], $row['director'], $row['actor'], $row['container'], $row['size'],
                $row['servingsPerContainer'], $row['height'], $row['width'], $row['length'], $row['weight'], $row['detailedDescription'], $row['features'], '<a class="imglist" id="' . $row['_id']['$oid'] . '" style="cursor:pointer;">View</a>',
                '<a  id="' . $row['_id']['$oid'] . '" class="reviewlist"style="cursor:pointer;"  >View</a>', $row['Ingredients'], $row['shelfLife'], $row['storageTemperature'],
                $row['warning'], $row['allergyInformation'], '<a class="nutrilist" id="' . $row['_id']['$oid'] . '" style="cursor:pointer;">View</a>', $row['currency'], $row['priceValue'], "<input type='checkbox' class='checkbox' id='checkboxProduct' data-id='" . $row['seqId'] . "' data='" . $row['_id']['$oid'] . "' value='" . $row['_id']['$oid'] . "'>"
            );
        }

        if ($this->input->post('sSearch') != '') {

            $FilterArr = array();
            foreach ($data as $row) {
                $needle = $this->input->post('sSearch');
                $search = strtoupper($needle);
                $ret = array_keys(array_filter($row, function($var) use ($search) {
                            return strpos(strtoupper($var), $search) !== false;
                        }));
                if (!empty($ret)) {
                    $FilterArr[] = $row;
                }
            }
            echo $this->datatables->getdataFromMongo($FilterArr);
        }

        if ($this->input->post('sSearch') == '')
            echo $this->datatables->getdataFromMongo($data);
    }

    function delete_product() {
        $this->load->library('elasticsearch');
        $id = $this->input->post('val');
        $ids = $this->input->post('id');

        foreach ($id as $data) {
            $result = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($data)))->delete('products');
        }
        $this->elasticsearch->delete("products", $ids);
        echo json_encode($result);
    }
    function AddNewProductData() {
        
        $this->load->library('elasticsearch');
        $cursor = $this->mongo_db->get('products');
        $arr = [];

        foreach ($cursor as $catdata) {
            array_push($arr, $catdata['seqId']);
        }
        $max = max($arr);
        $seq = $max + 1;
       
        $data = $_POST;
        $data['seqId'] = $seq;
        $result = $this->mongo_db->insert('products',$data);
        $data1[]=$data;
        $data1['mongoId']=(string)$result;
        $elasticdata=$data1;
        
        $this->elasticsearch->add('products', $seq, $elasticdata);

     }

    public function getProductData() {

        $res = $this->mongo_db->get('products');

        return $res;
    }

    function insertExcel($data) {

        $this->load->library('elasticsearch');
        $data1= $data;
        $cursor = $this->mongo_db->get('products');
        $arr = [];

        foreach ($cursor as $catdata) {
            array_push($arr, $catdata['seqId']);
        }
        $max = max($arr);
        $seq = $max + 1;

        $data['seqId'] = $seq;
        $result = $this->mongo_db->insert('products', $data); 
        $data1['mongoId']=(string)$result;
        $elasticdata=$data1;
        $return = $this->elasticsearch->add('products', $seq, $elasticdata);
    }

    function reviewlist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');
        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('products');
        $i = 1;
        foreach ($result as $row)
            $data[] = array($i++, 'Product_Name' => $row['productName'], 'Manufacturer' => $row['manufacturer'], 'Model' => $row['model'], 'Description' => $row['shortDescription']);

        echo json_encode(array('data' => $data));
    }

    function imagelist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('products');

        foreach ($result as $row) {
            $data = $row['images'];
        }

        echo json_encode(array('data' => $data));
    }

    function nutrilist($id = '') {

        $this->load->library('Datatables');
        $this->load->library('table');

        $result = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->get('products');

        $i = 1;

        foreach ($result as $row) {
            $data = $row['nutritionFacts'];
        }

        echo json_encode(array('data' => $data));
    }

    function getCities() {
        $val = $this->input->post("country");

        $cData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($val)))->find_one('Country');
        $entities = ' <select class="form-control" id="cityLists" name="FData[city_select]"  required>
                                                <option value="0">Select City</option>';
        foreach ($cData['cities'] as $city) {
            $cityData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($city)))->find_one('City');
            $entities .= ' <option value="' . $cityData['_id']['$oid'] . '" >' . implode($cityData['name']) . '</option>';
        }
        $entities .= ' </select>';
        return $entities;
    }

}

?>
