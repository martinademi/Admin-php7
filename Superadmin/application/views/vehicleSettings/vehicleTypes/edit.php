<link href="application/views/vehicleSettings/vehicleTypes/styles.css" rel="stylesheet" type="text/css">
<style>
    label#bookingType-error {
        position: absolute;
        top: 18px;
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
<?php
$activetab1 = $activetab2 = '';

$v_length = substr($vehicleTypeData['vehicleLength']['en'], 0, -1);
$v_length_metric = substr($vehicleTypeData['vehicleLength']['en'], -1);

$v_width = substr($vehicleTypeData['vehicleWidth']['en'], 0, -1);
$v_width_metric = substr($vehicleTypeData['vehicleWidth']['en'], -1);

$v_height = substr($vehicleTypeData['vehicleHeight']['en'], 0, -1);
$v_height_metric = substr($vehicleTypeData['vehicleHeight']['en'], -1);

$bookingType = $vehicleTypeData['bookingType'];
$goodTypesArr = $vehicleTypeData['goodTypes'];

$currency = $appConfigData['currencySymbol'];
$mileageMetric = $appConfigData['mileage_metric'];
$weightMetric = $appConfigData['weight_metric'];
if ($mileageMetric == 0)
    $mileageMetric = 'Km';
else
    $mileageMetric = 'Mile';

if ($weightMetric == 0)
    $weightMetric = 'Kg';
else
    $weightMetric = 'Pound';
?>

<script>
    var idNum = 0;
    var expanded = false;
    
    var goodTypeID;
    var goodType;

