<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);

if ($status == 1) {
    $passenger_status = 'active';
    $active = "active";
    echo '<style> .searchbtn{float: left;  margin-right: 63px;}.dltbtn{float: right;}</style>';
} else if ($status == 2) {
    $passenger_status = 'deactive';
    $deactive = "active";
}
?>

<script type="text/javascript">
    $(document).ready(function () {



        var status = '<?php echo $status; ?>';

        var table = $('#big_table');


        $('.whenclicked li').click(function () {

            if ($(this).attr('id') == 1) {
                $('#btnStickUpSizeToggler').show();
                 $("#error").text("");
               
            }
            else if ($(this).attr('id') == 2) {

                $('#btnStickUpSizeToggler').hide();
                 $("#error").text("");
            }


        });
         $('#big_table_processing').show();

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_disputes/' + status,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
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
        
        
        

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });



        $('.changeMode').click(function () {
             $("#error").text("");
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
                    "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
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
            };

            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');



            table.dataTable(settings);
            if($(this).data('id') == '2')
            {
              $('#big_table').dataTable().fnSetColumnVis([8], false);
             }

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });

        });
        
//        $('#companyid').change(function () {


     function refreshTableOnCityChange(){
      $("#error").text("");
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
                "sAjaxSource": $(".whenclicked li.active").children('a').attr('data'),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
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
            };

            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });

        }
    });
</script>

