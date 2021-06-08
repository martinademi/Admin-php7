<?php
$option = '<option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option>
<option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
<option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="23.59">23.59</option>';
?>
<style>
    #selectedcity,#companyid{
        display: none;
    }
    .alert-Info {
        color: #31708f !important;
        background-color: #d9edf7 !important;
        border-color: #bce8f1 !important;
    }


</style>


<script src="<?php echo base_url() ?>supportFiles/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>supportFiles/sweetalert.css">


<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>supportFiles/waitMe.css">
<script src="<?php echo base_url() ?>supportFiles/waitMe.js"></script>



<script>

// none, bounce, rotateplane, stretch, orbit, 
// roundBounce, win8, win8_linear or ios
//        var current_effect = 'bounce'; // 


    function run_waitMe(effect) {
        $('.content').waitMe({
//none, rotateplane, stretch, orbit, roundBounce, win8, 
//win8_linear, ios, facebook, rotation, timer, pulse, 
//progressBar, bouncePulse or img
            effect: 'bounce',
//place text under the effect (string).
            text: '',
//background for container (string).
            bg: 'rgba(255,255,255,0.7)',
//color for background animation and text (string).
            color: '#000',
//change width for elem animation (string).
            sizeW: '',
//change height for elem animation (string).
            sizeH: '',
// url to image
            source: '',
// callback
            onClose: function () {}

        });
    }

</script>

