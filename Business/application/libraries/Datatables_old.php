<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Ignited Datatables
 *
 * This is a wrapper class/library based on the native Datatables server-side implementation by Allan Jardine
 * found at http://datatables.net/examples/data_sources/server_side.html for CodeIgniter
 *
 * @package    CodeIgniter
 * @subpackage libraries
 * @category   library
 * @version    0.7
 * @author     Vincent Bambico <metal.conspiracy@gmail.com>
 *             Yusuf Ozdemir <yusuf@ozdemir.be>
 * @link       http://codeigniter.com/forums/viewthread/160896/
 */
class Datatables {

    /**
     * Global container variables for chained argument results
     *
     */
    protected $ci;
    protected $table;
    protected $distinct;
    protected $group_by;
    protected $select = array();
    protected $joins = array();
    protected $columns = array();
    protected $where = array();
    protected $filter = array();
    protected $add_columns = array();
    protected $edit_columns = array();
    protected $unset_columns = array();

    /**
     * Copies an instance of CI
     */
    public function __construct() {
        $this->ci = & get_instance();
    }

    /**
     * If you establish multiple databases in config/database.php this will allow you to
     * set the database (other than $active_group) - more info: http://codeigniter.com/forums/viewthread/145901/#712942
     */
    public function set_database($db_name) {
        $db_data = $this->ci->load->database($db_name, TRUE);
        $this->ci->db = $db_data;
    }

    /**
     * Generates the SELECT portion of the query
     *
     * @param string $columns
     * @param bool $backtick_protect
     * @return mixed
     */
    public function select($columns, $backtick_protect = TRUE) {
        foreach ($this->explode(',', $columns) as $val) {
            $column = trim(preg_replace('/(.*)\s+as\s+(\w*)/i', '$2', $val));
            $this->columns[] = $column;
            $this->select[$column] = trim(preg_replace('/(.*)\s+as\s+(\w*)/i', '$1', $val));
        }

        $this->ci->db->select($columns, $backtick_protect);
        return $this;
    }

    /**
     * Generates the DISTINCT portion of the query
     *
     * @param string $column
     * @return mixed
     */
    public function distinct($column) {
        $this->distinct = $column;
        $this->ci->db->distinct($column);
        return $this;
    }

    /**
     * Generates the GROUP_BY portion of the query
     *
     * @param string $column
     * @return mixed
     */
    public function group_by($column) {
        $this->group_by = $column;
        $this->ci->db->group_by($column);
        return $this;
    }

    /**
     * Generates the FROM portion of the query
     *
     * @param string $table
     * @return mixed
     */
    public function from($table) {
        $this->table = $table;
        $this->ci->db->from($table);
        return $this;
    }

    /**
     * Generates the JOIN portion of the query
     *
     * @param string $table
     * @param string $fk
     * @param string $type
     * @return mixed
     */
    public function join($table, $fk, $type = NULL) {
        $this->joins[] = array($table, $fk, $type);
        $this->ci->db->join($table, $fk, $type);
        return $this;
    }

    /**
     * Generates the WHERE portion of the query
     *
     * @param mixed $key_condition
     * @param string $val
     * @param bool $backtick_protect
     * @return mixed
     */
    public function where($key_condition, $val = NULL, $backtick_protect = TRUE) {
        $this->where[] = array($key_condition, $val, $backtick_protect);
        $this->ci->db->where($key_condition, $val, $backtick_protect);
        return $this;
    }

    /**
     * Generates the WHERE portion of the query
     *
     * @param mixed $key_condition
     * @param string $val
     * @param bool $backtick_protect
     * @return mixed
     */
    public function or_where($key_condition, $val = NULL, $backtick_protect = TRUE) {
        $this->where[] = array($key_condition, $val, $backtick_protect);
        $this->ci->db->or_where($key_condition, $val, $backtick_protect);
        return $this;
    }

    /**
     * Generates the WHERE portion of the query
     *
     * @param mixed $key_condition
     * @param string $val
     * @param bool $backtick_protect
     * @return mixed
     */
    public function like($key_condition, $val = NULL, $backtick_protect = TRUE) {
        $this->where[] = array($key_condition, $val, $backtick_protect);
        $this->ci->db->like($key_condition, $val, $backtick_protect);
        return $this;
    }

