
<?php if ($this->session->flashdata('message')) { ?>
    <div align="center" id="flashdata" class="alert alert-danger">      
        <?php echo $this->session->flashdata('message') ?>
    </div>
<?php } ?>
<link href="<?php echo base_url(); ?>css/products.css" rel="stylesheet">
<style>
    .btn{
        font-size: 10px !important;
    }
    .dataTables_scrollHead{
        margin-bottom: -52px !important;
    }
    .textDec{
        text-decoration: underline !important;  
    }
</style>
<script>
function callDatatable(){
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/StoreProductDetails/1',
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
    $(document).ready(function () {
		
		$('#import').click(function(){
			$('#importDataFromFile').val("");
            $('#url').val("");
			$('#importmodal').modal('show');
		});
		
		$('#uploadFileData').click(function(){
                var url = $("#url").val();
                var currentdate = new Date();
				var currentDate  = currentdate.getFullYear() + "-" + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
                var d = new Date();
				var n = d.getTime();
                var parentProductId = "";
                var createdTimestamp = n;
                var storeId = "<?php echo $storeId;?>";
                var cityId = "<?php echo $storeData['cityId'];?>";
                var storeLatitude = "<?php echo $storeData['coordinates']['latitude'];?>";
                var storeLongitude = "<?php echo $storeData['coordinates']['longitude'];?>";
                var zoneId5 = <?php echo json_encode($storeData['serviceZones']);?>;
                var storeName = "<?php echo $storeData['sName']['en'];?>";
                var storeAverageRating = "<?php echo $storeData['averageRating'];?>";
                if(!storeAverageRating)
                    {
						var storeAverageRating = "";
					}

                 $('#importmodal').modal('hide');
                if(url=="" || url == null){

			    var file_data = $('#importDataFromFile').prop('files')[0];
                if(file_data){
                var fileName1 = file_data.name;
				// console.log(fileName1);
				// var barcode = $("input[type=radio]:checked").val();
				var form_data = new FormData();
			
                form_data.append('OtherPhoto', file_data);
              
                form_data.append('type', 'uploadImage');
                form_data.append('Image', 'Image');
                form_data.append('folder', 'productXLSImport');
                // $(document).ajaxStart(function () {
                //         $('#importmodal').modal('hide');
                //         $("#loadingModal").modal('show')
                //     });
				 $.ajax({
                    url: "<?php echo base_url('index.php?/Common') ?>/uploadImagesToAws",
                    type: "POST",
                    data: form_data,
					dataType: "json",
                    processData: false,
					contentType: false,
                    success: function (result) {

                        if (result) {
                            var fileURL = result.fileName;
							
                            $.ajax({
                                url: '<?php echo ProductOffers ?>bulkImport_xlsx/',
                                type: 'POST',
								contentType: "application/json",
                               data:JSON.stringify({fileURL:fileURL,importType:1,currentDate:currentDate,createdTimestamp:createdTimestamp,parentProductId:parentProductId,cityId:cityId,
							   storeId:storeId,storeName:storeName,storeLatitude:storeLatitude,storeLongitude:storeLongitude,zoneId:zoneId5,storeAverageRating:storeAverageRating}),
                                dataType: 'JSON',
                                success: function (response, textStatus, xhr)
                                {
                                //     $(".modalPopUpText").empty();
									
                                //     $(document).ajaxComplete(function() {
                                //         $("#loadingModal").modal('hide')
                                //     });
								// 	if(xhr.status == 200){
								// 	$('#importmodal').modal('hide');
									
								// 	 callDatatable();
								// 	var resData='<div class="container">'
                                //     +'<div class="col-sm-12">'
                                //     +'<div class="col-sm-4">Success:</div><div class="col-sm-4">'+response.success.toString()+'</div></div>'
                                //     +'<div class="col-sm-12">'
                                //     +'<div class="col-sm-4">Repeated:</div><div class="col-sm-4">'+response.repeated.toString()+'</div></div>'
                                //     +'<div class="col-sm-12">'
                                //     +'<div class="col-sm-4">Failed:</div><div class="col-sm-4">'+response.failed.toString()+'</div></div>'
                                //     +'<div>';
                                //     //$(".modalPopUpText").text('Successfully Added...');
                                //     $(".modalPopUpText").append(resData);
                                //     $('#errorModal').modal('show')
                                // }
                                // else{
                                //         $(".modalPopUpText").text("Internal Server Error..."+xhr.status);
                                //         $('#errorModal').modal('show');
                                //     }
							},
							// error: function (error) {
                            //     $(document).ajaxComplete(function() {
                            //             $("#loadingModal").modal('hide')
                            //     });
							// 	    $('#importmodal').modal('hide');
							// 		$(".modalPopUpText").text("Invalid File Format");
                            //         $('#errorModal').modal('show');  
                            //     },
                               
							});
						}
					}
				 });
                    }
                        else{
                            $('#importmodal').modal('hide');
                            $(".modalPopUpText").text("Please upload spredsheet file only");
                            $('#errorModal').modal('show'); 
                        }
                    }
                    else{
                            var barcode = 1;
                            var fileURL = url;
                            var checkName =fileURL.split(".")[1];
                            if(checkName == "google"){
                            // $(document).ajaxStart(function () {
                            //     $('#importmodal').modal('hide');
                            //     $("#loadingModal").modal('show')
                            // });
                         $.ajax({
                                url: '<?php echo ProductOffers ?>bulkImport_xlsx/',
                                type: 'POST',
								contentType: "application/json",
                               data:JSON.stringify({fileURL:fileURL,importType:1,currentDate:currentDate,createdTimestamp:createdTimestamp,parentProductId:parentProductId,cityId:cityId,
							   storeId:storeId,storeName:storeName,storeLatitude:storeLatitude,storeLongitude:storeLongitude,zoneId:zoneId5,storeAverageRating:storeAverageRating}),
                                dataType: 'JSON',
                                success: function (response, textStatus, xhr)
                                {
                                //     $(".modalPopUpText").empty();
                                //     $(document).ajaxComplete(function() {
                                //         $("#loadingModal").modal('hide')
                                //     });
								// 	if(xhr.status == 200){
								// 	$('#importmodal').modal('hide');
									
								// 	 callDatatable();
								// 	var resData='<div class="container">'
                                //     +'<div class="col-sm-12">'
                                //     +'<div class="col-sm-4">Success:</div><div class="col-sm-4">'+response.success.toString()+'</div></div>'
                                //     +'<div class="col-sm-12">'
                                //     +'<div class="col-sm-4">Repeated:</div><div class="col-sm-4">'+response.repeated.toString()+'</div></div>'
                                //     +'<div class="col-sm-12">'
                                //     +'<div class="col-sm-4">Failed:</div><div class="col-sm-4">'+response.failed.toString()+'</div></div>'
                                //     +'<div>';
                                //     //$(".modalPopUpText").text('Successfully Added...');
                                //     $(".modalPopUpText").append(resData);
                                //     $('#errorModal').modal('show')
                                // }
                                // else{
                                //         $(".modalPopUpText").text("Internal Server Error..."+xhr.status);
                                //         $('#errorModal').modal('show');
                                //     }
							},
							// error: function (error) {
                            //     $(document).ajaxComplete(function() {
                            //             $("#loadingModal").modal('hide')
                            //     });
							// 	    $('#importmodal').modal('hide');
							// 		$(".modalPopUpText").text("Invalid File Format");
                            //         $('#errorModal').modal('show');  
                            // }
							});
                        }
                        else{
                            $('#importmodal').modal('hide');
                            $(".modalPopUpText").text("Please enter google doc spredsheet url only");
                            $('#errorModal').modal('show');  
                        }
                    }
			
			
		});
       $('.products').addClass('active');
      
        $('#big_table_processing').show();

        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        var settings = {
            "scrollX": true,
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
                $('#big_table').fadeIn('slow');
                $('#big_table_processing').hide();
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
            "aoColumns": [
                {"sWidth": "5%"},
                 {"sWidth": "15%"},
                {"sWidth": "15%"},
                {"sWidth": "15%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"}

            ]
        };
        table.dataTable(settings);
        // search box for table

        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

        $('#downloadFile').click(function () {
            $('#downloadModal').modal('show');

        });

        $('#complete').click(function () {
            setTimeout(function () {
                $('#downloadModal').modal('hide');
            }, 3000);
        });

        $('#edit').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length < 0 || val == '') {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Please select the Product');
//                alert('Inavalid Selection');
            } else if (val.length > 1) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Please select only one Product');
            }
            if (val.length == 1) {
                window.location.href = '<?php echo base_url(); ?>index.php?/AddNewProducts/EditProducts/' + val;
            }

        });
        $('#big_table').on("click", '.viewDetailedDescriptionlist', function () {
            $('#descriptionData').empty();
            var id = $(this).attr('id');

            console.log(id);
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/Uflyproducts/viewDescriptionlist/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';

                    html = '<p>' + result.data + '</p>';

                    $('#descriptionData').append(html);
                    $('#viewDescriptionlist').modal('show');
                }

            });

        });
        $('#big_table').on("click", '.viewShortDescriptionlist', function () {
            $('#shortDescriptionData').empty();
            var id = $(this).attr('id');

            console.log(id);
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/Uflyproducts/viewShortDescriptionlist/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';

                    html = '<p>' + result.data + '</p>';

                    $('#shortDescriptionData').append(html);
                    $('#viewShortDescriptionlist').modal('show');
                }

            });

        });
        $('#big_table').on("click", '.unitListForStoreProducts', function () {

            $('#unitListData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/Uflyproducts/getUnitsForStore/' + id,
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
        setTimeout(function () {
            $('#flashdata').hide();
        }, 3000);


        $("#confirmed1").click(function () {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
          
            var id = $('#checkboxProduct').attr('data-id')
            console.log('value--------',val);
            console.log('id-------',id);
            $.ajax({
                url: "<?php echo base_url('index.php?/AddNewProducts') ?>/delete_product",
                type: "POST",
                data: {val: val, id: id},
                dataType: 'JSON',
                success: function (response)
                {
                    window.location.reload();
                }

            });

        });

        $('#big_table').on("click", '.reviewlist', function () {
            $('#review_data').empty();
            var id = $(this).attr('id');

            console.log(id);
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/Uflyproducts/reviewlist/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr><td>' + k + '</td><td>' + row.Product_Name + '</td><td>' + row.Manufacturer + '</td><td>' + row.Model + '</td><td>' + row.Description + '</td><tr>';
                        k++;
                    });
                    $('#review_data').append(html);
                    $('#reviewlist').modal('show');
                }

            });

        });

        $('#myCarousel').carousel({
            pause: true,
            interval: false,

        });

        $('#big_table').on("click", '.imglist', function () {
            $('#imagedata').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/Uflyproducts/imagelist/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    console.log(result.data);
                    var imglength = Object.keys(result.data).length;
                    console.log(imglength);

                    if (result.data != null || result.data != '') {

                        var html1 = '';
                        var html2 = '';
                        var img = '';
                        var k = 1;

                        for (var i = 0; i < imglength; i++) {
//                             console.log(result.data[i]['imageid']);
//                             
                            html1 = '<li data-target="#myCarousel" id="myCarousel' + i + '"></li>';

                            if (result.data[i]['mobile'] != "") {
                                img = '<img src="' + result.data[i]['mobile'] + '" class="img-thumbnail" alt="" width="400" height="100"></div>'
                            } else {
                                img = '<img src="<?php echo base_url() ?>pics/user.jpg" class="img-thumbnail" alt="" width="250" height="100"></div>'
                            }
//                                  
                            html2 = '<div class="item" id="imagedata' + i + '">'
                                    + '<div class="col-sm-12">'
                                    + '<div class="col-sm-6">'

                                    + '<div class="col-sm-12" id="imagedata' + i + '">'
                                    + img
                                    + '<div class="col-sm-8"><label class="control-label" style="color:blue;">Alt-Text</label><input type="text" id="imgText' + i + '" class="form-control" value="' + result.data[i]['imageText'] + '"></div>'
                                    + '<div class="col-sm-4"><label class="control-label"></label><button class="btn btn-primary" imageid="' + result.data[i]['imageId'] + '" data-id = "' + id + '" id="imgTextBtn' + i + '" style="margin-top:25px;" onclick="savealltext(' + i + ')">Save</div>'

                                    + '<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">'
                                    + '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>'
                                    + '<span class="sr-only">Previous</span>'
                                    + '</a>'
                                    + '<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">'
                                    + '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
                                    + '<span class="sr-only">Next</span>'
                                    + '</a>'
                                    + '</div>'


                                    + '<div class="col-sm-6"  id="seodata' + i + '">'
                                    + '<div class="col-sm-12"><label class="control-label ">Seo-Title</label>'
                                    + '<input type="text" class="form-control seoTitle' + i + '" id="title' + i + '" value="' + result.data[i]['title'] + '"></div>'
                                    + '<div class="col-sm-12"><label class="control-label ">Seo-Description</label>'
                                    + '<input type="text" class="form-control seoDescription' + i + '" id="description' + i + '" value="' + result.data[i]['description'] + '"></div>'
                                    + '<div class="col-sm-12"><label class="control-label ">Seo-Keyword</label>'
                                    + '<input type="text" class="form-control seoKeyword' + i + '" id="keyword' + i + '" value="' + result.data[i]['keyword'] + '"></div>'
                                    + '</div>'
                                    + '</div>'

                                    + '<br/>'
                                    + '<br/>'
                                    + '<hr/>';

                            $('#indicator').append(html1);
                            $('#imagedata').append(html2);
                            $('#imagedata0').addClass('active');

                        }

                        $('#imagelist').modal('show');

                    } else {
                        $('#imagelist').modal('show');
                        $('#imagedata0').text('Sorry, No images to view');

                    }
                }
            });
        });

        $('#close1').click(function () {

            $('#indicator').html("");
            $('#imagedata').html("");
            window.location.reload();
        });

        $('#big_table').on("click", '.strainEffects', function () {

            $('#strainEffectsData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/Uflyproducts/strainEffects/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr style="font-size:14px;"><td style="text-align:center;width:200px;border-style: ridge;">' + i + '</td><td style="border-style: ridge;width:200px;text-align:center;">' + result.data[i] + ' %</td></tr><br/><br/>';

                        $('#strainEffectsData').append(html);
                    });
                    $('#strainEffectsList').modal('show');
                }
            });
        });
        $('#big_table').on("click", '.medicalAttributes', function () {

            $('#medicalAttributesData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/Uflyproducts/medicalAttributes/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr style="font-size:14px;"><td style="text-align:center;width:200px;border-style: ridge;">' + i + '</td><td style="border-style: ridge;width:200px;text-align:center;">' + result.data[i] + '%</td></tr><br/><br/>';

                        $('#medicalAttributesData').append(html);
                    });
                    $('#medicalAttributesList').modal('show');
                }

            });
        });
        $('#big_table').on("click", '.negativeAttributes', function () {

            $('#negativeAttributesData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/Uflyproducts/negativeAttributes/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr style="font-size:14px;"><td style="text-align:center;width:200px;border-style: ridge;">' + i + '</td><td style="border-style: ridge;width:200px;text-align:center;">' + result.data[i] + '%</td></tr><br/><br/>';

                        $('#negativeAttributesData').append(html);
                    });
                    $('#negativeAttributesList').modal('show');
                }

            });
        });
        $('#big_table').on("click", '.flavours', function () {

            $('#flavoursData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/Uflyproducts/flavours/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr style="font-size:14px; "><td style="text-align:center;width:200px;border-style: ridge;">' + i + '</td><td style="border-style: ridge;width:200px;text-align:center;">' + result.data[i] + '</td></tr>';

                        $('#flavoursData').append(html);
                    });
                    $('#flavoursList').modal('show');
                }

            });
        });
        $('#big_table').on("click", '.nutrilist', function () {

            $('#nutritiondata').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/Uflyproducts/nutrilist/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr style="font-size:14px;"><td>' + result.data[i] + '</td></tr>';

                        $('#nutritiondata').append(html);
                    });
                    $('#nutritionlist').modal('show');
                }
            });
        });

        $('.changeMode').click(function () {

            var table = $('#big_table');
            $('.cs-loader').show();
            $('#big_table').fadeOut('slow');
            $('#big_table_processing').show();

            var settings = {
                "scrollX": true,
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
                },
            "aoColumns": [
                {"sWidth": "5%"},
                {"sWidth": "15%"},
                {"sWidth": "15%"},
                {"sWidth": "15%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"},
                {"sWidth": "5%"}
            ]
            };

            $('.tabs_active').removeClass('active');

            $(this).parent().addClass('active');

            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });

        });

    });

    function savealltext(i) {

        var id = $('#imgTextBtn' + i).attr('data-id');
        var imageid = $('#imgTextBtn' + i).attr('imageid');
        var imgText = $('#imgText' + i).val();
        var title = $('#title' + i).val();
        var description = $('#description' + i).val();
        var keyword = $('#keyword' + i).val();

        if (title.trim() == "") {
            title = imgText;
            $('#title' + i).val(title);
        }

        if (keyword.trim() == "") {
            keyword = description.replace(" ", ",");
        } else {
            keyword = keyword.replace(" ", ",");
        }
        $('#keyword' + i).val(keyword);

        $.ajax({
            url: "<?php echo base_url() ?>index.php?/Uflyproducts/savealltext",
            type: "POST",
            data: {imgText: imgText, title: title, description: description, keyword: keyword, id: id, imageid: imageid, seq: i},
            success: function (result) {

            }
        });

    }


    function moveUp(id) {
        var row = $(id).closest('tr');
        var prev_id = row.prev('tr').find('.moveUp').attr('id')
        var curr_id = row.find('.moveUp').attr('id');
        if (typeof (prev_id) == 'undefined') {
            $('#errorModal').modal('show')
            $(".modalPopUpText").text('Not able to move up');
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/AddNewProducts/reorderProducts",
                type: "POST",
                data: {kliye: 'interchange', curr_id: curr_id, prev_id: prev_id},
                success: function (result) {

                }
            });
            row.prev().insertAfter(row);
            $('#saveOrder').trigger('click');
        }
    }
    function moveDown(id) {

        var row = $(id).closest('tr');
        var prev_id = row.find('.moveDown').attr('id');
        var curr_id = row.next('tr').find('.moveDown').attr('id');
        if (typeof (curr_id) == 'undefined') {
            $('#errorModal').modal('show')
            $(".modalPopUpText").text('Not able to move down');
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/AddNewProducts/reorderProducts",
                type: "POST",
                data: {kliye: 'interchange', prev_id: prev_id, curr_id: curr_id},
                success: function (result) {

                }
            });
            row.insertAfter(row.next());
            $('#saveOrder').trigger('click');
        }
    }

                $(document).ready(function(){

$('#big_table').on('init.dt', function () {

     var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
     var status = urlChunks[urlChunks.length - 1];
     var forwhat = urlChunks[urlChunks.length - 2];

     if (status == 0 || status == 1 ||  status == 2 || status == 3 || status == 4 || status == 5 || status == 6   ) {
         console.log('pass1');
        $('#big_table').dataTable().fnSetColumnVis([8,9,10,11,12], false);
         $('#add').show();
        $('#delete').show();
        $('#import').show();

    }
 
    if (status == 8) {
        console.log('pass8');
       $('#big_table').dataTable().fnSetColumnVis([1,2,3,4,5,6,7], false);
       
        $('#add').hide();
        $('#delete').hide();
        $('#import').hide();
 

    }

     });

});
</script>

