

<?php

//error_reporting(0);

if ($status == 5) {
    $vehicle_status = 'New';
    $new = "active";
    echo '<style> .searchbtn{float: left;  margin-right: 63px;}.dltbtn{float: right;}</style>';
} else if ($status == 2) {
    $vehicle_status = 'Accepted';
    $accept = "active";
} else if ($status == 4) {
    $vehicle_status = 'Rejected';
    $reject = 'active';
} else if ($status == 2) {
    $vehicle_status = 'Free';
    $free = 'active';
} else if ($status == 1) {
    $active = 'active';
}
?>



 

<style>
      .style_prevu_kit
{
    display:inline-block;
    border:0;
    
    position: relative;
    -webkit-transition: all 200ms ease-in;
    -webkit-transform: scale(1); 
    -ms-transition: all 200ms ease-in;
    -ms-transform: scale(1); 
    -moz-transition: all 200ms ease-in;
    -moz-transform: scale(1);
    transition: all 200ms ease-in;
    transform: scale(1);   

}
.style_prevu_kit:hover
{
    
    box-shadow: 0px 0px 150px #000000;
    z-index: 2;
    -webkit-transition: all 200ms ease-in;
    -webkit-transform: scale(1.5);
    -ms-transition: all 200ms ease-in;
    -ms-transform: scale(1.5);   
    -moz-transition: all 200ms ease-in;
    -moz-transform: scale(1.5);
    transition: all 200ms ease-in;
    transform: scale(1.5);
}
    span{
        font-weight: 600;
    }
    #selectedcity{
        display: none;
    }
    .hint-text{
        display: none;
    }
    .table>tbody>tr>td {
    vertical-align: middle;
}
</style>

