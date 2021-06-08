<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Metatags extends CI_Controller {

	
     public function __construct() {
           
          parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model("Metatagmodal");
        $this->load->model("Categorymodal");
        $this->load->model("SubCategorymodal");
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);
        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
	  public function datatable_Metatags($status = '') {
        $this->Metatagmodal->datatable_Metatags($status);
    }
      public function deletemetadata() {
        $data = $this->Metatagmodal->deletemetadata();
    }
    
     public function insert_metadata() {
       $this->Metatagmodal->insert_metadata();
        echo json_encode(array("msg" => '1'));
    }
    
      public function editmetadata() {
         $this->Metatagmodal->editmetadata();
         echo json_encode(array("msg" => '1'));
    }
    public function meta_tags($id = '', $bid = '') {
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->helper('cookie');
       
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

      //  $this->table->set_heading('SLNO', 'NAME', 'VALUE','ACTION', 'SELECT');
      $checkbox=' <input type="checkbox" id="select_all" />';
      $this->table->set_heading('SLNO', 'NAME', 'VALUE','ACTION', $checkbox );
        $data['business'] = $this->Categorymodal->CategoryData();
       
        $data['businessTwo'] = $this->SubCategorymodal->SubCategoryData();
        $data['metatags'] = $this->Metatagmodal->metatags();
        if($id)
          $data['mid'] = $id;   
        
        if($bid)
            $data['bid'] = $bid;

        $data['pagename'] = 'MetaTags/meta_tags';    
        $this->load->view("company", $data);
    }
      public function getmetadata() {

        $data[] = $this->Metatagmodal->getmetadata();

        echo json_encode($data);
    }


}
