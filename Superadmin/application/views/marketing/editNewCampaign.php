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
.checkbox input[type="checkbox"] {
    left: 25px;
    margin: 0;
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
</style>
 <script type="text/javascript">
 // $('#starttime').datetimepicker({
 //        use24hours: true
 //    });
     
 </script>
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
             format : 'HH:mm'
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
    function updateFiled(){
        // $.ajax({
        //         url: "<?php echo APILink ?>" + "admin/city",
        //         type: 'GET',
        //         dataType: 'json',
        //         headers: {
        //           language: 0
        //         },
        //         data: {                  
        //         },
        //     }).done(function(json) {
                
        //         $("#citiesList").html('');
                
        //          for (var i = 0; i< json.data.length; i++) {
                
        //             var citiesList = "<option value="+ json.data[i].id + " currency="+ json.data[i].currency + ">"+  json.data[i].cityName +"</option>";
        //             $("#citiesList").append(citiesList);  
        //         }

        //         $('#citiesList').multiselect({
        //             includeSelectAllOption: true,
        //             enableFiltering: true,
        //             enableCaseInsensitiveFiltering : true,
        //             buttonWidth: '100%',
        //             maxHeight: 300,
        //         });

        // });
     }
// Function to get all zones
    function getAllZones(cityIds){
        $.ajax({
                url: "<?php echo APILink ?>" + "zones/" + cityIds,
                type: 'GET',
                dataType: 'json',
                data: {                  
                },
            }).done(function(json) {
                if (json.data.length == 0) {
                    $(".zonesData").addClass('hide');
                }else{
                $(".zonesData").removeClass('hide');
                $("#zonesList").html('');
                $("#zonesList").append("<option disabled selected value> None Selected</option>");    
                 for (var i = 0; i< json.data.length; i++) {
                
                    var zonesList = "<option value="+ json.data[i]._id + ">"+  json.data[i].title +"</option>";
                    $("#zonesList").append(zonesList);  
                }                    
                }
        });
    }

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
        if ($("#titile").val().length == 0) {
            isFilled = false;
            $("#offerTitleError").text('Please enter the title');
        }
        if ($("#maxusage").val() == "0") {
            isFilled = false;
            $("#globalLimitError").text('Please enter maximum gloabl usage');
        }
        if ($("#perUserLimit").val().length == 0) {
            isFilled = false;
            $("#perUserLimitError").text('Please enter store liability');
        }
        if ($("#maxusage").val().length == 0) {
            isFilled = false;
            $("#maxusageError").text('Please enter admin liability');
        }
        if ($("#maxusage").val() == "0" && $("#perUserLimit").val() == "0") {
            isFilled = false;
            $("#maxusageError").text('Please enter admin liability');
            $("#perUserLimitError").text('Please enter store liability');
        }
        if ($("#startDate").val().length == 0) {
            isFilled = false;
            $("#startDateError").text('Please select the date');
        }
        if ($("#EndDate").val().length == 0) {
            isFilled = false;
            $("#endDateError").text('Please select the end date');
        }
        if ($('input[name=xridesRadio]:checked').val().length == 0) {
            isFilled = false;
            $("#paymentMethodError").text('Please select the payment method');
        }
        if (isFilled) {
            return true;
        }else{
            return false;
        }
     }


    $(document).ready(function () {

     updateFiled();
    /*
        check if edit page then fill the page with campaign data 
        pageFlag = 0 for edit page
    */
   
        /* Edit page
             Get the details by ajax call and fill the details
        */
       

   
    if ($("#citiesList").val()) {
        var cityIdForNonFranchiseStore = $("#citiesList").val();
    }






    $("#citiesList").change(function(){
        var cityId = $("#citiesList").val();
        getAllZones(cityId);
        $("#cityCurrency").text('(In ' +  $('option:selected', this).attr('currency') + ')');      
        $("#storeList").multiselect('destroy');
        var cityIdForNonFranchiseStore = $("#citiesList").val();
        
    });

    // $('#maxusage').one('focus', function(){
    //     this.value = '';
    // });
    // $('#perUserLimit').one('focus', function(){
    //     this.value = '';
    // });
    // $('#tripCount').one('focus', function(){
    //     this.value = '';
    // });
    // $('#adminLiability').one('focus', function(){
    //     this.value = '';
    // });
    // $('#storeLiability').one('focus', function(){
    //     this.value = '';
    // });
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
            return;
        }
        var fill = 100 - val;    
        $("#adminLiability").val(fill);
    });
     // Auto Fill store liability on typing in admin liability
   


    //Auto fill admin liability on typing in store liability
    
    
        
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