<script type="text/javascript">
        
   <?php
        $pricingModel = '';
            foreach ($pricingModelData as $row)
            $pricingModel = $row['pricingModel'];
                ?>
        var pricingModel = '<?php echo $pricingModel?>';
       
  
  
    
    $(document).ready(function () {
        
        if(pricingModel == 1)
        {
            $('.pricingModelSet').hide();
        }else{
            
            $('.pricingModelSet').show();
        }
        
     $('.cs-loader').show();
     $('#selectedcity').hide();
     var table = $('#big_table');
     var searchInput = $('#search-table');
     searchInput.hide();
     table.hide();
        var status = '<?php echo $status; ?>';

         
         setTimeout(function() {
    
        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url() ?>index.php?/vehicle/datatable_vehicletype/' + status,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
            
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
                  $('#big_table_processing').hide();
                   table.show()
                searchInput.show()
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
    
        table.dataTable(settings);
        }, 1000);
          

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });

         

     table.on('click', '.ordering', function () {
     
     if($('#selectedcity').val()  != '0')
     {

            var data = $(this).attr('data');
            var typeid = $(this).attr('id');
            var row = $(this).closest('tr');
            var currid = $(this).closest('tr').children('td:eq(0)').text();
//            alert(currid);
            var previd = $(this).closest('tr').next().find("td:eq(0)").text();
//            alert(previd);
            var nextid = $(this).closest('tr').prev().find("td:eq(0)").text();
//            alert(nextid);
            var prev_id = '', curr_id = '', next_id = '';

            if (data == '2') {
                curr_id = currid;
//                alert(curr_id);
                prev_id = previd;
//                alert(prev_id);
            } else if (data == '1') {
                curr_id = currid;
                prev_id = nextid;
            }
            

            if (typeof curr_id === "undefined" || typeof prev_id === "undefined" || curr_id === '' || prev_id === '' ) {
                alert("Can't perform.");
            }
            else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('index.php?/vehicle') ?>/vehicletype_reordering",
                    data: {prev_id: prev_id, curr_id: curr_id},
                    dataType: "JSON",
                    success: function (result) {
//                            alert(result.flag);
                        if (result.flag == '1') {
                        
                            if (data == '2') {
                                row.insertAfter(row.next());
//                                alert("changed");
                            } else if (data == '1') {
                                row.prev().insertAfter(row);
//                                alert("changed");
                            }
                        }
                            
                       else {
                            alert("Sorry,Not changed try again.");

                        }


                    },
                    error: function ()
                    {
                        alert("Error..!While updating data");
                    }
                });
            }
          }
          else{
                 $('#alertForNoneSelected').modal('show');
                 $("#display-data").text("Please select the city and then try to change the order");
          
          }

        });
        
     
        
     
        
        $(document).on('click','.pricing',function()
        {
          
          
            $('#min_fare').text('<?php echo $appConfigData['currencySymbol'];?> '+$(this).attr('min_fare'));
            $('#price_min').text('<?php echo $appConfigData['currencySymbol'];?> '+$(this).attr('price_per_min'));
            $('#price_km_mile').text('<?php echo $appConfigData['currencySymbol'];?> '+$(this).attr('price_per_km'));
            $('#waiting_charge').text('<?php echo $appConfigData['currencySymbol'];?> '+$(this).attr('waiting_charge'));
            
            var m = 'Miles';
            if($(this).attr('mileageMetric') == 0)
                m = 'Km';
            $('.mileageMetric').text(m);
            $('#mileagePrice').text('<?php echo $appConfigData['currencySymbol'];?> '+$(this).attr('mileagePrice'));
            
            $('.minimumKmMiles').text($(this).attr('minimum_km_miles'));
            $('.waitingMin').text($(this).attr('waiting_minutes'));
            $('.waiting_charge').text('<?php echo $appConfigData['currencySymbol'];?> '+$(this).attr('waiting_charge'));
            
            $('.cancelMin').text($(this).attr('cancellation_minutes'));
            $('#cancellationFee').text('<?php echo $appConfigData['currencySymbol'];?> '+$(this).attr('cancellation_fee'));
            
            $('.cancelScheduledMin').text($(this).attr('scheduledBookingCancellationMin'));
            $('#cancellationScheduledFee').text('<?php echo $appConfigData['currencySymbol'];?> '+$(this).attr('scheduledBookingCancellationFee'));
            
             $('#zonalDis').text('');
               $('#zonalEn').text('');
            if($(this).attr('longHaulEnDis') == 0)
                 $('#zonalDis').text('Disabled');
             else
                  $('#zonalEn').text('Enabled');
 
           
            $('#pricingModel1').modal('show');
        });
        
        $(document).on('click','.uploadImages',function()
        {
            if($(this).attr('id') == "on_img")
                $('#on_image_upload').trigger('click');
            else if($(this).attr('id') == "off_img")
                $('#off_image_upload').trigger('click');
            else if($(this).attr('id') == "map_img")
                $('#map_image_upload').trigger('click');
        });
        
        $('#save_image').click(function ()
        {
           
            if($('#on_image_upload').val() == '' && $('#off_image_upload').val() == '' && $('#map_image_upload').val() == '')
            {
                 alert('Nothing to update');
                 $('.close').trigger('click');
             }
            else
            {
                $('#form_uploadImage').submit();
            }
                 
        });
        
        
       $(document).on('click','.images',function ()
        {
            $('#vehicleType_id').val($(this).attr('type_id'));
             $('#doc_body').empty();
             var html = "<tr><td style='text-align: center;'>";
                        html += "SELECTED </td><td style='text-align: center;'><img  id=img1 src=" + $(this).attr('on_image')+ " style='height:46px;width:52px' class='img-circle style_prevu_kit'></td>";
                        html += "<td style='text-align: center;'>" +"<button type=button class='btn btn-default' style='width:inherit'><i class='fa fa-download' aria-hidden='true'></i> <a target='__blank' href="+ $(this).attr('on_image')+ " download="+ $(this).attr('on_image')+"> DOWNLOAD</a></button></td>";
                         html += "</tr>";
                         
                         
                        html += "<tr><td style='text-align: center;'>";
                        html += "UNSELECTED</td><td style='text-align: center;'> <img id=img2 src="+ $(this).attr('off_image')+ " style='height:46px;width:52px' class='img-circle style_prevu_kit'></td>";
                        html += "<td style='text-align: center;'>" + "<button type=button class='btn btn-default' style='width:inherit'><i class='fa fa-download' aria-hidden='true'></i> <a target='__blank' href=" +$(this).attr('off_image')+ " download="+ $(this).attr('on_image')+"> DOWNLOAD</a></button></td>";
                        
                        
                        html += "<tr><td style='text-align: center;'>";
                        html += "MAP IMAGE</td><td style='text-align: center;'><img id=img3 src=" + $(this).attr('map_image')+ " style='height:46px;width:52px' class='img-circle style_prevu_kit'></td>";
                        html += "<td style='text-align: center;'>" + "<button type=button class='btn btn-default' style='width:inherit'> <i class='fa fa-download' aria-hidden='true'></i> <a target='__blank' href="+ $(this).attr('map_image')+ " download="+ $(this).attr('map    _image')+"> DOWNLOAD</a></button></td>";


                        $('#doc_body').append(html);
           $('#imagesModel').modal('show');
        });



       
