<?php
$currency = $appConfigData['currencySymbol'];
$mileageMetric = $appConfigData['mileage_metric'];
$weightMetric = $appConfigData['weight_metric'];
if ($mileageMetric == 0)
    $mileageMetric = 'Km';
else
    $mileageMetric = 'Mile';
?>

<link href="application/views/vehicleSettings/vehicleTypes/styles.css" rel="stylesheet" type="text/css">

<script>
    var rideAdvanceBookingFee;
    var deliveryAdvanceBookingFee;
    var mileageMetric;

    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
                (charCode != 45 || $(element).val().indexOf('-') != -1) && // “-” CHECK MINUS, AND ONLY ONE.
                (charCode != 46 || $(element).val().indexOf('.') != -1) && // “.” CHECK DOT, AND ONLY ONE.
                (charCode < 48 || charCode > 57))
            return false;
        return true;
    }


    var expanded1 = false;
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
    var expanded2 = false;
    function showPromotedType() {
        var checkboxes = document.getElementById("promotedTypeCheckboxDiv");
        if (!expanded2) {
            checkboxes.style.display = "block";
            expanded2 = true;
        } else {
            checkboxes.style.display = "none";
            expanded2 = false;
        }
    }
    var expanded3 = false;
    function showPreferences() {
        var checkboxes = document.getElementById("selectPreferencesDiv");
        if (!expanded3) {
            checkboxes.style.display = "block";
            expanded3 = true;
        } else {
            checkboxes.style.display = "none";
            expanded3 = false;
        }
    }

    function updateTypeStatus(type_city) {
        var isEnabled = 0;
        if ($(type_city).prop('checked') == true) {
            isEnabled = 1;
        } else {
            isEnabled = 0;
        }
        $.ajax({
            url: "<?php echo base_url('index.php?/vehicle') ?>/updateTypeStatus",
            type: 'POST',
            data: {isEnabled: isEnabled, type_city: type_city.id.toString()},
            dataType: 'JSON',
            success: function (response)
            {
                if (response.errFlag == 1)
                {
                    alert(response.errMsg);
                    if ($(type_city).prop('checked') == true)
                        $(type_city).attr('checked', false);
                }
            }
        });
    }

    // cool
    function getRidePriceByType(type_city)
    {
        // console.log('clikced')
        // console.log('clikced id--',type_city)
        // console.log('clikced id--',type_city.id)
        $('#specialTypeCheckboxDiv').empty();
       
        $.ajax({
            url: "<?php echo base_url('index.php?/vehicle') ?>/getPriceByType",
            type: 'POST',
            data: {type_city: type_city.id.toString()},
            dataType: 'JSON',
            success: function (response)
            {
               // console.log('response',response)

                $('#updateRidePriceForm')[0].reset();
                $('.error-box').text('');
                if (response.errFlag == 1)
                    alert("some error occured");
                else
                {

                    $('.documentId').val(response.id);
                    $('#updateRidePriceId').val(type_city.id.toString());
                    var l_Data = response.data;
                    console.log('ldata---',l_Data)

                    rideAdvanceBookingFee = l_Data.laterBookingAdvanceFee;
                    //currency
                    $('.currencySpan').text('');
                    // $('.currencySpan').text(response.currency);
                    $('.currencySpan').text('$');

                 //   $('.mileageMetricSpan').text(response.cityData.distanceMetrics);
                    $('#bookingTypeSelected').val(l_Data.bookingType);

                    if (l_Data.isVehicleTypePromotedEnable)
                        $('#bookRide-isVehicleTypePromotedEnable').attr('checked', true);
                    else
                        $('#bookRide-isVehicleTypePromotedEnable').attr('checked', false);

                    switch (parseInt(l_Data.bookingType)) {
                        case 1:
                            $('#bookNow').attr('checked', true);
                            $('#bookALater').attr('checked', false);
                            $('#advanceFee').val('');
                            $('.feesAdvanceForLaterBooking').hide();
                            break;
                        case 2:
                            $('#bookALater').attr('checked', true);
                            $('#bookNow').attr('checked', false);
                            $('.feesAdvanceForLaterBooking').show();
                            $('#advanceFee').val(l_Data.laterBookingAdvanceFee);
                            break;
                        case 0:
                            $('#bookALater').attr('checked', true);
                            $('#bookNow').attr('checked', true);
                            $('.feesAdvanceForLaterBooking').show();
                            $('#advanceFee').val(l_Data.laterBookingAdvanceFee);
                            break;
                    }

                    $('#promotedTypeCheckboxDiv').empty();
                    $('#specialTypeCheckboxDiv').empty();

                    //Special Types-----------------------------------
                    var html = '';
                    $.each(response.vehicleTypes, function (index, value) {
                        html += '<label for="sepcialType_' + value._id.$oid + '">';
                        html += '<input type="checkbox" class="specialType" name="specialType[]" id="sepcialType_' + value._id.$oid + '"  value="' + value._id.$oid + '"/>' + value.typeName.en;
                        html += ' </label>';
                    });

                    $('#specialTypeCheckboxDiv').append(html);
                    //-----------------------------------------------------


                    //promoted Types--------------------------------------
                    var html = '';
                    $.each(response.promotedVehicleTypes, function (index, value) {
                        html += '<label for="promotedType_' + value._id.$oid + '">';
                        html += '<input type="checkbox" class="promotedType" name="promotedType[]" id="promotedType_' + value._id.$oid + '"  value="' + value._id.$oid + '"/>' + value.typeName.en;
                        html += ' </label>';
                    });
                    $('#promotedTypeCheckboxDiv').append(html);
                    //----------------------------------------------------

                    //If the special type is already exist in same city don't allow to make another special vehicle type
                    $('#specialType').attr('disabled', false);
                    if (response.isSpecialAlreadyExist)
                        $('#specialType').attr('disabled', true);

                    if (l_Data.isVehicleTypePromotedEnable)
                    {
                        $('#promotedType').prop('checked', true);
                        $('.specialTypeDiv').hide();
                        $('.promotedTypeDiv').show();
                        $.each(response.vehicleTypes, function (index, value) {
                            if (l_Data.promotedTypes.indexOf(value._id.$oid) !== -1)
                                $('#promotedType_' + value._id.$oid).prop('checked', true);
                        });
                        $('#promotedTypeCheckboxDiv').css('display', 'block');
                    } else {
                        $('.promotedTypeDiv').hide();
                        $('#promotedTypeCheckboxDiv').css('display', 'none');
                    }

                    if (l_Data.isSpecialTypeEnable)
                    {
                        $('#specialType').prop('checked', true);
                        $('.specialTypeDiv').show();

                        $.each(response.vehicleTypes, function (index, value) {
                            if (l_Data.specialTypes.indexOf(value._id.$oid) !== -1)
                                $('#sepcialType_' + value._id.$oid).prop('checked', true);
                        });
                        $('#specialTypeCheckboxDiv').css('display', 'block');
                    } else {
                        $('.specialTypeDiv').hide();
                        $('#specialTypeCheckboxDiv').css('display', 'none');
                    }

                    if ((l_Data.isVehicleTypePromotedEnable == null && l_Data.isSpecialTypeEnable == null) || (l_Data.isVehicleTypePromotedEnable == false && l_Data.isSpecialTypeEnable == false))
                        $('#none').prop('checked', true);

                    $('#baseFare').val(l_Data.baseFee);
                    $('#seatingCapacity').val(l_Data.seatingCapacity);
                    $('#mileage').val(l_Data.mileagePrice);
                    $('#mileage_after_x_km_mile').val(l_Data.mileageAfterXMetric);
                    $('#price_after_x_minutesTripDuration').val(l_Data.timeFee);
                    $('#x_minutesTripDuration').val(l_Data.timeFeeXMinute);
                    $('#price_after_x_minWaiting').val(l_Data.waitingFee);
                    $('#x_minutesWaiting').val(l_Data.waitingTimeXMinute);
                    $('#price_MinimumFee').val(l_Data.minFee);
                    $('#price_after_x_minCancel').val(l_Data.cancellationFee);
                    $('#x_minutesCancel').val(l_Data.cancellationXMinute);
                    $('#price_after_x_minCancelScheduledBookings').val(l_Data.scheduledBookingCancellationFee);
                    $('#x_minutesCancelScheduledBookings').val(l_Data.scheduledBookingCancellationXMinute);


                    if (l_Data.isDropLocationMandatory)
                        $('#isDropLocationMandatory').attr('checked', true);
                    else
                        $('#isDropLocationMandatory').attr('checked', false);
                    //isMeterEnable
                    if (l_Data.isMeterBookingEnable)
                        $('#isMeterBookingEnable').attr('checked', true);
                    else
                        $('#isMeterBookingEnable').attr('checked', false);


                    var type_city_arr = type_city.id.toString().split('_');
                    $('.divSeatingCapacity').show();
                    $('.isMeterBookingDiv').show();
                    $('#divIsDropLocationMandatory').show();

                    $('#editRidePriceModel').modal('show');
                }

                //$('#editRidePriceModel').modal('show');
            }
        });
    }

    function getDeliveryPriceByType(type_city)
    {
        $.ajax({
            url: "<?php echo base_url('index.php?/vehicle') ?>/getPriceByType",
            type: 'POST',
            data: {type_city: type_city.id.toString()},
            dataType: 'JSON',
            success: function (response)
            {
                console.log('response',response)

                $('#updateDelieveryPriceForm')[0].reset();
                $('.error-box').text('');
                if (response.errFlag == 1)
                    alert("some error occured");
                else
                {
                    $('#updateDeliveryPriceId').val(type_city.id.toString());
                    var l_Data = response.data;
                    deliveryAdvanceBookingFee = l_Data.laterBookingAdvanceFee;
                    //currency
                    $('.currencySpan').text(response.currency);
                 //   $('.mileageMetricSpan').text(response.cityData.distanceMetrics);
                    $('#bookingTypeSelectedDelivery').val(l_Data.bookingType);

                    switch (parseInt(l_Data.bookingType)) {
                        case 1:
                            $('#bookNowDelivery').attr('checked', true);
                            $('#bookALaterDelivery').attr('checked', false);
                            $('.deliveryFeesAdvanceForLaterBookingDiv').hide();
                            break;
                        case 2:
                            $('#bookALaterDelivery').attr('checked', true);
                            $('#bookNowDelivery').attr('checked', false);
                            $('.deliveryFeesAdvanceForLaterBookingDiv').show();
                            $('#advanceFeeDelivery').val(l_Data.laterBookingAdvanceFee);
                            break;
                        case 0:
                            $('#bookALaterDelivery').attr('checked', true);
                            $('#bookNowDelivery').attr('checked', true);
                            $('.deliveryFeesAdvanceForLaterBookingDiv').show();
                            $('#advanceFeeDelivery').val(l_Data.laterBookingAdvanceFee);
                            break;
                    }

                    $('#baseFareDelivery').val(l_Data.baseFee);
                    $('#mileageDelivery').val(l_Data.mileagePrice);
                    $('#mileage_after_x_km_mileDelivery').val(l_Data.mileageAfterXMetric);
                    $('#price_after_x_minutesTripDurationDelivery').val(l_Data.timeFee);
                    $('#x_minutesTripDurationDelivery').val(l_Data.timeFeeXMinute);
                    $('#price_after_x_minWaitingDelivery').val(l_Data.waitingFee);
                    $('#x_minutesWaitingDelivery').val(l_Data.waitingTimeXMinute);
                    $('#price_MinimumFeeDelivery').val(l_Data.minFee);
                    $('#price_after_x_minCancelDelivery').val(l_Data.cancellationFee);
                    $('#x_minutesCancelDelivery').val(l_Data.cancellationXMinute);
                    $('#price_after_x_minCancelScheduledBookingsDelivery').val(l_Data.scheduledBookingCancellationFee);
                    $('#x_minutesCancelScheduledBookingsDelivery').val(l_Data.scheduledBookingCancellationXMinute);

                    if (l_Data.longHaulEnDis)
                        $('#longHaulEnDis').attr('checked', true);
                    else
                        $('#longHaulEnDis').attr('checked', false);

                    $('#onlyforDelivery').show();

                    $('#editDeliveryPriceModel').modal('show');
                }
            }
        });
    }

