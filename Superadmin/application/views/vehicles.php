<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);

if ($status == 5) {
    $vehicle_status = 'New';
    $new = "active";
    echo '<style> .searchbtn{float: left;  margin-right: 63px;}.dltbtn{float: right;}</style>';
} else if ($status == 2) {
    $vehicle_status = 'Accepted';
    $accept = "active";
} else if ($status == 4) {
    $vehicle_status = 'Rejected';
    $reject = 'active';
} else if ($status == 6) {
    $vehicle_status = 'Free';
    $free = 'active';
} else if ($status == 1) {
    $active = 'active';
}
?>
<style>
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
</style>



<script>
    var tabURL;
    function getVehicle()
    {
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/superadmin/getVehicleCount",
            type: "POST",
            dataType: 'json',
            async: true,
            success: function (response)
            {
                $('.newVehicleCount').text(response.data.New);
                $('.acceptedVehicleCount').text(response.data.Accepted);
                $('.rejectedVehicleCount').text(response.data.Rejepted);
                $('.freeVehicleCount').text(response.data.Free);
                $('.assignVehicleCount').text(response.data.Assigned);
            }
        });
    }

    var html;
    var currentTab = 1;
    $(document).ready(function () {
        getVehicle();

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
               $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLE_ATLEAST_TO_DELETE); ?>);

            }

        });

        $("#confirm").click(function () {
            tabURL = $('li.tabs_active.active').children("a").attr('data');
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
                    refreshContent(tabURL);
                }

            });

        });


        $("#confirmed").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            tabURL = $('li.tabs_active.active').children("a").attr('data');
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/reject_vehicle",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (result)
                {
                    $(".close").trigger('click');
                    refreshContent(tabURL);
                }
            });
        });

        $("#reject").click(function () {

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length > 0) {
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
                            $('.deletePopUpText').text('Driver is in trip.Please let him to complete the booking first');
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
                $('#confirmmodel').modal('show');
                $("#errorboxdata").text(<?php echo json_encode(POPUP_VEHICLE_DEACTIVATE); ?>);
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLE_ATLEAST_TO_REJECT); ?>);
            }

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
                window.location = "<?php echo base_url() ?>index.php?/superadmin/editvehicle/" + val;

            } else
            {
               $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLE_ATLEAST); ?>);
            }

        });

        $("#active").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length > 0)
            {
                $('#confirmmodels').modal('show');
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_VEHICLE_ACTIVATE); ?>);
            } else
            {
               $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLE_ATLEAST_TO_ACTIVATE); ?>);
            }

        });

        $("#confirmeds").click(function () {
            tabURL = $('li.tabs_active.active').children("a").attr('data');


            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/activate_vehicle",
                    type: "POST",
                    data: {val: val},
                    dataType: 'json',
                    success: function (result)
                    {
                        $(".close").trigger('click');
                        refreshContent(tabURL);
                    }
                });
            }

        });
    });



</script>


