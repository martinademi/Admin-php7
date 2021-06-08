<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet">
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

        .btn{
        font-size: 10px !important;
    }
    .dataTables_scrollHead{
        margin-bottom: -52px !important;
    }
    .textDec{
        text-decoration: underline !important;  
    }

    /* Important part */
    .modal-dialog{
        overflow-y: initial !important
    }
    .bulkList{
        height: 250px;
        overflow-y: auto;
        overflow-x: auto;
    }

    .dataTables_scrollHead {
        margin-bottom: -49px !important;
    }

    .outer{
        margin-top:15px;
        border:1px solid lightgrey;
    }
    .list-group-item {
        margin-bottom:2px !important;
    }
    .ullist{
        margin-bottom:0px;
    }
    .liitems{
        border: none;
        padding:7px 0px 7px 0px;
    }
    .liitems>label{
        float:right;
        font-size:16px;
        margin-bottom: 0px;
        color:#514d6a;
    }
    .liitems>a{
        text-decoration: none;
        color: #74708d;
        font-weight: bold;
    }
    .liitems>a:hover{
        color:#007bff;
    }
    hr{
        margin-top: 5px;
        margin-bottom: 0px;
    }
    .size{
        padding:1px 10px 1px 10px;
        margin-right: 10px;
        border: 1px solid lightgrey;
        border-radius:10px;
        float: left;
    }

    /* filter units size */
    .sizefilter{
        padding-top: 0px;
        margin-bottom: 0px;

    }
    img{
        position: relative;
        transition: all 0.3s ease-in-out;
    }
    img:hover{
        transform: scale(1.1);
        cursor: pointer;	
    }
    .outerimagepart{
        position:relative;
    }
    .innerimagepart{
        position: absolute;
        top:0px;
        right:0px;
        color:#191616;;
        cursor: pointer;
    }
    .activealert{
        color:#514d6a;
    }
	.text-concat {
        white-space: nowrap; 
        width: 180px; 
        overflow: hidden;
        text-overflow: ellipsis;
        color:black;
        font-size:15px; 
	}
	.pricetag{
	    color:black;
	    font-size:15px; 
    }
    
    .brWrap{
        overflow: hidden;
    }
	@media (min-width: 1200px) and (max-width: 1420px) {
        .brWrap{
            display: block;
            width: 100%;
        }
    }
</style>

<script type="text/javascript">


 $('.units').click(function(){
     alert();
 });
  //for storing type of view
 var typeView=1;
 var storeId;

//  *********for grid view**********
        $(document).on('click', '.viewDetails', function (){

        var productId = $(this).attr('productId');

        window.location.href = '<?php echo base_url();?>index.php?/GridProduct_controller/ViewProducts/' + productId;

        });

        //filter edit details
        $(document).on('click','.editDetails',function(){

        var productId = $(this).attr('productId');
            
        window.location.href = '<?php echo base_url();?>index.php?/AddNewProducts/EditProducts/' + productId;
       

        });

        //unit modal

        //filter delete details
        $(document).on('click','.deleteDetails',function(){


        var productId=$(this).attr('productId');

        $('#deleteYes').val(productId);
        $('#deleteModal').modal('show');

        });

         //filter delete details
         $(document).on('click','#deleteYes',function(){

            
           var productIdYes=$(this).val();


            $.ajax({
            //chnages
                url:'<?php echo base_url();?>index.php?/GridProduct_controller/deleteProduct/' + productIdYes,
                type:'POST',
                dataType: 'json',


            }).done(function(json){

            if(json==1){
                
                window.location.href = '<?php echo base_url();?>index.php?/GridProduct_controller/index';

                }

            });
            

            //  $(document).on('click','.units',function(){
            //      console.log('unit called');


            //     });

                 //units modal
			 $(document).on('click', '.units', function (){
			//  $('.units').click(function(){
                console.log('unit');
			 var productId=$(this).attr('productId');
			

			 		$.ajax({
						url: '<?php echo base_url();?>index.php?/GridProduct_controller/getUnitDetails/' + productId,
						type: 'POST',
						dataType: 'json',
						data: { },
						
					})
					.done(function(json) {
						
						var html ="";
						$('.unitDetails').empty();
						$.each(json.data.units,function(index,val){

							 html+='	<div class="col-sm-12">'
									+'<div class="col-sm-6">'
									+'<div class="form-group row" style="  margin-left: 7%;">'
									+'<label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">'+val.name.en+'</label>'
									+'<div class="col-md-6 col-sm-6 col-xs-6">'
									+'<span style="" class="dname"></span>'
									+'</div>'
									+'</div>'
									+'</div>'
									+'<div class="col-sm-6">'
									+'<div class="form-group row" style="  margin-left: 7%;">'
									+'<label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">'+json.data.currencySymbol.currencySymbol+' '+val.price.en+'</label>'
									+'<div class="col-md-6 col-sm-6 col-xs-6">'
									+'<span style="" class="dname"></span>'
									+'</div>'
									+'</div>'
									+'</div>'
					        		+'</div>';

							
						});

						$('.unitDetails').append(html);
						
						$('#myModal').modal('show');
					
					});
					// $('#unitDetails').append(html);

			 });
             
        });


