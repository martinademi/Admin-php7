<link href="application/views/city/styles.css" rel="stylesheet" type="text/css">
<script src="//maps.googleapis.com/maps/api/js?key=<?= GOOGLE_MAP_API_KEY ?>&v=3&libraries=drawing,places"></script>
<!--<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCAnpL4IiJt_jeFspg16XQshxmbnl-zGbU&v=3&libraries=drawing,places"></script>-->
<script src="<?= base_url() ?>/theme/ZoneMapAssets/javascript.util.min.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/jsts.min.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/wicket.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/wicket-gmap3.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="//admin.uberforall.com/supportFiles/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="//admin.uberforall.com/supportFiles/sweetalert.css">
<style>
    .stripeLiveEnable{
        display: none;
    }
    span.abs_text {
        position: absolute;
        right:10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
        margin-top: 0px;
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
        margin-top: 10px;
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
    span.abs_textLeft1 {
        position: absolute;
        left: 12px;
        top: 11px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
    }

    .mandatory{
        color:red;
    }
</style>
<script>
    var idNum = 0;
    var expanded = false;
    var expanded1 = false;
    var walletEnDis;
    var html;
    var shortCountryCode;

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


    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");

        if (!expanded) {

            checkboxes.style.display = "block";

            expanded = true;
        } else {
            checkboxes.style.display = "none";

            expanded = false;
        }
    }
    function showCheckboxesForTax() {
        var checkboxesTax = document.getElementById("checkboxesTax");

        if (!expanded1) {
            checkboxesTax.style.display = "block";
            expanded1 = true;
        } else {
            checkboxesTax.style.display = "none";
            expanded1 = false;
        }
    }

    //Using For Generate Wicket from google polygon
    function UseWicketToGoFromGooglePolysToWKT(poly1, poly2) {
        var wicket = new Wkt.Wkt();

        wicket.fromObject(poly1);
        var wkt1 = wicket.write();

        wicket.fromObject(poly2);
        var wkt2 = wicket.write();

        return [wkt1, wkt2];
    }
    //Using For check Polygon is Overlapping to other or not
    function UseJstsToTestForIntersection(wkt1, wkt2) {
        // Instantiate JSTS WKTReader and get two JSTS geometry objects
        var wktReader = new jsts.io.WKTReader();
        var geom1 = wktReader.read(wkt1);
        var geom2 = wktReader.read(wkt2);

        if (geom2.intersects(geom1)) {
            return true;
        } else {
            return false;
        }
    }

    var map = "";
    var drawingManager = "";
    var polygonProps = null;
    var rectangle = null;
    var citiesArr = <?= json_encode($allCities) ?>;
    if(!citiesArr){		
            citiesArr = [];		
        }
    // console.log(citiesArr);
