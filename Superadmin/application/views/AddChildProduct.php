<style>
    .MandatoryMarker{
        color: red;
    }

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
    .btn{
        border-radius: 25px;
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

<script src="<?php echo ServiceLink ; ?>vendors/bootstrap/dist/js/bootstrap-multiselect.js"></script>
<link href="<?php echo ServiceLink ; ?>vendors/bootstrap/dist/css/bootstrap-multiselect.css" rel="stylesheet">

<script>
    var selectedsize = [];
//here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

    function submitform()
    {
        $('#finishbutton').prop('disabled', false);
        $(".error-box").text("");

        var name = $('#name_0').val();
        var category = $('#category').val();
        var barcode = $('#barcode').val();
        var shortDescription = $('#shortDescription').val();
        var THC = $('#THC').val();
        var CBD = $('#CBD').val();
        var title = $('.productTitle').val();
        var value = $('.productValue').val();
        var image = $('#image1').val();

        var selectType = $('.selectType option:selected').val();

        if (name == '' || name == null) {
            $('#name_0').focus();
            $('#text_name').text('Please enter the name');
        } else if (category == '' || category == null) {
            $('#category').focus();
            $('#text_category').text('Please select the category');
        } else if (shortDescription == '' || shortDescription == null) {
            $('#shortDescription').focus();
            $('#text_shortDescription').text('Please enter the short description');
        } else if (selectType == '') {
            $('.selectType').focus();
            $('#text_taxflag').text('Please select tax type');
        } else if (THC == '' || THC == null) {
            $('#THC').focus();
            $('#text_THC').text('Please enter THC value');
        } else if (CBD == '' || CBD == null) {
            $('#CBD').focus();
            $('#text_CBD').text('Please enter CBD value');
        } else if (title == '' || title == null || value == '' || value == null) {
            $('#productTitle').focus();
            $('#text_productCustomText').text('Enter title and value both ');
        } else if (image == '' || image == null) {
            $('#image1').focus();
            $('#text_images1').text('upload at least one image ');
        } else {
            $('#finishbutton').prop('disabled', true);

            var brandName = $('#brand option:selected').attr('data-name');
            var manufacturerName = $('#manufacturer option:selected').attr('data-name');

            var colorName = new Array();

            $(".colorName:checkbox:checked").each(function () {
                colorName.push($(this).attr('dataName'));
            });
            $('#colorName').val(colorName);

            var sizeName = new Array();

            $(".sizeName:checkbox:checked").each(function () {
                sizeName.push($(this).attr('dataName'));
            });
            $('#sizeName').val(sizeName);

            var categoryName = $('#category option:selected').attr('data-name');
            var subCategoryName = $('#subCategory option:selected').attr('data-name');
            var subSubCategoryName = $('#subSubCategory option:selected').attr('data-name');
            $('#firstCategoryName').val(categoryName);
            $('#secondCategoryName').val(subCategoryName);
            $('#thirdCategoryName').val(subSubCategoryName);

            var brandName = $('#brand option:selected').attr('data-name');
            var manufacturerName = $('#manufacturer option:selected').attr('data-name');
            $('#brandName').val(brandName);
            $('#manufacturerName').val(manufacturerName);

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

</script>

<script>
    $(document).ready(function () {

        var productId = '<?php echo $productId; ?>';
//            console.log(productId);
        $.ajax({
            url: '<?php echo base_url() ?>index.php?/AddNewProducts/getUnits',
            type: "POST",
            data: {val: productId},
            dataType: "JSON",
            success: function (result) {

                $('#productData').val(JSON.stringify(result.result));
                var html = '';
                var k = 1;
                $.each(result.data, function (i, row) {
                    console.log(row);
                    html = '<div class="form-group formex ">'
                            + '<div class="col-sm-12">'
                            + '<div class="col-sm-2"><label class="control-label">' + row.name.en + '</label><input type="hidden" value="' + row.name.en + '" class="unitsTitle" /></div>'
                            + '<div class="col-sm-4"><input type="text" value="' + row.price.en + '" class="form-control col-sm-12 unitsValue" onkeypress="return isNumberKey(event)"/></div>'
                            + '<div class="col-sm-4"><input type="checkbox" class="checkbox unitChecks" value="' + row.unitId + '"/></div>'
                            + '</div><br/><br/><hr/>';
                    $('.unitsData').append(html);
                });
                $('.unitTitle').text("Add Units");
            }

        });


        $('#addNewUnit').click(function () {
            var htmlAdd = '';
            var len = $('.customPriceField').length;
            var z = len + 1;
            var y = z + 1;
            htmlAdd = '<div class="customPriceField row"><div class="form-group pos_relative2 customPriceField' + z + '">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' </label>'
                    + '<div class="col-sm-4 pos_relative2">'
                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    + '<input type="text" name="units[' + len + '][name][en]" class="form-control productTitle' + z + '" id="title' + z + '"  placeholder="Enter title">'
                    + '</div>'
                    + ' <div class="col-sm-4 pos_relative2">'
                    + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                    + ' <input type="text" name="units[' + len + '][price][en]" class="form-control productValue' + z + '" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
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
                    + '<div class="col-sm-4 pos_relative2">'
                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    + '<input type="text" name="units[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle' + z + '" id="title' + z + '"  placeholder="Enter title">'
                    + '</div>'
                    + ' <div class="col-sm-4 pos_relative2">'
                    + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                    + ' <input type="text" name="units[' + len + '][price][<?php echo $val['langCode']; ?>]" class="form-control productValue' + z + '" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                    + ' </div>'
                    + '<div class=""></div>'
                    + '</div>'
                    + '<?php } else { ?>'
                    + '<div class="form-group pos_relative2 customPriceField' + z + '" style="display:none">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                    + '<div class="col-sm-4 pos_relative2">'
                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    + '<input type="text" name="units[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle' + z + '" id="title' + z + '"  placeholder="Enter title">'
                    + '</div>'
                    + ' <div class="col-sm-4 pos_relative2">'
                    + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                    + ' <input type="text" name="units[' + len + '][price][<?php echo $val['langCode']; ?>]" class="form-control productValue' + z + '" id="value' + z + '" placeholder="Enter value" onkeypress="return isNumberKey(event)">'
                    + ' </div>'
                    + '<div class=""></div>'
                    + '</div>'
                    + '<?php
    }
}
?>'
                    + '<div class="selectedsizeAttr"></div></div><hr/>';

            $('.unitsData').append(htmlAdd);
            selectedsize = [];
            var prodata = JSON.parse($('#productData').val());
            var sizegroups = prodata.sizes;

            if (sizegroups.length > 0) {

                $(sizegroups).each(function (index, sizeAttr) {
                    var data = sizeAttr['sizeId'];
                    if (selectedsize.indexOf(data) == -1) {

<?php foreach ($size as $sizes) { ?>
                            if ('<?php echo $sizes['_id']['$oid']; ?>' == data) {
                                if (sizegroups.length == 1) {

                                    $('.customPriceField:last').find('.selectedsizeAttr').html('<div class="form-group" id="selectedSizeAttr_' + data + '">\n\
                                                                                                                                           <label class="col-sm-3 control-label">Size Attribute</label>\n\
                                                                                                                                           <div class="col-sm-6"><span class="multiselect-native-select">\n\
                                                                                                                                           <select class="multiple sizeGroup form-control" id="sizeGroup' + z + '" name="units[' + z + '][sizeAttr][]" multiple="multiple" >\n\
    <?php foreach ($sizes['sizeAttr'] as $siz) {
        ?><option data-name="<?php echo $siz['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + data + '" ><?php echo $siz['en']; ?></option>\n\
    <?php } ?></select></div></div>');

                                } else {
    <?php foreach ($sizes['sizeAttr'] as $siz) { ?>
                                        $('.sizeGroup').append('<option data-name="<?php echo $siz['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + data + '" ><?php echo $siz['en']; ?></option>');
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
                        selectedsize.push(data);
                    }
                });
            }

        });


    });

</script>

<div class="page-content-wrapper">
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb" style="margin-left: 0px; margin-top: 5%;">
        <li><a href="<?php echo base_url(); ?>index.php?/AddNewProducts" class=""><?php echo $this->lang->line('LIST_PRODUCTS'); ?></a></li>
        <li style="width: 100px"><a href="#" class="active"><?php echo $this->lang->line('heading_add'); ?></a></li>
    </ul>
    <!-- END BREADCRUMB -->
    <!-- START PAGE CONTENT -->
    <div class="content">
        <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
            <li class="active tabs_active" id="firstlitab" onclick="managebuttonstate()">
                <a data-toggle="tab" href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span>Details</span></a>
            </li>
            <li class="tabs_active" id="secondlitab">
                <a data-toggle="tab" href="#tab2" onclick="profiletab('secondlitab', 'tab2')" id="mtab2"><i id="tab2icon" class=""></i> <span>Products available in</span></a>
            </li>

        </ul>        
        <!-- START JUMBOTRON -->
        <div class=" bg-white" data-pages="parallax">
            <div class="inner"></div>

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="navbar-collapsible"  class="navbar-collapse collapse m-t-50">
                    <!-- Nav tabs -->

                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form"
                          action="<?php echo base_url(); ?>index.php?/AddNewProducts/AddNewProductData"
                          method="post" enctype="multipart/form-data" onsubmit="return redirectToDest()">

                        <div class="tab-content">
                            <div class="modal-body">
                                <div class="tab-pane padding-20 slide-left active" id="tab1">

                                    <div class="row unitsData">

                                    </div>
                                    <input type="hidden" value id="productData"/>
                                    <div class="row">
                                        <div class="col-sm-4" >
                                            <a class="pull-left" id="addNewUnit" style="cursor:pointer;color:#0090d9; font-size: 13px;">Add New Unit</a>
                                        </div>
                                    </div>

                                    <hr/>
                                    <br/>
                                    <div class="row">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Tax'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="tax" name="tax[]"  class="multiple form-control error-box-class" multiple="multiple">
                                                <?php
                                                foreach ($taxData as $result) {
                                                    echo "<option data-name='" . implode(',', $result['taxName']) . "' data-id=" . $result['_id']['$oid'] . " value=" . $result['_id']['$oid'] . ">" . implode(',', $result['taxName']) . "</option>";
                                                }
                                                ?>

                                            </select> 

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_tax"></div>

                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="selectTax hidden "></div>
                                    </div>
                                    <script>
                                        var selected = [];
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
                                                    console.log($(this).attr('data-name'));

                                                    if (selected.indexOf($(this).val()) == -1) {
                                                        $('.selectTax').removeClass('hidden');
                                                        $('.selectTax').append("<div class='form-group'  id='" + $(this).val() + "'><div class='col-sm-2'></div>\n\
                                                                            \n\<label for='fname' class='col-sm-2 control-label'>" + $(this).attr('data-name') + "</label>\n\
                                                                            <div class='col-sm-4' ><select id='" + $(this).attr('data-name') + "' name='taxFlag[]' class='selectType form-control error-box-class'>\n\
                                                                            <option value='' >select Type </option>\n\
                                                                            <option value='0' >Inclusive </option>\n\
                                                                            <option value='1' >exclusive </option>\n\
                                                                            </select>\n\
                                                                            </div><div class='col-sm-3 error-box redClass' id='text_taxflag'></div></div>");
                                                        selected.push($(this).val());
                                                    }
                                                });
                                                $('input:checkbox').each(function (index, value) {

                                                    if ($(this).is(':checked')) {
                                                    } else {

                                                        var index = selected.indexOf($(this).val());
                                                        if (index !== -1)
                                                            selected.splice(index, 1);
                                                        $('#' + $(this).val()).remove();
                                                    }
                                                });
                                            }
                                        });

                                    </script>
                                </div>
                                <div class="tab-pane padding-20 slide-left active" id="tab2">

                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="modal-footer">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4" >
                                        <button type="button" class="btn btn-primary pull-right" data-id="" id="confirmed" >ADD</button>
                                    </div>
                                </div>
                            </div>


                            <!--                            <div class="padding-20 bg-white col-sm-9">
                                                            <ul class="pager wizard">
                            
                                                                <li class="" id="finishbutton">
                                                                    <button class="btn btn-success finishbutton pull-right" type="button" onclick="submitform()"><span><?php echo Finish; ?></span></button>
                                                                </li>
                            
                                                            </ul>
                                                        </div>-->

                        </div>
                        <input type="hidden" name="current_dt" id="time_hidden" value="" />

                    </form>
                </div>
            </div>
            <!-- END PANEL -->
        </div>

    </div>
    <!-- END JUMBOTRON -->

</div>
<!-- END PAGE CONTENT -->

<script>
    $('.multiple').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '100%',
        maxHeight: 300,
    });
</script>