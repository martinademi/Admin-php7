<?php
//    $mainAdmin = $this->session->userdata("mainAdmin");
//
//    if($mainAdmin != true){
//        redirect(base_url().'index.php?/superadmin/access_denied');
//    }
$City_Nm = array();
foreach ($cities as $val) {
    $City_Nm[$val->City_Id] = $val->City_Name;
}
$City_Nm[0] = "All";
$Role_Nm = array();
foreach ($roles as $val) {
    $Role_Nm[(string) $val['_id']['$oid']] = $val['role_name'];
}
$userList = array();
foreach ($users as $val) {
    $userList[] = $val;
}
$manageAccess = array(
    ['Dashboard', 'dashboard'],
    ['Payment Gateway', 'paymentgateway'],    
    ['Tax','taxes'],
    ['Cities', 'citySetup'],  
    ['Authorised User', 'Users'],  
    ['App Setting', 'appSetting'],    
    ['ProductSetup', 'productSetup'],
    ['Products', 'products'],
    ['Store Setup', 'storeSetup'],
    ['Franchise Setup', 'franchiseSetup'],
    ['Customer', 'customer'],
    ['Carts', 'carts'],
    ['Drivers', 'driver'],
    ['Estimate', 'estimate'],
    ['Orders', 'orders'],
    ['Product Offer', 'offers'],
    ['Wallet', 'wallet'],
    ['Marketing','marketing'],
    ['Ratings','ratings'],
    ['Logs', 'logs'],
    ['Manage Access', 'manageAccess'], 
    ['App Content', 'appContent'],
    ['HelpText', 'helpText'],
    ['Add ons','central'],
    ['Store Products','storeproducts'],
    ['Policy Pages','policyPages'],

   // ['Send Notification','sendNotification'],
    ['Bookings','allBookings'],
    ['Packaging Plan','PackagingPlan'],
    ['Payoff','payoff'],

   
);
?>
<style>
    .DataTables_sort_wrapper {
        text-align: center;
    }
    #user_table_paginate{
        display: none;
    }

    .cmn-toggle {
        position: absolute;
        margin-left: -9999px;

    }
    .cmn-toggle + label {
        display: block;
        position: relative;
        cursor: pointer;
        outline: none;
        user-select: none;
    }
    input.cmn-toggle-round + label {
        padding: 2px;
        width: 44px;
        height: 20px;
        background-color: #dddddd;
        border-radius: 60px;
    }
    input.cmn-toggle-round + label:before,
    input.cmn-toggle-round + label:after {
        display: block;
        position: absolute;
        top: 1px;
        left: 1px;
        bottom: 1px;
        content: "";
    }
    input.cmn-toggle-round + label:before {
        right: 1px;
        background-color: #f1f1f1;
        border-radius: 50px;
        transition: background 0.4s;
    }
    input.cmn-toggle-round + label:after {
        width: 16px;
        background-color: #fff;
        border-radius: 100%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        transition: margin 0.4s;
    }
    input.cmn-toggle-round:checked + label:before {
        background-color: #8ce196;
    }
    input.cmn-toggle-round:checked + label:after {
        margin-left:25px;
    }