    /**
     * Generates the WHERE portion of the query
     *
     * @param mixed $key_condition
     * @param string $val
     * @param bool $backtick_protect
     * @return mixed
     */
    public function filter($key_condition, $val = NULL, $backtick_protect = TRUE) {
        $this->filter[] = array($key_condition, $val, $backtick_protect);
        return $this;
    }

    /**
     * Sets additional column variables for adding custom columns
     *
     * @param string $column
     * @param string $content
     * @param string $match_replacement
     * @return mixed
     */
    public function add_column($column, $content, $match_replacement = NULL) {
        if (strpos($content, '<img') !== FALSE) {
            $xpath = new DOMXPath(@DOMDocument::loadHTML($content));
            $src = $xpath->evaluate("string(//img/@src)");
            $imgpath = explode('/', $src);
            if ($imgpath[sizeof($imgpath) - 1] == '')
                $content = '<img src="http://opaicosollinux.cloudapp.net/OPA/admin/img/user.jpg" width="50px" height="50px">';
//        else
//        $content = '<img src="http://opaicosollinux.cloudapp.net/OPA/admin/img/user.jpg" width="50px" height="50px">';
        }

        $this->add_columns[$column] = array('content' => $content, 'replacement' => $this->explode(',', $match_replacement));
//      print_r($this->add_columns);
//      exit();
        return $this;
    }

    /**
     * Sets additional column variables for editing columns
     *
     * @param string $column
     * @param string $content
     * @param string $match_replacement
     * @return mixed
     */
    public function edit_column($column, $content, $match_replacement) {
        $this->edit_columns[$column][] = array('content' => $content, 'replacement' => $this->explode(',', $match_replacement));
        return $this;
    }

    /**
     * Unset column
     *
     * @param string $column
     * @return mixed
     */
    public function unset_column($column) {
        $this->unset_columns[] = $column;
        return $this;
    }


    public function franchise_Data($aaData = array()) {
//        print_r($aaData);
////        echo 'asdf';
//        exit();
        $sColumns = $this->columns; //array_diff($this->columns, $this->unset_columns);
////      $sColumns = array_merge_recursive($sColumns, array_keys($this->add_columns));
//
        if($aaData == null){
            $aaData = [];
        }
        $sOutput = array
            (
            'sEcho' => intval($this->ci->input->post('sEcho')),
            'iTotalRecords' => count($aaData),
            'iTotalDisplayRecords' => '20',
            'aaData' => $aaData,
            'sColumns' => implode(',', $sColumns)
        );

        if (strtolower($charset) == 'utf-8')
            return json_encode($sOutput);
        else
            return $this->jsonify($sOutput);
    }
    
    
    public function driver_Data($aaData = array()) {

        $this->get_paging();
        $this->get_ordering();
        $this->get_filtering();
        $this->getdataFromMongo1($aaData);
    }
    
    public function getdataFromMongo1($aaData) {


        $datatosend=array();

        $iStart = $this->ci->input->post('iDisplayStart');
        $iLength = $this->ci->input->post('iDisplayLength');

        $iTotal = $this->getTotalMongocount($aaData);
        $iFilteredTotal = $this->getTotalMongocount($aaData); //$this->get_total_results(TRUE);
        $dataformMongo = array();
        $l = 0;

        

        for ($i = $iStart,$k=0; $i <= ($iStart+$iLength); $i++,$k++) {

            if($aaData[$i] == '')
                break;
            $datatosend[$k] = $aaData[$i];
        }


//        $sColumns = array_diff($this->columns, $this->unset_columns);
        $sColumns = array('DRIVER ID', 'DRIVER NAME', 'EMAIL', 'MOBILE', 'REG DATE', 'LOGIN DATE AND TIME','PROFILE PIC', 'SELECT'); //array_merge_recursive($sColumns, array_keys($this->add_columns));
//        print_r($aaData);
//        exit();
        $sOutput = array
            (
            'sEcho' => intval($this->ci->input->post('sEcho')),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => $datatosend,
            'sColumns' => implode(',', $sColumns)
        );


        echo json_encode($sOutput);

    }

