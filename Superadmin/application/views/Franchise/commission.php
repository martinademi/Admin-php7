
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Franchise/commission_details/0',
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
        $('#storeid').on('change', function () {
            if ($('#storeid option:selected').val() != "") {
                var defaultComm = '<?php echo $defaultCommission['storeDefaultCommission']; ?>';
                $('#commission').val(defaultComm);
            } else {
                $('#commission').val('');
            }
        });

        $('#add').click(function () {

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
                    $('#addCommission').modal('show');
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

            var storeId = $('#storeid option:selected').val();
            var storeName = $('#storeid option:selected').attr('data-name');
            $('#storeName').val(storeName);

            var commissionType = $('.ctype_:checked').val();
            console.log(commissionType);
            var commission = $('#commission').val();

            if (storeId == '' || storeId == null) {
                $('#storeid').focus();
                $("#text_store").text('<?php echo $this->lang->line('error_store'); ?>');
            } else if (commissionType == '' || commissionType == null) {
                $('#ctype_').focus();
                $("#text_ctype").text('<?php echo $this->lang->line('error_ctype'); ?>');
            } else if (commission == '' || commission == null) {
                $('#commission').focus();
                $("#text_comm").text('<?php echo $this->lang->line('error_comm'); ?>');
            } else {

                $('#yesAdd').prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/Franchise') ?>/addCommission",
                    type: "POST",
                    dataType: 'json',
                    data: {storeId: storeId, storeName: storeName, commissionType: commissionType, commission: commission},
                    success: function (result) {
                        console.log(result)
                        if (result.flag == 1) {
                            $('#addCommission').modal('hide');
                            window.location.reload();
                        } else if (result.flag == 0) {

                            $('#errorModal').modal('show')
                            $(".modalPopUpText").text('Color Name is already exist');
                            $('#yesAdd').prop('disabled', false);
                        }
                    }

                });
                $(".error-box-class").val("");
                $(".ctype_").val("");
            }

        });

