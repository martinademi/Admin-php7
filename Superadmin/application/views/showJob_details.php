

<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }
    
    strong {
        display: none;
    }
    
/*    .page-sidebar
    {
       display: none; 
    }*/
    
    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>
     <?php

     $startLat = '13.019568';
     $startLong = '77.596813';
     
     $i = 1;
     $routes = array();
    
     $routes[] = array('','12.990058','77.552492',0);
//     $routes[] = array('','13.124257','77.619603',0);
     $routes[] = array('','12.986801','77.609398',0);
     $routes[] = array('','12.899623','77.482698',0);
//     foreach ($data['res']['receivers'] as $trip_data)
//     {
//
//             $routes[] = array('', $trip_data['location']['lat'], $trip_data['location']['log'], $i);
//             $i++;
//
//     }

    
//$start = $routes[0];
//

//
$end = end($routes);

$endLat = $end[1];
$endLong = $end[2];


         
   

   
          


?>    

<style>
    
    
    table{
        width: 100%;
      
    }
    #trip_loc {
    padding: 10px;
    border: 2px solid gray;
    margin-left:35px;
}

label, input, button, select, textarea {
  font-size: 14px;
  font-weight: normal;
  line-height: 33px;
}

textarea {
  width: 202px;
  max-width: 202px;
  overflow:hidden;
  margin-left: -10%;
  border: none;
  height: 66px;
  max-height: 100px;
  color: darkcyan;
}

input {
  background-color: transparent;
  border: 0px solid;
  height: 34px;
  width: 175px;
  color: darkcyan;
  margin-left: -10%;
  }
  
  .row {
  margin-right: -15px;
  margin-left: -12px;
  margin-top: 1%;
}

textarea{
    width: 100%;
}
  
  .colon{
      margin-top: 2%;
        margin-left: -7%;
  }

hr {
    width: 97%;
  display: block;
  height: 2px;
  border: 1;
  border-top: 1px solid #ccc;
  margin: 3em 0;
  padding: 3px;
  border-width: 2px;
  border-color: #CCC;
  border-top: 2px solid #8c8b8b;
}

.col-lg-3 {
  width: 24%;
}

</style>
<div class="header  nav nav-tabs  bg-white" style="margin-left: 7%;
     height: 2px"><h3 style="color:dimgrey;margin-top:2%">JOB DETAILS
  </h3></div>
<div class="row" style="margin-top: 6%;">
 
<!--    <b><h3>Trip Details</h3></b>-->
    <div class="row" style="height:60%;" >
        <div class="col-lg-3" id="trip_loc">
         
            <div class="control-group row" style="margin-bottom: -15%;margin-top: -3%;">
                <div class="col-sm-6"><label class="control-label"><b>TRIP DETAILS</b></label></div>
                <hr>
            </div>
            
            
           <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Booking Id</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" readonly=" " value="<?php echo $data['appt_data']->appointment_id;?>"></div>
            </div>

             <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Sub Booking Id</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" readonly=" " value="<?php echo $trip_data['subid'];?>"></div>
            </div>
            
              <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Booking Type</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" readonly=" " value="<?php if($data['appt_data']->appt_type == 1) echo "Now"; else "Later";?>"></div>
            </div>
            
             <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Booking Time</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="waiting_time" readonly=" " id="waiting_time" value="<?php echo date('g:i A',  strtotime($data['appt_data']->created_dt));?>"></div>
            </div>
            
            <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Customer</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="cname" id="cname" readonly=" " value="<?php echo $data['customer_data']->first_name;?>"></div>
            </div>
            
                 <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Phone</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"> <input type="text" class="" name="phone" id="phone" readonly=" " value="<?php echo $data['customer_data']->phone;?>"></div>
            </div>
           
            <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Email</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="email"  readonly=" " id="email" value="<?php echo $data['customer_data']->email;?>"></div>
            </div>
            
            <div class="control-group row" style="margin-bottom: 13%;">
                <div class="col-md-5"><label class="control-label">Pickup Address</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"> <textarea readonly><?php echo $data['appt_data']->address_line1;?></textarea></div>
            </div>
            
