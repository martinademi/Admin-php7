

<style>
    .btn{
        border-radius: 25px !important;
    }
    .dataTables_scrollHead{
        margin-bottom: -52px !important;
    }

    .carousel-inner > .item > img,
    .carousel-inner > .item > a > img {
        width: 70%;
        margin: auto;
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
    $(document).ready(function () {
        
        

        $('#big_table').on('init.dt', function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            var forwhat = urlChunks[urlChunks.length - 2];

            if (status == 0) {
                $('#big_table').dataTable().fnSetColumnVis([], false);
                $('#reject').show();
                $('#ban').hide();
                $('#approve').show();
                $('#delete').show();


            }
            if (status == 1) {
                
                $('#big_table').dataTable().fnSetColumnVis([4], false);
                $('#reject').hide();
                $('#ban').show();
                $('#approve').hide();
                $('#delete').show();


            }
            if (status == 2) {
                $('#big_table').dataTable().fnSetColumnVis([4], false);
                $('#reject').hide();
                $('#ban').hide();
                $('#approve').show();
                $('#delete').hide();

            }
            if (status == 3) {
                 $('#big_table').dataTable().fnSetColumnVis([4], false);
                $('#reject').hide();
                $('#ban').hide();
                $('#approve').show();
                $('#delete').show();
            }
            if (status == 4) {
                 $('#big_table').dataTable().fnSetColumnVis([4], false);
                $('#reject').hide();
                $('#ban').hide();
                $('#approve').show();
                $('#delete').show();
            }

        });

        $('.changeMode').click(function () {
            $('.cs-loader').show();
            var table = $('#big_table');
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

                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
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

            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');





            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });



        });


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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/datatableStoreDetails/0',
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

        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

//        $('#downloadFile').click(function () {
//            $('#downloadModal').modal('show');
//        });
//
//        $('#complete').click(function () {
//            setTimeout(function () {
//                $('#downloadModal').modal('hide');
//            }, 3000);
//        });

        $('#approve').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val == '') {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('Please_select_the_product'); ?>');
//                alert('Inavalid Selection');
            } else {
                $('#approveModal').modal('show');

                $('.modalPopUpText').text('<?php echo $this->lang->line('Are_you_sure_to_approve_the_product?'); ?>')

            }
        });
        $('#yesApprove').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url('index.php?/AddNewProducts') ?>/approveStoreProduct",
                type: "POST",
                data: {val: val},
                dataType: 'JSON',
                success: function (response)
                {
                    $('#approveModal').modal('hide');
                     var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                     var status = urlChunks[urlChunks.length - 1];
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
                        "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/datatableStoreDetails/'+status,
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

                }

            });

        });

        $('#ban').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length < 0 || val == '') {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('Please_select_the_product'); ?>');
//             
            } else if (val.length > 1) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('Invalid_Selection'); ?>');
            } else {
                $('#banModal').modal('show');

                $('.modalPopUpText').text('<?php echo $this->lang->line('Are_you_sure_to_ban_the_product?'); ?>')

            }
        });
        $('#deactivateReason1').focus(function () {
            $('#yesReject').prop('disabled', false);
        });
        $('#deactivateReason').focus(function () {
            $('#yesBan').prop('disabled', false);
        });
         $('#deactivateNoReason').click(function () {
            if ($('#deactivateNoReason').is(':checked')) {
                $('#deactivateReason').val("");
                $('#deactivateReason').hide();
                $('#reasonLabel').hide();
                $('#yesBan').prop('disabled', false);
            } else {
                $('#deactivateReason').val("");
                $('#deactivateReason').show();
                $('#reasonLabel').show();
                $('#yesBan').prop('disabled', true);
            }
        });
         $('#deactivateNoReason1').click(function () {
            if ($('#deactivateNoReason1').is(':checked')) {
                $('#deactivateReason1').val("");
                $('#deactivateReason1').hide();
                $('#reasonLabel1').hide();
                $('#yesReject').prop('disabled', false);
            } else {
                $('#deactivateReason1').val("");
                $('#deactivateReason1').show();
                $('#reasonLabel1').show();
                $('#yesReject').prop('disabled', true);
            }
        });
        
        $('#yesBan').prop('disabled', true);
        $('#yesReject').prop('disabled', true);
        
        $('#yesBan').click(function () {
            var reasonText = $('#deactivateReason').val();
            if(reasonText == "" || reasonText == null){
                var reason = "No specific reason" ;
            }else{
                var reason = reasonText;
            }
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url('index.php?/AddNewProducts') ?>/banStoreProduct",
                type: "POST",
                data: {val: val,reason:reason},
                dataType: 'JSON',
                success: function (response)
                {
                    $('#banModal').modal('hide');
                     var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                     var status = urlChunks[urlChunks.length - 1];
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
                        "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/datatableStoreDetails/'+status,
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

                }

            });


        });
        $('#reject').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length < 0 || val == '') {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('Please_select_the_product'); ?>');
//             
            } else if (val.length > 1) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('Invalid_Selection'); ?>');
            } else {
                $('#rejectModal').modal('show');

                $('.modalPopUpText').text('<?php echo $this->lang->line('Are_you_sure_to_reject_the_product?'); ?>')

            }
        });
        $('#yesReject').click(function () {
            var reasonText = $('#deactivateReason1').val();
            if(reasonText == "" || reasonText == null){
                var reason = "No specific reason" ;
            }else{
                var reason = reasonText;
            }
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            
            $.ajax({
                url: "<?php echo base_url('index.php?/AddNewProducts') ?>/rejectStoreProduct",
                type: "POST",
                data: {val: val,reason:reason},
                dataType: 'JSON',
                success: function (response)
                {
                    $('#rejectModal').modal('hide');
                     var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                     var status = urlChunks[urlChunks.length - 1];
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
                        "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/datatableStoreDetails/'+status,
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

                }

            });


        });

