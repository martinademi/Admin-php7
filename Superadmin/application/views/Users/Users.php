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

    .cls111,.cls110{
        margin-top: 8px !important;
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

           // cool
           var resetval = '';
          $(document).on('click', '#resetPassword', function () {

             
              resetval = $(this).val();
              
              
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
        
        var valreset=resetval;
       
            var oldpass = $("#oldpass").val();
            if (oldpass == '' || oldpass == null) {
                $("#errorpass").html("Please enter current password");
            } else {
                $.ajax({
                    url: "<?php echo base_url('index.php?/Users') ?>/validatePassword",
                    type: 'POST',
                    data: {
                        oldpass: oldpass,
                        mId:valreset
                    },
                    dataType: 'JSON',
                    success: function (result)
                    {
                        
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
         
        $("errorpass").text("");
        
       
        var oldpass = $("#oldpass").val();
        var newpass = $("#newpassreset").val();
        var confirmpass = $("#confirmpassreset").val();
        var currentpassword = $("#oldpass").val();
        var valreset=resetval;
       

        var reg = /^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])\S*$/;  
        
        // if (oldpass == "" || oldpass == null)
        // {
        //     //                alert("please enter the new password");
        //     $("#errorpass").text('Please enter the current password ');
        //     console.log('p12');

        // }
         if (newpass == "" || newpass == null)
        {
            $('#pwdErr').text('Please enter  password');
        } else if(newpass!=confirmpass){
            $('#pwdErr').text('Please enter correct  password');
        }
        else {
           

            $.ajax({
                url: "<?php echo base_url('index.php?/Users') ?>/editpassword",
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
                            $('#confirmmodels').modal('show')
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
		var aerialExists = "<?php echo $role?>";
		
		if(aerialExists == "ArialPartner"){
			var val = "<?php echo $cityId;?>";
           
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/FranchiseManager/getFranchise",
                type: 'POST',
                data: {val: val},
                datatype: 'json', // fix: need to append your data to the call
                success: function (response) {
                    $('#franchise').empty();
                    var r = JSON.parse(response);
                    var html1 = '';
                    html1 = '<option franchiseName="" value="">Select Franchise</option>'
                    $.each(r, function (index, row) {
           
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
                    html = '<option storeName="" value="">Select Stores</option>'
                    $.each(r, function (index, row) {
                      
                        html += '<option storeName="' + row.name + '" value="' + row._id.$oid + '">' + row.name + '</option>';
                    });
                    $('#stores').html(html);
                }
            });
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

 
        $('#editcity').on('change', function () {

            var val = $('#editcity option:selected').val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Users/getStores",
                type: 'POST',
                data: {val: val},
                datatype: 'json', // fix: need to append your data to the call
                success: function (response) {
                    $('#editstores').empty();
                    var r = JSON.parse(response);
                    var html = '';
                    html = '<option value="">Select Stores</option>'
                    $.each(r, function (index, row) {
                       
                        html += '<option storeName="' + row.name + '" storeType="'+row.storeType+'" storeTypeMsg="'+row.storeTypeMsg+'" value="' + row._id.$oid + '">' + row.name + '</option>';
                    });
                    $('#editstores').append(html);
                }
            });


        });

        $(document).on('click', '#btndeviceLogs', function () {

            var val = $(this).val();

            $('#device_log_data').empty();
            $.ajax({
                url: "<?php echo base_url('index.php?/Users') ?>/getDeviceLogs/manager",
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
        $(document).on('click', '.btnEditUsers', function () {

            $('.editmanagerImage').attr('src', '');
            $('#editname').val("");
            $('#editemail').val("");
//            $('#password').val("");
            $('#editfrm_mobile').val("");
            $('#editstores').val("");
            $('#editfranchise').empty();
            $('#editstores').empty();

            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            editval = $(this).val();

            $.ajax({
                url: "<?php echo base_url('index.php?/Users') ?>/getUsers",
                type: "POST",
                dataType: 'json',
                data: {managerid: editval},
                success: function (result) {
                    $("#editfrm_mobile").intlTelInput("setNumber", result.data.countryCode);
                    $('#editcity').val(result.data.cityId);

                    $('#editname').val(result.data.name);
                    $('#editemail').val(result.data.email);
                    $('#editpassword').val(result.data.password);
                    $('#editfrm_mobile').val(result.data.phone);
                    $('#editImageUpload').val(result.data.profilePic);
                    $('.editmanagerImage').attr('src', result.data.profilePic);
                    $('#viewimage_hidden').val(result.data.profilePic);
                    $("input[name=editusertype][value="+ result.data.userType+"]").prop("checked",true);
                    $("input[name=editdispatchusertype][value="+ result.data.dispatcherUserType+"]").prop("checked",true);
                    $(".edituserType").attr("disabled",true)
                    if(result.data.userType == 2){
                        var storeoption='';
                        var franchiseoption='';
                        storeoption+='<option>Select Store</option>';
                        storeoption+='<option selected>'+result.data.storeName+'</option>';
                        $("#editstores").append(storeoption);
                        franchiseoption+='<option>Select Franchise</option>';
                          
                        if(result.data.franchiseName!=''){
                            franchiseoption+='<option selected>'+result.data.franchiseName+'</option>';
                        }
                        $(".editfranchiseDivClass").css("display","none")
                        $("#editfranchise").append(franchiseoption);
                        $("#editstores").prop('disabled',true);
                        $("#editfranchise").prop('disabled',true)
                        $("#editstoreDiv").css("display","block");
                        $("#editfranchiseDiv").css("display","block");

                    }
                    else if(result.data.userType == 1){
                        var franchiseoption='';
                        franchiseoption+='<option>Select Franchise</option>';
                        if(result.data.franchiseName!=''){
                            franchiseoption+='<option selected>'+result.data.franchiseName+'</option>';
                        }
                        $(".editfranchiseDivClass").css("display","inline")
                        $("#editfranchise").append(franchiseoption);
                        $("#editfranchise").prop('disabled',true)
                        $("#editstoreDiv").css("display","none");
                        $("#editfranchiseDiv").css("display","block");
                    }
                    else{
                        $("#editstoreDiv").css("display","none");
                        $("#editfranchiseDiv").css("display","none");
                    }
                    $('#editManagerModal').modal('show');
                }
            });


        });

     

          



        // cool
        $('#editemail,#editfrm_mobile').focusout(function () {

            var email = $('#editemail').val();
            var mobile = $('#editfrm_mobile').val();
            $.ajax({
                url: "<?php echo base_url('index.php?/Users') ?>/checkUsersExists",
                type: "POST",
                data: {email: email, mobile: mobile},
                success: function (result) {
                    
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
            var accepts = $('input[name=editaccepts]:checked').val();
            var password = $('#editpassword').val();
            var name = $('#editname').val();
            var email = $('#editemail').val();
            var stores = $('#editstores').val();
            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/; //^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            var storeType = $("#stores option:selected").attr('storeType');
            var storeTypeMsg = $("#stores option:selected").attr('storeTypeMsg');
            

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
            } else {
              
                $.ajax({
                    url: "<?php echo base_url('index.php?/Users') ?>/editUsers",
                    type: "POST",
                    data: {managerId: editval, name: name, storeId: storeId, email: email, mobile: mobile, accepts: accepts, countryCode: countryCode, storeName: storeName, cityId: cityId, cityName: cityName, profilePic: profilePic,
                           storeType:storeType,storeTypeMsg:storeTypeMsg},
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Users/datatable_Users/my/1',
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
           }
        });


        $("#add").click(function () {
            $('.managerImage').attr('src', '');
            $('#city').val("");
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
            var type = $("input:radio[name=usertype]:checked").val();
            switch(type){
                case "0":
                        flag = 0;
                        var userType =0;
                        var userTypeMsg ="Aerial Partner";
                        var dispatchusertype="0"; 
                        var dispatchusertypeMsg="Aerial";
                        break;

                case "1":
                     var franchiseId = $("#franchise option:selected").val();
                     var franchiseName = $("#franchise option:selected").attr('franchisename');
                     var flag =1;
                     var userType =1;
                     var userTypeMsg ="Franchise Manager";
                     var dispatchusertype="3"; 
                     var dispatchusertypeMsg="Franchiae";
                     break;
                case "2":
                     var franchiseId = $("#franchise option:selected").val();
                     var franchiseName = $("#franchise option:selected").attr('franchisename');
                     var storeId = $("#stores option:selected").val();
                     var storeName = $("#stores option:selected").attr('storename');
                     var flag =2;
                     var userType =2;
                     var userTypeMsg ="Store Manager";
                     var dispatchusertype=$('input[name=dispatchusertype]:checked').val();  
                     var dispatchusertypeMsg=$('input[name=dispatchusertype]:checked').attr('dataid');
                     var storeType = $("#stores option:selected").attr('storeType');
                     var storeTypeMsg = $("#stores option:selected").attr('storeTypeMsg');

                     break;     
                 
            }
           if(aerialExists == "ArialPartner"){
			    var cityId = "<?php echo $cityId;?>";
				var cityName = "<?php echo $cityName;?>"; 
		   }else{
            var cityId = $('#city').val();
            var cityName = $('#city option:selected').attr('cityName');
		   }

          
            var mobile = $('#frm_mobile').val();
            var countryCode = $('#countryCode').val();
          
            var password = $('#password').val();
            var name = $('#name').val();
            var email = $('#email').val();
           

            
            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/; //^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			
				if (cityId == "" || cityId == null) {
                $("#text_CityList").text('Please select city');
            
			}
            else if(flag == 1 && (franchiseId == "" || franchiseId == null)){
                $("#text_FranchiseList").text("Please select the franchise");
            } else if(flag == 2 && (storeId == "" || storeId == null)){
                $("#text_StoresList").text("Please select the store");
            }else if (name == "" || name == null)
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

            }  else {

                $('#yesAdd').prop('disabled', true);


                $.ajax({
                    url: "<?php echo base_url('index.php?/Users') ?>/addUsers",
                    type: "POST",
                    dataType: 'json',
                    data: {userType:userType,userTypeMsg:userTypeMsg,name: name, email: email, mobile: mobile, password: $('#password').val(),countryCode: countryCode,cityId: cityId, cityName: cityName,franchiseId:franchiseId,franchiseName:franchiseName,storeId:storeId,storeName:storeName,dispatchusertype:dispatchusertype,dispatchusertypeMsg:dispatchusertypeMsg,
                        storeType:storeType,storeTypeMsg:storeTypeMsg},
                    success: function (result) {

                        if (result.flag == 1) {

                            $('#addManager').modal('hide');



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
                                        "sAjaxSource": '<?php echo base_url() ?>index.php?/Users/datatable_Users/my/1',
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



                                
                            
                        } else if (result.flag == 0) {

                            $('#addManager').modal('hide');
                            $('#alertForNoneSelected').modal('show');
                            $("#display-data").text("User already exists");

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
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

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
                $("#errorboxactivateManager").text("Are you sure you want to activate the User?");


                $("#yesActivate").click(function () {

//            if(confirm("Are you sure to Delete " +val.length + " Drivers")){
                    $.ajax({
                        url: "<?php echo base_url('index.php?/Users') ?>/activateUsers",
                        type: "POST",
                        data: {val: val},
                        success: function (result) {

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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Users/datatable_Users/my/4',
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
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select only one manager once");
            } else if (val.length == 0) {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text("Please select atleast one manager");
            }

        });


        // Delete function
        $("#userDelete").click(function () {
           
            var deletedBy = "Admin";
            tabURL = $('li.active').children("a").attr('data');
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();           
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
                $("#errorboxactivateManager").text("Are you sure you want to delete the User?");

                $("#yesActivate").click(function () {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/Users') ?>/DeleteTempUsers",
                        type: "POST",
                        data: {val: val},
                        success: function (result) {
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Users/datatable_Users/my/4',
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
                        url: "<?php echo base_url('index.php?/Users') ?>/logoutManagers",
                        type: "POST",
                        data: {masterid: val},
                        success: function (result) {

                          
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Users/datatable_Users/my/2',
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
                $("#errorbox").text("Are you sure you want to deactivate the User?");


                $("#yesdelete").click(function () {

//            if(confirm("Are you sure to Delete " +val.length + " Drivers")){
                    $.ajax({
                        url: "<?php echo base_url('index.php?/Users') ?>/deleteUsers",
                        type: "POST",
                        data: {masterid: val, deletedBy: deletedBy},
                        success: function (result) {

                          
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Users/datatable_Users/my/1',
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
                window.location = "<?php echo base_url() ?>index.php?/Users/editdriver/" + val;
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
        $('#franchiseDiv').hide();
        $('#storeDiv').hide();
        $(".userType").change(function(){
            var type =  $("input:radio[name=usertype]:checked").val();
            switch(type){
                
                case "0": 
                $('#city').val("");
                $('#name').val("");
                $('#email').val("");
                $('#frm_mobile').val("");
                $('#franchiseDiv').hide();
                $('#storeDiv').hide();
				$('#APPcommission').show();
				$('#typeCommission').show();
                $('#dispatchUser').hide();
                break;
                
                case "1":
                $('#city').val("");
                $('#franchise').val("");
				$('#APPcommission').hide();
				$('#typeCommission').hide();
                $('#name').val("");
                $('#email').val("");
                $('#frm_mobile').val("");
                $('.franchiseDivClass').text("*");
                $('#franchiseDiv').show();
                $('#storeDiv').hide();
                $('#dispatchUser').hide();
                break;
               
                case "2":
                $('#city').val("");
                $('#franchise').val("");
                $('#store').val("");
                $('#name').val("");
                $('#email').val("");
                $('#frm_mobile').val("");
                $('.franchiseDivClass').text("");
				$('#APPcommission').hide();
				$('#typeCommission').hide();
                $('#franchiseDiv').show();
                $('#storeDiv').show();
                $('#dispatchUser').show();
                break;
            }
        });
        $('#city').on('change', function () {

            var val = $('#city option:selected').val();
            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/FranchiseManager/getFranchise",
                type: 'POST',
                data: {val: val},
                datatype: 'json', // fix: need to append your data to the call
                success: function (response) {
                    $('#franchise').empty();
                    var r = JSON.parse(response);
                    var html1 = '';
                    html1 = '<option franchiseName="" value="">Select Franchise</option>'
                    $.each(r, function (index, row) {
            
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
                    html = '<option storeName="" value="">Select Stores</option>'
                    $.each(r, function (index, row) {
                       
                        html += '<option storeName="' + row.name + '" storeType="'+row.storeType+'" storeTypeMsg="'+row.storeTypeMsg+'" value="' + row._id.$oid + '">' + row.name + '</option>';
                    });
                    $('#stores').html(html);
                }
            });
			
			//var type = $("input:radio[name=usertype]:checked").val();
		//	if(type == 0){
		//		 $.ajax({
          //      url: "<?php echo base_url(); ?>index.php?/Users/checkCityExistsForPartner",
            //    type: 'POST',
          //      data: {val: val,type:type},
          //      datatype: 'json', // fix: need to append your data to the call
          //      success: function (response) {
          //         if(response.flag == 1){
			//		    $('#alertForNoneSelected').modal('show');
			//			$("#display-data").text("Partner already exists for the selected city");
			//			$('$city').empty();
			//	   }
         //       }
         //   });
				
		//	}
			



});

$('#franchise').on('change',function(){
            var val = $('#franchise option:selected').val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Users/getFranchiseStores",
                type: 'POST',
                data: {val: val},
                datatype: 'json', // fix: need to append your data to the call
                success: function (response) {
                    $('#stores').empty();
                    var r = JSON.parse(response);
                    var html = '';
                    html = '<option storeName="" value="">Select Stores</option>'
                    $.each(r, function (index, row) {
                       
                        html += '<option storeName="' + row.name + '" value="' + row._id.$oid + '">' + row.name + '</option>';
                    });
                    $('#stores').html(html);
                }
            });

        });


        $('#resetPasswordConfirm').click(function () {
            var val = resetval;

            var confirm = $('#confirmpassword').val();
            var newpass = $('#newpass1').val();
            if (confirm == newpass) {

                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Users/resetPassword",
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


        

        var status = '<?php echo $status; ?>';

        if (status == 1) {

            $("#display-data").text("");
            console.log('12');
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
            console.log('apprv clicked');
            $("#display-data").text("");
            $('#managerLogout').hide();
            $('#permanentDelete').hide();
            $('#userDelete').show();
        });

          $('#my2').click(function () {
            console.log('login');
            $('#managerLogout').show();
            $('#permanentDelete').hide();
            $('#userDelete').show();
        });

        $('#my3').click(function () {
            console.log('logout');
            $("#display-data").text("");
            $('#managerLogout').hide();
            $('#permanentDelete').hide();
            $('#userDelete').show();

        });
        $('#my4').click(function () {
            console.log('deact');
            $("#display-data").text("");
            $('#managerLogout').hide();
            $('#permanentDelete').hide();
            $('#userDelete').show();

        });
      

        $('#my5').click(function () {
            console.log('del clicked');
            $("#display-data").text("");
            $('#managerLogout').hide();
            $('#permanentDelete').show();
            $('#active').hide();
            $('#userDelete').hide();




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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/Users/datatable_Users/my/' + status,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,

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

            $('#cityFilter').change(function(){
			
			var city=$('#cityFilter option:selected').attr('cityName');
			var cityId=$('#cityFilter option:selected').val();
			
			table.fnFilter(city);
			
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
                url: "<?php echo base_url() ?>index.php?/Users/driver_logout",
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
                url: "<?php echo base_url('index.php?/Users') ?>/getManagerDetails",
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
<script>
$(document).ready(function () {

    getManagerCount();

    function getManagerCount()
    {
        console.log('val*****')
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Users/getManagerCount",
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
                $('.deactive').text(response.data.deactive);
				
                
            }
        });
    }

    
});

</script>

<script>

$(document).ready(function(){
  $("#permanentDelete").click(function () {
      
     
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
                  
                  url: "<?php echo base_url('index.php?/Users/permanentDelete');?>",
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

  $(document).ready(function () {
		$.ajax({
                url: "<?php echo base_url(); ?>index.php?/Orders/getCities",
                type: "POST",
                data: {},
                dataType: "JSON",
                
                success: function (result) {
                     $('#cityFilter').empty();
                   
                    if(result.data){
                         
                          var html5 = '';
				   var html5 = '<option cityName="" value="" >Select city</option>';
                          $.each(result.data, function (index, row) {
                              
                               html5 += '<option value="'+row.cityId.$oid+'" cityName="'+row.cityName+'">'+row.cityName+'</option>';

                             
                          });
                            $('#cityFilter').append(html5);    
                    }

                     
                }
            });

  

    });


</script>




<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;">

            <strong ><?php echo $this->lang->line('All_Users'); ?></strong>
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">


 
                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->

                    <ul class="nav nav-tabs  bg-white whenclicked">
                        <li id= "my1" class="tabs_active <?php echo ($status == 1 ? "active" : "");?>" style="cursor:pointer">
                            <a  class="changeMode New_" data="<?php echo base_url(); ?>index.php?/Users/datatable_Users/my/1" data-id="1"><span><?php echo $this->lang->line('APPROVED'); ?></span><span class="badge approved" style="background-color: #337ab7;">12</span></a>
                        </li>


                         <li id= "my2" class="tabs_active <?php echo $status ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/Users/datatable_Users/my/2" data-id="2"><span><?php echo $this->lang->line('LOGGEDIN'); ?></span> <span class="badge login" style="background-color: #5bc0de;"></span></a>
                        </li>

                         <li id= "my3" class="tabs_active <?php echo $status ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/Users/datatable_Users/my/3" data-id="3"><span><?php echo $this->lang->line('LOGGEDOUT'); ?></span>  <span class="badge bg-green logout"></span></a>
                        </li>

                        <li id= "my4" class="tabs_active <?php echo $status ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/Users/datatable_Users/my/4" data-id="4"><span><?php echo $this->lang->line('DEACTIVE'); ?></span> <span class="badge bg-green deactive"></span></a>
                        </li>
                        
                        <li id= "my5" class="tabs_active <?php echo $status ?>" style="cursor:pointer">
                            <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/Users/datatable_Users/my/5" data-id="5"><span><?php echo $this->lang->line('DELETED'); ?></span> <span class="badge bg-green deleted"></span></a>
                        </li>

                         <div class="cls111"> <button class="btn btn-success pull-right m-t-10 cls111" id="active" ><?php echo $this->lang->line('ACTIVATE'); ?></button></a></div>
                        <div class="cls111"> <button class="btn btn-warning pull-right m-t-10 cls111" id="chekdel" ><?php echo $this->lang->line('Deactivate'); ?></button></a></div>
                        <div class="cls110"><button class="btn btn-success pull-right m-t-10 cls110" id="add" ><?php echo $this->lang->line('Add'); ?></button></a></div>
                        <div class="cls111"><button class="btn btn-danger pull-right m-t-10 cls111"  id="permanentDelete" style="width: 103px;display:none"><?php echo $this->lang->line('Permanent_Delete'); ?></button></a></div>
                        <div class="cls111"><button class="btn btn-danger pull-right m-t-10 cls111"  id="userDelete" style="width: 103px;"><?php echo $this->lang->line('Delete'); ?></button></a></div>
                        

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

                                    <div class="col-sm-2" style="margin-left: -40px;">

                                        <div class="row clearfix pull-left" style="margin-left:25px;">

                                                    <div class="pull-left">
                                                    <select class="form-control pull-left" id="cityFilter">
                                                
                                                    </select> 
                                                    </div>
                                         </div>                                               
                                    </div>

                                    <div class="pull-right"><form autocomplete="off"><input type="text" id="search-table" onkeypress="return event.keyCode != 13;" autocomplete="off" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"></form> </div>
                                    
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

                <span class="modal-title"><?php echo $this->lang->line('DEACTIVATE'); ?></span>
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
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel51"><?php echo $this->lang->line('Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="yesdelete" ><?php echo $this->lang->line('Deactivate'); ?></button></div>
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

                <span class="modal-title"><?php echo $this->lang->line('LOGOUT'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorboxLogoutManager" style="text-align:center"><?php echo $this->lang->line('LOGOUT'); ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel15"><?php echo $this->lang->line('Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-warning pull-right" id="yesLogout" ><?php echo $this->lang->line('Logout'); ?></button></div>
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

                <span class="modal-title"><?php echo $this->lang->line('ACTIVATE'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">

                <div class="row">

                    <div class="error-box" id="errorboxactivateManager" style="text-align:center"><?php echo $this->lang->line('Activate'); ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel5"><?php echo $this->lang->line('Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="yesActivate" ><?php echo 'Yes'; ?></button></div>
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

                <span class="modal-title"><?php echo $this->lang->line('ADD'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">
                <div class="form-group col-sm-3" style="margin-left: -11px">
                       
                        <div class="col-sm-9">
                            <label class="col-sm-3 control-label"><?php echo $this->lang->line('UserType'); ?><span class="MandatoryMarker">*</span></label>

                        </div>
                       
                    </div>

                    <div class="form-group col-sm-3">
                       
                        <div class="col-sm-6">
                            <input type="radio" checked name="usertype" class="error-box-class userType" id="usertype0" value="0">  

                        </div>
                        <label class="col-sm-3 control-label" style="margin-left: -35px;" for="usertype0"><?php echo $this->lang->line('CityPartner'); ?></label>
                        <div class="col-sm-3 error-box" id="text_usertype0" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-3">
                      
                        <div class="col-sm-6">
                            <input type="radio" name="usertype" class="error-box-class userType" id="usertype1" value="1">  

                        </div>
                        <label class="col-sm-3 control-label" style="margin-left: -35px;" for="usertype1"><?php echo $this->lang->line('Franchise'); ?></label>
                        <div class="col-sm-3 error-box" id="text_usertype1" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-3">
                        
                        <div class="col-sm-6">
                            <input type="radio" name="usertype" class="error-box-class userType" id="usertype2" value="2">  

                        </div>
                        <label class="col-sm-3 control-label"style="margin-left: -35px;" for="usertype2"><?php echo $this->lang->line('Store'); ?></label>
                        <div class="col-sm-3 error-box" id="text_usertype2" style="color:red"></div>
                    </div>
					<?php $role = $this->session->userdata("role");
					   if($role!="ArialPartner"){?>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label">City<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <select id="city" name="city" class="form-control error-box-class">
                                <option value=""><?php echo $this->lang->line('SelectCity'); ?></option>
                                <?php
                                foreach ($cities as $result) { 

                                    echo "<option cityName='" . $result['cityName'] . "'   cityId='" . $result['cityId']['$oid'] . "' value='" . $result['cityId']['$oid'] . "'>" . $result['cityName'] . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-sm-3 error-box" id="text_CityList" style="color:red"></div>
                    </div>
					   <?php } else {?>
					    <div class="form-group col-sm-12" style="display:none">
                        <label class="col-sm-3 control-label">City<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <select id="city" name="city" class="form-control error-box-class">
                                <option value=""><?php echo $this->lang->line('SelectCity'); ?></option>
                                <?php
                                foreach ($cities as $result) { 

                                    echo "<option cityName='" . $result['cityName'] . "'   cityId='" . $result['cityId']['$oid'] . "' value='" . $result['cityId']['$oid'] . "'>" . $result['cityName'] . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-sm-3 error-box" id="text_CityList" style="color:red"></div>
                    </div>
					   <?php } ?>
                    <div class="form-group col-sm-12" id="franchiseDiv">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('Franchise'); ?><span class="MandatoryMarker franchiseDivClass">*</span></label>
                        <div class="col-sm-6">
                            <select id="franchise" name="franchise" class="form-control error-box-class">
                                <option value=""><?php echo $this->lang->line('SelectFranchise'); ?></option>

                            </select>

                        </div>
                        <div class="col-sm-3 error-box" id="text_FranchiseList" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12" id="storeDiv">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('Stores'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <select id="stores" name="stores" class="form-control error-box-class">
                                <option value=""><?php echo $this->lang->line('SelectStores'); ?></option>

                            </select>

                        </div>
                        <div class="col-sm-3 error-box"  id="text_StoresList" style="color:red"></div>
                    </div>
                    

                   

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('Name'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control error-box-class" id="name" minlength="3" placeholder="Enter your name" required="">  

                        </div>
                        <div class="col-sm-3 error-box" id="text_name" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('Email'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control error-box-class" id="email"  placeholder="Enter your email" required="">  

                        </div>
                        <div class="col-sm-3 error-box" id="text_email" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('Password'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="password" required="" class="form-control error-box-class" name="password"  id="password" > 
                            <input type="hidden" name="paswordEncrypted" class="form-control paswordEncrypted">

                        </div>
                        <div class="col-sm-3 error-box" id="text_password" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('Mobile'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="tel" maxlength="10"required="" class="form-control error-box-class" name="frm_mobile"  id="frm_mobile" onkeypress="return isNumberKey(event)" style="    width: 109%;" > 
                            <input type="hidden" id="countryCode" name="coutry-code" value=""> 

                        </div>
                        <div class="col-sm-3 error-box" id="text_mobile" style="color:red"></div>
                    </div>

                    <!-- dispatchusertype -->

                    <!-- <div id="dispatchUser" style="display:none">
                            <div class="form-group col-sm-3" style="margin-left: -11px">
                            
                            <div class="col-sm-12">
                                <label class="col-sm-12 control-label">Dispatch User Type<span class="MandatoryMarker">*</span></label>

                            </div>
                            
                        </div>


                        <div class="form-group col-sm-3">
                            
                            <div class="col-sm-6">
                                <input type="radio" checked name="dispatchusertype" class="error-box-class userType" id="dispatchusertype1" value="1" dataid="Manager">  
                               
                            </div>
                            <label for="dispatchusertype1" class="col-sm-3 control-label" style="margin-left: -35px;">Manager</label>
                            <div class="col-sm-3 error-box" id="text_dispatchusertype0" style="color:red"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            
                            <div class="col-sm-6">
                                <input type="radio" name="dispatchusertype" class="error-box-class userType" id="dispatchusertype2" value="2"  dataid="Packer">  
                               
                            </div>
                            <label for="dispatchusertype2" class="col-sm-3 control-label" style="margin-left: -35px;">Packer</label>
                            <div class="col-sm-3 error-box" id="text_dispatchusertype1" style="color:red"></div>
                        </div>
                    
                    </div> -->
					
					

                   
                    <!--<div class="form-group col-sm-12">
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
                    </div>-->

                </div>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel6"><?php echo $this->lang->line('Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesAdd" ><?php echo $this->lang->line('Add'); ?></button></div>
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

                <span class="modal-title"><?php echo $this->lang->line('EDIT'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">
                            <!-- radio button start -->
                            <div class="form-group col-sm-3" style="margin-left: -11px">
                       
                       <div class="col-sm-9">
                           <label class="col-sm-3 control-label"><?php echo $this->lang->line('UserType'); ?><span class="MandatoryMarker">*</span></label>

                       </div>
                      
                   </div>

                   <div class="form-group col-sm-3">
                      
                       <div class="col-sm-6">
                           <input type="radio"  name="editusertype" class="error-box-class edituserType" value="0">  

                       </div>
                       <label class="col-sm-3 control-label" style="margin-left: -35px;"><?php echo $this->lang->line('CentralManager'); ?></label>
                       <div class="col-sm-3 error-box" id="text_usertype0" style="color:red"></div>
                   </div>
                   <div class="form-group col-sm-3">
                     
                       <div class="col-sm-6">
                           <input type="radio" name="editusertype" class="error-box-class edituserType" value="1">  

                       </div>
                       <label class="col-sm-3 control-label" style="margin-left: -35px;"><?php echo $this->lang->line('Franchise'); ?></label>
                       <div class="col-sm-3 error-box" id="text_usertype1" style="color:red"></div>
                   </div>
                   <div class="form-group col-sm-3">
                       
                       <div class="col-sm-6">
                           <input type="radio" name="editusertype" class="error-box-class edituserType" value="2">  

                       </div>
                       <label class="col-sm-3 control-label"style="margin-left: -35px;" ><?php echo $this->lang->line('Store'); ?></label>
                       <div class="col-sm-3 error-box" id="text_usertype2" style="color:red"></div>
                   </div>

                            <!-- radio button end -->

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('City'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <select id="editcity" name="city" class="form-control error-box-class" disabled>
                                <option value="" ><?php echo $this->lang->line('SelectCity'); ?></option>
                                <?php
                                foreach ($cities as $result) {

                                    echo "<option  cityName='" . $result['cityName'] . "'   cityId='" . $result['cityId']['$oid'] . "' value='" . $result['cityId']['$oid'] . "'>" . $result['cityName'] . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-sm-3 error-box" id="text_edit_CityList" style="color:red"></div>
                    </div>
                   
                          <!-- franchise and store disabled list box  -->
                          <div class="form-group col-sm-12" id="editfranchiseDiv" style="display:none;">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('Franchise'); ?><span class="MandatoryMarker editfranchiseDivClass">*</span></label>
                        <div class="col-sm-6">
                            <select id="editfranchise" name="editfranchise" class="form-control error-box-class">
                                <option value=""><?php echo $this->lang->line('SelectFranchise'); ?></option>

                            </select>

                        </div>
                        <div class="col-sm-3 error-box" id="" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12" id="editstoreDiv" style="display:none;" >
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('Stores'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <select id="editstores" name="editstores" class="form-control error-box-class">
                                <option value=""><?php echo $this->lang->line('SelectStores'); ?></option>

                            </select>

                        </div>
                        <div class="col-sm-3 error-box"  id="" style="color:red"></div>
                    </div>

                          <!-- list box end -->
                  
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('Name'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control error-box-class" id="editname" minlength="3" value="" placeholder="Enter your name" required="">  
                            <div class="error-box" id="text_edit_name" style="color:red"></div>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('Email'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control error-box-class" id="editemail" value="" placeholder="Enter your email" required="">  
                            <div class=" error-box" id="text_edit_email" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('Mobile'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="tel" maxlength="10"required="" value="" class="form-control error-box-class" name="editfrm_mobile"  id="editfrm_mobile" onkeypress="return isNumberKey(event)" style="    width: 100%;" > 
                            <input type="hidden" id="editCountryCode" name="coutry-code" value=""> 
                            <div class=" error-box" id="text_edit_mobile" style="color:red"></div>
                        </div>
                    </div>

                    <!-- <div id="editdispatchUser" style="display:none">
                        <div class="form-group col-sm-3" style="margin-left: -11px">
                            <div class="col-sm-12">
                                <label class="col-sm-12 control-label">Dispatch User Type<span class="MandatoryMarker">*</span></label>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <div class="col-sm-6">
                                <input type="radio" checked name="editdispatchusertype" class="error-box-class userType" id="editdispatchusertype1" value="1" dataid="Manager">  
                            </div>
                            <label class="col-sm-3 control-label" style="margin-left: -35px;">Manager</label>
                            <div class="col-sm-3 error-box" id="text_dispatchusertype0" style="color:red"></div>
                        </div>
                        <div class="form-group col-sm-3">
                            <div class="col-sm-6">
                                <input type="radio" name="editdispatchusertype" class="error-box-class userType" id="editdispatchusertype2" value="2"  dataid="Packer">  
                            </div>
                            <label class="col-sm-3 control-label" style="margin-left: -35px;">Packer</label>
                            <div class="col-sm-3 error-box" id="text_dispatchusertype1" style="color:red"></div>
                        </div>
                    </div> -->

                </div>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel7"><?php echo $this->lang->line('Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesEdit" ><?php echo 'Save'; ?></button></div>
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
                        <button type="button" class="btn btn-default pull-right" id="accepted_msg" >Close<?php echo $this->lang->line('Details'); ?></button>
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
                    <span class="modal-title"><?php echo $this->lang->line('DOCUMENTS'); ?></span>
                </div>


                <div class="modal-body">
           <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->

                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th style="width:20%;text-align: center;"><?php echo $this->lang->line('TYPE'); ?></th>
                                <th style="width:10%;text-align: center;"><?php echo $this->lang->line('PREVIEW'); ?></th>

                            </tr>
                        </thead>
                        <tbody id="doc_body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>

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
                <span class="modal-title"><?php echo $this->lang->line('LOGOUT'); ?></span>
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
                <span class="modal-title"><?php echo $this->lang->line('DEVICEINFO'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">

                <div class="form-group row">

                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for=""><?php echo $this->lang->line('Make'); ?></label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="make"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for=""><?php echo $this->lang->line('Model'); ?></label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="model"></span>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for=""><?php echo $this->lang->line('OS'); ?></label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="os"></span>
                    </div>

                </div>
                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for=""><?php echo $this->lang->line('logindt'); ?></label>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <span style="" class="lastLoginDate"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4" for=""><?php echo $this->lang->line('PushToken'); ?></label>
                    <div class="col-md-8 col-sm-8 pushToken" style="word-break: break-all;">

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade stick-up" id="deviceLogPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title"><?php echo $this->lang->line('DEVICEINFO'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body form-horizontal">
                <div class="row">
                    <span style="color:#738092;font-weight:700;margin-left: 10px;"> <?php echo $this->lang->line('ManagerName'); ?><span id="d_name_history" style="color:#1ABB9C;"></span></span>
                </div>
                <br>
                <div class="table-responsive">
                    <table class='table table-striped table-bordered table-hover demo-table-search' id="devices_datatable">
                        <thead>
                        <th ><?php echo $this->lang->line('DEVICETYPE'); ?></th>
                        <th style=""><?php echo $this->lang->line('APPVERSION'); ?></th>
                        <th style=""><?php echo $this->lang->line('DEVICEMAKE'); ?></th>
                        <th style=""><?php echo $this->lang->line('DEVICEMODEL'); ?></th>
                        <th style=""><?php echo $this->lang->line('DEVICEID'); ?></th>
                        <th style=""><?php echo $this->lang->line('DEVICEOS'); ?></th>
                        <th style=""><?php echo $this->lang->line('PUSHTOKEN'); ?></th>
                        <th style=""><?php echo $this->lang->line('LASTLOGGEDINDATE'); ?></th>
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
                <span class="modal-title TitleText" style="color:#337ab7;"><?php echo $this->lang->line('Alert'); ?></span>
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
                        <span class="modal-title"><?php echo $this->lang->line('RESETPASSWORD'); ?></span>
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
                <strong style="color:#0090d9;"><?php echo $this->lang->line('MANAGERDETAILS'); ?></strong>
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
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name"><?php echo $this->lang->line('Name'); ?></label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="dname"></span>
                            </div>

                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name"><?php echo $this->lang->line('Email'); ?></label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="demail"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name"><?php echo $this->lang->line('Phone'); ?></label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="dphone"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
            </div>
        </div>

    </div>
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

                    <div class="modal-body">
                                    <!-- changes -->
                        <!-- <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label">Current Password<span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  id="oldpass" name="oldpass" onblur="validatePassword()"  class="error-box-class form-control" placeholder="eg:g3Ehadd">
                                   
                                </div>
                            </div> -->

                            <br>
                            <br>
                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-4 control-label"> <?php echo 'New Password'; ?><span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  id="newpassreset" name="latitude"  class="error-box-class form-control" placeholder="Enter a new password">
                                </div>
                            </div>

                            <br>
                            <br>

                            <div class="form-group" class="formex">
                                <label for="fname" class="col-sm-4 control-label"><?php echo 'Confirm Password'; ?><span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text"  id="confirmpassreset" name="longitude" class="error-box-class form-control" placeholder="Confirm new password.">
                                </div>
                            </div>

                             <div class="form-group" class="formex">
                             <label for="fname" class="col-sm-6 control-label"><span style="color:red;" id="pwdErr"></span></label>
                                <div class="col-sm-6">
                                
                                </div>
                            </div>
                            
                          
                           

                            <div class="row">
                                <div class="col-sm-4" ></div>
                                <div class="col-sm-8 error-box" ><p><?php echo $this->lang->line('Error'); ?></p></div>
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
                    <div class="" id="popupmodeltext" style="font-size:15px;margin-left: 181px;"></div>

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


<div class="modal fade" id="walletSettingsPopUp" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;"><?php echo $this->lang->line('CREDITLINE'); ?></strong>
            </div>
            <div class="modal-body">
                <form id="4a" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="form-group">
                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Soft Limit'); ?></label>
                        <div class="col-sm-6">
                            <span  class="abs_text"><b><?php echo $appCofig['currencySymbol']; ?></b></span>
                            <input type="text" class="form-control number" id="softLimitForDriver" name="softLimitForDriver" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $softLimitForDriver; ?>">
                        </div>
                        <div class="col-sm-3 errors softLimitForDriverErr"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('HardLimit'); ?></label>
                        <div class="col-sm-6">
                            <span  class="abs_text"><b><?php echo $appCofig['currencySymbol']; ?></b></span>
                            <input type="text" class="form-control number" id="hardLimitForDriver" name="hardLimitForDriver" placeholder="" onkeypress="return isNumberKey(event)"  value="<?php echo $hardLimitForDriver; ?>">
                        </div>
                        <div class="col-sm-3 errors hardLimitForDriverErr"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                <button type="button" class="btn btn-success pull-right" id="creditSubmit" ><?php echo $this->lang->line('Update'); ?></button>
            </div>
        </div><script src="<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/intlTelInput.js"></script>

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

