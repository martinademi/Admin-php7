<script type="text/javascript">
    $(document).ready(function () {

        var date = new Date();
        $('#datepicker-component').datepicker({
            startDate: date
        });

        var table = $('#big_table');

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
//            "sPaginationType": "bootstrap",
            "destroy": true,
            "scrollCollapse": true,
//            "oLanguage": {
//                "sLengthMenu": "_MENU_ ",
//                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
//            },
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/DriverRechargeDetails_ajax/<?php echo $driverId; ?>',
                        "bJQueryUI": true,
                        "sPaginationType": "full_numbers",
                        "iDisplayStart ": 20,
                        "oLanguage": {
                            "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                        },
                        "fnInitComplete": function () {
                            //oTable.fnAdjustColumnSizing();
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


                    table.on('click', '.btn-cons-onclick', function () {

                        $('#amount_edit').val($(this).parents('tr:first').find('td:eq(1)').text());
                        $('#wheretoedit').val($(this).attr('id'));
                        $('#myModal1_driverpass_edit').modal('show');
                    });


                    // search box for table
                    $('#search-table').keyup(function () {
                        table.fnFilter($(this).val());
                    });

                    $('#RECHARGE').click(function () {

                        $('#myModal1_driverpass').modal('show');


                    });

                    $('#Nowrecharge').click(function () {
                        var amount = $('#amount_').val();
                        if (amount == '') {
                            $('#errorpass_driversmsg').html('please inseter amount.');
                        } else {
                            $.ajax
                                    ({
                                        'dataType': 'json',
                                        'type': 'POST',
                                        'url': '<?php echo base_url('index.php?/superadmin/RechargeOperation/0/') ?>/' + amount + '/<?php echo $driverId; ?>',
                                        'success': function (data) {

                                            alert(data.error);
                                            window.location = "<?php echo base_url(); ?>index.php?/superadmin/Recharge/<?php echo $driverId; ?>";

                                                                        }
                                                                    });
                                                        }
                                                    });
                                                    $('#Nowrecharge_edit').click(function () {
                                                        var amount = $('#amount_edit').val();
                                                        var id = $('#wheretoedit').val();

                                                        if (amount == '') {
                                                            $('#errorpass_driversmsg').html('please inseter amount.');
                                                        } else {
                                                            $.ajax
                                                                    ({
                                                                        'dataType': 'json',
                                                                        'type': 'POST',
                                                                        'url': '<?php echo base_url('index.php?/superadmin/RechargeOperation/1/') ?>/' + amount + '/' + id,
                                                                        'success': function (data) {

                                                                            alert(data.error);
                                                                            window.location = "<?php echo base_url(); ?>index.php?/superadmin/Recharge/1";

                                                                        }
                                                                    });
                                                        }
                                                    });




                                                });
</script>

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content"style="padding-top: 80px">
        <ul class="breadcrumb" style="margin-left: 20px;">
            <li><a href="<?php echo base_url()?>index.php?/superadmin/DriverRecharge" class="">DRIVER WALLET</a>
            </li>

            <li ><a href="#" class="active"><?php  echo $driverinfo->first_name .' '.$driverinfo->last_name.' ('.$driverinfo->email.')';?></a>
            </li>
        </ul>
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">


                <div class="panel panel-transparent ">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent m-t-20">
                                <div class="panel-heading">

                                    <div class="col-sm-1">
                                        <div class="">
                                            <button class="btn btn-primary" type="button" id="RECHARGE">RECHARGE</button>
                                        </div>
                                    </div>


                                    <div class="row clearfix">



                                        <div class="">

                                            <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search by id"> </div>
                                        </div>
                                    </div>




                                </div>
                                <div class="panel-body">
                                    <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                        <div class="table-responsive">
                                            <?php echo $this->table->generate(); ?>

                                        </div><div class="row"></div></div>
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


<div class="modal fade stick-up" id="myModal1_driverpass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">

                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>

                    </div>
                    <h3>RECHARGE </h3>
                </div>


                <div class="modal-body">




                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"> ENTER AMOUNT (<?php echo currency; ?>)<span style="color:red;font-size: 18px">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" id="amount_" name="latitude" class="newpass form-control" placeholder="eg:250">
                        </div>
                    </div>

                    <br>
                    <br>



                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4 error-box" id="errorpass_driversmsg"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="Nowrecharge" ><?php echo BUTTON_SUBMIT; ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>
<div class="modal fade stick-up" id="myModal1_driverpass_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">

                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>

                    </div>
                    <h3>EDIT RECHARGE </h3>
                </div>


                <div class="modal-body">




                    <div class="form-group" class="formex">
                        <label for="fname" class="col-sm-4 control-label"> ENTER AMOUNT (<?php echo currency; ?>)<span style="color:red;font-size: 18px">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" id="amount_edit" name="latitude" class="newpass form-control" placeholder="eg:250">
                        </div>
                    </div>

                    <br>
                    <br>

                    <input type="hidden" id="wheretoedit">

                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4 error-box" id="errorpass_driversmsg"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="Nowrecharge_edit" ><?php echo BUTTON_SUBMIT; ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>

