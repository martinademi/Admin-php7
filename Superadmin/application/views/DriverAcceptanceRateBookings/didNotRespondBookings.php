<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#big_table');

        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });
        var date = new Date();
        $('.datepicker-component').datepicker({
        });
        $('#clearData').click(function ()
        {
            $('#start').val('');
            $('#end').val('');
        });
        $('#datepicker-component').on('changeDate', function () {
            $('.datepicker').hide();
        });

        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        $('.hide_show').hide();

        setTimeout(function () {
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
//            "sPaginationType": "bootstrap",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>index.php?/DriverAcceptanceRate_controller/datatable_didNotRespondBookings/<?php echo $driverID;?>',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
                    $('#big_table_processing').hide();
                    $('.cs-loader').hide();

                    $('.hide_show').show();
                    table.show()
                    $('.hide_show').show()
                    searchInput.show()
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



        $('#Sortby').change(function () {
            var table = $('#big_table');

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>index.php?/DriverAcceptanceRate_controller/bookings_data_ajax/' + $(this).val(),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
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
                <a href="<?php echo base_url() ?>index.php?/superadmin/DriverAcceptanceRate" class="active">DID NOT RESPOND BOOKINGS</a>
            </li>
            <li>
                <a href="#" class="active"><?php echo $driverData['firstName'].' '.$driverData['lastName'];?></a>
            </li>
        </ul>

            <div class="" data-pages="parallax">
                <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20" style="margin-left: 0%;">


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


                                        <div class="pull-right hide_show"  style="display:none;"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search"> </div>


                                    </div>
                                    <div class="panel-body" style="margin-top: 1%;">
                                        <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                            <div class="table-responsive" style="overflow-x:hidden;overflow-y:hidden;">

                                                <?php
                                                $this->table->function = 'htmlspecialchars';

                                                echo $this->table->generate();
                                                ?>

                                            </div><div class="row"></div></div>
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




