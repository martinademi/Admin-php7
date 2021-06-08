<link type="text/css" rel="stylesheet" href="<?php echo ServiceLink ?>supportFiles/waitMe.css">
<script src="<?php echo ServiceLink ?>supportFiles/waitMe.js"></script>
<script src="https://cdn.ckeditor.com/4.7.0/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
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
<style>
    .form-horizontal .form-group {
        margin-left: 13px;
    }

    .ui-autocomplete {
        z-index: 5000;
    }

    #selectedcity, #companyid {
        display: none;
    }

    .ui-menu-item {
        cursor: pointer;
        background: black;
        color: white;
        border-bottom: 1px solid white;
        width: 200px;
    }
    span.abs_text {
        position: absolute;
        right:0px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }
    .pos_relative2{
        padding-right:10px
    }
    .pos_relative ,.pos_relative2{
        position: relative;
        padding-right:0px
    }
    .marginSet{
        margin-right: 25px;
    }
    .removeButton{
        margin-left: 10px;
        margin-top: 5px;
    }
    .redClass{
        color:red;
    }
    .btn{
        border-radius: 25px;
    }

    ul.navbar-nav.navbar-left.nav.nav-tabs.nav-tabs-linetriangle.nav-tabs-separator.nav-stack-sm.fixednab {
        position: fixed;
        z-index: 999;
        width: 100%;
        top: 0;
        background: white;
    }

    .multiselect-container>li>a label.checkbox input[type="checkbox"] {
        margin-left: -20px !important;

    }
    .multiselect{
        width: 123% !important;
        border-radius: 0;
        text-align: left;
        font-size: 10px;
    }
    .caret{
        float: right;
        position: relative;
        right: -10px;
    }
    .bootstrap-timepicker-widget table td input{
        width: 60px;

    }

     .panel {
    margin-bottom: 6px;
    }
    .MandatoryMarker{
        color:red;
    }


</style>

<script>
    var curentImageButton;

//here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

    function submitform()
    {
        $('.finishbutton').prop('disabled', true);
        $(".error-box").text("");
        
        var offerId=$('#offerId').val();
        var name = $('#name_0').val();
        var desc = $('#desc_0').val();
        var image = $('#bannerImage').val();
        var cityId = $('#cityId').val();
      //  var store = $('#store').val();
        var store= '<?php echo $storeId;?>';
        var serviceZones = $('#serviceZones').val();
        var applicableOn = $('#applicableOn').val();
        var offerType = $('#offerType').val();
        var minimumPurchaseQuantity = $('#minimumPurchaseQuantity').val();
        var GlobalUsageLimit = $('#GlobalUsageLimit').val();
        var PerUserLimit = $('#PerUserLimit').val();
        var termscond = CKEDITOR.instances['termscond'].getData();
        var howItWorks = CKEDITOR.instances.howItWorks.getData();
        

        //start,end data & time
        var startDate   =  '"' + $("#startDate").val() + ' ' + $("#starttime").val() + ':00"';
        var endDate     =  '"' + $("#endDate").val() + ' ' + $("#endtime").val() + ':00"';
        var parsedStartDate = moment(startDate, 'DD-MM-YYYY H:mm:ss');
        var parsedEndDate = moment(endDate, 'DD-MM-YYYY H:mm:ss');

        if (name == '' || name == null) {
            $('#name_0').focus();
            $('#text_name').text('<?php echo $this->lang->line('error_name'); ?>');
        } else if (desc == '' || desc == null) {
            $('#desc_0').focus();
            $('#text_desc').text('<?php echo $this->lang->line('error_desc'); ?>');
        } 
        // else if (image == '' || image == null) {
        //     $('#image0').focus();
        //     $('#text_images1').text('<?php echo $this->lang->line('error_image'); ?>');
        // } 
        else if (cityId == '' || cityId == null) {
            $('#cityId').focus();
            $('#text_city').text('<?php echo $this->lang->line('error_city'); ?>');
        } else if (store == '' || store == null) {
            $('#store').focus();
            $('#text_store').text('<?php echo $this->lang->line('error_store'); ?>');
        } else if (serviceZones == '' || serviceZones == null) {
            $('#serviceZones').focus();
            $('#text_serviceZones').text('<?php echo $this->lang->line('error_zone'); ?>');
        } else if (applicableOn == '' || applicableOn == null) {
            $('#applicableOn').focus();
            $('#text_applicableOn').text('<?php echo $this->lang->line('error_applicableOn'); ?>');
        } else if (offerType == '' || offerType == null) {
            $('#offerType').focus();
            $('#text_offerType').text('<?php echo $this->lang->line('error_offerType'); ?>');
        } else if (minimumPurchaseQuantity == '' || minimumPurchaseQuantity == null) {
            $('#minimumPurchaseQuantity').focus();
            $('#text_minimumPurchaseQuantity').text('<?php echo $this->lang->line('error_minimumPurchaseQuantity'); ?>');
        } else if (startDate == '' || startDate == null) {
            $('#startDate').focus();
            $('#text_startDate').text('<?php echo $this->lang->line('error_startDate'); ?>');
        } else if (endDate == '' || endDate == null) {
            $('#endDate').focus();
            $('#text_endDate').text('<?php echo $this->lang->line('error_endDate'); ?>');
        } else if (GlobalUsageLimit == '' || GlobalUsageLimit == null) {
            $('#GlobalUsageLimit').focus();
            $('#text_GlobalUsageLimit').text('<?php echo $this->lang->line('error_GlobalUsageLimit'); ?>');
        } else if (PerUserLimit == '' || PerUserLimit == null) {
            $('#PerUserLimit').focus();
            $('#text_PerUserLimit').text('<?php echo $this->lang->line('error_PerUserLimit'); ?>');
        } else if (termscond == '' || termscond == null) {
            $('#termscond').focus();
            $('#text_termscond').text('<?php echo $this->lang->line('error_termscond'); ?>');
        } else if (howItWorks == '' || howItWorks == null) {
            $('#howItWorks').focus();
            $('#text_howitworks').text('Please enter how it works');
        }
        else {
//              $('.finishbutton').prop('disabled', true);
      
            var categoryName = $('#category option:selected').attr('data-name');
            var subCategoryName = $('#subCategory option:selected').attr('data-name');
            var subSubCategoryName = $('#subSubCategory option:selected').attr('data-name');

            // $('#firstCategoryName').val(categoryName);
            // $('#secondCategoryName').val(subCategoryName);
            // $('#thirdCategoryName').val(subSubCategoryName);

            var currentdate = new Date();
            var datetime = currentdate.getFullYear() + "-" + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();

            $('#time_hidden').val(datetime);
            $('#termscond').val(termscond);
            $('#howItWorks').val(howItWorks);

           

            var datainsert=$('#addentity').serialize();
            console.log(datainsert);
            // return;
           
           
             $.ajax({
                  url: "<?php echo base_url(); ?>index.php?/ProductOffers/editNewOffersData",
                    type: "POST",
                    dataType: "JSON",
                    data:datainsert,
                    }).done(function(json) {
                       
                        if(json.data === "Successfully Updated"){
                             window.location.href = "<?php echo base_url(); ?>index.php?/ProductOffers";
                            
                        }   
                        if(json.flag==1){
                         
                        window.location.href = "<?php echo base_url(); ?>index.php?/ProductOffers";
                       


                        }else{
                            
                        }
                }); 
        }
    }



</script>

