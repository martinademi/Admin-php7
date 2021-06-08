<style>
    span.abs_text {
        position: absolute;
        right:10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }
    .pos_relative ,.pos_relative2{
        position: relative;
        padding-right:0px
    }
    .pos_relative2{
        padding-right:10px
    }
    #currencySymbol{
        padding-left: 10px;
    }

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
    .btn{
        border-radius: 25px !important;
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
<!--AIzaSyCNJ9nkXGQumgO3N_uQGaT3pZAbGB8q2vE-->
<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCAnpL4IiJt_jeFspg16XQshxmbnl-zGbU&sensor=false&language=en-AU&libraries=drawing,places"></script>


<script>
    var Str;
    var mapedit;
    var cities = []
    $(document).ready(function () {
        $.ajax({
            dataType: "json",
            url: "<?= base_url() ?>index.php?/City/getAllCities",
            async: false,
            success: function (result) {

                $.each(result.data, function (index, row)
                {
                    console.log(row.city);
                    cities.push(row.city);
                });
            }
        });
        console.log(cities);

        $('#buttonDelete').click(function ()
        {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length > 0)
            {
                $('#deletePopUp').modal('show');
            } else {

                $('#errorModal').modal('show');

            }
        });

        $("#deleteCity").click(function () {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val == '' || val == null) {
                $('#errorModal').modal('show');

            } else {

                $.ajax({
                    url: "<?php echo base_url('index.php?/City') ?>/deleteCity",
                    type: "POST",
                    data: {val: val, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
                    success: function (result) {
                        $(".close").trigger('click');
                        refreshContent();

                    }
                });
            }
        });

        $('#add').click(function () {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length > 0) {
                $('#errorModal1').modal('show');

            } else {

                $('#cityNameErr').text("");
                $('#currencySymbolErr').text("");
                $('#currencyNameErr').text("");
                $('#weightMetric').val("");
                $('#mileageMetric').val("");
                $('#weightMetric').val("");
                $('#currency').val("");
                $('#pac-input').val("");
                $('#countryName').val("");
                $('#currencySymbol').val("");
                $('#addModal').modal('show');
            }

        });


        //To save the zone details in the database
        $('#save').click(function () {

            $('.errors').text('');
            if ($('#pac-input').val() == '')
            {
                $('#cityNameErr').text('Please select a city');
            } else if ($('#pac-input').val() != $('#cityNameOnly').val())
            {
                $('#cityNameErr').text('Entered city is invalid');
            } else if ($('#currency').val() == '') {
                $('#currencyNameErr').text('Please enter the currency');
            } else if ($('#currencySymbol').val() == '') {
                $('#currencySymbolErr').text('Please enter the currency symbol');
            } else {

                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/City/zonemapsapi",
                    type: "POST",
                    data: {"country": $('#countryName').val(), 'state': $('#stateName').val(), "city": $('#cityNameOnly').val(), 'currency': $('#currency').val(), 'currencySymbol': $('#currencySymbol').val(), "lat": $('#lat1').val(), "lng": $('#lng1').val(), "isDeleted": false,"mileageMetric":$('#mileageMetric').val(),"weightMetric":$('#weightMetric').val()},
                    dataType: "JSON",
                    success: function (result) {
                        console.log(result);
                        if (result.flag == 0) {

                            $('#addModal').modal('hide');
                            $('#big_table').hide();
                            $('#big_table_processing').show();
                            var table = $('#big_table');
                            $('#big_table').fadeOut('slow');
                            $("#display-data").text("");

                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 10,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": "<?php echo base_url() ?>index.php?/City/datatable_cities",
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 10,
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
                            $('#currency').val("");
                            $('#pac-input').val("");
                            $('#countryName').val("");

                        } else if (result.flag == 1) {

                            $('#addModal').modal('hide');
                            $('#big_table').hide();
                            $('#big_table_processing').show();
                            var table = $('#big_table');
                            $('#big_table').fadeOut('slow');
                            $("#display-data").text("");

                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 10,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": "<?php echo base_url() ?>index.php?/City/datatable_cities",
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 10,
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
                            $('#currency').val("");
                            $('#pac-input').val("");
                            $('#countryName').val("");

                        } else {
                            $('#addModal').modal('hide');
                            $('#cityExistsPopUp').modal('show');
                        }
                    }
                });
            }
        });



        $('#pac-input').focus(function () {
            var map;
            map = new google.maps.Map();
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

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    console.log(places);

                    var lat = parseFloat(place.geometry.location.lat()).toFixed(6);
                    var lng = parseFloat(place.geometry.location.lng()).toFixed(6);



                    getCityCountry(place.geometry.location.lat() + ',' + place.geometry.location.lng());
                    alert();
//              
                });
            });
        });
    });


    function clearFields() {
//    alert();
        $('#zonecity').val("");
        $('#zonetitle').val("");
        $('#savezone').hide();
        $('#clearform').hide();
        $('#pac-input').val('');

    }
    function isCharacterKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
