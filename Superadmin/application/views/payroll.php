<?php
date_default_timezone_set('UTC');
$rupee = "$";
error_reporting(0);
$completed = 'active';
$pending = '';
$rejecte = '';
$status == 5;
if ($status == 5) {
    $vehicle_status = 'New';
    $completed = "active";
} else if ($status == 2) {
    $vehicle_status = 'Accepted';
    $pending = "active";
} else if ($status == 4) {
    $vehicle_status = 'Rejected';
    $rejecte = 'active';
} else if ($status == 1) {
    $vehicle_status = 'Free';
    $free = 'active';
}
?>
<script>
    $(document).ready(function () {
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
        $("#define_page").html("Payroll");
        $('.payroll').addClass('active');
        $('.payroll').attr('src',"<?php echo base_url();?>/theme/icon/payroll_on.png");
//        $('.payroll_thumb').addClass("bg-success");


//        $('#searchData').click(function(){
//
//
//            var dateObject = $("#start").datepicker("getDate"); // get the date object
//            var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
//            var dateObject = $("#end").datepicker("getDate"); // get the date object
//            var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
//
//            $('#createcontrollerurl').attr('href','<?php // echo base_url() ?>//index.php?/superadmin/Get_dataformdate/'+st+'/'+end);
//
//        });
//
//        $('#search_by_select').change(function(){
//
//
//            $('#atag').attr('href','<?php //echo base_url() ?>//index.php?/superadmin/search_by_select/'+$('#search_by_select').val());
//
//            $("#callone").trigger("click");
//        });



        $('#searchData').click(function () {
            
            if($("#start").val() && $("#end").val())
            {

            var dateObject = $("#start").datepicker("getDate"); // get the date object
            var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
            var dateObject = $("#end").datepicker("getDate"); // get the date object
            var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format

//           $('#createcontrollerurl').attr('href','<?php // echo base_url() ?>//index.php?/superadmin/Get_dataformdate/'+st+'/'+end);

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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/payroll_data_form_date/' + st + '/' + end + '/' + $('#companyid').val(),
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

            // search box for table
            $('#search-table').keyup(function () {
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
    function refreshTableOnActualcitychagne() {

        var table = $('#big_table');
        var url = '';

        if ($('#start').val() != '' || $('#end').val() != '') {

            var dateObject = $("#start").datepicker("getDate"); // get the date object
            var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
            var dateObject = $("#end").datepicker("getDate"); // get the date object
            var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format

            url = '<?php echo base_url() ?>index.php?/superadmin/payroll_data_form_date/' + st + '/' + end + '/' + $('#companyid').val();

        } else {
            url = '<?php echo base_url(); ?>index.php?/superadmin/payroll_ajax';
        }
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
            "sAjaxSource": url,
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

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

    }

    function refreshTableOnCityChange() {

        var table = $('#big_table');
        var url = '';

        if ($('#start').val() != '' || $('#end').val() != '') {

            var dateObject = $("#start").datepicker("getDate"); // get the date object
            var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
            var dateObject = $("#end").datepicker("getDate"); // get the date object
            var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format

            url = '<?php echo base_url() ?>index.php?/superadmin/payroll_data_form_date/' + st + '/' + end + '/' + $('#companyid').val();

        } else {
            url = '<?php echo base_url(); ?>index.php?/superadmin/payroll_ajax';
        }
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
            "sAjaxSource": url,
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

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

    }

</script>

<script type="text/javascript">
    $(document).ready(function () {


        $('#datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });



//        $("#datepicker1").datepicker({ minDate: 0});
        var date = new Date();
        $('#datepicker-component').datepicker({
            startDate: date
        });

       $('.cs-loader').show();
   
     $('.hide_show').hide();
     var table = $('#big_table');
     var searchInput = $('#search-table');
     searchInput.hide();
     table.hide();
    setTimeout(function() {
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
            "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/payroll_ajax',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                  table.show()
                   $('.cs-loader').hide()
                   searchInput.show()
                    $('#selectedcity').show()
                     $('.hide_show').show()
                     
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
         }, 1000);

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
<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
   <div class="content" style="padding-top: 0px">
 <div class="brand inline" style="  width: auto;             
             color: gray;
             margin-left: 30px;padding-top: 20px;">
           <!--                    <img src="--><?php //echo base_url();       ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();       ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();       ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="color:#0090d9;">PAYROLL MANAGEMENT</strong><!-- id="define_page"-->

            <ul class="nav nav-tabs  bg-white" style="">
         <div style="margin-left: 1%; display:none;" class="hide_show">
                          
                   
                            <div class="form-group " >
                             
                                <div class="col-sm-8" style="width: auto;
                                     paddingng: 0px;
                                     margin-bottom: 10px;margin-left: -0.7%" >

                                    <select id="selectedcity" name="company_select" class="form-control"  onchange="loadcompay()" style="background-color:gainsboro;height:30px;font-size:12px;">
                                        <!--<option value="0">Select city</option>-->
                                        <?php $city = $this->db->query("select * from city_available ORDER BY City_Name ASC")->result(); ?>
                                        <option value="0">Select City</option>
                                        <?php
                                        foreach ($city as $result) {

                                             echo '<option value="' . $result->City_Id . '">' . ucfirst(strtolower($result->City_Name)) . '</option>';
                                        }
                                        ?>   
                                    </select>
                                </div>
                            </div>

                                <div class="form-group" >

                                    <div class="col-sm-8" style="width: auto;" >

                                        <select id="companyid" name="company_select" class="form-control"  style="background-color:gainsboro;height:30px;font-size:12px;">
                                            <option value="0">Select Company</option>
                                        </select>

                                    </div>
                                </div>
               
                </div>
     </ul>
        </div>
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">


                <div class="panel panel-transparent ">
                  
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent m-t-20">
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

                                    <div class="col-sm-3" style="padding:0 !important;">
                                        <div class="" aria-required="true">

                                            <div class="input-daterange input-group hide_show" style="display:none;">
                                        <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From">
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To">
                                    </div>

                                        </div>

                                    </div>

                                    <div class="col-sm-1 hide_show" style="display:none;">
                                        <div class="">
                                            <button class="btn btn-primary  " type="button" id="searchData">Search</button>
                                        </div>
                                    </div>


                                    <div class="row clearfix">

                                        <div class="">

                                            <div class="pull-right "><input type="text" id="search-table" class="form-control pull-right search_class_dispatch" placeholder="Search"> </div>
                                        </div>
                                    </div>




                                </div>
                                <div class="panel-body">
                                    <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                        <div class="table-responsive" style="overflow-x:hidden;overflow-y:hidden;">
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
    <!-- END PAGE CONTENT -->
    <!-- START FOOTER -->
<!--    <div class="container-fluid container-fixed-lg footer">
        <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
                <span class="hint-text">Copyright @ 3Embed software technologies, All rights reserved</span>

            </p>

            <div class="clearfix"></div>
        </div>
    </div>-->
    <!-- END FOOTER -->
</div>


<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <span class="modal-title" style="color:#337ab7;">ALERT</span>

               <button type="button" class="close" data-dismiss="modal">×</button> 

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

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