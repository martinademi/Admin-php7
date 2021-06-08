<?php echo 111111111; die; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="https:/pics/grocer logo1.png" />
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
        
    <style>
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
        font-size:12px;
      }
  
    </style>
    
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span><?php echo Appname; ?></span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="<?php echo $this->session->userdata('profileimg'); ?>" class="img-circle profile_img" style=" margin: 20% 0% 0% 30%;" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span class="semi-bold">Welcome,</span>
                <h2 class="semi-bold"><?php echo $this->session->userdata("fadmin")['MasterBusinessName']; ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
               
                <ul class="nav side-menu">
                    <li><a  href="<?php echo base_url();?>Dashboard/loadDashbord">
                    <img src="<?php echo base_url(); ?>/../../pics/dashboard.png" alt="..." class="img-superadminIcon">
                   <span class="titleSuperadmin">DASHBOARD</span>
                   </a>
                   
                  </li>
                   <li><a href="<?php echo base_url();?>index.php?/superadmin/profile">
                   <!--<i class="fa fa-table"></i>-->
                   <img src="<?php echo base_url(); ?>/../../pics/franchise.png" alt="..." class="img-superadminIcon">
                   <span class="titleSuperadmin">FRANCHISE PROFILE</span>
                   </a>
                   
                  </li>
<!--                  <li class=""><a>
                  <i class="fa fa-edit"></i>
                  <img src="<?php echo base_url(); ?>/../../pics/menu.png" alt="..." class="img-superadminIcon">
                   <span class="titleSuperadmin"> MENU</span> <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none;">
                      <li><a  href="<?php echo base_url();?>index.php?/superadmin/Categories">
                      <i class="fa fa-building"></i>
                      <img src="<?php echo base_url(); ?>/../../pics/categories.png" alt="..." class="img-superadminIcon">
                     <span class="titleSuperadmin">CATEGORIES</span>
                     </a>

                      </li>
                      <li><a href="<?php echo base_url();?>index.php?/superadmin/SubCategories">
                      <i class="fa fa-car"></i>
                      <img src="<?php echo base_url(); ?>/../../pics/subcategories.png" alt="..." class="img-superadminIcon">
                      <span class="titleSuperadmin">SUB-CATEGORIES</span>
                      </a>

                      </li>
                      <li><a href="<?php echo base_url();?>index.php?/superadmin/AddOns">
                      <i class="fa fa-taxi"></i>
                      <img src="<?php echo base_url(); ?>/../../pics/add ons.png" alt="..." class="img-superadminIcon">
                      <span class="titleSuperadmin">ADD-ONS</span>
                      </a>

                      </li>
                     <li><a href="<?php echo base_url();?>index.php?/superadmin/Products">
                     <i class="fa fa-users"></i>
                     <img src="<?php echo base_url(); ?>/../../pics/products.png" alt="..." class="img-superadminIcon">
                      <span class="titleSuperadmin">PRODUCTS</span>
                      </a>

                      </li>
                     
                    </ul>
                  </li>-->
                  
<!--                  <li><a href="<?php echo base_url();?>index.php?/superadmin/Orders"><i class="fa fa-table"></i>ORDERS</a>
                   
                  </li>
                  <li><a href="<?php echo base_url();?>index.php?/superadmin/OrderHistory"><i class="fa fa-table"></i>ORDER HISTORY</a>
                   
                  </li><li><a href="<?php echo base_url();?>index.php?/superadmin/SalesAnalytics"><i class="fa fa-clone"></i>SALES ANALYTICS</a>
                  
                  </li>-->
                  
                 
                  <li><a href="<?php echo base_url();?>index.php?/superadmin/Products">
                  <!--<i class="fa fa-table"></i>-->
                  <img src="<?php echo base_url(); ?>/../../pics/dashboard.png" alt="..." class="img-superadminIcon">
                   <span class="titleSuperadmin">PRODUCTS</span>
                   </a>
                   
                  </li>
                  <li><a href="<?php echo base_url();?>index.php?/superadmin/Centers">
                  <!--<i class="fa fa-table"></i>-->
                  <img src="<?php echo base_url(); ?>/../../pics/dashboard.png" alt="..." class="img-superadminIcon">
                   <span class="titleSuperadmin">STORE LOCATIONS</span>
                   </a>
                   
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
              <a data-toggle="tooltip" data-placement="top"  href="Logout" title="Logout">
                  <!--<a tabindex="-1" href="Logout">LOGOUT</a>-->
                  
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>