
<?php if ($this->session->flashdata('message')) { ?>
    <div align="center" id="flashdata" class="alert alert-danger">      
        <?php echo $this->session->flashdata('message') ?>
    </div>
<?php } ?>
<link href="<?php echo base_url(); ?>css/products.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>theme/jquery.bootpag.js"></script>
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
    .panel.panel-info.outer{
        margin-bottom: 10px;
    }

    .table{
        min-height: 100px !important;
        
    }
</style>
<script>
var catId;
var subCatId;
var subsubCatId;
var category;



$(document).on('click','.getBulkInfo',function(){

   

   $('#bulkListData').empty();         
  var bulkId=$(this).attr('id');
  var bulkType=$(this).attr('bulkType');
//   alert(bulkType);
    $.ajax({
        url:'<?php echo base_url()?>index.php?/AddNewProducts/getBulkinfo/' + bulkId,
        type:'GET',
        dataType: 'json',
    }).done(function(json){
      
        if(json =='' || json == null ){
            $('#emptyModal').modal('show'); 
        }else{     

                var html = '';
                var k = 1;               

              

               $('#bulkModal').modal('show');

                if(bulkType=="Success"){
                    $.each(json.successImports, function (i, row) {
                      
                        html += '<tr><td style="text-align:center;width:250px;border-style: ridge;">' + k + '</td>';
                        html += '<td style="border-style: ridge;width:250px;text-align:center;">' + row + '</td></tr>';                       
                        k++;
                        
                    });                   

                }else if(bulkType=="Failed"){
                    
                    $.each(json.failedImports, function (i, row) {
                    
                        html += '<tr><td style="text-align:center;width:250px;border-style: ridge;">' + k + '</td>';
                        html += '<td style="border-style: ridge;width:250px;text-align:center;">' + row + '</td></tr>';                       
                        k++;
                        
                    });

                }else{
                    //$('.bulklist').text(json.repeatedImports);
                    $.each(json.repeatedImports, function (i, row) {
                    
                        html += '<tr><td style="text-align:center;width:250px;border-style: ridge;">' + k + '</td>';
                        html += '<td style="border-style: ridge;width:250px;text-align:center;">' + row + '</td></tr>';                       
                        k++;
                        
                    });
                } 

                 $('#bulkListData').append(html);               

            }
                        
    });

        });
</script>
<script>
 
 $('.units').click(function(){
     alert();
 });
  //for storing type of view
 var typeView=1;

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

                             html+='    <div class="col-sm-12">'
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
                catId=categoryId;
                $('#listsubCategory').load("<?php echo base_url('index.php?/GridProduct_controller') ?>/getSubCategory", {categoryId: categoryId});                       
            
            });


});

    //**********  end for grid view**********

