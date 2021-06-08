<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        setTimeout(function () {
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_googleKey',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    table.show()
                    $('.cs-loader').hide()
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
            table.fnFilter($(this).val());
        });
    });
</script>


<script>
    $(document).ready(function () {
        $(document).on('click', '.deleteOne', function () {
            $('#editId').val($(this).attr('data-id'))
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/addEditGoogleKey/delete",
                type: 'POST',
                data: {
                    'index': $(this).attr('data-index'),
                    'id': $(this).attr('data-id')
                },
                dataType: 'JSON',
                success: function (response)
                {
                    $(".close").trigger('click');
                    var table = $('#big_table');
                    var settings = {
                        "autoWidth": false,
                        "sDom": "<'table-responsive't><'row'<p i>>",
                        "destroy": true,
                        "scrollCollapse": true,
                        "iDisplayLength": 20,
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_googleKey',
                        "bJQueryUI": true,
                        "sPaginationType": "full_numbers",
                        "iDisplayStart ": 20,
                        "oLanguage": {

                        },
                        "fnInitComplete": function () {
                            //oTable.fnAdjustColumnSizing();
                            $('#big_table_processing').hide();
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
            });
        })
        $("#updateKeys").click(function () {

            $('.errors').text('');
            var key = $("#editkey").val();
            var distance = $("#editdistance").val();
            var direction = $("#editdirection").val();
            var places = $("#editplace").val();
            var billingAccountId = $("#editbillingAccountId").val();
            if (key == "")
            {

                $("#key_Error").text("key is required");
            } else if (billingAccountId == "")
            {

                $("#editbillingAccountId_Error").text("Billing account id is required");
            }else if (direction == "" || direction == 0)
            {

                $("#direction_Error").text("Direction should be not empty or zero.");
            } else if (places == "" || places == 0)
            {

                $("#place_Error").text("Places should be not empty or zero.");
            } else if (distance == "" || distance == 0)
            {

                $("#distance_Error").text("Distance should be not empty or zero.");
            } else
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/addEditGoogleKey/edit",
                    type: 'POST',
                    data: {
                        key: key,
                        distance: distance,
                        direction: direction,
                        places: places,
                        billingAccountId:billingAccountId,
                        id: $("#editId").val()
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                        $("#typename").val('');
                        $(".close").trigger('click');
                        var table = $('#big_table');
                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_googleKey',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {

                            },
                            "fnInitComplete": function () {
                                //oTable.fnAdjustColumnSizing();
                                $('#big_table_processing').hide();
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
                });
            }
        });
        $("#add").click(function () {
            $('#addGoogleKey').modal('show');
        })


        $(document).on('click', '.editKey', function () {
            $('#editId').val($(this).attr('data-id'))
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin/fetchKeyDetails') ?>/" + $(this).attr('data-id'),
                type: 'POST',
                dataType: 'JSON',
                success: function (response)
                {
                    $('#editkey').val(response.data.currentKey)
                    $('#editdistance').val(response.data.totalDistanceLimit)
                    $('#editplace').val(response.data.totalPlacesLimit)
                    $('#editdirection').val(response.data.totalDirectionLimit)
                    $('#editbillingAccountId').val(response.data.billingAccountId)
                }
            });
            $('#editGoogleKey').modal('show');
        })
        $("#inserts").click(function () {
            $(".errors").text("");
            var key = $("#key").val();
            var distance = $("#distance").val();
            var direction = $("#direction").val();
            var places = $("#place").val();
            var billingAccountId = $("#billingAccountId").val();
            if (key == "")
            {

                $("#key_Error").text("key is required");
            } 
            else if (billingAccountId == "")
            {

                $("#billingAccountId_Error").text("Billing account id is required");
            } else if (direction == "" || direction == 0)
            {

                $("#direction_Error").text("Direction should be not empty or zero.");
            } else if (places == "" || places == 0)
            {

                $("#place_Error").text("Places should be not empty or zero.");
            } else if (distance == "" || distance == 0)
            {

                $("#distance_Error").text("Distance should be not empty or zero.");
            } else
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/addEditGoogleKey/insert",
                    type: 'POST',
                    data: {
                        key: key,
                        distance: distance,
                        direction: direction,
                        places: places,
                        billingAccountId:billingAccountId
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {

                        if (response.msg == 1)
                        {
                            $('#keysAdd').trigger("reset");
                            $(".close").trigger('click');
                            var table = $('#big_table');
                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_googleKey',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {

                                },
                                "fnInitComplete": function () {
                                    //oTable.fnAdjustColumnSizing();
                                    $('#big_table_processing').hide();
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
                            $('.responseErr1').text(response.msg);
                        }
                    }
                });
            }

        });
    }
    );