<!--            <div class="control-group row" >
                <div class="col-md-5"><label class="control-label">Pickup Time</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"> <input type="text" class="" name="p_addr" id="p_addr" value="<?php echo $data['appt_data']->start_dt;?>"></div>
            </div>-->
            
<!--            <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Drop Address</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><textarea><?php echo $data['appt_data']->drop_addr1;?></textarea></div>
            </div>-->
            
<!--            <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Drop Time</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="drop_time" id="drop_time" value="<?php echo $data['appt_data']->complete_dt;?>"></div>
            </div>-->
            
<!--            <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Waiting Time</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="waiting_time" id="waiting_time" value="<?php echo $data['appt_data']->waiting_mts."  Minutes";?>"></div>
            </div>-->
            

            
<!--            <div class="control-group row" >
                <div class="col-md-5"><label class="control-label">Total Trip Distance</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="trip_distance" id="trip_distance" value="<?php 
//                if($data['appt_data']->distance_in_mts != NULL)
//                {    
//                
//                    echo bcdiv($data['appt_data']->distance_in_mts, '1609.344', 2); 
//                     echo " Miles";
//                }
                
                
                ?>"></div>
            </div>-->

<!--          <div class="control-group row" >
                <div class="col-md-5"><label class="control-label">Total Trip Time</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="trip_time" id="trip_time" value="<?php echo $data['appt_data']->start_dt;?>"></div>
            </div>
            
            <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Parking Fee</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="parking_fee" id="parking_fee" value="<?php echo $data['appt_data']->parking_fee." $";?>"></div>
            </div>
            
            <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Airport Fee</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="parking_fee" id="parking_fee" value="<?php echo $data['appt_data']->airport_fee." $";?>"></div>
            </div>
            
            <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Meter Fee</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="parking_fee" id="parking_fee" value="<?php echo $data['appt_data']->meter_fee." $";?>"></div>
            </div>
            
            <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Toll</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"> <input type="text" class="" name="toll" id="toll" value="<?php echo $data['appt_data']->toll_fee." $";?>"></div>
            </div>
            
            <div class="control-group row" style="margin-bottom: -4%;">
                <div class="col-md-5"><label class="control-label">Tip</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="tip" id="tip" value="<?php echo $data['appt_data']->tip_amount." $";?>"></div>
            </div>
            -->
            
        </div>
        <div class="col-lg-5" id="trip_loc">
           
            <!--<script src="http://maps.google.com/maps/api/js?" type="text/javascript"></script>-->
              <script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE"
  type="text/javascript"></script>

            <!--<script src="https://maps.googleapis.com/maps/api/js"></script>-->
             <div id="map" style="width: 100%; height: 440px;"></div>

            <script type="text/javascript">
            var locations = '<?php echo json_encode($routes); ?>';
          
            var directionsDisplay;
            var directionsService = new google.maps.DirectionsService();
           
            if(locations != "")
            {
                    
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 10,
                        center: new google.maps.LatLng(<?php echo json_encode($startLat); ?>, <?php echo json_encode($startLong); ?>),
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });

                    var infowindow = new google.maps.InfoWindow();

                    var marker, i;
        
                    for (i = 0; i < locations.length; i++) {
                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                            map: map
                        });

                        google.maps.event.addListener(marker, 'click', (function (marker, i) {
                            return function () {
                                infowindow.setContent(locations[i][1]);
                                infowindow.open(map, marker);
                            }
                        })(marker, i));
                    }



                    directionsDisplay = new google.maps.DirectionsRenderer();

                    directionsDisplay.setMap(map);
                     var waypnt=[];
                    var route=<?php echo json_encode($routes); ?>;
                    route.forEach(function(val){
                        if((val[3]==0 || val[3]==route.length-1)){
                            console.log(val[3]  +'||'+route.length-1);
                            waypnt.push({
                                    location: new google.maps.LatLng(val[1],val[2]),
                                    stopover: true
                                  });
                        }
//                         console.log(waypnt);
                    });
                    
                   

                    var start = new google.maps.LatLng(<?php echo json_encode($startLat); ?>, <?php echo json_encode($startLong); ?>);
                    var end = new google.maps.LatLng(<?php echo json_encode($endLat); ?>, <?php echo json_encode($endLong); ?>);
                    var request = {
                        origin: start,
                        destination: end,
                         waypoints: waypnt,
                        optimizeWaypoints: true,
                        travelMode: google.maps.DirectionsTravelMode.DRIVING
                    };
                    directionsService.route(request, function (response, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(response);
                        }
                    });
            }
            else
            {
                
                 var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 10,
                        center: new google.maps.LatLng(<?php echo json_encode($data['appt_data']->appt_lat); ?>, <?php echo json_encode($data['appt_data']->appt_long); ?>),
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });

                    var infowindow = new google.maps.InfoWindow();

                    var marker, i;
      
                    directionsDisplay = new google.maps.DirectionsRenderer();

                    directionsDisplay.setMap(map);

                    var start = new google.maps.LatLng(<?php echo json_encode($data['appt_data']->appt_lat); ?>, <?php echo json_encode($data['appt_data']->appt_long); ?>);
                    var end = new google.maps.LatLng(<?php echo json_encode($data['appt_data']->drop_lat); ?>, <?php echo json_encode($data['appt_data']->drop_long); ?>);
                    var request = {
                        origin: start,
                        destination: end,
                        travelMode: google.maps.DirectionsTravelMode.DRIVING
                    };
                    directionsService.route(request, function (response, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(response);
                        }
                    });
                  
            }
        </script>
  

        </div>
        <div class="col-lg-3" id="trip_loc">
             
            <div class="control-group row" style="margin-bottom: -10%;margin-top: -3%;">
                <div class="col-sm-6"><label class="control-label"><b>DRIVER DETAILS</b></label></div>
                <hr>
            </div>
            
            <div class="control-group row">
                <div class="col-md-6">
                    <?php
                    if($data['driver_data']->profile_pic != NULL)
                    {
                    ?>
                    <img src="<?php echo base_url('/../../pics')?>/<?php echo $data['driver_data']->profile_pic?>" width="70px" height="70px" class="img-circle">
                  <?php
                    }  
                    else {
                        ?>
                        <img src="<?php echo base_url('/../../pics/user.jpg')?>" width="70px" height="70px" class="img-circle">
                    <?php
                    }?>
                </div>
                <div class="col-md-5">
                    <div>
                        <input type="text" class="" readonly=" " name="driver_name" id="driver_name" placeholder="Driver Name" value="<?php echo $data['driver_data']->first_name;?>">
                        
                