    /**
     * Builds all the necessary query segments and performs the main query based on results set from chained statements
     *
     * @param string charset
     * @return string
     */
    public function generate($charset = 'UTF-8') {
        $this->get_paging();
        $this->get_ordering();
        $this->get_filtering();
        return $this->produce_output($charset);
    }

        public function generateForMongo($table,$charset = 'UTF-8') 
                {
        $this->get_paging();
        $this->get_ordering();
        $this->get_filtering();
        return $this->produce_output_formonogo($charset,$table);
    }
    /**
     * Generates the LIMIT portion of the query
     *
     * @return mixed
     */
    protected function get_paging() {
        $iStart = $this->ci->input->post('iDisplayStart');
        $iLength = $this->ci->input->post('iDisplayLength');
        $this->ci->db->limit(($iLength != '' && $iLength != '-1') ? $iLength : 100, ($iStart) ? $iStart : 0);
    }
    
 

    /**
     * Generates the ORDER BY portion of the query
     *
     * @return mixed
     */
    protected function get_ordering() {
        if ($this->check_mDataprop())
            $mColArray = $this->get_mDataprop();
        elseif ($this->ci->input->post('sColumns'))
            $mColArray = explode(',', $this->ci->input->post('sColumns'));
        else
            $mColArray = $this->columns;

        $mColArray = array_values(array_diff($mColArray, $this->unset_columns));
        $columns = array_values(array_diff($this->columns, $this->unset_columns));

        for ($i = 0; $i < intval($this->ci->input->post('iSortingCols')); $i++)
            if (isset($mColArray[intval($this->ci->input->post('iSortCol_' . $i))]) && in_array($mColArray[intval($this->ci->input->post('iSortCol_' . $i))], $columns) && $this->ci->input->post('bSortable_' . intval($this->ci->input->post('iSortCol_' . $i))) == 'true')
                $this->ci->db->order_by($mColArray[intval($this->ci->input->post('iSortCol_' . $i))], $this->ci->input->post('sSortDir_' . $i));
    }

    /**
     * Generates the LIKE portion of the query
     *
     * @return mixed
     */
    protected function get_filtering() {
        if ($this->check_mDataprop())
            $mColArray = $this->get_mDataprop();
//      elseif($this->ci->input->post('sColumns'))
//        $mColArray = explode(',', $this->ci->input->post('sColumns'));
        else
            $mColArray = $this->columns;




        $sWhere = '';
        $sSearch = mysql_real_escape_string($this->ci->input->post('sSearch'));
        $mColArray = array_values(array_diff($mColArray, $this->unset_columns));
        $columns = array_values(array_diff($this->columns, $this->unset_columns));



        if ($sSearch != '')
            for ($i = 0; $i < count($mColArray); $i++)
                if ($this->ci->input->post('bSearchable_' . $i) == 'true' && in_array($mColArray[$i], $columns))
                    $sWhere .= $this->select[$mColArray[$i]] . " LIKE '%" . $sSearch . "%' OR ";

        $sWhere = substr_replace($sWhere, '', -3);


//        $sWhere = substr_replace('distinct','',$sWhere);
//        echo $sWhere;
//        echo 'nodata';
//        print_r($mColArray);
//        exit();


        if ($sWhere != '')
            $this->ci->db->where('(' . $sWhere . ')');

        for ($i = 0; $i < intval($this->ci->input->post('iColumns')); $i++) {
            if (isset($_POST['sSearch_' . $i]) && $this->ci->input->post('sSearch_' . $i) != '' && in_array($mColArray[$i], $columns)) {
                $miSearch = explode(',', $this->ci->input->post('sSearch_' . $i));

                foreach ($miSearch as $val) {
                    if (preg_match("/(<=|>=|=|<|>)(\s*)(.+)/i", trim($val), $matches))
                        $this->ci->db->where($this->select[$mColArray[$i]] . ' ' . $matches[1], $matches[3]);
                    else
                        $this->ci->db->where($this->select[$mColArray[$i]] . ' LIKE', '%' . $val . '%');
                }
            }
        }

        foreach ($this->filter as $val)
            $this->ci->db->where($val[0], $val[1], $val[2]);
    }

