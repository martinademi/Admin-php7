<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo ServiceLink ; ?>theme/icon/delivxlogin.png" />
        <title><?php echo Appname;?></title>

        <script src="<?php echo base_url(); ?>RylandInsurence/assets/plugins/jquery/jquery-1.8.3.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/business.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>build/css/custom.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>RylandInsurence/cropingTool/css/cropper.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>RylandInsurence/cropingTool/css/main.css">
        <link rel= "stylesheet" href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/bootstrap-multiselect.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>RylandInsurence/assets/plugins/bootstrap-datepicker/css/datepicker3.css">
        <link href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/bootstrap-timepicker.min.css" rel="stylesheet">
        <style>

            .panel{
                margin-top: 1%;
                margin-bottom: 0px;
            }
            .btn {
                border-radius: 25px;
            }
            .menuIconClass {
                /* margin-right: 5%;
                margin-bottom: 0%;
                margin-left: 2%; */
                margin-right: 10px;
                margin-bottom: 0;
                margin-left: 6px;
                width: 20px !important;
                height: 24px !important;
            }
            .titleSuperadmin{
                margin-right: 1%;
                /*margin-bottom: 1%;*/
            }
            .nav-md .container.body .col-md-3.left_col{
                z-index: 999;
            }
            ul.nav.side-menu.leftSideMenu {
                overflow: auto !important;
                /* max-height: 74vh; */
            }

            
            .leftSideMenu::-webkit-scrollbar {
                width: 6px;
                background-color: #2A3F54;
            }
            .leftSideMenu::-webkit-scrollbar-thumb {
                background-color: #71a489;
            }

            .leftSideMenu::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                background-color: #2A3F54;
            }


            .modalPopUpText{
                font-size: 14px !important;
                text-align:center;
            }

            .form-horizontal .control-label {
                text-align:left;
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
                font-size:11px;
            }
         

            .left_colBtCus {
                max-width: 230px !important;
                position: fixed!important;
                left: 0!important;
                top: 0!important;
                /* background: #fff!important; */
                z-index: 999!important;
                height: 100%!important;
                /* border: 1px solid red!important; */
                width: 100%!important;
                padding-right: 0px !important;
                background: #2A3F54!important;
                padding-left: 0px !important;
            }
            .leftSideMenuBtCus {
                width: 100% !important;
                position: unset !important;
                height: 95vh !important;
                overflow-y: auto !important;
                padding-bottom: 0px !important;
            }
            .nav_titleBt {
                width: auto !important;
                height: auto !important;
            }
        </style>

    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col left_colBtCus">
                    <div class="left_col scroll-view leftSideMenu leftSideMenuBtCus">
                         <div class="navbar nav_title nav_titleBt" style="border: 0;">
                         <center><img src="<?php echo ServiceLink;?>theme/icon/delivxlogoflexy.png" style="margin-top: 10px;"></center>
                        </div>

                        <div class="clearfix"></div>                     
                        
                        <div id="sidebar-menu" class="main_menu_side main_menu" style=" margin-top: -20px;">
                            <div class="menu_section" style="margin-bottom: 0px !important;">
                                <h3 style="display: -webkit-box;"></h3>
                                <ul class="nav side-menu leftSideMenu">
                                    <br/>

                                    <li class="dashboard" ><a  href="<?php echo base_url(); ?>index.php?/Dashboard/loadDashbord">
                                            <!-- <img class="menuIconClass" src="<?php echo ServiceLink . '/pics/Dashboard.png' ?>" > -->
                                            <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/dashboard.svg">
                                            <span class="titleSuperadmin">DASHBOARD</span>
                                        </a>
                                    </li>

                                    <li class="profile"><a href="<?php echo base_url(); ?>index.php?/Profile/profile">
                                            <!-- <img src="<?php echo ServiceLink; ?>/theme/icon/store_profile.png" class="menuIconClass"> -->
                                            <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/Store people.svg">
                                            <span class="titleSuperadmin">FRANCHISE PROFILE</span>
                                        </a>
                                    </li>
                                    <li class="profile"><a href="<?php echo base_url(); ?>index.php?/schduled">
                                            <!-- <img src="<?php echo ServiceLink; ?>/theme/icon/store_profile.png" class="menuIconClass"> -->
                                            <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/working hours.svg">
                                            <span class="titleSuperadmin">WORKING HOUR</span>
                                        </a>
                                    </li>

                                     <li class="manager"><a href="<?php echo base_url(); ?>index.php?/franchiseManager">
                                            <!-- <img src="<?php echo ServiceLink; ?>/theme/icon/store_profile.png" class="menuIconClass"> -->
                                            <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/Store managers.svg">
                                            <span class="titleSuperadmin">FRANCHISE MANAGER</span>
                                        </a>
                                    </li> 

                                    <li><a href="<?php echo base_url(); ?>index.php?/Category">                                                   
                                    <!-- <img src="<?php echo ServiceLink; ?>/theme/icon/store_profile.png" class="menuIconClass"> -->
                                    <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/Product category.svg">
                                        <span class="titleSuperadmin">PRODUCT CATEGORY</span>
                                                </a>
                                     </li>
                                    <?php 
                                        if($this->session->userdata('fadmin')['storeType'] == 1){
                                       ?>
                                    <li class="AddOns"><a href="<?php echo base_url(); ?>index.php?/AddOns">
                                       <!-- <img class="menuIconClass" src="<?php echo ServiceLink; ?>theme/grocerIcons/list.png" style="width:20px;"> -->
                                       <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/Add ons.svg">
                                            <span >ADD ON'S/MODIFIER</span>
                                        </a>
                                    </li>
                                    <?php 
                                        
                                        }
                                    ?>
                                     <li class="StoreProducts"><a href="<?php echo base_url(); ?>index.php?/AddNewProducts/FranchiseProducts">
                                     <!-- <img class="menuIconClass" src="<?php echo ServiceLink; ?>theme/grocerIcons/list.png" style="width:20px;"> -->
                                     <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/store products.svg">
                                        <span >FRANCHISE PRODUCTS</span>
                                        </a>
                                    </li>


                                     <li class="manager"><a href="<?php echo base_url(); ?>index.php?/Business">
                                            <!-- <img src="<?php echo ServiceLink; ?>/theme/icon/store.png" class="menuIconClass"> -->
                                            <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/inventory.svg">
                                            <span class="titleSuperadmin">STORE SETUP</span>
                                        </a>
                                    </li> 

                                

                                     <li class="wallet"><a href="<?php echo base_url(); ?>index.php?/wallet/user/store">
                                            <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/accStatement.svg">
                                            <span class="titleSuperadmin">ACCOUNT STATEMENT</span>
                                        </a>
                                    </li> 
                                    
                                    <li class="customer"><a href="<?php echo base_url(); ?>index.php?/StoreCustomer">
                                            <!-- <img src="<?php echo ServiceLink; ?>/theme/icon/store_profile.png" class="menuIconClass"> -->
                                            <img class="menuIconClass" style="" src="<?php echo ServiceLink; ?>pics/svg/store customer.svg">
                                            <span class="titleSuperadmin">CUSTOMER</span>
                                        </a>
                                    </li> 
									 <li class="customer"><a href="<?php echo base_url(); ?>index.php?/Orders">
                                            <!-- <img src="<?php echo ServiceLink; ?>/theme/icon/store_profile.png" class="menuIconClass"> -->
                                            <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/allOrders.svg" >
                                            <span class="titleSuperadmin">ORDERS</span>
                                        </a>
                                    </li> 

                                    <li class="customer"><a href="<?php echo base_url(); ?>index.php?/productOffers">
                                            <!-- <img src="<?php echo ServiceLink; ?>/theme/icon/store_profile.png" class="menuIconClass"> -->
                                            <img class="menuIconClass" style="" src="<?php echo ServiceLink; ?>pics/svg/offers.svg">
                                            <span class="titleSuperadmin">OFFERS</span>
                                        </a>
                                    </li> 

                                    

                                </ul>
                            </div>
                        </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            
                        </div>
                        <!-- /menu footer buttons -->
                    </div>
                </div>
