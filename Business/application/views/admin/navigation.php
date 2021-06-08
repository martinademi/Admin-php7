<style>
@import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600,700');
.border {
    border: 1px solid red;
    padding: 0px 15px;
}
.profilePr{
    display:flex;
    align-items: center;
    padding: 4px 15px;
    background: #fff;
}
.profilePrCh{
    display:flex;
    align-items: center;
}
.ch1{
    flex:1;
}
.ch2{
    /* flex-basis: 22%; */
    flex-basis: auto;
}
.PrCh1{
    flex:1;
}
.PrCh2{
    flex-basis: auto;
}
.console {
    color: #474747 !important;
    font-size:16px !important;
    line-height:30px;
    font-family: 'Open Sans', sans-serif !important;
    margin-left: 20px;
    font-weight: 600;
}
.top_navCusBt{
    max-width:calc(100% - 230px)!important;
    /* border:1px solid red!important; */
    float:right!important;
    width:100%!important;
    margin-left: unset !important;
    transition: 1s ease-in-out
}

.top_nav.top_navCusBt.fixedNav {
    position: fixed;
    width: calc(100% - 230px)!important;
    height: 50px;
    top: 0px;
    z-index: 99;
    left: 230px;
    transition: 1s ease-in-out
}
</style>
<script>

$(document).ready(function () {

    $('.error-box-class').keyup(function () {
        $('.error-box').text("");
    });


    $(window).scroll(function () {
        var scr = jQuery(window).scrollTop();
        if (scr > 0) {
            $('.nav_menu').addClass('fixednab');
            $('.top_navCusBt').addClass('fixedNav');
        } else {
            $('.nav_menu').removeClass('fixednab');
            $('.top_navCusBt').removeClass('fixedNav');
        }
    });

    $('#resetPassword').click(function () {
        var size = $('input[name=stickup_toggler]:checked').val()
        var modalElem = $('#myModal1');
        if (size == "mini") {
            $('#modalStickUpSmall').modal('show')
        } else {
            $('#myModal1').modal('show')
            if (size == "default") {
                modalElem.children('.modal-dialog').removeClass('modal-lg');
            } else if (size == "full") {
                modalElem.children('.modal-dialog').addClass('modal-lg');
            }
        }
    });

    $("#superpass").click(function () {
        $("errorpass").text("");

        var oldpass = $("#oldpass").val();
        var newpass = $("#newpass").val();
        var confirmpass = $("#confirmpass").val();
        var currentpassword = $("#currentpassword").val();

        var reg = /^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])\S*$/;    //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;

        if (oldpass == "" || oldpass == null)
        {
            //                alert("please enter the new password");
            $("#errorpass").text('Please enter the current password ');

        } else if (newpass == "" || newpass == null)
        {
            //                alert("please enter the new password");
            $("#errorpass").text(<?php echo json_encode(POPUP_PASSENGERS_PASSNEW); ?>);
        } else if (!reg.test(newpass))
        {
            //                alert("please enter the password with atleast one chareacter and one letter");
            $("#errorpass").text(<?php echo json_encode(POPUP_PASSENGERS_PASSVALID); ?>);
        } else if (confirmpass == "" || confirmpass == null)
        {
            //                alert("please confirm the password");
            $("#errorpass").text(<?php echo json_encode(POPUP_PASSENGERS_PASSCONFIRM); ?>);
        } else if (confirmpass != newpass)
        {
            //                alert("please confirm the same password");
            $("#errorpass").text(<?php echo json_encode(POPUP_PASSENGERS_SAMEPASSCONFIRM); ?>);
        } else
        {

            $.ajax({
                url: "<?php echo base_url('index.php?/Business') ?>/editpassword",
                type: 'POST',
                data: {
                    password: newpass,
                    currentpassword: currentpassword
                },
                dataType: 'JSON',
                success: function (response)
                {
                    if (response == 1) {

                        $(".close").trigger('click');

                        var size = $('input[name=stickup_toggler]:checked').val()
                        var modalElem = $('#confirmmodels');
                        if (size == "mini")
                        {
                            $('#modalStickUpSmall').modal('show')
                        } else
                        {
                            $('#confirmmodels').modal('show')
                            if (size == "default") {
                                modalElem.children('.modal-dialog').removeClass('modal-lg');
                            } else if (size == "full") {
                                modalElem.children('.modal-dialog').addClass('modal-lg');
                            }
                        }

                        $("#errorboxdatas").text('password changed successfully');
                        $(".error-box-class").val('');

                    }

                }

            });
        }

    });

    $('#confirmedYes').click(function () {
        window.location.href="<?php echo base_url(); ?>index.php?/Business/logout";
    });

});


