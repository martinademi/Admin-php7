
<script>
    var filterCityId;
    var filterStoreId;
    var paymentMethod = <?php echo json_encode(unserialize(paymentMethod)); ?>;
    var currency = '<?php echo $appConfig['currencySymbol']; ?> ';
    $(document).ready(function () {
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
			
			$.ajax({
                url: "<?php echo base_url(); ?>index.php?/Orders/getStores",
                type: "POST",
                data: {},
                dataType: "JSON",
                
                success: function (result) {
                     $('#storeFilter').empty();
                   
                    if(result.data){
                         
                          var html15 = '';
				   var html15 = '<option storeName="" value="" >Select Store</option>';
                          $.each(result.data, function (index, row) {
                              console.log('row--',row.name[0]);
                              
                               html15 += '<option value="'+row._id.$oid+'" storeName="'+row.name[0]+'">'+row.name[0]+'</option>';

                             
                          });
                            $('#storeFilter').append(html15);    
                    }

                     
                }
            });

		$(document).on('click', '.getStoreDetails', function (){
		
			$.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getOrderDetails",
                type: "POST",
                data: {orderId: $(this).attr('orderId')},
                dataType: 'json',
                success: function (result) {
                    $('.orderID').text("OrderId : "+result.data.orderId); 
					 if (result.data.storeDetails.profileLogos.logoImage != '')
                        {
                            $('.storeLogo').attr('src', result.data.storeDetails.profileLogos.logoImage);
                            $('.storeLogo').show();
                        }
						$('.sName').text(result.data.storeName);
						$('.sType').text(result.data.storeDetails.storeTypeMsg);
						$('.sPhone').text(result.data.storeDetails.countryCode+result.data.storeDetails.ownerPhone);
						$('.sEmail').text(result.data.storeDetails.ownerEmail);

                    $('#getStoreDetails').modal('show');

                }
            });
			
		});
		$(document).on('click', '.getNetAmountDetails', function (){
			
			$.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getOrderDetails",
                type: "POST",
                data: {orderId: $(this).attr('orderId')},
                dataType: 'json',
                success: function (result) {
                   $('.orderID').text("OrderId : "+result.data.orderId); 
				   
				    if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.billingSubTotal').text(result.data.currencySymbol +" "+result.data.subTotalAmount);
					}else{
						$('.billingSubTotal').text(result.data.subTotalAmount+" "+result.data.currencySymbol);
					}
					
					if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.billingSubTotal').text(result.data.currencySymbol +" "+result.data.subTotalAmount);
					}else{
						$('.billingSubTotal').text(result.data.subTotalAmount+" "+result.data.currencySymbol);
					}
					
					if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.billingDeliveryCharge').text(result.data.currencySymbol +" "+result.data.deliveryCharge);
					}else{
						$('.billingDeliveryCharge').text(result.data.deliveryCharge+" "+result.data.currencySymbol);
					}
					
					if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.billingTaxes').text(result.data.currencySymbol +" "+result.data.accouting.taxes);
					}else{
						$('.billingTaxes').text(result.data.accouting.taxes+" "+result.data.currencySymbol);
					}
			if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.billingDiscount').text("- "+result.data.currencySymbol +" "+result.data.accouting.appDiscountValue.toFixed(2));
					}else{
						$('.billingDiscount').text("- "+result.data.accouting.appDiscountValue.toFixed(2)+" "+result.data.currencySymbol);
					}
					
					if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.billingGrandTotal').text(result.data.currencySymbol +" "+result.data.totalAmount);
					}else{
						$('.billingGrandTotal').text(result.data.totalAmount+" "+result.data.currencySymbol);
					}
				    

                    $('#getNetAmountDetails').modal('show');

                }
            });
			
		});
		$(document).on('click', '.getDiscountDetails', function (){
			
			$.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getOrderDetails",
                type: "POST",
                data: {orderId: $(this).attr('orderId')},
                dataType: 'json',
                success: function (result) {
					 $('.orderID').text("OrderId : "+result.data.orderId); 
					 $('.promoCode').text(result.data.couponCode);
                   if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.discountAmount').text(result.data.currencySymbol +" "+result.data.accouting.appDiscountValue.toFixed(2));
					}else{
					$('.discountAmount').text(result.data.accouting.appDiscountValue.toFixed(2)+" "+result.data.currencySymbol);
					}

                    $('#getDiscountDetails').modal('show');

                }
            });
			
		});
		$(document).on('click', '.getBillingDetails', function (){
			$('.deliveryCommission').text("");
			$.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getOrderDetails",
                type: "POST",
                data: {orderId: $(this).attr('orderId')},
                dataType: 'json',
                success: function (result) {
                    $('.orderID').text("OrderId : "+result.data.orderId); 
					if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.appCommission').text("  "+result.data.currencySymbol +" "+result.data.accouting.storeCommissionValue.toFixed(2));
					}else{
						$('.appCommission').text("  "+result.data.accouting.storeCommissionValue.toFixed(2)+" "+result.data.currencySymbol);
					}
					
					if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.deliveryComission').text("  "+result.data.currencySymbol +" "+result.data.accouting.driverCommissionValue.toFixed(2));
					}else{
						$('.deliveryComission').text("  "+result.data.accouting.driverCommissionValue.toFixed(2)+" "+result.data.currencySymbol);
					}
					
					
					
					if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.total').text("  "+result.data.currencySymbol +" "+result.data.accouting.appEarningValue.toFixed(2));
					}else{
						$('.total').text("  "+result.data.accouting.appEarningValue.toFixed(2)+" "+result.data.currencySymbol);
					}
					
					if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.discount').text("- "+result.data.currencySymbol +" "+result.data.accouting.appDiscountValue.toFixed(2));
					}else{
						$('.discount').text("- "+result.data.accouting.appDiscountValue.toFixed(2)+" "+result.data.currencySymbol);
				}
					
					if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.pgCommissionAccounting').text("- "+result.data.currencySymbol +" "+result.data.accouting.pgEarningValue.toFixed(2));
					}else{
						$('.pgCommissionAccounting').text("- "+result.data.accouting.pgEarningValue.toFixed(2)+" "+result.data.currencySymbol);
					}
                    $('#getBillingDetails').modal('show');

                }
            });
			
		});
		$(document).on('click', '.getPgCommDetails', function (){
			
			$.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getOrderDetails",
                type: "POST",
                data: {orderId: $(this).attr('orderId')},
                dataType: 'json',
                success: function (result) {
                    $('.orderID').text("OrderId : "+result.data.orderId); 
					$('.paymentGateway').text(result.data.accouting.pgCommName);
					if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.pgCommission').text(result.data.currencySymbol +" "+result.data.accouting.pgEarningValue.toFixed(2));
					}else{
						$('.pgCommission').text(result.data.accouting.pgEarningValue.toFixed(2)+" "+result.data.currencySymbol);
					}

                    $('#getPgCommDetails').modal('show');

                }
            });
			
		});
		$(document).on('click', '.getDriverCommDetails', function (){
			
			$.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getOrderDetails",
                type: "POST",
                data: {orderId: $(this).attr('orderId')},
                dataType: 'json',
                success: function (result) {
					 $('.orderID').text("OrderId : "+result.data.orderId); 
                   if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.driverComm').text(result.data.currencySymbol +" "+result.data.accouting.deliveryCommissionValue.toFixed(2));
					}else{
						$('.driverComm').text(result.data.accouting.deliveryCommissionValue.toFixed(2)+" "+result.data.currencySymbol);
					}
					
					 if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.driverTip').text(result.data.currencySymbol +" "+result.data.accouting.driverTip.toFixed(2));
					}else{
						$('.driverTip').text(result.data.accouting.driverTip.toFixed(2)+" "+result.data.currencySymbol);
					}
					 if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.driverTotal').text(result.data.currencySymbol +" "+result.data.accouting.driverEarningValue.toFixed(2));
					}else{
						$('.driverTotal').text(result.data.accouting.driverEarningValue.toFixed(2)+" "+result.data.currencySymbol);
					}

                    $('#getDriverCommDetails').modal('show');

                }
            });
			
		});
		$(document).on('click', '.getStoreCommDetails', function (){
			
			$.ajax({
                url: "<?php echo base_url('index.php?/superadmin') ?>/getOrderDetails",
                type: "POST",
                data: {orderId: $(this).attr('orderId')},
                dataType: 'json',
                success: function (result) {
                    console.log('responese---',result);
                    $('.orderID').text("OrderId : "+result.data.orderId); 
					
					if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.storeDiscount').text("- "+result.data.currencySymbol +" "+result.data.accouting.storeDiscountValue.toFixed(2));
					}else{
						$('.storeDiscount').text("- "+result.data.accouting.storeDiscountValue.toFixed(2)+" "+result.data.currencySymbol);
			}
					
					 if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.storeTaxes').text(result.data.currencySymbol +" "+result.data.accouting.taxes.toFixed(2));
					}else{
						$('.storeTaxes').text(result.data.accouting.taxes.toFixed(2)+" "+result.data.currencySymbol);
					}
					
					 if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.storeCommission').text(result.data.currencySymbol +" "+result.data.accouting.cartCommissionValue.toFixed(2));
					}else{
						$('.storeCommission').text(result.data.accouting.cartCommissionValue.toFixed(2)+" "+result.data.currencySymbol);
					}
					
					 if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.storeEarningsTotal').text(result.data.currencySymbol +" "+result.data.accouting.storeEarningValue.toFixed(2));
					}else{
						$('.storeEarningsTotal').text(result.data.accouting.storeEarningValue.toFixed(2)+" "+result.data.currencySymbol);
					}

                     if(result.data.abbrevation == "1" || result.data.abbrevation == 1){
					$('.storeDeliveryFee').text(result.data.currencySymbol +" "+result.data.accouting.storeDeliveryFee.toFixed(2));
					}else{
						$('.storeDeliveryFee').text(result.data.accouting.storeDeliveryFee.toFixed(2)+" "+result.data.currencySymbol);
					}

                    $('#getStoreCommDetails').modal('show');

                }
            });
			
		});

        $('#clearData').click(function ()
        {
            $('#start').val('');
            $('#end').val('');
        });

        $('.exportAccData').click(function () {
            
           
            if ($('#start').val() != '' || $('#end').val() != '') {

                var dateObject = $("#start").datepicker("getDate"); 
                var st = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate(); 
                var dateObject = $("#end").datepicker("getDate"); 
                var end = dateObject.getFullYear() + '-' + (dateObject.getMonth() + 1) + '-' + dateObject.getDate();
                $('.exportAccData').attr('href', '<?php echo base_url() ?>index.php?/superadmin/exportAccData/' + st + '/' + end + '/'+ filterCityId+'/'+filterStoreId);
                $('.exportAccData')[0].click();
            } else {
                $('.exportAccData').attr('href', '<?php echo base_url() ?>index.php?/superadmin/exportAccData/'+null+'/'+null+'/'+filterCityId+'/'+filterStoreId);
                $('.exportAccData')[0].click();
            }
        });
		
		
		


        $('#searchData').click(function () {
            filterCityId=filterCityId;
            filterStoreId=filterStoreId;
            if ($("#start").val() && $("#end").val())
            {


                var st = $("#start").datepicker().val();
                var startDate = st.split("/")[2] + '-' + st.split("/")[0] + '-' + st.split("/")[1];

                var end = $("#end").datepicker().val();
                var endDate = end.split("/")[2] + '-' + end.split("/")[0] + '-' + end.split("/")[1];

                var table = $('#big_table');

                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "autoWidth": false,
                            "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": '<?php echo base_url() ?>index.php?/superadmin/transection_data_form_date/' + startDate + '/' + endDate + '/' + $('#search_by_select').val(),
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "iDisplayStart ": 20,
                    "oLanguage": {
                        "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                    },
                    "fnInitComplete": function () {
                        //oTable.fnAdjustColumnSizing();
                    },
                    'fnServerData': function (sSource, aoData, fnCallback)
                    {

                          // filter 
                        aoData.push({ name: 'city',value:filterCityId});    
	                    aoData.push({ name: 'store',value:filterStoreId});

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


            } else
            {
                $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_DRIVERS_DEACTIVAT_DATEOFBOOKING); ?>);

            }

        });


    });


