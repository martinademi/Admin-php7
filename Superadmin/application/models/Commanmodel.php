<?php

class Commanmodel extends CI_Model {

     function __construct() {
        parent::__construct();
    }

    function ConnectToDb() {
        $db_Connect = new MongoClient('mongodb://InstacartdbAdmin:WMdoenrkfHDKrmgil@localhost:27017/Instacart') or die("Connection failed");
        $db_Name = $db_Connect->Instacart;
        return $db_Name;
    }

    function FindAll($p_CollectionName, $p_Bid = "") {
        $db_Name = $this->ConnectToDb();
        $l_CollectionName = $db_Name->$p_CollectionName;
        if ($p_Bid == "") {
            //$l_Result = $l_CollectionName->find()->sort(array("_id" => -1));
            $l_Result = $l_CollectionName->find();
            return iterator_to_array($l_Result);
        }

        $l_Result = $l_CollectionName->find(array("ShopId" => $p_Bid))->sort(array("_id" => -1));
        return $l_Result;

    }
    function findById($collectionName='',$data)
    {
        $db_Name = $this->ConnectToDb();
        $l_CollectionName = $db_Name->collectionName;
        $result= $l_CollectionName->find($data)->sort(array('_id'=>-1));
        return $result;
    }
    function findAllBanners()
    {
        $db_Name = $this->ConnectToDb();
        $l_CollectionName = $db_Name->banners;
        $p_CollectionName = $db_Name->products;
        $storeCollectionName=$db_Name->ProviderData;
        $result= $l_CollectionName->find()->sort(array('bannerOrder'=>1));
        $bannerData=array();
        foreach ($result as $row) 
        {
            $count=0;
            $productCount=(sizeof($row['products']));
            foreach ($row['products'] as $value) 
            {
               $products=$p_CollectionName->findOne(array('_id'=>new MongoId($value),'Bstatus'=>"1"));
               if(count($products)!=0)
               {
                    $storeData=$storeCollectionName->findOne(array('_id'=>new MongoId($products['Bid']),"Status"=>array('$eq'=>"1")));
                    if($storeData)
                    {
                        $count++;
                    }
                }
            }
            array_push($bannerData, array('_id'=>$row['_id'],'bannerName'=>$row['bannerName'],'orderNo'=>$row['bannerOrder'],'bannerDescription'=>$row['bannerDescription'],'imageurl'=>$row['imageurl'],'count'=>$count));
        }
        return $bannerData;
    }
    function countRecord($collectionName='')
    {
        $db_Name = $this->ConnectToDb();
        $l_CollectionName = $db_Name->$collectionName;
        $result= $l_CollectionName->find()->count();
        return $result;
    }
    function findAllProductbasedCategory($id='')
    {
        $db_Name = $this->ConnectToDb();
        $l_CollectionName = $db_Name->products;
        $result= $l_CollectionName->find(array("Bstatus"=>"1",'Bid' => (string)$id))->sort(array('_id'=>-1));
        $productsdata=array();
        foreach ($result as $row) 
        {
           if(is_null($row['CategoryId']))
            {
                $categoryName="N/A";
            }
            else
            {
                $catCollectionName = $db_Name->ProviderTypes;
                $catresult=$catCollectionName->findOne(array('_id'=>new MongoId($row['CategoryId'])));
                $categoryName=$catresult['TypeName'];
            }
            if(is_null($row['Subcategoryid']))
            {
                $subCategoryName="N/A";
            }
            else
            {
                $subcatCollectionName = $db_Name->ProviderCategory;
                $subCatresult=$subcatCollectionName->findOne(array('_id'=>new MongoId($row['Subcategoryid'])));
                $subCategoryName=$subCatresult['Category'];
            }
            $SubSubcategory=$row['SubSubcategory'];
            if(is_null($SubSubcategory)|| $SubSubcategory ==""||$SubSubcategory=="0")
            {
                $ssCategoryName="N/A";
            }
            else
            {
                $ssCollectionName = $db_Name->Interests;
                $ssresult=$ssCollectionName->findOne(array('_id'=>new MongoId($row['SubSubcategory'])));
                $ssCategoryName=$ssresult['Interest'];
            }
            array_push($productsdata, array('_id' => $row['_id'], 'ProductName'=>$row['ProductName'],'Masterimageurl'=>$row['Masterimageurl'],'ProductPrice'=>$row['ProductPrice'],'TotalQty'=>$row['TotalQty'],'categoryName'=>$categoryName,'subCategoryName'=>$subCategoryName,'subSubCategoryName'=>$ssCategoryName));
        }
        return $productsdata;
    }
    function findAllCategory()
    {
        $catArray=array();
        $db_Name = $this->ConnectToDb();
        $storeCollectionName = $db_Name->ProviderData;
        $productsCollection=$db_Name->products;
        $result= $storeCollectionName->find(array("Status"=>"1"))->sort(array('_id'=>-1));
        if($result)
        {
            foreach ($result as $value) {

                $productsData= $productsCollection->findOne(array("Bstatus"=>"1","Bid"=>(string)$value['_id']));
                if(count($productsData)!=0)
                {
                    array_push($catArray,array("TypeName"=>$value["ProviderName"],"_id"=>$value['_id']));
                }
            }
        }
        else{
            return $catArray;
        }
        return $catArray;
    }
    function FindShopName($p_CollectionName, $p_Bid = "") {
        $db_Name = $this->ConnectToDb();
        $l_CollectionName = $db_Name->$p_CollectionName;

        $l_Result = $l_CollectionName->findOne(array("_id" => new MongoId($p_Bid)));
        return $l_Result;

    }

