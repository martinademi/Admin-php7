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



    #addZoneModal .modal-dialog,
    #map_display .modal-dialog,
    #editZoneModal .modal-dialog {
        width: 90%;
    }


    #addmodalmap,
    #mapPolygon,
    #editmodalmap {
        /*height: 600px;*/
        height: 80vh;
    }

    #zoneform label {
        margin-left: 12px;
    }


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
        /*        font-size: 15px;*/
        font-weight: 600;
        /*margin-left: 12px;*/
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        /*width: 300px;*/
        /*border-radius: 5px;*/
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
    /*	.DataTables_sort_wrapper {
        text-align: center;
    }*/
</style>
<!--<script src="<?= base_url() ?>theme/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js" type="text/javascript"></script>-->
<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE&sensor=false&language=en-AU&libraries=drawing,places"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/javascript.util.min.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/jsts.min.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/wicket.js"></script>
<script src="<?= base_url() ?>/theme/ZoneMapAssets/wicket-gmap3.js"></script>
<script>
    //Surge Price should be either in decimal/Number
    var Str;
    var mapedit;
    var cities = [];
    $(document).ready(function () {

        // All cities including deleted
        $.ajax({
            dataType: "json",
            url: "<?= base_url() ?>index.php?/superadmin/getAllCities",
            async: false,
            success: function (result) {

                $.each(result.data, function (index, row)
                {
                    cities.push(row.city);
                });
            }
        });


    });
    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
                (charCode != 45 || $(element).val().indexOf('-') != -1) && // “-” CHECK MINUS, AND ONLY ONE.
                (charCode != 46 || $(element).val().indexOf('.') != -1) && // “.” CHECK DOT, AND ONLY ONE.
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
    var mapview;
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
                lat: 12.971599
                , lng: 77.594563
            }
            , zoom: 10
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

        google.maps.event.addListenerOnce(mapview, 'idle', function () {
            google.maps.event.trigger(mapview, 'resize');
        });


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
                selectedCity_view = $("#city_selection_view option:selected").val();
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
                    drawzones_view(city);

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

    function drawzones_view(selectedCity) {
        var zone = [];
        for (var iZone = 0; iZone < datafromserver_view.length; iZone++) {
            if (datafromserver_view[iZone].city == selectedCity) {

                var polgonProperties = datafromserver_view[iZone].polygonProps;
                polgonProperties.zoneIndex = iZone; //to add the array index of the polygon to its properties in the json object received from server

                zone[iZone] = new google.maps.Polygon(polgonProperties);
                zone[iZone].setMap(mapview);

                overlays_view.push(zone[iZone]);

                var latLng = {lat: datafromserver_view[iZone].polygonProps.paths[0].lat, lng: datafromserver_view[iZone].polygonProps.paths[0].lng};
                var inf = new google.maps.InfoWindow;

                var Str = '<b>' + datafromserver_view[iZone].title + '</b><br> Fare:' + datafromserver_view[iZone].surge_price + ' X';

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
    var operating_zones = "";

    function addNewZone() {
        $('#pac-input').val('');
        $('.errors').text('');
//        $('#city_selection_add option[value=""]').prop('selected','selected');
//        $('#city_selection_add').select2();
        selectedCity_add = "";

        /*ajax request to get all the details of polygon*/
        //All cities excluding deleted
        $.ajax({
            dataType: "json",
            url: "<?= base_url() ?>index.php?/superadmin/zonemapsapi",
            async: false,
            success: function (result) {
                datafromserver = result.data;
            }
        });



        //All cities excluding deleted
        $.ajax({
            dataType: "json",
            url: "<?= base_url() ?>index.php?/superadmin/operating_zonesAPI",
            async: false,
            success: function (result) {
                operating_zones = result.data;
            }
        });




        map = new google.maps.Map(document.getElementById('addmodalmap'), {
            center: {
                lat: 12.971599
                , lng: 77.594563
            }
            , zoom: 4
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
        showZones();

//            var bounds = new google.maps.LatLngBounds();
//            bounds.extend(new google.maps.LatLng(12.971599,77.594563));
//            map.fitBounds(bounds);
//            
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

                var polgonProperties = datafromserver[iZone].pointsProps;
                var oldpolyProp = new google.maps.Polygon(polgonProperties);

                var wkt = UseWicketToGoFromGooglePolysToWKT(newpolyProp, oldpolyProp);
                if (UseJstsToTestForIntersection(wkt[0], wkt[1])) {
                    $('#clearzone').trigger('click');
                    alert("Do not Overlap Existing Zone.")
                    return;
                }
            }




            for (var i = 0; i < len; i++) {
                htmlStr += "<div class='row'><label class='form-control col-sm-2' style='width:17%;'>Point" + (i + 1) + " </label> <input type='number' id='p" + (i + 1) + "lat' value='" + polygon.getPath().getAt(i).lat() + "' class='pointscontrols  form-control col-sm-2' readonly style='width:40%;'><input type='number' id='p" + (i + 1) + "lng' value='" + polygon.getPath().getAt(i).lng() + "' class='pointscontrols form-control col-sm-2' readonly style='width:40%;'></div>";
            }
            $('#info').html(htmlStr);
            $('#savezone').show();
            $('#clearzone').show();
        }

        //Function to Check if new polygon is inside another polygon
        function isPolygonInsidePolygon(newpolyProp, operating_zones) {
            var pointPoly = [];
            var isPointInsidePolygon = true;
            var operating_area = '';

            //loop for multiple operating zones
            for (var j = 0; j < operating_zones.length; j++)
            {
               
                pointPoly = [];
                operating_area = operating_zones[j].pointsProps;

                //Make right format for google lat long for each operating zone
                for (var i = 0; i < operating_area.paths.length; i++) {
                    pointPoly.push(new google.maps.LatLng(operating_area.paths[i].lat, operating_area.paths[i].lng));
                }
              

                //create polygon object for each operating zone
                var operatingZone = new google.maps.Polygon({
                    paths: pointPoly
                });



                //Check if new polygon is inside another polygon
                newpolyProp.getPath().getArray().map(function (x) {
                    if (google.maps.geometry.poly.containsLocation(x, operatingZone))
                    {
                        isPointInsidePolygon = true;
//                        console.log('inside');
                    } else {
//                        console.log('ouside');
                        isPointInsidePolygon = false;
                    }
                });

                if (isPointInsidePolygon)
                    return false;


            }
            if (isPointInsidePolygon === false)
            {
                $('#clearzone').trigger('click');
                alert("This zone is outside the operation zones")
                return false;
            } else
                return true;
        }
        ;



        google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
            // Switch back to non-drawing mode after drawing a shape.
            drawingManager.setMap(null);

            drawingManager.setDrawingMode(null);

            fillPathsInput(polygon);
            isPolygonInsidePolygon(polygon, operating_zones);
            google.maps.event.addListener(polygon.getPath(), 'set_at', function () {
                fillPathsInput(polygon);
                isPolygonInsidePolygon(polygon, operating_zones);
            });

            google.maps.event.addListener(polygon.getPath(), 'insert_at', function () {
                fillPathsInput(polygon);
                isPolygonInsidePolygon(polygon, operating_zones);
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
            $('#addCityForm')[0].reset();
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
            if ($('#pac-input').val() == '')
            {
                $('#cityNameErr').text('Please select a city');
            } else {

                var len = newPolygon.getPath().getLength();

                for (var i = 0; i < len; i++) {
                    var latlngobj = {
                        "lat": parseFloat(newPolygon.getPath().getAt(i).lat())
                        , "lng": parseFloat(newPolygon.getPath().getAt(i).lng())
                    };
                    polygonCoordinates.push(latlngobj);
                }

                var coordinates1 = [];
                for (var i = 0; i < len; i++) {
                    coordinates1.push([parseFloat(newPolygon.getPath().getAt(i).lng()), parseFloat(newPolygon.getPath().getAt(i).lat())]);
                }

                coordinates1.push(coordinates1[0]);
                //                alert(JSON.stringify(coordinates1));

                polygonCoordinates1.push(coordinates1);



                var cl = "#" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0) + Math.floor(Math.random() * (9 - 0 + 1) + 0) + "" + Math.floor(Math.random() * (9 - 0 + 1) + 0);
                var pointsProperties = {
                    "paths": polygonCoordinates
                    , "strokeColor": cl
                    , "strokeOpacity": 0.2
                    , "strokeWeight": 2
                    , "fillColor": cl
                    , "fillOpacity": 0.35
                    , "draggable": false
                    , "editable": false
                }


                var polygonProperties1 = {
                    "type": "Polygon",
                    "coordinates": polygonCoordinates1

                }


                var data = {
<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
                    "country": $('#coutryName').val(),
                    "city": $('#cityNameOnly').val(),
                    "isDeleted": false,
                    "pointsProps": pointsProperties,
                    "polygons": polygonProperties1
                }

                //To update the zone details
                $.ajax({
                    url: '<?php echo base_url() ?>index.php?/superadmin/zonemapsapi'
                    , dataType: "json"
                    , type: "POST"
                    , contentType: 'application/json; charset=utf-8'
                    , data: JSON.stringify(data)
                    , async: true
                    , success: function (data) {

                        if (data.flag == 0)
                        {
                            $('.close').trigger('click');
                            $('.Ok').trigger('click');
                        } else {
                            alert('City is already exists..!');
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
            if (selectedCity_add != $("#city_selection_view option:selected").val()) {
                $('#pac-input').val('');
                var customerlat;
                var customerlong;
                customerlat = $('#city_selection_add').children(":selected").attr("lat").trim();
                customerlong = $('#city_selection_add').children(":selected").attr("lng").trim();

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
                drawZones_add(selectedCity_add);
            }
        });
         var options = {
            types: ['(cities)']
        };

        var input = document.getElementById('pac-input');
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            var country = "";
            var state = "";
            for (var i = 0; i < place.address_components.length; i++) {
                for (var j = 0; j < place.address_components[i].types.length; j++) {
                    if (place.address_components[i].types[j] == "country")
                        $('#coutryName').val(place.address_components[i].long_name);
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
            $('#pac-input').val(place.name);
            $('#cityNameOnly').val(place.name);
            
             // Check if city is already exists

//                    console.log('city:'+$('#pac-input').val());
                    $('#cityExistsName').val($('#pac-input').val());
                    if ($.inArray($('#pac-input').val(), cities) == -1)
                    {
                         console.log('if:'+$('#pac-input').val());

                    } else {
                         console.log('else:'+$('#pac-input').val());
                        $('#cityNameOnly').val('');
                        $('#pac-input').val('');
                        $('#coutryName').val('');
                        $('#cityExistsPopUp').modal('show');
                    }
        });

//        $('#pac-input').focus(function () {
//
//            var input;
//            input = document.getElementById('pac-input');
//
//            var searchBox = new google.maps.places.SearchBox(input);
//
//            // Bias the SearchBox results towards current map's viewport.
//            map.addListener('bounds_changed', function () {
//                searchBox.setBounds(map.getBounds());
//            });
//
//            // Listen for the event fired when the user selects a prediction and retrieve
//            // more details for that place.
//            searchBox.addListener('places_changed', function () {
//
//                var places = searchBox.getPlaces();
//
//                if (places.length == 0) {
//                    return;
//                }
//
//                // Clear out the old markers.
//                if (marker_add != "")
//                {
//                    marker_add.setMap(null);
//                    marker_add = "";
//                }
//                // For each place, get the icon, name and location.
//                var bounds = new google.maps.LatLngBounds();
//                places.forEach(function (place) {
//                    for (var i = 0; i < place.address_components.length; i++) {
//                        for (var j = 0; j < place.address_components[i].types.length; j++) {
//                            if (place.address_components[i].types[j] == "country")
//                                $('#coutryName').val(place.address_components[i].long_name);
//                            if (place.address_components[i].types[j] == "administrative_area_level_1")
//                                state = place.address_components[i].long_name;
//                        }
//                    }
//                    if (place.geometry.viewport) {
//                        map.fitBounds(place.geometry.viewport);
//                    } else {
//                        map.setCenter(place.geometry.location);
//                        map.setZoom(10);
//                    }
//                    $('#cityNameOnly').val(place.name)
//
//                    var lat = parseFloat(place.geometry.location.lat()).toFixed(6);
//                    var lng = parseFloat(place.geometry.location.lng()).toFixed(6);
//
//                    for (i = 0; i < pnt_overlay_add; i++) {
//                        overlays_add[i].setMap(null);
//                    }
//                    for (i = 0; i < pnt_infwin_add; i++) {
//                        infoWindow_add[i].setMap(null);
//                    }
//                    overlays_add = [];
//                    infoWindow_add = [];
//                    pnt_overlay_add = 0;
//                    pnt_infwin_add = 0;
//
////                    getCityCountry(place.geometry.location.lat() + ',' + place.geometry.location.lng());
////                    drawZones_add(city);
//                    // Create a marker for each place.
//                    marker_add = new google.maps.Marker({
//                        map: map
//                        , title: place.name
//                        , position: place.geometry.location
//                    });
//                    map.setCenter(marker_add.getPosition());
//                });
//            });
//        });
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

                var Str = '<b>' + datafromserver[iZone].title + '</b><br> Fare:' + datafromserver[iZone].surge_price + ' X';

                infoWindow_add[pnt_infwin_add].setContent(Str);
                infoWindow_add[pnt_infwin_add].setPosition(latLng);
                infoWindow_add[pnt_infwin_add].open(map);
                pnt_infwin_add++;
            }
        }

    }
    //plots the zones or polygons on the map based on the selected city from dropdown
    function showZones() {
        var Str;
        var latLng;
        var lat;
        var long;
        var zone = [];
        pnt_infwin_add = 0;

        for (var iZone = 0; iZone < datafromserver.length; iZone++) {


//            if (datafromserver[iZone].city == selectedCity) {

            var polgonProperties = datafromserver[iZone].pointsProps;
            polgonProperties.zoneIndex = iZone; //to add the array index of the polygon to its properties in the json object received from server

            overlays_add[pnt_overlay_add] = new google.maps.Polygon(polgonProperties);
            overlays_add[pnt_overlay_add].setMap(map);


            pnt_overlay++;

            latLng = {lat: datafromserver[iZone].pointsProps.paths[0].lat, lng: datafromserver[iZone].pointsProps.paths[0].lng};
            infoWindow_add[pnt_infwin_add] = new google.maps.InfoWindow;

            lat = datafromserver[iZone].pointsProps.paths[0].lat;
            long = datafromserver[iZone].pointsProps.paths[0].lng;

            Str = '<b>' + datafromserver[iZone].city + '</b>';

//            cities.push(datafromserver[iZone].city);

            infoWindow_add[pnt_infwin_add].setContent('<b>' + datafromserver[iZone].city + '</b>');
            infoWindow_add[pnt_infwin_add].setPosition(latLng);
            infoWindow_add[pnt_infwin_add].open(map);

            pnt_infwin_add++;

//            }
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
            $("#display-data").text('Please choose one city to edit');
            return false;
        } else if (selectedZone.length > 1)
        {
            $('#alertForNoneSelected').modal('show');
            $("#display-data").text('Please choose only one city to edit');
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
                , zoom: 9
            });

            //Map does not load in a modal window until it is resized
            google.maps.event.addListenerOnce(mapedit, 'idle', function () {
                google.maps.event.trigger(mapedit, 'resize');
            });

            /*ajax request to get all the details of polygon*/
            $.ajax({
                dataType: "json",
                url: "<?= base_url() ?>index.php?/superadmin/zonemapsapi",
                async: false,
                success: function (result) {
                    datafromserver_edit = result.data;
                }
            });


            if (selectedZone == '')
                $("#cities").trigger('change');
            else
            {

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getZoneCity",
                    type: 'POST',
                    data: {city_id: selectedZone.toString(), <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
                    dataType: 'JSON',
                    success: function (response)
                    {
                        $('#editCityName').val(response.city);
                        $('#editcoutryName').val(response.country);
                        drawZones_editSpecific(response.city, selectedZone.toString());
                    }
                });
            }

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

                var Str = '<b>' + datafromserver_edit[iZone].title + '</b><br> Fare:' + datafromserver_edit[iZone].surge_price + ' X';

                infoWindow_edit[pnt_infwin].setContent(Str);
                infoWindow_edit[pnt_infwin].setPosition(latLng);
                infoWindow_edit[pnt_infwin].open(mapedit);
                pnt_infwin++;
            }
        }

    }

    //plots the zones or polygons on the map based on the selected city from dropdown
    function drawZones_editSpecific(selectedCity, id) {

        var zone = [];
        clearFields_edit();


        for (var iZone = 0; iZone < datafromserver_edit.length; iZone++) {


            if (datafromserver_edit[iZone]._id.$oid == id) {
                var polgonProperties = datafromserver_edit[iZone].pointsProps;
                polgonProperties.zoneIndex = iZone; //to add the array index of the polygon to its properties in the json object received from server

                overlays_edit[pnt_overlay] = new google.maps.Polygon(polgonProperties);
                overlays_edit[pnt_overlay].setMap(mapedit);


//                google.maps.event.addListener(overlays_edit[pnt_overlay], 'click', function (event) {
                editZoneDetails(overlays_edit[pnt_overlay]);

//                });
                pnt_overlay++;

                var latLng = {lat: datafromserver_edit[iZone].pointsProps.paths[0].lat, lng: datafromserver_edit[iZone].pointsProps.paths[0].lng};
                infoWindow_edit[pnt_infwin] = new google.maps.InfoWindow;

                var Str = '<b>' + datafromserver_edit[iZone].city + '</b>';

                infoWindow_edit[pnt_infwin].setContent(Str);
                infoWindow_edit[pnt_infwin].setPosition(latLng);
                infoWindow_edit[pnt_infwin].open(mapedit);
                pnt_infwin++;
            }

        }

    }



    function editZoneDetails(polygon) {
        if ((old_polygon || old_polygon == "0") && old_polygon == polygon.zoneIndex) {
            newPolygon_edit.setPaths(datafromserver_edit[old_polygon].pointsProps.paths);
            newPolygon_edit.setEditable(false);
            newPolygon_edit.setDraggable(false);
            clearFields_edit();
            return;
        }
        if ((old_polygon || old_polygon == "0") && old_polygon != polygon.zoneIndex) {
            newPolygon_edit.setPaths(datafromserver_edit[old_polygon].pointsProps.paths);
        }
        if (newPolygon_edit) {
            newPolygon_edit.setEditable(false);
            newPolygon_edit.setDraggable(false);
        }
        old_polygon = polygon.zoneIndex;
        polygon.setEditable(true);
        polygon.setDraggable(true);

        $('#editzonecity').val(datafromserver_edit[polygon.zoneIndex].city);

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

            var pointsProperties = {
                "paths": polygonCoordinates_edit
                , "strokeColor": cl
                , "strokeOpacity": 0.2
                , "strokeWeight": 2
                , "fillColor": cl
                , "fillOpacity": 0.35
                , "draggable": false
                , "editable": false
            };

            var newpolyProp = new google.maps.Polygon(pointsProperties);
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
                    "pointsProps": pointsProperties,
                    "polygons": polygonProperties1     //changed Done 08-05-2016
                }
            }

            $('#editmsg').text("please wait..")

            //To update the zone details
            $.ajax({
                url: '<?= base_url() ?>index.php?/superadmin/zonemapsapi'
                , dataType: "json"
                , type: "PUT"
                , contentType: 'application/json; charset=utf-8'
                , data: JSON.stringify(data)
                , async: true
                , success: function (data) {
                    if (data.status == 'success') {
                        var count = 1;
                        var s = '';
                        $.each(pointsProperties.paths, function (ind, val) {

                            s += 'P' + count + "(" + val['lat'] + "," + val['lng'] + ")";
                            s += " ";
                            if ((count % 2) == 0)
                                s += ' <br>';
                            count++;
                        });
                        s += "<input type='hidden' id='zone_" + String(zid) + "'>";
                        $('#zone_' + zid).closest('tr').find('td:nth-child(2)').html($('#cities').val());
                        $('#zone_' + zid).closest('tr').find('td:nth-child(3)').html($('#editzonetitle').val());
//                            $('#zone_'+zid).closest('tr').find('td:nth-child(4)').html(($('input[name=charge_type_add]:checked').val()=='SUBCHARGE')?"Sub Charge":"Surge Charge");
//                            $('#zone_'+zid).closest('tr').find('td:nth-child(5)').html($('#editzonesurge_price').val());
                        $('#zone_' + zid).closest('tr').find('td:nth-child(4)').html(s);
                        $('#zone_' + zid).closest('tr').find('td:nth-child(5)').html('<input type=checkbox class=checkbox name=checkbox value=' + selectedZone.toString() + '>');
                        $('#editZoneModal').modal('toggle');
                        clearFields_edit();
                    } else if (data.status == 'error') {
                        $('#editmsg').text("unable to update!").addClass("error");
                        clearFields_edit();
                    }
                }
                , error: function (xhr) {
                    alert('error');
                }
            });


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
                            , position: new google.maps.LatLng(customerlat, customerlong)
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
        $("#deleteZone").click(function () {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/deleteZone",
                type: "POST",
                data: {zone_id: val, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (result) {
                    $(".close").trigger('click');
                    refreshContent();

                }
            });
        });


    });

    function refreshContent() {

        $('#big_table').hide();
        $('#big_table_processing').show();
        var table = $('#big_table');
        $("#display-data").text("");

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo base_url() ?>index.php?/superadmin/datatable_cities",
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').show();
            },
            'fnServerData': function (sSource, aoData, fnCallback)
            {
                // csrf protection
                aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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

    }