//    function showCheckboxes() {
//        var checkboxes = document.getElementById("checkboxes");
//        if (!expanded) {
//            checkboxes.style.display = "block";
//            expanded = true;
//        } else {
//            checkboxes.style.display = "none";
//            expanded = false;
//        }
//    }


    function RemoveMore(Id)
    {
        $('#RemoveControl' + Id).remove();
    }

    $(document).ready(function () {
        $(".loader").fadeOut("slow");
//        showCheckboxes();
      

        $("#firstTabForm").validate({
            // Specify validation rules
            rules: {
                vehicletypename: {
                    required: true,
                    alphanumeric: true,
                },
                vehicle_length: {
                    required: true
                },
                vehicle_width: {
                    required: true
                }
                ,
                vehicle_height: {
                    required: true
                },
                vehicle_capacity: {
                    required: true
                },
                bookingType: {
                    required: true
                },
                goodType: {
                    required: true
                }

            },
            // Specify validation error messages
            messages: {
                vehicletypename: {
                    alphanumeric: "Please enter valid vehicle type name",
                }
            }
        });

        $('#specialType').change(function ()
        {

            $('.specialType').attr('checked', false);
            if ($(this).is(":checked"))
            {
                $('.mapIconDiv').hide();
                $('.specialTypeDiv').show();
                $('#specialTypeInputValue').val('1');
            } else
            {
                $('.mapIconDiv').show();
                $('.specialTypeDiv').hide();
                $('#specialTypeInputValue').val('0');
            }
        });


        $('.specialType').click(function ()
        {
            if ($('[name="specialType[]"]:checked').length == 0)
            {
                $('#specialType-error').show();
                $('#specialType-error').text('This field is required.');
            } else
            {
                $('#specialType-error').hide();
            }

        });

        //Click on next button
        $('.nextButton').click(function () {
            if ($("#firstTabForm").valid() == true)
            {

                // $('#type_map_image-error').hide();
                // if ($('#specialTypeInputValue').val() == 0 && $('#type_map_image').val() == '')
                // {
                //     $('#type_map_image-error').show();
                // } 
                // else if ($('#goodTypesSelectedCount').val() == '' || $('#goodTypesSelectedCount').val() == 0)
                // {

                // }
                //  else {
                    $('#firstTabForm').submit();
                // }

            }

            $('#specialType-error').hide();
            if ($('#specialTypeInputValue').val() == 1 && $('.specialType:checked').length == 0)
            {

                $('#specialType-error').show();
                $('#specialType-error').text('This field is required.');
            }
        })


        $.validator.addMethod("alphanumeric", function (value, element) {
            return this.optional(element) || /^[a-zA-Z0-9_'\s]+$/.test(value);
        });


        $('.checkbox1').click(function ()
        {
            if ($('[name="goodType[]"]:checked').length == 0)//goodTypesBox
            {
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
                $('.selectedGoodType').append('<span class="selectedGood" id="RemoveControl' + $(this).attr('id') + '"><input readonly class="inputDesc" type="text"  value="' + $(this).attr('goodType') + '"><input type="button"  value="&#10008" data-id="' + $(this).attr('id') + '" class="RemoveMore">')
                $('#goodType').val($(this).attr('id'));
            } else {

                RemoveMore($(this).attr('id'));

            }
        });


        //show selected good types
<?php
foreach ($speciality_data as $googType) {
    if (in_array($googType['_id']['$oid'], $goodTypesArr)) {
        ?>
                goodTypeID = '<?php echo $googType['_id']['$oid']; ?>';
                goodType = '<?php echo $googType['speciality']['en']; ?>';

                $('.selectedGoodType').append('<span class="selectedGood" id="RemoveControl' + goodTypeID + '"><input readonly type="text" class="inputDesc" value="' + goodType + '"><input type="button"  value="&#10008" data-id="' + goodTypeID + '" class="RemoveMore">')
        <?php
    } else {
        
    }
}
?>

        $('#bookingRide').click(function () {
            $('#serviceTypeSelected').val('1');
            $('#bookingRide').attr('class', 'btn btn-primary');
            $('#bookingDelivery').attr('class', 'btn btn-default');
        })
        $('#bookingDelivery').click(function () {
            $('#serviceTypeSelected').val('2');
            $('#bookingDelivery').attr('class', 'btn btn-primary');
            $('#bookingRide').attr('class', 'btn btn-default');
        })


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
                    case "type_on_image":
                        type = 1;
                        folderName = 'vehicleOnImages';
                        break;
                    case "type_off_image":
                        type = 2;
                        folderName = 'vehicleOffImages';
                        break;
                    default :
                        type = 3;
                        folderName = 'vehicleMapImages';

                }

                var formElement = $(this).prop('files')[0];
                var form_data = new FormData();

                form_data.append('OtherPhoto', formElement);
                form_data.append('type', 'VehicleTypes');
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
                                if ($('.onImageAWS').attr('src') != '')
                                    deleteAwsImage($('.onImageAWS').attr('src'));
                                $('#onImageAWS').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                $('.onImageAWS').attr('src', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                break;
                            case 2:
                                if ($('.offImageAWS').attr('src') != '')
                                    deleteAwsImage($('.offImageAWS').attr('src'));
                                $('#offImageAWS').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                $('.offImageAWS').attr('src', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                break;
                            case 3:
                                if ($('.mapImageAWS').attr('src') != '')
                                    deleteAwsImage($('.mapImageAWS').attr('src'));
                                $('#mapImageAWS').val('<?php echo AMAZON_URL; ?>' + result.fileName);
                                $('.mapImageAWS').attr('src', '<?php echo AMAZON_URL; ?>' + result.fileName);
                                break;
                            default :
                                '';
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


    });

    function deleteAwsImage(imgUrl) {
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/vehicle/deleteImage",
            type: "POST",
            data: {imgUrl: imgUrl},
            dataType: "JSON",
            async: false,
            beforeSend: function () {
            },
            success: function (result) {
            }
        });
    }

</script>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <ul class="breadcrumb" style="margin-left: 0px;margin-top: 5%; ">
        <li><a href="<?php echo base_url('index.php?/vehicle') ?>/vehicle_type" class=""><?php echo $this->lang->line('heading_services'); ?> (<?php echo $vehicleTypeData['typeName']['en']?>)</a>
        </li>

        <li ><a href="#" class="active"><?php echo strtoupper($operation); ?></a>
        </li>

    </ul>
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="bg-white" data-pages="parallax">

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">

                        <li class="active tabs_active" id="firstlitab" onclick="managebuttonstate()">
                            <a data-toggle="tab" href="#tab1" id="tb1" style="width:102%"><i id="tab1icon" class=""></i> <span><?php echo $this->lang->line('tab_vehicle_type_details'); ?></span></a>
                        </li>
                    </ul>
                    
                     <div class="loader" style="display: none;"></div>
                    <div id="divLoading" style="display:none;"></div>

                    <div class="tab-content">

                        <div class="tab-pane padding-20 slide-left active" id="tab1">
                            <form id="firstTabForm" method="post" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/vehicle/update_vehicletype/<?php echo $param; ?>"  enctype="multipart/form-data">
                                <input type="hidden" name="goodTypesSelectedCount" id="goodTypesSelectedCount">
                                <div class="row row-same-height">


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_type_name'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="vehicletypename" name="vehicletypename" class="form-control" value="<?php echo $vehicleTypeData['typeName']['en']; ?>" required="">

                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicletype"></div>
                                    </div>


