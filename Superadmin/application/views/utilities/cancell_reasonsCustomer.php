

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
                "processing": true,
                "serverSide": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/utilities/datatable_canreasonCustomer',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
//                  $('#big_table_processing').hide();
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
            table.fnFilter($(this).val());
        });

        $('#add').click(function () {
            $('.addReasons').val("");
            $('#addReasonsError').val("");
            $('#modalSlideUpSmall').modal('show');

        });
        $('#btnadd').click(function () {

            var reasons = [];
            $('.addReasons').each(function () {
                reasons.push($(this).val());
            });
            if (reasons == '' || reasons == null) {
                $('#addReasonsError').text('please enter the reason');
            } else {
                var reason = "Passenger";
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/utilities/cancell_act",
                    type: "POST",
//                    data: {reasons: $('.addReasons').val(), res_for: reason},
                    data: {reasons: reasons, res_for: reason},
                    dataType: "JSON",
                    success: function (result) {
                        if (result.msg == '1') {
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
                                    "processing": true,
                                    "serverSide": true,
                                    "scrollCollapse": true,
                                    "iDisplayLength": 20,
                                    "bProcessing": true,
                                    "bServerSide": true,
                                    "sAjaxSource": '<?php echo base_url() ?>index.php?/utilities/datatable_canreasonCustomer',
                                    "bJQueryUI": true,
                                    "sPaginationType": "full_numbers",
                                    "iDisplayStart ": 20,
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
                            $('#modalSlideUpSmall').modal('hide');

                        } else {
                            alert('Problem occurred please try agin.');
                        }
                    }
                });
            }
        });

        $('#delete').click(function () {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $("#generalPopup").modal("show");
            } else if (val.length > 0) {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#modalSlideUpSmallone');
                if (size == "mini") {
                    $('#modalSlideUpSmallone').modal('show')
                } else {
                    $('#modalSlideUpSmallone').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    } else {
                        $('#btndelete').click(function () {
                            $.ajax({
                                url: "<?php echo base_url() ?>index.php?/utilities/cancell_act/del",
                                type: "POST",
                                data: {id: val},
                                dataType: "JSON",
                                success: function (result) {
                                    if (result.msg == '1') {
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
                                                "processing": true,
                                                "serverSide": true,
                                                "scrollCollapse": true,
                                                "iDisplayLength": 20,
                                                "bProcessing": true,
                                                "bServerSide": true,
                                                "sAjaxSource": '<?php echo base_url() ?>index.php?/utilities/datatable_canreasonCustomer',
                                                "bJQueryUI": true,
                                                "sPaginationType": "full_numbers",
                                                "iDisplayStart ": 20,
                                                "oLanguage": {
                                                },
                                                "fnInitComplete": function () {
                                                    //oTable.fnAdjustColumnSizing();
                                                    //                  $('#big_table_processing').hide();
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
                                        $('#modalSlideUpSmall').modal('hide');

                                    } else {
                                        alert('Problem occurred please try agin.');
                                    }
                                    $('#modalSlideUpSmallone').modal('hide');

                                }
                            });

                        });

                    }
                }
            }



        });


        $('#edit').click(function () {
            $('#errorboxEdit').val(" ");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $("#generalPopup").modal("show");
            } else if (val.length > 0) {
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/utilities/getCanData",
                    type: "POST",
                    data: {id: val},
                    dataType: "JSON",
                    success: function (result) {
                        $('.editReasons').attr('edit_id', result.data.res_id);
                        $.each(result.data.reasons, function (index, value) {
                            $('#editReasons').val(value)
                        })
                    }
                });

                $('#editmodal').modal('show')

            }

        });
        $('#btnedit').click(function () {

            if ($('#editReasons').val() == '') {
                $('.errorboxEdit').val("Please enter the reason");
//                    alert('Please enter the reason');
            }
            var reason = "Passenger";
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/utilities/cancell_act",
                type: "POST",
                data: {reasons: $('#editReasons').val(), res_for: reason, edit_id: $('#btnedit').attr('edit_id'), id: $('#btnedit').attr('data-id')},
                dataType: "JSON",
                success: function (result) {
                    if (result.msg == '1') {
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
                                "processing": true,
                                "serverSide": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/utilities/datatable_canreasonCustomer',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
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
                        $('#editmodal').modal('hide');

                    } else {
                        alert('Problem occurred please try agin.');
                    }
                }
            });
        });


    });
