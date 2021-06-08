<style>

    #big_table_info, #big_table_paginate{
        display: none;
    }
    .cmn-toggle {
        position: absolute;
        margin-left: -9999px;

    }
    .cmn-toggle + label {
        display: block;
        position: relative;
        cursor: pointer;
        outline: none;
        user-select: none;
    }
    input.cmn-toggle-round + label {
        padding: 2px;
        width: 44px;
        height: 16px;
        background-color: #dddddd;
        border-radius: 60px;
    }
    input.cmn-toggle-round + label:before,
    input.cmn-toggle-round + label:after {
        display: block;
        position: absolute;
        top: 1px;
        left: 1px;
        bottom: 1px;
        content: "";
    }
    input.cmn-toggle-round + label:before {
        right: 1px;
        background-color: #f1f1f1;
        border-radius: 50px;
        transition: background 0.4s;
    }
    input.cmn-toggle-round + label:after {
        width: 16px;
        background-color: #fff;
        border-radius: 100%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        transition: margin 0.4s;
    }
    input.cmn-toggle-round:checked + label:before {
        background-color: #8ce196;
    }
    input.cmn-toggle-round:checked + label:after {
        margin-left:25px;
    }
</style>

<script type="text/javascript">


        function isNumberKey(evt, obj) {
            // onkeypress="return isNumberKey(event,this)"
            var charCode = (evt.which) ? evt.which : event.keyCode
            var value = obj.value;
            var dotcontains = value.indexOf(".") != -1;
            if (dotcontains)
                if (charCode == 46) return false;
            if (charCode == 46) return true;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

    var tabURL = '<?php echo base_url(); ?>index.php?/appVersions/datatable_appVersions/<?php echo $tab; ?>';
        var tabID = '1';
        var formName = 'driver_iosForm';
        var popUP = 'driver_iosPopUp';
        var inputFieldName = 'versionNo_driver_ios';
        var divErrFieldName = 'mandatory_driver_ios';
        var madantoryFiled;
        var platFormType = '';
        $(document).ready(function () {
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

            var table = $('#big_table');

            var searchInput = $('#search-table');
            searchInput.hide();
            table.hide();
            $('.cs-loader').show();
            setTimeout(function () {

                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": tabURL,
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "iDisplayStart ": 20,
                    "oLanguage": {
                        "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                    },
                    "fnInitComplete": function () {
                        $('.cs-loader').hide();
                        table.show()
                        searchInput.show()
                        $('.hide_show').show()
                    },
                    'fnServerData': function (sSource, aoData, fnCallback)
                    {
                        // csrf protection
                        aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
                        $.ajax
                                ({
                                    'dataType': 'json',
                                    'type': 'POST',
                                    'url': sSource,
                                    'data': aoData,
                                    'success': fnCallback
                                });
                    }, "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                        platFormType = nRow;
                    }
                };

                table.dataTable(settings);
            }, 1000);


            $(document).on('change', '.switch', function ()
            {

             

                 var urlChunks = $("li.active").find('.changeMode').attr('data');
                 var urldata=$("li.active").find('.changeMode').attr('data');
                
                 console.log(urlChunks);
                var isEnable = false;
                if ($('#' + $(this).attr('data-id')).is(':checked'))
                    isEnable = true;

               

                $.ajax({
                    url: "<?php echo APILink; ?>admin/appVersion",
                   
                    type: "PATCH",
                    headers: {
                        'language':'en'
                       
                    },
                    data: {type: $(this).attr('type'), version: $(this).attr('versionNo'), mandatory: isEnable},
                    dataType: 'json',
                    success: function (result) {

                        var settings = {
                            "autoWidth": false,
                            "sDom": "<'table-responsive't><'row'<p i>>",
                            "destroy": true,
                            "scrollCollapse": true,
                            "iDisplayLength": 20,
                            "bProcessing": true,
                            "bServerSide": true,
                            "sAjaxSource": urldata,
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "iDisplayStart ": 20,
                            "oLanguage": {
                                "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                            },
                            "fnInitComplete": function () {
                                $('.cs-loader').hide();
                                table.show()
                                searchInput.show()
                                $('.hide_show').show()
                            },
                            'fnServerData': function (sSource, aoData, fnCallback)
                            {
                                // csrf protection
                                aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
                                $.ajax
                                        ({
                                            'dataType': 'json',
                                            'type': 'POST',
                                            'url': sSource,
                                            'data': aoData,
                                            'success': fnCallback
                                        });
                            }, "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                                platFormType = nRow;
                            }
                        };

                        table.dataTable(settings);
                    }
                });
            });

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });

            var date = new Date();
            $('.datepicker-component').datepicker({
                startDate: date
            });

            $('#add').click(function ()
            {
                //Current tab
				
				 var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var st = urlChunks[urlChunks.length - 1];
		
                switch (st)
                {
                    case '21':
                        $('#driver_iosPopUp').modal('show');
                        popUP = 'driver_iosPopUp';
                        inputFieldName = 'versionNo_driver_ios';
                        divErrFieldName = 'versionNo_driver_iosErr';
                        break;
                    case '22':
                        $('#customer_iosPopUp').modal('show');
                        popUP = 'customer_iosPopUp';
                        inputFieldName = 'versionNo_customer_ios';
                        divErrFieldName = 'versionNo_customer_iosErr';
                        break;
                    case '23':
                        $('#store_iosPopUp').modal('show');
                        popUP = 'store_iosPopUp';
                        inputFieldName = 'versionNo_store_ios';
                        divErrFieldName = 'versionNo_store_iosErr';
                        break;
                    case '11':
                        $('#driver_andriodPopUp').modal('show');
                        popUP = 'driver_andriodPopUp';
                        inputFieldName = 'versionNo_driver_andriod';
                        divErrFieldName = 'versionNo_driver_andriodErr';
                        break;
                    case '12':
                        $('#customer_andriodPopUp').modal('show');
                        popUP = 'customer_andriodPopUp';
                        inputFieldName = 'versionNo_customer_andriod';
                        divErrFieldName = 'versionNo_customer_andriodErr';
                        break;
                    case '13':
                        $('#store_andriodPopUp').modal('show');
                        popUP = 'store_andriodPopUp';
                        inputFieldName = 'versionNo_store_andriod';
                        divErrFieldName = 'versionNo_store_andriodErr';
                        break;
                }

                $('.errors').text('');

            });


            $('.changeMode').click(function () {


                platFormType = '';
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
                    },
                    'fnServerData': function (sSource, aoData, fnCallback)
                    {
                        // csrf protection
                        aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
                        $.ajax
                                ({
                                    'dataType': 'json',
                                    'type': 'POST',
                                    'url': sSource,
                                    'data': aoData,
                                    'success': fnCallback
                                });
                    }, "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                       platFormType = nRow;

                    }
                };

                $('.tabs_active').removeClass('active');

                $(this).parent().addClass('active');

                $('#inactive').hide();
                $('#active').show();

                tabURL = $('li.active').children("a").attr('data');
                tabID = $('li.active').children("a").attr('data-id');

                table.dataTable(settings);


                // search box for table
                $('#search-table').keyup(function () {
                    table.fnFilter($(this).val());
                });

            });



            $('.insert').click(function ()
            {
                var type;
                var madantoryType = '';
               
                var methodType = '';
                var data;
 

                //Driver - 1
                //Customer - 2
 var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
 var urldata=$("li.active").find('.changeMode').attr('data');
            var st = urlChunks[urlChunks.length - 1];
		
                switch (st)
                {
                    case '21':
                        formName = 'driver_iosForm';
                       var typeName = 'ios_driver';
                        madantoryType = 'mandatory_driver_ios';
                        type = 21;
                        break;
                    case '22':
                        formName = 'customer_iosForm';
                        var typeName = 'ios_customer';
                        madantoryType = 'mandatory_customer_ios';
                        type = 22;
                        break;
                    case '23':
                        formName = 'store_iosForm';
                        var typeName = 'ios_store';
                        madantoryType = 'mandatory_store_ios';
                        type = 23;
                        break;
                    case '11':
                        formName = 'driver_andriodForm';
                       var typeName = 'andriod_driver';
                        madantoryType = 'mandatory_driver_andriod';
                        type = 11;
                        break;
                    case '12':
                        formName = 'customer_andriodForm';
                        var typeName = "andriod_customer";
                        madantoryType = 'mandatory_customer_andriod';
                        type = 12;
                        break;
                    case '13':
                        formName = 'store_andriodForm';
                       var  typeName = 'andriod_store';
                        madantoryType = 'mandatory_store_andriod';
                        type = 13;
                        break;
                }

                var madantoryFiled = false;
                if ($('#' + madantoryType).is(':checked'))
                    madantoryFiled = true;


                if (platFormType == '')
                {
                    methodType = 'POST';
					
                    data = {type: type, typeName: typeName, version: $('#' + inputFieldName).val(), mandatory: madantoryFiled};


                } else
                {
                    methodType = 'PATCH';
                    data = {type: type,version: $('#' + inputFieldName).val(), mandatory: madantoryFiled};
                }

                $('.errors').text('');
                if ($('#' + inputFieldName).val() == '')
                {
                    $('#' + divErrFieldName).text('App version should not be empty');
                } else {

                    var currentdate = new Date();
                    var datetime = currentdate.getFullYear() + "-" + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();

                    $('.time_hidden').val(datetime);

                    $.ajax({
                        url: "<?php echo APILink; ?>admin/appVersion",
                       
                        headers: {
                            "language": "en"
                        },
                        type: methodType,
                        data: data,
                        dataType: 'json',
                        success: function (result)
                        {

                            platFormType = '';
                            $('.close').trigger('click');
                            var table = $('#big_table');
                            var settings = {
                                "autoWidth": false,
                                "sDom": "<'table-responsive't><'row'<p i>>",
                                "destroy": true,
                                "scrollCollapse": true,
                                "iDisplayLength": 20,
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": urldata,
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {
                                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                                },
                                "fnInitComplete": function () {
                                    $('.cs-loader').hide();
                                    table.show()
                                    searchInput.show()
                                    $('.hide_show').show()
                                },
                                'fnServerData': function (sSource, aoData, fnCallback)
                                {
                                    // csrf protection
                                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
                                    $.ajax
                                            ({
                                                'dataType': 'json',
                                                'type': 'POST',
                                                'url': sSource,
                                                'data': aoData,
                                                'success': fnCallback
                                            });
                                }, "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                                    platFormType = nRow;
                                }
                            };

                            table.dataTable(settings);
//                     
                        }
                    });
                    $("#" + popUP).modal('hide');
                    $("#" + formName)[0].reset();
                }
            });

        });