<script type="text/javascript">
    $(document).ready(function () {

        var status = '<?php echo $status; ?>';

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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_vehicles/' + status,
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

        $('#big_table').on('init.dt', function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];

            switch (status)
            {
                case '1':
                    $('#big_table').dataTable().fnSetColumnVis([5, 6], false);
                    break;
                case '2':
                    $('#big_table').dataTable().fnSetColumnVis([5, 6], false);
                    break;
                case '3':
                    $('#big_table').dataTable().fnSetColumnVis([5, 6, 7], false);
                    break;
                case '4':
                    $('#big_table').dataTable().fnSetColumnVis([4, 5, 6, 7], false);
                    break;
                case '5':
                    $('#big_table').dataTable().fnSetColumnVis([7], false);
                    break;
            }



        });


        $('.changeMode').click(function () {

            var tab_id = $(this).attr('data-id');
            $('#display-data').text('');

            if (currentTab != tab_id)
            {
                currentTab = tab_id;
                $('#big_table').hide();

                if (tab_id == 5)
                {
                    $('#reject').hide();
                    $('#active').hide();
                    $('#chekdel').hide();
                }
                if (tab_id == 4)
                {
                    $('#reject').show();
                    $('#active').show();
                    $('#chekdel').show();
                } else if (tab_id == 1)
                {
                    $('#reject').show();
                    $('#active').show();
                    $('#chekdel').show();
                    $('#edit').show();
                }
                if (tab_id == 2)
                {
                    $('#active').hide();
                    $('#reject').show();
                    $('#chekdel').show();
                    $('#edit').show();
                }
                if (tab_id == 3)
                {
                    $('#reject').hide();
                    $('#active').show();
                    $('#edit').hide();
                    $('#chekdel').show();
                }


                if (tab_id != 1)
                    $('#addTab').hide();

                if (tab_id == 1)
                    $('#addTab').show();

                var table = $('#big_table');
                $('#big_table_processing').show();
                getVehicle();

                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": $(this).attr('data'),
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "iDisplayStart ": 20,
                    "oLanguage": {
                    },
                    "fnInitComplete": function () {
                        //oTable.fnAdjustColumnSizing();
                        $('#big_table').show();
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

                $('.tabs_active').removeClass('active');

                $(this).parent().addClass('active');



                table.dataTable(settings);

                $('#big_table').on('init.dt', function () {

                    var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                    var status = urlChunks[urlChunks.length - 1];

                    switch (status)
                    {
                        case '1':
                            $('#big_table').dataTable().fnSetColumnVis([5, 6], false);
                            break;
                        case '2':
                            $('#big_table').dataTable().fnSetColumnVis([5, 6], false);
                            break;
                        case '3':
                            $('#big_table').dataTable().fnSetColumnVis([5, 6, 7], false);
                            break;
                        case '4':
                            $('#big_table').dataTable().fnSetColumnVis([4, 5, 6, 7], false);
                            break;
                        case '5':
                            $('#big_table').dataTable().fnSetColumnVis([7], false);
                            break;
                    }



                });
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
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLE_DOCUMENT); ?>);

            } else if (val.length > 1)
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_ONLYEDIT_DOCUMENT); ?>);
            } else
            {
                    $('#myModaldocument').modal('show');
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

    function refreshContent(url) {

        getVehicle();

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
            "sAjaxSource": url,
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
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;

             color: gray;
             margin-left: 30px;padding-top: 20px;">
           <!--                    <img src="--><?php //echo base_url();                 ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();                 ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();                 ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="color:#0090d9;">VEHICLES</strong><!-- id="define_page"-->
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
            <li  id= "5" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_vehicles/1" data-id="1"><span><?php echo LIST_NEW; ?></span><span class="badge newVehicleCount" style="background-color: #337ab7;"></span></a>
            </li>
            <li id= "2"  class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;" >
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_vehicles/2" data-id="2"><span>APPROVED</span><span class="badge acceptedVehicleCount" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id= "4" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_vehicles/3" data-id="3"><span>DE-ACTIVATED</span> <span class="badge rejectedVehicleCount" style="background-color:#f0ad4e;"></span></a>
            </li>
            <li id= "1" class="tabs_active <?php echo ($status == 4 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;">
                <a class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/datatable_vehicles/4" data-id="4"><span>FREE</span><span class="badge freeVehicleCount" style="background-color: darkgray;"></span></a>
            </li>
            <li id= "3" class="tabs_active <?php echo ($status == 5 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;">
                <a class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/datatable_vehicles/5" data-id="5"><span>LOGGED IN</span><span class="badge bg-green  assignVehicleCount"></span></a>
            </li>
        </ul>
        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
            <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">
                <div class="dltbtn">
                    <div class="pull-right m-t-10 new_button cls111"> <button class="btn btn-primary btn-cons" id="chekdel"><?php echo BUTTON_DELETE; ?></button></a></div>
                    <div class="pull-right m-t-10 new_button cls100"><button class="btn btn-primary btn-cons" id="document_data" ><?php echo BUTTON_DOCUMENT ?></button></div>

                </div>
                <div class="pull-right m-t-10 new_button cls111"> <button class="btn btn-primary btn-cons" id="reject">Deactive</button></div>
                <div class="pull-right m-t-10 new_button cls111"> <button class="btn btn-primary btn-cons" id="active"><?php echo BUTTON_ACTIVATE; ?></button></div>

                <div class="pull-right m-t-10 new_button cls111"> <button class="btn btn-primary btn-cons" id="edit"><?php echo BUTTON_EDIT; ?></button></a></div>
                <div class="pull-right m-t-10 new_button cls110" id="addTab"><a href="<?php echo base_url() ?>index.php?/superadmin/addnewvehicle"> <button class="btn btn-primary btn-cons" id="add"><?php echo BUTTON_ADD; ?></button></a></div>
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