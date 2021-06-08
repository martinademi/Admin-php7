<?php date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);

if($status == 5) {
    $vehicle_status = 'New';
    $new ="active";
    echo '<style> .searchbtn{float: left;  margin-right: 63px;}.dltbtn{float: right;}</style>';
}
else if($status == 2) {
    $vehicle_status = 'Accepted';
    $accept ="active";
   }
else if($status == 4) {
    $vehicle_status = 'Rejected';
      $reject = 'active';
 }
else if($status == 2) {
    $vehicle_status = 'Free';
  $free = 'active';
  }
else if($status == 1) {
    $active = 'active';
}
?>
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


        $("#chekdel").click(function() {
            var val = [];
            $('.checkbox:checked').each(function(i){
                val[i] = $(this).val();
            });

            if(val.length > 0){
                if(confirm("Are you sure to Delete " +val.length + " Vehicle")){
                    $.ajax({
                        url:"<?php echo base_url('index.php?/companyadmin')?>/deleteVehicles",
                        type:"POST",
                        data: {val:val},
                        dataType:'json',
                        success:function(result){
                            alert(result.affectedRows)

                            $('.checkbox:checked').each(function(i){
                                $(this).closest('tr').remove();
                            });
                        }
                    });
                }

            }else{
                alert("Please mark any one of options");
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
<div class="content">
    <!-- START JUMBOTRON -->
    <div class="jumbotron" data-pages="parallax">
        <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
<!--            <div class="inner">-->
<!--                <!-- START BREADCRUMB -->
<!--                <ul class="breadcrumb">-->
<!--                    <li>-->
<!--                        <p>Company</p>-->
<!--                    </li>-->
<!--                    <li><a>Vehicles</a>-->
<!--                    </li>-->
<!--                    <li><a href="#" class="active">--><?php //echo $vehicle_status;?><!--</a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--                <!-- END BREADCRUMB -->
<!--            </div>-->






            <div class="panel panel-transparent ">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-fillup  bg-white">
                    <li class="<?php echo $new?>">
                        <a  href="<?php echo base_url(); ?>index.php?/companyadmin/Vehicles/5"><span>UNDER REVIEW</span></a>
                    </li>
                    <li class="<?php echo $accept?>">
                        <a  href="<?php echo base_url(); ?>index.php?/companyadmin/Vehicles/2"><span>ACCEPTED & FREE</span></a>
                    </li>
                    <li class="<?php echo $reject?>">
                        <a  href="<?php echo base_url(); ?>index.php?/companyadmin/Vehicles/4"><span>REJECTED</span></a>
                    </li>
<!--                    <li class="--><?php //echo $free?><!--">-->
<!--                        <a  href="--><?php //echo base_url(); ?><!--index.php?/companyadmin/Vehicles/21"><span>FREE</span></a>-->
<!--                    </li>-->
                    <li class="<?php echo $active?>">
                        <a  href="<?php echo base_url(); ?>index.php?/companyadmin/Vehicles/1"><span>ACTIVE</span></a>
                    </li>
                    <div class="pull-right m-t-10"><a href="<?php echo base_url()?>index.php?/companyadmin/addnewvehicle"> <button class="btn btn-primary btn-cons">ADD</button></a></div>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
<!--                                --><?php //if($status == '5') {?>
<!--                                    <div class="pull-left"><a href="--><?php //echo base_url()?><!--index.php?/companyadmin/addnewvehicle"> <button class="btn btn-primary btn-cons">ADD</button></a></div>-->
<!--                                --><?php //}?>

                                <div class="row clearfix pull-right" >


                                    <div class="col-sm-12">
                                        <div class="searchbtn" >

                                            <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search by id"> </div>
                                        </div>
                                        <div class="dltbtn">

                                            <!--                                    <div class="pull-right"> <a href="--><?php //echo base_url()?><!--index.php?/companyadmin/callExel/--><?php //echo $stdate;?><!--/--><?php //echo $enddate?><!--"> <button class="btn btn-primary" type="submit">Export</button></a></div>-->
                                            <?php if($status == '5') {?>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success" id="chekdel"><i class="fa fa-trash-o"></i>
                                                    </button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>




                            </div>
                            <div class="panel-body">
                                <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive"><table class="table table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">
                                            <thead>

                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;">VEHICLE ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;">TITLE</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 150px;">V MODEL</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 131px;">V TYPE</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 98px;">V REG NO</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 153px;">LICENSE PLATE NO</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 157px;">INSURANCE NUMBER</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width:75px;">V COLOR</th>
                                                <?php if($status == '5') {?> <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width:75px;">OPTION</th>  <?php } ?>

                                            </tr>


                                            </thead>
                                            <tbody>












                                            <?php

                                            $unq='1';
                                            foreach ($vehicles as $result) {
                                                ?>


                                                <tr role="row"  class="gradeA odd">
                                                    <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result->uniq_identity; ?></p></td>
                                                    <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result->vehicletype; ?></p></td>
                                                    <td class="v-align-middle"><?php echo $result->vehiclemodel; ?></td>
                                                    <td class="v-align-middle"><?php echo $result->type_name; ?></td>
                                                    <td class="v-align-middle"><?php echo $result->Vehicle_Reg_No; ?></td>
                                                    <td class="v-align-middle"><?php echo $result->License_Plate_No; ?></td>
                                                    <td class="v-align-middle"><?php echo  $result->Vehicle_Insurance_No; ?></td>
                                                    <td class="v-align-middle"><?php echo  $result->Vehicle_Color; ?></td>
                                                    <?php if($status == '5') {?>  <td class="v-align-middle">
                                                        <div class="checkbox check-primary">
                                                            <input type="checkbox" value="<?php echo $result->workplace_id;?>" id="checkbox<?php echo $unq;?>" class="checkbox">
                                                            <label for="checkbox<?php echo $unq;?>">Mark</label>
                                                        </div>
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                                                <?php
                                                $unq++;

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
                <span class="hint-text">Copyright at 3Embed software technologies, All right reserved</span>
               
            </p>
           
            <div class="clearfix"></div>
        </div>
    </div>
<!-- END FOOTER -->
</div>