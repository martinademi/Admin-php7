<?php
$this->load->database();
?>
<style>
    .form-horizontal .form-group
    {
        margin-left: 13px;
    }
</style>

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

        var status = <?php echo json_encode($status); ?>

        var oTable = $('#big_table').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/dt_passenger/' + status,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url() ?>assets/images/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
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
        });
    });
</script>



<script>
    $(document).ready(function () {
        $("#define_page").html("Delete");

        $('.delete').addClass('active');
        $('.delete').attr('src', "<?php echo base_url(); ?>/theme/icon/delete_on.png");
        $('.delete_thumb').addClass("bg-success");




        $('#deletev').click(function () {


            $("#display-data").text("");

            var vehicletypeid = $('#deletevehicletype').val();

            if (vehicletypeid == 0)
            {
//                           alert("please select vehicle type to delete");
                $("#display-data").text(<?php echo json_encode(POPUP_COMPANY_DELETEVEHICLE); ?>);
            }
            else if (vehicletypeid != 0)
            {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmode');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmode').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $("#errorboxdat").text(<?php echo json_encode(POPUP_DELETEVEHICLETYPE); ?>);

                $("#confirme").click(function () {
                    $.ajax({
                        url: "<?php echo base_url() . 'index.php?/superadmin/deletetype' ?>",
                        type: "POST",
                        data: {
                            vehicletypeid: vehicletypeid},
                        dataType: 'JSON',
                        success: function (response)
                        {
                            $("#errorboxdat").text(<?php echo json_encode(POPUP_COMPANY_DELETE_DELETE_VEHICLETYPE); ?>);
                            $("#confirme").hide();
                            var selectbox = document.getElementById('deletevehicletype');
                            for (var i = 0; i < selectbox.options.length; i++)
                            {
                                if (selectbox.options[i].value == $('#deletevehicletype').val())
                                    selectbox.remove(i);
                            }

                        }
                    });
                });

            }
        });






        $('#deletec').click(function () {

            $("#display-data").text("");
            var companyid = $('#deletecompany').val();

            if (companyid == 0)
            {
//                           alert("please select company to delete");
                $("#display-data").text(<?php echo json_encode(POPUP_COMPANY_DELETECOMPANY); ?>);
            }
            else {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodel');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }


                $("#errorboxdata").text(<?php echo json_encode(POPUP_DELETECOMPANY); ?>);

                $("#confirmed").click(function () {

//                        else if (confirm("Are you sure to Delete this company")) {

                    $.ajax({
                        url: "<?php echo base_url() . 'index.php?/superadmin/deletecompany' ?>",
                        type: "POST",
                        data: {
                            companyid: companyid},
                        dataType: 'JSON',
                        success: function (response)
                        {
                            $("#errorboxdata").text(<?php echo json_encode(POPUP_COMPANY_DELETE_DELETE_COMPANY); ?>);

                            $("#confirmed").hide();
                            var selectbox = document.getElementById('deletecompany');
                            for (var i = 0; i < selectbox.options.length; i++)
                            {
                                if (selectbox.options[i].value == $('#deletecompany').val())
                                    selectbox.remove(i);
                            }

                        }
                    });
                });
            }
        });



        $('#deletecoun').click(function () {
            $("#display-data").text("");
            var countryid = $('#deletecountry').val();

            if (countryid == 0)
            {

                $("#display-data").text(<?php echo json_encode(POPUP_COMPANY_DELETECOUNTRY); ?>);
            }
            else {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodels');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmodels').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_DELETECOUNTRY); ?>);
                $("#confirmeds").show();
                $("#confirmeds").click(function () {

                    $.ajax({
                        url: "<?php echo base_url() . 'index.php?/superadmin/deletecountry' ?>",
                        type: "POST",
                        data: {
                            countryid: countryid},
                        dataType: 'JSON',
                        success: function (response)
                        {
                            $("#errorboxdatas").text(<?php echo json_encode(POPUP_COMPANY_DELETE_DELETE_COUNTRY); ?>);
                            $("#confirmeds").hide();
                            var selectbox = document.getElementById('deletecountry');
                            for (var i = 0; i < selectbox.options.length; i++)
                            {
                                if (selectbox.options[i].value == $('#deletecountry').val())
                                    selectbox.remove(i);
                            }

                        }
                    });
                });
            }
        });


        $('#deletecit').click(function () {
            $("#display-data").text("");
            var cityid = $('#deletecity').val();
            
           

            if (cityid == 0)
            {

                $("#display-data").text(<?php echo json_encode(POPUP_COMPANY_DELETECITY); ?>);
            }
            else {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodeldelete');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmodeldelete').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatasdelete").text(<?php echo json_encode(POPUP_DELETECITY); ?>);
                $("#confirmdelete").show();
                $("#confirmdelete").click(function () {

                    $.ajax({
                        url: "<?php echo base_url() . 'index.php?/superadmin/deletepagecity' ?>",
                        type: "POST",
                        data: {
                            cityid: cityid},
                        dataType: 'JSON',
                        success: function (response)
                        {
                            
                            $("#errorboxdatasdelete").text(<?php echo json_encode(POPUP_COMPANY_DELETE_DELETE_CITY); ?>);
                            $("#confirmdelete").hide();
                           $("#confirmmodeldelete").dialog( "close" );
                            var selectbox = document.getElementById('deletecity');
                            for (var i = 0; i < selectbox.options.length; i++)
                            {
                                if (selectbox.options[i].value == $('#deletecity').val())
                                    selectbox.remove(i);
                            }

                        }
                    });
                });
            }
        });






        $('#deletedriv').click(function () {

            $("#display-data").text("");
            var masterid = $('#deletedriver').val();
            if (masterid == 0)
            {
//                           alert("please select driver to delete");
                $("#display-data").text(<?php echo json_encode(POPUP_COMPANY_DELETEDRIVER); ?>);
            }
//                       else if (confirm("Are you sure to Delete this driver")) {

            else {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodelss');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirmmodelss').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $("#errorboxdatass").text(<?php echo json_encode(POPUP_DELETEDRIVER); ?>);

                $("#confirmedss").click(function () {

                    $.ajax({
                        url: "<?php echo base_url() . 'index.php?/superadmin/deletedriver' ?>",
                        type: "POST",
                        data: {
                            masterid: masterid},
                        dataType: 'JSON',
                        success: function (response)
                        {
                            $("#errorboxdatass").text(<?php echo json_encode(POPUP_COMPANY_DELETE_DELETE_DRIVERDELETE); ?>);
                            $("#confirmedss").hide();

                            var selectbox = document.getElementById('deletedriver');
                            for (var i = 0; i < selectbox.options.length; i++)
                            {
                                if (selectbox.options[i].value == $('#deletedriver').val())
                                    selectbox.remove(i);
                            }

                        }
                    });
                });
            }
        });



        $('#logoutdriver').click(function () {

            $("#display-data").text("");
            var driverid = $('#deletedriver').val();
            if (driverid == 0)
            {
//                           alert("please select driver to logout");
                $("#display-data").text(<?php echo json_encode(POPUP_COMPANY_LOGOUTDRIVER); ?>);
            }
            else //if (confirm("Are you sure to logout this driver"))
            {


                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#con');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#con').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $("#err").text(<?php echo json_encode(POPUP_COMPANY_SURELOGOUTDRIVER); ?>);

                $("#conf").click(function () {

                    $.ajax({
                        url: "<?php echo base_url() . 'index.php?/superadmin/logoutdriver' ?>",
                        type: "POST",
                        data: {
                            driverid: driverid},
                        dataType: 'JSON',
                        success: function (response)
                        {
                                
                            $(".close").trigger("click");
                              
                        }
                    });
                });
            }
        });



        $('#deletevemodal').click(function () {

            $("#display-data").text("");
            var modalid = $('#deletevehiclemodal').val();
            if (modalid == 0)
            {
//                           alert("please select vehicle modal to delete");
                $("#display-data").text(<?php echo json_encode(POPUP_DELETEVEHICLEMODAL); ?>);
            }
            else {


                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirms');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#confirms').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }

                $("#errorboxd").text(<?php echo json_encode(POPUP_DELETEDVEHICLEMODAL); ?>);

                $("#confirmd").click(function () {

//                       else if (confirm("Are you sure to Delete this vehicle modal")) {

                    $.ajax({
                        url: "<?php echo base_url() . 'index.php?/superadmin/deletemodal' ?>",
                        type: "POST",
                        data: {
                            modalid: modalid},
                        dataType: 'JSON',
                        success: function (response)
                        {

                            $("#errorboxd").text(<?php echo json_encode(POPUP_COMPANY_DELETE_DELETE_MODELDELETE); ?>);
                            $("#confirmd").hide();

                            var selectbox = document.getElementById('deletevehiclemodal');
                            for (var i = 0; i < selectbox.options.length; i++)
                            {
                                if (selectbox.options[i].value == $('#deletevehiclemodal').val())
                                    selectbox.remove(i);
                            }
                           
                        }
                    });

                });

            }
        });

    });

