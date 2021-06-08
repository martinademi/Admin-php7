<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vehicle extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Logoutmodal');
        $this->Logoutmodal->logout();
        $this->load->model("Vehiclemodal");
        $language = $this->session->userdata('lang');
        $this->lang->load('header_lang',$language);
        $this->lang->load('vehicleSetting_lang', $language);

        
        $this->lang->load('topnav_lang', $language);

        // Load form helper library
        $this->load->helper('form');

        // Load form validation library
        $this->load->library('form_validation');

        error_reporting(0);
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }
    function Logout() {

        $this->session->sess_destroy();
        redirect(base_url() . "index.php?/superadmin");
    }

    public function vehicle_type() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['cities'] = $this->Vehiclemodal->getCities();
        

        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1"  class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:12px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" aria-label="Browser: activate to sort column ascending" style="width: 127px;thtext-align:left">',
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
//        $this->table->set_heading($this->lang->line('col_type_id'), $this->lang->line('col_vehicle_type_name'),$this->lang->line('col_description'), $this->lang->line('col_order'),$this->lang->line('col_action'),$this->lang->line('col_select'));
        $this->table->set_heading($this->lang->line('col_type_id'), $this->lang->line('col_vehicle_type_name'),$this->lang->line('col_description'), $this->lang->line('col_order'),$this->lang->line('col_action'));

        $data['pagename'] = "vehicleSettings/vehicleTypes/index";
        $this->load->view("company", $data);
    }
    public function vehicleOrdering() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['cities'] = $this->Vehiclemodal->getCities();
        

        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1"  class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:12px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" aria-label="Browser: activate to sort column ascending" style="width: 127px;thtext-align:left">',
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
        $this->table->set_heading($this->lang->line('col_type_id'), $this->lang->line('col_vehicle_type_name'),$this->lang->line('col_description'), $this->lang->line('col_order'));

        $data['pagename'] = "vehicleSettings/vehicleTypes/vehicleOrdering";
        $this->load->view("company", $data);
    }
   

    public function cityVehicleOrdering() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->cityVehicleOrdering();
    }
    public function getPreferences() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->getPreferences();
    }
    public function getRentalPackages() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->getRentalPackages();
    }
    public function getPreferenceSelected() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->getPreferenceSelected();
    }
    public function updatePreferences() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->updatePreferences();
    }
    public function updateRentalPackages() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->updateRentalPackages();
    }
    public function datatable_vehicletype() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->datatable_vehicletype();
    }
    public function datatable_vehicleOrdering() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->datatable_vehicleOrdering();
    }
  

    public function vehicletype_reordering() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->vehicletype_reordering();
    }
    public function getVehicleTypeLanguageDate() {


        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->getVehicleTypeLanguageDate();
    }

    public function vehicletype_addedit($status = '', $param = '') {

        $data['param'] = "";
        $data['operation'] = $status;
        $data['speciality_data'] = $this->Vehiclemodal->getSpecialityData();
        $data['appConfigData'] = $this->Vehiclemodal->getAppConfigOne();
        $data['languages'] = $this->Vehiclemodal->getLanguages();
        if ($status == 'edit') {
            $data['vehicleTypeData'] = $this->Vehiclemodal->getMongoVehicleType($param);

            $data['status'] = $status;
            $data['param'] = $param;
            $data['pagename'] = "vehicleSettings/vehicleTypes/edit";
        } elseif ($status == 'add') {
          
            $data['status'] = $status;
            $data['param'] = "";
            $data['pagename'] = "vehicleSettings/vehicleTypes/add";
        }
        $this->load->view("company", $data);
    }

    public function delete_vehicletype() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['delete'] = $this->Vehiclemodal->delete_vehicletype();
    }

    public function uploadVehicleTypeImage() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->uploadVehicleTypeImage();
        redirect(base_url() . "index.php?/vehicle/vehicle_type");
    }
    public function test() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->test();
    }

    public function update_vehicletype($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['updatevehicletype'] = $this->Vehiclemodal->update_vehicletype($param);
        redirect(base_url() . "index.php?/vehicle/vehicle_type");
    }

    public function uploadImage() {

      
        $this->Vehiclemodal->uploadImage();
    }
    public function deleteImage() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->deleteImage();
    }

    public function insert_vehicletype() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['pagename'] = "vehicleSettings/vehicleTypes/add";

        $data = $this->Vehiclemodal->insert_vehicletype();

    }

    public function typeCityPrice($typeId) {
       

        $this->load->library('Datatables');
        $this->load->library('table');
        $data['appConfigData'] = $this->Vehiclemodal->getAppConfigOne();
        $data['cities'] = $this->Vehiclemodal->cityForZones();
        $data['typeData'] = $this->Vehiclemodal->getMongoVehicleType($typeId);

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

        
        $this->table->set_heading($this->lang->line('col_sl_no'),$this->lang->line('col_city'),$this->lang->line('col_action'));

        $data['pagename'] = "vehicleSettings/vehicleTypes/typeCityPrice";
        $data['typeId'] = $typeId;

        $this->load->view("company", $data);
    }

    public function datatable_typeCityPrice($typeId) {

       

        $this->Vehiclemodal->datatable_typeCityPrice($typeId);
    }

    public function updateTypeStatus() {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->updateTypeStatus();
    }
    
    

    public function getPriceByType() {
        
        $this->Vehiclemodal->getPriceByType();
    }

    public function updateTypePrice() {
       
        $this->Vehiclemodal->updateTypePrice();
    }

    public function active_deactiveCity($param = '') {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        if ($param == '1')
            $this->Vehiclemodal->dectivateCity();
        else
            $this->Vehiclemodal->activateCity();
    }

    public function Vehicles($status = '') {

        

        $this->load->library('Datatables');
        $this->load->library('table');

        $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
            'heading_row_start' => '<tr style= "font-size:10px"role="row">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;">',
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
        $this->table->set_heading($this->lang->line('vehicle_id'),$this->lang->line('vehicle_type'),$this->lang->line('col_plate_no'),$this->lang->line('col_make'),$this->lang->line('col_model'),$this->lang->line('col_color'),$this->lang->line('col_businessType'),$this->lang->line('col_driver_name'),$this->lang->line('col_phone'),$this->lang->line('col_last_updated_location'),$this->lang->line('col_logged_in_on'), $this->lang->line('col_ownership_type'),'NOTES',$this->lang->line('col_action'),$this->lang->line('col_select'));

        $data['pagename'] = 'vehicleSettings/vehicles/index';
        $data['status'] = $status;
        $this->load->view("company", $data);
    }

    public function datatable_vehicles($status) {
        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->datatable_vehicles($status);
    }

    public function getVehicleCount() {
        $this->Vehiclemodal->getVehicleCount();
    }

    public function addVehicle($driverID = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        $data['Operators'] = $this->Vehiclemodal->getOperators();
        $data['vehicleTypes'] = $this->Vehiclemodal->vehicleTypeData();
        $data['vehiclemake'] = $this->Vehiclemodal->get_vehiclemake();

        //If 1 then adding vehicle for specific driver
        if ($driverID != '') {
            $data['pagename'] = 'addnewvehicleForDriver';
            $data['driverData'] = $this->Vehiclemodal->getDriver($driverID);
        } else
            $data['pagename'] = 'vehicleSettings/vehicles/add';
        $this->load->view("company", $data);
    }
    
    public function ajax_call_to_get_types($param = '') {

       
        //All freelancer drivers
        if ($param == 'vmodel') {
            $this->Vehiclemodal->getVehicleModel();
        } else if ($param == 'vmake') {
            $this->Vehiclemodal->getVehicleMake();
        } else if ($param == 'getGoodTypes') {

            $this->Vehiclemodal->getGoodTypes();
        } else if ($param == 'freelanceDrivers') {
            $this->Vehiclemodal->getfreelanceDrivers();
        } else if ($param == 'getCityVehicleType') {
            $this->Vehiclemodal->getCityVehicleType();
        }
    }
    
    
    public function licenceplaetno() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        return $this->Vehiclemodal->licenceplaetno();
    }

    public function vehicleOperations($operation = '', $id = '') {

        
        switch ($operation) {
            case 'add': $data['Operators'] = $this->Vehiclemodal->getOperators();
                 $data['cities'] = $this->Vehiclemodal->getCities();
                 $data['vehicleTypes'] = $this->Vehiclemodal->vehicleTypeData();
                 $data['vehiclemake'] = $this->Vehiclemodal->get_vehiclemake();
                 $data['vehicleYear'] = $this->Vehiclemodal->getVehicleYear();
                 $data['pagename'] = 'vehicleSettings/vehicles/add';
                 $this->load->view("company", $data);
                 break;
            case 'insert':$result = $this->Vehiclemodal->AddNewVehicleData();
                if ($result)
                    echo json_encode(array('errorCode' => 0, 'msg' => 'success'));
                else
                    echo json_encode(array('errorCode' => 1, 'msg' => 'Error'));
                break;
            case 'edit': $data['speciality_data'] = $this->Vehiclemodal->getSpecialityData();
                $data['Operators'] = $this->Vehiclemodal->getOperators();
                $data['vehicleData'] = $this->Vehiclemodal->editvehicle($id);
                $data['vehicleYear'] = $this->Vehiclemodal->getVehicleYear();
                $data['vehiclePreference'] = $this->Vehiclemodal->getVehiclePreferences($data['vehicleData']['cityId']['$oid']);
                $data['vehicleTypes'] = $this->Vehiclemodal->getCityVehicleTypeData($data['vehicleData']['cityId']['$oid']);
                $data['getSpecificVehicleType'] = $this->Vehiclemodal->getSpecificVehicleType($data['vehicleData']['typeId']['$oid']);
                
                $data['cities'] = $this->Vehiclemodal->getCities();

                if ($data['vehicleData']['masterId'] != '' && $data['vehicleData']['masterId'] != '0')
                    $data['driversList'] = $this->Vehiclemodal->getDriverList($data['vehicleData']['cityId']['$oid']);
                $data['goodTypes'] = $this->Vehiclemodal->getAllGoodTypes();
                $data['vehId'] = $id;
                $data['pagename'] = "vehicleSettings/vehicles/edit";
                $this->load->view("company", $data);
                break;
//            case 'getPromotedVehicleTypes':$this->Vehiclemodal->getPromotedVehicleTypes();
//                break;
            case 'update':$this->Vehiclemodal->editNewVehicleData($id);
                redirect(base_url() . "index.php?/vehicle/Vehicles/1");
                break;
            case 'activate': $this->Vehiclemodal->activate_vehicle();
                break;
            case 'deactivate': $this->Vehiclemodal->reject_vehicle();
                break;
            case 'documents': $this->Vehiclemodal->getVehicleDocuments();
                break;
            case 'delete': $this->Vehiclemodal->deleteVehicles();
                break;
            case 'getCityDrivers': $this->Vehiclemodal->getCityDrivers();
                break;
            case 'validatePlateNumber': $this->Vehiclemodal->validatePlateNumber();
                break;
             case "updateNote": $response = $this->Vehiclemodal->updateNote();
                if ($response)
                    echo json_encode(array('errorCode' => 0));
                else
                    echo json_encode(array('errorCode' => 1));
                break;
            case "getNote": $response = $this->Vehiclemodal->getNote($id);
                break;
        }
    }

    Public function checkDriverIsOnTrip() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->checkDriverIsOnTrip();
    }

    