<script>

    var OnlymobileNo;
    var CountryCodeMobileNo;
    var zoneIds=[];

     ///only for number
  function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                    }
                return true;
    }

    function redirectToDest() {
        window.location.href = "<?php echo base_url('index.php?/Uflyproducts/') ?>";
    }

    $(document).ready(function () {
        var zoneIds=[];

        $(window).scroll(function () {
            var scr = jQuery(window).scrollTop();

            if (scr > 0) {
                $('#mytabss').addClass('fixednab');
            } else {
                $('#mytabss').removeClass('fixednab');
            }
        });


        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });

        var date = new Date();
        $('.datepicker-component').datepicker({
            // startDate: date,
            format: 'dd-mm-yyyy'
        });

        $('.error-box-class ').keypress(function () {
            $('.error-box').text('');
        });
        $('.error-box-class ').change(function () {
            $('.error-box').text('');
        });

        $(document).on('change', '.imagesBanner', function () {

            $('#text_images1').text("");
            var fieldID = $(this).attr('attrId');
            var ext = $(this).val().split('.').pop().toLowerCase();
            var formElement = $(this).prop('files')[0];
            // 

            uploadImage(fieldID, ext, formElement);

        });

        $(document).on('change', '.webimagesBanner', function () {
            
            $('#webtext_images1').text("");
            var fieldID = $(this).attr('attrId');
            var ext = $(this).val().split('.').pop().toLowerCase();
            var formElement = $(this).prop('files')[0];
            uploadImage(fieldID, ext, formElement);

        });

        $('#cityId').on('change', function () {
            
            var val = $(this).val();
            // 
            // for franchise  
            $('#franchise').load("<?php echo base_url('index.php?/productOffers') ?>/getFranchiseData", {val: val});
            // for stores   
            $('#store').load("<?php echo base_url('index.php?/productOffers') ?>/getStoreData", {val: val});
            // fore zones
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/getZones",
                type: 'POST',
                dataType: 'json',
                data: {
                    val: val
                },
            }).done(function (json) {
                // 
                $("#serviceZones").multiselect('destroy');
                

                if (json.data.length > 0) {
                    for (var i = 0; i < json.data.length; i++) {
                        zoneIds.push(json.data[i].id);
                        var serviceZone = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
                        $("#serviceZones").append(serviceZone);
                    }
                    $('#serviceZones').multiselect({
                        includeSelectAllOption: true,
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering: true,
                        buttonWidth: '500px',
                        maxHeight: 300,
                    });
                } else {
                }

            });
        });

        $('.flatDiscount').hide();
        $('.percentageDiscount').hide();
        $('.freeProductDiscount').hide();

        $('#offerType').on('change', function () {


            var val = $(this).val();
            if (val == 0) { // flat Discount
                $('.flatDiscount').show();
                $('.percentageDiscount').hide();
                $('.freeProductDiscount').hide();
            } else if (val == 1) { // percentage discount

                $('.percentageDiscount').show();
                $('.freeProductDiscount').hide();
                $('.flatDiscount').hide();
            } else if (val == 2) { // combo

                $('.freeProductDiscount').show();
                $('.flatDiscount').hide();
                $('.percentageDiscount').hide();
            }

        });

      
        $('.firstCategory,.secondCategory,.thirdCategory,.products').hide();

        // $(document).on('change', '#applicableOn', function () {

        //     var storeId = $('#store').val();
        //     var val = $(this).val();
        //     $("#serviceZonesHidden").val(zoneIds);
        //     if (val == 0) {
                
        //         $('.firstCategory,.secondCategory,.thirdCategory,.unit').hide();
        //         $('.products').show();

        //         $.ajax({
        //             url: "<?php echo base_url('index.php?/productOffers') ?>/getProductData",
        //             type: 'POST',
        //             dataType: 'json',
        //             data: {
        //                 val: storeId
        //             },
        //         }).done(function (json) {
        //             $("#productIds").multiselect('destroy');

        //             if (json.data.length > 0) {
        //                 for (var i = 0; i < json.data.length; i++) {
        //                     var products = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
        //                     $("#productIds").append(products);
        //                 }
        //                 $('#productIds').multiselect({
        //                     includeSelectAllOption: true,
        //                     enableFiltering: true,
        //                     enableCaseInsensitiveFiltering: true,
        //                     buttonWidth: '500px',
        //                     maxHeight: 300,
        //                 });
        //             } else {
        //             }

        //         });
        //     }else if(val == 1){
        //         $('.firstCategory,.secondCategory,.thirdCategory,.products').hide();
           
        //     }else if(val == 2){
            
        //     $('.products,.secondCategory,.thirdCategory,.unit').hide();
        //     $('.firstCategory').show();
                
        //         $.ajax({
        //             url: "<?php echo base_url('index.php?/productOffers') ?>/getCategoryData",
        //             type: 'POST',
        //             dataType: 'json',
        //             data: {
        //                 val: storeId
        //             },
        //         }).done(function (json) {
        //             $("#category").multiselect('destroy');

        //            if (json.data.length > 0) {
        //                 for (var i = 0; i < json.data.length; i++) {
        //                     var category = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
        //                     $("#category").append(category);
        //                 }
        //                 $('#category').multiselect({
        //                     includeSelectAllOption: true,
        //                     enableFiltering: true,
        //                     enableCaseInsensitiveFiltering: true,
        //                     buttonWidth: '500px',
        //                     maxHeight: 300,
        //                 });
        //             } else {
        //             }    

        //         });
        //     }else if(val == 3){
               
              
        //       $('.products,.firstCategory,.thirdCategory,.unit').hide();
        //       $('.secondCategory').show();
                
        //         $.ajax({
        //             url: "<?php echo base_url('index.php?/productOffers') ?>/getSubCategoryData",
        //             type: 'POST',
        //             dataType: 'json',
        //             data: {
        //                 val: storeId
        //             },
        //         }).done(function (json) {
                   
        //             $("#subCategory").multiselect('destroy');

        //             if (json.data.length > 0) {
        //                 for (var i = 0; i < json.data.length; i++) {
        //                     var subCategory = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
        //                     $("#subCategory").append(subCategory);
        //                 }
        //                 $('#subCategory').multiselect({
        //                     includeSelectAllOption: true,
        //                     enableFiltering: true,
        //                     enableCaseInsensitiveFiltering: true,
        //                     buttonWidth: '500px',
        //                     maxHeight: 300,
        //                 });
        //             } else {
        //             }     

        //         });
        //     }else if(val == 4){
        //         $('.products,.firstCategory,.secondCategory,.unit').hide();
        //      $('.thirdCategory').show();
        
        //    $.ajax({
        //             url: "<?php echo base_url('index.php?/productOffers') ?>/getSubSubCategoryData",
        //             type: 'POST',
        //             dataType: 'json',
        //             data: {
        //                 val: storeId
        //             },
        //         }).done(function (json) {
        //            $("#subSubCategory").multiselect('destroy');

        //             if (json.data.length > 0) {
        //                 for (var i = 0; i < json.data.length; i++) {
        //                     var subSubCategory = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
        //                     $("#subSubCategory").append(subSubCategory);
        //                 }
        //                 $('#subSubCategory').multiselect({
        //                     includeSelectAllOption: true,
        //                     enableFiltering: true,
        //                     enableCaseInsensitiveFiltering: true,
        //                     buttonWidth: '500px',
        //                     maxHeight: 300,
        //                 });
        //             } else {
        //             }    

        //         });
        //     }

        // });



      

        $("#mobile").on("countrychange", function (e, countryData) {
            $("#coutry-code").val(countryData.dialCode);
        });

        $("#name").keypress(function (event) {
            var inputValue = event.which;
            //if digits or not a space then don't let keypress work.
            if ((inputValue > 64 && inputValue < 91) // uppercase
                    || (inputValue > 96 && inputValue < 123) // lowercase
                    || inputValue == 32) { // space
                return;
            }
            event.preventDefault();
        });

        $("#lastname").keypress(function (event) {
            var inputValue = event.which;
            //if digits or not a space then don't let keypress work.
            if ((inputValue > 64 && inputValue < 91) // uppercase
                    || (inputValue > 96 && inputValue < 123) // lowercase
                    || inputValue == 32) { // space
                return;
            }
            event.preventDefault();
        });


        /* activate scrollspy menu */
        $('body').scrollspy({
            target: '#navbar-collapsible',
            offset: 50
        });

        /* smooth scrolling sections */
        $('a[href*=#]:not([href=#])').click(function () {
            var scr = jQuery(window).scrollTop();
            if (scr > 50) {
                $('#mytabss').addClass('fixednab');
            } else {
                $('#mytabss').removeClass('fixednab');
            }

            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top - 50
                    }, 1000);
                    return false;
                }
            }
        });

 
           //based on product change
        //unitdiff
        $('#uproductIds').on('change',function(){

             var val = $(this).val();
             
             //units
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/productOffers/getUnitsData",
                type: 'POST',
                dataType: 'json',
                data: {
                    val: val.toString(),
                },
            }).done(function (json) {
                var productoffer=json.data[0];
                 
                $("#uproductIdsdetails").multiselect('destroy');
                $("#uproductIdsdetails").empty();

                if (json.data.length > 0) {
                    for (var i = 0; i < json.data.length; i++) {
                        var unitproduct = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
                        $("#uproductIdsdetails").append(unitproduct);
                    }
                    $('#uproductIdsdetails').multiselect({
                        includeSelectAllOption: true,
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering: true,
                        buttonWidth: '500px',
                        maxHeight: 300,
                    });

                    // //chnages to be done here for autoselecy
                    //     $.each( productoffer.products, function(index,val){
                    //                     var product=val["productId"];
                    //                     $('#uproductIdsdetails').multiselect('select', product);
                    //                  });
                 
                } else {
                }

            });


        });
 });

    function uploadImage(fieldID, ext, formElement)
    {
        $('.modalPopUpText').text('');

        if ($.inArray(ext, ['jpg', 'JPEG','png']) == -1) {
            $('#errorModal').modal('show');
            var k = $('.imageTag').length;
            $("#image" + k).val("");
            $('.modalPopUpText').text('Image format not supported');
        } else
        {
            var form_data = new FormData();
            /* chages*/
            var file_data = $('#image0').prop('files')[0];
                form_data.append('OtherPhoto', file_data);
                form_data.append('type', 'uploadImage');
                form_data.append('Image', 'Image');
                form_data.append('folder', 'offers');
                
            /*chnges end*/
            var amazonPath = "<?php echo AMAZON_URL; ?>"
            form_data.append('sampleFile', formElement);
            $(document).ajaxStart(function () {
                $("#wait").css("display", "block");
            });
            $.ajax({
               
                url: "<?php echo base_url(); ?>index.php?/Common/uploadImagesToAws",
                type: "POST",
                data: form_data,
                dataType: "JSON",

                beforeSend: function () {

                },
                success: function (response) {
                    
//                    
        
                   // if (response.code == '200') {
                    if (response.msg === "1") {
                        
                        $.each(response, function (index, val) {
                            
                            // switch (index) {
                            //     case 0:
                            //         $('#thumbnailImages' + fieldID + '').val(amazonPath + row.fileName);
                            //         break;
                            //     case 1:
                            //         $('#mobileImages' + fieldID + '').val(amazonPath + row.fileName);
                            //         break;
                            //     case 2:
                            //         $('#defaultImages' + fieldID + '').val(amazonPath + row.fileName);
                            //         break;
                            // }
                            $('#thumbnailImages' + fieldID + '').val(val);
                            $('#mobileImages' + fieldID + '').val(val);
                            $('#defaultImages' + fieldID + '').val(val);

                            $(document).ajaxComplete(function () {
                                $("#wait").css("display", "none");
                            });

//                            $('.finishbutton').removeAttr('disabled');
//                            $('.finishbutton').removeClass("disabled");
//                            $('.finishbutton').prop('disabled', false)

                        });
                    }
                },
                error: function () {

                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    }

    // function generateRandomString() {
    //     var text = "";
    //     var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    //     for (var i = 0; i < 10; i++)
    //         text += possible.charAt(Math.floor(Math.random() * possible.length));
    //     return text;
    // }


function getAllDetails(){
    //to fill form using ajajx
    $.ajax({
                url: "<?php echo ProductOffers ?>" + 'offerdetails/' + "<?php echo $campaignId ?>",
                type: "GET",
                dataType: "JSON",
               contentType: "application/json; charset=utf-8",
                data: '',

            }).done(function(json) {
                console.log(json);
                var productoffer=json.data[0];

                console.log(productoffer);
               if (json.message == "success") {

                   
                   $("#offerId").val(productoffer.offerId);
                   $("#name_0").val(productoffer.name['en']);
                   
                        <?php foreach ($language as $val) { ?>
                                $('#name_<?= $val['lan_id'] ?>').val(productoffer.name['<?= $val['langCode'] ?>']);
                                //<input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['langCode'] ?>]"
                        <?php } ?>
                                        
                        <?php foreach ($language as $val) { ?>
                                $('#desc_<?= $val['lan_id'] ?>').val(productoffer.description['<?= $val['langCode'] ?>']);
                                                    
                        <?php } ?>
                   
                   $("#desc_0").val(productoffer.description.en);
                   $("#minimumPurchaseQuantity").val(productoffer.minimumPurchaseQty);
                   $("#GlobalUsageLimit").val(productoffer.globalUsageLimit);
                   $("#PerUserLimit").val(productoffer.perUserLimit);
                   $("#FlatDiscount").val(productoffer.discountValue);
                   $("#PercentageDiscount").val(productoffer.discountValue);
                   //images
                   var imagelink=productoffer.images["image"];
                   //
                   
                   $("#bannerImage").val(imagelink);
                   
                   $("#myImg").attr('src', imagelink);
                   $('#thumbnailImages0').val(productoffer.images["image"]);
                   $('#mobileImages0').val(productoffer.images["mobile"]);
                   $('#defaultImages0').val(productoffer.images["thumbnail"]);

                    // web images changes
                   $('#thumbnailImages1').val(productoffer.images["image"]);
                   $('#mobileImages1').val(productoffer.images["mobile"]);
                   $('#defaultImages1').val(productoffer.images["thumbnail"]);

                  //get store list
                   $('#store').load("<?php echo base_url('index.php?/productOffers') ?>/getStoreData", {val: productoffer.city});
                    //get frnchise
                   $('#franchise').load("<?php echo base_url('index.php?/productOffers') ?>/getFranchiseData", {val: productoffer.city,fid:productoffer.franchise});
                   
                   //$('#franchise').load("<?php echo base_url('index.php?/productOffers') ?>/getFranchiseData", {val: productoffer.city,fid:productoffer.franchise});
                   citiesList(productoffer);

                 
                

                   //store name id storeName,storeId
                   

                   //start date
                //    var startdate=productoffer.startDateTimeISO;
                //    var res = startdate.split("T");
                //    $("#startDate").val(res[0]); 
                //    $("#starttime").val(res[1].substr(0,5)); 
                  
                // var offset = new Date().getTimezoneOffset();
               
                var d = new Date((productoffer.startDateTime)*1000);
                   
                    var start_Date =d.getDate()+ '-' + (d.getMonth()+1)+ '-' + d.getFullYear() ;
                    // d.setMinutes(d.getMinutes() + offset);
                    var start_Time = d.getHours()+':'+d.getMinutes();
                    
                        $("#startDate").datepicker("update",'5-3-2019'); 
                        $("#starttime").timepicker('setTime', start_Time);




                   //enddate
                //    var enddate=productoffer.endDateTimeISO;
                //    var resend = enddate.split("T");
                var ed = new Date((productoffer.endDateTime)*1000);
                    var end_Date =ed.getDate()+ '-' + (ed.getMonth()+1)+ '-' + ed.getFullYear();
                    // ed.setMinutes(ed.getMinutes() + offset);
                    var end_Time = ed.getHours()+':'+ed.getMinutes();
                   $("#endDate").datepicker("update",end_Date);
                   $("#endtime").timepicker('setTime', end_Time);

                    //csk editor
                    var termsdata=productoffer["termscond"];
                   // 
                    CKEDITOR.instances.termscond.setData(termsdata);


                     //csk editor
                    var howItworkdata=productoffer["howItWorkofferStatuss"];
                   // 
                   console.log(howItworkdata);
                    CKEDITOR.instances.howItWorks.setData(howItworkdata);

                   

                    /*applicalble on*/

                   // 
                    if(productoffer["applicableOn"]==0){
                        $('.firstCategory,.secondCategory,.thirdCategory,.unit').hide();
                         $('.products').show();
                         $("#applicableOn").val(0);
                         

                        /*changes strt*/

                            $.ajax({
                                    url: "<?php echo base_url('index.php?/productOffers') ?>/getProductData",
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        val: productoffer.storeId
                                    },
                                }).done(function (json) {
                                    $("#productIds").multiselect('destroy');

                                    if (json.data.length > 0) {
                                        for (var i = 0; i < json.data.length; i++) {
                                            var products = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
                                            $("#productIds").append(products);
                                        }
                                        $('#productIds').multiselect({
                                            includeSelectAllOption: true,
                                            enableFiltering: true,
                                            enableCaseInsensitiveFiltering: true,
                                            buttonWidth: '500px',
                                            maxHeight: 300,
                                        });
                                        // 
                                     $.each( productoffer.products, function(index,val){
                                        var product=val["productId"];
                                        $('#productIds').multiselect('select', product);
                                     });


                                    } else {
                                    }
                                });
                        /*chages end*/


                    }else if(productoffer["applicableOn"]==1){
                        $('.firstCategory,.secondCategory,.thirdCategory,.products').hide();
                        $('.unit').show();
                        $("#applicableOn").val(1);

                        //chnage strt
                $.ajax({
                    url: "<?php echo base_url('index.php?/productOffers') ?>/getProductData",
                    type: 'POST',
                    dataType: 'json',
                    async: false,
                    data: {
                        val: productoffer.storeId
                    },
                    success:function(json)
                    {
                        $("#uproductIds").multiselect('destroy');

                    if (json.data.length > 0) {
                        for (var i = 0; i < json.data.length; i++) {
                            var products = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
                            $("#uproductIds").append(products);
                        }
                        $('#uproductIds').multiselect({
                            includeSelectAllOption: true,
                            enableFiltering: true,
                            enableCaseInsensitiveFiltering: true,
                            buttonWidth: '500px',
                            maxHeight: 300,
                            
                        });
                        var unitproduct ="";
                        var productofferData =new Array();
                        $("#uproductIdsdetails").empty();
                         // selecting product from multiselect
                              $.each( productoffer.products, function(index1,val){
                                        var product=val["productId"];
                                        $("#uproductIdsdetails").empty();
                                        $('#uproductIds').multiselect('select', product);

                                            
                                         //units
                                            
                                         $.ajax({
                                                url: "<?php echo base_url() ?>index.php?/productOffers/getUnitsData",
                                                type: 'POST',
                                                dataType: 'json',
                                                async: false,
                                                data: {
                                                    val: product.toString(),
                                                },
                                                success: function (json)
                                                {
                                                    console.log('units displayed',json);
                                                    console.log(json.data);
                                                
                                                   
                                                // $("#uproductIdsdetails").multiselect('destroy');

                                                if (json.data.length > 0) {
                                                    
                                                    
                                                    // for (var i = 0; i < json.data.length; i++) {
                                                        $.each( json.data, function(index,val){
                                                            unitproduct += "<option value=" + json.data[index].id + ">" + json.data[index].title + "</option>";
                                                            productofferData.push(json.data[index].id);
                                                    });  
                                                    $("#uproductIdsdetails").append(unitproduct);
                                                   
                                                } 
                                                }
                                            });
                                           
                                        
                                         });
                                         $('#uproductIdsdetails').multiselect({
                                                        includeSelectAllOption: true,
                                                        enableFiltering: true,
                                                        enableCaseInsensitiveFiltering: true,
                                                        buttonWidth: '500px',
                                                        maxHeight: 300,
                                                    });
                                                   
                                                    //chnages to be done here for autoselect
                                                      console.log('show product---',productofferData);
                                                            $.each( productoffer.products, function(index,val){
                                                                        var product1=val['final_unitlist'];
                                                                       $('#uproductIdsdetails').multiselect('select', product1);
                                                                    });
                                       
                                         
                                         
                            

                        }
                    }
                    
                })

                //chnage end
                    }
                    else if(productoffer["applicableOn"]==2){
                        $('.products,.secondCategory,.thirdCategory,.unit').hide();
                        $('.firstCategory').show();
                        $("#applicableOn").val(2);
                        
                        /*changes strt*/
                                $.ajax({
                                    url: "<?php echo base_url('index.php?/productOffers') ?>/getCategoryData",
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        val: productoffer.storeId
                                    },
                                }).done(function (json) {
                                    $("#category").multiselect('destroy');

                                        if (json.data.length > 0) {
                                                for (var i = 0; i < json.data.length; i++) {
                                                    var category = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
                                                    $("#category").append(category);
                                                }
                                                $('#category').multiselect({
                                                    includeSelectAllOption: true,
                                                    enableFiltering: true,
                                                    enableCaseInsensitiveFiltering: true,
                                                    buttonWidth: '500px',
                                                    maxHeight: 300,
                                                });
                                                //multi selwect chnage
                                        $.each( productoffer.products, function(index,val){
                                                var product=val["firstCategoryId"];
                                                $('#category').multiselect('select', product);
                                        });

                                            } else {
                                                $("#applicableOn").prop('selectedIndex',0);
                                                $(".modalPopUpText").text("No category found.");
                                                $("#errorModal").modal('show');
                                            }    

                                });
                        /*chnages end*/
                    }else if(productoffer["applicableOn"]==3){
                        $('.products,.firstCategory,.thirdCategory,.unit').hide();
                        $('.secondCategory').show();
                        $("#applicableOn").val(3);

                        /*change sstr*/
                                $.ajax({
                                    url: "<?php echo base_url('index.php?/productOffers') ?>/getSubCategoryData",
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        val: productoffer.storeId
                                    },
                            }).done(function (json) {
                                 $("#subCategory").multiselect('destroy');
                                if (json.data.length > 0) {
                                        for (var i = 0; i < json.data.length; i++) {
                                            var subCategory = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
                                            $("#subCategory").append(subCategory);
                                        }
                                        $('#subCategory').multiselect({
                                            includeSelectAllOption: true,
                                            enableFiltering: true,
                                            enableCaseInsensitiveFiltering: true,
                                            buttonWidth: '500px',
                                            maxHeight: 300,
                                        });
                                        //multi selwect chnage
                                        $.each( productoffer.products, function(index,val){
                                                var product=val["secondCategoryId"];
                                                $('#subCategory').multiselect('select', product);
                                        });

                                } else {
                                    $("#applicableOn").prop('selectedIndex',0);
                                    $(".modalPopUpText").text("No sub category found.");
                                    $("#errorModal").modal('show');
                                }     

                            });
                        /*chnage send*/
                     }else if(productoffer["applicableOn"]==4){
                        $('.products,.firstCategory,.secondCategory,.unit').hide();
                        $('.thirdCategory').show();
                        $("#applicableOn").val(4);

                        /*change strt*/
                        $.ajax({
                                url: "<?php echo base_url('index.php?/productOffers') ?>/getSubSubCategoryData",
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    val: productoffer.storeId
                                },
                            }).done(function (json) {
                            $("#subSubCategory").multiselect('destroy');

                                if (json.data.length > 0) {
                                    for (var i = 0; i < json.data.length; i++) {
                                        var subSubCategory = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
                                        $("#subSubCategory").append(subSubCategory);
                                    }
                                    $('#subSubCategory').multiselect({
                                        includeSelectAllOption: true,
                                        enableFiltering: true,
                                        enableCaseInsensitiveFiltering: true,
                                        buttonWidth: '500px',
                                        maxHeight: 300,
                                    });
                                     //multi selwect chnage
                                        $.each( productoffer.products, function(index,val){
                                                var product=val["thirdCategoryId"];
                                                $('#subSubCategory').multiselect('select', product);
                                        });

                                } else {
                                    $("#applicableOn").prop('selectedIndex',0);
                                    $(".modalPopUpText").text("No sub sub category found.");
                                    $("#errorModal").modal('show');
                                }    

                            });
                        /*chnages end*/

                    }
                    /*applicalble on end*/

                    /*offert type*/
                   
                   

                    if(productoffer["offerType"]==0){
                        $('.flatDiscount').show();
                        $('.percentageDiscount').hide();
                        $('.freeProductDiscount').hide();
                        
                         $("#offerType").val(0);
                    }else if(productoffer["offerType"]==1){
                        $('.percentageDiscount').show();
                        $('.freeProductDiscount').hide();
                        $('.flatDiscount').hide();
                        
                        $("#offerType").val(1);
                    }else if(productoffer["offerType"]==2){
                        $('.freeProductDiscount').show();
                        $('.flatDiscount').hide();
                        $('.percentageDiscount').hide();
                                
                        $("#offerType").val(2);

                                    $.ajax({
                                url: "<?php echo base_url('index.php?/productOffers') ?>/getProductData",
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    val: productoffer.storeId
                                },
                            }).done(function (json) {
                                $("#freeProductsDiscount").multiselect('destroy');

                                if (json.data.length > 0) {
                                    for (var i = 0; i < json.data.length; i++) {
                                        var products = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
                                        $("#freeProductsDiscount").append(products);
                                    }
                                    $('#freeProductsDiscount').multiselect({
                                        includeSelectAllOption: true,
                                        enableFiltering: true,
                                        enableCaseInsensitiveFiltering: true,
                                        buttonWidth: '500px',
                                        maxHeight: 300,
                                        });

                                            /*chnage to be made*/
                                                $.each( productoffer.products, function(index,val){
                                                    var product=val["thirdCategoryId"];
                                                    $('#freeProductsDiscount').multiselect('select', product);
                                                });
                                                        
                                } else {
                                }

                            });

                    }
                    /*offer type end*/
                   
                }
                
});
}         
/*changes start*/
function citiesList(productoffer){
     //cityid
     var cityId = productoffer.city;
        $.ajax({    
                    url: "<?php echo ProductOffers ?>" + "cities",
                    type: 'GET',
                    dataType: 'json',
                    data: {                  
                    },
                }).done(function(json) {

                    $("#cityId").html('<option value="" disabled selected>Select City</option>');
                        
                        for (var i = 0; i< json.length; i++) {
                           var citiesList = "<option value="+ json[i].cityId.$oid + ">"+  json[i].cityName +"</option>";
                            $("#cityId").append(citiesList);  
                        }

                        $("#cityId").val(cityId);
                        $("#cityIdHidden").val(cityId);
                        //call franchise api 
                        //$('#franchise').load("<?php echo base_url('index.php?/productOffers') ?>/getFranchiseData", {val: cityId});
                        //call store api
                       
                       
                        // for zones
                        $.ajax({
                            url: "<?php echo base_url() ?>index.php?/superadmin/getZones",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                val: cityId
                            },
                        }).done(function (json) {
                            // 
                            $("#serviceZones").multiselect('destroy');

                            if (json.data.length > 0) {
                                for (var i = 0; i < json.data.length; i++) {
                                    var serviceZone = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
                                    $("#serviceZones").append(serviceZone);
                                }
                                $('#serviceZones').multiselect({
                                    includeSelectAllOption: true,
                                    enableFiltering: true,
                                    enableCaseInsensitiveFiltering: true,
                                    buttonWidth: '500px',
                                    maxHeight: 300,
                                });
                                 //multiselect
                                 //sevice zone
                                $.each( productoffer.zones, function(index,val){
                                    var zone=val;
                                    //hidden
                                    zoneIds.push(val);
                                    
                                    $('#serviceZonesHidden').val(val);
                                    $('#serviceZones').multiselect('select', zone);
                                });
                                
                            } 
                            
                            else {
                            }

                        });
                        
                        //$('#franchise').val(productoffer.franchise);
                        $("#franchiseHidden").val(productoffer.franchise);

                        $('#store').val(productoffer.storeId);
                        $("#storeHidden").val(productoffer.storeId);

                       
                });
     }



