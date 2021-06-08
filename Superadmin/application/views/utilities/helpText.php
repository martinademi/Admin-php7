<script src="<?= base_url() ?>theme/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
    $('.sm-table').find('.header-inner').html('<div class="brand inline" style="  width: auto;\
                     font-size: 27px;\
                     color: gray;\
                     margin-left: 100px;margin-right: 20px;margin-bottom: 12px; margin-top: 10px;">\
                    <strong><?= Appname ?> Super Admin Console</strong>\
                </div>');

    $(document).ready(function () {
//        var lan_tbl = $('#lan_table');
//        var settings = {
//            "sDom": "<'table-responsive't><'row'<p i>>",
//            "destroy": true,
//            "scrollCollapse": true,
//            "oLanguage": {
//                "sLengthMenu": "_MENU_ ",
//                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
//            },
//            "iDisplayLength": 5
//        };
//        lan_tbl.DataTable(settings);
//        $('#search-table').keyup(function () {
//            lan_tbl.fnFilter($(this).val());
//        });
//        $('#add_new_lan').click(function () {
//            $('#lan_title').html('Add new Language');
//            $('#add_lan').html('Add');
//            $('#lan_edit').val('');
//            $('#lan_name').val('');
//            $('#modal-lan').modal('show');
//        });
        var grp_tbl = $('#grp_table');
        var settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 20,
            "aoColumns": [
                {"sWidth": "2%","sClass" : "text-center"},
                {"sWidth": "10%"},
                {"sWidth": "5%","sClass" : "text-center"}
            ]
        };
        grp_tbl.DataTable(settings);
        $('#search-table1').keyup(function () {
            grp_tbl.fnFilter($(this).val());
        });
        $('#add_new_grp').click(function () {
            $('#grp_title').html('Add new Group');
            $('#add_grp').html('Add');
            $('#grp_edit').val('');
            $('#grp_name').val('');
            $('#modal-grp').modal('show');
        });
        var help_tbl = $('#help_table');
        var settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 20,
            "aoColumns": [
                {"sWidth": "2%","sClass" : "text-center"},
                {"sWidth": "10%"},
                {"sWidth": "5%"},
                {"sWidth": "10%"},
                {"sWidth": "2%","sClass" : "text-center"},
                {"sWidth": "5%"}
            ]
        };
        help_tbl.DataTable(settings);
        $('#search-table2').keyup(function () {
            help_tbl.fnFilter($(this).val());
        });
        var sabcat_tbl = $('#subcat_table');
        var settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 20//,
//            "aoColumns": [
//                {"sWidth": "2%","sClass" : "text-center"},
//                {"sWidth": "5%"},
//                {"sWidth": "10%"},
//                {"sWidth": "2%","sClass" : "text-center"},
//                {"sWidth": "5%","sClass" : "text-center"}
//            ]
        };
        help_tbl.DataTable(settings);
        $('#search-table3').keyup(function () {
            sabcat_tbl.fnFilter($(this).val());
        });
    });
