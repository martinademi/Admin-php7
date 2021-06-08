
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
</script>
<script>
    var currentTab = 1;
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/BrandsController/data_details/1',
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

        $('#add').click(function () {
            $(".error-box").text("");
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
                    $('#addModal').modal('show');
                } else {
                    $('#alertForNoneSelected').modal('show');
                    $("#display-data").text("Invalid Selection");

                }
            } else {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Invalid Selection...');
            }
        });



        $(":file").on("change", function (e) {
            var fieldID = $(this).attr('id');
            var ext = $(this).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $(this).val('');
                alert('invalid extension..!   Please choose file type in (gif,png,jpg,jpeg)');
            } else
            {
                var type;
                var folderName;
                switch ($(this).attr('id'))
                {
                    case "banner_image":
                        type = 1; // banner image
                        folderName = 'bannerImages';
                        break;
                    case "logo_image":
                        type = 2; // logo image
                        folderName = 'logoImages';
                        break;
                    case "editbanner_image":
                        type = 3; // banner image
                        folderName = 'bannerImages';
                        break;
                    default :
                        type = 4; // logo image
                        folderName = 'logoImages';
                        break;

                }

                var formElement = $(this).prop('files')[0];
                var form_data = new FormData();

                form_data.append('OtherPhoto', formElement);
                form_data.append('type', 'brandImages');
                form_data.append('folder', folderName);
                $.ajax({
                    url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                    type: "POST",
                    data: form_data,
                    dataType: "JSON",
                    async: false,
                    beforeSend: function () {
                        //                    $("#ImageLoading").show();
                    },
                    success: function (result) {

                        switch (type)
                        {
                            case 1:
                                $('#bannerImage').val(result.fileName);
                                $('.bannerImage').attr('src', result.fileName);
                                $('.bannerImage').show();
                                break;
                            case 2:
                                $('#logoImage').val(result.fileName);
                                $('.logoImage').attr('src', result.fileName);
                                $('.logoImage').show();
                                break;
                            case 3:
                                $('#editbannerImage').val(result.fileName);
                                $('.editbannerImage').attr('src', result.fileName);
                                $('.editbannerImage').show();
                                break;
                            case 4:
                                $('#editlogoImage').val(result.fileName);
                                $('.editlogoImage').attr('src', result.fileName);
                                $('.editlogoImage').show();
                                break;

                        }


                    },
                    error: function () {

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        })


        $("#yesAdd").click(function () {

            $(".error-box").text("");

            $('#yesAdd').prop('disabled', false);

            var Name = new Array();
            $(".name").each(function () {
                Name.push($(this).val());
            });

            var Description = new Array();
            $(".Description").each(function () {
                Description.push($(this).val());
            });

            var bimg = $("#bannerImage").val();
            var logoimg = $("#logoImage").val();
            var bname = $('#name_0').val();
            if (bname == '' || bname == null)
            {
                $('#name_0').focus();
                $("#text_name").text('<?php echo $this->lang->line('error_name'); ?>');

            } else if (bimg == "" || bimg == null) {
                $('#banner_image').focus();
                $("#text_bimage").text("Please select the banner image");
            } else if (logoimg == "" || logoimg == null) {
                $('#logo_image').focus();
                $("#text_limage").text("Please select the logo image");
            } else {

                $('#yesAdd').prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/BrandsController') ?>/addBrand",
                    type: "POST",
                    dataType: 'json',
                    data: {brandName: Name, brandDescription: Description, bannerImage: bimg, logoImage: logoimg},
                    success: function (result) {
                        console.log(result)
                        if (result.flag == 1) {
                            $('#addModal').modal('hide');
                            window.location.reload();
                        } else if (result.flag == 0) {

                            $('#errorModal').modal('show')
                            $(".modalPopUpText").text('Brand Name is already exist');
                            $('#yesAdd').prop('disabled', false);
                        }
                    }
                });

            }
        });
        var editval = '';
//        $('#edit').click(function () {
        $(document).on('click', '#btnEdit', function () {
            $(".error-box").text("");
            $('.editbannerImage,.editlogoImage').attr('src',"");
            editval = $(this).val();

            $.ajax({
                url: "<?php echo base_url('index.php?/BrandsController') ?>/getBrand",
                type: "POST",
                dataType: 'json',
                data: {Id: editval},
                success: function (result) {
//                        var data = JSON.parse(result.data);
                    console.log(result.data)
                    $('#editname_0').val(result.data.name['en']);
<?php foreach ($language as $val) { ?>
                        $('#editname_<?= $val['lan_id'] ?>').val(result.data.name['<?= $val['langCode'] ?>']);
<?php } ?>
                    $('#editdesc_0').val(result.data.description['en']);
<?php foreach ($language as $val) { ?>
                        $('#editdesc_<?= $val['lan_id'] ?>').val(result.data.description['<?= $val['langCode'] ?>']);
<?php } ?>

                    if (result.data.bannerImage) {
                        $('#editbannerImage').val(result.data.bannerImage);
                        $('.editbannerImage').attr('src', result.data.bannerImage);
                        $('.editbannerImage').show();
                    }
                    if (result.data.logoImage) {
                        $('#editlogoImage').val(result.data.logoImage);
                        $('.editlogoImage').attr('src', result.data.logoImage);
                        $('.editlogoImage').show();
                    }
                    
                    $('#editModal').modal('show');

                }
            });

        });

        $("#yesEdit").click(function () {
            $(".error-box").text("");

            $(this).prop('disabled', false);

            var Name = new Array();
            $(".editname").each(function () {
                Name.push($(this).val());
            });
            var Desc = new Array();
            $(".editDescription").each(function () {
                Desc.push($(this).val());
            });
            var editbimg = $("#editbannerImage").val();
            var editlogoimg = $("#editlogoImage").val();
            var Bname = $('#editname_0').val();
            if (Bname == '' || Bname == null)
            {
                $('#editname_0').focus();
                $("#text_editname").text('<?php echo $this->lang->line('error_name'); ?>');
            } else {
                $(this).prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/BrandsController') ?>/editBrand",
                    type: "POST",
                    data: {Id: editval, brandName: Name, brandDescription: Desc,bannerImage: editbimg,logoImage: editlogoimg},
                    success: function (result) {
                        console.log(result);
                        if (result == "true") {
                            $('#editModal').modal('hide');
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
                var modalElem = $('#activateModal');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#activateModal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxactivate").text('<?php echo $this->lang->line('alert_activate'); ?>');

            } else if (val.length == 0) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_oneselect'); ?>');
            }

        });




        $("#yesActivate").click(function () {
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            $.ajax({
                url: "<?php echo base_url('index.php?/BrandsController') ?>/activateBrand",
                type: "POST",
                data: {Id: val},
                success: function (result) {

                    var res = JSON.parse(result)
                    $('#activateModal').modal('hide');
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/BrandsController/data_details/0',
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
                        $(".modalPopUpText").text('Selected brand has not been activated');
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
                var modalElem = $('#deactivateModal');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#deactivateModal').modal('show')
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
                url: "<?php echo base_url('index.php?/BrandsController') ?>/deactivateBrand",
                type: "POST",
                data: {Id: val},
                success: function (result) {
                    console.log(JSON.parse(result));
                    var res = JSON.parse(result)
                    $('#deactivateModal').modal('hide');
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/BrandsController/data_details/1',
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
                        $(".modalPopUpText").text('Selected brand has not been deactivated');
                    }


                }
            })
        });

        $("#AddSchedule").click(function () {
           $(".shiftName option:selected").removeAttr("selected");
           $(".shiftName").multiselect("refresh");

            $('#insert_cat_group').prop('disabled',false);
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length >= 1) {
                $("#msgpara").text("Invalid Selection");
                $("#msg_model").modal('show');
            } else
            {
                $('#myModal').modal('show');
                
            }
        });

         $("#insert_cat_group").click(function () {
        
            var catStatus = true;
         
           var shiftTimings = [];
            $(".shiftName option:selected").each(function () {            

                var $this = $(this);
                if ($this.length) {
                var selVal = $this.val();
                var shifttimings = {
                    shiftId: selVal,                    
                    }
                    shiftTimings.push(shifttimings);
                }
            });

            var shiftDetails=JSON.stringify(shiftTimings);
                       
             
            if (catStatus)
            {
                $("#insert_cat_group").prop("disabled",true);
        
                $.ajax({
                    url: "<?php echo base_url() ?>index.php?/brandsController/addBrands",
                    type: "POST",
                    data: {
                        
                        shiftDetails:shiftDetails,
                        status: 1                    
                    },
                    dataType: 'json',
                    success: function (response)
                    {
                        console.log(response);
                        $("#insert_cat_group").prop("disabled",false);
                        if (response.flag == 1)
                        {     

                          $('#myModal').modal('hide');   
                          // setTimeout(function(){ alert(response.msg); }, 2000);    
                          // location.reload();                

                          if(confirm(response.msg)){
                                window.location.reload();  
                            }
                        //   alert(response.msg)
                           
                                                                                 
                        }
                        else if(response.flag == 2){
                          $('#myModal').modal('hide');  
                         //  setTimeout(function(){ alert(response.msg); }, 2000);
                         // location.reload();

                         if(confirm(response.msg)){
                                window.location.reload();  
                            }
                         // alert()


                        }
                    }
                });
            }

        });

        $('.changeMode').click(function () {

            var tab_id = $(this).attr('data-id');

            if (currentTab != tab_id)
            {
//                console.log(tab_id);
                $('#big_table').hide();
                $("#display-data").text("");

                if ($(this).data('id') == 0) {
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
                    <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/BrandsController/data_details/1" data-id="1"><span><?php echo $this->lang->line('heading_active'); ?></span><span class="badge" style="background-color: #337ab7;"></span></a>
                </li>

                <li id= "my2" class="tabs_active" style="cursor:pointer">
                    <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/BrandsController/data_details/0" data-id="0"><span><?php echo $this->lang->line('heading_deactive'); ?></span> <span class="badge bg-red"></span></a>
                </li>

                <div class="pull-right m-t-10"> <button class="btn btn-info cls111" style="margin-top: 9px;" id="deactivate"><?php echo $this->lang->line('button_deactivate'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-info cls111" id="activate"><?php echo $this->lang->line('button_activate'); ?></button></div>
              
                <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10 cls110" style="margin-top: 9px;" id="AddSchedule"><?php echo $this->lang->line('button_add'); ?> </button></a></div>

            </ul>
            <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

                

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

<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_add'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label class="col-sm-5 control-label"><?php echo $this->lang->line('label_Name'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="name form-control error-box-class" id="name_0" name="name[0]"  minlength="3" placeholder="Enter brand name" required="">  

                        </div>
                        <div class="col-sm-5"></div>
                        <div class="col-sm-4 error-box" id="text_name" style="color:red"></div>
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-5 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-6 pos_relative2">

                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['lan_id'] ?>]"  placeholder="Enter brand name" class="name error-box-class  form-control">

                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-5 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-6 pos_relative2">

                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['lan_id'] ?>]"  placeholder="Enter brand name" class="name error-box-class  form-control">

                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-5 control-label"><?php echo $this->lang->line('label_Desc'); ?></label>
                        <div class="col-sm-6">
                            <textarea type="text" class="Description form-control error-box-class" id="desc_0" name="description[0]"  minlength="3" placeholder="Enter brand description" required="" ></textarea> 

                        </div>
                        <!--<div class="col-sm-4 error-box" id="text_desc" style="color:red"></div>-->
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-5 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-6 pos_relative2">

                                    <textarea type="text" id="desc_<?= $val['lan_id'] ?>" name="description[<?= $val['lan_id'] ?>]"  placeholder="Enter brand description" class="Description error-box-class  form-control"></textarea>

                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-5 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-6 pos_relative2">

                                    <textarea type="text" id="desc_<?= $val['lan_id'] ?>" name="description[<?= $val['lan_id'] ?>]"  placeholder="Enter brand description" class="Description error-box-class  form-control"></textarea>

                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>


                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-5 control-label">Banner Image<span class="MandatoryMarker"> *(max size - 2mb)</span></label>
                        <div class="col-sm-6">
                            <input type="file" class="addImage form-control error-box-class"  name="banner_image" id="banner_image"  placeholder="">
                            <input type="hidden" class="form-control" style="height: 37px;"  name="bannerImage" id="bannerImage">
                        </div>
                        <div class="col-sm-1">
                            <img src="" style="width: 35px; height: 35px; display: none;"
                                 class="bannerImage style_prevu_kit">
                        </div>
                        <div class="col-sm-5"></div>
                        <div class="col-sm-6 error-box" id="text_bimage" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-5 control-label">Logo<span class="MandatoryMarker"> *(max size - 2mb)</span></label>
                        <div class="col-sm-6">
                            <input type="file" class="addImage form-control error-box-class"  name="logo_image" id="logo_image"  placeholder="">
                            <input type="hidden" class=" form-control" style="height: 37px;"  name="logoImage" id="logoImage">
                        </div>
                        <div class="col-sm-1">
                            <img src="" style="width: 35px; height: 35px; display: none;"
                                 class="logoImage style_prevu_kit">
                        </div>
                        <div class="col-sm-5"></div>
                        <div class="col-sm-6 error-box" id="text_limage" style="color:red"></div>
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
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_edit'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label class="col-sm-5 control-label"><?php echo $this->lang->line('label_Name'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="editname form-control error-box-class" id="editname_0" name="name[0]"  minlength="3" placeholder="Enter brand name" required="">  

                        </div>
                        <div class="col-sm-5"></div>
                        <div class="col-sm-4 error-box" id="text_name" style="color:red"></div>
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-5 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-6 pos_relative2">

                                    <input type="text" id="editname_<?= $val['lan_id'] ?>" name="name[<?= $val['lan_id'] ?>]"  placeholder="Enter brand name" class="editname error-box-class  form-control">

                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-5 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-6 pos_relative2">

                                    <input type="text" id="editname_<?= $val['lan_id'] ?>" name="name[<?= $val['lan_id'] ?>]"  placeholder="Enter brand name" class="editname error-box-class  form-control">

                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-5 control-label"><?php echo $this->lang->line('label_Desc'); ?></label>
                        <div class="col-sm-6">
                            <textarea type="text" class="editDescription form-control error-box-class" id="editdesc_0" name="description[0]"  minlength="3" placeholder="Enter brand description" required="" ></textarea> 

                        </div>
                        <!--<div class="col-sm-4 error-box" id="text_desc" style="color:red"></div>-->
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-5 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-6 pos_relative2">

                                    <textarea type="text" id="editdesc_<?= $val['lan_id'] ?>" name="description[<?= $val['lan_id'] ?>]"  placeholder="Enter brand description" class="editDescription error-box-class  form-control"></textarea>

                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-5 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-6 pos_relative2">

                                    <textarea type="text" id="editdesc_<?= $val['lan_id'] ?>" name="description[<?= $val['lan_id'] ?>]"  placeholder="Enter brand description" class="editDescription error-box-class  form-control"></textarea>

                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-5 control-label">Banner Image<span class="MandatoryMarker"> *(max size - 2mb)</span></label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control error-box-class"  name="banner_image" id="editbanner_image"  placeholder="">
                            <input type="hidden" class="form-control" style="height: 37px;"  name="editbannerImage" id="editbannerImage">
                        </div>
                        <div class="col-sm-1">
                            <img src="" style="width: 35px; height: 35px; display: none;"
                                 class="editbannerImage style_prevu_kit">
                        </div>
                        <div class="col-sm-5"></div>
                        <div class="col-sm-6 error-box" id="text_editbimage" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-5 control-label">Logo<span class="MandatoryMarker"> *(max size - 2mb)</span></label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control error-box-class"  name="logo_image" id="editlogo_image"  placeholder="">
                            <input type="hidden" class=" form-control" style="height: 37px;"  name="editlogoImage" id="editlogoImage">
                        </div>
                        <div class="col-sm-1">
                            <img src="" style="width: 35px; height: 35px; display: none;"
                                 class="editlogoImage style_prevu_kit">
                        </div>
                        <div class="col-sm-5"></div>
                        <div class="col-sm-6 error-box" id="text_editlimage" style="color:red"></div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel6"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesEdit" ><?php echo $this->lang->line('button_save'); ?></button></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade stick-up" id="activateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">ACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorboxactivate" style="text-align:center;font-size: 14px;">Activate</div>
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

<div class="modal fade stick-up" id="deactivateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DEACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorboxdeactivate" style="text-align:center; font-size: 14px;"><?php echo VEHICLEMODEL_DELETE; ?></div>
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


<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <span class="modal-title" >ADD BRANDS</span>
            </div>
            <div class="modal-body">
                <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                <div class="form-group" id="notesId">
                        <label for="fname" class="col-sm-4 control-label">Brand Name</label>
                        <div class="col-md-6 col-sm-5 col-xs-12">
                            <select class="shiftName multiple form-control" name="shiftName[]" multiple="multiple">
                                    <?php                                 
                                        foreach ($shiftTimings as $result) {                                        
                                                echo "<option  value=" . $result['_id']['$oid'] . "  data-name='" . $result['shiftName'] . "'>" . $result['name']['en']. "</option>";                                        
                                        }                               
                                     ?>
                            </select>
                        </div>   
                        <div class="col-sm-3 error-box errors" id="shiftErr">
                        </div>                    
                    </div>

                    

                    
                   



                </form>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box errors responseErr"></div>
                <div class="col-sm-8" >
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right" id="insert_cat_group" ><?php echo "Add"; ?></button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $('.shiftName').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '100%',
        maxHeight: 300,
    });

   
</script>  