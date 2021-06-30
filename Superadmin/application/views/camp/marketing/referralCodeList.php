<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);
$active = "active";
?>
<style>
    .btn {
        /* font-size: 11px; */
        width: auto;
        border-radius: 30px;
    }
    button#btnStickUpSizeToggler {
        /* font-size: 11px; */
        width: auto;
    }

    .badge {
        font-size: 9px;
        margin-left: 2px;
    }

</style>
<script>
    $(function () {

        $(document).ajaxComplete(function () {
        // console.log("hsdfsdf");
        var access_right_pg = '<?= $access_right_pg ?>';
        if (access_right_pg == 000) {
    //   base_url().'index.php?/superadmin/access_denied';
        } else if (access_right_pg == 100) {
            $('.cls110').remove();
            $('.cls111').remove();
        } else if (access_right_pg == 110) {
            $('.cls111').remove();
        } 
    });
        /* student details show on click */
        $(document).on('click', '.showSchedule', function ()
        {
            $('#scheduledoc_body').empty();
            $('#scheduleTime_body').empty();
            var businessId = $("#businessId").val();
            var scheduleId = $(this).attr('scheduleId');
            var stopName = $(this).attr('stopName');
            $("#scheduleHeading").text($(this).attr('scheduleType') + ' Schedule')
            if (scheduleId)
            {
                $.ajax({
                    url: '<?php echo APILink ?>schedule/' + scheduleId + '/' + businessId,
                    type: 'GET'
                }).done(function (data) {
                    $('#scheduledoc_body').empty();
                    var sno = 1;
                    var html = "<tr style='text-transform: capitalize;'><td style='text-align: center;'>" + sno + "</td><td style='text-align: center;'>";
                    html += "<span>" + data.data[0].vehicleDetails.vehicleName + "</span></td><td style='text-align: center;'>" + data.data[0].driverDetails.driverFirstName + ' ' + data.data[0].driverDetails.driverLastName + "</td><td style='text-align: center;'>" + data.data[0].scheduleId + "</td><td style='text-align: center;'>" + stopName + "</td>";
                    html += "<td style='text-align: center;'>" + data.data[0].routeDetails.routeName + "</td>";
                    html += "</tr>";
                    sno = sno + 1;
                    $("#scheduledoc_body").append(html);

                    $('#scheduleTime_body').empty();
                    var snos = 1;
                    $.each(data.data[0].days, function () {
                        var html = "<tr style='text-transform: capitalize;'><td style='text-align: center;'>" + snos + "</td><td style='text-align: center;'><a style='font-weight:600' vehicleid=" + this._id + ">";
                        html += '' + this.Day + "</a></td><td style='text-align: center;'>" + this.startTime + "</td>";
                        html += "<td style='text-align: center;'>" + this.endTime + "</td>";
                        html += "</tr>";
                        snos = snos + 1;
                        $("#scheduleTime_body").append(html);
                    });
                    $('#showScheduleModel').modal('show');
                });
            }
            $('#showScheduleModel').modal('show');
        });
    });
</script>
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


        $('#activeTab').hide();
        $(".student-menu").addClass('active');

        citiesList();
        $('#activateTab').hide();
        $('#activate').hide();
        $('#assignTab').hide();
        $('.changeMode').click(function () {
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
                "fnInitComplete": function () {
                   
                },
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

    });
