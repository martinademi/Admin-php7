
<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
    .btn {
        border-radius: 25px !important;
    }
    .pageAdj{
        margin-top: -35px;
        padding-top: 15px;
        margin-left: -50px;
        margin-right: -50px;
    }
    .MandatoryMarker{
        color:red;
    }
</style>
<script>
$(document).ready(function (){
    $(document).ajaxComplete(function () {
        // console.log("hsdfsdf");
        var access_right_pg = '<?= $access_right_pg ?>';
        if (access_right_pg == 000) {
    //   base_url().'index.php?/superadmin/access_denied';
        } else if (access_right_pg == 100) {
            $('.cls110').remove();
            $('.cls111').remove();
        } else if (access_right_pg == 110) {
            $('.cls111').remove();
        } 
    });

    $(document).on('click','.fg-button',function(){
        $("#select_all").prop("checked", false);
    });  

      $("body").on('click','#select_all',function(){ 
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    

       $("body").on('click','.checkbox',function(){ 
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }   
       });

});
</script>
<script>
    $(document).ready(function () {
        var mongoid = "<?php echo $bid; ?>";
        var id = "<?php echo $id; ?>";
        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });
        $('.businesscat').addClass('active');
        $('.businesscat').attr('src', "<?php echo base_url(); ?>/theme/icon/business_mgt_on.png");
        $('.businesscat_thumb').addClass("bg-success");
        $('#btnStickUpSizeToggler').click(function () {
            $('#catname_0').val("");
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
                    $('#myModal').modal('show')
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
        $('#bdelete').click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select a sub sub-category");
            } else if (val.length == 1 || val.length > 1)
            {
                $("#errorboxdata").text("Do you wish to delete the selected Sub sub-category ?");
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
                        url: "<?php echo base_url('index.php?/SubsubCategory') ?>/deleteSubSubCategory",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (response)
                        {
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/SubsubCategory/datatable_subsubcategory/' + '<?php echo $bid; ?>/1',
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
                                },
                                "columnDefs": [
                                    {  targets: "_all",
                                        orderable: false 
                                    }
                            ],
                            };
                            table.dataTable(settings);
                        }
                    });
                });
            }

        });

        $(document).on('change', '.catImage', function () {
           
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
                $("#categoryError").text("Please enter the sub sub-category name");
            } else if ($("#cat_photos").val() == "" || $("#cat_photos").val() == null) {
                $("#categoryError").text("Please select the image");
            }
            $('.clearerror').text("");
            var img = '';
            var imgUrl = ''
            var cateid = "<?php echo $bid; ?>";
            var form_data = new FormData();
            var catname = new Array();
            var description = new Array();
            $(".catname").each(function () {
                form_data.append('catname[]', $(this).val());
                catname.push($(this).val());
            });

            $(".catDescription").each(function () {
                description.push($(this).val());
                form_data.append('catDescription[]', $(this).val());
            });

            var description = new Array();
            var catcheckUpperLayer = '0';
            if ($('#catcheckUpperLayer').prop('checked') == true) {
                catcheckUpperLayer = '1';
            }

            var cat_photos = $("#cat_photos").val();
            var file_data = $('#cat_photos').prop('files')[0];
            var fileName = file_data.name;
            form_data.append('cateid', cateid);
            form_data.append('id', id);
            form_data.append('cat_photos', file_data);
            form_data.append('catcheckUpperLayer', catcheckUpperLayer);
            form_data.append('OtherPhoto', file_data);
            form_data.append('type', 'uploadImage');
            form_data.append('Image', 'Image')
            form_data.append('folder', 'third_level_category');
            if (catname == "" || catname == null)
            {
                $("#clearerror").text(<?php echo json_encode(POPUP_CAT_NAME); ?>);
            } else {
                var imgUrl = '';
                                         
                            imgUrl=$("#imagesProductImg").val();
                            img = imgUrl;
                            form_data.append('cat_photosamz', img);
                            $.ajax({

                                url: "<?php echo base_url('index.php?/SubsubCategory') ?>/insertSubSubCategory",
                                type: 'POST',
                                data: form_data,
                                dataType: 'JSON',
                                success: function (response)
                                {
                                    if (response.msg == 1 || response.msg == '1') {
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

                                        $("#errorboxaddmodal").text("Sub Sub-Category has been added successfully...");
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
                                            "sAjaxSource": '<?php echo base_url() ?>index.php?/SubsubCategory/datatable_subsubcategory/' + '<?php echo $bid; ?>/1',
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
                                                    },
                                            "columnDefs": [
                                                {  targets: "_all",
                                                    orderable: false 
                                                }
                                        ],
                                        };
                                        table.dataTable(settings);
                                    } else if (response.msg == 0 || response.msg == '0') {

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

                                        $("#errorboxaddmodal").text("Sub Sub-Category already exists...");


                                    }
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
        $("#cat_photos").change(function () {
            $('.clearerror').text("");
            var cat_photos = $("#cat_photos").val();
            var userfile_extn = cat_photos.split(".");
            userfile_extn = userfile_extn[userfile_extn.length - 1].toLowerCase();
            var arrayExtensions = ["jpg", "jpeg", "png", "bmp", "gif"];
            if (arrayExtensions.lastIndexOf(userfile_extn) == -1 || (this.files[0].size / 1024 / 1024) > 2)
            {
//                            alert("Invalid image.");
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

                $("#editclearerror").text("Invalid image.");
                $("#Editcat_photos").val("");
            }


        });
        $('#editbusiness').click(function () {

            $("#display-data").text("");
            var form_data = new FormData();
            var val = $(this).val();
            $('.editclearerror').text("");
            var editcatname = new Array();
            $(".Editcatname").each(function () {
                form_data.append('catname[]', $(this).val());
                editcatname.push($(this).val());
            });

            var editcatDescription = new Array();
            $(".editcatDescription").each(function () {
                editcatDescription.push($(this).val());
                form_data.append('catDescription[]', $(this).val());
            });

            var editcatpic = $("#Editcat_photos").val();
            var file_data = $('#Editcat_photos').prop('files')[0];
            console.log(file_data);
            form_data.append('cat_photos', file_data);
//            form_data.append('catDescription', $("#EditcatDescription").val());
            form_data.append('type', 'uploadImage');
            form_data.append('Image', 'Image');
            form_data.append('foldername', 'third_level_category');
            var UL = '0';
            if ($('#checkUpperLayer').prop('checked') == true) {
                UL = '1';
            }
            form_data.append('catcheckUpperLayer', UL);
            form_data.append('editId', val);
            if (editcatname == "" || editcatname == null) {
                $("#editclearerror").text("Please enter sub sub-category name");
            } else {

                if (file_data) {
                    var img = '';
                    var imgUrl = '';
                    $.ajax({
                        url: "<?php echo base_url('index.php?/Common') ?>/callUtility_services/cat_photos",
                        type: "POST",
                        data: form_data,
                        dataType: "JSON",
                        success: function (result) {
                            console.log(result)
                            if (result.msg == '1') {
                                imgUrl = result.fileName;
                                img = imgUrl;
                                form_data.append('cat_photosamz', img);
                                $.ajax({
                                    url: "<?php echo base_url('index.php?/SubsubCategory') ?>/editSubSubCategory",
                                    type: 'POST',
                                    data: form_data,
                                    async: false,
                                    dataType: 'JSON',
                                    success: function (response)
                                    {
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
                        url: "<?php echo base_url('index.php?/SubsubCategory') ?>/editSubSubCategory",
                        type: 'POST',
                        data: form_data,
                        async: true,
                        dataType: 'JSON',
                        success: function (response)
                        {
                            window.location.reload();
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            }
        });
        $(document).on('click', '.editICON', function () {
            $("#display-data").text("");
            $('#modalHeading').html("EDIT CATEGORY");
//            var val = $('.checkbox:checked').map(function () {
//                return this.value;
//            }).get();
            var val = $(this).val();
            $('#editbusiness').val(val);
            if(val)
            {
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/SubsubCategory/getSubSubCategoryData",
                    type: 'POST',
                    data: {val: val},
                    dataType: 'JSON',
                    success: function (response)
                    {

                        $.each(response, function (index, row) {
                            $('#editedId').val(row._id.$id);
                            $('#Editcatname_0').val(row.subSubCategoryName['en']);
<?php foreach ($language as $val) { ?>
                                $('#Editcatname_<?= $val['lan_id'] ?>').val(row.subSubCategoryName['<?= $val['langCode'] ?>']);
<?php } ?>
                            $('#EditcatDescription_0').val(row.subSubCategoryDesc['en']);
<?php foreach ($language as $val) { ?>
                                $('#EditcatDescription_<?= $val['lan_id'] ?>').val(row.subSubCategoryDesc['<?= $val['langCode'] ?>']);
<?php } ?>

//                            $('#EditcatDescription').val(row.description);
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
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_PASSENGERS_ACTIVATE); ?>);
            } else if (val.length > 1)
            {
                $('#displayData').modal('show');
                $("#display-data").text("Invalid Selection");
            }

        });
        $('#hide').click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            console.log(val);
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("PLease select the sub sub-category");
            } else if (val.length == 1 || val.length >1)
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

                $(".modalPopUpText").text("Are you sure you wish to hide sub sub-category");
            } 

        });
        $("#confirmed1").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
//                    console.log(val);
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/SubsubCategory/hideSubsubCategory",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {
                    if (response.flag == 1) {
                        $('#confirmmodel1').modal('hide');
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/SubsubCategory/datatable_subsubcategory/' + '<?php echo $bid; ?>/1',
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
                                    },
                                "columnDefs": [
                                    {  targets: "_all",
                                        orderable: false 
                                    }
                            ],
                        };
                        table.dataTable(settings);
                    } else {
                        $('#confirmmodel1').modal('hide');
                        $('#displayData').modal('show');
                        $("#display-data").text("Sub Sub Category is already Hidden");
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
                $("#display-data").text("Please select the sub sub-category");
            } else if (val.length == 1)
            {
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

                $("#errorboxdata").text("Are you sure you wish to unhide sub sub-category");
//              

            } else if (val.length > 1)
            {
                $('#displayData').modal('show');
                $("#display-data").text("Invalid Selection");
            }

        });
        $("#confirmed").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/SubsubCategory/unhideSubsubCategory",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {
                    if (response.flag == 1) {
                        $('#confirmmodel').modal('hide');
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/SubsubCategory/datatable_subsubcategory/' + '<?php echo $bid; ?>/2',
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
                                    },
                                "columnDefs": [
                                    {  targets: "_all",
                                        orderable: false 
                                    }
                            ],
                        };
                        table.dataTable(settings);
                    } else if (response.flag == 0) {
                        $('#confirmmodel').modal('hide');
                        $('#displayData').modal('show');
                        $("#display-data").text("Sub Sub Category is already Unhidden");
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
            $('#display-data').text('Cannot reorder , Sub Sub-Category is at the end..!!')
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/SubsubCategory/changeCatOrder",
                type: "POST",
                data: {kliye: 'interchange', curr_id: curr_id, prev_id: prev_id},
                success: function (result) {

                }
            });
            row.prev().insertAfter(row);
            $('#saveOrder').trigger('click');
        }
//        });
    }
    function moveDown(id) {

        var row = $(id).closest('tr');
        var prev_id = row.find('.moveDown').attr('id');
        var curr_id = row.next('tr').find('.moveDown').attr('id');
        if (curr_id == undefined) {
            $('#displayData').modal('show');
            $('#display-data').text('Cannot reorder , Sub Sub-Category is at the end..!!')
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/SubsubCategory/changeCatOrder",
                type: "POST",
                data: {kliye: 'interchange', prev_id: prev_id, curr_id: curr_id},
                success: function (result) {

//                    alert("intercange done" + result);

                }
            });
            row.insertAfter(row.next());
            $('#saveOrder').trigger('click');
        }
