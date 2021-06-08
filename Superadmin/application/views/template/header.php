<?php
//require_once '../Langauge/language.php'; 
//require_once __DIR__ . '../Langauge/language.php';
//require_once 'language.php';

$pgname = $pagename;

$acc_pageArr = array(
    'Dashboard/Dashboard' => 'dashboard',
//    'city/cities' => 'city',
//    'city/addnewcity' => 'city',
//    'Products/Products' => 'products',
//
////    'company/company_s' => 'company',
////    'company/company_edit' => 'company',
////    'company/company_add' => 'company',
//    
//    'ZonalPricing/ZonalPricing' => 'zones',
//    'MileagePricing/MileagePricing' => 'mileage',
//    
//    'Business/Business' => 'businesscat',
//    'Franchise/franchise' => 'franchise',
//    'Business/Business' => 'businessmgt',
//    
//    'company/passengers' => 'customer',
//    
//    'company/drivers' => 'driver',
//    'company/addnewdriver' => 'driver',
//    'company/editdriver' => 'driver',
//    
//    'company/bookings' => 'booking',
//    "company/OnGoingbookings" => 'OnGoingbookings',
//    "company/completedjobs" => 'completedjobs',
//    'company/Transection' => 'transection',
//    
//    'company/provisionen' => 'commission',
//    'company/compaigns' => 'compaign',
//    'company/driver_review' => 'driver_review',
//    
//     'Language/hlp_language'=> 'lang',
//     'utilities/helpText'=> 'helptext',
//     'utilities/add_help_cat'=> 'helptext',
//     'utilities/edit_help_cat'=> 'helptext',
//     'utilities/supportText'=> 'suptext',
//     'utilities/add_support_cat'=> 'suptext',
//     'utilities/edit_support_text'=> 'suptext',
//     'utilities/cancell_reasons'=> 'can_reason',
//    
//    'company/delete' => 'delete',
//    "company/notification" => 'notification',
//    'company/payroll' => 'payroll',
//    'company/operator' => 'operator',
//    
//    'company/ServiceCharge' => 'servicecharge',
//     
//    'company/convenienceFee' => 'ConvienienceFee',
//    
//   
//    'Coupons/referral_details' => 'campaigns',
//    'Coupons/promo_details' => 'campaigns',
//    
//    'company/Referral' => 'referrals',
//    
//    'godsview' => 'godsview',
// 
//  
//    'company/passenger_rating' => 'customer_rating',
//    'error_404' => 'access_denied'
);
$access_right = $this->session->userdata("access_rights");
$main_admin_check = $this->session->userdata("mainAdmin");
$access_right['access_denied'] = 111;
//$access_right_pg = $access_right[$acc_pageArr[$pagename]];
//if ($main_admin_check != true) {
//    if ($access_right_pg == 000) {
//        redirect(base_url() . 'index.php?/superadmin/access_denied');
//    }
//}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
 
        <title><?php echo APPNAME;?></title>

        <script src="<?php echo base_url(); ?>theme/assets/plugins/jquery/jquery-1.8.3.min.js" type="text/javascript"></script>


        <link href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/tebse.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>vendors/nprogress/nprogress.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>

        <link href="<?php echo base_url(); ?>vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

        <!--<script src="<?php echo base_url(); ?>theme/assets/plugins/jquery/jquery-1.8.3.min.js" type="text/javascript"></script>-->
        <link href="<?php echo base_url(); ?>theme/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" media="screen">


        <link href="<?php echo base_url(); ?>build/css/custom.min.css" rel="stylesheet">

        <style>
            .form-horizontal .control-label {
                text-align:left;
            }
            body{
                background : #2a4054 !important;
            }
            

            .breadcrumb>li+li:before {
                content:'>';
            }
            li .active {
                font-weight: 600;
                font-size: 11px;
                color: #0090d9;
            }
            .breadcrumb{
                font-size:11px;
            }

            .table>tbody>tr>td {
                vertical-align: middle;
            }
            .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
                color: #fff;
                background-color: slategrey;
            }
            .error-box{
                color: dodgerblue;
            }
            .modal-title{
                color: #0090d9;
            }
            body{
                font-size: 10px;
            }
            .lastButton{
                margin-right:1%;
            }
            .form-control {
                border-radius: 10;
            }
            ul.nav.side-menu img.img-superadminIcon {
                margin:0px 15px 5px 10px;
                /*width: 20px;*/
            }
            ul.nav.side-menu li>a {
                padding: 10px 10px;
            }
            .main_menu_side ul.nav.side-menu {
                margin-top: 20px;
            }
            ul.nav.side-menu .titleSuperadmin{
                font-size:12px;
            }
            .dataTables_paginate{
                cursor: pointer;
            }

            .style_prevu_kit
            {
                display:inline-block;
                border:0;

                position: relative;
                -webkit-transition: all 200ms ease-in;
                -webkit-transform: scale(1); 
                -ms-transition: all 200ms ease-in;
                -ms-transform: scale(1); 
                -moz-transition: all 200ms ease-in;
                -moz-transform: scale(1);
                transition: all 200ms ease-in;
                /*transform: scale(1.7);*/   

            }
            .style_prevu_kit:hover
            {

                /*        box-shadow: 0px 0px 150px #000000;*/
                z-index: 1;
                -webkit-transition: all 200ms ease-in;
                -webkit-transform: scale(1.7);
                -ms-transition: all 200ms ease-in;
                -ms-transform: scale(1.5);   
                -moz-transition: all 200ms ease-in;
                -moz-transform: scale(1.5);
                transition: all 200ms ease-in;
                transform: scale(1.7);
            }

            .Filters{
                background-color:gainsboro;
                height:30px;
                font-size:12px;
            }

            /*        #big_table_wrapper{
                        display: none;
                    }*/

            .leftSideMenu {
                height: 99vh;
                position: fixed;
                width:245px;
            }

            .leftSideMenu::-webkit-scrollbar-track
            {
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                background-color: #2A3F54;
            }

            .leftSideMenu::-webkit-scrollbar
            { 
                width: 6px; background-color: #2A3F54;
            }
            .leftSideMenu::-webkit-scrollbar-thumb
            { 
                background-color: #71a489;
            }
            .dataTables_paginate{
                cursor:pointer;
            }
            .container-fluid.container-fixed-lg.sm-p-l-20.sm-p-r-20 {
                margin-left: 0%;
                margin-right: 0%;
            }
            .form-horizontal .control-label {
                text-align:left;
            }

            #big_table_paginate{
                margin-right: 1%;
            }
            .breadcrumb>li+li:before {
                content:'>';
            }


            .responseHTML{
                font-size:10px;
                color:#0090d9;
            }
            textarea{
                max-width:258px;
            }
            .brand{
                font-size:12px;
                color:#0090d9;
            }
            li .active {
                font-weight: 600;
                font-size: 11px;
                color: #0090d9;
            }
            .breadcrumb{
                font-size:12px;
                background: white;
                font-weight:600;
                padding: 1%;
            }
            .row-same-height{
                margin-top: 1%;
            }
            .error-box{
                color: dodgerblue;
            }

            .errors{
                color:red;
            }
            .form-horizontal .form-group {

                margin-left: 13px;
            }

            .table>tbody>tr>td {
                vertical-align: middle;
            }
            .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
                color: #fff;
                background-color: slategrey;
            }

            .modal-title{
                color: #0090d9;
                font-size: 12px;
                font-weight: 600;

            }
            /*       .nav.side-menu>li {
                        height:45px;
                    }*/


            body{
                font-size: 11px;
            }
            .lastButton{
                margin-right:1%;
            }
            .form-control {
                border-radius: 10;
            }
            .btn{ 
                font-size: 11px;
                width:92px;
            }
            .btn btn-primary pull-right m-t-10 {
                font-size: 11px;
            }
            #errorboxdata,#errorboxdatas,#errorbox_accept,.error-box{font-size: 11px;
            }

            #search-table{
                height:28px;
                font-size: 11px;
            }
            .form-control {
                font-size: 11px;
            }        
            .modal-dialog {
                opacity: 1;
                visibility: visible;
                z-index: 100;
            }
            .top_nav .navbar-right {
                width:65%;
            }
            .MandatoryMarker{
                color:red;font-size: 12px
            }
            .input-sm {
                font-size: 10px;
            }
            li.tabs_active.active {
                border-bottom: 4px solid #f55753;
            }

            .table>thead>tr>th {

                vertical-align: middle;
            }
            .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
                font-weight: 600;

            }

            .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
                color: #555;
                cursor: default;
                background-color: #fff;
                border: 0px solid #ddd;
                border-bottom-color: transparent;
            }

            .no-margin{

                font-weight: 600;

            }
            .small, small {
                font-size: 100%;
                font-weight: 400;
                color:deepskyblue;

            }
            .fa {

                font-size:11px;;
            }
            .col-xs-height {
                display: table-cell;
                float: none;
            }
            .social-user-profile {
                width: 83px;
            }
            .col-top {
                vertical-align: top;
            }

            .panel-title {
                font-size: 11px;

            }

            .menuIconClass{
                margin-right: 5%;margin-bottom: 1%; 
            }


            .cs-loader {
                position: static;
                top: 0;
                left: 0;
                height: 65%;
                width: 100%;
            }

            .cs-loader-inner {
                transform: translateY(-50%);
                top: 80%;
                position: static;
                width: calc(110% - 200px);
                color: #FFF;
                /*  padding: 0 100px;*/
                text-align: center;
            }

            .cs-loader-inner label {
                font-size: 35px;
                opacity: 0;
                display:inline-block;
            }

            @keyframes lol {
                0% {
                    opacity: 0;
                    transform: translateX(-400px);
                }
                33% {
                    opacity: 1;
                    transform: translateX(0px);
                }
                66% {
                    opacity: 1;
                    transform: translateX(0px);
                }
                100% {
                    opacity: 0;
                    transform: translateX(400px);
                }
            }

            @-webkit-keyframes lol {
                0% {
                    opacity: 0;
                    -webkit-transform: translateX(-200px);
                }
                48% {
                    opacity: 1;
                    -webkit-transform: translateX(0px);
                }
                72% {
                    opacity: 1;
                    -webkit-transform: translateX(0px);
                }
                100% {
                    opacity: 0;
                    -webkit-transform: translateX(200px);
                }
            }



            .cs-loader-inner label:nth-child(5) {
                -webkit-animation: lol 3s 400ms infinite ease-in-out;
                animation: lol 2s 400ms infinite ease-in-out;
            }

            .cs-loader-inner label:nth-child(4) {
                -webkit-animation: lol 3s 500ms infinite ease-in-out;
                animation: lol 2s 500ms infinite ease-in-out;
            }

            .cs-loader-inner label:nth-child(3) {
                -webkit-animation: lol 3s 600ms infinite ease-in-out;
                animation: lol 2s 600ms infinite ease-in-out;
            }

            .cs-loader-inner label:nth-child(2) {
                -webkit-animation: lol 3s 700ms infinite ease-in-out;
                animation: lol 2s 700ms infinite ease-in-out;
            }

            .cs-loader-inner label:nth-child(1) {
                -webkit-animation: lol 3s 800ms infinite ease-in-out;
                animation: lol 2s 800ms infinite ease-in-out;
            }


            .form-horizontal .form-group
            {
                margin-left: 13px;
            }

            .Msg {
                animation: blinker 1s linear infinite;
            }

            @keyframes blinker {  
                50% { opacity: 0; }
            }
        </style>
        <script>
            $(document).ready(function () {

                $('#menubar').fadeToggle("fast");


//                
//                 var pgname = '<?= $pagename ?>';
//console.log(access_right_pg);
                var baseUrl = '<?php echo base_url() ?>';

                var headerArr = {
                    'Dashboard/Dashboard': '.dashboard',
                    'city/cities': '.cities',
                    'city/addnewcity': '.cities',
                    'Products/Products': '.products',
                    'ZonalPricing/ZonalPricing': '.zones',
                    'MileagePricing/MileagePricing': '.mileage',
//                    
//                    'company/business_cat' : '.businesscat',
//                    'company/franchise' : '.franchise',
                    'Business/Business': '.businessmgt',
//                    
//                    'company/passengers': '.passengers',
//                   
//                    'company/drivers': '.Drivers',
//                    'company/addnewdriver': '.Drivers',
//                    'company/editdriver': '.Drivers',
//                   
//                    'company/bookings': '.bookings',
//                    'company/OnGoingbookings' :'.ongoing',
//                    'company/completedjobs' :'.completed',
//                    'company/Transection': '.transection',
//                 
//                    'company/provisionen' : '.provisionen',
//                    'company/compaigns': '.compaigns',
//                    'company/driver_review' : '.driver_review',
//                    
//                    'company/delete': '.delete',
//                    'company/notification': '.notification',
//                      'company/payroll' : '.payroll',
//                      'company/operator' : '.operator',
//                        
//                    'company/ServiceCharge' :'.service',
//        
//                    'company/convenienceFee' : '.convenienceFee',
//                  
//                   
//                    'company/referral_details' : '.campaigns',
//                    'company/promo_details' : '.campaigns',
//    
//                    'company/Referral' : '.referral',
//                 
//                    'company/passenger_rating' : '.passenger_rating',
//                    'company/manageRole': '.manageRole',
//                    'godsview': '.godsview',
//                    'utilities/hlp_language': '.lang',
//                    'utilities/helpText': '.helptext',
//                    'utilities/add_help_cat': '.helptext',
//                    'utilities/edit_help_cat': '.helptext',
//                    'utilities/supportText': '.suptext',
//                    'utilities/add_support_cat': '.suptext',
//                    'utilities/edit_support_text': '.suptext',
//                    'utilities/cancell_reasons': '.can_reason'
                };

                $('#menubar').fadeIn('fast');

//                if (main_admin_check != true) {
//                    if (access_right_pg == 000) {
////                        base_url().'index.php?/superadmin/access_denied';
//                    } else if (access_right_pg == 100) {
//                        $('.cls110').remove();
//                        $('.cls111').remove();
//                    } else if (access_right_pg == 110) {
//                        $('.cls111').remove();
//                    } else if (access_right_pg == 111) {
//
//                    }
//                    $.each(acc_pageArr, function (ind, val) {
//                        var nav_pages = access_right[val];
//                        if (nav_pages == 000 || typeof nav_pages == 'undefined') {
//                            var pagecls = headerArr[ind];
//                            $(pagecls).remove();
//                        }
//                    });
//                }
            });
            // none, bounce, rotateplane, stretch, orbit, 
            // roundBounce, win8, win8_linear or ios
            // var current_effect = 'bounce'; // 


            function run_progress(effect) {
                $('.fixed-header').waitMe({
                    //none, rotateplane, stretch, orbit, roundBounce, win8, 
                    //win8_linear, ios, facebook, rotation, timer, pulse, 
                    //progressBar, bouncePulse or img
                    effect: effect,
                    //place text under the effect (string).
                    text: '',
                    //background for container (string).
                    bg: 'rgba(255,255,255,0.7)',
                    //color for background animation and text (string).
                    color: '#000',
                    //change width for elem animation (string).
                    sizeW: '',
                    //change height for elem animation (string).
                    sizeH: '',
                    // url to image
                    source: '',
                    // callback
                    onClose: function () {}

                });
            }
        </script>
        <script>
            $(document).ready(function () {
                var pgname = '<?= $pagename ?>';
                var headerArr = {
                    'utilities/hlp_language': '.lang',
                    'utilities/helpText': '.helptext',
                    'utilities/add_help_cat': '.helptext',
                    'utilities/edit_help_cat': '.helptext',
                    'utilities/supportText': '.suptext',
                    'utilities/add_support_cat': '.suptext',
                    'utilities/edit_support_text': '.suptext',
                    'utilities/cancell_reasons': '.can_reason'
                };
                var actcls = headerArr[pgname];
                if (typeof actcls !== "undefined") {
                    $(actcls).addClass('active');
                    var img = $(actcls + ' img').attr('src');

                    $(actcls + ' img').attr('src', img + 'on.png');
                }
            });
        </script>

    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="index.html" class="site_title">
                                <img src="<?php echo base_url(); ?>../pics/ufly.png" style="padding-left: 15px;margin-bottom: 20px">

                                <span><?php // echo APPNAME;?></span></a>
                        </div>

                        <div class="clearfix"></div>

                        <br />

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>Super Admin</h3>
                                <ul class="nav side-menu">
                                    <li class="dashboard">
                                        <a  href="<?php echo base_url(); ?>Dashboard">


                                            <img src="<?php echo base_url(); ?>../icons/dashboard.png" alt="..." class="img-superadminIcon">

                                            <span class="titleSuperadmin">DASHBOARD</span>
                                        </a>

                                    </li>
                                    <li class= "products">
                                        <a  href="<?php echo base_url(); ?>Products">
                                    <!--<i class="fa fa-building"></i>-->
                                            <img src="<?php echo base_url(); ?>../icons/product.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">PRODUCTS</span>
                                        </a>

                                    </li>



                                    <li class="zones"><a>
                                    <!--<i class="fa fa-edit"></i>-->
                                            <img src="<?php echo base_url(); ?>../icons/Pricing.png" alt="..." class="img-superadminIcon">                   
                                            <span class="titleSuperadmin">PRICING</span> 
                                            <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none;">
                                            <li><a  href="<?php echo base_url(); ?>Zonescontroller">
                                            <!--<i class="fa fa-building"></i>-->
                                                    <img src="<?php echo base_url(); ?>pics/zonal.png" alt="..." class="img-superadminIcon">
                                                    <span class="titleSuperadmin">ZONAL</span>
                                                </a>

                                            </li>
                                            <li class="mileage">
                                                <a href="<?php echo base_url(); ?>MileagePricing">
                                                    <img src="<?php echo base_url(); ?>pics/milage.png" alt="..." class="img-superadminIcon">
                                                    <span class="titleSuperadmin">MILEAGE</span>
                                                </a>

                                            </li>

                                        </ul>
                                    </li>
                                    <li class= "cities">
                                        <a  href="<?php echo base_url(); ?>City">
                                            <img src="<?php echo base_url(); ?>../icons/City.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">CITIES</span>
                                        </a>

                                    </li>
                                    <li class="businesscat">
                                        <a href="<?php echo base_url(); ?>Category">
                                            <img src="<?php echo base_url(); ?>../icons/Category.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">CATEGORY</span>
                                        </a>

                                    </li>
                                    <li class="franchise">
                                        <a href="<?php echo base_url(); ?>Franchise">
                                    <!--<i class="fa fa-table"></i>-->
                                            <img src="<?php echo base_url(); ?>../icons/Francies_location.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">FRANCHISE</span>
                                        </a>

                                    </li>
                                    <li class="businessmgt">
                                        <a href="<?php echo base_url(); ?>Business">
                                    <!--<i class="fa fa-table"></i>-->
                                            <img src="<?php echo base_url(); ?>../icons/store.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">STORES</span>
                                        </a>

                                    </li>
                                    <li class="passengers">
                                        <a href="<?php echo base_url(); ?>Customer">
                                    <!--<i class="fa fa-users"></i>-->
                                            <img src="<?php echo base_url(); ?>pics/customers.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">CUSTOMERS</span>
                                        </a>

                                    </li>

                                    <li>
                                        <a><img src="<?php echo base_url(); ?>../icons/accounting.png" class="menuIconClass">ACCOUNT STATEMENT<span class="fa fa-chevron-down"></span>
                                        </a>
                                        <ul class="nav child_menu">
                                            <li><a  href="<?php echo base_url(); ?>WalletController/master_wallet/1"><img class="menuIconClass" src="<?php echo base_url(); ?>pics/customers.png">CONTRACTOR</a></li>
                                            <li><a  href="<?php echo base_url(); ?>WalletController/customer_wallet/1"><img class="menuIconClass" src="<?php echo base_url(); ?>pics/customers.png">CUSTOMER WALLET</a></li>
                                            <li><a  href="<?php echo base_url(); ?>WalletController/app_walletDetails"><img class="menuIconClass" src="<?php echo base_url(); ?>pics/customers.png">APP WALLET</a></li>
                                            <li><a  href="<?php echo base_url(); ?>WalletController/pg_walletDetails"><img class="menuIconClass" src="<?php echo base_url(); ?>pics/customers.png">PG WALLET</a></li>
                                            <li><a  href="<?php echo base_url(); ?>WalletController/operator_wallet/1"><img class="menuIconClass" src="<?php echo base_url(); ?>pics/customers.png">OPERATOR WALLET</a></li>
                                        </ul>
                                    </li>
                                    <li class="language">
                                        <a  href="<?php echo base_url(); ?>Language/lan_help"><img class="menuIconClass" src="<?php echo base_url(); ?>../icons/language.png">LANGUAGE</a>
                                    </li>   
                                    <li><a><img class="menuIconClass" src="<?php echo base_url(); ?>../icons/cancel_reason.png" class="">CANCELLATION REASONS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a  href="<?php echo base_url(); ?>CancellationReasons/cancellationCustomer"><img class="menuIconClass" src="<?php echo base_url(); ?>../icons/cancel_reason.png" >CUSTOMER</a></li>
                                            <li><a  href="<?php echo base_url(); ?>CancellationReasons/cancellationDriver"><img class="menuIconClass" src="<?php echo base_url(); ?>../icons/cancel_reason.png" >DRIVER</a></li>
                                            <li><a  href="<?php echo base_url(); ?>CancellationReasons/cancellationStore"><img class="menuIconClass" src="<?php echo base_url(); ?>../icons/cancel_reason.png">STORE</a></li>
                                        </ul>
                                    </li>


                                    <li class="Drivers">
                                        <a href="<?php echo base_url(); ?>provider">
                                    <!--<i class="fa fa-car"></i>-->
                                            <img src="<?php echo base_url(); ?>../icons/driver.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">DRIVERS</span>
                                        </a>

                                    </li>

                                    <li class="bookings">
                                        <a href="<?php echo base_url(); ?>index.php?/superadmin/bookings/14">
                                            <img src="<?php echo base_url(); ?>pics/all_dispatched_jobs.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">ALL DISPATCHED JOB</span>
                                        </a>

                                    </li>
                                    <li class="ongoing">
                                        <a href="<?php echo base_url(); ?>index.php?/superadmin/OnGoingbookings/11">
                                            <img src="<?php echo base_url(); ?>../icons/ongoing_job.png" alt="..."  class="img-superadminIcon">
                                            <span class="title"><?php echo 'ON GOING JOBS'; ?></span>
                                        </a>
                                    </li>

                                    <li class="completed">
                                        <a href="<?php echo base_url(); ?>index.php?/superadmin/completedjobs/14">
                                            <img src="<?php echo base_url(); ?>../icons/job_completed.png" alt="..."  class="img-superadminIcon">
                                            <!--</span>-->
                                            <span class="title"><?php echo 'COMPLETED JOBS'; ?></span>
                                        </a>
                                    </li>
                                    <li class="godsview">
                                        <a target="_blank" href="http://104.131.66.74/Grocer/GodsView/home.html">
                                    <!--<i class="fa fa-table"></i>-->
                                            <img src="<?php echo base_url(); ?>pics/gods_view.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin"><?php echo 'GODSVIEW'; ?></span>
                                        </a>

                                    </li>
                                    <li class="transection">
                                        <a href="<?php echo base_url(); ?>index.php?/superadmin/transection">
                                    <!--<i class="fa fa-clone"></i>-->
                                            <img src="<?php echo base_url(); ?>pics/accounting.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">ACCOUNTING</span>
                                        </a>

                                    </li>