//    var eid;
//    function add_edit_lan() {
//        if ($('#lan_name').val() == '') {
//            $('#lan_name').closest('.form-group').addClass('has-error');
//            return;
//        }
//        $('#lan_name').closest('.form-group').removeClass('has-error');
//        $.ajax({
//            url: "<?php echo base_url() ?>index.php?/utilities/lan_action",
//            type: "POST",
//            data: $('#lan_form').serialize(),
//            dataType: "JSON",
//            success: function (result) {
//                if (result.msg == '1') {
//                    if (result.insert != 0) {
//                        var lan_tbl = $('#lan_table').DataTable();
//                        lan_tbl.row.add([
//                            4,
//                            $('#lan_name').val(),
//                            "<a class='btn btn-default' onclick='editlan(this)' data-id='" + result.msg + "'>\
//                                    <i class='fa fa-edit text-white'></i> Edit\
//                                </a>\
//                                <a class='btn btn-default' onclick='dellan(this)' data-id='" + result.msg + "'>\
//                                    <i class='fa fa-trash text-white'></i> Delete\
//                                </a>"
//                        ]).draw();
//                    } else {
//                        $(eid).closest('tr').find("td:nth-child(2)").html($('#lan_name').val());
//                        eid = '';
//                    }
//                    $('#modal-lan').modal('hide');
//                } else {
//                    alert('Problem occurred please try agin.');
//                }
//            },
//            error: function () {
//                alert('Problem occurred please try agin.');
//            },
//            timeout: 30000
//        });
//    }
//    function editlan(rowid) {
//        eid = rowid;
//        $('#lan_title').html('Edit Language');
//        $('#add_lan').html('Update');
//        $('#lan_edit').val($(rowid).attr('data-id'));
//        $('#lan_name').val($(rowid).closest('tr').find("td:nth-child(2)").html());
//        $('#modal-lan').modal('show');
//    }
//    function dellan(rowid) {
//        $.ajax({
//            url: "<?php echo base_url() ?>index.php?/utilities/lan_action/del",
//            type: "POST",
//            data: {id: $(rowid).attr('data-id')},
//            dataType: "JSON",
//            success: function (result) {
//                if (result.msg == '1') {
//                    var lan_tbl = $('#lan_table').DataTable();
//                    lan_tbl.row($(rowid).closest('tr'))
//                            .remove()
//                            .draw();
//                } else {
//                    alert('Problem in Deleting language please try agin.');
//                }
//            },
//            error: function () {
//                alert('Problem in Deleting language please try agin.');
//            },
//            timeout: 30000
//        });
//    }
    var egid;
    function add_edit_grp() {
        if ($('#grp_name').val() == '' || $('#grp_name').val().toLowerCase() == 'english') {
            $('#grp_name').closest('.form-group').addClass('has-error');
            return;
        }
        $('#grp_name').closest('.form-group').removeClass('has-error');
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/utilities/grp_action",
            type: "POST",
            data: $('#grp_form').serialize(),
            dataType: "JSON",
            success: function (result) {
                if (result.msg == '1') {
                    if (result.insert != 0) {
                        var grp_tbl = $('#grp_table').DataTable();
                        var data = grp_tbl.rows().data();
                        grp_tbl.row.add([
                            parseInt(data.length) + 1,
                            $('#grp_name').val(),
                            "<a class='btn btn-default' onclick='editgrp(this)' data-id='" + result.msg + "'>\
                                    <i class='fa fa-edit'></i> Edit\
                                </a>\
                                <a class='btn btn-default' onclick='delgrp(this)' data-id='" + result.msg + "'>\
                                    <i class='fa fa-trash'></i> Delete\
                                </a>"
                        ]).draw();
                    } else {
                        $(egid).closest('tr').find("td:nth-child(2)").html($('#grp_name').val());
                        egid = '';
                    }
                    $('#modal-grp').modal('hide');
                } else {
                    alert('Problem occurred please try agin.');
                }
            },
            error: function () {
                alert('Problem occurred please try agin.');
            },
            timeout: 30000
        });
    }
    function editgrp(rowid) {
        egid = rowid;
        $('#grp_title').html('Edit Group');
        $('#add_grp').html('Update');
        $('#grp_edit').val($(rowid).attr('data-id'));
        $('#grp_name').val($(rowid).closest('tr').find("td:nth-child(2)").html());
        $('#modal-grp').modal('show');
    }
    function delgrp(rowid) {
        if (confirm("Are you sure want to Delete?")) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/utilities/grp_action/del",
                type: "POST",
                data: {id: $(rowid).attr('data-id')},
                dataType: "JSON",
                success: function (result) {
                    if (result.msg == '1') {
                        var grp_tbl = $('#grp_table').DataTable();
                        grp_tbl.row($(rowid).closest('tr'))
                                .remove()
                                .draw();
                    } else {
                        alert('Problem in Deleting Group please try agin.');
                    }
                },
                error: function () {
                    alert('Problem in Deleting Group please try agin.');
                },
                timeout: 30000
            });
        }
    }
    var settings = {
        "sDom": "<'table-responsive't><'row'<p i>>",
        "destroy": true,
        "scrollCollapse": true,
        "oLanguage": {
            "sLengthMenu": "_MENU_ ",
            "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
        },
        "iDisplayLength": 20,
        "aoColumns": [
            {"sWidth": "2%","sClass" : "text-center"},
            {"sWidth": "5%"},
            {"sWidth": "10%"},
            {"sWidth": "2%","sClass" : "text-center"},
            {"sWidth": "5%","sClass" : "text-center"}
        ]
    };
    function viewsub_cat(cat_id) {
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/utilities/get_subcat",
            type: "POST",
            data: {cat_id: cat_id},
            dataType: "JSON",
            success: function (result) {
                var scat_tbl = $('#subcat_table').DataTable(settings);
                scat_tbl.clear().draw();
                var i = 1;
                $.each(result.sub_cat, function (ind, val) {
                    var name = $.map(val.name, function (v) {
                        return v;
                    }).join(', ');
                    var desc = $.map(val.desc, function (v) {
                        return v;
                    }).join(', ');
                    console.log(name);
                    scat_tbl.row.add([
                        i++,
                        name,
                        desc,
                        (val.cat_hform == true) ? "Yes" : "No",
                        "<a class='btn btn-default' href='<?= base_url()?>index.php?/utilities/help_edit/" + String(result._id.$id) +"/" + String(val.scat_id.$id) +"' data-id='" + val._id + "'>\
                                <i class='fa fa-edit'></i> Edit\
                            </a>\
                            <a class='btn btn-default' onclick='delscat(this)' data-id='" + String(val.scat_id.$id) + "'>\
                                <i class='fa fa-trash'></i> Delete\
                            </a>"
                    ]).draw();
                });
                $('#modal-subcat').modal('show');
            },
            error: function () {
                alert('Problem occurred please try agin.');
            },
            timeout: 30000
        });
    }
    function delcat(rowid){
        if (confirm("Are you sure you want to Delete?")) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/utilities/help_cat_action/del",
                type: "POST",
                data: {id: $(rowid).attr('data-id')},
                dataType: "JSON",
                success: function (result) {
                    if (result.msg == '1') {
                        var hlp_tbl = $('#help_table').DataTable();
                        hlp_tbl.row($(rowid).closest('tr'))
                                .remove()
                                .draw();
                    } else {
                        alert('Problem in Deleting Group please try agin.');
                    }
                },
                error: function () {
                    alert('Problem in Deleting Group please try agin.');
                },
                timeout: 30000
            });
        }
    }
    function delscat(rowid){
        if (confirm("Are you sure you want to Delete?")) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/utilities/help_cat_action/del/1",
                type: "POST",
                data: {id: $(rowid).attr('data-id')},
                dataType: "JSON",
                success: function (result) {
                    if (result.msg == '1') {
                        var scat_tbl = $('#subcat_table').DataTable();
                        scat_tbl.row($(rowid).closest('tr'))
                                .remove()
                                .draw();
                    } else {
                        alert('Problem in Deleting Group please try agin.');
                    }
                },
                error: function () {
                    alert('Problem in Deleting Group please try agin.');
                },
                timeout: 30000
            });
        }
    }
