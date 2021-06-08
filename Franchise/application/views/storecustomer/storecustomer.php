
<style>
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    .imageborder{
        border-radius: 50%;
    }
    .btn{
        border-radius: 25px !important;
        width: 115px !important;
    }


    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>
<script>

    function getCustomer()
    {
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/StoreCustomer/getCustomerCount",
            type: "POST",
            dataType: 'json',
            async: true,
            success: function (response)
            {
               // $('.rejectedDriverCount').text(response.data.Rejepted);
                //$('.acceptedDriverCount').text(response.data.Approved);
                $('.appcustomer').text(response.data.appcustomer);
                $('.addedbystore').text(response.data.addedbystore);
            }
        });
    }
    $(document).ready(function () {
    $('.StoreCustomer').addClass('active');


        var status = '<?php echo $status; ?>';



        $('#deactivateNoReason').click(function () {
            if ($('#deactivateNoReason').is(':checked')) {
                $('#deactivateReason').val("");
                $('#deactivateReason').hide();
                $('#reasonLabel').hide();
                $('#confirmed').prop('disabled', false);
            } else {
                $('#deactivateReason').val("");
                $('#deactivateReason').show();
                $('#reasonLabel').show();
                $('#confirmed').prop('disabled', true);
            }
//            $('#deactivateReason').val("");
//            $('#deactivateReason').hide();
//            $('#reasonLabel').hide();
//            $('#confirmed').prop('disabled', false);
        });
        $('#deactivateReason').focus(function () {
            $('#confirmed').prop('disabled', false);
        });
        $('#confirmed').prop('disabled', true);
        getCustomer();

        $(document).on('click', '.deviceInfo', function ()
        {
            $('.make').text($(this).attr('make'));
            $('.model').text($(this).attr('model'));
            $('.os').text($(this).attr('os'));
            $('.lastLoginDate').text($(this).attr('last_active_dt'));
            $('.pushToken').text($(this).attr('push_token'));
            $('#deviceInfoPopUp').modal('show');

        });

        if (status == 1)
        {
            $('#inactive').hide();
            $('#active').show();

        }
        if (status == 0)
        {
            $('#inactive').show();
            $('#active').hide();

        }



        $("#define_page").html("Passengers");

        $('.passengers').addClass('active');
        $('.passengers').attr('src', "<?php echo base_url(); ?>/theme/icon/passanger_on.png");
//        $('.passengers_thumb').addClass("bg-success");


        var table = $('.tableWithSearch1');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "sPaginationType": "bootstrap",
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 20,
            "order": [[0, "desc"]]
        };
        table.dataTable(settings);

//         $('#search-table').keyup(function() {
//                table.fnFilter($(this).val());
//            });


        $('#btnStickUpSizeToggler').click(function () {
            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });



            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select a customer to reset the password");
            } else if (val.length > 1) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select only one customer to reset the password");
            } else
            {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#myModal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#myModal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

            }
        });
        $('#devicelog').click(function ()
        {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            console.log(val);
            if (val.length == 0) {
                $("#display-data").text("Please select a customer");
            } else if (val.length > 1)
            {
                $("#display-data").text("");
            } else
            {
                var devices_tbl = $('#devices_datatable').DataTable(device_settings);
                devices_tbl.clear().draw();
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/storeCustomer/get_device_logs/2",
                    type: 'POST',
                    data: {o_id: val[0]},
                    dataType: 'JSON',
                    success: function (result) {

                        $.each(result.data, function (ind, val) {
//                            console.log(val);
                            if (val.DeviceType != 3)
                                devices_tbl.row.add([
                                    val.DeviceMake + " " + val.DeviceModel,
                                    val.Os,
                                    val.AppVersion,
                                    val.DeviceToken,
                                    //                                '<p data-toggle="tooltip" data-placement="top"  title="' + val.DeviceToken + '">' + val.DeviceToken.substring(0,8) + '....</p>',
                                    val.LastOnline
                                ]).draw();
                        });
                        $('.checkbox:checked').each(function (i) {
                            $('#d_name_history').html($(this).closest('tr').find('td:eq(1)').html());
                        });
                        $('[data-toggle="tooltip"]').tooltip();
                        $('#modal_device_logs').modal('show');
                    },
                    error: function () {
                        alert('Problem occurred please try agin.');
                    },
                    timeout: 30000
                });
            }
        });

        //Delete a passenger
        $('#delete_passenger').click(function ()
        {


            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length > 0) {

                //      if (confirm("Are you sure to inactive " + val.length + " passengers"))
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#delete_pass');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#delete_pass').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }


                $("#conform_delete").click(function () {
                    $(".close").trigger('click');

                    $.ajax({
                        url: "<?php echo base_url('index.php?/StoreCustomer') ?>/deletepassengers",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {
                            if (result) {
                                getCustomer();
                                var table = $('#big_table');
                                var searchInput = $('#search-table');
                                searchInput.hide();
                                table.hide();
                                $('.cs-loader').show();
                                setTimeout(function () {
                                    $('#big_table_processing').show();
                                    var settings = {
                                        "autoWidth": false,
                                        "sDom": "<'table-responsive't><'row'<p i>>",
                                        "destroy": true,
                                        "scrollCollapse": true,
                                        "iDisplayLength": 20,
                                        "bProcessing": true,
                                        "bServerSide": true,
                                        "sAjaxSource": '<?php echo base_url() ?>index.php?/StoreCustomer/dt_passenger/' + status,
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
                            }
                        }
                    });


                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Select at least one customer to delete');
            }

        });
        $(document).on('click', '.deviceLogsICON', function ()
        {
            var val = $(this).val();

            var id = $(this).val();
//            alert(id);
            if (val)
             {
                $('#device_log_data').empty();
                $.ajax({
                    url: "<?php echo base_url('index.php?/StoreCustomer') ?>/getDeviceLogs/customer",
                    type: "POST",
                    data: {slave_id: id},
                    dataType: 'json',
                    success: function (result)
                    {
                        console.log(result.data);
                        var html = '';
                        var deviceType = '';
                        $('#d_name_history').text(result.user.name)
                        $.each(result.data, function (index, logs) {
                            if (logs.deviceType == 1) {
                                deviceType = 'IOS';
                            } else if (logs.deviceType == 2) {
                                deviceType = 'ANDRIOD';
                            } else {
                                deviceType = 'WEB';
                            }
                            var date = new Date(logs.lastLogin * 1000);
//                            deviceType = logs.deviceType == 1 ? 'IOS' : 'ANDRIOD';
                            html = "<tr>";
                            html += "<td>" + deviceType + "</td>";
                            html += "<td>" + logs.appVersion + "</td>";
                            html += "<td>" + logs.deviceMake + "</td>";
                            html += "<td>" + logs.deviceModel + "</td>";
                            html += "<td>" + logs.deviceId + "</td>";
                            html += "<td>" + logs.pushToken + "</td>";
//                            html += "<td>" + moment(logs.lastLogin).format("DD-MM-YYYY HH:mm:ss") + "</td>";
                            html += "<td>" + date + "</td>";

                            html += "</tr>";
                            $('#device_log_data').append(html);

                        });

                    }
                });

                $('#deviceLogPopUp').modal('show');
            }
        });

        $("#insertpass").click(function () {

            $("#errors").text("");
            var newpass = $(".newpass").val();
            var confirmpass = $(".confirmpass").val();
            var reg = /^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])\S*$/;    //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;



            if (newpass == "" || newpass == null)
            {
//                alert("please enter the new password");
                $("#errorspass").text("Please enter a new password");
            } else if (confirmpass != newpass)
            {
                //  alert("please confirm the same password");
                $("#errorspass").text("Please re-enter the password");
            } else
            {

                $.ajax({
                    url: "<?php echo base_url('index.php?/StoreCustomer') ?>/insertpass",
                    type: 'POST',
                    data: {
                        newpass: newpass,
                        val: $('.checkbox:checked').val()
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                        $(".close").trigger("click");

                        var size = $('input[name=stickup_toggler]:checked').val()
                        var modalElem = $('#confirmmodels');
                        if (size == "mini")
                        {
                            $('#modalStickUpSmall').modal('show')
                        } else
                        {
                            $('#confirmmodels').modal('show')
                            if (size == "default") {
                                modalElem.children('.modal-dialog').removeClass('modal-lg');
                            } else if (size == "full") {
                                modalElem.children('.modal-dialog').addClass('modal-lg');
                            }
                        }
                        if (response.flag == 1) {
                            $("#errorboxdatas").text("Your new password has been successfully updated");
                            $("#confirmeds").hide();
                            $(".newpass").val("");
                            $(".confirmpass").val("");
                        }

                    }

                });
            }

        });

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });
        var identityCard = '';
        var mmjCard = '';
        $("#active").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                identityCard = $(this).attr('idcard');
                mmjCard = $(this).attr('imgmmj');

                return this.value;
            }).get();


            if (val.length == 1) {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodels');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#confirmmodels').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas").text("Are you sure you wish to approve the customer ?");

                $("#confirmeds").click(function () {

                    var urlChunksBan = $("li.active").find('.changeMode').attr('data').split('/');
                    var statusBan = urlChunksBan[urlChunksBan.length - 1];
                    var ban = '';
                    if (statusBan == 3 || statusBan == '3') {
                        ban = 'approveFromBan';
                    } else {
                        ban = '';
                    }
                    $.ajax({
                        url: "<?php echo base_url('index.php?/StoreCustomer') ?>/activepassengers",
                        type: "POST",
                        data: {val: val, identityCard: identityCard, mmjCard: mmjCard,ban:ban},
                        dataType: 'json',
                        success: function (result)
                        {
                            if (result.flag == 0) {
                                $('#confirmmodels').modal('hide');
                                var table = $('#big_table');
                                var searchInput = $('#search-table');
                                searchInput.hide();
                                table.hide();

                                $('#3').removeClass('active');
                                $('#4').addClass('active');
                                $('#5').removeClass('active');
                                $('#6').removeClass('active');
                                getCustomer();
                                $('#inactive').show();
                                $('#active').hide();
                                $('.cs-loader').show();
                                $('#3').removeClass('active');
                                $('#4').addClass('active');
                                $('#5').removeClass('active');
                                $('#6').removeClass('active');
                                setTimeout(function () {
                                    $('#big_table_processing').show();
                                    var settings = {
                                        "autoWidth": false,
                                        "sDom": "<'table-responsive't><'row'<p i>>",
                                        "destroy": true,
                                        "scrollCollapse": true,
                                        "iDisplayLength": 20,
                                        "bProcessing": true,
                                        "bServerSide": true,
                                        "sAjaxSource": '<?php echo base_url() ?>index.php?/StoreCustomer/dt_passenger/2',
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
                            } else if (result.flag == 1) {
                                $('#confirmmodels').modal('hide');
                                $('#alertForNoneSelected').modal('show');
                                $("#display-data").text('Please add both the cards (MMJ & Identity) ');
                            }
                        }
                    });
                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Select at least one customer to activate');
            }

        });
        $("#activeRejected").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 1) {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodels');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#confirmmodels').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas").text("Are you sure you wish to activate the customer ?");

                $("#confirmeds").click(function () {

                    $.ajax({
                        url: "<?php echo base_url('index.php?/StoreCustomer') ?>/activateRejectedCustomer",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {
                            $('#confirmmodels').modal('hide');

                            var table = $('#big_table');
                            var searchInput = $('#search-table');
                            searchInput.hide();
                            table.hide();
                            $('.cs-loader').show();
                            $('#3').removeClass('active');
                            $('#4').addClass('active');
                            $('#5').removeClass('active');
                            $('#6').removeClass('active');
                            getCustomer();

                            setTimeout(function () {
                                $('#big_table_processing').show();
                                var settings = {
                                    "autoWidth": false,
                                    "sDom": "<'table-responsive't><'row'<p i>>",
                                    "destroy": true,
                                    "scrollCollapse": true,
                                    "iDisplayLength": 20,
                                    "bProcessing": true,
                                    "bServerSide": true,
                                    "sAjaxSource": '<?php echo base_url() ?>index.php?/StoreCustomer/dt_passenger/1',
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
                        }
                    });
                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Select at least one customer to activate');
            }

        });

        $("#inactive").click(function () {
            $('#deactivateReason').show();
            $('#deactivateNoReason').attr('checked', false);


            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 1) {

                //      if (confirm("Are you sure to inactive " + val.length + " passengers"))
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodel');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#confirmmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#inactiveData").text("Are you sure you wish to deactivate the selected customer ?");

                $("#confirmed").click(function () {

                    if (val == '') {
                        alert('Please select  atleast one passenger in the list');
                    } else {
                        $(".close").trigger('click');
                        $.ajax({
                            url: "<?php echo base_url() ?>index.php?/StoreCustomer/rejectCustomers",
                            type: "POST",
                            data: {pass_id: val, reason: $('.reason').val()},
                            dataType: "JSON",
                            success: function (result) {

                                $('.checkbox:checked').each(function (i) {
                                    $(this).closest('tr').remove();
                                });
                                getCustomer();
                                $(".close").trigger('click');
                                var table = $('#big_table');
                                var searchInput = $('#search-table');
                                searchInput.hide();
                                table.hide();
                                $('#inactive').show();
                                $('#active').hide();
                                $('.cs-loader').show();
                                $('#3').removeClass('active');
                                $('#4').removeClass('active');
                                $('#5').removeClass('active');
                                $('#6').addClass('active');

                                setTimeout(function () {

                                    $('#big_table_processing').show();
                                    var settings = {
                                        "autoWidth": false,
                                        "sDom": "<'table-responsive't><'row'<p i>>",
                                        "destroy": true,
                                        "scrollCollapse": true,
                                        "iDisplayLength": 20,
                                        "bProcessing": true,
                                        "bServerSide": true,
                                        "sAjaxSource": '<?php echo base_url() ?>index.php?/StoreCustomer/dt_passenger/1',
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

                            }
                        });

                    }
                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Select at least one customer to deactivate');
            }

        });


        $("#ban").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 1) {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#banModal');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#banModal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas1").text("Are you sure you wish to ban the customer ?");

                $("#yesBan").click(function () {

                    $.ajax({
                        url: "<?php echo base_url('index.php?/StoreCustomer') ?>/banCustomer",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {
                            $('#banModal').modal('hide');
                            var table = $('#big_table');
                            var searchInput = $('#search-table');
                            searchInput.hide();
                            table.hide();
                            $('.cs-loader').show();
                            $('#3').removeClass('active');
                            $('#4').removeClass('active');
                            $('#6').removeClass('active');
                            $('#5').addClass('active');

                            $('#inactive').hide();
                            $('#active').show();
                            $('#ban').show();
                            getCustomer();
                            setTimeout(function () {
                                $('#big_table_processing').show();
                                var settings = {
                                    "autoWidth": false,
                                    "sDom": "<'table-responsive't><'row'<p i>>",
                                    "destroy": true,
                                    "scrollCollapse": true,
                                    "iDisplayLength": 20,
                                    "bProcessing": true,
                                    "bServerSide": true,
                                    "sAjaxSource": '<?php echo base_url() ?>index.php?/StoreCustomer/dt_passenger/3',
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
                        }
                    });
                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Select at least one customer to ban');
            }

        });



// Change Password 
        $('#changePassword').click(function (event) {
            $('#adminUpdateUserNewPassword').val("");
            $('#adminUpdateUserConfirmPassword').val("");
            $("#passwordUpdateError").removeClass('hide');
            var userId = $('input[name=checkbox]:checked').val();
            if (userId == undefined) {
                $("#changePasswordErrorPopUp").modal();
                return;
            } else {
                // changePasswordSubmit
                $('#changePasswordSubmit').attr('data-id', userId); //setter
                $("#changePasswordPopUp").modal();
            }
        });

        $('#changePasswordSubmit').click(function (evnet) {
            $(".passwordUpdateError").addClass('hide');
            var newPassword = $('#adminUpdateUserNewPassword').val();
            var confirmPassword = $('#adminUpdateUserConfirmPassword').val();
            if (newPassword.length === 0 || $('#adminUpdateUserNewPassword').val() == '' || $('#adminUpdateUserNewPassword').val() == null) {
                $("#passwordUpdateMesssage").text('Please enter the password');
                $(".passwordUpdateError").removeClass('hide');
            } else if (confirmPassword == '' || confirmPassword == null || confirmPassword.length === 0) {
                $("#passwordUpdateMesssage").text('Please enter the confirm password');
                $(".passwordUpdateError").removeClass('hide');
            } else if (confirmPassword.length < 6 || newPassword.length < 6) {
                $("#passwordUpdateMesssage").text('Please enter minimum 6 characters');
                $(".passwordUpdateError").removeClass('hide');
            } else if (newPassword == confirmPassword) {
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/StoreCustomer/adminUpdateUserPassword",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        userId: $('input[name=checkbox]:checked').val(),
                        password: $('#adminUpdateUserNewPassword').val()
                    },
                })
                        .done(function (json) {
                            console.log(json);
                            if (json.msg === "success") {
                                $("#changePasswordPopUp").modal('hide');
                                $('#alertForNoneSelected').modal('show');
                                $('#display-data').text('Password changed successfully... ');


                            } else {
                                $("#passwordUpdateMesssage").text('Unable to update password');
                                $(".passwordUpdateError").removeClass('hide');
                            }

                        });
            } else {
                $("#changePasswordPopUp").modal('hide');
                $('#alertForNoneSelected').modal('show');
                $('#display-data').text('Password mismatch');
            }

        });

    });


</script>

<script type="text/javascript">
    $(document).ready(function () {
        var status = '<?php echo $status; ?>';

        if (status == 0) {
            $('#inactive').show();
            $('#active').hide();
            $('#btnStickUpSizeToggler').show();
            $("#display-data").text("");
        }

        $('.whenclicked li').click(function () {
            // alert($(this).attr('id'));
            if ($(this).attr('id') == 3) {
                $('#inactive').show();
                $('#active').hide();
                $('#btnStickUpSizeToggler').show();
                $("#display-data").text("");

            } else if ($(this).attr('id') == 1) {
                $('#inactive').hide();
                $('#active').show();
                $('#btnStickUpSizeToggler').show();
                $("#display-data").text("");
            }


        });

        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {
            $('#big_table_processing').show();
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/StoreCustomer/dt_passenger/' + status,
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

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $(document).on('click', '.customerDetails', function ()
        {
            $('.Name').text($(this).attr('name'));
            $('.Phone').text($(this).attr('phone'));
            $('.Email').text($(this).attr('email'));
            $('.accountType').text($(this).attr('accountType'));
            $('#customerDetailsPopUP').modal('show');
        });



        $('.changeMode').click(function () {
            $('.cs-loader').show();
            var table = $('#big_table');
            $('#big_table_processing').show();
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": $(this).attr('data'),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {

                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
                    $('#big_table_processing').hide();
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
                },

            };

            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');





            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });



        });

        $('#big_table').on('init.dt', function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            var forwhat = urlChunks[urlChunks.length - 2];

            if (status == 0) {
               // $('#big_table').dataTable().fnSetColumnVis([6, 8, 9, 10], false);
               // $('#inactive').show();
                //$('#activeRejected').hide();
                // $('#active').show();
                // $('#ban').hide();

            }
            if (status == 1) {
                $('#big_table').dataTable().fnSetColumnVis([7,8,9], false);
                $('#activeRejected').hide();
                $('#active').show();
                $('#inactive').hide();
                $('#ban').hide();

            }
           /* if (status == 2) {
                $('#big_table').dataTable().fnSetColumnVis([8, 9, 10], false);
                $('#ban').show();
                $('#activeRejected').hide();
                $('#inactive').hide();
                $('#active').hide();

            }
            if (status == 3) {
                $('#big_table').dataTable().fnSetColumnVis([5, 6, 7, 8, 10], false);
                $('#activeRejected').hide();
                $('#active').show();
                $('#ban').hide();
                $('#inactive').hide();
            } */

        });
//

    });
