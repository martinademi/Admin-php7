<style>
    .color1{
        font-weight: 600;
        color: #47235a;
    }
</style>
<script type="text/javascript">

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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/appVersions/datatable_showAllUsersAppVersion/<?php echo $appversion; ?>/<?php echo $tab; ?>',
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
                    });
</script>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;">

            <strong class="active">USERS LIST</strong>
        </div>
        <br>
        <ul class="nav nav-tabs  bg-white">
            <div class="row">

                <div class="col-md-4 color1">
                    <div class="col-md-3">
                        <label>App Version</label>
                    </div>
                    <div class="col-md-2">: <?php echo $appversion; ?></div>
                    
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-2"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search"> </div>
                
            </div>
            <div class="row">

                <div class="col-md-4 color1">
                    <div class="col-md-3">
                        <label>Platform</label>
                    </div>
                    <div class="col-md-9">: <?php echo unserialize(Platform)[$tab] ?></div>

                </div>
            </div>
            <div class="row">

                <div class="col-md-4 color1">
                    <div class="col-md-3">
                        <label>App Type</label>
                    </div>
                    <div class="col-md-9">: <?php echo unserialize(AppType)[$tab]; ?></div>

                </div>
            </div>

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