<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class GridProductModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }


    function get_product(){

      $this->load->library('mongo_db');
   // $res=$this->mongo_db->where(array("status" => 1))->get('products');
      $res=$this->mongo_db->where(array("status" => 1))->limit(10)->offset(0)->order_by(array('_id'=>-1))->get('products');
     
      return $res;
     }

     //fetch particular data
     function get_productDetails($productId){
       
        $this->load->library('mongo_db');
        $res=$this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($productId)))->get('products');
        
        return $res;
       }

    //    pagination
       function get_productPagination($offset=""){        
        $limit=10;

        $this->load->library('mongo_db');
        $res=$this->mongo_db->where(array("status" => 1))->limit($limit)->offset($offset*10)->order_by(array('_id'=>-1))->get('products');       
        echo json_encode(array('data'=>$res));
       }
    
    //pagination count
    function get_productCount(){
       $this->load->library('mongo_db');
       $res=$this->mongo_db->where(array("status" => 1))->get('products');
       $count=count($res);
       return  $count;
       }
     
    //deletedproduct
     function get_productdeleted(){

        $this->load->library('mongo_db');
        $res=$this->mongo_db->where(array("status" => 0))->get('products');
        return $res;
       }

       //delete  product

    function deleteProduct($productId){

       //chnages in status
        $this->load->library('mongo_db');
        $res=$this->mongo_db->where(array('_id'=> new MongoDB\BSON\ObjectID($productId)))->set(array('status'=>2))->update('products');
        return $res;
    }



     function getAppConfigData() {
        $data = $this->mongo_db->get('appConfig');
        foreach ($data as $result) {
            $res = $result['currencySymbol'];
        }
        return $res;
    }

    public function getActiveColors() {

        $res = $this->mongo_db->where(array('status' => 1))->get('colors');

        return $res;
    }

    public function getActiveSize() {

        $res = $this->mongo_db->where(array('status' => 1))->get('sizeGroup');

        return $res;
    }

    function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->get('lang_hlp');
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    public function getManufacturer() {

        $res = $this->mongo_db->get('manufacturer');

        return $res;
    }

    public function getBrands() {

        $res = $this->mongo_db->get('brands');

        return $res;
    }

    function getData($id = '') {
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('products');
        return $data;
    }

    //category
    public function getCategory(){

        $this->load->library('mongo_db');
        $data=$this->mongo_db->where(array('visibility'=>1))->get('firstCategory');
       
        return $data;
 
     }

      //sub cat dynamically
    public function getSubCategory(){

        $this->load->library('mongo_db');
        $categoryId = $this->input->post('categoryId');
        // echo '<pre>';
        // print_r( $categoryId);
        // die;

        if($categoryId!='' || $categoryId!=null){

        $data=$this->mongo_db->where(array('categoryId'=> new MongoDB\BSON\ObjectId($categoryId),'visibility'=>1))->get('secondCategory');

         $entities = array();
        $entities = '<select class="form-control error-box-class"  id="subCategory" name="subCategory">
                 <option selected="selected" value="">Select Sub-Category </option>';
       
        foreach( $data as $subCategorys){ 
            
            $entities .= '<option value="' . $subCategorys['_id']['$oid'] . '" catType="getSubCategorylist">' . $subCategorys['name']['0'] . '</option>';

           }
            
        
        $entities .= '</select>';
        echo $entities;

        }
        else{
            
            $entities = array();
            $entities = '<select class="form-control error-box-class"  id="subCategory" name="subCategory">
                     <option value="">Select Sub-Category </option>';
                     $entities .= '</select>';
                     echo $entities;

        }
        //return $data;

    }

     //sub sub cat dynamic
     public function getSubSubCategory(){

        $this->load->library('mongo_db');
        $subCategoryId = $this->input->post('subCategoryId');
       
        $data=$this->mongo_db->where(array('subCategoryId'=> new MongoDB\BSON\ObjectId($subCategoryId),'visibility'=>1))->get('thirdCategory');

        $entities = array();
        $entities = '<select class="form-control error-box-class"  id="subSubCategory" name="subSubCategory">
                 <option selected="selected" value="">Select Sub-Category </option>';
       
        foreach( $data as $subCategorys){ 
            
            $entities .= '<option value="' . $subCategorys['_id']['$oid'] . '" catType="getSubSubCategorylist" >' . $subCategorys['name']['0'] . '</option>';

           }
            
        
        $entities .= '</select>';
        echo $entities;

        //return $data;

    }

    //brand
    public function getBrand(){

        $this->load->library('mongo_db');
        $data=$this->mongo_db->where(array('status'=>1))->get('brands');

       

        return $data;

    }

   
     //Manufacturer
     public function getManufacturerlist(){

        $this->load->library('mongo_db');
        $data=$this->mongo_db->where(array('status'=>1))->get('manufacturer');
       
        return $data;

    }

     //get category list
     public function getCategorylist($categoryId,$offset=''){ 
        // echo $offset;die;
         $this->load->library('mongo_db');
         $limit=10;
        if($categoryId!='' || $categoryId!=null){
          
        // $data=$this->mongo_db->where(array('firstCategoryId'=> $categoryId,'status'=>1))->get('products');  
        $data=$this->mongo_db->where(array('firstCategoryId'=> $categoryId,'status'=>1))->limit($limit)->offset($offset*10)->get('products');  
        
        }
        else{                  
         $data=$this->mongo_db->where(array('status'=>1))->get('products');        
            }
        $currencySymbol = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($storeId)))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
        $totalProducts=$this->mongo_db->where(array('firstCategoryId'=> $categoryId,'status'=>1))->get('products');  
       // echo count($totalProducts);die;
        echo json_encode(array('data'=>$data,'currencySymbol'=>$currencySymbol));
    }

     //sub category
     public function getSubCategorylist($categoryId){

        $this->load->library('mongo_db');
       
        if($categoryId!='' || $categoryId!=null){

        $data=$this->mongo_db->where(array('secondCategoryId'=> $categoryId,'status'=>1))->get('products');

        }
        else{

            //update required
            //$data=$this->mongo_db->where(array("storeId" => new MongoDB\BSON\ObjectId($storeId),'status'=>1))->get('products');

        }
        $currencySymbol = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($storeId)))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
       
        echo json_encode(array('data'=>$data,'currencySymbol'=>$currencySymbol));
    }
     //sub sub category
     public function getSubSubCategorylist($categoryId){

        $this->load->library('mongo_db');

        $data=$this->mongo_db->where(array('thirdCategoryId'=> $categoryId,'status'=>1))->get('products');
        $currencySymbol = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($storeId)))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
        // echo '<pre>';
        // print_r( $data);die;
        echo json_encode(array('data'=>$data,'currencySymbol'=>$currencySymbol));
    }

    //brand to be modified
    public function getBrandlistDetails($brandId){

        $this->load->library('mongo_db');
        $data=$this->mongo_db->where(array('status'=>1,'brand'=> new MongoDB\BSON\ObjectID($brandId)))->get('products');
        $currencySymbol = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($storeId)))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
        echo json_encode(array('data'=>$data,'currencySymbol'=>$currencySymbol));
    }

     //manufracture to be modified
     public function getManufacturerslist($manufracturerId){

        $this->load->library('mongo_db');
        $data=$this->mongo_db->where(array('status'=>1,'manufacturer'=> $manufracturerId ))->get('products');
        $currencySymbol = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($storeId)))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
        echo json_encode(array('data'=>$data,'currencySymbol'=>$currencySymbol));

    }

     //get_Grid product data
     function get_productGrid($status){

       
        $this->load->library('mongo_db');
        
        $res=$this->mongo_db->where(array("status"=>(int)$status))->get('products');

       // print_r($res);die;
       // $currencySymbol = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($storeId)))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
        echo json_encode(array('data'=>$res));
       
       }

         //unit details
         //fetch particular data
     function getUnitDetails($productId){
       
        $this->load->library('mongo_db');
        $res=$this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($productId)))->find_one('products');
       
        //$res['currencySymbol'] = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($this->session->userdata('badmin')['BizId'])))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
        echo json_encode(array('data'=>$res));
       }

}
?>