</script>


<div class="page-content-wrapper"style="">
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb" style="margin-left: 0px; margin-top: 5%;">
            <li><a href="<?php echo base_url(); ?>index.php?/superadmin/app_config" class="">App Configration</a></li>
        <li style="width: 100px"><a href="#" class="active">Google key</a></li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
            <strong>Google key</strong>
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">


                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  bg-white whenclicked">
                        <div style="margin-top:20px"class="pull-right m-t-10 cls110"> <button class="btn btn-primary btn-cons" id="add">Add</button></div>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
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

                                    <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search "> </div>

                                </div>
                                &nbsp;
                                <div class="panel-body">
                                    <?php echo $this->table->generate(); ?>
                                </div>
                            </div>
                            <!--                             END PANEL -->
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>
<div class="modal fade stick-up" id="addGoogleKey" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >ADD</span> 
            </div>
            <div class="modal-body">
                <form action="" method="post" id="keysAdd" data-parsley-validate="" class="form-horizontal form-label-left">
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Key<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text"  id="key" name="key"  class="form-control" placeholder="please enter google api key." required = "required">
                        </div>
                        <div class="col-sm-3 error-box errors" id="key_Error">
                        </div>
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Direction Quota<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number"  id="direction" name="direction"  class="form-control" placeholder="" required = "required">
                        </div>
                        <div class="col-sm-3 error-box errors" id="direction_Error">
                        </div>
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Places Quota<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number"  id="place" name="place"  class="form-control" placeholder=""required = "required">
                        </div>
                        <div class="col-sm-3 error-box errors" id="place_Error">
                        </div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Distance Quota<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number"  id="distance" name="distance"  class="form-control" placeholder=""required = "required">
                        </div>
                        <div class="col-sm-3 error-box errors" id="distance_Error">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">Billing Account Id<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="billingAccountId" name="billingAccountId" class="form-control" placeholder="please enter billing account id." required="required">
                        </div>
                        <div class="col-sm-3 error-box errors" id="billingAccountId_Error">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box errors" id="inserts-data" ></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"><button type="button" class="btn btn-success pull-right" id="inserts" >Add</button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="editGoogleKey" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >Edit</span> 
            </div>
            <div class="modal-body">
                <form action="" method="post" id="keysAdd" data-parsley-validate="" class="form-horizontal form-label-left">
                    <input type="hidden" id="editId" value="">
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Key<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text"  id="editkey" name="editkey"  class="form-control" placeholder="please enter google api key." required = "required">
                        </div>
                        <div class="col-sm-3 error-box errors" id="key_Error">
                        </div>
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Direction Quota<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number"  id="editdirection" name="editdirection"  class="form-control" placeholder="" required = "required">
                        </div>
                        <div class="col-sm-3 error-box errors" id="direction_Error">
                        </div>
                    </div>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Places Quota<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number"  id="editplace" name="editplace"  class="form-control" placeholder=""required = "required">
                        </div>
                        <div class="col-sm-3 error-box errors" id="place_Error">
                        </div>
                    </div>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label">Distance Quota<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number"  id="editdistance" name="editdistance"  class="form-control" placeholder=""required = "required">
                        </div>
                        <div class="col-sm-3 error-box errors" id="distance_Error">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">Billing Account Id<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="editbillingAccountId" name="editbillingAccountId" class="form-control" placeholder="please enter billing account id." required="required">
                        </div>
                        <div class="col-sm-3 error-box errors" id="editbillingAccountId_Error">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box errors" id="inserts-data" ></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"><button type="button" class="btn btn-success pull-right" id="updateKeys" >Update</button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>









