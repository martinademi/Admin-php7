
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
    .dataTables_scrollBody{
        height:100%!important;
        min-height:100%!important;
    }
</style>
<script>
var productId;
var unitId;
var avalabelQty;
var status=1;

var catId;
var subCatId;
var subsubCatId;
var category;

function callDatatable(sortby='',type='',mystatus){
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Inventory/inventoryProductList/'+mystatus+'/'+sortby+'/'+type,
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
                {"sWidth": "2%"},
                {"sWidth": "20%"},
                {"sWidth": "5%"},
                {"sWidth": "15%"},
                {"sWidth": "12%", "sClass": "text-center"},
                {"sWidth": "12%", "sClass": "text-center"},
                {"sWidth": "5%", "sClass": "text-center"}, 
                {"sWidth": "5%", "sClass": "text-center"},    
                {"sWidth": "20%"}
            ]
        };
        table.dataTable(settings);
}


// function for filter
        function filterData(category='',subCatId='',subsubCatId=''){         
                    
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
                        "sAjaxSource": '<?php echo base_url() ?>index.php?/Inventory/inventoryProductList/1',
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

                            if(category !='' && subCatId!='' && subsubCatId !=''){
                                aoData.push({ name: 'category',value:category});
                                aoData.push({ name: 'subCat',value:subCatId});  
                                aoData.push({ name: 'subSubCat',value:subsubCatId}); 
                             }else if(category !='' && subCatId!=''){
                                aoData.push({ name: 'category',value:category});
                                aoData.push({ name: 'subCat',value:subCatId});   
                             }else if(category !='' ){
                                aoData.push({ name: 'category',value:category});                     
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
                        "aoColumns": [
                            {"sWidth": "2%"},
                            {"sWidth": "20%"},
                            {"sWidth": "5%"},
                            {"sWidth": "15%"},
                            {"sWidth": "12%", "sClass": "text-center"},
                            {"sWidth": "12%", "sClass": "text-center"},
                            {"sWidth": "5%", "sClass": "text-center"}, 
                            {"sWidth": "5%", "sClass": "text-center"},    
                            {"sWidth": "20%"}
                        ],
                        "columnDefs": [
                            {  targets: "_all",
                                orderable: false 
                            }
                    ],
                    };
                    table.dataTable(settings);



         }





    $(document).ready(function () {

       $('.products').addClass('active');
      
        $('#big_table_processing').show();

       
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
                window.location.href = '<?php echo base_url(); ?>index.php?/Inventory/EditProductsdetails/' + val;
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
                url: '<?php echo base_url() ?>index.php?/Inventory/getUnitsForStore/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    console.log('unit details*******',result);
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
            $.ajax({
                url: "<?php echo base_url('index.php?/Inventory') ?>/delete_product",
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

$('.whenclicked li').click(function(){
      
      if ($(this).attr('id') == "5") {
         status = 2;
        $("#inventorysort").hide()
    }else if ($(this).attr('id') == "6") {
        status = 1;
        $("#inventorysort").show()
    }
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
                {"sWidth": "2%"},
                {"sWidth": "20%"},
                {"sWidth": "5%"},
                {"sWidth": "15%"},
                {"sWidth": "12%", "sClass": "text-center"},
                {"sWidth": "12%", "sClass": "text-center"},
                {"sWidth": "5%", "sClass": "text-center"}, 
                {"sWidth": "5%", "sClass": "text-center"},    
                {"sWidth": "20%"}
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

 $(document).ready(function(){
     
     //add units data cool
    $('#big_table').on("click", '.addUnitsData', function () {           
        productId = $(this).attr('id');
        unitId=$(this).attr('unitId');
           $.ajax({
               url: '<?php echo base_url() ?>index.php?/Inventory/getUnitsForItem/' + productId + '/' + unitId ,
               type: "POST",
               data: {id: productId,unitId:unitId},
               dataType: "JSON",
               success: function (result) {
                   $('#unitQuantityData').val(result.data);
                   avalabelQty = result.data;
                   $('#addUnitModal').modal('show');
               }

           });
       });

        //confirmation delete
             $('#addQuantity').click(function(){

                    var updateQuantity=$('#unitQuantityData').val();
                   
                    $.ajax({
                    //chnages
                        url:'<?php echo base_url();?>index.php?/Inventory/addProductQuantity',
                        type:'POST',
                        dataType: 'json',
                        data:{productId :productId,unitId:unitId,quantity:updateQuantity},
                        success: function (result) {
                            callDatatable("","",status);
               }

           });

        });
   
       //remove units modal
       $('#big_table').on("click", '.removeUnitsData', function () {           
           
          
        productId = $(this).attr('id');
        unitId=$(this).attr('unitId');

           $.ajax({
            url: '<?php echo base_url() ?>index.php?/Inventory/getUnitsForItem/' + productId + '/' + unitId ,
               type: "POST",
               data: {id: productId,unitId:unitId},
               dataType: "JSON",
               success: function (result) {
                  
                $('#removeQuantityData').val(result.data);

                   $('#removeUnitModal').modal('show');
               }

           });
       });

    //    remove quantity
     
     $('#removeQuantity').click(function(){


            var removeQuantity=$('#removeQuantityData').val();

            $.ajax({
            //chnages
                url:'<?php echo base_url();?>index.php?/Inventory/removeProductQuantity',
                type:'POST',
                dataType: 'json',
                data:{productId :productId,unitId:unitId,quantity:removeQuantity},
                success: function (result) {
                    console.log(result);
                    callDatatable("","",status);
            }

            });

    });
    
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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/Inventory/inventoryProductList/1',
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
                {"sWidth": "2%"},
                {"sWidth": "20%"},
                {"sWidth": "5%"},
                {"sWidth": "15%"},
                {"sWidth": "12%", "sClass": "text-center"},
                {"sWidth": "12%", "sClass": "text-center"},
                {"sWidth": "5%", "sClass": "text-center"}, 
                {"sWidth": "5%", "sClass": "text-center"},    
                {"sWidth": "20%"}
            ]
        };
        table.dataTable(settings);
        // search box for table

        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

         $('#listcategory').change(function(){          
            category=$('#listcategory option:selected').val();                                  
            // table.fnFilter(category);

            filterData(category);

            var categoryId=$(this).val();
            $('#listsubCategory').load("<?php echo base_url('index.php?/GridProduct_controller') ?>/getSubCategory", {categoryId: categoryId});          
            
        });




        $('#listsubCategory').change(function(){            
            var subcategory=$('#listsubCategory option:selected').attr('catName');
            var subCatId=$('#listsubCategory option:selected').val(); 
             subCatId=subCatId;
            $('#listsubSubCategory').load("<?php echo base_url('index.php?/GridProduct_controller') ?>/getSubSubCategory", {subCatId: subCatId});  
            // table.fnFilter(subcategory);
             filterData(category,subCatId); 
            
        });

         $('#listsubSubCategory').change(function(){            
            var listsubSubCategory=$('#listsubSubCategory option:selected').attr('catName');                                  
            // table.fnFilter(listsubSubCategory);
            var subsubCatId=$('#listsubSubCategory option:selected').val();
            filterData(category,subCatId,subsubCatId);
            
        });
        $('#inventorysort').change(function(){          
            var inventorysort=$('#inventorysort').val();                                  
            callDatatable("1",inventorysort,status)
            
        });
        $('#costsort').change(function(){           
            var costsort=$('#costsort').val();                                  
            callDatatable("2",costsort,status);
            
        });




        $('#import').click(function(){
            $('#importDataFromFile').val('');
            $('#importmodal').modal('show');
        });
        $('#uploadFileData').click(function(){
               var file_data = $('#importDataFromFile').prop('files')[0];
               var ext = $('#importDataFromFile').val().split('.').pop().toLowerCase();
               var fileName1 = file_data.name;
               var form_data = new FormData();
               var currentdate = new Date();
               var currentDate  = currentdate.getFullYear() + "-" + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
               form_data.append('OtherPhoto', file_data);
             
               form_data.append('type', 'uploadImage');
               form_data.append('Image', 'Image');
               form_data.append('folder', 'productXLSImport');
               $('#importmodal').modal('hide');
            //    $(document).ajaxStart(function () {
            //             $('#importmodal').modal('hide');
            //             $("#loadingModal").modal('show')
            //         });
            if ($.inArray(ext, ['xls', 'xlsx','xlr']) == -1) {
                alert("upload only xls, xlsx,xlr");
                }
                else{
                    $.ajax({
                   url: "<?php echo base_url('index.php?/Common') ?>/uploadPDFToAws",
                   type: "POST",
                   data: form_data,
                   dataType: "json",
                   processData: false,
                   contentType: false,
                   success: function (result) {

                       if (result) {
                           var fileURL = result.fileName;
                            var storeId = "<?php echo $storeId;?>";
                             var storeCategoryName='<?php echo json_encode($storeData['storeCategory']['0']['categoryName']);?>';
                             if(!storeAverageRating){
                                 var storeAverageRating = "";
                             }
                            
                           $.ajax({
                                url: '<?php echo ProductOffers ?>patchQuantity/',
                               type: 'PATCH',
                               contentType: "application/json",
                               data:JSON.stringify({fileURL:fileURL,storeId:storeId}),
                               dataType: 'JSON',
                               success: function (response, textStatus, xhr)
                               {
                                  
                               
                               
                             
                            }
                           });
                       }
                   }
                });
                }
                
           
           
       });


 });

     

        

    
    
</script>

<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <!-- <div class="brand inline" style="  width: auto; margin-left: 8px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 16px;">Inventory</strong>
        </div> -->
        <div class="brand inline" style="  width: auto;">
        <?php echo $this->lang->line('heading_inventory'); ?> 
        </div>
        <!-- Nav tabs -->
    <div class="panel panel-transparent">
    <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked btnMrgn">
           <li id= "6" class="active tabs_active" style="cursor:pointer">
               <a  class="changeMode" data="<?php echo base_url() ?>index.php?/Inventory/inventoryProductList/1"><span><?php echo $this->lang->line('In_Stock'); ?></span></a>
           </li>
           <li id= "5" class="tabs_active" style="cursor:pointer">
               <a  class="changeMode" data="<?php echo base_url() ?>index.php?/Inventory/inventoryProductList/2"><span><?php echo $this->lang->line('Out_of_Stock'); ?></span></a>
           </li>

           <div class="pull-right">
            <a style="color: white;" class="exportAccData" href="<?php echo base_url() ?>index.php?/Inventory/exportAccData/"><button class="btn btn-primary " style="    margin-top: 5px;" type="button">Export</button></a>
            <button class="btn btn-success " id="import"style="    margin-top: 5px;" > <?php echo $this->lang->line('Import'); ?></button>
            </div>


     </ul>
    </div>


          <!--- -->
                <div id="listFilter" class="">
                <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked pyCusBt">
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
                       <div class="col-sm-2">
                        <li>
                        
                        <select name="inventorysort" id="inventorysort" class="form-control" style="max-width:100%;">
                        <option value="">Sort by Inventory</option>
                        <option value="1">High to Low</option>
                        <option value="2">Low to High</option>

                        </select>
                        </li>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        </ul>
                    <!-- </div> -->
                </div>

                                    <!-- -->

        
        <!-- Tab panes -->
        <div class="parallax" data-pages="parallax">

            <div class="col-xs-12 container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="row panel panel-transparent">

            <div class="col-xs-12 container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="row panel panel-transparent">

                    <div class="tab-content">
                        <div class="col-xs-12 container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">
                                    <div class="error-box" id="display-data" style="text-align:center; color: red;"></div>
                                    <div class="searchbtn row clearfix pull-right" style="margin-right: 0%;">

                                        <div class="col-xs-12"><input type="text" id="search-table" class="form-control pull-right" style="text-transform: capitalize;" placeholder="<?php echo SEARCH; ?>"> </div>
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

<!-- <div class="modal fade stick-up" id="unitListModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Add Unit</h4>
            </div>
            <div class="modal-body form-horizontal">
            <label for="fname" class="col-sm-2 control-label">Quantity</label>
                                        <div class="col-sm-6 pos_relative2">

                                            <input type="text" id="quantity" name="quantity"
                                                   required="required" class="error-box-class  form-control">

                                        </div>
                                        
            </div>
            
        </div>
       
    </div>
</div> -->


 <div class="modal fade" id="addUnitModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $this->lang->line('heading_addQuantity'); ?></h4>
        </div>
        <div class="modal-body">
            <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_quantity'); ?></label>
                <div class="col-sm-9 pos_relative2">

                    <input type="text" id="unitQuantityData" name="unitQuantityData"
                            required="required" class="error-box-class  form-control">

                </div>
                                       
        </div>
        <br> <br> <br>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal" id="addQuantity"><?php echo $this->lang->line('button_add'); ?></button>
        </div>
      </div>
    </div>
  </div>

  <!-- //remove units -->
  <div class="modal fade" id="removeUnitModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $this->lang->line('heading_removeQuantity'); ?></h4>
        </div>
        <div class="modal-body">
            <label for="fname" class="col-sm-3 control-label"><?php echo $this->lang->line('label_quantity'); ?></label>
                <div class="col-sm-9 pos_relative2">

                    <input type="text" id="removeQuantityData" name="removeQuantityData"
                            required="required" class="error-box-class  form-control">

                </div>
                                       
        </div>
        <br> <br> <br>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button> -->
          <button type="button" class="btn btn-success" data-dismiss="modal" id="removeQuantity"><?php echo $this->lang->line('button_remove'); ?></button>
        </div>
      </div>
    </div>
  </div>
  

    <div id="importmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->lang->line('Import_Data'); ?></h4>
      </div>
      <div class="modal-body">
       <input type="file" name="file"  id="importDataFromFile"  class="form-control"/>
      </div>
      <div class="modal-footer">
      <div class="col-sm-4">
       <!-- <a href="https://s3.amazonaws.com/loopzadmin/uploadImage/productXLSImport/file201882116835.xlsx" download><button class="btn btn-success pull-left" style="width:140px;">Download Sample File</button></a> -->
       </div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
        <button type="button" class="btn btn-primary" id="uploadFileData"><?php echo $this->lang->line('Upload'); ?></button>
        </div>
      </div>
    </div>

  </div>
</div>