<!--                        <i style="margin-left: -11%;"class="fa fa-star"></i> <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>-->
                        
                    </div>
                
            </div>
           </div>
            
            <div class="control-group row" style="margin-top:2%;">
                <div class="col-md-5"><label class="control-label">Email</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" readonly=" "  value="<?php echo $data['driver_data']->email;?>"></div>
            </div>
            
             <div class="control-group row" style="margin-top:1%;">
                <div class="col-md-5"><label class="control-label">Phone</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id=""  readonly=" " value="<?php echo $data['driver_data']->mobile;?>"></div>
            </div>
            
            <div class="control-group row" style="margin-top:1%;">
                <div class="col-md-5"><label class="control-label">Ratings</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6">
                    <input type="text" class="" name="" id=""  readonly=" " value="<?php echo number_format($data['res']['rating'],1);?>">
                            <?php
            
//                        if($data['appt_data']->mas_rating_status == 1)
//                        {
//                         ?>
                        <!--<i style="margin-left: -11%;"class="fa fa-star"></i>-->
                        <?php
                        
//                        }  
//                        else if($data['master_rating_data']->mas_rating_status == 2)
//                        {
                         ?>
                           <!--<i style="margin-left: -11%;"class="fa fa-star"></i><i style=""class="fa fa-star"></i>-->
                        <?php
                        
