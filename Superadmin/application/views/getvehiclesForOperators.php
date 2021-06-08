
<script type="text/javascript">
    $(document).ready(function () {

        var operatorID = '<?php echo $operatorID; ?>';

        var table = $('#big_table');


        $('.whenclicked li').click(function () {

            // alert($(this).attr('id'));

            if ($(this).attr('data-id') == 5) {

                $('#add').show();
                $('#active').hide();
                $('#reject').hide();

            } else if ($(this).attr('data-id') == 2) {
                $('#active').hide();
                $('#reject').show();

            } else if ($(this).attr('data-id') == 4) {
                $('#reject').hide();
                $('#active').hide();


            } else if ($(this).attr('data-id') == 1) {
                $('#add').show();
                $('#active').show();
            } else if ($(this).attr('data-id') == 3) {
                $('#add').show();
                $('#reject').show();
            }

        });


        var searchInput = $('#search-table');
        searchInput.hide();
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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_getVehiclesForOperators/'+operatorID,
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


        $("#document_data").click(function () {

//       alert("hai");
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 0) {
                $("#displayData").modal("show");

                //         alert("please select any one dispatcher");
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLE_DOCUMENT); ?>);

            } else if (val.length > 1)
            {
                $("#displayData").modal("show");
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_ONLYEDIT_DOCUMENT); ?>);
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
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">


       <ul class="breadcrumb" style="margin-top: 5%;">
            <li>
                <a href="<?php echo base_url() ?>index.php?/superadmin/operators/1" class="active">OPERATOR (<?php echo $Operator['operatorName']; ?>)</a>
            </li>
            <li>
                <a href="#" class="active">VEHICLES</a>
            </li>

        </ul>
    
        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
            <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">
                <div class="dltbtn">
                    
                    <div class="pull-right m-t-10 new_button cls100"><button class="btn btn-primary btn-cons" id="document_data" ><?php echo BUTTON_DOCUMENT ?></button></div>

                </div>
                
            </ul>
        </div>
        <!-- Tab panes -->
        <!-- START JUMBOTRON -->
        <div class="">
            <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
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

                                    <div class="row clearfix pull-right" >
                                        <div class="col-sm-12">
                                            <div class="searchbtn" >

                                                <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?> "> </div>
                                            </div>

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



<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">DEACTIVE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button
            </div>

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
                <div class="col-sm-4"></div>
                <div class="col-sm-4" >
                    <button type="button" class="btn btn-warning pull-right" id="confirmed" >Deactive</button>
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

                <span class="modal-title">ACTIVE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button
            </div>
        </div>
        <br>
        <div class="modal-body">
            <div class="row">

                <div class="error-box" id="errorboxdatas" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

            </div>
        </div>

        <br>

        <div class="modal-footer">
            <div class="row">
                <div class="col-sm-4" ></div>
                <div class="col-sm-4"></div>
                <div class="col-sm-4" >
                    <button type="button" class="btn btn-success pull-right" id="confirmeds" >Activate</button>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
    <!-- /.modal-dialog -->
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