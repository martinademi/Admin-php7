<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class StoreCategoryController extends CI_Controller {

  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model("StoreCategoryModel");
        error_reporting(0);
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        $this->lang->load('storeCategory_lang', $language);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
 

    public function index() {

        $data['storeCategory'] = $this->StoreCategoryModel->CategoryData();

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
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_Name'),$this->lang->line('col_image'),$this->lang->line('col_desc'),$this->lang->line('col_sort'),$this->lang->line('col_type'),$this->lang->line('col_subCategoryCount'),$this->lang->line('col_attributes'),$this->lang->line('col_actions'),$checkbox);
        $data['language'] = $this->StoreCategoryModel->get_lan_hlpText();
        $data['pagename'] = 'StoreCategories/Category';
        $this->load->view("company", $data);
    }
    public function editAttributes($id='',$name='',$catid='') {
        $data['id'] = $catid;
        $data['name'] = $name;
        $data['language'] = $this->StoreCategoryModel->get_lan_hlpText();
        $data['dataId'] = $id;
        $data['addOnData'] = $this->StoreCategoryModel->getAtrributesData($id);
        $data['pagename'] = "StoreCategories/editAttributes";
        $this->load->view("company", $data);
    }

    public function addAttributes($name='',$params = ''){
        $data['id'] = $params; 
        $data['name'] = $name;  
        $data['language'] = $this->StoreCategoryModel->get_lan_hlpText();
        $data['pagename'] = 'StoreCategories/addAttributes';
        $this->load->view("company", $data);
    }   

    public function attributes($name='',$params = '') {
        $data['id'] = $params;
        $data['name'] = $name;  
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

        //$this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_Name'),$this->lang->line('col_image'),$this->lang->line('col_desc'),$this->lang->line('col_sort'),$this->lang->line('col_type'),$this->lang->line('col_subCategoryCount'),$this->lang->line('col_actions'),$this->lang->line('col_select'));
        $checkbox=' <input type="checkbox" id="select_all" />';
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_GroupName'),$this->lang->line('col_No_OF_ATTRIBUTES'),$this->lang->line('col_actions'),$checkbox);
        $data['language'] = $this->StoreCategoryModel->get_lan_hlpText();
        $data['pagename'] = 'StoreCategories/attributes';
        $this->load->view("company", $data);   
    }

    public function attributeList($params = '', $status1='', $status2 = '',$status3='') {
        $data['name'] = $status1;
        $data['catid'] = $status2;
        $data['gName'] = $status3;  
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
        //$checkbox=' <input type="checkbox" id="select_all" />';
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_AttributeName'));
        $data['id'] = $params;
        $data['pagename'] = 'StoreCategories/attributesList';
        $this->load->view("company", $data);   
    }


    public function SubCategory($params = '') {

        $data['business'] = $this->StoreCategoryModel->CategoryData();
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
        $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_Name'),$this->lang->line('col_image'),$this->lang->line('col_desc'),$this->lang->line('col_sort'),$this->lang->line('col_actions'),$checkbox);

        $data['language'] = $this->StoreCategoryModel->get_lan_hlpText();
        $data['bid1'] = $params;
        $data['pagename'] = 'StoreCategories/subCategory';
        $this->load->view("company", $data);       
    }
    
   
            
     public function operationCategory($param = '',$status1 = '',$status2 = '',$status3=''){
       
        
        switch ($param) {
            case 'insert':$this->StoreCategoryModel->insertCategory();
                break;

            case 'edit': $this->StoreCategoryModel->editCategory();
                break; 
              
            case 'getAtrributesData': 
            $sat = 1;
            $this->StoreCategoryModel->getAtrributesData($status1,$sat); 
            break;

            case 'editAttributeData': $this->StoreCategoryModel->editAttributeData($status1);
                break;

            case 'delete':$this->StoreCategoryModel->deleteCategory();
                break;

            case 'activateAttribute':$this->StoreCategoryModel->activateAttribute();
                break; 
            
            case 'deleteAttribute':$this->StoreCategoryModel->deleteAttribute();
                break;    
                
            case 'deactivateAttribute':$this->StoreCategoryModel->deactivateAttribute();
                break;     

            case 'get': $this->StoreCategoryModel->getCategoryData();
                break;
            
            case 'table': $this->StoreCategoryModel->datatable_category($status1);
                break;
           
            case 'tableAttributes': $this->StoreCategoryModel->datatable_attributes($status1,$status2,$status3);
                break;

            case 'tableAttributesList': 
            $this->StoreCategoryModel->datatable_attributesList($status1,$status2);
                break;    
            
            case 'unhide': $this->StoreCategoryModel->unhideCategory($status1);
                break; 
            
            case 'hide': $this->StoreCategoryModel->hideCategory($status1);
                break;
            
            case 'order': $this->StoreCategoryModel->changeCatOrder($status1);
                break;

            case 'AddNewAttributes':
                                   $data = $this->StoreCategoryModel->AddNewAttributes($status1,$status2);
                                    if ($data) {
                                        echo json_encode(array('status' => true, 'message' => 'Central addons added successfully'));
                                        redirect(base_url()."index.php?/StoreCategoryController/attributes/".$status1."/".$status2); 
                                    }
                break;
        }
    }
    
     public function operationSubCategory($param = '',$status1 = '',$status2 = ''){
       
        
        switch ($param) {
            case 'insert':$this->StoreCategoryModel->insertSubCategory();
                break;

            case 'edit': $this->StoreCategoryModel->editSubCategory();
                break;

            case 'delete':$this->StoreCategoryModel->deleteSubCategory();
                break;

            case 'get': $this->StoreCategoryModel->getSubCategoryData();
                break;
            
            case 'table': $this->StoreCategoryModel->datatable_Subcategory($status1,$status2);
                break;
            
            case 'unhide': $this->StoreCategoryModel->unhideSubCategory($status1);
                break;
            
            case 'hide': $this->StoreCategoryModel->hideSubCategory($status1);
                break;
            
            case 'order': $this->StoreCategoryModel->changeSubCatOrder($status1);
                break;
        }
    }
}