$(document).ready(function (){

    // category  to get sub cat

            $('#listcategory').change(function(){
                            
                var categoryId=$(this).val();
                $('#listsubCategory').load("<?php echo base_url('index.php?/GridProduct_controller') ?>/getSubCategory", {categoryId: categoryId});                       
            
            });


});

    //**********  end for grid view**********



    $(document).ready(function () {

        $('.changeMode').click(function () {
                var table = $('#big_table');
                $('.cs-loader').show();
                $('#big_table').fadeOut('slow');
                $('#big_table_processing').show();

                var settings = {
                    "autoWidth": false,
                    "sDom": "<'table-responsive't><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "iDisplayLength": 10,
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": $(this).attr('data'),
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "iDisplayStart ": 10,
                    "oLanguage": {

                    },
                    "fnInitComplete": function () {
                        $('#big_table').fadeIn('slow');
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
                    }
                };

                $('.tabs_active').removeClass('active');

                $(this).parent().addClass('active');

                table.dataTable(settings);

                // search box for table
                $('#search-table').keyup(function () {
                    table.fnFilter($(this).val());
                });

                });

                $("#delete").click(function () {

                $("#display-data").text("");

                var val = $('.checkbox:checked').map(function () {
                    return this.value;
                }).get();

                if (val.length == 0) {
                    $('#errorModal').modal('show')
                    $(".modalPopUpText").text('Please select the Product ');
                } else if (val.length >= 1)
                {
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

                }


                });

                $("#confirmed1").click(function () {
                var val = $('.checkbox:checked').map(function () {
                    return this.value;
                }).get();
                var id = $('#checkboxProduct').attr('data-id')
                console.log(val)
                console.log(id);
                $.ajax({
                    url: "<?php echo base_url('index.php?/AddNewProducts') ?>/delete_product",
                    type: "POST",
                    data: {val: val, id: id},
                    dataType: 'JSON',
                    success: function (response)
                    {
                        console.log(response)
                       // window.location.reload();
                    }

                });
            });


            $("#add").click(function(){
                var val = $('.checkbox:checked').map(function () {
                    return this.value;
                }).get();
                if(val.length == 0){
                   window.location="<?php echo base_url(); ?>index.php?/AddNewProducts/addNewProduct"
                }
                else{
                    $('#errorModal').modal('show')
                    $(".modalPopUpText").text('Invalid Selection');
                }
            });

             $("#edit").click(function(){
                var val = $('.checkbox:checked').map(function () {
                    return this.value;
                }).get();
                if(val.length == 1){
                    id = val[0];
                   window.location="<?php echo base_url(); ?>index.php?/AddNewProducts/EditProducts/"+id
                }
                else{
                    $('#errorModal').modal('show')
                    $(".modalPopUpText").text('Invalid Selection');
                }
            });

                


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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/StoreProductDetails/1',
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

         // category filter
         $('#listcategory').change(function(){			
            var category=$('#listcategory option:selected').attr('catName');                                  
            table.fnFilter(category);
            
        });

         $('#listsubCategory').change(function(){			
            var subcategory=$('#listsubCategory option:selected').attr('catName');                                  
            table.fnFilter(subcategory);
            
        });

         $('#listsubSubCategory').change(function(){			
            var listsubSubCategory=$('#listsubSubCategory option:selected').attr('catName');                                  
            table.fnFilter(listsubSubCategory);
            
        });


		 $('#big_table').on("click", '.addToStores', function () {
			 var productId = $(this).attr('data-id');
			window.location.href="<?php echo base_url();?>index.php?/AddNewProducts/StoreList/"+productId 
			 
		 });
 

        $('#big_table').on("click", '.unitListForStoreProducts', function () {

                $('#unitListData').empty();
                var id = $(this).attr('id');

                $.ajax({
                    url: '<?php echo base_url() ?>index.php?/AddNewProducts/getUnitsForFranchise/' + id,
                    type: "POST",
                    data: {id: id},
                    dataType: "JSON",
                    success: function (result) {
                        var html = '';
                        var k = 1;
                        $.each(result.data, function (i, row) {
                            html = '<tr style="font-size:14px; "><td style="text-align:center;width:250px;border-style: ridge;">' + row.title + '</td><td style="border-style: ridge;width:250px;text-align:center;">' + row.value + '</td></tr>';

                            $('#unitListData').append(html);
                        });


                        $('#unitListModal').modal('show');
                    }

                });
                });

    });
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }


    $(document).ready(function(){

        //list
        var currencySymbol="$";

    $("#list").click(function(){
        console.log('list');
        typeView=1;
        $('#gridFilter').hide();
        $('#listFilter').show();
        
        $('#listViewDetails').show();
        $('#gridViewDetails').hide();
        $('#categoryProduct').empty();

    });

    $("#grid").click(function(){
        console.log('grid');
        typeView=2;
        $('#gridFilter').show();
        $('#listFilter').hide();
        $('#listViewDetails').hide();
        $('#gridViewDetails').show();
        $('#categoryProduct').empty();


    });

    //category filter
			$('#category').change(function(){
                    console.log('cat grid clicked');
                        var categoryId=$(this).val();
                        //fetch sub category
                        $('#subCategory').load("<?php echo base_url('index.php?/GridProduct_controller') ?>/getSubCategory", {categoryId: categoryId});                       
                        

                        $.ajax({
                            url:'<?php echo base_url()?>index.php?/GridProduct_controller/getCategorylist/' + categoryId,
                            type:'POST',
                            dataType:'json',
                            data: { },
                        }).done(function(json){

                            console.log(json);
                            $('#outstockProduct').hide();
                            $('#instockProduct').hide();
                            $('#bannedProduct').hide();
                            $('#rejectedProduct').hide();
                            $('#deletedProduct').hide();
                            $('#activeProduct').hide();
                            $('#gridViewDetails').hide();
                            $('#pendingProduct').hide();
                            $('.noData').hide();

                            if ( json.data != 0 ) {
                            var html ="";

                                    $('#categoryProductId').empty();

                                    $.each(json.data,function(index,val){

                                    var unitDiv = "";
                                    $.each(val.units, function(index, unitData){
                                        unitDiv+='<div class="size" id="unitsproduct">'+unitData.name.en+'</div>'
                                    })
                                        
                                    var name=val.productname.en;

                                    html ='<div class="col-sm-3 col-lg-3">'
                                        +'<div class="panel panel-info outer">'
                                        +'<div class="panel-body">'
                                        +'<div class="outerimagepart">'
                                        +'<div class="innerimagepart" style="margin-right: -13px;">'
                                        +'<div class="size"><i class="fa fa-eye viewDetails" productId="'+val._id.$oid+'"></i></div>'
                                        +'<div class="size"><i class="fa fa-edit editDetails" productId="'+val._id.$oid+'"></i></div>'
                                        +'<div class="size"><i class="fa fa-trash deleteDetails" productId="'+val._id.$oid+'"></i></div>'
                                        +'<input type="hidden" id="productidmodal" value="" >'
                                        +'</div>'
                                        +'<img src="'+val.images[0].image+'"height="200px" width="170px" class="text-center">'
                                        +'</div> '
                                        +'<div>'
                                        +'<hr><br>'
                                        +'<div class="pull-left text-concat ">'+name.substr(0,30) +'...'+'</div><br><br>'
                                        +'<div class="pull-right pricetag"><p>'+currencySymbol+ val.units[0].price.en+'</p></div>'
                                        +'<div style="clear:both"></div>'
                                        +'<ul class="list-group ullist">'
                                        +'<li class="list-group-item liitems" style="overflow:hidden;white-space:nowrap">'
                                        + unitDiv
                                        
                                        +'<div style="clear:both;"></div>'
                                        +'</li>'
                                        +'</ul>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>'
                                        +'</div>';					
                                        $('#categoryProductId').append(html);
                                    });

                                    $('.categoryProduct').show();
                                
                            }else{

                                $('.categoryProduct').hide();
                                $('.noData').empty();
                                var html ="";
                                html='<ul class="nav nav-tabs bg-white" style="margin-top: 50px; text-align: center; padding: 26px;font-size: 16px;">No Data Available</ul>';
                                $('.noData').append(html);
                                $('.noData').show();
                            }
                        });
    
            });

     
    //  sub category filter
    //sub category on chnage
			$('#subCategory').change(function(){
				
				var subCategoryId=$(this).val();

				//fetch sub-sub category
				$('#subSubCategory').load("<?php echo base_url('index.php?/GridProduct_controller') ?>/getSubSubCategory", {subCategoryId: subCategoryId});
				
				$.ajax({
					url:'<?php echo base_url()?>index.php?/GridProduct_controller/getSubCategorylist/' + subCategoryId,
					type:'POST',
					dataType:'json',
					data: { },
				}).done(function(json){
					 //console.log('subcategory***',json);

					$('#outstockProduct').hide();
					$('#instockProduct').hide();
					$('#bannedProduct').hide();
					$('#rejectedProduct').hide();
					$('#deletedProduct').hide();
					$('#activeProduct').hide();

                    $('#gridViewDetails').hide();
                    

					$('#pendingProduct').hide();
					$('.noData').hide();

					if(json.data!=0){
							var html ="";

							$('#categoryProductId').empty();

							$.each(json.data,function(index,val){

							var unitDiv = "";
							$.each(val.units, function(index, unitData){

									if(index<=2){
								unitDiv+='<div class="size" id="unitsproduct">'+unitData.name.en.substr(0,6)+'</div>'}
								else if(index==3){
									unitDiv+='<div style="color:#42cbf4;cursor:pointer" class="units" productId="'+val._id.$oid+'">more..</div>'
								}

							});
							 
						
						
							var name=val.productname.en;
								if(val.productname.en!=''|| val.productname.en!=null || !val.productname.en){
									
							html ='<div class="col-sm-3 col-lg-3">'
								+'<div class="panel panel-info outer">'
								+'<div class="panel-body">'
								+'<div class="outerimagepart">'
								+'<div class="innerimagepart" style="margin-right: -13px;">'
								+'<div class="size"><i class="fa fa-eye viewDetails" productId="'+val._id.$oid+'"></i></div>'
								+'<div class="size"><i class="fa fa-edit editDetails" productId="'+val._id.$oid+'"></i></div>'
								+'<div class="size"><i class="fa fa-trash deleteDetails" productId="'+val._id.$oid+'"></i></div>'
								+'<input type="hidden" id="productidmodal" value="" >'
								+'</div>'
								+'<img src="'+val.images[0].image+'"height="200px" width="170px" class="text-center">'
								+'</div> '
								+'<div>'
								+'<hr><br>'
								+'<div class="pull-left text-concat ">'+name.substr(0,30) +'...'+'</div><br><br>'
								+'<div class="pull-right pricetag"><p>'+currencySymbol+ val.units[0].price.en+'</p></div>'
								+'<div style="clear:both"></div>'
								+'<ul class="list-group ullist">'
								+'<li class="list-group-item liitems" style="overflow:hidden;white-space:nowrap">'
								+ unitDiv
								
								+'<div style="clear:both;"></div>'
								+'</li>'
								+'</ul>'
								+'</div>'
								+'</div>'
								+'</div>'
								+'</div>'
								+'</div>'
								+'</div>'
								+'</div>';					
								$('#categoryProductId').append(html);
								}
							});

							$('.categoryProduct').show();
								

						
					}else{

					$('.categoryProduct').hide();
					$('.noData').empty();
					var html ="";
					html='<ul class="nav nav-tabs bg-white" style="margin-top: 50px; text-align: center; padding: 26px;font-size: 16px;">No Data Available</ul>';
					$('.noData').append(html);
					$('.noData').show();

					}


				});
					
			});


            	// sub-sub category dropdown
				$('#subSubCategory').change(function(){
					

                    var subSubCategoryId=$(this).val();
                    $.ajax({
                        url:'<?php echo base_url()?>index.php?/GridProduct_controller/getSubSubCategorylist/' + subSubCategoryId,
                        type:'POST',
                        dataType:'json',
                        data: { },
                    }).done(function(json){
    
                         console.log(json);
                        $('#outstockProduct').hide();
                        $('#instockProduct').hide();
                        $('#bannedProduct').hide();
                        $('#rejectedProduct').hide();
                        $('#deletedProduct').hide();
                        $('#activeProduct').hide();
                        $('#gridViewDetails').hide();
                        $('#pendingProduct').hide();
                        $('.noData').hide();
    
                        if ( json.data != 0 ) {
                        var html ="";
    
                                $('#categoryProductId').empty();
    
                                $.each(json.data,function(index,val){
    
                                var unitDiv = "";
                                $.each(val.units, function(index, unitData){
                                    unitDiv+='<div class="size" id="unitsproduct">'+unitData.name.en+'</div>'
                                })
                                    
                                var name=val.productname.en;
    
                                html ='<div class="col-sm-3 col-lg-3">'
                                    +'<div class="panel panel-info outer">'
                                    +'<div class="panel-body">'
                                    +'<div class="outerimagepart">'
                                    +'<div class="innerimagepart" style="margin-right: -13px;">'
                                    +'<div class="size"><i class="fa fa-eye viewDetails" productId="'+val._id.$oid+'"></i></div>'
                                    +'<div class="size"><i class="fa fa-edit editDetails" productId="'+val._id.$oid+'"></i></div>'
                                    +'<div class="size"><i class="fa fa-trash deleteDetails" productId="'+val._id.$oid+'"></i></div>'
                                    +'<input type="hidden" id="productidmodal" value="" >'
                                    +'</div>'
                                    +'<img src="'+val.images[0].image+'"height="200px" width="170px" class="text-center">'
                                    +'</div> '
                                    +'<div>'
                                    +'<hr><br>'
                                    +'<div class="pull-left text-concat ">'+name.substr(0,30) +'...'+'</div><br><br>'
                                    +'<div class="pull-right pricetag"><p>'+currencySymbol+ val.units[0].price.en+'</p></div>'
                                    +'<div style="clear:both"></div>'
                                    +'<ul class="list-group ullist">'
                                    +'<li class="list-group-item liitems" style="overflow:hidden;white-space:nowrap">'
                                    + unitDiv
                                    
                                    +'<div style="clear:both;"></div>'
                                    +'</li>'
                                    +'</ul>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>'
                                    +'</div>';					
                                    $('#categoryProductId').append(html);
                                });
    
                                $('.categoryProduct').show();
                            
                        }else{
    
                            $('.categoryProduct').hide();
                            $('.noData').empty();
                            var html ="";
                            html='<ul class="nav nav-tabs bg-white" style="margin-top: 50px; text-align: center; padding: 26px;font-size: 16px;">No Data Available</ul>';
                            $('.noData').append(html);
                            $('.noData').show();
                        }
    
                        });
    
                 });


                 // brand
					$('#brand').change(function(){
						
                        var brandId=$(this).val();
        
        
                        $('#category').val("");
                        $('#subCategory').val("");
                        $('#subSubCategory').val("");
                        $('#manufacturers').val("");
                        
                        $.ajax({
                            url:'<?php echo base_url()?>index.php?/GridProduct_controller/getBrandlistDetails/' + brandId,
                            type:'POST',
                            dataType:'json',
                            data: { },
                        }).done(function(json){
                             console.log('brand***',json);
                        
        
                            $('#outstockProduct').hide();
                            $('#instockProduct').hide();
                            $('#bannedProduct').hide();
                            $('#rejectedProduct').hide();
                            $('#deletedProduct').hide();
                            $('#activeProduct').hide();
                            $('#gridViewDetails').hide();
                            $('#pendingProduct').hide();
                            
                            var html ="";
                            $('.categoryProduct').empty();
                                
        
                            html+='<div class="tab-content" id="cateProduct" >'
                +'<div class="tab-pane padding-20 slide-left">'
                    +'<div class="row row-same-height" >';	
                            $.each(json.data,function(index,val){
                                
                                $.each(val.units,function(ind,uprice){
        
                                //console.log('imagedisplay--->',uprice.price.en);
                            var name=val.productname.en;
                            html+='<div class="col-sm-3 col-lg-3">'
                                  +'<div class="panel panel-info outer">'
                                  +'<div class="panel-body">'
                                  +'<div class="outerimagepart">'
                                  +'<div class="innerimagepart" style="margin-right: -13px;">'
                                  +'<div class="size"><i class="fa fa-eye viewDetails" productId="'+val._id.$oid+'"></i></div>'
                                  +'<div class="size"><i class="fa fa-edit editDetails" productId="'+val._id.$oid+'"></i></div>'
                                  +'<div class="size"><i class="fa fa-trash deleteDetails" productId="'+val._id.$oid+'"></i></div>'
                                  +'<input type="hidden" id="productidmodal" value="" >'
                                  +'</div>'
                                  +'<img src="'+val.images[0].image+'"height="200px" width="170px" class="text-center">'
                                  +'</div> '
                                  +'<div>'
                                  +'<hr><br>'
                                  +'<div class="pull-left text-concat ">'+name.substr(0,30) +'...'+'</div><br><br>'
                                  +'<div class="pull-right pricetag"><p>'+currencySymbol+uprice.price.en+'</p></div>'
                                  +'<div style="clear:both"></div>'
                                  +'<ul class="list-group ullist">'
                                  +'<li class="list-group-item liitems" style="overflow:hidden;white-space:nowrap">'
                                  +'<div class="size"><p>'+uprice.name.en+'</p></div>'
                                  +'<div style="clear:both;"></div>'
                                  +'</li>'
                                  +'</ul>'
                                  +'</div>'
                                  +'</div>'
                                  +'</div>'
                                  +'</div>'
                                  +'</div>'
                                  +'</div>'
                                  +'</div>';					
                                        
                            
                                });
        
                            });
        
                            $('.categoryProduct').append(html);
                            
                        });
                            
                    });



                    // manufracturer
					$('#manufacturers').change(function(){

                //default select
                $('#category').val("");
                $('#subCategory').val("");
                $('#subSubCategory').val("");
                $('#brand').val("");

                var manufracturerId=$(this).val();
                $.ajax({
                    url:'<?php echo base_url()?>index.php?/GridProduct_controller/getManufacturerslist/' + manufracturerId,
                    type:'POST',
                    dataType:'json',
                    data: { },
                }).done(function(json){  //cool126



                    console.log('manufracturer***',json);
                    // console.log('image--->',json.data[0].images[0]['image']);

                    $('#outstockProduct').hide();
                    $('#instockProduct').hide();
                    $('#bannedProduct').hide();
                    $('#rejectedProduct').hide();
                    $('#deletedProduct').hide();
                    $('#activeProduct').hide();
                    $('#gridViewDetails').hide();
                    $('#pendingProduct').hide();
                    
                    var html ="";
                    $('.categoryProduct').empty();
                        

                    html+='<div class="tab-content" id="cateProduct" >'
                    +'<div class="tab-pane padding-20 slide-left">'
                        +'<div class="row row-same-height" >';	
                    $.each(json.data,function(index,val){
                        
                        $.each(val.units,function(ind,uprice){

                        //console.log('imagedisplay--->',uprice.price.en);
                    var name=val.productname.en;	
                    html+='<div class="col-sm-3 col-lg-3">'
                        +'<div class="panel panel-info outer">'
                        +'<div class="panel-body">'
                        +'<div class="outerimagepart">'
                        +'<div class="innerimagepart" style="margin-right: -13px;">'
                        +'<div class="size"><i class="fa fa-eye viewDetails" productId="'+val._id.$oid+'"></i></div>'
                        +'<div class="size"><i class="fa fa-edit editDetails" productId="'+val._id.$oid+'"></i></div>'
                        +'<div class="size"><i class="fa fa-trash deleteDetails" productId="'+val._id.$oid+'"></i></div>'	
                        +'<input type="hidden" id="productidmodal" value="" >'
                        +'</div>'
                        +'<img src="'+val.images[0].image+'"height="200px" width="170px" class="text-center">'
                        +'</div> '
                        +'<div>'
                        +'<hr><br>'
                        +'<div class="pull-left text-concat ">'+name.substr(0,30) +'...'+'</div><br><br>'
                        +'<div class="pull-right pricetag"><p>'+currencySymbol+ uprice.price.en+'</p></div>'
                        +'<div style="clear:both"></div>'
                        +'<ul class="list-group ullist">'
                        +'<li class="list-group-item liitems" style="overflow:hidden;white-space:nowrap">'
                        +'<div class="size"><p>'+uprice.name.en+'</p></div>'
                        +'<div style="clear:both;"></div>'
                        +'</li>'
                        +'</ul>'
                        +'</div>'
                        +'</div>'
                        +'</div>'
                        +'</div>'
                        +'</div>'
                        +'</div>'
                        +'</div>';					
                                
                    
                        });

                    });

                    $('.categoryProduct').append(html);



                    // done end
                });
    
});

        $.ajax({
                url: "<?php echo base_url(); ?>index.php?/AddNewProducts/getStore",
                type: "POST",
                data: {                   
                },
                dataType: "JSON",
                success: function (result) {
                    $('#storeFilter').empty();
                    
                    if(result.data){
                        var html15 = '';
                        var html15 = '<option storeName="" value="" >Select Store</option>';
                        $.each(result.data, function (index, row) {
                            html15 = '<option value="'+row._id.$oid+'" storeName="'+row.sName.en+'" >'+row.sName.en+'</option>';                             
                            $('#storeFilter').append(html15);   
                        });

                        $('#storeFilter').multiselect({
                            includeSelectAllOption: true,
                            enableFiltering: true,
                            enableCaseInsensitiveFiltering: true,
                            buttonWidth: '100%',
                            maxHeight: 300,
                        });
                                            

                    }                    
                }
            });



        $('#addProductToStore').click(function(){

                var val = $('.checkbox:checked').map(function () {
                    return this.value;
                }).get();

                if (val.length == 0) {
                    $('#errorModal').modal('show')
                    $(".modalPopUpText").text('Please select the Product ');
                } else if (val.length >= 1)
                {
                    $('#addProductToStoreModal').modal('show');

                }          

        });

       $('#storeFilter').on('change', function () {
           

            storeId=[];
            var $this = $(this);
               if ($this.length) {
                var selVal = $this.val();

                var storeDetail = {
                    sId: selVal,               
                  }

                    storeId.push(storeDetail);
                }

            
            
       });

  
       $('#productToStore').click(function(){
           
                var sId=storeId;    
                if(sId==undefined){                    
                    $('#storeFilterErr').show();
                }else{

                    // appearing loading icon
                    $(document).ajaxStart(function () {
                       $("#productToStore").prop("disabled",true)
                       $("#loadingimg").css("display","block");
                    });

                    //$('#addProductToStoreModal').modal('show');
                    $('#storeFilterErr').hide();                    
                    var val = $('.checkbox:checked').map(function () {
                        return this.value;
                    }).get();
                    var id = sId;
                    
                    

                    $.ajax({
                        url: "<?php echo base_url('index.php?/AddNewProducts') ?>/pullProductToStore",
                        type: "POST",
                        data: {val: val, id: id},
                        dataType: 'JSON',
                        success: function (response)
                        {
                            // disapper loading icon
                            $(document).ajaxComplete(function () {
                                $("#productToStore").prop("disabled",false)
                                $("#loadingimg").css("display","none");
                            });

                            window.location.reload();
                        }

                    });
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

        <!-- <div class="brand inline" style="  width: auto;            
             color: gray;
             margin-left: 30px; margin-top:15px;padding: 15px;">

            <strong style="color:#0090d9;font-size: 11px;">FRANCHISE PRODUCTS</strong>
        </div> -->

        <div class="brand inline" style="  width: auto;">
            <?php echo str_replace('_', ' ', $pageTitle); ?> Franchise Products
        </div>

        <div id="test"></div>
        <!-- Nav tabs -->
        <!-- <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked"> -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">

            <li id= "0" class="tabs_active " style="cursor:pointer">
                <a  class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/0"><span>Pending Approval</span></a>
            </li>
            <li id= "1" class="active tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/1"><span>Approved</span></a>
            </li>
            <li id= "3" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/3"><span>Rejected</span></a>
            </li>
            <li id= "4" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/4"><span>Banned</span></a>
            </li>
            <li id= "5" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/5"><span>In Stock</span></a>
            </li>
            <li id= "6" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/6"><span>Out of Stock</span></a>
            </li>
            <li id= "2" class="tabs_active" style="cursor:pointer">
                <a   class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/2"><span>Deleted</span></a>
            </li>

            <div class="pull-right m-t-10" style="margin-top: 5px;"> <button class="btn btn-success pull-right m-t-10" id="addProductToStore">Pull to Store </button></a></div>
            <div class="pull-right m-t-10" style="margin-top: 5px;"> <button class="btn btn-danger" id="delete">Delete</button></div>
            <div class="pull-right m-t-10" style="margin-top: 5px;"> <button class="btn btn-info" id="edit">Edit</button></div>
            <div class="pull-right m-t-10" style="margin-top: 5px;"> <button class="btn btn-success pull-right m-t-10" id="add">Add </button></a></div>

            
        </ul>

        <br>
        <!-- filter for grid product -->
         <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked pyCusBt">

                <div id="gridFilter" style="display:none">
                    <div class="col-sm-2" >
                        <li>
                        
                        <select name="Category" id="category" class="form-control" style="max-width:100%;padding-left:15px" >
                        <option value="" >Select Category</option>

                    

                        <?php 
                        
                        foreach($category as $categorys){ ?>
                        
                        
                        <option value="<?php echo $categorys['_id']['$oid'] ?>" style="max-width:65%;"><?php echo $categorys['name']['0'] ?> </option>

                        <?php } ?>

                        </select>
                        </li>
                        </div>

                        <!-- sub category -->
                        <div class="col-sm-2">
                        <li>
                        
                        <select name="subCategory" id="subCategory" class="form-control" style="max-width:100%;">
                        <option selected="selected" value="">Select Sub-Category</option>
                        

                        </select>
                        </li>
                        </div>

                        <!-- Sub sub category -->
                        <div class="col-sm-2">
                        <li>
                        
                        <select name="subSubCategory" id="subSubCategory" class="form-control" style="max-width:100%;">
                        <option value="">Select Sub Sub-Category</option>
                        

                        </select>
                        </li>
                    </div>
                        <!-- brand -->
                        <div class="col-sm-2">
                        <li>
                        
                        <select name="brand" id="brand" class="form-control" style="max-width:100%;">
                        <option value="">Select Brand</option>
                        <?php 
                        
                        foreach($brand as $brands){ ?>
                        
                        <option value="<?php echo $brands['_id']['$oid'] ?>" style="max-width:65%;"><?php echo $brands['name']['en'] ?> </option>

                        <?php } ?>

                        </select>
                        </li>
                        </div>
                        <!-- manufacturer -->
                        <div class="col-sm-2">
                        <li>
                        
                        <select name="manufacturers" id="manufacturers" class="form-control" style="max-width:100%;">
                        <option value="<?php echo $categorys['_id']['$oid'] ?>" style="max-width:65%;">Select Manufacturer</option>
                        <?php 
                        
                        foreach($manufacturer as $manufacturers){ ?>
                        
                        <option value="<?php echo $manufacturers['_id']['$oid'] ?>" style="max-width:65%;"><?php echo $manufacturers['name']['en'] ?> </option>

                        <?php } ?>

                        </select>
                        </li>
                    </div>
				</div>

                <!-- lisr view -->

                      <div id="listFilter" >
                    <div class="col-sm-2" >
                        <li>
                        
                        <select name="listCategory" id="listcategory" class="form-control" style="max-width:100%;padding-left:15px" >
                        <option value="" >Select Category</option>

                    

                        <?php 
                        
                        foreach($category as $categorys){ ?>
                        
                        
                        <option value="<?php echo $categorys['_id']['$oid'] ?>" style="max-width:65%;" catName="<?php echo $categorys['name']['0'] ?>"><?php echo $categorys['name']['0'] ?> </option>

                        <?php } ?>

                        </select>
                        </li>
                        </div>

                        <!-- sub category -->
                        <div class="col-sm-2">
                        <li>
                        
                        <select name="listsubCategory" id="listsubCategory" class="form-control" style="max-width:100%;">
                        <option selected="selected" value="">Select Sub-Category</option>
                        

                        </select>
                        </li>
                        </div>

                        <!-- Sub sub category -->
                        <div class="col-sm-2">
                        <li>
                        
                        <select name="listsubSubCategory" id="listsubSubCategory" class="form-control" style="max-width:100%;">
                        <option value="">Select Sub Sub-Category</option>
                        

                        </select>
                        </li>
                    </div>
                       
                      
				</div>

                <!-- list view filter -->


                    <!-- style="border-radius: 0px;" -->
                 <div class="pull-right m-t-10 btnMrgn"> <a href="#" id="list" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon-th-list" style="margin-right:3px;">
                    </span><?php echo $this->lang->line('List'); ?></a> <a href="#" id="grid" class="btn btn-default btn-sm"><span
                        class="glyphicon glyphicon-th" style="margin-right:3px;"></span><?php echo $this->lang->line('Grid'); ?></a>
                  </div></div>

        </ul>

           
        <!-- Tab panes -->
        <!-- START JUMBOTRON -->
        <div class="parallax" data-pages="parallax">
            <div class="col-xs-12 container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="row panel panel-transparent ">

                    <div class="tab-content" id="listViewDetails">
                        <div class="col-xs-12 container-fixed-lg bg-white">
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

                                        <div class="pull-right col-xs-12"><input type="text" id="search-table" class="form-control pull-right"  placeholder="Search"> </div>
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
                
                <!-- list view end -->
                
                    <!-- grid view -->

                        <div class="tab-content" id="gridViewDetails" style="display:none">
                            <div class="tab-pane padding-20 slide-left active" id="activediv">
                                <div class="row row-same-height">
            <!-- grid view cool-->
			
			<?php

			$productcount=0;
			
			
			 foreach($products as $product ) { 

				if($product['status']==1){
					$productcount++;
					$field = FALSE;

				}

			   if($product['status']==1 && $productcount!=0){
					$field = true;
					$count=0;
					
					
				
                ?>
				<!-- cool -->
            
				<div class="col-sm-3 col-lg-3">
					<div class="panel panel-info outer">
						<div class="panel-body">
							<div class="outerimagepart">
								<div class="innerimagepart" style="margin-right: -4px;margin-top:6px">
                                <div class="size"><i class="fa fa-eye viewDetails" productId="<?php echo $product['_id']['$oid'];?>"></i></div>
                                <div class="size"><i class="fa fa-edit editDetails" productId="<?php echo $product['_id']['$oid'];?>"></i></div>
								<!-- <div class="size"><i class="fa fa-trash deleteDetails" productId="<?php echo $product['_id']['$oid'];?>"></i></div> -->
								
								</div>
								<br><br>
								<img src="<?php echo $product['images'][0]['image'];?>" height="200px" width="170px" class="text-center;img-responsive" style="margin-left: 20px;">
							</div> 
							<div>
							<hr><br>
							<div class="pull-left text-concat " style="margin-left: 10px;    margin-right: 6px;">
							 
							  
								  <?php echo substr($product['productname']['en'],0,30)."...";?>
							 
							</div><br><br>
							<div class="pull-right pricetag" style="margin-right: 9px;"><?php echo $products['currencySymbol']['currencySymbol']." ".$product['units'][0]['price']['en'];?></div>

							<div style="clear:both"></div>
								
								
								<ul class="list-group ullist">
									<li class="list-group-item liitems" style="overflow:hidden;white-space:nowrap">
									
									<?php foreach ($product['units'] as $units){ ?>

                                           <!-- cat123 -->
										  
										<div class="size" style="margin-left: 8px;"><?php echo substr($units['name']['en'],0,6);?></div>

										<?php 
											$count++;
											if ($count == 3){?>

											<div style="color:#42cbf4;cursor:pointer" class="units" productId="<?php echo $product['_id']['$oid']; ?>"><?php echo "more..";?></div>

									<?php break;	}
										
										  
									}
								?>
										<div style="clear:both;"></div>
									</li>
								</ul>
							</div>
							
						</div><!--panel body closes -->
					</div>
            	</div> <?php } }   if($field == FALSE){?>
					<ul class="nav nav-tabs bg-white" style="margin-top: 50px; text-align: center; padding: 26px;font-size: 16px;">No Data Available</ul>

				<?php } ?>  
				</div>
				</div>
			
				
			
			</div>


            <!-- category -->
	
			<div class="categoryProduct" id="categoryProduct">
				<div class="tab-content" id="cateProduct" >
								<div class="padding-20 slide-left">
									<div class="row row-same-height" id="categoryProductId">

									</div>
								</div>
				</div>			
							
			</div>

			<div class="noData" id="noData">
			</div>
	   
			


	<!-- end category -->


                    <!-- grid view end -->

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

<!-- add product to all store -->
<div id="addProductToStoreModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Store</h4>
      </div>
      <div class="modal-body">
                    <div class="form-group" class="formex" id='notesId'>
                        <label for="fname" class="col-sm-4 control-label"><?php echo "Store Name"; ?><span style="color:red;font-size: 12px"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control pull-left storeFilter" id="storeFilter" name="storeFilter[]" multiple="multiple">

                            </select> 
                        </div>

                        <!-- imahe loader -->
                          <div id="loadingimg" style="display:none; position:absolute; width:150px; height:75px;z-index:1000;top:-70%; left:44%;margin-top: 91px;" >
                                <img src="<?php echo base_url(); ?>theme/icon/loadingicon.gif" style="width:75px;height:75px;">
                          </div>

                    </div>
                    <p id="storeFilterErr" style="display:none;color:red;margin-left:191px" >Please select store</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-info" id="productToStore">Ok</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div>

  </div>
</div>



