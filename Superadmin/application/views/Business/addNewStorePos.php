

<?php
$appConfig['currency'] = '$';
//error_reporting(true);
//ini_set('display_errors', 1);
?>

<link href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />


<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    .pac-container {
        background-color: #FFF;
        z-index: 2000;
        position: fixed;
        display: inline-block;
    }
    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
    .btn {
        border-radius: 25px !important;
    }
    h5{
        margin-left: 20px !important;
    }
    .textAlign{
        color: #0090d9;
        padding-left: 20px;
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
    .phoneWidth{
        width: 610px;
    }
    .multiselect-container>li>a label.checkbox input[type="checkbox"] {
        margin-left: -20px !important;
    }
</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE"></script>

<script>

    function callMap() {
//        alert();
//       
        $('#ForMaps').modal('show');


        if ($('#entiryLatitude').val() != "" && $('#entiryLongitude').val() != "") {
            initialize1($('#entiryLatitude').val(), $('#entiryLongitude').val());
            $('#mapentityAddress').val($('#entityAddress_01').val());
            $('#mapentityAddress').val($('#entityAddress_0').val());
        } else {
            initialize1(20.268455824834792, 85.84099235520011);
        }
    }
    function callMap1() {
//        alert();
//       
        $('#ForMaps').modal('show');


        if ($('#entiryLatitude').val() != "" && $('#entiryLongitude').val() != "") {
            initialize1($('#entiryLatitude').val(), $('#entiryLongitude').val());
            $('#mapentityAddress1').val($('#entityAddress_01').val());
            $('#mapentityAddress1').val($('#entityAddress_0').val());
        } else {
            initialize1(20.268455824834792, 85.84099235520011);
        }
    }
    function Cancel() {
        $('#ForMaps').modal('hide');
        $('#ForMaps1').modal('hide');

    }

//    function Take() {
////        alert();
//        $('#entiryLongitude').val($('#longitude').val());
//        $('#entiryLatitude').val($('#latitude').val());
//        $('.entityAddress').val($('#mapentityAddress').val());
//        $('.entityAddress1').val($('#mapentityAddress').val());
//        $('#ForMaps').modal('hide');
//
//    }
    function Take() {
//        alert();
        $('#entiryLongitude').val($('#longitude').val());
        $('#entityAddress_0').val($('#entityAddress1').val());
        $('#entiryLatitude').val($('#latitude').val());
        $('#entityAddress_01').val($('#entityAddress1').val());
        $('#entityAddress1').val($('#mapentityAddress').val());
        $('.entityAddress1').val($('#mapentityAddress').val());
        $('#ForMaps').modal('hide');

    }

    function initialize1(lat, long, from) {

        if (lat != '' || long != '')
        {
            myLatlng = new google.maps.LatLng(lat, long);
        } else {
            myLatlng = new google.maps.LatLng(20.268455824834792, 85.84099235520011);
        }

        var mapOptions = {
            zoom: 15,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: true,
            zoomControl: true,
            scaleControl: true,
            mapTypeControl: true,
            streetViewControl: true,
            overviewMapControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
        };
        map = new google.maps.Map(document.getElementById("myMap"), mapOptions);
        marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
            draggable: true
        });

        geocoder.geocode({'latLng': myLatlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    if (from == '1') {
                        $('#entiryLongitude').val(marker.getPosition().lng());
                        $('#entiryLatitude').val(marker.getPosition().lat());
                    } else {
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                    }
                }
            }
        });

        google.maps.event.addListener(marker, 'dragend', function () {

            geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {

                        console.log(results[0].formatted_address);

                        $('#mapentityAddress').val(results[0].formatted_address);

                        $('#entityAddress1').val(results[0].formatted_address);
                        $('#latitude').val(marker.getPosition().lat());
                        $('#longitude').val(marker.getPosition().lng());
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                    }
                }
            });
        });
        google.maps.event.addListenerOnce(map, 'idle', function () {
            google.maps.event.trigger(map, 'resize');
        });

    }

    var map;
    var marker;
    var myLatlng = new google.maps.LatLng(20.268455824834792, 85.84099235520011);

    var geocoder = new google.maps.Geocoder();
    var infowindow = new google.maps.InfoWindow();

    function getAddLatLong1(text) {

        var addr = text.value;
//        alert(addr)
//        alert(text.value);
        $.ajax({
            url: "<?php echo base_url(); ?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                console.log(data);
                $('#entiryLatitude').val(Arr.Lat);
                $('#entiryLongitude').val(Arr.Long);
            }
        });
    }
    function getAddLatLong(text) {

        var addr = text.value;
        $.ajax({
            url: "<?php echo base_url(); ?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                $('#entityAddress1').val(Arr.Address);
                $('#latitude').val(Arr.Lat);
                $('#longitude').val(Arr.Long);
            }
        });
    }


</script>

