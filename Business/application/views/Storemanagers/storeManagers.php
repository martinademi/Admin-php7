
<link rel="stylesheet" type="text/css" href="<?php echo ServiceLink; ?>theme/intl-tel-input-master/build/css/intlTelInput.css">

<style>
    .btn{
        font-size: 10px;
    }
    .MandatoryMarker{
        color:red;
    }
    .nav-tabs li a {
        font-weight: bold !important;
        font-size: 11px  !important;
    }
    .error{
        color:red;
    }
    .pac-container {
        z-index: 1051 !important;
    }
    .intl-tel-input {
        position: relative;
        display: block;
        height: 40px;
    }
    .badge {
        font-size: 9px;
        margin-left: 4px;
    }
</style>
<script>
$(document).ready(function () {

    getManagerCount();

    function getManagerCount()
    {
        console.log('val*****')
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Storemanagers/getManagerCount",
            type: "POST",
            dataType: 'json',
            async: true,
            success: function (response)
            {
                console.log('reponse--',response);
                $('.approved').text(response.data.approved);
                $('.login').text(response.data.login);
                $('.logout').text(response.data.logout);
                $('.deleted').text(response.data.deleted);
				
                
            }
        });
    }

    
});

</script>
<script>
$(document).ready(function (){

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
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
            return false;
        }
        return true;
    }
    $(document).ready(function () {

//VALIDATION

 //-----------------form validation--------------------------
 $("#addManagerForm").validate({
            rules: {
                
                frm_mobile: {
                    required: true,
                    number: true,
                    validNumber: true
                }
              
            }
        
        });
         var telInput = $("#frm_mobile");
        $.validator.addMethod("validNumber", function (value, element) {
            if (telInput.intlTelInput("isValidNumber")) {
                return true;
            } else {
                return false;
            }
        }, "Please enter valid number");

    
    // edit form validation
    
    $("#editaddManagerForm").validate({
            rules: {
                
                editfrm_mobile: {
                    required: true,
                    number: true,
                    validNumber1: true
                }
              
            }
        
        });
         var edittelInput = $("#editfrm_mobile");
        $.validator.addMethod("validNumber1", function (value, element) {
            if (edittelInput.intlTelInput("isValidNumber")) {
                return true;
            } else {
                return false;
            }
        }, "Please enter valid number");

       


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

        var btnVal = '';
        $(document).on('click', '#btndevicelogs', function ()
        {

            btnVal = $(this).val();

            $('#device_log_data').empty();
            $.ajax({
                url: "<?php echo base_url('index.php?/Storemanagers') ?>/getDeviceLogs/manager",
                type: "POST",
                data: {mas_id: btnVal},
                dataType: 'json',
                success: function (result)
                {
                    if (result) {
                        var html = '';
                        var deviceType = '';
                        var pushToken = '';
                        var appVersion = '';
                        var deviceMake = '';
                        var deviceModel = '';
                        $('#d_name_history').text(result.user)
                        $.each(result.data, function (index, logs) {
//                            console.log(logs);
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
                            pushToken = '-';
                            if (logs.pushToken != '') {
                                pushToken = logs.pushToken;
                            }
                            appVersion = '-';
                            if (logs.appVersion != '') {
                                appVersion = logs.appVersion;
                            }
                            deviceMake = '-';
                            if (logs.deviceMake != '') {
                                deviceMake = logs.deviceMake;
                            }
                            deviceModel = '-';
                            if (logs.deviceModel != '') {
                                deviceModel = logs.deviceModel;
                            }

                            html = "<tr>";
                            html += "<td>" + deviceType + "</td>";
                            html += "<td>" + appVersion + "</td>";
                            html += "<td>" + deviceMake + "</td>";
                            html += "<td>" + deviceModel + "</td>";
                            html += "<td>" + logs.deviceId + "</td>";
                            html += "<td><span class='pushTokenShortShow'>" + pushToken + "</span></td>";
                            html += "<td>" + moment(logs.lastLogin).format("DD-MM-YYYY HH:mm:ss") + "</td>";

                            html += "</tr>";
                            $('#device_log_data').append(html);
                        });
                    } else {
                        html = "<tr>";
                        html += "<td></td>";
                        html += "<td></td>";
                        html += "<td></td>";
                        html += "<td></td>";
                        html += "<td></td>";
                        html += "<td></td>";
                        html += "<td></td>";
                        html += "</tr>";
                        $('#device_log_data').html(html);
                    }
                }
            });

            $('#deviceLogPopUp').modal('show');
        });


        $("#document_data").click(function () {

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_DOC_VIEW); ?>);
            } else if (val.length > 1)
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVER_DOC_VIEW); ?>);
            } else
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

        });

        $("#editfrm_mobile").on("countrychange", function (e, countryData) {
            $("#Coutry-code").val(countryData.dialCode);
        });

        var editval = '';
        $(document).on('click', "#btnedit", function () {
            $('#editname').val("");
            $('#editemail').val("");
            $('#editfrm_mobile').val("");
            $("#display-data").text("");
            editval = $(this).val();

            $.ajax({
                url: "<?php echo base_url('index.php?/Storemanagers') ?>/getManagers",
                type: "POST",
                dataType: 'json',
                data: {managerid: editval},
                success: function (result) {

                    console.log('result',result);
//                        $('#editstores').val(result.data.storeId);
                    $('#editname').val(result.data.name);
                    $('#editemail').val(result.data.email);
                    $('#editpassword').val(result.data.password);
                    $("#editfrm_mobile").intlTelInput("setNumber", result.data.countryCode + ' ' + result.data.phone);
                    $('#Coutry-code').val(result.data.countryCode);

                    var resposibility=result.data.accepts;
                    
                    if(resposibility=="1"){
                        $("#acceptedit1").attr('checked', 'checked');
                        }else if(resposibility=="2"){
                            $("#acceptedit2").attr('checked', 'checked');
                        }else{
                            $("#acceptedit3").attr('checked', 'checked');
                        }

//                        $('#editfrm_mobile').val(result.data.phone);
//                    $('.editaccepts').val(result.data.accepts);
//                    if ($('.editaccepts').val() == 1) {
//                        $("#editaccepts1").attr('checked', 'checked');
//                    } else if ($('.editaccepts').val() == 2) {
//                        $("#editaccepts2").attr('checked', 'checked');
//                    } else if ($('.editaccepts').val() == 3) {
//                        $("#editaccepts3").attr('checked', 'checked');
//
//                    }

                        if(result.data.receivedOrderEmail=="1"){
                            $('#editreceiveNewOrder').prop('checked',true);

                           

                    
                }


                    $('#editManagerModal').modal('show');
                }
            });

        });

        $("#yesEdit").click(function () {
            var storeId = "<?php echo $BizId; ?>";
            var cityId = "<?php echo $stores['cityId']; ?>";
            var cityName = "<?php echo $stores['cityName']; ?>";
            var storeName = "<?php echo $stores['name'][0]; ?>";
            var mobile = $('#editfrm_mobile').val();
            var countryCode = $("#Coutry-code").val();
          // var accepts = $('input[name=editaccepts]:checked').val();
          var accepts = $('input[name=acceptedit_res]:checked').val();
            var name = $('#editname').val();
            var email = $('#editemail').val();
            var editdispatchusertype=$('input[name=editdispatchusertype]:checked').val();  
            var editdispatchusertypeMsg=$('input[name=editdispatchusertype]:checked').attr('dataid');

            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/; //^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            if (name == "" || name == null)
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
            }
           // else if (accepts == "" || accepts == null)
           // {
           //     $("#text_edit_accepts").html("Please choose accepts");

           //  }
            else if(!$("#editaddManagerForm").valid()){
               
            } else {

                $.ajax({
                    url: "<?php echo base_url('index.php?/Storemanagers') ?>/editManager",
                    type: "POST",
                    data: {managerId: editval, name: name, storeId: storeId, email: email, mobile: mobile, countryCode: countryCode, storeName: storeName, cityId: cityId, cityName: cityName,accepts: accepts,editdispatchusertype:editdispatchusertype,editdispatchusertypeMsg:editdispatchusertypeMsg},// accepts: accepts,
                    success: function (result) {

                        $('#editManager').modal('hide');
                        window.location.reload();

                    }
                });
            }
        });

        $("#add").click(function () {
            $('#name').val("");
            $('#email').val("");
            $('#password').val("");
            $('#frm_mobile').val("");
            $('#stores').val("");
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

            var storeId = "<?php echo $BizId; ?>";
            var cityId = "<?php echo $stores['cityId']; ?>";
            var cityName = "<?php echo $stores['cityName']; ?>";
            var storeName = "<?php echo $stores['name'][0]; ?>";
            var mobile = $('#frm_mobile').val();
            var countryCode = $('#countryCode').val();
            var accepts = $('input[name=accepts]:checked').val();
            var password = $('#password').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var stores = $('#stores').val();
            var receiveEmail;
            var dispatchusertype=$('input[name=dispatchusertype]:checked').val();  
            var dispatchusertypeMsg=$('input[name=dispatchusertype]:checked').attr('dataid');

             if ($('#receiveNewOrder').is(':checked')) {
                receiveEmail=1;		
	     	}else{
                receiveEmail=0;		
             }
             
            

            var userType=2;
            


           

            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/; //^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            

            if (storeId == "" && storeId == null)
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
                $("#text_password").html("Please enter the password");

            } else if (password.length < 4)
            {
                $("#text_password").html("password should be more than 4 characters");

            } else if (mobile == "" || mobile == null)
            {
                $("#text_mobile").html("Please enter the mobile number");
            }
           //  else if (accepts == "" || accepts == null)
           // {
           //     $("#text_accepts").html("Please choose accepts");
           // }
           else if(!$("#addManagerForm").valid()){
               
           } else {

                $('#yesAdd').prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/Storemanagers') ?>/addManager",
                    type: "POST",
                    //data: {name: name, storeId: storeId, email: email, mobile: mobile, password: $('#password').val(),countryCode: countryCode, storeName: storeName, cityId: cityId, cityName: cityName},
                    data: {name: name, storeId: storeId, email: email, mobile: mobile, password: $('#password').val(),countryCode: countryCode, storeName: storeName, cityId: cityId, cityName: cityName,accepts: accepts,userType:userType,receiveEmail:receiveEmail,dispatchusertype:dispatchusertype,dispatchusertypeMsg:dispatchusertypeMsg},
                    success: function (result) {

                        $('#addManager').modal('hide');
                        $('#yesAdd').prop('disabled', false);
                        window.location.reload();

                    }
                });

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
                $("#errorbox").text("Are you sure you want to delete the manager?");

            } else {
                $('#modalBodyText').text('Please select atleast one to delete');
                $("#modelpopup").modal();
               
                // $('#alertForNoneSelected').modal('show');
                // $("#display-data").text("Please select atleast one manager");
            }

        });

        $("#yesdelete").click(function () {
            var deletedBy = "Admin";
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            $.ajax({
                url: "<?php echo base_url('index.php?/Storemanagers') ?>/deleteManagers",
                type: "POST",
                data: {masterid: val, deletedBy: deletedBy},
                success: function (result) {

                    $('#deletedriver').modal('hide');
                    window.location.reload();

                }
            });
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
                        url: "<?php echo base_url() ?>index.php?/Storemanagers/getAllDriversDetails",
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

                tabURL = $('li.active').children("a").attr('data');


                $("#confirmeds").click(function () {
                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/Storemanagers/rejectdrivers",
                        type: "POST",
                        data: {val: val, date: (new Date().getTime()) / 1000},
                        dataType: 'json',
                        success: function (result)
                        {
                            $('#confirmmodels').modal('hide');
                            refreshContent(tabURL);
                        }
                    });
                });
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


    });

