<?php
if ($storedata['currencySymbol'] == '') {
    $storedata['currencySymbol'] = '$';
}
?>

<link href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />

<style>     
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
        height: 20px;
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
    .MandatoryMarker{
        color:red;
    }
</style>
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
    span.abs_text1 {
        position: absolute;
        right:10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
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
    span.abs_textLeft {
        position: absolute;
        left: 12px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
    }
    .pos_relative2{
        padding-right:10px
    }
    .pos_relative ,.pos_relative2{
        position: relative;
        padding-right:0px
    }
    .phoneWidth{
        width: 270%;
    }
    .multiselect-container>li>a label.checkbox input[type="checkbox"] {
        margin-left: -20px !important;
    }
    ul.navbar-nav.navbar-left.nav.nav-tabs.nav-tabs-linetriangle.nav-tabs-separator.nav-stack-sm.fixednab {
        position: fixed;
        z-index: 999;
        width: 100%;
        top: 0;
        background: white;
    }
</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE"></script>

<script>
    var addressType = '';
    function callMap() {
        $('#ForMaps').modal('show');
        addressType = 1;
        if ($('#entiryLongitude').val() != "" && $('#entiryLatitude').val() != "") {
            initialize1($('#entiryLatitude').val(), $('#entiryLongitude').val());
            $('#mapentityAddress').val($('#entityAddress_0').val());
            $('#longitude').val($('#entiryLongitude').val());
            $('#latitude').val($('#entiryLatitude').val());
        } else {
            var loc = '';
            $('#mapentityAddress,#latitude,#longitude').val("");
            $.get("https://ipinfo.io/json", function (response) {
                loc = response.loc;
                var res = loc.split(",");
                initialize1(res[0], res[1]);
            }, "jsonp");
        }
    }

    function callMap1() {
        $('#ForMaps').modal('show');
        addressType = 2;
        if ($('#entityAddress_01').val() != "") {
            $('#mapentityAddress').val($('#entityAddress_01').val());
            $.ajax({
                url: "<?php echo base_url(); ?>application/views/get_latlong.php",
                method: "POST",
                data: {Address: $('#mapentityAddress').val()},
                datatype: 'json', // fix: need to append your data to the call
                success: function (data) {
                    var Arr = JSON.parse(data);
                    console.log(data);
                    if (Arr.flag == 1) {
                        $('#latitude').val(Arr.Lat);
                        $('#longitude').val(Arr.Long);
                        initialize1(Arr.Lat, Arr.Long, '0');
                    }
                }
            });
        } else {
            var loc = '';
            $.get("https://ipinfo.io/json", function (response) {
                loc = response.loc;
                var res = loc.split(",");
                initialize1(res[0], res[1]);
            }, "jsonp");
        }
    }

    function Take() {
        if (addressType == 1) {
            $('#entiryLongitude').val($('#longitude').val());
            $('#entiryLatitude').val($('#latitude').val());
            $('.entityAddress').val($('#mapentityAddress').val());
//            $('.entityAddress1').val($('#mapentityAddress').val());

        } else if (addressType == 2) {
            $('#entityAddress_01').val($('#mapentityAddress').val());
        }
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

                        $('#mapentityAddress').val(results[0].formatted_address);

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

        var addr = $('#entityAddress_0').val();
        if (!addr) {
            var addr = text;
        }
        $.ajax({
            url: "<?php echo base_url(); ?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
//                console.log(data);
                $('#entiryLatitude').val(Arr.Lat);
                $('#entiryLongitude').val(Arr.Long);
                $('#entitypostalcode').val(Arr.Zipcode);
                initialize1(Arr.Lat, Arr.Long, '0');
            }
        });
    }
    function getAddLatLong(text) {

        var addr = $('#mapentityAddress').val();
        if (!addr) {
            var addr = text;
        }
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
                initialize1(Arr.Lat, Arr.Long, '1');
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
            placeCom(place);
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
<script type="text/javascript">

function placeCom(place){

       var address = place.address_components;
       tempData =  {};
       var city, state, zip;
           
    address.forEach(function(component) {
            var types = component.types;
            
            if (types.indexOf('locality') > -1) {
                city = component.long_name;
                tempData['locality'] = city; 
            }

            if (types.indexOf('administrative_area_level_1') > -1) {
                state = component.short_name;
                tempData['administrative_area_level_1'] = state; 
            }

            if (types.indexOf('postal_code') > -1) {
                zip = component.long_name;
                tempData['postal_code'] = zip; 
            }

             if (types.indexOf('route') > -1) {
                route = component.long_name;
                tempData['route'] = route; 
            }            

             if (types.indexOf('sublocality_level_1') > -1) {
                sublocality1 = component.long_name;
                tempData['sublocality_level_1'] = sublocality1; 
            }

             if (types.indexOf('sublocality_level_2') > -1) {
                sublocality2 = component.long_name;
                tempData['sublocality_level_2'] = sublocality2; 
            }

             if (types.indexOf('administrative_area_level_2') > -1) {
                admin1 = component.long_name;
                tempData['administrative_area_level_2'] = admin1; 
            }
            
            if (types.indexOf('country') > -1) {
                country = component.long_name;
                tempData['country'] = country; 
            }         

    });

        console.log('addressCompo--->',tempData);
        var tempDataval = JSON.stringify(tempData);
        $('#addressCompo').val(tempDataval);
        $('#streetname').val(tempData['route']);
        $('#localityname').val(tempData['sublocality_level_2']);
        $('#areaname').val(tempData['sublocality_level_1']);
     


}
</script>
<script>
    selectarr = [];
    $(document).ready(function () {
        var select = '<?php echo $storedata['orderType'] ?>';
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

        var val = '<?php echo $storedata['forcedAccept'] ?>';
        if (val) {
            if (val == 1) {
                $('#forcedAccept').prop('checked', true);
            } else if (val == 2) {
                $('#forcedAccept').prop('checked', false);
            }
        }
        var autoDispatch = '<?php echo $storedata['autoDispatch'] ?>';
        if (autoDispatch) {
            if (autoDispatch == 1) {
                $('#autoDispatch').prop('checked', true);
            } else if (val == 0) {
                $('#autoDispatch').prop('checked', false);
            }
        }

        var autoApproval = '<?php echo $storedata['autoApproval'] ?>';
        if (autoApproval) {
            if (autoApproval == 1) {
                $('#Autoapproval').prop('checked', true);
            } else if (autoApproval == 0) {
                $('#Autoapproval').prop('checked', false);
            }
        }

        var pricingStaus = '<?php echo $storedata['pricingStatus'] ?>';
        if (pricingStaus == '0') {
            $('#tab3').hide();
        } else {
            $('#tab3').show();
        }

        $('.pricing_').click(function () {
            var select = $("input[name='price']:checked").val();
            if (select == 1) {
                $('#tab3').show();
            } else {
                $('#tab3').hide();
            }
        });

        $(window).scroll(function () {
            var scr = jQuery(window).scrollTop();

            if (scr > 0) {
                $('#mytabs').addClass('fixednab');
            } else {
                $('#mytabs').removeClass('fixednab');
            }
        });

        $("#businessNumber").intlTelInput("setNumber", '');
        $("#phone").intlTelInput("setNumber", '');

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });
        $('.error-box-class').change(function () {
            $('.error-box').text('');
        });

        $("#businessNumber").on("countrychange", function (e, countryData) {
            $("#bcountryCode").val(countryData.dialCode);
        });
        $("#phone").on("countrychange", function (e, countryData) {
            $("#countryCode").val(countryData.dialCode);
        });

        $.ajax({
            url: "<?php echo base_url() ?>index.php?/business/getZones",
            type: 'POST',
            dataType: 'json',
            data: {
                val: '<?php echo $storedata['cityId'] ?>'
            },
        }).done(function (json) {
            arr = [];
            $("#serviceZones").multiselect('destroy');

            if (json.data.length > 0) {
                var serviceZone = '';

                var selectedZones = [];

<?php foreach ($storedata['serviceZones'] as $servicezone) { ?>
                    selectedZones.push('<?php echo $servicezone; ?>');
<?php } ?>

                for (var i = 0; i < json.data.length; i++) {
                    var selected = '';

                    if (selectedZones.indexOf(json.data[i].id) !== -1) {
                        selected = 'selected';
                    }
                    serviceZone = "<option value=" + json.data[i].id + " " + selected + ">" + json.data[i].title + "</option>";
                    $("#serviceZones").append(serviceZone);
                    arr.push(json.data[i].id);

                }

                $('#serviceZones').multiselect('destroy').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    buttonWidth: '500px',
                    maxHeight: 300,
                });
            }
        });



        $('#cityLists').on('change', function () {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/business/getZones",
                type: 'POST',
                dataType: 'json',
                data: {
                    val: $('#cityLists').val()
                },
            }).done(function (json) {
//                console.log(json);
                $("#serviceZones").multiselect('destroy');
                var serviceZone = '';
                if (json.data.length > 0) {
                    for (var i = 0; i < json.data.length; i++) {
                        serviceZone += "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
//                        select.append(json.data[i].id);
                    }

                } else {
                    serviceZone = "<option value=''>No zones found</option>";
                    $("#serviceZones").html(serviceZone);
                }
                $("#serviceZones").html(serviceZone);
                $('#serviceZones').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    buttonWidth: '500px',
                    maxHeight: 300,
                });

            });

        });

        $('.basefare').hide();

        $('#cityLists').change(function () {
            $('#cityname').val($('#cityLists option:selected').text());
            $('#baseFare').val($('#cityLists option:selected').attr('baseFare'));
            $('#mileagePrice').val($('#cityLists option:selected').attr('mileagePrice'));
            $('#mileagePriceAfter').val($('#cityLists option:selected').attr('mileageAfter'));
            $('#timeFee').val($('#cityLists option:selected').attr('timeFee'));
            $('#timeFeeAfter').val($('#cityLists option:selected').attr('timeFeeAfter'));
            $('#waitingFee').val($('#cityLists option:selected').attr('waitingFee'));
            $('#waitingFeeAfter').val($('#cityLists option:selected').attr('waitingFeeAfter'));
            $('#minimumFare').val($('#cityLists option:selected').attr('minimumFare'));
            $('#onDemandBookingsCancellationFee').val($('#cityLists option:selected').attr('onDemandCanFee'));
            $('#onDemandBookingsCancellationFeeAfter').val($('#cityLists option:selected').attr('onDemandCanFeeAfter'));
            $('#ScheduledBookingsCancellationFee').val($('#cityLists option:selected').attr('scheduledCanFee'));
            $('#ScheduledBookingsCancellationFeeAfter').val($('#cityLists option:selected').attr('scheduledCanFeeAfter'));
            $('#convenienceFee').val($('#cityLists option:selected').attr('convenienceFee'));
            $('.currencySymbol').text($('#cityLists option:selected').attr('currencySymbol'));
        });

        $.ajax({
            url: "<?php echo base_url(); ?>index.php?/Business/getCityList",
            type: 'POST',
            data: {val: '<?php echo $storedata['countryId']; ?>'},
            datatype: 'json', // fix: need to append your data to the call
            success: function (response) {
//                     console.log(response);
                $('#cityLists').empty();
                var r = JSON.parse(response);
                var html = '';
                html = '<option value="">Select City</option>'
                $.each(r, function (index, row) {
                    if ('<?php echo $storedata['cityId'] ?>' == row.cityId.$oid) {
                        html += '<option currencySymbol="' + row.currencySymbol + '" baseFare="' + row.baseFare + '" mileagePrice="' + row.mileagePrice + '" mileageAfter="' + row.mileagePriceAfterMinutes + '" timeFee="' + row.timeFee + '" timeFeeAfter="' + row.timeFeeAfterMinutes + '" waitingFee="' + row.waitingFee + '" waitingFeeAfter="' + row.waitingFeeAfterMinutes + '" minimumFare="' + row.minimumFare + '" onDemandCanFee="' + row.onDemandBookingsCancellationFee + '" onDemandCanFeeAfter="' + row.onDemandBookingsCancellationFeeAfterMinutes + '" scheduledCanFee="' + row.scheduledBookingsCancellationFee + '"   scheduledCanFeeAfter="' + row.scheduledBookingsCancellationFeeAfterMinutes + '" convenienceFee="' + row.convenienceFee + '"  data-name="' + row.cityName + '" data-name="' + row.cityName + '"value="' + row.cityId.$oid + '" selected>' + row.cityName + '</option>';
                        $('.currencySymbol').text(row.currencySymbol);
                        $('#currencySymbol').val(row.currencySymbol);
                    } else {
                        html += '<option currencySymbol="' + row.currencySymbol + '" baseFare="' + row.baseFare + '" mileagePrice="' + row.mileagePrice + '" mileageAfter="' + row.mileagePriceAfterMinutes + '" timeFee="' + row.timeFee + '" timeFeeAfter="' + row.timeFeeAfterMinutes + '" waitingFee="' + row.waitingFee + '" waitingFeeAfter="' + row.waitingFeeAfterMinutes + '" minimumFare="' + row.minimumFare + '" onDemandCanFee="' + row.onDemandBookingsCancellationFee + '" onDemandCanFeeAfter="' + row.onDemandBookingsCancellationFeeAfterMinutes + '" scheduledCanFee="' + row.scheduledBookingsCancellationFee + '"   scheduledCanFeeAfter="' + row.scheduledBookingsCancellationFeeAfterMinutes + '" convenienceFee="' + row.convenienceFee + '"  data-name="' + row.cityName + '" data-name="' + row.cityName + '"value="' + row.cityId.$oid + '" >' + row.cityName + '</option>';
                    }
                });
                $('#cityLists').append(html);
            }
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
//                        console.log(row);
                        html += '<option currencySymbol="' + row.currencySymbol + '" baseFare="' + row.baseFare + '" mileagePrice="' + row.mileagePrice + '" mileageAfter="' + row.mileagePriceAfterMinutes + '" timeFee="' + row.timeFee + '" timeFeeAfter="' + row.timeFeeAfterMinutes + '" waitingFee="' + row.waitingFee + '" waitingFeeAfter="' + row.waitingFeeAfterMinutes + '" minimumFare="' + row.minimumFare + '" onDemandCanFee="' + row.onDemandBookingsCancellationFee + '" onDemandCanFeeAfter="' + row.onDemandBookingsCancellationFeeAfterMinutes + '" scheduledCanFee="' + row.scheduledBookingsCancellationFee + '"   scheduledCanFeeAfter="' + row.scheduledBookingsCancellationFeeAfterMinutes + '" convenienceFee="' + row.convenienceFee + '"  data-name="' + row.cityName + '"value="' + row.cityId.$oid + '">' + row.cityName + '</option>';
                    });
                    $('#cityLists').append(html);
                }
            });
        });

        // $.ajax({
        //     url: "<?php echo base_url(); ?>index.php?/Business/getSubcatList",
        //     type: 'POST',
        //     data: {val: $('#CategoryList').val()},
        //     datatype: 'json', // fix: need to append your data to the call
        //     success: function (response) {
        //         $('#subcatLists').empty();
        //             var r = JSON.parse(response);
        //             var html = '';
        //             var listData='';
        //             var langData = <?php echo json_encode($language); ?>;
        //             html = '<option value="">Select Sub Category</option>'
        //             $.each(r, function (index, row) {
        //                 listData= (row.storeSubCategoryName.en);
        //             $.each(langData,function(i,lngrow){
        //                 lngcode= lngrow.langCode;
        //                 var lngvalue = row.storeSubCategoryName.lngcode;
        //                 lngvalue = (lngvalue==''|| lngvalue==null )?" ":lngvalue;
        //                listData +=","+lngvalue; 
        //               // console.log(listData);
        //             });


        //                  if ('<?php echo $storedata['subCategoryId'] ?>' == row._id.$oid) {
        //                 html += '<option selected data-name="' + row.name + '"value="' + row._id.$oid + '">' + listData + '</option>';
        //             }else{
        //                html += '<option data-name="' + row.name + '"value="' + row._id.$oid + '">' + listData + '</option>'; 
        //             }
        //             });
        //             $('#subcatLists').html(html);
        //     }
        // });

        $('#CategoryList').on('change', function () {

            var val = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Business/getSubcatList",
                type: 'POST',
                data: {val: val},
                datatype: 'json', // fix: need to append your data to the call
                success: function (response) {
                    $('#subcatLists').empty();
                    var r = JSON.parse(response);
                    var html = '';
                    var listData='';
                    var langData = <?php echo json_encode($language); ?>;
                    html = '<option value="">Select Sub Category</option>'
                    // $.each(r, function (index, row) {
                    //     html += '<option data-name="' + row.name + '"value="' + row._id.$oid + '">' + row.name + '</option>';
                    // });
                    $.each(r, function (index, row) {
                        listData= (row.storeSubCategoryName.en);
                    $.each(langData,function(i,lngrow){
                        lngcode= lngrow.langCode;
                        var lngvalue = row.storeSubCategoryName.lngcode;
                        lngvalue = (lngvalue==''|| lngvalue==null )?" ":lngvalue;
                       listData +=","+lngvalue; 
                      // console.log(listData);
                    });
                    
                       html += '<option data-name="' + row.name + '"value="' + row._id.$oid + '">' + listData + '</option>'; 
                    
                    });
                    $('#subcatLists').html(html);
                }
            });


        });


        $('#edit').click(function () {
            var status = '<?php echo $status; ?>';
            $('.clearerror').text("");

            var BusinessName = new Array();
            $(".businessname").each(function () {
                BusinessName.push($(this).val());
            });
            var serviceZones = $("#serviceZones").val();

            var locationId = "<?php echo $locationId; ?>";
            var urlData = "<?php echo $urlData; ?>";
            var Description = new Array();
            $(".description").each(function () {
                Description.push($(this).val());
            });

            var Address = $('#entityAddress_0').val();
            //            $(".entityAddress").each(function () {
            //                Address.push($(this).val());
            //            });
            var billingAddress = $('#entityAddress_01').val();
            //            $(".entityAddress1").each(function () {
            //                billingAddress.push($(this).val());
            //            });
            var posID = $('#posID').val();
            var businessNumber = $('#businessNumber').val();
            var countryCode = $('#countryCode').val();
            var bCountryCode = $('#bcountryCode').val();
            var baseFare = $('#baseFare').val();
            var mileagePrice = $('#mileagePrice').val();
            var mileagePriceAfterMinutes = $('#mileagePriceAfter').val();
            var timeFee = $('#timeFee').val();
            var timeFeeAfterMinutes = $('#timeFeeAfter').val();
            var waitingFee = $('#waitingFee').val();
            var waitingFeeAfterMinutes = $('#waitingFeeAfter').val();
            var minimumFare = $('#minimumFare').val();
            var onDemandBookingsCancellationFee = $('#onDemandBookingsCancellationFee').val();
            var onDemandBookingsCancellationFeeAfterMinutes = $('#onDemandBookingsCancellationFeeAfter').val();
            var scheduledBookingsCancellationFee = $('#ScheduledBookingsCancellationFee').val();
            var scheduledBookingsCancellationFeeAfterMinutes = $('#ScheduledBookingsCancellationFeeAfter').val();
            var convenienceFee = $('#convenienceFee').val();
            var currencySymbol = $('#currencySymbol').val();
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
            var addressCompo=$('#addressCompo').val();
            var areaname = $('#areaname').val();
            var streetname = $('#streetname').val();
            var localityname = $('#localityname').val();

            var driverType = $("input[name='select_driver']:checked").val();
            var forcedAccept = $("input[name='forcedAccept']:checked").val();

            var autoDispatch = $("input[name='autoDispatch']:checked").val();
            var Autoapproval = $("input[name='FData[autoApproval]']:checked").val();

            // var CategoryList = $("#CategoryList").val();
            // var SubCategoryList = $("#subcatLists").val();

            var grocerDriver = $("#grocerDriver").val();
            var storeDriver = $("#storeDriver").val();
            var Offlinedriver = $("#Offlinedrivers").val();
            var tier1 = parseInt($("#tier1").val());
            var tier2 = parseInt($("#tier2").val());
            var tier3 = parseInt($("#tier3").val());
            var notes = $("#notes").val();
            var minorderVal = $('#entiryminorderVal').val();
            var freedelVal = $('#freedelVal').val();
            var avgDeliveryTime = $('#avgDeliveryTime').val();

            var profileImage = $('#PdefaultImages').val();
            if (profileImage == '') {
                profileImage = $('#viewPimage_hidden').val();
            }

            var profileAllText = $('#pAltText').val();
            if (typeof profileAllText == 'undefined') {
                profileAllText = '<?php echo $storedata['profileLogos']['seoAllText']; ?>';
            }
            var profileSeoTitle = $('#pSeoTitle').val();
            if (typeof profileSeoTitle == 'undefined') {
                profileSeoTitle = '<?php echo $storedata['profileLogos']['seoTitle']; ?>';
            }
            var profileSeoDesc = $('#pSeoDescription').val();
            if (typeof profileSeoDesc == 'undefined') {
                profileSeoDesc = '<?php echo $storedata['profileLogos']['seoDescription']; ?>';
            }
            var profileSeoKeyword = $('#pSeoKeyword').val();
            if (typeof profileSeoKeyword == 'undefined') {
                profileSeoKeyword = '<?php echo $storedata['profileLogos']['seoKeyword']; ?>';
            }

            var bannerImage = $('#BdefaultImages').val();
            if (bannerImage == '') {
                bannerImage = $('#viewBimage_hidden').val();
            }
            var bannerAllText = $('#bAltText').val();
            if (typeof bannerAllText == 'undefined') {
                bannerAllText = '<?php echo $storedata['bannerLogos']['seoAllText']; ?>';
            }
            var bannerSeoTitle = $('#bSeoTitle').val();
            if (typeof bannerSeoTitle == 'undefined') {
                bannerSeoTitle = '<?php echo $storedata['bannerLogos']['seoTitle']; ?>';
            }
            var bannerSeoDesc = $('#bSeoDescription').val();
            if (typeof bannerSeoDesc == 'undefined') {
                bannerSeoDesc = '<?php echo $storedata['bannerLogos']['seoDescription']; ?>';
            }
            var bannerSeoKeyword = $('#bSeoKeyword').val();
            if (typeof bannerSeoKeyword == 'undefined') {
                bannerSeoKeyword = '<?php echo $storedata['bannerLogos']['seoKeyword']; ?>';
            }

            var select = $('.accepts:checked').val();
            var basefare = $('#basefare').val();
            var range = $('#range').val();
            var priceperkm = $('#Priceperkm').val();

            if ($("#Pcash").is(':checked')) {
                var Pcash = 1;
            } else {
                var Pcash = 0;
            }

            if ($("#Pcredit_card").is(':checked')) {
                var Pcredit_card = 1;
            } else {
                var Pcredit_card = 0;
            }

            if ($("#Dcash").is(':checked')) {
                var Dcash = 1;
            } else {
                var Dcash = 0;
            }
            if ($("#Dcredit_card").is(':checked')) {
                var Dcredit_card = 1;
            } else {
                var Dcredit_card = 0;
            }

            var Facebook = $('#Facebook').val();
            var Twitter = $('#Twitter').val();
            var Instagram = $('#Instagram').val();
            var LinkedIn = $('#LinkedIn').val();
            var Google = $('#Google').val();

            var passwordstrong = /^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,15}$/;
            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            var bName = $('#businessname_0').val();

            if (bName == '' || bName == null) {
                $("#businessname_0").focus();
                $("#text_businessname_0").text("<?php echo $this->lang->line('error_Name'); ?>");
            } 
            else if ($('#ownername').val().trim() == '' || $('#ownername').val().trim() == null) {
                $("#ownername").focus();
                $("#text_ownername").text("<?php echo $this->lang->line('error_OwnerName'); ?>");
            } else if ($('#email').val().trim() == '' || $('#email').val().trim() == null) {
                $("#email").focus();
                $("#text_email").text("<?php echo $this->lang->line('error_OwnerEmail'); ?>");
            } 
            else if ($('#businessNumber').val().trim() == '' || $('#businessNumber').val().trim() == null) {
                $("#businessNumber").focus();
                $("#text_businessNumber").text("<?php echo $this->lang->line('error_BusinessPhone'); ?>");
            } else if ($('#CountryList option:selected').val() == '' || $('#CountryList option:selected').val() == null) {
                $("#CountryList").focus();
                $("#text_CountryList").text("<?php echo $this->lang->line('error_Country'); ?>");
            } 
            else if ($('#cityLists option:selected').val() == '' || $('#cityLists option:selected').val() == null) {
                $("#cityLists").focus();
                $("#text_cityLists").text("<?php echo $this->lang->line('error_City'); ?>");
            }
             else if ($('#entityAddress_0').val() == '' || $('#entityAddress_0').val() == null) {
                $("#entityAddress_0").focus();
                $("#text_entityAddress_0").text("<?php echo $this->lang->line('error_BAddress'); ?>");
            } else if (pricing == '' || pricing == null) {
                $(".pricing_").focus();
                $("#text_pricing").text("<?php echo $this->lang->line('error_pricing'); ?>");
            } else if (minorderVal == '' || minorderVal == null) {
                $("#entiryminorderVal").focus();
                $("#text_entiryminorderVal").text("<?php echo $this->lang->line('error_entiryminorderVal'); ?>");
            } else if (freedelVal == '' || freedelVal == null) {
                $("#freedelVal").focus();
                $("#text_freedelVal").text("<?php echo $this->lang->line('error_freedelVal'); ?>");
            } else if ($('#serviceZones').val() == '' || $('#serviceZones').val() == null) {
                $("#serviceZones").focus();
                $("#serviceZonesErr").text("<?php echo $this->lang->line('error_Zones'); ?>");
            } else if ($('.accepts:checked').val() == '' || $('.accepts:checked').val() == null) {
                $("accepts").focus();
                $('#text_accepts').text("<?php echo $this->lang->line('error_orderType'); ?>");
            } else if (select == '1' && ($('.Pcheckbox_:checked').val() == '' || $('.Pcheckbox_:checked').val() == null)) {
                $('#text_paymentp').show();
                $('#text_dpayment').hide();
                $(".Pcheckbox").focus();
                $('#text_accepts').text('');
                $('#text_paymentp').text("<?php echo $this->lang->line('error_paymentType'); ?>");
            } else if (select == '2' && ($('.Dcheckbox_:checked').val() == '' || $('.Dcheckbox_:checked').val() == null)) {
                $(".Dcheckbox").focus();
                $('#text_dpayment').show();
                $('#text_dpayment').text("<?php echo $this->lang->line('error_paymentType'); ?>");
            } else if (select == '3' && ($('.Pcheckbox_:checked').val() == '' || $('.Pcheckbox_:checked').val() == null || $('.Dcheckbox_:checked').val() == '' || $('.Dcheckbox_:checked').val() == null)) {
                $('#text_dpayment').show();
                if ($('.Pcheckbox_:checked').val() == '' || $('.Pcheckbox_:checked').val() == null) {
                    $(".Pcheckbox_").focus();
                    $('#text_paymentp').text("<?php echo $this->lang->line('error_paymentTypes'); ?>");
                }
                if ($('.Dcheckbox_:checked').val() == '' || $('.Dcheckbox_:checked').val() == null) {
                    $(".Dcheckbox_").focus();
                    $('#text_dpayment').text("<?php echo $this->lang->line('error_paymentTypes'); ?>");
                }
            } 
            else {
                $.ajax({
                    url: "<?php echo base_url('index.php?/Business') ?>/operationBusiness/edit",
                    type: 'POST',
                    data: {
                        storeId: '<?php echo $storedata['_id']['$oid']; ?>',
                        commission: '<?php echo $storedata['commission']; ?>',
                        commissionType: '<?php echo $storedata['commissionType']; ?>',
                        profileImage: profileImage,
                        profileAllText: profileAllText,
                        profileSeoTitle: profileSeoTitle,
                        profileSeoDesc: profileSeoDesc,
                        profileSeoKeyword: profileSeoKeyword,
                        currencySymbol: currencySymbol,
                        baseFare: baseFare,
                        mileagePrice: mileagePrice,
                        mileagePriceAfterMinutes: mileagePriceAfterMinutes,
                        timeFee: timeFee,
                        timeFeeAfterMinutes: timeFeeAfterMinutes,
                        waitingFee: waitingFee,
                        waitingFeeAfterMinutes: waitingFeeAfterMinutes,
                        minimumFare: minimumFare,
                        onDemandBookingsCancellationFee: onDemandBookingsCancellationFee,
                        onDemandBookingsCancellationFeeAfterMinutes: onDemandBookingsCancellationFeeAfterMinutes,
                        scheduledBookingsCancellationFee: scheduledBookingsCancellationFee,
                        scheduledBookingsCancellationFeeAfterMinutes: scheduledBookingsCancellationFeeAfterMinutes,
                        convenienceFee: convenienceFee,

                        bannerImage: bannerImage,
                        bannerAllText: bannerAllText,
                        bannerSeoTitle: bannerSeoTitle,
                        bannerSeoDesc: bannerSeoDesc,
                        bannerSeoKeyword: bannerSeoKeyword,

                        BusinessName: BusinessName,
                        OwnerName: OwnerName,
                        countryCode: countryCode,

                        Phone: Phone,
                        Email: Email,
                        Password: Password,
                        Website: Website,
                        Description: Description,
                        storeaddress: Address,
                        billingAddress: billingAddress,
                        Longitude: Longitude,
                        Latitude: Latitude,
                        Country: Country,
                        city: city,
                        cityName: cityName,
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
                        Dcash: Dcash,
                        Dcredit_card: Dcredit_card,
                        avgcooktime: avgcooktime,
                        Budget: Budget,
                        grocerDriver: grocerDriver,
                        storeDriver: storeDriver,
                        bCountryCode: bCountryCode,
                        businessNumber: businessNumber,
                        Offlinedriver: Offlinedriver,
                        serviceZones: serviceZones,
                        posID: posID,
                        locationId: locationId,
                        driverType: driverType,
                        forcedAccept: forcedAccept,
                        Autoapproval: Autoapproval,
                        autoDispatch: autoDispatch,
                        // CategoryId: CategoryList,
                        // SubCategoryId: SubCategoryList,
                        Facebook: Facebook,
                        Twitter: Twitter,
                        Instagram: Instagram,
                        LinkedIn: LinkedIn,
                        Google: Google,
                        avgDeliveryTime: avgDeliveryTime,
                        addressCompo: addressCompo,
                        streetname:streetname,
                        localityname:localityname,
                        areaname:areaname

                    },
                    dataType: 'JSON',
                    async: true,
                    success: function (response)
                    {
                        window.location.href = "<?php echo base_url('index.php?') ?>/Business";
                    }

                });
            }
        });

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
                                        <textarea class="form-control" id="Adress_' + $(val).val() + '" placeholder="Address" name="Address[0]" style="max-width:100%;" aria-required="true" onkeyup="getAddLatLong1(this)"></textarea>\
                                    </div>\
                                  </div>';
                $('#Address_txt').append(html);
            } else {
                $('.cat_lan_' + $(this).val()).remove();
            }
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
                $('#mytabs').addClass('fixednab');
            } else {
                $('#mytabs').removeClass('fixednab');
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


        $(document).on('change', '.imagesPStore', function () {

            $('#text_images').text("");
            var fieldID = $(this).attr('attrId');
            var ext = $(this).val().split('.').pop().toLowerCase();
            var formElement = $(this).prop('files')[0];
            uploadImage(fieldID, ext, formElement);

        });
        $(document).on('change', '.imagesBStore', function () {

            $('#text_images').text("");
            var fieldID = $(this).attr('attrId');
            var ext = $(this).val().split('.').pop().toLowerCase();
            var formElement = $(this).prop('files')[0];
            uploadImage(fieldID, ext, formElement);

        });

    });

    function uploadImage(fieldID, ext, formElement)
    {
        $('.modalPopUpText').text('');
        // fieldID : 0 - profileimage, 1- bannerimage
        if ($.inArray(ext, ['jpg', 'JPEG']) == -1) {
            $('#errorModal').modal('show');
            $('.modalPopUpText').text('<?php echo $this->lang->line('error_imageformat'); ?>');
        } else
        {
            var form_data = new FormData();
            var amazonPath = "http://s3.amazonaws.com"
            form_data.append('sampleFile', formElement);
            $(document).ajaxStart(function () {
                $("#wait").css("display", "block");
            });
            $.ajax({
                url: "<?php echo uploadImageLink; ?>",
                type: "POST",
                data: form_data,
                dataType: "JSON",

                beforeSend: function () {

                },
                success: function (response) {
                    if (response.code == '200') {
                        if (fieldID == '0') {
                            $.each(response.data, function (index, row) {
                                switch (index) {
                                    case 0:
                                        $('#thumbnailImages').val(amazonPath + row.path);
                                        break;
                                    case 1:
                                        $('#mobileImages').val(amazonPath + row.path);
                                        break;
                                    case 2:
                                        $('#PdefaultImages').val(amazonPath + row.path);
                                        break;
                                }
                                $(document).ajaxComplete(function () {
                                    $("#wait").css("display", "none");
                                });
                            });
                        } else if (fieldID == '1') {
                            $.each(response.data, function (index, row) {
                                //                                console.log(row);
                                switch (index) {
                                    case 0:
                                        $('#thumbnailImages').val(amazonPath + row.path);
                                        break;
                                    case 1:
                                        $('#mobileImages').val(amazonPath + row.path);
                                        break;
                                    case 2:
                                        $('#BdefaultImages').val(amazonPath + row.path);
                                        break;
                                }
                                $(document).ajaxComplete(function () {
                                    $("#wait").css("display", "none");
                                });
                            });

                        }
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

    $(document).on('click', "#btAddSeoP", function () {

        var imageval = $("#Pimage").val();
        if (imageval == '') {
            imageval = $("#viewPimage_hidden").val();
        }
        $('#addSeoModal').html('');

        var html1 = '';
        if (imageval != "") {
            html1 = '<div class="modal-header">'
                    + '<span class="modal-title"><?php echo $this->lang->line('label_PSeo'); ?></span>'
                    + '<button type="button" class="close" data-dismiss="modal">&times;</button>'
                    + '</div>'
                    + '<div class="modal-body form-horizontal">'
                    + '<form action="" method="post" id="addManagerrForm" data-parsley-validate="" class="form-horizontal form-label-left">'
                    + '<div class="form-group" class="formex">'
                    + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_AltText'); ?></label>'
                    + '<div class="col-sm-6">'
                    + '<input type="text"  id="AltText" name="profileImage[imageallText]"  class="form-control" value="<?php echo $storedata['profileLogos']['seoAllText']; ?>">'
                    + '</div>'
                    + '<div class="col-sm-3 errors" id="Alt_TextErr"></div>'
                    + '</div>'
                    + '<div class="form-group" class="formex">'
                    + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoTitle'); ?></label>'
                    + '<div class="col-sm-6">'
                    + '<input type="text"  id="SeoTitle" name="profileImage[seoTitle]"  class="form-control" value="<?php echo $storedata['profileLogos']['seoTitle']; ?>">'
                    + '</div>'
                    + '<div class="col-sm-3 errors" id="SeoTitleErr"></div>'
                    + '</div>'
                    + '<div class="form-group" class="formex">'
                    + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoDescription'); ?></label>'
                    + '<div class="col-sm-6">'
                    + '<input type="text"  id="SeoDescription" name="profileImage[seoDescription]" class="form-control" value="<?php echo $storedata['profileLogos']['seoDescription']; ?>">'
                    + '</div>'
                    + '<div class="col-sm-3 errors" id="SeoDescriptionErr"></div>'
                    + '</div>'
                    + '<div class="form-group" class="formex">'
                    + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoKeyword'); ?></label>'
                    + '<div class="col-sm-6">'
                    + '<input type="text"  id="SeoKeyword" name="profileImage[seoKeyword]" class="form-control" value="<?php echo $storedata['profileLogos']['seoKeyword']; ?>">'
                    + '</div>'
                    + '<div class="col-sm-3 errors" id="SeoKeywordErr"></div>'
                    + '</div>'
                    + '</form>'
                    + '</div>'
                    + '<div class="modal-footer">'

                    + '<div class="col-sm-4 error-box" id="errorpass"></div>'
                    + '<div class="col-sm-8" >'
                    + '<div class="pull-right m-t-10"><button type="button" class="btn btn-primary pull-right" id="insertPSeo"><?php echo $this->lang->line('button_add'); ?></button></div>'
                    + '<div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('button_Cancel'); ?></button></div>'
                    + '</div>'
                    + '</div>';

            $('#addSeoModal').append(html1);
            $('#seoModal').modal('show');
        } else {
            $("#Pimage").focus();
        }

    });

    $(document).on('click', "#insertPSeo", function () {
        $('.close').trigger('click');

        if ($('#SeoTitle').val() == '') {
            $('#SeoTitle').val($('#AltText').val())
        }
        if ($('#SeoKeyword').val() == "") {
            var seoDescription = $("#SeoDescription").val();
            var seoKeyword = seoDescription.replace(" ", ",");
            $("#SeoKeyword").val(seoKeyword);
        } else {
            var seoKeywordid = $('#SeoKeyword').val();
            var seoKeyword = seoKeywordid.replace(" ", ",");
            $("#SeoKeyword").val(seoKeyword);
        }
        html = '<div id="Seodata" >'
                + '<input type="text"  id="pAltText" name="profileImage[imageAllText]"  class="form-control" value="' + $('#AltText').val() + '">'
                + '<input type="text"  id="pSeoTitle" name="profileImage[seoTitle]"  class="form-control" value="' + $('#SeoTitle').val() + '">'
                + '<input type="text"  id="pSeoDescription" name="profileImage[seoDescription]" class="form-control" value="' + $('#SeoDescription').val() + '">'
                + '<input type="text"  id="pSeoKeyword" name="profileImage[seoKeyword]" class="form-control" value="' + $('#SeoKeyword').val() + '">'
                + '</div>';

        $('.PimageData').append(html);

    });

    $(document).on('click', "#btAddSeoB", function () {

        var imageval = $("#Bimage").val();
        if (imageval == '') {
            imageval = $("#viewBimage_hidden").val();
        }

        $('#addSeoModal').html('');

        var html2 = '';
        if (imageval != "") {
            html2 = '<div class="modal-header">'
                    + '<span class="modal-title"><?php echo $this->lang->line('label_BSeo'); ?></span>'
                    + '<button type="button" class="close" data-dismiss="modal">&times;</button>'
                    + '</div>'
                    + '<div class="modal-body form-horizontal">'
                    + '<form action="" method="post" id="addManagerrForm" data-parsley-validate="" class="form-horizontal form-label-left">'
                    + '<div class="form-group" class="formex">'
                    + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_AltText'); ?></label>'
                    + '<div class="col-sm-6">'
                    + '<input type="text"  id="BAltText" name="bannerImage[imageText]"  class="form-control" value="<?php echo $storedata['bannerLogos']['seoAllText']; ?>">'
                    + '</div>'
                    + '<div class="col-sm-3 errors" id="Alt_TextErr"></div>'
                    + '</div>'
                    + '<div class="form-group" class="formex">'
                    + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoTitle'); ?></label>'
                    + '<div class="col-sm-6">'
                    + '<input type="text"  id="BSeoTitle" name="bannerImage[seoTitle]"  class="form-control" value="<?php echo $storedata['bannerLogos']['seoTitle']; ?>">'
                    + '</div>'
                    + '<div class="col-sm-3 errors" id="SeoTitleErr"></div>'
                    + '</div>'
                    + '<div class="form-group" class="formex">'
                    + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoDescription'); ?></label>'
                    + '<div class="col-sm-6">'
                    + '<input type="text"  id="BSeoDescription" name="bannerImage[seoDescription]" class="form-control" value="<?php echo $storedata['bannerLogos']['seoDescription']; ?>">'
                    + '</div>'
                    + '<div class="col-sm-3 errors" id="SeoDescriptionErr"></div>'
                    + '</div>'
                    + '<div class="form-group" class="formex">'
                    + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoKeyword'); ?></label>'
                    + '<div class="col-sm-6">'
                    + '<input type="text"  id="BSeoKeyword" name="bannerImage[seoKeyword]" class="form-control" value="<?php echo $storedata['bannerLogos']['seoKeyword']; ?>" >'
                    + '</div>'
                    + '<div class="col-sm-3 errors" id="SeoKeywordErr"></div>'
                    + '</div>'
                    + '</form>'
                    + '</div>'
                    + '<div class="modal-footer">'

                    + '<div class="col-sm-4 error-box" id="errorpass"></div>'
                    + '<div class="col-sm-8" >'
                    + '<div class="pull-right m-t-10"><button type="button" class="btn btn-primary pull-right" id="insertBSeo"><?php echo $this->lang->line('button_add'); ?></button></div>'
                    + '<div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('button_Cancel'); ?></button></div>'
                    + '</div>'
                    + '</div>';

            $('#addSeoModal').append(html2);
            $('#seoModal').modal('show');
        } else {
            $("#Bimage").focus();
        }

    });

    $(document).on('click', "#insertBSeo", function () {
        $('.close').trigger('click');

        if ($('#BSeoTitle').val() == '') {
            $('#bSeoTitle').val($('#BAltText').val())
        }
        if ($('#BSeoKeyword').val() == "") {
            var seoDescription = $("#BSeoDescription").val();
            var seoKeyword = seoDescription.replace(" ", ",");
            $("#bSeoKeyword").val(seoKeyword);
        } else {
            var seoKeywordid = $('#BSeoKeyword').val();
            var seoKeyword = seoKeywordid.replace(" ", ",");
            $("#bSeoKeyword").val(seoKeyword);
        }
        html = '<div id="Seodata" >'
                + '<input type="text"  id="bAltText" name="bannerImage[imageAllText]"  class="form-control" value="' + $('#BAltText').val() + '">'
                + '<input type="text"  id="bSeoTitle" name="bannerImage[seoTitle]"  class="form-control" value="' + $('#BSeoTitle').val() + '">'
                + '<input type="text"  id="bSeoDescription" name="bannerImage[seoDescription]" class="form-control" value="' + $('#BSeoDescription').val() + '">'
                + '<input type="text"  id="bSeoKeyword" name="bannerImage[seoKeyword]" class="form-control" value="' + $('#BSeoKeyword').val() + '">'
                + '</div>';

        $('.BimageData').append(html);

    });


    function isNumberKey(evt)
    {
        $("#mobify").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
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
        <div class="inner">
            <!-- START BREADCRUMB -->
            <ul class="breadcrumb" style="margin-left: 0px;">
                <li><a href="javascript: history.go(-1)" class=""><?php echo $this->lang->line('heading_Dispensary'); ?></a>
                </li>
                <li style="width: 150px"><a href="#" class="active"><?php echo $this->lang->line('heading_editDispensary'); ?></a>
                </li>
            </ul>
            <!-- END BREADCRUMB -->
        </div>

        <!-- START JUMBOTRON -->
        <div class="bg-white">
            <!-- Nav tabs -->

            <div class="container-fluid container-fixed-lg bg-white">
                <div id="navbar-collapsible"  class="navbar-collapse collapse m-t-50">
                    <ul class="navbar-nav navbar-left nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs" style=" -webkit-transition: top .5s; transition: top .5s;">
                        <li class="active_class active">
                            <a class="" data-toggle="tab" role="tab" href="#tab1">
                                <span><?php echo $this->lang->line('heading_Details'); ?></span>
                            </a>
                        </li>
                        <li class="active_class">
                            <a class="" data-toggle="tab" role="tab" href="#tab2">
                                <span><?php echo $this->lang->line('heading_Settings'); ?></span>
                            </a>
                        </li>
                        <li class="active_class">
                            <a class="" data-toggle="tab" role="tab" href="#tab3">
                                <span><?php echo $this->lang->line('heading_MileageSetting'); ?></span>
                            </a>
                        </li>
                        <li class="active_class">
                            <a class="" data-toggle="tab" role="tab" href="#tab4">
                                <span><?php echo $this->lang->line('heading_SocialMediaLinks'); ?></span>
                            </a>
                        </li>

                    </ul>
                    <div class="row"><br></div>

                    <form id="addentity" class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                        <div class="tab-content">
                            <section class="" id="tab1">


                                <div class="row row-same-height">
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_GeneralDetails'); ?></h6>
                                    <hr>

                                    <div class="form-group relative1">
                                        <label id="td1" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ProfileImage'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <input type="file" name="imageupload" class="error-box-class form-control imagesPStore" id="Pimage" attrId="0" value="Text Element 1">
                                            <div class="">  
                                                <input type="hidden" class="form-control" style="height: 37px;" name="profileImage" id="profileImage">
                                                <input type="hidden" value="<?php echo $storedata['profileLogos']['logoImage']; ?>" id='viewPimage_hidden'/>
                                                <?php
                                                if ($storedata['profileLogos']['logoImage'] != '') {
                                                    ?>
                                                    <a target="_blank" href="<?php echo $storedata['profileLogos']['logoImage']; ?>">view</a> 

                                                <?php }
                                                ?>
                                            </div>
                                            <div class="col-sm-6 error-box redClass" id="text_imagesP"></div>
                                        </div>

                                        &nbsp;
                                        <button type="button" id="btAddSeoP" data-id="0" class="btAddSeo btn btn-default btn-primary" style="width: 5%; border-radius: 9px;">
                                            <span class="glyphicon glyphicon-plus " ><?php echo $this->lang->line('label_Seo'); ?></span>
                                        </button>

                                        <input type="hidden" class="defaultImages" id="PdefaultImages"  name="profileImage[logoImage]"/>

                                        <div class="PimageData" style="display: none;">
                                        </div>
                                    </div>

                                    <div class="form-group relative2">
                                        <label id="td1" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_BannerImage'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <input type="file" name="imageupload" class="error-box-class form-control imagesBStore" id="Bimage" attrId="1" value="Text Element 1">
                                            <div class="">  
                                                <input type="hidden" class="form-control" style="height: 37px;" name="profileImage" id="profileImage">
                                                <input type="hidden" value="<?php echo $storedata['bannerLogos']['bannerimage']; ?>" id='viewBimage_hidden'/>
                                                <?php
                                                if ($storedata['bannerLogos']['bannerimage'] != '') {
                                                    ?>
                                                    <a target="_blank" href="<?php echo $storedata['bannerLogos']['bannerimage']; ?>">view</a> 

                                                <?php }
                                                ?>
                                            </div>
                                            <div class="col-sm-6 error-box redClass" id="text_images"></div>
                                        </div>

                                        &nbsp;
                                        <button type="button" id="btAddSeoB" data-id="0" class="btAddSeo btn btn-default btn-primary" style="width: 5%; border-radius: 9px;">
                                            <span class="glyphicon glyphicon-plus " ><?php echo $this->lang->line('label_Seo'); ?></span>
                                        </button>
                                        <input type="hidden" class="defaultImages" id="BdefaultImages"  name="bannerImage[bannerimage]"/>
                                        <div class="BimageData" style="display: none;">
                                        </div>
                                    </div>

                                    <div class="form-group"id="bussiness_txt">

                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DName'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">  
                                            <input type="text"   id="businessname_0" name="Businessname[0]"  class=" businessname form-control error-box-class" value="<?php echo $storedata['name'][0]; ?>">
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_businessname_0" style="color:red">

                                        </div>
                                    </div>


                                    <?php
                                    foreach ($language as $val) {
                                        ?>
                                        <div class="form-group" >
                                            <label for="fname" class=" col-sm-2 control-label"> <?php echo $this->lang->line('label_DName') . ' (' . $val['lan_name'] . ')'; ?></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="businessname_<?= $val['lan_id'] ?>" name="Businessname<?= $val['lan_id'] ?>"  class=" businessname form-control error-box-class" value="<?php echo $storedata['name'][$val['lan_id']]; ?>">
                                            </div>
                                            <div class="col-sm-3" style="color:red" id="text_businessname_<?= $val['lan_id'] ?>">

                                            </div>
                                        </div>

                                    <?php } ?>


                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_OwnerName'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="ownername" name="Ownername"  class="form-control error-box-class" value="<?php echo $storedata['ownerName']; ?>">
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_ownername" style="color:red"></div>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $coutry_code = $storedata['countryCode'];
                                        $mobile = $storedata["ownerPhone"];
                                        ?>
                                        <script>
                                            $(document).ready(function () {

                                                $("#phone").intlTelInput("setNumber", "<?php echo $coutry_code . ' ' . $mobile ?>");
                                            });
                                        </script>
                                        <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_OwnerPhone'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="tel" maxlength="10" id="phone" name="Phone"  class="form-control error-box-class phoneWidth" onkeypress="return isNumberKey(event)" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_OwnerEmail'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="email" name="Email"  class="form-control error-box-class" value="<?php echo $storedata['ownerEmail']; ?>">
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_email" style="color:red"></div>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $bcoutry_code = $storedata['bcountryCode'];
                                        $bmobile = $storedata["businessNumber"];
                                        ?>
                                        <script>
                                            $(document).ready(function () {

                                                $("#businessNumber").intlTelInput("setNumber", "<?php echo $bcoutry_code . ' ' . $bmobile ?>");
                                            });
                                        </script>

                                        <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_BusinessPhone'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="tel" maxlength="10"  id="businessNumber" name="businessNumber"  class="form-control classRight phoneWidth error-box-class" onkeypress="return isNumberKey(event)" required="" >

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_businessNumber" style="color:red"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_BusinessWebsite'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="website" name="Website"  class="form-control error-box-class" value="<?php echo $storedata['website']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group" id="description_txt">

                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Description'); ?></label>
                                        <div class="col-sm-6">
                                            <textarea type="text"  id="description" name="Descrition[0]"  class="description form-control error-box-class" style="max-width: 100%"><?php echo $storedata['description'][0]; ?></textarea>
                                        </div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        ?>
                                        <div class="form-group" >
                                            <label for="fname" class=" col-sm-2 control-label"><?php echo $this->lang->line('label_Description'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                            <div class="col-sm-6">
                                                <textarea type="text"  id="description" name="Descrition[<?= $val['lan_id'] ?>]"  class="description form-control error-box-class" style="max-width: 100%" ><?php echo $storedata['description'][$val['lan_id']]; ?></textarea>

                                            </div>
                                        </div>
                                    <?php } ?>

                                    <!-- <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Category'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <select id="CategoryList" name='Category' class='form-control error-box-class'  <?PHP echo $enable; ?> >
                                                <option value=""><?php echo $this->lang->line('label_SelectCategory'); ?></option>
                                                <?php
                                                if(count($language) < 1){
                                                    foreach ($category as $result) {
                                                        $selected = '';
                                                    if ($storedata['storeCategory'][0]['categoryId'] == (string)$result['_id']['$oid']) {
                                                        $selected = 'selected';
                                                    }

                                                        echo "<option value=" . $result['_id']['$oid'] . "  data-name='" . $result['storeCategoryName']['en'] . "' $selected>" . $result['storeCategoryName']['en'] . "</option>";
                                                    }
                                                }
                                                else{
                                                    
                                                    foreach ($category as $result) {
                                                        $catData=$result['storeCategoryName']['en'];
                                                        foreach($language as $lngData){
                                                            $lngcode=$lngData['langCode'];
                                                           $lngvalue= ($result['storeCategoryName'][$lngcode]=='') ? "":$result['storeCategoryName'][$lngcode];
                                                            $catData .= ','.$lngvalue;
                                                        }
                                                        $selected = '';
                                                        if ($storedata['storeCategory'][0]['categoryId'] == (string)$result['_id']['$oid']) {
                                                            $selected = 'selected';
                                                        }
                                                        
                                                            echo "<option value=" . $result['_id']['$oid'] . "  data-name='" . implode($result['storeCategoryName'], ',') . "'  $selected>" . $catData . "</option>";
                                                       

                                                        
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_CategoryList" style="color:red"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_subCategory'); ?></label>
                                        <div class="col-sm-6">
                                            <div id='SubCatList'>
                                                <select id='subcatLists' class="form-control error-box-class" name='subCategory' <?PHP echo $enable; ?> >
                                                    <option value=''><?php echo $this->lang->line('label_SelectsubCat'); ?></option>


                                                </select>

                                            </div>

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_cityLists" style="color:red"></div>

                                    </div>
                                        -->
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Country'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <select id="CountryList" name='Country' class='form-control error-box-class'  <?PHP echo $enable; ?> >
                                                <option value=""><?php echo $this->lang->line('label_SelectCountry'); ?></option>
                                                <?php
                                                foreach ($country as $result) {
                                                    if ($storedata['countryId'] == $result['_id']['$oid'])
                                                        echo "<option value=" . $result['_id']['$oid'] . " selected>" . $result['country'] . "</option>";
                                                    else
                                                        echo "<option value=" . $result['_id']['$oid'] . ">" . $result['country'] . "</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_CountryList" style="color:red"></div>

                                    </div> 

                                    <input type='hidden' name='cityname' id='cityname' value="<?php echo $storedata['cityName']; ?>">
                                    <input type='hidden' name='countryname' id='countryname' value="<?php echo $storedata['countryName']; ?>">
                                    <input type='hidden' name='currencySymbol' id='currencySymbol' value="<?php echo $storedata['currencySymbol']; ?>">
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_City'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <div id='CityList'>
                                                <select id='cityLists' class="form-control error-box-class" name='City' <?PHP echo $enable; ?> >
                                                    <option value=''><?php echo $this->lang->line('label_SelectCity'); ?></option>


                                                </select>

                                            </div>

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_cityLists" style="color:red"></div>

                                    </div>
                                    <input type="hidden" id="countryCode" name="coutry-code" value="<?php echo $storedata['countryCode']; ?>">
                                    <input type="hidden" id="bcountryCode" name="coutry-code" value="<?php echo $storedata['bcountryCode']; ?>">
                                    <div class="form-group" id="Address_txt" >

                                        <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Address'); ?><span class="MandatoryMarker">*</span></label>
                                        <input type="hidden" id="addressCompo" name="addressCompo" value='<?php echo json_encode($storedata['addressCompo']); ?>'>
                                        <div class="col-sm-6">
                                            
                                            <textarea class="form-control entityAddress error-box-class" id="entityAddress_0" placeholder="Business Address" name="Address[0]"  aria-required="true"  onkeyup="getAddLatLong1(this)" style="max-width: 100%;"><?php echo $storedata['storeAddr']; ?></textarea>
                                        </div>
                                        <button  type="button" class=" btn btn-info btn-sm col-sm-1" 
                                                 style="margin-top: 0px;
                                                 width: 5%;
                                                 border-radius: 45px;
                                                 position: relative;
                                                 height: 30px;
                                                 font-size: 13px;" 
                                                 accesskey="" name="action" onclick="callMap();" value="add"><?php echo $this->lang->line('button_Map'); ?></button>
                                        <div class="col-sm-2 error-box" id="text_entityAddress_0" style="color:red"></div>
                                    </div>

                                    <div class="form-group" id="Address_txt" >

                                        <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_BillingAddress'); ?></label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control entityAddress1 error-box-class" id="entityAddress_01" placeholder="Billing Address" name="Address[0]"  aria-required="true" style="max-width: 100%;"><?php echo $storedata['storeBillingAddr']; ?></textarea>
                                        </div>
                                        <button  type="button" class=" btn btn-info btn-sm col-sm-1" 
                                                 style="margin-top: 0px;
                                                 width: 5%;
                                                 border-radius: 45px;
                                                 position: relative;
                                                 height: 30px;
                                                 font-size: 13px;" 
                                                 accesskey="" name="action" onclick="callMap1();" value="add"><?php echo $this->lang->line('button_Map'); ?></button>
                                    </div>

                                     <div class="form-group">
                                        <label for="streetname" class="col-sm-2 control-label"><?php echo 'STREET NAME'; ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="streetname" name="streetname" value='<?php echo $storedata['streetName']; ?>' class="form-control error-box-class" >
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_streetname" style="color:red"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="locality" class="col-sm-2 control-label"><?php echo 'LOCALITY'; ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="localityname" name="localityname" value='<?php echo $storedata['localityName']; ?>' class="form-control error-box-class" >
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_localityname" style="color:red"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="area" class="col-sm-2 control-label"><?php echo 'AREA NAME'; ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="areaname" name="araaname" value='<?php echo $storedata['areaName']; ?>' class="form-control error-box-class" >
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_areaname" style="color:red"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ServiceZones'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <select  id='serviceZones' name='FData[serviceZones][]' class='errr11 form-control serviceZones error-box-class' multiple="multiple">

                                            </select>
                                        </div> 
                                        <div class="col-sm-3 error-box text_err" id="serviceZonesErr" style="color:red"></div>                                       
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_Autoapproval'); ?></label>
                                        <div class="col-sm-6">
                                            <div class="switch">
                                                <input id="Autoapproval" name="FData[autoApproval]" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                <label for="Autoapproval"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" class="form-control" id="entitypostalcode"  placeholder="0" name="PostalCode"  aria-required="true" <?PHP echo $enable; ?>>

                                    <input type="hidden" class="form-control" id="entiryLongitude"  placeholder="0.00" name="Longitude"  aria-required="true" <?PHP echo $enable; ?> value='<?php echo $storedata['coordinates']['longitude']; ?>'>

                                    <input type="hidden" class="form-control" id="entiryLatitude"  placeholder="0.00" name="Latitude"  aria-required="true" <?PHP echo $enable; ?> value='<?php echo $storedata['coordinates']['latitude']; ?>'>

                                </div>
                            </section>

                            <!-- End of Tab1 -->

                            <!--Start of Tab2 -->
                            <section class="" id="tab2">
                                <div class="row row-same-height">
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_DriverSettings'); ?></h6>
                                    <hr>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_DriverType'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="radio" class="drivers_" name="select_driver" id="grocerDriver" value=1 <?php echo ($storedata['driverType'] == '1') ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label for ="grocerDriver"><?php echo $this->lang->line('label_DispensaryPool'); ?></label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" class="drivers_" name="select_driver" id="storeDriver" value=2 <?php echo ($storedata['driverType'] == '2') ? "CHECKED" : " " ?>  >&nbsp;&nbsp;<label for ="storeDriver"><?php echo $this->lang->line('label_Freelance'); ?></label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <!--<input type="checkbox" class="drivers_" name="select_driver" id="Offlinedrivers" value="1" >&nbsp;&nbsp;<label>Offline Pool</label>-->
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_forcedAccept'); ?></label>
                                        <div class="col-sm-6">
                                            <div class="switch">
                                                <input id="forcedAccept" name="forcedAccept" class="cmn-toggle cmn-toggle-round" type="checkbox"  style="display: none;">
                                                <label for="forcedAccept"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_autoDispatch'); ?></label>
                                        <div class="col-sm-6">
                                            <div class="switch">
                                                <input id="autoDispatch" name="autoDispatch" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                <label for="autoDispatch"></label>
                                            </div>
                                        </div>
                                    </div> 
                                    <hr>
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_PriceSettings'); ?></h6>
                                    <hr>


                                    <div class="form-group">

                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_PriceModel'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="radio" class="pricing_ error-box-class" name="price" value=0 <?php echo ($storedata['pricingStatus'] == '0') ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_zonalPricing'); ?></label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" class="pricing_ error-box-class" name="price"  value=1 <?php echo ($storedata['pricingStatus'] == '1') ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_MileagePricing'); ?></label>
                                        </div>

                                    </div>


                                    <div class="form-group ">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_MinValue'); ?> (<?php echo $appConfig['currency']; ?>)<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <span class="abs_text currencySymbol"><b><?php echo $storedata['currencySymbol']; ?></b></span>
                                            <input type="text" class="form-control" id="entiryminorderVal" placeholder="Minimum Order Value" name="MinimumOrderValue"  aria-required="true" <?PHP echo $enable; ?> value="<?php echo $storedata['minimumOrder']; ?>">
                                        </div>
                                        <div class="col-sm-2 error-box" id="text_entiryminorderVal" style="color:red"></div>
                                    </div>

                                    <div class="form-group ">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_ThresholdValue'); ?> (<?php echo $appConfig['currency']; ?>)<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <span class="abs_text currencySymbol"><b><?php echo $storedata['currencySymbol']; ?></b></span>
                                            <input type="text" class="form-control" id="freedelVal" placeholder="Threshold Value" name="FreeDeliveryAbove"  aria-required="true" <?PHP echo $enable; ?> value="<?php echo $storedata['freeDeliveryAbove']; ?>">
                                        </div>
                                        <div class="col-sm-2 error-box" id="text_freedelVal" style="color:red"></div>
                                    </div>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_avgDeliveryTime'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <span class="abs_text"><b>minutes</b></span>
                                            <input type="text" class="form-control" id="avgDeliveryTime"  placeholder="Avg Delivery Time" name="avgDeliveryTime"  aria-required="true" <?PHP echo $enable; ?> value="<?php echo $storedata['avgDeliveryTime']; ?>">
                                        </div>
                                        <div class="col-sm-2 error-box" id="text_avgDeliveryTime" style="color:red"></div>
                                    </div>

                                    <div class="form-group basefare" >

                                        <div class="form-group ">

                                            <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_BaseFare'); ?> (<?php echo $appConfig['currency']; ?>)</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="basefare" value='' placeholder="Base Fare" name="Basefare"  aria-required="true" <?PHP echo $enable; ?> value="<?php echo $storedata['baseFare']; ?>">
                                            </div>

                                        </div>


                                        <div class="form-group range">

                                            <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_Range'); ?> (<?php echo $appConfig['currency']; ?>)</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="range" value='' placeholder="Range" name="Range"  aria-required="true" <?PHP echo $enable; ?> value="<?php echo $storedata['range']; ?>">
                                            </div>

                                        </div>

                                        <div class="form-group Priceperkm">

                                            <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_Price'); ?>/<?php echo $appConfig['distance']; ?> (<?php echo $appConfig['currency']; ?>)</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="Priceperkm" value='' placeholder="Price/<?php echo $appConfig['distance']; ?>" name="priceperkm"  aria-required="true" <?PHP echo $enable; ?> value="<?php echo $storedata['pricePerMile']; ?>">
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_ServiceSettings'); ?></h6>
                                    <hr>

                                    <div class="form-group" >
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_OrderType'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6" id="accepts" >
                                            <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts error-box-class" id="accepts_1" value=1 <?php echo ($storedata['orderType'] == '1') ? "CHECKED" : " " ?>><label><?php echo $this->lang->line('label_Pickup'); ?> </label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts error-box-class" id="accepts_2" value=2 <?php echo ($storedata['orderType'] == '2') ? "CHECKED" : " " ?>><label><?php echo $this->lang->line('label_Delivery'); ?> </label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts error-box-class" id="accepts_3" value=3 <?php echo ($storedata['orderType'] == '3') ? "CHECKED" : " " ?>><label><?php echo $this->lang->line('label_Both'); ?> </label>
                                        </div>
                                        <div class="col-sm-3  error-box" id="text_accepts"></div>
                                    </div>

                                    <hr>
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_PaymentSettings'); ?></h6>
                                    <hr>

                                    <div class="form-group Pickup">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_PaymentMethodForPickup'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="checkbox" class="Pcheckbox_ error-box-class" name="payment[]" id="Pcash" value=1 <?php echo ($storedata['pickupCash'] == '1') ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_Cash'); ?></label> 

                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" class="Pcheckbox_ error-box-class" name="payment[]" id="Pcredit_card" value=1 <?php echo ($storedata['pickupCard'] == '1') ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_CreditCard'); ?></label> 

                                            &nbsp;&nbsp;&nbsp;&nbsp;

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_paymentp" style="color:red;"></div>
                                    </div>

                                    <div class="form-group  Delivery">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_PaymentMethodForDel'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="checkbox" class="Dcheckbox_ error-box-class" name="payment[]" id="Dcash" value=1 <?php echo ($storedata['deliveryCash'] == '1') ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_Cash'); ?></label> 

                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" class="Dcheckbox_ error-box-class" name="payment[]" id="Dcredit_card" value=1 <?php echo ($storedata['deliveryCard'] == '1') ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_CreditCard'); ?></label> 

                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_dpayment" style="color:red;"></div>
                                    </div>

                                    <hr>

                                </div>
                            </section>
                            <!--End of Tab2-->

                            <section class="" id="tab3">
                                <div class="row row-same-height">
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_DriverMileageSetting'); ?></h6>
                                    <hr>


                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_baseFare'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $storedata['currencySymbol']; ?></b></span>
                                            <input type="text" name="pricing[baseFare]" value="<?php echo $storedata['baseFare']; ?>" id="baseFare" placeholder="Enter Base Fare" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Mileage_Price'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $storedata['currencySymbol']; ?></b></span>
                                            <input type="text" name="pricing[mileagePrice]" value="<?php echo $storedata['mileagePrice']; ?>" id="mileagePrice" placeholder="Enter Mileage Price" class="form-control required">
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="abs_textLeft"><b>After</b></span>
                                            <input type="text" name="pricing[mileagePriceAfterMinutes]" id="mileagePriceAfter" value="<?php echo $storedata['mileagePriceAfterMinutes']; ?>" style="padding-left: 74px;" class="form-control required">
                                            <span class="abs_text1"><b><?php echo $this->lang->line('KM'); ?></b></span>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_timeFee'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $storedata['currencySymbol']; ?></b></span>
                                            <input type="text" name="pricing[timeFee]" id="timeFee" value="<?php echo $storedata['timeFee']; ?>" placeholder="Enter Time Fee" class="form-control required">
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="abs_textLeft"><b>After</b></span>
                                            <input type="text" name="pricing[timeFeeAfterMinutes]" style="padding-left: 74px;" value="<?php echo $storedata['timeFeeAfterMinutes']; ?>" id="timeFeeAfter" placeholder="Enter time fare" class="form-control required">
                                            <span class="abs_text1"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_waitingFee'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $storedata['currencySymbol']; ?></b></span>
                                            <input type="text" name="pricing[waitingFee]" id="waitingFee" value="<?php echo $storedata['waitingFee']; ?>" placeholder="Enter Waiting Fee" class="form-control required">
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="abs_textLeft"><b>After</b></span>
                                            <input type="text" value="<?php echo $storedata['waitingFeeAfterMinutes']; ?>"  name="pricing[waitingFeeAfterMinutes]" style="padding-left: 74px;" id="waitingFeeAfter" class="form-control required">
                                            <span class="abs_text1"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_minimumFare'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $storedata['currencySymbol']; ?></b></span>
                                            <input type="text" name="pricing[minimumFare]" value="<?php echo $storedata['minimumFare']; ?>" id="minimumFare" placeholder="Enter Minimum Fare" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_On-Demand Bookings_Cancellation_Fee'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $storedata['currencySymbol']; ?></b></span>
                                            <input type="text" name="pricing[onDemandBookingsCancellationFee]" value="<?php echo $storedata['onDemandBookingsCancellationFee']; ?>" id="onDemandBookingsCancellationFee" placeholder="Enter Now Booking Cancellation Fee" class="form-control required">
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="abs_textLeft"><b>After</b></span>
                                            <input type="text" style="padding-left: 74px;" value="<?php echo $storedata['onDemandBookingsCancellationFeeAfterMinutes']; ?>" name="pricing[onDemandBookingsCancellationFeeAfterMinutes]" id="onDemandBookingsCancellationFeeAfter" class="form-control required">
                                            <span class="abs_text1"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_ScheduledBookingsCancellationFee'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $storedata['currencySymbol']; ?></b></span>
                                            <input type="text" value="<?php echo $storedata['scheduledBookingsCancellationFee']; ?>" name="pricing[scheduledBookingsCancellationFee]" id="ScheduledBookingsCancellationFee" placeholder="Enter Scheduled Booking Cancellation Fee" class="form-control required">
                                        </div>
                                        <div class="col-sm-4">

                                            <span class="abs_textLeft"><b>After</b></span>
                                            <input type="text" style="padding-left: 74px;" value="<?php echo $storedata['scheduledBookingsCancellationFeeAfterMinutes']; ?>" name="pricing[ScheduledBookingsCancellationFeeAfterMinutes]" id="ScheduledBookingsCancellationFee"  class="form-control required">
                                            <span class="abs_text1"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_ConvenienceFee'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $storedata['currencySymbol']; ?></b></span>
                                            <input type="text" value="<?php echo $storedata['convenienceFee']; ?>" name="pricing[convenienceFee]" id="convenienceFee" placeholder="Enter Convenience Fee" class="form-control required">
                                        </div>
                                    </div>


                                </div>
                            </section>
                            <section class="" id="tab4">
                                <div class="row row-same-height">
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_SocialMediaLinks'); ?></h6>
                                    <hr>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Facebook'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="socialMediaLinks[Facebook]" id="Facebook" placeholder="Enter Facebook link" value="<?php echo $storedata['socialLinks']['Facebook']; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Twitter'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="socialMediaLinks[Twitter]" id="Twitter" placeholder="Enter Twitter link" value="<?php echo $storedata['socialLinks']['Twitter']; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Instagram'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="socialMediaLinks[Instagram]" id="Instagram" placeholder="Enter Instagram link" value="<?php echo $storedata['socialLinks']['Instagram']; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_LinkedIn'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="socialMediaLinks[LinkedIn]" id="LinkedIn" placeholder="Enter LinkedIn link" value="<?php echo $storedata['socialLinks']['LinkedIn']; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Google'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="socialMediaLinks[Google]" id="Google" placeholder="Enter Google+ link" value="<?php echo $storedata['socialLinks']['Google']; ?>" class="form-control">
                                        </div>
                                    </div>


                                </div>
                            </section>

                        </div>

                        <div class="padding-20 bg-white">
                            <ul class="pager wizard">

                                <li class="" id="finishbutton">
                                    <button class="btn btn-primary btn-cons btn-animated from-left pull-right" type="button"  id="edit">
                                        <span style="height: 24px; "><?php echo $this->lang->line('button_Save'); ?></span>
                                    </button>
                                </li>

                            </ul>
                        </div>


                    </form>
                </div> 
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
                                                            var bCountryCode = (resp && resp.country) ? resp.country : "";
                                                            callback(bCountryCode);
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

<div class="modal fade in" id="ForMaps" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
    <div class="modal-dialog">

        <form action = "<?php echo base_url(); ?>index.php/superadmin/AddNewCenter" method= "post" onsubmit="return validateForm();">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:initial;">&times;</button>
                    <h4 class="modal-title"><?php echo $this->lang->line('heading_DragMarker'); ?></h4>
                </div>

                <div class="modal-body"><div class="form-group" >
                        <div id="myMap" style="width: 544px; height: 250px;"></div><br/>
                        <div class="form-group">
                            <label><?php echo $this->lang->line('label_Address'); ?></label>
                            <!--<input type="text" class="form-control" value="" placeholder="Address ..." name="address" id="address" onkeyup="getAddLatLong(this);">-->
                            <textarea rows="4" cols="50" class="form-control" style="max-width:100%;" id="mapentityAddress" placeholder="Address.." name="FData[businessAddress][0]"   onkeyup="getAddLatLong(this)"><?PHP echo $ProfileData['Address'][0]; ?></textarea>

                        </div> 

                        <div class="form-group">
                            <label><?php echo $this->lang->line('label_Latitude'); ?></label>
                            <input type="text" readonly class="form-control" value="" placeholder="Latitude ..." name="latitude" id="latitude">
                        </div> 
                        <div class="form-group">
                            <label><?php echo $this->lang->line('label_Longitude'); ?></label>
                            <input type="text" readonly class="form-control" value="" placeholder="Longitude ..." name="longitude" id="longitude">
                        </div> 

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick='Cancel();'><?php echo $this->lang->line('button_Close'); ?></button>
                    <input type="button" id="TakeMapAddress"  data-dismiss="modal" class="btn btn-primary" onclick='Take();' value="<?php echo $this->lang->line('button_TakeAddress'); ?>" >

                </div>
            </div>
        </form>


    </div>

</div>

<div class="modal fade stick-up" id="seoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="addSeoModal">

            <!-- /.modal-content -->
        </div>

    </div>
    <!-- /.modal-content -->
</div>