<script type="text/javascript">
    function initialize() {
        var id = '';
        var input = document.getElementById('entityAddress_0');
        var input9 = document.getElementById('entityAddress_01');

        var options = {componentRestrictions: {country: 'us'}};

        var autocomplete = new google.maps.places.Autocomplete(input);
        var autocomplete9 = new google.maps.places.Autocomplete(input9);

        google.maps.event.addListener(autocomplete9, 'place_changed', function () {
            //alert('i am here');
            var place = autocomplete9.getPlace();
            document.getElementById('entiryLatitude1').value = place.geometry.location.lat();
            document.getElementById('entiryLongitude1').value = place.geometry.location.lng();
            initialize(place.geometry.location.lat(), place.geometry.location.lng(), '0');
            $('#longitude1').val(place.geometry.location.lng());
            $('#latitude1').val(place.geometry.location.lat());
        });
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            //alert('i am here');
            var place = autocomplete.getPlace();
            document.getElementById('entiryLatitude').value = place.geometry.location.lat();
            document.getElementById('entiryLongitude').value = place.geometry.location.lng();
            initialize(place.geometry.location.lat(), place.geometry.location.lng(), '0');
            $('#longitude').val(place.geometry.location.lng());
            $('#latitude').val(place.geometry.location.lat());
        });
