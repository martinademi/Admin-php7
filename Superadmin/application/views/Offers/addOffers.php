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

</style>
<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>
<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script src="<?php echo base_url() ?>supportFiles/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>supportFiles/sweetalert.css">
<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>supportFiles/waitMe.css">
<script src="<?php echo base_url() ?>supportFiles/waitMe.js"></script>
<script>

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

/*
Beacon locations by store Id
 */

 function allBecondLocationsByStoreIds(storeIds){
    $(".locationClass").addClass('hide');
    
            $.ajax({
                url: '<?php echo nodeAPILink ?>' + 'LocationsByStoreId/' + [storeIds],
                type: 'GET',
                dataType: 'json',
                data: {
                    
                },
            }).done(function(json) {
                $("#beconLoactions").multiselect('destroy');
                if (json.data.length > 0) {
                    $(".locationClass").removeClass('hide');
                    for (var i = 0; i< json.data.length; i++) {
                        for (var j = 0; j< json.data[i]['beacons'].length ; j++) {
                            
                            
                        var beacon = "<option value="+ json.data[i]._id +" beaconId = "+ json.data[i]['beacons'][j]['beaconId'] +"> " + json.data[i]['beacons'][j]['location'][0]  +"    ("+ json.data[i].storeName + ")"  +"</option>";
                        $("#beconLoactions").append(beacon);                       
                            
                        }
                    }
                    $('#beconLoactions').multiselect({
                        includeSelectAllOption: true,
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering : true,
                        buttonWidth: '500px',
                    }); 
                }else{
                    // $("#beconLoactionsError").text("No locations found");
                }
        });

     } 


/*

 */
// Function to get all product categories
    function citiesList(){
        $.ajax({
                url: "<?php echo nodeAPILink ?>" + "cities",
                type: 'GET',
                dataType: 'json',
                data: {                  
                },
            }).done(function(json) {
                
                $("#citiesList").html('');
                $("#citiesList").append("<option disabled selected value> None Selected</option>");    
                 for (var i = 0; i< json.data.length; i++) {
                
                    var citiesList = "<option value="+ json.data[i]._id + " currency="+ json.data[i].Currency + ">"+  json.data[i].name +"</option>";
                    $("#citiesList").append(citiesList);  
                }
        });
     }





// Function to get all product categories
    function franchiseList(){
        $.ajax({
                url: "<?php echo nodeAPILink ?>" + "allFranchise",
                type: 'GET',
                dataType: 'json',
                data: {                  
                },
            }).done(function(json) {
                $("#franchiseList").multiselect('destroy');
                 for (var i = 0; i< json.data.length; i++) {
                    var franchise = "<option value="+ json.data[i]._id +">" + json.data[i].MasterName +"</option>";
                    $("#franchiseList").append(franchise);  
                }
                $('#franchiseList').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering : true,
                    buttonWidth: '500px',
                    maxHeight: 300,
                });

        });
     }

// Function to get all store list
    function storeList(franchiseIds, cityId){
        $.ajax({
                url: "<?php echo nodeAPILink ?>" + "allStoresByFranchise/"+ cityId +"/" + franchiseIds,
                type: 'GET',
                dataType: 'json',
                async:false,
                data: {                  
                },
            }).done(function(json) {
                $("#storeError").text('');
                $("#storeList").multiselect('destroy');
                if (json.data.length > 0) {
                // $("#storeList").trigger('change');
                 for (var i = 0; i< json.data.length; i++) {
                    var franchise = "<option value="+ json.data[i]._id +" storeName ="+json.data[i].ProviderName[0] +">" + json.data[i].ProviderName[0] +"</option>";
                    $("#storeList").append(franchise);  
                }
                $('#storeList').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering : true,
                    buttonWidth: '500px',
                    maxHeight: 300,
                });
            }
            else{
                $("#storeError").text('No stores found for ' + $("#citiesList option:selected").text());
            }

        });
     }