$(document).ready(function (){



    

       $('#permanentDelete').hide();

$(document).on('click','.fg-button',function(){
    $("#select_all").prop("checked", false);
});  

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


   $("body").on('click','.checkbox',function(){ 
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }   
   });

});
    $(document).ready(function () {

         $('#import').click(function(){
            $('#importmodal').modal('show');
        });

          $('#uploadFileData').click(function(){
            
            var file_data = $('#importDataFromFile').prop('files')[0];
               var fileName1 = file_data.name;
               console.log(fileName1);
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
                            var d = new Date();
                            var n = d.getTime();
                            var createdTimestamp = n;
                            var storeId = "<?php echo $storeId;?>";
                            var cityId = "<?php echo $storeData['cityId'];?>";
                            var storeLatitude = "<?php echo $storeData['coordinates']['latitude'];?>";
                            var storeLongitude = "<?php echo $storeData['coordinates']['longitude'];?>";
                            var zoneId5 = <?php echo json_encode($storeData['serviceZones']);?>;
                            var storeName = "<?php echo $storeData['sName']['en'];?>";
                             var storeAverageRating = "<?php echo $storeData['averageRating'];?>";
                             var parentProductId = "";
                             var storeType="<?php echo $storeData['storeType'];?>";
                             var storeTypeMsg="<?php echo $storeData['storeTypeMsg'];?>";
                             var storeCategoryId="<?php echo $storeData['storeCategory']['0']['categoryId'];?>";
                             var storeCategoryName='<?php echo json_encode($storeData['storeCategory']['0']['categoryName']);?>';
                             var storeImage='<?php echo json_encode($storeData['bannerLogos']['bannerimage']);?>';
                             if(!storeAverageRating){
                                 var storeAverageRating = "";
                             }
                            
                           $.ajax({
                                url: '<?php echo ProductOffers ?>bulkImport_xlsx/',
                               type: 'POST',
                               contentType: "application/json",
                              data:JSON.stringify({fileURL:fileURL,importType:1,currentDate:currentDate,createdTimestamp:createdTimestamp,parentProductId:parentProductId,cityId:cityId,
                              storeId:storeId,storeName:storeName,storeLatitude:storeLatitude,storeLongitude:storeLongitude,zoneId:zoneId5,storeAverageRating:storeAverageRating,
                              storeType:storeType,storeTypeMsg:storeTypeMsg,storeCategoryId:storeCategoryId,storeCategoryName:storeCategoryName,storeImage:storeImage}),
                               dataType: 'JSON',
                               success: function (response, textStatus, xhr)
                               {
                                  
                               
                               
                             
                            }
                           });
                       }
                   }
                });
           
           
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
                {"sWidth": "20%"},
                {"sWidth": "15%"},
                {"sWidth": "15%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "5%", "sClass": "text-center"},
                {"sWidth": "5%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "5%"},
                {"sWidth": "5%"}
            ],
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

         // category filter
         $('#listcategory').change(function(){  
                
            category=$('#listcategory option:selected').val();   
            if(category==undefined){
                category='';            
            }                            

            filterData(category);     

            //table.fnFilter(category);
            
        });


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
                            {"sWidth": "5%"},
                            {"sWidth": "20%"},
                            {"sWidth": "15%"},
                            {"sWidth": "15%", "sClass": "text-center"},
                            {"sWidth": "10%", "sClass": "text-center"},
                            {"sWidth": "5%", "sClass": "text-center"},
                            {"sWidth": "5%", "sClass": "text-center"},
                            {"sWidth": "10%", "sClass": "text-center"},
                            {"sWidth": "10%", "sClass": "text-center"},
                            {"sWidth": "10%", "sClass": "text-center"},
                            {"sWidth": "10%", "sClass": "text-center"},
                            {"sWidth": "10%", "sClass": "text-center"},
                            {"sWidth": "5%"},
                            {"sWidth": "5%"}
                        ],
                        "columnDefs": [
                            {  targets: "_all",
                                orderable: false 
                            }
                    ],
                    };
                    table.dataTable(settings);



         }

         $('#listsubCategory').change(function(){   

            var subcategory=$('#listsubCategory option:selected').attr('catName');
            subCatId=  $('#listsubCategory option:selected').val();
            subCatId=subCatId;
            $('#listsubSubCategory').load("<?php echo base_url('index.php?/GridProduct_controller') ?>/getSubSubCategory", {subCatId: subCatId}); 
            if(subcategory==undefined){
                subcategory='';            
            }


              

            filterData(category,subCatId); 

                                           
            //table.fnFilter(subcategory);
            
        });

         $('#listsubSubCategory').change(function(){            
            var listsubSubCategory=$('#listsubSubCategory option:selected').attr('catName');  
            subsubCatId =$('#listsubSubCategory option:selected').val();
            if(listsubSubCategory==undefined){
                listsubSubCategory='';            
            }                               

            filterData(category,subCatId,subsubCatId); 
            //table.fnFilter(listsubSubCategory);
            
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
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/getUnitsForStore/' + id,
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

        // Add on modal
        $('#big_table').on("click", '.addOnListForStoreProducts', function () {

                $('#addOnListData').empty();
                var id = $(this).attr('id');

                $.ajax({
                    url: '<?php echo base_url() ?>index.php?/AddNewProducts/getAddonForStore/' + id,
                    type: "POST",
                    data: {id: id},
                    dataType: "JSON",
                    success: function (result) {
                       
                       var html = '';
                        var k = 1;
                    if(result.data.length==0){
                       
                            html= '<p style="font-size:15px">No Add-Ons Available</p>';
                            $('#addOnListData').append(html);
                            $('#addOnListModal').modal('show');

                       }else{

                            html='<tr style="font-size:14px; "><td style="text-align:center;width:250px;border-style: ridge;">Sl No</td><td style="border-style: ridge;width:250px;text-align:center;">Add-Ons Name</td></tr>';
                            $('#addOnListData').append(html);
                            $.each(result.data, function (i, row) {
                                var rownum=i + 1;
                                html= '<tr style="font-size:14px; "><td style="text-align:center;width:250px;border-style: ridge;">' + rownum + '</td><td style="border-style: ridge;width:250px;text-align:center;">' + row.title + '</td></tr>';

                                $('#addOnListData').append(html);
                            });
                            $('#addOnListModal').modal('show');
                        }
                       
                       
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


        $("#permanentDelete1confirmed1").click(function () {

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            var id = $('#checkboxProduct').attr('data-id')
            $.ajax({
                url: "<?php echo base_url('index.php?/AddNewProducts') ?>/permanentDeleteProduct",
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

            console.log('tyye of view----',typeView);
          
          if(typeView==1){

         // list view
            $('#listViewDetails').show();
            $('#gridViewDetails').hide();
                                  
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
                                "sAjaxSource": $(this).attr('data'),
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
                                    {"sWidth": "20%"},
                                    {"sWidth": "15%"},
                                    {"sWidth": "15%", "sClass": "text-center"},
                                    {"sWidth": "10%", "sClass": "text-center"},
                                    {"sWidth": "5%", "sClass": "text-center"},
                                    {"sWidth": "5%", "sClass": "text-center"},
                                    {"sWidth": "10%", "sClass": "text-center"},
                                    {"sWidth": "10%", "sClass": "text-center"},
                                    {"sWidth": "10%", "sClass": "text-center"},
                                    {"sWidth": "10%", "sClass": "text-center"},
                                    {"sWidth": "10%", "sClass": "text-center"},
                                    {"sWidth": "5%"},
                                    {"sWidth": "5%"}
                                ],
                                "columnDefs": [
                            {  targets: "_all",
                                orderable: false 
                            }
                    ],
                            };
                            table.dataTable(settings);

                                $('.tabs_active').removeClass('active');

                                $(this).parent().addClass('active');

                                // search box for table
                                $('#search-table').keyup(function () {
                                    table.fnFilter($(this).val());
                                });

                                // category filter
                                  $('#listcategory').change(function(){         
                                    var category=$('#listcategory option:selected').attr('catName');                                  
                                    table.fnFilter(category);
                                    
                                });


                                    // list view data


          }else{

               $('.tabs_active').removeClass('active');
                $(this).parent().addClass('active');

            console.log('type2');

            // grid strt
        
        var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
        var status = urlChunks[urlChunks.length - 1];
        console.log('status',status);
            
        console.log('changemode');
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/productGridDisplay/'+ status,
                type: 'GET',
                dataType: 'json',
                
            }).done(function(json) {

                 console.log('grid details--',json);
               if ( json.data != 0 ) {
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
                                +'<div class="pull-right pricetag"><p>'+json.currencySymbol.currencySymbol+ val.units[0].price.en+'</p></div>'
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

                

            // grid end

          }
           

    

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

     if (status == 0 || status == 1 ||  status == 2 || status == 3 || status == 4 || status == 5 || status == 6 || status == 7  ) {
         
        $('#big_table').dataTable().fnSetColumnVis([6,8,9,10,11,13], false);
        
       //  $('#add').show();
       // $('#delete').show();
      //  $('#import').show();

    }
 
    if (status == 8) {
       
       $('#big_table').dataTable().fnSetColumnVis([1,2,3,4,5,6,7,12], false);
       
        // $('#add').hide();
        // $('#delete').hide();
        // $('#import').hide();
 

    }

     });

});

$(document).ready(function(){
    $('.whenclicked li').click(function(){
      
        if ($(this).attr('id') == "2") {
           
            $('#permanentDelete').show();
            $('#import').hide();
            $('#edit').hide();
            $('#delete').hide();
            $('#inStock').hide();
            $('#outStock').hide();
            $('#add').hide();        
            
      }else if ($(this).attr('id') == "8") {
        $('#permanentDelete').hide();
            $('#import').hide();
            $('#edit').hide();
            $('#delete').hide();
            $('#inStock').hide();
            $('#outStock').hide();
            $('#add').hide();       


      }else if ($(this).attr('id') == "3") {
        $('#gridViewDetails').hide();    


      } else if ($(this).attr('id') == "4") {
        $('#gridViewDetails').hide();    


      }else if ($(this).attr('id') == "5") {
        $('#gridViewDetails').hide();    


      } else if ($(this).attr('id') == "6") {
        $('#gridViewDetails').hide();    


      }else if ($(this).attr('id') == "7") {
        $('#gridViewDetails').hide();  


      }else{
        $('#permanentDelete').hide();       
        $('#import').show();
        $('#edit').show();
        $('#delete').show();
        $('#inStock').show();
        $('#outStock').show();
        $('#add').show(); 


                }


                

  });


     $("#permanentDelete").click(function () {
              console.log('permanent elel');

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
                            $('#modalTitle').text('Delete');
                            $('.modalTitleText').text('Are you sure you want to delete the product?');
                        }

                        $("#confirmed").click(function () {
                            var id = $('#checkboxProduct').attr('data-id')
                            $.ajax({
                                url: "<?php echo base_url('index.php?/AddNewProducts') ?>/permanentDeleteProduct",
                                type: "POST",
                                data: {val: val, id: id},
                                dataType: 'JSON',
                                success: function (response)
                                {
                                    $('#confirmmodel').modal('hide');
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
                                        "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/product_details/1',
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
                                        "columnDefs": [
                                            {  targets: "_all",
                                                orderable: false 
                                            }
                                        ],
                                    };
                                    table.dataTable(settings);

                                }

                            });

                        });
                    }


});



 $("#inStock").click(function(){
        
                console.log('permanent elel');

            $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            var status=6;

            if (val.length == 0) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Please select the Product ');
            } else if (val.length >= 1)
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#inStockmodal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#inStockmodal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                    $('#modalTitle').text('In stock');
                    $('.modalTitleText').text('Are you sure you want move?');
                }

                $("#confirmInStock").click(function () {
                    var id = $('#checkboxProduct').attr('data-id')
                 
                    $.ajax({
                        url: "<?php echo base_url('index.php?/AddNewProducts') ?>/updatecouponCodeStatus",
                        type: "POST",
                        data: {val: val, id: id,status:status},
                        dataType: 'JSON',
                        success: function (response)
                        {
                            location.reload();
                            $('#inStockmodal').modal('hide')
                            $('#inStockmodal').modal('hide')

                                      $('#confirmmodel').modal('hide');
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
            "sAjaxSource": $(this).attr('data'),
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
                {"sWidth": "20%"},
                {"sWidth": "15%"},
                {"sWidth": "15%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "5%", "sClass": "text-center"},
                {"sWidth": "5%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "5%"},
                {"sWidth": "5%"}
            ],
            "columnDefs": [
        {  targets: "_all",
            orderable: false 
        }
],
                                    };
                                    table.dataTable(settings);

                            

                        }

                    });

                });
        }
   });

   $("#outStock").click(function(){
        
         $("#display-data").text("");

            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            var status=5;

            if (val.length == 0) {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Please select the Product ');
            } else if (val.length >= 1)
            {
                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#inStockmodal');
                if (size == "mini") {
                    $('#modalStickUpSmall').modal('show')
                } else {
                    $('#inStockmodal').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    } else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                    $('#modalTitle').text('In stock');
                    $('.modalTitleText').text('Are you sure you want move?');
                }

                $("#confirmInStock").click(function () {
                   
                    var id = $('#checkboxProduct').attr('data-id')
                    $.ajax({
                        url: "<?php echo base_url('index.php?/AddNewProducts') ?>/updatecouponCodeStatus",
                        type: "POST",
                        data: {val: val, id: id,status:status},
                        dataType: 'JSON',
                        success: function (response)
                        {

                              location.reload();
                            
                           
                            $('#confirmmodel').modal('hide');
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
            "sAjaxSource": $(this).attr('data'),
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
                {"sWidth": "20%"},
                {"sWidth": "15%"},
                {"sWidth": "15%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "5%", "sClass": "text-center"},
                {"sWidth": "5%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "10%", "sClass": "text-center"},
                {"sWidth": "5%"},
                {"sWidth": "5%"}
            ],
            "columnDefs": [
        {  targets: "_all",
            orderable: false 
        }
],
                                    };
                                    table.dataTable(settings);

                        }

                    });

                });
        }
   });


     function updateCampaignStatus(couponIds, status){
            $.ajax({
                    
                    url: "<?php echo base_url('index.php?/AddNewProducts/updatecouponCodeStatus');?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        Id : couponIds,
                        status : status
                    },
            })
            .done(function(json) {
                console.log(json);
                if (json.msg.message === "Successfully Updated") {
                  
                  //   $('#big_table').DataTable().ajax.reload();
                  //  $("#confirmmodels").modal('hide')
                    // window.location.reload();
                }else{
                    alert('Unable to update status. Please try agin later');
                }
            });
        }


});

