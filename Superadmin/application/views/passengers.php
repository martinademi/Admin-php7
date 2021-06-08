<style>
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
        height: 16px;
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
<style>
    input[type=checkbox]{
        margin: 4px 4px 1px 4px;
    }
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    .imageborder{
        border-radius: 50%;
    }
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    span.abs_text {
        position: absolute;
        right:10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>
<script>
    var tabURL;
    var referredCount;
    var status = '<?php echo $status; ?>';
    function getCustomer()
    {
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/superadmin/getCustomerCount",
            type: "POST",
            dataType: 'json',
            async: true,
            success: function (response)
            {
                $('.rejectedDriverCount').text(response.data.Rejepted);
                $('.unregisteredDriverCount').text(response.data.unregistered);
                $('.acceptedDriverCount').text(response.data.Accepted);
            }
        });
    }
    function isNumberKey(evt)
    {
//        $("#timeForacceptBookingErr").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
            return false;
        }
        return true;
    }
    $(document).ready(function () {


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

        if (status == 4)
        {
            $('#inactive').hide();
            $('#active').show();

        }

        $('.number').keypress(function (event) {
            if (event.which < 46
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if (event.which == 46
                    && $(this).val().indexOf('.') != -1) {
                event.preventDefault();
            } // prevent if already dot
        });

        $('.resetPasword').click(function ()
        {
            if ($(this).val() == 3)
            {
                $('#resetByEmail').attr('checked', false);
                $('#resetByMobile').attr('checked', false);
            } else {
                $('#resetByBoth').attr('checked', false);

                if ($(this).attr('id') == 'resetByEmail')
                    $('#resetByMobile').attr('checked', false);
                else
                    $('#resetByEmail').attr('checked', false);

            }
        });
        $('#resetPassordButton').click(function ()
        {
            $('.errors').text('');
            if (!$('.resetPasword').is(':checked'))
            {

                $(".resetPaswordErr").text('Please select an option to reset the password');
            } else {


            }

        });


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

        $(document).on('click', '.getCustomerReferralsList', function ()
        {
            referredCount = $(this).attr('customerReferralCount');

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getCustomerReferralsList",
                type: "POST",
                data: {slave_id: $(this).attr('slave')},
                dataType: 'json',
                success: function (result) {

                    var html;
                    $('#table_body').empty();
                    $('.referredCustomerCount').text(referredCount);

                    if (result.customerData && result.customerData != null)
                    {
                        $.each(result.customerData, function (index, row)
                        {
                            if (row != null) {
                                html += "<tr><td style='text-align: center;'>" + row.name + "</td>"
                                html += "</td><td style='text-align: center;'>" + row.phone + "</td>"
                                html += "</td><td style='text-align: center;'>" + row.email + "</td>"
                                html += "</td><td style='text-align: center;'>" + row.referralcode + "</td>"

                                html += "</tr>";
                                $('#table_body').append(html);
                            }
                        });
                    }

                    $('#getCustomerReferralsList').modal('show');

                }
            });
        });


        $('#btnStickUpSizeToggler').click(function () {
            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_PASSENGERS_ANYONEPASS); ?>);
            } else if (val.length > 1) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_PASSENGERS_ONLYONEPASS); ?>);
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

        $(document).on('change', '.switch', function ()
        {

             tabURL = $('li.active').children("a").attr('data');
            var isEnable = 0;
            if ($('#' + $(this).attr('data-id')).is(':checked'))
                isEnable = 1;

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/enDisCreditCustomer",
                type: "POST",
                data: {slave_id: $(this).attr('data-id'), flag: isEnable},
                dataType: 'json',
                success: function (result) {
                    refreshContent(tabURL);
                }
            });
        });

        $(document).on('click', '.walletSettings', function ()
        {
            customerID = $(this).attr('slaveID');
            $(".errors").text("");
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/getWalletForShipper",
                type: "POST",
                data: {pass_id: $(this).attr('slaveID')},
                dataType: "JSON",
                success: function (result) {
                    //Reset the fields
                    $('#softLimitForShipper').val('');
                    $('#hardLimitForShipper').val('');

                    if (result.flag == 0)
                    {
                        $('#softLimitForShipper').val(result.data.walletSoftLimit);
                        $('#hardLimitForShipper').val(result.data.walletHardLimit)
                    } else {
                        $('#softLimitForShipper').val(result.data.walletSettings.softLimitShipper);
                        $('#hardLimitForShipper').val(result.data.walletSettings.hardLimitShipper)
                    }
                }
            });
            $('#walletSettingsPopUp').modal('show');

        });
        $("#creditSubmit").click(function () {
             tabURL = $('li.active').children("a").attr('data');

            if ($('#softLimitForShipper').val() == '')
                $('.softLimitForShipperErr').text('Soft limit should not be empty');
            else if ($('#hardLimitForShipper').val() == '')
                $('.hardLimitForShipperErr').text('Hard limit should not be empty');
            else if (parseInt($('#hardLimitForShipper').val()) < parseInt($('#softLimitForShipper').val()) || parseInt($('#hardLimitForShipper').val()) == parseInt($('#softLimitForShipper').val()))
                $('.hardLimitForShipperErr').text('Hard limit should be greater than soft limit');
            else {

                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/superadmin/walletUpdateForShipper",
                    type: "POST",
                    data: {pass_id: customerID, softLimit: $('#softLimitForShipper').val(), hardLimit: $('#hardLimitForShipper').val()},
                    dataType: "JSON",
                    success: function (result) {
                         $(".close").trigger('click');
                        refreshContent(tabURL);
                       
                    }
                });

            }
        });

        $('#big_table').on('init.dt', function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];

            if (status == 5)
                $('#big_table').dataTable().fnSetColumnVis([0, 4, 5, 6, 7, 8, 9, 10], false);
        });



        $('#devicelog').click(function ()
        {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            console.log(val);
            if (val.length == 0) {
                $("#display-data").text(<?php echo json_encode(POPUP_PASSENGERS_ATLEAST); ?>);
            } else if (val.length > 1)
            {
                $("#display-data").text(<?php echo json_encode(POPUP_PASSENGERS_ONLYEDIT); ?>);
            } else
            {
                var devices_tbl = $('#devices_datatable').DataTable(device_settings);
                devices_tbl.clear().draw();
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/superadmin/get_device_logs/2",
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
                    tabURL = $('li.active').children("a").attr('data');

                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/deletepassengers",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {
//                            $('.checkbox:checked').each(function (i) {
//                                $(this).closest('tr').remove();
//                            });
$(".close").trigger('click');
                            refreshContent(tabURL);
                            
                        }
                    });


                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode('Select at least one customer to delete'); ?>);
            }

        });

        $('#deviceLogs').click(function ()
        {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0)
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select one customer to get device logs');
            } else if (val.length > 1)
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select only one customer to get device logs');
            } else {
                $('#device_log_data').empty();
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getDeviceLogs/customer",
                    type: "POST",
                    data: {slave_id: $('.checkbox:checked').val()},
                    dataType: 'json',
                    success: function (result)
                    {

                        var html = '';
                        var deviceType = '';
                        $('#d_name_history').text(result.data.name)
                        $.each(result.data.devices, function (index, logs) {
                            deviceType = '-';
                            if (logs.deviceType != 0 && logs.deviceType != "")
                            {
                                if (logs.deviceType == 1)
                                    deviceType = 'IOS';
                                else if (logs.deviceType == 2)
                                    deviceType = 'ANDRIOD';
                            }
//                                         deviceType = logs.deviceType == 1?'IOS':'ANDRIOD';
                            html = "<tr>";
                            html += "<td>" + deviceType + "</td>";
                            html += "<td>" + logs.appversion + "</td>";
                            html += "<td>" + logs.devMake + "</td>";
                            html += "<td>" + logs.devModel + "</td>";
                            html += "<td>" + logs.deviceId + "</td>";
                            html += "<td><span class='pushTokenShortShow'>" + logs.pushToken + "</span></td>";
                            html += "<td>" + moment(logs.serverTime['$date']).format("DD-MM-YYYY HH:mm:ss") + "</td>";

                            html += "</tr>";
                            $('#device_log_data').append(html);

                        });

                    }
                });

                $('#deviceLogPopUp').modal('show');
            }
        });
        $('#resetPassword').click(function ()
        {
            $('.errors').text('');
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0)
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select one customer to reset password');
            } else if (val.length > 1)
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select only one customer to reset password');
            } else {
                $('#device_log_data').empty();
                $('#resetPasswordPopUp').modal('show');
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
                $("#errorspass").text(<?php echo json_encode(POPUP_PASSENGERS_PASSNEW); ?>);
            }
