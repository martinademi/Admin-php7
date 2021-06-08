<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class ProductCategory extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');  
        $this->Logoutmodal->logout();         
        $this->load->model("StoreLevelCategorymodal");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        $this->lang->load('category_lang',$language);
//        $this->load->model("Superadminmodal");

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index() {
        
            $data['business'] = $this->StoreLevelCategorymodal->CategoryData();

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

          
         
          $checkbox=' <input type="checkbox" id="select_all" />';
          $this->table->set_heading($this->lang->line('SL_NO'),$this->lang->line('IMAGE'),$this->lang->line('CATEGORY_NAME'),$this->lang->line('STATUS'),$this->lang->line('DESCRIPTION'),$this->lang->line('SUBCATEGORY_COUNT'),
            // $this->lang->line('META_TAGS'),
            $this->lang->line('STORE_NAME'),$this->lang->line('ACTIONS'), $checkbox);

            $data['language'] = $this->StoreLevelCategorymodal->get_lan_hlpText();
            $data['pagename'] = 'storeProductCategory/Category/category';
            $this->load->view("company", $data);
        
    }

    public function operationCategory($param = '', $status = '') {


        switch ($param) {
            case 'insert':$this->StoreLevelCategorymodal->insertCategory();
                break;

            case 'edit': $this->StoreLevelCategorymodal->editCategory();
                break;

            case 'delete':$this->StoreLevelCategorymodal->deleteCategory();
                break;

            case 'get': $this->StoreLevelCategorymodal->getCategoryData();
                break;

            case 'table': $this->StoreLevelCategorymodal->datatable_category($status);
                break;

            case 'unhide': $this->StoreLevelCategorymodal->unhideCategory($status);
                break;

            case 'hide': $this->StoreLevelCategorymodal->hideCategory($status);
                break;

            case 'order': $this->StoreLevelCategorymodal->changeCatOrder($status);
                break;
			case 'approve': $this->StoreLevelCategorymodal->approveCategory();
                break;
				
				case 'ban': $this->StoreLevelCategorymodal->banCategory();
                break;
				case 'reject': $this->StoreLevelCategorymodal->rejectCategory();
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
