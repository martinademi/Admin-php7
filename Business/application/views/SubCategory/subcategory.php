
<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
    .btn {
        font-size: 12px !important;
        border-radius: 25px !important;
    }

     .MandatoryMarker{
        color:red;
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
    width: 93%;
    z-index: 999;
    background: #fff;
    top: 40px;

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
</style>
<script>
    $(document).ready(function () {

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });
        $('.Category').addClass('active');

        $('#btnStickUpSizeToggler').click(function () {
            $("#display-data").text("");
            $("#display-data").text("");
            $('.catname').val("");
            $('#categoryError').text("");

            $('.catDescription').val("");
            $('#cat_photos').val("");
            $(".imagesProduct").css('display','none'); 
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
                    $('#myModal').modal('show')
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


        $('#bdelete').click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select a sub-category");
            } else if (val.length == 1 || val.length > 1)
            {
                $("#errorboxdata").text("Do you wish to delete the selected Sub-categories ?");
                $("#display-data").text("");
                var BusinessId = val;

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodel');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }


                $("#confirmed").click(function () {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/SubCategory') ?>/deleteSubCategory",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (response)
                        {
                            console.log(response);
                            $(".close").trigger("click");
                            var table = $('#big_table');
                            $('#big_table').fadeOut('slow');
                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/SubCategory/datatable_subcategory/' + '<?php echo $bid1; ?>'+ '/1',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                                },
                                "fnInitComplete": function () {
                                    $('#big_table').fadeIn('slow');

                                },
                                'fnServerData': function (sSource, aoData, fnCallback)
                                {
                                    $.ajax
                                            ({
                                                'dataType': 'json',
                                                'type': 'POST',
                                                'url': sSource,
                                                'data': aoData,
                                                'success': fnCallback
                                            });
                                }
                            };

                            table.dataTable(settings);
                        }
                    });
                });
            }

        });

         $(document).on('change', '.catImage', function () {
           
           console.log('clekc');
           var fieldID = 0;
           var ext = $(this).val().split('.').pop().toLowerCase();
           var formElement = $(this).prop('files')[0];
           uploadImage(fieldID, ext, formElement);
       })

         function uploadImage(fieldID, ext, formElement)
        {
            if ($.inArray(ext, ['jpg', 'JPEG','png','PNG']) == -1) {
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
                           $("#imagesProductImg").val(result.fileName) 
                           $(".imagesProduct").attr('src',result.fileName)
                           $(".imagesProduct").css('display','inline'); 
                        }
                        else if(fieldID == 1){
                            $("#bannerImageLink").val(result.fileName) 
                            $("#bannerImageImg").attr('src',result.fileName)
                            $("#bannerImageImg").css('display','inline');
                        }
                        else if(fieldID == 2){
                            $("#iconImageLink").val(result.fileName) 
                            $("#iconImageImg").attr('src',result.fileName)
                            $("#iconImageImg").css('display','inline');
                        }
                        else if(fieldID == 3){
                           $("#EditlogoImageLink").val(result.fileName) 
                           $("#EditlogoImageImg").attr('src',result.fileName)
                           $("#EditlogoImageImg").css('display','inline'); 
                        }
                        else if(fieldID == 4){
                            $("#EditbannerImageLink").val(result.fileName) 
                            $("#EditbannerImageImg").attr('src',result.fileName)
                            $("#EditbannerImageImg").css('display','inline');
                        }
                        else if(fieldID == 5){
                            $("#EditiconImageLink").val(result.fileName) 
                            $("#EditiconImageImg").attr('src',result.fileName)
                            $("#EditiconImageImg").css('display','inline');
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
    

        $('#insert').click(function () {

            if ($('#catname_0').val() == "" || $('#catname_0').val() == null)
            {
                $("#categoryError").text("Please enter sub-category name");
            }
            else if ($("#imagesProductImg").val() == "" || $("#imagesProductImg").val() == null) {
                $("#categoryError").text("Please select the image");
            }else{
                var img = '';
            var imgUrl = ''
            var cateid = "<?php echo $bid1; ?>";
            var form_data = new FormData();
            var form_data1 = new FormData();
            var catname = new Array();
            var description = new Array();
            var parentCatId=$('#parentCatId').val();
               
               if(parentCatId=="" || parentCatId==null){
                   parentCatId="";
               }

            $(".catname").each(function () {
                catname.push($(this).val());
                form_data1.append('name[]', $(this).val());
            });
            $(".catDescription").each(function () {
                description.push($(this).val());
                form_data1.append('description[]', $(this).val());
            });

            var cat_photos = $("#cat_photos").val();
            form_data1.append('parentCatId', parentCatId);
            form_data1.append('categoryId', cateid);
            var visibility = parseInt(1);
            form_data1.append('visibility', visibility);
            form_data1.append('addedFrom', 'store');
            form_data.append('type', 'uploadImage');
            form_data.append('Image', 'Image')
            form_data.append('folder', 'second_level_category');
            if (catname == "" || catname == null)
            {
                $("#clearerror").text("Please enter the Category name");
            } else {
                var imgUrl = '';
               
                            imgUrl=$("#imagesProductImg").val();
                            img = imgUrl;
                            form_data1.append('imageUrl', img);

                            $.ajax({
                                url: "<?php echo base_url('index.php?/SubCategory') ?>/insertSubCategory",
                                type: 'POST',
                                data: form_data1,
                                dataType: 'JSON',
                                success: function (response)
                                {
                                    if (response.msg == 1) {
                                        $('.close').trigger('click');

                                        var size = $('input[name=stickup_toggler]:checked').val()
                                        var modalElem = $('#addmodal');
                                        if (size == "mini")
                                        {
                                            $('#modalStickUpSmall').modal('show')
                                        } else
                                        {
                                            $('#addmodal').modal('show')
                                            if (size == "default") {
                                                modalElem.children('.modal-dialog').removeClass('modal-lg');
                                            } else if (size == "full") {
                                                modalElem.children('.modal-dialog').addClass('modal-lg');
                                            }
                                        }

                                        $("#errorboxaddmodal").text("Sub-Category has been successfully added");

                                        var table = $('#big_table');
                                        $('#big_table').fadeOut('slow');
                                        var settings = {
                                            "autoWidth": false,
                                            "sDom": "<'table-responsive't><'row'<p i>>",
                                            "destroy": true,
                                            "scrollCollapse": true,
                                            "iDisplayLength": 20,
                                            "bProcessing": true,
                                            "bServerSide": true,
                                            "sAjaxSource": '<?php echo base_url() ?>index.php?/SubCategory/datatable_subcategory/' + '<?php echo $bid1; ?>'+ '/1',
                                            "bJQueryUI": true,
                                            "sPaginationType": "full_numbers",
                                            "iDisplayStart ": 20,
                                            "oLanguage": {
                                            },
                                            "fnInitComplete": function () {
                                                $('#big_table').fadeIn('slow');

                                            },
                                            'fnServerData': function (sSource, aoData, fnCallback)
                                            {
                                                $.ajax
                                                        ({
                                                            'dataType': 'json',
                                                            'type': 'POST',
                                                            'url': sSource,
                                                            'data': aoData,
                                                            'success': fnCallback
                                                        });
                                            }
                                        };

                                        table.dataTable(settings);
                                    } else {
                                        $('.close').trigger('click');

                                        var size = $('input[name=stickup_toggler]:checked').val()
                                        var modalElem = $('#addmodal');
                                        if (size == "mini")
                                        {
                                            $('#modalStickUpSmall').modal('show')
                                        } else
                                        {
                                            $('#addmodal').modal('show')
                                            if (size == "default") {
                                                modalElem.children('.modal-dialog').removeClass('modal-lg');
                                            } else if (size == "full") {
                                                modalElem.children('.modal-dialog').addClass('modal-lg');
                                            }
                                        }

                                        $("#errorboxaddmodal").text("Sub-Category already exists..");
                                    }
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

            }

            
        });


        $("#cat_photos").change(function () {
            $('.clearerror').text("");
            var cat_photos = $("#cat_photos").val();
            var userfile_extn = cat_photos.split(".");
            userfile_extn = userfile_extn[userfile_extn.length - 1].toLowerCase();

            var arrayExtensions = ["jpg", "jpeg", "png", "bmp", "gif"];
            if (arrayExtensions.lastIndexOf(userfile_extn) == -1 || (this.files[0].size / 1024 / 1024) > 2)
            {
                $("#clearerror").text("Invalid image.");
                $("#cat_photos").val("");
            }
        });

        $("#Editcat_photos").change(function ()
        {
            $('.editclearerror').text("");
            var cat_photos = $("#Editcat_photos").val();

            var userfile_extn = cat_photos.split(".");
            userfile_extn = userfile_extn[userfile_extn.length - 1].toLowerCase();

            var arrayExtensions = ["jpg", "jpeg", "png", "bmp", "gif"];
            if (arrayExtensions.lastIndexOf(userfile_extn) == -1 || (this.files[0].size / 1024 / 1024) > 2)
            {
                $("#editclearerror").text("Image Size is more than 2MB or Invalid Image.");
                $("#Editcat_photos").val("");
            }


        });

        $("#Editcat_photos").change(function ()
        {
            $('.editclearerror').text("");
            var cat_photos = $("#Editcat_photos").val();

            var userfile_extn = cat_photos.split(".");
            userfile_extn = userfile_extn[userfile_extn.length - 1].toLowerCase();

            var arrayExtensions = ["jpg", "jpeg", "png", "bmp", "gif"];
            if (arrayExtensions.lastIndexOf(userfile_extn) == -1 || (this.files[0].size / 1024 / 1024) > 2)
            {
                $("#editclearerror").text("Invalid image.");
                $("#Editcat_photos").val("");
            }


        });

        var editvalal = '';
        $(document).on('click', '#btnedit', function () {

            $("#display-data").text("");
            $(".error-box-class").val("");

            editvalal = $(this).val();

            $.ajax({
                url: "<?php echo base_url() ?>index.php?/SubCategory/getbusiness_catdataTwo",
                type: 'POST',
                data: {val: editvalal},
                dataType: 'JSON',
                success: function (response)
                {
                    $.each(response, function (index, row) {
                        $('#editedId').val(row._id.$oid);
                        $('#Editcatname_0').val(row.subCategoryName['en']);
<?php foreach ($language as $val) { ?>
                            $('#Editcatname_<?= $val['lan_id'] ?>').val(row.subCategoryName['<?= $val['langCode'] ?>']);
<?php } ?>
                        $('#EditcatDescription_0').val(row.subCategoryDesc['en']);
<?php foreach ($language as $val) { ?>
                            $('#EditcatDescription_<?= $val['lan_id'] ?>').val(row.subCategoryDesc['<?= $val['langCode'] ?>']);
<?php } ?>
                        if (row.imageUrl) {
                            $('#Edit_photo').show();
                            $('#Edit_photo').attr('href', row.imageUrl);
                        } else
                            $('#Edit_photo').hide();
                    });
                },
            });

            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#editModal');
            if (size == "mini")
            {
                $('#modalStickUpSmall').modal('show')
            } else
            {
                $('#editModal').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                } else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
            $("#errorboxdatas").text("Are you sure you wish to activate the driver reviews ?");
        });


         // delete category
        $(document).on('click', '#btndelete', function () {

        $('#myModalDelete').modal('show');
        delCatid   =$(this).attr('data-id');

        });



        $('#confirmDel').click(function(){
            val=delCatid;
            $.ajax({
                url: "<?php echo base_url('index.php?/SubCategory') ?>/operationSubCategory/delete",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {   
                    console.log('reppp---',response)
                    location.reload();
                }
            });
        });


    //active category
        $(document).on('click', '#btnactive', function () {
            $('#myModalActive').modal('show');
             delCatid   =$(this).attr('data-id');
             catStatus=$(this).attr('status');
        });
        

        $('#confirmActive').click(function(){
            val=delCatid;
            status=catStatus;
            $.ajax({
                    url: "<?php echo base_url('index.php?/SubCategory') ?>/operationSubCategory/active",
                    type: "POST",
                    data: {val: val},
                    dataType: 'json',
                    success: function (response)
                    {   
                        console.log('reppp---',response)
                        location.reload();
                    }
                });
        });

        //active category
        // $(document).on('click', '#btninactive', function () {
        //     $('#myModalActive').modal('show');
        //      delCatid   =$(this).attr('data-id');
        // });
        

        // $('#confirmActive').click(function(){
        //     val=delCatid;
        //     $.ajax({
        //             url: "<?php echo base_url('index.php?/SubCategory') ?>/operationSubCategory/inactive",
        //             type: "POST",
        //             data: {val: val},
        //             dataType: 'json',
        //             success: function (response)
        //             {   
        //                 console.log('reppp---',response)
        //                 location.reload();
        //             }
        //         });
        // });

        


        $('#editbusiness').click(function () {
            var img = "";
            var imgUrl = "";
            $("#display-data").text("");
            var form_data = new FormData();
            var form_data1 = new FormData();
            var val = editvalal;
            $('.editclearerror').text("");
            var editcatname = new Array();
            $(".Editcatname").each(function () {
                form_data1.append('name[]', $(this).val());
                editcatname.push($(this).val());
            });
            var editcatDescription = new Array();
            $(".editcatDescription").each(function () {
                editcatDescription.push($(this).val());
                form_data1.append('description[]', $(this).val());
            });

            var editcatpic = $("#Editcat_photos").val();
            var file_data = $('#Editcat_photos').prop('files')[0];
            if (file_data) {
                form_data.append('cat_photos', file_data);
                form_data.append('OtherPhoto', file_data);
                form_data.append('type', 'uploadImage');
                form_data.append('Image', 'Image')
                form_data.append('folder', 'second_level_category');
            }

            form_data1.append('editId', $("#editedId").val());
            if ($('#Editcatname_0').val() == "" || $('#Editcatname_0').val() == null) {
                $("#editclearerror").text(<?php echo json_encode(POPUP_CAT_NAME); ?>);
            } else {

                if (file_data) {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                        type: "POST",
                        data: form_data,
                        dataType: "JSON",
                        success: function (result) {
                            console.log(result)
                            if (result.msg == '1') {
                                imgUrl = result.fileName;
                                img = imgUrl;
                                form_data1.append('imageUrl', img);

                                $.ajax({
                                    url: "<?php echo base_url('index.php?/SubCategory') ?>/editSubCategory",
                                    type: 'POST',
                                    data: form_data1,
                                    async: true,
                                    dataType: 'JSON',
                                    success: function (response)
                                    {
                                        $('.close').trigger('click');
                                        window.location.reload();
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                });
                            } else {

                                alert('Problem In Uploading Image-' + result.folder);
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });

                } else {
                    $.ajax({
                        url: "<?php echo base_url('index.php?/SubCategory') ?>/editSubCategory",
                        type: 'POST',
                        data: form_data1,
                        async: true,
                        dataType: 'JSON',
                        success: function (response)
                        {
                            $('.close').trigger('click');
                            window.location.reload();
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });

                }
            }
        });


        $('#hide').click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select a sub-category");
            } else if (val.length >= 1)
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#hideModel');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#hideModel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $("#errorboxdata").text("Are you sure you wish to deactivate sub-category");
            }
        });
        $("#btnhide").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/SubCategory/hideSubCategory",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {
                    if (response.flag == 1) {
                        $('#hideModel').modal('hide');
                        window.location.reload();
                    } else {
                        $('#hideModel').modal('hide');
                        $('#displayData').modal('show');
                        $("#display-data").text("Sub Category is already Hidden");
                    }
                }
            });
        });

        $('#unhide').click(function () {
            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select a sub-category");
            } else if (val.length >= 1)
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodel1');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmodel1').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $("#errorboxdata").text("Are you sure you wish to activate sub-category");

            }

        });



        $("#confirmed1").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/SubCategory/unhideSubCategory",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {
                    if (response.flag == 1) {
                        $('#confirmmodel1').modal('hide');
                        window.location.reload();
                    } else {
                        $('#confirmmodel1').modal('hide');
                        $('#displayData').modal('show');
                        $("#display-data").text("Sub Category is already Unhidden");
                    }
                }
            });
        });
    });

    function moveUp(id) {
        var row = $(id).closest('tr');
        var prev_id = row.prev('tr').find('.moveUp').attr('id')
        var curr_id = row.find('.moveUp').attr('id');
        if (prev_id == undefined) {
            $('#displayData').modal('show');
            $('#display-data').text('Cannot reorder , Sub-Category is at the end..!!')
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/SubCategory/operationSubCategory/order",
                type: "POST",
                data: {kliye: 'interchange', curr_id: curr_id, prev_id: prev_id},
                success: function (result) {

                }
            });
            row.prev().insertAfter(row);
            $('#saveOrder').trigger('click');
        }
    }
    function moveDown(id) {

        var row = $(id).closest('tr');
        var prev_id = row.find('.moveDown').attr('id');
        var curr_id = row.next('tr').find('.moveDown').attr('id');
        if (curr_id == undefined) {
            $('#displayData').modal('show');
            $('#display-data').text('Cannot reorder , Sub-Category is at the end..!!')
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/SubCategory/operationSubCategory/order",
                type: "POST",
                data: {kliye: 'interchange', prev_id: prev_id, curr_id: curr_id},
                success: function (result) {

                }
            });
            row.insertAfter(row.next());
            $('#saveOrder').trigger('click');
        }
    }

