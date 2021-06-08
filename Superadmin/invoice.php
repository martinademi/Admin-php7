<?php

////require_once 'Models/ConDBServices.php';
//
//    $host = "localhost";
//    $user = "Dayrunner";
//    $pass = "ShmdeUGtdbwg5esN";
//    $db = "Dayrunner";
//    $port = "27017";
//    
//    if (isset($_REQUEST['Order_id'])) {
//   
////        $m = new MongoClient('mongodb://'.$host.':'.$port);
////        $db = $m->selectDB($db);
////        $db->authenticate($user,$pass);
//        
//        $dsn = "mongodb://";
//            
//                $dsn .= "{$host}:{$port}";
//            $dsn .= "/{$db}";
//            
//                $options = array('username' => $user, 'password' => $pass);
//            
//          
//            $db = new MongoDB\Driver\Manager($dsn, $options);
////            $this->db = $this->connect;
//    print_r($db);
//        $collection = new MongoCollection($db, 'ShipmentDetails');
//        $shipmentDetails = $collection->findOne(array('order_id'=>(int)$_REQUEST['Order_id']));
//        
//        foreach ($shipmentDetails['receivers'] as $rec)
//        {
//            $amount = $rec['Accounting']['amount'];
//            $discount = $rec['Accounting']['discount'];
//            $weight = $rec['weight'];
//            $qty = $rec['quantity'];
//            $receiverName = $rec['name'];
//            $receiverMobile = $rec['mobile'];
//            $shipmentPhoto = $rec['photo'];
//            $receiverSign = $rec['signatureImg'];
//        }
//        $pickup_lat = $shipmentDetails['pickup_location']['latitude'];
//        $pickup_lng = $shipmentDetails['pickup_location']['longitude'];
//        
//        $drop_lat = $shipmentDetails['drop_location']['latitude'];
//        $drop_lng = $shipmentDetails['drop_location']['longitude'];
//        
//}
//print_r($invoiceDetails);
foreach ($invoiceDetails['receivers'] as $rec)
        {
            $amount = $rec['Fare'];
          
            $weight = $rec['weight'];
            $qty = $rec['quantity'];
            $receiverName = $rec['name'];
            $receiverMobile = $rec['mobile'];
            $shipmentPhoto = $rec['driverPhoto'];
            $receiverSign = $rec['signatureUrl'];
        }
          $discount = $invoiceDetails['invoice']['Discount'];
        $pickup_lat = $invoiceDetails['pickup_location']['latitude'];
        $pickup_lng = $invoiceDetails['pickup_location']['longitude'];
        
        $drop_lat = $invoiceDetails['drop_location']['latitude'];
        $drop_lng = $invoiceDetails['drop_location']['longitude'];
//        $currencySMB = $;
//print_r($data);

?>
<!DOCTYPE html>
<html lang="it">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <title><?php echo APP_NAME;?> | INVOICE</title>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width">
      
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
      <style type="text/css">#ko_twocolumnBlock_6 .textsmallintenseStyle a, #ko_twocolumnBlock_6 .textsmallintenseStyle a:link, #ko_twocolumnBlock_6 .textsmallintenseStyle a:visited, #ko_twocolumnBlock_6 .textsmallintenseStyle a:hover {color: #fff;text-decoration: none;text-decoration: none;font-weight: bold;}
         #ko_twocolumnBlock_6 .textsmalllightStyle a:visited, #ko_twocolumnBlock_6 .textsmalllightStyle a:hover {color: #3f3d33;text-decoration: none;text-decoration: none;font-weight: bold;}
      </style>
      
   </head>
   <body style="margin: 0; padding: 0;" bgcolor="#f9f9f9" align="center">
   <style type="text/css">
  span.Weight {
    display: inline-block;
}
td.rt_col_head {
    color: #999999;
    font-size: 13px;
}