<script>

     function getDateINtimpstamp(dateString) {
        var dateTimeParts = dateString.split(' '),
                dateParts = dateTimeParts[0].split('-'),
                date;
        date = (new Date(dateParts[0] + "/" + dateParts[1] + "/" + dateParts[2] + " " + dateTimeParts[1] + ":" + dateTimeParts[3] + ":00").getTime() / 1000);

        return date;
    }
    $(document).ready(function () {

        // on city change

        var options = {
            twentyFour: true, //Display 24 hour format, defaults to false
            upArrow: 'wickedpicker__controls__control-up',
            downArrow: 'wickedpicker__controls__control-down',
            close: 'wickedpicker__close',
            hoverState: 'hover-state',
            title: 'Time',
            showSeconds: false,
            secondsInterval: 1,
            minutesInterval: 1,
            beforeShow: null,
            show: null,
            clearable: false
        };


        $('.timepicker').wickedpicker(options);

        $('#selectedcityNew').change(function () {
            $('#zonecheck').attr("checked", false);
            $('.showDiv').css({'display': 'none'});

        });

        $('#collapseOneancher').click();

//        CKEDITOR.replace('editor1');

        $('#selectedcityNew').html($('#selectedcity').html());

        $("input[type=radio]").click(function (event) {
            event.stopPropagation();
        });
        $("input[type=checkbox]").click(function (event) {
            event.stopPropagation();
        });



        $('.submitDataOnserver').click(function () {


            $(this).prop("disabled", true);
            var cityId = $('#selectedcityNew').val();
            var promocode = $('#Promocode').val();
            var amount = $('#amount').val();
            var startDate = $('#startDate').val();
            var EndDate = $('#EndDate').val();
            var starttime = $('#starttime').val();
            var endtime = $('#endtime').val();

            var stTimeParts = startDate.split('/');
            var endTimeParts = EndDate.split('/');
            var startTimestamp = getDateINtimpstamp(stTimeParts[2] + '-' + stTimeParts[0] + '-' + stTimeParts[1] + ' ' + starttime.trim());//'2013-09-17 10:08'
            var endTimestamp = getDateINtimpstamp(endTimeParts[2] + '-' + endTimeParts[0] + '-' + endTimeParts[1] + ' ' + endtime.trim());

            var zonecheck = $("#zonecheck:checked").val();
            if (promocode == '') {
                alertMessage('Enter PromoCode');
                $(this).prop("disabled", false);
            } else if (amount == '') {
                alertMessage('Enter amount');
                $(this).prop("disabled", false);
            } else if (cityId == 0) {
                alertMessage('Please Select City');
                $(this).prop("disabled", false);
            } else if ((typeof zonecheck != "undefined")&&$('#updateZone').val() == '0') {
                    alertMessage('Select Zone First');
                
            } else if (startDate == '' || starttime == '') {
                alertMessage('Enter start date or time');
                  $(this).prop("disabled", false);
            } else if (EndDate == '' || endtime == '') {
                alertMessage('Enter End date or time');
                $(this).prop("disabled", false);
            } else if (startTimestamp > endTimestamp) {
                alertMessage('Start Date Is greater than end date.');
                $(this).prop("disabled", false);
            } else {

                run_waitMe('bounce');
                var DataTOSend = {
                    promocode: promocode,
                    Amount: amount,
                    PromotionType: 2,
                    city: cityId,
                    ZoneSelected: ((typeof zonecheck != "undefined") ? 1 : 0),
                    ZoneId: $("#updateZone").val(),
                    zoneappliedOn: $("input[name=zonecheck]:checked").val(),
                    creditwalletWithaddition: $("#creditwalletWithaddition").val(),
                    sartDateNtime: startTimestamp,
                    endTimestamp: endTimestamp,
                };




                // update in database

                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/coupons/AddRefferal",
                    type: "POST",
                    data: {
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',
                        'city_id': cityId,
                        'coupon_type': "PROMOTION",
                        'title': $('#title').val(),
                        'TnC': $(".note-editable").html(),
                        'coupon_code' : promocode,
                        PromoData: DataTOSend,
                    },
                    dataType: "JSON",
                    success: function (result) {
                        if (result.msg == '0') {
                            $('.content').waitMe('hide');
                            window.location = "<?php echo base_url() ?>index.php?/coupons/promotion/2";

                        } else {
                            $('.submitDataOnserver').prop("disabled", false);
                            $('.content').waitMe('hide');
                            alertMessage('Error Occurd while processing.');

                        }
                        $('.submitDataOnserver').prop("disabled", false);
                        $('.content').waitMe('hide');
                    },
                    error: function () {
                        alertMessage('Problem occurred please try agin.');
                        $('.submitDataOnserver').prop("disabled", false);
                        $('.content').waitMe('hide');
                    },
                    timeout: 30000
                });



                //end of trigger handaling 



            }


        });




    });

    function alertMessage(message) {
        swal({
            title: message,
            timer: 2000,
            showConfirmButton: false
        });
    }
    
    function isNumberKey(evt, id)
    {

        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
            return false;
        }


        if (id == "amountsecondBlock") {
            if (($('.discountTypeLableReferrered').html() == "PERCENTAGE") && ($('#' + id).val()) > 10)
                return false;
        }
        if (id == "amountFirstBlock") {

            if (($('.discountTypeLableReferrer').html() == "PERCENTAGE") && ($('#' + id).val()) > 10)
                return false;
        }

        return true;
    }

    function calltrigger(element) {
        var dis = $('#' + element);

        $(dis).attr("checked", !$(dis).attr("checked"));
        if (element == "xridesselected") {
            $('.chekcRideType').html("Number of rides");
            $("#xrideUnit").css({'display': 'block'});
        } else if (element == "xamountselected") {
            $('.chekcRideType').html("Amount of rides");
            $("#xrideUnit").css({'display': 'block'});
        } else if (element == "General") {
            $('.chekcRideType').html("N/A");
            $("#xrideUnit").css({'display': 'none'});
        } else if (element == "creditintowallet") {
            $('.creditTowalletIFyes').html("Expiry Date");
            $("#creditTowalletIFyes").css({'display': 'block'});
        } else if (element == "Discountontrip") {
            $('.creditTowalletIFyes').html("N/A");

            $("#creditTowalletIFyes").css({'display': 'none'});
        }
        if (element == 'zonecheck' && $('#zonecheck').attr("checked")) {
            run_waitMe('bounce');
            var cityId = $('#selectedcityNew').find(":selected").text();
            if (cityId != "All") {
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/coupons/getCityZone",
                    type: "POST",
                    data: {
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',
                        'cityname': cityId,
                    },
                    dataType: "JSON",
                    success: function (result) {
                        if (Object.keys(result).length > 0) {
                            var html = "<option value='0'>Select Zone</option>";
                            $.each(result, function (index, item) {
                                html += "<option value='" + item['_id'].$id + "'>" + item.title + "</option>"
                            });


                            $('.showDiv').css({'display': 'block'});
                            $('.showDiv').addClass('in');
//                            $('#updateZone').css({'display': 'block'});
                            $('#updateZone').html(html);
                            $('.content').waitMe('hide');
                        } else {
                            $('.content').waitMe('hide');
                            alertMessage('Please add Zone First');


                        }
                    }
                });
            } else
            {
                alertMessage('Please Select City');
                $(dis).attr("checked", false);
                $('.content').waitMe('hide');
            }
        }
        if (!$('#zonecheck').attr("checked")) {
            $('.showDiv').css({'display': 'none'});
        }

    }
    function notificationbar(message) {
//    var position = $('.tab-pane.active .position.active').attr('data-placement'); 
        $('body').pgNotification({
            style: 'bar',
            message: message,
            position: "top",
            timeout: 10000,
            type: 'Info'
        }).show();
    }

