
<style>
    .input-group-addon {
        font-size: inherit;
    }
    .pos_relative ,.pos_relative2{
        position: relative;
        padding-right:0px
    }
    .pos_relative2{
        padding-right:10px
    }
    .input-group {
        margin-bottom: 0px;
    }
    .input-group-addon {
        border-radius: 0px !important;
    }
    input[type='file'] {
        color: transparent;
    }
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    .bookingID,.paymentType,.heading{
        font-weight: 600;
        color: #9f62bf;
        font-size: 10px;
    }
    .small{
        color:rgb(39, 144, 179);
    }
    .new-container {
        padding-left: 4px;
        padding-right: 2px;
    }
    .new-12{
        padding-right: 0px;
        padding-left: 0px;
    }

</style>
<script src="<?php echo base_url() ?>mqttws.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>webSocket.js" type="text/javascript"></script>
<script>
    var arrayD = [];
    var Diveid = 0;
    var slaveChannel;
    var tabURL;
    var zoneAndPickupAddr;
    var zoneAndDropAddr;

    function isNumberKey(evt)
    {
        $("#mobify").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
            //    alert("Only numbers are allowed");
            $("#mobify").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
            return false;
        }
        return true;
    }


    var table;
    $(document).ready(function () {
    
    client.onMessageArrived = function (message) {
//               console.log("Msg",message);
            var topicName = message.destinationName;
            console.log(topicName);
            var topic = topicName.split("/");
//            console.log(topic);
            console.log(topic[1]);
            if (topicName == 'adminOrderUpdates')
            {
                console.log('message', message);
                console.log('message.destinationName', message.destinationName);
                console.log('message.payloadString', message.payloadString);
                $('#big_table').find('tr:first').find('th:first').trigger('click');
            }
        };

        $('.number').keypress(function (event) {
            if (event.which < 46
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if (event.which == 46
                    && $(this).val().indexOf('.') != -1) {
                event.preventDefault();
            } // prevent if already dot
        });
        $('.cs-loader').show();
        $('#selectedcity').hide();
        $('#companyid').hide();
        table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
//     table.hide();


        setTimeout(function () {
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_onGoingBookings/1',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"width": "15%"},
                     {"width": "15%"},
                    null,
                    null,
                    null,
                    null
                ],
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    table.show()
                    $('.cs-loader').hide()
                    searchInput.show()
                    $('#selectedcity').show()
                    $('#companyid').show()
                    $('.panel-body').show()
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
            table.fnSort([[0, 'desc']]);
            // search box for table
            $('#search-table').keyup(function () {
                $('#start').val('');
                $('#end').val('');
                table.fnFilter($(this).val());
            });
        }, 1000);
        $(document).on("click", ".assignDriver", function ()
        {
            $('#modalForGetDrivers').modal('show');
        });
        $(document).on('click', '.manageBooking', function ()
        {
            //Get the status for booking
            $.ajax({
                type: 'post',
                url: '<?php echo base_url('index.php?/superadmin/get_appointment_details') ?>',
                data: {order_id: $(this).attr('order_id')},
                dataType: 'json',
                success: function (result)
                {
                    console.log(result.shipmentData.status);
                    switch (parseInt(result.shipmentData.status))
                    {
                        case 6:
                            $('#status7').attr('checked', true);
                            break;
                        case 7:
                            $('#status7').attr('checked', true);
                            break;
                        case 8:
                            $('#status8').attr('checked', true);
                            break;
                        case 9:
                            $('#status9').attr('checked', true);
                            break;
                        case 16:
                            $('#status16').attr('checked', true);
                            break;
                        case 10:
                            $('#status10').attr('checked', true);
                            break;
                    }
                }
            });
            $('#appId').val($(this).attr('order_id'));
            $('.bookingID').text(': ' + $(this).attr('order_id'));
            $('.paymentType').text(': ' + $(this).attr('paymentType'));
            $('#charged_amount_for_complete').val($(this).attr('billedAmount'));
            $('#charged_amount_for_cancel').val($(this).attr('cancelAmount'));
            $('#manageBooking').modal('show');
        });
        $(document).on('click', '.showEstimatedFareDetials', function ()
        {
            $('.estimatedFare').text('');
            $('.estimatedTime').text('');
            $('.estimatedFare').text('<?php echo $appConfig['currencySymbol'] ?>' + ' ' + $(this).attr('estimateFare'));
            $('.estimatedTime').text($(this).attr('estimatedTime') + ' Minutes');
            $('#showEstimatedFareDetails').modal('show'); //Code in footer.php

        });

        var JobStatus = <?= json_encode(unserialize(JobStatus)); ?>;
        var Diveid = 0;
       
        $('.changeMode').click(function () {
            table.hide();
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/getBookingCount",
                type: "POST",
                dataType: 'json',
                async: true,
                success: function (response)
                {
                    $('.assignedBookingCount').text(response.data.Assigned);
                    $('.unassignedBookingCount').text(response.data.Unassigned);
                }
            });
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
                    "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    table.show();
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
        });

        $('.radio').change(function () {
            $('.trip_complete_with_charge').hide();
            $('#trip_cancel_with_charge').hide();
            $('.cancelWithoutFeeDiv').hide();
            if ($(this).attr('id') == 'status11')
                $('.trip_complete_with_charge').show();
            else if ($(this).attr('id') == 'status31')
                $('#trip_cancel_with_charge').show();
            else if ($(this).attr('id') == 'status30')
                $('.cancelWithoutFeeDiv').show();

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
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/datatable_onGoingBookings/1/' + startDate + '/' + endDate,
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
            } else
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodels');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#confirmmodels').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_DRIVERS_DEACTIVAT_DATEOFBOOKING); ?>);
                $("#confirmeds").click(function () {
                    $('.close').trigger('click');
                });
            }
        });
        $('.submit').click(function () {
            var bid = $('#appId').val();
            var status = '';

            //get the updated status
            $('.radio').each(function () {
                if ($(this).is(':checked'))
                    status = $(this).val();
            });

            if ($('.radio').attr('id') == 'status11') {

                if ($('#charged_amount_for_complete').val() == '')
                    $('#errMsgComplete').text('Please enter charged amount');
                else if ($('#handling_fee').val() == '')
                    $('#errMsgComplete').text('Please enter handling fee');
                else if ($('#toll_fee').val() == '')
                    $('#errMsgComplete').text('Please enter toll fee');
            } else if ($('.radio').attr('id') == 'status30') {
                if ($('#cancelBy').val() == '')
                    $('#cancelByErr').text('Please enter charged amount');
            } else {

                $.ajax({
                    type: 'post',
                    url: '<?php echo APILink ?>admin/managebooking',
                    data: {status: status, bid: bid},
                    dataType: 'json',
                    success: function (result) {

                        if (result.errNum == 200)
                        {
                            $('.close').trigger('click');
                            table = $('#big_table');
                            var searchInput = $('#search-table');
                            searchInput.hide();

                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_onGoingBookings/1',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "columns": [
                                    null,
                                    null,
                                    null,
                                    null,
                                    {"width": "15%"},
                                    null,
                                    {"width": "15%"},
                                    null,
                                    null,
                                    null,
                                    null
                                ],
                                "oLanguage": {
                                },
                                "fnInitComplete": function () {
                                    table.show()
                                    $('.cs-loader').hide()
                                    searchInput.show()
                                    $('#selectedcity').show()
                                    $('#companyid').show()
                                    $('.panel-body').show()
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
                        } else {
                            alert('Error..! While updating the status');
                        }
                    }
                });
            }


        });
    });


