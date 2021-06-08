<script src="//code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" type="text/javascript"></script>


<style>
    .table>thead>tr>th {text-align:left}
    .dataTables_paginate,.dataTables_info{
        display: none;
    }
</style>
<script type="text/javascript">


<?php
$pricingModel = '';
foreach ($pricingModelData as $row)
    $pricingModel = $row['pricingModel'];
?>
    var pricingModel = '<?php echo $pricingModel ?>';
    var ids = [];
    $(document).ready(function () {

        $(document).ajaxComplete(function () {
        var access_right_pg = '<?= $access_right_pg ?>';
        if (access_right_pg == 000) {
    //   base_url().'index.php?/superadmin/access_denied';
        } else if (access_right_pg == 100) {
            $('.cls110').remove();
            $('.cls111').remove();
        } else if (access_right_pg == 110) {
            $('.cls111').remove();
        } 
    });

        if (pricingModel == 1)
        {
            $('.pricingModelSet').hide();
        } else {

            $('.pricingModelSet').show();
        }

        $('.cs-loader').show();
        $('#selectedcity').hide();
        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        var status = '<?php echo $status; ?>';

        var settings = {
            rowReorder: true,
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 30,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/vehicle/datatable_vehicletype/' + status,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 30,
            "ordering": false,
            "columns": [
                {"width": "1%"},
                {"width": "2%"},
                {"width": "4%"},
                {"width": "2%"},
                {"width": "15%"}
//                {"width": "1%"}
            ],
            "oLanguage": {

            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
                $('#big_table_processing').hide();
                table.show()
                searchInput.show()
                $('.cs-loader').hide();
                 /*
                     * .cls100 = view
                     * .cls110 = add
                     * .cls111 = edit and delete
                     */
                    // if (access == "100") {
                    //     $('.cls110').remove();
                    //     $('.cls111').remove();
                    // } else if (access == "110") {
                    //     $('.cls111').remove();

                    // }
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
            },

        };

        table.dataTable(settings);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('#cityFilter').change(function(){
			
			var city=$('#cityFilter option:selected').attr('cityName');
			var cityId=$('#cityFilter option:selected').val();
			
			table.fnFilter(cityId);
			
		});


        table.on('click', '.ordering', function () {

            if ($('#ciyFilter').val() != '') {
                var data = $(this).attr('data');
                var typeid = $(this).attr('data-id');
                var row = $(this).closest('tr');
                var currid = $(this).closest('tr').children('td:eq(0)').text();
                var previd = $(this).closest('tr').next().find("td:eq(0)").text();
                var nextid = $(this).closest('tr').prev().find("td:eq(0)").text();
                var prev_id = '', curr_id = '', next_id = '';

                if (data == '2') {
                    curr_id = currid;
                    prev_id = previd;
                } else if (data == '1') {
                    curr_id = currid;
                    prev_id = nextid;
                }

                if (typeof curr_id === "undefined" || typeof prev_id === "undefined" || curr_id === '' || prev_id === '') {
                    alert("Can't perform.");
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('index.php?/vehicle') ?>/vehicletype_reordering",
                        data: {prev_id: prev_id, curr_id: curr_id},
                        dataType: "JSON",
                        success: function (result) {
//                            alert(result.flag);
                            if (result.flag == 0) {

                                if (data == '2') {
                                    row.insertAfter(row.next());
//                                alert("changed");
                                } else if (data == '1') {
                                    row.prev().insertAfter(row);
//                                alert("changed");
                                }
                            } else {
                                alert("Sorry,Not changed try again.");
                            }
                        },
                        error: function ()
                        {
                            alert("Error..!While updating data");
                        }
                    });
                }
            } else
                alert('Please select city first..! Then only you can reorder the vehicle types');
        });



        $(document).on('click', '.vehicleTypes', function ()
        {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php?/vehicle') ?>/getVehicleTypeLanguageDate",
                data: {vehicleTypeId: $(this).data('id')},
                dataType: "JSON",
                success: function (result) {
                    $('#vehicleTypeNameTableBody').html('');

                    var html = "<tr><td style='text-align: center;'>English</td>";
                    html += "<td style='text-align: center;'>" + result.data.typeName.en + "</td></tr>";

                    $.each(result.lang, function (i, res) {
                        if (result.data.typeName[res.code]) {
                            html += "<tr><td style='text-align: center;'>" + res.name + "</td>";
                            html += "<td style='text-align: center;'>" + result.data.typeName[res.code] + "</td></tr>";
                        }
                    })

                    $('#vehicleTypeNameTableBody').append(html);
//                          
                    $('#vehicleTypeModel').modal('show');
                }
            });


        });
        $(document).on('click', '.pricing', function ()
        {


            $('#min_fare').text('<?php echo $appConfigData['currencySymbol']; ?> ' + $(this).attr('min_fare'));
            $('#price_min').text('<?php echo $appConfigData['currencySymbol']; ?> ' + $(this).attr('price_per_min'));
            $('#price_km_mile').text('<?php echo $appConfigData['currencySymbol']; ?> ' + $(this).attr('price_per_km'));
            $('#waiting_charge').text('<?php echo $appConfigData['currencySymbol']; ?> ' + $(this).attr('waiting_charge'));

            var m = 'Miles';
            if ($(this).attr('mileageMetric') == 0)
                m = 'Km';
            $('.mileageMetric').text(m);
            $('#mileagePrice').text('<?php echo $appConfigData['currencySymbol']; ?> ' + $(this).attr('mileagePrice'));

            $('.minimumKmMiles').text($(this).attr('minimum_km_miles'));
            $('.waitingMin').text($(this).attr('waiting_minutes'));
            $('.waiting_charge').text('<?php echo $appConfigData['currencySymbol']; ?> ' + $(this).attr('waiting_charge'));

            $('.cancelMin').text($(this).attr('cancellation_minutes'));
            $('#cancellationFee').text('<?php echo $appConfigData['currencySymbol']; ?> ' + $(this).attr('cancellation_fee'));

            $('.cancelScheduledMin').text($(this).attr('scheduledBookingCancellationMin'));
            $('#cancellationScheduledFee').text('<?php echo $appConfigData['currencySymbol']; ?> ' + $(this).attr('scheduledBookingCancellationFee'));

            $('#zonalDis').text('');
            $('#zonalEn').text('');
            if ($(this).attr('longHaulEnDis') == 0)
                $('#zonalDis').text('Disabled');
            else
                $('#zonalEn').text('Enabled');


            $('#pricingModel1').modal('show');
        });

        //Update the image-----------------------------

        $(document).on('click', '.uploadImages', function ()
        {
            if ($(this).attr('id') == "onImage")
                $('#on_image_upload').trigger('click');
            else if ($(this).attr('id') == "offImage")
                $('#off_image_upload').trigger('click');
            else if ($(this).attr('id') == "mapImage")
                $('#map_image_upload').trigger('click');
        });


        $('#saveImages').click(function ()
        {

            if ($('#on_image_upload').val() == '' && $('#off_image_upload').val() == '' && $('#map_image_upload').val() == '')
            {
                alert('Nothing to update');
                $('.close').trigger('click');
            } else
            {
                $('#form_uploadImage').submit();
            }

        });

        //Files upload
        $(":file").on("change", function (e) {
            var selected_file_name = $(this).val();
            if (selected_file_name.length > 0) {

                var fieldID = $(this).attr('id');
                var ext = $(this).val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    $(this).val('');
                    alert('invalid extension..!   Please choose file type in (gif,png,jpg,jpeg)');
                } else
                {
                    var type;
                    var folderName;
                    switch ($(this).attr('id'))
                    {
                        case "on_image_upload":
                            type = 1;
                            folderName = 'vehicleOnImages';
                            break;
                        case "off_image_upload":
                            type = 2;
                            folderName = 'vehicleOffImages';
                            break;
                        default :
                            type = 3;
                            folderName = 'vehicleMapImages';

                    }

                    var formElement = $(this).prop('files')[0];
                    var form_data = new FormData();

                    form_data.append('OtherPhoto', formElement);
                    form_data.append('type', 'VehicleTypes');
                    form_data.append('folder', folderName);
                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/vehicle/uploadImage",
                        type: "POST",
                        data: form_data,
                        dataType: "JSON",
                        async: false,
                        beforeSend: function () {
                        },
                        success: function (result) {

                            switch (type)
                            {
                                case 1:
                                    $('#img1').attr('src', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                    $('.img1').attr('href', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                    $('#onImageAWS').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                    break;
                                case 2:
                                    $('#img2').attr('src', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                    $('.img2').attr('href', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                    $('#offImageAWS').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                    break;
                                case 3:
                                    $('#img3').attr('src', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                    $('.img3').attr('href', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                    $('#mapImageAWS').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                    break;

                            }

                        },
                        error: function () {

                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            } else {
//                alert('No file choosed');
            }

        });
        //-----------------------------------------------


        $(document).on('click', '.images', function ()
        {
            $('#docId').val($(this).attr('docId'));
            $('#doc_body').empty();


            var html = "<tr><td style='text-align: center;'>";
            html += "SELECTED </td><td style='text-align: center;'><a class='img1' target='__blank' href=" + $(this).attr('on_image') + "><img  id=img1 src=" + $(this).attr('on_image') + " style='height:46px;width:52px' class='img-circle style_prevu_kit'></a></td>";
            html += "<td style=''>" + "<i style='padding-left: 20px;font-size:20px;' id='onImage' class='fa fa-pencil-square-o uploadImages' aria-hidden='true'></i></td>";
            html += "</tr>";


            html += "<tr><td style='text-align: center;'>";
            html += "UNSELECTED</td><td style='text-align: center;'> <a class='img2' target='__blank' href=" + $(this).attr('off_image') + "><img id=img2 src=" + $(this).attr('off_image') + " style='height:46px;width:52px' class='img-circle style_prevu_kit'><a></td>";
            html += "<td style=''>" + "<i style='padding-left: 20px;font-size:20px;' id='offImage' class='fa fa-pencil-square-o uploadImages' aria-hidden='true'></i></td>";


            html += "<tr><td style='text-align: center;'>";
            html += "MAP IMAGE</td><td style='text-align: center;'><a class='img3'  target='__blank' href=" + $(this).attr('map_image') + "><img id=img3 src=" + $(this).attr('map_image') + " style='height:46px;width:52px' class='img-circle style_prevu_kit'></a></td>";
            html += "<td style=''>" + "<i style='padding-left: 20px;font-size:20px;' id='mapImage' class='fa fa-pencil-square-o uploadImages' aria-hidden='true'></i></td>";


            $('#doc_body').append(html);
            $('#imagesModel').modal('show');
        });

    });
</script>

<script>
    $(document).ready(function () {

        $(document).on('click', '#delete_vehicletype,.deleteOne', function () {

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            ids = [];
            $('.checkbox:checked').each(function () {
                ids.push($(this).attr('data-id'));
            })

            if (ids.length == 0)
                ids.push($(this).attr('data-id'));

            if (ids.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLETYPE_ATLEASTONE); ?>);
            } else
            {
                $('#confirmmodel').modal('show');
                $("#errorboxdata").text(<?php echo json_encode(POPUP_VEHICLETYPE_SUREDELETE); ?>);
            }

        });

        $("#confirmed").click(function () {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('index.php?/vehicle') ?>/delete_vehicletype",
                data: {val: ids},
                dataType: 'JSON',
                success: function (response)
                {

                    $(".close").trigger("click");
                    reload();

                }
            });
        });

        $('#ciyFilter').change(function ()
        {
            $.ajax({
                url: "<?php echo base_url('index.php?/home') ?>/setSession",
                type: "POST",
                dataType: 'JSON',
                data: {city: $('#ciyFilter').val(), 'plan': ''},
                async: false,
                success: function (response)
                {
                    reload();
                }
            });
        });

        $(document).on('click', '.vehicleDetails', function ()
        {
            var length_metric = 'Feet';
            if ($(this).attr('length_metric') == 'M')
                length_metric = 'Meter';

            var width_metric = 'Feet';
            if ($(this).attr('width_metric') == 'M')
                width_metric = 'Meter';

            var height_metric = 'Feet';
            if ($(this).attr('height_metric') == 'M')
                height_metric = 'Meter';

            $('.v_length').text('-');
            if ($(this).attr('length'))
                $('.v_length').text($(this).attr('length') + ' ' + length_metric);

            $('.v_width').text('-');
            if ($(this).attr('width'))
                $('.v_width').text($(this).attr('width') + ' ' + width_metric);

            $('.v_height').text('-');
            if ($(this).attr('height'))
                $('.v_height').text($(this).attr('height') + ' ' + height_metric);

            $('.v_capacity').text('-');
            if ($(this).attr('capacity'))
                $('.v_capacity').text($(this).attr('capacity'));
            $('#vehicleDetailsPopup').modal('show');
        });
    });


    function reload() {

        var table = $('#big_table');
        $('#big_table_processing').show();

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 30,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/vehicle/datatable_vehicletype',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 30,
            "ordering": false,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                $('#big_table_processing').hide();
                /*
                     * .cls100 = view
                     * .cls110 = add
                     * .cls111 = edit and delete
                    //  */
                    // if (access == "100") {
                    //     $('.cls110').remove();
                    //     $('.cls111').remove();
                    // } else if (access == "110") {
                    //     $('.cls111').remove();

                    // }
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

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('#cityFilter').change(function(){
			
			var city=$('#cityFilter option:selected').attr('cityName');
			var cityId=$('#cityFilter option:selected').val();
			
			table.fnFilter(city);
			
		});
    }

    $(document).ready(function(){

        $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Orders/getCities",
                type: "POST",
                data: {},
                dataType: "JSON",
                
                success: function (result) {
                        $('#cityFilter').empty();
                    
                    if(result.data){
                            
                        var html5 = '';
                        var html5 = '<option cityName="" value="" >Select city</option>';
                        $.each(result.data, function (index, row) {
                            html5 += '<option value="'+row.cityId.$oid+'" cityName="'+row.cityName+'">'+row.cityName+'</option>';
                        
                        });
                       $('#cityFilter').append(html5);    
                    }

                }
            });

    });