</style>
<script src="<?= base_url() ?>theme/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
//    $('.sm-table').find('.header-inner').html('<div class="brand inline" style="  width: auto;\
//                     font-size: 27px;\
//                     color: gray;\
//                     margin-left: 100px;margin-right: 20px;margin-bottom: 12px; margin-top: 10px;">\
//                    <strong><?= Appname ?> Super Admin Console</strong>\
//                </div>');
    var settings = {
        "sDom": "<'table-responsive't><'row'<p i>>",
        "destroy": true,
        "scrollCollapse": true,
        "bJQueryUI": true,
        "oLanguage": {
            "sLengthMenu": "_MENU_ ",
            "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
        },
        "iDisplayLength": 200,
        "aoColumns": [
            {"sWidth": "2%", "sClass": "text-center"},
            {"sWidth": "10%"},
            {"sWidth": "5%", "sClass": "text-center"}
        ]
    };
    var settings_user = {
        "sDom": "<'table-responsive't><'row'<p i>>",
        "destroy": true,
        "scrollCollapse": true,
        "bJQueryUI": true,
        "oLanguage": {
            "sLengthMenu": "_MENU_ ",
            "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
        },
        "iDisplayLength": 200,
        "ordering": false,
        "aoColumns": [
            {"sWidth": "2%", "sClass": "text-center"},
            {"sWidth": "7%"},
            {"sWidth": "5%", "sClass": "text-center"},
            {"sWidth": "5%", "sClass": "text-center"},
            {"sWidth": "5%", "sClass": "text-center"}
        ]
    };
    $(document).ready(function () {

        //Mark the all the check box when you click on view column
        $('.allViewCheckbox').click(function () {
            if ($('.allViewCheckbox').is(':checked'))
                $('.checkAllViewCheckbox').attr('checked', true);
            else
                $('.checkAllViewCheckbox').attr('checked', false);
        });

        //Mark the all the check box when you click on add column
        $('.allAddCheckbox').click(function () {
            if ($('.allAddCheckbox').is(':checked'))
                $('.checkAllAddCheckbox').attr('checked', true);
            else
                $('.checkAllAddCheckbox').attr('checked', false);
        });

        //Mark the all the check box when you click on edit column
        $('.allEditCheckbox').click(function () {
            if ($('.allEditCheckbox').is(':checked'))
                $('.checkAllEditCheckobx').attr('checked', true);
            else
                $('.checkAllEditCheckobx').attr('checked', false);
        });

        var role_tbl = $('#role_table');
        role_tbl.DataTable(settings);
        $('#search-table1').keyup(function () {
            role_tbl.fnFilter($(this).val());
        });
        $('#add_new_role').click(function () {
            $('#role_title').html('ADD ROLE');
            $('#add_role').html('ADD');
            $('#role_edit').val('');
            $('#role_name').val('');
            $('.checkrole_role').prop('checked', false);
            $('.checkrole_role').prop('disabled', false);
            $('.checkrole_role').closest('.checkbox').removeClass('disabled');

            //Uncheck the all check box initially
            $('.allViewCheckbox').attr('checked', false);
            $('.allAddCheckbox').attr('checked', false);
            $('.allEditCheckbox').attr('checked', false);

            $('.allViewCheckbox').css('display', '');
            $('.allAddCheckbox').css('display', '');
            $('.allEditCheckbox').css('display', '');
            
            $('#modal-role').modal('show');
        });

        var user_tbl = $('#user_table');
        user_tbl.DataTable(settings_user);

        $('#add_new_user').click(function () {
            $('#user_title').html('ADD USER');
            $('#add_user').html('Add');
            $('#user_edit').val('');
            $('#user_name').val('');
            $('#user_role').val('');
            $('#user_email').val('');
            $('#user_pass').val('');
            $('#user_pass').prop('disabled', false);
            $('#user_pass').closest('.form-group').removeClass('disabled');
            $('#user_city').val('');
            $('.checkrole').prop('checked', false);
            $('.checkrole').prop('disabled', false);
            $('.checkrole').closest('.checkbox').removeClass('disabled');
            $('#modal-user').modal('show');
        });
        $('.checkall_role').change(function () {
            if (this.checked) {
                $(this).closest('.row').find('.check3_role').prop('checked', true);
                $(this).closest('.row').find('.check3_role').prop('disabled', true);
                $(this).closest('.row').find('.check3_role').closest('.checkbox').addClass('disabled');
            } else {
                $(this).closest('.row').find('.check3_role').prop('disabled', false);
                $(this).closest('.row').find('.check3_role').closest('.checkbox').removeClass('disabled');
                $('.checkadd_role').trigger('change');
            }
        });
        $('.checkadd_role').change(function () {
            if (this.checked) {
                $(this).closest('.row').find('.check2_role').prop('checked', true);
                $(this).closest('.row').find('.check2_role').prop('disabled', true);
                $(this).closest('.row').find('.check2_role').closest('.checkbox').addClass('disabled');
            } else {
                $(this).closest('.row').find('.check2_role').prop('disabled', false);
                $(this).closest('.row').find('.check2_role').closest('.checkbox').removeClass('disabled');
            }
        });
        $('.checkall').change(function () {
            if (this.checked) {
                $(this).closest('.row').find('.check3').prop('checked', true);
                $(this).closest('.row').find('.check3').prop('disabled', true);
                $(this).closest('.row').find('.check3').closest('.checkbox').addClass('disabled');
            } else {
                $(this).closest('.row').find('.check3').prop('disabled', false);
                $(this).closest('.row').find('.check3').closest('.checkbox').removeClass('disabled');
                $('.checkadd').trigger('change');
            }
        });
        $('.checkadd').change(function () {
            if (this.checked) {
                $(this).closest('.row').find('.check2').prop('checked', true);
                $(this).closest('.row').find('.check2').prop('disabled', true);
                $(this).closest('.row').find('.check2').closest('.checkbox').addClass('disabled');
            } else {
                $(this).closest('.row').find('.check2').prop('disabled', false);
                $(this).closest('.row').find('.check2').closest('.checkbox').removeClass('disabled');
            }
        });
        $('#user_role').change(function () {
            $('.checkrole').prop('checked', false);
            $('.checkrole').prop('disabled', false);
            $('.checkrole').closest('.checkbox').removeClass('disabled');

            var accarr = JSON.parse($('option:selected', this).attr('data-val'));
            $.each(accarr, function (ind, val) {
                $("." + ind + "acc[value=" + val + "]").prop("checked", true);
            });
            $('.checkadd').trigger('change');
            $('.checkall').trigger('change');
        });
    });

    var erid;
    function add_edit_role() {
        if ($('#role_name').val() == '') {
            $('#role_name').closest('.form-group').addClass('has-error');
            return;
        }
        $('#role_name').closest('.form-group').removeClass('has-error');
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/superadmin/role_action",
            type: "POST",
            data: $('#role_form').serialize(),
            dataType: "JSON",
            success: function (result) {
                if (result.msg == '1') {
                    if (result.insert != 0) {
                        var role_tbl = $('#role_table').DataTable(settings);
                        var data = role_tbl.rows().data();
                        role_tbl.row.add([
                            parseInt(data.length) + 1,
                            $('#role_name').val(),
                            "<a class='btn btn-info cls111' style='color:white;'  onclick='editrole(this)' data-id='" + result.insert + "' data-val='" + JSON.stringify(result.access) + "'>\
                                    <i class='fa fa-edit'></i> Edit\
                                </a>\
                                <a class='btn btn-danger cls111' style='color:white;'  onclick='delrole(this)' data-id='" + result.insert + "'>\
                                    <i class='fa fa-trash'></i> Delete\
                                </a>"
                        ]).draw();
                        var optionhtml = "<option value='" + result.insert + "' data-val='" + JSON.stringify(result.access) + "'>" + $('#role_name').val() + "</option>";
                        $('#user_role').append(optionhtml);
                    } else {
                        $(erid).closest('tr').find("td:nth-child(2)").html($('#role_name').val());
                        $(erid).closest('tr').find("td:nth-child(3)").html("<a class='btn btn-info' style='color:white;'  onclick='editrole(this)' data-id='" + $('#role_edit').val() + "' data-val='" + JSON.stringify(result.access) + "'>\
                                                                                <i class='fa fa-edit cls111'></i> Edit\
                                                                            </a>\
                                                                            <a class='btn btn-danger cls111' style='color:white;'  onclick='delrole(this)' data-id='" + $('#role_edit').val() + "'>\
                                                                                <i class='fa fa-trash'></i> Delete\
                                                                            </a>");
                        $("#user_role option[value=" + $('#role_edit').val() + "]").attr("data-val", JSON.stringify(result.access));
                        $("#user_role option[value=" + $('#role_edit').val() + "]").html($('#role_name').val());
                        erid = '';
                    }
                    $('#modal-role').modal('hide');
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
    function editrole(rowid) {
        erid = rowid;
        $('#role_title').html('EDIT ROLE');
        $('#add_role').html('Update');
        $('#role_edit').val($(rowid).attr('data-id'));
        $('#role_name').val($(rowid).closest('tr').find("td:nth-child(2)").html());
        $('.checkrole_role').prop('checked', false);
        $('.checkrole_role').prop('disabled', false);
        $('.checkrole_role').closest('.checkbox').removeClass('disabled');

        var accarr = JSON.parse($(rowid).attr('data-val'));
        $.each(accarr, function (ind, val) {
            $("." + ind + "acc_role[value=" + val + "]").prop("checked", true);
        });

        $('.allViewCheckbox').css('display', 'none');
        $('.allAddCheckbox').css('display', 'none');
        $('.allEditCheckbox').css('display', 'none');

        $('.checkadd_role').trigger('change');
        $('.checkall_role').trigger('change');
        $('#modal-role').modal('show');
    }
    function delrole(rowid) {
        if (confirm("Are you sure want to Delete?")) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/role_action/del",
                type: "POST",
                data: {<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>', id: $(rowid).attr('data-id')},
                dataType: "JSON",
                success: function (result) {
                    if (result.msg == '1') {
                        $("#user_role option[value=" + $(rowid).attr('data-id') + "]").remove();
                        var role_tbl = $('#role_table').DataTable(settings);
                        role_tbl.row($(rowid).closest('tr'))
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

    var euid;
    function add_edit_user() {
        alert();
        if ($('#user_name').val() == '') {
            $('#user_name').closest('.form-group').addClass('has-error');
            return;
        }
        $('#user_name').closest('.form-group').removeClass('has-error');
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/superadmin/user_action",
            type: "POST",
            data: $('#user_form').serialize(),
            dataType: "JSON",
            success: function (result) {
                if (result.msg == '1') {
                    if (result.insert != 0) {
                        var user_tbl = $('#user_table').DataTable(settings_user);
                        var data = user_tbl.rows().data();
                        user_tbl.row.add([
                            parseInt(data.length) + 1,
                            $('#user_name').val(),
                            "<a class='btn btn-info cls111' style='color:white;' onclick='editgrp(this)' data-id='" + result.msg + "'>\
                                    <i class='fa fa-edit'></i> Edit\
                                </a>\
                                <a class='btn btn-danger cls111' style='color:white;'  onclick='delgrp(this)' data-id='" + result.msg + "'>\
                                    <i class='fa fa-trash'></i> Delete\
                                </a>"
                        ]).draw();
                    } else {
                        $(euid).closest('tr').find("td:nth-child(2)").html($('#user_name').val());
                        euid = '';
                    }
                    $('#modal-user').modal('hide');
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
    var euser_email = '';
    function edituser(rowid) {



        euid = rowid;
        $('#user_title').html('EDIT USER');
        $('#add_user').html('Update');
        $('#user_edit').val($(rowid).attr('data-id'));
        $('#user_name').val($(rowid).closest('tr').find("td:nth-child(2)").html());
        $('#user_role').val($(rowid).closest('tr').find("td:nth-child(3)").attr('data-id'));
        euser_email = $(rowid).closest('tr').find("td:nth-child(4)").html();
        $('#user_email').val($(rowid).closest('tr').find("td:nth-child(4)").html());
        $('#user_city').val($(rowid).closest('tr').find("td:nth-child(5)").attr('data-id'));
        $('#user_pass').val('');
        $('#user_pass').prop('disabled', true);
        $('#user_pass').closest('.form-group').addClass('disabled');
        $('.checkrole').prop('checked', false);
        $('.checkrole').prop('disabled', false);
        $('.checkrole').closest('.checkbox').removeClass('disabled');

        var autoApproval = $(rowid).attr('maskEn');
        if (autoApproval) {
            if (autoApproval == 1) {
                $('#emailMask').prop('checked', true);
            } else if (autoApproval == 0) {
                $('#emailMask').prop('checked', false);
            }
        }     
      
        //  var autoApproval = '<?php echo $storedata['autoApproval'] ?>';
        // if (autoApproval) {
        //     if (autoApproval == 1) {
        //         $('#emailMask').prop('checked', true);
        //     } else if (autoApproval == 0) {
        //         $('#emailMask').prop('checked', false);
        //     }
        // }

        // $('#emailMaskEdit').attr('checked', false);
        //             if (result.data.emailMask)
        //                 $('#emailMaskEdit').attr('checked', true);
  

        var accarr = JSON.parse($(rowid).attr('data-val'));
        $.each(accarr, function (ind, val) {
//            console.log(ind+"->"+val);
            $("." + ind + "acc[value=" + val + "]").prop("checked", true);
        });
        $('.checkadd').trigger('change');
        $('.checkall').trigger('change');
        $('#modal-user').modal('show');
    }
    function deluser(rowid) {
        if (confirm("Are you sure want to Delete?")) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/user_action/del",
                type: "POST",
                data: {<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>', id: $(rowid).attr('data-id')},
                dataType: "JSON",
                success: function (result) {
                    if (result.msg == '1') {
                        var user_tbl = $('#user_table').DataTable(settings_user);
                        user_tbl.row($(rowid).closest('tr'))
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
    var users_emails = [];
    var users = JSON.parse('<?= json_encode($userList); ?>');
    jQuery.each(users, function (key, val) {
        users_emails.push(val.email);
    });
    function checkemail() {
        var email = $('#user_email').val();
        var eid = $('#user_edit').val();

        if (users_emails.indexOf(email) == -1) {
            return true;
        } else if (eid == '') {
            $('#user_email').closest('.form-group').addClass('has-error');
            return false;
        } else if (euser_email == email) {
            return true;
        } else {
            $('#user_email').closest('.form-group').addClass('has-error');
            return false;
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
    .form-group-default.disabled input {
        opacity: 0.23;
    }
    #selectedcity,#companyid{
        display: none;
    }
</style>

<div class="content">
    <div class="brand inline" style="  width: auto;">
        <strong >ACCESS CONTROL</strong>
    </div>
    <div class="container-fluid container-fixed-lg">

        <div class="container-md-height m-b-20">
            <div class="panel panel-transparent">
                <ul class="nav nav-tabs nav-tabs-simple bg-white" role="tablist" data-init-reponsive-tabs="collapse">
                    <li class="active tabs_active">
                        <a href="#tab_user" data-toggle="tab" role="tab" aria-expanded="false">USERS</a>
                    </li>
                    <li class="tabs_active">
                        <a href="#tab_role" data-toggle="tab" role="tab" aria-expanded="true">ROLES</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane slide-right active" id="tab_user">
                        <div class="row">

                            <div class="panel-heading">

                                <div class='pull-right cls110'>
                                    <button class='btn btn-success' id='add_new_user'>
                                        <i class="fa fa-plus text-white"></i> Add User
                                    </button>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered dataTable no-footer" id="user_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>USER NAME</th>
                                            <th>ROLE</th>
                                            <th>EMAIL</th>
                                            <!--<th>City</th>-->
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $l = 1;
                                        foreach ($users as $val) {
                                            ?>
                                            <tr>
                                                <td class="v-align-middle semi-bold">
                                                    <?= $l++ ?>
                                                </td>
                                                <td><?= $val['name'] ?></td>
                                                <td data-id='<?= $val['role']['$oid'] ?>'><?= $Role_Nm[$val['role']['$oid']] ?></td>
                                                <td><?= $val['email'] ?></td>
    <!--                                                <td data-id='<?= $val['city'] ?>'><?= $City_Nm[$val['city']] ?></td>-->
                                                <td class="v-align-middle">
                                                    <a class='btn btn-info cls111' style="color:white;" maskEn="<?= ($val['emailMask'] == 'on')?1:0 ?>" onclick='edituser(this)' data-id='<?= (string) $val['_id']['$oid']; ?>' data-val='<?= json_encode($val['access']) ?>'>
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a class='btn btn-danger cls111' style="color:white;" onclick='deluser(this)' data-id='<?= (string) $val['_id']['$oid']; ?>'>
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
                    <div class="tab-pane slide-left" id="tab_role">
                        <div class="row">

                            <div class="panel-heading">

                                <div class='pull-right cls110'>
                                    <button class='btn btn-success' id='add_new_role'>
                                        <i class="fa fa-plus text-white"></i> Add Role
                                    </button>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table  class="table table-striped table-bordered dataTable no-footer" id="role_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>ROLE NAME</th>
                                            <th align="center">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $l = 1;
                                        foreach ($roles as $val) {
                                            ?>
                                            <tr>
                                                <td class="v-align-middle semi-bold">
                                                    <?= $l++ ?>
                                                </td>
                                                <td><?= $val['role_name'] ?></td>
                                                <td class="v-align-middle">
                                                    <a class='btn btn-info cls111' style="color:white;" onclick='editrole(this)' data-id='<?= (string) $val['_id']['$oid'] ?>' data-val='<?= json_encode($val['access']) ?>'>
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <a class='btn btn-danger cls111' style="color:white;" onclick='delrole(this)' data-id='<?= (string) $val['_id']['$oid'] ?>'>
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

<div class="modal fade slide-up disable-scroll" id="modal-role" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id='role_form' onsubmit='return false;'>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                    <i class="pg-close"></i>
                </button>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title" id='role_title'></span>
                </div>
                <div class="modal-body m-t-50">
                    <div class="form-group-attached">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-group-default required">
                                    <label>Role</label>
                                    <input type="text" required name='fdata[role_name]' id="role_name" class="form-control">
                                    <input type="hidden" name='edit_id' id='role_edit'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row-fluid bold m-t-10 m-b-10" style="font-weight: 700;margin-left: 40%;">
                        <b style="color:#1ABB9C;font-size: 15px;">ACCESS RIGHTS</b>
                        <?php
                        foreach ($manageAccess as $val) {
                            echo '<input type="hidden" value="000" name="fdata[access][' . $val[1] . ']">';
                        }
                        ?>
                    </div>
                    <br>
                    <div class='row bold p-l-20' style="font-weight: 700;">
                        <div class="col-sm-6" style="padding-left: 10px;color:#31b0d5">PAGES</div>
                        <div class="col-sm-2" style="margin-left:-3px;color:#31b0d5">
                            <input type="checkbox" value="100" id="" name="" class="allViewCheckbox"> VIEW
                        </div>
                        <div class="col-sm-2" style="color:#31b0d5">
                            <input type="checkbox" value="110" id="" name="" class="allAddCheckbox"> ADD</div>
                        <div class="col-sm-2" style="color:#31b0d5">
                            <input type="checkbox" value="110" id="" name="" class="allEditCheckbox">EDIT</div>
                    </div>
                    <hr>
                    <div class='row' style="height: 40vh;overflow-x: hidden;margin-left: 2px;">
                        <?php
                        $i = 0;
                        foreach ($manageAccess as $val) {
                            ?>
                            <div class='row bordered'>
                                <div class="col-sm-6 checkbox p-l-15"><?= $val[0] ?></div>
                                <div class="col-sm-2 p-l-25">
                                    <div class="checkbox check-success">
                                        <input type="checkbox" value="100" id="checkbox<?= $i ?>r" name="fdata[access][<?= $val[1] ?>]" class="checkAllViewCheckbox check2_role check3_role checkrole_role <?= $val[1] ?>acc_role">
                                        <label for="checkbox<?= $i++ ?>r" style='position: initial;'></label>
                                    </div>
                                </div>
                                <div class="col-sm-2 p-l-25">
                                    <div class="checkbox check-success">
                                        <input type="checkbox" value="110" id="checkbox<?= $i ?>r" name="fdata[access][<?= $val[1] ?>]" class="checkAllAddCheckbox checkadd_role check3_role checkrole_role <?= $val[1] ?>acc_role">
                                        <label for="checkbox<?= $i++ ?>r" style='position: initial;'></label>
                                    </div>
                                </div>
                                <div class="col-sm-2 p-l-25">
                                    <div class="checkbox check-success">
                                        <input type="checkbox" value="111" id="checkbox<?= $i ?>r" name="fdata[access][<?= $val[1] ?>]" class="checkAllEditCheckobx checkall_role checkrole_role <?= $val[1] ?>acc_role">
                                        <label for="checkbox<?= $i++ ?>r" style='position: initial;'></label>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="pull-right">
                            <button type='button' class="btn btn-primary btn-block m-t-5" id='add_role' onclick='add_edit_role()'>Add</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade slide-up" id="modal-user" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id='user_form' action="<?php echo base_url() ?>index.php?/superadmin/user_action/" autocomplete="off" method="post" onsubmit="return checkemail();">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                    <i class="pg-close"></i>
                </button>
                <div class="modal-header">  
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title" id='user_title'></span>
                </div>
                <div class="modal-body m-t-20">
                    <div class="form-group-attached">
                        <div class="form-group form-group-default required">
                            <label>User Name</label>
                            <input type="text" required name='fdata[name]' id="user_name" class="form-control" autocomplete="off">
                            <input type="hidden" name='edit_id' id='user_edit'>
                        </div>
                        <div class="form-group form-group-default required">
                            <label>Role</label>
                            <select required name='fdata[role]' id="user_role" class="form-control">
                                <option value=''>Select Role</option>
                                <?php
                                foreach ($roles as $val) {
                                    ?>
                                    <option value='<?= (string) $val['_id']['$oid'] ?>' data-val='<?= json_encode($val['access']) ?>'><?= $val['role_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group form-group-default required">
                            <label>Email</label>
                            <input type="email" required name='fdata[email]' id="user_email" class="form-control" value="" autocomplete="off">
                        </div>
                        <div class="form-group form-group-default required">
                            <label>Password</label>
                            <input type="password" required name='fdata[pass]' id="user_pass" class="form-control" value="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="" class=""><?php echo 'Mask Email/Phone' ?></label>                                                          
                                        <input id="emailMask" name="fdata[emailMask]" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                        <label for="emailMask"></label>                           
                        </div>
                    </div>
                    <div class="row-fluid bold m-t-10 m-b-10" style="margin-left: 40%;">
                        <b style="color:#1ABB9C;font-size: 15px;">ACCESS RIGHTS</b>
                        <input type="hidden" value="111" name="fdata[access][dashboard]">
                        <?php
                        foreach ($manageAccess as $val) {
                            echo '<input type="hidden" value="000" name="fdata[access][' . $val[1] . ']">';
                        }
                        ?>
                    </div>
                    <br>
                    <div class='row bold p-l-20' style="font-weight: 700;">
                        <div class="col-sm-6" style="padding-left: 10px;color:#31b0d5;">PAGE</div>
                        <div class="col-sm-2" style="margin-left: -12px;color:#31b0d5;">VIEW</div>
                        <div class="col-sm-2" style="color:#31b0d5;">ADD</div>
                        <div class="col-sm-2" style="color:#31b0d5;">EDIT</div>
                    </div>
                    <hr>
                    <div class='row' style="height: 25vh;overflow-x: hidden;">
                        <?php
                        $i = 0;
                        foreach ($manageAccess as $val) {
                            ?>
                            <div class='row bordered'>
                                <div class="col-sm-6 checkbox p-l-15" style="padding-left:20px;"><?= $val[0] ?></div>
                                <div class="col-sm-2 p-l-25">
                                    <div class="checkbox check-success">
                                        <input type="checkbox" value="100" id="checkbox<?= $i ?>" name="fdata[access][<?= $val[1] ?>]" class="check2 check3 checkrole <?= $val[1] ?>acc">
                                        <label for="checkbox<?= $i++ ?>" style='position: initial;'></label>
                                    </div>
                                </div>
                                <div class="col-sm-2 p-l-25">
                                    <div class="checkbox check-success">
                                        <input type="checkbox" value="110" id="checkbox<?= $i ?>" name="fdata[access][<?= $val[1] ?>]" class="checkadd check3 checkrole <?= $val[1] ?>acc">
                                        <label for="checkbox<?= $i++ ?>" style='position: initial;'></label>
                                    </div>
                                </div>
                                <div class="col-sm-2 p-l-25">
                                    <div class="checkbox check-success">
                                        <input type="checkbox" value="111" id="checkbox<?= $i ?>" name="fdata[access][<?= $val[1] ?>]" class="checkall checkrole <?= $val[1] ?>acc">
                                        <label for="checkbox<?= $i++ ?>" style='position: initial;'></label>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-4 m-t-10 sm-m-t-10 pull-right">
                            <button type='submit' class="btn btn-primary btn-block m-t-5" style="margin-left:71px;" id='add_user'>Add</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>