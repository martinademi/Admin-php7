
<style>
    #companyid{
        display: none;
    }
</style>

<script>
    var tabURL;
    var currentTab = 1;
    $(document).ready(function () {
        $("#define_page").html("Dispatchers");
        $('.dispatches').addClass('active');
        $('.dispatches').attr('src', "<?php echo base_url(); ?>/theme/icon/dispatcher_on.png");


        $('#btnStickUpSizeToggler').click(function () {

            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#myModal');
            $('#addDispatcherForm')[0].reset();
            $('.errors').text('');
            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getManager",
                type: 'GET',
                dataType: 'JSON',
                success: function (response)
                {
                    $('#managerSelectAdd').empty();
                    var HTML = '<option value="">Select</option>';
                    $.each(response.data, function (i, row)
                    {
                        HTML += '<option value="' + row._id.$oid + '" name="' + row.fname + ' ' + row.lname + '">' + row.fname + ' ' + row.lname + '</option>';

                    });

                    $('#managerSelectAdd').append(HTML);
                }
            });



            $('#myModal').modal('show')


        });

        $('#reset_password').click(function () {


            $("#resetNewpass").val('');
            $("#resetConfirmpass").val('');

            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_PASSENGERS_ANYONEPASS); ?>);

            } else if (val.length > 1)
            {

                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_PASSENGERS_ONLYONEPASS); ?>);
            } else
            {
                var size = $('input[name=stickup_toggler]:checked').val();

                var modalElem = $('#resetPasswordModal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#resetPasswordModal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

            }
        });


        $("#editpassDispatcher").click(function () {
            $(".errors").text("");

            var newpass = $("#resetNewpass").val();
            var confirmpass = $("#resetConfirmpass").val();
            var reg = /^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])\S*$/;    //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;


            if (newpass == "" || newpass == null)
            {

//                alert("please enter the new password");
                $("#resetNewPassword").text(<?php echo json_encode(POPUP_PASSENGERS_PASSNEW); ?>);
            }
