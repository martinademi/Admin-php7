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

<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    
    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>

<script type="text/javascript">
    $(document).ready(function () {
        
        
        
//         var status = '<?php echo $status; ?>';

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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/datatable_passengerrating',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ":20,
            "oLanguage": {
                "sProcessing": "<img src='http://107.170.66.211/roadyo_live/sadmin/theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function() {
                //oTable.fnAdjustColumnSizing();
                 $('#big_table_processing').hide();
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

       $('#companyid').change(function () {

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

        });

    });
</script>


<script>
    $(document).ready(function(){
          $("#define_page").html("Passenger Rating");
           $('.passenger_rating').addClass('active');
           $('.passenger_rating').attr('src',"<?php echo base_url();?>/theme/icon/passanger rating_on.png");
//        $('.passenger_rating_thumb').addClass("bg-success");
          


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
<div class="page-content-wrapper"style="padding-top: 20px;">
<!-- START PAGE CONTENT -->
<div class="content">
    
        <div class="brand inline" style="  width: auto;
             font-size: 20px;
             color: gray;
             margin-left: 30px;padding-top: 20px;">
           <!--                    <img src="--><?php //echo base_url();  ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();  ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();  ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="color:#0090d9;">PASSENGER RATINGS</strong><!-- id="define_page"-->
        </div>
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
                    <li class="active">
                        <a href="<?php echo base_url()?>index.php?/superadmin/passenger_rating">   <span><?php echo LIST_PASSENGERRATING;?></span></a>
                    </li>
                    
                    </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <div id="big_table_processing" class="dataTables_processing" style=""><img src="http://www.ahmed-samy.com/demos/datatables_2/assets/images/ajax-loader_dark.gif"></div>

<!--                                --><?php //if($status == '5') {?>
<!--                                    <div class="pull-left"><a href="--><?php //echo base_url()?><!--index.php?/superadmin/addnewvehicle"> <button class="btn btn-primary btn-cons">ADD</button></a></div>-->
<!--                                --><?php //}?>

                                <div class="row clearfix pull-right" >
                                    



                                    <div class="col-sm-12">
                                        
                                        <div class="searchbtn" >

                                            <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH;?>"> </div>
                                        </div>
                                        <div class="dltbtn">

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
                            
                             &nbsp;
                            <div class="panel-body">
                                 <?php echo $this->table->generate(); ?>
                                
<!--                                <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive"><table class="table table-hover demo-table-search dataTable no-footer" id="big_table" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">
                                            <thead>

                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;font-size:15px"><?php echo PASSENGRRATING_TABLE_SLNO;?></th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;font-size:15px"><?php echo PASSENGRRATING_TABLE_PASSENGERID;?></th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 150px;font-size:15px"><?php echo PASSENGRRATING_TABLE_PASSENGERNAME;?></th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 131px;font-size:15px"><?php echo PASSENGRRATING_TABLE_PASSENGEREMAIL;?></th>
                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 131px;font-size:15px"><?php echo PASSENGRRATING_TABLE_AVGRATING;?></th>    
                                            </tr>


                                            </thead>
                                            <tbody>
                                             <?php

                                            $i='1';
                                            foreach ($passenger_rating as $result) {
                                                ?>


                                                <tr role="row"  class="gradeA odd">
                                                    <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $i; ?></p></td>
                                                    <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result->slave_id; ?></p></td>
                                                    <td class="v-align-middle"><?php echo $result->first_name.$result->last_name; ?></td>
                                                    <td class="v-align-middle"><?php echo $result->email; ?></td>
                                                    <td class="v-align-middle"><?php echo (round($result->rating,1) . "<br>"); ?></td>
                                                   
                                                   
                                                </tr>
                                                <?php
                                                $i++;

                                            }
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