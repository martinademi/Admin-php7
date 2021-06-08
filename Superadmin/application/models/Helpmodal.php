<?php

if (!defined("BASEPATH"))
    exit("Direct access to this page is not allowed");

class helpmodal extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function datatable_language() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');

        $respo = $this->datatables->datatable_mongodb('lang_hlp');
        $aaData = $respo["aaData"];
        $datatosend = array();

        $index = 1;
        foreach ($aaData as $value) {
            $arr = array();
            if ($value['Active'] == 1) {
                $active = 'Enabled';
            } else {
                $active = 'Disabled';
            }

            $arr[] = $index++;
            $arr[] = $value['lan_name'];
            $arr[] = $active;
            $arr[] = ($value['Active'] == 0) ? '<button class="btn btn-success btnenable cls111" id="btnenable" value="' . $value['lan_id'] . '"  data-id=' . $value['lan_id'] . ' style="border-radius: 25px;">Enable</i></button>'
                    . '<button class="btn btn-primary btnedit cls111" id="btnedit"  value="' . $value['lan_id'] . '"  data-id=' . $value['lan_id'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>'
                    . '<button class="btn btn-danger btndelete cls111" id="btndelete" value="' . $value['lan_id'] . '" data-id=' . $value['lan_id'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-trash" style="font-size:12px;"></i></button>' : '<button class="btn btn-warning btndisable" id="btndisable" value="' . $value['lan_id'] . '" data-id=' . $value['lan_id'] . ' style=" border-radius: 25px;">Disable</i></button>'
                    . '<button class="btn btn-primary btnedit" id="btnedit" value="' . $value['lan_id'] . '" data-id=' . $value['lan_id'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-edit" style="font-size:12px;"></i></button>' . '<button class="btn btn-danger btndelete" id="btndelete" value="' . $value['lan_id'] . '" data-id=' . $value['lan_id'] . ' style="width:35px; border-radius: 25px;"><i class="fa fa-trash" style="font-size:12px;"></i></button>';


            $datatosend[] = $arr;
        }


        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function get_allLan() {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->get('languageAndCode');
        $arr = [];
        foreach ($res as $data) {
            $arr = $data;
        }
        return $arr;
    }

    public function datatable_canreasonCustomer() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "reasons";

        $respo = $this->datatables->datatable_mongodb('can_reason', array('res_for' => 'customer'), '', 1);
        $aaData = $respo["aaData"];
        $datatosend = array();

        $index = 1;
        foreach ($aaData as $value) {
            $arr = array();

            $arr[] = $index++;
            $arr[] = $value['reasons'];
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '">';

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function datatable_canreasonDriver() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "reasons";

        $respo = $this->datatables->datatable_mongodb('can_reason', array('res_for' => 'driver'), '', 1);
        $aaData = $respo["aaData"];
        $datatosend = array();

        $index = 1;
        foreach ($aaData as $value) {
            $arr = array();

            $arr[] = $index++;
            $arr[] = $value['reasons'];
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '">';

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    public function datatable_canreasonDispatcher() {
        $this->load->library('mongo_db');
        $this->load->library('Datatables');
        $this->load->library('table');
        $_POST['iColumns'] = 1;
        $_POST['mDataProp_0'] = "reasons";

        $respo = $this->datatables->datatable_mongodb('can_reason', array('res_for' => 'manager'), '', 1);
        $aaData = $respo["aaData"];
        $datatosend = array();

        $index = 1;
        foreach ($aaData as $value) {
            $arr = array();

            $arr[] = $index++;
            $arr[] = $value['reasons'];
            $arr[] = '<input type="checkbox" class="checkbox" name="checkbox" value="' . $value['_id']['$oid'] . '">';

            $datatosend[] = $arr;
        }

        $respo["aaData"] = $datatosend;
        echo json_encode($respo);
    }

    function get_lan_hlpTextone($param = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('lan_id' => (int) $param))->find_one('lang_hlp');
        echo json_encode($res);
    }

    function get_lan_hlpText($param = '') {
        $this->load->library('mongo_db');
        if ($param == '') {
            $res = $this->mongo_db->get_where('lang_hlp', array('Active' => 1));
        } else {
            $res = $this->mongo_db->get_where('lang_hlp', array(array('lan_id' => (int) $param), array('Active' => 1)));
        }
        return $res;
    }

    function deleteCan() {
        $this->load->library('mongo_db');
        $ids = $this->input->post('id');
        $this->mongo_db->where(array('res_id' => (int) $ids))->delete('can_reason');
        echo json_encode(array('msg' => '1'));
    }

    function getDescription($cat_id = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('cat_id' => (int) $cat_id))->find_one('helpText');
        if ($res['desc']) {
            foreach ($res['desc'] as $fresult) {
                return $fresult;
            }
        }
    }

    function getsubDescription($cat_id = '', $subcatID = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('cat_id' => (int) $cat_id, 'sub_cat.id' => new MongoDB\BSON\ObjectID($subcatID)))->find_one('helpText');
        foreach ($res['sub_cat'] as $data) {
            if ($data['id']['$oid'] == $subcatID)
                return $data['desc'];
        }
    }

    function lan_action() {
        $this->load->library('mongo_db');

        $arr = $_POST;
        $result = $this->mongo_db->where(array('lan_name' => $arr['lan_name']))->find_one('lang_hlp');
        if ($result['lan_name'] == $arr['lan_name']) {
            echo json_encode(array('msg' => '0'));
        } else {
            if ($arr['lan_id'] == '') {
                $cursor = $this->mongo_db->get('lang_hlp');
                $data = array();
                foreach ($cursor as $res) {
                    $data = $res;
                }

                if (!empty($data))
                    $arr['lan_id'] = (int) ($data['lan_id'] + 1);
                else
                    $arr['lan_id'] = 1;

                $arr['Active'] = 1;

                $this->mongo_db->insert('lang_hlp', $arr);
                echo json_encode(array('msg' => '1', 'insert' => $arr['lan_id']));
            }else {
                $this->mongo_db->where(array('lan_id' => (int) $arr['lan_id']))->set(array("lan_name" => $arr['lan_name']))->update('lang_hlp');
                echo json_encode(array('msg' => '1', 'insert' => '0'));
            }
        }
    }

    function enable_lang() {
        $this->load->library('mongo_db');
        $val = $this->input->post('id');
        $res = $this->mongo_db->where(array('lan_id' => (int) $val))->set(array('Active' => 1))->update('lang_hlp');
        echo json_encode($res);
    }

    function deleteLang($param) {
        $this->load->library('mongo_db');
        if ($param == 'del') {
            $this->mongo_db->where(array('lan_id' => (int) $this->input->post('id')))->delete('lang_hlp');
            echo json_encode(array('msg' => '1'));
        }
    }

    function disable_lang() {
        $this->load->library('mongo_db');
        $val = $this->input->post('id');
        $res = $this->mongo_db->where(array('lan_id' => (int) $val))->set(array('Active' => 0))->update('lang_hlp');
        echo json_encode($res);
    }

    function get_can_reasons() {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->get('can_reason');
        return $res;
    }

    function getCanData() {
        $this->load->library('mongo_db');
        $id = $this->input->post('id');
        foreach ($id as $ids) {
            $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($ids)))->find_one('can_reason');
        }
        echo json_encode(array('data' => $res));
    }

    function cancell_act() {
        $this->load->library('mongo_db');
        $edit_id = $this->input->post('edit_id');
        $reasons = $this->input->post('reasons');
        $res_for = $this->input->post('res_for');
        $id = $this->input->post('id');

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

        if (count($lanCodeArr) == count($reasons)) {
            $arr['reasonObj'] = array_combine($lanCodeArr, $reasons);
        } else {
            $arr['reasonObj']['en'] = $reasons[0];
        }
//        echo '<pre>'; print_r($arr); die;
        if ($edit_id == '') {

            $cursor = $this->mongo_db->get('can_reason');
            $data = array();
            foreach ($cursor as $res) {
                $data = $res;
            }
            if (!empty($data))
                $edit_id = $data['res_id'] + 1;
            else
                $edit_id = 1;
//            array('res_id' => $edit_id, "reasons" => $reasons, 'res_for' => $res_for);
            $arr['res_id'] = $edit_id;
            $arr['reasons'] = $reasons;
            $arr['res_for'] = $res_for;
//           
            $this->mongo_db->insert('can_reason', $arr);
            echo json_encode(array('msg' => '1', 'insert' => $edit_id, 'reason' => $reasons));
            die;
        }else {

            $this->mongo_db->where(array('res_id' => (int) $edit_id))->set(array("reasons" => $reasons, 'reasonObj' => $arr['reasonObj']))->update('can_reason');
            echo json_encode(array('msg' => '1', 'insert' => 0, 'reason' => $reasons));
            die;
        }
        echo json_encode(array('msg' => '0'));
    }

    function get_cat_supportCustomer($param = '', $param2 = '') {
        $this->load->library('mongo_db');

        if ($param == '') {

            $res = $this->mongo_db->where(array('usertype' => "1"))->get('helpText');
        } else {
            if ($param2 == '')
                $res = $this->mongo_db->get_where('helpText', array('_id' => new MongoDB\BSON\ObjectID($param)));
            else
                $res = $this->mongo_db->where(array('cat_id' => (int) $param))->find_one('helpText');
        }

        return $res;
    }

    function get_cat_support($param = '', $param2 = '') {

        $this->load->library('mongo_db');
        if ($param == '') {
            $res = $this->mongo_db->where(array('usertype' => "2"))->get('helpText');
        } else {
            if ($param2 == '')
                $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->get('helpText');
            else
                $res = $this->mongo_db->where(array('cat_id' => (int) $param))->find_one('helpText');
        }

        return $res;
    }

    //store
    function get_cat_store($param = '', $param2 = '') {

        $this->load->library('mongo_db');
        if ($param == '') {
            $res = $this->mongo_db->where(array('usertype' => "3"))->get('helpText');
        } else {
            if ($param2 == '')
                $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->get('helpText');
            else
                $res = $this->mongo_db->where(array('cat_id' => (int) $param))->find_one('helpText');
        }

        return $res;
    }


    function get_subcat_support($param = '') {
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($param)))->find_one('helpText');

        return $res[sub_cat];
    }

    //subcategory
    function get_cat_SubCategory($catid) {
        
        $this->load->library('mongo_db');
        $res = $this->mongo_db->where(array('cat_id' => (int) $catid))->find_one('helpText');
        
        return $res;
    }

    function support_actionCustomer() {
        $this->load->library('mongo_db');
        $edit_id = $this->input->post('edit_id');
        $cat_id = $this->input->post('cat_id');

        $data['usertype'] = "1";
        $data['name'] = $this->input->post('cat_name');
        $data['has_scat'] = $this->input->post('cat_subcat');
        if ($data['has_scat'] == false) {
            $data['has_scat'] = false;
            if($this->input->post('desc'))
                $data['desc'] = $this->input->post('desc');
            else
               $data['desc'] = [];
        } else {
            $data['has_scat'] = true;
            $data['sub_cat'] = array();
        }

        if ($edit_id == '') {
            if ($cat_id == '') {
                $cursor = $this->mongo_db->get('helpText');
                $data1 = array();
                foreach ($cursor as $res) {
                    $data1 = $res;
                }
                if (!empty($data1)) {
                    $data['cat_id'] = $data1['cat_id'] + 1;
                } else {
                    $data['cat_id'] = 1;
                }
                $this->mongo_db->insert('helpText', $data);
            } else {
                unset($data['has_scat']);
                unset($data['sub_cat']);

                $data['id'] = new MongoDB\BSON\ObjectId();
                $result = $this->mongo_db->where(array('cat_id' => (int) $cat_id))->push(array('sub_cat' => $data))->update('helpText');
            }
        } else {
            unset($data['sub_cat']);
            $scat_id = $this->input->post('scat_id');
//            $data['id'] = new MongoDB/BSON/ObjectID();
            if ($scat_id == '') {
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->set($data)->update('helpText');
            } else {
                $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectID($scat_id)))->pull('sub_cat', array('id' => new MongoDB\BSON\ObjectID($scat_id)))->update('helpText');
                unset($data['sub_cat']);
                unset($data['has_scat']);
                $data['id'] = new MongoDB\BSON\ObjectID($scat_id);
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->push(array('sub_cat' => $data))->update('helpText');
            }
        }
    }

    function support_actionStore() {
        
        $this->load->library('mongo_db');
        $edit_id = $this->input->post('edit_id');
        $cat_id = $this->input->post('cat_id');
       
        $data['usertype'] = "3";
        $data['name'] = $this->input->post('cat_name');
        $data['has_scat'] = $this->input->post('cat_subcat');
        if ($data['has_scat'] == false) {
            $data['has_scat'] = false;
            if($this->input->post('desc'))
                $data['desc'] = $this->input->post('desc');
            else
               $data['desc'] = [];
        } else {
            $data['has_scat'] = true;
            $data['sub_cat'] = array();
        }
    
        if ($edit_id == '') {
            if ($cat_id == '') {
                $cursor = $this->mongo_db->get('helpText');
                $data1 = array();
                foreach ($cursor as $res) {
                    $data1 = $res;
                }
                if (!empty($data1)) {
                    $data['cat_id'] = $data1['cat_id'] + 1;
                } else {
                    $data['cat_id'] = 1;
                }
               
                $this->mongo_db->insert('helpText', $data);
            } else {
                unset($data['has_scat']);
                unset($data['sub_cat']);

                $data['id'] = new MongoDB\BSON\ObjectId();
                $result = $this->mongo_db->where(array('cat_id' => (int) $cat_id))->push(array('sub_cat' => $data))->update('helpText');
            }
        } else {
            unset($data['sub_cat']);
            $scat_id = $this->input->post('scat_id');
//            $data['id'] = new MongoDB/BSON/ObjectID();
            if ($scat_id == '') {
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->set($data)->update('helpText');
            } else {
                $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectID($scat_id)))->pull('sub_cat', array('id' => new MongoDB\BSON\ObjectID($scat_id)))->update('helpText');
                unset($data['sub_cat']);
                unset($data['has_scat']);
                $data['id'] = new MongoDB\BSON\ObjectID($scat_id);
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->push(array('sub_cat' => $data))->update('helpText');
            }
        }
    }

    function support_actionDriver() {
        $this->load->library('mongo_db');
        $edit_id = $this->input->post('edit_id');
        $cat_id = $this->input->post('cat_id');

        $data['usertype'] = "2";
        $data['name'] = $this->input->post('cat_name');
        $data['has_scat'] = $this->input->post('cat_subcat');
        if ($data['has_scat'] == false) {
            $data['has_scat'] = false;
            if($this->input->post('desc'))
                $data['desc'] = $this->input->post('desc');
            else
               $data['desc'] = []; 
        } else {
            $data['has_scat'] = true;
            $data['sub_cat'] = array();
        }


        if ($edit_id == '') {
            if ($cat_id == '') {
                $cursor = $this->mongo_db->get('helpText');
                $data1 = array();
                foreach ($cursor as $res) {
                    $data1 = $res;
                }
                if (!empty($data1)) {
                    $data['cat_id'] = $data1['cat_id'] + 1;
                } else {
                    $data['cat_id'] = 1;
                }
                $this->mongo_db->insert('helpText', $data);
            } else {
                unset($data['has_scat']);
                unset($data['sub_cat']);

                $data['id'] = new MongoDB\BSON\ObjectId();
                $result = $this->mongo_db->where(array('cat_id' => (int) $cat_id))->push(array('sub_cat' => $data))->update('helpText');
            }
        } else {
            unset($data['sub_cat']);
            $scat_id = $this->input->post('scat_id');
//            $data['id'] = new MongoDB/BSON/ObjectID();
            if ($scat_id == '') {
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->set($data)->update('helpText');
            } else {
                $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectID($scat_id)))->pull('sub_cat', array('id' => new MongoDB\BSON\ObjectID($scat_id)))->update('helpText');
                unset($data['sub_cat']);
                unset($data['has_scat']);
                $data['id'] = new MongoDB\BSON\ObjectID($scat_id);
                $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($edit_id)))->push(array('sub_cat' => $data))->update('helpText');
            }
        }
    }

    function email_template_action() {
        $this->load->library('mongo_db');
        $fdata = $this->input->post('fdata');
        if ($fdata['type'] == 'post') {
            $data = $this->mongo_db->where(array("temp_type" => $fdata['temp_type']))->find_one("email_template");
            $fdata['body'] = $this->input->post('body_editor');
            if (is_array($data)) {
                $this->mongo_db->where(array("temp_type" => $fdata['temp_type']))->set($fdata)->update('email_template');
            } else {
                $this->mongo_db->insert("email_template", $fdata);
            }
            redirect(base_url() . "index.php/utilities/email_template");
        } else if ($fdata['type'] == 'get') {
            $data = $this->mongo_db->where(array("temp_type" => $fdata['temp_type']))->find_one("email_template");
            if (!is_array($data)) {
                $data = array(
                    "subject" => "",
                    "from_name" => "",
                    "from_email" => "",
                    "body" => "",
                    "temp_type" => $fdata['temp_type']
                );
            }
            echo json_encode(array('flg' => 1, 'data' => $data));
        } else {
            redirect(base_url() . "index.php/utilities/email_template");
        }
    }

    function actionCustomer($param = '', $param2 = '') {

        $this->load->library('mongo_db');
        if ($param == 'subdel') {
            if ($param2 == '') {
                $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectId($this->input->post('id'))))->pull('sub_cat', array('id' => new MongoDB\BSON\ObjectId($this->input->post('id'))))->update('helpText');
                echo json_encode(array('msg' => '1'));
                die;
            }
        } else if ($param2 == '') {
            $this->mongo_db->where(array('cat_id' => (int) $this->input->post('id')))->delete('helpText');
            echo json_encode(array('msg' => '1'));
            die;
        }
    }

    // function actionDriver() {
    //     $this->load->library('mongo_db');
    //     if ($param2 == '') {
    //         $this->mongo_db->where(array('cat_id' => (int) $this->input->post('id')))->delete('helpText');
    //         echo json_encode(array('msg' => '1'));
    //         die;
    //     } else if ($param == 'subdel') {
    //         if ($param2 == '') {
    //             $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectId($this->input->post('id'))))->pull('sub_cat', array('id' => new MongoDB\BSON\ObjectId($this->input->post('id'))))->update('helpText');
    //             echo json_encode(array('msg' => '1'));
    //             die;
    //         }
    //     }
    // }

      //driver
      function actionDriver($param = '', $param2 = '') {

        $this->load->library('mongo_db');
        if ($param == 'subdel') {
            if ($param2 == '') {
                $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectId($this->input->post('id'))))->pull('sub_cat', array('id' => new MongoDB\BSON\ObjectId($this->input->post('id'))))->update('helpText');
                echo json_encode(array('msg' => '1'));
                die;
            }
        } else if ($param2 == '') {
            $this->mongo_db->where(array('cat_id' => (int) $this->input->post('id')))->delete('helpText');
            echo json_encode(array('msg' => '1'));
            die;
        }
    }

    function getEmailTemplate() {
        $data = $this->mongo_db->where(array("temp_type" => "Passenger_Signup"))->find_one("email_template");
        return $data;
    }


     //language
     function getCustomerSupportLanguage() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($this->input->post('supportId'))))->find_one('helpText');
        $getLanguages = $this->mongo_db->where(array('Active'=> 1))->get('lang_hlp');
        echo json_encode(array('data' => $getAll, 'lang' => $getLanguages));
    }

    //language for sub cat
    function getSubCustomerSupportLanguage() {
        $this->load->library('mongo_db');
        $getAll = $this->mongo_db->where(array('sub_cat.id' => new MongoDB\BSON\ObjectID($this->input->post('supportId'))))->find_one('helpText');
        $getLanguages = $this->mongo_db->where(array('Active'=> 1))->get('lang_hlp');
        echo json_encode(array('data' => $getAll, 'lang' => $getLanguages));
    }
}
