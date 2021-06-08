<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Datatable_Model extends CI_Model {

		var $table = NULL;
	    var $column_order = NULL;
	    var $column_search = NULL;
	    var $order = array('id' => 'asc'); // default order 
		public function initialize($tbl) {
		    $this->table = $tbl;
		    $all_coloumns = $this->db->list_fields($this->table);
		    $all_coloumns[0] = NULL;
		    $this->column_order = $all_coloumns; //set column field database for datatable orderable
		    unset($all_coloumns[0]);
		    $this->column_search = $all_coloumns; //set column field database for datatable orderable
		}

	    function __construct() {
	        
	    }

	    public function _get_datatables_query() {
	    	if (!empty($this->input->post())) {
	    		$post_data = $this->db->list_fields($this->table);
	    		for ($i=1; $i < count($post_data); $i++) { 
	    			if ($this->input->post($post_data[$i]) != '') {
	    				$this->db->like($post_data[$i], $this->input->post($post_data[$i]));
	    			}
	    		}
	    	}

	       
	        $this->db->from($this->table);
        	$i = 0;
        	foreach ($this->column_search as $item) {
	            if($_POST['search']['value']) {
	                 
	                if($i===0) {
	                    $this->db->group_start(); 
	                    $this->db->like($item, $_POST['search']['value']);
	                } else {
	                    $this->db->or_like($item, $_POST['search']['value']);
	                }
	 
	                if(count($this->column_search) - 1 == $i) {	
	                    $this->db->group_end(); 
	                }
	            }
	            $i++;
	        }

	        if(isset($_POST['order'])) {
	            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        } else if(isset($this->order)) {
	            $order = $this->order;
	            $this->db->order_by(key($order), $order[key($order)]);
	        }
		}

		public function get_datatables()
	    {
	        $this->_get_datatables_query();
	        if($_POST['length'] != -1)
	        $this->db->limit($_POST['length'], $_POST['start']);
	        $query = $this->db->get();
	        return $query->result();
	    }
	 
	    public function count_filtered()
	    {
	        $this->_get_datatables_query();
	        $query = $this->db->get();
	        return $query->num_rows();
	    }
	 
	    public function count_all()
	    {
	        $this->db->from($this->table);
	        return $this->db->count_all_results();
	    }
	}