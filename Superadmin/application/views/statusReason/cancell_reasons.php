<script src="<?= base_url() ?>theme/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
    $('.sm-table').find('.header-inner').html('<div class="brand inline" style="  width: auto;\
                     font-size: 27px;\
                     color: gray;\
                     margin-left: 100px;margin-right: 20px;margin-bottom: 12px; margin-top: 10px;">\
                    <strong><?= Appname ?> Super Admin Console</strong>\
                </div>');

    $(document).ready(function () {
        var lan_tbl = $('#res_table');
        var settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 5,
            "bJQueryUI": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 5,
            "aoColumns": [
                {"sWidth": "2%","sClass" : "text-center"},
                {"sWidth": "10%"},
                {"sWidth": "5%","sClass" : "text-center"}
            ]
        };
        lan_tbl.DataTable(settings);
        $('#search-table').keyup(function () {
            lan_tbl.fnFilter($(this).val());
        });
        $('#add_new_res').click(function () {
            console.log('Unsuccessfull clicked');
            $('#res_title').html('Add new Reason');
            $('#add_res').html('Add');
            $('#res_edit').val('');
            $('#res_name').val('');
            $('#res_for').val('unsuccessfull');
            $('#res_for_id').val('1');
            $('#modal-res').modal('show');
            $('.nres_div').remove();
            $('.res_check').prop('checked',false);
            $('.form-group').removeClass('has-error');

            var whogetsPaid = $("#whoGetsPaid option:selected").val();
            var whoGetsCharged = $("#whoGetsCharged option:selected").val();
            var ChargeDeliveryFee=$('input[name=chargeDeliveryFee]:checked').val();  
            var returnToStore=$('input[name=returnToStore]:checked').val(); 
                
            
        });
        var lan_tbl = $('#res_table_p');
        var settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 5,
            "bJQueryUI": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 5,
            "aoColumns": [
                {"sWidth": "2%","sClass" : "text-center"},
                {"sWidth": "10%"},
                {"sWidth": "5%","sClass" : "text-center"}
            ]
        };
        lan_tbl.DataTable(settings);
        $('#search-table').keyup(function () {
            lan_tbl.fnFilter($(this).val());
        });
        $('#add_new_res_p').click(function () {
            console.log('Partial clicked');
            $('#res_title').html('Add new Reason');
            $('#add_res').html('Add');
            $('#res_edit').val('');
            $('#res_name').val('');
            $('#res_for').val('partially');
            $('#res_for_id').val('2');
            $('#modal-res').modal('show');
            $('.nres_div').remove();
            $('.res_check').prop('checked',false);
            $('.form-group').removeClass('has-error');

            var whogetsPaid = $("#whoGetsPaid option:selected").val();
            var whoGetsCharged = $("#whoGetsCharged option:selected").val();
            var ChargeDeliveryFee=$('input[name=chargeDeliveryFee]:checked').val(); 
            var returnToStore=$('input[name=returnToStore]:checked').val(); 
        });
         var lan_tbl = $('#res_table_d');
        var settings = {
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 5,
            "bJQueryUI": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 5,
            "aoColumns": [
                {"sWidth": "2%","sClass" : "text-center"},
                {"sWidth": "10%"},
                {"sWidth": "5%","sClass" : "text-center"}
            ]
        };
        lan_tbl.DataTable(settings);
        $('#search-table').keyup(function () {
            lan_tbl.fnFilter($(this).val());
        });
         $('#add_new_res_d').click(function () {
             console.lof('others')
            $('#res_title').html('Add new Reason');
            $('#add_res').html('Add');
            $('#res_edit').val('');
            $('#res_name').val('');
            $('#res_for').val('manager');
            $('#modal-res').modal('show');
            $('.nres_div').remove();
            $('.res_check').prop('checked',false);
            $('.form-group').removeClass('has-error');
        });
        $('.res_check').change(function () {
            if ($(this).is(':checked')) {
                var html = '<div class="form-group form-group-default required nres_div res_lan_' + $(this).val() + '">\
                            <label>Reason (' + $(this).attr('data-id') + ')</label>\
                            <input type="text" required name="reasons[' + $(this).val() + ']" id="res_name_' + $(this).val() + '" class="form-control">\
                        </div>';
//                $(html).insertAfter($('.mainres'));
                $('.mainresapp').append(html);
            } else {
                $('.res_lan_' + $(this).val()).remove();
            }
        });
    });
    var eid;
    function add_edit_res() {
        $('.form-group').removeClass('has-error');
        var status = false;
        if ($('#res_name').val() == '') {
            $('#res_name').closest('.form-group').addClass('has-error');
            status = true;
        }
//        $('#res_name').closest('.form-group').removeClass('has-error');
        $('.nres_div').each(function(){
            var val = $(this).find('input:text').val();
            if (val == '') {
                $(this).addClass('has-error');
                status = true;
            }
        });
        if(status)
            return;
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/StatusReason/cancell_act",
            type: "POST",
            data: $('#res_form').serialize(),
            dataType: "JSON",
            success: function (result) {
                if (result.msg == '1') {
//                   console.log(result.insert);
                    if (result.insert != 0) {
                       
                        var res_tbl = $('#res_table_p').DataTable();
                        if($('#res_for').val() == 'unsuccessfull')
                            res_tbl = $('#res_table').DataTable();
                        if($('#res_for').val() == 'manager')
                            res_tbl = $('#res_table_d').DataTable();
                        var data = res_tbl.rows().data();
                        res_tbl.row.add([
                            parseInt(data.length) + 1,
                            $.map(result.reason, function (v) {
                                return v;
                            }).join('<br/>'),
                            "<a style='background: #5bc0de;border-color: #5bc0de;color: white;font-size: 10px;' class='btn btn-primary cls111'  onclick='editres(this)' data-id='" + result.insert + "' data-val='" + JSON.stringify(result.reason) + "' data-for='" + $('#res_for').val() + "'>\
                                    <i class='fa fa-edit'></i> Edit\
                                </a>\
                                <a  style='background: #d9534f;border-color: #d9534f;color: white;font-size: 10px;' class='btn btn-danger cls111' onclick='delres(this)' data-id='" + result.insert + "' data-for='" + $('#res_for').val() + "'>\
                                    <i class='fa fa-trash'></i> Delete\
                                </a>"
                        ]).draw();
                    } else {
                       
                        $(eid).closest('tr').find("td:nth-child(2)").html($.map(result.reason, function (v) {
                                                                                    return v;
                                                                                }).join('<br/>'));
                        $(eid).closest('tr').find("td:nth-child(3)").html("<a style='background: #5bc0de;border-color: #5bc0de;color: white;font-size: 10px;' class='btn btn-primary cls111'  onclick='editres(this)' data-id='" + result.insert + "' data-val='" + JSON.stringify(result.reason) + "' data-for='" + $('#res_for').val() + "'>\
                                                                            <i class='fa fa-edit'></i> Edit\
                                                                            </a>\
                                                                            <a style='background: #d9534f;border-color: #d9534f;color: white;font-size: 10px;' class='btn btn-default' onclick='delres(this)' data-id='" + $('#res_edit').val() + "' data-for='" + $('#res_for').val() + "'>\
                                                                                <i class='fa fa-trash'></i> Delete\
                                                                            </a>");
                      $(eid).closest('tr').find("td:nth-child(4)").html("<a style='background: #5bc0de;border-color: #5bc0de;color: white;font-size: 10px;' class='btn btn-primary cls111'  onclick='editres(this)' data-id='" + result.insert + "' data-val='" + JSON.stringify(result.reason) + "' data-for='" + $('#res_for').val() + "'>\
                                                                          <i class='fa fa-edit'></i> Edit\
                                                                              </a>\
                                                                            <a style='background: #d9534f;border-color: #d9534f;color: white;font-size: 10px;' class='btn btn-default' onclick='delres(this)' data-id='" + $('#res_edit').val() + "' data-for='" + $('#res_for').val() + "'>\
                                                                                <i class='fa fa-trash'></i> Delete\
                                                                            </a>");
                        
                        eid = '';
                    }
                   
                    $('#modal-res').modal('hide');
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
    function editres(rowid) {
        eid = rowid;
        $('#res_title').html('Edit Reason');
        $('#add_res').html('Update');
        $('.nres_div').remove();
        $('.res_check').prop('checked',false);
        $('#res_edit').val($(rowid).attr('data-id'));
        var val = jQuery.parseJSON($(rowid).attr('data-val'));
        $.each(val, function(ind,val){
            if(ind != 0){
                var chk = '#checkbox'+ ind ;
                $(chk).prop("checked", true);
                var html = '<div class="form-group form-group-default required nres_div res_lan_' + $(chk).val() + '">\
                            <label>Reason (' + $(chk).attr('data-id') + ')</label>\
                            <input type="text" required name="reasons[' + $(chk).val() + ']" id="res_name_' + $(chk).val() + '" class="form-control" value="'+ val +'">\
                        </div>';
//                $(html).insertAfter($('.mainres'));
                $('.mainresapp').append(html);
            }else{
                $('#res_name').val(val);
            }
        });
        $('.form-group').removeClass('has-error');
        $('#res_for').val($(rowid).attr('data-for'));
//        $('#res_name').val($(rowid).closest('tr').find("td:nth-child(2)").html());
        $('#modal-res').modal('show');
    }
    function delres(rowid) {
        if (confirm("Are you sure you want to Delete?")) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/StatusReason/cancell_act/del",
                type: "POST",
                data: {id: $(rowid).attr('data-id')},
                dataType: "JSON",
                success: function (result) {
                    if (result.msg == '1') {
                        var res_tbl = $('#res_table_p').DataTable();
                         
                        if($(rowid).attr('data-for') == 'unsuccessfull')
                            res_tbl = $('#res_table').DataTable();

                        res_tbl.row($(rowid).closest('tr'))
                                .remove()
                                .draw();
                        if($(rowid).attr('data-for') == 'manager')
                            res_tbl = $('#res_table_d').DataTable();

                        res_tbl.row($(rowid).closest('tr'))
                                .remove()
                                .draw();
                    } else {
                        alert('Problem in Deleting Reason please try agin.');
                    }
                },
                error: function () {
                    alert('Problem in Deleting Reason please try agin.');
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
    <div class="" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
            <div class="inner" style="transform: translateY(0px); opacity: 1;">
                <strong class="active" style="color: #0090d9; font-size: 14px;">STATUS NOTIFICATION</strong><br/>
            </div>
        </div>
    </div>
    
    <div class="container-fluid container-fixed-lg">
       
        <div class="container-md-height m-b-20">
            <div class="panel panel-transparent">
               
                <div class="panel-group visible-xs" id="LaCQy-accordion"></div>
                <div class="tab-content">
                    <div class="tab-pane active" id="lan_grp">
                        <div class="row">
                            <div class="col-sm-12 panel panel-default" style="border: 0;">
                                <div class="panel-heading" style="background:white;">
                                    <div class="pull-left panel-title" style="margin-top: 2%;color: #0090d9;">
                                        <strong style="font-size:12px;">Unsuccessfull Reason For Driver</strong>
                                    </div>
                                    <div class='pull-right'>
                                        <button class='btn btn-primary cls110' id='add_new_res' style="margin: 10px 0px;">
                                            Add
                                        </button>
                                    </div>
                                    <div class="panel-body no-padding">
                                        <table class="table table-striped table-bordered table-hover demo-table-search" id="res_table" style="margin-bottom: 10px;">
                                            <thead>
                                                <tr>
                                                    <th>SL No.</th>
                                                    <th>Unsuccessfull Notification</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $l = 1;
                                                foreach ($reasons as $val) {
                                                    if($val['res_for'] == 'unsuccessfull'){
                                                    ?>
                                                    <tr>
                                                        <td class="v-align-middle semi-bold">
                                                            <?= $l++ ?>
                                                        </td>
                                                        <td><?= implode("<br/>", $val['reasons']) ?></td>
                                                        <td class="v-align-middle">
                                                            <a style="background: #5bc0de;border-color: #5bc0de;color: white;font-size: 10px;" class='btn btn-default cls111' onclick='editres(this)' data-id='<?= $val['res_id'] ?>' data-val='<?= json_encode($val['reasons'])?>' data-for='unsuccessfull'>
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <a style="background: #d9534f;border-color: #d9534f;color: white;font-size: 10px;" class='btn btn-default cls111' onclick='delres(this)' data-id='<?= $val['res_id'] ?>' data-for='unsuccessfull'>
                                                                <i class="fa fa-trash"></i> Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                        }
                                                    } 
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 panel panel-default" style="border: 0;">
                                <div class="panel-heading" style="background:white;">
                                    <div class="pull-left panel-title" style="margin-top: 2%;color:  #0090d9;">
                                        <strong style="font-size:12px;">Partially Successfull Reason For Driver</strong>
                                    </div>
                                    <div class='pull-right'>
                                        <button class='btn btn-primary cls110' id='add_new_res_p' style="margin: 10px 0px;">
                                             Add
                                        </button>
                                    </div>
                                    <div class="panel-body no-padding">
                                        <table class="table table-striped table-bordered table-hover demo-table-search" id="res_table_p" style="margin-bottom: 10px;">
                                            <thead>
                                                <tr>
                                                    <th>SL No.</th>
                                                    <th>Partial Notification</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $l = 1;
                                                foreach ($reasons as $val) {
                                                    if($val['res_for'] == 'partially'){
                                                    ?>
                                                    <tr>
                                                        <td class="v-align-middle semi-bold">
                                                            <?= $l++ ?>
                                                        </td>
                                                        <td><?= implode("<br/>", $val['reasons']) ?></td>
                                                        <td class="v-align-middle">
                                                            <a style="background: #5bc0de;border-color: #5bc0de;color: white;font-size: 10px;" class='btn btn-default cls111' onclick='editres(this)' data-id='<?= $val['res_id'] ?>' data-val='<?= json_encode($val['reasons'])?>' data-for='partially'>
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <a style="background: #d9534f;border-color: #d9534f;color: white;font-size: 10px;" class='btn btn-default cls111' onclick='delres(this)' data-id='<?= $val['res_id'] ?>' data-for='partially'>
                                                                <i class="fa fa-trash"></i> Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                        }
                                                    } 
                                                ?>
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

<div class="modal fade slide-up disable-scroll" id="modal-res" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form id='res_form' onsubmit='return false;'>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                    <i class="pg-close"></i>
                </button>
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id='res_title'></h4>
                </div>
                <div class="modal-body m-t-50">
                    <div class="form-group-attached">
                        <div class="row">
                            <div class='col-sm-12'>
                                <div class='col-sm-3'>
                                    <div class="checkbox check-success disabled">
                                        <input type="checkbox" value="0" id="checkbox0" data-id='English' disabled checked>
                                        <label for="checkbox0">English</label>
                                    </div>
                                </div>
                                <?php
                                foreach ($language as $val) {
                                    ?>
                                    <div class='col-sm-3'>
                                        <div class="checkbox check-success">
                                            <input type="checkbox" class='res_check' value="<?= $val['lan_id'] ?>" id="checkbox<?= $val['lan_id'] ?>" data-id='<?= $val['lan_name'] ?>'>
                                            <label for="checkbox<?= $val['lan_id'] ?>"><?= $val['lan_name'] ?></label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-sm-12 mainresapp">
                                <div class="form-group form-group-default required mainres">
                                    <label>Reason (English)</label>
                                    <input type="text" required name="reasons[0]" id="res_name" class="form-control">
                                    <input type="hidden" name="edit_id" id="res_edit">
                                    <input type="hidden" name="res_for" id="res_for">
                                    <input type="hidden" name="res_for_id" id="res_for_id">

                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo "Who gets paid"; ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                            <select  class="form-control" name="whoGetsPaid" id="whoGetsPaid">
                                <option value="1" data-name="Driver">Driver</option>
                                <option value="2" data-name="Grocery">Trineo</option>
                                <option value="3" data-name="All">All</option>                               
                            </select>
                            </div>
                        </div>

                         <div class="form-group col-sm-12">
                            <label class="col-sm-4 control-label"><?php echo "Who gets charged"; ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-7">
                            <select  class="form-control" name="whoGetsCharged" id="whoGetsCharged">
                                <option value="1" data-name="Driver">Driver</option>
                                <option value="2" data-name="Grocery">Trineo</option>
                                <option value="3" data-name="Store">Store</option>  
                                <option value="4" data-name="All">All</option>                             
                            </select>
                            </div>
                        </div>                     

                        
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo "Charge delivery Fee "; ?><span class="MandatoryMarker"> *</span></label>

                             <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio" class="chargeDeliveryFee"  name="chargeDeliveryFee" id="yes" value="1" checked>
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="chargeDeliveryFee" class="col-sm-3 control-label "><?php echo "Yes"; ?></label>
                                </div>

                            </div>

                            <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio"  class="chargeDeliveryFee"   name="chargeDeliveryFee" id="no" value="2">
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="chargeDeliveryFee"  class=" col-sm-3 control-label"><?php echo "No"; ?></label>
                                </div>

                            </div>
                           
                           

                        </div>

                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-4 control-label"><?php echo "Return to Store "; ?><span class="MandatoryMarker"> *</span></label>

                             <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio" class="returnToStore"  name="returnToStore" id="yes" value="1" checked>
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="returnToStore" class="col-sm-3 control-label "><?php echo "Yes"; ?></label>
                                </div>

                            </div>

                            <div class="col-sm-4">
                                <div class="col-sm-1">
                                    <input style="cursor: pointer" type="radio"  class="returnToStore"   name="returnToStore" id="no" value="2">
                                </div>
                                <div class="col-sm-3">
                                    <label style="cursor: pointer" for="returnToStore"  class=" col-sm-3 control-label"><?php echo "No"; ?></label>
                                </div>

                            </div>
                           
                           

                        </div>
                    



                    </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10 pull-right">
                            <button type='button' class="btn btn-primary btn-block m-t-5" id='add_res' onclick='add_edit_res()'>Add</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>