</script>




<div class="page-content-wrapper"style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">


        <div class="brand inline" style="  width: auto;
             font-size: 20px;
             color: gray;
             margin-left: 30px;padding-top: 20px;">
           <!--                    <img src="--><?php //echo base_url();     ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();     ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();     ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="color:#0090d9;">DELETE</strong><!-- id="define_page"-->
        </div>
        <!-- START JUMBOTRON -->
        <div class="jumbotron bg-white" data-pages="parallax">
            <!--            <div class="inner">
                             START BREADCRUMB 
                            <ul class="breadcrumb" style="margin-left: 20px;">
                                <li><a href="#" class="active">dlete</a>
                                </li>
            
            
                            </ul>
                             END BREADCRUMB 
                        </div>-->



            <div class="container-fluid container-fixed-lg bg-white">
                <div class="panel panel-transparent " >

                    <div class="error-box" id="display-data" style="text-align:center"></div>

                    <div id="rootwizard" class="m-t-50">
                        <!-- Nav tabs -->
<!--                        <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                            <li class="" >
                                <strong >Enter details</strong></a>
                            </li>

                        </ul>-->
                        <!-- Tab panes -->
                        <!--<form id="addentity" class="form-horizontal" role="form" action="#"  enctype="multipart/form-data">-->
                            <div class="tab-content">
                                <div class="tab-pane padding-20 slide-left active" id="tab1">
                                    <div class="row row-same-height">


                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">Select Vehicle type</label>
                                            <div class="col-sm-6">
                                <!--                <input type="text" class="form-control" id="entityname" placeholder="Name" name="entityname"  aria-required="true">-->

                                                <select id="deletevehicletype" name="vehicletype"  class="form-control" >
                                                    <option value="0">vehicle type </option>
                                                    <?php
                                                    foreach ($getvehicletype as $typelist) {
                                                        echo "<option value='" . $typelist->type_id . "'>" . $typelist->type_name . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="pull-right m-t-10"><button class="btn btn-primary btn-cons" type="button" id="deletev">delete</button></div>

                                        </div>
                                        
                                        <br>
                                        <br>
                                        
<!--                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">Select Company</label>
                                            <div class="col-sm-6">
                                                <select id="deletecompany" name="companyname"  class="form-control" >
                                                    <option value="0">select company </option>
                                                    <?php
                                                    foreach ($getcompany as $typelist) {
                                                        echo "<option value='" . $typelist->company_id . "'>" . $typelist->companyname . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="pull-right m-t-10"><button class="btn btn-primary btn-cons" id="deletec" type="button">delete</button></div>
                                        </div>
                                        
                                         <br>
                                        <br>-->

                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">Select Country</label>
                                            <div class="col-sm-6">
                                                <select id="deletecountry" name="countryname"  class="form-control" >
                                                    <option value="0">select country </option>
                                                    <?php
                                                    foreach ($country as $typelist) {
                                                        echo "<option value='" . $typelist->Country_Id . "'>" . $typelist->Country_Name . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="deletecoun" type="button">delete</button></div>
                                        </div>

                                         <br>
                                        <br>
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">Select city</label>
                                            <div class="col-sm-6">
                                                <select id="deletecity" name="companyname"  class="form-control" >
                                                    <option value="0">Select city</option>
                                                    <?php
                                                    foreach ($city_ram as $typelist) {
                                                        echo "<option value='" . $typelist->City_Id . "'>" . $typelist->City_Name . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="deletecit">delete</button></div>
                                        </div>

                                         <br>
                                        <br>

<!--                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">Select Driver</label>
                                            <div class="col-sm-6">
                                                <select id="deletedriver" name="driver" class="form-control">

                                                    <option value="0">Select a driver</option>
                                                    <?php
                                                    foreach ($driver as $row) {
                                                        echo "<option value='" . $row->mas_id . "'>" . $row->last_name . " " . $row->first_name . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="deletedriv" type="button" >delete</button></div>
                                            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="logoutdriver" type="button">logout</button></div>


                                        </div>-->

                                         <br>
                                        <br>
<!--
                                        <div class="form-group">
                                            <label for="fname" class="col-sm-3 control-label">Select Vehicle </label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="entityregno" placeholder="Registration no" name="entityregno"  aria-required="true">
                                                <select id="deletevehiclemodal" name="driver" class="form-control">

                                                    <option value="0">Select vehicle model</option>
                                                    <?php
                                                    foreach ($vehiclemodal as $row) {
                                                        echo "<option value='" . $row->id . "'>" . $row->vehiclemodel . "</option>";
                                                    }
                                                    ?>


                                                </select>
                                            </div>
                                            <div class="pull-right m-t-10"> <button class="btn btn-primary btn-cons" id="deletevemodal" type="button">delete</button></div>

                                        </div>-->

                                         <br>
                                        <br>

                                    </div>
                                </div>
                             </div>
                        </form>
                      </div>
                </div>

            </div>

            <!--</form>-->

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


<!--<script src="http://107.170.66.211/apps/RylandInsurence/RylandInsurence/javascript/RylandInsurence.js" type="text/javascript"></script>-->





<div class="modal fade stick-up" id="confirmmode" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="errorboxdat" style="font-size: large;text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirme" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>  

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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

                    <div class="error-box" id="errorboxdata" style="font-size: large;text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>   
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade stick-up" id="confirmmodeldelete" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="errorboxdatasdelete" style="font-size: large;text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmdelete" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up" id="confirmmodelss" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="errorboxdatass" style="font-size: large;text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmedss" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up" id="confirms" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="errorboxd" style="font-size: large;text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmd" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<div class="modal fade stick-up" id="con" tabindex="-1" role="dialog" aria-hidden="true">
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

                    <div class="error-box" id="err" style="font-size: large;text-align:center"><?php echo COMPAIGNS_DISPLAY; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="conf" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


