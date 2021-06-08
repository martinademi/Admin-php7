
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
                "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/datatablePaymentCycle',
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
        <div class="brand inline" style="  width: auto;">
            <strong >PAYMENT CYCLE</strong>
        </div>
        <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">
            <div style="margin-left:1.5%;" style="display:none;" class="hide_show">
                <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">

                </div>
            </div>
        </ul>
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12">
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
                                <div>

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
</div>
