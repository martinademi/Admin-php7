<script src="<?php echo base_url(); ?>pubnub.js"></script>

<script>
    var arrayD = [];
    var Diveid = 0;
    var slaveChannel;
    var tabURL;
    var zoneAndPickupAddr;
    var zoneAndDropAddr;
    $(document).ready(function () {

        var table = $('#big_table');
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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_expiredBookings',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "columns": [
                    null,
                    null,
                    null,
                    
                    null,
                    null,
                    {"width": "14%"},
                    {"width": "14%"},
                    null,
                    null
                ],
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    $('.cs-loader').hide();
                    table.show()
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

        }, 500);


        // search box for table
        $('#search-table').keyup(function () {

            table.fnFilter($(this).val());
        });




        var JobStatus = <?= json_encode(unserialize(JobStatus)); ?>;
        var Diveid = 0;
        var pubnub = PUBNUB.init({
            publish_key: '<?php echo $appConfig['pubnubkeys']['publishKey']; ?>',
            subscribe_key: '<?php echo $appConfig['pubnubkeys']['subscribeKey']; ?>',
            ssl: true,
            jsonp: false
        });

        $(document).ready(function () {

            pubnub.subscribe({
                channel: "<?php echo channel; ?>",
                message: function (m) {
                    console.log(m)

                    //Pop up Notfication Alert at the right side of page
//                   $.bootstrapGrowl('BID: '+m.bid +'<br>'+'Status: '+JobStatus[m.st],{
//                            type: 'info',
//                            delay: 5000,
//                        });

//                    tabURL = $('li.active').children("a").attr('data');



                    if (m.status == '11')
                    {
                        zoneAndPickupAddr = '';
                        zoneAndPickupAddr = '';

                        $.ajax({
                            type: 'post',
                            url: '<?php echo base_url('index.php?/superadmin/get_appointment_details') ?>',
                            data: {order_id: m.bid},
                            dataType: 'json',
                            success: function (result) {
//                    
                                var table = $('#big_table').DataTable();
                                var data = result.shipmentData;//getting booking data

                                if (data.pickupzoneId == '' || data.pickupzoneId == '0' || data.dorpzoneId == '' || data.dorpzoneId == '0')
                                    zoneType = data.pricingModel + '-OZ';
                                else
                                    zoneType = (data.zoneType == '1') ? data.pricingModel + '-LH' : data.pricingModel + '-SH';

                                if (result.pickUpZone != '')
                                    zoneAndPickupAddr = '(Zone-' + result.pickUpZone + ') ' + data.address_line1;
                                else
                                    zoneAndPickupAddr = '(Zone-Out Zone) ' + data.address_line1;

                                if (result.dropZone != '')
                                    zoneAndDropAddr = '(Zone-' + result.dropZone + ') ' + data.address_line1;
                                else
                                    zoneAndDropAddr = '(Zone-Out Zone) ' + data.address_line1;

                                var rownod = table.row.add([
                                    '<a style="cursor: pointer;" id="' + data.order_id + '"  class="getDriverHistory" bid="' + data.order_id + '">' + data.order_id + '</a>',
                                    '<a style="cursor: pointer;" class="getCustomerDetails" slave="' + data.slave_id.$oid + '">' + data.slaveName + '</a>',
                                    data.slaveCountryCode + data.slavemobile,
                                    moment(data.createdDt * 1000).format("DD-MM-YYYY"),
                                    (data.appt_type == '1') ? 'Now' : 'Later',
                                    '',
                                    zoneAndPickupAddr,
                                    zoneAndDropAddr,
                                    '<a target="_blank" id="attemptCount'+data.order_id+'" href="<?php echo base_url() . 'index.php?/superadmin/bookingDispatchedList/'; ?>' + data.order_id + '">'+data.attemptCount+'</a>',
                                    data.pricingModel
                                ]).order([[0, 'desc']])
                                        .draw().node();

                            }
                        });


                    } 
                }
            });

        });
    });

</script>
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;

             color: gray;
             margin-left: 30px;padding-top: 20px;">


            <strong style="color:#0090d9;">EXPIRED BOOKINGS</strong>
        </div>

        <ul class="nav nav-tabs nav-tabs-simple bg-white ">

            <div class="pull-right" style="margin-right: 1.3%;"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>" area-controls="big_table"> </div>


        </ul>


        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent ">


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



                            </div>
                            &nbsp;
                            <div class="panel-body">

                                <?php
                                echo $this->table->generate();
//                                     
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


