<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);
$active = "active";
?>
<style>
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }

    .btn {
        /* font-size: 11px; */
        width: auto;
        border-radius: 30px;
    }
    button#btnStickUpSizeToggler {
        /* font-size: 11px; */
        width: auto;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {


        /*date picker*/
        var date = new Date();
        $('.datepicker-component').datepicker({
        });

        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });

        $('#datepicker-component').on('changeDate', function () {
            $('.datepicker').hide();
        });


        citiesList();
        $(".student-menu").addClass('active');
        // getAcceptedDataTables();

        $('#activateTab').hide();
        $('#activate').hide();
        $('#assignTab').hide();
        $('#addactive').hide();
        $('.changeMode').click(function () {


            /* $('#campaigns-datatable').DataTable({
             "pageLength" : 10,
             "sPaginationType" : "full_numbers",
             "aaSorting": [],
             "bDestroy" : true,
             "bScrollCollapse" : true,
             "destroy": true,
             "scrollCollapse": true,
             "iDisplayLength": 20,
             "ajax": {
             url : $(this).attr('data'),
             type : 'POST'
             },
             });*/

            $('.datepicker-component').on('changeDate', function () {
                $(this).datepicker('hide');
            });

            $('#datepicker-component').on('changeDate', function () {
                $('.datepicker').hide();
            });


            $('#campaigns-datatable').DataTable({
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 10,
                "bProcessing": true,
                "bServerSide": true,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 10,
                "serverSide": true,
                "ajax": {
                    url: $(this).attr('data'),
                    type: 'POST'
                },
                "language": {
                    "lengthMenu": "Display -- records per page",
                    "zeroRecords": "No matching records found",
                    "infoEmpty": "No records available"
                }
            });
            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');


        });



        $(document).ready(function () {

            $(".cityDetails").live('click', function () {

                var cityIds = $(this).attr("city_ids");
                $.ajax({
                    url: "<?php echo APILink ?>" + "admin/cityDetailsByCityIds/" + cityIds,
                    type: 'GET',
                    dataType: 'json',
                    data: {},
                })
                        .done(function (json) {
                            if (json.data.length > 0) {
                                $("#showCityDetailsModal").modal();
                                $("#cityDetailsBody").empty();
                                for (var i = 0; i < json.data.length; i++) {
                                    var cityDetailsData = '<tr>' +
                                            '<td style="text-align:center">' + (i + 1) + '</td>' +
                                            '<td style="text-align:center">' + json.data[i].city + '</td>' +
                                            '<td style="text-align:center">' + json.data[i].country + '</td>' +
                                            '<td style="text-align:center">' + json.data[i].currencySymbol + '</td>' +
                                            '</tr>';
                                    $("#cityDetailsBody").append(cityDetailsData);
                                }



                            } else {

                            }


                        });
            });


        });

    });
</script>
<script>
    $(document).ready(function () {

        var table = $('#campaigns-datatable');
        var settings = {

            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 10,
            "bProcessing": true,
            "bServerSide": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 10,
            "serverSide": true,
            "fnInitComplete": function () {
               
            },
            "ajax": {
                url: "<?php echo base_url('index.php?/campaigns/getAllCampaigns/2/'); ?>",
                type: 'POST',
                "data": function (d) {
                    d.cityId = $("#citiesList").val();
                    return d;
                }
            },

            "language": {
                "lengthMenu": "Displays -- records per page",
                "zeroRecords": "No matching records found",
                "infoEmpty": "No records available"
            }
        };

        table.dataTable(settings);
        $('#search-tables').keyup(function () {
            table.fnFilter($(this).val());
        });

        $("#citiesList").change(function () {
            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status1 = urlChunks[6];

            var table = $('#campaigns-datatable');
            var settings = {

                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 10,
                "bProcessing": true,
                "bServerSide": true,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 10,
                "serverSide": true,
                "ajax": {
                    url: '<?php echo base_url() . 'index.php?/campaigns/getAllCampaigns/' ?>' + status1 + '/',
                    type: 'POST',
                    "data": function (d) {
                        d.cityId = $("#citiesList").val();
                        return d;
                    }
                },

                "language": {
                    "lengthMenu": "Displays -- records per page",
                    "zeroRecords": "No matching records found",
                    "infoEmpty": "No records available"
                }
            };

            table.dataTable(settings);


        });

        /*Start date*/


    });


    function getFranchise() {
        // $.ajax({
        //           url: "<?php echo base_url() ?>index.php?/Student/getStudentCount",
        //           type: "POST",
        //           dataType: 'json',
        //            async:true,
        //           success: function (response)
        //           {
        //                $('.newStudentCount').text(response.data.New);
        //                $('.bannedStudentCount').text(response.data.Banned);
        //                $('.assignedStudentCount').text(response.data.Assigned);
        //                $('.unassignedStudentCount').text(response.data.Unassigned);
        //                $('.newAddressCount').text(response.data.newAddress);
        //           }
        //       });
    }
    var html;
    var currentTab = 1;
    var currentTabs = 1; // this is for managing the status when user click on banned and active
    $(document).ready(function () {
        getFranchise();
    });
