
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->
    <script src="https://rawgit.com/shvetsgroup/jquery.multisortable/master/src/jquery.multisortable.js"></script>
<style>

        body.dragging,
        body.dragging * {
            cursor: move !important;
        }

        .dragged {
            position: absolute;
            opacity: 0.5;
            z-index: 2000;
        }

        ol.vertical li {
            display: flex;
            margin: 5px;
            padding: 5px;
            border: 1px solid #cccccc;
            color: #0088cc;
            background: #eeeeee;
            justify-content: space-between;
            align-items: center;
            position : relative;
        }
        ol.vertical li.selected {
            outline: 1px solid #080808 ;
        }
        ol.vertical {
            padding: 8px;
        }
        ol.vertical li input {
            width: 45%;
            height: 27px;
        }
        .row-drag {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .justify-content-center-drag {
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }

        .col-6-drag {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col-6-drag {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .border-drag {
            border: 1px solid #b5a4a4 !important;
        }

        .containerDrag {
            width: 100%;
        }

        .drag-handle {
            /* padding: 0px 6px;
            border: 1px solid black;
            border-radius: 50%; */
            cursor: move;
            font-size: 19px;
        }

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
	#big_table_info{
		margin-left: 10px !important;
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
        right:15px;
        top: 1px;
        z-index: 9px;
        padding: 9px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }

    span.abs_text-drag {
        position: absolute;
    right: 5px;
    height: 25px;
    /* top: 54px; */
    z-index: 9px;
    padding: 6px;
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
        /* position: fixed; */
        z-index: 999;
        width: 100%;
        top: 0;
         background: #fff;
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
    .form-group.pos_relative2.productNameListDiv {
    position: absolute;
    width: 100%;
    top: 40px;
    left: -4px;
}
div#productNameList {
    border: 1px solid #cacaca;
    position: relative;
    padding: 10px;
    max-height: 100px;
    overflow-y: scroll;
    position: absolute;
    width: 98%;
    z-index: 999;
    background: #fff;
    top: 0px;

}p.pData {
    cursor: pointer;
    padding: 5px;
}
p.pData:hover {
    background: #006df9;
    color: #fff;
    padding: 5px;
}
.row-same-height {
    position: relative;
}
.loader {
    border: 3px solid #f3f3f3;
    border-radius: 50%;
    border-top: 3px solid #3498db;
    width: 30px;
    height: 30px;
    -webkit-animation: spin 0.5s linear infinite;
    animation: spin 0.5s linear infinite;
    position: absolute;
    right: 7px;
    top: 2px;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* // category */
div#catproductNameList {
    border: 1px solid #cacaca;
    position: relative;
    padding: 10px;
    max-height: 100px;
    overflow-y: scroll;
    position: absolute;
    width: 93%;
    z-index: 999;
    background: #fff;
    top: 40px;

}

div#subproductNameList {
    border: 1px solid #cacaca;
    position: relative;
    padding: 10px;
    max-height: 100px;
    overflow-y: scroll;
    position: absolute;
    width: 93%;
    z-index: 999;
    background: #fff;
    top: 40px;

}

div#subsubproductNameList {
    border: 1px solid #cacaca;
    position: relative;
    padding: 10px;
    max-height: 100px;
    overflow-y: scroll;
    position: absolute;
    width: 93%;
    z-index: 999;
    background: #fff;
    top: 40px;

}
.top_navCusBt{
    background:#fff !important;
}
.right_col{
    /* for add product header */
    max-width: calc(100% - 230px)!important;
    /* border: 1px solid red!important; */
    float: right!important;
    width: 100%!important;
    margin-left: unset !important;
    min-height:100vh;
    height:100%;
}
ul.navbar-nav.navbar-left.nav.nav-tabs.nav-tabs-linetriangle.nav-tabs-separator.nav-stack-sm.fixednab {
        /* position: fixed; */
       position:static !important;
    }

    li.selected {
            outline: 1px solid red;
        }
   div#linkedAddons {
     margin: 5px 0px;
     /* added later */
     display: flex;
     overflow: auto;
   }
    div#linkedAddons .linkedAddons {
                margin: 4px;
        display: inline;
        border: 1px solid grey;
        padding: 10px;
        position: relative;
        padding-right: 25px;
        outline: 4px solid #dadada;
        margin-right: 10px;
        cursor: pointer;

        /* added later */
        flex-shrink: 0;      
       
    }
    div#linkedAddons span.glyphicon.glyphicon-remove {
       /* border-left: 1px solid grey;
        padding: 5px;
        position: absolute;
        top: 0px;
        height: 100%;
        padding-top: 10px;
        cursor: pointer;
        margin-left: 5px; chnages*/
        border-left: 1px solid grey;
        padding: 5px;
        position: absolute;
        align-items: center;
        display: flex;
        right: 0;
        height: 100%;
        cursor: pointer;
    }
    .mb-10-drag {
        margin-top: 20px;
    }

    .consumptionTime{
        margin-top:0px !important;
    }
</style>

<script src="<?php echo  ServiceLink ; ?>vendors/bootstrap/dist/js/bootstrap-multiselect.js"></script>
<link href="<?php echo  ServiceLink ; ?>vendors/bootstrap/dist/css/bootstrap-multiselect.css" rel="stylesheet">

<link
    href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css"
    rel="stylesheet" type="text/css" />

<script>

// ******for category******

var glocatId;
var glosubcatId;
var modalGlobalLang=0;

// display add sub category button on click of category button 
$(document).on('change', "#category", function(){
    $('#subbtnStickUpSizeToggler').show();
    glocatId=$(this).val();
    console.log(glocatId);
});

function renameImageLabelsUnit() {
       for (var i = 0, length = $('.imageTag').length; i < length; i++) {
           $('.imageTag>label').eq(i).text('Image ' + (i + 1));
       }
   }

      $("body").click
(
  function(e)
  {
      
    if(e.target.className !== "productDropdown")
    {
      $(".productDropdown").hide();
    }
  }
);
// display add sub sub category button on click of xub category button
$(document).on('change', "#subCategory", function(){
    $('#subsubbtnStickUpSizeToggler').show();
    glosubcatId=$(this).val();
   
});

$(document).ready(function(){

    $('#btnStickUpSizeToggler').click(function () {
        
            $("#display-data").text("");
            $("#display-data").text("");
            $('.catname').val("");
            $('#categoryError').text("");
            $('.catDescription').val("");
            $('#cat_photos').val("");
            //$(".imagesProduct").css('display','none'); 
         
         
           //  $(".imagesProduct").css('display','none'); 


            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $('#modalHeading').html("ADD CATEGORY");
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#catmyModal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#catmyModal').modal('show');
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
            } else {
                $('#displayData').modal('show');
                $("#display-data").text("Invalid selection");
            }
        });

        // sub category modal
         $('#subbtnStickUpSizeToggler').click(function () {
            $("#display-data").text("");
            $("#display-data").text("");
            $('.catname').val("");
            $('#categoryError').text("");

            $('.catDescription').val("");
            $('#cat_photos').val("");
           // $(".imagesProduct").css('display','none'); 
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $('#modalHeading').html('ADD SUB-CATEGORY');
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#myModal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#subcatmyModal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
            } else {
                $('#displayData').modal('show');
                $("#display-data").text("Invalid selection");
            }
        });


        
$('#subsubbtnStickUpSizeToggler').click(function () {
            $('#subsubcatname_0').val("");
            $('.catDescription').val("");
            $('#cat_photos').val("");
            $("#display-data").text("");
            $("#categoryError").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $('#modalHeading').html("ADD SUB SUB-CATEGORY");
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#myModal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#subsubcatmyModal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
            } else {
                $('#displayData').modal('show');
                $("#display-data").text("Invalid Selection");
            }
        });


   


    $('#catinsert').click(function () {
                $('#catmyModal').modal('hide');
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if ($('#catname_0').val() == "" || $('#catname_0').val() == null)
            {
                $("#categoryError").text("Please enter the category name");
            } 
           
             else if (val.length == 1 || val.length > 1) {
                $('#displayData').modal('show');
                $('#display-data').text('Invalid Selection')
            } else {
                var imgUrl = '';
                var form_data = new FormData();
                var form_data1 = new FormData();
                var catname = new Array();
                var catDescription = new Array();
                var parentCatId=$('#parentCatId').val();
               
                if(parentCatId=="" || parentCatId==null){
                    parentCatId="";
                }

                $(".catname").each(function () {
                    catname.push($(this).val());
                    form_data1.append('name[]', $(this).val());
                });

                $(".catDescription").each(function () {
                    catDescription.push($(this).val());
                    form_data1.append('description[]', $(this).val());
                });

                var visibility = parseInt(1);

                form_data1.append('visibility', visibility);
                form_data1.append('parentCatId', parentCatId);
                form_data1.append('addedFrom', "store");
                form_data1.append('parentCatId',0);

                var cat_photos = $("#cat_photos").val();
             

                form_data.append('type', 'uploadImage');
                form_data.append('Image', 'Image');
                form_data.append('folder', 'first_level_category');

                var imgUrl = '';
                $(document).ajaxStart(function () {
                    $("#wait").css("display", "block");
                });


                         imgUrl=$("#catimagesProductImg").val();
                            form_data1.append('imageUrl', imgUrl);
                            $.ajax({
                                url: "<?php echo base_url('index.php?/Category/operationCategory') ?>/insert",
                                type: 'POST',
                                data: form_data1,
                                dataType: 'JSON',
                                success: function (response)
                                {
                                    $('#catmyModal').modal('hide');
                                    $('#category').load("<?php echo base_url('index.php?/GridProduct_controller') ?>/getCatlist");                
                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            });
                     
                $(".catname").val("");
                $(".catDescription").val("");
                $("#cat_photos").val("");
                $('#myModal').hide();
            }
        });


        // subcat insert
        
        $('#subcatinsert').click(function () {

                if ($('#subcatname_0').val() == "" || $('#subcatname_0').val() == null)
                {
                    $("#categoryError").text("Please enter sub-category name");
                }

                var img = '';
                var imgUrl = ''
                var cateid = glocatId;
                var form_data = new FormData();
                var form_data1 = new FormData();
                var catname = new Array();
                var description = new Array();
                var parentCatId=$('#subcatparentCatId').val();
                
                if(parentCatId=="" || parentCatId==null){
                    parentCatId="";
                }

                $(".subcatname").each(function () {
                    catname.push($(this).val());
                    form_data1.append('name[]', $(this).val());
                });
                $(".catDescription").each(function () {
                    description.push($(this).val());
                    form_data1.append('description[]', $(this).val());
                });

                var cat_photos = $("#cat_photos").val();

                form_data1.append('categoryId', cateid);
                var visibility = parseInt(1);
                form_data1.append('visibility', visibility);
                form_data1.append('addedFrom', 'store');
                form_data1.append('parentCatId', parentCatId);
                // form_data.append('OtherPhoto', file_data);
                form_data.append('type', 'uploadImage');
                form_data.append('Image', 'Image')
                form_data.append('folder', 'second_level_category');
                if (catname == "" || catname == null)
                {
                    $("#clearerror").text("Please enter the Category name");
                } else {
                    var imgUrl = '';
                
                                imgUrl=$("#subcatimagesProductImg").val();
                                img = imgUrl;
                                form_data1.append('imageUrl', img);

                                $.ajax({
                                    url: "<?php echo base_url('index.php?/SubCategory') ?>/insertSubCategory",
                                    type: 'POST',
                                    data: form_data1,
                                    dataType: 'JSON',
                                    success: function (response)
                                    {
                                      
                                    

                                    $('#subcatmyModal').modal('hide');
                                    var categoryId=glocatId;
                                    $('#subCategory').load("<?php echo base_url('index.php?/GridProduct_controller') ?>/getSubCategory", {categoryId: categoryId});  

                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                });
                
                        $(".catname").val("");
                        $("#catDescription").val("");
                        $("#cat_photos").val("");
                        $('#myModal').hide();
                    }
                    });


    // sub sub cat
         $('#subsubinsert').click(function () {
             console.log('click subsub');
            if ($('#subsubcatname_0').val() == "" || $('#catname_0').val() == null)
            {
                $("#categoryError").text("Please enter the sub sub-category name");
            } 
           
            $('.clearerror').text("");
            var img = '';
            var imgUrl = ''
            var cateid = glosubcatId;
            var form_data = new FormData();
            var form_data1 = new FormData();
            var catname = new Array();
            var description = new Array();
            var id=glocatId;

             var parentCatId=$('#parentCatId').val();
               
               if(parentCatId=="" || parentCatId==null){
                   parentCatId="";
               }

            $(".subsubcatname").each(function () {
                form_data1.append('name[]', $(this).val());
                catname.push($(this).val());
            });

            $(".subsubcatDescription").each(function () {
                description.push($(this).val());
                form_data1.append('description[]', $(this).val());
            });

            var cat_photos = $("#cat_photos").val();
            var file_data = $('#cat_photos').prop('files')[0];
            form_data1.append('subCategoryId', cateid);
            form_data1.append('parentCatId', parentCatId);
            form_data1.append('categoryId', id);
            var visibility = parseInt(1);
            form_data1.append('visibility', visibility);
            form_data1.append('addedFrom', 'store');

            // form_data.append('cat_photos', file_data);
            // form_data.append('OtherPhoto', file_data);

            form_data.append('type', 'uploadImage');
            form_data.append('Image', 'Image')
            form_data.append('folder', 'third_level_category');
            if ($('#subsubcatname_0').val() == "" || $('#subsubcatname_0').val() == null)
            {
                $("#clearerror").text(<?php echo json_encode(POPUP_CAT_NAME); ?>);
            } else {
                var imgUrl = '';
                                         

                             imgUrl=$("#subsubimagesProductImg").val();
                             img = imgUrl;
                            form_data1.append('imageUrl', img);
                            $.ajax({
                                url: "<?php echo base_url('index.php?/SubsubCategory') ?>/insertSubSubCategory",
                                type: 'POST',
                                data: form_data1,
                                dataType: 'JSON',
                                success: function (response)
                                {
                                    $('#subsubcatmyModal').modal('hide');
                                    var subCategoryId=glosubcatId;
                                    $('#subSubCategory').load("<?php echo base_url('index.php?/GridProduct_controller') ?>/getSubSubCategory", {subCategoryId: subCategoryId});
                                },
                                cache: false,
                                contentType: false,
                                processData: false
                            });
            
                $(".catname").val("");
                $(".catDescription").val("");
                $("#cat_photos").val("");
                $('#myModal').hide();
            }
        });





});

// *****for category end*******
    var selectedsize = [];
