
<?php if ($this->session->flashdata('message')) { ?>
    <div align="center" id="flashdata" class="alert alert-danger">      
        <?php echo $this->session->flashdata('message') ?>
    </div>
<?php } ?>
<style>
    .btn{
        border-radius: 25px !important;
    }
    .dataTables_scrollHead{
        margin-bottom: -52px !important;
    }

    span.RemoveMore{
        margin-left: 8px;cursor: pointer;
    }

    .attributesData,.editattributesData{
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        display: inline-block;
        padding: 4px 6px;
        color: #555;
        vertical-align: middle;
        border-radius: 4px;
        max-width: 100%;
        line-height: 22px;
        cursor: text;
        width: 100%;
    }
    span.tag {
        padding:9px 10px;
        background-color: #5bc0de;
        font-size:10px;
    }


    .label-info {
        background-color: #5bc0de;
    }


    .startDesc{
        height: 28px;
        padding: 6px;
        display: inline-flex;
        margin: 0px 1px 1px;
        font-weight: 600;
        /*background: #5bc0de;*/
        border: 1px solid;
        border-radius: 4px;
        /*width: 100%;*/
        max-width:400px
    }
    .inputDesc {
        width: 100%;
        min-width:15px!important;
        max-width:400px!important;
        border: none;
    }
    td span {
        line-height:0px !important;
    }
    .tag:after{
        display: none;
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
    var currentTab = 1;
    var counter = 0;
    $(document).ready(function () {

        $('#big_table_processing').show();
        $('.cs-loader').show();
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/sizeController/size_details/1',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
                $('#big_table_processing').hide();
                $('.cs-loader').hide();
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
        // search box for table

        $('#add').show();
        $('#edit').show();
        $('#activate').hide();
        $('#deactivate').show();

        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });
        $('.error-box-class').change(function () {
            $('.error-box').text('');
        });

        $('#category').on('change', function () {
            var val = $(this).val();
            $('#subCategory').load("<?php echo base_url('index.php?/SubCategory') ?>/getSubCategoryData", {val: val});
        });
        $('#subCategory').on('change', function () {
            var val = $(this).val();
            $('#subSubCategory').load("<?php echo base_url('index.php?/SubsubCategory') ?>/getSubsubCategoryDataList", {val: val});
        });

        $('#editcategory').on('change', function () {
            var val = $(this).val();
            $('#editsubCategory').load("<?php echo base_url('index.php?/SubCategory') ?>/getSubCategoryData", {val: val});
        });
        $('#editsubCategory').on('change', function () {
            var val = $(this).val();
            $('#editsubSubCategory').load("<?php echo base_url('index.php?/SubsubCategory') ?>/getSubsubCategoryDataList", {val: val});
        });

//        $('#addAttributes').click(function ()
//        {
//            if ($('#attributes').val() == '')
//            {
//                $('#alertForNoneSelected').modal('show');
//                $("#display-data").text('Input field should not be empty');
//            } else {
//                counter += 1;
//                $('.attributesData').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#' + $(this).attr('data-id')).val() + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');
//                $('.attributesData').append('<span class="startDesc" id="' + $(this).attr('id') + counter + '"><input name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><input type="button" value="&#10008"  data-id="' + $(this).attr('id') + counter + '" class="RemoveMore"></span>');
//                $('#attributes').val('');
//
//            }
//        });
//        $('#editaddAttributes').click(function ()
//        {
//            if ($('#editattributes').val() == '')
//            {
//                $('#alertForNoneSelected').modal('show');
//                $("#display-data").text('Input field should not be empty');
//            } else {
//                counter += 1;
//                $('.editattributesData').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#' + $(this).attr('data-id')).val() + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');
//                $('.attributesData').append('<span class="startDesc" id="' + $(this).attr('id') + counter + '"><input name="' + $(this).attr('data-id') + '[]" class="inputDesc"  type="text"  value="' + $('#' + $(this).attr('data-id')).val() + '"><input type="button" value="&#10008"  data-id="' + $(this).attr('id') + counter + '" class="RemoveMore"></span>');
//                $('#editattributes').val('');
//
//            }
//        });

        $(document).on('click', '.RemoveMore', function ()
        {
            $('#' + $(this).attr('data-id')).remove();
        });

        $('#add').click(function () {
            $('.error-box-class').val('');
             $('.error-box').text('');
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                tabURL = $('li.active').children("a").attr('data');

                $("#display-data").text("");
                var val = $('.checkbox:checked').map(function () {
                    return this.value;
                }).get();

                if (val.length == 0) {
					$('.attributesData').empty();
                    $('#addSize').modal('show');
                } else {
                    $('#alertForNoneSelected').modal('show');
                    $("#display-data").text("Invalid Selection");

                }
            } else {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Invalid Selection...');
            }
        });

        $("#yesAdd").click(function () {

            $('#yesAdd').prop('disabled', false);

            var sizeName = new Array();
            $(".sizename").each(function () {
                    sizeName.push($(this).val());
            });
            var categoryId = $('#category option:selected').val();
            var subCategoryId = $('#subCategory option:selected').val();
            var subSubCategoryId = $('#subSubCategory option:selected').val();

            var categoryName = $('#category option:selected').attr('data-name');
            var subCategoryName = $('#subCategory option:selected').attr('data-name');
            var subSubCategoryName = $('#subSubCategory option:selected').attr('data-name');
            $('#firstCategoryName').val(categoryName);
            $('#secondCategoryName').val(subCategoryName);
            $('#thirdCategoryName').val(subSubCategoryName);

            var sizeDesc = new Array();
            $(".sizeDescription").each(function () {
                   sizeDesc.push($(this).val());
            });

            var sizeAttr = new Array();
            $('.en_Attributes').each(function () {
                sizeAttr.push($(this).val());
            });
            var objen = {};

<?php
foreach ($language as $lang) {
    if ($lang['Active'] == 1) {
        ?>
                    var arr = new Array();
                    $('.<?php echo $lang['langCode']; ?>_Attributes').each(function () {
                        arr.push($(this).val());
                    });
                    objen['<?php echo $lang['langCode']; ?>'] = arr;
        <?php
    }
}
?>
            objen['en'] = sizeAttr;
            console.log(objen);
            var sName = $('#name_0').val();
            if (sName == '' || sName == null) {
                $('#name_0').focus();
                $("#text_name").text('<?php echo $this->lang->line('error_name'); ?>');
            } else if (categoryId == '' || categoryId == null) {
                $('#category').focus();
                $("#text_category").text('<?php echo $this->lang->line('error_category'); ?>');
            } else if (arr.length <= 0) {
                $('#attributes').focus();
                $("#text_attr").text('<?php echo $this->lang->line('error_attr'); ?>');
            } else {

                $('#yesAdd').prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/sizeController') ?>/addSizeGroup",
                    type: "POST",
                    dataType: 'json',
                    data: {sizeName: sizeName, categoryId: categoryId, categoryName: categoryName,
                        subCategoryId: subCategoryId, subCategoryName: subCategoryName,
                        subSubCategoryId: subSubCategoryId, subSubCategoryName: subSubCategoryName,
                        sizeDesc: sizeDesc, sizeAttr: objen},
                    success: function (result) {
                        console.log(result)
                        if (result.flag == 1) {
                            $('#addSize').modal('hide');
                            window.location.reload();
                        } else if (result.flag == 0) {

                            $('#errorModal').modal('show')
                            $(".modalPopUpText").text('Size group is already exist');
                            $('#yesAdd').prop('disabled', false);
                        }
                    }

                });
                $(".error-box-class").val("");
            }

        });

        $('#edit').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length < 0 || val == '') {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_select'); ?>');
            } else if (val.length > 1) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_onceselect'); ?>');
            }
            if (val.length == 1) {
                $.ajax({
                    url: "<?php echo base_url('index.php?/sizeController') ?>/getSize",
                    type: "POST",
                    dataType: 'json',
                    data: {Id: $('.checkbox:checked').val()},
                    success: function (result) {

                        console.log(result.data)
                        $('#editname_0').val(result.data.name['en']);
<?php foreach ($language as $val) { ?>
                            $('#editname_<?= $val['lan_id'] ?>').val(result.data.name['<?= $val['langCode'] ?>']);
<?php } ?>
                        $('#editcategory').val(result.data.categoryId);

                        $('#editsubCategory').load("<?php echo base_url('index.php?/sizeController') ?>/getSubCategoryData", {categoryId: result.data.categoryId, subCategoryId: result.data.subCategoryId});
                        $('#editsubCategory').val(result.data.subCategoryId);

                        $('#editsubSubCategory').load("<?php echo base_url('index.php?/sizeController') ?>/getSubsubCategoryDataList", {subCategoryId: result.data.subCategoryId, subSubCategoryId: result.data.subSubCategoryId});
                        $('#editsubSubCategory').val(result.data.subSubCategoryId);

                        $('#editfirstCategoryName').val(result.data.categoryName);
                        $('#editsecondCategoryName').val(result.data.subCategoryName);
                        $('#editthirdCategoryName').val(result.data.subSubCategoryName);

//                        if (result.data.sizeDesc) {
                        $('#editdesc_0').val(result.data.description['en']);
<?php foreach ($language as $val) { ?>
                            $('#editdesc_<?= $val['lan_id'] ?>').val(result.data.description['<?= $val['langCode'] ?>']);
<?php } ?>
//                        }
                        console.log(result.data.sizeAttr);
                        
                        $.each(result.data.sizeAttr, function (index, value) {
                           $('.editattributesData').append('<span class="tag label label-info" id="editaddAttributes' + counter + '">' + value.sAttrLng.en+'('+value.sAttrLng.ar+')' + '<input  style="display:none;" name="editattributes[]" class="inputDesc attrId"  type="text"  value="' + value.attrId.$oid.toString() + '"><input  style="display:none;" name="editattributes[]" class="inputDesc en_Attributes"  type="text"  value="' + value.sAttrLng.en + '"><input  style="display:none;" name="editattributes[]" class="inputDesc ar_Attributes"  type="text"  value="' + value.sAttrLng.ar + '"><span class="RemoveMore" data-id="editaddAttributes' + counter + '" style="">x</span></span>');
                          // $('.editattributesData').append('<span class="tag label label-info" id="editaddAttributes' + counter + '">' + value.en+'('+value.ar+')' + '<input  style="display:none;" name="editattributes[]" class="inputDesc en_Attributes"  type="text"  value="' + value.en + '"><input  style="display:none;" name="editattributes[]" class="inputDesc ar_Attributes"  type="text"  value="' + value.ar + '"><span class="RemoveMore" data-id="editaddAttributes' + counter + '" style="">x</span></span>');
                            counter++;
                        });

                        $('#editSizeModal').modal('show');

                    }
                });
            } else {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Invalid Selection...');
            }

        });

        $("#yesEdit").click(function () {
            $(".error-box").text("");

            $(this).prop('disabled', false);

            var sizeName = new Array();
            $(".editsizename").each(function () {
                    sizeName.push($(this).val());
            });
            var categoryId = $('#editcategory option:selected').val();
            var subCategoryId = $('#editsubCategory option:selected').val();
            var subSubCategoryId = $('#editsubSubCategory option:selected').val();

            var categoryName = $('#editcategory option:selected').attr('data-name');
            if (subCategoryId != '')
                var subCategoryName = $('#editsubCategory option:selected').attr('data-name');
            else
                subCategoryName = '';

            if (subSubCategoryId != '')
                var subSubCategoryName = $('#editsubSubCategory option:selected').attr('data-name');
            else
                subSubCategoryName = '';

            $('#editfirstCategoryName').val(categoryName);
            $('#editsecondCategoryName').val(subCategoryName);
            $('#editthirdCategoryName').val(subSubCategoryName);

            var sizeDesc = new Array();
            $(".editsizeDescription").each(function () {
                    sizeDesc.push($(this).val());
            });

//            var sizeAttr = new Array();
//            $(".inputDesc").each(function () {
//                if ($(this).val().trim() != '' && $(this).val().trim() != null)
//                    sizeAttr.push($(this).val());
//            });
var objen = {};
// var objen = [];
var attrId = new Array();
$('.attrId').each(function () {
                // console.log("pass")
               attrId.push($(this).val());
                objen['attrId']=attrId;
            });
var sizeAttr = new Array();
             $('.en_Attributes').each(function () {
                // console.log("pass")
                sizeAttr.push($(this).val());
                objen['en']=sizeAttr;
            });



<?php
foreach ($language as $lang) {
    if ($lang['Active'] == 1) {
        ?>
                    var arr = new Array();
                    $('.<?php echo $lang['langCode']; ?>_Attributes').each(function () {
                        arr.push($(this).val());
                    });
                    //console.log(arr)// having ar data
                    objen['<?php echo $lang['langCode']; ?>'] = arr;
        <?php
    }
}
?>
            console.log(objen)// print all lng data
            //console.log($('.checkbox:checked').val())
           // objen['en'] = sizeAttr;
            //console.log(objen);
            
            if (sizeName.length <= 0)
            {
                $('#name_0').focus();
                $("#text_editname").text('<?php echo $this->lang->line('error_editname'); ?>');
            } else if (categoryId == '' || categoryId == null) {
                $('#editcategory').focus();
                $("#text_editcategory").text('<?php echo $this->lang->line('error_category'); ?>');
            } else if (sizeAttr.length <= 0) {
                $('#editattributes').focus();
                $("#text_editattr").text('<?php echo $this->lang->line('error_attr'); ?>');
            } else {
                $(this).prop('disabled', true);

               $.ajax({
                    url: "<?php echo base_url('index.php?/sizeController') ?>/editSize",
                    type: "POST",
                    data: {sizeId: $('.checkbox:checked').val(),
                        sizeName: sizeName, categoryId: categoryId, categoryName: categoryName,
                        subCategoryId: subCategoryId, subCategoryName: subCategoryName,
                        subSubCategoryId: subSubCategoryId, subSubCategoryName: subSubCategoryName,
                        sizeDesc: sizeDesc, sizeAttr: objen},
                    success: function (result) {
                        console.log(result);
                        if (result == 1) {
                            $('#editSizeModal').modal('hide');
                            window.location.reload();
                        }

                    }
                }); 
            }

        });

        $("#activate").click(function () {
            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length >= 1) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#activateColor');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#activateColor').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxactivateColor").text('<?php echo $this->lang->line('alert_activate'); ?>');

            } else if (val.length == 0) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_select'); ?>');
            }

        });

        $("#yesActivate").click(function () {
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            $.ajax({
                url: "<?php echo base_url('index.php?/sizeController') ?>/activateColor",
                type: "POST",
                data: {Id: val},
                success: function (result) {

                    var res = JSON.parse(result)
                    $('#activateColor').modal('hide');
                    if (res.flag == 0) {
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/sizeController/size_details/2',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
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
                        $('#errorModal').modal('show')
                        $(".modalPopUpText").text('Selected size group has not been activated');
                    }
                }
            });
        });


        $("#deactivate").click(function () {
            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length >= 1) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#deactivateColor');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#deactivateColor').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdeactivate").text('<?php echo $this->lang->line('alert_deactivate'); ?>');

            } else if (val.length == 0) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_oneselect'); ?>');
            }

        });

        $('#yesdeactivate').click(function () {
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            $.ajax({
                url: "<?php echo base_url('index.php?/sizeController') ?>/deactivateColor",
                type: "POST",
                data: {Id: val},
                success: function (result) {
                    console.log(JSON.parse(result));
                    var res = JSON.parse(result)
                    $('#deactivateColor').modal('hide');
                    if (res.flag == 0) {
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/sizeController/size_details/1',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
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
                        $('#errorModal').modal('show')
                        $(".modalPopUpText").text('Selected size group has not been deactivated');
                    }


                }
            })
        });

        $('.changeMode').click(function () {

            var tab_id = $(this).attr('data-id');

            if (currentTab != tab_id)
            {
//                console.log(tab_id);
                $('#big_table').hide();
                $("#display-data").text("");

                if ($(this).data('id') == 2) {
                    $("#display-data").text("");
                    $('#add').hide();
                    $('#edit').show();
                    $('#activate').show();
                    $('#deactivate').hide();
                }

                $('#big_table_processing').toggle();

                var table = $('#big_table');

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
                        //oTable.fnAdjustColumnSizing();
//                    $('#big_table_processing').toggle();
                        $('#big_table').show();
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

            } else {

                $('#add').show();
                $('#edit').show();
                $('#activate').hide();
                $('#deactivate').show();

                $('#big_table_processing').toggle();

                var table = $('#big_table');

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
                        "sProcessing": "<img src='<?php echo base_url() ?>theme/assets/img/ajax-loader_dark.gif'>"
                    },
                    "fnInitComplete": function () {
                        //oTable.fnAdjustColumnSizing();
//                    $('#big_table_processing').toggle();
                        $('#big_table').show();
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

            }

        });

    });

