<?php
//print_r($canpaningData);
//exit();
?>
<style>
    #selectedcity,#companyid{
        display: none;
    }
</style>
<script src="<?php echo base_url() ?>supportFiles/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>supportFiles/sweetalert.css">

<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>supportFiles/waitMe.css">
<script src="<?php echo base_url() ?>supportFiles/waitMe.js"></script>
<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script>
    $(document).ready(function () {
    });
</script>
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
    $(document).ready(function () {
//        $('#collapseOneancher').click();

//        CKEDITOR.replace('editor1');

        $('#selectedcityNew').html($('#selectedcity').html());

        $("input[type=radio]").click(function (event) {
            event.stopPropagation();
        });
        $("input[type=checkbox]").click(function (event) {
            event.stopPropagation();
        });


        var campaningData = <?= json_encode($canpaningData[0]) ?>;

        $('#title').val(campaningData.title);

//        $('#selectedcityNew option[value=' + campaningData.cityId.$oid + ']').prop("selected", true);
        $('#selectedcityNew').append($('<option>', {
    value:   campaningData.cityId.$oid  ,
    text:  campaningData.cityName 
}));
 var referee = campaningData.referee;
 var referrer = campaningData.referrer;

        var newSignUp = 0;
//        if (typeof campaningData.rewardForNewsignup != 'undefined') {
            if (campaningData.rewardType == 1) {

                newSignUp = 1;
           
                if (referrer) {
       
                    $('#referre').prop('checked', true);

                    $("input[name=firstBlockDiscountType][value=" + referrer.discountType + "]").prop('checked', true);

                    $('#amountFirstBlock').val(referrer.discount);
                    $('#maxDiscountFirstBlock').val(referrer.maxDiscount);
                    $('#dateFirstBlock').val(referrer.daysValid);
                    if(referrer.discountType == '1'){
                         $('.discountTypeLableReferrer').html("AMOUNT");
                          $('.maxDiscountFirstBlockClass').hide();
                           $('#maxDiscountFirstBlock').val('');
                    }else{
                        $('.discountTypeLableReferrer').html("PERCENTAGE");
                        $('.maxDiscountFirstBlockClass').show();
                    }
                }

                if (referee) {
                
                    $('#Referred').prop('checked', true);

                    $("input[name=SecondBlockDiscountType][value=" + referee.discountType + "]").prop('checked', true);

                    $('#amountsecondBlock').val(referee.discount);
                    $('#maxdiscountsecondBlock').val(referee.maxDiscount);
                    $('#datesecondBlock').val(referee.daysValid);
                     if(referee.discountType == '1'){
                         $('.discountTypeLableReferrered').html("AMOUNT");
                          $('.maxdiscountsecondBlockClass').hide();
                           $('#maxdiscountsecondBlock').val('');
                    }else{
                        $('.discountTypeLableReferrered').html("PERCENTAGE");
                        $('.maxdiscountsecondBlockClass').show();
                         
                    }
                }
            } 
//            else {
//                var campaningData = campaningData.RefferalWallet;
//                newSignUp = 2;
//                if (campaningData.referrer == 1) {
//                    $('#referrefistwallet').prop('checked', true);
//                    $('#amountwalletFirstBlock').val(campaningData.amountReferre);
//                    $('#datewalletFistblock').val(campaningData.ExpiryDateReferre);
//                }
//
//                if (campaningData.referred == 1) {
//                    $('#Referredfirstwallet').prop('checked', true);
//                    $('#amountwalletsecondBlock').val(campaningData.amountReferred);
//                    $('#datewalletsecondBlock').val(campaningData.ExpiryDateReferred);
//                }
//            }
            $("input[name=refferal][value=" + newSignUp + "]").prop('checked', true);
//        }
        if (newSignUp == 0) {
            $("input[name=refferal][value=0]").prop('checked', true);
        }
        $("input[name=refferal][value=" + newSignUp + "]").closest('a').trigger('click');
        var href = $("input[name=refferal][value=" + newSignUp + "]").closest('a').attr('href');
        $("input[name=refferal][value=" + newSignUp + "]").closest('a').closest('.radio').find('a').attr('href', href);

        if (campaningData.rewardType == '2') {
            $("input[name=refferalforrides][value=2]").prop('checked', true);
            $("input[name=refferalforrides][value=2]").closest('a').trigger('click');

            var xrides = campaningData.xrides;
            $("input[name=xridesRadio][value=" + xrides.paymentType + "]").prop('checked', true);
            $("input[name=xridesRadioImmediate][value=" + xrides.immediateTransferTo + "]").prop('checked', true);
            $("input[name=xridesselected][value=" + xrides.type + "]").prop('checked', true);

            if (xrides.type == '1') {
                $('.chekcRideType').html("Number of rides");
            } else if (xrides.type == '2') {
                $('.chekcRideType').html("Amount of rides");
            }

            $("#xrideUnit").val(xrides.units);
        } else {
            $("input[name=refferalforrides][value=1]").prop('checked', true);
            $("input[name=refferalforrides][value=1]").click();
        }
        var href = $("input[name=refferalforrides]:checked").closest('a').attr('href');
        $("input[name=refferalforrides]:checked").closest('a').closest('.radio').find('a').attr('href', href);

        $("#summernote1").html(campaningData.TnC);

        $('input[type="text"], input[type="radio"], input[type="checkbox"], select').prop("disabled", true);
        $('input[type="text"], input[type="radio"], input[type="checkbox"], select').addClass("disabled");
        $('input[type="radio"]').closest('.radio').addClass("disabled");
        $('input[type="checkbox"]').closest('.checkbox').addClass("disabled");
    });

    function alertMessage(message) {
        swal({
            title: message,
            timer: 2000,
            showConfirmButton: false
        });
    }

    function calltrigger(element) {
//        var dis = $('#' + element);
//        if((!$(dis).attr("checked"))||$(dis).attr('type')=='checkbox')
//            $(dis).attr("checked", !$(dis).attr("checked"));
//        if (element == "xridesselected") {
//            $('.chekcRideType').html("Number of rides");
//        } else if (element == "xamountselected") {
//            $('.chekcRideType').html("Amount of rides");
//        }
    }