<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 8px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 16px;">Products</strong>
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked">

            <li id= "0" class="tabs_active " style="cursor:pointer;display:none">
                <a  class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/0"><span>Pending Approval</span></a>
            </li>
            <li id= "1" class="active tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/1"><span>ALL PRODUCTS</span></a>
            </li>
            <li id= "3" class="tabs_active" style="cursor:pointer;display:none">
                <a  class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/3"><span>Rejected</span></a>
            </li>
            <li id= "4" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/4"><span>Banned</span></a>
            </li>
            <li id= "5" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/6"><span>In Stock</span></a>
            </li>
            <li id= "6" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/5"><span>Out of Stock</span></a>
            </li>
            <li id= "2" class="tabs_active" style="cursor:pointer">
                <a   class="changeMode" data="index.php?/AddNewProducts/StoreProductDetails/2"><span>Deleted</span></a>
            </li>
            <li id="8"  class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/AddNewProducts/StoreProductDetails/8" ><span>List</span> </a>
            </li>

            <div class="pull-right m-t-10"> <button class="btn btn-danger" id="delete">Delete</button></div>
		<div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10" id="import">Import</button></a></div>
            <div class="pull-right m-t-10"> <button class="btn btn-info" id="edit">Edit</button></div>
            <!--  <div class="pull-right m-t-10"> <button class="btn btn-primary" data-toggle="modal" data-target="#importmodal">Import File</button></div> -->
            <div class="pull-right m-t-10"><a href="<?php echo base_url() ?>index.php?/AddNewProducts/addNewProduct"> <button class="btn btn-success pull-right m-t-10" id="add">Add </button></a></div>
            <!-- <div class="pull-right m-t-10"> <button class="btn btn-info btnClass" id="downloadFile" name="downloadFile" style="width: 125px;">Download Sample</button></div> -->
        </ul>
        <!-- Tab panes -->
        <div class="" data-pages="parallax">
            <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="panel panel-transparent " style="margin-left: -20px;margin-right: -50px;">

                    <div class="tab-content">
                        <div class="container-fluid container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="error-box" id="display-data" style="text-align:center; color: red;"></div>
                                    <div class="searchbtn row clearfix pull-right" style="margin-right: 0%;">

                                        <div class=""><input type="text" id="search-table" class="form-control pull-right" style="text-transform: capitalize;" placeholder="<?php echo SEARCH; ?>"> </div>
                                    </div>
                                    <div class="dltbtn">
                                    </div>
                                </div>
                                &nbsp;

                                <div class="container">
                                    <div class="row clearfix">
                                        <div class="col-md-12 column">
                                            <?php echo $this->table->generate(); ?>
                                        </div>
                                    </div>
                                </div>

                                <!--  <div class="col-md-12">
                                     
                                 <div class="col-md-12 panel-body">
                                <?php echo $this->table->generate(); ?>
 
                                 </div>
                                 </div> -->
                            </div>
                            <!-- END PANEL -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->

        <!-- END PAGE CONTENT -->
    </div>





    <div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <div class=" clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                    </div>
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




<div class="modal fade stick-up" id="reviewlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 180%;margin-left: -26%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Review List</h4>
            </div>
            <div class="modal-body form-horizontal">

                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    <th style="width :72px !important;" >SL NO</th>
                    <th style="width :72px !important;" >CUSTOMER NAME</th>
                    <th style="width :72px !important;">CUSTOMER ID</th>
                    <th style="width :72px !important;">RATING</th>
                    <th style="width :50px !important;">REVIEW</th>
                    </thead>
                    <tbody id="review_data">
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<div class="modal fade stick-up" id="imagelist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 180%;margin-left: -26%;">
            <button type="button" class="close"  data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" id="close1" class="close" data-dismiss="modal">&times;</button>
                <h4>Image List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container">

                        <div id="myCarousel" class="carousel slide" data-ride="carousel" >
                            <!-- Indicators -->

                            <ol class="carousel-indicators" style="left: 47%;" id='indicator'>

                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox" id='imagedata'>

                            </div>

                        </div>

                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>




<!--<div class="modal fade stick-up" id="imagelist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 180%;margin-left: -26%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Image List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="imagedata">
                    </div>
                    </tbody>
                </table>
            </div>
             /.modal-content 
        </div>
         /.modal-dialog 
    </div>
</div>-->



<div class="modal fade stick-up" id="nutritionlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Nutrition List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="nutritiondata">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="flavoursList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Flavours List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="flavoursData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="negativeAttributesList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Negative Attributes List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="negativeAttributesData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="medicalAttributesList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Medical Attributes List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="medicalAttributesData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="strainEffectsList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Strain Effects List</h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    </thead>
                    <tbody >
                    <div class="container" id="strainEffectsData">
                    </div>
                    </tbody>
                </table>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>