</script>

<link
    href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css"
    rel="stylesheet" type="text/css" />

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content" >

        <!-- <div class="brand inline" style="  width: auto;            
             color: gray;
             margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;">REGISTERED CUSTOMERS</strong>
        </div> -->
        <div class="brand inline" style="  width: auto;">
            <?php echo str_replace('_', ' ', $pageTitle); ?> registered customers
        </div>

        <div id="test"></div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">

            <li id="3" class="tabs_active <?php echo ($status == 0 ? "active" : ""); ?>" style="cursor:pointer">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/StoreCustomer/dt_passenger/0"><span>App Customers</span><span class="badge appcustomer" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id="4" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/StoreCustomer/dt_passenger/1"><span> Added by Stores </span> <span class="badge addedbystore" style="background-color:#3CB371;"></span></a>
            </li>
            <!-- <li id="5" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/customer/dt_passenger/3"><span>Ban</span> <span class="badge banDriverCount" style="background-color:#f0ad4e;"></span></a>
            </li>
            <li id="6" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/customer/dt_passenger/1"><span>Rejected</span> <span class="badge rejectedDriverCount" style="background-color:#B22222;"></span></a>
            </li>
           <li id="7" class="tabs_active <?php echo ($status == 4 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/customer/dt_passenger/1"><span>Rejected</span> <span class="badge rejectedDriverCount" style="background-color:#B22222;"></span></a>
            </li>-->

        <!--
            <div class="pull-right m-t-10 new_button" > <button class="btn btn-danger btn-cons" id="delete_passenger" >Delete</button></div>

            <div class="pull-right m-t-10 new_button" > <button class="btn btn-warning btn-cons" id="inactive" >Reject</button></div>
            <div class="pull-right m-t-10 new_button"><button class="btn btn-info" id="deviceLogs">Device Logs</button></div>

            <div class="pull-right m-t-10 new_button"> <button class="btn btn-success btn-cons" id="active">Approve</button></a></div>
            <div class="pull-right m-t-10 new_button"> <button class="btn btn-success btn-cons" id="activeRejected">Activate</button></a></div>
            <div class="pull-right m-t-10 new_button"> <button class="btn btn-warning btn-cons" id="ban">Ban</button></a></div>
            <div class="pull-right m-t-10 new_button"> <button class="btn btn-primary btn-cons" id="changePassword">Change Password</button></a></div>
            -->
        </ul>
        <!-- Tab panes -->
        <!-- START JUMBOTRON -->
        <div class="parallax" data-pages="parallax">
            <div class="col-xs-12 container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="row panel panel-transparent ">

                    <div class="tab-content">
                        <div class="col-xs-12 container-fixed-lg bg-white">
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

                                    <div class="searchbtn row clearfix pull-right" >

                                        <div class="pull-right col-xs-12"><input type="text" id="search-table" class="form-control pull-right"  placeholder="Search"> </div>
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


