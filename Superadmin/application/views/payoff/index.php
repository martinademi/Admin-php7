<link href="application/views/wallet/styles.css" rel="stylesheet" type="text/css">
<style>
    label.error{
        color: red;
    }
    .form-group.required .control-label:after{
        content: " *";
        color: red;
    }
    .select2-container{
        width: 100% !important;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#big_table');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/payoff/datatable_payoff/',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "ordering": false,
            "drawCallback": function () {
                $('#big_table').show();
                $('.cs-loader').hide();
            },
            "iDisplayStart ": 20,
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
                $('#big_table').show();
                $('.cs-loader').hide();
            },
            'fnServerData': function (sSource, aoData, fnCallback)
            {
                // csrf protection
             aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
                $.ajax({
                    'dataType': 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback
                });
            },
            "aoColumns": [
                {"sWidth": "1%", 'sClass': 'text-center'},
                {"sWidth": "5%"},
             
                {"sWidth": "2%", 'sClass': 'text-center'},
                {"sWidth": "2%", 'sClass': 'text-center'}
            ]
        };
        table.dataTable(settings);

        // search box for table
        $('#search-table').keyup(function () {
            $('.cs-loader').show();
            table.fnFilter($(this).val());
        });
    });
</script>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <ul class="breadcrumb">
            <li>
                <a href="#" class="active">PAYOFF</a>
            </li>
        </ul>
        <div class="row">
            <ul class="nav nav-tabs nav-tabs-fillup bg-white">
                <li id="1" class="tabs_active active">
                    <a class="changeMode" data-id="1">
                        <span>PAYOFF</span>
                    </a>
                </li>
            </ul>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-transparent ">
                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <div class="col-sm-8">
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
                                <div class="col-sm-4" style="padding:15px;">
                                    <div class="pull-right">
                                        <input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo $this->lang->line('search'); ?>"/> 
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" style="padding: 0px; margin-top: 2%;">
                                <?php echo $this->table->generate(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PANEL -->
        </div>
    </div>
</div>