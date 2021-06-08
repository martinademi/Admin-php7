<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js"></script>
<style>
    .tooltip > .tooltip-inner {background-color:#50606C;}
</style>

<style>
    .select2-results {
        max-height: 192px;
    }

</style>
<script src="<?php echo base_url() ?>mqttws.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>webSocket.js" type="text/javascript"></script>
<script>

//            var socket = io('<?php echo API_LINK; ?>');
//            socket.on('bookingChn', function (data) {
//                console.log(data);
//            });



    $(document).ready(function () {

        client.onMessageArrived = function (message) {
//               console.log("Msg",message);
            var topicName = message.destinationName;
            $('#search-table').trigger('keyup');
            console.log(topicName);
//            var topic = topicName.split("/");
////            console.log(topic);
//            console.log(topic[1]);
//            if (topicName == 'adminOrderUpdates')
//            {
//                console.log('message', message);
//                console.log('message.destinationName', message.destinationName);
//                console.log('message.payloadString', message.payloadString);
//                $('#big_table').find('tr:first').find('th:first').trigger('click');
//                $('#search-table').trigger('keyup');
//            }
        };
    });

    var arrayD = [];
    var JobStatus = <?= json_encode(unserialize(JobStatus)); ?>;
    var Diveid = 0;


    var zoneAndPickupAddr;
    var zoneAndDropAddr;
    var bookingType;
    $(document).ready(function () {
        $(document).on('click', '.showEstimatedFareDetials', function ()
        {
            $('.estimatedFare').text('');
            $('.estimatedTime').text('');
            $('.estimatedFare').text('<?php echo $appConfig['currencySymbol'] ?> ' + $(this).attr('estimatefare'));
            $('.estimatedTime').text($(this).attr('estimatedTime') + ' Minutes');
            $('#showEstimatedFareDetails').modal('show');//Code in footer.php

        });



    });


</script>



<script>

    $(document).ready(function () {

        $('.exportclick').click(function () {

            if ($('#start').val() != '' || $('#end').val() != '') {

                var dateObject = $("#start").datepicker("getDate"); // get the date object
                var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
                var dateObject = $("#end").datepicker("getDate"); // get the date object
                var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
                $('#exportformdate').attr('href', '<?php echo base_url() ?>index.php?/superadmin/allBookingsDataExport/' + st + '/' + end);
                $('#exportformdate')[0].click();
            } else {

                $('#exportformdate').attr('href', '<?php echo base_url() ?>index.php?/superadmin/allBookingsDataExport');
                $('#exportformdate')[0].click();
            }
        });


        $('#clearData').click(function ()
        {
            $('#start').val('');
            $('#end').val('');
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
                    "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/bookings_data_ajax/' + $('#Sortby').val() + '/' + startDate + '/' + endDate,
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

        $('#search_by_select').change(function () {

            $('#atag').attr('href', '<?php echo base_url() ?>index.php?/superadmin/search_by_select/' + $('#search_by_select').val());

            $("#callone").trigger("click");
        });


    });
</script>

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
                "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/bookings_data_ajax',
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
            $('#start').val('');
            $('#end').val('');
            table.fnFilter($(this).val());
        });



        $('#Sortby').change(function () {

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
                "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/bookings_data_ajax/' + $(this).val() + '/' + startDate + '/' + endDate,
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


    function pageReloadData()
    {
        var table = $('#big_table');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
//            "sPaginationType": "bootstrap",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/bookings_data_ajax',
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
        <div class="content"style="padding-top: 3px">
            <div class="brand inline" style="  width: auto;            
                 color: gray;
                 margin-left: 30px;">
               <!--                    <img src="--><?php //echo base_url();                  ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();                  ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();                  ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

                <strong style="color:#0090d9;">ALL ORDERS</strong><!-- id="define_page"-->
            </div>

            <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">
                <div class="hide_show" style="display:none;">

                    <div class="form-group">

                        <div class="col-sm-8" style="width: auto;
                             paddingng: 0px;
                             margin-bottom: 10px;margin-left:0.5%;" >
                            <select  class="form-control" id="Sortby" style="background-color:gainsboro;height:30px;font-size:12px;">
                                <option value="20" selected> ALL</option>
                                <option value="11" >No Drivers Assigned</option>
                                <option value="6" >Booking accepted By Driver</option>
                                <option value="6" >Driver on the way</option>
                                <option value="7" >Driver Arrived at Pickup Point</option>
                                <option value="8" >Trip Started</option>
                                <option value="9" >Driver Reached at Drop Location</option>
                                <option value="16" >Unloaded</option>
                                <option value="10" >Trip Completed</option>
                                <option value="10" >Invoice raised</option>
                                <option value="4" >Booking Cancelled by driver</option>
                                <option value="3">Booking Cancelled by Customer before driver assigned</option>
                                <option value="3">Booking Cancelled by Customer after driver assigned with fee</option>
                                <option value="3" >Booking Cancelled by Customer after driver assinged without fee</option>

                            </select>
                        </div>
                    </div>
                </div>
            </ul>
            <!-- START JUMBOTRON -->
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


                                        <div class="col-sm-4 hide_show" style="margin-left:-1%;">
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

                                        <div class="pull-right hide_show"  style="display:none;"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search"> </div>


                                    </div>
                                    <div class="panel-body">
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




