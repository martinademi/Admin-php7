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
    var selectedCity = '';
    $(document).ready(
            function ()
            {
                $('.selectpicker').selectpicker();
            });
</script>
<style>
    #heading_language
    {
        color: #337ab7;
        font-weight: 900;
        text-decoration: underline;
        padding: 15px;
    }
    .error{
        color:red;
    }
</style>
<script>
    var idNum = 0;
    var htmlCompanyList;

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
    var html;
    var ImageFlag = 0;
    $(document).ready(function () {

        

        $(".loader").fadeOut("slow");

        $('#car-years').change(function () {
            $('#car-makes').load('<?php echo base_url() ?>index.php?/vehicle/ajax_call_to_get_types/vmake', {adv: $('#car-years').val()});
        });
        $('#car-makes').change(function () {
            $('#vehicleMakeId').val($('#car-makes option:selected').val());
            $('#vehicleMakeName').val($('#car-makes option:selected').attr('name'));
            $('#car-models').load('<?php echo base_url() ?>index.php?/vehicle/ajax_call_to_get_types/vmodel', {adv: $('#car-makes').val(), year: $('#car-years').val()});
        });
        $('#car-models').change(function () {
            $('#vehicleModelId').val($('#car-models option:selected').val());
            $('#vehicleModelName').val($('#car-models option:selected').attr('name'));
        });

        $("#firstTabForm").validate({
            // Specify validation rules
            rules: {
                selected_driver: {
                    required: true,
                },
                licenceplaetno: {
                    required: true,
                    alphanumeric: true,
                    uniquePlateNumber: true
                }
            },
            messages: {
                licenceplaetno: {
                    alphanumeric: "Please enter valid plate number",
                }
            }
        });

        $.validator.addMethod("alphanumeric", function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9-\s]+$/.test(value);
        });


        $("#thirdTabForm").validate({
            // Specify validation rules
            rules: {
                certificate: {
                    required: true,
                },
                expirationrc: {
                    required: true
                },
                insurcertificate: {
                    required: true,
                },
                expirationinsurance: {
                    required: true
                }
            }
        });

        var response = false;
        $.validator.addMethod(
                "uniquePlateNumber",
                function (value, element) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('index.php?/vehicle') ?>/vehicleOperations/validatePlateNumber",
                        data: {plateNum: value},
                        dataType: "JSON",
                        async: false,
                        success: function (msg)
                        {
                            response = msg.msg;
                        }
                    });
                    return response;
                },
                "This plate number is already registered"
                );



        $('#selected_driver').change(function () {
            if ($(this).val() == '')
                $('#selected_driver-error').text('This field is required.');
            else
                $('#selected_driver-error').text('');

        });

        //click on next button it checks the whether the first tab form data is filled or not
        $('#nextbutton').click(function () {

            var currentTab = $('.tabs_active.active').attr('id');
            switch (currentTab) {
                case 'firstlitab':

                    var firstTabData = $("#firstTabForm").valid();
//                    if (checkfields() === true)
//                    {

                    if (firstTabData) {
                        //Goods Types validation
                        if (($('.deliveryCheckobx').is(':checked') && $('#goodTypesSelectedCount').val() == '') || ($('.deliveryCheckobx').is(':checked') && $('#goodTypesSelectedCount').val() == 0))
                        {
                            $('.goodTypesBox').hide();
                            $('#goodType-error').show();
                            $('#goodType-error').text('This field is required.');
                            $('#goodTypesSelectedCount').val('');

                        } else {
                            $("#tab1icon").addClass("fs-14 fa fa-check");
                            $("#prevbutton").removeClass("hidden");
                            $("#finishbutton").removeClass("hidden");
                            $("#nextbutton").addClass("hidden");

                            $("#firstlitab").removeClass("active");
                            $("#tab1").removeClass("active");

                            $("#thirdlitab").addClass("active");
                            $("#tab3").addClass("active");
                        }
                    } else
                    {
                        if ($('#goodTypesSelectedCount').val() == '' || $('#goodTypesSelectedCount').val() == 0)
                        {
                            $('.goodTypesBox').hide();
                            $('#goodType-error').show();
                            $('#goodType-error').text('This field is required.');
                            $('#goodTypesSelectedCount').val('');

                        }

                        return false;
                    }
//                    } else {
                    if ($('#goodTypesSelectedCount').val() == '' || $('#goodTypesSelectedCount').val() == 0)
                    {
                        $('.goodTypesBox').hide();
                        $('#goodType-error').show();
                        $('#goodType-error').text('This field is required.');
                        $('#goodTypesSelectedCount').val('');

                    }
                    return false;
//                    }
                    break;
            }
        });

        $('.tabs_active').click(function () {

            var currentTab = $('.tabs_active.active').attr('id');

            switch (currentTab) {
                case 'firstlitab':
                    var firstTabData = $("#firstTabForm").valid();
                    if (firstTabData) {

                        var nextTab = $(this).attr('id');
                        switch (nextTab) {
                            case 'thirdlitab':
                                var secondTabData = $("#secondTabForm").valid();
                                if (secondTabData) {
                                    $("#tab2icon").addClass("fs-14 fa fa-check");
                                    $("#firstlitab").removeClass("active");
                                    $("#tab1").removeClass("active");

                                    $("#thirdlitab").addClass("active");
                                    $("#tab3").addClass("active");

                                    $("#prevbutton").removeClass("hidden");
                                    $("#nextbutton").addClass("hidden");
                                    $("#finishbutton").removeClass("hidden");
                                } else
                                {
                                    return false;
                                }
                                break;
                        }

                    } else
                    {
                        return false;
                    }
                    break;
                case 'thirdlitab':

                    var nextTab = $(this).attr('id');
                    switch (nextTab) {
                        case 'firstlitab':
                            $("#thirdlitab").removeClass("active");
                            $("#tab3").removeClass("active");
                            $("#firstlitab").addClass("active");
                            $("#tab1").addClass("active");

                            $("#prevbutton").addClass("hidden");
                            $("#nextbutton").removeClass("hidden");
                            $("#finishbutton").addClass("hidden");

                            break;
                        case 'secondlitab':
                            $("#thirdlitab").removeClass("active");
                            $("#tab3").removeClass("active");
                            $("#secondlitab").addClass("active");
                            $("#tab2").addClass("active");

                            $("#prevbutton").removeClass("hidden");
                            $("#nextbutton").removeClass("hidden");
                            $("#finishbutton").addClass("hidden");
                            break;
                    }
                    break;
            }

        });

        $('#finishbutton').click(function () {
            if ($("#thirdTabForm").valid())
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php?/vehicle/vehicleOperations/insert",
                    type: "POST",
                    data: $('form').serialize(),
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);

                        if (result.errorCode == 0)
                            window.location = "<?php echo base_url('index.php?/vehicle') ?>/Vehicles/1";
                        else
                            alert(result.msg);
                    }
                });
            }
        })

        //Click on prevoius button
        $('#prevbutton').click(function () {

            var currentTab = $('.tabs_active.active').attr('id');

            switch (currentTab) {
                case 'thirdlitab':
                    $("#thirdlitab").removeClass("active");
                    $("#tab3").removeClass("active");
                    $("#firstlitab").addClass("active");
                    $("#tab1").addClass("active");

                    $("#prevbutton").removeClass("hidden");
                    $("#nextbutton").removeClass("hidden");
                    $("#finishbutton").addClass("hidden");
                    break;
            }

        });


        $('#company_select').empty();
        htmlCompanyList += '<option value="">Select</option>';
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

            if ($('[name="goodType[]"]:checked').length == 0)
            {//goodTypesBox
                $('.goodTypesBox').hide();
                $('#goodType-error').text('This field is required.');
                $('#goodType-error').show();
                $('#goodTypesSelectedCount').val('');
            } else
            {
                $('#goodTypesSelectedCount').val($('[name="goodType[]"]:checked').length);
                $('.goodTypesBox').show();
                $('#goodType-error').hide();
            }


            if ($(this).is(":checked"))
            {
                $('.selectedGoodType').append('<span class="selectedGood" id="RemoveControl' + $(this).attr('id') + '"><input readonly  class="inputDesc" type="text"  value="' + $(this).attr('goodType') + '"><input type="button" value="&#10008" data-id="' + $(this).attr('id') + '" class="RemoveMore">')
                $('#goodType').val($(this).attr('id'));
            } else {

                RemoveMore($(this).attr('id'));

            }
        });
        $(document).on('click', '.RemoveMore', function ()
        {
            $('#' + $(this).attr('data-id')).attr('checked', false);
            $('#RemoveControl' + $(this).attr('data-id')).remove();

            if ($('[name="goodType[]"]:checked').length == 0)//goodTypesBox
            {
                $('.goodTypesBox').hide();
                $('#goodType-error').show();
                $('#goodType-error').text('This field is required.');
                $('#goodTypesSelectedCount').val('');

            } else
            {
                $('.goodTypesBox').show();
                $('#goodTypesSelectedCount').val($('[name="goodType[]"]:checked').length);
            }
        });


        $('.datepicker-component,.datepicker-component1,.datepicker-component2').on('changeDate', function () {
            $(this).datepicker('hide');
        });

