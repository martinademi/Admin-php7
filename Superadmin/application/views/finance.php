<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);

if ($status == 5) {
    $vehicle_status = 'New';
    $new = "active";
    echo '<style> .searchbtn{float: left;  margin-right: 63px;}.dltbtn{float: right;}</style>';
} else if ($status == 2) {
    $vehicle_status = 'Accepted';
    $accept = "active";
} else if ($status == 4) {
    $vehicle_status = 'Rejected';
    $reject = 'active';
} else if ($status == 2) {
    $vehicle_status = 'Free';
    $free = 'active';
} else if ($status == 1) {
    $active = 'active';
}
?>
<script>
    $(document).ready(function () {
        $("#define_page").html("Marketing");
        $('.finance').addClass('active');
        $('.finance_thumb').addClass("bg-success");

//        
//    $('#searchData').click(function () {
//            var dateObject = $("#start").datepicker("getDate"); // get the date object
//                    var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate(); // Y-n-j in php date() format
//                    var dateObject = $("#end").datepicker("getDate"); // get the date object
//                    var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate(); // Y-n-j in php date() format
//
//                    $('#createcontrollerurl').attr('href', '<?php echo base_url() ?>index.php?/superadmin/Get_dataformdate/' + st + '/' + end);
//            });
//           
//
//
//                    $('#search_by_select').change(function () {
//
//
//                $('#atag').attr('href', '<?php echo base_url() ?>index.php?/superadmin/search_by_select/' + $('#search_by_select').val());
//                        $("#callone").trigger("click");
//                });
//            
//
//
//
//                $("#chekdel").click(function () {
//                        var val = [];
//                                $('.checkbox:checked').each(function (i) {
//                        val[i] = $(this).val();
//                        });
//                                if (val.length > 0) {
//                        if (confirm("Are you sure to Delete " + val.length + " Vehicle")) {
//                        $.ajax({
//                        url: "<?php echo base_url('index.php?/superadmin') ?>/deleteVehicles",
//                                type: "POST",
//                                data: {val: val},
//                                dataType: 'json',
//                                success: function (result) {
//                                alert(result.affectedRows)
//
//                                        $('.checkbox:checked').each(function (i) {
//                                $(this).closest('tr').remove();
//                                });
//                                }
//                        });
//                        }
//
//                        } else {
//                        alert("Please mark any one of options");
//                        }
//
//                        });
//                        
//                        
//            < type = "text/javascript" >
//            $(function() {
//                            $('#datetimepicker1').datetimepicker({
//                           language: 'pt-BR'
//                           });
//            });
    });
