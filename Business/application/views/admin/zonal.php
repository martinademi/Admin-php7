<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);
$enable = 'disabled';
if ($Admin == '1') {
    $enable = 'required';
}
?>

<style>
    .fa-dollar:before {
        content: "$";
    }
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .nav-tabs-fillup  bg-white{
        height: 65px;
    }
    .form-control{
        background-color: white;
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

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}

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

    #zoneform .pointscontrols {
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
        font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
        font-size: 15px;
        font-weight: 300;
        /*margin-left: 12px;*/
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
        font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
        font-size: 15px;
        font-weight: 300;
        /*margin-left: 12px;*/
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        border-radius: 5px;
    }

    #pac-input1:focus {
        border-color: #4d90fe;
    }

    #pac-input2 {
        background-color: #fff;
        font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
        font-size: 15px;
        font-weight: 300;
        /*margin-left: 12px;*/
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        border-radius: 5px;
    }

    #pac-input2:focus {
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

    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid,#tableWithSearch_length,#tableWithSearch_filter{
        display: none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>

<script src="https://maps.googleapis.com/maps/api/js?v=3&libraries=drawing,places&key=AIzaSyBm-C5-fDUpvqMaT_8wfAZXXI56hVcFk4g"></script>
<script src="http://104.131.66.74/Grocer/sadmin/theme/ZoneMapAssets/javascript.util.min.js"></script>
<script src="http://104.131.66.74/Grocer/sadmin/theme/ZoneMapAssets/jsts.min.js"></script>
<script src="http://104.131.66.74/Grocer/sadmin/theme/ZoneMapAssets/wicket.js"></script>
<script src="http://104.131.66.74/Grocer/sadmin/theme/ZoneMapAssets/wicket-gmap3.js"></script>
<script>
    var map;
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
                lat: 12.972442010578353
                , lng: 77.5909423828125
            }
            , zoom: 10
        });

        google.maps.event.addListenerOnce(mapview, 'idle', function () {
            google.maps.event.trigger(mapview, 'resize');
        });

        google.maps.event.addListenerOnce(mapview, 'idle', function () {
            google.maps.event.trigger(mapview, 'resize');
        });

        $.getJSON("http://104.131.66.74/Grocer/sadmin/index.php/superadmin/zonemapsapi", function (data, status) {
            datafromserver_view = data;
            var uniqueCities = $.unique(data.map(function (d) {
                console.log(d);
                return d.city;
            }));

            var citiesslthtml = "";

            for (var index in uniqueCities) {
                citiesslthtml += "<option value=\"" + uniqueCities[index] + "\">" + uniqueCities[index] + "</option>";
            }
            $("#city_selection_view").html(citiesslthtml);
//            $("#city_selection_view").select2();
            $("#city_selection_view").trigger('change');
        });
    }

    $(document).ready(function () {
        $('#city_selection_view').change(function ()
        {
            if (selectedCity_view != $("#city_selection_view option:selected").val()) {
                $('#pac-input2').val('');
                selectedCity_view = $("#city_selection_view option:selected").val();
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

                var Str = '<b>' + datafromserver_view[iZone].title + '</b>';//<br> Fare:' + datafromserver_view[iZone].surge_price + ' X';

                inf.setContent(Str);
                inf.setPosition(latLng);
                inf.open(mapview);
                infoWindow_view.push(inf);
            }
        }
    }


</script>
<script type="text/javascript">

    function changeD(id) {
        var type = $('#Drivertype').val();
//            console.log(type ); // 0 - jaiecom, 1 - srote, 2 - offline

        if (type == 0) {
            if (<?php echo $Admin ?> == '0') {
                $("#deliverychrg").attr("disabled", "disabled");
            }
            var zoneid = $('#zone').val();
//                console.log(zoneid);
            $.ajax({
                url: "<?php echo base_url('index.php/Admin') ?>/getjaiecom_deliverychg",
                type: "POST",
                data: {zoneid: zoneid},
                dataType: "JSON",
                success: function (result) {
//                        console.log(result);
                    $.each(result, function (index, row) {
//                                     console.log(row.Basefare);
                        $('#deliverychrg').val(row.deliverychrg);
                    });
                }
            });
        } else if (type == 1) {
        
            if (<?php echo $Admin ?> == '0') {
                $("#deliverychrg").removeAttr("disabled");
            }
            $('#deliverychrg').val('')
        } else if (type == 2) {
//                        console.log('offline', type);
            if (<?php echo $Admin ?> == '0') {
                $("#deliverychrg").removeAttr("disabled");
            }
            $('#deliverychrg').val('')
        }
    }

    function editchangeD(id) {

        var type = $('#edit_Drivertype').val();
//            console.log(type ); // 0 - jaiecom, 1 - srote, 2 - offline

        if (type == 0) {

            if (<?php echo $Admin ?> == '0') {
                $("#edit_deliverychrg").attr("disabled", "disabled");
            }
            var zoneid = $('#edit_zone').val();
//                console.log(zoneid);
            $.ajax({
                url: "<?php echo base_url('index.php/Admin') ?>/getjaiecom_deliverychg",
                type: "POST",
                data: {zoneid: zoneid},
                dataType: "JSON",
                success: function (result) {
                    console.log(result);
                    $.each(result, function (index, row) {
                                     console.log(row.deliverychrg);
//                        if(row.deliverychrg){
                        $('#edit_deliverychrg').val(row.deliverychrg);
//                        }else{
//                           $("#edit_deliverychrg").removeAttr("disabled");
//                        }
                    });
                }
            });
        } else if (type == 1) {

            if (<?php echo $Admin ?> == '0') {
                $("#edit_deliverychrg").removeAttr("disabled");
            }
        } else if (type == 2) {
            
            if (<?php echo $Admin ?> == '0') {
                $("#edit_deliverychrg").removeAttr("disabled");
            }
        }
    }

</script>

<script>
    $(document).ready(function ()
    {
        $('#tableWithSearch').DataTable();
        $('#search-table').keyup(function ()
        {
            searchTable($(this).val());
        });
    });

    function searchTable(inputVal)
    {
        var table = $('#tableWithSearch');
        table.find('tr').each(function (index, row)
        {
            var allCells = $(row).find('td');
            if (allCells.length > 0)
            {
                var found = false;
                allCells.each(function (index, td)
                {
                    var regExp = new RegExp(inputVal, 'i');
                    if (regExp.test($(td).text()))
                    {
                        found = true;
                        return false;
                    }
                });
                if (found == true)
                    $(row).show();
                else
                    $(row).hide();
            }
        });
    }

</script>

<script>

    $(document).ready(function () {

        $('#insert').click(function () {
            $('.clearerror').text("");

            var zone = $("#zone").val();
            var Drivertype = $("#Drivertype").val();
            var deliverychrg = $("#deliverychrg").val();
//            var miniorder = $("#miniorder").val();
//            var freeorder = $("#freeorder").val();

            if (zone == "" || zone == null)
            {
                $("#clearerror").text("Please select the zone");
            } else if (Drivertype == "" || Drivertype == null)
            {
                $("#clearerror").text("Please select the driver type");
            } else if (deliverychrg == "" || deliverychrg == null)
            {
                $("#clearerror").text("Please enter the delivery charge ");
            }
//            else if (miniorder == "" || miniorder == null)
//            {
//                $("#clearerror").text("Please enter the minimum order value ");
//            } else if (freeorder == "" || freeorder == null)
//            {
//                $("#clearerror").text("Please enter the free order value ");
//            }
            else {

                $('#addentity').submit();
                $("#zone").val('0');
                $("#Drivertype").val('0');
                $("#deliverychrg").val('');
            }
        });

        $('#useredit').click(function () {
            $('.clearerror').text("");
//            var providername = $("#businessname").val();
            var zone = $("#edit_zone").val();
            var Drivertype = $("#edit_Drivertype").val();
            var deliverychrg = $("#edit_deliverychrg").val();
            
            console.log(deliverychrg);
            
//            var miniorder = $("#edit_miniorder").val();
//            var freeorder = $("#edit_freeorder").val();

            if (zone == "" || zone == null)
            {
                $("#clearerror").text("Please select the zone");
            } else if (Drivertype == "" || Drivertype == null)
            {
                $("#clearerror").text("Please select the driver type");
            } else if (deliverychrg == "" || deliverychrg == null)
            {
                $("#clearerror").text("Please enter the delivery charge ");
            }
//            else if (miniorder == "" || miniorder == null)
//            {
//                $("#clearerror").text("Please enter the minimum order value ");
//            } else if (freeorder == "" || freeorder == null)
//            {
//                $("#clearerror").text("Please enter the free order value ");
//            }
            else
            {
                $('#editentity').submit();
            }
        });


        $('#btnStickUpSizeToggler').click(function () {

            $('#Default').prop('checked', false);
            $("#display-data").text("");

            $.ajax({
                url: "<?php echo base_url('index.php/Admin') ?>/get_mileagealldata",
                type: "POST",
                data: {},
                dataType: 'json',
                success: function (response)
                {

                    $.each(response, function (index, row) {
//                        console.log(row.count);
                        if (row.count < "3") {
                            $('#modalHeading').html(<?php echo json_encode(SELECT_COUNTRY_ANDBUSINESS_COMMISSION); ?>);
                            var size = $('input[name=stickup_toggler]:checked').val()
                            var modalElem = $('#myModal');
                            if (size == "mini") {
                                $('#modalStickUpSmall').modal('show')
                            } else {
                                //                alert('else');
                                $('#myModal').modal('show')
                                if (size == "default") {
                                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                                } else if (size == "full") {
                                    modalElem.children('.modal-dialog').addClass('modal-lg');
                                }
                            }
                        } else {
                            $('#displayData').modal('show');
                            $("#display-data").text("can not add more mileage settings");
                        }
                    });
////                                alert(response.length);

                }
            });


        });
//       
        $('#edit').click(function () {

            $('#modalHeading').html("Edit User");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
//            alert(val);

            $('#user_id').val(val);

            if (val.length < 1) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select any one Driver to edit");
            } else if (val.length == 1)
            {
//                 alert(val);
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#editModal');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else {

                    $.ajax({
                        url: "<?php echo base_url('index.php/Admin') ?>/get_zonaldata",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (response)
                        {
//                            console.log(response);
////                                alert(response.length);
                            $.each(response, function (index, row) {
//                                      alert(row.Email);
                                $('#edit_zone').val(row.Zoneid);
                                $('#edit_Drivertype').val(row.DriverType);
                                $('#edit_deliverychrg').val(row.Deliverycharge);
//                                $('#edit_miniorder').val(row.Miniorder);
//                                $('#edit_freeorder').val(row.Freeorder);

                                if ($('#edit_Drivertype').val() == 0)
                                {
//                                    $("#edit_deliverychrg").attr("readonly", "readonly");

                                } else {
//                                    $("#edit_deliverychrg").removeAttr("readonly");
                                }

                            });
                        }
                    });

                    $('#editModal').modal('show')

                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }

                }


            } else if (val.length > 1)
            {
                //      alert("select atleast one passenger");
                $('#displayData').modal('show');
                $("#display-data").text("Please select only one Driver to edit");
            }
        });

        $('#fdelete').click(function (e) {
//            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select any one  to delete");
            } else if (val.length == 1)
            {
                $("#display-data").text("");
                var id = val;
                //                       alert(id);
                //                    alert(BusinessId);
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodel');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#confirmmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full")
                    {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $("#confirmed").click(function () {
                    //                        else if (confirm("Are you sure to Delete this company")) {

                    $.ajax({
                        url: "<?php echo base_url('index.php/Admin') ?>/delete_zonal",

                        type: "POST",
                        data: {
                            id: id,
                        },

                        dataType: 'json',
                        success: function (response)
                        {
                            //                                   alert(id);
                            $(".close").trigger("click");
                            location.reload();
                        }
                    });

                });
            } else if (val.length > 1)
            {
                $('#displayData').modal('show');
                $("#display-data").text("Please select only one  to delete");
            }

        });

    });