//        });
    }


    function validatecat() {
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/superadmin/validate_catname",
            type: "POST",
            data: {catname: $('#catname_0').val()},
            dataType: "JSON",
            success: function (result) {

                $('#catname_0').attr('data', result.msg);
                if (result.count == true) {

                    $("#clearerror").html("Sub Sub-Category name already exists.");
                    $('#catname_0').focus();
                    return false;
                } else if (result.count != true) {
                    $("#clearerror").html("");
                }
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {

        var id = "<?php echo $bid; ?>";
        var status = 1;
        if (status == 1) {
            $('#btnStickUpSizeToggler').show();
            $('#edit').show();
            $('#bdelete').show();
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/SubsubCategory/datatable_subsubcategory/' + id + '/1',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {},
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
                    },
                                "columnDefs": [
                                    {  targets: "_all",
                                        orderable: false 
                                    }
                            ],
        };
        table.dataTable(settings);
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });
         $('#unhide').hide();
         $('#bdelete').hide();
        $('.whenclicked li').click(function () {
            if ($(this).attr('id') == 1) {

                $('#btnStickUpSizeToggler').show();
                $('#edit').show();
                $('#bdelete').hide();
                 $('#hide').show();
                $('#unhide').hide();
                $('#Sedit').hide();
                $('#SbtnStickUpSizeToggler').hide();
                $('#Sdelete').hide();
            } else if ($(this).attr('id') == 2) {

                $('#btnStickUpSizeToggler').hide();
                $('#edit').hide();
                $('#hide').hide();
                $('#unhide').show();
                $('#bdelete').hide();
                $('#Sedit').show();
                $('#SbtnStickUpSizeToggler').show();
                $('#Sdelete').show();
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
                        },
                                "columnDefs": [
                                    {  targets: "_all",
                                        orderable: false 
                                    }
                            ],
            };
            $('.tabs_active').removeClass('active');
            $(this).parent().addClass('active');
            table.dataTable(settings);
        });
    });
    function refreshTableOnCityChange() {

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
            "sAjaxSource": $(".whenclicked li.active").children('a').attr('data'),
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
                    },
                                "columnDefs": [
                                    {  targets: "_all",
                                        orderable: false 
                                    }
                            ],
        };
        table.dataTable(settings);
    }