</script> 

<script>
    $(document).ready(function () {

        //-------------PREFERENCES----------------------------------------------

        $(document).on('click', '.setPreference', function () {
            $('#selectPreferencesDiv').empty();
            $('.documentId').val($(this).attr('data-id'));
            $('.cityId').val($(this).attr('cityId'));
            $.ajax({
                url: "<?php echo base_url('index.php?/vehicle') ?>/getPreferences",
                type: 'POST',
                dataType: 'JSON',
                data: {cityId: $(this).attr('cityId'), id: $(this).attr('data-id')},
                success: function (response)
                {
                    var html = '';
                    $.each(response.data, function (index, value) {
                        if ($.inArray(value._id.$oid, response.selectedPreferences) !== -1) {
                            html += '<label for="preference_' + value._id.$oid + '">';
                            html += '<input type="checkbox" checked class="preference" name="preference[]" id="preference_' + value._id.$oid + '"  value="' + value._id.$oid + '"/>' + value.name.en;
                            html += ' </label>';
                        } else {
                            html += '<label for="preference_' + value._id.$oid + '">';
                            html += '<input type="checkbox" class="preference" name="preference[]" id="preference_' + value._id.$oid + '"  value="' + value._id.$oid + '"/>' + value.name.en;
                            html += ' </label>';
                        }
                    });
                    $('#selectPreferencesDiv').append(html);
                }
            });
            $('#setPreferencePopUp').modal('show');
        });
        $(document).on('click', '.updatePreference', function () {
            if ($("#setPreferenceForm").valid()) {
                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/updatePreferences",
                    type: 'POST',
                    dataType: 'JSON',
                    data: $('#setPreferenceForm').serialize(),
                    success: function (response)
                    {
                        $('.close').trigger('click');
                    }
                });
            }
        });

        $(document).on('keypress', function () {
            $('.autonumeric').autoNumeric('init', {aSep: ''});
        });


        //--------------------------END-----------------------------------------

        //------------------------RENTAL PACKAGES-------------------------------
