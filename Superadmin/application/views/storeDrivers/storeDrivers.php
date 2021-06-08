<?php
if ($status == 1) {
    $vehicle_status = 'New';
    $new = "active";
} else if ($status == 3 && $db == 'my') {
    $vehicle_status = 'Accepted';
    $accept = "active";
} else if ($status == 3 && $db == 'mo') {
    $vehicle_status = 'Online&Free';
    $free = "active";
} else if ($status == 4) {
    $vehicle_status = 'Rejected';
    $reject = 'active';
} else if ($status == 9) {
    $vehicle_status = 'Timed Out';
    $timedOut = 'active';
} else if ($status == 30) {
    $vehicle_status = 'Offile';
    $offline = 'active';
} else if ($status == 567) {
    $vehicle_status = 'Booked';
    $booked = 'active';
}
?>
<!--<script src="<?php echo base_url() ?>mqttwsDriver.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>webSocketDriver.js" type="text/javascript"></script>-->
<style>

    span.multiselect-native-select {
        position: relative
    }
    .btn{
        border-radius: 25px !important;
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
$(document).ready(function (){

    $(document).ajaxComplete(function () {
        // console.log("hsdfsdf");
        var access_right_pg = '<?= $access_right_pg ?>';
        if (access_right_pg == 000) {
    //   base_url().'index.php?/superadmin/access_denied';
        } else if (access_right_pg == 100) {
            $('.cls110').remove();
            $('.cls111').remove();
        } else if (access_right_pg == 110) {
            $('.cls111').remove();
        } 
    });

    $(document).on('click','.fg-button',function(){
        $("#select_all").prop("checked", false);
    });  

      $("body").on('click','#select_all',function(){ 
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    

       $("body").on('click','.checkbox',function(){ 
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }   
       });

});
</script>
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

        $('#clearData').click(function ()
        {
            $('#start').val('');
            $('#end').val('');
        });
        
        

        //Load the all plans
        //get Driver Plan
//        $.ajax({
//            url: "<?php echo base_url('index.php?/superadmin') ?>/getAllPlans",
//            type: "POST",
//            data: {id: $('.checkbox:checked').val()},
//            dataType: 'json',
//            success: function (result)
//            {
//                var htmlForPlans = '';
//                htmlForPlans = '<option value="">Select Plan</option>';
//                $.each(result.data, function (i, value)
//                {
//                    htmlForPlans += '<option value=' + value._id.$oid + ' planName=' + value.planName + '>' + value.planName + '</option>';
//                });
//                $('#planFilter').append(htmlForPlans);
//                $('#planFilter').val('<?php echo $this->session->userdata('plan') ?>');
//
//            }
//        });

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


        $(document).on('click', '.deviceInfo', function ()
        {
            $('.make').text($(this).attr('make'));
            $('.model').text($(this).attr('model'));
            $('.os').text($(this).attr('os'));
            $('.lastLoginDate').text($(this).attr('last_active_dt'));
            $('.pushToken').text($(this).attr('push_token'));
            $('#deviceInfoPopUp').modal('show');

        });

//        $('#deviceLogs').click(function ()
//        {
        $(document).on('click', '.deviceLogsICON', function () {
            var val = $(this).val();

            if (val) {
                $('#device_log_data').empty();
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getDeviceLogs/driver",
                    type: "POST",
                    data: {mas_id: val},
                    dataType: 'json',
                    success: function (result)
                    {

                        var html = '';
                        var deviceType = '';
						var deviceOsVersion = '';
                        var os = '';
                        $('#d_name_history').text(result.user.firstName + ' ' + result.user.lastName)
                        $.each(result.data, function (index, logs) {
                            deviceType = '-';
                            if (logs.deviceType != 0 && logs.deviceType != "")
                            {
                                if (logs.deviceType == 1)
                                    deviceType = 'IOS';
                                else if (logs.deviceType == 2)
                                    deviceType = 'ANDRIOD';
                                else
                                    deviceType = 'WEB';
                            }
							if (logs.deviceOsVersion != 0 && logs.deviceOsVersion != "")
                            {
                                deviceOsVersion = logs.deviceOsVersion;
                            }else{
								deviceOsVersion = "N/A";
							}

//                                        deviceType = ((logs.deviceType != 0)?((logs.deviceType != 0)?'IOS':'ANDRIOD')):'-';
                            html = "<tr>";
                            html += "<td>" + deviceType + "</td>";
                            html += "<td>" + logs.appVersion + "</td>";
                            html += "<td>" + logs.deviceMake + "</td>";
                            html += "<td>" + logs.deviceModel + "</td>";
                            html += "<td>" + logs.deviceId + "</td>";
                            html += "<td>" + deviceOsVersion + "</td>";
                            html += "<td><span class='pushTokenShortShow'>" + logs.pushToken + "</span></td>";
                            html += "<td>" + moment(logs.deviceTime['$date']).format("DD-MM-YYYY HH:mm:ss") + "</td>";

                            html += "</tr>";
                            $('#device_log_data').append(html);

                        });


                    }
                });

                $('#deviceLogPopUp').modal('show');
            }
        });


//        $("#document_data").click(function () {
        $(document).on('click', '.documentsICON', function () {


            $("#display-data").text("");
            var val = $(this).val();
            if (val)
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#myModaldocument');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#myModaldocument').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

            }

            $('#doc_body').html('');

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/documentgetdata",
                type: "POST",
                data: {mas_id: val},
                dataType: 'json',
                success: function (result)
                {
                    

                    $.each(result, function (index, doc) {

                        var html = "<tr><td style='text-align: center;'>";
                        html += "Profile Pic</td><td style='text-align: center;'>" + "<a href=" + doc.profilePic + " target='_blank'><img src=" + doc.profilePic + " style='height:46px;width:52px' class='img-circle'></a></td></tr>";

                        html += "<tr><td style='text-align: center;'>Driving Licence Front</td>" + "<td style='text-align: center;'><a href=" + doc.driverLicense + "  target='_blank'><img src=" + doc.driverLicense + " style='height:46px;width:52px' class='img-circle'></a></td>"
                        html += "<tr><td style='text-align: center;'>Driving Licence Back</td>" + "<td style='text-align: center;'><a href=" + doc.driverLicenseBack + "  target='_blank'><img src=" + doc.driverLicenseBack + " style='height:46px;width:52px' class='img-circle'></a></td>"
                        html += "<tr><td style='text-align: center;'>Driving Licence Expiry</td>" + "<td style='text-align: center;'>" + doc.driverLicenseExp + "</td>"


                        html += "</tr>";
                        $('#doc_body').append(html);


                    });
                    $("#documentok").click(function () {
                        $('.close').trigger('click');
                    });

                }
            });
        });