</script> 

<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    .pac-container {
        z-index: 1051 !important;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>
<script>
    var reg = /^[-+]?[0-9]{1,7}(\.[0-9]+)?$/;
    function getlatlongByCity() {

        var cityid = $("#selectedcity1 option:selected").text();
        var countryid = $("#countryid option:selected").text();

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': '' + cityid + ',' + countryid}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                $('#latitude').val(results[0].geometry.location.lat());
                $('#longitude').val(results[0].geometry.location.lng());
            } else {
                alert("Something got wrong " + status);
            }
        })
    }



</script>



<script>

    $(document).ready(function () {

        $("#currency").on("input", function () {
            var regexp = /[^a-zA-Z/ ]/g;
            if ($(this).val().match(regexp)) {
                $(this).val($(this).val().replace(regexp, ''));
            }
        });

        $('#AddCity').click(function ()
        {
            $('#addCityForm')[0].reset();

            $('#addZoneModal').modal('show');
        });


        //Delete zone
        $('#buttonDelete').click(function ()
        {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length > 0)
            {
                $('#deleteZonePopUp').modal('show');
            } else {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select at lease one city to delete');
            }
        });

        $("#search-box").keypress(function (event) {

            var inputValue = event.which;
            //if digits or not a space then don't let keypress work.
            if ((inputValue > 64 && inputValue < 91) // uppercase
                    || (inputValue > 96 && inputValue < 123) // lowercase
                    || inputValue == 32) { // space
                return;
            }
            event.preventDefault();
        });


        $('#insertCityData').click(function ()
        {
            $('.errors').text('');
            if ($('#cityName').val() == '')
            {
                $('#cityNameErr').text('Please enter city');
            } else if ($('#cityName').val() != $('#cityNameOnly').val())
            {
                $('#cityNameErr').text('Entered city is invalid');
            } else if ($('#latitude').val() == '')
            {
                $('#latitudeErr').text('Please enter latitude');
            } else if (!reg.test($('#latitude').val())) {
                $('#latitudeErr').text('Invalid data');
            } else if ($('#longitude').val() == '')
            {
                $('#longitudeErr').text('Please enter longitude');
            } else if (!reg.test($('#longitude').val())) {
                $('#longitudeErr').text('Invalid data');
            } else if ($('#currency').val() == '')
            {
                $('#currencyErr').text('Please enter currency');
            } else
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/insertCity",
                    type: 'POST',
                    data: $('#addCityForm').serialize(),
                    dataType: 'JSON',
                    success: function (response)
                    {
                        if (response.flag == 0)
                        {
                            $('.close').trigger('click');
                            $('#responseMsg').text(response.msg);
                            $('#ResponsePopUp').modal('show');


                        } else {
                            $('.ResponseErr').text(response.msg);
                        }


                    }
                });


            }

        });

        $('.Ok').click(function ()
        {
            var table = $('#big_table');
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo base_url() ?>index.php?/superadmin/datatable_cities",
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
                    $('.cs-loader').hide();

                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    // csrf protection
                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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
        });

        $('.cities').addClass('active');
