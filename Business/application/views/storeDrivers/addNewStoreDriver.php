
<style>
    .form-horizontal .form-group {
        margin-left: 13px;
    }

    .ui-autocomplete {
        z-index: 5000;
    }

    #selectedcity, #companyid {
        display: none;
    }

    .ui-menu-item {
        cursor: pointer;
        background: black;
        color: white;
        border-bottom: 1px solid white;
        width: 200px;
    }
    .btn{
        border-radius: 25px !important;
    }
    .error{
        color:red;
    }

    .intl-tel-input {
        position: relative;
        display: block;
        height: 40px;
    }
    .MandatoryMarker{
        color:red;
    }
</style>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<link
    href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css"
    rel="stylesheet" type="text/css" />
<script>

    var OnlymobileNo = '';
    var CountryCodeMobileNo = '';

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




    $('.storeDrivers').addClass('active');

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
	 



        $('#city_select').change(function () {
            var cityId = $('#city_select option:selected').val();
            
            $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Drivers/getStoreDataBasedOnCity",
                type: "POST",
                data: {cityId: cityId},
                dataType: "JSON",
                async: false,
                success: function (result) {
                     $('#store_select').empty();
                    console.log(result.data);
                    if(result.data){
                         
                          var html5 = '';
				   var html5 = '<option value="" >Select store</option>';
                          $.each(result.data, function (index, row) {
                              
                               html5 += '<option value="'+row._id.$oid+'" storeName="'+row.name[0]+'">'+row.name[0]+'</option>     ';

                             
                          });
                            $('#store_select').append(html5);    
                    }

                     
                }
            });

        });
		
        $('#store_select').change(function(){
        var storeId = $('#store_select option:selected').val();
        $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Drivers/getZonesBasedOnStores",
                type: "POST",
                data: {storeId: storeId},
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

        // $('#finishbutton').click(function () {
        //     $('#finishbutton').addClass("hidden");
        // });

        $("#mobile").on("countrychange", function (e, countryData) {

            $("#coutry-code").val(countryData.dialCode);
        });

        $('.datepicker-component,.datepicker-component1').on('changeDate', function () {
            $(this).datepicker('hide');
        });




//        $("#datepicker1").datepicker({ minDate: 0});
        var date = new Date();
        $('.datepicker-component').datepicker({
            format: 'dd/mm/yyyy',
            startDate: date
        });



        $('.datepicker-component1').datepicker({
            format: 'dd/mm/yyyy',
            endDate: "12-31-2010"

        });

        $('#datepicker-range').datepicker({
            endDate: date,

        });

//        $('#company_select').change(function ()
//        {
//            $('#operatorName').val($('#company_select option:selected').attr('operatorName'));
//        });

        $('#store_select').change(function ()
        {
            $('#storeName').val($('#store_select option:selected').attr('storeName'));
        });

//        if ($('#Operator').prop('checked', true)) {
//            $('#store_select').prop('disabled', true);
//            $('#store_select').val('');
//        }
//        $('.radio-success').click(function ()
//        {
//            if ($(this).attr('id') == 'Freelancer')
//            {
////                $('#company_select').prop('disabled', true);
//                $('#store_select').prop('disabled', true);
//                $('.planSelect').css('display','block');
//                $('#store_select').val('');
//                $('#selectedOwnerType').val('1');
//
//            } else if ($(this).attr('id') == 'store') {
////                $('#company_select').prop('disabled', true);
//                $('#store_select').prop('disabled', false);
//                 $('.planSelect').css('display','none');
////                $('#company_select').val('');
//                $('#selectedOwnerType').val('3');
//            } else
//            {
////                $('#company_select').prop('disabled', false);
//                $('#store_select').prop('disabled', true);
//                $('#store_select').val('');
//                $('#selectedOwnerType').val('2');
//            }
//        });

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


        $('#Address').focus(function () {

            var input;
            input = document.getElementById('Address');

            var searchBox = new google.maps.places.SearchBox(input);

            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function () {

                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }
                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {

                    getCityCountry(place.name);
//                   
                });
            });
        });

