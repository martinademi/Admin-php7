<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<style>
    .badge {
        font-size: 9px;
        margin-left: 2px;
    }
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    .imageborder{
        border-radius: 50%;
    }
    .btn{
        border-radius: 25px !important;
        width: 115px !important;
    }

    .panel-body {
        padding-top: 27px !important;
    }

    #modalBodyText{
        font-size: 14px !important;
    }


    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}

    /* multiselect */

    .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
    position: absolute;
    margin-left: -21px;
    }

    button.multiselect.dropdown-toggle.btn.btn-default {
    border-radius: 2px !important;
    }

    button.btn.btn-default.multiselect-clear-filter {
    display: none;
    }
    button.multiselect.dropdown-toggle.btn.btn-default {
        width: 100% !important;
    }

    /* select wit serch */
    .custom_select_btn button {
        border-radius: 0px !important;
    }
    .dropdown-menu.inner.selectpicker {
        max-height: 175px !important;
    }

    button.btn.dropdown-toggle.selectpicker.btn-default {
        width: 180px !important;
        height: 33px !important;
    }

    .input-block-level{
        min-width: 161px !important;
    }
</style>


<script type="text/javascript">

var cityId;
var zoneId;
var shiftTimimgs;
var startDate;
var endDate;
	
	
   

    $(document).ready(function () {	
		var status = '<?php echo $status; ?>';
        $('#big_table_processing').show();
        $('.cs-loader').show();
        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/DriverRoasterAdd/datatableOrders/9',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
                $('#big_table_processing').hide();
                $('.cs-loader').hide();
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
        };
        table.dataTable(settings);
        // search box for table


        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });
		
	
		
    });
	
	

// filter of data
$(document).ready(function (){

    // select all
    $("body").on('click','#select_all',function(){ 
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });

 // start date 
    var date = new Date();
        $('.datepicker-component').datepicker({
            startDate: date,
            format: 'dd-mm-yyyy'
        });

        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });

// to get cities
    $.ajax({
                url: "<?php echo base_url(); ?>index.php?/Orders/getCities",
                type: "POST",
                data: {},
                dataType: "JSON",
                
                success: function (result) {
                     $('#cityFilter').empty();                   
                    if(result.data){                         
                   var html5 = '';
				   var html5 = '<option cityName="" value="" >Select city</option>';
                        $.each(result.data, function (index, row) {
                               html5 += '<option value="'+row.cityId.$oid+'" cityName="'+row.cityName+'">'+row.cityName+'</option>';                             
                          });
                    $('#cityFilter').append(html5);    

                    }

                     
                }
            });