//        $('#edit').click(function () {
//            var val = $('.checkbox:checked').map(function () {
//                return this.value;
//            }).get();
//
//            if (val.length < 0 || val == '') {
//                $('#errorModal').modal('show')
//                $(".modalPopUpText").text('Please select the Product');
////                alert('Inavalid Selection');
//            } else if (val.length > 1) {
//                $('#errorModal').modal('show')
//                $(".modalPopUpText").text('Please select only one Product');
//            }
//            if (val.length == 1) {
//                window.location.href = '<?php echo base_url(); ?>index.php?/AddNewProducts/EditStoreProducts/' + val;
//            }
//
//        });
//        $('#add').click(function () {
//            var val = $('.checkbox:checked').map(function () {
//                return this.value;
//            }).get();
//            if (val.length == 0) {
//                window.location.href = "<?php echo base_url(); ?>index.php?/AddNewProducts/addNewProductStore";
//            } else {
//                $('#errorModal').modal('show')
//                $(".modalPopUpText").text('Invalid Selection...');
//            }
//        });

        $("#delete").click(function () {

            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Please select the Product ');
            } else if (val.length >= 1)
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
                    $('#modalTitle').text('Delete');
                    $('.modalTitleText').text('Are you sure you want to delete the product?');
                }

                $("#confirmed").click(function () {
                    var val = $('.checkbox:checked').map(function () {
                        return this.value;
                    }).get();
                    $.ajax({
                        url: "<?php echo base_url('index.php?/AddNewProducts') ?>/deleteStoreProduct",
                        type: "POST",
                        data: {val: val},
                        dataType: 'JSON',
                        success: function (response)
                        {
                            $('#confirmmodel').modal('hide');
                            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                            var status = urlChunks[urlChunks.length - 1];
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/datatableStoreDetails/'+status,
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

                        }

                    });

                });
            }


        });
        setTimeout(function () {
            $('#flashdata').hide();
        }, 3000);









        $('#big_table').on("click", '.storeUnitsList', function () {

            $('#unitListData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/storeUnitsList/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    console.log(result);
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr style="font-size:14px; "><td style="text-align:center;width:200px;border-style: ridge;">' + row.name.en + '</td><td style="border-style: ridge;width:200px;text-align:center;">'+result.currencySymbol+ ' ' + row.price.en + '</td></tr>';

                        $('#unitListData').append(html);
                    });
                    $('#unitListModal').modal('show');
                }

            });
        });


    });

    function savealltext(i) {

        var id = $('#imgTextBtn' + i).attr('data-id');
        var imageid = $('#imgTextBtn' + i).attr('imageid');
        var imgText = $('#imgText' + i).val();
        var title = $('#title' + i).val();
        var description = $('#description' + i).val();
        var keyword = $('#keyword' + i).val();

        if (title.trim() == "") {
            title = imgText;
            $('#title' + i).val(title);
        }

        if (keyword.trim() == "") {
            keyword = description.replace(" ", ",");
        } else {
            keyword = keyword.replace(" ", ",");
        }
        $('#keyword' + i).val(keyword);

        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Uflyproducts/savealltext",
            type: "POST",
            data: {imgText: imgText, title: title, description: description, keyword: keyword, id: id, imageid: imageid, seq: i},
            success: function (result) {

            }
        });

    }

    function moveUp(id) {
        var row = $(id).closest('tr');
        var prev_id = row.prev('tr').find('.moveUp').attr('id')
        var curr_id = row.find('.moveUp').attr('id');

        console.log('prev id - ' + typeof (prev_id));

        if (typeof (prev_id) == 'undefined') {
            $('#errorModal').modal('show')
            $(".modalPopUpText").text('Not able to move up');
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/AddNewProducts/reorderStoreProductSequence",
                type: "POST",
                data: {kliye: 'interchange', curr_id: curr_id, prev_id: prev_id},
                success: function (result) {

                }
            });
            row.prev().insertAfter(row);
            $('#saveOrder').trigger('click');
