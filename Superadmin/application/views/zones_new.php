<style>


    .paging_full_numbers{
        margin-right: 1%;
    }
    .dataTables_info {
        margin-left: 1%;
    }
    .table-responsive{
        overflow-x:hidden;
        overflow-y:hidden;
    }
    .radio input[type=radio], .radio-inline input[type=radio] {
        margin-left: 0px; 
    }
    .lastButton{
        margin-right:1.8%;
    }

    /*    .page-sidebar
        {
           display: none; 
        }*/

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}

    #addZoneModal .modal-dialog,
    #map_display .modal-dialog,
    #editZoneModal .modal-dialog {
        width: 90%;
    }

    /*    .modal-header,
        .modal-footer {
            color: white;
            background-color: grey;
        }*/

    /*    .modal-header,
        .modal-footer button {
            color: white;
            background-color: grey;
        }*/

    #addmodalmap,
    #mapPolygon,
    #editmodalmap {
        /*height: 600px;*/
        height: 80vh;
    }

    #zoneform label {
        margin-left: 12px;
    }

    /*    #zoneform .pointscontrols {
            width: 35%;
            margin: 5px;
            margin-top: 2px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }*/

    .btncontrols {
        margin: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        color: white;
        background-color: cornflowerblue;
    }

    /*#cities,*/
    #editnow {
        border: 1px solid transparent;
        border-radius: 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        color: white;
        background-color: darkgray;
    }

    .success {
        color: springgreen;
    }

    .error {
        color: red;
    }

    .waitmsg {
        display: inline;
        margin-left: 50%;

    }

    .modal .modal-body p {
        color: aliceblue;
    }

    .displayinline {
        display: inline;
    }


    /*------------for auto complete search box---------------------*/

    .controls {
        margin: 10px 0;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        border-radius: 5px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    #pac-input1 {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        border-radius: 5px;
    }

    #pac-input1:focus {
        border-color: #4d90fe;
        display: none;
    }


    .pac-container,.select2-drop {
        font-family: Roboto;
        z-index: 99999 !important;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #target {
        width: 345px;
    }
</style>
<style>
    .header{
        height:60px !important;
    }
    .header h3{
        margin:10px 0 !important;
    }
    .rating>.rated {
        color: #10cfbd;
    }
    .social-user-profile {
        width: 83px;
    }
    td a:before{
        color:transparent;
    }
    .DataTables_sort_wrapper {
        text-align: center;
    }
</style>
<!--<script src="<?= base_url() ?>theme/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js" type="text/javascript"></script>-->
<script src="https://maps.googleapis.com/maps/api/js?v=3&libraries=drawing,places&key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/javascript.util.min.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/jsts.min.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/wicket.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/wicket-gmap3.js"></script>
<script>
    //Surge Price should be either in decimal/Number


    var mapedit;
    var cities = <?= json_encode($cities); ?>;
    $(document).ready(function () {

        var table = $('#big_table1').dataTable();
        $('.zones').addClass('active');
        $('.zones').attr('src', '<?php echo base_url(); ?>/theme/icon/campaigns_on.png');
        $('#editzonesurge_price,#zonesurge_price').keypress('click', function (event) {

            return isNumber(event, this)

        });
//        $('#s2id_city_select').removeClass('full-width');

        $('#city_select').change(function () {

            table.fnFilter($("#city_select option:selected").attr('city'));
        });


    });
    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
                (charCode != 45 || $(element).val().indexOf('-') != -1) && // ???-??? CHECK MINUS, AND ONLY ONE.
                (charCode != 46 || $(element).val().indexOf('.') != -1) && // ???.??? CHECK DOT, AND ONLY ONE.
                (charCode < 48 || charCode > 57))
            return false;
        return true;
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
            return true
        } else {
            return false;
        }
    }

    function loadScript() {
//        var script = document.createElement("script");
//        script.src = "https://maps.googleapis.com/maps/api/js?libraries=drawing,places";//&callback=initMap";
//        document.body.appendChild(script);
    }
    window.onload = loadScript;

//-----------------------View Zones----------------------  
    var mapview = '';
    var datafromserver_view = null;
    var overlays_view = [];
    var infoWindow_view = [];
    var selectedCity_view = "";
    function viewzones() {
        $('#pac-input2').val('');
        selectedCity_view = "";
        /*ajax request to get all the details of polygon*/
        mapview = new google.maps.Map(document.getElementById('mapPolygon'), {
            center: {
                lat: 12.972442010578353
                , lng: 77.5909423828125
            }
            , zoom: 11
        });

        google.maps.event.addListenerOnce(mapview, 'idle', function () {
            google.maps.event.trigger(mapview, 'resize');
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                mapview.setCenter(pos);
            }, function () {
                console.log('error');
            });
        }

        $.ajax({
            dataType: "json",
            url: "<?= base_url() ?>index.php?/superadmin/shortHaul_zonesAPI",
            async: false,
            success: function (result) {
                datafromserver_view = result.data;
            }
        });
        $('#city_selection_view').trigger('change');


    }

    $(document).ready(function () {

        var table = $('#big_table1');
        $('.cs-loader').show();
        $('#city_select').hide();
        $('#tableWithSearch_wrapper1').hide();


        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        setTimeout(function () {
            var settings = {
                "autoWidth": true,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "columnDefs": [
                    {"width": "8%", "targets": 0}
                ],
                "fnInitComplete": function () {
                    table.show()
                    $('.cs-loader').hide()
                    searchInput.show()

                    $('#city_select').show()
                    $('#tableWithSearch_wrapper1').show()

                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback
                            });
                }

            };

            table.dataTable(settings);

            $('#search-table').keyup(function () {

                table.fnFilter($(this).val());
            });

        }, 1000);

        $('#city_selection_view').change(function ()
        {
            if (selectedCity_view != $("#city_selection_view option:selected").val()) {
                $('#pac-input2').val('');
                selectedCity_view = $('#city_selection_view').children(":selected").attr("city");
//                while (overlays_view[0]) {
//                    overlays_view.pop().setMap(null);
//                }
//                while (infoWindow_view[0]) {
//                    infoWindow_view.pop().setMap(null);
//                }
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    'address': selectedCity_view
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {

                        var latlng = {
                            lat: results[0].geometry.location.lat()
                            , lng: results[0].geometry.location.lng()
                        };
                        mapview.setCenter(latlng);
                    } else {
                        console.log("unable to center map");
                    }
                });
                for (i = 0; i < overlays_view.length; i++) {
                    overlays_view[i].setMap(null);
                }
                for (i = 0; i < infoWindow_view.length; i++) {
                    infoWindow_view[i].setMap(null);
                }
                overlays_view = [];
                infoWindow_view = [];
                drawzones_view(selectedCity_view);


            }
        });
        $('#pac-input2').focus(function () {
            var input;
            input = document.getElementById('pac-input2');

            var searchBox = new google.maps.places.SearchBox(input);
            //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            mapview.addListener('bounds_changed', function () {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();
                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function (marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    var lat = parseFloat(place.geometry.location.lat()).toFixed(6);
                    var lng = parseFloat(place.geometry.location.lng()).toFixed(6);
                    var city = "";
                    var flg = true;
                    $.each(cities, function (ind, val) {
                        if (flg) {
                            var d = calculateDistance(lat, lng, val.City_Lat, val.City_Long, 'K');
                            if (d < 30) {
                                city = val.City_Name;
                                flg = false;
                            }
                        }
                    });
                    selectedCity_view = city;
                    $('#city_selection_view option[value=' + city + ']').prop('selected', 'selected');
//                    $('#city_selection_view').select2();
                    for (i = 0; i < overlays_view.length; i++) {
                        overlays_view[i].setMap(null);
                    }
                    for (i = 0; i < infoWindow_view.length; i++) {
                        infoWindow_view[i].setMap(null);
                    }
                    overlays_view = [];
                    infoWindow_view = [];


                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                        map: mapview
                        , title: place.name
                        , position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });

                mapview.fitBounds(bounds);
                mapview.setZoom(13);
            });
            //map.setZoom(10);
        });
    });

    function drawzones_view(city) {
        var zone = [];
        for (var iZone = 0; iZone < datafromserver_view.length; iZone++) {
            if (datafromserver_view[iZone].city == city) {
                var polgonProperties = datafromserver_view[iZone].polygonProps;
                polgonProperties.zoneIndex = iZone; //to add the array index of the polygon to its properties in the json object received from server

                zone[iZone] = new google.maps.Polygon(polgonProperties);
                zone[iZone].setMap(mapview);

                overlays_view.push(zone[iZone]);

                var latLng = {lat: datafromserver_view[iZone].polygonProps.paths[0].lat, lng: datafromserver_view[iZone].polygonProps.paths[0].lng};
                var inf = new google.maps.InfoWindow;

                var Str = '<b>' + datafromserver_view[iZone].title + '</b>';

                inf.setContent(Str);
                inf.setPosition(latLng);
                inf.open(mapview);
                infoWindow_view.push(inf);
            }

        }
    }