// category  to get sub cat and for filter

        $('#cityFilter').change(function(){                
            // hide shift button initially
            $('#addShift').show();
            cityId=$(this).val();              
            //filterData(cityId);          
            $('#zoneFilter').load("<?php echo base_url('index.php?/DriverRoasterAdd') ?>/getZone", {cityId: cityId});                       
        
        });


        // filter for zone
        $('#zoneFilter').change(function(){           
            zoneId=$(this).val();
            filterData(cityId,zoneId);     
            $('#shiftTimings').load("<?php echo base_url('index.php?/DriverRoasterAdd') ?>/getshiftTimings", {zoneId: zoneId});  
            $('#shiftName').load("<?php echo base_url('index.php?/DriverRoasterAdd') ?>/getshiftTimings", {zoneId: zoneId});  

            
            
        });

          // filter for zone
          $('#shiftTimings').change(function(){           
            shiftTimimgs=$(this).val();          
            //filterData(cityId,zoneId,shiftTimimgs);                      
        });

        // $('#shiftName').change(function(){           
        //     shiftTimimgs=$(this).val();       
        //     console.log("shiftName",shiftTimimgs);
            
        // });



        
        // function for filter
        function filterData(cityId='',zoneId='',shiftTimimgs=''){
          
            $('#big_table_processing').show();
            $('.cs-loader').show();
            var table = $('#big_table');
            $('#big_table').fadeOut('slow');

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/DriverRoasterAdd/datatableOrders/0',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    $('#big_table').fadeIn('slow');
                    $('#big_table_processing').hide();
                    $('.cs-loader').hide();
                },
                'fnServerData': function (sSource, aoData, fnCallback)
                {

                   

                    if(cityId !='' && zoneId =='' && shiftTimimgs == '' ){
                        aoData.push({ name: 'cityId',value:cityId});                     
                    }
                    else if(cityId !='' && zoneId !='' && shiftTimimgs == '' ){
                        aoData.push({ name: 'cityId',value:cityId});
                        aoData.push({ name: 'zoneId',value:zoneId});
                    }else if(cityId !='' && zoneId !='' && shiftTimimgs != ''){
                        aoData.push({ name: 'cityId',value:cityId});
                        aoData.push({ name: 'zoneId',value:zoneId});
                        aoData.push({ name: 'shiftTimimgs',value:shiftTimimgs})
                    }


                    
                
                $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback
                            });
                },
                "columnDefs": [
                        {  targets: "_all",
                            orderable: false 
                        }
                ],
                
            };
            table.dataTable(settings);
            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });



        }

        // Onclick of Add shift for modal
        $("#addShift").click(function () {

        startDate=$('#start').val();
        endDate=$('#end').val();   

        var val=[];
        $(':checkbox:checked').each(function(i){
            val[i]=$(this).val();
        });

        if(val.length==0){
            var modalText = 'Please select at least one Driver';            
            $('#modalBodyText').text(modalText);
            $('#addShiftModal').modal('show');              
            $('#addShiftConfirm').hide();              
            $('#addShiftConfirmOk').show();  
            $('#shiftModal').hide();           
        }else{
            var modalText = 'Are you sure you want to add driver to selected Shift.?';    
            //$('#shiftModal').show();         
            $('#modalBodyText').text(modalText);           
            $('#addShiftModal').modal('show');    
            $('#addShiftConfirm').show();   
            $('#addShiftConfirmOk').hide();  
        }

                  
        });

        // confirmshift timings
        $("#addShiftConfirm").click(function () {
            var val = [];
            // $(':checkbox:checked').each(function(i){
            //   val[i] = $(this).val();
            // });

            $('.checkbox:checked').each(function (i) {
                val[i] = $(this).val();
            });                       
            
            if(startDate=="" ||  endDate==""){
                alert("Please select Date");                
            }if(shiftTimimgs == undefined){
                alert('Please select shift')
            }else{
                    $.ajax({                    
                        url: "<?php echo base_url('index.php?/DriverRoasterAdd/updateShiftTimimgs');?>",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            cityId:cityId,
                            zoneId :zoneId,
                            shiftTimimgs:shiftTimimgs,
                            driverId:val,
                            startDate:startDate,
                            endDate:endDate

                        },
                })
                .done(function(json) {
                    
                    if (json.flag === 1) {
                        $('#addShiftModal').modal('hide');    
                        $('.checkbox').each(function(){
                            this.checked = false;
                        });

                    }else{
                        $('#addShiftModal').modal('hide');
                        

                    }
                });

            }

           


        });

      //  citiesList();

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
                
                $("#citiesList").html('');
                
                 for (var i = 0; i< json.data.length; i++) {
                
                    var citiesList = "<option value="+ json.data[i].id + ">"+  json.data[i].cityName +"</option>";
                    $("#citiesList").append(citiesList);  
                }

                $('#citiesList').multiselect({
                    includeSelectAllOption: false,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering : true,
                    maxHeight: 400,
                    buttonWidth: '200px'

                  
                    

                });
        });
     }


     $("#citiesList").change(function() {            
                console.log('citiel',$(this).val());               
            if ($("#citiesList option:selected").length > 1) {
                var id=$(this).val();
                $("#citiesList option:selected").prop("selected", false);
                $('#citiesList').multiselect('refresh');               
                // console.log(id[1])
                //$('#citiesList').multiselect('select', id[1]);

                
           
            }
        });




});
</script>

