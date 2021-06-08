<?php
if ($data['approvedDate'] != '' || $data['approvedDate'] != null) {
    $approvedDate = date('F  d, Y h:i:s A', $data['approvedDate']);
} else {
    $approvedDate = '';
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<link href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<style>

    .btn-success {
        background: #26B99A;
        border: 1px solid #26b99a;
    }
    .btn{
        border-radius: 25px!important;
    }

    .headerText{
        margin-left: 100px;
        color: black;
        font-size: 18px;
    }
    .btnClass{
        background: #337ab7;
        border: 1px solid #31708f;
    }

    button, .buttons, .btn, .modal-footer .btn+.btn {
        margin-bottom: 5px;
    }
    .sweet-alert h2 {
        color: #575757;
        font-size: 14px;
        text-align: center;
        font-weight: 600;
        text-transform: none;
        position: relative;
        margin: 25px 0;
        padding: 0;
        line-height: 40px;
        display: block;
    }

    .cmn-toggle {
        position: absolute;
        margin-left: -9999px;

    }
    .cmn-toggle + label {
        display: block;
        position: relative;
        cursor: pointer;
        outline: none;
        user-select: none;
    }

    input.cmn-toggle-round + label {
        padding: 2px;
        width: 94px;
        height: 30px;
        background-color: #dddddd;
        border-radius: 60px;
    }
    input.cmn-toggle-round + label:before,
    input.cmn-toggle-round + label:after {
        display: block;
        position: absolute;
        top: 1px;
        left: 1px;
        bottom: 1px;
        content: "";
    }
    input.cmn-toggle-round + label:before {
        right: 1px;
        background-color: #f1f1f1;
        border-radius: 60px;
        transition: background 0.4s;
    }
    input.cmn-toggle-round + label:after {
        width: 38px;
        background-color: #fff;
        border-radius: 100%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        transition: margin 0.4s;
    }
    input.cmn-toggle-round:checked + label:before {
        background-color: #8ce196;
    }
    input.cmn-toggle-round:checked + label:after {
        margin-left: 60px;
    }

    span.abs_text{
        position:absolute;
        right:15px;
        top:1px;
        z-index:9px;
        padding:9px;
        background:#f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }
</style>
<script>
    function isNumberKey(evt)
    {
        $("#mobify").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
            //    alert("Only numbers are allowed");
            $("#mobify").text("Please enter only numbers");
            return false;
        }
        return true;
    }
    $('document').ready(function () {


        $('#deactivateNoReason').click(function () {
            if ($('#deactivateNoReason').is(':checked')) {
                $('#deactivateReason').val("");
                $('#deactivateReason').hide();
                $('#reasonLabel').hide();
                $('#confirmed').prop('disabled', false);
            } else {
                $('#deactivateReason').val("");
                $('#deactivateReason').show();
                $('#reasonLabel').show();
                $('#confirmed').prop('disabled', true);
            }
        });
        $('#deactivateNoReason1').click(function () {
            if ($('#deactivateNoReason1').is(':checked')) {
                $('#deactivateReason2').val("");
                $('#deactivateReason2').hide();
                $('#reasonLabel1').hide();
                $('#confirmed1').prop('disabled', false);
            } else {
                $('#deactivateReason2').val("");
                $('#deactivateReason2').show();
                $('#reasonLabel1').show();
                $('#confirmed1').prop('disabled', true);
            }
        });
        $('#deactivateReason').focus(function () {
            $('#confirmed').prop('disabled', false);
        });
        $('#deactivateReason2').focus(function () {
            $('#confirmed1').prop('disabled', false);
        });
		
		$('#deactivateReason').focusout(function () {
			if($('#deactivateReason').val() == "" || $('#deactivateReason').val() == null){
				$('#confirmed').prop('disabled', true);
			}else{
            $('#confirmed').prop('disabled', false);
			}
        });
		
		 $('#deactivateReason2').focusout(function () {
			 if( $('#deactivateReason2').val()== "" ||  $('#deactivateReason2').val()== null){
            $('#confirmed1').prop('disabled', true);
			 }else{
				   $('#confirmed1').prop('disabled', false);
			 }
        });
        $('#confirmed').prop('disabled', true);
        $('#confirmed1').prop('disabled', true);



        $('#uploadCard').click(function () {
            $('#uploadCardModal').modal('show');
        });
        $('#upload').click(function () {
            $('#uploadModal').modal('show');
        });
        $('#approveCard').click(function () {
			var approveCard = $('#approveCard').val();
			if(approveCard == "" || approveCard == null){
				$('#alertModal').modal('show');
			}else{
            $('#approveCardModel').modal('show');
			}
        });
        $('#approve').click(function () {
			var approve = $('#approve').val();
			if(approve == "" || approve == null){
				$('#alertModal').modal('show');
			}else{
            $('#approveModal').modal('show');
			}
        });
        $('#downloadCard').click(function () {
			var downloadCard = $('#downloadCard').val();
			if(downloadCard == "" || downloadCard == null){
				$('#alertModal').modal('show');
			}else{
            $('#downloadCardModal').modal('show');
			}
        });
        $('#download').click(function () {
			var download = $('#download').val();
			if(download == "" || download == null){
				$('#alertModal').modal('show');
			}else{
            $('#downloadModal').modal('show');
			}
            // $('#downloadModal').modal('show');
        });
        $('#rejectCard').click(function () {
			var rejectCard = $('#rejectCard').val();
			if(rejectCard == "" || rejectCard == null){
				$('#alertModal').modal('show');
			}else{
			$('#deactivateReason2').val("");
            $('#deactivateReason2').show();
            $('#deactivateNoReason1').attr('checked', false);
            $('#confirmmodel1').modal('show');
			}
        });
        $('#reject').click(function () {
			var reject = $('#reject').val();
			if(reject == "" || reject == null){
				$('#alertModal').modal('show');
			}else{
           $('#deactivateReason').val("");
            $('#deactivateReason').show();
            $('#deactivateNoReason').attr('checked', false);
            $('#confirmmodel').modal('show');
			}
			
        }); 


        $("#approveCardConfirm").click(function () {
            var id = '<?php echo $cid; ?>';
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Customer/approveSIICard",
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    if (result.flag == 0) {
                        $('#approveCardModel').modal('hide');
                        $('#errorModal').modal('show');
                        $('#errorCardText').text('SII card approved successfully');
                    } else {
                        $('#approveCardModel').modal('hide');
                        $('#errorModal').modal('show');
                        $('#errorCardText').text('Failed !');
                    }
                },
                error: function () {

                    $('#errorModal').modal('show');
                    $('#errorCardText').text('Problem occurred please try again.');

                },
            });
        });

        $('#SaveOk').click(function () {
            window.location.href = "<?php echo base_url() ?>index.php?/customer";
        });
        $('#SIIOk').click(function () {
            location.reload();
        });
        $('#MMJOk').click(function () {
            location.reload();
        });
        $("#approveConfirm").click(function () {
            var id = '<?php echo $cid; ?>';
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Customer/approveMMJCard",
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    if (result.flag == 0) {
                        $('#approveModal').modal('hide');
                        $('#errorModal').modal('show');
                        $('#errorCardText').text('MMJ card approved successfully');
                    } else {
                        $('#approveModal').modal('hide');
                        $('#errorModal').modal('show');
                        $('#errorCardText').text('Failed !');
                    }
                },
                error: function () {

                    $('#errorModal').modal('show');
                    $('#errorCardText').text('Problem occurred please try again.');

                },
            });
        });


        $("#confirmed").click(function () {
            var id = '<?php echo $cid; ?>';
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Customer/rejectMMJCard",
                type: "POST",
                data: {id: id, reason: $('.reason').val()},
                dataType: "JSON",
                success: function (result) {
                    if (result.flag == 0) {
                        $('#confirmmodel').modal('hide');
                        $('#errorModal').modal('show');
                        $('#errorCardText').text('MMJ card successfully rejected!');
                    } else {
                        $('#confirmmodel').modal('hide');
                        $('#errorModal').modal('show');
                        $('#errorCardText').text('Failed !');
                    }
                },
                error: function () {

                    $('#errorModal').modal('show');
                    $('#errorCardText').text('Problem occurred please try again.');

                },
            });
        });


        $("#confirmed1").click(function () {
            var id = '<?php echo $cid; ?>';
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Customer/rejectSIICard",
                type: "POST",
                data: {id: id, reason: $('.reason').val()},
                dataType: "JSON",
                success: function (result) {
                    if (result.flag == 0) {
                        $('#confirmmodel1').modal('hide');
                        $('#errorModal').modal('show');
                        $('#errorCardText').text('SII card successfully rejected!');
                    } else {
                        $('#confirmmodel1').modal('hide');
                        $('#errorModal').modal('show');
                        $('#errorCardText').text('Failed !');
                    }
                },
                error: function () {

                    $('#errorModal').modal('show');
                    $('#errorCardText').text('Problem occurred please try again.');

                },
            });
        });

        $('#downloadConfirm').click(function () {
            $('#downloadModal').modal('hide');
        });


        $('#downloadCardConfirm').click(function () {
            $('#downloadCardModal').modal('hide');
        });



        $('#uploadConfirm').click(function () {
            var form_data1 = new FormData();
            var form_data = new FormData();
            var id = '<?php echo $cid; ?>';
            var card = $('#cardUpload').prop('files')[0];
            form_data.append('OtherPhoto', card);
            var fileName = card.name;
            form_data1.append('id', id);
            form_data.append('type', 'uploadImage');
            form_data.append('Image', 'Image');
            form_data.append('folder', 'customer_certificates');
            var imgUrl = '';
            $.ajax({
                url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                type: "POST",
                data: form_data,
                dataType: "JSON",
                success: function (result) {
                    if (result.msg == '1') {
                        imgUrl = result.fileName;
                        form_data1.append('mmjImage', imgUrl);
                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php?/Customer/uploadMMJCard",
                            type: "POST",
                            data: form_data1,
                            dataType: "JSON",
                            processData: false,
                            contentType: false,
                            success: function (result) {
                                if (result.flag == 0) {
                                    $('#uploadModal').modal('hide');
                                    $('#errorModalMMJ').modal('show');
                                    $('#errorCardTextMMJ').text('MMJ card successfully uploaded!');
                                } else {
                                    $('#uploadModal').modal('hide');
                                    $('#errorModal').modal('show');
                                    $('#errorCardText').text('Failed !');
                                }
                            },
                            error: function () {

                                $('#errorModal').modal('show');
                                $('#errorCardText').text('Problem occurred please try again.');

                            },
                        });
                    } else {
                        alert('Problem In Uploading Image-' + result.folder);
                    }
                },
                cache: false,
                contentType: false,
                processData: false

            });
        });
        $('#uploadCardConfirm').click(function () {
            var form_data1 = new FormData();
            var form_data = new FormData();
            var id = '<?php echo $cid; ?>';
            var card = $('#cardUpload1').prop('files')[0];
            form_data.append('OtherPhoto', card);
            var fileName = card.name;
            form_data1.append('id', id);
            form_data.append('type', 'uploadImage');
            form_data.append('Image', 'Image');
            form_data.append('folder', 'customer_certificates');
            var imgUrl = '';
            $.ajax({
                url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                type: "POST",
                data: form_data,
                dataType: "JSON",
                success: function (result) {
                    if (result.msg == '1') {
                        imgUrl = result.fileName;
                        form_data1.append('idImage', imgUrl);
                        $.ajax({
                            url: "<?php echo base_url(); ?>index.php?/Customer/uploadSIICard",
                            type: "POST",
                            data: form_data1,
                            dataType: "JSON",
                            processData: false,
                            contentType: false,
                            success: function (result) {
                                if (result.flag == 0) {
                                    $('#uploadCardModal').modal('hide');
                                    $('#errorModalSII').modal('show');
                                    $('#errorCardTextSII').text('SII card successfully uploaded!');
                                } else {
                                    $('#uploadCardModal').modal('hide');
                                    $('#errorModal').modal('show');
                                    $('#errorCardText').text('Failed !');
                                }
                            },
                            error: function () {

                                $('#errorModal').modal('show');
                                $('#errorCardText').text('Problem occurred please try again.');

                            },
                        });
                    } else {
                        alert('Problem In Uploading Image-' + result.folder);
                    }
                },
                cache: false,
                contentType: false,
                processData: false

            });
        });

        $("#frm_mobile").intlTelInput("setNumber", '<?php echo $data['countryCode']; ?>' + ' ' + '<?php echo $data['phone']; ?>');
        $("#frm_mobile").on("countrychange", function (e, countryData) {

            $("#coutryCode").val('+'+countryData.dialCode);
            $("#countryCode").val('+'+countryData.dialCode);
        });

        var radius = '<?php echo $data['radius']; ?>';
        $("#radius").val(radius);
        var profileStatus = '<?php echo $data['profileStatus']; ?>';
        if (profileStatus == 1)
            $('#cmn-toggle-1').attr('checked', true);


        $('#save_driver_details').click(function () {
            $('.form-group').removeClass('has-error');
            var fname = $('#frm_fname').val();
            var dob = $('#frm_dob').val();
            var approvedDate = $('#approvedDate').val();
            var email = $('#frm_email').val();
            var mobile = $('#frm_mobile').val();
            var countryCode = $("#coutry-code").val();
            if (fname == '') {
                $('#frm_fname').closest('.form-group').addClass('has-error');
                return;
            } else if (email == '') {
                $('#frm_email').closest('.form-group').addClass('has-error');
                return;
            } else if (mobile == '' || $('#frm_mobile').attr('data') == 1) {
                $('#frm_mobile').closest('.form-group').addClass('has-error');
                return;
            } else {
                $.ajax({
                    url: "index.php?/customer/save_driver_data",
                    type: "POST",
                    data: $('#form_driver_pro').serialize(),
                    dataType: "JSON",
                    success: function (result) {
                        if (result.flag == 0) {
                            $('#errorModalSave').modal('show');
                            $('#errorCardTextSave').text('Profile successfully saved!');
                        } else {
                            $('#errorModal').modal('show');
                            $('#errorCardText').text('Failed !');
                        }
                    },
                    error: function () {

                        $('errorModal').modal('show');
                        $('#errorCardText').text('Problem occurred please try again.');

                    },
                });
            }
        });

    });
