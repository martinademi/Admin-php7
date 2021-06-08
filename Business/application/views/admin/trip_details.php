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
    $paymentMethod = "Cash";
}
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCK5bz3K1Ns_BASkAcZFLAI_oivKKo98VE"></script>

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
        min-height: 56px;
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
        text-align: center;
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

</style>
<?php
$pick_routes = $data['appRoute']['data']['6'];
$arrivedAtPickup_routes = $data['appRoute']['data']['7'];
$tripStarted_routes = $data['appRoute']['data']['8'];
$reachedAtDrop_routes = $data['appRoute']['data']['9'];
$unloaded_routes = $data['appRoute']['data']['16'];
$tripCompleted_routes = $data['appRoute']['data']['10'];

$apptdata = $data['res'];


foreach ($data['res']['receivers'] as $r) {
    $receiverName = $r['name'];
    $receiverPhone = $r['mobile'];
    $receiverEmail = $r['email'];
}

$arrColor = array(8 => "background:#933EC5!important", 9 => "background:#FFDA44!important", 10 => "background:#006DF0!important", 11 => "background:#402B4D!important", 12 => "background:#91DC5A!important", 13 => "background:#044857!important",14 =>"background:#9CD5A!important",15 =>"background:#9CD5A!important");
$arrStatusCode = array(8 => "A", 10 => "B", 11 => "C", 12 => "D", 13 => "E", 14 => "F" ,15 => "G");
?>    

