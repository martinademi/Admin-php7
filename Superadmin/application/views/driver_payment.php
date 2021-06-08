<?php date_default_timezone_set('UTC');
$rupee = "$";
error_reporting(0);
$completed = 'active';
$pending = '';
$rejecte = '';
$status == 5;
if($status == 5) {
    $vehicle_status = 'New';
    $completed ="active";
}
else if($status == 2) {
    $vehicle_status = 'Accepted';
    $pending ="active";
}
else if($status == 4) {
    $vehicle_status = 'Rejected';
    $rejecte = 'active';
}
else if($status == 1) {
    $vehicle_status = 'Free';
    $free = 'active';
}

?>
<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    
    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>
<script>
    $(document).ready(function(){
        $('#searchData').click(function(){


            var dateObject = $("#start").datepicker("getDate"); // get the date object
            var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format
            var dateObject = $("#end").datepicker("getDate"); // get the date object
            var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();// Y-n-j in php date() format

            $('#createcontrollerurl').attr('href','<?php  echo base_url()?>index.php?/companyadmin/Get_dataformdate/'+st+'/'+end);

        });

        $('#search_by_select').change(function(){


            $('#atag').attr('href','<?php echo base_url()?>index.php?/companyadmin/search_by_select/'+$('#search_by_select').val());

            $("#callone").trigger("click");
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
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">


                <div class="panel panel-transparent ">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-fillup  bg-white">
                        <li class="<?php echo $completed?>">
                            <a  href="<?php echo base_url(); ?>index.php?/companyadmin/payroll"><span>Completed</span></a>
                        </li>
                        <li class="<?php echo $pending?>">
                            <a  href="<?php echo base_url(); ?>index.php?/companyadmin/payroll"><span>Pending</span></a>
                        </li>
                        <li class="<?php echo $reject?>">
                            <a  href="<?php echo base_url(); ?>index.php?/companyadmin/payroll"><span>Rejected</span></a>
                        </li>


                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">



                                    <div class="row clearfix">







                                        <!--                                <div class="col-sm-2">-->
                                        <!---->
                                        <!--                                    <div class="">-->
                                        <!---->
                                        <!--                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search by id"> </div>-->
                                        <!--                                    </div>-->
                                        <!--                                </div>-->
                                        <!---->
                                        <!---->
                                        <!--                                <div class="col-sm-3 pull-right">-->
                                        <!--                                    <div class="">-->
                                        <!---->
                                        <!--                                        <div class="pull-right"> <a href="--><?php //echo base_url()?><!--index.php?/companyadmin/callExel_payroll"> <button class="btn btn-primary" type="submit">Export</button></a></div>-->
                                        <!--                                    </div>-->
                                        <!--                                </div>-->
                                        <div class="">

                                            <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search by id"> </div>
                                        </div>
                                    </div>




                                </div>
                                <div class="panel-body">
                                    <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive"><table class="table table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
                                                <thead>

                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 68px;">SLNO</th>
                                                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 88px;">DRIVER ID</th>
                                                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 150px;">NAME</th>
                                                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 145px;">TODAY EARNINGS</th>
                                                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 131px;">WEEK EARNINGS</th>
                                                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 140px;">MONTH EARNINGS</th>
                                                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 140px;">LIFE TIME Earning </th>
                                                    <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 149px;"> SHOW </th>
                                                </tr>


                                                </thead>
                                                <tbody>












                                                <?php
                                                $slno = 1;

                                                foreach ($payroll as $result) {
                                                    ?>


                                                    <tr role="row"  class="gradeA odd">
                                                        <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $slno; ?></p></td>
                                                        <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result->mas_id; ?></p></td>
                                                        <td class="v-align-middle"><?php echo $result->first_name;?></td>
                                                        <td class="v-align-middle"><?php echo  $rupee.number_format((float)$result->today_earnings, 2, '.', ''); ?></td>
                                                        <td class="v-align-middle"><?php echo  $rupee.number_format((float)$result->week_earnings, 2, '.', '');  ?></td>
                                                        <td class="v-align-middle"><?php echo  $rupee. number_format((float)$result->month_earnings, 2, '.', '');?></td>
                                                        <td class="v-align-middle"><?php echo  $rupee. number_format((float)$result->total_earnings, 2, '.', ''); ?></td>
                                                        <td class="v-align-middle"><a href="<?php echo base_url('index.php?/companyadmin/DriverDetails/'.$result->mas_id)?>"><button class="btn btn-success btn-cons" style="min-width: 83px !important;">DETAILS</button></a>
                                                            <a href="<?php echo base_url('index.php?/companyadmin/Driver_pay/'.$result->mas_id)?>"><button class="btn btn-success btn-cons" style="min-width: 83px !important;">Pay</button></a>
                                                        </td>

                                                    </tr>
                                                    <?php
                                                    $slno++;
                                                }
                                                //                                            ?>
                                                </tbody>
                                            </table></div><div class="row"></div></div>
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

    <!-- END FOOTER -->
</div>