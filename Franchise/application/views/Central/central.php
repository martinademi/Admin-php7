
<?php if ($this->session->flashdata('message')) { ?>
    <div align="center" id="flashdata" class="alert alert-danger">      
        <?php echo $this->session->flashdata('message') ?>
    </div>
<?php } ?>
<style>
    .btn{
        border-radius: 25px !important;
        font-size: 10px !important;
    }
    .dataTables_scrollHead{
        margin-bottom: -52px !important;
    }

    .carousel-inner > .item > img,
    .carousel-inner > .item > a > img {
        width: 70%;
        margin: auto;
    }
    span.abs_text {
        position: absolute;
        right:10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/CentralController/tax_details/1',
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

        $('#addsentral').show();
        $('#delete').show();
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

        $(document).on('click', '#custom', function () {

            var len = $('.customPriceField').length;
            var z = len + 1;
            var y = z + 1;
            var divElement1 = '<div class="customPriceField "><div class="form-group col-sm-12 customPriceField' + z + '">'
                    + '<label id="titleLabel' + z + '" for="fname" class="col-sm-4 control-label">addOn ' + z + ' </label>'
                    + '<div class="col-sm-6 pos_relative2">'
                    + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                    + '<input type="text" name="addOns[' + len + '][name][en]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                    + '</div>'
                    + '<div class=""></div>'
                    + '<button type="button" value="' + y + '"class="btn-default btnRemove removeButton">'
                    + '<span class="glyphicon glyphicon-remove"></span>'
                    + '</button>'
                    + '</div>'
                    + '<?php
foreach ($language as $val) {
    if ($val["Active"] == 1) {
        ?>'
                            + '<div class="form-group col-sm-12 customPriceField' + z + '">'
                            + '<label id="titleLabel' + z + '" for="fname" class="col-sm-4 control-label">addOn ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                            + '<div class="col-sm-6 pos_relative2">'
                            + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                            + '<input type="text" name="addOns[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                            + '</div>'
                            + '<div class=""></div>'
                            + '</div>'
                            + '<?php } else { ?>'
                            + '<div class="form-group col-sm-12 customPriceField' + z + '" style="display:none">'
                            + '<label id="titleLabel' + z + '" for="fname" class="col-sm-4 control-label">addOn ' + z + ' (<?php echo $val['lan_name']; ?>)</label>'
                            + '<div class="col-sm-6 pos_relative2">'
                            + '<span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>'
                            + '<input type="text" name="addOns[' + len + '][name][<?php echo $val['langCode']; ?>]" class="form-control productTitle" id="title' + z + '"  placeholder="Enter title">'
                            + '</div>'
                            + '<div class=""></div>'
                            + '</div>'
                            + '<?php
    }
}
?>'
                    + '<div class="selectedsizeAttr row"></div></div>';

            $('.customField').append(divElement1);

        });
        
        $('#big_table').on("click", '.addOnsList', function () {

            $('#addOnsListData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/CentralController/addOnsList/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html += '<tr><td style="text-align:center;width:250px;border-style: ridge;">' + k + '</td>';
                        html += '<td style="border-style: ridge;width:250px;text-align:center;">' + row.name.en + '</td></tr>';
                        
//                        html = '<tr style="font-size:14px; "><td style="text-align:center;width:250px;border-style: ridge;">' + k + '</td><td style="border-style: ridge;width:250px;text-align:center;">' + row.name.en + '</td></tr>';
                        k++;
                        
                    });
                    $('#addOnsListData').append(html);

                    $('#addOnsListModal').modal('show');
                }

            });
        });

    
        var editval = '';
