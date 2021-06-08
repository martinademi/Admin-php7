<link href="application/views/vehicleSettings/vehicleTypes/styles.css" rel="stylesheet" type="text/css">
<style>
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('<?php echo base_url(); ?>pics/pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
        opacity: .8;
    }
    #divLoading
    {
        display : block;
        position : fixed;
        z-index: 100;
        background-image : url('<?php echo base_url(); ?>pics/pageLoader.gif');
        background-color:#666;
        opacity : 0.4;
        background-repeat : no-repeat;
        background-position : center;
        left : 0;
        bottom : 0;
        right : 0;
    }
</style>
<script>
    var idNum = 0;
    var expanded = false;
    var expanded1 = false;


    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }

    function showSpecialType() {
        var checkboxes = document.getElementById("specialTypeCheckboxDiv");
        if (!expanded1) {
            checkboxes.style.display = "block";
            expanded1 = true;
        } else {
            checkboxes.style.display = "none";
            expanded1 = false;
        }
    }

    //Remove good types when click on close symbol
    function RemoveMore(Id)
    {
        $('#RemoveControl' + Id).remove();

    }

    $(document).ready(function () {
        $(".loader").fadeOut("slow");
        $('.tabs_active').click(function () {

            var currentTab = $('.tabs_active.active').attr('id');

            switch (currentTab) {
                case 'firstlitab':
                    var firstTabData = $("#firstTabForm").valid();
                    if (firstTabData) {

                        var nextTab = $(this).attr('id');
                        switch (nextTab) {
                            case 'secondlitab':
                                $("#firstlitab").removeClass("active");
                                $("#tab1").removeClass("active");

                                $("#secondlitab").addClass("active");
                                $("#tab2").addClass("active");
                                $(".nextButton").removeClass("hidden");
                                break;
                            case 'thirdlitab':
                                var secondTabData = $("#secondTabForm").valid();
                                if (secondTabData) {
                                    $("#tab2icon").addClass("fs-14 fa fa-check");
                                    $("#prevbutton").removeClass("hidden");
                                    $("#finishbutton").removeClass("hidden");

                                    $("#firstlitab").removeClass("active");
                                    $("#tab1").removeClass("active");

                                    $("#thirdlitab").addClass("active");
                                    $("#tab3").addClass("active");
                                } else
                                {
                                    return false;
                                }
                                break;
                        }

                    } else
                    {
                        return false;
                    }
                    break;
                case 'secondlitab':
                    var nextTab = $(this).attr('id');
                    switch (nextTab) {
                        case 'firstlitab':
                            $("#secondlitab").removeClass("active");
                            $("#tab2").removeClass("active");
                            $("#firstlitab").addClass("active");
                            $("#tab1").addClass("active");
                            $(".nextButton").removeClass("hidden");
                            break;
                        case 'thirdlitab':
                            var secondTabData = $("#secondTabForm").valid();
                            if (secondTabData) {
                                $("#tab2icon").addClass("fs-14 fa fa-check");
                                $("#prevbutton").removeClass("hidden");
                                $("#finishbutton").removeClass("hidden");

                                $("#secondlitab").removeClass("active");
                                $("#tab2").removeClass("active");

                                $("#thirdlitab").addClass("active");
                                $("#tab3").addClass("active");
                            } else
                            {
                                return false;
                            }
                    }
                    break;
                case 'thirdlitab':

                    var nextTab = $(this).attr('id');
                    switch (nextTab) {
                        case 'firstlitab':
                            $("#thirdlitab").removeClass("active");
                            $("#tab3").removeClass("active");
                            $("#firstlitab").addClass("active");
                            $("#tab1").addClass("active");
                            $(".nextButton").removeClass("hidden");
                            break;
                        case 'secondlitab':
                            $("#thirdlitab").removeClass("active");
                            $("#tab3").removeClass("active");
                            $("#secondlitab").addClass("active");
                            $("#tab2").addClass("active");
                            $(".secondNextButton").removeClass("hidden");
                            $("#prevbutton").removeClass("hidden");
                            break;
                    }
                    break;
            }

        });


        //Click on prevoius button
        $('.prevbutton').click(function () {

            var currentTab = $('.tabs_active.active').attr('id');

            switch (currentTab) {

                case 'secondlitab':
                    $("#secondlitab").removeClass("active");
                    $("#tab2").removeClass("active");
                    $("#firstlitab").addClass("active");
                    $("#tab1").addClass("active");
                    $(".nextButton").removeClass("hidden");
                    break;

                case 'thirdlitab':
                    $("#thirdlitab").removeClass("active");
                    $("#tab3").removeClass("active");
                    $("#secondlitab").addClass("active");
                    $("#tab2").addClass("active");
                    $(".secondNextButton").removeClass("hidden");

                    break;
            }

        });


        //Click on next button
        $('.nextButton').click(function () {
            if ($("#firstTabForm").valid() == true)
            {

//                $('#type_map_image-error').hide();
//                if ($('#specialTypeInputValue').val() == 0 && $('#type_map_image').val() == '')
//                {
//                    $('#type_map_image-error').show();
//                }
                if ($('#goodTypesSelectedCount').val() == '' || $('#goodTypesSelectedCount').val() == 0)
                {

                } else {
                    $("#tab1icon").addClass("fs-14 fa fa-check");
                    $("#prevbutton").removeClass("hidden");

                    $("#firstlitab").removeClass("active");
                    $("#tab1").removeClass("active");

                    $("#secondlitab").addClass("active");
                    $("#tab2").addClass("active");
                }

            }
        })
        $('.secondNextButton').click(function () {
            if ($("#secondTabForm").valid() == true)
            {

//                $("#tab2icon").addClass("fs-14 fa fa-check");
//                $("#prevbutton").removeClass("hidden");
//                $("#finishbutton").removeClass("hidden");
//
//                $("#secondlitab").removeClass("active");
//                $("#tab2").removeClass("active");
//
//                $("#thirdlitab").addClass("active");
//                $("#tab3").addClass("active");
                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/insert_vehicletype",
                    type: "POST",
                    data: $('form').serialize(),
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);

                        if (result.errorCode == 0)
                            window.location = "<?php echo base_url('index.php?/vehicle') ?>/vehicle_type";
                        else
                            alert(result.msg);
                    }
                });

            }
        })
        $('.finishButton').click(function () {
            if ($("#thirdTabForm").valid() == true)
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/insert_vehicletype",
                    type: "POST",
                    data: $('form').serialize(),
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);

                        if (result.errorCode == 0)
                            window.location = "<?php echo base_url('index.php?/vehicle') ?>/vehicle_type";
                        else
                            alert(result.msg);
                    }
                });
            }
        })

        $("#firstTabForm").validate({
            // Specify validation rules

            rules: {
                vehicletypename: {
                    required: true,
                    alphanumeric: true,
                },
                vehicle_length: {
                    required: true
                },
                vehicle_width: {
                    required: true
                },
                vehicle_height: {
                    required: true
                },
                vehicle_capacity: {
                    required: true
                },
//                bookingType: {
//                    required: true
//                },

                onImageAWS: {
                    required: true
                },
                offImageAWS: {
                    required: true
                }
            },

            // Specify validation error messages
            messages: {
                vehicletypename: {
                    alphanumeric: "Please enter valid vehicle type name",
                }
            }
        });

        $(".nextButton").click(function () {

            if ($('.checkbox1:checked').length == 0) {
                $('#goodType-error').text('This field is required.');
                $('#goodType-error').show();
            } else
                $('#goodType-error').hide();
        });



        $("#thirdTabForm").validate({
            // Specify validation rules
            rules: {
                bookingType: {
                    required: true,
                },
                baseFare: {
                    required: true,
                },
                mileage: {
                    required: true
                },
                mileage_after_x_km_mile: {
                    required: true
                },
                price_after_x_minutesTripDuration: {
                    required: true
                }
                , x_minutesTripDuration: {
                    required: true
                }
                , price_after_x_minWaiting: {
                    required: true
                }
                , x_minutesWaiting: {
                    required: true
                }
                , price_MinimumFee: {
                    required: true
                }
                , price_after_x_minCancel: {
                    required: true
                }
                , x_minutesCancel: {
                    required: true
                }
                , price_after_x_minCancelScheduledBookings: {
                    required: true
                }
                , x_minutesCancelScheduledBookings: {
                    required: true
                }
            }
        });
        $("#secondTabForm").validate({
            // Specify validation rules
            rules: {
                bookingType: {
                    required: true,
                },
                seatingCapacity: {
                    required: true,
                },
                ride_baseFare: {
                    required: true,
                },
                ride_mileage: {
                    required: true
                },
                ride_mileage_after_x_km_mile: {
                    required: true
                },
                ride_price_after_x_minutesTripDuration: {
                    required: true
                }
                , ride_x_minutesTripDuration: {
                    required: true
                }
                , ride_price_after_x_minWaiting: {
                    required: true
                }
                , ride_x_minutesWaiting: {
                    required: true
                }
                , ride_price_MinimumFee: {
                    required: true
                }
                , ride_price_after_x_minCancel: {
                    required: true
                }
                , ride_x_minutesCancel: {
                    required: true
                }
                , ride_price_after_x_minCancelScheduledBookings: {
                    required: true
                }
                , ride_x_minutesCancelScheduledBookings: {
                    required: true
                }
            }
        });
        $.validator.addMethod("alphanumeric", function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
        });


        $('.checkbox1').click(function ()
        {
            if ($('[name="goodType[]"]:checked').length == 0)
            {//goodTypesBox
                $('.goodTypesBox').hide();
                $('#goodType-error').text('This field is required.');
                $('#goodType-error').show();
                $('#goodTypesSelectedCount').val('');
            } else
            {
                $('#goodTypesSelectedCount').val($('[name="goodType[]"]:checked').length);
                $('.goodTypesBox').show();
                $('#goodType-error').hide();
            }
            if ($(this).is(":checked"))
            {
                $('.selectedGoodType').append('<span class="selectedGood" id="RemoveControl' + $(this).attr('id') + '"><input readonly  class="inputDesc" type="text"  value="' + $(this).attr('goodType') + '"><input type="button" value="&#10008" data-id="' + $(this).attr('id') + '" class="RemoveMore">')
                $('#goodType').val($(this).attr('id'));
            } else {

                RemoveMore($(this).attr('id'));

            }
        });

        $('.specialType').click(function ()
        {
            if ($('[name="specialType[]"]:checked').length == 0)
            {
                $('#specialType-error').show();
                $('#specialType-error').text('This field is required.');
            } else
            {
                $('#specialType-error').hide();
            }

        });

        $('.bookingTypeDelivery').change(function () {
            if ($('input:checkbox.bookingTypeDelivery:checked').length > 1)
                $('.bookingTypeDeliverySelected').val('0');
            else
                $('.bookingTypeDeliverySelected').val($('.bookingTypeDelivery:checked').val());

            //Advance booking fee
            if ($('#bookALaterDelivery').is(':checked')) {
                $('.delieveryBookingAdvanceFeeDiv').show();
            } else
                $('.delieveryBookingAdvanceFeeDiv').hide();
        })

        $('.bookingType').change(function ()
        {

            if ($('input:checkbox.bookingType:checked').length > 1)
                $('#bookingTypeSelected').val('0');
            else
                $('#bookingTypeSelected').val($('input:checkbox.bookingType:checked').val());

            //Advance booking fee
            if ($('#bookALater').is(':checked')) {
                $('.rideBookingAdvanceFeeDiv').show();
            } else
                $('.rideBookingAdvanceFeeDiv').hide();
        });



        $('.isNumericValidation').keypress(function (event) {
            if (event.which < 44
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if ((event.which == 45 && $(this).val().indexOf('-') != -1) || (event.which == 46 && $(this).val().indexOf('.') != -1)) {
                event.preventDefault();
            } // prevent if already dot
        });

        $(document).on('click', '.RemoveMore', function ()
        {
            $('#' + $(this).attr('data-id')).attr('checked', false);
            $('#RemoveControl' + $(this).attr('data-id')).remove();


            if ($('[name="goodType[]"]:checked').length == 0)//goodTypesBox
            {
                $('.goodTypesBox').hide();
                $('#goodType-error').show();
                $('#goodType-error').text('This field is required.');
                $('#goodTypesSelectedCount').val('');

            } else
            {
                $('.goodTypesBox').show();
                $('#goodTypesSelectedCount').val($('[name="goodType[]"]:checked').length);
            }
        });


        //Files upload
        $(":file").on("change", function (e) {
            var selected_file_name = $(this).val();
            if (selected_file_name.length > 0) {


                var fieldID = $(this).attr('id');
                var ext = $(this).val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    $(this).val('');
                    alert('invalid extension..!   Please choose file type in (gif,png,jpg,jpeg)');
                } else
                {

                    var type;
                    var folderName;
                    switch ($(this).attr('id'))
                    {
                        case "type_on_image":
                            type = 1;
                            folderName = 'vehicleOnImages';
                            break;
                        case "type_off_image":
                            type = 2;
                            folderName = 'vehicleOffImages';
                            break;
                        default :
                            type = 3;
                            folderName = 'vehicleMapImages';

                    }

                    var formElement = $(this).prop('files')[0];
                    var form_data = new FormData();

                    form_data.append('OtherPhoto', formElement);
                    form_data.append('type', 'VehicleTypes');
                    form_data.append('folder', folderName);
                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/vehicle/uploadImage",
                        type: "POST",
                        data: form_data,
                        dataType: "JSON",
//                        async: false,
                        beforeSend: function () {
                            $(".loader").fadeIn("slow");
                        },
                        success: function (result) {
                            $(".loader").fadeOut("slow");

                            $('#' + fieldID + '-error').hide();
                            switch (type)
                            {
                                case 1:
                                    $('#type_on_image-error').hide();
                                    $('#onImageAWS').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                    $('.onImageAWS').show();
                                    $('.onImageAWS').attr('src', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                    break;
                                case 2:
                                    $('#offImageAWS').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                    $('.offImageAWS').show();
                                    $('.offImageAWS').attr('src', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                    break;
                                case 3:
                                    $('#mapImageAWS').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                    $('.mapImageAWS').show();
                                    $('.mapImageAWS').attr('src', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                    break;
                                default :
                                    '';

                            }

                        },
                        error: function () {

                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            } else {
//                alert('No file choosed');
            }

        });

    });


</script>
<?php
$currency = $appConfigData['currencySymbol'];
$mileageMetric = $appConfigData['mileage_metric'];
$weightMetric = $appConfigData['weight_metric'];
if ($mileageMetric == 0)
    $mileageMetric = 'Km';
else
    $mileageMetric = 'Mile';

if ($weightMetric == 0)
    $weightMetric = 'Kg';
else
    $weightMetric = 'Pound';
?>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <ul class="breadcrumb" style="margin-left: 0px;margin-top: 5%; ">
        <li><a href="<?php echo base_url('index.php?/vehicle') ?>/vehicle_type" class=""><?PHP ECHO LIST_VEHICLETYPE; ?></a>
        </li>

        <li ><a href="#" class="active"><?php echo strtoupper($operation); ?></a>
        </li>

    </ul>
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="bg-white" data-pages="parallax">

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">

                        <li class="active tabs_active" id="firstlitab">
                            <a data-toggle="tab" id="tb1" style="width:102%"><i id="tab1icon" class=""></i> <span><?php echo $this->lang->line('tab_vehicle_type_details'); ?></span></a>
                        </li>
                        <li class="tabs_active" id="secondlitab" >
                            <a data-toggle="tab" id="tb2"><i id="tab2icon" class=""></i> <span><?php echo $this->lang->line('tab_vehicle_ride_pricing'); ?></span></a>
                        </li>
                        <!--                        <li class="tabs_active" id="thirdlitab">
                                                    <a data-toggle="tab" id="tb3"><i id="tab3icon" class=""></i> <span><?php echo $this->lang->line('tab_vehicle_delivery_pricing'); ?></span></a>
                                                </li>-->


                    </ul>
                    <div class="loader" style="display: none;"></div>
                    <div id="divLoading" style="display:none;"></div>

                    <div class="tab-content">

                        <div class="tab-pane padding-20 slide-left active" id="tab1">
                            <form id="firstTabForm" method="post" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/vehicle/insert_vehicletype"  enctype="multipart/form-data">
                                <input type="hidden" name="goodTypesSelectedCount" id="goodTypesSelectedCount">
                                <div class="row row-same-height">



                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_type_name'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="vehicletypename" name="vehicletypename" class="form-control" required="" placeholder="Enter vehicle type name">
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicletype"></div>
                                    </div>

                                    <!--                                    <div class="form-group">
                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_length_of_vehicle'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                                            <div class="col-sm-6">
                                                                                <div class="col-sm-6">
                                                                                    <input type="text" id="vehicle_length" name="vehicle_length" class="form-control autonumeric" style="margin-left: -9px;" required="" placeholder="Enter length">
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="vehicle_length_metric">
                                                                                        <option value="M"><?php echo $this->lang->line('label_meter'); ?></option>
                                                                                        <option value="F"><?php echo $this->lang->line('label_feet'); ?></option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3 error-box" id="vehicle_lengthErr"></div>
                                                                        </div>
                                    
                                    
                                                                        <div class="form-group">
                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_width_of_vehicle'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                                            <div class="col-sm-6">
                                                                                <div class="col-sm-6">
                                                                                    <input type="text" id="vehicle_width" name="vehicle_width" class="form-control autonumeric" style="margin-left: -9px" required="" placeholder="Enter width">
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="vehicle_width_metric">
                                                                                        <option value="M"><?php echo $this->lang->line('label_meter'); ?></option>
                                                                                        <option value="F"><?php echo $this->lang->line('label_feet'); ?></option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3 error-box" id="vehicle_widthErr"></div>
                                    
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_height_of_vehicle'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                                            <div class="col-sm-6">
                                                                                <div class="col-sm-6">
                                                                                    <input type="text" id="vehicle_height" name="vehicle_height" class="form-control autonumeric" style="margin-left: -9px;" required="" placeholder="Enter height">
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <select class="form-control" style="height: 34px; font-size: 11px; display: block;  min-width: 85px;" name="vehicle_height_metric">
                                                                                        <option value="M"><?php echo $this->lang->line('label_meter'); ?></option>
                                                                                        <option value="F"><?php echo $this->lang->line('label_feet'); ?></option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3 error-box" id="vehicle_heightErr"></div>
                                    
                                                                        </div>
                                    
                                    
                                    
                                                                        <div class="form-group">
                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_load_bearing_capacity'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                                            <div class="col-sm-6 pos_relative">
                                    
                                                                                <div class="col-sm-6">
                                                                                    <input type="text" id="vehicle_capacity" name="vehicle_capacity" class="form-control autonumeric" style="margin-left:-9px" placeholder="Enter capacity">
                                                                                    <span class="abs_textT"><?php echo $this->lang->line('label_pound'); ?></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3 error-box" id="vehicle_capacityErr"></div>
                                    
                                                                        </div>
                                    
                                    -->                                                                        <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_choose_good_types'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <div class="multiselect">
                                                <div class="selectBox" onclick="showCheckboxes()">
                                                    <select class="form-control" name="goodTypeSelect">
                                                        <option><?php echo $this->lang->line('select_option'); ?></option>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>
                                                <div id="checkboxes"  style="overflow-x: scroll;max-height: 125px;    display: block;"> 
                                                    <?php
                                                    foreach ($speciality_data as $googType) {
                                                        ?>
                                                        <label for="<?php echo $googType['_id']['$oid']; ?>">
                                                            <input type="checkbox" class="checkbox1" name="goodType[]" id="<?php echo $googType['_id']['$oid']; ?>" goodType="<?php echo $googType['speciality']['en']; ?>" value="<?php echo $googType['_id']['$oid']; ?>"/><?php echo $googType['speciality']['en']; ?>
                                                        </label>
                                                        <?php
                                                    }
                                                    ?>

                                                </div>

                                            </div>
                                            <label id="goodType-error" class="error" style="display:none">This field is required.</label>
                                        </div>
                                        <div class="col-sm-3 error-box" id="goodTypeErr"></div>

                                    </div>
                                    <div class="form-group goodTypesBox" style="display:none;">
                                        <label for="address" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-6">
                                            <div class="selectedGoodType" style="border-style:groove;min-height: 70px;padding: 6px;"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_on_image'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="file" id="type_on_image" name="type_on_image" class="form-control" accept="image/*" required="">
                                            <input type="hidden" id="onImageAWS" name="onImageAWS" class="form-control" required="">

                                        </div>
                                        <div class="col-sm-1"><img src="" style="width: 35px;height:35px;display:none;" class="onImageAWS style_prevu_kit"></div>
                                        <div class="col-sm-3 error-box" id="type_on_imageErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_off_image'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="file" id="type_off_image" name="type_off_image" class="form-control" accept="image/*" required="">
                                            <input type="hidden" id="offImageAWS" name="offImageAWS" class="form-control" required="">
                                        </div>
                                        <div class="col-sm-1"><img src="" style="width: 35px;height:35px;display:none;" class="offImageAWS style_prevu_kit"></div>
                                        <div class="col-sm-3 error-box" id="type_off_imageErr"></div>

                                    </div>

                                    <div class="form-group mapIconDiv">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_map_icon'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="file" id="type_map_image" name="type_map_image" class="form-control" accept="image/*"  required="">
                                            <input type="hidden" id="mapImageAWS" name="mapImageAWS" class="form-control" required="">
                                        </div>
                                        <div class="col-sm-1"><img src="" style="width: 35px;height:35px;display:none;" class="mapImageAWS style_prevu_kit" ></div>
                                        <div class="col-sm-3 error-box" id="type_map_imageErr"></div>

                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_description'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="discrption" name="descrption" class="form-control" placeholder="Enter description">

                                        </div>
                                        <div class="col-sm-3 error-box" id="disc"></div>

                                    </div>

                                    <?php
                                    $activeLanguages = 0;
                                    foreach ($languages as $lang) {
                                        if ($lang['active'])
                                            $activeLanguages++;
                                    }
                                    if ($activeLanguages == 0) {
                                        ?>

                                        <div class="form-group"> 
                                            <div class="col-sm-9">
                                                <div class="pull-right m-t-10"> <button type="button"  id="next" class="btn btn-success btn-cons nextButton" style="margin-right: 0px;"><?php echo $this->lang->line('button_next'); ?></button></div>

                                            </div>
                                        </div> 
                                        <?php
                                    }
                                    ?>
                                </div> 
                                <?php
                                $langCounter = 1;

                                foreach ($languages as $lang) {
                                    if ($lang['active']) {
                                        ?>
                                        <hr>
                                        <div class="row row-same-height">
                                            <div class="form-group">
                                                <label for="address" class="col-sm-2 control-label"><strong style="color:#0090d9;font-size:11px;"><?php echo strtoupper($lang['name']) ?> (<?php echo $this->lang->line('optional') ?>) </strong></label>
                                            </div>
                                            <div class="form-group">
                                                <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_type_name'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                <div class="col-sm-6">
                                                    <input type="text" id="<?php echo $lang['name'] ?>_vehicletypename" name="<?php echo $lang['name'] ?>_vehicletypename" class="form-control" placeholder="Enter vehicle type name">
                                                </div>
                                                <div class="col-sm-3 error-box" id="<?php echo $lang['name'] ?>_vehicletype"></div>
                                            </div>

                                            <!--                                            <div class="form-group">
                                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_length_of_vehicle'); ?></label>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="col-sm-6">
                                                                                                    <input type="text" id="<?php echo $lang['name'] ?>_vehicle_length" name="<?php echo $lang['name'] ?>_vehicle_length" class="form-control autonumeric" style="margin-left: -9px;"  placeholder="Enter length">
                                                                                                </div>
                                                                                                                                                <div class="col-sm-2">
                                                                                                                                                    <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="<?php echo $lang['name'] ?>_vehicle_length_metric">
                                                                                                                                                        <option value="M"><?php echo $this->lang->line('label_meter'); ?></option>
                                                                                                                                                        <option value="F"><?php echo $this->lang->line('label_feet'); ?></option>
                                                                                                                                                    </select>
                                                                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-3 error-box" id="<?php echo $lang['name'] ?>_vehicle_lengthErr"></div>
                                                                                        </div>
                                            
                                            
                                                                                        <div class="form-group">
                                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_width_of_vehicle'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="col-sm-6">
                                                                                                    <input type="text" id="<?php echo $lang['name'] ?>_vehicle_width" name="<?php echo $lang['name'] ?>_vehicle_width" class="form-control autonumeric" style="margin-left: -9px" placeholder="Enter width">
                                                                                                </div>
                                                                                                                                                <div class="col-sm-2">
                                                                                                                                                    <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="<?php echo $lang['name'] ?>_vehicle_width_metric">
                                                                                                                                                        <option value="M"><?php echo $this->lang->line('label_meter'); ?></option>
                                                                                                                                                        <option value="F"><?php echo $this->lang->line('label_feet'); ?></option>
                                                                                                                                                    </select>
                                                                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-3 error-box" id="<?php echo $lang['name'] ?>_vehicle_widthErr"></div>
                                            
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_height_of_vehicle'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="col-sm-6">
                                                                                                    <input type="text" id="<?php echo $lang['name'] ?>_vehicle_height" name="<?php echo $lang['name'] ?>_vehicle_height" class="form-control autonumeric" style="margin-left: -9px;"  placeholder="Enter height">
                                                                                                </div>
                                                                                                                                                <div class="col-sm-2">
                                                                                                                                                    <select class="form-control" style="height: 34px; font-size: 11px; display: block;  min-width: 85px;" name="<?php echo $lang['name'] ?>_vehicle_height_metric">
                                                                                                                                                        <option value="M"><?php echo $this->lang->line('label_meter'); ?></option>
                                                                                                                                                        <option value="F"><?php echo $this->lang->line('label_feet'); ?></option>
                                                                                                                                                    </select>
                                                                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-3 error-box" id="<?php echo $lang['name'] ?>_vehicle_heightErr"></div>
                                            
                                                                                        </div>
                                            
                                                                                        <div class="form-group">
                                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_load_bearing_capacity'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                                                            <div class="col-sm-6 pos_relative">
                                            
                                                                                                <div class="col-sm-6">
                                                                                                    <input type="text" id="<?php echo $lang['name'] ?>_vehicle_capacity" name="<?php echo $lang['name'] ?>_vehicle_capacity" class="form-control autonumeric" style="margin-left:-9px" placeholder="Enter capacity">
                                                                                                    <span class="abs_textT"><?php echo $this->lang->line('label_pound'); ?></span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-3 error-box" id="<?php echo $lang['name'] ?>_vehicle_capacityErr"></div>
                                                                                        </div>-->

                                            <div class="form-group">
                                                <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_description'); ?></label>
                                                <div class="col-sm-6">
                                                    <input type="text" id="<?php echo $lang['name'] ?>_discrption" name="<?php echo $lang['name'] ?>_descrption" class="form-control" placeholder="Enter description">

                                                </div>
                                                <div class="col-sm-3 error-box" id="<?php echo $lang['name'] ?>_disc"></div>

                                            </div>

                                            <?php
                                            if ($activeLanguages == $langCounter) {
                                                ?>
                                                <div class="form-group"> 
                                                    <div class="col-sm-9">
                                                        <div class="pull-right m-t-10"> <button type="button"  id="next" class="btn btn-success btn-cons nextButton" style="margin-right: 0px;"><?php echo $this->lang->line('button_next'); ?></button></div>

                                                    </div>
                                                </div> 
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <?php
                                        $langCounter++;
                                    }
                                }
                                ?>
                            </form>
                        </div>
                        <div class="tab-pane padding-20 slide-left" id="tab3">
                            <form id="thirdTabForm" method="post" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/vehicle/insert_vehicletype"  enctype="multipart/form-data">
                                <div class="row row-same-height">

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_booking_type'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-4 row">
                                            <label for="bookNowDelivery">
                                                <input type="checkbox" class="bookingTypeDelivery" name="bookingType" id="bookNowDelivery"  value="1"/><span><?php echo $this->lang->line('label_book_now'); ?></span>
                                            </label>

                                            <label for="bookALaterDelivery">
                                                <input type="checkbox" class="bookingTypeDelivery" name="bookingType" id="bookALaterDelivery" value="2"/><span><?php echo $this->lang->line('label_book_later'); ?></span>
                                            </label>
                                        </div>
                                        <input type="hidden" class="bookingTypeDeliverySelected" name="bookingTypeDeliverySelected">
                                    </div>

                                    <div class="form-group delieveryBookingAdvanceFeeDiv" style="display:none;">
                                        <label for="address" class="col-sm-2 control-label">Fees for Booking in Advance<span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="advanceBookingFeeDelivery" name="advanceBookingFeeDelivery" class="form-control autonumeric" value="" required="" placeholder="Enter advance booking fee for book later">

                                        </div>
                                        <div class="col-sm-3 pos_relative2">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Base Fare<span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="baseFare" name="baseFare" class="form-control autonumeric" value="" required="" placeholder="Enter basefare">

                                        </div>
                                        <div class="col-sm-3 pos_relative2">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Mileage Price<span style="" class="MandatoryMarker"> *</span></label>


                                        <div class="input-group col-sm-3">
                                            <input type="text" id="mileage" name="mileage" class="form-control autonumeric" placeholder="Enter mileage price" value="" required="">

                                            <span class="abs_text1"><?php echo $currency; ?> / <?php echo $mileageMetric; ?></span>

                                        </div>

                                        <div class="col-sm-3 pos_relative2">
                                            <span class="abs_textLeft">After</span>
                                            <input type="text" id="mileage_after_x_km_mile" name="mileage_after_x_km_mile" class="form-control" required="" placeholder="Enter no of <?php echo $mileageMetric; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>                                                     
                                            <span class="abs_text Mileagemetric"><?php echo $mileageMetric; ?></span>
                                        </div>
                                        <div class="col-sm-3 error-box" id="mileageErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Time Fee<span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="price_after_x_minutesTripDuration" name="price_after_x_minutesTripDuration" class="form-control autonumeric" placeholder="Enter Price per Minute" value="" required="">

                                            <span class="abs_text1"><?php echo $currency; ?> / Min</span>
                                        </div>
                                        <div class="col-sm-3 pos_relative2"> 

                                            <span  class="abs_textLeft">After</span>
                                            <input type="text" id="x_minutesTripDuration" name="x_minutesTripDuration" class="form-control" placeholder="Enter Minutes" value="" required="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                            <span  class="abs_text">Minutes</span>
                                        </div>
                                        <div class="col-sm-3 error-box" id="price_after_x_minutesTripDurationErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Waiting Fee<span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="price_after_x_minWaiting" name="price_after_x_minWaiting" class="form-control autonumeric" placeholder="Enter Price per Minute" value="" required="">

                                            <span class="abs_text1"><?php echo $currency; ?> / Min</span>
                                        </div>
                                        <div class="col-sm-3 pos_relative2"> 

                                            <span  class="abs_textLeft">After</span>
                                            <input type="text" id="x_minutesWaiting" name="x_minutesWaiting" class="form-control" placeholder="Enter Minutes" value="" required="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                            <span  class="abs_text">Minutes</span>
                                        </div>
                                        <div class="col-sm-3 error-box" id="price_after_x_minWaitingErr"></div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_MINIMUMFARE; ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="price_MinimumFee" name="price_MinimumFee" class="form-control autonumeric" placeholder="Enter minimum fare" value="" required="">

                                        </div>
                                        <div class="col-sm-3"> 

                                        </div>
                                        <div class="col-sm-3 error-box" id="price_MinimumFeeErr"></div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_ON_DEMAND_VEHICLETYPE_CANCILATIONFEE; ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="price_after_x_minCancel" name="price_after_x_minCancel" class="form-control autonumeric" placeholder="Enter Price" value="" required="">


                                        </div>
                                        <div class="col-sm-3 pos_relative2"> 
                                            <span  class="abs_textLeft">After</span>
                                            <input type="text" id="x_minutesCancel" name="x_minutesCancel" class="form-control"  placeholder="Enter Minutes" value="" required="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                            <span  class="abs_text">Minutes</span>
                                        </div>
                                        <div class="col-sm-3 error-box" id="price_after_x_minCancelErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_SCHEDULED_VEHICLETYPE_CANCILATIONFEE; ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="price_after_x_minCancelScheduledBookings" name="price_after_x_minCancelScheduledBookings" class="form-control autonumeric" placeholder="Enter Price" value="" required="">

                                        </div>
                                        <div class="col-sm-3 pos_relative2"> 
                                            <input style="padding-left : 12px" type="text" id="x_minutesCancelScheduledBookings" name="x_minutesCancelScheduledBookings" class="form-control"   placeholder="Enter Minutes" value="" required="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>

                                            <span  class="abs_text">Minutes Before Pickup Time</span>
                                        </div>
                                        <div class="col-sm-3 error-box" id="price_after_x_minCancelScheduledBookingsErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Long Haul Enable/Disable</label>
                                        <div class="col-sm-2">

                                            <div class="switch">
                                                <input id="longHaulEnDis" name="longHaulEnDis" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                <label for="longHaulEnDis"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-9">
                                            <div class="pull-right m-t-10"> <button type="button"  id="addVehicleType" class="btn  btn-primary btn-cons finishButton" style="margin-right: 0px;"><?php echo BUTTON_ADD_COMPANY; ?></button></div>
                                            <div class="pull-right m-t-10"> <button type="button"  class="btn btn-default btn-cons prevbutton"><?php echo BUTTON_PREVIOUS; ?></button></div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <!--  Start Third Tab -->
                        <div class="tab-pane padding-20 slide-left" id="tab2">
                            <form id="secondTabForm" method="post" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/vehicle/insert_vehicletype"  enctype="multipart/form-data">
                                <div class="row row-same-height">

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_booking_type'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 row">
                                            <label for="bookNow">
                                                <input type="checkbox" class="bookingType" name="bookingType" id="bookNow"  value="1"/><span><?php echo $this->lang->line('label_book_now'); ?></span>

                                            </label>

                                            <label for="bookALater">
                                                <input type="checkbox" class="bookingType" name="bookingType" id="bookALater" value="2"/><span><?php echo $this->lang->line('label_book_later'); ?></span>
                                            </label>
                                        </div>
                                        <input type="hidden" name="bookingTypeSelected" id="bookingTypeSelected">
                                        <div class="col-sm-3 error-box" id="bookingTypeErr"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="seatingCapacity" class="col-sm-2 control-label">Seating Capacity<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" id="seatingCapacity" name="seatingCapacity" class="form-control" value="" placeholder="Enter seating capacity" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>

                                        </div>
                                        <div class="col-sm-3 error-box" id="seatingCapacityErr"></div>

                                    </div>
                                    <div class="form-group rideBookingAdvanceFeeDiv" style="display:none;">
                                        <label for="address" class="col-sm-2 control-label">Fees for Booking in Advance<span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="advanceBookingFeeRide" name="advanceBookingFeeRide" class="form-control autonumeric" value="" required="" placeholder="Enter advance booking fee for book later">

                                        </div>
                                        <div class="col-sm-3 pos_relative2">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ride_baseFare" class="col-sm-2 control-label">Base Fare<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="ride_baseFare" name="ride_baseFare" class="form-control autonumeric" value="" placeholder="Enter basefare">

                                        </div>
                                        <div class="col-sm-3 pos_relative2">
                                        </div>
                                        <div class="col-sm-3 error-box" id="ride_baseFareErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="ride_mileage" class="col-sm-2 control-label">Mileage Price<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="input-group col-sm-3">
                                            <input type="text" id="ride_mileage" name="ride_mileage" class="form-control autonumeric" placeholder="Enter mileage price" value="">
                                            <span class="abs_text1"><?php echo $currency; ?> / <?php echo $mileageMetric; ?></span>
                                        </div>

                                        <div class="col-sm-3 pos_relative2">
                                            <span class="abs_textLeft">After</span>
                                            <input style="padding-left : 50px" type="text" id="ride_mileage_after_x_km_mile" name="ride_mileage_after_x_km_mile" class="form-control" value="" placeholder="Enter no. of <?php echo $mileageMetric; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>  
                                            <span class="abs_text Mileagemetric"><?php echo $mileageMetric; ?></span>

                                        </div>
                                        <div class="col-sm-3 error-box" id="ride_mileageErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Time Fee<span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="ride_price_after_x_minutesTripDuration" name="ride_price_after_x_minutesTripDuration" class="form-control autonumeric" placeholder="Enter Price per Minute" value="">

                                            <span class="abs_text1"><?php echo $currency; ?> / Min</span>
                                        </div>
                                        <div class="col-sm-3 pos_relative2"> 

                                            <span  class="abs_textLeft">After</span>
                                            <input type="text" style="padding-left : 50px" id="ride_x_minutesTripDuration" name="ride_x_minutesTripDuration" class="form-control"  placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                            <span  class="abs_text">Minutes</span>
                                        </div>
                                        <div class="col-sm-3 error-box" id="ride_price_after_x_minutesTripDurationErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Waiting Fee<span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="ride_price_after_x_minWaiting" name="ride_price_after_x_minWaiting" class="form-control autonumeric" placeholder="Enter Price per Minute" value="">

                                            <span class="abs_text1"><?php echo $currency; ?> / Min</span>
                                        </div>
                                        <div class="col-sm-3 pos_relative2"> 

                                            <span  class="abs_textLeft">After</span>
                                            <input style="padding-left : 50px" type="text" id="ride_x_minutesWaiting" name="ride_x_minutesWaiting" class="form-control"   placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                            <span  class="abs_text">Minutes</span>
                                        </div>
                                        <div class="col-sm-3 error-box" id="ride_price_after_x_minWaitingErr"></div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_MINIMUMFARE; ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="ride_price_MinimumFee" name="ride_price_MinimumFee" class="form-control autonumeric"  placeholder="Enter minimum fare" value="">

                                        </div>
                                        <div class="col-sm-3"> 

                                        </div>
                                        <div class="col-sm-3 error-box" id="ride_price_MinimumFeeErr"></div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_ON_DEMAND_VEHICLETYPE_CANCILATIONFEE; ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="ride_price_after_x_minCancel" name="ride_price_after_x_minCancel" class="form-control autonumeric" placeholder="Enter Price" value="">

                                        </div>
                                        <div class="col-sm-3 pos_relative2"> 
                                            <span  class="abs_textLeft">After</span>
                                            <input style="padding-left : 50px" type="text" id="ride_x_minutesCancel" name="ride_x_minutesCancel" class="form-control"  placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                            <span  class="abs_text">Minutes</span>
                                        </div>
                                        <div class="col-sm-3 error-box" id="price_after_x_minCancelErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_SCHEDULED_VEHICLETYPE_CANCILATIONFEE; ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="ride_price_after_x_minCancelScheduledBookings" name="ride_price_after_x_minCancelScheduledBookings" class="form-control autonumeric" placeholder="Enter Price" value="">

                                        </div>
                                        <div class="col-sm-3 pos_relative2"> 
                                            <input style="padding-left : 12px" type="text" id="ride_x_minutesCancelScheduledBookings" name="ride_x_minutesCancelScheduledBookings" class="form-control"  placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>

                                            <span  class="abs_text">Minutes Before Pickup Time</span>
                                        </div>
                                        <div class="col-sm-3 error-box" id="ride_price_after_x_minCancelScheduledBookingsErr"></div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_drop_location_mandatory'); ?></label>
                                        <div class="col-sm-2">

                                            <div class="switch">
                                                <input id="isDropLocationMandatory" name="isDropLocationMandatory" class="cmn-toggle cmn-toggle-round" type="checkbox" checked="" style="display: none;">
                                                <label for="isDropLocationMandatory"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_is_meter_booking'); ?></label>
                                        <div class="col-sm-2">

                                            <div class="switch">
                                                <input id="isMeterBookingEnable" name="isMeterBookingEnable" class="cmn-toggle cmn-toggle-round" type="checkbox" checked="" style="display: none;">
                                                <label for="isMeterBookingEnable"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <div class="col-sm-9">
                                            <div class="pull-right m-t-10"> <button type="button"  id="next" class="btn btn-success btn-cons secondNextButton"  style="margin-right: 0px;">Add</button></div>
                                            <div class="pull-right m-t-10"> <button type="button"  id="prevbutton" class="btn btn-default btn-cons prevbutton"><?php echo BUTTON_PREVIOUS; ?></button></div>
                                        </div>
                                    </div>


                                </div>
                            </form>
                        </div>
                        <!-- End Third Tab -->
                    </div>
                    <!--</form>-->
                </div>
            </div>
        </div>
    </div>
</div>