//----------------addnewzone-----------------------------------
    var map;
    var datafromserver = null;
    var newPolygon = null;
    var overlays_add = [];
    var infoWindow_add = [];
    var selectedCity_add = "";
    var pnt_overlay_add = 0;
    var pnt_infwin_add = 0;
    var polygonCoordinates = [];
    var polygonCoordinates1 = [];
    var rectangle;
    var marker_add = "";
    var customerlatitude;
    var customerlongitude;

    function addNewZone() {
        $('#pac-input').val('');
        $('.errors').text('');
//        $('#city_selection_add option[value=""]').prop('selected','selected');
//        $('#city_selection_add').select2();
        selectedCity_add = "";

        /*ajax request to get all the details of polygon*/
        $.ajax({
            dataType: "json",
            url: "<?= base_url() ?>index.php?/superadmin/shortHaul_zonesAPI",
            async: false,
            success: function (result) {
                datafromserver = result.data;
            }
        });

        map = new google.maps.Map(document.getElementById('addmodalmap'), {
            center: {
                lat: 12.972442010578353
                , lng: 77.5909423828125
            }
            , zoom: 10
        });

        google.maps.event.addListenerOnce(map, 'idle', function () {
            google.maps.event.trigger(map, 'resize');
        });
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(pos);
            }, function () {
                console.log('error');
            });
        }

        //Map does not load in a modal window until it is resized
        google.maps.event.addListenerOnce(map, 'idle', function () {
            google.maps.event.trigger(map, 'resize');
        });

        //Properties for the new polygon to be drawn
        var polyOptions = {
            strokeWeight: 0
            , fillOpacity: 0.45
            , editable: true
            , draggable: true
        };

        //drawing manager is a tool to draw the polygon
        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON
            , drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER
                , drawingModes: [google.maps.drawing.OverlayType.POLYGON]
            }
            , polygonOptions: polyOptions
            , map: map
        });

        $("form").submit(function (event) {
            event.preventDefault();
        });

        $('#savezone').hide();
        $('#clearzone').hide();

        //To create and fill the points input boxes of the newly created polygon
        function fillPathsInput(polygon) {
            newPolygon = polygon;
            var len = polygon.getPath().getLength();
            var htmlStr = "";

            var newpoly = [];
            for (var i = 0; i < len; i++) {
                var latlngobj = {
                    "lat": polygon.getPath().getAt(i).lat()
                    , "lng": polygon.getPath().getAt(i).lng()
                };
                newpoly.push(latlngobj);
            }
            var newpolyProp = new google.maps.Polygon({
                "paths": newpoly,
                strokeColor: '#000000',
                strokeOpacity: 0.8,
                strokeWeight: 1,
                fillColor: '#00FF00',
                fillOpacity: 0.35
            });
            for (var iZone = 0; iZone < datafromserver.length; iZone++) {
                if (datafromserver[iZone].city == selectedCity_add) {
                    var polgonProperties = datafromserver[iZone].polygonProps;
                    var oldpolyProp = new google.maps.Polygon(polgonProperties);

                    var wkt = UseWicketToGoFromGooglePolysToWKT(newpolyProp, oldpolyProp);
                    if (UseJstsToTestForIntersection(wkt[0], wkt[1])) {
                        $('#clearzone').trigger('click');
                        alert("Do not Overlap Existing Zone.")
                        return;
                    }
                }
            }

            for (var i = 0; i < len; i++) {
                htmlStr += "<div class='row'><label class='form-control col-sm-2' style='width:17%;'>Point" + (i + 1) + " </label> <input type='number' id='p" + (i + 1) + "lat' value='" + polygon.getPath().getAt(i).lat() + "' class='pointscontrols  form-control col-sm-2' readonly style='width:40%;'><input type='number' id='p" + (i + 1) + "lng' value='" + polygon.getPath().getAt(i).lng() + "' class='pointscontrols form-control col-sm-2' readonly style='width:40%;'></div>";
            }
            $('#info').html(htmlStr);
            $('#savezone').show();
            $('#clearzone').show();
        }

        google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
            // Switch back to non-drawing mode after drawing a shape.
            drawingManager.setMap(null);

            drawingManager.setDrawingMode(null);

            fillPathsInput(polygon);

            google.maps.event.addListener(polygon.getPath(), 'set_at', function () {
                fillPathsInput(polygon);
            });

            google.maps.event.addListener(polygon.getPath(), 'insert_at', function () {
                fillPathsInput(polygon);
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
        clearFields();
    }
    function clearFields() {
//    alert();
        $('#zonecity').val("");
        $('#zonetitle').val("");
        $('#zonesurge_price').val("");
        $('#info').html("");
        $('#savezone').hide();
        $('#clearzone').hide();
        $('#pac-input').val('');
        $('#city_selection_add').prop('selectedIndex', 0);
//        $('#city_selection_add').select2();
        $('#city_selection_add').val('');
        selectedCity_add = "";
        polygonCoordinates.splice(0, polygonCoordinates.length);
        newPolygon = null;
    }
    $(document).ready(function () {
        $('#clearzone').click(function (e) {
            $('.errors').text('');
            rectangle.setMap(null);
            drawingManager.setMap(map);
            polygonCoordinates.splice(0, polygonCoordinates.length);
            newPolygon = null;
            $('#info').html('');
            $('#savezone').hide();
            $('#clearzone').hide();
        });

        //To save the zone details in the database
        $('#savezone').click(function (e) {

            $('.errors').text('');
            //            alert($('#city_selection_add').val());

            if ($('#city_selection_add').val() == '#' || $('#city_selection_add').val() == null)
            {

                $('#cityErr').text('Please select a city');
            } else if ($('#zonetitle').val() == '' || $('#zonetitle').val() == null)
            {
                $('#titleErr').text('Please enter title for zone');
            }
//             else if ( $('#preferredStore').val() == '' || $('#preferredStore').val() == null || $('#preferredStore').val() == 0)
//            {
//                $('#preferredStoreErr').text('please select the store');
//            } 
            else if ($('#city_selection_add').val() != "" && $('#zonetitle').val() != "") {

                var len = newPolygon.getPath().getLength();

                for (var i = 0; i < len; i++) {
                    var latlngobj = {
                        "lat": newPolygon.getPath().getAt(i).lat()
                        , "lng": newPolygon.getPath().getAt(i).lng()
                    };
                    polygonCoordinates.push(latlngobj);
                }

                //changed Done 08-05-2016
                var coordinates1 = [];
                for (var i = 0; i < len; i++) {
                    coordinates1.push([newPolygon.getPath().getAt(i).lng(), newPolygon.getPath().getAt(i).lat()]);
                }

                coordinates1.push(coordinates1[0]);
                //                alert(JSON.stringify(coordinates1));

                polygonCoordinates1.push(coordinates1);



                var cl = "#" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0);
                var polygonProperties = {
                    "paths": polygonCoordinates
                    , "strokeColor": cl
                    , "strokeOpacity": 0.2
                    , "strokeWeight": 2
                    , "fillColor": cl
                    , "fillOpacity": 0.35
                    , "draggable": false
                    , "editable": false
                }

                //changed Done 08-05-2016
                var polygonProperties1 = {
                    "type": "Polygon",
                    "coordinates": polygonCoordinates1

                }


                var data = {
                    "city_ID": $('#city_selection_add').val(),
                    "city": $('#city_selection_add').children(":selected").attr("city"),
                    "cityName": $('#city_selection_add').children(":selected").attr("cityName"),
                    "currency": $('#city_selection_add').children(":selected").attr("currency"),
                    "currencySymbol": $('#city_selection_add').children(":selected").attr("currencySymbol"),
                    "mileageMetric": $('#city_selection_add').children(":selected").attr("mileageMetric"),
                    "weightMetric": $('#city_selection_add').children(":selected").attr("weightMetric"),
                    "title": $('#zonetitle').val(),
//                    "preferredStoreId": $('#preferredStore option:selected').attr('data-id'),
//                    "preferredStoreName": $('#preferredStore option:selected').attr('data-name'),
                    "polygonProps": polygonProperties,
                    "polygons": polygonProperties1
                }
                $('#addmsg').text("please wait..");

                //To update the zone details
                $.ajax({
                    url: '<?= base_url() ?>index.php?/superadmin/shortHaul_zonesAPI'
                    , dataType: "json"
                    , type: "POST"
                    , contentType: 'application/json; charset=utf-8'
                    , data: JSON.stringify(data)
                    , async: true
                    , success: function (data) {
                        if (data.status == 'success') {
                            window.location.reload(false);
//                            $('#addZoneModal').modal('toggle');
//    //                            $('#editmsg').text("zone updated successfuly").toggleClass("success");
//                            var count = 1;
//                            var s='';
//                            $.each(polygonProperties.paths, function(ind,val){
//
//                                s += 'P' + count + "(" + val['lat'] + "," + val['lng']+ ")";
//                                s += " ";
//                                if ((count % 2) == 0)
//                                    s += ' <br>';
//                                count++;
//                            });
//                            
//                         
//                            s +="<input type='hidden' id='zone_"+data.data._id.$id+"'>";
//                           var id = data.data._id.$id;
//                            
//                            var table = $('#big_table1').DataTable();
//                            table.row.add([
//                                table.page.info().recordsTotal + 1,
//                               $('#city_selection_add').children(":selected").attr("city"),
//                                $('#zonetitle').val(),
////                                ($('input[name=charge_type_add]:checked').val()=='SUBCHARGE')?"Sub Charge":"Surge Charge",
////                                $('#zonesurge_price').val(),
//                                s,
//                               "<a href='<?php echo base_url() . "index.php?/superadmin/zone_pricing/"; ?>"+data.city_ID+'/'+data.id.$id+"' class='btn btn-info btn-cons btn-animated from-top fa fa-dollar'  style='padding: 0px 10px;font-family: sans-serif;font-size: 10px;color: #fff;text-decoration: none;width: 108px;text-align:center;'><span>Set Zonal Price</span></a>",
//                                "<input type='checkbox' class='checkbox' name='checkbox' value='"+data.id.$id+"'>"
//                            ]).draw();
//                            clearFields();
                        } else if (data.status == 'error') {
                            $('#addmsg').text("unable to update please try again!").addClass("error");
                            clearFields();
                        }
                    }
                    , error: function (xhr) {
                        alert('error');
                    }
                });
            }
        });

        $('#city_selection_add').change(function ()
        {


//            if(selectedCity_add != $("#city_selection_view option:selected").val()){
            console.log('here');
            $('#pac-input').val('');
            var customerlat;
            var customerlong;
            var city;
            city = $('#city_selection_add').children(":selected").attr("city").trim();

            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': '' + city}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    customerlat = results[0].geometry.location.lat()
                    customerlong = results[0].geometry.location.lng();



                    map.setCenter(new google.maps.LatLng(customerlat, customerlong));
                    if (marker_add != "")
                    {
                        marker_add.setMap(null);
                        marker_add = "";
                    }
                    marker_add = new google.maps.Marker({
                        map: map
                        , title: selectedCity_add
                        , position: new google.maps.LatLng(customerlat, customerlong)
                    });
                    map.setCenter(marker_add.getPosition());
                    selectedCity_add = $("#city_selection_add option:selected").val();

                    for (i = 0; i < pnt_overlay_add; i++) {
                        overlays_add[i].setMap(null);
                    }
                    for (i = 0; i < pnt_infwin_add; i++) {
                        infoWindow_add[i].setMap(null);
                    }
                    overlays_add = [];
                    infoWindow_add = [];
                    pnt_overlay_add = 0;
                    pnt_infwin_add = 0;

                    drawZones_add(city);

                 customerlatitude = customerlat;
                customerlongitude = customerlong;
                } else {
                    alert("Something got wrong " + status);
                }
            });


//            }
        });

        $('#pac-input').focus(function () {
            var input;
            input = document.getElementById('pac-input');

            var searchBox = new google.maps.places.SearchBox(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function () {
                searchBox.setBounds(map.getBounds());
            });

            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();
                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                if (marker_add != "")
                {
                    marker_add.setMap(null);
                    marker_add = "";
                }
                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    var lat = parseFloat(place.geometry.location.lat()).toFixed(6);
                    var lng = parseFloat(place.geometry.location.lng()).toFixed(6);
                    var city = "#";
                    var flg = true;
                    $.each(cities, function (ind, val) {
                        if (flg) {
                            var d = calculateDistance(lat, lng, val.City_Lat, val.City_Long, 'K');
                            if (d < 30) {
                                city = val.City_Name;
                                flg = false;
                            }
                        }
                    });
                    selectedCity_add = city;
                    $('#city_selection_add option[value=' + city + ']').prop('selected', 'selected');
//                    $('#city_selection_add').select2();
                    for (i = 0; i < pnt_overlay_add; i++) {
                        overlays_add[i].setMap(null);
                    }
                    for (i = 0; i < pnt_infwin_add; i++) {
                        infoWindow_add[i].setMap(null);
                    }
                    overlays_add = [];
                    infoWindow_add = [];
                    pnt_overlay_add = 0;
                    pnt_infwin_add = 0;

                    drawZones_add(city);
                    // Create a marker for each place.
                    marker_add = new google.maps.Marker({
                        map: map
                        , title: place.name
                        , position: place.geometry.location
                    });
                    map.setCenter(marker_add.getPosition());
                });
            });
        });
    });

    //plots the zones or polygons on the map based on the selected city from dropdown
    function drawZones_add(selectedCity) {


        var zone = [];
        for (var iZone = 0; iZone < datafromserver.length; iZone++) {
            if (datafromserver[iZone].city == selectedCity) {

                var polgonProperties = datafromserver[iZone].polygonProps;
                polgonProperties.zoneIndex = iZone; //to add the array index of the polygon to its properties in the json object received from server

                overlays_add[pnt_overlay_add] = new google.maps.Polygon(polgonProperties);
                overlays_add[pnt_overlay_add].setMap(map);

                pnt_overlay_add++;

                var latLng = {lat: datafromserver[iZone].polygonProps.paths[0].lat, lng: datafromserver[iZone].polygonProps.paths[0].lng};
                infoWindow_add[pnt_infwin_add] = new google.maps.InfoWindow;

                var Str = '<b>' + datafromserver[iZone].title + '</b>';

                infoWindow_add[pnt_infwin_add].setContent(Str);
                infoWindow_add[pnt_infwin_add].setPosition(latLng);
                infoWindow_add[pnt_infwin_add].open(map);
                pnt_infwin_add++;
            }
        }

    }


    //function to sort lat long
    function calculateDistance(lat1, lon1, lat2, lon2, unit) {
        var radlat1 = Math.PI * lat1 / 180
        var radlat2 = Math.PI * lat2 / 180
        var radlon1 = Math.PI * lon1 / 180
        var radlon2 = Math.PI * lon2 / 180
        var theta = lon1 - lon2
        var radtheta = Math.PI * theta / 180
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        dist = Math.acos(dist)
        dist = dist * 180 / Math.PI
        dist = dist * 60 * 1.1515
        if (unit == "K") {
            dist = dist * 1.609344
        }
        if (unit == "N") {
            dist = dist * 0.8684
        }
        return dist
    }
    //end of sorting