//            $("#editdriver").click(function () {
        $(document).on('click', '.editICON', function () {


            $("#display-data").text("");
            var val = $(this).val();

            if (val)
            {

//               window.locaton = "<?php echo base_url() ?>index.php?/superadmin/editdriver" + val;
                window.location = "<?php echo base_url('index.php?/superadmin') ?>/editStoreDriver/" + val;
            }
        });



        $("#chekdel").click(function () {

            var tabURL = $("li.active").find('.changeMode').attr('data');

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
                $("#errorbox").text(<?php echo json_encode(POPUP_DRIVERS_DELETE); ?>);


                $("#yesdelete").click(function () {

//            if(confirm("Are you sure to Delete " +val.length + " Drivers")){
                    $.ajax({
                        url: "<?php echo base_url('index.php?/superadmin') ?>/deleteDrivers",
                        type: "POST",
                        data: {masterid: val},
                        success: function (result) {
                            $(".close").trigger('click');
                            refreshContent(tabURL);
                        }
                    });
                });
            } else {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ATLEAST_DELETE); ?>);
            }

        });

        $("#accept").click(function () {
            $('.errors').text('');

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 1) {

                $('#storeList').val("");
                $('#cityList').val("");
                $('#zonesList').val("");
                $('#plans').val("");
                $('#typeOperator').prop('checked', false);
                $('#typeOFreelancer').prop('checked', false);
                $('#typeStore').prop('checked', false);


                $('#confirmmodel').modal('show');
                //get Driver Plans
//                $.ajax({
//                    url: "<?php echo base_url('index.php?/superadmin') ?>/getAllPlans",
//                    type: "POST",
//                    data: {id: $('.checkbox:checked').val()},
//                    dataType: 'json',
//                    success: function (result)
//                    {
//                        var planExists = false;
//                        var htmlForPlans = '';
//                        $('#plans').empty();
//                        $('.deletedPlanTest').hide();
//                        if (result.driverData.planID)
//                        {
//                            if (result.driverData.planID.$oid)
//                            {
//
//                                htmlForPlans = '<option value="0">Select</option>';
//                                $.each(result.data, function (i, value)
//                                {
//                                    if (result.driverData.planID.$oid == value._id.$oid)
//                                    {
//                                        htmlForPlans += '<option value=' + value._id.$oid + ' planName=' + value.plan_name + ' selected>' + value.plan_name + '</option>';
//                                        planExists = true;
//                                        return false;
//                                    } else
//                                    {
//                                        htmlForPlans += '<option value=' + value._id.$oid + ' planName=' + value.plan_name + '>' + value.plan_name + '</option>';
//                                        planExists = false;
//                                        $('.deletedPlanTest').show();
//                                        $('.deletedPlanTest').text('The plan using this driver was deleted.Please move this driver to default or any other plan');
//                                    }
//                                });
//
////                                if (planExists)
////                                    $('.planDiv').hide();
////                                else
////                                    $('.planDiv').show();
//
//                                $('#plans').append(htmlForPlans);
//
//                            } else {
//
//                                htmlForPlans = '<option value="0">Select</option>';
//                                $.each(result.data, function (i, value)
//                                {
//                                    htmlForPlans += '<option value=' + value._id.$oid + ' planName=' + value.plan_name + '>' + value.plan_name + '</option>';
//                                });
//                                $('#plans').append(htmlForPlans);
//                                $('.planDiv').show();
//
//                                var currentdate = new Date();
//                                var datetime = currentdate.getFullYear() + "-" + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
//                                $('#time_hidden').val(datetime);
//
//                            }
//                        } else {
//
////                            $('.planDiv').show();
//                            htmlForPlans = '<option value="0">Select</option>';
//                            $.each(result.data, function (i, value)
//                            {
//                                htmlForPlans += '<option value=' + value._id.$oid + ' planName=' + value.plan_name + '>' + value.plan_name + '</option>';
//                            });
//
//                            $('#plans').append(htmlForPlans);
//                            $('#plans').val('0');
//
//                        }
//                    }
//                });

                $("#ve_compan").text("");

            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ATLEAST_FOR_ACCEPT); ?>);

            }

        });
        $("#updatePlan").click(function () {
            $('.errors').text('');

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 1) {
                $('#updatePlanPopUp').modal('show')

                //get Driver Plans
                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/getAllPlans",
                    type: "POST",
                    data: {id: $('.checkbox:checked').val()},
                    dataType: 'json',
                    success: function (result)
                    {
                        var htmlForPlans = '';
                        var newPlanID = '';
                        $('#newPlan').empty();
                        $('#currentPlan').empty();

                        //Get the last updated plan
                        if (result.driverData.newPlans)
                        {
                            $.each(result.driverData.newPlans, function (index, planNew)
                            {
                                newPlanID = planNew.planID.$oid;
                            });
                        } else {
                            newPlanID = result.driverData.planID.$oid;
                        }

                        //current plan
                        htmlForPlans = '<option value="0">Select</option>';
                        $.each(result.data, function (i, value)
                        {
                            var selected = '';
                            if (newPlanID == value._id.$oid)
                                selected = 'selected';

                            htmlForPlans += '<option value=' + value._id.$oid + ' planName="' + value.plan_name + '" ' + selected + '>' + value.plan_name + '</option>';

                        });
                        $('#currentPlan').append(htmlForPlans);
                        $('#currentPlan').attr('disabled', true);

                        //current plan
                        htmlForPlans = '';
                        htmlForPlans = '<option value="0">Select Plan</option>';
                        $.each(result.data, function (i, value)
                        {
                            htmlForPlans += '<option value=' + value._id.$oid + ' planName="' + value.plan_name + '">' + value.plan_name + '</option>';

                        });
                        $('#newPlan').append(htmlForPlans);
                    }
                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select only one driver to update the plan');

            }

        });

//        $('#shiftLogs').click(function(){
        $(document).on('click', '.shiftLogsICON', function () {
            var val = $(this).val()

            if (val) {
                window.location.href = "<?php echo base_url('index.php?') ?>/driver_controller/shiftLogsStore/" + val;
            } else {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Please select one driver to view the logs');
            }
        });

        $(".updateNewPlan").click(function () {

            var currentdate = new Date();
            var datetime = currentdate.getFullYear() + "-" + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
            $('#time_hidden').val(datetime);

            var val = $('.checkbox:checked').val();

            if ($('#newPlan').val() == '0')
            {
                $('.newPlanErr').text('Please select any one plan to update');
            } else if ($('#newPlan').val() == $('#currentPlan').val())
            {
                $('.newPlanErr').text('Plan should not be same as current plan');
            } else {
                var urlChunks = $("li.active").find('.changeMode').attr('data');

                var company = $("#company_select").val();

                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/updateNewPlan",
                    type: "POST",
                    data: {val: val, newPlanActiveDate: $('#time_hidden').val(), planID: $('#newPlan').val(), planName: $("#newPlan option:selected").attr('planName')},
                    dataType: 'json',
                    success: function (response)
                    {

                        $('.close').trigger('click');
                        refreshContent(urlChunks);

                    }
                });

                $(".close").trigger('click');

                $("#ve_compan").val('');
                $("#company_select").val('');
            }
        });
        $(document).on('click', '.checkboxAccept', function () {

            $('#confirmed').val($(this).attr('storeid'));

        });


        $("#confirmed").click(function () {

            var currentdate = new Date();
            var datetime = currentdate.getFullYear() + "-" + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
            $('#time_hidden').val(datetime);
            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var statusBan = urlChunks[urlChunks.length - 1];
            if (statusBan == 5 || statusBan == '5') {
                var banDriver = "bannedToActive";
            } else {
                var banDriver = "";
            }
           
            var val = $('.checkbox:checked').val();
            var storeId = $('#confirmed').val();
//            var storeId = 
//            alert(fieldID)
//            if($('#typeFreelancer').val() == '' && $('#typeStore').val() == ''){
//                $('#typeErr').text("Please select the driver type");
//            }
//            else if (($('#plans').val() == '0' )&& ($('#typeFreelancer').val() == "Freelancer"))
//            {
//                $('#plansErr').text("Please select any one plan to accept");
//            } 
//            else {

         
            var urlChunks = $("li.active").find('.changeMode').attr('data');

            $("#ve_compan").val('');

//                var company = $("#company_select").val();
//                var operatorId = $('#operatorList').val();
//                var operatorName = $('#operatorList option:selected').attr('data-name');
            var company = "";
            var operatorId = "";
            var operatorName = "";
            var cityName = $('#cityList option:selected').attr('data-name');
            var cityId = $('#cityList option:selected').val();
//                var storeId = $('#storeList option:selected').val();
            var storeName = $('#storeList option:selected').attr('data-name');
            var zoneIds = $("#zonesList").val();
            var zoneIdsValue = '';
            if (zoneIds === null) {
                zoneIdsValue = [];
            } else {
                zoneIdsValue = zoneIds;
            }


            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/acceptdrivers",
                type: "POST",
                data: {
                    val: val,
//                        operatorId: operatorId,
//                        operatorName: operatorName,
                    cityId: cityId,
                    cityName: cityName,
                    storeId: storeId,
                    storeName: storeName,
                    planActiveDate: $('#time_hidden').val(),
                    planID: $('#plans').val(),
                    planName: $("#plans option:selected").attr('planName'),
                    zoneIds: zoneIdsValue,
                    banDriver: banDriver
                },
                dataType: 'json',
                success: function (response)
                {

                    $('#acceptdrivermsg').modal('show');

                    $("#errorbox_accept").text(<?php echo json_encode(POPUP_MSG_ACCEPTED); ?>);

                    $("#accepted_msg").click(function () {
                        $('.close').trigger('click');
                    });
                    refreshContent(urlChunks);

                }
            });

            $(".close").trigger('click');

            $("#ve_compan").val('');
            $("#company_select").val('');
