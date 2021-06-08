<script>
    $(document).ready(function () {
        
          $('.HeaderOrders').addClass('active');
//        $('.icon-thumbnail').attr('<?php echo base_url(); ?>assets/dash_board_on.png"');
        $('.order_thumb').attr('src', "<?php echo base_url(); ?>assets/orders_on.png");
        
        $('#callM').click(function () {

            $('#NewCat').modal('show');
        });
    });
    //here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file

    function Delservice(thisval) {
        $('#deletemodal').modal('show');
        var entityidid = thisval.id;
        $("#deletelink").attr('href', "<?php echo base_url() ?>index.php/Admin/DeleteProduct/" + entityidid);
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
                        <a href="<?php echo base_url() ?>index.php/Admin/loadDashbord">Dashboard</a>
                    </li>
                    <li><a href="#" class="active">Orders</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>



            <div class="container-fluid container-fixed-lg bg-white">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <!--<a href="<?php // echo base_url();         ?>index.php/Admin/NewProduct"><button type="button" class="btn btn-default"> Add new</button></a>-->
                            <div class="pull-right">
                                <div class="col-xs-12">
                                    <input type="text" id="search-table" class="form-control pull-right" placeholder="Search">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                <div class="table-responsive">
                                    <table class="table table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
                                        <thead>
                                            <tr role="row">
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                    Slno</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                    User Id</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                    DateTime</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                                    Total</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                                    Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                    Option</th>
                                            </tr>

                                        </thead>
                                        <tbody>

                                            <?php
                                            $count = 1;

                                            foreach ($OrderList as $result) {
                                                ?>
                                                <tr role="row" class="odd">
                                                    <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $count ?></p></td>
                                                    <td id = "fname_" class="v-align-middle sorting_1"> <?php echo $result["UserId"] ?></td>
                                                    <td id = "fname_" class="v-align-middle sorting_1"> <p><?php echo $result["DateTime"] ?></p></td>
                                                    <td id = "lname_" class="v-align-middle"><p> <?php echo $result["Total"]; ?> </p></td>
                                                    <td id = "lname_" class="v-align-middle"><p> <?php echo 'New Order'; ?> </p></td>

                                                    <td  class="v-align-middle">
                                                        <div class="btn-group">
                                                            <a href="<?php echo base_url() . 'index.php/Admin/OrderDetails/' . $result['_id']; ?>"><button onclick="edit(this)" id="<?php echo $result['_id'] ?>" type="button" style="color: #ffffff !important;background-color: #10cfbd;" class="btn btn-success"><i class="fa fa-arrow-right"></i>
                                                                </button></a>

                                    <!--                                                            <a><button type="button" onclick="Delservice(this)" id="<?php echo $result['_id'] ?>" class="btn btn-success" style="color: #ffffff !important;background-color: #10cfbd;"><i class="fa fa-trash-o"></i>
                                                                                                </button></a>-->

                                                        </div>
                                                    </td>

                                                </tr>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
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
    <div class="modal fade in" id="NewCat" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
        <div class="modal-dialog">

            <form action = "<?php echo base_url(); ?>index.php/Admin/AddNewCategory" method= "post" onsubmit="return validateForm();">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add New Category</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" class="form-control" placeholder="Category" id="Category" name="FData[Category]">
                        </div>
                        <div class="form-group" >
                            <label>Description</label>
                            <input type="text" class="form-control" placeholder="Description" id="Description" name="FData[Description]">
                        </div>
                        <input type="hidden" id="BusinessId" name="FData[BusinessId]" value="<?PHP echo $BizId; ?>">


                        <label id = "errorbox" style="color: red; font-size: 15px;"></label>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="Submit" class="btn btn-primary" value="Add">

                    </div>
                </div>
            </form>
            </form>

        </div>

    </div>