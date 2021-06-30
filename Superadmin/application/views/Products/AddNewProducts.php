
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
    .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
    position: absolute;
    margin-left: -20px !important;
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet">


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<link
    href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css"
    rel="stylesheet" type="text/css" />



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

        var consumptionTime = new Array(); 
            $("input:checkbox[class=consumptionTime]:checked").each(function(){
                var checksel=consumptionTime.push($(this).val());
              

            });

        
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
        } 
		// else if (THC == '' || THC == null) {
        //     $('#THC').focus();
        //    $('#text_THC').text('Please enter THC value');
        // }
        //  else if (CBD == '' || CBD == null) {
        //     $('#CBD').focus();
        //     $('#text_CBD').text('Please enter CBD value');
        // } 
		else if (title == '' || title == null || value == '' || value == null) {
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
                colorName.push($(this).attr('data-name'));
            });
            $('#colorName').val(colorName);

            var sizeName = new Array();

            $(".sizeName:checkbox:checked").each(function () {
                sizeName.push($(this).attr('data-name'));
            });
            $('#sizeName').val(sizeName);

            var storeCategoryId = $('#category option:selected').attr('storecategoryid');
            var categoryName = $('#category option:selected').attr('data-name');
            var subCategoryName = $('#subCategory option:selected').attr('data-name');
            var subSubCategoryName = $('#subSubCategory option:selected').attr('data-name');
            $('#storeCategoryId').val(storeCategoryId);
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

    var OnlymobileNo;
    var CountryCodeMobileNo;
    var expanded = false;
    var expanded1 = false;

    function isNumberKey(evt)
    {
        $("#mobify").text("");
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
            $("#mobify").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
            return false;
        }
        return true;
    }
    function redirectToDest() {
        window.location.href = "<?php echo base_url(); ?>index.php?/AddNewProducts/StoreProducts";
    }

    $(document).ready(function () {
        $('#finishbutton').prop('disabled', false);

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

        $(document).on('change', '.imagesProduct', function () {

            $('#text_images1').text("");
            var fieldID = $(this).attr('attrId');
            var ext = $(this).val().split('.').pop().toLowerCase();
            var formElement = $(this).prop('files')[0];
            console.log(formElement);

            uploadImage(fieldID, ext, formElement);

        });

        //$('#category').on('change', function () {
       //     var val = $(this).val();
       //     $('#subCategory').load("<?php echo base_url('index.php?/SubCategory') ?>/getSubCategoryData", {val: val});
       // });
	   $('#category').on('change', function () {
            //var val = $(this).val();
           // $('#subSubCategory').load("<?php echo base_url('index.php?/SubsubCategory') ?>/getSubsubCategoryDataList", {val: val});
       

        var valCat =  $('#category option:selected').val();

        var entities = '';
        $.ajax({

            url: "<?php echo base_url('index.php?/SubCategory') ?>/getSubCategoryData/" + valCat,
            type: "POST",
            data: {},
            dataType: "JSON",
            success: function (response) {

                $('#subCategory').empty();
       
                        var html = '';
                        var listData='';
                        var langData = <?php echo json_encode($language); ?>;
                        var lngcode;
                        html = '<option value="">Select Sub Category</option>'
                    $.each(response, function (index, row) {

                        $.each(row, function (index, res) {
                            
                            listData= (res.subCategoryName.en);

                           $.each(langData,function(i,lngrow){ 
                                
                             lngcode= lngrow.langCode;
                             var lngvalue = res.subCategoryName[lngcode];
                             lngvalue = (lngvalue==''|| lngvalue==null )?"":lngvalue;

                             if(lngvalue){
                                listData +=","+lngvalue; 
                                }
                            });
                            html += '<option  data-name="' + res.subCategoryName.en + '"value="' + res._id.$oid + '">' + listData + '</option>';

                         });

                 });
                  $('#subCategory').append(html);
                  $('#subCategory').val("<?php echo $productsData['secondCategoryId']; ?>");

            },
            error: function () {

            },
            cache: false,
            contentType: false,
            processData: false
        });
		 });

        $('#subCategory').on('change', function () {
            //var val = $(this).val();
           // $('#subSubCategory').load("<?php echo base_url('index.php?/SubsubCategory') ?>/getSubsubCategoryDataList", {val: val});
			var valSubCat = $('#subCategory option:selected').val();
        $.ajax({

            url: "<?php echo base_url('index.php?/SubsubCategory') ?>/getSubsubCategoryDataList/" + valSubCat,
            type: "POST",
            data: {},
            dataType: "JSON",
            success: function (response) {
                

                $('#subSubCategory').empty();
       
                        var html = '';
                        var listData='';
                        var langData = <?php echo json_encode($language); ?>;
                        var lngcode;
                        html = '<option value="">Select Sub Sub Category</option>'

                    $.each(response, function (index, row) {

                        $.each(row, function (index, res) {
                            
                            listData= (res.subSubCategoryName.en);

                           $.each(langData,function(i,lngrow){ 
                                
                             lngcode= lngrow.langCode;
                             var lngvalue = res.subSubCategoryName[lngcode];
                             lngvalue = (lngvalue==''|| lngvalue==null )?"":lngvalue;

                             if(lngvalue){
                                listData +=","+lngvalue; 
                                }
                            });
                            html += '<option  data-name="' + res.subSubCategoryName.en + '"value="' + res._id.$oid + '">' + listData + '</option>';

                         });

                 });
                  $('#subSubCategory').append(html);
                  
            },


            error: function () {

            },
            cache: false,
            contentType: false,
            processData: false
        });
        });

        $("#mobile").on("countrychange", function (e, countryData) {
            $("#coutry-code").val(countryData.dialCode);
        });

        $("#name").keypress(function (event) {
            var inputValue = event.which;
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
// upload image function
    function uploadImage(fieldID, ext, formElement)
    {

        if ($.inArray(ext, ['jpg', 'png', 'JPEG']) == -1) {
            $('#errorModal').modal('show');
            $('.modalPopUpText').text('Please choose correct format');
        } else
        {
            var form_data = new FormData();
            var amazonPath = "<?php echo AMAZON_URL ?>"
            form_data.append('sampleFile', formElement);
            $(document).ajaxStart(function () {
                $(".finishbutton").prop("disabled",true)
               $("#loadingimg").css("display","block");
            });
            $.ajax({
                url: "<?php echo uploadImageLink; ?>",
                type: "POST",
                data: form_data,
                dataType: "JSON",

                beforeSend: function () {

                },
                success: function (response) {
                    if (response.code == '200') {
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
                                console.log('-------',amazonPath + row.path);
                                $(".finishbutton").prop("disabled",false)
                               $("#loadingimg").css("display","none");
                                    // cool
                                $('.imagesProduct').attr('src', amazonPath + row.path);
                                $('.imagesProduct').show();
                            });

                            $('.finishbutton').removeAttr('disabled');
                            $('.finishbutton').removeClass("disabled");
                            $('.finishbutton').prop('disabled', false)

                        });
                    }
                },
                error: function () {

                },
                cache: false,
                contentType: false,
                processData: false
            });
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

<div class="page-content-wrapper">
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb" style="margin-left: 0px; margin-top: 5%;">
        <li><a href="<?php echo base_url(); ?>index.php?/AddNewProducts" class=""><?php echo $this->lang->line('LIST_PRODUCTS'); ?></a></li>
        <li style="width: 100px"><a href="#" class="active"><?php echo $this->lang->line('heading_add'); ?></a></li>
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
                                <span style="color:black"><?php echo $this->lang->line('LIST_PRODUCT_GENERALDETAILS'); ?></span></a>
                        </li>
                        <li>
                            <a class=""data-toggle="tab" role="tab" href="#tab2" >
                                <span style="color:black">UNITS</span></a>
                        </li>
                       <li style="display:none">
                            <a class="" data-toggle="tab" role="tab" href="#tab3" >
                                <span style="color:black"><?php echo $this->lang->line('LIST_STRAIN_ATTRIBUTES_AND_FLAVOURS'); ?></span></a>
                        </li>
                        <li>
                            <a class="" data-toggle="tab" role="tab" href="#tab4" >
                                <span style="color:black"><?php echo $this->lang->line('LIST_PRODUCT_IMAGES'); ?></span></a>
                        </li>
                        <li style="display:none">
                            <a class="" data-toggle="tab" role="tab" href="#tab5" >
                                <span style="color:black"><?php echo $this->lang->line('ADDITIONAL_DETAILS'); ?></span></a>
                        </li>
                       
                        <li class="" id="finishbutton" style="position:fixed;margin-left: 936px;"><a>
                                        <button class="btn btn-success finishbutton pull-right" type="button" onclick="submitform()"><span><?php echo BUTTON_FINISH; ?></span></button>
                            </a></li>

                                
                       
                        
                        

                    </ul>
                    <div class="row"><br></div>
                    

                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form"
                          action="<?php echo base_url(); ?>index.php?/AddNewProducts/AddNewProductData"
                          method="post" enctype="multipart/form-data" onsubmit="return redirectToDest()">

                        <div class="tab-content">
                            <section class="" id="tab1">
                                <div class="row row-same-height">

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label error-box-class "><?php echo $this->lang->line('label_Name'); ?> <span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="name_0" name="productName[0]"
                                                   required="required" class="error-box-class  form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="productName[<?= $val['lan_id'] ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box" id="text_name"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="productName[<?= $val['lan_id'] ?>]"
                                                           required="required" class="error-box-class  form-control">

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
												 if(count($language) < 1){
                                                        foreach ($category as $result) {
															
																echo "<option  value=" . $result['categoryId'] . " storecategoryid='".$result['storeCategoryId']."'  data-name='" . $result['name']['en'] . "'>" . $result['name']['en'] . "</option>";
															
                                                        }
                                                    }
                                                    else{
                                                        
                                                        foreach ($category as $result) {
                                                            $catData=$result['name']['en'];
                                                            foreach($language as $lngData){
                                                            $lngcode=$lngData['langCode'];
                                                            $lngvalue= ($result['name'][$lngcode]=='') ? "":$result['name'][$lngcode];
                                                            if(strlen( $lngvalue)>0){
                                                                $catData.= ',' . $lngvalue;
                                                               }
                                                           }
                                                         
															 echo "<option  value=" . $result['categoryId'] . " storecategoryid='".$result['storeCategoryId']."' data-name='" .  $catData . "'>" . $catData . "</option>";	
															
                                                        }
                                                    }
												
                                                //foreach ($category as $result) {
                                                  //  echo "<option data-name='" . implode(';', $result['name']) . "' data-id=" . $result['categoryId'] . " value=" . $result['categoryId'] . ">" . implode(',', $result['name']) . "</option>";
                                             //   }
                                                ?>

                                            </select> 


                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_category"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SubCategory'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="subCategory" name="secondCategoryId"  class="form-control error-box-class">
                                                <option data-name="" value=""><?php echo $this->lang->line('label_SelectSubCategory'); ?></option>

                                            </select>  

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_subCategory"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SubSubCategory'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="subSubCategory" name="thirdCategoryId"  class="form-control error-box-class">
                                                <option data-name="" value=""><?php echo $this->lang->line('label_SelectSubSubCategory'); ?></option>

                                            </select>  
                                            <input type="hidden" name="colorName" id="colorName" value="" />
                                            <input type="hidden" name="sizeName" id="sizeName" value="" />
                                            <input type="hidden" name="storeCategoryId" id="storeCategoryId" value="" />
                                            <input type="hidden" name="firstCategoryName" id="firstCategoryName" value="" />
                                            <input type="hidden" name="secondCategoryName" id="secondCategoryName" value="" />
                                            <input type="hidden" name="thirdCategoryName" id="thirdCategoryName" value="" />
                                        </div>
                                        <div class="col-sm-3 error-box" id="text_subSubCategory"></div>
                                    </div>
                                    <div class="form-group pos_relative2 hide">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Sku'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="sku" name="sku" required="required" class="error-box-class  form-control">

                                        </div>
                                        <div class="col-sm-3 error-box" id="text_sku"></div>
                                    </div>

                                    <div class="form-group pos_relative2" style="display:none">
                                        <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Barcode'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="barcode" name="barcode"
                                                   required="required" class="error-box-class  form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_barcode"></div>
                                    </div>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SDescription'); ?> <span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="shortDescription" name="shortDescription[en]"
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

                                                    <input type="text" id="shortDescription" name="shortDescription[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_shortDescription"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SDescription'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="shortDescription" name="shortDescription[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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

                                            <textarea id="detailedDescription" name="detailedDescription[en]"
                                                      required="required" class="error-box-class  form-control" style=" max-width: 100%;"></textarea>

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

                                                    <textarea id="detailedDescription" name="detailedDescription[<?= $val['langCode']; ?>]"
                                                              required="required" class="error-box-class  form-control" style=" max-width: 100%;"></textarea>

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DDescription'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <textarea id="detailedDescription" name="detailedDescription[<?= $val['langCode']; ?>]"
                                                              required="required" class="error-box-class  form-control" style=" max-width: 100%;"></textarea>

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                   
                                    <div class="form-group pos_relative2"  >
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Manufacturer'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="manufacturer" name="manufacturer"  class="form-control error-box-class">
                                                <option data-name="" value=""><?php echo $this->lang->line('label_SelectManufacturer'); ?></option>

                                                <?php
												 if(count($language) < 1){
                                                        foreach ($manufacturer as $result) {
															
																echo "<option  value=" . $result['_id']['$oid'] . "  data-name='" . $result['name']['en'] . "'>" . $result['name']['en'] . "</option>";
															
                                                        }
                                                    }
                                                    else{
                                                        
                                                        foreach ($manufacturer as $result) {
                                                            $catData=$result['name']['en'];
                                                            foreach($language as $lngData){
                                                            $lngcode=$lngData['langCode'];
                                                            $lngvalue= ($result['name'][$lngcode]=='') ? "":$result['name'][$lngcode];
                                                            if(strlen( $lngvalue)>0){
                                                                $catData.= ',' . $lngvalue;
                                                               }
                                                           } 
                                                           
															 echo "<option  value=" .$result['_id']['$oid'] . "  data-name='" .  $catData . "'>" . $catData . "</option>";	
															
                                                        }
                                                    }
                                               // foreach ($manufacturer as $result) {
                                                //    echo "<option data-name='" . implode(',', $result['Name']) . "' data-id=" . $result['_id']['$oid'] . " value=" . $result['_id']['$oid'] . ">" . implode(',', $result['Name']) . "</option>";
                                             //   }
                                                ?>

                                            </select> 


                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_Manufacturer"></div>
                                    </div>
                                    <div class="form-group pos_relative2" >
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Brands'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="brand" name="brand" class="form-control error-box-class" >
                                                <option data-name="" value=""><?php echo $this->lang->line('label_SelectBrands'); ?></option>

                                                <?php
												 if(count($language) < 1){
                                                        foreach ($brands as $result) {
															
																echo "<option  value=" . $result['_id']['$oid'] . "  data-name='" . $result['name']['en'] . "'>" . $result['name']['en'] . "</option>";
															
                                                        }
                                                    }
                                                    else{
                                                        
                                                        foreach ($brands as $result) {
                                                            $catData=$result['name']['en'];
                                                            foreach($language as $lngData){
                                                            $lngcode=$lngData['langCode'];
                                                            $lngvalue= ($result['name'][$lngcode]=='') ? "":$result['name'][$lngcode];
                                                            if(strlen( $lngvalue)>0){
                                                                $catData.= ',' . $lngvalue;
                                                               }
                                                           } 
                                                           
															 echo "<option  value=" .$result['_id']['$oid'] . "  data-name='" .  $catData . "'>" . $catData . "</option>";	
															}
                                                        
                                                    }
                                               // foreach ($brands as $brand) {
                                               //     echo "<option data-name='" . implode(',', $brand['brandName']) . "' data-id=" . $brand['_id']['$oid'] . " value=" . $brand['_id']['$oid'] . ">" . implode(',', $brand['brandName']) . "</option>";
                                              //  }
                                                ?>

                                            </select> 


                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_brands"></div>
                                    </div>
                                    <!-- <div class="form-group required" > 
                                        <label class="col-sm-2 control-label"><?php echo $this->lang->line('label_Size'); ?></label>
                                        <div class="col-sm-6">
                                            <div class="multiselect sizeMultiSelect">
                                                <div class="selectBox" style="width: 102%;">
                                                    <select class="sizeName multiple form-control" id="sizeGroup" name="size[]" multiple="multiple" >
                                                        <?php
													
														 if(count($language) < 1){
                                                        foreach ($size as $result) {
															
																echo "<option  value=" . $result['_id']['$oid'] . "  data-name='" . $result['name']['en'] . "'>" . $result['name']['en'] . "</option>";
															
                                                        }
                                                    }
                                                    else{
                                                        
                                                        foreach ($size as $result) {
                                                            $catData=$result['name']['en'];
                                                            foreach($language as $lngData){
                                                            $lngcode=$lngData['langCode'];
                                                            $lngvalue= ($result['name'][$lngcode]=='') ? "":$result['name'][$lngcode];
                                                            if(strlen( $lngvalue)>0){
                                                                $catData.= ',' . $lngvalue;
                                                               }
                                                           } 
                                                         
															 echo "<option  value=" .$result['_id']['$oid'] . "  data-name='" .  $catData . "'>" . $catData . "</option>";
															
                                                        }
                                                    }
													
														
                                                    //    foreach ($size as $sizes) {
                                                    //        echo "<option data-name='" . $sizes['name']['en']. "' data-id=" . $sizes['_id']['$oid'] . " value=" . $sizes['_id']['$oid'] . ">" . $sizes['name']['en'] . "</option>";
                                                    //    }
                                                        ?>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>

                                            </div>
                                            <label id="size-error" class="error" style="display:none">This field is required.</label>
                                        </div>
                                        <div class="col-sm-3 error-box" id="sizeErr"></div>

                                    </div> -->

                                    <script>
                                        
                                        /*$('#sizeGroup').multiselect({
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
                                                                                                    ?><option data-name="<?php echo $siz['sAttrLng']['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + $(this).val() + '" ><?php echo $siz['sAttrLng']['en']; ?></option>\n\
                                                                                                    <?php } ?></select></div></div>');

                                                                } else {
                                                                     <?php foreach ($sizes['sizeAttr'] as $siz) { ?>
                                                                        $('.sizeGroup').append('<option data-name="<?php echo $siz['sAttrLng']['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + $(this).val() + '" ><?php echo $siz['sAttrLng']['en']; ?></option>');
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
                                        });*/
                                    </script>

                                    <!-- <div class="form-group required" >
                                        <label class="col-sm-2 control-label"><?php echo $this->lang->line('label_Colors'); ?></label>
                                        <div class="col-sm-6">
                                            <div class="multiselect">
                                                <div class="selectBox"  style="width: 102%;">
                                                    <select class="colorName multiple form-control" name="color[]" multiple="multiple">
                                                        <?php
														
														 if(count($language) < 1){
                                                        foreach ($color as $result) {
															
																echo "<option  value=" . $result['_id']['$oid'] . "  data-name='" . $result['colorName']['en'] . "'>" . $result['colorName']['en'] . "</option>";
															
                                                        }
                                                    }
                                                    else{
                                                        
                                                        foreach ($color as $result) {
                                                            $catData=$result['colorName']['en'];
                                                            foreach($language as $lngData){
                                                            $lngcode=$lngData['langCode'];
                                                            $lngvalue= ($result['colorName'][$lngcode]=='') ? "":$result['colorName'][$lngcode];
                                                            if(strlen( $lngvalue)>0){
                                                                $catData.= ',' . $lngvalue;
                                                               }
                                                           } 
                                                         
															 echo "<option  value=" .$result['_id']['$oid'] . "  data-name='" .  $catData . "'>" . $catData . "</option>";	
															
                                                        }
                                                    }
														
                                                      //  foreach ($color as $colors) {
                                                       //     echo "<option data-name='" . implode(',', $colors['name']) . "' data-id=" . $colors['_id']['$oid'] . " value=" . $colors['_id']['$oid'] . ">" . implode(',', $colors['name']) . "</option>";
                                                      //  }
                                                        ?>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>

                                            </div>
                                            <label id="colors-error" class="error" style="display:none">This field is required.</label>
                                        </div>
                                        <div class="col-sm-3 error-box" id="colorsErr"></div>

                                    </div> -->

                                     <!-- weight -->
                                     <!-- <div class="form-group required" >
                                        <label class="col-sm-2 control-label"><?php echo 'Weight'; ?></label>
                                        <div class="col-sm-6" style="display: flex">
                                                     <div class="" style="padding-left:0px !important;">
                                                        <input type="text" id="avgweight" name="avgWeight"
                                                            required="required"  class="error-box-class form-control" onkeypress="return isNumberKey(event)">
                                                    </div>

                                                    <div class="col-sm-6" style="padding-left:0px !important;">
                                                    <select type="text" id="avgweightunit" name="avgWeightunit"
                                                            class="error-box-class form-control weightunitlist" multiple="multiple">
                                                        </select>
                                                        
                                                    
                                                    </div>
                                           
                                        </div>
                                        <div class="col-sm-3 error-box" id="weightErr"></div>

                                    </div> -->
                                    
                                    
                                   
                                    

                                    <div class="form-group pos_relative2" style="display:none">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_PosName'); ?> </label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="POSName" name="POSName[0]"
                                                   required="required" class="error-box-class  form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_POSName"></div>
                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2" style="display:none">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_PosName'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="POSName" name="POSName[<?= $val['lan_id']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_POSName"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_PosName'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="POSName" name="POSName[<?= $val['lan_id']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_POSName"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2" style="display:none">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_BarcodeFormat'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="barcodeFormat" name="barcodeFormat"
                                                   required="required" class="error-box-class  form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_barcodeFormat"></div>
                                    </div>

                                    <div class="form-group pos_relative2" style="display:none">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_THC'); ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class  form-control" id="THC" name="THC" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box redClass" id="text_THC"></div>
                                    </div>
                                    <div class="form-group pos_relative2" style="display:none">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_CBD'); ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class  form-control" id="CBD" name="CBD" onkeypress="return isNumberKey(event)" >
                                        </div>
										<input type="hidden" id="THC" name="THC" value="0"/>
										<input type="hidden" id="CBD" name="CBD" value="0"/>
                                                   
                                        <div class="col-sm-3 error-box redClass" id="text_CBD"></div>
                                    </div>

                                </div>
                                <!-- addons -->
                                <!-- <hr>
                                 <h6 class="textAlign" >ADD-ON's GROUP</h6>
                                 <hr> -->
                                 <div class="form-group required" style="display:none">
                                        <label class="col-sm-2 control-label">Add-On's</label>
                                        <div class="col-sm-6">
                                            <div class="multiselect">
                                                <div class="selectBox"  style="width: 102%;">
                                                    <select class="addOn multiple form-control" name="addon[]" multiple="multiple">
                                                        <?php
														
														 if(count($language) < 1){
                                                        foreach ($addon as $result) {
															
																echo "<option  value=" . $result['_id']['$oid'] . "  data-name='" . $result['name']['en'] . "'>" . $result['name']['en'] . "</option>";
															
                                                        }
                                                    }
                                                    else{
                                                        
                                                        foreach ($addon as $result) {
                                                            $catData=$result['name']['en'];
                                                            foreach($language as $lngData){
                                                            $lngcode=$lngData['langCode'];
                                                            $lngvalue= ($result['name'][$lngcode]=='') ? "":$result['name'][$lngcode];
                                                            if(strlen( $lngvalue)>0){
                                                                $catData.= ',' . $lngvalue;
                                                               }
                                                           } 
                                                         
															 echo "<option  value=" .$result['_id']['$oid'] . "  data-name='" .  $catData . "'>" . $catData . "</option>";	
															
                                                        }
                                                    }
														
                                                      //  foreach ($color as $colors) {
                                                       //     echo "<option data-name='" . implode(',', $colors['name']) . "' data-id=" . $colors['_id']['$oid'] . " value=" . $colors['_id']['$oid'] . ">" . implode(',', $colors['name']) . "</option>";
                                                      //  }
                                                        ?>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>

                                            </div>
                                            <label id="colors-error" class="error" style="display:none">This field is required.</label>
                                        </div>
                                        <div class="col-sm-3 error-box" id="colorsErr"></div>

                                    </div>
                                    
                                 <hr>
                                 <h6 class="textAlign" >RECOMMEND FOR CONSUMPTION</h6>
                                 <hr>

                                    <div class="form-group" >
                                    <label class="checkbox-inline">
                                    <input type="checkbox" class="consumptionTime" value="breakfast" name ="consumptionTime[]"><span style="font-weight: 700;">Breakfast </span></label>
                                   
                                    <label class="checkbox-inline">
                                    <input type="checkbox" class="consumptionTime" value="brunch" name ="consumptionTime[]"><span style="font-weight: 700;">Brunch </span></label>
                                   
                                    <label class="checkbox-inline">
                                    <input type="checkbox" class="consumptionTime" value="lunch" name ="consumptionTime[]"><span style="font-weight: 700;">lunch</span></label>
                                    <label class="checkbox-inline">
                                    <input type="checkbox" class="consumptionTime" value="tea" name ="consumptionTime[]"><span style="font-weight: 700;">Tea And Snack</span></label>
                                    <label class="checkbox-inline">
                                    <input type="checkbox" class="consumptionTime" value="dinner" name ="consumptionTime[]"><span style="font-weight: 700;">Dinner</span></label>
                                    <label class="checkbox-inline">
                                    <input type="checkbox" class="consumptionTime" value="latenightdinner" name ="consumptionTime[]"><span style="font-weight: 700;">Late Night Dinner</span></label>
                                  
                                    </div>
                            </section>
                            <section class="" id="tab2">
                                <div class="row row-same-height">
                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo UNITS; ?></label>

                                    </div>
                                    <hr/>
                                    <div class="customField  row">
                                        <div class="customPriceField row" id="customePriceMain">

                                            <div class="form-group pos_relative2 customPriceField1">
                                                <label id="titleLabel" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Units'); ?> 1<span style="" class="MandatoryMarker"> *</span></label>
                                                <div class="col-sm-3 pos_relative2">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>
                                                    <input type="text" name="units[0][name][en]" class="error-box-class  form-control productTitle" id="title0"  placeholder="Text Element ">
                                                </div>
                                                <div class="col-sm-3 pos_relative2">
                                                    <span  class="abs_text"><b>$</b></span>
                                                    <input type="text" name="units[0][price][en]" class="error-box-class  form-control productValue" id="value0" placeholder="Value of text element "  onkeypress="return isNumberKey(event)">
                                                </div>
                                                <div class="col-sm-1" id="text_productTitleText">
                                                    <input type="button" id="custom" value="Add" class="btn btn-default pull-right marginSet btn-primary" style="margin-right: 0px;border-radius: 25px;">

                                                </div>
                                                <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div>
                                            </div>


                                            <?php
                                            foreach ($language as $val) {
                                                if ($val['Active'] == 1) {
                                                    ?>
                                                    <div class="form-group pos_relative2  customPriceField1">
                                                        <label id="titleLabel" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Units'); ?> 1(<?php echo $val['lan_name']; ?>)</label>
                                                        <div class="col-sm-3 pos_relative2">
                                                            <span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>
                                                            <input type="text" name="units[0][name][<?= $val['langCode']; ?>]" class="error-box-class  form-control productTitle" id="title0"  placeholder="Text Element ">
                                                        </div>
                                                        <div class="col-sm-3 pos_relative2">
                                                            <span  class="abs_text"><b>$</b></span>
                                                            <input type="text" name="units[0][price][<?= $val['langCode']; ?>]" class="error-box-class  form-control productValue" id="value0" placeholder="Value of text element "  onkeypress="return isNumberKey(event)">
                                                        </div>

                                                        <div class="col-sm-2 error-box redClass" ></div>

                                                    </div>
                                                <?php } else { ?>
                                                    <div class="form-group pos_relative2  customPriceField1" style="display:none">
                                                        <label id="titleLabel" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Units'); ?> 1(<?php echo $val['lan_name']; ?>)</label>
                                                        <div class="col-sm-3 pos_relative2">
                                                            <span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>
                                                            <input type="text" name="units[0][name][<?= $val['langCode']; ?>]" class="error-box-class  form-control productTitle" id="title0"  placeholder="Text Element ">
                                                        </div>
                                                        <div class="col-sm-3 pos_relative2">
                                                            <span  class="abs_text"><b>$</b></span>
                                                            <input type="text" name="units[0][price][<?= $val['langCode']; ?>]" class="error-box-class  form-control productValue" id="value0" placeholder="Value of text element "  onkeypress="return isNumberKey(event)">
                                                        </div>

                                                        <div class="col-sm-2 error-box redClass" ></div>

                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <div class="selectedsizeAttr row"></div>
                                        </div>
                                    </div>

                                </div>
                            </section>
                                           
                            <!-- <section class="" id="tab3" >
                                <div class="row row-same-height">


                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_PRODUCT_STRAIN_EFFECTS; ?></label>

                                    </div>
                                    <hr/>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Relaxed'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class  form-control" id="relaxed" name="strainEffects[relaxed]" onkeypress="return isNumberKey(event)" >
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_relaxed"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Happy'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class  form-control" id="happy" name="strainEffects[happy]" onkeypress="return isNumberKey(event)" >
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_happy"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Euphoric'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="euphoric" name="strainEffects[euphoric]" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_euphoric"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Uplifted'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="uplifted" name="strainEffects[uplifted]" onkeypress="return isNumberKey(event)" >
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_uplifted"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Creative'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="creative" name="strainEffects[creative]" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_creative"></div>
                                    </div>

                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_PRODUCT_MEDICAL_ATTRIBUTES; ?></label>

                                    </div>
                                    <hr/>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Stress'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="stress" name="medicalAttributes[stress]" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_stress"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Depression'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="depression" name="medicalAttributes[depression]" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_depression"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Pain'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="pain" name="medicalAttributes[pain]" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_pain"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Headaches'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="headaches" name="medicalAttributes[headaches]" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_headaches"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fatigue'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="fatigue" name="medicalAttributes[fatigue]" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_fatigue"></div>
                                    </div>


                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_PRODUCT_NEGATIVE_ATTRIBUTES; ?></label>

                                    </div>
                                    <hr/>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DryMouth'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="dryMouth" name="negativeAttributes[dryMouth]" onkeypress="return isNumberKey(event)" >
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_dryMouth"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DryEyes'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="CBD" name="negativeAttributes[dryEyes]" onkeypress="return isNumberKey(event)" >
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_CBD"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Anxious'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="anxious" name="negativeAttributes[anxious]" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_anxious"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Paranoid'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="paranoid" name="negativeAttributes[paranoid]" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_paranoid"></div>
                                    </div>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Dizzy'); ?></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class form-control" id="dizzy" name="negativeAttributes[dizzy]" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_dizzy"></div>
                                    </div>

                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo FIELD_PRODUCT_FLAVOURS; ?></label>

                                    </div>
                                    <hr/>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Flavour'); ?> 1</label>

                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" class="error-box-class form-control" id="flavour1" name="flavours[flavour1]" >
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_anxious"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Flavour'); ?> 2</label>

                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" class="error-box-class form-control" id="flavour2" name="flavours[flavour2]" >
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_paranoid"></div>
                                    </div>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Flavour'); ?> 3</label>

                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" class="error-box-class form-control" id="flavour3" name="flavours[flavour3]" >
                                        </div>

                                        <div class="col-sm-3 error-box" id="text_dizzy"></div>
                                    </div>

                                </div>
                            </section> -->

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
                                            <label id="td1" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Image'); ?> 1  <span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">
                                                <input type="file" name="imageupload" class="error-box-class form-control imagesProduct" id="image1" attrId="0" value="Text Element 1">
                                                <div id="loadingimg" style="display:none; position:absolute; width:150px; height:75px;z-index:1000;top:-70%; left:44%" >
                                                    <img src="<?php echo base_url(); ?>theme/icon/loadingicon.gif" style="width:75px;height:75px;">
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <img src="" style="width: 35px; height: 35px; display: none;"
                                                    class="imagesProduct style_prevu_kit">
                                            </div>
                                            <div class="col-sm-3 error-box" id="text_images1"></div>
                                            <input type="hidden" id="thumbnailImages0"  name="images[0][thumbnail]"/>
                                            <input type="hidden" id="mobileImages0"  name="images[0][mobile]"/>
                                            <input type="hidden" id="defaultImages0"  name="images[0][image]"/>
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

                                            <input type="text" id="upc" name="upcName[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_UPC'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="upc_<?php echo $val['langCode']; ?>"  name="upcName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_MPN'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="mpn" name="mpnName[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_MPN'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="mpn_<?php echo $val['langCode']; ?>"  name="mpnName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Model'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="model" name="modelName[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Model'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="model_<?php echo $val['langCode']; ?>"  name="modelName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ShelflifeUOM'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="uomShelfLife" name="uomShelfLife[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ShelflifeUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomShelfLife_<?php echo $val['langCode']; ?>"  name="uomShelfLife[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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

                                            <input type="text" id="UOMstorageTemperature" name="UOMstorageTemperature[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_UOMstorageTemperature"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_StorageTemperatureUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="UOMstorageTemperature_<?php echo $val['langCode']; ?>"  name="UOMstorageTemperature[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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

                                            <input type="text" id="warningName" name="warningName[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Warning'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="warningName_<?php echo $val['langCode']; ?>"  name="warningName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_AllergyInformation'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="allergyInfo" name="allergyInfo[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_AllergyInformation'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="allergyInfo_<?php echo $val['langCode']; ?>"  name="allergyInfo[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Servingspercalories'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCalories_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerCalories][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_CholesterolUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomCholesterol][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Cholesterolperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerCholesterol][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fatcaloriesperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerFatCalories][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_FibreUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomFibre_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomFibre][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fibreperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerFibre_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerFibre][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SodiumUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomSodium_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomSodium][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Sodiumperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="sodiumPerServing_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[sodiumPerServing][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ProteinUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomProtein_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomProtein][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Proteinperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerProtein_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerProtein][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TotalfatUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomTotalFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomTotalFat][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Totalfatperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerTotalFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerTotalFat][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TransfatUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomTransFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomTransFat][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Transfatperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerTransFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerTransFat][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCholesterol'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="cholesterolDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[cholesterolDVP][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCalcium'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="calciumDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[calciumDVP][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPIron'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="ironDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[ironDVP][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSodium'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="sodiumDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[sodiumDVP][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSaturatedFat'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="saturatedFatDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[saturatedFatDVP][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPTotalFat'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="totalFatDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[totalFatDVP][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminA'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminADvp_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[vitaminADvp][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminC'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminCDvp_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[vitaminCDvp][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminD'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminDDvp_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[vitaminDDvp][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Container'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="containerName_<?php echo $val['langCode']; ?>"  name="containerName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

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
                                                   required="required" class="error-box-class  form-control">

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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Containerperservings'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="containerPerServings_<?php echo $val['langCode']; ?>"  name="containerPerServings[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Genre'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="genreName" name="genreName[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Genre'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="genreName_<?php echo $val['langCode']; ?>"  name="genreName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Label'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="labelName" name="labelName[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Label'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="labelName_<?php echo $val['langCode']; ?>"  name="labelName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Artist'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="artistName" name="artistName[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Artist'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="artistName_<?php echo $val['langCode']; ?>"  name="artistName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Actor'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="actorName" name="actorName[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Actor'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="actorName_<?php echo $val['langCode']; ?>"  name="actorName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Director'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="directorName" name="directorName[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Director'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="directorName_<?php echo $val['langCode']; ?>"  name="directorName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Feature'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="featureName" name="featureName[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Feature'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="featureName_<?php echo $val['langCode']; ?>"  name="featureName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Publisher'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="publisherName" name="publisherName[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Publisher'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="publisherName_<?php echo $val['langCode']; ?>"  name="publisherName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Author'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="authorName" name="authorName[en]"
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
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Author'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="authorName_<?php echo $val['langCode']; ?>"  name="authorName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    

                                </div>
                            </section>-->
							
							
							<section class="" id="tab5" style="display:none">
                                <div class="row row-same-height">
                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('ADDITIONAL_DETAILS'); ?></label>

                                    </div>
                                    <hr/>
									
									<div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Ingredients'); ?></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="upc" name="ingredients[en]" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="ingredients[keyName][en]" value="UPC" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Ingredients'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="upc_<?php echo $val['langCode']; ?>" name="ingredients[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
                                                   <input type="hidden" id="" name="ingredients[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Ingredients'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="ingredientsName_<?php echo $val['langCode']; ?>"  name="ingredients[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="upc" name="upcName[en]" required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                   <input type="hidden" id="" name="upcName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_UPC'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="upc_<?php echo $val['langCode']; ?>"  name="upcName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="mpn" name="mpnName[en]" required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="mpnName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_MPN'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="mpn_<?php echo $val['langCode']; ?>"  name="mpnName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="model" name="modelName[en]"  required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="modelName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Model'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="model_<?php echo $val['langCode']; ?>"  name="modelName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="uomShelfLife" name="uomShelfLife[en]"
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="uomShelfLife[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ShelflifeUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomShelfLife_<?php echo $val['langCode']; ?>"  name="uomShelfLife[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="UOMstorageTemperature" name="UOMstorageTemperature[en]" required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="UOMstorageTemperature[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_UOMstorageTemperature"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_StorageTemperatureUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="UOMstorageTemperature_<?php echo $val['langCode']; ?>"  name="UOMstorageTemperature[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="warningName" name="warningName[en]" required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="warningName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Warning'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="warningName_<?php echo $val['langCode']; ?>"  name="warningName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="allergyInfo" name="allergyInfo[en]"  required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="allergyInfo[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_AllergyInformation'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="allergyInfo_<?php echo $val['langCode']; ?>"  name="allergyInfo[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="servingPerCalories" name="nutritionFactsInfo[servingPerCalories][en]"  required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerCalories][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">
                                                    

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Servingspercalories'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCalories_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerCalories][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="uomCholesterol" name="nutritionFactsInfo[uomCholesterol][en]"  required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomCholesterol][keyName][<?= $val['langCode']; ?>]" value="Cholesterol" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_CholesterolUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomCholesterol][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerCholesterol][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Cholesterolperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerCholesterol][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerFatCalories][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fatcaloriesperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerFatCalories][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomFibre][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_FibreUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomFibre_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomFibre][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerFibre][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Fibreperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerFibre_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerFibre][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomSodium][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SodiumUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomSodium_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomSodium][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[sodiumPerServing][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Sodiumperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="sodiumPerServing_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[sodiumPerServing][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomProtein][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_ProteinUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomProtein_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomProtein][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerProtein][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Proteinperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerProtein_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerProtein][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomTotalFat][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TotalfatUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomTotalFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomTotalFat][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerTotalFat][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Totalfatperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerTotalFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerTotalFat][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[uomTransFat][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_TransfatUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomTransFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomTransFat][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[servingPerTransFat][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Transfatperserving'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="servingPerTransFat_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[servingPerTransFat][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[cholesterolDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCholesterol'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="cholesterolDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[cholesterolDVP][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[calciumDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPCalcium'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="calciumDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[calciumDVP][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[ironDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPIron'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="ironDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[ironDVP][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[sodiumDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSodium'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="sodiumDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[sodiumDVP][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[saturatedFatDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPSaturatedFat'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="saturatedFatDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[saturatedFatDVP][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[totalFatDVP][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPTotalFat'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="totalFatDVP_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[totalFatDVP][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[vitaminADvp][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminA'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminADvp_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[vitaminADvp][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[vitaminCDvp][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminC'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminCDvp_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[vitaminCDvp][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="nutritionFactsInfo[vitaminDDvp][keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DVPvitaminD'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="vitaminDDvp_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[vitaminDDvp][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="containerName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Container'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="containerName_<?php echo $val['langCode']; ?>"  name="containerName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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
                                                   required="required" class="error-box-class  form-control">
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="containerPerServings[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Containerperservings'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="containerPerServings_<?php echo $val['langCode']; ?>"  name="containerPerServings[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="genreName" name="genreName[en]"
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="genreName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Genre'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="genreName_<?php echo $val['langCode']; ?>"  name="genreName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="labelName" name="labelName[en]"
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="labelName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Label'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="labelName_<?php echo $val['langCode']; ?>"  name="labelName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="artistName" name="artistName[en]"
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="artistName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Artist'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="artistName_<?php echo $val['langCode']; ?>"  name="artistName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="actorName" name="actorName[en]"
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="actorName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Actor'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="actorName_<?php echo $val['langCode']; ?>"  name="actorName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="directorName" name="directorName[en]"
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="directorName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Director'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="directorName_<?php echo $val['langCode']; ?>"  name="directorName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="featureName" name="featureName[en]"
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="featureName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Feature'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="featureName_<?php echo $val['langCode']; ?>"  name="featureName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="publisherName" name="publisherName[en]"
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="publisherName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Publisher'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="publisherName_<?php echo $val['langCode']; ?>"  name="publisherName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="authorName" name="authorName[en]"
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
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="authorName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Author'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="authorName_<?php echo $val['langCode']; ?>"  name="authorName[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
                                                    <input type="hidden" id="" name="authorName[keyName][<?= $val['langCode']; ?>]" value="" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    

                                </div>
                            </section>

<!--                            <div class="padding-20 bg-white col-sm-9">
                                <ul class="pager wizard">
                                    
                                    <li class="" id="finishbutton">
                                        <button class="btn btn-success finishbutton pull-right" type="button" onclick="submitform()"><span><?php echo BUTTON_FINISH; ?></span></button>
                                    </li>

                                </ul>
                            </div>-->

                        </div>
                        <input type="hidden" name="current_dt" id="time_hidden" value="" />

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
                        <input type="hidden" id="features" name="features" value="" />
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


<script>
    $(document).ready(function () {
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
                            if(sizegroups.length > 0){

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
                                                                                                    ?><option data-name="<?php echo $siz['sAttrLng']['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + $(this).val() + '" ><?php echo $siz['sAttrLng']['en']; ?></option>\n\
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
//                                                        selectedsize.push($(this).val());
                                                    }
                                                });
//                                                console.log(selectedsize);
                                                }

        });

        function renameImageLabels() {
            for (var i = 0, length = $('.imageTag').length; i < length; i++) {
                $('.imageTag>label').eq(i).text('Image ' + (i + 2));


            }
        }
        function renameUnitsLabels() {
            for (var j = 0, length = $('.customPriceField').length; j < length; j++) {
                $('.customPriceField>label').eq(j).text('Units ' + (j + 2) + ' *');


            }
        }

        // REMOVE ONE ELEMENT PER CLICK.
        $('body').on('click', '.btRemove', function () {
            $(this).parent().remove();
            renameImageLabels();
        });
        $('body').on('click', '.btnRemove', function () {
            $(this).parent().parent().remove();
            renameUnitsLabels();
        });


    });

</script>
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
<div id="errorModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">
                <p class="modalPopUpText" style="color:#0090d9;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>

    </div>
</div>
<script>
    $('.multiple').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '100%',
        maxHeight: 300,
    });
</script>

<script>
        // get data for select2
        $(".weightunitlist").select2({
            ajax: {
                url: "<?php echo pythonAPILink;?>unitmeasurement",
                dataType: 'json',
                headers: {
                    'language':'en',
                    'authorization':'<?php echo $this->session->userdata('godsviewToken');  ?>'
                },
                delay: 100,
                data: function (params) {
                return {
                    q: params.term || "",
                    page: params.page
                };
                },
                processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                    more: (params.page * 20) < data.total_count
                    }
                };
                },
                cache: true
            },
            placeholder: 'Search like dozen, inch etc. ',
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            maximumSelectionSize: 1,
            maximumSelectionLength:1,
            // templateResult: formatRepo,
            // templateSelection: formatRepoSelection,
            });

</script>