//    function validatecat() {
//        $.ajax({
//            url: "<?php echo base_url() ?>index.php?/Category/operationCategory/validate",
//            type: "POST",
//            data: {catname: $('#catname_0').val()},
//            dataType: "JSON",
//            success: function (result) {
//
//                // alert();
////                alert(result.count);
//                console.log(result.count);
//                $('#catname_0').attr('data', result.msg);
//
//                if (result.count == true) {
//
//                    $("#clearerror").html("Category name already exists.");
//                    $('#catname_0').focus();
//                    return false;
//                } else if (result.count != true) {
//                    $("#clearerror").html("");
//
//                }
//            }
//        });
//    }


   function productFill() {
        $('.loader').show();
        var pName=$('#catname_0').val();
        var pCatId='<?php echo $bid1 ; ?>';
       
       
        var countPname=pName.length;
        
        if(countPname==0){
            $('.loader').hide();
        }
        if(countPname>3){

                  $.ajax({
                    url: "<?php echo base_url('index.php?/SubCategory') ?>/getProductsBySerach",
                    type: "POST",
                    dataType: 'JSON',
                    data: {serachData: pName,pCatId:pCatId},
                    success: function (response)
                    {
                        $('#productNameListDiv').show();
                         $('#productNameList').empty();
                        console.log('rel---',response)
                     
                        html = '';
                      

                          if (response.data.length !== 0)
                        {
                           
                            $.each(response.data, function (index, row) {
                                  html +='<p class="pData" id="'+ row._id.$oid+'" >'+row.name[0]+' </p>';
                                  $('#productNameList').show();
                            });
                           
                        }else{
                            $('#productNameList').hide();
                        }

                         $('#productNameList').append(html);


    $("#productNameList").on('click', '.pData' , function () {
        $('#catname_0').val($(this).text());
        var selectedId = $(this).attr('id');
        console.log('------',selectedId);
        $('#productNameList').empty();
        $('#productNameList').hide();



             
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
                    $('.imagesProduct').attr('src', dList.imageUrl);
                    $('.imagesProduct').show();

                     $("#imagesProductImg").val(dList.imageUrl)                
                  

                    $('#parentCatId').val(dList._id.$oid);

                                          
                       }
                });
        });

        $('.loader').hide();
                            
                            }
                        });
                }

  
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {

       

        var id = "<?php echo $bid1; ?>";
        var status = 1;
        if (status == 1) {
           $('#btnStickUpSizeToggler').show();
        $('#unhide').hide();
        $('#hide').show();
        }

        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/SubCategory/datatable_subcategory/' + id + '/1',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');

            },
            'fnServerData': function (sSource, aoData, fnCallback)
            {
                $.ajax
                        ({
                            'dataType': 'json',
                            'type': 'POST',
                            'url': sSource,
                            'data': aoData,
                            'success': fnCallback
                        });
            }
        };
        table.dataTable(settings);
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('.whenclicked li').click(function () {
            console.log($(this).attr('id'));
            if ($(this).attr('id') == 1) {

                $('#btnStickUpSizeToggler').show();
                $('#unhide').hide();
                $('#hide').show();

            } else if ($(this).attr('id') == 0) {

                $('#btnStickUpSizeToggler').hide();
                $('#unhide').show();
                $('#hide').hide();
            }
        });

        $('.changeMode').click(function () {

            var table = $('#big_table');
            $('#big_table').fadeOut('slow');

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": $(this).attr('data'),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    $('#big_table').fadeIn('slow');

                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback
                            });
                }
            };
            $('.tabs_active').removeClass('active');
            $(this).parent().addClass('active');
            table.dataTable(settings);
        });
    });