//        });
        }
    }
    function moveDown(id) {

        var row = $(id).closest('tr');
        var prev_id = row.find('.moveDown').attr('id');
        var curr_id = row.next('tr').find('.moveDown').attr('id');
        if (typeof (curr_id) == 'undefined') {
            $('#errorModal').modal('show')
            $(".modalPopUpText").text('Not able to move down');
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/AddNewProducts/reorderStoreProductSequence",
                type: "POST",
                data: {kliye: 'interchange', prev_id: prev_id, curr_id: curr_id},
                success: function (result) {
                }
            });
            row.insertAfter(row.next());
            $('#saveOrder').trigger('click');
//        });
        }
    }
</script>


<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;">STORE PRODUCTS<?php // echo $this->lang->line('heading_Store_Products'); ?></strong>
        </div>
        <!-- Nav tabs --> 

        <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

            <li id="0" class="tabs_active <?php echo ($status == 0 ? "active" : ""); ?>" style="cursor:pointer">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/AddNewProducts/datatableStoreDetails/0"><span><?php echo $this->lang->line('pending_approval'); ?></span><span class="badge newDriverCount" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id="1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/AddNewProducts/datatableStoreDetails/1"><span><?php echo $this->lang->line('Approved'); ?></span> <span class="badge acceptedDriverCount" style="background-color:#3CB371;"></span></a>
            </li>
            <li id="4" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/AddNewProducts/datatableStoreDetails/4"><span><?php echo $this->lang->line('Ban'); ?></span> <span class="badge banDriverCount" style="background-color:#f0ad4e;"></span></a>
            </li>
            <li id="3" class="tabs_active <?php echo ($status == 4 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/AddNewProducts/datatableStoreDetails/3"><span><?php echo $this->lang->line('Rejected'); ?></span> <span class="badge rejectedDriverCount" style="background-color:#B22222;"></span></a>
            </li>
            <li id="2" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/AddNewProducts/datatableStoreDetails/2"><span><?php echo $this->lang->line('Deleted'); ?></span> <span class="badge rejectedDriverCount" style="background-color:#B22222;"></span></a>
            </li>

            <div class="pull-right m-t-10"> <button class="btn btn-success cls111" id="approve"><?php echo $this->lang->line('button_approve'); ?></button></div>
            <div class="pull-right m-t-10"> <button class="btn btn-danger cls111" id="reject"><?php echo $this->lang->line('button_reject'); ?></button></div>
            <div class="pull-right m-t-10"> <button class="btn btn-warning cls111" id="ban"><?php echo $this->lang->line('button_ban'); ?></button></div>
            <div class="pull-right m-t-10"> <button class="btn btn-danger cls111" id="delete"><?php echo $this->lang->line('button_delete'); ?></button></div>
            <!--<div class="pull-right m-t-10"> <button class="btn btn-info" id="edit"><?php echo $this->lang->line('button_edit'); ?></button></div>-->
            <!--<div class="pull-right m-t-10"> <button class="btn btn-primary" data-toggle="modal" data-target="#importmodal">Import File</button></div>-->
            <!--<div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10" id="add"><?php echo $this->lang->line('button_add'); ?> </button></a></div>-->
            <!--<div class="pull-right m-t-10"> <button class="btn btn-info btnClass" id="downloadFile" name="downloadFile" style="width: 125px;">Download Sample</button></div>-->

        </ul>
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
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" ><?php echo $this->lang->line('button_Yes'); ?></button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="reviewlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 180%;margin-left: -26%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4><?php echo $this->lang->line('Review_List'); ?></h4>
            </div>
            <div class="modal-body form-horizontal">

                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    <th style="width :72px !important;" >SL NO</th>
                    <th style="width :72px !important;" >CUSTOMER NAME</th>
                    <th style="width :72px !important;">CUSTOMER ID</th>
                    <th style="width :72px !important;">RATING</th>
                    <th style="width :50px !important;">REVIEW</th>
                    </thead>
                    <tbody id="review_data">
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<div class="modal fade stick-up" id="imagelist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 180%;margin-left: -26%;">
            <button type="button" class="close"  data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" id="close1" class="close" data-dismiss="modal">&times;</button>
                <h4>Image List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container">

                        <div id="myCarousel" class="carousel slide" data-ride="carousel" >
                            <!-- Indicators -->

                            <ol class="carousel-indicators" style="left: 47%;" id='indicator'>
                                <!--                                <li data-target="#myCarousel" id="myCarousel0" class="active"></li>
                                                                <li data-target="#myCarousel" ></li>
                                                                <li data-target="#myCarousel" ></li>-->
                                <!--<li data-target="#myCarousel" ></li>-->

                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox" id='imagedata'>
                                <!--                                <div class="item active" id="imagedata0">
                                                                </div>
                                                                <div class="item" id="imagedata1">
                                                                </div>
                                                                <div class="item" id="imagedata2">
                                                                </div>-->
                                <!--                                <div class="item" id="imagedata3">
                                                                </div>-->



                            </div>

                        </div>

                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>



