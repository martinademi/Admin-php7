<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class WalletModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->model("Home_m");   
        
    }

    function getAppConfigOne() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->find_one('appConfig');
        return $getAll;
    }

    function getBadgeCount($userType) {
        $data['walletCount'] = $this->mongo_db->count($userType);
        $data['softLimitCount'] = $this->mongo_db->where(array('wallet.softLimitHit' => true))->count($userType);
        $data['hardLimitCount'] = $this->mongo_db->where(array('wallet.hardLimitHit' => true))->count($userType);

        echo json_encode(array('data' => $data));
        return;
    }

    function getUserDetails($userId, $collectionName) {
        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($userId)))->find_one($collectionName);
       // echo '<pre>'; print_r($data);die;
        if($data['cityId']!=''){
               $cityData = $this->mongo_db->aggregate('cities',[
                ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($data['cityId'])]],
                ['$unwind'=>'$cities'],
                ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($data['cityId'])]],
                ['$project'=>['cities.currencySymbol'=>1,'cities.currency'=>1]]
                ]);
            foreach($cityData as $cData){
                $doc = json_decode(json_encode($cData),TRUE)['cities'];
            }
            $data['currency']=$doc;
            return $data;
        }else{
            $data['currency']='$';
            return $data;
        }
        
        
    }

    function datatable_user($userType, $tableName, $tabType) {

        // print_r($userType);
        // echo '<br/>';
        // print_r($tableName);
        // echo '<br/>';
        // print_r($tabType);
        // die;
       
        $var="walletDriverUser";
        $len=strlen($var);
        

        $this->load->library('Datatables');

        $queryObj = array();
        switch ((int) $tabType) {
            case 1:
                break;
            case 2:
                $queryObj['wallet.softLimitHit'] = true;
                break;
            case 3:
                $queryObj['wallet.hardLimitHit'] = true;
                break;
        }
        $queryObj['userType'] = array('$nin'=>[3]);

        if($tableName=="driver"){
            $queryObj['status'] = array('$in' => [2, 3, 4, 8, 9]);
        }

        $_POST['iColumns'] = 8;
        $_POST['mDataProp_0'] = "firstName";
        $_POST['mDataProp_1'] = "lastName";
        $_POST['mDataProp_2'] = "email";
        $_POST['mDataProp_3'] = "phone.phone";
        $_POST['mDataProp_4'] = "cityName";
        $_POST['mDataProp_5'] = "ownerEmail";
        $_POST['mDataProp_6'] = "name";
        $_POST['mDataProp_7'] = "registeredFromCity";
        



        // $respo = $this->datatables->datatable_mongodb($tableName, $queryObj,'',$sortOrder = 1);
     
        $respo = $this->datatables->datatable_mongodb($tableName, $queryObj);
        
       
        $userData = $respo["aaData"];

        $arr = [];
        $i = $_POST['iDisplayStart'] + 1;

        


        //(($tableName == 'institutions')? $val['name'] : ($tableName == == 'operatorName')?'':($val['firstName'] . " " . $val['lastName'])),
        foreach ($userData as $val) {

            //echo '<pre>';print_r($val);die;
            $name = '';
            $mobile = '';
            switch ($tableName) {                                

                    case 'driver':
                            $name = $val['firstName']." ".$val['lastName'];
                            $mobile = $val['countryCode'] . " " . $val['mobile'];
                            $email=$val['email'];

                            $cityData = $this->mongo_db->aggregate('cities',[
                                ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($val['cityId'])]],
                                ['$unwind'=>'$cities'],
                                ['$match'=>["cities.cityId"=>new MongoDB\BSON\ObjectID($val['cityId'])]],
                                ['$project'=>['cities.currencySymbol'=>1,'cities.abbrevation'=>1,'cities.currency'=>1,]]
                                ]);
                            foreach($cityData as $cData){                    
                                $doc = json_decode(json_encode($cData),TRUE)['cities'];
                            }                    
                            
                            //softlimit                    
                            if(!isset($val['wallet']['softLimit'])){
                                $softLimit='N/A';
                            }else{
                                if($doc['abbrevation']==1){
                                    $softLimit= $doc['currencySymbol'].' '.$val['wallet']['softLimit'];
                                }else{
                                    $softLimit= $val['wallet']['softLimit'].' '.$doc['currencySymbol'];
                                }
                            }

                            //hard limit
                            if(!isset($val['wallet']['hardLimit'])){
                                $hardLimit='N/A';
                            }else{
                                if($doc['abbrevation']==1){
                                    $hardLimit= $doc['currencySymbol'].' '.$val['wallet']['hardLimit'];
                                }else{
                                    $hardLimit= $val['wallet']['hardLimit'].' '.$doc['currencySymbol'];
                                }
                            }

                            //wallet balance
                            
                            if(!isset($val['wallet']['balance'])){
                                $walletbalance='N/A';
                            }else{
                                if($doc['abbrevation']==1){
                                    $walletbalance= $doc['currencySymbol'].' '.$val['wallet']['balance'];
                                }else{
                                    $walletbalance= $val['wallet']['balance'].' '.$doc['currencySymbol'];
                                }                       

                            }

                        break;  
                   
                    case 'customer':
                   // print_r($val);die;
                    
                    if(!isset($val['name'])){
                        $name='N/A';
                    }else{
                        $name=$val['name'];
                    }

                    if(!isset($val['email'])){
                        $email='N/A';
                    }else{
                        $email=$val['email'];
                       
                    }

                    $mobile = $val['countryCode'] . " " . $val['phone'];
                   



                    //wallet balce for customer
                    if(!isset($val['wallet']['balance'])){
                        $walletbalance='N/A';
                    }else{
                        $walletbalance= $val['currencySymbol'].' '.($val['wallet']['balance']-$val['wallet']['blocked']);

                    }

                    //softlimit
                   
                    if(!isset($val['wallet']['softLimit'])){
                        $softLimit='N/A';
                    }else{
                        $softLimit= $val['currencySymbol'].' '.$val['wallet']['softLimit'];

                    }

                    //hard limit
                   
                    if(!isset($val['wallet']['hardLimit'])){
                        $hardLimit='N/A';
                    }else{
                        $hardLimit= $val['currencySymbol'].' '.$val['wallet']['hardLimit'];

                    }



                    break;
                    
                    case 'stores':

                    
                    if($val['name']!="" || $val['name']!=null ){
                       
                        $name = $val['name'];
                        $mobile = $val['countryCode'] . " " . $val['phone'];
                        $email=$val['ownerEmail'];
                    }else{
                        $name = 'N/A';
                        $mobile = 'N/A';
                        $val['email']='N/A'  ;       

                    }
                    $mobile= $val['countryCode']." ".$val['ownerPhone'];

                    //wallet balce for customer
                    if(!isset($val['wallet']['balance'])){
                        $walletbalance='N/A';
                    }else{
                        $walletbalance= $val['currencySymbol'].' '.$val['wallet']['balance'];

                    }

                    //softlimit
                    if(!isset($val['wallet']['softLimit'])){
                        $softLimit='N/A';
                    }else{
                        $softLimit= $val['currencySymbol'].' '.$val['wallet']['softLimit'];

                    }

                    //hard limit
                    if(!isset($val['wallet']['hardLimit'])){
                        $hardLimit='N/A';
                    }else{
                        $hardLimit= $val['currencySymbol'].' '.$val['wallet']['hardLimit'];

                    }

                    break;

                   
                    default :
                    $name = $val['firstName'] . " " . $val['lastName'];
                    $mobile = $val['phone']['countryCode'] . " " . $val['phone']['phone'];
                    break;
            }

            $arr[] = array(
                $i++,
                $name,
                $this->Home_m->maskFileds($email, 1),
                $this->Home_m->maskFileds($mobile, 2),
                // $doc['currencySymbol'] .' '.$walletbalance,
                // $doc['currencySymbol'] .' '.$softLimit,
                // $doc['currencySymbol'] .' '.$hardLimit,
                $walletbalance,
                $softLimit,
                $hardLimit,
                '<input type="checkbox" class="checkbox" value="' . $val['_id']['$oid'] . '" data-currency="' . $doc['currency'] . '" data-currencySymbol="' . $doc['currencySymbol'] . '"  data-cityName="' . $val['cityName'] . '" data-email="' . $val['email'] . '" data-name="'.$name.'">',
                "<a type='button' class='btn btn-success cls111' href='" . base_url('index.php?/wallet') . "/details/" . $userType . "/" . $val['_id']['$oid'] . "'> 
                    <i class='fa fa-tasks'></i> Statement
                </a>"
            );

          
        }
        $respo["aaData"] = $arr;
        echo json_encode($respo);
    }

    function datatable_details($userType, $tableName, $userId, $export = false) {
           
        $this->load->library('Datatables'); 
        $queryObj = array('userId' => $userId);

        $isEntity = $_POST['isEntity'];
        if ($isEntity == 'true') {
            $queryObj = array();
        }
        $searchByPayment = $_POST['searchByPayment'];

        if ($searchByPayment != '0') {
            $queryObj['txnType'] = $searchByPayment;
        }

        $searchByTrigger = $_POST['searchByTrigger'];
        if ($searchByTrigger != '0') {
            $queryObj['trigger'] = $searchByTrigger;
        }

        $startDate = $_POST['searchByStartDate'];
        $endDate = $_POST['searchByEndDate'];
        if ($startDate != '' && $endDate != '') {
            $startDate = strtotime($startDate . ' 00:00:01');
            $endDate = strtotime($endDate . ' 23:59:59');
            if ($startDate < $endDate) {
                $queryObj['timestamp'] = array('$gte' => $startDate, '$lte' => $endDate);
            }
        }

        if ($export == 'true') {
           
            $this->load->library('mongo_db');
            $dataResponse = $this->mongo_db->where($queryObj)->order_by(array('timestamp' => -1))->get($tableName);
            $allExportData = array();
            foreach ($dataResponse as $each) {
                $arr['TXN ID'] = $each['txnId'];
                $arr['OPENING'] = $each['currencySymbol'] . ' ' . $each['openingBal'];
                $arr['TXN TYPE'] = $each['txnType'];
                $arr['TRIGGER'] = $each['trigger'];

                $arr['BOOKING ID'] = $each['orderId'];
             //   $arr['TXN DATE'] = date('d-M-Y h:i:s a', $each['timestamp']);
                $arr['TXN DATE'] = date('d-M-Y h:i:s a ', ($each['timestamp']) - ($this->session->userdata('timeOffset') * 60));              
                $arr['CITY'] = $each['cityName'];
                $arr['PG NAME'] = 'Stripe';
                $arr['INITIATED'] = $each['intiatedBy'];
                $arr['REASON'] = $each['comment'];
                $arr['AMOUNT'] = $each['currencySymbol'] . ' ' . $each['amount'];
                $arr['CLOSING'] = $each['currencySymbol'] . ' ' . $each['closingBal'];
                $allExportData[] = $arr;
            }
            $file_name = $fileName = "Wallet_" . time() . ".xls";
          
            $this->load->library('excel');
           
            $this->excel->setActiveSheetIndex(0);
            $this->excel->stream($file_name, $allExportData);


       
        } else {

           
            $_POST['iColumns'] = 10;
            $_POST['mDataProp_0'] = "txnId";
            $_POST['mDataProp_1'] = "openingBal";
            $_POST['mDataProp_2'] = "txnType";
            $_POST['mDataProp_3'] = "trigger";
            $_POST['mDataProp_4'] = "orderId";
            $_POST['mDataProp_5'] = "timestamp";
            $_POST['mDataProp_6'] = "intiatedBy";
            $_POST['mDataProp_7'] = "comment";
            $_POST['mDataProp_8'] = "amount";
            $_POST['mDataProp_9'] = "closingBal";
            $_POST['sSortDir_5'] = "desc";
           
            $respo = $this->datatables->datatable_mongodb($tableName, $queryObj);
          
            $userData = $respo["aaData"];

            $arr = [];
          
            foreach ($respo["aaData"] as $val) {

                
                $cityName=($val['cityName']!="" ||$val['cityName']!=null) ? $val['cityName']:'N/A';
                //$orderId=($val['orderId']!="" ||$val['orderId']!=null) ? $val['orderId']:'N/A';
                if(array_key_exists('orderId',$val) ){
                   
                   $orderId=($val['orderId']!="" ||$val['orderId']!=null) ? $val['orderId']:'N/A';
                  }else{
                     
                    $orderId='N/A';
                  }

                $arr[] = array(
                    $val['txnId'],
                    $val['currencySymbol'] . " " . $val['openingBal'],
                    $val['txnType'],
                    $val['trigger'],
                    $orderId,
                    date('d-M-Y h:i:s a ', ($val['timestamp']) - ($this->session->userdata('timeOffset') * 60)),
                    $cityName,
                    $val['paymentTxnId'],
                    // 'Stripe',
                    $val['intiatedBy'],
                    $val['comment'],
                    $val['currencySymbol'] . " " . $val['amount'],
                    $val['currencySymbol'] . " " . $val['closingBal']
                );
            }
            $respo["aaData"] = $arr;
            echo json_encode($respo);
        }
    }


   //zone dynamically
   public function getZone(){

    $this->load->library('mongo_db');
    $cityID = $this->input->post('cityID');
    
    
    if($cityID!='' || $cityID!=null){

    $data=$this->mongo_db->where(array('city_ID'=> $cityID))->select(array('title'))->get('zones');
    
    $entities = array();
    $entities = '<select class="form-control error-box-class"  id="zoneFilter" name="zoneFilter">
             <option selected="selected" value="">Select Zone </option>';
   
    foreach( $data as $zone){         
        $entities .= '<option value="' . $zone['_id']['$oid'] . '" >' . $zone['title'] . '</option>';
       }
        
    $entities .= '</select>';
    echo $entities;

    }
    else{
        
        $entities = array();
        $entities = '<select class="form-control error-box-class"  id="zoneFilter" name="zoneFilter">
                 <option value="">Select Zone </option>';
                 $entities .= '</select>';
                 echo $entities;

    }
    //return $data;

}