//Vehicle Models
    public function vehicle_models($status = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data['status'] = $status;
        $data['vehiclemake'] = $this->Vehiclemodal->get_vehiclemake();
        $data['languages'] = $this->Vehiclemodal->getLanguages();
        if ($status == 1) {

            $this->load->library('Datatables');
            $this->load->library('table');
            $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
                'heading_row_start' => '<tr style= "font-size:10px"role="row">',
                'heading_row_end' => '</tr>',
                'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;">',
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


            $this->table->set_heading('SL NO.', 'BRAND NAME', 'ACTION', 'SELECT');
        } else if ($status == 2) {

            $this->load->library('Datatables');
            $this->load->library('table');

            $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
                'heading_row_start' => '<tr style= "font-size:10px"role="row">',
                'heading_row_end' => '</tr>',
                'heading_cell_start' => '<th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 50px;">',
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

            $this->table->set_heading('SL NO.', 'BRAND NAME', 'MODEL', 'YEAR', 'ACTION', 'SELECT');
        }
        $data['pagename'] = "vehicleSettings/vehicleModels/index";
        $this->load->view("company", $data);
    }

    function datatable_vehiclemodels($status = '') {

        // if ($this->session->userdata('table') != 'company_info') {
        //     $this->Logout();
        // }

        if ($status == 1) {
            $this->Vehiclemodal->datatable_vehicleMake();
        } else if ($status == 2) {
            $this->Vehiclemodal->datatable_vehicleModel();
        }
    }

      //Add/Edit Vehicle make
    public function addEditVehicleMake($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        if ($param == 'add')
            $this->Vehiclemodal->addVehicleMake();
        else if ($param == 'edit')
            $this->Vehiclemodal->editVehicleMake();
        else if ($param == 'deleteMake')
            $this->Vehiclemodal->deletemakeVehicleMake();
        else
            $this->Vehiclemodal->deleteVehicleMake();
    }

    //Add/Edit Vehicle make
    public function addEditVehicleModel($param = '') {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }

        if ($param == 'add')
            $this->Vehiclemodal->addVehicleModel();
        else if ($param == 'edit')
            $this->Vehiclemodal->editVehicleModel();
        else if ($param == 'deletemodel')
            $this->Vehiclemodal->deletemakeVehicleModel();
        else
            $this->Vehiclemodal->deleteVehicleModel();
    }

    public function validateMake() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $this->Vehiclemodal->validateMake();
    }

    public function getMakeDetails() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Vehiclemodal->getMakeDetails();
    }
       public function getMakeData() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Vehiclemodal->getMakeData();
        echo json_encode($data);
    }


}
