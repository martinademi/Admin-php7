<style>
    .color1{
        font-weight: 600;
        color: #47235a;
    }
</style>
<script type="text/javascript">

    $(document).ready(function () {


        var table = $('#big_table');
        $('.hide_show').hide();
        table.hide();
        setTimeout(function () {
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
//            "sPaginationType": "bootstrap",
                "destroy": true,
                "scrollCollapse": true,
//            "oLanguage": {
//                "sLengthMenu": "_MENU_ ",
//                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
//            },
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/datatable_driverCompletedBookingList/<?php echo $driverID; ?>/<?php echo $cycleID; ?>',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                                },
                                "fnInitComplete": function () {
                                    //oTable.fnAdjustColumnSizing();
                                    table.show();
                                    $('.hide_show').show();
                                    $('.cs-loader').hide();
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
                        }, 1000);


                    });
</script>

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper" >
    <!-- START PAGE CONTENT -->
    <div class="content">
        <ul class="breadcrumb" style="margin-top: 5%;">
            <li>
                <a href="<?php echo base_url() ?>index.php?/superadmin/paymentCycleDriversList/<?php echo $cycleID; ?>" class="active">DRIVERS</a>
            </li>
            <li>
                <a href="#" class="active">BOOKINGS</a>
            </li>
        </ul>

        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
            <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">
                <div class="row color1">
                    <div class="col-md-3">
                        <div class="col-md-2 pull-left">NAME</div>
                        <div class="col-md-10 pull-left">: <?php echo $driverDetail['firstName'] . ' ' . $driverDetail['lastName']; ?></div>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3 color1">
                        <div class="col-md-4">
                            <label>CYCLE ID</label>
                        </div>
                        <div class="col-md-8">: <?php echo $paymentCycleDetails['_id']; ?></div>

                    </div>
                </div>
                <div class="row color1">
                    <div class="col-md-3">
                        <div class="col-md-2 pull-left">EMAIL</div>
                        <div class="col-md-10 pull-left">: <?php echo $driverDetail['email']; ?></div>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3 color1">
                        <div class="col-md-4">
                            <label>START</label>
                        </div>
                        <div class="col-md-8">: <?php echo date('d-m-Y H:i:s', $paymentCycleDetails['startDate']); ?></div>

                    </div>
                </div>
                <div class="row color1">
                    <div class="col-md-3">
                        <div class="col-md-2 pull-left">PHONE</div>
                        <div class="col-md-10 pull-left">: <?php echo $driverDetail['mobile']; ?></div>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3 color1">
                        <div class="col-md-4">
                            <label>END</label>
                        </div>
                        <div class="col-md-8">: <?php echo date('d-m-Y H:i:s', $paymentCycleDetails['endDate']); ?></div>

                    </div>
                </div>
            </ul>
        </div>



        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12">
                            <div class="panel-heading">
                                <div class="row clearfix">

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
                                        <input type="text" id="search-table" class="form-control pull-right" placeholder="Search"> </div>


                                </div>

                            </div>
                        </div>
                        <div class="panel-body" style="margin-top: 1%;">
                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                <div class="table-responsive" style="overflow-x:hidden;overflow-y:hidden;">

                                    <?php echo $this->table->generate(); ?>

                                </div><div class="row"></div></div>
                        </div>
                        <!-- END PANEL -->


                    </div>
                </div>


            </div>


        </div>

    </div>
</div>