//            }
        });



//        $('#driverresetpassword').click(function () {
        $(document).on('click', '.resetPasswordICON', function () {

            $("#display-data").text("");
            $(".errors").text("");

            var val = $(this).val();
            $("#editpass_msg").val($(this).val());

//            if (val.length == 0) {
//                $('#alertForNoneSelected').modal('show');
//                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_RESET_PASSWORD); ?>);
//
//            } else if (val.length > 1)
//            {
//
//                $('#alertForNoneSelected').modal('show');
//                $("#display-data").text(<?php echo json_encode(POPUP_PASSENGERS_ONLYONEPASS); ?>);
//            } else
             if(val)   
            {
                $('#myModal1_driverpass').modal('show');
            }else{
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_PASSENGERS_ONLYONEPASS); ?>);
            }
        });



        $("#editpass_msg").click(function () {


            $("errorpass").text("");

            var newpass = $("#newpass1").val();
            var confirmpass = $("#confirmpass1").val();
            var reg = /^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])\S*$/;    //^[-]?(?:[.]\d+|\d+(?:[.]\d*)?)$/;

            if (newpass == "" || newpass == null)
            {
//                alert("please enter the new password");
                $("#errorpass_driversmsg").text(<?php echo json_encode(POPUP_PASSENGERS_PASSNEW); ?>);
            }
//            else if (!reg.test(newpass))
//            {
////                alert("please enter the password with atleast one chareacter and one letter");
//                $("#errorpass_driversmsg").text(<?php echo json_encode(POPUP_PASSENGERS_PASSVALID); ?>);
//            }
            else if (confirmpass == "" || confirmpass == null)
            {
//                alert("please confirm the password");
                $("#errorpass_driversmsg").text(<?php echo json_encode(POPUP_PASSENGERS_PASSCONFIRM); ?>);
            } else if (confirmpass != newpass)
            {
//                alert("please confirm the same password");
                $("#errorpass_driversmsg").text(<?php echo json_encode(POPUP_PASSENGERS_SAMEPASSCONFIRM); ?>);
            } else
            {
//                
                //Getting encrypted password


                $.ajax({
                    url: "<?php echo base_url('index.php?/superadmin') ?>/editdriverpassword",
                    type: 'POST',
                    data: {
                        newpass: newpass,
                        val: $(this).val()
                    },
                    dataType: 'JSON',
                    success: function (response)
                    {
                        if (response.flag != 1) {

                            $(".close").trigger('click');

                            var size = $('input[name=stickup_toggler]:checked').val()
                            var modalElem = $('#confirmmodelss');
                            if (size == "mini")
                            {
                                $('#modalStickUpSmall').modal('show')
                            } else
                            {
                                $('#confirmmodelss').modal('show')
                                if (size == "default") {
                                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                                } else if (size == "full") {
                                    modalElem.children('.modal-dialog').addClass('modal-lg');
                                }
                            }

                            $("#errorboxdatass").text(<?php echo json_encode(POPUP_DRIVERS_NEWPASSWORD); ?>);
                            $("#confirmedss").hide();


                            $(".newpass").val('');
                            $(".confirmpass").val('');
                        } else if (response.flag == 1)
                        {
                            $("#errorpass_driversmsg").text(<?php echo json_encode(POPUP_DRIVERS_NEWPASSWORD_FAILED); ?>);

                        }

                    }

                });


            }

        });


        $("#reject").click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).
                    get();
            if (val.length > 0) {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodels');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/superadmin/getAllDriversDetails",
                        type: "POST",
                        data: {mas_id: val},
                        dataType: 'json',
                        success: function (result)
                        {
                            var firstName = '';
                            if (result.driverCount > 0)
                            {

                                $.each(result.driverData, function (i, response)
                                {
                                    if (i == 0)
                                        firstName += response.firstName + ' ' + response.lastName;
                                    else
                                        firstName += ',' + response.firstName + ' ' + response.lastName;
                                });
//                                     console.log(firstName);
                                $("#errorboxdatas").text('This driver has on-going trips so first complete them before you make this driver in-active');
                            } else {
                                $("#errorboxdatas").text('Are you sure you want to reject drivers');
                            }
                        }
                    });
                    $('#confirmmodels').modal('show');

                }
                var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
               var urlChunks = $("li.active").find('.changeMode').attr('data');


                $("#confirmeds").click(function () {
                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/superadmin/rejectdrivers",
                        type: "POST",
                        data: {val: val, date: (new Date().getTime()) / 1000},
                        dataType: 'json',
                        success: function (result)
                        {
                            $('#confirmmodels').modal('hide');
                            refreshContent(urlChunks);
                        }
                    });
                });
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ATLEAST_RELECT); ?>);
            }

        });

        $("#ban").click(function () {
            $('.okButton').show();
            $('.closeButton').hide();
            $("#display-data").text("");
            $('#banReason').val("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length > 0) {
                $('#banMsg').text('Are you sure you want to ban drivers');
                $('#banPopUp').modal('show');
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ATLEAST_RELECT); ?>);
            }

        });

        $('.closeButton').click(function ()
        {
            $('.close').trigger('click');
        });
        $('#banButton1').click(function () {

            $('#banPopUp').modal('hide');
            $('#banPopUpReason').modal('show');
            $('#banReasonErr').text("");

        });

        $("#banButton").click(function () {
            $('#banReasonErr').text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            var tabURLData = $("li.active").find('.changeMode').attr('data').split('/');
            var tabURLData = $("li.active").find('.changeMode').attr('data');

            if ($('#banReason').val() == '' || $('#banReason').val() == null) {
                $('#banReasonErr').text("Please enter the reason");
            } else {
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/superadmin/banDrivers",
                    type: "POST",
                    data: {val: val, reason: $('#banReason').val()},
                    dataType: 'json',
                    success: function (result)
                    {
                        $('#banReason').val(" ");
                        if (parseInt(result.apiResponse) > 0)
                        {
                            console.log('here');
                            $('#banMsg').text('The driver has on-ongoing trips so please first manage those before you attempt to ban the driver');
                            $('.okButton').hide();
                            $('.closeButton').show();
                            $('#banReason').val("");
                        } else {

                            refreshContent(tabURLData);
                            $(".close").trigger('click');
                            $('#banReason').val("");
                        }
                    }
                });
            }
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
                window.location = "<?php echo base_url() ?>index.php?/superadmin/editdriver/" + val;
            }
        });

    });

