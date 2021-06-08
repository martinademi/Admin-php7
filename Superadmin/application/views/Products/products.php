
<?php if ($this->session->flashdata('message')) { ?>
    <div align="center" id="flashdata" class="alert alert-danger">      
        <?php echo $this->session->flashdata('message') ?>
    </div>
<?php } ?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE"></script>
<style>
    .btn{
        border-radius: 25px !important;
    }
    .dataTables_scrollHead{
        margin-bottom: -52px !important;
    }

    .carousel-inner > .item > img,
    .carousel-inner > .item > a > img {
        width: 70%;
        margin: auto;
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

</style>
<script>




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
$(document).ready(function(){
    $(document).ajaxComplete(function () {
        // console.log("hsdfsdf");
        var access_right_pg = '<?= $access_right_pg ?>';
        if (access_right_pg == 000) {
    //   base_url().'index.php?/superadmin/access_denied';
        } else if (access_right_pg == 100) {
            $('.cls110').remove();
            $('.cls111').remove();
        } else if (access_right_pg == 110) {
            $('.cls111').remove();
        } 
    });


     $('#permanentDelete').hide();
    //$('#select_all').on('click',function(){
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
</script>
<script>


$(document).ready(function (){

    $(document).on('click','.fg-button',function(){
        $("#select_all").prop("checked", false);
    });  
});
    $(document).ready(function () {
		
		
		$('#uploadFileData').click(function(){
            
           

          var file_data = $('#importDataFromFile').prop('files')[0];
               var fileName1 = file_data.name;
               console.log(fileName1);
               var form_data = new FormData();
               
               form_data.append('OtherPhoto', file_data);
               var currentdate = new Date();
               var currentDate  = currentdate.getFullYear() + "-" + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + " " + currentdate.getHours() + ":" + currentdate.getMinutes() + ":" + currentdate.getSeconds();
               form_data.append('type', 'uploadImage');
               form_data.append('Image', 'Image');
               form_data.append('folder', 'productXLSImport');
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
                           $.ajax({
                               url: '<?php echo ProductOffers ?>bulkImport_xlsx/',
                               type: 'POST',
                              data: {fileURL:fileURL,importType:0,currentDate:currentDate},
                               dataType: 'JSON',
                               success: function (response, textStatus, xhr)
                               {
                              
                               }
                           });
                       }
                   }
                });
			
			
		});
		
        
         $('.changeMode').click(function () {

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
                "sAjaxSource": $(this).attr('data'),
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
                },
                "fnInitComplete": function () {
                    $('#big_table').fadeIn('slow');

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
            $('.tabs_active').removeClass('active');
            $(this).parent().addClass('active');
            table.dataTable(settings);
        });

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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/product_details/1',
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

        $('#downloadFile').click(function () {
            $('#downloadModal').modal('show');
        });

        $('#complete').click(function () {
            setTimeout(function () {
                $('#downloadModal').modal('hide');
            }, 3000);
        });

//        $('#edit').click(function () {
//            var val = $('.checkbox:checked').map(function () {
//                return this.value;
//            }).get();
//
//            if (val.length < 0 || val == '') {
//                $('#errorModal').modal('show')
//                $(".modalPopUpText").text('Please select the Product');
////                alert('Inavalid Selection');
//            } else if (val.length > 1) {
//                $('#errorModal').modal('show')
//                $(".modalPopUpText").text('Please select only one Product');
//            }
//        }
           $(document).on('click', '.editProducts', function () {
            var val = $(this).val();
            if (val) {
                window.location.href = '<?php echo base_url(); ?>index.php?/AddNewProducts/EditProducts/' + val;
            }

        });
        $('#add').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                window.location.href = "<?php echo base_url(); ?>index.php?/AddNewProducts/addNewProduct";
            } else {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Invalid Selection...');
            }
        });

        $("#delete").click(function () {

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];
            
            console.log('status',status)
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
                        url: "<?php echo base_url('index.php?/AddNewProducts') ?>/delete_product",
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
                                "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/product_details/'+status,
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


        setTimeout(function () {
            $('#flashdata').hide();
        }, 3000);


        $('#big_table').on("click", '.reviewlist', function () {
            $('#review_data').empty();
            var id = $(this).attr('id');

            console.log(id);
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/reviewlist/' + id,
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
            $('#indicator').html('');
            $('#imagedata').html('');
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/imagelist/' + id,
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
//                                    + '<div class="col-sm-4"><label class="control-label"></label><button class="btn btn-primary" imageid="' + result.data[i]['imageId'] + '" data-id = "' + id + '" id="imgTextBtn' + i + '" style="margin-top:25px;" onclick="savealltext(' + i + ')">Save</div>'

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
//        $('#imagelist').removeData();
            $('#indicator').html("");
            $('#imagedata').html("");
            window.location.reload();
        });


        $('#big_table').on("click", '.strainEffects', function () {

            $('#strainEffectsData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/strainEffects/' + id,
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
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/medicalAttributes/' + id,
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
        $('#big_table').on("click", '.viewDetailedDescriptionlist', function () {
            $('#descriptionData').empty();
            var id = $(this).attr('id');

            console.log(id);
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/viewDescriptionlist/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';

                    html = '<p style="font-family: Arial, Helvetica, sans-serif; font-size:14px;">' + result.data + '</p>';


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
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/viewShortDescriptionlist/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';

                    html = '<p style="font-family: Arial, Helvetica, sans-serif; font-size:14px;">' + result.data + '</p>';


                    $('#shortDescriptionData').append(html);

                    $('#viewShortDescriptionlist').modal('show');
                }

            });

        });

        $('#big_table').on("click", '.negativeAttributes', function () {

            $('#negativeAttributesData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/negativeAttributes/' + id,
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
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/flavours/' + id,
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
		$('#import').click(function(){
			$('#importmodal').modal('show');
		});
		
        $('#big_table').on("click", '.nutrilist', function () {

            $('#nutritiondata').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/nutrilist/' + id,
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
        $('#big_table').on("click", '.unitsList', function () {

            $('#unitListData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/AddNewProducts/unitsList/' + id,
                type: "POST",
                data: {id: id},
                dataType: "JSON",
                success: function (result) {
                    var html = '';
                    var k = 1;
                    $.each(result.data, function (i, row) {
                        html = '<tr style="font-size:14px; "><td style="text-align:center;width:200px;border-style: ridge;">' + row.title + '</td><td style="border-style: ridge;width:200px;text-align:center;">' + row.value + '</td></tr>';

                        $('#unitListData').append(html);
                    });
                    $('#unitListModal').modal('show');
                }

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

        console.log('prev id - ' + typeof(prev_id));
       
        if (typeof(prev_id) == 'undefined') {
            $('#errorModal').modal('show')
            $(".modalPopUpText").text('Not able to move up');
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/AddNewProducts/reorderProductSequence",
                type: "POST",
                data: {kliye: 'interchange', curr_id: curr_id, prev_id: prev_id},
                success: function (result) {

                }
            });
            row.prev().insertAfter(row);
            $('#saveOrder').trigger('click');
//        });
        }
    }
    function moveDown(id) {

        var row = $(id).closest('tr');
        var prev_id = row.find('.moveDown').attr('id');
        var curr_id = row.next('tr').find('.moveDown').attr('id');
        if ( typeof(curr_id) == 'undefined') {
            $('#errorModal').modal('show')
            $(".modalPopUpText").text('Not able to move down');
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php?/AddNewProducts/reorderProductSequence",
                type: "POST",
                data: {kliye: 'interchange', prev_id: prev_id, curr_id: curr_id},
                success: function (result) {
                }
            });
            row.insertAfter(row.next());
            $('#saveOrder').trigger('click');
//        });
        }
    }

        $(document).ready(function(){

$('#big_table').on('init.dt', function () {

     var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
     var status = urlChunks[urlChunks.length - 1];
     var forwhat = urlChunks[urlChunks.length - 2];

     if (status == 0) {
         
         $('#big_table').dataTable().fnSetColumnVis([7,8,9,10,12], false);      

    }
    if (status == 1) {        
        $('#big_table').dataTable().fnSetColumnVis([7,8,9,10,12], false);                    
        }
    if (status == 2) {        
         $('#big_table').dataTable().fnSetColumnVis([1,2,3,4,5,6,11], false);   
    }

     });

       $('.whenclicked li').click(function(){
        if ($(this).attr('id') == "1") {
            console.log('1');
            $('#permanentDelete').hide();  
            $('#add').show();  
            $('#delete').show();    
            $('#import').show();                 
                    
         }else if($(this).attr('id')=="2"){
             console.log('2 sds');
            $('#permanentDelete').show();       
            $('#delete').hide();    
            $('#import').hide();     
            $('#add').hide();                         
                
          }else if($(this).attr('id')=="3" ){
            console.log('3');
            $('#permanentDelete').hide();
            $('#delete').hide();
            $('#import').show();        
          }

        });


          $("#permanentDelete").click(function () {
              console.log('permanent elel');

            var urlChunks = $("li.active").find('.changeMode').attr('data').split('/');
            var status = urlChunks[urlChunks.length - 1];

            console.log('status permanent',status)
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
                                        "sAjaxSource": '<?php echo base_url() ?>index.php?/AddNewProducts/product_details/'+status,
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

});
</script>


<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"><?php echo $this->lang->line('Central_Products'); ?></strong>
        </div>
        <!-- Nav tabs -->

        <ul class="nav nav-tabs nav-tabs-simple whenclicked bg-white new_button" style="" role="tablist" data-init-reponsive-tabs="collapse">

             <li id="1" data-id="1" class="tabs_active <?php echo ($status == 1 ? "active" : ""); ?>" style="cursor:pointer">
                <a class="changeMode" data="<?php echo base_url(); ?>index.php?/AddNewProducts/product_details/1"
                    data-id="1"><span><?php echo $this->lang->line('Active'); ?></span><span class="badge newDriverCount" style="background-color: #5bc0de;"></span></a>
            </li>
            <li id="2" data-id="2" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/AddNewProducts/product_details/0" data-id="2"><span><?php echo $this->lang->line('Deleted'); ?></span> <span class="badge acceptedDriverCount" style="background-color:#3CB371;"></span></a>
            </li>
            <li id="3" data-id="3" class="tabs_active <?php echo ($status == 2 ? "active" : ""); ?>" style="cursor:pointer">
                <a  class="changeMode" data="<?php echo base_url(); ?>index.php?/AddNewProducts/product_details/2" data-id="3"><span><?php echo $this->lang->line('List'); ?></span> <span class="badge acceptedDriverCount" style="background-color:#3CB371;"></span></a>
            </li>
           
            <div class="pull-right m-t-10"> <button style="width:100%" class="btn btn-danger pull-right m-t-10 cls111" id="permanentDelete"><?php echo $this->lang->line('Permanent_Delete'); ?> </button></a></div>
            <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10 cls110" id="import">Import<?php echo $this->lang->line('search'); ?></button></a></div>
            <div class="pull-right m-t-10"> <button class="btn btn-danger cls111" id="delete"><?php echo $this->lang->line('button_delete'); ?></button></div>
            <!--<div class="pull-right m-t-10"> <button class="btn btn-info" id="edit">Edit</button></div>-->
            <!--<div class="pull-right m-t-10"> <button class="btn btn-primary" data-toggle="modal" data-target="#importmodal">Import File</button></div>-->
            <div class="pull-right m-t-10"> <button  class="btn btn-success pull-right m-t-10 cls110" id="add"><?php echo $this->lang->line('button_add'); ?> </button></a></div>
           
            <!--<div class="pull-right m-t-10"> <button class="btn btn-info btnClass" id="downloadFile" name="downloadFile" style="width: 125px;">Download Sample</button></div>-->
        
        </ul>
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

                                    <div cass="col-sm-6">
                                        <div class="searchbtn row clearfix pull-right" >
                                            <div class="pull-right"><input type="text" id="search-table"  style="margin-right:0px !important;" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>
                                            <br>
                                            <!-- <div > <input type="checkbox" id="select_all" /> Select all</div> -->
                                        </div>
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
    <!-- END FOOTER -->
</div>

<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h4 id="modalTitle"></h4>
                </div>
            </div>

            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="error-box modalPopUpText modalTitleText " id="errorboxdata" ></div>
                </div>
            </div>
            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>

                    <div class="col-sm-8" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" >Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
                                <!--                                <li data-target="#myCarousel" id="myCarousel0" class="active"></li>
                                                                <li data-target="#myCarousel" ></li>
                                                                <li data-target="#myCarousel" ></li>-->
                                <!--<li data-target="#myCarousel" ></li>-->

                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox" id='imagedata'>
                                <!--                                <div class="item active" id="imagedata0">
                                                                </div>
                                                                <div class="item" id="imagedata1">
                                                                </div>
                                                                <div class="item" id="imagedata2">
                                                                </div>-->
                                <!--                                <div class="item" id="imagedata3">
                                                                </div>-->



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



<div class="modal fade stick-up" id="nutritionlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
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
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
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
<div class="modal fade stick-up" id="unitListModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
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
<div class="modal fade stick-up" id="negativeAttributesList" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
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
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
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
        <div class="modal-content" style="    width: 70%;margin-left: 0%;">
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
       <input type="file" name="file"  id="importDataFromFile"  class="form-control"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="uploadFileData">Upload</button>
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
                <h4 class="modal-title">Download Sample File</h4>
            </div>
            <div class="modal-body">
                <p class="error-box modalPopUpText">Are you sure you want to download the sample file..</p>
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
                <p class="error-box modalPopUpText"></p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade stick-up" id="viewDescriptionlist" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Detailed Description</h4>
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
        <div class="modal-content" style="    width: 100%;margin-left: 0%;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='margin: 10px;'>
                <i class="pg-close"></i>
            </button>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Short Description</h4>
            </div>
            <div class="modal-body form-horizontal">
                <div id="shortDescriptionData"></div>
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

                 <!-- Modal -->
                 <div class="modal fade" id="bulkModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Product Information</h4>
        </div>
        <div class="modal-body bulkList">
                  <!-- <div class="col-md-6 col-sm-6 col-xs-6">
                        <span style="" class="bulklist"></span>
                  </div> -->
                  <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:2%;text-align: center;">SI NO.</th>
                            <th style="width:10%;text-align: center;">Product No.</th>
                        </tr>
                    </thead>
                    <tbody id="bulkListData">

                    </tbody>
                </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
      
    </div>
  </div>