//                        } 
//                        else if($data['master_rating_data']->mas_rating_status == 3)
//                        {
                         ?>
                          <!--<i style="margin-left: -11%;"class="fa fa-star"></i><i style=""class="fa fa-star"></i><i style=""class="fa fa-star"></i>-->
                        <?php
                        
//                        }
//                        else if($data['master_rating_data']->mas_rating_status == 4)
//                        {
                         ?>
                           <!--<i style="margin-left: -11%;"class="fa fa-star"></i><i style=""class="fa fa-star"></i><i style=""class="fa fa-star"></i><i style=""class="fa fa-star"></i>-->
                        <?php
                        
//                        } 
//                        else if($data['master_rating_data']->mas_rating_status == 5)
//                        {
                        ?>
                            <!--<i style="margin-left: -11%;"class="fa fa-star"></i><i style=""class="fa fa-star"></i><i style=""class="fa fa-star"></i><i style=""class="fa fa-star"></i><i style=""class="fa fa-star"></i>-->
                        <?php
                        
//                        } 
                        ?>
                </div>
            </div>
            
        </div>
        
<!--        <div class="col-lg-3" id="trip_loc" style="margin-top: 2%;">
            
            <div class="control-group row" style="margin-bottom: -10%;margin-top: -2%;">
                <div class="col-sm-6"><label class="control-label"><b>Trip Summary</b></label></div>
                <hr>
            </div>
           
            
            <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Trip Distance</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="trip_distance_s" id="trip_distance_s" value="<?php 
                if($data['appt_data']->distance_in_mts != NULL)
                {    
                
                    echo bcdiv($data['appt_data']->distance_in_mts, '1609.344', 2); 
                    echo " Miles";
                }
                 ?>"></div>
            </div>
            
            <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Trip Duration</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php echo gmdate("H:i:s",($data['appt_data']->duration * 60));?>"></div>
            </div>
            
            <div class="control-group row" >
                <div class="col-md-5"><label class="control-label">Distance Fee</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php print_r($data['car_data']->price_per_km * bcdiv($data['appt_data']->distance_in_mts, '1609.344', 2)." $");?>"></div>
            </div>
            
            <div class="control-group row" >
                <div class="col-md-5"><label class="control-label">Time Fee</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php print_r($data['car_data']->price_per_min * $data['appt_data']->duration." $");?>"></div>
            </div>
            
            <div class="control-group row" >
                <div class="col-md-5"><label class="control-label">Parking Fee</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"> <input type="text" class="" name="" id="" value="<?php echo $data['appt_data']->parking_fee." $";?>"></div>
            </div>
            
            <div class="control-group row" >
                <div class="col-md-5"><label class="control-label">Subtotal</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php print_r($data['appt_data']->meter_fee + $data['appt_data']->parking_fee + $data['appt_data']->toll_fee + $data['appt_data']->airport_fee." $");?>"></div>
            </div>
            
            <div class="control-group row" >
                <div class="col-md-5"><label class="control-label">Discounts</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php echo $data['appt_data']->discount." $";?>"></div>
            </div>
            
            <div class="control-group row" >
                <div class="col-md-5"><label class="control-label">Final Fare</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php echo $data['appt_data']->amount." $";?>"></div>
            </div>
            
            <div class="control-group row" style="margin-bottom:17%;">
                <div class="col-md-5"><label class="control-label">Payment Method</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"> <input type="text" class="" name="" id="" value="<?php if($data['appt_data']->payment_type == 1)echo 'Card';else echo 'Cash';?>"></div>
            </div>
        </div>-->
    
    </div>