</script>

<style>
    .radio input[type=radio][disabled] + label, .checkbox input[type=checkbox][disabled] + label{
        opacity:1 !important;
    }
    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control{
        color:black !important;
    }
</style>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <br/>
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ul class="breadcrumb" style="">
                        <li>
                            <a href="<?php echo base_url() ?>index.php/coupons/refferal">REFERRALS</a></li>

                        <li><a href="#" class="active">NEW</a>
                        </li>
                        <p class="pull-right cls110">
<!--                            <button class="btn btn-primary btn-cons m-b-10 submitDataOnserver texttop " type="button" disabled="disabled" ><i class="pg-form" style="color: #ffffff;"></i> <span class="bold" style="color: #ffffff;">Submit</span>
                            </button>-->
                        </p>
                    </ul>
                    <!-- END BREADCRUMB -->
                </div>



                <div class="panel panel-default" style="margin-bottom: 0px;">
                    <div>
                        <div class="panel-body">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fname" class="col-sm-1 control-label temp">TITLE</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="addmemclass1 form-control" id="title"  placeholder="Title"   name="fdata[title]" required="" aria-required="true" disabled="disabled">                                                                                            
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="fname" class="col-sm-1 control-label temp">CITY</label>
                                    <div class="col-sm-7">
                                        <select id="selectedcityNew" name="company_select" class="form-control" disabled="disabled">
                                            <?= $cities_html?>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <span style="color: red; font-size: 20px">*</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="panel panel-group panel-transparent" data-toggle="collapse" id="accordion">
                    <div class="panel panel-primary">
                        <div class="panel-heading"data-parent="#accordion"   data-toggle="collapse" href="#collapseThree">
                            <h4 class="panel-title">
                                <a  >TRIGGERS SETTING</a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse in" id="collapseThree">
                            <div class="panel-body">

                                <div id="REWARDFORNEWSIGNUP">
                                    <div class="panel panel-info">
                                        <div class="panel-heading ">
                                            <div class="panel-title">
                                                REWARD FOR NEW SIGNUP
                                                 </div>
                                             </div>
                                             
                                        <div class="radio" style="margin-top: 25px">
