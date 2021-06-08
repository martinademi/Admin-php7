<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>
<!-- <link href="http://superadmin.instacart-clone.com/vendors/bootstrap/dist/css/bootstrap-timepicker.min.css" rel="stylesheet"> -->
<!--date time picker-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<!--date time picker end-->
<script type="text/javascript">
         $(function () {
             $('#breakfasttime,#breakfastEndtime,#brunchtime,#brunchEndtime,#lunchtime,#lunchEndtime,#teatime,#teaEndtime,#dinnertime,#dinnerEndtime,#latenightdinnertime,#latenightdinnerEndtime').datetimepicker({
             format : 'HH:mm'
             });
             });
    </script> 
<?php
$mileageMetric = '';
$driverAcceptTime = '';
$dispatchStartTime = '';
$dispatchDuration = '';
foreach ($appConfigData as $row) {

    $activePaymentGateways = $row['paymentGateways'];
    $inActivePaymentGateways = $row['inActivePaymentGateways'];
//    $mileage_metric = $row['mileage_metric'];
//    $weight_metric = $row['weight_metric'];
//    $currencySym = $row['currencySymbol'];
//    $currency = $row['currency'];
    $appCommission = $row['appCommission'];
    $appVersion = $row['appVersion'];
    $timeForNormalDelivery = $row['laundry']['timeForNormalDelivery'];
    $timeForExpressDelivery=$row['laundry']['timeForExpressDelivery'];

    $defaultFeeForNormalDelivery = $row['laundry']['defaultFeeForNormalDelivery'];
    $defaultFeeForExpressDelivery=$row['laundry']['defaultFeeForExpressDelivery'];


    $storeDefaultCommission = $row['storeDefaultCommission'];
    $storeCommisionOnDeliveryFee=$row['storeCommisionOnDeliveryFee'];

    $breakfastTime=$row['consumptionTime']['breakfast']['startTime'];
    $brunchTime=$row['consumptionTime']['brunch']['startTime'];
    $lunchTime=$row['consumptionTime']['lunch']['startTime'];
    $teaTime=$row['consumptionTime']['tea']['startTime'];
    $dinnerTime=$row['consumptionTime']['dinner']['startTime'];
    $latenightDinnerTime=$row['consumptionTime']['latenightDinner']['startTime'];

    $breakfastEndTime=$row['consumptionTime']['breakfast']['endTime'];
    $brunchEndTime=$row['consumptionTime']['brunch']['endTime'];
    $lunchEndTime=$row['consumptionTime']['lunch']['endTime'];
    $teaEndTime=$row['consumptionTime']['tea']['endTime'];
    $dinnerEndTime=$row['consumptionTime']['dinner']['endTime'];
    $latenightDinnerEndTime=$row['consumptionTime']['latenightDinner']['endTime'];


    $zonalPricing = $row['pricing_model']['zonalPricing'];
    $mileagePricing = $row['pricing_model']['mileagePricing'];
    $longHaul = $row['pricing_model']['longHaul'];
    $shortHaul = $row['pricing_model']['shortHaul'];
    $paymentMode = $row['pricing_model']['paymentMode'];
  

    $driverAcceptTime = $row['dispatch_settings']['driverAcceptTime'];
    $timeForDriverAck = $row['dispatch_settings']['timeForDriverAck'];
    $dispatchStartHour = $row['dispatch_settings']['dispatchStartHour'];
    $dispatchStartMinutes = $row['dispatch_settings']['dispatchStartMinutes'];
    //$dispatchDuration = $row['dispatch_settings']['dispatchExpireTime'];
    $dispatchExpireTime = $row['dispatch_settings']['dispatchExpireTime'];
    $centralDispatchExpriryTime = $row['dispatch_settings']['centralDispatchExpriryTime'];
    $nowBookingExpriryTime = $row['dispatch_settings']['nowBookingExpriryTime'];
    $centralDispatchTime = $row['dispatch_settings']['centralDispatchTime'];
    $dispatchTime = $row['dispatch_settings']['dispatchTime'];
    $scheduledBookingsOnOFF = $row['dispatch_settings']['scheduledBookingsOnOFF'];
    $staffAcceptTime = $row['dispatch_settings']['staffAcceptTime'];
    $nowBookingStoreExpireTime=$row['dispatch_settings']['nowBookingStoreExpireTime'];
    $laterBookingStoreExpireTime=$row['dispatch_settings']['laterBookingStoreExpireTime'];

    // cool
    $laterBookingBufferHour=$row['dispatch_settings']['laterBookingBufferHour'];
    $laterBookingBufferMinute=$row['dispatch_settings']['laterBookingBufferMinute'];

    //Payment methods
    $cardPayment = $row['paymentMethods']['card'];
    $cashPayment = $row['paymentMethods']['cash'];
    $walletPayment = $row['paymentMethods']['wallet'];

    //Pubnub interval for Driver
    $homePageInterval = $row['pubnubSettings']['homePageInterval'];
    $timedOutTimeInterval = $row['pubnubSettings']['timedOutTimeInterval'];
    $onJobInterval = $row['pubnubSettings']['onJobInterval'];
    $tripStartedInterval = $row['pubnubSettings']['tripStartedInterval'];


    //MQTT interval for Customer
    $customerHomePageInterval = $row['pubnubSettings']['customerHomePageInterval'];

    //Book Later
    $autoDispatchRation = $row['dispatch_settings']['laterBookingAutoDispatchRatio'];
    $centralDispatchRation = $row['dispatch_settings']['laterBookingCentralDispatchRatio'];

    //Book Now
    $autoBookNowDispatchRation = $row['dispatch_settings']['nowBookingAutoDispatchRatio'];
    $centralBookNowDispatchRation = $row['dispatch_settings']['nowBookingCentralDispatchRatio'];

    $dipatchMode = $row['dispatch_settings']['dispatchMode'];

    $laterBookingDispatchBeforeHours = $row['dispatch_settings']['laterBookingDispatchBeforeHours'];
    $laterBookingDispatchBeforeMinutes = $row['dispatch_settings']['laterBookingDispatchBeforeMinutes'];

    $DispatchRadius = $row['dispatch_settings']['DispatchRadius'];

    $bookLaterExpQueueMin = $row['dispatch_settings']['bookLaterExpQueueMin'];

    $publishKey = $row['pubnubkeys']['publishKey'];
    $substribeKey = $row['pubnubkeys']['subscribeKey'];

    $referralCodeSendByEmail = $row['referralSettings']['sendByEmail'];
    $referralCodeSendByTestMsg = $row['referralSettings']['sendByTestMsg'];

    $presenceTime = $row['presenceSettings']['presenceTime'];

    $DistanceForLogingLatLongs = $row['presenceSettings']['DistanceForLogingLatLongs'];
    $paymentCycleTrigger = $row['paymentCycleTrigger'];

//App vesrions
    $ios_driver = $row['appVersions']['ios_driver'];
    $ios_customer = $row['appVersions']['ios_customer'];
    $andriod_driver = $row['appVersions']['andriod_driver'];
    $andriod_customer = $row['appVersions']['andriod_customer'];


    //Security Settings
//    $refreshToken = $row['securitySettings']['refreshToken'];
    $accessToken = $row['securitySettings']['accessToken'];

    //Forgot Password Settings
    $maxAttemptForgotPassword = $row['forgotPasswordSettings']['maxAttemptForgotPassword'];
    $maxAttemptOtp = $row['forgotPasswordSettings']['maxAttemptOtp'];
    $otpExpiryTime = $row['forgotPasswordSettings']['otpExpiryTime'];
	$resetPasswordLinkExpiry  = $row['forgotPasswordSettings']['resetPasswordLinkExpiry'];
//    
//     //Soft and hard limit
//    $softLimitForShipper = $row['walletSettings']['softLimitShipper'];
//    $hardLimitForShipper = $row['walletSettings']['hardLimitShipper'];
//    $walletShipperEnable = $row['walletSettings']['walletShipperEnable'];
//
//    $softLimitForDriver = $row['walletSettings']['softLimitDriver'];
//    $hardLimitForDriver = $row['walletSettings']['hardLimitDriver'];
//    $softLimitForStore = $row['walletSettings']['softLimitStore'];
//    $hardLimitForStore = $row['walletSettings']['hardLimitStore'];
//    $walletDriverEnable = $row['walletSettings']['walletDriverEnable'];
//    $walletStoreEnable = $row['walletSettings']['walletStoreEnable'];
//    $paidByReceiver = $row['walletSettings']['paidByReceiver'];
    //Google Keys
    $DriverGoogleMapKeys = $row['DriverGoogleMapKeys'];
    $custGoogleMapKeys = $row['custGoogleMapKeys'];
    $custGooglePlaceKeys = $row['custGooglePlaceKeys'];

    //Push Topics-Drivers
    $allDrivers = $row['pushTopics']['allDrivers'];
    $allCitiesDrivers = $row['pushTopics']['allCitiesDrivers'];
//    $outZoneDrivers = $row['pushTopics']['outZoneDrivers'];
    //Push Topics-Customers
    $allCustomers = $row['pushTopics']['allCustomers'];
    $allCitiesCustomers = $row['pushTopics']['allCitiesCustomers'];
//    $outZoneCustomers = $row['pushTopics']['outZoneCustomers'];
//    $stripeTestSecreteKeys = $row['stripeTestKeys']['SecreteKey'];
//    $stripeTestPublishableKeys = $row['stripeTestKeys']['PublishableKey'];
//
//    $stripeLiveSecreteKeys = $row['stripeLiveKeys']['SecreteKey'];
//    $stripeLivePublishableKeys = $row['stripeLiveKeys']['PublishableKey'];




    $sl = 1;
    foreach ($row['googleKeys'] as $keys) {
        ?>

        $('#driverGoogleKey<?php echo $sl; ?>').val('<?php echo $keys['driverKey']; ?>');
        $('#customerGoogleKey<?php echo $sl; ?>').val('<?php echo $keys['customerKey']; ?>');
        <?php
        $sl++;
    }
}
?>
<style>
    input[type=checkbox], input[type=radio] {
        margin: 4px 2px 0px;
    }
    span.RemoveMore,span.RemoveMore-inActive{
        margin-left: 8px;cursor: pointer;
    }
    .paymentGatewaysListDiv,.inActivePaymentGatewaysListDiv {
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        display: inline-block;
        padding: 4px 6px;
        color: #555;
        vertical-align: middle;
        border-radius: 4px;
        max-width: 100%;
        line-height: 22px;
        cursor: text;
        width: 100%;
    }
    span.tag {
        padding:5px 10px;
        background-color: #5bc0de;
        font-size:10px;
    }


    .label-info {
        background-color: #5bc0de;
    }

    span.abs_text {
        position: absolute;
        right:10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }
    .pos_relative ,.pos_relative2{
        position: relative;
        padding-right:0px
    }
    .pos_relative2{
        padding-right:10px
    }
    #currencySymbol{
        padding-left: 10px;
    }
    #currency,#dispatchHourStartTime,#dispatchMinStartTime,#timeForDriverAck,#homePageInterval,#onJobInterval,#tripStartedInterval,#timeForacceptBooking,#dispatchDuration{
        padding-left: 10px;
    }

    span.abs_text2 {
        position: absolute;
        left: 1px;
        top: 2px;
        padding: 8px 5px;
        background: #f1f1f1;
        color: #555555;
        border-right: 1px solid #c3c3c3;
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
        width: 44px;
        height: 16px;
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
        border-radius: 50px;
        transition: background 0.4s;
    }
    input.cmn-toggle-round + label:after {
        width: 16px;
        background-color: #fff;
        border-radius: 100%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        transition: margin 0.4s;
    }
    input.cmn-toggle-round:checked + label:before {
        background-color: #8ce196;
    }
    input.cmn-toggle-round:checked + label:after {
        margin-left:25px;
    }

    span.abs_text {
        position: absolute;
        right:10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }
    .pos_relative ,.pos_relative2{
        position: relative;
        padding-right:0px
    }
    .pos_relative2{
        padding-right:10px
    }
    #currencySymbol{
        padding-left: 10px;
    }
    #currency,#dispatchHourStartTime,#dispatchMinStartTime,#timeForDriverAck,#homePageInterval,#onJobInterval,#tripStartedInterval,#timeForacceptBooking,#dispatchDuration,#timedOutTimeInterval{
        padding-left: 10px;
    }

    span.abs_text2 {
        position: absolute;
        left: 1px;
        top: 2px;
        padding: 8px 5px;
        background: #f1f1f1;
        color: #555555;
        border-right: 1px solid #c3c3c3;
    }
    .stripeLiveEnable{
        display: none;
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
        width: 44px;
        height: 16px;
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
        border-radius: 50px;
        transition: background 0.4s;
    }
    input.cmn-toggle-round + label:after {
        width: 16px;
        background-color: #fff;
        border-radius: 100%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        transition: margin 0.4s;
    }
    input.cmn-toggle-round:checked + label:before {
        background-color: #8ce196;
    }
    input.cmn-toggle-round:checked + label:after {
        margin-left:25px;
    }
    .bootstrap-timepicker-widget table td input{
        width: 60px;

    }
