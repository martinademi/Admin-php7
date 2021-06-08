<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class GridProductModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');
    }


    function get_product($franchiseId){
    
       $this->load->library('mongo_db');
      $res=$this->mongo_db->where(array("franchiseId" => $franchiseId,"status"=>1))->get('franchiseProducts');
     
      $res['currencySymbol'] = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($this->session->userdata('fadmin')['MasterBizId'])))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
      return $res;
     }

     //get_Grid product data
     function get_productGrid($status,$storeId){

      
       $this->load->library('mongo_db');
  
       $res=$this->mongo_db->where(array("storeId" => new MongoDB\BSON\ObjectId($storeId),"status"=>(int)$status))->get('childProducts');
       //$res['currencySymbol'] = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($this->session->userdata('badmin')['BizId'])))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
       $currencySymbol = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($storeId)))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
       echo json_encode(array('data'=>$res,'currencySymbol'=>$currencySymbol));
      
      }

     //fetch particular data
     function get_productDetails($productId){
       
        $this->load->library('mongo_db');
        $res=$this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($productId)))->get('childProducts');
        
        return $res;
       }

       //unit details
         //fetch particular data
     function getUnitDetails($productId){
       
        $this->load->library('mongo_db');
        $res=$this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($productId)))->find_one('childProducts');
        
        $res['currencySymbol'] = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($this->session->userdata('fadmin')['MasterBizId'])))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
        echo json_encode(array('data'=>$res));
       }
     
    //fetch deleted product detail
     function get_productdeleted(){

        $this->load->library('mongo_db');
        $res=$this->mongo_db->where(array("status" => 0))->get('childProducts');
        return $res;
       }

    //delete  product

    function deleteProduct($productId){

       
        //$id = $this->input->post('val');
        
        $id =$productId;

        $fields = implode(',', $id);
        $fields = json_encode($fields);
        $headers = array(
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, APILink.'child/product/' .$fields);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        curl_close($ch);
        echo json_encode($result);
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

        $res = $this->mongo_db->where(array('status'=>1))->get('brands');

       

        return $res;
    }

    function getData($id = '') {
        $data = $this->mongo_db->where(array("_id" => new MongoDB\BSON\ObjectID($id)))->find_one('childProducts');
        return $data;
    }

    //category
    public function getCategory(){

       $this->load->library('mongo_db');
       $franchiseId=$this->session->userdata('fadmin')['MasterBizId'];    
       $data=$this->mongo_db->where(array('visibility'=>1,'franchiseId'=>$franchiseId))->get('firstCategory');
      
       return $data;

    }
 
    //sub category previous
    // public function getSubCategory(){

    //     $this->load->library('mongo_db');
    //     $data=$this->mongo_db->where(array('visibility'=>1))->get('secondCategory');
    //     return $data;

    // }


        // cat dynamically
    public function getCatlist(){

            $this->load->library('mongo_db');
            $categoryId = $this->input->post('categoryId');
            $storeId=$this->session->userdata('badmin')['BizId']; 
            //$franchiseId=$this->session->userdata('fadmin')['MasterBizId'];   
           
            

            $data=$this->mongo_db->where(array('visibility'=>1,'storeid'=>$storeId,"status" => 1,))->get('firstCategory');
           
             $entities = array();
            $entities = '<select class="form-control error-box-class"  id="category" name="firstCategoryId">
                     <option selected="selected" value="">Select Category </option>';
           
            foreach( $data as $Categorys){ 
                
                $entities .= '<option value="' . $Categorys['_id']['$oid'] . '" catName="'.$Categorys['name']['0'].'" >' . $Categorys['name']['0'] . '</option>';

               }
                
            
            $entities .= '</select>';
            echo $entities;

            
          
            //return $data;
    
        }


    //sub cat dynamically
    public function getSubCategory(){

            $this->load->library('mongo_db');
            $categoryId = $this->input->post('categoryId');
            $storeId=$this->session->userdata('badmin')['BizId']; 
            //$franchiseId=$this->session->userdata('fadmin')['MasterBizId'];   

            if($categoryId!='' || $categoryId!=null){

            $data=$this->mongo_db->where(array('categoryId'=> new MongoDB\BSON\ObjectId($categoryId),'visibility'=>1,'storeid'=>$storeId))->get('secondCategory');

             $entities = array();
            $entities = '<select class="form-control error-box-class"  id="subCategory" name="subCategory">
                     <option selected="selected" value="">Select Sub-Category </option>';
           
            foreach( $data as $subCategorys){ 
                
                $entities .= '<option value="' . $subCategorys['_id']['$oid'] . '" catName="'.$subCategorys['name']['0'].'" >' . $subCategorys['name']['0'] . '</option>';

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
            // $storeId=$this->session->userdata('badmin')['BizId']; 
            $franchiseId=$this->session->userdata('fadmin')['MasterBizId'];   
           
            $data=$this->mongo_db->where(array('subCategoryId'=> new MongoDB\BSON\ObjectId($subCategoryId),'visibility'=>1,'storeid'=>$storeId))->get('thirdCategory');

            $entities = array();
            $entities = '<select class="form-control error-box-class"  id="subSubCategory" name="subSubCategory">
                     <option selected="selected" value="">Select Sub-Category </option>';
           
            foreach( $data as $subCategorys){ 
                
                $entities .= '<option value="' . $subCategorys['_id']['$oid'] . '" catName="'.$subCategorys['name']['0'].'">' . $subCategorys['name']['0'] . '</option>';

               }
                
            
            $entities .= '</select>';
            echo $entities;

            //return $data;
    
        }



    //  //sub sub category
    //  public function getSubSubCategory(){

    //     $this->load->library('mongo_db');
    //     $data=$this->mongo_db->where(array('visibility'=>1))->get('thirdCategory');
    //     return $data;

    // }

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
    public function getCategorylist($categoryId,$storeId){

       
      
        $this->load->library('mongo_db');
       $franchiseId=$this->session->userdata('fadmin')['MasterBizId'];

        if($categoryId!='' || $categoryId!=null){

        $data=$this->mongo_db->where(array('firstCategoryId'=> $categoryId,'franchiseId'=>$franchiseId,'status'=>1))->get('franchiseProducts');
        

        }
        else{

        
        $data=$this->mongo_db->where(array("franchiseId" => $franchiseId,'status'=>1))->get('franchiseProducts');
        // echo '<pre>';
        // print_r( count($data));die;
        

            }
        $currencySymbol = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($storeId)))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');

        echo json_encode(array('data'=>$data,'currencySymbol'=>$currencySymbol));
    }

    //sub category
    public function getSubCategorylist($categoryId,$storeId){

        $this->load->library('mongo_db');
        $franchiseId=$this->session->userdata('fadmin')['MasterBizId'];
       
        if($categoryId!='' || $categoryId!=null){

        $data=$this->mongo_db->where(array('secondCategoryId'=> $categoryId,'franchiseId'=> $franchiseId,'status'=>1))->get('franchiseProducts');

        }
        else{

            //update required
            //$data=$this->mongo_db->where(array("storeId" => new MongoDB\BSON\ObjectId($storeId),'status'=>1))->get('childProducts');

        }
        $currencySymbol = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($storeId)))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
       
        echo json_encode(array('data'=>$data,'currencySymbol'=>$currencySymbol));
    }

    //sub sub category
    public function getSubSubCategorylist($categoryId,$storeId){

        $this->load->library('mongo_db');
        $franchiseId=$this->session->userdata('fadmin')['MasterBizId'];

        $data=$this->mongo_db->where(array('thirdCategoryId'=> $categoryId,'franchiseId'=> $franchiseId,'status'=>1))->get('franchiseProducts');
        $currencySymbol = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($storeId)))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
        // echo '<pre>';
        // print_r( $data);die;
        echo json_encode(array('data'=>$data,'currencySymbol'=>$currencySymbol));
    }

    //brand to be modified
    public function getBrandlistDetails($brandId,$storeId){

        $this->load->library('mongo_db');
        $data=$this->mongo_db->where(array('storeId'=>new MongoDB\BSON\ObjectID($storeId),'status'=>1,'brand'=> new MongoDB\BSON\ObjectID($brandId)))->get('childProducts');
        $currencySymbol = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($storeId)))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
        echo json_encode(array('data'=>$data,'currencySymbol'=>$currencySymbol));
    }

    //manufracture to be modified
    public function getManufacturerslist($manufracturerId,$storeId){

        $this->load->library('mongo_db');
        $data=$this->mongo_db->where(array('storeId'=>new MongoDB\BSON\ObjectID($storeId),'status'=>1,'manufacturer'=> $manufracturerId ))->get('childProducts');
        $currencySymbol = $this->mongo_db->where(array("_id"=>new MongoDB\BSON\ObjectID($storeId)))->select(array("currencySymbol"=>"currencySymbol"))->find_one('stores');
        echo json_encode(array('data'=>$data,'currencySymbol'=>$currencySymbol));

    }


}
?>