<script>
    $(document).ready(function() {
      
    });
    //here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file
  
    function Delservice(thisval){
        $('#deletemodal').modal('show');
        var entityidid=thisval.id;
        $("#deletelink").attr('href',"<?php echo base_url()?>index.php/superadmin/DeleteEntity/Broker/"+entityidid);                
    }
  
</script>




<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb" style="margin-left: 20px;">
                    <li>
                         <a href="<?php echo base_url()?>index.php/superadmin/loadDashbord">Dashboard</a>
                    </li>
                    <li><a href="#" class="active">Broker</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>



            <div class="container-fluid container-fixed-lg bg-white">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <div class="panel-title"><button type="button" class="btn btn-default" id="callM"><a href="<?php echo base_url(); ?>index.php/superadmin/loadViews/Broker"> Add new</a></button>
                        </div>
                        <div class="pull-right">
                            <div class="col-xs-12">
                                <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive"><table class="table table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
                                    <thead>
                                    <tr role="row">
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                            Slno</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                            Name</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                            Email</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                            Status</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 175px;">
                                            Last login time</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                            Last login IP</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                            Option</th>
                                    </tr>
                                    
                                    </thead>
                                    <tbody>

                                    <?php
                                    $count = 1;

                                    foreach ($entitylist as $result) {
                                        ?>
                                        <tr role="row" class="odd">
                                            <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $count ?></p></td>
                                            <td id = "fname_" class="v-align-middle sorting_1"> <p><?php echo $result["Name"] ?></p></td>
                                            <td id = "lname_" class="v-align-middle"><p> <?php echo $result["Email"] ?> </p></td>
                                            <td id = "email_" class="v-align-middle"> <p><?php echo $result["Status"] ?></p></td>
                                          
                                           
                                            <td id = "lastlogintime_" class="v-align-middle"><p> <?php
                                                    if (($result["Last_Login_Time"]=="NULL"))
                                                        echo "Not yet Login";
                                                    else
                                                        $result["Last_Login_Time"];
                                                    ?></p></td>
                                            <td id = "lastloginip_" class="v-align-middle"><p> <?php
                                                    if ($result["Last_Login_Ip"]=="NULL")
                                                        echo "Not yet Login";
                                                    else
                                                        $result["Last_Login_Ip"];
                                                    ?></p></td>
                                            <td  class="v-align-middle">
                                                <div class="btn-group">
                                                <a href="<?php echo base_url()?>index.php/superadmin/loadEditViews/Broker/<?php echo $result['_id']?>"><button onclick="edit(this)" id="<?php echo $result['_id']?>" type="button" style="color: #ffffff !important;background-color: #10cfbd;" class="btn btn-success"><i class="fa fa-pencil"></i>
                                                </button></a>
                                                    
                                                    <a><button type="button" onclick="Delservice(this)" id="<?php echo $result['_id']?>" class="btn btn-success" style="color: #ffffff !important;background-color: #10cfbd;"><i class="fa fa-trash-o"></i>
                                                        </button></a>
                       
                                                </div>
                                            </td>
                                            
                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                    ?>
                                    </tbody>
                                </table></div></div></div>
                </div>
            </div>
            <!-- END PANEL -->
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


<div class="modal fade stick-up in" id="deletemodal" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Are You Sure To Delete This Broker ? </h5>
                </div>
                <div class="modal-body">

                </div>

                <div class="modal-footer">
                    
                        
                <a href="" id="deletelink"><button type="buttuon" class="btn btn-primary btn-cons  pull-left inline">Continue</button></a>
                <button type="button" class="btn btn-default btn-cons no-margin pull-left inline" data-dismiss="modal">Cancel</button>

                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>