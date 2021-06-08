
<style>
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
</style>


<script>
    var tabURL;
    var vehicleId;
    var ids = [];
    var deactivateIds = [];
    var deleteIds = [];
    
    function getVehicle()
    {
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/vehicle/getVehicleCount",
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
                $('.deletedVehicleCount').text(response.data.deletedVehicleCount);
            }
        });
    }

    var html;
    var currentTab = 1;
    $(document).ready(function () {
        $(document).ajaxComplete(function () {
            console.log("hrer");
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
        getVehicle();

        $(document).on('click', '#chekdel,.deleteOne', function () {

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            deleteIds = [];
            if (val.length == 0)
            {
                deleteIds.push($(this).attr('data-id'));
            } else
                deleteIds = val;

            if (deleteIds.length > 0) {
                //Check if the driver is in trip or not before deleting the vehicle
                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/checkDriverIsOnTrip",
                    type: "POST",
                    data: {val: val},
                    dataType: 'json',
                    async: false,
                    success: function (result) {
                        if (result.driverOnTrip > 0)
                        {
                            $('.okButton').show();
                            $('.badge').show();
                            $('#confirm').hide();
                            $('.deletePopUpText').show();
                            $('.deletePopUpTextDiv').hide();
                            $('.driverOnTrip').text(result.driverOnTrip);
                            $('.deletePopUpText').text('Driver is on trip. Please let him to complete the booking first');
                        } else
                        {
                            $('.okButton').hide();
                            $('.driverOnTrip').hide();
                            $('.deletePopUpText').hide();
                            $('#confirm').show();
                            $('.deletePopUpTextDiv').show();
                            $('.deletePopUpTextDiv').text('Do you want to delete vehicle');
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
        
         $(document).on('click', '.notes', function () {
            $('#vehicleNotes').val('');
            vehicleId = $(this).attr('data-id');
            $.ajax({
                url: "<?php echo base_url('index.php?/vehicle') ?>/vehicleOperations/getNote/" + vehicleId,
                type: "GET",
                dataType: 'json',
                success: function (result) {
                    $('#vehicleNotes').val(result.data.notes);
                    $('#notesPopUp').modal('show');
                }
            });
        });

        $(document).on('click', '.updateNotes', function () {
            tabURL = $('li.active.tabs_active').children("a").attr('data');
            $.ajax({
                url: "<?php echo base_url('index.php?/vehicle') ?>/vehicleOperations/updateNote",
                type: "POST",
                data: {vehicleId: vehicleId, notes: $('#vehicleNotes').val()},
                success: function (result) {
                    $(".close").trigger('click');
                    refreshContent(tabURL);
                }
            });
        });

        $("#confirm").click(function () {
            tabURL = $('li.tabs_active.active').children("a").attr('data');

            $.ajax({
                url: "<?php echo base_url('index.php?/vehicle') ?>/vehicleOperations/delete",
                type: "POST",
                data: {val: deleteIds},
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
            if ($('#reasonForReject').val() == "") {
                $('#reasonForReject-error').text('Please provide a reason to deactivate');
            } else {
                $.ajax({
//                url: "<?php echo base_url('index.php?/vehicle') ?>/vehicleOperations/deactivate",
                    url: '<?php echo APILink; ?>admin/vehicleBan',
                    type: "POST",
                    data: {vehicleId: vehicleId,reason:$('#reasonForReject').val() },
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        /* Authorization header */
                        xhr.setRequestHeader("authorization", '<?php echo $this->session->userdata('apiToken') ?>');
                        xhr.setRequestHeader("lan", 'en');
                    },
                    success: function (result)
                    {
                        $(".close").trigger('click');
                        refreshContent(tabURL);
                    }, error: function (xhr, status, err) {
                        alert("error...! " + $.parseJSON(xhr.responseText).message);
                    }
                });
            }
        });

        $(document).on('click', '#reject,.deactivateVehicles', function () {
        
             $('#reasonForReject-error').text('');
             $('#reasonForReject').val('');
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            deactivateIds = [];
            if (val.length == 0)
            {
                val.push($(this).attr('data-id'));
                deactivateIds.push($(this).attr('data-id'));
            }

            vehicleId = $(this).attr('data-id');

            if (val.length > 0) {
                $.ajax({
                    url: "<?php echo base_url('index.php?/vehicle') ?>/checkDriverIsOnTrip",
                    type: "POST",
                    data: {val: val},
                    dataType: 'json',
                    success: function (result) {
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

        $(document).on('click', '#active,.activateVehicles', function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            ids = [];
            if (val.length == 0)
            {
                ids.push($(this).attr('data-id'));
            } else
                ids = val;

            if (ids.length > 0)
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



            $.ajax({
                url: "<?php echo base_url('index.php?/vehicle') ?>/vehicleOperations/activate",
                type: "POST",
                data: {val: ids},
                dataType: 'json',
                success: function (result)
                {
                    $(".close").trigger('click');
                    refreshContent(tabURL);

                    if (parseInt(result.flag) == 1) {
                        $('#activateFailedPopUp').modal('show');
                        $('#activateFailMsg').text(result.msg);
                    }

                }
            });
            ids = [];//Make it blank once operation is over


        });
    });



</script>


<script type="text/javascript">
    $(document).ready(function () {
        var status = '<?php echo $status; ?>';
        var table = $('#big_table');
        $('.whenclicked li').click(function () {
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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/vehicle/datatable_vehicles/' + status,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "columns": [
                    {"width": "2%"},
                    {"width": "2%"},
                    {"width": "1%"},
                    {"width": "2%"},
                    {"width": "2%"},
                    {"width": "2%"},
                    {"width": "3%"},
                    {"width": "3%"},
                    {"width": "2%"},
                    {"width": "2%"},
                    {"width": "10%"},
                    {"width": "2%"},
                    {"width": "2%"},
                    {"width": "15%"},
                    {"width": "1%"},
                ],
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
                    $('.hide_show').show();
                    /*
                     * .cls100 = view
                     * .cls110 = add
                     * .cls111 = edit and delete
                     */

                    var urlChunks = $("li.active.tabs_active").find('.changeMode').attr('data').split('/');
                    var status = urlChunks[urlChunks.length - 1];

                    if (status == 1)
                        $('.activateVehicles').show();
                    else if (status == 3)
                    {
                        $('.deactivateVehicles').hide();
                        $('.edit-button').hide();
                        $('.activateVehicles').show();
                    } else if (status == 5)
                    {

                        $('.deleteOne').hide();
                        $('.edit-button').hide();
                        $('.deactivateVehicles').hide();
                        $('.activateVehicles').hide();
                    } else if (status == 6)
                    {

                        $('.deleteOne').hide();
                        $('.edit-button').hide();
                        $('.deactivateVehicles').hide();
                        $('.activateVehicles').hide();
                    } else
                        $('.activateVehicles').hide();


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

            var urlChunks = $("li.active.tabs_active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];

            switch (status)
            {
                case '1':
                    $('#big_table').dataTable().fnSetColumnVis([9,10,11], false);
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

                if (tab_id == 5 || tab_id == 6)
                {
                    $('#reject').hide();
                    $('#active').hide();
                    $('#chekdel').hide();
                }
                if (tab_id == 4)
                {
                    $('#reject').hide();
                    $('#active').hide();
                    $('#chekdel').hide();
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
                        /*
                         * .cls100 = view
                         * .cls110 = add
                         * .cls111 = edit and delete
                         */
                        

                        if (tab_id == 1)
                            $('.activateVehicles').show();
                        else if (tab_id == 3)
                        {
                            $('.deactivateVehicles').hide();
                            $('.edit-button').hide();
                            $('.activateVehicles').show();
                        } else if (tab_id == 5)
                        {

                            $('.deleteOne').hide();
                            $('.edit-button').hide();
                            $('.deactivateVehicles').hide();
                            $('.activateVehicles').hide();
                        } else if (tab_id == 6)
                        {

                            $('.deleteOne').hide();
                            $('.edit-button').hide();
                            $('.deactivateVehicles').hide();
                            $('.activateVehicles').hide();
                        } else
                            $('.activateVehicles').hide();
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

                    var urlChunks = $("li.active.tabs_active").find('.changeMode').attr('data').split('/');
                    var status = urlChunks[urlChunks.length - 1];

                    switch (status)
                    {
                        case '1':
                            $('#big_table').dataTable().fnSetColumnVis([9,10,11], false);
                            break;
                        case '2':
                            $('#big_table').dataTable().fnSetColumnVis([9,10,11], false);
                            break;
                        case '3':
                            $('#big_table').dataTable().fnSetColumnVis([6, 7, 8, 9, 10,11], false);
                            break;
                        case '4':
                            $('#big_table').dataTable().fnSetColumnVis([6,7, 8, 9, 10,11,13], false);
                            break;
                        case '5':
                            $('#big_table').dataTable().fnSetColumnVis([4,9,11,13], false);
                            break;
                        case '6':
                            $('#big_table').dataTable().fnSetColumnVis([4,9,11,13], false);
                            break;
                    }



                });
            }

        });

        $(document).on('click', '.documentsView', function () {

            $('#doc_body').html("");
            html = '';
            $.ajax({
                url: "<?php echo base_url('index.php?/vehicle') ?>/vehicleOperations/documents",
                type: "POST",
                data: {val: $(this).attr('data-id')},
                dataType: 'json',
                success: function (result)
                {
                    $('#doc_body').html("");

                    $.each(result.data, function (index, vehicle) {

                        var carriagePermitCertDate = (vehicle.carriagePermitCertDate && vehicle.carriagePermitCertDate != '') ? moment(vehicle.carriagePermitCertDate['$date']).format('DD-MM-YYYY') : 'N/A';
                        var goodsInTransitDate = (vehicle.goodsInTransitDate && vehicle.goodsInTransitDate != '') ? moment(vehicle.goodsInTransitDate['$date']).format('DD-MM-YYYY') : 'N/A';
                        var regCertExpr = (vehicle.registrationCertExpiry && vehicle.registrationCertExpiry != '') ? moment(vehicle.registrationCertExpiry['$date']).format('DD-MM-YYYY') : 'N/A';
                        var motorInsuExpr = (vehicle.motorInsuImageDate && vehicle.motorInsuImageDate != '') ? moment(vehicle.motorInsuImageDate['$date']).format('DD-MM-YYYY') : 'N/A';
                        var inspectionDate = (vehicle.inspectionReportDate && vehicle.inspectionReportDate != '') ? moment(vehicle.inspectionReportDate['$date']).format('DD-MM-YYYY') : 'N/A';
                        var inspectionDate = (vehicle.inspectionReportDate && vehicle.inspectionReportDate != '') ? moment(vehicle.inspectionReportDate['$date']).format('DD-MM-YYYY') : 'N/A';

                        html = '<tr>';
                        html += '<td>Vehicle Image</td>';
                        html += '<td>-</td>';
                        html += "<td><a href=" + vehicle.vehicleImage + "  target='_blank'><img class='img-responsive' src='" + vehicle.vehicleImage + "' style='width: 68px;height: 54px;' alt='N/A'></a></td>";
                        html += '</tr>';

                        html += '<tr>';
                        html += '<td>Registration Document</td>';
                        html += '<td>' + regCertExpr + '</td>';
                        if (vehicle.registrationCertImage)
                        {
                            if (vehicle.registrationCertImage.split('.').pop().toLowerCase() !== "pdf")
                                html += "<td><a href=" + vehicle.registrationCertImage + "  target='_blank'><img class='img-responsive' src='" + vehicle.registrationCertImage + "' style='width: 68px;height: 54px;' alt='N/A'></a></td>";
                            else
                                html += "<td><a style='text-decoration:underline' href=" + vehicle.registrationCertImage + "  target='_blank'>PDF</a></td>";
                        } else
                            html += "<td><img class='img-responsive' src='" + vehicle.registrationCertImage + "' style='width: 68px;height: 54px;' alt='N/A'></td>";
                        html += '</tr>';

                        html += '<tr>';
                        html += '<td>Insurance Document</td>';
                        html += '<td>' + motorInsuExpr + '</td>';
                        if (vehicle.motorInsuImage)
                        {
                            if (vehicle.motorInsuImage.split('.').pop().toLowerCase() !== "pdf")
                                html += "<td><a href=" + vehicle.motorInsuImage + "  target='_blank'><img class='img-responsive' src='" + vehicle.motorInsuImage + "' style='width: 68px;height:54px;' alt='N/A'></a></td>";
                            else
                                html += "<td><a style='text-decoration:underline' href=" + vehicle.motorInsuImage + "  target='_blank'>PDF</a></td>";
                        } else
                            html += "<td><img class='img-responsive' src='" + vehicle.motorInsuImage + "' style='width: 68px;height:54px;' alt='N/A'></td>";
                        html += '</tr>';

                        html += '<tr>';
                        html += '<td>Inspection Report</td>';
                        html += '<td>' + inspectionDate + '</td>';
                        if (vehicle.inspectionReport)
                        {
                            if (vehicle.inspectionReport.split('.').pop().toLowerCase() !== "pdf")
                                html += "<td><a href=" + vehicle.inspectionReport + "  target='_blank'><img class='img-responsive' src='" + vehicle.inspectionReport + "' style='width: 68px;height: 54px;' alt='N/A'></a></td>";
                            else
                                html += "<td><a style='text-decoration:underline' href=" + vehicle.inspectionReport + "  target='_blank'>PDF</a></td>";
                        } else
                            html += "<td><img class='img-responsive' src='" + vehicle.inspectionReport + "' style='width: 68px;height: 54px;' alt='N/A'></td>";
                        html += '</tr>';

                        html += '<tr>';
                        html += '<td>Goods In Transit</td>';
                        html += '<td>' + goodsInTransitDate + '</td>';
                        if (vehicle.goodsInTransit)
                        {
                            if (vehicle.goodsInTransit.split('.').pop().toLowerCase() !== "pdf")
                                html += "<td><a href=" + vehicle.goodsInTransit + "  target='_blank'><img class='img-responsive'  src='" + vehicle.goodsInTransit + "' style='width: 68px;height: 54px;' alt='N/A'></a></td>";
                            else
                                html += "<td><a style='text-decoration:underline' href=" + vehicle.goodsInTransit + "  target='_blank'>PDF</a></td>";
                        } else
                            html += "<td><img class='img-responsive'  src='" + vehicle.goodsInTransit + "' style='width: 68px;height: 54px;' alt='N/A'></td>";

                        html += '</tr>';

                        $('#doc_body').append(html);

                    });

                }

            });

            $('#myModaldocument').modal('show');

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
                /*
                 * .cls100 = view
                 * .cls110 = add
                 * .cls111 = edit and delete
                 */
                
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

<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;

             color: gray;
             margin-left: 30px;padding-top: 20px;">

            <strong style="color:#0090d9;"><?php echo $this->lang->line('heading_vehicle'); ?></strong>
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
            <li  id= "5" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/vehicle/datatable_vehicles/1" data-id="1"><span><?php echo $this->lang->line('tab_new'); ?></span><span class="badge newVehicleCount" style="background-color: #337ab7;"></span></a>
            </li>
            <li id= "2"  class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;" >
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/vehicle/datatable_vehicles/2" data-id="2"><span><?php echo $this->lang->line('tab_approved'); ?></span><span class="badge acceptedVehicleCount" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id= "4" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/vehicle/datatable_vehicles/3" data-id="3"><span><?php echo $this->lang->line('tab_deactivated'); ?></span> <span class="badge rejectedVehicleCount" style="background-color:#f0ad4e;"></span></a>
            </li>
            <li id= "1" class="tabs_active <?php echo ($status == 4 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;">
                <a class="changeMode"  data="<?php echo base_url(); ?>index.php?/vehicle/datatable_vehicles/4" data-id="4"><span><?php echo $this->lang->line('tab_free'); ?></span><span class="badge freeVehicleCount" style="background-color: darkgray;"></span></a>
            </li>
            <li id= "3" class="tabs_active <?php echo ($status == 5 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;">
                <a class="changeMode"  data="<?php echo base_url(); ?>index.php?/vehicle/datatable_vehicles/5" data-id="5"><span><?php echo $this->lang->line('tab_logged_in'); ?></span><span class="badge bg-green  assignVehicleCount"></span></a>
            </li>
            <li id= "6" class="tabs_active <?php echo ($status == 6 ? "active" : ""); ?> " style="cursor:pointer;text-transform:uppercase;">
                <a class="changeMode"  data="<?php echo base_url(); ?>index.php?/vehicle/datatable_vehicles/6" data-id="6"><span><?php echo $this->lang->line('tab_delete'); ?></span><span class="badge  deletedVehicleCount" style="background-color:red;"></span></a>
            </li>
        </ul>
        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
            <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">
                <div class="dltbtn">
                    <div class="pull-right m-t-10 new_button cls111"> <button class="btn btn-primary btn-cons cls111" id="chekdel"><?php echo $this->lang->line('button_delete'); ?></button></a></div>

                </div>
                <!--<div class="pull-right m-t-10 new_button cls111"> <button class="btn btn-primary btn-cons" id="reject"><?php echo $this->lang->line('button_deactivate'); ?></button></div>-->
                <div class="pull-right m-t-10 new_button cls111"> <button class="btn btn-primary btn-cons cls111 id="active"><?php echo $this->lang->line('button_approved'); ?></button></div>

                <div class="pull-right m-t-10 new_button cls110" id="addTab"><a href="<?php echo base_url() ?>index.php?/vehicle/vehicleOperations/add"> <button class="btn btn-primary btn-cons cls110" id="add"><?php echo $this->lang->line('button_add'); ?></button></a></div>
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
            <!--            <div class="row">
                            <div class="error-box" id="errorboxdata" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>
            
                        </div>-->
            <div class="form-group">
                <label for="address" class="col-sm-2 control-label">Reason<span style="" class="MandatoryMarker"> *</span></label>
                <div class="col-sm-6 row">
                    <textarea class="form-control" id="reasonForReject" required=""></textarea>
                </div>
                <div class="error-box error" id="reasonForReject-error" style="text-align:center;color:red"></div>
            </div>
        </div>

        <br>

        <div class="modal-body">
            <div class="row">
                <div class="col-sm-4" ></div>
                <div class="col-sm-4"></div>
                <div class="col-sm-4" >
                    <button type="button" class="btn btn-warning pull-right cls111" id="confirmed" >Deactive</button>
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
                    <button type="button" class="btn btn-success pull-right cls111" id="confirmeds" >Activate</button>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>
<div class="modal fade stick-up" id="activateFailedPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title"></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button
            </div>
        </div>
        <br>
        <div class="modal-body">
            <div class="row">

                <div class="error-box" id="activateFailMsg" style="text-align:center"></div>

            </div>
        </div>

        <br>

        <div class="modal-footer">

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
                    <span class="error-box deletePopUpText"  style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></span>
                    <div class="error-box deletePopUpTextDiv" id="errorboxdata" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>
                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right okButton" data-dismiss="modal" style="display:none;">Ok</button></div>
                        <div class="pull-right m-t-10 cls111"> <button type="button" class="btn btn-danger pull-right" id="confirm" >Delete</button></div>
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
<div class="modal fade stick-up" id="notesPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Notes</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="vehicleNotes" id="vehicleNotes" required=""></textarea>

                        </div>
                        <div class="error-box" id="vehicleNotes-error" style="text-align:center"></div>
                    </div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6" >
                        <button type="button" class="btn btn-warning pull-right closeButton"  style="display:none;"><?php echo $this->lang->line('button_ok'); ?></button>
                        <div class="pull-right m-t-10"><button type="button" class="btn btn-success pull-right updateNotes">Update</button></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>