</script>

<script type="text/javascript">

    $(document).ready(function () {
        $('.datepicker-component').on('changeDate', function () {
            $(this).datepicker('hide');
        });
        var date = new Date();
        $('.datepicker-component').datepicker({
        });
        $('#clearData').click(function ()
        {
            $('#start').val('');
            $('#end').val('');
        });


        $('#datepicker-component').on('changeDate', function () {

            $('.datepicker').hide();
        });


        var table = $('#big_table');
        $('.hide_show').hide();
        table.hide();
        setTimeout(function () {
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",

                "destroy": true,
                "scrollCollapse": true,

                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>index.php?/superadmin/transection_data_ajax',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
                    table.show();
                    $('.hide_show').show();
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
        }, 1000);

    $('#storeFilter').change(function(){
		
        var store=$('#storeFilter option:selected').attr('storename');
        var cityId=$('#storeFilter option:selected').val();
        var storeid=$('#storeFilter option:selected').val();
        filterStoreId=storeid;
        
        table.fnFilter(store);
        
    });
    $('#cityFilter').change(function(){
        
        var city=$('#cityFilter option:selected').attr('cityName');
        var cityId=$('#cityFilter option:selected').val();
        filterCityId=$('#cityFilter option:selected').val();			
        table.fnFilter(city);

        $('#storeFilter').load("<?php echo base_url('index.php?/Orders') ?>/getStores", {role: "ArialPartner",city:filterCityId});  
        
    });

    });
	


    // function refreshTableOnActualcitychagne() {


    //     var table = $('#big_table');
    //     var url = '';

    //     if ($('#start').val() != '' || $('#end').val() != '') {

    //         var st = $("#start").datepicker().val();
    //         var startDate = st.split("/")[2] + '-' + st.split("/")[0] + '-' + st.split("/")[1];
    //         var end = $("#end").datepicker().val();
    //         var endDate = end.split("/")[2] + '-' + end.split("/")[0] + '-' + end.split("/")[1];

    //         url = '<?php echo base_url() ?>index.php?/superadmin/Get_dataformdate_for_all_bookingspg/' + startDate + '/' + endDate + '/' + $('#Sortby').val() + '/' + $('#companyid').val();

    //     } else {
    //         url = '<?php echo base_url(); ?>index.php?/superadmin/transection_data_ajax/' + $('#Sortby').val() + '/' + $('#companyid').val();
    //     }
    //     var settings = {
    //         "autoWidth": false,
    //         "sDom": "<'table-responsive't><'row'<p i>>",

    //         "destroy": true,
    //         "scrollCollapse": true,

    //         "iDisplayLength": 20,
    //         "bProcessing": true,
    //         "bServerSide": true,
    //         "sAjaxSource": url,
    //         "bJQueryUI": true,
    //         "sPaginationType": "full_numbers",
    //         "iDisplayStart ": 20,
    //         "oLanguage": {
    //             "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
    //         },
    //         "fnInitComplete": function () {
               
    //         },
    //         'fnServerData': function (sSource, aoData, fnCallback)
    //         {
    //             $.ajax
    //                     ({
    //                         'dataType': 'json',
    //                         'type': 'POST',
    //                         'url': sSource,
    //                         'data': aoData,
    //                         'success': fnCallback
    //                     });
    //         }
    //     };
    //     table.dataTable(settings);

    // }