</style>
<script>
    var counter = 0;
    var errorFields = '';
    var appCommErr = false;
    
    var isLaterBookingEnabled;
    var topic;
    function isNumberKey(evt)
    {
//        $("#timeForacceptBookingErr").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $(document).ready(function ()
    {
        $(document).ajaxComplete(function () {
        // console.log("hsdfsdf");
        var access_right_pg = '<?= $access_right_pg ?>';
        if (access_right_pg == 000) {
    //   base_url().'index.php?/superadmin/access_denied';
        } else if (access_right_pg == 100) {
            $('.cls110').remove();
            $('.cls111').remove();
        } else if (access_right_pg == 110) {
            $('.cls111').remove();
        } 
    });
        setTimeout(function () {
            $('.cs-loader').hide();
        }, 1000);


        $('.pushTopicButton').click(function () {
            var d = new Date();
            $('#inputAllDriverPushTopic').val('allDrivers_' + d.getTime());
            $('#inputAllCitiesPushTopic').val('allCitiesDrivers_' + d.getTime());
//            $('#inputAllOutZonePushTopic').val('OutZoneDrivers_' + d.getTime());
            $('#inputAllCustomersPushTopic').val('allCustomers_' + d.getTime());
            $('#inputAllCitiesCustomerPushTopic').val('allCitiesCustomers_' + d.getTime());
//            $('#inputAllOutZoneCustomersPushTopic').val('OutZoneCustomers_' + d.getTime());

        });





        $('#save').click(function ()
        {

            if ($('#scheduledBookingsOnOFF').is(':checked'))
                isLaterBookingEnabled = true;
            else
                isLaterBookingEnabled = false;


            $('.errors').text('');

            if ($('#currencySymbol').val() == '' && $('#currency').val() == '')
            {
                errorFields += "Currency";
//                $('#currencyErr').text('Please enter currency');
            }
            if ($('#IOS_Driver').val() == '')
            {
                errorFields += "IOS Driver App Version";
            }
            if ($('#IOS_Customer').val() == '')
            {
                errorFields += "IOS Customer App Version";
            }
            if ($('#Android_Driver').val() == '')
            {
                errorFields += "Android Driver App Version";
            }
            if ($('#Android_Customer').val() == '')
            {

                errorFields += "Android Customer App Version";
            }

            if ($('#paymentCycleTrigger').val() == '')
            {
                errorFields += "Payment Cycle Trigger";
            }
            if ($('#appCommission').val() == '')
            {
                errorFields += ",App commission";
//                $('#appCommissionErr').text('Please enter app commission in %');
            }
            if (parseInt($('#appCommission').val()) > 99)
            {
                appCommErr = true;
                errorFields += ",App commission should not be more that 99 %";
//                $('#appCommissionErr').text('App commission should not be more that 99 %');
            }



            if ($('#timeForacceptBooking').val() == '')
            {
                appCommErr = false;
                errorFields += ",Time for accept the booking";
//                $($activePaymentGateways'#timeForacceptBookingErr').text('Please enter time');
            }

            //Publish settings
            if ($('#homePageInterval').val() == '')
            {
                appCommErr = false;
                errorFields += ",Time interval for home page";
//                $('#timeForacceptBookingErr').text('Please enter time');
            }
            if ($('#timedOutTimeInterval').val() == '')
            {
                appCommErr = false;
                errorFields += ",Timed out Time interval for home page";
//                $('#timeForacceptBookingErr').text('Please enter time');
            }


            if ($('#timeForDriverAck').val() == '')
            {
                appCommErr = false;
                errorFields += ",Time for driver to acknowledge a new booking";
//                $('#timeForacceptBookingErr').text('Please enter time');
            }
//            if ($('#centralDispatchTime').val() == '')
//            {
//                appCommErr = false;
//                errorFields += ',Central time in hour';
////               $('#dispatchStartTimeErr').text('Please enter dispatch time in hour');
//            }
//            if ($('#dispatchTime').val() == '')
//            {
//                appCommErr = false;
//                errorFields += ', time in hour';
////               $('#dispatchStartTimeErr').text('Please enter dispatch time in hour');
//            }

            if ($('#dispatchHourStartTime').val() == '' && isLaterBookingEnabled)
            {
                appCommErr = false;
                errorFields += ',Dispatch time in hour';
//               $('#dispatchStartTimeErr').text('Please enter dispatch time in hour');
            }
            if ($('#dispatchHourStartTime').val() > 59 && isLaterBookingEnabled)
            {
                appCommErr = false;
                errorFields += ',Invalid hour entered in dispatch start time ';
//               $('#dispatchStartTimeErr').text('Invalid hour');
            }
            if ($('#dispatchMinStartTime').val() == '' && isLaterBookingEnabled)
            {
                appCommErr = false;
                errorFields += ',Dispatch time';
//               $('#dispatchStartTimeErr').text('Please enter dispatch time in minutes');
            }
            if ($('#dispatchMinStartTime').val() > 59 && isLaterBookingEnabled)
            {
                appCommErr = false;
                errorFields += ',Invalid minutes entered in dispatch start time';
//               $('#dispatchStartTimeErr').text('Invliad minutes');
            }

            if ($('#bookLaterExpQueueMin').val() == '' && isLaterBookingEnabled)
            {
                appCommErr = false;
                errorFields += ',Book Later Expires from Dispatch queue';
//               $('#dispatchStartTimeErr').text('Invliad minutes');
            }


            if ($('#dispatchDuration').val() == '')
            {
                appCommErr = false;
                errorFields += ',Auto Dispatch time duration';
//                 $('#dispatchDurationErr').text('Please enter time duration');
            }
//            if ($('#centralDispatchTime').val() == '')
//            {
//                appCommErr = false;
//                errorFields += ',Central Dispatch time duration';
////                 $('#dispatchDurationErr').text('Please enter time duration');
//            }
//            if ($('#dispatchTime').val() == '')
//            {
//                appCommErr = false;
//                errorFields += ', Dispatch time duration';
////                 $('#dispatchDurationErr').text('Please enter time duration');
//            }
            if ($('#customerHomePageInterval').val() == '')
            {
                appCommErr = false;
                errorFields += ',Time interval for home page';
//                 $('#dispatchDurationErr').text('Please enter time duration');
            }
            if ($('#presenceTime').val() == '')
            {
                appCommErr = false;
                errorFields += ',PresenceTime';
//                 $('#dispatchDurationErr').text('Please enter time duration');
            }
            if ($('#routeDistance').val() == '')
            {
                appCommErr = false;
                errorFields += ',Route distance lat long update';
//                 $('#dispatchDurationErr').text('Please enter time duration');
            }
            if (errorFields)
            {
                if (errorFields.charAt(0) == ',')
                    errorFields = errorFields.substr(1);
                //check for app comm
                if (!appCommErr)
                    alert("Please do not leave the field for " + errorFields + " blank");
                else
                    alert('App commission should not be more that 99 %');
            }
//           else{
            $('#updateAppConfig').submit();
//           }
        });

<?php
//Active payment gateways

foreach ($activePaymentGateways as $payment) {
    ?>
            counter += 1;
            $('.span-paymentGatewaysListDiv').show();
            $('.paymentGatewaysListDiv').show();
            var value = '<?php echo $payment; ?>';
    //            console.log(value);
            $('.paymentGatewaysListDiv').append('<span class="tag label label-info" id="span-active-' + counter + '">' + value + '<input  style="display:none;" name="paymentGateways[]" class="inputDesc" id="paymentGatewayId-' + counter + '" type="text"  value="' + value + '"><span class="RemoveMore" data-id="' + counter + '" style="">x</span></span>');

    <?php
}
?>
<?php
//Inactive payment gateways
foreach ($inActivePaymentGateways as $payment) {
    ?>

            counter += 1;
            $('.span-inActivePaymentGatewaysListDiv').show();
            $('.inActivePaymentGatewaysListDiv').show();
            var value = '<?php echo $payment; ?>';
            $('.inActivePaymentGatewaysListDiv').append('<span class="tag label label-info" id="span-inActive-' + counter + '">' + value + '<input  style="display:none;" name="inActivePaymentGateways[]" class="inActiveInputDesc" id="inActivePaymentGatewayId-' + counter + '" type="text"  value="' + value + '"><span class="RemoveMore-inActive" data-id="' + counter + '" style="">x</span></span>');

    <?php
}
?>
        $('#paymentGateways').click(function ()
        {
            var isAlready = false;
            if ($('#inputPaymentGateway').val() == '')
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Input field should not be empty');
            } else {

                //Check if already was added
                $('.inputDesc,.inActiveInputDesc').each(function () {
                    if ($('#inputPaymentGateway').val().toUpperCase() == $(this).val().toUpperCase())
                    {
                        $('#alertForNoneSelected').modal('show');
                        $("#display-data").text('Same payment gateways should not allow');
                        isAlready = true;
                    }

                })
                if (isAlready === false) {
                    counter += 1;
                    $('.span-paymentGatewaysListDiv').show();
                    $('.paymentGatewaysListDiv').show();

                    $('.paymentGatewaysListDiv').append('<span class="tag label label-info" id="span-active-' + counter + '">' + $('#inputPaymentGateway').val().toUpperCase() + '<input  style="display:none;" name="paymentGateways[]" class="inputDesc" id="paymentGatewayId-' + counter + '" type="text"  value="' + $('#inputPaymentGateway').val().toUpperCase() + '"><span class="RemoveMore" data-id="' + counter + '" style="">x</span></span>');
                    $('#inputPaymentGateway').val('');
                }

            }
        });


        $(document).on('click', '.RemoveMore', function ()
        {
            $('.inActivePaymentGatewaysListDiv').show();
            $('.span-inActivePaymentGatewaysListDiv').show();
            $('.inActivePaymentGatewaysListDiv').append('<span class="tag label label-info" id="span-inActive-' + $(this).attr('data-id') + '">' + $('#paymentGatewayId-' + $(this).attr('data-id')).val() + '<input  style="display:none;" name="inActivePaymentGateways[]" class="inActiveInputDesc" id="inActivePaymentGatewayId-' + $(this).attr('data-id') + '" type="text"  value="' + $('#paymentGatewayId-' + $(this).attr('data-id')).val() + '"><span class="RemoveMore-inActive" data-id="' + $(this).attr('data-id') + '" style="">x</span></span>');
            $('#span-active-' + $(this).attr('data-id')).remove();

            var countPaymentGateways = $('.inputDesc').length;
            if (countPaymentGateways > 0)
            {
                $('.paymentGatewaysListDiv').show();
                $('.span-paymentGatewaysListDiv').show();
            } else
            {
                $('.paymentGatewaysListDiv').hide();
                $('.span-paymentGatewaysListDiv').hide();
            }
        });
        $(document).on('click', '.RemoveMore-inActive', function ()
        {
            $('.paymentGatewaysListDiv').show();
            $('.span-paymentGatewaysListDiv').show();
            $('.paymentGatewaysListDiv').append('<span class="tag label label-info" id="span-active-' + $(this).attr('data-id') + '">' + $('#inActivePaymentGatewayId-' + $(this).attr('data-id')).val() + '<input  style="display:none;" name="paymentGateways[]" class="inputDesc" id="paymentGatewayId-' + $(this).attr('data-id') + '" type="text"  value="' + $('#inActivePaymentGatewayId-' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('data-id') + '" style="">x</span></span>');

            $('#span-inActive-' + $(this).attr('data-id')).remove();

            var countPaymentGateways = $('.inActiveInputDesc').length;
            if (countPaymentGateways > 0)
            {
                $('.inActivePaymentGatewaysListDiv').show();
                $('.span-inActivePaymentGatewaysListDiv').show();
            } else
            {
                $('.inActivePaymentGatewaysListDiv').hide();
                $('.span-inActivePaymentGatewaysListDiv').hide();
            }

        });



        $('.number').keypress(function (event) {
            if (event.which < 46
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if (event.which == 46
                    && $(this).val().indexOf('.') != -1) {
                event.preventDefault();
            } // prevent if already dot
        });

        $('#appCommission').blur(function ()
        {
            $('#appCommissionErr').text('');
            if (parseInt($('#appCommission').val()) > 99)
                $('#appCommissionErr').text('App commission should not be more that 99 %');


        });

        var cardPayment = '<?php echo $cardPayment; ?>';
        var cashPayment = '<?php echo $cashPayment; ?>';
        var walletPayment = '<?php echo $walletPayment; ?>';

        //Payment Methods--CARD
        if (cardPayment)
            $('#cardPayment').attr('checked', true);
        else
            $('#cardPayment').attr('checked', false);

        //Payment Methods--CASH
        if (cashPayment)
            $('#cashPayment').attr('checked', true);
        else
            $('#cashPayment').attr('checked', false);

        //Payment Methods--WALLET
        if (walletPayment)
            $('#walletPayment').attr('checked', true);
        else
            $('#walletPayment').attr('checked', false);




        var zonalPricing = '<?php echo $zonalPricing ?>';
        var mileagePricing = '<?php echo $mileagePricing ?>';

        var walletShipperEnable = '<?php echo $walletShipperEnable; ?>';
        var walletDriverEnable = '<?php echo $walletDriverEnable; ?>';
        var walletStoreEnable = '<?php echo $walletStoreEnable; ?>';
        var paidByReceiver = '<?php echo $paidByReceiver; ?>';

        //Paid by customer
        if (paidByReceiver)
        {
            $('#paidByReceiver').attr('checked', true);
            $('#paidByReceiverPreviousState').val('1');
        } else
        {
            $('#paidByReceiver').attr('checked', false);
            $('#paidByReceiverPreviousState').val('0');
        }

        //Shipper
        if (walletShipperEnable)
        {
            $('#shipperSoftHardLimitEnDis').attr('checked', true);
            $('.shipperWallet').show();
        } else
        {
            $('#shipperSoftHardLimitEnDis').attr('checked', false);
            $('.shipperWallet').hide();
        }

        //Driver
        if (walletDriverEnable)
        {
            $('#driverSoftHardLimitEnDis').attr('checked', true);
            $('.driverWallet').show();
        } else
        {
            $('#driverSoftHardLimitEnDis').attr('checked', false);
            $('.driverWallet').hide();
        }
        if (walletStoreEnable)
        {
            $('#storeSoftHardLimitEnDis').attr('checked', true);
            $('.storeWallet').show();
        } else
        {
            $('#storeSoftHardLimitEnDis').attr('checked', false);
            $('.storeWallet').hide();
        }

        if (mileagePricing == 1)
            $('#cmn-toggle-1').attr('checked', true);
        else
            $('#cmn-toggle-1').attr('checked', false);

        if (zonalPricing == 1)
            $('#cmn-toggle-2').attr('checked', true);
        else
        {
            $('#cmn-toggle-2').attr('checked', false);
            $('#longHaulZonal').attr('disabled', true);
            $('#shortHaulZonal').attr('disabled', true);
        }


        var scheduledBookingsOnOFF = '<?php echo $scheduledBookingsOnOFF ?>';
        if (scheduledBookingsOnOFF == 1 || scheduledBookingsOnOFF == '')
        {
            $('#scheduledBookingsOnOFF').attr('checked', true);
            $('.ScheduleBooking').show();
        } else
        {
            $('#scheduledBookingsOnOFF').attr('checked', false);
            $('.ScheduleBooking').hide();
        }

        var dispacthMode = '<?php echo $dipatchMode; ?>';
        if (dispacthMode == 1 || dispacthMode == '')
        {
            $('#dipatchModeAuto').attr('checked', true);
            $('#dipatchModeValue').val('1');
            $('.autoToCentralDispatch').show();
        } else
        {
            $('#dipatchModeManual').attr('checked', true);
            $('#dipatchModeValue').val('0');
            $('.autoToCentralDispatch').hide();
        }

        //longHual
        var paymentMode = '<?php echo $paymentMode ?>';
        if (paymentMode == 1)
            $('#paymentMode').attr('checked', true);
        else
            $('#paymentMode').attr('checked', false);

        //longHual
        var longHaul = '<?php echo $longHaul ?>';
        if (longHaul == 1 || longHaul == '')
            $('#longHaulMileage').attr('checked', true);
        else
            $('#longHaulZonal').attr('checked', true);

        //shortHual
        var shortHaul = '<?php echo $shortHaul ?>';
        if (shortHaul == 1 || shortHaul == '')
            $('#shortHaulMileage').attr('checked', true);
        else
            $('#shortHaulZonal').attr('checked', true);

        //referralSettings
        var referralCodeSendByEmail = '<?php echo $referralCodeSendByEmail ?>';
        if (referralCodeSendByEmail == 1)
            $('#referralCodeSentYes').attr('checked', true);
        else
            $('#referralCodeSentNo').attr('checked', true);


        var referralCodeSendByTestMsg = '<?php echo $referralCodeSendByTestMsg ?>';
        if (referralCodeSendByTestMsg == 1)
            $('#referralCodeSendByTestMsgYes').attr('checked', true);
        else
            $('#referralCodeSendByTestMsgNo').attr('checked', true);

//              
        //set Distance
        $('#mileage_metric').val('<?php echo $mileage_metric; ?>');
        $('#weightMetric').val('<?php echo $weight_metric; ?>');
        $('#paymentCycleTrigger').val('<?php echo $paymentCycleTrigger; ?>');

        console.log('<?php echo $paymentCycleTrigger; ?>');


        $(".c_moveUp").click(function (e) {
            var event = e || window.event;
            event.preventDefault();
            var row = $(this).closest('tr');
            row.prev().insertAfter(row);
            $('#row_order').trigger('click');
        });

        $(".c_moveDown").click(function (e) {
            var event = e || window.event;
            event.preventDefault();
            var row = $(this).closest('tr');
            row.insertAfter(row.next());
            $('#row_order').trigger('click');

        });

        $('#paymentGateway').click(function ()
        {
            if ($('#paymentGateway').is(':checked'))
            {
                $('.stripeLiveEnable').show();
                $('.stripeTestEnable').hide();
            } else {

                $('.stripeLiveEnable').hide();
                $('.stripeTestEnable').show();
            }
        });


        //Customer Wallet setting Enable/Disable
        $('#shipperSoftHardLimitEnDis').change(function ()
        {
            if ($(this).is(':checked'))
                $('.shipperWallet').show();
            else
                $('.shipperWallet').hide();
        });


        //Driver Wallet setting Enable/Disable
        $('#driverSoftHardLimitEnDis').change(function ()
        {
            if ($(this).is(':checked'))
                $('.driverWallet').show();
            else
                $('.driverWallet').hide();
        });

        $('#cmn-toggle-1').click(function ()
        {
            if ($('#cmn-toggle-1').is(':checked'))
            {

                if ($('#cmn-toggle-2').is(':checked'))
                {
                    $('#longHaulZonal').attr('disabled', false);
                    $('#shortHaulZonal').attr('disabled', false);
                } else {
                    $('#longHaulZonal').attr('disabled', true);
                    $('#shortHaulZonal').attr('disabled', true);
                }

                $('#longHaulMileage').attr('disabled', false);
                $('#shortHaulMileage').attr('disabled', false);

                $('#longHaulMileage').attr('checked', true);
                $('#shortHaulMileage').attr('checked', true);

            } else {

                if ($('#cmn-toggle-2').is(':checked'))
                {
                    $('#longHaulZonal').attr('disabled', false);
                    $('#shortHaulZonal').attr('disabled', false);

                    $('#longHaulZonal').attr('checked', true);
                    $('#shortHaulZonal').attr('checked', true);
                } else {
                    $('#longHaulMileage').attr('checked', true);
                    $('#shortHaulMileage').attr('checked', true);

                }
                $('#longHaulMileage').attr('disabled', true);
                $('#shortHaulMileage').attr('disabled', true);

            }
        });

        $('#autoBookNowDispatchRation').keyup(function ()
        {

            if ($('#autoBookNowDispatchRation').val() != '')
            {
                if ($('#autoBookNowDispatchRation').val() > 100)
                {
                    $('#autoBookNowDispatchRation').val('');
                    $('#centralBookNowDispatchRation').val('');
                } else {
                    remainingPerc = 100 - parseInt($('#autoBookNowDispatchRation').val());
                    $('#centralBookNowDispatchRation').val(remainingPerc);
                }
            } else
                $('#centralBookNowDispatchRation').val('');
        });

        $('.dipatchMode').click(function ()
        {
            if ($(this).val() == 1)
            {
                $('#dipatchModeValue').val('1');
                $('.autoToCentralDispatch').show();

            } else
            {
                $('#dipatchModeValue').val('0');
                $('.autoToCentralDispatch').hide();
            }

        });

        $('#autoDispatchRation').keyup(function ()
        {

            if ($('#autoDispatchRation').val() != '')
            {
                if ($('#autoDispatchRation').val() > 100)
                {
                    $('#autoDispatchRation').val('');
                    $('#centralDispatchRation').val('');
                } else {
                    remainingPerc = 100 - parseInt($('#autoDispatchRation').val());
                    $('#centralDispatchRation').val(remainingPerc);
                }
            } else
                $('#centralDispatchRation').val('');
        });



        $('#cmn-toggle-2').click(function ()
        {
            if ($('#cmn-toggle-2').is(':checked'))
            {

                if ($('#cmn-toggle-1').is(':checked'))
                {

                } else {
                    $('#longHaulZonal').attr('checked', true);
                    $('#shortHaulZonal').attr('checked', true);

                    $('#longHaulMileage').attr('disabled', true);
                    $('#shortHaulMileage').attr('disabled', true);

                }
                $('#longHaulZonal').attr('disabled', false);
                $('#shortHaulZonal').attr('disabled', false);



            } else {


                $('#longHaulZonal').attr('disabled', true);
                $('#shortHaulZonal').attr('disabled', true);

                $('#longHaulMileage').attr('disabled', false);
                $('#shortHaulMileage').attr('disabled', false);

                $('#longHaulMileage').attr('checked', true);
                $('#shortHaulMileage').attr('checked', true);
            }
        });

        $('#scheduledBookingsOnOFF').click(function ()
        {
            if ($('#scheduledBookingsOnOFF').is(':checked'))
            {
                $('.ScheduleBooking').show();
            } else {

                $('.ScheduleBooking').hide();
            }
        });



       


//        $('#hardLimitForShipper').keydown(function ()
//        {
//             if ($('#hardLimitForShipper').val() != '')
//            {
//                if (parseInt($('#hardLimitForShipper').val()) <= parseInt($('#softLimitForShipper').val()))
//                {
//                    $('#hardLimitForShipper').val('');
//                    $('#hardLimitForShipperErr').val('Hard limit should be greater than soft limit');
//                } else {
//                  $('#hardLimitForShipperErr').val('');
//                }
//            }
//            
//        });

    });

$(document).ready(function(){
    var shiftBufferTimings='<?php echo $shiftBufferTimings;?>'
    $('#shiftBufferTimings').val(shiftBufferTimings);

});

</script>
<style>
    input[type=checkbox], input[type=radio] {
        margin: 4px 2px 0px;
    }
</style>


<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;

             color: gray;
             margin-left: 30px;padding-top: 20px;">

            <strong style="color:#0090d9;"><?php echo $this->lang->line('APP_CONFIGURATION'); ?></strong>
        </div>

        <div class="">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">

                    <div class="tab-content">
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
                                    <div class="col-sm-12">
                                    <a href="<?php echo base_url()?>index.php?/superadmin/googleKeys" class="pull-right">
                                    <button type="button" class="btn btn-primary cls110">Google key</button></a>
                                    </div>

                                </div>
                                &nbsp;
                                <div class="panel-body">

                                    <div class="form-group col-md-1"></div>
                                    <div class="col-md-9" style="border-style:solid;padding:20px;">
                                        <form id="updateAppConfig" method="post" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/superadmin/updateAppConfigNew"  enctype="multipart/form-data"> 
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('APP_SETTINGS'); ?></label>
                                            </div>

                                            <!--                                            <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Currency</label>
                                                                                            <div class="col-sm-3 pos_relative2">
                                                                                                <span  class="abs_text"><b>Symbol</b></span>
                                                                                                <input type="text" class="form-control" id="currencySymbol" name="currencySymbol" placeholder="Symbol"   value="<?php echo $currencySym; ?>">
                                                                                            </div>
                                                                                            <div class="col-sm-3 pos_relative2">
                                                                                                <span  class="abs_text"><b>Short Form</b></span>
                                                                                                <input type="text" class="form-control" id="currency" name="currency" placeholder="Currency"   value="<?php echo $currency; ?>">
                                                                                            </div>
                                                                                            <div class="col-sm-2 errors" id="currencyErr"></div>
                                                                                        </div>
                                            
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Distance</label>
                                            
                                                                                            <div class="col-sm-3">
                                                                                                <select class="form-control" id="mileage_metric" name="mileage_metric" style="padding-left: 45px;">
                                                                                                    <option value="0"><?php echo unserialize(DistanceMetric)[0]; ?></option>
                                                                                                    <option value="1"><?php echo unserialize(DistanceMetric)[1]; ?></option>
                                                                                                </select> 
                                            
                                                                                            </div>
                                            
                                                                                        </div>
                                            
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Weight</label>
                                                                                            <div class="col-sm-3">
                                                                                                <select class="form-control" id="weightMetric" name="weightMetric" style="padding-left: 45px;">
                                                                                                    <option value="0"><?php echo unserialize(WeightMetric)[0]; ?></option>
                                                                                                    <option value="1"><?php echo unserialize(WeightMetric)[1]; ?></option>
                                                                                                </select> 
                                                                                            </div>
                                                                                        </div>-->
                                            <!--                                            <div class="form-group">
                                                                                        <label for="" class="control-label col-md-4">App Commission</label>
                                                                                        <div class="col-sm-3">
                                                                                             <span class="abs_text"><b>%</b></span>
                                                                                             <input type="text" id="appCommission" name="appCommission" placeholder="App Commission" class="form-control number" onkeypress="return isNumberKey(event)" value="<?php echo $appCommission; ?>" readonly="">
                                                                                            
                                                                                        </div>
                                                                                        <div class="col-sm-2 errors" id="appCommissionErr"></div>
                                                                                      </div>-->


                                            <!--                                            <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4"><p style="color:#8356a9">App Version</p>
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">IOS-Driver</label>
                                                                                            <div class="col-sm-3">
                                                                                                <input type="text" id="IOS_Driver" name="IOS_Driver"  class="form-control appVersions"  value="<?php echo $ios_driver; ?>">
                                            
                                                                                            </div>
                                                                                            <div class="col-sm-2 errors" id="appCommissionErr"></div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">IOS-Customer</label>
                                                                                            <div class="col-sm-3">
                                                                                                <input type="text" id="IOS_Customer" name="IOS_Customer"  class="form-control appVersions"  value="<?php echo $ios_customer; ?>">
                                            
                                                                                            </div>
                                                                                            <div class="col-sm-2 errors" id="appCommissionErr"></div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Android-Driver</label>
                                                                                            <div class="col-sm-3">
                                                                                                <input type="text" id="Android_Driver" name="Android_Driver"  class="form-control appVersions"  value="<?php echo $andriod_driver; ?>">
                                            
                                                                                            </div>
                                                                                            <div class="col-sm-2 errors" id="appCommissionErr"></div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Android-Customer</label>
                                                                                            <div class="col-sm-3">
                                                                                                <input type="text" id="Android_Customer" name="Android_Customer"  class="form-control appVersions"  value="<?php echo $andriod_customer; ?>">
                                            
                                                                                            </div>
                                                                                            <div class="col-sm-2 errors" id="appCommissionErr"></div>
                                                                                        </div>-->
                                            <hr/>
                                            <br>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('SECURITY_SETTINGS'); ?></label>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Access_Token'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                    <input type="text" class="form-control" id="accessToken" name="accessToken" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $accessToken; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="accessTokenErr"></div>
                                            </div>
											
                                            <hr/>
                                            <br>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('STORE_SETTINGS'); ?></label>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('storeDefaultCommission'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b>%</b></span>
                                                    <input type="text" maxlength="3" class="form-control" id="storeDefaultCommission " name="storeDefaultCommission" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $storeDefaultCommission; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="storeDefaultCommissionErr"></div>
                                            </div>

                                             <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('storeCommisionOnDeliveryFee'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b>%</b></span>
                                                    <input type="text" maxlength="3" class="form-control" id="storeCommisionOnDeliveryFee " name="storeCommisionOnDeliveryFee" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $storeCommisionOnDeliveryFee; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="storeCommisionOnDeliveryFeeErr"></div>
                                            </div>

                                            <hr/>
                                            <br>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('LAUNDRY_SETTINGS'); ?></label>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('timeForNormalDelivery'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('hours'); ?></b></span>
                                                    <input type="text" maxlength="3" class="form-control" id="timeForNormalDelivery " name="timeForNormalDelivery" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $timeForNormalDelivery; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="timeForExpressDeliveryErr"></div>
                                            </div>

                                             <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('timeForExpressDelivery'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('hours'); ?></b></span>
                                                    <input type="text" maxlength="3" class="form-control" id="timeForExpressDelivery " name="timeForExpressDelivery" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $timeForExpressDelivery; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="timeForExpressDeliveryErr"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('defaultFeeForNormalDelivery'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('hours'); ?></b></span>
                                                    <input type="text" maxlength="3" class="form-control" id="defaultFeeForNormalDelivery " name="defaultFeeForNormalDelivery" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $defaultFeeForNormalDelivery; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="defaultFeeForNormalDeliveryErr"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('defaultFeeForExpressDelivery'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('hours'); ?></b></span>
                                                    <input type="text" maxlength="3" class="form-control" id="defaultFeeForExpressDelivery " name="defaultFeeForExpressDelivery" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $defaultFeeForExpressDelivery; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="defaultFeeForExpressDeliveryErr"></div>
                                            </div>

                                            <!-- recommanded time consumption -->
                                            <hr/>
                                            <br>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('RECOMMANDEDTIME'); ?></label>
                                            </div>

                                            <!-- <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('BREAKEFAST'); ?></label>
                                                <div class="col-sm-3">
                                                   
                                                    <input type="text"  class="form-control" id="breakfast " name="breakfast" placeholder="" value="<?php echo $breakfast; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="breakfastErr"></div>
                                                </div> -->
                                                <!-- timepicker  cool-->
                                                <div class="form-group">
                                                    <label for="breakfast" class="col-sm-4 control-label"><?php echo $this->lang->line('BREAKEFAST'); ?></label>
                                                    <div class="col-md-1 col-sm-2 col-xs-12" style="margin-top: 8px;width: 5%;"> <span>From</span></div>
                                                     <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                                                        <!-- <input type="text" name="breakfasttime" class="form-control timepicker" id="breakfasttime" value="<?php echo $breakfastTime; ?>" /> -->
                                                         <input type='text' class="form-control" name="breakfasttime"  id="breakfasttime" value="<?php echo $breakfastTime; ?>" />
                                                                   
                                                    </div>
                                               
                                                    <div class="col-md-1 col-sm-2 col-xs-12" style="margin-top: 8px;width: 5%;"> <span>To</span></div>
                                                    <div class="col-md-2 col-sm-1 col-xs-12 bootstrap-timepicker">
                                                        <!-- <input type="text" name="breakfastEndtime" class="form-control timepicker" id="breakfastEndtime" value="<?php echo $breakfastEndTime; ?>" /> -->
                                                        <input type='text' class="form-control" name="breakfastEndtime"  id="breakfastEndtime" value="<?php echo $breakfastEndTime; ?>" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="brunch" class="col-sm-4 control-label"><?php echo $this->lang->line('BRUNCH'); ?></label>
                                                    <div class="col-md-1 col-sm-2 col-xs-12" style="margin-top: 8px;width: 5%;"> <span>From</span></div>
                                                    <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                                                        <!-- <input type="text" name="brunchtime" class="form-control timepicker" id="brunchtime" value="<?php echo $brunchTime; ?>" /> -->
                                                        <input type='text' class="form-control" name="brunchtime"  id="brunchtime" value="<?php echo $brunchTime; ?>" />
                                                    </div>
                                                    <div class="col-md-1 col-sm-2 col-xs-12" style="margin-top: 8px;width: 5%;"> <span>To</span></div>
                                                    <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                                                        <!-- <input type="text" name="brunchEndtime" class="form-control timepicker" id="brunchEndtime" value="<?php echo $brunchEndTime; ?>" /> -->
                                                        <input type='text' class="form-control" name="brunchEndtime"  id="brunchEndtime" value="<?php echo $brunchEndTime; ?>" />
                                                    </div>

                                                </div>

                                                 <div class="form-group">
                                                    <label for="lunch" class="col-sm-4 control-label"><?php echo $this->lang->line('LUNCH'); ?></label>
                                                    <div class="col-md-1 col-sm-2 col-xs-12" style="margin-top: 8px;width: 5%;"> <span>From</span></div>
                                                    <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                                                        <!-- <input type="text" name="lunchtime" class="form-control timepicker" id="lunchtime" value="<?php echo $lunchTime; ?>" /> -->
                                                        <input type='text' class="form-control" name="lunchtime"  id="lunchtime" value="<?php echo $lunchTime; ?>" />
                                                    </div>
                                                    <div class="col-md-1 col-sm-2 col-xs-12" style="margin-top: 8px;width: 5%;"> <span>To</span></div>
                                                    <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                                                        <!-- <input type="text" name="lunchEndtime" class="form-control timepicker" id="lunchEndtime" value="<?php echo $lunchEndTime; ?>" /> -->
                                                        <input type='text' class="form-control" name="lunchEndtime"  id="lunchEndtime" value="<?php echo $lunchEndTime; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tea" class="col-sm-4 control-label"><?php echo $this->lang->line('TEA'); ?></label>
                                                    <div class="col-md-1 col-sm-2 col-xs-12" style="margin-top: 8px;width: 5%;"> <span>From</span></div>
                                                    <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                                                        <!-- <input type="text" name="teatime" class="form-control timepicker" id="teatime" value="<?php echo $teaTime; ?>" /> -->
                                                        <input type='text' class="form-control" name="teatime"  id="teatime" value="<?php echo $teaTime; ?>" />
                                                    </div>
                                                    <div class="col-md-1 col-sm-2 col-xs-12" style="margin-top: 8px;width: 5%;"> <span>To</span></div>
                                                    <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                                                        <!-- <input type="text" name="teaEndtime" class="form-control timepicker" id="teaEndtime" value="<?php echo $teaEndTime; ?>" /> -->
                                                        <input type='text' class="form-control" name="teaEndtime"  id="teaEndtime" value="<?php echo $teaEndTime; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="dinner" class="col-sm-4 control-label"><?php echo $this->lang->line('DINNER'); ?></label>
                                                    <div class="col-md-1 col-sm-2 col-xs-12" style="margin-top: 8px;width: 5%;"> <span>From</span></div>
                                                    <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                                                        <!-- <input type="text" name="dinnertime" class="form-control timepicker" id="dinnertime" value="<?php echo $dinnerTime; ?>" /> -->
                                                        <input type='text' class="form-control" name="dinnertime"  id="dinnertime" value="<?php echo $dinnerTime; ?>" />
                                                    </div>
                                                    <div class="col-md-1 col-sm-2 col-xs-12" style="margin-top: 8px;width: 5%;"> <span>To</span></div>
                                                    <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                                                        <!-- <input type="text" name="dinnerEndtime" class="form-control timepicker" id="dinnerEndtime" value="<?php echo $dinnerEndTime; ?>" /> -->
                                                        <input type='text' class="form-control" name="dinnerEndtime"  id="dinnerEndtime" value="<?php echo $dinnerEndTime; ?>" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="latenightdinner" class="col-sm-4 control-label"><?php echo $this->lang->line('LATENIGHTDINNER'); ?></label>
                                                    <div class="col-md-1 col-sm-2 col-xs-12" style="margin-top: 8px;width: 5%;"> <span>From</span></div>
                                                    <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                                                        <!-- <input type="text" name="latenightdinnertime" class="form-control timepicker" id="latenightdinnertime" value="<?php echo $latenightDinnerTime; ?>" /> -->
                                                        <input type='text' class="form-control" name="latenightdinnertime"  id="latenightdinnertime" value="<?php echo $latenightDinnerTime; ?>" />
                                                    </div>
                                                    <div class="col-md-1 col-sm-2 col-xs-12" style="margin-top: 8px;width: 5%;"> <span>To</span></div>
                                                    <div class="col-md-2 col-sm-2 col-xs-12 bootstrap-timepicker">
                                                        <!-- <input type="text" name="latenightdinnerEndtime" class="form-control timepicker" id="latenightdinnerEndtime" value="<?php echo $latenightDinnerEndTime; ?>" /> -->
                                                        <input type='text' class="form-control" name="latenightdinnerEndtime"  id="latenightdinnerEndtime" value="<?php echo $latenightDinnerEndTime; ?>" />
                                                    </div>
                                                </div>

                                                <!-- timepicker end -->

                                            
                                              <!-- end of recommanded time consumption   -->








                                            <!--                                            <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Refresh_Token'); ?></label>
                                                                                            <div class="col-sm-3">
                                                                                                <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                                                                <input type="text" class="form-control" id="refreshToken" name="refreshToken" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $refreshToken; ?>">
                                                                                            </div>
                                                                                            <div class="col-sm-3 error-box" id="refreshTokenErr"></div>
                                                                                        </div>-->
                                                                                        <hr/>
                                            <br>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo 'SHIFT CONFIGURATION'; ?></label>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo 'Shift Timings'; ?></label>
                                                <div class="col-sm-3">
                                                    <select class="form-control shiftBufferTimings" id="shiftBufferTimings" name="shiftBufferTimings">
                                                        <option value="30">30 Minutes</option>
                                                        <option value="40">40 Minutes</option>
                                                        <option value="50">50 Minutes</option>
                                                        <option value="60">60 Minutes</option>
                                                        <option value="70">70 Minutes</option>
                                                        <option value="80">80 Minutes</option>
                                                        <option value="90">90 Minutes</option>
                                                        <option value="100">100 Minutes</option>
                                                        <option value="110">110 Minutes</option>
                                                        <option value="120">120 Minutes</option>
                                                    </select>
                                                   
                                                </div>                                                
                                            </div>


                                            <hr/>
                                            <br>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('FORGOT_PASSWORD_SETTINGS'); ?></label>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Max_Attempt_For_Forgot_Password'); ?></label>
                                                <div class="col-sm-3">

                                                    <input type="text" class="form-control" id="maxAttemptForgotPassword" name="maxAttemptForgotPassword" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $maxAttemptForgotPassword; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="maxAttemptForgotPasswordErr"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Max_Attempt_For_OTP'); ?></label>
                                                <div class="col-sm-3">

                                                    <input type="text" class="form-control" id="maxAttemptOtp" name="maxAttemptOtp" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $maxAttemptOtp; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="maxAttemptOtpErr"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('OTP_Expire_Time'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                    <input type="text" class="form-control" id="otpExpiryTime" name="otpExpiryTime" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $otpExpiryTime; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="otpExpiryTimeErr"></div>
                                            </div>
											<div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('resetPasswordLinkExpirys'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                    <input type="text" class="form-control" id="resetPasswordLinkExpiry" name="resetPasswordLinkExpiry" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $resetPasswordLinkExpiry; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="resetPasswordLinkExpiryErr"></div>
                                            </div>
                                            <!--                                            <hr/>
                                                                                        <br>-->

                                            <!--                                              <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('label_payment_gateways'); ?></label>
                                                                                        </div>
                                                                                        <span style="color: #1ABB9C;font-weight: 600;display: none;" class="span-paymentGatewaysListDiv"><?php echo $this->lang->line('ACTIVE'); ?></span>
                                                                                        <div class="form-group">
                                                                                            <div class="paymentGatewaysListDiv" style="padding-left: 1%;display: none;"></div>
                                                                                        </div>
                                                                                        <br>
                                                                                        <span style="color: #f0ad4e;font-weight: 600;display: none;" class="span-inActivePaymentGatewaysListDiv"><?php echo $this->lang->line('INACTIVE'); ?></span>
                                                                                        <div class="form-group">
                                                                                            <div class="inActivePaymentGatewaysListDiv" style="padding-left: 1%;display: none;"></div>
                                                                                        </div>
                                                                                        <br>
                                                                                        <div class="form-group">
                                                                                            <div class="col-sm-6">
                                                                                                <input id="inputPaymentGateway" class="form-control" type="text">
                                                                                            </div>
                                                                                            <div class="col-sm-2">
                                                                                                <button type="button" class="btn btn-primary cls110" data-id="paymentGateways" id="paymentGateways"><?php echo $this->lang->line('button_add'); ?></button>
                                                                                            </div>
                                                                                        </div>-->

                                            <!--
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;">UNIVERSAL WALLET LIMITS</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><p style="color:#8356a9">CUSTOMER</p>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4">CASH</label>
                                                <div class="col-sm-6">
                                                    <div class="switch">
                                                        <input id="paidByReceiver" name="paidByReceiver" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                        <label for="paidByReceiver"></label>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="paidByReceiverPreviousState" name="paidByReceiverPreviousState">
                                            </div> 
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4">WALLET</label>
                                                <div class="col-sm-6">
                                                    <div class="switch">
                                                        <input id="shipperSoftHardLimitEnDis" name="shipperSoftHardLimitEnDis" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                        <label for="shipperSoftHardLimitEnDis"></label>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-group shipperWallet">
                                                <label for="" class="control-label col-md-4">Soft Limit</label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $currencySym; ?></b></span>
                                                    <input type="text" class="form-control" id="softLimitForShipper" name="softLimitForShipper" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $softLimitForShipper; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="softLimitForShipperErr"></div>
                                            </div>
                                            <div class="form-group shipperWallet">
                                                <label for="" class="control-label col-md-4">Hard Limit</label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $currencySym; ?></b></span>
                                                    <input type="text" class="form-control" id="hardLimitForShipper" name="hardLimitForShipper" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $hardLimitForShipper; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="hardLimitForShipperErr"></div>
                                            </div>


                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><p style="color:#8356a9">DRIVER</p>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4">WALLET</label>
                                                <div class="col-sm-6">
                                                    <div class="switch">
                                                        <input id="driverSoftHardLimitEnDis" name="driverSoftHardLimitEnDis" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                        <label for="driverSoftHardLimitEnDis"></label>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-group driverWallet">
                                                <label for="" class="control-label col-md-4">Soft Limit</label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $currencySym; ?></b></span>
                                                    <input type="text" class="form-control" id="softLimitForDriver" name="softLimitForDriver" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $softLimitForDriver; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="softLimitForDriverErr"></div>
                                            </div>
                                            <div class="form-group driverWallet">
                                                <label for="" class="control-label col-md-4">Hard Limit</label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $currencySym; ?></b></span>
                                                    <input type="text" class="form-control" id="hardLimitForDriver" name="hardLimitForDriver" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $hardLimitForDriver; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="hardLimitForDriverErr"></div>
                                            </div>


                                            <br>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><p style="color:#8356a9">STORE</p>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4">WALLET</label>
                                                <div class="col-sm-6">
                                                    <div class="switch">
                                                        <input id="storeSoftHardLimitEnDis" name="storeSoftHardLimitEnDis" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                        <label for="storeSoftHardLimitEnDis"></label>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-group storeWallet">
                                                <label for="" class="control-label col-md-4">Soft Limit</label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $currencySym; ?></b></span>
                                                    <input type="text" class="form-control" id="softLimitForStore" name="softLimitForStore" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $softLimitForStore; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="softLimitForStoreErr"></div>
                                            </div>
                                            <div class="form-group storeWallet">
                                                <label for="" class="control-label col-md-4">Hard Limit</label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $currencySym; ?></b></span>
                                                    <input type="text" class="form-control" id="hardLimitForStore" name="hardLimitForStore" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $hardLimitForStore; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="hardLimitForStoreErr"></div>
                                            </div>-->

                                            <br>

                                            <!--                                            <hr>
                                                                                        <br>
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4" style="color: #0090d9;">PAYMENT METHODS SETUP</label>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Card</label>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="switch">
                                                                                                    <input id="cardPayment" name="cardPayment" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                                                                    <label for="cardPayment"></label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Cash</label>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="switch">
                                                                                                    <input id="cashPayment" name="cashPayment" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                                                                    <label for="cashPayment"></label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Wallet</label>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="switch">
                                                                                                    <input id="walletPayment" name="walletPayment" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                                                                    <label for="walletPayment"></label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <br>-->

                                            <!--                                            <hr>
                                                                                        <br>-->
                                            <!--                                            <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('PAYMENT_CYCLE_SETUP'); ?></label>
                                                                                        </div>-->
                                            <!--                                            <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Payment Cycle Trigger</label>
                                                                                            <div class="col-sm-3">
                                                                                                <select class="form-control" id="paymentCycleTrigger" name="paymentCycleTrigger" style="padding-left: 45px;">
                                                                                                    <option value="">Select</option>
                                                                                                    <option value="0">Daily</option>
                                                                                                    <option value="1">Weekly</option>
                                                                                                    <option value="2">Every Fortnight</option>
                                                                                                    <option value="3">Monthly</option>
                                                                                                </select> 
                                                                                            </div>
                                                                                        </div>-->
                                            <br>
                                            <hr>

                                            <br>

                                            <!-- <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('PUSH_TOPICS'); ?></label>
                                            </div>


                                            <div class="form-group">
                                                <label for="" class="control-label" style="margin-left: 15px;   "><p style="color:#8356a9"><?php echo $this->lang->line('DRIVER'); ?></p>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('All_Drivers'); ?></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="inputAllDriverPushTopic" data="allDrivers" name="inputAllDriverPushTopic" placeholder="" readonly value="<?php echo $allDrivers ?>">

                                                </div>

                                            </div> 
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('All_Cities'); ?></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="inputAllCitiesPushTopic" data="allCitiesDrivers" name="inputAllCitiesPushTopic" placeholder="" readonly value="<?php echo $allCitiesDrivers ?>">

                                                </div>

                                            </div>                                          

                                            <div class="form-group">
                                                <label for="" class="control-label" style="margin-left: 15px;"><p style="color:#8356a9"><?php echo $this->lang->line('CUSTOMER'); ?></p>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('All_Customers'); ?></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="inputAllCustomersPushTopic" data="allCustomers" name="inputAllCustomersPushTopic" placeholder="" readonly value="<?php echo $allCustomers ?>">

                                                </div>

                                            </div> 
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('All_Cities'); ?></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="inputAllCitiesCustomerPushTopic" data="allCitiesCustomers" name="inputAllCitiesCustomerPushTopic" placeholder="" readonly value="<?php echo $allCitiesCustomers ?>">

                                                </div>

                                            </div> 
                                          
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"></label>
                                                <div class="col-sm-6">
                                                    <button type="button" class="btn btn-info pushTopicButton"><?php echo $this->lang->line('Change_Topics'); ?></button>
                                                </div>

                                            </div>  -->




                                            <!-- <br>
                                            <hr>
                                            <br> -->

                                            <div id="mqtt">
                                                <div class="form-group">
                                                    <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('MQTT_Settings'); ?></label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label" style="margin-left: 15px;"><p style="color:#8356a9"><?php echo $this->lang->line('DRIVER'); ?></p>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Timed-Out_Time_Interval'); ?></label>
                                                    <div class="col-sm-6">
                                                        <span class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                        <input type="text" class="form-control" id="timedOutTimeInterval" name="timedOutTimeInterval" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $timedOutTimeInterval; ?>">

                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Publish_Time_Interval'); ?></label>
                                                    <div class="col-sm-6">
                                                        <span class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                        <input type="text" class="form-control" id="homePageInterval" name="homePageInterval" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $homePageInterval; ?>">

                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label for="" class="control-label col-md-4"><?php echo $this->lang->line('On_Trip_Driver_Location_Publish_Interval'); ?></label>
                                                    <div class="col-sm-6">
                                                        <span class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                        <input type="text" class="form-control" id="tripStartedInterval" name="tripStartedInterval" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $tripStartedInterval; ?>">
                                                    </div>
                                                </div> 

                                            </div>
                                            <br>
                                            <hr>
                                            <br>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('PRESENCE_SETTINGS'); ?></label>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Presence_Time'); ?></label>
                                                <div class="col-sm-6">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                    <input type="text" id="presenceTime" name="presenceTime" class="form-control number" onkeypress="return isNumberKey(event)" placeholder="Enter Minutes" value="<?php echo $presenceTime; ?>">

                                                </div>
                                                <div class="col-sm-2 errors" id="presenceTImeErr"></div>
                                            </div>

                                            <br>
                                            <hr>
                                            <br>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('PATH_PLOT_SETTINGS'); ?></label>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Lat/Long_Displacement'); ?></label>
                                                <div class="col-sm-6">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Meter'); ?></b></span>
                                                    <input type="text" id="routeDistance" name="routeDistance" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Enter Minutes" value="<?php echo $DistanceForLogingLatLongs; ?>">

                                                </div>
                                                <div class="col-sm-2 errors" id="presenceTImeErr"></div>
                                            </div>
                                            <hr>
                                            <br>
                                            <!--
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('PRICING_MODEL'); ?></label>
                                                                                        </div>
                                            
                                            
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Mileage'); ?></label>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="switch">
                                                                                                    <input id="cmn-toggle-1" name="mileagePricing" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                                                                    <label for="cmn-toggle-1"></label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div> 
                                            
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Zonal'); ?></label>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="switch">
                                                                                                    <input id="cmn-toggle-2" name="zonalPricing" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                                                                    <label for="cmn-toggle-2"></label>
                                                                                                </div>
                                                                                            </div>
                                            
                                                                                        </div> -->
                                            <!--                                            <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Short Haul</label>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="col-sm-6">
                                                                                                    <input type="radio" class="radio-success" name="shortHaul" id="shortHaulMileage" value="1">
                                                                                                    <label for="shortHaulMileage">Mileage</label>
                                                                                                </div>
                                                                                                <div class="col-sm-6">
                                                                                                    <input type="radio" class="radio-success" name="shortHaul" id="shortHaulZonal" value="0" >
                                                                                                    <label for="shortHaulZonal">Zonal</label>
                                                                                                </div>
                                                                                            </div>
                                            
                                                                                        </div> -->

                                            <!--                                            <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Payment Gateway for Bank Details (Stripe)</label>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="switch">
                                                                                                    <input id="paymentMode" name="paymentMode" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                                                                    <label for="paymentMode"></label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                            
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Payment Gateway (Stripe)</label>
                                                                                            <div class="col-sm-6">
                                                                                                <div class="switch">
                                                                                                    <input id="paymentGateway" name="paymentGateway" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                                                                    <label for="paymentGateway"></label>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                            
                                                                                        <div class="form-group stripeTestEnable">
                                                                                            <label for="" class="control-label col-md-4"> <span style="color:#8356a9">Stripe Sandbox (Test Mode)</span></label>
                                                                                            <div class="col-sm-6">
                                                                                                <span><b>Secret Key</span>
                                                                                                <input type="text" class="form-control" id="stripeTestSecreteKey" name="stripeTestSecreteKey" placeholder=""  value="<?php echo $stripeTestSecreteKeys; ?>">
                                                                                            </div>
                                                                                        </div>
                                            
                                                                                        <div class="form-group stripeTestEnable">
                                                                                            <label for="" class="control-label col-md-4"></label>
                                                                                            <div class="col-sm-6">
                                                                                                <span><b>Publishable Key</b></span>
                                                                                                <input type="text" class="form-control" id="stripeTestPublishableKey" name="stripeTestPublishableKey" placeholder=""   value="<?php echo $stripeTestPublishableKeys; ?>">
                                                                                            </div>
                                                                                        </div>
                                            
                                                                                        <div class="form-group stripeLiveEnable">
                                                                                            <label for="" class="control-label col-md-4"> <span style="color:green">Stripe Live</span></label>
                                            
                                                                                            <div class="col-sm-6">
                                                                                                <span><b>Secret Key</b></span>
                                                                                                <input type="text" class="form-control" id="stripeLiveSecreteKey" name="stripeLiveSecreteKey" placeholder=""   value="<?php echo $stripeLiveSecreteKeys; ?>">
                                                                                            </div>
                                                                                        </div>
                                            
                                                                                        <div class="form-group stripeLiveEnable">
                                                                                            <label for="" class="control-label col-md-4"></label>
                                                                                            <div class="col-sm-6">
                                                                                                <span><b>Publishable Key</b></span>
                                                                                                <input type="text" class="form-control" id="stripeLivePublishableKey" name="stripeLivePublishableKey" placeholder=""   value="<?php echo $stripeLivePublishableKeys; ?>">
                                                                                            </div>
                                                                                        </div>-->

                                            <br>
                                            <hr>
                                            <br>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('DISPATCH_SETTINGS'); ?></label>

                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Time_for_Driver_to_Accept_Booking'); ?></label>
                                                <div class="col-sm-6">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                    <input type="text" id="timeForacceptBooking" name="timeForacceptBooking" placeholder="Enter time in seconds" class="form-control number" onkeypress="return isNumberKey(event)" value="<?php echo $driverAcceptTime; ?>">

                                                </div>
                                                <div class="col-sm-2 errors" id="timeForacceptBookingErr"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Time_for_Driver_to_Acknowledge_a_New_Booking'); ?></label>
                                                <div class="col-sm-6">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                    <input type="text" id="timeForDriverAck" name="timeForDriverAck" placeholder="Enter time in seconds" class="form-control number" onkeypress="return isNumberKey(event)" value="<?php echo $timeForDriverAck; ?>">

                                                </div>
                                                <div class="col-sm-2 errors" id="timeForacceptBookingErr"></div>
                                            </div>




                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Dispatch_Radius'); ?></label>
                                                <div class="col-sm-6">
                                                    <span  class="abs_text"><b><?php echo ($mileage_metric == 0) ? 'Km' : 'Mile' ?></b></span>
                                                    <input type="text" id="DispatchRadius" name="DispatchRadius" class="form-control number" onkeypress="return isNumberKey(event)" placeholder="" value="<?php echo $DispatchRadius; ?>">

                                                </div>
                                                <div class="col-sm-2 errors" id="longHaulDispatchRadiusErr"></div>
                                            </div>


                                            <div class="form-group">
                                                <label  class="control-label col-md-4"><?php echo $this->lang->line('Dispatch_Mode'); ?></label>
                                                <div class="col-sm-6">
                                                    <div class="col-sm-6">

                                                        <input type="radio" class="radio-success dipatchMode" name="centralDipatchMode" id="dipatchModeAuto" value="1">
                                                        <label for="dipatchModeAuto"><?php echo $this->lang->line('Auto'); ?></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="radio" class="radio-success dipatchMode" name="centralDipatchMode" id="dipatchModeManual" value="0">
                                                        <label for="dipatchModeManual"><?php echo $this->lang->line('Manual'); ?></label>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="dipatchModeValue" id="dipatchModeValue" value="1">
                                                <div class="col-sm-2 errors" id="appCommissionErr"></div>
                                            </div> 
                                            <!--                                            <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4">Dispatch Time</label>
                                                                                            <div class="col-sm-6">
                                                                                                <span  class="abs_text"><b>Minutes</b></span>
                                                                                                <input type="text" id="dispatchTime" name="dispatchTime" class="form-control number" onkeypress="return isNumberKey(event)" placeholder="Enter Minutes" value="<?php echo $dispatchTime; ?>">
                                            
                                                                                            </div>
                                                                                            <div class="col-sm-2 errors" id="dispatchTimeErr"></div>
                                                                                        </div>-->


                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><p style="color:#8356a9"><?php echo $this->lang->line('BOOK_NOW'); ?></p>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Dispatch_ruration'); ?></label>
                                                <div class="col-sm-6">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                    <input type="text" id="dispatchExpireTime" name="dispatchExpireTime" class="form-control number" onkeypress="return isNumberKey(event)" placeholder="Enter Seconds" value="<?php echo $dispatchExpireTime; ?>">

                                                </div>
                                                <div class="col-sm-2 errors" id="dispatchDurationErr"></div>
                                            </div>

                                            <!-- <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Booking_Expiry_Time'); ?></label>
                                                <div class="col-sm-6">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                    <input type="text" id="nowBookingExpiryTime" name="nowBookingExpiryTime" class="form-control number" onkeypress="return isNumberKey(event)" placeholder="Enter Seconds" value="<?php echo $nowBookingExpriryTime; ?>">

                                                </div>
                                                <div class="col-sm-2 errors" id="nowBookingExpiryTimeErr"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('centralDispatchExpriryTime'); ?></label>
                                                <div class="col-sm-6">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                    <input type="text" id="centralDispatchExpriryTime" name="centralDispatchExpriryTime" class="form-control number" onkeypress="return isNumberKey(event)" placeholder="Enter Seconds" value="<?php echo $centralDispatchExpriryTime; ?>">

                                                </div>
                                                <div class="col-sm-2 errors" id="centralDispatchExpriryTimeErr"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('staffAcceptTime'); ?></label>
                                                <div class="col-sm-6">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                    <input type="text" class="form-control" id="staffAcceptTime " name="staffAcceptTime" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $staffAcceptTime; ?>">
                                                </div>
                                                <div class="col-sm-3 error-box" id="staffAcceptTimeErr"></div>
                                            </div> -->

                                          <!--                                            <div class="form-group">
                                                                                        <label for="" class="control-label col-md-4">Central Dispatch Time</label>
                                                                                        <div class="col-sm-6">
                                                                                            <span  class="abs_text"><b>Minutes</b></span>
                                                                                            <input type="text" id="centralDispatchTime" name="centralDispatchTime" class="form-control number" onkeypress="return isNumberKey(event)" placeholder="Enter Minutes" value="<?php echo $centralDispatchTime; ?>">
                                        
                                                                                        </div>
                                                                                        <div class="col-sm-2 errors" id="centralDispatchTimeErr"></div>
                                                                                    </div>-->

                                        <div class="form-group">
                                            <label for="" class="control-label col-md-4"><?php echo 'Store Accept Expiry Time'; ?></label>
                                            <div class="col-sm-6">
                                                <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                <input type="text" id="nowBookingStoreExpireTime" name="nowBookingStoreExpireTime" class="form-control number" onkeypress="return isNumberKey(event)" placeholder="Enter Seconds" value="<?php echo $nowBookingStoreExpireTime; ?>">

                                            </div>
                                            <div class="col-sm-2 errors" id="nowBookingStoreExpireTimeErr"></div>
                                        </div>

                                            <div class="form-group autoToCentralDispatch">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Auto_to_central_dispatch_ratio'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b>%</b></span>
                                                    <input type="text" class="form-control" id="autoBookNowDispatchRation" name="autoBookNowDispatchRation"  onkeypress="return isNumberKey(event)" value="<?php echo $autoBookNowDispatchRation; ?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b>%</b></span>
                                                    <input type="text" class="form-control" id="centralBookNowDispatchRation" name="centralBookNowDispatchRation"  onkeypress="return isNumberKey(event)" value="<?php echo $centralBookNowDispatchRation; ?>" readonly="">
                                                </div>
                                                <div class="col-sm-2 errors" id="autoBookNowDispatchRationErr"></div>
                                            </div>


                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><p style="color:#8356a9"><?php echo $this->lang->line('BOOK_LATER'); ?></p>
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Scheduled_Bookings'); ?></label>
                                                <div class="col-sm-6">
                                                    <div class="switch">
                                                        <input id="scheduledBookingsOnOFF" name="scheduledBookingsOnOFF" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                        <label for="scheduledBookingsOnOFF"></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2"></div>
                                            </div>

                                            <div class="form-group ScheduleBooking" >
                                                <label for="" class="control-label col-md-4"><?php echo 'Store Accept Expiry Time For Later'; ?></label>
                                                <div class="col-sm-6">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Seconds'); ?></b></span>
                                                    <input type="text" id="laterBookingStoreExpireTime" name="laterBookingStoreExpireTime" class="form-control number" onkeypress="return isNumberKey(event)" placeholder="Enter Seconds" value="<?php echo $laterBookingStoreExpireTime; ?>">
                                                </div>
                                                <div class="col-sm-2 errors" id="laterBookingStoreExpireTimeErr"></div>
                                            </div>

                                            <div class="form-group ScheduleBooking">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Customer_App_Buffer_Time_for_Book_Later'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Hours'); ?></b></span>
                                                    <input type="text" class="form-control" id="laterBookingBufferHour" name="laterBookingBufferHour" placeholder="Enter Hour"  onkeypress="return isNumberKey(event)" value="<?php echo $laterBookingBufferHour; ?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                                    <input type="text" class="form-control" id="laterBookingBufferMinute" name="laterBookingBufferMinute" placeholder="Enter Minutes"  onkeypress="return isNumberKey(event)" value="<?php echo $laterBookingBufferMinute; ?>">
                                                </div> <label><?php echo $this->lang->line('After_Current_Time'); ?></label>
                                                <div class="col-sm-2 errors" id="dispatchStartTimeErr"></div>
                                            </div>

                                            <div class="form-group ScheduleBooking">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Dispatch_will_start'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Hours'); ?></b></span>
                                                    <input type="text" class="form-control" id="laterBookingDispatchBeforeHours" name="laterBookingDispatchBeforeHours" placeholder="Enter Hour"  onkeypress="return isNumberKey(event)" value="<?php echo $laterBookingDispatchBeforeHours; ?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                                    <input type="text" class="form-control" id="laterBookingDispatchBeforeMinutes" name="laterBookingDispatchBeforeMinutes" placeholder="Enter Minutes"  onkeypress="return isNumberKey(event)" value="<?php echo $laterBookingDispatchBeforeMinutes; ?>">
                                                </div> <label><?php echo $this->lang->line('Before_Pickup_Time'); ?></label>
                                                <div class="col-sm-2 errors" id="dispatchMinStartTimeQueueErr"></div>
                                            </div>

                                            <!-- <div class="form-group ScheduleBooking autoToCentralDispatch"> -->
                                            <div class="form-group ScheduleBooking ">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Auto_to_central_dispatch_ratio'); ?></label>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b>%</b></span>
                                                    <input type="text" class="form-control" id="autoDispatchRation" name="autoDispatchRation"  onkeypress="return isNumberKey(event)" value="<?php echo $autoDispatchRation; ?>">
                                                </div>
                                                <div class="col-sm-3">
                                                    <span  class="abs_text"><b>%</b></span>
                                                    <input type="text" class="form-control" id="centralDispatchRation" name="centralDispatchRation"  onkeypress="return isNumberKey(event)" value="<?php echo $centralDispatchRation; ?>" readonly="">
                                                </div>
                                                <div class="col-sm-2 errors" id="DispatchRationErr"></div>
                                            </div>
                                       <!--                <div class="form-group ScheduleBooking">
                                                                            <label for="" class="control-label col-md-4">Book Later Expires from Dispatch queue</label>
                                                                            <div class="col-sm-3">
                                                                                <span  class="abs_text"><b>Minutes</b></span>
                                                                                <input type="text" class="form-control" id="bookLaterExpQueueMin" name="bookLaterExpQueueMin" placeholder="Enter Minutes"  onkeypress="return isNumberKey(event)" value="<?php echo $bookLaterExpQueueMin; ?>">
                                                                            </div>
                                                                            <div class="col-sm-3"> <label>
                                                                                    Before Pickup Time</label>
                                                                            </div>
                                                                            <div class="col-sm-2 errors" id="dispatchStartTimeErr"></div>
                                                                        </div>-->


                                            <br>
                                            <hr>
                                            <br>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('REFERRAL_CODE_SETTINGS'); ?></label>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Referral_Code_Sent_By_Email'); ?></label>
                                                <div class="col-sm-6">
                                                    <div class="col-sm-6">
                                                        <input type="radio" class="radio-success" name="referralCodeSendByEmail" id="referralCodeSentYes" value="1">
                                                        <label for="referralCodeSentYes"><?php echo $this->lang->line('Yes'); ?></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="radio" class="radio-success" name="referralCodeSendByEmail" id="referralCodeSentNo" value="0" checked>
                                                        <label for="referralCodeSentNo"><?php echo $this->lang->line('No'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 errors" id=""></div>
                                            </div> 

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><?php echo $this->lang->line('Referral_Code_Sent_By_Text_Message'); ?></label>
                                                <div class="col-sm-6">
                                                    <div class="col-sm-6">
                                                        <input type="radio" class="radio-success" name="referralCodeSendByTestMsg" id="referralCodeSendByTestMsgYes" value="1">
                                                        <label for="referralCodeSendByTestMsgYes"><?php echo $this->lang->line('Yes'); ?></label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="radio" class="radio-success" name="referralCodeSendByTestMsg" id="referralCodeSendByTestMsgNo" value="0" checked>
                                                        <label for="referralCodeSendByTestMsgNo"><?php echo $this->lang->line('No'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 errors" id=""></div>
                                            </div> 

                                            <br>
                                            <!--                                            <hr>
                                                                                        <br>
                                            
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4" style="color: #0090d9;">Terms & Conditions</label>
                                                                                        </div>
                                            
                                                                                        <div class="form-group">
                                                                                            <div class="col-sm-12">
                                                                                                <textarea name="tc"></textarea>
                                                                                                <script>
                                                                                                    CKEDITOR.replace('tc');
                                                                                                </script>
                                                                                            </div>
                                                                                        </div>
                                                                                        <br>
                                                                                        <div class="form-group">
                                                                                            <label for="" class="control-label col-md-4" style="color: #0090d9;">Privacy Policy</label>
                                                                                        </div>
                                            
                                                                                        <div class="form-group">
                                                                                            <div class="col-sm-12">
                                                                                                <textarea name="pp"></textarea>
                                                                                                <script>
                                                                                                    CKEDITOR.replace('pp');
                                                                                                </script>
                                                                                            </div>
                                                                                        </div>-->

                                            <!--                                            <br>
                                                                                        <hr>
                                            -->

                                            <!-- <div class="form-group">
                                                <label for="" class="control-label col-md-4" style="color: #0090d9;">GOOGLE KEYS</label>
                                            </div>

                                            <br>

                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><p style="color:#8356a9">FOR MAPS</p>
                                                </label>
                                            </div>
                                            <div class="form-group">

                                                <div class="col-sm-6">
                                                    <table id="table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered no-footer" role="grid" aria-describedby="big_table_info" style="">
                                                        <thead>
                                                            <tr style= "font-size:10px"role="row">
                                                                <th>DRIVER</th>
                                                                <th>REORDER</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
<?php
for ($i = 0; $i <= 9; $i++) {
    ?>
                                                                <tr>
                                                                    <td><input type="text"  class="autonumeric form-control prices" name="driverGoogleMapKey[]" id="driverGoogleMapKey<?php echo $i; ?>" placeholder="" value="<?php echo $DriverGoogleMapKeys[$i] ?>"></td>

                                                                    <td><img style="width:30px;" src="<?php echo base_url() ?>theme/assets/img/uparrow.png" data-id="up<?php echo $i; ?>" class="c_moveUp">
                                                                        <img style="width:30px;" src="<?php echo base_url() ?>theme/assets/img/downarrow.png"  data-id="down<?php echo $i; ?>"  class="c_moveDown"></td>
                                                                </tr>
    <?php
}
?>



                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-sm-6">
                                                    <table id="table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered no-footer" role="grid" aria-describedby="big_table_info" style="">
                                                        <thead>
                                                            <tr style= "font-size:10px"role="row">
                                                                <th>CUSTOMER</th>
                                                                <th>REORDER</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
<?php
for ($i = 0; $i <= 9; $i++) {
    ?>
                                                                <tr>

                                                                    <td><input type="text"  class="autonumeric form-control prices" name="customerGoogleMapKey[]" id="customerGoogleMapKey<?php echo $i; ?>" placeholder="" value="<?php echo $custGoogleMapKeys[$i] ?>"></td>
                                                                    <td><img style="width:30px;" src="<?php echo base_url() ?>theme/assets/img/uparrow.png" data-id="up<?php echo $i; ?>" class="c_moveUp">
                                                                        <img style="width:30px;" src="<?php echo base_url() ?>theme/assets/img/downarrow.png"  data-id="down<?php echo $i; ?>"  class="c_moveDown"></td>
                                                                </tr>
    <?php
}
?>



                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label for="" class="control-label col-md-4"><p style="color:#8356a9">FOR PLACES SEARCH</p>
                                                </label>
                                            </div>

                                            <div class="form-group">


                                                <div class="col-sm-6">
                                                    <table id="table" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered no-footer" role="grid" aria-describedby="big_table_info" style="">
                                                        <thead>
                                                            <tr style= "font-size:10px"role="row">
                                                                <th>CUSTOMER</th>
                                                                <th>REORDER</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
<?php
for ($i = 0; $i <= 9; $i++) {
    ?>
                                                                <tr>

                                                                    <td><input type="text"  class="autonumeric form-control prices" name="customerGooglePlaceKey[]" id="customerGooglePlaceKey<?php echo $i; ?>" placeholder="" value="<?php echo $custGooglePlaceKeys[$i] ?>"></td>
                                                                    <td><img style="width:30px;" src="<?php echo base_url() ?>theme/assets/img/uparrow.png" data-id="up<?php echo $i; ?>" class="c_moveUp">
                                                                        <img style="width:30px;" src="<?php echo base_url() ?>theme/assets/img/downarrow.png"  data-id="down<?php echo $i; ?>"  class="c_moveDown"></td>
                                                                </tr>
    <?php
}
?>



                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div> -->

                                        </form>

                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-4 cls111">
                                            
                                                <button type="button" class="btn btn-success cls110" id="save" style="position:fixed;"><?php echo $this->lang->line('save'); ?></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="walletSettingsPopUp" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <strong style="color:#0090d9;"><?php echo $this->lang->line('WALLET_SETTINGS'); ?></strong>
                                        </div>
                                        <div class="modal-body">
                                            <form id="" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                                                <div class="form-group">
                                                    <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Soft_Limit'); ?></label>
                                                    <div class="col-sm-6">
                                                        <span  class="abs_text"><b><?php echo $appCofig['currencySym']; ?></b></span>
                                                        <input type="text" class="form-control" id="softLimitForShipper" name="softLimitForShipper" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $softLimitForShipper; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Hard_Limit'); ?></label>
                                                    <div class="col-sm-6">
                                                        <span  class="abs_text"><b><?php echo $appCofig['currencySym']; ?></b></span>
                                                        <input type="text" class="form-control" id="hardLimitForShipper" name="hardLimitForShipper" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $hardLimitForShipper; ?>">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.ckeditor.com/<version.number>/<distribution>/ckeditor.js"></script>
    </div>

</div>