</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <ul class="breadcrumb" style="margin-left: 0px;margin-top: 5%;">
        <li><a href="<?php echo base_url(); ?>index.php?/customer" class="">CUSTOMER</a>
        </li>

        <li><a href="#" class="active"><?php echo $data['name']; ?></a>
        </li>
    </ul>
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="inner">

            </div>

            <div class="container-fluid container-fixed-lg">

                <div id="rootwizard" class="m-t-50">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  bg-white whenclicked" id="mytabs">
                        <!--                        <li class="active tabs_active" id="firstlitab">
                                                    <a href="#summary" data-toggle="tab" role="tab" aria-expanded="true">Summary</a>
                                                </li>-->
                        <li class="tabs_active active" id="secondlitab">
                            <a href="#profile" data-toggle="tab" role="tab" aria-expanded="true">Profile</a>
                        </li>
                        <!--                        <li class="tabs_active" id="thirdlitab">
                                                   <a href="#trips" data-toggle="tab" role="tab" aria-expanded="true">Trips</a>
                                                </li>
                                                <li class="tabs_active" id="fourthlitab">
                                                    <a href="#adjustment" data-toggle="tab" role="tab" aria-expanded="true">Adjustment History</a>
                                                </li>
                        
                                                <li class="tabs_active" id="fifthlitab">
                                                    <a href="#historyNotification" data-toggle="tab" role="tab" aria-expanded="true">Notification History</a>   
                                                </li>-->
                        <button type="button" class="pull-right btn btn-success  cls111" id="save_driver_details">Save</button>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div class="tab-pane slide-left active" id="profile">

                            <form id="form_driver_pro">

                                <!--<input type="hidden" id="coutryCode" name="coutry-code" value="">-->
                                <div class="row">
                                    <div class="panel panel-default" style="width: 98%; margin-left: 1%; ">
                                       

                                        <input type="hidden" name="ci_csrf_token" value="">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-3 text-center bold" style="    font-weight: bold !important;
                                                     color: black;
                                                     font-size: 13px;
                                                     padding: 8px;">
                                                    <div class="row m-b-10">
                                                        <img style="-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);width:175px;height: 175px;" class="img-circle" src="<?php echo $data['profilePic']; ?>" onerror="this.src = '<?php echo base_url() . '../../pics/user.jpg' ?>'">
                                                    </div>                                                   
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <div class="form-group required">
                                                                <label>Name <span class="text-danger">*</span></label>
                                                                <input type="text" required="" class="form-control" name="fdata[name]" value="<?php echo $data['name']; ?>" id="frm_fname">
                                                            </div>
                                                        </div>

                                                      
                                                        <div class="col-sm-3">
                                                            <div class="form-group required">
                                                                <label>Joining Date <span class="text-danger">*</span></label>
                                                                <input type="text" readonly="true" required="" class="form-control" name="createdDate" value="<?php echo date('F  d, Y h:i:s A', $data['createdDate']) ?>" >
                                                            </div>
                                                        </div>
                                                        


                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label>Email </label>
                                                                <input type="text" required="" class="form-control" name="fdata[email]" value="<?php echo $data['email']; ?>" id="frm_email" onblur="ValidateFromDb()">
                                                                <input type="hidden" name="old_email" value="<?php echo $data['email']; ?>" id="old_email">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 ">
                                                            <div class="form-group required">
                                                                <label>Mobile <span class="text-danger">*</span></label>
                                                                <input type="tel" required="" class="form-control classRight"  maxlength="15" name="fdata[phone]" value="<?php echo $data['phone']; ?>" id="frm_mobile" onkeypress="return isNumberKey(event)" >
                                                                <input type="hidden" name="old_mobile" value="<?php echo $data['phone']; ?>" id="old_mobile">
                                                                <input type="hidden" name="fdata[countryCode]" value="<?php echo $data['countryCode']; ?>" id="coutryCode">
                                                                
                                                            </div>
                                                            <input type="hidden" name="fdata['countryCode']" value="<?php echo $data['countryCode']; ?>" id="countryCode">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <input type="hidden" name="mas_id" value="<?php echo $cid; ?>">

                                                    </div>

                                                </div>
                                            </div>
                                        </div> 


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="panel panel-default" style="width: 98%; margin-left: 1%; ">


                                        <input type="hidden" name="ci_csrf_token" value="">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <label>Total No Of Orders</label>
                                                                <input type="text" id="totalOrders" class="form-control" name="totalOrders" disabled="disabled" value="<?php echo $data['orders']['ordersCount']; ?>"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <label>Total Ordered Value</label>
                                                                <input type="text" id="totalOrderValue" class="form-control" name="totalOrders"  disabled="disabled" value="<?php echo $data['orders']['ordersAmount']; ?>"/>

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-2" style="display:none">
                                                            <div class="form-group">
                                                                <label>Total amount paid</label>
                                                                <input type="text" id="totalAmountPaid" class="form-control" name="totalOrders" value="0" disabled="disabled" value="<?php echo $data['totalAmountPaid']; ?>"/>
                                                            </div>
                                                        </div>
                                                       

                                                    </div>

                                                </div>
                                                <div class="col-sm-4">

                                                </div>

                                            </div>

                                        </div> 


                                    </div>
                                </div>


                                <div class="col-sm-12" style="display:none">
                                    <div class="col-sm-6">
                                        <div class="panel panel-default" style="width: 100%; margin-left: 1%; ">

                                            <div class="panel-body">
                                                <div class="col-sm-3 text-center bold" style="font-weight: bold !important;color: black;font-size: 13px;padding: 8px;">
                                                    <div class="row m-b-10">
                                                        <img style="-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);width:125px;height: 125px;" class="img-thumbnail" src="<?php echo $data['identityCard']['url']; ?>" onerror="this.src = '<?php echo base_url(); ?>/pics/idcardSymbol.png ' ">
                                                    </div>

                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="row"><span class="headerText"> State Issued ID</span></div>
                                                    <div class="row" style="margin-top: 5px;">
                                                        <div class="col-sm-6">

                                                            <button type="button" value="<?php echo $data['identityCard']['url']; ?>" class="pull-right btn btn-success btnClass cls111 " id="approveCard">Approve</button>

                                                        </div>

                                                        <div class="col-sm-6">
                                                            <button type="button" value="<?php echo $data['identityCard']['url']; ?>" class="pull-right btn btn-danger  cls111" id="rejectCard">Reject</button>
                                                        </div>


                                                    </div>
                                                    <div class="row" style="margin-top: 5px;">

                                                        <div class="col-sm-6">
                                                            <button type="button" class="pull-right btn btn-primary  cls111" id="uploadCard">Upload</button>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <button type="button" value="<?php echo $data['identityCard']['url']; ?>" class="pull-right btn btn-info  cls111" id="downloadCard">Download</button>
                                                        </div>

                                                    </div>



                                                </div>
                                            </div> 


                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="panel panel-default" style="width: 100%; margin-left: 1%; ">

                                            <div class="panel-body">
                                                <div class="col-sm-3 text-center bold" style=" font-weight: bold !important;color: black;font-size: 13px;padding: 8px;">
                                                    <div class="row m-b-10">
                                                        <img style="-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);width:125px;height: 125px;" class="img-thumbnail" src="<?php echo $data['mmjCard']['url']; ?>" onerror="this.src = '<?php echo base_url(); ?>/pics/idcardSymbol.png '">
                                                    </div>

                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="row"><span class="headerText">Medical Marijuana Card</span>     </div>
                                                    <div class="row"></div>
                                                    <div class="row"></div>
                                                    <div class="row" style="margin-top:5px;">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <button type="button" class="pull-right btn btn-primary  btnClass cls111" value="<?php echo $data['mmjCard']['url']; ?>" id="approve">Approve</button>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <button type="button" class="pull-right btn btn-danger  cls111" value="<?php echo $data['mmjCard']['url']; ?>" id="reject">Reject</button>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="margin-top: 5px;">
                                                            <div class="col-sm-6">
                                                                <button type="button" class="pull-right btn btn-primary  cls111" id="upload">Upload</button>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <button type="button" class="pull-right btn btn-info  cls111" value="<?php echo $data['mmjCard']['url']; ?>" id="download">Download</button>
                                                            </div>
                                                        </div>

                                                    </div>



                                                </div>
                                            </div> 


                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>

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
<script src="<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/intlTelInput.js"></script>

