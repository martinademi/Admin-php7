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
//            alert();
            if ($('#oldPwd').val() == '') {
                alert('Enter Old Password.');
                return;
            }
            if ($('#newPwd').val() == '') {
                alert('Enter New Password.');
                return;
            }

            if ($('#newPwd').val() !== $('#reNewPwd').val()) {
                alert('password do not match.');
                return;
            }
            $.ajax({
                url: "<?PHP echo AjaxUrl; ?>CheckOldPwd",
                type: "POST",
                dataType: "JSON",
                data: {oldPwd: $('#oldPwd').val()},
                success: function (result) {


                    if (result.flag == 1) {
                        alert('Enter Correct Old Password');
                    } else {
                        $('#addentity').submit();
                    }
                }
            });
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
                    <li>
                        <a href="<?php echo base_url() ?>index.php/Admin/loadDashbord">DASHBOARD</a>
                    </li>


                    <li><a href="#" class="active">Change Password</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>



            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">

                    <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url() ?>index.php/Admin/UpdatePwd" method="post" enctype="multipart/form-data">
                        <input type='hidden' name='BusinessId' value='<?PHP echo $BizId; ?>'> 
                        <div class="tab-content">

                            <div class="row row-same-height">
                                <div class="form-group">
                                    <label for="fname" class="col-sm-3 control-label">Old Password</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" id="oldPwd" value='' placeholder="Old Password" name="OldPwd"  aria-required="true">
                                    </div>

                                </div>

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
                                <span style="
                                      height: 24px;
                                      ">Finish</span>
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


<div class="modal fade in" id="ForMaps" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
    <div class="modal-dialog">

        <form action = "<?php echo base_url(); ?>index.php/superadmin/AddNewCenter" method= "post" onsubmit="return validateForm();">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Drag Marker To See Address</h4>
                </div>

                <div class="modal-body"><div class="form-group" >
                        <div id="myMap" style="width: 544px; height: 250px;"></div><br/>
                        <div class="form-group">
                            <label>Address Line 1</label>
                            <input type="text" class="form-control" value="" placeholder="Address ..." name="address" id="address" onkeyup="getAddLatLong(this);">
                        </div> 
                        <div class="form-group">
                            <label>Address Line 2</label>
                            <input type="text" class="form-control" value="" placeholder="Address ..." name="address2" id="address2" >
                        </div> 
                        <div class="col-md-6">
                            <label>Latitude</label>
                            <input type="text" class="form-control" value="" placeholder="Latitude ..." name="latitude" id="latitude">
                        </div> 
                        <div class="col-md-6">
                            <label>Longitude</label>
                            <input type="text" class="form-control" value="" placeholder="Longitude ..." name="longitude" id="longitude">
                        </div> 

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick='Cancel();'>Close</button>
                    <input type="button" id="TakeMapAddress"  data-dismiss="modal" class="btn btn-primary" onclick='Take();' value="Take Address" >

                </div>
            </div>
        </form>
        </form>

    </div>

</div>
<?PHP
$i = 0;
if (is_array($ProfileData['WorkingHours'])) {
    foreach ($ProfileData['WorkingHours'] as $wh) {

        if ($i == 0) {
            ?>
            <script>

                $('#Monday1').val('<?PHP echo $wh['From']; ?>');
                $('#Monday2').val('<?PHP echo $wh['To']; ?>');
                $('#Monday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Monday4').val('<?PHP echo $wh['To1']; ?>');</script>
            <?PHP
        }
        if ($i == 1) {
            ?>
            <script>
                $('#Tuesday1').val('<?PHP echo $wh['From']; ?>');
                $('#Tuesday2').val('<?PHP echo $wh['To']; ?>');
                $('#Tuesday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Tuesday4').val('<?PHP echo $wh['To1']; ?>');
            </script>
            <?PHP
        }
        if ($i == 2) {
            ?>
            <script>
                $('#Wednesday1').val('<?PHP echo $wh['From']; ?>');
                $('#Wednesday2').val('<?PHP echo $wh['To']; ?>');
                $('#Wednesday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Wednesday4').val('<?PHP echo $wh['To1']; ?>');
            </script>
            <?PHP
        }
        if ($i == 3) {
            ?>
            <script>
                $('#Thursday1').val('<?PHP echo $wh['From']; ?>');
                $('#Thursday2').val('<?PHP echo $wh['To']; ?>');
                $('#Thursday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Thursday4').val('<?PHP echo $wh['To1']; ?>');
            </script>
            <?PHP
        }
        if ($i == 4) {
            ?>
            <script>
                $('#Friday1').val('<?PHP echo $wh['From']; ?>');
                $('#Friday2').val('<?PHP echo $wh['To']; ?>');
                $('#Friday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Friday4').val('<?PHP echo $wh['To1']; ?>');
            </script>
            <?PHP
        }
        if ($i == 5) {
            ?>
            <script>
                $('#Saturday1').val('<?PHP echo $wh['From']; ?>');
                $('#Saturday2').val('<?PHP echo $wh['To']; ?>');
                $('#Saturday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Saturday4').val('<?PHP echo $wh['To1']; ?>');
            </script>
            <?PHP
        }
        if ($i == 6) {
            ?>
            <script>
                $('#Sunday1').val('<?PHP echo $wh['From']; ?>');
                $('#Sunday2').val('<?PHP echo $wh['To']; ?>');
                $('#Sunday3').val('<?PHP echo $wh['From1']; ?>');
                $('#Sunday4').val('<?PHP echo $wh['To1']; ?>');
            </script>
            <?PHP
        }
        $i++;
    }
}
?>