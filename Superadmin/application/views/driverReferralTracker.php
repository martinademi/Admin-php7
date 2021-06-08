
<style>
    .tooltip > .tooltip-inner {background-color:#50606C;}
</style>

<style>

    .badge {
        font-size: 9px;
        margin-left: 2px;
    }

</style>


<script type="text/javascript">
    var referredCount;
    $(document).ready(function () {
        var table = $('#big_table');

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

                   $('.divCurrentPlanDate').hide();
                   $('.divCurrentPlan').hide();

                    $('.dname').text(result.driverData.firstName + ' ' + result.driverData.lastName);
                    $('.demail').text(result.driverData.firstName + ' ' + result.driverData.email);
                    $('.dphone').text(result.driverData.countryCode + result.driverData.mobile);
                    $('.joiningDate').text(moment(result.driverData.createdDt * 1000).format("DD-MM-YYYY"));

                    
                    $('.originalPlan').text(result.driverData.planName);
                    $('.referralPerc').text(result.driverPlan.referEarnings);

                    if (result.driverData.planActivedOn)
                        $('.originalPlanDate').text(moment(result.driverData.planActivedOn * 1000).format("DD-MM-YYYY"));
                    else
                        $('.originalPlanDate').text('');

                    if (result.driverPlan)
                    {
                        if (result.driverData.newPlans)
                        {
                           
                            $('.divCurrentPlanDate').show();
                            $('.divCurrentPlan').show();
                            //Get the currrent plan
                            $('.currentPlan').text(result.driverData.newPlans[result.driverData.newPlans.length - 1].planName);
                            $('.planPurchased').text(moment(result.driverData.newPlans[result.driverData.newPlans.length - 1].activatedOn * 1000).format("DD-MM-YYYY"));
                            
                            
                        } 

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
                    $.each(result.driverData, function (index, row)
                    {

                        $('.sname').text(row.first_name);
                        $('.semail').text(row.email);
                        $('.sphone').text(row.phone);
                    });

                    $('#getCustomerDetails').modal('show');

                }
            });
        });
        $(document).on('click', '.getDriversReferralsList', function ()
        {
            referredCount = $(this).attr('driverReferralCount');

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getDriversReferralsList",
                type: "POST",
                data: {mas_id: $(this).attr('mas_id')},
                dataType: 'json',
                success: function (result) {

                    $('.deletedDirverCount').hide();
                    $('.deletedDirverText').hide();

                    var html;
                    var order_id = '';
                    $('#table_body').empty();
                    if (result.driverData == null)
                    {
                        $('.deletedDirverCount').text(referredCount);
                        $('.deletedDirverCount').show();
                        $('.deletedDirverText').show();
                    } else
                    {
                        if (referredCount != result.driverData.length)
                        {
                            $('.deletedDirverCount').text(referredCount - result.driverData.length);
                            $('.deletedDirverCount').show();
                            $('.deletedDirverText').show();
                        }
                    }

                    if (result.driverData && result.driverData != null)
                    {
                        $.each(result.driverData, function (index, row)
                        {
                            if (row != null) {
                                html += "<tr><td style='text-align: center;'>" + row.firstName + " " + row.lastName + "</td>"
                                html += "</td><td style='text-align: center;'>" + row.mobile + "</td>"
                                html += "</td><td style='text-align: center;'>" + row.email + "</td>"
                                html += "</td><td style='text-align: center;'>" + row.referralCode + "</td>"

                                html += "</tr>";
                                $('#table_body').append(html);
                            }
                        });
                    }

                    $('#getDriversReferralsList').modal('show');

                }
            });
        });

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
                "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/datatable_driverReferrals',
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
                "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/bookings_data_ajax/' + $(this).val(),
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

//    function refreshContent(url) {
//
//        $('#big_table').hide();
//        $('#big_table_processing').show();
//        var table = $('#big_table');
//        $("#display-data").text("");
//
//        var settings = {
//            "autoWidth": false,
//            "sDom": "<'table-responsive't><'row'<p i>>",
//            "destroy": true,
//            "scrollCollapse": true,
//            "iDisplayLength": 20,
//            "bProcessing": true,
//            "bServerSide": true,
//            "sAjaxSource": url,
//            "bJQueryUI": true,
//            "sPaginationType": "full_numbers",
//            "iDisplayStart ": 20,
//            "oLanguage": {
//            },
//            "fnInitComplete": function () {
//                $('#big_table').show();
//            },
//            'fnServerData': function (sSource, aoData, fnCallback)
//            {
//                $.ajax
//                        ({
//                            'dataType': 'json',
//                            'type': 'POST',
//                            'url': sSource,
//                            'data': aoData,
//                            'success': fnCallback
//                        });
//            }
//        };
//
//        table.dataTable(settings);
//
//    }