<div class="page-content-wrapper">
    <div class="content">

        <ul class="breadcrumb" style="margin-top: 5%;">
            <li>
                <a href="<?php echo base_url() . 'index.php?/Business/OrderHistory'; ?>" class="active">ORDER DEATILS - <?php echo $order_id; ?></a>
            </li>
            <?php
            if ($data['res']['status'] == 10 || $data['res']['status'] == 3) {
                ?>
                <a target="_blank" style="color: #0090d9;margin-left: 55px;text-decoration:underline;" href="<?php echo base_url() . 'index.php?/superadmin/invoiceDetails/' . $order_id ?>">Invoice</a>
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

                                    <li class="active tabs_active">
                                        <a href="#customer_details" data-toggle="tab" role="tab" aria-expanded="false">SUMMARY</a>
                                    </li>
                                    <li class="tabs_active">
                                        <a href="#productDetails" data-toggle="tab" role="tab" aria-expanded="false">PRODUCT DETAILS</a>
                                    </li>
                                    <li class="tabs_active">
                                        <a href="#status_details" data-toggle="tab" role="tab" aria-expanded="true">ACTIVITY TIMELINE</a>
                                    </li>



                                    <!--                                    <li class="tabs_active">
                                                                            <a href="#consignment_details" data-toggle="tab" role="tab" aria-expanded="false">CONSIGNMENT</a>
                                                                        </li>-->

                                    <li class="tabs_active">
                                        <?php
                                        if ($data['res']['driverDetails']) {
                                            ?>
                                            <a href="#driver_details" data-toggle="tab" role="tab" aria-expanded="false">DRIVER</a>
                                            <?php
                                        }
                                        ?>
                                    </li>

                                </ul>
                                <div  class="tab-content hidden-xs">
                                    <div class="tab-pane active" id="customer_details">
                                        <?php if ($data['res']['status'] == 2 || $data['res']['status'] == 3) { ?>

                                            <div class="row"  style="margin-top:4%;">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Booking ID</a>
                                                    </p>
                                                    <p class="small">
                                                        <?php echo $order_id; ?>
                                                    </p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Booking Type</a>
                                                    </p>
                                                    <p class="small">

                                                        <?php
                                                        if ($data['res']['bookingType'] == '1')
                                                            echo "Now";
                                                        else
                                                            echo "Later";
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row" style="margin-top: 4%;">
                                                <div class="row">
                                                    <div class="col-sm-6" style="padding-left: 22px;">
                                                        <p class="no-margin"> <img src="" class="img-rounded" alt="" width="20px" height="20px">
                                                            <a href="#" class="headinClass">Pickup At</a>
                                                        </p>

                                                        <p class="small hint-text pickupAddr">
                                                            <?php echo $data['res']['pickup']['address_line1']; ?>       
                                                        </p>

                                                    </div>
                                                    <div class="col-sm-6" >
                                                        <p class="no-margin"><img src="" class="img-rounded" alt="" width="20px" height="20px">
                                                            <a href="#" class="headinClass">Drop At</a>
                                                        </p>
                                                        <p class="small hint-text dropAddr">
                                                            <?php echo $data['res']['drop_addr1']; ?>
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Customer Name</a>
                                                    </p>
                                                    <p class="small"><?php echo $data['res']['slaveName']; ?></p> 
                                                    <span class="errors" id="slaveNameErr"></span>
                                                </div>
                                                <div class="col-sm-6" >
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Receiver Name</a>
                                                    </p>
                                                    <p class="small"><?php echo $receiverName; ?></p> 
                                                    <span class="errors" id="receiverNameErr"></span>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Customer Phone</a>
                                                    </p>
                                                    <p class="small">
                                                    <p class="small"> <?php
                                                            echo $data['res']['slaveCountryCode'];
                                                            echo $data['res']['slavemobile'];
                                                            ?></p> 
                                                    </p>
                                                    <span class="errors" id="slavePhoneErr"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Receiver Phone</a>
                                                    </p>
                                                    <p class="small">   <?php echo $data['res']['slaveCountryCode'] . '' . $receiverPhone; ?> </p>
                                                    <span class="errors" id="receiverPhoneErr"></span>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Customer Email</a>
                                                    </p>
                                                    <p class="small"><?php echo $data['res']['slaveEmail']; ?></p>
                                                    <span class="errors" id="slaveEmailErr"></span>
                                                </div>


                                            </div>
                                            <hr>
                                            <div class="row">

                                                <div class="col-sm-6"  style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Cancelled By</a>
                                                    </p>
                                                    <?php if ($data['res']['status'] == 3) { ?>
                                                        <p class="small">
                                                            <?php echo 'Customer - ' . $data['res']['slaveName']; ?>
                                                        </p>
                                                        <p class="small">
                                                            <?php echo 'Reason - ' . $data['res']['Reason']; ?>
                                                        </p>
                                                    <?php } if ($data['res']['status'] == 4) { ?>

                                                        <p class="small">
                                                            <?php echo 'Driver - ' . $data['res']['driverDetails']['fName'] . ' ' . $data['res']['driverDetails']['lName']; ?>
                                                        </p>
                                                        <p class="small">
                                                            <?php echo 'Reason - ' . $data['res']['Reason']; ?>
                                                        </p>
                                                    <?php } ?>

                                                </div>
                                                <div class="col-sm-6" >
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Cancellation Fee</a>
                                                    </p>
                                                    <p class="small">
                                                        <?php echo $data['res']['accouting']['cancelationFee'] ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <?php if ($data['res']['accouting']['cancelationFee'] != 0) { ?>
                                                    <div class="col-sm-6"  style="padding-left: 22px;">
        <!--                                                        <p class="no-margin">
                                                            <a href="#" class="headinClass">Paid By </a>
                                                        </p>
                                                        <p class="small">
                                                        <?php // echo $card;  ?>
                                                        </p>-->
                                                        <p class="no-margin">
                                                            <a href="#" class="headinClass">Payment Type</a>
                                                        </p>
                                                        <p class="small">
                                                            <?php
                                                            if ($data['res']['payment_type'] == 1)
                                                                echo 'Card';
                                                            else if ($data['res']['payment_type'] == 2)
                                                                echo 'Cash';
                                                            else
                                                                echo 'Net30';
                                                            ?>
                                                        </p>
                                                    </div>
                                                <?php } ?>
                                            </div>


                                        <?php } else { ?>
                                            <div class="row" style="margin-top:4%;">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Order ID</a>
                                                    </p>
                                                    <p class="small">
                                                        <?php echo $order_id; ?>
                                                    </p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Order Type</a>
                                                    </p>
                                                    <p class="small">
                                                        <?php
                                                        if ($data['res']['bookingType'] == 1)
                                                            echo "Now";
                                                        else
                                                            echo "Later";
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row" style="margin-top: 4%;">
                                                <div class="row">
                                                    <div class="col-sm-6" style="padding-left: 22px;">
                                                        <p class="no-margin"> 
                                                            <!--<img src="<?php //echo base_url();  ?>../../pics/pickup_small_icon.png" class="img-rounded" alt="" width="20px" height="20px">-->
                                                            <a href="#" class="headinClass">Pickup At</a>
                                                        </p>

                                                        <p class="small hint-text pickupAddr">
                                                            <?php echo $data['res']['pickup']['addressLine1']; ?><br/>   
                                                            <?php echo $data['res']['pickup']['addressLine2']; ?>       
                                                        </p>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <p class="no-margin">
                                                            <!--<img src="<?php //echo base_url();  ?>../../pics/dropdown_small_icon.png" class="img-rounded" alt="" width="20px" height="20px">-->
                                                            <a href="#" class="headinClass">Drop At</a>
                                                        </p>
                                                        <p class="small hint-text dropAddr">
                                                            <?php echo $data['res']['drop']['addressLine1']; ?><br/>
                                                            <?php echo $data['res']['drop']['addressLine2']; ?>
                                                        </p>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row" style="margin-top: 4%;">
                                                <div class="row">


                                                    <div class="col-sm-6" style="padding-left: 22px;">
                                                        <p class="no-margin">
                                                            <!--<img src="<?php //echo base_url();  ?>../../pics/dropdown_small_icon.png" class="img-rounded" alt="" width="20px" height="20px">-->
                                                            <a href="#" class="headinClass">Pickup Time</a>
                                                        </p>
                                                        <p class="small hint-text dropAddr">
                                                            <?php echo date('j-M-Y g:i:s A', $data['res']['timeStamp']['accepted']['timeStamp']); ?>

                                                        </p>
                                                    </div>
                                                    <div class="col-sm-6" >
                                                        <p class="no-margin">
                                                            <!--<img src="<?php //echo base_url();  ?>../../pics/dropdown_small_icon.png" class="img-rounded" alt="" width="20px" height="20px">-->
                                                            <a href="#" class="headinClass">Drop Time</a>
                                                        </p>
                                                        <p class="small hint-text dropAddr">
                                                            <?php echo date('j-M-Y g:i:s A', $data['res']['timeStamp']['completed']['timeStamp']); ?>

                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Customer Name</a>
                                                    </p>
                                                    <p class="small"><?php echo $data['res']['customerDetails']['name']; ?></p> 
                                                    <span class="errors" id="slaveNameErr"></span>
                                                </div>
                                                <div class="col-sm-6" >
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Payment Method</a>
                                                    </p>
                                                    <p class="small"><?php echo $paymentMethod; ?> </p> 
                                                    <span class="errors" id="receiverNameErr"></span>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Customer Phone</a>
                                                    </p>
                                                    <p class="small">
                                                    <p class="small"> <?php echo $data['res']['customerDetails']['countryCode'] . $data['res']['customerDetails']['mobile']; ?></p> 
                                                    </p>
                                                    <span class="errors" id="slavePhoneErr"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Delivery Fee</a>
                                                    </p>
                                                    <p class="small">   <?php echo $data['res']['deliveryCharge']; ?> </p>
                                                    <span class="errors" id="receiverPhoneErr"></span>
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 3%;">
                                                <div class="col-sm-6" style="padding-left: 22px;">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Customer Email</a>
                                                    </p>
                                                    <p class="small"><?php echo $data['res']['customerDetails']['email']; ?></p>
                                                    <span class="errors" id="slaveEmailErr"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="no-margin">
                                                        <a href="#" class="headinClass">Total Amount</a>
                                                    </p>
                                                    <p class="small">
                                                     
                                                        <?php echo $data['res']['totalAmount']; ?>
                                                    </p>
                                                    <span class="errors" id="receiverimgErr"></span>

                                                </div>

                                            </div>
                                        <?php  } ?>
                                        </div>    
                                                                 

                                    <div class="tab-pane" id="driver_details">
                                        <div class="row-xs-height" style="margin-top: 6%;">
                                            <div class="social-user-profile col-xs-height  col-top">
                                                <div class="thumbnail-wrapper circular bordered b-white">
                                                    <img class="img-responsive img-circle" alt="<?php echo $data['driver_data']->first_name; ?>"  style="cursor:pointer;width:50px;height:50px;"

                                                         src="<?php echo $data['res']['driverDetails']['image'] ?>"
                                                         onerror="this.src = '<?php echo base_url('/../../pics/user.jpg ') ?>'">
                                                </div>
                                                <br><?php if (in_array($data['res']['status'], array(10))) { ?>
                                                    <p class="rating">
                                                        <?php
                                                        for ($i = 1; $i <= 5; $i++) {
                                                            if ($i > $data['res']['CustomerRating'])
                                                                echo '<i class="fa fa-star"></i>';
                                                            else
                                                                echo '<i class="fa fa-star rated"></i>';
                                                        }
                                                        ?>
                                                    </p>
                                                    <p style="padding-left: 10px;"><?php echo $data['res']['CustomerRating']; ?> of 5</p>
                                                <?php } ?>
                                            </div>

                                            <div class="col-xs-height p-l-20" style="padding-left: 32px;">
                                                <p style="padding: 5px 0px 5px 0px;" class="small"><img src="<?php //echo base_url();  ?>assests/default_user.jpg" width="12px" alt="NA"><?php echo "   " . $data['res']['driverDetails']['fName'] . " " . $data['res']['driverDetails']['lName']; ?></p>
                                                <p style="padding: 5px 0px 5px 0px;" class="fs-16 fa fa-envelope small"><?php echo "   " . $data['res']['driverDetails']['email']; ?></p><br>
                                                <p style="padding: 5px 0px 5px 0px;" class="fs-16 fa fa-phone small"><?php echo "   " . $data['res']['slaveCountryCode'] . $data['res']['driverDetails']['mobile']; ?></p><br>
                                                <!--<p style="padding: 5px 0px 5px 0px;" class="small"><img src="<?php echo base_url(); ?>../../admin/assets/license-plate.png" width="12px" alt="NA"><?php echo "   " . $data['res']['vehicleData']['platNo']; ?></p>-->
                                                <p style="padding: 5px 0px 5px 0px;" class="small" ><i class="fs-16 fa fa-car "  aria-hidden="true"></i><?php echo "   " . $data['res']['vehicleData']['platNo']; ?></p>
                                            </div>
                                        </div> 
                                        <hr>
                                    </div>
                                    <div class="tab-pane" id="status_details">
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
                                                        echo $resArray['msg'];
                                                        echo "           ";
                                                        ?><span  class="activity_status_text"><?php echo date('M-d, Y, h:i:a ', $resArray['time']); ?></span></span>
                                                        <span  class="bullet_line"></span>
                                                    </div>
                                                <?php } else { ?>
                                                    <div  class="activity_body">
                                                        <?php echo $arrStatusCode[$resArray['status']]; ?><span  class="bullet_points" style="<?php echo $arrColor[$resArray['status']]; ?>"></span>
                                                        <span  class="activity_status col-lg-6"><?php
                                                        echo $resArray['msg'];
                                                        echo "  [  Bid  :" . $resArray['bid'] . "] :        "
                                                        ?><span  class="activity_status_text col-lg-3"><?php echo date('M-d, Y, h:i:a ', $resArray['time']); ?></span></span>
                                                        <span  class="bullet_line"></span>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="tab-pane" id="consignment_details">
                                        <div class="row" style="margin-top:4%">

                                            <div class="col-sm-6" >
                                                <p class="no-margin">
                                                    <a href="#" class="headinClass">Additional Notes</a>
                                                </p>
                                                <p class="small">
                                                    <?php
                                                    if ($data['res']['extra_notes'] != '') {
                                                        ?>
                                                    <p class="small"><?php echo $data['res']['extra_notes']; ?></p>
                                                        <?php
                                                    } else {
                                                        ?>
                                                    <p class=""><?php echo 'No notes provided by customer'; ?></p>
                                                    <?php
                                                }
                                                ?>

                                                <span id="qtyErr" class="errors"></span>

                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:4%"></div>
                                        <div class="row" >


                                            <div class="col-sm-6" >
                                                <p class="no-margin">
                                                    <a href="#" class="headinClass">Quantity</a>
                                                </p>
                                                <p class="small">

                                                <p class="small"><?php echo $result; ?></p>
                                                <span id="qtyErr" class="errors"></span>

                                            </div>
                                        </div>

                                        <div class="row" style="margin-top:4%">
                                            <p class="no-margin" >
                                                <a href="#" class="headinClass" style="width: 100px;height: 100px;font-size: 14px;">Documents</a>
                                            </p>

                                        </div>
<?php if ($data['res']['receivers'][0]['photo']) { ?>
                                            <div class="row"style="margin-top:2%" >

                                                <div>
                                                    <p class="no-margin" class="headinClass">
                                                        <a href="#" class="headinClass" style="width: 100px;height: 100px;">Shipper</a>
                                                    </p>
                                                </div>

    <?php
    $index = 1;
    foreach ($data['res']['receivers'][0]['photo'] as $images) {
        ?>

                                                    <div class="col-sm-2">
                                                        <img id="myImg<?php echo $index; ?>" class="Imagepop" src="<?php echo $images; ?>" alt="" width="50" height="50">
        <!--                                                        <a target="_blank" href="<?php echo $images; ?>">
                                                                <img src="<?php echo $images; ?>" class="imgClass" alt="Forest" style="width:50px; height:50px" >
                                                            </a>-->
                                                    </div>
    <?php } ?>
                                            </div>
                                                <?php
                                                $index ++;
                                            } else {
                                                echo '<p>No job Documents</p>';
                                            }
                                            ?>
                                        <?php if ($data['res']['receivers'][0]['pickupImages']) { ?>
                                            <div class="row" >

                                                <div >
                                                    <p class="no-margin" class="headinClass">
                                                        <a href="#" class="headinClass" style="width: 100px;height: 100px;">Driver( At Pickup )</a>
                                                    </p>
                                                </div>

    <?php foreach ($data['res']['receivers'][0]['photo'] as $images) { ?>

                                                    <div class="col-sm-2">
                                                        <img id="myImg" class="Imagepop" src="<?php echo $images; ?>" alt="" width="50" height="50">
            <!--                                                        <a target="_blank" href="<?php echo $images; ?>">
                                                                         <img src="<?php echo $images; ?>" class="imgClass" alt="Forest" style="width:50px; height:50px" >
                                                                    </a>-->
                                                    </div>
    <?php } ?>
                                            </div>
<?php } ?>
                                            <?php if ($dropImages) { ?>
                                            <div class="row" >
                                                <div >
                                                    <p class="no-margin" class="headinClass">
                                                        <a href="#" class="headinClass" style="width: 100px;height: 100px;">Driver ( At Drop )</a>
                                                    </p>
                                                </div>
    <?php foreach ($dropImages as $images) { ?>

                                                    <div class="col-sm-2">
        <!--<a target="_blank" href="<?php echo $images; ?>">
        <img src="<?php echo $images; ?>" class="imgClass" alt="Forest" style="width:50px; height:50px" >
        </a>-->

                                                        <img id="myImg" class="Imagepop" src="<?php echo $images; ?>" alt="" width="50" height="50">
                                                    </div>
    <?php } ?>
                                            </div>
<?php } ?>

                                    </div>
                                    <div class="tab-pane" id="productDetails">
                                            <hr>
                                            <?php foreach ($data['res']['Items'] as $productsData) { ?>
                                                <div class="row">

                                                    <div class="col-sm-6"  style="padding-left: 22px;">
                                                        <p class="no-margin">
                                                            <a href="#" class="headinClass">Product Image</a>
                                                        </p>
                                                        <p class="small">
                                                            <img src=" <?php echo $productsData['itemImageURL']; ?>" style="height:80px;width:80px;">

                                                        </p>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="col-sm-12" >
                                                            <p class="no-margin">
                                                                <a href="#" class="headinClass">Product Name</a>
                                                            </p>
                                                            <p class="small">
                                                                <?php echo $productsData['itemName']; ?>
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-12" >
                                                            <p class="no-margin">
                                                                <a href="#" class="headinClass">Product Quantity</a>
                                                            </p>
                                                            <p class="small">
                                                                <?php echo $productsData['quantity']; ?>
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-12" >
                                                            <p class="no-margin">
                                                                <a href="#" class="headinClass"> Unit Price</a>
                                                            </p>
                                                            <p class="small">
                                                                <?php echo $productsData['unitPrice']; ?>
                                                            </p>
                                                        </div>
                                                        <div class="col-sm-12" >
                                                            <p class="no-margin">
                                                                <a href="#" class="headinClass"> Total</a>
                                                            </p>
                                                            <p class="small">
                                                                <?php echo $productsData['unitPrice'] * $productsData['quantity']; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row"></div>
                                            <?php } ?>
                                    
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
            msg = "Booking Received";
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
            msg = "Unloaded";

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
            msg = "Trip Completed";
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

            var start = new google.maps.LatLng(<?php echo $data['res']['pickup_location']['latitude']; ?>, <?php echo $data['res']['pickup_location']['longitude']; ?>);
            var end = new google.maps.LatLng(<?php echo $data['res']['drop_location']['latitude']; ?>, <?php echo $data['res']['drop_location']['longitude']; ?>);

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

<div id="myModal" class="modal">

    <!-- The Close Button -->
    <!--<span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>-->

    <!-- Modal Content (The Image) -->
    <img class="modal-content" id="img01">

    <!-- Modal Caption (Image Text) -->
    <div id="caption"></div>
</div>