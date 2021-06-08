<link href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<style>

    span.multiselect-native-select {
        position: relative
    }
    .btn{
        border-radius: 25px;
    }

    span.multiselect-native-select select {
        border: 0!important;
        clip: rect(0 0 0 0)!important;
        height: 1px!important;
        margin: -1px -1px -1px -3px!important;
        overflow: hidden!important;
        padding: 0!important;
        position: absolute!important;
        width: 1px!important;
        left: 50%;
        top: 30px
    }

    .multiselect-container {
        position: absolute;
        list-style-type: none;
        margin: 0;
        padding: 0
    }

    .multiselect-container .input-group {
        margin: 5px
    }

    .multiselect-container>li {
        padding: 0
    }

    .multiselect-container>li>a.multiselect-all label {
        font-weight: 700
    }

    .multiselect-container>li.multiselect-group label {
        margin: 0;
        padding: 3px 20px 3px 20px;
        height: 100%;
        font-weight: 700
    }

    .multiselect-container>li.multiselect-group-clickable label {
        cursor: pointer
    }

    .multiselect-container>li>a {
        padding: 0
    }

    .multiselect-container>li>a>label {
        margin: 0;
        height: 100%;
        cursor: pointer;
        font-weight: 400;
        padding: 3px 20px 3px 40px
    }

    .multiselect-container>li>a>label.radio,
    .multiselect-container>li>a>label.checkbox {
        margin: 0
    }

    .multiselect-container>li>a>label>input[type=checkbox] {
        margin-bottom: 5px;
        margin-left: -15px;
    }

    .btn-group>.btn-group:nth-child(2)>.multiselect.btn {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px
    }

    .form-inline .multiselect-container label.checkbox,
    .form-inline .multiselect-container label.radio {
        padding: 3px 20px 3px 40px
    }

    .form-inline .multiselect-container li a label.checkbox input[type=checkbox],
    .form-inline .multiselect-container li a label.radio input[type=radio] {
        margin-left: -20px;
        margin-right: 0
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
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    .imageborder{
        border-radius: 50%;
    }
    .btn{ font-size: 10px;
    }
    td span {
        line-height: 16px;
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
</style>

<script>
    var driverID = '';
    var currentTab = 1;
    var htmlForPlans;
    var tabURL;
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

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });
        $('.error-box-class').change(function () {
            $('.error-box').text('');
        });


        $(document).on('click', '.deviceInfo', function ()
        {
            $('.make').text($(this).attr('make'));
            $('.model').text($(this).attr('model'));
            $('.os').text($(this).attr('os'));
            $('.lastLoginDate').text($(this).attr('last_active_dt'));
            $('.pushToken').text($(this).attr('push_token'));
            $('#deviceInfoPopUp').modal('show');

        });
        $('#city').on('change', function () {

            var val = $('#city').val();
           console.log(val);
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Storemanagers/getFranchise",
                type: 'POST',
                data: {val: val},
                datatype: 'json', // fix: need to append your data to the call
                success: function (response) {
                    $('#franchise').empty();
                    var r = JSON.parse(response);
                    var html1 = '';
                    html1 = '<option value="">Select Franchise</option>'
                    $.each(r, function (index, row) {
                        console.log(row);
                        html1 += '<option franchiseName="' + row.franchiseName + '" value="' + row._id.$oid + '">' + row.franchiseName + '</option>';
                    });
                    $('#franchise').html(html1);
                }
            });
            
             $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Storemanagers/getStores",
                type: 'POST',
                data: {val: val},
                datatype: 'json', // fix: need to append your data to the call
                success: function (response) {
                    $('#stores').empty();
                    var r = JSON.parse(response);
                    var html = '';
                    html = '<option value="">Select Stores</option>'
                    $.each(r, function (index, row) {
                        console.log(row);
                        html += '<option storeName="' + row.name + '" value="' + row._id.$oid + '">' + row.name + '</option>';
                    });
                    $('#stores').html(html);
                }
            });


        });
        $('#editcity').on('change', function () {

            var val = $('#editcity option:selected').val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Storemanagers/getStores",
                type: 'POST',
                data: {val: val},
                datatype: 'json', // fix: need to append your data to the call
                success: function (response) {
                    $('#editstores').empty();
                    var r = JSON.parse(response);
                    var html = '';
                    html = '<option value="">Select Stores</option>'
                    $.each(r, function (index, row) {
                        console.log(row);
                        html += '<option storeName="' + row.name + '" value="' + row._id.$oid + '">' + row.name + '</option>';
                    });
                    $('#editstores').append(html);
                }
            });


        });

        $(document).on('click', '#btndeviceLogs', function () {

            var val = $(this).val();

            $('#device_log_data').empty();
            $.ajax({
                url: "<?php echo base_url('index.php?/Storemanagers') ?>/getDeviceLogs/manager",
                type: "POST",
                data: {mas_id: val},
                dataType: 'json',
                success: function (result)
                {

                    var html = '';
                    var deviceType = '';
                    var OS = '';
                    $('#d_name_history').text(result.user)
                    $.each(result.data, function (index, logs) {
                        deviceType = '-';
                        if (logs.deviceType != 0 && logs.deviceType != "")
                        {
                            switch (logs.deviceType) {
                                case 1:
                                    deviceType = 'IOS';
                                    break;
                                case 2:
                                    deviceType = 'ANDRIOD';
                                    break;
                                default:
                                    deviceType = 'WEB';
                                    break;
                            }

                        }
                        if (logs.deviceOsVersion == "") {
                            OS = "N/A";
                        } else {
                            OS = logs.deviceOsVersion;
                        }
                        var date = new Date(logs.lastLogin * 1000);
//                                        deviceType = ((logs.deviceType != 0)?((logs.deviceType != 0)?'IOS':'ANDRIOD')):'-';
                        html = "<tr>";
                        html += "<td>" + deviceType + "</td>";
                        html += "<td>" + logs.appVersion + "</td>";
                        html += "<td>" + logs.deviceMake + "</td>";
                        html += "<td>" + logs.deviceModel + "</td>";
                        html += "<td>" + logs.deviceId + "</td>";
                        html += "<td>" + OS + "</td>";
                        html += "<td><span class='pushTokenShortShow'>" + logs.pushToken + "</span></td>";
                        html += "<td>" + date + "</td>";

                        html += "</tr>";
                        $('#device_log_data').append(html);

                    });


                }
            });

            $('#deviceLogPopUp').modal('show');

        });

        var editval = '';
        $(document).on('click', '#btnEdit', function () {

            $('.editmanagerImage').attr('src', '');
            $('#editname').val("");
            $('#editemail').val("");
//            $('#password').val("");
            $('#editfrm_mobile').val("");
            $('#editstores').val("");

            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            editval = $(this).val();

            $.ajax({
                url: "<?php echo base_url('index.php?/Storemanagers') ?>/getManagers",
                type: "POST",
                dataType: 'json',
                data: {managerid: editval},
                success: function (result) {

                    $("#editfrm_mobile").intlTelInput("setNumber", result.data.countryCode);
                    $('#editcity').val(result.data.cityId);

//                    $('#editfranchise').val(result.data.franchise);
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php?/Storemanagers/getFranchise",
                        type: 'POST',
                        data: {val: result.data.franchise},
                        datatype: 'json', // fix: need to append your data to the call
                        success: function (response) {
                            $('#editfranchise').empty();
                            var r = JSON.parse(response);
                            var html1 = '';
                            html1 = '<option value="">Select Franchise</option>'
                            $.each(r, function (index, row) {
                                console.log(row);
                                if (row._id.$oid == result.data.storeId) {
                                    html1 += '<option selected franchiseName="' + row.franchiseName + '" value="' + row._id.$oid + '">' + row.franchiseName + '</option>';
                                } else {
                                    html1 += '<option franchiseName="' + row.franchiseName + '" value="' + row._id.$oid + '">' + row.franchiseName + '</option>';
                                }
                            });
                            $('#editfranchise').html(html1);
                        }
                    });



                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php?/Storemanagers/getStores",
                        type: 'POST',
                        data: {val: result.data.cityId},
                        datatype: 'json', // fix: need to append your data to the call
                        success: function (response) {
                            $('#stores').empty();
                            var r = JSON.parse(response);
                            var html = '';
                            html = '<option value="">Select Stores</option>'
                            $.each(r, function (index, row) {
                                if (row._id.$oid == result.data.storeId) {
                                    html += '<option selected storeName="' + row.name + '" value="' + row._id.$oid + '">' + row.name + '</option>';
                                } else {
                                    html += '<option storeName="' + row.name + '" value="' + row._id.$oid + '">' + row.name + '</option>';
                                }
                            });
                            $('#editstores').html(html);
                        }
                    });

//                        $('#editstores option:selected').val(result.data.storeId);
                    $('#editname').val(result.data.name);
                    $('#editemail').val(result.data.email);
                    $('#editpassword').val(result.data.password);
                    $('#editfrm_mobile').val(result.data.phone);
                    $('#editImageUpload').val(result.data.profilePic);
                    $('.editmanagerImage').attr('src', result.data.profilePic);
                    $('#viewimage_hidden').val(result.data.profilePic);
                    //chnages made from acceptedit to accepteditw
                    var resposibility=result.data.accepts;
                    
                    if(resposibility=="1"){
                        $("#acceptedit1").attr('checked', 'checked');
                        }else if(resposibility=="2"){
                            $("#acceptedit2").attr('checked', 'checked');
                        }else{
                            $("#acceptedit3").attr('checked', 'checked');
                        }
                    // $('.accepteditw').val(result.data.accepts);
                    // if ($('.acceptedit').val() == 1) {
                    //     $("#acceptedit1").attr('checked', 'checked');
                    // } else if ($('.acceptedit').val() == 2) {
                    //     $("#acceptedit2").attr('checked', 'checked');
                    // } else if ($('.acceptedit').val() == 3) {
                    //     $("#acceptedit3").attr('checked', 'checked');
                    // }

                    $('#editManagerModal').modal('show');
                }
            });


        });
        $('#editemail,#editfrm_mobile').focusout(function () {

            var email = $('#editemail').val();
            var mobile = $('#editfrm_mobile').val();
            $.ajax({
                url: "<?php echo base_url('index.php?/Storemanagers') ?>/checkManagerExists",
                type: "POST",
                data: {email: email, mobile: mobile},
                success: function (result) {
                    console.log(result);
                    switch (result.flag) {
                        case 1:
                            alert(1);
                            $("#yesEdit").prop("disabled", true);
                            $("#text_edit_email").text("Email already exists");
                            break;
                        case 2:
                            alert(2);
                            $("#yesEdit").prop("disabled", true);
                            $("#text_edit_mobile").text("Mobile already exists");
                            break;

                    }
                }
            });
        });


        $("#yesEdit").click(function () {
            var storeId = $('#editstores option:selected').val();
            var cityId = $('#editcity option:selected').val();
            var cityName = $('#editcity option:selected').attr('cityName');
            var storeName = $('#editstores option:selected').attr('storeName');
            var profilePic = $('#editImageUpload').val();
            var mobile = $('#editfrm_mobile').val();
            var countryCode = $('#editCountryCode').val();
            var accepts = $('input[name=acceptedit_res]:checked').val();
            var password = $('#editpassword').val();
            var name = $('#editname').val();
            var email = $('#editemail').val();
            var stores = $('#editstores').val();
            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/; //^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

//          console.log($('.editaccepts').val());  console.log(accepts); return;
            if (stores == "" && stores == null)
            {
                $("#text_edit_StoresList").text('Please choose an store');
            } else if (name == "" || name == null)
            {
                $("#text_edit_name").text("Please enter the name");
            } else if (email == "" || email == null)
            {
                $("#text_edit_email").html("Please enter the email");
            } else if (!emails.test(email))
            {
                $("#text_edit_email").html("Please enter the proper format");
            } else if (mobile == "" || mobile == null)
            {
                $("#text_edit_mobile").html("Please enter the mobile number");
            } else if (accepts == "" || accepts == null)
            {
                $("#text_edit_accepts").html("Please choose accepts");
            } else if (profilePic == "" || profilePic == null)
            {
                $("#text_editImageErr").html("Please choose Image");
            } else {
                $.ajax({
                    url: "<?php echo base_url('index.php?/Storemanagers') ?>/editManager",
                    type: "POST",
                    data: {managerId: editval, name: name, storeId: storeId, email: email, mobile: mobile, accepts: accepts, countryCode: countryCode, storeName: storeName, cityId: cityId, cityName: cityName, profilePic: profilePic},
                    success: function (result) {
                        $("#editManagerModal").modal('hide');
                        var table = $('#big_table');
                        $('#big_table').fadeOut('slow');
                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Storemanagers/datatable_storeManagers/my/1',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {
                            },
                            "fnInitComplete": function () {
                                $('#big_table').fadeIn('slow');
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
            $('.managerImage').attr('src', '');
            $('#city').val();
            $('#name').val("");
            $('#email').val("");
            $('#password').val("");
            $('#frm_mobile').val("");
            $('#stores').val();
            $('#text_name').text("");
            $('#text_email').text("");
            $('#text_password').text("");
            $('#text_mobile').text("");
            $('#text_stores').text("");

            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                $('#addManager').modal('show');
            } else {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Invalid Selection");

            }

        });
        $("#yesAdd").click(function () {

            $("#text_StoresList").text("");
            $("#text_name").text("");
            $("#text_email").text("");
            $("#text_password").text("");
            $("#text_mobile").text("");
            $("#text_accepts").text("");

            var storeId = $('#stores option:selected').val();
            var cityId = $('#city').val();
            var cityName = $('#city option:selected').attr('cityName');
            var storeName = $('#stores option:selected').attr('storeName');
            var mobile = $('#frm_mobile').val();
            var countryCode = $('#countryCode').val();
			
            var accepts = $('input[name=accepts]:checked').val();
           
            var password = $('#password').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var stores = $('#stores').val();
            var franchise = $('#franchise').val();

            console.log(cityId);
            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/; //^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (cityId == "" || cityId == null) {
                $("#text_CityList").text('Please select city');
            } else if (storeId == "" || storeId == null)
            {
                $("#text_StoresList").text('Please choose an store');
            } else if (name == "" || name == null)
            {
                $("#text_name").text("Please enter the name");

            } else if (email == "" || email == null)
            {
                $("#text_email").html("Please enter the email");

            } else if (!emails.test(email))
            {

                $("#text_email").html("Please enter the proper format");

            } else if (password == "" || password == null)
            {
                $("#text_email").html("");
                $("#text_password").html("Please enter the password");

            } else if (password.length < 4)
            {
                $("#text_password").html("password should be more than 4 characters");

            } else if (mobile == "" || mobile == null)
            {
                $("#text_mobile").html("Please enter the mobile number");

            } else if (accepts == "" || accepts == null)
            {
                $("#text_accepts").html("Please choose accepts");
            } else if ($('#ImageUpload').val() == "" || $('#ImageUpload').val() == null) {
                $("#text_ImageErr").text("Please add profile image");
            } else {

                $('#yesAdd').prop('disabled', true);


                $.ajax({
                    url: "<?php echo base_url('index.php?/Storemanagers') ?>/addManager",
                    type: "POST",
                    dataType: 'json',
                    data: {name: name, profilePic: $('#ImageUpload').val(), storeId: storeId, email: email, mobile: mobile, password: $('#password').val(), accepts: accepts, countryCode: countryCode, storeName: storeName, cityId: cityId, cityName: cityName,franchiseId:franchise},
                    success: function (result) {

                        if (result.flag == 1) {

                            $('#addManager').modal('hide');

                            $.ajax({
                                url: "<?php echo base_url() ?>index.php?/Storemanagers/getManagersCount",
                                type: "POST",
                                dataType: 'json',
                                async: true,
                                success: function (response)
                                {
                                    $('.newManagersCount').text(response.data.New);
                                    $('.loggedInManagersCount').text(response.data.loggedin);
                                    $('.loggedOutManagersCount').text(response.data.loggedout);
                                    $('.deletedManagersCount').text(response.data.deleted);


                                    var table = $('#big_table');
                                    $('#big_table').fadeOut('slow');
                                    var settings = {
                                        "autoWidth": false,
                                        "sDom": "<'table-responsive't><'row'<p i>>",
                                        "destroy": true,
                                        "scrollCollapse": true,
                                        "iDisplayLength": 20,
                                        "bProcessing": true,
                                        "bServerSide": true,
                                        "sAjaxSource": '<?php echo base_url() ?>index.php?/Storemanagers/datatable_storeManagers/my/1',
                                        "bJQueryUI": true,
                                        "sPaginationType": "full_numbers",
                                        "iDisplayStart ": 20,
                                        "oLanguage": {
                                        },
                                        "fnInitComplete": function () {
                                            $('#big_table').fadeIn('slow');
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
                        } else if (result.flag == 0) {

                            $('#addManager').modal('hide');
                            $('#alertForNoneSelected').modal('show');
                            $("#display-data").text("Manager already exists");

                        }
                        $('#yesAdd').prop('disabled', false);

                    }

                });
            }

        });


        $("#active").click(function () {
            var deletedBy = "Admin";
            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length == 1) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#activateManager');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#activateManager').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxactivateManager").text("Are you sure you want to activate the manager?");


                $("#yesActivate").click(function () {

//            if(confirm("Are you sure to Delete " +val.length + " Drivers")){
                    $.ajax({
                        url: "<?php echo base_url('index.php?/Storemanagers') ?>/activateManagers",
                        type: "POST",
                        data: {masterid: val},
                        success: function (result) {

                            $.ajax({
                                url: "<?php echo base_url() ?>index.php?/Storemanagers/getManagersCount",
                                type: "POST",
                                dataType: 'json',
                                async: true,
                                success: function (response)
                                {
                                    $('.newManagersCount').text(response.data.New);
                                    $('.loggedInManagersCount').text(response.data.loggedin);
                                    $('.loggedOutManagersCount').text(response.data.loggedout);
                                    $('.deletedManagersCount').text(response.data.deleted);

                                }
                            });
                            $('#activateManager').modal('hide')
                            var table = $('#big_table');
                            $('#big_table').fadeOut('slow');
                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Storemanagers/datatable_storeManagers/my/4',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                                },
                                "fnInitComplete": function () {
                                    $('#big_table').fadeIn('slow');
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
                });
            } else if (val.length > 1) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select only one manager once");
            } else if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select atleast one manager");
            }

        });
        $("#managerLogout").click(function () {
            var deletedBy = "Admin";
            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length == 1) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#logoutManager');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#logoutManager').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxLogoutManager").text("Are you sure you want to logout the manager?");


                $("#yesLogout").click(function () {

//            if(confirm("Are you sure to Delete " +val.length + " Drivers")){
                    $.ajax({
                        url: "<?php echo base_url('index.php?/Storemanagers') ?>/logoutManagers",
                        type: "POST",
                        data: {masterid: val},
                        success: function (result) {

                            $.ajax({
                                url: "<?php echo base_url() ?>index.php?/Storemanagers/getManagersCount",
                                type: "POST",
                                dataType: 'json',
                                async: true,
                                success: function (response)
                                {
                                    $('.newManagersCount').text(response.data.New);
                                    $('.loggedInManagersCount').text(response.data.loggedin);
                                    $('.loggedOutManagersCount').text(response.data.loggedout);
                                    $('.deletedManagersCount').text(response.data.deleted);

                                }
                            });
                            $('#logoutManager').modal('hide')
                            var table = $('#big_table');
                            $('#big_table').fadeOut('slow');
                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Storemanagers/datatable_storeManagers/my/2',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                                },
                                "fnInitComplete": function () {
                                    $('#big_table').fadeIn('slow');
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
                });
            } else if (val.length > 1) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select only one manager once");
            } else if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select atleast one manager");
            }

        });
        $("#chekdel").click(function () {
            var deletedBy = "Admin";
            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length > 0) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#deletedriver');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#deletedriver').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorbox").text("Are you sure you want to deactivate the manager?");


                $("#yesdelete").click(function () {

//            if(confirm("Are you sure to Delete " +val.length + " Drivers")){
                    $.ajax({
                        url: "<?php echo base_url('index.php?/Storemanagers') ?>/deleteManagers",
                        type: "POST",
                        data: {masterid: val, deletedBy: deletedBy},
                        success: function (result) {

                            $.ajax({
                                url: "<?php echo base_url() ?>index.php?/Storemanagers/getManagersCount",
                                type: "POST",
                                dataType: 'json',
                                async: true,
                                success: function (response)
                                {
                                    $('.newManagersCount').text(response.data.New);
                                    $('.loggedInManagersCount').text(response.data.loggedin);
                                    $('.loggedOutManagersCount').text(response.data.loggedout);
                                    $('.deletedManagersCount').text(response.data.deleted);

                                }
                            });
                            $('#deletedriver').modal('hide')
                            var table = $('#big_table');
                            $('#big_table').fadeOut('slow');
                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Storemanagers/datatable_storeManagers/my/1',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                                },
                                "fnInitComplete": function () {
                                    $('#big_table').fadeIn('slow');
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
                });
            } else {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select atleast one manager");
            }

        });




        $('.closeButton').click(function ()
        {
            $('.close').trigger('click');
        });




        $("#editdriver").click(function () {
            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_EDIT); ?>);

            } else if (val.length > 1)
            {

                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_ONLYEDIT); ?>);
            } else
            {
                window.location = "<?php echo base_url() ?>index.php?/Storemanagers/editdriver/" + val;
            }
        });

    });

</script>


<script type="text/javascript">
    var driverWalletEnable = <?php echo $appCofig['walletSettings']['walletDriverEnable']; ?>

    $(document).ready(function () {
        $('#storeList').hide();
        $('#operatorList').hide();

        var resetval = '';
        $(document).on('click', '#btnResetPwd', function () {
            resetval = $(this).val();
            $('#newpass1').val("");
            $('#confirmpassword').val("");
            $('#resetPasswordForManagers').modal('show');

        });


        $('#resetPasswordConfirm').click(function () {
            var val = resetval;

            var confirm = $('#confirmpassword').val();
            var newpass = $('#newpass1').val();
            if (confirm == newpass) {

                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Storemanagers/resetPassword",
                    type: "POST",
                    data: {val: val, newpass: newpass},
                    dataType: 'json',
                    async: true,
                    success: function (response)
                    {
                        $('#resetPasswordForManagers').modal('hide');
                        $('.TitleText').text("Success");
                        $('#alertForNoneSelected').modal('show');
                        $('#display-data').text('Password changed successfully...!!!');
                    }
                });
            } else {
                $('#resetPasswordForManagers').modal('hide');
                $('#alertForNoneSelected').modal('show');
                $('#display-data').text('Password Mismatch');
            }


        });


        $('.cs-loader').show();

        var table = $('#big_table');
        var searchInput = $('#search-table');
        $('.hide_show').hide();
        searchInput.hide();
        table.hide();


        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Storemanagers/getManagersCount",
            type: "POST",
            dataType: 'json',
            async: true,
            success: function (response)
            {
                $('.newManagersCount').text(response.data.New);
                $('.loggedInManagersCount').text(response.data.loggedin);
                $('.loggedOutManagersCount').text(response.data.loggedout);
                $('.deletedManagersCount').text(response.data.deleted);

            }
        });

        var status = '<?php echo $status; ?>';

        if (status == 1) {

            $("#display-data").text("");
//            alert('asdf');
            $('#driverresetpassword').hide();
            $('#chekdel').show();
            $('#reject').show();
            $('#active').hide();
            $('#accept').show();
            $('#add').show();
            $('#ban').hide();
            $('#driver_logout').hide();
            $('#updatePlan').hide();

        }


        $('#my1').click(function () {
            $("#display-data").text("");
            $('#managerLogout').hide();


        });
        $('#my3').click(function () {
            $("#display-data").text("");
            $('#managerLogout').hide();


        });
        $('#my4').click(function () {
            $("#display-data").text("");
            $('#managerLogout').hide();


        });
        $('#my2').click(function () {
            $('#managerLogout').show();
        });

        $('#my5').click(function () {
            $("#display-data").text("");
            $('#managerLogout').hide();


        });

        $("#frm_mobile").intlTelInput("setNumber", '');
        $("#frm_mobile").on("countrychange", function (e, countryData) {

            $("#countryCode").val(countryData.dialCode);
        });
        $("#editfrm_mobile").intlTelInput("setNumber", '');
        $("#editfrm_mobile").on("countrychange", function (e, countryData) {

            $("#editCountryCode").val(countryData.dialCode);
        });


        setTimeout(function () {
            $('#managerLogout').hide();
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/Storemanagers/datatable_storeManagers/my/' + status,
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
					null,
					
					null,
					{"width": "14%"},
					null
                ],

                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    table.show()
                    $('.cs-loader').hide()
                    $('.hide_show').show();
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

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });

        }, 1000);