</script>

    <script>

// cool
var resetval = '';
$(document).on('click', '#resetPassword', function () {

  
   resetval = $(this).val();
   console.log('reset pwd---- 12',resetval);
   
   $('#oldpass').val("");
   $('#newpass').val("");
   $('#confirmpass').val("");
 var size = $('input[name=stickup_toggler]:checked').val()
 var modalElem = $('#resetModal');
 if (size == "mini") {
     $('#modalStickUpSmall').modal('show')
 } else {
     $('#resetModal').modal('show')
     if (size == "default") {
         modalElem.children('.modal-dialog').removeClass('modal-lg');
     } else if (size == "full") {
         modalElem.children('.modal-dialog').addClass('modal-lg');
     }
 }

});

function validatePassword() {
console.log('validate pwd');
var valreset=resetval;

 var oldpass = $("#oldpassreset").val();
 if (oldpass == '' || oldpass == null) {
     console.log('old');
     $("#errorpass").html("Please enter current password");
 } else {
     $.ajax({
         url: "<?php echo base_url('index.php?/Storemanagers') ?>/validatePassword",
         type: 'POST',
         data: {
             oldpass: oldpass,
             mId:valreset
         },
         dataType: 'JSON',
         success: function (result)
         {
             console.log(result);
             if (result.msg == '1') {
               //  $("#errorpass").html("Wrong current Password");
               $('#pwdErr').hide();
               
             } else if (result.msg == '0') {
                 $('#pwdErr').show();

             }
         }

     });
 }
}


