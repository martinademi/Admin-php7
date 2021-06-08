<style>
    .color1{
        font-weight: 600;
        color: #47235a;
    }
    /*Device logs*/
    .pushTokenShortShow{
        display:inline-block;
        width:180px;
        white-space: nowrap;
        overflow:hidden !important;
        text-overflow: ellipsis;
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
                                    // csrf protection
                                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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

                        $(document).on('click', '.deviceLogs', function ()
                        {
                            $('#device_log_data').empty();
                            $.ajax({
                                url: '<?php echo APILink; ?>app/versions/<?php echo $tab; ?>/<?php echo $appversion; ?>/' + $(this).attr('mas_id'),
                                type: "GET",
//                                data: {mas_id: $(this).attr('mas_id')},
                                dataType: 'json',
                                success: function (result)
                                {


                                    console.log(result);
                                    var html = '';
                                    var deviceType = '';
//                                    $('#d_name_history').text(result.data.firstName + ' ' + result.data.lastName)
                                    $.each(result.data, function (index, logs) {
                                        html = "<tr>";
                                        html += "<td>" + logs.make + "</td>";
                                        html += "<td>" + logs.model + "</td>";
                                        html += "<td>" + logs.deviceId + "</td>";
                                        html += "<td>" + moment(logs.lastLogin).format("DD-MM-YYYY HH:mm:ss") + "</td>";

                                        html += "</tr>";
                                        $('#device_log_data').append(html);

                                    });


                                }
                            });

                            $('#deviceLogPopUp').modal('show');

                        });
                    });
</script>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <ul class="breadcrumb" style="margin-top: 5%;">

            <li>
                <a href="<?php echo base_url() ?>index.php?/appVersions/appVersions/<?php echo $tab; ?>" class="active"><?php echo unserialize(Platform)[$tab]; ?></a>
            </li>
            <li>
                <a href="#" class="active"><?php echo $appversion; ?></a>
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

<div class="modal fade stick-up" id="deviceLogPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">DEVICE INFO</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body form-horizontal">
                <!--                <div class="row">
                                    <span style="color:#738092;font-weight:700;margin-left: 10px;"> Username : <span id="d_name_history" style="color:#1ABB9C;"></span></span>
                                </div>-->
                <!--<br>-->
                <div class="table-responsive">
                    <table class='table table-striped table-bordered table-hover demo-table-search' id="devices_datatable">
                        <thead>
                        <th style="">DEVICE MAKE</th>
                        <th style="">DEVICE MODEL</th>
                        <th style="">DEVICE ID</th>
                        <th style="">LAST LOGGED IN DATE</th>
                        </thead>


                        <tbody id="device_log_data">

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>