</script>

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <div class="content"style="padding-top: 3px">
            <div class="brand inline" style="  width: auto;            
                 color: gray;
                 margin-left: 30px;">
                <strong style="color:#0090d9;">DRIVER REFERRAL TRACKER</strong><!-- id="define_page"-->
            </div>



            <!-- START JUMBOTRON -->
            <div class="" data-pages="parallax">
                <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20" style="margin-left: 0%;">


                    <div class="panel panel-transparent ">

                        <div class="tab-content">

                            <div class="container-fluid container-fixed-lg bg-white">
                                <!-- START PANEL -->
                                <div class="panel panel-transparent">
                                    <div class="panel-heading">

                                        <!--                                        <div class="hide_show">
                                                                                    <div class="form-group" >
                                                                                        <div class="col-sm-8" style="width:166px;margin-left: -1%;" >
                                                                                            <select id="cityFilter" name="cityFilter" class="form-control"  style="background-color:gainsboro;height:30px;font-size:12px;">
                                        
                                                                                            </select>
                                        
                                                                                        </div>
                                                                                    </div>
                                        
                                                                                    <div class="form-group showOperators" style="display:none;">
                                                                                        <div class="col-sm-8" style="width: auto;" >
                                        
                                                                                            <select id="companyid" name="company_select" class="form-control"  style="background-color:gainsboro;height:30px;font-size:12px;">
                                                                                                <option value="0">Select</option>
                                                                                            </select>
                                        
                                                                                        </div>
                                                                                    </div>
                                        
                                                                                </div>-->


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
</div>


<div class="modal fade stick-up" id="modelBookingHistory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">
                    <span class="modal-title" id="headingFor"></span>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>


                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:10%;text-align: center;">DRIVER ID</th>
                                <th style="width:20%;text-align: center;">DRIVER NAME</th>
                                <th style="width:20%;text-align: center;">DRIVER PHONE</th>
                                <th style="width:20%;text-align: center;">BOOKING RECEIVED ON</th>
                                <th style="width:20%;text-align: center;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="doc_body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</div>




<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title " style="color:red;">ALERT</span>
                <button type="button" class="close" data-dismiss="modal">×</button>


            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box errors" id="errorboxdatas" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <button type="button" data-dismiss="modal" class="btn btn-default pull-right" id="cancel">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up" id="getDriversReferralsList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">
                    <span class="modal-title" id="headingFor">REFERRAL DETAILS</span>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>


                <div class="modal-body">
                    <span class="badge deletedDirverCount" style="background-color: indianred;display:none;"></span>
                    <span class="deletedDirverText" style="display:none;"> Drivers was deleted</span>
                    <br>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:20%;text-align: center;">DRIVER NAME</th>
                                <th style="width:20%;text-align: center;">DRIVER PHONE</th>
                                <th style="width:20%;text-align: center;">DRIVER EMAIL</th>
                                <th style="width:20%;text-align: center;">REFERRAL CODE</th>
                            </tr>
                        </thead>
                        <tbody id="table_body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</div>


<div class="modal fade" id="getDriverDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">DRIVER DETAILS</strong>
            </div>
            <div class="modal-body">


                <br>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Name</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="dname"></span>
                    </div>

                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Email</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="demail"></span>
                    </div>

                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Phone</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="dphone"></span>
                    </div>

                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Original Plan</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="originalPlan"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Original Plan Joining Date</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="originalPlanDate"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>
                <div class="form-group row divCurrentPlan" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Current Plan</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="currentPlan"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>
                <div class="form-group row divCurrentPlanDate" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Current Plan Join Date</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="planPurchased"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Joined Date</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="joiningDate"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>

                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Referral (%)</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="referralPerc"></span>
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

<div class="modal fade" id="getCustomerDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">CUSTOMER DETAILS</strong>
            </div>
            <div class="modal-body">


                <br>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Name</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="sname"></span>
                    </div>

                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Email</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="semail"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Phone</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="sphone"></span>
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
