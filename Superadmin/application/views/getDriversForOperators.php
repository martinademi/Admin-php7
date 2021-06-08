
<style>
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    .imageborder{
        border-radius: 50%;
    }
    .btn{ font-size: 10px;
    }
    td span {
        line-height: 16px;
    }
</style>

<script>
    var currentTab = 1;
    var htmlForPlans;
    var tabURL;
    $(document).ready(function () {

        $(document).on('click', '.deviceInfo', function ()
        {
            $('.make').text($(this).attr('make'));
            $('.model').text($(this).attr('model'));
            $('.os').text($(this).attr('os'));
            $('.lastLoginDate').text($(this).attr('last_active_dt'));
            $('.pushToken').text($(this).attr('push_token'));
            $('#deviceInfoPopUp').modal('show');

        });

        $('#deviceLogs').click(function ()
        {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0)
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select one drivers to get device logs');
            } else if (val.length > 1)
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select only one drivers to get device logs');
            } else {
                $('#device_log_data').empty();
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getDeviceLogs/driver",
                    type: "POST",
                    data: {mas_id: $('.checkbox:checked').val()},
                    dataType: 'json',
                    success: function (result)
                    {

                        var html = '';
                        var deviceType = '';
                        $('#d_name_history').text(result.data.firstName + ' ' + result.data.lastName)
                        $.each(result.data.devices, function (index, logs) {
                            deviceType = '-';
                            if (logs.deviceType != 0 && logs.deviceType != "")
                            {
                                if (logs.deviceType == 1)
                                    deviceType = 'IOS';
                                else if (logs.deviceType == 2)
                                    deviceType = 'ANDRIOD';
                            }
//                                        deviceType = ((logs.deviceType != 0)?((logs.deviceType != 0)?'IOS':'ANDRIOD')):'-';
                            html = "<tr>";
                            html += "<td>" + deviceType + "</td>";
                            html += "<td>" + logs.appversion + "</td>";
                            html += "<td>" + logs.devMake + "</td>";
                            html += "<td>" + logs.devModel + "</td>";
                            html += "<td>" + logs.deviceId + "</td>";
                            html += "<td>" + logs.pushToken + "</td>";
                            html += "<td>" + moment(logs.serverTime['$date']).format("DD-MM-YYYY HH:mm:ss") + "</td>";

                            html += "</tr>";
                            $('#device_log_data').append(html);

                        });


                    }
                });

                $('#deviceLogPopUp').modal('show');
            }
        });


        $("#document_data").click(function () {


            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_DOC_VIEW); ?>);
            } else if (val.length > 1)
            {

                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_DOC_VIEW); ?>);
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

            $('#doc_body').html('');

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/documentgetdata",
                type: "POST",
                data: {mas_id: $('.checkbox:checked').val()},
                dataType: 'json',
                success: function (result)
                {


                    $.each(result, function (index, doc) {

                        var html = "<tr><td style='text-align: center;'>";
                        html += "Profile Pic</td><td style='text-align: center;'>" + "<a href=" + doc.image + " target='_blank'><img src=" + doc.image + " style='height:46px;width:52px' class='img-circle'></a></td></tr>";

                        html += "<tr><td style='text-align: center;'>Driving Licence</td>" + "<td style='text-align: center;'><a href=" + doc.driverLicense + "  target='_blank'><img src=" + doc.driverLicense + " style='height:46px;width:52px' class='img-circle'></a></td>"


                        html += "</tr>";
                        $('#doc_body').append(html);


                    });
                    $("#documentok").click(function () {
                        $('.close').trigger('click');
                    });

                }
            });


        });

    });

</script>


<script type="text/javascript">
    $(document).ready(function () {
        $('.cs-loader').show();

        var table = $('#big_table');
        var searchInput = $('#search-table');
        $('.hide_show').hide();
        searchInput.hide();
        table.hide();


        var operatorID = '<?php echo $operatorID; ?>';

        setTimeout(function () {
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_getDriversForOperators/' + operatorID,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    table.show()
                    $('.cs-loader').hide()
                    $('.hide_show').show();
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

            // search box for table
            $('#search-table').keyup(function () {

                table.fnFilter($(this).val());
            });

        }, 1000);


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

                        if (result.driverData.image != '')
                        {
                            $('.dprofilePic').attr('src', result.driverData.image);
                            $('.dprofilePic').show();
                        }
                    }

                    $('#getDriverDetails').modal('show');//Code in footer.php

                }
            });
        });

    });


   
</script>


<style>
    .exportOptions{
        display: none;
    }
    /*    .btn-cons {
            margin-right: 5px;
            min-width: 102px;
        }
        .btn{
            font-size: 13px;
        }*/