<link
    href="<?php echo base_url(); ?>theme/intl-tel-input-master/build/css/intlTelInput.css"
    rel="stylesheet" type="text/css" />

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper"style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content" >

        <div class="brand inline" style="  width: auto;            
             color: gray;
             margin-left: 30px;padding-top: 20px;">
       

            <strong style="color:#0090d9;">ADD DRIVER ROSTERS</strong><!-- id="define_page"-->
        </div>
        <div id="test"></div>
        <!-- Nav tabs -->

        <div class="">
            <ul class="breadcrumb" style="background:white;margin-top: 0%;">
                <li><a class="active" href="<?php echo base_url() ?>index.php?/DriverRoaster" class="">Driver Roaster</a> </li>
                <li><a class="active" href="#" class="">Add</a> </li>
            </ul>
        </div>

        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">

      

            <!-- new tab -->
          <!-- new tab end -->
       
        </ul>
        <!-- Tab panes -->
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">

                <div class="pull-left col-sm-6" >

                    


                </div>

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">

                                    <div class="cs-loader">
                                        <div class="cs-loader-inner" >
                                            <label class="loaderPoint" style="color:#10cfbd">●</label>
                                            <label class="loaderPoint" style="color:red">●</label>
                                            <label class="loaderPoint" style="color:#FFD119">●</label>
                                            <label class="loaderPoint" style="color:#4d90fe">●</label>
                                            <label class="loaderPoint" style="color:palevioletred">●</label>
                                        </div>
                                    </div>
								<!-- city filter -->
									<?php $role = $this->session->userdata("role");
									if($role!="ArialPartner"){?>
									<!-- <div class="row clearfix pull-left" style="margin-left:0px;">
                                        <div class="pull-left">
                                            <select class="form-control pull-left" id="cityFilter">
                                            </select>                                     
                                        </div>
                                    </div> -->

                                    <div class="row clearfix pull-left" style="margin-left:0px;">
                                            <div class="" style="width: 35%; paddingng: 0px; margin-bottom: 10px;margin-left: -0.7%">                                          
                                            <select class="selectpicker form-control custom_select_btn" id="cityFilter" style="background-color:gainsboro;height:30px;font-size:11px;" data-show-subtext="false" data-live-search="true">
                                                    <option value="" city="">Select City</option>
                                                    <?php
                                                    foreach ($allcities as $city) {
                                                        if($city['isDeleted'] == FALSE){
                                                        ?>
                                                        <option value="<?php echo $city['cityId']; ?>" city="<?php echo $city['cityName']; ?>" data-id="" lat="" lng=""><?php echo $city['cityName']; ?></option>    
                                                        <?php
                                                        }
                                                    }
                                                    ?>                                                                        
                                            </select>
                                            </div>
                                        </div>
										<?php } ?>

                                    <!-- zone -->
                                    <div class="row clearfix pull-left" style="margin-left:25px;">

                                        <div class="pull-left">
										<select class="form-control pull-left" id="zoneFilter">
                                            <option selected="selected" value="">Select Zone</option>
									
										</select> 
										</div>
                                    </div>

									
									<!-- start date and end date -->
									<div class="col-sm-2 hide_show" style="margin-left: 30px">
										<div class="" aria-required="true">

											<div class="input-daterange input-group">
												<input type="text" style="width:90px;" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
												<span class="input-group-addon">to</span>
												<input style="width:90px;"type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">

											</div>
										</div>
									</div>
                                    
                                     <!-- Shift timings -->
                                     <div class="col-sm-2" style="margin-left:35px;">

                                        <div class="">
                                        <select class="form-control pull-left" id="shiftTimings">
                                            <option selected="selected" value="">Select Shifts</option>

                                        

                                        </select> 
                                        </div>
                                     </div>									

                                    <div class="col-sm-1 hide_show pull-right" >
										<button class="btn btn-info" style="width: 70px !important;display:none" type="button" id="addShift">Add</button>
									</div>


                                </div>
                                &nbsp;
                                <div class="panel-body">
                                    <?php echo $this->table->generate(); ?>

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

<div class="modal fade stick-up" id="actionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <span class="modal-title">Action</span>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdata" style="font-size: large;text-align:center">What would you like to do with the order ?</div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-3">
                    <input type="hidden" id="orderId" value="">
					 <button type="button" class="btn btn-warning pull-right" id="btnReject" value="3" >Reject</button>
					</div>
                    <div class="col-sm-3" >
                        <button type="button" class="btn btn-success pull-right" id="btnAccept" value="4" >Accept</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade stick-up" id="detailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <span class="modal-title">Breakdown Details</span>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">
				<div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Net Price</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" id="netPrice" class="headinClass"></a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>

                    <div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#"  class="headinClass">Delivery Fee</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" id="deliveryFee" class="headinClass"></a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Discount<br/><?php echo "<span id='discountTag'></span> - Applied";?></a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass"><br/><?php echo "( - ) <span id='discount'></span>";?></a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Taxes
														
														</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" id="tax" class="headinClass"></a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Last Due</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" id="lastDue" class="headinClass">0</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<hr/>
											<div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Grand Total</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="no-margin">
                                                        <a href="#" id="grandTotal" class="headinClass"></a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<hr/>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-8" ></div>
					 <div class="col-sm-4" >
					   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					 </div>
                    
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Modal -->
<div id="addShiftModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:450px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Alert</h4>
      </div>
      <div class="modal-body" >
        
        <!-- <div  id="shiftModal" style="display:none">
        <form action="" method="post"  data-parsley-validate="" class="form-horizontal form-label-left">
                <div class="form-group" id="notesId">
                    <label for="fname" class="col-sm-4 control-label">Shift Name</label>
                    <div class="col-md-6 col-sm-5 col-xs-12">
                        <select class="form-control pull-left" id="shiftName">
                            <option selected="selected" value="">Select Shifts</option>
                        </select> 
                    </div>   
                    <div class="col-sm-3 error-box errors" id="shiftErr">
                    </div>                    
                </div>
        </form>
        </div> -->

        <div class="" id="modalBodyText" ></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-right" id="addShiftConfirm" style="margin:0;display:none">Yes</button>
        <button type="button" class="btn btn-primary pull-right" id="addShiftConfirmOk" data-dismiss="modal" style="margin:0;display:none">Ok</button>

      </div>
    </div>

  </div>
</div>

