<?php date_default_timezone_set('UTC');
$rupee = "$";
error_reporting(0);
?>
<script>
    $(document).ready(function(){
           
        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });
           var date = new Date();
        $('.datepicker-component').datepicker({
           
        });
        $('#clearData').click(function ()
        {
            $('#start').val('');
            $('#end').val('');
        });
        
        $('#searchData').click(function(){
             if($("#start").val() && $("#end").val())
            {
            var dateObject = $("#start").datepicker("getDate"); // get the date object
            var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
            var dateObject = $("#end").datepicker("getDate"); // get the date object
            var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format

//           $('#createcontrollerurl').attr('href','<?php // echo base_url()?>//index.php?/superadmin/Get_dataformdate/'+st+'/'+end);

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
                      "autoWidth": false,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url()?>index.php?/superadmin/DriverDetails_form_Date/'+st+'/'+end+'/'+$('#companyid').val()+'/'+<?php echo $mas_id?>,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ":20,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function() {
                    //oTable.fnAdjustColumnSizing();
                },
                'fnServerData': function(sSource, aoData, fnCallback)
                {
                    $.ajax
                    ({
                        'dataType': 'json',
                        'type'    : 'POST',
                        'url'     : sSource,
                        'data'    : aoData,
                        'success' : fnCallback
                    });
                }
            };

            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function() {
                table.fnFilter($(this).val());
            });
              }
            else
            {
                 $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_DEACTIVAT_DATEOFBOOKING); ?>);
            }



        });

    });

    function refreshTableOnCityChange(){

        var table = $('#big_table');
        var url = '';

        if($('#start').val() != '' ||$('#end').val() != '' ){

            var dateObject = $("#start").datepicker("getDate"); // get the date object
            var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
            var dateObject = $("#end").datepicker("getDate"); // get the date object
            var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format

            url =  '<?php echo base_url()?>index.php?/superadmin/DriverDetails_form_Date/'+st+'/'+end+'/'+$('#companyid').val()+'/'+<?php echo $mas_id?>;

        }else{
            url = '<?php echo base_url(); ?>index.php?/superadmin/DriverDetails_ajax/'+<?php echo $mas_id?>;
        }
        var settings = {
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
            "sAjaxSource": url,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ":20,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function() {
                //oTable.fnAdjustColumnSizing();
            },
            'fnServerData': function(sSource, aoData, fnCallback)
            {
                $.ajax
                ({
                    'dataType': 'json',
                    'type'    : 'POST',
                    'url'     : sSource,
                    'data'    : aoData,
                    'success' : fnCallback
                });
            }
        };

        table.dataTable(settings);

        // search box for table
        $('#search-table').keyup(function() {
            table.fnFilter($(this).val());
        });

    }

</script>


<script type="text/javascript">
    $(document).ready(function() {


        var table = $('#big_table');

        var settings = {
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
            "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/DriverDetails_ajax/'+<?php echo $mas_id?>,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ":20,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function() {
                //oTable.fnAdjustColumnSizing();
            },
            'fnServerData': function(sSource, aoData, fnCallback)
            {
                $.ajax
                ({
                    'dataType': 'json',
                    'type'    : 'POST',
                    'url'     : sSource,
                    'data'    : aoData,
                    'success' : fnCallback
                });
            }
        };

        table.dataTable(settings);

        // search box for table
        $('#search-table').keyup(function() {
            table.fnFilter($(this).val());
        });

    } );
</script>
<?php

    $driverName = $this->db->query("SELECT * FROM master where mas_id = ".$mas_id."")->row()->first_name;
   
?>

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <ul class="breadcrumb" style="margin-top: 5%;">
                      
                        <li><a href="<?php echo base_url('index.php?/superadmin/payroll')?>" class="">PAYROLL</a>
                        </li>
                        <li><a href="#" class="active"><?php echo $driverName;?></a>
                        </li>
                    </ul>
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                   
                    <!-- END BREADCRUMB -->
                </div>


                <div class="container-fluid container-fixed-lg bg-white">
                    <!-- START PANEL -->
                    <div class="panel panel-transparent">
                        <div class="panel-heading">


                            <div class="col-sm-3" style="padding-left:0px;">
                                <div class="" aria-required="true">

                                    <div class="input-daterange input-group">
                                            <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">

                                        </div>


                                </div>

                            </div>

                            <div class="col-sm-1">
                                <div class="">
                                    <button class="btn btn-primary" type="button" id="searchData">Search</button>
                                </div>
                            </div>
                             <div class="col-sm-1">
                                    <div class="">
                                        <button class="btn btn-info" type="button" id="clearData">Clear</button>
                                    </div>
                                </div>

                            <div class="row clearfix">

                                <div class="pull-right" style="margin-right: 1%;"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search"> </div>
                                
                            </div>




                        </div>
                        <div class="panel-body">
                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                <div class="table-responsive" style="overflow-x: hidden;overflow-y:hidden;">
                                    <?php echo $this->table->generate();?>

                                </div><div class="row"></div></div>
                        </div>
                    </div>
                    <!-- END PANEL -->
                </div>



            </div>


        </div>
        <!-- END JUMBOTRON -->



    </div>
    <!-- END PAGE CONTENT -->
    <!-- START FOOTER -->

    <!-- END FOOTER -->
</div>

<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

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
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" ><?php echo BUTTON_OK; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>