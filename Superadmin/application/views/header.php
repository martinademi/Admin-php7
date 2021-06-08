<?php require_once 'language.php'; ?>

<?php

$pgname = $pagename;

$acc_pageArr = array(
    'Dashboard' => 'dashboard',
    'cart/carts' => 'customer',
    'cart/cartsAction' => 'customer',
    'cart/cartDetails' => 'customer',
    'cart/cartInfo' => 'customer',
    'city/cities' => 'citySetup',
    'city/createCity1' => 'citySetup',
    'city/createCity' => 'citySetup',
    'city/editCity' => 'citySetup',
    'city/index' => 'citySetup',

    "vehicleSettings/vehicleTypes/index" => 'citySetup',
    "vehicleSettings/vehicleTypes/vehicleOrdering"=> 'citySetup',
    "vehicleSettings/vehicleTypes/edit" => 'citySetup',
    "vehicleSettings/vehicleTypes/add" => 'citySetup',
    "vehicleSettings/vehicleTypes/typeCityPrice" => 'citySetup',
    "vehicleSettings/vehicles/index" => 'citySetup',
    "vehicleSettings/vehicleModels/index"=> 'citySetup',
    "vehicleSettings/vehicles/add"=> 'citySetup',
    "vehicleSettings/vehicles/edit" => 'citySetup',
    'app_confi' => 'appSetting',
    'googleKey' => 'appSetting',
    'Manufacturer/manufacturer' => 'productSetup',
    'AppVersions/appVersions' => 'appSetting',
    'AppVersions/showAllUsersAppVersion' => 'appSetting',
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
    'operating_zone' => 'citySetup',
    'long_haul_zone' => 'citySetup',
    'longHaulDisabledPage' => 'citySetup',
    'zones_new' => 'citySetup',
    'zones_pricing' => 'citySetup',
    'vehicle_pricing' => 'citySetup',
    'long_haul_zonePricing' => 'citySetup',
    'shortHaulDisabledPage' => 'citySetup',
    'drivers' => 'driver',
    'drivers_1' => 'driver',
    'addnewdriver' => 'driver',
    'storeDrivers/storeDrivers' => 'driver',
    'storeDrivers/addNewStoreDriver' => 'driver',
    'storeDrivers/editStoreDriver' => 'driver',
    'getDriversForOperators' => 'driver',
    'editdriver' => 'driver',
    'Drivers/shiftLogs' => 'driver',
    'Drivers/shiftLogsStore' => 'driver',
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
    'Orders/index' => 'orders',
    'Ordertype/ordertype' => 'orders',
    'OrderItemtype/ordertype' => 'orders',
    'onGoing_jobs' => 'allBookings',
    'completed_jobs' => 'allBookings',
    'cancelledBookings' => 'allBookings',
    'unassignedBookings' => 'allBookings',
    'expiredBookings' => 'allBookings',
    'DriverAcceptanceRate' => 'driverAcceptanceRate',
    'dispatched' => 'centralDispatcher',
    'Manager/manager' => 'manager',
    'driverReferralTracker' => 'driverReferralTracker',
    'plans' => 'driver',
    'paymentCycle/paymentCycle' => 'wallet',
    'paymentCycle/paymentCycleDriversList' => 'wallet',
    'paymentGateway/index' => 'wallet',
    'accounting' => 'wallet',
    'stripeFeeds/stripeFeeds' => 'wallet',
    'wallet/master_wallet' => 'wallet',
    'wallet/master_walletDetails' => 'wallet',
    'wallet/customer_wallet' => 'wallet',
    'wallet/customer_walletDetails' => 'wallet',
    'wallet/app_walletDetails' => 'wallet',
    'wallet/pg_walletDetails' => 'wallet',
    'wallet/operator_walletDetails' => 'wallet',
    'wallet/operator_wallet' => 'wallet',
    'wallet/index' => 'wallet',
    'wallet/walletDetails' => 'wallet',
    'Coupons/refferal' => 'promotions',
    'Coupons/editrefferal' => 'promotions',
    'Coupons/createrefferal' => 'promotions',
    'Coupons/Promotions' => 'promotions',
    'Coupons/promotionshistory' => 'promotions',
    'Coupons/createpromotions' => 'promotions',
    'Coupons/createpromotionsForwallet' => 'promotions',
    'Coupons/editpromotions' => 'promotions',
    'Coupons/editpromotionsForwallet' => 'promotions',
    'utilities/cancell_reasonsCustomer' => 'appContent',
    'utilities/cancell_reasonsDriver' => 'appContent',
    'utilities/cancell_reasonsDispatcher' => 'appContent',
   // 'Notification/sendNotification' => 'sendNotification',
    'notification/index'=>'sendNotification',
    'driver_review' => 'driverReview',
    'driverRateForIndividual' => 'driverReview',
    'customerRateForIndividual' => 'driverReview',
    'driverRatingNew' => 'tripRating',
    'manageRole' => 'manageAccess',
    'utilities/hlp_language' => 'appContent',
    'utilities/supportTextCustomer' => 'appContent',
    'utilities/edit_support_text_Customer' => 'appContent',
    'utilities/Subcat_editCustomer' => 'appContent',
    'utilities/edit_support_text_Driver' => 'appContent',
    'utilities/Subcat_editDriver' => 'appContent',
    'utilities/add_support_catCustomer' => 'appContent',
    'utilities/supportTextDispatcher' => 'appContent',
    'utilities/supportTextDriver' => 'appContent',
    'utilities/add_support_catDriver' => 'appContent',
    'utilities/supportTextStore' => 'appContent',
    'utilities/add_support_catStore' =>'appContent',
    'utilities/supportTextCustomerSubCategory'=>'appContent',
    'utilities/edit_support_text_Store'=>'appContent',
    'utilities/supportTextStoreSubCategory'=>'appContent',
    'utilities/add_support_catSubCustomer'=>'appContent',
    'utilities/edit_support_text_Driver'=>'appContent',
    'utilities/supportTextDriverSubCategory'=>'appContent',
    'utilities/add_support_catSubDriver'=>'appContent',
    'utilities/Subcat_editStore'=>'appContent',
    'utilities/add_support_catSubStore'=>'appContent',
    'contactUs/index' => 'appContent',
    'aboutUs/index' => 'appContent',
    'Products/products' => 'products',
    'Products/product_details' => 'products',
    'Products/addNewProducts' => 'products',
    'Products/Products' => 'products',
    'Products/product_details' => 'products',
    'Products/AddNewProducts' => 'products',
    'Products/editProducts' => 'products',
    'Products/productDetails' => 'products',
    'Gridproducts/GridProductView'=>'products',
    'Gridproducts/editProducts'=>'products',
    'Gridproducts/viewProductsDetails'=>'products',
    'Category/category' => 'productSetup',
    'SubCategory/subcategory' => 'productSetup',
    'SubsubCategory/subsubcategory' => 'productSetup',
	'storeProductCategory/Category/category'=> 'productSetup',
    'storeProductCategory/SubCategory/subcategory'=> 'productSetup',
    'storeProductCategory/SubsubCategory/subsubcategory'=> 'productSetup',
    'franchiseProductCategory/Category/category'=> 'productSetup',
    'franchiseProductCategory/SubCategory/subcategory'=> 'productSetup',
    'franchiseProductCategory/SubsubCategory/subsubcategory'=> 'productSetup',
    'packageBox/index'=>'productSetup',

    'MetaTags/meta_tags' => 'productSetup',
    'Franchise/franchise' => 'franchiseSetup',
    'Franchise/addNewFranchise' => 'franchiseSetup',
    'Franchise/editFranchise' => 'franchiseSetup',
    'Franchise/commission' => 'franchiseSetup',
    'franchiseManager/franchiseManager' => 'franchiseSetup',
    'Business/business' => 'storeSetup',
    'Business/addNewStore' => 'storeSetup',
    'Business/addNewStorePos' => 'storeSetup',
    'Business/editbusiness' => 'storeSetup',
    'logs/message' => 'logs',
    'logs/email' => 'logs',
    'logs/inputTripLogs' => 'logs',
    'logs/campaignQualifiedTripLogs' => 'logs',
    'logs/promoCodeLogs' => 'logs',
    'logs/claimsLogs' => 'logs',
    'customer/profile' => 'customer',
    'customer/customer' => 'customer',
    'customer/guest' => 'customer',
    'Storemanagers/storeManagers' => 'storeSetup',
    'dispatchLogs/dispatchLogs' => 'orders',
    'camp/marketing/addNewPromoCode' => 'marketing',
    'camp/marketing/addNewReferralCampaign' => 'marketing',
    'camp/marketing/logs' => 'marketing',
    'camp/marketing/addNewCampaign' => 'marketing',
    'camp/marketing/campaignsList' => 'marketing',
    'camp/marketing/couponCodeList' => 'marketing',
    'camp/marketing/referralCodeList' => 'marketing',
    'camp/marketing/campaignQualifiedTripLogs' => 'marketing',
    'camp/marketing/inputTripLogs' => 'marketing',
    'camp/marketing/promoLogs' => 'marketing',
    'camp/marketing/claimsList' => 'marketing',
    'camp/marketing/unlockedList' => 'marketing',
    'camp/marketing/qualifiedTrips' => 'marketing',
    'camp/marketing/referralList' => 'marketing',
    'camp/marketing/editPromoCode'=>'marketing',
    'camp/marketing/refCodesByCampAndUserId' => 'marketing',
    'camp/marketing/referalQulTripLogs' => 'marketing',
    'camp/marketing/editNewCampaign'=> 'marketing',
    'camp/marketing/editReferalCampaign'=>'marketing',
    'camp/marketing/promoclaimlist'=>'marketing',
    'camp/logs/message'=>'marketing',
    'camp/logs/email'=>'marketing',
    'camp/logs/inputTripLogs'=>'marketing',
    'camp/logs/campaignQualifiedTripLogs'=>'marketing',
    'camp/logs/promoCodeLogs'=>'marketing',
    'Offers/productOffers' => 'offers',
    'Offers/addNewOffer' => 'offers',
    'Offers/editNewOffer' => 'offers',
    'Offers/ProductOffersredemtionview'=>'offers',
    'Colors/colors' => 'productSetup',
    'Shifts/shifts'=>'driver',
    'Taxes/tax' => 'taxes',
    'SizeGroups/sizegroup' => 'productSetup',
    'Brands/brands' => 'productSetup',
    'AppWebPages/cterms' => 'policyPages',
    'AppWebPages/dterms' => 'policyPages',
    'AppWebPages/sterms' => 'policyPages',
    'AppWebPages/cprivacy' => 'policyPages',
    'AppWebPages/dprivacy' => 'policyPages',
    'AppWebPages/sprivacy' => 'policyPages',
    'AppWebPages/faq' => 'policyPages',
    'AppWebPages/refund' => 'policyPages',
    'AppWebPages/contactUs' => 'policyPages',
    'AppWebPages/aboutUs' => 'policyPages',
    'AppWebPages/websiteTerms' => 'policyPages',
    'AppWebPages/storeTerms'=> 'policyPages',
    'AppWebPages/website_privacy' => 'policyPages',
    'AppWebPages/store_privacy' => 'policyPages',
    'storeCommission/commission' => 'storeSetup',
    'utilities/cancell_reasons' => 'appContent',            
    'Parameters/parameters' => 'ratings',
    'Parameters/driverRatingNew' => 'ratings',
    'Parameters/customerReview' => 'ratings',
    'Parameters/orderReview' => 'ratings',
    'Parameters/driverReview' => 'ratings',
     'Parameters/driverReviewDetails' => 'ratings',
     "Parameters/customerReviewDetails"=> 'ratings',
    'Parameters/orderReviewDetails' => 'ratings',
    'StoreCategories/Category' => 'storeSetup',
    'StoreCategories/subCategory' => 'storeSetup',
    'StoreCategories/attributes' => 'storeSetup',
    'StoreCategories/editAttributes' => 'storeSetup',
    'StoreCategories/attributesList' => 'storeSetup',
    'StoreCategories/addAttributes' => 'storeSetup',
    'Zones/index' => 'citySetup',
    'Zones/create' => 'citySetup',
    'Zones/edit' => 'citySetup',
    'Zones/setPrice' => 'citySetup',
    'Deliveryschduled/Deliveryschduled' => 'citySetup',
    'Deliveryschduled/Deliveryslot' => 'citySetup',
    'Deliveryschduled/bookedDetails' => 'citySetup',    
    'Deliveryslots/Deliveryschduled' => 'citySetup',
    'Deliveryslots/Deliveryslot' => 'citySetup',
    'Deliveryslots/bookedDetails' => 'citySetup',
    'Deliveryslotsdriver/Deliveryschduled' => 'citySetup',
    'Deliveryslotsdriver/Deliveryslot' => 'citySetup',
    'Deliveryslotsdriver/bookedDetails' => 'citySetup',
    'Ordercapacityslots/Deliveryschduled' => 'citySetup',
    'Ordercapacityslots/Deliveryslot' => 'citySetup',
    'Ordercapacityslots/bookedDetails' => 'citySetup',
    'Deliverydriver/Deliveryschduled' => 'citySetup',
    'Deliverydriver/Deliveryslot' => 'citySetup',
    'Deliverydriver/bookedDetails' => 'citySetup',
    'ShiftTimings/ShiftTimings' => 'citySetup',
    'Products/storeProducts' => 'storeproducts',
     'Offers/productOffers' => 'offers',
    'Offers/addNewOffer' => 'offers',
    'Offers/editNewOffer' => 'offers',
    'Offers/ProductOffersredemtionview'=>'offers',
    'Central/central' => 'central',
    'Central/addCentral' => 'central',
    'Central/editCentral' => 'central',
    'helpText/helpsupportTextCustomer'=>'helpText',
    'helpText/add_support_catCustomer'=>'helpText',
    'helpText/edit_support_text_Customer'=>'helpText',
    'helpText/supportTextDriver'=>'helpText',
    'helpText/add_support_catDriver'=>'helpText',
    'helpText/edit_support_text_Driver'=>'helpText',
    'helpText/supportTextStore'=>'helpText',
    'helpText/add_support_catStore'=>'helpText',
    'helpText/supportTextCustomerSubCategory'=>'helpText',
    'helpText/add_support_catSubCustomer'=>'helpText',
    'helpText/Subcat_editCustomer'=>'helpText',
    'helpText/supportTextDriverSubCategory'=>'helpText',
    'helpText/add_support_catSubDriver'=>'helpText',
    'helpText/Subcat_editDriver'=>'helpText',
    'helpText/Subcat_editStore'=>'helpText',
    'cancellation/cancellationReasons'=>'helpText',
    'helpText/supportTextStoreSubCategory'=>'helpText',
    'helpText/add_support_catSubStore'=>'helpText',
    'helpText/edit_support_text_Store'=>'helpText',
    'estimate/estimateList'=>'estimate',
    'driveracceptance/driverAcceptanceList'=>'allBookings',
    'driveracceptance/bookings'=>'allBookings',
    'AddOns/addons'=>'productSetup',
    'Users/Users'=>'Users',
    'marketing/voucher'=>'marketing',
    'marketing/particularVoucher'=>'marketing',
    'marketing/redeemVoucher'=>'marketing',
    'payoff/index'=>'payoff',
    'payoff/details'=>'payoff',
    'payoff/userDetails'=>'payoff',
    'PackagingPlan/index'=>'PackagingPlan',
    'PricingPlan/index'=>'PackagingPlan',
    'Symptoms/symptom' => 'productSetup',
    'statusReason/cancell_reasons'=>'helpText',
    'DriverRoaster/index' => 'driver',
    'DriverRoasterAdd/index' => 'driver',
    
);
$role = $this->session->userdata("role");
$access_right = $this->session->userdata("access_rights");
$main_admin_check = $this->session->userdata("mainAdmin");


