
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
	.container-fluid {
    padding-right: 0px !important;
    padding-left: 0px !important;
    margin-right: auto;
    margin-left: auto;
}


    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>


<script type="text/javascript">

function getOrdersCount()
    {
        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Orders/getOrdersCount",
            type: "POST",
            dataType: 'json',
            async: true,
            success: function (response)
            {
      
                $('.assignedCount').text(response.data.Assigned);
                $('.newOrderCount').text(response.data.New);
                $('.unassignedCount').text(response.data.Unassigned);
                $('.completedCount').text(response.data.Completed);
                $('.orderPickedCount').text(response.data.orderPicked);
                $('.pickupReadyCount').text(response.data.pickupReady);
                
                
                
            }
        });
    }
    
    function callDatatable(status){
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Orders/datatableOrders/'+status,
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
    }
	
	$(document).on('click', '.orderAction', function ()
        {
			var val = $(this).val();
            $("#orderId").val(val);
			$('#actionModal').modal('show');
			
		});

    $(document).ready(function () {
		
		  
		
        var status = '<?php echo $status; ?>';

       

        $('.whenclicked li').click(function () {
            // alert($(this).attr('id'));
            if ($(this).attr('id') == 3) {
                $('#inactive').show();
                $('#active').hide();
                $('#btnStickUpSizeToggler').show();
                $("#display-data").text("");

            } else if ($(this).attr('id') == 1) {
                $('#inactive').hide();
                $('#active').show();
                $('#btnStickUpSizeToggler').show();
                $("#display-data").text("");
            }else if ($(this).attr('id') == 7) {
                $('#changePassword').hide();
                $('#inactive').hide();
                $('#active').hide();
                $('#ban').hide();
                $('#btnStickUpSizeToggler').hide();
                $('#deviceLogs').hide();
                $('#delete_passenger').hide();
                $("#display-data").text("");
            }
            else if ($(this).attr('id') == 8) {
                $('#changePassword').hide();
                $('#inactive').hide();
                $('#active').hide();
                $('#ban').hide();
                $('#btnStickUpSizeToggler').hide();
                $('#deviceLogs').hide();
                $('#delete_passenger').hide();
                $("#display-data").text("");
            }else if ($(this).attr('id') == 4) {
                
            $('#delete_passenger').show();
            }else if ($(this).attr('id') == 5) {
                
            $('#delete_passenger').show();
            }else if ($(this).attr('id') == 6) {
                $('#delete_passenger').show();
            }


        });
		getOrdersCount();
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Orders/datatableOrders/<?php echo $status;?>',
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
			var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Orders/datatableOrders/'+status,
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
			
        });
        $('#datepicker-component').on('changeDate', function () {
            $('.datepicker').hide();
        });
		
		$(document).on('click', '.orderDetails', function ()
		 {
			 var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
			 var orderId = $(this).attr('orderId');
			 window.open("<?php echo base_url();?>index.php?/Orders/orderDetails/"+orderId+"/"+status,"_self")
		 });
		 $(document).on('click', '.getBreakDownDetails', function ()
		 {
		    var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
			
			var orderId1 = $(this).val();
			var orderId = $(this).attr('orderId');
			
			$.ajax({
                url: "<?php echo base_url(); ?>index.php?/Orders/ordersData",
                type: "POST",
                data: {orderId:orderId,status:status},
                dataType: "JSON",
                
                success: function (result) {
                   
				   $('#discountTag').text(result.data.couponCode);
				   if(result.data.abbrevation == 1){
				   $('#netPrice').text((result.data.currencySymbol)+(result.data.subTotalAmount.toFixed(2)));
				    $('#deliveryFee').text((result.data.currencySymbol)+(result.data.deliveryCharge.toFixed(2)));
					 $('#discount').text((result.data.currencySymbol)+(result.data.discount.toFixed(2)));
					 $('#tax').text((result.data.currencySymbol)+(result.data.excTax));
					  $('#grandTotal').text((result.data.currencySymbol)+(result.data.totalAmount.toFixed(2)));
				   }else{
					   $('#netPrice').text((result.data.subTotalAmount.toFixed(2))+(result.data.currencySymbol));
					   $('#deliveryFee').text((result.data.deliveryCharge.toFixed(2))+(result.data.currencySymbol));
					   $('#discount').text((result.data.discount.toFixed(2))+(result.data.currencySymbol));
					   $('#tax').text((result.data.excTax)+(result.data.currencySymbol));
					    $('#grandTotal').text((result.data.totalAmount.toFixed(2))+(result.data.currencySymbol));
				   }
				    
				    $('#detailsModal').modal('show');
                }
            });
			
		});
		
		$('#searchDataold').click(function () {
            if ($("#start").val() && $("#end").val())
            {
                var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                var status = urlChunks[urlChunks.length - 1];               
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
                    "sAjaxSource": '<?php echo base_url(); ?>index.php?/Orders/datatableOrders/' +status +'/' + startDate + '/' + endDate,
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
                var modalElem = $('#searchModal');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                } else
                {
                    $('#searchModal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
               // $("#errorboxdatas").text(<?php echo json_encode(POPUP_DRIVERS_DEACTIVAT_DATEOFBOOKING); ?>);
                $("#searchModal").click(function () {
                    $('.close').trigger('click');
                });
            }
        });


        $('#searchData').click(function () {
            if ($("#start").val() && $("#end").val())
            {

                 var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
        var status = urlChunks[urlChunks.length - 1];
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
                    "sAjaxSource": '<?php echo base_url(); ?>index.php?/Orders/datatableOrders/'+status +'/' + startDate + '/' + endDate,
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
                              
                               html15 += '<option value="'+row._id.$oid+'" storeName="'+row.name[0]+'">'+row.name+'</option>';

                             
                          });
                            $('#storeFilter').append(html15);    
                    }

                     
                }
            });
		$('#orderFilter').change(function(){
			var filterStatus = $('#orderFilter option:selected').val();
			if(filterStatus != ""){
			switch(parseInt(filterStatus)){
			
			case 2 :callDatatableForFilters(1,1);
			break;
			case 3 :callDatatableForFilters(1,2);
			break;
			case 4 :callDatatableForFilters(2,1);
			break;
			case 5 :callDatatableForFilters(2,2);
			break;
			}
			}else{
				callDatatableForFilters(0,0); 
			}
		});
		
		$('#cityFilter').change(function(){
			var city=$('#cityFilter option:selected').attr('cityName');
			var cityId=$('#cityFilter option:selected').val();
			
			table.fnFilter(city);
			
		});
		$('#storeFilter').change(function(){
			var store=$('#storeFilter option:selected').attr('storename');
			var cityId=$('#storeFilter option:selected').val();
			
			table.fnFilter(store);
			
		});
		

        $('.changeMode').click(function () {
            $('.cs-loader').show();
            var table = $('#big_table');
            $('#big_table_processing').show();
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": $(this).attr('data'),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {

                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
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
                },

            };

            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');





            table.dataTable(settings);

          



        });
		
		$('#btnAccept').click(function(){
			var val = $("#orderId").val();
            var status = $("#btnAccept").val();
			$.ajax({
            url: "<?php echo base_url() ?>index.php?/Orders/acceptOrder",
            type: "POST",
			data:{val:val , status:status},
            dataType: 'json',
            async: true,
            success: function (response)
            { 
                
                $("#actionModal").modal('hide');      
               if(response.statusCode == 200){
                   callDatatable(0)
               }
               else{
                   alert("Internal server Error.")
               }
                
                
            }
        });
			
		});
        $('#btnReject').click(function(){
			var val = $("#orderId").val();
            var status = $("#btnReject").val();
			$.ajax({
            url: "<?php echo base_url() ?>index.php?/Orders/acceptOrder",
            type: "POST",
			data:{val:val , status:status},
            dataType: 'json',
            async: true,
            success: function (response)
            { 
                
                $("#actionModal").modal('hide');        
               if(response.statusCode == 200){
                   
                callDatatable(0)
               }
               else{
                alert("Internal server Error.")   
               }
                
            }
        });
			
		});
		
		

        $('#big_table').on('init.dt', function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            var forwhat = urlChunks[urlChunks.length - 2];

            if (status == 0) {
                $('#big_table').dataTable().fnSetColumnVis([2,4,5,13,14,15,16,12], false);
				getOrdersCount();
                }
            if (status == 1) {
                $('#big_table').dataTable().fnSetColumnVis([2,4,5,13,14,17,15,12], false);
				getOrdersCount();
                
            }
            if (status == 2) {
                $('#big_table').dataTable().fnSetColumnVis([2,4,15,17,12], false);
                getOrdersCount();
            }
            if (status == 3) {
                $('#big_table').dataTable().fnSetColumnVis([2,4,5,8,9,13,14,15,17,12], false);
                getOrdersCount();
            }
            if (status == 4) {
                $('#big_table').dataTable().fnSetColumnVis([2,4,5,8,9,13,14,15,17,12], false);
                getOrdersCount();
            }
            if (status == 5) {
                $('#big_table').dataTable().fnSetColumnVis([2,4,5,8,9,13,14,15,17,12], false);
                getOrdersCount();
            }
           

        });