<script>
                                                                    var countryData = $.fn.intlTelInput.getCountryData();
                                                                    $.each(countryData, function (i, country) {

                                                                        country.name = country.name.replace(/.+\((.+)\)/, "$1");
                                                                    });
                                                                    $("#frm_mobile").intlTelInput({
//       allowDropdown: false,
                                                                        autoHideDialCode: false,
                                                                        autoPlaceholder: "off",
                                                                        dropdownContainer: "body",
//       excludeCountries: ["us"],
                                                                        formatOnDisplay: false,
                                                                        geoIpLookup: function (callback) {
                                                                            $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                                                                                var countryCode = (resp && resp.country) ? resp.country : "";
                                                                                callback(countryCode);
                                                                            });
                                                                        },
                                                                        initialCountry: "auto",
                                                                        nationalMode: false,
//       onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                                                                        placeholderNumberType: "MOBILE",
//       preferredCountries: ['srilanka'],
                                                                        separateDialCode: true,
                                                                        utilsScript: "<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/utils.js",

                                                                    });




</script>


<div class="modal fade stick-up" id="errorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorCardText"></div>


                </div>

                <br/>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" >
                            <button type="button" data-dismiss="modal" class="btn btn-primary">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="errorModalSave" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorCardTextSave"></div>


                </div>

                <br/>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" >
                            <button type="button"  class="btn btn-primary" id="SaveOk">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="errorModalMMJ" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorCardTextMMJ"></div>


                </div>

                <br/>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary" id="MMJOk">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="errorModalSII" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorCardTextSII"></div>


                </div>

                <br/>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary" id="SIIOk">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<div class="modal fade stick-up" id="uploadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Upload Certificate</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">


                    <label class="col-sm-3">Upload Certificate</label>
                    <input type="file" class="form-control error-box-class col-sm-9"  name="cardUpload" id="cardUpload"  placeholder=""></div>

            </div>


            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary " id="uploadConfirm">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="downloadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Download Certificate</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box modalPopUpText">Are you sure you want to download the MMJ card?</div>

                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <a download="mmjCard.jpg" href="<?php echo $data['mmjCard']['url']; ?>" title="mmjCard"><button type="button" class="btn btn-info" id="downloadConfirm">Download</button></a>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="approveModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Approve Certificate</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box modalPopUpText">Are you sure you want to approve the MMJ card?</div>

                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-info" id="approveConfirm">Approve</button></a>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="">
                <span class="modal-title" style="color:#337ab7;">Reject Card</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="inactiveData">Are you sure you want to reject the MMJ card?</div>
                    <div class="row">
                        <label id="reasonLabel" style="margin-left:20px;">Reason</label>
                        <input style="margin-left:20px;width: 90% !important;" type="text" id="deactivateReason" name="deactivateReason" class="form-control reason"/>
                    </div>
                    <div class="row"></div>
                    <div class="row">

                        <input style="margin-left:20px;" type="checkbox" id="deactivateNoReason" name="deactivateNoReason" class="reason"/>
                        <label>Do not prefer to specify the reason..!!</label>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                        <button type="button" class="btn btn-warning pull-right" id="confirmed" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>