$(document).on('click', '#superpass', function () {
console.log('superpwd');
$("errorpass").text("");


var oldpass = $("#oldpassreset").val();
var newpass = $("#newpassreset").val();
var confirmpass = $("#confirmpassreset").val();
var currentpassword = $("#oldpassreset").val();
var valreset=resetval;


var reg = /^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])\S*$/;  
console.log('p11');
// if (oldpass == "" || oldpass == null)
// {
 
//  $("#errorpass").text('Please enter the current password ');
//  console.log('p12');

// } else

 if (newpass == "" || newpass == null)
{
 
    $('#pwdErr').text('Please enter  password');
} else if(newpass!=confirmpass){
            $('#pwdErr').text('Please enter correct  password');
} else
{
 console.log('p1')

 $.ajax({
     url: "<?php echo base_url('index.php?/Storemanagers') ?>/editpassword",
     type: 'POST',
     data: {
         password: newpass,
         currentpassword: currentpassword,
         mId:valreset

     },
     dataType: 'JSON',
     success: function (response)
     {
         if (response == 1) {

             $(".close").trigger('click');

             var size = $('input[name=stickup_toggler]:checked').val()
             var modalElem = $('#confirmmodels');
             if (size == "mini")
             {
                 $('#modalStickUpSmall').modal('show')
             } else
             {
                 $('#resetSuccessmsg').modal('show')
                 if (size == "default") {
                     modalElem.children('.modal-dialog').removeClass('modal-lg');
                 } else if (size == "full") {
                     modalElem.children('.modal-dialog').addClass('modal-lg');
                 }
             }

             $("#errorboxdatas").text('password changed successfully');
             $(".error-box-class").val('');

         }

     }

 });
}

});

</script>


<script type="text/javascript">
    var driverWalletEnable = <?php echo $appCofig['walletSettings']['walletDriverEnable']; ?>

    $(document).ready(function () {

        $('.error-box-class ').keypress(function () {
            $('.error-box').text('');
        });
        $('.error-box-class ').change(function () {
            $('.error-box').text('');
        });

        $('#storeList').hide();
        $('#operatorList').hide();

        $("#frm_mobile").intlTelInput("setNumber", '');

        $("#frm_mobile").on("countrychange", function (e, countryData) {
            $("#countryCode").val(countryData.dialCode);
        });

       


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
        
         $("#activate").click(function () {
            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            if (val.length > 0) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#activatedriver');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#activatedriver').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxact").text("Are you sure you want to activate the manager?");

            } else {
                $('#modalBodyText').text('Please select atleast one to activate');
                $("#modelpopup").modal();

                // $('#alertForNoneSelected').modal('show');
                // $("#display-data").text("Please select atleast one manager");
            }

        });
        
        $("#yesactivate").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            tabURL = $('li.active').children("a").attr('data');

            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Storemanagers/activateManager",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {
                    $('#activatedriver').modal('hide');
                    window.location.reload();
                }

            });

            $("#ve_compan").val('');
            $("#company_select").val('');

        });

        $(document).on('click', '.getDriverDetails', function ()
        {
            $('.dname').text('');
            $('.demail').text('');
            $('.dphone').text('');

            $.ajax({
                url: "<?php echo base_url('index.php?/Storemanagers') ?>/getDriverDetails",
                type: "POST",
                data: {mas_id: $(this).attr('mas_id')},
                dataType: 'json',
                success: function (result) {

                    var accoutType = (result.driverData.accountType == 2) ? 'Operator' : 'Freelancer';
                    $('.dprofilePic').attr('src', '');
                    $('.dprofilePic').hide();
                    if (result.driverData.firstName != null)
                    {
                        $('.dname').text(result.driverData.firstName + ' ' + result.driverData.lastName);
                        $('.demail').text(result.driverData.email);
                        $('.dphone').text(result.driverData.countryCode + result.driverData.mobile);
                        $('.dbusinessType').text(accoutType);

                        if (result.driverData.image != '')
                        {
                            $('.dprofilePic').attr('src', result.driverData.image);
                            $('.dprofilePic').show();
                        }
                    }

                    $('#getDriverDetails').modal('show');//Code in footer.php

                }
            });
        });

    });

    function refreshContent(url) {

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
<script type="text/javascript">
    $(document).ready(function () {
        $('.Storemanagers').addClass('active');
        var id = "<?php echo $BizId; ?>";
        var status = 1;
        if (status == 1) {
            $('#btnStickUpSizeToggler').show();
            $('#managerLogout').hide();
            $('#hide').show();
            $('#activate').hide();
        }

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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Storemanagers/datatable_storeManagers/' + id + '/1',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');

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
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('.whenclicked li').click(function () {
            console.log($(this).attr('id'));
            if ($(this).attr('id') == 1) {
                $('#add').show();
                $('#managerLogout').hide();
                $('#activate').hide();
                $('#chekdel').show();
                $('#permanentDelete').hide();

            } else if ($(this).attr('id') == 2) {

                $('#add').hide();
                $('#managerLogout').show();
                $('#activate').hide();
                $('#chekdel').hide();
                $('#permanentDelete').hide();
            } else if ($(this).attr('id') == 3) {

                $('#add').hide();
                $('#managerLogout').hide();
                $('#activate').hide();
                $('#chekdel').hide();
                $('#permanentDelete').hide();
            } else if ($(this).attr('id') == 4) {

                $('#add').hide();
                $('#managerLogout').hide();
                $('#activate').hide();
                $('#chekdel').hide();
                $('#permanentDelete').show();
            }
        });
		 $("#managerLogout").click(function () {
            var deletedBy = "Admin";
            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

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
                                },
                                "columnDefs": [
		{  targets: "_all",
			orderable: false 
		}
],
                            };

                            table.dataTable(settings);
                        }
                    });
                });
            } else if (val.length > 1) {
                $('#modalBodyText').text('Please select only one manager once');
                $("#modelpopup").modal();

                // $('#alertForNoneSelected').modal('show');
                // $("#display-data").text("Please select only one manager once");
            } else if (val.length == 0) {
                $('#modalBodyText').text('Please select atleast one manager');
                $("#modelpopup").modal();

                // $('#alertForNoneSelected').modal('show');
                // $("#display-data").text("Please select atleast one manager");
            }

        });

        $('.changeMode').click(function () {

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
                "sAjaxSource": $(this).attr('data'),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    $('#big_table').fadeIn('slow');

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
        });
    });

    
 


   
