
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
</style>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<link
    href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css"
    rel="stylesheet" type="text/css" />

<script>
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
        } else if (barcode == '' || barcode == null) {
            $('#barcode').focus();
            $('#text_barcode').text('Please enter the barcode');
        } else if (shortDescription == '' || shortDescription == null) {
            $('#shortDescription').focus();
            $('#text_shortDescription').text('Please enter the short description');
        } else if (THC == '' || THC == null) {
            $('#THC').focus();
            $('#text_THC').text('Please enter THC value');
        } else if (CBD == '' || CBD == null) {
            $('#CBD').focus();
            $('#text_CBD').text('Please enter CBD value');
        } else if (title == '' || title == null || value == '' || value == null) {
            $('#productTitle').focus();
            $('#text_productCustomText').text('Enter title and value both ');
        } else {
            var categoryName = $('#category option:selected').attr('data-name');
            var subCategoryName = $('#subCategory option:selected').attr('data-name');
            var subSubCategoryName = $('#subSubCategory option:selected').attr('data-name');
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

            url: "<?php echo base_url(); ?>index.php?/AddNewProducts/getUnits/" + productId,
            type: "POST",
            data: {productId: productId},
            dataType: "JSON",

            beforeSend: function () {
                //                    $("#ImageLoading").show();
            },
            success: function (response) {
                console.log(response);
                $.each(response.result, function (index, row) {
                    var z = $('.customPriceField').length;
                    var unitElement = '<div class="form-group pos_relative2 customPriceField">'
                            + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units <label class="MandatoryMarker">*</label></label>'
                            + '<div class="col-sm-3 pos_relative2">'
                            + '<span  class="abs_text"><b>Title</b></span>'
                            + '<input type="text" name="units[' + z + '][title]" value="' + row.title + '" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                            + '<input type="hidden" name="units[' + z + '][unitId]" value="' + row.unitId + '">'
                            + '<input type="hidden" name="units[' + z + '][status]" value="' + row.status + '">'
                            + '</div>'
                            + ' <div class="col-sm-3 pos_relative2">'
                            + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                            + ' <input type="text" name="units[' + z + '][value]" value="' + row.value + '" class="form-control productValue" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                            + ' </div>'
                            + '<div class=""></div>'
                            + '<button type="button" class="btn-default btnRemove removeButton">'
                            + '<span class="glyphicon glyphicon-remove"></span>'
                            + '</button>'
                            + '</div>';
                    $('.customField').append(unitElement);
                    renameUnitsLabelsUnit();
                });
                $.each(response.data, function (index, row) {
                    var k = $('.imageTag').length;
                    console.log(k);
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
            $(this).parent().remove();
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
                console.log($('.imageTag').length + 1);
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

        $('#custom').click(function () {
            var z = $('.customPriceField').length + 1;

            var divElement1 = '<div class="form-group pos_relative2 customPriceField">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units <span class="MandatoryMarker"> *</span></label>'
                    + '<div class="col-sm-3 pos_relative2">'
                    + '<span  class="abs_text"><b>Title</b></span>'
                    + '<input type="text" name="units[' + z + '][title]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                    + '</div>'
                    + ' <div class="col-sm-3 pos_relative2">'
                    + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                    + ' <input type="text" name="units[' + z + '][value]" class="form-control productValue" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                    + ' </div>'
                    + '<div class=""></div>'
                    + '<button type="button" class="btn-default btnRemove removeButton">'
                    + '<span class="glyphicon glyphicon-remove"></span>'
                    + '</button>'
                    + '</div>';
            $('.customField').append(divElement1);
            renameUnitsLabels();

        });



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
                                <span><?php echo LIST_PRODUCT_GENERALDETAILS; ?></span></a>
                        </li>
                        <li>
                            <a class=""data-toggle="tab" role="tab" href="#tab2" >
                                <span>UNITS</span></a>
                        </li>
                        <li>
                            <a class="" data-toggle="tab" role="tab" href="#tab3" >
                                <span><?php echo LIST_STRAIN_ATTRIBUTES_AND_FLAVOURS; ?></span></a>
                        </li>
                        <li>
                            <a class="" data-toggle="tab" role="tab" href="#tab4" >
                                <span><?php echo LIST_PRODUCT_IMAGES; ?></span></a>
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
                                        <label for="fname" class="col-sm-2 control-label">Name (English)<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="name_0" name="productName[0]"
                                                   required="required" value="<?php echo $productsData['productName'][0]; ?>" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        ?>
                                        <div class="form-group pos_relative2">
                                            <label for="fname" class="col-sm-2 control-label">Name (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">

                                                <input type="text" id="name_<?= $val['lan_id'] ?>" name="productName[<?= $val['lan_id'] ?>]"
                                                       required="required" value="<?php echo $productsData['productName'][$val['lan_id']]; ?>" class="form-control">

                                            </div>
                                            <div class="col-sm-3 error-box" id="text_name"></div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Category<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="category" name="firstCategoryId"  class="form-control error-box-class">
                                                <option data-name="Select Category" value="">Select Category</option>

                                                <?php
                                                foreach ($category as $result) {
                                                    if ($result['categoryId'] == $productsData['firstCategoryId']) {
                                                        echo "<option selected data-name=" . $result['name'][0] . " data-id=" . $result['categoryId'] . " value=" . $result['categoryId'] . ">" . $result['name'][0] . "</option>";
                                                    } else {
                                                        echo "<option data-name=" . $result['name'][0] . " data-id=" . $result['categoryId'] . " value=" . $result['categoryId'] . ">" . $result['name'][0] . "</option>";
                                                    }
                                                }
                                                ?>

                                            </select> 


                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_category"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Sub-Category</label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="subCategory" name="secondCategoryId"  class="form-control error-box-class">
                                                <option data-name="Select Category" value="">Select Sub-Category</option>

                                            </select>  

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_subCategory"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Sub-SubCategory</label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="subSubCategory" name="thirdCategoryId"  class="form-control error-box-class">
                                                <option data-name="Select Category" value="0">Select Sub-SubCategory</option>

                                            </select>  
                                            <input type="hidden" name="firstCategoryName" id="firstCategoryName" value="" />
                                            <input type="hidden" name="secondCategoryName" id="secondCategoryName" value="" />
                                            <input type="hidden" name="thirdCategoryName" id="thirdCategoryName" value="" />
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_subSubCategory"></div>
                                    </div>
                                    <div class="form-group pos_relative2 hide">
                                        <label for="fname" class="col-sm-2 control-label">SKU</label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="sku" name="sku" required="required" value="<?php echo $productsData['sku']; ?>" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_sku"></div>
                                    </div>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label ">Barcode<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="barcode" name="barcode"
                                                   required="required" value="<?php echo $productsData['barcode']; ?>" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_barcode"></div>
                                    </div>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Short Description<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="shortDescription" name="shortDescription"
                                                   required="required"  value="<?php echo $productsData['shortDescription']; ?>" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_shortDescription"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Detailed Description</label>
                                        <div class="col-sm-6 pos_relative2">

                                            <textarea id="detailedDescription" name="detailedDescription"
                                                      required="required"  class="form-control" style=" max-width: 100%;"><?php echo $productsData['detailedDescription']; ?></textarea>

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">POS Name</label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="POSName" name="POSName"
                                                   required="required" class="form-control" value="<?php echo $productsData['POSName']; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_POSName"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Barcode Format</label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="barcodeFormat" name="barcodeFormat"
                                                   required="required" class="form-control" value="<?php echo $productsData['barcodeFormat']; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_barcodeFormat"></div>
                                    </div>
                                    <!--                                    <div class="form-group pos_relative2">
                                                                            <label for="fname" class="col-sm-2 control-label">Image<span style="" class="MandatoryMarker"> *</span></label>
                                                                             <div class="col-sm-6 pos_relative2">
                                    
                                                                                <input type="file" id="image" name="images[]" required="required" class="form-control" multiple>
                                    
                                                                            </div>
                                                                            <div class="col-sm-3 error-box" id="text_image"></div>
                                                                        </div>-->

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">THC<span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="THC" name="THC" onkeypress="return isNumberKey(event)" value="<?php echo $productsData['THC']; ?>">
                                        </div>

                                        <div class="col-sm-3 error-box redClass" id="text_THC"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">CBD<span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="CBD" name="CBD" onkeypress="return isNumberKey(event)" value="<?php echo $productsData['CBD']; ?>">
                                        </div>

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
                                        <div class="col-sm-1" id="text_productTitleText ">
                                            <button  type="button" id="custom"  class="btn btn-default btn-primary pull-right" style="width:50px;margin-right:-1100px;border-radius: 25px;">Add</button>

                                        </div>
                                        <!--  <button type="button" id="btRemove" class="btn btn-default pull-right hide">
                                             <span class="glyphicon glyphicon-minus">Remove Field</span>
                                         </button> -->
                                    </div>
                                    <div class="customField row">

                                    </div>

                                </div>
                            </section>

                            <section class="" id="tab3">

                                <div class="row row-same-height">


                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_PRODUCT_STRAIN_EFFECTS; ?></label>

                                    </div>
                                    <hr/>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Relaxed</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="relaxed" value="<?php echo $productsData['strainEffects']['relaxed']; ?>" name="strainEffects[relaxed]" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_relaxed"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Happy</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="happy" name="strainEffects[happy]" value="<?php echo $productsData['strainEffects']['happy']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_happy"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Euphoric</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="euphoric" name="strainEffects[euphoric]" value="<?php echo $productsData['strainEffects']['euphoric']; ?>" onkeypress="return isNumberKey(event)" >
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_euphoric"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Uplifted</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="uplifted" name="strainEffects[uplifted]" value="<?php echo $productsData['strainEffects']['uplifted']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_uplifted"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Creative</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="creative" name="strainEffects[creative]" value="<?php echo $productsData['strainEffects']['creative']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_creative"></div>
                                    </div>



                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_PRODUCT_MEDICAL_ATTRIBUTES; ?></label>

                                    </div>
                                    <hr/>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Stress</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="stress" name="medicalAttributes[stress]" value="<?php echo $productsData['medicalAttributes']['stress']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_stress"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Depression</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="depression" name="medicalAttributes[depression]" value="<?php echo $productsData['medicalAttributes']['depression']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_depression"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Pain</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="pain" name="medicalAttributes[pain]" value="<?php echo $productsData['medicalAttributes']['pain']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_pain"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Headaches</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="headaches" name="medicalAttributes[headaches]" value="<?php echo $productsData['medicalAttributes']['headaches']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_headaches"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Fatigue</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="fatigue" name="medicalAttributes[fatigue]" value="<?php echo $productsData['medicalAttributes']['fatigue']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_fatigue"></div>
                                    </div>


                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_PRODUCT_NEGATIVE_ATTRIBUTES; ?></label>

                                    </div>
                                    <hr/>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Dry Mouth</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="dryMouth" name="negativeAttributes[dryMouth]" value="<?php echo $productsData['negativeAttributes']['dryMouth']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_dryMouth"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Dry Eyes</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="CBD" name="negativeAttributes[dryEyes]" value="<?php echo $productsData['negativeAttributes']['dryEyes']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_CBD"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Anxious</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="anxious" name="negativeAttributes[anxious]" value="<?php echo $productsData['negativeAttributes']['anxious']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_anxious"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Paranoid</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="paranoid" name="negativeAttributes[paranoid]" value="<?php echo $productsData['negativeAttributes']['paranoid']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_paranoid"></div>
                                    </div>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Dizzy</label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="form-control" id="dizzy" name="negativeAttributes[dizzy]" value="<?php echo $productsData['negativeAttributes']['dizzy']; ?>" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_dizzy"></div>
                                    </div>




                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_PRODUCT_FLAVOURS; ?></label>

                                    </div>
                                    <hr/>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Flavour 1</label>

                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" class="form-control" id="flavour1" name="flavours[flavour1]" value="<?php echo $productsData['flavours']['flavour1']; ?>">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_anxious"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Flavour 2</label>

                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" class="form-control" id="flavour2" name="flavours[flavour2]" value="<?php echo $productsData['flavours']['flavour2']; ?>" >
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_paranoid"></div>
                                    </div>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label">Flavour 3</label>

                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" class="form-control" id="flavour3" name="flavours[flavour3]" value="<?php echo $productsData['flavours']['flavour3']; ?>">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_dizzy"></div>
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
                                        <!--  <button type="button" id="btRemove" class="btn btn-default pull-right hide">
                                             <span class="glyphicon glyphicon-minus">Remove Field</span>
                                         </button> -->
                                    </div>



                                    <div class="imagesField row">
                                        <div class="form-group pos_relative2">
                                            <!--                                            <label id="td1" for="fname" class="col-sm-2 control-label">Image 1 </label>
                                                                                        <div class="col-sm-6 pos_relative2">
                                                                                            <input type="file" name="imageupload" class="form-control imagesProduct" id="tb1" attrId="0" value="Text Element 1">
                                                                                            <input type="hidden"  id="text_imagesVal" value="<?php echo $productsData['images'][0]['mobile']; ?>">
                                                                                        </div>
                                                                                        <div class="col-sm-1">
                                                                                            <img src="<?php echo $productsData['images'][0]['mobile']; ?>" style="width: 35px;height:35px;" class="text_imagesVal style_prevu_kit">
                                                                                        </div>
                                                                                        <div class="col-sm-3 error-box" id="text_images1"></div>
                                            
                                                                                        <input type="hidden" id="thumbnailImages0"  name="images[0][thumbnail]"/>
                                                                                        <input type="hidden" id="mobileImages0"  name="images[0][mobile]"/>
                                                                                        <input type="hidden" id="defaultImages0"  name="images[0][image]"/>-->
                                        </div>
                                    </div>

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
                        <input type="hidden" id="size" name="size" value="" />
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
                        <input type="hidden" id="color" name="color" value="" />
                        <input type="hidden" id="features" name="features" value="" />
                        <input type="hidden" id="manufacturer" name="manufacturer" value="" />
                        <input type="hidden" id="brand" name="brand" value="" />
                        <input type="hidden" id="publisher" name="publisher" value="" />
                        <input type="hidden" id="author" name="author" value="" />

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
<div id="wait" style="display:none;width:80px;height:80px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
    <img src='<?php echo base_url(); ?>pics/spinner.gif' width="50" height="50" /><br>Loading..</div>
