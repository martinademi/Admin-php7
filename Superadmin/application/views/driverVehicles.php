

<script type="text/javascript">
    var tabURL;
    $(document).ready(function () {

        var id = '<?php echo $id; ?>';

        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        $('#vehiclesFilter').hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_showDriverVehicles/' + id,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
                    $('.hide_show').show()
                    $('#vehiclesFilter').show();
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
        }, 1000);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('#vehiclesFilter').change(function ()
        {
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_showDriverVehicles/' + id + '/' + $('#vehiclesFilter').val(),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    table.show()
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
        });


        $("#chekdel").click(function () {

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length > 0) {
                //Check if the driver is in trip or not before deleting the vehicle
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/checkeDriverIsOnTrip",
                    type: "POST",
                    data: {val: val},
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        if (result.driverOnTrip > 0)
                        {
                            $('.okButton').show();
                            $('.badge').show();
                            $('#confirm').hide();
                            $('.deletePopUpText').show();
                            $('.deletePopUpTextDiv').hide();
                            $('.driverOnTrip').text(result.driverOnTrip);
                            $('.deletePopUpText').text('Driver is on trip.Please let him to complete the booking first');
                        } else
                        {
                            $('.okButton').hide();
                            $('.driverOnTrip').hide();
                            $('.deletePopUpText').hide();
                            $('#confirm').show();
                            $('.deletePopUpTextDiv').show();
                            $('.deletePopUpTextDiv').text('Do want to delete the vehicles');
                        }
                    }

                });
                $('#confirmmod').modal('show');
                $("#errorboxda").text(<?php echo json_encode(POPUP_VEHICLE_DELETE); ?>);
            } else {
                $("#displayData").modal("show");
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLE_ATLEAST_TO_DELETE); ?>);

            }

        });

        $("#confirm").click(function () {
            tabURL = $('li.active').children("a").attr('data');
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/deleteVehicles",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (result) {

                    $(".close").trigger('click');
                  
                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_showDriverVehicles/' + id,
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {
                                "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                            },
                            "fnInitComplete": function () {
                                $('.cs-loader').hide();
                                table.show()
                                searchInput.show()
                                $('.hide_show').show()
                                $('#vehiclesFilter').show();
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
                    
                }

            });

        });


        $("#edit").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length > 1)
            {
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLE_ONE); ?>);
                // if (confirm("Are you sure to activate " + val.length + " driver review/reviews"))
            } else if (val.length == 1)
            {
                window.location = "<?php echo base_url() ?>index.php?/superadmin/editvehicle/" + val + '/1';

            } else
            {
                $("#displayData").modal("show");

                //      alert("select atleast one passenger");
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLE_ATLEAST); ?>);
            }

        });

        $("#document_data").click(function () {

//       alert("hai");
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select one vhicle to view documents');

            } else if (val.length > 1)
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select any one vhicle to view documents');
            } else
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#myModaldocument');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#myModaldocument').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

            }
            $('#doc_body').html("");
            html = '';
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/documentgetdatavehicles",
                type: "POST",
                data: {val: $('.checkbox:checked').val()},
                dataType: 'json',
                success: function (result)
                {
                    $('#doc_body').html("");

                    $.each(result.data, function (index, vehicle) {
                        var regCertExpr = (vehicle.regCertExpr == null) ? '-' : vehicle.regCertExpr;
                        var motorInsuExpr = (vehicle.motorInsuExpr == null) ? '-' : vehicle.motorInsuExpr;
                        var permitExpr = (vehicle.permitExpr == null) ? '-' : vehicle.permitExpr;

                        html = '<tr>';
                        html += '<td>Vehicle Image</td>';
                        html += '<td>-</td>';
                        html += "<td><a href=" + vehicle.image + "  target='_blank'><img src='" + vehicle.image + "' style='width: 65px;height: 40px;'></a></td>";
                        html += '</tr>';

                        html += '<tr>';
                        html += '<td>Registration</td>';
                        html += '<td>' + regCertExpr + '</td>';
                        html += "<td><a href=" + vehicle.regCertImage + "  target='_blank'><img src='" + vehicle.regCertImage + "' style='width: 65px;height: 40px;'></a></td>";
                        html += '</tr>';

                        html += '<tr>';
                        html += '<td>Insurance</td>';
                        html += '<td>' + motorInsuExpr + '</td>';
                        html += "<td><a href=" + vehicle.motorInsuImage + "  target='_blank'><img src='" + vehicle.motorInsuImage + "' style='width: 65px;height: 40px;'></a></td>";
                        html += '</tr>';

                        html += '<tr>';
                        html += '<td>Certificate</td>';
                        html += '<td>' + permitExpr + '</td>';
                        html += "<td><a href=" + vehicle.permitImage + "  target='_blank'><img src='" + vehicle.permitImage + "' style='width: 65px;height: 40px;'></a></td>";
                        html += '</tr>';

                        $('#doc_body').append(html);

                    });

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
        <ul class="breadcrumb" style="margin-top: 5%;">


            <li>
                <a href="<?php echo base_url() ?>index.php?/superadmin/Drivers/my/1" class="active">DRIVER (<?php echo $Name ?>)</a>
            </li>
            <li>
                <a href="#" class="active">VEHICLES</a>
            </li>

        </ul>
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
            <div class="pull-right m-t-10 new_button"><button class="btn btn-primary btn-cons" id="document_data" ><?php echo BUTTON_DOCUMENT ?></button></div>
            <div class="pull-right m-t-10 new_button"> <button class="btn btn-primary btn-cons" id="chekdel"><?php echo BUTTON_DELETE; ?></button></a></div>
            <div class="pull-right m-t-10 new_button"> <button class="btn btn-primary btn-cons" id="edit"><?php echo BUTTON_EDIT; ?></button></a></div>
            <div class="pull-right m-t-10 new_button" id="addTab"><a href="<?php echo base_url() ?>index.php?/superadmin/addnewvehicle/<?php echo $id; ?>"> <button class="btn btn-primary btn-cons" id="add"><?php echo BUTTON_ADD; ?></button></a></div>
        </ul>



        <!-- Tab panes -->
        <!-- START JUMBOTRON -->
        <div class="">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent ">

                    <div class="tab-content">
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

                                    <div class="form-group" >
                                        <div class="col-sm-8" style="width: auto;" >
                                            <select id="vehiclesFilter" name="vehiclesFilter" class="form-control"  style="background-color:gainsboro;height:30px;font-size:12px;">
                                                <option value="">All</option>
                                                <option value="1">Pending Approval</option>
                                                <option value="2">Approved</option>
                                                <option value="3">Banned</option>
                                            </select>

                                        </div>
                                    </div>

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

</div>


<div class="modal fade stick-up" id="myModaldocument" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">

                <div class=" clearfix text-left">
                    <span class="modal-title">DOCUMENTS</span>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

            </div>

            <div class="modal-body">

                <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="table-responsive" style="overflow-x: hidden;"><table class="table table-hover demo-table-search dataTable no-footer" id="big_table" role="grid" aria-describedby="tableWithSearch_info">


                            <thead>

                                <tr role="row">
                                    <th  rowspan="1" colspan="1" aria-sort="ascending"  style="width: 100PX;font-size: 14px;text-align: left;"><?php echo DRIVERS_TABLE_DRIVER_DOCUMENT; ?></th>
                                    <th align="left" rowspan="1" colspan="1" aria-sort="ascending"  style="width: 100PX;font-size: 14px;text-align: left;"><?php echo DRIVERS_TABLE_DRIVER_EXPIREDATE; ?></th>
                                    <th align="left" rowspan="1" colspan="1" aria-sort="ascending"  style="width: 100PX;font-size: 14px;text-align: left;">PREVIEW</th>

                                </tr>


                            </thead>
                            <tbody id="doc_body">

                            </tbody>
                        </table>


                        <div class="row">
                            <div class="col-sm-4" ></div>
                            <div class="col-sm-4 error-box" id="errorpass"></div>
                            <div class="col-sm-4" >


                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
</div>

<div class="modal fade stick-up" id="confirmmod" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <span class="modal-title">DELETE</span>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <span class="badge  badge bg-green driverOnTrip"></span>
                    <span class="error-box deletePopUpText" id="errorboxdata" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></span>
                    <div class="error-box deletePopUpTextDiv" id="errorboxdata" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>
                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right okButton" data-dismiss="modal" style="display:none;">Ok</button></div>
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="confirm" >Delete</button></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>