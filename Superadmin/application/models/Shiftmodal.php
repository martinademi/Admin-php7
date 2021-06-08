<?php

if (!defined("BASEPATH")) {
    exit("Direct access to this page is not allowed");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Shiftmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');
    }

    function getlanguageText($param = '') {

        if ($param == '') {
            $res = $this->mongo_db->get('lang_hlp');
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function colors_details($status) {

        $this->load->library('mongo_db');

        $this->load->library('Datatables');
        $this->load->library('table');

        $_POST['iColumns'] = 2;
        $_POST['mDataProp_0'] = "name";

        $sl = $_POST['iDisplayStart'] + 1;

        $respo = $this->datatables->datatable_mongodb('shiftTimings', array("status" => (int) $status), 'seqId', -1);
        $respo['lang'] = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));

        $aaData = $respo["aaData"];
        $datatosend = array();

        foreach ($aaData as $value) {
            $arr = array();

          


            // if(count($respo['lang'])<1){               
            //     $colorName=($value['colorName']['en'] != "" || $value['colorName']['en'] != null) ? $value['colorName']['en']: 'N/A';              
            //    }else{                
            //     $colorName=($value['colorName']['en'] != "" || $value['colorName']['en'] != null) ? $value['colorName']['en']: 'N/A';    
            //     foreach( $respo['lang'] as $lang){    
            //         $lan= $lang['langCode'];
            //         $colorNames=($value['colorName'][$lan] != "" || $value['colorName'][$lan] != null) ? $value['colorName'][$lan]: '';                    
            //        if(strlen( $colorNames)>0){
            //         $colorName.= ',' . $colorNames;
            //        }
            //     }
            // }



            $arr[] = $sl++;
            $arr[] =$value['shiftName'];
            $arr[] =$value['startTime'];
            $arr[] =$value['endTime'];
            $arr[] = "<a href='".base_url()."index.php?/ShiftTimings/slotDetails/".$value['_id']['$oid']."'><button class='btn btnview btn-primary cls111' style='width:35px; border-radius: 25px;display:none' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-eye' aria-hidden='true'></i></button></a> <button class='btn btndelete btn-primary cls111' style='width:35px; border-radius: 25px;' data-id='" . $value['_id']['$oid'] . "'><i class='fa fa-trash' style='font-size:12px;'></i> </button>";
         

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function addColors() {
	
		$name = $this->input->post('colorName');

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

        if (count($lanCodeArr) == count($name)) {
            $data['colorName'] = array_combine($lanCodeArr, $name);
        } else if (count($lanCodeArr) < count($name) ) {
            $data['colorName']['en'] = $name[0];
            
            foreach ($name as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']){
                            $data['colorName'][$lan['langCode']] = $val;
                        }
                    }else{
                       if ($key == $lan['lan_id']){
                            $data['colorName'][$lan['langCode']] = $val;
                        } 
                    }
                }
                
            }
        } else {
            $data['colorName']['en'] = $name[0];
        }

        $time = time();
        $datetime = $this->mongo_db->date();

        $cursor = $this->mongo_db->get("colors");
        $arr = [];
        $arrName = [];
        foreach ($cursor as $cdata) {
            array_push($arr, $cdata['seqId']);
            array_push($arrName, $cdata['colorName'][0]);
        }
        $max = max($arr);
        $seq = $max + 1;
        $data['seqId'] = $seq;
        $data['name'] = $name;
        $data['status'] = 1;
        $data['statusMsg'] = 'Active';
        $data['createdTimeStamp'] = $time;
        $data['isoDate'] = $datetime;
            // echo '<pre>'; print_r($data); die;
        if (!in_array($name[0], $arrName)) {
//            $result = array('colorName' => $name, 'seqId' => $seq, 'status' => 1,'statusMsg' => 'Active','createdTimeStamp' => $time,'isoDate' => $datetime);
            $data = $this->mongo_db->insert('colors', $data);
            echo json_encode(array('data' => $data, 'flag' => 1));
        } else {
            echo json_encode(array('data' => $data, 'flag' => 0));
        }
		
    }

    function getColor() {
        $colorId = $this->input->post('colorId');

        $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($colorId)))->find_one('colors');

        return $data;
    }

    function editColor() {
        $colorId = $this->input->post('colorId');
        $name = $this->input->post('colorName');

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
       
        if (count($lanCodeArr) == count($name)) {
            $data['colorName'] = array_combine($lanCodeArr, $name);
        } else if (count($lanCodeArr) < count($name) ) {
            $data['colorName']['en'] = $name[0];
            
            foreach ($name as $key => $val) {
                foreach ($lang as $lan) {

                    if ($lan['Active'] == 1) {
                        if ($key == $lan['lan_id']){
                            $data['colorName'][$lan['langCode']] = $val;
                        }
                    }else{
                       if ($key == $lan['lan_id']){
                            $data['colorName'][$lan['langCode']] = $val;
                        } 
                    }
                }
                
            }
        } else {
            $data['colorName']['en'] = $name[0];
        }
        $data['name'] = $name;
        try {
            $data = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($colorId)))->set($data)->update('colors');
        } catch (Exception $ex) {
            print_r($ex);
        }
        echo json_encode($data);
    }

    function activateColor() {
        $colorId = $this->input->post('colorId');

        foreach ($colorId as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 1, 'statusMsg' => 'Active'))->update('colors');
        }

        echo json_encode(array("msg" => "Selected color has been activated successfully", "flag" => 0));
    }

    function deactivateColor() {
        $colorId = $this->input->post('colorId');

        foreach ($colorId as $id) {
            $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($id)))->set(array('status' => 2, 'statusMsg' => 'Inactive'))->update('colors');
        }

        echo json_encode(array("msg" => "Selected color has been deactivated successfully", "flag" => 0));
    }


    function addSchduled($zoneId,$cityId) {

        
        $this->load->library('mongo_db');
        $timeOffset = $this->session->userdata('timeOffset');
        $timeOffset = $timeOffset * 60; 
        $data['startTime'] = $this->input->post('stTime');
        $data['endTime'] = $this->input->post('enTime');
        $data['sTime'] = $this->input->post('startTime');
        $data['eTime'] = $this->input->post('endTime');
        $data['shiftName'] = $this->input->post('shiftName');
        $data['status'] = 1;
        $data['statusMsg'] = 'Active';
        //$data['zoneId'] =$zoneId;

        $rel= $this->mongo_db->insert('shiftTimings',$data); 
        if($rel){
            $msg="Shift created successfully";
            echo json_encode(array('msg'=> $msg,'flag' => 1));
            return;
        }else{
            $msg="Shift creation failed";
            echo json_encode(array('msg'=> $msg,'flag' => 2));
            return;
        }
   
        
       
    }


    function deleteSchduled() {
        $this->load->library('mongo_db');
        $whId = $this->input->post('whId');        
        $dltdata= $this->mongo_db->where(array("_id"=> new MongoDB\BSON\ObjectID($whId)))->set(array('status'=>2,'statusMsg'=>"Deleted"))->update('shiftTimings');      
        echo json_encode($dltdata);
        
    }

}

?>