<!--<div class="row" style="height:60%;" >
            <?php
            foreach ($data['res']['receivers'] as $trip_data)
            {
                ?>
     <div class="col-lg-3" id="trip_loc">
          
 

            <div class="control-group row" style="margin-bottom: -15%;margin-top: -3%;">
                <div class="col-sm-7"><label class="control-label"><b>SHIPMENT DETAILS</b></label></div>
                <hr>
            </div>
            
            <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Booking Type</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php if($data['appt_data']->appt_type == 1) echo "Now"; else "Later";?>"></div>
            </div>
         
         <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Sub Booking Id</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php echo $trip_data['subid'];?>"></div>
            </div>
         
         <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Address</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><textarea><?php echo $trip_data['address'];?></textarea></div>
            </div>
         
         <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Drop Time</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php echo $trip_data['completedTime'];?>"></div>
            </div>
         
         <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Signed By</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php echo $trip_data['name'];?>"></div>
            </div>
         
         <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Signee’s number</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php echo $trip_data['mobile'];?>"></div>
            </div>
         
          <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Signature</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value=""></div>
            </div>
         
          <div class="control-group row">
                <div class="col-md-5"><label class="control-label">Status</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php echo $trip_data['status'];?>"></div>
            </div>
     </div>
    
    <div class="col-lg-3" id="trip_loc">
             
            <div class="control-group row" style="margin-bottom: -10%;margin-top: -3%;">
                <div class="col-sm-6"><label class="control-label"><b>ITEM DETAILS</b></label></div>
                <hr>
            </div>
            
            <div class="control-group row">
                <div class="col-md-4">
                    <?php
                    if($trip_data['photo'] != NULL || $trip_data['photo'] != '')
                    {
                    ?>
                    <img src="<?php echo $trip_data['photo'];?>" width="70px" height="70px" class="img-circle">
                  <?php
                    }  
                    else {
                        ?>
                        <img src="<?php echo base_url('/../../pics/user.jpg')?>" width="70px" height="70px" class="img-circle">
                    <?php
                    }?>
                </div>
                <div class="col-md-8">
                    <div class="row">
                    <div class="col-sm-4">
                       <label class="control-label">Weight</label>
                       
                    </div>
                    <div class="col-sm-1 colon">:</div>
                    <div class="col-sm-5">
                        <input type="text" class="" name="Weight" id="Weight" placeholder="Weight" value="<?php echo $trip_data['weight'];?>">
                        
                    </div></div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                       <label class="control-label">Quantity</label>
                       
                    </div>
                    <div class="col-sm-1 colon">:</div>
                    <div class="col-sm-5">
                        <input type="text" class="" name="Quantity" id="Quantity" placeholder="Quantity" value="<?php echo $trip_data['quantity'];?>">
                        
                    </div>
                    </div>
                
                </div>
                    
                    
                
           </div>
            
            <div class="control-group row" style="margin-top:2%;">
                <div class="col-md-5"><label class="control-label">Distance Fare</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name=""  value="<?php print_r($data['car_data']->price_per_km * bcdiv($data['appt_data']->distance_in_mts, '1609.344', 2)." $");?>"></div>
            </div>
            
             <div class="control-group row" style="margin-top:1%;">
                <div class="col-md-5"><label class="control-label">Time Fare</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php print_r($data['car_data']->price_per_min * $data['appt_data']->duration." $");?>"></div>
            </div>
            
            <div class="control-group row" style="margin-top:1%;">
                <div class="col-md-5"><label class="control-label">Base Fare</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="" id="" value="<?php echo $trip_data['Fare']." $";?>"></div>
            </div>
        
          <div class="control-group row" style="margin-top:1%;">
                <div class="col-md-5"><label class="control-label">Discount</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="Discount" id="Discount" value="<?php echo $data['appt_data']->discount." $";?>"></div>
            </div>
        
          <div class="control-group row" style="margin-top:1%;margin-bottom: 30%;">
                <div class="col-md-5"><label class="control-label">Total</label></div>
                <div class="col-md-1 colon">:</div>
                <div class="col-md-6"><input type="text" class="" name="Total" id="Total" value="<?php echo  $trip_data['Fare']." $";?>"></div>
            </div>
            
        </div>
        <?php
            }
            ?>