    /**
     * Compiles the select statement based on the other functions called and runs the query
     *
     * @return mixed
     */
    protected function get_display_result() {
        $data = $this->ci->db->get();
        return $data;
    }

    /**
     * Builds a JSON encoded string data
     *
     * @param string charset
     * @return string
     */
    protected function produce_output($charset) {
        $aaData = array();
        $rResult = $this->get_display_result();
        $iTotal = $this->get_total_results();
        $iFilteredTotal = $this->get_total_results(TRUE);

        foreach ($rResult->result_array() as $row_key => $row_val) {
            $aaData[$row_key] = ($this->check_mDataprop()) ? $row_val : array_values($row_val);

            foreach ($this->add_columns as $field => $val)
                if ($this->check_mDataprop())
                    $aaData[$row_key][$field] = $this->exec_replace($val, $aaData[$row_key]);
                else
                    $aaData[$row_key][] = $this->exec_replace($val, $aaData[$row_key]);

            foreach ($this->edit_columns as $modkey => $modval)
                foreach ($modval as $val)
                    $aaData[$row_key][($this->check_mDataprop()) ? $modkey : array_search($modkey, $this->columns)] = $this->exec_replace($val, $aaData[$row_key]);

            $aaData[$row_key] = array_diff_key($aaData[$row_key], ($this->check_mDataprop()) ? $this->unset_columns : array_intersect($this->columns, $this->unset_columns));

            if (!$this->check_mDataprop())
                $aaData[$row_key] = array_values($aaData[$row_key]);
        }

        $sColumns = array_diff($this->columns, $this->unset_columns);
        $sColumns = array_merge_recursive($sColumns, array_keys($this->add_columns));

        $sOutput = array
            (
            'sEcho' => intval($this->ci->input->post('sEcho')),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => $aaData,
            'sColumns' => implode(',', $sColumns)
        );

        if (strtolower($charset) == 'utf-8')
            return json_encode($sOutput);
        else
            return $this->jsonify($sOutput);
    }
    
    
    
        protected function produce_output_formonogo($charset,$table) {
        $aaData = array();
        $rResult = $this->get_display_result();
        $iTotal = $this->get_total_results();
        $iFilteredTotal = $this->get_total_results(TRUE);

        foreach ($rResult->result_array() as $row_key => $row_val) {
            $aaData[$row_key] = ($this->check_mDataprop()) ? $row_val : array_values($row_val);

            foreach ($this->add_columns as $field => $val)
                if ($this->check_mDataprop())
                    $aaData[$row_key][$field] = $this->exec_replace($val, $aaData[$row_key]);
                else
                    $aaData[$row_key][] = $this->exec_replace($val, $aaData[$row_key]);

            foreach ($this->edit_columns as $modkey => $modval)
                foreach ($modval as $val)
                    $aaData[$row_key][($this->check_mDataprop()) ? $modkey : array_search($modkey, $this->columns)] = $this->exec_replace($val, $aaData[$row_key]);

            $aaData[$row_key] = array_diff_key($aaData[$row_key], ($this->check_mDataprop()) ? $this->unset_columns : array_intersect($this->columns, $this->unset_columns));

            if (!$this->check_mDataprop())
                $aaData[$row_key] = array_values($aaData[$row_key]);
        }

          $dataformMongo=array();
         $l = 0;

        $this->ci->load->library('mongo_db');
        $dataformMongo = array();
        foreach ($aaData as $resutl) {
            $getShipmentdata = $this->ci->mongo_db->get($table);
            foreach ($getShipmentdata as $result) {

                $dataformMongo[$l] = $result;
                 $l++;
         }
        }

        $aaData = $dataformMongo;
        $sColumns = array_diff($this->columns, $this->unset_columns);
        $sColumns = array_merge_recursive($sColumns, array_keys($this->add_columns));

        $sOutput = array
            (
            'sEcho' => intval($this->ci->input->post('sEcho')),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => $aaData,
            'sColumns' => implode(',', $sColumns)
        );

        if (strtolower($charset) == 'utf-8')
            return json_encode($sOutput);
        else
            return $this->jsonify($sOutput);
    }

