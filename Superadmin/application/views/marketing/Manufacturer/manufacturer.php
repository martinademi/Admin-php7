
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Manufacturer_Controller/datatableManufacturer/1',
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
            }
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
            $(".manufacturerName").val("");
            $(".Description").val("");
            $('.error-box').text("");
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
                    $('#addManufacturerModal').modal('show');
                    $('#yesAdd').prop('disabled', false);
                } else {
                    $('#alertForNoneSelected').modal('show');
                    $("#display-data").text("<?php echo $this->lang->line('error_Invalid'); ?>");

                }
            } else {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_Invalid'); ?>');
            }
        });

        $("#yesAdd").click(function () {

            $(".error-box").text("");

            

            var Name = new Array();
            $(".manufacturerName").each(function () {
                
                    Name.push($(this).val());
            });
            var Description = new Array();
            $(".Description").each(function () {
                
                    Description.push($(this).val());
            });

            if (Name.length <= 0 )
            {
                $('#name_0').focus();
                $(".error-box").text('<?php echo $this->lang->line('error_name'); ?>');
            } else if( $('#name_0').val() == '' || $('#name_0').val() == null){
                 $('#name_0').focus();
                $(".error-box").text('<?php echo $this->lang->line('error_name'); ?>');
            }else {

                $('#yesAdd').prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/Manufacturer_Controller') ?>/addManufacturer",
                    type: "POST",
                    dataType: 'json',
                    data: {Name: Name, Description: Description},
                    success: function (result) {
                        console.log(result)
                        if (result.flag == 1) {
                            $('#addManufacturerModal').modal('hide');
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/Manufacturer_Controller/datatableManufacturer/1',
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
                                }
                            };
                            table.dataTable(settings);
                        } else if (result.flag == 0) {

                            $('#errorModal').modal('show')
                            $(".modalPopUpText").text('Name is already exist');
                            $('#yesAdd').prop('disabled', false);
                        }
                    }
                });
            }
            $(".error-box-class").val("");
        });
        
        var editval = '';