//        $('.cities').attr('<?php echo base_url(); ?>/theme/icon/cities_on.png"');
        $('.cities_thumb').attr('src', "<?php echo base_url(); ?>/theme/icon/cities_on.png");

        $('#latitudeedit').keypress(function (event) {
            if (event.which < 44
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if ((event.which == 45 && $(this).val().indexOf('-') != -1) || (event.which == 46 && $(this).val().indexOf('.') != -1)) {
                event.preventDefault();
            } // prevent if already dot
        });

        $('#longitudeedit').keypress(function (event) {
            if (event.which < 44
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if ((event.which == 45 && $(this).val().indexOf('-') != -1) || (event.which == 46 && $(this).val().indexOf('.') != -1)) {
                event.preventDefault();
            } // prevent if already dot
        });


        $('#latitude').keypress(function (event) {
            if (event.which < 44
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if ((event.which == 45 && $(this).val().indexOf('-') != -1) || (event.which == 46 && $(this).val().indexOf('.') != -1)) {
                event.preventDefault();
            } // prevent if already dot
        });

        $('#longitude').keypress(function (event) {
            if (event.which < 44
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if ((event.which == 45 && $(this).val().indexOf('-') != -1) || (event.which == 46 && $(this).val().indexOf('.') != -1)) {
                event.preventDefault();
            } // prevent if already dot
        });



        $('#btnStickUpSizeToggler').click(function () {
            $("#display-data").text("");
            $(".errors").text("");
            $("#cityCofig")[0].reset();
            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#myModal');
            if (size == "mini") {
                $('#modalStickUpSmall').modal('show')
            } else {
                $('#myModal').modal('show');
                $('#countryid').val('');
                $('#search-box').val('');
                $('#latitude').val('');
                $('#longitude ').val('');
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
        });



        $(document).on('click', '.editCity', function () {

            $('#EditCityID').val($(this).attr('data-id'));
            $('#latitudeedit').val($(this).parent().prev().prev().text());
            $('#longitudeedit').val($(this).parent().prev().text());
            $('#myanotherModal').modal('show');
        });



        $("#updateCity").click(function () {
            $("#longlat").text("");

            var lat = $("#latitudeedit").val();
            var lon = $("#longitudeedit").val();
            var reg = /^(\-?\d+(\.\d+)?)$/;


            if (lat == "" || lat == null)
            {
//                alert("please enter the latitude");
                $("#field_lat_e").text(<?php echo json_encode(POPUP_CITY_LAT); ?>);
            } else if (!reg.test(lat))
            {
//                alert("please enter valid data at latitude");
                $("#field_lat_e").text(<?php echo json_encode(POPUP_CITY_LATVAL); ?>);

            } else if (lon == "" || lon == null)
            {
//                alert("please enter the longitude");
                $("#field_long_e").text(<?php echo json_encode(POPUP_CITY_LOT); ?>);
            } else if (!reg.test(lon))
            {
//                alert("please enter valid data at longitude");
                $("#field_long_e").text(<?php echo json_encode(POPUP_CITY_LONVAL); ?>);
            } else
            {

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/editlonglat",
                    type: 'POST',
                    data: {
                        cityID: $('#EditCityID').val(),
                        lat: lat,
                        lon: lon
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                        $(".close").trigger("click");
                        $('#responseMsg').text(response.msg);
                        $('#ResponsePopUp').modal('show');
//                      
                    }

                });
            }



        });


        $(document).on('click', '.dectivate', function () {
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/active_deactiveCity/1",
                type: "POST",
                data: {cityID: $(this).attr('data-id')},
                dataType: 'json',
                success: function (result)
                {
                    if (result.flag == 0)
                    {
                        $('#responseMsg').text(result.msg);
                        $('#ResponsePopUp').modal('show');
                    } else {

                        $('#display-data').text(result.msg);
                        $('#alertForNoneSelected').modal('show');
                    }
                }
            });

        });

        $(document).on('click', '.Activate', function () {

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/active_deactiveCity/0",
                type: "POST",
                data: {cityID: $(this).attr('data-id')},
                dataType: 'json',
                success: function (result)
                {
                    if (result.flag == 0)
                    {
                        $('#responseMsg').text(result.msg);
                        $('#ResponsePopUp').modal('show');
                    } else {

                        $('#display-data').text(result.msg);
                        $('#alertForNoneSelected').modal('show');
                    }
                }
            });

        });



        $(document).on('click', '.deleteCity', function () {
            $("#display-data").text("");

            $('#deleteModel-cities').modal('show');
            $('#deleteCityID').val($(this).attr('data-id'));
            $("#errorboxdata").text(<?php echo json_encode(CITY_DELETE); ?>);

        });

        $('#confirmed').click(function () {

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/deletecities",
                type: "POST",
                data: {cityID: $('#deleteCityID').val()},
                dataType: 'json',
                success: function (result)
                {

                    $(".close").trigger("click");
                    $('#responseMsg').text(result.msg);
                    $('#ResponsePopUp').modal('show');



                }
            });

        });


    });

