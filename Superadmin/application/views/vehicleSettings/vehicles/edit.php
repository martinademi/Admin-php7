<link href="application/views/vehicleSettings/vehicles/styles.css" rel="stylesheet" type="text/css">
<!--<script type="text/javascript" src="https://www.carqueryapi.com/js/carquery.0.3.4.js"></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />

<style>
    #selectPreferencesDiv label{
        display: block;
    }
    #selectPreferencesDiv {
        display: none;
        border: 1px #dadada solid;
    }
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('<?php echo base_url(); ?>pics/pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
        opacity: .8;
    }
    #divLoading
    {
        display : block;
        position : fixed;
        z-index: 100;
        background-image : url('<?php echo base_url(); ?>pics/pageLoader.gif');
        background-color:#666;
        opacity : 0.4;
        background-repeat : no-repeat;
        background-position : center;
        left : 0;
        bottom : 0;
        right : 0;
    }
</style>
<script type="text/javascript">
    var selectedVehiclePreferences = [];
    var expanded3 = false;
    function showPreferences() {
        var checkboxes = document.getElementById("selectPreferencesDiv");
        if (!expanded3) {
            checkboxes.style.display = "block";
            expanded3 = true;
        } else {
            checkboxes.style.display = "none";
            expanded3 = false;
        }
    }


</script>
<?php
$goodTypesAll = array();
foreach ($speciality_data as $googType) {
    $goodTypesAll[$googType['_id']['$oid']] = $googType['speciality']['en'];
}

$allVehicleTypeGoodTypes = array();
foreach ($vehicleTypes as $vType) {

    if ($vType['_id']['$oid'] == $vehicleData['typeId']['$oid']) {

        $allVehicleTypeGoodTypes = $vType['goodTypes'];
        break;
    }
}
?>
<script>
    var htmlDriverList;
    var idNum = 0;
    var coutryCode;

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

    var expanded1 = false;
    function businessTypeCheckboxes() {
        var checkboxes = document.getElementById("businessType");
        if (!expanded1) {
            checkboxes.style.display = "block";
            expanded1 = true;
        } else {
            checkboxes.style.display = "none";
            expanded1 = false;
        }
    }
    $(document).ready(function () {
        $('.selectpicker').selectpicker();

        $('#car-years').change(function () {

            $('#car-makes').html('<option value="" disabled selected>Select</option>');
            $('#car-models').html('<option value="" disabled selected>Select</option>');
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url() ?>index.php?/vehicle/ajax_call_to_get_types/vmake",
                data: {adv: $('#car-years').val()},
                success: function (result) {
                    $('#car-makes').html(result);
                    if ('<?= $vehicleData['year'] ?>' == $('#car-years').val()) {
                        $('#car-makes').val('<?= $vehicleData['makeId']['$oid'] ?>');
                        $('#car-makes').trigger('change');
                    }
                }
            });
        });
        $('#car-makes').change(function () {
            $('#vehicleMakeId').val($('#car-makes option:selected').val());
            $('#vehicleMakeName').val($('#car-makes option:selected').attr('name'));

            $('#car-models').html('<option value="" disabled selected>Select</option>');
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url() ?>index.php?/vehicle/ajax_call_to_get_types/vmodel",
                data: {adv: $('#car-makes').val(), year: $('#car-years').val()},
                success: function (result) {
                    $('#car-models').html(result);
                    $('#car-models').val('<?= $vehicleData['modelId']['$oid'] ?>');
                }
            });
        });
        $('#car-models').change(function () {
            $('#vehicleModelId').val($('#car-models option:selected').val());
            $('#vehicleModelName').val($('#car-models option:selected').attr('name'));
        });
        $('#car-years').trigger('change');

        showCheckboxes();
        businessTypeCheckboxes();
        $('#selected_driver').empty();
        $('.selectDriverTag').empty();
        htmlDriverList = '';
        htmlDriverList += '<select id="selected_driver" required="" name="selected_driver" class="form-control error-box-class selectpicker" data-live-search="true"><option data-tokens="" value="">Select</option>';
<?php
foreach ($driversList as $driver) {
    ?>

            id = '<?php echo $driver['_id']['$oid']; ?>'
            name = '<?php echo trim($driver['firstName']) . ' ' . trim($driver['lastName']) . ' | ' . $driver['email'] . ' | ' . $driver['phone']['countryCode'] . $driver['phone']['phone']; ?>';

            htmlDriverList += '<option value="' + id + '"  data-tokens="' + name + '">' + name + '</option>';

    <?php
}
?>
        htmlDriverList += ' </select>';
        $('.selectDriverTag').append(htmlDriverList);
        $('#selected_driver').val('<?php echo $vehicleData['masterId']['$oid']; ?>');
        $('.selectpicker').selectpicker();


        var inspectionReport = '<?php echo $vehicleData['inspectionReport']; ?>';
        if (inspectionReport != '')
            $('.PermitCertificate').show();
        else
            $('.PermitCertificate').hide();

        var goodsInTransit = '<?php echo $vehicleData['goodsInTransit']; ?>';
        if (goodsInTransit != '')
            $('.goodsInTransit-img').show();
        else
            $('.goodsInTransit-img').hide();

        //Set the color
        $('#color').val('<?php echo $vehicleData['colour']; ?>');



        $(document).on('click', '.checkbox1', function ()
        {
            $('.selectedGoodType').show();
            if ($(this).is(":checked"))
            {
                $('.selectedGoodType').append('<span class="selectedGood" id="RemoveControl' + $(this).attr('id') + '"><input readonly type="text" class="inputCheckbox" value="' + $(this).attr('goodType') + '"><input type="button"  value="&#10008" data-id="' + $(this).attr('id') + '" class="RemoveMore">')
                $('#goodType').val($(this).attr('id'));
            } else {
                RemoveMore($(this).attr('id'));
            }
        });
        $(document).on('click', '.RemoveMore', function ()
        {
            $('#' + $(this).attr('data-id')).attr('checked', false);
            $('#RemoveControl' + $(this).attr('data-id')).remove();
        });

        var accType = '<?php echo $vehicleData['accountType']; ?>';
        var company = '<?php echo $vehicleData['operatorId']['$oid']; ?>';


        $('#operatorName').val('<?php echo $vehicleData['operatorName']; ?>');
        $('#driverName').val('<?php echo $vehicleData['driverName']; ?>');
        $('#driverMobile').val('<?php echo $vehicleData['driverMobile']; ?>');
        $('#vehicleTypeName').val('<?php echo $vehicleData['typeName']; ?>');
        $('#vehicleMakeName').val('<?php echo $vehicleData['make']; ?>');
        $('#vehicleMakeId').val('<?php echo $vehicleData['vehicle']['makeId']['$oid']; ?>');
        $('#vehicleModelId').val('<?php echo $vehicleData['vehicle']['modelId']['$oid']; ?>');
        $('#vehicleModelName').val('<?php echo $vehicleData['model']; ?>');

        if (accType == 2)
        {

            $('#Operator').attr('checked', true);
            $('#company_select').val(company);
            $('#selected_driver').val('');
            $('.operatorList').show();
            $('.driverList').hide();
        } else
        {

            $('#selected_driver').prop('disabled', false);
            $('.driverList').show();
            $('#Freelancer').attr('checked', true);
            $('.operatorList').hide();
        }
        $('#selectedOwnerType').val(accType);
        $('#goodType').val('<?php echo $vehicleData['goodTypes']; ?>')
        $('#getvechiletype').val('<?php echo $vehicleData['typeId']['$oid']; ?>');
        $('#city').trigger('change');
    });