//        $('#big_table').on('init.dt', function () {
//
//            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
//            var status = urlChunks[urlChunks.length - 1];
//            var forwhat = urlChunks[urlChunks.length - 2];
//            if (forwhat == 'my') {
//                if (status == 1 || status == 2 || status == 3 || status == 4)
//                    $('#big_table').dataTable().fnSetColumnVis([], false);
//            }
//        });

        $("#driver_logout").click(function () {

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length > 0) {

                $('#Model_manual_logout').modal('show');
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ATLEAST_LOGOUT); ?>);

            }

        });

        $("#ok_to_logout").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            tabURL = $('li.active').children("a").attr('data');

            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Storemanagers/driver_logout",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {
                    $("#errorbox_logout").text(<?php echo json_encode(POPUP_MSG_LOGOUT); ?>);
                    $(".close").trigger('click');

                    refreshContent(tabURL);
                }

            });

            $("#ve_compan").val('');
            $("#company_select").val('');

        });


        $(":file").on("change", function (e) {
            var fieldID = $(this).attr('id');
            var ext = $(this).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $(this).val('');
                alert('invalid extension..!   Please choose file type in (gif,png,jpg,jpeg)');
            } else
            {
                var type;
                var folderName;
                switch ($(this).attr('id'))
                {
                    case "managerImageUpload":
                        type = 1;
                        folderName = 'Manager';
                        break;
                    case "editmanagerImageUpload":
                        type = 2;
                        folderName = 'Manager';
                        break;

                }

                var formElement = $(this).prop('files')[0];
                var form_data = new FormData();

                form_data.append('OtherPhoto', formElement);
                form_data.append('type', 'profile');
                form_data.append('folder', folderName);
                $.ajax({
                    url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                    type: "POST",
                    data: form_data,
                    dataType: "JSON",
                    async: false,
                    success: function (result) {
                        console.log(result.fileName);
                        switch (type)
                        {
                            case 1:
                                $('#ImageUpload').val(result.fileName);
                                $('.managerImage').attr('src', result.fileName);
                                $('.managerImage').show();
                                break;
                            case 2:
                                $('#editImageUpload').val(result.fileName);
                                $('.editmanagerImage').attr('src', result.fileName);
                                $('.editmanagerImage').show();
                                break;
                        }
                    },
                    error: function () {

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        })

        $('.changeMode').click(function () {

            var tab_id = $(this).attr('data-id');

            if (currentTab != tab_id)
            {
                $('#big_table').hide();

//                currentTab = tab_id;
                $('#big_table').hide();
                $("#display-data").text("");

                console.log(currentTab);

                if ($(this).data('id') == 2) {
                    $("#display-data").text("");
                    $('#add').hide();
                    $('#driverresetpassword').show();
                    $('#chekdel').hide();
                    $('#reject').hide();
                    $('#document_data').show();
                    $('#joblogs').show();
                    $('#editdriver').show();
                    $('#driver_logout').hide();
                    $('#ban').show();
                    $('#updatePlan').show();
                    $('#active').hide();


                } else if ($(this).data('id') == 3) {
                    $("#display-data").text("");
                    $('#add').hide();
                    $('#driverresetpassword').hide();
                    $('#chekdel').hide();
                    $('#reject').hide();
                    $('#document_data').show();
                    $('#editdriver').hide();
                    $('#ban').hide();
                    $('#updatePlan').hide();
                    $('#active').hide();


                } else {
                    $("#display-data").text("");
                    $('#add').hide();
                    $('#active').show();
                    $('#driverresetpassword').hide();
                    $('#chekdel').hide();
                    $('#reject').hide();
                    $('#document_data').show();
                    $('#editdriver').hide();
                    $('#ban').hide();
                    $('#updatePlan').hide();
                }


                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Storemanagers/getManagersCount",
                    type: "POST",
                    dataType: 'json',
                    async: true,
                    success: function (response)
                    {
                        $('.newManagersCount').text(response.data.New);
                        $('.loggedInManagersCount').text(response.data.loggedin);
                        $('.loggedOutManagersCount').text(response.data.loggedout);
                        $('.deletedManagersCount').text(response.data.deleted);

                    }
                });




                $('#big_table_processing').toggle();

                var table = $('#big_table');

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
                        "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
                    },
                    "fnInitComplete": function () {
                        //oTable.fnAdjustColumnSizing();
//                    $('#big_table_processing').toggle();
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

                $('.tabs_active').removeClass('active');

                $(this).parent().addClass('active');
                table.dataTable(settings);
                var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                var status = urlChunks[urlChunks.length - 1];


                switch (parseInt(status)) {

                    case 2:
                        $('#big_table').dataTable().fnSetColumnVis([], false);

                        break;
                    case 3:
                        $('#big_table').dataTable().fnSetColumnVis([], false);
                        break;
                    case 4:
                        $('#big_table').dataTable().fnSetColumnVis([], false);
                        break;


                }
            } else {
                $('#chekdel').show();
                $('#reject').show();
                $('#accept').show();
                $('#add').show();
                $('#document_data').show();
                $('#driverresetpassword').hide();
                $('#editdriver').show();
                $('#active').hide();
                $('#driver_logout').hide();
                $('#ban').hide();
                $('#updatePlan').hide();
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Storemanagers/getManagersCount",
                    type: "POST",
                    dataType: 'json',
                    async: true,
                    success: function (response)
                    {
                        $('.newManagersCount').text(response.data.New);
                        $('.loggedInManagersCount').text(response.data.loggedin);
                        $('.loggedOutManagersCount').text(response.data.loggedout);
                        $('.deletedManagersCount').text(response.data.deleted);

                    }
                });




                $('#big_table_processing').toggle();

                var table = $('#big_table');

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
                        "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
                    },
                    "fnInitComplete": function () {
                        //oTable.fnAdjustColumnSizing();
//                    $('#big_table_processing').toggle();
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

                $('.tabs_active').removeClass('active');

                $(this).parent().addClass('active');
                table.dataTable(settings);
                var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                var status = urlChunks[urlChunks.length - 1];


                switch (parseInt(status)) {
                    case 1:
                        $('#big_table').dataTable().fnSetColumnVis([], false);
                        break;
                }

            }

        });


        $(document).on('click', '.getManagerDetails', function ()
        {
            $('.dname').text('');
            $('.demail').text('');
            $('.dphone').text('');

            $.ajax({
                url: "<?php echo base_url('index.php?/Storemanagers') ?>/getManagerDetails",
                type: "POST",
                data: {managerId: $(this).attr('managerId')},
                dataType: 'json',
                success: function (result) {


                    $('.dprofilePic').attr('src', '');
                    $('.dprofilePic').hide();
                    if (result.managerData.name != null)
                    {
                        $('.dname').text(result.managerData.name);
                        $('.demail').text(result.managerData.email);
                        $('.dphone').text(result.managerData.countryCode + result.managerData.phone);


                        if (result.managerData.profilePic != '')
                        {
                            $('.dprofilePic').attr('src', result.managerData.profilePic);
                            $('.dprofilePic').show();
                        }
                    }

                    $('#getManagerDetails').modal('show');//Code in storeManageers view page

                }
            });
        });

    });

    function refreshContent(url) {


        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Storemanagers/getManagersCount",
            type: "POST",
            dataType: 'json',
            async: true,
            success: function (response)
            {
                $('.newManagersCount').text(response.data.New);
                $('.loggedInManagersCount').text(response.data.loggedin);
                $('.loggedOutManagersCount').text(response.data.loggedout);
                $('.deletedManagersCount').text(response.data.deleted);

            }
        });

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
        var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
        var status = urlChunks[urlChunks.length - 1];
        var forwhat = urlChunks[urlChunks.length - 2];
        if (forwhat == 'my') {

            switch (parseInt(status)) {
                case 1:
                    $('#big_table').dataTable().fnSetColumnVis([], false);
                    break;
                case 2:
                    $('#big_table').dataTable().fnSetColumnVis([], false);
                    break;
                case 3:
                    $('#big_table').dataTable().fnSetColumnVis([], false);
                    break;
                case 4:
                    $('#big_table').dataTable().fnSetColumnVis([], false);
                    break;


            }


        }

    }