//            else if (!reg.test(newpass))
//            {
////                alert("please enter the password with atleast one chareacter and one letter");
//                $("#errorspass").text(<?php echo json_encode(POPUP_PASSENGERS_PASSVALID); ?>);
//            }
//            else if (confirmpass == "" || confirmpass == null)
//            {
////                alert("please confirm the password");
//                $("#errorspass").text(<?php echo json_encode(POPUP_PASSENGERS_PASSCONFIRM); ?>);
//            }
            else if (confirmpass != newpass)
            {
                //  alert("please confirm the same password");
                $("#errorspass").text(<?php echo json_encode(POPUP_PASSENGERS_SAMEPASSCONFIRM); ?>);
            } else
            {

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/insertpass",
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
                            $("#errorboxdatas").text(<?php echo json_encode(POPUP_DRIVERS_NEWPASSWORD); ?>);
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

        $("#confirmed").click(function () {
            var tabURL = $('li.active').children("a").attr('data');
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val == '') {
                alert('Please select  atleast one passenger in the list');
            } else {

                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/superadmin/rejectCustomers",
                    type: "POST",
                    data: {pass_id: val},
                    dataType: "JSON",
                    success: function (result) {

                        if (parseInt(result.apiResponse) > 0)
                        {
                            $('#errorboxdata').text('The customer has on-ongoing trips so please first manage those before you attempt to ban the customer');
                            $('.okButton').hide();
                            $('.closeButton').show();
                        } else {

                            refreshContent(tabURL);
                            $(".close").trigger('click');
                        }


                    }
                });

            }
        });

        $("#inactive").click(function (e) {
            $('.okButton').show();
            $('.closeButton').hide();
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length > 0) {

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
                $("#errorboxdata").text(<?php echo json_encode(POPUP_PASSENGERS_DEACTIVAT); ?>);

            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode('Select at least one customer to deactivate'); ?>);
            }

        });

        $('.closeButton').click(function ()
        {
            $('.close').trigger('click');
        });

        $("#active").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length > 0) {
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
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_PASSENGERS_ACTIVAT); ?>);

                $("#confirmeds").click(function () {

                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/activepassengers",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {

                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });
                            getCustomer();
                            $(".close").trigger('click');
                        }
                    });
                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode('Select at least one customer to activate'); ?>);
            }

        });




    });


