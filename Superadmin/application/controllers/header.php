<?php require_once 'language.php'; ?>
<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <link rel="shortcut icon" href="<?php echo base_url(); ?>theme/icon/truckr_favicon.png" />
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

        <style>


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



    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col" >
                    <div class="left_col scroll-view leftSideMenu">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="#" class="site_title" style="padding-left: 22%;"></<span><?php echo strtoupper(Appname); ?></span></a>
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile">
                            <div class="profile_pic">
                                <img src="<?php echo ServiceLink . 'pics/user.jpg' ?>" alt="..." class="img-circle profile_img">
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

                                    <li><a  href="<?php echo base_url(); ?>index.php?/superadmin/Dashboard"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Dashboard.png' ?>" class="">DASHBOARD</a></li>
                                    <li><a  href="<?php echo base_url(); ?>index.php?/superadmin/cities"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cities.png' ?>" class="">CITIES</a></li>
                                    <li><a  href="<?php echo base_url(); ?>index.php?/category"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle Models.png' ?>" class="">TYPE OF ARTIST</a>
                                    </li>
                                    <li><a  href="<?php echo base_url(); ?>index.php?/events"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/dispatcher_off.png' ?>" class="">EVENTS</a></li>
                                    <li><a  href="<?php echo base_url(); ?>index.php?/subcategory"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle Models.png' ?>" class="">SUB CATEGORY</a>

                                    </li>
                                    <li><a  href="<?php echo base_url(); ?>index.php?/services"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle Models.png' ?>" class="">SERVICES</a>
                                    <li><a  href="<?php echo base_url(); ?>index.php?/customer"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" class=""><?php echo NAV_PASSENGERS; ?></a>

                                    </li> 
                                    </li>
                                    <li><a  href="<?php echo base_url(); ?>index.php?/provider"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle Models.png' ?>" class="">ARTIST</a>

                                    </li>
                                    <li id=""><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" class="">LOGS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/messages"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">SMS</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/logs/email"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">EMAIL</a></li>
                                        </ul>
                                    </li>
                                    <li><a  href="<?php echo base_url(); ?>index.php?/superadmin/app_config"><img style="margin-right: 3%;margin-bottom: 1%;" src="<?php echo ServiceLink . 'pics/disputes_off.png' ?>" class="">APP CONFIGURATION</a></li> 
                                    <li><a  href="<?php echo base_url(); ?>index.php?/appVersions/appVersions/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" class=""> APP VERSIONS</a></li>    
                <!--                    <li><a  href="<?php echo base_url(); ?>index.php?/superadmin/operators/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Comapnies.png' ?>" class="">OPERATORS</a></li>-->
                                    <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/vehicle_models/1"><img class="menuIconClass" src="<?php // echo ServiceLink.'pics/Vehicle Models.png' ?>" class="">VEHICLEMODELS</a> </li>-->
                                    <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/vehicle_type"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicle types.png' ?>" class="">VEHICLETYPES</a></li>-->
                                    <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/Vehicles/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Vehicles.png' ?>" class="">VEHICLES</a></li>--> 
                                    <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/specialities"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/disputes_off.png' ?>" class="">GOOD TYPES</a> </li>--> 
                                    <!--<li id=""><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" class="">ZONES<span class="fa fa-chevron-down"></span></a>-->
                                    <!--                        <ul class="nav child_menu">
                                                                <li><a  href="<?php echo base_url(); ?>index.php?/superadmin/operating_zone"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">OPERATING ZONE</a></li>
                                                                <li><a  href="<?php echo base_url(); ?>index.php?/superadmin/long_haul_zone"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">LONG HAUL ZONE</a></li>
                                                                <li><a href="<?php echo base_url(); ?>index.php?/superadmin/zones"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" class="">SHORT HAUL ZONE</a></li>
                                                            </ul>-->
                                    <!--</li>-->
                                    <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/Drivers/my/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Drivers.png' ?>" class="">DRIVERS</a></li>-->  
                                    <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/driverVerification"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Customer-Verification.png' ?>" class="">DRIVER VERIFICATION</a>-->
                                    <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/customers/3"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" class="">CUSTOMERS</a></li>--> 
                                    <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/customerVerification"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" class="">CUSTOMER VERIFICATION</a></li>--> 
                                    <!--<li><a class="godviewLink" target="_blank" href="<?php echo GodsviewLink; ?>?id=<?php echo $this->session->userdata('godsviewToken'); ?>"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/GodsView.png' ?>" class="">GODSVIEW</a></li>-->  
                                    
                                     <li><a  href="<?php echo base_url(); ?>index.php?/superadmin/DriverAcceptanceRate"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/completedjobs_off.png' ?>" class="">ARTIST ACCEPTANCE RATE</a></li> 
                                    <li><a  href="<?php echo base_url(); ?>index.php?/superadmin/dispatched/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/dispatcher_off.png' ?>" class="">CENTRAL DISPATCHERS</a></li>
                                    <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/driverReferral"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver-Referrals-Tracker.png' ?>" class="">DRIVER REFERRAL TRACKER</a></li>-->
                                    <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/driverPlans"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver-Plans.png' ?>" class="">DRIVER PLANS</a></li>-->
                                    <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/paymentCycle"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/payroll_off.png' ?>" class="">PAYMENT CYCLE</a></li>-->
                                    <!--<li><a  href="<?php echo base_url(); ?>index.php?/superadmin/accounting"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/accounting_off.png' ?>" class=""> ACCOUNTING</a></li>--> 
                                    <li class="stripeFeed"><a  href="<?php echo base_url(); ?>index.php?/Stripefeeds"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/accounting_off.png' ?>">STRIPE FEEDS</a></li> 
                                    <li class="bookings"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >BOOKINGS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a  href="<?php echo base_url(); ?>index.php?/DispatchLogs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/All dispatched jobs.png' ?>" class="">DISPATCH LOGS</a></li> 
                                            <!--<li  class="estimateRequested"><a  href="<?php echo base_url(); ?>index.php?/superadmin/estimateRequested"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape ongoingbooking_off.png' ?>" >ESTIMATE REQUESTED</a> </li>--> 
                                            <li  class="allBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/bookings/13"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/All dispatched jobs.png' ?>" >ALL BOOKINGS</a></li> 
                                            <li class="onGoingBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/onGoing_jobs/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape ongoingbooking_off.png' ?>" >ON GOING BOOKINGS</a></li> 
                                            <li class="completedBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/completed_jobs"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/completedjobs_off.png' ?>" >COMPLETED BOOKINGS</a></li> 
                                            <li class="cancelledBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/cancelledBookings"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancelled-Bookings.png' ?>" >CANCELLED BOOKINGS</a></li> 
                                            <li class="unassignedBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/unassignedBookings"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancelled-Bookings.png' ?>" >UNASSIGNED BOOKINGS</a></li> 
                                            <li class="expiredBookings"><a  href="<?php echo base_url(); ?>index.php?/superadmin/expiredBookings"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancelled-Bookings.png' ?>" >EXPIRED BOOKINGS</a></li> 
                                            <li class="allBids"><a  href="<?php echo base_url(); ?>index.php?/superadmin/allBids"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/completedjobs_off.png' ?>" >ALL BIDS</a></li> 
                                        </ul>
                                    </li>
                                    <li class="wallet"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" >ACCOUNT STATEMENT<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="master_wallet"><a  href="<?php echo base_url(); ?>index.php?/WalletController/wallet/1/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >PROVIDER WALLET</a></li>
                                            <li class="customer_wallet"><a  href="<?php echo base_url(); ?>index.php?/WalletController/wallet/2/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >CUSTOMER WALLET</a></li>
                                            <li class="app_walletDetails"><a  href="<?php echo base_url(); ?>index.php?/WalletController/app_walletDetails"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >APP WALLET</a></li>
                                            <li class="pg_walletDetails"><a  href="<?php echo base_url(); ?>index.php?/WalletController/pg_walletDetails"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >PG WALLET</a></li>
                                            <li class="operator_wallet"><a  href="<?php echo base_url(); ?>index.php?/WalletController/wallet/3/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Shape passangerrating_off.png' ?>" >OPERATOR WALLET</a></li>
                                        </ul>
                                    </li>
                                    <li id=""><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" class="">PROMOTION<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a  href="<?php echo base_url(); ?>index.php?/coupons/refferal"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">REFERRALS</a></li>
                                            <li><a  href="<?php echo base_url(); ?>index.php?/coupons/promotion"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png' ?>" class="">PROMO CODES</a></li>
                                            <!--<li><a href="<?php echo base_url(); ?>index.php?/coupons/zones"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/icon_Zones.png'; ?>" class="">PROMO ZONE</a></li>-->
                                        </ul>
                                    </li>



                   <!--<li><a  href="<?php echo base_url(); ?>index.php?/Utilities/email_template"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" class="">EMAIL TEMPLATES</a>-->

                                    <!--</li>--> 
                                    <li><a  href="<?php echo base_url(); ?>index.php?/Sendnotification"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/completedjobs_off.png' ?>" class=""> SEND NOTIFICATION</a></li>


                                    <li class="ratings"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png'; ?>" >RATINGS<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="driverReview"><a  href="<?php echo base_url(); ?>index.php?/superadmin/driver_review/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" > ARTIST RATING</a></li>    
                                            <li class="driverReview"><a  href="<?php echo base_url(); ?>index.php?/superadmin/customer_review/1"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" > CUSTOMER RATING</a></li>    
                                            <li class="tripRating"><a  href="<?php echo base_url(); ?>index.php?/superadmin/driverRating"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" > CONFIGURE RATING</a></li>    
                                        </ul>
                                    </li>

                                    <li class="appText"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >APP TEXT SETTING<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li class="language"><a  href="<?php echo base_url(); ?>index.php?/Utilities/lan_help"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Driver reviews.png' ?>" >LANGUAGE</a></li>   
                                            <li class="supportText"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >SUPPORT TEXT<span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/supportTextCustomer"><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >CUSTOMER</a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/supportTextDriver"><img class="menuIconClass" src="<?php echo ServiceLink . 'assests/support_text.png' ?>" >ARTIST</a></li>
                                                </ul>
                                            </li>
                                            <li class="cancellationReasons"><a><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancellation-Reasons.png' ?>" >CANCELLATION REASONS<span class="fa fa-chevron-down"></span></a>
                                                <ul class="nav child_menu">
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/cancellationCustomer"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancellation-Reasons.png' ?>" >CUSTOMER</a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/cancellationDriver"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancellation-Reasons.png' ?>" >ARTIST</a></li>
                                                    <li><a  href="<?php echo base_url(); ?>index.php?/utilities/cancellationDispatcher"><img class="menuIconClass" src="<?php echo ServiceLink . 'pics/Cancellation-Reasons.png' ?>" >DISPATCHER</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a  href="<?php echo base_url(); ?>index.php?/superadmin/manageRole"><img class="menuIconClass"  src="<?php echo ServiceLink . 'pics/disputes_off.png' ?>" class=""> MANAGE ACCESS</a></li> 
                                </ul>
                            </div>


                        </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->

                        <!-- /menu footer buttons -->
                    </div>
                </div>















