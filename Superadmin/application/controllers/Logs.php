<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logs extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
$this->Logoutmodal->logout();
        $this->load->model("Logsmodel");
        $this->load->model('promoCodeModel');
        $language = ($this->session->userdata('lang'))?($this->session->userdata('lang')):'english';
        $this->lang->load('header_lang',$language);

       

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function messages() {
       
        
        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127PX;">',
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
        $this->table->set_heading('SL NO.', 'TO', 'MESSAGE', 'TRIGGER', 'STATUS','SEND DATE');
//
        $data['pagename'] = "camp/logs/message";
        $this->load->view("company", $data);
    }
    public function stripe() {
       
        
        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127PX;">',
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
        $this->table->set_heading('SL NO.', 'TO', 'SUBJECT', 'TRIGGER', 'STATUS','SEND DATE');
//
        $data['pagename'] = "camp/logs/email";
        $this->load->view("company", $data);
    }
    public function email() {
       
        
        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127PX;">',
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
        $this->table->set_heading('SL NO.', 'TO', 'SUBJECT', 'TRIGGER', 'STATUS','SEND DATE');
//
        $data['pagename'] = "camp/logs/email";
        $this->load->view("company", $data);
    }
    public function dataTable($status) {
        switch ($status)
        {
        case 'sms':
            $this->Logsmodel->smsLog();
            break;
        case 'email':
            $this->Logsmodel->emailLog();
            break;
        case 'stripe':
            $this->Logsmodel->stripeLog();
            break;
        }
         
    }

    public function inputTripLogs(){
        
         $this->load->library('Datatables');
         $this->load->library('table');
        
          $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 0px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;">',
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
        $this->table->set_heading('SL NO', "BOOKING ID", "CUSTOMER NAME",  "PAYMENT METHOD", "BOOKING TIME", "BILLING AMOUNT", "CURRENCY");
        // Load the page
        $data['pagename'] = "camp/logs/inputTripLogs";
        $this->load->view("company", $data);
      
    }

    public function getInputTripLogs(){

        
        $logsData = $this->Logsmodel->inputTripLogs();
        
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $slNo = 1;
        // echo '<pre>';
        // print_r($offersData);
        $data = array();
       foreach ($logsData as $logData) {
          // var_dump($logData);
        $userdetails=$this->promoCodeModel->getUserDetails( $logData['userId']);
           if (!empty($userdetails)) {
                $customerName = $userdetails[0]['firstName'];
            } else {
                $customerName = '';
            }

        // echo '<pre>';
        // var_dump($userdetails);
        // exit;
            $bookingTime = date( "j-M-Y g:i A",$logData['bookingTime']);
               $data[] = [
                 $slNo,
                 $logData['bookingId'],
                 //$logData['userId'],
                 //$logData['customerFirstName'], 
                 $customerName,
                 $logData['paymentMethodString'],
                 $bookingTime, 
                 $logData['currencySymbol'].' '.$logData['cartValue'],
                 $logData['currency']
            ];
          
           $slNo++;
       }
        $output = array(
        "draw" => $draw,
        "recordsTotal" => count($logsData),
        "recordsFiltered" => count($logsData),
        "data" => $data
        );
        echo json_encode($output);
    }




    public function campaignQualifiedTripLogs(){
       
        $this->load->library('table');
        
          $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 0px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;">',
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
        $this->table->set_heading('SL NO', "BOOKING ID", "CUSTOMER NAME", "CITY", "PAYMENT METHOD", "CART VALUE", "CURRENCY");
        // Load the page
        $data['pagename'] = "camp/logs/campaignQualifiedTripLogs";
        $this->load->view("company", $data);
    }

    public function getAllQualifiedTripLogs(){
        
        $logsData = $this->Logsmodel->inputTripLogs();
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $slNo = 1;
        // echo '<pre>';
        // print_r($offersData);
        $data = array();
       foreach ($logsData as $logData) {
            $bookingTime = "09-02-2018 05:59:00";
               $data[] = [
                 $slNo,
                 $logData['bookingId'],
                 $logData['customerName'],
                 //$logData['customerFirstName'], 
                 $logData['cityName'], 
                 $logData['paymentMethodString'], 
                 $logData['currencySymbol'].' '.$logData['cartValue'],
                 $logData['currency']
            ];
          
           $slNo++;
       }
        $output = array(
        "draw" => $draw,
        "recordsTotal" => count($logsData),
        "recordsFiltered" => count($logsData),
        "data" => $data
        );
        echo json_encode($output);
    }




    public function promoLogs(){
        $this->load->library('table');
        
          $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class=" table table-striped table-bordered dataTable no-footer table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 0px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;">',
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
         $this->table->set_heading('SL NO', 'COUPON CODE', 'BOOKING ID', 'CLAIM STATUS','CUSTOMER NAME' ,'BILLED AMOUNT' ,'DISCOUNT TYPE', 'DISCOUNT VALUE', 'LOCKED TIME', 'UNLOCKED TIME','CLAIM TIME');
        // Load the page
        $data['pagename'] = "camp/logs/promoCodeLogs";
        $this->load->view("company", $data);
    }

    public function getAllPromoLogs(){
     
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $logsData = $this->logsmodel->claimsLog();
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $slNo = 1;
       foreach ($logsData as $logData) {

           if ( !$logData['couponCode']) {
               $couponCode = "N/A";
           }else{
                $couponCode = $logData['couponCode'];
           }
           /*
           Locked timestamp
            */
           
           if ($logData['lockedTimeStamp'] == "N/A") {
              $lockedTimeStamp = "N/A"; 
           }else{
            $lockedTimeStamp = date( "j-M-Y g:i A", strtotime($logData['lockedTimeStamp']));
           }
           
           /*
           Unlocked timestamp
            */
            if ($logData['unlockedTimeStamp'] == "N/A") {
              $unlockedTimeStamp = "N/A"; 
           }else{
            $unlockedTimeStamp = date( "j-M-Y g:i A", strtotime($logData['unlockedTimeStamp']));
           }
           /*
           Claimed timestamp
            */
              if ($logData['claimTimeStamp'] == "N/A") {
                $claimTimeStamp = "N/A"; 
              }else{
                $claimTimeStamp = date( "j-M-Y g:i A", strtotime($logData['claimTimeStamp']));
               }


               $data[] = [
                $slNo,
                $couponCode,
                $logData['cartId'],
                $logData['claimStatus'], 
                $logData['cartValue'], 
                $logData['deliveryFee'], 
                $logData['discountType'], 
                $logData['discountValue'],
                $logData['finalValue'],
                $lockedTimeStamp,
                $unlockedTimeStamp,
                $claimTimeStamp

                
            ];
          
           $slNo++;
       }
        $output = array(
        "draw" => $draw,
        "recordsTotal" => count($logsData),
        "recordsFiltered" => count($logsData),
        "data" => $data
        );
        echo json_encode($output);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */