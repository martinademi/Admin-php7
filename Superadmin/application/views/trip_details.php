<?php
if ($data['res']['receivers']['0']['quantity'] == '')
    $result = "";
else {
    $result = $data['res']['receivers']['0']['quantity'];
}
if ($data['res']['payment_type'] == 1) {
    $payment = "Card";
    if ($data['res']['cardId'] == '' || $data['res']['cardId'] == null) {
        $card = "N/A";
    } else {
        $cardData = $data['res']['cardId'];
        $lastfour = 'XXXX-XXXX-XXXX-' . substr($cardData, -4);
        $card = $lastfour;
    }
} else {
    $payment = "Cash";
}
if ($data['res']['receivers']['0']['documentImage'] != "") {
    $dropImages = explode(',', $data['res']['receivers']['0']['documentImage']);
}
if ($data['res']['paymentType'] == 1) {
    $paymentMethod = "Card";
} else {
	if($data['res']['payByWallet']==1){
		$paymentMethod ="FlexyCoin";
	}else{
		$paymentMethod = "Cash";
	}
    
}

$totalJourney = $data['res']['driverJourney']['OnTheWayToStore'] + $data['res']['driverJourney']['storeToJourneyStart'] + $data['res']['driverJourney']['journeyStartToDrop'];

// foreach ( $data['res']['dispatched'] as $driverDetails){
	// if($driverDetails['status'] == "" )
// }

?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="//maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_API_KEY;?>"></script>

<style>
    .tooltip > .tooltip-inner {background-color:#50606C;}
    .small, small {
        font-size: 100%;
        font-weight: 400;
        color:deepskyblue;

    }
</style>
<script>
    var mobileFormat = /^[0-9]{9,15}$/;
    $('.sm-table').find('.header-inner').html('<div class="brand inline" style="  width: auto;\
                     font-size: 27px;\
                     color: gray;\
                     margin-left: 100px;margin-right: 20px;margin-bottom: 12px; margin-top: 10px;">\
                    <strong> Super Admin Console</strong>\
                </div>');
    $('document').ready(function () {
		
	$('#orderCollapsed').click();
	
	

//var modal = document.getElementById('myModal');
//
//// Get the image and insert it inside the modal - use its "alt" text as a caption
//var img = document.getElementsByClassName('Imagepop')[0];
//var modalImg = document.getElementById("img01");
//var captionText = document.getElementById("caption");
//img.onclick = function(){
//    modal.style.display = "block";
//    modalImg.src = this.src;
//    captionText.innerHTML = this.alt;
//}
//
//// Get the <span> element that closes the modal
//var span = document.getElementsByClassName("close")[0];
//
//// When the user clicks on <span> (x), close the modal
//span.onclick = function() { 
//  modal.style.display = "none";
//}




        var initStripedTable = function () {
            var table = $('.stripedTable');
            var settings = {
                "sDom": "t",
                "destroy": true,
                "paging": false,
                "scrollCollapse": true
            };
            table.dataTable(settings);
        }
        initStripedTable();

        $('#updateInfo').click(function ()
        {
            if ($('#slaveName').val() == '' || $('#slaveName').val() == null)
            {
                $('#slaveNameErr').text('Name should not be empty');
            } else if ($('#receiverName').val() == '' || $('#slaveName').val() == null)
            {
                $('#receiverNameErr').text('Name should not be empty');
            } else if ($('#slavePhone').val() == '' || $('#slavePhone').val() == null)
            {
                $('#slavePhoneErr').text('Phone number should not be empty');
            } else if ($('#receiverPhone').val() == '' || $('#receiverPhone').val() == null)
            {
                $('#receiverPhoneErr').text('Phone number should not be empty');
            } else if ($('#slaveEmail').val() == '' || $('#slaveEmail').val() == null)
            {
                $('#slaveEmailErr').text('Email should not be empty');
            } else if ($('#receiverEmail').val() == '' || $('#receiverEmail').val() == null)
            {
                $('#receiverEmailErr').text('Email should not be empty');
            } else if ($('#weight').val() == '' || $('#weight').val() == null)
            {
                $('#weightErr').text('Weight should not be empty');
            } else if ($('#qty').val() == '' || $('#qty').val() == null)
            {
                $('#qtyErr').text('Quantity should not be empty');
            } else
                $('#bookingDetailsForm').submit();
        });


    });

    function isNumberKey(evt)
    {
        $(".errors").text('');
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 41 || charCode > 57)) {
            //    alert("Only numbers are allowed");
            $(".errors").text('Please enter valid number');
            return false;
        }
        return true;
    }

    // Get the modal


// Get the image and insert it inside the modal - use its "alt" text as a caption


</script>

<style>
    .small{
        color:purple;
    }
    .header{
        height:60px !important;
    }
    .header h3{
        margin:10px 0 !important;
    }
    .rating>.rated {
        color: #10cfbd;
    }
    .social-user-profile {
        width: 83px;
    }
    p {
        margin: 0 0 3px;
    }
    .headinClass{
        font-size: 12px;
    }

    span.bullet_points {    
        width: 13px;    
        height: 13px;    
        background: #118cce;    
        content: '';    
        border-radius: 36px;    
        display: inline-block;    
        position: absolute;    
        left: 10px;
    }
    .bullet_line{    
        width: 1px;    
        display: inline-block;    
        background: #d5caca;    
        height: 75%;    
        position: absolute;    
        left: 16px;    
        top: 13px;
    }

    .activity_status {    
        position: absolute;    
        left: 34px;    
        color: grey;    
        font-size: 11px;    
        top: -3px;
        font-size: 12px;
    }
    .activity_body{
        width: 100%;
        min-height: 82px;
        background: #fff;
        position: relative;
    }
    span.activity_status_text{
        border: 1px solid #d7d7d7;
        padding: 0px 5px;
        border-radius: 5px;
        width:170px;
        height: 20px;
        background: #fff7f7;
    }

    .imgClass {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        width: 350px;
        height:350px;
    }

    .imgClass:hover {
        box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
    }




    /* Style the Image Used to Trigger the Modal */
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {opacity: 0.7;}

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    /* Modal Content (Image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image (Image Text) - Same Width as the Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: left;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation - Zoom in the Modal */
    .modal-content, #caption { 
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {-webkit-transform:scale(0)} 
        to {-webkit-transform:scale(1)}
    }

    @keyframes zoom {
        from {transform:scale(0)} 
        to {transform:scale(1)}
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px){
        .modal-content {
            width: 100%;
        }
    }

    p {
    text-align: left !important; 
}

/* hr.addOns{

  color: black;
    background-color: black;
    height: 1px;
} */
</style>
<?php

$pick_routes = $dataLocation['10'];
$arrivedAtPickup_routes = $dataLocation['11'];
$tripStarted_routes = $dataLocation['12'];
$reachedAtDrop_routes = $dataLocation['13'];
$unloaded_routes = $dataLocation['14'];
$tripCompleted_routes = $dataLocation['15'];

$apptdata = $data['res'];


foreach ($data['res']['receivers'] as $r) {
    $receiverName = $r['name'];
    $receiverPhone = $r['mobile'];
    $receiverEmail = $r['email'];
}

$arrColor = array(8 => "background:#933EC5!important", 9 => "background:#FFDA44!important", 10 => "background:#006DF0!important", 11 => "background:#402B4D!important", 12 => "background:#91DC5A!important", 13 => "background:#044857!important",14 =>"background:#9CD5A!important",15 =>"background:#9CD5A!important");
$arrStatusCode = array(10 => "A", 11 => "B", 12 => "C", 13 => "D", 14 => "E", 15 => "F");
?>    

