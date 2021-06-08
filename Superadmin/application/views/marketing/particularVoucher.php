
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

 .bootstrap-timepicker-widget table td input{
        width: 60px;

    }

    .datepicker{z-index:1151 !important;}
    table{
        color: #333333;
        font-size: 13px;
    }
    .sTable{
        border-collapse: collapse;
        width: 100%;
    }
    .sTable td,.sTable th{
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

</style>
<script>
    var currentTab = 1;
    var counter = 0;
    var id ="<?php echo $id; ?>";
    $(document).ready(function () {
        var offset = new Date().getTimezoneOffset();
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Voucher/getCouponDetails/'+id,
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
                    $('#addVoucher').modal('show');
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
            Number.prototype.padLeft = function (base, chr) {
                var len = (String(base || 10).length - String(this).length) + 1;
                return len > 0 ? new Array(len).join(chr || '0') + this : this;
            }
            $('#yesAdd').prop('disabled', false);
            var vouchername = $('#vouchername').val();
            var codeprefix = $('#codeprefix').val();
            var codepostfix = $('#codepostfix').val();
            var noofcoupon = parseInt($('#noofcoupon').val());
            var couponvalue = $('#couponvalue').val();
            var expiryDate = $('#expiryDate').val();
            var expiryTime = $('#expiryTime').val();
            var expiryTime =  expiryTime+":00";
            var dateObject = $("#expiryDate").datepicker("getDate");
            var expiryDate = dateObject.getFullYear() + '-' + ("0" + (dateObject.getMonth() + 1)).slice(-2) + '-' + ("0" + dateObject.getDate()).slice(-2)+' '+expiryTime;

            var d = new Date();
                    dformat = [(d.getFullYear()),
                    (d.getMonth() + 1).padLeft(),
                        d.getDate().padLeft()].join('-') +
                    ' ' +
                [d.getHours().padLeft(),
                        d.getMinutes().padLeft(),
                        d.getSeconds().padLeft()].join(':');



            if(vouchername == '' || vouchername == null) {
                $('#vouchername').focus();
                $("#text_vouchername").text('<?php echo $this->lang->line('error_vouchername'); ?>');
            } else if (codeprefix == '' || codeprefix == null) {
                $('#codeprefix').focus();
                $("#text_codeprefix").text('<?php echo $this->lang->line('error_codeprefix'); ?>');
            } else if (codepostfix == '' || codepostfix == null) {
                $('#codepostfix').focus();
                $("#text_codepostfix").text('<?php echo $this->lang->line('error_codepostfix'); ?>');
            } 
            else if (noofcoupon == '' || noofcoupon == null || noofcoupon < 1) {
                $('#noofcoupon').focus();
                $("#text_noofcoupon").text('<?php echo $this->lang->line('error_noofcoupon'); ?>');
            }
            else if (couponvalue == '' || couponvalue == null ) {
                $('#couponvalue').focus();
                $("#text_couponvalue").text('<?php echo $this->lang->line('error_couponvalue'); ?>');
            }
            else if(expiryDate=='' || expiryDate == null){
                $('#expiryDate').focus();
                $("#text_expiryDateTime").text('<?php echo $this->lang->line('error_expiryDate'); ?>');
            }
            else if(expiryTime=='' || expiryTime == null){
                $('#expiryTime').focus();
                $("#text_expiryDateTime").text('<?php echo $this->lang->line('error_expiryTime'); ?>');
            }
             else if((new Date(expiryDate).getTime() <= new Date(dformat).getTime()))
                {
                    $('#expiryDate').focus();
                    $("#text_expiryDateTime").text('<?php echo $this->lang->line('error_expiryDate'); ?>');
                }
            else {
                    
                 $('#yesAdd').prop('disabled', true);

                $.ajax({
                    url: "<?php echo base_url('index.php?/Voucher') ?>/addVoucher",
                    type: "POST",
                    dataType: 'json',
                    data: {vouchername: vouchername, codeprefix: codeprefix, codepostfix: codepostfix,noofcoupon:noofcoupon, couponvalue: couponvalue,expiryDate:expiryDate,expiryTime:expiryTime},
                    success: function (result) {
                        console.log(result)
                        if (result.statusCode == 200) {
                            $('#yesAdd').prop('disabled', false);
                            $('#addVoucher').modal('hide');
                            window.location.reload();
                        } else{
                            alert(result.message);
                            // $('#errorModal').modal('show')
                            // $(".modalPopUpText").text('Color Name is already exist');
                            $('#yesAdd').prop('disabled', false);
                        }
                    }

                });
                // $(".error-box-class").val("");
                // $(".ctype_").val("");
            }

        });

//        $('#edit').click(function () {
        var editval = '';
       


       

        


        var dt = new Date();
        $('.datepicker-component').datepicker({
            format: 'dd/mm/yyyy',
            startDate: dt
//            endDate: date,
        });

        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });

        $('#datepicker-component').on('changeDate', function () {  
            $('.datepicker').hide();
        });
        


    });
    function isNumberKey(evt)
        {
            $("#mobify").text("");
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 41 || charCode > 57)) {
                //    alert("Only numbers are allowed");
                $("#mobify").text(<?php echo json_encode(LIST_COMPANY_MOBIFY); ?>);
                return false;
            }
            return true;
        }

