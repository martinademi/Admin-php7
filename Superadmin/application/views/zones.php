
<style>


    /*  .colon{
          margin-top: 2%;
            margin-left: -7%;
      }*/

    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .nav-tabs-fillup  bg-white{
        height: 65px;
    }

    h1, h2, h3, h4, h5, h6 {
        color: aliceblue;

    }

    .container-fluid{
        padding-left: 0px;
    }

    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

    strong {
        display: none;
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

    .modal-header,
    .modal-footer {
        color: white;
        background-color: grey;
    }

    .modal-header,
    .modal-footer button {
        color: white;
        background-color: grey;
    }

    #addmodalmap,
    #mapPolygon,
    #editmodalmap {
        height: 600px;
    }

    #zoneform label {
        margin-left: 12px;
    }

    #zoneform .pointscontrols {
        margin-top: 2px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
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

    #cities,
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

    .modal .modal-header p {
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
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    .pac-container {
        font-family: Roboto;
        z-index: 99999;
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



<script>
 var infoWindow;
    //Surge Price should be either in decimal/Number
    $(document).ready(function () {

        $('#editzonesurge_price,#zonesurge_price').keypress('click', function (event) {

            return isNumber(event, this)

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

    function loadScript() {
        var script = document.createElement("script");
        script.src = "http://maps.googleapis.com/maps/api/js?libraries=drawing,places&callback=initMap";
        document.body.appendChild(script);
    }

    window.onload = loadScript;


//initializing the google map
    function initMap() {
        var map = new google.maps.Map(document.getElementById('mapPolygon'), {
            center: {
                lat: 12.966
                , lng: 77.566
            }
            , zoom: 10
        });


//Map does not load in a modal window until it is resized
        google.maps.event.addListenerOnce(map, 'idle', function () {
            google.maps.event.trigger(map, 'resize');
        });

        //ajax request to get all the zone and draw on the map
        var zone = [];
        var datafromserver = null;

        $.getJSON("http://107.170.65.252/roadyo1.0/zones_map/zonemapsapi.php", function (data, status) {

            datafromserver = data;

            if (data.length > 0) {
                $('#mainmsg').text('loading zones..');
                for (var iZone = 0; iZone < data.length; iZone++) {
                    zone[iZone] = new google.maps.Polygon(data[iZone].polygonProps);
                    zone[iZone].setMap(map);

                    var latLng = {lat: data[iZone].polygonProps.paths[0].lat, lng: data[iZone].polygonProps.paths[0].lng};
                    infoWindow = new google.maps.InfoWindow;

                    var Str = '<b>' + data[iZone].title + '</b><br> Fare:' + data[iZone].surge_price + ' X';


                    infoWindow.setContent(Str);
                    infoWindow.setPosition(latLng);
                    infoWindow.open(map);
                }
//            $('#mainmsg').text('all zones loaded');
                $('#mainmsg').text('');
            } else {
                $('#mainmsg').text('No zones to load');
            }
        });

    }

//----------------addnewzone-----------------------------------

    var map;

    function addNewZone(customerlat, customerlong) {
//        alert(customerlat);
//        alert(customerlong);
        //12.972442010578353,77.5909423828125

        var newPolygon = null;

        map = new google.maps.Map(document.getElementById('addmodalmap'), {
            center: {
                lat: customerlat
                , lng: customerlong
            }
            , zoom: 13
        });

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

        var polygonCoordinates = [];
        var polygonCoordinates1 = [];


        //To create and fill the points input boxes of the newly created polygon
        function fillPathsInput(polygon) {
            newPolygon = polygon;
            var len = polygon.getPath().getLength();
            var htmlStr = "";

            for (var i = 0; i < len; i++) {
                htmlStr += "<label>Point" + (i + 1) + " </label> <input type='number' id='p" + (i + 1) + "lat' value='" + polygon.getPath().getAt(i).lat() + "' class='pointscontrols' readonly><input type='number' id='p" + (i + 1) + "lng' value='" + polygon.getPath().getAt(i).lng() + "' class='pointscontrols' readonly><br>";
            }
            $('#info').html(htmlStr);
            $('#savezone').show();
        }

        $("form").submit(function (event) {
            event.preventDefault();
        });

        $('#savezone').hide();

        //To save the zone details in the database
        $('#savezone').click(function (e) {
//            alert($('#city_selection_add').val());


            if ($('#zonetitle').val() == '' || $('#zonetitle').val() == null)
            {
                alert("Please provide the zone title");
            } else if ($('#zonesurge_price').val() == '' || $('#zonesurge_price').val() == null)
            {
                alert("Surge price should not be empty");
            } else if ($('#zonecity').val() != "" && $('#zonetitle').val() != "" && $('#zonesurge_price').val() != "") {

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
                    coordinates1.push([newPolygon.getPath().getAt(i).lng(),newPolygon.getPath().getAt(i).lat()]);
                }

                coordinates1.push(coordinates1[0]);
//                alert(JSON.stringify(coordinates1));

                polygonCoordinates1.push(coordinates1);




                var polygonProperties = {
                    "paths": polygonCoordinates
                    , "strokeColor": "#00FF00"
                    , "strokeOpacity": 0.8
                    , "strokeWeight": 2
                    , "fillColor": "#00FF00"
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
                    "city": $('#city_selection_add').val(),
                    "title": $('#zonetitle').val(),
                    "surge_price": $('#zonesurge_price').val(),
                    "polygonProps": polygonProperties,
                    "polygons": polygonProperties1     //changed Done 08-05-2016
                }

                $('#addmsg').text("please wait..")

                $.post("http://107.170.65.252/roadyo1.0/zones_map/zonemapsapi.php", JSON.stringify(data)
                        , function (data, status) {
                            if (data.status == 'success') {
                                //alert("zone added successfuly");
//                                $('#addZoneModal').modal
                                $('#addZoneModal').modal('toggle');
//                                $('#addmsg').text("Zone added successfuly").toggleClass("success");
                                clearFields();
                            } else if (data.status == 'error') {
                                //alert("unable to update!");
                                $('#addmsg').text("unable to update please try again").addClass("error");
                                ;
                                clearFields();
                            }
                        });
            }

        });

        function clearFields() {
            addNewZone();
            $('#zonecity').val("");
            $('#zonetitle').val("");
            $('#zonesurge_price').val("");
            $('#info').html("");
            $('#savezone').hide();
            polygonCoordinates.splice(0, polygonCoordinates.length);
            newPolygon = null;
        }

        google.maps.event.addListener(drawingManager, 'polygoncomplete'
                , function (polygon) {

                    // Switch back to non-drawing mode after drawing a shape.
                    drawingManager.setMap(null);

                    fillPathsInput(polygon);

                    google.maps.event.addListener(polygon.getPath(), 'set_at', function () {
                        fillPathsInput(polygon);
                    });

                    google.maps.event.addListener(polygon.getPath(), 'insert_at', function () {
                        fillPathsInput(polygon);
                    });
                });

        //To refresh the page to get the newly added zone
        $('#addZoneModal').on('hidden.bs.modal', function () {
            window.location.reload(true);
        });

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


//initializing autocomplete to search for places
    function initAutocomplete() {
        // Create the search box and link it to the UI element.
//        var input = document.getElementById('pac-input');
        var input = $('#city_selection_add').val();
        alert(input);
        var searchBox = new google.maps.places.SearchBox(input);
        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function () {
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
                var icon = {
                    url: place.icon
                    , size: new google.maps.Size(71, 71)
                    , origin: new google.maps.Point(0, 0)
                    , anchor: new google.maps.Point(17, 34)
                    , scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map
                    , icon: icon
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
            map.fitBounds(bounds);
        });
    }

//---------------edit zone details--------------------------------

   
    function loadExistingZones() {

        var map;
        var newPolygon = null;
        var datafromserver = null;
        var overlays = [];



        //creating a map 
        map = new google.maps.Map(document.getElementById('editmodalmap'), {
            center: {
                lat: 12.972442010578353
                , lng: 77.5909423828125
            }
            , zoom: 13
        });




        //Map does not load in a modal window until it is resized
        google.maps.event.addListenerOnce(map, 'idle', function () {
            google.maps.event.trigger(map, 'resize');
        });



        /*ajax request to get all the details of polygon*/
        $.getJSON("http://107.170.65.252/roadyo1.0/zones_map/zonemapsapi.php", function (data, status) {

            datafromserver = data;

            var uniqueCities = $.unique(data.map(function (d) {
                return d.city;
            }));

            var citiesslthtml = "";

            for (var index in uniqueCities) {
                citiesslthtml += "<option value=\"" + uniqueCities[index] + "\">" + uniqueCities[index] + "</option>";
            }
            $("#cities").html(citiesslthtml);

            $("#editnow").trigger('click');

        });

        $('#cities').change(function ()
        {
            while (overlays[0]) {
                overlays.pop().setMap(null);
                infoWindow.open(null);
            }

            $("#editnow").trigger('click');
        });


        $("#editnow").click(function () {
            var selectedCity = $("#cities option:selected").val();



            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'address': selectedCity
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {

                    var latlng = {
                        lat: results[0].geometry.location.lat()
                        , lng: results[0].geometry.location.lng()
                    };
                    map.setCenter(latlng);
                } else {
                    alert("unable to center map");
                }
            });

            drawZones(selectedCity);
        });

        //plots the zones or polygons on the map based on the selected city from dropdown
        function drawZones(selectedCity) {
            var zone = [];
            for (var iZone = 0; iZone < datafromserver.length; iZone++) {
                if (datafromserver[iZone].city == selectedCity) {
                    var polgonProperties = datafromserver[iZone].polygonProps;
                    polgonProperties.zoneIndex = iZone; //to add the array index of the polygon to its properties in the json object received from server

                    zone[iZone] = new google.maps.Polygon(polgonProperties);
                    zone[iZone].setMap(map);



                    zone[iZone].addListener('click', function () {
                        editZoneDetails(this);

                    });
                    overlays.push(zone[iZone]);

                    var latLng = {lat: datafromserver[iZone].polygonProps.paths[0].lat, lng: datafromserver[iZone].polygonProps.paths[0].lng};
                    infoWindow = new google.maps.InfoWindow;

                    var Str = '<b>' + datafromserver[iZone].title + '</b><br> Fare:' + datafromserver[iZone].surge_price + ' X';


                    infoWindow.setContent(Str);
                    infoWindow.setPosition(latLng);
                    infoWindow.open(map);

                }
            }

        }



        function editZoneDetails(polygon) {

            polygon.setEditable(true);
            polygon.setDraggable(true);

            $('#editzonecity').val(datafromserver[polygon.zoneIndex].city);
            $('#editzonetitle').val(datafromserver[polygon.zoneIndex].title);
            $('#editzonesurge_price').val(datafromserver[polygon.zoneIndex].surge_price);
            fillPathsInput(polygon);

            google.maps.event.addListener(polygon.getPath(), 'set_at', function () {
                fillPathsInput(polygon);
            });

            google.maps.event.addListener(polygon.getPath(), 'insert_at', function () {
                fillPathsInput(polygon);
            });

            google.maps.event.addListener(polygon, "mouseout", function () {
                polygon.setDraggable(false);
            });

            $('#saveeditzone').show();
            $('#deletezone').show();
        }

        var polygonCoordinates = [];
        var polygonCoordinates1 = [];

        //To create and fill the points input boxes of the edited polygon
        function fillPathsInput(polygon) {
            newPolygon = polygon;
            var len = polygon.getPath().getLength();
            var htmlStr = "";

            for (var i = 0; i < len; i++) {
                htmlStr += "<label>Point" + (i + 1) + " </label> <input type='number' id='p" + (i + 1) + "lat' value='" + polygon.getPath().getAt(i).lat() + "' class='pointscontrols' readonly><input type='number' id='p" + (i + 1) + "lng' value='" + polygon.getPath().getAt(i).lng() + "' class='pointscontrols' readonly><br>";
            }

            $('#pointsinfo').html(htmlStr);


        }

        $("form").submit(function (event) {
            event.preventDefault();
        });

        $('#saveeditzone').hide();
        $('#deletezone').hide();



        //To save the zone details in the database
        $('#saveeditzone').click(function () {

            if ($('#editzonetitle').val() == '' || $('#editzonetitle').val() == null)
            {
                alert("Please provide zone title");
            } else if ($('#editzonesurge_price').val() == '' || $('#editzonesurge_price').val() == null)
            {
                alert("Surge price should not be empty");
            } else if ($('#editzonecity').val() != "" && $('#editzonetitle').val() != "" && $('#editzonesurge_price').val() != "") {

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
                    coordinates1.push([newPolygon.getPath().getAt(i).lng(),newPolygon.getPath().getAt(i).lat()]);
                }
//
////                alert(JSON.stringify(coordinates1));
//                for (var i = 0; i < len; i++) {
//                    coordinates1[i]["distance"] = calculateDistance(newPolygon.getPath().getAt(0).lat(), newPolygon.getPath().getAt(0).lat(), newPolygon.getPath().getAt(i).lat(), newPolygon.getPath().getAt(i).lng(), "K");
//
//                }
//                coordinates1.sort(function (a, b) {
//                    return a.distance - b.distance;
//                });
                coordinates1.push(coordinates1[0]);
//                alert(JSON.stringify(coordinates1));

                polygonCoordinates1.push(coordinates1);



                //changed Done 08-05-2016
                var polygonProperties1 = {
                    "type": "Polygon",
                    "coordinates": polygonCoordinates1

                }

                var polygonProperties = {
                    "paths": polygonCoordinates
                    , "strokeColor": "#00FF00"
                    , "strokeOpacity": 0.8
                    , "strokeWeight": 2
                    , "fillColor": "#00FF00"
                    , "fillOpacity": 0.35
                    , "draggable": false
                    , "editable": false
                }


                var data = {
                    "id": datafromserver[newPolygon.zoneIndex]._id.$id
                    , "details": {
                        "city": $('#cities').val()
                        , "title": $('#editzonetitle').val()
                        , "surge_price": $('#editzonesurge_price').val()
                        , "polygonProps": polygonProperties,
                        "polygons": polygonProperties1     //changed Done 08-05-2016
                    }
                }

                $('#editmsg').text("please wait..")

                //To update the zone details
                $.ajax({
                    url: 'http://107.170.65.252/roadyo1.0/zones_map/zonemapsapi.php'
                    , dataType: "json"
                    , type: "PUT"
                    , contentType: 'application/json; charset=utf-8'
                    , data: JSON.stringify(data)
                    , async: true
                    , success: function (data) {
                        if (data.status == 'success') {
                            $('#editZoneModal').modal('toggle');
//                            $('#editmsg').text("zone updated successfuly").toggleClass("success");
                            clearFields();
                        } else if (data.status == 'error') {
                            //alert("unable to update!");
                            $('#editmsg').text("unable to update!").addClass("error");
                            clearFields();
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
                var deleteZoneId = {
                    "id": datafromserver[newPolygon.zoneIndex]._id.$id
                };

                $('#editmsg').text("please wait..")

                $.ajax({
                    url: 'http://107.170.65.252/roadyo1.0/zones_map/zonemapsapi.php'
                    , dataType: "json"
                    , type: "DELETE"
                    , contentType: 'application/json; charset=utf-8'
                    , data: JSON.stringify(deleteZoneId)
                    , async: true
                    , success: function (data) {
                        if (data.status == 'success') {
                            //alert("zone deleted successfuly");
                            $('#editZoneModal').modal('toggle');
//                            $('#editmsg').text("zone deleted successfuly").toggleClass("success");
                            clearFields();
                        } else if (data.status == 'error') {
                            //alert("unable to update!");
                            $('#editmsg').text("unable to delete!").addClass("error");
                            clearFields();
                        }
                    }
                    , error: function (xhr) {
                        alert('error');
                    }
                });
            }

        });

        function clearFields() {
            loadExistingZones();
            $('#editzonecity').val('');
            $('#editzonetitle').val('');
            $('#editzonesurge_price').val('');
            $('#pointsinfo').html('');
        }

        //To refresh the page after editing the zone
        $('#editZoneModal').on('hidden.bs.modal', function () {
            window.location.reload(true);
        });


    }


    $(document).ready(function ()
    {


        $('#city_select').change(function ()
        {
            
            var res = '';

            var city_id = $('#city_select').val();

            if (city_id != '#')
            {

                $.ajax({
                    url: '<?php echo base_url('index.php?/superadmin') ?>/selectCityZone',
                    data: {city_id: city_id},
                    dataType: 'JSON',
                    type: 'POST',
                    success: function (response)
                    {
                        
                        
                        $("#tableWithSearch tbody").remove();
                        var html;
                        for(var j = 0; j < response.length;j++)
                        {
                                var str = '';
                                if(response[j].city == city_id)
                                {
                                        for (var i = 0; i < response[j].polygonProps.paths.length; i++)
                                        {

                                            str += "P" + (i + 1) + "(" + response[j].polygonProps.paths[i].lat + "," + response[j].polygonProps.paths[i].lng + ")";

                                            if (i % 2 == 1)
                                                str += " <br>";
                                        }
                                         html += "<tr><td>"+(j+1)+"</td><td>" + response[j].city + "</td><td>" + response[j].title + "</td><td>" + response[j].surge_price + "</td><td>" + str + "</td></tr>";
                                 }
                        }
                        $('#tableWithSearch').append(html);
                    }
                });
            } else
            {
                window.location.reload(true);
            }

        });

        $('#city_selection_add').change(function ()
        {



            var customerlat;
            var customerlong;
            customerlat = $('#city_selection_add').children(":selected").attr("lat").trim();
            customerlong = $('#city_selection_add').children(":selected").attr("lng").trim();
//               initialize(customerlat,customerlong);
//            addNewZone(customerlat,customerlong);


            map.setCenter(new google.maps.LatLng(customerlat, customerlong));

        });


    });
</script>  

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        
        
       

        <h3 style="margin-top: 2%;margin-left: 3%;color: #0090d9;font-size: 20px;"><b>ZONES</b></h3>


        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="panel-heading">
                <div class="panel-title">
                </div>
                <div class="pull-left" style="margin-left: 2%;">

                    <div class="form-group ">
                        <select  class="form-control" id="city_select" aria-controls="tableWithSearch">
                            <option value="#">All</option>
                            <?php
                            foreach ($cities as $data) {
                                ?>
                                <option value="<?php echo $data->City_Name; ?>" lat="<?php echo $data->City_Lat; ?>" lng="<?php echo $data->City_Long; ?>"><?php echo $data->City_Name; ?></option>    
                                <?php
                            }
                            ?>

                        </select>  
                         <!--<input id="search-table" class="form-control pull-right" placeholder="Search" type="text" aria-controls="tableWithSearch">-->

                    </div>

                </div>
                <div class="pull-right">
                    <div class="col-xs-12">
                        <button data-toggle="modal" class="btn btn-primary btn-cons" data-target="#addZoneModal" onclick="addNewZone(12.972442010578353, 77.5909423828125)"> <i class="fa fa-plus"></i> Add Zone </button>
                        <button data-toggle="modal" class="btn btn-primary" data-target="#editZoneModal" onclick="loadExistingZones()"> <i class="fa fa-edit"></i> Edit zone</button>
                        <button data-toggle="modal" class="btn btn-primary btn-cons" data-target="#map_display" onclick="initMap()"> View On Map </button>
                        <!--                            <a href="addNewUser">
                                                        <button id="show-modal" class="btn btn-primary btn-cons"><i class="fa fa-plus"></i>  Add Zone</button>
                                                    </a>-->
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>





            <div id="big_table_wrapper" class="dataTables_wrapper no-footer" style="margin-left: 4%;" id="all_cities">
                <div class="table-responsive">
                    <table id="tableWithSearch" border="1"  data-filter="true"  data-input="#city_select" cellpadding="2" cellspacing="1" class="table table-hover demo-table-search dataTable no-footer" role="grid" aria-describedby="big_table_info" style="margin-top: 30px;" >
                        <thead>
                            <tr style="font-size:20px" role="row">
                                <th class="sorting ui-state-default sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 68px;" aria-sort="ascending">
                                    <div class="DataTables_sort_wrapper">Sl No.<span class="DataTables_sort_icon css_right ui-icon ui-icon-triangle-1-n"></span></div>
                                </th><th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 127px;"><div class="DataTables_sort_wrapper">CITY<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 127px;"><div class="DataTables_sort_wrapper">TITLE<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th><th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 127px;"><div class="DataTables_sort_wrapper">SURGE FACTOR<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 127px;"><div class="DataTables_sort_wrapper">POLYGON POINTS<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $start = 1;
                            foreach ($zones_data as $data) {
                                ?>

                                <tr role="row" class="odd">
                                    <td><?php echo $start++; ?></td>
                                    <td><?php echo $data['city']; ?></td>
                                    <td><?php echo $data['title']; ?></td>
                                    <td><?php echo $data['surge_price']; ?></td>
                                    <td><?php
                                        $count = 1;
                                        foreach ($data['polygonProps']['paths'] as $points) {

                                            echo 'P' . $count . "(" . ucwords($points['lat']) . "," . ucwords($points['lng']) . ")";
                                            echo " ";
                                            if (($count % 2) == 0)
                                                echo ' <br>';
                                            $count++;
                                        }
                                        ?></td>

                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>  

                    </table></div></div>


        </div>
    </div>

    <!--Add Zone Modal -->
    <div class="modal fade" id="addZoneModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title displayinline" style="">Add new zone</h4>
                    <p id="addmsg" class="waitmsg"></p>
                </div>
                <div class="modal-body" style="padding-top:1%;">
                    <div class="container-fluid">
                        <div class="row">
                            <div id="addmodalmap" class="col-md-8 col-sm-12"></div>
                            <div class="col-md-4 col-sm-12">
                                <div class="row">
    <!--                                <input id="pac-input" class="controls" type="text" placeholder="Enter the city/place to center the map" onfocus="initAutocomplete()">-->

                                </div>
                                <form id="zoneform">

                                    <div class="control-group row" style="margin-top:8%;">
                                        <div class="col-sm-3"><label for="zonecity" class="control-label">Select City</label></div>
                                        <div class="col-sm-1 colon">:</div>
                                        <div class="col-sm-6" style="margin-top:-1%;"> 
    <!--                                        <input type="text" id="zonecity" placeholder="Enter city name"  class="controls">-->
                                            <select id="city_selection_add" class="form-control">
                                                <option value="#">Select</option>
                                                <?php
                                                foreach ($cities as $data1) {
                                                    foreach($data1['cities'] as $data){
                                                        if($data['isDeleted'] == FALSE){
                                                    ?>
                                                    <option value="<?php echo $data['cityId']['$oid']; ?>" lat="<?php echo $data['lat']; ?>" lng="<?php echo $data['lng']; ?>"><?php echo $data['cityName']; ?></option>    
                                                    <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="control-group row" style="margin-top:9%;">
                                        <div class="col-sm-3"><label for="zonetitle" class="control-label">Zone Title</label></div>
                                        <div class="col-sm-1 colon">:</div>
                                        <div class="col-sm-6 " style="margin-top:-4%;"> 
                                            <input type="text" id="zonetitle" placeholder="Enter zone title"  class="form-control">
                                        </div>
                                    </div>


                                    <div class="control-group row" style="margin-top:9%;">
                                        <div class="col-sm-3"> <label for="zonesurge_price">Surge Factor</label></div>
                                        <div class="col-sm-1 colon">:</div>
                                        <div class="col-sm-6" style="margin-top:-4%;"> 
                                            <input type="text" id="zonesurge_price" placeholder="Entet zone surge factor"  class="form-control">
                                        </div>
                                        <div style="clear:both;">
                                            <br>
                                            <span style="color: cornflowerblue;font-size: 16px;">*</span>
                                            <small>Surge factor is multiplied with fare setup for the linked vehicle types for that zone</small></div>
                                    </div>



                                    <br> <br>
                                    <div id="info"></div>
                                    <button id='savezone' style="margin-left: 16%;margin-top: 10%;" class="btncontrols">Save zone</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="  margin-top: 1%;">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--Edit Zone Modal -->
    <div class="modal fade" id="editZoneModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <!--                <label>Select City</label>
                                    <select id="cities" style="width:9%;"></select>-->
                    <button id="editnow" style="display:none;">Edit</button>
                    <p id="editmsg" class="waitmsg"></p>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div id="editmodalmap" class="col-md-8 col-sm-12"></div>
                            <div class="col-md-4 col-sm-12">
                                <form id="zoneform">



                                    <div class="control-group row" style="margin-top:9%;">
                                        <div class="col-sm-3"><label for="editzonecity">Zone City</label></div>

                                        <div class="col-sm-1 colon">:</div>
                                        <div class="col-sm-6" style="margin-top:-2%;"> 
                                            <select id="cities" style="width:88%;" class="form-control"></select></div>
                                    </div>


                                    <div class="control-group row" style="margin-top:9%;">
                                        <div class="col-sm-3"><label for="editzonetitle">Zone Title</label></div>
                                        <div class="col-sm-1 colon">:</div>
                                        <div class="col-sm-6" style="margin-top:-2%;"> <input class="form-control" type="text" id="editzonetitle" placeholder="Enter zone title"  class="controls"></div>
                                    </div>


                                    <div class="control-group row" style="margin-top:9%;">
                                        <div class="col-sm-3"><label for="editzonesurge_price">Surge Factor</label></div>
                                        <div class="col-sm-1 colon">:</div>
                                        <div class="col-sm-6" style="margin-top:-2%;">  <input class="form-control" type="text" id="editzonesurge_price" placeholder="Enter surge factor"  class="controls">
                                        </div>
                                        <div style="clear:both;">
                                            <br>
                                            <span style="color: cornflowerblue;font-size: 16px;">*</span>
                                            <small>Surge factor is multiplied with fare setup for the linked vehicle types for that zone</small></div>
                               
                                        
                                    </div>



                                    <br> <br>
                                    <div id="pointsinfo"></div>
                                    <button id='saveeditzone' style="margin-left: 31%;margin-top: 11%;" class="btncontrols">Save zone</button>
                                    <button id="deletezone" class="btncontrols">Delete zone</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="  margin-top: 1%;">Close</button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="map_display" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <label style="font-size:18px;">All Polygons</label>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div id="mapPolygon"  class="col-sm-12"></div>

                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="  margin-top: 1%;">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  <div id="map"></div>