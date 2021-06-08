<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');

        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index($loginerrormsg = NULL) {
        $data['loginerrormsg'] = $loginerrormsg;
        $this->load->view('AdminLogin', $data);
    }

    public function profile() {
        if ($this->issessionset()) {

            $this->load->model("Msuperadmin");

//            $data['dashborddata'] = $this->Msuperadmin->get_Dashbord_data($this->session->userdata('badmin')['BizId']);

            $data['ProfileData'] = $this->Msuperadmin->GetProfileData($this->session->userdata('badmin')['BizId']);
            $data['Admin'] = $this->session->userdata('badmin')['Admin'];
            $data['CountryList'] = $this->Msuperadmin->GetCountry();
//            print_r $data['CountryList'];
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['ProCats'] = $this->Msuperadmin->AllProviderCategories();

            $data['pagename'] = "admin/MyProfile";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }

    public function AuthenticateUser() {
        $this->load->model("Msuperadmin");
        $status = $this->Msuperadmin->ValidateSuperAdmin();
        if ($status) {
//            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
//            $data['pagename'] = "V_AdminList";
//            $this->load->view("V_Dashbord", $data);
            redirect(base_url() . "index.php/Admin/loadDashbord");
        } else {
            $loginerrormsg = "invalid email or password";
            $this->index($loginerrormsg);
        }
    }

    public function changeOrder() {
        $this->load->model("Msuperadmin");
        $Subs = $this->Msuperadmin->changeOrder();
//        print_r($Subs);
//        redirect(base_url() . "index.php/superadmin/SubCategories");
    }

    public function changeSubCatOrder() {
        $this->load->model("Msuperadmin");
        $Subs = $this->Msuperadmin->changeSubCatOrder();
//        print_r($Subs);
//        redirect(base_url() . "index.php/superadmin/SubCategories");
    }

    public function changeProductCatOrder() {
        $this->load->model("Msuperadmin");
        $Subs = $this->Msuperadmin->changeProductCatOrder();
//        print_r($Subs);
//        redirect(base_url() . "index.php/superadmin/SubCategories");
    }
    
   
    public function FromAdmin($param = '') {
        if ($param != '') {
            $this->load->model("Msuperadmin");
            $this->Msuperadmin->SetSeesionFromAdmin($param);
//            echo $this->session->userdata('badmin')['BizId'];
            redirect(base_url() . "index.php/Admin/loadDashbord");
        }
    }

    public function loadDashbord() {

        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
            $data['dashborddata'] = $this->Msuperadmin->get_Dashbord_data($this->session->userdata('badmin')['BizId']);
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/V_AdminList";
            $this->load->view("V_Dashbord", $data);
        } else
        //if session expired
            redirect(base_url() . "index.php/Admin");
    }

    //categories controller
    public function Categories() {
        //check the session.
        if ($this->issessionset()) {
            //select applied model
            $this->load->model("Msuperadmin");
            //get data from model
            $data['entitylist'] = $this->Msuperadmin->GetAllCategories($this->session->userdata('badmin')['BizId']);
            //get id from session
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            //select the page
            $data['pagename'] = "admin/Categories";
            //open the view
            $this->load->view("V_Dashbord", $data);
        } else
        //if session expired
            redirect(base_url() . "index.php/Admin");
    }

    //delete cat controller
    public function DeleteCat($CatId = '') {
        //select model
        $this->load->model("Msuperadmin");
        //call delete method from model
        $this->Msuperadmin->DeleteCat($CatId);
        //redirect
        redirect(base_url() . "index.php/Admin/Categories");
    }

    public function ChangePwd() {

        $data['BizId'] = $this->session->userdata('badmin')['BizId'];
        $data['pagename'] = "admin/ChangePwd";
        $this->load->view("V_Dashbord", $data);
    }

    public function SubCategories() {

        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
//            echo $this->session->userdata('badmin')['BizId'];
//            $data['dashborddata'] = $this->Msuperadmin->get_Dashbord_data($this->session->userdata('badmin')['BizId']);
            $data['entitylist'] = $this->Msuperadmin->GetAllSubCategories($this->session->userdata('badmin')['BizId']);
            $data['AllCats'] = $this->Msuperadmin->GetAllCategories($this->session->userdata('badmin')['BizId']);


            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/SubCategories";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }

    public function DeleteSubCat($subCatId = '') {
        $this->load->model("Msuperadmin");
        $this->Msuperadmin->DeleteSubCat($subCatId);
        redirect(base_url() . "index.php/Admin/SubCategories");
    }

    public function DeleteProduct($subCatId = '') {
        $this->load->model("Msuperadmin");
        $this->Msuperadmin->DeleteProduct($subCatId);
        redirect(base_url() . "index.php/Admin/Products");
    }

    public function Products() {
        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
//            echo $this->session->userdata('badmin')['BizId'];
//            $data['dashborddata'] = $this->Msuperadmin->get_Dashbord_data($this->session->userdata('badmin')['BizId']);
            $data['entitylist'] = $this->Msuperadmin->GetAllProducts($this->session->userdata('badmin')['BizId']);
//            $data['productlist'] = $this->Msuperadmin->GetProducts($this->session->userdata('badmin')['BizId']);
              $data['productlist'] = $this->Msuperadmin->GetAllCategories($this->session->userdata('badmin')['BizId']);

//            foreach($data['entitylist'] as $d ){
//                echo '<pre>';
//                print_r($d["CatName"]);
//                echo '</pre>';
//            }
//            exit();
//            
//            print_r($data['entitylist']);
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/Products";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }
    
    public function showsubcat() {

        $this->load->model("Msuperadmin");
        $data = $this->Msuperadmin->loadsubcat(); 
        $vt = $this->input->post('vt');

//        echo json_encode($vt);
          $return1 = array();

        if ($vt == '1')
            $this->session->set_userdata(array('BusinessId' => $this->input->post('cat')));

        $return1[] = "<option value='0'>Select Subcategory</option>";
        $return1[] = "<option value='0'>All</option>";
//        echo $return;

      
        foreach ($data as $cat) {
//            print_r($cat);
            $return1[] = "<option value='" . $cat['BusinessId'] . "'>" . $cat['SubCategory'] . "</option>";
        } 
        print_r($return1);       
//        echo $return1;
//        echo $return1;
    }
    public function filtercat() {

        $this->load->model("Msuperadmin");
        $data = $this->Msuperadmin->getdata(); 
//        $vt = $this->input->post('vt');
//        if ($vt == '1')
//            $this->session->set_userdata(array('BusinessId' => $this->input->post('cat')));

        echo json_encode(array('res'=>$data));       

    }
   
    
    

    public function SalesAnalytics() {
        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
            $data['entitylist'] = $this->Msuperadmin->SalesAnalytics($this->session->userdata('badmin')['BizId']);
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/SalesAnalytics";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }
    
//    public function drivers($status = "") {
//        if ($this->issessionset()) {
////            print_r($status); die();
////            echo 'controllers';
////             print_r($this->session->userdata('badmin')['BizId']); die();
//            $this->load->model("Msuperadmin");
//           $data['table'] = $this->Msuperadmin->drivers($this->session->userdata('badmin')['BizId']);
////            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
//            $data['pagename'] = "admin/drivers";
//            $this->load->view("V_Dashbord", $data);
//        } else
//            redirect(base_url() . "index.php/Admin");
//    }
    
    public function drivers() {
        //////////////
         if ($this->issessionset()) {
            $this->load->library('Datatables');
            $this->load->library('table');
//            $data['BizId'] = $this->session->userdata('BizId');
            $data['id'] = $this->session->userdata('BizId');
            
            $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="table table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">',
                'heading_row_start' => '<tr style= "font-size:12px" role="row">',
                'heading_row_end' => '</tr>',
                'heading_cell_start' => ' <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size: 12px;">',
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
             $this->table->set_heading('DRIVER ID','FIRST NAME','LAST NAME', 'PHONE','EMAIL','SELECT');

           $data['pagename'] = "admin/drivers";
            $this->load->view("V_Dashbord", $data);
      } else
            redirect(base_url() . "index.php/Admin");
    }
    
    
    public function datatable_drivers($status="") {
             $this->load->model("Msuperadmin");
             
              $data['id'] = $this->session->userdata('badmin')['BizId'];
              print_r($status);
              exit();
            
//        echo 'admin';
//        if ($this->session->userdata('table') != 'company_info') {
//            $this->Logout();
//        }

        $this->Msuperadmin->datatable_drivers($data,$status);
//        echo json_encode($res);
       
        }
    

    public function OrderDetails($param = '') {
        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
//            echo $this->session->userdata('badmin')['BizId'];
            $data['OrderDetails'] = $this->Msuperadmin->GetOrderDetails($param);
            $data['ProfileData'] = $this->Msuperadmin->GetProfileData($this->session->userdata('badmin')['BizId']);
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/OrderDetail";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }

    
    public function NotificationDetails($param = '') {

        $this->load->model("Msuperadmin");

        $OrderDetails = $this->Msuperadmin->GetOrderDetails($param);
        print_r(json_encode($OrderDetails));
    }

    public function Orders() {
        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
//            $data['dashborddata'] = $this->Msuperadmin->get_Dashbord_data($this->session->userdata('badmin')['BizId']);
            $data['OrderList'] = $this->Msuperadmin->GetAllOrders($this->session->userdata('badmin')['BizId']);
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/Orders";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }

    public function OrderHistory() {
        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
//            $data['dashborddata'] = $this->Msuperadmin->get_Dashbord_data($this->session->userdata('badmin')['BizId']);
            $data['OrderList'] = $this->Msuperadmin->GetOrderHistory($this->session->userdata('badmin')['BizId']);
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/OrderHistory";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }

    public function AddOns() {
        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
//            echo $this->session->userdata('badmin')['BizId'];
//            $data['dashborddata'] = $this->Msuperadmin->get_Dashbord_data($this->session->userdata('badmin')['BizId']);
            $data['entitylist'] = $this->Msuperadmin->GetAllAddOns($this->session->userdata('badmin')['BizId']);
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['pagename'] = "admin/AddOns";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }

    public function GetSubCatfromCat() {
        $this->load->model("Msuperadmin");
        $Subs = $this->Msuperadmin->GetSubCatfromCat();
        print_r($Subs);
//        redirect(base_url() . "index.php/Admin/SubCategories");
    }

    public function EditProduct($param = '') {
        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['ProductId'] = $param;
            $data['ProductDetails'] = $this->Msuperadmin->GetProductDetails($param);
            $data['ProfileData'] = $this->Msuperadmin->GetProfileData($this->session->userdata('badmin')['BizId']);
            $data['AllCats'] = $this->Msuperadmin->GetAllCategories($this->session->userdata('badmin')['BizId']);
            $data['AllAddonCats'] = $this->Msuperadmin->GetAllAddOnCats($this->session->userdata('badmin')['BizId']);
            $data['pagename'] = "admin/ProductDetails";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }

    public function EditAddon($param = '') {
        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['AddOnId'] = $param;
            $data['AddonDetails'] = $this->Msuperadmin->GetAddonDetails($param);
            $data['pagename'] = "admin/NewAddOns";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }

    public function GetMongoid() {
        $this->load->model("Msuperadmin");
        $Subs = $this->Msuperadmin->GetMongoid();
        print_r($Subs);
//        redirect(base_url() . "index.php/Admin/SubCategories");
    }

    public function NewProduct() {
        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
            $data['AllCats'] = $this->Msuperadmin->GetAllCategories($this->session->userdata('badmin')['BizId']);
            $data['AllAddonCats'] = $this->Msuperadmin->GetAllAddOnCats($this->session->userdata('badmin')['BizId']);
            $data['ProfileData'] = $this->Msuperadmin->GetProfileData($this->session->userdata('badmin')['BizId']);
            $data['count'] = $this->Msuperadmin->get_product_count($this->session->userdata('badmin')['BizId']);
            echo'1';
            $data['pagename'] = "admin/ProductDetails";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }

    public function AddNewAddOns() {
        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
            $data['BizId'] = $this->session->userdata('badmin')['BizId'];
//            $data['dashborddata'] = $this->Msuperadmin->get_Dashbord_data($this->session->userdata('badmin')['BizId']);

            $data['pagename'] = "admin/NewAddOns";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }

    public function DeleteAddOnCat($subCatId = '') {
        $this->load->model("Msuperadmin");
        $this->Msuperadmin->DeleteAddOnCat($subCatId);
        redirect(base_url() . "index.php/Admin/AddOns");
    }

    public function admin_list() {
        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
            $data['Admin_list'] = $this->Msuperadmin->LoadAdminList();
            $data['pagename'] = "admin/adminlist";
            $this->load->view("V_Dashbord", $data);
        } else {
            redirect(base_url() . "index.php/Admin");
        }
    }

    public function LoadAdminList() {
//       $this->IsDirectUrl();
        $this->load->model("Msuperadmin");
        $data['Admin_list'] = $this->Msuperadmin->LoadAdminList();
        $data['pagename'] = "admin/adminlist";
        $this->load->view("V_Dashbord", $data);
    }

    public function AddNewAdmin() {
//       $this->IsDirectUrl();
        $this->load->model("Msuperadmin");
        $this->Msuperadmin->AddNewAdmin();
        redirect(base_url() . "index.php/Admin/admin_controller");
    }

    public function AddnewAddOnCategory() {
//       $this->IsDirectUrl();
        $this->load->model("Msuperadmin");
        $this->Msuperadmin->AddNewAddOns();
        redirect(base_url() . "index.php/Admin/AddOns");
    }

    public function AddnewProduct() {
        $this->load->model("Msuperadmin");
        $this->Msuperadmin->AddnewProduct();
        redirect(base_url() . "index.php/Admin/Products");
    }

    public function UpdateProfile() {
        $this->load->model("Msuperadmin");
//         $BusinessId = $this->input->post("BusinessId");
        $this->Msuperadmin->UpdateProfile();
        $this->Msuperadmin->updateSession($this->input->post("BusinessId"));
        redirect(base_url() . "index.php/Admin/profile");
    }

    public function UpdatePwd() {
        $this->load->model("Msuperadmin");
        $this->Msuperadmin->UpdatePwd();
        redirect(base_url() . "index.php/Admin/profile");
    }

    public function CheckOldPwd() {
        $this->load->model("Msuperadmin");
//        ECHO $this->session->userdata('badmin')['BizId'];
        $data = $this->Msuperadmin->CheckOldPwd($this->session->userdata('badmin')['BizId']);
        print_r(json_encode($data));
//        redirect(base_url() . "index.php/Admin/profile");
    }

    public function AddNewCategory() {
        $this->load->model("Msuperadmin");
        $this->Msuperadmin->AddNewCategory();
        redirect(base_url() . "index.php/Admin/Categories");
    }

    public function AddNewSubCategory() {
        $this->load->model("Msuperadmin");
        $this->Msuperadmin->AddNewSubCategory();
        redirect(base_url() . "index.php/Admin/SubCategories");
    }

    public function ChangePassword() {
        $this->IsDirectUrl();
        $currenpassword = $this->input->post("CurrentPassword");
        $adminpassword = $this->session->userdata['password'];
        $email = $this->session->userdata['emailid'];

        if (md5($currenpassword) == $adminpassword) {
            $newpassword = $this->input->post("NewPassword");
            $this->load->model("Msuperadmin");
            $this->Msuperadmin->ChangePassword($newpassword, $email);
            echo "Password changed successfully";
        } else {
            echo "Current password is wrong";
        }
    }

    /*
     *
     * logout
     *
     */

    public function logout() {
        $array_items = array('emailid' => '', 'email' => '', 'validate' => false);
        $this->session->unset_userdata($array_items);
        redirect(base_url() . "index.php/Admin");
    }

    public function forgotPassword() {
        $useremail = $this->input->post("resetemail");
        $this->load->model("Msuperadmin");
        $data = $this->Msuperadmin->ForgotPassword($useremail);

        if ($data) {
            echo "Reset password link is sent to you in mail";
        } else {
            echo "Email is not available";
        }
    }

    public function ResetPwd($param1) {
//        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
            $check = $this->Msuperadmin->checkLink($param1);
            if ($check['flag'] == 1) {
                $this->load->view('error.php');
            } else {
                $data['pagename'] = "ReSetPwd";
                $data['For'] = $param1;

                $this->load->view("ResetPassword", $data);
            }
//        } else
//            redirect(base_url() . "index.php/Admin");
    }

    public function ResetPassword() {
        $this->load->model("Msuperadmin");
        $data = $this->Msuperadmin->ResetPwd();
        print_r(json_encode($data));
    }

    public function VerifyResetLink($param) {
        if ($param) {
            $this->load->model("Msuperadmin");
            $data = $this->Msuperadmin->VerifyResetLink($param);
        }
        if ($data)
            redirect(base_url() . "index.php/Admin");
        else
            echo "error while resetting password try again forgot password option";
    }

    // call Admin control clicked

    public function admin_controller() {
        if ($this->issessionset()) {
            $this->load->model("Msuperadmin");
            $data['Admin_list'] = $this->Msuperadmin->LoadAdminList();
            $data['pagename'] = "superadmin/adminlist";
            $this->load->view("V_Dashbord", $data);
        } else
            redirect(base_url() . "index.php/Admin");
    }

    // end of admin control
    // call Admin control clicked

    /* public function broker_controller()
      {
      if($this->issessionset()) {
      $this->load->model("Msuperadmin");
      $data['broker_list'] = $this->Msuperadmin->LoadBrokerList();
      $data['pagename'] = "superadmin/brokerlist";
      $this->load->view("V_Dashbord", $data);
      }else
      redirect(base_url()."index.php/Admin");

      } */


    // end of admin control

    /**
     *
     * add new broker
     *
     */
    public function AddNewBroker() {
        if ($this->issessionset()) {
            if ($this->input->post()) {

                $this->load->model("Msuperadmin");
                $this->Msuperadmin->AddNewBroker();
                redirect(base_url() . "index.php/Admin/broker_controller");
            } else
                redirect(base_url() . "index.php/Admin/broker_controller");
        } else
            redirect(base_url() . "index.php/Admin");
    }

    /*
     *
     * Edit admin and broker Creation details
     *
     */

    function EditNewAdmin($user = '') {

        $this->load->model("Msuperadmin");
        $this->Msuperadmin->EditNewAdmin();
        if ($user == 'admin')
            redirect(base_url() . "index.php/Admin/admin_controller");
        else if ($user == 'broker')
            redirect(base_url() . "index.php/Admin/broker_controller");
    }

    /*
     *
     * Delete admin and broker Creation details
     *
     */

    function DeleteUser($user = '') {

        $this->load->model("Msuperadmin");
        $this->Msuperadmin->DeleteUser();
        if ($user == 'admin')
            redirect(base_url() . "index.php/Admin/admin_controller");
        else if ($user == 'broker')
            redirect(base_url() . "index.php/Admin/broker_controller");
    }

    /**
     *
     * validate email is available in database
     */
    public function validateEmail() {
        $this->load->model("Msuperadmin");
        return $this->Msuperadmin->validateEmail();
    }

    /*
     *
     *
     * check session
     */

    function issessionset() {
        if ($this->session->userdata('badmin')['BizId']) {

//        if ($this->session->userdata('emailid') && $this->session->userdata('badmin')['BizId']) {

            return true;
        }
        return false;
    }

    /*
     * Load pages to add different entities
     */

    public function loadViews($entityname = '') {
        if ($entityname == 'Broker') {
            $data['pagename'] = "superadmin/addnewBroker";
        }
        $this->load->view("V_Dashbord", $data);
    }

    public function loadEditViews($entityname = '', $entityid = '') {
        $this->load->model("Msuperadmin");
        $data['entitydata'] = $this->Msuperadmin->loadOneEntity($entityname, $entityid);

        if ($entityname == 'Broker') {
            $data['pagename'] = "superadmin/EditBroker";
        }
        $this->load->view("V_Dashbord", $data);
    }

    /*
     * Load pages to add different entities
     */

    public function AddNewEntity($entityname = '') {
        $this->load->model("Msuperadmin");
        $this->Msuperadmin->AddNewEntity($entityname);
        redirect(base_url() . "index.php/Admin/loadEntity/" . $entityname);
    }

    //listing of different entities will go here

    public function loadEntity($entityname = '') {
        $this->load->model("Msuperadmin");
        $data['entitylist'] = $this->Msuperadmin->LoadEntity($entityname);

        if ($entityname == "Broker") {
            $data['pagename'] = "superadmin/brokerlist";
        }
        $this->load->view("V_Dashbord", $data);
    }

    // delete entity
    public function DeleteEntity($entityname = '', $entityid = '') {
        $this->load->model("Msuperadmin");
        $this->Msuperadmin->DeleteEntity($entityname, $entityid);
        redirect(base_url() . "index.php/Admin/loadEntity/" . $entityname);
    }

    //update entities
    public function EditEntity($entityname = '', $entityid = '') {
        $this->load->model("Msuperadmin");
        $this->Msuperadmin->EditEntity($entityname, $entityid);
        redirect(base_url() . "index.php/Admin/loadEditViews/" . $entityname . "/" . $entityid);
    }

}