</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;">

            <strong >STORE MANAGERS</strong>
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">


 
                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->

                    <ul class="nav nav-tabs  bg-white whenclicked">
                        <li id= "my1" class="tabs_active <?php echo ($status == 1 ? "active" : "");?>" style="cursor:pointer">
                            <a  class="changeMode New_" data="<?php echo base_url(); ?>index.php?/Storemanagers/datatable_storeManagers/my/1" data-id="1"><span>APPROVED</span><span class="badge newManagersCount" style="background-color: #337ab7;"></span></a>
                        </li>

                        <li id= "my2" class="tabs_active <?php echo $status ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/Storemanagers/datatable_storeManagers/my/2" data-id="2"><span>LOGGED IN</span> <span class="badge bg-green loggedInManagersCount" style="background-color: #5bc0de;"></span></a>
                        </li>
                        <li id= "my3" class="tabs_active <?php echo $status ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/Storemanagers/datatable_storeManagers/my/3" data-id="3"><span>LOGGED OUT</span> <span class="badge loggedOutManagersCount" style="background-color:#f0ad4e;"></span></a>
                        </li>
                        <li id= "my4" class="tabs_active <?php echo $status ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/Storemanagers/datatable_storeManagers/my/4" data-id="4"><span>INACTIVE</span> <span class="badge bg-red deletedManagersCount"></span></a>
                        </li>



                    </ul>


                    <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">



                        <!--<div class="cls111"><button class="btn btn-primary pull-right m-t-10 " id="resetPassword"  ><?php echo BUTTON_RESETPASSWORD; ?></button></div>-->
                        <div class="cls111"><button class="btn btn-primary pull-right m-t-10 " id="managerLogout"  ><?php echo BUTTON_MANUAL_LOGOUT; ?></button></div>
                        <div class="cls111"> <button class="btn btn-success pull-right m-t-10" id="active" >Activate</button></a></div>
                        <div class="cls111"> <button class="btn btn-danger pull-right m-t-10" id="chekdel" >Deactivate</button></a></div>
                        <!--<div class="cls100"><button class="btn btn-info pull-right m-t-10 " id="deviceLogs" >Device Logs</button></div>-->     


                        <!--<div class="cls111"><button class="btn btn-info pull-right m-t-10 " id="editManager" ><?php echo BUTTON_EDIT; ?></button></div>-->
                        <div class="cls110"><button class="btn btn-success pull-right m-t-10" id="add" ><?php echo BUTTON_ADD; ?></button></a></div>

                    </ul>
                </div>


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



                                    <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
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

