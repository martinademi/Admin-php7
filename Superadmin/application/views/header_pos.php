<?php require_once 'language.php'; ?>

<?php
$pgname = $pagename;

$acc_pageArr = array(
    'Dashboard' => 'dashboard',
   'carts/carts' => 'carts',
    'city/cities' => 'city',
    'app_confi' => 'appConfig',
    'AppVersions/appVersions' => 'appVersions',
    'AppVersions/showAllUsersAppVersion' => 'appVersions',
    'operators' => 'operator',
    'operator_add' => 'operator',
    'vehicle_models' => 'vmodel',
    'vehicle_type' => 'vtype',
    'vehicle/vehicle_type' => 'vtype',
    'vehicle/typeCityPrice' => 'vtype',
    'vehicle/vehicletype_add' => 'vtype',
    'vehicle/vehicletype_edit' => 'vtype',
    'vehicle/vehicletype_addedit' => 'vtype',
    'vehicletype_add' => 'vtype',
    'vehicletype_edit' => 'vtype',
    'vehicles' => 'vehicle',
    'addnewvehicleForDriver' => 'vehicle',
    'driverVehicles' => 'vehicle',
    'getvehiclesForOperators' => 'vehicle',
    'editvehicleForDriver' => 'vehicle',
    'addnewvehicle' => 'vehicle',
    'editvehicle' => 'vehicle',
    'specialies' => 'goodTypes',
    'operating_zone' => 'zones',
    'long_haul_zone' => 'zones',
    'longHaulDisabledPage' => 'zones',
    'zones_new' => 'zones',
    'zones_pricing' => 'zones',
    'vehicle_pricing' => 'zones',
    'long_haul_zonePricing' => 'zones',
    'shortHaulDisabledPage' => 'zones',
    'drivers' => 'driver',
    'addnewdriver' => 'driver',
    'getDriversForOperators' => 'driver',
    'editdriver' => 'driver',
    'Drivers/shiftLogs' => 'driver',
    'driverVerification' => 'driverVerification',
    'passengers' => 'customer',
    'customerVerification' => 'customerVerification',
    'bookings' => 'allBookings',
    'trip_details' => 'allBookings',
    'DriverAcceptanceRateBookings/totalBooking' => 'allBookings',
    'DriverAcceptanceRateBookings/acceptedBookings' => 'allBookings',
    'DriverAcceptanceRateBookings/rejectedBookings' => 'allBookings',
    'DriverAcceptanceRateBookings/cancelledBookings' => 'allBookings',
    'DriverAcceptanceRateBookings/didNotRespondBookings' => 'allBookings',
    'bookingDispatchedList' => 'allBookings',
    'estimateRequested' => 'allBookings',
    'onGoing_jobs' => 'allBookings',
    'completed_jobs' => 'allBookings',
    'cancelledBookings' => 'allBookings',
    'unassignedBookings' => 'allBookings',
    'expiredBookings' => 'allBookings',
    'DriverAcceptanceRate' => 'driverAcceptanceRate',
    'dispatched' => 'centralDispatcher',
    'Manager/manager' => 'manager',
    'driverReferralTracker' => 'driverReferralTracker',
    'plans' => 'driverPlan',
    'paymentCycle/paymentCycle' => 'paymentCycle',
    'paymentCycle/paymentCycleDriversList' => 'paymentCycle',
    'accounting' => 'accouting',
    'stripeFeeds/stripeFeeds' => 'accouting',
    'wallet/master_wallet' => 'accoutStatements',
    'wallet/master_walletDetails' => 'accoutStatements',
    'wallet/customer_wallet' => 'accoutStatements',
    'wallet/customer_walletDetails' => 'accoutStatements',
    'wallet/app_walletDetails' => 'accoutStatements',
    'wallet/pg_walletDetails' => 'accoutStatements',
    'wallet/operator_walletDetails' => 'accoutStatements',
    'wallet/operator_wallet' => 'accoutStatements',
    'Coupons/refferal' => 'promotions',
    'Coupons/editrefferal' => 'promotions',
    'Coupons/createrefferal' => 'promotions',
    'Coupons/Promotions' => 'promotions',
    'Coupons/promotionshistory' => 'promotions',
    'Coupons/createpromotions' => 'promotions',
    'Coupons/createpromotionsForwallet' => 'promotions',
    'Coupons/editpromotions' => 'promotions',
    'Coupons/editpromotionsForwallet' => 'promotions',
    'utilities/cancell_reasonsCustomer' => 'cancellationReasons',
    'utilities/cancell_reasonsDriver' => 'cancellationReasons',
    'utilities/cancell_reasonsDispatcher' => 'cancellationReasons',
    'Notification/sendNotification' => 'sendNotification',
    'driver_review' => 'driverReview',
    'driverRateForIndividual' => 'driverReview',
    'customerRateForIndividual' => 'driverReview',
    'driverRatingNew' => 'tripRating',
    'manageRole' => 'manageAccess',
    'utilities/hlp_language' => 'language',
    'utilities/supportTextCustomer' => 'supportText',
    'utilities/edit_support_text_Customer' => 'supportText',
    'utilities/Subcat_editCustomer' => 'supportText',
    'utilities/edit_support_text_Driver' => 'supportText',
    'utilities/Subcat_editDriver' => 'supportText',
    'utilities/add_support_catCustomer' => 'supportText',
    'utilities/supportTextDispatcher' => 'supportText',
    'utilities/supportTextDriver' => 'supportText',
    'utilities/add_support_catDriver' => 'supportText',
    'Products/products' => 'products',
    'Products/product_details' => 'products',
    'Products/addNewProducts' => 'products',
    'Uflyproducts/uflyProducts' => 'products',
    'Uflyproducts/Uflyproduct_details' => 'products',
    'Uflyproducts/uflyAddNewProducts' => 'products',
    'Uflyproducts/uflyEditProducts' => 'products',
    'Category/category' => 'category',
    'SubCategory/subcategory' => 'category',
    'SubsubCategory/subsubcategory' => 'category',
    'MetaTags/meta_tags' => 'category',
    'Franchise/franchise' => 'franchise',
    'Business/business' => 'store',
    'Business/addNewStore' => 'store',
     'Business/addNewStorePos' => 'store',
    'logs/message' => 'logs',
    'logs/email' => 'logs',
    'customer/profile' => 'customers',
    'customer/customer' => 'customers',
    'customer/guest' => 'customers',
    'Storemanagers/storeManagers'=>'storeManagers',
    'dispatchLogs/dispatchLogs'=>'dispatchLogs'
);
$access_right = $this->session->userdata("access_rights");
$main_admin_check = $this->session->userdata("mainAdmin");
$access_right['access_denied'] = 111;
$access_right['store'] = 111;
$access_right['products'] = 111;
$access_right['dispatchLogs'] = 111;
$access_right['category'] = 111;
$access_right['customers'] = 111;
$access_right['storeManagers'] = 111;