</script>

<style>
    .exportOptions{
        display: none;
    }

    .breadcrumb {
        padding: 8px 14px;
        margin-bottom: -35px !important;
        list-style: none;
        background-color: #f5f5f5;
        border-radius: 4px;
    }
    .btn {
        border-radius: 25px !important;
    }
    .pageAdj{
        margin-top: -35px;
        margin-left: -50px;
        margin-right: -50px;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 20px;">
    <div class="content">
        <div class="brand inline" style="  width: auto;">
           <?php echo 'Sub Category'; ?>
        </div>

        <div class="panel panel-transparent ">
                <ul class="breadcrumb" style="background:white;">
                    <li><a class="active" href="<?php echo base_url() ?>index.php?/Category" class="">Categories</a> </li>
                    <li style="width: 70%"><a href="<?php echo base_url() ?>index.php?/SubCategory/SubCategory/<?php echo $bid1; ?>" class="active">
                            <?php
                            foreach ($business as $cat) {
                                if ((string) $cat['categoryId'] == $bid1) {
                                    $catname = $cat['name'][0];
                                }
                            }
                            print_r($catname);
                            ?>

                        </a>
                    </li>
                </ul>
        <br/><br/>
        </div>

        <div class="panel panel-transparent ">
                <ul class="whenclicked nav nav-tabs  bg-white">
                    <li id= "1" class="tabs_active active" style="cursor:pointer">
                        <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/SubCategory/datatable_subcategory/<?php echo $bid1; ?>/1" data-id="1"><span>Active</span><span class="badge" style="background-color: #337ab7;"></span></a>
                    </li>

                    <li id= "0" class="tabs_active" style="cursor:pointer;display:none">
                        <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/SubCategory/datatable_subcategory/<?php echo $bid1; ?>/0" data-id="0"><span>In-active</span> <span class="badge bg-red"></span></a>
                    </li>

                    <li id= "2" class="tabs_active" style="cursor:pointer">
                        <a   class="changeMode" data="index.php?/SubCategory/datatable_subcategory/<?php echo $bid1; ?>/2" data-id="2"><span><?php echo 'Deleted'; ?></span></a>
                    </li>

                    <!--<div class="pull-right m-t-10 cls111"> <button class="btn btn-info" id="edit" >Edit</button></div>-->
                    <!--<div class="pull-right m-t-10 cls111"> <button class="btn btn-danger" id="bdelete"><span>Delete</button></a></div>-->
                    <!-- <div class="pull-right m-t-10 cls111"> <button class="btn btn-warning" id="hide" >Deactivate</button></a></div> -->
                    <!-- <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary" id="unhide">Activate</button></a></div> -->
                    <div class="pull-right m-t-10  cls110"> <button class="btn btn-success" id="btnStickUpSizeToggler"><span>Add</button></a></div>

                </ul>
        </div>

        
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent " style="margin-left: -20px;margin-right: -15px;padding-top: 15px;">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="error-box" id="display-data" style="text-align:center; color: red;"></div>
                                    <div class="searchbtn row clearfix pull-right" >

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" style="text-transform: capitalize;" placeholder="<?php echo SEARCH; ?>"> </div>
                                    </div>
                                    <div class="dltbtn">
                                    </div>
                                </div>
                                &nbsp;

                                <div class="container">
                                    <div class="row clearfix">
                                        <div class="col-md-12 column">
                                            <?php echo $this->table->generate(); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- END JUMBOTRON -->

</div>
<!-- END PAGE CONTENT -->

</div>

<div class="modal fade stick-up" id="addmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title">Alert</span>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxaddmodal" style="font-size: large;text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-default pull-right" id="confirmeds1"data-dismiss="modal" >OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <span class="modal-title">Alert</span>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdata" style="font-size: large;text-align:center">"Are you sure you wish to delete?"</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="confirmmodel1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <span class="modal-title">Alert</span>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdata" style="font-size: large;text-align:center">Are you sure you wish to activate sub-category</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed1" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="hideModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <span class="modal-title">Alert</span>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdata" style="font-size: large;text-align:center">Are you sure you wish to deactivate sub-category</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="btnhide" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom:0;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdatas" style="font-size: large;text-align:center">Are you sure you wish to delete?</div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" >Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="addcat"  role="form"  method="post" enctype="multipart/form-data">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>

                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"> ADD SUB-CATEGORY</span>
                </div>

                <div class="modal-body">

                    <div id="Category_txt" >
                        <div class="row">
                            <div class="form-group formex">
                                <div class="frmSearch">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label"> Name (English) <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">    <!--<div class="col-sm-6">-->  
                                        <input type="text"   id="catname_0" name="catname[0]" style="  width: 100%;line-height: 2;" class="catname form-control error-box-class" onkeyup="productFill()" >
                                        <div class="loader" style="display:none"></div>
                                        <input type="hidden" id="parentCatId" name="parentCatId">
                                         
                                             <div id="productNameList" style="display:none"></div>
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
                                                <input type="text"  id="catname_<?= $val['lan_id'] ?>" name="catname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="catname form-control error-box-class" >
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
                            <label for="fname" class="col-sm-4 control-label">Image<span class="MandatoryMarker">* (max size - 2 mb)</span></label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control error-box-class catImage"  name="cat_photos" id="cat_photos" placeholder=""></div>

                                 <input type="hidden" id="imagesProductImg" value="">

                             <img src="" style="width: 35px; height: 35px; display: none;" class="imagesProduct style_prevu_kit">
                        </div>
                        <br/>

                    </div>
                </div>

                <div class="modal-footer">                            
                    <div class="col-sm-4 error-box" id="categoryError"></div>
                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary pull-right" id="insert" >Add</button>
                    </div>
                </div>                    
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>

<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
</button>
</form>
</div>




<div class="modal fade stick-up" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="editcat"  role="form"  method="post" enctype="multipart/form-data">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title"> EDIT SUB-CATEGORY</span>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="editedId" style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>                       

                    <div id="Category_txt" >
                        <div class="row">
                            <div class="form-group formex">
                                <div class="frmSearch">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label">Name (English) <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">  
                                        <input type="text"   id="Editcatname_0" name="Editcatname[0]" style="  width: 100%;line-height: 2;" class="Editcatname form-control error-box-class" >
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
                                            <label for="fname" class="col-sm-4 control-label">Name (<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="Editcatname_<?= $val['lan_id'] ?>" name="Editcatname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="Editcatname form-control error-box-class" >
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <?php } else { ?>
                                <div class="row">
                                    <div class="form-group formex" style="display: none;">
                                        <div class="frmSearch">
                                            <div class="col-sm-1"></div>
                                            <label for="fname" class="col-sm-4 control-label">Name (<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="Editcatname_<?= $val['lan_id'] ?>" name="Editcatname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="Editcatname form-control error-box-class" >
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
                            <label for="fname" class="col-sm-4 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="EditcatDescription_0" name="EditcatDescription[0]"  class="editcatDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
                            </div>
                        </div>
                    </div>

                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="row">                    
                                <div class="form-group formex">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label">Description (<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <textarea type="text"  id="EditcatDescription_<?= $val['lan_id'] ?>" name="EditcatDescription[<?= $val['lan_id'] ?>]"  class="editcatDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>
                            <div class="row" style="display: none;">                    
                                <div class="form-group formex">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label">Description (<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <textarea type="text"  id="EditcatDescription_<?= $val['lan_id'] ?>" name="EditcatDescription[<?= $val['lan_id'] ?>]"  class="editcatDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>
                    <br/>

                    <div class="form-group formex" style="display:none;">
                        <label for="fname" class="col-sm-4 control-label">    <?php echo "SELECT IF THIS CUSINE IS UPPER LAYER"; ?></label>
                        <div class="col-sm-8">
                            <input type="checkbox" id="checkUpperLayer" value="CheckUpperLayer">
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="form-grou formex">
                            <div class="col-sm-1"></div>
                            <label for="fname" class="col-sm-4 control-label">Image<span class="MandatoryMarker"> * (max size - 2 mb)</span></label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control error-box-class"  name="Editcat_photos" id="Editcat_photos" value="" placeholder="">
                                <input type="hidden" id="Edit_photos" name="Edit_photos"  class="form-control error-box-class">

                                <a target="_blank" id="Edit_photo" name="Edit_photo" style="display:none;" href="" >view</a> 

                            </div>

                        </div>
                    </div>
                    <br/>

                </div>

                <div class="modal-footer">
                    <div class="col-sm-4 error-box" id="editclearerror"></div>

                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary pull-right" id="editbusiness" >Save</button>
                    </div>
                </div>
            </div>                
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
</form>
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
</button>
</div>


<div id="wait" style="display:none;width:100px;height:100px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url(); ?>pics/spinner.gif' width="64" height="64" /><br>Loading..</div>


<div id="myModalDelete" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Alert</h4>
      </div>
      <div class="modal-body">
        <p style="font-size: 15px;">Are you sure you want to delete..?</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" id="confirmDel" >Ok</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="myModalActive" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Alert</h4>
      </div>
      <div class="modal-body">
        <p style="font-size: 15px;">Are you sure you want to active..?</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" id="confirmActive" >Ok</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>