</script>
<script>

  $(document).ready(function(){
    $("#permanentDelete").click(function () {
        
        console.log('perman')
      if ($(".checkbox").is(":checked") == false) {
          $('#popupmodeltext').text('Please select atleast one to delete');
          $("#popupmodel").modal();
          return;
      }
          $('#popupmodeltext').text('');
          $("#popupmodelfooter").text('');
          $('#confirmeds').attr('data_id', '');
          $('#confirmeds').attr('status', '');
          $('#confirmeds').attr('updateType', '');
          var addOnId = $(".checkbox:checked").val();
  
          var modalText = 'Do you want to continue to delete';
  
          $('#popupmodeltext').text(modalText);
          var deleteButton = '<button type="button" class="btn btn-primary pull-right" data_id="'+ addOnId +' " id="confirmPermanentDelete" style="width: 87px !important;">DELETE</button>"';
          $("#popupmodelfooter").append(deleteButton);
          $("#popupmodel").modal();
      });

         //delete the addon permanent 
         $("body").on('click','#confirmPermanentDelete',function(){

            var status="<?php echo $this->session->userdata('badmin')['BizId']; ?>";
            var val=[];

            $(':checkbox:checked').each(function(i){
                val[i] = $(this).val();
                
                });
            permanentDelete(val, status);               
            

            });

  function permanentDelete(managerIds, status){
            $.ajax({
                    
                    url: "<?php echo base_url('index.php?/Storemanagers/permanentDelete');?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        val : managerIds,
                        status : status
                    },
            })
            .done(function(json,textStatus, xhr) {
                
                if (xhr.status == 200) {
                  
                     $('#big_table').DataTable().ajax.reload();
                     $("#popupmodel").modal('hide');
                  
                }else{
                    alert('Unable to update status. Please try agin later');
                }
            });
      }


    });

    
    function validateEmail(text) {

            var emailstr = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            var email = $('#email').val();
            if (!emailstr.test(email)) {
                $('#email').val('');
                $("#text_email").text("<?php echo $this->lang->line('error_ValidEmail'); ?>");
            } else {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php?/Storemanagers/validateEmail",
                    type: 'POST',
                    data: {email: email},
                    datatype: 'json', 
                    success: function (response) {
                    response = JSON.parse(response)
                        if (response.msg == 1) {
                            $("#text_email").text("Email is already allocated !");
                            $("#text_edit_email").text("Email is already allocated !");

                            $('#email').val('');
                            return false;
                        } else if (response.msg == 0) {
                            $("#text_email").text("");

                        }
                    }
                });
            }
    }

    function editvalidateEmail(text) {

        var emailstr = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
        var editValEmail = $('#editemail').val();
        if (!emailstr.test(email)) {

            $('#email').val('');
            $("#text_email").text("<?php echo $this->lang->line('error_ValidEmail'); ?>");
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Storemanagers/validateEmail",
                type: 'POST',
                data: {email: email,id:editValEmail},
                datatype: 'json', 
                success: function (response) {
                    console.log('respone',response)
                response = JSON.parse(response)
                    if (response.msg == 1) {

                        $("#text_edit_email").text("Email is already allocated !");
                        $('#editemail').val('');
                        return false;

                    } else if (response.msg == 0) {
                        $("#text_edit_email").text("");

                    }
                }
            });
        }
    }

  
