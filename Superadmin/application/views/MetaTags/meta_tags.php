
<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
    .btn{
        border-radius: 25px !important;
    }
    .top{
        padding-top: 5px;
    }
</style>
<script>
$(document).ready(function (){

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

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });
        $('.businesscat').addClass('active');
        $('.businesscat').attr('src', "<?php echo base_url(); ?>/theme/icon/business_mgt_on.png");
        $('.businesscat_thumb').addClass("bg-success");

        $('#btnStickUpSizeToggler').click(function () {
            $("#display-data").text("");
            $("#display-data").text("");
			$("#metaname").val("");
			$("#metaId").val("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                $('#modalHeading').html(<?php echo json_encode(SELECT_COUNTRY_ANDBUSINESS_CAT); ?>);
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
                $("#display-data").text("Wrong selection");
            }
        });


        $('#bdelete').click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Select the Meta-tag you want to delete");
            } else if (val.length == 1 || val.length > 1)
            {
                $("#errorboxdata").text("Do you want to delete this Meta-Tag");
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
                        url: "<?php echo base_url('index.php?/Metatags') ?>/deletemetadata",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (response)
                        {
                            $(".close").trigger("click");
                            location.reload();
                        }
                    });
                });
//                $("#display-data").text(<?php // echo json_encode(POPUP_DELETE_DELETE_FRANCHISE);                                                       ?>);
            }

        });




        $('#insert').click(function () {
            $(this).prop('disabled', false);
            $('.clearerror1').text("");
            var cateid = "<?php echo $mid; ?>";
            var form_data = new FormData();

            var metaname = $("#metaname").val();
            form_data.append('value', metaname);

            var metaId = $("#metaId").val();
            form_data.append('type', metaId);
            form_data.append('categoryId', cateid);
            console.log('saoho;ashoah;adhs');
            if (metaname == "" || metaname == null)
            {

                $("#clearerror1").text('Please enter value');
            } else if (metaId == "" || metaId == null)
            {

                $("#clearerror1").text('Please enter type');
            } else {
                console.log(metaname, metaId);
                $.ajax({
                    url: "<?php echo base_url('index.php?/Metatags') ?>/insert_metadata",
                    type: 'POST',
                    data: form_data,
                    async: false,
                    dataType: 'JSON',
                    success: function (response)
                    {

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
                        $("#errorboxaddmodal").text("Meta-tag has been added successfully...!!");
                        $("#confirmeds1").hide();

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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Metatags/datatable_Metatags/' + '<?php echo $mid; ?>',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {
//                                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
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
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });


                $("#metaname").val("");
                $("#metaId").val("");
                $('#myModal').hide();
               
            }
        });

        $("#cat_photos").change(function () {
//           alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
            $('.clearerror').text("");
            var cat_photos = $("#cat_photos").val();
            var userfile_extn = cat_photos.split(".");
            userfile_extn = userfile_extn[userfile_extn.length - 1].toLowerCase();

            var arrayExtensions = ["jpg", "jpeg", "png", "bmp", "gif"];
            if (arrayExtensions.lastIndexOf(userfile_extn) == -1 || (this.files[0].size / 1024 / 1024) > 2)
            {
//                            alert("Invalid image.");
                $("#clearerror").text("Invalid image Size is more than 2MB.");
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
//                            alert("Invalid image.");
                $("#editclearerror").text("Invalid image.");
                $("#Editcat_photos").val("");
            }


        });

        $('#editbusiness').click(function () {

            $("#display-data").text("");
            var form_data = new FormData();
            var val = $(this).val();
            $('.editclearerror').text("");

            form_data.append('metaname', $("#Editmetaname").val());
            form_data.append('metaId', $("#EditmetaId").val());

            form_data.append('editId', $("#editedId").val());
            if (Editmetaname == "" || Editmetaname == null) {

                $("#editclearerror").text(<?php echo json_encode(POPUP_CAT_NAME); ?>);
            } else {


                $.ajax({
                    url: "<?php echo base_url('index.php?/Metatags') ?>/editmetadata",
                    type: 'POST',
                    data: form_data,
                    async: true,
                    dataType: 'JSON',
                    success: function (response)
                    {
                        $('#editModal').modal('hide');
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Metatags/datatable_Metatags/' + '<?php echo $mid; ?>',
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {
                                //                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
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

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }


        });



       $(document).on('click', '.editICON', function ()
        {
            $("#display-data").text("");
            $('#modalHeading').html("Edit Metatag");
            var val = $(this).val();
            $('#editbusiness').val(val);
            if(val){
//                  alert(val);
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/Metatags/getmetadata",
                    type: 'POST',
                    data: {val: val},

                    dataType: 'JSON',

                    success: function (response)
                    {
                        $.each(response, function (index, row) {
                            $('#editedId').val(row._id.$oid);
                            $('#Editmetaname').val(row.value);
                            if (row.type == "Number") {
                                $('#EditmetaId').val("number");
                            } else {
                                $('#EditmetaId').val("string");
                            }
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
                $("#display-data").text(<?php echo json_encode(POPUP_ONE_BUSINESSEDIT_CAT); ?>);
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
                $("#display-data").text(<?php echo json_encode(POPUP_SELECT_ONEBUSINESS_CATHIDE); ?>);
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

                $("#errorboxdata").text("Are you sure you wish to hide category");

                $("#confirmed").click(function () {
//                    console.log(val);
                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/Metatags/catdata_hide",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (response)
                        {
                            $(".close").trigger("click");
                            location.reload();
                        }
                    });
                });

            } else if (val.length > 1)
            {
                $('#displayData').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_ONE_BUSINESSEDIT_HIDECAT); ?>);
            }

        });

        $('#unhide').click(function () {
            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_SELECT_ONEBUSINESS_CATUNHIDE); ?>);
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

                $("#errorboxdata").text("Are you sure you wish to hide category");

                $("#confirmed").click(function () {
//                    console.log(val);
                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/Metatags/catdata_unhide",
                        type: "POST",
                        data: {val: val},
                        dataType: 'json',
                        success: function (response)
                        {
//                            alert(response);
                            $(".close").trigger("click");
                            location.reload();
                        }
                    });
                });
//              

            } else if (val.length > 1)
            {
                $('#displayData').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_ONE_BUSINESSEDIT_UNHIDECAT); ?>);
            }

        });


    });

    function moveUp(id) {
//        alert(id);

        var row = $(id).closest('tr');
        var prev_id = row.prev('tr').find('.moveUp').attr('id')
        var curr_id = row.find('.moveUp').attr('id');

        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Metatags/changeCatOrder",
            type: "POST",
            data: {kliye: 'interchange', curr_id: curr_id, prev_id: prev_id},
            success: function (result) {

            }
        });
        row.prev().insertAfter(row);
        $('#saveOrder').trigger('click');
