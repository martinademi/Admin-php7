<?php require_once 'language.php'; ?>

<?php
$pgname = $pagename;

$acc_pageArr = array(
    'Dashboard' => 'dashboard',
    'cart/carts' => 'carts',
    'cart/cartsAction' => 'carts',
    'cart/cartDetails' => 'carts',
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
     'Uflyproducts/storeProducts' => 'products',
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
    'Business/editbusiness' => 'store',
    'logs/message' => 'logs',
    'logs/email' => 'logs',
    'logs/campaignQualifiedTripLogs' => 'logs',
    'logs/inputTripLogs' => 'logs',
    'logs/promoCodeLogs' => 'logs',
    'logs/promoLogs' => 'offers',
    'marketing/inputTripLogs' => 'offers',
    'customer/profile' => 'customers',
    'customer/customer' => 'customers',
    'customer/guest' => 'customers',
    'Storemanagers/storeManagers' => 'storeManagers',
    'dispatchLogs/dispatchLogs' => 'dispatchLogs',
    'marketing/addNewPromoCode' => 'offers',
    'marketing/addNewReferralCampaign' => 'offers',
    'marketing/addNewCampaign' => 'offers',
    'marketing/campaignsList' => 'offers',
    'marketing/couponCodeList' => 'offers',
    'marketing/referralCodeList' => 'offers',
    'marketing/campaignQualifiedTripLogs' => 'offers',
    'marketing/inputTripLogs' => 'offers',
    'marketing/promoLogs' => 'offers',
    'marketing/claimsList' => 'offers',
    'marketing/unlockedList' => 'offers',
    'marketing/qualifiedTrips' => 'offers',
    'marketing/referralList' => 'offers',
    'marketing/refCodesByCampAndUserId' => 'offers',
    'marketing/referalQulTripLogs' => 'offers',
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
        <link href="<?php echo base_url(); ?>vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/bootstrap-multiselect.css" rel="stylesheet">
        


        <link href="<?php echo base_url(); ?>build/css/adminAllStyles.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/plugins/timepicker/bootstrap-timepicker.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-html5-1.5.1/cr-1.4.1/fh-3.1.3/r-2.2.1/datatables.min.css"/>

        <script>
            $(document).ready(function () {
            var access_right_pg = '<?= $access_right_pg ?>';
                    var access_right = JSON.parse('<?= json_encode($access_right) ?>');
                    var main_admin_check = '<?= $main_admin_check ?>';
                    var acc_pageArr = JSON.parse('<?= json_encode($acc_pageArr) ?>');
                    var headerArr = {
                    'Dashboard': 'dashboard',
                            'cart/carts': 'carts',
                            'cart/cartsAction': 'carts',
                            'cart/cartDetails': 'carts',
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
                            'Uflyproducts/storeProducts' : 'products',
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
                            'Business/editbusiness' : 'store',
                            'logs/message': 'logs',
                            'logs/email': 'logs',
                            'logs/campaignQualifiedTripLogs' : 'logs',
                            'logs/inputTripLogs' : 'logs',
                            'logs/promoCodeLogs' : 'logs',
                            'customer/profile': 'customers',
                            'customer/customer': 'customers',
                            'customer/guest': 'customers',
                            'Storemanagers/storeManagers':'storeManagers',
                            'dispatchLogs/dispatchLogs':'dispatchLogs',
                            'marketing/addNewPromoCode' : 'offers',
                            'marketing/addNewReferralCampaign' : 'offers',
                            'marketing/logs' : 'offers',
                            'marketing/addNewCampaign' : 'offers',
                            'marketing/campaignsList' : 'offers',
                            'marketing/couponCodeList' : 'offers',
                            'marketing/referralCodeList': 'offers',
                            'marketing/campaignQualifiedTripLogs' : 'offers',
                            'marketing/inputTripLogs' : 'offers',
                            'marketing/promoLogs' : 'offers',
                            'marketing/claimsList' : 'offers',
                            'marketing/unlockedList' : 'offers',
                            'marketing/qualifiedTrips' : 'offers',
                            'marketing/referralList' : 'offers',
                            'marketing/refCodesByCampAndUserId' : 'offers',
                            'marketing/referalQulTripLogs' : 'offers',
                            



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

                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view leftSideMenu">
                        <div class="navbar nav_title" style="border: 0;">
                            <!--<img src="<?php echo base_url() ?>theme/icon/loopz logo.png" alt="logo" id="company_log" style="height: 45px;margin-left: 25px;">-->
                            <img src="<?php echo base_url() ?>theme/icon/uflylogo.png" alt="logo" id="company_log" style="height: 45px;margin-left: 25px;">
                            <!--<a href="#" class="site_title" style="padding-left: 22%;"></<span><?php echo strtoupper(Appname); ?></span></a>-->
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
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


                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side main_menu">
                            <div class="menu_section">
                                <h3 style="display: -webkit-box;"></h3>
                                <ul class="nav side-menu leftSideMenu">

                                    <li class="dashboard"><a  href="<?php echo base_url(); ?>index.php?/superadmin/Dashboard"><img class="menuIconClass" src="<?php echo ServiceLink . '/pics/Dashboard.png' ?>" >DASHBOARD</a></li>
                                    <!--<li class="city"><a  href="<?php // echo base_url();       ?>index.php?/superadmin/cities"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cities.png' ?>" >CITIES</a></li>-->
                                    <li class="city"><a  href="<?php echo base_url(); ?>index.php?/City"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cities.png' ?>" >CITIES</a></li>
                                    <li class="appConfig"><a  href="<?php echo base_url(); ?>index.php?/superadmin/app_config"><img style="margin-right: 3%;margin-bottom: 1%;" src="<?php echo ServiceLink . 'pics/disputes_off.png' ?>" >APP CONFIGURATION</a></li> 
                                    <li class="appVersions"><a  href="<?php echo base_url(); ?>index.php?/appVersions/appVersions/21"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" > APP VERSIONS</a></li>    
                                    <!--<li class="products"><a  href="<?php echo base_url(); ?>Products"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/product.png" > PRODUCTS</a></li>-->    
                                    <!--<li class="products"><a  href="<?php echo base_url(); ?>Uflyproducts"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/product.png" > PRODUCTS</a></li>-->    
                                    <!--<li class="products"><a  href="<?php echo base_url(); ?>index.php?/AddNewProducts"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/product.png" > PRODUCTS</a></li>-->    
                                    <li class="products"><a><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/product.png" > PRODUCTS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                           
                                            <li><a  href="<?php echo base_url(); ?>index.php?/AddNewProducts"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/product.png" >ALL</a></li>    
                                            <li><a  href="<?php echo base_url(); ?>index.php?/AddNewProducts/storeProducts"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/product.png" >MANAGE</a></li>    
                                        </ul>
                                    </li>
                                    
                                    
                                    
                                    <li class="category"><a  href="<?php echo base_url(); ?>index.php?/Category"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/Category.png" > CATEGORIES</a></li>    
                                    <!--<li class="franchise"><a  href="<?php echo base_url(); ?>Franchise"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/Francies_location.png" > FRANCHISE</a></li>-->    

                                    <li class="store"><a  href="<?php echo base_url(); ?>index.php?/Business"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/store.png" > DISPENSARIES</a></li>

                                    <!-- Header -->
                                    <li class="carts"><a  href="<?php echo base_url(); ?>index.php?/CartsController"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/store.png" > CARTS</a></li>    

                                    <li class="operator"><a  href="<?php echo base_url(); ?>index.php?/superadmin/operators/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Comapnies.png' ?>" >OPERATORS</a></li>

                                    <li class="offers"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicles.png'; ?>" >MARKETING<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li ><a  href="<?php echo base_url(); ?>index.php?/campaigns/index/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle types.png' ?>" >PROMO CAMPAIGNS</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/referralController/index/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicles.png' ?>" >REFERRAL CAMPAIGN</a></li> 
                                            <li><a  href="<?php echo base_url(); ?>index.php?/CouponCode/index/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle Models.png' ?>" >PROMO CODES</a> </li>                                       
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/campaignQualifiedTripLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">CAMPAIGN QUALIFIED TRIP LOGS</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/promoLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">PROMO CODE CLAIM LOGS</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/inputTripLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">INPUT TRIP LOGS</a></li>
                                        </ul>
                                    </li>   
                                    <li class="vehicleSettings"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicles.png'; ?>" >VEHICLE SETTINGS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li ><a  href="<?php echo base_url(); ?>index.php?/vehicle/vehicle_type"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle types.png' ?>" >VEHICLE TYPES</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/superadmin/Vehicles/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicles.png' ?>" >VEHICLES</a></li> 
                                            <li><a  href="<?php echo base_url(); ?>index.php?/superadmin/vehicle_models/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle Models.png' ?>" >VEHICLE MODELS</a> </li>                                       
                                        </ul>
                                    </li>                                    



                                    <li class="zones"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >ZONES<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/operating_zone"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" >OPERATING ZONE</a></li>-->
                                            <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/long_haul_zone"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" >LONG HAUL ZONE</a></li>-->
                                            <li><a href="<?php echo base_url(); ?>index.php?/superadmin/zones"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >SERVICE ZONES</a></li>
                                        </ul>
                                    </li>

                                    <li class="customers"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >CUSTOMERS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="<?php echo base_url(); ?>index.php?/Customer">
                                                    <img src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" alt="..." class="img-superadminIcon">
                                                    <span class="titleSuperadmin">REGISTERED</span>
                                                </a></li>
                                            <li><a href="<?php echo base_url(); ?>index.php?/Guest">
                                                    <img src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" alt="..." class="img-superadminIcon">
                                                    <span class="titleSuperadmin">GUEST</span>
                                                </a></li>
                                        </ul>

                                    </li>

                                    <li  class="driver"><a  href="<?php echo base_url(); ?>index.php?/superadmin/Drivers/my/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Drivers.png' ?>" >DRIVERS</a></li>  
                                    <!--<li  class="customer"><a  href="<?php // echo base_url();     ?>index.php?/superadmin/customers/3"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >CUSTOMERS</a></li>--> 
                                    <li class="verification"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >VERIFICATION<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li ><a  href="<?php echo base_url(); ?>index.php?/superadmin/driverVerification"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Customer-Verification.png' ?>" >DRIVER</a>
                                            <li ><a  href="<?php echo base_url(); ?>index.php?/welcome/customerVerification"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >CUSTOMER</a></li> 
                                        </ul>
                                    </li>



                                    <li  class="storeManagers"><a  href="<?php echo base_url(); ?>index.php?/Storemanagers"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Drivers.png' ?>" >STORE MANAGERS</a></li>  
                                    <!--<li class="godsview"><a class="godviewLink" target="_blank" href="<?php // echo GodsviewLink;  ?>?id=<?php echo $this->session->userdata('godsviewToken'); ?>"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/GodsView.png' ?>" >GODSVIEW</a></li>-->  

                                    <li class="bookings"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >ALL ORDERS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <!--<li  class="estimateRequested"><a  href="<?php echo base_url(); ?>index.php?/superadmin/estimateRequested"><img class="menuIconClass" src="<?php // echo ServiceLink . 'pics/Shape ongoingbooking_off.png'  ?>" >ESTIMATE REQUESTED</a> </li>--> 
                                            <!--<li  class="allBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/bookings/13"><img class="menuIconClass" src="<?php // echo ServiceLink . 'pics/All dispatched jobs.png'  ?>" >ALL BOOKINGS</a></li>--> 
                                            <li  class="dispatchLogs"><a  href="<?php echo base_url(); ?>index.php?/DispatchLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Drivers.png' ?>" >DISPATCH LOGS</a></li>  
                                            <li class="onGoingBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/onGoing_jobs/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape ongoingbooking_off.png' ?>" >ON GOING ORDERS</a></li> 
                                            <li class="completedBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/completed_jobs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/completedjobs_off.png' ?>" >COMPLETED ORDERS</a></li> 
                                            <li class="cancelledBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/cancelledBookings"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancelled-Bookings.png' ?>" >CANCELLED ORDERS</a></li> 
                                            <li class="unassignedBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/unassignedBookings"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancelled-Bookings.png' ?>" >UNASSIGNED ORDERS</a></li> 
                                            <li class="expiredBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/expiredBookings"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancelled-Bookings.png' ?>" >EXPIRED ORDERS</a></li> 

                                        </ul>
                                    </li>


                                    <li class="driverAcceptanceRate"><a  href="<?php echo base_url(); ?>index.php?/superadmin/DriverAcceptanceRate"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/completedjobs_off.png' ?>" >DRIVER ACCEPTANCE RATE</a></li> 
                                    <li><a  href="<?php echo base_url(); ?>index.php?/managers"><img class="menuIconClass"  src="<?php echo ServiceLink . 'pics/dispatcher_off.png' ?>" class="">MANAGERS</a></li>       

                                    <li class="centralDispatcher"><a  href="<?php echo base_url(); ?>index.php?/superadmin/dispatched/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/dispatcher_off.png' ?>" >CENTRAL DISPATCHERS</a></li>
                                    <li class="driverReferralTracker"><a  href="<?php echo base_url(); ?>index.php?/superadmin/driverReferral"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver-Referrals-Tracker.png' ?>" >DRIVER REFERRAL TRACKER</a></li>
                                    <li class="driverPlan"><a  href="<?php echo base_url(); ?>index.php?/superadmin/driverPlans"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver-Plans.png' ?>" >DRIVER PLANS</a></li>
                                    <li class="paymentCycle"><a  href="<?php echo base_url(); ?>index.php?/superadmin/paymentCycle"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" >PAYMENT CYCLE</a></li>
                                    <li class="accounting"><a  href="<?php echo base_url(); ?>index.php?/superadmin/accounting"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/accounting_off.png' ?>"> ACCOUNTING</a></li> 


                                    <li class="stripeFeed"><a  href="<?php echo base_url(); ?>index.php?/Stripefeeds"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/accounting_off.png' ?>">STRIPE FEEDS</a></li> 


                                    <li class="logs" ><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" class="">LOGS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/campaignQualifiedTripLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">SMS</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/email"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">EMAIL</a></li>
                                            <!-- <li><a  href="<?php echo base_url(); ?>index.php?/logs/email"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">CAMPAIGN QUALIFIED TRIP LOGS</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/promoLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">PROMO CODE CLAIM LOGS</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/inputTripLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">INPUT TRIP LOGS</a></li> -->
                                        </ul>
                                    </li>


                                    <li class="wallet"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >ACCOUNT STATEMENT<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="master_wallet"><a  href="<?php echo base_url(); ?>index.php?/WalletController/wallet/1/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >DRIVER WALLET</a></li>
                                            <li class="customer_wallet"><a  href="<?php echo base_url(); ?>index.php?/WalletController/wallet/2/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >CUSTOMER WALLET</a></li>
                                            <li class="app_walletDetails"><a  href="<?php echo base_url(); ?>index.php?/WalletController/app_walletDetails"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >APP WALLET</a></li>
                                            <li class="pg_walletDetails"><a  href="<?php echo base_url(); ?>index.php?/WalletController/pg_walletDetails"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >PG WALLET</a></li>
                                            <li class="operator_wallet"><a  href="<?php echo base_url(); ?>index.php?/WalletController/wallet/3/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >OPERATOR WALLET</a></li>
                                        </ul>
                                    </li>
                                    <li class="promotions"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >PROMOTION<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a  href="<?php echo base_url(); ?>index.php?/coupons/refferal"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" >REFERRALS</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/coupons/promotion"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" >PROMO CODES</a></li>
                                            <!--<li><a href="<?php echo base_url(); ?>index.php?/coupons/zones"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >PROMO ZONE</a></li>-->
                                        </ul>
                                    </li>
                                    <li class="appText"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >APP TEXT SETTING<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="language"><a  href="<?php echo base_url(); ?>index.php?/Utilities/lan_help"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" >LANGUAGE</a></li>   
                                            <li class="supportText"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >SUPPORT TEXT<span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/supportTextCustomer"><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >CUSTOMER</a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/supportTextDriver"><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >DRIVER</a></li>
                                                </ul>
                                            </li>
                                            <li class="cancellationReasons"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancellation-Reasons.png' ?>" >CANCELLATION REASONS<span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/cancellationCustomer"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancellation-Reasons.png' ?>" >CUSTOMER</a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/cancellationDriver"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancellation-Reasons.png' ?>" >DRIVER</a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/cancellationDispatcher"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancellation-Reasons.png' ?>" >DISPATCHER</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>



                   <!--<li><a  href="<?php echo base_url(); ?>index.php?/Utilities/email_template"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" >EMAIL TEMPLATES</a>-->

                                    <!--</li>--> 
                                    <li class="sendNotification"> <a  href="<?php echo base_url(); ?>index.php?/Sendnotification"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/completedjobs_off.png' ?>" > SEND NOTIFICATION</a></li>

                                    <li class="ratings"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png'; ?>" >RATINGS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="driverReview"><a  href="<?php echo base_url(); ?>index.php?/superadmin/driver_review/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" > DRIVER RATING</a></li>    
                                            <li class="tripRating"><a  href="<?php echo base_url(); ?>index.php?/superadmin/driverRating"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" > CONFIGURE RATING</a></li>    
                                        </ul>
                                    </li>
                                    <li class="manageAccess"><a  href="<?php echo base_url(); ?>index.php?/superadmin/manageRole"><img class="menuIconClass"  src="<?php echo ServiceLink . 'pics/disputes_off.png' ?>" > MANAGE ACCESS</a></li> 



                                </ul>
                            </div>


                        </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->

                        <!-- /menu footer buttons -->
                    </div>
                </div>