</script>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <!-- <div class="brand inline" style="  width: auto; margin-left: 8px;padding-top: 50px;">
            <strong style="color:#0090d9;font-size: 16px;">Managers</strong>
        </div> -->

        <div class="brand inline" style="  width: auto;">
           <?php echo $this->lang->line('Managers'); ?>
        </div>
        <div class="panel panel-transparent ">
        <ul class="nav nav-tabs bg-white whenclicked">
            <li id= "1" class="tabs_active active" style="cursor:pointer">
                <a  data-toggle="tab" href="#tab1" id="tb1" class="changeMode New_" data="<?php echo base_url() ?>index.php?/Storemanagers/datatable_storeManagers/<?php echo $BizId; ?>/1" data-id="1"><span> <?php echo $this->lang->line('APPROVED'); ?></span><span class="badge approved" style="background-color: #337ab7;"></span></a>
            </li>
            <li id= "2" class="tabs_active" style="cursor:pointer">
                <a data-toggle="tab" href="#tab2" id="tb2" class="changeMode accepted_" data="<?php echo base_url() ?>index.php?/Storemanagers/datatable_storeManagers/<?php echo $BizId; ?>/2"  data-id="2"><span> <?php echo $this->lang->line('LOGGED_IN'); ?></span> <span class="badge login" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id= "3" class="tabs_active" style="cursor:pointer">
                <a data-toggle="tab" href="#tab3" id="tb3" class="changeMode accepted_" data="<?php echo base_url() ?>index.php?/Storemanagers/datatable_storeManagers/<?php echo $BizId; ?>/3"   data-id="3"><span> <?php echo $this->lang->line('LOGGED_OUT'); ?></span> <span class="badge bg-green logout"></span></a>
            </li>
            <li id= "4" class="tabs_active" style="cursor:pointer">
                <a  data-toggle="tab" href="#tab4" id="tb4" class="changeMode accepted_" data="<?php echo base_url() ?>index.php?/Storemanagers/datatable_storeManagers/<?php echo $BizId; ?>/4"  data-id="4"><span> <?php echo $this->lang->line('DELETED'); ?></span> <span class="badge bg-green deleted"></span></a>
            </li>

            <div class="cls111"><button class="btn btn-primary pull-right m-t-10 " id="managerLogout" style="margin:8px !important;"  > <?php echo $this->lang->line('Logout'); ?></button></div>
            <div class="cls111"> <button class="btn btn-danger pull-right m-t-10" id="chekdel" style="margin:8px !important;"> <?php echo $this->lang->line('Delete'); ?></button></a></div>
            <div class="cls100"><button class="btn btn-info pull-right m-t-10 " id="activate" style="margin:8px !important;"> <?php echo $this->lang->line('Activate'); ?></button></div>     
            <!--<div class="cls111"><button class="btn btn-info pull-right m-t-10 " id="editManager" ><?php echo Edit; ?></button></div>-->
            <div class="cls110"><button class="btn btn-success pull-right m-t-10" id="add" style="margin:8px !important;"> <?php echo $this->lang->line('Add'); ?></button></a></div>
            <div class="cls110"><button class="btn btn-danger pull-right m-t-10" id="permanentDelete" style="margin:8px !important;display:none"> <?php echo 'Permanent Delete'; ?></button></a></div>
           
        </ul>
        </div>

        <!-- Tab panes -->
        <div class="tab-content">

            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent " style="margin-left: -20px;margin-right: -15px;">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="error-box" id="display-data" style="text-align:center; color: red;"></div>
                                    <div class="col-xs-12 searchbtn row clearfix pull-right" >

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" style="text-transform: capitalize;" placeholder="<?php echo SEARCH; ?>"> </div>
                                    </div>
                                    <div class="dltbtn">
                                    </div>
                                </div>
                                &nbsp;

                                <div class="container">
                                    <div class="row clearfix">
                                        <div class="col-md-12 column">
                                            <?php echo $this->table->generate(); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- END PANEL -->
        </div>
    </div>


</div>

<input type="hidden" name="current_dt" id="time_hidden" value=""/>