//            else if (!reg.test(newpass))
//            {
////                alert("please enter the password with atleast one chareacter and one letter");
//                $("#resetNewPassword").text(<?php echo json_encode(POPUP_PASSENGERS_PASSVALID); ?>);
//            }
            else if (confirmpass == "" || confirmpass == null)
            {


//                alert("please confirm the password");
                $("#resetConfirmPassword").text(<?php echo json_encode(POPUP_PASSENGERS_PASSCONFIRM); ?>);
            } else if (confirmpass != newpass)
            {
//                alert("please confirm the same password");
                $("#resetConfirmPassword").text(<?php echo json_encode(POPUP_PASSENGERS_SAMEPASSCONFIRM); ?>);
            } else
            {

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/editpassDispatcher",
                    type: 'POST',
                    data: {
                        newpass: newpass,
                        val: $('.checkbox:checked').val()
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {


                        if (response.flag == 1)
                        {
                            $('#errorpass').text(response.msg);
                        } else {
                            $(".close").trigger('click');
                            $('#responseMsg').text(response.msg);
                            $('#resetPasswordResponse').modal('show');
                        }



                    }

                });
            }

        });


        $("#inactive").click(function () {

            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).
                    get();
            if (val.length > 0) {

                //  if (confirm("Are you sure to inactive " + val.length + " dispatchers"))

                var size = $('input[name=stickup_toggler]:checked').val();

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
                $("#errorboxdata").text(<?php echo json_encode(POPUP_DISPATCHER_SUREINACTIVE); ?>);

                $("#confirmed").click(function () {


                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/inactivedispatchers",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {

                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });
                            $(".close").trigger('click');
                        }
                    });
                });

            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DISPATCHER_INACTIVE); ?>);
            }

        });


        $("#active").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).
                    get();
            if (val.length > 0) {

                // if (confirm("Are you sure to active " + val.length + " dispatchers"))
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
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_DISPATCHER_SUREACTIVE); ?>);

                $("#confirmeds").click(function () {

                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/activedispatchers",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {

                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });

                            $(".close").trigger('click');
                        }
                    });


                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DISPATCHER_ACTIVE); ?>);
            }

        });

        $("#delete").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            console.log(val);
            if (val.length > 0) {

                // if (confirm("Are you sure to active " + val.length + " dispatchers"))
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#conformDelete');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#conformDelete').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_DISPATCHER_SUREACTIVE); ?>);

                $("#con_delete").click(function () {

                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/deletedispatchers",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (result)
                        {

                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });

                            $(".close").trigger('click');
                        }
                    });


                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DISPATCHER_DELETE); ?>);
            }

        });



        $("#btnStickUpSizeToggl").click(function () {
            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DISPATCHER_EDIT); ?>);

            } else if (val.length > 1) {

                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DISPATCHER_ONLYEDIT); ?>);

            } else {

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getManager",
                    type: 'GET',
                    dataType: 'JSON',
                    async: false,
                    success: function (response)
                    {
                        $('#managerSelectEdit').empty();
                        var HTML = '<option value="">Select</option>';
                        $.each(response.data, function (i, row)
                        {
                            HTML += '<option value="' + row._id.$oid + '" name="' + row.fname + ' ' + row.lname + '">' + row.fname + ' ' + row.lname + '</option>';

                        });

                        $('#managerSelectEdit').append(HTML);
                    }
                });

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getDispatcerData",
                    type: 'POST',
                    data: {val: val},
                    dataType: 'json',
                    success: function (result)
                    {

                        $.each(result, function (index, val1)
                        {

                            $('#city_select').val(result.city.$oid);
                            $('#email_e').val(result.email);
                            $('#name_e').val(result.name);
                            $('#managerSelectEdit').val(result.managerId.$oid);

                        });



                    }
                });

                $('#myModal2').modal('show');
            }
        });



        $("#insert").click(function () {

            $(".errors").text("");
            var city_name = $('#cityid option:selected').attr('name');

            var manager = $("#managerSelectAdd option:selected").attr('name');
            var managerID = $("#managerSelectAdd").val();
            var city = $("#cityid").val();
            var name = $("#name").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            var text = /^[a-zA-Z ]*$/;
            var pass = /^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])\S*$/;    //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;

            if (manager == "" || manager == null)
                $("#managerSelectAddErr").text('Please select the manager');
            else if (name == "" || name == null)
                $("#nameErr").text(<?php echo json_encode(POPUP_DISPATCHERS_NAME); ?>);
            else if (email == "" || email == null)
                $("#emailErr").text(<?php echo json_encode(POPUP_DISPATCHERS_EMAIL); ?>);
            else if (!emails.test(email))
                $("#emailErr").text(<?php echo json_encode(POPUP_DISPATCHERS_VALIDEMAIL); ?>);
            else if ($("#email").attr('data') == 1)
                $("#emailErr").text(<?php echo json_encode(POPUP_DRIVER_DRIVER_ALLOCATED); ?>);
            else if (password == "" || password == null)
                $("#passwordErr").text(<?php echo json_encode(POPUP_DISPATCHERS_PASSWORD); ?>);
            else if (!pass.test(password))
                $("#passwordErr").text(<?php echo json_encode(POPUP_PASSENGERS_PASSVALID); ?>);
            else
            {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/insertdispatches",
                    type: 'POST',
                    data: {
<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
                        manager: manager,
                        managerID: managerID,
                        name: name,
                        city: city,
                        email: email,
                        password: password,
                        city_name: city_name
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                        $(".close").trigger("click");



                        var table = $('#big_table');

                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_dispatcher/1',
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

                        // search box for table
                        $('#search-table').keyup(function () {
                            table.fnFilter($(this).val());
                        });



                    }

                });
            }

        });
        $('#editDispatcher').click(function () {
            tabURL = $('li.active').children("a").attr('data');
            $(".errors").text("");
            var manager = $('#managerSelectEdit option:selected').attr('name');
            var managerId = $('#managerSelectEdit').val();
            var city_name = $('#city_select option:selected').attr('name');
            var city = $("#city_select").val();
            var val = $('.checkbox:checked').val();
            var email = $('#email_e').val();
            var name = $('#name_e').val();
            var city_name = $('#city_select option:selected').attr('name');



            if (managerId == '')
                $("#managerSelectEditErr").text('Please select the manager');
            else if (name == '' || name == null)
                $("#name_e_Err").text('Please enter name');
            else if (email == '' || email == null)
                $("#email_e_Err").text('Please enter email');
            else {
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/editdispatchers",
                    type: "POST",
                    data: {manager:manager,managerId:managerId,cityval: city, val: val, email: email, name: name, city_name: city_name},
                    dataType: 'json',
                    success: function (result)
                    {
                        $(".close").trigger("click");
                        var table = $('#big_table');

                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": tabURL,
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

                        // search box for table
                        $('#search-table').keyup(function () {
                            table.fnFilter($(this).val());
                        });


                    }
                });
            }

        });
    });

