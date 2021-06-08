<?php $appConfig['currency'] = '$';?>

<link href="<?php echo base_url();?>application/views/js/jquery.multiselect.css"
      rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>application/views/js/jquery.multiselect.js"
type="text/javascript"></script>



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
</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE"></script>

<script>

    function callMap() {
//        alert();
//       
        $('#ForMaps').modal('show');


        if ($('#entiryLatitude').val() != "" && $('#entiryLongitude').val() != "") {
            initialize1($('#entiryLatitude').val(), $('#entiryLongitude').val());
            $('#mapentityAddress').val($('#entityAddress_0').val());
        } else {
            initialize1(20.268455824834792, 85.84099235520011);
        }
    }
    function Cancel() {
        $('#ForMaps').modal('hide');

    }

    function Take() {
//        alert();
        $('#entiryLongitude').val($('#longitude').val());
        $('#entiryLatitude').val($('#latitude').val());
        $('.entityAddress').val($('#mapentityAddress').val());
//        $('#entityAddress').val($('#entityAddress').val());

//        $('#entityAddress2').val($('#address2').val());

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

        var addr = text.value;
//        alert(addr)
//        alert(text.value);
        $.ajax({
            url: "<?php echo base_url();?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                console.log(Arr.Lat);
                $('#entiryLatitude').val(Arr.Lat);
                $('#entiryLongitude').val(Arr.Long);
            }
        });
    }
    function getAddLatLong(text) {

        var addr = text.value;
        $.ajax({
            url: "<?php echo base_url();?>application/views/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                console.log(Arr.Lat);
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

        var options = {componentRestrictions: {country: 'us'}};

        var autocomplete = new google.maps.places.Autocomplete(input);

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

        $('.Pickup').show();
        $('.Delivery').show();
        $('.basefare').hide();
        $('#cityLists').change(function () {
            $('#cityname').val($('#cityLists option:selected').text());
        });

        $('#CatId').on('change', function () {

            var val = $(this).val();
            $('#subcat').load("<?php echo base_url('index.php?/SubCategory') ?>/getSubCategoryData", {val: val});


        });
        $('#CountryList').on('change', function () {

            var val = $(this).val();
            $('#cityList').load("<?php echo base_url('index.php?/City') ?>/getCityList", {val: val});


        });


        $('#insert').click(function () {

            var status = '<?php echo $status; ?>';
            $('.clearerror').text("");
            var BusinessName = new Array();
//            varBusinessName BusinessName = $(".businessname").val();
            $(".businessname").each(function () {
                if ($(this).val() != '')
                    BusinessName.push($(this).val());
            });

            var Description = new Array();
//            varBusinessName BusinessName = $(".businessname").val();
            $(".description").each(function () {
                if ($(this).val() != '')
                    Description.push($(this).val());
            });

            var Address = new Array();
            //            varBusinessName BusinessName = $(".businessname").val();
            $(".entityAddress").each(function () {
                if ($(this).val())
                    Address.push($(this).val());
            });
//             BusinessName = BusinessName.push(.val())

            var OwnerName = $("#ownername").val();
            var Phone = $("#phone").val();
            var Email = $("#email").val();
            var Password = $("#password").val();
            var Website = $("#website").val();
//            var Description = $(".description").val();
//            var Address = $(".entityAddress").val();
            var Country = $("#CountryList").val();
            var city = $("#cityLists").val();
            var Postalcode = $("#entitypostalcode").val();
            var Longitude = $("#entiryLongitude").val();
            var Latitude = $("#entiryLatitude").val();
            var avgcooktime = $("#avgcooktime").val();
            var BizId = $("#BizId").val();
            var CatId = $("#CatId").val();
            var Budget = $("#budget").val();
            var subCatId = $("#subCatId").val();
            var pricing = $("input[name='price']:checked").val();
            var Jaiecomdriver = $("#Jaiecomdriver0").val();
            var Storedriver = $("#Storedriver1").val();
            var Offlinedriver = $("#Offlinedrivers").val();
            var tier1 = parseInt($("#tier1").val());
            var tier2 = parseInt($("#tier2").val());
            var tier3 = parseInt($("#tier3").val());
            var notes = $("#notes").val();
            var minorderVal = $('#entiryminorderVal').val();
            var freedelVal = $('#freedelVal').val();

            var select = $('.accepts:checked').val();
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

            if (BusinessName == "" || BusinessName == null)
            {
                $("#clearerror").text(<?php echo json_encode(POPUP_BUSINESS_NAME); ?>);
            }
//            else if (OwnerName == "" || OwnerName == null)
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_OWNER_NAME); ?>);
//            } else if (Phone == "" || Phone == null)
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_DRIVER_MOBILE); ?>);
//            } else if (Email == "" || Email == null)
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_COMPANY_EMAIL); ?>);
//            } else if (!emails.test(Email))
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_COMPANY_NAMEVALID); ?>);
//            } else if (Password == "" || Password == null)
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_PASSENGERS_PASSENTER); ?>);
//            } else if (!passwordstrong.test(Password))
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_PASSENGERS_PASSVALID); ?>);
//            } else if (Website == "" || Website == null)
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_WEBSITE_NAME); ?>);
//            } else if (Description == "" || Description == null)
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_DESC); ?>);
//            } else if (Address == "" || Address == null)
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_ADDR); ?>);
//            } 
//            else if (Country == "0" || Country == null)
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_COUNTRY); ?>);
//            } else if (city == "0" || city == null)
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_CITY); ?>);
//            }
//            else if (Postalcode == "" || Postalcode == null)
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_POSTCODE); ?>);
//            } else if (CatId == "0")
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_CAT_SECLECT); ?>);
//            } else if (subCatId == "0")
//            {
//                $("#clearerror").text(<?php echo json_encode(POPUP_SUBCAT_SECLECT); ?>);
//            } 
//            else if (tier1 == "" || tier1 == null)
//            {
//                $("#clearerror").text("Please enter tier1 radius" );
//            } else if (tier2 == "" || tier2 == null)
//            {
//                $("#clearerror").text("Please enter tier2 radius" );
//            } else if (tier1 > tier2)
//            {
//                $("#clearerror").text("tier 2 should be greater than tier 1");
//            } else if (tier3 == "" || tier3 == null)
//            {
//                $("#clearerror").text("Please enter tier3 radius" );
//            } else if (tier2 > tier3)
//            {
//                $("#clearerror").text("tier 3 should be greater than tier 2");
//            }
            else {

                $.ajax({
                    url: "<?php echo base_url('index.php?/Business') ?>/operationBusiness/insert",
                    type: 'POST',
                    data: {
                        BusinessName: BusinessName,
                        OwnerName: OwnerName,
                        Phone: Phone,
                        Email: Email,
                        Password: Password,
                        Website: Website,
                        Description: Description,
                        Address: Address,
                        Longitude: Longitude,
                        Latitude: Latitude,
                        Country: Country,
                        city: city,
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
                        Jaiecomdriver: Jaiecomdriver,
                        Storedriver: Storedriver,
                        Offlinedriver: Offlinedriver,
                    },
                    dataType: 'JSON',
                    async: true,
                    success: function (response)
                    {
                        window.location = "<?php echo base_url('index.php?') ?>/Business";
//              
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
                                <textarea class="form-control" id="Adress_' + $(val).val() + '" placeholder="Address" name="Address[0]"  aria-required="true" onkeyup="getAddLatLong1(this)"></textarea>\
                            </div>\
                          </div>';
                $('#Address_txt').append(html);
            } else {
                $('.cat_lan_' + $(this).val()).remove();
            }
        });
    });

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
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="margin-left: 20px;">
                    <li><a href="#" class="">DISPENSARIES</a>
                    </li>

                    <li style="width: 100px"><a href="#" class="active">ADD NEW</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>

            <div class="container-fluid container-fixed-lg bg-white">
                <form id="addentity" class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="tab-content">
                        <h5>General Information</h5> <hr>
                       
                        <div class="form-group"id="bussiness_txt">

                                <label for="fname" class="col-sm-2 control-label">STORE NAME (English) <span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-6">  
                                    <input type="text"   id="businessname_0" name="Businessname[0]"  class=" businessname form-control error-box-class" >
                                </div>
                            </div>