//        if (charCode > 31 && (charCode < 41 || charCode > 57)) 
        if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 123) && charCode != 32) {
            return false;
        }
        return true;
    }

    function refreshContent() {

        $('#big_table').hide();
        $('#big_table_processing').show();
        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        $("#display-data").text("");

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 10,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo base_url() ?>index.php?/City/datatable_cities",
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 10,
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

    $(document).ready(function () {

        $('#AddCity').click(function ()
        {
            $('#addCityForm')[0].reset();

            $('#addModal').modal('show');
        });
        $('#clearform').click(function (e) {
            $('#addCityForm')[0].reset();
            $('#cityNameErr').text("");
            $('#currencyNameErr').text("");

        });

        $('.Ok').click(function ()
        {
            var table = $('#big_table');
            $('#big_table').fadeOut('slow');
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 10,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo base_url() ?>index.php?/City/datatable_cities",
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 10,
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
                "iDisplayLength": 10,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/City/datatable_cities',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 10,
                "oLanguage": {
                },
                "fnInitComplete": function () {

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
            <strong><?php echo $this->lang->line('CITIES'); ?></strong>

        </div>

        <div class="row">
            <ul class="nav nav-tabs nav-tabs-fillup  new_class bg-white" style="margin: 1% 0.8%;padding: 0.5% 2% 0% 1%">
                <div class="pull-right m-t-10"><button  class="btn btn-danger" id="buttonDelete"> 
                        <?php echo $this->lang->line('Delete'); ?></button></div>

                <!--                <div class="pull-right m-t-10"><button data-toggle="modal" class="btn btn-info" onclick="loadExistingZones()"> 
                                        Edit</button></div>-->
                <button data-toggle="modal" class="btn btn-primary" data-target="#editZoneModal" style="display:none;" id="editZoneModal1"> 
                </button>
                <div class="pull-right m-t-10"><button data-toggle="modal" class="btn btn-primary btn-cons" id="add" > 
                        <?php echo $this->lang->line('Add'); ?></button></div>
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
                                    <input type="text" id="search-table" class="form-control pull-right"  placeholder="SEARCH"/> 

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








<div class="modal fade stick-up" id="deleteModel-cities" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"><?php echo $this->lang->line('DELETE'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <input type="hidden" name="deleteCityID" id="deleteCityID">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdata" ></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <div class="pull-right m-t-10"><button type="button" class="btn btn-danger pull-right" id="confirmed" ><?php echo $this->lang->line('Delete'); ?></button></div>
                    <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('Cancel'); ?></button></div>


                </div>

            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>





<div class="modal fade stick-up" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title"><?php echo $this->lang->line('ADD_CITY'); ?></span>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12">
                        <form id="addCityForm" action="<?php echo base_url(); ?>City/insertCity" method="post"  data-parsley-validate="" class="form-horizontal form-label-left" >

                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('City'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  id="pac-input" name="cityName"  class="form-control error-box-class" autocomplete="on">
                                </div>
                                <div class="col-sm-3 error-box errors" id="cityNameErr"></div>
                                <input type="hidden" id="cityNameOnly" name="cityNameOnly">

                            </div>
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Country'); ?></label>
                                <div class="col-sm-6">
                                    <input type="text" id="countryName" name="countryName" class="form-control error-box-class" disabled>
                                    <input type="hidden" id="stateName" name="stateName" class="form-control error-box-class" disabled>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Currency'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6 pos_relative2">
                                    <span class="abs_text"><b><?php echo $this->lang->line('Short_form'); ?></b></span>
                                    <input type="text"  id="currency" name="currency" maxlength="3" onkeypress="return isCharacterKey(event)"class="form-control error-box-class" >
                                </div>
                                <div class="col-sm-3 error-box errors" id="currencyNameErr"></div>
                                <input type="hidden" id="currencyNameOnly" name="currencyNameOnly">
                                <input type="hidden" id="lat1" name="lat1">
                                <input type="hidden" id="lng1" name="lng1">

                            </div>
                            <div class="form-group">
                                <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Currency_Symbol'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6 pos_relative2">
                                    <span class="abs_text"><b>Symbol<?php echo $this->lang->line('CITIES'); ?></b></span>
                                    <input type="text"  id="currencySymbol" name="currencySymbol" maxlength="3" pattern='^\d+(?:\.\d{0,2})$'class="form-control error-box-class" >
                                </div>
                                <div class="col-sm-3 error-box errors" id="currencySymbolErr"></div>


                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-sm-3"><?php echo $this->lang->line('Distance'); ?><span style="" class="MandatoryMarker"> *</span></label>

                                <div class="col-sm-6">
                                    <select class="form-control" id="mileageMetric" name="mileageMetric" style="padding-left: 45px;">
                                        <option value="0"><?php echo unserialize(DistanceMetric)[0]; ?></option>
                                        <option value="1"><?php echo unserialize(DistanceMetric)[1]; ?></option>
                                    </select> 

                                </div>

                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-sm-3"><?php echo $this->lang->line('Weight'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="weightMetric" name="weightMetric" style="padding-left: 45px;">
                                        <option value="0"><?php echo unserialize(WeightMetric)[0]; ?></option>
                                        <option value="1"><?php echo unserialize(WeightMetric)[1]; ?></option>
                                    </select> 
                                </div>
                            </div>
                            <hr/>
                        </form>

                        <div class="form-group pull-right">
                            <button id="save" class="btn btn-success" ><?php echo $this->lang->line('Save'); ?></button>
                            <button id="clearform"  class="btn btn-default"><?php echo $this->lang->line('Clear'); ?></button><br/>
                        </div>

                        <p id="addmsg" class="waitmsg"></p>


                    </div>

                </div>


            </div>

            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="deletePopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('DELETE'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box modalPopUpText" id="errorbox" ><?php echo $this->lang->line('Activatecity'); ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="deleteCity" ><?php echo $this->lang->line('Delete'); ?></button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="cityExistsPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('ALERT'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box modalPopUpText" id="errorbox "><?php echo $this->lang->line('cityExist'); ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('OK'); ?></button>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="errorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('ALERT'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box modalPopUpText" id="errorbox " ><?php echo $this->lang->line('Selectcity'); ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">OK</button>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="errorModal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('ALERT'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box modalPopUpText" id="errorbox1 " ><?php echo $this->lang->line('Invalid_Selection'); ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('OK'); ?></button>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<script>
    var autocomplete = new google.maps.places.Autocomplete($("#pac-input")[0], {types: ['(cities)']});

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();

        //Get latlong

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': '' + $("#pac-input").val()}, function (results, status) {

            if (status == google.maps.GeocoderStatus.OK) {
                $('#latitude').val(results[0].geometry.location.lat());
                $('#longitude').val(results[0].geometry.location.lng());
            } else {
                alert("Something got wrong " + status);
            }
        })

        //get country
        $.ajax({
            url: "https://maps.googleapis.com/maps/api/geocode/json?address=" + $("#pac-input").val() + "&sensor=false",
            type: "POST",
            success: function (res) {
                console.log(res);
                var address = res.results[0].geometry.location.lat + ',' + res.results[0].geometry.location.lng;

                geocoder = new google.maps.Geocoder();
                $('#lat1').val(res.results[0].geometry.location.lat);
                $('#lng1').val(res.results[0].geometry.location.lng);

                geocoder.geocode({'address': address}, function (results, status) {
                    console.log(results);
                    if (status == google.maps.GeocoderStatus.OK) {

                        for (var component in results[0]['address_components']) {
//                                                                          console.log(results[0]['address_components']);
                            for (var i in results[0]['address_components'][component]['types']) {


                                if (results[0]['address_components'][component]['types'][i] == "country") {

                                    $('#countryName').val(results[0]['address_components'][component]['long_name']);
                                }
                                if (results[0]['address_components'][component]['types'][i] == "administrative_area_level_1") {

                                    $('#stateName').val(results[0]['address_components'][component]['long_name']);
                                }
                                console.log($('#stateName').val());
                                if (results[0]['address_components'][component]['types'][i] == "locality") {

                                    $('#pac-input').val(results[0]['address_components'][component]['long_name']);
                                    $('#cityNameOnly').val(results[0]['address_components'][component]['long_name']);
                                }
//                                 console.log($('#cityNameOnly').val());
                            }
                        }


                    } else {
                        alert('Invalid Zipcode');
                    }
                    //Check if city is already exists


                });



            }
        });

    });

    function getCityCountry(address)
    {
        console.log(address);
        $.ajax({
            url: "https://maps.googleapis.com/maps/api/geocode/json?address=" + address + "&sensor=false",
            type: "POST",
            success: function (res) {

//                                                              address = res.results[0].geometry.location.lat+','+res.results[0].geometry.location.lng;
                geocoder = new google.maps.Geocoder();

                geocoder.geocode({'address': address}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {

                        for (var component in results[0]['address_components']) {
                            console.log(results[0]['address_components']);
                            for (var i in results[0]['address_components'][component]['types']) {

                                if (results[0]['address_components'][component]['types'][i] == "country") {

                                    $('#coutryName').val(results[0]['address_components'][component]['long_name']);
                                }

                                if (results[0]['address_components'][component]['types'][i] == "locality") {

                                    $('#pac-input').val(results[0]['address_components'][component]['long_name']);
                                    $('#cityNameOnly').val(results[0]['address_components'][component]['long_name']);
                                }
                            }
                        }
                        //Check if city is already exists
//                                                                            console.log($('#pac-input').val());
//                                     
//                                                                                                                   console.log(cities);
                        alert($('#pac-input').val());
                        $('#cityExistsName').val($('#pac-input').val());
                        if ($.inArray($('#pac-input').val(), cities) == -1)
                        {

                        } else {
                            alert();
                            $('#cityNameOnly').val('');
                            $('#pac-input').val('');
                            $('#coutryName').val('');
                            $('#cityExistsPopUp').modal('show');
                        }
                    } else {
                        alert('Invalid Zipcode');
                    }


                });



            }
        });



    }

</script>