</script>
<script>

    $(document).ready(function () {


        $("#deactivate").click(function () {

            var status = 3;
            var val = [];
            $(':checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            if (val.length == 0) {
                var modalText = 'Please select at least one code to activate';
                var button = '<button type="button" class="btn btn-primary pull-right" data-dismiss="modal">CLOSE</button>';
                $('#modalBodyText').text(modalText);
                $("#modalFooter").append(button);
                $("#confirmmodels").modal();
            } else {
                updateCampaignStatus(val, status);
            }
        });

//active 
        $("#adactive").click(function () {

            var status = 2;
            var val = [];
            $(':checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });
            if (val.length == 0) {
                var modalText = 'Please select at least one code to activate';
                var button = '<button type="button" class="btn btn-primary pull-right" data-dismiss="modal">CLOSE</button>';
                $('#modalBodyText').text(modalText);
                $("#modalFooter").append(button);
                $("#confirmmodels").modal();
            } else {
                updateCampaignStatus(val, status);
            }
        });
        console.log("firsst");
        


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
                /*
                 * .cls100 = view
                 * .cls110 = add
                 * .cls111 = edit and delete
                 */
               
            },
            "ajax": {
                url: "<?php echo base_url('index.php?/ReferralController/referralCampaignsByStatus/2'); ?>",
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
            console.log('urlChunk', urlChunks);
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
                "fnInitComplete": function () {
                    /*
                     * .cls100 = view
                     * .cls110 = add
                     * .cls111 = edit and delete
                     */
                    if (access == "100") {
                        $('.cls110').remove();
                        $('.cls111').remove();
                    } else if (access == "110") {
                        $('.cls111').remove();

                    }
                },
                "ajax": {
                    url: '<?php echo base_url() . 'index.php?/ReferralController/referralCampaignsByStatus/' ?>' + status1 + '/',
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
    $(document).ready(function () {

    $(".cityDetails").live('click', function(){
            var cityIds = $(this).attr("city_ids");
            $.ajax({
            url: "<?php echo APILink ?>admin/cityDetailsByCityIds/" + cityIds,
            type: 'GET',
            dataType: 'json',
            headers: {
                  language: 'en'
                },
            data: { },
        })
        .done(function(json) {
            console.log('details---',json)
            if (json.data.length > 0 ) {
                $("#showCityDetailsModal").modal();
                $("#cityDetailsBody").empty();
                for (var i = 0; i< json.data.length; i++) {
                    var cityDetailsData = '<tr>'+
                                    '<td style="text-align:center">' + (i+1) +'</td>' +
                                    '<td style="text-align:center">' + json.data[i].cityName+ '</td>' +
                                    '<td style="text-align:center">' + json.data[i].country+ '</td>' +
                                    '<td style="text-align:center">' + json.data[i].currencySymbol + '</td>' +
                                    '</tr>';
                    $("#cityDetailsBody").append(cityDetailsData);  
                   
                }



            }else{

            }


        });
});

        $(".newUserDetails").live('click', function () {
            var campaignId = $(this).attr("campaignid");
            $.ajax({
                url: "<?php echo APILink ?>" + "referralCampaignDetailsById/" + campaignId,
                type: 'GET',
                dataType: 'json',
                headers: {
                  language: 'en'
                },
                data: {},
            })
                    .done(function (json) {
                        if (json.data.length > 0) {



                            $("#showDiscountDetailsModal").modal();

                            $(".newUserDiscountModalData").empty();

                            $(".referrerDiscountModalData").empty();
                            var newUserDiscType = '';
                            var refUserDiscType = '';
                            if (json.data[0].newUserDiscount.customer.discountType == 1) {
                                newUserDiscType = json.data[0].currencySymbol;
                            } else {
                                newUserDiscType = '%';
                            }
                            if (json.data[0].referrerDiscount.customer.discountType == 1) {
                                refUserDiscType = json.data[0].currencySymbol;
                            } else {
                                refUserDiscType = '%';
                            }

                            var newUserDiscountData = '<tr>' +
                                    '<td style="text-align:center">' + json.data[0].newUserDiscount.customer.rewardTypeName + '</td>' +
                                    '<td style="text-align:center">' + json.data[0].newUserDiscount.customer.discountTypeName + '</td>' +
                                    '<td style="text-align:center">' + json.data[0].newUserDiscount.customer.discountAmt + ' ' + newUserDiscType + '</td>' +
                                    '</tr>';
                            $(".newUserDiscountModalData").append(newUserDiscountData);
                            var referrerDiscounttModalData = '<tr>' +
                                    '<td style="text-align:center">' + json.data[0].referrerDiscount.customer.rewardTypeName + '</td>' +
                                    '<td style="text-align:center">' + json.data[0].referrerDiscount.customer.discountTypeName + '</td>' +
                                    '<td style="text-align:center">' + json.data[0].referrerDiscount.customer.discountAmt + ' ' + refUserDiscType + '</td>' +
                                    '</tr>';
                            $(".referrerDiscountModalData").append(referrerDiscounttModalData);

                        } else {

                        }


                    });
        });

        $(".referrerDiscount").live('click', function () {
            var campaignId = $(this).attr("campaignid");
            $.ajax({
                url: "<?php echo APILink ?>" + "referralCampaignDetailsById/" + campaignId,
                type: 'GET',
                dataType: 'json',
                headers: {
                  language: 'en'
                },
                data: {},
            })
                    .done(function (json) {
                        if (json.data.length > 0) {

                            $("#discountDetailsText").text("REFERRER DISCOUNT DETAILS");

                            $("#showDiscountDetailsModal").modal();

                            $("#discountDetailsBody").empty();


                            var newUserDiscountData = '<tr>' +
                                    '<td style="text-align:center">' + json.data[0].referrerDiscount.rewardTypeName + '</td>' +
                                    '<td style="text-align:center">' + json.data[0].referrerDiscount.discountTypeName + '</td>' +
                                    '<td style="text-align:center">' + json.data[0].referrerDiscount.discountAmt + '</td>' +
                                    '</tr>';
                            $("#discountDetailsBody").append(newUserDiscountData);
                        } else {

                        }


                    });
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
                    $('#add').show();
                    $('#edit').show();
                    $('#del_all').show();
                    $('#banned').show();
                    $('#activateTab').hide();
                    $('#activate').hide();
                    $('#assignTab').hide();
                    $('#reassignTab').hide();
                }
                if (tab_id == 2)
                {
                    $('#add').hide();
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
                    $('#add').hide();
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
                    $('#add').hide();
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
                    $('#add').hide();
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
                    if (status == 1) {
                        $('#big_table').dataTable().fnSetColumnVis([], false);
                    } else
                        $('#big_table').dataTable().fnSetColumnVis([], false);
                });
            }
        });
    });

    // Function to update campaign status
    function updateCampaignStatus(couponIds, status) {
        $.ajax({
            url: "<?php echo base_url('index.php?/referralController/updatecouponCodeStatus'); ?>",
            type: 'POST',
//            dataType: 'json',
            data: {
                couponId: couponIds,
                status: status
            },
        })
                .done(function (json) {
                    console.log(json);
//                    if (json.msg.message === "success") {
                    $('#campaigns-datatable').DataTable().ajax.reload();
                    $("#confirmmodels").modal('hide')
                    // window.location.reload();
//                    } else {
//                        alert('Unable to update status. Please try agin later');
//                    }
                });
    }


    // Delete offer
    $("body").on('click', '#del_all', function () {
        var status = 5;
        var val = [];
        $(':checkbox:checked').each(function (i) {
            val[i] = $(this).val();
        });
        updateCampaignStatus(val, status);
    });


    // Offer inactive



</script>




<!--------------------------------------- for activate the studen---------------------------------------------->
<script>
    $(document).ready(function () {


        $('.whenclicked li').click(function () {
            console.log("clicked");
            if ($(this).attr('id') == "my1") {
                console.log("clicked 1");
                $('#add').show();
                $('#deleteTab').show();
                $('#deactivateTab').show();
                $('#activeTab').hide();



            } else if ($(this).attr('id') == "my2") {
                console.log("clicked 2");
                $('#deleteTab').show();
                $('#addTab').show();
                $('#activeTab').show();
                $('#add').hide();
                $('#deactivateTab').hide();
                $('#  del_all').hide();


            } else
            if ($(this).attr('id') == "my3") {
                console.log("clicked 3");
                $('#add').hide();
                $('#deleteTab').hide();
                $('#deactivateTab').hide();
                $('#activeTab').hide();

            }


        });

        resetcheckbox();
        $("#activate").on('click', function (e) {
            e.preventDefault();
            var activateValue = [];
            activateValue = $('.checkbox1:checked').map(function ()
            {
                return $(this).val();
            }).get();
            if (activateValue.length == 0) {
                $('#alertForNoneSelected').modal('show');
            } else
            {
                $('#activatefranchise').modal('show');
            }
            $("#yesaccept").click(function () {

                $.each(activateValue, function (i, val) {
                    $("#" + val).remove();
                });
//                    return  false;    
                $.ajax({
                    url: '<?php echo base_url() ?>index.php?/Student/statusStudent/1',
                    type: 'post',
                    data: 'ids=' + activateValue
                }).done(function (data) {
                    getFranchise();
                    $(".close").trigger('click');
                    $("#respose").html(data);
                    $('#campaigns-datatable').DataTable().ajax.reload();
                    $('#selecctall').attr('checked', false);
                });
            });

        });
        function  resetcheckbox() {
            $('input:checkbox').each(function () { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });
        }
    });
</script>
<!------------------------------------------ for edit the student---------------------------------------------->
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

    function citiesList() {
        $.ajax({
            url: "<?php echo APILink ?>" + "admin/city",
            type: 'GET',
            dataType: 'json',
            headers: {
                  language: 0
                },
            data: {
            },
        }).done(function (json) {

            console.log(json);

            $("#citiesList").html('<option value=""  selected>All</option>');

            for (var i = 0; i < json.data.length; i++) {

                var citiesList = "<option value=" + json.data[i].id + " currency=" + json.data[i].currencySymbol + ">" + json.data[i].cityName + "</option>";
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

            <strong style="color:#0090d9;">REFERRAL CAMPAIGN</strong><!-- id="define_page"-->
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
            <li id= "my1" class="tabs_active <?php echo $active ?>" style="cursor:pointer">
                <a  class="changeMode New_" data="<?php echo base_url("/index.php?/ReferralController/referralCampaignsByStatus/2/") ?>" data-id="1">
                    <span>ACTIVE</span>
                    <span class="badge newStudentCount" style="background-color: #337ab7;"></span>
                </a>
            </li>
            <li id= "my2" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode New_" data="<?php echo base_url("/index.php?/ReferralController/referralCampaignsByStatus/3/") ?>" data-id="1">
                    <span>INACTIVE</span>
                    <span class="badge newStudentCount" style="background-color: #337ab7;"></span>
                </a>
            </li>
            <li id= "my3" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode New_" data="<?php echo base_url("/index.php?/ReferralController/referralCampaignsByStatus/4/") ?>" data-id="1">
                    <span>EXPIRED</span>
                    <span class="badge newStudentCount" style="background-color: #337ab7;"></span>
                </a>
            </li>


            <div class="pull-right m-t-10 new_button cls111" id="deleteTab">
                <a href="#">
                    <button class="btn btn-danger btn-cons" id="del_all">
                        DELETE
                    </button>
                </a>
            </div>
            <div class="pull-right m-t-10 new_button cls111" id="deactivateTab">
                <a href="#">
                    <button class="btn btn-warning btn-cons" id="deactivate">
                        DEACTIVE
                    </button>
                </a>
            </div>
            <div class="pull-right m-t-10 new_button cls110" id="addTab">
                <a href="<?php echo base_url() ?>index.php?/ReferralController/addNewReferralCampaign"> 
                    <button class="btn btn-success btn-cons" id="add">
                        CREATE
                    </button>
                </a>
            </div>
            <div class="pull-right m-t-10 new_button cls111" id="activeTab">
                <a href="#"> 
                    <button class="btn btn-success btn-cons" id="adactive">
                        ACTIVATE
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

                            <!--changes-->
                            <div class="panel panel-transparent">

                                <div class="col-sm-6 form-group">

                                    <div class="col-sm-8">
                                        <select id="citiesList" name="company_select" class="form-control" style="width: 40% !important;border-radius: 20px;">
                                            <!-- <option disabled selected value> None Selected</option> -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 form-group">

                                    <div class="col-sm-5 row input-daterange input-group" style="float: left;display:none">
                                        <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">
                                    </div>
                                    <div class="col-sm-1 " style="margin-left: 10px;display:none">
                                        <button class="btn btn-primary" style="width: 60px !important;border-radius: 35%;" type="button" id="searchData">Search</button>
                                    </div>

                                    <div class="col-sm-5 row pull-right">
                                        <div class="pull-right"><input type="text" id="search-tables" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>" style="
                                                                       border-radius: 19px;
                                                                       "> </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <?php
                                    echo $this->table->generate();
                                    ?>
                                </div>

                            </div>
                            <!--changes end-->
                            <!-- END PANEL -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade stick-up" id="deletefranchise" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"><?php echo $this->lang->line("delete"); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorbox" style="text-align:center"><?php echo $this->lang->line("confirm"); ?></div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <div class="col-sm-4" ></div>
                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-danger pull-right" id="yesdelete" >Delete</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="bannedfranchise" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"><?php echo $this->lang->line("ban"); ?></span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorbox" style="text-align:center"><?php echo $this->lang->line("banconfirm"); ?></div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <div class="col-sm-4" ></div>
                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                    <div class="pull-right m-t-10"> 
                        <button type="button" class="btn btn-info pull-right" id="yesbanned" ><?php echo $this->lang->line("ban"); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>   
<div class="modal fade stick-up" id="activatefranchise" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Activate</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box" id="errorbox" style="text-align:center"><?php echo $this->lang->line("activateconfirm"); ?></div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <div class="col-sm-4" ></div>
                <div class="col-sm-8">
                    <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button>
                    <div class="pull-right m-t-10"> <button type="button" class="btn btn-success pull-right" id="yesaccept" >Activate</button></div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--show schedule -->
<div class="modal fade" id="showScheduleModel" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;text-transform: capitalize;"><span id="scheduleHeading"></span></strong>
            </div>
            <div class="modal-body">
                <!-- data is comming from js which is written at top-->
                <table class="table table-bordered schedulepopup">
                    <thead>
                        <tr>
                            <th style="width:10%;text-align: center;">S.no</th>
                            <th style="width:15%;text-align: center;">Vehicle Name</th>
                            <th style="width:20%;text-align: center;">Driver Name</th>
                            <th style="width:20%;text-align: center;">ScheduleId.</th>
                            <th style="width:40%;text-align: center;">StopName</th>  
                            <th style="width:40%;text-align: center;">RouteName</th>  
                        </tr>
                    </thead>
                    <tbody id="scheduledoc_body">
                    </tbody>
                </table>
                <center><h6 style="font-weight:900;color:red">Schedule Days</h6></center>
                <table class="table table-bordered" id="timetable">
                    <thead>
                        <tr>
                            <th style="width:10%;text-align: center;">S.no</th>
                            <th style="width:15%;text-align: center;">Days</th>
                            <th style="width:20%;text-align: center;">Start Time</th>
                            <th style="width:20%;text-align: center;">End Time</th> 
                        </tr>
                    </thead>
                    <tbody id="scheduleTime_body">
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
<div class="modal fade" id="showDiscountDetailsModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;text-transform: capitalize;"><span id="discountDetailsText">DISCOUNT DETAILS</span></strong>
            </div>
            <div class="modal-body">
                <!-- data is comming from js which is written at top-->
                <span style="padding-bottom: 10px; display: inline-block;">NEW USER DISCOUNT</span>
                <table class="table table-bordered schedulepopup">
                    <thead>
                        <tr>
                            <th style="width:10%;text-align: center; color: darkturquoise;">REWARD TYPE</th>
                            <th style="width:15%;text-align: center; color: darkturquoise;">DISCOUNT TYPE</th>
                            <th style="width:20%;text-align: center; color: darkturquoise;">AMOUNT / PERCENTAGE</th>

                        </tr>
                    </thead>
                    <tbody class="newUserDiscountModalData">
                    </tbody>
                </table>
                <span style="padding-bottom: 10px; display: inline-block;">REFERRER DISCOUNT</span>

                <table class="table table-bordered schedulepopup">
                    <thead>
                        <tr>
                            <th style="width:10%;text-align: center; color: darkturquoise;">REWARD TYPE</th>
                            <th style="width:15%;text-align: center; color: darkturquoise;">DISCOUNT TYPE</th>
                            <th style="width:20%;text-align: center; color: darkturquoise;">AMOUNT / PERCENTAGE</th>

                        </tr>
                    </thead>
                    <tbody class="referrerDiscountModalData">
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