<?php
foreach ($language as $val) {
//                                         print_r($val);
    ?>
                                <div class="form-group">
                                    <label for="fname" class=" col-sm-2 control-label"> <?php echo "STORE NAME" . ' (' . $val['lan_name'] . ')'; ?> <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text"  id="businessname_<?= $val['lan_id'] ?>" name="Businessname<?= $val['lan_id'] ?>"  class=" businessname form-control error-box-class" >
                                    </div>
                                </div>

<?php } ?>



                        </div>
                        <br>
                        <br>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label">OWNER NAME<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="ownername" name="Ownername"  class="form-control error-box-class" >
                            </div>
                        </div>
                        <br>
                        <br>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label">PHONE NUMBER<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="phone" name="Phone"  class="form-control error-box-class" >
                            </div>
                        </div>

                        <br>
                        <br>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label">EMAIL<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="email" name="Email"  class="form-control error-box-class" >
                            </div>
                        </div>

                        <br>
                        <br>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label">PASSWORD<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="password" name="Password"  class="form-control error-box-class" >
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label"> WEBSITE<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="website" name="Website"  class="form-control error-box-class" >
                            </div>
                        </div>
                        <br>
                        <br>
                        <div id="description_txt">
                            <div class="form-group" lan_append formex">
                                 <label for="fname" class="col-sm-3 control-label"> DESCRIPTION (English)<span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-6">
                                    <textarea type="text"  id="description" name="Descrition[0]"  class="description form-control error-box-class" ></textarea>
                                </div>
                            </div>
