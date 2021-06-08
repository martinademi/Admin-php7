
<style>
    .form-horizontal .form-group {
        margin-left: 13px;
    }
    /*    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}*/
    .multiselect {
        width: 200px;
    }

    .selectBox {
        position: relative;
    }

    .selectBox select {
        width: 100%;
        font-weight: bold;
    }

    .overSelect {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }

    #checkboxes {
        display: none;
        border: 1px #dadada solid;
    }

    #checkboxes label {
        display: block;
    }

    .selectedGood {
        /*    padding: 6px;
    display: inline-flex;
    margin: 0px 1px 1px;
    font-weight: 600;*/
        height: 28px;
        padding: 6px;
        display: inline-flex;
        margin: 0px 1px 1px;
        font-weight: 600;
        /*background: #5bc0de;*/
        border: 1px solid;
        border-radius: 4px;
    }

    .inputCheckbox {
        border: none;
    }

    .RemoveMore {
        color: #6185b0;
        height: 18px;
    }

    input[type=checkbox], input[type=radio] {
        margin: 4px 5px 0;
        line-height: normal;
    }

    .driverList {
        display: none;
    }
</style>




<script>
    var idNum = 0;
    var htmlCompanyList;
    var htmlDriverList;

    function RemoveMore(Id)
    {
        $('#RemoveControl' + Id).remove();
    }

    var expanded = false;
    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }
    var html;
    var ImageFlag = 0;
    $(document).ready(function () {


        //Settings for specific drivers
        $('#selectedOwnerType').val(<?php echo $driverData['accountType']; ?>);
        var account_type = <?php echo $driverData['accountType']; ?>;

        switch (account_type)
        {
            case 1:
                console.log('1');
                $('#Freelancer').attr('checked', true);
                $('#Operator').prop('disabled', true);
                $('#company_select').prop('disabled', true);
                $('.driverList').show();
                $('#company_select').val('');
                break;
            case 2:
                console.log('2');
                $('#Operator').val('checked', true);
                $('.driverList').hide();
                $('#company_select').prop('disabled', false);
                $('#Freelancer').prop('disabled', true);
                $('#selected_driver').val('');
                break;
        }

        $('#selected_driver').empty();

        id = '<?php echo $driverData['_id']['$oid']; ?>'
        name = '<?php echo $driverData['firstName'] . '-' . $driverData['lastName'] . '-' . $driverData['email'] . '-' . $driverData['mobile']; ?>';
        mobile = '<?php echo $driverData['mobile']; ?>';
        name1 = '  <?php echo $driverData['firstName'] . ' ' . $driverData['lastName']; ?>';
        htmlDriverList += '<option value="' + id + '" driverName="' + name1 + '" driverMobile="' + mobile + '">' + name + '</option>';

        $('#selected_driver').append(htmlDriverList);
        
        $('#driverName').val('<?php echo $driverData['firstName'] . '-' . $driverData['lastName'];?>');
        $('#driverMobile').val('<?php echo $driverData['mobile'];?>');

        //reset the form data
        $(".clear").click(function () {
            $('.selectedGoodType').empty();
            $('#addVehicleTypeForm')[0].reset();
        });

        $('#company_select').empty();
        htmlCompanyList += '<option value="">select</option>';
<?php
foreach ($Operators as $op) {
    ?>      id = '<?php echo $op['_id']['$oid']; ?>'
            name = '<?php echo $op['operatorName'] . '-' . $op['email'] . '-' . $op['mobile']; ?>';
            operatorName = '<?php echo $op['operatorName']; ?>';
            htmlCompanyList += '<option value="' + id + '" operator="' + operatorName + '">' + name + '</option>';

    <?php
}
?>


        $('#company_select').append(htmlCompanyList);
        $(document).on('click', '.checkbox1', function ()
        {
            if ($(this).is(":checked"))
            {
                $('.selectedGoodType').append('<span class="selectedGood" id="RemoveControl' + $(this).attr('id') + '"><input readonly type="text" class="inputCheckbox" value="' + $(this).attr('goodType') + '"><input type="button"  value="&#10008" data-id="' + $(this).attr('id') + '" class="RemoveMore">')
                $('#goodType').val($(this).attr('id'));
            } else {
                RemoveMore($(this).attr('id'));
            }
        });



        $('.tabs_active').click(function () {

            var pstatus = true;
            $(".error-box").text("");

            $("#ve_compan").val('');
            $("#ve_city").val('');
            $("#ve_type").val('');
            $("#ve_make").val('');
            $("#v_modal").val('');
            $("#v_image").val('');
            $("#ve_id").val('');

            $("#ve_city").text('');

            var selectedOwnerType = $("#selectedOwnerType").val();

            var company = $("#company_select").val();
            var cityselect = $("#city_select").val();
            var vtype = $("#getvechiletype").val();
            var goodType = $("#goodType").val();

            var vmake = $('#vehiclemake').val();
            var vmodal = $('#vehiclemodel').val();
            var vimage = $('#vehicleImage').val();
            var vehicleid = $("#vehicleid").val();
            var manual = $("input[name = entitystatus]:checked").val()
            var driver_select = $("#selected_driver").val();


            if ((company == "" && selectedOwnerType == 0))
            {
                $("#ve_compan").text(<?php echo json_encode(POPUP_ADDCOMPANY_NAME); ?>);
                return false;
            } else if ((driver_select == "" && selectedOwnerType == 0))
            {
                $("#driver").text('Please select a driver');
                return false;
            } else if (vtype == "" || vtype == null)
            {
                $("#ve_type").text(<?php echo json_encode(POPUP_SELECT_TYPE); ?>);
                return false;
            } else if (goodType == "")
            {
                $("#goodTypeErr").text('Please select good type');
                return false;
            } else if (manual == 2 && (vehicleid == "" || vehicleid == null))
            {
                $("#ve_type").text("");
                $("#ve_id").text(<?php echo json_encode(POPUP_SELECT_VEHICLEID); ?>);
                return false;
            } else if (vmake == "" || vmake == null)
            {
                $("#ve_type").text("");
                $("#ve_id").text("");
                $("#ve_make").text(<?php echo json_encode(POPUP_SELECT_VEHICLEMAKE); ?>);
                return false;
            } else if (vmodal == "" || vmodal == null)
            {
                $("#ve_make").text("");
                $("#v_modal").text(<?php echo json_encode(POPUP_SELECT_VEHICLEMODAL); ?>);
                return false;
            } else if (vimage == "" || vimage == null)
            {
                $("#ve_make").text("");
                $("#v_modal").text("");
                $("#v_image").text(<?php echo json_encode(POPUP_SELECT_VEHICLEIMAGE); ?>);
                return false;
            }
        });


        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });

        var date = new Date();
        $('.datepicker-component').datepicker({
            startDate: date
        });

        $(document).on('click', '.RemoveMore', function ()
        {
            $('#' + $(this).attr('data-id')).attr('checked', false);
            $('#RemoveControl' + $(this).attr('data-id')).remove();
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
                    case "imagefiles":
                        type = 1;
                        folderName = 'VehicleImage';
                        break;
                    case "regcertificate":
                        type = 2;
                        folderName = 'VehicleDocuments';
                        break;
                    case "motorcertificate":
                        type = 3;
                        folderName = 'VehicleDocuments';
                        break;
                    default :
                        type = 4;
                        folderName = 'VehicleDocuments';

                }

                var formElement = $(this).prop('files')[0];
                var form_data = new FormData();

                form_data.append('OtherPhoto', formElement);
                form_data.append('type', 'Vehicles');
                form_data.append('folder', folderName);
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/superadmin/upload_images_on_amazon",
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
                                $('#vehicleImage').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                $('.vehicleImage').attr('src','<?php echo AMAZON_URL;?>'+result.fileName);
                                $('.vehicleImage').show();
                                break;
                            case 2:
                                $('#registationCertificate').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                $('.registationCertificate').attr('src','<?php echo AMAZON_URL;?>'+result.fileName);
                                $('.registationCertificate').show();
                                break;
                            case 3:
                                $('#motorCertificate').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                $('.motorCertificate').attr('src','<?php echo AMAZON_URL;?>'+result.fileName);
                                $('.motorCertificate').show();
                                break;
                            case 4:
                                $('#PermitCertificate').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                $('.PermitCertificate').attr('src','<?php echo AMAZON_URL;?>'+result.fileName);
                                $('.PermitCertificate').show();
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
        });

        $('.vehicles').addClass('active');
        $('.vehicles_thumb').addClass("bg-success");


        $('#company_select').change(function () {
            $('#operatorName').val($('#company_select option:selected').attr('operator'));
//              $('#selected_driver').load('<?php echo base_url() ?>index.php?/superadmin/ajax_call_to_get_types/driverselect', {company_id: $('#company_select').val()});

        });
        $('#getvechiletype').change(function () {
            html = '';
            $('#checkboxes').empty();
            $('.selectedGood').remove();

            $('#vehicleTypeName').val($('#getvechiletype option:selected').attr('typeName'));
            $.ajax({
                dataType: "json",
                type: 'POST',
                url: "<?= base_url() ?>index.php?/superadmin/ajax_call_to_get_types/getGoodTypes",
                data: {vehicleTypeID: $('#getvechiletype').val()},
                async: false,
                success: function (result) {

                    $.each(result.allGoodTypes, function (index, response)
                    {

                        if ($.inArray(response._id.$oid, result.vehicleTypGoodTypes) !== -1)
                        {
                            html += '<label for="' + response._id.$oid + '">';
                            html += '<input type="checkbox" class="checkbox1" name="goodType[]" id="' + response._id.$oid + '" goodType="' + response.name + '" value="' + response._id.$oid + '"/>' + response.name;
                            html += ' </label>';
                        }
                    });

                    $('#checkboxes').append(html);

                }
            });
        });


        $('#selected_driver').change(function () {
            $('#driverName').val($('#selected_driver option:selected').attr('driverName'));
            $('#driverMobile').val($('#selected_driver option:selected').attr('driverMobile'));


        });


        $('#vehiclemake').change(function () {
            $('#vehicleMakeName').val($('#vehiclemake option:selected').attr('name'));
            $('#vehiclemodel').load('<?php echo base_url() ?>index.php?/superadmin/ajax_call_to_get_types/vmodel', {adv: $('#vehiclemake').val()});
        });

        $('#vehiclemodel').change(function () {
            $('#vehicleModelName').val($('#vehiclemodel option:selected').attr('name'));

        });

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });

    });

    function platNoValidationCheck(email)
    {
        var status = '1';
        var returnStatus;
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/superadmin/licenceplaetno",
            type: "POST",
            data: {licenceplaetno: $('#licenceplaetno').val()},
            dataType: "JSON",
            async: false,
            success: function (result) {

                $('#licenceplaetno').attr('data', result.msg);

                if (result.msg == '1') {

                    $("#vehicl_plate").html("Licence Number is already allocated !");
                    $('#licenceplaetno').focus();
                    returnStatus = true;

                } else if (result.msg == '0') {
                    $("#vehicl_plate").html("");
                    status = '0';
                    returnStatus = false;

                }
            }
        });

        return returnStatus;

    }

    function managebuttonstate()
    {
        $("#prevbutton").addClass("hidden");
    }

    function profiletab(litabtoremove, divtabtoremove)
    {
        var pstatus = true;


        $(".error-box").text("");

        $("#ve_compan").val('');
        $("#ve_city").val('');
        $("#ve_type").val('');
        $("#ve_make").val('');
        $("#v_modal").val('');
        $("#v_image").val('');
        $("#ve_id").val('');

        $("#ve_city").text('');

        var selectedOwnerType = $("#selectedOwnerType").val();

        var company = $("#company_select").val();
        var cityselect = $("#city_select").val();
        var vtype = $("#getvechiletype").val();
        var goodType = $('[name="goodType[]"]:checked').length;

        var vmake = $('#vehiclemake').val();
        var vmodal = $('#vehiclemodel').val();
        var vimage = $('#vehicleImage').val();
        var vehicleid = $("#vehicleid").val();
        var manual = $("input[name = entitystatus]:checked").val()
        var driver_select = $("#selected_driver").val();


        if ((company == "" && selectedOwnerType == 2))
        {
            $("#ve_compan").text(<?php echo json_encode(POPUP_ADDCOMPANY_NAME); ?>);
            pstatus = false;
        } else if (driver_select == "" && selectedOwnerType == 1)
        {
            $("#driver").text('Please select a driver');
            pstatus = false;
        } else if (vtype == "" || vtype == null)
        {
            $("#ve_type").text(<?php echo json_encode(POPUP_SELECT_TYPE); ?>);
            pstatus = false;
        } else if (goodType == 0)
        {
            $("#goodTypeErr").text('Please select atleast one good type');
            pstatus = false;
        } else if (manual == 2 && (vehicleid == "" || vehicleid == null))
        {
            $("#ve_type").text("");
            $("#ve_id").text(<?php echo json_encode(POPUP_SELECT_VEHICLEID); ?>);
            pstatus = false;
        } else if (vmake == "" || vmake == null)
        {
            $("#ve_type").text("");
            $("#ve_id").text("");
            $("#ve_make").text(<?php echo json_encode(POPUP_SELECT_VEHICLEMAKE); ?>);
            pstatus = false;
        } else if (vmodal == "" || vmodal == null)
        {
            $("#ve_make").text("");
            $("#v_modal").text(<?php echo json_encode(POPUP_SELECT_VEHICLEMODAL); ?>);
            pstatus = false;
        } else if (vimage == "" || vimage == null)
        {
            $("#ve_make").text("");
            $("#v_modal").text("");
            $("#v_image").text(<?php echo json_encode(POPUP_SELECT_VEHICLEIMAGE); ?>);
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

            $("#error-box").text("");

            $("#vehi_reg").val('');
            $("#vehicl_plate").val('');
            $("#ve_insurence").val('');
            $("#v_color").val('');


            var regno = $("#vechileregno").val();
            var licenseno = $("#licenceplaetno").val();

            var insurenceno = $("#Vehicle_Insurance_No").val();

            var vcolor = $('#vechilecolor').val();
            var isLicenseno = platNoValidationCheck(licenseno);
            var licensenoIsAllocated = $("#licenceplaetno").attr('data');

            if (regno == "" || regno == null)
            {
                $("#vehi_reg").text(<?php echo json_encode(POPUP_SELECT_VEHICLEREGNO); ?>);
                astatus = false;
            } else if (licenseno == "" || licenseno == null)
            {
                $("#vehi_reg").text("");

                $("#vehicl_plate").text(<?php echo json_encode(POPUP_SELECT_VEHICLEPLATENO); ?>);
                astatus = false;
            } else if (isLicenseno)
            {
                $("#vehi_reg").text("");
                $("#vehicl_plate").text('Licence Number is already allocated !');
                astatus = false;
            } else if (licensenoIsAllocated == "1")
            {
                $("#vehi_reg").text("");

                $("#vehicl_plate").text('Licence Number is already allocated !');
                astatus = false;
            } else if (insurenceno == "" || insurenceno == null)
            {
                $("#vehicl_plate").text("");
                $("#ve_insurence").text(<?php echo json_encode(POPUP_SELECT_VINSURENCENUMBER); ?>);
                astatus = false;
            }


//            else if (vcolor == "" || vcolor == null)
//            {
//                $("#ve_insurence").text("");
//                $("#v_color").text(<?php echo json_encode(POPUP_SELECT_VEHICLECOLOR); ?>);
//                astatus = false;
//            }


            if (astatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'secondlitab', 'tab2');

                }, 100);

                $("#tab2icon").removeClass("fs-14 fa fa-check");
                return false;

            }
            $("#tab2icon").addClass("fs-14 fa fa-check");
            $("#finishbutton").removeClass("hidden");
            $("#nextbutton").addClass("hidden");

            return astatus;
        }
    }




    function bonafidetab(litabtoremove, divtabtoremove)
    {
        var bstatus = true;
        if (addresstab(litabtoremove, divtabtoremove))
        {
//            if (isBlank($("#expirationrc").val()) || isBlank($("#expirationinsurance").val()) || isBlank($("#regcertificate").val()) || isBlank($("#motorcertificate").val()) || isBlank($("#contractpermit").val()) || isBlank($("#edate").val()))
//            {
//                bstatus = false;
//            }

            if (bstatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'thirdlitab', 'tab3');

                }, 100);