//    });
        var input1 = document.getElementById('mapentityAddress');
        var autocomplete1 = new google.maps.places.Autocomplete(input1);
        google.maps.event.addListener(autocomplete1, 'place_changed', function () {
            var place = autocomplete1.getPlace();
//            document.getElementById('city2').value = place.name;
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();

        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script>
    $(document).ready(function () {
        $("#businessNumber").intlTelInput("setNumber", '');
        $("#phone").intlTelInput("setNumber", '');
        $("#businessNumber").on("countrychange", function (e, countryData) {

            $("#countryCode").val(countryData.dialCode);
        });
        $("#phone").on("countrychange", function (e, countryData) {

            $("#countryCode").val(countryData.dialCode);
        });
        $('#businessname_0').val("<?php echo $locationName; ?>");
        $('#category').on('change', function () {

            var val = $(this).val();
            $('#subCategory').load("<?php echo base_url('index.php?/SubCategory') ?>/getSubCategoryData", {val: val});


        });
        $('#subCategory').on('change', function () {

            var val = $(this).val();
            $('#subSubCategory').load("<?php echo base_url('index.php?/SubsubCategory') ?>/getSubsubCategoryDataList", {val: val});


        });

        $('#cityLists').on('change', function () {


            $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/getZones",
                type: 'POST',
                dataType: 'json',
                data: {
                    val: $('#cityLists').val()
                },
            }).done(function (json) {
                console.log(json);
                $("#serviceZones").multiselect('destroy');

                //     $("#nonFranchiseStoreError").text('');
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
                    // $("#storeError").text('No stores found for ' + $("#citiesList option:selected").text());
                }

            });

        });

        $('.Pickup').show();
        $('.Delivery').show();
        $('.basefare').hide();



        $('#cityLists').change(function () {
            $('#cityname').val($('#cityLists option:selected').text());
        });

        $('#CountryList').on('change', function () {

            var val = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Business/getCityList",
                type: 'POST',
                data: {val: val},
                datatype: 'json', // fix: need to append your data to the call
                success: function (response) {
                    $('#cityLists').empty();
                    var r = JSON.parse(response);
                    var html = '';
                    html = '<option value="">Select City</option>'
                    $.each(r, function (index, row) {
                        console.log(row);
                        html += '<option data-name="' + row.cityName + '"value="' + row.cityId.$oid + '">' + row.cityName + '</option>';
                    });
//              
                    $('#cityLists').append(html);
                }
            });


        });

        $('#businessNumber').val("<?php echo $phonePos; ?>");
        $('#insert').click(function () {
            var status = '<?php echo $status; ?>';
            $('.clearerror').text("");
            var BusinessName = new Array();
            $(".businessname").each(function () {
                if ($(this).val() != '')
                    BusinessName.push($(this).val());
            });
            // var serviceZones = $("#serviceZones option:selected").val();
            var serviceZones = $("#serviceZones").val();

            var locationId = "<?php echo $locationId; ?>";
            var urlData = "<?php echo $urlData; ?>";
//alert(urlData)
            var Description = new Array();
            $(".description").each(function () {
                if ($(this).val() != '')
                    Description.push($(this).val());
            });

            var Address = new Array();
            $(".entityAddress").each(function () {
                if ($(this).val())
                    Address.push($(this).val());
            });
            var billingAddress = new Array();
            $(".entityAddress1").each(function () {
                if ($(this).val())
                    billingAddress.push($(this).val());
            });
//            var posID = $('#posID').val();
            var externalCreditCard = "<?php echo $externalCreditCard; ?>";
            var internalCreditCard = "<?php echo $internalCreditCard; ?>";
            var check = "<?php echo $check; ?>";
            var quickCard = "<?php echo $quickCard; ?>";
            var giftCard = "<?php echo $giftCard; ?>";
            var walletID = "<?php echo $walletID; ?>";
            var paymentsEnabled = "<?php echo $paymentsEnabled; ?>";
            var posID = "<?php echo $posID; ?>";

            var locationName = "<?php echo $locationName; ?>";
            var businessNumber = $('#businessNumber').val();
            var countryCode = $('#countryCode').val();
//            alert(countryCode);
            var OwnerName = $("#ownername").val();
            var Phone = $("#phone").val();
            var Email = $("#email").val();
            var Password = $("#password").val();
            var Website = $("#website").val();
            var Country = $("#CountryList").val();
            var city = $("#cityLists").val();
            var cityName = $("#cityLists option:selected").attr('data-name');
            var Postalcode = $("#entitypostalcode").val();
            var Longitude = $("#entiryLongitude").val();
            var Latitude = $("#entiryLatitude").val();
            var avgcooktime = $("#avgcooktime").val();
            var BizId = $("#BizId").val();
            var CatId = $("#category option:selected").val();
            var Budget = $("#budget").val();
            var subCatId = $("#subCategory option:selected").val();
            var pricing = $("input[name='price']:checked").val();
            var grocerDriver = $("#grocerDriver").val();
            var storeDriver = $("#storeDriver").val();
            var Offlinedriver = $("#Offlinedrivers").val();
            var tier1 = parseInt($("#tier1").val());
            var tier2 = parseInt($("#tier2").val());
            var tier3 = parseInt($("#tier3").val());
            var notes = $("#notes").val();
            var minorderVal = $('#entiryminorderVal').val();
            var freedelVal = $('#freedelVal').val();

            var select = $('.accepts:checked').val();
//            alert(select);
            var basefare = $('#basefare').val();
            var range = $('#range').val();
            var priceperkm = $('#Priceperkm').val();

            var Pcash = $('#Pcash:checked').map(function () {
                return this.value;
            }).get();
            var Pcredit_card = $('#Pcredit_card:checked').map(function () {
                return this.value;
            }).get();
            var Psadad = $('#PSADAD:checked').map(function () {
                return this.value;
            }).get();

            var Dcash = $('#Dcash:checked').map(function () {
                return this.value;
            }).get();
            var Dcredit_card = $('#Dcredit_card:checked').map(function () {
                return this.value;
            }).get();
            var Dsadad = $('#DSADAD:checked').map(function () {
                return this.value;
            }).get();

            var passwordstrong = /^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,15}$/;
            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;

            if ($('.accepts:checked').val() == '' || $('.accepts:checked').val() == null) {
                $('#text_accepts').text("Please select the order type");
            } else if ($('.Pcheckbox_:checked').val() == '' || $('.Pcheckbox_:checked').val() == null) {
                $('#text_payment').text("Please select the payment type");
            } else {

                $.ajax({
                    url: "<?php echo base_url('index.php?/Business') ?>/operationBusiness/insert",
                    type: 'POST',
                    data: {
                        BusinessName: BusinessName,
                        externalCreditCard: externalCreditCard,
                        internalCreditCard: internalCreditCard,
                        check: check,
                        quickCard: quickCard,
                        giftCard: giftCard,
                        OwnerName: OwnerName,
                        countryCode: countryCode,
                        Phone: Phone,
                        Email: Email,
                        Password: Password,
                        Website: Website,
                        Description: Description,
                        Address: Address,
                        billingAddress: billingAddress,
                        Longitude: Longitude,
                        Latitude: Latitude,
                        Country: Country,
                        city: city,
                        cityName: cityName,
                        Postalcode: Postalcode,
                        CatId: CatId,
                        subCatId: subCatId,
                        pricing: pricing,
                        minorderVal: minorderVal,
                        freedelVal: freedelVal,
                        select: select,
                        basefare: basefare,
                        range: range,
                        priceperkm: priceperkm,
                        Pcash: Pcash,
                        Pcredit_card: Pcredit_card,
                        Psadad: Psadad,
                        Dcash: Pcash,
                        Dcredit_card: Pcredit_card,
                        Dsadad: Dsadad,
                        tier1: tier1,
                        tier2: tier2,
                        tier3: tier3,
                        notes: notes,
                        avgcooktime: avgcooktime,
                        Budget: Budget,
                        grocerDriver: grocerDriver,
                        storeDriver: storeDriver,
                        businessNumber: businessNumber,
                        Offlinedriver: Offlinedriver,
                        serviceZones: serviceZones,
                        walletID: walletID,
                        paymentsEnabled: paymentsEnabled,
                        locationName: locationName,
                        posID: posID,
                        locationId: locationId,
                        urlData: urlData

                    },
                    dataType: 'JSON',
                    async: true,
                    success: function (response)
                    {

                        console.log(response);
//                        window.location="http://"+response.urlData+".greenboxpos.com/locations/store_submit/"+response.message+"/"+response.token+"/"+response.storeId+"/"+response.storeName+"/"+response.appId;
                        window.location = response.data.urlData + "/locations/store_submit/" + response.message + "/" + response.data.token + "/" + response.data.storeId + "/" + response.data.storeName + "/" + response.data.appId;

//              
                    }

                });
            }
        });