<!--                                    <li><a href="<?php echo base_url(); ?>index.php?/superadmin/ideliver_driverlogs">
                                    <i class="fa fa-table"></i>
                                            <img src="<?php echo base_url(); ?>/../../pics/driver_logs.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">DRIVER LOGS</span>
                                        </a>

                                    </li>-->

                                    <li class="provisionen">
                                        <a href="<?php echo base_url(); ?>index.php?/superadmin/provisionen">
                                    <!--<i class="fa fa-table"></i>-->
                                            <img src="<?php echo base_url(); ?>../icons/commision.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">COMMISSION</span>
                                        </a>

                                    </li>
                                    <li class="service">
                                        <a href="<?php echo base_url(); ?>ServiceCharge">
                                    <!--<i class="fa fa-table"></i>-->
                                            <img src="<?php echo base_url(); ?>pics/service_charge_setup.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">SERVICE CHARGE SETUP</span>
                                        </a>

                                    </li>

                                    <li class="compaigns">
                                        <a href="<?php echo base_url(); ?>index.php?/superadmin/compaigns/1">
                                    <!--<i class="fa fa-table"></i>-->
                                            <img src="<?php echo base_url(); ?>../icons/campaign.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">CAMPAIGNS</span>
                                        </a>

                                    </li>

                                    <li class="zones"><a>

                                            <img src="<?php echo base_url(); ?>../icons/rate_and_review.png" alt="..." class="img-superadminIcon">                   
                                            <span class="titleSuperadmin">REVIEW & RATING</span> 
                                            <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none;">
                                            <li><a  href="<?php echo base_url(); ?>index.php?/superadmin/parameters">

                                                    <img src="<?php echo base_url(); ?>pics/driver_review.png" alt="..." class="img-superadminIcon">
                                                    <span class="titleSuperadmin">PARAMETERS</span>
                                                </a>

                                            </li>
                                            <li class="driver_review">
                                                <a href="<?php echo base_url(); ?>index.php?/superadmin/driver_review/1">

                                                    <img src="<?php echo base_url(); ?>pics/driver_review.png" alt="..." class="img-superadminIcon">
                                                    <span class="titleSuperadmin">R & R HISTORY</span>
                                                </a>

                                            </li>

                                        </ul>
                                    </li>

                                    <li><a><img class="img-superadminIcon" src="<?php echo base_url(); ?>../icons/support.png">SUPPORT TEXT<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a  href="<?php echo base_url(); ?>utilities/supportTextCustomer"><img class="menuIconClass" src="<?php echo base_url(); ?>../icons/customer.png" class="">CUSTOMER</a></li>
                                            <li><a  href="<?php echo base_url(); ?>utilities/supportTextDriver"><img class="menuIconClass" src="<?php echo base_url(); ?>../icons/driver.png" class="">DRIVER</a></li>
                                        </ul>
                                    </li>
                                    <li class="delete">
                                        <a href="<?php echo base_url(); ?>index.php?/superadmin/delete">
                                            <img src="<?php echo base_url(); ?>pics/delete.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">DELETE</span>
                                        </a>

                                    </li>
              
                                    <li class="payroll">
                                        <a href="<?php echo base_url(); ?>index.php?/superadmin/payroll">
                                            <img src="<?php echo base_url(); ?>../icons/payroll.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">PAYROLL</span>
                                        </a>

                                    </li>
                                    <li class="operator">
                                        <a href="<?php echo base_url(); ?>index.php?/Operator/operators/1">
                                            <img src="<?php echo base_url(); ?>../icons/operator.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">OPERATORS</span>
                                        </a>

                                    </li>