</script>

<script type="text/javascript">
    $(document).ready(function () {
        var status = '<?php echo $status; ?>';

        if (status == 3) {
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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/dt_passenger/' + status,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"width": "8%"},
                    {"width": "10%"},
                    null,
                    null,
                    null,
                    null
                ],
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

<?php
if (!$appCofig['walletSettings']['walletShipperEnable']) {
    ?>
                $('#big_table').dataTable().fnSetColumnVis([6, 7], false);
    <?php
}
?>
        }, 1000);







        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });



        $('.changeMode').click(function () {

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

            $('#inactive').hide();
            $('#active').show();



            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });

        });



    });

    function refreshContent(url) {
        getCustomer();

        $('#big_table').hide();
        $('#big_table_processing').show();
        var table = $('#big_table');
        $("#display-data").text("");

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": url,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').show();
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
</script>

<div class="page-content-wrapper"style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content" >

        <div class="brand inline" style="  width: auto;            
             color: gray;
             margin-left: 30px;padding-top: 20px;">
           <!--                    <img src="--><?php //echo base_url();                ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();                ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();                ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="color:#0090d9;">CUSTOMERS</strong><!-- id="define_page"-->
        </div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">

            <li id="3" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?>" style="cursor:pointer">
                <a class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/dt_passenger/3"><span><?php echo LIST_ACCEPTED; ?></span><span class="badge acceptedDriverCount" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id="5" class="tabs_active <?php echo ($status == 5 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/dt_passenger/5"><span>UNREGISTERED</span> <span class="badge unregisteredDriverCount" style="background-color:darkgray;"></span></a>
            </li>
            <li id="4" class="tabs_active <?php echo ($status == 4 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/dt_passenger/4"><span>BANNED</span> <span class="badge rejectedDriverCount" style="background-color:#33312f;"></span></a>
            </li>


            <div class="pull-right m-t-10 new_button cls100"><button class="btn btn-primary" id="deviceLogs">Device Logs</button></div>

            <div class="pull-right m-t-10 new_button cls111" > <button class="btn btn-primary btn-cons" id="resetPassword" style="width:100px;">Reset Password</button></div>
            <div class="pull-right m-t-10 new_button cls111" > <button class="btn btn-primary btn-cons" id="delete_passenger" ><?php echo BUTTON_DELETE_PASSENGER; ?></button></div>

            <div class="pull-right m-t-10 new_button cls111" > <button class="btn btn-primary btn-cons" id="inactive" >Ban</button></div>

            <div class="pull-right m-t-10 new_button cls110"> <button class="btn btn-primary btn-cons" id="active"><?php echo BUTTON_ACTIVE; ?></button></a></div>

        </ul>
        <!-- Tab panes -->
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">

                    <div class="tab-content">
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

                                    <div class="searchbtn row clearfix pull-right" >

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right"  placeholder="<?php echo SEARCH; ?> "> </div>
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
                            <button type="button" class="btn btn-primary pull-right" id="insertpass" ><?php echo BUTTON_SUBMIT; ?></button>
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
                <span class="modal-title">BAN</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-warning pull-right okButton" id="confirmed" >Yes</button>
                        <button type="button" class="btn btn-warning pull-right closeButton"  style="display:none;">Ok</button>
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

                    <div class="error-box" id="errorboxdatas" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-success pull-right" id="confirmeds" ><?php echo BUTTON_YES; ?></button>
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


<div class="modal fade stick-up" id="delete_pass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" style="color:#337ab7;">ALERT</span>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="text-align:center"><?php echo DELETE_PASSENGER; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="conform_delete" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="deviceLogPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                        <span class="custName"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label for="address" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-6">
                        <span class="custEmail"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label for="address" class="col-sm-3 control-label">Phone</label>
                    <div class="col-sm-6">
                        <span class="custPhone"></span>
                    </div>
                </div>
                <div class="form-group row businessNameDiv" style="margin-left: 7%;display:none;">
                    <label for="address" class="col-sm-3 control-label">Business Name</label>
                    <div class="col-sm-6">
                        <span class="custaccountType"></span>
                    </div>
                </div>
                <div class="form-group row addressDiv" style="  margin-left: 7%;display:none;">
                    <label for="address" class="col-sm-3 control-label">Address</label>
                    <div class="col-sm-6">
                        <span class="custaddress"></span>
                    </div>
                </div>


            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="resetPasswordPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">RESET PASSWORD</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <form id="" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label"></label>
                        <div class="col-sm-6 row">
                            <label for="resetByEmail">
                                <input type="checkbox" class="resetPasword" name="resetByEmail" id="resetByEmail"  value="1"/><span>Reset By Email</span>
                            </label>

                        </div>
                        <div class="col-sm-4 error-box" id=""></div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label"></label>
                        <div class="col-sm-6 row">
                            <label for="resetByMobile">
                                <input type="checkbox" class="resetPasword" name="resetByMobile" id="resetByMobile" value="2"/><span>Reset By Phone Number</span>
                            </label>

                        </div>
                        <div class="col-sm-4 error-box" id=""></div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label"></label>
                        <div class="col-sm-6 row">
                            <label for="resetByBoth">
                                <input type="checkbox" class="resetPasword" name="resetByBoth" id="resetByBoth" value="3"/><span>Both</span>
                            </label>
                        </div>
                        <div class="col-sm-4 error-box" id=""></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4 error-box errors resetPaswordErr"></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-success pull-right" id="resetPassordButton" >Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="getCustomerReferralsList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">
                    <span class="modal-title" id="headingFor">REFERRAL DETAILS</span>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>


                <div class="modal-body">
                    <span class="badge referredCustomerCount badge bg-green"></span>
                    <span class="referredCustomerText" style=""> Customers Referred</span>
                    <br>
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:20%;text-align: center;">CUSTOMER NAME</th>
                                <th style="width:20%;text-align: center;">CUSTOMER PHONE</th>
                                <th style="width:20%;text-align: center;">CUSTOMER EMAIL</th>
                                <th style="width:20%;text-align: center;">REFERRAL CODE</th>
                            </tr>
                        </thead>
                        <tbody id="table_body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<div class="modal fade" id="walletSettingsPopUp" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">CREDIT LINE</strong>
            </div>
            <div class="modal-body">
                <form id="" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="form-group">
                        <label for="" class="control-label col-md-3">Soft Limit</label>
                        <div class="col-sm-6">
                            <span  class="abs_text"><b><?php echo $appCofig['currencySymbol']; ?></b></span>
                            <input type="text" class="form-control number" id="softLimitForShipper" name="softLimitForShipper" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $softLimitForShipper; ?>">
                        </div>
                        <div class="col-sm-3 errors softLimitForShipperErr"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-3">Hard Limit</label>
                        <div class="col-sm-6">
                            <span  class="abs_text"><b><?php echo $appCofig['currencySymbol']; ?></b></span>
                            <input type="text" class="form-control number" id="hardLimitForShipper" name="hardLimitForShipper" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $hardLimitForShipper; ?>">
                        </div>
                        <div class="col-sm-3 errors hardLimitForShipperErr"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success pull-right" id="creditSubmit" >Update</button>
            </div>
        </div>

    </div>
</div>
