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

    .referlabel{
        font-size: 14px !important;

    }
    .aligntext{
        margin-top:12px; 
        font-size: 11px;
    }
    .aligntext1{
        margin-top:12px; 
        font-size: 11px;
    }
    .removePadding{
        padding: 0 !important;
    }
    .marginLeft{
        margin-left: 5px !important;
    }

    .checkbox label, .radio label {
        min-height: 20px;
        padding-left: 20px;
        margin-bottom: 0;
        font-weight: 400;
        cursor: pointer;
        font-size: 13px;
    }
    button.btn.btn-primary.btn-cons.m-b-10.postAOffer.texttop {
        margin-top: -12px;
    }

    .multiselect-container>li>a>label.radio input[type=radio] {
        display: none;
    }

    .clickable_but {
        background: #7dc1fb;
        padding: 4px 7px;
        border-radius: 5px;
        color: #fff;
        margin-top: 10px;
        margin-left: 12px;
    }

    .fontSize {
        font-size: 15;
        border-bottom: 8px solid
    }
    .mandatoryField{
        color: red; 
    }
    .form-group select.form-control {
        height: 34px;
        overflow: initial;
        width: 500px;
    }
    .marginTop{
        margin-top: 15px !important;
    }
    .padding{
        padding: 10px !important;
    }

    .error-box{
        font-size: 15px;
    }
    /*    .checkbox input[type="checkbox"] {
            margin: 0 ;
            left: 20px ;
        }*/
    .breadClass:before{
        content: initial !important; 
    }
    .breadClass{
        font-weight: 600;
        font-size: 11px;
        color: #0090d9 !important;
    }
    .bootstrap-timepicker-widget table td input{
        width: 60px;

    }
    .percentageSpan{
        font-size: 20px;
        position: absolute;
        right: 48px;
        background: gainsboro;
        height: 33px;
        display: inline-block;
        padding: 4px 12px;
    }
    .percentageSpan{
        font-size: 20px;
        position: absolute;
        right: 48px;
        background: gainsboro;
        height: 33px;
        display: inline-block;
        padding: 4px 12px;
    }
    .submitButtonCss{
        position: fixed;
        right: 6%;
        bottom: 0;
        z-index: 1000000;
        border-radius: 25px;
    }
    .multiselect-search{
        width: 270% !important;
    }
    .multiselect-clear-filter{

        display: none;
    }

    /*CSS*/
    .checkbox input[type=checkbox] {
        position: absolute;
        margin-left: -14px;
    }
    .checkbox, .radio {
        position: relative;
        display: block;
        margin-bottom: 0px;
        margin-left: 5px;
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


</style>
<script type="text/javascript">
    // $('#starttime').datetimepicker({
    //     use24hours: true
    // });
</script>
<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script src="<?php echo base_url() ?>supportFiles/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>supportFiles/sweetalert.css">
<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>supportFiles/waitMe.css">
<script src="<?php echo base_url() ?>supportFiles/waitMe.js"></script>
<script>

// none, bounce, rotateplane, stretch, orbit, 
// roundBounce, win8, win8_linear or ios
//        var current_effect = 'bounce'; // 

  function isNumberKey(evt, obj) {

       evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function run_waitMe(effect) {
        $('.content').waitMe({
            none, rotateplane, stretch, orbit, roundBounce, win8,
            win8_linear, ios, facebook, rotation, timer, pulse,
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
// Call trigger function for radio button field change
    function calltrigger(element) {

        var dis = $('#' + element);
        if ((!$(dis).attr("checked")) || $(dis).attr('type') == 'checkbox')
            $(dis).attr("checked", !$(dis).attr("checked"));

        $('#referrerPercentageValue').attr('disabled', false);
        if (element == 'referrerFixedValue') {
            $('.referrerAmountLabel').html('AMOUNT');
            $('.referrerMaxDiscount').hide();
        } else if (element == 'referrerPercentageValue') {
//            $('.referrerAmountLabel').html('PERCENTAGE');
//            $('#cityCurrency').addClass('hide');
//            $('.referrerMaxDiscount').show();
//            $(".newUserForPercentage").removeClass('hide');


            if ($('#offerAvailImmediateRefUser').is(':checked')) {
                calltrigger('referrerFixedValue');
            } else {
                $('.referrerAmountLabel').html('PERCENTAGE');
                $('#cityCurrency').text('%');
                $('.referrerMaxDiscount').show();
            }

        } else if (element == 'newUserPercentageValue') {
//            $('.newUserAmountLable').html('PERCENTAGE');
//            $("#newUserCityCurrency").addClass('hide');
//            $('.newUserMaxDiscount').show();
//            $(".newUserForPercentage").removeClass('hide');

            if ($('#offerAvailImmediateNewUser').is(':checked')) {
                calltrigger('newUserFixedValue');
            } else {
                $('.newUserAmountLable').html('PERCENTAGE');
                $("#newUserCityCurrency").addClass('hide');
                $('.newUserMaxDiscount').show();
            }
            $(".newUserForPercentage").removeClass('hide');
        } else if (element == 'newUserFixedValue') {
            $("#newUserCityCurrency").removeClass('hide');
            $('.newUserAmountLable').html('AMOUNT');
            $('.newUserMaxDiscount').hide();
            $(".newUserForPercentage").addClass('hide');
        } else if (element == 'newUserTripCountTrigger') {
            $('.requiredBillingAmount').addClass('hide');
            $('.tripCountTrigger').removeClass('hide');
        } else if (element == "newUserTotalBusinessTrigger") {
            $('.requiredBillingAmount').removeClass('hide');
            $('.tripCountTrigger').addClass('hide');
        } else if (element == "xridesselected") {
            $('.chekcRideType').html("NUMBER OF RIDES");
            $("#xrideUnit").css({'display': 'block'});
            $("#xrideUnit").val(1);
        } else if (element == "xamountselected") {
            $('.chekcRideType').html("Amount of rides");
            $("#xrideUnit").css({'display': 'block'});
        } else if (element == "General") {
            $('.chekcRideType').html("N/A");
            $("#xrideUnit").css({'display': 'none'});
            $("#xrideUnit").val(0);
        } else if (element == "creditintowallet") {
            $('.creditTowalletIFyes').html("Expiry Date");
            $("#creditTowalletIFyes").css({'display': 'block'});
        } else if (element == "Discountontrip") {
            $('.creditTowalletIFyes').html("N/A");
            $("#creditTowalletIFyes").css({'display': 'none'});
        } else if (element == "criteriamin") {
            $('.criteriaType').html("Minimum Trips");
        } else if (element == "criteriamax") {
            $('.criteriaType').html("Maximum Trips");
        }
        
        
        if ($('#offerAvailImmediateRefUser').is(':checked'))
        {
            $('.referrerAmountLabel').html('AMOUNT');
            $('.referrerMaxDiscount').hide();
            $('#referrerPercentageValue').attr('disabled', true);
        }
        
        if ($('#offerAvailImmediateNewUser').is(':checked'))
        {
            $("#newUserCityCurrency").removeClass('hide');
            $('.newUserAmountLable').html('AMOUNT');
            $('.newUserMaxDiscount').hide();
            $(".newUserForPercentage").addClass('hide');
            
            $('#newUserPercentageValue').attr('disabled', true);
        }
        
        if (element == 'zonecheck' && $('#zonecheck').attr("checked")) {
//            run_waitMe('bounce');
            var cityId = $('#selectedcityNew').find(":selected").text();
            if (cityId != "All") {
                $.ajax({
                    url: "<?php echo base_url() ?>index.php/coupons/getCityZone",
                    type: "POST",
                    data: {
<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
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








    function getDateINtimpstamp(dateString) {
        var dateTimeParts = dateString.split(' '),
                dateParts = dateTimeParts[0].split('-'),
                date;
        date = (new Date(dateParts[0] + "/" + dateParts[1] + "/" + dateParts[2] + " " + dateTimeParts[1] + ":" + dateTimeParts[3] + ":00").getTime() / 1000);
        return date;
    }


// Function to get all zones

// Function to get all cities
function citiesList(){
        $.ajax({
                url: "<?php echo base_url() ?>" + "index.php?/ReferralController/getCityData",
                type: 'GET',
                dataType: 'json',
                headers: {
                  language: 0
                },
                data: {                  
                },
            }).done(function(json) {
                
               
                $("#citiesList").html('');
                
                 for (var i = 0; i< json.data.length; i++) {
                
                    //var citiesList = "<option value="+ json.data[i].cities.cityId.$oid + " currency="+ json.data[i].cities.currency + ">"+  json.data[i].cities.cityName +"</option>";
                    var citiesList = "<option value="+ json.data[i].id + " currency="+ json.data[i].currency + ">"+  json.data[i].cityname +"</option>";
                    $("#citiesList").append(citiesList);  
                }
                 $('#citiesList').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering : true,
                    buttonWidth: '100%',
                    maxHeight: 300,
                });
        });
     }
// Function to get all zones
    function getAllZones(cityIds) {
        $.ajax({
            url: "<?php echo APILink ?>" + "zones/" + cityIds,
            type: 'GET',
            dataType: 'json',
            headers: {
                'language':'en'
            },
            data: {
            },
        }).done(function (json) {
            if (json.data.length == 0) {
                $(".zonesData").addClass('hide');
            } else {
                $(".zonesData").removeClass('hide');
                $("#zonesList").html('');
                $("#zonesList").append("<option disabled selected value> None Selected</option>");
                for (var i = 0; i < json.data.length; i++) {

                    var zonesList = "<option value=" + json.data[i]._id + ">" + json.data[i].title + "</option>";
                    $("#zonesList").append(zonesList);
                }
            }
        });
    }
    function getAllCategoryByCityId(cityIds) {
        $.ajax({
            url: "<?php echo base_url('index.php?/couponCode') ?>/getCatList",
            type: 'POST',
            dataType: 'json',
            data: {
                cityid: cityIds,
            },
        }).done(function (json) {
            if (json.data.length == 0) {
                $(".catData").addClass('hide');
            } else {

                $("#catList").html('');
                $.each(json.data, function (key, value)
                {
                    $('#catList').append('<option value="' + value['_id']['$oid'] + '">' + value['typeName']['en'] + '</option>');
                });
                $('#catList').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    buttonWidth: '100%',
                    maxHeight: 300,
                });
                $("#catList2").html('');
                $.each(json.data, function (key, value)
                {
                    $('#catList2').append('<option value="' + value['_id']['$oid'] + '">' + value['typeName']['en'] + '</option>');
                });
                $('#catList2').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    buttonWidth: '100%',
                    maxHeight: 300,
                });
                $('#catList').hide();
                $('#catList2').hide();
            }
        });
    }
// Function to get all product categories
// Check all the fields has been filled or not
    function validateOfferFields() {
        var isFilled = true;
        if ($("#titile").val().length == 0) {
            var isFilled = false;
            $("#offerTitleError").text("Please enter offer title");
        }
        // if ($("#Promocode").val().length == 0) {
        //     var isFilled = false;
        //     $("#promoCodeError").text("Please enter promo code");
        // }
        if ($("#tripCount").val().length == 0) {
            var isFilled = false;
            $("#tripCountError").text("Please enter trip count");
        }


    }
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

      function checkAllFields(){
        var isFilled = true;
        if ($("#titile").val().length == 0) {
            isFilled = false;
            $("#offerTitleError").text('Please enter the title');
        }
        
        // if ($("#perUserLimit").val().length == 0) {
        //     isFilled = false;
        //     $("#perUserLimitError").text('Please enter store liability');
        // }
        if ($("#startDate").val().length == 0) {
            isFilled = false;
            $("#startDateError").text('Please select the start date');
        }
        if ($("#EndDate").val().length == 0) {
            isFilled = false;
            $("#endDateError").text('Please select the end date');
        }
        if ($("#citiesList").val().length == 0){
            isFilled = false;
            $("#citiesError").text('Please select city');
        }

        var d=new Date();
        var stdate=($("#startDate").val());
        var Edate=($('#EndDate').val());
        var fDate = d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear();
        
        var dateObject = $("#startDate").datepicker("getDate");
        var dateObject2 = $("#EndDate").datepicker("getDate");
       
        
        var startDate = dateObject.getFullYear() + '-' + ("0" + (dateObject.getMonth() + 1)).slice(-2) + '-' + ("0" + dateObject.getDate()).slice(-2);
        var endDate = dateObject2.getFullYear() + '-' + ("0" + (dateObject2.getMonth() + 1)).slice(-2) + '-' + ("0" + dateObject2.getDate()).slice(-2);
        var startDate = new Date(startDate);
        var endDate = new Date(endDate);

          if(startDate<endDate)
        {           
        }else{
            isFilled = false;
            $("#endDateError").text('End date must be greater than Start date');
            
        }
        
        if (isFilled) {
            return true;
        }else{
           // document.getElementById('enableBtn').disabled = false;
            return false;
        }
     }


    $(document).ready(function () {
        citiesList();

        $('#offerAvailImmediateRefUser').change(function () {
            if ($(this).is(':checked')) {
                calltrigger('referrerFixedValue');
            } else
                $('#referrerPercentageValue').attr('disabled', false);
        })

        $('#offerAvailImmediateNewUser').change(function () {
            if ($(this).is(':checked')) {
                calltrigger('newUserFixedValue');
            } else
                $('#newUserPercentageValue').attr('disabled', false);
        })


        if ($("#citiesList").val()) {
            var cityIdForNonFranchiseStore = $("#citiesList").val();
        }
        $("#citiesList").change(function () {
            var cityId = $("#citiesList").val();
//        getAllZones(cityId);
            $(".cityCurrency").text('(In ' + $('option:selected', this).attr('currency') + ')');
            $("#storeList").multiselect('destroy');
            var cityIdForNonFranchiseStore = $("#citiesList").val();
        });
        $("#citiesList2").change(function () {
            var cityId = $("#citiesList2").val();
            $("#catList").multiselect('destroy');
            $("#catList2").multiselect('destroy');
            getAllCategoryByCityId(cityId);
        })

        $('#maxusage').one('focus', function () {
            this.value = '';
        });
//        $('#perUserLimit').one('focus', function () {
//            this.value = '';
//        });
        $('#tripCount').one('focus', function () {
            this.value = '';
        });
        $('#adminLiability').one('focus', function () {
            this.value = '';
        });
        $('#storeLiability').one('focus', function () {
            this.value = '';
        });
// Admin liability
        $("#adminLiability").keyup(function () {
            $("#storeLiability").val('');
            if ($("#adminLiability").val().length === 0) {
                return;
            }
            var val = parseInt(this.value);
            if (val > 100) {
                alert("Liability percentage should be less than or equal to 100 %");
                $("#storeLiability").val('');
                return;
            }
            var fill = 100 - val;
            $("#storeLiability").val(fill);
        });
// Store Liability
        $("#storeLiability").keyup(function () {
            $("#adminLiability").val('');
            if ($("#storeLiability").val().length === 0) {
                return;
            }
            var val = parseInt(this.value);
            if (val > 100) {
                alert("Liability percentage should be less than or equal to 100 %");
                $("#adminLiability").val('');
                return;
            }
            var fill = 100 - val;
            $("#adminLiability").val(fill);
        });
        // Auto Fill store liability on typing in admin liability



        //Auto fill admin liability on typing in store liability



        // on city change


        $('input[type=radio][name=referrerRewardType]').change(function () {
            if (this.value == "1")
            {
                $(".catData").addClass('hide');
            } else {
                $(".catData").removeClass('hide');
            }
        })

        $('input[type=radio][name=newUserRewardType]').change(function () {
            if (this.value == "1")
            {
                $(".catData1").addClass('hide');
            } else {
                $(".catData1").removeClass('hide');
            }
        })
        $('#collapseOneancher').click();
//        CKEDITOR.replace('editor1');

        $('#selectedcityNew').html($('#selectedcity').html());
        // Referrer discount field change

        $("input[name=referrerRewardType]").click(function (event) {
            event.stopPropagation();
        });
        $("input[name=newUserRewardType]").click(function (event) {
            event.stopPropagation();
        });
        // New user discount field change

        $("input[name=newUserDiscountType]").click(function (event) {
            event.stopPropagation();
        });
        $("input[type=checkbox]").click(function (event) {
            event.stopPropagation();
        });
        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });
        $('#xridesselected').click(function () {
            $('.chekcRideType').html("NUMBER OF RIDES");
            $("#xrideUnit").css({'display': 'block'});
            $("#xrideUnit").val(1);
        });
        $('#General').click(function () {
            // $('.chekcRideType').html("N/A");
            $("#xrideUnit").css({'display': 'none'});
            $("#xrideUnit").val(0);
        });
// Change the field for referrer percentage value

        $('#referrerPercentageValue').click(function () {
            $('.amountLabel').html('PERCENTAGE');
            $("#cityCurrency").addClass('hide');
            $('.maxDiscount').show();
            $(".forPercentage").removeClass('hide');
        });
// Change the field for referrer fixed value
        $('#referrerFixedValue').click(function () {
            $("#cityCurrency").removeClass('hide');
            $('.amountLabel').html('AMOUNT');
            $('.maxDiscount').hide();
            $(".forPercentage").addClass('hide');
        });
// Change the field for new user percentage value

        $('#newUserPercentageValue').click(function () {
            $('.newUserAmountLable').html('PERCENTAGE');
            $("#newUserCityCurrency").addClass('hide');
            $('.newUserMaxDiscount').show();
            $(".newUserForPercentage").removeClass('hide');
        });
// Change the field for new user fixed value
        $('#newUserFixedValue').click(function () {
            $("#newUserCityCurrency").removeClass('hide');
            $('.newUserAmountLable').html('AMOUNT');
            $('.newUserMaxDiscount').hide();
            $(".newUserForPercentage").addClass('hide');
        });
//        $("#datepicker1").datepicker({ minDate: 0});
        var date = new Date();
        $('.datepicker-component').datepicker({
            startDate: date,
            format: 'dd-mm-yyyy'
        });

        $('#tripCount').keyup(function () {
            if (parseInt($(this).val()) == 0) {
                $('#offerAvailImmediateRefUser').attr('checked', true);
                $('#offerAvailImmediateRefUser').attr('disabled', true);
                $('#offerAvailImmediateNewUser').attr('checked', true);
                $('#offerAvailImmediateNewUser').attr('disabled', true);
            } else {
//                        $('#offerAvailImmediateRefUser').attr('checked', false);
                $('#offerAvailImmediateRefUser').attr('disabled', false);
//                        $('#offerAvailImmediateNewUser').attr('checked', false);
                $('#offerAvailImmediateNewUser').attr('disabled', false);
            }
        });
        $('#newUserBillingAmountTrigger').keyup(function () {
            if (parseInt($(this).val()) == 0) {
                $('#offerAvailImmediateRefUser').attr('checked', true);
                $('#offerAvailImmediateRefUser').attr('disabled', true);
                $('#offerAvailImmediateNewUser').attr('checked', true);
                $('#offerAvailImmediateNewUser').attr('disabled', true);
            } else {
//                        $('#offerAvailImmediateRefUser').attr('checked', false);
                $('#offerAvailImmediateRefUser').attr('disabled', false);
//                        $('#offerAvailImmediateNewUser').attr('checked', false);
                $('#offerAvailImmediateNewUser').attr('disabled', false);
            }
        })

//         $('.postAOffer').click(function () {
//             if (checkAllFields() == true) {

//                 var description = CKEDITOR.instances.description.getData();
//                 var termsAndConditions = CKEDITOR.instances.termscond.getData();
//                 var howItWorks = CKEDITOR.instances.howItWorks.getData();
//                 var discountType = parseInt($('input[name=secondblockrefferalDiscount]:checked').val());
//                 if (discountType == 1) {
//                     var discountData = {
//                         "typeId": 1,
//                         "typeName": "fixedValue",
//                         "value": parseFloat($("#amount").val())
//                     }
//                 } else {
//                     var discountData = {
//                         "typeId": 2,
//                         "typeName": "percentage",
//                         "value": parseFloat($("#amount").val()),
//                         "maximumDiscountValue": parseFloat($('#maxDiscount').val())
//                     }
//                 }

//                 var startTime = '"' + $("#startDate").val() + ' ' + $("#starttime").val() + ':00"';
//                 var endTime = '"' + $("#EndDate").val() + ' ' + $("#endtime").val() + ':00"';


//                 var parsedStartDate = moment(startTime, 'DD-MM-YYYY H:mm:ss');
//                 var parsedEndDate = moment(endTime, 'DD-MM-YYYY H:mm:ss');

//                 console.log('startData0', parsedStartDate);
//                 console.log('startData1', parsedEndDate);
//                 // var parsedStartDate = moment(startTime, 'DD-MM-YYYY H:mm:ss');
//                 // var parsedEndDate = moment(endTime, 'DD-MM-YYYY H:mm:ss');

// //    var parsedStartDate = new Date(date);
// //    var parsedEndDate = new Date(date);
//                 var cityDetails = [];
//                 var catDetails = [];
//                 var catDetails2 = [];

// //    $("#citiesList option:selected").each(function () {
// //    var $this = $(this);
// //    if ($this.length) {
// //    var selText = $this.text();
// //    var selVal = $this.val();
// //    var cityDetail = {
// //    cityId: selVal,
// //            cityName: selText
// //    }
// //    cityDetails.push(cityDetail);
// //    }
// //    });

//                 var cityIdd = $("#citiesList2").find("option:selected").text();
//                 var cityNamee = $("#citiesList2").find("option:selected").prop("value");

//                 console.log('cityid is', cityIdd);
//                 console.log('cityname is', cityNamee);
//                 var cityDetail = {
//                     cityId: cityNamee,
//                     cityName: cityIdd
//                 }
//                 cityDetails.push(cityDetail);


//                 console.log('4');
//                 $("#catList option:selected").each(function () {
//                     var $this = $(this);
//                     if ($this.length) {
//                         var selText = $this.text();
//                         var selVal = $this.val();

//                         var catDetail = {
//                             catId: selVal,
//                             catName: selText
//                         }
//                         catDetails.push(catDetail);
//                     }
//                 });

//                 $("#catList2 option:selected").each(function () {
//                     var $this = $(this);
//                     if ($this.length) {
//                         var selText = $this.text();
//                         var selVal = $this.val();

//                         var catDetail = {
//                             catId: selVal,
//                             catName: selText
//                         }
//                         catDetails2.push(catDetail);
//                     }
//                 });



//                 var dataToInsert = JSON.stringify({
//                     "title": $("#titile").val(),
//                     "offerAvailImmediateRefUser": ($('#offerAvailImmediateRefUser').is(':checked')) ? true : false,
//                     "offerAvailImmediateNewUser": ($('#offerAvailImmediateNewUser').is(':checked')) ? true : false,
//                     "cities": cityDetails,
//                     'currencySymbol': $("#citiesList2").find(':selected').attr('currencySymbol'),
//                     'currency': $("#citiesList2").find(':selected').attr('currency'),
//                     "newUserCategory": catDetails,
//                     "referralCategory": catDetails2,
//                     "zones": "string",
//                     "rewardType": 0,
//                     "paymentMethod": 0,
//                     "startTime": parsedStartDate,
//                     "endTime": parsedEndDate,
//                     "referrerlRewardType": $('input[name=referrerRewardType]:checked').val(),
//                     "referrerlDiscountType": $('input[name=referralDiscountValue]:checked').val(),
//                     "referrerlDiscountAmt": $("#referralAmount").val(),
//                     "referrerMaxDiscount": parseInt($("#referrerMaxDiscount").val()),

//                     "referrerWalletCreditAmount": 0,
//                     "newUserRewardType": $('input[name=newUserRewardType]:checked').val(),
//                     "newUserDiscountType": $('input[name=newUserDiscountType]:checked').val(),
//                     "newUserDiscountAmt": $("#newUserDiscountAmount").val(),
//                     "newUserMaxDiscount": parseInt($("#newUserMaxDiscount").val()),
//                     "newUserWalletCreditAmount": 0,
//                     "perUserLimit": 0,
//                     "rewardTriggerType": parseInt($('input[name=rewardTriggerType]:checked').val()),
//                     "tripCount": $("#tripCount").val(),
//                     "newUserBillingAmtTrigger": $("#newUserBillingAmountTrigger").val(),
//                     "description": description,
//                     "termsConditions": termsAndConditions,
//                     "howITWorks": howItWorks,
//                 });
//                 // update in database
//                 console.log(dataToInsert);
// //                return false;
//                 $.ajax({
//                     url: "<?php echo APILink ?>" + 'addReferralCampaign',
//                     type: "POST",
//                     dataType: "JSON",
//                     contentType: "application/json; charset=utf-8",
//                     data: dataToInsert,
//                 }).done(function (json) {
//                     if (json.message == "Success") {
//                         window.location.href = "<?php echo base_url() ?>index.php?/referralController/index/1";
//                         // console.log('true');

//                     } else {
//                         alert('Unable to add Offer! Please try agian');
//                     }
//                 });
//             }


//             //end of trigger handaling 

//         });

        $('.postAOffer').click(function () {
            if(checkAllFields() == true){

            var description         = CKEDITOR.instances.description.getData();
            var termsAndConditions  = CKEDITOR.instances.termscond.getData();
            var howItWorks          = CKEDITOR.instances.howItWorks.getData();

            var discountType = parseInt($('input[name=secondblockrefferalDiscount]:checked').val());
            if (discountType == 1) {
                var discountData = {
                    "typeId": 1,
                    "typeName": "fixedValue",
                    "value" : parseFloat($("#amount").val())
                }
            }else{
                var discountData = {
                    "typeId": 2,
                    "typeName": "percentage",
                    "value" : parseFloat($("#amount").val()),
                    "maximumDiscountValue": parseFloat($('#maxDiscount').val())
                }
            }

            var startTime   =  '"' + $("#startDate").val() + ' ' + $("#starttime").val() + ':00"';
            var endTime     =  '"' + $("#EndDate").val() + ' ' + $("#endtime").val() + ':00"';

           


            var parsedStartDate = moment(startTime, 'DD-MM-YYYY H:mm:ss');
            var parsedEndDate = moment(endTime, 'DD-MM-YYYY H:mm:ss');

           var cityDetails = [];
            $("#citiesList option:selected").each(function () {
               var $this = $(this);
               if ($this.length) {
                var selText = $this.text();
                var selVal = $this.val();

                 var cityDetail = {
                        cityId: selVal,
                        cityName: selText 
                    }
                    cityDetails.push(cityDetail);
               }
            });

            //console.log(cityDetails);

            var dataToInsert = JSON.stringify({
                                "title": $("#titile").val(),
                                "cities": cityDetails,
                                "zones": "string",                                
                                "rewardType": 0,
                                "paymentMethod": 0,                              
                                "startTime": parsedStartDate,
                                 "endTime": parsedEndDate,
                                "referrerlRewardType": $('input[name=referrerRewardType]:checked').val(),
                                "referrerlDiscountType": $('input[name=referralDiscountValue]:checked').val(),
                                "referrerlDiscountAmt": $("#referralAmount").val(),
                                "referrerWalletCreditAmount": 0,
                                "newUserRewardType": $('input[name=newUserRewardType]:checked').val(),
                                "newUserDiscountType": $('input[name=newUserDiscountType]:checked').val(),
                                "newUserDiscountAmt": $("#newUserDiscountAmount").val(),
                                "newUserWalletCreditAmount": 0,
                                "tripCount": $("#tripCount").val(),
                                "newUserBillingAmtTrigger": $("#newUserBillingAmountTrigger").val(),
                                "description": description,
                                "termsConditions": termsAndConditions,
                                "howITWorks": howItWorks,
                                "perUserLimit": 0,
                                "rewardTriggerType": parseInt($('input[name=rewardTriggerType]:checked').val()),

                                "offerAvailImmediateRefUser": ($('#offerAvailImmediateRefUser').is(':checked')) ? true : false,
                                "offerAvailImmediateNewUser": ($('#offerAvailImmediateNewUser').is(':checked')) ? true : false,
                                "referrerMaxDiscount": parseInt($("#referrerMaxDiscount").val()),
                                "referrerWalletCreditAmount": 0,
                                "newUserMaxDiscount": parseInt($("#newUserMaxDiscount").val()),
                                'currency':'',
                                'currencySymbol':'',
                                "newUserCategory": '',
                                "campaignType" : "11",
                                "referrerlDriverDiscountAmt" : 0,
                                "newUserDriverDiscountAmt" :0



                               
            });
                // update in database

                $.ajax({
                    url: "<?php echo APILink ?>" + 'addReferralCampaign',
                    type: "POST",
                    dataType: "JSON",
                    contentType: "application/json; charset=utf-8",
                    data: dataToInsert,
                    }).done(function(json,textStatus,xhr) {
                        console.log('res---',json);
                        if (xhr.status == 200) {
                            window.location.href = "<?php echo base_url() ?>index.php?/referralController/index/1";
                            // console.log('true');

                        }else{
                            alert('Unable to add Offer! Please try agian');
                        }
                });

            }

          
                //end of trigger handaling 

        });


        function alertMessage(message) {
            swal({
                title: message,
                timer: 2000,
                showConfirmButton: false
            });
        }


        function notificationbar(message) {
            var position = $('.tab-pane.active .position.active').attr('data-placement');
            $('body').pgNotification({
                style: 'bar',
                message: message,
                position: "top",
                timeout: 10000,
                type: 'Info'
            }).show();
        }

        function onlysmallalphadigit(evt, len, txtid)
        {
            var val = $(txtid).val();
            var key = evt.charCode || evt.keyCode || 0;
            if ((key >= 97 && key <= 122) || (key >= 65 && key <= 90) ||
                    (key >= 48 && key <= 57)) {
                return true;
            } else {
                return false;
            }
        }
    });</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20"><br/>
                <div class="inner" style="">
                    <!-- START BREADCRUMB -->
                    <ul class="breadcrumb" style="">
                        <li>

                        <li class="breadClass"><a href="index.php?/referralController/index/1" class="active">REFERRAL CAMPAIGN</a>&nbsp>&nbsp<a href="#" style="color: #0090d9 !important; font-size: 11px !important">ADD</a>
                        </li>
                        <p class="pull-right cls110">
                            <button class="btn btn-primary btn-cons m-b-10 postAOffer texttop submitButtonCss" type="button" >
                                <i class="pg-form" style="color: #ffffff;"></i> 
                                <span class="bold" style="color: #ffffff;">Submit</span>
                            </button>
                        </p>
                    </ul>
                    <!-- END BREADCRUMB -->
                </div>



                <div class="panel panel-group panel-transparent"  id="accordion">
                    <div class="panel panel-primary">
                        <div class="panel-heading padding" data-parent="#accordion" data-toggle="collapse" href="#collapseOne">
                            <h4 class="panel-title">
                                <a class="collapsed"  id="collapseOneancher">
                                    REFERRAL CAMPAIGN SETTING
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse " id="collapseOne" style="height: 0px;">
                            <div class="panel-body">
                                <!-- GENERAL SETTING TAB START  -->
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <p class="fontSize marginTop">GENERAL SETTING :</p>
                                </div>
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6">
                                        <div class="form-group col-xs-12 removePadding">
                                            <label for="fname" class="col-sm-3 control-label aligntext">TITLE<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="" id="titile">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class=" col-sm-3 error-box" id="offerTitleError"></div>
                                </div>




                                <!--  <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                     <div class="col-sm-6 form-group">
                                         <div class="form-group removePadding">
                                             <label for="fname" class="col-sm-3 control-label aligntext">CODE </label>
                                             <div class="col-sm-7">
                                                 <input type="text" class="form-control" id="Promocode"  placeholder="eg. xyz" required="" aria-required="true" 
                                                        onkeypress="return onlysmallalphadigit(event, this)"
                                                        onblur=""
                                                        data = "1"
                                                        >
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-sm-3 error-box" id="promoCodeError"></div>
 
                                 </div> -->

                               
                          <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 citiesData" >
                                    <div class="col-sm-6 form-group">
                                        <label for="fname" class="col-sm-3 control-label aligntext">CITIES <span class="mandatoryField"> &nbsp *</span></label> 
                                        <div class="col-sm-7">
                                            <select id="citiesList" name="company_select" class="form-control" style="width: 55% !important">
                                                
                                            </select>
                                        </div>
                                        <div class="col-sm-3 error-box" id="citiesError"></div>
                                    </div>

                                </div>
                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 hide zonesData">
                                    <div class="col-sm-6 form-group">

                                        <label for="fname" class="col-sm-3 control-label aligntext">ZONES <span class="mandatoryField"> &nbsp *</span></label> 
                                        <div class="col-sm-7">
                                            <select id="zonesList" name="company_select" class="form-control" style="width: 100% !important">
                                                <option disabled selected value> None Selected</option>
                                            </select>
                                        </div>

                                    </div>
                                    <!--<div class="col-sm-3 error-box" id="citiesError"></div>-->
                                </div>

                                <!-- Reward type -->

                                <!-- Reward type end -->

                                <!-- GENERAL SETTING TAB END -->


                                <!-- CONDITIONS TAB START -->
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <p class="fontSize marginTop">CONDITIONS :</p>
                                </div>

                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">

                                    <div class="col-sm-3 error-box" id="tripCountError"></div>

                                </div>


                                <!-- Per user limit -->
                                <!--                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10" style="padding-bottom: 15px">
                                                                    <div class="col-sm-12 removePadding">
                                                                        <div class="form-group ">
                                                                            <label class="col-sm-2 control-label aligntext1">PER USER USAGE LIMIT<span class="mandatoryField"> &nbsp *</span></label>
                                                                            <div class="col-sm-3">
                                                                                <input type="text" id='perUserLimit' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left;" >
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-3 error-box" id="globalLimitError"></div>
                                                                </div>-->

                                <!-- Trip count -->


                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                    <div class="col-sm-12 removePadding form-group">

                                        <label class="col-sm-2 control-label aligntext">START DATE <span class="mandatoryField"> &nbsp *</span></label>
                                        <div class="col-sm-4">
                                            <div id="datepicker-component" class="input-group date col-sm-6 pull-left" >
                                                <input type="text" class="form-control datepicker-component" id="startDate"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <div class="col-sm-4 bootstrap-timepicker">
                                                <input type="text" name="timepicker" class="form-control timepicker" id="starttime"/>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="startDateError"></div>

                                </div>
                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                    <div class="col-sm-12 removePadding form-group">

                                        <label class="col-sm-2 control-label aligntext">END DATE <span class="mandatoryField"> &nbsp *</span></label>
                                        <div class="col-sm-4">
                                            <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                <input type="text" class="form-control datepicker-component" id="EndDate"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <div class="col-sm-4 bootstrap-timepicker">
                                                <input type="text" name="timepicker" class="form-control timepicker" id="endtime"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="endDateError"></div>

                                </div>
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-12 removePadding">
                                        <div class="form-group col-xs-12 ">
                                            <label for="fname" class="col-sm-2 control-label aligntext" style="padding: 0px !important">REWARD TYPE TRIGGER<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-6 removePadding">
                                                <div class="radio radio-success">
                                                    <input class = "marginLeft" type="radio" checked="checked" value="1" name="rewardTriggerType" id="newUserTripCountTrigger">
                                                    <label onclick="calltrigger('newUserTripCountTrigger')">BOOOKING COUNT</label>
                                                    <input class= "marginLeft" type="radio"  value="2" name="rewardTriggerType" id="newUserTotalBusinessTrigger">
                                                    <label onclick="calltrigger('newUserTotalBusinessTrigger')">TOTAL BUSINESS</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 hide requiredBillingAmount">
                                    <div class="col-sm-12 removePadding">
                                        <div class="form-group  col-xs-12 ">
                                            <label for="fname" class="col-sm-2 control-label aligntext" style="margin-left: -1%; margin-right: 1%;">TOTAL BILLING AMOUNT REQUIRED</label>
                                            <div class="col-sm-3 removePadding">
                                                <input type="text" class="addmemclass1 form-control" id="newUserBillingAmountTrigger"  placeholder=""   required="" aria-required="true" onkeypress="return event.charCode >= 48 && event.charCode <= 57">                                                                                            
                                                <span class="cityCurrency"  id="cityCurrency" style="font-size: 18px; margin-left: 10px; margin-top: -34px; margin-right: -48px;"></span>
                                                <!-- <span class="" id="cityCurrency" style="font-size: small"></span> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="amountError"></div>
                                </div>

                                <!-- Trip count -->
                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 tripCountTrigger" style="padding-bottom: 15px">
                                    <div class="col-sm-12 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-2 control-label aligntext1">BOOKING COUNT<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" id='tripCount' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="" onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="width: 90%; float: left;" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="globalLimitError"></div>
                                </div>
                                <!-- Trip count end here -->


                                <!-- PAYMENT METHOD TAB END -->

                                <!-- Discount type start -->
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <p class="fontSize marginTop">DISCOUNT DETAILS :</p>
                                </div>
                                <div class="col-md-12">

                                    <div class="col-md-6">
                                        <p style="font-size: 15px; text-align: center; border-bottom: 2px solid; width: 85%;">REFERRER DISCOUNT</p>

                                        <div class="form-group">
                                            <label for="address" class="col-sm-3 control-label">OFFER IMMEDIATE AVAILABLE</label>
                                            <div class="col-sm-2" style="    padding-left: 22px;">

                                                <div class="switch">
                                                    <input id="offerAvailImmediateRefUser" name="offerAvailImmediateRefUser" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                    <label for="offerAvailImmediateRefUser"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                            <div class="col-sm-12 removePadding">
                                                <div class="form-group ">
                                                    <label class="col-sm-3 control-label aligntext">REWARD TYPE <span class="mandatoryField"> &nbsp *</span></label>
                                                    <div class="col-sm-9">
                                                        <div class="radio radio-success">
                                                            <input class = "marginLeft" type="radio" checked="checked" value="1" name="referrerRewardType" id="referrerWalletCredit">
                                                            <label>Wallet Credit</label>
                                                            <!-- <input type="radio" class ="marginLeft"  value="2" name="referrerRewardType" id="referrerCouponDelivery">
                                                            <label>Coupon Delivery</label> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="error-box" id="paymentMethodError"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 hide catData">
                                            <div class="col-sm-12 removePadding">
                                                <div class="form-group ">
                                                    <label class="col-sm-3 control-label aligntext">Category <span class="mandatoryField"> &nbsp *</span></label>
                                                    <div class="col-sm-9">
                                                        <select id="catList2" name="company_select" class="form-control" style="width: 55% !important" multiple="multiple"></select>
                                                    </div>
                                                </div>
                                                <div class="error-box" id="catList2Err"></div>
                                            </div>
                                        </div>



                                        <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                            <div class="col-sm-12 removePadding">
                                                <div class="form-group col-xs-12 ">
                                                    <label for="fname" class="col-sm-3 control-label aligntext" style="padding: 0px !important">DISCOUNT TYPE <span class="mandatoryField"> &nbsp *</span></label>
                                                    <div class="col-sm-7 ">
                                                        <div class="">
                                                            <input class = "marginLeft" type="radio" checked="checked" value="1" name="referralDiscountValue" id="referrerFixedValue">
                                                            <label onclick="calltrigger('referrerFixedValue')">FIXED</label>
                                                            <input class= "marginLeft" type="radio"  value="2" name="referralDiscountValue" id="referrerPercentageValue">
                                                            <label onclick="calltrigger('referrerPercentageValue')">PERCENTAGE</label>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                            <div class="col-sm-12 removePadding">
                                                <div class="form-group  col-xs-12 ">
                                                    <label for="fname" class="col-sm-3 control-label referrerAmountLabel aligntext" style="margin-left: 3%; margin-right: -4%;">AMOUNT</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="addmemclass1 form-control" id="referralAmount"  placeholder=""   required="" aria-required="true" onkeypress="return isNumberKey(event, 'amount')">                                                                                            
                                                        <span class="percentageSpan cityCurrency"  id="cityCurrency" style="font-size: 18px; margin-left: 10px; margin-top: -34px; margin-right: -38px;"></span>
                                                        <!-- <span class="" id="cityCurrency" style="font-size: small"></span> -->
                                                        <span class= "forPercentage hide percentageSpan" style="font-size: 18px; margin-left: 10px; right:11px; top:0"> % </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 error-box" id="amountError"></div>
                                        </div>

                                        <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                            <div class="col-sm-12" style="padding-bottom: 15px">
                                                <div class="form-group referrerMaxDiscount" style="display:none">
                                                    <label for="fname" class="col-sm-3 control-label aligntext removePadding">MAX DISCOUNT<span class="mandatoryField"> &nbsp *</span></label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="addmemclass1 form-control" id="referrerMaxDiscount" placeholder="Amount" value="0"   required="" aria-required="true" onkeypress="return isNumberKey(event, 'amountFirstBlock')" style="margin-left:-2%">                                                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 error-box" id="maxDiscountError"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="font-size: 15px; text-align: center; border-bottom: 2px solid; width: 85%;">NEW USER DISCOUNT</p>
                                        <div class="form-group">
                                            <label for="address" class="col-sm-3 control-label">OFFER IMMEDIATE AVAILABLE</label>
                                            <div class="col-sm-2" style="    padding-left: 22px;">

                                                <div class="switch">
                                                    <input id="offerAvailImmediateNewUser" name="offerAvailImmediateNewUser" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                    <label for="offerAvailImmediateNewUser"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                            <div class="col-sm-12 removePadding">
                                                <div class="form-group ">
                                                    <label class="col-sm-3 control-label aligntext">REWARD TYPE <span class="mandatoryField"> &nbsp *</span></label>
                                                    <div class="col-sm-9">
                                                        <div class="radio radio-success">
                                                            <input class = "marginLeft" type="radio"  value="1" name="newUserRewardType" id="newUserWalletCredit" checked="checked">
                                                            <label>Wallet Credit</label>
                                                            <!-- <input  class ="marginLeft" type="radio"  value="2" name="newUserRewardType" id="newUserCouponDelivery">
                                                            <label>Coupon Delivery</label> -->
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="error-box" id="paymentMethodError"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 hide catData1">
                                            <div class="col-sm-12 removePadding">
                                                <div class="form-group ">
                                                    <label class="col-sm-3 control-label aligntext">Category <span class="mandatoryField"> &nbsp *</span></label>
                                                    <div class="col-sm-9">
                                                        <select id="catList" name="company_select" class="form-control" style="width: 55% !important" multiple="multiple"></select>
                                                    </div>
                                                </div>
                                                <div class="error-box" id="catListErr"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                            <div class="col-sm-12 removePadding">
                                                <div class="form-group col-xs-12 ">
                                                    <label for="fname" class="col-sm-3 control-label aligntext" style="padding: 0px !important">DISCOUNT TYPE <span class="mandatoryField"> &nbsp *</span></label>
                                                    <div class="col-sm-7 ">
                                                        <div class="radio radio-success">
                                                            <input class = "marginLeft" type="radio" checked="checked" value="1" name="newUserDiscountType" id="newUserFixedValue">
                                                            <label onclick="calltrigger('newUserFixedValue')">FIXED</label>
                                                            <input class= "marginLeft" type="radio"  value="2" name="newUserDiscountType" id="newUserPercentageValue">
                                                            <label onclick="calltrigger('newUserPercentageValue')">PERCENTAGE</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                            <div class="col-sm-12 removePadding">
                                                <div class="form-group  col-xs-12 ">
                                                    <label for="fname" class="col-sm-3 control-label newUserAmountLable aligntext" style="margin-left: 3%; margin-right: -4%;">AMOUNT</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="addmemclass1 form-control" id="newUserDiscountAmount"  placeholder=""   required="" aria-required="true" onkeypress="return isNumberKey(event, 'amount')">                                                                                            
                                                        <span class="percentageSpan cityCurrency"  id="newUserCityCurrency" style="font-size: 18px; margin-left: 10px; margin-top: -34px; margin-right: -38px;"></span>
                                                        <!-- <span class="" id="cityCurrency" style="font-size: small"></span> -->
                                                        <span class= "newUserForPercentage hide percentageSpan" style="font-size: 18px; margin-left: 10px; right:11px; top:0"> % </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 error-box" id="amountError"></div>
                                        </div>

                                        <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                            <div class="col-sm-12" style="padding-bottom: 15px">
                                                <div class="form-group newUserMaxDiscount" style="display:none">
                                                    <label for="fname" class="col-sm-3 control-label aligntext removePadding">MAX DISCOUNT<span class="mandatoryField"> &nbsp *</span></label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="addmemclass1 form-control" id="newUserMaxDiscount" placeholder="Amount" value="0"   required="" aria-required="true" onkeypress="return isNumberKey(event, 'amountFirstBlock')" style="margin-left:-2%">                                                                                            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 error-box" id="maxDiscountError"></div>
                                        </div>

                                    </div>

                                </div>
                                <!-- usage -->

                                <!-- Discount details -->




                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading padding" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" >
                                    DESCRIPTION 
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseTwo" style="height: 0px;">
                            <div class="panel-body">
                                <div class="summernote-wrapper">
                                    <div id="summernote">

                                        <label>Term & Conditions<a target="_new" href="">Preview</a></label>

                                        <textarea name="description" id="description"></textarea>
                                        <script>
                                            CKEDITOR.replace('description');
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading padding" data-parent="#accordion" data-toggle="collapse" href="#collapseThree">
                            <h4 class="panel-title">
                                <a class="collapsed" >
                                    TERM & CONDITIONS 
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseThree" style="height: 0px;">
                            <div class="panel-body">
                                <div class="summernote-wrapper">
                                    <div id="summernote">

                                        <label>Term & Conditions<a target="_new" href="">Preview</a></label>

                                        <textarea name="termscond" id="termscond"></textarea>
                                        <script>
                                            CKEDITOR.replace('termscond');
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="panel panel-primary">
                        <div class="panel-heading padding" data-parent="#accordion" data-toggle="collapse" href="#collapseFour">
                            <h4 class="panel-title">
                                <a class="collapsed" >
                                    HOW IT WORKS 
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseFour" style="height: 0px;">
                            <div class="panel-body">
                                <div class="summernote-wrapper">
                                    <div id="summernote">

                                        <label>How it works<a target="_new" href="">Preview</a></label>

                                        <textarea name="howItWorks" id="howItWorks"></textarea>
                                        <script>
                                            CKEDITOR.replace('howItWorks');
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
</div>
<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>supportFiles/wickedpicker.css">
<script src="<?php echo base_url() ?>supportFiles/wickedpicker.js"></script>
<script>
//function changeButton(e){
//console.log(e);
//}
//
//$("#newUserCouponDelivery").click(function(){
//    alert();
//})
</script>
