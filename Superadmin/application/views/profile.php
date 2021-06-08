<?php  error_reporting(0)?>
<script>
    $(document).ready(function(){
       $('#upload1').click(function(){

           $('#positionone').trigger('click');


       });

        $('#positionone').change(function(){
            $('#path').html($('#positionone').val());

            var formElement = $('#positionone').prop('files')[0];              //document.getElementById("files_upload_form");
            var form_data = new FormData();

            form_data.append('myfile', formElement);
            form_data.append('uploadType', 'license');
            form_data.append('type', 'master');


            $.ajax({
                url: "http://107.170.66.211/roadyo_live/newadmin/application/views/master/upload_images_on_local.php",
                type: "POST",
                data: form_data,
                dataType: "JSON",
                mimeType:"multipart/form-data",
                async: false,
                success: function (result) {

                    $('#license_pic').val(result.fileName);



                },
                cache: false,
                contentType: false,
                processData: false
            });




        });

        $('#upload2').click(function(){

            $('#positiontwo').trigger('click');
        });


        $('#profile_img_upload_click').click(function(){

            $('#poponclick').trigger('click');

        });


        $('#poponclick').change(function(){


            var DivId = 0;


            var formElement = $('#poponclick').prop('files')[0];              //document.getElementById("files_upload_form");
            var form_data = new FormData();

            form_data.append('myfile', formElement);
            form_data.append('uploadType', 'profile');
            form_data.append('type', 'master');


            $.ajax({
                url: "<?php echo base_url();?>application/views/company/upload_images_on_local.php",
                type: "POST",
                data: form_data,
                dataType: "JSON",
                mimeType:"multipart/form-data",
                async: false,
                success: function (result) {

                    $('#profile_pic_to_save').val(result.fileName);
                    $('#uimg,#nav_user_img').attr('src','<?php echo PIC_PATH; ?>xxhdpi/'+result.fileName);


                },
                cache: false,
                contentType: false,
                processData: false
            });





        });

    });

</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ul class="breadcrumb">
                        <li>
                            <p>Profile</p>
                        </li>
                        <li><a href="#" class="active"> </a>
                        </li>
                    </ul>
                    <!-- END BREADCRUMB -->
                </div>
                <form enctype="multipart/form-data" id="uploadFile">
                    <input type="file" style="display: none" name="myfile_upload" id="poponclick">
                </form>

                <div class="panel panel-transparent">

                    <div class="panel-body">
                        <div class="col-md-1 sm-no-padding"></div>
                        <div class="col-md-10 sm-no-padding">

                            <div class="panel panel-transparent">
                                <div class="panel-body no-padding">
                                    <div id="portlet-advance" class="panel panel-default">
                                        <div class="panel-heading ">

                                            <div class="panel-controls">
                                                <ul>
                                                    <li>
                                                        <div class="dropdown">
                                                            <a id="portlet-settings" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                                                <i class="portlet-icon portlet-icon-settings "></i>
                                                            </a>
                                                            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="portlet-settings">
                                                                <li><a href="#">API</a>
                                                                </li>
                                                                <li><a href="#">Preferences</a>
                                                                </li>
                                                                <li><a href="#">About</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li><a href="#" class="portlet-collapse" data-toggle="collapse"><i class="portlet-icon portlet-icon-collapse"></i></a>
                                                    </li>
                                                    <li><a href="#" class="portlet-refresh" data-toggle="refresh"><i class="portlet-icon portlet-icon-refresh"></i></a>
                                                    </li>
                                                    <li><a href="#" class="portlet-maximize" data-toggle="maximize"><i class="portlet-icon portlet-icon-maximize"></i></a>
                                                    </li>
                                                    <li><a href="#" class="portlet-close" data-toggle="close"><i class="portlet-icon portlet-icon-close"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-4">


                                                    

                                                        <center>
                                                            <div class="col_2">
                                                                <div class="img" id="prof_img">
                                                                    <img style="-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);" class="img-circle" id="uimg" src="http://107.170.66.211/roadyo_live/pics/xxhdpi/<?php echo $userinfo->logo; ?>" enctype="multipart/form-data">

                                                                </div>
                                                                <div class="img" id="prof_img" style="margin-top: 28px;">

                                                                    <button class="btn btn-success btn-cons m-b-10" type="button" id="profile_img_upload_click"><i class="fa fa-cloud-upload"></i> <span class="bold">Upload</span>
                                                                    </button>
                                                                </div>
                                                            </div>



                                                        </center>



                                                </div>
                                                <div class="col-sm-6">
                                                    <form id="form-work" class="form-horizontal" method="post" role="form" autocomplete="off" novalidate="novalidate"  enctype="multipart/form-data" action="udpadedataProfile">
                                                        <div class="form-group">
                                                            <label for="fname" class="col-sm-3 control-label">First Name</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="fname" placeholder="Full name"  value="<?php echo $userinfo->firstname; ?>" name="fdata[firstname]" required="" aria-required="true">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id="profile_pic_to_save" name="fdata[logo]" value="<?php echo $userinfo->logo; ?>">

                                                        <div class="form-group">
                                                            <label for="fname" class="col-sm-3 control-label">Last Name</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="fname" placeholder="Last name" value="<?php echo $userinfo->lastname; ?>" name="fdata[lastname]" required="" aria-required="true">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="position" class="col-sm-3 control-label">Mobile</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control " id="position" value="<?php echo $userinfo->mobile; ?>" placeholder="Mobile" name="fdata[mobile]"  aria-required="true" aria-invalid="true">
                                                                <!--<label id="position-error" class="error" for="position">This field is required.</label>-->
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name" class="col-sm-3 control-label">Email</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="position" value="<?php echo $userinfo->email; ?>" placeholder="Email"  aria-required="true" aria-invalid="true" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name" class="col-sm-3 control-label">Post Code</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control " id="position" value="<?php echo $userinfo->postcode; ?>" placeholder="postcode" name="fdata[postcode]"  aria-required="true" aria-invalid="true" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name" class="col-sm-3 control-label">COMPANY</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control " id="position" value="<?php echo $userinfo->companyname; ?>" placeholder="Designation" name="fdata[companyname]"  aria-required="true" aria-invalid="true" >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name" class="col-sm-3 control-label">VAT NUMBER</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control " id="position" value="<?php echo $userinfo->vat_number; ?>" placeholder="vat number"  aria-required="true" aria-invalid="true" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name" class="col-sm-3 control-label">Address</label>
                                                            <div class="col-sm-9">
                                                                <textarea name="fdata[addressline1]"  class="form-control "><?php echo $userinfo->addressline1;?></textarea>
