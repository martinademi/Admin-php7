
<style>
    span.abs_text {
        position: absolute;
        right:10px;
        top: 1px;
        z-index: 9;
        padding: 8px;
        background: #f1f1f1;
        border-right: 1px solid #d0d0d0;
        border-left: 1px solid #d0d0d0;
    }
    .pos_relative ,.pos_relative2{
        position: relative;
        padding-right:0px
    }
    .pos_relative2{
        padding-right:10px
    }
    #currencySymbol{
        padding-left: 10px;
    }

    .paging_full_numbers{
        margin-right: 1%;
    }
    .dataTables_info {
        margin-left: 1%;
    }
    .table-responsive{
        overflow-x:hidden;
        overflow-y:hidden;
    }
    .radio input[type=radio], .radio-inline input[type=radio] {
        margin-left: 0px; 
    }
    .lastButton{
        margin-right:1.8%;
    }
    .btn{
        border-radius: 25px !important;
    }



    .btncontrols {
        margin: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        color: white;
        background-color: cornflowerblue;
    }

    /*#cities,*/
    #editnow {
        border: 1px solid transparent;
        border-radius: 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        color: white;
        background-color: darkgray;
    }

    .success {
        color: springgreen;
    }

    .error {
        color: red;
    }

    .waitmsg {
        display: inline;
        margin-left: 50%;

    }

    .modal .modal-body p {
        color: aliceblue;
    }

    .displayinline {
        display: inline;
    }


    /*------------for auto complete search box---------------------*/

    .controls {
        margin: 10px 0;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        /*        font-size: 15px;*/
        font-weight: 600;
        /*margin-left: 12px;*/
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        /*width: 300px;*/
        /*border-radius: 5px;*/
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    #pac-input1 {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        border-radius: 5px;
    }

    #pac-input1:focus {
        border-color: #4d90fe;
    }


    .pac-container,.select2-drop {
        font-family: Roboto;
        z-index: 99999 !important;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #target {
        width: 345px;
    }

    .header{
        height:60px !important;
    }
    .header h3{
        margin:10px 0 !important;
    }
    .rating>.rated {
        color: #10cfbd;
    }
    .social-user-profile {
        width: 83px;
    }
    td a:before{
        color:transparent;
    }
    /*	.DataTables_sort_wrapper {
        text-align: center;
    }*/
</style>


<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    .pac-container {
        z-index: 1051 !important;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>




<script>

    $(document).ready(function () {

        $('#clearData').click(function ()
        {
            $('#start').val('');
            $('#end').val('');
            refreshData();
        });

        $('#searchData').click(function () {
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
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": '<?php echo base_url(); ?>index.php?/CartsController/datatable_carts/' + startDate + '/' + endDate,
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
            } else
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodels');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#confirmmodels').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdatas").text(<?php echo json_encode(POPUP_DRIVERS_DEACTIVAT_DATEOFBOOKING); ?>);
                $("#confirmeds").click(function () {
                    $('.close').trigger('click');
                });
            }
        });




    });

</script>

<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {

            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/CartsController/datatableActionDetails/<?php echo $cartId; ?>',
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers",
                                "iDisplayStart ": 20,
                                "oLanguage": {},
                                "fnInitComplete": function () {

                                    $('.cs-loader').hide();
                                    table.show()
                                    searchInput.show()
                                },
                                'fnServerData': function (sSource, aoData, fnCallback)
                                {
                                    // csrf protection
                                    aoData.push({name: '<?php echo $this->security->get_csrf_token_name(); ?>', value: '<?php echo $this->security->get_csrf_hash(); ?>'});
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
                        }, 1000);

                        // search box for table
                        $('#search-table').keyup(function () {
                            table.fnFilter($(this).val());
                        });

                    });


</script>

<style>
    .exportOptions{
        display: none;
    }
</style>