<div class="page-content-wrapper">
    <div class="content">

        <ul class="breadcrumb" style="margin-top: 5%;">
            <li>
                <a href="<?php echo base_url();?>index.php?/Orders" class="active">ORDER DETAILS - <?php echo $order_id; ?></a>
            </li>
            <?php
            if ($data['res']['status'] == 10 || $data['res']['status'] == 3) {
                ?>
                <!-- <a target="_blank" style="color: #0090d9;margin-left: 55px;text-decoration:underline;" href="<?php echo base_url() . 'index.php?/superadmin/invoiceDetails/' . $order_id ?>">Invoice</a>-->
                <?php
            }
            ?>
        </ul>
        <div class="container-fluid container-fixed-lg bg-white col-md-12 col-sm-12 col-xs-12">
            <form id="bookingDetailsForm" action="<?php echo base_url() . 'index.php?/superadmin/updateBookingDetails/' . $order_id; ?>" method="post">
                <div class="panel panel-transparent">

                    <div class="panel-body no-padding">
                        <div class="row">

                            <div class="col-lg-6 col-md-12 col-sm-12">

                                <ul class="nav nav-tabs nav-tabs-simple hidden-xs" role="tablist" data-init-reponsive-tabs="collapse">

                                    <!--<li class="active tabs_active">
                                        <a href="#customer_details" data-toggle="tab" role="tab" aria-expanded="false">ORDER SUMMARY</a>
                                    </li>
                                    <?php //if($tabStatus == 0 || $tabStatus == 1){}else{?>
                                    <li class="tabs_active">
                                        <a href="#status_details" data-toggle="tab" role="tab" aria-expanded="true">ACTIVITY TIMELINE</a>
                                    </li>
									<?php// } ?>
									<li class="tabs_active">
                                        <a href="#finalSummaryDetails" data-toggle="tab" role="tab" aria-expanded="false">FINAL SUMMARY</a>
                                    </li>-->
                                    
                                    <!--<li class="tabs_active">
                                        <a href="#invoice_details" data-toggle="tab" role="tab" aria-expanded="true">INVOICE</a>
                                    </li> -->



                                </ul>
                                <div  class="tab-content hidden-xs">
                                    
											
											
											<div class="panel panel-primary">
                        <div class="panel-heading padding" data-parent="#accordion" data-toggle="collapse" href="#collapseOne">
                            <h4 class="panel-title">
                                <a class="collapsed" id="orderCollapsed">
                                    ORDER SUMMARY
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseOne" style="height: 0px;">
                            <div class="panel-body">
                                <div class="summernote-wrapper">
                                    <div id="summernote">
                                   
                                            <div class="row" style="margin-top:4%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Order ID</a>
                                                    </p>
                                                    <p class="small">
                                                        <?php echo $order_id; ?>
                                                    </p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Order Status</a>
                                                    </p>
                                                    <p class="small">
                                                        <?php
                                                        echo $data['res']['statusMsg'];
                                                        ?>
                                                    </p>
                                                </div>
												<div class="col-sm-4">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Payment Type</a>
                                                    </p>
                                                    <p class="small">
                                                    <?php
                                                        switch($data['res']['paymentType']){
                                                          case 0:
                                                             if($data['res']['payByWallet']==1){
                                                                 echo "Wallet";
                                                                 break;
                                                             }
                                                         case 1: 
                                                             if($data['res']['payByWallet'] == 1){
                                                                 echo "Card + Wallet";
                                                             }else{
                                                                 echo "Card";
                                                             }
                                                         break;
                                                         case 2: 
                                                             if($data['res']['payByWallet'] == 1){
                                                                 echo "Cash + Wallet";
                                                             }else{
                                                                 echo "Cash";
                                                             }
                                                         break;
                                                        case 24:
                                                        echo"Razorpay";
                                                        break;
 													   }
                                                         ?>
                                                    </p>
                                                </div>
                                            </div>

                                             <div class="row" style="margin-top:1%;">
                                                  <div class="col-sm-6" style="padding-left: 22px;">
                                                            <p class="no-margin">
                                                                <a href="#" class="headinClass">Order Type</a>
                                                            </p>
                                                            <p class="small">
                                                            <p class="small">  <?php
                                                                if($data['res']['bookingType'] == 1 && $data['res']['serviceType'] == 1){
                                                                    echo "ASAP Delivery";
                                                                }
                                                                if($data['res']['bookingType'] == 1 && $data['res']['serviceType'] == 2){
                                                                    echo "ASAP Pickup";
                                                                }
                                                                if($data['res']['bookingType'] == 2 && $data['res']['serviceType'] == 2){
                                                                    echo "Scheduled Pickup";
                                                                }
                                                                if($data['res']['bookingType'] == 2 && $data['res']['serviceType'] == 1){
                                                                    echo "Scheduled Delivery";
                                                                }
                                                                ?></p> 
                                                            </p>
                                                            <span class="errors" id="slavePhoneErr"></span>
                                                    </div>
                                               
												
                                            </div>

                                          
                                           <div class="row">
                                                <div class="col-sm-12" style="padding-left: 22px;margin-top:1%;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass"><u>CUSTOMER DETAILS</u></a>
                                                    </p>
                                                    
                                                </div>
                                               
                                            </div>
											
                                             
                                            <div class="row">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="">Customer Name</a>
                                                    </p>
                                                    <p class="small"><?php echo ($data['res']['customerDetails']['name'] == "" || $data['res']['customerDetails']['name'] ==null)?"N/A":$data['res']['customerDetails']['name']; ?></p> 
                                                    <span class="errors" id="slaveNameErr"></span>
                                                </div>

                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="">Customer Phone</a>
                                                    </p>
                                                    <p class="small">
                                                    <p class="small"> <?php echo ($data['res']['customerDetails']['countryCode'] == "" || $data['res']['customerDetails']['mobile'] == "")?"N/A":$data['res']['customerDetails']['countryCode'].$data['res']['customerDetails']['mobile']; ?></p> 
                                                    </p>
                                                    <span class="errors" id="slavePhoneErr"></span>
                                                </div>

                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="">Customer Email</a>
                                                    </p>
                                                    <p class="small">
													<?php echo $data['res']['customerDetails']['email']; ?></p>
                                                    <span class="errors" id="slaveEmailErr"></span>
                                                </div>
                                               
                                            </div>

                                           

											<?php if($data['res']['serviceType'] == 1 ){?>
											<div class="row" style="margin-top:2%;">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass"><u>STORE DETAILS</u></a>
                                                    </p>
                                                    
                                                </div>
												<?php if($data['res']['status'] != 2){?>
												<div class="col-sm-6">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass"><u>DRIVER DETAILS</u></a>
                                                    </p>
                                                    
                                                </div>
												<?php }?>
                                               
                                            </div>
										
											<div class="row">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="">Store Name</a>
                                                    </p>
                                                    <p class="small"><?php echo ($data['res']['storeName']=="" || $data['res']['storeName'] == null)?"N/A":$data['res']['storeName']; ?></p> 
                                                    <span class="errors" id="slaveNameErr"></span>
                                                </div>
												<?php if($data['res']['status'] != 2){?>
                                                <div class="col-sm-6" >
                                                <p class="no-margin">
                                                    <a href="#" class="">Driver Names</a>
                                                    </p>
                                                    <p class="small"><?php echo ($data['res']['driverDetails']['fName'] == "" )?"N/A":$data['res']['driverDetails']['fName']." ".$data['res']['driverDetails']['lName']; ?></p> 
                                                    <span class="errors" id="receiverNameErr"></span>
                                                </div>
												<?php } ?>
                                            </div>

                                            <div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="">Store Phone</a>
                                                    </p>
                                                    <p class="small">
                                                    <p class="small"> <?php echo $data['storeData']['countryCode'] .$data['storeData']['businessNumber']; ?></p> 
                                                    </p>
                                                    <span class="errors" id="slavePhoneErr"></span>
                                                </div>
												<?php if($data['res']['status'] != 2){?>
                                                <div class="col-sm-6">
                                                    <p class="no-margin">
                                                        <a href="#" class="">Driver Phone</a>
                                                    </p>
                                                    <p class="small"><?php echo ($data['res']['driverDetails']['countryCode']=="" || $data['res']['driverDetails']['mobile'] == "")?"N/A":$data['res']['driverDetails']['countryCode'].$data['res']['driverDetails']['mobile']; ?></p>
                                                    <span class="errors" id="receiverPhoneErr"></span>
                                                </div>
												<?php } ?>
                                            </div>

                                            <div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Store Email</a>
                                                    </p>
                                                    <p class="small"><?php echo $data['storeData']['ownerEmail']; ?></p>
                                                    <span class="errors" id="slaveEmailErr"></span>
                                                </div>
												<?php if($data['res']['status'] != 2){?>
                                                <div class="col-sm-6">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Driver Email</a>
                                                    </p>
                                                    <p class="small">
                                                     
                                                        <?php echo ($data['res']['driverDetails']['email'] == "")?"N/A":$data['res']['driverDetails']['email']; ?>
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>
												<?php }?>

                                            </div>
											
											
											<?php } ?>
											
                                         <div class="row">
                                                <div class="col-sm-12" style="padding-left: 22px;margin-top: 1%;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass"><u>ORDER DETAILS</u></a>
                                                    </p>
                                                    
                                                </div>
                                               
                                            </div>
										
											<div class="row">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Cart Id</a>
                                                    </p>
                                                    <p class="small"><?php echo $data['res']['cartId']; ?></p> 
                                                    <span class="errors" id="slaveNameErr"></span>
                                                </div>
                                                <div class="col-sm-6" >
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Estimate Id</a>
                                                    </p>
                                                    <p class="small"><?php echo ($data['res']['estimateId'] == "" || $data['res']['estimateId'] == null)?"N/A":$data['res']['estimateId']; ?></p> 
                                                    <span class="errors" id="receiverNameErr"></span>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Order Type</a>
                                                    </p>
                                                    <p class="small">
                                                    <p class="small">  <?php
                                                        if($data['res']['bookingType'] == 1 && $data['res']['serviceType'] == 1){
															echo "ASAP Delivery";
														}
														if($data['res']['bookingType'] == 1 && $data['res']['serviceType'] == 2){
															echo "ASAP Pickup";
														}
														if($data['res']['bookingType'] == 2 && $data['res']['serviceType'] == 2){
															echo "Scheduled Pickup";
														}
														if($data['res']['bookingType'] == 2 && $data['res']['serviceType'] == 1){
															echo "Scheduled Delivery";
														}
                                                        ?></p> 
                                                    </p>
                                                    <span class="errors" id="slavePhoneErr"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Delivery Address</a>
                                                    </p>
                                                    <p class="small"><?php echo $data['res']['drop']['addressLine1'].'<br/>'.$data['res']['drop']['addressLine2']; ?></p>
                                                    <span class="errors" id="receiverPhoneErr"></span>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Order Placed On</a>
                                                    </p>
                                                    <p class="small"><?php echo date('d-M-Y h:i:s a ', ($data['res']['bookingDateTimeStamp']) - ($this->session->userdata('timeOffset') * 60));; ?>
                                                    <span class="errors" id="slaveEmailErr"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Ordered For</a>
                                                    </p>
                                                    <p class="small">
                                                     
                                                        <?php echo $data['res']['dueDatetime']; ?>
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>

                                            </div>
											<div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Store Type</a>
                                                    </p>
                                                    <p class="small"><?php echo $data['storeData']['category']['typeName']; ?></p>
                                                    <span class="errors" id="slaveEmailErr"></span>
                                                </div>
                                                <div class="col-sm-6" style="display:none">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Store Category</a>
                                                    </p>
                                                    <p class="small">
                                                     
                                                        <?php echo $data['storeData']['category']['name']; ?>
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>
												

                                            </div>
											
												 <div class="row">
                                                <div class="col-sm-12" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass"><u>CART DETAILS</u></a>
                                                    </p>
                                                    
                                                </div>
                                               
                                            </div>
										
											
											<div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Product Name</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Quantity</a>
                                                    </p>
                                                    
                                                </div>
												 <div class="col-sm-3">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Unit Price</a>
                                                    </p>
                                                   
                                                </div>
												 <div class="col-sm-3">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Total</a>
                                                    </p>
                                                   
                                                </div>
												

                                            </div>
											<?php foreach($data['res']['Items'] as $items){?>
											<div class="row" style="margin-top: 1%;">
                                                
												
												
												<div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass"><?php echo $items['itemName']."[ ".$items['unitName']." ]";?></a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass"><?php echo $items['quantity'];?></a>
                                                    </p>
                                                    
                                                </div>
												 <div class="col-sm-3">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($items['unitPrice'],2,'.','');
														}else{
														echo number_format($items['unitPrice'],2,'.','').$data['res']['currencySymbol'];
														}?>
														</a>
                                                    </p>
                                                   
                                                </div>
												 <div class="col-sm-3">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">
														
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($items['unitPrice']*$items['quantity'],2,'.','');
														}else{
														echo number_format($items['unitPrice']*$items['quantity'],2,'.','').$data['res']['currencySymbol'];
														}?>
														</a>
                                                    </p>
                                                   
                                                </div>
                                                             
                                                 

                                            </div>
											<?php }?>
                                           
                                            <div class="row" >
                                                <div class="col-sm-4" style="padding-left: 22px;" >
                                                    <p class="small">
                                                        <a href="#"class="headinClass">Add-On's</a>
                                                    </p>                                                  
                                                   
                                                </div>                                                
												 
                                            </div>
                                            <!-- <hr class="addOns" > -->

                                            <div class="row" >
                                               
                                            <?php   $sl=1;foreach($data['res']['Items'] as $items){
                                                foreach($items['addOns'] as $addOns){
                                                    foreach($addOns['addOnGroup'] as $addOnDetail){                                                
                                                ?>
											<div class="row" >
                                                
												
												
												<div class="col-sm-4" style="padding-left: 42px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass"><?php echo $sl.'.'.$addOnDetail['name'];?></a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                    
                                                    
                                                </div>
												 <div class="col-sm-3">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($addOnDetail['price'],2,'.','');
														}else{
														echo number_format($items['unitPrice'],2,'.','').$data['res']['currencySymbol'];
														}?>
														</a>
                                                    </p>
                                                   
                                                </div>
												
                                                             
                                             

                                            </div>
											<?php  $sl++; } }}?>
												 
                                            </div>
                                                
											<div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Sub-Total</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">
														
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($data['res']['subTotalAmount'],2,'.','');
														}else{
														echo number_format($data['res']['subTotalAmount'],2,'.','').$data['res']['currencySymbol'];
														}?>
														</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											
											<div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Delivery Fee</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">
														
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($data['res']['deliveryCharge'],2,'.','');
														}else{
														echo number_format($data['res']['deliveryCharge'],2,'.','').$data['res']['currencySymbol'];
														}?>
														</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Discount<?php echo $data['res']['couponCode']." - Applied";?></a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass"><br/>
														
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].$data['res']['discount'];
														}else{
														echo $data['res']['discount'].$data['res']['currencySymbol'];
														}?>
														</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Taxes
														<br/><?php foreach($data['res']['exclusiveTaxes'] as $taxData){
															echo $taxData['taxtName']; echo "@"; echo $taxData['taxValue'];echo "%";echo"<br/>";
														}?>
														</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass"><?php echo "<br/>"; foreach($data['res']['exclusiveTaxes'] as $taxData){
															
															 if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].$taxData['price'];
														}else{
														echo $taxData['price'].$data['res']['currencySymbol'];
														}
														echo "<br/>";
														}?>
														
														</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Last Due</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">0</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											
                                            <div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Driver Tip</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">
														<?php ?>
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($data['res']['accouting']['driverTip'],2,'.','');
														}else{
														echo number_format($data['res']['accouting']['driverTip'],2,'.','').$data['res']['currencySymbol'];
														}?>
														
														</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Grand Total</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">
														<?php ?>
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($data['res']['totalAmount'],2,'.','');
														}else{
														echo number_format($data['res']['totalAmount'],2,'.','').$data['res']['currencySymbol'];
														}?>
														
														</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<hr/>
                                          
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
											
											
											
											
											
											
											
											
                                        </div>   
										<?php if($tabStatus == 0 || $tabStatus == 1){}else{?>
                                         <div class="panel panel-primary">
                        <div class="panel-heading padding" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" >
                                   ACTIVITY TIMELINE
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseTwo" style="height: 0px;">
                            <div class="panel-body">
                                <div class="summernote-wrapper">
                                    <div id="summernote1">
                                   <div class="row" style="margin-top: 6%;"></div>
                                        <div  class="tabs_details details_description_activity">

                                            <div  style="height:10px;width:100%;background:#fff"></div>
                                            <?php
                                            foreach ($data['res']['activities'] as $resArray) {
                                                if ($resArray['bid'] == $data['res']['orderId']) {
                                                    ?>
                                                    <div  class="activity_body">
                                                        <?php echo $arrStatusCode[$resArray['status']]; ?><span  class="bullet_points" style="<?php echo $arrColor[$resArray['status']]; ?>"></span>
                                                        <span  class="activity_status"><?php
                                                         echo "OrderId-[ ".$resArray['bid']." ]<br/>";
														echo $resArray['msg']; 
                                                      echo "<br/>";
                                                        ?><span  class="activity_status_text"><?php echo  date('d-M-Y h:i:s a ', ($resArray['time']) - ($this->session->userdata('timeOffset') * 60)); ?></span></span>
                                                        <span  class="bullet_line"></span>
                                                    </div>
                                                <?php } /* else { ?>
                                                    <div  class="activity_body">
                                                        <?php echo $arrStatusCode[$resArray['status']]; ?><span  class="bullet_points" style="<?php echo $arrColor[$resArray['status']]; ?>"></span>
                                                        <span  class="activity_status col-lg-7"><?php
                                                       echo "OrderId-[ ".$resArray['bid']." ]<br/>";
														echo $resArray['msg'];
														echo "<br/>";
                                                        ?><span  class="activity_status_text col-lg-5"><?php echo date('d-M-Y h:i:s a ', ($resArray['time']) - ($this->session->userdata('timeOffset') * 60)); ?></span></span>
                                                        <span  class="bullet_line"></span>
                                                    </div>
                                                    <?php
                                                }*/
                                            }
                                            ?>

                                        </div>
                                            
                                            </div>
                                        </div>
                                </div>
                            </div>
							</div>
										<?php } ?>
							
							
							
							          <div class="panel panel-primary">
                        <div class="panel-heading padding" data-parent="#accordion" data-toggle="collapse" href="#collapseThree">
                            <h4 class="panel-title">
                                <a class="collapsed" >
                                  FINAL SUMMARY
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseThree" style="height: 0px;">
                            <div class="panel-body">
                                <div class="summernote-wrapper">
                                    <div id="summernote2">
                                   
                                            <div class="row" style="margin-top: 2%;"></div>
									<div class="row">
                                                <div class="col-sm-12" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">CART DETAILS</a>
                                                    </p>
                                                    
                                                </div>
                                               
                                            </div>
										
											
											<div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Product Name</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Quantity</a>
                                                    </p>
                                                    
                                                </div>
												 <div class="col-sm-3">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Unit Price</a>
                                                    </p>
                                                   
                                                </div>
												 <div class="col-sm-3">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Total</a>
                                                    </p>
                                                   
                                                </div>
												

                                            </div>
											<?php foreach($data['res']['Items'] as $items){?>
											<div class="row" style="margin-top: 1%;">
                                                
												
												
												<div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass"><?php echo $items['itemName']."[ ".$items['unitName']." ]";?></a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass"><?php echo $items['quantity'];?></a>
                                                    </p>
                                                    
                                                </div>
												 <div class="col-sm-3">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($items['unitPrice'],2,'.','');
														}else{
														echo number_format($items['unitPrice'],2,'.','').$data['res']['currencySymbol'];
														}?>
														</a>
                                                    </p>
                                                   
                                                </div>
												 <div class="col-sm-3">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">
														
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($items['unitPrice']*$items['quantity'],2,'.','');
														}else{
														echo number_format($items['unitPrice']*$items['quantity'],2,'.','').$data['res']['currencySymbol'];
														}?>
														</a>
                                                    </p>
                                                   
                                                </div>

                                            </div>
											<?php }?>

                                            <!-- cool -->
											<div class="row" >
                                                <div class="col-sm-4" style="padding-left: 22px;" >
                                                    <p class="small">
                                                        <a href="#"class="headinClass">Add-On's</a>
                                                    </p>                                                  
                                                   
                                                </div>                                                
												 
                                            </div>
                                            <!-- <hr class="addOns" > -->

                                            <div class="row" >
                                               
                                            <?php   $sl=1;foreach($data['res']['Items'] as $items){
                                                foreach($items['addOns'] as $addOns){
                                                    foreach($addOns['addOnGroup'] as $addOnDetail){                                                
                                                ?>
											<div class="row" >
                                                
												
												
												<div class="col-sm-4" style="padding-left: 42px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass"><?php echo $sl.'.'.$addOnDetail['name'];?></a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                    
                                                    
                                                </div>
												 <div class="col-sm-3">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($addOnDetail['price'],2,'.','');
														}else{
														echo number_format($items['unitPrice'],2,'.','').$data['res']['currencySymbol'];
														}?>
														</a>
                                                    </p>
                                                   
                                                </div>
												
                                                             
                                             

                                            </div>
											<?php  $sl++; } }}?>
												 
                                            </div>
                                                
											<div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Sub-Total</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">
														
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($data['res']['subTotalAmount'],2,'.','');
														}else{
														echo number_format($data['res']['subTotalAmount'],2,'.','').$data['res']['currencySymbol'];
														}?>
														</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											
											<div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Delivery Fee</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">
														
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($data['res']['deliveryCharge'],2,'.','');
														}else{
														echo number_format($data['res']['deliveryCharge'],2,'.','').$data['res']['currencySymbol'];
														}?>
														</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Discount<br/><?php echo $data['res']['couponCode']." - Applied";?></a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass"><br/>
														
														<?php if($data['res']['abbrevation'] == "1"){
														echo $data['res']['currencySymbol'].$data['res']['discount'];
														}else{
														echo $data['res']['discount'].$data['res']['currencySymbol'];
														}?>
														</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Taxes
														<br/><?php foreach($data['res']['exclusiveTaxes'] as $taxData){
															echo $taxData['taxtName']; echo "@"; echo $taxData['taxValue'];echo "%";echo"<br/>";
														}?>
														</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass"><?php echo "<br/>"; foreach($data['res']['exclusiveTaxes'] as $taxData){
															
															 if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].$taxData['price'];
														}else{
														echo $taxData['price'].$data['res']['currencySymbol'];
														}
														echo "<br/>";
														}?>
														
														</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											<div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">Last Due</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">0</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>
											
											<div class="row" style="margin-top: 1%;">
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Grand Total</a>
                                                    </p>
                                                   
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
                                                <div class="col-sm-2">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">
														<?php ?>
														<?php if($data['res']['abbrevation'] == "1"){
															echo $data['res']['currencySymbol'].number_format($data['res']['totalAmount'],2,'.','');
														}else{
														echo number_format($data['res']['totalAmount'],2,'.','').$data['res']['currencySymbol'];
														}?>
														
														</a>
                                                    </p>
                                                    
                                                </div>
												 
                                            </div>											
											 <div class="row" style="margin-top:2%;">
                                                
												<div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Payment Type</a>
                                                    </p>
                                                    
                                                </div>
                                                <div class="col-sm-2">
                                                </div>
                                                <div class="col-sm-3">
                                                </div>
												<div class="col-sm-3">
                                                    <p class="no-margin">
                                                    <?php
                                                        switch($data['res']['paymentType']){
                                                          case 0:
                                                             if($data['res']['payByWallet']==1){
                                                                 echo "Wallet";
                                                                 break;
                                                             }
                                                         case 1: 
                                                             if($data['res']['payByWallet'] == 1){
                                                                 echo "Card + Wallet";
                                                             }else{
                                                                 echo "Card";
                                                             }
                                                         break;
                                                         case 2: 
                                                             if($data['res']['payByWallet'] == 1){
                                                                 echo "Cash + Wallet";
                                                             }else{
                                                                 echo "Cash";
                                                             }
                                                         break;
                                                        case 24:
                                                        echo"Razorpay";
                                                        break;
 													   }
                                                         ?>
                                                    </p>
                                                </div>
                                            </div>
										
											<?php if(($data['res']['serviceType'] == 1 && $data['res']['status'] != 2)){?>
											<div class="row" style="margin-top:2%;">
                                                
												<div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass"><u>DRIVER DETAILS</u></a>
                                                    </p>
                                                    
                                                </div>
                                               
                                            </div>
											<!-- cool -->
											<div class="row" style="margin-top:1%;">
                                               
                                                <div class="col-sm-4" style="padding-left: 22px;" >
                                                    <p class="no-margin">
                                                        <a href="#" class="">Driver Names</a>
                                                    </p>
                                                    <p class="small"><?php echo ($data['res']['driverDetails']['fName'] == "" )?"N/A":$data['res']['driverDetails']['fName']." ".$data['res']['driverDetails']['lName']; ?></p> 
                                                    <span class="errors" id="receiverNameErr"></span>
                                                </div>

                                                <div class="col-sm-4" style="padding-left: 22px;" >
                                                 <p class="no-margin">
                                                        <a href="#" class="headinClass">Driver Phone</a>
                                                    </p>
                                                    <p class="small"><?php echo ($data['res']['driverDetails']['countryCode'] == "" || $data['res']['driverDetails']['mobile'] == "")?"N/A":$data['res']['driverDetails']['countryCode'].$data['res']['driverDetails']['mobile'] ; ?></p>
                                                    <span class="errors" id="receiverPhoneErr"></span>
                                                </div>

                                                <div class="col-sm-4" style="padding-left: 22px;" >
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Driver Email</a>
                                                    </p>
                                                    <p class="small">
                                                     
                                                        <?php echo ($data['res']['driverDetails']['email'] == "")?"N/A":$data['res']['driverDetails']['email']; ?>
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>
                                                </div>
                                            </div>

                                           
											
											<?php } ?>
											<div class="row">
                                                
												<div class="col-sm-5" style="padding-left: 22px;margin-top:2%;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass"><u>PAYMENT GATEWAY COMMISSION</u></a>
                                                    </p>
                                                    
                                                </div>
                                                <div class="col-sm-2" style="padding-left: 22px;margin-top:2%;">
                                                   
                                                    
                                                </div>

												<div class="col-sm-5" style="padding-left: 40px;margin-top:2%;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass"><u>EARNINGS</u></a>
                                                    </p>
                                                    
                                                </div>
                                               
                                            </div>
											
											<div class="row">
                                               
                                                <div class="col-sm-5" style="padding-left: 22px;">
                                                    <p class="no-margin" >
                                                        <a href="#" class="headinClass">Payment Gateway Type </a>
                                                    </p>
													<p class="small"> 
                                                     <?php 
													  if($data['res']['abbrevation'] == "1" || $data['res']['abbrevation'] == 1){
            echo ($data['res']['accouting']['pgCommName'] == "") ? "N/A" :$data['res']['accouting']['pgCommName'];
		  }else{
			 echo ($data['res']['accouting']['pgCommName'] == "") ? "N/A" :$data['res']['accouting']['pgCommName']; 
		  }
			 ?>
			 </p>
                                                    <span class="errors" id="receiverNameErr"></span>
                                                </div>
                                                <div class="col-sm-2" style="padding-left: 22px;margin-top:2%;">
                                                   
                                                    
                                                </div>

												<div class="col-sm-5" style="padding-left: 22px;margin-top:2%;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass"><?= Appname  ?> Earnings </a>
                                                    </p>
                                                    <p class="small">                                                
													 <?php 
													  if($data['res']['abbrevation'] == "1" || $data['res']['abbrevation'] == 1){
            echo ($data['res']['accouting']['appEarningValue'] == "") ? "N/A" :$data['res']['currencySymbol']." ".number_format($data['res']['accouting']['appEarningValue'], 2);
		  }else{
			 echo ($data['res']['accouting']['appEarningValue'] == "") ? "N/A" :number_format($data['res']['accouting']['appEarningValue'], 2)." ".$data['res']['currencySymbol']; 
		  }
			 ?>
 
												   </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 1%;">
                                                
                                                <div class="col-sm-5" style="padding-left: 22px;">
                                                    <p class="no-margin" >
                                                        <a href="#" class="headinClass">Commission</a>
                                                    </p>
                                                    <p class="small"><?php echo "N/A"; ?></p>
                                                    <span class="errors" id="receiverPhoneErr"></span>
                                                </div>
                                                <div class="col-sm-2" style="padding-left: 22px;margin-top:2%;">
                                                   
                                                    
                                                   </div>
												<div class="col-sm-5" style="padding-left: 22px;margin-top:1%;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Earnings from Store</a>
                                                    </p>
                                                    <p class="small">
                                                     <?php 
													  if($data['res']['abbrevation'] == "1" || $data['res']['abbrevation'] == 1){
            echo ($data['res']['accouting']['storeEarningValue'] == "") ? "N/A" :$data['res']['currencySymbol']." ".number_format($data['res']['accouting']['storeEarningValue'], 2);
		  }else{
			 echo ($data['res']['accouting']['storeEarningValue'] == "") ? "N/A" :number_format($data['res']['accouting']['storeEarningValue'], 2)." ".$data['res']['currencySymbol']; 
		  }
			 ?>
												   </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 1%;">
                                                
                                                <div class="col-sm-5" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Payment Gateway Commission Amount </a>
                                                    </p>
                                                    <p class="small">
                                                     
                                                         <?php 
													  if($data['res']['abbrevation'] == "1" || $data['res']['abbrevation'] == 1){
            echo ($data['res']['accouting']['pgEarningValue'] == "") ? "N/A" :$data['res']['currencySymbol']." ".number_format($data['res']['accouting']['pgEarningValue'], 2);
		  }else{
			 echo ($data['res']['accouting']['pgEarningValue'] == "") ? "N/A" :number_format($data['res']['accouting']['pgEarningValue'], 2)." ".$data['res']['currencySymbol']; 
		  }
			 ?>
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>
                                                <div class="col-sm-2" style="padding-left: 22px;margin-top:1%;">
                                                   
                                                    
                                                   </div>
												<div class="col-sm-5" style="padding-left: 22px;margin-top:1%;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Earnings from Driver</a>
                                                    </p>
                                                    <p class="small">
                                                     <?php 
													  if($data['res']['abbrevation'] == "1" || $data['res']['abbrevation'] == 1){
            echo ($data['res']['accouting']['driverEarningValue'] == "") ? "N/A" :$data['res']['currencySymbol']." ".number_format($data['res']['accouting']['driverEarningValue'], 2);
		  }else{
			 echo ($data['res']['accouting']['driverEarningValue'] == "") ? "N/A" :number_format($data['res']['accouting']['driverEarningValue'], 2)." ".$data['res']['currencySymbol']; 
		  }
			 ?>
                                                   
												   
												   </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>

                                            </div>
											 <div class="row" style="margin-top: 1%;">
                                                
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Payment Gateway Commission Paid By App</a>
                                                    </p>
                                                    <p class="small">
                                                     <?php 
													  if($data['res']['abbrevation'] == "1" || $data['res']['abbrevation'] == 1){
            echo ($data['res']['accouting']['pgEarningValue'] == "") ? "N/A" :$data['res']['currencySymbol']." ".number_format($data['res']['accouting']['pgEarningValue'], 2);
		  }else{
			 echo ($data['res']['accouting']['pgEarningValue'] == "") ? "N/A" :number_format($data['res']['accouting']['pgEarningValue'], 2)." ".$data['res']['currencySymbol']; 
		  }
			 ?>
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>

                                            </div>
											<div class="row" style="margin-top: 1%;margin-top:2%;">
                                                
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Commission Paid By Store</a>
                                                    </p>
                                                    <p class="small">
                                                     
                                                      <?php 
													  if($data['res']['abbrevation'] == "1" || $data['res']['abbrevation'] == 1){
            echo ($data['res']['accouting']['storeCommissionValue'] == "") ? "N/A" :$data['res']['currencySymbol']." ".number_format($data['res']['accouting']['storeCommissionValue'], 2);
		  }else{
			 echo ($data['res']['accouting']['storeCommissionValue'] == "") ? "N/A" :number_format($data['res']['accouting']['storeCommissionValue'], 2)." ".$data['res']['currencySymbol']; 
		  }
			 ?>
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>

                                            </div>
										
											<?php if($data['res']['status'] == 2 ||  $data['res']['status'] == 16 || $data['res']['status'] == 17){?>
											<div class="row">
                                                
												<div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass"><u>CANCELLATION DETAILS</u></a>
                                                    </p>
                                                    
                                                </div>
                                               
                                            </div>
										
											<div class="row">
                                               
                                                <div class="col-sm-6" style="padding-left: 22px;" >
                                                    <p class="no-margin">
                                                        <a href="#" class="">Cancelled By</a>
                                                    </p>
                                                    <p class="small"><?php echo $data['res']['timeStamp']['cancelledBy']['statusUpdatedBy'];?></p> 
                                                    <span class="errors" id="receiverNameErr"></span>
                                                </div>

                                                <div class="col-sm-6" style="padding-left: 22px;" >
                                                    <p class="no-margin">
                                                        <a href="#" class="">Cancelled On</a>
                                                    </p>
                                                    <p class="small"><?php echo date('F  d, Y h:i:s A',$data['res']['timeStamp']['cancelledBy']['timeStamp']);?></p>
                                                    <span class="errors" id="receiverPhoneErr"></span>
                                                </div>

                                                <div class="col-sm-6" style="padding-left: 22px;" >
                                                    <p class="no-margin">
                                                        <a href="#" class="">Cancellation Fee Applicable </a>
                                                    </p>
                                                    <p class="small">
                                                     
                                                        <?php if($data['res']['status'] == 2){ echo "No";}else{echo "Yes";}?>
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>
                                                </div>
                                            </div>

                                           
											<div class="row" style="margin-top: 1%;">
                                                
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="">Cancelled Reason </a>
                                                    </p>
                                                    <p class="small">
                                                     <?php echo $data['res']['timeStamp']['cancelledBy']['message'];?>
                                                        
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>

                                            </div>
										
											
											<?php } ?>
											
											<div class="row">
                                                
												<div class="col-sm-6" style="padding-left: 22px;margin-top:2%;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass"><u>BOOKING STATS</u></a>
                                                    </p>
                                                    
                                                </div>
                                               
                                            </div>
											
											<div class="row">
                                               
                                                <div class="col-sm-6" style="padding-left: 22px;" >
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Total Time For Delivery</a>
                                                    </p>
                                                    <p class="small"><?php echo ($totalJourney == "" || $totalJourney ==null)?"N/A":gmdate("H:i:s", $totalJourney);?></p> 
                                                    <span class="errors" id="receiverNameErr"></span>
                                                </div>

                                                <div class="col-sm-6" style="padding-left: 22px;" >
                                                   <p class="no-margin">
                                                        <a href="#" class="headinClass">Total Time Spent at Store</a>
                                                    </p>
                                                    <p class="small">
													 <?php echo ($data['res']['driverJourney']['storeToJourneyStart']  == "" || $data['res']['driverJourney']['storeToJourneyStart'] == null)?"N/A":gmdate("H:i:s",$data['res']['driverJourney']['storeToJourneyStart']);?>
													</p>
                                                    <span class="errors" id="receiverPhoneErr"></span>
                                                </div>

                                            </div>

                                            

                                            <div class="row" style="margin-top: 1%;">
                                                
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Distance Travelled From Acceptance to Store</a>
                                                    </p>
                                                    <p class="small">
                                                     <?php if($data['res']['mileageMetric'] == "Km") {
														 echo ($data['res']['timeStamp']['arrived']['distance']*0.001).$data['res']['mileageMetric'];
													 }else{
														  echo ($data['res']['timeStamp']['arrived']['distance']*0.00062137).$data['res']['mileageMetric'];
													 }?>
                                                       
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>

                                            </div>
											<div class="row" style="margin-top: 1%;">
                                                
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Distance travelled between Store start & Delivery Address</a>
                                                    </p>
                                                    <p class="small">
                                                    <?php if($data['res']['mileageMetric'] == "Km") {
														echo ($data['res']['timeStamp']['reached']['distance']*0.001).$data['res']['mileageMetric'];
													}else{
														echo ($data['res']['timeStamp']['reached']['distance']*0.00062137).$data['res']['mileageMetric'];
													}?>
                                                        
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>

                                            </div>
										
											<div class="row">
                                                
												<div class="col-sm-6" style="padding-left: 22px;margin-top:1%;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass"><u>RATINGS & REVIEWS</u></a>
                                                    </p>
                                                    
                                                </div>
                                               
                                            </div>
										
											<div class="row">
                                               
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Customer Rated </a>
                                                    </p>
                                                    
                                                </div>

                                                
                                            </div>
											<div class="row">
                                               
                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">To Order</a>
                                                    </p>
                                                    <p class="small">
                                                   
                                                        <?php echo ($data['res']['reviewByCustomer']['averageRatingForOrder'] == "" || $data['res']['reviewByCustomer']['averageRatingForOrder'] == null)?"N/A":$data['res']['reviewByCustomer']['averageRatingForOrder'];?>
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>
												<div class="col-sm-4" style="padding-left: 22px;">
                                                    <p class="small">
                                                        <a href="#" class="headinClass">To Driver</a>
                                                    </p>
                                                    <p class="small">
                                                        <?php echo ($data['res']['reviewByCustomer']['averageRatingForDriver'] == "" || $data['res']['reviewByCustomer']['averageRatingForDriver'] == null)?"N/A":$data['res']['reviewByCustomer']['averageRatingForDriver'];?>
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>

                                                <div class="col-sm-4" style="padding-left: 22px;">
                                                <p class="no-margin">
                                                        <a href="#" class="headinClass">Driver Rated </a>
                                                    </p>
                                                    <p class="small">
                                                   <?php echo ($data['res']['reviewByProvider']['rating'] == "" || $data['res']['reviewByProvider']['rating'] == null)?"N/A":$data['res']['reviewByProvider']['rating'];?>
                                                        
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>
                                            </div>
											
											
											<div class="row">
                                                
												
												<div class="col-sm-6" style="padding-left: 22px;margin-top:2%;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">SIGNATURE</a>
                                                    </p>
													<br/>
													
                                                    
                                                </div>
                                               
                                            </div>
										
											<div class="row">
                                               
                                                <div class="col-sm-6" style="padding-left: 22px;" >
                                                    <p class="no-margin">
													<?php if($data['res']['receivers']['signatureUrl'] == null || $data['res']['receivers']['signatureUrl'] == ""){ echo "N/A"; } else{?>
                                                        <img src="<?php echo $data['res']['receivers']['signatureUrl']; ?>" style="width: 180px;height:90px;" class="style_prevu_kit">
													<?php }?>
                                                    </p>
                                                    
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
							</div>
                                               

                                    
                                    
									
									
                                    
                                     
                                </div>

                            
							
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div id="map" style="width: 100%; height: 780px;"></div>
                                <input id="pac-input" placeholder="Search" style="width:200px;height:27px;padding:10px;display: none; ">
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>


