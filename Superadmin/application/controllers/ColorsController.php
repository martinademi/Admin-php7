<?php


// testing
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class colorsController extends CI_Controller {
  
    public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model('Colorsmodal');
        
         $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
         $this->lang->load('header_lang',$language); 
         $this->lang->load('colors_lang', $language);

        

        
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    
       public function index($status = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        
        $data['language'] = $this->Colorsmodal->getlanguageText();
        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:12px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:12px;">',
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
      //  $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_Name'),$this->lang->line('col_actions'),$this->lang->line('col_select'));
      $checkbox=' <input type="checkbox" id="select_all" />';
      $this->table->set_heading($this->lang->line('col_sino'),$this->lang->line('col_Name'),$this->lang->line('col_actions'),$checkbox);
    
        $data['pagename'] = "Colors/colors";
        $this->load->view("company", $data);
    }
    
     public function colors_details($status = '') {
        $this->Colorsmodal->colors_details($status);
    }
    
     public function addColors() {
        $this->Colorsmodal->addColors();
    }
     public function getColor($id = '') {
        $data1 = $this->Colorsmodal->getColor($id);
        echo json_encode(array('data' => $data1));
    }
     public function editColor() {
        $this->Colorsmodal->editColor();
    }
     public function activateColor() {
        $this->Colorsmodal->activateColor();
    }
     public function deactivateColor() {
        $this->Colorsmodal->deactivateColor();
    }
   
    
}