<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"> <?php echo $this->lang->line('ACCEPT'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form  data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="form-group">
                        <label for="fname" class="col-sm-12 control-label"> <?php echo $this->lang->line('doc_validate'); ?></label>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <div class="">
                            <label> <?php echo $this->lang->line('Activate_As'); ?></label>
                        </div>
                        <div class="">
                            <input class="" type="radio" name="type" id="typeOperator" value="Operator"/>
                            <label> <?php echo $this->lang->line('Operator'); ?></label>
                        </div>
                        <div class="">
                            <input type="radio" name="type" id="typeStore" value="store"/>
                            <label> <?php echo $this->lang->line('Store'); ?></label>
                        </div>

                    </div>
                    <div class="">
                        <select class="form-control" id="operatorList" name="operatorList">
                            <option data-name="" data-id="" value="" name=""> <?php echo $this->lang->line('Select_Operator'); ?></option>
                        </select>
                    </div>
                    <div class="">
                        <select class="form-control" id="storeList" name="storeList">
                            <option data-name="" data-id="" value="" name=""> <?php echo $this->lang->line('Select_Store'); ?></option>
                        </select>
                    </div>
                    <hr/>

                    <div class="form-group planDiv">
                        <span class="deletedPlanTest" style="display:none;font-weight:600;"></span>
                        <br>
                        <br>
                        <label for="fname" class="col-sm-2 control-label"> <?php echo $this->lang->line('Plans'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" id="plans" name="plans">
                                <option value="0"></option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 errors" id="plansErr"></div>
                    </div>
                    <div class="form-group planDiv zonesDiv hide">
                        <span class="deletedPlanTest" style="display:none;font-weight:600;"></span>
                        <br>
                        <br>
                        <label for="fname" class="col-sm-2 control-label"> <?php echo $this->lang->line('Zones'); ?><span style="" class="MandatoryMarker"></span></label>
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
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"> <?php echo $this->lang->line('Cancel'); ?></button>
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="confirmed" > <?php echo $this->lang->line('ACCEPT'); ?>T</button></div>
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
                <span class="modal-title"> <?php echo $this->lang->line('UPDATE_PLAN'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                <form  data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

                    <div class="form-group">

                        <label for="fname" class="col-sm-3 control-label"> <?php echo $this->lang->line('Current_Plan'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <select class="form-control" id="currentPlan" name="currentPlan">
                                <option value="0"></option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 errors"></div>
                    </div>
                    <div class="form-group">

                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('New_Plan '); ?><span style="" class="MandatoryMarker"> *</span></label>
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
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"> <?php echo $this->lang->line('Cancel'); ?></button>
                        <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right updateNewPlan" > <?php echo $this->lang->line('Update'); ?></button></div>
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
                <span class="modal-title"> <?php echo $this->lang->line('REJECT'); ?></span>
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
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"> <?php echo $this->lang->line('Cancel'); ?></button>
                        <div class="pull-right m-t-10"><button type="button" class="btn btn-warning pull-right" id="confirmeds" > <?php echo $this->lang->line('Reject'); ?></button></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="resetSuccessmsg" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">success</h4>
        </div>
        <div class="modal-body">
          <p>Password changes successfully.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<div class="modal fade stick-up" id="banPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"> <?php echo $this->lang->line('BAN'); ?></span>
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
                        <button type="button" class="btn btn-warning pull-right closeButton"  style="display:none;"> <?php echo $this->lang->line('Ok'); ?></button>
                        <div class="pull-right m-t-10"><button type="button" class="btn btn-warning pull-right okButton" id="banButton"> <?php echo $this->lang->line('Yes'); ?></button></div>
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
                        <span class="modal-title"> <?php echo $this->lang->line('RESET_PASSWORD'); ?></span>
                    </div>


                    <div class="modal-body">
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label"> <?php echo FIELD_NEWPASSWORD; ?> <span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="newpass1" name=""  class="newpass form-control" placeholder="New Password">
                            </div>
                        </div>

                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-3 control-label"><?php echo FIELD_CONFIRMPASWORD; ?> <span style="" class="MandatoryMarker"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="confirmpass1" name="" class="confirmpass form-control" placeholder="Confirm Password">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="col-sm-6 error-box errors" id="errorpass_driversmsg"></div>
                        <div class="col-sm-6" >
                            <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"> <?php echo $this->lang->line('Cancel'); ?></button>
                            <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="editpass_msg" ><?php echo BUTTON_SUBMIT; ?> <?php echo $this->lang->line('Managers'); ?></button></div>
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

                <span class="modal-title"> <?php echo $this->lang->line('Delete'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorbox" style="font-size: 14px;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"> <?php echo $this->lang->line('Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="yesdelete" > <?php echo $this->lang->line('Delete'); ?></button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="activatedriver" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title"> <?php echo $this->lang->line('Activate'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorboxact" style="font-size: 14px;text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"> <?php echo $this->lang->line('Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="yesactivate" > <?php echo $this->lang->line('Activate'); ?></button></div>
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
                <span class="modal-title"> <?php echo $this->lang->line('Add'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <hr/>
                <div class="modal-body">
                <form id="addManagerForm" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <br>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-3 control-label" style="padding:10px" > <?php echo $this->lang->line('Name'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="error-box-class form-control" id="name" minlength="3" placeholder="Please enter name" required="" style="margin:3px;">  
                                <div class="error-box col-sm-8" id="text_name" style="color:red"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-3 control-label" style="padding:10px"> <?php echo $this->lang->line('Email'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-8">
                                <input type="email" class="error-box-class form-control" id="email" onblur="validateEmail(this)" pattern="[^ @]*@[^ @]*" placeholder="Enter your email" required="" style="margin:3px;">  
                                <div class="error-box col-sm-8" id="text_email" style="color:red"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-3 control-label" style="padding:10px"> <?php echo $this->lang->line('Password'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-8">
                                <input type="password" required="" pattern="[a-zA-Z0-9]{6}"class="form-control" name="password"  id="password"  style="margin:3px;"> 

                                <div class="col-sm-8" id="text_password" style="color:red"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-3 control-label" style="padding:10px"> <?php echo $this->lang->line('Mobile'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-9" style="padding-left: 13px;">
                                <input type="text" required="" class="error-box-class form-control" name="frm_mobile" style="width:88%;margin:3px;" id="frm_mobile"> 
                                <input type="hidden" id="countryCode" name="coutry-code" value=""> 
                                <div class="error-box col-sm-8" id="text_mobile" style="color:red"></div>
                            </div>
                        </div>
                    </div>

                     <!-- dispatchusertype -->
                     <div class="row" id="dispatchUser" style="display:none">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-3 control-label">Dispatch User Type<span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-8">
                            <div class="radio">
                                <label><input type="radio"  name="dispatchusertype" checked id="dispatchusertype1" value="1" dataid="Manager" style="margin-top: 0px;">Manager</label>
                                <label><input type="radio" name="dispatchusertype" id="dispatchusertype2" value="2"  dataid="Packer" style="margin-top: 0px;">Packer</label>
                                </div>
                              
                            </div>
                        </div>
                    </div>

                    
                   <div class="row" style="display:none">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-3 control-label"> <?php echo $this->lang->line('Accepts'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-8">

                                <!-- <label class=" col-sm-2 control-label">Pickup</label>
                                <input type="radio" class= "error-box-class col-sm-2 accepts" name="accepts"  id="accepts1"  value="1"> 


                                <label class="col-sm-2 control-label">Delivery</label>
                                <input type="radio" class="error-box-class col-sm-2 accepts" name="accepts"  id="accepts2"  value="2"> 

                                <label class="col-sm-2 control-label">Both</label>
                                <input type="radio" class="error-box-class col-sm-2 accepts" name="accepts"  id="accepts3"  value="3">  -->

                            <label class="radio-inline accepts"><input type="radio" name="accepts" id="accepts1"  value="1" checked> <?php echo $this->lang->line('Pickup'); ?></label>
                            <label class="radio-inline accepts"><input type="radio" name="accepts" id="accepts2"  value="2"> <?php echo $this->lang->line('Delivery'); ?></label>
                            <label class="radio-inline accepts"><input type="radio" name="accepts" id="accepts3"  value="3"> <?php echo $this->lang->line('Both'); ?></label>

                                <div class="error-box col-sm-8" id="text_accepts" style="color:red"></div>
                            </div>
                        </div>
                    </div>

                     <div class="row" style="display:none">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-3 control-label" style="padding:10px"> <?php echo $this->lang->line('Receive_new_order_emails'); ?> <span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-9" style="padding-left: 13px;">
                            <input type="checkbox" name="receiveNewOrder" id="receiveNewOrder"  style="margin-top: 15px;">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </form>
            <div class="modal-footer">
                <div class="col-sm-4" ></div>
                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"> <?php echo $this->lang->line('Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesAdd" > <?php echo $this->lang->line('Add'); ?></button></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.modal-dialog -->

<div id="editManagerModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"> <?php echo $this->lang->line('EDIT'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">
                <form id="editaddManagerForm" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-3 control-label"> <?php echo $this->lang->line('Name'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="error-box-class form-control" id="editname" minlength="3" value="" placeholder="Enter your name" required="">  
                                <div class="error-box col-sm-8" id="text_edit_name" style="color:red"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12" style="margin-top:7px">
                            <label class="col-sm-3 control-label"> <?php echo $this->lang->line('Email'); ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-8">
                                <input type="email" class="error-box-class form-control" id="editemail" onblur="editvalidateEmail(this)" value="" placeholder="Enter your email" required="">  
                                <div class="error-box col-sm-8" id="text_edit_email" style="color:red"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12" style="margin-top:7px">
                            <label class="col-sm-3 control-label"> <?php echo $this->lang->line('Mobile'); ?><span class="MandatoryMarker">*</span></label>
                            <input type="hidden" id="Coutry-code" name="coutry-code" value="">
                            <div class="col-sm-8">
                                <input type="text" required="" value="" class="error-box-class form-control" name="editfrm_mobile"  id="editfrm_mobile" onkeypress="return isNumberKey(event)" style="width:88%;" > 

                                <div class="error-box col-sm-8" id="text_edit_mobile" style="color:red"></div>
                            </div>
                        </div>
                    </div>

                     <div class="row" style="display:none">
                     <div class="form-group col-sm-12" style="margin-top:7px">
                        <label class="col-sm-3 control-label"> <?php echo $this->lang->line('Accepts'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">

                            <!-- <label class=" col-sm-3 control-label">Pickup</label>
                            <input type="radio" class= "error-box-class col-sm-1 acceptedit" name="acceptedit_res"  id="acceptedit1"  value="1"> 


                            <label class="col-sm-3 control-label">Delivery</label>
                            <input type="radio" class="error-box-class col-sm-1 acceptedit" name="acceptedit_res"  id="acceptedit2"  value="2"> 

                            <label class="col-sm-2 control-label">Both</label>
                            <input type="radio" class="error-box-class col-sm-2 acceptedit" name="acceptedit_res"  id="acceptedit3"  value="3">  -->

                            <label class="radio-inline acceptedit"><input type="radio" name="acceptedit_res" id="acceptedit1"  value="1" checked> <?php echo $this->lang->line('Pickup'); ?></label>
                            <label class="radio-inline acceptedit"><input type="radio" name="acceptedit_res" id="acceptedit2"  value="2"> <?php echo $this->lang->line('Delivery'); ?></label>
                            <label class="radio-inline acceptedit"><input type="radio" name="acceptedit_res" id="acceptedit3"  value="3"> <?php echo $this->lang->line('Both'); ?></label>

                            <div class="col-sm-3 error-box" id="text_edit_accepts" style="color:red"></div>
                        </div>
                    </div>
                    </div>

                    <div class="row" style="display:none">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-3 control-label" style="padding:10px"> <?php echo $this->lang->line('Receive_new_order_emails'); ?> <span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-9" style="padding-left: 13px;">
                            <input type="checkbox" name="receiveNewOrder" id="editreceiveNewOrder"  style="margin-top: 15px;">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </form>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel7"> <?php echo $this->lang->line('Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesEdit" > <?php echo $this->lang->line('Save'); ?></button></div>
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
                        <button type="button" class="btn btn-default pull-right" id="accepted_msg" > <?php echo $this->lang->line('Close'); ?></button>
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
                    <span class="modal-title"> <?php echo $this->lang->line('DOCUMENTS'); ?></span>
                </div>


                <div class="modal-body">
           <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->

                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th style="width:20%;text-align: center;"> <?php echo $this->lang->line('TYPE'); ?></th>
                                <th style="width:10%;text-align: center;"> <?php echo $this->lang->line('PREVIEW'); ?></th>

                            </tr>
                        </thead>
                        <tbody id="doc_body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal"> <?php echo $this->lang->line('Close'); ?></button>

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
                <span class="modal-title"> <?php echo $this->lang->line('Logout'); ?></span>
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
                <span class="modal-title"><?php echo $this->lang->line('DEVICE_INFO '); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">

                <div class="form-group row">

                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for=""> <?php echo $this->lang->line('Make'); ?></label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="make"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for=""> <?php echo $this->lang->line('Model'); ?></label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="model"></span>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for=""> <?php echo $this->lang->line('OS'); ?></label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="os"></span>
                    </div>

                </div>
                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for=""> <?php echo $this->lang->line('Last_Login_Date_Time'); ?></label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="lastLoginDate"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for=""> <?php echo $this->lang->line('Push_Token'); ?></label>
                    <div class="col-md-8 col-sm-8 pushToken" style="word-break: break-all;">

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <?php echo $this->lang->line('Close'); ?></button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade stick-up" id="deviceLogPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title"><?php echo $this->lang->line('DEVICE_INFO '); ?></span>
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
                        <th > <?php echo $this->lang->line('DEVICE_TYPE'); ?></th>
                        <th style=""><?php echo $this->lang->line('APP_VERSION '); ?></th>
                        <th style=""> <?php echo $this->lang->line('DEVICE_MAKE'); ?></th>
                        <th style=""> <?php echo $this->lang->line('DEVICE_MODEL'); ?></th>
                        <th style=""> <?php echo $this->lang->line('DEVICE_ID'); ?></th>
                        <th style=""> <?php echo $this->lang->line('PUSH_TOKEN'); ?></th>
                        <th style=""> <?php echo $this->lang->line('LAST_LOGGED_IN_DATE'); ?></th>
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
<div class="modal fade stick-up" id="logoutManager" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <span class="modal-title"> <?php echo $this->lang->line('LOGOUT'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorboxLogoutManager" style="text-align:center"> <?php echo $this->lang->line('Logout'); ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel15"> <?php echo $this->lang->line('Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-warning pull-right" id="yesLogout" > <?php echo $this->lang->line('Logout'); ?></button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="walletSettingsPopUp" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;"> <?php echo $this->lang->line('CREDIT LINE'); ?></strong>
            </div>
            <div class="modal-body">
                <form data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="form-group">
                        <label for="" class="control-label col-md-3"> <?php echo $this->lang->line('Soft_Limit'); ?></label>
                        <div class="col-sm-6">
                            <span  class="abs_text"><b><?php echo $appCofig['currencySymbol']; ?></b></span>
                            <input type="text" class="form-control number" id="softLimitForDriver" name="softLimitForDriver" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $softLimitForDriver; ?>">
                        </div>
                        <div class="col-sm-3 errors softLimitForDriverErr"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-3"> <?php echo $this->lang->line('Hard_Limit'); ?></label>
                        <div class="col-sm-6">
                            <span  class="abs_text"><b><?php echo $appCofig['currencySymbol']; ?></b></span>
                            <input type="text" class="form-control number" id="hardLimitForDriver" name="hardLimitForDriver" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $hardLimitForDriver; ?>">
                        </div>
                        <div class="col-sm-3 errors hardLimitForDriverErr"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <?php echo $this->lang->line('Close'); ?></button>
                <button type="button" class="btn btn-success pull-right" id="creditSubmit" > <?php echo $this->lang->line('Update'); ?></button>
            </div>
        </div>
        


    </div>
</div>

<div class="modal fade " id="modelpopup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"> <?php echo $this->lang->line('Confirmation'); ?></h4>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="" id="modalBodyText" style="font-size:11px"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" id="modalFooter">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> <?php echo $this->lang->line('Close'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- reset password -->
<div class="modal fade stick-up" id="resetModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-header">

                        <div class=" clearfix text-left">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                            </button>

                        </div>
                        <h3> <?php echo 'Change Passwords'; ?></h3>
                    </div>

                    <br>

                    <div class="modal-body" style="padding:0px">

                        <!-- <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label">Current Password<span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  id="oldpassreset" name="oldpass" onblur="validatePassword()"  class="error-box-class form-control" placeholder="eg:g3Ehadd">
                                    
                                </div>
                            </div> -->

                            <br>
                            <br>
                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-4 control-label"> <?php echo 'New Password'; ?><span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  id="newpassreset" name="latitude"  class="error-box-class form-control" placeholder="eg:g3Ehadd">
                                </div>
                            </div>

                            <br>
                            <br>

                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-4 control-label"><?php echo 'Confirm Password'; ?><span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  id="confirmpassreset" name="longitude" class="error-box-class form-control" placeholder="H3dgsk">
                                </div>
                            </div>

                            
                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-6 control-label"><span style="color:red;" id="pwdErr"></span></label>
                                
                                <div class="col-sm-6">
                                
                                </div>
                            </div>
                            
                          
                           

                            <div class="row">
                                <div class="col-sm-4" ></div>
                                <div class="col-sm-8 error-box" ></div>
                                <div class="col-sm-4" ></div>
                                <div class="col-sm-4" ></div>
                                <div class="col-sm-12" >
                                    <button type="button" class="btn btn-primary pull-right" id="superpass" ><?php echo 'Submit'; ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

 </div>

 <div class="modal fade " id="popupmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><?php echo $this->lang->line('Confirmation'); ?></h4>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="" id="popupmodeltext" style="font-size:15px"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" id="popupmodelfooter">
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script src="//admin.uberforall.com/theme/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script  src="<?php echo ServiceLink; ?>theme/intl-tel-input-master/build/js/intlTelInput.js"></script>

<script>
                        var countryData = $.fn.intlTelInput.getCountryData();
                        $.each(countryData, function (i, country) {

                            country.name = country.name.replace(/.+\((.+)\)/, "$1");
                        });
                        $("#frm_mobile,#editfrm_mobile").intlTelInput({
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
                            utilsScript: "<?php  echo ServiceLink ; ?>theme/intl-tel-input-master/build/js/utils.js",

                        });

//                         $("#editfrm_mobile").intlTelInput({
// //       allowDropdown: false,
//                             autoHideDialCode: false,
//                             autoPlaceholder: "off",
//                             dropdownContainer: "body",
// //       excludeCountries: ["us"],
//                             formatOnDisplay: false,
//                             geoIpLookup: function (callback) {
//                                 $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
//                                     var countryCode = (resp && resp.country) ? resp.country : "";
//                                     callback(countryCode);
//                                 });
//                             },
//                             initialCountry: "auto",
//                             nationalMode: false,
// //       onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
//                             placeholderNumberType: "MOBILE",
// //       preferredCountries: ['srilanka'],
//                             separateDialCode: true,
//                             utilsScript: "https://superadmin.instacart-clone.com/theme/intl-tel-input-master/build/js/utils.js",

//                         });





</script>

