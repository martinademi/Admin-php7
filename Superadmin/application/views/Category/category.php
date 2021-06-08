
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet">
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
    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }
    .pageAdj{
        margin-top: -35px;
        padding-top: 15px;
        margin-left: -50px;
        margin-right: -50px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
    .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
    position: absolute;
    margin-left: -20px !important;
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
<script src="<?php echo base_url(); ?>/css/loadingImage.css"></script>
<script>
$(document).ready(function (){
    $(document).ajaxComplete(function () {
        
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

//        $('.catname').keyup(function (event) {
//            this.value = this.value.toUpperCase();
//        });
        var id = '';
        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });


        $('.businesscat').addClass('active');
        $('.businesscat').attr('src', "<?php echo base_url(); ?>/theme/icon/business_mgt_on.png");
        $('.businesscat_thumb').addClass("bg-success");

        $('#btnStickUpSizeToggler').click(function () {
            $("#display-data").text("");
            $("#display-data").text("");
            $('.catname').val("");
            $('.storeCategory').val("");
            $('#categoryError').text("");

            $('.catDescription').val("");
            $('#cat_photos').val("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $('#modalHeading').html("ADD CATEGORY");
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
            $(".modalPopUpText").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            id = '';
            id = val;
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select a category");
            } else if (val.length == 1 || val.length > 1)
            {
                $(".modalPopUpText").text("Do you wish to delete the selected categories ?");
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
//                var condition = {MONGO_id: val};
                $("#confirmed").click(function () {

                    $.ajax({
                        url: "<?php echo base_url('index.php?/Category') ?>/operationCategory/delete",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (response)
                        {

                            $('.close').trigger("click");
                            $('#big_table_processing').show();
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Category/operationCategory/table/' + status,
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "columns": [
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,

                                    // null,

                                    null,
                                    null,

                                    null
                                ],
                                "oLanguage": {
                                },
                                "fnInitComplete": function () {
                                    $('#big_table').fadeIn('slow');
                                    $('#big_table_processing').hide();
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

       $(document).on('change', '.editcatImage', function () {
           
           var fieldID = 1;
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
                        
                        if(fieldID == 0){
                           $("#imagesProductImg").val(result.fileName) 
                           $(".imagesProduct").attr('src',result.fileName)
                           $(".imagesProduct").css('display','inline'); 
                        }else if(fieldID == 1){
                            $("#editimagesProductImg").val(result.fileName) 
                           $(".editimagesProduct").attr('src',result.fileName)
                           $(".editimagesProduct").css('display','inline'); 
                            

                        }
                        
                        $(document).ajaxComplete(function () {
                            if(fieldID < 3)
                            $("#insert").prop("disabled",false)
                            else
                            $("#editbusiness").prop("disabled",false)                           
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
            
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            var storeCategory = [];
            
            
            
            $(".storeCategory option:selected").each(function () {
             

                var $this = $(this);
               if ($this.length) {
                var selText = $this.text();
                var selVal = $this.val();

                 var storeDetail = {
                    storeCategoryId: selVal,
                    storeCategoryName: selText 
                    }
                    storeCategory.push(storeDetail);
                }
            });
            $('#storeCategory').val(storeCategory);
           

            if($('#storeCategory').val() == "" || $('#storeCategory').val() == null){
                 $('#categoryError').text("Please select store category type");
            }
            else if ($('#catname_0').val() == "" || $('#catname_0').val() == null)
            {
                $("#categoryError").text("Please enter the category name");
            } else if ($("#cat_photos").val() == "" || $("#cat_photos").val() == null) {
                $("#categoryError").text("Please select the image");
            } else if (val.length == 1 || val.length > 1) {
                $('#displayData').modal('show');
                $('#display-data').text('Invalid Selection')
            } else {
                var imgUrl = '';
                var form_data = new FormData(); 
                var form_data1 = new FormData();
                var catname = new Array();
                var catDescription = new Array();
                $(".catname").each(function () {
                    catname.push($(this).val());
                    form_data1.append('name[]', $(this).val());
                });

                $(".catDescription").each(function () {
                    catDescription.push($(this).val());
                    form_data1.append('description[]', $(this).val());
                });

                var visibility = parseInt(1);
                var cat_photos = $("#cat_photos").val();
              
                var file_data = $('#cat_photos').prop('files')[0];
                var fileName = file_data.name;
                form_data.append('OtherPhoto', file_data);
                form_data1.append('visibility', visibility);
                form_data1.append('storeCategory', JSON.stringify(storeCategory));
                form_data.append('type', 'uploadImage');
                form_data.append('Image', 'Image');
                form_data.append('folder', 'first_level_category');

                var imgUrl = '';
                $(document).ajaxStart(function () {
                    $("#wait").css("display", "block");
                });

               
                            imgUrl=$("#imagesProductImg").val();
                            form_data1.append('imageUrl', imgUrl);

                            $.ajax({
                                url: "<?php echo base_url('index.php?/Category/operationCategory') ?>/insert",
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
                                            $('#addmodal').modal('show');
                                            $('.modalPopUpText').text('Category has been added successfully..');

                                        }
                                        $('#big_table_processing').show();
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
                                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Category/operationCategory/table/1',
                                            "bJQueryUI": true,
                                            "sPaginationType": "full_numbers",
                                            "iDisplayStart ": 20,
                                            "columns": [
                                                null,
                                                null,
                                                null,
                                                null,
                                                null,
                                                // null,
                                                null,
                                                null,
                                                null
                                            ],
                                            "oLanguage": {
                                            },
                                            "fnInitComplete": function () {
                                                $('#big_table').fadeIn('slow');
                                                $('#big_table_processing').hide();
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
                                        $('.modalPopUpText').text('Category already exists..');
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


        $('#editbusiness').click(function () {

            $("#display-data").text("");
            var form_data = new FormData();
            var val = $(this).val();
            $('.editclearerror').text("");
            var editcatname = new Array();
            var editcatnameDesc = new Array();
            $(".Editcatname").each(function () {
                form_data.append('name[]', $(this).val());
                editcatname.push($(this).val());

            });

            $(".EditcatDescription").each(function () {
                form_data.append('description[]', $(this).val());
                editcatnameDesc.push($(this).val());

            });

            var editStoreCategory = [];
            
            
            
            $(".editStoreCategory option:selected").each(function () {
             

                var $this = $(this);
               if ($this.length) {
                var selText = $this.text();
                var selVal = $this.val();

                 var editStoreDetail = {
                    storeCategoryId: selVal,
                    storeCategoryName: selText 
                    }
                    editStoreCategory.push(editStoreDetail);
                }
            });
            $('#editStoreCategory').val(editStoreCategory);

            var editcatpic = $("#Editcat_photos").val();

            var file_data = $('#Editcat_photos').prop('files')[0];
            form_data.append('cat_photos', file_data);
            form_data.append('storeCategory', JSON.stringify(editStoreCategory));
            form_data.append('type', 'uploadImage');
            form_data.append('Image', 'Image');
            form_data.append('foldername', 'first_level_category');
            var UL = '0';
            if ($('#checkUpperLayer').prop('checked') == true) {
                UL = '1';
            }
            form_data.append('catcheckUpperLayer', UL);
            form_data.append('editId', val);
            if ($(".Editcatname").val() == "" || $(".Editcatname").val() == null || $(".Editcatname").val() == '' || $(".Editcatname").val() == 0) {

                $("#editclearerror").text("Please enter the Category name");
            } else {

                var imgUrl = '';
                var img = '';
                console.log(form_data);
                if (file_data) {
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
                                form_data.append('imageUrl', img);

                                $.ajax({
                                    url: "<?php echo base_url('index.php?/Category/operationCategory') ?>/edit",
                                    type: 'POST',
                                    data: form_data,
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
                        url: "<?php echo base_url('index.php?/Category/operationCategory') ?>/edit",
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



//        $('.editICON').click(function () {
        $(document).on('click', '.editICON', function () {
            $("#display-data").text("");
       
            $(".editStoreCategory option:selected").prop("selected", false);
            $(".editStoreCategory").multiselect('refresh')

            $('#modalHeading').html("EDIT CATEGORY");
//            var val = $('.checkbox:checked').map(function () {
//                return this.value;
//            }).get();
            var val = $(this).val(); 
            $('#editbusiness').val(val);
            if (val)
            {
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Category/operationCategory/get",
                    type: 'POST',
                    data: {val: val},  
   
                    dataType: 'JSON',

                    success: function (response)
                    {
                        $.each(response, function (index, row) {
                            $('#editedId').val(row._id.$oid);
                            $('#Editcatname_0').val(row.categoryName['en']);
<?php foreach ($language as $val) { ?>
                                $('#Editcatname_<?= $val['lan_id'] ?>').val(row.categoryName['<?= $val['langCode'] ?>']);
<?php } ?>
                            $('#EditcatDescription_0').val(row.categoryDesc['en']);
<?php foreach ($language as $val) { ?>
                                $('#EditcatDescription_<?= $val['lan_id'] ?>').val(row.categoryDesc['<?= $val['langCode'] ?>']);
<?php } ?>

                            if (row.imageUrl) {
                                $('#Edit_photo').show();
                                $('#Edit_photo').attr('href', row.imageUrl);

                                $(".editimagesProduct").attr('src', row.imageUrl)
                                $(".editimagesProduct").css('display','inline'); 

                            } else
                                $('#Edit_photo').hide();
                                $.each( row.storeCategory, function(index,val){
                                    var storeCategorydata=val.storeCategoryId;
                                    var res = storeCategorydata.split(",");                      
                                $('.editStoreCategory').multiselect('select', res);
                                });   
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
                $("#errorboxdatas").text("Are you sure you wish to activate the category ?");

            } else if (val.length > 1)
            {
                $('#displayData').modal('show');
                $("#display-data").text("Invalid selection");
            }

        });


        $('#hide').click(function () {
            $("#display-data").text("");
            $(".modalPopUpText").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            id = val;
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select a category");
            } else if (val.length == 1 || val.length > 1)
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#hideModal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#hideModal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $(".modalPopUpText").text("Are you sure you wish to hide category");



            } 

        });


        $("#btnHide").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Category/operationCategory/hide",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {
                    if (response.flag == 1) {
                        $(".close").trigger("click");
                        $('#big_table_processing').show();
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Category/operationCategory/table/1',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "columns": [
                                null,
                                null,
                                null,
                                null,
                               // null,

                                null,

                                null,
                                null,

                                null
                            ],
                            "oLanguage": {
                            },
                            "fnInitComplete": function () {
                                $('#big_table').fadeIn('slow');
                                $('#big_table_processing').hide();
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
                        $('#hideModal').modal('hide')
                        $('#displayData').modal('show');
                        $('#display-data').text('Category is already Hidden')

                    }
                }
            });
        });

        $('#unhide').click(function () {
            $("#display-data").text("");
            $(".modalPopUpText").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select a category");
} else if (val.length == 1 || val.length > 1)
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#unhideModal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show');
                } else {
                    $('#unhideModal').modal('show');
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $(".modalPopUpText").text("Are you sure you wish to unhide category");



            } 

        });

        $("#btnUnhide11").click(function () {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Category/operationCategory/unhide",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {
                    if (response.flag == 1) {
                        $(".close").trigger("click");
                        $('#big_table_processing').show();
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Category/operationCategory/table/0',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "columns": [
                                null,
                                null,
                                null,
                                //null,
                                null,

                                null,

                                null,
                                null,

                                null
                            ],
                            "oLanguage": {
                            },
                            "fnInitComplete": function () {
                                $('#big_table').fadeIn('slow');
                                $('#big_table_processing').hide();
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
                        $('#displayData').modal('show');
                        $("#display-data").text("Category is already Unhidden");
                        $('#unhideModal').modal('hide');
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
            $('#display-data').text('Cannot reorder , Category is at the end..!!')
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Category/operationCategory/order",
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
            $('#display-data').text('Cannot reorder , Category is at the end..!!')
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/Category/operationCategory/order",
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
            url: "<?php echo base_url() ?>index.php?/Category/operationCategory/validate",
            type: "POST",
            data: {catname: $('#catname_0').val()},
            dataType: "JSON",
            success: function (result) {

                // alert();
//                alert(result.count);
                console.log(result.count);
                $('#catname_0').attr('data', result.msg);

                if (result.count == true) {

                    $("#clearerror").html("Category name already exists.");
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


        var status = 1;
        if (status == 1) {
            $('#btnStickUpSizeToggler').show();
            $('#edit').show();
            $('#bdelete').show();
        }

        $('#big_table_processing').show();
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Category/operationCategory/table/' + status,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
//            "columns": [
//                null,
//                null,
//                null,
//                null,
//                null,
//
//                null,
//
//                null,
//                null,
//
//                null
//            ],
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
                $('#big_table_processing').hide();
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
                $('#bdelete').hide();
                 $('#unhide').show();
                $('#hide').hide();
                $('#Sedit').show();
                $('#SbtnStickUpSizeToggler').show();
                $('#Sdelete').show();
            }
        });
        $('.changeMode').click(function () {

            var table = $('#big_table');
            $('#big_table').fadeOut('slow');
            $('#big_table_processing').show();
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
//                "columns": [
//                    null,
//                    null,
//                    null,
//                    null,
//
//                    {"width": "30%"},
//
//                    null,
//                    null,
//                    null
//                ],
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    $('#big_table').fadeIn('slow');
                    $('#big_table_processing').hide();
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
        $('#big_table_processing').show();
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
//            "columns": [
//                null,
//                null,
//                null,
//                null,
//
//                {"width": "30%"},
//
//                null,
//                null,
//                null
//            ],
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
                $('#big_table_processing').hide();
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

        $('#big_table_processing').toggle();

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
                $('#big_table_processing').toggle();
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



</script>
<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"><?php echo $this->lang->line('PRODUCT_CATEGORIES'); ?></strong>
        </div>
        <!-- Nav tabs --> 

        <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

            <li id="1" data-id="1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor:pointer">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/Category/operationCategory/table/1
" data-id="1"><span><?php echo $this->lang->line('Active'); ?></span><span class="badge newDriverCount" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id="2" data-id="2" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/Category/operationCategory/table/0" data-id="2"><span><?php echo $this->lang->line('In_active'); ?></span> <span class="badge acceptedDriverCount" style="background-color:#3CB371;"></span></a>
            </li>


             <!--<div class="pull-right m-t-10 cls111"> <button class="btn btn-info " id="edit">Edit</button></div>-->
                        <div class="pull-right m-t-10  cls110"> <button class="btn btn-info" id="btnStickUpSizeToggler"><span><?php echo $this->lang->line('Add'); ?></span></button></a></div>
                        <!--<div class="pull-right m-t-10 cls111"> <button class="btn btn-danger" id="bdelete" ><span>Delete</button></a></div>-->
                        <div class="pull-right m-t-10 cls111"> <button class="btn btn-warning" id="hide"><?php echo $this->lang->line('Deactivate'); ?></button></a></div>
                        <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary" id="unhide"><?php echo $this->lang->line('Activate'); ?></button></a></div>


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
<!--                                        <div class="cs-loader">
                                            <div class="cs-loader-inner" >
                                                <label class="loaderPoint" style="color:#10cfbd">●</label>
                                                <label class="loaderPoint" style="color:red">●</label>
                                                <label class="loaderPoint" style="color:#FFD119">●</label>
                                                <label class="loaderPoint" style="color:#4d90fe">●</label>
                                                <label class="loaderPoint" style="color:palevioletred">●</label>
                                            </div>
                                        </div>-->
                                    </div>
                                    <div cass="col-sm-6">
                                        <div class="searchbtn row clearfix pull-right" >
                                            <div class="pull-right"><input type="text" id="search-table"  style="margin-right:0px !important;" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>
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
    <!-- END PAGE CONTENT -->

<div class="modal fade" id="displayData" role="dialog">
    <div class="modal-dialog">                                        
        <!-- Modal content-->
        <div class="modal-content">   
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>  
                <span class="modal-title"><?php echo $this->lang->line('ALERT'); ?></span>

            </div>
            <div class="modal-body">
                <h5 class="error-box modalPopUpText" id="display-data" style="text-align:center"></h5>                                            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Ok'); ?></button>
            </div>
        </div>                                            
    </div>
</div>

<div class="modal fade stick-up" id="addmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title"><?php echo $this->lang->line('Success_Alert'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="boxaddmodal"><?php echo $this->lang->line('Category_Added_successfully'); ?></div>

                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-default pull-right" id="confirmeds1" data-dismiss="modal" ><?php echo $this->lang->line('OK'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="hideModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <span class="modal-title"><?php echo $this->lang->line('Alert'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="boxhidemodal"><?php echo $this->lang->line('Are_you_sure_you_want_to_hide_the_category'); ?></div>

                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-success pull-right" id="btnHide" data-dismiss="modal" ><?php echo $this->lang->line('Yes'); ?></button>
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
                <span class="modal-title"><?php echo $this->lang->line('Alert'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdata" ></div>

                </div>
            </div>


            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('Cancel'); ?></button></div>
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" ><?php echo $this->lang->line('Yes'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="unhideModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"><?php echo $this->lang->line('Alert'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdata" ></div>

                </div>
            </div>


            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-8" >
                        <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('Cancel'); ?></button></div>
                        <button type="button" class="btn btn-primary pull-right" id="btnUnhide11" ><?php echo $this->lang->line('Yes'); ?></button>
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

                    <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center"><?php echo $this->lang->line('Delete'); ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-default pull-right" id="confirmeds" ><?php echo $this->lang->line('yes'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">



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

                
                    <br/><br/>
                    <div id="Category_txt" >

            <!-- stoer category start -->
                    <div class="row">
                            <div class="form-group formex">
                                <div class="frmSearch">
                                    <label for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('Store_Category'); ?> <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">    
                                    <div class="multiselect">
                                                <div class="selectBox"  style="width: 102%;">
                                                    <select class="storeCategory multiple form-control" name="storeCategory[]" multiple="multiple">
                                                        <?php
														
														 if(count($language) < 1){
                                                        foreach ($storeCategory as $result) {
															
																echo "<option  value=" . $result['_id']['$oid'] . "  data-name='" . $result['storeCategoryName']['en'] . "'>" . $result['storeCategoryName']['en'] . "</option>";
															
                                                        }
                                                    }
                                                    else{
                                                        foreach ($storeCategory as $result) {
                                                            $catData=$result['storeCategoryName']['en'];
                                                            foreach($language as $lngData){
                                                            $lngcode=$lngData['langCode'];
                                                            $lngvalue= ($result['storeCategoryName'][$lngcode]=='') ? "":$result['storeCategoryName'][$lngcode];
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
                                            <label id="colors-error" class="error" style="display:none"><?php echo $this->lang->line('This_field_is_required'); ?></label>
                                    </div>

                                </div>
                            </div>
                        </div> 
                        <br/>
                        <!-- stoer category end -->

                        <div class="row">
                            <div class="form-group formex">
                                <div class="frmSearch">
                                    <label for="fname" class="col-sm-4 control-label">Name(English) <span class="MandatoryMarker">*</span></label>
                                    <div class="col-sm-6">    
                                        <input type="text"   id="catname_0" name="catname[0]" onblur="validatecat()" style="  width: 100%;line-height: 2;" class="catname form-control error-box-class" >
                                        <input type="hidden" id="storeCategory" value="" />
                                        <input type="hidden" name="storeCategoryId" id="storeCategoryId" value="" />
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
                                <label for="fname" class="col-sm-4 control-label">Description(English)</label>
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
                                            <label for="fname" class="col-sm-4 control-label">Description(<?php echo $val['lan_name']; ?>) </label>
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
                                <label for="fname" class="col-sm-4 control-label">Image<span class="MandatoryMarker"> * (max size - 2 mb)</span></label>
                                <div class="col-sm-6">
                                    <input type="file" class="form-control error-box-class catImage"  name="cat_photos" id="cat_photos"  placeholder=""></div>

                                    <input type="hidden" id="imagesProductImg" value="">

                                    <img src="" style="width: 35px; height: 35px; display: none;" class="imagesProduct style_prevu_kit">
                            </div>
                        </div>
                    </div>
                    <br/>
                    
                                    <br/><br/><br/><br/><br/>
                    <div class="modal-footer">                            
                        <div class="col-sm-6 error-box" id="categoryError"></div>

                        <div class="col-sm-6" >
                            <button type="button" class="btn btn-primary pull-right" id="insert" ><?php echo $this->lang->line('Add'); ?></button>
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





<div class="modal fade stick-up" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title"><?php echo $this->lang->line('Edit_Category'); ?></span>
            </div>

            <div class="modal-body">

                <input type="hidden" id="editedId" style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>                       
                

               
                <div id="Category_txt" >
                <!-- store category start -->
                <div class="row">
                        <div class="form-group formex">
                            <div class="frmSearch">
                                <div class="col-sm-1"></div>
                                <label for="fname" class="col-sm-4 control-label"> <?php echo $this->lang->line('Store_Category'); ?><span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-6">    <!--<div class="col-sm-6">-->  
                                <div class="multiselect">
                                                <div class="selectBox"  style="width: 102%;">
                                                    <select class="editStoreCategory multiple form-control" name="editStoreCategory[]" multiple="multiple">
                                                        <?php
														
														 if(count($language) < 1){
                                                        foreach ($storeCategory as $result) {
															
																echo "<option  value=" . $result['_id']['$oid'] . "  data-name='" . $result['storeCategoryName']['en'] . "'>" . $result['name']['en'] . "</option>";
															
                                                        }
                                                    }
                                                    else{
                                                        foreach ($storeCategory as $result) {
                                                            $catData=$result['storeCategoryName']['en'];
                                                            foreach($language as $lngData){
                                                            $lngcode=$lngData['langCode'];
                                                            $lngvalue= ($result['storeCategoryName'][$lngcode]=='') ? "":$result['storeCategoryName'][$lngcode];
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
                                            <label id="colors-error" class="error" style="display:none"><?php echo $this->lang->line('This_field_is_required'); ?></label>
                                </div>

                            </div>
                        </div>  
                    </div>
                    <br/>

                    <!-- store category end -->
                    <div class="row">
                        <div class="form-group formex">
                            <div class="frmSearch">
                                <div class="col-sm-1"></div>
                                <label for="fname" class="col-sm-4 control-label"> Name(English) <span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-6">    <!--<div class="col-sm-6">-->  
                                    <input type="text"   id="Editcatname_0" name="Editcatname[0]" style="line-height: 2;max-width: 100%;" class="Editcatname form-control error-box-class" >
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
                <div class="row"></div>

                <div class="categoryDescription">
                    <div class="row">
                        <div class="form-group" class="formex">
                            <div class="col-sm-1"></div>
                            <label for="fname" class="col-sm-4 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="EditcatDescription_0" name="EditcatDescription"  class=" EditcatDescription form-control error-box-class" style="max-width: 100%;"> </textarea>
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
                                        <label for="fname" class="col-sm-4 control-label">Description(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <textarea type="text"  id="EditcatDescription_<?= $val['lan_id'] ?>" name="EditcatDescription[<?= $val['lan_id'] ?>]" style="line-height: 2; max-width: 100%;" class="EditcatDescription form-control error-box-class" ></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        <?php } else { ?> 
                            <div class="row">
                                <div class="form-group formex"  style="display: none;">
                                    <div class="frmSearch">
                                        <div class="col-sm-1"></div>
                                        <label for="fname" class="col-sm-4 control-label">Description(<?php echo $val['lan_name']; ?>) <span class="MandatoryMarker">*</span></label>
                                        <div class="col-sm-6">
                                            <textarea type="text"  id="EditcatDescription_<?= $val['lan_id'] ?>"  name="EditcatDescription[<?= $val['lan_id'] ?>]" style="line-height: 2; max-width: 100%;" class="EditcatDescription form-control error-box-class" ></textarea>
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
                <div class="row"></div>
                <div class="categoryImage">
                    <div class="row">
                        <div class="form-group" class="formex">
                            <div class="col-sm-1"></div>
                            <label for="fname" class="col-sm-4 control-label">Image<span class="MandatoryMarker">  (max size - 2 mb)</span></label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control error-box-class editcatImage"  name="Editcat_photos" id="Editcat_photos" value="" placeholder="">

                                <img src="" style="width: 35px; height: 35px; display: none;" class="editimagesProduct style_prevu_kit">

                                <input type="hidden" id="Edit_photos" name="Edit_photos"  class="form-control error-box-class">

                                <input type="hidden" id="editimagesProductImg" value="">

                            

                                <!-- <a target="_blank" id="Edit_photo" name="Edit_photo" style="display:none;" href="" >view</a>                               -->

                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <div class="col-sm-4 error-box" id="editclearerror"></div>

                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"><button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('Cancel'); ?></button></div>
                    <button type="button" class="btn btn-primary pull-right" id="editbusiness" ><?php echo $this->lang->line('Save'); ?></button>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
            </div>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>  
</div>

<div id="wait" style="display:none;width:100px;height:100px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url(); ?>pics/spinner.gif' width="64" height="64" /><br><?php echo $this->lang->line('Loading'); ?></div>

<script>
    $('.storeCategory').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '100%',
        maxHeight: 300,
    });

    $('.editStoreCategory').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '100%',
        maxHeight: 300,
    });
</script>  