$("#newUserTripCountTrigger").click(function(){
     $('.requiredBillingAmount').addClass('hide');
    $('.tripCountTrigger').removeClass('hide');
});

$("#newUserTotalBusinessTrigger").click(function(){
    $('.requiredBillingAmount').removeClass('hide');
    $('.tripCountTrigger').addClass('hide');
})
{
    $('.requiredBillingAmount').addClass('hide');
    $('.tripCountTrigger').removeClass('hide');
}





//        $("#datepicker1").datepicker({ minDate: 0});
        var date = new Date();
        $('.datepicker-component').datepicker({
            startDate: date,
            format: 'dd-mm-yyyy'
        });

        $('.postAOffer').click(function () {
            if(checkAllFields() == true){
            var discountType = parseInt($('input[name=secondblockrefferalDiscount]:checked').val());

            var description         = CKEDITOR.instances.description.getData();
            var termsAndConditions  = CKEDITOR.instances.termscond.getData();
            var howItWorks          = CKEDITOR.instances.howItWorks.getData();


            
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

            if ($('input[name=rewardTriggerType]:checked').val() == "2") {
                var totalBusinessAmount = parseInt($("#totalBillingAmountRequired").val());
            }else{
                var totalBusinessAmount = 0;
            }

            // var startTime   =  '"' + $("#startDate").val() + ' ' + $("#starttime").val() + ':00"';
            // var endTime     =  '"' + $("#EndDate").val() + ' ' + $("#endtime").val() + ':00"';

            var startTime   =  '"' + $("#startDate").val() + ' ' + $("#starttime").val() + ':00"';
            var endTime     =  '"' + $("#EndDate").val() + ' ' + $("#endtime").val() + ':00"';

            // "29-01-2018"
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

            
            var dataToInsert = JSON.stringify({
                                "campaignId":"<?php echo $campaignId?>",
                                "title": $("#titile").val(),
                                "code": "N/A",
                                
                                "storeLiability" : $("#storeLiability").val(),
                                "adminLiability" : $("#adminLiability").val(),
                                
                                "cities": cityDetails,
                                "zones": $("#zonesList").val(),
                                
                                "tripCount": parseInt($("#tripCount").val()),
                                "rewardTriggerType" : parseInt($('input[name=rewardTriggerType]:checked').val()),
                                "totalBusinessAmountRequired" : totalBusinessAmount,
                                "isApplicableWithWallet":($('#isApplicableWithWallet').is(':checked'))?1:0,
                                
                                "rewardType": parseInt($('input[name=rewardType]:checked').val()),
                                "paymentMethod":$('input[name=xridesRadio]:checked').val(),
                                "discount": discountData,
                                "usage": parseInt(($('input[name=usageType]:checked').val())),
                                "startTime": parsedStartDate.toISOString(),
                                "endTime": parsedEndDate.toISOString(),
                                
                                "globalUsageLimit": parseInt($("#maxusage").val()) ,
                                "perUserLimit": parseInt($("#perUserLimit").val()),
                                "tripCount": $("#tripCount").val(),
                                
                                
                                "description": description,
                                "termsConditions": termsAndConditions,
                                "howITWorks": howItWorks,
            });
                // update in database

                $.ajax({
                    url: "<?php echo APILink ?>" + 'campaign',
                    type: "PATCH",
                    dataType: "JSON",
                    contentType: "application/json; charset=utf-8",
                    data: dataToInsert,
                    }).done(function(json,textStatus,xhr) {
                        if (xhr.status == 200) {
                            window.location.href = "<?php echo base_url() ?>index.php?/campaigns/index/1";
                           

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

        } else if(element == 'percentagesecondPromo') {
           
           $('.amountLabel').html('PERCENTAGE');
            $('.maxDiscount').show();

        } else if(element == "xridesselected") {
            
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

        } else if(element == 'newUserTripCountTrigger'){
            
            $('.requiredBillingAmount').addClass('hide');
            $('.tripCountTrigger').removeClass('hide');

        } else if(element == "newUserTotalBusinessTrigger"){
            
            $('.requiredBillingAmount').removeClass('hide');
            $('.tripCountTrigger').addClass('hide');
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


$(document).ready(function () {


    
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

                console.log('city fetched');
                console.log('city detail',json);
                
                $("#citiesList").html('');
                
                 for (var i = 0; i< json.data.length; i++) {
                
                    var citiesList = "<option value="+ json.data[i].id + " currency="+ json.data[i].currency + ">"+  json.data[i].cityName +"</option>";
                    $("#citiesList").append(citiesList);  
                }
                  $('#citiesList').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering : true,
                    buttonWidth: '100%',
                    maxHeight: 300,
                });

// Ajax to fill the form 

            $.ajax({
                url: "<?php echo APILink ?>" + 'campaignById/' + "<?php echo $campaignId ?>",
                type: "GET",
                dataType: "JSON",
                headers: {
                      language: 0
                    },
                contentType: "application/json; charset=utf-8",
                data: '',
            }).done(function(json,textStatus, xhr) {

               var promodata=json["data"][0];
                 //dynamic city  selection
                 var editvalCity = [];
               $.each( promodata.cities, function(index,val){                
                    editvalCity.push(val.cityId);
                });            
              
              
                
                $.ajax({
                    url: "<?php echo base_url('index.php?/CouponCode') ?>/getStoreData",
                    type: 'POST',
                    dataType: 'json',
                    async: false,
                    data: {
                        val: editvalCity
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
              
          
                if (xhr.status == 200) {
                   
                    $("#titile").val(promodata["title"]);
                    $("#adminLiability").val(promodata["adminLiability"]);
                    $("#storeLiability").val(promodata["storeLiability"]);
                    $("#maxusage").val(promodata["globalUsageLimit"]);
                    $("#perUserLimit").val(promodata["perUserLimit"]);
                    
                    $("#tripCount").val(promodata["tripCount"]);
                    $("#amount").val(promodata["amount"]);
                    $("#totalBillingAmountRequired").val(promodata["totalBusinessAmountRequired"]);
                    $("#tripCount").val(promodata["tripCount"]);
                    //discount
                    $("#amount").val(promodata["discount"]["value"]);
                    //multiselect
                    $.each( promodata.cities, function(index,val){
                        var citydata=val;
                       
                        $('#citiesList').multiselect('select', citydata.cityId);
                    });

                     $.each( promodata.store, function(index,val){
                        var storedata=val;
                        $('#storeList').multiselect('select', storedata.storeId);
                    });


                   //start date
                //    var startdate=promodata["startTime"];
                //    var res = startdate.split("T");
                //    $("#startDate").val(res[0]); 
                //    $("#starttime").val(res[1].substr(0,5)); 
                //    var enddate=promodata["endTime"];                    
                //    var resend = enddate.split("T");
                //    $("#EndDate").val(resend[0]);
                //    $("#endtime").val(resend[1].substr(0,5));

                    //changes in date format ****
                    var momentDate = moment(promodata["startTime"]);
                    var hour = momentDate.hours();
                    var minutes = momentDate.minutes();
                    var firstTime =moment(promodata["startTime"]).format("HH:mm");
                
                    var momentDate2 = moment(promodata["endTime"])
                    var hour2 = momentDate2.hours();
                    var minutes2 = momentDate2.minutes();
                    var lastTime =moment(promodata["endTime"]).format("HH:mm");

                  
                   var startdate=promodata["startTime"];
                   var res = startdate.split("T");
                   $("#startDate").val(moment(startdate).format('DD-MM-YYYY'));
                   $("#starttime").val(firstTime); 

                   var enddate=promodata["endTime"];
                   var resend = enddate.split("T");
                   $("#EndDate").val(moment(enddate).format('DD-MM-YYYY'));
                   $("#endtime").val(lastTime);

                //    changes end *****


                     //csk editor
                   var data=promodata["description"];
                  
                   CKEDITOR.instances.description.setData(data);

                    // $('#citiesList').multiselect('select', citydata);
                    // console.log(promodata["cities"]);

                  

                   //csk editor 2
                   var dataterms=promodata["termsConditions"];
                  
                   CKEDITOR.instances.termscond.setData(dataterms);

                   //csk editor 3
                   var datahow=promodata["howITWorks"];
                  
                   CKEDITOR.instances.howItWorks.setData(datahow);


                   

                    $(".cke_editable").val(promodata["description"]);
                    if(promodata["paymentMethod"]==1){
                        $("input[name=xridesRadio][value='1']").prop("checked",true);
                    }else if(promodata["paymentMethod"]==2){
                        $("input[name=xridesRadio][value='2']").prop("checked",true);
                    }else  if(promodata["paymentMethod"]==3){
                        $("input[name=xridesRadio][value='3']").prop("checked",true);
                    }


                        //reward
                        if(promodata["rewardTriggerType"]==1){
                        $("input[name=rewardTriggerType][value='1']").prop("checked",true);
                        $('.requiredBillingAmount').addClass('hide');
                        $('.tripCountTrigger').removeClass('hide');
                    }else if(promodata["rewardTriggerType"]==2){
                        $("input[name=rewardTriggerType][value='2']").prop("checked",true);
                        $('.requiredBillingAmount').removeClass('hide');
                        $('.tripCountTrigger').addClass('hide');

                    }

                    //applicable on
                    if(promodata["usage"]==1){
                        $("input[name=usageType][value='1']").prop("checked",true);
                    }else if(promodata["usage"]==2){
                        $("input[name=usageType][value='2']").prop("checked",true);
                    }else  if(promodata["usage"]==3){
                        $("input[name=usageType][value='3']").prop("checked",true);
                    }
                    //reward type 

                    if(promodata["rewardType"]==1){
                        $("input[name=rewardType][value='1']").prop("checked",true);
                    }else if(promodata["rewardType"]==2){
                        $("input[name=rewardType][value='2']").prop("checked",true);
                    }
                    
                  
                    
                    if(promodata["discount"]["typeId"]==1){
                        $("input[name=secondblockrefferalDiscount][value='1']").prop("checked",true);
                        $("#cityCurrency").removeClass('hide');
                        $('.amountLabel').html('AMOUNT');
                        $('.maxDiscount').hide(); 
                        $(".forPercentage").addClass('hide');
                    }else if(promodata["discount"]["typeId"]==2){
                        $("input[name=secondblockrefferalDiscount][value='2']").prop("checked",true);
                        $('.amountLabel').html('PERCENTAGE');
                        $("#cityCurrency").addClass('hide');
                        $('.maxDiscount').show(); 
                        $(".forPercentage").removeClass('hide');
                    }

                    //csk editor

                   
                   


               }
                
            });
            });


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
                            
                                
                      
                        <li class="breadClass"><a href="<?php echo base_url(); ?>index.php?/campaigns/index/1" class="active">Loyalty Program</a>&nbsp>&nbsp<a href="#" style="color: #0090d9 !important; font-size: 11px !important">Edit Campaign</a>
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



                <div class="panel panel-group panel-transparent" data-toggle="collapse" id="accordion">
                    <div class="panel panel-primary">
                        <div class="panel-heading padding" data-parent="#accordion" data-toggle="collapse" href="#collapseOne">
                            <h4 class="panel-title">
                                <a class="collapsed"  id="collapseOneancher">
                                    CAMPAIGN SETTING
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

                           


                                <!-- <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
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

                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 citiesData">
                                    <div class="col-sm-6 form-group">
                                            <label for="fname" class="col-sm-3 control-label aligntext">CITIES <span class="mandatoryField"> &nbsp *</span></label> 
                                            <div class="col-sm-7">
                                                <select id="citiesList" name="company_select" class="form-control" style="width: 55% !important" multiple="multiple">
                                                 
                                                </select>
                                            </div>
                                        
                                    </div>
                                <div class="col-sm-3 error-box" id="citiesError"></div>
                            </div>
                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 citiesData">
                                    <div class="col-sm-6 form-group">
                                            <label for="fname" class="col-sm-3 control-label aligntext">STORE<span class="mandatoryField"> &nbsp *</span></label> 
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
                                        
                                            <label for="fname" class="col-sm-3 control-label aligntext">ZONES <span class="mandatoryField"> &nbsp *</span></label> 
                                            <div class="col-sm-7">
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
                                 <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10" style="padding-bottom: 15px">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label aligntext1">ADMIN LIABILITY<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" id='adminLiability' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left;" >
                                                <span class="percentageSpan" style="font-size: 18px; margin-left: 10px; "> % </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="globalLimitError"></div>
                                </div>

                                <!-- Store liability -->

                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10" style="padding-bottom: 15px">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label aligntext1">STORE LIABILITY<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" id='storeLiability' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left;" >
                                                <span class="percentageSpan" style="font-size: 18px; margin-left: 10px; "> % </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="globalLimitError"></div>
                                </div>


                                <!-- Maximu global limit -->

                                 <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10" style="padding-bottom: 15px">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label aligntext1">MAXIMUM GLOBAL USAGE LIMIT<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" id='maxusage' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left;" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="globalLimitError"></div>
                                </div>

                                <!-- Per user limit -->
                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10" style="padding-bottom: 15px">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label aligntext1">PER USER USAGE LIMIT<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" id='perUserLimit' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left;" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="globalLimitError"></div>
                                </div>

                                <!-- Trip count -->
                               <!--  <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10" style="padding-bottom: 15px">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label aligntext1">TRIP COUNT<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" id='tripCount' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left;" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="globalLimitError"></div>
                                </div> -->
                            
                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                <div class="col-sm-6 removePadding form-group">
                                        
                                            <label class="col-sm-3 control-label aligntext">START DATE <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <div id="datepicker-component" class="input-group date col-sm-6 pull-left" >
                                                    <input type="text" class="form-control datepicker-component" id="startDate"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <div class="col-sm-4 bootstrap-timepicker">
                                                    <!-- <input type="text" name="timepicker" class="form-control timepicker" id="starttime"/> -->
                                                    <div class="form-group">
                                                            <div class='input-group date' id='stime' >
                                                                <input type='text' class="form-control"   id="starttime" value="00:00" />
                                                               
                                                            </div>
                                                    </div>
                                                </div>
                                            
                                        </div>
                                    </div>
                                <div class="col-sm-3 error-box" id="startDateError"></div>

                            </div>
                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                <div class="col-sm-6 removePadding form-group">
                                        
                                            <label class="col-sm-3 control-label aligntext">END DATE <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                    <input type="text" class="form-control datepicker-component" id="EndDate"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <div class="col-sm-4 bootstrap-timepicker">
                                                    <!-- <input type="text" name="timepicker" class="form-control timepicker" id="endtime"/> -->
                                                    <div class="form-group">
                                                                <div class='input-group date' id='etime'>
                                                                    <input type='text' class="form-control" onkeypress = "return onlyNumbersWithColon(event)" id="endtime" value="00:00"/>
                                                                   
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
                                            <label class="col-sm-3 control-label aligntext">PAYMENT TYPE <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <div class="radio radio-success">
                                                   
                                                    <input class = "marginLeft" type="radio" checked="checked" value="1" name="xridesRadio" id="cardselected">
                                                    <label onclick="calltrigger('cardselected')">CARD</label>
                                                     <input type="radio" class ="marginLeft"  value="2" name="xridesRadio" id="cashselected">
                                                    <label onclick="calltrigger('cashselected')">CASH</label>
                                                    <input type="radio" class="marginLeft" checked="checked" value="3" name="xridesRadio" id="bothselected">
                                                    <label onclick="calltrigger('bothselected')">BOTH</label>
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
                      
                                <!-- PAYMENT METHOD TAB END -->
                                <!-- Reward trigger type start -->
                                    <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                            <div class="col-sm-12 removePadding">
                                                    <div class="form-group col-xs-12 ">
                                                        <label for="fname" class="col-sm-2 control-label aligntext" style="padding: 0px !important">REWARD TYPE TRIGGER<span class="mandatoryField"> &nbsp *</span></label>
                                                        <div class="col-sm-6 removePadding">
                                                            <div class="radio radio-success">
                                                                <input class = "marginLeft" type="radio" checked="checked" value= 1 name="rewardTriggerType" id="newUserTripCountTrigger">
                                                                <!-- <label onclick="calltrigger('newUserTripCountTrigger')">TRIP COUNT</label> -->
                                                                <label>TRIP COUNT</label>
                                                                <input class= "marginLeft" type="radio"  value= 2 name="rewardTriggerType" id="newUserTotalBusinessTrigger">
                                                                <!-- <label onclick="calltrigger('newUserTotalBusinessTrigger')">TOTAL BUSINESS</label> -->
                                                                <label>TOTAL BUSINESS</label>

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
                                                    <input type="text" class="addmemclass1 form-control" id="totalBillingAmountRequired"  placeholder=""   required="" aria-required="true" onkeypress="return isNumberKey(event, 'amount')">                                                                                            
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
                                            <label class="col-sm-2 control-label aligntext1">TRIP COUNT<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" id='tripCount' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left;" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="globalLimitError"></div>
                                </div>
                                <!-- Reward trigger type end -->
                                <!-- Discount type start -->
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <p class="fontSize marginTop">DISCOUNT TYPE :</p>
                                </div>

                                <!-- usage -->
                                 <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label aligntext">APPLICABLE ON<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <div class="radio usageType">
                                                    <input class = "marginLeft" type="radio" checked="checked" value="1" name="usageType" id="cardselected">
                                                    <label>CART</label>
                                                    <input type="radio" class ="marginLeft"  value="2" name="usageType" id="cashselected">
                                                    <label>DELIVERY FEE</label>
                                                    <input type="radio" class ="marginLeft"  value="3" name="usageType" id="cashselected">
                                                    <label>BOTH</label>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="error-box" id="paymentMethodError"></div>
                                    </div>
                                </div>
                                <!-- usage end -->
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label aligntext">REWARD TYPE <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <div class="radio radio-success">
                                                    <input class = "marginLeft" type="radio" checked="checked" value="1" name="rewardType" id="cardselected">
                                                    <label>Wallet Credit</label>
                                                     <input type="radio" class ="marginLeft"  value="2" name="rewardType" id="cashselected">
                                                    <label>Coupon Delivery</label>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="error-box" id="paymentMethodError"></div>
                                    </div>
                                </div>
                            <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6 removePadding">
                                            <div class="form-group col-xs-12 ">
                                                <label for="fname" class="col-sm-3 control-label aligntext" style="padding: 0px !important">DISCOUNT TYPE <span class="mandatoryField"> &nbsp *</span></label>
                                                <div class="col-sm-7 ">
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
                                            <label for="fname" class="col-sm-3 control-label amountLabel aligntext" style="margin-left: 3%; margin-right: -4%;">AMOUNT</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="addmemclass1 form-control" id="amount"  placeholder=""   required="" aria-required="true" onkeypress="return isNumberKey(event, 'amount')">                                                                                            
                                                <span class="percentageSpan"  id="cityCurrency" style="font-size: 18px; margin-left: 10px; margin-top: -34px; margin-right: -38px;"></span>
                                                <!-- <span class="" id="cityCurrency" style="font-size: small"></span> -->
                                                <span class= "forPercentage hide percentageSpan" style="font-size: 18px; margin-left: 10px; right:11px; top:0"> % </span>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="amountError"></div>
                               </div>
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6" style="padding-bottom: 15px">
                                        <div class="form-group maxDiscount" style="display:none">
                                            <label for="fname" class="col-sm-3 control-label aligntext removePadding">MAX DISCOUNT<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="addmemclass1 form-control" id="maxDiscount" placeholder="Amount" value="0"   required="" aria-required="true" onkeypress="return isNumberKey(event, 'amountFirstBlock')" style="margin-left:-2%">                                                                                            
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
<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>supportFiles/wickedpicker.css">
<script src="<?php echo base_url() ?>supportFiles/wickedpicker.js"></script>