</script>

<style>
    #active{
        display:none;
    }
    .exportOptions{
        display: none;
    }
</style>

<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content" style="  padding-top: 30px;">

        <div class="brand inline breadcrumb" style="">
            <strong>ZONAL PRICING</strong><!-- id="define_page"-->
        </div>

        <div class="add_new">
            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="fdelete" style="margin-bottom:0px;background: #d9534f !important;border-color: #d9534f !important;">Delete</button></a></div>
            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="edit" style="margin-bottom:0px;background: #5bc0de !important;border-color: #5bc0de !important;">Edit</button></div>
            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="btnStickUpSizeToggler" style="margin-bottom:0px;background: #337ab7 !important;border-color: #337ab7 !important;"><span>Add</button></div>
            <div class="pull-right m-t-10"><button data-toggle="modal" class="btn btn-primary btn-cons " data-target="#map_display" onclick="viewzones()">View On Map </button></div>
        </div>
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax" style="padding:0px;">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20" style="padding:0px;">

                <div class="panel panel-transparent ">

                    <div class="tab-content">

                        <div class="container-fluid container-fixed-lg bg-white">
                            <!--START PANEL--> 
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <!--<div class="error-box" id="display-data" style="text-align:center"></div>-->
                                    <div class="modal fade" id="displayData" role="dialog">
                                        <div class="modal-dialog modal-sm">                                        
                                            <!-- Modal content-->
                                            <div class="modal-content">                                            
                                                <div class="modal-body">
                                                    <h5 class="error-box" id="display-data" style="text-align:center"></h5>                                            
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>     
                                    <!--<div id="big_table_processing" class="dataTables_processing" style=""><img src="http://www.ahmed-samy.com/demos/datatables_2/assets/images/ajax-loader_dark.gif"></div>-->
                                    <div class="searchbtn row clearfix pull-right" >
                                        <div class="pull-right">
                                            <div class="col-xs-12" style="margin: 10px 0px;">
                                                <input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>">
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                                <br>
                                <div class="panel-body">



                                    <div class="dataTables_wrapper form-inline no-footer" id="tableWithDynamicRows_wrapper">
                                        <div class="table-responsive" style="overflow-x: hidden">

                                            <table aria-describedby="tableWithSearch_info" role="grid" class="table table-striped table-bordered table-hover demo-table-dynamic dataTable no-footer" id="tableWithSearch">
                                                <thead>

                                                    <tr>                                   
                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                                            Slno</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                                            Zone Name</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                                            Driver Type</th>
                <!--                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 0px;">
                                                            City</th>-->
                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 0px;">
                                                            Delivery Charge</th>
