<link href="application/views/city/styles.css" rel="stylesheet" type="text/css">
<!--<script src="//maps.googleapis.com/maps/api/js?key=<?= GOOGLE_MAP_API_KEY ?>&v=3&libraries=drawing,places"></script>-->
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCAnpL4IiJt_jeFspg16XQshxmbnl-zGbU&v=3&libraries=drawing,places"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/javascript.util.min.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/jsts.min.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/wicket.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/wicket-gmap3.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="//admin.uberforall.com/supportFiles/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="//admin.uberforall.com/supportFiles/sweetalert.css">
<?php
if ($data['mileageMetricText'] == "KM") {
    $km = "selected";
} else if ($data['mileageMetricText'] == "Miles") {
    $miles = "selected";
} else if ($data['mileageMetricText'] == "Yards") {
    $Yards = "selected";
}

if ($data['weightMetricText'] == "KG") {
    $kg = "selected";
} else {
    $lb = "selected";
}

if ($data['laundry']['taxesApplicable'] == true) {
    $yes = "selected=selected";
} else {
    $no = "selected=selected";
}

foreach ($data['taxDetails'] as $value) {
    $arr2[] = $value['name']['en'];
}
foreach ($data['paymentDetails'] as $key) {
    $arr1[] = $key['paymentName']['en'];
}


?>
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
</style>

<script>


    var idNum = 0;
    var expanded = false;
    var expanded1 = false;
    var walletEnDis;


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
    var walletEnDis;
    var rectangle = null;
    var cities = JSON.parse('<?php echo addslashes(json_encode($allcities)); ?>');