//        
//       $('.tabs_active').click(function() {
//           
//           var pstatus = true;
//            if($(this).attr('id') == 'fifthlitab')
//             {
//                   $("#finishbutton").removeClass("hidden");
//            $("#nextbutton").addClass("hidden");
//                 
//             }else
//             {
//                   $("#finishbutton").addClass("hidden");
//                   $("#nextbutton").removeClass("hidden");
//             }
//             
//   });

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

    function phoneValidationCheck(phone, coutryCode)
    {


        var OnlymobileNo = phone;
        var CountryCodeMobileNo = '+' + coutryCode;
        var returnStatus;
        var status = '1';
        $.ajax({
            url: "<?php echo base_url(); ?>index.php?/Drivers/validateMobileNo",
            type: "POST",
            data: {CountryCodemobileNo: CountryCodeMobileNo, onlyMobileNo: OnlymobileNo},
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

//validations for each previous tab before proceeding to the next tab
    function managebuttonstate()
    {
        $("#prevbutton").addClass("hidden");
    }

    function profiletab(litabtoremove, divtabtoremove)
    {
        var pstatus = true;

        $(".error-box").text("");

        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();
        var dob = $("#dob").val();
        var mobile = $('#mobile').val();
        var driverphoto = $('#driverImage').val();
        var memberRenewalDate = $('#memberRenewalDate').val();
        

        var selectedOwnerType = $("#selectedOwnerType").val();
//        var company_select = $("#company_select").val();
        var store_select = $("#store_select").val();

        var password = /^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,15}$/;
        var number = /^[0-9-+]+$/;
        var num = /^[0-9]+$/;
        var email = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/; //^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        var text = /^[a-zA-Z ]*$/;
        var alphabit = /^[a-zA-Z]+$/;

//        if (company_select == "" && selectedOwnerType == 2)
//        {
//            $("#ve_compan").text('Please choose an operator');
//            pstatus = false;
//        } else
//            if (store_select == "" && selectedOwnerType == 3)
//        {
//            $("#ve_store").text('Please choose an store');
//            pstatus = false;
//        } else 
        if (firstname == "" || firstname == null)
        {
            $("#text_firstname").text(<?php echo json_encode(POPUP_DRIVER_FIRSTNAME); ?>);
            pstatus = false;
        } else if (dob == "")
        {
            $("#dobErr").text('Please choose date of birth');
            pstatus = false;
        }
//        else if (planSelected == "")
//        {
//            $("#planErr").text('Please choose a plan');
//            pstatus = false;
//        }
//        else if (memberRenewalDate == "")
//        {
//            $("#memberRenewalDateErr").text('Please choose membership renewal date');
//            pstatus = false;
//        } 
        else if (driverphoto == "" || driverphoto == null)
        {
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
        $("#prevbutton").removeClass("hidden");
        $("#nextbutton").removeClass("hidden");
        $("#finishbutton").addClass("hidden");
        return true;
    }




    function addresstab(litabtoremove, divtabtoremove)
    {

        var astatus = true;
        if (profiletab(litabtoremove, divtabtoremove))
        {
            var paswordEncrypted = $('#password').val();

            var emailCheck = emailValidationCheck($("#email").val());
            var phoneCheck = phoneValidationCheck($('#mobile').val(), $('#coutry-code').val());

            $("#text_password").text("");
            $("#text_zip").text("");

            var email = $("#email").val();
            var password = $("#password").val();
            var mobile = $('#mobile').val();
            var zipcode = $('#zipcode').val();
            var emails = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            var num = /^[0-9]+$/;

            var pass = /^(?=.*\d)(?=.*[a-zA-Z])(?!.*[\W_\x7B-\xFF]).{6,15}$/;

            if (email == "" || email == null)
            {
                $("#editerrorbox").html(<?php echo json_encode(POPUP_DRIVER_DRIVER_EMAIL); ?>);
                astatus = false;
            } else if (!emails.test(email))
            {
                $("#editerrorbox").html(<?php echo json_encode(POPUP_DRIVER_DRIVER_YOUREMAIL); ?>);
                astatus = false;
            } else if ($("#email").attr('data') == 1)
            {
                $("#editerrorbox").html(<?php echo json_encode(POPUP_DRIVER_DRIVER_ALLOCATED); ?>);
                astatus = false;
            } else if (emailCheck)
            {
                $("#editerrorbox").text(<?php echo json_encode(POPUP_DRIVER_DRIVER_ALLOCATED); ?>);
                astatus = false;
            } else if (password == "" || password == null)
            {
                $("#text_email").text("");
                $("#editerrorbox").html("");
                $("#text_password").text(<?php echo json_encode(POPUP_DRIVER_DRIVER_PASSWORD); ?>);
                astatus = false;
            } else if (password.length < 4)
            {
                $("#text_email").text("");
                $("#text_password").text('Password should have at least 4 char long');
                astatus = false;
            } else if (mobile == "" || mobile == null)
            {
                $("#text_email").text("");
                $("#editerrorbox").html("");
                $("#text_password").text("");
                $("#driver_mobile").text('Please enter mobile number');
                astatus = false;
            } else if (mobile.length < 4)
            {

                $("#driver_mobile").text('Please enter valid mobile number');
                astatus = false;
            } else if (!num.test(mobile))
            {
                $("#driver_mobile").text('Please enter valid mobile number');
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

            // cool

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

            return astatus;
        }
    }

    function bonafidetab(litabtoremove, divtabtoremove)
    {
        var bstatus = true;
        if (addresstab(litabtoremove, divtabtoremove))
        {

            if ($("#driverLicence").val() == '' || $("#driverLicence").val() == null)
            {
                bstatus = false;
                $('#file_driver_license').text("Complete Driving Licence tab properly");
            }else  if ($("#driverLicenceBack").val() == '' || $("#driverLicenceBack").val() == null)
            {
                bstatus = false;
                $('#file_driver_license1').text("Complete Driving Licence tab properly");
            } else if ($("#expirationrc").val() == '')
            {
                $('#file_driver_license').text("");
                bstatus = false;
                $('#file_driver_exdate').text("Please select the expiry date");
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

            console.log('here');
            $("#nextbutton").addClass("hidden");
            $("#finishbutton").removeClass("hidden");
            console.log('here');
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
            if (bonafidetab('fourthlitab', 'tab4'))
         {

                proceed('thirdlitab', 'tab3', 'fourthlitab', 'tab4');

//                $("#finishbutton").removeClass("hidden");
//                $("#nextbutton").addClass("hidden");
            }
        }
//        else if (currenttabstatus === "fourthlitab")
//        {
//             $("#tab4icon").addClass("fs-14 fa fa-check");
//            proceed('fourthlitab', 'tab4', 'fifthlitab', 'tab5');
//
//            $("#finishbutton").removeClass("hidden");
//            $("#nextbutton").addClass("hidden");
//        }
    }

    function movetoprevious()
    {
        var currenttabstatus = $("li.active.tabs_active").attr('id');
        if (currenttabstatus === "secondlitab")
        {
            profiletab('secondlitab', 'tab2');
            proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
            $("#prevbutton").addClass("hidden");
        } else if (currenttabstatus === "thirdlitab")
        {
            addresstab('thirdlitab', 'tab3');
            proceed('thirdlitab', 'tab3', 'secondlitab', 'tab2');
            $("#nextbutton").removeClass("hidden");

            $("#prevbutton").removeClass("hidden");
        } else if (currenttabstatus === "fourthlitab")
        {
            bonafidetab('fourthlitab', 'tab4');
            proceed('fourthlitab', 'tab4', 'thirdlitab', 'tab3');
            $("#nextbutton").removeClass("hidden");
            $("#finishbutton").addClass("hidden");
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




    function submitform()
    {

       $('#finishbutton').removeAttr('disabled');
      
        $("#file_driver_license").val('');
        $("#file_driver_exdate").val('');
        $("#file_passbook").val('');
        // $('#driverLicence').val($('.driverLicence').val());
		// $('#driverLicenceBBack').val($('.driverLicenceBack').val())
        $('#cityName').val($('#city_select option:selected').attr('city'));
        var uploaddrivinglicence = $("#driverLicence").val();
		var uploaddrivinglicenceBack = $("#driverLicenceBack").val();
        var expiredatelicence = $("#expirationrc").val();
        var expiredatePassbook = $("#expirationPassbook").val();


        if (uploaddrivinglicence == "" || uploaddrivinglicence == null)
        {
            $("#file_driver_license").text(<?php echo json_encode(POPUP_DRIVER_FILE_POPUP_DRIVING); ?>);
        }else if (uploaddrivinglicenceBack == "" || uploaddrivinglicenceBack == null)
        {
			$("#file_driver_license").text("");
            $("#file_driver_license1").text(<?php echo json_encode(POPUP_DRIVER_FILE_POPUP_DRIVING); ?>);
        }
		else if (expiredatelicence == "" || expiredatelicence == null)
        {

            $("#file_driver_license1").text("");
            $("#file_driver_exdate").text(<?php echo json_encode(POPUP_DRIVER_FILE_POPUP_EXPERIENCE); ?>);

        }else if(!$("#addentity").valid()){
            console.log('in ');
                  $('#finishbutton').removeClass("hidden");
            } else {

            

            var currentdate = new Date();
            var datetime = currentdate.getFullYear() + "-" + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();

            $('#time_hidden').val(datetime);

            $('#addentity').submit();
            $('#finishbutton').removeClass("hidden");

        }

    }

</script>
<script>
    function stripeResponseHandler(status, response) {


        if (response.error) { // Problem!
            alert(response.error.message);
        } else { // Token was created!

            // Get the token ID:
            var token = response.id;
            document.getElementById("Banktocken").value = token;
            stripetockencallback(token);
        }
    }
    function stripeResponseHandlerNew(status, response) {


        if (response.error) { // Problem!
            alert(response.error.message);
        } else { // Token was created!

            var token = response.id;
            stripetockencallbackNew(token);
        }
    }


    function stripetockencallback(token) {

        var data = {IdProoF: $('#idproof').val(),
            "dob": $('#DateOfB').val(), presnalid: $('#presnalid').val(), banktoken: token, 'account_holder_name': $('#account_holder_name').val(),
            'state': $('#state').val(), postalcode: $('#postalcode').val(), cityname: $('#cityname').val(), Address: $('#Address').val(), mas_id: '<?php echo $driverid; ?>'
        };
        $.ajax({
            url: '<?php echo base_url(); ?>index.php?/Drivers/AddBankAccountInitial',
            type: 'post',
            data: data,
            dataType: "JSON",
            async: false,
            success: function (data) {
                document.getElementById("addBankAcc").innerHTML = "<i class='fa fa-check'></i> Account added.";
                $('#process').fadeOut('slow');
                if (data.flag == 0) {
                    alert(data.msg);
                    $('#Banktocken').val("");
                    location.reload();
                } else {
                    alert(data.msg);
                }

            },
            error: function (data) {
                $('#process').fadeOut('slow');
                $('#txtdelete').text(data);
            }

        });
    }

    function stripetockencallbackNew(id) {


        if (id == "") {
            $('#process').fadeOut('slow');
            alert('Please Add Bank Details first');
        } else {

            $.ajax({
                url: '<?php echo base_url(); ?>index.php?/Drivers/deleteDriverBank',
                type: 'post',
                data: {'id': id, 'uid': '<?php echo $driverid; ?>', deleteaccount: $('#deleteaccount').val()},
                dataType: "JSON",
                async: false,
                success: function (data) {

                    $('#process').fadeOut('slow');
                    if (data.flag == 0) {
                        $('#addnewaccountmodel').modal('hide');
                        $('#deletebanckac').modal('show');
                        $('#txtdelete').text(data.message);
                        $('#addBankAccwhileDeleting').hide();

                        var settings1 = {
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "sPaginationType": "bootstrap",
                            "destroy": true,
                            "scrollCollapse": true,
                            "oLanguage": {
                                "sLengthMenu": "_MENU_ ",
                                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
                            },
                            "iDisplayLength": 20,
                            "order": [[0, 'desc']]

                        };
                        var table = $('#big_table').DataTable(settings1);
                        table
                                .clear()
                                .draw();

                        $.each(data.userData, function (index, row1) {


                            var rownod = table.row.add([
                                row1.bank_id,
                                row1.account_holder_name,
                                row1.bank_name,
                                row1.routing_number,
                                row1.country,
                                row1.currency,
                                '<button name="" type="button" class="btn btn-danger" onclick="deleteid(this)" value="' + row1.bank_id + '">Delete</button>'
                            ]).draw();
                        });
                    } else {
                        alert(data.message);
                    }

                },
                error: function (data) {

                    $('#txtdelete').text(data);
                }

            });
        }

    }

    $(document).ready(function () {
        Stripe.setPublishableKey('<?php echo ($appCofig['pricing_model']['paymentGatewayEnDis'] == 1) ? $appCofig['stripeLiveKeys']['PublishableKey'] : $appCofig['stripeTestKeys']['PublishableKey'] ?>');
        $('#addBankAcc').click(function () {
            if ($('#DateOfB').val() == "") {
                alert('Date Of Birth Is missing.');
            } else if ($('#presnalid').val() == "") {
                alert('Presnal Id Is missing.');
            } else if ($('#state').val() == "") {
                alert('Presnal Id Is missing.');
            } else if ($('#postalcode').val() == "") {
                alert('postal code  Is missing.');
            } else if ($('#cityname').val() == "") {
                alert('cityname  Is missing.');
            } else if ($('#Address').val() == "") {
                alert('Address  Is missing.');
            } else if ($('#idproof').val() == "") {
                alert('Plz choose Id Proof.');
            } else {
                if ($('#Banktocken').val() == "") {
                    $('#process').fadeIn('slow');
                    Stripe.bankAccount.createToken({
                        country: $('#country').val(),
                        currency: $('#currency').val(),
                        routing_number: $('#routing_number').val(),
                        account_number: $('#account_number').val(),
                        account_holder_name: $('#account_holder_name').val(),
                        account_holder_type: 'individual'//$('.account_holder_type').val()
                    }, stripeResponseHandler);
                } else {
                    stripetockencallback($('#Banktocken').val());
                }
            }
        });
        $('#addBankAccBeforeDelete').click(function () {
            $('#process').fadeIn('slow');
            Stripe.bankAccount.createToken({
                country: $('#countrym').val(),
                currency: $('#currencym').val(),
                routing_number: $('#routing_numberm').val(),
                account_number: $('#account_numberm').val(),
                account_holder_name: $('#account_holder_namem').val(),
                account_holder_type: 'individual'//$('.account_holder_type').val()
            }, stripeResponseHandlerNew);
        });
    });
</script>



<div class="page-content-wrapper">
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb" style="margin-left: 0px; margin-top: 5%;">
        <li><a
                href="<?php echo base_url(); ?>index.php?/Drivers/storeDrivers/my/1"
                class=""><?php echo $this->lang->line('DRIVER'); ?></a></li>

        <li style="width: 100px"><a href="#" class="active"><?php echo $this->lang->line('ADD'); ?></a>
        </li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class=" bg-white" data-pages="parallax">
            <div class="inner"></div>


            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                    <!-- Nav tabs -->
                    <ul
                        class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm"
                        id="mytabs">
                        <li class="active tabs_active" id="firstlitab"
                            onclick="managebuttonstate()"><a data-toggle="tab" href="#tab1"
                                                         id="tb1"><i id="tab1icon" class=""></i> <span><?php echo $this->lang->line('LIST_DRIVER_PESIONALDETAILS'); ?></span></a>
                        </li>
                        <li class="tabs_active" id="secondlitab"><a data-toggle="tab"
                                                                    href="#tab2" onclick="profiletab('secondlitab', 'tab2')"
                                                                    id="mtab2"><i id="tab2icon" class=""></i> <span><?php echo $this->lang->line('LIST_DRIVER_LOGINDETAILS'); ?></span></a>
                        </li>
                        <li class="tabs_active" id="thirdlitab"><a data-toggle="tab"
                                                                   href="#tab3" onclick="addresstab('thirdlitab', 'tab3')"><i
                                    id="tab3icon" class=""></i> <span><?php echo $this->lang->line('LIST_DRIVER_DRIVINGLICENCE'); ?></span></a>
                        </li>
                        <li class="tabs_active" id="fourthlitab"><a data-toggle="tab"
                                                                    href="#tab4" onclick="bonafidetab('fourthlitab', 'tab4')"><i
                                    id="tab4icon" class=""></i> <span><?php echo $this->lang->line('SERVICE_ZONES'); ?></span></a></li>
                        <!--                            <li class="tabs_active" id="fifthlitab">
        <a data-toggle="tab" href="#tab5" onclick="fifthTab('fourthlitab','tab5')"><i id="tab5icon" class=""></i> <span>BANK DETAILS</span></a>
    </li>-->
                    </ul>
                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form"
                          action="<?php echo base_url(); ?>index.php?/Drivers/AddNewDriverData"
                          method="post" enctype="multipart/form-data">
                        <input type="hidden" id="coutry-code" name="coutry-code" value="">

                        <div class="tab-content">
                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">
                                    <input type="hidden" id="driverType" value="2" name="driverType" required="required" class="form-control">
                                    


                                    <!--                                    <div class="form-group" class="formexx">
                                                                            <label for="address" class="col-sm-2 control-label">Driver
                                                                                Type<span style="" class="MandatoryMarker"> *</span>
                                                                            </label>
                                                                            <div class="col-sm-6">
                                                                                <div class="col-sm-4">
                                                                                    <input type="radio" class="radio-success" name="driverType"
                                                                                            id="Operator" value="2" checked> <label>Operator</label>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <input type="radio" class="radio-success" name="driverType"
                                                                                           id="Freelancer" checked value="1"> <label>Freelancer</label>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                    <input type="radio" class="radio-success" name="driverType"
                                                                                           id="store" value="3"> <label>Store</label>
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" id="selectedOwnerType"
                                                                                   name="selectedOwnerType" value="2">
                                    
                                                                            <div class="col-sm-3 error-box" id="companyname"></div>
                                                                        </div>-->


                                    <!--                                    <div class="form-group">
                                                                            <label for="fname" class="col-sm-2 control-label">Operator
                                                                                Name<span style="" class="MandatoryMarker"> *</span>
                                                                            </label>
                                                                            <div class="col-sm-6">
                                                                                <select id="company_select" name="company_select"
                                                                                        class="form-control error-box-class">
                                                                                    <option value="">Select a Operator</option>
                                    <?php
//                                                foreach ($Operators as $each) {
//                                                    echo "<option value='" . $each['_id']['$oid'] . "' operatorName= '" . $each['operatorName'] . "'>" . $each['operatorName'] . ' - ' . $each['email'] . ' - ' . $each['mobile'] . "</option>";
//                                                }
                                    ?>
                                                                                </select> <input type="hidden" id="operatorName" name="operatorName" required="required" class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-3 error-box" id="ve_compan"></div>
                                    
                                                                        </div>-->
                                    

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('First_Name'); ?><span
                                                style="color:red;" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="text" id="firstname" name="firstname"
                                                   required="required" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_firstname"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_LASTNAME'); ?></label>
                                        <div class="col-sm-6">

                                            <input type="text" id="lastname" name="lastname"
                                                   required="required" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_lastnmae"></div>
                                    </div>


                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Date_of_Birth'); ?><span style="color:red;" class="MandatoryMarker"> *</span>
                                        </label>
                                        <div class="col-sm-6">

                                            <input type="text" id="dob" name="dob" required="required"
                                                   onfocus="this.removeAttribute('readonly');" readonly
                                                   class="form-control datepicker-component1" onkeypress="return isNumberKey(event)" >

                                        </div>
                                        <div class="col-sm-3 error-box" id="dobErr"></div>
                                    </div>

                                    
                                    <!--                                    <div class="form-group">
                                                                            <label for="fname" class="col-sm-2 control-label">Membership
                                                                                Renewal Date<span style="" class="MandatoryMarker"> *</span>
                                                                            </label>
                                                                            <div class="col-sm-6">
                                    
                                                                                <input type="text" id="memberRenewalDate"
                                                                                       name="memberRenewalDate" required="required"
                                                                                       onfocus="this.removeAttribute('readonly');" readonly
                                                                                       class="form-control datepicker-component">
                                    
                                                                            </div>
                                                                            <div class="col-sm-3 error-box" id="memberRenewalDateErr"></div>
                                                                        </div>-->
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_UPLOADPHOTO'); ?><span
                                                style="color:red;" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">

                                            <input type="file" class="form-control" style="height: 37px;"
                                                   name="photos" id="file_upload"> <input type="hidden"
                                                   class="form-control" style="height: 37px;"
                                                   name="driverImage" id="driverImage">

                                        </div>
                                        <div class="col-sm-1">
                                            <img src="" style="width: 35px; height: 35px; display: none;"
                                                 class="driverImage style_prevu_kit">
                                        </div>
                                        <div class="col-sm-3 error-box" id="file_driver_photo"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane slide-left padding-20" id="tab2">
                                <div class="row row-same-height">

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_EMAIL'); ?><span
                                                style="color:red;" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="email" data="1" id="email" name="email"
                                                   required="required"
                                                   onfocus="this.removeAttribute('readonly');" readonly
                                                   class="form-control">


                                        </div>
                                        <span id="editerrorbox"
                                              class="col-sm-3 control-label error-box"></span>
                                        <div class="col-sm-3 error-box" id="text_email"></div>
                                    </div>




                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_PASSWORD'); ?><span
                                                style="color:red;" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="password" id="password" name="password"
                                                   required="required" class="form-control"> <input
                                                   type="hidden" name="paswordEncrypted"
                                                   class="form-control paswordEncrypted">

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_password"></div>
                                    </div>

                                   <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_MOBILE'); ?><span
                                                style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-6">
                                            <input type="text" data="1" id="mobile"  name="mobile"
                                                   required="required" class="form-control"
                                                   onkeypress="return isNumberKey(event)">

                                        </div>
                                        <div class="col-sm-3 error-box" id="driver_mobile"></div>
                                    </div>

                                    <div class="form-group">

                                        <label for="fname" class="col-sm-2 control-label error-box-class"><?php echo 'Order Fulfillment Type'; ?><span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="radio" class="orderFulfillmentType error-box-class" name="orderFulfillmentType" id="onDemand" value="0" checked >&nbsp;&nbsp;<label for="onDemand"><?php echo 'On - Demand'; ?></label> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" class="orderFulfillmentType error-box-class" name="orderFulfillmentType" id="slots" value="1" >&nbsp;&nbsp;<label for="slots"><?php echo 'Slots'; ?></label>
                                        </div>
                                        <div class="col-sm-2 error-box" id="text_pricing" style="color:red"></div>
                                    </div>

                                </div>
                            </div>




                            <div class="tab-pane slide-left padding-20" id="tab3">
                                <div class="row row-same-height">
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Driving_Licence_Front'); ?><span
                                                sstyle="color:red;" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-5">
                                            <input type="file" class="form-control" style="height: 37px;"
                                                   name="driverLicenceFront" id="file_upload_l"> <input type="hidden"
                                                   class="form-control" style="height: 37px;"
                                                   name="driverLicence" id="driverLicence">
                                        </div>
                                        <div class="col-sm-1">
                                            <img src="" style="width: 35px; height: 35px; display: none;"
                                                 class="driverLicence style_prevu_kit">
                                        </div>
                                        <div class="col-sm-3 error-box" id="file_driver_license"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Driving_Licence_Back'); ?><span
                                                style="color:red;" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-5">
                                            <input type="file" class="form-control" style="height: 37px;"
                                                   name="driverLicenceBack1" id="driverBack"> <input type="hidden"
                                                   class="form-control" style="height: 37px;"
                                                   name="driverLicenceBack" id="driverLicenceBack">
                                        </div>
                                        <div class="col-sm-1">
                                            <img src="" style="width: 35px; height: 35px; display: none;"
                                                 class="driverLicenceBack style_prevu_kit">
                                        </div>
                                        <div class="col-sm-3 error-box" id="file_driver_license1"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('FIELD_DRIVERS_EXDATE'); ?><span
                                                style="color:red;" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">
                                            <input id="expirationrc" name="expirationrc"
                                                   required="required" type=""
                                                   class="form-control datepicker-component">
                                        </div>
                                        <div class="col-sm-1"></div>
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

                                                <div class="panel-body">
                                                    <div class="errors"></div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Country</label> <select
                                                                    class="form-control input-lg" id="country"
                                                                    data-stripe="country">
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
                                                                <label>Currency</label> <select
                                                                    class="form-control input-lg" id="currency"
                                                                    data-stripe="currency">
                                                                    <option value="usd">USD</option>
                                                                    <option value="aud">AUD</option>
                                                                    <option value="brl">BRL</option>
                                                                    <option value="cad">CAD</option>
                                                                    <option value="eur">EUR</option>
                                                                    <option value="gbp">GBP</option>
                                                                    <option value="hkd">HKD</option>
                                                                    <option value="jpy">JPY</option>
                                                                    <option value="mxn">MXN</option>
                                                                    <option value="nzd">NZD</option>
                                                                    <option value="sgd">SGD</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('Full_Legal_Name'); ?></label> <input
                                                                    class="form-control input-lg account_holder_name"
                                                                    id="account_holder_name" type="text"
                                                                    data-stripe="account_holder_name"
                                                                    placeholder="Jane Doe" autocomplete="off">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6" id="routing_number_div">
                                                            <div class="form-group">
                                                                <label id="routing_number_label"><?php echo $this->lang->line('Routing_Number'); ?></label>
                                                                <input class="form-control input-lg bank_account"
                                                                       id="routing_number" type="tel" size="12"
                                                                       data-stripe="routing_number" placeholder="110000"
                                                                       autocomplete="off"
                                                                       onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label id="account_number_label"><?php echo $this->lang->line('Account_Number'); ?></label>
                                                                <input class="form-control input-lg bank_account"
                                                                       id="account_number" type="tel" size="20"
                                                                       data-stripe="account_number" placeholder="000123456789"
                                                                       autocomplete="off"
                                                                       onkeypress="return isNumberKey(event)">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div id="nextscreenHtmlNextScreen">
                                                        <div class="row">

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label id="account_number_label"><?php echo $this->lang->line('Address'); ?> </label> <input
                                                                        class="form-control input-lg" id="Address"
                                                                        placeholder="Address" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label> <?php echo $this->lang->line('City'); ?> </label> <input
                                                                        class="form-control input-lg" id="cityname"
                                                                        placeholder="City Name" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line('Postal_Code'); ?> </label> <input class="form-control"
                                                                                                       id="postalcode" placeholder="Postal Code"
                                                                                                       autocomplete="off"
                                                                                                       onkeypress="return isNumberKey(event)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label id="account_number_label"><?php echo $this->lang->line('State'); ?></label> <input
                                                                        class="form-control input-lg" placeholder="State"
                                                                        id="state" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line('Personal_ID_Number'); ?> </label> <input
                                                                        class="form-control" id="presnalid"
                                                                        placeholder="Personal Id Number" autocomplete="off"
                                                                        onkeypress="return isNumberKey(event)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label> <?php echo $this->lang->line('DOB'); ?> </label> <input type="text"
                                                                                                class="form-control datepicker-component1"
                                                                                                id="DateOfB">

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="form-group">

                                                            <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('ID_PROOF'); ?></label>

                                                            <div class="col-sm-6">
                                                                <input type="file" class="form-control"
                                                                       style="height: 37px;" id="id_proof" data="id_proof"> <input
                                                                       type="hidden" id="idproof">
                                                            </div>
                                                            <div class="col-sm-3 error-box" id="id_proofErr"></div>
                                                        </div>


                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button style="width: 130px;"
                                                                    class="btn btn-lg btn-block btn-success " type="button"
                                                                    id="addBankAcc"><?php echo $this->lang->line('VERIFY_ACCOUNT'); ?></button>
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
                                        <button class="btn btn-info  pull-right" type="button"
                                                onclick="movetonext()">
                                            <span><?php echo $this->lang->line('Next'); ?></span>
                                        </button>
                                    </li>
                                    <li class="hidden" id="finishbutton">
                                        <button class="btn btn-success  pull-right" type="button"
                                                onclick="submitform()">
                                            <span><?php echo $this->lang->line('Finish'); ?></span>
                                        </button>
                                    </li>

                                    <li class="previous hidden" id="prevbutton">
                                        <button class="btn btn-default  pull-right" type="button"
                                                onclick="movetoprevious()">
                                            <span><?php echo $this->lang->line('Previous'); ?></span>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <input type="hidden" name="current_dt" id="time_hidden" value="" />
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


<script src="<?php echo base_url(); ?>theme/intl-tel-input-master/build/js/intlTelInput.js"></script>
<script src="<?php echo ServiceLink; ?>theme/assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript"src="http://maps.google.com/maps/api/js?key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE&sensor=false&libraries=places&language=en-AU"></script>


<script>
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




</script>