<!--                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 0px;">
                                                            Minimum Order</th>
                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 00px;">
                                                            Free Order</th>-->

                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 0px;">
                                                            Select</th>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    <?php
                                                    $start = 1;
                                                    $dev = [];
                                                    foreach ($table as $result) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $start++; ?></td>
                                                            <td><?php echo $result['zonetitle']; ?></td>
                                                            <td><?php
                                                                if ($result['DriverType'] == 0) {
                                                                    echo 'Grocer Driver';
                                                                } else if ($result['DriverType'] == 1) {
                                                                    echo 'Store Driver';
                                                                } else if ($result['DriverType'] == 2) {
                                                                    echo 'Offline Driver';
                                                                }
                                                                ?></td>
                                                            <td><?php echo $result['Deliverycharge']; ?></td>
                                                            <!--<td><?php echo $result['Miniorder']; ?></td>-->
                                                            <!--<td><?php echo $result['Freeorder']; ?></td>-->


                                                            <td><input type="checkbox" class="checkbox" value="<?php echo (string) $result['_id']['$oid']; ?>"></td>

                                                        </tr>

                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <!--END PANEL--> 
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- END JUMBOTRON -->
            </div>
            <!-- END PAGE CONTENT -->

        </div>

        <div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <div class=" clearfix text-left">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                            </button>
                        </div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <div class="row">

                            <div class="error-box" id="errorboxdata" style="font-size: large;text-align:center">Are you sure to delete</div>

                        </div>
                    </div>

                    <br>

                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-sm-4" ></div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4" >
                                <button type="button" class="btn btn-primary pull-right" id="confirmed" >yes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <div class=" clearfix text-left">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                            </button>

                        </div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <br>
                    <div class="modal-body">
                        <div class="row">

                            <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                        </div>
                    </div>

                    <br>

                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-sm-4" ></div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4" >
                                <button type="button" class="btn btn-primary pull-right" id="confirmeds" ><?php echo BUTTON_YES; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class=" clearfix text-left">                        
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                            </button>
                        </div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3>Add Zonal</h3>
                    </div>

                    <div class="modal-body">                  

                        <form id="addentity" method="post" class="" role="form" action="<?php echo base_url('index.php/Admin') ?>/insertzonalset"  method="post" enctype="multipart/form-data">
                            <?php if ($this->session->userdata("badmin")['Businesszone']) { ?>
                                <div class="form-group" class="formex">

                                    <div class="frmSearch">
                                        <label for="fname" class="col-sm-4 control-label">BUSINESS ZONE</label>
                                        <div class="col-sm-8">
                                            <span style="    font-size: larger;"><?php echo ucwords($this->session->userdata("badmin")['Businesszone']); ?> </span>
                                            <!--<input type="text" id="businesszone" name="businesszone" value="" style="" readonly class="form-control error-box-class" />-->

                                            <div id="suggesstion-box"></div>
                                        </div>

                                    </div>
                                </div>
                            <?php } ?>
                            <br><br>
                            <div class="form-group formex">

                                <div class="frmSearch">
                                    <label for="fname" class="col-sm-4 control-label">ZONE<span style="color:red;font-size: 18px">*</span></label>
                                    <div class="col-sm-8">
                                        <select id='zone' name='zone' class='form-control'  >
                                            <option value="0">Select Zone</option>
                                            <?php
                                            foreach ($zonelist as $result) {
                                                echo "<option value=" . $result['_id']['$oid'] . ">" . $result['title'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <div id="suggesstion-box"></div>
                                    </div>
                                    <span id="errorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group formex">

                                <div class="frmSearch">
                                    <label for="fname" class="col-sm-4 control-label">DRIVER TYPE<span style="color:red;font-size: 18px">*</span></label>
                                    <div class="col-sm-8">
                                        <select id='Drivertype' name='Drivertype' onchange='changeD(this);' class='form-control' >
                                            <option value="0">Select Driver Type</option>
                                            <?php
//                                        foreach ($Drivertype as $result) {
                                            if ($Drivertype['Grocerdriver'] == "1")
                                                echo "<option value='0' data-id='0'>Grocer Driver</option>";
                                            if ($Drivertype['Storedriver'] == "1")
                                                echo "<option value='1' data-id='1'>Store Driver</option>";
                                            if ($Drivertype['Offlinedriver'] == "1")
                                                echo "<option value='2' data-id='2'>Offline Driver</option>";
////                                           echo "<option value=" . $result['_id'] . ">" . implode($result['name'],',') . "</option>";
//                                        }
                                            ?>
                                        </select>
                                        <div id="suggesstion-box"></div>
                                    </div>
                                    <span id="errorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="form-group" class="formex">

                                <div class="frmSearch">
                                    <label for="fname" class="col-sm-4 control-label">DELIVERY CHARGE<span style="color:red;font-size: 18px">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" <?PHP echo $enable; ?> id="deliverychrg" name="deliverychrg"  style="" class="form-control error-box-class" />

                                        <div id="suggesstion-box"></div>
                                    </div>

                                    <span id="editerrorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                                </div>
                            </div>
                            <br>
                            <br>
                            <!--                            <div class="form-group" class="formex">
                            
                                                            <div class="frmSearch">
                                                                <label for="fname" class="col-sm-4 control-label">MINIMUM ORDER<span style="color:red;font-size: 18px">*</span></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" id="miniorder" name="miniorder" style="" class="form-control error-box-class"/>
                            
                                                                    <div id="suggesstion-box"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <div class="form-group" class="formex">
                            
                                                            <div class="frmSearch">
                                                                <label for="fname" class="col-sm-4 control-label">FREE ORDER<span style="color:red;font-size: 18px">*</span></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" id="freeorder" name="freeorder" style="" class="form-control error-box-class"/>
                            
                                                                    <div id="suggesstion-box"></div>
                                                                </div>
                                                            </div>
                                                        </div>-->
                            <br>
                            <br>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <div class="col-sm-6 error-box" style="color:red;" id="clearerror"></div>
                        <div class="col-sm-4" ></div>                        
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="insert" >Add</button>
                        </div>
                    </div>


                </div>            
            </div>

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
            </button>
        </div>

        <div class="modal fade stick-up" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class=" clearfix text-left">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                            </button>
                        </div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3>Edit Zonal</h3>
                    </div>

                    <div class="modal-body">

                        <form id="editentity" method="post" class="" role="form" action="<?php echo base_url('index.php/Admin') ?>/editzonalset"  method="post" enctype="multipart/form-data">
                            <input type="hidden" id="user_id" name="user_id">
                            <?php if ($this->session->userdata("badmin")['Businesszone']) { ?>
                                <div class="form-group" class="formex">

                                    <div class="frmSearch">
                                        <label for="fname" class="col-sm-4 control-label">BUSINESS ZONE</label>
                                        <div class="col-sm-8">
                                            <span style="    font-size: larger;"><?php echo ucwords($this->session->userdata("badmin")['Businesszone']); ?> </span>
                                            <!--<input type="text" id="businesszone" name="businesszone" value="" style="" readonly class="form-control error-box-class" />-->

                                            <div id="suggesstion-box"></div>
                                        </div>

                                    </div>
                                </div>
                            <?php } ?>
                            <br><br>
                            <div class="form-group formex">
                                <?php //   foreach ($Drivertype as $result) {print_r($Drivertype['zonalprice']);}   ?>
                                <div class="frmSearch">
                                    <label for="fname" class="col-sm-4 control-label">ZONE<span style="color:red;font-size: 18px">*</span></label>
                                    <div class="col-sm-8">
                                        <select id='edit_zone' name='zone' onchange='editchangeD(this);' class='form-control'  >
                                            <option value="0">Select Zone</option>
                                            <?php
                                            foreach ($zonelist as $result) {
                                                echo "<option value=" . $result['_id']['$oid'] . ">" . $result['title'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <div id="suggesstion-box"></div>
                                    </div>
                                    <span id="errorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group formex">
                                <?php //   foreach ($Drivertype as $result) {print_r($Drivertype['zonalprice']);}   ?>
                                <div class="frmSearch">
                                    <label for="fname" class="col-sm-4 control-label">DRIVER TYPE<span style="color:red;font-size: 18px">*</span></label>
                                    <div class="col-sm-8">
                                        <select id='edit_Drivertype' name='Drivertype' onchange='editchangeD(this);'  class='form-control'  >
                                            <option value="0">Select Driver Type</option>
                                            <?php
//                                        foreach ($Drivertype as $result) {
                                             if ($Drivertype['Grocerdriver'] == "1")
                                                echo "<option value='0' data-id='0'>Jaiecom Driver</option>";
                                            if ($Drivertype['Storedriver'] == "1")
                                                echo "<option value='1' data-id='1'>Store Driver</option>";
                                            if ($Drivertype['Offlinedriver'] == "1")
                                                echo "<option value='2' data-id='2'>Offline Driver</option>";
////                                           echo "<option value=" . $result['_id']['$oid'] . ">" . implode($result['name'],',') . "</option>";
//                                        }
                                            ?>
                                        </select>
                                        <div id="suggesstion-box"></div>
                                    </div>
                                    <span id="errorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                                </div>
                            </div>
                            <br>
                            <br>

                            <div class="form-group" class="formex">

                                <div class="frmSearch">
                                    <label for="fname" class="col-sm-4 control-label">DELIVERY CHARGE<span style="color:red;font-size: 18px">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" id="edit_deliverychrg" name="deliverychrg"  style="" class="form-control error-box-class" <?PHP echo $enable; ?>  />

                                        <div id="suggesstion-box"></div>
                                    </div>

                                    <span id="editerrorbox" class="col-sm-8 control-label" style="color: #ff0000;float: right;"></span>
                                </div>
                            </div>
                            <br>
                            <br>
                            <!--                            <div class="form-group" class="formex">
                            
                                                            <div class="frmSearch">
                                                                <label for="fname" class="col-sm-4 control-label">MINIMUM ORDER<span style="color:red;font-size: 18px">*</span></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" id="edit_miniorder" name="miniorder" style="" class="form-control error-box-class"/>
                            
                                                                    <div id="suggesstion-box"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <div class="form-group" class="formex">
                            
                                                            <div class="frmSearch">
                                                                <label for="fname" class="col-sm-4 control-label">FREE ORDER<span style="color:red;font-size: 18px">*</span></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" id="edit_freeorder" name="freeorder" style="" class="form-control error-box-class"/>
                            
                                                                    <div id="suggesstion-box"></div>
                                                                </div>
                                                            </div>
                                                        </div>-->
                            <br>
                            <br>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-6 error-box" style="color:red;" id="clearerror1"></div>
                        <div class="col-sm-4" ></div>                       
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="useredit" >Save</button>
                        </div>
                    </div>

                </div>

                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


        <div class="modal fade stick-up" id="ChangeModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class=" clearfix text-left">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                            </button>
                        </div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3>Change Password</h3>
                    </div>
                    <div class="modal-body">
                        <form id="changepassword" method="post" class="" role="form" action="<?php echo base_url('index.php/Admin') ?>/change_password"  method="post" enctype="multipart/form-data">
                            <input type="hidden" id="user_id1" name="user_id1">
                            <div class="form-group" class="formex">

                                <div class="frmSearch">
                                    <label for="fname" class="col-sm-4 control-label">New Password<span style="color:red;font-size: 18px">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="password" id="newPwd" name="newpassword" placeholder="New Password" style="" class="form-control error-box-class"/>

                                        <div id="suggesstion-box"></div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group" class="formex">

                                <div class="frmSearch">
                                    <label for="fname" class="col-sm-4 control-label">Re-Type New Password<span style="color:red;font-size: 18px">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="password" id="reNewPwd" placeholder="Re-Type New Password" name="renewpassword"  style="" class="form-control error-box-class"/>

                                        <div id="suggesstion-box"></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-6 error-box" style="color:red;" id="clearerror2"></div>
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="changepass" >Save</button>
                        </div>
                    </div>
                    </form>
                </div>

                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
        </button>
    </div>

</div>

<div class="modal fade fill-in" id="map_display" role="dialog">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <i class="pg-close"></i>
    </button>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="">All Zones</h4>
            </div>
            <div class="modal-body" style="padding-top:1%;">

                <!--<input id="pac-input2" class="controls" type="text" placeholder="Search Location" style="position: absolute;width: 15.5em;right: 6vw;padding: 1%;z-index: 1050;margin-top: 21px;border-radius: 5px;">-->
                <!--onfocus="initAutocomplete(3)"-->
                <select tabindex="-1" class="bg-transparent full-width form-control" id="city_selection_view" style="position: absolute;width: 15.5em;margin-left: 35vw;z-index: 1050;margin-top: 20px;">
                    <option value="#">Select City</option>
                    <?php
                    foreach ($cities as $data) {
                        ?>
                        <option value="<?php echo implode($data['name'], ','); ?>" lat="<?php echo $data['location']['latitude']; ?>" lng="<?php echo $data['location']['longitude']; ?>"><?php echo implode($data['name'], ','); ?></option>    
                        <?php
                    }
                    ?>
                </select>
                <div class="container-fluid bg-white" style="padding-top: 1%;padding-bottom: 1%;">
                    <div id='viewmaploader' style="display:none;position: relative;z-index: 1500;background-color: white;height: 90vh;width: 100%;">
                        <img src="<?= base_url() ?>/../../../images/loading.gif" style="position: absolute;left: 0;right: 0;top: 0;bottom: 0;margin: auto;"/>
                    </div>
                    <div id='viewmap' class="row">
                        <div id="mapPolygon"  class="col-sm-12"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>