<?php
foreach ($language as $val) {
//                                   print_r($val);
    ?>
                                <div class="form-group lan_append formex" >
                                    <label for="fname" class=" col-sm-3 control-label"> DESCRIPTION (<?php echo $val['lan_name']; ?>)<span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea type="text"  id="description" name="Descrition[<?= $val['lan_id'] ?>]"  class="description form-control error-box-class" ></textarea>
                                       
                                    </div>
                                </div>
<?php } ?>

                        </div>
                        <br>
                        <br>
                        <div id="Address_txt" >
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label ">ADDRESS (English)<span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control entityAddress" id="entityAddress_0" placeholder="Address" name="Address[0]"  aria-required="true"  onkeyup="getAddLatLong1(this)"></textarea>
                                </div>
                            </div>
<?php
foreach ($language as $val) {
//                                         print_r($val);
    ?>
                                <div class="form-group lan_append formex" >
                                    <label for="fname" class=" col-sm-3 control-label"> ADDRESS (<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control entityAddress" id="entityAddress_<?= $val['lan_id'] ?>" placeholder="Address" name="Address[<?= $val['lan_id'] ?>]"  aria-required="true" ></textarea>
                                    </div>
                                    <button  type="button" class=" btn btn-danger btn-sm" 
                                             style="margin-top: -80px;
                                             width: 5%;
                                             border-radius: 45px;
                                             position: relative;
                                             height: 41px;
                                             font-size: 13px;" 
                                             accesskey="" name="action" onclick="callMap();" value="add">Map</button>
                                </div>

<?php } ?>
                            <div class="col-sm-1">

                            </div>

                        </div>
                        <br>
                        <br>

                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">COUNTRY<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <select id='CountryList' name='Country' class='form-control'  <?PHP echo $enable; ?>>
                                    <option value="0">Select Country</option>
<?php
foreach ($country as $result) {

    echo "<option value=" . $result['_id']['$oid'] . ">" . $result['country']. "</option>";
}
?>
                                </select>
                            </div>
                            <div class="col-sm-1">

                            </div>
                        </div>

                        <br>
                        <br>
                        <input type='hidden' name='cityname' id='cityname'>
                        <input type='hidden' name='countryname' id='countryname'>
                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">CITY<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <div id='CityList'>
                                    <select id='cityLists' class="form-control" name='City' <?PHP echo $enable; ?> >
                                        <option value=''>Select City</option>
                                        

                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-1">

                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">POSTAL CODE<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="entitypostalcode" value='' placeholder="0" name="PostalCode"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>
                            <div class="col-sm-1">

                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">LONGITUDE<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="entiryLongitude" value='' placeholder="0.00" name="Longitude"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>
                            <div class="col-sm-1">

                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">LATITUDE<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="entiryLatitude" value='' placeholder="0.00" name="Latitude"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>
                            <div class="col-sm-1">

                            </div>
                        </div>
                        <br>
                        <hr>
                        <h5>Grocer Category Settings</h5>
                        <hr>
                        <br>

                        <div class="form-group" class="formex">
                            <div class="frmSearch">
                                <label for="fname" class="col-sm-3 control-label">CATEGORY<span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-6">
                                    <select id="CatId" name="cat_select"  class="form-control error-box-class" >
                                        <option value="">Select Category</option>


<?php
foreach ($category as $result) {
    echo "<option value=". $result['categoryId'] .">" . implode($result['name'], ',') . "</option>";
}
?>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="form-group" class="formex">
                            <div class="frmSearch">
                                <label for="fname" class="col-sm-3 control-label">SUB-CATEGORY<span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-6" id="subcat" >
                                    <select id="subCatId" name="subcat_select[]"  class="form-control error-box-class" >
                                        <option value="">Select Sub-Category</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <h5>Driver Settings</h5>
                        <hr>
                        <br>
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label">DRIVERS TYPE</label>
                            <div class="col-sm-6">
                                <input type="checkbox" class="drivers_" name="select_driver" id="Jaiecomdriver0" value="1" >&nbsp;&nbsp;<label>Grocer Pool</label> 
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class="drivers_" name="select_driver" id="Storedriver1" value="1" >&nbsp;&nbsp;<label>Store Pool</label> 
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class="drivers_" name="select_driver" id="Offlinedrivers" value="1" >&nbsp;&nbsp;<label>Offline Pool</label>
                            </div>

                        </div>
                        <br>
                        <hr>
                        <h5>Price Settings</h5>
                        <hr>
                        <br>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label">PRICING MODAL</label>
                            <div class="col-sm-6">
                                <input type="radio" class="pricing_" name="price" value="0" >&nbsp;&nbsp;<label>Zonal Pricing</label> 
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" class="pricing_" name="price"  value="1" >&nbsp;&nbsp;<label>Mileage Pricing</label>
                            </div>

                        </div>
                        <br>
                        <br>

                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">MINIMUM ORDER VALUE (<?php echo $appConfig['currency'];?>)</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="entiryminorderVal" value='' placeholder="Minimum Order Value" name="MinimumOrderValue"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>

                        </div>
                        <br>
                        <br>

                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">FREE DELIVERY ABOVE (<?php echo $appConfig['currency'];?>)</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="freedelVal" value='' placeholder="Free Delivery Above" name="FreeDeliveryAbove"  aria-required="true" <?PHP echo $enable; ?>>
                            </div>

                        </div>

                        <div class="form-group basefare" >
                            <br>
                            <br>
                            <div class="form-group ">

                                <label for="fname" class="col-sm-3 control-label">BASE FARE (<?php echo $appConfig['currency'];?>)</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="basefare" value='' placeholder="Base Fare" name="Basefare"  aria-required="true" <?PHP echo $enable; ?>>
                                </div>

                            </div>
                            <br>
                            <br>

                            <div class="form-group range">

                                <label for="fname" class="col-sm-3 control-label">RANGE (<?php echo $appConfig['currency'];?>)</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="range" value='' placeholder="Range" name="Range"  aria-required="true" <?PHP echo $enable; ?>>
                                </div>

                            </div>
                            <br>
                            <br>
                            <div class="form-group Priceperkm">

                                <label for="fname" class="col-sm-3 control-label">PRICE/<?php echo $appConfig['distance'];?> (<?php echo $appConfig['currency'];?>)</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="Priceperkm" value='' placeholder="Price/<?php echo $appConfig['distance'];?>" name="priceperkm"  aria-required="true" <?PHP echo $enable; ?>>
                                </div>

                            </div>
                        </div>
                        <br>
                        <hr>
                        <h5>SERVICE SETTINGS</h5>
                        <hr>
                        <br>
                        <div class="form-group" class="formex">

                            <div class="frmSearch">
                                <label for="fname" class="col-sm-3 control-label">Order Type<span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-6" id="accepts" >
                                    <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts" id="accepts_1" value="1"> Pickup
                                    <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts" id="accepts_2" value="2"> Delivery
                                    <input type="radio" name="Accepts" onclick="acceptselect();" class="accepts" id="accepts_3" value="3"> Both<br>
                                </div>
                            </div>
                        </div>

                        <br>
                        <hr>
                        <h5>Payment Settings</h5>
                        <hr>
                        <br>

                        <div class="form-group formex Pickup">
                            <label for="fname" class="col-sm-3 control-label">PAYMENT METHOD FOR PICKUP<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <input type="checkbox" class="Pcheckbox_" name="payment[]" id="Pcash" value="1" >&nbsp;&nbsp;<label>Cash</label> 
                               
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class="Pcheckbox_" name="payment[]" id="Pcredit_card" value="1" >&nbsp;&nbsp;<label>Credit Card</label> 
                                
                                &nbsp;&nbsp;&nbsp;&nbsp;

                            </div>
                        </div>
                        <br>

                        <div class="form-group formex Delivery">
                            <label for="fname" class="col-sm-3 control-label">PAYMENT METHOD FOR DELIVERY<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <input type="checkbox" class="Dcheckbox_" name="payment[]" id="Dcash" value="1" >&nbsp;&nbsp;<label>Cash</label> 
                              
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class="Dcheckbox_" name="payment[]" id="Dcredit_card" value="1" >&nbsp;&nbsp;<label>Credit Card</label> 
                               
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                        </div>
                        <br>
                        <br>
                        <hr>
                        <h5>Notes</h5>
                        <hr>
                        <br>
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-3 control-label"> NOTE </label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="notes" name="notes"  class="description form-control error-box-class" ></textarea>
                            </div>
                        </div>
                        <!--<br>-->

                        <div class="row">
                            <div class="col-sm-4" ></div>
                            <div class="col-sm-4 error-box" id="clearerror"></div>
                            <div class="col-sm-4" >
                                <button type="button" class="btn btn-primary pull-right" id="insert" >ADD</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
</div>


<div class="modal fade stick-up" id="addmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxaddmodal modalPopUpText">Are you sure you wish to activate the selected business ?</div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds1" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade in" id="ForMaps" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
    <div class="modal-dialog">

            <!--<form id="search_form" action = "<?php echo base_url(); ?>index.php?/superadmin/AddNewCenter" method= "post" onsubmit="return validateForm();">-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  class="close" onclick='Cancel();' data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Drag Marker To See Address</h4>
            </div>

            <div class="modal-body"><div class="form-group" >
                    <div id="myMap" style="width: 544px; height: 250px;"></div><br/>
                    <!--                            <div class="form-group">
                                                    <label>Address Line </label>
                                                    <input type="text" class="form-control" value="" placeholder="Address ..." name="address" id="address" onkeyup="getAddLatLong(this);">
                                                    <textarea class="form-control" id="entityAddress" placeholder="Address..." name="FData[Address]" onkeyup="getAddLatLong(this)"><?PHP echo $ProfileData['Address']; ?></textarea>
                    
                                                </div> -->
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" value="<?PHP echo $ProfileData['Address']; ?>" placeholder="Address ..." name="FData[Address]"
                               id="mapentityAddress" onkeyup="getAddLatLong(this);" on  >
                    </div> 

                    <div class="col-md-6">
                        <label>Latitude</label>
                        <input type="text" class="form-control" value="" placeholder="Latitude ..." name="latitude" id="latitude">
                    </div> 
                    <div class="col-md-6">
                        <label>Longitude</label>
                        <input type="text" class="form-control" value="" placeholder="Longitude ..." name="longitude" id="longitude">
                    </div> 

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick='Cancel();'>Close</button>
                <input type="button" id="TakeMapAddress"  data-dismiss="modal" class="btn btn-primary" onclick='Take();' value="Take Address" >

            </div>
        </div>
        <!--</form>-->
        </form>

    </div>

</div>