<!--                                                                <input type="text" class="form-control " id="position" value="--><?php //echo $userinfo->vat_number; ?><!--" placeholder="License number" name="fdata[vat_number]"  aria-required="true" aria-invalid="true" disabled>-->
                                                            </div>
                                                        </div>
<!--                                                        <div class="form-group">-->
<!--                                                            <label for="name" class="col-sm-3 control-label">Upload Driving License</label>-->
<!--                                                            <div class="col-sm-4">-->
<!--                                                                <button class="btn btn-success btn-cons m-b-10" type="button" id="upload1"><i class="fa fa-cloud-upload"></i> <span class="bold">Upload</span>-->
<!--                                                                </button>-->
<!---->
<!--                                                                <input type="hidden" id="license_pic" value="--><?php //echo $userinfo->license_pic;?><!--" name="fdata[license_pic]">-->
<!--                                                                --><?php //if($userinfo->license_pic) {?>
<!--                                                                <a href="http://107.170.66.211/roadyo_live/pics/--><?php //echo $userinfo->license_pic;?><!--" target="_blank"><button class="btn btn-primary btn-cons m-b-10" type="button"><i class="pg-form"></i> <span class="bold">View</span>-->
<!--                                                                </button></a>-->
<!--                                                                --><?php //}?>
<!---->
<!--                                                            </div>-->
<!--                                                            <div class="col-sm-5" id="path" style="float: right;"></div>-->
<!---->
<!--                                                        </div>-->
<!--                                                        <div class="form-group">-->
<!--                                                            <label for="name" class="col-sm-3 control-label">Expiration Date</label>-->
<!--                                                            <div class="col-sm-9">-->
<!--                                                                <input type="text" class="form-control " id="position" value="--><?php //echo $userinfo->expirydate; ?><!--" placeholder="Designation" name="fdata[expirydate]"  aria-required="true" aria-invalid="true" disabled>-->
<!--                                                            </div>-->
<!--                                                        </div>-->
<!--                                                        <div class="form-group">-->
<!--                                                            <label for="name" class="col-sm-3 control-label">Upload Bank Passbook Copy</label>-->
<!--                                                            <div class="col-sm-4">-->
<!--                                                                <button class="btn btn-success btn-cons m-b-10" type="button" id="upload2"><i class="fa fa-cloud-upload"></i> <span class="bold">Upload</span>-->
<!--                                                                </button>-->
<!--                                                                <input type="file" class="form-control " id="positiontwo" placeholder="Designation" name="passbook"  style="display: none;" aria-required="true" aria-invalid="true">-->
<!--                                                                <button class="btn btn-primary btn-cons m-b-10" type="button"><i class="pg-form"></i> <span class="bold">View</span>-->
<!--                                                                </button>-->
<!--                                                            </div>-->
<!--                                                            <div class="col-sm-5" id="path" style="float: right;"></div>-->
<!--                                                        </div>-->
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <!--<p>I hereby certify that the information above is true and accurate. </p>-->
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <button class="btn btn-success" type="submit">Submit</button>
<!--                                                                <button class="btn btn-default"><i class="pg-close"></i> Clear</button>-->
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="val" value="1">
                                                    </form>


                                                    <input type="file" class="form-control " id="positionone" placeholder="Designation" name="userfile"  style="display: none;" aria-required="true" aria-invalid="true">
                                                </div>
                                            </div>
                                        </div>
                                        <img src="pages/img/progress/progress-circle-master.svg" style="display:none"></div>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-1 sm-no-padding"></div>
                    </div>
                </div>




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
        <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
                <span class="hint-text">Copyright © 2014</span>
                <span class="font-montserrat">REVOX</span>.
                <span class="hint-text">All rights reserved.</span>
                <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a>
                </span>
            </p>
            <p class="small no-margin pull-right sm-pull-reset">
                <a href="#">Hand-crafted</a> 
                <span class="hint-text">&amp; Made with Love ®</span>
            </p>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- END FOOTER -->
</div>