<?php
$mainAdmin = $this->session->userdata("mainAdmin");

if ($mainAdmin == true) {
    ?>
                                        <li class="manageRole">
                                            <a href="<?php echo base_url(); ?>ManageRole/manageRole">

                                                <img src="<?php echo base_url(); ?>../icons/manage_access.png" alt="..." class="img-superadminIcon">
                                                <span class="titleSuperadmin">MANAGE ACCESS</span>

                                            </a>
                                        </li>
    <?php
}
?>

                                    <li class="Team">
                                        <a href="<?php echo base_url(); ?>index.php?/superadmin/Team">

                                            <img src="<?php echo base_url(); ?>../icons/team.png" alt="..." class="img-superadminIcon">
                                            <span class="titleSuperadmin">TEAM</span>
                                        </a>

                                    </li>

                                    <li class="zones"><a>
                                    <!--<i class="fa fa-edit"></i>-->
                                            <img src="" alt="..." class="img-superadminIcon">                   
                                            <span class="titleSuperadmin">APP CONFIGURATION</span> 
                                            <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu" style="display: none;">
                                            <li class="manageRole">
                                                <a href="<?php echo base_url(); ?>index.php?/superadmin/App_Configuration">

                                                    <img src="" alt="..." class="img-superadminIcon">
                                                    <span class="titleSuperadmin">TEXT DATA</span>
                                                </a>

                                            </li>
                                            <li class="mileage">
                                                <a href="<?php echo base_url(); ?>index.php?/Timeconfigration/grocerTimeConfig">
                                            <!--<i class="fa fa-car"></i>-->
<!--                                                    <img src="<?php echo base_url(); ?>" alt="..." class="img-superadminIcon">-->
                                                    <span class="titleSuperadmin">TIME SLOT CONFIG</span>
                                                </a>

                                            </li>

                                        </ul>
                                    </li>



                                </ul>
                            </div>


                        </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="Settings">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Lock">
                                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Logout">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </div>
                        <!-- /menu footer buttons -->
                    </div>
                </div>