<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div style="padding:0;" class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3 style="font-size:16px;">CUSTOMER DETAILS</h3>
                </div>


                <br>
                <br>

                <div class="modal-body">




                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"> USERNAME<span style="color:red;font-size: 18px">*</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="newpass" name="latitude"  class="newpass form-control error-box-class" placeholder="eg:g3Ehadd">
                        </div>
                    </div>

                    <br>
                    <br>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"> EMAIL<span style="color:red;font-size: 18px">*</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="newpass" name="latitude"  class="newpass form-control error-box-class" placeholder="eg:g3Ehadd">
                        </div>
                    </div>

                    <br>
                    <br>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label">PHONE<span style="color:red;font-size: 18px">*</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="newpass" name="latitude"  class="newpass form-control error-box-class" placeholder="eg:g3Ehadd">
                        </div>
                    </div>

                    <br>
                    <br>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label">BUSINESS NAME<span style="color:red;font-size: 18px">*</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="newpass" name="latitude"  class="newpass form-control error-box-class" placeholder="eg:g3Ehadd">
                        </div>
                    </div>

                    <br>
                    <br>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label">ADDRESS<span style="color:red;font-size: 18px">*</span></label>
                        <div class="col-sm-6">
                            <input type="text"  id="confirmpass" name="longitude" class="confirmpass form-control error-box-class" placeholder="H3dgsk">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4 error-box" id="errorspass" ></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="insertpass" >Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
    </button>
