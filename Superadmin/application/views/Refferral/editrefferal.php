<style>
    #selectedcity,#companyid{
        display: none;
    }
    
a.clickable_but {
    background: #7dc1fb;
    padding: 10px 11px;
    border-radius: 5px;
    color: #fff;
    margin-top: 10px;
    margin-left: 12px;
}

.referlabel{
    font-size: 14px !important;
}
button.btn.btn-primary.btn-cons.m-b-10.submitDataOnserver.texttop {
    margin-top: -12px;
}
.checkbox label, .radio label {
    min-height: 20px;
    padding-left: 20px;
    margin-bottom: 0;
    font-weight: 400;
    cursor: pointer;
    font-size: 13px;
}
label.col-sm-1.control-label.temp {
    margin-top: 8px;
}
</style>
<script src="<?php echo base_url() ?>supportFiles/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>supportFiles/sweetalert.css">


<!--<script src="<?php echo base_url() ?>supportFiles/ckeditor.js"></script>-->

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
    $(document).ready(function () {
      
//        $('#collapseOneancher').click();
//        CKEDITOR.replace('editor1');
//        $('#selectedcityNew').html($('#selectedcity').html());

        $("input[type=radio]").click(function (event) {
            event.stopPropagation();
        });
        $("input[type=checkbox]").click(function (event) {
            event.stopPropagation();
        });


        var campaningData = <?= json_encode($canpaningData[0]) ?>;
        
        
        var campaningID = '<?= (string) $canpaningData['cityId']?>';
        var referee = campaningData.referee;
        var referrer = campaningData.referrer;

        
        $('#title').val(campaningData.title);
//        
       console.log(campaningData);
      $('#selectedcityNew').append($('<option>', {
    value:   campaningData.cityId.$oid  ,
    text:  campaningData.cityName 
}));
// $('#selectedcityNew').val(campaningData.cityId);
       var Id = campaningData._id.$oid;
    
        var newSignUp = 0;
           if (campaningData.referralType == 1) {

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
//        else {
//            var NewsignupReward = campaningData.RefferalWallet;
//            newSignUp = 2;
//            if (NewsignupReward.referre == 1) {
//                $('#referrefistwallet').prop('checked', true);
//                $('#amountwalletFirstBlock').val(NewsignupReward.discount);
//                $('#datewalletFistblock').val(NewsignupReward.daysValid);
//            }
//
//            if (NewsignupReward.referred == 1) {
//                $('#Referredfirstwallet').prop('checked', true);
//                $('#amountwalletsecondBlock').val(NewsignupReward.discount);
//                $('#datewalletsecondBlock').val(NewsignupReward.daysValid);
//            }
//        }
        $("input[name=refferal][value=" + newSignUp + "]").prop('checked', true);
//        }
        if (newSignUp == 0) {
            $("input[name=refferal][value=0]").prop('checked', true);
        }
        $("input[name=refferal][value=" + newSignUp + "]").closest('a').trigger('click');
//        var href = $("input[name=refferal][value=" + newSignUp + "]").closest('a').attr('href');
//        $("input[name=refferal][value=" + newSignUp + "]").closest('a').closest('.radio').find('a').attr('href', href);

        if (campaningData.rewardType == '2') {
            $("input[name=refferalforrides][value=2]").prop('checked', true);
            $("input[name=refferalforrides][value=2]").closest('a').trigger('click');
            
            var xrides = campaningData.xrides;
            $("input[name=xridesRadio][value=" + xrides.type + "]").prop('checked', true);
            $("input[name=xridesRadioImmediate][value=" + xrides.immediateTransferTo + "]").prop('checked', true);
            $("input[name=xridesselected][value=" + xrides.paymentType + "]").prop('checked', true);

            if (xrides.type == '1') {
                $('.chekcRideType').html("Number of rides");
            } else if (xrides.type == '2') {
                $('.chekcRideType').html("AMOUNT");
            }

            $("#xrideUnit").val(xrides.units);
        } else {
            $("input[name=refferalforrides][value=1]").prop('checked', true);
            $("input[name=refferalforrides][value=1]").click();
        }
//        var href = $("input[name=refferalforrides]:checked").closest('a').attr('href');
//        $("input[name=refferalforrides]:checked").closest('a').closest('.radio').find('a').attr('href', href);

        $("#summernote").html(campaningData.TnC);


         $('.submitDataOnserver').click(function () {
            
            $(this).prop("disabled", true);
            var cityId = $('#selectedcityNew').val();
             var cityName = $("#selectedcityNew option:selected").attr('data-name');
            if (cityId == 0) {
                alertMessage('Please Select City');
                $(this).prop("disabled", false);
            } else {

                run_waitMe('bounce');

                /************************************************************************/
                var RefferalType = $("input[name=refferal]:checked").val();
                var RewardType = $("input[name=refferalforrides]:checked").val();



                /************RefferalType = 1 *****/
                // if promo code referrer
                var referre = $("#referre:checked").val();
                var referred = $("#Referred:checked").val();

                var discountTypeReferre = $("input[name=firstBlockDiscountType]:checked").val();
                var PromoamountReferre = $("#amountFirstBlock").val();
                var dateFirstBlock = $("#dateFirstBlock").val();
                var maxDiscountFirstBlock = $("#maxDiscountFirstBlock").val();

                // end of promocode    

                // if promocode reffered 
                var discountTypeReferred = $("input[name=SecondBlockDiscountType]:checked").val();
                var PromoamountReferred = $("#amountsecondBlock").val();
                var datesecondBlock = $("#datesecondBlock").val();
                var maxdiscountsecondBlock = $("#maxdiscountsecondBlock").val();
                // end of prmocode 
                /****************end of RefferalType = 1******************/



                var errorno = 0;
                if (RefferalType == 1) {
                    if (typeof referre == "undefined" && typeof referred == "undefined") {
                        alertMessage('Please select one of (Referrer / Referred).');
                        errorno = 1;
                    }
                    if (typeof referre != "undefined") {
                        if (PromoamountReferre == '0' || PromoamountReferre == '') {
                            if (discountTypeReferre == 2)
                                alertMessage('Please insert Percentage for Referrer.');
                            else if (discountTypeReferre == 1)
                                alertMessage('Please insert amount for Referrer.');
                            errorno = 1;
                        } else if (dateFirstBlock == '') {
                            alertMessage('Please select Expired Date for Referrer.');
                            errorno = 1;
                        } else if (discountTypeReferre == '2' && maxDiscountFirstBlock == '') {
                            alertMessage('Please insert Max amount for Referrer.');
                            errorno = 1;
                        }

                    }
                    if (typeof referred != "undefined") {

                        if (PromoamountReferred == '0' || PromoamountReferred == '') {
                            if (discountTypeReferred == 2)
                                alertMessage('Please insert Percentage for Referred.');
                            else if (discountTypeReferred == 1)
                                alertMessage('Please insert amount for Referred.');
                            errorno = 1;
                        } else if (datesecondBlock == '') {
                            alertMessage('Please select Expired Date for Referred.');
                            errorno = 1;
                        } else if (discountTypeReferred == '2' && maxdiscountsecondBlock == '') {
                            alertMessage('Please insert Max amount for Referred.');
                            errorno = 1;
                        }

                    }

                }

                if(referre =='1'){
                var referrer = {
//                    referrer: ((typeof referre == "undefined") ? 0 : 1),
                    
                    discountType: discountTypeReferre,
                    discount: PromoamountReferre,
                    daysValid: dateFirstBlock,
                    maxDiscount: maxDiscountFirstBlock,
                   
                }
            }
               if(referred == '1'){
    var referee = { 
//                    referee: ((typeof referred == "undefined") ? 0 : 1),
                    discountType: discountTypeReferred,
                    discount: PromoamountReferred,
                    daysValid: datesecondBlock,
                    maxDiscount: maxdiscountsecondBlock

                  }
          }

                /************RefferalType = 2 *****/

                var referreWallet = $("#referrefistwallet:checked").val();
                var referredWallet = $("#Referredfirstwallet:checked").val();
                // if wallet referrer
                var referreWalletAmount = $("#amountwalletFirstBlock").val();
                var referreWalletExpire = $("#datewalletFistblock").val();

                // end of referre wallet

                //if wallet referred
                var referredWalletAmount = $("#amountwalletsecondBlock").val();
                var referredWalletExpire = $("#datewalletsecondBlock").val();
                // end of wallet referred

                /****************end of RefferalType = 2******************/




                if (RefferalType == 2) {
                    if (typeof referreWallet == "undefined" && typeof referredWallet == "undefined") {
                        alertMessage('Please select one of (Referrer / Referred).');
                        errorno = 1;
                    } else if (typeof referreWallet != "undefined") {
                        if (referreWalletAmount == '0' || referreWalletAmount == '') {
                            alertMessage('Please insert amount for Referrer.');
                            errorno = 1;
                        } else if (referreWalletExpire == '') {
                            alertMessage('Please select Expired Date for Referrer.');
                            errorno = 1;
                        }

                    }

                    if (typeof referredWallet != "undefined") {

                        if (referredWalletAmount == '0' || referredWalletAmount == '') {
                            alertMessage('Please insert amount for Referred.');
                            errorno = 1;
                        } else if (referredWalletExpire == '') {
                            alertMessage('Please select Expired Date for Referred.');
                            errorno = 1;
                        }
                    }
                }


//                var RefferalWallet = {
//                    referre: ((typeof referreWallet == "undefined") ? 0 : 1),
//                    referred: ((typeof referredWallet == "undefined") ? 0 : 1),
//                    amountReferre: referreWalletAmount,
//                    ExpiryDateReferre: referreWalletExpire,
//                    amountReferred: referredWalletAmount,
//                    ExpiryDateReferred: referredWalletExpire,
//                };



                /*********** if RewardType = 2 ********/

                var xrides_Paytype = $("input[name=xridesRadio]:checked").val();
                var xrides_ImediateTo = $("input[name=xridesRadioImmediate]:checked").val();
                var xrides_Type = $("input[name=xridesselected]:checked").val();
                var xrides_Unit_or_amount = $("#xrideUnit").val();

                /************** end of RewardType = 2********/

                if (RewardType == 2) {
                    if (xrides_Type == 1 && (xrides_Unit_or_amount == '' || xrides_Unit_or_amount == '0')) {
                        alertMessage('Please insert Number Of Rides.');
                        errorno = 1;
                    } else if (xrides_Type == 2 && (xrides_Unit_or_amount == '' || xrides_Unit_or_amount == '0')) {
                        alertMessage('Please insert Amount For X Rides.');
                        errorno = 1;
                    }
                }
 
              if(RewardType == 2)  {      
                var xrides = {
                    immediateTransferTo: xrides_ImediateTo,
                    paymentType: xrides_Paytype,
                    type: xrides_Type,
                    units: xrides_Unit_or_amount,
                }
            }


//                console.log('PromoRefferal =>' + RefferalPromo+'RefferalWallet => '+ RefferalWallet);
//                console.log('xrides=>' + xrides);
                $('.content').waitMe('hide');
                

                /*************************************************************************/
                if (errorno == 0) {
                    
                      $.ajax({
                    url: "<?php echo base_url() ?>index.php/Referral/UpdateRefferal",
                    type: "POST",
                    data: {
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',
                           'Id':Id,
                            'referralType': RefferalType,
                            'rewardType': RewardType,
                            'cityId': cityId,
                            'cityName':cityName,
                            'couponType': "REFERRAL",
                            'title': $('#title').val(),
                            'TnC': $(".note-editable").html(), //CKEDITOR.instances.editor1.getData(),
                            referrer: referrer,
                                     referee: referee,
//                            RefferalWallet: RefferalWallet,

                            xrides: xrides
                    },
                    dataType: "JSON",
                    success: function (result) {
                        if (result.msg == '0') {
                            $('.content').waitMe('hide');
                            window.location = "<?php echo base_url() ?>index.php/Referral/refferal";

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
                }

            }


        });
         
        $('#Fixed').click(function(){
            $('.discountTypeLableReferrer').html("AMOUNT");
            $('.maxDiscountFirstBlockClass').css({"display": "none"});
            $('#amountFirstBlock').val(0);
        });
         $('#percentage').click(function(){
              $('.discountTypeLableReferrer').html("PERCENTAGE");
            $('.maxDiscountFirstBlockClass').css({"display": "block"});
            $('#amountFirstBlock').val(0);
         });
        $('#FixednewPromo').click(function(){
             $('.discountTypeLableReferrered').html("Amount");
            $('.maxdiscountsecondBlockClass').css({"display": "none"});

        });
        $('#percentagenewpromo').click(function(){
             $('.discountTypeLableReferrered').html("PERCENTAGE");
            $('.maxdiscountsecondBlockClass').css({"display": "block"});
            $('#amountsecondBlock').val(0);

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
        if ((!$(dis).attr("checked")) || $(dis).attr('type') == 'checkbox')
            $(dis).attr("checked", !$(dis).attr("checked"));
        if (element == "xridesselected") {
            $('.chekcRideType').html("Number of rides");
        } else if (element == "xamountselected") {
            $('.chekcRideType').html("Amount of rides");
        }
        if (element == "percentage") {
            $('.discountTypeLableReferrer').html("PERCENTAGE");
            $('.maxDiscountFirstBlockClass').css({"display": "block"});
            $('#amountFirstBlock').val(0);
        } else if (element == "Fixed") {
            $('.discountTypeLableReferrer').html("AMOUNT");
            $('.maxDiscountFirstBlockClass').css({"display": "none"});
            $('#amountFirstBlock').val(0);
        }
        if (element == "FixednewPromo") {
            $('.discountTypeLableReferrered').html("Amount");
            $('.maxdiscountsecondBlockClass').css({"display": "none"});

            $('#amountsecondBlock').val(0);
        } else if (element == "percentagenewpromo") {
            $('.discountTypeLableReferrered').html("PERCENTAGE");
            $('.maxdiscountsecondBlockClass').css({"display": "block"});
            $('#amountsecondBlock').val(0);
        }
    }
</script>


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
                            <a href="<?php echo base_url() ?>index.php/Referral/refferal">REFERRALS</a></li>

                        <li><a href="#" class="active">NEW</a>
                        </li>
                        <p class="pull-right cls110">
                            <button class="btn btn-primary btn-cons m-b-10 submitDataOnserver texttop " type="button" ><i class="pg-form" style="color: #ffffff;"></i> <span class="bold" style="color: #ffffff;">Submit</span>
                            </button>
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
                                        <input type="text" class="addmemclass1 form-control" id="title"  placeholder="Title"   name="fdata[title]" required="" aria-required="true">                                                                                            
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="fname" class="col-sm-1 control-label temp">CITY</label>
                                    <div class="col-sm-7">
                                        <select id="selectedcityNew" name="company_select" class="form-control">
                                            
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
                                                    <!--<a href="#notapplicabletab" data-toggle="tab" role="tab">-->
<!--                                                        <input type="radio"  name="refferal" checked="checked" value="0" id="notapplicable">
                                                        <label onclick="calltrigger('notapplicable')">N/A</label></a>-->
                                                    <a href="#tab2hellowWorld" data-toggle="tab" role="tab" class="clickable_but"><input type="radio"  checked="checked" name="refferal" value="1" id="promocheck">
                                                        <label onclick="calltrigger('promocheck')">Promo Code</label></a>
                                                    <a href="#tab2FollowUs" data-toggle="tab" role="tab" class="clickable_but"><input type="radio" value="2" name="refferal" id="walletClick">
                                                        <label class="walletClick" onclick="calltrigger('walletClick')">Credit Wallet</label></a>
                                          
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
                                                                                    <input type="text" class="form-control " id="amountFirstBlock"  name="promotionamount" required="" aria-required="true" aria-invalid="true" onkeypress="return isNumberKey(event, 'amountFirstBlock')">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group maxDiscountFirstBlockClass">
                                                                                <label for="fname" class="col-sm-3 control-label" id="maxfirstDiscount">MAX DISCOUNT</label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="text" class="form-control " id="maxDiscountFirstBlock" placeholder="maxdiscount" name="promotionamount"  aria-required="true" aria-invalid="true" onkeypress="return isNumberKey(event, 'maxDiscountFirstBlock')">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="position" class="col-sm-3 control-label">NO OF DAYS VALID</label>
                                                                                <div class="col-sm-9">
                                                                                    <!--<input type="text" id="dateFirstBlock" class="form-control">-->
                                                                                    <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                                                        <input type="text" class="form-control datepicker-component" id="dateFirstBlock"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </form>


                                                                    </div>
                                                                </div>



                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="checkbox check-primary">
                                                                    <input type="checkbox" value="1" id="Referred">
                                                                    <label onclick="calltrigger('Referred')" class="referlabel">Referred</label>
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
                                                                                    <input type="text" class="form-control " id="amountsecondBlock"  name="" required="" aria-required="true" aria-invalid="true" onkeypress="return isNumberKey(event, 'amountsecondBlock')">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group maxdiscountsecondBlockClass">
                                                                                <label for="fname" class="col-sm-3 control-label">MAX DISCOUNT</label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="text" class="form-control " id="maxdiscountsecondBlock" placeholder="maxdiscount" name=""  aria-required="true" aria-invalid="true" onkeypress="return isNumberKey(event, 'maxdiscountsecondBlock')">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="position" class="col-sm-3 control-label">NO OF DAYS VALID</label>
                                                                                <div class="col-sm-9">
                                                                                    <!--<input type="text" id="datesecondBlock" class="form-control">-->
                                                                                    <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                                                        <input type="text" class="form-control datepicker-component" id="datesecondBlock"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
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
                                                                                        <input type="text" class="form-control datepicker-component" id="datewalletFistblock"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
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
                                                                    <label onclick="calltrigger('Referredfirstwallet')" class="referlabel">Referred</label>
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
                                                                                        <input type="radio" checked="checked" value="0" name="xridesRadioImmediate" id="ImmediateNone">
                                                                                        <label onclick="calltrigger('ImmediateNone')">None</label>
                                                                                        <input type="radio" value="1" name="xridesRadioImmediate" id="ImmediateReferrer">
                                                                                        <label onclick="calltrigger('ImmediateReferrer')">Referrer</label>
                                                                                        <input type="radio" value="2" name="xridesRadioImmediate" id="ImmediateReferred">
                                                                                        <label onclick="calltrigger('ImmediateReferred')">Referred</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-sm-3 control-label">Applied ON</label>
                                                                                <div class="col-sm-9">
                                                                                    <div class="radio radio-success">
                                                                                        <input type="radio" value="1" name="xridesRadio" id="cashselected">
                                                                                        <label onclick="calltrigger('cashselected')">Cash</label>
                                                                                        <input type="radio" checked="checked" value="2" name="xridesRadio" id="cardselected">
                                                                                        <label onclick="calltrigger('cardselected')">Card</label>
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
                                                                                <label for="fname" class="col-sm-3 control-label chekcRideType">AMOUNT</label>
                                                                                <div class="col-sm-9">
                                                                                    <input type="text" class="form-control"  id="xrideUnit" required="" aria-required="true" aria-invalid="true" onkeypress="return isNumberKey(event, 'xrideUnit')">
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
                                                                                                                    <label onclick="calltrigger('percentagesecondPromo')">percentage</label>
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
                                                                                                <label onclick="calltrigger('Referredforreward')">Referred</label>
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
                                                                                                            <label for="fname" class="col-sm-3 control-label">AMOUNT</label>
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
                                                                                                                    <input type="text" class="form-control datepicker-component" id="secondblockdatereffred"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
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
                                                                                                                    <input type="text" class="form-control datepicker-component" id="secondblockwalletdatereffer"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
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
                                                                                                <label onclick="calltrigger('Referredsecondwallet')">Referred</label>
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
                                                                                                                    <input type="text" class="form-control datepicker-component" id="secondblockdatereffered"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
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