//    console.log("cities"+cities);
    $(document).ready(function () {
        showCheckboxes();
        showCheckboxesForTax();
        $('#city_distance_metrics').val('<?= $data['mileageMetricText'] ?>');
        $('#city_temperature').val('<?= $data['temperature'] ?>');
        $('#city_height').val('<?= $data['height'] ?>');
        $('#city_width').val('<?= $data['width'] ?>');
        $('#city_length').val('<?= $data['length'] ?>');


         $('#btnResetZone').click(function () { 
          console.log('reset');
            rectangle.setMap(null);
            drawingManager.setMap(map);
            polygonProps = null;
            $('#btnResetZone').hide();
        });
        


//        $('.checkboxTax').change(function () {
//            if ($(this).attr("checked")) {
//                html = '<span class=" abs_textLeft1 ' + $(this).attr('dataName') + '">' + $(this).attr('dataName') + '</span><span class="abs_text1 ' + $(this).attr('dataName') + '"><b>%</b></span><input type="text" class="form-control col-sm-2" onkeypress="return isNumberKey(event)" maxlength="3"  style="padding-left:75px;margin-top:10px;" name="fdata[taxValues][]"  id="' + $(this).attr('dataId') + '"/>'
//                $('.' + $(this).attr('dataId')).append(html);
//            } else {
//                $('#' + $(this).attr('dataId')).remove();
//
//                $('.' + $(this).attr('dataName')).remove();
//            }
//
//
//        });
 var zone = <?= json_encode($data['polygonProps']) ?>;
        var zone_path = [];
        var bounds = new google.maps.LatLngBounds();
        $.each(zone.paths, function (key, val) {
            var ltlg = new google.maps.LatLng(val.lat, val.lng);
            bounds.extend(ltlg);
            zone_path.push(ltlg);
        });
        var latlng = new google.maps.LatLng(12.972442010578353, 77.5909423828125);
        map = new google.maps.Map(document.getElementById('city_zone_map'), {
            center: latlng,
            zoom: 10
        });

        google.maps.event.addListenerOnce(map, 'idle', function () {
            google.maps.event.trigger(map, 'resize');
        });

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
        drawingManager.setMap(null);
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
        
        

<?php
//$x = 0;
//foreach ($taxes as $tax) {
//    $checked = '';
//    if (in_array(strtoupper($tax['taxName'][0]), $arr)) {
//        $checked = 'checked';
//        ?>
//
//                html = '<span class="abs_textLeft1 ////<?php //echo strtoupper($tax['taxName'][0]); ?>"><?php //echo strtoupper($tax['taxName'][0]); ?></span><span class="abs_text1 <?php// echo strtoupper($tax['taxName'][0]); ?>"><b>%</b></span><input type="text" onkeypress="return isNumberKey(event)" maxlength="3" class="form-control col-sm-2" style="padding-left:75px;margin-top:10px;" name="fdata[taxValues][]" value="<?php// echo $arr1[$x]; ?>" id="<?php// echo $tax['_id']['$oid']; ?>"/>'
//                $('.//<?php //echo $tax['_id']['$oid']; ?>').append(html);
        //                                               $('.taxTextBoxes').append(html);
        //<?php
//        $x++;
//    }
//}
?>


        var options = {
            types: ['(cities)']
        };

        var input = document.getElementById('city_name');
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            var country = "";
            var state = "";
            for (var i = 0; i < place.address_components.length; i++) {
                for (var j = 0; j < place.address_components[i].types.length; j++) {
                    if (place.address_components[i].types[j] == "country")
                        country = place.address_components[i].long_name;
                    if (place.address_components[i].types[j] == "administrative_area_level_1")
                        state = place.address_components[i].long_name;
                }
            }
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(10);
            }
            $('#city_name').val(place.name);
            $('#city_state_name').val(state);
            $('#city_state_name_hidden').val(state);
            $('#city_country_name').val(country);
            $('#city_country_name_hidden').val(country);
            var lat = parseFloat(place.geometry.location.lat()).toFixed(6);
            var lng = parseFloat(place.geometry.location.lng()).toFixed(6);
            $('#city_lat').val("<?php echo $data['coordinates']['latitude']; ?>");
            $('#city_long').val("<?php echo $data['coordinates']['longitude']; ?>");
            
        });
        
        

 rectangle = new google.maps.Polygon(zone);
        rectangle.setMap(map);

        map.fitBounds(bounds);

        google.maps.event.addListener(rectangle, 'click', function (event) {
            editCityZone(this);
        });
        $('#btnResetZone').show();

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
        var currencySymAbbr = "<?php echo $data['abbrevation'] ?>";
        if (currencySymAbbr == "1")
        {
            $('#currencySymbolAbbPrefix').attr('class', 'btn btn-primary');
            $('#currencySymbolAbbSuffix').attr('class', 'btn btn-default');
        } else {
            $('#currencySymbolAbbSuffix').attr('class', 'btn btn-primary');
            $('#currencySymbolAbbPrefix').attr('class', 'btn btn-default');
        }

    });
    function editCityZone(polygon) {
        $('#city_zone_prop').val('');
        $('#city_zone_path').val('');
        polygon.setEditable(true);
        polygon.setDraggable(true);
        polygonProps = polygon;

        $('#btnResetZone').show();

        google.maps.event.addListener(polygon.getPath(), 'set_at', function () {
            polygonProps = polygon;
        });

        google.maps.event.addListener(polygon.getPath(), 'insert_at', function () {
            polygonProps = polygon;
        });

        google.maps.event.addListener(polygon, "mouseout", function () {
            polygonProps = polygon;
        });
    }

    $(function ()
    {

        var validator = $('#form_editCity').validate({
            submitHandler: function (form) {

                if ($('#currency').val().length != 3) {
                    swal("", 'Currency short code should be 3 character long', "error");
                }  
                // else if ($('#hardLimitForDriver').val()< $('#softLimitForDriver').val()) {
                //     swal("", 'Driver hard limit should not be less than soft limit', "error");
                // } 
                 else if (polygonProps == null && $('#city_zone_prop').val() == '') {
                    swal("", 'Please Provide zone for city', "error");
                } else if ($('#city_zone_prop').val() == '' && polygonProps.getPath().getLength() < 4) {
                    swal("", 'Please Provide zone for city', "error");
                } else {
                    var overlapFlag = true;
                    if ($('#city_zone_prop').val() == '') {
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

                        $('#city_zone_prop').val(JSON.stringify(zonePath));
                        $('#city_zone_path').val(JSON.stringify(zoneProp));
                    }
                    if (overlapFlag) {

                        
                        var softLimitDriver=parseFloat($('#softLimitForDriver').val());
                        var hardLimitDriver=parseFloat($('#hardLimitForDriver').val());
                        var softLimitCustomer=parseFloat($('#softLimitForCustomer').val());
                        var hardLimitCustomer=parseFloat($('#hardLimitForCustomer').val());

                        if(hardLimitDriver>softLimitDriver){
                            $('#hardLimitForDriverErr').text('Hard limit should be less than soft limit');
                        }else if(hardLimitCustomer>softLimitCustomer){
                            $('#hardLimitForCustomerErr').text('Hard limit should be less than soft limit');
                        }else{ $.ajax({
                            url: '<?= base_url() ?>index.php?/city/city_update',
                            type: 'POST',
                            dataType: "JSON",
                            data: $(form).serialize(),
                            timeout: 30000,
                            cache: false,
                            processData: false,
                            success: function (response, status, jqXHR) {
                                if (response.flag == 0) {
                                    window.location.href = "<?= base_url() ?>index.php?/city";
                                } else {
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
<div class="page-content-wrapper">
    <div class="content">
        <div class="container-fluid container-fixed-lg">
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo base_url('index.php?/city') ?>"><?php echo $this->lang->line('heading_city'); ?></a>
                </li>
                <li>
                    <a href="#" class="active">EDIT - <?= $data['cityName'] ?></a>
                </li>
            </ul>
            <div class="container-md-height m-b-20">
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs nav-tabs-simple bg-white" role="tablist" data-init-reponsive-tabs="collapse">

                        </ul>
                    </div>

                    <div class="panel-body no-padding">
                        <form action="" id="form_editCity" class="form-horizontal" role="form" method="post">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_city'); ?></span>
                                <div class="col-sm-10">
                                    <input type="text" disabled="" name="fdata[city]" id="city_name" placeholder="Enter City Name" class="form-control" required value="<?= $data['cityName'] ?>">
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_state'); ?></span>
                                <div class="col-sm-10">
                                    <input type="text" disabled="" id="city_state_name" placeholder="State" class="form-control" required value="<?= $data['state'] ?>">
                                    <input type="hidden" name="fdata[state]" id="city_state_name_hidden" value="<?= $data['state'] ?>">
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_coutry'); ?></span>
                                <div class="col-sm-10">
                                    <input type="text" disabled="" id="city_country_name" placeholder="Country" class="form-control" required value="<?= $data['country'] ?>">
                                    <input type="hidden" name="fdata[country]" id="city_country_name_hidden"  value="<?= $data['country'] ?>">
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_coutry_short_code'); ?></span>
                                <div class="col-sm-10">
                                    <input type="text" name="fdata[currency]" id="currency" placeholder="Enter Currency Short Code" class="form-control" required value="<?= $data['currency'] ?>">
                                    <div class="alert alert-warning">
                                        <strong>This currency will be used in payment gateways..!</strong>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_currency_symbol'); ?></span>
                                <div class="col-sm-10">
                                    <input type="text" name="fdata[currency_symbol]" id="currency_symbol" placeholder="Enter Currency Symbol" class="form-control required" value="<?= $data['currencySymbol'] ?>">
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_currency_symbol_abbr'); ?></span>
                                <div class="col-sm-10">
                                    <div id="gender" class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default" id="currencySymbolAbbPrefix" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="fdata[currenct_abbr]" value="1" <?= ($data['abbrevation'] == "1" || $data['currencyAbbr'] == "") ? "checked" : "" ?>> Prefix
                                        </label>
                                        <label class="btn btn-primary" id="currencySymbolAbbSuffix" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="fdata[currenct_abbr]" value="2" <?= ($data['abbrevation'] == "2") ? "checked" : "" ?>> Suffix
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_distance_metric'); ?></span>
                                <div class="col-sm-10">
                                    <select name="fdata[distance_metrics]" id="city_distance_metrics" class="form-control" required>
                                        <option value="" disabled><?php echo $this->lang->line('lable_select_distance_metric'); ?></option>
                                        <option <?php echo $km; ?> value="KM"><?php echo $this->lang->line('lable_km'); ?></option>
                                        <option <?php echo $miles; ?> value="Miles"><?php echo $this->lang->line('lable_miles'); ?></option>
                                        <option <?php echo $Yards; ?> value="Yards"><?php echo $this->lang->line('lable_yards'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Temperature'); ?></span>
                                <div class="col-sm-10">
                                    <select name="fdata[temperature]" id="city_temperature" class="form-control" required>
                                        <option value="" selected disabled><?php echo $this->lang->line('lable_select_temperature'); ?></option>
                                        <option <?php echo $celcius;?> value="celcius"><?php echo $this->lang->line('lable_celcius'); ?></option>
                                        <option <?php echo $farenheit;?> value="farenheit"><?php echo $this->lang->line('lable_farenheit'); ?></option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_height'); ?></span>
                                <div class="col-sm-10">
                                    <select name="fdata[height]" id="city_height" class="form-control" required>
                                        <option  value="" selected disabled><?php echo $this->lang->line('lable_select_height'); ?></option>
                                        <option <?php echo $feet1; ?> value="feet"><?php echo $this->lang->line('lable_feet'); ?></option>
                                        <option <?php echo $inches1; ?> value="inches"><?php echo $this->lang->line('lable_inches'); ?></option>
                                        <option <?php echo $centimeter1; ?> value="centimeter"><?php echo $this->lang->line('lable_centimeter'); ?></option>
                                        <option <?php echo $millimeter1; ?> value="millimeter"><?php echo $this->lang->line('lable_millimeter'); ?></option>
                                        <option <?php echo $meter1; ?> value="meter"><?php echo $this->lang->line('lable_meter'); ?></option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_width'); ?></span>
                                <div class="col-sm-10">
                                    <select name="fdata[width]" id="city_width" class="form-control" required>
                                        <option  value="" selected disabled><?php echo $this->lang->line('lable_select_width'); ?></option>
                                        <option <?php echo $feet2; ?> value="feet"><?php echo $this->lang->line('lable_feet'); ?></option>
                                        <option <?php echo $inches2; ?> value="inches"><?php echo $this->lang->line('lable_inches'); ?></option>
                                        <option <?php echo $centimeter2; ?> value="centimeter"><?php echo $this->lang->line('lable_centimeter'); ?></option>
                                        <option <?php echo $millimeter2; ?> value="millimeter"><?php echo $this->lang->line('lable_millimeter'); ?></option>
                                        <option <?php echo $meter2; ?> value="meter"><?php echo $this->lang->line('lable_meter'); ?></option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_length'); ?></span>
                                <div class="col-sm-10">
                                    <select name="fdata[length]" id="city_length" class="form-control" required>
                                        <option value="" selected disabled><?php echo $this->lang->line('lable_select_length'); ?></option>
                                        <option <?php echo $feet; ?> value="feet"><?php echo $this->lang->line('lable_feet'); ?></option>
                                        <option <?php echo $inches; ?> value="inches"><?php echo $this->lang->line('lable_inches'); ?></option>
                                        <option <?php echo $centimeter; ?> value="centimeter"><?php echo $this->lang->line('lable_centimeter'); ?></option>
                                        <option <?php echo $millimeter; ?> value="millimeter"><?php echo $this->lang->line('lable_millimeter'); ?></option>
                                        <option <?php echo $meter; ?> value="meter"><?php echo $this->lang->line('lable_meter'); ?></option>

                                    </select>
                                </div>
                            </div> -->
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_weight_metric'); ?></span>
                                <div class="col-sm-10">
                                    <select name="fdata[weightMetric]" id="city_weightMetric" class="form-control" required>
                                        <option value="" selected disabled><?php echo $this->lang->line('lable_select_weight_metric'); ?></option>
                                        <option <?php echo $kg; ?> value="KG"><?php echo $this->lang->line('lable_KG'); ?></option>
                                        <option <?php echo $lb; ?> value="lb"><?php echo $this->lang->line('lable_Pounds'); ?></option>

                                    </select>
                                </div>
                            </div>

                            <!-- cool -->
                            <div class="form-group">
                                <label for="address" class="col-sm-2">Payment Gateways</label>
                                <div class="col-sm-6">

                                    <div class="multiselect">
                                        <div class="selectBox" onclick="showCheckboxes()">
                                            <select class="form-control" name="paymentGatewaysSelect">
                                                <option>Select</option>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>
                                        <div id="checkboxes"> 
                                            <?php
                                            foreach ($paymentGateways as $payment) {
                                                $checked = '';
                                                if (in_array($payment['gatewayName'], $arr1))
                                                    $checked = 'checked';
                                                ?>
                                                <label for="<?php echo $payment; ?>">
                                                    <input type="checkbox" <?php echo $checked; ?> class="checkbox1" name="fdata[payment][]" id="<?php echo strtoupper($payment['gatewayName']) . '_' . $payment['_id']['$oid']; ?>"  value="<?php echo $payment['gatewayName'] . '_' . $payment['_id']['$oid']; ?>" /><?php echo strtoupper($payment['gatewayName']); ?>
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
                                                $checked = '';
                                                if (in_array($tax['taxName'][0], $arr2))
                                                    $checked = 'checked';
                                                ?>

                                                <label for="<?php echo $tax['taxName'][0]; ?>">
                                                    <input type="checkbox"  <?php echo $checked; ?> class="checkboxTax" name="fdata[taxes][]" id="<?php echo $tax['_id']['$oid'] . '_' . $tax['taxName'][0]; ?>"  dataId="<?php echo $tax['_id']['$oid']; ?>" dataName="<?php echo strtoupper($tax['taxName'][0]); ?>" value="<?php echo $tax['taxName'][0] . '_' . $tax['_id']['$oid']; ?>"/><?php echo strtoupper($tax['taxName'][0]); ?><br/>
                                                    <input type="hidden" name="fdata[taxId][]" id="<?php echo $tax['_id']['$oid'] . '_' . $tax['taxName'][0]; ?>"  value="<?php echo $tax['_id']['$oid']; ?>"/>

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
                                <label for="" style="margin-left: -41px;" class="control-label col-md-2"><p style="color:#8356a9"><?php echo $this->lang->line('label_driver'); ?></p>
                                </label>
                            </div>


                            <div class="form-group driverWallet required">
                                <label for="" class="control-label col-md-2"><?php echo $this->lang->line('label_soft_limit'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-3">
                                    <span class="span-currencySymbol" style="display:none;"></span>
                                    <input type="text" class="form-control autonumeric" id="softLimitForDriver" name="fdata[driverWalletLimits][softLimitForDriver]" placeholder="" value="<?= $data['driverWalletLimits']['softLimitForDriver']?>" required>
                                </div>
                                <div class="col-sm-3 error-box" id="softLimitForDriverErr"></div>
                            </div>

                            <div class="form-group driverWallet required">
                                <label for="" class="control-label col-md-2"><?php echo $this->lang->line('label_hard_limit'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-3">
                                    <span class="span-currencySymbol" style="display:none;"></span>
                                    <input type="text" class="form-control autonumeric" id="hardLimitForDriver" name="fdata[driverWalletLimits][hardLimitForDriver]" placeholder="" value="<?= $data['driverWalletLimits']['hardLimitForDriver']?>" required>
                                </div>
                                <div class="col-sm-3 error-box" id="hardLimitForDriverErr" style="color: crimson;"></div>
                            </div>


                            <div class="form-group">
                                <label for="" style="margin-left: -41px;" class="control-label col-md-2"><p style="color:#8356a9"><?php echo $this->lang->line('label_customer'); ?></p>
                                </label>
                            </div>


                            <div class="form-group driverWallet required">
                                <label for="" class="control-label col-md-2"><?php echo $this->lang->line('label_soft_limit'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-3">
                                    <span class="span-currencySymbol" style="display:none;"></span>
                                    <input type="text" class="form-control autonumeric" id="softLimitForCustomer" name="fdata[customerWalletLimits][softLimitForCustomer]" placeholder="" value="<?= $data['customerWalletLimits']['softLimitForCustomer']?>" required>
                                </div>
                                <div class="col-sm-3 error-box" id="softLimitForCustomerErr"></div>
                            </div>

                            <div class="form-group driverWallet required">
                                <label for="" class="control-label col-md-2"><?php echo $this->lang->line('label_hard_limit'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-3">
                                    <span class="span-currencySymbol" style="display:none;"></span>
                                    <input type="text" class="form-control autonumeric" id="hardLimitForCustomer" name="fdata[customerWalletLimits][hardLimitForCustomer]" placeholder="" value="<?= $data['customerWalletLimits']['hardLimitForCustomer']?>" required>
                                </div>
                                <div class="col-sm-3 error-box" id="hardLimitForCustomerErr" style="color: crimson;"></div>
                            </div>

                            <br/><br/><hr/>
                            <div class="form-group" style="display: none">
                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('LAUNDRY_BY_WEIGHT_FEE'); ?></label>
                            </div>

                            <div class="form-group required" style="display: none">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('Lower_weight_limit'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="weightTag"><?=$data['weightMetricText']?></b></span>
                                    <input type="text" value="<?= $data['laundry']['lowerWeightLimit']?>" name="fdata[lowerWeightLimit]" id="Lower_weight_limit" placeholder="" onkeypress="return isNumberKey(event)" class="form-control">
                                </div>
                            </div>

                            <div class="form-group required" style="display: none">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('Upper_weight_limit'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="weightTag"><?=$data['weightMetricText']?></b></span>
                                    <input type="text" value="<?= $data['laundry']['upperWeightLimit']?>" name="fdata[upperWeightLimit]" id="Upper_weight_limit" placeholder="" onkeypress="return isNumberKey(event)" class="form-control">
                                </div>
                            </div>

                            <div class="form-group required" style="display: none">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('Price'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"><?= $data['currencySymbol'] ?></b></span>
                                    <input type="text" value="<?= $data['laundry']['Price']?>" name="fdata[Price]" id="Price" placeholder="" onkeypress="return isNumberKey(event)" class="form-control ">
                                </div>
                            </div>

                            <div class="form-group required" style="display: none">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('Extra_Fee_forexpress_delivery'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"><?= $data['currencySymbol'] ?></b></span>
                                    <input type="text" value="<?= $data['laundry']['extraFeeForExpressDelivery']?>" name="fdata[extraFeeForExpressDelivery]" id="Extra_Fee_forexpress_delivery" placeholder="" onkeypress="return isNumberKey(event)" class="form-control">
                                </div>
                            </div>

                            <div class="form-group required" style="display: none">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('Taxes_applicable'); ?></span>
                                <div class="col-sm-4">
                                <input type="radio" <?php echo $yes;?>  name="fdata[taxesApplicable]" value=1 id="Taxes_applicable">
                                    <span class=' control-label'><?php echo $this->lang->line('Yes'); ?></span>
                                    
                                </div>
                                <div class="col-sm-4">
                                <input type="radio" <?php echo $no;?>  name="fdata[taxesApplicable]" value=2 id="Taxes_applicable2">
                                    <span class=' control-label'><?php echo $this->lang->line('No'); ?></span>
                                  
                                </div>
                            </div>


                            
                            

                            <div class="form-group">
                                <label for="" class="control-label col-md-4" style="color: #0090d9;"><?php echo $this->lang->line('MILEAGE_SETTING'); ?></label>
                            </div>

                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_baseFare'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"><?= $data['currencySymbol'] ?></b></span>
                                    <input type="text" name="fdata[baseFare]" id="baseFare" value="<?= $data['baseFare']; ?>" placeholder="Enter Base Fare" class="form-control required ">
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_Mileage_Price'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"><?= $data['currencySymbol'] ?></b></span>
                                    <input type="text" name="fdata[mileagePrice]" value="<?= $data['mileagePrice']; ?>" id="mileagePrice" placeholder="Enter Mileage Price" class="form-control required">
                                </div>
                                <div class="col-sm-5">
                                    <span class="abs_textLeft"><b>After</b></span>
                                    <input type="text" name="fdata[mileagePriceAfterMinutes]" id="mileagePriceAfter" value="<?= $data['mileagePriceAfterDistance']; ?>" style="padding-left: 74px;" class="form-control required">
                                    <span class="abs_text mileagePriceText"><b><?= $data['mileageMetricText']; ?></b></span>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_timeFee'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"><?= $data['currencySymbol'] ?></b></span>
                                    <input type="text" name="fdata[timeFee]" value="<?= $data['timeFee']; ?>" id="timeFee" placeholder="Enter Time Fee" class="form-control required">
                                </div>
                                <div class="col-sm-5">
                                    <span class="abs_textLeft"><b>After</b></span>
                                    <input type="text" name="fdata[timeFeeAfterMinutes]" style="padding-left: 74px;" value="<?= $data['timeFeeAfterMinutes']; ?>" id="timeFeeAfter" placeholder="Enter time fare" class="form-control required">
                                    <span class="abs_text"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                </div>
                            </div>
<!--                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_waitingFee'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"><?= $data['currencySymbol'] ?></b></span>
                                    <input type="text" name="fdata[waitingFee]" id="waitingFee" value="<?= $data['waitingFee'] ?>"placeholder="Enter Waiting Fee" class="form-control required">
                                </div>
                                <div class="col-sm-5">
                                    <span class="abs_textLeft"><b>After</b></span>
                                    <input type="text" value="<?= $data['waitingFeeAfterMinutes']; ?>" name="fdata[waitingFeeAfterMinutes]" style="padding-left: 74px;" id="waitingFeeAfter" class="form-control required">
                                    <span class="abs_text"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                </div>
                            </div>-->
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_minimumFare'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"><?= $data['currencySymbol'] ?></b></span>
                                    <input type="text" name="fdata[minimumFare]" id="minimumFare" value="<?= $data['minimumFare'] ?>" placeholder="Enter Minimum Fare" class="form-control required">
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_On-Demand Bookings_Cancellation_Fee'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"><?= $data['currencySymbol'] ?></b></span>
                                    <input type="text" name="fdata[onDemandBookingsCancellationFee]" value="<?= $data['onDemandBookingsCancellationFee']; ?>" id="onDemandBookingsCancellationFee" placeholder="Enter Now Booking Cancellation Fee" class="form-control required">
                                </div>
                                <div class="col-sm-5">
                                    <span class="abs_textLeft"><b>After</b></span>
                                    <input type="text" style="padding-left: 74px;" value="<?= $data['onDemandBookingsCancellationFeeAfterMinutes']; ?>"   name="fdata[onDemandBookingsCancellationFeeAfterMinutes]" id="onDemandBookingsCancellationFeeAfter" class="form-control required">
                                    <span class="abs_text"><b><?php echo $this->lang->line('Minutes'); ?></b></span>
                                </div>
                            </div>
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_ScheduledBookingsCancellationFee'); ?></span>
                                <div class="col-sm-5">
                                    <span class="abs_text"><b class="postfixTag"><?= $data['currencySymbol'] ?></b></span>
                                    <input type="text" name="fdata[ScheduledBookingsCancellationFee]" value="<?= $data['scheduledBookingsCancellationFee'] ?>" id="ScheduledBookingsCancellationFee" placeholder="Enter Scheduled Booking Cancellation Fee" class="form-control required">
                                </div>
                                <div class="col-sm-5">

                                    <span class="abs_textLeft"><b>Before</b></span>
                                    <input type="text" style="padding-left: 74px;" value="<?= $data['scheduledBookingsCancellationFeeBeforeMinutes']; ?>" name="fdata[ScheduledBookingsCancellationFeeBeforeMinutes]" id="ScheduledBookingsCancellationFeeAfter"  class="form-control required">
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
                                <span class='col-sm-2 control-label'><?php echo $this->lang->line('lable_convenienceFee'); ?></span>
                                <div class="col-sm-5">
                                    <!-- <span class="abs_text"><b class="postfixTag"><?= $data['currencySymbol'] ?></b></span> -->
                                    <input type="text" name="fdata[convenienceFee]" value="<?= $data['convenienceFee']; ?>"id="convenienceFee" placeholder="Enter Convenience Fee" class="form-control required">
                                </div>
                            </div>

                            <!--                            <div class="form-group required">
                                                            <label for="" class="control-label col-md-2">Paid by Receiver</label>
                                                            <div class="col-sm-6">
                                                                <div class="switch">
                                                                    <input id="paidByReceiver" name="fdata[paymentMode][paidByReceiver]" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;" <?= (isset($data['paymentMode']['paidByReceiver']) && $data['paymentMode']['paidByReceiver'] == TRUE) ? "checked" : "" ?>>
                                                                    <label for="paidByReceiver"></label>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="paidByReceiverPreviousState" name="paidByReceiverPreviousState">
                                                        </div>-->
                         
                            <div class="form-group required">
                                <span class='col-sm-2 control-label'>Zone</span>
                                <div class="col-sm-10">

                                    <div id="city_zone_map" style="height:400px;"></div>
                                    <input type="hidden" name="fdata[latitude]" id="city_lat" value="<?php echo $data['coordinates']['latitude']; ?>">
                                    <input type="hidden" name="fdata[longitude]" id="city_long" value="<?php echo $data['coordinates']['longitude']; ?>">
                                    <input type="hidden" name="fdata[path]" id="city_zone_prop" value="<?php echo htmlentities(json_encode($data['polygonProps'])); ?>">
                                    <input type="hidden" name="fdata[location]" id="city_zone_path" value="<?php echo htmlentities(json_encode($data['polygons'])) ;?>">
                                    <input type="hidden" name="edit_id" value="<?php echo $cityId; ?>">
                                    <input type="hidden" name="docid" value="<?php echo $data['id']; ?>">
                                    <input type="hidden" name="fdata[city]" value="<?php echo $data['cityName']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 m-t-10 sm-m-t-10 pull-right text-right">
                                    <button type='submit' class="btn btn-primary" id='btnSubmit'>Update City</button>
                                    <button type='button' class="btn btn-primary" id='btnResetZone' style="display: none;">Clear Zone</button>
                                </div>
                            </div>
                        </form>
                    </div>                                    
                </div>
            </div>
        </div>
    </div>
</div>
</div>