</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ul class="breadcrumb" style="">
                        <li>
                            <?php if ($actionFor == 1) { ?>
                                <a href="<?php echo base_url() . 'index.php?/coupons/promotion/' . $actionFor ?>">TRIP PROMO</a></li>
                        <?php } else { ?>
                            <a href="<?php echo base_url() . 'index.php?/coupons/promotion/' . $actionFor ?>">WALLET PROMO</a></li>
                        <?php } ?>
                        <li><a href="#" class="active">NEW</a>
                        </li>
                        <p class="pull-right cls110">
                            <button class="btn btn-primary btn-cons m-b-10 submitDataOnserver" type="button" ><i class="pg-form" style="color: #ffffff;"></i> <span class="bold" style="color: #ffffff;">Submit</span>
                            </button>
                        </p>
                    </ul>
                    <!-- END BREADCRUMB -->
                </div>



                <div class="panel panel-group panel-transparent" data-toggle="collapse" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseOne" id="collapseOneancher">
                                    GENERAL SETTING
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse " id="collapseOne" style="height: 0px;">
                            <div class="panel-body">
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">Promo Code</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" id="Promocode"  placeholder="eg. XYZ"    required="" aria-required="true">                                                                                            
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">Amount</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="addmemclass1 form-control" id="amount"  placeholder="amount"   required="" aria-required="true" onkeypress="return isNumberKey(event, 'amountFirstBlock')">                                                                                            
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">CITY</label>
                                            <div class="col-sm-7">
                                                <select id="selectedcityNew" name="company_select" class="form-control">

                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <span style="color: red; font-size: 20px">*</span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">ZONE </label>
                                            <div class="col-sm-7">
                                                <div class="checkbox check-primary">
                                                    <!--<div style="width: 40%;float: left;">-->
                                                    <input type="checkbox" value="1" id="zonecheck">
                                                    <label onclick="calltrigger('zonecheck')">Select</label>

                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div>



                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 fade  showDiv" style="display: none">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">Select Zone</label>
                                            <div class="col-sm-7">
                                                <select id="updateZone" name="company_select" class="form-control">

                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">ZONE </label>
                                            <div class="col-sm-7">
                                                <div class="radio radio-success">
                                                    <input type="radio"  name="zonecheck" checked="checked" value="0" id="appliedonpickup">
                                                    <label onclick="calltrigger('appliedonpickup')"> Applied On pickup</label>
                                                    <input type="radio"  name="zonecheck" value="1" id="applidondrop">
                                                    <label onclick="calltrigger('applidondrop')">Applied On Drop </label>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>







                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Start Date</label>
                                            <div class="col-sm-9">
                                                <div id="datepicker-component" class="input-group date col-sm-6 pull-left" >
                                                    <input type="text" class="form-control" id="startDate"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" name="timepicker" class="timepicker" id="starttime"/>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">End Date</label>
                                            <div class="col-sm-9">

                                                <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                    <input type="text" class="form-control" id="EndDate"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <div class="col-sm-4">

                                                    <input type="text" name="timepicker" class="timepicker" id="endtime"/>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>





                                <div class="col-md-12 col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label"> Additional amount </label>
                                            <div class="col-sm-7">
                                                <input type="text" class="addmemclass1 form-control" id="creditwalletWithaddition"    placeholder="additional  amount"   required="" aria-required="true" onkeypress="return isNumberKey(event, 'amountFirstBlock')">                                                                                            
                                            </div>

                                        </div>
                                    </div>

                                </div>







                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">
                                    TERM & CONDITIONS 
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseTwo" style="height: 0px;">
                            <div class="panel-body">
                                <div class="summernote-wrapper">
                                    <div id="summernote"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>


    </div>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>supportFiles/wickedpicker.css">
<script src="<?php echo base_url() ?>supportFiles/wickedpicker.js"></script>
