<?php
$option = '<option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option>
<option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
<option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="23.59">23.59</option>';
$actionFor = 1;
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
      font-size: 12px;
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
    margin-top: 0px;
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


.currencyCss{
    position: absolute;
    right: 48px;
    background: gainsboro;
    height: 33px;
    display: inline-block;
    padding: 0px 6px;
    font-size: 18px;
    margin-top: -34px;
    margin-right: -38px;
}


.percentageCss{
    position: absolute;
    right: 54px;
    background: gainsboro;
    height: 32px;
    display: inline-block;
    padding: 0px 6px;
    font-size: 18px;
    margin-top: -33px;
    margin-right: -38px;
}
/*.submitButton{
    margin-top: 272px;
    / margin-right: 55px; /
    display: fixed;
    position: fixed;
    right: 17px;
}*/
.submitButtonCss{
    position: fixed;
    right: 20px;
    bottom: 0;
    z-index: 1000000;

}
.checkbox input[type="checkbox"] {
    left: 25px;
    margin: 0;
}
.multiselect-search{
    width: 270% !important;
}
.multiselect-clear-filter{
    
    display: none;
}
 $('#starttime').datetimepicker({
        use24hours: true
    });
</style>
<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script src="<?php echo base_url() ?>supportFiles/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>supportFiles/sweetalert.css">
<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>supportFiles/waitMe.css">
<script src="<?php echo base_url() ?>supportFiles/waitMe.js"></script>
<!--date time picker-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<!--date time picker end-->
<script type="text/javascript">
         $(function () {
             $('#starttime,#stime,#endtime,#etime').datetimepicker({
             format : 'HH:mm:'
             });
             });
    </script> 
<script>

