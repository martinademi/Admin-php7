<?php require_once 'language.php'; ?>

<?php
$pgname = $pagename;

$acc_pageArr = array(
    'Dashboard' => 'dashboard',
    'cart/carts' => 'carts',
    'cart/cartsAction' => 'carts',
    'city/cities' => 'city',
    'city/createCity1' => 'city',
    'city/createCity' => 'city',
    'city/editCity' => 'city',
    'city/index' => 'city',
    'app_confi' => 'appConfig',
    'Manufacturer/manufacturer' => 'manufacturer',
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
    'drivers_1' => 'driver',
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
    'paymentGateway/index' => 'paymentgateway',
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
    'Uflyproducts/productDetails' => 'products',
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
    'customer/profile' => 'customers',
    'customer/customer' => 'customers',
    'customer/guest' => 'customers',
    'Storemanagers/storeManagers' => 'storeManagers',
    'dispatchLogs/dispatchLogs' => 'dispatchLogs',
    'marketing/addNewPromoCode' => 'offers',
    'marketing/addNewReferralCampaign' => 'offers',
    'marketing/logs' => 'offers',
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
    'Colors/colors' => 'colors',
    'Taxes/tax' => 'taxes',
    'SizeGroups/sizegroup' => 'sizegroup',
    'Brands/brands' => 'brands',
    'AppWebPages/cterms' => 'policyPages',
    'AppWebPages/dterms' => 'policyPages',
    'AppWebPages/cprivacy' => 'policyPages',
    'AppWebPages/dprivacy' => 'policyPages',
    'AppWebPages/faq' => 'policyPages',
    'AppWebPages/refund' => 'policyPages',
    'AppWebPages/contactUs' => 'policyPages',
    'AppWebPages/aboutUs' => 'policyPages',
    'storeCommission/commission' => 'storeCommission',
    'utilities/cancell_reasons' => 'can_reason',
    'Parameters/parameters' => 'parameters',
    'Parameters/driverRatingNew' => 'parameters',
    'Parameters/customerReview' => 'parameters',
    'Parameters/orderReview' => 'parameters',
    'StoreCategories/Category' => 'storeCategory',
    'StoreCategories/subCategory' => 'storeCategory',
    'Zones/index' => 'zones',
    'Zones/create' => 'zones',
    'Zones/edit' => 'zones',
    'Uflyproducts/storeProducts' => 'storeproducts'
);
$access_right = $this->session->userdata("access_rights");
$main_admin_check = $this->session->userdata("mainAdmin");
$access_right['access_denied'] = 111;
$access_right['products'] = 111;
$access_right['storeproducts'] = 111;
$access_right['storeManagers'] = 111;
$access_right['store'] = 111;
$access_right['colors'] = 111;
$access_right['taxes'] = 111;
$access_right['sizegroup'] = 111;
$access_right['brands'] = 111;
$access_right['policyPages'] = 111;
$access_right['storeCommission'] = 111;
$access_right['can_reason'] = 111;
$access_right['category'] = 111;
$access_right['parameters'] = 111;
$access_right['product_offers'] = 111;


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
                    'cart/carts': 'carts',
                    'cart/cartsAction': 'carts',
                    'city/cities': 'city',
                    'city/createCity1': 'city',
                    'city/createCity': 'city',
                    'city/editCity': 'city',
                    'city/index': 'city',
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
                    'Manufacturer/manufacturer': 'manufacturer',
                    'drivers': 'driver',
                    'drivers_1': 'driver',
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
                    'paymentGateway/index': 'paymentgateway',
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
                    'StoreCategories/Category': 'storeCategory',
                    'StoreCategories/subCategory': 'storeCategory',
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
                    'Uflyproducts/uflyProducts': 'products',
                    'Uflyproducts/Uflyproduct_details': 'products',
                    'Uflyproducts/uflyAddNewProducts': 'products',
                    'Uflyproducts/uflyEditProducts': 'products',
                    'Uflyproducts/productDetails': 'products',
                    'Category/category': 'category',
                    'SubCategory/subcategory': 'category',
                    'SubsubCategory/subsubcategory': 'category',
                    'MetaTags/meta_tags': 'category',
                    'Franchise/franchise': 'franchise',
                    'Business/business': 'store',
                    'Business/addNewStore': 'store',
                    'Business/editbusiness': 'store',
                    'logs/message': 'logs',
                    'logs/email': 'logs',
                    'customer/profile': 'customers',
                    'customer/customer': 'customers',
                    'customer/guest': 'customers',
                    'Storemanagers/storeManagers': 'storeManagers',
                    'dispatchLogs/dispatchLogs': 'dispatchLogs',
                    'marketing/addNewPromoCode': 'offers',
                    'logs/promoLogs': 'offers',
                    'marketing/inputTripLogs': 'offers',
                    'marketing/addNewReferralCampaign': 'offers',
                    'marketing/addNewCampaign': 'offers',
                    'marketing/campaignsList': 'offers',
                    'marketing/couponCodeList': 'offers',
                    'marketing/referralCodeList': 'offers',
                    'marketing/campaignQualifiedTripLogs': 'offers',
                    'marketing/promoLogs': 'offers',
                    'marketing/claimsList': 'offers',
                    'marketing/unlockedList': 'offers',
                    'marketing/qualifiedTrips': 'offers',
                    'marketing/referralList': 'offers',
                    'marketing/refCodesByCampAndUserId': 'offers',
                    'marketing/referalQulTripLogs': 'offers',
                    'Colors/colors': 'colors',
                    'Taxes/tax': 'taxes',
                    'SizeGroups/sizegroup': 'sizegroup',
                    'Brands/brands': 'brands',
                    'AppWebPages/cterms': 'policyPages',
                    'AppWebPages/dterms': 'policyPages',
                    'AppWebPages/cprivacy': 'policyPages',
                    'AppWebPages/dprivacy': 'policyPages',
                    'AppWebPages/faq': 'policyPages',
                    'AppWebPages/refund': 'policyPages',
                    'AppWebPages/contactUs': 'policyPages',
                    'AppWebPages/aboutUs': 'policyPages',
                    'storeCommission/commission': 'storeCommission',
                    'utilities/cancell_reasons': 'can_reason',
                    'Parameters/parameters': 'parameters',
                    'Parameters/driverRatingNew': 'parameters',
                    'Parameters/customerReview': 'parameters',
                    'Parameters/orderReview': 'parameters',
                    'Zones/index': 'zones',
                    'Zones/create': 'zones',
                    'Zones/edit': 'zones',
                    'Uflyproducts/storeProducts': 'storeproducts'

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
                                    <li class="paymentgateway"><a  href="<?php echo base_url(); ?>index.php?/PaymentGateway"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" >PAYMENT GATEWAY</a></li>
                                    <li class="taxes"><a  href="<?php echo base_url(); ?>index.php?/taxController"><img class="menuIconClass"  src="<?php echo ServiceLink . 'pics/disputes_off.png' ?>" >TAX SETUP</a></li> 
                                    <li><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cities.png'; ?>" >CITY SETUP<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="city"><a  href="<?php echo base_url(); ?>index.php?/City"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cities.png' ?>" >CITIES</a></li>
                                            <li class="zones"><a href="<?php echo base_url(); ?>index.php?/Zones_Controller"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >ZONES</a></li>
                                        </ul>
                                    </li>

                                    <li><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/App-configuration.png'; ?>" >APP SETTINGS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="appConfig"><a  href="<?php echo base_url(); ?>index.php?/superadmin/app_config"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/App-configuration.png' ?>" >APP CONFIGURATION</a></li> 
                                            <li class="language"><a  href="<?php echo base_url(); ?>index.php?/Utilities/lan_help"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/language.png' ?>" >LANGUAGE</a></li>   
                                            <li class="appVersions"><a  href="<?php echo base_url(); ?>index.php?/appVersions/appVersions/21"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" >VERSIONS</a></li>    
                                        </ul>
                                    </li>

                                    <li><a><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/product.png" >PRODUCT SETUP<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="category"><a  href="<?php echo base_url(); ?>index.php?/Category"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/Category.png" >PRODUCT CATEGORIES</a></li>    
                                            <li class="colors"><a  href="<?php echo base_url(); ?>index.php?/colorsController"><img class="menuIconClass"  src="<?php echo base_url() ?>theme/icon/Category.png" > COLORS</a></li> 
                                            <li class="sizegroup"><a  href="<?php echo base_url(); ?>index.php?/sizeController"><img class="menuIconClass"  src="<?php echo base_url() ?>theme/icon/Category.png" > SIZE-GROUPS</a></li> 
                                            <li class="brands"><a  href="<?php echo base_url(); ?>index.php?/brandsController"><img class="menuIconClass"  src="<?php echo base_url() ?>theme/icon/Category.png" > BRANDS</a></li> 
                                            <li class="manufacturer"><a  href="<?php echo base_url(); ?>index.php?/Manufacturer_Controller"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/Category.png" >MANUFACTURER</a></li>    
                                        </ul>
                                    </li>

                                    <li><a><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/product.png" >PRODUCTS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="products"><a  href="<?php echo base_url(); ?>index.php?/AddNewProducts"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/product.png" >MAIN PRODUCTS</a></li>    
                                            <li class="storeproducts"><a  href="<?php echo base_url(); ?>index.php?/AddNewProducts/storeProducts"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/product.png" >STORE PRODUCTS</a></li>
                                        </ul>
                                    </li>

                                    <li><a><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/store.png" >STORE SETUP<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="storeCategory"><a  href="<?php echo base_url(); ?>index.php?/StoreCategoryController"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/Category.png" > STORE CATEGORIES</a></li>    
                                            <li class="store"><a  href="<?php echo base_url(); ?>index.php?/Business"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/store.png" > STORES</a></li>
                                            <li class="storeCommission"><a  href="<?php echo base_url(); ?>index.php?/storeCommission"><img class="menuIconClass"  src="<?php echo ServiceLink . 'pics/disputes_off.png' ?>" >STORE COMMISSION</a></li> 
                                            <li  class="storeManagers"><a  href="<?php echo base_url(); ?>index.php?/Storemanagers"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Drivers.png' ?>" >STORE MANAGERS</a></li>  
                                            <li  class="storeDrivers"><a  href="<?php echo base_url(); ?>index.php?/Storemanagers"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Drivers.png' ?>" >STORE DRIVERS</a></li>  
                                        </ul>
                                    </li>

                                    <li><a><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/Francies_location.png" >FRANCHISE SETUP<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="franchise"><a  href="<?php echo base_url(); ?>index.php?/Business"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/Francies_location.png" > FRANCHISE</a></li>
                                            <li class="storeCommission"><a  href="<?php echo base_url(); ?>index.php?/storeCommission"><img class="menuIconClass"  src="<?php echo base_url() ?>theme/icon/Francies_location.png" >FRANCHISE COMMISSION</a></li> 
                                        </ul>
                                    </li>

                                    <li><a href="<?php echo base_url(); ?>index.php?/Customer"><img src="<?php echo base_url() ?>theme/icon/passanger_on.png" alt="..." class="img-superadminIcon"><span class="titleSuperadmin">CUSTOMERS</span></a></li>