<!--                                                    <a href="#notapplicabletab" data-toggle="tab" role="tab" class="clickable_but">
                                                        <input type="radio"  name="refferal" checked="checked" value="0" id="notapplicable">
                                                        <label onclick="calltrigger('notapplicable')">N/A</label></a>-->
                                                    <a href="#tab2hellowWorld" data-toggle="tab" role="tab" class="clickable_but"><input type="radio"  checked="checked" name="refferal" value="1" id="promocheck">
                                                        <label onclick="calltrigger('promocheck')">Promo Code</label></a>
<!--                                                    <a href="#tab2FollowUs" data-toggle="tab" role="tab" class="clickable_but"><input type="radio" value="2" name="refferal" id="walletClick">
                                                        <label class="walletClick" onclick="calltrigger('walletClick')">Credit Wallet</label></a>-->
                                          
                                               </div>

                                            </div>
                                           

                                       
                                        <div class="panel-body">

                                            <div class="panel">

                                                <div class="tab-content">
                                                    <div id="notapplicabletab" class="tab-pane slide-left">
                                                        <div class="row column-seperation">
                                                            <div class="col-md-12">
                                                                The Service is not applicable.
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="tab-pane slide-left active" id="tab2hellowWorld">
                                                        <div class="row column-seperation">
                                                            <div class="col-md-6">
                                                                <div class="checkbox check-primary">
                                                                    <input type="checkbox" value="1" id="referre">
                                                                    <label onclick="calltrigger('referre')" class="referlabel"> Referrer</label>
                                                                </div>

                                                                <div class="panel panel-default">
                                                                    <div class="panel-body">


                                                                        <form id="form-work" class="form-horizontal" role="form" autocomplete="off" novalidate="novalidate">
                                                                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                                            <div class="form-group">
                                                                                <label class="col-sm-3 control-label">DISCOUNT TYPE</label>
                                                                                <div class="col-sm-9">
                                                                                    <div class="radio radio-success">
                                                                                        <input type="radio" name="firstBlockDiscountType" id="Fixed" value="1">
                                                                                        <label onclick="calltrigger('Fixed')">FIXED</label>
                                                                                        <input type="radio" checked="checked" value="2" name="firstBlockDiscountType" id="percentage" value="2">
                                                                                        <label onclick="calltrigger('percentage')">PERCENTAGE</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="fname" class="col-sm-3 control-label discountTypeLableReferrer">PERCENTAGE</label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="text" class="form-control " id="amountFirstBlock"  name="promotionamount" required="" aria-required="true" aria-invalid="true" onkeypress="return isNumberKey(event, 'amountFirstBlock')" disabled="disabled">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group maxDiscountFirstBlockClass">
                                                                                <label for="fname" class="col-sm-3 control-label">MAX DISCOUNT</label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="text" class="form-control " id="maxDiscountFirstBlock" placeholder="maxdiscount" name="promotionamount"  aria-required="true" aria-invalid="true" onkeypress="return isNumberKey(event, 'maxDiscountFirstBlock')" disabled="disabled">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="position" class="col-sm-3 control-label">NO OF DAYS VALID</label>
                                                                                <div class="col-sm-9">
                                                                                    <!--<input type="text" id="dateFirstBlock" class="form-control">-->
                                                                                    <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                                                        <input type="text" class="form-control " id="dateFirstBlock" disabled="disabled">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </form>


                                                                    </div>
                                                                </div>



                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="checkbox check-primary">
                                                                    <input type="checkbox" value="2" id="Referred">
                                                                    <label onclick="calltrigger('Referred')" class="referlabel">Referee</label>
                                                                </div>

                                                                <div class="panel panel-default">
                                                                    <div class="panel-body">

                                                                        <form id="form-work" class="form-horizontal" role="form" autocomplete="off" novalidate="novalidate">
                                                                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                                            <div class="form-group">
                                                                                <label class="col-sm-3 control-label">DISCOUNT TYPE</label>
                                                                                <div class="col-sm-9">
                                                                                    <div class="radio radio-success">
                                                                                        <input type="radio" name="SecondBlockDiscountType" id="FixednewPromo" value="1">
                                                                                        <label onclick="calltrigger('FixednewPromo')">FIXED</label>
                                                                                        <input type="radio" checked="checked" value="2" name="SecondBlockDiscountType" id="percentagenewpromo">
                                                                                        <label onclick="calltrigger('percentagenewpromo')">PERCENTAGE</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="fname" class="col-sm-3 control-label discountTypeLableReferrered">PERCENTAGE</label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="text" class="form-control " id="amountsecondBlock"  name=""  disabled="disabled" required="" aria-required="true" aria-invalid="true" onkeypress="return isNumberKey(event, 'amountsecondBlock')">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group maxdiscountsecondBlockClass">
                                                                                <label for="fname" class="col-sm-3 control-label">MAX DISCOUNT</label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="text" class="form-control " id="maxdiscountsecondBlock" disabled="disabled" placeholder="maxdiscount" name=""  aria-required="true" aria-invalid="true" onkeypress="return isNumberKey(event, 'maxdiscountsecondBlock')">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="position" class="col-sm-3 control-label">NO OF DAYS VALID</label>
                                                                                <div class="col-sm-9">
                                                                                    <!--<input type="text" id="datesecondBlock" class="form-control">-->
                                                                                    <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                                                        <input type="text" class="form-control " id="datesecondBlock" disabled="disabled"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </form>


                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--/// REWARD FOR NEW SIGNUP promocode-->
                                                    <div class="tab-pane slide-left" id="tab2FollowUs">
                                                        <div class="row column-seperation">
                                                            <div class="col-md-6">
                                                                <div class="checkbox check-primary">
                                                                    <input type="checkbox" value="1" id="referrefistwallet">
                                                                    <label onclick="calltrigger('referrefistwallet')" class="referlabel"> Referrer</label>
                                                                </div>

                                                                <div class="panel panel-default">
                                                                    <div class="panel-body">


                                                                        <form id="form-work" class="form-horizontal" role="form" autocomplete="off" novalidate="novalidate">
                                                                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                                                            <div class="form-group">
                                                                                <label for="fname" class="col-sm-3 control-label">FIXED AMOUNT</label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="text" class="form-control " id="amountwalletFirstBlock"  onkeypress="return isNumberKey(event, 'amountwalletFirstBlock')" placeholder="amount" name="promotionamount" required="" aria-required="true" aria-invalid="true">
                                                                                </div>
                                                                            </div> 
                                                                            <div class="form-group">
                                                                                <label for="position" class="col-sm-3 control-label">NO OF DAYS VALID</label>
                                                                                <div class="col-sm-9">
                                                                                    <!--<input type="text" id="datewalletFistblock" class="form-control">-->
                                                                                    <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                                                        <input type="text" class="form-control " id="datewalletFistblock">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </form>


                                                                    </div>
                                                                </div>



                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="checkbox check-primary">
                                                                    <input type="checkbox" value="1" id="Referredfirstwallet">
                                                                    <label onclick="calltrigger('Referredfirstwallet')" class="referlabel">Referree</label>
                                                                </div>

                                                                <div class="panel panel-default">
                                                                    <div class="panel-body">

                                                                        <form id="form-work" class="form-horizontal" role="form" autocomplete="off" novalidate="novalidate">
                                                                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                                            <div class="form-group">
                                                                                <label for="fname" class="col-sm-3 control-label">FIXED AMOUNT</label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="text" class="form-control " id="amountwalletsecondBlock" onkeypress="return isNumberKey(event, 'amountwalletsecondBlock')" placeholder="amount" name="promotionamount" required="" aria-required="true" aria-invalid="true">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="position" class="col-sm-3 control-label">NO OF DAYS VALID</label>
                                                                                <div class="col-sm-9">
                                                                                    <!--<input type="text" id="datewalletsecondBlock" class="form-control">-->
                                                                                    <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                                                        <input type="text" class="form-control datepicker-component" id="datewalletsecondBlock"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </form>


                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/// REWARD FOR NEW SIGNUP Credit Wallet-->

                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>


                                <div id="REWARDFORCOMPLETINGXRIDESOXAMOUNTOFRIDES">
                                    <div class="panel panel-default">
                                        <div class="panel-heading ">
                                            <div class="panel-title">
                                            
                                                <div class="radio radio-success " style="margin-top: 25px;">
                                                    <a href="#notapplicabletabforridesTab" data-toggle="tab" role="tab" class="clickable_but">
                                                        <input type="radio"  name="refferalforrides" checked="checked" value="1" id="notapplicableforrides" >
                                                        <label onclick="calltrigger('notapplicableforrides')">REWARD FOR NEW SIGNUP</label></a>
                                                    <a href="#applyridesTab" data-toggle="tab" role="tab" class="clickable_but"><input type="radio"  name="refferalforrides" value="2" id="applysetting">
                                                        <label onclick="calltrigger('applysetting')">REWARD FOR COMPLETING X RIDES OR X AMOUNT OF RIDES</label></a>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="panel-body">

                                            <div class="panel">

                                                <div class="tab-content">
                                                    <div id="notapplicabletabforridesTab" class="tab-pane slide-left active">
                                                        <div class="row column-seperation">
                                                            <div class="col-md-12">


                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="tab-pane slide-left" id="applyridesTab">
                                                        <div class="row column-seperation">
                                                            <div class="col-md-12">


                                                                <div class="panel panel-default">
                                                                    <div class="panel-body">

                                                                        <form id="form-work" class="form-horizontal" role="form" autocomplete="off" novalidate="novalidate">
                                                                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                                            <div class="form-group">
                                                                                <label class="col-sm-3 control-label">Immediate Transfer To</label>
                                                                                <div class="col-sm-9">
                                                                                    <div class="radio radio-success">