</div>

<input type="hidden" name="current_dt" id="time_hidden" value=""/>






<div class="modal fade stick-up" id="deletedriver" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">DEACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel51">Cancel</button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="yesdelete" >Deactivate</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="logoutManager" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">LOGOUT</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorboxLogoutManager" style="text-align:center">Logout</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel15">Cancel</button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-warning pull-right" id="yesLogout" >Logout</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="activateManager" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">ACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorboxactivateManager" style="text-align:center">Activate</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel5">Cancel</button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="yesActivate" >Activate</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="addManager" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title">ADD</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">


                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">City<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <select id="city" name="city" class="form-control error-box-class">
                                <option value="">Select City</option>
                                <?php
                                foreach ($cities as $result) {

                                    echo "<option cityName='" . $result['cityName'] . "'   cityId='" . $result['cityId']['$oid'] . "' value='" . $result['cityId']['$oid'] . "'>" . $result['cityName'] . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-sm-3 error-box" id="text_CityList" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Franchise</label>
                        <div class="col-sm-6">
                            <select id="franchise" name="franchise" class="form-control error-box-class">
                                <option value="">Select Franchise</option>

                            </select>

                        </div>
                        <div class="col-sm-3 error-box" id="text_FranchiseList" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Stores<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <select id="stores" name="stores" class="form-control error-box-class">
                                <option value="">Select Stores</option>

                            </select>

                        </div>
                        <div class="col-sm-3 error-box"  id="text_StoresList" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Name<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control error-box-class" id="name" minlength="3" placeholder="Enter your name" required="">  

                        </div>
                        <div class="col-sm-3 error-box" id="text_name" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Email<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control error-box-class" id="email"  placeholder="Enter your email" required="">  

                        </div>
                        <div class="col-sm-3 error-box" id="text_email" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Password<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="password" required="" class="form-control error-box-class" name="password"  id="password" > 
                            <input type="hidden" name="paswordEncrypted" class="form-control paswordEncrypted">

                        </div>
                        <div class="col-sm-3 error-box" id="text_password" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Mobile<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="tel" maxlength="10"required="" class="form-control error-box-class" name="frm_mobile"  id="frm_mobile" onkeypress="return isNumberKey(event)" style="    width: 109%;" > 
                            <input type="hidden" id="countryCode" name="coutry-code" value=""> 

                        </div>
                        <div class="col-sm-3 error-box" id="text_mobile" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Accepts<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">

                            <label class=" col-sm-2 control-label">Pickup</label>
                            <input type="radio" class= "error-box-class col-sm-2 accepts" name="accepts"  id="accepts1"  value="1"> 


                            <label class="col-sm-2 control-label">Delivery</label>
                            <input type="radio" class="error-box-class col-sm-2 accepts" name="accepts"  id="accepts2"  value="2"> 

                            <label class="col-sm-2 control-label">Both</label>
                            <input type="radio" class="error-box-class col-sm-2 accepts" name="accepts"  id="accepts3"  value="3"> 


                        </div>
                        <div class="col-sm-3 error-box" id="text_accepts" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Profile Image<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control error-box-class" style="height: 37px;" name="photos" id="managerImageUpload" >
                            <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="ImageUpload" id="ImageUpload">


                        </div>
                        <div class="col-sm-1">
                            <img src="" style="width: 35px; height: 35px; display: none;"
                                 class="managerImage style_prevu_kit">
                        </div>
                        <div class="col-sm-3 error-box" id="text_ImageErr" style="color:red"></div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel6">Cancel</button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesAdd" >Add</button></div>
                </div>

            </div>
        </div>


    </div>
</div>
<div id="editManagerModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title">EDIT</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">


                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">City<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <select id="editcity" name="city" class="form-control error-box-class">
                                <option value="">Select City</option>
                                <?php
                                foreach ($cities as $result) {

                                    echo "<option cityName='" . $result['cityName'] . "'   cityId='" . $result['cityId']['$oid'] . "' value='" . $result['cityId']['$oid'] . "'>" . $result['cityName'] . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-sm-3 error-box" id="text_edit_CityList" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Franchise</label>
                        <div class="col-sm-6">
                            <select id="editfranchise" name="franchise" class="form-control error-box-class">
                                <option value="">Select Franchise</option>

                            </select>

                        </div>
                        <div class="col-sm-3 error-box" id="text_edit_FranchiseList" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Stores<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <select id="editstores" name="stores" class="form-control error-box-class">
                            </select>

                        </div>
                        <div class="col-sm-3 error-box" id="text_edit_StoresList" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Name<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control error-box-class" id="editname" minlength="3" value="" placeholder="Enter your name" required="">  
                            <div class="col-sm-3 error-box" id="text_edit_name" style="color:red"></div>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Email<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control error-box-class" id="editemail" value="" placeholder="Enter your email" required="">  
                            <div class="col-sm-3 error-box" id="text_edit_email" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Mobile<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="tel" maxlength="10"required="" value="" class="form-control error-box-class" name="editfrm_mobile"  id="editfrm_mobile" onkeypress="return isNumberKey(event)" style="    width: 100%;" > 
                            <input type="hidden" id="editCountryCode" name="coutry-code" value=""> 
                            <div class="col-sm-3 error-box" id="text_edit_mobile" style="color:red"></div>
                        </div>
                    </div>

                    <!-- <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Accepts<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">

                            <label class=" col-sm-2 control-label">Pickup</label>
                            <input type="radio" class= "error-box-class col-sm-2 editaccepts" name="editaccepts"  id="editaccepts1"  value="1"> 


                            <label class="col-sm-2 control-label">Delivery</label>
                            <input type="radio" class="error-box-class col-sm-2 editaccepts" name="editaccepts"  id="editaccepts2"  value="2"> 

                            <label class="col-sm-2 control-label">Both</label>
                            <input type="radio" class="error-box-class col-sm-2 editaccepts" name="editaccepts"  id="editaccepts3"  value="3"> 

                            <div class="col-sm-3 error-box" id="text_edit_accepts" style="color:red"></div>
                        </div>
                    </div> -->
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Accepts<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">

                            <label class=" col-sm-2 control-label">Pickup</label>
                            <input type="radio" class= "error-box-class col-sm-2 acceptedit" name="acceptedit_res"  id="acceptedit1"  value="1"> 


                            <label class="col-sm-2 control-label">Delivery</label>
                            <input type="radio" class="error-box-class col-sm-2 acceptedit" name="acceptedit_res"  id="acceptedit2"  value="2"> 

                            <label class="col-sm-2 control-label">Both</label>
                            <input type="radio" class="error-box-class col-sm-2 acceptedit" name="acceptedit_res"  id="acceptedit3"  value="3"> 

                            <div class="col-sm-3 error-box" id="text_edit_accepts" style="color:red"></div>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">Profile Image<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control error-box-class" style="height: 37px;" name="photos" id="editmanagerImageUpload" >
                            <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="ImageUpload" id="editImageUpload">
                            <input type="hidden" value="" id='viewimage_hidden'/>



                        </div>
                        <div class="col-sm-1">
                            <img src="" style="width: 35px; height: 35px; display: block;"
                                 class="editmanagerImage style_prevu_kit">
                        </div>
                        <div class="col-sm-3 error-box" id="text_editImageErr" style="color:red"></div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel7">Cancel</button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesEdit" >Edit</button></div>
                </div>

            </div>
        </div>


    </div>
</div>

<div class="modal fade stick-up" id="acceptdrivermsg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox_accept" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-default pull-right" id="accepted_msg" >Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="myModaldocument" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title">DOCUMENTS</span>
                </div>


                <div class="modal-body">
           <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->

                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th style="width:20%;text-align: center;">TYPE</th>
                                <th style="width:10%;text-align: center;">PREVIEW</th>

                            </tr>
                        </thead>
                        <tbody id="doc_body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
                <!-- /.modal-dialog -->
            </div>


        </div>
    </div> </div>

<div class="modal fade stick-up" id="Model_manual_logout" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">LOGOUT</span>
            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox_logout" style="text-align:center"><?php echo ARE_YOU_SURE_TO_LOGOUT_THIS_DRIVER; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="ok_to_logout" ><?php echo BUTTON_OK; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="deviceInfoPopUp" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DEVICE INFO</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">

                <div class="form-group row">

                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">Make</label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="make"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">Model</label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="model"></span>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">OS</label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="os"></span>
                    </div>

                </div>
                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">Last Login Date & Time</label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="lastLoginDate"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for="">Push Token</label>
                    <div class="col-md-8 col-sm-8 pushToken" style="word-break: break-all;">

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                <div class="row">
                    <span style="color:#738092;font-weight:700;margin-left: 10px;">Manager Name : <span id="d_name_history" style="color:#1ABB9C;"></span></span>
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
                        <th style="">DEVICE OS</th>
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

<div class="modal fade stick-up" id="alertForNoneSelected" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="">
                <span class="modal-title TitleText" style="color:#337ab7;">Alert</span>
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
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancelq">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="resetPasswordForManagers" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <span class="modal-title">RESET PASSWORD</span>
                    </div>


                    <div class="modal-body">
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label"> <?php echo FIELD_NEWPASSWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="newpass1" name=""  class="newpass form-control" placeholder="New Password">
                            </div>
                        </div>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_CONFIRMPASWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="confirmpassword"  class="confirmpass form-control" placeholder="Confirm Password">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="col-sm-6 error-box errors" id="errorpass_driversmsg"></div>
                        <div class="col-sm-6" >
                            <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel99">Cancel</button>
                            <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="resetPasswordConfirm" ><?php echo BUTTON_SUBMIT; ?></button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="getManagerDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">MANAGER DETAILS</strong>
            </div>
            <div class="modal-body">
                <br>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-2"><br>
                        <img src="" class="img-circle dprofilePic style_prevu_kit" onerror="this.src = '<?php echo base_url('/../../pics/user.jpg ') ?>'" alt="pic" style="width:80px;height:80px;display: none;">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="dname"></span>
                            </div>

                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Email</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="demail"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Phone</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="dphone"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

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
                <form id="4a" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="form-group">
                        <label for="" class="control-label col-md-3">Soft Limit</label>
                        <div class="col-sm-6">
                            <span  class="abs_text"><b><?php echo $appCofig['currencySymbol']; ?></b></span>
                            <input type="text" class="form-control number" id="softLimitForDriver" name="softLimitForDriver" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $softLimitForDriver; ?>">
                        </div>
                        <div class="col-sm-3 errors softLimitForDriverErr"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-3">Hard Limit</label>
                        <div class="col-sm-6">
                            <span  class="abs_text"><b><?php echo $appCofig['currencySymbol']; ?></b></span>
                            <input type="text" class="form-control number" id="hardLimitForDriver" name="hardLimitForDriver" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $hardLimitForDriver; ?>">
                        </div>
                        <div class="col-sm-3 errors hardLimitForDriverErr"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success pull-right" id="creditSubmit" >Update</button>
            </div>
        </div>
		<script src="<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/intlTelInput.js"></script>

        <script>
                                var countryData = $.fn.intlTelInput.getCountryData();
                                $.each(countryData, function (i, country) {

                                    country.name = country.name.replace(/.+\((.+)\)/, "$1");
                                });
                                $("#frm_mobile").intlTelInput({
                                    //       allowDropdown: false,
                                    autoHideDialCode: false,
                                    autoPlaceholder: "off",
                                    dropdownContainer: "body",
                                    //       excludeCountries: ["us"],
                                    formatOnDisplay: false,
                                    geoIpLookup: function (callback) {
                                        $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                                            var countryCode = (resp && resp.country) ? resp.country : "";
                                            callback(countryCode);
                                        });
                                    },
                                    initialCountry: "auto",
                                    nationalMode: false,
                                    //       onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                                    placeholderNumberType: "MOBILE",
                                    //       preferredCountries: ['srilanka'],
                                    separateDialCode: true,
                                    utilsScript: "<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/utils.js",

                                });

                                $("#editfrm_mobile").intlTelInput({
                                    //       allowDropdown: false,
                                    autoHideDialCode: false,
                                    autoPlaceholder: "off",
                                    dropdownContainer: "body",
                                    //       excludeCountries: ["us"],
                                    formatOnDisplay: false,
                                    geoIpLookup: function (callback) {
                                        $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                                            var countryCode = (resp && resp.country) ? resp.country : "";
                                            callback(countryCode);
                                        });
                                    },
                                    initialCountry: "auto",
                                    nationalMode: false,
                                    //       onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                                    placeholderNumberType: "MOBILE",
                                    //       preferredCountries: ['srilanka'],
                                    separateDialCode: true,
                                    utilsScript: "<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/utils.js",

                                });




        </script>


    </div>
</div>

