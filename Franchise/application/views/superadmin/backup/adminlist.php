

<script>
    $(document).ready(function() {

        $('#callM').click(function() {

            $('#modal-container-18669944').modal('show');
        });



    });
    //here this function validates all the field of form while adding new subadmin you can find all related functions in RylandInsurence.js file


    function edit(thisval){

        $('#modalEdit').modal('show');
        $('#EFirstname').val($(thisval).closest("tr").find("#fname_").text());
        $('#ELastname').val($(thisval).closest("tr").find("#lname_").text());
        $('#EEmail').val($(thisval).closest("tr").find("#email_").text());

        $('#mongoid').val(thisval.id);

    }
    function Delservice(thisval){
        $('#deletemodal').modal('show');
        $('#mongo_id_del').val(thisval.id);
    }


    function validate(){

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
    }
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

        if (validateEmail($("#Email").val()) == 1)
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
    
function validemailfromdb(val) 
{

        var dofor = val;
        if (dofor == 2) {
            var m_id = $('#mongoid').val();
            var Email = $("#EEmail").val();
        }
        else {
            var m_id = 0;
            var Email = $("#Email").val();
        }

       /* if ($('#selectadd').val() == '1') {

            $("#errorbox").html("Select Type  !");
            return false;
        }*/
      //  else {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/superadmin/validateEmail",
                type: "POST",
                data: {email: Email, dofor: dofor, m_id: m_id},
                dataType: "JSON",
                success: function (result) {

                    if (result.msg == 1) {
                        if (dofor == 2) {
                            $("#editerrorbox").html("Email is already allocated !");
//                    $('#EEmail').val('');
                        }
                        else {
                            $("#errorbox").html("Email is already allocated !");

                            $('#Email').val('');
                        }

                        return false;
                    }
                    else if (result.msg == 0) {

                        if (dofor == 2) {
                            $("#errorbox").html('');
                            $('#getsetgoedit').trigger('click');
                        }
                        else {
                            $("#errorbox").html('');
                            $('#getsetgo').trigger('click');
                        }

                        return true;

                    }

                }
            });

        //}


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
                        <a href="loadDashbord" > Dashboard</a></li>
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
                        <div class="panel-title"><button type="button" class="btn btn-default" id="callM">Add new</button>
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
                                            First Name</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Places: activate to sort column ascending" style="width: 275px;">
                                            Last Name</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" style="width: 304px;">
                                            Email</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 175px;">
                                            Type</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 175px;">
                                            Last login time</th><th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                            Last login IP</th>
                                        <th class="sorting" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Last Update: activate to sort column ascending" style="width: 232px;">
                                           Option</th>
                                      </tr>


                                    </thead>
                                    <tbody>





                                        <?php
                                        $count = 1;

                                        foreach ($Admin_list as $result) {
                                        ?>
                                    <tr role="row" class="odd">
                                        <td id = "d_no" class="v-align-middle sorting_1"> <p><?php echo $count ?></p></td>
                                        <td id = "fname_" class="v-align-middle sorting_1"> <p><?php echo $result["Fname"] ?></p></td>
                                        <td id = "lname_" class="v-align-middle"><p> <?php echo $result["Lname"] ?> </p></td>
                                        <td id = "email_" class="v-align-middle"> <p><?php echo $result["Email"] ?></p></td>
                                        <td id = "type_" class="v-align-middle"> <p><?php echo $result["Type"] ?></p></td>
<!--                                        <td id = "Password_" class="v-align-middle" style="display: none"> <p>--><?php //echo md5($result["Password"]) ?><!--</p></td>-->
                                        <td id = "lastlogintime_" class="v-align-middle"><p> <?php
                                                if (is_null($result["Last_Login_Time"]))
                                                    echo "Not yet Login";
                                                else
                                                    $result["Last_Login_Time"];
                                                ?></p></td>
                                        <td id = "lastloginip_" class="v-align-middle"><p> <?php
                                                if (is_null($result["Last_Login_Ip"]))
                                                    echo "Not yet Login";
                                                else
                                                    $result["Last_Login_Ip"];
                                                ?></p></td>
                                        <td  class="v-align-middle">
                                            <div class="btn-group">
                                                <button onclick="edit(this)" id="<?php echo $result['_id']?>" type="button" style="color: #ffffff !important;background-color: #10cfbd;" class="btn btn-success"><i class="fa fa-pencil"></i>
                                                </button>
                                                <button type="button" onclick="Delservice(this)" id="<?php echo $result['_id']?>" class="btn btn-success" style="color: #ffffff !important;background-color: #10cfbd;"><i class="fa fa-trash-o"></i>
                                                </button>
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

                <form action ="<?php echo base_url(); ?>index.php/superadmin/AddNewAdmin" method= "post" onsubmit="return validateForm() " role="form">
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
                                    <input type="email" class="form-control" placeholder="Email" name="Email" id="Email" >
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


                        <div class="row">
                            <div class="col-md-12 form-group">

                                <label style="margin-left: 12px;">Select Type</label>
                               <div class="col-md-12">
                                   <div class="">
                                       <select class="form-control" style="height: 37px;" name="type" id="selectadd">
                                           <option value="1" selected="">Select....</option>
                                           <option>admin</option>
                                           <option>ops_level_1</option>
                                           <option>ops_level_2</option>
                                           <option>management</option>

                                       </select>
                                   </div>
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
                            <button type="button" class="btn btn-primary btn-block m-t-5" onclick="validemailfromdb(1)">Add</button>
                            <button type="submit" style="display: none" id="getsetgo"></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up in" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                </button>
                <h5><span class="semi-bold">Edit Admin</span></h5>
                <p></p>
            </div>
            <div class="modal-body">

                <form action ="<?php echo base_url(); ?>index.php/superadmin/EditNewAdmin/admin" method= "post"  role="form">
                    <div class="form-group-attached">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" placeholder="First name" id="EFirstname" name="fdata[Firstname]">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" placeholder="Last name" id="ELastname" name="fdata[Lastname]">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Email</label>
                                    <input type="email" class="form-control" placeholder="Email" name="fdata[Email]" id="EEmail" >
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12">

                                <div class="form-group form-group-default">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="fdata[Password]" id="EPassword">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="form-group form-group-default">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" placeholder="Confirm Password" name="ECpassword" id ="ECpassword">
                                </div>

                            </div>
                           </div>
                         <input type="hidden" name="fdata[mongoidtoupdate]" id="mongoid">

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
                                <label id ="editerrorbox" style="color: red; font-size: 15px;"></label>
                            </div>
                        </div>
                        <div class="col-sm-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" onclick="validemailfromdb(2)">Update</button>
                            <button type="submit" style="display: none" id="getsetgoedit"></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade stick-up in" id="deletemodal" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5>Are You Sure To Delete This Admin ? </h5>
                </div>
                <div class="modal-body">

                </div>

                <div class="modal-footer">
                    <form action ="<?php echo base_url(); ?>index.php/superadmin/DeleteUser/admin" method= "post"  role="form">
                    <input type="hidden" name="mongo_id_del" id="mongo_id_del">
                    <button type="submit" class="btn btn-primary btn-cons  pull-left inline">Continue</button>
                    <button type="button" class="btn btn-default btn-cons no-margin pull-left inline" data-dismiss="modal">Cancel</button>
                </form>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