//        });

        $('.lan_check').change(function () {
            if ($(this).is(':checked')) {
                var val = this;
                var html = '<div class="form-group formex cat_lan_' + $(val).val() + '"">\
                            <label for="fname" class="col-sm-3 control-label">    <?php echo FIELD_BUSINESSNAME_NAME; ?>  (' + $(val).attr('data-id') + ') <span class="MandatoryMarker">*</span></label>\
                            <div class="col-sm-6">\
                                <input type="text"  id="businessname_' + $(val).val() + '" name="Businessname[' + $(val).val() + ']"  class="form-control error-box-class" >\
                            </div>\
                        </div>';
                $('#bussiness_txt').append(html);

                var html = '<div class="form-group formex cat_lan_' + $(val).val() + '"">\
                            <label for="fname" class="col-sm-3 control-label"> DESCRIPTION (' + $(val).attr('data-id') + ')<span class="MandatoryMarker">*</span></label>\
                            <div class="col-sm-6">\
                                <textarea type="text"  id="description_' + $(val).val() + '" name="Descrition[' + $(val).val() + ']"  class="form-control error-box-class" ></textarea>\n\
                            </div>\
                          </div>';
                $('#description_txt').append(html);

                var html = '<div class="form-group formex cat_lan_' + $(val).val() + '"">\
                            <label for="fname" class="col-sm-3 control-label">Address (' + $(val).attr('data-id') + ')<span class="MandatoryMarker">*</span></label>\
                            <div class="col-sm-6">\
                                <textarea class="form-control" id="Adress_' + $(val).val() + '" placeholder="Address" name="Address[0]"  aria-required="true" onkeyup="getAddLatLong1(this)"></textarea>\
                            </div>\
                          </div>';
                $('#Address_txt').append(html);
            } else {
                $('.cat_lan_' + $(this).val()).remove();
            }
        });
    });

    function isNumberKey(evt)
    {
        $("#mobify").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
            //    alert("Only numbers are allowed");
            $("#mobify").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
            return false;
        }
        return true;
    }
    function acceptselect() {

        var select = $('.accepts:checked').val();
        if (select == '1') {
            $('.Pickup').show();
            $('.Delivery').hide();
        } else if (select == '2') {
            $('.Pickup').hide();
            $('.Delivery').show();
        } else if (select == '3') {
            $('.Pickup').show();
            $('.Delivery').show();
        }
    }

    function selectprice() {
        var pricing = $("#pricing").val();
        var drivers = $("#drivers").val();

        if (pricing == "2" && drivers == '1')
        {
            if (drivers == '1') {
                $('.basefare').show();
            }
        } else {
            $('.basefare').hide();
            $('#range').val('');
            $('#Priceperkm').val('');
            $('#basefare').val('');
        }
    }

</script>