//$acc_pageArr['Business/addNewStore']


$access_right_pg = $access_right[$acc_pageArr[$pagename]];

if ($main_admin_check != true) {
//        print_r($access_right);die;
    if ($access_right_pg == 000) {
        redirect(base_url() . 'accessDeniedPage.php');
    }
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <!--<link rel="shortcut icon" href="<?php echo base_url(); ?>theme/icon/loopz logo.png" />-->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>theme/icon/uflylogo.png" />
        <!--<title><?php echo Appname; ?></title>-->
        <title><?php echo "Ufly"; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>theme/pages/ico/60.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>theme/pages/ico/76.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>theme/pages/ico/120.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>theme/pages/ico/152.png">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta content="" name="description" />
        <meta content="" name="author" />

        <script src="<?php echo base_url(); ?>theme/assets/plugins/jquery/jquery-1.8.3.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>theme/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" media="screen">
        <link href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/shypersuperadmin.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>build/css/custom.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/bootstrap-multiselect.css" rel="stylesheet">


        <link href="<?php echo base_url(); ?>build/css/adminAllStyles.css" rel="stylesheet">

        <script>
            $(document).ready(function () {
            var access_right_pg = '<?= $access_right_pg ?>';
                    var access_right = JSON.parse('<?= json_encode($access_right) ?>');
                    var main_admin_check = '<?= $main_admin_check ?>';
                    var acc_pageArr = JSON.parse('<?= json_encode($acc_pageArr) ?>');
                    var headerArr = {
                    'Dashboard': 'dashboard',
                            'carts/carts': 'carts',
                            'city/cities': 'city',
                            'app_confi': 'appConfig',
                            'AppVersions/appVersions': 'appVersions',
                            'AppVersions/showAllUsersAppVersion': 'appVersions',
                            'operators': 'operator',
                            'operator_add': 'operator',
                            'vehicle_models': 'vmodel',
                            'vehicle/typeCityPrice': 'typeCityPrice',
                            'vehicle/vehicle_type': 'vtype',
                            'vehicle_type': 'vtype',
                            'vehicletype_add': 'vtype',
                            'vehicletype_edit': 'vtype',
                            'vehicles': 'vehicle',
                            'addnewvehicleForDriver': 'vehicle',
                            'driverVehicles': 'vehicle',
                            'getvehiclesForOperators': 'vehicle',
                            'editvehicleForDriver': 'vehicle',
                            'addnewvehicle': 'vehicle',
                            'editvehicle': 'vehicle',
                            'specialies': 'goodTypes',
                            'operating_zone': 'zones',
                            'zones_pricing': 'zones',
                            'vehicle_pricing': 'zones',
                            'long_haul_zone': 'zones',
                            'long_haul_zonePricing': 'zones',
                            'shortHaulDisabledPage': 'zones',
                            'drivers': 'driver',
                            'getDriversForOperators': 'driver',
                            'addnewdriver': 'driver',
                            'editdriver': 'driver',
                            'driverVerification': 'driverVerification',
                            'passengers': 'customer',
                            'customerVerification': 'customerVerification',
                            'bookings': 'allBookings',
                            'trip_details': 'allBookings',
                            'estimateRequested': 'estimateRequested',
                            'onGoing_jobs': 'onGoingBookings',
                            'completed_jobs': 'completedBookings',
                            'cancelledBookings': 'cancelledBookings',
                            'DriverAcceptanceRate': 'driverAcceptanceRate',
                            'dispatched': 'centralDispatcher',
                            'driverReferralTracker': 'driverReferralTracker',
                            'plans': 'driverPlan',
                            'paymentCycle/paymentCycle': 'paymentCycle',
                            'accounting': 'accouting',
                            'stripeFeeds/stripeFeeds': 'accouting',
                            'wallet/master_wallet': 'accoutStatements',
                            'wallet/master_walletDetails': 'accoutStatements',
                            'wallet/customer_wallet': 'accoutStatements',
                            'wallet/customer_walletDetails': 'accoutStatements',
                            'wallet/app_walletDetails': 'accoutStatements',
                            'wallet/pg_walletDetails': 'accoutStatements',
                            'wallet/operator_wallet': 'accoutStatements',
                            'wallet/operator_walletDetails': 'accoutStatements',
                            'Coupons/refferal': 'promotions',
                            'Coupons/editrefferal': 'promotions',
                            'Coupons/createrefferal': 'promotions',
                            'Coupons/Promotions': 'promotions',
                            'Coupons/promotionshistory': 'promotions',
                            'Coupons/createpromotions': 'promotions',
                            'Coupons/createpromotionsForwallet': 'promotions',
                            'Coupons/editpromotions': 'promotions',
                            'Coupons/editpromotionsForwallet': 'promotions',
                            'utilities/cancell_reasonsCustomer': 'cancellationReasons',
                            'utilities/cancell_reasonsDriver': 'cancellationReasons',
                            'utilities/cancell_reasonsDispatcher': 'cancellationReasons',
                            'Notification/sendNotification': 'sendNotification',
                            'driver_review': 'driverReview',
                            'driverRateForIndividual': 'tripRating',
                            'customerRateForIndividual': 'tripRating',
                            'driverRatingNew': 'tripRating',
                            'manageRole': 'manageAccess',
                            'utilities/hlp_language': 'language',
                            'utilities/supportTextCustomer': 'supportText',
                            'utilities/add_support_catCustomer': 'supportText',
                            'utilities/supportTextDriver': 'supportText',
                            'utilities/add_support_catDriver': 'supportText',
                            'Products/products': 'products',
                            'Uflyproducts/uflyProducts' : 'products',
                            'Uflyproducts/Uflyproduct_details' : 'products',
                            'Uflyproducts/uflyAddNewProducts' : 'products',
                            'Uflyproducts/uflyEditProducts' : 'products',
                            'Category/category': 'category',
                            'SubCategory/subcategory': 'category',
                            'SubsubCategory/subsubcategory': 'category',
                            'MetaTags/meta_tags': 'category',
                            'Franchise/franchise': 'franchise',
                            'Business/business': 'store',
                            'Business/addNewStore': 'store',
                            'logs/message': 'logs',
                            'logs/email': 'logs',
                            'customer/profile': 'customers',
                            'customer/customer': 'customers',
                            'customer/guest': 'customers',
                             'Storemanagers/storeManagers':'storeManagers',
                             'dispatchLogs/dispatchLogs':'dispatchLogs'
                    };
                    var pgname = '<?= $pagename ?>';
                    var baseUrl = '<?php echo base_url() ?>';
                    /*
                     * .cls100 = view
                     * .cls110 = add
                     * .cls111 = edit and delete
                     */
                    if (main_admin_check != true) {
            if (access_right_pg == 000) {
            //                        base_url().'index.php?/superadmin/access_denied';
            } else if (access_right_pg == 100) {
            $('.cls110').remove();
                    $('.cls111').remove();
            } else if (access_right_pg == 110) {
            $('.cls111').remove();
            } else if (access_right_pg == 111) {

            }
            $.each(acc_pageArr, function (ind, val) {
            var nav_pages = access_right[val];
                    if (nav_pages == 000 || typeof nav_pages == 'undefined') {
            var pagecls = headerArr[ind];
                    $(pagecls).remove();
            }
            });
            }
            }
            );
        </script>
        <style>
            .modalPopUpText{
                font-size: 14px !important;
                text-align:center;
            }
        </style>

    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">

<!--                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view leftSideMenu">
                        <div class="navbar nav_title" style="border: 0;">
                            <img src="<?php echo base_url() ?>theme/icon/loopz logo.png" alt="logo" id="company_log" style="height: 45px;margin-left: 25px;">
                            <img src="<?php echo base_url() ?>theme/icon/uflylogo.png" alt="logo" id="company_log" style="height: 45px;margin-left: 25px;">
                            <a href="#" class="site_title" style="padding-left: 22%;"></<span><?php echo strtoupper(Appname); ?></span></a>
                        </div>

                        <div class="clearfix"></div>

                         menu profile quick info 
                        <div class="profile">
                            <div class="profile_pic">
                                <img src="<?php echo base_url() . '../../pics/user.jpg' ?>" alt="..." class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Welcome <?php echo $this->session->userdata('first_name'); ?></span>
                                <h5 style="color:mediumaquamarine">

                                    <span class="green"><?php echo $this->session->userdata('role'); ?></span>
                                </h5>
                            </div>
                        </div>


                         sidebar menu 

                         /sidebar menu 

                         /menu footer buttons 

                         /menu footer buttons 
                    </div>
                </div>-->















