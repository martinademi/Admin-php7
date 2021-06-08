
<?php if ($this->session->flashdata('message')) { ?>
    <div align="center" id="flashdata" class="alert alert-danger">      
        <?php echo $this->session->flashdata('message') ?>
    </div>
<?php } ?>

<style>
    /* .btn{
        border-radius: 25px !important;
    } */
    .dataTables_scrollHead{
        margin-bottom: -52px !important;
    }

    .btn {
    border-radius: 25px !important;
    }

    .carousel-inner > .item > img,
    .carousel-inner > .item > a > img {
        width: 70%;
        margin: auto;
    }

    .nav-md .container.body .right_col {
    padding: 0% 2% 0 3% !important;
    margin-left: 230px !important;
    }

    
    .panel-heading {
        padding: 0px;
    }

    .customfooter{
        /* margin-left: 0px !important; */
        display:none !important;
    }
   

</style>
<script>
$(document).ready(function (){

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

$(document).on('click','.fg-button',function(){
    $("#select_all").prop("checked", false);
});  

  $("body").on('click','#select_all',function(){ 
    if(this.checked){
        $('.checkbox1').each(function(){
            this.checked = true;
        });
    }else{
         $('.checkbox1').each(function(){
            this.checked = false;
        });
    }
});


   $("body").on('click','.checkbox1',function(){ 
       
        if($('.checkbox1:checked').length == $('.checkbox1').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }   
   });

});
</script>
<script>
    $(document).ready(function () {

        citiesList();
        $('#inactivate').hide();


         /*date picker*/
         var date = new Date();
        $('.datepicker-component').datepicker({
        });

        $('.datepicker-component').on('changeDate', function () {
          $(this).datepicker('hide');
        });
      
        $('#datepicker-component').on('changeDate', function () {
            $('.datepicker').hide();
        });



  /*changes strtrt*/


// Delete offer
        // $("body").on('click', '#delete', function (){        
        //     var status = 3;
        //     var val = [];
        //     $(':checkbox:checked').each(function(i){
        //       val[i] = $(this).val();
        //     });
        //     updateCampaignStatus(val, status);
        // });
        
$('#delete').click(function(){
        $("#modalFooter").html("");
        var val=[];
        $(':checkbox:checked').each(function(i){
            val[i]=$(this).val();
        });
    if(val.length==0){
        var modalText = 'Please select at least one code to Delete';
                var button = '<button type="button" class="btn btn-primary pull-right" data-dismiss="modal">CLOSE</button>';
                    $('#modalBodyText').text(modalText);
                    $("#modalFooter").append(button);
                    $("#confirmmodels").modal();
        }else{
            $('#modalBodyText').text('');
            $("#modalFooter").text('');
            var modalText = 'Do you want to continue to Delete';

            $('#modalBodyText').text(modalText);
            var deleteButton = '<button type="button" class="btn btn-primary pull-right"  id="confirmDelete" style="margin:0;">YES</button>"';
            $("#modalFooter").append(deleteButton);
            $("#confirmmodels").modal();

        }

   });


$("body").on('click', '#confirmDelete', function (){        
            var status = 3;
            var val = [];
            $(':checkbox:checked').each(function(i){
              val[i] = $(this).val();
            });
            updateCampaignStatus(val, status);
 }); 



//**********delete********** 

//*******deactivate****

 $('#inactivate').click(function(){
        $("#modalFooter").html("");
        var val=[];
        $(':checkbox:checked').each(function(i){
            val[i]=$(this).val();
        });
    if(val.length==0){
        var modalText = 'Please select at least one code to Deactivate';
                var button = '<button type="button" class="btn btn-primary pull-right" data-dismiss="modal">CLOSE</button>';
                    $('#modalBodyText').text(modalText);
                    $("#modalFooter").append(button);
                    $("#confirmmodels").modal();
        }else{
            $('#modalBodyText').text('');
            $("#modalFooter").text('');
            var modalText = 'Do you want to continue to Deactivate';

            $('#modalBodyText').text(modalText);
            var deleteButton = '<button type="button" class="btn btn-primary pull-right"  id="confirmDeativate" style="margin:0;">YES</button>"';
            $("#modalFooter").append(deleteButton);
            $("#confirmmodels").modal();

        }

   });


$("body").on('click', '#confirmDeativate', function (){        
            var status = 2;
            var val = [];
            $(':checkbox:checked').each(function(i){
              val[i] = $(this).val();
            });
            updateCampaignStatus(val, status);
        });
//*******************deactivate***********



//***************active **************
$("#active").click(function(){
         $("#modalFooter").html("");
       // var status = 1;
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
         
        });
        if (val.length ==0) {
            var modalText = 'Please select at least one code to activate';
            var button = '<button type="button" class="btn btn-primary pull-right" data-dismiss="modal">CLOSE</button>';
                $('#modalBodyText').text(modalText);
                $("#modalFooter").append(button);
                $("#confirmmodels").modal();
        }else{
            $('#modalBodyText').text('');
                $("#modalFooter").text('');
                $('#confirmeds').attr('data_id', '');
                $('#confirmeds').attr('status', '');
                $('#confirmeds').attr('updateType', '');
                //var offerId = $(".checkbox1:checked").val();
               //alert(offerId);
                var modalText = 'Do you want to continue to Activate';

                $('#modalBodyText').text(modalText);
                var deleteButton = '<button type="button" class="btn btn-primary pull-right"  id="confirmActivate" style="margin:0;">YES</button>"';
                $("#modalFooter").append(deleteButton);
                $("#confirmmodels").modal();

       
            
        }
   });

     // Activate offer
     $("body").on('click', '#confirmActivate', function (){        
            var status = 1;
            var val = [];
            $(':checkbox:checked').each(function(i){
              val[i] = $(this).val();
            });
            updateCampaignStatus(val, status);
        });