</script>
<div class="brand inline" style=" width: auto;           
     color: gray;">


    <strong style="color:#0090d9;">ON GOING ORDERS</strong>
</div>
<div class="tab-pane slide-left" id="slide5">
    <div class="row column-seperation">
        <div class="col-md-12 new-12">

            <ul class="nav nav-tabs  bg-white" style="margin-top: 1%;">
                <div class="col-sm-4 hide_show">
                    <div class="" aria-required="true">

                        <div class="input-daterange input-group">
                            <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">

                        </div>
                    </div>
                </div>
                <div class="col-sm-1 hide_show" style="min-width:103px;">

                    <button class="btn btn-primary" type="button" id="searchData">Search</button>

                </div>
                <div class="col-sm-1 hide_show">

                    <button class="btn btn-info" type="button" id="clearData">Clear</button>

                </div> 
                <!--                        <li id= "my3" class="tabs_active active" style="cursor:pointer">
                                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_onGoingBookings/2" data-id="2"><span>UNASSIGNED</span> <span class="badge unassignedBookingCount" style="background-color: indianred;"></span></a>
                                        </li>
                                        <li id= "my1" class="tabs_active" style="cursor:pointer">
                                            <a  class="changeMode New_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_onGoingBookings/1" data-id="1"><span>ASSIGNED</span><span class="badge bg-green assignedBookingCount" style="background-color: #337ab7;"></span></a>
                                        </li>-->


                <div class="pull-right" style="margin-right: 0.7%;">
                    <div class="col-xs-12">
                        <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
                    </div>
                </div>
            </ul>
            <div class="container-fluid container-fixed-lg bg-white  new-container">
                <!-- START PANEL -->
                <div class="panel panel-transparent" style="margin-top: 0%;">


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



                    </div>
                    <div class="panel-body" style="display:none;">


                        <?php
                        echo $this->table->generate();
