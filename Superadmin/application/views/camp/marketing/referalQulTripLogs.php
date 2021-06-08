<?php
date_default_timezone_set('UTC');
$rupee = "$";
//error_reporting(0);
$active="active";


?>
<style>
    .badge {
    font-size: 9px;
    margin-left: 2px;
}
.nav-md .container.body .right_col {
    padding: 2% 2% 0 3% !important;
    margin-left: 230px !important;
}
</style>
<script>
$(function(){
        /* student details show on click */
        $(document).on('click','.showSchedule',function ()
        {
            $('#scheduledoc_body').empty();  
            $('#scheduleTime_body').empty();  
            var businessId = $("#businessId").val();
            var scheduleId = $(this).attr('scheduleId');
            var stopName = $(this).attr('stopName');
            $("#scheduleHeading").text($(this).attr('scheduleType')+' Schedule')
            if(scheduleId)
            {
            $.ajax({
                    url: '<?php echo APILINKPROMO ?>schedule/' + scheduleId +'/'+ businessId,
                    type: 'GET'
                  }).done(function(data) {
                       $('#scheduledoc_body').empty();        
                            var sno=1;
                            var html = "<tr style='text-transform: capitalize;'><td style='text-align: center;'>"+sno+"</td><td style='text-align: center;'>";
                            html +="<span>" +data.data[0].vehicleDetails.vehicleName+"</span></td><td style='text-align: center;'>"+data.data[0].driverDetails.driverFirstName+ ' ' +data.data[0].driverDetails.driverLastName+"</td><td style='text-align: center;'>"+data.data[0].scheduleId+"</td><td style='text-align: center;'>"+stopName+"</td>";
                            html += "<td style='text-align: center;'>"+ data.data[0].routeDetails.routeName+ "</td>";
                            html += "</tr>";
                            sno = sno+1;
                            $("#scheduledoc_body").append(html);
                    
                            $('#scheduleTime_body').empty();        
                            var snos=1;
                            $.each(data.data[0].days, function() {
                                var html = "<tr style='text-transform: capitalize;'><td style='text-align: center;'>"+snos+"</td><td style='text-align: center;'><a style='font-weight:600' vehicleid="+this._id+">";
                                html +='' +this.Day+"</a></td><td style='text-align: center;'>"+this.startTime+"</td>";
                                html += "<td style='text-align: center;'>"+this.endTime+"</td>";
                                html += "</tr>";
                                snos = snos+1;
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
    $(document).ready(function() {
        $(".student-menu").addClass('active');
        getAcceptedDataTables();
        $('#activateTab').hide();
        $('#activate').hide();
        $('#assignTab').hide();
        // $('.changeMode').click(function () {
        //     $('#campaigns-datatable').DataTable({
        //         "pageLength" : 10,
        //         "sPaginationType" : "full_numbers",
        //         "aaSorting": [],
        //         "bDestroy" : true,
        //         "bScrollCollapse" : true,
        //         "destroy": true,
        //         "scrollCollapse": true,
        //         "iDisplayLength": 20,
        //         "ajax": {
        //             url : $(this).attr('data'),
        //             type : 'POST'
        //         },
        //     });
        // });

    });     
</script>
<script>
     function getAcceptedDataTables(){
        var campaignId = "<?php echo $campaignId; ?>";
        console.log(campaignId);
         /*   $('#campaigns-datatable').DataTable({
                 "pageLength" : 10,
                 "sPaginationType" : "full_numbers",
                 "aaSorting": [],
                 "bDestroy" : true,
                 "fnInitComplete": function() {
                  $("#gif").fadeOut(1000);
                 },
                 "bScrollCollapse" : true,
                 "bSort" : true,
                 "ajax": {
                    url : "<?php //echo base_url('index.php?/ReferralController/referralQualifiedTripLog/');?>"+ campaignId +"/0/10",  //1 MEANS NEW
                    type : 'POST'
                },
            });*/
            var table = $('#campaigns-datatable');
            var settings = {
                
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "serverSide": true,
                "ajax": {
                    url : "<?php echo base_url('index.php?/ReferralController/referralQualifiedTripLog/');?>"+ campaignId +"/",  //1 MEANS NEW
                    type : 'POST',
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
        }
     function getFranchise(){
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
            url: "<?php echo APILINKPROMO ?>" +"admin/cityDetailsByCityIds/" + cityIds,
            type: 'GET',
            dataType: 'json',
            data: { },
        })
        .done(function(json) {
            if (json.data.length > 0 ) {
                $("#showCityDetailsModal").modal();
                $("#cityDetailsBody").empty();
                for (var i = 0; i< json.data.length; i++) {
                    var cityDetailsData = '<tr>'+
                                    '<td style="text-align:center">' + (i+1) +'</td>' +
                                    '<td style="text-align:center">' + json.data[i].cities.cityName+ '</td>' +
                                    '<td style="text-align:center">' + json.data[i].country+ '</td>' +
                                    '<td style="text-align:center">' + json.data[i].cities.currency + '</td>' +
                                    '</tr>';
                    $("#cityDetailsBody").append(cityDetailsData);  
                }



            }else{

            }
            
            
        });
});

        $(".newUserDetails").live('click', function(){
            var campaignId = $(this).attr("campaignid");
            $.ajax({
            url: "<?php echo APILINKPROMO ?>" +"referralCampaignDetailsById/" + campaignId,
            type: 'GET',
            dataType: 'json',
           
            data: { },
        })
        .done(function(json) {
            if (json.data.length > 0 ) {

                $("#discountDetailsText").text("NEW USER DISCOUNT DETAILS");
                
                $("#showDiscountDetailsModal").modal();

                $("#discountDetailsBody").empty();

                     var newUserDiscountData = '<tr>'+
                                    '<td style="text-align:center">' + json.data[0].newUserDiscount.rewardTypeName+ '</td>' +
                                    '<td style="text-align:center">' + json.data[0].newUserDiscount.discountTypeName+ '</td>' +
                                    '<td style="text-align:center">' + json.data[0].newUserDiscount.discountAmt + '</td>' +
                                    '</tr>';
                    $("#discountDetailsBody").append(newUserDiscountData); 
            }else{

            }
            
            
        });
});

        $(".referrerDiscount").live('click', function(){
            var campaignId = $(this).attr("campaignid");
            $.ajax({
            url: "<?php echo APILINKPROMO ?>" +"referralCampaignDetailsById/" + campaignId,
            type: 'GET',
            dataType: 'json',
            
            data: { },
        })
        .done(function(json) {
            if (json.data.length > 0 ) {

                $("#discountDetailsText").text("REFERRER DISCOUNT DETAILS");
                
                $("#showDiscountDetailsModal").modal();

                $("#discountDetailsBody").empty();


                     var newUserDiscountData = '<tr>'+
                                    '<td style="text-align:center">' + json.data[0].referrerDiscount.rewardTypeName+ '</td>' +
                                    '<td style="text-align:center">' + json.data[0].referrerDiscount.discountTypeName+ '</td>' +
                                    '<td style="text-align:center">' + json.data[0].referrerDiscount.discountAmt + '</td>' +
                                    '</tr>';
                    $("#discountDetailsBody").append(newUserDiscountData); 
            }else{

            }
            
            
        });
});







        var status = 1;
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
                if( status == 1 ){
                     $('#big_table').dataTable().fnSetColumnVis([0], false);
                }   
                else
                    $('#big_table').dataTable().fnSetColumnVis([0], false);
        });
        $('.changeMode').click(function () {
            var tab_id = $(this).attr('data-id');
            currentTabs = tab_id;
            $('#display-data').text('');
              if(currentTab != tab_id)
              {
                currentTab = tab_id;
                $('#big_table').hide();
                if(tab_id == 1)
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
                if(tab_id == 2)
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
                if(tab_id == 3)
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
                if(tab_id == 4)
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
                if(tab_id == 5)
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
                    if( status == 1 ){
                         $('#big_table').dataTable().fnSetColumnVis([], false);
                    }   
                    else
                        $('#big_table').dataTable().fnSetColumnVis([], false);
                });
            }
        });
    });
</script>




<!--------------------------------------- for activate the studen---------------------------------------------->
        <script>
            $(document).ready(function() {
                resetcheckbox();
                $("#activate").on('click', function(e) {
                    e.preventDefault();
                     var activateValue = [];
                     activateValue = $('.checkbox1:checked').map(function()
                    {
                        return $(this).val();
                    }).get();
                    if (activateValue.length == 0) {
                         $('#alertForNoneSelected').modal('show');
                      }
                    else
                    {
                      $('#activatefranchise').modal('show');    
                    }
                    $("#yesaccept").click(function () {
                                        
                    $.each( activateValue, function( i, val ) {
                        $("#"+val).remove();
                        });
//                    return  false;    
                    $.ajax({
                        url: '<?php echo base_url() ?>index.php?/Student/statusStudent/1',
                        type: 'post',
                        data: 'ids=' + activateValue
                    }).done(function(data) {
                        getFranchise();
                        $(".close").trigger('click');
                        $("#respose").html(data);
                        $('#campaigns-datatable').DataTable().ajax.reload();
                        $('#selecctall').attr('checked', false);
                    });
                });
                                
                });
                function  resetcheckbox(){
                $('input:checkbox').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                   });
                }
            });
        </script>
