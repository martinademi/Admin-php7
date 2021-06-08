<style>
    .error{
        color: red;
    }
    .form-group.required .control-label:after{
        content: " *";
        color: red;
    }
    .locMain .delLocBtn{
        display: none;
    }
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
        height: 16px;
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
    .halfRow{
        padding: 6px;
        padding-left: 9%;
        padding-right: 9%;
    }
    .switch{
        padding:8px;
        float: right;
    }
    .halfRow .form-group{
        border: 1px solid #c3c3c3;
        border-radius: 20px;
    }
</style>
<script src="//maps.googleapis.com/maps/api/js?key=<?= GOOGLE_MAP_API_KEY ?>&v=3&libraries=drawing,places"></script>
<script src="https://cdn.jsdelivr.net/npm/@turf/turf@5/turf.min.js"></script>
<script src="//admin.uberforall.com/supportFiles/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="//admin.uberforall.com/supportFiles/sweetalert.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<link href="<?= base_url() ?>/vendors/bootstrap/dist/css/bootstrap-multiselect.css" rel="stylesheet">
<script>
    var areaZone = <?= json_encode($zones_data) ?>;
    var map = "";
    var drawingManager = "";
    var cities = <?= json_encode($allcities) ?>;
    var polygonProps = null;
    var rectangle = null;
    var cityZone = null;
    var cityProp = [];
    var cityAreas = [];

    var validZone = false;

    var markers = [];
    var centerLatLng = null;

    $(document).ready(function () {
     
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

        google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
            polygonProps = polygon;
            drawingManager.setMap(null);

            drawingManager.setDrawingMode(null);

            $('#btnResetZone').show();
            $('#btnValidate').show();

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
            if ((drawingManager.getDrawingMode() == google.maps.drawing.OverlayType.POLYGON) && (rectangle != null))
                rectangle.setMap(null);
        });

        $('#zoneCity').change(function () {
            $.each(cities, function (ind, val) {
                if (val['cityId'] == $('#zoneCity').val()) {
                   if (cityZone != null)
                       cityZone.setMap(null);
                   val.polygonProps.strokeColor = '#000000';
                   val.polygonProps.strokeOpacity = 1;
                   val.polygonProps.strokeWeight = 1;
                   val.polygonProps.fillOpacity = 0;
                   cityZone = new google.maps.Polygon(val.polygonProps);
                   cityZone.setMap(map);
                   cityProp = val['polygons']['coordinates'];

                   var latlngbounds = new google.maps.LatLngBounds();
                   for (var j = 0; j < val.polygonProps.paths.length; j++) {
                       latlngbounds.extend(new google.maps.LatLng(val.polygonProps.paths[j]['lat'], val.polygonProps.paths[j]['lng']));
                   }
                   map.fitBounds(latlngbounds);
                    var pos = new google.maps.LatLng(val.latitude, val.longitude);
                    map.setCenter(pos);
                    overlapFlag = true;

                    $.ajax({
                        url: '<?= base_url() ?>index.php?/Zones_Controller/getCityZone',
                        type: 'POST',
                        dataType: "JSON",
                        data: {
                            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                            cityId: $('#zoneCity').val()
                        },
                        timeout: 30000,
                        cache: false,
                        success: function (response) {
                            if (response.flag == 0) {
                                drawCityAreas(response.data);
                            } else {
                                drawCityAreas([]);
                                swal("", response.msg, "error");
                            }
                        },
                        error: function (jqXHR, status, err) {
                            drawCityAreas([]);
                            swal("", 'Something Went Wrong', "error");
                        }
                    });
                }
            });
        });

        $('#btnValidate').click(function () {
            validateZone(function (overlapFlag, zoneProp, zonePath) {
                console.log(overlapFlag);
                console.log(zoneProp);
                console.log(zonePath);
                if (overlapFlag) {
                    validZone = true;

                    var latlngbounds = new google.maps.LatLngBounds();
                    for (var j = 0; j < zonePath.paths.length; j++) {
                        latlngbounds.extend(new google.maps.LatLng(zonePath.paths[j]['lat'], zonePath.paths[j]['lng']));
                    }
                    map.fitBounds(latlngbounds);

                    var polygon = turf.polygon(zoneProp['coordinates']);
                    var centroid = turf.centroid(polygon);
                    centerLatLng = new google.maps.LatLng(centroid.geometry.coordinates[1], centroid.geometry.coordinates[0]);

//                    $('.btnOnOff').trigger('change');
//                    $('.delLocBtn').trigger('click');

                    $('#zone_prop').val(JSON.stringify(zoneProp));
                    $('#zone_path').val(JSON.stringify(zonePath));
                } else {
                    validZone = false;
                }
            });
        });

        $('.btnOnOff').change(function () {
            if (this.checked) {
                if (centerLatLng != null) {
                    $('.zoneLocationName').each(function (ind, val) {
                        if (typeof markers[ind] == 'undefined') {
                            marker = new google.maps.Marker({
                                position: centerLatLng,
                                draggable: true,
                                animation: google.maps.Animation.DROP,
                                ind: markers.length
                            });
                            // To add the marker to the map, call setMap();
                            marker.setMap(map);
                            markers.push(marker);
                        } else {
                            markers[ind].setMap(map);
                        }
                    });
                }
                $('.pickupLocations').show();
                manageLocInd();
            } else {
                //remove all markers from map
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                $('.pickupLocations').hide();
            }
        });

        $('.additionalFees').change(function () {
            if (this.checked) {
                $(this).closest('.additionalFeesBlock').find('.additionalFeesData').show();
            } else {
                $(this).closest('.additionalFeesBlock').find('.additionalFeesData').hide();
            }
        });

        $(document).on('focus', '.zoneLocationName', function () {
            if (markers.length == 0) {
                return;
            }
            for (var i = 0; i < markers.length; i++) {
                markers[i].setAnimation(null);
            }
            var ind = $(this).attr('data-ind');
            markers[ind].setAnimation(google.maps.Animation.BOUNCE);
            setTimeout(function () {
                markers[ind].setAnimation(null);
            }, 3000);
            manageLocInd();
        });

        $('#btnAddLocation').click(function () {
            if (centerLatLng == null) {
                swal("", 'First Validate Zone', "error");
            } else {
                var html = $('.locMain').html();
                $('.locSub').append(html);
                marker = new google.maps.Marker({
                    position: centerLatLng,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    ind: markers.length
                });
                // To add the marker to the map, call setMap();
                marker.setMap(map);
                markers.push(marker);
//                manageLocInd();
            }
        });

        $('#fetchLocation').click(function () {
            manageLocInd();
        });

        $(document).on('click', '.delLocBtn', function () {
            var ind = $(this).closest('.form-group').find('.zoneLocationName').attr('data-ind');
            if (ind != 0) {
                $(this).closest('.form-group').remove();
                if (typeof markers[ind] != 'undefined') {
                    markers[ind].setMap(null);
                    markers.splice(ind, 1);
                }
                manageLocInd();
            }
        });


        $('#btnResetZone').click(function () {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
            centerLatLng = null;
            manageLocInd();

            validZone = false;
            rectangle.setMap(null);
            drawingManager.setMap(map);
            polygonProps = null;
            $('#btnResetZone').hide();
            $('#btnValidate').hide();
        });

 


    });

    function manageLocInd() {
        $('.zoneLocationName').each(function (ind, val) {
            $(this).attr('name', 'fdata[zoneLocationName][' + ind + ']');
            $(this).attr('data-ind', ind);
        });
        $('.zoneLocationLat').each(function (ind, val) {
            $(this).closest('.form-group').find('.zoneLocationLatDis').val('');
            $(this).val('');
            if (typeof markers[ind] != 'undefined') {
                $(this).closest('.form-group').find('.zoneLocationLatDis').val(markers[ind].position.lat());
                $(this).val(markers[ind].position.lat());
            }
            $(this).attr('data-ind', ind);
        });
        $('.zoneLocationLng').each(function (ind, val) {
            $(this).closest('.form-group').find('.zoneLocationLngDis').val('');
            $(this).val('');
            if (typeof markers[ind] != 'undefined') {
                $(this).closest('.form-group').find('.zoneLocationLngDis').val(markers[ind].position.lng());
                $(this).val(markers[ind].position.lng());
            }
            $(this).attr('data-ind', ind);
        });
    }

    var cityAreaZones = [];
    var infoWindow = [];

    function drawCityAreas(zones) {
//        cityAreas = zones || [];
        var i = 0;
        for (i = 0; i < cityAreaZones.length; i++) {
            cityAreaZones[i].setMap(null);
        }
        for (i = 0; i < infoWindow.length; i++) {
            infoWindow[i].setMap(null);
        }
        cityAreaZones = [];
        infoWindow = [];
        $.each(zones, function (ind, val) {
            val.polygonProps.editZone = false;
            if (val['_id']['$oid'] == areaZone['_id']['$oid']) {
                var latlngbounds = new google.maps.LatLngBounds();
                for (var j = 0; j < val.polygonProps.paths.length; j++) {
                    latlngbounds.extend(new google.maps.LatLng(val.polygonProps.paths[j]['lat'], val.polygonProps.paths[j]['lng']));
                }
                map.fitBounds(latlngbounds);
                val.polygonProps.editZone = true;
            } else {
                cityAreas.push(val);
            }
            val.polygonProps.ind = ind;
            cityAreaZones[ind] = new google.maps.Polygon(val.polygonProps);
            cityAreaZones[ind].setMap(map);

            infoWindow[ind] = new google.maps.InfoWindow;
            infoWindow[ind].setContent('<b>' + val.title + '</b>');
            infoWindow[ind].setPosition({lat: val.polygonProps.paths[0].lat, lng: val.polygonProps.paths[0].lng});
            infoWindow[ind].setMap(null);

            google.maps.event.addListener(cityAreaZones[ind], 'click', function (event) {
                if (this.editZone)
                    editZone(this);
                else
                    infoWindow[this.ind].setMap(map);
            });
        });
    }

    function editZone(polygon) {
        $('#zone_prop').val('');
        $('#zone_path').val('');
        polygon.setEditable(true);
        polygon.setDraggable(true);
        polygonProps = polygon;
        rectangle = polygon;

        $('#btnValidate').show();
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

        validZone = false;
    }

    $(function ()
    {
        validZone = true;

        $('.zoneCity').val('<?= $zones_data['city_ID'] ?>');
        $('#zoneCity').trigger('change');


//        if (areaZone.dispatchByQueue)
//            $('#zoneQueing').prop('checked', true);
//
//        $('#additionalFeePickup').prop('checked', false);
//        $('#additionalFeePickup').trigger('change');
//        if (typeof areaZone.additionalFees != 'undefined' && typeof areaZone.additionalFees.pickup != 'undefined') {
//            if (areaZone.additionalFees.pickup) {
//                $('#additionalFeePickup').prop('checked', true);
//                $('#additionalFeePickup').trigger('change');
//                $('#additionalFeePickupTitle').val(areaZone.additionalFees.pickupFees.title);
//                $('#additionalFeePickupPrice').val(areaZone.additionalFees.pickupFees.fee);
//            }
//        }
//
//        $('#additionalFeeDrop').prop('checked', false);
//        $('#additionalFeeDrop').trigger('change');
//        if (typeof areaZone.additionalFees != 'undefined' && typeof areaZone.additionalFees.pickup != 'undefined') {
//            if (areaZone.additionalFees.drop) {
//                $('#additionalFeeDrop').prop('checked', true);
//                $('#additionalFeeDrop').trigger('change');
//                $('#additionalFeeDropTitle').val(areaZone.additionalFees.dropFees.title);
//                $('#additionalFeeDropPrice').val(areaZone.additionalFees.dropFees.fee);
//            }
//        }

        drawingManager.setMap(null);
        drawingManager.setDrawingMode(null);

        var polygon = turf.polygon(areaZone['polygons']['coordinates']);
        var centroid = turf.centroid(polygon);
        centerLatLng = new google.maps.LatLng(centroid.geometry.coordinates[1], centroid.geometry.coordinates[0]);

        if (areaZone.specialPickup) {
            $('#specialPickup').prop('checked', true);
            $('#specialPickup').trigger('change');
            $.each(areaZone.pickups, function (ind, val) {
                if (ind == 0) {
                    $('.locMain').find('.zoneLocationName').val(val.title);
                    $('.locMain').find('.zoneLocationLatDis').val(val.location.latitude);
                    $('.locMain').find('.zoneLocationLngDis').val(val.location.longitude);
                } else {
                    $('#btnAddLocation').trigger('click');
                    $('.locSub').find('.form-group:nth-child(' + ind + ')').find('.zoneLocationName').val(val.title);
                    $('.locSub').find('.form-group:nth-child(' + ind + ')').find('.zoneLocationLatDis').val(val.location.latitude);
                    $('.locSub').find('.form-group:nth-child(' + ind + ')').find('.zoneLocationLngDis').val(val.location.longitude);
                }
                var latlng = new google.maps.LatLng(val.location.latitude, val.location.longitude);
                markers[ind].setPosition(latlng);
            });
            manageLocInd();
        }

        var validator = $('#form_addNewZone').validate({
            submitHandler: function (form) {
                if (validZone) {
                    $.ajax({
                        url: '<?= base_url() ?>index.php?/Zones_Controller/editAreaZone',
                        type: 'POST',
                        dataType: "JSON",
                        data: $(form).serialize(),
                        timeout: 30000,
                        cache: false,
                        //                processData: false,
                        success: function (response) {
                            console.log(response);
                            if (response.flag == 0) {
                                window.location.href = "<?= base_url() ?>index.php?/Zones_Controller";
                            } else {
                                swal("", response.msg, "error");
                            }
                        },
                        error: function (jqXHR, status, err) {
                            swal("", 'Something Went Wrong.', "error");
                        }
                    });
                } else {
                    swal("", 'Validate Zone First.', "error");
                }
                return false;
            }
        });
    });

    // function validateZone(callback) {
        // var cl = "#" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0);
        // var overlapFlag = true;
        // var zoneProp = [];
        // var zonePath = {
            // "strokeColor": cl,
            // "strokeOpacity": 0.4,
            // "strokeWeight": 2,
            // "fillColor": cl,
            // "fillOpacity": 0.55,
            // "draggable": false,
            // "editable": false,
            // "paths": []
        // };
        // if (polygonProps == null) {
            // swal("Invalid Zone", 'Please provide valid zone.', "warning");
            // return callback(overlapFlag);
        // } else if (polygonProps.getPath().getLength() >= 3 ) {
            // for (var i = 0; i < polygonProps.getPath().getLength(); i++) {
                 // zonePath.paths.push({
                    // "lat": polygonProps.getPath().getAt(i).lat(),
                    // "lng": polygonProps.getPath().getAt(i).lng()
                // });
                // zoneProp.push([polygonProps.getPath().getAt(i).lng(), polygonProps.getPath().getAt(i).lat()]);
            // }
            // zoneProp.push(zoneProp[0]);
            // var newZoneTurf = turf.polygon([zoneProp], {
                // "fill": "#F00",
                // "fill-opacity": 0.1
            // });
           // var cityZoneTurf = turf.polygon(cityProp, {
               // "fill": "#00F",
               // "fill-opacity": 0.1
           // });
           // var intersection = null;
           // try {
               // intersection = turf.intersect(newZoneTurf, cityZoneTurf);
           // } catch (err) {
               // console.log(err);
           // }
           // if (intersection !== null) {
               // if (intersection.geometry.coordinates[0].length > 3) {
                   // zoneProp = [];
                   // zonePath.paths = [];
                   // $.each(intersection.geometry.coordinates[0], function (index, latlng) {
                       // zoneProp.push([latlng[0], latlng[1]]);
                       // zonePath.paths.push({
                           // "lat": latlng[1],
                           // "lng": latlng[0]
                       // });
                   // });
                   // zoneProp.push(zoneProp[0]);
                   // newZoneTurf = intersection;
                   // overlapFlag = true;
                    // $.each(cityAreas, function (ind, val) {
                        // var oldZoneTurf = turf.polygon(val['polygons']['coordinates'], {
                            // "fill": "#00F",
                            // "fill-opacity": 0.1
                        // });
                        // var zoneOverlap = null;
                        // try {
                            // zoneOverlap = turf.intersect(newZoneTurf, oldZoneTurf);
                        // } catch (err) {
                            // console.log(err);
                        // }
                        // if (zoneOverlap !== null) {
                            // var diffZoneTurf = turf.difference(newZoneTurf, oldZoneTurf);
                            // if (diffZoneTurf.geometry.type == "MultiPolygon") {
                                // diffZoneTurf.geometry.coordinates = diffZoneTurf.geometry.coordinates[0];
                            // }
                            // if (
                                    // diffZoneTurf.geometry.coordinates.length == 1 &&
                                    // diffZoneTurf.geometry.coordinates[0].length > 3 &&
                                    // overlapFlag
                                    // ) {
                                // zoneProp = [];
                                // zonePath.paths = [];
                                // $.each(diffZoneTurf.geometry.coordinates[0], function (index, latlng) {
                                    // zoneProp.push([latlng[0], latlng[1]]);
                                    // zonePath.paths.push({
                                        // "lat": latlng[1],
                                        // "lng": latlng[0]
                                    // });
                                // });
                                // zoneProp.push(zoneProp[0]);
                                // newZoneTurf = diffZoneTurf;
                                // var features = turf.featureCollection([
                                    // turf.polygon([zoneProp], {combine: 'yes'}),
                                    // turf.polygon(val['polygons']['coordinates'], {combine: 'yes'}),
                                // ]);
                                // overlapFlag = true;
                            // } else {
                                // if (overlapFlag) {
                                    // $('#btnResetZone').trigger('click');
                                    // swal("Invalid Zone", 'Please provide valid zone.', "warning");
                                    // overlapFlag = false;
                                // }
                            // }
                        // }
                    // });
                   // if(overlapFlag){
                       // var area = turf.area(newZoneTurf);
                       // if(area == 0){
                           // $('#btnResetZone').trigger('click');
                           // swal("Invalid Zone", 'Please provide valid zone.', "warning");
                           // overlapFlag = false;
                       // }
                   // }
               // } else {
                   // $('#btnResetZone').trigger('click');
                   // swal("Invalid Zone", 'Please provide valid zone.', "warning");
                   // overlapFlag = false;
               // }
           // } else {
               // $('#btnResetZone').trigger('click');
               // swal("", 'Zone outside city is not allowed.', "warning");
               // overlapFlag = false;
           // }
        // } else {
           // if (cityProp.length == 0) {
               // swal("", 'Please select city.', "warning");
           // } else {
                // $('#btnResetZone').trigger('click');
                // swal("Invalid Zone", 'Please provide valid zone.', "warning");
           // }
            // overlapFlag = false;
        // }
        // if (overlapFlag) {
            // var diffZone = new google.maps.Polygon(zonePath);
            // diffZone.setMap(map);
            // polygonProps.setMap(null);
            // polygonProps = diffZone;
            // rectangle.setMap(null);
            // rectangle = diffZone;

            // google.maps.event.addListener(diffZone, 'click', function (event) {
                // editZone(this);
            // });
        // }
        // zoneProp = {
            // "type": "Polygon",
            // "coordinates": [zoneProp]
        // };
       // zonePath.draggable = false;
       // zonePath.editable = false;
        // return callback(overlapFlag, zoneProp, zonePath);
    // }
	
	 function validateZone(callback) {
        var cl = "#" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0);
        var overlapFlag = false;
        var zoneProp = [];
        var zonePath = {
            "strokeColor": cl,
            "strokeOpacity": 0.4,
            "strokeWeight": 2,
            "fillColor": cl,
            "fillOpacity": 0.55,
            "draggable": false,
            "editable": false,
            "paths": []
        };
        if (polygonProps == null) {
            swal("Invalid Zone", 'Please provide valid zone.', "warning");
            return callback(overlapFlag);
        } else if (polygonProps.getPath().getLength() >= 3 && cityProp.length == 1) {
            for (var i = 0; i < polygonProps.getPath().getLength(); i++) {
                zoneProp.push([polygonProps.getPath().getAt(i).lng(), polygonProps.getPath().getAt(i).lat()]);
            }
            zoneProp.push(zoneProp[0]);
            var newZoneTurf = turf.polygon([zoneProp], {
                "fill": "#F00",
                "fill-opacity": 0.1
            });
            var cityZoneTurf = turf.polygon(cityProp, {
                "fill": "#00F",
                "fill-opacity": 0.1
            });
            var intersection = null;
            try {
                intersection = turf.intersect(newZoneTurf, cityZoneTurf);
            } catch (err) {
                console.log(err);
            }
            if (intersection !== null) {
                if (intersection.geometry.coordinates[0].length > 3) {
                    zoneProp = [];
                    zonePath.paths = [];
                    $.each(intersection.geometry.coordinates[0], function (index, latlng) {
                        zoneProp.push([latlng[0], latlng[1]]);
                        zonePath.paths.push({
                            "lat": latlng[1],
                            "lng": latlng[0]
                        });
                    });
                    zoneProp.push(zoneProp[0]);
                    newZoneTurf = intersection;
                    overlapFlag = true;
                    $.each(cityAreas, function (ind, val) {
                        var oldZoneTurf = turf.polygon(val['polygons']['coordinates'], {
                            "fill": "#00F",
                            "fill-opacity": 0.1
                        });
                        var zoneOverlap = null;
                        try {
                            zoneOverlap = turf.intersect(newZoneTurf, oldZoneTurf);
                        } catch (err) {
                            console.log(err);
                        }
                        if (zoneOverlap !== null) {
                            var diffZoneTurf = turf.difference(newZoneTurf, oldZoneTurf);
                            if (diffZoneTurf.geometry.type == "MultiPolygon") {
                                diffZoneTurf.geometry.coordinates = diffZoneTurf.geometry.coordinates[0];
                            }
                            if (
                                    diffZoneTurf.geometry.coordinates.length == 1 &&
                                    diffZoneTurf.geometry.coordinates[0].length > 3 &&
                                    overlapFlag
                                    ) {
                                zoneProp = [];
                                zonePath.paths = [];
                                $.each(diffZoneTurf.geometry.coordinates[0], function (index, latlng) {
                                    zoneProp.push([latlng[0], latlng[1]]);
                                    zonePath.paths.push({
                                        "lat": latlng[1],
                                        "lng": latlng[0]
                                    });
                                });
                                zoneProp.push(zoneProp[0]);
                                newZoneTurf = diffZoneTurf;
                                var features = turf.featureCollection([
                                    turf.polygon([zoneProp], {combine: 'yes'}),
                                    turf.polygon(val['polygons']['coordinates'], {combine: 'yes'}),
                                ]);
                                overlapFlag = true;
                            } else {
                                if (overlapFlag) {
                                    $('#btnResetZone').trigger('click');
                                    swal("Invalid Zone", 'Please provide valid zone.', "warning");
                                    overlapFlag = false;
                                }
                            }
                        }
                    });
//                    if(overlapFlag){
//                        var area = turf.area(newZoneTurf);
//                        if(area == 0){
//                            $('#btnResetZone').trigger('click');
//                            swal("Invalid Zone", 'Please provide valid zone.', "warning");
//                            overlapFlag = false;
//                        }
//                    }
                } else {
                    $('#btnResetZone').trigger('click');
                    swal("Invalid Zone", 'Please provide valid zone.', "warning");
                    overlapFlag = false;
                }
            } else {
                $('#btnResetZone').trigger('click');
                swal("", 'Zone outside city is not allowed.', "warning");
                overlapFlag = false;
            }
        } else {
            if (cityProp.length == 0) {
                swal("", 'Please select city.', "warning");
            } else {
                $('#btnResetZone').trigger('click');
                swal("Invalid Zone", 'Please provide valid zone.', "warning");
            }
            overlapFlag = false;
        }
        if (overlapFlag) {
            var diffZone = new google.maps.Polygon(zonePath);
            diffZone.setMap(map);
            polygonProps.setMap(null);
            polygonProps = diffZone;
            rectangle.setMap(null);
            rectangle = diffZone;
            
            google.maps.event.addListener(rectangle, 'click', function (event) {
                editZone(this);
            });
        }
        zoneProp = {
            "type": "Polygon",
            "coordinates": [zoneProp]
        };

        return callback(overlapFlag, zoneProp, zonePath);
    }

     