    function insertRow($collectionName,$data)
    {
        $dbName = $this->ConnectToDb();
        $collection = $dbName->$collectionName;
        $collection->insert($data);
        return true;
    }

    function updateRow($collectionName,$cond,$data,$option = '')
    {
        $dbName = $this->ConnectToDb();
        $collection = $dbName->$collectionName;
        if($option != ''){
             $collection->update($cond,$data,array('multiple' => true));
        }
        else{
            $collection->update($cond,$data);
        }
        return ;
    }
    function countRow($collectionName='')
    {
        $dbName = $this->ConnectToDb();
        $collection = $dbName->$collectionName;
        $recordcount=$collection->find()->count();
        return $recordcount;
    }
    function removeRow($collectionName,$data)
    {
        $dbName = $this->ConnectToDb();
        $collection = $dbName->$collectionName;
        $collection->remove($data);
        return true;
    }

    function findRecord($collectionName,$data)
    {
        $dbName = $this->ConnectToDb();
        $collection = $dbName->$collectionName;
        $row=$collection->findOne($data);
        if($row)
        {
            return true;
        }
        return false;
    }

    function getOne($collectionName,$data)
    {
        $dbName = $this->ConnectToDb();
        $collection = $dbName->$collectionName;
        $row=$collection->findOne($data);

        if($row)
        {
           return $row;
        }
        return false;
    }

    function getWhere($collectionName,$data)
    {
        $dbName = $this->ConnectToDb();
        $collection = $dbName->$collectionName;
        $rows=$collection->find($data)->sort(array('_id'=>-1));
        if(sizeof($rows)>0)
        {
           return iterator_to_array($rows);
        }
        return false;
    }
    public function sendpush($registrationIds,$data)
    {       
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAAg4Gg-nk:APA91bFZjgBN6JpIcV_mC68hdVksPDsHoG982qNZh6z0Jvd8nhottEpdLRFr2W9GimpK50v7gobcQcgS43lT5Xr4qHce33nGrFXOTgQ_Sztqa2Pl3l-_WULfgyVblls_FNnUDUkwcgPd';

        /*$fields = array();
        //$fields['data'] = $data;  
        $data['sound']=1;
        $data['vibrate']=1;
        $fields['notification'] = $data;
        $fields['registration_ids'] = $registrationIds;  
        $fields['priority'] ="high";  */      
        $fields = array(
            'registration_ids'=>array($registrationIds),
            'notification'=>$data,
            'data' =>array('sound'=>"sms-received.wav",'vibrate'=>1),
            'priority'=>"high"
        );
        //header with content_type api key
        $headers = array(
                'Content-Type:application/json',
          'Authorization:key='.$server_key
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
        }        
        curl_close($ch);        
    }
    
   function sendmail($to, $subject, $body) {
        $mg_api = 'key-20fe54af019fe22b795f78cd3159aa09';
        $mg_version = 'api.mailgun.net/v3/';
        $mg_domain = "fancy-clone.com";

    $mg_message_url = "https://" . $mg_version . $mg_domain . "/messages";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $mg_api);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    //curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $emailSetter = array('from' => 'sellr team <' . 'noreply@fancy-clone.com' . '>',
        'to' => $to,
        'subject' => $subject,
        'html' => $body
    );
    curl_setopt($ch, CURLOPT_URL, $mg_message_url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $emailSetter);
    $result = curl_exec($ch);
    print_r($result);
    curl_close($ch);
    $res = json_decode($result, TRUE);
    print_r($res);
}
    function sendMessage($body,$phone)
    {                   
        require_once $_SERVER["DOCUMENT_ROOT"].'/sellr/Twilio/Twilio.php';  
        define("ACCOUNT_SID", "AC532445fb0698eb53c754f5eb7a7dcd23");
        define("AUTH_TOKEN", "32b32b6baf31f33fad7f47ee820469c0");
        define("ACCOUNT_NUMBER", "(404) 328-7099");
        
        if (substr($phone, 0, 1) != '+') 
        {  
            $phone='+'.$phone;
        }
       try{
            $client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN);
            $message = $client->account->messages->create(array(
                'To' =>$phone,
                'From' => ACCOUNT_NUMBER,
                'Body' => $body
            ));
       }catch (Exception $ex){
           return;
       }
        
    }
    
    function sendMailtoadmin($email){
        $row = $this->getOne('SuperAdmin',array('email' => $email));
        if($row){
            $subject = 'Current Password For Login For Superadmin :';
            $body = 'Your Password is :'.$row['password'];
            $this->sendmail($email,$subject,$body);
            return 'success';
        }else{
            return 'failed';
        }
    }
    function getWhereSort($collectionName,$data,$sortarray)
    {
        $dbName = $this->ConnectToDb();
        $collection = $dbName->$collectionName;
        $rows=$collection->find($data)->sort($sortarray);
        if(sizeof($rows)>0)
        {
           return iterator_to_array($rows);
        }
        return false;
    }
}

?>