//
        $(document).on('click', '.rentalPackages', function () {
            if ($(this).is(':checked'))
                $('.rentalClass_' + $(this).val()).attr("readonly", false);
            else
            {
                $('.rentalClass_' + $(this).val()).attr("readonly", true);
                $('.rentalClass_' + $(this).val()).val('');
            }
        });
        $(document).on('click', '.setRentalPackages', function () {

            $('.rentalPackagesDiv').empty();
            $('.documentId').val($(this).attr('data-id'));
            $('.cityId').val($(this).attr('cityId'));
            $.ajax({
                url: "<?php echo base_url('index.php?/vehicle') ?>/getRentalPackages",
                type: 'POST',
                dataType: 'JSON',
                data: {cityId: $(this).attr('cityId'), id: $(this).attr('data-id')},
                success: function (response)
                {
                    var html = '';

                    mileageMetric = response.cityDetails.distanceMetrics;

                    if (response.data && response.data.length > 0) {
                        html += '<div class="form-group"><label for="address" class="col-sm-1 control-label"></label><label for="address" class="col-sm-3 control-label"> PACKAGE NAME</label>';
                        html += '<div class="col-sm-7">';
                        html += '<div class="col-sm-4"><label class="control-label">BASE FEE</label></div>';
                        html += '<div class="col-sm-4"><label class="control-label">TIME FEE</label></div>';
                        html += '<div class="col-sm-4"><label class="control-label">DISTANCE FEE</label></div>';
                        html += '</div></div>';

                        var selectedIds = [];
                        if (response.rentalPackages && response.rentalPackages != null && response.rentalPackages.length > 0)
                        {
                            console.log('here');
                            $.each(response.rentalPackages, function (index, value) {
                                selectedIds.push(value.rentalPackageId.$oid);
                            });
                        }


                        $.each(response.data, function (index, value) {
                            $.each(response.rentalPackages, function (ind, response) {
                                if (value._id.$oid == response.rentalPackageId.$oid) {

                                    html += '<div class="form-group"><div class="col-sm-1"><input type="checkbox" value="' + value._id.$oid + '" title="Activate" class="checkbox rentalPackages" checked name="rentalPackagesEnable[]" value=""></div><label for="address" class="col-sm-3 control-label">' + value.labelName + ' (' + value.pkgName + ' ' + value.packageKmMile + ' <span class="mileageMetricSpan" style="color: #73879C;">' + mileageMetric + '</span>' + ')</label>';
                                    html += '<div class="col-sm-7">';
                                    html += '<div class="col-sm-4"><input typr="text"value="' + response.baseFare + '" class="form-control autonumeric rentalClass_' + value._id.$oid + '" name="baseFare[' + value._id.$oid + ']"></div>';
                                    html += '<div class="col-sm-4"><input typr="text" value="' + response.timeFare + '" class="form-control autonumeric rentalClass_' + value._id.$oid + '" name="timeFare[' + value._id.$oid + ']"></div>';
                                    html += '<div class="col-sm-4"><input typr="text" value="' + response.distanceFare + '" class="form-control autonumeric rentalClass_' + value._id.$oid + '" name="distanceFare[' + value._id.$oid + ']"></div>';
                                    html += '</div></div>';
                                }
                            });

                            if ($.inArray(value._id.$oid, selectedIds) === -1) {
                                html += '<div class="form-group"><div class="col-sm-1"><input type="checkbox" value="' + value._id.$oid + '" title="Activate" class="checkbox rentalPackages" name="rentalPackagesEnable[]" value=""></div><label for="address" class="col-sm-3 control-label">' + value.labelName + ' (' + value.pkgName + ' ' + value.packageKmMile + ' <span class="mileageMetricSpan" style="color: #73879C;">' + mileageMetric + '</span>' + ')</label>';
                                html += '<div class="col-sm-7">';
                                html += '<div class="col-sm-4"><input typr="text" readOnly class="form-control autonumeric rentalClass_' + value._id.$oid + '" name="baseFare[' + value._id.$oid + ']"></div>';
                                html += '<div class="col-sm-4"><input typr="text" readOnly class="form-control autonumeric rentalClass_' + value._id.$oid + '" name="timeFare[' + value._id.$oid + ']"></div>';
                                html += '<div class="col-sm-4"><input typr="text" readOnly class="form-control autonumeric rentalClass_' + value._id.$oid + '" name="distanceFare[' + value._id.$oid + ']"></div>';
                                html += '</div></div>';
                            }
                        });
                    }
                    $('.rentalPackagesDiv').append(html);
                    $('#setRentalPackagesPopUp').modal('show');
                }
            });

        });
        $(document).on('click', '.updateRentalPackages', function () {
            if ($("#rentalPackagesForm").valid()) {
                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/updateRentalPackages",
                    type: 'POST',
                    dataType: 'JSON',
                    data: $('#rentalPackagesForm').serialize(),
                    success: function (response)
                    {
                        $('.close').trigger('click');
                    }
                });
            }
        });

        //--------------------------END-----------------------------------------

        $('.isSpecialOrPromoted').click(function () {
            $('.specialTypeDiv').hide();
            $('.specialType').attr('checked', false);
            $('.promotedTypeDiv').hide();
            $('.promotedType').attr('checked', false);
            if ($('.isSpecialOrPromoted:checked').val() == 1)
            {
                $('.specialTypeDiv').show();
                $('#specialTypeCheckboxDiv').css('display', 'block');
            } else if ($('.isSpecialOrPromoted:checked').val() == 2)
            {
                $('.promotedTypeDiv').show();
                $('#promotedTypeCheckboxDiv').css('display', 'block');
            } else
                $('.specialType').prop('checked', false);
        })

        $(document).on('click', '.specialType', function ()
        {

            if ($('.specialType:checked').length > 0)
                $('#specialType-error').hide();

        });
        $(document).on('click', '.promotedType', function ()
        {
            if ($('.promotedType:checked').length > 0)
                $('#promotedType-error').hide();

        });

        $('.bookingType').click(function ()
        {

            if ($('input:checkbox.bookingType:checked').length > 1)
                $('#bookingTypeSelected').val('0');
            else
                $('#bookingTypeSelected').val($('input:checkbox.bookingType:checked').val());
        });
        //Delivery
        $('.bookingTypeDelivery').click(function ()
        {

            if ($('input:checkbox.bookingTypeDelivery:checked').length > 1)
                $('#bookingTypeSelectedDelivery').val('0');
            else
                $('#bookingTypeSelectedDelivery').val($('input:checkbox.bookingTypeDelivery:checked').val());

            if ($('#bookALaterDelivery').is(":checked"))
            {
                $('.deliveryFeesAdvanceForLaterBookingDiv').show();
                $('#advanceFeeDelivery').val(deliveryAdvanceBookingFee);
            } else
                $('.deliveryFeesAdvanceForLaterBookingDiv').hide();

        });


        //Ride
        $("#updateRidePriceForm").validate({
            // Specify validation rules
            rules: {
                bookingType: {
                    required: true,
                },
                seatingCapacity: {
                    required: true,
                },
                baseFare: {
                    required: true,
                },
                mileage: {
                    required: true,
                },
                mileage_after_x_km_mile: {
                    required: true,
                },
                price_after_x_minutesTripDuration: {
                    required: true,
                },
                x_minutesTripDuration: {
                    required: true,
                },
                price_after_x_minWaiting: {
                    required: true,
                },
                x_minutesWaiting: {
                    required: true,
                },
                price_MinimumFee: {
                    required: true,
                },
                price_after_x_minCancel: {
                    required: true,
                },
                x_minutesCancel: {
                    required: true,
                },
                price_after_x_minCancelScheduledBookings: {
                    required: true,
                },
                x_minutesCancelScheduledBookings: {
                    required: true,
                }
            }
        });

        $('#ridePriceUpdateButton').click(function () {
            $('#specialType-error').hide();

            if ($('.isSpecialOrPromoted:checked').val() == 1) {

                if ($('.specialType:checked').length == 0) {
                    $('#specialType-error').text('This field is required.');
                    $('#specialType-error').show();
                    return false;
                }
            }

            if ($('.isSpecialOrPromoted:checked').val() == 2) {

                if ($('.promotedType:checked').length == 0) {
                    $('#promotedType-error').text('This field is required.');
                    $('#promotedType-error').show();
                    return false;
                }
            }

            if ($("#updateRidePriceForm").valid()) {

                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/updateTypePrice",
                    type: 'POST',
                    data: $('#updateRidePriceForm').serialize(),
                    dataType: 'JSON',
                    success: function (response)
                    {
                        if (response.errFlag == 0)
                        {
                            $('.close').trigger('click');
                            $('#responseMsg').text(response.errMsg);
                            $('#ResponsePopUp').modal('show');
                        } else {
                            $('.ResponseErr').text(response.msg);
                        }
                    }
                });
            }

        })

        //Delivery
        $("#updateDelieveryPriceForm").validate({
            // Specify validation rules
            rules: {
                bookingType: {
                    required: true,
                },
                baseFare: {
                    required: true,
                },
                mileage: {
                    required: true,
                },
                mileage_after_x_km_mile: {
                    required: true,
                },
                price_after_x_minutesTripDuration: {
                    required: true,
                },
                x_minutesTripDuration: {
                    required: true,
                },
                price_after_x_minWaiting: {
                    required: true,
                },
                x_minutesWaiting: {
                    required: true,
                },
                price_MinimumFee: {
                    required: true,
                },
                price_after_x_minCancel: {
                    required: true,
                },
                x_minutesCancel: {
                    required: true,
                },
                price_after_x_minCancelScheduledBookings: {
                    required: true,
                },
                x_minutesCancelScheduledBookings: {
                    required: true,
                }
            }
        });

        $('#deliveryPriceUpdateButton').click(function () {
            if ($("#updateDelieveryPriceForm").valid()) {

                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/updateTypePrice",
                    type: 'POST',
                    data: $('#updateDelieveryPriceForm').serialize(),
                    dataType: 'JSON',
                    success: function (response)
                    {
                        if (response.errFlag == 0)
                        {
                            $('.close').trigger('click');
                            $('#responseMsg').text(response.errMsg);
                            $('#ResponsePopUp').modal('show');
                        } else {
                            $('.ResponseErr').text(response.msg);
                        }
                    }
                });
            }

        });

        $.validator.addMethod("alphanumeric", function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
        });

    });

    $(document).ready(function () {

        $('.isNumericValidation').keypress(function (event) {
            if (event.which < 44
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if ((event.which == 45 && $(this).val().indexOf('-') != -1) || (event.which == 46 && $(this).val().indexOf('.') != -1)) {
                event.preventDefault();
            } // prevent if already dot
        });

        $('#bookALater').click(function () {
            if ($(this).is(':checked'))
            {
                $('.feesAdvanceForLaterBooking').show();
                $('#advanceFee').val(rideAdvanceBookingFee);
            } else
                $('.feesAdvanceForLaterBooking').hide();
        });

    });

</script>

<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/vehicle/datatable_typeCityPrice/<?php echo $typeId ?>',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {

                                },
                                "fnInitComplete": function () {
                                    $('.cs-loader').hide();
                                    table.show()
                                    searchInput.show()
                                },
                                'fnServerData': function (sSource, aoData, fnCallback)
                                {
                                    $.ajax
                                            ({
                                                'dataType': 'json',
                                                'type': 'POST',
                                                'url': sSource,
                                                'data': aoData,
                                                'success': fnCallback
                                            });
                                }
                            };



                            table.dataTable(settings);
                        }, 1000);

                        // search box for table
                        $('#search-table').keyup(function () {
                            table.fnFilter($(this).val());
                        });

                    });