<!--                                    <li><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >CUSTOMERS<span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a href="<?php echo base_url(); ?>index.php?/Guest"><img src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" alt="..." class="img-superadminIcon"><span class="titleSuperadmin">GUEST</span></a></li>
    </ul>
</li>-->

                                    <li class="driverPlan"><a  href="<?php echo base_url(); ?>index.php?/superadmin/driverPlans"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver-Plans.png' ?>" >DRIVER PLANS</a></li>
                                    <li  class="driver"><a  href="<?php echo base_url(); ?>index.php?/superadmin/Drivers/my/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Drivers.png' ?>" >DRIVERS</a></li>  
                                    <li class="carts"><a  href="<?php echo base_url(); ?>index.php?/CartsController"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/store.png" > CARTS</a></li>    

                                    <li class="bookings"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >ORDERS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li  class="dispatchLogs"><a  href="<?php echo base_url(); ?>index.php?/DispatchLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Drivers.png' ?>" >DISPATCH</a></li> 
                                            <li class="unassignedBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/unassignedBookings"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancelled-Bookings.png' ?>" >UNASSIGNED</a></li> 
                                            <li class="onGoingBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/onGoing_jobs/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape ongoingbooking_off.png' ?>" >ON GOING</a></li> 
                                            <li class="completedBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/completed_jobs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/completedjobs_off.png' ?>" >COMPLETED</a></li> 
                                            <li class="cancelledBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/cancelledBookings"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancelled-Bookings.png' ?>" >CANCELLED</a></li> 
                                            <li class="expiredBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/expiredBookings"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancelled-Bookings.png' ?>" >EXPIRED</a></li> 

                                        </ul>
                                    </li>
                                    <li class="offers"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >OFFERS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                        </ul>
                                    </li>

                                    <li class="wallet"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >FINANCIALS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="accounting"><a  href="<?php echo base_url(); ?>index.php?/superadmin/accounting"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/accounting_off.png' ?>"> ACCOUNTING</a></li> 
                                            <li class=""><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >ACCOUNT STATEMENTS<span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">

                                                    <li class="master_wallet"><a  href="<?php echo base_url(); ?>index.php?/WalletController/wallet/1/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >DRIVER</a></li>
                                                    <li class="customer_wallet"><a  href="<?php echo base_url(); ?>index.php?/WalletController/wallet/2/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >CUSTOMER</a></li>
                                                    <li class="app_walletDetails"><a  href="<?php echo base_url(); ?>index.php?/WalletController/app_walletDetails"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >APP</a></li>
                                                    <li class="pg_walletDetails"><a  href="<?php echo base_url(); ?>index.php?/WalletController/pg_walletDetails"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >PAYMENT GATEWAY</a></li>
                                                </ul>
                                            </li>
                                            <li class="payroll"><a  href="<?php echo base_url(); ?>index.php?/superadmin/paymentCycle"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" >PAYROLL</a></li>
                                            <li class="stripePayoutLogs"><a  href="<?php echo base_url(); ?>index.php?/superadmin/paymentCycle"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" >STRIPE PAYOUT LOGS</a></li>
                                            <li class="stripeTaxLogs"><a  href="<?php echo base_url(); ?>index.php?/superadmin/paymentCycle"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" >STRIPE TXN LOGS</a></li>
                                            <!--<li class="paymentCycle"><a  href="<?php echo base_url(); ?>index.php?/superadmin/paymentCycle"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" >PAYMENT CYCLE</a></li>-->

                                        </ul>
                                    </li>

                                    <li class="offers"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicles.png'; ?>" >MARKETING<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li ><a  href="<?php echo base_url(); ?>index.php?/campaigns/index/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle types.png' ?>" >PROMO CAMPAIGNS</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/referralController/index/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicles.png' ?>" >REFERRAL CAMPAIGN</a></li> 
                                            <li><a  href="<?php echo base_url(); ?>index.php?/CouponCode/index/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle Models.png' ?>" >PROMO CODES</a> </li>
                                            <li class=""><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >LOGS<span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/logs/campaignQualifiedTripLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">CAMPAIGN QUALIFIED TRIP LOGS</a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/logs/promoLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">PROMO CODE CLAIM LOGS</a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/logs/inputTripLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">INPUT TRIP LOGS</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>  

                                    <li class="ratings"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png'; ?>" >RATINGS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="parameters"><a  href="<?php echo base_url(); ?>index.php?/parametersController"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" > PARAMETERS FOR CUSTOMERS</a></li>
                                            <li class="driverReview"><a  href="<?php echo base_url(); ?>index.php?/superadmin/driver_review/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" > DRIVER RATING</a></li>    
                                            <li class="customerReview"><a  href="<?php echo base_url(); ?>index.php?/parametersController/customer_review/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" > CUSTOMER RATING</a></li>    
                                            <li class="orderReview"><a  href="<?php echo base_url(); ?>index.php?/parametersController/order_review/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" > ORDER RATING</a></li>    
                                        </ul>
                                    </li>

                                    <li class="logs" ><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" class="">MAIL & SMS LOGS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/messages"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">SMS</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/email"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">EMAIL</a></li>
                                        </ul>
                                    </li>
                                    <li class="manageAccess"><a  href="<?php echo base_url(); ?>index.php?/superadmin/manageRole"><img class="menuIconClass"  src="<?php echo ServiceLink . 'pics/disputes_off.png' ?>" >ADMIN USERS</a></li> 

                                    <li ><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" class="">APP CONTENT<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="supportText"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >SUPPORT TEXT<span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/supportTextCustomer"><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >CUSTOMER</a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/supportTextDriver"><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >DRIVER</a></li>
                                                </ul>
                                            </li>
                                            <li class="can_reason">
                                                <a href="<?php echo base_url(); ?>index.php?/utilities/cancellation">
                                                    <img src="<?php echo ServiceLink . 'pics/disputes_off.png' ?>" alt="..." class="img-superadminIcon">
                                                    <span class="titleSuperadmin">CANCELLATION REASONS</span>
                                                </a>

                                            </li>
                                            <li class="terms">
                                                <a><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >Terms & Conditions<span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/policyController/terms/customer"><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >CUSTOMER</a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/policyController/terms/driver"><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >DRIVER</a></li>
                                                </ul>
                                            </li>

                                            <li class="Privacy">
                                                <a><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >Privacy Policy<span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/policyController/privacy/customer"><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >CUSTOMER</a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/policyController/privacy/driver"><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >DRIVER</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

<!--                                    <li class="promotions"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >PROMOTION<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a  href="<?php echo base_url(); ?>index.php?/coupons/refferal"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" >REFERRALS</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/coupons/promotion"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" >PROMO CODES</a></li>
                                            <li class="sendNotification"> <a  href="<?php echo base_url(); ?>index.php?/Sendnotification"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/completedjobs_off.png' ?>" > SEND NOTIFICATION</a></li>
                                        </ul>
                                    </li>-->

                                </ul>
                            </div>


                        </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->

                        <!-- /menu footer buttons -->
                    </div>
                </div>