</script>


<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"><?php echo $this->lang->line('heading_page'); ?></strong>
        </div>
        <!-- Nav tabs -->
        <div class="panel panel-transparent ">
            <!-- Nav tabs -->

            <ul class="nav nav-tabs  bg-white whenclicked">
                <li id= "my1" class="tabs_active active" style="cursor:pointer">
                    <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/sizeController/size_details/1" data-id="1"><span><?php echo $this->lang->line('heading_active'); ?></span><span class="badge" style="background-color: #337ab7;"></span></a>
                </li>

                <li id= "my2" class="tabs_active" style="cursor:pointer">
                    <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/sizeController/size_details/2" data-id="2"><span><?php echo $this->lang->line('heading_deactive'); ?></span> <span class="badge bg-red"></span></a>
                </li>
            </ul>
            <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

                <div class="pull-right m-t-10"> <button class="btn btn-info cls111" id="deactivate"><?php echo $this->lang->line('button_deactivate'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-info cls111" id="activate"><?php echo $this->lang->line('button_activate'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-info cls111" id="edit"><?php echo $this->lang->line('button_edit'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10 cls110" id="add"><?php echo $this->lang->line('button_add'); ?> </button></a></div>

            </ul>
        </div>
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">

                                    <div class="cs-loader">
                                        <div class="cs-loader-inner" >
                                            <label class="loaderPoint" style="color:#10cfbd">●</label>
                                            <label class="loaderPoint" style="color:red">●</label>
                                            <label class="loaderPoint" style="color:#FFD119">●</label>
                                            <label class="loaderPoint" style="color:#4d90fe">●</label>
                                            <label class="loaderPoint" style="color:palevioletred">●</label>
                                        </div>
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
    <!-- END FOOTER -->
</div>

<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h4 id="modalTitle"></h4>
                </div>
            </div>

            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box modalPopUpText modalTitleText " id="errorboxdata" ></div>
                </div>
            </div>
            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>

                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" >Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="addSize" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_add'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Name'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="sizename form-control error-box-class" id="name_0" name="sizeName[0]"  minlength="3" placeholder="Enter size name" required="">  

                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_name" style="color:red"></div>
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-8">
                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="sizeName[<?= $val['lan_id'] ?>]"  placeholder="Enter size name" class="sizename error-box-class  form-control">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-8">
                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="sizeName[<?= $val['lan_id'] ?>]"  placeholder="Enter size name" class="sizename error-box-class  form-control">
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_Category'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-8">
                            <select id="category" name="firstCategoryId"  class="form-control error-box-class">
                                <option data-name="Select Category" value=""><?php echo $this->lang->line('label_SelectCategory'); ?></option>

                                <?php
                                foreach ($category as $result) {
                                    echo "<option data-name='" . $result['name']['en'] . "' data-id=" . $result['categoryId'] . " value=" . $result['categoryId'] . ">" . $result['name']['en'] . "</option>";
                                }
                                ?>

                            </select> 


                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_category" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SubCategory'); ?></label>
                        <div class="col-sm-8">
                            <select id="subCategory" name="secondCategoryId"  class="form-control error-box-class">
                                <option data-name="" value=""><?php echo $this->lang->line('label_SelectSubCategory'); ?></option>

                            </select>  

                        </div>

                    </div>
                    <div class="col-sm-4 error-box" id="text_subCategory"></div>
                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SubSubCategory'); ?></label>
                        <div class="col-sm-8">
                            <select id="subSubCategory" name="thirdCategoryId"  class="form-control error-box-class">
                                <option data-name="" value=""><?php echo $this->lang->line('label_SelectSubSubCategory'); ?></option>

                            </select>  
                            <input type="hidden" name="firstCategoryName" id="firstCategoryName" value="" />
                            <input type="hidden" name="secondCategoryName" id="secondCategoryName" value="" />
                            <input type="hidden" name="thirdCategoryName" id="thirdCategoryName" value="" />
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_subSubCategory" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Description'); ?></label>
                        <div class="col-sm-8">
                            <textarea type="text" class="sizeDescription form-control error-box-class" id="desc_0" name="sizeDescription[0]"  minlength="3" placeholder="Enter size description" style="max-width: 100%;"></textarea> 

                        </div>

                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Description'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-8">

                                    <textarea type="text" id="desc_<?= $val['lan_id'] ?>" name="sizeDescription[<?= $val['lan_id'] ?>]"  placeholder="Enter size description" class="sizeDescription error-box-class  form-control" style="max-width: 100%;"></textarea>

                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Description'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-8">

                                    <textarea type="text" id="desc_<?= $val['lan_id'] ?>" name="sizeDescription[<?= $val['lan_id'] ?>]"  placeholder="Enter size description" class="sizeDescription error-box-class  form-control" style="max-width: 100%;"></textarea>

                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Attr'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="form-group col-sm-8">
                            <div class="attributesData" style="padding-left: 1%;"></div>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="form-group col-sm-3"></div>
                        <div class="col-sm-6">
                            <br><label>ENGLISH</label>
                            <input id="attributes"  class="form-control error-box-class" type="text">
                            <?php
                            foreach ($language as $lang) {
                                if ($lang['Active'] == 1) {
                                    ?>
                                    <br><label><?php echo strtoupper($lang['lan_name']); ?></label>
                                    <input id="<?php echo $lang['langCode']; ?>_attribute"  class="form-control" type="text">
                                    <?php
                                } else {
                                    ?>
                                    <br><label style="display: none;"><?php echo strtoupper($lang['lan_name']); ?></label>
                                    <input style="display: none;" id="<?php echo $lang['langCode']; ?>_attribute"  class="form-control" type="text">
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="col-sm-2" style=" margin-top: 37px;">
                            <button type="button" class="btn btn-primary" data-id="attributes" id="addAttributes"><?php echo $this->lang->line('button_add'); ?></button>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_attr" style="color:red"></div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel6"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesAdd" ><?php echo $this->lang->line('button_add'); ?></button></div>
                </div>

            </div>
        </div>


    </div>
</div>
<div id="editSizeModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_edit'); ?></span>
                <button type="button" class="close editSizeModalClosed">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Name'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="editsizename form-control error-box-class" id="editname_0" name="colorName[0]"  minlength="3" placeholder="Enter color name" required="">  

                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_editname" style="color:red"></div>
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-8">

                                    <input type="text" id="editname_<?= $val['lan_id'] ?>" name="colorName[<?= $val['lan_id'] ?>]"  placeholder="Enter color name" class="editsizename error-box-class  form-control">

                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-8">

                                    <input type="text" id="editname_<?= $val['lan_id'] ?>" name="colorName[<?= $val['lan_id'] ?>]"  placeholder="Enter color name" class="editsizename error-box-class  form-control">

                                </div>

                            </div> 
                            <?php
                        }
                    }
                    ?>

                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_Category'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-8">
                            <select id="editcategory" name="firstCategoryId"  class="form-control error-box-class">
                                <option data-name="Select Category" value=""><?php echo $this->lang->line('label_SelectCategory'); ?></option>

                                <?php
                                foreach ($category as $result) {
                                    echo "<option data-name=" . $result['name'][0] . " data-id=" . $result['categoryId'] . " value=" . $result['categoryId'] . ">" . $result['name'][0] . "</option>";
                                }
                                ?>

                            </select> 


                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_editcategory" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SubCategory'); ?></label>
                        <div class="col-sm-8">
                            <select id="editsubCategory" name="secondCategoryId"  class="form-control error-box-class">
                                <option data-name="" value=""><?php echo $this->lang->line('label_SelectSubCategory'); ?></option>

                            </select>  

                        </div>

                    </div>
                    <div class="col-sm-4 error-box" id="text_editsubCategory"></div>
                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_SubSubCategory'); ?></label>
                        <div class="col-sm-8">
                            <select id="editsubSubCategory" name="thirdCategoryId"  class="form-control error-box-class">
                                <option data-name="" value=""><?php echo $this->lang->line('label_SelectSubSubCategory'); ?></option>

                            </select>  
                            <input type="hidden" name="firstCategoryName" id="editfirstCategoryName" value="" />
                            <input type="hidden" name="secondCategoryName" id="editsecondCategoryName" value="" />
                            <input type="hidden" name="thirdCategoryName" id="editthirdCategoryName" value="" />
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_editsubSubCategory" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Description'); ?></label>
                        <div class="col-sm-8">
                            <textarea type="text" class="editsizeDescription form-control error-box-class" id="editdesc_0" name="sizeDescription[0]"  minlength="3" placeholder="Enter size description" style="max-width: 100%;"></textarea> 

                        </div>

                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Description'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-8">

                                    <textarea type="text" id="editdesc_<?= $val['lan_id'] ?>" name="sizeDescription[<?= $val['lan_id'] ?>]"  placeholder="Enter size description" class="editsizeDescription error-box-class  form-control" style="max-width: 100%;"></textarea>

                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Description'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-8">

                                    <textarea type="text" id="editdesc_<?= $val['lan_id'] ?>" name="sizeDescription[<?= $val['lan_id'] ?>]"  placeholder="Enter size description" class="editsizeDescription error-box-class  form-control" style="max-width: 100%;"></textarea>

                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Attr'); ?><span class="MandatoryMarker">*</span></label>
                        <!--<div class="form-group col-sm-3"></div>-->
                        <div class="form-group col-sm-8">
                            <div class="editattributesData" style="padding-left: 1%;"></div>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="form-group col-sm-3"></div>
                        <div class="col-sm-6">
                            <br><label>ENGLISH</label>
                            <input id="editattributes"  class="form-control" type="text">
                            <?php
                            foreach ($language as $lang) {
                                if ($lang['Active'] == 1) {
                                    ?>
                                    <br><label><?php echo strtoupper($lang['lan_name']); ?></label>
                                    <input id="<?php echo $lang['langCode']; ?>_editattribute"  class="form-control" type="text">
                                    <?php
                                } else {
                                    ?>
                                    <br><label style="display: none;"><?php echo strtoupper($lang['lan_name']); ?></label>
                                    <input style="display: none;" id="<?php echo $lang['langCode']; ?>_editattribute"  class="form-control" type="text">
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary" data-id="editattributes" id="editaddAttributes"><?php echo $this->lang->line('button_add'); ?></button>
                        </div>
                    </div>
<!--                    <div class="form-group col-sm-12">
                        <div class="form-group col-sm-3"></div>
                        <div class="col-sm-6">
                            <input id="editattributes"  class="form-control" type="text">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary" data-id="editattributes" id="editaddAttributes"><?php echo $this->lang->line('button_add'); ?></button>
                        </div>
                    </div>-->
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_editattr" style="color:red"></div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button"  class="btn btn-default btn-cons editSizeModalClosed"  id="cancel6"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesEdit" ><?php echo $this->lang->line('button_save'); ?></button></div>
                </div>
            </div>
        </div>


    </div>
</div>

<div class="modal fade stick-up" id="activateColor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">ACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorboxactivateColor" style="text-align:center;font-size: 14px;">Activate</div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <div class="col-sm-4" ></div>
                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel5"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="yesActivate" ><?php echo $this->lang->line('button_activate'); ?></button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="deactivateColor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DEACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorboxdeactivate" style="text-align:center;font-size: 14px;"><?php echo VEHICLEMODEL_DELETE; ?></div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <div class="col-sm-4" ></div>
                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel51"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="yesdeactivate" ><?php echo $this->lang->line('button_deactivate'); ?></button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
                <p class="error-box modalPopUpText"></p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>

    </div>
</div>

<script>

    var counter = 0;
    var desc = '';
    var langInput = '';

    $(document).ready(function ()
    {

        var desc = '';
        var langInput = '';


//-------------------On click add ----------------------------------------
        $('#addAttributes').click(function ()
        {
            if ($('#attributes').val() == '')
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Input field should not be empty');
            } else {
                var desc = '';
                var langInput = '';
<?php
foreach ($language as $lang) {
    if ($lang['Active'] == 1) {
        ?>
                        //                        if ($('#<?php echo $lang['langCode']; ?>_attribute').val() != '')
                        //                        {
                        desc += $('#<?php echo $lang['langCode']; ?>_attribute').val();
                        desc += ',';

                        langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id') + '[]" id="<?php echo $lang['langCode']; ?>_addAttributes" class="<?php echo $lang['langCode']; ?>_Attributes  inputDesc"  type="text"  value="' + $('#<?php echo $lang['langCode']; ?>_attribute').val() + '">';
                        $('#<?php echo $lang['langCode']; ?>_attribute').val('');//Blank it after 
                        //                        }
        <?php
    }
}
?>

                if (desc != '')
                    desc = '(' + desc.replace(/,\s*$/, "") + ')';

                counter += 1;
                $('.attributesData').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#attributes').val() + ' ' + desc + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" id="en_addAttributes" class="en_Attributes inputDesc"  type="text"  value="' + $('#attributes').val() + '">' + langInput + '<span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');

                $('#attributes').val('');

            }
        });
        
        $('#editaddAttributes').click(function ()
        {
            if ($('#editattributes').val() == '')
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text('Input field should not be empty');
            } else {
                var desc = '';
                var langInput = '';
<?php
foreach ($language as $lang) {
    if ($lang['Active'] == 1) {
        ?>
                        //                        if ($('#<?php echo $lang['langCode']; ?>_attribute').val() != '')
                        //                        {
                        desc += $('#<?php echo $lang['langCode']; ?>_editattribute').val();
                        desc += ',';

                        langInput += '<input  style="display:none;" name="<?php echo $lang['langCode']; ?>_' + $(this).attr('data-id') + '[]" id="<?php echo $lang['langCode']; ?>_editAttributes" class="<?php echo $lang['langCode']; ?>_Attributes  inputDesc"  type="text"  value="' + $('#<?php echo $lang['langCode']; ?>_editattribute').val() + '">';
                        $('#<?php echo $lang['langCode']; ?>_attribute').val('');//Blank it after 
                        //                        }
        <?php
    }
}
?>

                if (desc != '')
                    desc = '(' + desc.replace(/,\s*$/, "") + ')';

                counter += 1;
                $('.editattributesData').append('<span class="tag label label-info" id="' + $(this).attr('id') + counter + '">' + $('#editattributes').val() + ' ' + desc + '<input  style="display:none;" name="' + $(this).attr('data-id') + '[]" id="en_Attributes" class="en_Attributes inputDesc"  type="text"  value="' + $('#editattributes').val() + '">' + langInput + '<span class="RemoveMore" data-id="' + $(this).attr('id') + counter + '" style="">x</span></span>');

                $('#editattributes').val('');

            }
        });


$(".editSizeModalClosed").click(function(){
    $(".editattributesData").empty();
    $("#editSizeModal").modal('toggle');;
});

    });

    
    
</script>