<!------------------------------------------ for edit the student---------------------------------------------->
        <script>
            function edit()
            {
                var checkValues = $('.checkbox1:checked').map(function()
                {
                    return $(this).val();
                }).get();
                console.log(checkValues);
                 if (checkValues.length == 0) {
                    $('#alertForNoneSelected').modal('show');
                }
                else if(checkValues.length >1)
                {
                    $('#alertForSelected').modal('show');
                }
                else
                {
             window.location.href = "<?php echo base_url('index.php?/Student/editstudent');?>?ids="+checkValues;
                }
            }
        </script>
<!------------------------------------------ for assign route to the student---------------------------------------------->
        <script>
            function assign()
            {
                var checkValues = $('.checkbox1:checked').map(function()
                {
                    return $(this).val();
                }).get();
                 if (checkValues.length == 0) {
                    $('#alertForNoneSelected').modal('show');
                }
                else if(checkValues.length >1)
                {
                    $('#alertForSelected').modal('show');
                }
                else
                {
                  if(currentTabs == 3)
                      {
                          window.location.href = "<?php echo base_url('index.php?/Student/reassignstudent');?>?ids="+checkValues;
                      }
                    else 
                      {
                          window.location.href = "<?php echo base_url('index.php?/Student/assignstudent');?>?ids="+checkValues;
                      }
                }
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
         <input type="hidden" id="businessId" value="<?php echo $this->session->userdata('userId');?>" >
        <div class="content">
        <div class="brand inline" style="  width: auto;color: gray;margin-left: 30px;padding-top: 20px;">
                <strong style="color:#0090d9;"><?php echo $this->lang->line('student');?></strong>
        </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">
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
                                    <div class="panel-heading">
                                    <!--<span style="font-size: 15px !important; COLOR: darkcyan; border-bottom: 2px solid; padding-bottom: 5px;">REFERRAL CAMPAIGN QUALIFIED LOGS :-</span>-->
                                         <ul class="breadcrumb">
                                        <li><a href="<?php echo base_url('index.php?/referralController/index/1');?>" style="color: dodgerblue !important;">REFERAL CAMPAIGNS</a></li>
                                                  <li><a href="" style="color: dodgerblue !important;">REFERRAL CAMPAIGN QUALIFIED LOGS</a></li>
                                         </ul>
                                        <div class="hide_show" style="display:none;"></div>
                                        <div class="row clearfix pull-right" >
                                            <div class="col-sm-12">
                                                <!-- <div class="searchbtn" >
                                                    <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo strtoupper($this->lang->line('search')); ?> "> </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>&nbsp;
                                    <div class="panel-body">
                                    <div class="panel-heading">
										<div class="row">
											<div class="pull-right"><input type="text" id="campaign_table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
										</div>
									</div>
										
									<div class="panel-body">
										<?php
										echo $this->table->generate();
										?>
									</div>
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
                <strong style="color:#0090d9;text-transform: capitalize;"><span id="discountDetailsText"></span></strong>
            </div>
            <div class="modal-body">
                 <!-- data is comming from js which is written at top-->
            <table class="table table-bordered schedulepopup">
                <thead>
                  <tr>
                    <th style="width:10%;text-align: center; color: darkturquoise;">REWARD TYPE</th>
                    <th style="width:15%;text-align: center; color: darkturquoise;">DISCOUNT TYPE</th>
                    <th style="width:20%;text-align: center; color: darkturquoise;">AMOUNT / PERCENTAGE</th>
                    
                  </tr>
                </thead>
               <tbody id="discountDetailsBody">
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