td.rt_col_head21 {
   
    font-size: 14px;
    font-weight: 500;
    width: 49%;
}
td.align-rt1 {
    text-align: right;
    float: right;
    width: 100%;
    font-size: 14px;
}
span.Weightright {
    float: right;
}
span.Weightright {
   
  color: #999999;
    font-size: 12px;
    font-weight: 500;
        text-align: center;
}
span.Weight {
    
 color: #999999;
    font-size: 12px;
    font-weight: 500;
        text-align: center;
        margin-left:24px;
}
	  hr {
    margin: 0px;
    background: #b3b3b3;
    opacity: 0.5;
}
body {    
    font-family: 'Open Sans', sans-serif;
}
td {
    font-family: 'Open Sans' !important;
}
         /* CLIENT-SPECIFIC STYLES */
         #outlook a{padding:0;} /* Force Outlook to provide a "view in browser" message */
         .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
         .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height: 100%;} /* Force Hotmail to display normal line spacing */
         body, table, td, a{-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
         table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} /* Remove spacing between tables in Outlook 2007 and up */
         img{-ms-interpolation-mode:bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */
         /* RESET STYLES */
         body{margin:0; padding:0;}
         img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
         table{border-collapse:collapse !important;}
         body{height:100% !important; margin:0; padding:0; width:100% !important;}
         /* iOS BLUE LINKS */
         .appleBody a{color:#68440a; text-decoration: none;}
         .appleFooter a{color:#999999; text-decoration: none;}
         /* MOBILE STYLES */
         @media screen and (max-width: 625px) {
           .generated {
    font-weight: 400;
    font-size: 13px !important;
}
         /* ALLOWS FOR FLUID TABLES */
         table[class="wrapper"]{
         width:100% !important;
         min-width:0px !important;
         }
         span.left_col_field
         {
           margin-left:0px !important;
         }
         p.left_col_head{
           margin-left:0px !important;
         }
         /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
         td[class="mobile-hide"]{
         display:none;}
         img[class="mobile-hide"]{
         display: none !important;
         }
      span.lasttrip {
    position: relative;
    top: 0px !important;    
    text-align: center !important;    
    width: 100%;
    display: inline-block;
    font-size:13px;
}

td.mobile_using {
    margin-top: 7px !important;
}
td.align-rt {
    text-align: right;
    font-size: 12px !important;
    font-weight: bold;
}
td.bold_txt {
        font-size: 13px !important;
}
         img[class="img-max"]{    
		    width: 50% !important;
    margin-top: 20px !important;
    margin-left: 80px;     
         }
         p.left_col_head {
    text-align: left !important;
}
         /* FULL-WIDTH TABLES */
         table[class="responsive-table"]{
         width:100%!important;
         }
         /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
         td[class="padding"]{
         padding: 10px 5% 15px 5% !important;
         }
         td[class="padding-copy"]{
         padding: 10px 5% 10px 5% !important;
         text-align: center;
         }
         td[class="padding-meta"]{
         padding: 30px 5% 0px 5% !important;
         text-align: center;
         }
         td[class="no-pad"]{
         padding: 0 0 0px 0 !important;
         }
         td[class="no-padding"]{
         padding: 0 !important;
         }
         td[class="section-padding"]{
         padding: 10px 5px 10px 5px !important;
         }
         td[class="section-padding-bottom-image"]{
         padding: 10px 15px 0 15px !important;
         }
         /* ADJUST BUTTONS ON MOBILE */
         td[class="mobile-wrapper"]{
         /*padding: 10px 5% 15px 5% !important;*/
         }
         table[class="mobile-button-container"]{
         margin:0 auto;
         width:100% !important;
         }
         a[class="mobile-button"]{
         width:80% !important;
         padding: 15px !important;
         border: 0 !important;
         font-size: 16px !important;
         }
         }
		 table#end_block tbody tr td {
    font-size: 12px!important;
    color: #232323!important;
    border: 1px solid #bfbfbf;
    padding: 3%!important;
}
table tr:last-child td:first-child {
    border-bottom-left-radius: 10px;
}

table tr:last-child td:last-child {
    border-bottom-right-radius: 10px;
}
p.left_col_head {
    font-size: 11px;
    color: #999999;
    font-family: sans-serif;
	margin-top:11px;
	margin-bottom:11px;
	margin-left:5px
}
tr.bottom_border {
    border-bottom: solid 1px #efe7e7;
}
.rt_col_head {
      font-family: sans-serif;
    font-size: 15px;
    
    padding-bottom: 7px;
    border-bottom: 1px solid #e0dcdc;
}
td.rt_col_head2 {
    font-family: sans-serif;
    color: #999999;
    font-size: 14px;
    font-weight: 500;
	width:59%
}
td.bold_txt {
    font-family: sans-serif;
    font-weight: 600;
    font-size: 15px;
}
span.left_col_field {
    font-family: sans-serif;
    font-size: 14px;
	margin-top:11px;
	margin-bottom:11px;
	margin-left:5px
}
td#app_det {
    font-size: 16px;
    font-family: sans-serif;
    text-align: left;
}
td.align-rt {
    text-align: right;
	font-size:14px;
  font-weight:bold;
}
span.lasttrip {
    text-align: right;
    float: right;
    position: relative;
    top: 28px;
}
.generated {
    font-weight: 400;
}


/*map css */
#map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #origin-input,
      #destination-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 200px;
      }

      #origin-input:focus,
      #destination-input:focus {
        border-color: #4d90fe;
      }

      #mode-selector {
        color: #fff;
        background-color: #4d90fe;
        margin-left: 12px;
        padding: 5px 11px 0px 11px;
      }

      #mode-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      td#app_det1 {
    height: 200px;
}
.gm-svpc {
    display: none;
}
.gmnoprint {
    display: none;
}
tr.delivery {
    border-bottom: solid 1px #efe7e7;
}
tr.bottom_border11 {
    border: 1px solid #e0dcdc;
}
span.phone {
    font-size: 14px;
    color: #999999;
}
p.left_col_head112 {
    margin: 0%;
    text-align: center;
    padding-bottom: 5px;
    border-bottom: solid 1px #efe7e7;
}
span.left_col_field {
    margin-left: 0px;
}
p.left_col_head {
    margin-left: 0;
}
td.rt_col_head {
    padding-top: 12px;
}
td.align-rt123 {
    font-size: 13px;
}
td.align-rt12 {
    color: #999999;
    font-size: 14px;
    font-weight: 500;
    text-align: center;
}
textarea {
    margin-top: 10px;
}


      </style>

      <!-- PREHEADER -->
      <table border="0" cellpadding="0" cellspacing="0" width="100%" id="ko_imageBlock_5">
         <tbody>
            <tr class="row-a">
               <td bgcolor="#f9f9f9" align="center" class="no-pad" style="padding-top: 0px; padding-left: 15px; padding-bottom: 0px; padding-right: 15px;">
                  <table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table">
                     <tbody>
                        <tr>
                           <td>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <!-- HERO IMAGE -->
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                             <tbody>
                                                <tr>
                                                   <td class="no-padding">
                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <img width="600" border="0" alt="" class="img-max" style="display: inline-block; padding: 0; color: #3F3D33; 
																  text-decoration: none; font-family: Helvetica, Arial, sans-serif; font-size: 16px; width: 175px;height:35px;margin-top:20px;"
																  src="<?php echo APP_SERVER_HOST.'/assests/.png';?>">
                                                               <span class="lasttrip" style=""> Your Last Trip on: <b><?php echo date('j F Y h:i a',  strtotime($invoiceDetails['appointment_dt']))?> </b></span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
      <table border="0" cellpadding="0" cellspacing="0" width="100%" id="ko_twocolumnBlock_6">
         <tbody>
            <tr class="row-a">
               <td bgcolor="#f9f9f9" align="center" class="section-padding" style="padding-top: 0px; padding-left: 15px; padding-bottom: 0px; padding-right: 15px;">
                  <table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table">
                     <tbody>
                        <tr>
                           <td>
                              <!-- TWO COLUMNS -->
                               
							  <table cellpadding="0" cellspacing="0" border="0" width="600" align="left" class="responsive-table" style="background:#fff;padding:2%;border: 1px solid #e6e3e3;">
								<tr><td style="font-size: 23px; letter-spacing:1px; padding: 10px;font-family: fantasy; font-weight: 700;width:50%"><?php echo $amount;?></td>
								    <td  class="mobile_using" style="float: right; color: #b2b2b2; margin-top: 20px; margin-right: 10px;font-family: sans-serif;letter-spacing: 1px;font-size: 13px;">Thanks for using <?php echo Appname.', '.$invoiceDetails['slaveName'];?></td>
									
								</tr>
							  </table>
							  
                              <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                 <tbody>
                                    <tr>
                                       <td valign="top" style="padding: 2%;background:#fff;border: 1px solid #e6e3e3; border-top: 0px;" class="mobile-wrapper">
                                          <!-- LEFT COLUMN -->
                                          <table cellpadding="5" cellspacing="0" border="0" width="46%" align="left" class="responsive-table" style="background:#fff;border:1px solid #f9f9f9">
                                             <tbody>
                                               
												<tr class="bottom_border">
												  <td colspan="3" id="app_det">
												    TRIP DETAILS
												  </td>
												</tr>
                                                                                                <tr class="bottom_border21">
												  <td colspan="3" id="app_det1">
												    <div id="map"></div>
												  </td>
												</tr>
												<tr class="bottom_border">
												  <td>
												    <p class="left_col_head" style="text-align: center;">JOB ID</p>
													<span class="left_col_field align_pro"  style="text-align: center;"><?php echo $invoiceDetails['order_id'];?></span>
												  </td>
												  <td>
												    <p class="left_col_head"></p>
													<span  class="left_col_field"></span>
												  </td>
												  <td>
												    <p class="left_col_head"  style="text-align: center;" >DATE AND TIME</p>
													<span  class="left_col_field align_pro"  style="text-align: center;"><?php echo date('d-m-Y h:i a',  strtotime($invoiceDetails['appointment_dt']));?> </span>
												  </td>
												</tr>
												<tr  class="bottom_border">
												  <td colspan="3">
												    <p class="left_col_head">PICKUP LOCATION</p>
													<span  class="left_col_field"><?php echo $invoiceDetails['address_line1'];?>
													</span>
												  </td>
												</tr>
                                                                                                <tr  class="bottom_border">
												  <td colspan="3">
												    <p class="left_col_head">DELIVERY LOCATION</p>
													<span  class="left_col_field"><?php echo $invoiceDetails['drop_addr1'];?>
													</span>
												  </td>
												</tr>
											
											    
                        <td class="rt_col_head" colspan="3">SHIPMENT DETAILS</td>
											  </tr>

                        <td colspan="3">
                            <img src="<?php echo $shipmentPhoto;?>" onerror="this.src='/smart/assests/shopping-cart.png'" style=" float: left;width:40px;height:30px;padding-top: 2px; margin-right: 15px;">
													<br>
                         <span class="Weight">WEIGHT<br>
                              <?php echo $weight;?>
                           </span>
                            <span class="Weightright">QUANTITY<br>
                                 <?php echo $qty;?>
                           </span>
												  </td>

                          
                          <tr class="bottom_border"><td class="rt_col_head" colspan="3">DESCRIPTION<br><span class="left_col_field"></span></td>
                        </tr>

                                           
                                             </tbody>
                                          </table>
                                          <!-- RIGHT COLUMN -->
                                          <table cellpadding="5" cellspacing="0" border="0" width="46%" align="right" class="responsive-table">
                                             <tbody>
                                                	<tr  class="bottom_border">
												  <td colspan="3">
												    <p class="left_col_head">DRIVER DETAILS</p>
				
     									<span><img src="<?php echo $invoiceDetails['driverDetails']['image'];?>"   style="margin-bottom:15px;float:left;margin-right:5px;width:40px;height:30px;"></span><span  class="left_col_field" style="margin-left:0px">
													<?php echo $invoiceDetails['driverDetails']['fName']." ".$invoiceDetails['driverDetails']['lName'];?><br>
													<?php echo $invoiceDetails['driverDetails']['mobile'];?>
													</span>
												  </td>
												</tr>											
												  
												<tr>
												  <td colspan="3" >
												    <p class="left_col_head" style="text-align:center">Issued on behalf of <?php echo $invoiceDetails['driverDetails']['fName']." ".$invoiceDetails['driverDetails']['lName'];?></p>
												  </td>
												</tr>
											  <tr>
											    <td class="rt_col_head" colspan="3">RECEIPT</td>	  </tr>                                         
												
												

                                                                                            <tr class="delivery1">
                                                                                            <td class="rt_col_head2">Time Fee</td>
										               <td  class="align-rt">
												    <?php echo $currencySMB." ".$invoiceDetails['invoice']['timeFare'];?>
												  </td>
                                                                                            </tr>
                                                                                              <tr class="delivery1">
                                                                                            <td class="rt_col_head2">Base Fee</td>
										               <td  class="align-rt">
												    <?php echo $currencySMB." ".$invoiceDetails['invoice']['baseFare'];?>
												  </td>
                                                                                            </tr>
                                                                                            <tr class="delivery1">
                                                                                            <td class="rt_col_head2">Distance Fee</td>
										               <td  class="align-rt">
												    <?php echo  $currencySMB." ". $invoiceDetails['invoice']['distFare'];?>
												  </td>
                                                                                            </tr>
                                                                                             <tr class="delivery1">
                                                                                            <td class="rt_col_head2">Toll Fee</td>
										               <td  class="align-rt">
												    <?php echo  $currencySMB." ". $invoiceDetails['invoice']['tollFee'];?>
												  </td>
                                                                                            </tr>
                                                                                            
												 <tr class="delivery1">
                                                                                            <td class="rt_col_head2">Waiting Fee</td>
										               <td  class="align-rt">
												    <?php echo  $currencySMB." ". $invoiceDetails['invoice']['watingFee'];?>
												  </td>
                                                                                            </tr>
                                                                                            <?php 
                                                                                            if( $invoiceDetails['invoice']['cancelationFee'] == 0){}else{?>
                                                                                             <tr class="delivery1">
                                                                                            <td class="rt_col_head2">Cancellation Fee</td>
										               <td  class="align-rt">
												    <?php echo  $currencySMB." ". $invoiceDetails['invoice']['cancelationFee'];?>
												  </td>
                                                                                            </tr>
                                                                                            <?php }?> 
                                                                                            <?php 
                                                                                            if( $invoiceDetails['invoice']['Discount'] == 0){}else{?>
                                                                                            <tr class="delivery1">
                                                                                            <td class="rt_col_head2">Discount</td>
										               <td  class="align-rt">
												    <?php echo  $currencySMB." ". $invoiceDetails['invoice']['Discount'];?>
												  </td>
                                                                                            </tr>
                                                                                            <?php }?> 
                                                                                            <tr class="delivery1">
                                                                                            <td ><?php echo Total?></td>
										               <td  class="align-rt">
												    <?php echo  $currencySMB." ".$invoiceDetails['invoice']['total'];?>
												  </td>
                                                                                            </tr>
												

                                                <tr><td class="rt_col_head" colspan="3">RECEIVER DETAILS</td>
											  </tr>
                       <tr class="">
												  <td class="rt_col_head21 ">
												   NAME:
												  </td>
												  <td class="align-rt1">
												     <?php echo $receiverName;?>
												  </td>
                          <tr class="">
												  <td class="rt_col_head21 ">
												    PHONE:
												  </td>
												  <td class="align-rt1">
												      <?php echo $receiverMobile;?>
												  </td>
                                                </tr>


                                                <tr style="font-size: 13px;width: 100%;">
												   <td colspan="3">
                                                                                                       <p class="left_col_head">SIGNATURE:<br>
                                                                                                           
                                                                            <img width="600" border="0" alt="" class="img-max" style="display: inline-block; padding: 0; color: #3F3D33; 
																  text-decoration: none; font-family: Helvetica, Arial, sans-serif; font-size: 16px; width: 175px;height:35px;margin-top:20px;"
																  src="<?php echo $receiverSign;?>">
                                                                        
                                                                                                      </p>    
												   </td>
												</tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>   
      </table>
      <table border="0" cellpadding="0" cellspacing="0" width="100%" id="ko_titleBlock_7">
         <tbody>
            <tr class="row-a">
               <td bgcolor="#f9f9f9" align="center" class="section-padding" style="padding: 30px 15px 15px 15px;">
                  <table border="0" cellpadding="0" cellspacing="0" width="600" style="padding: 0 0 20px 0;" class="responsive-table" id="end_block">
                     <!-- TITLE -->
                     <tbody>
                        <tr>
                           <td align="center" class="padding-copy" colspan="2" style="padding: 0 0 10px 0px; color:#000; font-size: 25px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #232323!important;">
                             <div class="generated" style="font-size:15px;">This is an electronically generated invoice. All Taxes are included</div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
      

    
      <!-- FOOTER -->

      
  
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCn0dk0FzLNwlseL973kfz9EKRFFyy5a5M&libraries=places&callback=initMap" async defer></script>
    <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
      

      function initMap() {
        var origin_place_id = null;
        var destination_place_id = null;
        var travel_mode = 'WALKING';
        var map = new google.maps.Map(document.getElementById('map'), {
          mapTypeControl: false,
          center: {lat: <?php echo $invoiceDetails['pickup_location']['latitude']?>, lng: <?php echo $invoiceDetails['pickup_location']['longitude']?>},
          zoom: 13
        });
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        directionsDisplay.setMap(map);

        var origin_input = document.getElementById('origin-input');
        var destination_input = document.getElementById('destination-input');
        var modes = document.getElementById('mode-selector');

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(origin_input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(destination_input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(modes);

        var origin_autocomplete = new google.maps.places.Autocomplete(origin_input);
        origin_autocomplete.bindTo('bounds', map);
        var destination_autocomplete =
            new google.maps.places.Autocomplete(destination_input);
        destination_autocomplete.bindTo('bounds', map);

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, mode) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            travel_mode = mode;
          });
        }
        setupClickListener('changemode-walking', 'WALKING');
        setupClickListener('changemode-transit', 'TRANSIT');
        setupClickListener('changemode-driving', 'DRIVING');

        function expandViewportToFitPlace(map, place) {
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
          }
        }

        origin_autocomplete.addListener('place_changed', function() {
          var place = origin_autocomplete.getPlace();
          if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
          }
          expandViewportToFitPlace(map, place);

          // If the place has a geometry, store its place ID and route if we have
          // the other place ID
          origin_place_id = place.place_id;
          route(origin_place_id, destination_place_id, travel_mode,
                directionsService, directionsDisplay);
        });

        destination_autocomplete.addListener('place_changed', function() {
          var place = destination_autocomplete.getPlace();
          if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
          }
          expandViewportToFitPlace(map, place);

          // If the place has a geometry, store its place ID and route if we have
          // the other place ID
          destination_place_id = place.place_id;
          route(origin_place_id, destination_place_id, travel_mode,
                directionsService, directionsDisplay);
        });

        function route(origin_place_id, destination_place_id, travel_mode,
                       directionsService, directionsDisplay) {
          if (!origin_place_id || !destination_place_id) {
            return;
          }
          directionsService.route({
            origin: {'placeId': origin_place_id},
            destination: {'placeId': destination_place_id},
            travelMode: travel_mode
          }, function(response, status) {
            if (status === 'OK') {
              directionsDisplay.setDirections(response);
            } else {
              window.alert('Directions request failed due to ' + status);
            }
          });
        }
      }
    </script>
    
    
   </body>
</html>