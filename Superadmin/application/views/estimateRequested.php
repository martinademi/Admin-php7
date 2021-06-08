<style>
    .tooltip > .tooltip-inner {background-color:#50606C;}
</style>
<script>
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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_estimateRequested',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"width": "15%"},
                    {"width": "15%"},
                    null,
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
        }, 1000);

        // search box for table
        $('#search-table').keyup(function () {
            $('#start').val('');
            $('#end').val('');
            table.fnFilter($(this).val());
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
                    "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/datatable_estimateRequested/' + startDate + '/' + endDate,
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



        $(document).on('click', '.getCustomer', function ()
        {
            $('.sname').text($(this).attr('sname'));
            $('.semail').text($(this).attr('semail'));
            $('.sphone').text($(this).attr('sphone'));

            $('#getCustomerPopUP').modal('show');//Code in footer.php

        });

    });



</script>
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;

             color: gray;
             margin-left: 30px;padding-top: 20px;">


            <strong style="color:#0090d9;">ESTIMATE REQUESTED</strong>
        </div>

        <ul class="nav nav-tabs nav-tabs-simple bg-white " style="margin-top: 1%;">
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
                </div></div></div>
        <div class="container-fluid container-fixed-lg">

        </div>
    </div>

</div>

<div class="modal fade" id="getCustomerPopUP" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">CUSTOMER DETAILS</strong>
            </div>
            <div class="modal-body">
                <br>
                <div class="row">
                    <div class="col-sm-1"></div>

                    <div class="col-sm-6">
                        <div class="form-group row" style="margin-left: 7%;">
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
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