</script>


<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->    
    <ul class="breadcrumb" style="margin-left: 0px;margin-top: 5%; ">
        <li>
            <a href="<?php echo base_url('index.php?/vehicle') ?>/vehicle_type" class=""><?PHP ECHO LIST_VEHICLETYPE; ?></a>
        </li>
        <li>
            <a href="<?php echo base_url('index.php?/vehicle') ?>/vehicle_type" class=""><?php echo $typeData['typeName']['en']; ?></a>
        </li>
        <li>
            <a href="#" class="active">CITY</a>
        </li>

    </ul>

    <div class="content">
        <div class="row">           
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-transparent ">
                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <div class="cs-loader">
                                    <div class="cs-loader-inner" >
                                        <label class="loaderPoint" style="color:#10cfbd">●</label>
                                        <label class="loaderPoint" style="color:red">●</label>
                                        <label class="loaderPoint" style="color:#FFD119">●</label>
                                        <label class="loaderPoint" style="color:#4d90fe">●</label>
                                        <label class="loaderPoint" style="color:palevioletred">●</label>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo SEARCH; ?>"/> 
                                </div>
                                &nbsp;
                                <div class="panel-body" style="padding: 0px; margin-top: 2%;">
                                    <?php echo $this->table->generate(); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PANEL -->
        </div>
    </div>
