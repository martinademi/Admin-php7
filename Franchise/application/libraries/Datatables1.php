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
class Datatables1 {

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
    protected $counter;

    /**
     * Copies an instance of CI
     */
    public function __construct() {
        $this->ci = & get_instance();
        $this->counter = 1;
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

    public function getdataFromMongo($aaData) {


        $datatosend = array();

        $iStart = $this->ci->input->post('iDisplayStart');
        $iLength = $this->ci->input->post('iDisplayLength');

        $iTotal = count($aaData);
        $iFilteredTotal = count($aaData); //$this->get_total_results(TRUE);
        $dataformMongo = array();
        $l = 0;



        for ($i = $iStart, $k = 0; $i < ($iStart + $iLength); $i++, $k++) {

            if ($aaData[$i] == '')
                break;
            $datatosend[$k] = $aaData[$i];
        }


//        $sColumns = array_diff($this->columns, $this->unset_columns);
        $sColumns = array('NAME', 'STATUS', 'NO ON LOCATIONS', 'SELECT'); //array_merge_recursive($sColumns, array_keys($this->add_columns));
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

    function datatable_mongodb($collection, $queryobj = array(), $filedNameToSort = '', $sortOrder = -1) {

        $sortFiled = ($filedNameToSort == '') ? '_id' : $filedNameToSort;

//        mb_internal_encoding('UTF-8');
//        $this->ci->load->library('mongo_db');
        $database = $this->ci->mongo_db;

        /**
         * MongoDB connection
         */
        $m_collection = $collection;
        /**
         * Define the document fields to return to DataTables (as in http://us.php.net/manual/en/mongocollection.find.php).
         * If empty, the whole document will be returned.
         */
        $fields = array();

        // Input method (use $_GET, $_POST or $_REQUEST)
        $input = & $_POST;



        /**
         * Handle requested DataProps
         */
        // Number of columns being displayed (useful for getting individual column search info)
        $iColumns = $input['iColumns'];

        // Get mDataProp values assigned for each table column
        $dataProps = array();
        for ($i = 0; $i < $iColumns; $i++) {
            $var = 'mDataProp_' . $i;
            if (!empty($input[$var]) && $input[$var] != 'null') {
                $dataProps[$i] = $input[$var];
            }
        }


        /**
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large collections.
         */
        $searchTermsAny = array();
        $searchTermsAll = array();


        if (!empty($input['sSearch'])) {
            $sSearch = $input['sSearch'];

            for ($i = 0; $i < $iColumns; $i++) {
                if ($input['bSearchable_' . $i] == 'true') {
                    if ($input['bRegex'] == 'true') {
                        $sRegex = str_replace('/', '\/', $sSearch);
                    } else {
                        $sRegex = preg_quote($sSearch, '/');
                    }
                    if (is_numeric($sRegex))
                        $searchTermsAny[] = array(
                            $dataProps[$i] => (int) $sRegex
                        );
//                    else
                    $searchTermsAny[] = array(
                        $dataProps[$i] => new MongoDB\BSON\Regex($sRegex, "i")
                    );
                }
            }
        }

        //Column sorting
        if ($input['iSortCol_0'] == 6) {
            if (isset($input['userType']) && $input['userType'] == 'Customer') {
                $sortFiled = 'walletSoftLimit';
                if ($input['sSortDir_0'] == 'desc')
                    $sortOrder = -1;
                else
                    $sortOrder = 1;
            }
        }


        $searchTerms = array();
        if (!empty($searchTermsAny)) {
            $searchTerms['$or'] = $searchTermsAny;
        }


        $totalrec = $this->ci->mongo_db->where($queryobj)->count($m_collection);

        if (count($queryobj) > 0) {
            $totalrec = $this->ci->mongo_db->where($queryobj)->count($m_collection);
            if (count($searchTerms) > 0) {

                $searchTerms = array('$and' => array($queryobj, $searchTerms));
            } else {
                $searchTerms = $queryobj;
            }
        }


        /**
         * Paging
         */
        if (isset($input['iDisplayStart']) && $input['iDisplayLength'] != '-1') {
            $cursor = $this->ci->mongo_db->where($searchTerms)->offset($input['iDisplayStart'])->limit($input['iDisplayLength'])->order_by(array($sortFiled => (int) $sortOrder))->get($m_collection);
            $displayRec = $this->ci->mongo_db->where($searchTerms)->offset($input['iDisplayStart'])->limit($input['iDisplayLength'])->order_by(array($sortFiled => (int) $sortOrder))->count($m_collection);
//            $cursor->limit($input['iDisplayLength'])->skip($input['iDisplayStart']);
        }


        /**
         * Output
         */
        $output = array(
            "sEcho" => (int)($input['sEcho']),
            "iTotalRecords" => $totalrec,
            "iTotalDisplayRecords" => $totalrec,
            "aaData" => array()
        );
        foreach ($cursor as $doc) {
            $output['aaData'][] = $doc;
        }

        return $output;
    }

    public function secondsToTime($inputSeconds) {

        $secondsInAMinute = 60;
        $secondsInAnHour = 60 * $secondsInAMinute;
        $secondsInADay = 24 * $secondsInAnHour;

        // extract days
        $days = floor($inputSeconds / $secondsInADay);

        // extract hours
        $hourSeconds = $inputSeconds % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);

        // extract minutes
        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);

        // extract the remaining seconds
        $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        $seconds = ceil($remainingSeconds);

        // return the final array
        $obj = array(
            'd' => (int) $days,
            'h' => (int) $hours,
            'm' => (int) $minutes,
            's' => (int) $seconds,
        );
        return $obj;
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
            if ($imgpath[sizeof($imgpath) - 1] == " ")
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
        $sSearch = $this->ci->input->post('sSearch');
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
                if ($custom_val['content'] == 'get_deliveriescount/$1') {
                    $custom_val['content'] = $this->get_TotalShipement($replace_string);
                } else if ($custom_val['content'] == 'counter/$1') {
                    $custom_val['content'] = $this->counter($replace_string);
                } else if ($custom_val['content'] == 'get_lat/$1') {
                    $custom_val['content'] = $this->get_lat($replace_string);
                } else if ($custom_val['content'] == 'get_lat/$1') {
                    $custom_val['content'] = $this->get_lat($replace_string);
                } else if ($custom_val['content'] == 'getRec_time/$1') {
                    $custom_val['content'] = $this->getRec_time($replace_string);
                } else if ($custom_val['content'] == 'getPayrollButton/$1') {
                    $custom_val['content'] = $this->getPayrollButton($replace_string);
                } else if ($custom_val['content'] == 'getFormatValue/$1') {
                    $custom_val['content'] = $this->getFormatValue($replace_string);
                } else if ($custom_val['content'] == 'getMasterDeviceInfo/$1') {
                    $custom_val['content'] = $this->getMasterDeviceInfo($replace_string);
                } else if ($custom_val['content'] == 'getSlaveDeviceInfo/$1') {
                    $custom_val['content'] = $this->getSlaveDeviceInfo($replace_string);
                } else if ($custom_val['content'] == 'getButton/$1') {
                    $custom_val['content'] = $this->getButton($replace_string);
                } else if ($custom_val['content'] == 'getCompanyName/$1') {
                    $custom_val['content'] = $this->getCompanyName($replace_string);
                } else if ($custom_val['content'] == 'getvehicleType/$1') {
                    $custom_val['content'] = $this->getvehicleType($replace_string);
                } else if ($custom_val['content'] == 'getplateNumber/$1') {
                    $custom_val['content'] = $this->getplateNumber($replace_string);
                } else if ($custom_val['content'] == 'getDispatcher/$1') {
                    $custom_val['content'] = $this->getDispatcher($replace_string);
                } else if ($custom_val['content'] == 'getCustomerDetails/$1') {
                    $custom_val['content'] = $this->getCustomerDetails($replace_string);
                } else if ($custom_val['content'] == 'getDriverName/$1') {
                    $custom_val['content'] = $this->getDriverName($replace_string);
                } else {

                    $custom_val['content'] = str_ireplace('$' . ($key + 1), $replace_string, $custom_val['content']);
                }
//          echo $custom_val['content'];
//          exit();
//           if(strpos($custom_val['content'],'<img')!== FALSE){
//        $xpath = new DOMXPath(@DOMDocument::loadHTML($custom_val['content']));
//        $src = $xpath->evaluate("string(//img/@src)");
//        $imgpath = explode('/', $src);
//        print_r($custom_val['content']);
//        exit();
//        if($imgpath[sizeof($imgpath)-1] =='')
//            $content = '<img src="http://opaicosollinux.cloudapp.net/OPA/admin/img/user.jpg" width="50px" height="50px">';
////        else
////        $content = '<img src="http://opaicosollinux.cloudapp.net/OPA/admin/img/user.jpg" width="50px" height="50px">';
//        }
            }
        }

        return $custom_val['content'];
    }

    public function counter($id) {
        return $this->counter++;
    }

    public function get_lat($id) {
        $cursor = $this->ci->mongo_db->where(array('user' => (int) $id))->find_one('location');
        if ($cursor['location']['latitude'] === 0.0)
            $elapsed = '';
        else {
            if ($cursor['lastTs'] != NULL || $cursor['lastTs'] != '')
                $elapsed = '<br> <b><span style="color:#1ABB9C">' . number_format((time() - $cursor['lastTs']) / 60, 0) . ' mins ago</span></b>';
            else
                $elapsed = '';
        }


        return number_format($cursor['location']['latitude'], 6) . ', ' . number_format($cursor['location']['longitude'], 6) . $elapsed;
    }

    public function getCompanyName($id) {

        $company_id = $this->ci->db->select("company_id")->from('master')->where("mas_id = " . $id . "")->get()->row()->company_id;

        if ($company_id)
            $operators = $this->ci->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($company_id)))->find_one('operators');

        return $operators['operatorName'];
    }

    public function getvehicleType($id) {
        $vehicles = $this->ci->mongo_db->where(array('mas_id' => (int) $id))->find_one('vehicles');

        if (!empty($vehicles))
            $vehicleTypes = $this->ci->mongo_db->where(array('_id' => new MongoDB\BSON\ObjectID($vehicles['type_id'])))->find_one('vehicleTypes');
        else
            return '';

        return $vehicleTypes['type_name'];
    }

    public function getplateNumber($id) {
        $vehicles = $this->ci->mongo_db->where(array('mas_id' => (int) $id))->find_one('vehicles');

        if (empty($vehicles))
            return '';
        else
            return $vehicles['platNo'];
    }

    public function getDispatcher($id) {
        $slave_id = $this->ci->db->select("slave_id")->from('slave')->where("slave_id = " . $id . " and accountType = 2")->get()->row()->slave_id;
        if ($slave_id) {
            $Customer_dispatcher = $this->ci->mongo_db->where(array('customerID' => (int) $slave_id))->find_one('Customer_dispatcher');

            if (empty($Customer_dispatcher))
                return '<a href="' . base_url() . 'index.php?/superadmin/customerDispatch/' . $slave_id . '">0</a>';
            else
                return '<a href="' . base_url() . 'index.php?/superadmin/customerDispatch/' . $slave_id . '">' . count($Customer_dispatcher['Dispatcher']) . '</a>';
        } else
            return '-';
    }

    public function getCustomerDetails($id) {
        $slaveData = $this->ci->db->select("slave_id,first_name,email,phone,accountType")->from('slave')->where("slave_id = " . $id . "")->get()->result();
        if ($slaveData) {
            foreach ($slaveData as $customer) {
                $accountType = ($customer->accountType == 1) ? "Individual" : "Business";
                return '<a style="cursor:pointer" class="customerDetails" name="' . $customer->first_name . '" email="' . $customer->email . '" phone="' . $customer->phone . '" accountType="' . $accountType . '">' . $customer->first_name . '</a>';
            }
        } else
            return '-';
    }

    public function getDriverName($id) {
        $Customer_dispatcher = $this->ci->mongo_db->where(array('_id' => (int) $slave_id))->find_one('Customer_dispatcher');

        return "<a style='cursor: pointer;'  class='getDriverDetails' mas_id=" . $id . ">" . $name . "</a>";
    }

    public function getRec_time($id) {
        $this->ci->load->library('mongo_db');
        $cursor = $this->ci->mongo_db->get_one('booking_route', array('bid' => (int) $id));
        if (!empty($cursor['receiveDt']) && isset($cursor['receiveDt']))
            return date('M d Y h:i A', strtotime($cursor['receiveDt']));
        else
            return;
    }

    public function get_TotalShipement($id) {

        $this->ci->load->library('mongo_db');
        $cursor = $this->ci->mongo_db->get_one('ShipmentDetails', array('order_id' => (int) $id));

        return $cursor['Totalcount'];
    }

    public function getFormatValue($id) {

        return number_format($id, 2);
    }

    public function getMasterDeviceInfo($id) {
        return '';
//          $cursor =  $this->ci->db->select("us.device,us.push_token,m.last_active_dt,(case us.type when 2 then 'android_new.png' when 1 then 'apple_new.png'  END) as deviceType")->from('user_sessions us,master m')->where('us.oid = "'.$id.'"  and us.user_type = 1 and m.mas_id = oid order by us.sid DESC limit 1')->get()->result();
//          if(!empty($cursor))
//          {
//            foreach ($cursor as $row)
//                return '<img src="' . base_url() . '../../admin/assets/'.$row->deviceType.'" width="30px" height="30px" class="imageborder deviceInfo" deviceID="'.$row->device.'" push_token="'.$row->push_token.'" last_active_dt="'.$row->last_active_dt.'" data-toggle="tooltip" title="Device Info" onerror="this.src=\'' . base_url() . '../../pics/user.jpg\'">';
//          }
//          else
//                   return '<img src="' . base_url() . '../../pics/user.jpg" width="30px" height="30px" class="imageborder"  onerror="this.src=\'' . base_url() . '../../pics/user.jpg\'">';
//          
    }

    public function getSlaveDeviceInfo($id) {
        $cursor = $this->ci->db->select("us.device,us.push_token,s.last_active_dt,(case us.type when 2 then 'android_new.png' when 1 then 'apple_new.png'  END) as deviceType")->from('user_sessions us,slave s')->where('us.oid = "' . $id . '"  and us.user_type = 1 and s.slave_id = oid order by us.sid DESC limit 1')->get()->result();
        if (!empty($cursor)) {
            foreach ($cursor as $row)
                return '<img src="' . base_url() . '../../admin/assets/' . $row->deviceType . '" width="30px" height="30px" class="imageborder deviceInfo" deviceID="' . $row->device . '" push_token="' . $row->push_token . '" last_active_dt="' . $row->last_active_dt . '" data-toggle="tooltip" title="Device Info" onerror="this.src=\'' . base_url() . '../../pics/user.jpg\'">';
        } else
            return '<img src="' . base_url() . '../../pics/user.jpg" width="30px" height="30px" class="imageborder"  onerror="this.src=\'' . base_url() . '../../pics/user.jpg\'">';
//          
    }

    public function getPayrollButton($id) {
//         echo $id;
        $cursor = $this->ci->db->select('m.mas_id,(select sum(mas_earning) FROM appointment WHERE  mas_id  = ' . $id . '  AND  STATUS = 9 and payment_type = 1) as cardEarned,(select sum(app_commission) FROM appointment WHERE  mas_id  = ' . $id . '  AND  STATUS = 9 and payment_type = 2) as app_commission,(SELECT SUM(pay_amount) FROM payroll WHERE mas_id  = ' . $id . ' ) as collectedAmount')->from('master m')->where('m.mas_id = ', $id)->get()->result();
        $cardEarning = 0;
        $app_commission = 0;
        $collectedAmount = 0;
        $due = 0;
        foreach ($cursor as $row) {

            if ($row->cardEarned != '' || $row->cardEarned != NULL)
                $cardEarning = $row->cardEarned;
            if ($row->app_commission != '' || $row->app_commission != NULL)
                $app_commission = $row->app_commission;
            if ($row->collectedAmount != '' || $row->collectedAmount != NULL)
                $collectedAmount = $row->collectedAmount;

            $due = (floatval($cardEarning) - floatval($app_commission) - floatval($collectedAmount));

            if ($due >= 0)
                return '<a href="' . base_url("index.php?/superadmin/DriverDetails/" . $id . "") . '"><button class="btn btn-default" style="min-width: 83px !important;">DETAILS</button></a><a href="' . base_url("index.php?/superadmin/Driver_pay/" . $id . "") . '" style="margin-left:1%;"><button class="btn btn-success " style="min-width: 83px !important;background-color: cadetblue;border-color: cadetblue;">PAY</button>';
            else
                return '<a href="' . base_url("index.php?/superadmin/DriverDetails/" . $id . "") . '"><button class="btn btn-default" style="min-width: 83px !important;">DETAILS</button></a><a href="' . base_url("index.php?/superadmin/Driver_collect/" . $id . "") . '" style="margin-left:1%;"><button class="btn btn-warning" style="min-width: 83px !important;background-color: rgb(129, 130, 181);border-color: rgb(129, 130, 181);">COLLECT</button>';
        }
    }

    public function get_log($id) {
        $this->ci->load->library('mongo_db');
        $cursor = $this->ci->mongo_db->get_one('location', array('user' => (int) $id));
        return $cursor['location']['longitude'];
    }

    public function getButton($id) {
        $Status = $this->ci->db->select('Status')->from('city_available')->where('City_Id = ', $id)->get()->row()->Status;

        if ($Status == 1)
            return '<button type="button" data-toggle="tooltip" title="Edit City" onclick="loadExistingZones()" class="btn-success editCity" style="height: 26px;" data-id="' . $id . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button class="btn-danger data-toggle="tooltip" style="height: 26px;" title="Delete City" deleteCity" style="" data-id="' . $id . '"><i class="fa fa-trash-o" aria-hidden="true"></i></button><button class="btn btn-success Activate" style="" data-id="' . $id . '">Activate</button>';
        else
            return '<button type="button" style="height: 26px;" data-toggle="tooltip" title="Edit City" class="btn-success editCity" data-id="' . $id . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button class="btn-danger deleteCity" data-toggle="tooltip" style="height: 26px;" title="Delete City" style="" data-id="' . $id . '"><i class="fa fa-trash-o" aria-hidden="true"></i></button><button class="btn btn-warning dectivate" style="" data-id="' . $id . '">Deactivate</button>';
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