</style>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <ul class="breadcrumb" style="margin-top: 5%;">
            <li>
                <a href="<?php echo base_url() ?>index.php?/superadmin/operators/1" class="active">OPERATOR (<?php echo $Operator['operatorName']; ?>)</a>
            </li>
            <li>
                <a href="#" class="active">DRIVERS</a>
            </li>

        </ul>
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">



                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->


                    <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                        <div class="cls100"><button class="btn btn-primary pull-right m-t-10 " id="deviceLogs"  style="margin-top: 5px;">Device Logs</button></div>
                        <div class="cls100"><button class="btn btn-primary pull-right m-t-10 " id="document_data"  style="margin-top: 5px;"><?php echo BUTTON_DOCUMENT ?></button></div>  
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="cs-loader">
                                            <div class="cs-loader-inner" >
                                                <label class="loaderPoint" style="color:#10cfbd">●</label>
                                                <label class="loaderPoint" style="color:red">●</label>
                                                <label class="loaderPoint" style="color:#FFD119">●</label>
                                                <label class="loaderPoint" style="color:#4d90fe">●</label>
                                                <label class="loaderPoint" style="color:palevioletred">●</label>
                                            </div>
                                        </div>
                                        <!--                                        <div class="hide_show">
                                                                                    <div class="form-group" >
                                                                                        <div class="col-sm-8" style="width:166px;" >
                                                                                            <select id="operatorType" name="operatorType" class="form-control"  style="background-color:gainsboro;height:30px;font-size:12px;">
                                                                                                <option value="">All</option>
                                                                                                <option value="1">Freelancer</option>
                                                                                                <option value="2">Operator</option>
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


                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                    </div>

                                    <!--                                    <div class="row hide_show" style="margin-top:8px;display:none;">
                                                                            <div class="form-group">
                                                                                <div class="col-sm-8" style="width:166px;" >
                                                                                    <select id="planFilter" name="planFilter" class="form-control"  style="background-color:gainsboro;height:30px;font-size:12px;">
                                    
                                                                                    </select>
                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>-->
                                </div>

                                <div class="panel-body">

                                    <?php
                                    echo $this->table->generate();
                                    ?>

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

<input type="hidden" name="current_dt" id="time_hidden" value=""/>


<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">ACCEPT</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                <form id="" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="form-group">
                        <label for="fname" class="col-sm-12 control-label">Please make sure you have validated all the documents submitted before you approve the driver’s membership</label>


                    </div>

                    <div class="form-group planDiv">
                        <span class="deletedPlanTest" style="display:none;font-weight:600;"></span>
                        <br>
                        <br>
                        <label for="fname" class="col-sm-2 control-label">Plans<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" id="plans" name="plans">
                                <option value="0"></option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 errors" id="plansErr"></div>
                    </div>

                </form>
            </div>


            <div class="modal-footer">
                <div class="row">

                    <div class="col-sm-6 " id="ve_compan"></div>
                    <div class="col-sm-6" >
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="confirmed" >ACCEPT</button></div>
                    </div>
                </div>
            </div>
        </div><!--
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>






<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">REJECT</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6" >
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                        <div class="pull-right m-t-10"><button type="button" class="btn btn-warning pull-right" id="confirmeds" >Reject</button></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="banPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">BAN</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="banMsg" style="text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6" >
                        <button type="button" class="btn btn-warning pull-right closeButton"  style="display:none;">Ok</button>
                        <div class="pull-right m-t-10"><button type="button" class="btn btn-warning pull-right okButton" id="banButton">Yes</button></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up" id="myModal1_driverpass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <span class="modal-title">RESET PASSWORD</span>
                    </div>


                    <div class="modal-body">
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label"> <?php echo FIELD_NEWPASSWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="newpass1" name=""  class="newpass form-control" placeholder="New Password">
                            </div>
                        </div>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_CONFIRMPASWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="confirmpass1" name="" class="confirmpass form-control" placeholder="Confirm Password">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="col-sm-6 error-box errors" id="errorpass_driversmsg"></div>
                        <div class="col-sm-6" >
                            <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                            <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="editpass_msg" ><?php echo BUTTON_SUBMIT; ?></button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>






<div class="modal fade stick-up" id="confirmmodelss" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatass" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="confirmedss" ><?php echo BUTTON_OK; ?></button></div>
                    </div>
                </div>
            </div>
        </div>
        <a href="vehicletype_addedit.php"></a>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="deletedriver" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">DELETE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="yesdelete" >Delete</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="acceptdrivermsg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox_accept" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-default pull-right" id="accepted_msg" >Close</button>
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

            <div class="modal-body">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title">DOCUMENTS</span>
                </div>


                <div class="modal-body">
           <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->

                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th style="width:20%;text-align: center;">TYPE</th>
                                <th style="width:10%;text-align: center;">PREVIEW</th>

                            </tr>
                        </thead>
                        <tbody id="doc_body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
                <!-- /.modal-dialog -->
            </div>


        </div>
    </div> </div>

<div class="modal fade stick-up" id="Model_manual_logout" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">LOGOUT</span>
            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox_logout" style="text-align:center"><?php echo ARE_YOU_SURE_TO_LOGOUT_THIS_DRIVER; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="ok_to_logout" ><?php echo BUTTON_OK; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="deviceInfoPopUp" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DEVICE INFO</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">

                <div class="form-group row">

                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">Make</label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="make"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">Model</label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="model"></span>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">OS</label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="os"></span>
                    </div>

                </div>
                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">Last Login Date & Time</label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="lastLoginDate"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">Push Token</label>
                    <div class="col-md-8 col-sm-8 pushToken" style="word-break: break-all;">

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade stick-up" id="deviceLogPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">DEVICE INFO</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body form-horizontal">
                <div class="row">
                    <span style="color:#738092;font-weight:700;margin-left: 10px;">Driver Name : <span id="d_name_history" style="color:#1ABB9C;"></span></span>
                </div>
                <br>
                <div class="table-responsive">
                    <table class='table table-striped table-bordered table-hover demo-table-search' id="devices_datatable">
                        <thead>
                        <th >DEVICE TYPE</th>
                        <th style="">APP VERSION</th>
                        <th style="">DEVICE MAKE</th>
                        <th style="">DEVICE MODEL</th>
                        <th style="">DEVICE ID</th>
                        <th style="">PUSH TOKEN</th>
                        <th style="">LAST LOGGED IN DATE</th>
                        </thead>


                        <tbody id="device_log_data">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>