<?php

//  error_reporting(E_ALL);
//         ini_set('display_errors', 1);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Franchise extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("Franchisemodal");

        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

//    for generating sequenceid of existing data 
//    public function sequence() {
//           $this->load->library('mongo_db');
//        $allMasters = $this->mongo_db->get_where('Master_products');
//            $i = 0;
//        foreach ($allMasters as $data){
//           $seq = $i;
//            $this->mongo_db->update('Master_products', array('count' => $seq), array('_id' => new MongoId($data['_id'])));
//            $i++;
//        }
//     }


    public function FromAdmin($param = '',$timeOffset='') {
//        print_r($param); die;
        if ($param != '') {
            $this->Franchisemodal->SetSeesionFromAdmin($param , $timeOffset);
            redirect(base_url() . "index.php?/Franchise/loadDashbord");
        }
    }

    public function AuthenticateUser() {
        $status = $this->Franchisemodal->ValidateSuperAdmin();
        if ($status) {
//            $data['BizId'] = $this->session->userdata('BizId');
//            $data['pagename'] = "V_AdminList";
//            $this->load->view("SuperAdmin_Dashbord", $data);
            redirect(base_url() . "index.php?/Franchise/loadDashbord");
        } else {
            $loginerrormsg = "invalid email or password";
            $this->index($loginerrormsg);
        }
    }

    public function loadDashbord() {

        if ($this->issessionset()) {
            $data['dashborddata'] = $this->Franchisemodal->get_Dashbord_data($this->session->userdata('fadmin')['MasterBizId']);
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['pagename'] = "superadmin/V_AdminList";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function validatePassword() {
        return $this->Franchisemodal->validatePassword($this->session->userdata('fadmin')['MasterBizId']);
    }
    public function editpassword() {
        $this->Franchisemodal->editpassword();
//        redirect(base_url() . "index.php?/Business");
    }

    public function CopyBusiness() {
        $this->load->model("Supperadmin");
        $Subs = $this->Supperadmin->CopyBusiness();
        echo json_encode(array('flag' => 0));
//        print_r($Subs);
//        redirect(base_url() . "index.php?/superadmin/SubCategories");
    }

    public function validateEmail_store() {
        $this->load->model("Supperadmin");
        return $this->Supperadmin->validateEmail_store();
    }

    public function index($loginerrormsg = NULL) {
        $data['loginerrormsg'] = $loginerrormsg;
        $this->load->view('login', $data);
    }

    public function get_cities() {
        $this->load->model("Supperadmin");
        $data = $this->Supperadmin->get_cit();
        print_r($data);
//        echo json_encode($data); 
    }

    public function profile() {

        if ($this->issessionset()) {

            $this->load->model("Supperadmin");

//            $data['dashborddata'] = $this->Supperadmin->get_Dashbord_data($this->session->userdata('fadmin')['MasterBizId']);

            $data['ProfileData'] = $this->Supperadmin->GetProfileData($this->session->userdata('fadmin')['MasterBizId']);

            $data['Admin'] = $this->session->userdata('fadmin')['Admin'];

            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];

            $data['CountryList'] = $this->Supperadmin->GetCountry();

            $data['ProCats'] = $this->Supperadmin->AllProviderCategories();
            $data['ProsubCats'] = $this->Supperadmin->AllProvidersubCategories();
            $data['pagename'] = "superadmin/MyProfile";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function getcatdetails() {
//        echo 'hi';
        $this->load->model("Supperadmin");
        $data[] = $this->Supperadmin->getcatdetails();
        echo json_encode($data);
//        redirect(base_url() . "index.php?/superadmin/ServiceCharge");
    }

    public function getsubcatdetails() {
//        echo 'hi';
        $this->load->model("Supperadmin");
        $data[] = $this->Supperadmin->getsubcatdetails();
        echo json_encode($data);
//        redirect(base_url() . "index.php?/superadmin/ServiceCharge");
    }

    public function Categories() {
        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
            $data['language'] = $this->Supperadmin->get_lan_hlpText();
//            print_r($data['language']);
//            exit();
//            $data['dashborddata'] = $this->Supperadmin->get_Dashbord_data($this->session->userdata('fadmin')['MasterBizId']);
//            echo $this->session->userdata('fadmin')['MasterBizId'];
            $data['entitylist'] = $this->Supperadmin->GetAllCategories($this->session->userdata('fadmin')['MasterBizId']);
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['pagename'] = "superadmin/Categories";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function DeleteCat($CatId = '') {
        $this->load->model("Supperadmin");
        $this->Supperadmin->DeleteCat($CatId);
        redirect(base_url() . "index.php?/superadmin/Categories");
    }

    public function ChangeStatus($Centerid = '', $statusId = '') {
        $this->load->model("Supperadmin");
        $this->Supperadmin->ChangeStatus($Centerid, $statusId);
        redirect(base_url() . "index.php?/superadmin/Centers");
    }

    public function ResetPwd($param) {
//       print_r($param);
        $this->load->model("Supperadmin");
        $check = $this->Supperadmin->checkLink($param);
//        print_r($check); die;
        if ($check['flag'] == 1) {
            $this->load->view('error.php');
        } else {
            $data['pagename'] = "ReSetPwd";
            $data['For'] = $param;

            $this->load->view("ResetPassword", $data);
        }
    }

    public function ResetPassword() {
//            echo 'hi';
//            exit();
        $this->load->model("Supperadmin");
        $data = $this->Supperadmin->ResetPwd();
        print_r(json_encode($data));
//        redirect(base_url() . "index.php?/superadmin/Centers");
//        print_r(json_encode($data));
    }

    public function storeResetPassword() {
//            echo 'hi';
//            exit();
        $this->load->model("Supperadmin");
        $data = $this->Supperadmin->storeResetPassword();
//       print_r(json_encode($data));
        redirect(base_url() . "index.php?/superadmin/Centers");
//        print_r(json_encode($data));
    }

    public function SubCategories() {

        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
            $data['language'] = $this->Supperadmin->get_lan_hlpText();
//            echo $this->session->userdata('fadmin')['MasterBizId'];
//            $data['dashborddata'] = $this->Supperadmin->get_Dashbord_data($this->session->userdata('fadmin')['MasterBizId']);
            $data['entitylist'] = $this->Supperadmin->GetAllSubCategories($this->session->userdata('fadmin')['MasterBizId']);
            $data['AllCats'] = $this->Supperadmin->GetAllCategories($this->session->userdata('fadmin')['MasterBizId']);


            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['pagename'] = "superadmin/SubCategories";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function DeleteSubCat($subCatId = '') {
        $this->load->model("Supperadmin");
        $this->Supperadmin->DeleteSubCat($subCatId);
        redirect(base_url() . "index.php?/superadmin/SubCategories");
    }

    public function deletestore() {
//        die();
        $this->load->model("Supperadmin");
        $this->Supperadmin->deletestore();
//        redirect(base_url() . "index.php?/superadmin/Products");
    }

    public function DeleteProduct() {
//        die();
        $this->load->model("Supperadmin");
        $this->Supperadmin->DeleteProduct();
//        redirect(base_url() . "index.php?/superadmin/Products");
    }
	public function forgotPasswordFromadmin() {

        if ($this->session->userdata('table') != 'company_info') {
            $this->Logout();
        }
        $data = $this->Franchisemodal->forgotPasswordFromadmin();
    }

    public function Products() {
        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
            $data['language'] = $this->Supperadmin->get_lan_hlpText();
//            echo $this->session->userdata('fadmin')['MasterBizId'];
//            $data['dashborddata'] = $this->Supperadmin->get_Dashbord_data($this->session->userdata('fadmin')['MasterBizId']);
            $data['entitylist'] = $this->Supperadmin->GetAllProducts($this->session->userdata('fadmin')['MasterBizId']);

            $data['productlist'] = $this->Supperadmin->GetAllCategories($this->session->userdata('fadmin')['MasterBizId']);

            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['pagename'] = "superadmin/Products";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function showsubcat() {

        $this->load->model("Supperadmin");
        $data = $this->Supperadmin->loadsubcat();
        $vt = $this->input->post('vt');

//        echo json_encode($vt);
        $return1 = array();

        if ($vt == '1')
            $this->session->set_userdata(array('BusinessId' => $this->input->post('cat')));

        $return1[] = "<option value=''>Select Subcategory</option>";
        $return1[] = "<option value=''>All</option>";
//        echo $return;

        foreach ($data as $cat)
            $return1[] = "<option value='" . $cat['BusinessId'] . "'>" . implode($cat['SubCategory'], ',') . "</option>";

        print_r($return1);
//        } 
//        echo $return1;
//        echo $return1;
    }

    public function filtercat() {

        $this->load->model("Supperadmin");
        $catid = $this->input->post('cat');
        $scatid = $this->input->post('sid');
        $data = array();
//         echo $catid;
        if ($catid == '0') {
            $data1 = $this->Supperadmin->GetAllProducts($this->session->userdata('fadmin')['MasterBizId']);

            foreach ($data1 as $val) {
//                foreach($val['Masterimageurl'] as $img){
                foreach ($val['Portion'] as $price) {
                    $portionid = $price['PortionID'];
                }
                $portion = $this->mongo_db->get_one("portion", array('_id' => new MongoId($portionid)));
                $portion_Name = implode($portion['PortionName'], ',');
//                        }
//                         echo 'hy  ';
                $data[] = array(
                    'img' => $val['Masterimageurl']['Url'],
                    'p_id' => (string) $val['_id'],
                    'pname' => $val['ProductName'],
                    'cat' => $val['CatName'],
                    'subcat' => $val['SubCatName'],
                    'price' => $price['price'],
                    'portion' => $portion_Name
                );
            }
        } else {
            $data = $this->Supperadmin->getdata();
        }

        echo json_encode(array('res' => $data));
    }

    public function OrderDetails($param = '') {
        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
//            echo $this->session->userdata('fadmin')['MasterBizId'];
            $data['OrderDetails'] = $this->Supperadmin->GetOrderDetails($param);

            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['pagename'] = "superadmin/OrderDetail";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function Orders() {
        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
//            $data['dashborddata'] = $this->Supperadmin->get_Dashbord_data($this->session->userdata('fadmin')['MasterBizId']);
            $data['OrderList'] = $this->Supperadmin->GetAllOrders($this->session->userdata('fadmin')['MasterBizId']);
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['pagename'] = "superadmin/Orders";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function Centers() {
        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
            $data['language'] = $this->Supperadmin->get_lan_hlpText();
//            $data['dashborddata'] = $this->Supperadmin->get_Dashbord_data($this->session->userdata('fadmin')['MasterBizId']);
            $data['BusinessList'] = $this->Supperadmin->GetAllCenters($this->session->userdata('fadmin')['MasterBizId']);
            $data['CountryList'] = $this->Supperadmin->GetCountry();
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['pagename'] = "superadmin/Centers";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function Get_city() {
        // echo 1; die;
//        $drivid = $this->input->post('val');
        $this->load->model("Supperadmin");

        $data = $this->Supperadmin->get_city();
        print_r($data);
//        echo json_encode($res);
    }

    public function addnewbusiness() {

        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
            $data['language'] = $this->Supperadmin->get_lan_hlpText();
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['ProfileData'] = $this->Supperadmin->GetProfileData($this->session->userdata('fadmin')['MasterBizId']);

            $data['CountryList'] = $this->Supperadmin->GetCountry();
//        $data['business'] = $this->Supperadmin->businessdata();
            $data['category'] = $this->Supperadmin->ProviderCategory();
            $data['pagename'] = "superadmin/addnewbusiness";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function editbusiness($params) {

        if ($this->issessionset()) {
//            print_r($params); 
            $this->load->model("Supperadmin");
            $data['ProviderData'] = $this->Supperadmin->GetProviderData($params);
            $data['ProviderData_id'] = ($params);
//            print_r( $data['ProviderData_id']); die;
//            print_r($data['ProfileData'] ); die;
            $data['language'] = $this->Supperadmin->get_lan_hlpText();
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['ProfileData'] = $this->Supperadmin->GetProfileData($this->session->userdata('fadmin')['MasterBizId']);

            $data['CountryList'] = $this->Supperadmin->GetCountry();
//        $data['business'] = $this->Supperadmin->businessdata();
            $data['category'] = $this->Supperadmin->ProviderCategory();
            $data['pagename'] = "superadmin/editbusiness";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function updatebusiness() {
//        echo 1;
//        exit();
        $this->load->model("Supperadmin");
        $this->Supperadmin->updatebusiness();
//        redirect(base_url() . "index.php?/superadmin/businessmgt");
    }

    public function insertbusiness() {
//        echo 1;
//        exit();
        $this->load->model("Supperadmin");
        $this->Supperadmin->insertbusiness();
//        redirect(base_url() . "index.php?/superadmin/businessmgt");
    }

    public function getsubcat() {
//         echo 'superadmin';
        $this->load->model("Supperadmin");
        $data = $this->Supperadmin->getsubcat();
        print_r($data);
//        echo json_encode($data);
    }

    public function AddOns() {
        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
            $data['language'] = $this->Supperadmin->get_lan_hlpText();
//            echo $this->session->userdata('fadmin')['MasterBizId'];
//            $data['dashborddata'] = $this->Supperadmin->get_Dashbord_data($this->session->userdata('fadmin')['MasterBizId']);
            $data['entitylist'] = $this->Supperadmin->GetAllAddOns($this->session->userdata('fadmin')['MasterBizId']);
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['pagename'] = "superadmin/AddOns";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function GetSubCatfromCat() {
        $this->load->model("Supperadmin");
        $Subs = $this->Supperadmin->GetSubCatfromCat();
        print_r($Subs);
//        redirect(base_url() . "index.php?/superadmin/SubCategories");
    }

    public function changeOrder() {
        $this->load->model("Supperadmin");
        $Subs = $this->Supperadmin->changeOrder();
//        print_r($Subs);
//        redirect(base_url() . "index.php?/superadmin/SubCategories");
    }

    public function changeSubCatOrder() {
        $this->load->model("Supperadmin");
        $Subs = $this->Supperadmin->changeSubCatOrder();
//        print_r($Subs);
//        redirect(base_url() . "index.php?/superadmin/SubCategories");
    }

    public function EditProduct($param = '') {
        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
            $data['language'] = $this->Supperadmin->get_lan_hlpText();
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['ProductId'] = $param;
            $data['ProductDetails'] = $this->Supperadmin->GetProductDetails($param);
            $data['ProfileData'] = $this->Supperadmin->GetProfileData($this->session->userdata('fadmin')['MasterBizId']);
            $data['AllBusinesses'] = $data['ProductDetails']['Businesses'];
            $data['AllCats'] = $this->Supperadmin->GetAllCategories($this->session->userdata('fadmin')['MasterBizId']);
            $data['AllAddonCats'] = $this->Supperadmin->GetAllAddOnCats($this->session->userdata('fadmin')['MasterBizId']);
            $data['pagename'] = "superadmin/ProductDetails";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function EditAddon($param = '') {
        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
            $data['language'] = $this->Supperadmin->get_lan_hlpText();
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['AddOnId'] = $param;
            $data['AddonDetails'] = $this->Supperadmin->GetAddonDetails($param);
            $data['pagename'] = "superadmin/NewAddOns";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function GetMongoid() {
        $this->load->model("Supperadmin");
        $Subs = $this->Supperadmin->GetMongoid();
        print_r($Subs);
//        redirect(base_url() . "index.php?/superadmin/SubCategories");
    }

    public function changeProductCatOrder() {
        $this->load->model("Supperadmin");
        $Subs = $this->Supperadmin->changeProductCatOrder();
//        print_r($Subs);
//        redirect(base_url() . "index.php?/superadmin/SubCategories");
    }

    public function NewProduct() {
        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
            $data['language'] = $this->Supperadmin->get_lan_hlpText();
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
            $data['ProfileData'] = $this->Supperadmin->GetProfileData($this->session->userdata('fadmin')['MasterBizId']);
            $data['AllBusinesses'] = $this->Supperadmin->GetAllBusinesses($this->session->userdata('fadmin')['MasterBizId']);
            $data['AllCats'] = $this->Supperadmin->GetAllCategories($this->session->userdata('fadmin')['MasterBizId']);
            $data['AllAddonCats'] = $this->Supperadmin->GetAllAddOnCats($this->session->userdata('fadmin')['MasterBizId']);
//            $data['dashborddata'] = $this->Supperadmin->get_Dashbord_data($this->session->userdata('fadmin')['MasterBizId']);
            $data['count'] = $this->Supperadmin->get_product_count($this->session->userdata('fadmin')['MasterBizId']);
            $data['pagename'] = "superadmin/ProductDetails";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function AddNewAddOns() {
        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
            $data['language'] = $this->Supperadmin->get_lan_hlpText();
            $data['BizId'] = $this->session->userdata('fadmin')['MasterBizId'];
//            $data['dashborddata'] = $this->Supperadmin->get_Dashbord_data($this->session->userdata('fadmin')['MasterBizId']);

            $data['pagename'] = "superadmin/NewAddOns";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    public function DeleteAddOnCat($subCatId = '') {
        $this->load->model("Supperadmin");
        $this->Supperadmin->DeleteAddOnCat($subCatId);
        redirect(base_url() . "index.php?/superadmin/AddOns");
    }

    public function admin_list() {
        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
            $data['Admin_list'] = $this->Supperadmin->LoadAdminList();
            $data['pagename'] = "superadmin/adminlist";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else {
            redirect(base_url() . "index.php?/superadmin");
        }
    }

    public function LoadAdminList() {
//       $this->IsDirectUrl();
        $this->load->model("Supperadmin");
        $data['Admin_list'] = $this->Supperadmin->LoadAdminList();
        $data['pagename'] = "superadmin/adminlist";
        $this->load->view("SuperAdmin_Dashbord", $data);
    }

    public function AddNewAdmin() {
//       $this->IsDirectUrl();
        $this->load->model("Supperadmin");
        $this->Supperadmin->AddNewAdmin();
        redirect(base_url() . "index.php?/superadmin/admin_controller");
    }

    public function AddnewAddOnCategory() {
//       $this->IsDirectUrl();
        $this->load->model("Supperadmin");
        $this->Supperadmin->AddNewAddOns();
        redirect(base_url() . "index.php?/superadmin/AddOns");
    }

    public function AddNewCenter() {
//       $this->IsDirectUrl();
        $this->load->model("Supperadmin");
        $this->Supperadmin->AddNewCenter();
        redirect(base_url() . "index.php?/superadmin/Centers");
    }

    public function AddnewProduct() {
        $this->load->model("Supperadmin");
        $this->Supperadmin->AddnewProduct();
        redirect(base_url() . "index.php?/superadmin/Products");
    }

    public function UpdateProfile() {
        $this->load->model("Supperadmin");
        $this->Supperadmin->UpdateProfile();
        redirect(base_url() . "index.php?/superadmin/profile");
    }

    public function UpdateEmail() {
        $this->load->model("Supperadmin");
        $this->Supperadmin->UpdateEmail();
        redirect(base_url() . "index.php?/superadmin/email");
    }

    public function AddNewCategory() {
        $this->load->model("Supperadmin");
        $this->Supperadmin->AddNewCategory();
        redirect(base_url() . "index.php?/superadmin/Categories");
    }

    public function AddNewSubCategory() {
        $this->load->model("Supperadmin");
        $this->Supperadmin->AddNewSubCategory();
        redirect(base_url() . "index.php?/superadmin/SubCategories");
    }

    public function ChangePassword() {
        $this->IsDirectUrl();
        $currenpassword = $this->input->post("CurrentPassword");
        $adminpassword = $this->session->userdata['password'];
        $email = $this->session->userdata['emailid'];

        if (md5($currenpassword) == $adminpassword) {
            $newpassword = $this->input->post("NewPassword");
            $this->load->model("Supperadmin");
            $this->Supperadmin->ChangePassword($newpassword, $email);
            echo "Password changed successfully";
        } else {
            echo "Current password is wrong";
        }
    }

    public function checkCenterEmail($email = '') {

//echo $email;
        $this->load->model("Supperadmin");
        $this->Supperadmin->checkCenterEmail($email);
    }

    /*
     *
     * logout
     *
     */

    public function logout() {
        $array_items = array('emailid' => '', 'email' => '', 'validate' => false);
        $this->session->unset_userdata($array_items);
        redirect(base_url() . "index.php?/Franchise");
    }

    public function ForgotPassword() {
        $useremail = $this->input->post("resetemail");
//        print_r($useremail); die;
        $this->load->model("Supperadmin");
        $data = $this->Supperadmin->ForgotPassword($useremail);

        if ($data) {
            echo "reset password link is sent to you in mail";
        } else {
            echo "Email ID entered doesn’t not match with any accounts on iDeliver, please try again.";
        }
    }

    public function VerifyResetLink($param) {
        if ($param) {
            $this->load->model("Supperadmin");
            $data = $this->Supperadmin->VerifyResetLink($param);
        }
        if ($data)
            redirect(base_url() . "index.php?/superadmin");
        else
            echo "error while resetting password try again forgot password option";
    }

    // call Admin control clicked

    public function admin_controller() {
        if ($this->issessionset()) {
            $this->load->model("Supperadmin");
            $data['Admin_list'] = $this->Supperadmin->LoadAdminList();
            $data['pagename'] = "superadmin/adminlist";
            $this->load->view("SuperAdmin_Dashbord", $data);
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    // end of admin control
    // call Admin control clicked

    /* public function broker_controller()
      {
      if($this->issessionset()) {
      $this->load->model("Supperadmin");
      $data['broker_list'] = $this->Supperadmin->LoadBrokerList();
      $data['pagename'] = "index.php?/superadmin/brokerlist";
      $this->load->view("SuperAdmin_Dashbord", $data);
      }else
      redirect(base_url()."index.php?/superadmin");

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

                $this->load->model("Supperadmin");
                $this->Supperadmin->AddNewBroker();
                redirect(base_url() . "index.php?/superadmin/broker_controller");
            } else
                redirect(base_url() . "index.php?/superadmin/broker_controller");
        } else
            redirect(base_url() . "index.php?/superadmin");
    }

    /*
     *
     * Edit admin and broker Creation details
     *
     */

    function EditNewAdmin($user = '') {

        $this->load->model("Supperadmin");
        $this->Supperadmin->EditNewAdmin();
        if ($user == 'admin')
            redirect(base_url() . "index.php?/superadmin/admin_controller");
        else if ($user == 'broker')
            redirect(base_url() . "index.php?/superadmin/broker_controller");
    }

    /*
     *
     * Delete admin and broker Creation details
     *
     */

    function DeleteUser($user = '') {

        $this->load->model("Supperadmin");
        $this->Supperadmin->DeleteUser();
        if ($user == 'admin')
            redirect(base_url() . "index.php?/superadmin/admin_controller");
        else if ($user == 'broker')
            redirect(base_url() . "index.php?/superadmin/broker_controller");
    }

    /**
     *
     * validate email is available in database
     */
    public function validateEmail() {
        $this->load->model("Supperadmin");
        return $this->Supperadmin->validateEmail();
    }

    /*
     *
     *
     * check session
     */

    function issessionset() {
        if ($this->session->userdata('fadmin')['MasterBizId']) {

//        if ($this->session->userdata('emailid') && $this->session->userdata('BizId')) {

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
        $this->load->view("SuperAdmin_Dashbord", $data);
    }

    public function loadEditViews($entityname = '', $entityid = '') {
        $this->load->model("Supperadmin");
        $data['entitydata'] = $this->Supperadmin->loadOneEntity($entityname, $entityid);

        if ($entityname == 'Broker') {
            $data['pagename'] = "superadmin/EditBroker";
        }
        $this->load->view("SuperAdmin_Dashbord", $data);
    }

    /*
     * Load pages to add different entities
     */

    public function AddNewEntity($entityname = '') {
        $this->load->model("Supperadmin");
        $this->Supperadmin->AddNewEntity($entityname);
        redirect(base_url() . "index.php?/superadmin/loadEntity/" . $entityname);
    }

    //listing of different entities will go here

    public function loadEntity($entityname = '') {
        $this->load->model("Supperadmin");
        $data['entitylist'] = $this->Supperadmin->LoadEntity($entityname);

        if ($entityname == "Broker") {
            $data['pagename'] = "superadmin/brokerlist";
        }
        $this->load->view("SuperAdmin_Dashbord", $data);
    }

    // delete entity
    public function DeleteEntity($entityname = '', $entityid = '') {
        $this->load->model("Supperadmin");
        $this->Supperadmin->DeleteEntity($entityname, $entityid);
        redirect(base_url() . "index.php?/superadmin/loadEntity/" . $entityname);
    }

    //update entities
    public function EditEntity($entityname = '', $entityid = '') {
        $this->load->model("Supperadmin");
        $this->Supperadmin->EditEntity($entityname, $entityid);
        redirect(base_url() . "index.php?/superadmin/loadEditViews/" . $entityname . "/" . $entityid);
    }

}
