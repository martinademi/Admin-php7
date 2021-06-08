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

            $('#createcontrollerurl').attr('href','<?php  echo base_url()?>index.php?/superadmin/Get_dataformdate/'+st+'/'+end);

        });

        $('#search_by_select').change(function(){


            $('#atag').attr('href','<?php echo base_url()?>index.php?/superadmin/search_by_select/'+$('#search_by_select').val());

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
                        url:"<?php echo base_url('index.php?/superadmin')?>/deleteVehicles",
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
                   
                    <li class="<?php echo $accept?>">
                        <a  href="<?php echo base_url(); ?>index.php?/superadmin/cities"><span>add cities</span></a>
                    </li>
                   
                    <div class="pull-right m-t-10"><a href="<?php echo base_url()?>index.php?/superadmin/addnewvehicle"> <button class="btn btn-primary btn-cons">ADD</button></a></div>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
<!--                                --><?php //if($status == '5') {?>
<!--                                    <div class="pull-left"><a href="--><?php //echo base_url()?><!--index.php?/superadmin/addnewvehicle"> <button class="btn btn-primary btn-cons">ADD</button></a></div>-->
<!--                                --><?php //}?>

                                <div class="row clearfix pull-right" >


                                  
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                            <!--                                    <div class="pull-right"> <a href="--><?php //echo base_url()?><!--index.php?/superadmin/callExel/--><?php //echo $stdate;?><!--/--><?php //echo $enddate?><!--"> <button class="btn btn-primary" type="submit">Export</button></a></div>-->
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
            <span class="hint-text">Copyright © 2014</span>
            <span class="font-montserrat">REVOX</span>.
            <span class="hint-text">All rights reserved.</span>
                <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a>
                </span>
        </p>
        <p class="small no-margin pull-right sm-pull-reset">
            <a href="#">Hand-crafted</a>
            <span class="hint-text">&amp; Made with Love ®</span>
        </p>
        <div class="clearfix"></div>
    </div>
</div>
<!-- END FOOTER -->
</div>