</script>

<script>


    $(document).ready(function () {
        $(".loader").fadeOut("slow");
        //show selected good types
<?php
foreach ($allVehicleTypeGoodTypes as $vType) {
    if (in_array($vType, $vehicleData['goodTypes'])) {
        ?>
                goodTypeID = '<?php echo $vType; ?>';
                goodType = '<?php echo $goodTypesAll[$vType]; ?>';

                $('.selectedGoodType').append('<span class="selectedGood" id="RemoveControl' + goodTypeID + '"><input readonly type="text" class="inputCheckbox" value="' + goodType + '"><input type="button" value="&#10008" data-id="' + goodTypeID + '" class="RemoveMore">')
        <?php
    } else {
        
    }
}
?>

<?php
foreach ($vehicleData['services'] as $services) {
    ?>
            var businessType = '<?php echo $services['serviceType'] ?>';

            if (parseInt(businessType) == 2)
            {
                $('.selectedGoodType').hide();
                $('.goodTypeDiv').hide();
            } else
            {
                $('.goodTypeDiv').show();
                $('.selectedGoodType').show();
            }
    <?php
}
?>

        $(document).on('click', '.deliveryCheckobx', function () {

            if ($(this).is(':checked')) {
                $('.goodTypeDiv').show();
                $('.selectedGoodType').show();
            } else
            {
                $('.goodTypeDiv').hide();
                $('.selectedGoodType').hide();
                $('.checkbox1').prop('checked', false);
                $('.selectedGoodType').empty();
            }
        })


        $(":file").on("change", function (e) {
            var fieldID = $(this).attr('id');
            var ext = $(this).val().split('.').pop().toLowerCase();
            if ($(this).attr('id') == "imagefiles")
                var fileTypesArr = ['gif', 'png', 'jpg', 'jpeg'];
            else
                var fileTypesArr = ['gif', 'png', 'jpg', 'jpeg', 'pdf'];
            if ($.inArray(ext, fileTypesArr) == -1) {
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
                    case "goodsInTransit":
                        type = 5;
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
                    url: "<?php echo base_url() ?>index.php?/vehicle/uploadImage",
                    type: "POST",
                    data: form_data,
                    dataType: "JSON",
//                    async: false,
                    beforeSend: function () {
                        $(".loader").fadeIn("slow");
                    },
                    success: function (result) {
                        $(".loader").fadeOut("slow");
                        switch (type)
                        {
                            case 1:
                                $('#vehicleImage').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                $('.vehicleImage').show();
                                $('.vehicleImage').attr('src', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                break;
                            case 2:
                                $('#registationCertificate').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                $('.registrationCertImageDiv').empty();
                                $('.registrationCertImageDiv').html('<a target="_blank" class="href_registrationCertImage" href="' + '<?php echo AMAZON_URL; ?>' + result.fileName + '" style="text-decoration:underline"></a>');

                                if (ext === "pdf") {
                                    $('.href_registrationCertImage').text('PDF');
                                } else {
                                    $('.href_registrationCertImage').html('<img style="width: 35px;height:35px;" class="style_prevu_kit" src="<?php echo AMAZON_URL; ?>' + result.fileName + '">');
                                }
                                break;
                            case 3:
                                $('#motorCertificate').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                $('.motorInsuImageDiv').empty();
                                $('.motorInsuImageDiv').html('<a target="_blank" class="href_motorInsuImage" href="' + '<?php echo AMAZON_URL; ?>' + result.fileName + '" style="text-decoration:underline"></a>');

                                if (ext === "pdf") {
                                    $('.href_motorInsuImage').text('PDF');
                                } else {
                                    $('.href_motorInsuImage').html('<img style="width: 35px;height:35px;" class="style_prevu_kit" src="<?php echo AMAZON_URL; ?>' + result.fileName + '">');
                                }
                                break;
                            case 4:
                                $('#PermitCertificate').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                $('.inspectionReportDiv').empty();
                                $('.inspectionReportDiv').html('<a target="_blank" class="href_inspectionReport" href="' + '<?php echo AMAZON_URL; ?>' + result.fileName + '" style="text-decoration:underline"></a>');

                                if (ext === "pdf") {
                                    $('.href_inspectionReport').text('PDF');
                                } else {
                                    $('.href_inspectionReport').html('<img style="width: 35px;height:35px;" class="style_prevu_kit" src="<?php echo AMAZON_URL; ?>' + result.fileName + '">');
                                }
                                break;
                            case 5:
                                $('#goodsInTransit-img').val('<?php echo AMAZON_URL; ?>' + result.fileName);

                                $('.goodsInTransitDiv').empty();
                                $('.goodsInTransitDiv').html('<a target="_blank" class="href_goodsInTransit" href="' + '<?php echo AMAZON_URL; ?>' + result.fileName + '" style="text-decoration:underline"></a>');

                                if (ext === "pdf") {
                                    $('.href_goodsInTransit').text('PDF');
                                } else {
                                    $('.href_goodsInTransit').html('<img style="width: 35px;height:35px;" class="style_prevu_kit" src="<?php echo AMAZON_URL; ?>' + result.fileName + '">');
                                }

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

        var date = new Date();
        var nextThreeMonth = new Date(new Date().getTime() + (90 * 24 * 60 * 60 * 1000))
        var nextSixMonth = new Date(new Date().getTime() + (180 * 24 * 60 * 60 * 1000))
        $('.datepicker-component').datepicker({
            startDate: date,
//            endDate: nextThreeMonth
        });

        $('.datepicker-component2').datepicker({
            startDate: date,
//            endDate: nextSixMonth
        });

        $('.datepicker-component1').datepicker({
            endDate: date,
        });

        $('.datepicker-component1').on('changeDate', function () {
            $(this).datepicker('hide');
        });
        $('.datepicker-component2').on('changeDate', function () {
            $(this).datepicker('hide');
        });
        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });


        var preferenceSelected = '<?= $vehicleData['vehiclePreference']; ?>';


        $.ajax({
            dataType: "json",
            type: 'POST',
            url: "<?= base_url() ?>index.php?/vehicle/getPreferenceSelected",
            data: {vehicleId: '<?php echo $vehicleData['_id']['$oid']; ?>', vehicleTypeId: '<?php echo $vehicleData['typeId']['$oid']; ?>'},
            async: false,
            success: function (result) {
                selectedVehiclePreferences = result.vehiclePreference;

                html = '';
                $.each(result.bookingPreferences, function (index, value) {
                    if ($.inArray(value._id.$oid, result.vehiclePreference) !== -1) {
                        html += '<label for="preference_' + value._id.$oid + '">';
                        html += '<input type="checkbox" checked="" class="preference" name="preference[]" id="preference_' + value._id.$oid + '"  value="' + value._id.$oid + '"/>' + value.name.en;
                        html += ' </label>';
                    } else {
                        html += '<label for="preference_' + value._id.$oid + '">';
                        html += '<input type="checkbox" class="preference" name="preference[]" id="preference_' + value._id.$oid + '"  value="' + value._id.$oid + '"/>' + value.name.en;
                        html += ' </label>';
                    }
                });
                $('#selectPreferencesDiv').append(html);
                showPreferences();

            }
        });

        $('#getvechiletype').change(function () {

            html = '';
            $('#checkboxes').empty();
            $('#businessType').empty();
            $('.selectedGood').remove();
            $('.goodTypeDiv').hide();
            $('.selectedGoodType').hide();
            $('#selectPreferencesDiv').empty();

            $('#vehicleTypeName').val($('#getvechiletype option:selected').attr('typeName'));

            selectedCity = $('#city option:selected').val();
            $.ajax({
                dataType: "json",
                type: 'POST',
                url: "<?= base_url() ?>index.php?/vehicle/ajax_call_to_get_types/getGoodTypes",
                data: {vehicleTypeID: $('#getvechiletype').val(), cityId: $('#city').val()},
                async: false,
                success: function (result) {

                    $.each(result.allGoodTypes, function (index, response)
                    {

                        if ($.inArray(response._id.$oid, result.vehicleTypGoodTypes) !== -1)
                        {
                            html += '<label for="' + response._id.$oid + '">';
                            html += '<input type="checkbox" class="checkbox1" name="goodType[]" id="' + response._id.$oid + '" goodType="' + response.speciality.en + '" value="' + response._id.$oid + '"/>' + response.speciality.en;
                            html += ' </label>';
                        }
                    });
                    $('#checkboxes').append(html);


                    html = '';
                    $.each(result.vehiclePreference, function (index, value) {
                        if ($.inArray(value._id.$oid, selectedVehiclePreferences) !== -1) {
                            html += '<label for="preference_' + value._id.$oid + '">';
                            html += '<input type="checkbox" checked="" class="preference" name="preference[]" id="preference_' + value._id.$oid + '"  value="' + value._id.$oid + '"/>' + value.name.en;
                            html += ' </label>';
                        } else {
                            html += '<label for="preference_' + value._id.$oid + '">';
                            html += '<input type="checkbox" class="preference" name="preference[]" id="preference_' + value._id.$oid + '"  value="' + value._id.$oid + '"/>' + value.name.en;
                            html += ' </label>';
                        }
                    });
                    $('#selectPreferencesDiv').append(html);

                    html = '';
                    //Business Type
                    $('#businessType').empty();
                    $.each(result.vehicleTypePrice, function (index, response)
                    {
                        if (response.cityId == selectedCity)
                        {
                            if (response.ride.isEnabled) {
                                html += '<label for="' + response.ride._id.$oid + '">';
                                html += '<input type="checkbox" class="businessTypeCheckbox" businessTypeName="Ride" name="businessType[]" id="' + response.ride._id.$oid + '"  value="' + response.ride._id.$oid + '"/> Ride';
                                html += ' </label>';
                            }
                            if (response.delivery.isEnabled) {
                                html += '<label for="' + response.delivery._id.$oid + '">';
                                html += '<input type="checkbox" class="businessTypeCheckbox deliveryCheckobx" businessTypeName="Delivery" name="businessType[]" id="' + response.delivery._id.$oid + '"  value="' + response.delivery._id.$oid + '"/> Courier';
                                html += ' </label>';
                            }
                            if (response.towtruck && response.towtruck.isEnabled) {
                                html += '<label for="' + response.towtruck._id.$oid + '">';
                                html += '<input type="checkbox" class="businessTypeCheckbox towtruckCheckobx" businessTypeName="Towtruck" name="businessType[]" id="' + response.towtruck._id.$oid + '"  value="' + response.towtruck._id.$oid + '"/> Towtruck';
                                html += ' </label>';
                            }
                        }
                    });
                    $('#businessType').append(html);
                    businessTypeCheckboxes();

                }
            });
        });

        //city changed
        $('#city').change(function () {

            $('#businessType').empty();
            $('.selectedGood').remove();
            $('.goodTypeDiv').hide();
            $('.selectedGoodType').hide();
            $('.checkbox1').attr('checked', false);
            $('#getvechiletype').empty();


            html = '';
            $('#selected_driver').empty();
            $('.selectDriverTag').empty();
            html += '<select id="selected_driver" required="" name="selected_driver" class="form-control error-box-class selectpicker" data-live-search="true"><option data-tokens="" value="">Select</option>';

            if ($('#city').val() != '') {
                $.ajax({
                    dataType: "json",
                    type: 'POST',
                    url: "<?= base_url() ?>index.php?/vehicle/vehicleOperations/getCityDrivers",
                    data: {cityId: $('#city').val()},
                    async: false,
                    success: function (result) {
                        //------------DRIVERS----------


                        // $.each(result.drivers, function (index, response)
                        // {
                        //     html += '<option data-tokens="' + response.email + ' ' + response.phone.phone + ' ' + response.firstName + '" value="' + response._id.$oid + '">' + response.firstName + ' ' + response.lastName + ' | ' + response.email + ' | ' + response.phone.countryCode + response.phone.phone + '</option>'


                        // });

                        $.each(result.drivers, function (index, response)
                        {
                            html += '<option   value="' + response._id.$oid + '">' + response.firstName + ' ' + response.lastName + ' | ' + response.email + ' | ' + response.countryCode + response.mobile + '</option>'


                        });

                        html += ' </select>';
                        $('.selectDriverTag').append(html);
                        $('.selectpicker').selectpicker();

                        //------------VEHICLE TYPES----------
                        html = '';

                        html += '<option>Select</option>';
                        $.each(result.vehicleTypes, function (index, response)
                        {
                            html += '<option value="' + response._id.$oid + '">' + response.typeName.en + '</option>'


                        });
                        $('#getvechiletype').append(html);
                    }
                });
            } else {
                html += ' </select>';
                $('.selectDriverTag').append(html);
                $('.selectpicker').selectpicker();
            }


            //---------------------------------------------

        });

        $('#vehiclemake').change(function () {
            $('#vehicleMakeName').val($('#vehiclemake option:selected').attr('name'));
            $('#vehiclemodel').load('<?php echo base_url() ?>index.php?/vehicle/ajax_call_to_get_types/vmodel', {adv: $('#vehiclemake').val()});
        });

        $('#vehiclemodel').change(function () {
            $('#vehicleModelName').val($('#vehiclemodel option:selected').attr('name'));

        });
        $('#cancelbutton').click(function () {
            window.location = "<?php echo base_url(); ?>index.php?/vehicle/Vehicles/1";
        })
    });


    function managebuttonstate()
    {

        $("#prevbutton").addClass("hidden");
        $("#cancelbutton").removeClass("hidden");
        $("#nextbutton").removeClass("hidden");
        $("#finishbutton").addClass("hidden");
    }

    function profiletab(litabtoremove, divtabtoremove)
    {
//        alert('in profiletab');
        var pstatus = true;

        $("#error-box").text("");

        $("#cityErr").text('');
        $("#ve_compan").val('');
        $("#ve_city").val('');
        $("#ve_type").val('');
        $("#ve_make").val('');
        $("#v_modal").val('');
        $("#v_image").val('');
        $("#vehi_reg").val('');
        $("#vehicl_plate").val('');

        var regno = $("#vechileregno").val();
        var city = $("#city").val();
        var businessType = $(".businessTypeCheckbox:checked").length;
        var goodTypes = $(".checkbox1:checked").length;
        var licenseno = $("#licenceplaetno").val();
        var company = $("#company_select").val();
        var city = $("#city").val();
        var vtype = $("#getvechiletype").val();
        var year = $('#car-years').val();
        var vmake = $('#car-makes').val();
        var vmodal = $('#car-models').val();
        var viewimage = $("#imagefiles").val();
        var driver_select = $("#selected_driver").val();
//        var year = $('#year').val();
        var anyBoxesChecked = false;
        $('input[type="checkbox"]').each(function () {
            if ($(this).is(":checked")) {
                anyBoxesChecked = true;
            }
        });
        var selectedOwnerType = $("#selectedOwnerType").val();

        if (city == "")
        {
            $("#cityErr").text('Please select a city');
            pstatus = false;
        } else if ((driver_select == "" && selectedOwnerType == 1))
        {
            $("#driver").text('Please select a driver');
            pstatus = false;
        } else if (city == "" || city == null)
        {
            $("#cityErr").text('Please select a city');
            pstatus = false;
        } else if (vtype == "" || vtype == null)
        {
            $("#ve_city").text("");
            $("#ve_type").text(<?php echo json_encode(POPUP_DRIVER_MOBILE); ?>);
            pstatus = false;
        } else if (businessType == 0)
        {
            $("#ve_city").text("");
            $("#businessTypeErr").text('Please select business type');
            pstatus = false;
        } else if ($('.deliveryCheckobx:checked').length == 1 && $('.checkbox1:checked').length == 0)
        {
            $("#goodTypeErr").text('Please select good type');
            pstatus = false;
        } else if (year == "" || year == null)
        {
            $("#yearErr").text('Please select year');
            pstatus = false;
        } else if (vmake == "" || vmake == null)
        {
            $("#ve_type").text("");
            $("#ve_make").text(<?php echo json_encode(POPUP_SELECT_VEHICLEMAKE); ?>);
            pstatus = false;
        } else if (vmodal == "" || vmodal == null)
        {
            $("#ve_make").text("");
            $("#v_modal").text(<?php echo json_encode(POPUP_DRIVER_MOBILE); ?>);
            pstatus = false;
        } else if ((viewimage == "" || viewimage == null) && $('#viewimage_hidden').val() == '')
        {
            $("#ve_make").text("");
            $("#v_modal").text("");
            $("#v_image").text(<?php echo json_encode(POPUP_SELECT_VEHICLEIMAGE); ?>);
            pstatus = false;
        } else if (licenseno == "" || licenseno == null)
        {
            $("#vehi_reg").text("");

            $("#vehicl_plate").text('Please enter the licence plate number');
            pstatus = false;
        } else if (year == "" || year == null)
        {
            $("#vehicl_plate").text("");

            $("#year_err").text('Please enter the year');
            pstatus = false;
        }
//        else if (year.length != 4)
//        {
//            $("#vehicl_plate").text("");
//
//            $("#year_err").text('Please enter valid  year');
//            pstatus = false;
//        }
        if (pstatus === false)
        {
            setTimeout(function ()
            {
                proceed(litabtoremove, divtabtoremove, 'firstlitab', 'tab1');
            }, 300);

            $("#tab1icon").removeClass("fs-14 fa fa-check");
            $("#cancelbutton").removeClass("hidden");
            return false;
        }
        $("#tab1icon").addClass("fs-14 fa fa-check");
        $("#cancelbutton").removeClass("hidden");
        $("#prevbutton").removeClass("hidden");
        $("#nextbutton").removeClass("hidden");
        $("#finishbutton").addClass("hidden");
        return true;
    }
    function bonafidetab(litabtoremove, divtabtoremove)
    {
        var bstatus = true;
        if (profiletab(litabtoremove, divtabtoremove))
        {

            if (bstatus === false)
            {
                setTimeout(function ()
                {
                    proceed(litabtoremove, divtabtoremove, 'thirdlitab', 'tab3');

                }, 100);

                $("#tab3icon").removeClass("fs-14 fa fa-check");
                return false;
            }

            $("#tab1icon").addClass("fs-14 fa fa-check");
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
            if (isBlank($("#regcertificate").val()) || isBlank($("#motorcertificate").val()) || $("#entitydegination").val() === "null")
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

                alert("complete 4 tab properly");
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

            bonafidetab('thirdlitab', 'tab3');

//            alert('after bonafied');
            proceed('firstlitab', 'tab1', 'thirdlitab', 'tab3');

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
        if (currenttabstatus === "thirdlitab")
        {
            profiletab('thirdlitab', 'tab3');
            proceed('thirdlitab', 'tab3', 'firstlitab', 'tab1');
            $("#prevbutton").addClass("hidden");
        }

    }

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
        $("#error-box").text("");

        $("#v_upload_cr").val('');
        $("#ve_expire").val('');
        $("#vehicle_uploadmotor").val('');
        $("#expire_insurence_date").val('');
        $("#vehicle_up_carrp").val('');
        $("#vehicle_expire_date").val('');

        var regcertificate = $("#regcertificate").val();
        var expirerc = $("#expirationrc").val();
        var motorcertificate = $("#motorCertificate").val();
        var expiremotor = $("#expirationinsurance").val();

        var carriagepermit = $("#PermitCertificate").val();
        var date = $("#date").val();
        var entitydegnation = $("#entitydegination").val();
        var edate = $("#edate").val();


//
        if ((regcertificate == "" || regcertificate == null) && $('#regcertificate_hidden').val() == '')
        {
            $("#v_upload_cr").text(<?php echo json_encode(POPUP_SELECT_VEHICLEUPLOADREGNO); ?>);
        } else if (expirerc == "" || expirerc == null)
        {

            $("#v_upload_cr").text("");
            $("#ve_expire").text(<?php echo json_encode(POPUP_SELECT_VEHICLE_DATE); ?>);

        } else if ((motorcertificate == "" || motorcertificate == null) && $('#motorcertificate_hidden').val() == '')
        {
            $("#ve_expire").text("");
            $("#vehicle_uploadmotor").text(<?php echo json_encode(POPUP_SELECT_VINSURENCENUMBER_INSURENCE); ?>);

        } else if (expiremotor == "" || expiremotor == null)
        {
            $("#vehicle_uploadmotor").text("");
            $("#expire_insurence_date").text(<?php echo json_encode(POPUP_SELECT_VEHICLE_DATE); ?>);

        } else if ((carriagepermit == "" || carriagepermit == null) && $('#carriagepermit_hidden').val() == '')
        {
            $("#expire_insurence_date").text("");
            $("#vehicle_up_carrp").text(<?php echo json_encode(POPUP_SELECT_VEHICLECOLOR_CARRIAGE_PERMIT); ?>);

        }
//        else if (edate == "" || edate == null)
//        {
//            $("#vehicle_up_carrp").text("");
//            $("#vehicle_expire_date").text(<?php echo json_encode(POPUP_SELECT_VEHICLE_DATE); ?>);
//            return false;
//        }
        else {
            $('#addentity').submit();
        }

    }

</script>



<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->

    <div class="inner">
        <!-- START BREADCRUMB -->
        <ul class="breadcrumb" style="margin-top: 5%;">
            <li><a href="<?php echo base_url('index.php?/vehicle') ?>/Vehicles/1" class=""><?php echo LIST_VEHICLE; ?></a>
            </li>

            <li style="width: 100px"><a href="#" class="active">EDIT</a>
            </li>
        </ul>
        <!-- END BREADCRUMB -->
    </div>



    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="bg-white" data-pages="parallax">

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                        <li class="active tabs_active" id="firstlitab" onclick="managebuttonstate()">
                            <a  href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span><?php echo LIST_VEHICLE_VEHICLESETUP; ?></span></a>
                        </li>
                        <li class="tabs_active" id="thirdlitab">
                            <a href="#tab3"><i id="tab3icon" class=""></i> <span><?php echo LIST_VEHICLE_DOCUMETS; ?></span></a>
                        </li>

                    </ul>

                    <div class="loader" style="display: none;"></div>
                    <div id="divLoading" style="display:none;"></div>


                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/vehicle/vehicleOperations/update/<?php echo $vehId; ?>" method="post" enctype="multipart/form-data">
                        <div class="tab-content">
                            <input type="hidden" value="<?php echo $vehId; ?>" name="vehicle_id"/>
                            <?php
                            $accType = $vehicleData['accountType'];
                            ?>


                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">


                                    <div class="form-group" class="formexx" style="display:none;">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ownertype'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-5">
                                                <input type="radio" class="radio-success" name="OwnershipType" id="Operator" value="2">
                                                <label for="Operator"><?php echo $this->lang->line('label_operator'); ?></label>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="radio" class="radio-success" name="OwnershipType" id="Freelancer" value="1" checked>
                                                <label for="Freelancer"><?php echo $this->lang->line('label_freelancer'); ?></label>
                                            </div>
                                        </div>
                                        <input type="hidden" id="selectedOwnerType" name="selectedOwnerType" value="1">

                                        <div class="col-sm-3 error-box" id="companyname"></div>
                                    </div>




                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_city'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <select id="city" name="city" class="form-control error-box-class" style="color: #555;"> 
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                <?php
                                                foreach ($cities as $each) {
                                                    $selected = '';
                                                    if ($vehicleData['cityId']['$oid'] == $each['cities']['cityId']['$oid'])
                                                        $selected = 'selected';
                                                    

                                                    echo "<option value='" . $each['cities']['cityId']['$oid'] . "' " . $selected . ">" . $each['cities']['cityName'] . "</option>";
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="col-sm-3 error-box" id="cityErr"></div>
                                    </div>

                                    <div class="form-group driverList">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_driver_name'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 selectDriverTag">
                                            <select id="selected_driver" required="" name="selected_driver" class="form-control error-box-class selectpicker">


                                            </select>
                                        </div>
                                        <div class="col-sm-3 error-box" id="driver"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_type'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <select id="getvechiletype" name="getvechiletype" class="form-control error-box-class" style="color: #555;">
                                                <option value="">Select a vehicle type</option>
                                                <?php
                                                foreach ($vehicleTypes as $each) {
                                                    echo "<option value='" . $each['_id']['$oid'] . "' typeName='" . $each['typeName']['en'] . "'>" . $each['typeName']['en'] . "</option>";
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <input type="hidden" id="vehicleTypeName" name="vehicleTypeName">
                                        <div class="col-sm-3 error-box" id="ve_type"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('lable_preferences'); ?></label>
                                        <div class="col-sm-5">
                                            <div class="multiselect">
                                                <div class="selectBox" onclick="showPreferences()">
                                                    <select class="form-control" name="preferencesSelect">
                                                        <option value=""><?php echo $this->lang->line('select_option'); ?></option>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>
                                                <div id="selectPreferencesDiv" style="overflow-x: auto;max-height: 125px">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_business_type'); ?><span style="" class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <div class="multiselect">
                                                <div class="selectBox " onclick="businessTypeCheckboxes()">
                                                    <select class="form-control" id= "">
                                                        <option><?php echo $this->lang->line('select_option'); ?></option>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>
                                                <div id="businessType" >
                                                    <?php
//                                                    foreach ($vehicleData['services'] as $services) {
//                                                        $serviceType = ($services['serviceType'] == 1) ? 'deliveryCheckobx' : '';
//                                                        
                                                    ?>
<!--                                                        <label for="//<?php echo $services['serviceId']; ?>">
                                                            <input type="checkbox" class="businessTypeCheckbox //<?php echo $serviceType; ?>" name="businessType[]" id="<?php echo $services['serviceId']; ?>" checked value="<?php echo $services['serviceId']; ?>"/><?php echo $services['serviceName']; ?>
                                                        </label>-->
                                                    <?php
//                                                    }
                                                    ?>
                                                    <?php
                                                    foreach ($vehicleData['services'] as $services) {
                                                        $serviceIds[] = $services['serviceId'];
                                                    }


                                                    foreach ($getSpecificVehicleType['prices'] as $types) {

                                                        if ($vehicleData['cityId']['$oid'] == $types['cityId']) {

                                                            $rideChecked = '';
                                                            $deliveryChecked = '';
                                                            if ($types['ride']['isEnabled']) {
                                                                if (in_array($types['ride']['_id']['$oid'], $serviceIds))
                                                                    $rideChecked = 'checked';
                                                                ?>
                                                                <label for="<?php echo $types['ride']['_id']['$oid']; ?>">
                                                                    <input type="checkbox" <?php echo $rideChecked; ?> class="businessTypeCheckbox " name="businessType[]" id="<?php echo $types['ride']['_id']['$oid']; ?>"  value="<?php echo $types['ride']['_id']['$oid']; ?>"/>Ride
                                                                </label>
                                                                <?php
                                                            }
                                                            if ($types['delivery']['isEnabled']) {
                                                                if (in_array($types['delivery']['_id']['$oid'], $serviceIds))
                                                                    $deliveryChecked = 'checked';
                                                                ?>
                                                                <label for="<?php echo $types['delivery']['_id']['$oid']; ?>">
                                                                    <input type="checkbox" <?php echo $deliveryChecked; ?> class="businessTypeCheckbox deliveryCheckobx" name="businessType[]" id="<?php echo $types['delivery']['_id']['$oid']; ?>"  value="<?php echo $types['delivery']['_id']['$oid']; ?>"/>Courier
                                                                </label>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-3 error-box" id="businessTypeErr"></div>
                                    </div>


                                    <div class="form-group goodTypeDiv" style="display: none;">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_good_types'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <div class="multiselect">
                                                <div class="selectBox " onclick="showCheckboxes()">
                                                    <select class="form-control" id="goodType">
                                                        <option>Select an option</option>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>
                                                <div id="checkboxes"  style="overflow-x: scroll;max-height: 125px;    display: block;"> 
                                                    <?php
                                                    foreach ($allVehicleTypeGoodTypes as $vType) {
                                                        if (in_array($vType, $vehicleData['goodTypes'])) {
                                                            ?>

                                                            <label for="<?php echo $vType; ?>">
                                                                <input type="checkbox" class="checkbox1" name="goodType[]" id="<?php echo $vType; ?>" goodType="<?php echo $goodTypesAll[$vType]; ?>" checked value="<?php echo $vType; ?>"/><?php echo $goodTypesAll[$vType]; ?>
                                                            </label>
                                                            <?php
                                                        } else {
                                                            ?>

                                                            <label for="<?php echo $vType; ?>">
                                                                <input type="checkbox" class="checkbox1" name="goodType[]" id="<?php echo $vType; ?>" goodType="<?php echo $goodTypesAll[$vType]; ?>"  value="<?php echo $vType; ?>"/><?php echo $goodTypesAll[$vType]; ?>
                                                            </label>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-3 error-box" id="goodTypeErr"></div>
                                    </div> 

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-6">
                                            <div class="selectedGoodType" style="display:none;border-style:groove;min-height: 70px;padding: 6px;"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Year'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <select name="car-years" id="car-years" class="form-control error-box-class" required="">
                                                <option value="">Select</option>
                                                <?php
                                                $year = date('Y');
                                                foreach ($vehicleYear as $value) {
                                                    if ($vehicleData['year'] == $value) {
                                                        ?>
                                                        <option value="<?php echo $value; ?>" selected><?php echo $value; ?></option>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>  
                                        </div>

                                        <div class="col-sm-3 error-box" id="yearErr"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_make'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <select name="car-makes" id="car-makes" class="form-control error-box-class" required></select> 
                                        </div>
                                        <input type="hidden" id="vehicleMakeName" name="vehicleMakeName">
                                        <input type="hidden" id="vehicleMakeId" name="vehicleMakeId">
                                        <div class="col-sm-3 error-box" id="ve_make"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_model'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <select name="car-models" id="car-models" class="form-control error-box-class" required></select>
                                        </div>
                                        <input type="hidden" id="vehicleModelId" name="vehicleModelId">
                                        <input type="hidden" id="vehicleModelName" name="vehicleModelName">
                                        <div class="col-sm-3 error-box" id="v_modal"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_color'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <!--<input type="text" name="color" id="color" class="form-control error-box-class" required="" value="<?php echo $vehicleData['colour']; ?>"></select>-->
                                            <select name="color" id="color" class="form-control error-box-class" required="">
                                                <option value="White">White</option>>
                                                <option value="Black">Black</option>
                                                <option value="DarkGray">DarkGray</option>
                                                <option value="LightGray">LightGray</option>
                                                <option value="Gray">Gray</option>
                                                <option value="Red">Red</option>
                                                <option value="Green">Green</option>
                                                <option value="Navy">Navy</option>
                                                <option value="Blue">Blue</option>
                                                <option value="SkyBlue">SkyBlue</option>
                                                <option value="Turquoise">Turquoise</option>
                                                <option value="BlueGreen">BlueGreen</option>
                                                <option value="Cyan">Cyan</option>
                                                <option value="Yellow">Yellow</option>
                                                <option value="Magenta">Magenta</option>
                                                <option value="Orange">Orange</option>
                                                <option value="Purple">Purple</option>
                                                <option value="Brown">Brown</option>
                                                <option value="Silver">Silver</option>
                                                <option value="Cerulean">Cerulean</option>
                                                <option value="Lime">Lime</option>
                                                <option value="Gold">Gold</option>
                                                <option value="Olive">Olive</option>
                                                <option value="Maroon">Maroon</option>
                                                <option value="Rose">Rose</option>
                                                <option value="Pink">Pink</option>
                                                <option value="Indigo">Indigo</option>
                                                <option value="Violet">Violet</option>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_image'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">

                                            <input type="file" accept="image/*" class="form-control error-box-class" style="height: 37px;" name="imagefile" id="imagefiles">
                                            <input type="hidden" value="<?php echo $vehicleData['vehicleImage']; ?>" id='viewimage_hidden'/>
                                            <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="vehicleImage" id="vehicleImage">

                                        </div>

                                        <div class="col-sm-1"> <a href="<?php echo $vehicleData['vehicleImage']; ?>" target="blank"><img src="<?php echo $vehicleData['vehicleImage']; ?>" style="width: 35px;height:35px;" class="vehicleImage style_prevu_kit"></a></div>

                                        <div class="col-sm-3 error-box" id="v_image"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_registration_no'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="licenceplaetno" name="licenceplaetno" required="required" class="form-control" placeholder="eg. KA-05/1800" value="<?php echo $vehicleData['plateNo']; ?>">
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicl_plate"></div>
                                    </div>

                                    <!--                                    <div class="form-group">
                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_wheelChairSupport'); ?></label>
                                                                            <div class="col-sm-2">
                                    
                                                                                <div class="switch">
                                                                                    <input id="wheelChairSupport" name="wheelChairSupport" class="cmn-toggle cmn-toggle-round" type="checkbox" <?php if ($vehicleData['wheelChairSupport'] == TRUE) echo 'checked'; ?> style="display: none;">
                                                                                    <label for="wheelChairSupport"></label>
                                                                                </div>
                                                                            </div>
                                    
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_boosterSeatSupport'); ?></label>
                                                                            <div class="col-sm-2">
                                    
                                                                                <div class="switch">
                                                                                    <input id="boosterSeatSupport" name="boosterSeatSupport" class="cmn-toggle cmn-toggle-round" type="checkbox" <?php if ($vehicleData['boosterSeatSupport'] == TRUE) echo 'checked'; ?> style="display: none;">
                                                                                    <label for="boosterSeatSupport"></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    
                                                                        <div class="form-group">
                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_extraBagSupport'); ?></label>
                                                                            <div class="col-sm-2">
                                    
                                                                                <div class="switch">
                                                                                    <input id="extraBagSupport" name="extraBagSupport" class="cmn-toggle cmn-toggle-round" type="checkbox" <?php if ($vehicleData['extraBagSupport'] == TRUE) echo 'checked'; ?>  style="display: none;">
                                                                                    <label for="extraBagSupport"></label>
                                                                                </div>
                                                                            </div>
                                    
                                                                        </div>-->

                                </div>
                            </div>

                            <div class="tab-pane slide-left padding-20" id="tab3">
                                <div class="row row-same-height">

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_upload_registration_certificate'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">

                                            <input type="file" class="form-control error-box-class" style="height: 37px;" name="certificate" id="regcertificate">
                                            <input type="hidden" value="<?php echo $vehicleData['registrationCertImage']; ?>" id='regcertificate_hidden'/>
                                            <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="registationCertificate" id="registationCertificate">
                                        </div>
                                        <div class="col-sm-1 registrationCertImageDiv">
                                            <?php
                                            if ($vehicleData['registrationCertImage']) {
                                                if (substr($vehicleData['registrationCertImage'], -3) !== "pdf") {
                                                    ?>
                                                    <a href="<?php echo $vehicleData['registrationCertImage']; ?>" target="blank">
                                                        <img src="<?php echo $vehicleData['registrationCertImage']; ?>" style="width: 35px;height:35px;" class="registationCertificate style_prevu_kit">
                                                    </a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a style="text-decoration: underline;" href="<?php echo $vehicleData['registrationCertImage']; ?>" target="blank">
                                                        PDF
                                                    </a>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>

                                        <div class="col-sm-3 error-box" id="v_upload_cr"></div>
                                    </div>



                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_registration_expiry_date'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">
                                            <input id="expirationrc" readonly="" name="expirationrc" required="required"  type="" class="form-control error-box-class datepicker-component" value="<?php echo date('m/d/Y', ($vehicleData['registrationCertExpiry']['$date'] / 1000)); ?>">
                                        </div>
                                        <div class="col-sm-3 error-box" id="ve_expire"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_insurance_certificate'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">
                                            <input type="file" class="form-control error-box-class" style="height: 37px;" name="insurcertificate" id="motorcertificate">
                                            <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="motorCertificate" id="motorCertificate">
                                            <input type="hidden" value="<?php echo $vehicleData['motorInsuImage']; ?>" id='motorcertificate_hidden'/>

                                        </div>
                                        <div class="col-sm-1 motorInsuImageDiv">
                                            <?php
                                            if ($vehicleData['motorInsuImage']) {
                                                if (substr($vehicleData['motorInsuImage'], -3) !== "pdf") {
                                                    ?>
                                                    <a href="<?php echo $vehicleData['motorInsuImage']; ?>" target="blank">
                                                        <img src="<?php echo $vehicleData['motorInsuImage']; ?>" style="width: 35px;height:35px;" class="registationCertificate style_prevu_kit">
                                                    </a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a style="text-decoration: underline;" href="<?php echo $vehicleData['motorInsuImage']; ?>" target="blank">
                                                        PDF
                                                    </a>
                                                    <?php
                                                }
                                            }
                                            ?>


                                        </div>

                                        <div class="col-sm-3 error-box" id="vehicle_uploadmotor"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_insurance_expiry_date'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">

                                            <input id="expirationinsurance" readonly="" name="expirationinsurance" required="required"  type="" class="form-control error-box-class datepicker-component2" value="<?php echo date('m/d/Y', ($vehicleData['motorInsuImageDate']['$date'] / 1000)); ?>">

                                        </div>

                                        <div class="col-sm-3 error-box" id="expire_insurence_date"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_inception_report'); ?></label>
                                        <div class="col-sm-5">
                                            <input type="file" class="form-control error-box-class" name="carriagecertificate" id="contractpermit">
                                            <input type="hidden" value="<?php echo $vehicleData['permitImage']; ?>" id='carriagecertificate_hidden'/>
                                            <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="PermitCertificate" id="PermitCertificate">

                                        </div>
                                        <div class="col-sm-1 inspectionReportDiv">
                                            <?php
                                            if ($vehicleData['inspectionReport']) {
                                                if (substr($vehicleData['inspectionReport'], -3) !== "pdf") {
                                                    ?>
                                                    <a href="<?php echo $vehicleData['inspectionReport']; ?>" target="blank">
                                                        <img src="<?php echo $vehicleData['inspectionReport']; ?>" style="width: 35px;height:35px;" class="registationCertificate style_prevu_kit">
                                                    </a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a style="text-decoration: underline;" href="<?php echo $vehicleData['motorInsuImage']; ?>" target="blank">
                                                        PDF
                                                    </a>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </div>

                                        <div class="col-sm-3 error-box" id="vehicle_up_carrp"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_inspection_date'); ?></label>
                                        <div class="col-sm-5">

                                            <input type="text"  readonly="" class="form-control error-box-class datepicker-component1" style="height: 37px;" name="inspectiondate" id="edate" value="<?php
                                            if ($vehicleData['inspectionReportDate'])
                                                echo date('m/d/Y', ($vehicleData['inspectionReportDate']['$date'] / 1000));
                                            else
                                                echo '';
                                            ?>">
                                        </div>

                                        <div class="col-sm-3 error-box" id="vehicle_expire_date"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_goods_in_transit'); ?></label>
                                        <div class="col-sm-5">
                                            <input type="file"  class="form-control error-box-class" name="goodsInTransit" id="goodsInTransit">

                                            <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="goodsInTransit-img" id="goodsInTransit-img">
                                        </div>
                                        <div class="col-sm-1 goodsInTransitDiv">
                                            <?php
                                            if ($vehicleData['goodsInTransit']) {
                                                if (substr($vehicleData['goodsInTransit'], -3) !== "pdf") {
                                                    ?>
                                                    <a href="<?php echo $vehicleData['goodsInTransit']; ?>" target="blank">
                                                        <img src="<?php echo $vehicleData['goodsInTransit']; ?>" style="width: 35px;height:35px;" class="registationCertificate style_prevu_kit">
                                                    </a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a style="text-decoration: underline;" href="<?php echo $vehicleData['goodsInTransit']; ?>" target="blank">
                                                        PDF
                                                    </a>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_goods_in_transit_exp_date'); ?></label>
                                        <div class="col-sm-5">

                                            <input type="text" readonly="" class="form-control error-box-class datepicker-component1" style="height: 37px;"  name="goodsInTransitExpireDate" value="<?php
                                            if ($vehicleData['goodsInTransitDate'])
                                                echo date('m/d/Y', ($vehicleData['goodsInTransitDate']['$date'] / 1000));
                                            else
                                                echo '';
                                            ?>">
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="padding-20 bg-white col-sm-10">
                                <ul class="pager wizard">

                                    <li class="next" id="nextbutton">
                                        <button class="btn btn-success  pull-right" type="button" onclick="movetonext()">
                                            <span><?php echo $this->lang->line('button_next'); ?></span>
                                        </button>
                                    </li>
                                    <li class="hidden" id="finishbutton">
                                        <button class="btn btn-success  pull-right" type="button" onclick="submitform()" >
                                            <span><?php echo $this->lang->line('button_finish'); ?></span>
                                        </button>
                                    </li>

                                    <li class="previous hidden" id="prevbutton">
                                        <button class="btn btn-info  pull-right" type="button" onclick="movetoprevious()">
                                            <span><?php echo $this->lang->line('button_previous'); ?></span>
                                        </button>
                                    </li>
                                    <li class="cancel" id="cancelbutton">
                                        <button class="btn btn-default pull-right" type="button">
                                            <span><?php echo $this->lang->line('button_cancel'); ?></span>
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
</div>