//    var cities = "";
    var symbol = $('#currency_symbol').val();
    $(document).ready(function () {
        $('#cityError').hide();

        $('#city_name').keyup(function(){
            $('#cityError').hide();
        });

//        $('.checkboxTax').change(function () { 
//            if ($(this).attr("checked")) {
//                html = '<span class="abs_textLeft1 '+$(this).attr('dataId')+'">' + $(this).attr('dataName') + '</span><span class="abs_text1 ' + $(this).attr('dataName') + '"><b>%</b></span><input type="text" onkeypress="return isNumberKey(event)" maxlength="3" class="form-control col-sm-6" style="padding-left:75px;margin-top:10px;" name="fdata[taxValues][]"  id="' + $(this).attr('dataId') + '"/>'
//                $('.' + $(this).attr('dataId')).append(html);
//            } else {
//                $('#' + $(this).attr('dataId')).remove();
//
//                $('.' + $(this).attr('dataName')).remove();
//            }
//
//
//        });


        var latlng = new google.maps.LatLng(12.972442010578353, 77.5909423828125);
        map = new google.maps.Map(document.getElementById('city_zone_map'), {
            center: latlng,
            zoom: 10
        });

        google.maps.event.addListenerOnce(map, 'idle', function () {
            google.maps.event.trigger(map, 'resize');
        });
//        if (navigator.geolocation) {
//            navigator.geolocation.getCurrentPosition(function (position) {
//                var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
//                map.setCenter(pos);
//            }, function () {
//                console.log('error');
//            });
//        }

        google.maps.event.addListenerOnce(map, 'idle', function () {
            google.maps.event.trigger(map, 'resize');
        });

        var polyOptions = {
            "strokeColor": "#000000",
            "strokeOpacity": 0.2,
            "strokeWeight": 2,
            "fillColor": "#000000",
            "fillOpacity": 0.35,
            "editable": true,
            "draggable": true
        };

        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [google.maps.drawing.OverlayType.POLYGON]
            },
            polygonOptions: polyOptions,
            map: map
        });

        google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
            polygonProps = polygon;
            drawingManager.setMap(null);

            drawingManager.setDrawingMode(null);

            $('#btnResetZone').show();

            google.maps.event.addListener(polygon.getPath(), 'set_at', function () {
                polygonProps = polygon;
            });

            google.maps.event.addListener(polygon.getPath(), 'insert_at', function () {
                polygonProps = polygon;
            });
        });

        google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
            if (event.type == google.maps.drawing.OverlayType.POLYGON) {
                if (rectangle != null)
                    rectangle.setMap(null);
                rectangle = event.overlay;
                drawingManager.setDrawingMode(null);
            }
        });

        google.maps.event.addListener(drawingManager, "drawingmode_changed", function () {
            if ((drawingManager.getDrawingMode() == google.maps.drawing.OverlayType.POLYGON) &&
                    (rectangle != null))
                rectangle.setMap(null);
        });

        var options = {
            types: ['(cities)']
        };

        var input = document.getElementById('city_name');

        var autocomplete = new google.maps.places.Autocomplete(input, options);
        var cityName = '';
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            
            var country = "";
            var state = "";
        try{
            for (var i = 0; i < place.address_components.length; i++) {
                for (var j = 0; j < place.address_components[i].types.length; j++) {
                    if (place.address_components[i].types[j] == "country"){
                        country = place.address_components[i].long_name;
                        shortCountryCode=place.address_components[i].short_name;
                        $('#shortCountryCode').val(shortCountryCode);
                        console.log('country code',place.address_components[i].short_name)
                    }
                        
                    if (place.address_components[i].types[j] == "administrative_area_level_1")
                        state = place.address_components[i].long_name;
                }
            }
            }catch(error){
                $('#cityError').show();
            }
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(10);
            }


            var latlong = place.geometry.location.lat()+','+place.geometry.location.lng();
            var timestamp = + new Date();
            timestamp = parseInt(timestamp/1000);

                $.ajax({
                    url: "https://maps.googleapis.com/maps/api/timezone/json?location="+latlong+"&timestamp="+timestamp+"&key=<?= GOOGLE_MAP_API_KEY ?>",
                    type: 'GET',
                    dataType: 'JSON',
                    async: false,
                    success: function (response)
                    {
                      console.log('response----',response.timeZoneId);
                      $("#timeZoneId").val(response.timeZoneId);
                 
                    }
                });


            var cityExist = false;
            cityName = place.name;
            $.each(citiesArr, function (index, response) {
                if (response.cities.cityName == place.name && response.country === country && response.cities.state === state) {
                    cityExist = true;
                    return false;
                }
            })

            if (cityExist)
            {
                var erroFlag = false;
                //check if the city is deleted
                $.ajax({
                    url: '<?php echo base_url() ?>index.php?/city/checkCityDeleted',
                    dataType: "json",
                    type: "POST",
                    data: {city: cityName},
                    async: false,
                    success: function (result) {
                        //City was deleted.Activate it again
                        erroFlag = result.errorFlag;
                    }

                });

                if (erroFlag) {
                    console.log('p1');
                    $('#activateCity').show();
                    $('#errorbox').text('<?php echo $this->lang->line('label_already_city_exist_deleted'); ?>');
                } else {
                    console.log('p2');
                    $('#errorbox').text('<?php echo $this->lang->line('label_already_city_exist'); ?>');
                    // earlier it was hide
                    $('#activateCity').show();
                }

                $('#cityExistsPopUp').modal('show');
                $('#city_name').val('');
                $('#city_state_name').val('');
                $('#city_state_name_hidden').val('');
                $('#city_country_name').val('');
                $('#city_lat').val('');
                $('#city_long').val('');
            } else {
                $('#city_name').val(place.name);
                $('#city_state_name').val(state);
                $('#city_state_name_hidden').val(state);
                $('#city_country_name').val(country);
                $('#city_country_name_hidden').val(country);
                var lat = parseFloat(place.geometry.location.lat()).toFixed(6);
                var lng = parseFloat(place.geometry.location.lng()).toFixed(6);
                $('#city_lat').val(lat);
                $('#city_long').val(lng);
            }
        });


        $('#activateCity').click(function ()
        {
            //update the city status if it exists already
            var data = {"isDeleted": false, 'city': cityName,<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'};
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/city/checkCityExists'
                , dataType: "json"
                , type: "POST"
                , data: data
                , async: true
                , success: function (data) {

                    if (data.flag == 0)
                    {
                        $('.close').trigger('click');
                        $('.Ok').trigger('click');
                        window.location = "<?php echo base_url(); ?>index.php?/city";
                    } else {
                        alert('while updating databse getting an error');
                    }
                }
                , error: function (xhr) {
                    alert('error');
                }
            });
        });

        $('#btnResetZone').click(function () {
            rectangle.setMap(null);
            drawingManager.setMap(map);
            polygonProps = null;
            $('#btnResetZone').hide();
        });
        var cityZone = [];
        var infoWindow = [];
        $.each(citiesArr, function (ind, val) {
            val = val.cities;
            val.polygonProps.ind = ind;
            cityZone[ind] = new google.maps.Polygon(val.polygonProps);
            cityZone[ind].setMap(map);

            infoWindow[ind] = new google.maps.InfoWindow;
            infoWindow[ind].setContent('<b>' + val.city + '</b>');
            infoWindow[ind].setPosition({lat: val.polygonProps.paths[0].lat, lng: val.polygonProps.paths[0].lng});
            infoWindow[ind].setMap(null);

            google.maps.event.addListener(cityZone[ind], 'click', function (event) {
                infoWindow[this.ind].setMap(map);
            });
        });

        var cityZone = [];
        var infoWindow = [];

        $.each(citiesArr, function (ind, val) {
            val = val.cities;
            val.polygonProps.ind = ind;
            cityZone[ind] = new google.maps.Polygon(val.polygonProps);
            cityZone[ind].setMap(map);

            infoWindow[ind] = new google.maps.InfoWindow;
            infoWindow[ind].setContent('<b>' + val.city + '</b>');
            infoWindow[ind].setPosition({lat: val.polygonProps.paths[0].lat, lng: val.polygonProps.paths[0].lng});
            infoWindow[ind].setMap(null);

            google.maps.event.addListener(cityZone[ind], 'click', function (event) {
                infoWindow[this.ind].setMap(map);
            });
        });

        $('#currency_symbol').focusout(function () {
            $('.postfixTag').text($('#currency_symbol').val());

        });

        $('#city_weightMetric').change(function(){
            $('.weightTag').text($('#city_weightMetric option:selected').val())
        });

        $('#city_distance_metrics').focusout(function () {
            $('.mileagePriceText').text($('#city_distance_metrics option:selected').val());

        });

        $('input#currency').keypress(function () {
            if ($(this).val().length >= 3) {
                $(this).val($(this).val().slice(0, 3));
                return false;
            }
        });
        $('#currencySymbolAbbPrefix').click(function () {

            $('#currencySymbolAbbPrefix').attr('class', 'btn btn-primary');
            $('#currencySymbolAbbSuffix').attr('class', 'btn btn-default');
        })
        $('#currencySymbolAbbSuffix').click(function () {

            $('#currencySymbolAbbSuffix').attr('class', 'btn btn-primary');
            $('#currencySymbolAbbPrefix').attr('class', 'btn btn-default');
        })
    });



    $(function ()
    {
        var validator = $('#form_addNewCity').validate({

            submitHandler: function (form) {
             

                if ($('#currency').val().length != 3) {
                    swal("", 'Currency should be 3 character long', "error");
                } else if (polygonProps == null && $('#city_zone_prop').val() == '') {
                    swal("", 'Please Provide zone for city', "error");
                } else if ($('#city_zone_prop').val() == '' && polygonProps.getPath().getLength() < 4) {
                    swal("", 'Please provide zone for city', "error");
                } else {
                  

                    var len = polygonProps.getPath().getLength();
                    var zoneProp = [];
                    var zonePath = [];
                    for (var i = 0; i < len; i++) {
                        zoneProp.push([polygonProps.getPath().getAt(i).lng(), polygonProps.getPath().getAt(i).lat()]);
                        zonePath.push({
                            "lat": polygonProps.getPath().getAt(i).lat(),
                            "lng": polygonProps.getPath().getAt(i).lng()
                        });
                    }
                    zoneProp.push(zoneProp[0]);
                    zoneProp = {
                        "type": "Polygon",
                        "coordinates": [zoneProp]
                    };
                    var cl = "#" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0);
                    zonePath = {
                        "strokeColor": cl,
                        "strokeOpacity": 0.2,
                        "strokeWeight": 2,
                        "fillColor": cl,
                        "fillOpacity": 0.35,
                        "draggable": false,
                        "editable": false,
                        "paths": zonePath
                    };
                    var newpolyProp = new google.maps.Polygon(zonePath);
                    var overlapFlag = true;
                    $.each(citiesArr, function (ind, val) {
                        val = val.cities;
                        var oldpolyProp = new google.maps.Polygon(val.polygonProps);
                        var wkt = UseWicketToGoFromGooglePolysToWKT(newpolyProp, oldpolyProp);
                        if (UseJstsToTestForIntersection(wkt[0], wkt[1])) {
                            $('#btnResetZone').trigger('click');
                            swal("", 'Do not Overlap Existing Zone.', "warning");
                            overlapFlag = false;
                        }
                    });
                    
                    
                    if (overlapFlag) {
                        $('#city_zone_prop').val(JSON.stringify(zoneProp));
                        $('#city_zone_path').val(JSON.stringify(zonePath));
                     
                        
                        var softLimitDriver=parseFloat($('#softLimitForDriver').val());
                        var hardLimitDriver=parseFloat($('#hardLimitForDriver').val());
                        var softLimitCustomer=parseFloat($('#softLimitForCustomer').val());
                        var hardLimitCustomer=parseFloat($('#hardLimitForCustomer').val());

                        if(hardLimitDriver>softLimitDriver){
                            $('#hardLimitForDriverErr').text('Hard limit should be less than soft limit');
                        }else if(hardLimitCustomer>softLimitCustomer){
                            $('#hardLimitForCustomerErr').text('Hard limit should be less than soft limit');
                        }else{         
                            $('#btnSubmit').prop("disabled", true);                       
                                $.ajax({
                                    url: '<?php echo base_url(); ?>index.php?/city/city_create',
                                    type: 'POST',
                                    dataType: "JSON",
                                    data: $(form).serialize(),

                                    success: function (response) {
                                        console.log(response);
                                    if (response.flag == 0) {
                                        swal({
                                            title: "Success",
                                            text: 'Successfully added...',
                                            type: "success",
                                            showCancelButton: false,
                                            confirmButtonText: "OK",
                                            showLoaderOnConfirm: true

                                        }, function () {
                                            $('#btnSubmit').prop("disabled",false);
                                            window.location.href = "<?= base_url() ?>index.php?/city";
                                        });

                                    } else if (response.flag == 2) {
                                        swal("", response.msg, "error");
                                    }
                                    },
                                    error: function (jqXHR, status, err) {
                                        swal("", 'Something Went Wrong', "error");
                                    }
                                });
                        }
                        
                        

                      

                    }
                     
                }
                return false;
            }
        });
    });
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
     


        //cool
     

}