//        $('#editTax').click(function () {
        $(document).on('click', '#editCentral', function () {
            console.log($(this).val());
            editval = $(this).val();
            window.location.href="<?php echo base_url() ?>index.php?/CentralController/editCentral/" + editval;

        });

        $("#yesEdit").click(function () {
            $(".error-box").text("");

            $(this).prop('disabled', false);

            var taxName = new Array();
            $(".edittaxname").each(function () {
                taxName.push($(this).val());
            });
            var taxDesc = new Array();
            $(".edittaxDescription").each(function () {
                taxDesc.push($(this).val());
            });
            var edittaxCode = $('#edittaxCode').val();
            var edittaxValue = $('#edittaxValue').val();
            var name = $('#editname_0').val();
            if (name == '' || name == null)
            {
                $('#name_0').focus();
                $("#text_name").text('<?php echo $this->lang->line('error_name'); ?>');
            } else if (edittaxValue == '' || edittaxValue == null)
            {
                $('#edittaxValue').focus();
                $("#text_edittaxValue").text('<?php echo $this->lang->line('error_value'); ?>');
            } else {
                $(this).prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/CentralController') ?>/editTax",
                    type: "POST",
                    data: {Id: editval, taxName: taxName, taxDescription: taxDesc, taxCode: edittaxCode, taxValue: edittaxValue},
                    success: function (result) {
                        console.log(result);
                        if (result == "true") {
                            $('#editTaxModal').modal('hide');
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
                var modalElem = $('#activateTax');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#activateTax').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxactivateTax").text('<?php echo $this->lang->line('alert_activate'); ?>');

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
                url: "<?php echo base_url('index.php?/CentralController') ?>/activateActon",
                type: "POST",
                data: {Id: val},
                success: function (result) {

                    var res = JSON.parse(result)
                    $('#activateTax').modal('hide');
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/CentralController/tax_details/2',
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
                        $(".modalPopUpText").text('Selected central addOn has not been activated');
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
                var modalElem = $('#deactivateTax');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#deactivateTax').modal('show')
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
                url: "<?php echo base_url('index.php?/CentralController') ?>/deactivateAction",
                type: "POST",
                data: {Id: val},
                success: function (result) {
                    console.log(JSON.parse(result));
                    var res = JSON.parse(result)
                    $('#deactivateTax').modal('hide');
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
                            "sAjaxSource": '<?php echo base_url() ?>index.php?/CentralController/tax_details/1',
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
        $("#delete").click(function () {
            tabURL = $('li.active').children("a").attr('data');

            $("#display-data").text("");
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });

            if (val.length >= 1) {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#deleteCentral');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#deleteCentral').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdelete").text('<?php echo $this->lang->line('alert_delete'); ?>');

            } else if (val.length == 0) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('<?php echo $this->lang->line('error_oneselect'); ?>');
            }

        });

        $('#yesdelete').click(function () {
            var val = [];
            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            $.ajax({
                url: "<?php echo base_url('index.php?/CentralController') ?>/deleteAction",
                type: "POST",
                data: {Id: val},
                success: function (result) {
                    console.log(JSON.parse(result));
                    var res = JSON.parse(result)
                    $('#deleteCentral').modal('hide');
                    if (res.flag == 0) {
                        window.location.reload();
                    } else {
                        $('#errorModal').modal('show')
                        $(".modalPopUpText").text('Selected central has not been deleted');
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
                    $('#addsentral').hide();
                    $('#delete').show();
                    $('#activate').show();
                    $('#deactivate').hide();
                }
                else if ($(this).data('id') == 3) {
                    $("#display-data").text("");
                    $('#addsentral').hide();
                    $('#delete').hide();
                    $('#activate').hide();
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

                $('#addsentral').show();
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

            <!-- <ul class="nav nav-tabs  bg-white whenclicked">
                <li id= "my1" class="tabs_active active" style="cursor:pointer">
                    <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/CentralController/tax_details/1" data-id="1"><span><?php echo $this->lang->line('heading_active'); ?></span><span class="badge" style="background-color: #337ab7;"></span></a>
                </li>

               
            </ul> -->
            <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

                <!-- <div class="pull-right m-t-10"> <button class="btn btn-info" id="deactivate"><?php echo $this->lang->line('button_deactivate'); ?></button></div> -->
                <div class="pull-right m-t-10"> <button class="btn btn-info" id="activate"><?php echo $this->lang->line('button_activate'); ?></button></div>
                <!-- <div class="pull-right m-t-10"> <button class="btn btn-info" id="delete"><?php echo $this->lang->line('button_delete'); ?></button></div> -->
                <!-- <div class="pull-right m-t-10"><a href="<?php echo base_url() ?>index.php?/CentralController/addCentral"> <button class="btn btn-success pull-right m-t-10" id="addsentral"><?php echo $this->lang->line('button_add'); ?> </button></a></div> -->

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
                    <div class="error-box modalPopUpText modalTitleText " style="color:red;" id="errorboxdata" ></div>
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

<div id="addTaxModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_add'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_Name'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="taxname form-control error-box-class" id="name_0" name="name[0]"  minlength="3" placeholder="Enter tax name" required="">  

                        </div>
                        <div class="col-sm-4 error-box" id="text_name" style="color:red"></div>
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-4 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-6">
                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['lan_id'] ?>]"  placeholder="Enter tax name" class="taxname error-box-class  form-control">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-4 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-6">
                                    <input type="text" id="name_<?= $val['lan_id'] ?>" name="name[<?= $val['lan_id'] ?>]"  placeholder="Enter name" class="taxname error-box-class  form-control">
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label"><?php echo $this->lang->line('label_Desc'); ?></label>
                        <div class="col-sm-6">
                            <textarea type="text" class="taxDescription form-control error-box-class" id="desc_0" name="description[0]"  minlength="3" placeholder="Enter tax description" required="" ></textarea> 

                        </div>
                        <!--<div class="col-sm-4 error-box" id="text_desc" style="color:red"></div>-->
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-4 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-6">
                                    <textarea type="text" id="desc_<?= $val['lan_id'] ?>" name="description[<?= $val['lan_id'] ?>]"  placeholder="Enter tax description" class="taxDescription error-box-class  form-control"></textarea>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-4 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-6">
                                    <textarea type="text" id="desc_<?= $val['lan_id'] ?>" name="description[<?= $val['lan_id'] ?>]"  placeholder="Enter tax description" class="taxDescription error-box-class  form-control"></textarea>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="customField">
                        <div class="customPriceField " id="customePriceMain">

                            <div class="form-group col-sm-12 customPriceField1">
                                <label id="titleLabel" for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_AddOns'); ?> 1<span style="" class="MandatoryMarker"> *</span></label>
                                <div class="col-sm-6 pos_relative2">
                                    <span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>
                                    <input type="text" name="addOns[0][name][en]" class="error-box-class  form-control productTitle" id="title0"  placeholder="Text Element ">
                                </div>
                                <div class="col-sm-1" id="text_productTitleText">
                                    <input type="button" id="custom" value="Add" class="btn btn-default pull-right marginSet btn-primary" style="width: 50px;margin-right: -15px;;border-radius: 25px;">

                                </div>
                                <!--<div class="col-sm-2 error-box redClass" id="text_productCustomText"></div>-->
                            </div>


                            <?php
                            foreach ($language as $val) {
                                if ($val['Active'] == 1) {
                                    ?>
                                    <div class="form-group col-sm-12 customPriceField1">
                                        <label id="titleLabel" for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_AddOns'); ?> 1(<?php echo $val['lan_name']; ?>)</label>
                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>
                                            <input type="text" name="addOns[0][name][<?= $val['langCode']; ?>]" class="error-box-class  form-control productTitle" id="title0"  placeholder="Text Element ">
                                        </div>
                                        <!--<div class="col-sm-2 error-box redClass" ></div>-->

                                    </div>
                                <?php } else { ?>
                                    <div class="form-group col-sm-12 customPriceField1" style="display:none">
                                        <label id="titleLabel" for="fname" class="col-sm-4 control-label"><?php echo $this->lang->line('label_AddOns'); ?> 1(<?php echo $val['lan_name']; ?>)</label>
                                        <div class="col-sm-6 pos_relative2">
                                            <span  class="abs_text"><b><?php echo $this->lang->line('label_Title'); ?></b></span>
                                            <input type="text" name="addOns[0][name][<?= $val['langCode']; ?>]" class="error-box-class  form-control productTitle" id="title0"  placeholder="Text Element ">
                                        </div>
                                        <!--<div class="col-sm-2 error-box redClass" ></div>-->

                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <div class="selectedsizeAttr row"></div>
                        </div>
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
<div id="editTaxModal" class="modal fade" role="dialog">
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
                            <input type="text" class="edittaxname form-control error-box-class" id="editname_0" name="taxName[0]"  minlength="3" placeholder="Enter tax name" required="">  

                        </div>
                        <div class="col-sm-4 error-box" id="text_name" style="color:red"></div>
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-5 pos_relative2">

                                    <input type="text" id="editname_<?= $val['lan_id'] ?>" name="taxName[<?= $val['lan_id'] ?>]"  placeholder="Enter tax name" class="edittaxname error-box-class  form-control">

                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Name'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-5 pos_relative2">

                                    <input type="text" id="editname_<?= $val['lan_id'] ?>" name="taxName[<?= $val['lan_id'] ?>]"  placeholder="Enter tax name" class="edittaxname error-box-class  form-control">

                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Desc'); ?></label>
                        <div class="col-sm-5">
                            <textarea type="text" class="edittaxDescription form-control error-box-class" id="editdesc_0" name="taxDescription[0]"  minlength="3" placeholder="Enter tax description" required="" ></textarea> 

                        </div>
                        <!--<div class="col-sm-4 error-box" id="text_desc" style="color:red"></div>-->
                    </div>
                    <?php
                    foreach ($language as $val) {
                        if ($val['Active'] == 1) {
                            ?>
                            <div class="form-group col-sm-12">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-5 pos_relative2">

                                    <textarea type="text" id="editdesc_<?= $val['lan_id'] ?>" name="taxDescription[<?= $val['lan_id'] ?>]"  placeholder="Enter tax description" class="edittaxDescription error-box-class  form-control"></textarea>

                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="form-group col-sm-12" style="display:none;">
                                <label for="fname" class="col-sm-3 control-label "><?php echo $this->lang->line('label_Desc'); ?> (<?php echo $val['lan_name']; ?>)</label>
                                <div class="col-sm-5 pos_relative2">

                                    <textarea type="text" id="editdesc_<?= $val['lan_id'] ?>" name="taxDescription[<?= $val['lan_id'] ?>]"  placeholder="Enter tax description" class="edittaxDescription error-box-class  form-control"></textarea>

                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Taxcode'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control error-box-class" id="edittaxCode" name="edittaxCode"  minlength="3" placeholder="Enter tax code" required="">  

                        </div>
                        <!--<div class="col-sm-4 error-box" id="text_edittaxCode" style="color:red"></div>-->
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('label_Taxvalue'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-5">
                            <span class="abs_text1 currencySymbol"><b>%</b></span>
                            <input type="text" class="form-control error-box-class" id="edittaxValue" name="edittaxValue"  minlength="3" placeholder="Enter tax code" required="">  

                        </div>
                        <div class="col-sm-4 error-box" id="text_edittaxValue" style="color:red"></div>
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


<div class="modal fade stick-up" id="activateTax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">ACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorboxactivateTax" style="text-align:center;    font-size: 14px;">Activate</div>
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

<div class="modal fade stick-up" id="deactivateTax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DEACTIVATE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorboxdeactivate" style="text-align:center;    font-size: 14px;"><?php echo VEHICLEMODEL_DELETE; ?></div>
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
<div class="modal fade stick-up" id="deleteCentral" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">DELETE</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorboxdelete" style="text-align:center;    font-size: 14px;"><?php echo VEHICLEMODEL_DELETE; ?></div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <div class="col-sm-4" ></div>
                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel51"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="yesdelete" ><?php echo $this->lang->line('button_delete'); ?></button></div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="addOnsListModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>AddOns List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:10%;text-align: center;">SI NO.</th>
                            <th style="width:10%;text-align: center;">ADD-ONS</th>
                        </tr>
                    </thead>
                    <tbody id="addOnsListData">

                    </tbody>
                </table>
<!--                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    <th>SI No.</th>
                    <th>add-Ons</th>
                    </thead>
                    <tbody >
                    <div class="container" id="addOnsListData">
                    </div>
                    </tbody>
                </table>-->
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
