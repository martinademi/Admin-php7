<?php
$appConfig['currency'] = "$";
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
        width: 215%;
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
        $('#mapentityAddress').val('');
        $('#mapBtnDataId').val($('#mapbtn1').attr("data-id"));
        $('#ForMaps').modal('show');
        addressType = 1;
        if ($('#entiryLatitude').val() != "" && $('#entiryLongitude').val() != "") {
            $('#latitude').val($('#entiryLatitude').val());
            $('#longitude').val($('#entiryLongitude').val());
            initialize1($('#entiryLatitude').val(), $('#entiryLongitude').val());
            $('#mapentityAddress').val($('#entityAddress_0').val());
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
        $('#mapentityAddress').val('');
        $('#mapBtnDataId').val($('#mapbtn2').attr("data-id"));
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
    function Cancel() {
        $('#mapBtnDataId').val('');
        $('#ForMaps').modal('hide');
    }

    function Take() {
        if (addressType == 1) {
            $('#entiryLongitude').val($('#longitude').val());
            $('#entiryLatitude').val($('#latitude').val());
            $('.entityAddress').val($('#mapentityAddress').val());
        } else if (addressType == 2) {
            $('#entityAddress_01').val($('#mapentityAddress').val());
        }
        $('#mapBtnDataId').val('');
        $('#ForMaps').modal('hide');
    }

    function initialize1(lat, long, from) {
        console.log("my lat",lat,"my long",long,"from",from)
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
                        $('#entityAddress').val(results[0].formatted_address);
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
        console.log(addr);
        $.ajax({
            url: "<?php echo base_url(); ?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                console.log(data);
                if (Arr.flag == 1) {
                    $('#entiryLatitude').val(Arr.Lat);
                    $('#entiryLongitude').val(Arr.Long);
                    initialize1(Arr.Lat, Arr.Long, '0');
                }
            }
        });
    }
    function getAddLatLong() {
        //console.log("my text",text)
        var addr = $('#mapentityAddress').val();
        var mapdataid=$('#mapBtnDataId').val();
        console.log(mapdataid);
        if (addr) {
           // var addr = text;
            //var addr = '';
        
        $.ajax({
            url: "<?php echo base_url(); ?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                $('#latitude').val(Arr.Lat);
                $('#longitude').val(Arr.Long);
                initialize1(Arr.Lat, Arr.Long, mapdataid);
                

            }
        });
    }
    }
        /* start */

        function getAddLatLong2(text) {
        var mapdataid=$('#mapBtnDataId').val();
        console.log("mapdataid in 2 ",mapdataid)
        if (text) {
           var addr = text;
            //var addr = '';
        
        $.ajax({
            url: "<?php echo base_url(); ?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                // console.log("dataprint--------");
                // console.log(data);
                var Arr = JSON.parse(data);
                $('#latitude').val(Arr.Lat);
                $('#longitude').val(Arr.Long);
                if(mapdataid!=''){
                    initialize1(Arr.Lat, Arr.Long,mapdataid);
                }
                
                else{
                    initialize1(Arr.Lat, Arr.Long,'0');
                }
                

            }
        });
    }
    }
        /* end */


    function initialize() {
        var id = '';

        var input = document.getElementById('entityAddress_0');

        var options = {componentRestrictions: {country: 'us'}};

        var autocomplete = new google.maps.places.Autocomplete(input);

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            
            document.getElementById('entiryLatitude').value = place.geometry.location.lat();
            document.getElementById('entiryLongitude').value = place.geometry.location.lng();
            //initialize(place.geometry.location.lat(), place.geometry.location.lng(), '0');
            $('#longitude').val(place.geometry.location.lng());
            $('#latitude').val(place.geometry.location.lat());
            getAddLatLong1(place.formatted_address);
        });

        var input0 = document.getElementById('entityAddress_01');
        var autocomplete0 = new google.maps.places.Autocomplete(input0);
        google.maps.event.addListener(autocomplete0, 'place_changed', function () {
            var place = autocomplete0.getPlace();
            getAddLatLong2(place.formatted_address);
        });

        var input1 = document.getElementById('mapentityAddress');
        var autocomplete1 = new google.maps.places.Autocomplete(input1);
        google.maps.event.addListener(autocomplete1, 'place_changed', function () {
            var place = autocomplete1.getPlace();
            //getAddLatLong2(place.formatted_address);
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();
            getAddLatLong2(place.formatted_address);
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script>
    $(document).ready(function () {
        

        $(window).scroll(function () {
            var scr = jQuery(window).scrollTop();

            if (scr > 0) {
                $('#mytabs').addClass('fixednab');
            } else {
                $('#mytabs').removeClass('fixednab');
            }
        });

        $("#phone").intlTelInput("setNumber", '');

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });
        $('.error-box-class').change(function () {
            $('.error-box').text('');
        });

        $("#phone").on("countrychange", function (e, countryData) {
            $("#countryCode").val(countryData.dialCode);
        });

       /* $('#cityLists').on('change', function () {

            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Franchise/getZones",
                type: 'POST',
                dataType: 'json',
                data: {
                    val: $('#cityLists').val()
                },
            }).done(function (json) {
                console.log(json);
                var serviceZone = '';
                if (json.data.length >= 1) {
                    for (var i = 0; i < json.data.length; i++) {
                        serviceZone += "<option value=" + json.data[i].id + ">" + json.data[i].title + "</option>";
                    }
                    $("#serviceZones").html(serviceZone);
                } else {
                    serviceZone = "<option value=''>No zones found</option>";
                    $("#serviceZones").html(serviceZone);
                }
                $('#serviceZones').multiselect('destroy').multiselect({
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    buttonWidth: '500px',
                    maxHeight: 300,
                });

            });

        });*/

        $('#cityLists').change(function () {
            $('#cityname').val($('#cityLists option:selected').text());
            $('#currencySymbol').val($('#cityLists option:selected').attr('currencySymbol'));
        });

        $('#CountryList').on('change', function () {

            var val = $(this).val();

            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Franchise/getCityList",
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
            $('#countryname').val($('#CountryList option:selected').text());

        });

        $('#CategoryList').on('change', function () {

            var val = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Franchise/getSubcatList",
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
                    $.each(r, function (index, row) {
                     listData= (row.storeSubCategoryName.en);
                     $.each(langData,function(i,lngrow){
                        lngcode= lngrow.langCode;
                        // console.log(lngcode);
                        // console.log(typeof(lngcode));
                        var lngvalue = row.storeSubCategoryName.lngcode;
                        lngvalue = (lngvalue==''|| lngvalue==null )?" ":lngvalue;
                       listData +=","+lngvalue; 
                      // console.log(listData);
                    });
                   
                        html += '<option data-name="' + row.name + '"value="' + row._id.$oid + '">' + listData + '</option>';
                    });
                    $('#subcatLists').append(html);
                }
            });
        });


        

        $('#insert').click(function () {
            var status = '<?php echo $status; ?>';
            $(this).prop('disabled', false);
            $('.clearerror').text("");

            var Name = new Array();
            $(".franchisename").each(function () {
                Name.push($(this).val());
            });
            var Description = new Array();
            $(".description").each(function () {
                Description.push($(this).val());
            });
           // var serviceZones = $("#serviceZones").val();

            var countryCode = $('#countryCode').val();
            var Pimage = $("#Pimage").val();
            var Bimage = $("#Bimage").val();

            var OwnerName = $("#ownername").val();
            var Phone = $("#phone").val();
            var Email = $("#email").val();
            var Password = $("#password").val();
            var Website = $("#website").val();
            var CategoryList = $("#CategoryList").val();
            var SubCategoryList = $("#subcatLists").val();
            var Country = $("#CountryList").val();
            var city = $("#cityLists").val();
            var cityName = $("#cityLists option:selected").attr('data-name');
            var countryname = $("#countryname").val();         
            var Autoapproval = $("input[name='Autoapproval']:checked").val();
            var profileImage = $('#PdefaultImages').val();
            var profileAllText = $('#pAltText').val();
            var profileSeoTitle = $('#pSeoTitle').val();
            var profileSeoDesc = $('#pSeoDescription').val();
            var profileSeoKeyword = $('#pSeoKeyword').val();
            var bannerImage = $('#BdefaultImages').val();
            var bannerAllText = $('#bAltText').val();
            var bannerSeoTitle = $('#bSeoTitle').val();
            var bannerSeoDesc = $('#pbeoDescription').val();
            var bannerSeoKeyword = $('#bSeoKeyword').val();
            var currencySymbol = $('#currencySymbol').val();
            var franchiseAddress = $("#entityAddress_0").val();
            var billingAddress = $("#entityAddress_01").val();
            var longitude = $("#entiryLongitude").val();
            var latitude = $("#entiryLatitude").val();         
            var Facebook = $('#Facebook').val();
            var Twitter = $('#Twitter').val();
            var Instagram = $('#Instagram').val();
            var LinkedIn = $('#LinkedIn').val();
            var Google = $('#Google').val();
            var passwordstrong = /^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,15}$/;
            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            var name = $('#name_0').val();

            var storeType=$("#CategoryList option:selected").attr('storetype');
			var storeTypeName=$("#CategoryList option:selected").attr('storetypename');
            var catName=$("#CategoryList option:selected").attr('data-name');
            var CatId = $("#category option:selected").val();
            var catName = $("#category option:selected").attr("data-name");
            console.log(storeType);
            console.log(storeTypeName);
            console.log(catName);
            if (Pimage == '' || Pimage == null) {
                $("#Pimage").focus();
                $("#text_imageP").show();
                $("#text_imageP").text("<?php echo $this->lang->line('error_ImageP'); ?>");
            } else if (Bimage == '' || Bimage == null) {
                $("#text_imageP").hide();
                $("#text_imageB").show();
                $("#Bimage").focus();
                $("#text_imageB").text("<?php echo $this->lang->line('error_ImageB'); ?>");
            } else if (name == '' || name == null || name.length < 3) {
                $("#text_imageP").hide();
                $("#text_imageB").hide();
                $("#name_0").focus();
                $("#text_name_0").text("<?php echo $this->lang->line('error_Name'); ?>");
            } else if ($('#ownername').val() == '' || $('#ownername').val() == null || $('#ownername').val().length < 3 ) {
                $("#ownername").focus();
                $("#text_ownername").text("<?php echo $this->lang->line('error_OwnerName'); ?>");
            } else if ($('#email').val() == '' || $('#email').val() == null) {
                $("#email").focus();
                $("#text_email").text("<?php echo $this->lang->line('error_OwnerEmail'); ?>");
            } else if ($('#password').val().trim() == '' || $('#password').val().trim() == null) {
                $("#password").focus();
                $("#text_password").text("<?php echo $this->lang->line('error_Password'); ?>");
            } else if (Password.length < 6) {
                $("#password").focus();
                $("#text_password").text("<?php echo $this->lang->line('error_PasswordErr'); ?>");
            } else if (CategoryList == '' || CategoryList == null) {
                $("#CategoryList").focus();
                $("#text_CategoryList").text("<?php echo $this->lang->line('error_Category'); ?>");
            } else if ($('#CountryList option:selected').val() == '' || $('#CountryList option:selected').val() == null) {
                $("#CountryList").focus();
                $("#text_CountryList").text("<?php echo $this->lang->line('error_Country'); ?>");
            } else if ($('#cityLists option:selected').val() == '' || $('#cityLists option:selected').val() == null) {
                $("#cityLists").focus();
                $("#text_cityLists").text("<?php echo $this->lang->line('error_City'); ?>");
            } else if (franchiseAddress == '' || franchiseAddress == null) {
                $("#entityAddress_0").focus();
                $("#text_entityAddress_0").text("<?php echo $this->lang->line('error_BAddress'); ?>");
            } else if (longitude == '' && latitude == '') {
                $("#entityAddress_0").focus();
                $("#text_entityAddress_0").text("<?php echo $this->lang->line('error_BAddress'); ?>");
            } 
            /*else if ($('#serviceZones').val() == '' || $('#serviceZones').val() == null) {
                $("#serviceZones").focus();
                $("#serviceZonesErr").text("<?php echo $this->lang->line('error_Zones'); ?>");
            } */
            else {
                $(this).prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/Franchise') ?>/operationFranchise/insert",
                    type: 'POST',
                    data: {
                        profileImage: profileImage,
                        profileAllText: profileAllText,
                        profileSeoTitle: profileSeoTitle,
                        profileSeoDesc: profileSeoDesc,
                        profileSeoKeyword: profileSeoKeyword,
                        currencySymbol: currencySymbol,
                        bannerImage: bannerImage,
                        bannerAllText: bannerAllText,
                        bannerSeoTitle: bannerSeoTitle,
                        bannerSeoDesc: bannerSeoDesc,
                        bannerSeoKeyword: bannerSeoKeyword,
                        franchiseName: Name,
                        ownerName: OwnerName,
                        countryCode: countryCode,                     
                        phone: Phone,
                        email: Email,
                        password: Password,
                        website: Website,
                        franchiseDescription: Description,
                        countryId: Country,
                        cityId: city,
                        cityName: cityName,
                        countryName: countryname,
                        Autoapproval: Autoapproval,
                        categoryId: CategoryList,
                        subCategoryId: SubCategoryList,
                        franchiseAddress: franchiseAddress,
                        billingAddress: billingAddress,
                        longitude:longitude,
                        latitude: latitude,
                        Facebook: Facebook,
                        Twitter: Twitter,
                        Instagram: Instagram,
                        LinkedIn: LinkedIn,
                        Google: Google,

                        storeType:storeType,
                        storeTypeName:storeTypeName,
                        catName:catName,

                    },
                    dataType: 'JSON',
                    async: true,
                    success: function (response)
                    {
                        window.location.href = "<?php echo base_url('index.php?') ?>/Franchise";

                    }

                });
            }
        });

        /* activate scrollspy menu */
        $('body').scrollspy({
            target: '#navbar-collapsible',
            offset: 50
        });
        $(document).on('change', '.imagesPFranchise', function () {
//            console.log('pimage');
            $('#text_imageP').hide();
            $('#text_images').text("");
            var fieldID = $(this).attr('attrId');
            var ext = $(this).val().split('.').pop().toLowerCase();
            var formElement = $(this).prop('files')[0];
//            console.log(formElement);
            uploadImage(fieldID, ext, formElement);

        });
        $(document).on('change', '.imagesBFranchise', function () {

            $('#text_images').text("");
            var fieldID = $(this).attr('attrId');
            var ext = $(this).val().split('.').pop().toLowerCase();
            var formElement = $(this).prop('files')[0];
//            console.log(formElement);
            $('#text_imageB').hide();
            uploadImage(fieldID, ext, formElement);

        });

        function uploadImage(fieldID, ext, formElement)
        {

            $('.modalPopUpText').text('');
            // fieldID : 0 - profileimage, 1- bannerimage


            if ($.inArray(ext, ['jpg', 'JPEG' , 'png']) == -1) {
                $('#errorModal').modal('show');
                $('.modalPopUpText').text('<?php echo $this->lang->line('error_imageformat'); ?>');
            } else
            {
                var form_data = new FormData();
                form_data.append('OtherPhoto', formElement);
                form_data.append('type', 'uploadImage');
                form_data.append('Image', 'Image');
                form_data.append('folder', 'franchise');
                // var amazonPath = "http://s3.amazonaws.com"
                // form_data.append('sampleFile', formElement);
                $(document).ajaxStart(function () {
                    $("#wait").css("display", "block");
                });
                $.ajax({
                    url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                    type: "POST",
                    data: form_data,
                    dataType: "JSON",

                    beforeSend: function () {

                    },
                    success: function (response) {
//                    console.log(response);
                        
                        // console.log(response.msg);
                        // console.log(response.fileName);
                        if (response.msg == "1") {
                            if (fieldID == '0') {
                                $('#thumbnailImages').val(response.fileName);
                                $('#PdefaultImages').val(response.fileName);
                                $('#mobileImages').val(response.fileName);
//                                 $.each(response.data, function (index, row) {
// //                                console.log(row);
//                                     switch (index) {
//                                         case 0:
//                                             $('#thumbnailImages').val(amazonPath + row.path);
//                                             break;
//                                         case 1:
//                                             $('#mobileImages').val(amazonPath + row.path);
//                                             break;
//                                         case 2:
//                                             $('#PdefaultImages').val(amazonPath + row.path);
//                                             break;
//                                     }
//                                     $(document).ajaxComplete(function () {
//                                         $("#wait").css("display", "none");
//                                     });
//                                 });
                            } else if (fieldID == '1') {
                                $('#thumbnailImages').val(response.fileName);
                                $('#mobileImages').val(response.fileName);
                                $('#BdefaultImages').val(response.fileName);
//                                 $.each(response.data, function (index, row) {
// //                                console.log(row);
//                                     switch (index) {
//                                         case 0:
//                                             $('#thumbnailImages').val(amazonPath + row.path);
//                                             break;
//                                         case 1:
//                                             $('#mobileImages').val(amazonPath + row.path);
//                                             break;
//                                         case 2:
//                                             $('#BdefaultImages').val(amazonPath + row.path);
//                                             break;
//                                     }
//                                     $(document).ajaxComplete(function () {
//                                         $("#wait").css("display", "none");
//                                     });
//                                 });

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
//        console.log(imageval);

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
                        + '<input type="text"  id="AltText" name="profileImage[imageallText]"  class="form-control">'
                        + '</div>'
                        + '<div class="col-sm-3 errors" id="Alt_TextErr"></div>'
                        + '</div>'
                        + '<div class="form-group" class="formex">'
                        + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoTitle'); ?></label>'
                        + '<div class="col-sm-6">'
                        + '<input type="text"  id="SeoTitle" name="profileImage[seoTitle]"  class="form-control">'
                        + '</div>'
                        + '<div class="col-sm-3 errors" id="SeoTitleErr"></div>'
                        + '</div>'
                        + '<div class="form-group" class="formex">'
                        + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoDescription'); ?></label>'
                        + '<div class="col-sm-6">'
                        + '<input type="text"  id="SeoDescription" name="profileImage[seoDescription]" class="form-control" >'
                        + '</div>'
                        + '<div class="col-sm-3 errors" id="SeoDescriptionErr"></div>'
                        + '</div>'
                        + '<div class="form-group" class="formex">'
                        + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoKeyword'); ?></label>'
                        + '<div class="col-sm-6">'
                        + '<input type="text"  id="SeoKeyword" name="profileImage[seoKeyword]" class="form-control" >'
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
//        console.log(imageval);

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
                        + '<input type="text"  id="BAltText" name="bannerImage[imageText]"  class="form-control">'
                        + '</div>'
                        + '<div class="col-sm-3 errors" id="Alt_TextErr"></div>'
                        + '</div>'
                        + '<div class="form-group" class="formex">'
                        + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoTitle'); ?></label>'
                        + '<div class="col-sm-6">'
                        + '<input type="text"  id="BSeoTitle" name="bannerImage[seoTitle]"  class="form-control">'
                        + '</div>'
                        + '<div class="col-sm-3 errors" id="SeoTitleErr"></div>'
                        + '</div>'
                        + '<div class="form-group" class="formex">'
                        + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoDescription'); ?></label>'
                        + '<div class="col-sm-6">'
                        + '<input type="text"  id="BSeoDescription" name="bannerImage[seoDescription]" class="form-control" >'
                        + '</div>'
                        + '<div class="col-sm-3 errors" id="SeoDescriptionErr"></div>'
                        + '</div>'
                        + '<div class="form-group" class="formex">'
                        + '<label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SeoKeyword'); ?></label>'
                        + '<div class="col-sm-6">'
                        + '<input type="text"  id="BSeoKeyword" name="bannerImage[seoKeyword]" class="form-control" >'
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
    
    function validateEmail(text) {

            var emailstr = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;

            var email = $('#email').val();
            
            if (!emailstr.test(email)) {
                console.log(email);
                $('#email').val('');
//                $('#email').focus();
                $("#text_email").text("<?php echo $this->lang->line('error_ValidEmail'); ?>");
            } else {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php?/Franchise/validateEmail",
                    type: 'POST',
                    data: {email: email},
                    datatype: 'json', // fix: need to append your data to the call
                    success: function (response) {
                        response = JSON.parse(response)
//                    console.log(response.msg);

                        if (response.msg == 1) {
//                    $('#email').attr('data', result.msg);
                            $("#text_email").text("Email is already allocated !");
                            $('#email').val('');
//                            $('#email').focus();
//                            return false;
                        } else if (response.msg == 0) {
                            $("#text_email").text("");

                        }
                    }
                });
            }
        }



        function validatePhone(text) {

//var phonestr = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;

var phoneval = $('#phone').val();

if (phoneval =='' || phoneval ==null) {
   
    $('#phone').val('');
//                $('#email').focus();
    $("#text_phone").text("please enter valid phone number");
} else {
    $.ajax({
        url: "<?php echo base_url(); ?>index.php?/Franchise/validatePhone",
        type: 'POST',
        data: {phoneval: phoneval},
        datatype: 'json', // fix: need to append your data to the call
        success: function (response) {
            response = JSON.parse(response)
//                    console.log(response.msg);

            if (response.msg == 1) {
//                    $('#email').attr('data', result.msg);
                $("#text_phone").text("Phone number is already exist !");
                $('#phone').val('');
//                            $('#email').focus();
//                            return false;
            } else if (response.msg == 0) {
                $("#text_phone").text("");

            }
        }
    });
}
}



</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <div class="inner">
            <!-- START BREADCRUMB -->
            <ul class="breadcrumb" style="margin-left: 0px;">
                <li><a href="javascript: history.go(-1)" class=""><?php echo $this->lang->line('heading_Frachise'); ?></a>
                </li>
                <li style="width: 150px"><a href="#" class="active"><?php echo $this->lang->line('heading_addFranchise'); ?></a>
                </li>
            </ul>
            <!-- END BREADCRUMB -->
        </div>

        <!-- START JUMBOTRON -->
        <div class="bg-white">
            <!-- Nav tabs -->

            <div class="container-fluid container-fixed-lg bg-white">
                <div id="navbar-collapsible"  class="navbar-collapse collapse m-t-50">
                    <!--                    <ul class="navbar-nav navbar-left nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs" style=" -webkit-transition: top .5s; transition: top .5s;">
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
                    
                                        </ul>-->
                    <div class="row"><br></div>

                    <form id="addentity" class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                        <div class="tab-content">
                            <section class="" id="tab1">
                                <div class="row row-same-height">
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_GeneralDetails'); ?></h6>
                                    <hr>

                                    <div class="form-group relative1">
                                        <label id="td1" for="fname" class="col-sm-2 control-label">FRANCHISE LOGO<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <input type="file" name="imageupload" class="error-box-class form-control imagesPFranchise" id="Pimage" attrId="0" value="Text Element 1">

                                        </div>

                                        &nbsp;
                                        <button type="button" id="btAddSeoP" data-id="0" class="btAddSeo btn btn-default btn-primary" style="width: 5%; border-radius: 9px;">
                                            <span class="glyphicon glyphicon-plus " ><?php echo $this->lang->line('label_Seo'); ?></span>
                                        </button>

                                        <input type="hidden" class="defaultImages" id="PdefaultImages"  name="profileImage[logoImage]"/>

                                        <div class="PimageData" style="display: none;">
                                        </div>
                                        <div class="col-sm-3" id="text_imageP"  style="color:red ; display: none;"></div>
                                    </div>


                                    <div class="form-group relative2">
                                        <label id="td1" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_BannerImage'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <input type="file" name="imageupload" class="error-box-class form-control imagesBFranchise" id="Bimage" attrId="1" value="Text Element 1">

                                        </div>

                                        &nbsp;
                                        <button type="button" id="btAddSeoB" data-id="0" class="btAddSeo btn btn-default btn-primary" style="width: 5%; border-radius: 9px;">
                                            <span class="glyphicon glyphicon-plus " ><?php echo $this->lang->line('label_Seo'); ?></span>
                                        </button>

                                        <input type="hidden" class="defaultImages" id="BdefaultImages"  name="bannerImage[bannerimage]"/>

                                        <div class="col-sm-3" id="text_imageB" style="color:red ; display: none;"></div>
                                        <div class="BimageData" style="display: none;">
                                        </div>
                                    </div>


                                    <div class="form-group"id="bussiness_txt">

                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Name'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">  
                                            <input type="text"   id="name_0" name="FranchiseName[0]"  class=" franchisename form-control error-box-class" >
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_name_0" style="color:red">

                                        </div>
                                    </div>


                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group" >
                                                <label for="fname" class=" col-sm-2 control-label"> <?php echo $this->lang->line('label_Name') . ' (' . $val['lan_name'] . ')'; ?></label>
                                                <div class="col-sm-6">
                                                    <input type="text"  id="name_<?= $val['lan_id'] ?>" name="FranchiseName<?= $val['lan_id'] ?>"  class=" franchisename form-control error-box-class" >
                                                </div>
                                            </div>


                                        <?php } else { ?>
                                            <div class="form-group" style="display: none;">
                                                <label for="fname" class=" col-sm-2 control-label"> <?php echo $this->lang->line('label_Name') . ' (' . $val['lan_name'] . ')'; ?></label>
                                                <div class="col-sm-6">
                                                    <input type="text"  id="name_<?= $val['lan_id'] ?>" name="FranchiseName<?= $val['lan_id'] ?>"  class=" franchisename form-control error-box-class" >
                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_OwnerName'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="ownername" name="Ownername"  class="form-control error-box-class" >
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_ownername" style="color:red"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_OwnerPhone'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="tel" maxlength="10" id="phone" name="Phone"  class="form-control error-box-class phoneWidth" onblur="validatePhone(this)" onkeypress="return isNumberKey(event)" >
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_phone" style="color:red"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_OwnerEmail'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="email" name="Email" onblur="validateEmail(this)"   class="form-control error-box-class" autocomplete="new-password">
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_email" style="color:red"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Password'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="password"  id="password" name="Password"  class="form-control error-box-class" autocomplete="new-password" >
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_password" style="color:red"></div>
                                    </div>

                                    <!--                                    <div class="form-group">
                                                                            <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_BusinessPhone'); ?><span class="MandatoryMarker">*</span></label>
                                                                            <div class="col-sm-6">
                                                                                <input type="tel" maxlength="10"  id="businessNumber" name="businessNumber"  class="form-control classRight phoneWidth error-box-class" onkeypress="return isNumberKey(event)" required="">
                                    
                                                                            </div>
                                                                            <div class="col-sm-3 error-box" id="text_businessNumber" style="color:red"></div>
                                                                        </div>-->

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_BusinessWebsite'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="website" name="Website"  class="form-control error-box-class" >
                                        </div>
                                    </div>

                                    <div class="form-group" id="description_txt">

                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Description'); ?></label>
                                        <div class="col-sm-6">
                                            <textarea type="text"  id="description" name="Descrition[0]"  class="description form-control error-box-class" style="max-width: 100%"></textarea>
                                        </div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group" >
                                                <label for="fname" class=" col-sm-2 control-label"><?php echo $this->lang->line('label_Description'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6">
                                                    <textarea type="text"  id="description" name="Descrition[<?= $val['lan_id'] ?>]"  class="description form-control error-box-class" style="max-width: 100%" ></textarea>

                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group" style="display: none;">
                                                <label for="fname" class=" col-sm-2 control-label"><?php echo $this->lang->line('label_Description'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6">
                                                    <textarea type="text"  id="description" name="Descrition[<?= $val['lan_id'] ?>]"  class="description form-control error-box-class" style="max-width: 100%" ></textarea>

                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Category'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <select id="CategoryList" name='Category' class='form-control error-box-class'  <?PHP echo $enable; ?> >
                                                <option value=""><?php echo $this->lang->line('label_SelectCategory'); ?></option>
                                                <?php
                                                if(count($language) < 1){
                                                    foreach ($category as $result) {

                                                        echo "<option value=" . $result['_id']['$oid'] . "  data-name='" . $result['storeCategoryName']['en'] . "'>" . $result['storeCategoryName']['en'] . "</option>";
                                                    }
                                                }
                                                else{
                                                    
                                                    foreach ($category as $result) {
                                                        $catData=$result['storeCategoryName']['en'];
                                                        foreach($language as $lngData){
                                                           // print_r($lngData['langCode']);
                                                            $lngcode=$lngData['langCode'];
                                                            //print_r(gettype($lngcode));
                                                           $lngvalue= ($result['storeCategoryName'][$lngcode]=='') ? "":$result['storeCategoryName'][$lngcode];
                                                           if(strlen($lngvalue)>0)
                                                            $catData .= ','.$lngvalue;
                                                            //print_r($catData);
                                                        }
                                                            echo "<option value=" . $result['_id']['$oid'] . "  data-name='" . implode($result['storeCategoryName'], ',') . "'>" . $catData . "</option>";
                                                       

                                                        
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
                                        <div class="col-sm-3 error-box" id="text_subcatLists" style="color:red"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Country'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <select id="CountryList" name='Country' class='form-control error-box-class'  <?PHP echo $enable; ?> >
                                                <option value=""><?php echo $this->lang->line('label_SelectCountry'); ?></option>
                                                <?php
                                                foreach ($country as $result) {

                                                    echo "<option value=" . $result['_id']['$oid'] . ">" . $result['country'] . "</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_CountryList" style="color:red"></div>

                                    </div>

                                    <input type='hidden' name='cityname' id='cityname'>
                                    <input type='hidden' name='countryname' id='countryname'>
                                    <input type='hidden' name='currencySymbol' id='currencySymbol'>
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
                                    <input type="hidden" id="countryCode" name="coutry-code" value="">
                                    <input type="hidden" id="bcountryCode" name="coutry-code" value="">
                                    <div class="form-group" id="Address_txt" >

                                        <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Address'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control entityAddress error-box-class" id="entityAddress_0" placeholder="Business Address" name="Address[0]"  aria-required="true"  onkeyup="getAddLatLong1(this)" style="max-width: 100%;"></textarea>
                                        </div>
                                        <button  type="button" id="mapbtn1" class=" btn btn-info btn-sm col-sm-1" 
                                                 style="margin-top: 0px;
                                                 width: 5%;
                                                 border-radius: 45px;
                                                 position: relative;
                                                 height: 30px;
                                                 font-size: 13px;" 
                                                 accesskey="" name="action" onclick="callMap();" value="add" data-id="1"><?php echo $this->lang->line('button_Map'); ?></button>
                                        <div class="col-sm-2 error-box" id="text_entityAddress_0" style="color:red"></div>
                                    </div>
                                    <div class="form-group" id="Address_txt" >

                                        <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_BillingAddress'); ?></label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control bentityAddress error-box-class" id="entityAddress_01" placeholder="Billing Address" name="Address[0]"  aria-required="true" style="max-width: 100%;"></textarea>
                                        </div>
                                        <button  type="button" id="mapbtn2" class=" btn btn-info btn-sm col-sm-1" 
                                                 style="margin-top: 0px;
                                                 width: 5%;
                                                 border-radius: 45px;
                                                 position: relative;
                                                 height: 30px;
                                                 font-size: 13px; " 
                                                 accesskey="" name="action" onclick="callMap1();" value="add" data-id="0"><?php echo $this->lang->line('button_Map'); ?></button>
                                    </div>

                                    <input type="hidden" class="form-control" id="entiryLongitude" value='' placeholder="0.00" name="Longitude"  aria-required="true" <?PHP echo $enable; ?>>
                                    <input type="hidden" class="form-control" id="entiryLatitude" value='' placeholder="0.00" name="Latitude"  aria-required="true" <?PHP echo $enable; ?>>

                                    <!-- <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ServiceZones'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <select  id='serviceZones' name='FData[serviceZones][]' class='errr11 form-control serviceZones error-box-class' multiple="multiple">

                                            </select>
                                        </div> 
                                        <div class="col-sm-3 error-box text_err" id="serviceZonesErr" style="color:red"></div>                                       
                                    </div> -->

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_Autoapproval'); ?></label>
                                        <div class="col-sm-6">
                                            <div class="switch">
                                                <input id="Autoapproval" name="Autoapproval" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                <label for="Autoapproval"></label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </section>

                            <!-- End of Tab1 -->

                            <!--Start of Tab2 -->
<!--                            <section class="" id="tab2">
                                <div class="row row-same-height">
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_DriverSettings'); ?></h6>
                                    <hr>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_DriverType'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="checkbox" class="drivers_" name="select_driver" id="grocerDriver" value="1" >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_DispensaryPool'); ?></label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" class="drivers_" name="select_driver" id="storeDriver" value="2" >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_Freelance'); ?></label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" class="drivers_" name="select_driver" id="Offlinedrivers" value="1" >&nbsp;&nbsp;<label>Offline Pool</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_forcedAccept'); ?></label>
                                        <div class="col-sm-6">
                                            <div class="switch">
                                                <input id="forcedAccept" name="forcedAccept" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
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
                                            <input type="radio" class="pricing_ error-box-class" name="price" value="0" >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_zonalPricing'); ?></label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" class="pricing_ error-box-class" name="price"  value="1" >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_MileagePricing'); ?></label>
                                        </div>
                                        <div class="col-sm-2 error-box" id="text_pricing" style="color:red"></div>
                                    </div>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_MinValue'); ?>(<?php echo $appConfig['currency']; ?>)<span class="MandatoryMarker">*</span></label>
                                        <span class="currencySymbol"></span>
                                        <div class="col-sm-6 pos_relative2">
                                            <span class="abs_text currencySymbol"><b><?php echo $appConfig['currency']; ?></b></span>
                                            <input type="text" class="form-control error-box-class" id="entiryminorderVal" value='' placeholder="Minimum Order Value" name="MinimumOrderValue"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>
                                        <div class="col-sm-2 error-box" id="text_entiryminorderVal" style="color:red"></div>
                                    </div>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_ThresholdValue'); ?> (<?php echo $appConfig['currency']; ?>)<span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <span class="abs_text currencySymbol"><b><?php echo $appConfig['currency']; ?></b></span>
                                            <input type="text" class="form-control error-box-class" id="freedelVal" value='' placeholder="Threshold Value" name="FreeDeliveryAbove"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>
                                        <div class="col-sm-2 error-box" id="text_freedelVal" style="color:red"></div>
                                    </div>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_avgDeliveryTime'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <span class="abs_text"><b>minutes</b></span>
                                            <input type="text" class="form-control error-box-class" id="avgDeliveryTime" value='' placeholder="Avg Delivery Time" name="avgDeliveryTime"  aria-required="true" <?PHP echo $enable; ?>>
                                        </div>
                                        <div class="col-sm-2 error-box" id="text_avgDeliveryTime" style="color:red"></div>
                                    </div>

                                    <div class="form-group basefare" >

                                        <div class="form-group ">

                                            <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_BaseFare'); ?> (<?php echo $appConfig['currency']; ?>)</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="basefare" value='' placeholder="Base Fare" name="Basefare"  aria-required="true" <?PHP echo $enable; ?>>
                                            </div>

                                        </div>


                                        <div class="form-group range">

                                            <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_Range'); ?> (<?php echo $appConfig['currency']; ?>)</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="range" value='' placeholder="Range" name="Range"  aria-required="true" <?PHP echo $enable; ?>>
                                            </div>

                                        </div>

                                        <div class="form-group Priceperkm">

                                            <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_Price'); ?>/<?php echo $appConfig['distance']; ?> (<?php echo $appConfig['currency']; ?>)</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="Priceperkm" value='' placeholder="Price/<?php echo $appConfig['distance']; ?>" name="priceperkm"  aria-required="true" <?PHP echo $enable; ?>>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_ServiceSettings'); ?></h6>
                                    <hr>

                                    <div class="form-group" >
                                        <label for="fname" id="OrderType" class="col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_OrderType'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6" id="accepts" >
                                            <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts error-box-class" id="accepts_1" value="1"><label><?php echo $this->lang->line('label_Pickup'); ?> </label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts error-box-class" id="accepts_2" value="2"><label><?php echo $this->lang->line('label_Delivery'); ?> </label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts error-box-class" id="accepts_3" value="3"><label><?php echo $this->lang->line('label_Both'); ?> </label>
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_accepts" style="color:red;"></div>
                                    </div>

                                    <hr>
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_PaymentSettings'); ?></h6>
                                    <hr>

                                    <div class="form-group Pickup">
                                        <label for="fname" class="Pcheckbox col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_PaymentMethodForPickup'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="checkbox" class="Pcheckbox_ error-box-class" name="payment[]" id="Pcash" value="1" >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_Cash'); ?></label> 

                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" class="Pcheckbox_" error-box-class name="payment[]" id="Pcredit_card" value="2" >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_CreditCard'); ?></label> 

                                            &nbsp;&nbsp;&nbsp;&nbsp;

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_paymentp" style="color:red;"></div>
                                    </div>

                                    <div class="form-group  Delivery">
                                        <label for="fname" class="Dcheckbox col-sm-2 control-label error-box-class"><?php echo $this->lang->line('label_PaymentMethodForDel'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="checkbox" class="Dcheckbox_ error-box-class" name="payment[]" id="Dcash" value="1" >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_Cash'); ?></label> 

                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" class="Dcheckbox_ error-box-class" name="payment[]" id="Dcredit_card" value="1" >&nbsp;&nbsp;<label><?php echo $this->lang->line('label_CreditCard'); ?></label> 

                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_dpayment" style="color:red;"></div>
                                    </div>

                                    <hr>

                                </div>
                            </section>-->
                            <!--End of Tab2-->
<!--                            <section class="" id="tab3">
                                <div class="row row-same-height">
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_DriverMileageSetting'); ?></h6>
                                    <hr>


                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_baseFare'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $appConfig['currency']; ?></b></span>
                                            <input type="text" name="pricing[baseFare]" id="baseFare" placeholder="Enter Base Fare" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Mileage_Price'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $appConfig['currency']; ?></b></span>
                                            <input type="text" name="pricing[mileagePrice]" id="mileagePrice" placeholder="Enter Mileage Price" class="form-control required">
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="abs_textLeft"><b>After</b></span>
                                            <input type="text" name="pricing[mileagePriceAfterMinutes]" id="mileagePriceAfter" value="0" style="padding-left: 74px;" class="form-control required">
                                            <span class="abs_text1"><b><?php echo $this->lang->line('KM'); ?></b></span>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_timeFee'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $appConfig['currency']; ?></b></span>
                                            <input type="text" name="pricing[timeFee]" id="timeFee" placeholder="Enter Time Fee" class="form-control required">
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="abs_textLeft"><b>After</b></span>
                                            <input type="text" name="pricing[timeFeeAfterMinutes]" style="padding-left: 74px;" value="0" id="timeFeeAfter" placeholder="Enter time fare" class="form-control required">
                                            <span class="abs_text1"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_waitingFee'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $appConfig['currency']; ?></b></span>
                                            <input type="text" name="pricing[waitingFee]" id="waitingFee" placeholder="Enter Waiting Fee" class="form-control required">
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="abs_textLeft"><b>After</b></span>
                                            <input type="text" value="0" name="pricing[waitingFeeAfterMinutes]" style="padding-left: 74px;" id="waitingFeeAfter" class="form-control required">
                                            <span class="abs_text1"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_minimumFare'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $appConfig['currency']; ?></b></span>
                                            <input type="text" name="pricing[minimumFare]" id="minimumFare" placeholder="Enter Minimum Fare" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_On-Demand Bookings_Cancellation_Fee'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $appConfig['currency']; ?></b></span>
                                            <input type="text" name="pricing[onDemandBookingsCancellationFee]" id="onDemandBookingsCancellationFee" placeholder="Enter Now Booking Cancellation Fee" class="form-control required">
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="abs_textLeft"><b>After</b></span>
                                            <input type="text" style="padding-left: 74px;" value="0" name="pricing[onDemandBookingsCancellationFeeAfterMinutes]" id="onDemandBookingsCancellationFeeAfter" class="form-control required">
                                            <span class="abs_text1"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_ScheduledBookingsCancellationFee'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $appConfig['currency']; ?></b></span>
                                            <input type="text" name="pricing[scheduledBookingsCancellationFee]" id="ScheduledBookingsCancellationFee" placeholder="Enter Scheduled Booking Cancellation Fee" class="form-control required">
                                        </div>
                                        <div class="col-sm-4">

                                            <span class="abs_textLeft"><b>After</b></span>
                                            <input type="text" style="padding-left: 74px;" value="0" name="pricing[ScheduledBookingsCancellationFeeAfterMinutes]" id="ScheduledBookingsCancellationFee"  class="form-control required">
                                            <span class="abs_text1"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_ConvenienceFee'); ?></label>
                                        <div class="col-sm-4">
                                            <span class="abs_text1 currencySymbol"><b><?php echo $appConfig['currency']; ?></b></span>
                                            <input type="text" name="pricing[convenienceFee]" id="convenienceFee" placeholder="Enter Convenience Fee" class="form-control required">
                                        </div>
                                    </div>


                                </div>
                            </section>-->
                            <section class="" id="tab2">
                                <div class="row row-same-height">
                                    <h6 class="textAlign"><?php echo $this->lang->line('heading_SocialMediaLinks'); ?></h6>
                                    <hr>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Facebook'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="socialMediaLinks[Facebook]" id="Facebook" placeholder="Enter Facebook link" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Twitter'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="socialMediaLinks[Twitter]" id="Twitter" placeholder="Enter Twitter link" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Instagram'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="socialMediaLinks[Instagram]" id="Instagram" placeholder="Enter Instagram link" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_LinkedIn'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="socialMediaLinks[LinkedIn]" id="LinkedIn" placeholder="Enter LinkedIn link" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Google'); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="socialMediaLinks[Google]" id="Google" placeholder="Enter Google+ link" class="form-control">
                                        </div>
                                    </div>


                                </div>
                            </section>
                        </div>

                        <div class="padding-20 bg-white">
                            <ul class="pager wizard">

                                <li class="" id="finishbutton">
                                    <button class="btn btn-primary btn-cons btn-animated from-left pull-right" type="button"  id="insert">
                                        <span style="height: 24px; "><?php echo $this->lang->line('button_Finish'); ?></span>
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
    <input type="hidden" id="mapBtnDataId" value="">
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
                            <textarea rows="4" cols="50" class="form-control" id="mapentityAddress" style="max-width: 100%;" placeholder="Address.." name="FData[businessAddress][0]"   onkeyup="getAddLatLong()"><?PHP echo $ProfileData['Address'][0]; ?></textarea>

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