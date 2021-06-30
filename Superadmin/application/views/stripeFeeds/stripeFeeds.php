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
            

             var st = $("#start").datepicker().val();
                var startDate = st.split("/")[2] + '-' + st.split("/")[0] + '-' + st.split("/")[1];
                var end = $("#end").datepicker().val();
                var endDate = end.split("/")[2] + '-' + end.split("/")[0] + '-' + end.split("/")[1];
                if (st == "")
                {
                    startDate = "0";
                    endDate = "0";
                }
                var cid = $("#city_id").val();
                var table = $('#big_table');
                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": '<?php echo base_url(); ?>index.php?/Stripefeeds/datatable_stripeFeeds/'+ startDate + '/' + endDate,
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


        $('#datepicker-component').on('changeDate', function () {

            $('.datepicker').hide();
        });





          table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();



        setTimeout(function () {
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>index.php?/Stripefeeds/datatable_stripeFeeds/0/0',
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

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });


        $('#searchData').click(function () {
            if ($("#start").val() && $("#end").val())
            {
                var st = $("#start").datepicker().val();
                var startDate = st.split("/")[2] + '-' + st.split("/")[0] + '-' + st.split("/")[1];
                var end = $("#end").datepicker().val();
                var endDate = end.split("/")[2] + '-' + end.split("/")[0] + '-' + end.split("/")[1];
                if (st == "")
                {
                    startDate = "0";
                    endDate = "0";
                }
                var cid = $("#city_id").val();
                var table = $('#big_table');
                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": '<?php echo base_url(); ?>index.php?/Stripefeeds/datatable_stripeFeeds/'+ startDate + '/' + endDate,
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

   
    });
</script>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <ul class="breadcrumb" style="margin-top: 5%;">

            <li>
                <a href="#" class="active"><?php echo $this->lang->line('CASH_FREE_LOGS'); ?></a>
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

                                <div class="col-sm-1 hide_show">
                                    <div class="">
                                    <button  style="width:94px;" class="btn btn-info" type="button" id="clearData">Clear</button>

                                      
                                    </div>
                                </div>


                                  
                                <div class="row clearfix pull-right" >
                                    <div class="col-sm-12">
                                        <div class="searchbtn" >

                                            <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>
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