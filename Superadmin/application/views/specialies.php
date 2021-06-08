
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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_specialies',
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



        $('#add').click(function ()
        {
            $('#addModal').modal('show');
            $('#speciality').val('');

        });

        $('#edit').click(function ()
        {
            $(".errors").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select any one row to edit");
            } else if (val.length > 1) {

                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select only one row to edit");
            } else {
                $('#edit_speciality').val($('.checkbox:checked').parent().prev().text());
                $('#editModal').modal('show');
            }
        });

        $('#insert').click(function ()
        {

            if ($('#speciality').val() == '' || $('#speciality').val() == null)
            {
                $('#specialityErr').text('Please enter speciality name');
            } else {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/addSpeciality",
                    type: "POST",
                    data: {name: $('#speciality').val()},
                    dataType: 'json',
                    success: function (result)
                    {

                        if (result.flag == 0)
                        {
                            $('.close').trigger('click');
                            var table = $('#big_table');
                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_specialies',
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
                        } else {
                            $('.ResponseErr').text(result.msg);
                        }

                    }
                });
            }
        });
        $('#update').click(function ()
        {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if ($('#edit_speciality').val() == '' || $('#edit_speciality').val() == null)
            {
                $('#edit_specialityErr').text('Please enter speciality name');
            } else {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/updateSpeciality",
                    type: "POST",
                    data: {name: $('#edit_speciality').val(), id: val},
                    dataType: 'json',
                    success: function (result)
                    {

                        $('.close').trigger('click');
                        var table = $('#big_table');
                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_specialies',
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

                    }
                });
            }
        });

        $('#checkdel').click(function ()
        {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select any one row to delete");
            } else {

                $('#deleteModal').modal('show');
            }
        });

        $('#delete').click(function ()
        {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/deleteSpeciality",
                type: "POST",
                data: {id: val},
                dataType: 'json',
                success: function (result)
                {
                    $(".close").trigger('click');
                    $('.checkbox:checked').each(function (i) {
                        $(this).closest('tr').remove();
                    });
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

            <strong style="color:#0090d9;">GOOD TYPES</strong>
        </div>

        <div class="">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent ">
                    <ul class="nav nav-tabs nav-tabs-fillup bg-white" style="padding: 0.5%;">
                        <div class="pull-right m-t-10 cls111" style="margin-right: 1%;"> <button class="btn btn-danger " id="checkdel"><?php echo BUTTON_DELETE; ?></button></a></div>
                        <div class="pull-right m-t-10 cls111"><button class="btn btn-info " id="edit"><?php echo BUTTON_EDIT; ?></button></div>
                        <div  class="pull-right m-t-10 cls110"><button class="btn btn-primary " id="add"><?php echo BUTTON_ADD; ?></button></div>
                    </ul>

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


                                    <div class="row clearfix pull-right" >
                                        <div class="col-sm-12">
                                            <div class="searchbtn" >

                                                <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?> "> </div>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                                &nbsp;
                                <div class="panel-body">

                                    <?php echo $this->table->generate(); ?>

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


<div class="modal fade stick-up in" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <span class="modal-title">ADD</span>

            </div>

            <div class="modal-body">
                <form action="" method="post" data-parsley-validate="" class="form-horizontal form-label-left">

                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">Speciality<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="speciality" name="speciality" class="form-control error-box-class" placeholder="Enter Speciality Name">

                        </div>
                        <div class="col-sm-3 error-box errors" id="specialityErr">

                        </div>

                    </div>
                </form>


            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box ResponseErr errors"></div>
                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="insert">Add </button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up in" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <span class="modal-title">EDIT</span>

            </div>

            <div class="modal-body">
                <form action="" method="post" data-parsley-validate="" class="form-horizontal form-label-left">

                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label">Speciality<span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="edit_speciality" name="edit_speciality" class="form-control error-box-class" placeholder="Enter Speciality Name">

                        </div>
                        <div class="col-sm-3 error-box errors" id="edit_specialityErr">

                        </div>

                    </div>
                </form>


            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box " id=""></div>
                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="update">Update</button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" >DELETE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="text-align:center">Do want to delete speciality</div>

                </div>
            </div>


            <div class="modal-footer">

                <div class="col-sm-4" ></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="delete" >Delete</button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div> 