<!--                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_length_of_vehicle'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-6">
                                                <input type="text" id="vehicle_length" name="vehicle_length" class="form-control autonumeric" style="margin-left: -9px;" value="<?php echo $v_length; ?>" required="">
                                            </div>
                                            <div class="col-sm-2">
                                                <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="vehicle_length_metric">
                                                    <?php
                                                    $m_selected = '';
                                                    $f_selected = '';
                                                    if ($v_length_metric == 'M')
                                                        $m_selected = 'selected';
                                                    else
                                                        $f_selected = 'selected';
                                                    ?>
                                                    <option value="M" <?php echo $m_selected ?>><?php echo $this->lang->line('label_meter'); ?></option>
                                                    <option value="F" <?php echo $f_selected ?>><?php echo $this->lang->line('label_feet'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicle_lengthErr"></div>
                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_width_of_vehicle'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-6">
                                                <input type="text" id="vehicle_width" name="vehicle_width" class="form-control autonumeric"  style="margin-left: -9px" value="<?php echo $v_width; ?>" required="">
                                            </div>
                                            <div class="col-sm-2">
                                                <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="vehicle_width_metric">
                                                    <?php
                                                    $m_selected = '';
                                                    $f_selected = '';
                                                    if ($v_width_metric == 'M')
                                                        $m_selected = 'selected';
                                                    else
                                                        $f_selected = 'selected';
                                                    ?>  
                                                    <option value="M" <?php echo $m_selected ?>><?php echo $this->lang->line('label_meter'); ?></option>
                                                    <option value="F" <?php echo $f_selected ?>><?php echo $this->lang->line('label_feet'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicle_widthErr"></div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_height_of_vehicle'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-6">
                                                <input type="text" id="vehicle_height" name="vehicle_height" class="form-control autonumeric"  style="margin-left: -9px;" value="<?php echo $v_height; ?>" required="">
                                            </div>
                                            <div class="col-sm-2">
                                                <select class="form-control" style="height: 34px; font-size: 11px; display: block;  min-width: 85px;" name="vehicle_height_metric">
                                                    <?php
                                                    $m_selected = '';
                                                    $f_selected = '';
                                                    if ($v_height_metric == 'M')
                                                        $m_selected = 'selected';
                                                    else
                                                        $f_selected = 'selected';
                                                    ?> 
                                                    <option value="M" <?php echo $m_selected ?>><?php echo $this->lang->line('label_meter'); ?></option>
                                                    <option value="F" <?php echo $f_selected ?>><?php echo $this->lang->line('label_feet'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicle_heightErr"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_load_bearing_capacity'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative">

                                            <div class="col-sm-6">
                                                <input type="text" id="vehicle_capacity" name="vehicle_capacity" class="form-control autonumeric" style="margin-left:-9px" value="<?php echo $vehicleTypeData['vehicleCapacity']['en']; ?>" required="">
                                                <span class="abs_textT"><?php echo $this->lang->line('label_pound'); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicle_capacityErr"></div>
                                    </div>
-->
                                    
                                   <div class="form-group" style="display: none;">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_choose_good_types'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <div class="multiselect">
                                                <div class="selectBox " onclick="showCheckboxes()">
                                                    <select class="form-control">
                                                        <option><?php echo $this->lang->line('select_option'); ?></option>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>
                                                <div id="checkboxes"  style="overflow-x: scroll;max-height: 125px;    display: block;"> 
                                                    <?php
                                                    foreach ($speciality_data as $googType) {
                                                        if (in_array((string) $googType['_id']['$oid'], $goodTypesArr)) {
                                                            ?>
                                                            <label for="">
                                                                <input type="checkbox" class=" checkbox1" name="goodType[]" id="<?php echo $googType['_id']['$oid']; ?>" goodType="<?php echo $googType['speciality']['en']; ?>" checked value="<?php echo $googType['_id']['$oid']; ?>"/><?php echo $googType['speciality']['en']; ?>
                                                            </label>

                                                            <?php
                                                        } else {
                                                            ?>
                                                            <label for="">
                                                                <input type="checkbox" class=" checkbox1" name="goodType[]" id="<?php echo $googType['_id']['$oid']; ?>" goodType="<?php echo $googType['speciality']['en']; ?>" value="<?php echo $googType['_id']['$oid']; ?>"/><?php echo $googType['speciality']['en']; ?>
                                                            </label>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <label id="goodType-error" class="error" style="display:none">This field is required.</label>
                                        </div>
                                    </div> 

                                    <div class="form-group goodTypesBox" style="display: none;">
                                        <label for="address" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-6">
                                            <div class="selectedGoodType" style="border-style:groove;min-height: 70px;padding: 6px;"></div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_on_image'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-4">

                                            <input type="file" id="type_on_image" name="type_on_image" class="form-control" accept="image/*" value="<?php echo $vehicleTypeData['vehicleImgOn']; ?>">
                                            <input type="hidden" id="onImageAWS" name="onImageAWS" class="form-control">
                                            <input type="hidden" value="<?php echo $vehicleTypeData['vehicleImgOn']; ?>" id="viewimage_on_image">

                                        </div>
                                        <div class="col-sm-2">
                                            <img style="width:35px;height:35px;" src="<?php echo $vehicleTypeData['vehicleImgOn']; ?>" alt="" class="onImageAWS style_prevu_kit"></div>

                                        <div class="col-sm-3 error-box" id="type_on_imageErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_off_image'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-4">
                                            <input type="file" id="type_off_image" name="type_off_image" class="form-control" accept="image/*">
                                            <input type="hidden" id="offImageAWS" name="offImageAWS" class="form-control" >
                                            <input type="hidden" value="<?php echo $vehicleTypeData['vehicleImgOff']; ?>" id='viewimage_off_image'>
                                        </div>
                                        <div class="col-sm-2">
                                            <img style="width:35px;height:35px;" src="<?php echo $vehicleTypeData['vehicleImgOff']; ?>" alt="" class="offImageAWS style_prevu_kit"></div>

                                        <div class="col-sm-3 error-box" id="type_off_imageErr"></div>

                                    </div>

                                    <div class="form-group mapIconDiv">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_map_icon'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-4">
                                            <input type="file" id="type_map_image" name="type_map_image" class="form-control" accept="image/*">
                                            <input type="hidden" value="<?php echo $vehicleTypeData['vehicleMapIcon']; ?>" id='viewimage_map_image'>
                                            <input type="hidden" id="mapImageAWS" name="mapImageAWS" class="form-control">
                                        </div>
                                        <div class="col-sm-2">
                                            <img style="width:35px;height:35px;" src="<?php echo $vehicleTypeData['vehicleMapIcon']; ?>" alt="" class="mapImageAWS style_prevu_kit"></div>

                                        <div class="col-sm-3 error-box" id="type_map_imageErr"></div>

                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_description'); ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="discrption" name="descrption" class="form-control" value="<?php echo $vehicleTypeData['typeDesc']['en']; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="disc"></div>
                                    </div>
                                    <?php
                                   foreach ($languages as $lang) {
                                        if ($lang['active'])
                                            $activeLanguages++;
                                    }
                                    if ($activeLanguages == 0) {
                                        ?>

                                        <div class="form-group">
                                            <div class="col-sm-9">
                                                <div class="pull-right m-t-10"> <button type="submit"  id="" class="btn  btn-success btn-cons submitButton" style="margin-right: 0px;"><?php echo $this->lang->line('button_save'); ?></button></div>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <?php
                                $langCounter = 1;
                                foreach ($languages as $lang) {
                                      if ($lang['active']) {
                                    ?>
                                    <hr>
                                    <div class="row row-same-height">
                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><strong style="color:#0090d9;font-size:11px;"><?php echo strtoupper($lang['name']) ?> (<?php echo $this->lang->line('optional') ?>)</strong></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_vehicle_type_name'); ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="<?php echo $lang['name'] ?>_vehicletypename" name="<?php echo $lang['name'] ?>_vehicletypename" class="form-control"  placeholder="Enter vehicle type name" value="<?php echo $vehicleTypeData['typeName'][$lang['code']]?>">
                                            </div>
                                            <div class="col-sm-3 error-box" id="<?php echo $lang['name'] ?>_vehicletype"></div>
                                        </div>

<!--                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_length_of_vehicle'); ?></label>
                                            <div class="col-sm-6">
                                                <div class="col-sm-6">
                                                    <input type="text" id="<?php echo $lang['name'] ?>_vehicle_length" name="<?php echo $lang['name'] ?>_vehicle_length" class="form-control autonumeric" style="margin-left: -9px;"  placeholder="Enter length" value="<?php echo substr($vehicleTypeData['vehicleLength'][$lang['code']],0,-1)?>">
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="<?php echo $lang['name'] ?>_vehicle_length_metric">
                                                        <option value="M"><?php echo $this->lang->line('label_meter'); ?></option>
                                                        <option value="F"><?php echo $this->lang->line('label_feet'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 error-box" id="<?php echo $lang['name'] ?>_vehicle_lengthErr"></div>
                                        </div>


                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_width_of_vehicle'); ?></label>
                                            <div class="col-sm-6">
                                                <div class="col-sm-6">
                                                    <input type="text" id="<?php echo $lang['name'] ?>_vehicle_width" name="<?php echo $lang['name'] ?>_vehicle_width" class="form-control autonumeric" style="margin-left: -9px" placeholder="Enter width" value="<?php echo substr($vehicleTypeData['vehicleWidth'][$lang['code']],0,-1)?>">
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="<?php echo $lang['name'] ?>_vehicle_width_metric">
                                                        <option value="M"><?php echo $this->lang->line('label_meter'); ?></option>
                                                        <option value="F"><?php echo $this->lang->line('label_feet'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 error-box" id="<?php echo $lang['name'] ?>_vehicle_widthErr"></div>

                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_height_of_vehicle'); ?></label>
                                            <div class="col-sm-6">
                                                <div class="col-sm-6">
                                                    <input type="text" id="<?php echo $lang['name'] ?>_vehicle_height" name="<?php echo $lang['name'] ?>_vehicle_height" class="form-control autonumeric" style="margin-left: -9px;"  placeholder="Enter height" value="<?php echo substr($vehicleTypeData['vehicleHeight'][$lang['code']],0,-1)?>">
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control" style="height: 34px; font-size: 11px; display: block;  min-width: 85px;" name="<?php echo $lang['name'] ?>_vehicle_height_metric">
                                                        <option value="M"><?php echo $this->lang->line('label_meter'); ?></option>
                                                        <option value="F"><?php echo $this->lang->line('label_feet'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 error-box" id="<?php echo $lang['name'] ?>_vehicle_heightErr"></div>

                                        </div>

                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_load_bearing_capacity'); ?></label>
                                            <div class="col-sm-6 pos_relative">

                                                <div class="col-sm-6">
                                                    <input type="text" id="<?php echo $lang['name'] ?>_vehicle_capacity" name="<?php echo $lang['name'] ?>_vehicle_capacity" class="form-control autonumeric" style="margin-left:-9px" placeholder="Enter capacity" value="<?php echo $vehicleTypeData['vehicleCapacity'][$lang['code']]?>">
                                                    <span class="abs_textT"><?php echo $this->lang->line('label_pound'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 error-box" id="<?php echo $lang['name'] ?>_vehicle_capacityErr"></div>
                                        </div>-->

                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?php echo $this->lang->line('label_description'); ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="<?php echo $lang['name'] ?>_discrption" name="<?php echo $lang['name'] ?>_descrption" class="form-control" placeholder="Enter description" value="<?php echo $vehicleTypeData['typeDesc'][$lang['code']]?>" >

                                            </div>
                                            <div class="col-sm-3 error-box" id="<?php echo $lang['name'] ?>_disc"></div>

                                        </div>

                                        <?php
                                        if ($activeLanguages == $langCounter) {
                                            ?>
                                            <div class="form-group">
                                                <div class="col-sm-9">
                                                    <div class="pull-right m-t-10"> <button type="submit"  id="" class="btn  btn-success btn-cons submitButton" style="margin-right: 0px;"><?php echo $this->lang->line('button_save'); ?></button></div>

                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    <?php
                                    $langCounter++;
                                }
                                }
                                ?>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