//           

        $('#companyid').change(function () {

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
                "sAjaxSource": '<?php echo base_url() ?>index.php?/vehicle/datatable_vehicletype',
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 20,
                "oLanguage": {
               
                },
                "fnInitComplete": function () {
                    //oTable.fnAdjustColumnSizing();
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
            };

            table.dataTable(settings);

            // search box for table
            $('#search-table').keyup(function () {
                table.fnFilter($(this).val());
            });

        });

    });
</script>
<style>
    #companyid{
        display: none;
    }

</style>

<script>
    $(document).ready(function () {
     
        
      
        $(".taskerTypeDiv").show();
        $("#define_page").html("Vehicle Type");
        $('.vehicle_type').addClass('active');
        $('.vehicle_type').attr('src',"<?php echo base_url();?>/theme/icon/vehicle types_on.png");
//        $('.vehicletype_thumb').addClass("bg-success");



        var table = $('#tableWithSearch1');

        var settings = {
            "autoWidth": false,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "sPaginationType": "bootstrap",
            "destroy": true,
            "scrollCollapse": true,
            "oLanguage": {
                "sLengthMenu": "_MENU_ ",
                "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
            },
            "iDisplayLength": 20,
            "order": [[0, "desc"]]
        };

//        table.dataTable(settings);

//          
//         $('#search-table1').keyup(function() {
//            table.fnFilter($(this).val());
//        });

        $("#edit_vehicletype").click(function () {

            $("#display-data").text("");


            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                  $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLETYPE_ANYONE); ?>);
            }
            else if (val.length > 1)
            {
                  $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLETYPE_ONLYONE); ?>);
            }
            else {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('index.php?/vehicle') ?>/editvehicletype",
                    data: {val: val},
                    dataType: 'JSON',
                    success: function (response)
                    {

                    }


                });
                window.location = "<?php echo base_url() ?>index.php?/vehicle/vehicletype_addedit/edit/" + val;



            }
        });


        $("#delete_vehicletype").click(function () {

            $("#display-data").text("");
            var val = $('.checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (val.length == 0) {
                  $('#alertForNoneSelected').modal('show');
                $("#display-data").text(<?php echo json_encode(POPUP_VEHICLETYPE_ATLEASTONE); ?>);
            }
            else if (val.length >= 1)
            {

                var size = $('input[name=stickup_toggler]:checked').val()
                var modalElem = $('#confirmmodel');
                if (size == "mini")
                {
                    $('#modalStickUpSmall').modal('show')
                }
                else
                {
                    $('#confirmmodel').modal('show')
                    if (size == "default") {
                        modalElem.children('.modal-dialog').removeClass('modal-lg');
                    }
                    else if (size == "full") {
                        modalElem.children('.modal-dialog').addClass('modal-lg');
                    }
                }
                $("#errorboxdata").text(<?php echo json_encode(POPUP_VEHICLETYPE_SUREDELETE); ?>);

                $("#confirmed").click(function () {


                    //    if(confirm("Are you sure to Delete " +val.length + " vehicletypes")){
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo base_url('index.php?/vehicle') ?>/delete_vehicletype",
                        data: {val: val},
                        dataType: 'JSON',
                        success: function (response)
                        {
                            //  alert(response.msg);

                            $('.checkbox:checked').each(function (i) {
                                $(this).closest('tr').remove();
                            });
                            $(".close").trigger("click");

                        }


                    });
                });
            }

        });
        
        $(document).on('click','.vehicleDetails',function ()
        {
            var length_metric = 'Feet';
            if($(this).attr('length_metric') == 'M')
                length_metric = 'Meter';
            
            var width_metric = 'Feet';
            if($(this).attr('width_metric') == 'M')
                width_metric = 'Meter';
            
            var height_metric = 'Feet';
            if($(this).attr('height_metric') == 'M')
                height_metric = 'Meter';
            
             $('.v_length').text('-');
            if($(this).attr('length'))
                $('.v_length').text($(this).attr('length')+' '+length_metric);
           
            $('.v_width').text('-');
            if($(this).attr('width'))
                $('.v_width').text($(this).attr('width')+' '+width_metric);
            
             $('.v_height').text('-');
            if($(this).attr('height'))
            $('.v_height').text($(this).attr('height')+' '+height_metric);
        
            $('.v_capacity').text('-');
            if($(this).attr('capacity'))
                $('.v_capacity').text($(this).attr('capacity'));
            $('#vehicleDetailsPopup').modal('show');
        });




    });


    function refreshTableOnActualcitychagne(){

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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/vehicle/datatable_vehicletype',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
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
            }
        };

        table.dataTable(settings);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });


    }
    function changeTaskerType(){

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
            "sAjaxSource": '<?php echo base_url() ?>index.php?/vehicle/datatable_vehicletype/'+$('#taskerType').val(),
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url(); ?>theme/assets/img/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
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
            }
        };

        table.dataTable(settings);

        // search box for table
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });
    }