/*changes end*/

</script>


<div class="page-content-wrapper">
    <!-- START BREADCRUMB -->
    <div class="brand inline" style="  width: auto;
             font-size: 16px;
             color: gray;
             margin-left: 7px;padding-top: 20px;">

            <?php echo $this->lang->line('heading_editPage'); ?>
    </div>
    <ul class="breadcrumb" style="margin-left: 0px; margin-top: 1%;">
        <li><a
                href="<?php echo base_url(); ?>index.php?/ProductOffers"
                class=""><?php echo $this->lang->line('heading_page'); ?></a></li>

        <li style="width: 100px"><a href="#" class="active"><?php echo $this->lang->line('heading_edit'); ?></a>
        </li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class=" bg-white" data-pages="parallax">
            <div class="inner"></div>

            <div class="container-fluid container-fixed-lg bg-white">
                <!--id="rootwizard"-->
                

                <div id="navbar-collapsible"  class="navbar-collapse collapse m-t-50">
                    <!-- Nav tabs -->
                    <!--                    <ul class="navbar-nav navbar-left nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabss" style=" -webkit-transition: top .5s; transition: top .5s;">
                    
                                            <li class="active" >
                                                <a class="" data-toggle="tab" role="tab" href="#tab1" >
                                                    <span><?php echo $this->lang->line('LIST_PRODUCT_GENERALDETAILS'); ?></span></a>
                                            </li>
                                            <li>
                                                <a class=""data-toggle="tab" role="tab" href="#tab2" >
                                                    <span><?php echo $this->lang->line('LIST_PRODUCT_UNITS'); ?></span></a>
                                            </li>
                                            <li>
                                                <a class="" data-toggle="tab" role="tab" href="#tab3" >
                                                    <span><?php echo $this->lang->line('LIST_STRAIN_ATTRIBUTES_AND_FLAVOURS'); ?></span></a>
                                            </li>
                                            <li>
                                                <a class="" data-toggle="tab" role="tab" href="#tab4" >
                                                    <span><?php echo $this->lang->line('LIST_PRODUCT_IMAGES'); ?></span></a>
                                            </li>
                    
                                        </ul>-->
                    <div class="row"><br></div>

                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form"
                          action="<?php echo base_url(); ?>index.php?/ProductOffers/editNewOffersData"
                          method="post" enctype="multipart/form-data" onsubmit="return redirectToDest()">


                        <div class="tab-content">
                            <section class="" id="tab1">
                                <div class="row row-same-height">
                                <div class="row">
                                        <div class="form-group pos_relative2" style="display:none">
                                            <label for="fname" class="col-sm-2 control-label error-box-class ">ID<span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input type="text" id="offerId" name="offerId"  class="error-box-class  form-control">

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label error-box-class "><?php echo $this->lang->line('label_Name'); ?> (English)<span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input type="text" id="name_0" name="name[en]" required="required" class="error-box-class  form-control">

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                        foreach ($language as $val) {
                                            if ($val['Active'] == 1) {
                                                ?>
                                                <div class="form-group pos_relative2">
                                                    <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                    <div class="col-sm-6 pos_relative2">

                                                        <input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['langCode'] ?>]"
                                                               required="required" class="error-box-class  form-control">

                                                    </div>
                                                    <div class="col-sm-3 error-box" id="text_namelan"></div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group pos_relative2" style="display:none;">
                                                    <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                    <div class="col-sm-6 pos_relative2">

                                                        <input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['langCode'] ?>]"
                                                               required="required" class="error-box-class  form-control">

                                                    </div>
                                                    <div class="col-sm-3 error-box" id="text_namelan"></div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="row">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label error-box-class "><?php echo $this->lang->line('label_Desc'); ?> (English)<span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input type="text" id="desc_0" name="description[en]" required="required" class="error-box-class  form-control">

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_desc"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                        foreach ($language as $val) {
                                            if ($val['Active'] == 1) {
                                                ?>
                                                <div class="form-group pos_relative2">
                                                    <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                    <div class="col-sm-6 pos_relative2">

                                                        <input type="text" id="desc_<?= $val['lan_id'] ?>" name="description[<?= $val['langCode'] ?>]"
                                                               required="required" class="error-box-class  form-control">

                                                    </div>
                                                    <div class="col-sm-3 error-box" id="text_desclan"></div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="form-group pos_relative2" style="display:none;">
                                                    <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                    <div class="col-sm-6 pos_relative2">

                                                        <input type="text" id="desc_<?= $val['lan_id'] ?>" name="description[<?= $val['langCode'] ?>]"
                                                               required="required" class="error-box-class  form-control">

                                                    </div>
                                                    <div class="col-sm-3 error-box" id="text_desclan"></div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="row">
                                        <div class="imagesField">
                                            <div class="form-group pos_relative2">
                                                <label id="td1" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Image'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                <div class="col-sm-6 pos_relative2">
                                                    <input type="file" name="imageupload" class="error-box-class form-control imagesBanner" id="image0" attrId="0" value="Text Element 1">
                                                   
                                                    <div class="col-sm-6 error-box redClass" id="text_images1"></div>
                                                </div>

                                                &nbsp;
                                                

                                                <input type="hidden" id="thumbnailImages0"  name="images[thumbnail]"/>
                                                <input type="hidden" id="mobileImages0"  name="images[mobile]"/>
                                                <input type="hidden" id="defaultImages0"  name="images[image]"/>
                                                <!--<div class="col-sm-3 error-box" id="text_image"></div>-->
                                            </div>

                                           


                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="imagesField">
                                            <div class="form-group pos_relative2">
                                                <label id="td1" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('weblabel_Image'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                <div class="col-sm-6 pos_relative2">
                                                    <input type="file" name="imageupload" class="error-box-class form-control webimagesBanner" id="image0" attrId="1" value="Text Element 1">
                                                    <div class="col-sm-6 error-box redClass" id="webtext_images1"></div>
                                                </div>

                                                &nbsp;
                                                <input type="hidden" id="thumbnailImages1"  name="webimages[thumbnail]"/>
                                                <input type="hidden" id="mobileImages1"  name="webimages[mobile]"/>
                                                <input type="hidden" id="defaultImages1"  name="webimages[image]"/>
                                              
                                              
                                            </div>

                                        </div>
                                    </div>

                                    <!--image uplodad-->
                                   
                                    <div class="row">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label">Image:</label>
                                            <div class="col-sm-6 pos_relative2">
                                                <div class="gallery"></div>
                                                    <img id="myImg" src="" height="40" width="40"/>
                                                </div>
                                             </div>
                                       </div>
                                        <!--image end-->
                                        <input type="hidden" name="cityId" id="cityIdHidden" class="form-control error-box-class" val ="">

                                    <div class="row">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_City'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">
                                                <select id="cityId" name="cityId2"  class="form-control error-box-class" onchange="defaultvalue()" disabled> 
                                                    
                                                </select> 


                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_city"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    
                                    <input type="hidden" name="franchiseId" id="franchiseHidden" class="form-control error-box-class" val ="">

                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Franchise'); ?></label>
                                            <div class="col-sm-6 pos_relative2">
                                                <select id="franchise" name="franchiseId"  class="form-control error-box-class" disabled>
                                                    <option data-name="" value=""><?php echo $this->lang->line('label_SelectFranchise'); ?></option>

                                                </select>  

                                            </div>
                                            <div class="col-sm-3 error-box" id="text_subCategory"></div>
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="form-group">

                                        <input type="hidden" name="serviceZones[]" id="serviceZonesHidden" class="form-control error-box-class" val ="">

                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ServiceZones'); ?><span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <select  id='serviceZones' name='serviceZones2[]' class='errr11 form-control serviceZones error-box-class' multiple="multiple" disabled >
                                                </select>
                                            </div> 
                                            <div class="col-sm-3 error-box text_err" id="text_serviceZones" style="color:red"></div>                                       
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- <div class="form-group pos_relative2">

                                         <input type="hidden" name="storeId" id="storeHidden" class="form-control error-box-class" val ="">

                                            <label for="fname" class="col-sm-2 control-label"><?php //echo $this->lang->line('label_Store'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">
                                                <select id="store" name="storeId"  class="form-control error-box-class" store disabled>
                                                    

                                                </select>  

                                            </div>
                                            <div class="col-sm-3 error-box" id="text_store"></div>
                                        </div> -->
                                        <input type="hidden" name="storeId" value="<?php echo $storeId;?>"/>
                                    </div>
                                    <div class="row">

                                        <!--0 - Product, 1 - Unit, 2 - Category, 3 - Sub Category, 4 -Sub-Sub Category-->
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ApplicableOn'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">
                                                <select id="applicableOn" name="applicableOn"  class="form-control error-box-class" >
                                                    <option data-name="" value=""><?php echo $this->lang->line('label_Select'); ?></option>
                                                    <option data-name="Product" value="0">Product</option>
                                                    <option data-name="Unit" value="1">Unit</option>
                                                    <option data-name="Category" value="2">Category</option>
                                                    <option data-name="Sub Category" value="3">Sub Category</option>
                                                    <option data-name="Sub-Sub Category" value="4">Sub-Sub Category</option>

                                                </select>  

                                            </div>
                                            <div class="col-sm-3 error-box" id="text_applicableOn"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!--offerType : 0 - Flat Discount, 1 - Percentage Discount, 2 - Combo-->
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_OfferType'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">
                                                <select id="offerType" name="offerType"  class="form-control error-box-class">
                                                    <option data-name="" value=""><?php echo $this->lang->line('label_Select'); ?></option>
                                                    <option data-name="pickUp" value="0">Flat Discount</option>
                                                    <option data-name="delivery" value="1">Percentage Discount</option>
                                                    <option data-name="both" value="2">Combo</option>
                                                </select>  

                                            </div>
                                            <div class="col-sm-3 error-box" id="text_offerType"></div>
                                        </div>
                                    </div>
                                    <div class="row percentageDiscount">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label error-box-class "><?php echo $this->lang->line('label_PercentageDiscount'); ?> </label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input type="text" id="PercentageDiscount" name="percentageDiscount" required="required" class="error-box-class  form-control">

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                        </div>
                                    </div>
                                    <div class="row flatDiscount">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label error-box-class "><?php echo $this->lang->line('label_FlatDiscount').' in '.$this->session->userdata('badmin')['Currency']; ?></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input type="text" id="FlatDiscount" name="flatDiscount" required="required" class="error-box-class  form-control" onkeypress = "return isNumber(event)">

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                        </div>
                                    </div>
                                    <!-- <div class="row freeProductDiscount">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label error-box-class "><?php echo $this->lang->line('label_freeProducts'); ?> (currency)</label>
                                            <div class="col-sm-6 pos_relative2">
                                            <select id="freeProductsDiscount" name="freeProductsDiscount[]"  class="form-control error-box-class multiple" multiple="multiple">
                                                   

                                             </select>
                                               

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                        </div>
                                    </div> -->
                                    <div class="row">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label error-box-class "><?php echo $this->lang->line('label_MinimumPurchaseQuantity'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input type="text" id="minimumPurchaseQuantity" name="minimumPurchaseQuantity" required="required" class="error-box-class  form-control" onkeypress = "return isNumber(event)">

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_minimumPurchaseQuantity"></div>
                                        </div>
                                    </div>

                                    <div class="row firstCategory">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Category'); ?></label>
                                            <div class="col-sm-6 pos_relative2">
                                                
                                                <select id="category" name="categoryIds[]"  class="form-control error-box-class multiple" multiple="multiple">
                                                   

                                                </select>

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_category"></div>
                                        </div>
                                    </div>
                                    <div class="row secondCategory">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SubCategory'); ?></label>
                                            <div class="col-sm-6 pos_relative2">
                                               <select id="subCategory" name="subcategoryIds[]"  class="form-control error-box-class multiple" multiple="multiple">
                                                 
                                                </select>

                                            </div>
                                            <div class="col-sm-3 error-box" id="text_subCategory"></div>
                                        </div>
                                    </div>

                                    <div class="row thirdCategory">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SubSubCategory'); ?></label>
                                            <div class="col-sm-6 pos_relative2">
                                                <select id="subSubCategory" name="subsubcategoryIds[]"  class="form-control error-box-class multiple" multiple="multiple">
                                                 
                                                </select>  
                                                <!-- <input type="hidden" name="firstCategoryName" id="firstCategoryName" value="" />
                                                <input type="hidden" name="secondCategoryName" id="secondCategoryName" value="" />
                                                <input type="hidden" name="thirdCategoryName" id="thirdCategoryName" value="" /> -->
                                            </div>
                                            <div class="col-sm-3 error-box" id="text_subSubCategory"></div>
                                        </div>
                                    </div>
                                    <div class="row products">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_product'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">
                                                <select id="productIds" name="productIds[]"  class="form-control error-box-class multiple" multiple="multiple">
                                                   

                                                </select>  

                                            </div>
                                            <div class="col-sm-3 error-box" id="text_subCategory"></div>
                                        </div>
                                    </div>
                                    <!--unitdiff-->
                                    <div class="row unit">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label">Product Unit<span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">
                                                <select id="uproductIds" name="uproductIds[]"  class="form-control error-box-class multiple" multiple="multiple">
                                                   

                                                </select>  

                                            </div>
                                            
                                            <div class="col-sm-3 error-box" id="text_subCategory"></div>
                                        </div>
                                    </div>
                                    <div class="row unit">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label">Units<span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">
                                                <select id="uproductIdsdetails" name="unitIds[]"  class="form-control error-box-class multiple" multiple="multiple">
                                                   

                                                </select>  

                                            </div>
                                            
                                            <div class="col-sm-3 error-box" id="text_subCategory"></div>
                                        </div>
                                    </div>
                                    <!--end-->
                                    <div class="row">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_startDate'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <!--<input type="text" id="startDate" name="startDate" required="required" class="error-box-class  form-control">-->
                                                <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                    <input type="text" class="form-control datepicker-component" name="startDate" id="startDate"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <div class="col-sm-4 bootstrap-timepicker">
                                                    <!-- <input type="text" name="start_timepicker" class="form-control timepicker" id="starttime"/> -->

                                                    <div class="form-group">
                                                                <div class='input-group date' id='stime' >
                                                                    <input type='text' class="form-control"   id="starttime" name="starttime" value="00:00" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time" ></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                    
                                                        <script type="text/javascript">
                                                            $(function () {
                                                                $('#starttime,#stime').datetimepicker({
                                                                    format : 'HH:mm'
                                                                });
                                                            });
                                                        </script>
                                                    </div>


                                                </div>
                                                <!--////////-->


                                            </div>
                                            <div class="col-sm-3 error-box" id="text_startDate"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_endDate'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <!--<input type="text" id="endDate" name="endDate" required="required" class="error-box-class  form-control">-->
                                                <div id="datepicker-component" class="input-group date col-sm-6 pull-left">
                                                    <input type="text" class="form-control datepicker-component" nAME="endDate" id="endDate"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <div class="col-sm-4 bootstrap-timepicker">
                                                    <!-- <input type="text" name="end_timepicker" class="form-control timepicker" id="endtime"/> -->

                                                    <div class="form-group">
                                                                <div class='input-group date' id='etime'>
                                                                    <input type='text' class="form-control" onkeypress = "return onlyNumbersWithColon(event)" id="endtime" name="endtime" value="00:00"/>
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                    
                                                        <script type="text/javascript">
                                                            $(function () {
                                                                $('#endtime,#etime').datetimepicker({
                                                                    format : 'HH:mm'
                                                                   
                                                                });
                                                            });
                                                        </script>

                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_endDate"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_GlobalUsageLimit'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input type="text" id="GlobalUsageLimit" data-v-min="0" data-v-max="1000000" name="globalUsageLimit"  required="required" class="error-box-class  form-control" onkeypress = "return isNumber(event)">

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_GlobalUsageLimit"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_PerUserLimit'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input  type="text" id="PerUserLimit" name="perUserLimit"
                                                        required="required" class="error-box-class  form-control" style=" max-width: 100%;" onkeypress = "return isNumber(event)">

                                            </div>
                                            <div class="col-sm-3 error-box redClass" id="text_PerUserLimit"></div>
                                        </div>
                                    </div>

                                </div>

                                <br/>
                                <div class="panel panel-primary">
                                    <div class="panel-heading padding" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" >
                                                <?php echo $this->lang->line('terms_condition'); ?> 
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapseTwo" style="height: 0px;">
                                        <div class="panel-body">
                                            <div class="summernote-wrapper">
                                                <div id="summernote">

                                                    <label><?php echo $this->lang->line('terms_condition'); ?><a target="_new" href="">Preview</a></label>

                                                    <textarea name="termscond" id="termscond"></textarea>
                                                    <script>
                                                        CKEDITOR.replace('termscond');
                                                    </script>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 error-box redClass" id="text_termscond"></div>
                                  <!-- How it works -->
                        <div class="panel panel-primary">
                        <div class="panel-heading padding" data-parent="#accordion" data-toggle="collapse" href="#collapseFour">
                            <h4 class="panel-title">
                                <a class="collapsed" >
                                <?php echo $this->lang->line('howit_work'); ?> 
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseFour" style="height: 0px;">
                            <div class="panel-body">
                                <div class="summernote-wrapper">
                                    <div id="summernote">
                                   
                                            <label><?php echo $this->lang->line('howit_work'); ?> <a target="_new" href="">Preview</a></label>
                                            
                                            <textarea name="howItWorks" id="howItWorks"></textarea>
                                                <script>
                                                    CKEDITOR.replace('howItWorks');
                                                </script>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 error-box redClass" id="text_howitworks"></div>
                            </section>

                            <div class="padding-30 bg-white col-sm-9">
                                <ul class="pager wizard">

                                    <li class="" id="finishbutton">
                                        <button class="btn btn-success finishbutton pull-right" type="button" onclick="submitform()"><span><?php echo $this->lang->line('Button_Finish'); ?></span></button>
                                    </li>

                                </ul>
                            </div>

                        </div>
                        <div class="imageData" style="display: none;">

                        </div>


                        <input type="hidden" name="current_dt" id="time_hidden" value="" />

                    </form>
                </div>
            </div>
            <!-- END PANEL -->
        </div>

    </div>
    <!-- END JUMBOTRON -->
<!-- Modal -->
           <!--show city details -->
<div class="modal fade" id="productOffer" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;text-transform: capitalize;"><span id="cityDetails">PRODUCT OFFERS REJECTED</span></strong>
            </div>
            <div class="modal-body">
                 <!-- data is comming from js which is written at top-->
            <table class="table table-bordered schedulepopup">
                <thead>
                  <tr>
                    <!--<th style="width:10%;text-align: center; color: darkturquoise;">S.NO</th>-->
                    <th style="text-align: center; color: darkturquoise;">PRODUCT NAME</th>
                   
                  </tr>
                </thead>
               <tbody id="productDetailsBody">
              </tbody>
            </table>
            
            
            </div>
            <div class="modal-footer">  
               <a href="<?php echo base_url(); ?>index.php?/ProductOffers" class="btn btn-default">Close</a>
               </button>
            </div>
        </div>
    </div>
</div>
            <!--modal end-->
</div>
<!-- END PAGE CONTENT -->

<script>
    $(document).ready(function () {

       

       getAllDetails();
        
        var arr = [];

        $('#custom').click(function () {

            var z = $('.customPriceField').length + 1;
            var divElement1 = '<div class="form-group pos_relative2 customPriceField">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Units'); ?></label>'
                    + '<div class="col-sm-3 pos_relative2">'
                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    + '<input type="text" name="units[' + z + '][title]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                    + '</div>'
                    + ' <div class="col-sm-3 pos_relative2">'
                    + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                    + ' <input type="text" name="units[' + z + '][value]" class="form-control productValue" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                    + ' </div>'
                    + '<div class=""></div>'
                    + '<button type="button" class="btn-default btnRemove removeButton">'
                    + '<span class="glyphicon glyphicon-remove"></span>'
                    + '</button>'
                    + '</div>';
            $('.customField').append(divElement1);
            renameUnitsLabels();

        });


        function renameImageLabels() {
            for (var i = 0, length = $('.imageTag').length; i < length; i++) {
                $('.imageTag>label').eq(i).text('Image ' + (i + 2));


            }
        }
        function renameUnitsLabels() {
            for (var j = 0, length = $('.customPriceField').length; j < length; j++) {
                $('.customPriceField>label').eq(j).text('Units ' + (j + 2));


            }
        }

        // REMOVE ONE ELEMENT PER CLICK.
        $('body').on('click', '.btRemove', function () {
            $(this).parent().remove();
            $('#Seodata' + imgCount).remove();
            renameImageLabels();
        });
        $('body').on('click', '.btnRemove', function () {
            $(this).parent().remove();
            renameUnitsLabels();
        });


        //default value in edit
        function defaultvalue(){

            var val = $(this).val();
            
            // for franchise  
            $('#franchise').load("<?php echo base_url('index.php?/productOffers') ?>/getFranchiseData", {val: val});
            // for stores   
            $('#store').load("<?php echo base_url('index.php?/productOffers') ?>/getStoreData", {val: val});
            // fore zones
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/getZones",
                type: 'POST',
                dataType: 'json',
                data: {
                    val: val
                },
            }).done(function (json) {
                // 
                $("#serviceZones").multiselect('destroy');

                if (json.data.length > 0) {
                    for (var i = 0; i < json.data.length; i++) {
                        var serviceZone = "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
                        $("#serviceZones").append(serviceZone);
                    }
                    $('#serviceZones').multiselect({
                        includeSelectAllOption: true,
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering: true,
                        buttonWidth: '500px',
                        maxHeight: 300,
                    });
                } else {
                }

            });



        }

    });