// Function to load all non franchise stores list
// Function to get all store list
    function nonFranchiseStores(cityId){

        $.ajax({
                url: "<?php echo nodeAPILink ?>" + "nonFranchiseStores/"+ cityId,
                type: 'GET',
                dataType: 'json',
                data: {                  
                },
            }).done(function(json) {
                
                
                $("#nonFranchiseStoreError").text('');
                $("#nonFranchiseStores").multiselect('destroy');
                if (json.data.length >  0) {
                 for (var i = 0; i< json.data.length; i++) {
                    var franchise = "<option value="+ json.data[i]._id +">" + json.data[i].ProviderName[0] +"</option>";
                    $("#nonFranchiseStores").append(franchise);  
                }
                $('#nonFranchiseStores').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering : true,
                    buttonWidth: '500px',
                    maxHeight: 300,
                });
            }else{
                $("#nonFranchiseStoreError").text('No stores found for ' + $("#citiesList option:selected").text());
            }

        });
     }

// Function to get all product categories
    function allCategories(){
        $.ajax({
                url: "<?php echo nodeAPILink ?>" + "productCategories",
                type: 'GET',
                dataType: 'json',
                data: {                  
                },
            }).done(function(json) {
                $("#productCategoryList").multiselect('destroy');
                 for (var i = 0; i< json.data.length; i++) {
                    var allCategories = "<option value="+ json.data[i]._id +">" + json.data[i].Category[0] +"</option>";
                    $("#productCategoryList").append(allCategories);  
                }
                $('#productCategoryList').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering : true,
                    buttonWidth: '500px',
                    maxHeight: 300,
                });

        });

     }

      // Function to get all available product subcats form a cat
      function productSubCategories(CatId){
            $.ajax({
                url: "<?php echo nodeAPILink ?>" + 'productSubCategories/' + CatId,
                type: 'GET',
                dataType: 'json',
                data: {
                    
                },
            }).done(function(json) {
                $("#productSubCategoryList").multiselect('destroy');
                $("#subCategoryError").text("");
                
                
                if (json.data.length > 0) {
                    for (var i = 0; i< json.data.length; i++) {
                        var productSubCategoryList = "<option value="+ json.data[i]._id +">" + json.data[i].SubCategory[0] +"</option>";
                        $("#productSubCategoryList").append(productSubCategoryList);                        
                    }
                    $('#productSubCategoryList').multiselect({
                        includeSelectAllOption: true,
                        enableFiltering: true,
                        buttonWidth: '500px',
                        maxHeight: 300,
                    }); 
                }else{
                    $("#subCategoryError").text("No subcategories available");
                }
            });

        } 