</script>


<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;">

            <strong >APP VERSION</strong>
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  bg-white whenclicked">
                        <li id= "" class="tabs_active <?php echo ($tab == 21 ? "active" : ""); ?>" style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php?/appVersions/datatable_appVersions/21" data-id="21"><span><?php echo $this->lang->line('DRIVER_iOS'); ?></span></a>
                        </li>
                        <li id= "" class="tabs_active <?php echo ($tab == 22 ? "active" : ""); ?>" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/appVersions/datatable_appVersions/22" data-id="22"><span><?php echo $this->lang->line('CUSTOMER_iOS'); ?></span></a>
                        </li>
                        <li id= "" class="tabs_active <?php echo ($tab == 23 ? "active" : ""); ?>" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/appVersions/datatable_appVersions/23" data-id="23"><span><?php echo $this->lang->line('STORE_iOS'); ?></span></a>
                        </li>
                        <li id= "" class="tabs_active <?php echo ($tab == 11 ? "active" : ""); ?>" style="cursor:pointer">
                            <a class="changeMode" data="<?php echo base_url(); ?>index.php?/appVersions/datatable_appVersions/11" data-id="11"><span><?php echo $this->lang->line('DRIVER_ANDROID'); ?></span></a>
                        </li>
                        <li id= "" class="tabs_active <?php echo ($tab == 12 ? "active" : ""); ?>" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/appVersions/datatable_appVersions/12" data-id="12"><span><?php echo $this->lang->line('CUSTOMER_ANDROID'); ?></span></a>
                        </li>
                        <li id= "" class="tabs_active <?php echo ($tab == 13 ? "active" : ""); ?>" style="cursor:pointer">
                            <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/appVersions/datatable_appVersions/13" data-id="13"><span><?php echo $this->lang->line('STORE_ANDROID'); ?></span></a>
                        </li>
                        <div class="pull-right">
                            <div  class="pull-right m-t-10 cls110" ><button class="btn btn-primary " id="add">Add</button></div>

                        </div>

                    </ul>


                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="cs-loader">
                                            <div class="cs-loader-inner" >
                                                <label class="loaderPoint" style="color:#10cfbd">●</label>
                                                <label class="loaderPoint" style="color:red">●</label>
                                                <label class="loaderPoint" style="color:#FFD119">●</label>
                                                <label class="loaderPoint" style="color:#4d90fe">●</label>
                                                <label class="loaderPoint" style="color:palevioletred">●</label>
                                            </div>
                                        </div>


                                    </div>


                                </div>

                                <div class="panel-body">

                                    <?php
                                    echo $this->table->generate();
                                    ?>

                                </div>
                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade stick-up in" id="driver_iosPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <span class="modal-title"><?php echo $this->lang->line('ADD'); ?></span>

            </div>

            <div class="modal-body">
                <form action="" id="driver_iosForm" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Version_No'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="versionNo_driver_ios" name="versionNo" class="form-control error-box-class " placeholder="Enter version no" >

                        </div>
                        <div class="col-sm-3 error-box errors" id="versionNo_driver_iosErr">

                        </div> 
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Update_Mandatory'); ?></label>
                        <div class="col-sm-6">
                            <div class="switch">
                                <input id="mandatory_driver_ios" name="mandatory" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                <label for="mandatory_driver_ios"></label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="date" class="time_hidden" value="" />
                    <input type="hidden" name="platform"  value="ios" />
                    <input type="hidden" name="appType"  value="driver" />

                </form>


            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box ResponseErr errors"></div>
                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right insert"><?php echo $this->lang->line('Add'); ?> </button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('Cancel'); ?></button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up in" id="customer_iosPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <span class="modal-title"><?php echo $this->lang->line('ADD'); ?></span>

            </div>

            <div class="modal-body">
                <form action="" id="customer_iosForm" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Version_No'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="versionNo_customer_ios" name="versionNo" class="form-control error-box-class " placeholder="Enter version no">

                        </div>
                        <div class="col-sm-3 error-box errors" id="versionNo_customer_iosErr">

                        </div> 
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Update_Madatory'); ?></label>
                        <div class="col-sm-6">
                            <div class="switch">
                                <input id="mandatory_customer_ios" name="mandatory" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                <label for="mandatory_customer_ios"></label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="time_hidden" name="date"  value="" />
                    <input type="hidden" name="platform" value="ios" />
                    <input type="hidden" name="appType"  value="customer" />

                </form>


            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box ResponseErr errors"></div>
                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right insert"><?php echo $this->lang->line('Add'); ?> </button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('Cancel'); ?></button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up in" id="store_iosPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <span class="modal-title"><?php echo $this->lang->line('ADD'); ?></span>

            </div>

            <div class="modal-body">
                <form action="" id="store_iosForm" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Version_No'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="versionNo_store_ios" name="versionNo" class="form-control error-box-class " placeholder="Enter version no">

                        </div>
                        <div class="col-sm-3 error-box errors" id="versionNo_store_iosErr">

                        </div> 
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Update_Madatory'); ?></label>
                        <div class="col-sm-6">
                            <div class="switch">
                                <input id="mandatory_store_ios" name="mandatory" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                <label for="mandatory_store_ios"></label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="time_hidden" name="date"  value="" />
                    <input type="hidden" name="platform" value="ios" />
                    <input type="hidden" name="appType"  value="customer" />

                </form>


            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box ResponseErr errors"></div>
                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right insert"><?php echo $this->lang->line('Add'); ?> </button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('Cancel'); ?></button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up in" id="driver_andriodPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <span class="modal-title"><?php echo $this->lang->line('ADD'); ?></span>

            </div>

            <div class="modal-body">
                <form action="" id="driver_andriodForm" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Version_No'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="versionNo_driver_andriod" name="versionNo" class="form-control error-box-class " placeholder="Enter version no">

                        </div>
                        <div class="col-sm-3 error-box errors" id="versionNo_driver_andriodErr">

                        </div> 
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Update_Madatory'); ?></label>
                        <div class="col-sm-6">
                            <div class="switch">
                                <input id="mandatory_driver_andriod" name="mandatory" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                <label for="mandatory_driver_andriod"></label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="time_hidden" name="date"  value="" />
                    <input type="hidden" name="platform" value="android" />
                    <input type="hidden" name="appType" value="driver" />

                </form>


            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box ResponseErr errors"></div>
                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right insert"><?php echo $this->lang->line('Add'); ?> </button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('Cancel'); ?></button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up in" id="customer_andriodPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <span class="modal-title"><?php echo $this->lang->line('ADD'); ?></span>

            </div>

            <div class="modal-body">
                <form action="" id="customer_andriodForm" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Version_No'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="versionNo_customer_andriod" name="versionNo" class="form-control error-box-class " placeholder="<?php echo $this->lang->line('Enter_version_no'); ?>">

                        </div>
                        <div class="col-sm-3 error-box errors" id="versionNo_customer_andriodErr">

                        </div> 
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Update_Madatory'); ?></label>
                        <div class="col-sm-6">
                            <div class="switch">
                                <input id="mandatory_customer_andriod" name="mandatory" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                <label for="mandatory_customer_andriod"></label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="time_hidden" name="date"  value="" />
                    <input type="hidden" name="platform" value="android" />
                    <input type="hidden" name="appType" value="customer" />

                </form>


            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box ResponseErr errors"></div>
                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right insert"><?php echo $this->lang->line('Add'); ?> </button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('Cancel'); ?></button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up in" id="store_andriodPopUp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <span class="modal-title"><?php echo $this->lang->line('ADD'); ?></span>

            </div>

            <div class="modal-body">
                <form action="" id="store_andriodForm" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('Version_No'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" id="versionNo_store_andriod" name="versionNo" class="form-control error-box-class " placeholder="Enter version no">

                        </div>
                        <div class="col-sm-3 error-box errors" id="versionNo_store_andriodErr">

                        </div> 
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label col-md-3"><?php echo $this->lang->line('Update_Madatory'); ?></label>
                        <div class="col-sm-6">
                            <div class="switch">
                                <input id="mandatory_store_andriod" name="mandatory" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                <label for="mandatory_store_andriod"></label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="time_hidden" name="date"  value="" />
                    <input type="hidden" name="platform" value="android" />
                    <input type="hidden" name="appType" value="customer" />

                </form>


            </div>
            <div class="modal-footer">

                <div class="col-sm-4 error-box ResponseErr errors"></div>
                <div class="col-sm-8">
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-primary pull-right insert"> <?php echo $this->lang->line('Add'); ?></button></div>
                    <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel"><?php echo $this->lang->line('Cancel'); ?></button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