</script>


<script type="text/javascript">
    var driverWalletEnable = <?php echo $appCofig['walletSettings']['walletDriverEnable']; ?>

    $(document).ready(function () {
        $('#storeList').hide();
        $('#operatorList').hide();
        $('#cityList').hide();
        $('#planDiv1').css("display", "none");
        $('.planDiv').hide();
        $('#confirmed').prop('disabled', true);

        $('#confirmed').prop('disabled', false);

        $('#typeOperator').click(function () {
            $('#confirmed').prop('disabled', false);
            $(".zonesDiv").addClass('hide');
            $('#operatorList').load('<?php echo base_url(); ?>index.php?/Superadmin/getOperatorList');
            $('#storeList').hide();
            $('#operatorList').show();
            $(".planDiv").show();

            $("#zonesList").multiselect('destroy');

//            $.ajax({
//                url: '<?php echo base_url(); ?>index.php?/superadmin/getAllZones',
//                type: 'GET',
//                dataType: 'json',
//                data: {},
//            }).done(function (json) {
//                console.log(json);
//                $("#zonesError").text("");
//
//                if (json.data.length === 0) {
//                    $("#zonesError").text("No stores found");
//
//                } else {
//                    $(".zonesDiv").removeClass('hide');
//                    for (var i = 0; i < json.data.length; i++) {
//                        var zone = "<option value=" + json.data[i]._id.$oid + "> " + json.data[i].title + "    (" + json.data[i].city + ")" + "</option>";
//                        $("#zonesList").append(zone);
//                    }
//                    $('#zonesList').multiselect({
//                        includeSelectAllOption: true,
//                        enableFiltering: true,
//                        enableCaseInsensitiveFiltering: true,
//                        buttonWidth: '260px',
//                    });
//                }
//
//
//            });
        });

        $('#typeStore').click(function () {
            $('#confirmed').prop('disabled', false);
            $('#storeList').load('<?php echo base_url(); ?>index.php?/Business/getStoreList');
            $('#storeList').show();
            $('#operatorList').hide();
            $("#zonesList").multiselect('destroy');
            $('#cityList').hide();
            $(".zonesDiv").addClass('hide');
            $(".planDiv").hide()

            // $.ajax({
            //     url: '<?php echo base_url(); ?>index.php?/superadmin/getAllZones',
            //     type: 'GET',
            //     dataType: 'json',
            //     data: {   },
            // }).done(function(json) {
            //     $("#zonesList").multiselect('destroy');
            //     console.log(json);
            //     for (var i = 0; i< json.data.length; i++) {
            //     var beacon = "<option value="+ json.data[i]._id + "> " + json.data[i].title  +"    ("+ json.data[i].city + ")"  +"</option>";
            //     $("#zonesList").append(beacon);
            // }                
            // });
        });
        $('#cityList').load('<?php echo base_url(); ?>index.php?/City/getAllCityList');
//        $('#typeFreelancer').click(function () {
//            
//            $('#confirmed').prop('disabled',false);
//            $('#operatorList').hide();
//            $('#storeList').hide();
//            $('#cityList').load('<?php echo base_url(); ?>index.php?/City/getAllCityList');
//            $('#cityList').show();
//            $("#zonesList").multiselect('destroy');
//            $(".zonesDiv").addClass('hide');
//            $(".planDiv").show()
//
//        });
        $("#storeList").change(function () {
            $("#zonesList").empty();
            $("#zonesList").multiselect('destroy');
            $(".zonesDiv").addClass('hide');
            var storeId = $("#storeList").val();
            $("#zonesError").text("");
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?/superadmin/getZonesByStoreId/' + storeId,
                type: 'GET',
                dataType: 'json',
                data: {},
            }).done(function (json) {
                console.log(json);
                console.log(json.data.length)
                if (json.data.length === 0) {
                    $("#zonesError").text("No stores found");

                } else {
                    $(".zonesDiv").removeClass('hide');
                    for (var i = 0; i < json.data.length; i++) {
                        var zone = "<option value=" + json.data[i]._id.$oid + "> " + json.data[i].title + "    (" + json.data[i].city + ")" + "</option>";
                        $("#zonesList").append(zone);
                    }
                    $('#zonesList').multiselect({
                        includeSelectAllOption: true,
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering: true,
                        buttonWidth: '260px',
                    });
                }
            });
        });
        $("#cityList").change(function () {
            $("#zonesList").empty();
            $("#zonesList").multiselect('destroy');
            $(".zonesDiv").addClass('hide');
            var cityId = $("#cityList").val();
            $("#zonesError").text("");
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?/superadmin/getZonesByCity/' + cityId,
                type: 'GET',
                dataType: 'json',
                data: {},
            }).done(function (json) {
                console.log(json);
                console.log(json.data.length)
                if (json.data.length === 0) {
                    $("#zonesError").text("No stores found");

                } else {
                    $(".zonesDiv").removeClass('hide');
                    for (var i = 0; i < json.data.length; i++) {
                        var zone = "<option value=" + json.data[i]._id.$oid + "> " + json.data[i].title + "    (" + json.data[i].city + ")" + "</option>";
                        $("#zonesList").append(zone);
                    }
                    $('#zonesList').multiselect({
                        includeSelectAllOption: true,
                        enableFiltering: true,
                        enableCaseInsensitiveFiltering: true,
                        buttonWidth: '260px',
                    });
                }
            });
        });