// get all products by category id
    function allProducts(storeIds){
            $.ajax({
                url: "<?php echo nodeAPILink ?>" + "productFromStoreIds/" + storeIds,
                type: 'GET',
                dataType: 'json',
                data: {                  
                },
            }).done(function(json) {
                
                // if (true) {
                $("#productListError").text('');
                $("#productList").multiselect('destroy');
                if (json.data.length >0) {
                for (var i = 0; i< json.data.length; i++) {
                    var product = "<option value="+ json.data[i]._id +">" + json.data[i].ProductName[0] +"</option>";
                    $("#productList").append(product);  
                }
                 $('#productList').multiselect({ 
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering : true,
                    buttonWidth: '500px',
                    maxHeight: 300    
           
            });
        }else{
            $("#productListError").text('No products found');
            
        }
        });

    }


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
        if ($("#maxusage").val() == "0") {
            isFilled = false;
            $("#globalLimitError").text('Please enter maximum gloabl usage');
        }
        if ($("#storeLiability").val().length == 0) {
            isFilled = false;
            $("#storeLiabilityError").text('Please enter store liability');
        }
        if ($("#adminLiability").val().length == 0) {
            isFilled = false;
            $("#adminLiabilityError").text('Please enter admin liability');
        }
        if ($("#adminLiability").val() == "0" && $("#storeLiability").val() == "0") {
            isFilled = false;
            $("#adminLiabilityError").text('Please enter admin liability');
            $("#storeLiabilityError").text('Please enter store liability');
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
        // if ($("#franchiseList").val() == null) {
        //     isFilled = false;
        //     $("#franchiseListError").text('Please select the franchise');
        // }
        // if ($("#storeList").val() == null) {
        //     isFilled = false;
        //     $("#franchiseListError").text('Please select the franchise');

        // }
        if($('input[name=offerType]:checked').val().length == 0){
            isFilled = false;
            $("#offerTypeError").text('Please select the offer type');
        }

        if (isFilled) {
            return true;
        }else{
            return false;
        }


     }


    $(document).ready(function () {

    
    allCategories();
    franchiseList();
    citiesList();
    
if ($("#citiesList").val()) {

    var cityIdForNonFranchiseStore = $("#citiesList").val();
    nonFranchiseStores(cityIdForNonFranchiseStore);
}
    $("#citiesList").change(function(){
    
        $("#cityCurrency").text('(In ' +  $('option:selected', this).attr('currency') + ')');      
        $("#storeList").multiselect('destroy');
        var cityIdForNonFranchiseStore = $("#citiesList").val();
        nonFranchiseStores(cityIdForNonFranchiseStore);
    });


    $("#franchiseList").change(function(){
        var cityId = $("#citiesList").val();
        if (cityId == null ) {
            alert('Please select city Id');
            return;
        }

        
        var franchiseIds = $("#franchiseList").val();
        storeList(franchiseIds, cityId);
        
    });
// On change of stores check if any non franchise stores are selected. Then load the data by combining both two. Load the location if present
    $("#storeList").change(function(){  
        var storeIds = $("#storeList").val();

        allBecondLocationsByStoreIds(storeIds);
        
    });

// On change of non franchsie stores check if any stores are selected. Then laod the data by combining both two. Load the location if present

    $("#nonFranchiseStores").change(function(){  
        var nonFranchiseStores =  $("#nonFranchiseStores").val();
        var franchhiseStoreIds = $("#nonFranchiseStores").val();
        if ( nonFranchiseStores !== null) {
        if (franchhiseStoreIds !== null) {
        nonFranchiseStores.push(franchhiseStoreIds);            
        }
        allBecondLocationsByStoreIds(nonFranchiseStores);
            
        }
        
        
    });






    $('#adminLiability').one('focus', function(){
        this.value = '';
    });
    $('#storeLiability').one('focus', function(){
        this.value = '';
    });
    $('#maxusage').one('focus', function(){
        this.value = '';
    });


     // Auto Fill store liability on typing in admin liability
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

    //Auto fill admin liability on typing in store liability
    
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


    /*
    fill div elements by selected options
     */
    $('input[name=offerType]').change(function () {
    var typeName = this.id;
    if (typeName === "productCategoryBtn" ) {
        // allCategories();
        $(".productCategoryClass").removeClass('hide');
        $(".productSubCategoryClass").addClass('hide');
        $(".productClass").addClass('hide');
    }
    else if(typeName === "productSubCategoryBtn"){
        $("#productCategoryList").change(function(){
            var categoryIds = $("#productCategoryList").val();
            productSubCategories(categoryIds);
            });
        
        if ($("#productCategoryList").val() == null) {
            $("#categoryErrror").text('Please select the category');
        }
        
        $(".productCategoryClass").removeClass('hide');
        $(".productSubCategoryClass").removeClass('hide');
        $(".productClass").addClass('hide');
    }else{
        if ($("#franchiseList").val() == null) {
            $("#franchiseList option").prop('selected', true);
        }
            // var franchiseList = $("#franchiseList").val();
            // storeList(franchiseList); 

            if ($("#storeList").val() === null) {
                
                $("#storeList option").prop('selected', true);
                
            }
           var storeIds = $("#storeList").val();
                allProducts(storeIds);
    

        $(".productCategoryClass").addClass('hide');
        $(".productSubCategoryClass").addClass('hide');
        $(".productClass").removeClass('hide');
    }
});
        // Load zones by city id on change of city
    // $('#citiesList').change(function(){
    //     var cityId = $("#citiesList").val();
    //     allZonesByCityId(cityId);
    //  });
        
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


        // $('.timepicker').wickedpicker(options);

        $('#selectedcityNew').change(function () {
           

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

        $('.postAOffer').click(function () {
            if(checkAllFields() == true){
                  if ($("#franchiseList").val() == null) {
                $("#franchiseList option").prop('selected', true);
            }

            var franchiseIds = $("#franchiseList").val();

            if ($("#storeList").val() == null) {
                $("#storeList option").prop('selected', true);
            }
            var storeIds = $("#storeList").val();

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


            var dataToInsert = JSON.stringify({
                                "offerOwner" : "1",
                                "title" : $("#titile").val(),
                                "couponCode" : $("#Promocode").val(),
                                "adminLiability" : parseInt($("#adminLiability").val()),
                                "storeLiability" : parseInt($("#storeLiability").val()),
                                "discountType" : discountData,
                                "offerType" : {
                                                "typeId" : $('input[name=xridesRadio]:checked').val(),
                                                "typeName" : 'abc'
                                                
                                                },
                                "paymentMethod" : $('input[name=xridesRadio]:checked').val(),
                                "globalUsageLimit" : $("#maxusage").val(), 
                                "schedule": {
                                    "startDate": $("#startDate").val(),
                                    "endDate": $("#EndDate").val(),
                                    "startTime": $("#starttime").val(),
                                    "endTime": $("#endtime").val()
                                },
                                "franchiseIds": franchiseIds,
                                "storeIds": storeIds,
                                "portionIds" : [],
                                "nonFranchiseIds": $("#nonFranchiseStores").val(),
                                "offerSubType": "",
                                "productCategory": $("#productCategoryList").val(),
                                "productSubCategory": $("#productSubCategoryList").val(),
                                "Product": $("#productList").val()
                                
                                 
            });
                // update in database

                $.ajax({
                    url: "<?php echo nodeAPILink ?>" + 'offers',
                    type: "POST",
                    dataType: "JSON",
                    contentType: "application/json; charset=utf-8",
                    data: dataToInsert,
                    }).done(function(json) {
                        if (json.message == "Success") {
                            window.location.href = "<?php echo base_url() ?>index.php/offerscontroller/offerDetails/1/1";

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
                            <?php if ($actionFor == 1) { ?>
                                <a href="<?php echo base_url() . 'index.php/coupons/promotion/' . $actionFor ?>">TRIP PROMO</a></li>
                        <?php } else { ?>
                            <!--<a href="<?php // echo base_url() . 'index.php/coupons/refferal/' . $actionFor ?>">WALLET PROMO</a></li>-->
                        <?php } ?>
                        <li class="breadClass"><a href="#" class="active">NEW</a>&nbsp>&nbsp<a href="<?php echo base_url() ?>index.php?/offerscontroller" style="color: #0090d9 !important; font-size: 11px !important">Create New Offer</a>
                        </li>
                        <p class="pull-right cls110">
                             <button class="btn btn-primary btn-cons m-b-10 postAOffer texttop" type="button" >
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
                                    OFFER SETTING
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
                                    <div class="row">
                                        <div class="form-group col-xs-12 removePadding">
                                            <label for="fname" class="col-sm-2 control-label aligntext"><?php echo $this->lang->line('label_Name'); ?><span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="name['en']" id="name_0">
                                            </div>
                                        </div>
                                   </div>
                                    <div class="row">
                                        <?php
                                        foreach ($language as $val) {
                                            if ($val['Active'] == 1) {
                                                ?>
                                                <div class="form-group col-xs-12 removePadding">
                                                    <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                                    <div class="col-sm-7 pos_relative2">

                                                        <input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['langCode'] ?>]"
                                                               required="required" class="error-box-class  form-control">

                                                    </div>
                                                    <div class="col-sm-3 error-box" id="text_name"></div>
                                                </div>
                                        <br/>
                                            <?php } else { ?>
                                                <div class="form-group col-xs-12 removePadding" style="display:none;">
                                                    <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                                    <div class="col-sm-7 pos_relative2">

                                                        <input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['langCode'] ?>]"
                                                               required="required" class="error-box-class  form-control">

                                                    </div>
                                                    <div class="col-sm-3 error-box" id="text_name"></div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class=" col-sm-3 error-box" id="offerTitleError"></div>
                                </div>
                                    <div class="row">
                                        <div class="form-group col-xs-12 removePadding">
                                            <label for="fname" class="col-sm-2 control-label aligntext"><?php echo $this->lang->line('label_Desc'); ?><span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="description['en']" id="desc_0">
                                            </div>
                                        </div>
                                   </div>
                                    <div class="row">
                                        <?php
                                        foreach ($language as $val) {
                                            if ($val['Active'] == 1) {
                                                ?>
                                                <div class="form-group col-xs-12 removePadding">
                                                    <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                                    <div class="col-sm-7 pos_relative2">

                                                        <input type="text" id="desc_<?= $val['lan_id'] ?>" name="description[<?= $val['langCode'] ?>]"
                                                               required="required" class="error-box-class  form-control">

                                                    </div>
                                                    <div class="col-sm-3 error-box" id="text_desc"></div>
                                                </div>
                                        <br/>
                                            <?php } else { ?>
                                                <div class="form-group col-xs-12 removePadding" style="display:none;">
                                                    <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                                    <div class="col-sm-7 pos_relative2">

                                                        <input type="text" id="desc_<?= $val['lan_id'] ?>" name="description[<?= $val['langCode'] ?>]"
                                                               required="required" class="error-box-class  form-control">

                                                    </div>
                                                    <div class="col-sm-3 error-box" id="text_desc"></div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class=" col-sm-3 error-box" id="offerTitleError"></div>
                                </div>
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6 form-group">
                                        <div class="form-group removePadding">
                                            <label for="fname" class="col-sm-3 control-label aligntext">PROMO CODE</label>
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

                                </div>



                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 citiesData">
                                    <div class="col-sm-6 form-group">
                                        
                                            <label for="fname" class="col-sm-3 control-label aligntext">CITIES <span class="mandatoryField"> &nbsp *</span></label> 
                                            <div class="col-sm-7">
                                                <select id="citiesList" name="company_select" class="form-control" style="width: 100% !important">
                                                 <option disabled selected value> None Selected</option>
                                                </select>
                                            </div>
                                        
                                    </div>
                                <div class="col-sm-3 error-box" id="citiesError"></div>
                            </div>



                                <!-- GENERAL SETTING TAB END -->
                                

                                <!-- CONDITIONS TAB START -->
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <p class="fontSize marginTop">CONDITIONS :</p>
                                </div>
                                
                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">

                                    <div class="col-sm-3 error-box" id="tripCountError"></div>

                                </div>

                                
                                 <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group ">
                                            <label class="col-sm-3 control-label aligntext1">MAXIMUM GLOBAL USAGE<span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" id='maxusage' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left;" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="globalLimitError"></div>
                                </div>
                            
                            <!-- Admin liability -->
                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                <div class="col-sm-6 removePadding form-group" >
                                            <label class="col-sm-3 control-label aligntext1">ADMIN LIABILITY <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9" >
                                                <input type="text" id='adminLiability' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left; ">
                                            <span class="percentageSpan" style="font-size: 18px; margin-left: 10px; "> % </span>
                                            </div>
                                </div>
                                <div class="col-sm-3 error-box" id="adminLiabilityError"></div>
                            </div>

                            <!-- Store liability -->
                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                <div class="col-sm-6 removePadding form-group" >
                                            <label class="col-sm-3 control-label aligntext1">STORE LIABILITY <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" id='storeLiability' data-v-min="0" data-v-max="1000000" class="autonumeric form-control" value="0" onkeypress = "return isNumber(event)" style="width: 90%; float: left;">
                                                 <span class="percentageSpan" style="font-size: 18px; margin-left: 10px; "> % </span>
                                            </div>
                                </div>
                                <div class="col-sm-3 error-box" id="storeLiabilityError"></div>
                            </div>


                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                <div class="col-sm-6 removePadding form-group">
                                        
                                            <label class="col-sm-3 control-label aligntext">START DATE <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
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
                                <div class="col-sm-6 removePadding form-group">
                                        
                                            <label class="col-sm-3 control-label aligntext">END DATE <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-9">
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

                           <!--  <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label aligntext">CITY</label>
                                            <div class="col-sm-7">
                                                <select id="citiesList" name="company_select" class="form-control" >
                                                 <?= $cities_html?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-sm-3 error-box" id="cityError"></div>

                            </div> -->

                            <!-- <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                <div class="col-sm-6">
                                            <div class="form-group removePadding">
                                                <label for="fname" class="col-sm-3 control-label aligntext">ZONE </label>
                                                <div class="col-sm-7">
                                                    <div class="checkbox check-primary">
                                                        <select class="form-control" id="zoneList" multiple="multiple" style="height: 40px;">
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-sm-3 error-box" id="zoneError"></div>

                            </div> -->

                                <!-- CONDITIONS TAB END -->

                                <!-- PAYMENT METHOD TAB -->
                                 
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

                                <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 franchiseData">
                                    <div class="col-sm-6 form-group removePadding">
                                        
                                            <label for="fname" class="col-sm-3 control-label aligntext">FRANCHISE</label>
                                            <div class="col-sm-7">
                                                <select id="franchiseList" name="company_select" class="form-control" multiple="multiple">
                                                 
                                                </select>
                                            </div>
                                        
                                    </div>
                                <div class="col-sm-3 error-box" id="franchiseListError"></div>
                            </div>

                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                    <div class="col-sm-6 form-group removePadding">
                                        
                                            <label for="fname" class="col-sm-3 control-label aligntext">STORE</label>
                                            <div class="col-sm-7">
                                                <select id="storeList" name="company_select" class="form-control" multiple="multiple">
                                                </select>
                                            </div>
                                    </div>
                                <div class="col-sm-3 error-box" id="storeError" style="margin-left: -250px"></div>
                            </div>
                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                    <div class="col-sm-6 form-group removePadding">
                                        
                                            <label for="fname" class="col-sm-3 control-label aligntext">NON FRANCHISE STORES</label>
                                            <div class="col-sm-7">
                                                <select id="nonFranchiseStores" name="company_select" class="form-control" multiple="multiple">
                                                 
                                                </select>
                                            </div>
                                        
                                    </div>
                                <div class="col-sm-3 error-box" id="nonFranchiseStoreError" style="margin-left: -250px"></div>
                            </div>
                             <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 locationClass hide">
                                    <div class="col-sm-6 form-group removePadding">
                                        
                                            <label for="fname" class="col-sm-3 control-label aligntext">LOCATIONS</label>
                                            <div class="col-sm-7">
                                                <select id="beconLoactions" name="company_select" class="form-control" multiple="multiple">
                                                 
                                                </select>
                                            </div>
                                        
                                    </div>
                                <div class="col-sm-3 error-box" id="beconLoactionsError"></div>
                            </div>

                            <!-- Offer type -->
                            <div class="col-sm-6 removePadding">
                                        <div class="form-group col-xs-12 removePadding">
                                            <label for="fname" class="col-sm-3 control-label aligntext" style="margin-left: 2%">OFFER TYPE <span class="mandatoryField"> &nbsp *</span></label>
                                            <div class="col-sm-8">
                                                <div class="radio radio-success offerTypeBtn" style="margin-left: -3%">
                                                    <input class = "offerTypeButton marginLeft" type="radio" checked="checked" value="1" name="offerType" id="productCategoryBtn">
                                                    <label>CATEGORY</label>
                                                    <input class= "marginLeft offerTypeButton" type="radio"  value="2" name="offerType" id="productSubCategoryBtn">
                                                    <label>SUB CATEGORY</label>
                                                    <input class= "marginLeft offerTypeButton" type="radio"  value="3" name="offerType" id="productBtn">
                                                    <label>PRODUCT</label>
                                                    <!-- <input class= "marginLeft offerTypeButton" type="radio"  value="4" name="offerType" id="productPortionBtn">
                                                    <label>Portion</label> -->
                                                </div>
                                            </div>
                                            <div class="col-sm-2 error-box" id="offerTypeError"></div>
                                        </div>
                                </div>
                            <!-- Category  -->
                             <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 productCategoryClass">
                                    <div class="col-sm-6 form-group removePadding">
                                        
                                            <label for="fname" class="col-sm-3 control-label aligntext">CATEGORY</label>
                                            <div class="col-sm-7">
                                                <select id="productCategoryList" name="company_select" class="form-control" multiple="multiple">
                                                 
                                                </select>
                                            </div>
                                        
                                    </div>
                                <div class="col-sm-3 error-box" id="categoryErrror"></div>
                            </div>

                            <!-- SUB CATEGORY -->
                             <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 productSubCategoryClass hide">
                                    <div class="col-sm-6 form-group removePadding">
                                            <label for="fname" class="col-sm-3 control-label aligntext">SUB CATEGORY</label>
                                            <div class="col-sm-7">
                                                <select id="productSubCategoryList" name="company_select" class="form-control" multiple="multiple">
                                                 
                                                </select>
                                            </div>
                                    </div>
                                <div class="col-sm-3 error-box" id="subCategoryError"></div>
                            </div>

                            <!-- PRODUCT -->
                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10 productClass hide">
                                    <div class="col-sm-6">
                                        <div class="form-group removePadding">
                                            <label for="fname" class="col-sm-3 control-label aligntext">PRODUCT</label>
                                            <div class="col-sm-7">
                                                <select id="productList" name="company_select" class="form-control" multiple="multiple">
                                                 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-sm-3 error-box" id="productListError" style="margin-left:-250px"></div>
                            </div>

                            <!-- PORTION -->
                            <div class="col-md-12 b-b  b-l b-r b-grey p-b-10 p-t-10">
                                    <div class="col-sm-6">
                                        <div class="form-group portionClass hide">
                                            <label for="fname" class="col-sm-3 control-label aligntext">PORTION</label>
                                            <div class="col-sm-7">
                                                <select id="citiesList" name="company_select" class="form-control" >
                                                 <option>Store 1</option>
                                                 <option>Store 2</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-sm-3 error-box" id="portionError"></div>
                            </div>



                                <!-- PAYMENT METHOD TAB END -->

                                <!-- Discount type start -->
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <p class="fontSize marginTop">DISCOUNT TYPE :</p>
                                </div>
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
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6 removePadding">
                                        <div class="form-group  col-xs-12 ">
                                            <label for="fname" class="col-sm-3 control-label amountLabel aligntext" style="margin-left: 3%; margin-right: -4%;">AMOUNT</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="addmemclass1 form-control" id="amount"  placeholder=""   required="" aria-required="true" onkeypress="return isNumberKey(event, 'amount')">                                                                                            
                                                <span class="" id="cityCurrency" style="font-size: small"></span>
                                                <span class= "forPercentage hide percentageSpan" style="font-size: 18px; margin-left: 10px; right:11px; top:0"> % </span>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3 error-box" id="amountError"></div>
                               </div>
                                <div class="col-md-12 col-md-12 b-b b-t b-l b-r b-grey p-b-10 p-t-10 ">
                                    <div class="col-sm-6">
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
                                    TERM & CONDITIONS 
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseTwo" style="height: 0px;">
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
                    </div>

                </div>

            </div>


        </div>


    </div>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>supportFiles/wickedpicker.css">
<script src="<?php echo base_url() ?>supportFiles/wickedpicker.js"></script>
