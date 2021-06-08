<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class FranchiseCategory extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model("FranchiseLevelCategorymodal");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
//        $this->load->model("Superadminmodal");

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index() {
        
            $data['business'] = $this->FranchiseLevelCategorymodal->CategoryData();

            $this->load->library('Datatables');
            $this->load->library('table');

            $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
                'heading_row_start' => '<tr style= "font-size:12px"role="row">',
                'heading_row_end' => '</tr>',
                'heading_cell_start' => ' <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:12px;">',
                'heading_cell_end' => '</th>',
                'row_start' => '<tr>',
                'row_end' => '</tr>',
                'cell_start' => '<td>',
                'cell_end' => '</td>',
                'row_alt_start' => '<tr>',
                'row_alt_end' => '</tr>',
                'cell_alt_start' => '<td>',
                'cell_alt_end' => '</td>',
                'table_close' => '</table>'
            );
            $this->table->set_template($tmpl);

          
          // changes $this->table->set_heading('SL NO', 'IMAGE', 'CATEGORY NAME', 'STATUS', 'DESCRIPTION', 'SUBCATEGORY COUNT', 'META TAGS', 'STORE NAME','ACTION', 'SELECT');
          $checkbox=' <input type="checkbox" id="select_all" />';
          $this->table->set_heading('SL NO', 'IMAGE', 'CATEGORY NAME', 'STATUS', 'DESCRIPTION', 'SUBCATEGORY COUNT',
           // 'META TAGS', 
           'FRANCHISE NAME','ACTION', $checkbox);
            $data['language'] = $this->FranchiseLevelCategorymodal->get_lan_hlpText();
            $data['pagename'] = 'franchiseProductCategory/Category/category';
            $this->load->view("company", $data);
        
    }

    public function operationCategory($param = '', $status = '') {


        switch ($param) {
            case 'insert':$this->FranchiseLevelCategorymodal->insertCategory();
                break;

            case 'edit': $this->FranchiseLevelCategorymodal->editCategory();
                break;

            case 'delete':$this->FranchiseLevelCategorymodal->deleteCategory();
                break;

            case 'get': $this->FranchiseLevelCategorymodal->getCategoryData();
                break;

            case 'table': $this->FranchiseLevelCategorymodal->datatable_category($status);
                break;

            case 'unhide': $this->FranchiseLevelCategorymodal->unhideCategory($status);
                break;

            case 'hide': $this->FranchiseLevelCategorymodal->hideCategory($status);
                break;

            case 'order': $this->FranchiseLevelCategorymodal->changeCatOrder($status);
                break;
			case 'approve': $this->FranchiseLevelCategorymodal->approveCategory();
                break;
				
				case 'ban': $this->FranchiseLevelCategorymodal->banCategory();
                break;
				case 'reject': $this->FranchiseLevelCategorymodal->rejectCategory();
                break;
        }
    }

    function issessionset() {
        if ($this->session->userdata('badmin')['BizId']) {
            return true;
        }
        return false;
    }

}