</div>-->
<div class="row" style="margin-left: 1%;">
  <?php
  

  $countDeliveries = 1;
            foreach ($data['res']['receivers'] as $trip_data)
            {
                ?>

    <div class="col-md-6">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-advance TB">
        <thead style="background-color: lavender;">
            <tr>
                <th style="font-size:18px;">DELIVERY <?php echo $countDeliveries;?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
               
                <td>
                    <img src="<?php echo base_url('theme/icon/pickup_small_icon.png');?>" class="img-rounded" alt="" width="20px" height="20px">
                    <b>  PICKUP ADDRESS :</b> <?php echo $data['appt_data']->address_line1;?>
                </td>
            </tr>
            <tr>
                <td>
                     <img src="<?php echo base_url('theme/icon/dropdown_small_icon.png');?>" class="img-rounded" alt="" width="20px" height="20px">
                 <b>   DROP ADDRESS : </b> <?php echo $trip_data['address'];?>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-advance TB" style="width:98%;">
                        <thead style="background-color: lavender;">
                            <tr>
                                <th>ITEM</th>
                                <th>PHOTO</th>
                                <th>WEIGHT</th>
                                <th>QTY</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>NA</td>
                                <td><?php
                                if($trip_data['photo'] != NULL || $trip_data['photo'] != '')
                                {
                                ?>
                                <img src="<?php echo $trip_data['photo'];?>" width="70px" height="70px" class="img-circle">
                              <?php
                                }  
                                else {
                                    ?>
                                    <img src="<?php echo base_url('/../../pics/user.jpg')?>" width="70px" height="70px" class="img-circle">
                                <?php
                                }?></td>
                                <td><?php echo $trip_data['weight'];?></td>
                                <td><?php echo $trip_data['quantity'];?></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-advance TB" style="margin-top: 2%;width: 98%;">
                       <tbody>
                           <tr>
                               <td style="width: 53%;">BASE FARE</td>
                                    <td><?php echo "$ ".$trip_data['Fare'];?></td>
                                </tr>
                                <tr>
                                    <td>DISTANCE</td>
                                    <td><?php print_r("$ ".$data['car_data']->price_per_km * bcdiv($data['appt_data']->distance_in_mts, '1609.344', 2));?></td>
                                </tr>
                                <tr>
                                    <td>TIME</td>
                                    <td><?php 
                                     print_r($data['res']['invoice'][$countDeliveries - 1]['TripTIme']);;?></td>
                                </tr>
                                <tr>
                                    <td>SUBTOTAL</td>
                                    <td><?php print_r("$ ".$data['appt_data']->meter_fee + $data['appt_data']->parking_fee + $data['appt_data']->toll_fee + $data['appt_data']->airport_fee);?></td>
                                </tr>
                                 <tr>
                                    <td>DISCOUNT</td>
                                    <td><?php echo "$ ".$data['appt_data']->discount;?></td>
                                </tr>
                                 <tr>
                                    <td>TOTAL</td>
                                    <td><?php echo  "$ ".$trip_data['Fare'];?></td>
                                </tr>
                       </tbody>
                            
                    </table>
                </td>
            </tr>
         
             <tr>
                 <td> <b>RECEIVED BY</b></td>
            </tr>
            <tr>
               
                <td><?php if($trip_data['signatureImg'] != "" && $trip_data['signatureImg'] != NULL)  
                            { ?>
                    <img src="<?php echo $trip_data['signatureImg'];?>" width="70px" height="70px" class="img-circle">
                       <?php
                       echo '<br>';
                        echo $trip_data['name'];?>  (<?php echo $data['customer_data']->phone;
                            }
                            else
                            {
                               
                            echo $trip_data['name'];?>  (<?php echo $data['customer_data']->phone;}?>)</td>
            </tr>
        </tbody>
    </table>
</div>
<?php
$countDeliveries++;
            }
            ?>
    </div>
</div>