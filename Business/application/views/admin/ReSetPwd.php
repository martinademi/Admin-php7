<?PHP
error_reporting(false);

$enable = 'disabled';
if ($Admin == '1') {
    $enable = 'required';
}
?>
<style>
    .form-horizontal .form-group 
    {
        margin-left: 13px;
    }    
</style>



<script>
//    $("#MyProfile").addClass("active");

    $(document).ready(function () {

        $('#submitButton').click(function () {
            alert(1);

            if ($('#newPwd').val() == '') {
                alert('Enter New Password.');
                return;
            }

            if ($('#newPwd').val() !== $('#reNewPwd').val()) {
                alert('password do not match.');
                return;
            }
            
//            alert(1);
                    
            $.ajax({
                url: "<?PHP echo AjaxUrl; ?>ResetPassword",
                type: "POST",
                dataType: "JSON",
                data: {reNewPwd: $('#reNewPwd').val(), For: $('#For').val()},
                success: function (result) {


                    if (result.flag == 1) {
                        alert('ReEnter The Passwords');
                    } else {
                        alert('Password is succssfully changed.');
                        $('#addentity').submit();
                    }
                }
            });
//            $('#addentity').submit();

        });


    });

</script>




<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="margin-left: 20px;">



                    <li><a href="#" class="active">Change Password</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>



            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">

                    <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url() ?>index.php/Admin" method="post" enctype="multipart/form-data">
                        <input type='hidden' id='For' value='<?PHP echo $For; ?>'> 
                        <div class="tab-content">

                            <div class="row row-same-height">


                                <div class="form-group">
                                    <label for="fname" class="col-sm-3 control-label">New Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" id="newPwd" value='' placeholder="New Password" name=""  aria-required="true" style="color: black;">
                                    </div>
                                    <div class="col-sm-1">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fname" class="col-sm-3 control-label">Re-Type New Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" id="reNewPwd" value='' placeholder="Re-Type New Password" name="FData[Password]"  aria-required="true" style="color: black;">
                                    </div>

                                </div>


                            </div>
                            <button class="btn btn-primary btn-cons btn-animated from-left fa fa-cog pull-right" id="submitButton" type="button" >
                                <span style=" height: 24px;">Finish</span>
                            </button>



                        </div>               
                    </form>

                </div>


            </div>
            <!-- END PANEL -->
        </div>

    </div>
    <!-- END JUMBOTRON -->

    <!-- START CONTAINER FLUID -->
    <div class="container-fluid container-fixed-lg">
        <!-- BEGIN PlACE PAGE CONTENT HERE -->

        <!-- END PLACE PAGE CONTENT HERE -->
    </div>
    <!-- END CONTAINER FLUID -->

</div>
<!-- END PAGE CONTENT -->
<!-- START FOOTER -->
<div class="container-fluid container-fixed-lg footer">
    <?PHP include 'FooterPage.php' ?>
</div>


