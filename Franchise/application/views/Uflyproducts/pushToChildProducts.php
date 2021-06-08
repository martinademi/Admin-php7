
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
    /* .btn{
        border-radius: 25px !important;
        width: auto;
        padding: 5px;
    } */
    a.fg-button{
        cursor:pointer;
    }


    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>

<script type="text/javascript">
    $(document).ready(function () {

       

        /* DEFAULT DATATABLE START */
        var table = $('#big_table');
        var searchInput = $('#search-table');
        searchInput.hide();
        table.hide();
        $('.cs-loader').show();
        setTimeout(function () {
            $('#big_table_processing').show();
            var settings = {
                "autoWidth": false,
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "iDisplayLength": 20,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/StoreListDetails/1',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {

                },
                "fnInitComplete": function () {
                    $('.cs-loader').hide();
                    table.show()
                    searchInput.show()
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
        }, 1000);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });
	$('#addToAllStores').click(function(){
		$('.checkboxProductToPush').prop('checked', true);
		$('#addToAll').modal('show');
	});	

	// $('#addALL').click(function(){
	// 	var val = $('.checkboxProductToPush:checked').map(function () {
    //                 return this.value;
    //             }).get();
    //             $('#addALL').attr('disabled','disabled');
               
	// 	var id = "<?php echo $productId;?>";	
    //     //$('#addToAll').modal('hide');	
	// 			 $.ajax({
    //                 url: "<?php echo base_url('index.php?/AddNewProducts') ?>/pushFranchiseProductsToStores",
    //                 type: "POST",
    //                 data: {val: val, productId: id},
    //                 dataType: 'JSON',
    //                 success: function (response,textStatus, xhr)
    //                 {   
    //                     console.log('if');
                     
    //                     if(xhr.status==200){
    //                         $('#addToAll').modal('hide');
    //                         $('.modalPopUpText').text("Added Successfully");
    //                         reloadDataTable();
    //                    $('#errorModal').modal('show');
    //                     }
    //                     else{
    //                         $('.modalPopUpText').text("Opps! Somethings went wrong");
    //                         $('#errorModal').modal('show');
    //                     }
					   
    //                 }

    //             });
	// });

     $('.addProductToStores').click(function(){
            $("#addToAll").modal('hide');
		var val = $('.checkboxProductToPush:checked').map(function () {
                    return this.value;
                }).get();
		if(val.length == 0 || val.length == "0"){
			$('.modalPopUpText').text("Invalid Selection ...");
                       $('#errorModal').modal('show');
		}else{	
            $(document).ajaxStart(function () {
                        $("#addToStores").prop("disabled",true)
                        $("#loadingModal").modal('show')
                    });	
		var ids = "<?php echo $productId;?>";		
				 $.ajax({
                    url: "<?php echo base_url('index.php?/AddNewProducts') ?>/pushFranchiseProductsToStores",
                    type: "POST",
                    data: {val: val, productId: ids},
                    dataType: 'JSON',
                    success: function (response)
                    {
                        console.log('store response',response)
                        $("#showMsg").empty();
                        $(document).ajaxComplete(function() {
                                $("#addToStores").prop("disabled",false)
                                $("#loadingModal").modal('hide')
                         });

                        reloadDataTable();
                        
                        // refresh dataTable

                                
                        //         var proInfo = response.productInfo;
                        //     var tableData ='<table class="msgTable"><tr><th>store Name</th><th>Status</th></tr>';
                        //         $.each(proInfo,function(index,row){
                        //             tableData+='<tr><td>'+row.storeName+'</td><td>'+row.msg+'</td></tr>';
                        //         })    
                        //         tableData+='</table>'; 
                        //     var htmlData ='<span>Details</span>'
                        //                     +'<div class="form-group">'+tableData+'</div>';
                        // $("#showMsg").append(htmlData);
                        // $("#showMessage").modal('show');                                
					   
                    },
                    error: function (jqXHR, exception) {
                            $("#addToStores").prop("disabled",false)
                            $(".modalPopUpText").text("Error.Please contact with administrator");
                            $("#errorModal").modal('show');
                        }

                });
		}
	});
	// $('#addToStores').click(function(){
	// 	var val = $('.checkboxProductToPush:checked').map(function () {
    //                 return this.value;
    //             }).get();
	// 	if(val.length == 0 || val.length == "0"){
	// 		$('.modalPopUpText').text("Invalid Selection ...");
    //                    $('#errorModal').modal('show');
	// 	}else{		
	// 	var ids = "<?php echo $productId;?>";		
	// 			 $.ajax({
    //                 url: "<?php echo base_url('index.php?/AddNewProducts') ?>/pushFranchiseProductsToStores",
    //                 type: "POST",
    //                 data: {val: val, productId: ids},
    //                 dataType: 'JSON',
    //                 success: function (response,textStatus, xhr)
    //                 {
                      
	// 					if(xhr.status==200){
    //                         $('.modalPopUpText').text("Added Successfully");
    //                    $('#errorModal').modal('show');
    //                    reloadDataTable();
    //                     }
    //                     else{
    //                         $('.modalPopUpText').text("Opps! Somethings went wrong");
    //                         $('#errorModal').modal('show');
    //                     }
                       
					   
    //                 }

    //             });
	// 	}
	// });
     

    });
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

     function reloadDataTable(){

                    console.log('refresh')
                    /* DEFAULT DATATABLE START */
                    var table = $('#big_table');
                    var searchInput = $('#search-table');
                    searchInput.hide();
                    table.hide();
                    $('.cs-loader').show();
                    setTimeout(function () {
                    $('#big_table_processing').show();
                    var settings = {
                        "autoWidth": false,
                        "sDom": "<'table-responsive't><'row'<p i>>",
                        "destroy": true,
                        "scrollCollapse": true,
                        "iDisplayLength": 20,
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/StoreListDetails/1',
                        "bJQueryUI": true,
                        "sPaginationType": "full_numbers",
                        "iDisplayStart ": 20,
                        "oLanguage": {

                        },
                        "fnInitComplete": function () {
                            $('.cs-loader').hide();
                            table.show()
                            searchInput.show()
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
                    }, 1000);
                    }


   
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
             margin-left: 30px; margin-top:15px;padding: 15px;">
           <!--                    <img src="--><?php //echo base_url();                ?><!--theme/assets/img/Rlogo.png" alt="logo" data-src="--><?php //echo base_url();                ?><!--theme/assets/img/Rlogo.png" data-src-retina="--><?php //echo base_url();                ?><!--theme/assets/img/logo_2x.png" width="93" height="25">-->

            <strong style="color:#0090d9;font-size: 11px;">FRANCHISE STORES</strong><!-- id="define_page"-->
        </div>

         <ul class="breadcrumb" style="margin-left: 0px; margin-top:15px;">
        <li><a href="<?php echo base_url(); ?>index.php?/AddNewProducts/FranchiseProducts" class="">PRODUCT</a></li>
        <li style="width: 100px"><a href="#" class="active">Add to Store</a></li>
        </ul>

        <div id="test"></div>
        <!-- Nav tabs -->
        <!-- <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked"> -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">

          
            <div class="pull-right m-t-10" style="margin-top: 5px;"> <button class="btn btn-info addProductToStores " id="addToStores">Add Product to Selected Store</button></div>
            <div class="pull-right m-t-10" style="margin-top: 5px;"> <button class="btn btn-success pull-right m-t-10" id="addToAllStores">Add product to all stores</button></a></div>
            
        </ul>

           
        <!-- Tab panes -->
        <!-- START JUMBOTRON -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="panel panel-transparent ">

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

                                    <div class="searchbtn row clearfix pull-right" >

                                        <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right"  placeholder="Search"> </div>
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
<div class="modal fade stick-up" id="unitListModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Unit List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="unitListData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                        </button>
                </div>

                <br>
                <div class="modal-body">
                    <div class="row">
                        <div class="error-box" id="errorboxdata" style="font-size: large;text-align:center"><?php echo 'Are you sure, you want to delete this product'; ?></div>
                    </div>
                </div>
                <br>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="confirmed1" >Yes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<div id="errorModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">
                <p class="error-box modalPopUpText" style="font-size: initial !important;"></p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>

    </div>
</div>

<div id="addToAll" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm</h4>
      </div>
      <div class="modal-body">
        <p style="font-size:11px;">Are you sure you want to add <?php echo '<b style="color:#0066ff">'.$productName.'</b>';?> product to all the stores?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default addProductToStores " id="addALL">Add</button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="loadingModal" data-backdrop="static" data-keyboard="false" role="dialog" style="margin-top:10%;">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <!-- <div class="modal-header">
         
        </div> -->
        <div class="modal-body">
        <div id="loadingimg">
            <img src="<?php echo base_url(); ?>theme/icon/loadingicon.gif" style="width:75px;height:75px; margin-left:35%;">
        </div>
       <p>Adding Selected Products.Please wait...</p>
        </div>
        <!-- <div class="modal-footer">
         
        </div> -->
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="showMessage" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Alert</h4>
        </div>
        <div class="modal-body form-group" id="showMsg">
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