</script>


<script type="text/javascript">
    $(document).ready(function () {


//        alert('<?php // echo $status;                   ?>');
        var status = '<?php echo $status; ?>';



        if (status == 1) {
            $('#btnStickUpSizeToggler').show();
            $('#btnStickUpSizeToggl').show();
            $('#inactive').show();
            $('#active').hide();
            $("#reset_password").show();
        }

        $('.cs-loader').show();
        $('#selectedcity').hide();

        $('#companyid').hide();
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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_dispatcher/' + status,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    table.show()
                    $('.cs-loader').hide()
                    searchInput.show()
                    $('#selectedcity').show()
                    $('#companyid').show()
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

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });
        }, 1000);


        $('.whenclicked li').click(function () {
            // alert($(this).attr('id'));\
            if ($(this).attr('id') == 1) {

                $('#btnStickUpSizeToggler').show();
                $('#btnStickUpSizeToggl').show();
                $('#inactive').show();
                $('#active').hide();
                $("#reset_password").show();

            } else if ($(this).attr('id') == 2) {
                $('#btnStickUpSizeToggler').hide();
                $('#btnStickUpSizeToggl').show();
                $('#inactive').hide();
                $('#active').show();
                $("#reset_password").show();


            }
        });

        $('#logs').click(function ()
        {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0)
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select one dispatcher to get logs');
            } else if (val.length > 1)
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select only one dispatcher to get logs');
            } else {
                $('#device_log_data').empty();
//                $.ajax({
//                    url: "<?php echo base_url('index.php?/superadmin') ?>/getDeviceLogs/driver",
//                    type: "POST",
//                    data: {mas_id: $('.checkbox:checked').val()},
//                    dataType: 'json',
//                    success: function (result)
//                    {
//
//
//                    }
//                });

                $('#IPLogPopUp').modal('show');
            }
        });

        $('.changeMode').click(function () {

            var table = $('#big_table');
            var tab_id = $(this).attr('data-id');

            if (tab_id != currentTab)
            {
                currentTab = tab_id;
                table.hide();

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
                        //                    $('#big_table_processing').hide();
                        table.show()

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

                $('.tabs_active').removeClass('active');

                $(this).parent().addClass('active');



                table.dataTable(settings);

                // search box for table
                $('#search-table').keyup(function () {
                    table.fnFilter($(this).val());
                });
            }

        });


    });

    function ValidateFromDb() {

        $.ajax({
            url: "<?php echo base_url() ?>index.php?/superadmin/validatedispatchEmail",
            type: "POST",
            data: {email: $('#email').val(),<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "JSON",
            success: function (result) {

                $('#email').attr('data', result.msg);

                if (result.msg == 1) {

                    $("#emailErr").html("Email id is already exist!");
                    $('#email').focus();
                    return false;
                } else if (result.msg == 0) {
                    $("#validatedispatchEmail").html("");

                }
            }
        });

    }


</script>

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">

            <strong>CENTRAL DISPATCHERS</strong><!-- id="define_page"-->
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
                        <li id= "1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_dispatcher/1" data-id="1"><span><?php echo LIST_ACTIVE; ?></span></a>
                        </li>
                        <li id= "2" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_dispatcher/2" data-id="2"><span><?php echo LIST_INACTIVE; ?> </span></a>
                        </li>
                        <div style="margin-top: 10px;">
                            <div class="pull-right m-t-10 cls111" style="margin-right: 2%;"> <button class="btn btn-primary btn-cons" style="width:inherit;" id="reset_password" ><?php echo BUTTON_RESETPASSWORD; ?></button></div>

                            <div class="pull-right m-t-10 cls100" > <button class="btn btn-primary btn-cons" id="logs" >Logs</button></div>
                            <div class="pull-right m-t-10 cls111" > <button class="btn btn-warning btn-cons" id="inactive" >Deactivate</button></div>
                            <div class="pull-right m-t-10 cls111"> <button class="btn btn-success btn-cons" id="active">Activate</button></a></div>
                            <div class="pull-right m-t-10 cls111"> <button class="btn btn-danger btn-cons" id="delete"><?php echo BUTTON_DELETE; ?></button></a></div>

                            <div class="pull-right m-t-10 cls111"> <button class="btn btn-info btn-cons" id="btnStickUpSizeToggl"><?php echo BUTTON_EDIT; ?></button></a></div>


                            <div class="pull-right m-t-10 cls110" > <button class="btn btn-primary btn-cons" id="btnStickUpSizeToggler" ><?php echo BUTTON_ADD; ?></button></div>
                        </div>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
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
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid container-fixed-lg">

</div>
<!-- END CONTAINER FLUID -->

<!-- END PAGE CONTENT -->
<!-- START FOOTER -->
<div class="container-fluid container-fixed-lg footer">
    <div class="copyright sm-text-center">
        <p class="small no-margin pull-left sm-pull-reset">
            <span class="hint-text"></span>

        </p>

        <div class="clearfix"></div>
    </div>
</div>




<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">
                    <span class="modal-title"><?php echo LIST_ADD_DISPATCHER; ?></span>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                <div class="modal-body">
                    <form action="" method="post" id="addDispatcherForm" data-parsley-validate="" class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">Manager<span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">

                                <select id="managerSelectAdd" name="managerSelectAdd"  class="form-control" >

                                </select>
                            </div>
                            <div class="col-sm-3 errors" id="managerSelectAddErr"></div>
                        </div>

                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label" ><?php echo FIELD_SELECTCITY; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6" id="city_id">

                                <select id="cityid" name="city_select"  class="form-control" >
                                    <option value="0" name="ALL">ALL</option>
                                    <?php
                                    foreach ($city as $result) {

                                        echo '<option value="' . $result['_id']['$oid'] . '" name="' . ucfirst(strtolower($result['city'])) . '">' . ucfirst(strtolower($result['city'])) . '</option>';
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="col-sm-3 errors" id="cityErr"></div>
                            <div class="col-sm-3 errors" id="citynameErr"></div>
                        </div>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label">  <?php echo FIELD_DISPATCHERS_NAME; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="name" name="name"  class="form-control" placeholder="">
                            </div>
                            <div class="col-sm-3 errors" id="nameErr"></div>
                        </div>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_DISPATCHERS_EMAIL; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="email" name="email" class="form-control" data="1" onblur="ValidateFromDb()">
                            </div>
                            <div class="col-sm-3 errors" id="emailErr"></div>
                        </div>


                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label">  <?php echo FIELD_DISPATCHERS_PASSWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="password"  id="password" name="password"  class="form-control" placeholder="">
                            </div>
                            <div class="col-sm-3 errors" id="passwordErr"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-4 error-box errors" id="error_data"></div>
                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-primary pull-right" id="insert" ><?php echo BUTTON_ADD; ?></button>
                        <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Close</button></div>
                    </div>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<div class="modal fade stick-up" id="resetPasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">

                    <span class="modal-title"><?php echo LIST_RESETPASSWORD_HEAD; ?></span>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>



                <div class="modal-body">

                    <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label"> <?php echo FIELD_NEWPASSWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="resetNewpass" name="resetNewpass"  class="form-control" placeholder="New Password">
                            </div>
                            <div class="col-sm-3 errors" id="resetNewPassword"></div>
                        </div>


                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_CONFIRMPASWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="resetConfirmpass" name="resetConfirmpass" class="form-control" placeholder="Confirm Password">
                            </div>
                            <div class="col-sm-3 errors" id="resetConfirmPassword"></div>

                        </div>

                    </form>
                </div>

                <div class="modal-footer">

                    <div class="col-sm-4 error-box" id="errorpass"></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"><button type="button" class="btn btn-success pull-right" id="editpassDispatcher"><?php echo BUTTON_SUBMIT; ?></button></div>
                        <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                    </div>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>


<div class="modal fade stick-up" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">

                    <span class="modal-title">EDIT</span>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">
                    <form action="" method="post" data-parsley-validate="" class="form-horizontal form-label-left">

                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label">Manager<span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">

                                <select id="managerSelectEdit" name="managerSelectEdit"  class="form-control" >

                                </select>
                            </div>
                            <div class="col-sm-3 errors" id="managerSelectEditErr"></div>
                        </div>

                        <div class="form-group">
                            <label for="fname" class="col-sm-3 control-label" ><?php echo FIELD_SELECTCITY; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">

                                <select id="city_select" name="city_select"  class="form-control" >
                                    <option value="0" name="ALL">ALL</option>
                                    <?php
                                    foreach ($city as $result) {

                                        echo '<option value="' . $result['_id']['$oid'] . '" name="' . ucfirst(strtolower($result['city'])) . '">' . ucfirst(strtolower($result['city'])) . '</option>';
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="col-sm-3 errors" id="city_e_Err"></div>
                        </div>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label">  <?php echo FIELD_DISPATCHERS_NAME; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="name_e" name="name_e"  class="form-control" placeholder="">
                            </div>
                            <div class="col-sm-3 errors" id="name_e_Err"></div>
                        </div>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_DISPATCHERS_EMAIL; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="email_e" name="email_e" class="form-control" data="1" onblur="ValidateFromDb()">
                            </div>
                            <div class="col-sm-3 errors" id="email_e_Err"></div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <div class="col-sm-4 error-box errors" id="errormsg"></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="editDispatcher" >Save</button></div>
                        <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" >Cancel</button></div>
                    </div>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>

<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">DEACTIVATE</span>
            </div>

            <div class="modal-body">

                <div class="error-box" id="errorboxdata" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

            </div>


            <div class="modal-footer">

                <div class="col-sm-4" ></div>
                <div class="col-sm-8"></div>
                <div class="pull-right m-t-10">  <button type="button" class="btn btn-warning pull-right" id="confirmed" >Deactivate</button></div>
                <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" >Cancel</button></div>

            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->



<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">ACTIVATE</span>

            </div>

            <div class="modal-body">
                <div class="error-box" id="errorboxdatas" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

            </div>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="confirmeds" >Activate</button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" >Cancel</button></div>

                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="conformDelete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">DELETE</span>
            </div>

            <div class="modal-body">

                <div class="error-box" id="show_deleteMsg" style="text-align:center"><?php echo DISPTACH_DELETE; ?></div>

            </div>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10">  <button type="button" class="btn btn-danger pull-right" id="con_delete" >Delete</button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" >Cancel</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="resetPasswordResponse" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="responseMsg" style="text-align:center;"></div>

                </div>
            </div>


            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6" >

                        <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Close</button></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="IPLogPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title">LOGS</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body form-horizontal">

                <div class="table-responsive">
                    <table class='table table-striped table-bordered table-hover demo-table-search' id="devices_datatable">
                        <thead>
                        <th >IP ADDRESS</th>
                        <th style="">LAST LOGGED IN DATE</th>
                        </thead>


                        <tbody id="device_log_data">
                            <tr>
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