</script>

<style>
    .exportOptions{
        display: none;
    }
</style>



<div class="page-content-wrapper" style="padding-top: 20px">
   
    
    <!-- START PAGE CONTENT -->
    <div class="content">
        


        <div class="brand inline" style="  width: auto;">
             <strong >VEHICLE TYPES</strong>
        </div>
        <!-- START JUMBOTRON -->
        <div class="row" style="margin-top: 1%">
              <div class="col-md-12 col-sm-12 col-xs-12">
    


                <div class="panel panel-transparent ">
                   
                   <ul class="nav nav-tabs nav-tabs-fillup bg-white" style="padding: 0.5%;">
                                
                                  <div class="pull-right m-t-10" style="margin-right: 1%;"> <button class="btn btn-danger btn-cons " id="delete_vehicletype"><?php echo BUTTON_DELETE; ?></button></a></div>
                        <div class="pull-right m-t-10"> <button class="btn btn-info btn-cons" id="edit_vehicletype"><?php echo BUTTON_EDIT; ?></button></a></div>
                       

                        <div class="pull-right m-t-10"><a href="<?php echo base_url() ?>index.php?/vehicle/vehicletype_addedit/add"> <button class="btn btn-primary btn-cons" ><?php echo BUTTON_ADD; ?></button></a></div>

                    </ul>
                   
       
                   <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12" style="margin-top: 1%;">
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
                                    
                                    <div>
                   
                            <div class="form-group " >
                             
                                <div class="col-sm-8" style="width: auto;
                                     
                                     margin-bottom: 10px;margin-left:-0.9%" >
                
                                </div>
                            </div>
                           
                </div>

                                   
                                      <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="<?php echo SEARCH; ?>"> </div>
                                 

                                    
                                   
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
       