</script>

<style>
    .exportOptions{
        display: none;
    }
</style>
<div class="page-content-wrapper" >
    <!-- START PAGE CONTENT -->
    <div class="content">
        <div class="brand inline" style="  width: auto;">
            <strong >ACCOUNTING</strong>
        </div>
        <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">
            <div style="margin-left:1.5%;" style="display:none;" class="hide_show">
                <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                    <div class="row clearfix">

                        <div class="col-sm-2">

                           <div class="row clearfix pull-left" style="margin-left:25px;">

                                        <div class="pull-left">
										<select class="form-control pull-left" id="cityFilter">
									
										</select> 
										</div>
                                    </div>
									

                        </div>
						<div class="col-sm-2">
						<div class="row clearfix pull-left" style="margin-left:25px;">

                                        <div class="pull-left"> 
										<select class="form-control pull-left" id="storeFilter">
									
										</select> 
										</div>
                                    </div> 
									</div>

                        <div class="col-sm-3">
                            <div class="" aria-required="true">

                                <div class="input-daterange input-group">
                                    <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">

                                </div>

                            </div>

                        </div>
                        <div class="col-sm-1">
                            <div class="">
                                <button class="btn btn-primary" type="button" id="searchData">Search</button>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="">
                                <button class="btn btn-info" type="button" id="clearData">Clear</button>
                            </div>
                        </div>

                       

                        <div class="col-sm-1">	
                        <a style="color: white;" class="exportAccData" href="<?php echo base_url() ?>index.php?/superadmin/exportAccData/<?php echo $paymentCycleDetails['_id']; ?>"> <button class="btn btn-primary " style="margin-left:-10px;width: 60px !important;" type="button">Export</button></a>
                    </div>
                    
                    </div>
                </div>
            </div>
        </ul>
        <!-- START JUMBOTRON -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <!-- START PANEL -->
                <div class="panel panel-transparent">
                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12">
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
                                <div>


                                    <div class="pull-right  hide_show">
                                        <input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>

                                  



                                </div>

                            </div>
                            <div class="panel-body" style="margin-top: 1%;">
                                <div id="tableWithSearch_wrapper" class="dataTables_wrapper form-inline no-footer">
                                    <div class="table-responsive" style="overflow-x:hidden;overflow-y:hidden;">

                                        <?php echo $this->table->generate(); ?>

                                    </div><div class="row"></div></div>
                            </div>
                            <!-- END PANEL -->
                        </div>

                    </div>
                </div>


            </div>


        </div>

    </div>