//                alert("complete Document tab properly");
                $("#tab3icon").removeClass("fs-14 fa fa-check");
                return false;
            }

            $("#tab3icon").addClass("fs-14 fa fa-check");
            $("#nextbutton").addClass("hidden");
            $("#finishbutton").removeClass("hidden");

            return bstatus;

        }
    }

    function signatorytab(litabtoremove, divtabtoremove)
    {
        var bstatus = true;
        if (bonafidetab(litabtoremove, divtabtoremove))
        {
            if (isBlank($("#regcertificate").val()) || isBlank($("#motorcertificate").val()) || isBlank($("#contractpermit").val()) || $("#entitydegination").val() === "null")
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

//                alert("complete 4 tab properly");
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


        var currenttabstatus = $("li.active").attr('id');
        if (currenttabstatus === "firstlitab")
        {
            profiletab('secondlitab', 'tab2');


            proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');
        } else if (currenttabstatus === "secondlitab")
        {

            bonafidetab('thirdlitab', 'tab3')


            proceed('secondlitab', 'tab2', 'thirdlitab', 'tab3');

        } else if (currenttabstatus === "thirdlitab")
        {
            bonafidetab('fourthlitab', 'tab4');
            proceed('thirdlitab', 'tab3', 'fourthlitab', 'tab4');
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
            $("#nextbutton").removeClass("hidden");
            $("#finishbutton").addClass("hidden");

//            $("#nextbutton").removeClass("hidden");
//            $("#finishbutton").addClass("hidden");
        }
////    else if(currenttabstatus === "fourthlitab")
////    {
////        bonafidetab('fourthlitab','tab4');
////        proceed('fourthlitab','tab4','thirdlitab','tab3');
////        $("#nextbutton").removeClass("hidden");
////        $("#finishbutton").addClass("hidden");
////    }
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
//
    function submitform()
    {


        $(".error-box").text("");

        $("#v_upload_cr").val('');
        $("#ve_expire").val('');
        $("#vehicle_uploadmotor").val('');
        $("#expire_insurence_date").val('');
        $("#vehicle_up_carrp").val('');
        $("#vehicle_expire_date").val('');

        var regcertificate = $("#registationCertificate").val();
        var expirerc = $("#expirationrc").val();
        var motorcertificate = $("#motorCertificate").val();
        var expiremotor = $("#expirationinsurance").val();

        var carriagepermit = $("#PermitCertificate").val();
        var date = $("#date").val();
        var entitydegnation = $("#entitydegination").val();
        var edate = $("#edate").val();


        if (regcertificate == "" || regcertificate == null)
        {
            $("#v_upload_cr").text(<?php echo json_encode(POPUP_SELECT_VEHICLEUPLOADREGNO); ?>);

        } else if (expirerc == "" || expirerc == null)
        {

            $("#v_upload_cr").text("");
            $("#ve_expire").text(<?php echo json_encode(POPUP_SELECT_VEHICLE_DATE); ?>);

        } else if (motorcertificate == "" || motorcertificate == null)
        {
            $("#ve_expire").text("");

            $("#vehicle_uploadmotor").text(<?php echo json_encode(POPUP_SELECT_VINSURENCENUMBER_INSURENCE); ?>);

        } else if (expiremotor == "" || expiremotor == null)
        {
            $("#vehicle_uploadmotor").text("");

            $("#expire_insurence_date").text(<?php echo json_encode(POPUP_SELECT_VEHICLE_DATE); ?>);

        } else if (carriagepermit == "" || carriagepermit == null)
        {
            $("#expire_insurence_date").text("");
            $("#vehicle_up_carrp").text(<?php echo json_encode(POPUP_SELECT_VEHICLECOLOR_CARRIAGE_PERMIT); ?>);

        } else if (edate == "" || edate == null)
        {
            $("#vehicle_up_carrp").text("");
            $("#vehicle_expire_date").text(<?php echo json_encode(POPUP_SELECT_VEHICLE_DATE); ?>);
            return false;
        } else {
            $('#addentity').submit();
        }

    }


    function changeType(dis) {
        if (dis.value == 1) {
            $('#vehicleid').hide();
            $('#ve_id').html('');
        } else
            $('#vehicleid').show();
    }


</script>


<div class="page-content-wrapper">
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb" style="margin-left: 0px; margin-top: 5%;">
        <li><a
                href="<?php echo base_url('index.php?/superadmin') ?>/Vehicles/1"
                class=""><?php echo LIST_VEHICLE; ?></a></li>

        <li style="width: 100px"><a href="#" class="active"><?php echo LIST_VEHICLE_ADD; ?></a>
        </li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="bg-white" data-pages="parallax">

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                    <!-- Nav tabs -->
                    <ul
                        class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm"
                        id="mytabs">
                        <li class="active tabs_active" id="firstlitab"
                            onclick="managebuttonstate()"><a data-toggle="tab" href="#tab1"
                                                         id="tb1"><i id="tab1icon" class=""></i> <span><?php echo LIST_VEHICLE_VEHICLESETUP; ?></span></a>
                        </li>
                        <li class="tabs_active" id="secondlitab"><a data-toggle="tab"
                                                                    href="#tab2" onclick="profiletab('secondlitab', 'tab2')"
                                                                    id="mtab2"><i id="tab2icon" class=""></i> <span><?php echo LIST_VEHICLE_DETAILS; ?></span></a>
                        </li>
                        <li class="tabs_active" id="thirdlitab"><a data-toggle="tab"
                                                                   href="#tab3" onclick="addresstab('thirdlitab', 'tab3')"><i
                                    id="tab3icon" class=""></i> <span><?php echo LIST_VEHICLE_DOCUMETS; ?></span></a>
                        </li>

                    </ul>
                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form"
                          action="<?php echo base_url(); ?>index.php?/superadmin/AddNewVehicleData/1"
                          method="post" enctype="multipart/form-data">
                        <div class="tab-content">
                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">


                                    <div class="form-group" class="formexx">
                                        <label for="address" class="col-sm-2 control-label">Ownership
                                            Type<span style="" class="MandatoryMarker"> *</span>
                                        </label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-5">
                                                <input type="radio" class="radio-success"
                                                       name="OwnershipType" id="Operator" value="2" checked> <label>Operator</label>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="radio" class="radio-success"
                                                       name="OwnershipType" id="Freelancer" value="1"> <label>Freelancer</label>
                                            </div>
                                        </div>
                                        <input type="hidden" id="selectedOwnerType"
                                               name="selectedOwnerType" value="2">

                                        <div class="col-sm-3 error-box" id="companyname"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label">Operator
                                            Name<span style="" class="MandatoryMarker"> *</span>
                                        </label>
                                        <div class="col-sm-6">


                                            <select id="company_select" name="company_select"
                                                    class="form-control error-box-class">
                                                <option value="">Select a Company</option>

                                            </select> <input type="hidden" id="operatorName"
                                                             name="operatorName">

                                        </div>
                                        <div class="col-sm-3 error-box" id="ve_compan"></div>

                                    </div>

                                    <div class="form-group driverList">
                                        <label for="fname" class="col-sm-2 control-label">Driver Name<span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <select id="selected_driver" name="selected_driver"
                                                    class="form-control error-box-class">

                                                <option value="">Select</option>

                                            </select>
                                        </div>
                                        <input type="hidden" id="driverName" name="driverName"> <input
                                            type="hidden" id="driverMobile" name="driverMobile">
                                        <div class="col-sm-3 error-box" id="driver"></div>
                                    </div>


                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_VEHICLETYPE; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <select id="getvechiletype" name="getvechiletype"
                                                    class="form-control error-box-class">
                                                <option value="">Select</option>
                                                <?php
                                                foreach ($vehicleTypes as $each) {
                                                    echo "<option value='" . $each['_id']['$oid'] . "' typeName='" . $each['type_name'] . "'>" . $each['type_name'] . "</option>";
                                                }
                                                ?>

                                            </select> <input
                                                type="hidden" id="vehicleTypeName" name="vehicleTypeName">
                                        </div>

                                        <div class="col-sm-3 error-box" id="ve_type"></div>
                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Good Types<span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <div class="multiselect">
                                                <div class="selectBox " onclick="showCheckboxes()">
                                                    <select class="form-control">
                                                        <option>Select an option</option>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>
                                                <div id="checkboxes"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 error-box" id="goodTypeErr"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-6">
                                            <div class="selectedGoodType"
                                                 style="border-style: groove; min-height: 70px; padding: 6px;"></div>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_VEHICLEMAKE; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">


                                            <select id="vehiclemake" name="title"
                                                    class="form-control error-box-class">

                                                <option value="">Select</option>
                                                <?php
                                                foreach ($vehiclemake as $each) {
                                                    echo "<option value='" . $each['_id']['$oid'] . "' id='" . $each['_id']['$oid'] . "' name='" . $each['Name'] . "'>" . $each['Name'] . "</option>";
                                                }
                                                ?>


                                            </select> <input
                                                type="hidden" id="vehicleMakeName" name="vehicleMakeName">
                                        </div>

                                        <div class="col-sm-3 error-box" id="ve_make"></div>
                                    </div>



                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_VEHICLEMODEL; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <select id="vehiclemodel" name="vehiclemodel"
                                                    class="form-control error-box-class">

                                                <option value="">Select</option>

                                            </select> <input type="hidden" id="vehicleModelName"
                                                             name="vehicleModelName">
                                        </div>

                                        <div class="col-sm-3 error-box" id="v_modal"></div>
                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_IMAGE; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="file" class="form-control error-box-class" style="height: 37px;" name="imagefile" id="imagefiles"> 
                                            <input type="hidden" class="form-control error-box-class"  name="vehicleImage" id="vehicleImage">
                                        </div>
                                        <div class="col-sm-1"><img src="" style="width: 35px;height:35px;display:none;" class="vehicleImage style_prevu_kit"></div>
                                        <div class="col-sm-2 error-box" id="v_image"></div>
                                    </div>


                                </div>
                            </div>
                            <div class="tab-pane slide-left padding-20" id="tab2">
                                <div class="row row-same-height">

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_REGNO; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="vechileregno" name="vechileregno"
                                                   required="required" class="form-control error-box-class">

                                        </div>

                                        <div class="col-sm-3 error-box" id="vehi_reg"></div>
                                    </div>




                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_PLATENO; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="licenceplaetno" name="licenceplaetno"
                                                   required="required" class="form-control error-box-class"
                                                   placeholder="eg. KA-05/1800">
                                        </div>

                                        <div class="col-sm-3 error-box" id="vehicl_plate"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_INSURENCE; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control error-box-class"
                                                   id="Vehicle_Insurance_No" name="Vehicle_Insurance_No"
                                                   required="required" placeholder="eg. PL-23111441">
                                        </div>

                                        <div class="col-sm-3 error-box" id="ve_insurence"></div>
                                    </div>

                                </div>
                            </div>


                            <div class="tab-pane slide-left padding-20" id="tab3">
                                <div class="row row-same-height">

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_UPLOADCR; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="hidden" class="form-control error-box-class"
                                                   style="height: 37px;" name="registationCertificate"
                                                   id="registationCertificate"> <input type="file"
                                                   class="form-control error-box-class" style="height: 37px;"
                                                   name="certificate" id="regcertificate">
                                        </div>
                                        <div class="col-sm-1"><img src="" style="width: 35px;height:35px;display:none;" class="registationCertificate style_prevu_kit"></div>
                                        <div class="col-sm-2 error-box" id="v_upload_cr"></div>
                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_EXPIREDATE; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input id="expirationrc" name="expirationrc"
                                                   required="required" type=""
                                                   class="form-control error-box-class datepicker-component">
                                        </div>

                                        <div class="col-sm-3 error-box" id="ve_expire"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_UPLOADMOTOR; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="file" class="form-control error-box-class"
                                                   style="height: 37px;" name="insurcertificate"
                                                   id="motorcertificate"> <input type="hidden"
                                                   class="form-control error-box-class" style="height: 37px;"
                                                   name="motorCertificate" id="motorCertificate">
                                        </div>
                                        <div class="col-sm-1"><img src="" style="width: 35px;height:35px;display:none;" class="motorCertificate style_prevu_kit"></div>
                                        <div class="col-sm-3 error-box" id="vehicle_uploadmotor"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_EXPIREDATE; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input id="expirationinsurance" name="expirationinsurance"
                                                   required="required" type=""
                                                   class="form-control error-box-class datepicker-component">
                                        </div>

                                        <div class="col-sm-3 error-box" id="expire_insurence_date"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_UPLOADCP; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="file" class="form-control error-box-class"
                                                   name="carriagecertificate" id="contractpermit"> <input
                                                   type="hidden" class="form-control error-box-class"
                                                   style="height: 37px;" name="PermitCertificate"
                                                   id="PermitCertificate">
                                        </div>
                                        <div class="col-sm-1"><img src="" style="width: 35px;height:35px;display:none;" class="PermitCertificate style_prevu_kit"></div>
                                        <div class="col-sm-3 error-box" id="vehicle_up_carrp"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo FIELD_VEHICLE_EXPIREDATE; ?><span
                                                style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type=""
                                                   class="form-control error-box-class datepicker-component"
                                                   style="height: 37px;" name="expirationpermit" id="edate">
                                        </div>

                                        <div class="col-sm-3 error-box" id="vehicle_expire_date"></div>
                                    </div>

                                </div>
                            </div>

                            <div class="padding-20 bg-white col-sm-9">
                                <ul class="pager wizard ">
                                    <li class="next" id="nextbutton">
                                        <button class="btn btn-primary pull-right" type="button"
                                                onclick="movetonext()">
                                            <span>Next</span>
                                        </button>
                                    </li>
                                    <li class="hidden" id="finishbutton">
                                        <button class="btn btn-primary pull-right" type="button"
                                                onclick="submitform()">
                                            <span>Finish</span>
                                        </button>
                                    </li>

                                    <li class="previous hidden" id="prevbutton">
                                        <button class="btn btn-default pull-right" type="button"
                                                onclick="movetoprevious()">
                                            <span>Previous</span>
                                        </button>
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



<div class="modal fade stick-up" id="confirmmodels" tabindex="-1"
     role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">
                        <i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas"
                         style="font-size: large; text-align: center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-primary pull-right"
                                id="confirmeds"><?php echo BUTTON_OK; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade stick-up" id="confirmmodelss" tabindex="-1"
     role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">
                        <i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatass"
                         style="font-size: large; text-align: center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-primary pull-right"
                                id="confirmedss"><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