</script>

<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_cities',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
//                  $('#big_table_processing').hide();
                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    // csrf protection
                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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
        }, 1000);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });


        $('#activateCity').click(function ()
        {
            //update the city status if it exists already
            var data = {"isDeleted": false, 'city': $('#cityExistsName').val(),<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'};
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/superadmin/checkCityExists'
                , dataType: "json"
                , type: "POST"
                , data: data
                , async: true
                , success: function (data) {

                    if (data.flag == 0)
                    {
                        $('.close').trigger('click');
                        $('.Ok').trigger('click');
                    } else {
                        alert('while updating databse getting an error');
                    }
                }
                , error: function (xhr) {
                    alert('error');
                }
            });
        });

    });
</script>

<style>
    .exportOptions{
        display: none;
    }
</style>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
            <strong>CITIES</strong>

        </div>

        <div class="row">
            <ul class="nav nav-tabs nav-tabs-fillup  new_class bg-white" style="margin: 1% 0.8%;padding: 0.5% 2% 0% 1%">
                <div class="pull-right m-t-10 cls111"><button  class="btn btn-danger" id="buttonDelete"> 
                        Delete</button></div>

                <div class="pull-right m-t-10 cls111"><button data-toggle="modal" class="btn btn-info" onclick="loadExistingZones()"> 
                        Edit</button></div>
                <button data-toggle="modal" class="btn btn-primary" data-target="#editZoneModal" style="display:none;" id="editZoneModal1"> 
                </button>
                <div class="pull-right m-t-10 cls110"><button data-toggle="modal" class="btn btn-primary btn-cons" data-target="#addZoneModal" onclick="addNewZone(12.972442010578353, 77.5909423828125)"> 
                        Add</button></div>
                <div class="pull-right m-t-10" class="btn-group">

                </div>

            </ul>

            <div class="col-md-12 col-sm-12 col-xs-12">


                <div class="panel panel-transparent ">


                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <div class="cs-loader">
                                    <div class="cs-loader-inner" >
                                        <label class="loaderPoint" style="color:#10cfbd">●</label>
                                        <label class="loaderPoint" style="color:red">●</label>
                                        <label class="loaderPoint" style="color:#FFD119">●</label>
                                        <label class="loaderPoint" style="color:#4d90fe">●</label>
                                        <label class="loaderPoint" style="color:palevioletred">●</label>
                                    </div>
                                </div>

                                <div class="pull-right">
                                    <input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo SEARCH; ?>"/> 

                                </div>
                                &nbsp;
                                <div class="panel-body" style="padding: 0px; margin-top: 2%;">

                                    <?php echo $this->table->generate(); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- END PANEL -->
        </div>
    </div>
