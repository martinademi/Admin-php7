
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
    padding: 10px 20px 0px!important;
    margin-left: 230px !important;
    }

    
    .panel-heading {
        padding: 0px;
    }

    .customfooter{
        margin-left: 0px !important;
        /* display:none !important; */
    }

    .container-fluid {
    padding-right: 0px !important;
    padding-left: 1px !important;
    }
    .btn {
        font-size: 10px !important;
    }

</style>
<script>

    $(document).ready(function (){

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

        $("#delete").click(function(){
        
        var status = 3;
        var val = $('.checkbox1:checked').map(function () {
                return this.value;
            }).get();
        if (val.length ==0) {
            var modalText ='<?php echo $this->lang->line('alert_delete'); ?>';
                $('#errorpara').text(modalText);
                $("#offererrorModal").modal('show');
        }else{
            console.log("deletellll");
            var modalText ='<?php echo $this->lang->line('alert_deletemsg'); ?>';
            $('#confirmpara').text(modalText);
            $('#confirmButton').val(status);
            $("#offerconfirmModal").modal('show');
        // updateCampaignStatus(val, status);
    }
   });           

//deactivate
 $("#inactivate").click(function(){
        
        var status = 2;
        var val = $('.checkbox1:checked').map(function () {
                return this.value;
            }).get();
        if (val.length ==0) {
            var modalText = '<?php echo $this->lang->line('alert_deactivate'); ?>';
            $('#errorpara').text(modalText);
            $("#offererrorModal").modal('show');
        }else{
            var modalText = '<?php echo $this->lang->line('alert_deactivatemsg'); ?>';
            $('#confirmpara').text(modalText);
            $('#confirmButton').val(status);
            $("#offerconfirmModal").modal('show');
        // updateCampaignStatus(val, status);
    }
   });

//active 
     $("#active").click(function(){
      
        var status = 1;
        var val = $('.checkbox1:checked').map(function () {
                return this.value;
            }).get();
        if (val.length ==0) {
            var modalText = '<?php echo $this->lang->line('alert_activate'); ?>';
            $('#errorpara').text(modalText);
            $("#offererrorModal").modal('show');
        }else{
            var modalText = '<?php echo $this->lang->line('alert_activatemsg'); ?>';
            $('#confirmpara').text(modalText);
            $('#confirmButton').val(status);
            $("#offerconfirmModal").modal('show');
        // updateCampaignStatus(val, status);
    }
   });	

    $("#confirmButton").click(function(){
        var val = $('.checkbox1:checked').map(function () {
                return this.value;
            }).get();
        var status =  $("#confirmButton").val();
        updateCampaignStatus(val, status);
    })

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

        // "data": function (d) {
        //  d.cityId = $("#citiesList").val();
        //  return d;
       
       $('#search-tables').keyup(function () {
                table.fnFilter($(this).val());
        });

        $("#citiesList").change(function(){
            table.fnFilter($('#search-table').val());
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

                console.log(this.id);
                console.log( $(this).attr('data'));
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
                        $('.tabs_active').removeClass('active');

                        $(this).parent().addClass('active');

                        
                    
                    });
            /*chnage end*/


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
                if (json && json.msg.message === "Successfully Updated") {
                  
                     $('#big_table').DataTable().ajax.reload();
                     $("#offerconfirmModal").modal('hide');
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

        <!-- <div class="brand inline" style="  width: auto; margin-left: 30px;padding-top: 20px;">
            <strong style="color:#0090d9;font-size: 14px;"> </strong>
        </div> -->
        <!-- Nav tabs -->
        <!--button for active changes-->
        <!-- <div class="brand inline" style="  width: auto;
             font-size: 16px;
             color: gray;
             margin-left: 7px;padding-top: 20px;padding-bottom:10px;">

            <strong style="color:#0090d9;">PRODUCT OFFERS</strong>
        </div> -->
        <!-- id="define_page"-->
        <div class="brand inline" style="  width: auto;">
        <?php echo $this->lang->line('heading_page'); ?>
        </div>
        <div class="panel panel-transparent ">
        <ul class="nav nav-tabs bg-white whenclicked">
                           <li id= "my1" class="tabs_active active<?php //echo $accept ?>" style="cursor:pointer">
                                <a  class="changeMode accepted_" id="tabnew" data="<?php echo base_url(); ?>index.php?/productOffers/offer_details/0/">
                                    <span><?php echo $this->lang->line('heading_new'); ?> </span>
                                </a>
                            </li>
                            <li id= "my2" class="tabs_active <?php //echo $accept ?>" style="cursor:pointer">
                                <a  class="changeMode accepted_" id="tabactive" data="<?php echo base_url(); ?>index.php?/productOffers/offer_details/1/">
                                    <span><?php echo $this->lang->line('heading_active'); ?></span>
                                </a>
                            </li>
                            <li id= "my3" class="tabs_active <?php //echo $accept ?>" style="cursor:pointer">
                                <a  class="changeMode accepted_" id="tabinactive" data="<?php echo base_url(); ?>index.php?/productOffers/offer_details/2/">
                                    <span><?php echo $this->lang->line('heading_inactive'); ?></span>
                                </a>
                            </li>
                            <li id= "my4" class="tabs_active <?php //echo $reject ?>" style="cursor:pointer">
                                <a  class="changeMode rejected_" id="tabexpired" data="<?php echo base_url(); ?>index.php?/productOffers/offer_details/3/">
                                    <span><?php echo $this->lang->line('heading_expired'); ?></span>
                                </a>
                            </li>
                           
                            <div class="pull-right m-t-10"> <button class="btn btn-danger pull-right m-t-10" id="delete"><?php echo $this->lang->line('button_delete'); ?> </button></a></div>
                            <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10" id="inactivate"><?php echo $this->lang->line('button_inactivate'); ?></button></a></div>
                            <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10" id="active"><?php echo $this->lang->line('button_activate'); ?> </button></a></div>
                            <div class="pull-right m-t-10"> <button class="btn btn-success pull-right m-t-10" id="add"><?php echo $this->lang->line('button_create'); ?> </button></a></div>
         </ul>
         </div>
        <!--button end-->
       
        <!-- START JUMBOTRON -->
        <div class="parallax" data-pages="parallax">
            <div class="col-xs-12 container-fixed-lg sm-p-l-20 sm-p-r-20">

                <div class="row panel panel-transparent ">

                    <div class="tab-content">
                        <div class="col-xs-12 container-fixed-lg bg-white">
                            <!-- START PANEL -->
                            <div class="panel panel-transparent">
                                <div class="panel-heading">

                                    <!-- <div class="cs-loader">
                                        <div class="cs-loader-inner" >
                                            <label class="loaderPoint" style="color:#10cfbd">●</label>
                                            <label class="loaderPoint" style="color:red">●</label>
                                            <label class="loaderPoint" style="color:#FFD119">●</label>
                                            <label class="loaderPoint" style="color:#4d90fe">●</label>
                                            <label class="loaderPoint" style="color:palevioletred">●</label>
                                        </div>
                                    </div> -->

                                     <div class="col-sm-6 form-group" >
                                                <label for="fname" class="col-sm-1 control-label aligntext" style="padding: 0%; margin-top: 2%;display:none">CITIES <span ></span></label> 
                                                <div class="col-sm-4" style="display:none">
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
                                             <button class="btn btn-primary" style="" type="button" id="searchData"><?php echo $this->lang->line('button_search'); ?></button>
                                            </div>
                                           
                                            <div class="row pull-right">
                                                <div class="pull-right"><input type="text" id="search-tables" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
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

<div id="offererrorModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Alert</h4>
      </div>
      <div class="modal-body">
        <div class="error-box modalPopUpText" id = "errorpara"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="offerconfirmModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Alert</h4>
      </div>
      <div class="modal-body">
        <div class="error-box modalPopUpText" id = "confirmpara"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-status ="" id="confirmButton">Ok</button>
      </div>
    </div>

  </div>
</div>