//here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

    function submitform()
    {
        $('#finishbutton').prop('disabled', false);
        $(".error-box").text("");

        var name = $('#name_0').val();
        var category = $('#category').val();
        var barcode = $('#barcode').val();
        var shortDescription = $('#shortDescription_0').val();
        var THC = $('#THC').val();
        var CBD = $('#CBD').val();
        var title = $('.productTitle').val();
        var value = $('.productValue').val();
        var image = $('#image1').val();
        console.log('imahe',image);
        var rxMandatory=$('input[name=rx]:checked').val();
        var storeType='<?php echo $storeType?>'
        var selectType = $('.selectType option:selected').val();
       
       
        
       if (name == '' || name == null) {
            $('#name_0').focus();
            $('#text_name').text('Please enter the name');
        } else if (category == '' || category == null) {
            $('#category').focus();
            $('#text_category').text('Please select the category');
        } else if (shortDescription == '' || shortDescription == null) {
            $('#shortDescription_0').focus();
            $('#text_shortDescription').text('Please enter the short description');
        } else if (selectType == '') {
            $('.selectType').focus();
            $('#text_taxflag').text('Please select tax type');
        } 	
		else if (title == '' || title == null || value == '' || value == null) {
            $('#productTitle').focus();
            $('#text_productCustomText').text('Enter title and value both ');
        }
        //  else if (image == '' || image == null) {
        //     $('#image1').focus();
        //     $('#text_images1').text('upload at least one image ');
        // } 

        
    //     else if(storeType==6 || storeType=="6" && rxMandatory==1 && ((professionalUsageFile == '' || professionalUsageFile == null) || (personalUsageFile == '' || personalUsageFile == null)) ){
    //                 console.log('in');
    //                if (professionalUsageFile == '' || professionalUsageFile == null) {
    //                    console.log('pass1');
    //                 $('#professionalUsageFile').focus();
    //                 $('#professionalUsageFile_error').text('Please upload a file');
    //             }else  if (personalUsageFile == '' || personalUsageFile == null) {
    //                 console.log('pass2');
    //                 $('#personalUsageFile').focus();
    //                 $('#personalUsageFile_error').text('Please upload a file');
    //             }     

    //    } 
       else {
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

        function loadCategory(catid){
        $("#category").empty();
            //console.log(catid);
            $.ajax({
                    url: "<?php echo base_url(); ?>index.php?/AddNewProducts/loadCategory",
                    type: "GET",
                    dataType: "JSON",
                    success: function (response) {
                        // console.log(response);
                        var cateData = response.Category;
                        // console.log(cateData);
                        
                        var htmlOption ='<option data-name="" data-id="" value="0">Select Category</option>';
                        $(cateData).each(function(index,row){
                            if(row.categoryId == catid){
                                htmlOption+= '<option data-name="'+row.name.en+'" data-id="'+row.categoryId+'" value="'+row.categoryId+'" selected>'+row.name.en+'</option>';
                            }
                            else{
                                htmlOption+= '<option data-name="'+row.name.en+'" data-id="'+row.categoryId+'" value="'+row.categoryId+'">'+row.name.en+'</option>';
                            }
                        
                        });
                        $("#category").append(htmlOption);
                    }
            });
      }

          function loadSubCategory(catid,subcatid){
        $("#subCategory").empty();
        $.ajax({
                url: "<?php echo base_url(); ?>index.php?/AddNewProducts/loadSubCategory",
                type: "POST",
                data:{categoryId:catid},
                dataType: "JSON",
                success: function (response) {
                    // console.log(response);
                    var subcateData = response.subCategory;
                    //console.log(subcateData);
                    
                    var htmlsubCateOption ='<option data-name="" data-id="" value="0">Select SubCategory</option>';
                    $(subcateData).each(function(index,row){
                        if(row.subCategoryId == subcatid){
                            htmlsubCateOption+= '<option data-name="'+row.subcateName.en+'" data-id="'+row.subCategoryId+'" value="'+row.subCategoryId+'" selected>'+row.subcateName.en+'</option>';
                        }
                        else{
                            htmlsubCateOption+= '<option data-name="'+row.subcateName.en+'" data-id="'+row.subCategoryId+'" value="'+row.subCategoryId+'">'+row.subcateName.en+'</option>';
                        }
                       
                    });
                    $("#subCategory").append(htmlsubCateOption);
                }
        });
    }
    function loadSubSubCategory(catid,subcatid,subsubid){
        $("#subSubCategory").empty();
        $.ajax({
                url: "<?php echo base_url(); ?>index.php?/AddNewProducts/loadSubSubCategory",
                type: "POST",
                data:{categoryId:catid,subCategoryId:subcatid},
                dataType: "JSON",
                success: function (response) {
                    
                    var subsubcateData = response.subSubCategory;
                   
                    
                    var htmlsubsubCateOption ='<option data-name="" data-id="" value="0">Select SubCategory</option>';
                    $(subsubcateData).each(function(index,row){
                        if(row.subSubCategoryId == subsubid){
                            htmlsubsubCateOption+= '<option data-name="'+row.subSubcateName.en+'" data-id="'+row.subSubCategoryId+'" value="'+row.subSubCategoryId+'" selected>'+row.subSubcateName.en+'</option>';
                        }
                        else{
                            htmlsubsubCateOption+= '<option data-name="'+row.subSubcateName.en+'" data-id="'+row.subSubCategoryId+'" value="'+row.subSubCategoryId+'">'+row.subSubcateName.en+'</option>';
                        }
                       
                    });
                    $("#subSubCategory").append(htmlsubsubCateOption);
                }
        });
    }
   
    function loadManufacture(manuId){
        console.log("manuid"+manuId);
        $("#manufacturer").empty();
        $.ajax({
                url: "<?php echo base_url(); ?>index.php?/AddNewProducts/loadManufacture",
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    // console.log(response);
                    var manufacturer = response.manufacturer;
                    // console.log(manufacturer);
                    
                    var htmlmanufacturerOption ='<option data-name="" data-id="" value="0">Select Manufacturer</option>';
                    $(manufacturer).each(function(index,row){
                      // var manufacturerIdRes = String(row._id.$oid);
                      
                        if((row._id.$oid.toString()) == manuId){
                           // console.log("manu",manufacturerIdRes , manuId)
                            htmlmanufacturerOption+= '<option data-name="'+row.name.en+'" data-id="'+row._id.$oid+'" data-mcode="'+row.mCode+'" value="'+row._id.$oid+'" selected>'+row.name.en+'</option>';
                        }
                        else{
                            htmlmanufacturerOption+= '<option data-name="'+row.name.en+'" data-id="'+row._id.$oid+'" data-mcode="'+row.mCode+'" value="'+row._id.$oid+'">'+row.name.en+'</option>';
                        }
                       
                    });
                    $("#manufacturer").append(htmlmanufacturerOption);
                }
        });
    }
    function loadBrand(brandId){
        console.log("brandId "+brandId);
        $("#brand").empty();
        $.ajax({
                url: "<?php echo base_url(); ?>index.php?/AddNewProducts/loadBrand",
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    // console.log(response);
                    var brand = response.brand;
                    // console.log(manufacturer);
                    
                    var htmlBrandOption ='<option data-name="" data-id="" value="0">Select Brand</option>';
                    $(brand).each(function(index,row){
                      //console.log(row._id.$oid,brandId)
                      //var brandIdRes = String(row._id.$oid);
                        if((row._id.$oid.toString()) == brandId){
                            htmlBrandOption+= '<option data-name="'+row.name.en+'" data-id="'+row._id.$oid+'" value="'+row._id.$oid+'" selected>'+row.name.en+'</option>';
                        }
                        else{
                            htmlBrandOption+= '<option data-name="'+row.name.en+'" data-id="'+row._id.$oid+'"  value="'+row._id.$oid+'">'+row.name.en+'</option>';
                        }
                       
                    });
                    $("#brand").append(htmlBrandOption);
                    // $('#brand').val(brandId);
                }
        });
    }

  $(document).ready(function(){
       

       $('input[name="rx"]').change(function(){
          if($('#rx1').prop('checked')){
             
          }else{
              $('#professionalUsageFile_span').hide();
              $('#personalUsageFile_span').hide();
          }
      });
  
    
  });

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

            console.log('images cliced');
           
            $('#text_images1').text("");
            var fieldID = $(this).attr('attrId');
            var ext = $(this).val().split('.').pop().toLowerCase();
            var formElement = $(this).prop('files')[0];
            console.log(formElement);

            uploadImage(fieldID, ext, formElement);

        });

                 $(document).on('change', '.personalUsageFile', function () {

console.log('personalUsageFile');
   $('#text_images1').text("");
   var fieldID = $(this).attr('attrId');
   var ext = $(this).val().split('.').pop().toLowerCase();
   var formElement = $(this).prop('files')[0];
  

    var fileName1 = formElement.name;
               var form_data = new FormData();
             
               
               form_data.append('OtherPhoto', formElement);
               
               form_data.append('type', 'uploadImage');
               form_data.append('Image', 'Image');
               form_data.append('folder', 'personalUsageFile');
               $(document).ajaxStart(function () {
                       $(".finishbutton").prop("disabled",true)
                   $("#loadingimg").css("display","block");
               });
               $.ajax({
                   url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                   type: "POST",
                   data: form_data,
                   dataType: "json",  
                   processData: false,
                   contentType: false,
                   success: function (json,textStatus, xhr) {
                     

                        //    var filename=JSON.stringify(json.fileName);
                        //    console.log('professionalUsageFile----',filename);
                       if(xhr.status=="200"){

                                $('#personalUsageFilehidden').val(json.fileName);

                                 $(document).ajaxComplete(function () {
                                       $(".finishbutton").prop("disabled",false)
                                   $("#loadingimg").css("display","none");
                                 });


                       }
                     
                   }
               });

  

});


   $(document).on('change', '.professionalUsageFile', function () {
      
       $('#text_images1').text("");
   var fieldID = $(this).attr('attrId');
   var ext = $(this).val().split('.').pop().toLowerCase();
   var formElement = $(this).prop('files')[0];
  

    var fileName1 = formElement.name;
               var form_data = new FormData();
             
               
               form_data.append('OtherPhoto', formElement);
               
               form_data.append('type', 'uploadImage');
               form_data.append('Image', 'Image');
               form_data.append('folder', 'professionalUsageFile');
               $(document).ajaxStart(function () {
                       $(".finishbutton").prop("disabled",true)
                   $("#loadingimg").css("display","block");
               });
               $.ajax({
                   url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                   type: "POST",
                   data: form_data,
                   dataType: "json",  
                   processData: false,
                   contentType: false,
                   success: function (json,textStatus, xhr) {
                           
                           
                  
                         //  var filename=JSON.stringify(json.fileName);
                  
                       if(xhr.status=="200"){

                              $('#professionalUsageFilehidden').val(json.fileName);

                                 $(document).ajaxComplete(function () {
                                       $(".finishbutton").prop("disabled",false)
                                   $("#loadingimg").css("display","none");
                                 });


                       }
                     
                   }
               });

});

        $('#category').on('change', function () {
            var val = $(this).val();
            //$('#subCategory').load("<?php echo base_url('index.php?/SubCategory') ?>/getSubCategoryData", {val: val});
            var entities = '';
        $.ajax({

            url: "<?php echo base_url('index.php?/SubCategory') ?>/getSubCategoryData/" + val,
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
            var val = $(this).val();
           // $('#subSubCategory').load("<?php echo base_url('index.php?/SubsubCategory') ?>/getSubsubCategoryDataList", {val: val});

            $.ajax({

            url: "<?php echo base_url('index.php?/SubsubCategory') ?>/getSubsubCategoryDataList/" + val,
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
            var htmlImage='';
            var form_data = new FormData();
            var amazonPath = '<?php echo AMAZON_URL;?>'
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
                        console.log(response);
                        console.log(amazonPath+ response.data[0].path);
                        htmlImage +='<div class="col-sm-2 imageremovedynamic" data-id="'+fieldID+'"><a href="'+amazonPath + response.data[0].path+'" target="_blank"><img src="'+amazonPath + response.data[0].path+'" style="height:100px;width:100px;border:1px solid;"></a></div>';
                         $('#dynamicViewImage').append(htmlImage);
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
                                $(".finishbutton").prop("disabled",false)
                               $("#loadingimg").css("display","none");

                                // $('.imagesProduct').attr('src', amazonPath + row.path);
                                // $('.imagesProduct').show();
                                
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

    function defaultUnit() {
        var uName= $('#name_0').val();
       $('#title0').val(uName);   
    }

    // ********cat image*************

        $(document).on('change', '.catImage', function () {
                console.log('cat image');
           
           var fieldID = 0;
           var ext = $(this).val().split('.').pop().toLowerCase();
           var formElement = $(this).prop('files')[0];
           uploadImagecat(fieldID, ext, formElement);
       })


       $(document).on('change', '.subcatImage', function () {
                console.log('cat image');
           
           var fieldID = 1;
           var ext = $(this).val().split('.').pop().toLowerCase();
           var formElement = $(this).prop('files')[0];
           uploadImagecat(fieldID, ext, formElement);
       })

       $(document).on('change', '.subsubcatImage', function () {
                console.log('cat image');
           
           var fieldID = 2;
           var ext = $(this).val().split('.').pop().toLowerCase();
           var formElement = $(this).prop('files')[0];
           uploadImagecat(fieldID, ext, formElement);
       })

       


         function uploadImagecat(fieldID, ext, formElement)
        {
            console.log('called');
            if ($.inArray(ext, ['jpg', 'JPEG','png','PNG','jpeg']) == -1) {
              alert("please upload .jpg image")
            } else
            {
                var form_data = new FormData();
                var amazonPath = " http://s3.amazonaws.com"
                var file_data = formElement;
                var fileName = file_data.name;
                form_data.append('OtherPhoto', file_data);
                form_data.append('type', 'uploadImage');
                form_data.append('Image', 'Image');
                form_data.append('folder', 'first_level_category');
                
                $(document).ajaxStart(function () {
                    if(fieldID < 3)
                    $("#insert").prop("disabled",true)
                    else
                    $("#editbusiness").prop("disabled",true)
                  
                });

                $.ajax({
                    url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                    type: "POST",
                    data: form_data,
                    dataType: "JSON",
                    beforeSend: function () {
                    },
                    success: function (result) {
                        console.log('pas1');
                        if(fieldID == 0){
                            console.log('pas2');
                           $("#catimagesProductImg").val(result.fileName) 
                           $(".catimagesProduct").attr('src',result.fileName)
                           $(".catimagesProduct").css('display','inline'); 
                        }else if(fieldID == 1){
                            $("#subcatimagesProductImg").val(result.fileName) 
                           $(".subcatimagesProductImg").attr('src',result.fileName)
                           $(".subcatimagesProductImg").css('display','inline'); 
                        }else if(fieldID == 2){
                            $("#subsubcatimagesProductImg").val(result.fileName) 
                           $(".subsubcatimagesProductImg").attr('src',result.fileName)
                           $(".subsubcatimagesProductImg").css('display','inline'); 
                        }
                       
                        $(document).ajaxComplete(function () {
                            if(fieldID < 3)
                            $("#insert").prop("disabled",false)
                            else
                            $("#editbusiness").prop("disabled",false)
                            // $("#loadingimg").css("display","none");
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

// for category product

 
 function catproductFill() {
       console.log('catname');
      
        var pName=$('#catname_0').val();

        var countPname=pName.length;
        
        if(countPname>3){

                 $.ajax({
                    url: "<?php echo base_url('index.php?/Category') ?>/getProductsBySerach",
                    type: "POST",
                    dataType: 'JSON',
                    data: {serachData: pName},
                    success: function (response)
                    {
                        $('#catproductNameListDiv').show();
                         $('#catproductNameList').empty();
                        console.log('rel---',response)
                     
                        html = '';
                      

                          if (response.data.length !== 0)
                        {
                           
                            $.each(response.data, function (index, row) {
                                  html +='<p class="pData" id="'+ row._id.$oid+'" >'+row.name[0]+' </p>';
                                  $('#catproductNameList').show();
                            });
                           
                        }else{
                            $('#catproductNameList').hide();
                        }

                         $('#catproductNameList').append(html);


    $("#catproductNameList").on('click', '.pData' , function () {
        $('#catname_0').val($(this).text());
        var selectedId = $(this).attr('id');
        console.log('------',selectedId);
        $('#catproductNameList').empty();
        $('#catproductNameList').hide();

         $.ajax({


                    url:   '<?php echo base_url(); ?>index.php?/Category/getProductDataDetail/' + selectedId,
                    type: "GET",
                    data: '',                  
                    success: function (json,textStatus, xhr) {
                        console.log('valllllllll',json)
                    var dataList=JSON.parse(json);
                    var dList=dataList.data;

                     var dataList=JSON.parse(json);
                    var dList=dataList.data;
                    
                    $("#catDescription_0").val(dList.categoryDesc['en']);      
                    $("#catimagesProductImg").val(dList.imageUrl)                
                    $('.catimagesProduct').attr('src', dList.imageUrl);
                    $('.catimagesProduct').show();
                    $('#parentCatId').val(dList._id.$oid);

                    // dynamically fetch category

                    
                    }
                });
        });

                 }
                });

        }
     }


    //  subcategory dynamica changes

    function subcatproductFill() {
        
        console.log('subproduct list');
        var pName=$('#subcatname_0').val();
        console.log('name----',pName);
        var pCatId=glocatId;
       
       
       
        var countPname=pName.length;
        
        if(countPname>3){

                  $.ajax({
                    url: "<?php echo base_url('index.php?/SubCategory') ?>/getProductsBySerach",
                    type: "POST",
                    dataType: 'JSON',
                    data: {serachData: pName,pCatId:pCatId},
                    success: function (response)
                    {
                        $('#subproductNameListDiv').show();
                         $('#subproductNameList').empty();
                        console.log('rel---',response)
                     
                        html = '';
                      

                          if (response.data.length !== 0)
                        {
                           
                            $.each(response.data, function (index, row) {
                                  html +='<p class="pData" id="'+ row._id.$oid+'" >'+row.name[0]+' </p>';
                                  $('#subproductNameList').show();
                            });
                           
                        }else{
                            $('#subproductNameList').hide();
                        }

                         $('#subproductNameList').append(html);


    $("#subproductNameList").on('click', '.pData' , function () {
        $('#subcatname_0').val($(this).text());
        var selectedId = $(this).attr('id');
        console.log('------',selectedId);
        $('#subproductNameList').empty();
        $('#subproductNameList').hide();



             
             $.ajax({


                    url:   '<?php echo base_url(); ?>index.php?/SubCategory/getProductDataDetail/' + selectedId,
                    type: "GET",
                    data: '',                  
                    success: function (json,textStatus, xhr) {
                        
                    var dataList=JSON.parse(json);
                    var dList=dataList.data;

                     var dataList=JSON.parse(json);
                    var dList=dataList.data;
                    
                    $("#catDescription_0").val(dList.subCategoryDesc['en']);                   
                    $('.subcatimagesProductImg').attr('src', dList.imageUrl);
                    $('.subcatimagesProductImg').show();
                    $("#subcatimagesProductImg").val(dList.imageUrl)                                
                    $('#subcatparentCatId').val(dList._id.$oid);
               }
                });
        });

        
                            
                            }
                        });
                }

  
    }


    
    function subsubproductFill() {
        
      
       var pName=$('#subsubcatname_0').val();

       var pCatId=glocatId;
       var scatId=glosubcatId;

        var countPname=pName.length;
       
       if(countPname>3){

                   $.ajax({
                   url: "<?php echo base_url('index.php?/SubsubCategory') ?>/getProductsBySerach",
                   type: "POST",
                   dataType: 'JSON',
                   data: {serachData: pName,pCatId:pCatId,scatId:scatId},
                   success: function (response)
                   {
                       $('#subsubproductNameListDiv').show();
                        $('#subsubproductNameList').empty();
                       console.log('rel---',response)
                    
                       html = '';
                     

                         if (response.data.length !== 0)
                       {
                          
                           $.each(response.data, function (index, row) {
                                 html +='<p class="pData" id="'+ row._id.$oid+'" >'+row.name[0]+' </p>';
                                 $('#subsubproductNameList').show();
                           });
                          
                       }else{
                           $('#subsubproductNameList').hide();
                       }

                        $('#subsubproductNameList').append(html);


   $("#subsubproductNameList").on('click', '.pData' , function () {
       $('#subsubcatname_0').val($(this).text());
       var selectedId = $(this).attr('id');
       console.log('------',selectedId);
       $('#subsubproductNameList').empty();
       $('#subsubproductNameList').hide();



            
            $.ajax({


                   url:   '<?php echo base_url(); ?>index.php?/SubsubCategory/getProductDataDetail/' + selectedId,
                   type: "GET",
                   data: '',                  
                   success: function (json,textStatus, xhr) {
                       console.log('valllllllll',json)
                   var dataList=JSON.parse(json);
                   var dList=dataList.data;

                    var dataList=JSON.parse(json);
                   var dList=dataList.data;
                   
                  // $("#catDescription_0").val(dList.categoryDesc['en']);                   
                   $('.subsubimagesProductImg').attr('src', dList.imageUrl);
                   $('.subsubimagesProductImg').show();                  
                   $("#subsubimagesProductImg").val(dList.imageUrl);
                   $('#parentCatId').val(dList._id.$oid);
                       
                   }
       });
});


                     
                   }
               });
       }
     
       
   }

//    cool

    function productFill() {
        
        var pName=$('#name_0').val();
        var countPname=pName.length;
        $("#shortDescription").val('');
        $("#detailedDescription").val('');

        if(countPname==0){
          $(".imagesProductdis").css('display','none'); 
        }   
        
        if(countPname>3){
                    $('.loader').show();
                    $.ajax({
                            url: "<?php echo base_url('index.php?/AddNewProducts') ?>/getProductsBySerach",
                            type: "POST",
                            dataType: 'JSON',
                            data: {serachData: pName},
                            success: function (response)
                            {

                            //    $.each(dList.pName, function (index, row) {
                                //       console.log('val',row)
                                // });
                                $('#productNameListDiv').show();
                                $('#productNameList').empty();                              
                                html = '';                           
                                if (response.data.length !== 0)
                                    {                                
                                        $.each(response.data, function (index, row) {
                                            //html +='<option value="'+ row._id.$oid+'" >'+row.productName[0]+' </option>';
                                            html +='<p class="pData" id="'+ row._id.$oid+'" >'+row.productName[0]+' </p>';
                                            $('#productNameList').show();
                                        });
                                
                                   }else{
                                    $('#productNameList').hide();
                                   }
                                $('#productNameList').append(html);
                                $('.loader').hide();                                                        
                            }
                    });
            }
     
    }

    $(document).ready(function(){

        $("#productNameList").on('click', '.pData' , function () {                   
                $('#name_0').val($(this).text());
                var selectedId = $(this).attr('id');
                $('#productNameList').empty();
                $('#productNameList').hide();
                    $.ajax({
                        url:   '<?php echo base_url(); ?>index.php?/AddNewProducts/getProductDataDetail/' + selectedId,
                        type: "GET",
                        data: '',                  
                        success: function (json,textStatus, xhr) {
                                var dataList=JSON.parse(json);
                                var dList=dataList.data;
                                console.log('responsesss',dList)
                               // console.log('data--------',dataList)
                                $("#shortDescription_0").val(dList.sDescription.en);
                                $("#detailedDescription_0").val(dList.detailDescription.en);
                                $('#parentProductId').val(dList._id.$oid);   

                                 var langData = <?php echo json_encode($language); ?>;
                                 $.each(langData,function(i,lngrow){
                                    lngid= lngrow.lan_id;
                                    langCode=lngrow.langCode;
                                    $('#name_'+lngid).val(dList.pName[langCode])
                                    $("#shortDescription_"+lngid).val(dList.sDescription[langCode]);
                                    $("#detailedDescription_"+lngid).val(dList.detailDescription[langCode]);
                                });

                                 var breakfast=dList.consumptionTime.breakfast;
                                 var brunch=dList.consumptionTime.brunch;
                                 var lunch=dList.consumptionTime.lunch;
                                 var tea=dList.consumptionTime.tea;
                                 var dinner=dList.consumptionTime.dinner; 
                                 var latenightdinner=dList.consumptionTime.latenightdinner;  
                                                               
                                if(breakfast==true)
                                    $('$breakfast').pro('checked',true);
                                if(brunch==true)
                                    $('$brunch').pro('checked',true);
                                if(lunch==true)
                                    $('$lunch').pro('checked',true);
                                if(tea==true)
                                    $('$tea').pro('checked',true);
                                if(dinner==true)
                                    $('$dinner').pro('checked',true);
                                if(latenightdinner==true)
                                    $('$latenightdinner').pro('checked',true);

                               
                                $('.imageinit').remove();
                                $.each(dList.images, function (index, row) {
                                    var k = $('.imageTag').length;
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
                                            + '<img class="imagesProductdynamic" src="' + row.mobile + '" style="width: 35px;height:35px;" class="text_imagesVal style_prevu_kit">'
                                            + '</div>'
                                            + '<div class=""></div>'
                                            + '<button type="button" class="btn-default btRemove removeButton">'
                                            + '<span class="glyphicon glyphicon-remove"></span>'
                                            + '</button>'
                                            + '</div>';
                                    $('.imagesField').append(divElement);
                                    renameImageLabelsUnit();
               });
                                    
                                // for unit dynamicallyr 
                                    $('#customePriceMain').remove();
                                    $.each(dList.units,function(index,row){
                                            
                                    var z = $('.customPriceField').length;
                                    var y = z + 1;
                                    var divElement1 = '<div class="customPriceField row"><div class="form-group pos_relative2 customPriceField' + z + '">'
                                                + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' </label>'
                                                + '<div class="col-sm-2 pos_relative2">'
                                                + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                                                + '<input type="text" name="units[' + z + '][name][en]" value="' + row.name.en + '" class="form-control productTitle" id="title' + z + '"  placeholder="Enter Unit">'
                                                + '</div>'
                                                + ' <div class="col-sm-2 pos_relative2">'
                                                + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                                                + ' <input type="text" maxlength="8" name="units[' + z + '][price][en]" value="' + row.price.en + '" class="form-control productValue" id="value' + z + '" placeholder="Enter Unit Price" onkeypress="return isNumberKey(event)">'
                                                + ' </div>'
                                            
                                                + '<div class="col-sm-2 pos_relative2">'         
                                                + '<input type="hidden" name="units[' + z + '][unitId]" value="' + row.unitId + '">'        
                                                + ' <?php if($storeType != "1" || $storeType != 1){?>'                                  
                                                + '<input type="text" maxlength="8" name="units[' + z + '][quantity][en]" value="0" class="error-box-class  form-control productTitle" id="quantity0"  placeholder="Enter Stock"  onkeypress="return isNumberKey(event)">'                   
                                                + '<input type="hidden" name="units[' + z + '][availableQuantity]" value="0">'
                                                + '<?php } ?>'
                                                + '</div>'
                                            
                                                + '<div class="col-sm-3 form-group" id="text_unitLanguage" >'
                                                + '<input type="button" id="unitLanguage" value="Language" class="btn btn-default marginSet btn-primary unitLanguage" data-id="'+z+'" style="margin-right: -30px;border-radius: 18px;font-size: 10px;padding-left: 13px;padding-right: 9px;">'
                                                + '<?php
                                                    foreach ($language as $val) {
                                                        if ($val['Active'] == 1) {
                                                ?>'
                                                + '<input type="hidden" name="units[' + z + '][name][<?= $val['langCode']; ?>]" value="' + row.name.<?php echo $val['langCode']; ?> + '" class="error-box-class  form-control productTitle title<?= $val['langCode']; ?>"  placeholder="Enter Unit">'
                                                + '<input type="hidden" name="units[' + z + '][price][<?= $val['langCode']; ?>]" value="' + row.price.<?php echo $val['langCode']; ?> + '" class="error-box-class  form-control productValue value<?= $val['langCode']; ?>" placeholder="Enter the price"  onkeypress="return isNumberKey(event)">'
                                                + '<?php if($storeType == "1" || $storeType == 1){?>'
                                                + '<input type="hidden" maxlength="8" name="units[' + z + '][quantity][<?= $val['langCode']; ?>]" class="error-box-class  form-control productTitle quantity<?= $val['langCode']; ?>"  placeholder="Enter Stock"  onkeypress="return isNumberKey(event)">'
                                                + ' <?php } ?>
                                                        <?php } else { }
                                                        }                                                 
                                                    ?>'
                                                + '<?php if($storeType == "1" || $storeType == 1){?>'
                                                + '<button type="button" class="btn btn-default  marginSet btn-primary draggableModal" id="draggableModal'+ z +'"  dataValAddon="'+z+'" style="margin-left: 49px;border-radius: 18px;font-size: 10px;">Add-On</button>'
                                                + ' <?php } ?>'
                                              //  + '<input type="hidden" name="units[' + z + '][addOns]" id="addOnUnitDestination"  value=\''+addOnPushData+ '\'>'
                                                + '</div>'                   
                                                + '<div class=""></div>'
                                                + '<button type="button" value="' + y + '"class="btn-default btnRemove removeButton">'
                                                + '<span class="glyphicon glyphicon-remove"></span>'
                                                + '</button>'
                                                + '</div>'
                                                + '<div class="form-group pos_relative2 customPriceField1">'
                                                + '<label  class="col-sm-2 control-label"></label>'	              
                                                +' <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div> </div>'                   
                                                + '<div class="selectedsizeAttr row"></div></div>'                                                              

                                          $('.customField').append(divElement1);                                      
                                    })                              
                            }
                        });
            });
    });

   

</script>

<div class="page-content-wrapper">
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb" style="margin-left: 0px; margin-top: 5%;">
        <li><a href="<?php echo base_url(); ?>index.php?/AddNewProducts/StoreProducts" class=""><?php echo $this->lang->line('LIST_PRODUCTS'); ?></a></li>
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
                                <span><?php echo $this->lang->line('LIST_PRODUCT_GENERALDETAILS'); ?></span></a>
                        </li>
                        <li>
                            <a class=""data-toggle="tab" role="tab" href="#tab2" >
                                <span><?php echo $this->lang->line('UNITS'); ?></span></a>
                        </li>
						<?php if($storeType == 4 || $storeType == "4"){?>
                        <li>
                            <a class="" data-toggle="tab" role="tab" href="#tab3" >
                                <span><?php echo $this->lang->line('LIST_STRAIN_ATTRIBUTES_AND_FLAVOURS'); ?></span></a>
                        </li>
						<?php } ?>
                        <li>
                            <a class="" data-toggle="tab" role="tab" href="#tab4" >
                                <span><?php echo $this->lang->line('LIST_PRODUCT_IMAGES'); ?></span></a>
                        </li>
						<?php if($storeType == 1 || $storeType == "1" || $storeType == 2 || $storeType == "2"){?>
                        <li style="display:none">
                            <a class="" data-toggle="tab" role="tab" href="#tab5" >
                                <span><?php echo $this->lang->line('ADDITIONAL_DETAILS'); ?></span></a>
                        </li>
						<?php } ?>

                    </ul>
                   </div> 
                    <div class="row"><br></div>

                    <!-- Tab panes -->
                    <form id="addentity" class="form-horizontal" role="form"
                          action="<?php echo base_url(); ?>index.php?/AddNewProducts/AddNewProductData"
                          method="post" enctype="multipart/form-data" onsubmit="return redirectToDest()">

                        <div class="tab-content">
                            <section class="" id="tab1">
                                <div class="row row-same-height">
                                    <input type="hidden" id="parentProductId" name="parentProductId">
                                <?php if($storeType == "6" || $storeType == 6){?>
                                     <!-- pharmacy -->
                                        <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Rx_Mandatory'); ?></label>
                                                <div class="col-sm-2 pos_relative2">
                                                    <label for="rxname" class="col-sm-1 control-label"><?php echo "Yes"; ?></label>
                                                    <input type="radio" id="rx1" name="rx" value="1"
                                                        style="margin-left: 15px;margin-top: 10px;" class="col-sm-1 rx error-box-class" >
                                                </div>										
                                                <div class="col-sm-2 pos_relative2">
                                                    <label for="rxname" class="col-sm-1 control-label"><?php echo "No"; ?></label>
                                                    <input type="radio" checked="checked" id="rx1" name="rx" value="0"
                                                        style="margin-left: 5px;margin-top: 10px;" class="col-sm-2 rx error-box-class "> 
                                                </div>                                                                             
                                        </div>

                                        <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Sold_Online'); ?></label>
                                                <div class="col-sm-2 pos_relative2">
                                                    <label for="soldOnline" class="col-sm-1 control-label"><?php echo "Yes"; ?></label>
                                                    <input type="radio" checked="checked" id="soldOnline" name="soldOnline" value="1"
                                                        style="margin-left: 15px;margin-top: 10px;" class="col-sm-1 rx error-box-class" >
                                                </div>										
                                                <div class="col-sm-2 pos_relative2">
                                                    <label for="soldOnline" class="col-sm-1 control-label"><?php echo "No"; ?></label>
                                                    <input type="radio"  id="soldOnline" name="soldOnline" value="0"
                                                        style="margin-left: 5px;margin-top: 10px;" class="col-sm-2 rx error-box-class "> 
                                                </div>
                                        </div>

                                        <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Prescription_Required'); ?></label>
                                                <div class="col-sm-2 pos_relative2">
                                                    <label for="soldOnline" class="col-sm-1 control-label"><?php echo "Yes"; ?></label>
                                                    <input type="radio" checked="checked" id="prescriptionRequired1" name="prescriptionRequired" value="1"
                                                        style="margin-left: 15px;margin-top: 10px;" class="col-sm-1 rx error-box-class" >
                                                </div>
                                                
                                                <div class="col-sm-2 pos_relative2">
                                                    <label for="soldOnline" class="col-sm-1 control-label"><?php echo "No"; ?></label>
                                                    <input type="radio"  id="prescriptionRequired2" name="prescriptionRequired" value="0"
                                                        style="margin-left: 6px;margin-top: 10px;" class="col-sm-2 rx error-box-class "> 
                                                </div>
                                        </div>

                                        <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Product_Type'); ?></label>
                                                <div class="col-sm-2 pos_relative2">
                                                    <label for="soldOnline" class="col-sm-1 control-label"><?php echo $this->lang->line('Generic'); ?></label>
                                                    <input type="radio" checked="checked" id="productType1" name="productType" value=1
                                                        style="margin-left: 33px;margin-top: 10px;" class="col-sm-1 rx error-box-class" >
                                                </div>										
                                                <div class="col-sm-2 pos_relative2">
                                                    <label for="soldOnline" class="col-sm-1 control-label"><?php echo $this->lang->line('Branded'); ?></label>
                                                    <input type="radio"  id="productType2" name="productType" value=2
                                                        style="margin-left: 33px;margin-top: 10px;" class="col-sm-2 rx error-box-class "> 
                                                </div>                                       
                                        </div>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('Serial_Number'); ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <input type="text" id="serialNumber" name="serialNumber"
                                                 class="error-box-class  form-control">
                                        </div>                                      
                                    </div>

                                <?php } ?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label error-box-class "><?php echo $this->lang->line('label_Name'); ?> <span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" autocomplete="off" id="name_0" name="productName[0]" onfocusout="defaultUnit()" onkeyup="productFill()"
                                                   required="required" class="error-box-class  form-control">
                                            <div class="loader" style="display:none"></div>

                                           

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                    </div>
                                    <!-- drop down -->

                                     <div class="form-group pos_relative2 productNameListDiv"  >
                                        <label for="fname" class="col-sm-2 control-label error-box-class "> </label>
                                        <div class="col-sm-6 pos_relative2">

                                             <div id="productNameList" class="productDropdown" style="display:none"></div>
                                                                                          
                                           

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                    </div>

                                    

                                 
                                    
                                    <?php
                                    $count = 1;
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2">
                                                <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="productName[<?= $count ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box" id="text_name"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)<span style="" class="MandatoryMarker"> *</span></label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="productName[<?= $count ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box" id="text_name"></div>
                                            </div>
                                            <?php
                                        }
                                        $count++;
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
															
																echo "<option  value=" . $result['categoryId'] . "  data-name='" . $result['name']['en'] . "'>" . $result['name']['en'] . "</option>";
															
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
                                                         
															 echo "<option  value=" . $result['categoryId'] . "  data-name='" .  $catData . "'>" . $catData . "</option>";	
															
                                                        }
                                                    }
												
                                               
                                                ?>

                                               <?php
                                                //foreach ($category as $result) {
                                                   // echo "<option data-name='" . implode(';', $result['name']) . "' data-id=" . $result['categoryId'] . " value=" . $result['categoryId'] . ">" . implode(',', $result['name']) . "</option>";
                                                //}
                                                ?> 

                                            </select> 
                                           

                                        </div>
                                        <div class="col-sm-2  cls110"> 
                                                 <button type="button" class="btn btn-success pull-right m-t-10" id="btnStickUpSizeToggler" style="font-size: 10px;"><?php echo $this->lang->line('Add_Category'); ?></button>
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
                                        <div class="col-sm-2  cls110"> 
                                                 <button type="button" class="btn btn-success pull-right m-t-10" id="subbtnStickUpSizeToggler" style="font-size: 10px;display:none"><?php echo $this->lang->line('Add_Sub_Category'); ?></button>
                                             </div>       
                                        <div class="col-sm-3 error-box" id="text_subCategory"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SubSubCategory'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="subSubCategory" name="thirdCategoryId"  class="form-control error-box-class">
                                                <option data-name="" value=""><?php echo $this->lang->line('label_SelectSubSubCategory'); ?></option>

                                            </select>  
                                            <input type="hidden" name="firstCategoryName" id="firstCategoryName" value="" />
                                            <input type="hidden" name="secondCategoryName" id="secondCategoryName" value="" />
                                            <input type="hidden" name="thirdCategoryName" id="thirdCategoryName" value="" />
                                        </div>
                                        <div class="col-sm-2  cls110"> 
                                                 <button type="button" class="btn btn-success pull-right m-t-10" id="subsubbtnStickUpSizeToggler" style="font-size: 10px;display:none"><?php echo $this->lang->line('Add_Sub_sub_Category'); ?></button>
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

                                            <input type="text" id="shortDescription_0" name="shortDescription[0]"
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

                                                    <input type="text" id="shortDescription_<?= $val['lan_id'] ?>" name="shortDescription[<?= $val['lan_id']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_shortDescription"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_SDescription'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="shortDescription_<?= $val['lan_id'] ?>" name="shortDescription[<?= $val['lan_id']; ?>]"
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

                                            <textarea id="detailedDescription_0" name="detailedDescription[0]"
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

                                                    <textarea id="detailedDescription_<?= $val['lan_id'] ?>" name="detailedDescription[<?= $val['lan_id']; ?>]"
                                                              required="required" class="error-box-class  form-control" style=" max-width: 100%;"></textarea>

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_DDescription'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <textarea id="detailedDescription_<?= $val['lan_id'] ?>" name="detailedDescription[<?= $val['lan_id']; ?>]"
                                                              required="required" class="error-box-class  form-control" style=" max-width: 100%;"></textarea>

                                                </div>
                                                <div class="col-sm-3 error-box redClass" id="text_detailedDescription"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                   <!-- store filter strt -->
                                   <?php if($storeType != "1" || $storeType != 1){?>

                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Manufacturer'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="manufacturer" name="manufacturer"  class="form-control error-box-class">
                                                <option data-name="Select Manufacturer" value=""><?php echo $this->lang->line('label_SelectManufacturer'); ?></option>

                                                <?php
                                                foreach ($manufacturer as $result) {
                                                    echo "<option data-name='" . $result['name']['en'] . "' data-id=" . $result['_id']['$oid'] . " value=" . $result['_id']['$oid'] . ">" . $result['name']['en'] . "</option>";
                                                }
                                                ?>

                                            </select> 
    

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_Manufacturer"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Brands'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="brand" name="brand" class="form-control error-box-class" >
                                                <option data-name="Select Brand" value=""><?php echo $this->lang->line('label_SelectBrands'); ?></option>

                                                <?php
                                                foreach ($brands as $brand) {
                                                    echo "<option data-name='" . $brand['name']['en'] . "' data-id=" . $brand['_id']['$oid'] . " value=" . $brand['_id']['$oid'] . ">" . $brand['name']['en'] . "</option>";
                                                }
                                                ?>

                                            </select> 


                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_brands"></div>
                                    </div>

                                    <?php } ?>
                                   <!-- store type end -->
									<?php if($storeType == "3" || $storeType == 3){?>
                                    <div class="form-group required">
                                        <label class="col-sm-2 control-label"><?php echo $this->lang->line('label_Size'); ?></label>
                                        <div class="col-sm-6">
                                            <!--onclick="showCheckboxesSize()"--> 
                                            <div class="multiselect sizeMultiSelect">
                                                <div class="selectBox" style="width: 102%;">
                                                    <select class="multiple form-control" id="sizeGroup" name="size[]" multiple="multiple" >
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
                                                        // foreach ($size as $sizes) {
                                                        //     echo "<option data-name='" . implode(',', $sizes['sizeName']) . "' data-id=" . $sizes['_id']['$oid'] . " value=" . $sizes['_id']['$oid'] . ">" . implode(',', $sizes['sizeName']) . "</option>";
                                                        // }
                                                        ?>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>

                                            </div>
                                            <label id="size-error" class="error" style="display:none"><?php echo $this->lang->line('Required_field'); ?></label>
                                        </div>
                                        <div class="col-sm-3 error-box" id="sizeErr"></div>

                                    </div>
									<?php } ?>

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
                                                                                                    ?><option data-name="<?php echo $siz['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + $(this).val() + '" ><?php echo $siz['sAttrLng']['en']; ?></option>\n\
                                                                                                    <?php } ?></select></div></div>');

                                                                } else {
                                                                     <?php foreach ($sizes['sizeAttr'] as $siz) { ?>
                                                                        $('.sizeGroup').append('<option data-name="<?php echo $siz['en']; ?>" data-id=" <?php echo $siz['attrId']['$oid']; ?>" value="<?php echo $siz['attrId']['$oid']; ?>" class="opt_' + $(this).val() + '" ><?php echo $siz['sAttrLng']['en']; ?></option>');
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
                                        });
                                    </script>
									<?php if($storeType == 3 || $storeType == "3"){?>
                                    <div class="form-group required">
                                        <label class="col-sm-2 control-label"><?php echo $this->lang->line('label_Colors'); ?></label>
                                        <div class="col-sm-6">
                                            <div class="multiselect">
                                                <div class="selectBox"  style="width: 102%;">
                                                    <select class="multiple form-control" name="color[]" multiple="multiple">
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
                                                        // foreach ($color as $colors) {
                                                        //     echo "<option data-name='" . implode(',', $colors['name']) . "' data-id=" . $colors['_id']['$oid'] . " value=" . $colors['_id']['$oid'] . ">" . implode(',', $colors['name']) . "</option>";
                                                        // }
                                                        ?>
                                                    </select>
                                                    <div class="overSelect"></div>
                                                </div>

                                            </div>
                                            <label id="colors-error" class="error" style="display:none"><?php echo $this->lang->line('Required_field'); ?></label>
                                        </div>
                                        <div class="col-sm-3 error-box" id="colorsErr"></div>

                                    </div>
									<?php } ?>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Tax'); ?></label>
                                        <div class="col-sm-6 pos_relative2">
                                            <select id="tax" name="tax[]"  class="multiple form-control error-box-class" multiple="multiple">
                                                <?php
                                                // foreach ($taxData as $result) {
                                                //     echo "<option data-name='" . implode(',', $result['taxName']) . "' data-id=" . $result['_id']['$oid'] . " value=" . $result['_id']['$oid'] . ">" . implode(',', $result['taxName']['en']) . "</option>";
                                                // }

                                                if(count($language) < 1){
                                                    foreach ($taxData as $result) {
                                                        
                                                            echo "<option  value='" . $result['Id'] . "'  data-name='" . $result['name']['en'] . "'>" . $result['name']['en'] . "</option>";
                                                        
                                                    }
                                                }
                                                else{
                                                    
                                                    foreach ($taxData as $result) {
                                                        $catData=$result['name']['en'];
                                                        foreach($language as $lngData){
                                                        $lngcode=$lngData['langCode'];
                                                        $lngvalue= ($result['name'][$lngcode]=='') ? "":$result['name'][$lngcode];
                                                        if(strlen( $lngvalue)>0){
                                                            $catData.= ',' . $lngvalue;
                                                        }
                                                    } 
                                                    
                                                        echo "<option  value='" .$result['Id'] . "'  data-name='" .  $catData . "'>" . $catData . "</option>";	
                                                        
                                                    }
                                                }
                                                ?>

                                            </select> 

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_tax"></div>
                                    </div>
                                    
                                    <div class="form-group pos_relative2" style="display:none">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_HSNCode'); ?> </label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="hsnCode" name="hsnCode[en]"
                                                   required="required" class="error-box-class  form-control">

                                        </div>

                                    </div>
                                    <?php
                                    foreach ($language as $val) {
                                        if ($val['Active'] == 1) {
                                            ?>
                                            <div class="form-group pos_relative2" style="display:none">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_HSNCode'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="hsnCode_<?php echo $val['langCode']; ?>" name="hsnCode[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_HSNCode'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="hsnCode_<?php echo $val['langCode']; ?>"  name="hsnCode[<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">

                                                </div>

                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    
                                    <div class="selectTax hidden ">

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
                                                                        <option value='0' >Inclusive (Tax Included in Product price)</option>\n\
                                                                        <option value='1' >Exclusive (Tax to be added to Product price) </option>\n\
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
                                    <!--//-->

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
									<input type="hidden" id="THC" name="THC" value="0"/>
									<input type="hidden" id="CBD" name="CBD" value="0"/>
                                   <!-- <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_THC'); ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class  form-control" id="THC" name="THC" onkeypress="return isNumberKey(event)">
                                        </div>

                                        <div class="col-sm-3 error-box redClass" id="text_THC"></div>
                                    </div>
                                    <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_CBD'); ?><span style="" class="MandatoryMarker"> *</span></label>

                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b>%</b></span>
                                            <input type="text" class="error-box-class  form-control" id="CBD" name="CBD" onkeypress="return isNumberKey(event)" >
                                        </div>

                                        <div class="col-sm-3 error-box redClass" id="text_CBD"></div>
                                    </div>-->
                           <?php if($storeType == "1" || $storeType == 1){?>
                                <!-- changes required -->
                                    <div class="form-group required" style="display:none">
                                <label class="col-sm-2 control-label"><?php echo $this->lang->line('Add_On'); ?></label>
                                <div class="col-sm-6">
                                    <div class="multiselect">
                                        <div class="selectBox"  style="width: 102%;">
                                            <select class="addOn multiple form-control addons" name="addOnIds[]" id="addOnIds" multiple="multiple">
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
                                                
                                           
                                                ?>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>

                                    </div>
                                    <label id="colors-error" class="error" style="display:none"><?php echo $this->lang->line('Required_field'); ?></label>
                                </div>
                                <div class="col-sm-3 error-box" id="colorsErr"></div>

                            </div> 

                            
                             <!-- <div class="form-group pos_relative2">
                                        <label for="fname" class="col-sm-2 control-label error-box-class "><?php echo "Cost For Two"; ?> <span style="" class="MandatoryMarker"> </span></label>
                                        <div class="col-sm-6 pos_relative2">
                                            
                                        <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>
                                            <input type="text" id="costForTwo" name="costForTwo"  onkeypress="return isNumberKey(event)" required="required" class="error-box-class  form-control">

                                        </div>
                                        <div class="col-sm-3 error-box redClass" id="text_name"></div>
                              </div> -->


                        <?php } ?>   

                        

                            <?php if($storeType == "6" || $storeType == 6){?>
                                   <!--Pharmacy  -->
                                   <div class="form-group required" >
                                <label class="col-sm-2 control-label"><?php echo $this->lang->line('Symptoms'); ?></label>
                                <div class="col-sm-6">
                                    <div class="multiselect">
                                        <div class="selectBox"  style="width: 102%;">
                                            <select class="addOn multiple form-control addons" name="symptoms[]" id="symptoms" multiple="multiple">
                                                <?php
                                                
                                                if(count($language) < 1){
                                                foreach ($symptoms as $result) {
                                                    
                                                        echo "<option  value=" . $result['_id']['$oid'] . "  data-name='" . $result['name']['en'] . "'>" . $result['name']['en'] . "</option>";
                                                    
                                                }
                                            }
                                            else{
                                                
                                                foreach ($symptoms as $result) {
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
                                                
                                           
                                                ?>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>

                                    </div>
                                    <label id="colors-error" class="error" style="display:none"><?php echo $this->lang->line('Required_field'); ?></label>
                                </div>
                                <div class="col-sm-3 error-box" id="colorsErr"></div>

                            </div> 


                             <div class="form-group required" >
                                <label class="col-sm-2 control-label"><?php echo $this->lang->line('Selective_Generic'); ?></label>
                                <div class="col-sm-6">
                                    <div class="multiselect">
                                        <div class="selectBox"  style="width: 102%;">
                                            <select class="addOn multiple form-control addons" name="selectiveGeneric[]" id="selectiveGeneric" multiple="multiple">
                                                <?php
                                                
                                                if(count($language) < 1){
                                                foreach ($generic as $result) {
                                                    
                                                        echo "<option  value=" . $result['_id']['$oid'] . "  data-name='" . $result['productname']['en'] . "'>" . $result['productname']['en'] . "</option>";
                                                    
                                                }
                                            }
                                            else{
                                                
                                                foreach ($generic as $result) {
                                                    $catData=$result['productname']['en'];
                                                    foreach($language as $lngData){
                                                    $lngcode=$lngData['langCode'];
                                                    $lngvalue= ($result['productname'][$lngcode]=='') ? "":$result['productname'][$lngcode];
                                                    if(strlen( $lngvalue)>0){
                                                        $catData.= ',' . $lngvalue;
                                                    }
                                                } 
                                                
                                                    echo "<option  value=" .$result['_id']['$oid'] . "  data-name='" .  $catData . "'>" . $catData . "</option>";	
                                                    
                                                }
                                            }
                                                
                                           
                                                ?>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>

                                    </div>
                                    <label id="colors-error" class="error" style="display:none"><?php echo $this->lang->line('Required_field'); ?></label>
                                </div>
                                <div class="col-sm-3 error-box" id="colorsErr"></div>

                            </div> 

                        <div class="form-group required" >
                                <label class="col-sm-2 control-label"><?php echo $this->lang->line('Selective_Branded'); ?></label>
                                <div class="col-sm-6">
                                    <div class="multiselect">
                                        <div class="selectBox"  style="width: 102%;">
                                            <select class="addOn multiple form-control addons" name="selectiveBranded[]" id="selectiveBranded" multiple="multiple">
                                                <?php
                                                
                                                if(count($language) < 1){
                                                foreach ($branded as $result) {
                                                    
                                                        echo "<option  value=" . $result['_id']['$oid'] . "  data-name='" . $result['productname']['en'] . "'>" . $result['productname']['en'] . "</option>";
                                                    
                                                }
                                            }
                                            else{
                                                
                                                foreach ($branded as $result) {
                                                    $catData=$result['productname']['en'];
                                                    foreach($language as $lngData){
                                                    $lngcode=$lngData['langCode'];
                                                    $lngvalue= ($result['productname'][$lngcode]=='') ? "":$result['productname'][$lngcode];
                                                    if(strlen( $lngvalue)>0){
                                                        $catData.= ',' . $lngvalue;
                                                    }
                                                } 
                                                
                                                    echo "<option  value=" .$result['_id']['$oid'] . "  data-name='" .  $catData . "'>" . $catData . "</option>";	
                                                    
                                                }
                                            }
                                                
                                           
                                                ?>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>

                                    </div>
                                    <label id="colors-error" class="error" style="display:none"><?php echo $this->lang->line('Required_field'); ?></label>
                                </div>
                                <div class="col-sm-3 error-box" id="colorsErr"></div>

                            </div>
                            <?php } ?>

                                </div>

                            <?php if($storeType == "1" || $storeType == 1){?>
                                <hr>
                                 <h6 class="textAlign" >RECOMMEND FOR CONSUMPTION</h6>
                                 <hr>

                                    <div class="form-group" >
                                    <label class="checkbox-inline">
                                    <input type="checkbox" id="breakfast"  class="consumptionTime" value="breakfast" name ="consumptionTime[]"><span style="font-weight: 700;">Breakfast </span></label>
                                   
                                    <label class="checkbox-inline">
                                    <input type="checkbox" id="brunch" class="consumptionTime" value="brunch" name ="consumptionTime[]"><span style="font-weight: 700;">Brunch </span></label>
                                   
                                    <label class="checkbox-inline">
                                    <input type="checkbox" id="lunch" class="consumptionTime" value="lunch" name ="consumptionTime[]"><span style="font-weight: 700;">Lunch</span></label>
                                    <label class="checkbox-inline">
                                    <input type="checkbox" id="tea"  class="consumptionTime" value="tea" name ="consumptionTime[]"><span style="font-weight: 700;">Tea And Snack</span></label>
                                    <label class="checkbox-inline">
                                    <input type="checkbox" id="dinner"  class="consumptionTime" value="dinner" name ="consumptionTime[]"><span style="font-weight: 700;">Dinner</span></label>
                                    <label class="checkbox-inline">
                                    <input type="checkbox" id="latenightdinner"  class="consumptionTime" value="latenightdinner" name ="consumptionTime[]"><span style="font-weight: 700;">Late Night Dinner</span></label>
                                  
                                    </div>
                            <?php } ?>

                            </section>
                            <section class="" id="tab2">
                                <div class="row row-same-height">
                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('UNITS'); ?></label>

                                    </div>
                                    <hr/>
                                    
                                    <div id="main" class="row">
                                        <button type="button" id="custom" value="Add"  class="btn btn-default marginSet btn-primary" style="margin-left: 116px;">
                                            <span >Add Unit</span>
                                        </button>
                                    </div>

                                    <div class="customField  row">
                                        <div class="customPriceField row" id="customePriceMain">

                                            <div class="form-group pos_relative2 customPriceField1">
                                                <label id="titleLabel" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Units'); ?> 1<span style="" class="MandatoryMarker"> *</span></label>
                                                <div class="col-sm-2 pos_relative2">
                                                    <span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>
                                                    <input type="text" name="units[0][name][en]" class="error-box-class  form-control productTitle" id="title0"  placeholder="Enter Unit ">
                                                </div>
                                                <div class="col-sm-2 pos_relative2">
                                                    <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>
                                                    <input type="text" maxlength="8" name="units[0][price][en]" class="error-box-class  form-control productValue" id="value0" placeholder="Enter the Price "  onkeypress="return isNumberKey(event)">
                                                </div>

                                                <?php if($storeType != "1" || $storeType != 1){?>
                                                <div class="col-sm-2 pos_relative2">                                                   
                                                    <input type="text" name="units[0][quantity][en]" maxlength="8" class="error-box-class  form-control productTitle" id="quantity0"  placeholder="Enter Stock"  onkeypress="return isNumberKey(event)">
                                                </div>   
                                                 <?php } ?>
                                               
                                                <!-- language button -->
                                                <div class="col-sm-3 form-group" id="text_unitLanguage" >
                                                    <input type="button" value="Language" class="btn btn-default marginSet btn-primary unitLanguage" style="margin-right: -30px;border-radius: 18px;font-size: 10px;padding-left: 13px;padding-right: 9px;">
                                                    <?php
                                                        foreach ($language as $val) {
                                                            if ($val['Active'] == 1) {
                                                    ?>
                                                        <input type="hidden" name="units[0][name][<?= $val['langCode']; ?>]" class="error-box-class form-control productTitle title<?= $val['langCode']; ?>" placeholder="Enter Unit">
                                                        <input type="hidden" name="units[0][price][<?= $val['langCode']; ?>]" class="error-box-class form-control productValue value<?= $val['langCode']; ?>" placeholder="Enter the price"  onkeypress="return isNumberKey(event)">

                                                        <?php if($storeType == "1" || $storeType == 1){?>
                                                            <input type="hidden" maxlength="8" name="units[0][quantity][<?= $val['langCode']; ?>]" class="error-box-class  form-control productTitle quantity<?= $val['langCode']; ?>" placeholder="Enter Quantity"  onkeypress="return isNumberKey(event)">
                                                        <?php } ?>
                                                    <?php } else { }
                                                        }
                                                    ?>

                                                <?php if($storeType == "1" || $storeType == 1){?>
                                                    <button type="button" class="btn btn-default  marginSet btn-primary draggableModal" id="draggableModal"  dataValAddon="1" style="margin-left: 49px;border-radius: 18px;font-size: 10px;"  >
                                                        Add-On
                                                    </button>
                                                <?php } ?>
                                                    <input type="hidden" name="units[0][addOns]" id="addOnUnitDestination" value='[]'> 

                                                </div> 
                                                
                                                <!--Add-on button -->

                                                <!-- <div class="col-sm-1 form-group" id="text_unitLanguage" >
                                                    <button type="button" class="btn btn-default  marginSet btn-primary draggableModal" id="draggableModal"  style="margin-right: -30px;border-radius: 18px;font-size: 10px;"  >
                                                        Add-On
                                                    </button>
                                                    <input type="hidden" name="units[0][addOns]" id="addOnUnitDestination" value='[]'> 
                                                </div>  -->
                                             
                                                
                                                <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div>
                                            </div>

                                                    
                                            
                                            <!-- quantity -->
                                             <!-- <div class="form-group pos_relative2 customPriceField1">
                                                <label  class="col-sm-2 control-label"></label>                                          
                                            <?php if($storeType == "1" || $storeType == 1){?>
                                                <div class="col-sm-3 pos_relative2">                                                   
                                                    <input type="text" name="units[0][quantity][en]" class="error-box-class  form-control productTitle" id="quantity0"  placeholder="Enter Quantity"  onkeypress="return isNumberKey(event)">
                                                </div>   
                                            <?php } ?>
                                             
                                                 <div class="col-sm-3 pos_relative2">
                                                    <button type="button" class="btn btn-primary draggableModal" id="draggableModal"   >
                                                        Add-On
                                                    </button>
                                                </div>                
                                                 <input type="hidden" name="units[0][addOns]" id="addOnUnitDestination" value='[]'>                                        

                                                <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div>
                                            </div> -->

                                        <!-- 
                                            <?php
                                            foreach ($language as $val) {
                                                if ($val['Active'] == 1) {
                                                    ?>
                                                    <div class="form-group pos_relative2  customPriceField1">
                                                        <label id="titleLabel" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Units'); ?> 1(<?php echo $val['lan_name']; ?>)</label>
                                                        <div class="col-sm-3 pos_relative2">
                                                            <span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>
                                                            <input type="text" name="units[0][name][<?= $val['langCode']; ?>]" class="error-box-class  form-control productTitle" id="title0"  placeholder="Enter Unit">
                                                        </div>
                                                        <div class="col-sm-3 pos_relative2">
                                                            <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>
                                                            <input type="text" name="units[0][price][<?= $val['langCode']; ?>]" class="error-box-class  form-control productValue" id="value0" placeholder="Enter the price"  onkeypress="return isNumberKey(event)">
                                                        </div>

                                                        <div class="col-sm-2 error-box redClass" ></div>

                                                    </div>
                                                    
                                                  
                                                    <div class="form-group pos_relative2 customPriceField1">
                                                        <label  class="col-sm-2 control-label"></label>
                                                            <div class="col-sm-3 pos_relative2">                                                   
                                                                <input type="text"  name="units[0][quantity][<?= $val['langCode']; ?>]" class="error-box-class  form-control productTitle" id="quantity0"  placeholder="Enter Quantity"  onkeypress="return isNumberKey(event)">
                                                            </div>                                               
                                                        <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div>
                                                  </div>


                                                <?php } else { ?>
                                                    <div class="form-group pos_relative2  customPriceField1" style="display:none">
                                                        <label id="titleLabel" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Units'); ?> 1(<?php echo $val['lan_name']; ?>)</label>
                                                        <div class="col-sm-3 pos_relative2">
                                                            <span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>
                                                            <input type="text" name="units[0][name][<?= $val['langCode']; ?>]" class="error-box-class  form-control productTitle" id="title0"  placeholder="Enter Unit">
                                                        </div>
                                                        <div class="col-sm-3 pos_relative2">
                                                            <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>
                                                            <input type="text" name="units[0][price][<?= $val['langCode']; ?>]" class="error-box-class  form-control productValue" id="value0" placeholder="Enter the price"  onkeypress="return isNumberKey(event)">
                                                        </div>

                                                        <div class="col-sm-2 error-box redClass" ></div>

                                                    </div>
                                                    
                                                     
                                                    <div class="form-group pos_relative2 customPriceField1">
                                                        <label  class="col-sm-2 control-label"></label>
                                                            <div class="col-sm-3 pos_relative2">                                                   
                                                                <input type="text"  name="units[0][quantity][<?= $val['langCode']; ?>]" class="error-box-class  form-control productTitle" id="quantity0"  placeholder="Enter Quantity"  onkeypress="return isNumberKey(event)">
                                                            </div>                                               
                                                        <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div>
                                                  </div>
                                                    <?php
                                                }
                                            }
                                            ?> -->

                                            <div class="selectedsizeAttr row"></div>
                                        </div>
                                    </div>

                                </div>
                            </section>
							<?php if($storeType == 4 || $storeType == "4"){?>
                            <section class="" id="tab3">
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
                            </section>
							<?php } ?>
							
                             <section class="" id="tab4">
                                <div class="row row-same-height">
                                    <hr/>
                                    <div class="form-group">
                                        <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('LIST_PRODUCT_IMAGES'); ?></label>

                                    </div>
                                    <hr/>
                                    <div id="main" class="row">
                                        <button type="button" id="btAdd" class="btn btn-default marginSet btn-primary" style="margin-left: 116px;">
                                            <span ><?php echo $this->lang->line('Add_Images'); ?></span>
                                        </button>
                                    </div>

                                    <div class="imagesField row " >
                                        <div class="form-group pos_relative2 imageinit" >
                                            <label id="td1" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Image'); ?> 1 </label>
                                            <div class="col-sm-6 pos_relative2">
                                                <input type="file" name="imageupload" class="error-box-class form-control imagesProduct" id="image1" attrId="0" value="">
                                                <div id="loadingimg" style="display:none; position:absolute; width:150px; height:75px;z-index:1000;top:-70%; left:44%" >
                                                    <img src="<?php echo base_url(); ?>theme/icon/loadingicon.gif" style="width:75px;height:75px;">
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <!-- <img src="" style="width: 35px; height: 35px; display: none;"
                                                    class="imagesProduct style_prevu_kit"> -->
                                            </div>
                                            <div class="col-sm-3 error-box" id="text_images1"></div>
                                            <input type="hidden" id="thumbnailImages0"  name="images[0][thumbnail]" value=""/>
                                            <input type="hidden" id="mobileImages0"  name="images[0][mobile]" value=""/>
                                            <input type="hidden" id="defaultImages0"  name="images[0][image]" value=""/>
                                        </div>
                                    </div>

                            <?php if($storeType == "6" || $storeType == 6){?>
                                    <!-- pharmacy -->
                                    <div class="imagesField row">
                                        <div class="form-group pos_relative2">
                                            <label id="td1" for="fname" class="col-sm-2 control-label"><?php echo "Professioal Usage File"; ?>  <span id="professionalUsageFile_span" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">
                                                <input type="file" name="professionalUsageFile" class="error-box-class form-control professionalUsageFile " id="professionalUsageFile" attrId="0" value="Text Element 1">
                                                <div id="loadingimg" style="display:none; position:absolute; width:150px; height:75px;z-index:1000;top:-70%; left:44%" >
                                                    <img src="<?php echo base_url(); ?>theme/icon/loadingicon.gif" style="width:75px;height:75px;">
                                                </div>
                                            </div>
                                            <div class="col-sm-1"><a href='' id="anchorimglink" target="_blank"><img id="imgsrclink" src='' widht="50" height="50"></a></div>
                                            <div class="col-sm-2 error-box" id="text_images1"></div>
                                            <input type="hidden" id="professionalUsageFilehidden"  name="professionalUsageFile"/>
                                          
                                        </div>
                                    </div>

                                    <div class="imagesField row">
                                        <div class="form-group pos_relative2">
                                            <label id="td1" for="fname" class="col-sm-2 control-label"><?php echo "Personal Usage File"; ?>  <span id="personalUsageFile_span" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6 pos_relative2">
                                                <input type="file" name="personalUsageFile" class="error-box-class form-control personalUsageFile" id="personalUsageFile" attrId="0" value="Text Element 1">
                                                <div id="loadingimg" style="display:none; position:absolute; width:150px; height:75px;z-index:1000;top:-70%; left:44%" >
                                                    <img src="<?php echo base_url(); ?>theme/icon/loadingicon.gif" style="width:75px;height:75px;">
                                                </div>
                                            </div>
                                            <div class="col-sm-1"><a href='' id="anchorimglink" target="_blank"><img id="imgsrclink" src='' widht="50" height="50"></a></div>
                                            <div class="col-sm-2 error-box" id="text_images1"></div>
                                            <input type="hidden" id="personalUsageFilehidden"  name="personalUsageFile"/>
                                          
                                        </div>
                                    </div>

                            <?php } ?>
                                </div>
                            </section> 
				<?php if($storeType == 1 || $storeType == "1" || $storeType == 2 || $storeType == "2"){?>
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

                                            <input type="text" id="ingredients_0" name="ingredients[en]" value="<?php echo $productsData['ingredients']['en']; ?>" required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="ingredients[keyName][en]" value="Ingredients" class="error-box-class  form-control">

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

                                            <input type="text" id="upc" name="upcName[en]"
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

                                            <input type="text" id="mpn" name="mpnName[en]"
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

                                            <input type="text" id="model" name="modelName[en]"
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
                                            <input type="hidden" id="" name="uomShelfLife[keyName][en]" value="Shelf life UOM" class="error-box-class  form-control">
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

                                            <input type="text" id="UOMstorageTemperature" name="UOMstorageTemperature[en]"
                                                   required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="UOMstorageTemperature[keyName][en]" value="Storage Temperature UOM" class="error-box-class  form-control">
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

                                            <input type="text" id="allergyInfo" name="allergyInfo[en]"
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

                                            <input type="text" id="servingPerCalories" name="nutritionFactsInfo[servingPerCalories][en]"
                                                   required="required" class="error-box-class  form-control">
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

                                            <input type="text" id="uomCholesterol" name="nutritionFactsInfo[uomCholesterol][en]"
                                                   required="required" class="error-box-class  form-control">
                                        <input type="hidden" id="" name="nutritionFactsInfo[uomCholesterol][keyName][en]" value="Cholesterol UOM" class="error-box-class  form-control">
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
                                                <input type="hidden" id="" name="nutritionFactsInfo[uomCholesterol][keyName][<?= $val['langCode']; ?>]" value="Cholesterol UOM" class="error-box-class  form-control">
                                                </div>

                                            </div>
                                        <?php } else { ?>
                                            <div class="form-group pos_relative2" style="display:none;">
                                                <label for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_CholesterolUOM'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                                <div class="col-sm-6 pos_relative2">

                                                    <input type="text" id="uomCholesterol_<?php echo $val['langCode']; ?>"  name="nutritionFactsInfo[uomCholesterol][<?= $val['langCode']; ?>]"
                                                           required="required" class="error-box-class  form-control">
                                            <input type="hidden" id="" name="nutritionFactsInfo[uomCholesterol][keyName][<?= $val['langCode']; ?>]" value="Cholesterol UOM" class="error-box-class  form-control">
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
                                            <input type="hidden" id="" name="nutritionFactsInfo[uomFibre][keyName][en]" value="Fibre UOM" class="error-box-class  form-control">
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
                                    <input type="hidden" id="" name="nutritionFactsInfo[uomSodium][keyName][en]" value="Sodium UOM" class="error-box-class  form-control">
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
                                        <input type="hidden" id="" name="nutritionFactsInfo[uomProtein][keyName][en]" value="Protein UOM" class="error-box-class  form-control">
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
                                        <input type="hidden" id="" name="nutritionFactsInfo[uomTotalFat][keyName][en]" value="Total-fat UOM" class="error-box-class  form-control">
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
                                            <input type="hidden" id="" name="nutritionFactsInfo[uomTransFat][keyName][en]" value="Trans-fat UOM" class="error-box-class  form-control">
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
				<?php } ?> 
                        

                                    <div class="divdynamicViewImage row">
                                        <div class="form-group pos_relative2">
                                           
                                            <div class="col-sm-2 ">

                                            </div>
                                            <div id="dynamicViewImage"class="col-sm-6 pos_relative2 dynamicViewImage ">
                                                
                                            </div>
                                            <div class="col-sm-1">
                                                  <button class="btn btn-success finishbutton pull-right" type="button" onclick="submitform()"><span><?php echo BUTTON_FINISH; ?></span></button>
                                            </div>
                                            <div class="col-sm-3 error-box" id="text_images1"></div>
                                          
                                        </div>
                                    </div>

                       
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
                var divElement = '<div class="form-group pos_relative2 imageTag" id="'+k+'">'
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
                $('#myModalmax').modal('show');
            }
        });

        
        $(document).on('click', '#custom', function () {
            var len = $('.customPriceField').length;
            var z = len + 1;
            var y = z + 1;
            var divElement1 = '<div class="customPriceField row"><div class="form-group pos_relative2 customPriceField' + z + '">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' </label>'
                    + '<div class="col-sm-2 pos_relative2">'
                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    + '<input type="text" name="units[' + len + '][name][en]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter Unit">'
                    + '</div>'
                    + ' <div class="col-sm-2 pos_relative2">'
                    + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                    + ' <input type="text" maxlength="8" name="units[' + len + '][price][en]" class="form-control productValue" id="value' + z + '" placeholder="Enter Unit Price" onkeypress="return isNumberKey(event)">'
                    + ' </div>'
                    + ' <?php if($storeType != "1" || $storeType != 1){?>'
                    + '<div class="col-sm-2 pos_relative2">'                                                   
		            + '<input type="text" maxlength="8" name="units[' + len + '][quantity][en]" class="error-box-class  form-control productTitle" id="quantity0"  placeholder="Enter Stock"  onkeypress="return isNumberKey(event)">'
	                + '</div>'
                    + '<?php } ?>'
                    + '<div class="col-sm-3 form-group" id="text_unitLanguage" >'
                    + '<input type="button" id="unitLanguage" value="Language" class="btn btn-default marginSet btn-primary unitLanguage" data-id="'+len+'" style="margin-right: -30px;border-radius: 18px;font-size: 10px;padding-left: 13px;padding-right: 9px;">'
                    + '<?php
                        foreach ($language as $val) {
                            if ($val['Active'] == 1) {
                    ?>'
                    + '<input type="hidden" name="units[' + len + '][name][<?= $val['langCode']; ?>]" class="error-box-class  form-control productTitle title<?= $val['langCode']; ?>"  placeholder="Enter Unit">'
                    + '<input type="hidden" name="units[' + len + '][price][<?= $val['langCode']; ?>]" class="error-box-class  form-control productValue value<?= $val['langCode']; ?>" placeholder="Enter the price"  onkeypress="return isNumberKey(event)">'
                    + '<?php if($storeType == "1" || $storeType == 1){?>'
                    + '<input type="hidden" maxlength="8" name="units[' + len + '][quantity][<?= $val['langCode']; ?>]" class="error-box-class  form-control productTitle quantity<?= $val['langCode']; ?>"  placeholder="Enter Stock"  onkeypress="return isNumberKey(event)">'
                    + ' <?php } ?>
                            <?php } else { }
                            }
                        ?>'
                    + '<?php if($storeType == "1" || $storeType == 1){?>'
                    + '<button type="button" class="btn btn-default  marginSet btn-primary draggableModal" id="draggableModal'+ len +'"   style="margin-left: 49px;border-radius: 18px;font-size: 10px;">Add-On</button>'
                    + ' <?php } ?>'
                    + '<input type="hidden" name="units[' + len + '][addOns]" id="addOnUnitDestination" value="[]">'
                    + '</div>' 
                    // + '<div class="col-sm-1 form-group" id="text_unitLanguage">'
                    // + '<button type="button" class="btn btn-default  marginSet btn-primary draggableModal" id="draggableModal'+ len +'"   style="margin-right: -30px;border-radius: 18px;font-size: 10px;">Add-On</button>'
                    // + '<input type="hidden" name="units[' + len + '][addOns]" id="addOnUnitDestination" value="[]">'
                    // + '</div>'
                    + '<div class=""></div>'
                    + '<button type="button" value="' + y + '"class="btn-default btnRemove removeButton">'
                    + '<span class="glyphicon glyphicon-remove"></span>'
                    + '</button>'
                    + '</div>'
                    + '<div class="form-group pos_relative2 customPriceField1">'
	                + '<label  class="col-sm-2 control-label"></label>'
	                // + '<div class="col-sm-3 pos_relative2">'                                                   
		            // + '<input type="text" name="units[' + len + '][quantity][en]" class="error-box-class  form-control productTitle" id="quantity0"  placeholder="Enter Quantity"  onkeypress="return isNumberKey(event)">'
	                // + '</div>'
                    // + '<div class="col-sm-3 pos_relative2"  >'
		            // +'<button type="button" class="btn btn-primary draggableModal" id="draggableModal'+ len +'"  >Add-On</button></div>'
	                // +'<input type="hidden" name="units[' + len + '][addOns]" id="addOnUnitDestination" value="[]">'
                    +' <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div> </div>'
                    // + '<?php
                    //                 foreach ($language as $val) {
                    //                     if ($val["Active"] == 1) {
                    //                         ?>'
                    //         + '<div class="form-group pos_relative2 customPriceField' + z + '">'
                    //         + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                    //         + '<div class="col-sm-3 pos_relative2">'
                    //         + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    //         + '<input type="text" name="units[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter Unit">'
                    //         + '</div>'
                    //         + ' <div class="col-sm-3 pos_relative2">'
                    //         + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                    //         + ' <input type="text" name="units[' + len + '][price][<?php echo $val['langCode']; ?>]" class="form-control productValue" id="value' + z + '" placeholder="Enter Unit Price" onkeypress="return isNumberKey(event)">'
                    //         + ' </div>'
                    //         + '<div class=""></div>'
                    //         + '</div>'
                    //         + '<div class="form-group pos_relative2 customPriceField1">'
                    //         + '<label  class="col-sm-2 control-label"></label>'
                    //         + '<div class="col-sm-3 pos_relative2">'                                                   
                    //         + '<input type="text" name="units[' + len + '][quantity][<?php echo $val['langCode']; ?>]" class="error-box-class  form-control productTitle" id="quantity0"  placeholder="Enter Quantity"  onkeypress="return isNumberKey(event)">'
                    //         + '</div> <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div> </div>'
                    //         + '<?php // } else { ?>'
                    //         + '<div class="form-group pos_relative2 customPriceField' + z + '" style="display:none">'
                    //         + '<label id="titleLabel' + z + '" for="fname" class="col-sm-2 control-label">Units ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                    //         + '<div class="col-sm-3 pos_relative2">'
                    //         + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    //         + '<input type="text" name="units[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter Unit">'
                    //         + '</div>'
                    //         + ' <div class="col-sm-3 pos_relative2">'
                    //         + ' <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>'
                    //         + ' <input type="text" name="units[' + len + '][price][<?php echo $val['langCode']; ?>]" class="form-control productValue" id="value' + z + '" placeholder="Enter Unit Price" onkeypress="return isNumberKey(event)">'
                    //         + ' </div>'
                    //         + '<div class=""></div>'
                    //         + '</div>'
                    //         + '<div class="form-group pos_relative2 customPriceField1">'
                    //         + '<label  class="col-sm-2 control-label"></label>'
                    //         + '<div class="col-sm-3 pos_relative2">'                                                   
                    //         + '<input type="text" name="units[' + len + '][quantity][<?php echo $val['langCode']; ?>]" class="error-box-class  form-control productTitle" id="quantity0"  placeholder="Enter Quantity"  onkeypress="return isNumberKey(event)">'
                    //         + '</div> <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div> </div>'
                    //         + '<?php
                    //                     }
                    //                 }
                    //                 ?>'
                            + '<div class="selectedsizeAttr row"></div></div>'
                            

            
            $('.customField').append(divElement1);
            var sizegroups = $('#sizeGroup option:selected');

                            if(sizegroups.length > 0){

                                                $(sizegroups).each(function (index, sizeAttr) {
                                                    var data = $(this).val();

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
         
            
            //console.log($(this).parent().attr('id'));
            var divImagedynamic=$(this).parent().attr('id');
          //  $('.imageremovedynamic').attr()

            $('.imageremovedynamic').filter('[data-id='+divImagedynamic+']').remove();
            $(this).parent().remove();
            renameImageLabels();
        });
        $('body').on('click', '.btnRemove', function () {
            $(this).parent().parent().remove();
            renameUnitsLabels();
        });


    });

</script>
<div id="myModalmax" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Alert'); ?></h4>
            </div>
            <div class="modal-body">
                <p class="modalPopUpText"><?php echo $this->lang->line('Reached_Maximum_Limit'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
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
                <h4 class="modal-title"><?php echo $this->lang->line('Alert'); ?></h4>
            </div>
            <div class="modal-body">
                <p class="modalPopUpText" style="color:#0090d9;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('OK'); ?></button>
            </div>
        </div>

    </div>
</div>


<!--category modal -->
<div class="modal fade stick-up" id="catmyModal" tabindex="-1" role="dialog" aria-hidden="true">

<div class="modal-dialog">
    <div class="modal-content">

        <div class="modal-body">
            <div class="modal-header">
                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title"><?php echo $this->lang->line('Add_Category'); ?></span>
            </div>
            <div class="modal-body">


                <div id="Category_txt" >
                    <div class="row">
                        <div class="form-group formex">
                            <div class="frmSearch">
                                <label for="fname" class="col-sm-4 control-label">Name(English) <span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-6">    
                                    <input type="text"   id="catname_0" name="catname[0]"  style="  width: 100%;line-height: 2;" class="catname form-control error-box-class" onkeyup="catproductFill()">
                                    
                                    <input type="hidden" id="parentCatId" name="parentCatId">
                                     
                                         <div id="catproductNameList" style="display:none"></div>
                                    
                                </div>

                            </div>
                        </div>
                    </div> 

                <!-- dynamic -->
                 <div class="form-group pos_relative2 catproductNameListDiv"  >
                                    <label for="fname" class="col-sm-2 control-label error-box-class "> </label>
                                    <div class="col-sm-6 pos_relative2">

                                         <!-- <div id="productNameList" style="display:none"></div> -->
                                                                                      
                                       

                                    </div>
                                    <div class="col-sm-3 error-box redClass" id="text_name"></div>
                                </div>

                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <br/>
                            <div class="row">
                                <div class="form-group formex">
                                    <div class="frmSearch">
                                        <label for="fname" class="col-sm-4 control-label">Name(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="catname_<?= $val['lan_id'] ?>" name="catname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="catname form-control error-box-class" >
                                        </div>

                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>
                            <div class="row">
                                <div class="form-group formex" style="display:none;">
                                    <div class="frmSearch">
                                        <label for="fname" class="col-sm-4 control-label">Name(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text"  id="catname_<?= $val['lan_id'] ?>" name="catname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="catname form-control error-box-class" >
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>

                <br/>
                <div class="categoryDescription">
                    <div class="row">
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label">Description(English) <span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="catDescription_0" name="catDescription[0]"  class="catDescription form-control error-box-class" style="max-width: 100%;"></textarea>
                                <input type="hidden" id="cat_photosamz" name="cat_photosamz" value=""/>
                            </div>
                        </div>
                    </div>

                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <br/>
                            <div class="row">
                                <div class="form-group formex">
                                    <div class="frmSearch">
                                        <label for="fname" class="col-sm-4 control-label">Description(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <textarea type="text"  id="catDescription_<?= $val['lan_id'] ?>" name="catDescription[<?= $val['lan_id'] ?>]" style="line-height: 2; max-width: 100%;" class="catDescription form-control error-box-class" ></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>
                            <div class="row">
                                <div class="form-group formex" style="display:none;">
                                    <div class="frmSearch">
                                        <label for="fname" class="col-sm-4 control-label">Description(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <textarea type="text"  id="catDescription_<?= $val['lan_id'] ?>" name="catDescription[<?= $val['lan_id'] ?>]" style="line-height: 2; max-width: 100%;" class="catDescription form-control error-box-class" ></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>

                </div>

                <br/>
                <div class="categoryImage">
                    <div class="row">
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('Image'); ?><span class="MandatoryMarker"> * (max size - 2 mb)</span>(Supported format PNG,JPEG,JPG)</label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control error-box-class catImage"  name="cat_photos" id="cat_photos"  placeholder=""></div>

                                <input type="hidden" id="catimagesProductImg" value="">

                                <img src="" style="width: 35px; height: 35px; display: none;" class="catimagesProduct style_prevu_kit">
                        </div>

                        
                    </div>
                </div>
                <br/>
                <div class="modal-footer">                            
                    <div class="col-sm-6 error-box" id="categoryError"></div>

                    <div class="col-sm-6" >
                        <button type="button" class="btn btn-primary pull-right" id="catinsert" ><?php echo $this->lang->line('Add'); ?></button>
                        <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('Cancel'); ?></button></div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                </div>  
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</div>
</div>

<!-- // sub cat moal -->
<div class="modal fade stick-up" id="subcatmyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="addcat"  role="form"  method="post" enctype="multipart/form-data">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>

                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"><?php echo $this->lang->line('Add_Sub_Category'); ?></span>
                </div>

                <div class="modal-body">

                    <div id="Category_txt" >
                        <div class="row">
                            <div class="form-group formex">
                                <div class="frmSearch">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label"> Name (English) <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">    <!--<div class="col-sm-6">-->  
                                        <input type="text"   id="subcatname_0" name="catname[0]" style="  width: 100%;line-height: 2;" class="subcatname form-control error-box-class" onkeyup="subcatproductFill()" >
                                        <div class="loader" style="display:none"></div>
                                        <input type="hidden" id="subcatparentCatId" name="parentCatId">
                                         
                                             <div id="subproductNameList" style="display:none"></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <?php
                        foreach ($language as $val) {
                            if ($val['Active'] == 1) {
                                ?>
                                <br/>
                                <div class="row">
                                    <div class="form-group formex">
                                        <div class="frmSearch">
                                            <div class="col-sm-1"></div>
                                            <label for="fname" class="col-sm-4 control-label"> Name(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="subcatname_<?= $val['lan_id'] ?>" name="catname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="subcatname form-control error-box-class" >
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <?php } else { ?>
                                <div class="row">
                                    <div class="form-group formex" style="display: none;">
                                        <div class="frmSearch">
                                            <div class="col-sm-1"></div>
                                            <label for="fname" class="col-sm-4 control-label"> Name(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="subcatname_<?= $val['lan_id'] ?>" name="catname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="subcatname form-control error-box-class" >
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>
                    <br/>
                    <div class="row">
                        <div class="form-group formex">
                            <div class="col-sm-1"></div>
                            <label for="fname" class="col-sm-4 control-label">Description <span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="catDescription_0" name="catDescription[0]"  class="catDescription form-control error-box-class" style="max-width: 100%;"></textarea>
                                <input type="hidden" id="cat_photosamz" name="cat_photosamz" value=""/>
                            </div>
                        </div>
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>

                            <div class="row">                    
                                <div class="form-group formex" class="formex">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label">Description (<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea type="text"  id="catDescription_<?= $val['lan_id'] ?>" name="catDescription[<?= $val['lan_id'] ?>]"  class="catDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>
                            <div class="row" style="display: none;">                    
                                <div class="form-group formex" class="formex">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label">Description (<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <textarea type="text"  id="catDescription_<?= $val['lan_id'] ?>" name="catDescription[<?= $val['lan_id'] ?>]"  class="catDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>

                    <br/>
                    <div class="row">
                        <div class="form-group formex">
                            <div class="col-sm-1"></div>
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('Image'); ?>
                            <span class="MandatoryMarker">
                            <?php 
                                if($storeType != 1 || $storeType != "1"){
                                    echo "*";
                                 }
                            ?>
                            (max size - 2 mb)</span>(Supported format PNG,JPEG,JPG)</label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control error-box-class subcatImage"  name="subcat_photos" id="subcat_photos" placeholder=""></div>

                                 <input type="hidden" id="subcatimagesProductImg" value="">

                             <img src="" style="width: 35px; height: 35px; display: none;" class="subcatimagesProductImg style_prevu_kit">
                        </div>
                        <br/>

                    </div>
                </div>

                <div class="modal-footer">                            
                    <div class="col-sm-4 error-box" id="categoryError"></div>
                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Cancel'); ?></button>
                        <button type="button" class="btn btn-primary pull-right" id="subcatinsert" ><?php echo $this->lang->line('Add'); ?></button>
                    </div>
                </div>                    
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>

<!-- // Sub sub category modal -->


<div class="modal fade stick-up" id="subsubcatmyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="addcat"  role="form"  method="post" enctype="multipart/form-data">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>

                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"><?php echo $this->lang->line('Add_Sub_sub_Category'); ?></span>
                </div>

                <div class="modal-body">

                    <div id="Category_txt" >
                        <div class="row">
                            <div class="form-group formex">
                                <div class="frmSearch">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label">Name(English) <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">   
                                        <input type="text"   id="subsubcatname_0" name="catname[0]" style="  width: 100%;line-height: 2;" class="subsubcatname form-control error-box-class" onkeyup="subsubproductFill()" >
                                        <div class="loader" style="display:none"></div>
                                        <input type="hidden" id="parentCatId" name="parentCatId">
                                         
                                             <div id="subsubproductNameList" style="display:none"></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <?php
                        foreach ($language as $val) {
                            if ($val['Active'] == 1) {
                                ?>
                                <div class="row">
                                    <div class="form-group formex">
                                        <div class="frmSearch">
                                            <div class="col-sm-1"></div>
                                            <label for="fname" class="col-sm-4 control-label">Name (<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="subsubcatname_<?= $val['lan_id'] ?>" name="catname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="subsubcatname form-control error-box-class" >
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <?php } else { ?>
                                <div class="row">
                                    <div class="form-group formex" style="display: none">
                                        <div class="frmSearch">
                                            <div class="col-sm-1"></div>
                                            <label for="fname" class="col-sm-4 control-label">Name (<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="subsubcatname_<?= $val['lan_id'] ?>" name="catname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="subsubcatname form-control error-box-class" >
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="form-group" class="formex">
                            <div class="col-sm-1"></div>
                            <label for="fname" class="col-sm-4 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="catDescription_0" name="catDescription[0]"  class="subsubcatDescription form-control error-box-class" style="max-width: 100%;"></textarea>
                                <input type="hidden" id="cat_photosamz" name="cat_photosamz" value=""/>
                            </div>
                        </div>
                    </div>

                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>

                            <div class="row">                    
                                <div class="form-group formex" class="formex">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label">Description (<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <textarea type="text"  id="catDescription_<?= $val['lan_id'] ?>" name="catDescription[<?= $val['lan_id'] ?>]"  class="subsubcatDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>
                            <div class="row" style="display: none;">                    
                                <div class="form-group formex" class="formex">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label">Description (<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <textarea type="text"  id="catDescription_<?= $val['lan_id'] ?>" name="catDescription[<?= $val['lan_id'] ?>]"  class="subsubcatDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>

                    <br/>
                    <div class="row">
                        <div class="form-group" class="formex">
                            <div class="col-sm-1"></div>
                            <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('Image'); ?>
                            <span class="MandatoryMarker">
                            <?php 
                                if($storeType != 1 || $storeType != "1"){
                                    echo "*";
                                 }
                            ?>
                            (max size - 2 mb)</span>(Supported format PNG,JPEG,JPG)</label></label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control error-box-class subsubcatImage"  name="cat_photos" id="subsubcat_photos" placeholder=""></div>

                                 <input type="hidden" id="subsubcatimagesProductImg" value="">

                            <img src="" style="width: 35px; height: 35px; display: none;" class="subsubcatimagesProductImg style_prevu_kit">
                               
                        </div>
                    </div>
                    <br/>

                </div>

                <div class="modal-footer">                            
                    <div class="col-sm-5 error-box" id="categoryError"></div>
                    <div class="col-sm-7" >
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Cancel'); ?></button>
                        <button type="button" class="btn btn-primary pull-right" id="subsubinsert" ><?php echo $this->lang->line('Add'); ?></button>
                    </div>
                </div>                    
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>

 <!--lang -->
    <div id="unitLanguagemodal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Unit</h4>
        </div>
        <div class="modal-body">
            <?php
                foreach ($language as $val) {
                    if ($val['Active'] == 1) {
                      
            ?>
                    <div class="form-group pos_relative2  customPriceField1">
                        <label id="titleLabel" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Units'); ?> 1(<?php echo $val['lan_name']; ?>)</label>
                        <div class="col-sm-6 pos_relative2">
                            <span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>
                            <input type="text" class="error-box-class  form-control productTitle" id="modaltitle<?= $val['langCode']; ?>"  placeholder="Enter Unit">
                        </div>
                        <div class="col-sm-4 pos_relative2">
                            <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>
                            <input type="text" maxlength="8" class="error-box-class  form-control productValue" id="modalvalue<?= $val['langCode']; ?>" placeholder="Enter the price"  onkeypress="return isNumberKey(event)">
                        </div>
                    </div>
                                                        
                                                    
                    <div class="form-group pos_relative2 customPriceField1">
                        <label  class="col-sm-2 control-label"></label>
                        <?php if($storeType != "1" || $storeType != 1){?>
                            <div class="col-sm-3 pos_relative2">                                                   
                                <input type="text" class="error-box-class  form-control productTitle" id="modalquantity<?= $val['langCode']; ?>"  placeholder="Enter Stock"  onkeypress="return isNumberKey(event)">
                            </div>    
                         <?php } ?>                                             
                        <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div>
                    </div>
                <?php } else {   ?>
                        <div class="form-group pos_relative2  customPriceField1" style="display:none">
                            <label id="titleLabel" for="fname" class="col-sm-2 control-label"><?php echo $this->lang->line('label_Units'); ?> 1(<?php echo $val['lan_name']; ?>)</label>
                            <div class="col-sm-3 pos_relative2">
                                <span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>
                                <input type="text" maxlength="8" class="error-box-class  form-control productTitle" id="modaltitle<?= $val['langCode']; ?>" placeholder="Enter Unit">
                            </div>
                            <div class="col-sm-3 pos_relative2">
                                <span  class="abs_text"><b><?php echo $currencySymbol; ?></b></span>
                                <input type="text" class="error-box-class  form-control productValue" id="modalvalue<?= $val['langCode']; ?>" placeholder="Enter the price"  onkeypress="return isNumberKey(event)">
                            </div>

                            <div class="col-sm-2 error-box redClass" ></div>

                        </div>
                                                    
                        <!-- quantity --> 
                        <div class="form-group pos_relative2 customPriceField1">
                            <label  class="col-sm-2 control-label"></label>
                            <?php if($storeType != "1" || $storeType != 1){?>
                                <div class="col-sm-3 pos_relative2">                                                   
                                    <input type="text" maxlength="8" class="error-box-class  form-control productTitle" id="modalvalue<?= $val['langCode']; ?>"  placeholder="Enter Stock"  onkeypress="return isNumberKey(event)">
                                </div>       
                            <?php } ?>                                        
                            <div class="col-sm-2 error-box redClass" id="text_productCustomText"></div>
                        </div>
                <?php
                        }
                    }
                ?>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" id="langSubmit">Ok</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>

    </div>
    </div>

<!--Addon modal -->
    <div class="modal fade" id="draggableModalpop" tabindex="-1" role="dialog" aria-labelledby="draggableModalll"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Add-On</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                
                <div>
                <div class="multiselect">
                                        <div class="selectBox"  style="width: 102%;">
                                            <select class="addOn multiple form-control addons" name="addOnIdsUnit[]" id="addOnIdsUnit" multiple="multiple">
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
                                                
                                           
                                                ?>
                                            </select>
                                            <div class="overSelect"></div>
                                        </div>

                                    </div>
                </div>
                <br>
                <p id="addOnLinkedmsg" style="display:none" >Linked Add-On's on group</p>
                    <div class="mb-10-drag">
                        <div id="linkedAddons">
                            
                        </div>
                    </div>
                   
                    <div class="mb-10-drag">
                        <div>
                            <label id="select-all" class="">
                                <input  type="checkbox" id="addOnselectAll"> Select all
                            </label>
                        </div>
                    </div>
                    <div class="mb-10" id="copyfromPAddondiv" style="display:none">
                        <div>
                            <label id="select-all" class="">
                                <input  type="checkbox" id="copyFromPAddon"> Copy from primary Add-On's
                            </label>
                        </div>
                    </div>
                    <div class="containerDrag">
                        <div class='row-drag justify-content-center-drag'>
                            <div class='col-6-drag'>
                            <div> <h6>Select Addons</h6> </div>
                                <ol class='list-drag vertical border-drag' id="source">
                                </ol>
                            </div>
                            <div class='col-6-drag'>
                            <div> <h6> Selected Addons with Price</h6> </div>
                                <ol class='list-drag vertical border-drag' id="destination">
                                </ol>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                   <button type="button" class="btn btn-default" id="draggableModalOk">Ok</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div id="confirmationDeleteaddOn" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirmation</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete.?</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default"  id="confirmAddondel">Ok</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div>

  </div>
</div>


<script>

    var $multiselect = $('.multiple').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '100%',
        maxHeight: 300,
        onChange : function(option, checked) {
             $("#unitLanguagemodal .modal-title").trigger('click');
},

    });
    $(document).ready(function () {
        var thisAddOnBtn = null;
    
        // Addon modal popup
        $(document).on('click', '.draggableModal', function () {
            
            var  dataValAddOn=$(this).attr('dataValAddon');          
            if(dataValAddOn==1){    
                $('#copyfromPAddondiv').hide();
            }else{
                $('#copyfromPAddondiv').show();
            }
            $('#copyFromPAddon').prop('checked', false);
            $('#addOnselectAll').prop('checked', false);
           

            thisAddOnBtn = this;
            var modalVal = $(thisAddOnBtn).closest('.form-group').find('#addOnUnitDestination').val();
            
            modalVal = JSON.parse(modalVal);
            var addOnList = '';
            $("#destination").html('');
            $("#linkedAddons").html('');
            $("#addOnIdsUnit option:selected").prop("selected", false);
            $("#addOnIdsUnit option").prop("disabled", false);
            modalVal.map((item) => {
                // addOnList +="<li value='"+ item.addOnId +"' id='"+ item.addOnId +"' groupId='"+ item.groupID +"' groupName='"+ item.groupname +"' addOnName='"+ item.addOnName +"' class='addOnUnit'><span class=' glyphicon glyphicon-move drag-handle'></span>"+  item.addOnName + "<span class='abs_text-drag'><b><?php echo $currencySymbol; ?></b></span><input class='form-control' id='unitPriceAddons' type='text' value='"+item.price+"'> </li>"; 
                $("#addOnIdsUnit option[value='"+ item.groupID +"']").prop("disabled", true);
                if($("#linkedAddons").find(`#linked_${item.groupID}`).length > 0){
                    var linkedData = $("#linkedAddons").find(`#linked_${item.groupID}`).attr('data');
                    linkedData = JSON.parse(linkedData);
                    linkedData.push(item);
                    $("#linkedAddons").find(`#linked_${item.groupID}`).attr('data', JSON.stringify(linkedData));
                } else {
                    var htmlLinked = `<div class='linkedAddons' id='linked_${item.groupID}' groupId='${item.groupID}' data='[${JSON.stringify(item)}]'>
                                        ${item.groupname}
                                        <span class="glyphicon glyphicon-remove linkedAddonsRemove"></span>
                                    </div>`;
                    $('#linkedAddons').append(htmlLinked);
                }
            });
            $("#destination").html(addOnList);
            $("#addOnIdsUnit").multiselect('refresh');
            $("#addOnIdsUnit").trigger('change');
            $("#source").html('');
            $('#draggableModalpop').modal('show');
        });
        $(document).on('click', '.linkedAddons', function () {
           
            $("#addOnIdsUnit option:selected").prop("selected", false);
            $("#addOnIdsUnit").multiselect('refresh');
            var linkedData = $(this).attr('data');
            var groupId = $(this).attr('groupId');
            linkedData = JSON.parse(linkedData);
            $("#destination").html('');
            var addOnList = '';
            linkedData.map((item) => {
                addOnList +="<li value='"+ item.addOnId +"' id='"+ item.addOnId +"' groupId='"+ item.groupID +"' groupName='"+ item.groupname +"' addOnName='"+ item.addOnName +"' class='addOnUnit'><span style='width:5%' class=' glyphicon glyphicon-move drag-handle'></span><span style='width:40%;text-align: center;'>"+  item.addOnName + "</span><span class='abs_text-drag'><b><?php echo $currencySymbol; ?></b></span><input class='form-control unitPriceAddons' id='unitPriceAddons' maxlength='5' onkeypress='return isNumberKey(event)' type='text' value='"+item.price+"'> </li>"; 
            });
            $("#destination").html(addOnList);
            $.ajax({
                url: "<?php echo base_url('index.php?/AddNewProducts') ?>/getAddonData",
                type: 'POST',
                dataType: 'json',
                data: {
                    val: [groupId]
                }
            }).done(function(json) {
                $("#source").html('');
                for (var i = 0; i< json.data.length; i++) {
                    var addOnLength=json.data[i].addOns.length;
                    var addOnList = ""
                    for(var j = 0; j< json.data[i].addOns.length; j++){
                        if($("#destination").find('#'+json.data[i].addOns[j].id).length <= 0)
                            addOnList +="<li value='"+ json.data[i].addOns[j].id +"' id='"+ json.data[i].addOns[j].id +"' groupId='"+ json.data[i]._id['$oid'] +"' groupName='"+ json.data[i].name['en'] +"' addOnName='"+ json.data[i].addOns[j].name['en'] +"' class='addOnUnit'><span style='width:5%' class=' glyphicon glyphicon-move drag-handle'></span><span style='width:40%;text-align: center;'>"+  json.data[i].addOns[j].name['en'] +" </span>  <span  class='abs_text-drag'><b><?php echo $currencySymbol; ?></b></span><input disabled class='form-control unitPriceAddons' maxlength='5' id='unitPriceAddons' onkeypress='return isNumberKey(event)' type='text' value='"+ json.data[i].addOns[j].price +"'> </li>"; 
                    }
                    $("#source").append(addOnList);
                }   
            });
        });

        $(document).on('change', '.unitPriceAddons', function () {
            console.log('cliked')
            var addOnId = $(this).closest('li').attr('id');
            var groupId = $(this).closest('li').attr('groupId');

            var linkedData = $("#linkedAddons").find(`#linked_${groupId}`).attr('data');
            console.log('linkedData-----',linkedData);
            linkedData = JSON.parse(linkedData);
            var linkedDataNew = [];
            var push = true;
            linkedData.map((item) => {
                if(item.addOnId == addOnId)
                    item.price = $(this).val();
                linkedDataNew.push(item);
            });
          
            $("#linkedAddons").find(`#linked_${groupId}`).attr('data', JSON.stringify(linkedDataNew));
        });
        // Addon modal popup
        $(document).on('click', '#draggableModalOk', function () {
            
            var destinationArray = [];
            $('.linkedAddons').each(function (i, e) {
                var linkedData = $(e).attr('data');
                linkedData = JSON.parse(linkedData);
                destinationArray = $.merge( $.merge( [], destinationArray ), linkedData );
            });
            // $('#destination li').each(function (i, e) {
            //     console.log($(e).find('#unitPriceAddons').val());
                // destinationArray.push({ 
                //     groupname : $(e).attr('groupName'),
                //     addOnId : $(e).attr('id'),
                //     groupID : $(e).attr('groupId'), 
                //     addOnName: $(e).attr('addOnName'), 
                //     price: $(e).find('#unitPriceAddons').val()
                // });
            // });
            var tempDataval = JSON.stringify(destinationArray);
            $(thisAddOnBtn).closest('.form-group').find('#addOnUnitDestination').val(tempDataval);
            $('#draggableModalpop').modal('hide');
        });
        //functio to get all addo on
        $(document).on('change', '#addOnIdsUnit', function () {
           
            var addOnGroupId = $(this).val();
            // var valAddonId = [];
            // console.log($(this).find(':checkbox:checked'));
            // console.log($(this).val());
            // $(this).find(':checkbox:checked').each(function(e, i){
            //     valAddonId[i] = $(e).val();
            // });
            // console.log(valAddonId);
            
            $.ajax({
                url: "<?php echo base_url('index.php?/AddNewProducts') ?>/getAddonData",
                type: 'POST',
                dataType: 'json',
                data: {
                    val: addOnGroupId
                }
            }).done(function(json) {
                $("#source").html('');
                // changes made destination is made empty on slect on addon 
                $("#destination").html('');
                for (var i = 0; i< json.data.length; i++) {
                    var addOnLength=json.data[i].addOns.length;
                    var addOnList = ""
                    for(var j = 0; j< json.data[i].addOns.length; j++){
                        if($("#destination").find('#'+json.data[i].addOns[j].id).length <= 0)
                            addOnList +="<li value='"+ json.data[i].addOns[j].id +"' id='"+ json.data[i].addOns[j].id +"' groupId='"+ json.data[i]._id['$oid'] +"' groupName='"+ json.data[i].name['en'] +"' addOnName='"+ json.data[i].addOns[j].name['en'] +"' class='addOnUnit'><span class=' glyphicon glyphicon-move drag-handle' style='width:5%;text-align: center;'></span><span style='width:40%'>"+  json.data[i].addOns[j].name['en'] +" </span>  <span  class='abs_text-drag'><b><?php echo $currencySymbol; ?></b></span><input disabled class='form-control unitPriceAddons' maxlength='5' id='unitPriceAddons' onkeypress='return isNumberKey(event)' type='text' value='"+ json.data[i].addOns[j].price +"'> </li>"; 
                    }
                    $("#source").append(addOnList);
                }   
            });
        });
        $('ol.list-drag').multisortable({
            stop: function (e, ui) {
                if ($(e.target).attr('id') == 'source') {
                    $('#destination li input').each(function (i, e) {
                        if ($(e).prop('disabled')) {
                            $(e).prop("disabled", false);
                        }
                    });
                    
                    $('#addOnLinkedmsg').show();
                  
                    $('#destination li.selected').each(function (i, e) {
                        var addOnId = $(e).attr('id');
                        var groupId = $(e).attr('groupId');
                        var groupName = $(e).attr('groupName');

                        var item = { 
                            groupname : $(e).attr('groupName'),
                            addOnId : $(e).attr('id'),
                            groupID : $(e).attr('groupId'), 
                            addOnName: $(e).attr('addOnName'), 
                            price: $(e).find('#unitPriceAddons').val()
                        }
                        $("#addOnIdsUnit option[value='"+ groupId +"']").prop("disabled", true);
                        $("#addOnIdsUnit option[value='"+ groupId +"']").prop("selected", false);
                        
                        if($("#linkedAddons").find(`#linked_${groupId}`).length > 0){
                            var linkedData = $("#linkedAddons").find(`#linked_${groupId}`).attr('data');
                            linkedData = JSON.parse(linkedData);
                            var push = true;
                            linkedData.map((item1) => {
                                if(item1.addOnId == addOnId)
                                    push = false;
                            });
                            if(push)
                                linkedData.push(item);
                            $("#linkedAddons").find(`#linked_${groupId}`).attr('data', JSON.stringify(linkedData));
                        } else {
                            var htmlLinked = `<div class='linkedAddons' id='linked_${groupId}' groupId='${groupId}' data='[${JSON.stringify(item)}]'>
                                                ${groupName}
                                                <span class="glyphicon glyphicon-remove linkedAddonsRemove"></span>
                                            </div>`;
                            $('#linkedAddons').append(htmlLinked);
                        }
                        $("#addOnIdsUnit").multiselect('refresh');
                    });
                } else if ($(e.target).attr('id') == 'destination') {
                   
                    $('#source li input').each(function (i, e) {
                        if (!($(e).prop('disabled'))) {
                            $(e).prop("disabled", true);
                        }
                    });
                    $('#source li.selected').each(function (i, e) {
                        var addOnId = $(e).attr('id');
                        var groupId = $(e).attr('groupId');

                        if($("#linkedAddons").find(`#linked_${groupId}`).length > 0){
                            var linkedData = $("#linkedAddons").find(`#linked_${groupId}`).attr('data');
                            linkedData = JSON.parse(linkedData);
                            var linkedDataNew = [];
                            linkedData.map((item) => {
                                if(item.addOnId != addOnId)
                                    linkedDataNew.push(item);
                            });
                            if(linkedDataNew.length > 0) {
                                $("#linkedAddons").find(`#linked_${groupId}`).attr('data', JSON.stringify(linkedDataNew));
                            } else {
                                $("#addOnIdsUnit option[value='"+ groupId +"']").prop("disabled", false);
                                $("#linkedAddons").find(`#linked_${groupId}`).remove();
                                $("#addOnIdsUnit").multiselect('refresh');
                            }
                        } else {
                        }
                    });
                }
            }
        });


        $('ol#source').sortable({
            handle: '.drag-handle',
            connectWith: 'ol#destination'
        });
        $('ol#destination').sortable({
            handle: '.drag-handle',
            connectWith: 'ol#source'
        });

        $('#select-all').on('click', () => {
            if ($("#select-all input").prop('checked') == true) {
                $('#source li').each(function (i, e) {
                    $(e).addClass('selected');
                });
            } else {
                $('#source li').each(function (i, e) {
                    $(e).removeClass('selected');
                });
            }

        })

        var langButton = null;
        // dynamically assign value
         $(document).on('click', '.unitLanguage', function () {
            langButton = this;
            var langdata= '<?php echo  json_encode($language); ?>';
            langdata = JSON.parse(langdata);
            $.each(langdata,function(i,data){     
                $('#modaltitle'+data.langCode).val($(langButton).closest('.form-group').find('.title'+data.langCode).val());
                $('#modalvalue'+data.langCode).val($(langButton).closest('.form-group').find('.value'+data.langCode).val());
                $('#modalquantity'+data.langCode).val($(langButton).closest('.form-group').find('.quantity'+data.langCode).val());
            });
            $('#unitLanguagemodal').modal('show'); 
        });
        

        // language modal popup
        $(document).on('click', '#langSubmit', function () {
            var langdata= '<?php echo  json_encode($language); ?>';
            langdata = JSON.parse(langdata);
            $.each(langdata,function(i,data){     
                $(langButton).closest('.form-group').find('.title'+data.langCode).val($('#modaltitle'+data.langCode).val());
                $(langButton).closest('.form-group').find('.value'+data.langCode).val($('#modalvalue'+data.langCode).val());
                $(langButton).closest('.form-group').find('.quantity'+data.langCode).val($('#modalquantity'+data.langCode).val());
            });
            $('#unitLanguagemodal').modal('hide');          
        });

        $(document).on('click', '.linkedAddonsRemove', function () {
            $('#confirmAddondel').attr('groupId', $(this).closest('.linkedAddons').attr('groupid'));
            $('#confirmationDeleteaddOn').modal('show');
        });

        $(document).on('click', '#confirmAddondel', function () {
            var groupId = $('#confirmAddondel').attr('groupId');
            $('#linkedAddons').find('#linked_'+groupId).remove();
            $("#source").html('');
            $("#destination").html('');
            $("#addOnIdsUnit option[value='"+ groupId +"']").prop("disabled", false);
            $("#addOnIdsUnit").multiselect('refresh');
            $('#confirmationDeleteaddOn').modal('hide');
        });


        $('#copyFromPAddon').click(function() {                       
            if ($('#copyFromPAddon').is(':checked')) {
               
                var modalVal = $('#addOnUnitDestination').val();
                modalVal = JSON.parse(modalVal);
                var addOnList = '';
                $("#destination").html('');
                $("#linkedAddons").html('');
                $("#addOnIdsUnit option:selected").prop("selected", false);
                $("#addOnIdsUnit option").prop("disabled", false);
                modalVal.map((item) => {
                    // addOnList +="<li value='"+ item.addOnId +"' id='"+ item.addOnId +"' groupId='"+ item.groupID +"' groupName='"+ item.groupname +"' addOnName='"+ item.addOnName +"' class='addOnUnit'><span class=' glyphicon glyphicon-move drag-handle'></span>"+  item.addOnName + "<span class='abs_text-drag'><b><?php echo $currencySymbol; ?></b></span><input class='form-control' id='unitPriceAddons' type='text' value='"+item.price+"'> </li>"; 
                    $("#addOnIdsUnit option[value='"+ item.groupID +"']").prop("disabled", true);
                    if($("#linkedAddons").find(`#linked_${item.groupID}`).length > 0){
                        var linkedData = $("#linkedAddons").find(`#linked_${item.groupID}`).attr('data');
                        linkedData = JSON.parse(linkedData);
                        linkedData.push(item);
                        $("#linkedAddons").find(`#linked_${item.groupID}`).attr('data', JSON.stringify(linkedData));
                    } else {
                        var htmlLinked = `<div class='linkedAddons' id='linked_${item.groupID}' groupId='${item.groupID}' data='[${JSON.stringify(item)}]'>
                                            ${item.groupname}
                                            <span class="glyphicon glyphicon-remove linkedAddonsRemove"></span>
                                        </div>`;
                        $('#linkedAddons').append(htmlLinked);
                    }
                });
                $("#destination").html(addOnList);
                $("#addOnIdsUnit").multiselect('refresh');
                $("#addOnIdsUnit").trigger('change');
                $("#source").html('');
                $('#draggableModalpop').modal('show');
	     	}else{
                $("#source").html('');
                $("#destination").html('');
                $("#linkedAddons").html('');
                $("#addOnIdsUnit option:selected").prop("selected", false);
                $("#addOnIdsUnit option").prop("disabled", false);
                $("#addOnIdsUnit").multiselect('refresh');
             }
    });

        
    });
</script>