</script>

<div class="page-content-wrapper">
    <div class="content">
        <div class="container-fluid container-fixed-lg">
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo base_url('index.php?/Zones_Controller') ?>"><?php echo $this->lang->line('areaZones') ?></a>
                </li>
                <li>
                    <a href="#" class="active"><?php echo $this->lang->line('areaZonesAdd') ?></a>
                </li>
            </ul>
            <div class="container-md-height m-b-20">
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs nav-tabs-simple bg-white" role="tablist" data-init-reponsive-tabs="collapse">
                            <!--                            <li class="active">
                                                            <a href="#lan_grp" data-toggle="tab" role="tab" aria-expanded="true">Create</a>
                                                        </li>-->
                        </ul>
                    </div>
                    <div class="panel-body no-padding">
                        <form action="" id="form_addNewZone" class="form-horizontal" role="form" method="get">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                            <div class="form-group required">
                                <span class='col-sm-2 control-label' for="zoneCity"><?php echo $this->lang->line('zoneCity') ?></span>
                                <div class="col-sm-10">
                                    <select name="fdata[cityId]" id="zoneCity" class="form-control zoneCity" disabled>
                                        <option value="" selected disabled><?php echo $this->lang->line('zoneSelectCity') ?></option>
                                        <?php
                                        foreach ($cities as $city) {
                                            foreach ($city['cities'] as $data) {
                                                if ($data['isDeleted'] == FALSE) {
                                                    ?>
                                                    <option value="<?php echo $data['cityId']['$oid']; ?>" city="<?php echo $data['cityName']; ?>" lat="" lng="" currency="<?php echo $data['currency']; ?>" currencySymbol="<?php echo $data['currencySymbol']; ?>" weightMetric="<?php echo $data['weightMetric']; ?>" mileageMetric="<?php echo $data['mileageMetric']; ?>"><?php echo $data['cityName']; ?></option>    
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" name="fdata[cityId]" class="zoneCity">
                                </div>
                            </div>

                            <div class="form-group required">
                                <span class='col-sm-2 control-label' for="zoneTitle"><?php echo $this->lang->line('zoneTitle') ?></span>
                                <div class="col-sm-10">
                                    <input type="text" name="fdata[title]" id="zoneTitle" placeholder="<?php echo $this->lang->line('zoneTitle') ?>" class="form-control" required value="<?php echo $zones_data['title'] ?>">
                                </div>
                            </div>
                            <input type="hidden" name="fdata[hasPackage]" value="<?php echo $hasPackage ?>" >
                            <?php if($hasPackage==1){?>

                            <div id="Category_txt" >
                                <div class="row">
                                    <div class="form-group col-sm-12">                                  
                                        <label for="fname" class="col-sm-2 control-label"> Name(English) <span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text"   id="Editcatname_0" name="Editcatname[0]" style="  width: 50%;line-height: 2;" class="Editcatname form-control error-box-class" value="<?php echo $zones_data['packagingPlanDetails']['packagingPlanName']['en'] ?>" readonly >
                                        </div>
                                    </div>  
                                </div>
                                <div class="row">
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group col-sm-12">
                                                <label for="fname" class="col-sm-4 control-label">Name (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6">
                                                    <input type="text"  id="Editcatname_<?= $val['lan_id'] ?>" name="Editcatname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="Editcatname form-control error-box-class" >
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group formex col-sm-12" style="display:none">
                                                <label for="fname" class="col-sm-5 control-label">Name (<?php echo $val['lan_name']; ?>) </label>
                                                <div class="col-sm-6">
                                                    <input type="text"  id="Editcatname_<?= $val['lan_id'] ?>" name="Editcatname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="Editcatname form-control error-box-class" >
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                        <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-2 control-label"><?php echo $this->lang->line('label_Weight'); ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="error-box-class form-control " style="  width: 50%;line-height: 2;" name="fdata[packagingPlanDetails][weight]" id="EditweightMetrics" value="<?php echo $zones_data['packagingPlanDetails']['weight'] ?>" placeholder="<?php echo $this->lang->line('enter_name'); ?>" >  
                                        </div>
                                    </div>
                                </div>     

             

                   <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="col-sm-2 control-label"><?php echo $this->lang->line('label_Price'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="error-box-class form-control " style="  width: 50%;line-height: 2;" name="fdata[packagingPlanDetails][price]" id="Editprice" value="<?php echo $zones_data['packagingPlanDetails']['price'] ?>"  placeholder="<?php echo $this->lang->line('enter_price'); ?>" >  
                        </div>
                    </div>
                </div>

                   <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="col-sm-2 control-label"><?php echo $this->lang->line('label_UL'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="error-box-class form-control " style="  width: 50%;line-height: 2;" name="fdata[packagingPlanDetails][upperLimit]" id="EditupperLimit" value="<?php echo $zones_data['packagingPlanDetails']['upperLimit'] ?>" placeholder="<?php echo $this->lang->line('enter_ul'); ?>" >  
                        </div>
                    </div>
                </div>

                   <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="col-sm-2 control-label"><?php echo $this->lang->line('label_LL'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="error-box-class form-control " style="  width: 50%;line-height: 2;" name="fdata[packagingPlanDetails][lowerLimit]" id="EditlowerLimit" value="<?php echo $zones_data['packagingPlanDetails']['lowerLimit'] ?>" placeholder="<?php echo $this->lang->line('enter_ll'); ?>" >  
                        </div>
                    </div>
                </div> 

                            <?php } ?>                     

                            <div class="form-group required">
                                <span class='col-sm-2 control-label'>Zone</span>
                                <div class="col-sm-10">
                                    <div id="city_zone_map" style="height:400px;"></div>
                                    <input type="hidden" name="fdata[polygons]" id="zone_prop" value="<?= htmlentities(json_encode($zones_data['polygons'])) ?>">
                                    <input type="hidden" name="fdata[polygonProps]" id="zone_path" value="<?= htmlentities(json_encode($zones_data['polygonProps'])) ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4 m-t-10 sm-m-t-10 pull-right text-right">
                                    <button type='button' class="btn btn-primary" id='btnValidate' style="display: none;">Validate Zone</button>
                                    <button type='button' class="btn btn-primary" id='btnResetZone' style="display: none;">Clear Zone</button>
                                </div>
                            </div>

                            <hr/>


                            <div class="form-group required pickupLocations" style="display: none;">
                                <div class="locMain">
                                    <div class="form-group required">
                                        <span class='col-sm-2 control-label' for="zoneLocationName"><?php // lang('zoneLocationName') ?></span>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <input type="text" name="fdata[zoneLocationName][0]" data-ind="0" placeholder="<?php // lang('zoneLocationName') ?>" class="form-control zoneLocationName" required>
                                                <input type="hidden" name="fdata[zoneLocationLat][]" value="" data-ind="0" class="zoneLocationLat">
                                                <input type="hidden" name="fdata[zoneLocationLng][]" value="" data-ind="0" class="zoneLocationLng">
                                                <span class="input-group-btn" style="padding-top:2px;padding-left:10px;">
                                                    <button type='button' class="btn btn-danger delLocBtn"><i class="fa fa-trash"></i></button>
                                                </span>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input type="text" disabled value="" class="form-control zoneLocationLatDis">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" disabled value="" class="form-control zoneLocationLngDis">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="locSub">

                                </div>
                            </div>

                            

            <!-- package details cool-->
                   

             

         
                          

                            <div class="form-group">
                                <div class="col-sm-4 m-t-10 sm-m-t-10 pull-right text-right">
                                    <input type="hidden" name="fdata[id]" value="<?php echo $zones_data['_id']['$oid']; ?>">
                                    <button type='submit' class="btn btn-primary" id='btnSubmit'>Save Zone</button>
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