//        $('#edit').click(function () {
        $(document).on('click','#btnEdit',function () {
            $('.error-box').text("");
             editval = $(this).val();

                $.ajax({
                    url: "<?php echo base_url('index.php?/Manufacturer_Controller') ?>/getOneManufacturer",
                    type: "POST",
                    dataType: 'json',
                    data: {Id: editval},
                    success: function (result) {
//                        var data = JSON.parse(result.data);
                        console.log(result.data)

                        $('#editname_0').val(result.data.Name[0]);
<?php  foreach ($language as $val) { ?>
                            $('#editname_<?= $val['lan_id'] ?>').val(result.data.Name[<?= $val['lan_id'] ?>]);
<?php } ?>
                        $('#editdesc_0').val(result.data.Description[0]);
<?php foreach ($language as $val) { ?>
                            $('#editdesc_<?= $val['lan_id'] ?>').val(result.data.Description[<?= $val['lan_id'] ?>]);
<?php } ?>


                        $('#editManufacturerModal').modal('show');

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

            if (Name.length <= 0)
            {
                $('#name_0').focus();
                $(".error-box").text('<?php echo $this->lang->line('error_name'); ?>');
            } else {
                $(this).prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/Manufacturer_Controller') ?>/editManufacturer",
                    type: "POST",
                    data: {Id: editval, Name: Name, Desc: Desc},
                    success: function (result) {
                        console.log(result);
                        if (result == "true") {
                            $('#editManufacturerModal').modal('hide');
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
                var modalElem = $('#activateManufacturer');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#activateManufacturer').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxactivateManufacturer").text('<?php echo $this->lang->line('alert_activate'); ?>');

            } else if (val.length < 1) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_select'); ?>');
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
                url: "<?php echo base_url('index.php?/Manufacturer_Controller') ?>/activateManufacturer",
                type: "POST",
                data: {Id: val},
                success: function (result) {

                    var res = JSON.parse(result)
                    $('#activateManufacturer').modal('hide');
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Manufacturer_Controller/datatableManufacturer/2',
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
                            }
                        };

                        table.dataTable(settings);
                    } else {
                        $('#errorModal').modal('show')
                        $(".modalPopUpText").text('Selected color has not been activated');
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
                var modalElem = $('#deactivateManufacturer');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#deactivateManufacturer').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdeactivate").text('<?php echo $this->lang->line('alert_deactivate'); ?>');

            } else if (val.length < 1) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_Invalid'); ?>');
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
                url: "<?php echo base_url('index.php?/Manufacturer_Controller') ?>/deactivateManufacturer",
                type: "POST",
                data: {Id: val},
                success: function (result) {
                    console.log(JSON.parse(result));
                    var res = JSON.parse(result)
                    $('#deactivateManufacturer').modal('hide');
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/Manufacturer_Controller/datatableManufacturer/1',
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
                            }
                        };

                        table.dataTable(settings);
                    } else {
                        $('#errorModal').modal('show')
                        $(".modalPopUpText").text('Selected color has not been deactivated');
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
                    }
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
                    }
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
                    <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/Manufacturer_Controller/datatableManufacturer/1" data-id="1"><span><?php echo $this->lang->line('heading_active'); ?></span><span class="badge" style="background-color: #337ab7;"></span></a>
                </li>

                <li id= "my2" class="tabs_active" style="cursor:pointer">
                    <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/Manufacturer_Controller/datatableManufacturer/2" data-id="2"><span><?php echo $this->lang->line('heading_deactive'); ?></span> <span class="badge bg-red"></span></a>
                </li>
            </ul>
            <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

                <div class="pull-right m-t-10"> <button class="btn btn-info" id="deactivate"><?php echo $this->lang->line('button_deactivate'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-info" id="activate"><?php echo $this->lang->line('button_activate'); ?></button></div>
                <!--<div class="pull-right m-t-10"> <button class="btn btn-info" id="edit"><?php echo $this->lang->line('button_edit'); ?></button></div>-->
                <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10" id="add"><?php echo $this->lang->line('button_add'); ?> </button></a></div>

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

<div id="addManufacturerModal" class="modal fade" role="dialog">
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
                        <div class="col-sm-5">
                            <input type="text" class="manufacturerName form-control error-box-class" id="name_0" name="Name[0]"   placeholder="Enter  name" required="">  

                        </div>
                        <div class="col-sm-4 error-box" id="text_name" style="color:red"></div>
                    </div>
                    <?php foreach ($language as $val) { if($val['Active'] == 1){?>
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                            <div class="col-sm-5 pos_relative2">

                                <input type="text" id="name_<?= $val['lan_id'] ?>" name="Name[<?= $val['lan_id'] ?>]"  placeholder="Enter  name" class="manufacturerName error-box-class  form-control">

                            </div>

                        </div>
                    <?php } else {?>
                    <div class="form-group col-sm-12" style="display:none">
                            <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                            <div class="col-sm-5 pos_relative2">

                                <input type="text" id="name_<?= $val['lan_id'] ?>" name="Name[<?= $val['lan_id'] ?>]"  placeholder="Enter  name" class="manufacturerName error-box-class  form-control">

                            </div>

                        </div>
                    <?php } }?>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Desc'); ?></label>
                        <div class="col-sm-5">
                            <textarea type="text" class="Description form-control error-box-class" id="desc_0" name="Description[0]"  minlength="3" placeholder="Enter  description" required="" ></textarea> 

                        </div>
                        <!--<div class="col-sm-4 error-box" id="text_desc" style="color:red"></div>-->
                    </div>
                    <?php foreach ($language as $val) { if($val['Active']==1){ ?>
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                            <div class="col-sm-5 pos_relative2">

                                <textarea type="text" id="desc_<?= $val['lan_id'] ?>" name="Description[<?= $val['lan_id'] ?>]"  placeholder="Enter  description" class="Description error-box-class  form-control"></textarea>

                            </div>

                        </div>
                    <?php } else{?>
                    <div class="form-group col-sm-12"style="display:none">
                            <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                            <div class="col-sm-5 pos_relative2">

                                <textarea type="text" id="desc_<?= $val['lan_id'] ?>" name="Description[<?= $val['lan_id'] ?>]"  placeholder="Enter  description" class="Description error-box-class  form-control"></textarea>

                            </div>

                        </div>
                    <?php } }?>

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
<div id="editManufacturerModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_edit'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Name'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-5">
                            <input type="text" class="editname form-control error-box-class" id="editname_0" name="Name[0]"  minlength="3" placeholder="Enter  name" required="">  

                        </div>
                        <div class="col-sm-4 error-box" id="text_nameErr" style="color:red"></div>
                    </div>
                    <?php foreach ($language as $val) { if($val['Active']==1){?>
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                            <div class="col-sm-5 pos_relative2">

                                <input type="text" id="editname_<?= $val['lan_id'] ?>" name="Name[<?= $val['lan_id'] ?>]"  placeholder="Enter  name" class="editname error-box-class  form-control">

                            </div>

                        </div>
                    <?php } else {?>
                    <div class="form-group col-sm-12" style="display:none;">
                            <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                            <div class="col-sm-5 pos_relative2">

                                <input type="text" id="editname_<?= $val['lan_id'] ?>" name="Name[<?= $val['lan_id'] ?>]"  placeholder="Enter  name" class="editname error-box-class  form-control">

                            </div>

                        </div>
                    <?php } } ?>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Desc'); ?></label>
                        <div class="col-sm-5">
                            <textarea type="text" class="editDescription form-control error-box-class" id="editdesc_0" name="Description[0]"  minlength="3" placeholder="Enter description" required="" ></textarea> 

                        </div>
                        <!--<div class="col-sm-4 error-box" id="text_desc" style="color:red"></div>-->
                    </div>
                    <?php foreach ($language as $val) { if($val['Active'] == 1){?>
                        <div class="form-group col-sm-12">
                            <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                            <div class="col-sm-5 pos_relative2">

                                <textarea type="text" id="editdesc_<?= $val['lan_id'] ?>" name="Description[<?= $val['lan_id'] ?>]"  placeholder="Enter  description" class="editDescription error-box-class  form-control"></textarea>

                            </div>

                        </div>
                    <?php } else{?>
                    <div class="form-group col-sm-12" style="display:none">
                            <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                            <div class="col-sm-5 pos_relative2">

                                <textarea type="text" id="editdesc_<?= $val['lan_id'] ?>" name="Description[<?= $val['lan_id'] ?>]"  placeholder="Enter  description" class="editDescription error-box-class  form-control"></textarea>

                            </div>

                        </div>
                    <?php } }?>
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


<div class="modal fade stick-up" id="activateManufacturer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">ACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorboxactivateManufacturer" style="text-align:center">Activate</div>
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

<div class="modal fade stick-up" id="deactivateManufacturer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DEACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box modalPopUpText" id="errorboxdeactivate" ><?php echo VEHICLEMODEL_DELETE; ?></div>
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
