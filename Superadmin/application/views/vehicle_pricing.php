<script>
    $(document).ready(function () {
        
        var table = $('#big_table1');
        $('.cs-loader').show();
            $('#city_select').hide();
            $('#tableWithSearch_wrapper1').hide();
            
         
            var searchInput = $('#search-table');
            searchInput.hide();
            table.hide();
 setTimeout(function() {
        var settings = {
            "autoWidth": true,
            "sDom": "<'table-responsive't><'row'<p i>>",
            "destroy": true,
            "scrollCollapse": true,
            "iDisplayLength": 20,
          
            "bProcessing": true,
             "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
           "columnDefs": [
                { "width": "8%", "targets": 0 }
              ],
                      "fnInitComplete": function () {
                      table.show()
                       $('.cs-loader').hide()
                       searchInput.show()
                       
                        $('#city_select').show()
                        $('#tableWithSearch_wrapper1').show()
                        
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
        $('#search-table').keyup(function () {
            table.fnFilter($(this).val());
        });
        
      }, 1000);
      
      
      
       $('[id^=zone_vehicle_price]').keypress(function (event) {
           if (event.which < 44
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if ((event.which == 45 && $(this).val().indexOf('-') != -1) || (event.which == 46 && $(this).val().indexOf('.') != -1)) {
                event.preventDefault();
            } // prevent if already dot
        });
        
        $('#save').click(function ()
        {
            var isBlack = false;
           $('input:text').each(function(){
                if( $(this).val().length == 0)
                {
                    isBlack = false;
                   $(".error").text('Please enter price for all vehicles');
                }
                else
                {
                     isBlack = true;
                    $(".error").text('');
                }
            }); 
            
            if(isBlack)
                $('#vehiclePriceForm').submit();
            
        });
 });
</script> 

<style>
    .table-responsive {
    overflow-x: hidden;
    }
</style>

<?php

$ZoneId = '';
    foreach ($zones_data['zones_price'] as $object=>$value)
    {

        if($zone_to_id == $object)
             $ZoneId = $object;
      
    }

?>

<div class="page-content-wrapper"style="">
    <!-- START PAGE CONTENT -->
    <div class="content">
        
        <div class="brand inline" style="  width: auto;">
           <strong>ZONES</strong>
        </div>
        <!-- START JUMBOTRON -->
          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <?php
                  $fromZone = '';
                  $toZone = '';
//                  foreach ($zones_data as $zone)
//                  {
                      if((string)$zones_data['_id'] == $zone_from_id)
                          $fromZone = $zones_data['title'];
                      
                      if($zone['_id'] == $zone_to_id)
                          $toZone = $zones_data['title'];
                      

                  ?>
     

                <div class="panel panel-transparent ">
				<ol class="breadcrumb" style="margin-bottom:0px">
                                <li><a href="<?php echo  base_url().'index.php?/superadmin/zones';?>">Zones</a></li>
                                <li><a href="<?php echo  base_url().'index.php?/superadmin/zone_pricing/'.$zone_from_id;?>"><?php echo $fromZone;?></a></li>
                                <li class="active"><a href="#"><?php echo $Fromzone_name;?></a></li>      
                              </ol>

                    <div class="tab-content">
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
                                     paddingng: 0px;
                                     margin-bottom: 10px;margin-left: -0.7%" >
                                     <!--   <select class="form-control" id="city_select" style="background-color:gainsboro;height:30px;font-size:11px;display: none;" >
                                            <option value="">Select City</option>
                                            <?php
                                            foreach ($cities as $data) {
                                                ?>
                                            <option value="<?php echo $data->City_Name; ?>" lat="<?php echo $data->City_Lat; ?>" lng="<?php echo $data->City_Long; ?>"><?php echo ucfirst(strtolower($data->City_Name)); ?></option>    
                                                <?php
                                            }
                                            ?>
                                        </select>-->

                                </div>
                            </div>

                                
                </div>
                                       
                                       <div class="pull-right"><input type="text" id="search-table" class="form-control pull-right" placeholder="Search " style="display: none;"> </div>
                                               
                                </div>
                               &nbsp;
                               
                                 
                                <div class="panel-body" >
                                    <form id="vehiclePriceForm" method="post" action="<?php echo  base_url().'index.php?/superadmin/insert_vehicle_price/'.$zone_from_id.'/'.$zone_to_id;?>">
                                    <div id="tableWithSearch_wrapper1" class="dataTables_wrapper no-footer" style="display: none;">
                                          <div class="table-responsive">
                                              <table id="big_table1" border="1" cellpadding="2" cellspacing="1" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="big_table_info" style="">
                                                <thead>
                                        <tr style= "font-size:10px"role="row">
                                            <th  class="sorting ui-state-default sorting_asc" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" aria-sort="ascending" style="width:10%!important"><div class="DataTables_sort_wrapper" style="text-align: center;">Sl No.<span class="DataTables_sort_icon css_right ui-icon ui-icon-triangle-1-n"></span></div></th><th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" ><div class="DataTables_sort_wrapper">TYPE ID<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                            <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" ><div class="DataTables_sort_wrapper" style="text-align: center;">TYPE NAME<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                            <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" ><div class="DataTables_sort_wrapper" style="text-align: center;">TYPE DESCRIPTION<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>
                                            <!--<th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" ><div class="DataTables_sort_wrapper">CITY<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>-->
                                            <th class="sorting ui-state-default" tabindex="0" aria-controls="tableWithSearch" rowspan="1" colspan="1" aria-label="Activities: activate to sort column ascending" ><div class="DataTables_sort_wrapper">SET PRICE (<?php echo currency;?>)<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span></div></th>

                                        </tr>
                                    </thead>
                                    <tbody id="table_zone">
                                       
                                              <?php
                                              $sl = 0;
                                            foreach ($vehicleType_data as $row) {
                                               
                                                    
                                                ?>
                                            <tr role="row" class="odd">
                                                <td><?php echo ++$sl;?></td>
                                                <td><?php echo $row->type_id;?></td>
                                                <td><?php echo $row->type_name;?></td>
                                                <td><?php echo $row->type_desc;?></td>
						<td>
                                                    <?php 
//                                                    $vehiclePrice;
//                                                   
//                                                    print_r($zones_data['zones_price'][$zone_to_id]);
////                                                    if($zone_to_id == )
//                                                        foreach ($zones_data['zones_price'][$zone_to_id] as $value)
//                                                        {
//                                                           print_r($value);
//                                                         
////                                                                        if($value == $row->type_id)
////                                                                            $vehiclePrice = $value;
//                                                       }
                                                    
                                                    ?>
                                                        <input type="text" id="zone_vehicle_price<?php echo $row->type_id;?>"  class="autonumeric form-control" name="price[<?php echo $row->type_id;?>]"  placeholder="Enter price" value="<?php echo $zones_data['zones_price'][$zone_to_id][$row->type_id];?>"></td>
                                                        <input type="hidden" id="selected_zone">
                                                  
                                                    
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                            
                                    </tbody>  
                                </table>
                            </div>
                                    </div> 
                                    </form>
                                        <div class="error" style="text-align: center;color:red"></div><button id="save" class="btn btn-success pull-right">Save</button> 
                               </div>
							  
                            </div>
<!--                             END PANEL -->
                        </div>
                    </div>
                </div>
              </div>


        </div>
    
</div>
</div>

   