</script>
<script type="text/javascript">

// Function to update campaign status
    function updateCampaignStatus(couponIds, status) {
        $.ajax({
            url: "<?php echo base_url('index.php?/campaigns/updateCampaignStatus'); ?>",
            type: 'POST',
//            dataType: 'JSON',
            data: {
                couponId: couponIds,
                status: status
            },
            success: function (json)
            {
              
//                 if (json.msg.message === "success") {
                     $('#campaigns-datatable').DataTable().ajax.reload();
                    $("#confirmmodels").modal('hide')
                    // window.location.reload();
//                }else{
//                    alert('Unable to update status. Please try agin later');
//                }
            }
        })
    }






    $(document).ready(function () {

        $('.whenclicked li').click(function () {

            if ($(this).attr('id') == "my1") {

                $('#activatenew').hide();
                $('#addTab').show();
                $('#deactivate').show();
                $('#deleteTab').show();
                $('#add').show();
                $('.deactivateCampaign').show();


            } else if ($(this).attr('id') == "my2") {

                $('#deleteTab').show();
                $('#activatenew').show();
                $('#addTab').hide();
                $('#deactivate').hide();
                $('#addactive').show();


            } else
            if ($(this).attr('id') == "my3") {

                $('#add').hide();
                $('#deleteTab').hide();
                $('#addTab').hide();
                $('#activatenew').hide();
                $('.deactivateCampaign').hide();



            } else if ($(this).attr('id') == "my4") {
                $('#add').hide();
                $('#deleteTab').hide();
                $('#addTab').hide();
                $('#activatenew').hide();
                $('.deactivateCampaign').hide();
            }


        });

        var status = '<?php echo $status; ?>';
        var table = $('#big_table');
        $('#reassignTab').hide();
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });
        $('#big_table').on('init.dt', function () {
            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            if (status == 1) {
                $('#big_table').dataTable().fnSetColumnVis([0], false);
            } else
                $('#big_table').dataTable().fnSetColumnVis([0], false);
        });
        $('.changeMode').click(function () {

            var tab_id = $(this).attr('data-id');
            currentTabs = tab_id;
            $('#display-data').text('');
            if (currentTab != tab_id)
            {
                currentTab = tab_id;
                $('#big_table').hide();
                if (tab_id == 1)
                {
                    console.log("clcked");
                    $('#add').show();
                    $('#edit').show();
                    $('#del_all').show();
                    $('#banned').show();
                    $('#activateTab').hide();
                    $('#activate').hide();
                    $('#assignTab').hide();
                    $('#reassignTab').hide();
                    $('#addactive').hide();

                }
                if (tab_id == 2)
                {
                    //$('#add').hide();
                    $('#edit').hide();
                    $('#del_all').show();
                    $('#banned').hide();
                    $('#activateTab').show();
                    $('#activate').show();
                    $('#assignTab').hide();
                    $('#reassignTab').hide();
                }
                if (tab_id == 3)
                {
                    // $('#add').hide();
                    $('#edit').show();
                    $('#del_all').show();
                    $('#banned').hide();
                    $('#activateTab').hide();
                    $('#activate').hide();
                    $('#assignTab').hide();
                    $('#reassignTab').show();
                }
                if (tab_id == 4)
                {
                    //$('#add').hide();
                    $('#edit').show();
                    $('#del_all').show();
                    $('#banned').hide();
                    $('#activateTab').hide();
                    $('#activate').hide();
                    $('#assignTab').show();
                    $('#reassignTab').hide();
                }
                if (tab_id == 5)
                {
                    //$('#add').hide();
                    $('#edit').show();
                    $('#del_all').show();
                    $('#banned').hide();
                    $('#activateTab').hide();
                    $('#activate').hide();
                    $('#assignTab').hide();
                    $('#reassignTab').show();

                }

                var table = $('#big_table');
                $('#big_table_processing').show()
                $('.tabs_active').removeClass('active');
                $(this).parent().addClass('active');
                //table.dataTable(settings);
                $('#big_table').on('init.dt', function () {
                    var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                    var status = urlChunks[urlChunks.length - 1];

                    $('#big_table').dataTable().fnSetColumnVis([], false);


                });
            }


        });
    });