</div>
<input type="hidden" id="cityExistsName" name="cityExistsName">

<div class="container-fluid container-fixed-lg footer">
    <div class="copyright sm-text-center">
        <p class="small no-margin pull-left sm-pull-reset">
            <span class="copy-right"></span>

        </p>

        <div class="clearfix"></div>
    </div>
</div>




<div class="modal fade stick-up" id="myanotherModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">EDIT CITY</span>
            </div>
            <div class="modal-body">

                <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">

                    <input type="hidden" name="EditCityID" id="EditCityID">
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_VEHICLETYPE_LATITUDE; ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="latitudeedit" name="latitude"  class="form-control error-box-class" placeholder="eg:234.3432">
                        </div>
                        <div class="col-sm-3 error-box errors" id="field_lat_e"></div>
                    </div>


                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_VEHICLETYPE_LONGITUDE; ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="longitudeedit" name="longitude" class="form-control error-box-class" placeholder="eg:3632.465">
                        </div>
                        <div class="col-sm-3 error-box errors" id="field_long_e"></div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <div class="col-sm-4 error-box errors"></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="updateCity" >Update</button></div>
                    <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>

                </div>
            </div>

        </div>


        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade stick-up" id="deleteModel-cities" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DELETE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <input type="hidden" name="deleteCityID" id="deleteCityID">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <div class="pull-right m-t-10"><button type="button" class="btn btn-danger pull-right" id="confirmed" >Delete</button></div>
                    <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>


                </div>

            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>