</script>
<script>
    $('.changeMode').click(function () {

        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        $("#display-data").text("");
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
                    },
                                "columnDefs": [
                                    {  targets: "_all",
                                        orderable: false 
                                    }
                            ],
        };
        $('.tabs_active').removeClass('active');
        $(this).parent().addClass('active');
        table.dataTable(settings);
    });</script>
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
</style>
<!--<div class="page-content-wrapper"style="padding-top: 20px;">
     START PAGE CONTENT 
    <div class="content">

        <div class="brand inline">
            <strong>SUB-CATEGORY</strong>

        </div>
        <div class="inner">
             START BREADCRUMB 
            <ul class="breadcrumb" style="background:white;margin-top: 4%;">
                <li><a class="active" href="<?php echo base_url() ?>index.php?/Category" class="">CATEGORIES</a> </li>
                <li><a class="active" href="<?php echo base_url() ?>index.php?/SubCategory/SubCategory/<?php echo $id; ?>" class="">
<?php
foreach ($business as $cat1) {
    if ((string) $cat1['categoryId'] == $id) {
        $catname = $cat1['name'][0];
    }
}
print_r(strtoupper($catname));
?>
                    </a>
                </li>
                <li><a class="active" href="" class="">
<?php
foreach ($businesssub as $cat1) {
    if ($cat1['id'] == $bid) {
        $catname = $cat1['name'][0];
    }
}
print_r(strtoupper($catname));
?>
                    </a>
                </li>

            </ul>

        </div>           

        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent pageAdj">
                     Nav tabs 
                    <ul class="nav nav-tabs bg-white whenclicked">

                    </ul>
                    <ul class="nav nav-tabs  bg-white">
                        <div class="pull-right m-t-10 cls111"> <button class="btn btn-info" id="edit" >Edit</button></div>
                        <div class="pull-right m-t-10  cls110"> <button class="btn btn-success" id="btnStickUpSizeToggler"><span>Add</button></a></div>
                        <div class="pull-right m-t-10 cls111"> <button class="btn btn-danger" id="bdelete"><span>Delete</span></button></a></div>
                        <div class="pull-right m-t-10 cls111"> <button class="btn btn-warning" id="hide">Hide</button></a></div>
                        <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary" id="unhide">Unhide</button></a></div>



                    </ul>
                     Tab panes 
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                             START PANEL 
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="error-box" id="display-data" style="text-align:center"></div>
                                    <div class="modal fade" id="displayData" role="dialog">
                                        <div class="modal-dialog">                                        
                                             Modal content
                                            <div class="modal-content"> 
                                                <div class="modal-header">
                                                    <span class="modal-title">Alert</span>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 class="error-box modalPopUpText" id="display-data" style="text-align:center"></h5>                                            
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>     

                                    <div class="searchbtn row clearfix pull-right" style="">

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                    </div>

                                </div>
                                <br>
                                <div class="panel-body">
