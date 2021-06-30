<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo ServiceLink;?>theme/icon/favicon.png" />
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
        <link rel= "stylesheet" href="<?php echo base_url(); ?>vendors/bootstrap/dist/css/bootstrap-multiselect.css"></script>
        <link rel= "stylesheet" href="<?php echo base_url(); ?>RylandInsurence/assets/plugins/bootstrap-datepicker/css/datepicker3.css"></script>

       

    <style>

        /* .panel{
            margin-top: 1%;
            margin-bottom: 0px;
        } */
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
            /* margin-right: 0;
            margin-bottom: 1%; */
            margin-right: 6px !important;
            margin-bottom: 0 !important;
            margin-left: 0 !important;
            width: 30px !important;
            height: 30px !important;
        }
        .nav-md .container.body .col-md-3.left_col {
            height: 100%  !important;
            min-height: 100%  !important;
            background:transparent !important;
            z-index: 999;
        }
        ul.nav.side-menu.leftSideMenu {
            overflow: auto !important;
            /* max-height: 74vh; */
        }
        .leftSideMenu {
            height: 99vh;
            position: fixed;
            /* width: 245px; */
            width: 230px;
            max-height: 100% !important;
            padding-bottom: 100px !important;
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
        .brand {
            font-weight: 600;
            font-size: 16px;
            color: #0090d9;
            color: #0090d9 !important;
            margin-bottom: 20px !important;
            letter-spacing: 0.3px !important;
            margin-top: 10px !important;
            display: inline-block !important;
            font-family: 'Libre Franklin', sans-serif !important;
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
            font-size: 10px !important;
        }
        .lastButton{
            margin-right:1%;
        }
        .form-control {
            border-radius: 10;
        }

        ul.nav.side-menu img.img-superadminIcon {
            margin:0px 15px 5px 10px;
            width: 20px;
        }
        ul.nav.side-menu li>a {
            padding: 10px 10px;
        }
        .main_menu_side ul.nav.side-menu {
            margin-top: 0px;
        }
        .nav_titleBt{
            width: auto !important;
            height: auto !important;
        }
        .left_colBtCus {
            max-width:230px !important;
            position:fixed!important;
            left:0!important;
            top:0!important;
            background:#fff!important;
            z-index:999!important;
            height:100%!important;
            /* border:1px solid red!important; */
            width:100%!important;
            padding-right: 0px !important;
        }
        .leftSideMenuBtCus {
            width: 100% !important;
            position: unset !important;
            height: 95vh !important;
            overflow-y: auto !important;
            padding-bottom: 0px !important;
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
                    <!-- store logo details -->    
                    
                    <!-- store logo details -->
                    <div id="sidebar-menu" class="main_menu_side main_menu">
                        <div class="menu_section">
                            <h3 style="display: -webkit-box;"></h3>
                            <ul class="nav side-menu">
                                <br/>

                                <li class="dashboard" ><a  href="<?php echo base_url(); ?>index.php?/Business/loadDashbord">
                                        <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/dashboard.svg">
                                        <span><?php echo $this->lang->line('DASHBOARD'); ?></span>
                                    </a>
                                </li>

                                

                                <li class="profile"><a href="<?php echo base_url(); ?>index.php?/Business/profile">
                                        <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/Store people.svg">
                                        <span><?php echo $this->lang->line('STORE_PROFILE'); ?></span>
                                    </a>
                                </li>

                                <li class="dashboard" ><a  href="<?php echo base_url(); ?>index.php?/brandsController">
                                        <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/Store managers.svg">
                                        <span><?php echo "BRANDS"; ?></span>
                                    </a>
                                </li>

                                 <li class="workinghour"><a href="<?php echo base_url(); ?>index.php?/Schduled">
                                        <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/working hours.svg">
                                        <span><?php echo $this->lang->line('WORKING_HOURS'); ?></span>
                                    </a>
                                </li>

                                <!-- <li class="workinghour"><a href="<?php echo base_url(); ?>index.php?/Deliveryschduled">
                                        <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/working hours.svg">
                                        <span><?php echo $this->lang->line('DELIVERY_SCHEDULE'); ?></span>
                                    </a>
                                </li> -->


                                <li class="Storemanagers"><a  href="<?php echo base_url(); ?>index.php?/Storemanagers">
                                        <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/Store managers.svg">
                                        <span ><?php echo $this->lang->line('STORE_MANAGERS'); ?></span>
                                    </a>
                                </li> 
                                
                                <!-- for laundr -->
                                <?php
                                  if($this->session->userdata('badmin')['storeType']!=5){
                                 ?> 
                                <li class="storeDrivers"><a  href="<?php echo base_url(); ?>index.php?/Drivers/storeDrivers/my/1">
                                        <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/drivers.svg">
                                        <span><?php echo $this->lang->line('DRIVERS'); ?></span>
                                    </a>

                                </li>
                                <li class="Category"><a href="<?php echo base_url(); ?>index.php?/Category">
                                        <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/Product category.svg">
                                        <span ><?php echo $this->lang->line('PRODUCT_CATEGORY'); ?></span>
                                    </a>
                                </li>

                                <?php } ?>


                                  <!--validation of store  -->
                                  <?php
                                  if($this->session->userdata('badmin')['storeType']==1){
                                 ?> 

                                <li class="AddOns"><a href="<?php echo base_url(); ?>index.php?/AddOns">
                                    <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/Add ons.svg">
                                    <span ><?php echo $this->lang->line('ADDON_MODIFIERS'); ?></span>
                                   </a>
                                 </li>

                                 

                                  <li class="StoreProducts"><a href="<?php echo base_url(); ?>index.php?/AddNewProducts/StoreProducts">
                                        <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/store menu.svg">
                                        <span ><?php echo $this->lang->line('STORE_MENU'); ?></span>
                                    </a>
                                 </li>

                                  <?php } ?>
                                  
                                  <!--validation of store  -->
                                  <?php
                                  if($this->session->userdata('badmin')['storeType']!=1 && $this->session->userdata('badmin')['storeType']!=5 ){
                                 ?> 

                                 <li class="StoreProducts"><a href="<?php echo base_url(); ?>index.php?/AddNewProducts/StoreProducts">
                                        <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/store products.svg">
                                        <span ><?php echo $this->lang->line('STORE_PRODUCTS'); ?></span>
                                    </a>
                                 </li>

                                <li  class="inventory"><a href="<?php echo base_url(); ?>index.php?/Inventory">
                                        <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/inventory.svg">
                                        <span ><?php echo $this->lang->line('INVENTORY'); ?></span>
                                    </a>
                                </li>

                                  <?php } ?>

                                <li class="carts"><a  href="<?php echo base_url(); ?>index.php?/Orders">
                                        <img class="menuIconClass" src="<?php echo ServiceLink; ?>pics/svg/allOrders.svg" >
										<span><?php echo $this->lang->line('ALL_ORDERS'); ?></span>
									</a>
								</li>

                                <!-- validation for laundr -->
                                  <?php
                                  if($this->session->userdata('badmin')['storeType']!=5){
                                 ?> 


                                <li  class="Offers"><a href="<?php echo base_url(); ?>index.php?/ProductOffers">
                                        <img class="menuIconClass" style="" src="<?php echo ServiceLink; ?>pics/svg/offers.svg">
                                        <span ><?php echo $this->lang->line('OFFERS'); ?></span>
                                    </a>
                                </li>

                                  <?php } ?>

                                <li class="wallet"><a href="<?php echo base_url(); ?>index.php?/wallet/details/store/<?php echo $this->session->userdata('badmin')['BizId'] ; ?>">
                                        <img class="menuIconClass" style="" src="<?php echo ServiceLink; ?>pics/svg/accStatement.svg">
                                        <span ><?php echo $this->lang->line('ACCOUNT_STATEMENT'); ?></span>
                                    </a>
                                </li>
                                <li class="StoreCustomer"><a href="<?php echo base_url(); ?>index.php?/StoreCustomer" style="display:none">
                                        <img class="menuIconClass" style="" src="<?php echo ServiceLink; ?>pics/svg/store customer.svg">
                                        <span ><?php echo $this->lang->line('STORE_CUSTOMER'); ?></span>
                                    </a>
                                </li>

                            
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small sidebar-footerBtCus">
                       
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>