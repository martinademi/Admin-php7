<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        $('#callM').click(function() {

            $('#modal-container-18669944').modal('show');
        });

    });
    //here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file
    function validateForm()
    {
        if (!isBlank($("#Firstname").val()))
        {
            if (!isAlphabet($("#Firstname").val()))
            {
                $("#errorbox").html("Enter only character in First name");
                return false;
            }
        }
        else
        {
            $("#errorbox").html("First name is blank");
            return false;
        }

        if (!isBlank($("#Lastname").val()))
        {
            if (!isAlphabet($("#Lastname").val()))
            {
                $("#errorbox").html("Enter only character in Last name");
                return false;
            }
        }
        else
        {
            $("#errorbox").html("Last name is blank");
            return false;
        }

        if (!validateEmail($("#Email").val()))
        {
            $("#errorbox").html("Enter valid email");
            return false;
        }

        if (isBlank($("#Password").val()))
        {
            $("#errorbox").html("Password is Blank");
            return false;
        }

        if (!MatchPassword($("#Password").val(), $("#Cpassword").val()))
        {
            $("#errorbox").html("Password not matching");
            return false;
        }
        // return true;
    }


</script>




<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class="inner">
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li>
                        <p>Pages</p>
                    </li>
                    <li><a href="#" class="active">ADMIN</a>
                    </li>
                </ul>
                <!-- END BREADCRUMB -->
            </div>
            <div class="container-fluid container-fixed-lg bg-white">
                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <div class="panel-title">Pages Default Tables Style
                        </div>
                        <div class="pull-right">
                            <div class="btn-group pull-right m-b-10">
                                <button type="button" class="btn btn-default" id="callM">Add new</button>
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings</a>
                                    </li>
                                    <li><a href="#">Help</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer"><div class="table-responsive"><table class="table table-hover demo-table-search dataTable no-footer" id="tableWithSearch" role="grid" aria-describedby="tableWithSearch_info">
                                    <thead>
                                        <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Title: activate to sort column ascending" style="width: 247px;">
                                                First Name</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                                Last Name</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                                Email</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 175px;">
                                                Last login time</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                                Last login IP</th></tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $count = 1;

                                        foreach ($Admin_list as $result) {
                                            ?>
                                            <tr role="row" class="odd">
                                                <td class="v-align-middle">
                                                    <div class="checkbox ">
                                                        <input type="checkbox" value="3" id="checkbox<?php echo $count;?>">
                                                        <label for="checkbox4"></label>
                                                    </div>
                                                </td>
                                                <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $result["Fname"] ?></p></td>
                                                <td id = "d_fname" class="v-align-middle"><p> <?php echo $result["Fname"] ?> </p></td>
                                                <td id = "d_lname" class="v-align-middle"> <p><?php echo $result["Lname"] ?></p></td>
                                                <td id = "d_email" class="v-align-middle"> <p><?php echo $result["Email"] ?></p></td>
                                                <td id = "d_lastlogintime" class="v-align-middle"><p> <?php
                                                        if (is_null($result["Last_Login_Time"]))
                                                            echo "New Admin";
                                                        else
                                                            $result["Last_Login_Time"];
                                                        ?></p></td>
                                                <td id = "d_lastloginip" class="v-align-middle"><p> <?php
                                                        if (is_null($result["Last_Login_Ip"]))
                                                            echo "New Admin";
                                                        else
                                                            $result["Last_Login_Ip"];
                                                        ?></p></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        ?> 

                                    </tbody>
                                </table></div><div class="row"><div><div class="dataTables_paginate paging_bootstrap pagination" id="tableWithSearch_paginate"><ul><li class="prev disabled"><a href="#"><i class="pg-arrow_left"></i></a></li><li class="active"><a href="#">1</a></li><li><a href="#">2</a></li><li><a href="#">3</a></li><li class="next"><a href="#"><i class="pg-arrow_right"></i></a></li></ul></div><div class="dataTables_info" id="tableWithSearch_info" role="status" aria-live="polite">Showing <b>1 to 5</b> of 12 entries</div></div></div></div>
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
</div>

<div class="modal fade in" id="modal-container-1866994411" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="">
    <div class="modal-dialog">

        <form action = "<?php echo base_url(); ?>index.php/superadmin/AddNewAdmin" method= "post" onsubmit="return validateForm();">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add New Admin</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" placeholder="First name" id="Firstname" name="Firstname">
                    </div>
                    <div class="form-group" >
                        <label>Last Name</label>
                        <input type="text" class="form-control" placeholder="Last name" id="Lastname" name="Lastname">
                    </div>

                    <div class="form-group" >
                        <label>Email</label>
                        <input type="text" class="form-control" placeholder="Email" name="Email" id="Email">
                    </div>

                    <div class="form-group" >
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="Password" id="Password">
                    </div>

                    <div class="form-group" >
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" placeholder="Confirm Password" name="Cpassword" id ="Cpassword">
                    </div>

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



<div class="modal fade stick-up in" id="modal-container-18669944" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
                <h5>Add <span class="semi-bold">Admin</span></h5>
                <p></p>
            </div>
            <div class="modal-body">

                <form action ="<?php echo base_url(); ?>index.php/superadmin/AddNewAdmin" method= "post" onsubmit="return validateForm();" role="form">
                    <div class="form-group-attached">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" placeholder="First name" id="Firstname" name="Firstname">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" placeholder="Last name" id="Lastname" name="Lastname">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Email</label>
                                    <input type="text" class="form-control" placeholder="Email" name="Email" id="Email">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12">

                                <div class="form-group form-group-default">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="Password" id="Password">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="form-group form-group-default">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" placeholder="Confirm Password" name="Cpassword" id ="Cpassword">
                                </div>

                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                            <div class="p-t-20 clearfix p-l-10 p-r-10">
                                <!--                            <div class="pull-left">
                                                                <p class="bold font-montserrat text-uppercase">TOTAL</p>
                                                            </div>
                                                            <div class="pull-right">
                                                                <p class="bold font-montserrat text-uppercase">$20.00</p>
                                                            </div>-->
                                <label id = "errorbox" style="color: red; font-size: 15px;"></label>
                            </div>
                        </div>
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="Submit" class="btn btn-primary btn-block m-t-5">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>