//from date to end date*************

function transection_data_form_date($stdate = '', $enddate = '', $paymentType = '') {

   
    $var="walletDriverUser";
    $len=strlen($var);
    

    $this->load->library('Datatables');

    $queryObj = array();
    switch ((int) $tabType) {
        case 1:
            break;
        case 2:
            $queryObj['wallet.softLimitHit'] = true;
            break;
        case 3:
            $queryObj['wallet.hardLimitHit'] = true;
            break;
    }

    $_POST['iColumns'] = 5;
    $_POST['mDataProp_0'] = "firstName";
    $_POST['mDataProp_1'] = "lastName";
    $_POST['mDataProp_2'] = "email";
    $_POST['mDataProp_3'] = "phone.phone";
    $_POST['mDataProp_3'] = "cityName";


    $respo = $this->datatables->datatable_mongodb($tableName, $queryObj);
   
    $userData = $respo["aaData"];

    $arr = [];
    $i = $_POST['iDisplayStart'] + 1;


    //(($tableName == 'institutions')? $val['name'] : ($tableName == == 'operatorName')?'':($val['firstName'] . " " . $val['lastName'])),
    foreach ($userData as $val) {

   
       
        $name = '';
        $mobile = '';
        switch ($tableName) {
                            

                case 'driver':
                $name = $val['firstName']." ".$val['lastName'];
                $mobile = $val['countryCode'] . " " . $val['mobile'];

                //softlimit
                if($val['walletSoftLimit']=="" || $val['walletSoftLimit']==null){
                    $softLimit='N/A';
                }else{
                    $softLimit=$val['walletSoftLimit'];

                }

                //hard limit
                if($val['walletHardLimit']=="" || $val['walletHardLimit']==null){
                    $hardLimit='N/A';
                }else{
                    $hardLimit=$val['walletHardLimit'];

                }

                //wallet balance
                if($val['wallet']['balance']=="" || $val['wallet']['balance']==null){
                    $walletbalance='N/A';
                }else{
                    $walletbalance=$val['wallet']['balance'];

                }

                break;  
               
                case 'customer':
                if($val['name']!="" || $val['name']!=null ){
                   
                    $name = $val['name'];
                $mobile = $val['countryCode'] . " " . $val['phone'];
                }else{
                    $name = 'N/A';
                    $mobile = 'N/A';
                    $val['email']='N/A'  ;       

                }

                //wallet balce for customer
                if($val['wallet']['balance']!="" || $val['wallet']['balance']!=null ){
                    $walletbalance =$val['wallet']['balance'];
                }else{
                    $walletbalance='N/A';

                }

                //softlimit
                if($val['walletSoftLimit']=="" || $val['walletSoftLimit']==null){
                    $softLimit='N/A';
                }else{
                    $softLimit=$val['walletSoftLimit'];

                }

                //hard limit
                if($val['walletHardLimit']=="" || $val['walletHardLimit']==null){
                    $hardLimit='N/A';
                }else{
                    $hardLimit=$val['walletHardLimit'];

                }



                break;
                
                case 'stores':

                
                if($val['firstName']!="" || $val['firstName']!=null ){
                   
                    $name = $val['firstName'];
                    $mobile = $val['countryCode'] . " " . $val['phone'];
                }else{
                    $name = 'N/A';
                    $mobile = 'N/A';
                    $val['email']='N/A'  ;       

                }
                $mobile= $val['countryCode']." ".$val['phone'];

                //wallet balce for customer
                if($val['wallet']['balance']!="" || $val['wallet']['balance']!=null ){
                    $walletbalance =$val['wallet']['balance'];
                }else{
                    $walletbalance='N/A';

                }

                //softlimit
                if($val['walletSoftLimit']=="" || $val['walletSoftLimit']==null){
                    $softLimit='N/A';
                }else{
                    $softLimit=$val['walletSoftLimit'];

                }

                //hard limit
                if($val['walletHardLimit']=="" || $val['walletHardLimit']==null){
                    $hardLimit='N/A';
                }else{
                    $hardLimit=$val['walletHardLimit'];

                }

                break;

               
                default :
                $name = $val['firstName'] . " " . $val['lastName'];
                $mobile = $val['phone']['countryCode'] . " " . $val['phone']['phone'];
                break;
        }

        $arr[] = array(
            $i++,
            $name,
            $val['email'],
            $mobile,
            $val['currencySymbol'] . " " .$walletbalance,
           
           //$val['currencySymbol'] . " " . $val['walletSoftLimit'],
           //$val['currencySymbol'] . " " . $val['walletHardLimit'],

           $val['currencySymbol'] . " " .$softLimit,
           $val['currencySymbol'] . " " .$hardLimit,
            '<input type="checkbox" class="checkbox" value="' . $val['_id']['$oid'] . '" data-currency="' . $val['currency'] . '" data-currencySymbol="' . $val['currencySymbol'] . '"  data-cityName="' . $val['cityName'] . '" data-email="' . $val['email'] . '">',
            "<a type='button' class='btn btn-success cls111' href='" . base_url('index.php?/wallet') . "/details/" . $userType . "/" . $val['_id']['$oid'] . "'> 
                <i class='fa fa-tasks'></i> Statement
            </a>"
        );

      
    }
    $respo["aaData"] = $arr;
    echo json_encode($respo);
}

//end from date to end date*************


}

?>