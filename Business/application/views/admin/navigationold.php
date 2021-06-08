<?php $userimageurl = "http://104.131.96.96/guyidee/"; ?>

<script src="http://cdn.pubnub.com/pubnub-3.7.12.min.js"></script>
<script>(function () {


//        alert('<?php // echo $this->session->userdata("BizId");               ?>');
        // INIT PubNub
        var Diveid = 0;
        var pubnub = PUBNUB.init({
            publish_key: 'pub-c-f591132c-1fb7-4e91-a4f1-3b90a712794a', //pub-c-0c7e42e0-ad19-4c03-8e3a-3eb1d854cb54',
            subscribe_key: 'sub-c-b7e72e8c-e1dd-11e4-a366-0619f8945a4f', //'sub-c-ce8459e8-a9f4-11e3-85d3-02ee2ddab7fe',
            ssl: false,
            jsonp: false
        });

        // LISTEN
        pubnub.subscribe({
            channel: "<?php echo $this->session->userdata("badmin")['BizId']; ?>",
            message: function (m) {
//                alert(m.a);

//                    alert('pubnub is running'+JSON.stringify(m));
                if (m.a == 12) {
//                    alert('i m here');

                    $.ajax({
                        type: 'post',
                        url: '<?php echo AjaxUrl; ?>NotificationDetails/' + m.bid,
                        data: {app_id: ''},
                        dataType: 'json',
                        success: function (result) {

                            if (result.CustomerProfilePic) {
                                $('#patientimage').attr('src', result.CustomerProfilePic);
                                var pp = result.CustomerProfilePic;
                            }
                            else {
                                $('#patientimage').attr('src', 'http://104.236.41.101/tutree/pics/aa_default_profile_pic.gif');
                                var pp = 'http://104.236.41.101/tutree/pics/aa_default_profile_pic.gif';
                            }


                            var code = '<a href="http://107.170.50.165/YumToGo/Business/index.php/Admin/OrderDetails/' + m.bid + '"><div class="pgn pgn-circle" style="cursor: pointer;" id="notificationclick' + Diveid + '" >' +
                                    '<div class="alert alert-info"><div onclick="displaypopup(' + Diveid + ')">' +
                                    '<div class="pgn-thumbnail"><div >' +
                                    '<img width="40" height="40" style="display: inline-block;" src="' + pp + '" data-src="' + pp + '" data-src-retina="' + pp + '" alt=""></div>' +
                                    '</div><div class="pgn-message"><div style="margin-left: 6%;width: 100%;">' +
                                    '<p class="bold">' + result.CustomerName + '</p>' +
                                    '<p>' + 'New Order Recived' + '</p></div>' +
                                    '</div></div><button type="button" class="close" data-dismiss="alert">' +
                                    '<span aria-hidden="true">×</span><span class="sr-only">Close</span>' +
                                    '</button></div><div class="clearfix"></div></div></a>';
                            $('#notificationpop').append(code);
//                            $('#notificationsound').html('<audio autoplay="autoplay"><source src="http://postmenu.cloudapp.net/Business/notification.mp3" type="audio/mpeg" /><source src="<?php // echo soundfile ?>.ogg" type="audio/ogg" /><embed hidden="true" autostart="true" loop="false" src="<?php // echo soundfile ?>.mp3" /></audio>');
                            $('#notificationsound').html('<audio autoplay="autoplay"><source src="http://postmenu.cloudapp.net/Business/notification.mp3" type="audio/mpeg" /><source src="soundfile.ogg" type="audio/ogg" /><embed hidden="true" autostart="true" loop="false" src="soundfile.mp3" /></audio>');

                            Diveid++;
                        }
                    });
                }

            }
        });

    })();

    function displaypopup(divid) {
        $("#notificationclick" + divid).remove();
        $("#quickview").css('display', 'block ');
        $("#quickview").show();
        $(".abt")[0].click();
    }



    function Show_Reson_box() {

        $('#reson_box').modal('show');
        $('#cover').trigger('click');


    }

</script>




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
<!--                    <img src="--><?php //echo base_url();                                                                ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();                                                                ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();                                                                ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

                    <strong>BUSINESS MANAGEMENT CONSOLE - <span style="text-transform: uppercase;"><?php echo $this->session->userdata("badmin")['BusinessName']; ?></span></strong>
                </div>
            </div>
        </div>

        <!--        <div class=" pull-left sm-table">
                    <div class="header-inner">
                        <div class="brand inline" style="width: 200px;font-size: 17px;color: gray;">
                            <img src="<?php //echo base_url();                                                                ?>theme/assets/img/Rlogo.png" alt="logo" data-src="<?php //echo base_url();                                                                ?>theme/assets/img/Rlogo.png" data-src-retina="<?php //echo base_url();                                                                ?>theme/assets/img/logo_2x.png" width="93" height="25">
                            <span style="color:red; padding-right:20px">AUTO LOGOUT IN:<span id="logouttime"></span></span>
        
                        </div>
                    </div>
                </div>-->

        <div class=" pull-right">
            <div id="notificationsound"></div>
            <!--<div></div>-->
            <div  id="notificationpop" class="pgn-wrapper" data-position="top-right"></div>
            <div class="header-inner">

                <!--<a href="#" class="btn-link icon-set menu-hambuger-plus m-l-20 sm-no-margin hidden-sm hidden-xs" data-toggle="quickview" data-toggle-element="#quickview"></a>-->
            </div>
        </div>
        <div class=" pull-right">

            <!-- START User Info-->
            <div class="visible-lg visible-md m-t-10" id="caldw">

                <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
                    <span class="semi-bold"><?php echo $this->session->userdata("badmin")['BusinessName']; ?></span>
                    <!--<span class="text-master"><?php // echo $this->session->userdata("last_name");                                                         ?></span>-->
                </div>

                <div class="btn-group">

                    <?php
                    if ($this->session->userdata("badmin")['profile_pic'] == '')
                        $profilepic = base_url() . 'RylandInsurence/images/default.png';
                    else
                        $profilepic = $this->session->userdata("badmin")['profile_pic'];
                    ?>

                    <img data-toggle="dropdown" style="border-radius: 28px;margin-top: 4px;margin-right: 7px;cursor: pointer;" data-hover="dropdown" src="<?php echo $profilepic; ?>" alt="" data-src="<?php echo $profilepic; ?>" data-src-retina="<?php echo $profilepic; ?>" width="32" height="32">
                        <ul class="dropdown-menu" style="margin-left: -135px;margin-top: 14px;background: #ffffff;width: 171px;">
                            <li>
                                <div class="row center-margin m-b-10">
                                    <div class="col-xs-2 text-center">
                                        <i class="fs-14 sl-user-follow"></i>
                                    </div>
                                    <div class="col-xs-8 text-center">
                                        <a tabindex="-1" href="<?php echo base_url(); ?>index.php/Admin/profile">my Profile</a>
                                    </div>
                                </div>

                            </li>
                            <li class="divider"></li>
                            <li>

                                <center><a tabindex="-1" href="ChangePwd">Change Password</a></center>
                            </li>
                            <li class="divider"></li>
                            <li>

                                <center><a tabindex="-1" href="Logout">Logout</a></center>
                            </li>

                        </ul>
                </div>

            </div>
            <!-- END User Info-->
        </div>

    </div>