<div class="modal fade stick-up" id="addZoneModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">ADD CITY</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="addmodalmap" class="col-md-7 col-sm-7"></div>
                    <div class="col-md-5 col-sm-5">
                        <form id="addCityForm" action="<?php echo base_url(); ?>index.php?/superadmin/insertCity" method="post"  data-parsley-validate="" class="form-horizontal form-label-left" >

                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">City<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  id="pac-input" name="cityName"  class="form-control error-box-class" autocomplete="on">
                                </div>
                                <div class="col-sm-3 error-box errors" id="cityNameErr"></div>
                                <input type="hidden" id="cityNameOnly" name="cityNameOnly">

                            </div>
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label">Country</label>
                                <div class="col-sm-6">
                                    <input type="text" id="coutryName" name="coutryName" class="form-control error-box-class" disabled>
                                </div>

                            </div>


                            <br>
                            <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">Long Haul Zone Points</label>
                            </div>
                            <div class="form-group">
                                <div id="info">

                                </div>
                            </div>
                        </form>

                        <div class="form-group">
                            <button id="savezone" class="btn btn-success" style="margin-left: 10%;">Save</button>
                            <button id="clearzone"  class="btn btn-default">Clear</button><br/>
                            <p id="addmsg" class="waitmsg"></p>


                        </div>

                    </div>


                </div>
            </div>


            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>



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
                        <input id="pac-input1" class="controls" type="text" placeholder="Search Location" style="position: absolute;width: 15.5em;margin-left: 130px;z-index: 1050;">
                        <!--onfocus="initAutocomplete(2)"--> 
                        <div id="editmodalmap" class="col-md-8 col-sm-12"></div>
                        <div class="col-md-4 col-sm-12">
                            <form id="zoneform" data-parsley-validate="" class="form-horizontal form-label-left">

                                <div class="form-group">
                                    <label for="fname" class="col-sm-3 control-label">City<span style="" class="MandatoryMarker"> *</span></label>
                                    <div class="col-sm-6">
                                        <input type="text"  id="editCityName" name="editCityName"  class="form-control error-box-class" autocomplete="on" style="text-transform:capitalize;" readonly>
                                    </div>
                                    <div class="col-sm-3 error-box errors" id="editcityNameErr"></div>
                                    <input type="hidden" id="editcityNameOnly" name="editcityNameOnly">

                                </div>

                                <div class="form-group">
                                    <label for="fname" class="col-sm-3 control-label">Country</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="editcoutryName" name="editcoutryName" class="form-control error-box-class" disabled>

                                    </div>

                                </div>

                            </form>

                            <div class="form-group" style="margin-left: 8%;">
                                <div id="pointsinfo"></div>
                            </div>
                            <div class="form-group">
                                <button id='saveeditzone' style="margin-left:6.5%;" class="btn btn-success">Save</button>
                                <button type="button" id="cancelEditZoneModal" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button><br>
                                <p id="editmsg" class="waitmsg"></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="EditCityID" id="EditCityID">