function validatePassword() {
    var oldpass = $("#oldpass").val();
    if (oldpass == '' || oldpass == null) {
        $("#errorpass").html("Please enter current password");
    } else {
        $.ajax({
            url: "<?php echo base_url('index.php?/Business') ?>/validatePassword",
            type: 'POST',
            data: {
                oldpass: oldpass
            },
            dataType: 'JSON',
            success: function (result)
            {
                console.log(result);
                if (result.msg == '1') {
                    $("#errorpass").html("Wrong current Password");
                    $('#oldpass').focus();
                } else if (result.msg == '0') {


                }
            }

        });
    }
}


</script>

<!-- top navigation -->
<!-- <div class="col-xs-12 top_nav top_navCusBt"> -->
<div class="col-xs-9 top_nav top_navCusBt">
    <div class="nav_menu profilePr">
        <div class="profile ch1">
            <!-- store logo details -->
            <div class="profilePrCh">
                <div class="PrCh2">
                    <div class="profile_pic" style="text-align: center;width: auto;margin-right: 14px;">
                        <img src="<?php echo $this->session->userdata["badmin"]['profile_pic']; ?>" onerror="this.src='<?php echo ServiceLink; ?>pics/user.jpg'" class="img-circle profile_img" style="border-radius: 50%; width:60px;margin-left: 0% !important;margin-top: 0px !important;height: 60px!important;">
                    </div>
                </div>
                <div class="PrCh1">
                    <div class="profile_info" style="padding: 0;width: 100%; text-align: left;margin-left:0% !important;">
                        <span style="font-weight: bold;"><?php
                            $adminName = $this->session->userdata["badmin"]['BusinessName'];
                            if (isset($adminName)) {
                                echo $adminName;
                            } else {
                                echo 'Store Admin';
                            }
                        ?></span><span class="console"><?php echo $this->lang->line('Store_Management_Console'); ?></span>
                    </div>
                </div>
            </div>
             <!-- store logo details -->
        </div>
        <div class= "ch3">
            <ul class="nav navbar-nav" style="">
            <li class="active">
                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="green" style="font-size: 14px;"><?php echo $this->lang->line('Language'); ?></span>
                            <span class=" fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu " style="width:0px;">

                            <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php?/Language/index/english">
                                    <img src="<?php echo ServiceLink; ?>theme/grocerIcons/IN.png" class="pull-right" alt="" style="width:20%;margin-top-3px">English
                                </a>
                            </li>
                            <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php?/Language/index/arabic">
                                    <img src="<?php echo base_url() . 'pics/french_flag.png' ?>" class="pull-right" alt="" style="width:20%">Arabic
                            </a></li>
                        </ul>
                    </li>
            </ul>
        </div>
        <div class="ch2">
            <ul class="nav navbar-nav" style="">
            
                <li class="active">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="green" style="    font-size: 14px;">
                            <?php
                            $adminName = $this->session->userdata["badmin"]['Ownername'];
                            if (isset($adminName)) {
                                echo $adminName;
                            } else {
                                echo 'Admin';
                            }
                            ?></span>
                        &nbsp;&nbsp;<span class="fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right" style="width:0px;">
                        <li><a tabindex="-1" href="#" id="resetPassword"><i class="fa fa-lock pull-right" aria-hidden="true"></i><?php echo $this->lang->line('Reset_Password'); ?></a></li>
                        <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php?/Business/logout"><i class="fa fa-sign-out pull-right"></i><?php echo $this->lang->line('Log_Out'); ?></a></li>
                    </ul>
                </li>

                <li role="presentation" class="dropdown">
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li>
                            <a>
                                <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li>
                            <div class="text-center">
                                <a>
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- nav -->
    <div class="row"  style="display:none !important;">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6">
                    <div class="row">
                        <div class="col-xs-5">
                            <img src="<?php echo $this->session->userdata["badmin"]['profile_pic']; ?>" onerror="this.src='<?php echo ServiceLink; ?>pics/user.jpg'" class="img-circle" style="border-radius: 50%; width:60px;margin-left: 0% !important;margin-top: 0px !important;height: 60px!important;">
                        </div>
                        <div class="col-xs-7">
                            <div class="" style="">
                                <span style="font-weight: bold;">
                                    <?php
                                        $adminName = $this->session->userdata["badmin"]['BusinessName'];
                                        if (isset($adminName)) {
                                            echo $adminName;
                                        } else {
                                            echo 'Store Admin';
                                        }
                                    ?>
                                </span>
                                <span class="console">
                                    <?php echo $this->lang->line('Store_Management_Console'); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <ul class="list-inline">
                        <li class="active">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="green" style="    font-size: 14px;">
                                    <?php
                                    $adminName = $this->session->userdata["badmin"]['Ownername'];
                                    if (isset($adminName)) {
                                        echo $adminName;
                                    } else {
                                        echo 'Admin';
                                    }
                                    ?></span>
                                &nbsp;&nbsp;<span class="fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right" style="width:0px;">
                                <li><a tabindex="-1" href="#" id="resetPassword"><i class="fa fa-lock pull-right" aria-hidden="true"></i><?php echo $this->lang->line('Reset_Password'); ?></a></li>
                                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php?/Business/logout"><i class="fa fa-sign-out pull-right"></i><?php echo $this->lang->line('Log_Out'); ?></a></li>
                            </ul>
                        </li>

                        <li role="presentation" class="dropdown">
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                                        <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                                        <span>
                                            <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                        </span>
                                        <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                                        <span>
                                            <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                        </span>
                                        <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                                        <span>
                                            <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                        </span>
                                        <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <!--<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>-->
                                        <span>
                                            <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                        </span>
                                        <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a>
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </div> 
    </div>
    <!-- nav -->