</script>

<style>
    .header{
        height:60px !important;
    }
    .header h3{
        margin:10px 0 !important;
    }
    .rating>.rated {
        color: #10cfbd;
    }
    .social-user-profile {
        width: 83px;
    }
    .table > thead > tr > th{
        font-size: 14px;
    }
</style>

<div class="content">
    <div class="jumbotron  no-margin" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
            <div class="inner" style="transform: translateY(0px); opacity: 1;">
                <h3 class="">Page Title</h3>
            </div>
        </div>
    </div>
    <div class="container-fluid container-fixed-lg">
        <ul class="breadcrumb">
            <li>
                <a href="#" class="active">Help Text</a>
            </li>
            <!--            <li>
                            <a href="#" class="active">Job Details - <?php echo $data['appt_data']->appointment_id; ?></a>
                        </li>-->
        </ul>
        <div class="container-md-height m-b-20">
            <div class="panel panel-transparent">
                <ul class="nav nav-tabs nav-tabs-simple bg-white" role="tablist" data-init-reponsive-tabs="collapse">
                    <li class="active">
                        <a href="#hlp_txt" data-toggle="tab" role="tab" aria-expanded="false">Help Text</a>
                    </li>
                    <li class="">
                        <a href="#lan_grp" data-toggle="tab" role="tab" aria-expanded="true">Group</a>
                    </li>
                </ul>
                <div class="panel-group visible-xs" id="LaCQy-accordion"></div>
                <div class="tab-content">
                    <div class="tab-pane active" id="hlp_txt">
                        <div class="row panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Help Text</div>
                                <div class='pull-right'>
                                    <a href='<?= base_url() ?>index.php?/utilities/help_cat'>
                                        <button class='btn btn-success' id='add_new_cat'>
                                            <i class='fa fa-plus text-white'></i> Add New Category
                                        </button>
                                    </a>
                                </div>
                                <div class="panel-body no-padding">
                                    <table class="table table-hover demo-table-search" id="help_table">
                                        <thead>
                                            <tr>
                                                <th>SL No.</th>
                                                <th>Category</th>
                                                <th>Languages</th>
                                                <th>Description</th>
                                                <th>Has Form</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $l = 1;
                                            foreach ($helpText as $val) {
                                                ?>
                                                <tr>
                                                    <td class="v-align-middle semi-bold">
                                                        <?= $l++ ?>
                                                    </td>
                                                    <td><?= implode(", ", $val['name']) ?></td>
                                                    <td><?php
                                                        $elan = array();
                                                        $elang = array('English');
                                                        foreach($val['name'] as $ind => $val1)
                                                            array_push($elan, $ind);
                                                        foreach ($language as $val2) 
                                                            if(array_search($val2['lan_id'], $elan) != false)
                                                                array_push($elang,$val2['lan_name']);
                                                        echo implode(", ", $elang);
                                                    ?></td>
                                                    <td>
                                                        <?php
                                                        if ($val['has_scat'])
                                                            echo "<button class='btn btn-default' onclick='viewsub_cat(" . $val['cat_id'] . ")'>
                                                                        <i class='fa fa-eye'></i> Sub Categories
                                                                    </button>";
                                                        else
                                                            echo implode(", ", $val['desc']);
                                                        ?>
                                                    </td>
                                                    <td><?= ($val['cat_hform'] == "1") ? "Yes" : "No" ?></td>
                                                    <td class="v-align-middle">
                                                        <?php
                                                        if ($val['has_scat'])
                                                            echo "<a href='" . base_url() . "index.php?/utilities/help_cat/0/" . $val['cat_id'] . "'>
                                                                        <button class='btn btn-default' id='add_new_cat'>
                                                                            <i class='fa fa-plus'></i> Add Sub Category
                                                                        </button>
                                                                    </a><br/>";
                                                        ?>
                                                        <a class='btn btn-default' href='<?= base_url()?>index.php?/utilities/help_edit/<?= (String)$val['_id']?>' data-id='<?= $val['cat_id'] ?>'>
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <a class='btn btn-default' onclick='delcat(this)' data-id='<?= $val['cat_id'] ?>'>
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="lan_grp">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        ZenDesk Group
                                    </div>
                                    <div class='pull-right'>
                                        <button class='btn btn-success' id='add_new_grp'>
                                            <i class="fa fa-plus text-white"></i> Add Group
                                        </button>
                                    </div>
                                    <div class="panel-body no-padding">
                                        <table class="table table-hover demo-table-search" id="grp_table">
                                            <thead>
                                                <tr>
                                                    <th>SL No.</th>
                                                    <th>Group</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $l = 1;
                                                foreach ($group as $val) {
                                                    ?>
                                                    <tr>
                                                        <td class="v-align-middle semi-bold">
                                                            <?= $l++ ?>
                                                        </td>
                                                        <td><?= $val['grp_name'] ?></td>
                                                        <td class="v-align-middle">
                                                            <a class='btn btn-default' onclick='editgrp(this)' data-id='<?= $val['grp_id'] ?>'>
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <a class='btn btn-default' onclick='delgrp(this)' data-id='<?= $val['grp_id'] ?>'>
                                                                <i class="fa fa-trash"></i> Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<div class="modal fade slide-up disable-scroll" id="modal-lan" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form id='lan_form' action=''>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                    <i class="pg-close"></i>
                </button>
                <div class="modal-header">
                    <h4 class="modal-title" id='lan_title'></h4>
                </div>
                <div class="modal-body m-t-50">
                    <div class="form-group-attached">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-group-default required">
                                    <label>Language</label>
                                    <input type="text" required name='lan_name' id="lan_name" class="form-control">
                                    <input type="hidden" name='edit_id' id='lan_edit'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10 pull-right">
                            <button class="btn btn-primary btn-block m-t-5" id='add_lan' onclick='add_edit_lan()'>Add</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
         /.modal-content 
    </div>
     /.modal-dialog 
</div>-->
<div class="modal fade slide-up disable-scroll" id="modal-grp" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form id='grp_form' onsubmit='return false;'>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                    <i class="pg-close"></i>
                </button>
                <div class="modal-header">
                    <h4 class="modal-title" id='grp_title'></h4>
                </div>
                <div class="modal-body m-t-50">
                    <div class="form-group-attached">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-group-default required">
                                    <label>Group</label>
                                    <input type="text" required name='grp_name' id="grp_name" class="form-control">
                                    <input type="hidden" name='edit_id' id='grp_edit'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10 pull-right">
                            <button type='button' class="btn btn-primary btn-block m-t-5" id='add_grp' onclick='add_edit_grp()'>Add</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade slide-up" id="modal-subcat" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id='grp_form' onsubmit='return false;'>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                    <i class="pg-close"></i>
                </button>
                <div class="modal-header">
                    <h4 class="modal-title">Sub Categories</h4>
                </div>
                <div class="modal-body m-t-50">
                    <div class="form-group-attached">
                        <div class="row">
                            <table class="table table-hover demo-table-search" id="subcat_table">
                                <thead>
                                    <tr>
                                        <th style="width:3%;">SL No.</th>
                                        <th style="width:12%;">Sub-Category</th>
                                        <th style="width:20%;">Description</th>
                                        <th style="width:20%;">Has Form</th>
                                        <th style="width:10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>