</script>

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">
 <div class="brand inline" style="  width: auto;
             font-size: 20px;
             color: gray;
             margin-left: 30px;padding-top: 20px;">
           <!--                    <img src="--><?php //echo base_url();      ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();      ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();      ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="margin-bottom: 50px">MARKETING</strong><!-- id="define_page"-->
        </div>
            <!-- START JUMBOTRON -->
            <div class="jumbotron" data-pages="parallax">
                <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                    <div class="panel panel-transparent ">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-fillup  bg-white">
                            <!-- <h3 style="text-align:center">STATEMENT OF WORK</h3>-->
                            <li class="<?php echo ($status == 1 ? "active" : ""); ?>">
                                <a  href="<?php echo base_url(); ?>index.php?/superadmin/finance/1"><span>HISTORY</span></a>
                            </li>
                            <li class="<?php echo ($status == 2 ? "active" : ""); ?>">
                                <a  href="<?php echo base_url(); ?>index.php?/superadmin/finance/2"><span>STATEMENTS</span></a>
                            </li>


                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="container-fluid container-fixed-lg bg-white">
                                <!-- START PANEL -->

                                <?php if ($status == 1) { ?>

                                    <div class="panel-body">
                                        <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive"><table class="table table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">
                                                    <thead>

                                                        <tr role="row">
                                                            <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 87px;">SNO</th>
                                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;">DATE</th>
                                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 150px;">TIME</th>
                                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 131px;">PASSENGER EMAIL</th>
                                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 98px;">DRIVER EMAIL</th>
                                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 153px;">PAYMENT TYPE</th>
                                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 157px;">CHARGE ID</th>
                                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 157px;">TRANSACTION ID</th>
                                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 157px;">AMOUNT</th>

                                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 157px;">STATUS</th>
                                                            <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 157px;">DETAILS</th>



                                                        </tr>


                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $unq = '1';
                                                        foreach ($vehicles as $result) {
                                                            ?>


                                                            <tr role="row"  class="gradeA odd">
                                                                <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result->uniq_identity; ?></p></td>
                                                                <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result->vehicletype; ?></p></td>
                                                                <td class="v-align-middle"><?php echo $result->vehiclemodel; ?></td>
                                                                <td class="v-align-middle"><?php echo $result->type_name; ?></td>
                                                                <td class="v-align-middle"><?php echo $result->Vehicle_Reg_No; ?></td>
                                                                <td class="v-align-middle"><?php echo $result->License_Plate_No; ?></td>
                                                                <td class="v-align-middle"><?php echo $result->Vehicle_Insurance_No; ?></td>
                                                                <td class="v-align-middle"><?php echo $result->Vehicle_Color; ?></td>
                                                                <?php if ($status == '5') { ?>  <td class="v-align-middle">
                                                                        <div class="checkbox check-primary">
                                                                            <input type="checkbox" value="<?php echo $result->workplace_id; ?>" id="checkbox<?php echo $unq; ?>" class="checkbox">
                                                                            <label for="checkbox<?php echo $unq; ?>">Mark</label>
                                                                        </div>
                                                                    </td>
                                                                <?php } ?>
                                                            </tr>
                                                            <?php
                                                            $unq++;
                                                        }
                                                        //                                            
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>


                                        <?php } elseif ($status == 2) { ?>
                                            <div class="panel panel-transparent">
                                                <div class="panel-heading" style="padding:0px">
                                                    <h3 style="text-align: center">STATEMENT OF WORK</h3>
                                                </div>





                                                <div class="container" style="background-color: grey;height:80px">
                                                    <div class="row">
                                                        <div class="col-sm-2">


                                                            <div style="float: left;">
                                                                <select id="view_type_select" style="margin-top: 20px;width: 130px;height:35px;display: inline;background-color: white;color:black;"> 
                                                                    <option value="">Select</option>        
                                                                    <option value="1">TODAY</option>        
                                                                    <option value="2">THIS WEEK</option>        
                                                                    <option value="3">LAST WEEK</option>        
                                                                    <option value="4">THIS MONTH</option>        
                                                                    <option value="5">LAST MONTH</option>        
                                                                    <option value="6">LAST 3 MONTHS</option>        
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <span style="color:white">FROM:</span>
                                                            <div id="datepicker-component" class="input-group date col-sm-8">
                                                                <input type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            </div>

                                                        </div>  


                                                        <div class="col-sm-2">
                                                            <span style="color:white"> TO:</span>
                                                            <div id="datepicker-component" class="input-group date col-sm-8">
                                                                <input type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <select id="view_type_select_u" style="margin-top: 20px;height:35px;width: 130px;display: inline;background-color: white;color:black;"> 
                                                                <option value="">Sort by driver</option>
                                                                <option value="1">Chetan</option>
                                                                <option value="2">Shimona</option>
                                                                <option value="3">Mona</option>
                                                                <option value="4">Rahul</option>
                                                                <option value="5">Anriid</option>
                                                                <option value="6">Devinder</option>
                                                                <option value="7">Devinder</option>
                                                                <option value="8">Srikanth</option>
                                                                <option value="9">Testy</option>
                                                                <option value="10">Vinay</option>
                                                                <option value="11">Saleem</option>
                                                                <option value="12">Shaheen</option>
                                                                <option value="13">Shaheen</option>
                                                                <option value="14">Allan</option>
                                                                <option value="15">Daniel</option>
                                                                <option value="16">Eddie</option>
                                                                <option value="17">Eddie</option>
                                                                <option value="18">Daniel</option>
                                                                <option value="19">Daniel</option>
                                                                <option value="20">Mike</option>
                                                                <option value="21">AA</option>
                                                                <option value="22">Peyush</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <select id="view_type_select_u" style="margin-top: 20px;height:35px;width: 130px;display: inline;background-color: white;color:black;">    
                                                                <option value="">select </option>
                                                                <option value="">option1</option>
                                                                <option value="">option</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <button id="view_type_select_u" style="margin-top: 20px;height:35px;width: 130px;display: inline;background-color: white;color:black;">search</button>

                                                        </div>

                                                    </div>
                                                </div>

                                                <br>


                                                <div class="container-fluid" style="background-color:#10CFBD;height:140px">
                                                    <div class="row">
                                                        <div class="col-sm-3">

                                                            

                                                    </div>
                                                </div>
                                                <br>

                                                <br>

                                                <div class="row clearfix pull-right" >


                                                    <div class="col-sm-12">
                                                        <div class="searchbtn" >

                                                            <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search by id"> </div>
                                                        </div>
                                                        <div class="dltbtn">


                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <br>


                                                <div class="panel-body">
                                                    <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive"><table class="table table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info" style="margin-top: 30px;">
                                                                <thead>

                                                                    <tr role="row">
                                                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 127px;">APP DATE</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 127px;">DATE</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 150px;">PAYMENT METHOD</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 131px;">DRIVER ID</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 98px;">BILL ID</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 153px;">DRIVER NAME</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 157px;">COMMISSION</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 157px;">DRIVER EARNING</th>
                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 157px;">STRIPE AMOUNT</th>


                                                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 157px;">DETAILS</th>



                                                                    </tr>


                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    <?php } ?>

                                                </div><div class="row">


                                                </div></div>
                                        </div>
                                    </div>



                                </div>
                            </div>





                        </div>

                    </div>
                    <!-- END PANEL -->
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
</div>
          </div>