<?php // echo $this->table->generate(); ?>

                                </div>
                            </div>
                             END PANEL 
                        </div>
                    </div>
                </div>

            </div>

        </div>
         END JUMBOTRON 

    </div>
     END PAGE CONTENT 

</div>-->
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;">SUB SUB-CATEGORY</strong>
        </div>


        <!-- Nav tabs --> 

        <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

            <li id="1" data-id="1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor:pointer">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/SubsubCategory/datatable_subsubcategory/<?php echo $bid; ?>/1"
                   data-id="1"><span>Active</span><span class="badge newDriverCount" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id="2" data-id="2" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/SubsubCategory/datatable_subsubcategory/<?php echo $bid; ?>/0" data-id="2"><span>In-active</span> <span class="badge acceptedDriverCount" style="background-color:#3CB371;"></span></a>
            </li>
<!--<div class="pull-right m-t-10 cls111"> <button class="btn btn-info" id="edit" >Edit</button></div>-->
                        <div class="pull-right m-t-10  cls110"> <button class="btn btn-success" id="btnStickUpSizeToggler"><span>Add</button></a></div>
                        <div class="pull-right m-t-10 cls111"> <button class="btn btn-danger" id="bdelete"><span>Delete</span></button></a></div>
                        <div class="pull-right m-t-10 cls111"> <button class="btn btn-warning" id="hide">Deactivate</button></a></div>
                        <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary" id="unhide">Activate</button></a></div>


        </ul>
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="row">

                                    </div>
                                    <div class="pull-left col-sm-12" >
