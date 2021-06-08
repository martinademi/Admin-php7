<script src="<?php echo ServiceLink ; ?>vendors/bootstrap/dist/js/bootstrap-multiselect.js"></script>
<link href="<?php echo ServiceLink ; ?>vendors/bootstrap/dist/css/bootstrap-multiselect.css" rel="stylesheet">
<?php

$breakfastData = $productsData['consumptionTime']['breakfast'];
$brunchData = $productsData['consumptionTime']['brunch'];
$lunchData = $productsData['consumptionTime']['lunch'];
$teaData = $productsData['consumptionTime']['tea'];
$dinnerData = $productsData['consumptionTime']['dinner'];
$latenightdinnerData = $productsData['consumptionTime']['latenightdinner'];
if($latenightdinnerData == 1 || $latenightdinnerData == "1"){
    $latenightdinner = "checked";
}
if($teaData == 1 || $teaData == "1"){
    $tea = "checked";
}
if($dinnerData == 1 || $dinnerData == "1"){
    $dinner = "checked";
}
if($lunchData == 1 || $lunchData == "1"){
    $lunch = "checked";
}
if($brunchData == 1 || $brunchData == "1"){
    $brunch = "checked";
}
if($breakfastData == 1 || $breakfastData == "1"){
    $breakfast = "checked";
}

?>
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
    .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
    position: absolute;
    margin-left: -20px !important;
}

    .ui-menu-item {
        cursor: pointer;
        background: black;
        color: white;
        border-bottom: 1px solid white;
        width: 200px;
    }
    span.abs_text {
        position: absolute;
        right:0px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }
    .pos_relative2{
        padding-right:10px
    }
    .pos_relative ,.pos_relative2{
        position: relative;
        padding-right:0px
    }
    .marginSet{
        margin-right: 25px;
    }
    .removeButton{
        margin-left: 10px;
        margin-top: 5px;
    }
    .redClass{
        color:red;
    }

    ul.navbar-nav.navbar-left.nav.nav-tabs.nav-tabs-linetriangle.nav-tabs-separator.nav-stack-sm.fixednab {
        position: fixed;
        z-index: 999;
        width: 100%;
        top: 0;
        background: white;
    }
    .multiselect{
        border-radius: 0;
        text-align: left;
        font-size: 10px;
    }
    .caret{
        float: right;
        position: relative;
        right: -10px;
    }

</style>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script>
    var selectedsize = [];
    var select = [];
    function submitform()
    {
        $(".error-box").text("");

        var name = $('#name_0').val();
        var category = $('#category').val();
        var barcode = $('#barcode').val();
        var shortDescription = $('#shortDescription').val();
        var THC = $('#THC').val();
        var CBD = $('#CBD').val();
      

        var title = $('.productTitle').val();
        var value = $('.productValue').val();

        if (name == '' || name == null) {
            $('#name_0').focus();
            $('#text_name').text('Please enter the name');
        } else if (category == '' || category == null) {
            $('#category').focus();
            $('#text_category').text('Please select the category');
        } else if (shortDescription == '' || shortDescription == null) {
            $('#shortDescription').focus();
            $('#text_shortDescription').text('Please enter the short description');
        } 
        // else if (THC == '' || THC == null) {
        //     $('#THC').focus();
        //     $('#text_THC').text('Please enter THC value');
        // } 
        // else if (CBD == '' || CBD == null) {
        //     $('#CBD').focus();
        //     $('#text_CBD').text('Please enter CBD value');
        // }
         else if (title == '' || title == null || value == '' || value == null) {
            $('#productTitle').focus();
            $('#text_productCustomText').text('Enter title and value both ');
        } else {
            var categoryName = $('#category option:selected').attr('data-name');
            var subCategoryName = $('#subCategory option:selected').attr('data-name');
            var subSubCategoryName = $('#subSubCategory option:selected').attr('data-name');
              var brandName = $('#brand option:selected').attr('data-name');
            var manufacturerName = $('#manufacturer option:selected').attr('data-name');
            $('#brandName').val(brandName);
            $('#manufacturerName').val(manufacturerName);
            $('#firstCategoryName').val(categoryName);
            $('#secondCategoryName').val(subCategoryName);
            $('#thirdCategoryName').val(subSubCategoryName);

            var currentdate = new Date();
            var datetime = currentdate.getFullYear() + "-" + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();

            var categorySKU = categoryName.substring(0, 2);
            if ($("#subCategory").val().length === 0 || subCategoryName == "undefined" || $('#subCategory option:selected').attr('data-name') == "undefined") {
                var subCategorySKU = $("#name_0").val().substring(0, 2) + '-' + categoryName.substring(0, 2) + '-' + generateRandomString();

            } else {
                var subCategorySKU = $('#subCategory option:selected').attr('data-name').substring(0, 2);

                if ($("#subSubCategory").val().length === 0 || $("#subSubCategory").val() == "0" || $("#subSubCategory").val() == 0) {
                    var sku = $("#name_0").val().substring(0, 2) + '-' + categoryName.substring(0, 2) + '-' + subCategoryName.substring(0, 2) + '-' + generateRandomString();

                } else {
                    var subCategorySKU1 = $('#subCategory option:selected').attr('data-name').substring(0, 2);
                    var sku = $("#name_0").val().substring(0, 2) + '-' + categoryName.substring(0, 2) + '-' + subCategoryName.substring(0, 2) + '-' + subCategorySKU1.substring(0, 2) + '-' + generateRandomString();

                }

            }

            $("#sku").val(sku);

            $('#time_hidden').val(datetime);
            $('#addentity').submit();
        }

    }

    function generateRandomString() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 10; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    }



</script>