//        $('#storeList').multiselect({
//            includeSelectAllOption: true,
//            enableFiltering: true,
//            enableCaseInsensitiveFiltering : true,
//            buttonWidth: '260px',
//            maxHeight: 300,                
//        });
//        $('#operatorList').multiselect({
//            includeSelectAllOption: true,
//            enableFiltering: true,
//            enableCaseInsensitiveFiltering : true,
//            buttonWidth: '260px',
//            maxHeight: 300,                
//        });

        $('.cs-loader').show();

        var table = $('#big_table');
        var searchInput = $('#search-table');
        $('.hide_show').hide();
        searchInput.hide();
        table.hide();


        $.ajax({
            url: "<?php echo base_url() ?>index.php?/superadmin/getDriversCountForStore",
            type: "POST",
            dataType: 'json',
            async: true,
            success: function (response)
            {
                $('.newDriverCount').text(response.data.New);
                $('.approvedDriverCount').text(response.data.Approved);
                $('.timedOutDriverCount').text(response.data.timedOut);
                $('.acceptedDriverCount').text(response.data.Accepted);
                $('.inactiveDriverCount').text(response.data.Inactive);
                $('.rejectedDriverCount').text(response.data.Rejepted);
                $('.bannedDriverCount').text(response.data.Banned);
                $('.onlineDriverCount').text(response.data.Online);
                $('.offlineDriverCount').text(response.data.offline);
                $('.loggedOutDriverCount').text(response.data.loggedOut);
            }
        });

        var status = '<?php echo $status; ?>';

        if (status == 1) {

            $("#display-data").text("");
//            alert('asdf');
            $('#offlineDriver').hide();
            $('#driverresetpassword').hide();
            $('#chekdel').show();
            $('#reject').show();
            $('#accept').show();
            $('#add').show();
            $('#ban').hide();
            $('#driver_logout').hide();
            $('#updatePlan').hide();
            $('#shiftLogs').hide();

        }



        $('#my1').click(function () {
            $("#display-data").text("");

            $('#driverresetpassword').hide();
            $('#chekdel').show();
            $('#reject').show();
            $('#accept').show();
            $('#add').show();
            $('#updatePlan').hide();
            $('#shiftLogs').hide();

        });
        $('#my3').click(function () {
            $("#display-data").text("");
            $('#driverresetpassword').show();
            $('#chekdel').show();
            $('#reject').hide();
            $('#accept').hide();
            $('#add').hide();
            $('#updatePlan').show();
            $('#shiftLogs').hide();


        });

        $('#my4').click(function () {
            $("#display-data").text("");

            $('#driverresetpassword').hide();
            $('#chekdel').show();
            $('#reject').hide();
            $('#editdriver').hide();
            $('#accept').show();
            $('#add').hide();
            $('#updatePlan').hide();
            $('#shiftLogs').hide();


        });
        $('#my5').click(function () {
            $("#display-data").text("");
            $('#driverresetpassword').hide();
            $('#chekdel').show();
            $('#reject').hide();
            $('#accept').show();
            $('#add').hide();
            $('#ban').hide();
            $('#updatePlan').hide();
            $('#shiftLogs').hide();

        });


        $('#mo3').click(function () {

            $("#display-data").text("");

            $('#driverresetpassword').hide();
            $('#chekdel').hide();
			$('#ban').hide();
            $('#reject').hide();
            $('#accept').hide();

            $('#editdriver').hide();
            $('#joblogs').hide();
            $('#driverresetpassword').hide();
            $('#document_data').show();
            $('#add').hide();
            $('#updatePlan').hide();
            $('#shiftLogs').show();

        });
        $('#mo30').click(function () {
            $("#display-data").text("");

            $('#driverresetpassword').hide();
            $('#chekdel').hide();
            $('#reject').hide();
            $('#accept').hide();
            $('#editdriver').hide();
            $('#driverresetpassword').hide();
            $('#document_data').show();
            $('#add').hide();
            $('#updatePlan').hide();
            $('#shiftLogs').hide();

        });
        $('#mo567').click(function () {
            $("#display-data").text("");

            $('#driverresetpassword').hide();
            $('#chekdel').hide();
            $('#editdriver').hide();
            $('#reject').hide();
            $('#driverresetpassword').hide();
            $('#document_data').show();
            $('#reject').hide();
            $('#accept').hide();
            $('#add').hide();
            $('#updatePlan').hide();
            $('#shiftLogs').hide();

        });


        setTimeout(function () {
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_storedrivers/my/' + status,
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
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"width": "12%"},
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
                },
                "columnDefs": [
		{  targets: "_all",
			orderable: false 
		}
],

            };

            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {

                table.fnFilter($(this).val());
            });

        }, 1000);



        $('#big_table').on('init.dt', function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            var forwhat = urlChunks[urlChunks.length - 2];
            if (forwhat == 'my') {
                if (status == 1)
                    $('#big_table').dataTable().fnSetColumnVis([0,1,7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19], false);
//                      $('#big_table').dataTable().fnSetColumnVis([6, 9, 10, 11, 12, 13, 14], false);


            }
        });


        $("#offlineDriver").click(function () {

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 1) {

                $('#offlineModalDriver').modal('show');
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Invalid Selection");

            }

        });

        $(document).on('click', '.makeOfflineICON', function (){

              var val = $(this).val();
            tabURL = $("li.active").find('.changeMode').attr('data');

            $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/makeDriverOffline",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {

                    $(".close").trigger('click');

                    refreshContent(tabURL);
                }

            });
        });
       $(document).on('click', '.manualLogoutICON', function (){

            $("#display-data").text("");
            var val = $(this).val();
			$("#ok_to_logout").val(val);
            if (val.length > 0) {

                $('#Model_manual_logout').modal('show');
            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_ATLEAST_LOGOUT); ?>);

            }

        });

        $('#add').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                window.location.href = "<?php echo base_url() ?>index.php?/superadmin/addnewstoredriver";

            } else {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Invalid Selection...");
            }
        });

        $("#ok_to_logout").click(function () {
            var val =$(this).val();
            tabURL = $("li.active").find('.changeMode').attr('data');

            $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/driver_logout",
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
//refreshContent(tabURL);
            $("#ve_compan").val('');
            $("#company_select").val('');

        });

        $('.changeMode').click(function () {

            var tab_id = $(this).attr('data-id');

            if (currentTab != tab_id)
            {
                $('#big_table').hide();

                currentTab = tab_id;
                $('#big_table').hide();
                $("#display-data").text("");


                if ($(this).data('id') == 1) {
                    $('#chekdel').show();
                    $('#reject').show();
                    $('#accept').show();
                    $('#add').show();
                    $('#document_data').show();
                    $('#driverresetpassword').hide();
                    $('#editdriver').show();
                    $('#driver_logout').hide();
                    $('#ban').hide();
                    $('#updatePlan').hide();
                    $('#offlineDriver').hide();
                    $('#shiftLogs').hide();
                } else if ($(this).data('id') == 2) {
                    $("#display-data").text("");
                    $('#driverresetpassword').show();
                    $('#chekdel').show();
                    $('#reject').hide();
                    $('#document_data').show();
                    $('#joblogs').show();
                    $('#editdriver').show();
                    $('#driver_logout').hide();
                    $('#ban').show();
                    $('#updatePlan').show();
                    $('#offlineDriver').hide();
                    $('#shiftLogs').hide();

                } else if ($(this).data('id') == 3) {
                    $("#display-data").text("");
                    $('#driverresetpassword').hide();
                    $('#chekdel').show();
                    $('#reject').hide();
                    $('#add').hide();
                    $('#reject').hide();
                    $('#document_data').show();
                    $('#editdriver').hide();
                    $('#ban').hide();
                    $('#updatePlan').hide();
                    $('#offlineDriver').hide();
                    $('#shiftLogs').hide();

                } else if ($(this).data('id') == 4) {
                    $('#offlineDriver').show();
                    $('#driver_logout').show();
                    $('#reject').hide();
                    $('#ban').hide();
                    $('#add').hide();
                    $('#document_data').show();
                    $('#updatePlan').hide();
                    $('#shiftLogs').hide();
                } else if ($(this).data('id') == 5) {
                    $('#driver_logout').show();
                    $('#reject').hide();
                    $('#ban').show();
                    $('#document_data').show();
                    $('#updatePlan').hide();
                    $('#offlineDriver').hide();
                    $('#shiftLogs').hide();
                } else if ($(this).data('id') == 6) {
                    $('#driver_logout').hide();
                    $('#reject').hide();
                    $('#ban').show();
                    $('#document_data').show();
                    $('#updatePlan').hide();
                    $('#offlineDriver').hide();

                } else if ($(this).data('id') == 7) {
                    $('#reject').hide();
                    $('#chekdel').show();
                    $('#accept').show();
                    $('#add').hide();
                    $('#deviceLogs').hide();
                    $('#editdriver').hide();
                    $('#driver_logout').hide();
                    $('#document_data').show();
                    $('#driverresetpassword').hide();
                    $('#offlineDriver').hide();
                    $('#updatePlan').hide();
                    $('#shiftLogs').hide();
                } else if ($(this).data('id') == 8) {
                    $("#display-data").text("");
                    $('#driverresetpassword').show();
                    $('#chekdel').show();
                    $('#reject').hide();
                    $('#document_data').show();
                    $('#joblogs').show();
                    $('#editdriver').show();
                    $('#driver_logout').hide();
                    $('#ban').show();
                    $('#updatePlan').show();
                    $('#offlineDriver').hide();
                    $('#shiftLogs').hide();

                } else if ($(this).data('id') == 0) {
                    $("#display-data").text("");
                    $('#driverresetpassword').show();
                    $('#chekdel').show();
                    $('#editdriver').hide();
                    $('#reject').hide();
                    $('#document_data').show();
                    $('#joblogs').show();
                    $('#accept').hide();
                    $('#updatePlan').hide();
                    $('#add').hide();
                    $('#driver_logout').hide();
                    $('#ban').show();
                    $('#shiftLogs').hide();
                    $('#offlineDriver').hide();

                } else if ($(this).data('id') == 9) {
                    $("#display-data").text("");
                    $('#driverresetpassword').show();
                    $('#chekdel').show();
                    $('#reject').hide();
                    $('#accept').hide();
                    $('#add').hide();
                    $('#document_data').show();
                    $('#joblogs').show();
                    $('#editdriver').show();
                    $('#driver_logout').hide();
                    $('#ban').show();
                    $('#updatePlan').show();
                    $('#shiftLogs').show();
                    $('#offlineDriver').hide();
                }


                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/superadmin/getDriversCountForStore",
                    type: "POST",
                    dataType: 'json',
                    async: true,
                    success: function (response)
                    {
                        $('.newDriverCount').text(response.data.New);
                        $('.approvedDriverCount').text(response.data.Approved);
                        $('.timedOutDriverCount').text(response.data.timedOut);
                        $('.acceptedDriverCount').text(response.data.Accepted);
                        $('.inactiveDriverCount').text(response.data.Inactive);
                        $('.rejectedDriverCount').text(response.data.Rejepted);
                        $('.bannedDriverCount').text(response.data.Banned);
                        $('.onlineDriverCount').text(response.data.Online);
                        $('.offlineDriverCount').text(response.data.offline);
                        $('.loggedOutDriverCount').text(response.data.loggedOut);
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
                    },
                    "columnDefs": [
		{  targets: "_all",
			orderable: false 
		}
],

                };

                $('.tabs_active').removeClass('active');

                $(this).parent().addClass('active');
                table.dataTable(settings);
                var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                var status = urlChunks[urlChunks.length - 1];


                switch (parseInt(status)) {
                    case 0:
                        $('#big_table').dataTable().fnSetColumnVis([0,1,7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18, 19], false);
                        break;
                    case 1:
                        $('#big_table').dataTable().fnSetColumnVis([0,1,7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19], false);
                        break;
                    case 2:<?php
if (!$appCofig['walletSettings']['walletDriverEnable']) {
    ?>
                            $('#big_table').dataTable().fnSetColumnVis([0, 1, 7, 9, 12, 13, 14, 15, 17], false);
    <?php
} else {
    ?>
                            $('#big_table').dataTable().fnSetColumnVis([0, 1, 7, 9, 14, 15, 16, 17], false);
    <?php
}
?>
                        break;
                    case 3:
                        $('#big_table').dataTable().fnSetColumnVis([0,1,7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18, 19], false);
                        break;
                    case 4:
                        $('#big_table').dataTable().fnSetColumnVis([0,1,7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 19], false);
                        break;
                    case 5:
                        $('#big_table').dataTable().fnSetColumnVis([0,1,7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17], false);
                        break;
                    case 6:
                        $('#big_table').dataTable().fnSetColumnVis([0, 1, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 22], false);
                        break;
                    case 7:
                        $('#big_table').dataTable().fnSetColumnVis([0, 1, 4, 5, 6, 7, 9, 10, 11, 12, 13, 14, 16, 17, 18], false);
                        break;
                    case 8:
                        $('#big_table').dataTable().fnSetColumnVis([0, 1, 7, 9, 11, 12, 13, 14, 15, 16, 17, 18], false);
                        break;
                    case 9:
                        $('#big_table').dataTable().fnSetColumnVis([0,1,7, 8, 9, 13, 14, 17, 18, 19], false);
                        break;

                    case 30:
                        $('#big_table').dataTable().fnSetColumnVis([0,1,7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18, 19], false);
                        break;
                    case 567:
                        $('#big_table').dataTable().fnSetColumnVis([0,1,7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18, 19], false);
                        break;




                }
            }

        });


        $(document).on('click', '.getDriverDetails', function ()
        {
            $('.dname').text('');
            $('.demail').text('');
            $('.dphone').text('');

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getDriverDetails",
                type: "POST",
                data: {mas_id: $(this).attr('mas_id')},
                dataType: 'json',
                success: function (result) {

                    var accoutType = (result.driverData.accountType == 2) ? 'Operator' : 'Freelancer';
                    var myDate = new Date(result.driverData.createdDate * 1000);
                    $('.dprofilePic').attr('src', '');
                    $('.dprofilePic').hide();
                    if (result.driverData.firstName != null)
                    {
                        
                        $('.dname').text(result.driverData.firstName + ' ' + result.driverData.lastName);
                        $('.demail').text(result.driverData.email);
                        $('.dphone').text(result.driverData.countryCode + result.driverData.mobile);
                        $('.dbusinessType').text(myDate);

                        if (result.driverData.image != '')
                        {
                            $('.dprofilePic').attr('src', result.driverData.profilePic);
                            $('.dprofilePic').show();
                        }
                    }

                    $('#getDriverDetails').modal('show');//Code in footer.php

                }
            });
        });

        $(document).on('change', '.switch', function ()
        {

            var tabURL = $("li.active").find('.changeMode').attr('data');
            var isEnable = 0;
            if ($('#' + $(this).attr('data-id')).is(':checked'))
                isEnable = 1;

            $.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/enDisCreditDriver",
                type: "POST",
                data: {mas_id: $(this).attr('data-id'), flag: isEnable},
                dataType: 'json',
                success: function (result) {
                    refreshContent(tabURL);
                }
            });
        });

        $(document).on('click', '.walletSettings', function ()
        {
            driverID = $(this).attr('driverID');
            $(".errors").text("");
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/superadmin/getWalletForDriver",
                type: "POST",
                data: {mas_id: driverID},
                dataType: "JSON",
                success: function (result) {
                    //Reset the fields
                    $('#softLimitForDriver').val('');
                    $('#hardLimitForDriver').val('');

                    if (result.flag == 0)
                    {
                        $('#softLimitForDriver').val(result.data.walletSoftLimit);
                        $('#hardLimitForDriver').val(result.data.walletHardLimit)
                    } else {
                        $('#softLimitForDriver').val(result.data.walletSettings.softLimitDriver);
                        $('#hardLimitForDriver').val(result.data.walletSettings.hardLimitDriver)
                    }
                }
            });
            $('#walletSettingsPopUp').modal('show');

        });
        $("#creditSubmit").click(function () {
            var tabURL = $("li.active").find('.changeMode').attr('data');


            if ($('#softLimitForDriver').val() == '')
                $('.softLimitForDriverErr').text('Soft limit should not be empty');
            else if ($('#hardLimitForDriver').val() == '')
                $('.hardLimitForDriverErr').text('Hard limit should not be empty');
            else if (parseInt($('#hardLimitForDriver').val()) < parseInt($('#softLimitForDriver').val()) || parseInt($('#hardLimitForDriver').val()) == parseInt($('#softLimitForDriver').val()))
                $('.hardLimitForDriverErr').text('Hard limit should be greater than soft limit');
            else {

                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/superadmin/walletUpdateForDriver",
                    type: "POST",
                    data: {driverID: driverID, softLimit: $('#softLimitForDriver').val(), hardLimit: $('#hardLimitForDriver').val()},
                    dataType: "JSON",
                    success: function (result) {
                        refreshContent(tabURL);
                        $(".close").trigger('click');
                    }
                });

            }
        });

    });

    function refreshContent(url) {

        $.ajax({
            url: "<?php echo base_url() ?>index.php?/superadmin/getDriversCountForStore",
            type: "POST",
            dataType: 'json',
            async: true,
            success: function (response)
            {
                $('.newDriverCount').text(response.data.New);
                $('.approvedDriverCount').text(response.data.Approved);
                $('.timedOutDriverCount').text(response.data.timedOut);
                $('.acceptedDriverCount').text(response.data.Accepted);
                $('.inactiveDriverCount').text(response.data.Inactive);
                $('.rejectedDriverCount').text(response.data.Rejepted);
                $('.bannedDriverCount').text(response.data.Banned);
                $('.onlineDriverCount').text(response.data.Online);
                $('.offlineDriverCount').text(response.data.offline);
                $('.loggedOutDriverCount').text(response.data.loggedOut);
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
            },
            "columnDefs": [
		{  targets: "_all",
			orderable: false 
		}
],

        };

        table.dataTable(settings);
        var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
        var status = urlChunks[urlChunks.length - 1];
        var forwhat = urlChunks[urlChunks.length - 2];
        if (forwhat == 'my') {
            switch (parseInt(status)) {
                case 1:
                    $('#big_table').dataTable().fnSetColumnVis([7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19], false);
                    break;
                case 3:
                    $('#big_table').dataTable().fnSetColumnVis([7, 8, 9, 10, 11, 12, 13, 15, 17, 18, 19], false);
                    break;
                case 4:
                    $('#big_table').dataTable().fnSetColumnVis([7, 8, 9, 10, 11, 12, 14, 15, 16, 17, 19], false);
                    break;
                case 5:
                    $('#big_table').dataTable().fnSetColumnVis([7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17], false);
                    break;
                case 8:
                    $('#big_table').dataTable().fnSetColumnVis([0, 1, 7, 9, 11, 12, 13, 14, 15, 16, 17, 18, 22], false);
                    break;
                case 9:
                    $('#big_table').dataTable().fnSetColumnVis([8, 9, 13, 17, 18, 19], false);
                    break;

            }


        } else {

            switch (parseInt(status)) {

                case 3:
                    $('#big_table').dataTable().fnSetColumnVis([7, 8, 9, 10, 11, 12, 13, 15, 17, 18, 19], false);
                    break;
                case 30:
                    $('#big_table').dataTable().fnSetColumnVis([7, 8, 9, 10, 11, 12, 13, 15, 17, 18, 19], false);
                    break;
                case 587:
                    $('#big_table').dataTable().fnSetColumnVis([1, 8, 10, 11, 12, 13, 14, 15, 16, 17, 19, 20, 21, 22], false);
                    break;
            }

        }

    }

</script>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;">

            <strong >STORE DRIVERS</strong>
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">



                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  bg-white whenclicked">
                        <li id= "my1" class="tabs_active <?php echo $new ?>" style="cursor:pointer">
                            <a  class="changeMode New_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_storedrivers/my/1" data-id="1"><span><?php echo LIST_NEW; ?></span><span class="badge newDriverCount" style="background-color: #337ab7;"></span></a>
                        </li>
                        <li id= "my9" class="tabs_active <?php echo $accept ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_storedrivers/my/9" data-id="9"><span><?php echo LIST_APPROVED; ?></span> <span class="badge approvedDriverCount" style="background-color: #5bc0de;"></span></a>
                        </li>

                        <!--
<!--                        <li id= "my3" class="tabs_active <?php echo $accept ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/my/3" data-id="2"><span><?php echo LIST_ACCEPTED; ?></span> <span class="badge bg-green acceptedDriverCount"></span></a>
                        </li>
                        <li id= "my8" class="tabs_active <?php echo $accept ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/my/8" data-id="8"><span>INACTIVE</span> <span class="badge inactiveDriverCount" style="background-color: #745535;"></span></a>
                        </li>-->

                        <li id= "my4" class="tabs_active <?php echo $reject ?>" style="cursor:pointer">
                            <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_storedrivers/my/4" data-id="3"><span><?php echo LIST_REJECTED_DRIVER; ?></span> <span class="badge rejectedDriverCount" style="background-color:#f0ad4e;"></span></a>
                        </li>
                        <li id= "my5" class="tabs_active" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_storedrivers/my/5" data-id="7"><span><?php echo LIST_BANNED; ?></span> <span class="badge bannedDriverCount" style="background-color:#33312f;"></span></a>
                        </li>
                        <!--                        <li id= "my5" class="tabs_active" style="cursor:pointer">
                                                    <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_drivers/my/5" data-id="7"><span>DUE FOR RENEWAL</span> <span class="badge renewalDriverCount" style="background-color:#f0ad4e;"></span></a>
                                                </li>-->

                        <li id= "my0" class="tabs_active <?php echo $timedOut ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_storedrivers/my/0" data-id="0"><span><?php echo LIST_TIMED_OUT; ?></span> <span class="badge  timedOutDriverCount" style="background-color:#12415e"></span></a>
                        </li>
                        <li id= "mo3" class="tabs_active <?php echo $free ?>" style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_storedrivers/mo/3" data-id="4"><span>ONLINE</span><span class="badge bg-green onlineDriverCount"></span></a>
                        </li>
                        <li id= "mo30" class="tabs_active <?php echo $offline ?>" style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_storedrivers/mo/30" data-id="5"><span><?php echo LIST_OFFLINE; ?> </span><span class="badge offlineDriverCount" style="background-color: darkgray;"></span></a>
                        </li>
                        <li id= "mo567" class="tabs_active <?php echo $booked ?>" style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php?/superadmin/datatable_storedrivers/mo/567" data-id="6"><span><?php echo LIST_LOGGED_OUT; ?></span> <span class="badge loggedOutDriverCount" style="background-color: indianred;"></span></a>
                        </li>
                    </ul>

                    <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                        <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">


                            <!--<div class="cls111"><button class="btn btn-info pull-right m-t-10 " id="shiftLogs"  style="margin-top: 5px;">Shift Logs</button></div>-->
                            <!--<div class="cls111"><button class="btn btn-primary pull-right m-t-10 " id="updatePlan"  style="margin-top: 5px;">Update Plan</button></div>-->
                            <!--<div class="cls100"><button class="btn btn-primary pull-right m-t-10 " id="deviceLogs"  style="margin-top: 5px;">Device Logs</button></div>-->
                            <!--<div class="cls111"><button class="btn btn-primary pull-right m-t-10 " id="driver_logout"  style="margin-top: 5px;"><?php// echo BUTTON_MANUAL_LOGOUT; ?></button></div>-->

<!--                            <div class="cls100"><button class="btn btn-primary pull-right m-t-10 " id="document_data"  style="margin-top: 5px;"><?php echo BUTTON_DOCUMENT ?></button></div>
                            <div class="cls111"> <button class="btn btn-primary pull-right m-t-10" id="driverresetpassword" style="margin-top: 5px;"><?php echo BUTTON_RESETPASSWORD; ?></button></a></div>-->

                            <div class="cls111"> <button class="btn btn-danger pull-right m-t-10" id="chekdel" style="margin-top: 5px;"><?php echo BUTTON_DELETE; ?></button></a></div>
                            <!--<div class="cls111"> <button class="btn btn-success pull-right m-t-10" id="offlineDriver" style="margin-top: 5px;">Make Offline</button></a></div>-->
                            <div class="cls111"> <button class="btn btn-warning pull-right m-t-10" id="reject" style="margin-top: 5px;">Reject</button></a></div>
                            <div class="cls111"> <button class="btn btn-warning pull-right m-t-10" id="ban" style="margin-top: 5px;">Ban</button></a></div>
                            <div class="cls111"> <button class="btn btn-success pull-right m-t-10" id="accept" style="margin-top: 5px;"><?php echo BUTTON_ACTIVE; ?></button></a></div>


                            <!--<div class="cls111"><button class="btn btn-info pull-right m-t-10 " id="editdriver" style="margin-top: 5px;"><?php echo BUTTON_EDIT; ?></button></div>-->
                            <div class="cls110"> <button class="btn btn-primary pull-right m-t-10" id="add" style="margin-top: 5px;"><?php echo BUTTON_ADD; ?></button></div>

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
                                        <div class="hide_show">
                                            <!--                                            <div class="form-group" >
                                                                                            <div class="col-sm-8" style="width:166px;" >
                                                                                                <select id="operatorType" name="operatorType" class="form-control"  style="background-color:gainsboro;height:30px;font-size:12px;">
                                                                                                    <option value="">All</option>
                                                                                                    <option value="1">Freelancer</option>
                                                                                                    <option value="2">Operator</option>
                                                                                                    <option value="3">Store</option> 
                                                                                                </select>
                                            
                                                                                            </div>
                                                                                        </div>-->

                                            <!--                                            <div class="form-group showOperators" style="display:none;">
                                                                                            <div class="col-sm-8" style="width: auto;" >
                                            
                                                                                                <select id="companyid" name="company_select" class="form-control"  style="background-color:gainsboro;height:30px;font-size:12px;">
                                                                                                    <option value="0">Select</option>
                                                                                                </select>
                                            
                                                                                            </div>
                                                                                        </div>-->
                                            <div class="form-group showStores" style="display:none;">
                                                <div class="col-sm-8" style="width: auto;" >

                                                    <select id="storeId" name="store_select" class="form-control"  style="background-color:gainsboro;height:30px;font-size:12px;">
                                                        <option value="0">Select</option>
                                                    </select>

                                                </div>
                                            </div>

                                        </div>


                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>
                                    </div>

                                    <!--                                    <div class="row hide_show" style="margin-top:8px;display:none;">
                                                                            <div class="form-group">
                                                                                <div class="col-sm-8" style="width:166px;" >
                                                                                    <select id="planFilter" name="planFilter" class="form-control"  style="background-color:gainsboro;height:30px;font-size:12px;">
                                    
                                                                                    </select>
                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>-->
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


<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">ACCEPT</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                <form id="" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="form-group">
                        <label for="fname" class="col-sm-12 control-label">Please make sure you have validated all the documents submitted before you approve the driver’s membership</label>


                    </div>
                    <hr/>
                    <!--                    <div class="form-group">
                                            <div class="">
                                                <label>Activate As</label>
                                            </div>
                                            <div class="">
                                                <input class="" type="radio" name="type" id="typeOperator" value="Operator"/>
                                                <label>Operator</label>
                                            </div>
                                            <div class="">
                                                <input class="" type="radio" name="type" id="typeFreelancer" value="Freelancer"/>
                                                <label>Freelancer</label>
                                            </div>
                                            <div class="">
                                                <input type="radio" name="type" id="typeStore" value="store"/>
                                                <label>Store</label>
                                            </div>
                                            <span id="typeErr"></span>   
                                        </div>-->
                    <div class="">
                        <select class="form-control" id="operatorList" name="operatorList">
                            <option data-name="" data-id="" value="" name="">Select Operator's</option>
                        </select>
                    </div>
                    <div class="">
                        <select class="form-control" id="storeList" name="storeList">
                            <option data-name="" data-id="" value="" name="">Select Store's</option>
                        </select>
                    </div>
                    <div class="">
                        <select class="form-control" id="cityList" name="cityList">
                            <option data-name="" data-id="" value="" name="">Select City's</option>
                        </select>
                    </div>
                    <hr/>

                    <div class="form-group planDiv" id="planDiv1">
                        <span class="deletedPlanTest" style="display:none;font-weight:600;"></span>
                        <br>
                        <br>
                        <label for="fname" class="col-sm-2 control-label">Plans<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" id="plans" name="plans">
                                <option value="0"></option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 errors" id="plansErr"></div>
                    </div>
                    <div class="form-group zonesDiv hide">
                        <span class="deletedPlanTest" style="display:none;font-weight:600;"></span>
                        <br>
                        <br>
                        <label for="fname" class="col-sm-2 control-label">Zones<span style="" class="MandatoryMarker"></span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" id="zonesList" name="plans" multiple="multiple">
                                <!-- <option value="0">Select</option> -->
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 errors" id="zonesError" style="margin-left: -182px;"></div>
                    </div>

                </form>
            </div>


            <div class="modal-footer">
                <div class="row">

                    <div class="col-sm-6 " id="ve_compan"></div>
                    <div class="col-sm-6" >
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="confirmed" >ACCEPT</button></div>
                    </div>
                </div>
            </div>
        </div><!--
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="updatePlanPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">UPDATE PLAN</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                <form id="" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

                    <div class="form-group">

                        <label for="fname" class="col-sm-3 control-label">Current Plan<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <select class="form-control" id="currentPlan" name="currentPlan">
                                <option value="0"></option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 errors"></div>
                    </div>
                    <div class="form-group">

                        <label for="fname" class="col-sm-3 control-label">New Plan<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <select class="form-control" id="newPlan" name="newPlan">
                                <option value="0"></option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 errors newPlanErr"></div>
                    </div>

                </form>
            </div>


            <div class="modal-footer">
                <div class="row">

                    <div class="col-sm-6 " id="ve_compan"></div>
                    <div class="col-sm-6" >
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right updateNewPlan" >Update</button></div>
                    </div>
                </div>
            </div>
        </div><!--
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">REJECT</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6" >
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                        <div class="pull-right m-t-10"><button type="button" class="btn btn-warning pull-right" id="confirmeds" >Reject</button></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="banPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">BAN</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="banMsg" style="text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6" >
                        <button type="button" class="btn btn-warning pull-right closeButton"  style="display:none;">Ok</button>
                        <div class="pull-right m-t-10"><button type="button" class="btn btn-warning pull-right okButton" id="banButton1">Yes</button></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="banPopUpReason" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Reason</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="banReasonMsg"></div>


                </div>
                <div class="row">

                    <lablel class="col-sm-3 control-label" style="color:#0090d9">Reason<span class="MandatoryMarker">*</span></lablel>
                    <input class="form-control col-sm-6" type="text" name="banReason" id="banReason" />
                    <div class="col-sm-3" id="banReasonErr" style="color:red;"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6" >
                        <button type="button" class="btn btn-warning pull-right closeButton"  style="display:none;">Ok</button>
                        <div class="pull-right m-t-10"><button type="button" class="btn btn-warning pull-right okButton" id="banButton">Yes</button></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up" id="myModal1_driverpass" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <input type="text"  id="confirmpass1" name="" class="confirmpass form-control" placeholder="Confirm Password">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="col-sm-6 error-box errors" id="errorpass_driversmsg"></div>
                        <div class="col-sm-6" >
                            <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                            <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="editpass_msg" ><?php echo BUTTON_SUBMIT; ?></button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>






<div class="modal fade stick-up" id="confirmmodelss" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatass" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <button type="button" data-dismiss="modal" class="btn btn-success btn-cons" id="cancel">Ok</button>
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="confirmedss" ><?php echo BUTTON_OK; ?></button></div>
                    </div>
                </div>
            </div>
        </div>
        <a href="vehicletype_addedit.php"></a>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="deletedriver" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title">DELETE</span>
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
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="yesdelete" >Delete</button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
<div class="modal fade stick-up" id="offlineModalDriver" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">Alert</span>
            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox_offline" style="text-align:center">Are you sure you want to make driver offline?</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="yesMakeOffline" >Yes</button>
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
                    <span style="color:#738092;font-weight:700;margin-left: 10px;">Driver Name : <span id="d_name_history" style="color:#1ABB9C;"></span></span>
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

    </div>
</div>