<script type="text/javascript">

    var result;
    var stops = 0;
    var latlong = [];
    jQuery(function () {

        var pick_routes = jQuery.parseJSON('<?php echo json_encode($pick_routes); ?>');
        var arrivedAtPickup_routes = jQuery.parseJSON('<?php echo json_encode($arrivedAtPickup_routes); ?>');
        var tripStarted_routes = jQuery.parseJSON('<?php echo json_encode($tripStarted_routes); ?>');
        var reachedAtDrop_routes = jQuery.parseJSON('<?php echo json_encode($reachedAtDrop_routes); ?>');
        var unloaded_routes = jQuery.parseJSON('<?php echo json_encode($unloaded_routes); ?>');
        var tripCompleted_routes = jQuery.parseJSON('<?php echo json_encode($tripCompleted_routes); ?>');

        var pick_routesCount = jQuery.parseJSON('<?php echo count($pick_routes); ?>');
        var arrivedAtPickup_routesCount = jQuery.parseJSON('<?php echo count($arrivedAtPickup_routes); ?>');
        var tripStarted_routesCount = jQuery.parseJSON('<?php echo count($tripStarted_routes); ?>');
        var reachedAtDrop_routesCount = jQuery.parseJSON('<?php echo count($reachedAtDrop_routes); ?>');
        var unloaded_routesCount = jQuery.parseJSON('<?php echo count($unloaded_routes); ?>');
        var tripCompleted_routesCount = jQuery.parseJSON('<?php echo count($tripCompleted_routes); ?>');

        //check if the lat long updated for different status
        if (pick_routesCount > 0)
        {
            latlong = pick_routes[0].split(',');
            stops = pick_routesCount;
        } else if (arrivedAtPickup_routesCount > 0)
        {
            latlong = arrivedAtPickup_routes[0].split(',');
            stops = arrivedAtPickup_routesCount;
        } else if (tripStarted_routesCount > 0)
        {
            latlong = tripStarted_routes[0].split(',');
            stops = tripStarted_routesCount;
        } else if (reachedAtDrop_routesCount > 0)
        {
            latlong = reachedAtDrop_routes[0].split(',');
            stops = reachedAtDrop_routesCount;
        } else if (unloaded_routesCount > 0)
        {
            latlong = unloaded_routes[0].split(',');
            stops = unloaded_routesCount;
        } else if (tripCompleted_routesCount > 0)
        {
            latlong = tripCompleted_routes[0].split(',');
            stops = tripCompleted_routesCount;
        } else {
            latlong.push('<?php echo json_encode($data['res']['pickup_location']['latitude']); ?>');
            latlong.push('<?php echo json_encode($data['res']['pickup_location']['longitude']); ?>');
        }

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: new google.maps.LatLng(parseFloat(latlong[0]), parseFloat(latlong[1])),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var bounds = new window.google.maps.LatLngBounds();

        // extend bounds for each record
        var ico;
        var msg = "Driver Accepted - ";
        var j = 0;
        var i = 0;
        var markers = [];
        var myLatlng = '';
        var inf = new google.maps.InfoWindow;

        var pick_routes = jQuery.parseJSON('<?php echo json_encode($pick_routes); ?>');
        var arrivedAtPickup_routes = jQuery.parseJSON('<?php echo json_encode($arrivedAtPickup_routes); ?>');
        var tripStarted_routes = jQuery.parseJSON('<?php echo json_encode($tripStarted_routes); ?>');
        var reachedAtDrop_routes = jQuery.parseJSON('<?php echo json_encode($reachedAtDrop_routes); ?>');
        var unloaded_routes = jQuery.parseJSON('<?php echo json_encode($unloaded_routes); ?>');
        var tripCompleted_routes = jQuery.parseJSON('<?php echo json_encode($tripCompleted_routes); ?>');

        // Define a symbol using a predefined path (an arrow)     
// supplied by the Google Maps JavaScript API.        


        var lineSymbol = {
            path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
        };

// Create the polyline and add the symbol via the 'icons' property.        



        var arr = [];
        if (stops > 0)
        {
            console.log("route");
            msg = "Order Received";
            j = 0;
            ico = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=A|933EC5';

            if (pick_routesCount > 0)
            {
                jQuery.each(pick_routes, function (key, val) {

                    result = val.split(',');
                    var latlongobj = {lat: parseFloat(result[0]), lng: parseFloat(result[1])}
                    arr.push(latlongobj);
                    myLatlng = new window.google.maps.LatLng(parseFloat(result[0]), parseFloat(result[1]));
                    //                msg += val.time;
                    markers[i] = new google.maps.Marker({
                        icon: ico,
                        map: map,
                        animation: google.maps.Animation.DROP,
                        msg: msg,
                        position: myLatlng
                    });
                    google.maps.event.addListener(markers[i], 'click', function () {
                        inf.setContent(this.msg);
                        inf.open(map, this);
                    });
                    //                msg = "";
                    ico = '<?php echo base_url(); ?>/Map Makers/marker4.png';
                    bounds.extend(myLatlng);
                    i++;
                    j++;
                    //                if(j == stops.length-1)
                    //                    msg = "Appointment Completed - ";
                });

                map.fitBounds(bounds);
            }

            ico = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=B|FFDA44';
            msg = "Arrived at Pickup";

            if (arrivedAtPickup_routesCount > 0)
            {

                jQuery.each(arrivedAtPickup_routes, function (key, val) {
                    result = val.split(',');
                    var latlongobj = {lat: parseFloat(result[0]), lng: parseFloat(result[1])}
                    arr.push(latlongobj);
                    myLatlng = new window.google.maps.LatLng(parseFloat(result[0]), parseFloat(result[1]));
                    //                msg += val.time;
                    markers[i] = new google.maps.Marker({
                        icon: ico,
                        map: map,
                        animation: google.maps.Animation.DROP,
                        msg: msg,
                        position: myLatlng
                    });
                    google.maps.event.addListener(markers[i], 'click', function () {
                        inf.setContent(this.msg);
                        inf.open(map, this);
                    });
                    //                msg = "";
                    ico = '<?php echo base_url(); ?>/Map Makers/marker3.png';
                    bounds.extend(myLatlng);
                    i++;
                    j++;
                    //                if(j == stops.length-1)
                    //                    msg = "Appointment Completed - ";
                });

                map.fitBounds(bounds);
            }

            ico = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=C|006DF0';
            msg = "Trip Started";
            if (tripStarted_routesCount > 0)
            {

                jQuery.each(tripStarted_routes, function (key, val) {
                    result = val.split(',');
                    var latlongobj = {lat: parseFloat(result[0]), lng: parseFloat(result[1])}
                    arr.push(latlongobj);
                    myLatlng = new window.google.maps.LatLng(parseFloat(result[0]), parseFloat(result[1]));
                    //                msg += val.time;
                    markers[i] = new google.maps.Marker({
                        icon: ico,
                        map: map,
                        animation: google.maps.Animation.DROP,
                        msg: msg,
                        position: myLatlng
                    });
                    google.maps.event.addListener(markers[i], 'click', function () {
                        inf.setContent(this.msg);
                        inf.open(map, this);
                    });
                    //                msg = "";
                    ico = '<?php echo base_url(); ?>/Map Makers/marker2.png';
                    bounds.extend(myLatlng);
                    i++;
                    j++;
                });
                map.fitBounds(bounds);
            }

            ico = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|402B4D';
            msg = "Reached at Drop";

            if (reachedAtDrop_routesCount > 0)
            {
                jQuery.each(reachedAtDrop_routes, function (key, val) {
                    result = val.split(',');
                    var latlongobj = {lat: parseFloat(result[0]), lng: parseFloat(result[1])}
                    arr.push(latlongobj);
                    myLatlng = new window.google.maps.LatLng(parseFloat(result[0]), parseFloat(result[1]));
                    //                msg += val.time;
                    markers[i] = new google.maps.Marker({
                        icon: ico,
                        map: map,
                        animation: google.maps.Animation.DROP,
                        msg: msg,
                        position: myLatlng
                    });
                    google.maps.event.addListener(markers[i], 'click', function () {
                        inf.setContent(this.msg);
                        inf.open(map, this);
                    });
                    //                msg = "";
                    ico = '<?php echo base_url(); ?>/Map Makers/marker1.png';
                    bounds.extend(myLatlng);
                    i++;
                    j++;

                });
                map.fitBounds(bounds);
            }

            ico = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=E|91DC5A';
            msg = "Delivered";

            if (unloaded_routesCount > 0)
            {
                jQuery.each(unloaded_routes, function (key, val) {
                    result = val.split(',');
                    var latlongobj = {lat: parseFloat(result[0]), lng: parseFloat(result[1])}
                    arr.push(latlongobj);
                    myLatlng = new window.google.maps.LatLng(parseFloat(result[0]), parseFloat(result[1]));
                    //                msg += val.time;
                    markers[i] = new google.maps.Marker({
                        icon: ico,
                        map: map,
                        animation: google.maps.Animation.DROP,
                        msg: msg,
                        position: myLatlng
                    });
                    google.maps.event.addListener(markers[i], 'click', function () {
                        inf.setContent(this.msg);
                        inf.open(map, this);
                    });
                    //                msg = "";
                    ico = '<?php echo base_url(); ?>/Map Makers/marker5.png';
                    bounds.extend(myLatlng);
                    i++;
                    j++;

                });
                map.fitBounds(bounds);
            }


            ico = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=F|044857';
            msg = "Order Completed";
            if (tripCompleted_routesCount.length > 0)
            {
                jQuery.each(tripCompleted_routes, function (key, val) {
                    result = val.split(',');
                    var latlongobj = {lat: parseFloat(result[0]), lng: parseFloat(result[1])}
                    arr.push(latlongobj);
                    myLatlng = new window.google.maps.LatLng(parseFloat(result[0]), parseFloat(result[1]));
                    //                msg += val.time;
                    markers[i] = new google.maps.Marker({
                        icon: ico,
                        map: map,
                        animation: google.maps.Animation.DROP,
                        msg: msg,
                        position: myLatlng
                    });
                    google.maps.event.addListener(markers[i], 'click', function () {
                        inf.setContent(this.msg);
                        inf.open(map, this);
                    });
                    //                msg = "";
                    ico = '<?php echo base_url(); ?>/Map Makers/marker6.png';
                    bounds.extend(myLatlng);
                    i++;
                    j++;

                });
                map.fitBounds(bounds);
            }
            var line = new google.maps.Polyline
                    ({
                        path: arr,
                        strokeOpacity: 0.8,
                        strokeWeight: 3,
                        strokeColor: '#578adb',
                        icons: [{
                                icon: lineSymbol,
                                repeat: '300px',
                                strokeColor: 'red',
                                offset: '100%'
                            }],
                        map: map
                    });

        } else
        {
            console.log('google');
            var directionsDisplay;
            var directionsService = new google.maps.DirectionsService();
            directionsDisplay = new google.maps.DirectionsRenderer();

            directionsDisplay.setMap(map);

            var start = new google.maps.LatLng(<?php echo $data['res']['pickup']['location']['latitude']; ?>, <?php echo $data['res']['pickup']['location']['longitude']; ?>);
            var end = new google.maps.LatLng(<?php echo $data['res']['drop']['location']['latitude']; ?>, <?php echo $data['res']['drop']['location']['longitude']; ?>);

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
    });
    function openimg(imgid)
    {
        $('#modal-img').modal('show');
        var src = $(imgid).attr("src");
        console.log(src);
        $("#showimg").attr("src", src);
    }



//    var m 
</script>