$(document).ready(function(){


    //confirmation delete cool12
    $('#grid').click(function(){
                

                var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
                var status = urlChunks[urlChunks.length - 1];
                console.log('status------',status);
                
                $.ajax({
                    //chnages
                     url:'<?php echo base_url();?>index.php?/AddNewProducts/productGridView/'+ status,
                     type:'POST',
                     dataType: 'json',
                    

                 }).done(function(json){

                       $('#gridViewDetails').hide();

                     console.log('dataaaaaaaaaaaaaa',json);
                     if ( json.data != 0 ) {
                            var html ="";

                                    $('#categoryProductId').empty();

                                    $.each(json.data,function(index,val){

                                    var unitDiv = "";
                                    $.each(val.units, function(index, unitData){

                                        if(index<=2){
                                        unitDiv+='<div class="size" id="unitsproduct">'+unitData.name.en.substr(0,6)+'</div>'}
                                        else if(index==3){
                                        unitDiv+='<div style="color:#42cbf4;cursor:pointer;margin-top: 10px" class="units" productId="'+val._id.$oid+'">more..</div>'
                                        }

                                    });
                                        
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
                                        +'<div class="pull-right pricetag"><p>'+json.currencySymbol.currencySymbol+ val.units[0].price.en+'</p></div>'
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

    //list

    $("#list").click(function(){
        typeView=1;
        $('#gridFilter').hide();
        $('#listFilter').show();
        
        $('#listViewDetails').show();
        $('#gridViewDetails').hide();
        $('#categoryProduct').hide();

    });

    $("#grid").click(function(){
        
        typeView=2;
        $('#gridFilter').show();
        $('#listFilter').hide();
        $('#listViewDetails').hide();
        $('#gridViewDetails').show();
        $('#categoryProduct').show();


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
                                        +'<div class="pull-right pricetag"><p>'+json.currencySymbol.currencySymbol+ val.units[0].price.en+'</p></div>'
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
                                +'<div class="pull-right pricetag"><p>'+json.currencySymbol.currencySymbol+ val.units[0].price.en+'</p></div>'
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
                                    +'<div class="pull-right pricetag"><p>'+json.currencySymbol.currencySymbol+ val.units[0].price.en+'</p></div>'
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
                                  +'<div class="pull-right pricetag"><p>'+json.currencySymbol.currencySymbol+uprice.price.en+'</p></div>'
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
                        +'<div class="pull-right pricetag"><p>'+json.currencySymbol.currencySymbol+ uprice.price.en+'</p></div>'
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


    $('.demo2').bootpag({
                    total: '<?php echo $productsCount?>',
                    page: 1,
                    maxVisible: 5
                    }).on('page', function(event, num){                          
    
                $.ajax({
                        url:'<?php echo base_url()?>index.php?/AddNewProducts/get_productPagination/' + num,
                        type:'POST',
                        dataType:'json',
                        data: { },

                        }).done(function(json){ 

                            console.log('data---',json);
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
                                        if(index<=2){
                                        unitDiv+='<div class="size" id="unitsproduct">'+unitData.name.en.substr(0,6)+'</div>'}
                                        else if(index==3){
                                            unitDiv+='<div style="color:#42cbf4;cursor:pointer" class="units" productId="'+val._id.$oid+'">more..</div>'
                                        }                               
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





// list view filter**********
 //category filter
 




// list view filter end****************

    

});
</script>

<div class="page-content-wrapper"style="padding-top: 20px;">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <!-- <div class="brand inline" style="  width: auto; margin-left: 8px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 16px;">Products</strong>
        </div> -->
        <div class="brand inline" style="  width: auto;">
              <?php echo $this->lang->line('products'); ?>      
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-fillup  bg-white whenclicked btnMrgn">
           
            <li id= "0" class="tabs_active " style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url() ?>index.php?/AddNewProducts/StoreProductDetails/0"><span><?php echo $this->lang->line('Pending_Approval'); ?></span></a>
            </li>
            <li id= "1" class="active tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url() ?>index.php?/AddNewProducts/StoreProductDetails/1"><span> <?php echo $this->lang->line('Approved'); ?></span></a>
            </li>
            <li id= "3" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url() ?>index.php?/AddNewProducts/StoreProductDetails/3"><span> <?php echo $this->lang->line('Rejected'); ?></span></a>
            </li>
            <li id= "4" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url() ?>index.php?/AddNewProducts/StoreProductDetails/4"><span> <?php echo $this->lang->line('Banned'); ?></span></a>
            </li>
            <!-- <li id= "6" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url() ?>index.php?/AddNewProducts/StoreProductDetails/6"><span><?php echo $this->lang->line('In_Stock'); ?></span></a>
            </li>
            <li id= "5" class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url() ?>index.php?/AddNewProducts/StoreProductDetails/5"><span><?php echo $this->lang->line('Out_of_Stock'); ?></span></a>
            </li> -->
            <li id= "2" class="tabs_active" style="cursor:pointer">
                <a   class="changeMode" data="<?php echo base_url() ?>index.php?/AddNewProducts/StoreProductDetails/2"><span> <?php echo $this->lang->line('Deleted'); ?></span></a>
            </li>
            <li id="8"  class="tabs_active" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/AddNewProducts/StoreProductDetails/8" ><span> <?php echo $this->lang->line('List'); ?></span> </a>
            </li>

            
            
      </ul>
      <div class="bg-white" style="margin-top:15px; margin-bottom:15px; padding:10px;">
            <div class="brWrap">
                <!-- <div class="pull-right m-t-10"> <button class="btn btn-warning" id="outStock"> <?php echo $this->lang->line('Out_of_Stock'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-success" id="inStock"> <?php echo $this->lang->line('In_Stock'); ?></button></div> -->
                <div class="pull-right m-t-10"> <button class="btn btn-danger" id="delete"> <?php echo $this->lang->line('Delete'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-info" id="edit"> <?php echo $this->lang->line('Edit'); ?></button></div>
                <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10" id="import"> <?php echo $this->lang->line('Import'); ?></button></a></div>
                <div class="pull-right m-t-10"> <button style="width:100%" class="btn btn-danger pull-right m-t-10" id="permanentDelete"> <?php echo $this->lang->line('Permanent_Delete'); ?> </button></a></div>
                <div class="pull-right m-t-10"><a href="<?php echo base_url() ?>index.php?/AddNewProducts/addNewProduct"> <button class="btn btn-success pull-right m-t-10" id="add">  <?php echo $this->lang->line('Add'); ?></button></a></div>         
            </div>
      </div>

    <br>
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
        <div class="parallax" data-pages="parallax">
            <div class="col-xs-12 container-fixed-lg sm-p-l-20 sm-p-r-20">
                <div class="row panel panel-transparent">

                    <!-- list viwe -->
                    <div class="tab-content" id="listViewDetails">
                        <div class="container-fluid container-fixed-lg bg-white">
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
                          
                        </div>
                    </div>
                    <!-- list viwe end -->

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

                                    <?php break;    }
                                        
                                          
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
    
            <div class="categoryProduct" id="categoryProduct" style="display:none">
                <div class="tab-content" id="cateProduct" >
                                <div class="padding-20 slide-left">
                                    <div class="row row-same-height" id="categoryProductId">

                                    </div>
                                </div>

                                <div class="bs-docs-example">
                                    <p class="demo demo2" style=" text-align: center;"></p>
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
        <!-- END JUMBOTRON -->

        <!-- END PAGE CONTENT -->
    </div>



    <div class="modal fade stick-up" id="permanentDeleteconfirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <div class="error-box" id="errorboxdata" style="font-size: large;text-align:center"><?php echo $this->lang->line('Del_confirm'); ?></div>
                    </div>
                </div>
                <br>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="permanentDelete1confirmed1" ><?php echo $this->lang->line('Yes'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
                        <div class="error-box" id="errorboxdata" style="font-size: large;text-align:center"><?php echo $this->lang->line('Del_confirm'); ?></div>
                    </div>
                </div>
                <br>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="confirmed1" ><?php echo $this->lang->line('Yes'); ?></button>
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
                <h4><?php echo $this->lang->line('Review_List'); ?></h4>
            </div>
            <div class="modal-body form-horizontal">

                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>
                    <th style="width :72px !important;" ><?php echo $this->lang->line('SL_NO'); ?></th>
                    <th style="width :72px !important;" ><?php echo $this->lang->line('CUSTOMER_NAME'); ?></th>
                    <th style="width :72px !important;"><?php echo $this->lang->line('CUSTOMER_ID'); ?></th>
                    <th style="width :72px !important;"><?php echo $this->lang->line('RATING'); ?></th>
                    <th style="width :50px !important;"><?php echo $this->lang->line('REVIEW'); ?></th>
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
                <h4><?php echo $this->lang->line('Image_List'); ?></h4>
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
                <h4><?php echo $this->lang->line('Nutrition_List'); ?></h4>
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
                <h4><?php echo $this->lang->line('Flavours_List'); ?></h4>
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
                <h4><?php echo $this->lang->line('Negative_Attributes_List'); ?></h4>
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
                <h4><?php echo $this->lang->line('Medical_Attributes_List'); ?></h4>
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
                <h4><?php echo $this->lang->line('Strain_Effects_List'); ?></h4>
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



<!-- <div class="modal fade stick-up" id="importmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="  width: 110%;">
            <form action="<?php echo base_url(); ?>index.php?/Uflyproducts/importExcel" method="post" name="upload_excel" enctype="multipart/form-data">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4>Upload File</h4>
                </div>
                <div class="modal-body">
                    <div class="row row-same-height">
                        <div align="center">
                            <div class="row">
                                <label class="col-sm-4 control-label"><h5>Excel File Upload</h5></label>
                                <input type="file" name="file" id="file" class="form-control col-sm-6" style="width:50% !important;">
                            </div>
                            <div class="row"></div>
                            <div class="row"></div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- <div class="modal-footer">
                    <div class="row">
                        <button type="submit" id="submit" name="import" class='btn btn-primary pull-right'>Import</button>
                    </div>
                </div> -->
                <!-- /.modal-dialog -->
            </form>
        </div>
    </div>
</div> -->

<div id="downloadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Download_Sample_File'); ?></h4>
            </div>
            <div class="modal-body" >
                <p class="error-box  modalPopUpText" ><?php echo $this->lang->line('Download_confirmation'); ?></p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo base_url(); ?>application/ajaxFile/ProductsSamplefile.csv" download="ProductsSamplefile.csv"><button class="btn btn-success btnClass" id="complete"><?php echo $this->lang->line('Yes'); ?></button></a>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
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
                <h4 class="modal-title"><?php echo $this->lang->line('Alert'); ?></h4>
            </div>
            <div class="modal-body">
                <p class="error-box modalPopUpText" style="font-size: initial !important;"></p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('OK'); ?></button>
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
                <h4><?php echo $this->lang->line('Decription'); ?></h4>
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
                <h4><?php echo $this->lang->line('Short_Decription'); ?></h4>
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
                <h4><?php echo $this->lang->line('Unit_List'); ?></h4>
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
<!-- // Addon details -->
<div class="modal fade stick-up" id="addOnListModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4><?php echo $this->lang->line('Add_Ons_List'); ?></h4>
            </div>
            <div class="modal-body form-horizontal">
                <table class='table table-hover demo-table-search' id="devices_datatable">
                    <thead>                 
                        <!-- <tr style="font-size:14px; "><td style="text-align:center;width:250px;border-style: ridge;">Sl No.</td>
                        <td style="border-style: ridge;width:250px;text-align:center;">Add-Ons Name</td></tr> -->
                    </thead>
                    <tbody >
                    <div class="container" id="addOnListData">
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
       <p><?php echo $this->lang->line('Adding_product'); ?></p>
        </div>
        <!-- <div class="modal-footer">
         
        </div> -->
      </div>
      
    </div>
  </div>
  
</div>

                 <!-- Modal -->
                 <div class="modal fade" id="bulkModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $this->lang->line('Product_Information'); ?></h4>
        </div>
        <div class="modal-body bulkList">
                  <!-- <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="bulklist"></span>
                  </div> -->
                  <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:2%;text-align: center;"><?php echo $this->lang->line('SL_NO'); ?></th>
                            <th style="width:10%;text-align: center;"><?php echo $this->lang->line('Product_No'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="bulkListData">

                    </tbody>
                </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Ok'); ?></button>
        </div>
      </div>
      
    </div>
  </div>


    <div class="modal fade stick-up" id="inStockmodal" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <div class="error-box" id="errorboxdata" style="font-size: large;text-align:center"><?php echo 'Are you sure  ?'; ?></div>
                    </div>
                </div>
                <br>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4" ></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4" >
                            <button type="button" class="btn btn-primary pull-right" id="confirmInStock" >Yes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="deleteModal" role="dialog">
                        <div class="modal-dialog">
                        
                        
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><?php echo $this->lang->line('Confirmation'); ?></h4>
                        </div>
                            <div class="modal-body">
                            <p><?php echo $this->lang->line('Confirmation_Delete'); ?></p>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="deleteYes"  ><?php echo $this->lang->line('Yes'); ?></button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Cancel'); ?></button>
                            </div>
                        </div>
                        
                        </div>
                    </div>


    <!-- modal for view -->
                            
    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                        
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><?php echo $this->lang->line('Unit_Details'); ?></h4>
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
                                                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name" style="color:#42b3f4"><?php echo $this->lang->line('Unit_Name'); ?></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <span style="" class="dname"></span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row" style="  margin-left: 7%;">
                                                    <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name" style="color:#42b3f4"><?php echo $this->lang->line('Price'); ?></label>
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
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                            </div>
                        </div>
                        
                        </div>
                    </div>
        <!-- end of modal view -->