<script>

    $(document).ready(function () {
        $("#define_page").html("Disputes");
        $('.disputes').addClass('active');
        $('.disputes').attr('src',"<?php echo base_url();?>/theme/icon/dispuite_on.png");
//        $('.disputes_thumb').addClass("bg-success");



        $('.error-box-class').keypress(function () {
            $('.error-box').text('');
        });



        $("#btnStickUpSizeToggler").click(function () {

            $("#error").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();


            if (val.length == 0) {
                $("#displayData").modal("show");

                //      alert("please select any one to resolve");
                $("#error").text(<?php echo json_encode(POPUP_DISPUTES_ANYONE); ?>);
            } else if (val.length > 1) {
                $("#displayData").modal("show");


                //       alert("please select only one to resolve");
                $("#error").text(<?php echo json_encode(POPUP_DISPUTES_ONLYONE); ?>);
            }
            else {



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
            }
        });








        $("#insert").click(function () {

            $("#displayerror").text("");

            var val = $('.checkbox:checked').val();

            var message = $("#message").val();
            var test = /[^a-zA-Z0-9\s]/;

            if (message == "" || message == null)
            {
                $("#displayData").modal("show");

                //     alert("please enter the message");
                $("#displayerror").text(<?php echo json_encode(POPUP_MESSAGE); ?>);
            }
            else if (test.test(message))
            {
                $("#displayData").modal("show");

                //    alert("please enter the valid data");
                $("#displayerror").text(<?php echo json_encode(POPUP_COMPAIGNS_TEXT); ?>);
            }

            else {

                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('index.php?/superadmin') ?>/resolvedisputes",
                    data: {val: val,
                        message: message},
                    dataType: 'JSON',
                    success: function (response)
                    {


                        $('.checkbox:checked').each(function (i) {
                            $(this).closest('tr').remove();
                        });

                        $(".close").trigger('click');

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
<div class="page-content-wrapper" style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto;">
           <!--                    <img src="--><?php //echo base_url();    ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();    ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();    ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="color:#0090d9;">DISPUTES</strong><!-- id="define_page"-->
        </div>
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <!--            <div class="inner">-->
                <!--                <!-- START BREADCRUMB -->
                <!--                <ul class="breadcrumb">-->
                <!--                    <li>-->
                <!--                        <p>Company</p>-->
                <!--                    </li>-->
                <!--                    <li><a>Vehicles</a>-->
                <!--                    </li>-->
                <!--                    <li><a href="#" class="active">--><?php //echo $vehicle_status;    ?><!--</a>-->
                <!--                    </li>-->
                <!--                </ul>-->
                <!--                <!-- END BREADCRUMB -->
                <!--            </div>-->






                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs  bg-white whenclicked">
                        <li  id="1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>">
                            <a  class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/datatable_disputes/1" data-id="1"><span><?php echo LIST_DISPUTES_REPORTED; ?></span></a>
                        </li>
                        <li  id="2" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>">
                            <a  class="changeMode"  data="<?php echo base_url(); ?>index.php?/superadmin/datatable_disputes/2" data-id="2"><span><?php echo LIST_DISPUTES_RESOLVED; ?> </span></a>
                        </li>

                        <div class="pull-right m-t-10" style="margin-right: 1.9%;"> <button class="btn btn-success btn-cons resolve" id="btnStickUpSizeToggler" ><?php echo BUTTON_RESOLVE; ?></button></div>


                        <div class="pull-right m-t-10" style="margin-right: 10px; width: 150px;">


<!--                            <select id="cityid" name="city_select"  class="form-control"  >
                                <option value="0"><?php echo SELECT_BY_DRIVER; ?></option>
                                <?php
                                foreach ($master as $result) {

                                    echo "<option value=" . $result->mas_id . ">" . $result->first_name . $result->last_name . "</option>";
                                }
                                ?>

                            </select>-->

                        </div>


                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                     <!-- <div id="big_table_processing" class="dataTables_processing" style=""><img src="http://www.ahmed-samy.com/demos/datatables_2/assets/images/ajax-loader_dark.gif"></div> -->

                                    <!--                                --><?php //if($status == '5') {    ?>
                                    <!--                                    <div class="pull-left"><a href="--><?php //echo base_url()    ?><!--index.php?/superadmin/addnewvehicle"> <button class="btn btn-primary btn-cons">ADD</button></a></div>-->
                                    <!--                                --><?php //}    ?>
                                    <div  class="col-sm-6 error-box" id="error" style="text-align: right" ></div>
                                    <div class="row clearfix pull-right" >


                                        <div class="col-sm-12">

                                            <div cass="col-sm-6">
                                                <div class="searchbtn" >

                                                    <div class="pull-right"><a href="#">
                                                            <input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"></a> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                                 &nbsp;
                                <div class="panel-body">
                                    <?php echo $this->table->generate(); ?>

<!--                                    <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive"><table class="table table-hover demo-table-search dataTable no-footer" id="big_table" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">
            <thead>

                <tr role="row">
                     <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px"><?php echo DISPUTES_TABLE_DISPUTEID; ?></th>
                  
                  
                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:15px"><?php echo DISPUTES_TABLE_PASSENGERID; ?></th>
                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:15px"><?php echo DISPUTES_TABLE_PASSENGERNAME; ?></th>
                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:15px"><?php echo DISPUTES_TABLE_DRIVERID; ?></th>
                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 150px;font-size:15px"><?php echo DISPUTES_TABLE_DRIVERNAME; ?></th>
                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 150px;font-size:15px"><?php echo DISPUTES_TABLE_DISPUTEMESSAGE; ?></th>
                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 180px;font-size:15px"><?php echo DISPUTES_TABLE_DISPUTEDATE; ?></th>
                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 60px;font-size:15px"><?php echo DISPUTES_TABLE_BOOKINGID; ?></th>
                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:15px"><?php echo DISPUTES_TABLE_SELECT; ?></th>
                </tr>


            </thead>
            <tbody> <?php
                                    $i = '1';
                                    foreach ($disputesdata as $result) {
                                        ?>


                            <tr role="row"  class="gradeA odd">
                                 
                                <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result->report_id; ?></p></td>
                                <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result->slave_id; ?></p></td>
                                <td class="v-align-middle"><?php echo $result->mas_fname . $result->mas_lname ?></td>
                                <td class="v-align-middle"><?php echo $result->mas_id; ?></td>
                                <td class="v-align-middle"><?php echo $result->slv_name . $result->slv_lname; ?></td>
                                <td class="v-align-middle"><?php echo $result->report_msg; ?></td>
                                <td class="v-align-middle"><?php echo $result->report_dt; ?></td>
                                <td class="v-align-middle"><?php echo $result->appointment_id; ?></td>
                                  <td class="v-align-middle">
                                        <div class="checkbox check-primary">
                                            <input type="checkbox" value="<?php echo $result->report_id; ?>" id="checkbox<?php echo $i; ?>" class="checkbox">
                                            <label for="checkbox<?php echo $i; ?>">Mark</label>
                                        </div>
                                    </td>
                               
                            </tr>
                                        <?php
                                        $i++;
                                    }
                                    //                                            
                                    ?>
            </tbody>
        </table></div><div class="row"></div></div>-->
                                </div>
                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>
                </div>









            </div>


        </div>
        <!-- END JUMBOTRON -->

        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->

            <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->

    </div>
    <!-- END PAGE CONTENT -->
    <!-- START FOOTER -->
    <div class="container-fluid container-fixed-lg footer">
        <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
                <span class="hint-text">Copyright @ 3Embed software technologies, All rights reserved</span>
               
            </p>
           
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- END FOOTER -->
</div>

<div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-header">

                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>

                    </div>
                    <h3> <?php echo LIST_DISPUTES_EDITDISPUTE; ?></h3>
                </div>



                <br>



                <div class="form-group" class="formex">
                    <label for="fname" class="col-sm-4 control-label">    <?php echo FIELD_DISPUTES_MANAGEMENTNOTE; ?><span style="color:red;font-size: 18px">*</span></label>
                    <div class="col-sm-6">
                        <input type="text"  id="message" name="latitude"  class="form-control error-box-class" placeholder="">
                    </div>
                </div>

                <br>


                <div class="row ">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4 error-box" id="displayerror" ></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="insert" ><?php echo BUTTON_SUBMIT; ?></button>
                    </div>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
    </button>
</div>

<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="errorboxdata" style="font-size: large;text-align:center"></div>

                </div>
            </div>

            <br>


        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