</div>

<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" style="color:#337ab7;">ALERT</span>

                <button type="button" class="close" data-dismiss="modal">×</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmeds" ><?php echo BUTTON_OK; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="getBillingDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">APP EARNINGS</strong>

                <p class="pull-right orderID" style=" color: #8356a9;font-weight: 600;margin-right: 60px;"></p>
            </div>
            <div class="modal-body">

                <br>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Store Commission</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="appCommission"></span>
                    </div>

                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">PG Commission</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="pgCommissionAccounting"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Delivery Comission</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="deliveryComission"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Discount</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="discount"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>
                <div class="form-group row " style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Total </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="total"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="getAppdetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">APP EARNINGS</strong>
                <p class="pull-right orderID" style=" color: #8356a9;font-weight: 600;margin-right: 60px;"></p>
            </div>
            <div class="modal-body">

                <br>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">App Commission</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="appComm"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">PG Commission</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="appPGComm"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Discount</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="appDiscount"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">App Earning</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="appEarning"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="getDriverCommDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">DRIVER EARNINGS</strong>
                <p class="pull-right orderID" style=" color: #8356a9;font-weight: 600;margin-right: 60px;"></p>
            </div>
            <div class="modal-body">

                <br>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Driver Commission</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="driverComm"></span>
                    </div>
                </div>
				
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Tip</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="driverTip"></span>
                    </div>
                </div>
               

                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Total</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="driverTotal"></span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="referralDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">REFERRER DETAILS</strong>
                <p class="pull-right masterID" style=" color: #8356a9;font-weight: 600;margin-right: 60px;"></p>
            </div>
            <div class="modal-body">

                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <img src="" class="img-circle dprofilePic style_prevu_kit" alt="pic" style="width: 80px;height:80px;display: none;">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Name:</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="driverName"></span>
                            </div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Email:</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="driverEmail"></span>
                            </div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Phone:</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="driverMobile"></span>
                            </div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Earnings:</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="driverEarnings"></span>
                            </div>
                        </div>
                    </div>
                </div>

              

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="getDiscountDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">DISCOUNT</strong>
                <p class="pull-right orderID" style=" color: #8356a9;font-weight: 600;margin-right: 60px;"></p>
            </div>
            <div class="modal-body">

                <br>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Promo Code</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="promoCode"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Discount Amount</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="discountAmount"></span>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="getPgCommDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">PG COMMISSION</strong>
                <p class="pull-right orderID" style=" color: #8356a9;font-weight: 600;margin-right: 60px;"></p>
            </div>
            <div class="modal-body">

                <br>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Payment Gateway</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="paymentGateway"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Commission</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="pgCommission"></span>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="getStoreDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">STORE DETAILS</strong>
            </div>
            <div class="modal-body">
                <br>
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-2"><br>
                        <img src="" class="img-circle storeLogo style_prevu_kit" onerror="this.src = '<?php echo base_url('/../../pics/user.jpg ') ?>'" alt="pic" style="width:80px;height:80px;display: none;">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="sName"></span>
                            </div>

                        </div>
						<div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Type</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="sType"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Email</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="sEmail"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                        <div class="form-group row" style="  margin-left: 7%;">
                            <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Phone</label>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <span style="" class="sPhone"></span>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        </div>
                        
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>



