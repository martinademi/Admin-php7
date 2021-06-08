<?php
    // require_once '../environmentVariables/config.php';
?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>change password</title>
        <script>
            const url = "<?php echo APIDevLink;?>";
        </script>
        <script src='./config.js'></script>
        <link rel="icon" type="image/x-icon" href="../theme/icon/favicon.png">
        <link rel='stylesheet prefetch' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>

        <link rel="stylesheet" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>

    <body>	  <button id="password_hidden" style="display:none"> </button>
        <div class='login'>
            <span><img src="../theme/icon/logo.png" width="150" height="53" alt="company logo" id="header_logo"></span>
            <div class='login_title'>
                <span>Change your password</span>
            </div>
            <div class='login_fields'>
                <div class='login_fields__user'>
                    <div class='icon'>
                        <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/lock_icon_copy.png'>
                    </div>

                    <input placeholder='Type your password' type='password' id="password" autocomplete="off">
                    <div class='validation'>
                        <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/tick.png'>
                    </div>
                    </input>
                </div>
                <div class='login_fields__password'>
                    <div class='icon'>
                        <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/lock_icon_copy.png'>
                    </div>
                    <input placeholder='Confirm your password' type='password' autocomplete="off" id="confirm_password">
                    <div class='validation'>
                        <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/tick.png'>
                    </div>
                </div>
                <div class='login_fields__submit'>
                    <p class="error_msg"></p>
                    <input type='submit' value='Change Password' id="submit">
                </div>
            </div>
            <div class='success'>
                <h2 style="color:#0bff34">Password changed</h2>
                <p style="text-align:center;color:#fff">Please login to continue</p>
            </div>
        </div>
        <div class='authent'>
            <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/puff.svg'>
            <p>Authenticating...</p>
        </div>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
        <script src="js/index.js"></script>
    </body>
</html>