<!--                                            <div class="pull-left"><a href="<?php echo base_url() ?>index.php?/Category" id="back"><i style="font-size: 16px;"class="glyphicon glyphicon-arrow-left">GoBack</i></a> </div>-->
                                        <div class="pull-left">
                                            <ul class="breadcrumb" style="background:white;margin-top: 0%;">
                                                <li><a class="active" href="<?php echo base_url() ?>index.php?/Category" class="">CATEGORIES</a> </li>
                                                <li><a class="active" href="<?php echo base_url() ?>index.php?/SubCategory/SubCategory/<?php echo $id; ?>" class="">
                                                        <?php
                                                        foreach ($business as $cat1) {
                                                            if ((string) $cat1['categoryId'] == $id) {
                                                                $catname = $cat1['name'][0];
                                                            }
                                                        }
                                                        print_r(strtoupper($catname));
                                                        ?>
                                                    </a>
                                                </li>
                                                <li><a class="active" href="" class="">
                                                        <?php
                                                        foreach ($businesssub as $cat1) {
                                                            if ($cat1['id'] == $bid) {
                                                                $catname = $cat1['name'][0];
                                                            }
                                                        }
                                                        print_r(strtoupper($catname));
                                                        ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div cass="col-sm-6">

                                        <div class="searchbtn row clearfix pull-right" >
                                            <div class="pull-right"><input type="text" id="search-table"  style="margin-right:0px !important;" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                        </div>
                                    </div>

                                </div>
                                &nbsp;
                                <div class="panel-body">
                                    <?php echo $this->table->generate(); ?>
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
<div class="modal fade" id="displayData" role="dialog">
    <div class="modal-dialog">                                        
        <!-- Modal content-->
        <div class="modal-content">   
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>  
                <span class="modal-title">ALERT</span>

            </div>
            <div class="modal-body">
                <h5 class="error-box modalPopUpText" id="display-data" style="text-align:center"></h5>                                            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div>                                            
    </div>
</div>