<!--                                                                                        <input type="checkbox" checked="checked" value="0" name="xridesRadioImmediate" id="ImmediateNone">
                                                                                        <label onclick="calltrigger('ImmediateNone')">None</label>-->
                                                                                        <input type="checkbox" value="1" name="xridesRadioImmediate" id="ImmediateReferrer">
                                                                                        <label onclick="calltrigger('ImmediateReferrer')">Referrer</label>
                                                                                        <input type="checkbox" value="2" name="xridesRadioImmediate" id="ImmediateReferred">
                                                                                        <label onclick="calltrigger('ImmediateReferred')">Referee</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-sm-3 control-label">Applied ON</label>
                                                                                <div class="col-sm-9">
                                                                                    <div class="radio radio-success">
                                                                                       
                                                                                        <input type="radio" checked="checked" value="1" name="xridesRadio" id="cardselected">
                                                                                        <label onclick="calltrigger('cardselected')">Card</label>
                                                                                         <input type="radio" value="2" name="xridesRadio" id="cashselected">
                                                                                        <label onclick="calltrigger('cashselected')">Cash</label>
                                                                                        <input type="radio" checked="checked" value="3" name="xridesRadio" id="bothselected">
                                                                                        <label onclick="calltrigger('bothselected')">Both</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-sm-3 control-label">Applied ON</label>
                                                                                <div class="col-sm-9">
                                                                                    <div class="radio radio-success">
                                                                                        <input type="radio" value="1" name="xridesselected" id="xridesselected">
                                                                                        <label onclick="calltrigger('xridesselected')">X rides</label>
                                                                                        <input type="radio" checked="checked" value="2" name="xridesselected" id="xamountselected">
                                                                                        <label onclick="calltrigger('xamountselected')">X amount</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group" style="border-bottom:0px">
                                                                                <label for="fname" class="col-sm-3 control-label chekcRideType">Amount</label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="text" disabled="disabled" class="form-control"  id="xrideUnit" required="" aria-required="true" aria-invalid="true" onkeypress="return isNumberKey(event, 'xrideUnit')">
                                                                                </div>
                                                                            </div>

                                                                            <!--                                                                            <div class="form-group">
                                                                                                                                                            <label class="col-sm-3 control-label">Reward Type </label>
                                                                                                                                                            <div class="col-sm-9">
                                                                                                                                                                <div class="radio radio-success">
                                                                                                                                                                    <a href="#tabrewardPromocode" data-toggle="tab" role="tab">  <input type="radio" value="1" name="rewardtype" id="rewardPromocode">
                                                                                                                                                                        <label onclick="calltrigger('rewardPromocode')">Promo Code</label></a>
                                                                                                                                                                    <a href="#tabrewardCreditWallet" data-toggle="tab" role="tab"><input type="radio" checked="checked" value="2" name="rewardtype" id="rewardCreditWallet">
                                                                                                                                                                        <label onclick="calltrigger('rewardCreditWallet')">Credit Wallet</label></a>
                                                                                                                                                                </div>
                                                                                                                                                            </div>
                                                                                                                                                        </div>-->

                                                                            <!--//here is the second reffered and reffree comest-->

                                                                            <div class="tab-content">
                                                                                <div class="tab-pane slide-left" id="tabrewardPromocode">
                                                                                    <div class="row column-seperation">
                                                                                        <div class="col-md-6">
                                                                                            <div class="checkbox check-primary">
                                                                                                <input type="checkbox" value="1" id="referreforrewared">
                                                                                                <label onclick="calltrigger('referreforrewared')"> Referrer</label>
                                                                                            </div>

                                                                                            <div class="panel panel-default">
                                                                                                <div class="panel-body">


                                                                                                    <form id="form-work" class="form-horizontal" role="form" autocomplete="off" novalidate="novalidate">
                                                                                                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                                                                        <div class="form-group">
                                                                                                            <label class="col-sm-3 control-label">DISCOUNT TYPE</label>
                                                                                                            <div class="col-sm-9">
                                                                                                                <div class="radio radio-success">
                                                                                                                    <input type="radio" name="secondblockrefferalDiscount" id="Fixedsecondtpromo" value="1">
                                                                                                                    <label onclick="calltrigger('Fixedsecondtpromo')">FIXED</label>
                                                                                                                    <input type="radio" checked="checked" value="2" name="secondblockrefferalDiscount" id="percentagesecondPromo">
                                                                                                                    <label onclick="calltrigger('percentagesecondPromo')">PERCENTAGE</label>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                            <label for="fname" class="col-sm-3 control-label">AMOUNT</label>
                                                                                                            <div class="col-sm-9">
                                                                                                                <input type="text" class="form-control " id="secondblockfeffralamount" placeholder="amount" name="promotionamount" required="" aria-required="true" aria-invalid="true">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                            <label for="fname" class="col-sm-3 control-label">MAX DISCOUNT</label>
                                                                                                            <div class="col-sm-9">
                                                                                                                <input type="text" class="form-control " id="secondblockmaxdiscountRefferal" placeholder="maxdiscount" name="promotionamount"  aria-required="true" aria-invalid="true">
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <div class="form-group">
                                                                                                            <label for="position" class="col-sm-3 control-label">Expiry Date</label>
                                                                                                            <div class="col-sm-9">
                                                                                                                <!--<input type="text" id="secondblockdaterefferal" class="form-control">-->
                                                                                                                <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                                                                                    <input type="text" class="form-control datepicker-component" id="secondblockdaterefferal"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                                                                </div>

                                                                                                            </div>



                                                                                                        </div>

                                                                                                    </form>


                                                                                                </div>
                                                                                            </div>



                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="checkbox check-primary">
                                                                                                <input type="checkbox" value="1" id="Referredforreward">
                                                                                                <label onclick="calltrigger('Referredforreward')">Referree</label>
                                                                                            </div>

                                                                                            <div class="panel panel-default">
                                                                                                <div class="panel-body">

                                                                                                    <form id="form-work" class="form-horizontal" role="form" autocomplete="off" novalidate="novalidate"> <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                                                                        <div class="form-group">
                                                                                                            <label class="col-sm-3 control-label">DISCOUNT TYPE</label>
                                                                                                            <div class="col-sm-9">
                                                                                                                <div class="radio radio-success">
                                                                                                                    <input type="radio" name="secondblockrefferedDiscount" id="Fixedlastpromo" value="1">
                                                                                                                    <label onclick="calltrigger('Fixedlastpromo')">FIXED</label>
                                                                                                                    <input type="radio" checked="checked" value="2" name="secondblockrefferedDiscount" id="percentagelastpromo">
                                                                                                                    <label onclick="calltrigger('percentagelastpromo')">PERCENTAGE</label>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                            <label for="fname" class="col-sm-3 control-label">Amount</label>
                                                                                                            <div class="col-sm-9">
                                                                                                                <input type="text" class="form-control " id="secondblockreffredamount" placeholder="amount" name="promotionamount" required="" aria-required="true" aria-invalid="true">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                            <label for="fname" class="col-sm-3 control-label">MAX DISCOUNT</label>
                                                                                                            <div class="col-sm-9">
                                                                                                                <input type="text" class="form-control " id="secondblockreffredMaxamount" placeholder="maxdiscount" name="promotionamount"  aria-required="true" aria-invalid="true">
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <div class="form-group">
                                                                                                            <label for="position" class="col-sm-3 control-label">NO OF DAYS VALID</label>
                                                                                                            <div class="col-sm-9">
                                                                                                                <!--<input type="text" id="secondblockdatereffred" class="form-control">-->
                                                                                                                <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                                                                                    <input type="text" class="form-control" id="secondblockdatereffred">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                    </form>


                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="tab-pane slide-left" id="tabrewardCreditWallet">
                                                                                    <div class="row column-seperation">
                                                                                        <div class="col-md-6">
                                                                                            <div class="checkbox check-primary">
                                                                                                <input type="checkbox" value="1" id="referresecondwallet">
                                                                                                <label onclick="calltrigger('referresecondwallet')"> Referrer</label>
                                                                                            </div>

                                                                                            <div class="panel panel-default">
                                                                                                <div class="panel-body">


                                                                                                    <form id="form-work" class="form-horizontal" role="form" autocomplete="off" novalidate="novalidate"> <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                                                                                        <div class="form-group">
                                                                                                            <label for="fname" class="col-sm-3 control-label">FIXED AMOUNT</label>
                                                                                                            <div class="col-sm-9">
                                                                                                                <input type="text" class="form-control " id="secondblockwalletamountreffer" placeholder="amount" name="promotionamount" required="" aria-required="true" aria-invalid="true">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                            <label for="position" class="col-sm-3 control-label">NO OF DAYS VALID</label>
                                                                                                            <div class="col-sm-9">
                                                                                                                <!--<input type="text" id="secondblockwalletdatereffer" class="form-control">-->
                                                                                                                <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                                                                                    <input type="text" class="form-control " id="secondblockwalletdatereffer">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                    </form>


                                                                                                </div>
                                                                                            </div>



                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="checkbox check-primary">
                                                                                                <input type="checkbox" value="1" id="Referredsecondwallet">
                                                                                                <label onclick="calltrigger('Referredsecondwallet')">Referree</label>
                                                                                            </div>

                                                                                            <div class="panel panel-default">
                                                                                                <div class="panel-body">

                                                                                                    <form id="form-work" class="form-horizontal" role="form" autocomplete="off" novalidate="novalidate"> <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                                                                        <div class="form-group">
                                                                                                            <label for="fname" class="col-sm-3 control-label">FIXED AMOUNT</label>
                                                                                                            <div class="col-sm-9">
                                                                                                                <input type="text" class="form-control " id="secondblockwalletamountreffered" placeholder="amount" name="promotionamount" required="" aria-required="true" aria-invalid="true">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                            <label for="position" class="col-sm-3 control-label">NO OF DAYS VALID</label>
                                                                                                            <div class="col-sm-9">
                                                                                                                <!--<input type="text" id="secondblockdatereffered" class="form-control">-->
                                                                                                                <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                                                                                    <input type="text" class="form-control datepicker-component" id="secondblockdatereffered">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                    </form>


                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!--end of reffred second--> 






                                                                        </form>


                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>



                                            </div>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-primary">
                        <div class="panel-heading" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" >
                                    TERM & CONDITIONS 
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseTwo" style="height: 0px;">
                            <div class="panel-body">
                                <div class="summernote-wrapper">
                                    <div id="summernote">
                                        <label>Term & Conditions<a target="_new" href="">Preview</a></label>
                                            
                                        <textarea name="termscond" id="termscond" disabled="disabled"><?php echo $canpaningData[0]['termscond'];?></textarea>
                                                <script>
                                                    CKEDITOR.replace('termscond');
                                                </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>


    </div>
</div>



