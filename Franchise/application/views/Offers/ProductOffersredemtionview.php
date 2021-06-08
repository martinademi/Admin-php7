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
.panel-body {
    padding: 0%;
}

.breadcrumb {
    padding: 1%;
    margin-bottom: 5px;
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
                    url: '<?php echo APILink ?>schedule/' + scheduleId +'/'+ businessId,
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
        console.log("first time");
        $(".student-menu").addClass('active');
        // getAcceptedDataTables();
        $('#activateTab').hide();
        $('#activate').hide();
        $('#assignTab').hide();
        $('.changeMode').click(function () {
            $('#campaigns-datatable').DataTable({
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
            });
        });

        $(".cityDetails").live('click', function(){
            var cityIds = $(this).attr("city_ids");
            $.ajax({
            url: "<?php echo APILink; ?>/admin/cityDetailsByCityIds/" + cityIds,
            type: 'GET',
            dataType: 'json',
            headers: {
                  language: 0
                },
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
                    url : "<?php echo base_url('index.php?/productOffers/getclaimDetails/'. $campaignId .'/');?>",
                    type : 'POST',
                    
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

    });   
    
      
</script>
<script>
    //  function getAcceptedDataTables(){
         
    

        // $("#citiesList").change(function(){
        //     table.fnFilter($('#search-table').val());
        // });
            
        // }
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
        
        // citiesList();


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

    //   function citiesList(){
    //     $.ajax({
    //             url: "<?php echo APILink ?>" + "admin/city",
    //             type: 'GET',
    //             dataType: 'json',
    //             headers: {
    //               language: 0
    //             },
    //             data: {                  
    //             },
    //         }).done(function(json) {

    //             console.log(json);
                
    //             $("#citiesList").html('<option value="" selected>Select City</option>');
                
    //              for (var i = 0; i< json.data.length; i++) {
                
    //                 var citiesList = "<option value="+ json.data[i].id + " currency="+ json.data[i].currency + ">"+  json.data[i].cityName +"</option>";
    //                 $("#citiesList").append(citiesList);  
    //             }
              
    //     });
    //  }
</script>


<style>
    .exportOptions{
        display: none;
    }
</style>

<!----------------------------------------view page start-------------------------------------------------------->
<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="brand inline" style="  width: auto;">
        <?php echo $this->lang->line('heading_redemption'); ?>
        </div>
         <input type="hidden" id="businessId" value="<?php echo $this->session->userdata('userId');?>" >
        
        <div class="content container-fluid">
       <!-- Nav tabs -->
           

            <!-- <strong style="color:#0090d9;">Redemption list</strong> -->
            <ul class="breadcrumb">
           
            <li class="breadClass">
            <a href="<?php echo base_url(); ?>index.php?/productOffers" class=""> Product Offers</a> >
            <a href="" style="color: #0090d9 !important; font-size: 11px !important"><?php echo $campaignname;?> </a> <a href="" style="color: #0090d9 !important; font-size: 11px !important">Redemption </a>    
            </ul>
        </div>
             
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
                                    <div class="col-sm-4 form-group">
                                                <!-- <label for="fname" class="col-sm-1 control-label aligntext" style="padding-left:0%; margin-top: 2%;">CITIES <span ></span></label> 
                                                <div class="col-sm-6">
                                                    <select id="citiesList" name="company_select" class="form-control" style="padding: 1%; margin-top: 1%;">
                                                    <option disabled selected value> None Selected</option>
                                                    </select>
                                                </div> -->
                                    </div>
                                    <div class="col-sm-8 form-group">
                                          
                                    <div class="col-sm-5 row input-daterange input-group" style="float: left">
												<input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
												<span class="input-group-addon">to</span>
												<input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">
                                            </div>
                                            <div class="col-sm-1 " style="margin-left: 10px;">
                                             <button class="btn btn-primary"  type="button" id="searchData"><?php echo $this->lang->line('button_search'); ?></button>
                                            </div>
                                           
                                            <div class="col-sm-5 row pull-right">
                                                <div class="pull-right"><input type="text" id="search-tables" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                            </div>
                                     </div>
                                   
									
										
									<div class="panel-body">
										<?php
										echo $this->table->generate();
										?>
									</div>

                            </div>
                            <!-- END PANEL -->
                                <!-- END PANEL -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