</div>

<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="">
                <span class="modal-title" style="color:#337ab7;">DEACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="inactiveData"></div>
                    <div class="row">
                        <label id="reasonLabel" style="margin-left:20px">Reason</label>
                        <input type="text" style="margin-left:20px;width: 90% !important;" id="deactivateReason" name="deactivateReason" class="form-control reason"/>
                    </div>
                    <div class="row"></div>
                    <div class="row">

                        <input type="checkbox" style="margin-left:20px" id="deactivateNoReason" name="deactivateNoReason" class="reason"/>
                        <label>Do not prefer to specify the reason..!!</label>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                        <button type="button" class="btn btn-warning pull-right" id="confirmed" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="alertForNoneSelected" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="">
                <span class="modal-title" style="color:#337ab7;">Alert</span>
                <button type="button" class="close title" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="display-data"></div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
</button>


<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">ACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdatas" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                        <button type="button" class="btn btn-success pull-right" id="confirmeds" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="banModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Ban</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdatas1" style="text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                        <button type="button" class="btn btn-success pull-right" id="yesBan" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="delete_pass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" style="color:#337ab7;">ALERT</span>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="delete-data" >Are you sure you want to delete the customer?</div>

                </div>
            </div>


            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <button type="button" data-dismiss="modal" class="btn btn-default" id="deleteModalCancel">Cancel</button>
                        <button type="button" class="btn btn-primary pull-right" id="conform_delete" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="deviceLogPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">DEVICE INFO</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body form-horizontal">
                <div class="row">
                    <span style="color:#738092;font-weight:700;margin-left: 10px;">Customer Name : <span id="d_name_history" style="color:#1ABB9C;"></span></span>
                </div>
                <br>
                <div class="table-responsive">
                    <table class='table table-striped table-bordered table-hover demo-table-search' id="devices_datatable">
                        <thead>
                        <th >DEVICE TYPE</th>
                        <th style="">APP VERSION</th>
                        <th style="">DEVICE MAKE</th>
                        <th style="">DEVICE MODEL</th>
                        <th style="">DEVICE ID</th>
                        <th style="">PUSH TOKEN</th>
                        <th style="">LAST LOGGED IN DATE</th>
                        </thead>


                        <tbody id="device_log_data">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4" ></div>
                <div class="col-sm-8" >
                    <button type="button" data-dismiss="modal" class="btn btn-default pull-right" id="deleteModalCancel">Cancel</button>

                </div>
            </div>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<div class="modal fade stick-up" id="customerDetailsPopUP" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">CUSTOMER DETAILS</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">


                <div class="form-group row" style="  margin-left: 7%;">
                    <label for="address" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-6">
                        <span class="Name"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label for="address" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-6">
                        <span class="Email"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label for="address" class="col-sm-3 control-label">Phone</label>
                    <div class="col-sm-6">
                        <span class="Phone"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label for="address" class="col-sm-3 control-label">Business Name</label>
                    <div class="col-sm-6">
                        <span class="accountType"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label for="address" class="col-sm-3 control-label">Address</label>
                    <div class="col-sm-6">
                        <span class="address"></span>
                    </div>
                </div>


            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="changePasswordPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="padding-bottom: 35px">

            <div class="modal-header">
                <span class="modal-title">Change Password</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="form-group row" style="  margin-left: 7%;">
                    <label for="address" class="col-sm-3 control-label" style="margin-top:10px;">New Password<span class="MandatoryMarker">*</span></label>
                    <div class="col-sm-6">
                        <input type="text"  id="adminUpdateUserNewPassword" class="newpass form-control error-box-class">
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label for="address" class="col-sm-3 control-label" style="margin-top:10px;">Confirm Password<span class="MandatoryMarker">*</span></label>
                    <div class="col-sm-6">
                        <input type="text"  id="adminUpdateUserConfirmPassword" class="newpass form-control error-box-class">
                    </div>
                </div>
                <div class="form-group row passwordUpdateError hide" style="  margin-left: 7%;">
                    <span style="margin-left: 190px; color: red" id="passwordUpdateMesssage"></span>
                </div>

            </div>
            <div class="modal-footer">
                <div class="col-sm-4"></div>
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-success pull-right" data-id="" id="changePasswordSubmit" style=" border-radius: 25px;" >Change</button>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="changePasswordErrorPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="">
                <span class="modal-title" style="color:#337ab7;">Message</span>
                <button type="button" class="close title" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText">Please select the customer</div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