$access_right['access_denied'] = 111;
$access_right['store'] = 111;  //not defined
$access_right['can_reason'] = 111;   //not defined
$access_right['sendNotification'] = 111;
$access_right['allBookings'] = 111;
$access_right['payoff'] = 111;
$access_right['PackagingPlan'] = 111;



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
        <link rel="shortcut icon" href="<?php echo base_url(); ?>theme/icon/favicon.png" />
        
        <title><?php echo Appname; ?></title>
       
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
        <!-- <script src="<?php echo base_url(); ?>theme/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script> -->
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
        <link href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/bootstrap-timepicker.min.css" rel="stylesheet">
        <!-- <link href="<?php echo base_url(); ?>RylandInsurence/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet"> -->

        <!-- dataTabe -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/datatable/dataTables/css/dataTables.bootstrap.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/datatable/dataTables/css/dataTables.bootstrap.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/datatable/buttons/css/buttons.bootstrap.css'); ?>"/>
        <link href="<?php echo base_url(); ?>build/css/adminAllStyles.css" rel="stylesheet">

        <script>
            $(document).ready(function () {
                var access_right_pg = '<?= $access_right_pg ?>';
                var access_right = JSON.parse('<?= json_encode($access_right) ?>');
                var main_admin_check = '<?= $main_admin_check ?>';
                var acc_pageArr = JSON.parse('<?= json_encode($acc_pageArr) ?>');
                var headerArr = {
                    'Dashboard': 'dashboard',
                    'cart/carts': 'customer',
                    'cart/cartsAction': 'customer',
                    'cart/cartDetails': 'customer',
                    'cart/cartInfo': 'customer',
                    'city/cities': 'citySetup',
                    'city/createCity1': 'citySetup',
                    'city/createCity': 'citySetup',
                    'city/editCity': 'citySetup',
                    'city/index': 'citySetup',

                    "vehicleSettings/vehicleTypes/index" : 'citySetup',
                    "vehicleSettings/vehicleTypes/vehicleOrdering": 'citySetup',
                    "vehicleSettings/vehicleTypes/edit" : 'citySetup',
                    "vehicleSettings/vehicleTypes/add" : 'citySetup',
                    "vehicleSettings/vehicleTypes/typeCityPrice" : 'citySetup',
                    "vehicleSettings/vehicles/index" : 'citySetup',
                    "vehicleSettings/vehicleModels/index": 'citySetup',
                    "vehicleSettings/vehicles/add": 'citySetup',
                    "vehicleSettings/vehicles/edit" : 'citySetup',
                    'ShiftTimings/ShiftTimings' : 'citySetup',

                    'app_confi': 'appSetting',
                    'googleKey': 'appSetting',
                    'AppVersions/appVersions': 'appSetting',
                    'AppVersions/showAllUsersAppVersion': 'appSetting',
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
                    'operating_zone': 'citySetup',
                    'zones_pricing': 'citySetup',
                    'vehicle_pricing': 'citySetup',
                    'long_haul_zone': 'citySetup',
                    'long_haul_zonePricing': 'citySetup',
                    'shortHaulDisabledPage': 'citySetup',
                    'Manufacturer/manufacturer': 'productSetup',
                    'packageBox/index': 'productSetup',
                    'drivers': 'driver',
                    'drivers_1': 'driver',
                    'storeDrivers/storedrivers': 'driver',
                    'storeDrivers/addNewStoreDriver': 'driver',
                    'getDriversForOperators': 'driver',
                    'addnewdriver': 'driver',
                    'editdriver': 'driver',
                    'driverVerification': 'driverVerification',
                    'passengers': 'customer',
                    'customerVerification': 'customerVerification',
                    'bookings': 'allBookings',
					'Orders/index' :'orders',
                    'Ordertype/ordertype' : 'orders',
                    'OrderItemtype/ordertype' : 'orders',
                    'DriverRoaster/index' : 'driver',
                    'DriverRoasterAdd/index' : 'driver',
                    'trip_details': 'allBookings',
                    'estimateRequested': 'estimateRequested',
                    'onGoing_jobs': 'onGoingBookings',
                    'completed_jobs': 'completedBookings',
                    'cancelledBookings': 'cancelledBookings',
                    'DriverAcceptanceRate': 'driverAcceptanceRate',
                    'dispatched': 'centralDispatcher',
                    'driverReferralTracker': 'driverReferralTracker',
                    'plans': 'driver',
                    'paymentCycle/paymentCycle': 'wallet',
                    'paymentGateway/index': 'paymentgateway',
                    'accounting': 'wallet',
                    'stripeFeeds/stripeFeeds': 'wallet',
                    'wallet/master_wallet': 'wallet',
                    'wallet/master_walletDetails': 'wallet',
                    'wallet/customer_wallet': 'wallet',
                    'wallet/customer_walletDetails': 'wallet',
                    'wallet/app_walletDetails': 'wallet',
                    'wallet/pg_walletDetails': 'wallet',
                    'wallet/operator_wallet': 'wallet',
                    'wallet/operator_walletDetails': 'wallet', 
                    'Coupons/refferal': 'promotions',
                    'Coupons/editrefferal': 'promotions',
                    'StoreCategories/Category': 'storeSetup',
                    'StoreCategories/subCategory': 'storeSetup',
                    'StoreCategories/attributes': 'storeSetup',
                    'StoreCategories/attributesList': 'storeSetup',
                    'StoreCategories/addAttributes': 'storeSetup',
                    'StoreCategories/editAttributes': 'storeSetup',
                    'Coupons/createrefferal': 'promotions',
                    'Coupons/Promotions': 'promotions',
                    'Coupons/promotionshistory': 'promotions',
                    'Coupons/createpromotions': 'promotions',
                    'Coupons/createpromotionsForwallet': 'promotions',
                    'Coupons/editpromotions': 'promotions',
                    'Coupons/editpromotionsForwallet': 'promotions',
                    'utilities/cancell_reasonsCustomer': 'appContent',
                    'utilities/cancell_reasonsDriver': 'appContent',
                    'utilities/cancell_reasonsDispatcher': 'appContent',
                    //'Notification/sendNotification': 'sendNotification',
                    'notification/index': 'sendNotification',
                    'driver_review': 'driverReview',
                    'driverRateForIndividual': 'tripRating',
                    'customerRateForIndividual': 'tripRating',
                    'driverRatingNew': 'tripRating',
                    'manageRole': 'manageAccess',
                    'utilities/hlp_language': 'appContent',
                    'utilities/supportTextCustomer': 'appContent',
                    'utilities/add_support_catCustomer': 'appContent',
                    'utilities/supportTextDriver': 'appContent',
                    'utilities/add_support_catDriver': 'appContent',
                    'utilities/supportTextStore' : 'appContent',
                    'utilities/add_support_catStore' :'appContent',
                    'utilities/supportTextCustomerSubCategory':'appContent',
                    'utilities/edit_support_text_Store':'appContent',
                    'utilities/supportTextStoreSubCategory':'appContent',
                    'utilities/add_support_catSubCustomer':'appContent',
                    'utilities/edit_support_text_Driver':'appContent',
                    'utilities/supportTextDriverSubCategory':'appContent',
                    'utilities/add_support_catSubDriver':'appContent',
                    'utilities/Subcat_editStore':'appContent',
                    'utilities/add_support_catSubStore':'appContent',
                    'contactUs/index' : 'appContent',
                    'aboutUs/index' : 'appContent',
                    'Products/products': 'products',
                    'Products/Products': 'products',
                    'Products/product_details': 'products',
                    'Products/AddNewProducts': 'products',
                    'Products/EditProducts': 'products',
                    'Products/productDetails': 'products',
                    'Gridproducts/GridProductView':'products',
                    'Gridproducts/editProducts':'products',
                    'Gridproducts/viewProductsDetails':'products',
                    'Category/category': 'productSetup',
                    'SubCategory/subcategory': 'productSetup',
                    'SubsubCategory/subsubcategory': 'productSetup',
					'storeProductCategory/Category/category': 'productSetup',
                    'storeProductCategory/SubCategory/subcategory': 'productSetup',
                    'storeProductCategory/SubsubCategory/subsubcategory': 'productSetup',
                    'franchiseProductCategory/Category/category': 'productSetup',
                    'franchiseProductCategory/SubCategory/subcategory': 'productSetup',
                    'franchiseProductCategory/SubsubCategory/subsubcategory': 'productSetup',
                    'MetaTags/meta_tags': 'productSetup',
                    'Franchise/franchise': 'franchiseSetup',
                    'Franchise/addNewFranchise': 'franchiseSetup',
                    'Franchise/editFranchise': 'franchiseSetup',
                    'Franchise/commission': 'franchiseSetup',
                    'franchiseManager/franchiseManager': 'franchiseSetup',
                    'Business/business': 'storeSetup',
                    'Business/addNewStore': 'storeSetup',
                    'Business/editbusiness': 'storeSetup',
                    'logs/message': 'logs',
                    'logs/email': 'logs',
                    'customer/profile': 'customer',
                    'customer/customer': 'customer',
                    'customer/guest': 'customer',
                    'Storemanagers/storeManagers': 'storeSetup',
                    'dispatchLogs/dispatchLogs': 'orders',
                    'camp/marketing/addNewPromoCode': 'marketing',
                    'logs/promoLogs': 'marketing',
                    'camp/marketing/inputTripLogs': 'marketing',
                    'camp/marketing/addNewReferralCampaign': 'marketing',
                    'camp/marketing/addNewCampaign': 'marketing',
                    'camp/marketing/campaignsList': 'marketing',
                    'camp/marketing/couponCodeList': 'marketing',
                    'camp/marketing/referralCodeList': 'marketing',
                    'camp/marketing/campaignQualifiedTripLogs': 'marketing',
                    'camp/marketing/promoLogs': 'marketing',
                    'camp/marketing/claimsList': 'marketing',
                    'camp/marketing/unlockedList': 'marketing',
                    'camp/marketing/qualifiedTrips': 'marketing',
                    'camp/marketing/referralList': 'marketing',
                    'camp/marketing/editPromoCode':'marketing',
                    'camp/marketing/editNewCampaign':'marketing',
                    'camp/marketing/editReferalCampaign':'marketing',
                    'camp/marketing/promoclaimlist':'marketing',
                    'camp/logs/message':'marketing',
                    'camp/logs/email':'marketing',
                    'camp/logs/inputTripLogs':'marketing',
                    'camp/logs/campaignQualifiedTripLogs':'marketing',
                    'camp/logs/promoCodeLogs':'marketing',
					'Offers/productOffers' : 'offers',
                    'Offers/addNewOffer' : 'offers',
                    'Offers/editNewOffer':'offers',
                    'Offers/ProductOffersredemtionview':'offers',
                    'logs/inputTripLogs': 'logs',
                    'logs/campaignQualifiedTripLogs': 'logs',
                    'logs/promoCodeLogs': 'logs',
                    'logs/claimsLogs' : 'logs',
                    'marketing/refCodesByCampAndUserId': 'marketing',
                    'marketing/referalQulTripLogs': 'marketing',
                    'Colors/colors': 'productSetup',
                    'Shifts/shifts':'driver',
                    'Taxes/tax': 'taxes',
                    'SizeGroups/sizegroup': 'productSetup',
                    'Brands/brands': 'productSetup',
                    'AppWebPages/cterms': 'policyPages',
                    'AppWebPages/dterms': 'policyPages',
                    'AppWebPages/sterms': 'policyPages',
                    'AppWebPages/cprivacy': 'policyPages',
                    'AppWebPages/dprivacy': 'policyPages',
                    'AppWebPages/sprivacy' : 'policyPages',
                   'AppWebPages/faq': 'policyPages',
                    'AppWebPages/refund': 'policyPages',
                    'AppWebPages/contactUs': 'policyPages',
                    'AppWebPages/aboutUs': 'policyPages', 
                    'AppWebPages/websiteTerms' : 'policyPages',
                    'AppWebPages/storeTerms' : 'policyPages',
                    'AppWebPages/website_privacy' : 'policyPages',        
                    'AppWebPages/store_privacy' : 'policyPages',          
                    'storeCommission/commission': 'storeSetup',
                    'utilities/cancell_reasons': 'appContent',
                    'Parameters/parameters': 'ratings',
                    'Parameters/driverRatingNew': 'ratings',
                    'Parameters/customerReview': 'ratings',
                    'Parameters/orderReview': 'ratings',
                    'Parameters/driverReview': 'ratings',
					'parameters/driverReviewDetails': 'ratings',
                    "Parameters/customerReviewDetails": 'ratings',
                    'Parameters/orderReviewDetails': 'ratings',
                    'Zones/index': 'zones',
                    'Zones/create': 'zones',
                    'Zones/edit': 'zones',
                    'Products/storeProducts': 'storeproducts',
                    'Offers/productOffers' : 'offers',
                    'Offers/addNewOffer' : 'offers',
                    'Offers/editNewOffer':'offers',
                    'Offers/ProductOffersredemtionview':'offers',
                    'Central/central' : 'central',
                    'Central/addCentral' : 'central',
                    'Central/editCentral' : 'central',
                    'helpText/helpsupportTextCustomer':'helpText',
                    'helpText/add_support_catCustomer':'helpText',
                    'helpText/edit_support_text_Customer':'helpText',
                    'helpText/supportTextDriver':'helpText',
                    'helpText/add_support_catDriver':'helpText',
                    'helpText/edit_support_text_Driver':'helpText',
                    'helpText/supportTextStore':'helpText',
                    'helpText/add_support_catStore':'helpText',
                    'helpText/supportTextCustomerSubCategory':'helpText',
                    'helpText/add_support_catSubCustomer':'helpText',
                    'helpText/Subcat_editCustomer':'helpText',
                    'helpText/supportTextDriverSubCategory':'helpText',
                    'helpText/add_support_catSubDriver':'helpText',
                    'cancellation/cancellationReasons':'helpText',
                    'helpText/Subcat_editDriver':'helpText',
                    'helpText/Subcat_editStore':'helpText',
                    'helpText/supportTextStoreSubCategory':'helpText',
                    'helpText/add_support_catSubStore':'helpText',
                    'helpText/edit_support_text_Store':'helpText',
                    'estimate/estimateList':'estimate',
                    'driveracceptance/driverAcceptanceList':'allBookings',
                    'AddOns/addons':'productSetup',
                    'Users/Users':'Users',
                    'marketing/voucher':'marketing',
                    'marketing/particularVoucher':'marketing',
                    'marketing/redeemVoucher':'marketing',
                    'payoff/index':'payoff',
                    'payoff/details':'payoff',
                    'payoff/userDetails':'payoff',
                    'PackagingPlan/index':'PackagingPlan',
                    'PricingPlan/index':'PackagingPlan',
                    'Zones/setPrice' : 'zones',
                    'Symptoms/symptom' : 'productSetup',
                    'statusReason/cancell_reasons':'helpText'


                };
                var pgname = '<?= $pagename ?>';
                var baseUrl = '<?php echo base_url() ?>';
                /*
                 * .cls100 = view
                 * .cls110 = add
                 * .cls111 = edit and delete
                 */
                $.each(access_right, function (key, response) {
                    if (response == "000") {
                        $('.menuPageName_' + key).remove();
                    }
                })

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
            /* .center {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 50%;
            } */
            p{
                text-align: center;
            }
            @media (max-width: 991px){}
                .nav-md .container.body .main_container .col-md-3.left_col {
                    /* display: inline-block; */
                }
            }
        </style>

    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">

                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view leftSideMenu">
                        <div class="navbar nav_title" style="border: 0;">
							<p><img class="center" src="<?php echo base_url() . 'theme/icon/delivxlogoflexy.png' ?>" style="width:174px;height:66px;margin-top: 15px;" ></p>
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <!-- <div class="profile">
                            <div class="profile_pic">
                                <img src="<?php echo base_url() . '../../pics/user.jpg' ?>" alt="..." class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Welcome <?php echo $this->session->userdata('first_name'); ?></span>
                                <h5 style="color:mediumaquamarine">

                                    <span class="green"><?php echo $this->session->userdata('role'); ?></span>
                                </h5>
                            </div>
                        </div> -->

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side main_menu" style="margin-top:25px">
                            <div class="menu_section">
                                <h3 style="display: -webkit-box;"></h3>
                                <ul class="nav side-menu leftSideMenu">
								
                                    <li class="dashboard"><a  href="<?php echo base_url(); ?>index.php?/superadmin/Dashboard"><img class="menuIconClass" src="<?php echo ServiceLink . '/pics/Dashboard.png' ?>" ><?php echo $this->lang->line('dashboard'); ?></a></li>
                                    <li class="menuPageName_paymentgateway"><a  href="<?php echo base_url(); ?>index.php?/PaymentGateway"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" ><?php echo $this->lang->line('paymentgateway'); ?></a></li>
                                    <li class="menuPageName_taxes"><a  href="<?php echo base_url(); ?>index.php?/taxController"><img class="menuIconClass" style="width:15px;" src="<?php echo base_url(); ?>theme/grocerIcons/Payout logs.png" ><?php echo $this->lang->line('taxsetup'); ?></a></li>
                                    
                                    

                                    <li class="menuPageName_citySetup" ><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cities.png'; ?>" ><?php echo $this->lang->line('citysetup'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="city"><a  href="<?php echo base_url(); ?>index.php?/City"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cities.png' ?>" ><?php echo $this->lang->line('cities'); ?></a></li>
                                            <li class="zones"><a href="<?php echo base_url(); ?>index.php?/Zones_Controller"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" ><?php echo $this->lang->line('zones'); ?></a></li>
                                            <!-- <li class="packagingplan"><a href="<?php echo base_url(); ?>index.php?/Packaging_Controller"><img style="width:20px" class="menuIconClass" src="<?php echo ServiceLink . 'theme/grocerIcons/list.png'; ?>" >PACKAGING PLAN</a></li> -->
                                        </ul>
                                    </li>

                                    <!-- <li class="menuPageName_driver"><a  href="<?php echo base_url(); ?>index.php?/ShiftsController"><img class="menuIconClass" style="width:15px;" src="<?php echo base_url(); ?>theme/grocerIcons/Orders.png" ><?php echo 'SHIFTS'; ?></a></li>
                                    <li class="menuPageName_driver"><a  href="<?php echo base_url(); ?>index.php?/DriverRoaster"><img class="menuIconClass" style="width:15px;" src="<?php echo base_url(); ?>theme/grocerIcons/Driver.png" ><?php echo 'DRIVER ROSTER'; ?></a></li> -->

                                    <li class="menuPageName_vehicles" style="display:none"><a><img style="width:20px;" class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/Driver plans.png" ><?= strtoupper($this->lang->line('vehicles')); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li ><a  href="<?php echo base_url(); ?>index.php?/vehicle/vehicle_type"><?= strtoupper($this->lang->line('vehicle_types')); ?></a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/vehicle/Vehicles/1"><?= strtoupper($this->lang->line('vehicles')); ?></a></li> 
                                            <li><a  href="<?php echo base_url(); ?>index.php?/vehicle/vehicle_models/1"><?= strtoupper($this->lang->line('vehiclesmodels')); ?></a> </li>                                       
                                        </ul>
                                    </li>

                                   <!-- USER -->
                                     <!-- <li class="menuPageName_Users"><a><img class="menuIconClass" style="width:15px;" src="<?php echo base_url(); ?>/theme/grocerIcons/customer.png" ><?php echo $this->lang->line('AUTHORISED_USERS'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">  
                                         <li class="Users"><a  href="<?php echo base_url(); ?>index.php?/Users"><?php echo $this->lang->line('ALL_USERS'); ?></a></li>                                       
                                        </ul>
                                    </li> -->

                                    <li class="menuPageName_Users"><a  href="<?php echo base_url(); ?>index.php?/Users"><img class="menuIconClass"  style="width:15px;" src="<?php echo base_url(); ?>/theme/grocerIcons/customer.png"?><?php echo $this->lang->line('ALL_USERS'); ?></a></li>

                                    <li class="menuPageName_appSetting"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/App-configuration.png'; ?>" ><?php echo $this->lang->line('appsetting'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="appConfig"><a  href="<?php echo base_url(); ?>index.php?/superadmin/app_config"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/App-configuration.png' ?>" ><?php echo $this->lang->line('appconfiguration'); ?></a></li>
                                            <li class="language"><a  href="<?php echo base_url(); ?>index.php?/Utilities/lan_help"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/language.png' ?>" ><?php echo $this->lang->line('language'); ?></a></li>
                                            <li class="appVersions"><a  href="<?php echo base_url(); ?>index.php?/appVersions/appVersions/21"><img style="width:20px" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Versions.png" ><?php echo $this->lang->line('versions'); ?></a></li>
                                        </ul>
                                    </li>

                                    
                                       
                                    <li class="menuPageName_productSetup"><a><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/product.png" ><?php echo $this->lang->line('productsetup'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="category"><a  href="<?php echo base_url(); ?>index.php?/Category"><img style="width:20px" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/list.png" ><?php echo $this->lang->line('productcategories'); ?></a></li>
											<li class="category"><a  href="<?php echo base_url(); ?>index.php?/ProductCategory"><img style="width:20px" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/list.png" ><?php echo $this->lang->line('storeproductcategories'); ?></a></li>
                                            <li class="franchisecategory"><a  href="<?php echo base_url(); ?>index.php?/FranchiseCategory"><img style="width:20px" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/list.png" ><?php echo $this->lang->line('franchiseproductcategories'); ?></a></li>
                                            <li class="colors" ><a  href="<?php echo base_url(); ?>index.php?/colorsController"><img style="width:20px" class="menuIconClass"  src="<?php echo base_url() ?>theme/grocerIcons/Color.png" > <?php echo $this->lang->line('colors'); ?></a></li>
                                            <li class="sizegroup" ><a  href="<?php echo base_url(); ?>index.php?/sizeController"><img style="width:20px" class="menuIconClass"  src="<?php echo base_url() ?>theme/grocerIcons/Size.png" > <?php echo $this->lang->line('sizegroups'); ?></a></li>
                                            <li class="brands" ><a  href="<?php echo base_url(); ?>index.php?/brandsController"><img style="width:20px" class="menuIconClass"  src="<?php echo base_url() ?>theme/grocerIcons/Brands.png" > <?php echo $this->lang->line('brands'); ?></a></li>
                                            <li class="manufacturer" ><a  href="<?php echo base_url(); ?>index.php?/Manufacturer_Controller"><img style="width:20px" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Manufacturer.png" ><?php echo $this->lang->line('manufacturer'); ?></a></li>
                                            <li class="manufacturer" ><a  href="<?php echo base_url(); ?>index.php?/symptomController"><img style="width:20px" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Orders.png" ><?php echo $this->lang->line('SYMPTOM'); ?></a></li>
                                           <!--  <li class="packagebox" ><a  href="<?php echo base_url(); ?>index.php?/packageBox"><img style="width:20px" class="menuIconClass"  src="<?php echo base_url() ?>theme/grocerIcons/Size.png" > <?php echo $this->lang->line('packagebox'); ?></a></li> -->
                                            <li><a><img class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Manufacturer.png" >ADD-ON's GROUP<span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li class="central"><a  href="<?php echo base_url(); ?>index.php?/centralController"><img style="width:20px" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Manufacturer.png" ><?php echo $this->lang->line('centraladdon'); ?></a></li>
                                                <li class="central"><a  href="<?php echo base_url(); ?>index.php?/StoreAddons"><img style="width:20px" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Manufacturer.png" ><?php echo $this->lang->line('storeaddon'); ?></a></li>
                                            </ul>
                                            
                                            </li>
                                            
                                        </ul>
                                    </li>

                                   
                                    <li class="menuPageName_products"><a><img class="menuIconClass" style="width:20px" src="<?php echo base_url() ?>theme/grocerIcons/Products.png" ><?php echo $this->lang->line('products'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="products"><a  href="<?php echo base_url(); ?>index.php?/AddNewProducts"><img style="width:20px" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Main products.png" ><?php echo $this->lang->line('centralproducts'); ?></a></li>
                                            <li class="storeproducts"><a  href="<?php echo base_url(); ?>index.php?/AddNewProducts/storeProducts"><img style="width:20px" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Store products.png" ><?php echo $this->lang->line('storeproducts'); ?></a></li>
                                            <!-- <li class="storeproducts"><a  href="<?php echo base_url(); ?>index.php?/GridProduct_controller"><img style="width:20px" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Store products.png" ><?php echo $this->lang->line('gridproducts'); ?></a></li> -->
                                        </ul>
                                    </li>

                                     <li class="menuPageName_storeSetup"><a><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/store.png" ><?php echo $this->lang->line('storesetup'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="storeCategorymenu"><a  href="<?php echo base_url(); ?>index.php?/StoreCategoryController"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/Category.png" > <?php echo $this->lang->line('storecategories'); ?></a></li>
                                            <li class="store"><a  href="<?php echo base_url(); ?>index.php?/Business"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/store.png" > <?php echo $this->lang->line('stores'); ?></a></li>
                                            <li class="storeCommission"><a  href="<?php echo base_url(); ?>index.php?/storeCommission"><img class="menuIconClass"  src="<?php echo ServiceLink . 'pics/disputes_off.png' ?>" ><?php echo $this->lang->line('storecommission'); ?></a></li>
                                            <li  class="storeManagers" style="display:none"><a  href="<?php echo base_url(); ?>index.php?/Storemanagers"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/manager.png" ><?php echo $this->lang->line('storemanager'); ?></a></li>
                                            <li  class="driver"><a  href="<?php echo base_url(); ?>index.php?/superadmin/storeDrivers/my/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Drivers.png' ?>" ><?php echo $this->lang->line('storedriver'); ?></a></li>
                                        </ul>
                                    </li>

                                 
                                    <li class="menuPageName_franchiseSetup"><a><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/Francies_location.png" > <?php echo $this->lang->line('franchisesetup'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="franchise"><a  href="<?php echo base_url(); ?>index.php?/Franchise"><img class="menuIconClass" src="<?php echo base_url() ?>theme/icon/Francies_location.png" > <?php echo $this->lang->line('franchise'); ?></a></li>
                                            <li class="franchiseCommission"><a  href="<?php echo base_url(); ?>index.php?/Franchise/franchiseCommission"><img class="menuIconClass"  src="<?php echo base_url() ?>theme/icon/Francies_location.png" > <?php echo $this->lang->line('franchisecommission'); ?></a></li>
                                           <li class="franchiseManager"><a  href="<?php echo base_url(); ?>index.php?/franchiseManager"><img class="menuIconClass"  src="<?php echo base_url() ?>theme/icon/manager.png" > <?php echo $this->lang->line('franchisemanager'); ?></a></li>
                                        </ul>
                                    </li>

                         
                                    <!-- <li class="menuPageName_customer"><a><img style="width:15px;" src="<?php echo base_url(); ?>/theme/grocerIcons/customer.png"  class="menuIconClass"><?php echo $this->lang->line('customers'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="<?php echo base_url(); ?>index.php?/Customer"><img style="width:15px;" src="<?php echo base_url(); ?>/theme/grocerIcons/customer.png"  class="menuIconClass"><?php echo $this->lang->line('customers'); ?></a></li>
                                            <li class="carts"><a  href="<?php echo base_url(); ?>index.php?/CartsController"><img style="width:18px;"class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/carts.png" > <?php echo $this->lang->line('carts'); ?></a></li>
                                        </ul>
                                    </li> -->

                                    <li class="menuPageName_estimate"><a href="<?php echo base_url(); ?>index.php?/Customer"><img style="width:18px;" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/customer.png"><?php echo $this->lang->line('customers'); ?></a></li>
                                    <li class="menuPageName_estimate"><a href="<?php echo base_url(); ?>index.php?/CartsController"><img style="width:18px;" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/carts.png"><?php echo $this->lang->line('carts'); ?></a></li>

                                         
                                      <li class="menuPageName_driver"><a><img style="width:20px;" class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/Driver plans.png" >DRIVER<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                        <li  class="driver"><a  href="<?php echo base_url(); ?>index.php?/superadmin/Drivers/my/1"><img style="width:15px;" class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/Driver.png" ><?php echo $this->lang->line('drivers'); ?></a></li>       
                                        <li class="driverPlan"><a  href="<?php echo base_url(); ?>index.php?/superadmin/driverPlans"><img style="width:20px;" class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/Driver plans.png" > <?php echo $this->lang->line('driverplans'); ?></a></li>
                                        <li  class="driver"><a  href="<?php echo base_url(); ?>index.php?/DriverAcceptanceController"><img style="width:15px;" class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/Driver.png" >  <?php echo $this->lang->line('driveracceptancerate'); ?></a></li>
                                        </ul>
                                    </li>                                  
                                  
                                    
                                   <li class="menuPageName_estimate"><a href="<?php echo base_url(); ?>index.php?/EstimateController"><img style="width:18px;" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Orders.png"><?php echo $this->lang->line('estimate'); ?></a></li>
                                   
                                   
                                   <!-- <li class="menuPageName_orders"><a href="<?php echo base_url(); ?>index.php?/OrderItemtypecontroller"><img style="width:18px;" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Orders.png"><?php echo "ITEM TYPE"; ?></a></li> -->
                                   <!-- <li class="menuPageName_orders"><a href="<?php echo base_url(); ?>index.php?/Ordertypecontroller"><img style="width:18px;" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Orders.png"><?php echo "ORDER TYPE"; ?></a></li> -->

                                   
                                   
                                        
                                   <li  class="dispatchLogs"><a  href="<?php echo base_url(); ?>index.php?/DispatchLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Drivers.png' ?>" ><?php echo $this->lang->line('dispatch'); ?></a></li>

                                    <li class="carts"><a  href="<?php echo base_url(); ?>index.php?/Orders"><img style="width:18px;"class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/Orders.png" > <?php echo $this->lang->line('allorders'); ?></a></li>

                                    <!-- <li class="menuPageName_orders"><a><img class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/Orders.png" style="width:20px;"><?php echo $this->lang->line('orders'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                           
                                        </ul>
                                    </li> -->
                                     
                                    <!-- <li class="menuPageName_offers"><a><img style="width:20px;" class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/Offers.png" ><?php echo $this->lang->line('offers'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
										<li class="product_offers">
                                       
                                        <a href="<?php echo base_url(); ?>index.php?/productOffers">
                                            <img src="<?php echo ServiceLink . 'pics/disputes_off.png' ?>" class="img-superadminIcon">
                                            <span class="titleSuperadmin">PRODUCT OFFERS</span>
                                        </a>

                                    </li>
                                        </ul>
                                    </li> -->

                                    <li class="menuPageName_orders"><a href="<?php echo base_url(); ?>index.php?/productOffers"><img style="width:18px;" class="menuIconClass" src="<?php echo base_url() ?>theme/grocerIcons/Offers.png"><?php echo "PRODUCT OFFERS"; ?></a></li>
                                     
                                    <li class="menuPageName_wallet"><a><img class="menuIconClass" style="width:15px;" src="<?php echo base_url(); ?>theme/grocerIcons/financial.png" ><?php echo $this->lang->line('financials'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="accounting"><a  href="<?php echo base_url(); ?>index.php?/superadmin/accounting"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/accounting_off.png' ?>"> <?php echo $this->lang->line('accounting'); ?></a></li>
                                            <li class=""><a style="font-size:11px;"><img class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/Account Statement.png" style="width:15px;"> <?php echo $this->lang->line('accountstatement'); ?><span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">

                                                    <li class="master_wallet"><a  href="<?php echo base_url(); ?>index.php?/wallet/user/driver"><?php echo $this->lang->line('driver'); ?> </a></li>
                                                    <li class="customer_wallet"><a  href="<?php echo base_url(); ?>index.php?/wallet/user/customer"> <?php echo $this->lang->line('customer'); ?></a></li>
                                                    <li class="store_wallet"><a  href="<?php echo base_url(); ?>index.php?/wallet/user/store"><?php echo $this->lang->line('store'); ?> </a></li>
                                                    <li class="app_walletDetails"><a  href="<?php echo base_url(); ?>index.php?/wallet/details/app"><?php echo $this->lang->line('app'); ?> </a></li>
                                                    <li class="pg_walletDetails"><a  href="<?php echo base_url(); ?>index.php?/wallet/details/pg"><?php echo $this->lang->line('pg'); ?> </a></li>

                                                </ul>
                                            </li>
                                            <!-- <li class="payroll"><a  href="<?php echo base_url(); ?>index.php?/superadmin/paymentCycle"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" >PAYROLL</a></li> -->
                                            <!-- <li class="payroll" style="display:none"><a  href="<?php echo base_url(); ?>index.php?/payoff"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" >PAYOFFL</a></li> -->
                                            
                                            <!-- <li class="stripePayoutLogs"><a  href="<?php echo base_url(); ?>index.php?/superadmin/paymentCycle"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" >STRIPE PAYOUT LOGS</a></li> -->
                                            <!-- <li class="stripeTaxLogs"><a  href="<?php echo base_url(); ?>index.php?/superadmin/paymentCycle"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" >STRIPE TXN LOGS</a></li> -->
                                            <li class="stripeTaxLogs"><a  href="<?php echo base_url(); ?>index.php?/Stripefeeds/index"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" ><?php echo $this->lang->line('STRIPE_LOGS'); ?></a></li>
                                            <li class="payoff" ><a  href="<?php echo base_url(); ?>index.php?/payoff"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" ><?php echo $this->lang->line('PAYOFF'); ?></a></li>
                                         
                                        </ul>
                                    </li>
            
                                  
                                    <li class="menuPageName_marketing"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicles.png'; ?>" ><?php echo $this->lang->line('marketing'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <!-- <li ><a  href="<?php echo base_url(); ?>index.php?/campaigns/index/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle types.png' ?>" > <?php echo $this->lang->line('loyaltyprogram'); ?></a></li> -->
                                            <!-- <li><a  href="<?php echo base_url(); ?>index.php?/referralController/index/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicles.png' ?>" > <?php echo $this->lang->line('referalcampaign'); ?></a></li> -->
                                            <li><a  href="<?php echo base_url(); ?>index.php?/CouponCode/index/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle Models.png' ?>" > <?php echo $this->lang->line('promocodes'); ?></a> </li>
                                            <li><a href="<?php echo base_url(); ?>index.php?/Sendnotification"><img style="width:15px;" src="<?php echo base_url(); ?>theme/grocerIcons/App content.png"  class="menuIconClass"> <?php echo $this->lang->line('sendnotification'); ?></a></li>
                                            <li class="offers"><a  href="<?php echo base_url(); ?>index.php?/logs/promoLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">  <?php echo $this->lang->line('promocodelogs'); ?></a></li>
                                            <li class="" style="display:none"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >LOGS<span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li class="offers"><a  href="<?php echo base_url(); ?>index.php?/logs/campaignQualifiedTripLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">   <?php echo $this->lang->line('campaignqualifiedtriplogs'); ?></a></li>
                                                    <li class="offers"><a  href="<?php echo base_url(); ?>index.php?/logs/promoLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">  <?php echo $this->lang->line('promocodelogs'); ?></a></li>
                                                    <li class="offers"><a  href="<?php echo base_url(); ?>index.php?/logs/inputTripLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">  <?php echo $this->lang->line('inputtriplogs'); ?></a></li>
                                                </ul>
                                            </li>
                                           <!--  <li><a  href="<?php echo base_url(); ?>index.php?/Voucher"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle Models.png' ?>" ><?php echo $this->lang->line('VOUCHERS'); ?></a> </li> -->
                                        </ul>
                                    </li>


									<li class="menuPageName_ratings"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png'; ?>" ><?php echo $this->lang->line('ratings'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="parameters"><a  href="<?php echo base_url(); ?>index.php?/parametersController"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" > <?php echo $this->lang->line('parameters'); ?></a></li>
                                            <li class="driverReview"><a  href="<?php echo base_url(); ?>index.php?/parametersController/driver_review/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" >  <?php echo $this->lang->line('driverrating'); ?></a></li>
                                            <li class="customerReview"><a  href="<?php echo base_url(); ?>index.php?/parametersController/customer_review/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" >  <?php echo $this->lang->line('customerrating'); ?></a></li>
                                            <li class="orderReview"><a  href="<?php echo base_url(); ?>index.php?/parametersController/order_review/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" >  <?php echo $this->lang->line('storerating'); ?></a></li>
                                        </ul>
                                    </li>
             
                                    <li class="menuPageName_logs" ><a><img class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/mail.png" style="width:20px;"class=""><?php echo $this->lang->line('mailsmslogs'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/messages"><img class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/sms.png" class="" style="width:20px;"><?php echo $this->lang->line('sms'); ?></a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/email"><img class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/email.png" style="width:20px;"class=""><?php echo $this->lang->line('email'); ?></a></li>
                                        </ul>
                                    </li>
                                  
                                    <li class="menuPageName_manageAccess"><a  href="<?php echo base_url(); ?>index.php?/superadmin/manageRole"><img style="width:15px;" class="menuIconClass"  src="<?php echo base_url(); ?>theme/grocerIcons/Admin users.png" ><?php echo $this->lang->line('MANAGE_ACCESS'); ?></a></li>
    <!-- cool -->
                                    <li class="menuPageName_appContent"  ><a><img class="menuIconClass" style="width:15px;"src="<?php echo base_url(); ?>theme/grocerIcons/App content.png" class=""><?php echo $this->lang->line('appcontent'); ?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
										
										
										<li class="supportText">
                                                <a><?php echo $this->lang->line('faq'); ?><span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/supportTextCustomer"><?php echo $this->lang->line('customer'); ?></a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/supportTextDriver"><?php echo $this->lang->line('driver'); ?></a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/supportTextStore"><?php echo $this->lang->line('store'); ?></a></li>
                                                </ul>
                                            </li>
                                            <li class="helpText">
                                                <a><?php echo $this->lang->line('helptext'); ?><span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a class="helpText"  href="<?php echo base_url(); ?>index.php?/helpText/helpTextCustomer"><?php echo $this->lang->line('customer'); ?></a></li>
                                                    <li><a class="helpText" href="<?php echo base_url(); ?>index.php?/helpText/helpTextDriver"><?php echo $this->lang->line('driver'); ?></a></li>
                                                    <li><a class="helpText" href="<?php echo base_url(); ?>index.php?/helpText/helpTextStore"><?php echo $this->lang->line('store'); ?></a></li>
                                                </ul>
                                            </li>
                                            <li class="helpText">
                                                <a><?php echo $this->lang->line('CANCELLATION'); ?> <br><?php echo $this->lang->line('reasons'); ?><span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                   
                                                            <li><a  href="<?php echo base_url(); ?>index.php?/Cancellation/cancellationReason/Customer/customer"><?php echo $this->lang->line('customer'); ?></a></li>
                                                            <li><a  href="<?php echo base_url(); ?>index.php?/Cancellation/cancellationReason/Driver/driver"><?php echo $this->lang->line('driver'); ?></a></li>
                                                            <li><a  href="<?php echo base_url(); ?>index.php?/Cancellation/cancellationReason/Store/manager"><?php echo $this->lang->line('store'); ?></a></li>
                                                </ul>
                                            </li>

                                            <li class="contactUs">
                                                <a href="<?php echo base_url(); ?>index.php?/ContactUsCity">CONTACT US</span>
                                                </a>

                                            </li>
                                            <li class="aboutUs">
                                                <a href="<?php echo base_url(); ?>index.php?/WebsitePages/aboutUs">ABOUT US</span>
                                                </a>

                                            </li>

                                            <li class="menuPageName_manageAccess"><a  href="<?php echo base_url(); ?>index.php?/StatusReason/cancellation"><?php echo $this->lang->line('statusReason'); ?></a></li>
										
										
                                            <li class="terms">
                                                <a><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" ><?php echo $this->lang->line('termsandcondition'); ?><span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/policyController/terms/customer"><img style="width:15px;" src="<?php echo base_url(); ?>/theme/grocerIcons/customer.png"  class="menuIconClass"><?php echo $this->lang->line('customer'); ?></a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/policyController/terms/driver"><img style="width:15px;" class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/Driver.png" ><?php echo $this->lang->line('driver'); ?></a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/policyController/terms/store"><img style="width:15px;" class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/store.png" ><?php echo $this->lang->line('store'); ?></a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/policyController/terms/website">WEBSITE</a></li>
                                                </ul>
                                            </li>

                                            <li class="Privacy">
                                                <a><img class="menuIconClass" style="width:15px;"src="<?php echo base_url(); ?>theme/grocerIcons/Privacy policy.png" ><?php echo $this->lang->line('privacypolicy'); ?><span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/policyController/privacy/customer"><img style="width:15px;" src="<?php echo base_url(); ?>/theme/grocerIcons/customer.png"  class="menuIconClass"><?php echo $this->lang->line('customer'); ?></a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/policyController/privacy/driver"><img style="width:15px;" class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/Driver.png" ><?php echo $this->lang->line('driver'); ?></a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/policyController/privacy/store"><img style="width:15px;" class="menuIconClass" src="<?php echo base_url(); ?>theme/grocerIcons/store.png" ><?php echo $this->lang->line('store'); ?></a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/policyController/privacy/website">WEBSITE</a></li>
                                                </ul>
                                            </li>
                                        </ul>

                                    </li>
									


                                  
          
                                </ul>
                            </div>


                        </div>
                      
                    </div>
                </div>
