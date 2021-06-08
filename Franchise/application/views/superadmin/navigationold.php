<?php $userimageurl = "http://104.131.96.96/guyidee/"; ?>

<div class="page-container" xmlns="http://www.w3.org/1999/html">
    <!-- START PAGE HEADER WRAPPER -->
    <!-- START HEADER -->
    <div class="header ">
        <!-- START MOBILE CONTROLS -->
        <!-- LEFT SIDE -->
        <div class="pull-left full-height visible-sm visible-xs">
            <!-- START ACTION BAR -->
            <div class="sm-action-bar">
                <a href="#" class="btn-link toggle-sidebar" data-toggle="sidebar">
                    <span class="icon-set menu-hambuger"></span>
                </a>
            </div>
            <!-- END ACTION BAR -->
        </div>
        <!-- RIGHT SIDE -->
        <div class="pull-right full-height visible-sm visible-xs">
            <!-- START ACTION BAR -->
            <div class="sm-action-bar">
                <a href="#" class="btn-link" data-toggle="quickview" data-toggle-element="#quickview">
                    <span class="icon-set menu-hambuger-plus"></span>
                </a>
            </div>
            <!-- END ACTION BAR -->
        </div>
        <!-- END MOBILE CONTROLS -->
        <div class=" pull-left sm-table">
            <div class="header-inner">
                <div class="brand inline" style="width: 718px;color: gray;">
<!--                    <img src="--><?php //echo base_url();       ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();       ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();       ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

                    <strong>FRANCHISE MANAGEMENT CONSOLE - <span style="text-transform: uppercase;"><?php echo $this->session->userdata("fadmin")['MasterBusinessName']; ?></span></strong>
                </div>
            </div>
        </div>

        <!--        <div class=" pull-left sm-table">
                    <div class="header-inner">
                        <div class="brand inline" style="width: 200px;font-size: 17px;color: gray;">
                            <img src="<?php //echo base_url();       ?>theme/assets/img/Rlogo.png" alt="logo" data-src="<?php //echo base_url();       ?>theme/assets/img/Rlogo.png" data-src-retina="<?php //echo base_url();       ?>theme/assets/img/logo_2x.png" width="93" height="25">
                            <span style="color:red; padding-right:20px">AUTO LOGOUT IN:<span id="logouttime"></span></span>
        
                        </div>
                    </div>
                </div>-->

        <div class=" pull-right">

            <div class="header-inner">
                <!--<a href="#" class="btn-link icon-set menu-hambuger-plus m-l-20 sm-no-margin hidden-sm hidden-xs" data-toggle="quickview" data-toggle-element="#quickview"></a>-->
            </div>
        </div>
        <div class=" pull-right">
            <!-- START User Info-->
            <div class="visible-lg visible-md m-t-10" id="caldw">

                <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
                    <span class="semi-bold"><?php echo $this->session->userdata("fadmin")['MasterBusinessName']; ?></span>
                    <!--<span class="text-master"><?php // echo $this->session->userdata("MasterBusinessName"); ?></span>-->
                </div>

                <div class="btn-group">

                    <?php
                    if ($this->session->userdata("fadmin")['profile_pic'] == '')
                        $profilepic = base_url() . 'RylandInsurence/images/default.png';
                    else
                        $profilepic = $this->session->userdata("fadmin")['profile_pic'];
                    ?>

                    <img data-toggle="dropdown" style="border-radius: 28px;margin-top: 4px;margin-right: 7px;cursor: pointer;" data-hover="dropdown" src="<?php echo $profilepic; ?>" alt="" data-src="<?php echo $profilepic; ?>" data-src-retina="<?php echo $profilepic; ?>" width="32" height="32">
                        <ul class="dropdown-menu" style="margin-left: -135px;margin-top: 14px;background: #ffffff;width: 171px;">
                            <li>
                                <div class="row center-margin m-b-10">
                                    <div class="col-xs-2 text-center">
                                        <i class="fs-14 sl-user-follow"></i>
                                    </div>
                                    <div class="col-xs-8 text-center">
                                        <a tabindex="-1" href="<?php echo base_url(); ?>index.php/superadmin/profile">MY PROFILE</a>
                                    </div>
                                </div>

                            </li>
                            <li class="divider"></li>

                            <li>

                                <center><a tabindex="-1" href="Logout">LOGOUT</a></center>
                            </li>

                        </ul>
                </div>

            </div>
            <!-- END User Info-->
        </div>
    </div>