// ****************************************end*************************

/*changes end*/

        $('#big_table_processing').show();
        $('.cs-loader').show();
        var table = $('#big_table');
        $('#big_table').fadeOut('slow');
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 10,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/productOffers/offer_details/0/',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 10,
            "oLanguage": {
            },
            "fnInitComplete": function () {
                $('#big_table').fadeIn('slow');
                $('#big_table_processing').hide();
                $('.cs-loader').hide();
            },
            'fnServerData': function (sSource, aoData, fnCallback)
            {
                let city = {
                    "name":"cityId",
                    "value":$('#citiesList').val()
                }

                aoData.push(city);

                let search={
                    "name":"name",
                    "value":$('#search-tables').val()
                }
                aoData.push(search);
                
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

       $('#search-tables').keyup(function () {
                table.fnFilter($(this).val());
        });

        $("#citiesList").change(function(){
            table.fnFilter($('#search-table').val());
        });
        
        //from date to end date
         $("#searchData").click(function(){

                var st = $("#start").datepicker().val();
                var stDate = st.split("/")[2] + '-' + st.split("/")[0] + '-' + st.split("/")[1];
                var end = $("#end").datepicker().val();
                var enDate = end.split("/")[2] + '-' + end.split("/")[0] + '-' + end.split("/")[1];
               
               var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 10,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/productOffers/offer_details/0/'+stDate+'/'+enDate,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 10,
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
                window.location.href = '<?php echo base_url(); ?>index.php?/productOffers/EditProducts/' + val;
            }

        });
        $('#add').click(function () {
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();
            if (val.length == 0) {
                window.location.href = "<?php echo base_url(); ?>index.php?/productOffers/addNewOffer";
            } else {
                $('#errorModal').modal('show')
                $(".modalPopUpText").text('Invalid Selection...');
            }
        });

        setTimeout(function () {
            $('#flashdata').hide();
        }, 3000);

        $('#myCarousel').carousel({
            pause: true,
            interval: false,

        });

        $('#big_table').on("click", '.imglist', function () {
            $('#indicator').html('');
            $('#imagedata').html('');
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/productOffers/imagelist/' + id,
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


       
        $('#big_table').on("click", '.viewDetailedDescriptionlist', function () {
            $('#descriptionData').empty();
            var id = $(this).attr('id');

            console.log(id);
            $.ajax({
                url: '<?php echo base_url() ?>index.php?/productOffers/viewDescriptionlist/' + id,
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
                url: '<?php echo base_url() ?>index.php?/productOffers/viewShortDescriptionlist/' + id,
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

        
        $('#big_table').on("click", '.unitsList', function () {

            $('#unitListData').empty();
            var id = $(this).attr('id');

            $.ajax({
                url: '<?php echo base_url() ?>index.php?/productOffers/unitsList/' + id,
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


            /*chnage mode for active*/
            $('.changeMode').click(function () {
                var table = $('#big_table');
                        $('#big_table').fadeOut('slow');
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
                                $('#big_table_processing').hide();
                                $('.cs-loader').hide();
                            },
                            'fnServerData': function (sSource, aoData, fnCallback)
                            {
                                let city = {
                                    "name":"cityId",
                                    "value":$('#citiesList').val()
                                }

                                aoData.push(city);

                                let search={
                                    "name":"name",
                                    "value":$('#search-tables').val()
                                }
                                aoData.push(search);

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

                         $('#search-tables').keyup(function () {
                                table.fnFilter($(this).val());
                        });

                        $("#citiesList").change(function(){
                            table.fnFilter($('#search-table').val());
                        });


                        $('.tabs_active').removeClass('active');

                        $(this).parent().addClass('active');

                        
                    
                    });
            /*chnage end*/

            //clear function
            $('.clearData').click(function(){

              $('#start').val('');
              $('#end').val('');   
             });


            //click function
            $('.whenclicked li').click(function(){
                if ($(this).attr('id') == "my1") {
                    console.log("1");
                    $('#add').show();
                    $('#inactivate').hide();
                    $('#delete').show();
                    $('#active').show();

                    


                }else if($(this).attr('id')=="my2"){
                    console.log("2");
                    $('#active').hide();
                    $('#add').show();
                    $('#delete').show();
                    $('#inactivate').show();


                }else if($(this).attr('id')=="my3"){
                    console.log("3");
                    $('#inactivate').hide();
                    $('#active').show();
                    $('#add').show();
                    $('#delete').show();



                }else if($(this).attr('id')=="my4"){
                    console.log("4");
                    $('#active').hide();
                    $('#inactivate').hide();
                    $('#add').hide();
                    $('#delete').hide();

                  }


            });

    //UPDATE THE STATUS
     // Function to update campaign status
    function updateCampaignStatus(couponIds, status){
            $.ajax({
                    
                    url: "<?php echo base_url('index.php?/productOffers/updatecouponCodeStatus');?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        offerId : couponIds,
                        status : status
                    },
            })
            .done(function(json) {
                console.log(json);
                if (json.msg.message === "Successfully Updated") {
                  
                    $('#big_table').DataTable().ajax.reload();
                    $("#confirmmodels").modal('hide')
                    // window.location.reload();
                }else{
                    alert('Unable to update status. Please try agin later');
                }
            });
        }

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

    function citiesList(){
        $.ajax({
                url: "<?php echo APILink ?>" + "admin/city",
                type: 'GET',
                dataType: 'json',
                headers: {
                  language: 0
                },
                data: {                  
                },
            }).done(function(json) {

                console.log(json);
                
                $("#citiesList").html('<option value="" selected>Select City</option>');
                
                 for (var i = 0; i< json.data.length; i++) {
                
                    var citiesList = "<option value="+ json.data[i].id + " currency="+ json.data[i].currency + ">"+  json.data[i].cityName +"</option>";
                    $("#citiesList").append(citiesList);  
                }
              
        });
     }

</script>


<div class="page-content-wrapper" style="padding-top: 20px">
    <!-- START PAGE CONTENT -->
    <div class="content">

        <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"> </strong>
        </div>
        <!-- Nav tabs -->
        <!--button for active changes-->
        <div class="brand inline" style="  width: auto;
             font-size: 16px;
             color: gray;
             margin-left: 7px;padding-top: 20px;padding-bottom:10px;">

            <strong style="color:#0090d9;">PRODUCT OFFERS</strong><!-- id="define_page"-->
        </div>
        <ul class="nav nav-tabs bg-white whenclicked">
                           <li id= "my1" class="tabs_active active<?php //echo $accept ?>" style="cursor:pointer">
                                <a  class="changeMode accepted_" id="tabnew" data="<?php echo base_url(); ?>index.php?/productOffers/offer_details/0/">
                                    <span>NEW</span>
                                </a>
                            </li>
                            <li id= "my2" class="tabs_active <?php //echo $accept ?>" style="cursor:pointer">
                                <a  class="changeMode accepted_" id="tabactive" data="<?php echo base_url(); ?>index.php?/productOffers/offer_details/1/">
                                    <span>ACTIVE</span>
                                </a>
                            </li>
                            <li id= "my3" class="tabs_active <?php //echo $accept ?>" style="cursor:pointer">
                                <a  class="changeMode accepted_" id="tabinactive" data="<?php echo base_url(); ?>index.php?/productOffers/offer_details/2/">
                                    <span>INACTIVE</span>
                                </a>
                            </li>
                            <li id= "my4" class="tabs_active <?php //echo $reject ?>" style="cursor:pointer">
                                <a  class="changeMode rejected_" id="tabexpired" data="<?php echo base_url(); ?>index.php?/productOffers/offer_details/3/">
                                    <span>EXPIRED</span>
                                </a>
                            </li>
                           
                            <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10 cls111" id="delete">DELETE </button></a></div>
                            <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10 cls111" id="inactivate">INACTIVATE </button></a></div>
                            <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10 cls111" id="active">ACTIVATE </button></a></div>
                            <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10 cls110" id="add">CREATE </button></a></div>
         </ul>
        <!--button end-->
       
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

                                     <div class="col-sm-6 form-group">
                                                <label for="fname" class="col-sm-1 control-label aligntext" style="padding: 0%; margin-top: 2%;">CITIES <span ></span></label> 
                                                <div class="col-sm-4">
                                                    <select id="citiesList" name="company_select" class="form-control" style="padding: 1%; margin-top: 1%;">
                                                    <!-- <option disabled selected value> None Selected</option> -->
                                                    </select>
                                                </div>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                          
                                    <div class="col-sm-5 row input-daterange input-group" style="float: left;margin-top: 1%;">
												<input type="text" class="input-sm form-control datepicker-component" name="start" id="start" placeholder="From Date">
												<span class="input-group-addon">to</span>
												<input type="text" class="input-sm form-control datepicker-component" name="end"  id="end" placeholder="To Date">
                                            </div>
                                            <div class="col-sm-1 " style="margin-left: 10px;margin-top: 1%;">
                                             <button class="btn btn-primary" style="width: 60px !important;" type="button" id="searchData">Search</button>
                                            </div>
                                            <div class="col-sm-1 " style="margin-left: 10px;margin-top: 1%;">
                                             <button class="btn btn-primary clearData" style="width: 60px !important;" type="button" id="clear">Clear</button>
                                            </div>
                                            <div class="col-sm-5 row pull-right">
                                                <div class="pull-right"><input type="text" id="search-tables" class="form-control pull-right" placeholder="<?php echo $this->lang->line('search'); ?>"> </div>
                                            </div>
                                     </div>
                                   
									
										
									<div class="panel-body">
										<?php
										echo $this->table->generate();
										?>
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


<div class="modal fade stick-up" id="importmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="  width: 110%;">
            <form action="<?php echo base_url(); ?>index.php?/productOffers/importExcel" method="post" name="upload_excel" enctype="multipart/form-data">

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
                <div class="modal-footer">
                    <div class="row">
                        <button type="submit" id="submit" name="import" class='btn btn-primary pull-right'>Import</button>
                    </div>
                </div>
                <!-- /.modal-dialog -->
            </form>
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


<div class="modal fade " id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Confirmation</h4>
            </div>
            <br>
            <div class="modal-body">
                <div class="row">
                    <div class="" id="modalBodyText" ></div>

                </div>
            </div>

            <br>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" id="modalFooter">
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
