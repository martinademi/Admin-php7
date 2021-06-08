
<script>

    $(document).ready(function () {

        var ID = '<?php echo $ID; ?>';
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

        $('#searchData').click(function () {
            if ($("#start").val() && $("#end").val())
            {


                var st = $("#start").datepicker().val();
                var startDate = st.split("/")[2] + '-' + st.split("/")[0] + '-' + st.split("/")[1];

                var end = $("#end").datepicker().val();
                var endDate = end.split("/")[2] + '-' + end.split("/")[0] + '-' + end.split("/")[1];

                var table = $('#big_table');

                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "autoWidth": false,
                            "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_driverRateForIndividual/' + ID + '/' + startDate + '/' + endDate,
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

                // search box for table
                $('#search-table').keyup(function () {
                    table.fnFilter($(this).val());
                });


            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_DEACTIVAT_DATEOFBOOKING); ?>);

            }

        });

        $(document).on('click', '.getDriverDetails', function ()
        {
            $('.dname').text('');
            $('.demail').text('');
            $('.dphone').text('');

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getDriverDetails",
                type: "POST",
                data: {mas_id: $(this).attr('mas_id')},
                dataType: 'json',
                success: function (result) {
                    var accoutType = (result.driverData.accountType == 2) ? 'Operator' : 'Freelancer';
                    $('.dprofilePic').attr('src', '');
                    $('.dprofilePic').hide();
                    if (result.driverData.firstName != null)
                    {
                        $('.dname').text(result.driverData.firstName + ' ' + result.driverData.lastName);
                        $('.demail').text(result.driverData.email);
                        $('.dphone').text(result.driverData.countryCode + result.driverData.mobile);
                        $('.dbusinessType').text(accoutType);

                        $('.dprofilePic').attr('src', result.driverData.image);
                        $('.dprofilePic').show();
                    }
                    $('#getDriverDetails').modal('show');

                }
            });
        });
        $(document).on('click', '.getCustomerDetails', function ()
        {

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getCustomerDetails",
                type: "POST",
                data: {slave_id: $(this).attr('slave')},
                dataType: 'json',
                success: function (result) {
                    if (result.driverData.name != null)
                    {
                        $('.sprofilePic').attr('src', '');
                        $('.sname').text(result.driverData.name);
                        $('.semail').text(result.driverData.email);
                        $('.sphone').text(result.driverData.countryCode + result.driverData.phone);
//                                     if(result.driverData.profile_pic != '')
//                                     {
                        $('.sprofilePic').attr('src', result.driverData.profile_pic);
                        $('.sprofilePic').show();
//                                     }
                    }


                    $('#getCustomerDetails').modal('show');

                }
            });
        });

    });

</script>


<script type="text/javascript">
    $(document).ready(function () {

        var ID = '<?php echo $ID; ?>';

        if (status == 1) {
            $('#inactive').show();
            $('#active').hide();
            $("#display-data").text("");

        }
        $('#big_table_processing').show();

        var table = $('#big_table');

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_driverRateForIndividual/' + ID,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
                $('#big_table_processing').hide();
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

    });


</script>


<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <ul class="breadcrumb" style="margin-top: 5%;">
            <li>
                <a href="<?php echo base_url() ?>index.php?/superadmin/Drivers/my/1" class="active">DRIVER (<?php echo $driverData['firstName'] . ' ' . $driverData['lastName']; ?>)</a>
            </li>
            <li>
                <a class="active">Rating</a>
            </li>

        </ul>

        <!-- Tab panes -->
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent ">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="col-sm-3" style="margin-left: -1%;">
                                        <div class="input-daterange input-group">
                                            <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">

                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="">
                                            <button class="btn btn-primary" type="button" id="searchData">Search</button>
                                        </div>
                                    </div>

                                    <div class="searchbtn row clearfix pull-right" >

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
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