</script>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">
                <p class="modalPopUpText1"  style="color:#0090d9; margin-left: 34%;font-size: larger;">Reached Maximum Limit.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div id="errorModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">
                <p class="modalPopUpText" style="color:#0090d9;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>

    </div>
</div>
<div id="wait" style="display:none;width:80px;height:80px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
    <img src='<?php echo ServiceLink; ?>pics/spinner.gif' width="50" height="50" /><br>Loading..
</div>


<div class="modal fade stick-up" id="seoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="addSeoModal">

            <!-- /.modal-content -->
        </div>

    </div>
    <!-- /.modal-content -->
</div>

<script>
    $(document).ready(function () {

        $(document).on('click', "#insertSeo", function () {
            $('.close').trigger('click');
            imgCount = curentImageButton;

            if ($('#SeoTitle' + imgCount).val() == '') {
                $('#SeoTitle' + imgCount).val($('#AltText' + imgCount).val())
            }
            if ($('#SeoKeyword' + imgCount).val() == "") {
                var seoDescription = $("#SeoDescription" + imgCount).val();
                var seoKeyword = seoDescription.replace(" ", ",");
                $("#SeoKeyword" + imgCount).val(seoKeyword);
            } else {
                var seoKeywordid = $('#SeoKeyword' + imgCount).val();
                var seoKeyword = seoKeywordid.replace(" ", ",");
                $("#SeoKeyword" + imgCount).val(seoKeyword);
            }
            html = '<div id="Seodata' + imgCount + '" >'
                    + '<input type="text"  id="AltText' + imgCount + '" name="images[' + imgCount + '][imageText]"  class="form-control" value="' + $('#AltText' + imgCount).val() + '">'
                    + '<input type="text"  id="SeoTitle' + imgCount + '" name="images[' + imgCount + '][title]"  class="form-control" value="' + $('#SeoTitle' + imgCount).val() + '">'
                    + '<input type="text"  id="SeoDescription' + imgCount + '" name="images[' + imgCount + '][description]" class="form-control" value="' + $('#SeoDescription' + imgCount).val() + '">'
                    + '<input type="text"  id="SeoKeyword' + imgCount + '" name="images[' + imgCount + '][keyword]" class="form-control" value="' + $('#SeoKeyword' + imgCount).val() + '">'
                    + '</div>';

            $('.imageData').append(html);

        });

        $(document).on('click', ".btAddSeo", function () {

            var imgCount = $(this).attr('data-id');
            curentImageButton = imgCount;
            var imageval = $("#image" + imgCount).val();
//            
//            

            $('#addSeoModal').html('');

            var html2 = '';
            if (imageval != "") {
                html2 = '<div class="modal-header">'
                        + '<span class="modal-title"><?php echo $this->lang->line('label_Seo'); ?></span>'
                        + '<button type="button" class="close" data-dismiss="modal">&times;</button>'
                        + '</div>'
                        + '<div class="modal-body form-horizontal">'
                        + '<form action="" method="post" id="addManagerrForm" data-parsley-validate="" class="form-horizontal form-label-left">'
                        + '<div class="form-group" class="formex">'
                        + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_AltText'); ?></label>'
                        + '<div class="col-sm-6">'
                        + '<input type="text"  id="AltText' + imgCount + '" name="images[' + imgCount + '][imageText]"  class="form-control">'
                        + '</div>'
                        + '<div class="col-sm-3 errors" id="Alt_TextErr"></div>'
                        + '</div>'
                        + '<div class="form-group" class="formex">'
                        + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoTitle'); ?></label>'
                        + '<div class="col-sm-6">'
                        + '<input type="text"  id="SeoTitle' + imgCount + '" name="SeoTitle"  class="form-control">'
                        + '</div>'
                        + '<div class="col-sm-3 errors" id="SeoTitleErr"></div>'
                        + '</div>'
                        + '<div class="form-group" class="formex">'
                        + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoDescription'); ?></label>'
                        + '<div class="col-sm-6">'
                        + '<input type="text"  id="SeoDescription' + imgCount + '" name="SeoDescription" class="form-control" >'
                        + '</div>'
                        + '<div class="col-sm-3 errors" id="SeoDescriptionErr"></div>'
                        + '</div>'
                        + '<div class="form-group" class="formex">'
                        + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoKeyword'); ?></label>'
                        + '<div class="col-sm-6">'
                        + '<input type="text"  id="SeoKeyword' + imgCount + '" name="SeoKeyword" class="form-control" >'
                        + '</div>'
                        + '<div class="col-sm-3 errors" id="SeoKeywordErr"></div>'
                        + '</div>'
                        + '</form>'
                        + '</div>'
                        + '<div class="modal-footer">'

                        + '<div class="col-sm-4 error-box" id="errorpass"></div>'
                        + '<div class="col-sm-8" >'
                        + '<div class="pull-right m-t-10"><button type="button" class="btn btn-primary pull-right" id="insertSeo"><?php echo $this->lang->line('button_add'); ?></button></div>'
                        + '<div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('button_Cancel'); ?></button></div>'
                        + '</div>'
                        + '</div>';

                $('#addSeoModal').append(html2);
                $('#seoModal').modal('show');
            } else {
                $("#image" + imgCount).focus();
            }

        });

        $('#close1').click(function () {
//        $('#imagelist').removeData();
            $('#imagedata').html("");
            window.location.reload();
        });
    });

</script>