//

    });
	
	
	
function callDatatableForFilters(businessType,serviceType){
	  var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
	var table = $('#big_table');
                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "iDisplayLength": 20,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": '<?php echo base_url(); ?>index.php?/Orders/datatableOrders/'+status+'/' + businessType + '/' + serviceType,
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
}

    
    $(document).ready(function () {

        var forcedAccept='<?php echo $forcedAccept;?>';
        var autodispatch='<?php echo $autodispatch;?>';

        // autoDispatch 0(off) & 1(on)
        // forcedAccept 1(on) & 2(off)

        if(forcedAccept==1 && autodispatch==1){
            $('.tab_accepted').show();
            $('.tab_orderPicked').show();
            $('.tab_pickupReady').show();
            $('.tab_completed').show();
        }else if(forcedAccept==2 && autodispatch==0){
            $('.tab_new').show();
            $('.tab_accepted').show();
            $('.tab_inDispatch').show();
            $('.tab_orderPicked').show();
            $('.tab_pickupReady').show();
            $('.tab_completed').show();
        }else if(forcedAccept==2 && autodispatch==1){
            $('.tab_new').show();
            $('.tab_accepted').show();
            $('.tab_orderPicked').show();
            $('.tab_pickupReady').show();
            $('.tab_completed').show();
        }else if(forcedAccept==1 && autodispatch==0){
            $('.tab_new').show();
            $('.tab_accepted').show();
            $('.tab_inDispatch').show();
            $('.tab_orderPicked').show();
            $('.tab_pickupReady').show();
            $('.tab_completed').show();
        }
       



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

       
        <div class="brand inline" style="  width: auto;">
       <?php echo $this->lang->line('page_name'); ?>
        </div>
        <div id="test"></div>
        <!-- Nav tabs -->
        <div class="panel panel-transparent ">
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">

          

            <li id="0" class="tabs_active <?php echo ($status == 0 ? "active" : ""); ?> tab_new " style="cursor:pointer;display:none">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/Orders/datatableOrders/0"><span><?php echo $this->lang->line('tab_new'); ?>
            </span><span class="badge newOrderCount" style="background-color: #5bc0de;"></span></a>
            </li>

            <li id="1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?> tab_accepted" style="cursor:pointer;display:none">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/Orders/datatableOrders/1"><span><?php echo $this->lang->line('tab_accepted'); ?>
            </span><span class="badge unassignedCount" style="background-color:#3CB371;"></span></a>
            </li>
            <li id="2" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?> tab_inDispatch" style="cursor:pointer;">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/Orders/datatableOrders/2"><span><?php echo $this->lang->line('tab_inDispatch'); ?>
            </span><span class="badge assignedCount" style="background-color:#f0ad4e;"></span></a>
            </li>
            <li id="3" class="tabs_active <?php echo ($status == 3 ? "active" : ""); ?> tab_orderPicked" style="cursor:pointer;display:none">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/Orders/datatableOrders/3"><span><?php echo $this->lang->line('tab_orderPicked'); ?>
            </span><span class="badge orderPickedCount " style="background-color:#B22222;"></span></a>
            </li>
            <li id="4" class="tabs_active <?php echo ($status == 4 ? "active" : ""); ?> tab_pickupReady" style="cursor:pointer;">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/Orders/datatableOrders/4"><span><?php echo $this->lang->line('tab_pickupReady'); ?>
            </span><span class="badge pickupReadyCount" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id="5" class="tabs_active <?php echo ($status == 5 ? "active" : ""); ?> tab_completed" style="cursor:pointer;">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/Orders/datatableOrders/5"><span><?php echo $this->lang->line('tab_completed'); ?>
            </span><span class="badge completedCount " style="background-color: #3CB371;"></span></a>
            </li>
           
       
        </ul>
        </div>
        <!-- Tab panes -->
        <!-- START JUMBOTRON -->
        <div class="parallax" data-pages="parallax">
            <div class="col-xs-12 container-fixed-lg sm-p-l-20 sm-p-r-20" style="margin-top: 10px;">

                <div class="row panel panel-transparent ">

                    <div class="tab-content">
                        <div class="col-xs-12 container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="col-xs-12 panel panel-transparent">
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
									<div class="row clearfix pull-left" style="margin-left:0px;">

                                        <div class="pull-left">
										<select class="form-control pull-left" id="orderFilter">
										<option value="" >Select Order Type</option>
										
										<option value="2" >ASAP Delivery</option>
										<option value="3" >ASAP Pickup</option>
										<option value="4" >Scheduled Pickup</option>
										<option value="5" >Scheduled Delivery</option>
										
										</select> 
										</div>
                                    </div>
									 
									
									<div class="col-sm-2 hide_show" style="margin-left: 30px">
										<div class="" aria-required="true">

											<div class="input-daterange input-group">
												<input type="text" style="width:90px;" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
												<span class="input-group-addon">to</span>
												<input style="width:90px;"type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">

											</div>
										</div>
									</div>
									 <div class="col-sm-3 hide_show" >

											<button class="btn btn-primary" style="margin-left:35px;width: 100px !important;" type="button" id="searchData"><?php echo $this->lang->line('button_search'); ?></button>
                                           
                                            <button class="btn btn-info" style="margin-left:20px;width: 60px !important;" type="button" id="clearData"><?php echo $this->lang->line('button_clear'); ?></button>


									</div>
									<!-- <div class="col-sm-1 hide_show" >

										<button class="btn btn-info" style="margin-left:100px;width: 60px !important;" type="button" id="clearData"><?php echo $this->lang->line('button_clear'); ?></button>

									</div> -->


                                    <div class="searchbtn row clearfix pull-right" >

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right"  placeholder="Search"> </div>
                                    </div>


                                </div>
                                &nbsp;
                                <div class="row panel-body">
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

                <span class="modal-title"><?php echo $this->lang->line('title_action'); ?></span>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box modalPopUpText" id="errorboxdata" style="font-size: large;text-align:center"><?php echo $this->lang->line('alert_action'); ?></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-3">
                    <input type="hidden" id="orderId" value="">
					 <button type="button" class="btn btn-warning pull-right" id="btnReject" value="3" ><?php echo $this->lang->line('button_reject'); ?></button>
					</div>
                    <div class="col-sm-3" >
                        <button type="button" class="btn btn-success pull-right" id="btnAccept" value="4"  ><?php echo $this->lang->line('button_accept'); ?></button>
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

                <span class="modal-title"><?php echo $this->lang->line('title_breakdownDetails'); ?></span>

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

<!-- Modal for search data-->
<div id="searchModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Alert</h4>
      </div>
      <div class="modal-body">
        <p>Please select start and end date</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>