//        });
    }
    function moveDown(id) {
//        console.log(id);

        var row = $(id).closest('tr');
//           console.log(row.find('.moveDown').attr('id'));

//            console.log(row.next('tr').find('.moveDown').attr('id'));
//            console.log(row.prev('tr').find('.moveDown').attr('id'));
        var prev_id = row.find('.moveDown').attr('id');
        var curr_id = row.next('tr').find('.moveDown').attr('id');

        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Metatags/changeCatOrder",
            type: "POST",
            data: {kliye: 'interchange', prev_id: prev_id, curr_id: curr_id},
            success: function (result) {

//                    alert("intercange done" + result);

            }
        });
        row.insertAfter(row.next());
        $('#saveOrder').trigger('click');
//        });
    }

    function validatecat() {
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Metatags/validate_catname",
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
//        alert(status);
        if (status == 1) {
            $('#btnStickUpSizeToggler').show();
            $('#edit').show();
            $('#bdelete').show();
//                $('#Sedit').hide();
//                $('#SbtnStickUpSizeToggler').hide();
//                $('#Sdelete').hide();
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Metatags/datatable_Metatags/' + '<?php echo $mid; ?>',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
//                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
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
        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });




        $('.whenclicked li').click(function () {
//             alert($(this).attr('id'));
            if ($(this).attr('id') == 1) {

                $('#btnStickUpSizeToggler').show();
                $('#edit').show();
                $('#bdelete').show();
                $('#Sedit').hide();
                $('#SbtnStickUpSizeToggler').hide();
                $('#Sdelete').hide();
//                 $('#big_table').find('td:eq(6),th:eq(6)').hide();
            } else if ($(this).attr('id') == 2) {

                $('#btnStickUpSizeToggler').hide();
                $('#edit').hide();
                $('#bdelete').hide();
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
                "oLanguage": {
//                    "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    $('#big_table').fadeIn('slow');
                    //oTable.fnAdjustColumnSizing();
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
            "oLanguage": {
//                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
                //oTable.fnAdjustColumnSizing();
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
//                    "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
                //oTable.fnAdjustColumnSizing();
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


//
        table.dataTable(settings);


    });



</script>
<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;
             font-size: 16px;
             color:#0090d9;">
        

            <strong style="color:#0090d9;">Meta Tags </strong><!-- id="define_page"-->
        </div>
        <!-- START BREADCRUMB -->
        <ul class="breadcrumb" style="background:white;margin-top: 1%;">
            <li><a class="active" href="<?php echo base_url() ?>index.php?/Category" class="">
                <?php
                    foreach ($business as $cat) {
                        if($bid == "" || $bid == null){
                            if ((string) $cat['categoryId'] == $mid) {
                                $catname = $cat['name'][0];
                            } 
                        }else{
                        if ((string) $cat['categoryId'] == $bid) {
                            $catname = $cat['name'][0];
                        }
                    }
                    }
                    print_r(strtoupper($catname));
                    ?></a></li>
<?php if($bid !=''){?>
            <li>
                <a href="<?php echo base_url() ?>index.php?/SubCategory/SubCategory/<?php echo $bid;?>" class="active">
                    <?php
                    foreach ($businessTwo as $cat) {
                        if ((string) $cat['id'] == $mid) {
                            $catname = $cat['name'][0];
                        }
                    }
                    print_r(strtoupper($catname));
                    ?></a>
            </li>
<?php } ?>

            <li><a href="<?php echo base_url() ?>index.php?/Metatags/meta_tags/<?php echo $mid; ?>/<?php echo $bid; ?>" class="active">
                    <?php
//print_r($mid);die;
//foreach ($metatags as $cat1) {
//    if ((string) $cat1['categoryId'] == $mid) {
//        $catname1 = $cat1['value'];
//    }
//}
//print_r(strtoupper($catname1));
                    ?>

                    Metatag
                </a>
            </li>
            <div class="pull-right m-t-10"> <button class="btn btn-danger btn-cons pull-right" id="bdelete">Delete</button></div>
            <!--<div class="pull-right m-t-10"> <button class="btn btn-warning btn-cons" id="edit">Edit</button></div>-->
            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons pull-right"  id="btnStickUpSizeToggler">Add</button></div>                 
        </ul>
        <!-- END BREADCRUMB -->


        <!-- START JUMBOTRON -->

        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent " style="margin-left: -50px;margin-right: -50px;margin-top: -50px;">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs bg-white whenclicked">
                        <!--                        <li id= "1" class="active tabs_active">
                                                    <a  class="changeMode cuisines_" data="<?php echo base_url() ?>index.php?/Metatags/datatable_businesscat/1" ><span><?php echo NAV_BUSINESS_CAT; ?></span></a>
                                                </li>
                                                <li id= "2" class="tabs_active">
                                                    <a  class="changeMode subcuisines_" data="<?php echo base_url() ?>index.php?/Metatags/datatable_businesscat/2"><span>SUB CATEGORY</span></a>
                                                </li>-->
                    </ul>
                    <ul class="nav nav-tabs  bg-white">


                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <!--<div class="error-box" id="display-data" style="text-align:center"></div>-->
                                    <div class="modal fade" id="displayData" role="dialog">
                                        <div class="modal-dialog">                                        
                                            <!-- Modal content-->

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
                                    <div id="big_table_processing" class="dataTables_processing" style="">
                                        <!--<img src="http://www.ahmed-samy.com/demos/datatables_2/assets/images/ajax-loader_dark.gif">-->
                                    </div>


                                    <div class="searchbtn row clearfix pull-right" style="">

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                    </div>

                                </div>
                                <br>
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
        <!-- END JUMBOTRON -->

    </div>
    <!-- END PAGE CONTENT -->

</div>

<div class="modal fade stick-up" id="addmodal" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="errorboxaddmodal" style="font-size: large;text-align:center"><?php echo POPUP_BUSINESS_ACTIVATE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds1" >Yes</button>
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


            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdata" style="font-size: large;text-align:center"></div>

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
                <span class="modal-title">Alert</span>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
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

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <span class="modal-title">Meta Tags</span>
                </div>

                <div class="modal-body">
                    <br/>
                    <div id="Category_txt" >
                        <div class="form-group formex">
                            <div class="frmSearch">
                                <label for="fname" class="col-sm-3 control-label top">Value<span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-8">    <!--<div class="col-sm-6">-->  
                                    <input type="text"   id="metaname" name="metaname"  placeholder="Enter the meta-tag value"style="  width: 100%;line-height: 2;" class="catname form-control error-box-class" >
                                </div>
                                <div class="col-sm-1"></div>

                            </div>
                        </div>
                        <br>
                        <br>
                        <br>



                    </div>

                    <br>



                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label top">Type<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <select id="metaId" name="meta_select"  class="form-control error-box-class">
                                <option value="" disabled selected>Select </option>
                                <option value="Number">Number</option>
                                <option value="String">String</option>
                            </select>  
                        </div>
                        <div class="col-sm-1"></div>
                    </div>

                    <br/>
                    <br/>

                </div>

                <div class="modal-footer">                            
                    <div class="col-sm-4 error-box" id="clearerror1"></div>

                    <div class="col-sm-8" >

                        <button type="button" class="btn btn-primary pull-right" id="insert" >Add</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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


<div class="modal fade stick-up" id="mysubModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="addcat"  role="form"  method="post" enctype="multipart/form-data">

        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-header">

                        <div class=" clearfix text-left">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                            </button>

                        </div>
                        <h3> <?php echo SELECT_COUNTRY_ANDBUSINESS_CAT; ?></h3>
                    </div>

                    <div class="modal-body">

                        <br>
                        <div class="form-group" class="formex">
                            <div class="frmSearch">
                                <label for="fname" class="col-sm-4 control-label">Category<span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <select id="Catid" name="Category_select"  class="form-control error-box-class">
                                        <option value="0">Select Category</option>

                                        <?php
                                        foreach ($business as $result) {
                                            echo "<option value=" . $result['Categoryid'] . ">" . $result['Categoryname'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                    <div id="suggesstion-box"></div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="form-group" class="formex">
                            <div class="frmSearch">
                                <label for="fname" class="col-sm-4 control-label">Sub-Category <span style="color:red;font-size: 18px">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" id="subcatname" name="subcatname" style="  width: 250px;line-height: 2;" class="form-control error-box-class"/>
    <!--                                <input type="hidden" id="search-box-hidden" class="form-control error-box-class" />-->
                                    <div id="suggesstion-box"></div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group" class="formex">
                            <label for="fname" class="col-sm-4 control-label">    <?php echo FIELD_VALUE; ?></label>
                            <div class="col-sm-6">
                                <textarea type="text"  id="subcatDescription" name="subcatDescription"  class="form-control error-box-class" ></textarea>
                            </div>
                        </div>

                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-sm-4" ></div>
                            <div class="col-sm-6 error-box" id="clearerror"></div>
                            <div class="col-sm-2" >
                                <button type="button" class="btn btn-primary pull-right" id="insertsubcat" ><?php echo BUTTON_ADD; ?></button>
                            </div>
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
                    <span id='modalHeading' class="modal-title"></span>
                </div>

                <div class="modal-body">
                    <br> 
                    <input type="hidden" id="editedId" style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>                       

                    <div id="Category_txt" >
                        <div class="form-group formex">
                            <div class="frmSearch">
                                <label for="fname" class="col-sm-3 control-label top">Value<span class="MandatoryMarker">*</span></label>
                                <div class="col-sm-8">    <!--<div class="col-sm-6">-->  
                                    <input type="text"   id="Editmetaname" name="Editmetaname" style="  width: 100%;line-height: 2;" class="Editcatname form-control error-box-class" >
                                </div>
                                 <div class="col-sm-1"></div>


                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                    </div>
                    <br>

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-3 control-label top">Type<span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <select id="EditmetaId" name="meta_select"  class="form-control error-box-class">
                                <option value="">Select type</option>
                                <option value="number">Number</option>
                                <option value="string">String</option>
                            </select>  
                        </div>
                        <div class="col-sm-1"></div>

                        <br>
                        <br>                      
                        <div class="form-group" class="formex" style="display:none;">
                            <label for="fname" class="col-sm-4 control-label">    <?php echo "SELECT IF THIS CUSINE IS UPPER LAYER"; ?></label>
                            <div class="col-sm-8">
                                <input type="checkbox" id="checkUpperLayer" value="CheckUpperLayer">
                            </div>
                        </div>

                        <br>
                        <br>
                    </div>

                    <div class="modal-footer">
                        <div class="col-sm-4 error-box" id="editclearerror"></div>                          
                        <div class="col-sm-8" >
                            <button type="button" class="btn btn-primary pull-right" id="editbusiness" >Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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

<div class="modal fade stick-up" id="editsubModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="editcat"  role="form"  method="post" enctype="multipart/form-data">

        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <input type="hidden" id="editedsubId" style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>


                    <br>
                    <div class="form-group" class="formex">
                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">Category<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <select id="editCatid" name="Category_select"  class="form-control error-box-class">
                                    <option value="0">Select Category</option>

                                    <?php
                                    foreach ($business as $result) {
                                        echo "<option value=" . $result['Categoryid'] . ">" . $result['Categoryname'] . "</option>";
                                    }
                                    ?>

                                </select>
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <br>
                    <div class="form-group" class="formex">
                        <div class="frmSearch">
                            <label for="fname" class="col-sm-4 control-label">Sub-Category <span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" id="editsubcatname" name="subcatname" style="  width: 250px;line-height: 2;" class="form-control error-box-class"/>
<!--                                <input type="hidden" id="search-box-hidden" class="form-control error-box-class" />-->
                                <div id="suggesstion-box"></div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label">    <?php echo FIELD_DESCRIPTION; ?></label>
                        <div class="col-sm-6">
                            <textarea type="text"  id="editsubcatDescription" name="subcatDescription"  class="form-control error-box-class" ></textarea>
                        </div>
                    </div>

                    <br>
                    <br>

                    <br>
                    <br>
                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"><?php echo FIELD_IMAGE; ?><span style="color:red;font-size: 10px">  (max size - 2 mb)</span></label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control error-box-class"  name="subcat_photos" id="editsubcat_photos" value="" placeholder="">
                            <input type="hidden" id="subEdit_photos" name="subcat_photos"  class="form-control error-box-class">

                            <a target="_blank" id="subEdit_photo" name="subcat_photos" style="display:none;" href="" >view</a> 

                        </div>

                    </div>

                    <!--                    <div class="form-group">
                                                            <div class="col-sm-6">
                                                                <label for="fname" class="control-label">Upload Image</label>
                                                                <div class="" style="
                                                                     width: 31%;
                                                                     ">
                                                                    <a onclick="openFileUpload(this)" id='1' style="cursor: pointer;">
                                                                        <div class="portfolio-group">
                    <?PHP
//                                                        if ($ProfileData['ImageUrl'] == '') {
//                                                            echo '  <img src="http://postmenu.cloudapp.net/Business/addnew.png" id="btnStickUpSizeToggler" style="width: 20%;height: 28%;float: right;position: absolute;margin-left: 34%;margin-top: -2%;">';
//                                                        } else {
//                                                            echo '  <img src="' . $ProfileData['ImageUrl'] . '" id="btnStickUpSizeToggler" style="width: 20%;height: 28%;float: right;position: absolute;margin-left: 34%;margin-top: -2%;width: 20%;height: 28%;float: right;position: absolute;/* padding-left: 0%; */margin-left: 34%;margin-top: -2%;">';
//                                                        }
                    ?>
                    
                                                                        </div>
                                                                    </a>                                                                    
                                                                </div>
                    
                                                            </div>
                                        </div>-->

                    <br>
                    <br>
                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4 error-box" id="editclearerror"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="editsubbusiness" ><?php echo BUTTON_SAVE; ?></button>
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
