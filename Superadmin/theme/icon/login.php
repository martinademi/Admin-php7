<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

        <link rel="shortcut icon" href="<?php echo base_url(); ?>theme/icon/loginlogoflexy.png" />

        <link href="<?php echo base_url(); ?>theme/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>theme/assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>theme/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>theme/assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo base_url(); ?>theme/assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo base_url(); ?>theme/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo base_url(); ?>theme/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
        <link class="main-stylesheet" href="<?php echo base_url(); ?>theme/pages/css/pages.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript">
            window.onload = function ()
            {
                // fix for windows 8
                if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
                    document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
            }

            function forgotLink() {

                $(".loginForm").hide();
                $(".resetPassword").show();
            }
            function loginLink() {

                $(".loginForm").show();
                $(".resetPassword").hide();
            }

            function submitLogin()
            {
                if ($('#email').val() == '' || $('#email').val() == null)
                {
                    alert('Please eneter username');
                    return false;
                } else if ($('#password').val() == '' || $('#password').val() == null)
                {
                    alert('Please eneter password');
                    return false;
                }

                return true;

            }

            window.onload = function ()
            {
                // fix for windows 8
                if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
                    document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
            }

            function validateForm()
            {
                if (!validateEmail($("#email").val()))
                {
                    $("#errorbox").html("Enter valid email id");
                    return false;
                }

                if (isBlank($("#password").val()))
                {
                    $("#errorbox").html("Enter password");
                    return false;
                }

                return true;

            }

            function VerifyNsendLink()
            {
                var resetemail = $("#emailid").val();
                if (!validateEmail(resetemail))
                {
                    alert("Enter valid email id");
                    return false;
                } else
                {

                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/superadmin/forgotPasswordFromadmin",
                        type: 'POST',
                        data: {"email": resetemail, 'AccType': 'Superadmin'},
                        datatype: "JSON",
                        success: function (data) {
                            $("#forgoterrorbox").html("");
                            if (data.flag == 1)
                                alert('Invalid email id,Please enter valid email id');
                            else
                            {
                                alert('New password has been sent to your mail.');

                            }
                        }
                    });
                }

            }

        </script>

        <style>

            .login-wrapper {
                background-color:black;
            }            btn:focus, .btn:active:focus, .btn.active:focus {
                outline: 0 none;
            }

            .btn-primary {
                background: #0099cc;
                color: #ffffff;
                border-color:azure;
            }

            .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open > .dropdown-toggle.btn-primary {
                background: #33a6cc;
                border-color:azure;
            }

            .btn-primary:active, .btn-primary.active {
                background: #007299;
                box-shadow: none;
                border-color:azure;
            }

        </style>

        <style>
            .m-t-30 {
                margin-top: 35%;
            }
            .m-l-20 {
                margin-left: 10%;
            }
            .m-r-20 {
                margin-right: 10%;
            }

            .login-wrapper .bg-pic > img {
                width: 100%;
            }
            .loginDetails {
                background-color: rgba(10, 11, 13, 0.71);
                padding: 5%;
                color: white;
                /*border-radius: 5px;*/
                /*border: 5px solid rgb(182, 218, 250);*/
            }
            .login-wrapper .bg-caption {
                width: 510px;
            }
        </style>


    </head>
    <body>

        <div class="login-wrapper">



            <div class="bg-pic">
                <!--START Background Pic-->
                <img src="<?php echo base_url() ?>theme/icon/flexynew.png" data-src="<?php echo base_url() ?>theme/icon/flexynew.png" data-src-retina="<?php echo base_url() ?>theme/icon/flexynew.png" alt="">


                <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
                    <!--<h2 class="semi-bold text-white">-->
<?php//                        echo Appname; ?> 
                    <!--                        Drivers Are 
                                            Setting Things In Motion!
                                            Be A Part Of The Revolution</h2>-->
                    <br>
                    <p class="small text-white" style="font-weight:600">
                        © 2016-17 <?php echo Appname; ?><br>                        

                    </p>
                </div>
                <!--END Background Caption-->
            </div>

            <div class="login-container">
                <div class="m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
				 <img src="<?php base_url() ?>theme/icon/flexy_logo1.png" style="width:50%;height:50%; margin-left:25%;padding-bottom: 25px"/>
                    <div class="loginDetails loginForm col-xs-12">
                        <form id="submitForLogin" method="post" action="<?php echo base_url() ?>index.php?/superadmin/AuthenticateUser" onsubmit= "return submitLogin();">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" id="email" name="email" placeholder="Please enter username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="password" name="password" placeholder="Please enter password" class="form-control">
                            </div>
                            <div class="" style="margin-top: 1%;">                            
                                <button type="submit" class="btn btn-success">Login</button>
                                <a href="#" class="forgotLink" onclick="forgotLink()" style="color:red;font-size: 11px;margin-left:20%;">
<?php
if ($loginerrormsg != '')
    echo $loginerrormsg;
else
    echo 'Forgot Password ?'
    ?>
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="loginDetails resetPassword col-xs-12" style="display:none;">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="emailid" id="emailid" placeholder="Please enter your email" class="form-control">
                        </div>                         
                        <div class="" style="margin-top: 1%;">                            
                            <button type="button" class="btn btn-success" onclick="VerifyNsendLink();">Submit</button>   
                            <a href="#" class="forgotLink" onclick="loginLink()" style="font-weight: 600;font-size: 12px;margin-left:20%;">Click here to login</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <script src="<?php echo base_url(); ?>theme/assets/js/universal.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/jquery/jquery-1.8.3.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/modernizr.custom.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/jquery-bez/jquery.bez.min.js"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/jquery-actual/jquery.actual.min.js"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>theme/assets/plugins/bootstrap-select2/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>theme/assets/plugins/classie/classie.js"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>theme/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <!-- END VENDOR JS -->
        <!-- BEGIN CORE TEMPLATE JS -->
        <script src="<?php echo base_url(); ?>theme/pages/js/pages.min.js"></script>
        <!-- END CORE TEMPLATE JS -->
        <!-- BEGIN PAGE LEVEL JS -->
        <script src="<?php echo base_url(); ?>theme/assets/js/scripts.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL JS -->
        <script>
                                $(function ()
                                {
                                    $('#form-login').validate()
                                })
        </script>
    </body>
</html>


