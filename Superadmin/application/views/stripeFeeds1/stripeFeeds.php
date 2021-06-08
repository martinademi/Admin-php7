<style>
    .color1{
        font-weight: 600;
        color: #47235a;
    }
</style>
<script type="text/javascript">
    var html;
    var stDate = '';
    var edDate = '';
    $(document).ready(function () {
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


        var table = $('#big_table');

        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        $('.hide_show').hide();
        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo APILink ?>logs/stripe',
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
                    // csrf protection
                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
                    aoData.push({name: 'startDate', value: stDate});
                    aoData.push({name: 'endDate', value: edDate});
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback
                            });
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    
                    if(typeof(aData.bid) != "undefined")
                    {
                        html = "<a style='cursor: pointer;' href='<?php echo base_url() ?>index.php?/superadmin/tripDetails/" + aData.bid + "' target='_blank'>" + aData.bid + "</a>";
                        $('td:eq(0)', nRow).html(html);
                    }else
                         $('td:eq(0)', nRow).html('N/A');
                     
                      if(typeof(aData.cardType) != "undefined")
                          $('td:eq(7)', nRow).html(aData.cardType);
                      else
                          $('td:eq(7)', nRow).html('N/A');
                      
                      if(typeof(aData.card) != "undefined")
                          $('td:eq(8)', nRow).html(aData.card);
                      else
                      {
                          $('td:eq(8)', nRow).html('N/A');
                      }

                    html = moment(aData.chargeDate * 1000).format("DD-MM-YYYY hh:mm:ss");
                    $('td:eq(1)', nRow).html(html);
                },
                "aoColumns": [
                    {"mData": "name"},
                    {"mData": "chargeDate"},
                    {"mData": "customerId"},
                    {"mData": "name"},
                    {"mData": "phone"},
                    {"mData": "chargeId"},
                    {"mData": "amount"},
                    {"mData": "name"},
                    {"mData": "name"},
                    {"mData": "status",
                        "bSortable": false}
                ]

            };

            table.dataTable(settings);
        }, 1000);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('#searchData').click(function () {
            if ($("#start").val() && $("#end").val())
            {

                var st = $("#start").datepicker().val();
                var startDate = st.split("/")[2] + '.' + st.split("/")[0] + '.' + st.split("/")[1];
                stDate = parseInt((new Date(startDate).getTime() / 1000).toFixed(0));

                var end = $("#end").datepicker().val();
                var endDate = end.split("/")[2] + '.' + end.split("/")[0] + '.' + end.split("/")[1];
                edDate = parseInt((new Date(endDate).getTime() / 1000).toFixed(0));

                var table = $('#big_table');

                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": '<?php echo APILink ?>admin/stripecharges',
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

                        // csrf protection
//                        aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
                        aoData.push({name: 'startDate', value: stDate});
                        aoData.push({name: 'endDate', value: edDate});
                        $.ajax
                                ({
                                    'dataType': 'json',
                                    'type': 'POST',
                                    'url': sSource,
                                    'data': aoData,
                                    'success': fnCallback
                                });
                    },
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    
                    if(typeof(aData.bid) != "undefined")
                    {
                        html = "<a style='cursor: pointer;' href='<?php echo base_url() ?>index.php?/superadmin/tripDetails/" + aData.bid + "' target='_blank'>" + aData.bid + "</a>";
                        $('td:eq(0)', nRow).html(html);
                    }else
                         $('td:eq(0)', nRow).html('N/A');
                     
                      if(typeof(aData.cardType) != "undefined")
                          $('td:eq(7)', nRow).html(aData.cardType);
                      else
                          $('td:eq(7)', nRow).html('N/A');
                      
                      if(typeof(aData.card) != "undefined")
                          $('td:eq(8)', nRow).html(aData.card);
                      else
                      {
                          $('td:eq(8)', nRow).html('N/A');
                      }

                    html = moment(aData.chargeDate * 1000).format("DD-MM-YYYY hh:mm:ss");
                    $('td:eq(1)', nRow).html(html);
                },
                "aoColumns": [
                    {"mData": "name"},
                    {"mData": "chargeDate"},
                    {"mData": "customerId"},
                    {"mData": "name"},
                    {"mData": "phone"},
                    {"mData": "chargeId"},
                    {"mData": "amount"},
                    {"mData": "name"},
                    {"mData": "name"},
                    {"mData": "status",
                        "bSortable": false}
                ]

                };

                table.dataTable(settings);


            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_DEACTIVAT_DATEOFBOOKING); ?>);

            }

        });
    });
</script>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <ul class="breadcrumb" style="margin-top: 5%;">

            <li>
                <a href="#" class="active">STRIPE FEEDS</a>
            </li>

        </ul>


        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

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

                                </div>
                                <div class="col-sm-3 hide_show">
                                    <div class="" aria-required="true">

                                        <div class="input-daterange input-group">
                                            <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">

                                        </div>

                                    </div>

                                </div>
                                <div class="col-sm-1 hide_show">
                                    <div class="">
                                        <button class="btn btn-primary" type="button" id="searchData">Search</button>
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

                            <div class="panel-body" style="margin-top: 1%;">

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