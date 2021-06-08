<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class PayoffModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        error_reporting(false);
    }
    
    function datatable_payoff(){
        $this->load->library('mongo_db');
        $this->load->library('Datatables');

        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "cities.cityName";

        //$respo = $this->datatables->datatable_mongodb('cities', array("isDeleted" => false));
    $respo = $this->datatables->datatable_mongodbAggregate('cities', array(array('$unwind' => '$cities'),
        array('$match'=>array('cities.isDeleted'=>FALSE)),
        array('$project'=>array("country"=>1,"cities.cityId"=>1,"cities.cityName"=>1,"cities.state"=>1,"cities.currency"=>1,"cities.currencySymbol"=>1,"cities.mileageMetric"=>1,"cities.paymentMethods"=>1,"cities.isDeleted"=>1)),
         array('$sort'=>array('cities.cityId'=> -1))
    ),
     array(array('$unwind' => '$cities'),array('$match'=>array('cities.isDeleted'=>FALSE)),array('$group'=>array('_id'=>1,count=>array('$sum'=>1))))
    );
    
        $cities = $respo["aaData"];
        // echo '<pre>';print_r( $cities);die;
        $arr = [];
        $i = $_POST['iDisplayStart'] + 1;
        foreach ($cities as $val) {
            $myId=((string)$val->cities->cityId);
            $val->cities->cityId = (string)$val->cities->cityId;
            $val = json_decode(json_encode($val),TRUE);
            $result = $val['cities'];
            // echo '<pre>';print_r($result);die;

            //$result['operators'] = $this->mongo_db->where(array('cityId' => new MongoDB\BSON\ObjectID($result['_id']['$oid']),"accountType"=>0))->count('driver');
            //$result['masters'] = $this->mongo_db->where(array('cityId' => new MongoDB\BSON\ObjectID($result['_id']['$oid']),"accountType"=>1))->count('driver');
             $result['operators'] = $this->mongo_db->where(array('cityId' => $result['cityId'],"accountType"=>0))->count('driver');
            $result['masters'] = $this->mongo_db->where(array('cityId' => $result['cityId'],"accountType"=>1))->count('driver');
            $result['store'] = $this->mongo_db->where(array('cityId' => $result['cityId']))->count('stores');
            $arr[] = array(
                $i++,
                $result['cityName'],
                "<a type='button' class='btn btn-success cls100' href='" . base_url() . "index.php?/payoff/details/driver/" . $result['cityId'] . "'>" .
                    $result['operators'] .
                "</a>",
                // "<a type='button' class='btn btn-success cls100' href='" .  base_url() . "index.php?/payoff/details/driver/" . $result['cityId'] . "'>" .
                //     $result['masters'] .
                // "</a>",
                "<a type='button' class='btn btn-success cls100' href='" . base_url() . "index.php?/payoff/details/stores/" . $result['cityId'] . "'>" .
                    $result['store'] .
                "</a>",
            );
        }
        $respo["aaData"] = $arr;
        echo json_encode($respo);
    }
    
    function datatable_payoff_details($userType, $tableName){
      
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
       
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "city";
     

        $respo = $this->datatables->datatable_mongodb($tableName, array("cityId" => new MongoDB\BSON\ObjectID($_POST['cityId'])));
        // echo '<pre>';print_r($respo);die;
        $cities = $respo["aaData"];
        
        $arr = [];
        foreach ($cities as $val) {
            $arr[] = array(
                ($val['startDate'] == '')? "-- --" :  date('d-M-Y h:i:s a ', ($val['startDate']['$date']) - ($this->session->userdata('timeOffset') * 60)),
                //date("d M,Y h:i:s a", $val['endDate']['$date'] / 1000),
                date('d-M-Y h:i:s a ', ($val['endDate']['$date']) - ($this->session->userdata('timeOffset') * 60)),
                $val['trips'],
                $val['totalBilling'],
                "<a type='button' class='btn btn-info cls100' href='" . base_url('index.php?/payoff') . "/userDetails/" . $userType . "/" . $val['_id']['$oid'] . "'>" .
                    count($val['usersList']) .
                "</a>",
                $val['cashCollect'],
                $val['payable'],
                count($val['successPayment']),
                count($val['issuedPayment']),
                count($val['cashCollection']),
                "<a type='button' class='btn btn-success cls111' href='" . base_url('index.php?/payoff') . "/payoffReport/" . $userType . "/" . $val['cityId']['$oid'] . "/" . $val['_id']['$oid'] ."'> 
                    <i class='fa fa-file'></i> Report
                </a>"
            );
        }
        $respo["aaData"] = $arr;
        echo json_encode($respo);
    }
    
    function payoff() {
        $url = APILink . 'admin/payoff';
        $this->load->library('CallAPI');
        $authKey = $this->session->userdata('godsviewToken'); 
        $headers = array(
            'Content-Type: application/json',
            'authorization:'.$authKey,
            'language:en'

        );
        $postData=json_encode($_POST);
        // echo '<pre>';print_r($_POST);die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        //$result = curl_exec($ch);
        $response = json_decode(curl_exec($ch), TRUE);
        $response['statusCode'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
      // $response = $this->callapi->CallAPI('POST', $url, $_POST, true, 'application/json');
       if ($response['statusCode'] == 200) {
            return array(
                'error' => 0,
                'data' => $response['data'],
                'statusCode' => $response['statusCode'],
                'msg' => (($response['message'] == '') ? "Payoff Success" : $response['message']),
            );
        } else {
            return array(
                'error' => 1,
                'data' => $response,
                'msg' => $response['statusCode'] . " " . (($response['message'] == '') ? "Internal Server Error" : $response['message']),
                'statusCode' => $response['statusCode']
            );
        }
    }

    function payoffReport($userTable, $tableName, $cityId, $cycleId) {
        $this->load->library('mongo_db');
        
        $cycleData = $this->mongo_db->where(array('cityId' => new MongoDB\BSON\ObjectID($cityId)))->order_by(array("endDate" => "desc"))->find_one($tableName);
        if($cycleId !== ''){
            $cycleData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($cycleId)))->find_one($tableName);
        }
        
        $allExportData = array();
        foreach ($cycleData['usersList'] as $each) {
           // echo '<pre>'; print_r($each);die;
            $userData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($each['id']['$oid'])))->find_one($userTable);

            if($userTable=="stores"){
                $name=$userData['ownerName'];
                $email=$userData['ownerEmail'];
            }else{
                $name=$userData['firstName'] . " " . $userData['lastName'];
                $email=$userData['email'];
            }
            
            $arr['Name'] = $name;
            $arr['Email'] = $email;
            $arr['Balance'] = $each['currencySymbol'] . ' ' . abs($each['wallet']);
            $arr['TXN Date'] = date("d M,Y h:i:s a", $each['txnDate']['$date'] / 1000);
           // $arr['TXN Date'] =   date('d-M-Y h:i:s a ', ( $each['txnDate']['$date']) - ($this->session->userdata('timeOffset') * 60));
            $arr['Status'] = $each['message'];
            $allExportData[] = $arr;
        }
        $file_name = $fileName = $tableName . "_" . time() . ".xls";
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->stream($file_name, $allExportData);
            