<div class="modal fade stick-up" id="nutritionlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Nutrition List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="nutritiondata">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="flavoursList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Flavours List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="flavoursData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="unitListModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Unit List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="unitListData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="negativeAttributesList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Negative Attributes List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="negativeAttributesData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="medicalAttributesList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Medical Attributes List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="medicalAttributesData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="strainEffectsList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Strain Effects List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="strainEffectsData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>


<div class="modal fade stick-up" id="importmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="  width: 110%;">
            <form action="<?php echo base_url(); ?>index.php?/AddNewProducts/importExcel" method="post" name="upload_excel" enctype="multipart/form-data">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4>Upload File</h4>
                </div>
                <div class="modal-body">
                    <div class="row row-same-height">
                        <div align="center">
                            <div class="row">
                                <label class="col-sm-4 control-label"><h5>Excel File Upload</h5></label>
                                <input type="file" name="file" id="file" class="form-control col-sm-6" style="width:50% !important;">
                            </div>
                            <div class="row"></div>
                            <div class="row"></div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <button type="submit" id="submit" name="import" class='btn btn-primary pull-right'>Import</button>
                    </div>
                </div>
                <!-- /.modal-dialog -->
            </form>
        </div>
    </div>
</div>

<div id="downloadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Download Sample File</h4>
            </div>
            <div class="modal-body">
                <p class="error-box modalPopUpText">Are you sure you want to download the sample file..</p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo base_url(); ?>application/ajaxFile/ProductsSamplefile.csv" download="ProductsSamplefile.csv"><button class="btn btn-success btnClass" id="complete">Yes</button></a>
                <button type="button" class="btn btn-default" data-dismiss="modal">button_Cancel</button>
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
                <p class="error-box modalPopUpText"></p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade stick-up" id="viewDescriptionlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Detailed Description</h4>
            </div>
            <div class="modal-body form-horizontal">
                <div id="descriptionData"></div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="viewShortDescriptionlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Short Description</h4>
            </div>
            <div class="modal-body form-horizontal">
                <div id="shortDescriptionData"></div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="approveModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('button_approve'); ?></h4>
            </div>
            <div class="modal-body form-horizontal">
                <div id="approveText" class="modalPopUpText"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-right" id="yesApprove" ><?php echo $this->lang->line('button_Yes'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('button_Cancel'); ?></button>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="banModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('button_ban'); ?></h4>
            </div>
            <div class="modal-body form-horizontal">
                <div id="banText" class="modalPopUpText"></div>
                <div class="row">
                        <label id="reasonLabel" style="margin-left:20px">Reason</label>
                        <input type="text" style="margin-left:20px;width: 90% !important;" id="deactivateReason" name="deactivateReason" class="form-control reason"/>
                    </div>
                    <div class="row"></div>
                    <div class="row">

                        <input type="checkbox" style="margin-left:20px" id="deactivateNoReason" name="deactivateNoReason" class="reason"/>
                        <label>Do not prefer to specify the reason..!!</label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-right" id="yesBan" ><?php echo $this->lang->line('button_Yes'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('button_Cancel'); ?></button>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('button_reject'); ?></h4>
            </div>
            <div class="modal-body form-horizontal">
                <div id="rejectText" class="modalPopUpText"></div>
                <div class="error-box " id="inactiveData"></div>
                    <div class="row">
                        <label id="reasonLabel1" style="margin-left:20px">Reason</label>
                        <input type="text" style="margin-left:20px;width: 90% !important;" id="deactivateReason1" name="deactivateReason1" class="form-control reason"/>
                    </div>
                    <div class="row"></div>
                    <div class="row">

                        <input type="checkbox" style="margin-left:20px" id="deactivateNoReason1" name="deactivateNoReason1" class="reason"/>
                        <label>Do not prefer to specify the reason..!!</label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-right" id="yesReject" ><?php echo $this->lang->line('button_Yes'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('button_Cancel'); ?></button>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
