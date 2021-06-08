<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="text/javascript" src="<?php echo base_url();?>theme/jquery.bootpag.js"></script>
	
		
		<style>
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

	


		</style>
        <script> 

		//filter click view
		$(document).on('click', '.viewDetails', function (){

			var productId = $(this).attr('productId');

			window.location.href = '<?php echo base_url();?>index.php?/GridProduct_controller/ViewProducts/' + productId;

		});

		//filter edit details
		$(document).on('click','.editDetails',function(){

			var productId = $(this).attr('productId');
                 
			window.location.href = '<?php echo base_url();?>index.php?/GridProduct_controller/EditProducts/' + productId;

		});

		//unit modal

		//filter delete details
		$(document).on('click','.deleteDetails',function(){
			

			var productId=$(this).attr('productId');

			$('#deleteYes').val(productId);
			$('#deleteModal').modal('show');

		});
		
         $(document).ready(function () {
			 
			$('#deletedProduct').hide();
			
			$('#rejectedProduct').hide();
			$('#bannedProduct').hide();
			$('#instockProduct').hide();
			$('#outstockProduct').hide();
			$('#pendingProduct').hide();
			 //tab mode
			 $('.changeMode').click(function(){

			$.ajax({
                url: $(this).attr('data'),
                type: 'GET',
                dataType: 'json',
               
            }).done(function(json) {

                console.log('MODIFIE----->',json);
			   if ( json.data != 0 ) {
					var html ="";

							$('#categoryProductId').empty();

							$.each(json.data,function(index,val){

							var unitDiv = "";

							$.each(val.units, function(index, unitData){
 
									//console.log('units----->',unitData); 
									//console.log('units detaisl---------->',unitData.name.en);
							if(unitData.name.en!='' || unitData.name.en!=null ){

									if(index<=2){
								unitDiv+='<div class="size" id="unitsproduct">'+unitData.name.en.substr(0,6)+'</div>'}
								else if(index==3){
									unitDiv+='<div style="color:#42cbf4;cursor:pointer" class="units" productId="'+val._id.$oid+'">more..</div>'
								}

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
								+'<div class="pull-right pricetag"><p>'+ val.units[0].price.en+'</p></div>'
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

			 	// cool123

			 $('.whenclicked li').click(function(){

				 if ($(this).attr('id') == "pendingapproval") {

					$('#pendingProduct').show();
					$('#deletedProduct').hide();
					$('#rejectedProduct').hide();
					$('#bannedProduct').hide();
					$('#instockProduct').hide();
					$('#outstockProduct').hide();
					$('#activeProduct').hide();
					$('.categoryProduct').hide();

				 }else if($(this).attr('id')=="active"){
					$('#activeProduct').show();

					$('#pendingProduct').hide();
					$('#deletedProduct').hide();
					$('#rejectedProduct').hide();
					$('#bannedProduct').hide();
					$('#instockProduct').hide();
					$('#outstockProduct').hide();
					$('#pendingProduct').hide();
					$('.categoryProduct').hide();

				 }else if($(this).attr('id')=="rejected"){
					$('#rejectedProduct').show();

					$('#deletedProduct').hide();
					$('#activeProduct').hide();
					$('#pendingProduct').hide();
					$('#bannedProduct').hide();
					$('#instockProduct').hide();
					$('#outstockProduct').hide();


					$('.categoryProduct').hide();
					
					 
				 }else if($(this).attr('id')=="banned"){
					$('#bannedProduct').show();

					$('#rejectedProduct').hide();
					$('#deletedProduct').hide();
					$('#activeProduct').hide();
					$('#pendingProduct').hide();
					$('#instockProduct').hide();
					$('#outstockProduct').hide();
					$('.categoryProduct').hide();
					 
				}else if($(this).attr('id')=="instock"){
					  $('#instockProduct').show();
						
						$('#bannedProduct').hide();
						$('#rejectedProduct').hide();
						$('#deletedProduct').hide();
						$('#activeProduct').hide();
						$('#pendingProduct').hide();
						$('#outstockProduct').hide();
						$('.categoryProduct').hide();
					 
				}else if($(this).attr('id')=="outstock"){
					$('#outstockProduct').show();

					$('#instockProduct').hide();
					$('#bannedProduct').hide();
					$('#rejectedProduct').hide();
					$('#deletedProduct').hide();
					$('#activeProduct').hide();
					$('#pendingProduct').hide();
					$('.categoryProduct').hide();

					 
				}else if($(this).attr('id')=="delete"){
					$('#deletedProduct').show();

				$('#activeProduct').hide();
				$('#pendingProduct').hide();
				$('#rejectedProduct').hide();
				$('#bannedProduct').hide();
				$('#instockProduct').hide();
				$('#outstockProduct').hide();
				$('.categoryProduct').hide();

					 
				}	


			 });




			//view product details
             $('.viewDetails').click(function(){
				
                 var productId = $(this).attr('productId');

           		window.location.href = '<?php echo base_url();?>index.php?/GridProduct_controller/ViewProducts/' + productId;

             });

              $('.editDetails').click(function(){
                 var productId = $(this).attr('productId');
                 
                window.location.href = '<?php echo base_url();?>index.php?/GridProduct_controller/EditProducts/' + productId;
             });

			 //delete modal
			 $('.deleteDetails').click(function(){

				 var productId=$(this).attr('productId');

				 $('#deleteYes').val(productId);
				 $('#deleteModal').modal('show');

			});

			 //confirmation delete
			 $('#deleteYes').click(function(){

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

			 });
			
			 //units modal
			 $(document).on('click', '.units', function (){
			//  $('.units').click(function(){
			 var productId=$(this).attr('productId');
			

			 		$.ajax({
						url: '<?php echo base_url();?>index.php?/GridProduct_controller/getUnitDetails/' + productId,
						type: 'POST',
						dataType: 'json',
						data: { },
						
					})
					.done(function(json) {
						console.log('units details----------->',json);
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
									+'<label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">$'+val.price.en+'</label>'
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

			//category onchange
			$('#category').change(function(){

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
					$('#pendingProduct').hide();
					$('.noData').hide();

				    if ( json.data != 0 ) {

					var html ="";

							$('#categoryProductId').empty();

							$.each(json.data,function(index,val){
									//console.log('units data',val);
							var unitDiv = "";
							$.each(val.units, function(index, unitData){

								if(index<=2){
								unitDiv+='<div class="size" id="unitsproduct">'+unitData.name.en.substr(0,6)+'</div>'}
								else if(index==3){
									unitDiv+='<div style="color:#42cbf4;cursor:pointer" class="units" productId="'+val._id.$oid+'">more..</div>'
								}

								//unitDiv+='<div class="size" id="unitsproduct">'+unitData.name.en+'</div>'
							})
								
							var name=val.pName.en;

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
								+'<div class="pull-right pricetag"><p>'+ val.units[0].price.en+'</p></div>'
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
								+'<div class="pull-right pricetag"><p>'+ val.units[0].price.en+'</p></div>'
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
			// end sub category

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
								
							var name=val.pName.en;

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
								+'<div class="pull-right pricetag"><p>'+ val.units[0].price.en+'</p></div>'
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

			// end sub-sub cat

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
					$('#pendingProduct').hide();
					
					var html ="";
					$('.categoryProduct').empty();
						

					html+='<div class="tab-content" id="cateProduct" >'
		+'<div class="tab-pane padding-20 slide-left">'
        	+'<div class="row row-same-height" >';	
					$.each(json.data,function(index,val){
						
						$.each(val.units,function(ind,uprice){

						//console.log('imagedisplay--->',uprice.price.en);
					var name=val.pName.en;
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
						  +'<div class="pull-right pricetag"><p>'+uprice.price.en+'</p></div>'
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

			// end brand

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
					$('#pendingProduct').hide();
					
					var html ="";
					$('.categoryProduct').empty();
						

					html+='<div class="tab-content" id="cateProduct" >'
					+'<div class="tab-pane padding-20 slide-left">'
						+'<div class="row row-same-height" >';	
					$.each(json.data,function(index,val){
						
						$.each(val.units,function(ind,uprice){

						//console.log('imagedisplay--->',uprice.price.en);
					var name=val.pName.en;	
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
						  +'<div class="pull-right pricetag"><p>'+uprice.price.en+'</p></div>'
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
			// end

			

         });

		 

		
        </script>
		
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script> -->
	</head>
	<body>
	<div class="brand inline" style="  width: auto;
                        font-size: 16px;
                        color: gray;
                        margin-left: 7px;padding-top: 45px;padding-bottom:10px;">

                        <strong style="color:#0090d9;">GRID PRODUCTS </strong><!-- id="define_page"-->
                   </div>
		<div class="container">
        <!-- header -->
                   

        <ul class="nav nav-tabs bg-white whenclicked">

		 					<!-- cool123 -->
							<li id= "pendingapproval" class="tabs_active <?php //echo $reject ?>" style="cursor:pointer">
                                <a data-toggle="tab" href="#deletediv" class="changeMode pending_" id="tabpending"  data="<?php echo base_url(); ?>index.php?/GridProduct_controller/productGridDisplay/0">
                                    <span>PENDING APPROVAL</span>
                                </a>
                            </li>
                           
                            <!-- <li id= "active" class="tabs_active active<?php //echo $accept ?>" style="cursor:pointer">
                                <a  data-toggle="tab" href="#activediv" class="changeMode accepted_" id="tabactive" data="1">
                                    <span>APPROVED</span>
                                </a>
                            </li> -->
							

							<li id= "active" class="tabs_active active<?php //echo $accept ?>" style="cursor:pointer">
                                <a  data-toggle="tab" href="#activediv" class="changeMode accepted_" id="tabactive" data="<?php echo base_url(); ?>index.php?/GridProduct_controller/productGridDisplay/1">
                                    <span>APPROVED</span>
                                </a>
                            </li>
                            
                            

						 <li id= "rejected" class="tabs_active <?php //echo $reject ?>" style="cursor:pointer">
                                <a data-toggle="tab" href="#deletediv" class="changeMode rejected1_" id="tabrejected"  data="<?php echo base_url(); ?>index.php?/GridProduct_controller/productGridDisplay/3">
                                    <span>REJECTED</span>
                                </a>
                            </li>

							<li id= "banned" class="tabs_active <?php //echo $reject ?>" style="cursor:pointer">
                                <a data-toggle="tab" href="#deletediv" class="changeMode banned_" id="tabbanned"  data="<?php echo base_url(); ?>index.php?/GridProduct_controller/productGridDisplay/4">
                                    <span>BANNED</span>
                                </a>
                            </li>

							<li id= "instock" class="tabs_active <?php //echo $reject ?>" style="cursor:pointer">
                                <a data-toggle="tab" href="#deletediv" class="changeMode instock_" id="tabinstock"  data="<?php echo base_url(); ?>index.php?/GridProduct_controller/productGridDisplay/5">
                                    <span>IN STOCK</span>
                                </a>
                            </li>

							<li id= "outstock" class="tabs_active <?php //echo $reject ?>" style="cursor:pointer">
                                <a data-toggle="tab" href="#deletediv" class="changeMode outstock_" id="taboutofstock"  data="<?php echo base_url(); ?>index.php?/GridProduct_controller/productGridDisplay/6">
                                    <span>OUT OF STOCK</span>
                                </a>
                            </li>

							

							<li id= "delete" class="tabs_active <?php //echo $reject ?>" style="cursor:pointer;display:none">
                                <a data-toggle="tab" href="#deletediv" class="changeMode rejected_" id="tabdeleted"  data="<?php echo base_url(); ?>index.php?/GridProduct_controller/productGridDisplay/2">
                                    <span>DELETED</span>
                                </a>
                            </li>

		 					 <div class="pull-right m-t-10"><a href="<?php echo base_url() ?>index.php?/AddNewProducts/addNewProduct"> <button class="btn btn-success pull-right m-t-10 cls110" id="add" style="font-size:10px !important;">Add </button></a></div>
							 
                           
                            <!-- <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10" id="delete" style="border-radius:50px">ADD </button></a></div>
                            <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10" id="inactivate" style="border-radius:50px">DELETE </button></a></div> -->
                           
         </ul>    

		   <ul class="nav nav-tabs bg-white " style="margin-top:10px;padding:5px;">
            <div class="col-sm-12 col-md-12">
			<div class="col-sm-2">
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



		   </ul>
		
									
			
			<div class="tab-content" id="activeProduct">
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
								<div class="innerimagepart" style="margin-right: -13px;">
                                <div class="size"><i class="fa fa-eye viewDetails" productId="<?php echo $product['_id']['$oid'];?>"></i></div>
                                <div class="size cls111"><i class="fa fa-edit editDetails" productId="<?php echo $product['_id']['$oid'];?>"></i></div>
								<div class="size  cls111"><i class="fa fa-trash deleteDetails" productId="<?php echo $product['_id']['$oid'];?>"></i></div>
								
								</div>
								<br><br>
								<img src="<?php echo $product['images'][0]['image'];?>" height="200px" width="170px" class="text-center;img-responsive">
							</div> 
							<div>
							<hr><br>
							<div class="pull-left text-concat ">
							 
							  
								  <?php echo substr($product['pName']['en'],0,30)."...";?>
							 
							</div><br><br>
							<div class="pull-right pricetag"><?php echo "$"." ".$product['units'][0]['price']['en'];?></div>

							<div style="clear:both"></div>
								
								
								<ul class="list-group ullist">
									<li class="list-group-item liitems" style="overflow:hidden;white-space:nowrap">
									
									<?php foreach ($product['units'] as $units){ ?>

                                           <!-- cat123 -->
										  
										<div class="size"><?php echo substr($units['name']['en'],0,6);?></div>

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
		</div>

<!--**************************************************************************************************************  -->
					<div class="bs-docs-example">
								<p class="demo demo2"></p>
					</div>
							
		<script type="text/javascript">							
							$('.demo2').bootpag({
							total: <?php echo $productCount?>,
							page: 1,
							maxVisible: 5
							}).on('page', function(event, num){							 
	
				$.ajax({
						url:'<?php echo base_url()?>index.php?/GridProduct_controller/get_productPagination/' + num,
						type:'POST',
						dataType:'json',
						data: { },

						}).done(function(json){			
							$('#outstockProduct').hide();
							$('#instockProduct').hide();
							$('#bannedProduct').hide();
							$('#rejectedProduct').hide();
							$('#deletedProduct').hide();
							$('#activeProduct').hide();
							$('#pendingProduct').hide();
							$('.noData').hide();
								
							if ( json.data != 0 ) {
							var html ="";
									$('#categoryProductId').empty();
									$.each(json.data,function(index,val){									
									var unitDiv = "";
									$.each(val.units, function(index, unitData){
										if(unitData.name.en!=""){
										   if(index<=2){
											  unitDiv+='<div class="size" id="unitsproduct">'+unitData.name.en.substr(0,6)+'</div>'}
										   else if(index==3){
											unitDiv+='<div style="color:#42cbf4;cursor:pointer" class="units" productId="'+val._id.$oid+'">more..</div>'
										   }	
										}else{
											unitDiv+='<div class="size" id="unitsproduct">No Units available</div>'
										}
																	
									})								
									var name=val.pName.en;
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
										+'<div class="pull-right pricetag"><p>'+ val.units[0].price.en+'</p></div>'
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
							
						</script> 
	<!-- ****************************************************************************************************************** -->


		<script>
			$(function(){
				$('#icon').click(function(){
					$("#icon").toggleClass('activealert');
				})
			});
		</script>

		<!-- modal for view -->
							
					<div class="modal fade" id="myModal" role="dialog">
						<div class="modal-dialog">
						
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Unit Details</h4>
							</div>

						<!-- <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
							<li class="active tabs_active" id="firstlitab">
							<a data-toggle="tab" href="#tab1" id="tb1"><i id="tab1icon" class=""></i> <span>Details</span></a>
							</li>
							
						</ul> -->
						
						<div class="modal-body">
							<br>
							<div class="tab-content">
								<div class="tab-pane padding-20 slide-left active" id="tab1">
									<div class="row row-same-height">
										<div class="row">
										<div class="col-sm-12">
										<div class="col-sm-6">
												<div class="form-group row" style="  margin-left: 7%;">
													<label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name" style="color:#42b3f4">Unit Name</label>
													<div class="col-md-6 col-sm-6 col-xs-6">
														<span style="" class="dname"></span>
													</div>

												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group row" style="  margin-left: 7%;">
													<label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name" style="color:#42b3f4">Price</label>
													<div class="col-md-6 col-sm-6 col-xs-6">
														<span style="" class="dname"></span>
													</div>

												</div>
											</div>
										</div>
										<hr/>
										<div class="unitDetails" id="unitDetails"></div>
										
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
		<!-- end of modal view -->

		<!-- deletet model -->
				  <!-- Modal -->
					<div class="modal fade" id="deleteModal" role="dialog">
						<div class="modal-dialog">
						
						
						<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Confirmation</h4>
						</div>
							<div class="modal-body">
							<p>Are you sure you want to delete it?</p>
							</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" id="deleteYes"  >Yes</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
						
						</div>
					</div>
		<!-- end delete -->
	</body>
	
</html>
<!-- <script>

$('#category').multiselect({
                            includeSelectAllOption: true,
                            enableFiltering: true,
                            enableCaseInsensitiveFiltering: true,
                            buttonWidth: '500px',
                            maxHeight: 300,
                        });
</script> -->