</script>


<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <div class="brand inline" style="  width: auto;">
            <strong ><?php echo $this->lang->line('heading_services'); ?></strong>
        </div>
        <!-- START JUMBOTRON -->
        <div class="row" style="margin-top: 1%">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="panel panel-transparent ">

                    <ul class="nav nav-tabs nav-tabs-fillup bg-white" style="padding: 0.5%;">
                        <div class="pull-right m-t-10 cls100"><a href="<?php echo base_url() ?>index.php?/vehicle/vehicletype_addedit/add"> <button class="btn btn-primary btn-cons cls110" ><?php echo $this->lang->line('button_add'); ?></button></a></div>
                    </ul>

                    <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="hide_show">
                                        <div class="form-group showOperators">
                                            <div class="col-sm-8" style="width:166px;" data-toggle="tooltip" title="Cities" >

                                                <!-- <select id="ciyFilter" name="ciyFilter" class="form-control"  style="background-color:gainsboro;height:30px;font-size:12px;">
                                                    <option value="">All</option>
                                                    <?php
                                                    $selectedCity = $this->session->userdata('cityId');
                                                    foreach ($cities as $city)
                                                        if ($city['_id']['$oid'] == $selectedCity)
                                                            echo '<option value="' . $city['_id']['$oid'] . '" selected>' . $city['city'] . '</option>';
                                                        else
                                                            echo '<option value="' . $city['_id']['$oid'] . '">' . $city['city'] . '</option>';
                                                    ?>
                                                </select> -->

                                                <select class="form-control pull-left" id="cityFilter">
									
								        		</select> 

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="cs-loader">
                                    <div class="cs-loader-inner" >
                                        <label class="loaderPoint" style="color:#10cfbd">●</label>
                                        <label class="loaderPoint" style="color:red">●</label>
                                        <label class="loaderPoint" style="color:#FFD119">●</label>
                                        <label class="loaderPoint" style="color:#4d90fe">●</label>
                                        <label class="loaderPoint" style="color:palevioletred">●</label>
                                    </div>
                                </div>

                                <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>

                            </div>
                            &nbsp;
                            <div class="panel-body">

                                <?php echo $this->table->generate(); ?>

                            </div>

                        </div>
                        <!-- END PANEL -->
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>


