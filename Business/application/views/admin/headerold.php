<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <link rel="shortcut icon" href="https://tebse.com/Tebse/sadmin/theme/icon/website_yum_to_go_logo.png"/>
        <title>Tebse</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!--<link rel="apple-touch-icon" href="<?php echo base_url(); ?>RylandInsurence/pages/ico/60.png">-->
        <!--<link rel="apple-touch-icon" sizes="76x76" href="<?php // echo base_url(); ?>RylandInsurence/pages/ico/76.png">-->
        <!--<link rel="apple-touch-icon" sizes="120x120" href="<?php // echo base_url(); ?>RylandInsurence/pages/ico/120.png">-->
        <!--<link rel="apple-touch-icon" sizes="152x152" href="<?php // echo base_url(); ?>RylandInsurence/pages/ico/152.png">-->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN Vendor CSS-->
        <!--<link href="<?php echo base_url(); ?>RylandInsurence/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />-->
        <link href="<?php echo base_url(); ?>RylandInsurence/assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>RylandInsurence/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>RylandInsurence/assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo base_url(); ?>RylandInsurence/assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo base_url(); ?>RylandInsurence/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
        <script src="<?php echo base_url(); ?>RylandInsurence/assets/plugins/jquery/jquery-1.8.3.min.js" type="text/javascript"></script>
        <!-- BEGIN Pages CSS-->
        <link href="<?php echo base_url(); ?>RylandInsurence/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
        <link class="main-stylesheet" href="<?php echo base_url(); ?>RylandInsurence/pages/css/pages.css" rel="stylesheet" type="text/css" />
        <link class="main-stylesheet" href="<?php echo base_url(); ?>RylandInsurence/pages/css/jquery-ui.css" rel="stylesheet" type="text/css" />


        <link href="<?php echo base_url(); ?>RylandInsurence/assets/plugins/jquery-datatable/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>RylandInsurence/assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>RylandInsurence/assets/plugins/datatables-responsive/css/datatables.responsive.css" rel="stylesheet" type="text/css" media="screen" />

        <!--[if lte IE 9]>
            <link href="pages/css/ie9.css" rel="stylesheet" type="text/css" />
        <![endif]-->

        <link rel="stylesheet" href="<?php echo base_url(); ?>RylandInsurence/cropingTool/css/cropper.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>RylandInsurence/cropingTool/css/main.css">


        <script type="text/javascript">
            window.onload = function () {
                // fix for windows 8
                if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
                    document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>RylandInsurence/pages/css/windows.chrome.fix.css" />'
            }


        </script>
    </head>

    <body class="fixed-header">
        <!--<body class="fixed-header" onload="set_interval();" onmousemove="reset_interval();" onclick="reset_interval();" onkeypress="reset_interval();" onscroll="reset_interval();">-->
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar" data-pages="sidebar">
            <!--<div id="appMenu" class="sidebar-overlay-slide from-top">-->
            <!--</div>-->
            <!-- BEGIN SIDEBAR HEADER -->
            <div class="sidebar-header">
                <div class="sidebar-header-controls " class="pull-left" style="margin-left:-60px" >
                    <h4 style="color:white;" >Tebse</h4>
                </div>
                <div class="pull-right m-l-20">
                    <img src="http://54.174.164.30/Tebse/sadmin//theme/icon/website_yum_to_go_logo.png" style="height: 50px;" alt="Logo">
                </div>

            </div>
            <!-- END SIDEBAR HEADER -->
            <!-- BEGIN SIDEBAR MENU -->
            <div class="sidebar-menu">
                <ul class="menu-items">

                    <li class="dashboard" id="HeaderDashBoard">
                        <a href="<?php echo base_url(); ?>index.php/Admin/loadDashbord" class="detailed">
                            <span class="title" style="font-size: smaller;">DASHBOARD</span>
                        </a>
                        <!--<span class="icon-thumbnail <?php // echo (base_url() . "index.php/Admin/loadDashbord" == $request_uri ? "bg-success" : "");  ?>">-->
                        <span class="icon-thumbnail ">
                            <img src="<?php echo base_url(); ?>assets/dash_board_off.png" class="dashboard_thumb"></i></span>
                    </li>

                    <li class="HeaderMenu" id="HeaderMenu">
                        <a href="javascript:;"><span class="title" style="font-size: smaller;">MENU</span>
                            <span class=" arrow"></span></a>
                        <!--<span class="icon-thumbnail">Ui</span>-->
                        <span class="icon-thumbnail">
                            <img src="<?php echo base_url(); ?>assets/menu_off.png"style="margin-top: 11px;"></span>
                        <ul class="sub-menu">

                            <!--                            <li class="" id="HeaderMenu1">
                                                            <a href="<?PHP // echo base_url() . "index.php/Admin/";  ?>Categories" class="detailed">
                                                                <span class="title" style="font-size: smaller;">CATEGORIES</span>
                                                                <span class="details"><?php // echo $dashborddata['TotalCat'];                                       ?> Categories</span>
                                                            </a>
                                                            <span class="icon-thumbnail "><i class="pg-mail"></i></span>
                                                            <span class="icon-thumbnail">
                                                                <img src="<?php // echo base_url();  ?>assets/categories_off.png"style="
                                                                                              margin-top: 6px;
                                                                                              "></span>
                                                        </li>-->


                            <li class="HeaderMenu1" id="HeaderMenu1">
                                <a href="<?PHP echo base_url(); ?>index.php/Admin/Categories" class="detailed">
                                    <span class="title" style="font-size: smaller;">CATEGORIES</span>
                                </a>
                                <!--<span class="icon-thumbnail <?php // echo (base_url() . "index.php/Admin/Categories" == $request_uri ? "bg-success" : "");  ?>">-->
                                <span class="icon-thumbnail ">
                                    <img src="<?php echo base_url(); ?>assets/categories_off.png" class="menu_thumb"></i></span>
                            </li>

                            <li class="HeaderMenu2" id="HeaderMenu2">
                                <a href="<?PHP echo base_url(); ?>index.php/Admin/SubCategories" class="detailed">
                                    <span class="title" style="font-size: smaller;">SUB-CATEGORIES</span>
                                </a>
                                <span class="icon-thumbnail ">
                                    <img src="<?php echo base_url(); ?>assets/sub_categories_off.png" class="menu1_thumb"></i></span>
                            </li>
                            
                             <li class="HeaderMenu3" id="HeaderMenu3">
                                <a href="<?PHP echo base_url(); ?>index.php/Admin/AddOns" class="detailed">
                                    <span class="title" style="font-size: smaller;">ADD-ONS</span>
                                </a>
                                <!--<span class="icon-thumbnail <?php // echo (base_url() . "index.php/Admin/AddOns" == $request_uri ? "bg-success" : "");  ?>">-->
                                <span class="icon-thumbnail ">
                                    <img src="<?php echo base_url(); ?>assets/addons_off.png" class="menu2_thumb"></i></span>
                            </li>

                            <li class="HeaderMenu4" id="HeaderMenu4">
                                <a href="<?PHP echo base_url(); ?>index.php/Admin/Products" class="detailed">
                                    <span class="title" style="font-size: smaller;">PRODUCTS</span>
                                </a>
                                <!--<span class="icon-thumbnail <?php // echo (base_url() . "index.php/Admin/Products" == $request_uri ? "bg-success" : "");  ?>">-->
                                <span class="icon-thumbnail ">
                                    <img src="<?php echo base_url(); ?>assets/products_off.png" class="menu3_thumb"></span>
                            </li>


                           

                        </ul>

                    </li>



                    <li class="HeaderOrders" id="HeaderOrders">

                        <a href="<?PHP echo base_url(); ?>index.php/Admin/Orders" class="detailed">
                            <span class="title" style="font-size: smaller;">ORDERS</span>
                        </a>
                        <!--<span class="icon-thumbnail <?php // echo (base_url() . "index.php/Admin/Orders" == $request_uri ? "bg-success" : "");  ?>">-->
                        <span class="icon-thumbnail ">
                            <img src="<?php echo base_url(); ?>assets/orders_off.png" class="order_thumb"></i></span>
                    </li>

                    <!--                    <li class="" id="HeaderOrderhistory">
                                            <a href="<?PHP // echo base_url() . "index.php/Admin/";  ?>OrderHistory" class="detailed">
                                                <span class="title" style="width: 133px; font-size: smaller;">ORDER HISTORY</span>
                                                                                  <span class="details">234 Categories</span>
                                            </a>
                                            <span class="icon-thumbnail "><i class="pg-mail"></i></span>
                                            <span class="icon-thumbnail"><img src="<?php // echo base_url();  ?>assets/icn_orderhistory.png"style="
                                                                              margin-top: 11px;
                                                                              "></span>
                                        </li>-->

                    <li class="HeaderOrderhistory" id="HeaderOrderhistory">
                        <a href="<?PHP echo base_url(); ?>index.php/Admin/OrderHistory" class="detailed">
                            <span class="title" style="font-size: smaller; width:200px;">ORDER HISTORY</span>
                        </a>
                        <!--<span class="icon-thumbnail <?php // echo (base_url() . "index.php/Admin/OrderHistory" == $request_uri ? "bg-success" : "");  ?>">-->
                        <span class="icon-thumbnail ">
                            <img src="<?php echo base_url(); ?>assets/icn_orderhistory.png" class="orderhistory_thumb"></i></span>
                    </li>

                    <!--                     <li class="" id="HeaderSalesAnalytics">
                                            <a href="<?PHP // echo base_url() . "index.php/Admin/";  ?>SalesAnalytics" class="detailed">
                                                <span class="title" style="width: 133px;font-size: smaller;">SALES ANALYTICS</span>
                                                                                  <span class="details">234 Categories</span>
                                            </a>
                                            <span class="icon-thumbnail "><i class="pg-mail"></i></span>
                                            <span class="icon-thumbnail"><img src="<?php // echo base_url();  ?>assets/icn_salesanalytics.png"style="
                                                                              margin-top: 11px;
                                                                              "></span>
                                        </li>
                    -->

                    <li class="HeaderSalesAnalytics" id="HeaderSalesAnalytics">
                        <a href="<?PHP echo base_url(); ?>index.php/Admin/SalesAnalytics" class="detailed">
                            <span class="title" style="font-size: smaller; width:200px;">SALES ANALYTICS</span>
                        </a>
                        <!--<span class="icon-thumbnail <?php // echo (base_url() . "index.php/Admin/SalesAnalytics" == $request_uri ? "bg-success" : "");  ?>">-->
                        <span class="icon-thumbnail ">
                            <img src="<?php echo base_url(); ?>assets/icn_salesanalytics.png" class="sales_thumb"></i></span>
                    </li>

                    <li class="MyProfile" id="MyProfile">
                        <a href="<?php echo base_url(); ?>index.php/Admin/profile" class="detailed">
                            <span class="title" style="font-size: smaller;width:200px;" >STORE PROFILE</span>
                        </a>
                        <!--<span class="icon-thumbnail <?php // echo (base_url() . "index.php/Admin/profile" == $request_uri ? "bg-success" : "");  ?>">-->
                        <span class="icon-thumbnail ">
                            <img src="<?php echo base_url(); ?>assets/restaurant_off.png" class="profile_thumb"></i></span>
                    </li>


                    <li class="user" id="user">
                        <a href="<?php echo base_url(); ?>index.php/Admin/user" class="detailed">
                            <span class="title" style="font-size: smaller;width:200px;" >USERS</span>
                        </a>
                        <!--<span class="icon-thumbnail <?php // echo (base_url() . "index.php/Admin/profile" == $request_uri ? "bg-success" : ""); ?>">-->
                      <span class="icon-thumbnail ">   
                        <img src="<?php echo base_url(); ?>assets/restaurant_off.png" class="user_thumb"></i></span>
                    </li>

                    <?php if ($this->session->userdata("badmin")['Driver'] == 1) { ?>
                        <li class="drivers" id="drivers">
                            <!--                        <div class="pull-left" >
                                                     
                                                        <span class="semi-bold"><?php // echo $this->session->userdata("badmin")['Driver'];   ?></span>
                                                    </div>-->
                            <a href="<?php echo base_url(); ?>index.php/Admin/drivers" class="detailed">
                                <span class="title" style="font-size: smaller;width:200px;">DRIVERS</span>
                            </a>
                            <!--<span class="icon-thumbnail <?php // echo (base_url() . "index.php/Admin/drivers" == $request_uri ? "bg-success" : "");  ?>">-->
                            <span class="icon-thumbnail ">
                                <img src="<?php echo base_url(); ?>assets/restaurant_off.png" class="drivers_thumb"></i></span>
                        </li>
                    <?php } ?>




                </ul>
                <div class="clearfix"></div>
            </div>
            <!-- END SIDEBAR MENU -->
        </div>