//        $('#edit').click(function () {
        var editval = '';
        $(document).on('click','#btnEdit',function () {
           editval = $(this).val()

                $.ajax({
                    url: "<?php echo base_url('index.php?/Franchise') ?>/getCommissionData",
                    type: "POST",
                    dataType: 'json',
                    data: {Id: editval},
                    success: function (result) {

                        console.log(result.data._id.$oid)
                        $('#editFranchiseid').val(result.data._id.$oid);
                        console.log(result.data.commissionType);
                        if (result.data.commissionType == 0) {
                            $('input:radio[name="editctype"][value="0"]').attr('checked', true);
                        } else if (result.data.commissionType == 1) {
                            $('input:radio[name="editctype"][value="1"]').attr('checked', true);
                        }

                        $('#editcommission').val(result.data.commission);

//                        $('#editsubSubCategory').load("<?php echo base_url('index.php?/sizeController') ?>/getSubsubCategoryDataList", {subCategoryId: result.data.subCategoryId, subSubCategoryId: result.data.subSubCategoryId});
//                        $('#editsubSubCategory').val(result.data.subSubCategoryId);
//
//                        $('#editthirdCategoryName').val(result.data.subSubCategoryName);


                        $('#editCommissionModal').modal('show');

                    }
                });
           

        });


        $("#yesEdit").click(function () {
            $(".error-box").text("");

            $(this).prop('disabled', false);
            var storeId = $('#editFranchiseid option:selected').val();
            var storeName = $('#editFranchiseid option:selected').attr('data-name');
            $('#editfranchiseName').val(storeName);

            var commissionType = $('.editctype_:checked').val();
            console.log(commissionType);
            var commission = $('#editcommission').val();

            if (storeId == '' || storeId == null) {
                $('#editFranchiseid').focus();
                $("#text_editstore").text('<?php echo $this->lang->line('error_store'); ?>');
            } else if (commissionType == '' || commissionType == null) {
                $('.editctype_').focus();
                $("#text_editctype").text('<?php echo $this->lang->line('error_ctype'); ?>');
            } else if (commission == '' || commission == null) {
                $('#editcommission').focus();
                $("#text_editcomm").text('<?php echo $this->lang->line('error_comm'); ?>');
            } else {
                $(this).prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/Franchise') ?>/editCommission",
                    type: "POST",
                    data: {commId: editval,
                        storeId: storeId,
                        commissionType: commissionType, commission: commission
                    },
                    success: function (result) {
                        console.log(result);
                        if (result == 1) {
                            $('#editCommissionModal').modal('hide');
                            window.location.reload();
                        }

                    }
                });
            }

        });

        $('#reset').click(function () {
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
                    url: "<?php echo base_url('index.php?/Franchise') ?>/setDefaultCommission",
                    type: "POST",
                    dataType: 'json',
                    data: {Id: $('.checkbox:checked').val()},
                    success: function (result) {
                        window.location.reload();
                    }
                });
            } else {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Invalid Selection...');
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

            <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">
                <div class="pull-right m-t-10"> <button class="btn btn-info cls110" id="reset" style="background-color: darkgray;border-color: darkgray;"><?php echo $this->lang->line('button_reset'); ?></button></div>

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

<div id="addCommission" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_add'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_Store'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-8">
                            <select id="storeid" name="storeid"  class="form-control error-box-class">
                                <option data-name="Select Store" value=""><?php echo $this->lang->line('label_SelectStore'); ?></option>

                                <?php
                                foreach ($store as $result) {
                                    echo "<option data-name='" . implode(',', $result["name"]) . "' data-id=" . $result['seqId'] . " value=" . $result['_id']['$oid'] . ">" . implode(',', $result['name']) . "</option>";
                                }
                                ?>

                            </select> 

                            <input type="hidden" name="storeName" id="storeName" value="" />
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_store" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12"><?php // echo ($storedata['commissionType'] == '0') ? "CHECKED" : " "     ?> 
                        <label for="fname" class="col-sm-3 control-label error-box-class"><?php echo $this->lang->line('label_Ctype'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="radio" class="ctype_" name="ctype" value='0'>&nbsp;&nbsp;<label><?php echo $this->lang->line('label_Percentage'); ?></label> 
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" class="ctype_" name="ctype"  value='1'>&nbsp;&nbsp;<label><?php echo $this->lang->line('label_Fixed'); ?></label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_ctype" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="fname"  class="col-sm-3 control-label "><?php echo $this->lang->line('label_Value'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control error-box-class" id="commission" name="commission"  minlength="3" placeholder="Enter commission" required="">  
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_comm" style="color:red"></div>
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
<div id="editCommissionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_edit'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_Franchise'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-8">
                            <select id="editFranchiseid" name="editFranchiseid"  class="form-control error-box-class">
                                <option data-name="Select Franchise" value=""><?php echo $this->lang->line('label_SelectFranchise'); ?></option>

                                <?php
                                foreach ($franchise as $result) {
                                    echo "<option data-name='" . implode(',', $result["franchiseName"]) . "' data-id=" . $result['seqId'] . " value=" . $result['_id']['$oid'] . ">" . implode(',', $result['name']) . "</option>";
                                }
                                ?>

                            </select> 

                            <input type="hidden" name="editfranchiseName" id="editstoreName" value="" />
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_editstore" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12"><?php // echo ($storedata['commissionType'] == '0') ? "CHECKED" : " "     ?> 
                        <label for="fname" class="col-sm-3 control-label error-box-class"><?php echo $this->lang->line('label_Ctype'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="radio" class="editctype_" name="editctype" value='0'>&nbsp;&nbsp;<label><?php echo $this->lang->line('label_Percentage'); ?></label> 
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" class="editctype_" name="editctype"  value='1'>&nbsp;&nbsp;<label><?php echo $this->lang->line('label_Fixed'); ?></label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_editctype" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="fname"  class="col-sm-3 control-label "><?php echo $this->lang->line('label_Value'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control error-box-class" id="editcommission" name="editcommission"  minlength="3" placeholder="Enter commission" required="">  
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_editcomm" style="color:red"></div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <div class="col-sm-4" ></div>

                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel6"><?php echo $this->lang->line('button_Cancel'); ?></button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-info pull-right" id="yesEdit" ><?php echo $this->lang->line('button_Save'); ?></button></div>
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
                    <div class="error-box" id="errorboxactivateColor" style="text-align:center">Activate</div>
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
                    <div class="error-box" id="errorboxdeactivate" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>
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
