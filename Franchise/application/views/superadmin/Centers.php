<script>
    $("#HeaderCenters").addClass("active");
    $(document).ready(function () {
        $("form").submit(function () {
            $(this).find('input[type="submit"]').prop("disabled", true);
        });
        $('#callM').click(function () {

            $('#NewCenter').modal('show');
        });

        $('#CountryList').change(function () {

            $('#CityList').load('<?PHP echo base_url(); ?>application/views/superadmin/get_cities.php', {country: $('#CountryList').val()});
            $('#countryname').val($('#CountryList option:selected').text());
//            alert($('#CountryList option:selected').text());
        });
        function base64_encode(data) {
            //  discuss at: http://phpjs.org/functions/base64_encode/
            // original by: Tyler Akins (http://rumkin.com)
            // improved by: Bayron Guevara
            // improved by: Thunder.m
            // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
            // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
            // improved by: Rafał Kukawski (http://kukawski.pl)
            // bugfixed by: Pellentesque Malesuada
            //   example 1: base64_encode('Kevin van Zonneveld');
            //   returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
            //   example 2: base64_encode('a');
            //   returns 2: 'YQ=='

            var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
            var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
                    ac = 0,
                    enc = '',
                    tmp_arr = [];

            if (!data) {
                return data;
            }

            do { // pack three octets into four hexets
                o1 = data.charCodeAt(i++);
                o2 = data.charCodeAt(i++);
                o3 = data.charCodeAt(i++);

                bits = o1 << 16 | o2 << 8 | o3;

                h1 = bits >> 18 & 0x3f;
                h2 = bits >> 12 & 0x3f;
                h3 = bits >> 6 & 0x3f;
                h4 = bits & 0x3f;

                // use hexets to index into b64, and append result to encoded string
                tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
            } while (i < data.length);

            enc = tmp_arr.join('');

            var r = data.length % 3;

            return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
        }

        $('#checkEmail').click(function () {

            $.ajax({
                url: "<?PHP echo base_url(); ?>index.php/superadmin/checkCenterEmail/" + base64_encode($('#Email').val()),
                method: "POST",
                data: {},
                datatype: 'json', // fix: need to append your data to the call
                success: function (data) {
                    var Arr = JSON.parse(data);
//alert(Arr.flag);
                    if (Arr.flag == 1) {
                        alert('Email already exist');

                    } else {
                        $('#addnew').trigger('click');
                    }
                    // alert(data);
//                $('#Latitude').val(Arr.Lat);
//                $('#Longitude').val(Arr.Long);

                    initialize(Arr.Lat, Arr.Long);
                }
            });
        });

        $('#cityLists').change(function () {

            alert($('#cityLists option:selected').text());
            $('#cityname').val($('#cityLists option:selected').text());
        });
    });
    //here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

    function Delservice(thisval) {

        $('#deletemodal').modal('show');
        var entityidid = thisval.id;
        var statusid = thisval.value;
//        alert(statusid);
        if (statusid == 5) {
            $('#MessageLabel').text('Are You Sure Want To De-Active This Center');


        } else {
            $('#MessageLabel').text('Are You Sure Want To Active This Center');
        }

        $("#deletelink").attr('href', "<?php echo base_url() ?>index.php/superadmin/ChangeStatus/" + entityidid + '/' + statusid);
    }

    function validate(key) {
        //getting key code of pressed key
        var keycode = (key.which) ? key.which : key.keyCode;
        // var tex = document.getElementById('TextBox2');
        //comparing pressed keycodes
        if (!(keycode == 8 || keycode == 46) && (keycode < 48 || keycode > 57)) {
            return false;
        } else {

        }
    }
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyA1fCUi4aDiWfD7vvdJgznndKWF54KJRnw"></script>
<script>
    function callMap() {
//        alert();
        $('#NewCenter').modal('hide');
        $('#ForMaps').modal('show');


        if ($('#entiryLatitude').val() != "" && $('#entiryLongitude').val() != "") {
            initialize($('#entiryLatitude').val(), $('#entiryLongitude').val());
            $('#address').val($('#entityAddress').val());
        } else {
            initialize(24.7136, 46.6753);
        }
    }

    var map;
    var marker;
    var myLatlng = new google.maps.LatLng(24.7136, 46.6753);

    var geocoder = new google.maps.Geocoder();
    var infowindow = new google.maps.InfoWindow();
    function getAddLatLong(text) {
        var addr = text.value;
//        alert(text.value);
        $.ajax({
            url: "<?PHP echo base_url(); ?>application/views/superadmin/get_latlong.php",
            method: "POST",
            data: {Address: addr},
            datatype: 'json', // fix: need to append your data to the call
            success: function (data) {
                var Arr = JSON.parse(data);
                // alert(data);
//                $('#Latitude').val(Arr.Lat);
//                $('#Longitude').val(Arr.Long);

                initialize(Arr.Lat, Arr.Long);
            }
        });
    }
    function initialize(lat, long) {

        if (lat != '' || long != '')
        {
            myLatlng = new google.maps.LatLng(lat, long);
        } else {
            myLatlng = new google.maps.LatLng(24.7136, 46.6753);
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


                    //$('#address').val(results[0].formatted_address);
                    $('#latitude').val(marker.getPosition().lat());
                    $('#longitude').val(marker.getPosition().lng());
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                }
            }
        });
        google.maps.event.addListener(marker, 'dragend', function () {

            geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
//                        if (results[0].address_components.length > 4) {
//                            $('#address').val(results[0].address_components[0].long_name + ', ' + results[0].address_components[1].long_name);
//                            $('#address2').val(results[0].address_components[2].long_name + ', ' + results[0].address_components[3].long_name);
//                        } else if (results[0].address_components.length = 3) {
//                            $('#address').val(results[0].address_components[0].long_name + ', ' + results[0].address_components[1].long_name);
//                            $('#address2').val(results[0].address_components[2].long_name);
//                        }
                        $('#address').val(results[0].formatted_address);

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
    function Cancel() {
        $('#ForMaps').modal('hide');
        $('#NewCenter').modal('show');
    }
    function Take() {

        $('#entiryLongitude').val($('#longitude').val());
        $('#entiryLatitude').val($('#latitude').val());
        $('#entityAddress').val($('#address').val());


        $('#ForMaps').modal('hide');
        $('#NewCenter').modal('show');
    }

    function ResetPwd(v) {
        $('#CenterId').val(v.id);
        $('#resetPwd').modal('show');
    }
</script>



<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="">
              
                    <li><a href="#" class="active">STORE LOCATIONS</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>
            <div class="add_new">
                <a href="<?php echo base_url() ?>index.php/superadmin/addnewbusiness">  <button type="button" class="btn btn-primary" id="" style="margin:0px;">Add</button></a>
            </div>

            <div class="container-fluid container-fixed-lg bg-white">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="pull-right">
                                <div class="col-xs-12" style="margin: 10px 0px;padding:0px;">
                                    <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body" style="height: auto;">
                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
                                        <thead>
                                          
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                    Slno</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                    Business Name</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                    Email</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                                    Owner Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                                    Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                    Option</th>
                                            </tr>

                                        </thead>
                                        <tbody>

                                            <?php
                                            $count = 1;

                                            foreach ($BusinessList as $result) {
//                                                print_r($result);
                                                ?>
                                                <tr role="row" class="odd">
                                                    <td id = "d_no" class="v-align-middle sorting_1"> <?php echo $count ?></td>
                                                    <td id = "fname_" class="v-align-middle sorting_1">
                                                        <a target="_blank" href="<?PHP echo base_url(); ?>index.php/Admin/FromAdmin/<?PHP echo (string) $result['_id']; ?>"  data-toggle="modal"> 
                                                            <?php
                                                            echo implode($result['ProviderName'],',');
                                                            ?>
                                                        </a>
                                                        <?php // echo $result["ProviderName"] ?></td>
                                                    <td id = "fname_" class="v-align-middle sorting_1"><?php echo $result["Email"] ?></td>
                                                    <td id = "lname_" class="v-align-middle"> <?php echo $result["OwnerName"]; ?></td>
                                                    <td id = "lname_" class="v-align-middle"> <?php
                                                            if ($result['Status'] == '1') {
                                                                echo 'Active';
                                                            } elseif ($result['Status'] == '3') {
                                                                echo 'New';
                                                            } elseif ($result['Status'] == '5') {
                                                                echo 'Rejected';
                                                            }
                                                            ?> </td>
                                                    <td id = "lname_" class="v-align-middle">
                                                        <a>
                                                            <button type="button" onclick="ResetPwd(this)" id="<?php echo $result['_id'] ?>" class="btn btn-success" style="padding: 3px 7px !important; font-size: 11px; color: #ffffff !important;background-color: #10cfbd;">Reset Password </button>
                                                        </a>

                                                    </td>
                                                                                                                                                                         

                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- END PANEL -->
            </div>
        </div>
        <!-- END JUMBOTRON -->


    <!-- START FOOTER -->
    <div class="container-fluid container-fixed-lg footer">
        <?PHP include 'FooterPage.php' ?>
    </div>
    <!-- END FOOTER -->


    <div class="modal fade stick-up in" id="deletemodal" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                        <h5><label id='MessageLabel'></label> </h5>
                    </div>
                    <div class="modal-body">

                    </div>

                    <div class="modal-footer">


                        <a href="" id="deletelink"><button type="buttuon" class="btn btn-primary btn-cons  pull-left inline">Continue</button></a>
                        <button type="button" class="btn btn-default btn-cons no-margin pull-left inline" data-dismiss="modal">Cancel</button>

                    </div>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade in" id="NewCenter" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
        <div class="modal-dialog">

            <form action = "<?php echo base_url(); ?>index.php/superadmin/AddNewCenter" method= "post" onsubmit="return validateForm();">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Store</h4>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Store Name</label>
                            <input type="text" class="form-control" placeholder="Center Name" id="ProviderName" name="FData[ProviderName]" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Email" id="Email" name="FData[Email]" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" placeholder="Password" id="Password" name="FData[Password]" required>
                        </div>
                        <div class="form-group">
                            <label>Owner</label>
                            <input type="text" class="form-control" placeholder="Owner Name" id="OwnerName" name="FData[OwnerName]" required>
                        </div>
                        <div class="form-group" >
                            <label>Address Line1</label><br>
                            <input type="text" class="form-control" placeholder="Address" id="entityAddress" name="FData[Address]" required style="
                                   width: 88%;
                                   float: left;
                                   ">
                            <button  type="button" class=" btn btn-danger btn-sm" style="border-radius: 20px;"  name="action" onclick="callMap();" value="add">Map</button>
                        </div>

                        <div class="form-group" >
                            <label>Country</label>
                            <!--<input type="text" class="form-control" placeholder="Description" id="Description" name="FData[Description]">-->
                            <select id='CountryList' name='FData[Country]' class='form-control' required>
                                <option val=''>Select Country</option>
                                <?PHP
                                foreach ($CountryList as $Country) {
                                    echo "<option value='" . $Country->Country_Id . "'>" . $Country->Country_Name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <div id='CityList'>
                                <select id='cityLists' class="form-control" name='FData[City]' required>
                                    <option value=''>Select City</option>

                                </select>
                            </div>
                        </div>
                        <input type='hidden' name='FData[cityname]' id='cityname'>
                        <input type='hidden' name='FData[countryname]' id='countryname'>
                        <input type='hidden' name='FData[Status]' value='3' id='countryname'>
                        <input type='hidden' name='FData[Master]' value='<?PHP echo $BizId; ?>' id='countryname'>
                        <input type='hidden' name='MasterId' value='<?PHP echo $BizId; ?>' id='countryname'>

                        <div class="form-group" >
                            <label>Post Code</label>
                            <input type="text" class="form-control" onkeypress="return validate(event)"  placeholder="PostCode" id="PostCode" name="FData[PostalCode]" required>
                        </div>
                        <div class="form-group" >
                            <label>Latitude</label>
                            <input type="text" class="form-control" onkeypress="return validate(event)" placeholder="Latitude" id="entiryLatitude" name="Latitude" required>
                        </div>
                        <div class="form-group" >
                            <label>Longitude</label>
                            <input type="text" class="form-control" onkeypress="return validate(event)" placeholder="Longitude" id="entiryLongitude" name="Longitude" required>
                        </div>
                       <div class="form-group">
                           <label>Payment Method</label>
                           <br>
                        <div class="col-sm-6">
                            <input type="checkbox" class=" checkbox_" name="FData[cash]"  value="1" >&nbsp;&nbsp;<label>Cash</label> 
                            <br>
                            <input type="checkbox" class=" checkbox_" name="FData[credit_card]" value="1" >&nbsp;&nbsp;<label>Credit Card</label> 
                            <br>
                            <input type="checkbox" class=" checkbox_" name="FData[SADAD]" value="1" >&nbsp;&nbsp;<label>SADAD</label> 
                        </div>
                    </div>

                        <input type="hidden" id="BusinessId" name="FData[BusinessId]" value="<?PHP echo $BizId; ?>">
                        <label id = "errorbox" style="color: red; font-size: 15px;"></label>

                    </div>
                    <div class="modal-footer">
                        <input type="Submit" class="btn btn-primary" id="addnew" value="Add" >
                        <!--style="visibility: hidden;"-->

                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <!--<input type="button" class="btn btn-primary" id="checkEmail" value="Add">-->

                    </div>
                </div>
            </form>
            </form>

        </div>

    </div>
    <div class="modal fade in" id="ForMaps" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
        <div class="modal-dialog">

            <form action = "<?php echo base_url(); ?>index.php/superadmin/AddNewCenter" method= "post" onsubmit="return validateForm();">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Drag Marker To See Address</h4>
                    </div>

                    <div class="modal-body"><div class="form-group" >
                            <div id="myMap" style="width: 544px; height: 250px;"></div><br/>
                            <div class="form-group">
                                <label>Address Line 1</label>
                                <input type="text" class="form-control" value="" placeholder="Address ..." name="address" id="address" onkeyup="getAddLatLong(this);">
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
            </form>
            </form>

        </div>

    </div>

    <div class="modal fade in" id="resetPwd" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
        <div class="modal-dialog">

            <form action = "<?php echo base_url(); ?>index.php/superadmin/ResetPassword" method= "post" onsubmit="return validateForm();">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Enter The New Password</h4>
                    </div>

                    <div class="modal-body"><div class="form-group" >
                            <input type="hidden" value="" id="CenterId" name="CenterId">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" value="" placeholder="Password" name="FData[Password]" id="Password" >
                            </div> 


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" id="TakeMapAddress"   class="btn btn-primary" value="Submit" >

                    </div>
                </div>
            </form>
            </form>

        </div>

    </div>