<div class="modal fade stick-up" id="uploadCardModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Upload Card</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">


                    <label class="col-sm-3">Upload Certificate</label>
                    <input type="file" class="form-control error-box-class col-sm-9"  name="cardUpload1" id="cardUpload1"  placeholder=""></div>

            </div>


            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary " id="uploadCardConfirm">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="downloadCardModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Download Card</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box modalPopUpText">Are you sure you want to download the SII card?</div>

                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <a download="SIICard.jpg" href="<?php echo $data['identityCard']['url']; ?>" title="SIICard"><button type="button" class="btn btn-info" id="downloadCardConfirm">Download</button></a>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="approveCardModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Approve Card</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box modalPopUpText">Are you sure you want to approve the SII card?</div>

                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-info" id="approveCardConfirm">Approve</button></a>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade stick-up" id="alertModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box modalPopUpText">Please upload the card...</div>

                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                       
						<button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="alertConfirm">OK</button>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="confirmmodel1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="">
                <span class="modal-title" style="color:#337ab7;">Reject Card</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="inactiveData">Are you sure you want to reject the SII card?</div>
                    <div class="row">
                        <label id="reasonLabel1" style="margin-left:20px;">Reason</label>
                        <input style="margin-left:20px;width: 90% !important;" type="text" id="deactivateReason2" name="deactivateReason2" class="form-control reason"/>
                    </div>
                    <div class="row"></div>
                    <div class="row">

                        <input style="margin-left:20px;" type="checkbox" id="deactivateNoReason1" name="deactivateNoReason1" class="reason"/>
                        <label>Do not prefer to specify the reason..!!</label>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                        <button type="button" class="btn btn-warning pull-right" id="confirmed1" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>