</script>


<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"><?php echo $this->lang->line('heading_page'); ?></strong>
        </div>
        <ul class="breadcrumb" style="margin-left: 0px; margin-top: 1%;">
        <li><a
                href="<?php echo base_url(); ?>index.php?/Voucher"
                class="">Voucher</a></li>

        <li style="width: 100px"><span  class="active"><?php echo $voucherName ?></span>
        </li>
    </ul>
        <!-- Nav tabs -->
        <div class="panel panel-transparent ">
            <!-- Nav tabs -->

            <!--            <ul class="nav nav-tabs  bg-white whenclicked">
                            <li id= "my1" class="tabs_active active" style="cursor:pointer">
                                <a  class="changeMode accepted_" data="<?php echo base_url(); ?>index.php?/Voucher/voucher_details/0" data-id="1"><span><?php echo $this->lang->line('heading_active'); ?></span><span class="badge" style="background-color: #337ab7;"></span></a>
                            </li>
            
                            <li id= "my2" class="tabs_active" style="cursor:pointer">
                                <a  class="changeMode rejected_" data="<?php echo base_url(); ?>index.php?/Voucher/voucher_details/1" data-id="2"><span><?php echo $this->lang->line('heading_deactive'); ?></span> <span class="badge bg-red"></span></a>
                            </li>
                        </ul>-->
            <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

<!--                <div class="pull-right m-t-10"> <button class="btn btn-info" id="deactivate"><?php echo $this->lang->line('button_deactivate'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-info" id="activate"><?php echo $this->lang->line('button_activate'); ?></button></div>-->
                <!-- <div class="pull-right m-t-10"> <button class="btn btn-info" id="add" style="background-color: darkgray;border-color: darkgray;"><?php echo $this->lang->line('button_reset'); ?></button></div> -->
                <!--<div class="pull-right m-t-10"> <button class="btn btn-info" id="edit"><?php echo $this->lang->line('button_edit'); ?></button></div>-->
                <!-- <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10" id="add"><?php echo $this->lang->line('button_add'); ?> </button></a></div> -->

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

<div id="addVoucher" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">

                <span class="modal-title"><?php echo $this->lang->line('heading_add'); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <hr/>
                <div class="modal-body">

                    <div class="form-group col-sm-12">
                        <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_Voucher'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control error-box-class" id="vouchername" name="vouchername"   placeholder="Enter Voucher Name">  
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_vouchername" style="color:red"></div>
                    </div>
                    <div class="form-group col-sm-12">
                    <label for="codeprefix" class="col-sm-3 control-label"><?php echo $this->lang->line('lable_codeprefix'); ?><span style="" class="MandatoryMarker"> *</span></label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control error-box-class" id="codeprefix" name="codeprefix"   placeholder="Enter Prefix code">  
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_codeprefix" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="codepostfix"  class="col-sm-3 control-label "><?php echo $this->lang->line('label_codepostfix'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control error-box-class" id="codepostfix" name="codepostfix"  placeholder="Enter Postfix Code">  
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_codepostfix" style="color:red"></div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="count"  class="col-sm-3 control-label "><?php echo $this->lang->line('label_noofcoupon'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control error-box-class" id="noofcoupon" name="noofcoupon" onkeypress="return isNumberKey(event)" placeholder="Enter No. Of Coupon">  
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_noofcoupon" style="color:red"></div>
                    </div>


                    <div class="form-group col-sm-12">
                        <label for="value"  class="col-sm-3 control-label "><?php echo $this->lang->line('label_Value'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control error-box-class" id="couponvalue" name="couponvalue" onkeypress="return isNumberKey(event)"  placeholder="Enter Coupon Value">  
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_couponvalue" style="color:red"></div>
                    </div>


                    <div class="form-group col-sm-12">
                        <label for="value"  class="col-sm-3 control-label "><?php echo $this->lang->line('label_ExpiryDate'); ?><span class="MandatoryMarker">*</span></label>
                        <div class="col-sm-5">
                        <input type="text" class="input-sm form-control datepicker-component" name="expiryDate" id="expiryDate" placeholder="From Date"> 
                        </div>
                        <div class="col-sm-4 bootstrap-timepicker">
                        <input type="text" name="expiryTime" class="form-control timepicker" id="expiryTime"/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-8 error-box" id="text_expiryDateTime" style="color:red"></div>
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