
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

    //aplhanumeric
     function isAlphaNumericKey(evt)
    {
        var code, i, len;

        for (i = 0, len = evt.length; i < len; i++) {
            code = evt.charCodeAt(i);
            if (!(code > 47 && code < 58) && // numeric (0-9)
                !(code > 64 && code < 91) && // upper alpha (A-Z)
                !(code > 96 && code < 123)) { // lower alpha (a-z)
            return false;
            }
        }
        return true;
    }

    $(document).ready(function () {
        $.getJSON("https://jsonip.com/?callback=?", function (data) {
            myIP = data.ip;
        });
    });


    //Check if the stripe has verified the account or/and added bank account
    $.ajax({
        url: '<?php echo APILink; ?>admin/connectAccount/<?php echo $driverid; ?>',
                type: "GET",
                dataType: "JSON",
                headers: {
                   
                   authorization: "<?php echo $this->session->userdata['godsviewToken']; ?>",
                    language:"en"
                                },
                success: function (result,textStatus,xhr) {
                  
                    
                    $('.createBankAccountDivButton').hide();
                    $('.stripeResponse').text('');
                    if (xhr.status==200)
                    {       
                  
                        if (result.data.legal_entity.verification.status =="verified")
                        {
                  
                            if (result.data.external_accounts.data.length > 0)
                            {
                  
                                $('.createBankAccountDivButton').hide();
                                $.each(result.data.external_accounts.data, function (index, value)
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
                },
                error:function(xhr, status, error){
                    $(".createBankAccountDivButton").hide();
                   $(".addBankFormDiv").hide();

                }
            });

var zoneIds ;
            $(document).ready(function () {

    
    // delivery Type msg
        var deliveryType='<?php echo $data['deliveryType'];?>';
        var deliveryTypeMsg='<?php echo $data['deliveryTypeMsg'];?>';     
        $('#deliveryType').val(deliveryType);
        $('#deliveryTypeMsg').val(deliveryTypeMsg);



				var cityId = "<?php echo $data['cityId'];?>";
			     zoneIds = <?php echo json_encode($data['serviceZones'])?>;
				 
				 $.ajax({
                url: "<?php echo base_url(); ?>index.php?/superadmin/cityForZonesData",
                type: "POST",
                data: {cityId: cityId},
                dataType: "JSON",
                async: false,
                success: function (result) {

                    if (result) {
                   
				   $('#serviceZones').empty();
				   var html = '';
				  
                        $.each(result.data, function (index, row) {
							
							if(jQuery.inArray(index, zoneIds) !== -1){
                            var html = '<div class="form-group">'
                                    + '<label for="fname" class="col-sm-2 control-label">' + row + '</label>'
                                    + '<div class="col-sm-6">'
                                    +'<input checked name="checkboxs[]" value="' + index + '"required="required" type="checkbox" class="checkbox"> </div>'
                                    +'<div class="col-sm-3 error-box" id="file_driver_exdate"></div></div>';
							}else{
								
								
								var html = '<div class="form-group">'
                                    + '<label for="fname" class="col-sm-2 control-label">' + row + '</label>'
                                    + '<div class="col-sm-6">'
                                    +'<input  name="checkboxs[]" value="' + index + '"required="required" type="checkbox" class="checkbox"> </div>'
                                    +'<div class="col-sm-3 error-box" id="file_driver_exdate"></div></div>';
							}
                               $('#serviceZones').append(html);  
														   
                        });
 
                    } 
                }
            });


                $('.tabs_active').click(function () {

                    var pstatus = true;
                    if ($(this).attr('id') == 'fifthlitab')
                    {
                        console.log('clciked');
                        //$("#finishbutton").removeClass("hidden");
                        $("#finishbutton").hide();
                        $("#prevbutton").hide();
                        $("#nextbutton").addClass("hidden");
                        

                    } else
                    {
                        $("#finishbutton").addClass("hidden");
                        $("#nextbutton").removeClass("hidden");

                        if ($(this).attr('id') == 'fourthlitab')
                        {
                <?php
                if ($appCofig['pricing_model']['paymentMode'] == 1) {
                    ?>

                                $("#finishbutton").addClass("hidden");
                                $("#nextbutton").removeClass("hidden");
            <?php
        } else {
            ?>

                                $("#finishbutton").removeClass("hidden");
                                $("#nextbutton").addClass("hidden");


                <?php
            }
            ?>
                        }

                    }

                });
//               



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
//                $('#storeName').val("<?php echo $data['storeName'];?>"); 

//                $('#store_select').change(function ()
//                {
//                    $('#storeName').val($('#store_select option:selected').attr('storeName'));
//                });
                $('#addBankAcc').click(function () {
                    console.log('addbank');

                    $('.stripeResponse').text('');
                    if ($('#presnalid').val() == "") {
                        alert('Personal Id is missing.');
                    } else if ($('#presnalid').val().length != 9) {
                        alert('Personal Id should have 9 digit long');
                    } else if ($('#account_holder_fname').val() == "") {
                        alert('First name is missing.');
                    } else if ($('#account_holder_lname').val() == "") {
                        alert('Last name is missing.');
                    } 
                    // else if ($('#routing_number').val() == "") {
                    //     alert('Routing number is missing.');
                    // } else if ($('#routing_number').val().length != 9) {
                    //     alert('Routing number should have 9 digit long');
                    // } else if ($('#account_number').val() == "") {
                    //     alert('Accounting number is missing.');
                    // } else if ($('#account_number').val().length != 12) {
                    //     alert('Accounting number have 12 digit long');
                    // }
                     else if ($('#Address').val() == "") {
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
                        var email=$("#email").val();
                        $.ajax({
                            url: '<?php echo APILink; ?>admin/connectAccount',
                            type: "POST",
                            data: {userId: "<?php echo $driverid; ?>", city: $('#cityname').val(), country: $('#country').val(), line1: $('#Address').val(), postal_code: $('#postalcode').val(), state: $('#state').val(), day: dob[1], month: dob[0], year: dob[2], first_name: $('#account_holder_fname').val(), last_name: $('#account_holder_lname').val(), document: $('#idproof').val(), personal_id_number: $('#presnalid').val(), date: $("#DateOfB").val(), ip: myIP,email:email},
                            headers: {
                             
                              authorization: "<?php echo $this->session->userdata['godsviewToken']; ?>",
                                language:"en"
                                },
                            dataType: "JSON",
                            beforeSend: function (xhr) {
                                $("#addBankAcc").prop("disabled",true)
                                $("#loadingimg").css("display","block");
                            },
                            complete: function () {
                                $("#addBankAcc").prop("disabled",false)
                                $("#loadingimg").css("display","none");
                            },
                            success: function (result,textStatus, xhr) {
                                console.log('----------',result)

                                if (xhr.status==200)
                                {
                                   
                                        console.log('Success');                                        
                                        window.location.href = "<?php echo base_url()?>index.php?/superadmin/Drivers/my/1";
                                    // $('.stripeResponse').css({'color': 'green'});
                                    // $('.stripeResponse').text('Stripe account is created succefully.Will be activated soon...!');

//                                     setTimeout(function () {
//                                         //Check if the stripe has verified the account or not
//                                         $.ajax({
//                                             url: '<?php echo APILink; ?>admin/stripe/<?php echo $driverid; ?>',
//                                                                                 type: "GET",
//                                                                                 dataType: "JSON",
//                                                                                 complete: function () {
//                                                                                     $(".loader").fadeOut("slow");
//                                                                                 },
//                                                                                 success: function (result) {
// //                                                                             $('.stripeResponse').text('');

//                                                                                     $('.stripeCreateFormDiv').hide();
//                                                                                     if (result.legal_entity.verification.status == "verified")
//                                                                                     {

//                                                                                         $('.stripeResponse').css({'color': 'green'});
//                                                                                         $('.stripeResponse').text('Stripe account is verified.Please add bank details');
//                                                                                         $('.createBankAccountDivButton').show();

//                                                                                     } else {

//                                                                                         $('.createBankAccountDivButton').hide();
//                                                                                         $('.stripeResponse').css({'color': 'red'});
//                                                                                         $('.stripeResponse').text('Stripe account is not verified yet.');
//                                                                                     }
//                                                                                 }
//                                                                             });

//                                                                         }, 2000);


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

                                    //Get the currency
                                 /*   $('#bankCountry1').change(function () {
                                        console.log('currency');
                                            $('#bankCurrency').empty();
                                            $.ajax({
                                                url: '<?php echo APILink; ?>connectAccountCurrency/' + $('#bankCountry1').val(),
                                                type: "GET",
                                                dataType: "JSON",
                                            
                                                beforeSend: function (xhr) {
                                                    xhr.setRequestHeader("authorization", '<?php echo $this->session->userdata['godsviewToken']; ?>');
                                                    xhr.setRequestHeader("language", 'en');

                                                },
                                                success: function (result) {
                                                    var html = '';
                                                    if (result.data.currency) {
                                                        $.each(result.data.currency, function (index, response) {
                                                            html += "<option value=" + response + ">" + response + "</option>";
                                                        });

                                                        $('#bankCurrency').append(html);
                                                        $('#bankCurrency').val(result.data.default_currency);
                                                    }

                                                }, error: function (xhr, status, err) {
                                                    alert("error...! " + $.parseJSON(xhr.responseText).message);
                                                },
                                            });
                                        })*/

                                                    $('#addBankAccount').click(function ()
                                                    {
                                                       
															if ($('#bankAccountHolderName').val() == '')
                                                            alert('Please enter bank account holder name');
                                                        
                                                        else {
                                                            //Add bank account information
                                                            var email=$("#email").val();
                                                            $.ajax({
                                                                url: '<?php echo APILink; ?>admin/externalAccount',
                                                                type: "POST",
                                                                data: {userId:  "<?php echo $driverid; ?>",account_number: $('#bankAccountNumber').val(),routing_number: $('#bankRoutingNumber').val(), account_holder_name: $('#bankAccountHolderName').val(), country: $('#bankCountry1').val(),email:email,currency: "<?php echo $data['currency']; ?>"},
                                                                headers: {                                                                
                                                                  authorization: "<?php echo $this->session->userdata['godsviewToken']; ?>",
                                                                    language:"en"
                                                                    },
                                                                dataType: "JSON",
                                                                beforeSend: function (xhr) {
                                                                    $("#addBankAccount").prop("disabled",true)
                                                                    $("#loadingimg1").css("display","block");
                                                                },
                                                                complete: function () {
                                                                    $("#addBankAccount").prop("disabled",false)
                                                                    $("#loadingimg1").css("display","none");
                                                                },
                                                                success: function (result,textStatus,xhr) {
                                                                    $('.stripeResponse').text('');
                                                                    if (xhr.status == 200) {
                                                                        window.location.href = "<?php echo base_url()?>index.php?/superadmin/editdriver/<?php echo $driverid; ?>";
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

                                                                },
                                                                error: function (jqXHR, textStatus, errorThrown) {
                                                                    console.log("jqXHR",(jqXHR))
                                                                    if (jqXHR.status == 500) {
                                                                        alert('Internal error: ' + jqXHR.responseText);
                                                                    } else {
                                                                        alert('Unexpected error.');
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
                                                    // changed 31-12
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
                                                        $('#getvechiletype').load('<?php echo base_url() ?>index.php?/superadmin/ajax_call_to_get_types/vtype', {city: $('#city_select').val()});
                                                    });


                                                    $('#title').change(function () {
                                                        $('#vehiclemodel').load('<?php echo base_url() ?>index.php?/superadmin/ajax_call_to_get_types/vmodel', {adv: $('#title').val()});
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
                                                        url: "<?php echo base_url(); ?>index.php?/superadmin/validateEmail",
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
                                                        url: "<?php echo base_url(); ?>index.php?/superadmin/validateMobileNoEditDriver",
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
//                                                    var store_select = $("#store_select").val();


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
//                                                        if (store_select == "" && selectedOwnerType == 3)
//                                                    {
//                                                        $("#ve_store").text('Please choose an store');
//                                                        pstatus = false;
//                                                    } else 
                                                        if (firstname == "")
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
                                                    //changes made here to view finish button
                                                    $('#prevbutton').show();
                                                    $('#finishbutton').show();
                                                    var bstatus = true;
                                                    if (addresstab(litabtoremove, divtabtoremove))
                                                    {
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

                                                            $("#finishbutton").addClass("hidden");
                                                            $("#nextbutton").removeClass("hidden");
    <?php
} else {
    ?>

                                                            $("#finishbutton").removeClass("hidden");
                                                            $("#nextbutton").addClass("hidden");


    <?php
}
?>
                                                        $("#finishbutton").addClass("hidden");
                                                        $("#nextbutton").removeClass("hidden");

                                                        $("#cancelbutton").removeClass("hidden");
                                                        return bstatus;

                                                    }
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
                                                    var currenttabstatus = $("li.active").attr('id');
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
                                                            $("#finishbutton").addClass("hidden");
                                                            $("#nextbutton").removeClass("hidden");
    <?php
} else {
    ?>
                                                            $("#finishbutton").removeClass("hidden");
                                                            $("#nextbutton").addClass("hidden");

    <?php
}
?>
                                                    } else if (currenttabstatus === "fourthlitab")
                                                    {
                                                        $("#tab4icon").addClass("fs-14 fa fa-check");
                                                        proceed('fourthlitab', 'tab4', 'fifthlitab', 'tab5');

                                                        $("#finishbutton").removeClass("hidden");
                                                        $("#nextbutton").addClass("hidden");
                                                    }
                                                }

                                                function movetoprevious()
                                                {
                                                    var currenttabstatus = $("li.active").attr('id');
                                                    if (currenttabstatus === "secondlitab")
                                                    {
                                                        profiletab('secondlitab', 'tab2');
                                                        proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
                                                        $("#prevbutton").addClass("hidden");
                                                    } else if (currenttabstatus === "thirdlitab")
                                                    {
                                                        addresstab('thirdlitab', 'tab3');
                                                        proceed('thirdlitab', 'tab3', 'secondlitab', 'tab2');

                                                    } else if (currenttabstatus === "fourthlitab")
                                                    {
                                                        addresstab('fourthlitab', 'tab4');
                                                        proceed('fourthlitab', 'tab4', 'thirdlitab', 'tab3');
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

                                                    window.location = "<?php echo base_url(); ?>index.php?/superadmin/Drivers/my/1";
                                                }
        
        $("#boxtype").click(function(){
            var id=$('#boxtype option:selected').attr('boxid');
            $('#packageBoxTypeId').val(id);

        });

        $("#deliveryType").click(function(){
           var id=$('#deliveryType option:selected').attr('data-name');
           $('#deliveryTypeMsg').val(id);
           
        });

       

</script>



<?php
$allZones_id = array();
$allSpeciality = array();
?>



<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <ul class="breadcrumb" style="margin-left: 0px;margin-top: 5%;">
        <li><a href="<?php echo base_url(); ?>index.php?/superadmin/Drivers/my/1" class=""><?php echo LIST_DRIVER; ?></a>
        </li>

        <li style="width: 100px"><a href="#" class="active"><?php echo LIST_DRIVER_EDIT; ?></a>
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
                            <a data-toggle="tab" href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span><?php echo LIST_DRIVER_PESIONALDETAILS; ?></span></a>
                        </li>
                        <li class="tabs_active" id="secondlitab">
                            <a data-toggle="tab" href="#tab2" onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span><?php echo LIST_DRIVER_LOGINDETAILS; ?></span></a>
                        </li>
                        <li class="tabs_active" id="thirdlitab">
                            <a data-toggle="tab" href="#tab3" onclick="addresstab('thirdlitab', 'tab3')"><i id="tab3icon" class=""></i> <span><?php echo LIST_DRIVER_DRIVINGLICENCE; ?></span></a>
                        </li>
                        <li class="tabs_active" id="fourthlitab">
                            <a data-toggle="tab" href="#tab4" onclick="bonafidetab('fourthlitab', 'tab4')"><i id="tab4icon" class=""></i> <span>PREFERRED ZONES</span></a>
                        </li>

                        <?php
                      //  if ($appCofig['pricing_model']['paymentMode'] == 1) {
                            ?>
                            <!-- <li class="tabs_active" id="fifthlitab">
                                <a data-toggle="tab" href="#tab5" onclick="fifthTab('fourthlitab', 'tab5')"><i id="tab5icon" class=""></i> <span>BANK DETAILS</span></a>
                            </li> -->
                            <?php
                    //    }
                        ?>

                    </ul>
                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/superadmin/editdriverdata" method="post" enctype="multipart/form-data" autocomplete="off">
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
<!--                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">Store
                                            Name<span style="" class="MandatoryMarker"> *</span>
                                        </label>
                                        <div class="col-sm-6">
                                            <select id="store_select" name="store_select"
                                                    class="form-control error-box-class">
                                                <option value="">Select a Store</option>
                                                <?php
//                                                foreach ($store as $each) {
//                                                    if ($each['_id']['$oid'] == $data['storeId']['$oid']) {
//                                                        echo "<option selected='selected' value='" . $each['_id']['$oid'] . "' storeName= '" . $each['name'][0] . "'>" . $each['name'][0] . ' - ' . $each['cityName'] . "</option>";
//                                                    } else {
//                                                        echo "<option value='" . $each['_id']['$oid'] . "' storeName= '" . $each['name'][0] . "'>" . $each['name'][0] . ' - ' . $each['cityName'] . "</option>";
//                                                    }
//                                                }
                                                ?>
                                            </select> 
                                            <input type="hidden" id="storeName" name="storeName" value="<?php echo $data['storeName'];?>" required="required" class="form-control">
                                        </div>
                                        <div class="col-sm-3 error-box" id="ve_store"></div>

                                    </div>-->


                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_DRIVERS_FIRSTNAME; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="text"  id="firstname" name="firstname" required="required"class="form-control" value="<?php echo $data['firstName']; ?>"/>

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_firstname"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_DRIVERS_LASTNAME; ?></label>
                                        <div class="col-sm-6">

                                            <input type="text" id="lastname" name="lastname" required="required"class="form-control" value="<?php echo $data['lastName']; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_lastnmae"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">Date of Birth<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="text"  id="dob" name="dob" required="required" class="form-control datepicker-component1" readonly value="<?php echo $data['dob']; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="dobErr"></div>
                                    </div>

<!--                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">Membership Renewal Date<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <?php
                                            // if (isset($data['memberRenewalDate']) && $data['memberRenewalDate'] != '')
                                                // $memberRenewalDate = date('Y-m-d', $data['memberRenewalDate']);
                                            // else
                                                // $memberRenewalDate = '';
                                            ?>

                                            <input type="text"  id="memberRenewalDate" name="memberRenewalDate" required="required" onfocus="this.removeAttribute('readonly');" readonly class="form-control datepicker-component" value="<?php echo $memberRenewalDate; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="memberRenewalDateErr"></div>
                                    </div>-->
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo FIELD_DRIVERS_UPLOADPHOTO; ?><span style="" class="MandatoryMarker"> *</span></label>
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

                                          <!-- capacity -->
                                    <div class="form-group" style="display:none" >
                                        <label for="address" class="col-sm-2 control-label"><?php echo 'Capacity'; ?><span
                                                style="" class="MandatoryMarker"> </span></label>
                                        <div class="col-sm-5">

                                              <select id="boxtype" name="packageBoxType" class="form-control">
                                                    <option value="">Select box type</option>

                                                    <?php
                                                    if(count($language) < 1){
                                                            foreach ($boxtype as $btype) {

                                                                if($data['packageBoxTypeId'] ==  $btype['_id']['$oid'] ){
	
                                                                    $showData = $btype['name']['en'].' '. $btype['weight'].' '.$btype['weightCapacityUnit'].' '.$btype['volumeCapacity'].' '.$btype['voulumeCapacityUnit'];                                                                
                                                                    echo "<option selected value='" .$btype['name']['en']."' boxid=". $btype['_id']['$oid'] .">" .$showData . "</option>";
                                                            
                                                                }else{
                                                            
                                                                    $showData = $btype['name']['en'].' '. $btype['weight'].' '.$btype['weightCapacityUnit'].' '.$btype['volumeCapacity'].' '.$btype['voulumeCapacityUnit'];                                                                
                                                                    echo "<option value='" .$btype['name']['en']."' boxid=". $btype['_id']['$oid'] .">" .$showData . "</option>";
                                                                }
                                                                
                                                                
                                                            }
                                                        }
                                                        else{
                                                            
                                                            foreach ($boxtype as $btype) {
                                                                $nameData= $btype['name']['en'].' '. $btype['weight'].' '.$btype['weightCapacityUnit'].' '.$btype['volumeCapacity'].' '.$btype['voulumeCapacityUnit'];
                                                                foreach($language as $lngData){
                                                                $lngcode=$lngData['langCode'];
                                                                $lngvalue= ($btype['name'][$lngcode]=='') ? "":$btype['name'][$lngcode];
                                                                if(strlen( $lngvalue)>0){
                                                                    $nameData.= ',' . $lngvalue.' '. $btype['weight'].' '.$btype['weightCapacityUnit'].' '.$btype['volumeCapacity'].' '.$btype['voulumeCapacityUnit'];
                                                                }
                                                            }
                                                            
                                                                echo "<option value='" .$btype['name']['en']."' boxid=".$btype['_id']['$oid'] .">" . $nameData . "</option>";	
                                                                
                                                            }
                                                        }
                                                    ?>

                                                </select>
                                                <input type="hidden" name="packageBoxTypeId" id="packageBoxTypeId">
                                                 

                                        </div>
                                        <div class="col-sm-1">
                                           
                                        </div>
                                        <div class="col-sm-3 error-box" id="file_driver_photo"></div>
                                    </div>

                                    <div class="form-group planSelect" style="display:none" >
                                        <label for="" class="control-label col-sm-2">Delivery Type</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" id="deliveryType" name="deliveryType">
                                               <option value='1' data-name='dinning'>Dinning</option>
                                               <option value='2' data-name='otherCategories'>Other Categories</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 error-box" id="planErr"></div>
                                        <input type="hidden" name="deliveryTypeMsg" id="deliveryTypeMsg">
                                    </div>


                                    <!-- Bank details -->
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo "Bank Holder Name"; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                        <input type="text"  id="bankHolderName" name="bankHolderName" required="required"class="form-control" value="<?php echo $data['bankHolderName']; ?>" readonly/>

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_bankHolderName"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo "Bank Account Number"; ?></label>
                                        <div class="col-sm-6">

                                        <input type="text"  id="bankAccountNumber" name="bankAccountNumber" required="required"class="form-control" value="<?php echo $data['bankAccountNumber']; ?>"readonly />

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_bankAccountNumber"></div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="tab-pane slide-left padding-20" id="tab2">
                                <div class="row row-same-height">

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_DRIVERS_EMAIL; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="email" data="1" id="email" name="email" required="required" onblur="ValidateFromDb()" class="form-control" value="<?php echo $data['email']; ?>" disabled="disabled">


                                        </div>
                                        <span id="editerrorbox" class="col-sm-3 control-label" style="color: #ff0000"></span>
                                        <div class="col-sm-3 error-box" id="text_email"></div>
                                    </div>




                                    <div class="form-group" style="display: none;">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_DRIVERS_PASSWORD; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="password"  id="password" name="password" required="required" class="form-control" value="<?php echo $data['password']; ?>" disabled>

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_password"></div>
                                    </div>


                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_DRIVERS_MOBILE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="text"  id="mobile" name="mobile" minlength="4" maxlength="15" required="required" class="form-control" onkeypress="return isNumberKey(event)" value="<?php echo $data['mobile']; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="driver_mobile"></div>
                                    </div>


                                </div>
                            </div>

                            <div class="tab-pane slide-left padding-20" id="tab3">
                                <div class="row row-same-height">
                                    <div class="form-group">

                                        <label for="fname" class="col-sm-2 control-label">Driving License Front<span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-5">
                                            <input type="file" class="form-control" style="height: 37px;" name="certificate" id="file_upload_l">
                                            <input type="hidden" class="form-control" style="height: 37px;" value="<?php echo $data['driverLicense']; ?>" name="driverLicence" id="driverLicence"> 
                                            <!-- <input type="hidden" value="<?php echo $data['driverLicense']; ?>" name="driverLicence" id='licence_hidden'/> -->


                                        </div>

                                        <div class="col-sm-1">
                                            <img src="<?php echo $data['driverLicenseFront']; ?>" style="width: 35px;height:35px;" class="driverLicence style_prevu_kit">
                                        </div>
                                        <div class="col-sm-3 error-box" id="file_driver_license"></div>
                                    </div>
                                    <div class="form-group">

                                        <label for="fname" class="col-sm-2 control-label">Driving License Back<span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-5">
                                            <input type="file" class="form-control" style="height: 37px;" name="certificateBack" id="driverBack">
                                            <input type="hidden" class="form-control" value="<?php echo $data['driverLicenseBack']; ?>" style="height: 37px;" name="driverLicenceBack" id="driverLicenceBack"> 
                                            <!-- <input type="hidden" value="<?php echo $data['driverLicenseBack']; ?>" name="driverLicenceBack" id='licence_hiddenBack'/> -->


                                        </div>

                                        <div class="col-sm-1">
                                            <img src="<?php echo $data['driverLicenseBack']; ?>" style="width: 35px;height:35px;" class="driverLicenceBack style_prevu_kit">
                                        </div>
                                        <div class="col-sm-3 error-box" id="file_driver_licenseBack"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_DRIVERS_EXDATE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">
                                            <input id="expirationrc" readonly name="expirationrc" required="required"  type="" class="form-control datepicker-component"
                                                   value="<?php echo $data['driverLicenseExpiry']; ?>" autocomplete="off">
                                        </div>
                                        <div class="col-sm-3 error-box" id="file_driver_exdate"></div>
                                    </div>


                                </div>
                            </div>

                            <div class="tab-pane slide-left padding-20" id="tab4">
                                <div class="row row-same-height">
											<div class="" id="serviceZones"></div>
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
                                                                
                                                                <select  class="form-control" id="country" data-stripe="country" >
                                                                 
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
                                                                <label>Personal ID Number </label>
                                                                <input class="form-control"   id="presnalid" placeholder="Personal Id Number" autocomplete="off" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>First Name</label>
                                                                <input class="form-control account_holder_fname" id="account_holder_fname" type="text" data-stripe="account_holder_fname" placeholder="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Last Name</label>
                                                                <input class="form-control account_holder_lname" id="account_holder_lname" type="text" data-stripe="account_holder_lname" placeholder="" autocomplete="off">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                    <!-- <div class="row" >
                                                        <div class="col-md-6" id="routing_number_div">
                                                            <div class="form-group">
                                                                <label id="routing_number_label">Routing Number</label>
                                                                <input class="form-control  bank_account" id="routing_number" type="tel" size="12" data-stripe="routing_number" placeholder="110000000" autocomplete="off" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label id="account_number_label">Account Number</label>
                                                                <input class="form-control bank_account" id="account_number" type="tel" size="20" data-stripe="account_number" placeholder="000123456789" autocomplete="off" onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                    </div> -->


                                                    <div id="nextscreenHtmlNextScreen">
                                                        <div class="row">

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label id="account_number_label">Address </label>
                                                                    <input class="form-control" id="Address" placeholder="Address" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label> City </label>
                                                                    <input class="form-control" id="cityname"  placeholder="City Name" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Postal Code </label>
                                                                    <input class="form-control"   id="postalcode" placeholder="Postal Code" autocomplete="off" onkeypress="return isAlphaNumericKey(event)">
                                                                    <div id="loadingimg" style="display:none; position:absolute; width:150px; height:75px;z-index:1000;top:-70%; left:44%" >
                                                                        <img src="<?php echo base_url(); ?>theme/icon/loadingicon.gif" style="width:75px;height:75px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label id="account_number_label">State</label>
                                                                    <input class="form-control" placeholder="State" id="state" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fname">ID PROOF</label>
                                                                    <input type="file" class="form-control" style="height: 37px;" id="id_proof" data="id_proof">
                                                                    <input type="hidden" id="idproof">
                                                                    <div class="col-sm-3 error-box" id="id_proofErr"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label> DOB </label>
                                                                    <input type="text" class="form-control datepicker-component1" id="DateOfB">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <button style="width:176px;" class="btn btn-sm btn-block btn-success " type="button" id="addBankAcc">CREATE STRIPE ACCOUNT</button>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <span class="stripeResponse" style="font-weight:600;font-size: 11px;"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row createBankAccountDivButton" >
                                                    <br>
                                                    <div class="row">
                                                        <span class="" style="font-weight:600;font-size: 11px;color:green;padding-left: 24px;">Stripe account has been created and verified, Please add your bank account information</span>
                                                    </div>
                                                    <br>
                                                    <div class="col-md-6">

                                                    </div>
                                                    <div class="col-md-6">
                                                        <button style="width:164px;" class="btn btn-sm btn-block btn-success"  type="button" id="createBankAccount">ADD BANK ACCOUNT</button>
                                                    </div>
                                                </div>
                                                <div class="loader"></div>
                                                <div class="panel-body addBankFormDiv"  >
                                                    <div class="errors"></div>
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-md-3">Country<span style="" class="MandatoryMarker"> *</span></label>
                                                        <div class="col-sm-6">
                                                            <select disabled="disabled" class="form-control" id="bankCountryRead" data-stripe="country" disabled="">
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
                                                                <option selected="selected" value="NL">Netherlands</option>
                                                                <option value="NO">Norway</option>
                                                                <option value="PT">Portugal</option>
                                                                <option value="SG">Singapore</option>
                                                                <option value="ES">Spain</option>
                                                                <option value="SE">Sweden</option>
                                                                <option value="CH">Switzerland</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <!--<div class="form-group">
                                                        <label for="" class="control-label col-md-3">Account Number<span style="" class="MandatoryMarker"> *</span></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control number" id="bankAccountNumberRead" name="bankAccountNumberRead" placeholder="" onkeypress="return isNumberKey(event)" readonly="">
                                                        </div>
                                                        <div class="col-sm-3 errors bankAccountNumberErr"></div>
                                                    </div>-->
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-md-3">Account Holder Name<span style="" class="MandatoryMarker"> *</span></label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="bankAccountHolderNameRead" name="bankAccountHolderNameRead" placeholder="" readonly="">
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-md-3">Routing Number<span style="" class="MandatoryMarker"> *</span></label>
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
                                            <span><?php echo BUTTON_NEXT; ?></span>
                                        </button>
                                    </li>
                                    <li class="hidden" id="finishbutton">
                                        <button class="btn btn-success pull-right" type="button" onclick="submitform()">
                                            <span><?php echo BUTTON_FINISH; ?></span>
                                        </button>
                                    </li>

                                    <li class="previous hidden" id="prevbutton">
                                        <button class="btn btn-default pull-right" type="button" onclick="movetoprevious()">
                                            <span><?php echo BUTTON_PREVIOUS; ?></span>
                                        </button>
                                    </li>
                                    <li class="" id="cancelbutton">

                                        <button  type="button" class="btn btn-default pull-right" onclick = "cancel()" ><?php echo BUTTON_CANCEL; ?></button>
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
                <strong style="color:#0090d9;">ADD</strong>
            </div>
            <div class="modal-body">
                <form id="" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                    <div class="form-group">
                        <label for="" class="control-label col-md-3">Country<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <select  class="form-control" id="bankCountry1" data-stripe="country">
                                <option value="">Select</option>
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
                                <option  value="NL">Netherlands</option>
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

                     <div class="form-group" style="display:none">
                        <label for="" class="control-label col-md-3">Currency <span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <select class="form-control" required="" id="bankCurrency" name="bankCurrency">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                   <div class="form-group">
                        <label for="" class="control-label col-md-3">Account Number<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control number" id="bankAccountNumber" name="bankAccountNumber" placeholder="" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="col-sm-3 errors bankAccountNumberErr"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-3">Account Holder Name<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="bankAccountHolderName" name="bankAccountHolderName" placeholder="">
                            <div id="loadingimg1" style="display:none; position:absolute; width:150px; height:75px;z-index:1000;top:-70%; left:44%" >
                                <img src="<?php echo base_url(); ?>theme/icon/loadingicon.gif" style="width:75px;height:75px;">
                            </div>
                        </div>
                        <div class="col-sm-3 errors bankAccountHolderNameErr"></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-3">Routing Number<span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control number" id="bankRoutingNumber" name="bankRoutingNumber" placeholder="NL39RABO0300065264"  >
                        </div>
                        <div class="col-sm-3 errors bankRoutingNumberErr"></div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success pull-right" id="addBankAccount" >Submit</button>
            </div>
        </div>

    </div>
</div>

<script src="<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/intlTelInput.js"></script>

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