    /**
     * Get result count
     *
     * @return integer
     */
    protected function get_total_results($filtering = FALSE) {
        if ($filtering)
            $this->get_filtering();

        foreach ($this->joins as $val)
            $this->ci->db->join($val[0], $val[1], $val[2]);

        foreach ($this->where as $val)
            $this->ci->db->where($val[0], $val[1], $val[2]);

        return $this->ci->db->count_all_results($this->table);
    }

    /**
     * Runs callback functions and makes replacements
     *
     * @param mixed $custom_val
     * @param mixed $row_data
     * @return string $custom_val['content']
     */
    protected function exec_replace($custom_val, $row_data) {
        $replace_string = '';

        if (isset($custom_val['replacement']) && is_array($custom_val['replacement'])) {
            foreach ($custom_val['replacement'] as $key => $val) {
                $sval = preg_replace("/(?<!\w)([\'\"])(.*)\\1(?!\w)/i", '$2', trim($val));

                if (preg_match('/(\w+)\((.*)\)/i', $val, $matches) && function_exists($matches[1])) {
                    $func = $matches[1];
                    $args = preg_split("/[\s,]*\\\"([^\\\"]+)\\\"[\s,]*|" . "[\s,]*'([^']+)'[\s,]*|" . "[,]+/", $matches[2], 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

                    foreach ($args as $args_key => $args_val) {
                        $args_val = preg_replace("/(?<!\w)([\'\"])(.*)\\1(?!\w)/i", '$2', trim($args_val));
                        $args[$args_key] = (in_array($args_val, $this->columns)) ? ($row_data[($this->check_mDataprop()) ? $args_val : array_search($args_val, $this->columns)]) : $args_val;
                    }

                    $replace_string = call_user_func_array($func, $args);
                } elseif (in_array($sval, $this->columns))
                    $replace_string = $row_data[($this->check_mDataprop()) ? $sval : array_search($sval, $this->columns)];
                else
                    $replace_string = $sval;

//          echo $replace_string;
                if ($replace_string == '')
                    $replace_string = 'user.jpg';


//         echo $replace_string;
//         echo $custom_val['content'];
                if ($custom_val['content'] == 'get_lat/$1') {
                    $custom_val['content'] = $this->get_lat($replace_string);
                } else if ($custom_val['content'] == 'get_lon/$1') {
                    $custom_val['content'] = $this->get_log($replace_string);
                } else if ($custom_val['content'] == 'get_coupon_code_per/$1') {

                    $custom_val['content'] = $this->get_coupon_code_per($replace_string);
                } else if ($custom_val['content'] == 'get_coupon_code_fixd/$1') {
                    $custom_val['content'] = $this->get_coupon_code_fixd($replace_string);
                } else if ($custom_val['content'] == 'get_storename/$1') {
                    $custom_val['content'] = $this->get_storename($replace_string, 'ProviderName');
                } else if ($custom_val['content'] == 'get_storeid/$1') {
                    $custom_val['content'] = $this->get_storename($replace_string, 'BusinessId');
                } else if ($custom_val['content'] == 'get_storeaddress/$1') {
                    $custom_val['content'] = $this->get_storename($replace_string, 'Address');
                } else if ($custom_val['content'] == 'get_lat_log/$1') {
                    $custom_val['content'] = $this->get_lat_log($replace_string);
                } else {

                    $custom_val['content'] = str_ireplace('$' . ($key + 1), $replace_string, $custom_val['content']);
                }
            }
        }

        return $custom_val['content'];
    }

    public function get_lat($id) {
        $this->ci->load->library('mongo_db');
        $cursor = $this->ci->mongo_db->get_one('location', array('user' => (int) $id));
        return $cursor['location']['latitude'];
    }

    public function get_coupon_code_per($id) {
        $this->ci->load->library('mongo_db');
        $cursor = $this->ci->mongo_db->get_one('coupons', array('coupon_code' => (string) $id));
        
        if($cursor['discount_type'] == 1){
        $return = $cursor['discount'];     
        }else{
            $return = '--';
        }
        return $return;
    }

    public function get_coupon_code_fixd($id) {
         $this->ci->load->library('mongo_db');
        $cursor = $this->ci->mongo_db->get_one('coupons', array('coupon_code' => (string) $id));
        
        if($cursor['discount_type'] == 2){
        $return = $cursor['discount'];     
        }else{
            $return = '--';
        }
        return $return;
    }

    public function get_lat_log($id) {
        $this->ci->load->library('mongo_db');
        $cursor = $this->ci->mongo_db->get_one('location', array('user' => (int) $id));
        return $cursor['location']['latitude'] . ',' . $cursor['location']['longitude'];
    }

    public function get_log($id) {
        $this->ci->load->library('mongo_db');
        $cursor = $this->ci->mongo_db->get_one('location', array('user' => (int) $id));
        return $cursor['location']['longitude'];
    }

    public function get_storename($id, $param) {
        $this->ci->load->library('mongo_db');
        $cursor = $this->ci->mongo_db->get_one('appointment', array('appointment_id' => (int) $id));
        $cursor2 = $this->ci->mongo_db->get_one('ProviderData', array('_id' => new MongoId($cursor['BusinessId'])));
        if ($param == 'Address')
            return $cursor2[$param] . ' ' . $cursor2[$param . '2'];
        return $cursor2[$param];
    }

    /**
     * Check mDataprop
     *
     * @return bool
     */
    protected function check_mDataprop() {
        if (!$this->ci->input->post('mDataProp_0'))
            return FALSE;

        for ($i = 0; $i < intval($this->ci->input->post('iColumns')); $i++)
            if (!is_numeric($this->ci->input->post('mDataProp_' . $i)))
                return TRUE;

        return FALSE;
    }

    /**
     * Get mDataprop order
     *
     * @return mixed
     */
    protected function get_mDataprop() {
        $mDataProp = array();

        for ($i = 0; $i < intval($this->ci->input->post('iColumns')); $i++)
            $mDataProp[] = $this->ci->input->post('mDataProp_' . $i);

        return $mDataProp;
    }

    /**
     * Return the difference of open and close characters
     *
     * @param string $str
     * @param string $open
     * @param string $close
     * @return string $retval
     */
    protected function balanceChars($str, $open, $close) {
        $openCount = substr_count($str, $open);
        $closeCount = substr_count($str, $close);
        $retval = $openCount - $closeCount;
        return $retval;
    }

    /**
     * Explode, but ignore delimiter until closing characters are found
     *
     * @param string $delimiter
     * @param string $str
     * @param string $open
     * @param string $close
     * @return mixed $retval
     */
    protected function explode($delimiter, $str, $open = '(', $close = ')') {
        $retval = array();
        $hold = array();
        $balance = 0;
        $parts = explode($delimiter, $str);

        foreach ($parts as $part) {
            $hold[] = $part;
            $balance += $this->balanceChars($part, $open, $close);

            if ($balance < 1) {
                $retval[] = implode($delimiter, $hold);
                $hold = array();
                $balance = 0;
            }
        }

        if (count($hold) > 0)
            $retval[] = implode($delimiter, $hold);

        return $retval;
    }

    /**
     * Workaround for json_encode's UTF-8 encoding if a different charset needs to be used
     *
     * @param mixed result
     * @return string
     */
    protected function jsonify($result = FALSE) {
        if (is_null($result))
            return 'null';

        if ($result === FALSE)
            return 'false';

        if ($result === TRUE)
            return 'true';

        if (is_scalar($result)) {
            if (is_float($result))
                return floatval(str_replace(',', '.', strval($result)));

            if (is_string($result)) {
                static $jsonReplaces = array(array('\\', '/', '\n', '\t', '\r', '\b', '\f', '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $result) . '"';
            } else
                return $result;
        }

        $isList = TRUE;

        for ($i = 0, reset($result); $i < count($result); $i++, next($result)) {
            if (key($result) !== $i) {
                $isList = FALSE;
                break;
            }
        }

        $json = array();

        if ($isList) {
            foreach ($result as $value)
                $json[] = $this->jsonify($value);

            return '[' . join(',', $json) . ']';
        } else {
            foreach ($result as $key => $value)
                $json[] = $this->jsonify($key) . ':' . $this->jsonify($value);

            return '{' . join(',', $json) . '}';
        }
    }

}

/* End of file Datatables.php */
/* Location: ./application/libraries/Datatables.php */