</script>
<div class="page-content-wrapper">
    <div class="content">
        <div class="container-fluid container-fixed-lg">
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo base_url('index.php?/city') ?>"><?php echo $this->lang->line('heading_city'); ?></a>
                </li>
                <li>
                    <a href="#" class="active"><?php echo $this->lang->line('heading_add'); ?></a>
                </li>
            </ul>
            <div class="container-md-height m-b-20">
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs nav-tabs-simple bg-white" role="tablist" data-init-reponsive-tabs="collapse">
                            <!--                            <li class="active">
                                                            <a href="#lan_grp" data-toggle="tab" role="tab" aria-expanded="true">City Create</a>
                                                        </li>-->
                        </ul>
                    </div>
                    <div class="panel-body no-padding">
                        <form action="" id="form_addNewCity" class="form-horizontal" role="form" method="post">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_city'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-10">
                                    <input type="text" name="fdata[city]" id="city_name" placeholder="Enter City Name" class="form-control" required>

                                    <input type="hidden" name="fdata[timeZoneId]" id="timeZoneId">
                                    <div id="cityError"> <span style="color:red;"><strong>Enter Valid City</strong></span></div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_state'); ?></span>
                                <div class="col-sm-10">
                                    <input type="text" disabled="" id="city_state_name" placeholder="State" class="form-control" required>
                                    <input type="hidden" name="fdata[state]" id="city_state_name_hidden">
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_coutry'); ?></span>
                                <div class="col-sm-10">
                                    <input type="text" disabled="" id="city_country_name" placeholder="Country" class="form-control" required>
                                    <input type="hidden" name="fdata[country]" id="city_country_name_hidden" class="form-control">
                                </div>
                            </div>
                            <input type="hidden" id="shortCountryCode" name="fdata[shortCountryCode]">
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_coutry_short_code'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-10">
                                    <input type="text" name="fdata[currency]" id="currency" placeholder="Enter Currency Short Code" class="form-control" required>
                                    <div class="alert alert-warning">
                                        <strong><?php echo $this->lang->line('lable_currency_alert'); ?></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_currency_symbol'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-10">
                                    <input type="text" name="fdata[currency_symbol]" id="currency_symbol" placeholder="Enter Currency Symbol" class="form-control required">
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_currency_symbol_abbr'); ?></span>
                                <div class="col-sm-10">
                                    <div id="gender" class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default" id="currencySymbolAbbPrefix" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="fdata[currenct_abbr]" value="1" checked> Prefix
                                        </label>
                                        <label class="btn btn-primary" id="currencySymbolAbbSuffix" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="fdata[currenct_abbr]" value="2"> Suffix
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_distance_metric'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-10">
                                    <select name="fdata[distance_metrics]" id="city_distance_metrics" class="form-control" required>
                                        <option value="" selected disabled><?php echo $this->lang->line('lable_select_distance_metric'); ?></option>
                                        <option value="KM"><?php echo $this->lang->line('lable_km'); ?></option>
                                        <option value="Miles"><?php echo $this->lang->line('lable_miles'); ?></option>
                                        <option value="Yards"><?php echo $this->lang->line('lable_yards'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Temperature'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-10">
                                    <select name="fdata[temperature]" id="city_temperature" class="form-control" required>
                                        <option value="" selected disabled><?php echo $this->lang->line('lable_select_temperature'); ?></option>
                                        <option value="celcius"><?php echo $this->lang->line('lable_celcius'); ?></option>
                                        <option value="farenheit"><?php echo $this->lang->line('lable_farenheit'); ?></option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_height'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-10">
                                    <select name="fdata[height]" id="city_height" class="form-control" required>
                                        <option value="" selected disabled><?php echo $this->lang->line('lable_select_height'); ?></option>
                                        <option value="feet"><?php echo $this->lang->line('lable_feet'); ?></option>
                                        <option value="inches"><?php echo $this->lang->line('lable_inches'); ?></option>
                                        <option value="centimeter"><?php echo $this->lang->line('lable_centimeter'); ?></option>
                                        <option value="millimeter"><?php echo $this->lang->line('lable_millimeter'); ?></option>
                                        <option value="meter"><?php echo $this->lang->line('lable_meter'); ?></option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_width'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-10">
                                    <select name="fdata[width]" id="city_width" class="form-control" required>
                                        <option value="" selected disabled><?php echo $this->lang->line('lable_select_width'); ?></option>
                                        <option value="feet"><?php echo $this->lang->line('lable_feet'); ?></option>
                                        <option value="inches"><?php echo $this->lang->line('lable_inches'); ?></option>
                                        <option value="centimeter"><?php echo $this->lang->line('lable_centimeter'); ?></option>
                                        <option value="millimeter"><?php echo $this->lang->line('lable_millimeter'); ?></option>
                                        <option value="meter"><?php echo $this->lang->line('lable_meter'); ?></option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_length'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-10">
                                    <select name="fdata[length]" id="city_length" class="form-control" required>
                                        <option value="" selected disabled><?php echo $this->lang->line('lable_select_length'); ?></option>
                                        <option value="feet"><?php echo $this->lang->line('lable_feet'); ?></option>
                                        <option value="inches"><?php echo $this->lang->line('lable_inches'); ?></option>
                                        <option value="centimeter"><?php echo $this->lang->line('lable_centimeter'); ?></option>
                                        <option value="millimeter"><?php echo $this->lang->line('lable_millimeter'); ?></option>
                                        <option value="meter"><?php echo $this->lang->line('lable_meter'); ?></option>

                                    </select>
                                </div>
                            </div> -->
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_weight_metric'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-10">
                                    <select name="fdata[weightMetric]" id="city_weightMetric" class="form-control" required>
                                        <option value="" selected disabled><?php echo $this->lang->line('lable_select_weight_metric'); ?></option>
                                        <option value="KG"><?php echo $this->lang->line('lable_KG'); ?></option>
                                        <option value="lb"><?php echo $this->lang->line('lable_Pounds'); ?></option>

                                    </select>
                                </div>
                            </div>


                            <div class="form-group required">
                                <span class="col-sm-2 control-label"><?php echo $this->lang->line('label_payment_gateways'); ?></span>
                                <div class="col-sm-6">

                                    <div class="multiselect">
                                        <div class="selectBox" onclick="showCheckboxes()">
                                            <select class="form-control" name="paymentGatewaysSelect">
                                                <option><?php echo $this->lang->line('label_select'); ?></option>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>
                                        <div id="checkboxes"> 
                                            <?php
                                            foreach ($paymentGateways as $payment) {
                                                ?>
                                                <label for="<?php echo $payment; ?>">
                                                    <input type="checkbox" class="checkbox1" name="fdata[payment][]" id="<?php echo strtoupper($payment['gatewayName']); ?>"  value="<?php echo $payment['gatewayName'] . '_' . $payment['_id']['$oid']; ?>"/><?php echo strtoupper($payment['gatewayName']); ?>

                                                </label>
                                                <?php
                                            }
                                            ?>

                                        </div>

                                    </div>
                                    <label id="goodType-error" class="error" style="display:none">This field is required.</label>
                                </div>
                                <div class="col-sm-3 error-box" id="goodTypeErr"></div>

                            </div>

                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('Type_of_account'); ?></span>
                                <div class="col-sm-2">
                                <input type="radio" <?php echo $yes;?>  name="fdata[typeOfAccount]" value=1 <?php echo ($data['typeOfAccount'] == '1') ? "CHECKED" : " " ?> id="iban">
                                    <span class=' control-label'><?php echo $this->lang->line('iban'); ?></span>
                                    
                                </div>
                                <div class="col-sm-2">
                                <input type="radio" <?php echo $no;?>  name="fdata[typeOfAccount]" value=2 <?php echo ($data['typeOfAccount'] == '2') ? "CHECKED" : " " ?> id="accountNumber">
                                    <span class=' control-label'><?php echo $this->lang->line('account_number'); ?></span>
                                  
                                </div>
                            </div>

                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('stripe_enable'); ?></span>
                                <div class="col-sm-2">
                                <input type="radio" <?php echo $yes;?>  name="fdata[isStripeEnabled]" value=1 <?php echo ($data['isStripeEnabled'] == '1') ? "CHECKED" : " " ?> id="isStripeEnabled">
                                    <span class=' control-label'><?php echo $this->lang->line('yes'); ?></span>
                                    
                                </div>
                                <div class="col-sm-2">
                                <input type="radio" <?php echo $no;?>  name="fdata[isStripeEnabled]" value=0 <?php echo ($data['isStripeEnabled'] == '0') ? "CHECKED" : " " ?> id="isStripeEnabled">
                                    <span class=' control-label'><?php echo $this->lang->line('no'); ?></span>
                                  
                                </div>
                            </div>

                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('ideal_enable'); ?></span>
                                <div class="col-sm-2">
                                <input type="radio" <?php echo $yes;?>  name="fdata[isIdeal]" value=1 <?php echo ($data['isIdeal'] == '1') ? "CHECKED" : " " ?> id="isIdeal">
                                    <span class=' control-label'><?php echo $this->lang->line('yes'); ?></span>
                                    
                                </div>
                                <div class="col-sm-2">
                                <input type="radio" <?php echo $no;?>  name="fdata[isIdeal]" value=0 <?php echo ($data['isIdeal'] == '0') ? "CHECKED" : " " ?> id="isIdeal">
                                    <span class=' control-label'><?php echo $this->lang->line('no'); ?></span>
                                  
                                </div>
                            </div>

                            <div class="form-group required">
                                <span class="col-sm-2 control-label"><?php echo $this->lang->line('label_tax'); ?></span>
                                <div class="col-sm-2">

                                    <div class="multiselect">
                                        <div class="selectBox" onclick="showCheckboxesForTax()">
                                            <select class="form-control" name="taxSelect">
                                                <option><?php echo $this->lang->line('label_select'); ?></option>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>
                                        <div id="checkboxesTax"> 
                                            <?php
                                            foreach ($taxes as $tax) {
                                                ?>
                                                <label for="<?php echo $tax; ?>">
                                                    <input type="checkbox" class="checkboxTax" name="fdata[taxes][]" id="<?php echo $tax['_id']['$oid'] . '_' . $tax['taxName'][0]; ?>"  dataId="<?php echo $tax['_id']['$oid']; ?>" dataName="<?php echo strtoupper($tax['taxName'][0]); ?>" value="<?php echo implode($tax['taxName'], ',') . '_' . $tax['_id']['$oid'] . '_' . $tax['taxValue']; ?>"/><?php echo strtoupper($tax['taxName'][0]); ?><br/>

                                                </label>
                                                <?php
                                            }
                                            ?>

                                        </div>

                                    </div>
                                    <label id="tax-error" class="error" style="display:none">This field is required.</label>
                                </div>
                                <div class="col-sm-2">
                                    <?php
                                    foreach ($taxes as $tax) {
                                        ?>
                                        <div id="taxTextBoxes_<?php echo $tax['taxName'][0]; ?>" class="<?php echo $tax['_id']['$oid']; ?> col-sm-12"></div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-3 error-box" id="taxErr"></div>

                            </div>
                            <br/>
                            <div class="form-group">
                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('label_universal_wallet_limit'); ?></label>
                            </div>
                            <div class="form-group">
                                <label style="margin-left: -41px;" for="" class="control-label col-md-2"><p style="color:#8356a9"><?php echo $this->lang->line('label_driver'); ?></p>
                                </label>
                            </div>


                            <div class="form-group driverWallet required">
                                <label for="" class="control-label col-md-2"><?php echo $this->lang->line('label_soft_limit'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-3">
                                    <!-- <span class="span-currencySymbol" style="display:none;"></span> -->
                                    <span class="abs_text"><b class="postfixTag"></b></span>
                                    <input type="text" class="form-control autonumeric" id="softLimitForDriver" name="fdata[driverWalletLimits][softLimitForDriver]" placeholder=""  required>
                                </div>
                                <div class="col-sm-3 error-box" id="softLimitForDriverErr"></div>
                            </div>

                            <div class="form-group driverWallet required">
                                <label for="" class="control-label col-md-2"><?php echo $this->lang->line('label_hard_limit'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-3">
                                    <!-- <span class="span-currencySymbol" style="display:none;"></span> -->
                                    <span class="abs_text"><b class="postfixTag"></b></span>
                                    <input type="text" class="form-control autonumeric" id="hardLimitForDriver" name="fdata[driverWalletLimits][hardLimitForDriver]" placeholder="" required>
                                </div>
                                <div class="col-sm-3 error-box" id="hardLimitForDriverErr" style="color: crimson;"></div>
                            </div>


                             <div class="form-group">
                                <label style="margin-left: -68px;" for="" class="control-label col-md-2"><p style="color:#8356a9"><?php echo $this->lang->line('label_customer'); ?></p>
                                </label>
                            </div>


                            <div class="form-group driverWallet required">
                                <label for="" class="control-label col-md-2"><?php echo $this->lang->line('label_soft_limit'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-3">
                                    <!-- <span class="span-currencySymbol" style="display:none;"></span> -->
                                    <span class="abs_text"><b class="postfixTag"></b></span>
                                    <input type="text" class="form-control autonumeric" id="softLimitForCustomer" name="fdata[customerWalletLimits][softLimitForCustomer]" placeholder=""  required>
                                </div>
                                <div class="col-sm-3 error-box" id="softLimitForCustomerErr"  style="color: crimson;"></div>
                            </div>

                            <div class="form-group driverWallet required">
                                <label for="" class="control-label col-md-2"><?php echo $this->lang->line('label_hard_limit'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-3">
                                    <!-- <span class="span-currencySymbol" style="display:none;"></span> -->
                                    <span class="abs_text"><b class="postfixTag"></b></span>
                                    <input type="text" class="form-control autonumeric" id="hardLimitForCustomer" name="fdata[customerWalletLimits][hardLimitForCustomer]" placeholder="" required>
                                </div>
                                <div class="col-sm-3 error-box" id="hardLimitForCustomerErr" style="color: crimson;"></div>
                            </div>

                            <br/><br/><hr/>
                            <!-- <div class="form-group">
                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('LAUNDRY_BY_WEIGHT_FEE'); ?></label>
                            </div>

                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('Lower_weight_limit'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="weightTag"></b></span>
                                    <input type="text" value="0" name="fdata[lowerWeightLimit]" id="Lower_weight_limit" placeholder="" onkeypress="return isNumberKey(event)" class="form-control">
                                </div>
                            </div>

                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('Upper_weight_limit'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="weightTag"></b></span>
                                    <input type="text" value="0" name="fdata[upperWeightLimit]" id="Upper_weight_limit" placeholder="" onkeypress="return isNumberKey(event)" class="form-control">
                                </div>
                            </div>

                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('Price'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"></b></span>
                                    <input type="text" value="0" name="fdata[Price]" id="Price" placeholder="" onkeypress="return isNumberKey(event)" class="form-control ">
                                </div>
                            </div>

                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('Extra_Fee_forexpress_delivery'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"></b></span>
                                    <input type="text" value="0" name="fdata[extraFeeForExpressDelivery]" id="Extra_Fee_forexpress_delivery" placeholder="" onkeypress="return isNumberKey(event)" class="form-control">
                                </div>
                            </div>

                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('Taxes_applicable'); ?></span>
                                <div class="col-sm-4">
                                <input type="radio" name="fdata[taxesApplicable]" value=1 id="Taxes_applicable">
                                    <span class=' control-label'><?php echo $this->lang->line('Yes'); ?></span>
                                   
                                </div>
                                <div class="col-sm-4">
                                <input type="radio" selected="selected" name="fdata[taxesApplicable]" value=2 id="Taxes_applicable2">
                                    <span class='control-label'><?php echo $this->lang->line('No'); ?></span>
                                  
                                </div>
                            </div>


                            <br/>
                            <br/>
                            <hr/> -->

                            <div class="form-group">
                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('MILEAGE_SETTING'); ?></label>
                            </div>

                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_baseFare'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"></b></span>
                                    <input type="text" name="fdata[baseFare]" id="baseFare" placeholder="Enter Base Fare" onkeypress="return isNumberKey(event)" class="form-control required">
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Mileage_Price'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"></b></span>
                                    <input type="text" name="fdata[mileagePrice]" id="mileagePrice" placeholder="Enter Mileage Price" class="form-control required" onkeypress="return isNumberKey(event)">
                                </div>
                                <div class="col-sm-5">
                                    <span class="abs_textLeft"><b>After</b></span>
                                    <input type="text" name="fdata[mileagePriceAfterMinutes]" id="mileagePrice" value="0" style="padding-left: 74px;" onkeypress="return isNumberKey(event)" class="form-control required">
                                    <span class="abs_text mileagePriceText"><b></b></span>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_timeFee'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"></b></span>
                                    <input onkeypress="return isNumberKey(event)" type="text" name="fdata[timeFee]" id="timeFee" placeholder="Enter Time Fee" class="form-control required">
                                </div>
                                <div class="col-sm-5">
                                    <span class="abs_textLeft"><b>After</b></span>
                                    <input onkeypress="return isNumberKey(event)" type="text" name="fdata[timeFeeAfterMinutes]" style="padding-left: 74px;" value="0" id="timeFee" placeholder="Enter time fare" class="form-control required">
                                    <span class="abs_text"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                </div>
                            </div>
                            <!--                            <div class="form-group required">
                                                            <span class='col-sm-2 control-label'><?php //echo $this->lang->line('lable_waitingFee');  ?></span>
                                                            <div class="col-sm-5">
                                                                <span class="abs_text"><b class="postfixTag"></b></span>
                                                                <input onkeypress="return isNumberKey(event)" type="text" name="fdata[waitingFee]" id="waitingFee" placeholder="Enter Waiting Fee" class="form-control required">
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <span class="abs_textLeft"><b>After</b></span>
                                                                <input onkeypress="return isNumberKey(event)" type="text" value="0" name="fdata[waitingFeeAfterMinutes]" style="padding-left: 74px;" id="waitingFee" class="form-control required">
                                                                <span class="abs_text"><b><?php // echo $this->lang->line('Minutes');  ?></b></span>
                                                            </div>
                                                        </div>-->
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_minimumFare'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"></b></span>
                                    <input onkeypress="return isNumberKey(event)" type="text" name="fdata[minimumFare]" id="minimumFare" placeholder="Enter Minimum Fare" class="form-control required">
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_On-Demand Bookings_Cancellation_Fee'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"></b></span>
                                    <input onkeypress="return isNumberKey(event)" type="text" name="fdata[onDemandBookingsCancellationFee]" id="onDemandBookingsCancellationFee" placeholder="Enter Now Booking Cancellation Fee" class="form-control required">
                                </div>
                                <div class="col-sm-5">
                                    <span class="abs_textLeft"><b>After</b></span>
                                    <input onkeypress="return isNumberKey(event)" type="text" style="padding-left: 74px;" value="0" name="fdata[onDemandBookingsCancellationFeeAfterMinutes]" id="onDemandBookingsCancellationFee" class="form-control required">
                                    <span class="abs_text"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_ScheduledBookingsCancellationFee'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"></b></span>
                                    <input onkeypress="return isNumberKey(event)" type="text" name="fdata[ScheduledBookingsCancellationFee]" id="ScheduledBookingsCancellationFee" placeholder="Enter Scheduled Booking Cancellation Fee" class="form-control required">
                                </div>
                                <div class="col-sm-5">

                                    <span class="abs_textLeft"><b>Before</b></span>
                                    <input onkeypress="return isNumberKey(event)" type="text" style="padding-left: 74px;" value="0" name="fdata[ScheduledBookingsCancellationFeeAfterMinutes]" id="ScheduledBookingsCancellationFee"  class="form-control required">
                                    <span class="abs_text"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                </div>
                            </div>
                            <div class="form-group required" aria-required="true">
                                <?php $data['convenienceType'] =  (isset($data['convenienceType']) == '1') ? $data['convenienceType'] : 1 ?>
                                <span class="col-sm-2 control-label"><?php echo $this->lang->line('lable_convenienceType'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-2">
                                    <input type="radio" name="fdata[convenienceType]" value="1" id="convenienceType"  <?php echo ($data['convenienceType'] == 1) ? "CHECKED" : " " ?> >
                                    <span class=" control-label">Fixed</span>
                                </div>
                                <div class="col-sm-2">
                                    <input type="radio" name="fdata[convenienceType]" value="2" id="convenienceType"  <?php echo ($data['convenienceType'] == 2) ? "CHECKED" : " " ?> >
                                    <span class=" control-label">Percentage</span>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_convenienceFee'); ?><span class="mandatory">*</span></span>
                                <div class="col-sm-5">
                                    <!-- <span class="abs_text"><b class="postfixTag"></b></span> -->
                                    <input onkeypress="return isNumberKey(event)" type="text" name="fdata[convenienceFee]" id="convenienceFee" placeholder="Enter Convenience Fee" class="form-control required">
                                </div>
                            </div>
                            <br/>
                            <br/>
                            <br/>
                            <hr/>
                            <div class="form-group required">
                                <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_city'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-10">
                                    <div id="city_zone_map" style="height:400px;"></div>
                                    <input type="hidden" name="fdata[location]" id="city_zone_prop">
                                    <input type="hidden" name="fdata[path]" id="city_zone_path">
                                    <input type="hidden" name="fdata[latitude]" id="city_lat">
                                    <input type="hidden" name="fdata[longitude]" id="city_long">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 m-t-10 sm-m-t-10 pull-right text-right">
                                    <button type='submit' class="btn btn-primary" id='btnSubmit'><?php echo $this->lang->line('label_add_city'); ?></button>
                                    <button type='button' class="btn btn-primary" id='btnResetZone' style="display: none;"><?php echo $this->lang->line('label_clear_zone'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>                                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade stick-up" id="cityExistsPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title"></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorbox" style="text-align:center"><?php echo "Exists"; ?></div>
                </div>
            </div>
            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('button_cancel'); ?></button>
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="activateCity"><?php echo 'Activate'; ?></button>
                     <!-- <button type="button" class="btn btn-success pull-right" id="activateCity" >Activate</button> -->
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>