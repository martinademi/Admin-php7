<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Inventorymodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables1');
        $this->load->library('table');
        $this->load->library('utility_library');
        $this->load->library('CallAPI');
    }

     
    function getlanguageText($param = '') {

        if ($param == '') {
            // $res = $this->mongo_db->where(array('Active'=>1))->get('lang_hlp');
            $res = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        } else {
            $res = $this->mongo_db->where(array('lan_id' => (int) $param), array('Active' => 1))->get('lang_hlp');
        }
        return $res;
    }




    //language
    function get_lan_hlpText($param = '') {
        $this->load->library('mongo_db');
        if ($param == '') {
            $res = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }




    
// *******************************************************************************
    function inventoryProductList($status,$sortby,$type){
        $this->load->library('mongo_db');    
        $this->load->library('Datatables');
        $this->load->library('table');
        $catId = $this->input->post("category");
        $subCat= $this->input->post('subCat');
        $subSubCat=$this->input->post('subSubCat');
        $_POST['iColumns'] = 5;
        $_POST['mDataProp_0'] = "productname.en";
        $_POST['mDataProp_1'] = "firstCategoryName";
        $_POST['mDataProp_2'] = "secondCategoryName";
        $_POST['mDataProp_3'] = "thirdCategoryName";
        $_POST['mDataProp_4'] = "units.barcode";

        // $sl = $_POST['iDisplayStart'] + 1;
        $storeSession = $this->session->all_userdata();
        $storeId = $storeSession['badmin']['BizId'];
        if($sortby && $type){
            $querysort=array();
            if($sortby == "1" && $type == "1"){
                
                $querysort = array('$sort'=>array("units.availableQuantity"=>-1));
                
            }
            else if($sortby == "1" && $type == "2"){
                $querysort = array('$sort'=>array("units.availableQuantity"=>1));
            }
            else if($sortby == "2" && $type == "1"){
                $querysort = array('$sort'=>array("units.floatValue"=>-1));
            }
            else if($sortby == "2" && $type == "2"){
                $querysort = array('$sort'=>array("units.floatValue"=>1));
            }
            $respo = $this->datatables->datatable_mongodbAggregate('childProducts', array(array('$match'=>array("storeId"=>new MongoDB\BSON\ObjectID($storeId),"status"=>1)),array('$unwind' => '$units'),array('$match'=>array('units.availableQuantity'=>array('$gt'=>0))),$querysort),array(array('$match'=>array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status' => 1)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))));
        }
        else{
            // based on instock and outstock
            if($status == '1'){              
                if($catId==''){
                    $respo = $this->datatables->datatable_mongodbAggregate('childProducts', array(array('$match'=>array("storeId"=>new MongoDB\BSON\ObjectID($storeId),"status"=>array('$in'=>[1,6]))),
                        array('$sort'=>array("_id"=>-1)),array('$unwind' => '$units'),array('$match'=>array('units.availableQuantity'=>array('$gt'=>0)))),
                        array(array('$match'=>array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status'=>array('$in'=>[1,6]),'units.availableQuantity'=>array('$gt'=>0))),
                        array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))));

                }else{


                    if($catId!='' && $subCat!='' && $subSubCat!=''){
                            $respo = $this->datatables->datatable_mongodbAggregate('childProducts', array(array('$match'=>array("storeId"=>new MongoDB\BSON\ObjectID($storeId),"status"=>array('$in'=>[1,6]),'firstCategoryId'=>(string)$catId,
                                    'secondCategoryId'=>(string)$subCat,'thirdCategoryId'=>$subSubCat)),
                            array('$sort'=>array("_id"=>-1)),array('$unwind' => '$units'),array('$match'=>array('units.availableQuantity'=>array('$gt'=>0)))),
                            array(array('$match'=>array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status'=>array('$in'=>[1,6]),'units.availableQuantity'=>array('$gt'=>0))),
                            array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))));

                        }else if ($catId!='' && $subCat!=''){
                           
                            $respo = $this->datatables->datatable_mongodbAggregate('childProducts', array(array('$match'=>array("storeId"=>new MongoDB\BSON\ObjectID($storeId),"status"=>array('$in'=>[1,6]),'firstCategoryId'=>(string)$catId,
                                    'secondCategoryId'=>(string)$subCat)),
                            array('$sort'=>array("_id"=>-1)),array('$unwind' => '$units'),array('$match'=>array('units.availableQuantity'=>array('$gt'=>0)))),
                            array(array('$match'=>array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status'=>array('$in'=>[1,6]),'units.availableQuantity'=>array('$gt'=>0))),
                            array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))));

                        }else if($catId!=''){
                            $respo = $this->datatables->datatable_mongodbAggregate('childProducts', array(array('$match'=>array("storeId"=>new MongoDB\BSON\ObjectID($storeId),"status"=>array('$in'=>[1,6]),'firstCategoryId'=>(string)$catId)),
                            array('$sort'=>array("_id"=>-1)),array('$unwind' => '$units'),array('$match'=>array('units.availableQuantity'=>array('$gt'=>0)))),
                            array(array('$match'=>array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status'=>array('$in'=>[1,6]),'units.availableQuantity'=>array('$gt'=>0))),
                            array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))));
                        
                        }

                }
            }
            else{
            
            //     $respo = $this->datatables->datatable_mongodbAggregate(
            //         'childProducts',array(
            //             array('$match'=>array("storeId"=>new MongoDB\BSON\ObjectID($storeId),'status'=>array('$in'=>[1,5]))),
            //             array('$unwind' => '$units'),
            //             array('$match'=>array('$or'=>array( array('$and'=>array(array('status'=>1),array('units.availableQuantity'=>0))),array('status'=>5) ))),
            //             array('$sort'=>array("_id"=>-1))
            //         ),
            //         array(
            //             array('$match'=>array("storeId"=>new MongoDB\BSON\ObjectID($storeId),'status'=>array('$in'=>[1,5]))),
            //             array('$unwind' => '$units'),
            //             array('$match'=>array('$or'=>array( array('$and'=>array(array('status'=>1),array('units.availableQuantity'=>0))),array('status'=>5) ))),
            //             array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))
            //     )
            // ); 

                $respo = $this->datatables->datatable_mongodbAggregate(
                    'childProducts', array(
                        array('$match'=>array("storeId"=>new MongoDB\BSON\ObjectID($storeId),"status"=>array('$in'=>[1,5]))),
                        array('$sort'=>array("_id"=>-1)),
                        array('$unwind' => '$units'),
                        array('$match'=>array('units.availableQuantity'=>array('$lte'=>0)))),
                        array(
                            array('$match'=>array("storeId" => new MongoDB\BSON\ObjectID($storeId),'status'=>array('$in'=>[1,5]),'units.availableQuantity'=>array('$lte'=>0))),
                array('$group'=>array('_id'=>1,count=>array('$sum'=>1)))));
            }
            
        }
       
    //    echo '<pre>';print_r( $respo);die;

        $aaData = $respo["aaData"];
       
        $datatosend = array();
        //echo "<pre>";print_r($respo);die;   
        // $slno = 1;  
        $slno = $_POST['iDisplayStart'] + 1;  
        foreach ($aaData as $value) {
            $showbtn = "";
           



            $id = "";
            $storeId = "";
            $id = (string)$value->_id;
            $storeId = (string)$value->storeId;
            $value = json_decode(json_encode($value),TRUE);
            $units= $value['units']['name']['en'];
            $unitsId=$value['units']['unitId'];
            $unitsQty=$value['units']['availableQuantity'];
            
            if($status == "1"){
                $showbtn = '<a class="addUnitsData textDec" id="' . $id . '" unitId="'. $unitsId.'"> <button class="btn btnedit btn-success cls111 " id="editinventory" style="">Add</button></a>
                <a class="removeUnitsData textDec" id="' .$id . '" unitId="'. $unitsId.'"> <button class="btn btnedit btn-success cls111 " id="editinventory" style="">Remove</button></a>
                <a href="'. base_url() .'index.php?/Inventory/viewInventory/'.$id.'/'.$unitsId.'"> <button class="btn btnview btn-success cls111 " id="viewinventory" style="">View</button></a>';
            }
            else{
               $showbtn =  '<a class="addUnitsData textDec" id="' . $id . '" unitId="'. $unitsId.'"> <button class="btn btnedit btn-success cls111 " id="editinventory" style="">Add</button></a>
                <a href="'. base_url() .'index.php?/Inventory/viewInventory/'.$id.'/'.$unitsId.'"> <button class="btn btnview btn-success cls111 " id="viewinventory" style="">View</button></a>';
            }

            $arr = array();

            $arr[] = $slno++;
            $arr[]= $value['productname']['en'];
            $arr[] = ($value['units']['barcode']=="")?"N/A":'<a class="barcodeImgbarcodeaInventory" href="'.$value['units']['barcodeImg'].'"  target="_blank">'.$value['units']['barcode'].'</a>';
            $arr[]= $value['catName']['en'];
            $arr[]= $value['subCatName']['en'];
            $arr[]= $value['subSubCatName']['en'];
            $arr[]= $units;
            $arr[]=$unitsQty;
            $arr[]=$showbtn;


            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
  

    }


    function InventoryProductDetails($id,$unitsId,$timeOffset){
        $timeOffset = -$timeOffset;
        $this->load->library('mongo_db');    
        $this->load->library('Datatables');
        $this->load->library('table');
        $sl = $_POST['iDisplayStart'] + 1;
         
       // $respo=$this->mongo_db->where(array('_id'=> new MongoDB\BSON\ObjectID($id),'unitId'=> new MOngoDB\BSON\ObjectID($unitsId)))->find_one('inventoryLogs');
       $respo=$this->datatables1->datatable_mongodb('inventoryLogs', array('productId'=> $id,'unitId'=>$unitsId),'timeStamp',-1);
        $aaData = $respo["aaData"];
       $datatosend = array();
       foreach ($aaData as $value) {
        $datetimeval = date('d-m-Y h:i:s A',$value['timeStamp']/1000);
        $datetimeval = date('d-m-Y h:i:s A',strtotime("+$timeOffset minutes" , strtotime($datetimeval)));
        $arr = array();
        // $arr[] = ($value['units']['barcode']=="")?"N/A":'<a class="barcodeImgbarcodeaInventory" href="'.$value['units']['barcodeImg'].'"  target="_blank">'.$value['units']['barcode'].'</a>';
        $arr[]=$value['openingBalance'];
        $arr[]=$value['triggerTypeMsg'];
        $arr[]=($value['orderId'] == 0)?"N/A":$value['orderId']; 
        $arr[]=$value['quantity'];
        //$arr[]=$value['isoTimeStamp'] || 'N/A';
        // $arr[]=($value['timeStamp']!="" || $value['timeStamp']!= null)? date('F j, Y, g:i a',$value['timeStamp']/1000):'N/A';
        $arr[]=$datetimeval;
        $arr[]=$value['closingBalance'];     
        $datatosend[] = $arr;
    }

    $respo["aaData"] = $datatosend;
    echo json_encode($respo);

    }

     //get units for item
     function getUnitsForItem($id = '',$unitId= ''){
        
        $this->load->library('mongo_db');    
            $this->load->library('Datatables');
            $this->load->library('table');
        $respo = $this->mongo_db->aggregate('childProducts', array(array('$match' =>array('_id'=>new MongoDB\BSON\ObjectID($id))),array('$unwind' => '$units'),array('$match' =>array('units.unitId'=>$unitId)),array('$project'=>array('units.availableQuantity'=>1))));
     
     foreach($respo as $value){
        $valu = json_decode(json_encode($value),TRUE);
        $x = $valu['units']['availableQuantity'];
     }
    echo json_encode(array('data'=>$x));
    }

        //add product quantity API
    
        function addProductQuantity(){

            $data=$_POST;
            $data1['productId']=(string)$data['productId'];
            $data1['unitId']=(string)$data['unitId'];
            $data1['quantity']=$data['quantity'];
            $data1['triggerType'] = 1;
         
            $url = APILink . 'child/product/quantity';  
            $response = json_decode($this->callapi->CallAPI('PATCH', $url, $data1), true);
            echo json_encode(array("flag"=>1));
           
        }


            
    function removeProductQuantity(){

        $data=$_POST;
        $data1['productId']=(string)$data['productId'];
        $data1['unitId']=(string)$data['unitId'];
        $data1['quantity']=$data['quantity'];
        $data1['triggerType'] = 2;
    // print_r($data1);
        $url = APILink . 'child/product/quantity';  
    //  print_r($url);
        $response = json_decode($this->callapi->CallAPI('PATCH', $url, $data1), true);  
        //print_r($response);die;
        echo json_encode($response);
       
    }

    public function getProductData() {

        $res = $this->mongo_db->get('products');

        return $res;
    }

     public function exportAccData(){

            $storeId = new MongoDB\BSON\ObjectID($this->session->userdata('badmin')['BizId']);

      

            $allExportData = array();
            // $requiredData= $this->mongo_db->where(array('storeId'=>$storeId,"status" =>array('$in'=>[1,6])))->select(array('productname','units','serialNumber'))->get('childProducts');   

          
          
            

            $requiredData = $this->mongo_db->aggregate('childProducts',[
                ['$match'=>["storeId"=>new MongoDB\BSON\ObjectID($storeId),"status"=>array('$in'=>[1,6,5])]],
                ['$unwind'=>'$units'],
                ['$match'=>["storeId"=>new MongoDB\BSON\ObjectID($storeId),"status"=>array('$in'=>[1,6,5])]],
                ['$project'=>['productname'=>1,'units'=>1,'serialNumber'=>1]]
                ]);  

           

            $sl=1;
            foreach ($requiredData as $each) {     


                   
                $each = json_decode(json_encode($each),TRUE);   
            // echo '<pre>'; print_r($each);die;
                $arr['Seraial No.'] =$sl++;
                $arr['ProductId'] = $each['_id']['$oid'];
                $arr['Product Name'] = $each['productname']['en'];
                $arr['UnitId'] = $each['units']['unitId'];
               // $arr['Price'] = $each['units']['floatValue'];
                $arr['Unit'] =$each['units']['name']['en'];
                $arr['Quantity'] = $each['units']['availableQuantity'];
                //$arr['MRP'] = $each['units'][0]['mrp'];
                // $sl++;
                $allExportData[] = $arr;
            }       
           
            $file_name = "Inventory" . date('Y-m-d H:i:s') . ".xls";          
            $this->load->library('excel');           
            $this->excel->setActiveSheetIndex(0);
            $this->excel->stream($file_name, $allExportData);

    }

        


        
}

?>
 