</div>

<div class="modal fade stick-up" id="myModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-header">

                        <div class=" clearfix text-left">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                            </button>

                        </div>
                        <h3> <?php echo LIST_RESETPASSWORD_HEAD; ?></h3>
                    </div>

                    <br>

                    <div class="modal-body">

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label">Current Password<span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  id="oldpass" name="oldpass" onblur="validatePassword()"  class="error-box-class form-control" placeholder="eg:g3Ehadd">
                                    <!--<input type="text"  id="oldpass" name="oldpass"  class="form-control" onblur="validateoldpass()" placeholder="eg:g3Ehadd">-->
                                </div>
                            </div>

                            <br>
                            <br>
                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-4 control-label"> <?php echo FIELD_NEWPASSWORD; ?><span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  id="newpass" name="latitude"  class="error-box-class form-control" placeholder="eg:g3Ehadd">
                                </div>
                            </div>

                            <br>
                            <br>

                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-4 control-label"><?php echo FIELD_CONFIRMPASWORD; ?><span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  id="confirmpass" name="longitude" class="error-box-class form-control" placeholder="H3dgsk">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4" ></div>
                                <div class="col-sm-8 error-box" id="errorpass"></div>
                                <div class="col-sm-4" ></div>
                                <div class="col-sm-4" ></div>
                                <div class="col-sm-4" >
                                    <button type="button" class="btn btn-primary pull-right" id="superpass" ><?php echo BUTTON_SUBMIT; ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        </div>
        <div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom:0;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>

                    </div>

                </div>
                <br>
                <div class="modal-body">
                    <div class="row">

                        <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center">Delete</div>

                        </div>
                    </div>

                    <br>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4" ></div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4" >
                                <button type="button" class="btn btn-default pull-right" id="confirmedYes" ><?php echo BUTTON_YES; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" style="min-height:100vh!important" role="main">
<!-- top navigation -->