<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <div class="brand inline" style="  width: auto;
             font-size: 16px;
             color: gray;
             padding-top: 45px;
             padding-bottom: 10px;">
            <strong style="color:#0090d9;"> Add New Dispensary</strong><!-- id="define_page"-->
        </div>
        <!-- START JUMBOTRON -->
        <div class="bg-white">


            <!-- Nav tabs -->

            <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                <li class="tabs_active active" id="firstlitab" onclick="managebuttonstate()">
                    <a id="tb1"><i id="tab1icon" class=""></i> <span>Details</span></a>
                </li>

                <li class="tabs_active" id="secondlitab">
                    <a onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span>Settings</span></a>
                </li>


            </ul>

            <!-- End Nav tabs -->  


            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">

                    <form id="addentity" class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                        <div class="tab-content">


                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">
                                    <div class="form-group"id="bussiness_txt">

                                        <label for="fname" class="col-sm-2 control-label">DISPENSARY NAME<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">  
                                            <input type="text"   id="businessname_0" name="Businessname[0]"  class=" businessname form-control error-box-class" >
                                        </div>
                                        <div class="col-sm-3" id="text_businessname_0" style="color:red">

                                        </div>
                                    </div>


                                    <?php
                                    foreach ($language as $val) {
//                                         print_r($val);
                                        ?>
                                        <div class="form-group" >
                                            <label for="fname" class=" col-sm-2 control-label"> <?php echo "DISPENSARY NAME" . ' (' . $val['lan_name'] . ')'; ?> <span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="businessname_<?= $val['lan_id'] ?>" name="Businessname<?= $val['lan_id'] ?>"  class=" businessname form-control error-box-class" >
                                            </div>
                                            <div class="col-sm-3" style="color:red" id="text_businessname_<?= $val['lan_id'] ?>">

                                            </div>
                                        </div>

                                    <?php } ?>


                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">OWNER NAME<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="ownername" name="Ownername"  class="form-control error-box-class" >
                                        </div>
                                        <div class="col-sm-3" id="text_ownername" style="color:red"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label ">OWNER PHONE</label>
                                        <div class="col-sm-6">
                                            <input type="tel" maxlength="10" id="phone" name="Phone"  class="form-control error-box-class phoneWidth" onkeypress="return isNumberKey(event)">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">OWNER EMAIL<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="email" name="Email"  value="<?php echo $emailAddressPos; ?>" class="form-control error-box-class" >
                                        </div>
                                        <div class="col-sm-3" id="text_email" style="color:red"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">PASSWORD<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="password" name="Password"  class="form-control error-box-class" >
                                        </div>
                                        <div class="col-sm-3" id="text_password" style="color:red"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label ">BUSINESS PHONE<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="tel" maxlength="10" value=""  id="businessNumber" name="businessNumber"  class="form-control classRight phoneWidth" onkeypress="return isNumberKey(event)" required="">

                                        </div>
                                        <div class="col-sm-3" id="text_businessNumber" style="color:red"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"> WEBSITE</label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="website" name="Website"  class="form-control error-box-class" >
                                        </div>
                                    </div>

                                    <div class="form-group" id="description_txt">

                                        <label for="fname" class="col-sm-2 control-label"> DESCRIPTION</label>
                                        <div class="col-sm-6">
                                            <textarea type="text"  id="description" name="Descrition[0]"  class="description form-control error-box-class" ></textarea>
                                        </div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        ?>
                                        <div class="form-group" >
                                            <label for="fname" class=" col-sm-2 control-label"> DESCRIPTION (<?php echo $val['lan_name']; ?>)</label>
                                            <div class="col-sm-6">
                                                <textarea type="text"  id="description" name="Descrition[<?= $val['lan_id'] ?>]"  class="description form-control error-box-class" ></textarea>

                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">COUNTRY<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <select id='CountryList' name='Country' class='form-control'  <?PHP echo $enable; ?>>
                                                <option value="">Select Country</option>
                                                <?php
                                                foreach ($country as $result) {

                                                    echo "<option value=" . $result['_id']['$oid'] . ">" . $result['country'] . "</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="col-sm-3" id="text_CountryList" style="color:red"></div>

                                    </div>

                                    <input type='hidden' name='cityname' id='cityname'>
                                    <input type='hidden' name='countryname' id='countryname'>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">CITY<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <div id='CityList'>
                                                <select id='cityLists' class="form-control" name='City' <?PHP echo $enable; ?> >
                                                    <option value=''>Select City</option>


                                                </select>

                                            </div>
                                            <div class="col-sm-3" id="text_cityLists" style="color:red"></div>
                                        </div>

                                    </div>
                                    <input type="hidden" id="countryCode" name="coutry-code" value="">
                                    <div class="form-group" id="Address_txt" >

                                        <label for="fname" class="col-sm-2 control-label ">BUSINESS ADDRESS<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control entityAddress" id="entityAddress_0" placeholder="Business Address" name="Address[0]"  aria-required="true"  onkeyup="getAddLatLong1(this)"><?php echo $addressPos; ?></textarea>
                                        </div>
                                        <button  type="button" class=" btn btn-info btn-sm col-sm-1" 
                                                 style="margin-top: 0px;
                                                 width: 5%;
                                                 border-radius: 45px;
                                                 position: relative;
                                                 height: 30px;
                                                 font-size: 13px;" 
                                                 accesskey="" name="action" onclick="callMap();" value="add">Map</button>
                                        <div class="col-sm-2" id="text_entityAddress_0" style="color:red"></div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
//                                         print_r($val);
                                        ?>
                                        <div class="form-group" >
                                            <label for="fname" class=" col-sm-2 control-label"> ADDRESS (<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control entityAddress" id="entityAddress_<?= $val['lan_id'] ?>" placeholder="Address" name="Address[<?= $val['lan_id'] ?>]"  aria-required="true" ></textarea>
                                            </div>

                                            <button  type="button" class=" btn btn-info btn-sm col-sm-1" 
                                                     style="margin-top: 0px;
                                                     width: 5%;
                                                     border-radius: 45px;
                                                     position: relative;
                                                     height: 30px;
                                                     font-size: 13px;" 
                                                     accesskey="" name="action" onclick="callMap();" value="add">Map</button>
                                        </div>

                                    <?php } ?>
                                    <div class="form-group" id="Address_txt" >

                                        <label for="fname" class="col-sm-2 control-label ">BILLING ADDRESS</label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control entityAddress1" id="entityAddress_01" placeholder="Billing Address" name="Address[0]"  aria-required="true"  onkeyup="getAddLatLong1(this)"></textarea>
                                        </div>
                                        <!--                                        <button  type="button" class=" btn btn-info btn-sm col-sm-1" 
                                                                                         style="margin-top: 0px;
                                                                                         width: 5%;
                                                                                         border-radius: 45px;
                                                                                         position: relative;
                                                                                         height: 30px;
                                                                                         font-size: 13px;" 
                                                                                         accesskey="" name="action" onclick="callMap1();" value="add">Map</button>-->
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">SERVICE ZONES<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <select  id='serviceZones' name='FData[serviceZones][]' class='errr11 form-control serviceZones' multiple="multiple">

                                            </select>
                                        </div> 
                                        <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="serviceZonesErr" style="color:red"></div>                                       
                                    </div>
                                    <!--                                    <div class="form-group">
                                                                            <label for="fname" class="col-sm-2 control-label">POS-ID<span class="MandatoryMarker">*</span></label>
                                                                            <div class="col-sm-6">
                                                                                <input type="test"  id='posID' name="posID" class='errr11 form-control posID'>
                                    
                                                                            </div> 
                                                                            <div class="col-sm-offset-3 col-sm-6 error-box text_err" id="posIDErr" style="color:red"></div>                                       
                                                                        </div>-->








                                    <!--                                    <div class="form-group">
                                                                            <label for="fname" class="col-sm-3 control-label">POSTAL CODE<span class="MandatoryMarker">*</span></label>
                                                                            <div class="col-sm-6">-->
                                    <input type="hidden" class="form-control" id="entitypostalcode" value='' placeholder="0" name="PostalCode"  aria-required="true" <?PHP echo $enable; ?>>
                                    <!--</div>-->

                                    <!--</div>-->

                                    <!--                                    <div class="form-group">
                                                                            <label for="fname" class="col-sm-3 control-label">LONGITUDE<span class="MandatoryMarker">*</span></label>
                                                                            <div class="col-sm-6">-->
                                    <input type="hidden" class="form-control" id="entiryLongitude" value='' placeholder="0.00" name="Longitude"  aria-required="true" <?PHP echo $enable; ?>>
                                    <!--                                        </div>
                                                                            
                                                                        </div>-->

                                    <!--<div class="form-group">-->
                                        <!--<label for="fname" class="col-sm-3 control-label">LATITUDE<span class="MandatoryMarker">*</span></label>-->
                                    <!--<div class="col-sm-6">-->
                                    <input type="hidden" class="form-control" id="entiryLatitude" value='' placeholder="0.00" name="Latitude"  aria-required="true" <?PHP echo $enable; ?>>
                                    <!--                                        </div>
                                                                           
                                                                        </div>-->

                                </div>
                            </div>

                            <!-- End of Tab1 -->




                            <!--Start of Tab2 -->
                            <div class="tab-pane slide-left padding-20" id="tab2" style="border: 2px">
                                <div class="row row-same-height">
                                    <h6 class="textAlign">DRIVER SETTINGS</h6>
                                    <hr>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">DRIVERS TYPE</label>
                                        <div class="col-sm-6">
                                            <input type="checkbox" class="drivers_" name="select_driver" id="grocerDriver" value="1" >&nbsp;&nbsp;<label>UFly Pool</label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" class="drivers_" name="select_driver" id="storeDriver" value="2" >&nbsp;&nbsp;<label>Dispensary Pool</label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <!--<input type="checkbox" class="drivers_" name="select_driver" id="Offlinedrivers" value="1" >&nbsp;&nbsp;<label>Offline Pool</label>-->
                                        </div>
                                    </div>

                                    <hr>
                                    <h6 class="textAlign">PRICE SETTINGS</h6>
                                    <hr>


                                    <div class="form-group">

                                        <label for="fname" class="col-sm-2 control-label">PRICING MODEL</label>
                                        <div class="col-sm-6">
                                            <input type="radio" class="pricing_" name="price" value="0" >&nbsp;&nbsp;<label>Zonal Pricing</label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" class="pricing_" name="price"  value="1" >&nbsp;&nbsp;<label>Mileage Pricing</label>
                                        </div>

                                    </div>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">MINIMUM ORDER VALUE (<?php echo $appConfig['currency']; ?>)</label>
                                        <div class="col-sm-6 pos_relative2">
                                            <span class="abs_text"><b><?php echo $appConfig['currency']; ?></b></span>
                                            <input type="text" class="form-control" id="entiryminorderVal" value='' placeholder="Minimum Order Value" name="MinimumOrderValue"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>

                                    </div>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">THRESHOLD VALUE (<?php echo $appConfig['currency']; ?>)</label>
                                        <div class="col-sm-6 pos_relative2">
                                            <span class="abs_text"><b><?php echo $appConfig['currency']; ?></b></span>
                                            <input type="text" class="form-control" id="freedelVal" value='' placeholder="Threshold Value" name="FreeDeliveryAbove"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>

                                    </div>

                                    <div class="form-group basefare" >

                                        <div class="form-group ">

                                            <label for="fname" class="col-sm-2 control-label">BASE FARE (<?php echo $appConfig['currency']; ?>)</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="basefare" value='' placeholder="Base Fare" name="Basefare"  aria-required="true" <?PHP echo $enable; ?>>
                                            </div>

                                        </div>


                                        <div class="form-group range">

                                            <label for="fname" class="col-sm-2 control-label">RANGE (<?php echo $appConfig['currency']; ?>)</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="range" value='' placeholder="Range" name="Range"  aria-required="true" <?PHP echo $enable; ?>>
                                            </div>

                                        </div>

                                        <div class="form-group Priceperkm">

                                            <label for="fname" class="col-sm-2 control-label">PRICE/<?php echo $appConfig['distance']; ?> (<?php echo $appConfig['currency']; ?>)</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="Priceperkm" value='' placeholder="Price/<?php echo $appConfig['distance']; ?>" name="priceperkm"  aria-required="true" <?PHP echo $enable; ?>>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <h6 class="textAlign">SERVICE SETTINGS</h6>
                                    <hr>

                                    <div class="form-group" >
                                        <label for="fname" class="col-sm-2 control-label">ORDER TYPE<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6" id="accepts" >
                                            <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts" id="accepts_1" value="1"><label> Pickup</label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts" id="accepts_2" value="2"><label> Delivery</label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts" id="accepts_3" value="3"><label> Both</label>
                                        </div>
                                        <div class="col-sm-3" id="text_accepts"></div>
                                    </div>

                                    <hr>
                                    <h6 class="textAlign">PAYMENT SETTINGS</h5>
                                        <hr>

                                        <div class="form-group Pickup">
                                            <label for="fname" class="col-sm-2 control-label">PAYMENT METHOD FOR PICKUP<span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="checkbox" class="Pcheckbox_" name="payment[]" id="Pcash" value="1" >&nbsp;&nbsp;<label>Cash</label> 

                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="checkbox" class="Pcheckbox_" name="payment[]" id="Pcredit_card" value="2" >&nbsp;&nbsp;<label>Credit Card</label> 

                                                &nbsp;&nbsp;&nbsp;&nbsp;

                                            </div>
                                            <div class="col-sm-3" id="text_payment"></div>
                                        </div>

                                        <div class="form-group  Delivery">
                                            <label for="fname" class="col-sm-2 control-label">PAYMENT METHOD FOR DELIVERY<span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="checkbox" class="Dcheckbox_" name="payment[]" id="Dcash" value="1" >&nbsp;&nbsp;<label>Cash</label> 

                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="checkbox" class="Dcheckbox_" name="payment[]" id="Dcredit_card" value="1" >&nbsp;&nbsp;<label>Credit Card</label> 

                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                        </div>

                                        <hr>

                                        </div>
                                        </div>
                                        <!--End of Tab2-->
                                        </div>

                                        </div>

                                        <div class="padding-20 bg-white">
                                            <ul class="pager wizard">
                                                <li class="next" id="nextbutton">
                                                    <button class="btn btn-primary btn-cons btn-animated from-left  pull-right" type="button" onclick="movetonext()">
                                                        <span style="
                                                              height: 24px;
                                                              ">Next</span>
                                                    </button>
                                                </li>
                                                <li class="hidden" id="finishbutton">
                                                    <button class="btn btn-primary btn-cons btn-animated from-left pull-right" type="button"  id="insert">
                                                        <span style="height: 24px; ">Finish</span>
                                                    </button>
                                                </li>

                                                <li class="previous hidden" id="prevbutton">
                                                    <button class="btn btn-default btn-cons pull-right" type="button" onclick="movetoprevious()">
                                                        <span style="
                                                              height: 24px;
                                                              ">Previous</span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

                                </div>    
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/intlTelInput.js"></script>

        <script>
                                                        var countryData = $.fn.intlTelInput.getCountryData();
                                                        $.each(countryData, function (i, country) {

                                                            country.name = country.name.replace(/.+\((.+)\)/, "$1");
                                                        });
                                                        $("#businessNumber").intlTelInput({
                                                            //       allowDropdown: false,
                                                            autoHideDialCode: false,
                                                            autoPlaceholder: "off",
                                                            dropdownContainer: "body",
                                                            //       excludeCountries: ["us"],
                                                            formatOnDisplay: false,
                                                            geoIpLookup: function (callback) {
                                                                $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                                                                    var countryCode = (resp && resp.country) ? resp.country : "";
                                                                    callback(countryCode);
                                                                });
                                                            },
                                                            initialCountry: "auto",
                                                            nationalMode: false,
                                                            //       onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                                                            placeholderNumberType: "MOBILE",
                                                            //       preferredCountries: ['srilanka'],
                                                            separateDialCode: true,
                                                            utilsScript: "<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/utils.js",

                                                        });
                                                        $("#phone").intlTelInput({
                                                            //       allowDropdown: false,
                                                            autoHideDialCode: false,
                                                            autoPlaceholder: "off",
                                                            dropdownContainer: "body",
                                                            //       excludeCountries: ["us"],
                                                            formatOnDisplay: false,
                                                            geoIpLookup: function (callback) {
                                                                $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                                                                    var countryCode = (resp && resp.country) ? resp.country : "";
                                                                    callback(countryCode);
                                                                });
                                                            },
                                                            initialCountry: "auto",
                                                            nationalMode: false,
                                                            //       onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                                                            placeholderNumberType: "MOBILE",
                                                            //       preferredCountries: ['srilanka'],
                                                            separateDialCode: true,
                                                            utilsScript: "<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/utils.js",

                                                        });




        </script>


        <script>
            //validations for each previous tab before proceeding to the next tab
            function managebuttonstate()
            {
                $("#prevbutton").addClass("hidden");
                $("#tb1").attr('data-toggle', 'tab');
                $("#tb1").attr('href', '#tab1');
            }

            function profiletab(litabtoremove, divtabtoremove)
            {
                console.log('profiletab-start');
                var pstatus = true;
                var reason = '';
                var BusinessName = new Array();
                $(".businessname").each(function () {
                    if ($(this).val() != '')
                        BusinessName.push($(this).val());
                });
                if (BusinessName == "" || BusinessName == null) {
                    $("#text_businessname_0").text("Please enter the dispensary name");
                    pstatus = false;
                } else if ($('#ownername').val() == '' || $('#ownername').val() == null) {
                    $("#text_businessname_0").text(" ");
                    $("#text_ownername").text("Please enter the owner name");
                    pstatus = false;
                } else if ($('#email').val() == '' || $('#email').val() == null) {
                    $("#text_ownername").text("")
                    $("#text_email").text("Please enter the owner email");
                    pstatus = false;
                } else if ($('#password').val() == '' || $('#password').val() == null) {
                    $("#text_email").text("");
                    $("#text_password").text("Please enter the password");
                    pstatus = false;
                } else if ($('#businessNumber').val() == '' || $('#businessNumber').val() == null) {
                    $("#text_password").text("");
                    $("#text_businessNumber").text("Please enter the business phone number");
                    pstatus = false;
                } else if ($('#CountryList option:selected').val() == '' || $('#CountryList option:selected').val() == null) {
                    $("#text_businessNumber").text("");
                    $("#text_CountryList").text("Please select the country");
                    pstatus = false;
                } else if ($('#cityLists option:selected').val() == '' || $('#cityLists option:selected').val() == null) {
                    $("#text_CountryList").text("");
                    $("#text_cityLists").text("Please select the city");
                    pstatus = false;
                } else if ($('#entityAddress_0').val() == '' || $('#entityAddress_0').val() == null) {
                    $("#text_cityLists").text("");
                    $("#text_entityAddress_0").text("Please enter the business address");
                    pstatus = false;
                } else if ($('#serviceZones').val() == '' || $('#serviceZones').val() == null) {
                    $("#text_entityAddress_0").text("");
                    $("#serviceZonesErr").text("Please select the zones");
                    pstatus = false;
                }
//                else if ($('#posID').val() == '' || $('#posID').val() == null) {
//                    $("#serviceZonesErr").text("");
//                    $("#posIDErr").text("Please enter pos Id");
//                    pstatus = false;
//                }
                if (pstatus === false)
                {
                    console.log('pstatus-false');
                    $("#mtab2").removeAttr('data-toggle', 'tab');
                    $("#mtab2").removeAttr('href', '#tab2');
                    $("#mtab3").removeAttr('data-toggle', 'tab');
                    $("#mtab3").removeAttr('href', '#tab3');
                    $("#mtab4").removeAttr('data-toggle', 'tab');
                    $("#mtab4").removeAttr('href', '#tab4');

                    setTimeout(function ()
                    {
                        proceed(litabtoremove, divtabtoremove, 'firstlitab', 'tab1');
                    }, 300);
                    if (reason != '') {
                        alert(reason);
                    }
                    $("#tab1icon").removeClass("fs-14 fa fa-check");
                    return false;
                } else {

                    console.log('else');
                    $("#mtab2").attr('data-toggle', 'tab');
                    $("#mtab2").attr('href', '#tab2');
                    $("#mtab3").attr('data-toggle', 'tab');
                    $("#mtab3").attr('href', '#tab3');
                    $("#mtab4").attr('data-toggle', 'tab');
                    $("#mtab4").attr('href', '#tab4');

                }
                //        alert();
                //       $("#tab1icon").addClass("fs-14 fa fa-check");
                $("#prevbutton").removeClass("hidden");
                $("#nextbutton").addClass("hidden");
                $("#finishbutton").removeClass("hidden");

                return true;
            }


            function proceed(litabtoremove, divtabtoremove, litabtoadd, divtabtoadd)
            {
                console.log(litabtoremove);
                console.log(litabtoadd);
                $("#" + litabtoremove).removeClass("active");
                $("#" + divtabtoremove).removeClass("active");

                $("#" + litabtoadd).addClass("active");
                $("#" + divtabtoadd).addClass("active");
            }

            /*-----managing direct click on tab is over -----*/

            //manage next next and finish button
            function movetonext()
            {
                var currenttabstatus = $("li.active").attr('id');
                if (currenttabstatus === "firstlitab")
                {
                    profiletab('secondlitab', 'tab2');
                    proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');

//                    $("#nextbutton").removeClass("hidden");
                    $("#secondlitab").attr('class') === "active";


                }
            }

            function movetoprevious()
            {
                var currenttabstatus = $("li.active").attr('id');
                if (currenttabstatus === "secondlitab")
                {
                    profiletab('secondlitab', 'tab2');
                    proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
                    $("#prevbutton").removeClass("hidden");


                }
            }

        </script>
        <div class="modal fade in" id="ForMaps" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
            <div class="modal-dialog">

                <form action = "<?php echo base_url(); ?>index.php/superadmin/AddNewCenter" method= "post" onsubmit="return validateForm();">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:initial;">&times;</button>
                            <h4 class="modal-title">Drag Marker To See Address</h4>
                        </div>

                        <div class="modal-body"><div class="form-group" >
                                <div id="myMap" style="width: 544px; height: 250px;"></div><br/>
                                <div class="form-group">
                                    <label>Address</label>
<!--                                    <input type="text" class="form-control" value="" placeholder="Address ..." name="address" id="address" onkeyup="getAddLatLong(this);">$addressPos-->
                                    <textarea rows="4" cols="50" class="form-control" id="entityAddress1" placeholder="Address.." name="FData[businessAddress][0]"   onkeyup="getAddLatLong(this)"><?php echo "R T nagar"; ?></textarea>

                                </div> 

                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input type="text" readonly class="form-control" value="" placeholder="Latitude ..." name="latitude" id="latitude">
                                </div> 
                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input type="text" readonly class="form-control" value="" placeholder="Longitude ..." name="longitude" id="longitude">
                                </div> 

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick='Cancel();'>Close</button>
                            <input type="button" id="TakeMapAddress"  data-dismiss="modal" class="btn btn-primary" onclick='Take();' value="Take Address" >

                        </div>
                    </div>
                </form>


            </div>

        </div>