<div id="importmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import Data</h4>
      </div>
      <div class="modal-body">
	   
       <div class="form-group">
       <input type="file" name="file"  id="importDataFromFile"  class="form-control"/>
       </div>
       <div class="form-group">
       <!-- <label for="url">URL</label> -->
        <input type="url" name="url" id="url" class="form-control" placeholder="Enter Google Docs url">
       </div>
      </div>
      <div class="modal-footer">
	  <div class="col-sm-4">
	   <a href="https://s3.amazonaws.com/loopzadmin/uploadImage/productXLSImport/file201895132133.xlsx" download><button class="btn btn-info pull-left" style="width:140px;">Download Normal Sample</button></a>
	   </div>
	    <div class="col-sm-4">
	   
	   </div>
	    <div class="col-sm-4">
        <button type="button" class="btn btn-primary" id="uploadFileData">Upload</button>
		</div>
      </div>
    </div>

  </div>
</div>

<div id="downloadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Download Sample Normal File</h4>
            </div>
            <div class="modal-body" >
                <p class="error-box  modalPopUpText" >Are you sure you want to download the sample file..</p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo base_url(); ?>application/ajaxFile/ProductsSamplefile.csv" download="ProductsSamplefile.csv"><button class="btn btn-success btnClass" id="complete">Yes</button></a>
                <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
            </div>
        </div>

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





<div class="modal fade stick-up" id="viewDescriptionlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 180%;margin-left: -26%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Decription</h4>
            </div>
            <div class="modal-body form-horizontal">



                <div id="descriptionData"></div>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade stick-up" id="viewShortDescriptionlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 180%;margin-left: -26%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Short Decription</h4>
            </div>
            <div class="modal-body form-horizontal">



                <div id="shortDescriptionData"></div>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
       <p>Adding Products.Please wait...</p>
        </div>
        <!-- <div class="modal-footer">
         
        </div> -->
      </div>
      
    </div>
  </div>
  
</div>