//                                     
                        ?>

                    </div>
                    <!-- END PANEL -->
                </div>
            </div>

        </div>
    </div>
</div>
<!--this is the end of customers tab-->
<!--the div which we needs to close is it follows-->

<div class="modal in" id="manageBooking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <div class="row">
                    <div class="col-md-6">
                        <span class="modal-title" id="headingFor1">MANAGE BOOKING</span>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-5">
                            <span class="heading">BOOKING ID</span>
                        </div>
                        <div class="col-md-7 pull-left bookingID">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-5">
                            <span class="heading">PAYMENT TYPE</span>
                        </div>
                        <div class="col-md-7 paymentType">

                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-1">
                            <input type="radio" class="radio" id="status7" name="radio" value="7"></div>
                        <div class="col-sm-10">
                            <p class="pull-left no-margin"><label for="status7">Driver Arrived at Pickup Point</label></p>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-1">
                            <input type="radio" class="radio" id="status8" name="radio" value="8" ></div>
                        <div class="col-sm-10">
                            <p class="pull-left no-margin"><label for="status8">Trip Started</label></p>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-1">
                            <input type="radio" class="radio" id="status9" name="radio" value="9"></div>
                        <div class="col-sm-10">
                            <p class="pull-left no-margin"><label for="status9">Driver Reached at Drop Location</label></p>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-1">
                            <input type="radio" class="radio" id="status16" name="radio" value="16"></div>
                        <div class="col-sm-10">
                            <p class="pull-left no-margin"><label for="status16">Unloaded the Vehicle</label></p>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-1">
                            <input type="radio" class="radio" id="status10" name="radio" value="10"></div>
                        <div class="col-sm-10">
                            <p class="pull-left no-margin"><label for="status10">Trip Complete Without Fee</label></p>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-1">
                            <input type="radio" class="radio" id="status11" name="radio" value="10"></div>
                        <div class="col-sm-10">
                            <p class="pull-left no-margin"><label for="status11">Trip Complete With Fee</label></p>
                        </div> 
                    </div>
                    <div class="row trip_complete_with_charge" style="display: none;">
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-3">
                                <p class="pull-left no-margin" style="font-size: 11px;">Charge Amount</p>
                            </div> 
                            <div class="col-sm-5 input-group pos_relative">
                                <input type="text" class="form-control number" placeholder="Enter amount" id="charged_amount_for_complete" name="charged_amount_for_complete">
                                <div class="input-group-addon">
                                    <span style="color: #73879C;"><?php echo $appConfig['currencySymbol']; ?></span>
                                </div>
                            </div>
                            <div class="col-sm-2"><span style="color: red"></span></div>
                        </div>

                    </div>
                    <div class="row trip_complete_with_charge"  style="display: none;">
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-3">
                                <p class="pull-left no-margin" style="font-size: 11px;">Handling Fee</p>
                            </div> 
                            <div class="col-sm-5 input-group pos_relative">
                                <input type="text" class="form-control number" placeholder="Enter amount" id="handling_fee" name="handling_fee">
                                <div class="input-group-addon">
                                    <span style="color: #73879C;"><?php echo $appConfig['currencySymbol']; ?></span>
                                </div>
                            </div>
                            <div class="col-sm-2"><span  style="color: red"></span></div>
                        </div>

                    </div>
                    <div class="row trip_complete_with_charge" style="display: none;">
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-3">
                                <p class="pull-left no-margin" style="font-size: 11px;">Toll Fee</p>
                            </div> 
                            <div class="col-sm-5 input-group pos_relative">
                                <input type="text" class="form-control number" placeholder="Enter amount" id="toll_fee" name="toll_fee">
                                <div class="input-group-addon">
                                    <span style="color: #73879C;"><?php echo $appConfig['currencySymbol']; ?></span>
                                </div>
                            </div>
                            <div class="col-sm-2"><span id="errMsgComplete" style="color: red"></span></div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-1">
                            <input type="radio" class="radio" id="status30" name="radio" value="3"></div>
                        <div class="col-sm-10">
                            <p class="pull-left no-margin"><label for="status30">Cancel Without Fee</label></p>
                        </div> 
                    </div>

                    <div class="row cancelWithoutFeeDiv" style="display:none;">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-3">
                            <p class="pull-left no-margin" style="font-size: 11px;">On behalf of </p>
                        </div> 
                        <div class="col-sm-5">
                            <select class="form-control"  id="cancelBy" name="cancelBy">
                                <option value="">Select</option>
                                <option value="1">Customer</option>
                                <option value="2">Driver</option>
                            </select>

                        </div>
                        <div class="col-sm-2"><span id="cancelByErr" style="color: red"></span></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-1">
                            <input type="radio" class="radio" id="status31" name="radio" value="3"></div>
                        <div class="col-sm-10">
                            <p class="pull-left no-margin"><label for="status31">Cancel With Fee</label></p>
                        </div> 
                    </div>
                    <div class="row" id="trip_cancel_with_charge" style="display: none;">

                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-3">
                                <p class="pull-left no-margin" style="font-size: 11px;">Charge Amount (<?php echo $appConfig['currencySymbol']; ?>)</p>
                            </div> 
                            <div class="col-sm-5 input-group pos_relative">
                                <input type="text" class="form-control number" placeholder="Enter amount" id="charged_amount_for_cancel" name="charged_amount_for_cancel" readonly="">
                                <div class="input-group-addon">
                                    <span style="color: #73879C;"><?php echo $appConfig['currencySymbol']; ?></span>
                                </div>
                            </div>
                            <div class="col-sm-2"><span id="errMsgCancel" style="color: red"></span></div>
                        </div>

                    </div>


                    <!--                    <div class="row">
                                            <div class="col-sm-1"></div>
                                            <div class="col-sm-1">
                                                <input type="radio" class="radio" id="radio3" name="radio" value="3"></div>
                                            <div class="col-sm-10">
                                                <p class="pull-left no-margin"><label>Complete Booking Without Fee </label></p>
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-1"></div>
                                            <div class="col-sm-1">
                                                <input type="radio" class="radio" id="radio4" name="radio" value="4" ></div>
                                            <div class="col-sm-10" >
                                                <p class="pull-left no-margin"><label>Complete Booking With Fee </label></p>
                                            </div> 
                                        </div>-->

                    <!--                    <div class="row" id="charge_input_price_for_complete" style="display: none;">
                    
                                            <div class="form-group">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-4">
                                                    <p class="pull-left no-margin" style="font-size: 11px;">Charge Amount (<?php echo currency; ?>)</p></div> 
                                                <div class="col-sm-4"><input type="text" class="form-control number" placeholder="Enter an amount" id="charged_amount_for_complete" name="charged_amount_for_complete"></div>
                                                <div class="col-sm-2"><span id="errMsgComplete" style="color: red"></span></div>
                                            </div>
                    
                                        </div>-->

                    <input type="hidden" id="appId">
                    <input type="hidden" id="radioChecked">

                </div>

            </div>
            <div class="modal-footer">
                <div class="pull-left m-t-10 manageBookingErr errors"> </div>
                <div class="pull-right m-t-10"> 
                    <button class="btn btn-success  submit"  data="1">Submit</button>

                </div>
                <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>



            </div>
        </div>
    </div>
</div>