<div class="modal fade" id="getStoreCommDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">STORE EARNINGS</strong>
                <p class="pull-right orderID" style=" color: #8356a9;font-weight: 600;margin-right: 60px;"></p>
            </div>
            <div class="modal-body">

                <br>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Store Commission</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="storeCommission"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Store Given to driver</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="storeDeliveryFee"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Tax</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="storeTaxes"></span>
                    </div>
                </div>
				<div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Discount</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="storeDiscount"></span>
                    </div>
                </div>
				<div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Total</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="storeEarningsTotal"></span>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="getNetAmountDetails" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <strong style="color:#0090d9;">BILLING DETAILS</strong>
                <p class="pull-right orderID" style=" color: #8356a9;font-weight: 600;margin-right: 60px;"></p>
            </div>
            <div class="modal-body">

                <br>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Net Total</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="billingSubTotal"></span>
                    </div>
                </div>
                <div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Tax</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="billingTaxes"></span>
                    </div>
                </div>
				<div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Discount</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="billingDiscount"></span>
                    </div>
                </div>
				
				<div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Delivery Charge</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="billingDeliveryCharge"></span>
                    </div>
                </div>
				<div class="form-group row" style="  margin-left: 7%;">
                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="">Grand Total</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="billingGrandTotal"></span>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