//---------------edit zone details--------------------------------

    var newPolygon_edit = null;
    var datafromserver_edit = null;
    var overlays_edit = [];
    var infoWindow_edit = [];
    var pnt_overlay = 0;
    var pnt_infwin = 0;
    var selectedCity_edit = "";
    var polygonCoordinates_edit = [];
    var polygonCoordinates1_edit = [];
    var old_polygon = "";
    var marker_edit = "";
    function loadExistingZones() {

        var selectedZone = $('.checkbox:checked').map(function () {
            return this.value;
        }).get();


        if (selectedZone.length == 0)
        {
            $('#alertForNoneSelected').modal('show');
            $("#err").text('Please choose one zone to edit');
            return false;
        } else if (selectedZone.length > 1)
        {
            $('#alertForNoneSelected').modal('show');
            $("#err").text('Please choose only one zone to edit');
            return false;
        } else {

            $('#editZoneModal1').trigger('click');
            $('#pac-input1').val('');
            selectedCity_edit = "";
            old_polygon = "";
            newPolygon_edit = null;
            //creating a map 
            mapedit = new google.maps.Map(document.getElementById('editmodalmap'), {
                center: {
                    lat: 12.972442010578353
                    , lng: 77.5909423828125
                }
                , zoom: 11
            });

            //Map does not load in a modal window until it is resized
            google.maps.event.addListenerOnce(mapedit, 'idle', function () {
                google.maps.event.trigger(mapedit, 'resize');
            });

            /*ajax request to get all the details of polygon*/
            $.ajax({
                dataType: "json",
                type: 'POST',
                url: "<?= base_url() ?>index.php?/superadmin/getCityZones",
                data: {'city_id': $('.checkbox:checked').val()},
                async: false,
                success: function (result) {
                    datafromserver_edit = result.data;
                }
            });

            var uniqueCities = $.unique(datafromserver_edit.map(function (d) {
                return d.city;
            }));

            var citiesslthtml = "";

            for (var index in uniqueCities) {
                citiesslthtml += "<option value=\"" + uniqueCities[index] + "\">" + uniqueCities[index] + "</option>";
            }
            $("#cities").html(citiesslthtml);
            //            $("#cities").select2();

            $("#cities").trigger('change');

            if (selectedZone == '')
                $("#cities").trigger('change');

//                                    $('#cities option[value='+response.city+']').prop('selected','selected');
            drawZones_editSpecific($('.checkbox:checked').val());


            $("form").submit(function (event) {
                event.preventDefault();
            });

            $('#saveeditzone').hide();
            $('#deletezone').hide();
            $('#cancelEditZoneModal').hide();
            clearFields_edit();
        }
        //To refresh the page after editing the zone
//        $('#editZoneModal').on('hidden.bs.modal', function () {
//            $('.select2').select2("close");
//        });
    }
    function clearFields_edit() {
//            loadExistingZones();
//        old_polygon = "";
//        newPolygon_edit = null;
//        $('#editzonecity').val('');
        $('#editzonetitle').val('');
        $('#editzonesurge_price').val('');
        $('#pointsinfo').html('');
    }
    //plots the zones or polygons on the map based on the selected city from dropdown
    function drawZones_edit(selectedCity) {
        var zone = [];
        clearFields_edit();
        for (var iZone = 0; iZone < datafromserver_edit.length; iZone++) {
            if (datafromserver_edit[iZone].city == selectedCity) {

                var polgonProperties = datafromserver_edit[iZone].polygonProps;
                polgonProperties.zoneIndex = iZone; //to add the array index of the polygon to its properties in the json object received from server

                overlays_edit[pnt_overlay] = new google.maps.Polygon(polgonProperties);
                overlays_edit[pnt_overlay].setMap(mapedit);


                google.maps.event.addListener(overlays_edit[pnt_overlay], 'click', function (event) {
                    editZoneDetails(this);

                });
                pnt_overlay++;

                var latLng = {lat: datafromserver_edit[iZone].polygonProps.paths[0].lat, lng: datafromserver_edit[iZone].polygonProps.paths[0].lng};
                infoWindow_edit[pnt_infwin] = new google.maps.InfoWindow;

                var Str = '<b>' + datafromserver_edit[iZone].title + '</b>';

                infoWindow_edit[pnt_infwin].setContent(Str);
                infoWindow_edit[pnt_infwin].setPosition(latLng);
                infoWindow_edit[pnt_infwin].open(mapedit);
                pnt_infwin++;
            }
        }

    }

    //plots the zones or polygons on the map based on the selected city from dropdown
    function drawZones_editSpecific(id) {

        var zone = [];
        clearFields_edit();


        for (var iZone = 0; iZone < datafromserver_edit.length; iZone++) {


            if (datafromserver_edit[iZone]._id.$oid == id) {

                var polgonProperties = datafromserver_edit[iZone].polygonProps;
                polgonProperties.zoneIndex = iZone; //to add the array index of the polygon to its properties in the json object received from server

                overlays_edit[pnt_overlay] = new google.maps.Polygon(polgonProperties);
                overlays_edit[pnt_overlay].setMap(mapedit);


//                google.maps.event.addListener(overlays_edit[pnt_overlay], 'click', function (event) {
                editZoneDetails(overlays_edit[pnt_overlay]);

//                });
                pnt_overlay++;

                var latLng = {lat: datafromserver_edit[iZone].polygonProps.paths[0].lat, lng: datafromserver_edit[iZone].polygonProps.paths[0].lng};
                infoWindow_edit[pnt_infwin] = new google.maps.InfoWindow;

                var Str = '<b>' + datafromserver_edit[iZone].title + '</b>';

                infoWindow_edit[pnt_infwin].setContent(Str);
                infoWindow_edit[pnt_infwin].setPosition(latLng);
                infoWindow_edit[pnt_infwin].open(mapedit);
                pnt_infwin++;
            }

        }

    }



    function editZoneDetails(polygon) {
        if ((old_polygon || old_polygon == "0") && old_polygon == polygon.zoneIndex) {
            newPolygon_edit.setPaths(datafromserver_edit[old_polygon].polygonProps.paths);
            newPolygon_edit.setEditable(false);
            newPolygon_edit.setDraggable(false);
            clearFields_edit();
            return;
        }
        if ((old_polygon || old_polygon == "0") && old_polygon != polygon.zoneIndex) {
            newPolygon_edit.setPaths(datafromserver_edit[old_polygon].polygonProps.paths);
        }
        if (newPolygon_edit) {
            newPolygon_edit.setEditable(false);
            newPolygon_edit.setDraggable(false);
        }
        old_polygon = polygon.zoneIndex;
        polygon.setEditable(true);
        polygon.setDraggable(true);

        $('#editzonecity').val(datafromserver_edit[polygon.zoneIndex].city);
        if (datafromserver_edit[polygon.zoneIndex].charge_type == 'SURGECHARGE')
            $('#charge_surge_edit').prop("checked", true);
        else
            $('#charge_sub_edit').prop("checked", true);
        $('#editzonetitle').val(datafromserver_edit[polygon.zoneIndex].title);
        $('#editzonesurge_price').val(datafromserver_edit[polygon.zoneIndex].surge_price);
        fillPathsInput_edit(polygon);

        google.maps.event.addListener(polygon.getPath(), 'set_at', function () {
            fillPathsInput_edit(polygon);
        });

        google.maps.event.addListener(polygon.getPath(), 'insert_at', function () {
            fillPathsInput_edit(polygon);
        });

        google.maps.event.addListener(polygon, "mouseout", function () {
            polygon.setDraggable(true);
        });

        $('#saveeditzone').show();
        $('#deletezone').show();
        $('#cancelEditZoneModal').show();
    }

    //To create and fill the points input boxes of the edited polygon
    function fillPathsInput_edit(polygon) {
        newPolygon_edit = polygon;
        var len = polygon.getPath().getLength();
        var htmlStr = "";

        for (var i = 0; i < len; i++) {
            htmlStr += "<div class='row'><label class='form-control col-sm-2' style='width:16%;'>Point" + (i + 1) + " </label> <input type='number' id='p" + (i + 1) + "lat' value='" + polygon.getPath().getAt(i).lat() + "' class='pointscontrols form-control col-sm-2' readonly style='width:40%;'><input type='number' id='p" + (i + 1) + "lng' value='" + polygon.getPath().getAt(i).lng() + "' class='pointscontrols form-control col-sm-2' readonly style='width:40%;'></div>";
        }

        $('#pointsinfo').html(htmlStr);


    }
    $(document).ready(function ()
    {


        //To save the zone details in the database
        $('#saveeditzone').click(function () {

            var selectedZone = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if ($('#editzonetitle').val() == '' || $('#editzonetitle').val() == null)
            {
                $('#title_e_Err').text('Please enter zone title');
            } else if ($('#editzonecity').val() != "" && $('#editzonetitle').val() != "") {
                var len = newPolygon_edit.getPath().getLength();
                polygonCoordinates_edit = [];
                polygonCoordinates1_edit = [];
                for (var i = 0; i < len; i++) {
                    var latlngobj = {
                        "lat": newPolygon_edit.getPath().getAt(i).lat()
                        , "lng": newPolygon_edit.getPath().getAt(i).lng()
                    };
                    polygonCoordinates_edit.push(latlngobj);
                }

                var coordinates1 = [];
                for (var i = 0; i < len; i++) {
                    coordinates1.push([newPolygon_edit.getPath().getAt(i).lng(), newPolygon_edit.getPath().getAt(i).lat()]);
                }

                coordinates1.push(coordinates1[0]);

                polygonCoordinates1_edit.push(coordinates1);

                //changed Done 08-05-2016
                var polygonProperties1 = {
                    "type": "Polygon",
                    "coordinates": polygonCoordinates1_edit

                }
                var cl = "#" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0);

                var polygonProperties = {
                    "paths": polygonCoordinates_edit
                    , "strokeColor": cl
                    , "strokeOpacity": 0.2
                    , "strokeWeight": 2
                    , "fillColor": cl
                    , "fillOpacity": 0.35
                    , "draggable": false
                    , "editable": false
                };

                var newpolyProp = new google.maps.Polygon(polygonProperties);
                for (var iZone = 0; iZone < datafromserver_edit.length; iZone++) {
                    if (datafromserver_edit[iZone].city == selectedCity_edit && newPolygon_edit.zoneIndex != iZone) {
                        var oldpolyProp = new google.maps.Polygon(datafromserver_edit[iZone].polygonProps);

                        var wkt = UseWicketToGoFromGooglePolysToWKT(newpolyProp, oldpolyProp);

                        if (UseJstsToTestForIntersection(wkt[0], wkt[1])) {
                            newPolygon_edit.setPaths(datafromserver_edit[old_polygon].polygonProps.paths);
                            newPolygon_edit.setDraggable(false);
                            newPolygon_edit.setEditable(false);

                            alert("Do not Overlap Existing Zone.");
                            editZoneDetails(newPolygon_edit);
                            return;
                        }
                    }
                }
                var zid = datafromserver_edit[newPolygon_edit.zoneIndex]._id.$oid;
                var data = {
                    "id": datafromserver_edit[newPolygon_edit.zoneIndex]._id.$oid
                    , "details": {
                        'title': $('#editzonetitle').val(),
                        "polygonProps": polygonProperties,
                        "polygons": polygonProperties1     //changed Done 08-05-2016
                    }
                }

                $('#editmsg').text("please wait..")

                //To update the zone details
                $.ajax({
                    url: '<?= base_url() ?>index.php?/superadmin/shortHaul_zonesAPI'
                    , dataType: "json"
                    , type: "PUT"
                    , contentType: 'application/json; charset=utf-8'
                    , data: JSON.stringify(data)
                    , async: true
                    , success: function (data) {
                        if (data.status == 'success') {
                            window.location.reload(false);
//                            var count = 1;
//                            var s='';
//                            $.each(polygonProperties.paths, function(ind,val){
//
//                                s += 'P' + count + "(" + val['lat'] + "," + val['lng']+ ")";
//                                s += " ";
//                                if ((count % 2) == 0)
//                                    s += ' <br>';
//                                count++;
//                            });
//                            s +="<input type='hidden' id='zone_"+String(zid)+"'>";
//                            $('#zone_'+zid).closest('tr').find('td:nth-child(2)').html($('#cities').val());
//                            $('#zone_'+zid).closest('tr').find('td:nth-child(3)').html($('#editzonetitle').val());
//
//                            $('#zone_'+zid).closest('tr').find('td:nth-child(4)').html(s);
//                            $('#zone_'+zid).closest('tr').find('td:nth-child(4)').html(s);
//                             $('#zone_'+zid).closest('tr').find('td:nth-child(5)').html('<input type=checkbox class=checkbox name=checkbox value='+selectedZone.toString()+'>');
//                            $('#editZoneModal').modal('toggle');
//                            clearFields_edit();
                        } else if (data.status == 'error') {
                            $('#editmsg').text("unable to update!").addClass("error");
                            clearFields_edit();
                        }
                    }
                    , error: function (xhr) {
                        alert('error');
                    }
                });
            }

        });

        //To delete the zone 
        $('#deletezone').click(function () {
            var confirmDelete = confirm("Are you sure you want to delete this zone?");
            if (confirmDelete == true) {
                var zid = datafromserver_edit[newPolygon_edit.zoneIndex]._id.$id;
                var deleteZoneId = {
                    "id": datafromserver_edit[newPolygon_edit.zoneIndex]._id.$id
                };

                $('#editmsg').text("please wait..")

                $.ajax({
                    url: '<?= base_url() ?>index.php?/superadmin/shortHaul_zonesAPI'
                    , dataType: "json"
                    , type: "DELETE"
                    , contentType: 'application/json; charset=utf-8'
                    , data: JSON.stringify(deleteZoneId)
                    , async: true
                    , success: function (data) {
                        if (data.status == 'success') {
                            $('#editZoneModal').modal('toggle');
                            var table = $('#big_table1').DataTable();
                            table.row($('#zone_' + zid).closest('tr')).remove().draw();
                            clearFields_edit();
                        } else if (data.status == 'error') {
                            $('#editmsg').text("unable to delete!").addClass("error");
                            clearFields_edit();
                        }
                    }
                    , error: function (xhr) {
                        alert('error');
                    }
                });
            }

        });
        $('#cities').change(function ()
        {
            $('#pac-input1').val('');
            if (selectedCity_edit != $("#cities option:selected").val()) {
                clearFields_edit();


                selectedCity_edit = $("#cities option:selected").val();
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    'address': selectedCity_edit
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {

                        var latlng = {
                            lat: results[0].geometry.location.lat()
                            , lng: results[0].geometry.location.lng()
                        };
                        mapedit.setCenter(latlng);
                        if (marker_edit != "")
                        {
                            marker_edit.setMap(null);
                            marker_edit = "";
                        }
                        marker_edit = new google.maps.Marker({
                            map: mapedit
                            , title: selectedCity_add
                            , position: new google.maps.LatLng(customerlatitude, customerlongitude)
                        });
                    } else {
                        console.log("unable to center map");
                    }
                });
                var i = 0;
                for (i = 0; i < pnt_overlay; i++) {
                    overlays_edit[i].setMap(null);
                }
                for (i = 0; i < pnt_infwin; i++) {
                    infoWindow_edit[i].setMap(null);
                }
                overlays = [];
                infoWindow_edit = [];
                pnt_overlay = 0;
                pnt_infwin = 0;
                drawZones_edit(selectedCity_edit);
            }
        });

        $('#pac-input1').focus(function () {
            var input;
            input = document.getElementById('pac-input1');

            var searchBox = new google.maps.places.SearchBox(input);

            mapedit.addListener('bounds_changed', function () {
                searchBox.setBounds(mapedit.getBounds());
            });

            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();
                if (places.length == 0) {
                    return;
                }
                if (marker_edit != "")
                {
                    marker_edit.setMap(null);
                    marker_edit = "";
                }
                // Clear out the old markers.
                markers.forEach(function (marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    var lat = parseFloat(place.geometry.location.lat()).toFixed(6);
                    var lng = parseFloat(place.geometry.location.lng()).toFixed(6);
                    var city = "";
                    var flg = true;
                    $.each(cities, function (ind, val) {
                        if (flg) {
                            var d = calculateDistance(lat, lng, val.City_Lat, val.City_Long, 'K');
                            if (d < 30) {
                                city = val.City_Name;
                                flg = false;
                            }
                        }
                    });
                    console.log(city);
                    selectedCity_edit = city;
                    $('#cities option[value=' + city + ']').prop('selected', 'selected');
                    $('#cities').select2();
                    var i = 0;
                    for (i = 0; i < pnt_overlay; i++) {
                        overlays_edit[i].setMap(null);
                    }
                    for (i = 0; i < pnt_infwin; i++) {
                        infoWindow_edit[i].setMap(null);
                    }
                    overlays = [];
                    infoWindow_edit = [];
                    pnt_overlay = 0;
                    pnt_infwin = 0;

                    drawZones_edit(city);

                    // Create a marker for each place.
                    marker_edit = new google.maps.Marker({
                        map: mapedit
                        , title: place.name
                        , position: place.geometry.location
                    });
                    map.setCenter(marker_edit.getPosition());
                });
            });
        });

        $('#cancel_delete').click(function ()
        {
            $('.close').trigger('click');
            $('.checkbox:checked').each(function (i) {
                $(this).removeAttr('checked');
            });
        });

        //Delete zones
        $("#chekdel").click(function () {

            $("#err").text("");
            var val = [];
            $('.checkbox:checked').each(function () {
                val.push($(this).attr('data-id'));
            })

            if (val.length > 0) {

                var size = $('input[name=stickup_toggler]:checked').val()

                $('#deleteZone').modal('show')

                $(".error-box").text('Do you want to delete this zone?');

                $("#yesdelete").click(function () {

                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/deleteShortHaul",
                        type: "POST",
                        data: {zone_id: val},
                        success: function (result) {

                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });

                            $(".close").trigger('click');
                        }
                    });
                });
            } else {
                $('#alertForNoneSelected').modal('show');
                $("#err").text('Please choose zone to delete');
            }

        });
        $('#add').click(function(){
         var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if(val.length == 0){
        $('#addZoneModal').modal('show');
    }else{
        $('#alertForNoneSelected1').modal('show')
        $('#errZone').text("Invalid Selection")
    }
        
        });

        $('#addPreferredZone').click(function () {
            var val = $('.zonesCheckBox:checked').attr('data-id');

            if (val == '' || val == null) {
                $('#alertForNoneSelected1').modal('show');
                $("#errZone").text('Please choose only one zone to add preferred store');
            } else {

                $('#preferredStoreList').load('<?php echo base_url(); ?>index.php?/superadmin/getStoreZones', {val: val});
                $('#preferredZoneModal').modal('show');

                $('#setZone').click(function () {
                    var preferredStoreId = $('#preferredStoreList option:selected').val();
                    var preferredStoreName = $('#preferredStoreList option:selected').attr('data-name');

                    $.ajax({
                        url: '<?= base_url() ?>index.php?/superadmin/updateZone',
                        dataType: "json",
                        type: "POST",
                        data: {val: val, preferredStoreId: preferredStoreId, preferredStoreName: preferredStoreName},
                        success: function (data) {
                            window.location.reload(false);
                            $('#preferredZoneModal').modal('hide');
                        },
                        error: function (xhr) {
                            alert('error');
                        }
                    });
                });
            }

        });



    });
