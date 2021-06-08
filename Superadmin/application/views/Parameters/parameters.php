
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
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
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
        $('#unhide').hide();

        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });

        $('.businesscat').addClass('active');
        $('.businesscat_thumb').addClass("bg-success");

        $('#btnStickUpSizeToggler').click(function () {
            $('#insert').prop('disabled', false);
            $("#display-data,#clearerror").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {

                $('#modalHeading').html('ADD NEW TEAM');
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
                $("#display-data").text("Please select any one parameter to delete ?");
            } else if (val.length >= 1)
            {
                $('#deleteconfirmed').show();
                $("#deleteerrorboxdata").text("Do you wish to delete the selected parameter ?");
                $("#display-data").text("");
                var BusinessId = val;

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#deleteconfirmmodel');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#deleteconfirmmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
            }

        });


        $("#deleteconfirmed").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url('index.php?/parametersController') ?>/deleteparams",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {
                    $(".close").trigger("click");
                    window.location.reload();
                }
            });
        });

        $('#hide').click(function () {
            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length < 0 || val.length == 0) {
                $('#displayData').modal('show');
                $("#display-data").text("Please select any one parameter to deactivate ?");
            } else if (val.length >= 1)
            {
                $("#hideconfirmed").show();

                $("#hideerrorboxdata").text("Do you wish to deactivate the selected parameter ?");
                $("#display-data").text("");
                var BusinessId = val;

                var size = $('input[name=stickup_toggler]:checked').val();
                var modalElem = $('#hideconfirmmodel');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show');
                } else {
                    $('#hideconfirmmodel').modal('show');
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

            }

        });

        $("#hideconfirmed").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url('index.php?/parametersController') ?>/hideparams",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {
                    $(".close").trigger("click");
                    window.location.reload();
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
                $("#display-data").text("Please select any one parameter to activate ?");
            } else if (val.length >= 1)
            {
                $("#unhideconfirmed").show();
                $("#unhideerrorboxdata").text("Do you wish to activate the selected parameter ?");
                $("#display-data").text("");
                var BusinessId = val;

                var size = $('input[name=stickup_toggler]:checked').val();
                var modalElem = $('#unhideconfirmmodel');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show');
                } else {
                    $('#unhideconfirmmodel').modal('show');
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

            }

        });


        $("#unhideconfirmed").click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            $.ajax({
                url: "<?php echo base_url('index.php?/parametersController') ?>/unhideparams",
                type: "POST",
                data: {val: val},
                dataType: 'json',
                success: function (response)
                {
                    $(".close").trigger("click");
                    window.location.reload();
                }
            });
        });

        $('#insert').click(function () {
            $(this).prop('disabled', false);
//            $('#clearerror').text("");
            var form_data = new FormData();

            var pname = new Array();
            $(".pname").each(function () {
                pname.push($(this).val());
                form_data.append('pName[]', $(this).val());
            });
//            $("input[type='checkbox']").val();
            var associateDelivery = '';
            if ($("input[name='Associated']").is(':checked')) {
                associateDelivery = $("input[name='Associated']:checked").val();
            }

//            var associateDelivery = $('#associateDelivery').val();
            form_data.append('associated', associateDelivery);
            
            var storeType = $("#storeType option:selected").val();
            var storeTypeMsg = $("#storeType option:selected").attr('data-name');

            form_data.append('storeType', storeType);
            form_data.append('storeTypeMsg', storeTypeMsg);

            var name = $('#Pname_0').val();
            if (name == '' || name == null)
            {
                $("#clearerror").text("Please enter the parameter Title");
            } else {
                $(this).prop('disabled', true);
                $.ajax({
                    url: "<?php echo base_url('index.php?/parametersController') ?>/insert_param",
                    type: 'POST',
                    data: form_data,
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
                $("#Pname").val("");

            }
        });

        var editval = '';
        $(document).on('click', '#btnEdit', function () {
            $("#display-data,#clearerror").text("");
            $('#modalHeading').html("EDIT PARAMETER");
            editval = $(this).val();
            console.log(editval);
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/parametersController/getparam",
                type: 'POST',
                data: {val: editval},
                dataType: 'JSON',
                success: function (response)
                {
                    $.each(response, function (index, row) {
                        console.log(row);
//                                      console.log(row._id.$id);
                        $('#editedId').val(row._id.$oid);
                        $('#editstoreType').val(row.storeType);
                        $('#editPname_0').val(row.name['en']);
<?php foreach ($language as $val) { ?>
                            $('#editPname_<?= $val['lan_id'] ?>').val(row.name['<?= $val['langCode'] ?>']);
<?php } ?>
                        if (row.associated == 1) {
                            $("#driver").attr('checked', true);
                        } else {
                            $("#order").attr('checked', true);
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

        });


        $('#editbusiness').click(function () {
            $(this).prop('disabled', false);
            $("#display-data,#clearerror").text("");
            var form_data = new FormData();
            var val = editval;
            $('.editclearerror').text("");

            var pname = new Array();
            $(".editpname").each(function () {
                pname.push($(this).val());
                form_data.append('pName[]', $(this).val());
            });

            form_data.append('editId', $("#editedId").val());

            var associateDelivery = '';
            if ($("input[name='editAssociated']").is(':checked')) {
                associateDelivery = $("input[name='editAssociated']:checked").val();
            }

            form_data.append('associated', associateDelivery);
            
            var storeType = $("#editstoreType option:selected").val();
            var storeTypeMsg = $("#editstoreType option:selected").attr('data-name');

            form_data.append('storeType', storeType);
            form_data.append('storeTypeMsg', storeTypeMsg);

            var name = $('#editPname_0').val();
            if (name == '' || name == null)
            {
                $("#clearerror").text("Please enter the name");
            } else {
                $(this).prop('disabled', true);
                $.ajax({
                    url: "<?php echo base_url('index.php?/parametersController') ?>/editparams",
                    type: 'POST',
                    data: form_data,
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
                    $('#btnStickUpSizeToggler').hide();
                    $('#bdelete').show();
                    $('#unhide').show();
                    $('#hide').hide();
                }
                if ($(this).data('id') == 2) {
                    $("#display-data").text("");
                    $('#btnStickUpSizeToggler').hide();
                    $('#bdelete').hide();
                    $('#unhide').hide();
                    $('#hide').hide();
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
                var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                var status = urlChunks[urlChunks.length - 1];
                if(status== 2 || status == "2"){
                  $("#big_table").dataTable().fnSetColumnVis([4], false);
                }

            } else {

                $('#btnStickUpSizeToggler').show();
                $('#bdelete').show();
                $('#unhide').hide();
                $('#hide').show();

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

    function openmodel(tbl) {
        alert();
        //  alert($(tbl).closest('tr').find('#AppCommission').val()); // table row ID );
        $('#popupPname').text($(tbl).closest('tr').find('#Pname').val());
        $('#popupPrate').text($(tbl).closest('tr').find('#Prate').val());

        $('#popupModal').modal('show');
    }

    function validatecat() {
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/parametersController/validate_catname",
            type: "POST",
            data: {catname: $('#catname_0').val()},
            dataType: "JSON",
            success: function (result) {

                // alert();
//                alert(result.count);
                console.log(result.count);
                $('#catname_0').attr('data', result.msg);

                if (result.count == true) {

                    $("#clearerror").html("Parameter name already exists.");
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/parametersController/datatable_parameters/1',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
//                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
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
        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });


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

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"><?php echo $this->lang->line('heading_page'); ?></strong>
        </div>

        <div class="panel panel-transparent ">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs  bg-white whenclicked">
                <li id= "my1" class="tabs_active active" style="cursor:pointer">
                    <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/parametersController/datatable_parameters/1" data-id="1"><span><?php echo $this->lang->line('heading_active'); ?></span><span class="badge" style="background-color: #337ab7;"></span></a>
                </li>

                <li id= "my2" class="tabs_active" style="cursor:pointer">
                    <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/parametersController/datatable_parameters/0" data-id="0"><span><?php echo $this->lang->line('heading_deactive'); ?></span> <span class="badge bg-red"></span></a>
                </li>
                <li id= "my3" class="tabs_active" style="cursor:pointer">
                    <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/parametersController/datatable_parameters/2" data-id="2"><span><?php echo $this->lang->line('heading_deleted'); ?></span> <span class="badge bg-red"></span></a>
                </li>
            </ul>

            <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">
                <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary btn-cons" id="unhide" style="background: #705ea9;border-color: #705ea9"><span><?php echo $this->lang->line('button_activate'); ?></button></a></div>
                <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary btn-cons" id="hide" style="background: #7e9490;border-color: #7e9490"><span><?php echo $this->lang->line('button_deactivate'); ?></button></a></div>
                <div class="pull-right m-t-10 cls111"> <button class="btn btn-primary btn-cons" id="bdelete" style="background: #d9534f;border-color: #d9534f"><span><?php echo BUTTON_DELETE; ?></button></a></div>
                <!--<div class="pull-right m-t-10 cls111"> <button class="btn btn-primary btn-cons" id="edit" style="background: #5bc0de;border-color: #5bc0de"><?php echo BUTTON_EDIT; ?></button></div>-->
                <div class="pull-right m-t-10  cls110"> <button class="btn btn-primary btn-cons" id="btnStickUpSizeToggler" style="background: #337ab7;border-color: #337ab7"><span><?php echo BUTTON_ADD; ?></button></a></div>
            </ul>
        </div>
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">


                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <!--<div class="error-box" id="display-data" style="text-align:center"></div>-->
                                <div class="modal fade" id="displayData" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <h5 class="error-box" id="display-data" style="text-align:center"></h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="searchbtn row clearfix pull-right" style="">

                                    <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>
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
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds1" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="deleteconfirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="deleteerrorboxdata" style="font-size: large;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="deleteconfirmed" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="hideconfirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="hideerrorboxdata" style="font-size: large;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="hideconfirmed" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="unhideconfirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="unhideerrorboxdata" style="font-size: large;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="unhideconfirmed" ><?php echo BUTTON_YES; ?></button>
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
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" ><?php echo BUTTON_YES; ?></button>
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
                    <h5>ADD NEW PARAMETER</h5>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-4 control-label">Title<span style="color:red;font-size: 14px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="Pname_0" name="Pname[0]"  class="pname form-control error-box-class" />
                            </div>
                        </div>
                    </div>

                    <div class="row" >
                        <?php
                        foreach ($language as $val) {
                            if ($val['Active'] == 1) {
                                ?>
                                <br/>
                                <div class="form-group formex" >
                                    <label for="fname" class="col-sm-4 control-label">Title(<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <input type="text"  id="Pname_<?= $val['lan_id'] ?>" name="Pname[<?= $val['lan_id'] ?>]"  class="pname form-control error-box-class" />
                                    </div>
                                </div>

                                <br/>

                            <?php } else { ?>
                                <br/>
                                <div class="form-group formex"  >
                                    <label for="fname" class="col-sm-4 control-label">Title(<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <input type="text"   id="Pname_<?= $val['lan_id'] ?>" name="Pname[<?= $val['lan_id'] ?>]"  class="pname form-control error-box-class" />
                                    </div>
                                </div>
                                <br/>
                                <?php
                            }
                        }
                        ?>
                    </div>
                  
                    <div class="row" style="margin-top:15px">
                        <div class="form-group formex" >
                            <label for="fname" class="col-sm-4 control-label">Associate with delivery<span style="color:red;font-size: 14px">*</span></label>
                            <div class="col-sm-6">
                                <label class="container">
                                    <input type="radio" name="Associated" value="1">
                                    <span class="checkmark">Associated with Driver</span>
                                </label>
                                <label class="container">
                                    <input type="radio" name="Associated" value="2" checked>
                                    <span class="checkmark">Associated with Order</span>
                                </label>                                                                                          
                            </div>
                        </div>
                    </div>

                    <div class="row">
                       <div class="form-group formex" >
                            <label class="col-sm-4 control-label"><?php echo "Store Type"; ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-4">
                            <select  class="form-control" name="storeType" id="storeType">
                                <option value="1" data-name="Food">Food</option>
                                <option value="2" data-name="Grocery">Grocery</option>
                                <option value="3" data-name="Fashion">Fashion</option>
                                <option value="4" data-name="Order Anything">Order Anything</option>
                                <option value="5" data-name="Laundry">Laundry</option>
                                <option value="6" data-name="Pharmacy">Pharmacy</option>
                                <option value="7" data-name="Send Anything">Send Anything</option>
                                <option value="8" data-name="Liquor">Liquor</option>
                            </select>
                            </div>
                        </div>
                    </div>

                </div>
                <br/>


                <div class="modal-footer">
                    <div class="col-sm-6 error-box" id="clearerror"></div>
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-2" >
                        <button type="button" class="btn btn-primary pull-right" id="insert" ><?php echo BUTTON_ADD; ?></button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
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
                    <h3 id='modalHeading'> </h3>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="editedId" style="  width: 219px;line-height: 2;" class="form-control error-box-class"/>
                    <div class="row">
                        <div class="form-group formex">
                            <label for="fname" class="col-sm-4 control-label">Title<span style="color:red;font-size: 18px">*</span></label>
                            <div class="col-sm-6">
                                <input type="text"  id="editPname_0" name="Pname[0]"  class="editpname form-control error-box-class" />
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <?php
                        foreach ($language as $val) {
                            if ($val['Active'] == 1) {
                                ?>
                                <br/>
                                <div class="form-group formex">
                                    <label for="fname" class="col-sm-4 control-label">Title(<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <input type="text"  id="editPname_<?= $val['lan_id'] ?>" name="Pname[<?= $val['lan_id'] ?>]"  class="editpname form-control error-box-class" />
                                    </div>
                                </div>

                                <br/>

                            <?php } else { ?>
                                <br/>
                                <div class="form-group formex"  >
                                    <label for="fname" class="col-sm-4 control-label">Title(<?php echo $val['lan_name']; ?>) </label>
                                    <div class="col-sm-6">
                                        <input type="text"   id="editPname_<?= $val['lan_id'] ?>" name="Pname[<?= $val['lan_id'] ?>]"  class="editpname form-control error-box-class" />
                                    </div>
                                </div>
                                <br/>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <br/>
                    <div class="row" style="margin-top:15px">
                        <div class="form-group formex" >
                            <label for="fname" class="col-sm-4 control-label">Associate with delivery</label>
                            <div class="col-sm-6">
                                <label class="container">
                                    <input type="radio" name="editAssociated" id="driver" value="1">
                                    <span class="checkmark">Associated with Driver</span>
                                </label>
                                <label class="container">
                                    <input type="radio" name="editAssociated" id="order" value="2">
                                    <span class="checkmark">Associated with Order</span>
                                </label>
                                                                                            <!--<input type="checkbox" id="associateDelivery" name="associateDelivery" value="1">-->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                       <div class="form-group formex" >
                            <label class="col-sm-4 control-label"><?php echo "Store Type"; ?><span class="MandatoryMarker">*</span></label>
                            <div class="col-sm-4">
                            <select  class="form-control" name="editstoreType" id="editstoreType">
                                <option value="1" data-name="Food">Food</option>
                                <option value="2" data-name="Grocery">Grocery</option>
                                <option value="3" data-name="Fashion">Fashion</option>
                                <option value="4" data-name="Order Anything">Order Anything</option>
                                <option value="5" data-name="Laundry">Laundry</option>
                                <option value="6" data-name="Pharmacy">Pharmacy</option>
                                <option value="7" data-name="Send Anything">Send Anything</option>
                                <option value="8" data-name="Liquor">Liquor</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <br/>
                </div>

                <div class="modal-footer">
                    <div class="col-sm-4 error-box" id="editclearerror"></div>
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4" >
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


<div class="modal fade stick-up" id="openmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">

                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>

                    </div>
                    <h3> <?php echo 'ratings'; ?></h3>
                </div>

                <div class="modal-body">

                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-10 control-label" ><?php echo ''; ?> <span id="popupPname"></span></label>
                        <div class="col-sm-2">
                            <span id="AppCommissionShow"></span>

                        </div>
                    </div>

                    <br>

                    <div class="col-sm-12">
                        <span id="ServiceChargeShow">--------------------------------------------------------------------------------------------------</span>
                    </div>
                    <br>
                    <div class="form-group" class="formex">
                        <div class="frmSearch">
                            <label for="fname" class="col-sm-10 control-label"><?php echo 'Avg Total'; ?></label>
                            <div class="col-sm-2">
                                <span id="TotalShow"></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