</script>

<script>
    $(document).ready(function () {

        $(".deactivateCampaign").click(function () {
            var status = 3;
            var val = [];
            $(':checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            updateCampaignStatus(val, status);

        });

        $("#addactive").click(function () {
            var status = 2;
            var val = [];
            $(':checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            updateCampaignStatus(val, status);

        });



        $("#del_all").click(function () {

            if ($(".checkbox1").is(":checked") == false) {
                $('#modalBodyText').text('Please select the promo to delete');
                $("#confirmmodels").modal();
                return;
            }
            $('#modalBodyText').text('');
            $("#modalFooter").text('');
            $('#confirmeds').attr('data_id', '');
            $('#confirmeds').attr('status', '');
            $('#confirmeds').attr('updateType', '');
            var couponId = $(".checkbox1:checked").val();

            var modalText = 'Do you want to continue to delete';

            $('#modalBodyText').text(modalText);
            var deleteButton = '<button type="button" class="btn btn-primary pull-right" data_id="' + couponId + ' " id="confirmDelete1" style="margin:0;">YES DELETE</button>"';
            $("#modalFooter").append(deleteButton);
            $("#confirmmodels").modal();
        });

        // Delete offer
        $("body").on('click', '#confirmDelete1', function () {
            var status = 5;
            var val = [];
            $(':checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            updateCampaignStatus(val, status);
        });

    });

</script>

<script>
    function edit()
    {
        var checkValues = $('.checkbox1:checked').map(function ()
        {
            return $(this).val();
        }).get();
        console.log(checkValues);
        if (checkValues.length == 0) {
            $('#alertForNoneSelected').modal('show');
        } else if (checkValues.length > 1)
        {
            $('#alertForSelected').modal('show');
        } else
        {
            window.location.href = "<?php echo base_url('index.php?/Student/editstudent'); ?>?ids=" + checkValues;
        }
    }
</script>
<!------------------------------------------ for assign route to the student---------------------------------------------->
<script>
    function assign()
    {
        var checkValues = $('.checkbox1:checked').map(function ()
        {
            return $(this).val();
        }).get();
        if (checkValues.length == 0) {
            $('#alertForNoneSelected').modal('show');
        } else if (checkValues.length > 1)
        {
            $('#alertForSelected').modal('show');
        } else
        {
            if (currentTabs == 3)
            {
                window.location.href = "<?php echo base_url('index.php?/Student/reassignstudent'); ?>?ids=" + checkValues;
            } else
            {
                window.location.href = "<?php echo base_url('index.php?/Student/assignstudent'); ?>?ids=" + checkValues;
            }
        }
    }


function citiesList(){
        $.ajax({
                url: "<?php echo APILink ?>" + "admin/city",
                type: 'GET',
                dataType: 'json',
                headers: {
                  language: 0
                },
                data: {                  
                },
            }).done(function(json) {

                console.log(json);
                
                $("#citiesList").html('<option value="" selected>Select All</option>');
                
                 for (var i = 0; i< json.data.length; i++) {
                
                    var citiesList = "<option value="+ json.data[i].id + " currency="+ json.data[i].currency + ">"+  json.data[i].cityName +"</option>";
                    $("#citiesList").append(citiesList);  
                }
                //   $('#citiesList').multiselect({
                //     includeSelectAllOption: true,
                //     enableFiltering: true,
                //     enableCaseInsensitiveFiltering : true,
                //     buttonWidth: '100%',
                //     maxHeight: 300,
                // });
        });
     }


</script>



<style>
    .exportOptions{
        display: none;
    }
</style>

<!----------------------------------------view page start-------------------------------------------------------->
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <input type="hidden" id="businessId" value="<?php echo $this->session->userdata('userId'); ?>" >
    <div class="content">
        <div class="brand inline" style="  width: auto;color: gray;margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;"><?php echo $this->lang->line('student'); ?></strong>
        </div>
        <div class="brand inline" style="  width: auto;
             font-size: 16px;
             color: gray;
             margin-left: 7px;padding-top: 20px;padding-bottom:10px;">

            <strong style="color:#0090d9;">LOYALTY PROGRAM</strong><!-- id="define_page"-->
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
            <li id= "my1" class="tabs_active <?php echo $active ?>" style="cursor:pointer">
                <a  class="changeMode New_" data="<?php echo base_url("/index.php?/campaigns/getAllCampaigns/2/") ?>" data-id="1">
                    <span>ACTIVE</span>
                    <span class="badge newStudentCount" style="background-color: #337ab7;"></span>
                </a>
            </li>
            <li id= "my2" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode New_" data="<?php echo base_url("/index.php?/campaigns/getAllCampaigns/3/") ?>" data-id="1">
                    <span>INACTIVE</span>
                    <span class="badge newStudentCount" style="background-color: #337ab7;"></span>
                </a>
            </li>
            <li id= "my3" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode New_" data="<?php echo base_url("/index.php?/campaigns/getAllCampaigns/4/") ?>" data-id="1">
                    <span>EXPIRED</span>
                    <span class="badge newStudentCount" style="background-color: #337ab7;"></span>
                </a>
            </li>
            <li id= "my4" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode New_" data="<?php echo base_url("/index.php?/campaigns/getAllCampaigns/5/") ?>" data-id="1">
                    <span>DELETED</span>
                    <span class="badge newStudentCount" style="background-color: #337ab7;"></span>
                </a>
            </li>


            <div class="pull-right m-t-10 new_button cls111" id="activatenew">
                <a href="#"> 
                    <button class="btn btn-success btn-cons" id="addactive">
                        ACTIVATE
                    </button>
                </a>
            </div>
            <div class="pull-right m-t-10 new_button cls111" id="deleteTab">
                <a href="#">
                    <button class="btn btn-danger btn-cons deleteCampaign" id="del_all">
                        DELETE
                    </button>
                </a>
            </div>
            <div class="pull-right m-t-10 new_button cls111" id="deactivate">
                <a href="#">
                    <button class="btn btn-warning btn-cons deactivateCampaign" id="del_all">
                        DEACTIVATE
                    </button>
                </a>
            </div>
            <div class="pull-right m-t-10 new_button cls110" id="addTab">
                <a href="<?php echo base_url() ?>index.php?/campaigns/addNewCampaign/1/0"> 
                    <button class="btn btn-success btn-cons" id="add">
                        CREATE
                    </button>
                </a>
            </div>

        </ul>
        <!-- Tab panes -->
        <!-- START JUMBOTRON -->
        <div class="">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent ">
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="col-sm-6 form-group">
                                                <!--<label for="fname" class="col-sm-1 control-label aligntext" style=" margin-top: 2%;">CITIES <span ></span></label>--> 
                                    <div class="col-sm-4">
                                        <select id="citiesList" name="company_select" class="form-control" style="padding: 5%; margin-top: 1%;border-radius: 13px;width: 126px;">
                                            <!-- <option disabled selected value> None Selected</option> -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 form-group">

                                    <!-- <div class="col-sm-5 row input-daterange input-group" style="float: left">
                                        <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">
                                    </div>
                                    <div class="col-sm-1 " style="margin-left: 10px;">
                                        <button class="btn btn-primary" style="width: 60px !important;border-radius: 22%;" type="button" id="searchData">Search</button>
                                    </div> -->

                                    <div class="col-sm-5 row pull-right">
                                        <div class="pull-right"><input type="text" id="search-tables"  style="border-radius: 29px;" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                    </div>
                                </div>



                                <div class="panel-body">
<?php
echo $this->table->generate();
?>
                                </div>
                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--show city details -->
<div class="modal fade" id="showCityDetailsModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;text-transform: capitalize;"><span id="cityDetails">CITIES DETAILS</span></strong>
            </div>
            <div class="modal-body">
                <!-- data is comming from js which is written at top-->
                <table class="table table-bordered schedulepopup">
                    <thead>
                        <tr>
                            <th style="width:10%;text-align: center; color: darkturquoise;">S.NO</th>
                            <th style="width:15%;text-align: center; color: darkturquoise;">CITY NAME</th>
                            <th style="width:20%;text-align: center; color: darkturquoise;">COUNTRY NAME</th>
                            <th style="width:20%;text-align: center; color: darkturquoise;">CURRENCY</th>
                        </tr>
                    </thead>
                    <tbody id="cityDetailsBody">
                    </tbody>
                </table>


            </div>
            <div class="modal-footer">  
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="" id="modalBodyText" style="font-size: large;text-align:center"></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" id="modalFooter">

                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