// none, bounce, rotateplane, stretch, orbit, 
// roundBounce, win8, win8_linear or ios
//        var current_effect = 'bounce'; // 


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
                url: "<?php echo APILink ?>" + "admin/city",
                type: 'GET',
                dataType: 'json',
                headers: {
                  language: 0
                },
                data: {                  
                },
            }).done(function(json) {

                console.log('city currency',json);
                
                $("#citiesList").html('');
                
                 for (var i = 0; i< json.data.length; i++) {
               
                    var citiesList = "<option value='"+ json.data[i].id +"'   currency='"+ json.data[i].currency + "'>"+  json.data[i].cityName +"</option>";
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
     
     //functio to get all store based in city cool
         $(document).on('change', '#citiesList', function () {
            
             var cityId = $(this).val();
             var valCity = [];
             $(':checkbox:checked').each(function(i){
                valCity[i] = $(this).val();
             });
           
               $.ajax({
                url: "<?php echo base_url('index.php?/CouponCode') ?>/getStoreData",
                type: 'POST',
                dataType: 'json',
                data: {
                    val: valCity
                },             
                
            }).done(function(json) {
               
                
                $("#storeList").html('');
                
                 for (var i = 0; i< json.data.length; i++) {
               
                    var storeList = "<option value='"+ json.data[i].id +"'>"+  json.data[i].title +"</option>";
                    $("#storeList").append(storeList);  
                }
                  $('#storeList').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering : true,
                    buttonWidth: '100%',
                    maxHeight: 300,
                });
        });



         });
// Function to get all zones
    // function getAllZones(cityIds){
    //     $.ajax({
    //             url: "<?php echo APILink ?>" + "zones/" + cityIds,
    //             type: 'GET',
    //             dataType: 'json',
    //             data: {                  
    //             },
    //         }).done(function(json) {
    //             if (json.data.length == 0) {
    //                 $(".zonesData").addClass('hide');
    //             }else{
    //             $(".zonesData").removeClass('hide');
    //             $("#zonesList").html('');
    //             $("#zonesList").append("<option disabled selected value> None Selected</option>");    
    //              for (var i = 0; i< json.data.length; i++) {
                
    //                 var zonesList = "<option value="+ json.data[i]._id + ">"+  json.data[i].title +"</option>";
    //                 $("#zonesList").append(zonesList);  
    //             }                    
    //             }
    //     });
    // }
// Function to get all product categories
// Check all the fields has been filled or not
     function validateOfferFields(){
        var isFilled = true;
        if ($("#titile").val().length == 0) {
            var isFilled = false;
            $("#offerTitleError").text("Please enter offer title");
        }
        if ($("#Promocode").val().length == 0) {
            var isFilled = false;
            $("#promoCodeError").text("Please enter promo code");
        }
        // if ($("#tripCount").val().length == 0) {
        //     var isFilled = false;
        //     $("#tripCountError").text("Please enter trip count");

        // }
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


        var now = new Date();
        var currentHours = now.getHours();
        var currentMinutes = now.getMinutes();
        var startTimeHourMinute = $("#starttime").val().split(":");
        var endTimeHourMinute = $("#endtime").val().split(":");
        
        
        // Title validation
        if ($("#titile").val().length == 0) {
            isFilled = false;
            $("#offerTitleError").text('Please enter the title');
        }else{
            $("#offerTitleError").text('');
        }

      // Code validation
        if ($("#Promocode").val().length == 0) {
            isFilled = false;
            $("#promoCodeError").text('Please enter the promo code');
        }else{
            $("#promoCodeError").text('');
        }

        // City check error
        if ($("#citiesList").val() == null) {
            isFilled = false;
            $("#citiesError").text('Please select city from the list');
        }else{
            $("#citiesError").text('');
        }

        if ($("#maxusage").val() == "0" || $("#maxusage").val().length=== 0) {
            isFilled = false;
            $("#maxiUsageError").text('Please enter maximum gloabl usage');
        }else{
            $("#maxiUsageError").text('');
        }


        if ($("#perUserLimit").val().length == 0 || $("#perUserLimit").val() === "0") {
            isFilled = false;
            $("#perUserLimitError").text('Please enter store liability');
        }else{
            $("#perUserLimitError").text('');
        }

     
        

        if ($("#maxusage").val().length == 0  || $("#maxusage").val() === "0") {
            isFilled = false;
            $("#maxusageError").text('Please enter admin liability');
        }else{
            $("#maxusageError").text('');
        }

        var maxusage=parseInt($('#maxusage').val());
        var perUserLimit=parseInt($('#perUserLimit').val());
        if(maxusage<perUserLimit){
            $("#maxperUserLimitError").show();
             $("#maxperUserLimitError").text('Maximum global usage must be less than per usage limit');
        }else if(maxusage>perUserLimit){           
            $("#maxperUserLimitError").hide();
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
        

      
    //   validate date accordingly
        if ($("#startDate").val().length == 0  ) {
            
            isFilled = false;
            $("#startDateError").text('Please select start date');
        }else{
            
            //     if(stdate>fDate){
            //         console.log('start date greate than current data');
            //     $("#startDateError").text('');
            // }else{
            //     console.log('enterd date is lesse');
            //     if(startTimeHourMinute[0] < currentHours ){
            //            isFilled = false;
            //          $("#startDateError").text('Please select hour greater than current hour');
            //          if(startTimeHourMinute[1] <= currentMinutes)
            //            {
            //                 isFilled = false;
            //                 $("#startDateError").text('Please select minutes greater than current minutes');
            //             }
            //             else{
            //                 $("#startDateError").text('');
            //             }
            //         }
            //         else{
            //             $("#startDateError").text('');
            //         }
            // } 

            $("#startDateError").text('');

        }

           if ($("#startDate").val().length == 0  ) {
                isFilled = false;
            $("#startDateError").text('Please select start date');
        }else{
            $("#startDateError").text('');
        }



        if ($("#EndDate").val().length == 0) {
            isFilled = false;
            $("#endDateError").text('Please select end date');
        }else{
            $("#endDateError").text('');
        }

        //start date end date validation
        if(startDate<endDate)
        {           
        }else{
            isFilled = false;
            $("#endDateError").text('End date must be greater than Start date');
            
        }
            


        if ($('input[name=xridesRadio]:checked').val().length == 0) {
            isFilled = false;
            $("#paymentMethodError").text('Please select the payment method');
        }else{
            $("#paymentMethodError").text('');
        }

         if ( $("#minimumPurchaseValue").val().length=== 0) {
            isFilled = false;
            $("#minimumPurchaseError").text('Please enter minimum purchase value');
        }else{
            $("#minimumPurchaseError").text('');
        }

          if ($("#amount").val() == "0" || $("#amount").val().length=== 0) {
            isFilled = false;
            $("#amountError").text('Please enter the amount');
        }else{
            $("#amountError").text('');
        }

        
       


        // if ($("#franchiseList").val() == null) {
        //     isFilled = false;
        //     $("#franchiseListError").text('Please select the franchise');
        // }
        // if ($("#storeList").val() == null) {
        //     isFilled = false;
        //     $("#franchiseListError").text('Please select the franchise');

        // }
        // if($('input[name=offerType]:checked').val().length == 0){
        //     isFilled = false;
        //     $("#offerTypeError").text('Please select the offer type');
        // }else{
        //     $("#offerTypeError").text('');
        // }

        if (isFilled) {
           
            
            return true;
           
        }else{
            document.getElementById('enableBtn').disabled = false; 
            return false;
           
        }
     }


    $(document).ready(function () {

        $('#amount').keypress(function(event) {
                if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
                        $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            }).on('paste', function(event) {
                event.preventDefault();
        });


    citiesList();
    
    if ($("#citiesList").val()) {
        var cityIdForNonFranchiseStore = $("#citiesList").val();
    }
    $("#citiesList").change(function(){
       
        var cityId = $("#citiesList").val();
      //  getAllZones(cityId);
       $('#cityCurrency').text($('#cityId option:selected').attr('currency'));
        $("#cityCurrency").text('(In ' +  $('option:selected', this).attr('currency') + ')'); 
        $("#cityCurrencyPerntage").text('(In ' +  $('option:selected', this).attr('currency') + ')');      
        $("#storeList").multiselect('destroy');
        var cityIdForNonFranchiseStore = $("#citiesList").val();
        
    });

    $('#maxusage').one('focus', function(){
        this.value = '';
    });
    $('#perUserLimit').one('focus', function(){
        this.value = '';
    });
    // $('#tripCount').one('focus', function(){
    //     this.value = '';
    // });
    $('#adminLiability').one('focus', function(){
        this.value = '';
    });
    $('#storeLiability').one('focus', function(){
        this.value = '';
    });
// Admin liability
     $("#adminLiability").keyup(function(){
        $("#storeLiability").val('');        
        if ($("#adminLiability").val().length === 0) {
            return;
        }
        var val = parseInt(this.value);
        if (val > 100) {
            alert("Liability percentage should be less than or equal to 100 %");
            $("#storeLiability").val('');
            $("#adminLiability").val('');
            return;
        }
        var fill = 100 - val;    
        $("#storeLiability").val(fill);
    });

// Store Liability
 $("#storeLiability").keyup(function(){
        $("#adminLiability").val('');        
        if ($("#storeLiability").val().length === 0) {
            return;
        }
        var val = parseInt(this.value);
        if (val > 100) {
            alert("Liability percentage should be less than or equal to 100 %");
            $("#adminLiability").val('');
            $("#storeLiability").val('');
            return;
        }
        var fill = 100 - val;    
        $("#adminLiability").val(fill);
    });
     // Auto Fill store liability on typing in admin liability
    // $("#maxusage").keyup(function(){
    // // Check if per user limit entered then global usage can not be less than per user limit
    //    var perUserLimit = $("#perUserLimit").val('');
    //    if (perUsreLimit.length == 0) {

    //    }else{

    //    }
    //     if ($("#maxusage").val().length === 0) {
    //         return;
    //     }
    //     var val = parseInt(this.value);
    //     if (val > 100) {
    //         alert("Liability percentage should be less than or equal to 100 %");
    //         $("#perUserLimit").val('');
    //         return;
    //     }
    //     var fill = 100 - val;    
        
    // });


    //Auto fill admin liability on typing in store liability
    
    // $("#perUserLimit").keyup(function(){
    // // Check if global usge limit entered then per user limit can not be more than global usaga 



    //    var maxUsage = parseInt($("#maxusage").val());
    //    if ($("#maxusage").val().length == 0) {
    //     return;
    //    }else{
    //     if ($("#perUserLimit").val().length === 0) {
    //         return;
    //     }
    //     var val = parseInt(this.value);
    //     if (val > maxUsage) {
    //         alert("Per user limit can not be greater than maximum global usage");
    //         $("#perUserLimit").val('');
    //         return;
    //     }
        
    //    }
        
    // });
        
      // on city change



        $('#collapseOneancher').click();

//        CKEDITOR.replace('editor1');

        $('#selectedcityNew').html($('#selectedcity').html());

        $("input[type=radio]").click(function (event) {
            event.stopPropagation();
        });
        $("input[type=checkbox]").click(function (event) {
            event.stopPropagation();
        });

        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });

        $('#xridesselected').click(function(){
          $('.chekcRideType').html("NUMBER OF RIDES");
            $("#xrideUnit").css({'display': 'block'});
            $("#xrideUnit").val(1);
        });
        $('#General').click(function(){
            // $('.chekcRideType').html("N/A");
            $("#xrideUnit").css({'display': 'none'});
            $("#xrideUnit").val(0);
        });
    $('#percentagesecondPromo').click(function(){
        $('.amountLabel').html('PERCENTAGE');
        $("#cityCurrency").addClass('hide');
        $('.maxDiscount').show(); 
        $(".forPercentage").removeClass('hide');

});
$('#Fixedsecondtpromo').click(function(){
    $("#cityCurrency").removeClass('hide');
    $('.amountLabel').html('AMOUNT');
            $('.maxDiscount').hide(); 
            $(".forPercentage").addClass('hide');
});

//        $("#datepicker1").datepicker({ minDate: 0});
        var date = new Date();
        $('.datepicker-component').datepicker({
            startDate: date,
            format: 'dd-mm-yyyy'
        });
        $('#endDataAddOn').datepicker({
            startDate: date,
            format: 'dd-mm-yyyy'
        });
        $('#startDateAddOn').datepicker({
            startDate: date,
            format: 'dd-mm-yyyy'
        });

        $('.postAOffer').click(function () {

            var description         = (CKEDITOR.instances.description.getData()).trim();
            var termsAndConditions  = (CKEDITOR.instances.termscond.getData()).trim();
            var howItWorks          = (CKEDITOR.instances.howItWorks.getData()).trim();
            if(checkAllFields() == true){
                $(".postAOffer").addClass("disabled");
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

            // "29-01-2018"
            var parsedStartDate = moment(startTime, 'DD-MM-YYYY H:mm:ss');
            var parsedEndDate = moment(endTime, 'DD-MM-YYYY H:mm:ss');
            
            var sDate=new Date(parsedStartDate);
            var eDate=new Date(parsedEndDate);
            
           
            
            
            
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

             var storeDetails = [];
            
            $("#storeList option:selected").each(function () {
               var $this = $(this);
               if ($this.length) {
                var storeName = $this.text();
                var storeVal = $this.val();

                 var storeDetail = {
                        storeId: storeVal,
                        storeName: storeName 
                    }
                    storeDetails.push(storeDetail);
               }
            });
            
            
            

            
            
            var dataToInsert = JSON.stringify({
                                "title": $("#titile").val(),
                                "code": $("#Promocode").val(),
                                // "storeLiability" : $("#storeLiability").val(),
                                // "adminLiability" : $("#adminLiability").val(),

                                "storeLiability" : "0",
                                "adminLiability" : "100",
                                "cities": cityDetails,
                                "store": storeDetails,
                                // "cityNames": cityDetails,
                                // "tripCount": parseInt($("#tripCount").val()),
                                "zones": $("#zonesList").val(),
                                "rewardType": 1,
                                "paymentMethod":$('input[name=xridesRadio]:checked').val(),
                                "isApplicableWithWallet":($('#isApplicableWithWallet').is(':checked'))?1:0,
                                "discount": discountData,
                                "startTime": parsedStartDate.toISOString(),
                                "endTime": parsedEndDate.toISOString(),
                                "globalUsageLimit": parseInt($("#maxusage").val()) ,
                                "perUserLimit": parseInt($("#perUserLimit").val()),
                                "globalClaimCount": 0,
                                "minimumPurchaseValue": $("#minimumPurchaseValue").val(),
                               // "vehicleType" : $('input[name=veichleTypeRadio]:checked').val(),
                               //"vehicleType" : "4",
                                "description": description,
                                "applicableOn" : parseInt($('input[name=applicableOn]:checked').val()),
                                "termsAndConditions" : termsAndConditions,
                                "howItWorks" : howItWorks


            });

                // update in database

                $.ajax({
                    url: "<?php echo APILink ?>" + 'promoCode',
                    type: "POST",
                    dataType: "JSON",
                    contentType: "application/json; charset=utf-8",
                    data: dataToInsert,
                    }).done(function(json) {
                            console.log('result',json);
                        if (json.data.status == true) {
                            window.location.href = "<?php echo base_url() ?>index.php?/CouponCode/index/2";

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

    function calltrigger(element) {
        var dis = $('#' + element);
        if ((!$(dis).attr("checked")) || $(dis).attr('type') == 'checkbox')
            $(dis).attr("checked", !$(dis).attr("checked"));
        if (element == 'Fixedsecondtpromo') {
            $('.amountLabel').html('AMOUNT');
            $('.maxDiscount').hide();
        } else if (element == 'percentagesecondPromo') {
            $('.amountLabel').html('PERCENTAGE');
            $('.maxDiscount').show();
        } else
        if (element == "xridesselected") {
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
        if (element == 'zonecheck' && $('#zonecheck').attr("checked")) {
//            run_waitMe('bounce');
            var cityId = $('#selectedcityNew').find(":selected").text();
            if (cityId != "All") {
                $.ajax({
                    url: "<?php echo base_url() ?>index.php/coupons/getCityZone",
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
        
        if ((key >= 97 && key <= 122) ||(key >= 65 && key <= 90) ||
            (key >= 48 && key <= 57)) {
            return true;
        } else {
            return false;
        }
    }
});

</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20"><br/>
                <div class="inner" style="">
                    <!-- START BREADCRUMB -->
                    <ul class="breadcrumb" style="">
                        <li>
                        <!-- <a href="<?php echo base_url() . 'index.php/coupons/promotion/' . $actionFor ?>">PROMO CODE</a></li> -->
                       
                        <li class="breadClass"><a href="<?php echo base_url() ?>index.php?/CouponCode/index/1" class="active">Promo Code</a>&nbsp>&nbsp<a href="<?php echo base_url() ?>index.php?/couponCode/addNewCode" style="color: #0090d9 !important; font-size: 11px !important">Create new promo code</a>
                        </li>
                        <p class="pull-right cls110 submitButtonCss">
                             <button class="btn btn-primary btn-cons m-b-10 postAOffer texttop" id="enableBtn" type="button" style="border-radius: 40px;" >
                                <i class="pg-form" style="color: #ffffff;"></i> 
                                <span class="" style="color: #ffffff;">Submit</span>
                            </button>
                        </p>
                    </ul>
                    <!-- END BREADCRUMB -->
                </div>



                <div class="panel panel-group panel-transparent" data-toggle="collapse" id="accordion">
                    <div class="panel panel-primary">
                        <div class="panel-heading padding" data-parent="#accordion" data-toggle="collapse" href="#collapseOne">
                            <h4 class="panel-title">
                                <a class="collapsed"  id="collapseOneancher">
                                    PROMO CODE SETTING
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
                                            <label for="fname" class="col-sm-4 control-label aligntext">TITLE<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="" id="titile">
                                            </div>
                                        </div>
                                   </div> 
                                    <div class=" col-sm-3 error-box" id="offerTitleError"></div>
                                </div>

                           


                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6 form-group">
                                        <div class="form-group removePadding">
                                            <label for="fname" class="col-sm-4 control-label aligntext">CODE <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="Promocode"  placeholder="eg. xyz" required="" aria-required="true" 
                                                       onkeypress="return onlysmallalphadigit(event, this)"
                                                       onblur=""
                                                       data = "1"
                                                       >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="promoCodeError"></div>

                                </div>



                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 citiesData">
                                    <div class="col-sm-6 form-group">
                                            <label for="fname" class="col-sm-4 control-label aligntext">CITIES <span class="mandatoryField"> &nbsp *</span></label> 
                                            <div class="col-sm-8">
                                                <select id="citiesList" name="company_select" class="form-control" style="width: 55% !important" multiple="multiple">
                                                 <!-- <option disabled selected value> None Selected</option> -->
                                                </select>
                                            </div>
                                        
                                    </div>
                                <div class="col-sm-3 error-box" id="citiesError"></div>
                            </div>

                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 citiesData">
                                    <div class="col-sm-6 form-group">
                                            <label for="fname" class="col-sm-4 control-label aligntext">STORE<span class="mandatoryField"> &nbsp *</span></label> 
                                            <div class="col-sm-8">
                                                <select id="storeList" name="company_select" class="form-control" style="width: 55% !important" multiple="multiple">
                                                         <option > Please Select City</option>
                                                </select>
                                            </div>
                                        
                                    </div>
                                <div class="col-sm-3 error-box" id="citiesError"></div>
                            </div>
                             <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 hide zonesData">
                                    <div class="col-sm-6 form-group">
                                        
                                            <label for="fname" class="col-sm-4 control-label aligntext">ZONES <span class="mandatoryField"> &nbsp *</span></label> 
                                            <div class="col-sm-8">
                                                <select id="zonesList" name="company_select" class="form-control" style="width: 100% !important">
                                                 <option disabled selected value> None Selected</option>
                                                </select>
                                            </div>
                                        
                                    </div>
                                <div class="col-sm-3 error-box" id="citiesError"></div>
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
                                <!-- Admin Liability -->
                                <!--  <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10" style="padding-bottom: 15px">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label aligntext1">ADMIN LIABILITY<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" id='adminLiability' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 88%; float: left;" >
                                                <span class="percentageSpan" style="font-size: 18px; margin-left: 10px; "> % </span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="adminLiabilityError"></div>
                                </div> -->

                                <!-- Store liability -->

                                <!-- <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10" style="padding-bottom: 15px">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label aligntext1">STORE LIABILITY<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" id='storeLiability' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 88%; float: left;" >
                                                <span class="percentageSpan" style="font-size: 18px; margin-left: 10px; "> % </span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="storeLiabilityError"></div>
                                </div> -->


                                <!-- Maximu global limit -->
                                


                                 <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10" style="padding-bottom: 15px">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-4 control-label aligntext1">MAXIMUM GLOBAL USAGE LIMIT<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" id='maxusage' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left;" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="maxiUsageError"></div>
                                </div>

                                <!-- Per user limit -->
                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10" style="padding-bottom: 15px">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-4 control-label aligntext1">PER USER USAGE LIMIT<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" id='perUserLimit' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left;" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="maxperUserLimitError"  style="display:none"></div>
                                    <div class="col-sm-3 error-box" id="perUserLimitError"></div>
                                    
                                </div>

                                <!-- Trip count -->
                               
                            
                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                <div class="col-sm-6 removePadding form-group">
                                        
                                            <label class="col-sm-4 control-label aligntext">START DATE <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-8">
                                                <div id="datepicker-component" class="input-group date col-sm-6 pull-left" >
                                                    <input type="text" class="form-control datepicker-component" id="startDate"><span class="input-group-addon" id="startDateAddOn"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <div class="col-sm-4 bootstrap-timepicker">
                                                    <!-- <input type="text" name="timepicker" class="form-control timepicker" id="starttime"/> -->
                                                    <div class="form-group">
                                                                <div class='input-group date' id='stime' >
                                                                    <input type='text' class="form-control"   id="starttime" value="00:00" />
                                                                    <!-- <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time" ></span>
                                                                    </span> -->
                                                                </div>
                                                            </div>
                                                    
                                                      
                                                </div>
                                            
                                        </div>
                                    </div>
                                <div class="col-sm-3 error-box" id="startDateError"></div>

                            </div>
                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                <div class="col-sm-6 removePadding form-group">
                                        
                                            <label class="col-sm-4 control-label aligntext">END DATE <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-8">
                                                <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                    <input type="text" class="form-control datepicker-component" id="EndDate"><span class="input-group-addon" id="endDataAddOn"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <div class="col-sm-4 bootstrap-timepicker">
                                                    <!-- <input type="text" name="timepicker" class="form-control timepicker" id="endtime"/> -->
                                                    <div class="form-group">
                                                                <div class='input-group date' id='etime'>
                                                                    <input type='text' class="form-control" onkeypress = "return onlyNumbersWithColon(event)" id="endtime" value="00:00"/>
                                                                    <!-- <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span> -->
                                                                </div>
                                                            </div>
                                                </div>
                                        </div>
                                    </div>
                                <div class="col-sm-3 error-box" id="endDateError"></div>

                            </div>
                              
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-4 control-label aligntext">PAYMENT TYPE <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-8">
                                                <div class="radio radio-success ">
                                                    <input class = "marginLeft" type="radio" checked="checked" value="1" name="xridesRadio" id="cardselected">
                                                    <label>CARD</label>
                                                     <input type="radio" class ="marginLeft"  value="2" name="xridesRadio" id="cashselected">
                                                    <label>CASH</label>                                                   
                                                    <input type="radio" class="marginLeft"  value="3" name="xridesRadio" id="bothselected">
                                                    <label>ANY</label>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    <div class="error-box" id="paymentMethodError"></div>
                                    </div>

                                </div>
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-4 control-label aligntext">IS  APPLICABLE WITH</label>
                                            <div class="col-sm-8">
                                              <div class="">
                                                  <input type="checkbox" class="checkbox" value="1" name="isApplicableWithWallet" id="isApplicableWithWallet" style="float:left">
                                                  <label for="isApplicableWithWallet" style="padding-left: 8px;margin-top: 3px;">WALLET</label>
                                                </div>
                                            </div>
                                        </div>
                                   
                                    </div>

                                </div>
                                 <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6 removePadding">
                                        <!-- <div class="form-group ">
                                            <label class="col-sm-4 control-label aligntext">VEICHLE TYPE <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-8">
                                                <div class="radio radio-success">
                                                    <input class = "marginLeft" type="radio" checked="checked" value="1" name="veichleTypeRadio" id="veichleType">
                                                    <label>A</label>
                                                     <input type="radio" class ="marginLeft"  value="2" name="veichleTypeRadio" id="cashselected">
                                                    <label>B</label>
                                                    <input type="radio" class="marginLeft" checked="checked" value="3" name="veichleTypeRadio" id="bothselected">
                                                    <label>C</label>
                                                    <input type="radio" class="marginLeft" checked="checked" value="4" name="veichleTypeRadio" id="bothselected">
                                                    <label>ANY</label>
                                                </div>
                                            </div>
                                        </div> -->
                                    <div class="error-box" id="paymentMethodError"></div>
                                    </div>

                                </div>
                      
                                <!-- PAYMENT METHOD TAB END -->

                                <!-- Discount type start -->
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <p class="fontSize marginTop">DISCOUNT TYPE :</p>
                                </div>

                                <!-- Applicable on tab -->

                                  <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-4 control-label aligntext" style="font-size: 11px !important;">APPLICABLE ON<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-8">
                                                <div class="radio usageType">
                                                    <input class = "marginLeft" type="radio" name="applicableOn" checked="checked" value="1" name="usageType" id="cartSelected">
                                                    <label>CART</label>
                                                    <input type="radio" class ="marginLeft"  name="applicableOn" value="2" name="usageType" id="cashSelected">
                                                    <label>DELIVERY FEE</label>
                                                    <input type="radio" class ="marginLeft" name="applicableOn" value="3" name="usageType" id="bothSeleted">
                                                    <label>BOTH</label>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="error-box" id="paymentMethodError"></div>
                                    </div>
                                </div>
                                 <!-- <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                     <div class="col-sm-6 removePadding">
                                        <div class="form-group  col-xs-12 ">
                                            <label for="fname" class="col-sm-3 control-label amountLabel aligntext" style="margin-left: -1%; margin-right: 2%;">REWARD TYPE <span class="mandatoryField"> &nbsp *</span></label>
                                                <div class="col-sm-7">
                                                <div class="radio radio-success offerTypeBtn" style="margin-left: -3%">
                                                    <input class = "offerTypeButton marginLeft" type="radio" checked="checked" value="1" name="offerType" id="productCategoryBtn">
                                                    <label>Wallet Credit</label>
                                                    <input class= "marginLeft offerTypeButton" type="radio"  value="2" name="offerType" id="productSubCategoryBtn">
                                                    <label>Coupon delivery</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 error-box" id="offerTypeError"></div>
                                        </div>
                                </div>
                            </div> -->
                                 <!-- Per user limit -->
                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10" style="padding-bottom: 15px">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-4 control-label aligntext1">MINIMUM PURCHASE VALUE<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" id='minimumPurchaseValue' data-v-min="0" data-v-max="" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left;" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="minimumPurchaseError"></div>
                                </div>


                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6 removePadding">
                                            <div class="form-group col-xs-12 ">
                                                <label for="fname" class="col-sm-4 control-label aligntext" style="padding: 0px !important">DISCOUNT TYPE <span class="mandatoryField"> &nbsp *</span></label>
                                                <div class="col-sm-8 ">
                                                    <div class="radio radio-success">
                                                        <input class = "marginLeft" type="radio" checked="checked" value="1" name="secondblockrefferalDiscount" id="Fixedsecondtpromo">
                                                        <label onclick="calltrigger('Fixedsecondtpromo')">FIXED</label>
                                                        <input class= "marginLeft" type="radio"  value="2" name="secondblockrefferalDiscount" id="percentagesecondPromo">
                                                        <label onclick="calltrigger('percentagesecondPromo')">PERCENTAGE</label>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group  col-xs-12 ">
                                            <label for="fname" class="col-sm-4 control-label amountLabel aligntext" style="margin-left: 3%; margin-right: -4%;">AMOUNT<span class="mandatoryField"> &nbsp *</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="addmemclass1 form-control" id="amount"  placeholder=""   required="" aria-required="true">                                                                                            
                                                <span class="currencyCss" id="cityCurrency" style="font-size: 18px"></span>
                                                <span class= "forPercentage hide percentageSpan" style="font-size: 18px; margin-left: 10px; right:11px; top:0"> % </span>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="amountError"></div>
                               </div>
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6">
                                        <div class="form-group maxDiscount" style="display:none">
                                            <label for="fname" class="col-sm-4 control-label aligntext" style="font-size: 11px; padding-bottom: 10px;">MAX DISCOUNT<span class="mandatoryField"> &nbsp *</span></label>

                                            <div class="col-sm-8">
                                                <input type="text" class="addmemclass1 form-control" id="maxDiscount" placeholder="Amount" value="0"   required="" aria-required="true" style="margin-left:-2%">
                                                <span class="percentageCss" id="cityCurrencyPerntage" style="font-size: 18px"></span>                                                                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="maxDiscountError"></div>
                                </div>


                                <!-- Discount type end -->
                                
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
                                   
                                            <label>Description<a target="_new" href=""> &nbsp Preview</a></label>
                                            
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

                        <!-- How it works -->
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
</div>
<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>supportFiles/wickedpicker.css">
<script src="<?php echo base_url() ?>supportFiles/wickedpicker.js"></script>