//        echo json_encode(array('error' => 0, 'data' => $_POST, 'msg' => ""));
    }

    public function getPayoffDetails($tableName, $payoffId) {
        $this->load->library('mongo_db');
      
        return $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($payoffId)))->find_one($tableName);
        
        
    }
    
    function datatable_user_details($userTable, $tableName){

        // echo $userTable;
        // echo '<br>';
        // echo $tableName;die;
        
        $this->load->library('mongo_db');
        $this->load->library('Datatables');

        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "firstName";

        $data = '$usersList';
        switch((int) $_POST['tabType']){
            case 1:
                $data = 'successPayment';
                break;
            case 2:
                $data = 'issuedPayment';
                break;
            case 3:
                $data = 'cashCollection';
                break;
        }
        $condition = array(
            array(
                '$match' => array(
                    "_id" => new MongoDB\BSON\ObjectID($_POST['payoffId'])
                )
            ),
            array(
                '$unwind' => '$'.$data
            )
        );
        
           $countRecordCondition = array(
            array(
                '$match' => array(
                    "_id" => new MongoDB\BSON\ObjectID($_POST['payoffId'])
                )
            ),
            array(
                '$unwind' => '$'.$data
            ),
            array(
                '$group' => array(
                    "_id" => 0, 'count' => array('$sum' => 1)
                )
            )
        );
           
         
        $respo = $this->datatables->datatable_mongodbAggregate($tableName, $condition,$countRecordCondition);

        $arr = [];
        $slno = 1;
        
       
        foreach ($respo['aaData'] as $user) {
            // $each = $user->$data;
            // $userData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($each->id)))->find_one($userTable);
            // $arr[] = array(
            //     $slno++,
            //     $userData['firstName'] . " " . $userData['lastName'],
            //     $userData['email'],
            //     $userData['countryCode']. $userData['mobile'],
            //    $each->currency,
            //     $each->currencySymbol . ' ' . abs($each->wallet),
            //     $each->message,
            //     ($each->txnId == '')?"N/A":$each->txnId
            // );

            $each = $user->$data;          
            $userData = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($each->id)))->find_one($userTable);
            //   print_r( $userData);die;
            if($userTable=="stores"){
                $name=$userData['sName']['en'];
                $email=$userData['ownerEmail'];
                $mobile=$userData['countryCode']. $userData['ownerPhone'];
               
            }else{
               $name=$userData['firstName'] . " " . $userData['lastName'];
               $email=$userData['email'];
               $mobile=$userData['countryCode']. $userData['mobile'];
            }   

            $arr[] = array(
                $slno++,
                // $userData['firstName'] . " " . $userData['lastName'],
                $name,
                // $userData['email'],
                $email,
                // $userData['countryCode']. $userData['mobile'],
                $mobile,
                $each->currency,
                $each->currencySymbol . ' ' . abs($each->wallet),
                $each->message,
                ($each->txnId == '')?"N/A":$each->txnId
            );
        }
        
        $respo['aaData'] = $arr;
        echo json_encode($respo);
//       if ($this->input->post('sSearch') != '') {
//            $FilterArr = array();
//            foreach ($arr as $row) {
//                $needle = strtoupper($this->input->post('sSearch'));
//                $ret = array_keys(array_filter($row, function($var) use ($needle) {
//                            return strpos(strtoupper($var), $needle) !== false;
//                        }));
//                if (!empty($ret)) {
//                    $FilterArr [] = $row;
//                }
//            }
//            echo $this->datatables->getdataFromMongo($FilterArr);
//        }
//        if ($this->input->post('sSearch') == '')
//            echo $this->datatables->getdataFromMongo($arr);
    }
    
}

?>