<script>

    var OnlymobileNo;
    var CountryCodeMobileNo;

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
    function redirectToDest() {
        window.location.href = "<?php echo base_url('index.php?/AddNewProducts/') ?>";
    }

    function renameUnitsLabelsUnit() {
        for (var j = 0, length = $('.customPriceField').length; j < length; j++) {
            $('.customPriceField>label').eq(j).text('Units ' + (j + 1) + ' *');


        }
    }

    function renameImageLabelsUnit() {
        for (var i = 0, length = $('.imageTag').length; i < length; i++) {
            $('.imageTag>label').eq(i).text('Image ' + (i + 1));
        }
    }
    function renameImageLabels() {
        for (var i = 0, length = $('.imageTag').length; i < length; i++) {
            $('.imageTag>label').eq(i).text('Image ' + (i + 1));


        }
    }
    function renameUnitsLabels() {
        for (var j = 0, length = $('.customPriceField').length; j < length; j++) {
            $('.customPriceField>label').eq(j).text('Units ' + (j + 1) + ' *');


        }
    }



    $(document).ready(function () {
        var productId = "<?php echo $productId; ?>";

        $(window).scroll(function () {
            var scr = jQuery(window).scrollTop();

            if (scr > 0) {
                $('#mytabss').addClass('fixednab');
            } else {
                $('#mytabss').removeClass('fixednab');
            }
        });

        $('.error-box-class ').keypress(function () {
            $('.error-box').text('');
        });
        $('.error-box-class ').change(function () {
            $('.error-box').text('');
        });


        $.ajax({

            url: "<?php echo base_url(); ?>index.php?/AddNewProducts/getUnitsEdit/" + productId,
            type: "POST",
            data: {productId: productId},
            dataType: "JSON",

            beforeSend: function () {
                //                    $("#ImageLoading").show();
            },
            success: function (response) {
                console.log(response.result);
               
                $.each(response.result, function (index, row) {
//                    var z = $('.customPriceField').length;
//                    var unitElement = '<div class="form-group pos_relative2 customPriceField">'
//                            + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units <label class="MandatoryMarker">*</label></label>'
//                            + '<div class="col-sm-3 pos_relative2">'
//                            + '<span  class="abs_text"><b>Title</b></span>'
//                            + '<input type="text" name="units[' + z + '][title]" value="' + row.title + '" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
//                            + '<input type="hidden" name="units[' + z + '][unitId]" value="' + row.unitId + '">'
//                            + '<input type="hidden" name="units[' + z + '][status]" value="' + row.status + '">'
//                            + '</div>'
//                            + ' <div class="col-sm-3 pos_relative2">'
//                            + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
//                            + ' <input type="text" name="units[' + z + '][value]" value="' + row.value + '" class="form-control productValue" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
//                            + ' </div>'
//                            + '<div class=""></div>'
//                            + '<button type="button" class="btn-default btnRemove removeButton">'
//                            + '<span class="glyphicon glyphicon-remove"></span>'
//                            + '</button>'
//                            + '</div>';
//                    $('.customField').append(unitElement);
//                    renameUnitsLabelsUnit();

                    var z = $('.customPriceField').length;
//                    var z = len + 1;
//                    console.log(z);
                    var y = z + 1;
                    var divElement1 = '<div class="customPriceField row"><div class="form-group pos_relative2 customPriceField' + z + '">'
                            + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' </label>'
                            + '<div class="col-sm-3 pos_relative2">'
                            + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                            + '<input type="text" name="units[' + z + '][name][en]" value="' + row.name.en + '" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                            + '</div>'
                            + ' <div class="col-sm-3 pos_relative2">'
                            + ' <span  class="abs_text"><b>$</b></span>'
                            + ' <input type="text" name="units[' + z + '][price][en]" value="' + row.price.en + '"  class="form-control productValue" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                            + ' </div>'
                            + '<div class=""></div>'
                            + '<button type="button" value="' + y + '"class="btn-default btnRemove removeButton">'
                            + '<span class="glyphicon glyphicon-remove"></span>'
                            + '</button>'
                            + '</div>'
                            + '<?php
foreach ($language as $val) {
    if ($val["Active"] == 1) {
        ?>'
                                    + '<div class="form-group pos_relative2 customPriceField' + z + '">'
                                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                                    + '<div class="col-sm-3 pos_relative2">'
                                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                                    + '<input type="text" name="units[' + z + '][name][<?php echo $val['langCode']; ?>]" value="' + row.name.<?php echo $val['langCode']; ?> + '" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                                    + '</div>'
                                    + ' <div class="col-sm-3 pos_relative2">'
                                    + ' <span  class="abs_text"><b>$</b></span>'
                                    + ' <input type="text" name="units[' + z + '][price][<?php echo $val['langCode']; ?>]" value="' + row.price.<?php echo $val['langCode']; ?> + '" class="form-control productValue" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                                    + ' </div>'
                                    + '<div class=""></div>'
                                    + '</div>'
                                    + '<?php } else { ?>'
                                    + '<div class="form-group pos_relative2 customPriceField' + z + '" style="display:none">'
                                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                                    + '<div class="col-sm-3 pos_relative2">'
                                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                                    + '<input type="text" name="units[' + z + '][name][<?php echo $val['langCode']; ?>]"  value="' + row.name.<?php echo $val['langCode']; ?> + '"  class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                                    + '</div>'
                                    + ' <div class="col-sm-3 pos_relative2">'
                                    + ' <span  class="abs_text">$</b></span>'
                                    + ' <input type="text" name="units[' + z + '][price][<?php echo $val['langCode']; ?>]"  value="' + row.price.<?php echo $val['langCode']; ?> + '" class="form-control productValue" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                                    + ' </div>'
                                    + '<div class=""></div>'
                                    + '</div>'
                                    + '<?php
    }
}
?>'
                            + '<div class="selectedsizeAttr row"></div></div>'

                    $('.customField').append(divElement1);
                    
                    <?php foreach ($productsData['sizes'] as $sizearr) { ?>
                        if (selectedsize.indexOf('<?php echo $sizearr['sizeId']; ?>') == -1) {
                            selectedsize.push('<?php echo $sizearr['sizeId']; ?>');
                        }
                    <?php } ?>

//                    console.log(selectedsize);
                    var sizegroups = $('#sizeGroup option:selected');
                    console.log(sizegroups.length);
                   
                    var selectedSizeAttributes = [];
                            $.each(row.sizeAttributes,function (ind,value){
                                selectedSizeAttributes.push(value.attrId); 
                            });
                            
                          var htmltag = '';
                            
                    if (sizegroups.length > 0) {

                        $(sizegroups).each(function (index, sizeAttr) {
                            var data = $(this).val();
                            if (selectedsize.indexOf($(this).val()) == 0) {

<?php foreach ($size as $sizes) {  ?>
                                    if ('<?php echo $sizes['_id']['$oid']; ?>' == data) {
                                        
                                        htmltag += '<div class="form-group row row-same-height" id="selectedSizeAttr_' + $(this).val() + '">\n\
                                                                                                               <label class="col-sm-2 control-label">Size Attribute</label>\n\
                                                                                                               <div class="col-sm-6"><span class="multiselect-native-select">\n\
                                                                                                               <select class="multiple sizeGroup form-control" id="sizeGroup" name="units[' + z + '][sizeAttr][]" multiple="multiple" >';
                                                                                                                   
                                                                                                                    <?php $selected = '';
                                                                                                                   foreach ($sizes['sizeAttr'] as $siz) { 
                                                                                                                       ?>
                                                                                                                      if(selectedSizeAttributes.indexOf('<?php echo $siz['attrId']['$oid']; ?>') !== -1)
                                                                                                                                htmltag +='<option data-name="<?php echo $siz['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" selected="" class="opt_' + $(this).val() + '"><?php echo $siz['en']; ?></option>';
                                                                                                                            else
                                                                                                                                htmltag +='<option data-name="<?php echo $siz['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + $(this).val() + '"><?php echo $siz['en']; ?></option>';
                                                                                                                     <?php } ?>
                                                                                                                         htmltag +='</select></div></div>';

                                         $('.customField').find('.customPriceField:last').find('.selectedsizeAttr').html(htmltag);
                                                                                                                         
                                                                                                                         
                                                                                                                         
//                                        $('.customField').find('.customPriceField:last').find('.selectedsizeAttr').html('<div class="form-group row row-same-height" id="selectedSizeAttr_' + $(this).val() + '">\n\
//                                                                                                               <label class="col-sm-2 control-label">Size Attribute</label>\n\
//                                                                                                               <div class="col-sm-6"><span class="multiselect-native-select">\n\
//                                                                                                               <select class="multiple sizeGroup form-control" id="sizeGroup" name="units[' + z + '][sizeAttr][]" multiple="multiple" >\n\
//                                                                                                                   <?php // $selected = '';
//                                                                                                                   foreach ($sizes['sizeAttr'] as $siz) { 
                                                                                                                       ?>//<option data-name="<?php echo $siz['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" selected="" class="opt_' + $(this).val() + '"><?php echo $siz['en']; ?></option>\n\
//                                                                                                                     <?php // } ?></select></div></div>');

                                        $('.sizeGroup').multiselect("destroy").multiselect({
                                            selectAllValue: 'multiselect-all',
                                            includeSelectAllOption: true,
                                            enableFiltering: true,
                                            enableCaseInsensitiveFiltering: true,
                                            buttonWidth: '100%',
                                            maxHeight: 300});
                                    }
<?php } ?>
                            }
                        });
                    }

                });

                $.each(response.data, function (index, row) {
                    var k = $('.imageTag').length;
//                    console.log(k);
                    var divElement = '<div class="form-group pos_relative2 imageTag">'
                            + '<label class="col-sm-2 control-label">Image </label>'
                            + '<div class="col-sm-6 pos_relative2">'
                            + '<input type="file" name="imageupload" attrId="' + k + '" class="form-control imagesProduct">'
                            + '<input type="hidden" class="images" id="thumbnailImages' + k + '" name="images[' + k + '][thumbnail]" value="' + row.thumbnail + '"/>'
                            + '<input type="hidden" class="images" id="mobileImages' + k + '" name="images[' + k + '][mobile]" value="' + row.mobile + '"/>'
                            + '<input type="hidden" class="images" id="defaultImages' + k + '" name="images[' + k + '][image]" value="' + row.image + '"/>'

                            + '<input type="hidden" class="images" id="imageId' + k + '" name="images[' + k + '][imageId]" value="' + row.imageId + '"/>'
                            + '<input type="hidden" class="images" id="imageText' + k + '" name="images[' + k + '][imageText]" value="' + row.imageText + '"/>'
                            + '<input type="hidden" class="images" id="title' + k + '" name="images[' + k + '][title]" value="' + row.title + '"/>'
                            + '<input type="hidden" class="images" id="description' + k + '" name="images[' + k + '][description]" value="' + row.description + '"/>'
                            + '<input type="hidden" class="images" id="keyword' + k + '" name="images[' + k + '][keyword]" value="' + row.keyword + '"/>'

                            + '</div>'
                            + '<div class="col-sm-1">'
                            + '<img src="' + row.mobile + '" style="width: 35px;height:35px;" class="text_imagesVal style_prevu_kit">'
                            + '</div>'
                            + '<div class=""></div>'
                            + '<button type="button" class="btn-default btRemove removeButton">'
                            + '<span class="glyphicon glyphicon-remove"></span>'
                            + '</button>'
                            + '</div>';
                    $('.imagesField').append(divElement);
                    renameImageLabelsUnit();
                });



            },
            error: function () {

            },
            cache: false,
            contentType: false,
            processData: false
        });




        // REMOVE ONE ELEMENT PER CLICK.
        $('body').on('click', '.btRemove', function () {
            $(this).parent().remove();
            renameImageLabels();
        });
        $('body').on('click', '.btnRemove', function () {
            $(this).parent().parent().remove();
            renameUnitsLabels();
        });


        $(document).on('change', '.imagesProduct', function () {
            $('#text_images1').text("");
            var fieldID = $(this).attr('attrId');
            var ext = $(this).val().split('.').pop().toLowerCase();
            var formElement = $(this).prop('files')[0];
            uploadImage(fieldID, ext, formElement);

        });

        $('#category').on('change', function () {

            var val = $(this).val();

            $('#subCategory').load("<?php echo base_url('index.php?/SubCategory') ?>/getSubCategoryData", {val: val});


        });


        $('#subCategory').on('change', function () {
            var val = $(this).val();
            $('#subSubCategory').load("<?php echo base_url('index.php?/SubsubCategory') ?>/getSubsubCategoryDataList", {val: val});
        });

        var valCat = "<?php echo $productsData['firstCategoryId']; ?>";

        var entities = '';
        $.ajax({

            url: "<?php echo base_url('index.php?/SubCategory') ?>/getSubCategoryData/" + valCat,
            type: "POST",
            data: {},
            dataType: "JSON",
            success: function (response) {

                $.each(response.data, function (index, row) {
                    entities = '<option data-name="' + row.name + '" value="' + row._id.$oid + '">' + row.name + '</option>';
                    $('#subCategory').append(entities);
                });
                $('#subCategory').val("<?php echo $productsData['secondCategoryId']; ?>");

            },
            error: function () {

            },
            cache: false,
            contentType: false,
            processData: false
        });



        var valSubCat = "<?php echo $productsData['secondCategoryId']; ?>";
        $.ajax({

            url: "<?php echo base_url('index.php?/SubsubCategory') ?>/getSubsubCategoryDataList/" + valSubCat,
            type: "POST",
            data: {},
            dataType: "JSON",
            success: function (response) {

                $.each(response.data, function (index, row) {
                    entities = '<option data-name="' + row.name + '" value="' + row._id.$oid + '">' + row.name + '</option>';
                    $('#subSubCategory').append(entities);
                });

                $('#subSubCategory').val("<?php echo $productsData['thirdCategoryId']; ?>");
            },
            error: function () {

            },
            cache: false,
            contentType: false,
            processData: false
        });

        var arr = [];
        $('#btAdd').click(function () {
            if ($('.imageTag').length < 4) {
//                console.log($('.imageTag').length + 1);
                var k = $('.imageTag').length + 1;
                var divElement = '<div class="form-group pos_relative2 imageTag">'
                        + '<label class="col-sm-2 control-label">Image </label>'
                        + '<div class="col-sm-6 pos_relative2">'
                        + '<input type="file" name="imageupload" attrId="' + k + '" class="form-control imagesProduct">'
                        + '<input type="hidden" id="thumbnailImages' + k + '" name="images[' + k + '][thumbnail]"/>'
                        + '<input type="hidden" id="mobileImages' + k + '" name="images[' + k + '][mobile]"/>'
                        + '<input type="hidden" id="defaultImages' + k + '" name="images[' + k + '][image]"/>'

                        + '<input type="hidden" class="images" id="imageText' + k + '" name="images[' + k + '][imageText]" value=""/>'
                        + '<input type="hidden" class="images" id="title' + k + '" name="images[' + k + '][title]" value=""/>'
                        + '<input type="hidden" class="images" id="description' + k + '" name="images[' + k + '][description]" value=""/>'
                        + '<input type="hidden" class="images" id="keyword' + k + '" name="images[' + k + '][keyword]" value=""/>'

                        + '</div>'
                        + '<div class=""></div>'
                        + '<button type="button" class="btn-default btRemove removeButton">'
                        + '<span class="glyphicon glyphicon-remove"></span>'
                        + '</button>'
                        + '</div>';
                $('.imagesField').append(divElement);
                renameImageLabels();
            } else {
                $('#myModal').modal('show');
            }
        });



        $(document).on('click', '#custom', function () {
//            var html = $('#customePriceMain').html();
//            $('.customField').append(html);
            var len = $('.customPriceField').length;
            var z = len + 1;
            console.log(z);
            var y = z + 1;
            var divElement1 = '<div class="customPriceField row"><div class="form-group pos_relative2 customPriceField' + z + '">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' </label>'
                    + '<div class="col-sm-3 pos_relative2">'
                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    + '<input type="text" name="units[' + len + '][name][en]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                    + '</div>'
                    + ' <div class="col-sm-3 pos_relative2">'
                    + ' <span  class="abs_text"><b>$</b></span>'
                    + ' <input type="text" name="units[' + len + '][price][en]" class="form-control productValue" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                    + ' </div>'
                    + '<div class=""></div>'
                    + '<button type="button" value="' + y + '"class="btn-default btnRemove removeButton">'
                    + '<span class="glyphicon glyphicon-remove"></span>'
                    + '</button>'
                    + '</div>'
                    + '<?php
foreach ($language as $val) {
    if ($val["Active"] == 1) {
        ?>'
                            + '<div class="form-group pos_relative2 customPriceField' + z + '">'
                            + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                            + '<div class="col-sm-3 pos_relative2">'
                            + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                            + '<input type="text" name="units[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                            + '</div>'
                            + ' <div class="col-sm-3 pos_relative2">'
                            + ' <span  class="abs_text"><b>$</b></span>'
                            + ' <input type="text" name="units[' + len + '][price][<?php echo $val['langCode']; ?>]" class="form-control productValue" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                            + ' </div>'
                            + '<div class=""></div>'
                            + '</div>'
                            + '<?php } else { ?>'
                            + '<div class="form-group pos_relative2 customPriceField' + z + '" style="display:none">'
                            + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                            + '<div class="col-sm-3 pos_relative2">'
                            + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                            + '<input type="text" name="units[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                            + '</div>'
                            + ' <div class="col-sm-3 pos_relative2">'
                            + ' <span  class="abs_text"><b>$</b></span>'
                            + ' <input type="text" name="units[' + len + '][price][<?php echo $val['langCode']; ?>]" class="form-control productValue" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                            + ' </div>'
                            + '<div class=""></div>'
                            + '</div>'
                            + '<?php
    }
}
?>'
                    + '<div class="selectedsizeAttr row"></div></div>'

//                            + '</div><div class="selectedsizeAttr row"></div>'

            $('.customField').append(divElement1);
            var sizegroups = $('#sizeGroup option:selected');
//                            console.log(sizegroups.length);
            if (sizegroups.length > 0) {

                $(sizegroups).each(function (index, sizeAttr) {
                    var data = $(this).val();
//                                                    console.log(selectedsize.indexOf($(this).val()));
                    if (selectedsize.indexOf($(this).val()) == 0) {

<?php foreach ($size as $sizes) { ?>
                            if ('<?php echo $sizes['_id']['$oid']; ?>' == data) {

                                $('.customField').find('.customPriceField:last').find('.selectedsizeAttr').html('<div class="form-group row row-same-height" id="selectedSizeAttr_' + $(this).val() + '">\n\
                                                                                                               <label class="col-sm-2 control-label">Size Attribute</label>\n\
                                                                                                               <div class="col-sm-6"><span class="multiselect-native-select">\n\
                                                                                                               <select class="multiple sizeGroup form-control" id="sizeGroup" name="units[' + len + '][sizeAttr][]" multiple="multiple" >\n\
    <?php foreach ($sizes['sizeAttr'] as $siz) {
        ?><option data-name="<?php echo $siz['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + $(this).val() + '" ><?php echo $siz['en']; ?></option>\n\
    <?php } ?></select></div></div>');

                                $('.sizeGroup').multiselect("destroy").multiselect({
                                    selectAllValue: 'multiselect-all',
                                    includeSelectAllOption: true,
                                    enableFiltering: true,
                                    enableCaseInsensitiveFiltering: true,
                                    buttonWidth: '100%',
                                    maxHeight: 300});
                            }
<?php } ?>
                    }
                });
            }

        });


//        $('#custom').click(function () {
//            var z = $('.customPriceField').length + 1;
//
//            var divElement1 = '<div class="form-group pos_relative2 customPriceField">'
//                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units <span class="MandatoryMarker"> *</span></label>'
//                    + '<div class="col-sm-3 pos_relative2">'
//                    + '<span  class="abs_text"><b>Title</b></span>'
//                    + '<input type="text" name="units[' + z + '][title]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
//                    + '</div>'
//                    + ' <div class="col-sm-3 pos_relative2">'
//                    + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
//                    + ' <input type="text" name="units[' + z + '][value]" class="form-control productValue" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
//                    + ' </div>'
//                    + '<div class=""></div>'
//                    + '<button type="button" class="btn-default btnRemove removeButton">'
//                    + '<span class="glyphicon glyphicon-remove"></span>'
//                    + '</button>'
//                    + '</div>';
//            $('.customField').append(divElement1);
//            renameUnitsLabels();
//
//        });



        $("#mobile").on("countrychange", function (e, countryData) {

            $("#coutry-code").val(countryData.dialCode);
        });





        $("#name").keypress(function (event) {
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

        /* activate scrollspy menu */
        $('body').scrollspy({
            target: '#navbar-collapsible',
            offset: 50
        });

        /* smooth scrolling sections */
        $('a[href*=#]:not([href=#])').click(function () {
            var scr = jQuery(window).scrollTop();
            if (scr > 50) {
                $('#mytabss').addClass('fixednab');
            } else {
                $('#mytabss').removeClass('fixednab');
            }

            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top - 50
                    }, 1000);
                    return false;
                }
            }
        });


    });



    function uploadImage(fieldID, ext, formElement)
    {

        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            alert('invalid extension..!   Please choose file type in (gif,png,jpg,jpeg)');
        } else
        {
            var form_data = new FormData();
            var amazonPath = " http://s3.amazonaws.com"
            form_data.append('sampleFile', formElement);
            $(document).ajaxStart(function () {
                $("#wait").css("display", "block");
            });
            $.ajax({
                url: "<?php echo uploadImageLink; ?>",
                type: "POST",
                data: form_data,
                dataType: "JSON",

                beforeSend: function () {

                },
                success: function (response) {

                    $.each(response.data, function (index, row) {
                        console.log(row);
                        switch (index) {
                            case 0:
                                $('#thumbnailImages' + fieldID + '').val(amazonPath + row.path);
                                break;
                            case 1:
                                $('#mobileImages' + fieldID + '').val(amazonPath + row.path);
                                break;
                            case 2:
                                $('#defaultImages' + fieldID + '').val(amazonPath + row.path);
                                break;
                        }

                        $(document).ajaxComplete(function () {
                            $("#wait").css("display", "none");
                        });
                        $('.finishbutton').removeAttr('disabled');
                        $('.finishbutton').removeClass("disabled");

                    });



                },
                error: function () {

                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    }

</script>


<div class="page-content-wrapper">
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb" style="margin-left: 0px; margin-top: 5%;">
        <li><a
                href="<?php echo base_url(); ?>index.php?/AddNewProducts"
                class=""><?php echo LIST_PRODUCTS; ?></a></li>

        <li style="width: 100px"><a href="#" class="active">Edit</a>
        </li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class=" bg-white" data-pages="parallax">
            <div class="inner"></div>


            <div class="container-fluid container-fixed-lg bg-white">

                <div id="navbar-collapsible"  class="navbar-collapse collapse m-t-50">
                    <!-- Nav tabs -->
                    <ul class="navbar-nav navbar-left nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabss" style=" -webkit-transition: top .5s; transition: top .5s;">

                        <li class="active" >
                            <a class="" data-toggle="tab" role="tab" href="#tab1" >
                                <span style="color:black"><?php echo LIST_PRODUCT_GENERALDETAILS; ?></span></a>
                        </li>
                        <li>
                            <a class=""data-toggle="tab" role="tab" href="#tab2" >
                                <span style="color:black">UNITS</span></a>
                        </li>
                        <li style="display:none">
                            <a class="" data-toggle="tab" role="tab" href="#tab3" >
                                <span style="color:black"><?php echo LIST_STRAIN_ATTRIBUTES_AND_FLAVOURS; ?></span></a>
                        </li>
                        <li>
                            <a class="" data-toggle="tab" role="tab" href="#tab4" >
                                <span style="color:black"><?php echo LIST_PRODUCT_IMAGES; ?></span></a>
                        </li>
                        <li>
                            <a class="" data-toggle="tab" role="tab" href="#tab5" >
                                <span style="color:black">ADDITIONAL DETAILS</span></a>
                        </li>

                    </ul>
                    <div class="row"><br></div>
                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form"
                          action="<?php echo base_url(); ?>index.php?/AddNewProducts/updateProductData/<?php echo $productId; ?>"
                          method="post" enctype="multipart/form-data" onsubmit="return redirectToDest()">


                        <div class="tab-content">
                            <section class="" id="tab1">
                                <div class="row row-same-height">

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Name'); ?> <span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="name_0" name="productName[0]"
                                                   required="required" value="<?php echo $productsData['productName'][0]; ?>" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if($val['Active'] == 1){
                                        ?>
                                        <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="productName[<?= $val['lan_id'] ?>]"
                                                          value="<?php echo $productsData['productName'][$val['lan_id']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box" id="text_name"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="productName[<?= $val['lan_id'] ?>]"
                                                          value="<?php echo $productsData['productName'][$val['lan_id']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box" id="text_name"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('lable_Category'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="category" name="firstCategoryId"  class="form-control error-box-class">
                                                <option data-name="Select Category" value=""><?php echo $this->lang->line('label_SelectCategory'); ?></option>

                                                <?php
                                                foreach ($category as $result) {
                                                    if ($result['categoryId'] == $productsData['firstCategoryId']) {
                                                        echo "<option selected data-name='" . implode(';', $result['name']) . "' data-id=" . $result['categoryId'] . " value=" . $result['categoryId'] . ">" . implode(',', $result['name']) . "</option>";
                                                    } else {
                                                        echo "<option data-name='" . implode(';', $result['name']) . "' data-id=" . $result['categoryId'] . " value=" . $result['categoryId'] . ">" . implode(',', $result['name']) . "</option>";
                                                    }
                                                }
                                                ?>

                                            </select> 


                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_category"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SubCategory'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="subCategory" name="secondCategoryId"  class="form-control error-box-class">
                                                <option data-name="Select Category" value=""><?php echo $this->lang->line('label_SelectSubCategory'); ?></option>

                                            </select>  

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_subCategory"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SubSubCategory'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="subSubCategory" name="thirdCategoryId"  class="form-control error-box-class">
                                                <option data-name="Select Category" value="0"><?php echo $this->lang->line('label_SelectSubSubCategory'); ?></option>

                                            </select>  
                                            <input type="hidden" name="firstCategoryName" id="firstCategoryName" value="" />
                                            <input type="hidden" name="secondCategoryName" id="secondCategoryName" value="" />
                                            <input type="hidden" name="thirdCategoryName" id="thirdCategoryName" value="" />
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_subSubCategory"></div>
                                    </div>
                                    <div class="form-group pos_relative2 hide">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Sku'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="sku" name="sku" required="required" value="<?php echo $productsData['sku']; ?>" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_sku"></div>
                                    </div>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Barcode'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="barcode" name="barcode"
                                                   required="required" value="<?php echo $productsData['barcode']; ?>" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_barcode"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SDescription'); ?> <span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="shortDescription" name="shortDescription[0]" value="<?php echo $productsData['shortDesc'][0]; ?>" 
                                                   required="required" class="error-box-class  form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_shortDescription"></div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SDescription'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="shortDescription" name="shortDescription[<?= $val['lan_id']; ?>]"
                                                           value="<?php echo $productsData['shortDesc'][$val['lan_id']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_shortDescription"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SDescription'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="shortDescription" name="shortDescription[<?= $val['lan_id']; ?>]"
                                                           value="<?php echo $productsData['shortDesc'][$val['lan_id']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_shortDescription"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DDescription'); ?> </label>
                                        <div class="col-sm-6 pos_relative2">

                                            <textarea id="detailedDescription" name="detailedDescription[0]" value="<?php echo $productsData['detailedDesc'][0]; ?>" 
                                                      required="required" class="error-box-class  form-control" style=" max-width: 100%;"><?php echo $productsData['detailedDesc'][0]; ?></textarea>

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DDescription'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <textarea id="detailedDescription" name="detailedDescription[<?= $val['lan_id']; ?>]"
                                                              value="<?php echo $productsData['detailedDesc'][$val['lan_id']]; ?>"  required="required" class="error-box-class  form-control" style=" max-width: 100%;"><?php echo $productsData['detailedDesc'][$val['lan_id']]; ?></textarea>

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DDescription'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <textarea id="detailedDescription" name="detailedDescription[<?= $val['lan_id']; ?>]"
                                                              value="<?php echo $productsData['detailedDesc'][$val['lan_id']]; ?>" required="required" class="error-box-class  form-control" style=" max-width: 100%;"><?php echo $productsData['detailedDesc'][$val['lan_id']]; ?></textarea>

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2" style="display:none">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Manufacturer'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="manufacturer" name="manufacturer"  class="form-control error-box-class">
                                                <option data-name="Select Manufacturer" value="">Select Manufacturer</option>
                                                <?php
                                                foreach ($manufacturer as $result) {
                                                    if ($productsData['manufactureName']['en'] == $result['Name'][0]) {
                                                        echo "<option data-name='" . implode(',', $result['Name']) . "' data-id=" . $result['_id']['$oid'] . " value=" . $result['_id']['$oid'] . " selected>" . implode(',', $result['Name']) . "</option>";
                                                    } else {
                                                        echo "<option data-name='" . implode(',', $result['Name']) . "' data-id=" . $result['_id']['$oid'] . " value=" . $result['_id']['$oid'] . ">" . implode(',', $result['Name']) . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select> 
                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_Manufacturer"></div>
                                    </div>
                                    <div class="form-group pos_relative2" style="display:none">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Brands'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="brand" name="brand" class="form-control error-box-class" >
                                                <option data-name="Select Brand" value="">Select Brand</option>
                                                <?php
                                                foreach ($brands as $brand) {
                                                    if ($productsData['brandTitle']['en'] == $brand['brandName'][0]) {
                                                        echo "<option data-name='" . implode(',', $brand['brandName']) . "' data-id=" . $brand['_id']['$oid'] . " value=" . $brand['_id']['$oid'] . " selected>" . implode(',', $brand['brandName']) . "</option>";
                                                    } else {
                                                        echo "<option data-name='" . implode(',', $brand['brandName']) . "' data-id=" . $brand['_id']['$oid'] . " value=" . $brand['_id']['$oid'] . ">" . implode(',', $brand['brandName']) . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select> 
                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_brands"></div>
                                    </div>
                                    <div class="form-group required" style="display:none">
                                        <label class="col-sm-2 control-label"><?php echo $this->lang->line('label_Size'); ?></label>
                                        <div class="col-sm-6">
                                            <div class="multiselect sizeMultiSelect">
                                                <div class="selectBox" style="width: 102%;">
                                                    <select class="multiple form-control" id="sizeGroup" name="size[]" multiple="multiple" >
                                                        <?php
                                                        $sizeIds = [];
                                                        foreach ($productsData['sizes'] as $sizeData) {
                                                            array_push($sizeIds, $sizeData['sizeId']);
                                                        }
                                                        foreach ($size as $dataData) {
                                                            if (in_array($dataData['_id']['$oid'], $sizeIds)) {
                                                                echo "<option data-name='" . implode(',', $dataData['sizeName']) . "' data-id=" . $dataData['_id']['$oid'] . " value=" . $dataData['_id']['$oid'] . " selected>" . implode(',', $dataData['sizeName']) . "</option>";
                                                            } else {
                                                                echo "<option data-name='" . implode(',', $dataData['sizeName']) . "' data-id=" . $dataData['_id']['$oid'] . " value=" . $dataData['_id']['$oid'] . ">" . implode(',', $dataData['sizeName']) . "</option>";
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>

                                            </div>
                                            <label id="size-error" class="error" style="display:none">This field is required.</label>
                                        </div>
                                        <div class="col-sm-3 error-box" id="sizeErr"></div>

                                    </div>
                                    <script>

                                        $('#sizeGroup').multiselect({
                                            selectAllValue: 'multiselect-all',
                                            includeSelectAllOption: true,
                                            enableFiltering: true,
                                            enableCaseInsensitiveFiltering: true,
                                            buttonWidth: '100%',
                                            maxHeight: 300,
                                            onChange: function (element, checked) {
                                                var unitcount = $('.customPriceField').length;
                                                var sizegroups = $('#sizeGroup option:selected');

                                                $(sizegroups).each(function (index, brand) {

                                                    var data = $(this).val();
                                                    if (selectedsize.indexOf($(this).val()) == -1) {

<?php foreach ($size as $sizes) { ?>
                                                            if ('<?php echo $sizes['_id']['$oid']; ?>' == data) {
                                                                if (sizegroups.length == 1) {

                                                                    $('.selectedsizeAttr').removeClass('hidden');
                                                                    $('.selectedsizeAttr').append('<div class="form-group row row-same-height" id="selectedSizeAttr_' + $(this).val() + '">\n\
                                                                                                               <label class="col-sm-2 control-label">Size Attribute</label>\n\
                                                                                                               <div class="col-sm-6"><span class="multiselect-native-select">\n\
                                                                                                               <select class="multiple sizeGroup form-control" id="sizeGroup" name="units[0][sizeAttr][]" multiple="multiple" >\n\
    <?php foreach ($sizes['sizeAttr'] as $siz) {
        ?><option data-name="<?php echo $siz['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + $(this).val() + '" ><?php echo $siz['en']; ?></option>\n\
    <?php } ?></select></div></div>');

                                                                } else {
    <?php foreach ($sizes['sizeAttr'] as $siz) { ?>
                                                                        $('.sizeGroup').append('<option data-name="<?php echo $siz['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + $(this).val() + '" ><?php echo $siz['en']; ?></option>');
    <?php } ?>
                                                                }
                                                                $('.sizeGroup').multiselect("destroy").multiselect({
                                                                    selectAllValue: 'multiselect-all',
                                                                    includeSelectAllOption: true,
                                                                    enableFiltering: true,
                                                                    enableCaseInsensitiveFiltering: true,
                                                                    buttonWidth: '100%',
                                                                    maxHeight: 300});
                                                            }
<?php } ?>
                                                        selectedsize.push($(this).val());
                                                    }

                                                });

//                                                console.log(selectedsize);
                                                if (!checked) {
                                                    $('.opt_' + $(element).val()).remove();
                                                    $('.sizeGroup').multiselect({
                                                        selectAllValue: 'multiselect-all',
                                                        includeSelectAllOption: true,
                                                        enableFiltering: true,
                                                        enableCaseInsensitiveFiltering: true,
                                                        buttonWidth: '100%',
                                                        maxHeight: 300});
                                                }
                                            }
                                        });
                                    </script>
                                    <div class="form-group required" style="display:none">
                                        <label class="col-sm-2 control-label"><?php echo $this->lang->line('label_Colors'); ?></label>
                                        <div class="col-sm-6">
                                            <!--onclick="showCheckboxesColor()"-->
                                            <div class="multiselect">
                                                <div class="selectBox"  style="width: 102%;">
                                                    <select class="multiple form-control" name="color[]" multiple="multiple">
                                                        <?php
                                                        $colorIds = [];
                                                        foreach ($productsData['colors'] as $colorData) {
                                                            array_push($colorIds, $colorData['colorId']);
                                                        }

                                                        foreach ($color as $colors) {
                                                            if (in_array($colors['_id']['$oid'], $colorIds)) {
                                                                echo "<option data-name='" . implode(',', $colors['name']) . "' data-id=" . $colors['_id']['$oid'] . " value=" . $colors['_id']['$oid'] . " selected>" . implode(',', $colors['name']) . "</option>";
                                                            } else {
                                                                echo "<option data-name='" . implode(',', $colors['name']) . "' data-id=" . $colors['_id']['$oid'] . " value=" . $colors['_id']['$oid'] . ">" . implode(',', $colors['name']) . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>

                                            </div>
                                            <label id="colors-error" class="error" style="display:none">This field is required.</label>
                                        </div>
                                        <div class="col-sm-3 error-box" id="colorsErr"></div>

                                    </div>
                                    
                                    <script>
                                        $(document).ready(function () {
                                            var taxes = $('#tax option:selected');

                                            $(taxes).each(function (index, tax) {

                                                if (select.indexOf($(this).val()) == -1) {
                                                    $('.selectTax').removeClass('hidden');
                                                    $('.selectTax').append("<div class='form-group' id='" + $(this).val() + "'><div class='col-sm-2' ></div>\n\
                                                                        \n\<label for='fname' class='col-sm-2 control-label'>" + $(this).attr('data-name') + "</label>\n\
                                                                        <div class='col-sm-4' ><select id='" + $(this).attr('data-name') + "' name='taxFlag[]' class='selectType form-control error-box-class'>\n\
                                                                        <option value='' >select Type </option>\n\
<?php if ($productsData['taxes']['taxFlag'] == 0) { ?>\n\
                                                                             <option value='0' selected >Inclusive </option>\n\
                                                                             <option value='1'>exclusive </option>\n\
<?php } else if ($productsData['taxes']['taxFlag'] == 1) { ?>\n\
                                                                             <option value='0' >Inclusive </option>\n\
                                                                             <option value='1' selected>exclusive </option>\n\
<?php } ?>\n\
                                                                        </select>\n\
                                                                        </div><div class='col-sm-3 error-box redClass' id='text_taxflag'></div></div>");
                                                    select.push($(this).val());
                                                }
                                            });
                                        });

                                        $('#tax').multiselect({
                                            selectAllValue: 'multiselect-all',
                                            includeSelectAllOption: true,
                                            enableFiltering: true,
                                            enableCaseInsensitiveFiltering: true,
                                            buttonWidth: '100%',
                                            maxHeight: 300,
                                            onChange: function (element, checked) {


                                                var brands = $('#tax option:selected');

                                                $(brands).each(function (index, brand) {

                                                    if (select.indexOf($(this).val()) == -1) {
                                                        $('.selectTax').removeClass('hidden');
                                                        $('.selectTax').append("<div class='form-group' id='" + $(this).val() + "'><div class='col-sm-2' ></div>\n\
                                                                        \n\<label for='fname' class='col-sm-2 control-label'>" + $(this).attr('data-name') + "</label>\n\
                                                                        <div class='col-sm-4' ><select id='" + $(this).attr('data-name') + "' name='taxFlag[]' class='selectType form-control error-box-class'>\n\
                                                                        <option value='' >select Type </option>\n\
                                                                        <option value='0' >Inclusive </option>\n\
                                                                        <option value='1' >exclusive </option>\n\
                                                                        </select>\n\
                                                                        </div><div class='col-sm-3 error-box redClass' id='text_taxflag'></div></div>");
                                                        select.push($(this).val());
                                                    }
                                                });

                                                $('input:checkbox').each(function (index, value) {

                                                    if ($(this).is(':checked')) {
                                                    } else {

                                                        var index = select.indexOf($(this).val());
                                                        if (index !== -1)
                                                            select.splice(index, 1);
                                                        $('#' + $(this).val()).remove();
                                                    }
                                                });

//                                                console.log(select);

                                            }
                                        });
                                    </script>

                                    <!--//-->
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_PosName'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="POSName" name="POSName[0]" value="<?php echo $productsData['pos']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_POSName"></div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_PosName'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="POSName" name="POSName[<?= $val['lan_id']; ?>]"
                                                           value="<?php echo $productsData['pos'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_POSName"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_PosName'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="POSName" name="POSName[<?= $val['lan_id']; ?>]"
                                                           value="<?php echo $productsData['pos'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_POSName"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_BarcodeFormat'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="barcodeFormat" name="barcodeFormat"
                                                   required="required" class="form-control" value="<?php echo $productsData['barcodeFormat']; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_barcodeFormat"></div>
                                    </div>

                                     <hr>
                                 <h6 class="textAlign" >RECOMMEND FOR CONSUMPTION</h6>
                                 <hr>

                                    <div class="form-group" >
                                    <label class="checkbox-inline">
                                    <input type="checkbox" <?php echo $breakfast;?>  class="consumptionTime" value="breakfast" name ="consumptionTime[]"><span style="font-weight: 700;">Breakfast </span></label>
                                   
                                    <label class="checkbox-inline">
                                    <input type="checkbox" <?php echo $brunch;?> class="consumptionTime" value="brunch" name ="consumptionTime[]"><span style="font-weight: 700;">Brunch </span></label>
                                   
                                    <label class="checkbox-inline">
                                    <input type="checkbox" <?php echo $lunch;?> class="consumptionTime" value="lunch" name ="consumptionTime[]"><span style="font-weight: 700;">lunch</span></label>
                                    <label class="checkbox-inline">
                                    <input type="checkbox" <?php echo $tea;?> class="consumptionTime" value="tea" name ="consumptionTime[]"><span style="font-weight: 700;">Tea And Snack</span></label>
                                    <label class="checkbox-inline">
                                    <input type="checkbox" <?php echo $dinner;?> class="consumptionTime" value="dinner" name ="consumptionTime[]"><span style="font-weight: 700;">Dinner</span></label>
                                    <label class="checkbox-inline">
                                    <input type="checkbox" <?php echo $latenightdinner;?> class="consumptionTime" value="latenightdinner" name ="consumptionTime[]"><span style="font-weight: 700;">Late Night Dinner</span></label>
                                  
                                    </div>

                                    <div class="form-group pos_relative2" style="display:none">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_THC'); ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="THC" name="THC" onkeypress="return isNumberKey(event)" value="<?php echo $productsData['THC']; ?>">
                                        </div>

                                        <div class="col-sm-3 error-box redClass" id="text_THC"></div>
                                    </div>
                                    <div class="form-group pos_relative2" style="display:none">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_CBD'); ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="CBD" name="CBD" onkeypress="return isNumberKey(event)" value="<?php echo $productsData['CBD']; ?>">
                                        </div>
                                        <input type="hidden" id="THC" name="THC" value="0"/>
										<input type="hidden" id="CBD" name="CBD" value="0"/>
                                        <div class="col-sm-3 error-box redClass" id="text_CBD"></div>
                                    </div>

                                </div>
                            </section>
                            <section class="" id="tab2">
                                <div class="row row-same-height">
                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo UNITS; ?></label>

                                    </div>
                                    <hr/>
                                    <div id="main1" class="row ">
                                        <div class="" id="text_productTitleText ">
                                            <button  type="button" id="custom"  class="btn btn-default btn-primary pull-right" style="margin-right: 20%;border-radius: 25px;">Add</button>

                                        </div>

                                    </div>
                                    <div class="customField row">
                                        <div class="customPriceField row" id="customePriceMain">

                                        </div>
                                    </div>

                                </div>
                            </section>

                        

                            <section class="" id="tab4">
                                <div class="row row-same-height">
                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo LIST_PRODUCT_IMAGES; ?></label>

                                    </div>
                                    <hr/>
                                    <div id="main" class="row">
                                        <button type="button" id="btAdd" class="btn btn-default pull-right marginSet btn-primary">
                                            <span class="glyphicon glyphicon-plus">Add Field</span>
                                        </button>

                                    </div>



                                    <div class="imagesField row">
                                        <div class="form-group pos_relative2">

                                        </div>
                                    </div>

                                </div>
                            </section>

                            <!--<section class="" id="tab5">
                                <div class="row row-same-height">
                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('ADDITIONAL_DETAILS'); ?></label>

                                    </div>
                                    <hr/>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_UPC'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="upc" name="upcName[en]" value="<?php echo $productsData['upcName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_UPC'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="upc_<?php echo $val['langCode']; ?>" name="upcName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['upcName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_UPC'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="upc_<?php echo $val['langCode']; ?>"  name="upcName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['upcName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_MPN'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="mpn" name="mpnName[en]" value="<?php echo $productsData['mpnName']['en']; ?>" 
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_MPN'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="mpn_<?php echo $val['langCode']; ?>" name="mpnName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['mpnName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_MPN'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="mpn_<?php echo $val['langCode']; ?>"  name="mpnName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['mpnName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Model'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="model" name="modelName[en]" value="<?php echo $productsData['modelName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Model'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="model_<?php echo $val['langCode']; ?>" name="modelName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['modelName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Model'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="model_<?php echo $val['langCode']; ?>"  name="modelName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['modelName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ShelflifeUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomShelfLife" name="uomShelfLife[en]"  value="<?php echo $productsData['uomShelfLife']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ShelflifeUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomShelfLife_<?php echo $val['langCode']; ?>" name="uomShelfLife[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['uomShelfLife'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ShelflifeUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomShelfLife_<?php echo $val['langCode']; ?>"  name="uomShelfLife[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['uomShelfLife'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_uomShelfLife"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_StorageTemperatureUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="UOMstorageTemperature" name="UOMstorageTemperature[en]" value="<?php echo $productsData['UOMstorageTemperature']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_UOMstorageTemperature"></div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_StorageTemperatureUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="UOMstorageTemperature_<?php echo $val['langCode']; ?>" name="UOMstorageTemperature[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['UOMstorageTemperature'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_UOMstorageTemperature"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_StorageTemperatureUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="UOMstorageTemperature_<?php echo $val['langCode']; ?>"  name="UOMstorageTemperature[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['UOMstorageTemperature'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_UOMstorageTemperature"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Warning'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="warningName" name="warningName[en]" value="<?php echo $productsData['warningName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Warning'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="warningName_<?php echo $val['langCode']; ?>" name="warningName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['warningName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Warning'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="warningName_<?php echo $val['langCode']; ?>"  name="warningName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['warningName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_AllergyInformation'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="allergyInfo" name="allergyInfo[en]" value="<?php echo $productsData['allergyInfo']['en']; ?>" 
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_AllergyInformation'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="allergyInfo_<?php echo $val['langCode']; ?>" name="allergyInfo[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['allergyInfo'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_AllergyInformation'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="allergyInfo_<?php echo $val['langCode']; ?>"  name="allergyInfo[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['allergyInfo'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Servingspercalories'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerCalories" name="nutritionFactsInfo[servingPerCalories][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerCalories']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Servingspercalories'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCalories_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerCalories][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerCalories'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Servingspercalories'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCalories_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerCalories][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerCalories'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_CholesterolUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomCholesterol" name="nutritionFactsInfo[uomCholesterol][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['uomCholesterol']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_CholesterolUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomCholesterol_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[uomCholesterol][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomCholesterol'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_CholesterolUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomCholesterol][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomCholesterol'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>



                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Cholesterolperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerCholesterol" name="nutritionFactsInfo[servingPerCholesterol][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerCholesterol']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Cholesterolperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCholesterol_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerCholesterol][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerCholesterol'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Cholesterolperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerCholesterol][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerCholesterol'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fatcaloriesperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerFatCalories" name="nutritionFactsInfo[servingPerFatCalories][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerFatCalories']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fatcaloriesperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCholesterol_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerFatCalories][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerFatCalories'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fatcaloriesperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerFatCalories][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerFatCalories'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_FibreUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomFibre" name="nutritionFactsInfo[uomFibre][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['uomFibre']['en']; ?>"  required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_FibreUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomFibre_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[uomFibre][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomFibre'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_FibreUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomFibre_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomFibre][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomFibre'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fibreperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerFibre" name="nutritionFactsInfo[servingPerFibre][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerFibre']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fibreperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerFibre_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerFibre][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerFibre'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fibreperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerFibre_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerFibre][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerFibre'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SodiumUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomSodium" name="nutritionFactsInfo[uomSodium][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['uomSodium']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SodiumUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomSodium_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[uomSodium][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomSodium'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SodiumUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomSodium_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomSodium][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomSodium'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Sodiumperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="sodiumPerServing" name="nutritionFactsInfo[sodiumPerServing][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['sodiumPerServing']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Sodiumperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="sodiumPerServing_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[sodiumPerServing][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['sodiumPerServing'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Sodiumperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="sodiumPerServing_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[sodiumPerServing][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['sodiumPerServing'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ProteinUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomProtein" name="nutritionFactsInfo[uomProtein][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['uomProtein']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ProteinUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomProtein_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[uomProtein][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomProtein'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ProteinUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomProtein_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomProtein][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomProtein'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>




                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Proteinperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerProtein" name="nutritionFactsInfo[servingPerProtein][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerProtein']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Proteinperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerProtein_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerProtein][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerProtein'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Proteinperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerProtein_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerProtein][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerProtein'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TotalfatUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomTotalFat" name="nutritionFactsInfo[uomTotalFat][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['uomTotalFat']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TotalfatUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomTotalFat_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[uomTotalFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomTotalFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TotalfatUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomTotalFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomTotalFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomTotalFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Totalfatperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerTotalFat" name="nutritionFactsInfo[servingPerTotalFat][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerTotalFat']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Totalfatperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerTotalFat_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerTotalFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerTotalFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Totalfatperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerTotalFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerTotalFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerTotalFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>



                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TransfatUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomTransFat" name="nutritionFactsInfo[uomTransFat][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['uomTransFat']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TransfatUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomTransFat_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[uomTransFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomTransFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TransfatUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomTransFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomTransFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomTransFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Transfatperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerTransFat" name="nutritionFactsInfo[servingPerTransFat][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerTransFat']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Transfatperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerTransFat_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerTransFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerTransFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Transfatperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerTransFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerTransFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerTransFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCholesterol'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="cholesterolDVP" name="nutritionFactsInfo[cholesterolDVP][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['cholesterolDVP']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCholesterol'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="cholesterolDVP_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[cholesterolDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['cholesterolDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCholesterol'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="cholesterolDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[cholesterolDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['cholesterolDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCalcium'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="calciumDVP" name="nutritionFactsInfo[calciumDVP][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['calciumDVP']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCalcium'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="calciumDVP_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[calciumDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['calciumDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCalcium'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="calciumDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[calciumDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['calciumDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>



                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPIron'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="ironDVP" name="nutritionFactsInfo[ironDVP][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['ironDVP']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPIron'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="ironDVP_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[ironDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['ironDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPIron'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="ironDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[ironDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['ironDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSodium'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="sodiumDVP" name="nutritionFactsInfo[sodiumDVP][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['sodiumDVP']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSodium'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="sodiumDVP_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[sodiumDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['sodiumDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSodium'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="sodiumDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[sodiumDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['sodiumDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>



                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSaturatedFat'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="saturatedFatDVP" name="nutritionFactsInfo[saturatedFatDVP][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['saturatedFatDVP']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSaturatedFat'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="saturatedFatDVP_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[saturatedFatDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['saturatedFatDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSaturatedFat'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="saturatedFatDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[saturatedFatDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['saturatedFatDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPTotalFat'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="totalFatDVP" name="nutritionFactsInfo[totalFatDVP][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['totalFatDVP']['en']; ?>"  required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPTotalFat'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="totalFatDVP_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[totalFatDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['totalFatDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPTotalFat'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="totalFatDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[totalFatDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['totalFatDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>





                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminA'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="vitaminADvp" name="nutritionFactsInfo[vitaminADvp][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['vitaminADvp']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminA'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminADvp_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[vitaminADvp][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['vitaminADvp'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminA'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminADvp_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[vitaminADvp][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['vitaminADvp'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>



                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminC'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="vitaminCDvp" name="nutritionFactsInfo[vitaminCDvp][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['vitaminCDvp']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminC'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminCDvp_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[vitaminCDvp][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['vitaminCDvp'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminC'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminCDvp_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[vitaminCDvp][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['vitaminCDvp'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminD'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="vitaminDDvp" name="nutritionFactsInfo[vitaminDDvp][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['vitaminDDvp']['en']; ?>" required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminD'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminDDvp_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[vitaminDDvp][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['vitaminDDvp'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminD'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminDDvp_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[vitaminDDvp][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['vitaminDDvp'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Container'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="containerName" name="containerName[en]"
                                                   value="<?php echo $productsData['containerName']['en']; ?>"  required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Container'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="containerName_<?php echo $val['langCode']; ?>" name="containerName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['containerName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Container'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="containerName_<?php echo $val['langCode']; ?>"  name="containerName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['containerName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>



                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Containerperservings'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="containerPerServings" name="containerPerServings[en]"
                                                   value="<?php echo $productsData['containerPerServings']['en']; ?>"  required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Containerperservings'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="containerPerServings_<?php echo $val['langCode']; ?>" name="containerPerServings[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['containerPerServings'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Containerperservings'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="containerPerServings_<?php echo $val['langCode']; ?>"  name="containerPerServings[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['containerPerServings'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Genre'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="genreName" name="genreName[en]" value="<?php echo $productsData['genreName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Genre'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="genreName_<?php echo $val['langCode']; ?>" name="genreName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['genreName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Genre'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="genreName_<?php echo $val['langCode']; ?>"  name="genreName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['genreName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>




                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Label'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="labelName" name="labelName[en]"  value="<?php echo $productsData['labelName']['en']; ?>" 
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Label'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="labelName_<?php echo $val['langCode']; ?>" name="labelName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['labelName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Label'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="labelName_<?php echo $val['langCode']; ?>"  name="labelName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['labelName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Artist'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="artistName" name="artistName[en]" value="<?php echo $productsData['artistName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Artist'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="artistName_<?php echo $val['langCode']; ?>" name="artistName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['artistName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Artist'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="artistName_<?php echo $val['langCode']; ?>"  name="artistName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['artistName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Actor'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="actorName" name="actorName[en]" value="<?php echo $productsData['actorName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Actor'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="actorName_<?php echo $val['langCode']; ?>" name="actorName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['actorName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Actor'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="actorName_<?php echo $val['langCode']; ?>"  name="actorName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['actorName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Director'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="directorName" name="directorName[en]" value="<?php echo $productsData['directorName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Director'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="directorName_<?php echo $val['langCode']; ?>" name="directorName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['directorName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Director'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="directorName_<?php echo $val['langCode']; ?>"  name="directorName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['directorName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Feature'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="featureName" name="featureName[en]" value="<?php echo $productsData['featureName']['en']; ?>" 
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Feature'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="featureName_<?php echo $val['langCode']; ?>" name="featureName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['featureName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Feature'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="featureName_<?php echo $val['langCode']; ?>"  name="featureName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['featureName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Publisher'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="publisherName" name="publisherName[en]" value="<?php echo $productsData['publisherName']['en']; ?>" 
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Publisher'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="publisherName_<?php echo $val['langCode']; ?>" name="publisherName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['publisherName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Publisher'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="publisherName_<?php echo $val['langCode']; ?>"  name="publisherName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['publisherName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Author'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="authorName" name="authorName[en]" value="<?php echo $productsData['authorName']['en']; ?>" 
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Author'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="authorName_<?php echo $val['langCode']; ?>" name="authorName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['authorName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Author'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="authorName_<?php echo $val['langCode']; ?>"  name="authorName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['authorName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    
                                    


                                </div>
                            </section>-->
							
							
							<section class="" id="tab5">
                                <div class="row row-same-height">
                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('ADDITIONAL_DETAILS'); ?></label>

                                    </div>
                                    <hr/>
									
									<div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Ingredients'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="ingredients" name="ingredients[en]" value="<?php echo $productsData['ingredients']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="ingredients[keyName][en]" value="ingredients" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Ingredients'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="ingredients_<?php echo $val['langCode']; ?>" name="ingredients[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['ingredients'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="ingredients[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Ingredients'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="ingredients_<?php echo $val['langCode']; ?>"  name="ingredients[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['ingredients'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="ingredients[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
									
									
									
									
									

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_UPC'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="upc" name="upcName[en]" value="<?php echo $productsData['upcName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="upcName[keyName][en]" value="UPC" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_UPC'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="upc_<?php echo $val['langCode']; ?>" name="upcName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['upcName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="upcName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_UPC'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="upc_<?php echo $val['langCode']; ?>"  name="upcName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['upcName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="upcName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_MPN'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="mpn" name="mpnName[en]" value="<?php echo $productsData['mpnName']['en']; ?>" 
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="mpnName[keyName][en]" value="MPN" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_MPN'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="mpn_<?php echo $val['langCode']; ?>" name="mpnName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['mpnName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="mpnName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_MPN'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="mpn_<?php echo $val['langCode']; ?>"  name="mpnName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['mpnName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="mpnName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Model'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="model" name="modelName[en]" value="<?php echo $productsData['modelName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="modelName[keyName][en]" value="Model" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Model'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="model_<?php echo $val['langCode']; ?>" name="modelName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['modelName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="modelName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Model'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="model_<?php echo $val['langCode']; ?>"  name="modelName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['modelName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="modelName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ShelflifeUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomShelfLife" name="uomShelfLife[en]"  value="<?php echo $productsData['uomShelfLife']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="uomShelfLife[keyName][en]" value="Shelf life" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ShelflifeUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomShelfLife_<?php echo $val['langCode']; ?>" name="uomShelfLife[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['uomShelfLife'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="uomShelfLife[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ShelflifeUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomShelfLife_<?php echo $val['langCode']; ?>"  name="uomShelfLife[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['uomShelfLife'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="uomShelfLife[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_uomShelfLife"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_StorageTemperatureUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="UOMstorageTemperature" name="UOMstorageTemperature[en]" value="<?php echo $productsData['UOMstorageTemperature']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="UOMstorageTemperature[keyName][en]" value="Storage Temperature" class="error-box-class  form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_UOMstorageTemperature"></div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_StorageTemperatureUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="UOMstorageTemperature_<?php echo $val['langCode']; ?>" name="UOMstorageTemperature[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['UOMstorageTemperature'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="UOMstorageTemperature[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_UOMstorageTemperature"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_StorageTemperatureUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="UOMstorageTemperature_<?php echo $val['langCode']; ?>"  name="UOMstorageTemperature[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['UOMstorageTemperature'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="UOMstorageTemperature[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_UOMstorageTemperature"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Warning'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="warningName" name="warningName[en]" value="<?php echo $productsData['warningName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="warningName[keyName][en]" value="Warning" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Warning'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="warningName_<?php echo $val['langCode']; ?>" name="warningName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['warningName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="warningName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Warning'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="warningName_<?php echo $val['langCode']; ?>"  name="warningName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['warningName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="warningName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_AllergyInformation'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="allergyInfo" name="allergyInfo[en]" value="<?php echo $productsData['allergyInfo']['en']; ?>" 
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="allergyInfo[keyName][en]" value="Allergy Information" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_AllergyInformation'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="allergyInfo_<?php echo $val['langCode']; ?>" name="allergyInfo[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['allergyInfo'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="allergyInfo[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_AllergyInformation'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="allergyInfo_<?php echo $val['langCode']; ?>"  name="allergyInfo[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['allergyInfo'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="allergyInfo[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Servingspercalories'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerCalories" name="nutritionFactsInfo[servingPerCalories][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerCalories']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[servingPerCalories][keyName][en]" value="Servings per calories" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Servingspercalories'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCalories_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerCalories][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerCalories'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerCalories][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Servingspercalories'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCalories_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerCalories][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerCalories'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerCalories][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_CholesterolUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomCholesterol" name="nutritionFactsInfo[uomCholesterol][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['uomCholesterol']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[uomCholesterol][keyName][en]" value="Cholesterol" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_CholesterolUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomCholesterol_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[uomCholesterol][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomCholesterol'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomCholesterol][keyName][<?= $val['langCode']; ?>]" value="Cholesterol" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_CholesterolUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomCholesterol][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomCholesterol'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomCholesterol][keyName][<?= $val['langCode']; ?>]" value="Cholesterol" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>



                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Cholesterolperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerCholesterol" name="nutritionFactsInfo[servingPerCholesterol][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerCholesterol']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[servingPerCholesterol][keyName][en]" value="Cholesterol per serving" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Cholesterolperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCholesterol_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerCholesterol][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerCholesterol'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerCholesterol][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Cholesterolperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerCholesterol][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerCholesterol'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerCholesterol][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fatcaloriesperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerFatCalories" name="nutritionFactsInfo[servingPerFatCalories][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerFatCalories']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[servingPerFatCalories][keyName][en]" value="Fat-calories per serving" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fatcaloriesperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCholesterol_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerFatCalories][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerFatCalories'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerFatCalories][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fatcaloriesperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerFatCalories][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerFatCalories'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerFatCalories][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_FibreUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomFibre" name="nutritionFactsInfo[uomFibre][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['uomFibre']['en']; ?>"  required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[uomFibre][keyName][en]" value="Fibre" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_FibreUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomFibre_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[uomFibre][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomFibre'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomFibre][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_FibreUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomFibre_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomFibre][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomFibre'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomFibre][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fibreperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerFibre" name="nutritionFactsInfo[servingPerFibre][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerFibre']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[servingPerFibre][keyName][en]" value="Fibre per serving" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fibreperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerFibre_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerFibre][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerFibre'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerFibre][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fibreperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerFibre_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerFibre][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerFibre'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerFibre][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SodiumUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomSodium" name="nutritionFactsInfo[uomSodium][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['uomSodium']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[uomSodium][keyName][en]" value="Sodium" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SodiumUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomSodium_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[uomSodium][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomSodium'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomSodium][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SodiumUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomSodium_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomSodium][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomSodium'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomSodium][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Sodiumperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="sodiumPerServing" name="nutritionFactsInfo[sodiumPerServing][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['sodiumPerServing']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[sodiumPerServing][keyName][en]" value="Sodium per serving" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Sodiumperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="sodiumPerServing_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[sodiumPerServing][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['sodiumPerServing'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[sodiumPerServing][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Sodiumperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="sodiumPerServing_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[sodiumPerServing][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['sodiumPerServing'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[sodiumPerServing][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ProteinUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomProtein" name="nutritionFactsInfo[uomProtein][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['uomProtein']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[uomProtein][keyName][en]" value="Protein" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ProteinUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomProtein_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[uomProtein][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomProtein'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomProtein][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ProteinUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomProtein_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomProtein][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomProtein'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomProtein][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>




                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Proteinperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerProtein" name="nutritionFactsInfo[servingPerProtein][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerProtein']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[servingPerProtein][keyName][en]" value="Protein per serving" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Proteinperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerProtein_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerProtein][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerProtein'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerProtein][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Proteinperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerProtein_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerProtein][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerProtein'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerProtein][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TotalfatUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomTotalFat" name="nutritionFactsInfo[uomTotalFat][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['uomTotalFat']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[uomTotalFat][keyName][en]" value="Total-fat" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TotalfatUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomTotalFat_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[uomTotalFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomTotalFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomTotalFat][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TotalfatUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomTotalFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomTotalFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomTotalFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomTotalFat][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Totalfatperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerTotalFat" name="nutritionFactsInfo[servingPerTotalFat][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerTotalFat']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[servingPerTotalFat][keyName][en]" value="Total-fat per serving" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Totalfatperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerTotalFat_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerTotalFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerTotalFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerTotalFat][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Totalfatperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerTotalFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerTotalFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerTotalFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerTotalFat][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>



                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TransfatUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomTransFat" name="nutritionFactsInfo[uomTransFat][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['uomTransFat']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[uomTransFat][keyName][en]" value="Trans-fat" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TransfatUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomTransFat_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[uomTransFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomTransFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomTransFat][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TransfatUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomTransFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomTransFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['uomTransFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomTransFat][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Transfatperserving'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="servingPerTransFat" name="nutritionFactsInfo[servingPerTransFat][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['servingPerTransFat']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[servingPerTransFat][keyName][en]" value="Trans-fat per serving" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Transfatperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerTransFat_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[servingPerTransFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerTransFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerTransFat][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Transfatperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerTransFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerTransFat][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['servingPerTransFat'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerTransFat][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCholesterol'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="cholesterolDVP" name="nutritionFactsInfo[cholesterolDVP][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['cholesterolDVP']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[cholesterolDVP][keyName][en]" value="DVP Cholesterol" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCholesterol'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="cholesterolDVP_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[cholesterolDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['cholesterolDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[cholesterolDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCholesterol'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="cholesterolDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[cholesterolDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['cholesterolDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[cholesterolDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCalcium'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="calciumDVP" name="nutritionFactsInfo[calciumDVP][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['calciumDVP']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[calciumDVP][keyName][en]" value="DVP Calcium" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCalcium'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="calciumDVP_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[calciumDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['calciumDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[calciumDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCalcium'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="calciumDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[calciumDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['calciumDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[calciumDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">
                                                    

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>



                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPIron'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="ironDVP" name="nutritionFactsInfo[ironDVP][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['ironDVP']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[ironDVP][keyName][en]" value="DVP Iron" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPIron'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="ironDVP_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[ironDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['ironDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[ironDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPIron'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="ironDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[ironDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['ironDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[ironDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSodium'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="sodiumDVP" name="nutritionFactsInfo[sodiumDVP][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['sodiumDVP']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[sodiumDVP][keyName][en]" value="DVP Sodium" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSodium'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="sodiumDVP_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[sodiumDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['sodiumDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[sodiumDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSodium'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="sodiumDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[sodiumDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['sodiumDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[sodiumDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>



                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSaturatedFat'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="saturatedFatDVP" name="nutritionFactsInfo[saturatedFatDVP][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['saturatedFatDVP']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[saturatedFatDVP][keyName][en]" value="DVP Saturated Fat" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSaturatedFat'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="saturatedFatDVP_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[saturatedFatDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['saturatedFatDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[saturatedFatDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSaturatedFat'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="saturatedFatDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[saturatedFatDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['saturatedFatDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[saturatedFatDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPTotalFat'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="totalFatDVP" name="nutritionFactsInfo[totalFatDVP][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['totalFatDVP']['en']; ?>"  required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[totalFatDVP][keyName][en]" value="DVP Total Fat" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPTotalFat'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="totalFatDVP_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[totalFatDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['totalFatDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[totalFatDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPTotalFat'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="totalFatDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[totalFatDVP][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['totalFatDVP'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[totalFatDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>





                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminA'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="vitaminADvp" name="nutritionFactsInfo[vitaminADvp][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['vitaminADvp']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[vitaminADvp][keyName][en]" value="DVP vitamin A" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminA'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminADvp_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[vitaminADvp][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['vitaminADvp'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[vitaminADvp][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminA'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminADvp_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[vitaminADvp][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['vitaminADvp'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[vitaminADvp][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>



                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminC'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="vitaminCDvp" name="nutritionFactsInfo[vitaminCDvp][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['vitaminCDvp']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[vitaminCDvp][keyName][en]" value="DVP vitamin C" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminC'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminCDvp_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[vitaminCDvp][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['vitaminCDvp'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[vitaminCDvp][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminC'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminCDvp_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[vitaminCDvp][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['vitaminCDvp'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[vitaminCDvp][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminD'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="vitaminDDvp" name="nutritionFactsInfo[vitaminDDvp][en]"
                                                   value="<?php echo $productsData['nutritionFactsInfo']['vitaminDDvp']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[vitaminDDvp][keyName][en]" value="DVP vitamin D" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminD'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminDDvp_<?php echo $val['langCode']; ?>" name="nutritionFactsInfo[vitaminDDvp][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['vitaminDDvp'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[vitaminDDvp][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminD'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminDDvp_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[vitaminDDvp][<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['nutritionFactsInfo']['vitaminDDvp'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[vitaminDDvp][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Container'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="containerName" name="containerName[en]"
                                                   value="<?php echo $productsData['containerName']['en']; ?>"  required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="containerName[keyName][en]" value="Container" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Container'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="containerName_<?php echo $val['langCode']; ?>" name="containerName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['containerName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="containerName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Container'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="containerName_<?php echo $val['langCode']; ?>"  name="containerName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['containerName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="containerName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>



                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Containerperservings'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="containerPerServings" name="containerPerServings[en]"
                                                   value="<?php echo $productsData['containerPerServings']['en']; ?>"  required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="containerPerServings[keyName][en]" value="Container per servings" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Containerperservings'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="containerPerServings_<?php echo $val['langCode']; ?>" name="containerPerServings[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['containerPerServings'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="containerPerServings[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Containerperservings'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="containerPerServings_<?php echo $val['langCode']; ?>"  name="containerPerServings[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['containerPerServings'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="containerPerServings[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Genre'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="genreName" name="genreName[en]" value="<?php echo $productsData['genreName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="genreName[keyName][en]" value="Genre" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Genre'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="genreName_<?php echo $val['langCode']; ?>" name="genreName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['genreName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="genreName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Genre'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="genreName_<?php echo $val['langCode']; ?>"  name="genreName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['genreName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="genreName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>




                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Label'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="labelName" name="labelName[en]"  value="<?php echo $productsData['labelName']['en']; ?>" 
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="labelName[keyName][en]" value="Label" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Label'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="labelName_<?php echo $val['langCode']; ?>" name="labelName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['labelName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="labelName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Label'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="labelName_<?php echo $val['langCode']; ?>"  name="labelName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['labelName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="labelName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Artist'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="artistName" name="artistName[en]" value="<?php echo $productsData['artistName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="artistName[keyName][en]" value="Artist" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Artist'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="artistName_<?php echo $val['langCode']; ?>" name="artistName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['artistName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="artistName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Artist'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="artistName_<?php echo $val['langCode']; ?>"  name="artistName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['artistName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="artistName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Actor'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="actorName" name="actorName[en]" value="<?php echo $productsData['actorName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="actorName[keyName][en]" value="Actor" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Actor'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="actorName_<?php echo $val['langCode']; ?>" name="actorName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['actorName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="actorName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Actor'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="actorName_<?php echo $val['langCode']; ?>"  name="actorName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['actorName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="actorName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Director'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="directorName" name="directorName[en]" value="<?php echo $productsData['directorName']['en']; ?>"
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="directorName[keyName][en]" value="Director" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Director'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="directorName_<?php echo $val['langCode']; ?>" name="directorName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['directorName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="directorName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Director'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="directorName_<?php echo $val['langCode']; ?>"  name="directorName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['directorName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="directorName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Feature'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="featureName" name="featureName[en]" value="<?php echo $productsData['featureName']['en']; ?>" 
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="featureName[keyName][en]" value="Feature" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Feature'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="featureName_<?php echo $val['langCode']; ?>" name="featureName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['featureName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="featureName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Feature'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="featureName_<?php echo $val['langCode']; ?>"  name="featureName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['featureName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="featureName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Publisher'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="publisherName" name="publisherName[en]" value="<?php echo $productsData['publisherName']['en']; ?>" 
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="publisherName[keyName][en]" value="Publisher" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Publisher'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="publisherName_<?php echo $val['langCode']; ?>" name="publisherName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['publisherName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="publisherName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Publisher'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="publisherName_<?php echo $val['langCode']; ?>"  name="publisherName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['publisherName'][$val['langCode']]; ?>"  required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="publisherName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Author'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="authorName" name="authorName[en]" value="<?php echo $productsData['authorName']['en']; ?>" 
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="authorName[keyName][en]" value="Author" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Author'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="authorName_<?php echo $val['langCode']; ?>" name="authorName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['authorName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="authorName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Author'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="authorName_<?php echo $val['langCode']; ?>"  name="authorName[<?= $val['langCode']; ?>]"
                                                           value="<?php echo $productsData['authorName'][$val['langCode']]; ?>" required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="authorName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    
                                    


                                </div>
                            </section>


                            <div class="padding-20 bg-white col-sm-9">
                                <ul class="pager wizard">
                                    <!--                                    <li class="next" id="nextbutton">
                                                                            <button class="btn btn-info  pull-right" type="button" onclick="movetonext()"><span><?php echo BUTTON_NEXT; ?></span>  </button>
                                                                        </li>-->
                                    <li class="" id="finishbutton">
                                        <button class="btn btn-success finishbutton pull-right" type="button" onclick="submitform()"><span><?php echo BUTTON_FINISH; ?></span></button>
                                    </li>

                                    <!--                                    <li class="previous hidden" id="prevbutton">
                                                                            <button class="btn btn-default  pull-right" type="button" onclick="movetoprevious()"><span><?php echo BUTTON_PREVIOUS; ?></span></button>
                                                                    </li>-->
                                </ul>
                            </div>

                        </div>
                        <input type="hidden" name="currentDate" id="time_hidden" value="" />

                        <input type="hidden" id="type" name="type"required="required" value="" />
                        <input type="hidden" id="upc" name="upc" value=""/>
                        <input type="hidden" id="mpn" name="mpn" value="" />
                        <input type="hidden" id="model" name="model" value=""/>
                        <input type="hidden" id="shelflifeuom" name="shelflifeuom" value="" /> 
                        <input type="hidden" id="storageTemperature" name="storageTemperature" value="">
                        <input type="hidden" id="storageTemperatureUOM" name="storageTemperatureUOM" value=""/>
                        <input type="hidden" id="warning" name="warning" value="" />
                        <input type="hidden" id="allergyInformation" name="allergyInformation" value="" />
                        <input type="hidden"  id="caloriesPerServing" name="nutritionFacts[caloriesPerServing]" value=""/>
                        <input type="hidden"  id="cholesterolUom" name="nutritionFacts[cholesterolUom]" value="" />
                        <input type="hidden"  id="cholesterolPerServing" name="nutritionFacts[cholesterolPerServing]" value="" />
                        <input type="hidden"  id="fatCaloriesPerServing" name="nutritionFacts[fatCaloriesPerServing]" value="" />
                        <input type="hidden"  id="fibreUom" name="nutritionFacts[fibreUom]" value="" />
                        <input type="hidden"  id="fibrePerServing" name="nutritionFacts[fibrePerServing]" value="" />
                        <input type="hidden" id="sodiumUom" name="nutritionFacts[sodiumUom]" value="" />
                        <input type="hidden"  id="sodiumPerServing" name="nutritionFacts[sodiumPerServing]" value="" />
                        <input type="hidden"  id="proteinUom" name="nutritionFacts[proteinUom]" value="" />
                        <input type="hidden"  id="proteinPerServing" name="nutritionFacts[proteinPerServing]" value="" />
                        <input type="hidden"  id="totalFatUom" name="nutritionFacts[totalFatUom]" value="" />
                        <input type="hidden" id="totalFatPerServing" name="nutritionFacts[totalFatPerServing]" value="">
                        <input type="hidden" id="transFatUom" name="nutritionFacts[transFatUom]" value="" />
                        <input type="hidden" id="transFatPerServing" name="nutritionFacts[transFatPerServing]" value="" />
                        <input type="hidden" id="dvpCholesterol" name="nutritionFacts[dvpCholesterol]" value="" />
                        <input type="hidden" id="dvpCalcium" name="nutritionFacts[dvpCalcium]" value="" />
                        <input type="hidden"  id="dvpIron" name="nutritionFacts[dvpIron]" value="" />
                        <input type="hidden"  id="dvpProtein" name="nutritionFacts[dvpProtein]" value="" />
                        <input type="hidden"  id="dvpSodium" name="nutritionFacts[dvpSodium]" value="" />
                        <input type="hidden"  id="dvpSaturatedFat" name="nutritionFacts[dvpSaturatedFat]" value="" />
                        <input type="hidden"  id="dvpTotalFat" name="nutritionFacts[dvpTotalFat]" value="" /> 
                        <input type="hidden"  id="dvpVitaminA" name="nutritionFacts[dvpVitaminA]" value="" />
                        <input type="hidden"  id="dvpVitaminC" name="nutritionFacts[dvpVitaminC]" value="" />
                        <input type="hidden"  id="dvpVitaminD" name="nutritionFacts[dvpVitaminD]" value="" />
                        <input type="hidden" id="container" name="container" value="" /> 
                        <!--<input type="hidden" id="size" name="size" value="" />-->
                        <input type="hidden" id="sizeUom" name="sizeUom" value="" /> 
                        <input type="hidden" id="servingsPerContainer" name="servingsPerContainer" value="" />
                        <input type="hidden" id="height" name="height" value="" /> 
                        <input type="hidden" id="width" name="width" value="" /> 
                        <input type="hidden" id="length" name="length" value="" /> 
                        <input type="hidden" id="weight" name="weight" value="" />
                        <input type="hidden" id="genre" name="genre" value="" />
                        <input type="hidden" id="label" name="label" value="" />
                        <input type="hidden" id="artist" name="artist" value="" />
                        <input type="hidden" id="actor" name="actor" value="" />
                        <input type="hidden" id="director" name="director" value="" />
                        <input type="hidden" id="clothingSize" name="clothingSize" value="" />
                        <!--<input type="hidden" id="color" name="color" value="" />-->
                        <input type="hidden" id="features" name="features" value="" />
                        <!--<input type="hidden" id="manufacturer" name="manufacturer" value="" />-->
                        <!--<input type="hidden" id="brand" name="brand" value="" />-->
                        <input type="hidden" id="publisher" name="publisher" value="" />
                        <input type="hidden" id="author" name="author" value="" />
                        <input type="hidden" name="brandName" id="brandName" value="" />
                        <input type="hidden" name="manufacturerName" id="manufacturerName" value="" />

                    </form>

                </div>


            </div>
            <!-- END PANEL -->
        </div>

    </div>
    <!-- END JUMBOTRON -->

</div>
<!-- END PAGE CONTENT -->


<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">
                <p class="modalPopUpText">Reached Maximum Limit.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function () {

        var brands = $('#tax option:selected');
        $(brands).each(function (index, brand) {
<?php foreach ($productsData['taxes'] as $taxD) { ?>
                selectedType = '';
                if ('<?php echo $taxD['taxtName'] ?>' == $(this).attr('data-name')) {
                    selectedType = '<?php echo $taxD['taxFlag'] ?>';

                    if (select.indexOf($(this).val()) == -1) {

                        $('.selectTax').removeClass('hidden');
                        $('.selectTax').append("<div class='form-group' id='" + $(this).val() + "'><div class='col-sm-2'></div>\n\
                                                                                                            \n\<label for='fname' class='col-sm-2 control-label'>" + $(this).attr('data-name') + "</label>\n\
                                                                                                            <div class='col-sm-4' ><select id='" + $(this).attr('data-name') + "' name='taxFlag[]' class='selectType form-control error-box-class'>\n\
                                                                                                            <option value='' >select Type </option>\n\
                                                                                                            <option value='0'>Inclusive </option>\n\
                                                                                                            <option value='1'>exclusive </option>\n\
                                                                                                            </select>\n\
                                                                                                            </div><div class='col-sm-3 error-box redClass' id='text_taxflag'></div></div>");
                        $('#' + $(this).attr('data-name')).val(selectedType);
                        select.push($(this).val());
                    }
                }
<?php } ?>
        });

        $('.multiple').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            buttonWidth: '100%',
            maxHeight: 300,
        });

    });

</script>