<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DELETE</span> 
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6" >
                        <button type="button" class="btn btn-danger cls111  pull-right" id="confirmed" >Delete</button>
                        <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                    </div>
                </div>
            </div>
        </div>  
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade" id="pricingModel1" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" style="color:#0090d9;">PRICING DETAILS</span> 
            </div>
            <div class="modal-body">
                <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->

                <form data-parsley-validate="" class="form-horizontal form-label-left">
                    <div class="form-group pricingModelSet">


                        <label for="address" class="col-sm-5 control-label">Mileage Metric</label>
                        <div class="col-sm-5">
                            <span class="mileageMetric"></span> 
                        </div>
                    </div>
                    <div class="form-group pricingModelSet">
                        <label for="address" class="col-sm-5 control-label">Mileage Price Per <span class="mileageMetric"></span></label>
                        <div class="col-sm-5">
                            <span id="mileagePrice"></span> 
                        </div>

                    </div>
                    <div class="form-group pricingModelSet">
                        <label for="address" class="col-sm-5 control-label">Minimum Fare Upto (<span class="minimumKmMiles"></span> <span class="mileageMetric"></span>)</label>
                        <div class="col-sm-5">
                            <span id="min_fare"></span> 

                        </div>

                    </div>

                    <div class="form-group pricingModelSet">
                        <label for="address" class="col-sm-5 control-label">Waiting Charge After <span class="waitingMin"></span> Minutes</label>
                        <div class="col-sm-5">
                            <span id="waiting_charge"></span> 

                        </div>
                        <div class="col-sm-3 error-box" id=""></div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-5 control-label">On Demand Bookings Cancellation Charge After <span class="cancelMin"></span> Minutes</label>
                        <div class="col-sm-5">
                            <span id="cancellationFee"></span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-5 control-label">Scheduled Bookings Cancellation Charge After <span class="cancelScheduledMin"></span> Minutes</label>
                        <div class="col-sm-5">
                            <span id="cancellationScheduledFee"></span> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-sm-5 control-label">Long Haul Enabled</label>
                        <div class="col-sm-5">
                            <span id="zonalEn" style="color:green"></span> 
                            <span id="zonalDis" style="color:red;"></span> 
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="imagesModel" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">IMAGES</span> 
            </div>
            <div class="modal-body">
                <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->

                <table class="table table-bordered">
                    <thead>
                        <tr>

                            <th style="width:15%;text-align: center;">TYPE</th>
                            <th style="width:15%;text-align: center;">PREVIEW</th>
                            <th style="width:10%;text-align: center;">ACTION</th>

                        </tr>
                    </thead>
                    <tbody id="doc_body">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success cls111" id="saveImages">SAVE</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="vehicleTypeModel" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">VEHICLE TYPE</span> 
            </div>
            <div class="modal-body">
                <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->

                <table class="table table-bordered">
                    <thead>
                        <tr>

                            <th style="width:10%;text-align: center;">LANGUAGE</th>
                            <th style="width:10%;text-align: center;">VEHICLE TYPE NAME</th>
                        </tr>
                    </thead>
                    <tbody id="vehicleTypeNameTableBody">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="vehicleDetailsPopup" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">VEHICLE TYPE DETAILS</strong>
            </div>
            <div class="modal-body">


                <br>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Length</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="v_length"></span>
                    </div>

                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Width</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="v_width"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Height</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="v_height"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Load Bearing Capacity (<?php
                        if ($appConfigData['weight_metric'] == 0)
                            echo 'Kg';
                        else
                            echo 'Pound';
                        ?>)</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="v_capacity"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<form id="form_uploadImage"  enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?>index.php?/vehicle/uploadVehicleTypeImage">
    <input type="hidden" id="docId" name="docId">

    <input type="file"  name="on_image_upload" id="on_image_upload" style="display: none">
    <input type="hidden"  name="onImageAWS" id="onImageAWS" style="display: none">

    <input type="file"  name="off_image_upload" id="off_image_upload" style="display: none">
    <input type="hidden"  name="offImageAWS" id="offImageAWS" style="display: none">

    <input type="file" name="map_image_upload" id="map_image_upload" style="display: none">
    <input type="hidden"  name="mapImageAWS" id="mapImageAWS" style="display: none">
</form>