//        $("#datepicker1").datepicker({ minDate: 0});
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
                form_data.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
                form_data.append('OtherPhoto', formElement);
                form_data.append('type', 'Vehicles');
                form_data.append('folder', folderName);
                $.ajax({
                  
                    url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                    type: "POST",
                    data: form_data,
                    dataType: "JSON",
//                    async: false,
                    beforeSend: function () {
                        $(".loader").fadeIn("slow");
                    },
                    success: function (result) {
                        $(".loader").fadeOut("slow");
                        $('#' + fieldID + '-error').hide();
                        switch (type)
                        {
                            case 1:
                                // $('#vehicleImage').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                // $('.vehicleImage').show();
                                // $('.vehicleImage').attr('src', '<?php echo AMAZON_URL; ?>' + result.fileName);

                                $('#vehicleImage').val(result.fileName);
                                  $('.vehicleImage').show();
                                  $('.vehicleImage').attr('src', result.fileName);
                                break;
                            case 2:
                                $('#registationCertificate').val(result.fileName);
                                $('.registrationCertImageDiv').empty();
                                $('.registrationCertImageDiv').html('<a target="_blank" class="href_registrationCertImage" href="' + result.fileName + '" style="text-decoration:underline"></a>');

                                if (ext === "pdf") {
                                    $('.href_registrationCertImage').text('PDF');
                                } else {
                                    $('.href_registrationCertImage').html('<img style="width: 35px;height:35px;" class="style_prevu_kit" src="' + result.fileName + '">');
                                }

                                break;
                            case 3:
                                $('#motorCertificate').val( result.fileName);
                                $('.motorInsuImageDiv').empty();
                                $('.motorInsuImageDiv').html('<a target="_blank" class="href_motorInsuImage" href="' + result.fileName + '" style="text-decoration:underline"></a>');

                                if (ext === "pdf") {
                                    $('.href_motorInsuImage').text('PDF');
                                } else {
                                    $('.href_motorInsuImage').html('<img style="width: 35px;height:35px;" class="style_prevu_kit" src="' + result.fileName + '">');
                                }
                                break;
                            case 4:
                                $('#inspection_report').val(result.fileName);
                                $('.inspectionReportDiv').empty();
                                $('.inspectionReportDiv').html('<a target="_blank" class="href_inspectionReport" href="' + result.fileName + '" style="text-decoration:underline"></a>');

                                if (ext === "pdf") {
                                    $('.href_inspectionReport').text('PDF');
                                } else {
                                    $('.href_inspectionReport').html('<img style="width: 35px;height:35px;" class="style_prevu_kit" src="' + result.fileName + '">');
                                }
                                break;
                            case 5:
                                $('#goodsInTransit-img').val( result.fileName);
                                $('.goodsInTransitDiv').empty();
                                $('.goodsInTransitDiv').html('<a target="_blank" class="href_goodsInTransit" href="' + result.fileName + '" style="text-decoration:underline"></a>');

                                if (ext === "pdf") {
                                    $('.href_goodsInTransit').text('PDF');
                                } else {
                                    $('.href_goodsInTransit').html('<img style="width: 35px;height:35px;" class="style_prevu_kit" src="' + result.fileName + '">');
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

        $('#getvechiletype').change(function () {
            html = '';
            $('#checkboxes').empty();
            $('#businessType').empty();
            $('.selectedGood').remove();
            $('.goodTypeDiv').hide();
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

                    console.log('res',result)
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
                        html += '<label for="preference_' + value._id.$oid + '">';
                        html += '<input type="checkbox" class="preference" name="preference[]" id="preference_' + value._id.$oid + '"  value="' + value._id.$oid + '"/>' + value.name.en;
                        html += ' </label>';

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

                }
            });
        });

        //city changed
        $('#city').change(function () {
            html = '';
            $('#selected_driver').empty();
            $('.selectDriverTag').empty();
            $('#getvechiletype').empty();
            $('#selectPreferencesDiv').empty();
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
                        console.log('river--',result);

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

                $('#getvechiletype').empty();
            }


            //---------------------------------------------

//            if ($('#getvechiletype').val() == '') {
////                alert('Please select vehicle type');
//            } else {
//
//                html = '';
//                selectedCity = $('#city').val();
//                $.ajax({
//                    dataType: "json",
//                    type: 'POST',
//                    url: "<?= base_url() ?>index.php?/vehicle/ajax_call_to_get_types/getCityVehicleType",
//                    data: {vehicleTypeID: $('#getvechiletype').val()},
//                    async: false,
//                    success: function (result) {
//                        html = '';
//                        $('#businessType').empty();
//                        $.each(result.data, function (index, response)
//                        {
//                            if (response.cityId == selectedCity)
//                            {
//                                if (response.ride.isEnabled) {
//                                    html += '<label for="' + response.ride._id.$oid + '">';
//                                    html += '<input type="checkbox" class="businessTypeCheckbox" name="businessType[]" id="' + response.ride._id.$oid + '"  value="' + response.ride._id.$oid + '"/> Ride';
//                                    html += ' </label>';
//                                }
//                                if (response.delivery.isEnabled) {
//                                    html += '<label for="' + response.delivery._id.$oid + '">';
//                                    html += '<input type="checkbox" class="businessTypeCheckbox"  name="businessType[]" id="' + response.delivery._id.$oid + '"  value="' + response.delivery._id.$oid + '"/> Courier';
//                                    html += ' </label>';
//                                }
//                            }
//                        });
//                        $('#businessType').append(html);
//                    }
//                });
//            }
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

    function platNoValidationCheck(email)
    {
        var status = '1';
        var returnStatus;
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/vehicle/licenceplaetno",
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

   

</script>




<div class="page-content-wrapper">
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb" style="margin-left: 0px;margin-top: 5%;">
        <li><a href="<?php echo base_url('index.php?/vehicle') ?>/Vehicles/1" class=""><?php echo $this->lang->line('heading_vehicle'); ?></a>
        </li>

        <li style="width: 100px"><a href="#" class="active"><?php echo $this->lang->line('heading_vehicle_add'); ?></a>
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
                    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                        <li class="active tabs_active" id="firstlitab">
                            <a data-toggle="tab" href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span><?php echo $this->lang->line('tab_vehicle_set_up'); ?></span></a>
                        </li>
                        <li class="tabs_active" id="thirdlitab">
                            <a data-toggle="tab" href="#tab3"><i id="tab3icon" class=""></i> <span><?php echo $this->lang->line('tab_vehicle_documents'); ?></span></a>
                        </li>

                    </ul>

                    <div class="loader" style="display: none;"></div>
                    <div id="divLoading" style="display:none;"></div>

                    <div class="tab-content">
                        <div class="tab-pane padding-20 slide-left active" id="tab1">
                            <form id="firstTabForm" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/vehicle/vehicleOperations/insert" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="goodTypesSelectedCount" id="goodTypesSelectedCount">
                                <div class="row row-same-height">
                                    <div class="form-group" class="formexx" style="display:none">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ownertype'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-5">
                                                <input type="radio" class="radio-success" name="OwnershipType" id="Operator" value="2" >
                                                <label for="Operator"><?php echo $this->lang->line('label_operator'); ?></label>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="radio" class="radio-success" name="OwnershipType" id="Freelancer" value="1" checked>
                                                <label for="Freelancer"><?php echo $this->lang->line('label_freelancer'); ?></label>
                                            </div>
                                        </div>
                                        <input type="hidden" id="selectedOwnerType" name="selectedOwnerType" value="2">

                                    </div>

                                    <div class="form-group operatorList" style="display:none;">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_operator_name'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <select id="company_select" name="company_select"  class="form-control error-box-class" >
                                                <option value=""><?php echo $this->lang->line('label_select_Company'); ?></option>

                                            </select>
                                            <label id="company_select-error" class="error" style="display:none;">This field is required.</label>

                                            <input type="hidden" id="operatorName" name="operatorName">

                                        </div>
                                        <div class="col-sm-3 error-box" id="ve_compan"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_city'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <select id="city" name="city" class="form-control error-box-class" style="color: #555;" required=""> 
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                <?php
                                                foreach ($cities as $each) {
                                                    echo "<option value='" . $each['cities']['cityId']['$oid'] . "'>" . $each['cities']['cityName'] . "</option>";
                                                }
                                                ?>

                                            </select>                                        

                                        </div>
                                    </div>

                                    <div class="form-group driverList" style="display: block;">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_driver_name'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 selectDriverTag">
                                            <select id="selected_driver" required="" name="selected_driver" class="form-control error-box-class selectpicker" data-live-search="true">
                                                <option data-tokens="" value="">Select</option>
                                            </select>

                                        </div>
                                        <!--<label id="selected_driver-error" class="error" style="display:none;">This field is required.</label>-->

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_type'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <select id="getvechiletype"  required="" name="getvechiletype" class="form-control error-box-class" style="color: #555;"> 
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                <?php
//                                                foreach ($vehicleTypes as $each) {
//                                                    echo "<option value='" . $each['_id']['$oid'] . "' typeName='" . $each['typeName']['en'] . "'>" . $each['typeName']['en'] . "</option>";
//                                                }
                                                ?>

                                            </select>
                                            <input type="hidden" id="vehicleTypeName" name="vehicleTypeName">
                                        </div>

                                    </div>
                                   
                                    <!-- <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_business_type'); ?><span style="" class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <div class="multiselect">
                                                <div class="selectBox " onclick="businessTypeCheckboxes()">
                                                    <select class="form-control" id= "">
                                                        <option><?php echo $this->lang->line('select_option'); ?></option>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>
                                                <div id="businessType"></div>
                                            </div>
                                            <label id="businessType-error" class="error" style="display:none">This field is required.</label>
                                        </div>
                                    </div> -->
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

                                    <div class="form-group goodTypeDiv" style="display:none;">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_good_types'); ?><span style="" class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <div class="multiselect">
                                                <div class="selectBox " onclick="showCheckboxes()">
                                                    <select class="form-control" id= "goodType">
                                                        <option><?php echo $this->lang->line('select_option'); ?></option>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>
                                                <div id="checkboxes" style="overflow-x: scroll;max-height: 125px;    display: block;"></div>
                                            </div>
                                            <label id="goodType-error" class="error" style="display:none">This field is required.</label>
                                        </div>

                                    </div>

                                    <div class="form-group goodTypesBox" style="display:none;">
                                        <label for="address" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-6">
                                            <div class="selectedGoodType" style="border-style:groove;min-height: 70px;padding: 6px;"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Year'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <select name="car-years" id="car-years" class="form-control error-box-class" required="">
                                                <option value="">Select</option>
                                                <?php
                                                foreach ($vehicleYear as $value) {
                                                    ?>
                                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>  
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_make'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <select name="car-makes" id="car-makes" class="form-control error-box-class" required=""></select> 
                                        </div>
                                        <input type="hidden" id="vehicleMakeName" name="vehicleMakeName">
                                        <input type="hidden" id="vehicleMakeId" name="vehicleMakeId">
                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_model'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <select name="car-models" id="car-models" class="form-control error-box-class" required=""></select>
                                        </div>
                                        <input type="hidden" id="vehicleModelName" name="vehicleModelName">
                                        <input type="hidden" id="vehicleModelId" name="vehicleModelId">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_color'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <!--<input type="text" name="color" id="color" class="form-control error-box-class" required=""></select>-->
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

                                            <input type="file" accept="image/*" class="form-control error-box-class" required="" style="height: 37px;" name="imagefile" id="imagefiles">
                                            <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="vehicleImage" id="vehicleImage">
                                        </div>
                                        <div class="col-sm-1"><img src="" style="width: 35px;height:35px;display:none;" class="vehicleImage style_prevu_kit"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_registration_no'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="licenceplaetno" name="licenceplaetno" required="required" class="form-control error-box-class" placeholder="">
                                            <label id="licensePlateNo-validation" class="" for="licenceplaetno" style="display:none;color:red">License number has already been used.</label>
                                        </div>

                                    </div>


                                    <!--                                    <div class="form-group">
                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_wheelChairSupport'); ?></label>
                                                                            <div class="col-sm-2">
                                    
                                                                                <div class="switch">
                                                                                    <input id="wheelChairSupport" name="wheelChairSupport" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                                                    <label for="wheelChairSupport"></label>
                                                                                </div>
                                                                            </div>
                                    
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_boosterSeatSupport'); ?></label>
                                                                            <div class="col-sm-2">
                                    
                                                                                <div class="switch">
                                                                                    <input id="boosterSeatSupport" name="boosterSeatSupport" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                                                    <label for="boosterSeatSupport"></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    
                                                                        <div class="form-group">
                                                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_extraBagSupport'); ?></label>
                                                                            <div class="col-sm-2">
                                    
                                                                                <div class="switch">
                                                                                    <input id="extraBagSupport" name="extraBagSupport" class="cmn-toggle cmn-toggle-round" type="checkbox"  style="display: none;">
                                                                                    <label for="extraBagSupport"></label>
                                                                                </div>
                                                                            </div>
                                    
                                                                        </div>-->

                                </div>
                            </form>
                        </div>
                        <div class="tab-pane slide-left padding-20" id="tab3">
                            <form id="thirdTabForm" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/vehicle/vehicleOperations/insert" method="post" enctype="multipart/form-data">
                                <div class="row row-same-height">
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_upload_registration_certificate'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">
                                            <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="registationCertificate" id="registationCertificate">
                                            <input type="file"  class="form-control error-box-class" style="height: 37px;" name="certificate" id="regcertificate">
                                        </div>
                                        <div class="col-sm-1 registrationCertImageDiv">
                                            <a href="" class="href_registationCertificate" target="_blank">
                                                <img src="" style="width: 35px;height:35px;display:none;" class="registationCertificate style_prevu_kit">
                                            </a>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_registration_expiry_date'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">
                                            <input id="expirationrc" readonly="" name="expirationrc" required="required"  type="" class="form-control error-box-class datepicker-component">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_insurance_certificate'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">
                                            <input type="file"  class="form-control error-box-class" style="height: 37px;" name="insurcertificate" id="motorcertificate">
                                            <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="motorCertificate" id="motorCertificate">
                                        </div>
                                        <div class="col-sm-1 motorInsuImageDiv"><a href="" class="href_motorCertificate" target="_blank"><img src="" style="width: 35px;height:35px;display:none;" class="motorCertificate style_prevu_kit"></a></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_insurance_expiry_date'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-5">
                                            <input id="expirationinsurance" readonly="" name="expirationinsurance" required="required"  type="" class="form-control error-box-class datepicker-component" >
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_inception_report'); ?></label>
                                        <div class="col-sm-5">
                                            <input type="file"  class="form-control error-box-class" name="inspectionreport" id="inspectionreport">

                                            <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="inspection_report" id="inspection_report">
                                        </div>
                                        <div class="col-sm-1 inspectionReportDiv"><a href="" class="href_inspection_report" target="_blank"><img src="" style="width: 35px;height:35px;display:none;" class="inspection_report style_prevu_kit"></a></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_inspection_date'); ?></label>
                                        <div class="col-sm-5">

                                            <input type="text" readonly="" class="form-control error-box-class datepicker-component" style="height: 37px;"  name="inspectiondate">
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_goods_in_transit'); ?></label>
                                        <div class="col-sm-5">
                                            <input type="file"  class="form-control error-box-class" name="goodsInTransit" id="goodsInTransit">

                                            <input type="hidden" class="form-control error-box-class" style="height: 37px;" name="goodsInTransit-img" id="goodsInTransit-img">
                                        </div>
                                        <div class="col-sm-1 goodsInTransitDiv"><a href="" class="href_goodsInTransit-img" target="_blank"><img src="" style="width: 35px;height:35px;display:none;" class="goodsInTransit-img style_prevu_kit"></a></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_goods_in_transit_exp_date'); ?></label>
                                        <div class="col-sm-5">

                                            <input type="text" readonly="" class="form-control error-box-class datepicker-component" style="height: 37px;"  name="goodsInTransitExpireDate">
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <div class="padding-20 bg-white col-sm-9">
                            <ul class="pager wizard ">

                                <li class="next" id="nextbutton">
                                    <button class="btn btn-primary pull-right" type="button">
                                        <span><?php echo $this->lang->line('button_next'); ?></span>
                                    </button>
                                </li>
                                <li class="hidden" id="finishbutton">
                                    <button class="btn btn-primary pull-right" type="button">
                                        <span><?php echo $this->lang->line('button_finish'); ?></span>
                                    </button>
                                </li>

                                <li class="previous hidden" id="prevbutton">
                                    <button class="btn btn-default pull-right" type="button">
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

                </div>


            </div>
            <!-- END PANEL -->
        </div>

    </div>

</div>