</script> 



<div class="page-content-wrapper"style="">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
            <strong>ZONES</strong>
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">


                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  bg-white whenclicked">

                        <!--<div class="pull-right m-t-10 lastButton"><button data-toggle="modal" class="btn btn-warning btn-cons" data-target="#map_display" onclick="viewzones()">--> 
                                <!--View </button></div>-->  
                        <div class="pull-right m-t-10"><button  class="btn btn-danger" id="chekdel"> 
                                Delete</button></div>
                        <div class="pull-right m-t-10"><button data-toggle="modal" class="btn btn-info" onclick="loadExistingZones()"> 
                                Edit</button></div>
                        <button data-toggle="modal" class="btn btn-primary" data-target="#editZoneModal" style="display:none;" id="editZoneModal1"> 
                        </button>
                                <div class="pull-right m-t-10"><button data-toggle="modal" class="btn btn-primary btn-cons"  id="add" onclick="addNewZone(12.972442010578353, 77.5909423828125)"> 
                                Add</button></div>
                        <!--                        <div class="pull-right m-t-10"><button data-toggle="modal" class="btn btn-success btn-cons" id="addPreferredZone" > 
                                                        Preferred Store</button></div>-->



                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="cs-loader">
                                        <div class="cs-loader-inner" >
                                            <label class="loaderPoint" style="color:#10cfbd">???</label>
                                            <label class="loaderPoint" style="color:red">???</label>
                                            <label class="loaderPoint" style="color:#FFD119">???</label>
                                            <label class="loaderPoint" style="color:#4d90fe">???</label>
                                            <label class="loaderPoint" style="color:palevioletred">???</label>
                                        </div>
                                    </div>

                                    <div>

                                        <div class="form-group " >

                                            <div class="col-sm-8" style="width: auto;
                                                 paddingng: 0px;
                                                 margin-bottom: 10px;margin-left: -0.7%" >
                                                <select class="form-control" id="city_select" style="background-color:gainsboro;height:30px;font-size:11px;display: none;" >
                                                    <option value="" city="">Select City</option>
                                                    <?php
                                                    foreach ($citiesNew as $city) {
                                                        ?>
                                                        <option value="<?php echo $city['cityId']; ?>" city="<?php echo $city['cityName']; ?>" data-id="" lat="" lng=""><?php echo $city['cityName']; ?></option>    
                                                        <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>


                                    </div>

                                    <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search " style="display: none;"> </div>

                                </div>
                                &nbsp;
                                <div class="panel-body" >
                                    <div id="tableWithSearch_wrapper1" class="dataTables_wrapper no-footer" style="display: none;">
                                        <div class="table-responsive">
                                            <table id="big_table1" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="big_table_info" style="">
                                                <thead>
                                                    <tr style= "font-size:10px"role="row">
                                                        <th class="sorting ui-state-default sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 8%;" aria-sort="ascending">
                                                            <div class="DataTables_sort_wrapper">Sl No.<span class="DataTables_sort_icon css_right ui-icon ui-icon-triangle-1-n"></span></div>
                                                        </th><th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width:12%;"><div class="DataTables_sort_wrapper">CITY<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                        <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 12%;"><div class="DataTables_sort_wrapper">TITLE<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                        <!--<th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 13px;"><div class="DataTables_sort_wrapper">CHARGE TYPE<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>-->
                                                        <!--<th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 10%;"><div class="DataTables_sort_wrapper">SURGE FACTOR<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>-->
                                                        <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 40%;"><div class="DataTables_sort_wrapper">POLYGON POINTS<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                        <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 5%;"><div class="DataTables_sort_wrapper">ZONAL PRICE<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                        <!--<th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 5%;"><div class="DataTables_sort_wrapper">PREFERRED STORE<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>-->
                                                        <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 5%;"><div class="DataTables_sort_wrapper">SELECT<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_zone">
                                                    <?php
                                                    $start = 1;
                                                    foreach ($zones_data as $data) {
                                                        ?>

                                                        <tr role="row" class="odd">
                                                            <td><?php echo $start++; ?></td>
                                                            <td><?php echo $data['city']; ?></td>
                                                            <td><?php echo $data['title']; ?></td>

                                                            <td><?php
                                                                $count = 1;
                                                                foreach ($data['polygonProps']['paths'] as $points) {

                                                                    echo 'P' . $count . "(" . ucwords($points['lat']) . "," . ucwords($points['lng']) . ")";
                                                                    echo " ";
                                                                    if (($count % 2) == 0)
                                                                        echo ' <br>';
                                                                    $count++;
                                                                }
                                                                ?>
                                                                <input type="hidden" id="zone_<?= $data['_id']['$oid'] ?>"/>
                                                            </td>
                                                            <td><a href="<?php echo base_url() . 'index.php?/superadmin/zone_pricing/' . $data['city_ID'] . '/' . $data['_id']['$oid']; ?>" class="btn btn-info btn-cons btn-animated from-top fa fa-dollar" id="zone_585cd4a65b45401325268a88" style="padding: 0px 10px;font-family: sans-serif;font-size: 10px;color: #fff;text-decoration: none;width: 108px;text-align:center;"><span>SET PRICE</span></a></td>

                                                                    <!--<td><?php // echo $data['preferredStoreName'];   ?></td>-->
                                                            <td><input type="checkbox" class="checkbox zonesCheckBox" name="checkbox" data-id="<?php echo $data['_id']['$oid'] ?>" value="<?php echo $data['city_ID'] ?>"/></td>
                                                    <input type="hidden" id="selected_zone">

                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>  
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--                             END PANEL -->
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

<!--Add Zone Modal -->
<div class="modal fade fill-in" id="addZoneModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >ADD</span> 
            </div>
            <div class="modal-body">

                <div class="container-fluid bg-white">
                    <div class="row">
                        <input id="pac-input" class="controls" type="text" placeholder="Search Location"  style="position: absolute;width: 15.5em;margin-left: 130px;z-index: 1050;">
                        <!--onfocus="initAutocomplete(1)"-->
                        <div id="addmodalmap" class="col-md-8 col-sm-12">
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <form id="zoneform" data-parsley-validate="" class="form-horizontal form-label-left">

                                <div class="form-group">
                                    <label for="zonecity" class="control-label col-md-3 col-sm-3">City</label>
                                    <div class="col-md-6 col-sm-6"> 

                                        <select  class="form-control" id="city_selection_add" >
                                            <option value="#">Select</option>
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
                                    </div>
                                    <div class="col-sm-2 errors" id="cityErr"> </div>
                                </div>



                                <div class="form-group">
                                    <label for="zonetitle" class="control-label col-md-3 col-sm-3">Title</label>
                                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                                        <input type="text" id="zonetitle" placeholder="Enter zone title"  class="form-control col-md-7">
                                    </div>
                                    <div class="col-sm-2 errors" id="titleErr"> </div>
                                </div>


                                <!--                                <div class="form-group">
                                                                    <label for="zonetitle" class="control-label col-md-3 col-sm-3">Preferred Store</label>
                                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                                        <select  id='preferredStore' name='preferredStore' class='errr11 form-control'>
                                                                            <option value=''>Select Stores</option>
                                <?PHP
//foreach ($stores as $dat) {
//    echo "<option data-name = " . implode(',', $dat['name']) . "value='" . $dat['_id']['$oid'] . "' data-id='" . $dat['_id']['$oid'] . "'>" . implode(',', $dat['name']) . "</option>";
//}
                                ?>
                                                                        </select>
                                
                                                                    </div>
                                                                    <div class="col-sm-2 errors" id="preferredStoreErr"> </div>
                                                                </div>-->


                            </form>
                            <div class="form-group" style="margin-left: 12%;">
                                <div id="info">

                                </div>
                            </div>
                            <div class="form-group">
                                <button id="savezone" class="btn btn-success" style="margin-left: 10%;">Save</button>
                                <button id="clearzone"  class="btn btn-default">Clear</button><br/>
                                <p id="addmsg" class="waitmsg"></p>


                            </div>

                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>

<!--Edit Zone Modal -->
<div class="modal fade fill-in" id="editZoneModal" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">EDIT</span> 

            </div>
            <div class="modal-body">
                <div class="container-fluid bg-white">
                    <div class="row">

                        <!--onfocus="initAutocomplete(2)"--> 
                        <div id="editmodalmap" class="col-md-8 col-sm-12"></div>
                        <div class="col-md-4 col-sm-12">
                            <form id="zoneform" data-parsley-validate="" class="form-horizontal form-label-left">

                                <div class="form-group">
                                    <label for="editzonecity" class="control-label col-md-3 col-sm-3">City</label>
                                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                                        <select  class="form-control" id="cities" disabled></select>
                                    </div>
                                    <div class="col-sm-2 errors" id="city_e_Err"> </div>
                                </div>


                                <div class="form-group">
                                    <label for="editzonetitle" class="control-label col-md-3 col-sm-3">Title</label>
                                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                                        <input class="form-control" type="text" id="editzonetitle" placeholder="Enter zone title"  class="form-control col-md-7">
                                    </div>
                                    <div class="col-sm-2 errors" id="title_e_Err"> </div>
                                </div>


                                <div class="form-group" style="margin-left: 8%;">
                                    <div id="pointsinfo"></div>
                                </div>
                                <div class="form-group">
                                    <button id='saveeditzone' style="margin-left:6.5%;" class="btn btn-success">Save</button>
                                    <!--<button id="deletezone"  class="btn btn-danger">Delete</button>-->
                                    <button type="button" id="cancelEditZoneModal" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button><br>
                                    <p id="editmsg" class="waitmsg"></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="modal fade fill-in" id="map_display" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">ALL ZONES</span> 
            </div>
            <div class="modal-body" style="margin-top: -1%;">
                <input id="pac-input2" class="controls" type="text" placeholder="Search Location" style="position: absolute;width: 15.5em;margin-left: 130px;z-index: 1050;margin-top: 24px;padding:10px;">
                <!--onfocus="initAutocomplete(3)"-->
                <select  class="form-control" id="city_selection_view" style="position: absolute;width: 15.5em;margin-left: 359px;z-index: 1050;margin-top: 24px;background-color:gainsboro;font-size:11px;">

                    <?php
                    foreach ($cities as $city) {
                        ?>
                        <option value="<?php echo $city['_id']['$oid']; ?>" city="<?php echo $city['city']; ?>" lat="" lng=""><?php echo $city['city']; ?></option>    
                        <?php
                    }
                    ?>
                </select>
                <div class="container-fluid bg-white" style="padding-top: 1%;padding-bottom: 1%;">
                    <!--                        <div id='viewmaploader' style="display:none;position: relative;z-index: 1500;background-color: white;height: 90vh;width: 100%;">
                                                <img src="<?= base_url() ?>/../../../images/loading.gif" style="position: absolute;left: 0;right: 0;top: 0;bottom: 0;margin: auto;"/>
                                            </div>-->
                    <div id='viewmap' class="row">
                        <div id="mapPolygon"  class="col-sm-12"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade stick-up" id="deleteZone" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">Delete</span> 
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="error-box"  style="text-align:center"></div>
                </div>
            </div>



            <div class="modal-footer">
                <div class="col-sm-4"></div>
                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger" id="yesdelete" >Delete</button></div>
                    <div class="pull-right m-t-10"><button type="button" class="btn btn-default" id="cancel_delete" >Cancel</button></div>

                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="preferredZoneModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Preferred Store</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>


            </div>
            <br>
            <div class="modal-body">
                <div class="">

                    <label>Preferred Store</label>

                    <div class="">
                        <select class="form-control" id="preferredStoreList">
                            <option value="" >Select Stores</option>
                        </select>
                    </div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">

                    <div class="col-sm-4"></div>
                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-success pull-right" id="setZone" >Save</button>
                        <button type="button"  class="btn btn-default pull-right" data-dismiss="modal" >Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="alertForNoneSelected1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>


            </div>
            <br>
            <div class="modal-body">
                <div class="modalPopUpText" id="errZone"></div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">

                    <div class="col-sm-4"></div>
                    <div class="col-sm-8" >

                        <button type="button"  class="btn btn-default pull-right" data-dismiss="modal" >OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