</script>

<style>
    .exportOptions{
        display: none;
    }
    .btn {
        border-radius: 25px !important;
    }
</style>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
            <strong>CANCELLATION REASONS FOR CUSTOMER</strong>

        </div>

        <div class="row">
            <ul class="nav nav-tabs nav-tabs-fillup  new_class bg-white" style="margin: 1% 0.8%;padding: 0.5% 2% 0% 1%">
                <div class="pull-right m-t-10 cls111"><button  class="btn btn-danger" id="delete"> 
                        Delete</button></div>

                <div class="pull-right m-t-10 cls111"><button data-toggle="modal"  id="edit" class="btn btn-info" "> 
                        Edit</button></div>

                <div class="pull-right m-t-10 cls110"><button data-toggle="modal" class="btn btn-primary btn-cons" id="add"> 
                        Add</button></div>
            </ul>

            <div class="col-md-12 col-sm-12 col-xs-12">


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

                                <div class="pull-right">
                                    <input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo SEARCH; ?>"/> 

                                </div>
                                &nbsp;
                                <div class="panel-body" style="padding: 0px; margin-top: 2%;">

                                    <?php echo $this->table->generate(); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- END PANEL -->
        </div>
    </div>
</div>
<div class="modal fade slide-up disable-scroll in" id="generalPopup" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"></span>
                </div>
                <div class="modal-body text-center m-t-20">
                    <h4 class="no-margin p-b-10">Please select atleast one reason</h4>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-cons " data-dismiss="modal">OK</button>
                </div>
            </div>

        </div>
    </div>
    <!-- /.modal-content -->
</div>
</div>
<div class="modal fade slide-up disable-scroll in" id="modalSlideUpSmall" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"> ADD</span>
                </div>
                <div class="modal-body">
                    <div class="">
                        <label class="control-label">Reason</label>
                        <input type="text" id="addReasons" class="addReasons form-control" placeholder="Enter the reason for cancellation"/>
                    </div>
                    <?php
                    foreach ($language as $val) {
                        ?>
                        <div class="form-group">
                            <label for="fname" class=" control-label">Reason (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>


                            <input type="text" id="name_<?= $val['lan_id'] ?>" class="form-control addReasons" placeholder="Enter the reason for cancellation" name="Reason[<?= $val['lan_id'] ?>]" required="required" >

                        </div>
                    <?php } ?>
                </div>
                <div id="addReasonsError" class="addReasonsErr modalPopUpText" style="text-align: center;color: red;"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnadd">ADD</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<div class="modal fade slide-up disable-scroll in" id="editmodal" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"> EDIT</span>
                </div>
                <div class="modal-body">
                    <label>Reason</label>
                    <input type="text" id="editReasons" name="editReasons[]" class="form-control "  placeholder="Enter the reason for cancellation"/>
                    <div class="row">
                        <div class="error-box" id="errorboxEdit" class="errorboxEdit" style="font-size: large;text-align:center"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary editReasons"  data-id="" edit_id="" id="btnedit">Edit</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<div class="modal fade slide-up disable-scroll in" id="modalSlideUpSmallone" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"></span>
                </div>
                <div class="modal-body">
                    <h4 class="no-margin p-b-10">Are you sure, You want to Delete the reason ?</h4>

                </div>
                <div class="modal-footer">
                    <button type="button" id="btndelete" class="btn btn-primary " data-dismiss="modal">Continue</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
</div>


