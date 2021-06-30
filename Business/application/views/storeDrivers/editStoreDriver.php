<style>
.MandatoryMarker{
    color:red;
}
.error{
        color:red;
    }

    .intl-tel-input {
        position: relative;
        display: block;
        height: 40px;
    }

</style>
<link href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<script>
    var myIP = '';
    function isNumberKey(evt)
    {
        $("#mobify").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
            //    alert("Only numbers are allowed");
            $("#mobify").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
            return false;
        }
        return true;
    }

    	$('#firstname').focusout(function(){
		var storeId = "<?php echo $storeId;?>";
		$.ajax({
                url: "<?php echo base_url(); ?>index.php?/Drivers/getZonesBasedOnStores",
                type: "POST",
                data: {storeId:storeId},
                dataType: "JSON",
                async: false,
                success: function (result) {

                    if (result) {
                   console.log(result.data);
				   $('#serviceZones').empty();
				   var html = '';
                        $.each(result.data, function (index, row) {

                            var html = '<div class="form-group">'
                                    + '<label for="fname" class="col-sm-2 control-label">' + row + '<span style="color:red;" class="MandatoryMarker"> *</span></label>'
                                    + '<div class="col-sm-6">'
                                    +'<input  name="checkboxs[]" value="' + index + '"required="required" type="checkbox" class="checkbox"> </div>'
                                    +'<div class="col-sm-3 error-box" id="file_driver_exdate"></div></div>';

                               $('#serviceZones').append(html);    
                        });
 
                    } 
                }
            });
		
	});

    $(document).ready(function () {

        $("#addentity").validate({
            rules: {
        
                mobile: {
                    required: true,
                    number: true,
                    validNumber: true
                }      
              }
        
        });

       var telInput = $("#mobile");
        $.validator.addMethod("validNumber", function (value, element) {
            if (telInput.intlTelInput("isValidNumber")) {
                return true;
            } else {
                return false;
            }
        }, "Please enter valid number");

        var storeId = "<?php echo $storeId;?>";
        console.log('stoew',storeId);
		$.ajax({
                url: "<?php echo base_url(); ?>index.php?/Drivers/getZonesBasedOnStores",
                type: "POST",
                data: {storeId:storeId},
                dataType: "JSON",
                async: false,
                success: function (result) {

                    if (result) {
                   console.log(result.data);
				   $('#serviceZones').empty();
				   var html = '';
                        $.each(result.data, function (index, row) {

                            var html = '<div class="form-group">'
                                    + '<label for="fname" class="col-sm-2 control-label">' + row + '</label>'
                                    + '<div class="col-sm-6">'
                                    +'<input  name="checkboxs[]" value="' + index + '"required="required" type="checkbox" class="checkbox"> </div>'
                                    +'<div class="col-sm-3 error-box" id="file_driver_exdate"></div></div>';

                               $('#serviceZones').append(html);    
                        });
 
                    } 
                }
            });
    });

    //Check if the stripe has verified the account or/and added bank account
    $.ajax({
        url: '<?php echo APILink; ?>admin/stripe/<?php echo $driverid; ?>',
                type: "GET",
                dataType: "JSON",
                success: function (result) {
                    console.log(result);
                    $('.createBankAccountDivButton').hide();
                    $('.stripeResponse').text('');
                    if (result.errFlag != 1)
                    {
                        if (result.legal_entity.verification.status == "verified")
                        {

                            if (result.external_accounts.data.length > 0)
                            {

                                $('.createBankAccountDivButton').hide();
                                $.each(result.external_accounts.data, function (index, value)
                                {
                                    $('.stripeCreateFormDiv').hide();
                                    $('.addBankFormDiv').show();

                                    $('#bankCountryRead').val(value.country);
                                    $('#bankAccountNumberRead').val('********' + value.last4);
                                    $('#bankAccountHolderNameRead').val(value.account_holder_name);
                                    $('#bankRoutingNumberRead').val(value.routing_number);


                                });
                            } else
                            {

                                $('.createBankAccountDivButton').show();
                                $('.stripeCreateFormDiv').hide();
                                $('.addBankFormDiv').hide();
                            }
                        } else {

                            $('.stripeResponse').css('color', 'red');
                            $('.stripeResponse').text('Account is not verified yet..!');
                        }

                    } else {

                        $('.addBankFormDiv').hide();

                    }
                }
            });


            $(document).ready(function () {


                $('.tabs_active').click(function () {

                    var pstatus = true;
                    if ($(this).attr('id') != 'fifthlitab')
                    {
                        console.log('clicked');
                        $("#finishbutton").addClass("hidden");
                        $("#finishbutton").css("display","none");
                        // $("#finishbutton").removeClass("hidden");
                        // $("#nextbutton").addClass("hidden");

                        //  $("#finishbutton").hide();
                        // $("#prevbutton").hide();
                        // $("#nextbutton").addClass("hidden");

                    } 

                });

                $('.radio-success').click(function ()
                {
                    if ($(this).attr('id') == 'Freelancer')
                    {
//                        $('#company_select').prop('disabled', true);
                        $('#store_select').prop('disabled', true);
//                        $('#company_select').val('');
                        $('#store_select').val('');
                        $('#selectedOwnerType').val('1');

                    } else if ($(this).attr('id') == 'store') {
//                        $('#company_select').prop('disabled', true);
                        $('#store_select').prop('disabled', false);
//                        $('#company_select').val('');
                        $('#selectedOwnerType').val('3');
                    } else
                    {
//                        $('#company_select').prop('disabled', false);
                        $('#store_select').prop('disabled', true);
                        $('#store_select').val('');
                        $('#selectedOwnerType').val('2');
                    }
                });
//                if ($('#Operator').prop('checked', true)) {
//                    $('#store_select').prop('disabled', true);
//                    $('#store_select').val('');
//                }
                $('#storeName').val("<?php echo $data['storeName'];?>"); 

                $('#store_select').change(function ()
                {
                    $('#storeName').val($('#store_select option:selected').attr('storeName'));
                });
                $('#addBankAcc').click(function () {

                    $('.stripeResponse').text('');
                    if ($('#presnalid').val() == "") {
                        alert('Personal Id is missing.');
                    } else if ($('#presnalid').val().length != 9) {
                        alert('Personal Id should have 9 digit long');
                    } else if ($('#account_holder_fname').val() == "") {
                        alert('First name is missing.');
                    } else if ($('#account_holder_lname').val() == "") {
                        alert('Last name is missing.');
                    } else if ($('#routing_number').val() == "") {
                        alert('Routing number is missing.');
                    } else if ($('#routing_number').val().length != 9) {
                        alert('Routing number should have 9 digit long');
                    } else if ($('#account_number').val() == "") {
                        alert('Accounting number is missing.');
                    } else if ($('#account_number').val().length != 12) {
                        alert('Accounting number have 12 digit long');
                    } else if ($('#Address').val() == "") {
                        alert('Address  is missing.');
                    } else if ($('#cityname').val() == "") {
                        alert('cityname  is missing.');
                    } else if ($('#postalcode').val() == "") {
                        alert('postal code  is missing.');
                    } else if ($('#state').val() == "") {
                        alert('state is missing.');
                    } else if ($('#idproof').val() == "") {
                        alert('Id proof is missing.');
                    } else if ($('#DateOfB').val() == "") {
                        alert('Date Of Birth is missing.');
                    } else {
                        var dob = $("#DateOfB").val().split('/');
                        $.ajax({
                            url: '<?php echo APILink; ?>admin/stripe',
                            type: "POST",
                            data: {id: "<?php echo $driverid; ?>", city: $('#cityname').val(), country: $('#country').val(), line1: $('#Address').val(), postal_code: $('#postalcode').val(), state: $('#state').val(), day: dob[1], month: dob[0], year: dob[2], first_name: $('#account_holder_fname').val(), last_name: $('#account_holder_lname').val(), document: $('#idproof').val(), personal_id_number: $('#presnalid').val(), date: $("#DateOfB").val(), ip: myIP},
                            dataType: "JSON",
                            beforeSend: function (xhr) {
                                $(".loader").fadeIn("slow");
                            },
                            success: function (result) {

                                if (result.errNum == 200)
                                {
                                    $('.stripeResponse').css({'color': 'green'});
                                    $('.stripeResponse').text('Stripe account is created succefully.Will be activated soon...!');

                                    setTimeout(function () {
                                        //Check if the stripe has verified the account or not
                                        $.ajax({
                                            url: '<?php echo APILink; ?>admin/stripe/<?php echo $driverid; ?>',
                                                                                type: "GET",
                                                                                dataType: "JSON",
                                                                                complete: function () {
                                                                                    $(".loader").fadeOut("slow");
                                                                                },
                                                                                success: function (result) {
//                                                                             $('.stripeResponse').text('');

                                                                                    $('.stripeCreateFormDiv').hide();
                                                                                    if (result.legal_entity.verification.status == "verified")
                                                                                    {

                                                                                        $('.stripeResponse').css({'color': 'green'});
                                                                                        $('.stripeResponse').text('Stripe account is verified.Please add bank details');
                                                                                        $('.createBankAccountDivButton').show();

                                                                                    } else {

                                                                                        $('.createBankAccountDivButton').hide();
                                                                                        $('.stripeResponse').css({'color': 'red'});
                                                                                        $('.stripeResponse').text('Stripe account is not verified yet.');
                                                                                    }
                                                                                }
                                                                            });

                                                                        }, 2000);


                                                                    } else
                                                                    {
                                                                        $(".loader").fadeOut("slow");
                                                                        $('.stripeResponse').css({'color': 'red'});
                                                                        $('.stripeResponse').text('Erro while adding stripe account');
                                                                    }
                                                                }
                                                            });


                                                        }
                                                    });

                                                    $('#createBankAccount').click(function ()
                                                    {
                                                        $('#createBankAccountPopUp1').modal('show');
                                                    });

                                                    $('#addBankAccount').click(function ()
                                                    {
                                                        if ($('#bankAccountNumber').val() == '')
                                                            alert('Please enter bank account number');
                                                        else if ($('#bankAccountNumber').val().length != 12)
                                                            alert('Account number should have 12 digit long');
                                                        else if ($('#bankAccountHolderName').val() == '')
                                                            alert('Please enter bank account holder name');
                                                        else if ($('#bankRoutingNumber').val() == '')
                                                            alert('Please enter bank routing number');
                                                        else if ($('#bankRoutingNumber').val().length != 9)
                                                            alert('Routing number should have 9 digit long');
                                                        else {
                                                            //Add bank account information
                                                            $.ajax({
                                                                url: '<?php echo APILink; ?>admin/stripe/bank',
                                                                type: "POST",
                                                                data: {id: "<?php echo $driverid; ?>", account_number: $('#bankAccountNumber').val(), routing_number: $('#bankRoutingNumber').val(), account_holder_name: $('#bankAccountHolderName').val(), country: $('#bankCountry').val()},
                                                                dataType: "JSON",
                                                                beforeSend: function (xhr) {
                                                                    $(".loader").fadeIn("slow");
                                                                },
                                                                complete: function () {
                                                                    $(".loader").fadeOut("slow");
                                                                },
                                                                success: function (result) {
                                                                    $('.stripeResponse').text('');
                                                                    if (result.errNum == 200) {
                                                                        $('.stripeCreateFormDiv').hide();
                                                                        $('.createBankAccountDivButton').hide();
                                                                        $('.addBankFormDiv').show();
                                                                        $('.close').trigger('click');

                                                                        $('#bankCountryRead').val(result.data.country);
                                                                        $('#bankAccountNumberRead').val('********' + result.data.last4);
                                                                        $('#bankAccountHolderNameRead').val(result.data.account_holder_name);
                                                                        $('#bankRoutingNumberRead').val(result.data.routing_number);

                                                                    } else {
                                                                        alert('Error..!while adding a bank account information')
                                                                    }

                                                                }
                                                            });
                                                        }
                                                    });

//        $("#datepicker1").datepicker({ minDate: 0});
                                                    var date = new Date();
                                                    $('.datepicker-component').datepicker({
                                                        startDate: date
                                                    });

//         var date = new Date('1999-01-01');
                                                    $('.datepicker-component1').datepicker({
                                                        endDate: '31-12-2010',
                                                    });

                                                    $('.datepicker-component').on('changeDate', function () {
                                                        $(this).datepicker('hide');
                                                    });

                                                    $('.datepicker-component1').on('changeDate', function () {
                                                        $(this).datepicker('hide');
                                                    });

                                                    $("#mobile").on("countrychange", function (e, countryData) {
                                                        $("#coutry-code").val(countryData.dialCode);
                                                    });



                                                    $("#firstname").keypress(function (event) {
                                                        var inputValue = event.which;
                                                        //if digits or not a space then don't let keypress work.
                                                        if ((inputValue > 64 && inputValue < 91) // uppercase
                                                                || (inputValue > 96 && inputValue < 123) // lowercase
                                                                || inputValue == 32) { // space
                                                            return;
                                                        }
                                                        event.preventDefault();
                                                    });

                                                    $("#lastname").keypress(function (event) {
                                                        var inputValue = event.which;
                                                        //if digits or not a space then don't let keypress work.
                                                        if ((inputValue > 64 && inputValue < 91) // uppercase
                                                                || (inputValue > 96 && inputValue < 123) // lowercase
                                                                || inputValue == 32) { // space
                                                            return;
                                                        }
                                                        event.preventDefault();
                                                    });

                                                    // old version
                                                    // $(":file").on("change", function (e) {
                                                    //     var fieldID = $(this).attr('id');
                                                    //     var folderName;
                                                    //     var ext = $(this).val().split('.').pop().toLowerCase();
                                                    //     if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                                                    //         $(this).val('');
                                                    //         alert('invalid extension..!   Please choose file type in (gif,png,jpg,jpeg)');
                                                    //     } else
                                                    //     {
                                                    //         var type;
                                                    //         if ($(this).attr('id') == 'file_upload')
                                                    //             type = 1;
                                                    //         else if ($(this).attr('id') == 'id_proof')
                                                    //             type = 3;
                                                    //         else
                                                    //             type = 2;


                                                    //         var formElement = $(this).prop('files')[0];
                                                    //         var form_data = new FormData();


                                                    //         form_data.append('OtherPhoto', formElement);
                                                    //         form_data.append('type', 'Drivers');
                                                    //         form_data.append('folder', 'Drivers');

                                                    //         $.ajax({
                                                    //             url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                                                    //             type: "POST",
                                                    //             data: form_data,
                                                    //             dataType: "JSON",
                                                    //             async: false,
                                                    //             beforeSend: function () {
                                                    //                 //                    $("#ImageLoading").show();
                                                    //             },
                                                    //             success: function (result) {

                                                    //                 if (type == 1)
                                                    //                 {
                                                    //                     $('#driverImage').val(result.fileName);
                                                    //                     $('.driverImage').attr('src', result.fileName);
                                                    //                 } else if (type == 3)
                                                    //                 {
                                                    //                     $('#idproof').val(result.fileName);
                                                    //                 } else
                                                    //                 {
                                                    //                     $('#driverLicence').val(result.fileName);
                                                    //                     $('.driverLicence').attr('src', result.fileName);
                                                    //                 }

                                                    //             },
                                                    //             error: function () {

                                                    //             },
                                                    //             cache: false,
                                                    //             contentType: false,
                                                    //             processData: false
                                                    //         });
                                                    //     }
                                                    // })

                                    // chnages done here
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
                                                            case "file_upload":
                                                                type = 1;
                                                                folderName = 'ProfilePics';
                                                                break;
                                                            case "id_proof":
                                                                type = 3;
                                                                folderName = 'BankIDProof';
                                                                break;
                                                            case "driverBack":
                                                                type = 4;
                                                                folderName = 'DriverLincence';
                                                                break;
                                                            default :
                                                                type = 2;
                                                                folderName = 'DriverLincence';

                                                        }

                                                        var formElement = $(this).prop('files')[0];
                                                        var form_data = new FormData();

                                                        form_data.append('OtherPhoto', formElement);
                                                        form_data.append('type', 'Drivers');
                                                        form_data.append('folder', folderName);
                                                        $.ajax({
                                                            url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                                                            type: "POST",
                                                            data: form_data,
                                                            dataType: "JSON",
                                                            async: false,
                                                            beforeSend: function () {
                                                                //                    $("#ImageLoading").show();
                                                            },
                                                            success: function (result) {

                                                                switch (type)
                                                                {
                                                                    case 1:
                                                                        $('#driverImage').val(result.fileName);
                                                                        $('.driverImage').attr('src', result.fileName);
                                                                        $('.driverImage').show();
                                                                        break;
                                                                    case 2:
                                                                        $('#driverLicence').val(result.fileName);
                                                                        $('.driverLicence').attr('src', result.fileName);
                                                                        $('.driverLicence').show();
                                                                        break;
                                                                    case 3:
                                                                        $('#idproof').val(result.fileName);
                                                                        $('#idproof').attr('data-id', '1');
                                                                        break;
                                                                    case 4:
                                                                        $('#driverLicenceBack').val(result.fileName);
                                                                        $('.driverLicenceBack').attr('src', result.fileName);
                                                                        $('.driverLicenceBack').show();
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




                                                    $('.drivers').addClass('active');
                                                    $('.driver_thumb').addClass("bg-success");

                                                    $('#city_select').change(function () {
                                                        $('#getvechiletype').load('<?php echo base_url() ?>index.php?/Drivers/ajax_call_to_get_types/vtype', {city: $('#city_select').val()});
                                                    });


                                                    $('#title').change(function () {
                                                        $('#vehiclemodel').load('<?php echo base_url() ?>index.php?/Drivers/ajax_call_to_get_types/vmodel', {adv: $('#title').val()});
                                                    });


//                                                    $('#company_select').change(function ()
//                                                    {
//                                                        $('#operatorName').val($('#company_select option:selected').attr('operatorName'));
//                                                    });

                                                });
                                                function emailValidationCheck(email)
                                                {
                                                    var status = '1';
                                                    var returnStatus;
                                                    $.ajax({
                                                        url: "<?php echo base_url(); ?>index.php?/Drivers/validateEmail",
                                                        type: "POST",
                                                        data: {email: email},
                                                        dataType: "JSON",
                                                        async: false,
                                                        success: function (result) {

                                                            $('#email').attr('data', result.msg);

                                                            if (result.msg == '1') {

                                                                $("#editerrorbox").html("Email is already allocated !");
                                                                $('#email').focus();
                                                                returnStatus = true;

                                                            } else if (result.msg == '0') {
                                                                $("#editerrorbox").html("");
                                                                status = '0';
                                                                returnStatus = false;

                                                            }
                                                        }
                                                    });

                                                    return returnStatus;

                                                }

//validations for each previous tab before proceeding to the next tab
                                                function managebuttonstate()

                                                {
                                                    $("#prevbutton").addClass("hidden");
                                                    $("#cancelbutton").removeClass("hidden");
                                                }
                                                function phoneValidationCheck(phone, coutryCode)
                                                {

                                                    var driverId ="<?php echo $driverid;?>";
                                                    var OnlymobileNo = phone;
                                                    var CountryCodeMobileNo = '+' + coutryCode;
                                                    var returnStatus;
                                                    var status = '1';
                                                    $.ajax({
                                                        url: "<?php echo base_url(); ?>index.php?/Drivers/validateMobileNoEditDriver",
                                                        type: "POST",
                                                        data: {CountryCodemobileNo: CountryCodeMobileNo, onlyMobileNo: OnlymobileNo,driverId:driverId},
                                                        dataType: "JSON",
                                                        async: false,
                                                        success: function (result) {

                                                            $('#mobile').attr('data', result.msg);

                                                            if (result.msg == '1') {

                                                                $("#driver_mobile").html("Number is already registered!");
                                                                $('#mobile').focus();
                                                                returnStatus = true;

                                                            } else if (result.msg == '0') {
                                                                $("#driver_mobile").html("");
                                                                status = '0';
                                                                returnStatus = false;

                                                            }
                                                        }
                                                    });
                                                    return returnStatus;
                                                }

                                                function profiletab(litabtoremove, divtabtoremove)
                                                {

                                                    var pstatus = true;

                                                    $("#error-box").text("");

                                                    $("#text_firstname").text("");
                                                    $("#text_lastnmae").text("");
                                                    $("#driver_mobile").text("");
                                                    $("#file_driver_photo").text("");

                                                    var firstname = $("#firstname").val();
                                                    var lastname = $("#lastname").val();
                                                    var mobile = $('#mobile').val();
                                                    var driverphoto = $('#driverImage').val();
                                                    var memberRenewalDate = $('#memberRenewalDate').val();
                                                    var dob = $("#dob").val();
//                                                    var company_select = $("#company_select").val();
                                                    var store_select = $("#store_select").val();


                                                    var selectedOwnerType = $("#selectedOwnerType").val();
                                                    var password = /^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,15}$/;

                                                    var number = /^[0-9-+]+$/;


                                                    var email = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/; //^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                                                    var text = /^[a-zA-Z ]*$/;
                                                    var alphabit = /^[a-zA-Z]+$/;
                                                    var num = /^[0-9]+$/;


//                                                    if (company_select == "" && selectedOwnerType == 2)
//                                                    {
//                                                        $("#ve_compan").text('Please choose an operator');
//                                                        pstatus = false;
//                                                    } else 
                                                        if (store_select == "" && selectedOwnerType == 3)
                                                    {
                                                        $("#ve_store").text('Please choose an store');
                                                        pstatus = false;
                                                    } else if (firstname == "")
                                                    {
                                                        $("#ve_compan").text('');
                                                        $("#text_firstname").text(<?php echo json_encode(POPUP_DRIVER_FIRSTNAME); ?>);
                                                        pstatus = false;
                                                    } else if (dob == "")
                                                    {
                                                        $("#ve_compan").text('');
                                                        $("#text_firstname").text('');
                                                        $("#dobErr").text('Please choose date of birth');
                                                        pstatus = false;
                                                    } else if (memberRenewalDate == "")
                                                    {
                                                        $("#ve_compan").text('');
                                                        $("#text_firstname").text('');
                                                        $("#dobErr").text("");
                                                        $("#memberRenewalDateErr").text('Please choose membership renewal date');
                                                        pstatus = false;
                                                    } else if ((driverphoto == "" || driverphoto == null) && $('#viewimage_hidden').val() == '')
                                                    {
                                                        $("#ve_compan").text('');
                                                        $("#text_firstname").text('');
                                                        $("#dobErr").text("");
                                                        $("#memberRenewalDateErr").text('');
                                                        $("#file_driver_photo").text(<?php echo json_encode(POPUP_DRIVER_DRIVERPHOTO); ?>);
                                                        pstatus = false;
                                                    }


                                                    if (pstatus === false)
                                                    {
                                                        setTimeout(function ()
                                                        {
                                                            proceed(litabtoremove, divtabtoremove, 'firstlitab', 'tab1');
                                                        }, 300);


                                                        $("#tab1icon").removeClass("fs-14 fa fa-check");
                                                        return false;
                                                    }
                                                    $("#tab1icon").addClass("fs-14 fa fa-check");
                                                    $("#cancelbutton").removeClass("hidden");
                                                    $("#prevbutton").removeClass("hidden");

                                                    if (litabtoremove == "fourthlitab")
                                                    {

                                                        $("#nextbutton").addClass("hidden");
                                                        $("#finishbutton").removeClass("hidden");
                                                    } else {
                                                        $("#nextbutton").removeClass("hidden");
                                                        $("#finishbutton").addClass("hidden");
                                                    }
                                                    return true;
                                                }

                                                function addresstab(litabtoremove, divtabtoremove)
                                                {
                                                    var astatus = true;

                                                    if (profiletab(litabtoremove, divtabtoremove))
                                                    {
                                                        astatus == true;
                                                       
                                                        var phoneCheck = phoneValidationCheck($('#mobile').val(), $('#coutry-code').val());

                                                        $("#text_password").text("");
                                                        $("#text_zip").text("");
//              $('#email').attr('disabled', true);

                                                        var email = $("#email").val();
                                                        var password = $("#password").val();
                                                        var zipcode = $('#zipcode').val();
                                                        var mobile = $('#mobile').val();

                                                        var pass = /^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,15}$/;
                                                        var num = /^[0-9]+$/;

//                                                        if (password == "" || password == null)
//                                                        {
//                                                            $("#text_email").text("");
//                                                            $("#text_password").text(<?php echo json_encode(POPUP_DRIVER_DRIVER_PASSWORD); ?>);
//                                                            astatus = false;
//                                                        } else
                                                        if (mobile == "" || mobile == null)
                                                        {
                                                            $("#driver_mobile").text(<?php echo json_encode(POPUP_DRIVER_MOBILE); ?>);
                                                            astatus = false;
                                                        } else if (mobile.length < 4)
                                                        {
                                                            $("#driver_mobile").text(<?php echo json_encode(POPUP_DRIVER_MOBILE_VALIDATION); ?>);
                                                            astatus = false;
                                                        } else if (!num.test(mobile))
                                                        {
                                                            $("#driver_mobile").text(<?php echo json_encode(POPUP_DRIVER_MOBILE_VALIDATION); ?>);
                                                            astatus = false;
                                                        } else if ($('#mobile').attr('data') == 1)
                                                        {
                                                            $("#driver_mobile").text('Mobile is already registered');
                                                            astatus = false;
                                                        } else if (phoneCheck)
                                                        {
                                                            $("#driver_mobile").text('Mobile is already registered');
                                                            astatus = false;
                                                        }else if(!$("#addentity").valid()){
                                                            astatus = false;
                                                        }

                                                        if (astatus === false)
                                                        {
                                                            setTimeout(function ()
                                                            {
                                                                proceed(litabtoremove, divtabtoremove, 'secondlitab', 'tab2');

                                                            }, 100);

//                alert("complete Login Details tab properly")
                                                            $("#tab2icon").removeClass("fs-14 fa fa-check");
                                                            return false;
                                                        }

                                                        $("#tab2icon").addClass("fs-14 fa fa-check");
                                                        $("#nextbutton").removeClass('hidden');
//            $("#finishbutton").removeClass("hidden");
//            $("#nextbutton").addClass("hidden");

                                                        return astatus;
                                                    }
                                                }

                                                function fifthTab()
                                                {
                                                    $(".loader").fadeOut("slow");
                                                }




                                                function bonafidetab(litabtoremove, divtabtoremove)
                                                {
                                                    console.log(litabtoremove,litabtoremove)
                                                    var bstatus = true;
                                                    if (addresstab(litabtoremove, divtabtoremove))
                                                    {
                                                        console.log('bona p1')
                                                        if (($("#driverLicence").val() == '' && $('#licence_hidden').val() == ''))
                                                        {
                                                            bstatus = false;

                                                            $('#file_driver_license').text("Complete Driving Licence tab properly");
                                                        }
                                                        if ($("#expirationrc").val() == '')
                                                        {
                                                            bstatus = false;
                                                            $('#file_driver_license').text("")
                                                            $('#file_driver_exdate').text("Please select expiry date");

                                                        }

                                                        if (bstatus === false)
                                                        {
                                                            setTimeout(function ()
                                                            {
                                                                proceed(litabtoremove, divtabtoremove, 'thirdlitab', 'tab3');

                                                            }, 100);


                                                            $("#tab3icon").removeClass("fs-14 fa fa-check");
                                                            return false;
                                                        }

                                                        $("#tab3icon").addClass("fs-14 fa fa-check");



                                                            <?php
                                                            if ($appCofig['pricing_model']['paymentMode'] == 1) {
                                                                ?>  
                                                            console.log('pass 1')
                                                            $("#finishbutton").addClass("hidden");
                                                            $("#nextbutton").removeClass("hidden");
                                                            $("#nextbutton").addClass("show");

                                                            <?php
                                                        } 
                                                        ?>                      
                                                         console.log('pass 3')
                                                        $("#finishbutton").addClass("hidden");
                                                        $("#nextbutton").removeClass("hidden");

                                                        $("#cancelbutton").removeClass("hidden");
                                                        return bstatus;

                                                    }
                                                }


                                                  function bankdetailtab(litabtoremove, divtabtoremove)
                                                {
                                                    var astatus = true;

                                                        console.log('fifith clicked');

                                                        if(!$(".checkbox:checked").length){
                                                            console.log("if here")
                                                            $("#serviceError").css("display","block")
                                                            $("#nextbutton").removeClass("hidden");
                                                            setTimeout(function ()
                                                            {
                                                                proceed(litabtoremove, divtabtoremove, 'fourthlitab', 'tab4');

                                                            }, 100);
                                                            
                                                            
                                                            $("#tab4icon").removeClass("fs-14 fa fa-check");
                                                            return false;
                                                        }
                                                        $("#finishbutton").removeClass("hidden");
                                                        $("#finishbutton").css("display","block");
                                                        $("#nextbutton").addClass("hidden");
                                                        
                                                       
                                                        
                                                }

                                                function signatorytab(litabtoremove, divtabtoremove)
                                                {
                                                    var bstatus = true;
                                                    if (bonafidetab(litabtoremove, divtabtoremove))
                                                    {
                                                        if (isBlank($("#entitypersonname").val()) || isBlank($("#entitysignatorymobileno").val()) || isBlank($("#entitysignatoryimagefile").val()) || $("#entitydegination").val() === "null")
                                                        {
                                                            bstatus = false;
                                                        }

                                                        if (validateEmail($("#entityemail").val()) !== 2)
                                                        {
                                                            bstatus = false;
                                                        }

                                                        if (bstatus === false)
                                                        {
                                                            setTimeout(function ()
                                                            {
                                                                proceed(litabtoremove, divtabtoremove, 'fourthlitab', 'tab4');

                                                            }, 100);

                                                            alert("complete Other Document tab properly");
                                                            $("#tab4icon").removeClass("fs-14 fa fa-check");
                                                            return false;
                                                        }

                                                        $("#tab4icon").addClass("fs-14 fa fa-check");
                                                        $("#cancelbutton").removeClass("hidden");
                                                        $("#nextbutton").addClass("hidden");
                                                        $("#finishbutton").removeClass("hidden");

                                                        return bstatus;
                                                    }

                                                }


                                                function proceed(litabtoremove, divtabtoremove, litabtoadd, divtabtoadd)
                                                {
                                                    
                                                    $("#" + litabtoremove).removeClass("active");
                                                    $("#" + divtabtoremove).removeClass("active");

                                                    $("#" + litabtoadd).addClass("active");
                                                    $("#" + divtabtoadd).addClass("active");
                                                }

                                                /*-----managing direct click on tab is over -----*/

//manage next next and finish button


                                                

                                                function movetonext()
                                                {
                                                    console.log('movetonext');
                                                    $('#serviceError').css('display','none');
                                                    var currenttabstatus = $("li.active.tabs_active").attr('id');
                                                    if (currenttabstatus === "firstlitab")
                                                    {
                                                        profiletab('secondlitab', 'tab2');
                                                        proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');
                                                    } else if (currenttabstatus === "secondlitab")
                                                    {
                                                        addresstab('thirdlitab', 'tab3');
                                                        proceed('secondlitab', 'tab2', 'thirdlitab', 'tab3');

                                                    } else if (currenttabstatus === "thirdlitab")
                                                    {
                                                        bonafidetab('fourthlitab', 'tab4');
                                                        proceed('thirdlitab', 'tab3', 'fourthlitab', 'tab4');
                                                        console.log('here')

                                                    <?php
                                                    if ($appCofig['pricing_model']['paymentMode'] == 1) {
                                                        ?>
                                                            console.log('in tab');
                                                            $("#finishbutton").addClass("hidden");
                                                            $("#nextbutton").removeClass("hidden");
                                                    <?php
                                                } else {
                                                    ?>
                                                            console.log('in 2');
                                                            // $("#finishbutton").removeClass("hidden");
                                                            // $("#nextbutton").addClass("hidden");


                                                            $("#finishbutton").addClass("hidden");
                                                            $("#nextbutton").removeClass("hidden");

                                                        <?php
                                                    }
                                                    ?>
                                                    } else if (currenttabstatus === "fourthlitab")
                                                    {
                                                        console.log('fourth tab');
                                                        $("#tab4icon").addClass("fs-14 fa fa-check");
                                                        if(!$(".checkbox:checked").length){
                                                            $('#serviceError').css('display','block');
                                                            $("#nextbutton").removeClass("hidden");
                                                            return false;
                                                        }
                                                        else{
                                                            proceed('fourthlitab', 'tab4', 'fifthlitab', 'tab5');

                                                            $("#finishbutton").removeClass("hidden");
                                                            $("#finishbutton").css("display","block");
                                                            $("#nextbutton").addClass("hidden"); 
                                                        }
                                                        


                                                        
                                                    } 
                                                     
                                                }

                                                function movetoprevious()
                                                {
                                                    var currenttabstatus = $("li.active.tabs_active").attr('id');
                                                    $('#serviceError').css('display','none');
                                                    if (currenttabstatus === "secondlitab")
                                                    {
                                                        console.log('p1');
                                                        profiletab('secondlitab', 'tab2');
                                                        proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
                                                        $("#prevbutton").addClass("hidden");
                                                    } else if (currenttabstatus === "thirdlitab")
                                                    {
                                                        console.log('p2');
                                                        addresstab('thirdlitab', 'tab3');
                                                        proceed('thirdlitab', 'tab3', 'secondlitab', 'tab2');

                                                    } else if (currenttabstatus === "fourthlitab")
                                                    {
                                                        console.log('p3');
                                                        addresstab('fourthlitab', 'tab4');
                                                        proceed('fourthlitab', 'tab4', 'thirdlitab', 'tab3');
                                                        $("#nextbutton").removeClass("hidden");
                                                        $("#finishbutton").addClass("hidden");
                                                        $("#prevbutton").removeClass("hidden");
                                                    }
                                                    else if (currenttabstatus === "fifthlitab")
                                                    {
                                                        console.log('p5');
                                                        addresstab('fifthlitab', 'tab5');
                                                        proceed('fifthlitab', 'tab5', 'fourthlitab', 'tab4');
                                                        $("#nextbutton").removeClass("hidden");
                                                        $("#finishbutton").addClass("hidden");
                                                        $("#prevbutton").removeClass("hidden");
                                                    }

                                                }

                                                //here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

                                                function validate() {

                                                    if (!isBlank($("#Firstname").val()))
                                                    {
                                                        if (!isAlphabet($("#Firstname").val()))
                                                        {
                                                            $("#errorbox").html("Enter only character in First name");
                                                            return false;
                                                        }
                                                    } else
                                                    {
                                                        $("#errorbox").html("First name is blank");
                                                        return false;
                                                    }
                                                }
                                                function validateForm()
                                                {
                                                    if (!isBlank($("#Firstname").val()))
                                                    {
                                                        if (!isAlphabet($("#Firstname").val()))
                                                        {
                                                            $("#errorbox").html("Enter only character in First name");
                                                            return false;
                                                        }
                                                    } else
                                                    {
                                                        $("#errorbox").html("First name is blank");
                                                        return false;
                                                    }

                                                    if (!isBlank($("#Lastname").val()))
                                                    {
                                                        if (!isAlphabet($("#Lastname").val()))
                                                        {
                                                            $("#errorbox").html("Enter only character in Last name");
                                                            return false;
                                                        }
                                                    } else
                                                    {
                                                        $("#errorbox").html("Last name is blank");
                                                        return false;
                                                    }

                                                    if (validateEmail($("#Email").val()) == 1)
                                                    {

                                                        $("#errorbox").html("Enter valid email");
                                                        return false;
                                                    }

                                                    if (isBlank($("#Password").val()))
                                                    {
                                                        $("#errorbox").html("Password is Blank");
                                                        return false;
                                                    }

                                                    if (!MatchPassword($("#Password").val(), $("#Cpassword").val()))
                                                    {
                                                        $("#errorbox").html("Password not matching");
                                                        return false;
                                                    }
                                                    // return true;
                                                }

                                                function ValidateFromDb() {

                                                    $.ajax({
                                                        url: "validateEmail",
                                                        type: "POST",
                                                        data: {email: $('#email').val()},
                                                        dataType: "JSON",
                                                        success: function (result) {

                                                            $('#email').attr('data', result.msg);

                                                            if (result.msg == 1) {

                                                                $("#editerrorbox").html("Email is already allocated !");
                                                                $('#email').focus();
                                                                return false;
                                                            } else if (result.msg == 0) {
                                                                $("#editerrorbox").html("");

                                                            }
                                                        }
                                                    });

                                                }


                                                function submitform()
                                                {

                                                    $("#file_driver_license").val('');
                                                    $("#file_driver_exdate").val('');
                                                    $("#file_passbook").val('');


                                                    var uploaddrivinglicence = $("#driverLicence").val();
                                                    var expiredatelicence = $("#expirationrc").val();
                                                    var expiredatePassbook = $("#expirationPassbook").val();



                                                    if ((uploaddrivinglicence == "" || uploaddrivinglicence == null) && $('#licence_hidden').val() == '')
                                                    {
                                                        $("#file_driver_license").text(<?php echo json_encode(POPUP_DRIVER_FILE_POPUP_DRIVING); ?>);
                                                    } else if (expiredatelicence == "" || expiredatelicence == null)
                                                    {

                                                        $("#file_driver_license").text("");
                                                        $("#file_driver_exdate").text("Please select expiry date");

                                                    } else {
                                                        $('#addentity').submit();
                                                    }

                                                }

                                                function cancel() {

                                                    window.location = "<?php echo base_url(); ?>index.php?/Drivers/storeDrivers/my/1";
                                                }
</script>



<?php
$allZones_id = array();
$allSpeciality = array();
?>



<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <ul class="breadcrumb" style="margin-left: 0px;margin-top: 5%;">
        <li><a href="<?php echo base_url(); ?>index.php?/Drivers/storeDrivers/my/1" class=""><?php echo $this->lang->line('DRIVER'); ?></a>
        </li>

        <li style="width: 100px"><a href="#" class="active"><?php echo $this->lang->line('LIST_DRIVER_EDIT'); ?></a>
        </li>
    </ul>
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class=" bg-white" data-pages="parallax">
            <div class="inner">

            </div>

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                        <li class="active tabs_active" id="firstlitab" onclick="managebuttonstate()">
                            <a data-toggle="tab" href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span><?php echo $this->lang->line('LIST_DRIVER_PESIONALDETAILS'); ?></span></a>
                        </li>
                        <li class="tabs_active" id="secondlitab">
                            <a data-toggle="tab" href="#tab2" onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span><?php echo $this->lang->line('LIST_DRIVER_LOGINDETAILS'); ?></span></a>
                        </li>
                        <li class="tabs_active" id="thirdlitab">
                            <a data-toggle="tab" href="#tab3" onclick="addresstab('thirdlitab', 'tab3')"><i id="tab3icon" class=""></i> <span><?php echo $this->lang->line('LIST_DRIVER_DRIVINGLICENCE'); ?></span></a>
                        </li>
                        <li class="tabs_active" id="fourthlitab">
                            <a data-toggle="tab" href="#tab4" onclick="bonafidetab('fourthlitab', 'tab4')"><i id="tab4icon" class=""></i> <span><?php echo $this->lang->line('PREFERRED_ZONES'); ?></span></a>
                        </li>
                        <!-- <li class="tabs_active" id="fifthlitab">
                                <a data-toggle="tab" href="#tab5" onclick="bankdetailtab('fifthlitab', 'tab5')"><i id="tab5icon" class=""></i> <span><?php echo $this->lang->line('BANK_DETAILS'); ?></span></a>
                         </li>                         -->
                      


                        <?php
                      //  if ($appCofig['pricing_model']['paymentMode'] == 1) {
                            ?>
                           
                            <?php
                    //    }
                        ?>

                    </ul>
                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/Drivers/editdriverdata" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="tab-content">
                            <?php
//                           foreach($data['masterdata'] as $row) { 
                            $accType = $data['accountType'];
                            $company_id = $data['companyId']['$oid'];
                            $coutry_code = $data['countryCode'];
                            $mobile = $data["mobile"];
                            ?>

                            <script>
                                $(document).ready(function () {
                                    var accType = '<?php echo $accType; ?>';
                                    var company = '<?php echo $company_id; ?>';

                                    if (accType == 2)
                                    {

                                        $('#Operator').attr('checked', true);
                                    } else if (accType == 3)
                                    {
                                        $('#store').attr('checked', true);
                                        $('#store_select').attr('disabled', false);
//                                        $('#company_select').attr('disabled', true);
                                    } else
                                    {
                                        $('#Freelancer').attr('checked', true);
                                        $('#company_select').attr('disabled', true);
//                                        $('#store_select').attr('disabled', true);
                                    }

//                                    $('#company_select').val(company)
//                                    $('#operatorName').val('<?php echo $data['companyName'] ?>')
                                    $("#selectedOwnerType").val(accType);
                                    //                                    
                                    $("#mobile").intlTelInput("setNumber", "<?php echo $coutry_code . ' ' . $mobile ?>");
                                });
                            </script>
                            <input type="hidden" id="coutry-code" name="coutry-code" value="">
                            <input type="hidden" value="<?php echo $data['_id']['$oid']; ?>" name="driver_id"/>
                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">

<!--                                    <div class="form-group" class="formexx">
                                        <label for="address" class="col-sm-2 control-label">Driver
                                            Type<span style="" class="MandatoryMarker"> *</span>
                                        </label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-4">
                                                <input type="radio" class="radio-success" name="driverType"
                                                       id="Operator" value="2" > <label>Operator</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="radio" class="radio-success" name="driverType"
                                                       id="Freelancer" value="1"> <label>Freelancer</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="radio" class="radio-success" name="driverType"
                                                       id="store" value="3" > <label>Store</label>
                                            </div>
                                        </div>
                                        <input type="hidden" id="selectedOwnerType"
                                               name="selectedOwnerType" value="2">

                                        <div class="col-sm-3 error-box" id="companyname"></div>
                                    </div>-->



<!--                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">Operator Name <span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <select id="company_select" name="company_select"  class="form-control error-box-class" >
                                                <option value="">Select a Company</option>
                                                <?php
                                                foreach ($Operators as $each) {
                                                    echo "<option value='" . $each['_id']['$oid'] . "' operatorName= '" . $each['operatorName'] . "'>" . $each['operatorName'] . ' - ' . $each['email'] . ' - ' . $each['mobile'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden"  id="operatorName" name="operatorName" required="required"class="form-control" value="">
                                        </div>
                                        <div class="col-sm-3 error-box" id="ve_compan"></div>

                                    </div>-->
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Store_Name'); ?><span style="" class="MandatoryMarker"> *</span>
                                        </label>
                                        <div class="col-sm-6">
<!--                                            <select  id="store_select" name="store_select"
                                                    class="form-control error-box-class">
                                                <option value="">Select a Store</option>
                                                <?php
//                                                foreach ($store as $each) {
//                                                    if ($each['_id']['$oid'] == $data['storeId']['$oid']) {
//                                                        echo "<option  selected='selected' value='" . $each['_id']['$oid'] . "' storeName= '" . $each['name'][0] . "'>" . $each['name'][0] . ' - ' . $each['cityName'] . "</option>";
//                                                    } else {
//                                                        echo "<option value='" . $each['_id']['$oid'] . "' storeName= '" . $each['name'][0] . "'>" . $each['name'][0] . ' - ' . $each['cityName'] . "</option>";
//                                                    }
//                                                }
                                                ?>
                                            </select> -->
                                            <input  disabled="disabled"type="text" id="store" name="" class="form-control" value="<?php echo $data['storeName'];?>" required="required" class="form-control">
                                            <input type="hidden" id="storeName" name="storeName" value="<?php echo $data['storeName'];?>" required="required" class="form-control">
                                        </div>
                                        <div class="col-sm-3 error-box" id="ve_store"></div>

                                    </div>

                                     <input type="hidden"  id="editstoreId" name="storeId" class="form-control" value="<?php echo $storeId; ?>"/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_FIRSTNAME'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="text"  id="firstname" name="firstname" required="required"class="form-control" value="<?php echo $data['firstName']; ?>"/>

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_firstname"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_LASTNAME'); ?></label>
                                        <div class="col-sm-6">

                                            <input type="text" id="lastname" name="lastname" required="required"class="form-control" value="<?php echo $data['lastName']; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_lastnmae"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Date_of_Birth'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="text"  id="dob" name="dob" required="required" class="form-control datepicker-component1" onfocus="this.removeAttribute('readonly');" value="<?php echo $data['dob']; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="dobErr"></div>
                                    </div>

<!--                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">Membership Renewal Date<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <?php
                                            if (isset($data['memberRenewalDate']) && $data['memberRenewalDate'] != '')
                                                $memberRenewalDate = date('Y-m-d', $data['memberRenewalDate']);
                                            else
                                                $memberRenewalDate = '';
                                            ?>

                                            <input type="text"  id="memberRenewalDate" name="memberRenewalDate" required="required" onfocus="this.removeAttribute('readonly');" readonly class="form-control datepicker-component" value="<?php echo $memberRenewalDate; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="memberRenewalDateErr"></div>
                                    </div>-->
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_UPLOADPHOTO'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">
                                            <!--                <input type="text" class="form-control" name="entitydocname" id="entitydocname">-->
                                            <input type="file" class="form-control" style="height: 37px;" name="photos" id="file_upload" >
                                            <input type="hidden" class="form-control" style="height: 37px;" name="driverImage" id="driverImage" value="<?php echo $data['profilePic']; ?>">
                                            <input type="hidden" value="<?php echo $data['profilePic']; ?>" id='viewimage_hidden'/>



                                        </div>

                                        <div class="col-sm-1">

                                            <img src="<?php echo $data['profilePic']; ?>" style="width: 35px;height:35px;" class="driverImage style_prevu_kit">

                                        </div>
                                        <div class="col-sm-3 error-box" id="file_driver_photo"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane slide-left padding-20" id="tab2">
                                <div class="row row-same-height">

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_EMAIL'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="email" data="1" id="email" name="email" required="required" onblur="ValidateFromDb()" class="form-control" value="<?php echo $data['email']; ?>" disabled="disabled">


                                        </div>
                                        <span id="editerrorbox" class="col-sm-3 control-label" style="color: #ff0000"></span>
                                        <div class="col-sm-3 error-box" id="text_email"></div>
                                    </div>




                                    <div class="form-group" style="display: none;">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_PASSWORD'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="password"  id="password" name="password" required="required" class="form-control" value="<?php echo $data['password']; ?>" disabled>

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_password"></div>
                                    </div>


                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_MOBILE'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="text"  id="mobile" name="mobile"  required="required" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $data['mobile']; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="driver_mobile"></div>
                                    </div>

                                    <div class="form-group">

                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo 'Order Fulfillment Type'; ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="radio" class="orderFulfillmentType error-box-class" name="orderFulfillmentType" id="onDemand" value="0"  <?php echo ($data['orderFullfillmentType'] == 0) ? "CHECKED" : " " ?>  >&nbsp;&nbsp;<label for="onDemand"><?php echo 'On - Demand'; ?></label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" class="orderFulfillmentType error-box-class" name="orderFulfillmentType" id="slots" value="1"  <?php echo ($data['orderFullfillmentType'] == 1) ? "CHECKED" : " " ?> >&nbsp;&nbsp;<label for="slots"><?php echo 'Slots'; ?></label>
                                        </div>
                                        <div class="col-sm-2 error-box" id="text_pricing" style="color:red"></div>
                                    </div>


                                </div>
                            </div>

                            <div class="tab-pane slide-left padding-20" id="tab3">
                                <div class="row row-same-height">
                                    <div class="form-group">

                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Driving_Licence_Front'); ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-5">
                                            <!-- <input type="file" class="form-control" style="height: 37px;" name="certificate" id="file_upload_l">
                                            <input type="hidden" class="form-control" style="height: 37px;" name="driverLicence" id="driverLicence"> 
                                            <input type="hidden" value="<?php echo $data['driverLicense']; ?>" id='licence_hidden'/> -->


                                            <!-- cool front -->
                                              <input type="file" class="form-control" style="height: 37px;" name="driverLicenceFront" id="file_upload_l">
                                               <input type="hidden"  class="form-control" style="height: 37px;"  name="driverLicence" id="driverLicence" value="<?php echo $data['driverLicenseFront']; ?>">


                                        </div>

                                        <div class="col-sm-1">
                                            <img src="<?php echo $data['driverLicenseFront']; ?>" style="width: 35px;height:35px;" class="driverLicence style_prevu_kit">
                                        </div>
                                        <div class="col-sm-3 error-box" id="file_driver_license"></div>
                                    </div>
                                    <div class="form-group">

                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Driving_Licence_Back'); ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-5">
                                            <!-- <input type="file" class="form-control" style="height: 37px;" name="certificate" id="file_upload_l1">
                                            <input type="hidden" class="form-control" style="height: 37px;" name="driverLicence" id="driverLicence1"> 
                                            <input type="hidden" value="<?php echo $data['driverLicense']; ?>" id='licence_hidden1'/> -->

                                            <!-- cool back -->
                                            <input type="file" class="form-control" style="height: 37px;"name="driverLicenceBack1" id="driverBack">
                                             <input type="hidden" class="form-control" style="height: 37px;" name="driverLicenceBack" id="driverLicenceBack" value="<?php echo $data['driverLicenseBack']; ?>">


                                        </div>

                                        <div class="col-sm-1">
                                            <img src="<?php echo $data['driverLicenseBack']; ?>" style="width: 35px;height:35px;" class="driverLicenceBack style_prevu_kit">
                                        </div>
                                        <div class="col-sm-3 error-box" id="file_driver_license"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_EXDATE'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">
                                            <input id="expirationrc" name="expirationrc" required="required"  type="" class="form-control datepicker-component"
                                                   value="<?php echo $data['driverLicenseExp']; ?>" autocomplete="off">
                                        </div>
                                        <div class="col-sm-3 error-box" id="file_driver_exdate"></div>
                                    </div>


                                </div>
                            </div>

                            <div class="tab-pane slide-left padding-20" id="tab4">
                                <div class="row row-same-height">
                                <div class="" id="serviceZonesdel"></div>
                                    
                                    <?php
                                    foreach ($cityForZonesData as $key => $value) {
                                        $checked = '';
                                        if (in_array($key, $data['serviceZones']))
                                            $checked = 'checked';
                                        ?>

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-2 control-label"><?php echo $value ?><span style="color:red;" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input id="" name="checkboxs[]" value="<?php echo $key ?>" required="required"  type="checkbox" class="checkbox" <?php echo $checked; ?>>
                                                <p style="display:none; color:red;" id="serviceError">Please select the zone</p>
                                            </div>
                                            <div class="col-sm-3 error-box" id="file_driver_exdate"></div>
                                        </div>
                                        <?php
                                    }
                                    ?>


                                </div>
                            </div>


                            <div class="tab-pane slide-left padding-20" id="tab5">
                                <div class="row row-same-height">

                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-3">
                                            <div class="panel panel-default">

                                                <div class="panel-body stripeCreateFormDiv">
                                                    <div class="errors"></div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Country</label>
                                                                <select class="form-control" id="country" data-stripe="country">
                                                                    <option value="US">United States</option>
                                                                    <option value="AU">Australia</option>
                                                                    <option value="AT">Austria</option>
                                                                    <option value="BE">Belgium</option>
                                                                    <option value="BR">Brazil</option>
                                                                    <option value="CA">Canada</option>
                                                                    <option value="DK">Denmark</option>
                                                                    <option value="FI">Finland</option>
                                                                    <option value="FR">France</option>
                                                                    <option value="DE">Germany</option>
                                                                    <option value="HK">Hong Kong</option>
                                                                    <option value="IE">Ireland</option>
                                                                    <option value="IT">Italy</option>
                                                                    <option value="JP">Japan</option>
                                                                    <option value="LU">Luxembourg</option>
                                                                    <option value="MX">Mexico</option>
                                                                    <option value="NZ">New Zealand</option>
                                                                    <option value="NL">Netherlands</option>
                                                                    <option value="NO">Norway</option>
                                                                    <option value="PT">Portugal</option>
                                                                    <option value="SG">Singapore</option>
                                                                    <option value="ES">Spain</option>
                                                                    <option value="SE">Sweden</option>
                                                                    <option value="CH">Switzerland</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('Personal_ID_Number'); ?> </label>
                                                                <input class="form-control"   id="presnalid" placeholder="Personal Id Number" autocomplete="off" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('FIELD_DRIVERS_FIRSTNAME'); ?></label>
                                                                <input class="form-control account_holder_fname" id="account_holder_fname" type="text" data-stripe="account_holder_fname" placeholder="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('FIELD_DRIVERS_LASTNAME'); ?></label>
                                                                <input class="form-control account_holder_lname" id="account_holder_lname" type="text" data-stripe="account_holder_lname" placeholder="" autocomplete="off">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6" id="routing_number_div">
                                                            <div class="form-group">
                                                                <label id="routing_number_label"><?php echo $this->lang->line('Routing_Number'); ?></label>
                                                                <input class="form-control  bank_account" id="routing_number" type="tel" size="12" data-stripe="routing_number" placeholder="110000000" autocomplete="off" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label id="account_number_label"><?php echo $this->lang->line('Account_Number'); ?></label>
                                                                <input class="form-control bank_account" id="account_number" type="tel" size="20" data-stripe="account_number" placeholder="000123456789" autocomplete="off" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div id="nextscreenHtmlNextScreen">
                                                        <div class="row">

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label id="account_number_label"><?php echo $this->lang->line('Address'); ?> </label>
                                                                    <input class="form-control" id="Address" placeholder="Address" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label> <?php echo $this->lang->line('City'); ?> </label>
                                                                    <input class="form-control" id="cityname"  placeholder="City Name" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line('Postal_Code'); ?> </label>
                                                                    <input class="form-control"   id="postalcode" placeholder="Postal Code" autocomplete="off" onkeypress="return isNumberKey(event)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label id="account_number_label"><?php echo $this->lang->line('State'); ?></label>
                                                                    <input class="form-control" placeholder="State" id="state" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fname"><?php echo $this->lang->line('ID_PROOF'); ?></label>
                                                                    <input type="file" class="form-control" style="height: 37px;" id="id_proof" data="id_proof">
                                                                    <input type="hidden" id="idproof">
                                                                    <div class="col-sm-3 error-box" id="id_proofErr"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label> <?php echo $this->lang->line('DOB'); ?> </label>
                                                                    <input type="text" class="form-control datepicker-component1" id="DateOfB">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <button style="width:176px;" class="btn btn-sm btn-block btn-success " type="button" id="addBankAcc"><?php echo $this->lang->line('CREATE_STRIPE_ACCOUNT'); ?></button>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <span class="stripeResponse" style="font-weight:600;font-size: 11px;"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row createBankAccountDivButton" style="display:none;">
                                                    <br>
                                                    <div class="row">
                                                        <span class="" style="font-weight:600;font-size: 11px;color:green;padding-left: 24px;"><?php echo $this->lang->line('stript_bank_acc'); ?></span>
                                                    </div>
                                                    <br>
                                                    <div class="col-md-6">

                                                    </div>
                                                    <div class="col-md-6">
                                                        <button style="width:164px;" class="btn btn-sm btn-block btn-success"  type="button" id="createBankAccount"><?php echo $this->lang->line('ADD_BANK_ACCOUNT'); ?></button>
                                                    </div>
                                                </div>
                                                <div class="loader"></div>
                                                <div class="panel-body addBankFormDiv" style="display: none;">
                                                    <div class="errors"></div>
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-md-3">Country<span style="" class="MandatoryMarker"> *</span></label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control" id="bankCountryRead" data-stripe="country" disabled="">
                                                                <option value="US">United States</option>
                                                                <option value="AU">Australia</option>
                                                                <option value="AT">Austria</option>
                                                                <option value="BE">Belgium</option>
                                                                <option value="BR">Brazil</option>
                                                                <option value="CA">Canada</option>
                                                                <option value="DK">Denmark</option>
                                                                <option value="FI">Finland</option>
                                                                <option value="FR">France</option>
                                                                <option value="DE">Germany</option>
                                                                <option value="HK">Hong Kong</option>
                                                                <option value="IE">Ireland</option>
                                                                <option value="IT">Italy</option>
                                                                <option value="JP">Japan</option>
                                                                <option value="LU">Luxembourg</option>
                                                                <option value="MX">Mexico</option>
                                                                <option value="NZ">New Zealand</option>
                                                                <option value="NL">Netherlands</option>
                                                                <option value="NO">Norway</option>
                                                                <option value="PT">Portugal</option>
                                                                <option value="SG">Singapore</option>
                                                                <option value="ES">Spain</option>
                                                                <option value="SE">Sweden</option>
                                                                <option value="CH">Switzerland</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Account_Number'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control number" id="bankAccountNumberRead" name="bankAccountNumberRead" placeholder="" onkeypress="return isNumberKey(event)" readonly="">
                                                        </div>
                                                        <div class="col-sm-3 errors bankAccountNumberErr"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Account_Holder_Name'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="bankAccountHolderNameRead" name="bankAccountHolderNameRead" placeholder="" readonly="">
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-md-3">Routing Number<?php echo $this->lang->line('Routing_Number'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control number" id="bankRoutingNumberRead" name="bankRoutingNumberRead" placeholder="" onkeypress="return isNumberKey(event)" readonly="">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <div class="padding-20 bg-white col-sm-9">
                                <ul class="pager wizard">
                                    <li class="next" id="nextbutton">
                                        <button class="btn btn-info pull-right" type="button" onclick="movetonext()">
                                            <span><?php echo $this->lang->line('Next'); ?></span>
                                        </button>
                                    </li>
                                    <li class="hidden" id="finishbutton">
                                        <button class="btn btn-success pull-right" type="button" onclick="submitform()">
                                            <span><?php echo $this->lang->line('Finish'); ?></span>
                                        </button>
                                    </li>

                                    <li class="previous hidden" id="prevbutton">
                                        <button class="btn btn-default pull-right" type="button" onclick="movetoprevious()">
                                            <span><?php echo $this->lang->line('Previous'); ?></span>
                                        </button>
                                    </li>
                                    <li class="" id="cancelbutton">

                                        <button  type="button" class="btn btn-default pull-right" onclick = "cancel()" ><?php echo $this->lang->line('Cancel'); ?></button>
                                    </li>
                                </ul>
                            </div>

                        </div>

                    </form>

                </div>


            </div>
            <!-- END PANEL -->
        </div>

    </div>
    <!-- END JUMBOTRON -->

    <!-- START CONTAINER FLUID -->
    <div class="container-fluid container-fixed-lg">
        <!-- BEGIN PlACE PAGE CONTENT HERE -->

        <!-- END PLACE PAGE CONTENT HERE -->
    </div>
    <!-- END CONTAINER FLUID -->

</div>
<!-- END PAGE CONTENT -->
<!-- START FOOTER -->

<!-- END FOOTER -->

<div class="modal fade" id="createBankAccountPopUp1" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;"><?php echo $this->lang->line('ADD'); ?></strong>
            </div>
            <div class="modal-body">
                <form  data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="form-group">
                        <label for="" class="control-label col-md-3">Country<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <select class="form-control" id="bankCountry" data-stripe="country">
                                <option value="US">United States</option>
                                <option value="AU">Australia</option>
                                <option value="AT">Austria</option>
                                <option value="BE">Belgium</option>
                                <option value="BR">Brazil</option>
                                <option value="CA">Canada</option>
                                <option value="DK">Denmark</option>
                                <option value="FI">Finland</option>
                                <option value="FR">France</option>
                                <option value="DE">Germany</option>
                                <option value="HK">Hong Kong</option>
                                <option value="IE">Ireland</option>
                                <option value="IT">Italy</option>
                                <option value="JP">Japan</option>
                                <option value="LU">Luxembourg</option>
                                <option value="MX">Mexico</option>
                                <option value="NZ">New Zealand</option>
                                <option value="NL">Netherlands</option>
                                <option value="NO">Norway</option>
                                <option value="PT">Portugal</option>
                                <option value="SG">Singapore</option>
                                <option value="ES">Spain</option>
                                <option value="SE">Sweden</option>
                                <option value="CH">Switzerland</option>
                            </select>
                        </div>
                        <div class="col-sm-3 errors bankAccountNumberErr"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Account_Number'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control number" id="bankAccountNumber" name="bankAccountNumber" placeholder="" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="col-sm-3 errors bankAccountNumberErr"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Account_Holder_Name'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="bankAccountHolderName" name="bankAccountHolderName" placeholder="">
                        </div>
                        <div class="col-sm-3 errors bankAccountHolderNameErr"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Routing_Number'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control number" id="bankRoutingNumber" name="bankRoutingNumber" placeholder="" onkeypress="return isNumberKey(event)" >
                        </div>
                        <div class="col-sm-3 errors bankRoutingNumberErr"></div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Cancel'); ?></button>
                <button type="button" class="btn btn-success pull-right" id="addBankAccount" ><?php echo $this->lang->line('Submit'); ?></button>
            </div>
        </div>

    </div>
</div>

<script src="<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/intlTelInput.js"></script>
<script src="<?php echo ServiceLink; ?>theme/assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE&sensor=false&libraries=places"></script>

<script>

                                var autocomplete = new google.maps.places.Autocomplete($("#Address")[0], {});

                                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                                    var place = autocomplete.getPlace();

                                    var address = document.getElementById('Address').value;
                                    console.log(address);

                                    $.ajax({
                                        url: "https://maps.googleapis.com/maps/api/geocode/json?address=" + address + "&sensor=false",
                                        type: "POST",
                                        success: function (res) {

                                            address = res.results[0].geometry.location.lat + ',' + res.results[0].geometry.location.lng;
                                            geocoder = new google.maps.Geocoder();

                                            geocoder.geocode({'address': address}, function (results, status) {
                                                if (status == google.maps.GeocoderStatus.OK) {

                                                    for (var component in results[0]['address_components']) {

                                                        for (var i in results[0]['address_components'][component]['types']) {
                                                            if (results[0]['address_components'][component]['types'][i] == "locality") {
                                                                city = results[0]['address_components'][component]['long_name'];
                                                                //                                            
                                                                $("#cityname").val(city);

                                                            }

                                                            if (results[0]['address_components'][component]['types'][i] == "administrative_area_level_1") {
                                                                state = results[0]['address_components'][component]['long_name'];

                                                                $('#state').val(state);
                                                            }

                                                            if (results[0]['address_components'][component]['types'][i] == "postal_code") {
                                                                pcode = results[0]['address_components'][component]['long_name'];

                                                                $('#postalcode').val(pcode);

                                                            }
                                                        }
                                                    }
                                                } else {
                                                    alert('Invalid Zipcode');
                                                }
                                            });

                                        }

                                    });

                                });
                                var countryData = $.fn.intlTelInput.getCountryData();
                                $.each(countryData, function (i, country) {

                                    country.name = country.name.replace(/.+\((.+)\)/, "$1");
                                });
                                $("#mobile").intlTelInput({
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
//                         $(document).ready(function () {
//                         $('#store_select').change(function ()
//                {
//                    $('#storeName').val($('#store_select option:selected').attr('storeName'));
//                });
//
//                if ($('#Operator').prop('checked', true)) {
//                    $('#store_select').prop('disabled', true);
//                    $('#store_select').val('');
//                }
//            });

</script>