<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <div class="content"> 

       
        <ul class="nav nav-tabs  bg-white" style="margin-right: 1%;">
		 <div class="brand inline" style="  width: auto;">
            <a style="cursor:pointer" href="<?php echo base_url();?>index.php?/CartsController"><strong style="margin-left: 20px;">CART</strong></a><span style="margin-left: 0px;">->CART DETAILS</span>

        </div>
            <div style="margin-left:1.5%;" style="display:none;" class="hide_show">
                <!--             <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
                                          <div class="row clearfix">
                
                
                                                <div class="col-sm-3">
                                                    <div class="" aria-required="true">
                
                                                        <div class="input-daterange input-group">
                                                            <input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
                                                            <span class="input-group-addon">to</span>
                                                            <input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">
                
                                                        </div>
                
                                                    </div>
                
                                                </div>
                                                <div class="col-sm-1" style="margin-right: 15px;">
                                                     <div class=""> 
                                                        <button class="btn btn-primary" type="button" id="searchData">Search</button>
                                                     </div> 
                                                </div>
                                                 <div class="col-sm-1" style="margin-right: 15px;">
                                                     <div class=""> 
                                                        <button class="btn btn-info" type="button" id="clearData">Clear</button>
                                                     </div> 
                                                </div>
                
                                            </div>
                                           </div>-->
            </div>
        </ul>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">


                <div class="panel panel-transparent ">


                    <div class="container-fluid container-fixed-lg bg-white">
                        <!-- START PANEL -->
                        <div class="panel panel-transparent">
                            <div class="panel-heading">
                                <!--                                <div class="cs-loader">
                                                                    <div class="cs-loader-inner" >
                                                                        <label class="loaderPoint" style="color:#10cfbd">●</label>
                                                                        <label class="loaderPoint" style="color:red">●</label>
                                                                        <label class="loaderPoint" style="color:#FFD119">●</label>
                                                                        <label class="loaderPoint" style="color:#4d90fe">●</label>
                                                                        <label class="loaderPoint" style="color:palevioletred">●</label>
                                                                    </div>
                                                                </div>-->

                                <!--                                <div class="pull-right">
                                                                    <input type="text" id="search-table" class="form-control pull-right"  placeholder="SEARCH"/> 
                                
                                                                </div>
                                                                &nbsp;-->
                                <div class="panel-body" style="padding: 0px; margin-top: 2%;">
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <div class="col-sm-12">
                                                <span  style="font-size: 12px;font-weight:bold;color:#a5108f">CUSTOMER DETAILS</span>
                                            </div>
                                            <hr/>
                                        </div>
										 <div class="col-sm-6">
                                            <div class="col-sm-3">
                                                <span  style="font-size: 12px;font-weight:bold;color:#a5108f">CART STATUS  :</span>
                                            </div>
											<div class="col-sm-3">
											<span  style="font-size: 12px;color: #208e89"><?php echo $cartDetails['statusMsg']; ?></span>
											</div>
                                            <hr/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <div class="col-sm-12">
                                                <label class="col-sm-4" style="font-size: 12px;color:#4165f4">Customer Name  :  </label><span class="col-sm-4" style="font-size: 12px;color: #a5108f"><?php echo $cartDetails['userName']; ?></span>
                                            </div>
                                            <hr/>
                                        </div>
										<div class="col-sm-6"></div>

                                    </div>
									<div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <div class="col-sm-12">
                                                <label class="col-sm-4" style="font-size: 12px;color:#4165f4">Customer Phone  :  </label><span class="col-sm-4" style="font-size: 12px;color: #a5108f"><?php echo $cartDetails['customerCountryCode'].$cartDetails['customerPhone']; ?></span>
                                            </div>
                                            <hr/>
                                        </div>
										<div class="col-sm-6">
										</div>

                                    </div>
									<div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <div class="col-sm-12">
                                                <label class="col-sm-4" style="font-size: 12px;color:#4165f4">Customer Email  :  </label><span class="col-sm-4" style="font-size: 12px;color: #a5108f"><?php echo $cartDetails['customerEmail']; ?></span>
                                            </div>
                                            <hr/>
                                        </div>
										<div class="col-sm-6"></div>

                                    </div>
                                    <hr/>
                                    <div class="col-sm-12">
									<hr/>
                                        <div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <span  style="font-size: 12px;font-weight:bold;color:#a5108f">ORDER DETAILS</span>
                                            </div>
                                            <hr/>
                                        </div>
										
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="col-sm-4">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12" style="font-size: 12px;color:#4165f4">Item Name</label>
												
                                            </div>
                                          
                                        </div>
										<div class="col-sm-2">
										<div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12" style="font-size: 12px;color:#4165f4">Unit Name </label>
												
                                            </div>
                                           
										   </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12" style="font-size: 12px;color:#4165f4">Quantity</label>
												
                                            </div>
                                          
                                        </div>
                                        <div class="col-sm-2">
										<div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12" style="font-size: 12px;color:#4165f4">Unit Price </label>
												
                                            </div>
                                           
										   </div>
                                        </div>
                                        <div class="col-sm-2">
										<div class="col-sm-12">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12" style="font-size: 12px;color:#4165f4">Total </label>
												
                                            </div>
											
                                            
											</div>
                                        </div>
                                        <!--<div class="col-sm-1">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12" style="font-size: 12px;color:#4165f4">Edit </label>
                                            </div>
                                            <hr/>
                                        </div>-->
										
                                    </div>
									
									
									
									
									<?php 
									$totalDiscount =0;
									$subtotal =0;
									$totalTax =0.0;
									
									foreach($cartDetails['items'] as $items){
										?>
									
									<div class="col-sm-12">
									<hr/>
                                        <div class="col-sm-4">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12" style="font-size: 12px;color:#208e89"><?php echo $items['itemName'];?></label>
                                            </div>
                                            
                                        </div>
										<div class="col-sm-2">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12" style="font-size: 12px;    margin-left: 10px;color:#208e89"><?php echo $items['unitName'];?></label>
                                            </div>
                                           
                                        </div>
										
                                        <div class="col-sm-2">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12" style="font-size: 12px;color:#208e89"><?php echo $items['quantity'];?></label>
                                            </div>
                                            
                                        </div>
										
                                        <div class="col-sm-2">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12" style="font-size: 12px;    margin-left: 10px;color:#208e89"><?php echo $items['unitPrice']." ".$items['currencySymbol'];?></label>
                                            </div>
                                           
                                        </div>
										
                                        <div class="col-sm-2">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12" style="    margin-left: 10px;font-size: 12px;color:#208e89"><?php echo $items['unitPrice'] * $items['quantity']." ".$items['currencySymbol']  ;?> </label>
                                            </div>
                                            
                                        </div>
										
									 </div>
									 <hr/>
                                        <!--<div class="col-sm-1">
                                            <div class="col-sm-12">
                                                <label class="col-sm-12" style="font-size: 12px;color:#4165f4"><span class="glyphicon glyphicon-pencil"></span> </label>
                                            </div>
                                            <hr/>
                                        </div> -->
											
                                   <?php 
								   $subtotal = $subtotal + ($items['unitPrice'] * $items['quantity']);
								   $totalDiscount = $totalDiscount + ($items['appliedDiscount']);
								   if($items['taxes'] == null || $items['taxes'] == "" || empty($items['taxes'])){
									   $totalTax = 0;
								   }else{
									   foreach($items['taxes'] as $tax){
										  (float)$totalTax =  (float)$totalTax + (float)$tax['taxValue'];
									   }
								   }
								   ?>
									
									<?php } ?>
									
									
									<div class="col-sm-12">
											<hr/>
												<div class="col-sm-8"></div>
													<div class="col-sm-4">
													
														<div class="col-sm-12">
															<label class="col-sm-7" style="font-size: 12px;color:#208e89">Sub-total </label>
															<label class="col-sm-5" style="font-size: 12px;color:#208e89"><?php echo $subtotal." ".$items['currencySymbol'];?></label>
														</div>
													</div>
											</div>
											<div class="col-sm-12">
											
												<div class="col-sm-8"></div>
													<div class="col-sm-4">
													
														<div class="col-sm-12">
															<label class="col-sm-7" style="font-size: 12px;color:#208e89">Total Discount </label>
															<label class="col-sm-5" style="font-size: 12px;color:#208e89"><?php echo $totalDiscount." ".$items['currencySymbol'];?></label>
														</div>
													</div>
											</div>
											<div class="col-sm-12">
												<div class="col-sm-8"></div>
													<div class="col-sm-4">
														<div class="col-sm-12">
															<label class="col-sm-7" style="font-size: 12px;color:#208e89">tax</label>
															<label class="col-sm-5" style="font-size: 12px;color:#208e89"><?php echo $totalTax." ".$items['currencySymbol'];?></label>
														</div>
													</div>
											</div>
											<div class="col-sm-12">
												<div class="col-sm-8"></div>
													<div class="col-sm-4">
													<hr/>
														<div class="col-sm-12">
														<label class="col-sm-7" style="font-size: 12px;color:#208e89">Final total </label>
														<label class="col-sm-5" style="font-size: 12px;color:#208e89"><?php echo ($subtotal -($totalDiscount+$totalTax))." ".$items['currencySymbol'];?> </label>
														</div>
														<hr/>
														
												</div>
											</div>
											
											
									

									
									
									
									
									
									




                                    <?php // echo $this->table->generate(); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- END PANEL -->
        </div>
    </div>
</div>
<input type="hidden" id="cityExistsName" name="cityExistsName">

<div class="container-fluid container-fixed-lg footer">
    <div class="copyright sm-text-center">
        <p class="small no-margin pull-left sm-pull-reset">
            <span class="copy-right"></span>

        </p>

        <div class="clearfix"></div>
    </div>
</div>