<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                  <span class="modal-title">DELETE</span> 
                   <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                     <div class="col-sm-4" ></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6" >
                        <button type="button" class="btn btn-danger  pull-right" id="confirmed" >Delete</button>
                         <div class="pull-right m-t-10"> <button type="button" data-dismiss="modal" class="btn btn-default btn-cons" id="cancel">Cancel</button></div>
                    </div>
                </div>
            </div>
        </div>  
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade" id="pricingModel1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <span class="modal-title" style="color:#0090d9;">PRICING DETAILS</span> 
        </div>
        <div class="modal-body">
            <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->
            
            <form data-parsley-validate="" class="form-horizontal form-label-left">
                <div class="form-group pricingModelSet">
                    
                 
                    <label for="address" class="col-sm-5 control-label">Mileage Metric</label>
                    <div class="col-sm-5">
                        <span class="mileageMetric"></span> 
                    </div>
                </div>
                <div class="form-group pricingModelSet">
                    <label for="address" class="col-sm-5 control-label">Mileage Price Per <span class="mileageMetric"></span></label>
                    <div class="col-sm-5">
                        <span id="mileagePrice"></span> 
                    </div>
                    
                </div>
                <div class="form-group pricingModelSet">
                    <label for="address" class="col-sm-5 control-label">Minimum Fare Upto (<span class="minimumKmMiles"></span> <span class="mileageMetric"></span>)</label>
                    <div class="col-sm-5">
                        <span id="min_fare"></span> 

                    </div>
                    
                </div>
      
                <div class="form-group pricingModelSet">
                    <label for="address" class="col-sm-5 control-label">Waiting Charge After <span class="waitingMin"></span> Minutes</label>
                    <div class="col-sm-5">
                        <span id="waiting_charge"></span> 

                    </div>
                    <div class="col-sm-3 error-box" id=""></div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-5 control-label">On Demand Bookings Cancellation Charge After <span class="cancelMin"></span> Minutes</label>
                    <div class="col-sm-5">
                        <span id="cancellationFee"></span> 
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-5 control-label">Scheduled Bookings Cancellation Charge After <span class="cancelScheduledMin"></span> Minutes</label>
                    <div class="col-sm-5">
                        <span id="cancellationScheduledFee"></span> 
                    </div>
                </div>
             
                <div class="form-group">
                    <label for="address" class="col-sm-5 control-label">Long Haul Enabled</label>
                    <div class="col-sm-5">
                        <span id="zonalEn" style="color:green"></span> 
                        <span id="zonalDis" style="color:red;"></span> 
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<div class="modal fade" id="imagesModel" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
           <span class="modal-title">IMAGES</span> 
        </div>
        <div class="modal-body">
            <!--<b><p id="bus_type" style="color:dodgerblue;"></p></b>-->
            
           <table class="table table-bordered">
                <thead>
                  <tr>
                   
                    <th style="width:20%;text-align: center;"></th>
                    <th style="width:10%;text-align: center;">PREVIEW</th>
                    <th style="width:41%;text-align: center;">ACTION</th>
                    
                  </tr>
                </thead>
               <tbody id="doc_body">

              </tbody>
              </table>
        </div>
        <div class="modal-footer">
            
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<!--          <button type="button" class="btn btn-success" id="save_image">SAVE</button>-->
        </div>
      </div>
      
    </div>
  </div>

<div class="modal fade" id="vehicleDetailsPopup" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
            <strong style="color:#0090d9;">VEHICLE TYPE DETAILS</strong>
        </div>
        <div class="modal-body">
           
           
             <br>
             <div class="form-group row" style="  margin-left: 7%;">
                <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Length</label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <span style="" class="v_length"></span>
                </div>
                
            </div>
                <div class="form-group row" style="  margin-left: 7%;">
                <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Width</label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <span style="" class="v_width"></span>
                </div>
                      <div class="col-md-3 col-sm-3 col-xs-3"></div>
            </div>
                <div class="form-group row" style="  margin-left: 7%;">
                <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Height</label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <span style="" class="v_height"></span>
                </div>
                      <div class="col-md-3 col-sm-3 col-xs-3"></div>
            </div>
                <div class="form-group row" style="  margin-left: 7%;">
                <label class="control-label col-md-5 col-sm-5 col-xs-5" for="first-name">Load Bearing Capacity (<?php if($appConfigData['weight_metric'] == 0) echo 'Kg'; else echo 'Pound';?>)</label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <span style="" class="v_capacity"></span>
                </div>
                      <div class="col-md-3 col-sm-3 col-xs-3"></div>
            </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


<form id="form_uploadImage"  enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?>index.php?/vehicle/uploadVehicleTypeImage">
    <input type="hidden" id="vehicleType_id" name="vehicleType_id">
         
               <input type="file"  name="on_image_upload" id="on_image_upload" style="display: none" onchange="document.getElementById('img1').src = window.URL.createObjectURL(this.files[0])">
               <input type="file"  name="off_image_upload" id="off_image_upload" style="display: none" onchange="document.getElementById('img2').src = window.URL.createObjectURL(this.files[0])">
               <input type="file" name="map_image_upload" id="map_image_upload" style="display: none" onchange="document.getElementById('img3').src = window.URL.createObjectURL(this.files[0])">
            </form>