<div class="modal fade stick-up" id="addmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Alert</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxaddmodal" ></div>

                </div>
            </div>


            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-default  pull-right"  data-dismiss="modal" >OK</button>
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

                    <div class="error-box modalPopUpText" id="errorboxdata" style="font-size: large;text-align:center">Are you sure you wish to unhide sub sub-category</div>

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

                    <div class="error-box modalPopUpText" id="errorboxdata1" style="font-size: large;text-align:center"></div>

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

                    <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

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
                    <span class="modal-title">Add Sub Sub-Category</span>
                </div>

                <div class="modal-body">

                    <div id="Category_txt" >
                        <div class="row">
                            <div class="form-group formex">
                                <div class="frmSearch">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label">Name(English) <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">   
                                        <input type="text"   id="catname_0" name="catname[0]" onblur="validatecat()" style="  width: 100%;line-height: 2;" class="catname form-control error-box-class" >
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
                                            <label for="fname" class="col-sm-4 control-label">Name (<?php echo $val['lan_name']; ?>)</label>
                                            <div class="col-sm-6">
                                                <input type="text"  id="catname_<?= $val['lan_id'] ?>" name="catname[<?= $val['lan_id'] ?>]" style="  width: 100%;line-height: 2;" class="catname form-control error-box-class" >
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
                        <div class="form-group" class="formex">
                            <div class="col-sm-1"></div>
                            <label for="fname" class="col-sm-4 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="catDescription_0" name="catDescription[0]"  class="catDescription form-control error-box-class" style="max-width: 100%;"></textarea>
                                <input type="hidden" id="cat_photosamz" name="cat_photosamz" value=""/>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>

                            <div class="row">                    
                                <div class="form-group formex" class="formex">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label">Description (<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <textarea type="text"  id="catDescription_<?= $val['lan_id'] ?>" name="catDescription[<?= $val['lan_id'] ?>]"  class="catDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
                                    </div>
                                </div>
                            </div>
                            <br/>
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
                            <!-- <br/> -->
                            <?php
                        }
                    }
                    ?>

                    <br/>
                    <div class="row">
                        <div class="form-group" class="formex">
                            <div class="col-sm-1"></div>
                            <label for="fname" class="col-sm-4 control-label">Image<span class="MandatoryMarker"> * (max size - 2 mb)</span></label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control error-box-class catImage"  name="cat_photos" id="cat_photos" placeholder=""></div>
                                <input type="hidden" id="imagesProductImg" value="">

                            <img src="" style="width: 35px; height: 35px; display: none;" class="imagesProduct style_prevu_kit">
                        </div>
                    </div>
                    <br/>

                </div>

                <div class="modal-footer">                            
                    <div class="col-sm-5 error-box" id="categoryError"></div>
                    <div class="col-sm-7" >
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
                    <span id='modalHeading' class="modal-title">EDIT SUB SUB-CATEGORY</span>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="editedId" style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>                       

                    <div id="Category_txt" >
                        <div class="row">
                            <div class="form-group formex">
                                <div class="frmSearch">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label"> Name (English) <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">    <!--<div class="col-sm-6">-->  
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
                                            <label for="fname" class="col-sm-4 control-label"> Name (<?php echo $val['lan_name']; ?>) </label>
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
                                            <label for="fname" class="col-sm-4 control-label"> Name (<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
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
                        <div class="form-group" class="formex">
                            <div class="col-sm-1"></div>
                            <label for="fname" class="col-sm-4 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="EditcatDescription_0" name="EditcatDescription[0]"  class="editcatDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="row">                    
                                <div class="form-group formex" class="formex">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label">Description (<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <textarea type="text"  id="EditcatDescription_<?= $val['lan_id'] ?>" name="EditcatDescription[<?= $val['lan_id'] ?>]"  class="editcatDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
                                    </div>
                                </div>
                            </div>
                            <br/>
                        <?php } else { ?>
                            <div class="row" style="display: none;">                    
                                <div class="form-group formex" class="formex">
                                    <div class="col-sm-1"></div>
                                    <label for="fname" class="col-sm-4 control-label">Description (<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <textarea type="text"  id="EditcatDescription_<?= $val['lan_id'] ?>" name="EditcatDescription[<?= $val['lan_id'] ?>]"  class="editcatDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- <br/> -->
                            <?php
                        }
                    }
                    ?>

                    <br/>
                    <div class="form-group" class="formex" style="display:none;">
                        <label for="fname" class="col-sm-4 control-label">    <?php echo "SELECT IF THIS CUSINE IS UPPER LAYER"; ?></label>
                        <div class="col-sm-8">
                            <input type="checkbox" id="checkUpperLayer" value="CheckUpperLayer">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="form-group" class="formex">
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
                    <div class="col-sm-5 error-box" id="editclearerror"></div>                         
                    <div class="col-sm-7" >
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary pull-right" id="editbusiness" >Yes</button>
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



<div id="wait" style="display:none;width:100px;height:100px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url(); ?>pics/spinner.gif' width="64" height="64" /><br>Loading..</div>