</div>




<div class="modal fade stick-up" id="editRidePriceModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="updateRidePriceForm" action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title" ><?php echo $this->lang->line('heading_edit_price'); ?></span>                   
                </div>
                <input type="hidden" name="documentId" class="documentId">
                <div class="modal-body">
                    <input type="hidden" id="updateRidePriceId" name="updateRidePriceId">
                    <div class="row row-same-height">
                        <!-- <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('label_booking_type'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 row">
                                <label for="bookNow">
                                    <input type="checkbox" class="bookingType" name="bookingType" id="bookNow"  value="1"/><span><?php echo $this->lang->line('label_book_now'); ?></span>
                                </label>

                                <label for="bookALater">
                                    <input type="checkbox" class="bookingType" name="bookingType" id="bookALater" value="2"/><span><?php echo $this->lang->line('label_book_later'); ?></span>
                                </label>
                            </div>
                            <input type="hidden" name="bookingTypeSelected" id="bookingTypeSelected">
                            <div class="col-sm-3 error-box" id="bookingTypeErr"></div>
                        </div> -->
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"></label>
                            <div class="col-sm-4 row">
                                <label for="specialType">
                                    <input type="radio" class="isSpecialOrPromoted" name="isSpecialOrPromoted" id="specialType"  value="1"/><span><?php echo $this->lang->line('label_specialType'); ?></span>
                                </label>

                                <label for="promotedType" style="padding-left: 20px;">
                                    <input type="radio" class="isSpecialOrPromoted" name="isSpecialOrPromoted" id="promotedType" value="2"/><span><?php echo $this->lang->line('label_promotedType'); ?></span>
                                </label>

                                <label for="none" style="padding-left: 20px;">
                                    <input type="radio" class="isSpecialOrPromoted" name="isSpecialOrPromoted" id="none" value="3"/><span><?php echo $this->lang->line('label_normal'); ?></span>
                                </label>
                            </div>

                            <div class="col-sm-3 error-box" id="bookingTypeErr"></div>
                        </div>


                        <div class="form-group specialTypeDiv" style="display:none;">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('label_vehicle_type'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4">
                                <div class="multiselect">
                                    <div class="selectBox" onclick="showSpecialType()">
                                        <select class="form-control" name="goodTypeSelect">
                                            <option><?php echo $this->lang->line('select_option'); ?></option>
                                        </select>
                                        <div class="overSelect"></div>
                                    </div>
                                    <div id="specialTypeCheckboxDiv">

                                    </div>

                                </div>
                                <label id="specialType-error" class="error" style="display:none">This field is required.</label>
                            </div>
                            <div class="col-sm-3 error-box" id=""></div>
                        </div>
                        <div class="form-group promotedTypeDiv" style="display:none;">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('label_vehicle_type'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4">
                                <div class="multiselect">
                                    <div class="selectBox" onclick="showPromotedType()">
                                        <select class="form-control" name="goodTypeSelect">
                                            <option><?php echo $this->lang->line('select_option'); ?></option>
                                        </select>
                                        <div class="overSelect"></div>
                                    </div>
                                    <div id="promotedTypeCheckboxDiv">

                                    </div>

                                </div>
                                <label id="promotedType-error" class="error" style="display:none">This field is required.</label>
                            </div>
                            <div class="col-sm-3 error-box" id=""></div>
                        </div>


                        <div class="form-group divSeatingCapacity" style="display:none;">
                            <label for="seatingCapacity" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_seatig_capacity'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="seatingCapacity" name="seatingCapacity" class="form-control" value="" placeholder="Enter seating capacity" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                            </div>
                            <div class="col-sm-3 error-box" id="seatingCapacityErr"></div>
                        </div>

                        <div class="form-group feesAdvanceForLaterBooking" style="display:none;">
                            <label for="advanceFee" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_fees_for_booking_in_advance'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <!--<span class="currencySpan abs_text1" style="color: #73879C;"></span>-->
                                <input type="text" id="advanceFee" name="advanceFee" class="form-control isNumericValidation" value="" placeholder=""  required="">
                                <span class="currencySpan abs_text1" style="color: #73879C;"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_basefare'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="baseFare" name="baseFare" class="form-control autonumeric" value="" placeholder="Enter basefare" required="">

                                <span class="currencySpan abs_text1" style="color: #73879C;"></span>
                            </div>
                            <div class="col-sm-3 pos_relative2">
                            </div>
                            <div class="col-sm-3 error-box" id="baseFareErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_mileage_price'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="input-group col-sm-4">
                                <input type="text" id="mileage" name="mileage" class="form-control autonumeric" placeholder="Enter mileage price" value="" required="">

                                <span style="color: #73879C;" class="abs_text1"><span class="currencySpan"></span>/ <span class="mileageMetricSpan" style="color: #73879C;"></span></span>

                            </div>
                            <div class="col-sm-5 pos_relative2">
                                <span class="abs_textLeft"><?php echo $this->lang->line('lable_after'); ?></span>
                                <input type="text" id="mileage_after_x_km_mile" name="mileage_after_x_km_mile" class="form-control" value="" placeholder="Enter no .of <?php echo $mileageMetric; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text Mileagemetric"><span class="mileageMetricSpan" style="color: #73879C;"></span></span>
                            </div>
                            <div class="col-sm-3 error-box" id="mileageErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_time_fee'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_after_x_minutesTripDuration" name="price_after_x_minutesTripDuration" class="form-control autonumeric" placeholder="Enter Price per Minute" value="" required="">

                                <span style="color: #73879C;" class="abs_text1"><span class="currencySpan"></span>/ <?php echo $this->lang->line('lable_minutes'); ?></span>

                            </div>
                            <div class="col-sm-5 pos_relative2"> 
                                <span class="abs_textLeft"><?php echo $this->lang->line('lable_after'); ?></span>
                                <input type="text" id="x_minutesTripDuration" name="x_minutesTripDuration" class="form-control" placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text"><?php echo $this->lang->line('lable_minutes'); ?></span>
                            </div>
                            <div class="col-sm-3 error-box" id="price_after_x_minutesTripDurationErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_waiting_fee'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_after_x_minWaiting" name="price_after_x_minWaiting" class="form-control autonumeric" placeholder="Enter Price per Minute" value="" required="">

                                <span style="color: #73879C;" class="abs_text1"><span class="currencySpan"></span>/ Minutes</span>

                            </div>
                            <div class="col-sm-5 pos_relative2"> 
                                <span class="abs_textLeft"><?php echo $this->lang->line('lable_after'); ?></span>
                                <input type="text" id="x_minutesWaiting" name="x_minutesWaiting" class="form-control"  placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text"><?php echo $this->lang->line('lable_minutes'); ?></span>
                            </div>
                            <div class="col-sm-3 error-box" id="price_after_x_minWaitingErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_minimum_fee'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_MinimumFee" name="price_MinimumFee" class="form-control autonumeric"  placeholder="Enter Price" value="" required="">

                                <span class="currencySpan abs_text1"  style="color: #73879C;"></span>

                            </div>

                            <div class="col-sm-3 error-box" id="price_MinimumFeeErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_on_demand_bookings_cancellation_fee'); ?> <span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_after_x_minCancel" name="price_after_x_minCancel" class="form-control autonumeric" placeholder="Enter Price" value="" required="">

                                <span class="currencySpan abs_text1" style="color: #73879C;"></span>

                            </div>
                            <div class="col-sm-5 pos_relative2"> 
                                <span class="abs_textLeft"><?php echo $this->lang->line('lable_after'); ?></span>
                                <input type="text" id="x_minutesCancel" name="x_minutesCancel" class="form-control"  placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text"><?php echo $this->lang->line('lable_minutes'); ?></span>
                            </div>
                            <div class="col-sm-4 error-box" id="price_after_x_minCancelErr"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_scheduled_bookings_cancellation_fee'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_after_x_minCancelScheduledBookings" name="price_after_x_minCancelScheduledBookings" class="form-control autonumeric" placeholder="Enter Price" value="" required="">

                                <span class="currencySpan abs_text1" style="color: #73879C;"></span>

                            </div>
                            <div class="col-sm-5 pos_relative2"> 
                                <input style="padding-left : 12px" type="text" id="x_minutesCancelScheduledBookings" name="x_minutesCancelScheduledBookings" class="form-control"  placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text"><?php echo $this->lang->line('lable_minutes_before_pickup_time'); ?></span>
                            </div>
                            <div class="col-sm-3 error-box" id="price_after_x_minCancelScheduledBookingsErr"></div>
                        </div>

                        <!-- <div class="form-group" id="divIsDropLocationMandatory">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('label_drop_location_mandatory'); ?></label>
                            <div class="col-sm-2">

                                <div class="switch">
                                    <input id="isDropLocationMandatory" name="isDropLocationMandatory" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                    <label for="isDropLocationMandatory"></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group isMeterBookingDiv">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('label_is_meter_booking'); ?></label>
                            <div class="col-sm-2">

                                <div class="switch">
                                    <input id="isMeterBookingEnable" name="isMeterBookingEnable" class="cmn-toggle cmn-toggle-round" type="checkbox" checked="" style="display: none;">
                                    <label for="isMeterBookingEnable"></label>
                                </div>
                            </div>
                        </div> -->
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-sm-4 error-box errors responseErr"></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="ridePriceUpdateButton" >Save</button></div>
                        <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                    </div>
                </div>
            </form>   
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="editDeliveryPriceModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="updateDelieveryPriceForm" action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title" ><?php echo $this->lang->line('heading_edit_price'); ?></span>                   
                </div>
                <input type="hidden" name="documentId" class="documentId">
                <div class="modal-body">
                    <input type="hidden" id="updateDeliveryPriceId" name="updateRidePriceId">
                    <div class="row row-same-height">
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('label_booking_type'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 row">
                                <label for="bookNowDelivery">
                                    <input type="checkbox" class="bookingTypeDelivery" name="bookingType" id="bookNowDelivery"  value="1"/><span><?php echo $this->lang->line('label_book_now'); ?></span>
                                </label>

                                <label for="bookALaterDelivery">
                                    <input type="checkbox" class="bookingTypeDelivery" name="bookingType" id="bookALaterDelivery" value="2"/><span><?php echo $this->lang->line('label_book_later'); ?></span>
                                </label>
                            </div>
                            <input type="hidden" name="bookingTypeSelected" id="bookingTypeSelectedDelivery">


                        </div>

                        <div class="form-group deliveryFeesAdvanceForLaterBookingDiv" style="display:none;">
                            <label for="advanceFee" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_fees_for_booking_in_advance'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <!--<span class="currencySpan abs_text1" style="color: #73879C;"></span>-->
                                <input type="text" id="advanceFeeDelivery" name="advanceFee" class="form-control isNumericValidation" value="" placeholder="Enter advance fee"  required="">
                                <span class="currencySpan abs_text1" style="color: #73879C;"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_basefare'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="baseFareDelivery" name="baseFare" class="form-control autonumeric" value="" placeholder="Enter basefare" required="">

                                <span class="currencySpan abs_text1" style="color: #73879C;"></span>
                            </div>
                            <div class="col-sm-3 pos_relative2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_mileage_price'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="input-group col-sm-4">
                                <input type="text" id="mileageDelivery" name="mileage" class="form-control autonumeric" placeholder="Enter mileage price" value="" required="">

                                <span style="color: #73879C;" class="abs_text1"><span class="currencySpan"></span>/ <span class="mileageMetricSpan" style="color: #73879C;"></span></span>

                            </div>
                            <div class="col-sm-5 pos_relative2">
                                <span class="abs_textLeft"><?php echo $this->lang->line('lable_after'); ?></span>
                                <input type="text" id="mileage_after_x_km_mileDelivery" name="mileage_after_x_km_mile" class="form-control" value="" placeholder="Enter no .of <?php echo $mileageMetric; ?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text Mileagemetric"><span class="mileageMetricSpan" style="color: #73879C;"></span></span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_time_fee'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_after_x_minutesTripDurationDelivery" name="price_after_x_minutesTripDuration" class="form-control autonumeric" placeholder="Enter Price per Minute" value="" required="">

                                <span style="color: #73879C;" class="abs_text1"><span class="currencySpan"></span>/ <?php echo $this->lang->line('lable_minutes'); ?></span>

                            </div>
                            <div class="col-sm-5 pos_relative2"> 
                                <span class="abs_textLeft"><?php echo $this->lang->line('lable_after'); ?></span>
                                <input type="text" id="x_minutesTripDurationDelivery" name="x_minutesTripDuration" class="form-control" placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text"><?php echo $this->lang->line('lable_minutes'); ?></span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_waiting_fee'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_after_x_minWaitingDelivery" name="price_after_x_minWaiting" class="form-control autonumeric" placeholder="Enter Price per Minute" value="" required="">

                                <span style="color: #73879C;" class="abs_text1"><span class="currencySpan"></span>/ Minutes</span>

                            </div>
                            <div class="col-sm-5 pos_relative2"> 
                                <span class="abs_textLeft"><?php echo $this->lang->line('lable_after'); ?></span>
                                <input type="text" id="x_minutesWaitingDelivery" name="x_minutesWaiting" class="form-control"  placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text"><?php echo $this->lang->line('lable_minutes'); ?></span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_minimum_fee'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_MinimumFeeDelivery" name="price_MinimumFee" class="form-control autonumeric"  placeholder="Enter Price" value="" required="">

                                <span class="currencySpan abs_text1"  style="color: #73879C;"></span>

                            </div>


                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_on_demand_bookings_cancellation_fee'); ?> <span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_after_x_minCancelDelivery" name="price_after_x_minCancel" class="form-control autonumeric" placeholder="Enter Price" value="" required="">

                                <span class="currencySpan abs_text1" style="color: #73879C;"></span>

                            </div>
                            <div class="col-sm-5 pos_relative2"> 
                                <span class="abs_textLeft"><?php echo $this->lang->line('lable_after'); ?></span>
                                <input type="text" id="x_minutesCancelDelivery" name="x_minutesCancel" class="form-control"  placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text"><?php echo $this->lang->line('lable_minutes'); ?></span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_scheduled_bookings_cancellation_fee'); ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-4 input-group pos_relative">
                                <input type="text" id="price_after_x_minCancelScheduledBookingsDelivery" name="price_after_x_minCancelScheduledBookings" class="form-control autonumeric" placeholder="Enter Price" value="" required="">

                                <span class="currencySpan abs_text1" style="color: #73879C;"></span>

                            </div>
                            <div class="col-sm-5 pos_relative2"> 
                                <input style="padding-left : 12px" type="text" id="x_minutesCancelScheduledBookingsDelivery" name="x_minutesCancelScheduledBookings" class="form-control"  placeholder="Enter Minutes" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                                <span class="abs_text"><?php echo $this->lang->line('lable_minutes_before_pickup_time'); ?></span>
                            </div>

                        </div>
                        <div class="form-group" id="onlyforDelivery">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_long_haul_enable_disable'); ?></label>
                            <div class="col-sm-3">
                                <div class="switch">
                                    <input id="longHaulEnDis" name="longHaulEnDis" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                    <label for="longHaulEnDis"></label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-sm-4 error-box errors responseErr"></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="deliveryPriceUpdateButton" >Save</button></div>
                        <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                    </div>
                </div>
            </form>   
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="setPreferencePopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="setPreferenceForm" action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title" >SET PREFERENCES</span>                   
                </div>
                <input type="hidden" name="documentId" class="documentId">
                <input type="hidden" name="cityId" class="cityId">
                <div class="modal-body">
                    <div class="row row-same-height">
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_preferences'); ?></label>
                            <div class="col-sm-4">
                                <div class="multiselect">
                                    <div class="selectBox" onclick="showPreferences()">
                                        <select class="form-control" name="preferencesSelect">
                                            <option value=""><?php echo $this->lang->line('select_option'); ?></option>
                                        </select>
                                        <div class="overSelect"></div>
                                    </div>
                                    <div id="selectPreferencesDiv" style="overflow-x: scroll;max-height: 125px">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-4 error-box errors responseErr"></div>
                        <div class="col-sm-8" >
                            <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right updatePreference" >Update</button></div>
                            <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                        </div>
                    </div>
            </form>   
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>
<div class="modal fade stick-up" id="setRentalPackagesPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="rentalPackagesForm" action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title" ><?php echo $this->lang->line('heading_popup_rental_packages'); ?></span>                   
                </div>
                <input type="hidden" name="documentId" class="documentId">
                <input type="hidden" name="cityId" class="cityId">
                <div class="modal-body">
                    <div class="row row-same-height rentalPackagesDiv">

                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-4 error-box errors responseErr"></div>
                        <div class="col-sm-8" >
                            <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right updateRentalPackages" >Update</button></div>
                            <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                        </div>
                    </div>

                </div>
            </form>   
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