<div class="modal fade stick-up" id="deleteZonePopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">DELETE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox" style="text-align:center">Do you want to delete city/cities..?</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="deleteZone" >Delete</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>





   <!--<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE&sensor=false&libraries=places&language=en-AU"></script>-->
<script>

    var options = {
        types: ['(cities)']
    };
    var input = document.getElementById('pac-input');
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        var country = "";
        var state = "";
        for (var i = 0; i < place.address_components.length; i++) {
            for (var j = 0; j < place.address_components[i].types.length; j++) {
                if (place.address_components[i].types[j] == "country")
                    $('#coutryName').val(place.address_components[i].long_name);
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
       
        $('#cityNameOnly').val(place.name);
    });
//    var autocomplete = new google.maps.places.Autocomplete($("#pac-input")[0], {types: ['(cities)']});
//
//    google.maps.event.addListener(autocomplete, 'place_changed', function () {
//        var place = autocomplete.getPlace();
//
//        //Get latlong
//
//        var geocoder = new google.maps.Geocoder();
//        geocoder.geocode({'address': '' + $("#pac-input").val()}, function (results, status) {
//            if (status == google.maps.GeocoderStatus.OK) {
//                $('#latitude').val(results[0].geometry.location.lat());
//                $('#longitude').val(results[0].geometry.location.lng());
//            } else {
//                alert("Something got wrong " + status);
//            }
//        })
//
//        //get country
//        $.ajax({
//            url: "https://maps.googleapis.com/maps/api/geocode/json?address=" + $("#pac-input").val() + "&sensor=false",
//            type: "POST",
//            success: function (res) {
//
//                address = res.results[0].geometry.location.lat + ',' + res.results[0].geometry.location.lng;
//                geocoder = new google.maps.Geocoder();
//
//                geocoder.geocode({'address': address}, function (results, status) {
//                    if (status == google.maps.GeocoderStatus.OK) {
//
//                        for (var component in results[0]['address_components']) {
////                                                                          console.log(results[0]['address_components']);
//                            for (var i in results[0]['address_components'][component]['types']) {
//
//
//                                if (results[0]['address_components'][component]['types'][i] == "country") {
//
//                                    $('#coutryName').val(results[0]['address_components'][component]['long_name']);
//                                }
//
//                                if (results[0]['address_components'][component]['types'][i] == "locality") {
//
//                                    $('#pac-input').val(results[0]['address_components'][component]['long_name']);
//                                    $('#cityNameOnly').val(results[0]['address_components'][component]['long_name']);
//                                }
//                            }
//                        }
//
//
//                    } else {
//                        alert('Invalid Zipcode');
//                    }
//                    //Check if city is already exists
//
//
//                });
//
//
//
//            }
//        });
//
//    });
//
//    function getCityCountry(address)
//    {
//        console.log(address);
//        $.ajax({
//            url: "https://maps.googleapis.com/maps/api/geocode/json?address=" + address + "&sensor=false",
//            type: "POST",
//            success: function (res) {
//
////                                                              address = res.results[0].geometry.location.lat+','+res.results[0].geometry.location.lng;
//                geocoder = new google.maps.Geocoder();
//
//                geocoder.geocode({'address': address}, function (results, status) {
//                    if (status == google.maps.GeocoderStatus.OK) {
//
//                        for (var component in results[0]['address_components']) {
//                            console.log(results[0]['address_components']);
//                            for (var i in results[0]['address_components'][component]['types']) {
//
//                                if (results[0]['address_components'][component]['types'][i] == "country") {
//
//                                    $('#coutryName').val(results[0]['address_components'][component]['long_name']);
//                                }
//
//                                if (results[0]['address_components'][component]['types'][i] == "locality") {
//
//                                    $('#pac-input').val(results[0]['address_components'][component]['long_name']);
//                                    $('#cityNameOnly').val(results[0]['address_components'][component]['long_name']);
//                                }
//                            }
//                        }
//                        //Check if city is already exists
////                                                                            console.log($('#pac-input').val());
////                                                                            console.log(cities);
//                        $('#cityExistsName').val($('#pac-input').val());
//                        if ($.inArray($('#pac-input').val(), cities) == -1)
//                        {
//
//                        } else {
//                            $('#cityNameOnly').val('');
//                            $('#pac-input').val('');
//                            $('#coutryName').val('');
//                            $('#cityExistsPopUp').modal('show');
//                        }
//                    } else {
//                        alert('Invalid Zipcode');
//                    }
//
//
//                });
//
//
//
//            }
//        });
//
//
//
//    }

</script>
<div class="modal fade stick-up" id="cityExistsPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">ALERT</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox" style="text-align:center">This city is already exists..! Do you want to activate it</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="activateCity" >Activate</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>