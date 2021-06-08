<?php
//$this->load->database();
$activetab1 = $activetab2 = '';

    foreach ($mongoData as $value) {
        $v_length = substr($value['vehicle_length'],0,-1);
        $v_length_metric =  substr($value['vehicle_length'],-1);

        $v_width = substr($value['vehicle_width'],0,-1);
        $v_width_metric = substr($value['vehicle_width'],-1);

        $v_height = substr($value['vehicle_height'],0,-1);
        $v_height_metric = substr($value['vehicle_height'],-1);
        
        $vehicleTypeName = $value['type_name'];
        $vehicle_capacity = $value['vehicle_capacity'];
        
        $vehicle_img = $value['vehicle_img'];
        $vehicle_img_off = $value['vehicle_img_off'];
        $MapIcon = $value['MapIcon'];
        $desc = $value['type_desc'];
        
        $goodTypesArr = $value['goodTypes'];
        
        $bookingType = $value['bookingType'];
        
        
        $mileage_price_per_km_miles = $value['mileage_price'];
        $mileage_metric = $value['mileage_metric'];
        
        $baseFare = $value['baseFare'];
        $mileage_after_x_km_mile = $value['mileage_after_x_km_mile'];
        $xminuts = $value['xminuts'];
        $xmilage = $value['xmilage'];
        
        $waiting_minutes = $value['waiting_time_min'];
        $waiting_charge_per_min = $value['waiting_charge'];
        
        $cancellation_minutes = $value['cancenlation_min'];
        $cancilation_fee = $value['cancellation_fee'];
        
        $scheduledBookingCancellationMin = $value['scheduledBookingCancellationMin'];
        $scheduledBookingCancellationFee = $value['scheduledBookingCancellationFee'];
        
        $minimum_km_miles = $value['min_distance'];
        $min_fare = $value['min_fare'];
        
        $x_zonal_km_miles = $value['x_zonal_km_miles'];
        $zonal_km_miles_greater_or_less = $value['zonal_km_miles_greater_or_less'];
        $zonalEnable = $value['zonalEnable'];
        
        $longHaulEnDis = $value['longHaulEnDis'];
    }

     $currency = $appConfigData['currencySymbol'];
    $mileageMetric = $appConfigData['mileage_metric'];
    $weightMetric = $appConfigData['weight_metric'];

    
?>



<style>
 
.input-group-addon {
        font-size: inherit;
}
    .input-group {
    margin-bottom: 0px;
}
    .input-group-addon {
            border-radius: 0px !important;
    }
    input[type='file'] {
  color: transparent;
}
    
    .input-group[class*=col-] {
     float: left; 
    padding-right: 0;
    padding-left: 11px;
}
    
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

/*    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}*/
.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}
.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes label {
  display: block;
}
.selectedGood{
           height: 28px;
   padding: 6px;
    display: inline-flex;
    margin: 0px 1px 1px;
    font-weight: 600;
    /*background: #5bc0de;*/
    border: 1px solid;
    border-radius: 4px;
    }
    .inputDesc {
  min-width:15px!important;
  max-width:99.99%!important;
 border: none;
}
td span {
    line-height:0px !important;
}
.RemoveMore  {
    color: #6185b0;height: 18px;
}
input[type=checkbox] {
    margin: 4px 4px 0px 8px;
}
span.abs_text {
    position: absolute;
    right: 10px;
    top: 1px;
    z-index: 9;
    padding: 8px;
    background: #f1f1f1;
    border-right: 1px solid #d0d0d0;
    border-left: 1px solid #d0d0d0;
}
span.abs_textT {
    position: absolute;
    right: 18px;
    top: 1px;
    z-index: 9;
    padding: 8px;
    background: #f1f1f1;
    border-right: 1px solid #d0d0d0;
    border-left: 1px solid #d0d0d0;
}
span.abs_textLeft {
    position: absolute;
    left: 12px;
    top: 1px;
    z-index: 9;
    padding: 8px;
    background: #f1f1f1;
    border-right: 1px solid #d0d0d0;
}

.pos_relative ,.pos_relative2{
    position: relative;
    padding-right:0px
}
.pos_relative2{
    padding-right:10px
}
input#price_MinimumFee,#x_km_mileMinimumFee,#price_after_x_minutesTripDuration,#price_after_x_minWaiting,#price_after_x_minCancel,#price_after_x_minCancelScheduledBookings{
    padding-left: 10px;
}
#vehicle_capacity{
     padding-left: 10px;
}

span.abs_text2 {
    position: absolute;
    left: 1px;
    top: 2px;
    padding: 8px 5px;
    background: #f1f1f1;
    color: #555555;
    border-right: 1px solid #c3c3c3;
}
input#x_minutesCancel,#x_minutesCancelScheduledBookings,#x_minutesWaiting,#x_minutesTripDuration,#mileage_after_x_km_mile,#x_km_mile_price {
    padding-left: 74px;
}   



//Toggal
.cmn-toggle {
    position: absolute;
    margin-left: -9999px;
    
  }
  .cmn-toggle + label {
    display: block;
    position: relative;
    cursor: pointer;
    outline: none;
    user-select: none;
  }
  input.cmn-toggle-round + label {
    padding: 2px;
    width: 94px;
    height: 30px;
    background-color: #dddddd;
    border-radius: 60px;
  }
  input.cmn-toggle-round + label:before,
  input.cmn-toggle-round + label:after {
    display: block;
    position: absolute;
    top: 1px;
    left: 1px;
    bottom: 1px;
    content: "";
  }
  input.cmn-toggle-round + label:before {
    right: 1px;
    background-color: #f1f1f1;
    border-radius: 60px;
    transition: background 0.4s;
  }
  input.cmn-toggle-round + label:after {
    width: 38px;
    background-color: #fff;
    border-radius: 100%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    transition: margin 0.4s;
  }
  input.cmn-toggle-round:checked + label:before {
    background-color: #8ce196;
  }
  input.cmn-toggle-round:checked + label:after {
    margin-left: 60px;
  }
</style>


<script>
        var idNum = 0;
var expanded = false;
var goodTypeID;
var goodType;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}

 function RemoveMore(Id)
     {
         $('#RemoveControl'+Id).remove();
     }

    $(document).ready(function () {
        
         $(".clear").click(function () {
             $('.selectedGoodType').empty();
            $('#updateVehicleTypeForm')[0].reset();
        });
        
        $('.checkbox1').click(function ()
        {
            if($(this).is(":checked"))
            {
                 $('.selectedGoodType').append('<span class="selectedGood" id="RemoveControl'+$(this).attr('id')+'"><input class="inputDesc" readonly type="text"  value="'+$(this).attr('goodType')+'"><input type="button" value="&#10008" data-id="'+$(this).attr('id')+'" class="RemoveMore">')
                 $('#goodType').val($(this).attr('id'));
            }
            else{
                
               RemoveMore($(this).attr('id'));
               
            }
        });
        
                
    
        
        
        //show selected good types
        <?php
                foreach ($speciality_data as $googType)
                {
                     if(in_array($googType['_id']['$oid'],$goodTypesArr))
                     {
                         ?>
                               goodTypeID = '<?php echo $googType['_id']['$oid'];?>';
                               goodType = '<?php echo $googType['name'];?>';
                               
                            $('.selectedGoodType').append('<span class="selectedGood" id="RemoveControl'+goodTypeID+'"><input readonly type="text" class="inputDesc" value="'+goodType+'"><input type="button"  value="&#10008" data-id="'+goodTypeID+'" class="RemoveMore">')
            <?php
                     }
                     else{
                         
                     }
                }
                ?>
        
        if('<?php echo $longHaulEnDis;?>' == 1)
            $('#longHaulEnDis').attr('checked',true);
         else
            $('#longHaulEnDis').attr('checked',false);
        
        //Booking Type Checkbox
        $('#bookingTypeSelected').val('<?php echo $bookingType;?>')
        if('<?php echo $bookingType;?>' == 0)
            $('.bookingType').attr('checked',true);
         else  if('<?php echo $bookingType;?>' == 1)
            $('#bookNow').attr('checked',true);
         else
            $('#bookALater').attr('checked',true);
        
        //Click
            $('.bookingType').click(function ()
            {

                if($('input:checkbox.bookingType:checked').length > 1)
                    $('#bookingTypeSelected').val('0');
                else
                    $('#bookingTypeSelected').val($('input:checkbox.bookingType:checked').val());
            });
        
        
         $('#mileage,#price_after_x_minWaiting,#price_after_x_minCancel,#price_MinimumFee').keypress(function (event) {
            if (event.which < 44
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if ((event.which == 45 && $(this).val().indexOf('-') != -1) || (event.which == 46 && $(this).val().indexOf('.') != -1)) {
                event.preventDefault();
            } // prevent if already dot
        });
        
        $(document).on('click','.RemoveMore',function ()
        {
             $('#'+$(this).attr('data-id')).attr('checked',false);
            $('#RemoveControl'+$(this).attr('data-id')).remove();
        });
        
        
        $('.tabs_active').click(function() {
           
            $('.error-box').text('');
           if($('#vehicletypename').val() == '')
           {
                $("#vehicletype").text(<?php echo json_encode(POPUP_VEHICLETYPE_ENTER); ?>);
               return  false;
           }
           else if($('#type_on_image').val() ==  '' && $('#viewimage_on_image').val() == '')
           {
               $("#type_on_imageErr").text(<?php echo json_encode(POPUP_VEHICLETYPE_ON_IMAGE); ?>);
               return  false;
           }
           else if($('#type_off_image').val() == '' && $('#viewimage_off_image').val() == '')
           {
                $("#type_off_imageErr").text(<?php echo json_encode(POPUP_VEHICLETYPE_OFF_IMAGE); ?>);
               return  false;
           }
         });
        
      

        $("#cancel").click(function () {

            //        if (confirm("Cancel the data you have entered?")) {

            var size = $('input[name=stickup_toggler]:checked').val()
            var modalElem = $('#confirmmodels');
            if (size == "mini")
            {
                $('#modalStickUpSmall').modal('show')
            }
            else
            {
                $('#confirmmodels').modal('show')
                if (size == "default") {
                    modalElem.children('.modal-dialog').removeClass('modal-lg');
                }
                else if (size == "full") {
                    modalElem.children('.modal-dialog').addClass('modal-lg');
                }
            }
            $("#errorboxdatas").text(<?php echo json_encode(POPUP_CANCEL); ?>);

            $("#confirmeds").click(function () {
                $(".close").trigger("click");
                $("#vehicletypename").val('');
                $("#seating").val('');
                $("#minimumfare").val('');
                $("#basefare").val('');
                $("#priceperminute").val('');
                $("#priceperkm").val('');
                $("#discrption").val('');
                $("#citys").val('');

            });
        });

        $("#updateVehicleType").click(function (e) {

            $(".error-box").text("");
            var number = /^\d+$/;
            var validation = /^-?\d*\.?\d*$/;

            var baseFare = $("#baseFare").val();
            
            var mileage = $("#mileage").val();
            var mileage_after_x_km_mile = $("#mileage_after_x_km_mile").val();
            var x_minutesWaiting = $("#x_minutesWaiting").val();
            var price_after_x_minWaiting = $("#price_after_x_minWaiting").val();
            
              //On demand bookings
            var x_minutesCancel = $("#x_minutesCancel").val();
            var price_after_x_minCancel = $("#price_after_x_minCancel").val();
            
             //scheduled bookings
            var x_minutesCancelScheduledBookings = $("#x_minutesCancelScheduledBookings").val();
            var price_after_x_minCancelScheduledBookings = $("#price_after_x_minCancelScheduledBookings").val();
            
           
            //var x_km_mileMinimumFee = $("#x_km_mileMinimumFee").val();
            var price_MinimumFee = $("#price_MinimumFee").val();
            
            var x_minutesTripDuration = $("#x_minutesTripDuration").val();
            var price_after_x_minutesTripDuration = $("#price_after_x_minutesTripDuration").val();

            if (baseFare == "" || baseFare == null)
            {
                $('#baseFareErr').text('Please enter base price');
            }
            else if (!validation.test(baseFare))
            {
                $('#baseFareErr').text('Invalid price');
            }
            else if (mileage == "" || mileage == null)
            {
                $('#mileageErr').text('Please enter mileage price');
            }
            else if (!validation.test(mileage))
            {
                $('#mileageErr').text('Invalid price');
            }
            else if (mileage_after_x_km_mile == "" || mileage_after_x_km_mile == null)
            {
                $('#mileageErr').text('Please enter km/mile');
            }
            else if (!validation.test(mileage_after_x_km_mile))
            {
                $('#mileageErr').text('Invalid price');
            }
            
             else if (x_minutesTripDuration == "" || x_minutesTripDuration == null)
            {
                $('#price_after_x_minutesTripDurationErr').text('Please enter trip duration');
            }
            else if (!number.test(x_minutesTripDuration))
            {
                $('#price_after_x_minutesTripDurationErr').text('Invaild');
            }
            else if (price_after_x_minutesTripDuration == "" || price_after_x_minutesTripDuration == null)
            {
                $('#price_after_x_minutesTripDurationErr').text('Please enter trip duration fee');
            }
            else if (!validation.test(price_after_x_minutesTripDuration))
            {
                $('#price_after_x_minutesTripDurationErr').text('Invaild');
            }
            
            else if (x_minutesWaiting == "" || x_minutesWaiting == null)
            {
                $('#price_after_x_minWaitingErr').text('Please enter minutes');
            }
            else if (!number.test(x_minutesWaiting))
            {
                $('#price_after_x_minWaitingErr').text('Invaild');
            }
            else if (price_after_x_minWaiting == "" || price_after_x_minWaiting == null)
            {
                $('#price_after_x_minWaitingErr').text('Please enter price per minute');
            }
            else if (!validation.test(price_after_x_minWaiting))
            {
                $('#price_after_x_minWaitingErr').text('Invaild');
            }
            
             //On demand booking
            else if (x_minutesCancel == "" || x_minutesCancel == null)
            {
                $('#price_after_x_minCancelErr').text('Please enter cancellation minutes');
            }
            else if (!number.test(x_minutesCancel))
            {
                $('#price_after_x_minCancelErr').text('Invaild');
            }
            else if (price_after_x_minCancel == "" || price_after_x_minCancel == null)
            {
                $('#price_after_x_minCancelErr').text('Please enter cancellation fee');
            }
            else if (!validation.test(price_after_x_minCancel))
            {
                $('#price_after_x_minCancelErr').text('Invaild');
            }
            
            //scheduled booking 
            else if (x_minutesCancelScheduledBookings == "" || x_minutesCancelScheduledBookings == null)
            {
                $('#price_after_x_minCancelScheduledBookingsErr').text('Please enter cancellation minutes');
            }
            else if (!number.test(x_minutesCancelScheduledBookings))
            {
                $('#price_after_x_minCancelScheduledBookingsErr').text('Invaild');
            }
            else if (price_after_x_minCancelScheduledBookings == "" || price_after_x_minCancelScheduledBookings == null)
            {
                $('#price_after_x_minCancelScheduledBookingsErr').text('Please enter cancellation fee');
            }
            else if (!validation.test(price_after_x_minCancelScheduledBookings))
            {
                $('#price_after_x_minCancelScheduledBookingsErr').text('Invaild');
            }
            
//            else if (x_km_mileMinimumFee == "" || x_km_mileMinimumFee == null)
//            {
//                $('#price_MinimumFeeErr').text('Please enter km/mile');//
//            }
//            else if (!number.test(x_km_mileMinimumFee))
//            {
//                $('#price_MinimumFeeErr').text('Invaild');
//            }
            else if (price_MinimumFee == "" || price_MinimumFee == null)
            {
                $('#price_MinimumFeeErr').text('Please enter price');
            }
            else if (!validation.test(price_MinimumFee))
            {
                $('#price_MinimumFeeErr').text('Invaild');
            }
            else {

               $('#updateVehicleTypeForm').submit();

            }

        });

        $("#cancel_s").click(function () {

            window.location = "<?php echo base_url('index.php?/superadmin') ?>/vehicle_type";
        });
        
        
        
        $(":file").on("change", function(e) {
             var fieldID = $(this).attr('id');
            var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                $(this).val('');
                alert('invalid extension..!   Please choose file type in (gif,png,jpg,jpeg)');
            }
            else
            {
                var type;
                var folderName;
                switch($(this).attr('id'))
                {
                    case "type_on_image": type = 1;
                                          folderName = 'vehicleOnImages';  
                                          break;
                    case "type_off_image": type = 2;
                                          folderName = 'vehicleOffImages';  
                                          break;
                                 default :type = 3;
                                          folderName = 'vehicleMapImages';  
                                         
                }
                
                 var formElement = $(this).prop('files')[0];
                 var form_data = new FormData();
             
                    form_data.append('OtherPhoto', formElement);
                    form_data.append('type', 'VehicleTypes');
                    form_data.append('folder',folderName);
                    $.ajax({
                        url: "<?php echo base_url() ?>index.php?/superadmin/upload_images_on_amazon",
                        type: "POST",
                        data: form_data,
                        dataType: "JSON",
                        async: false,
                        beforeSend: function () {
        //                    $("#ImageLoading").show();
                        },
                        success: function (result) {
                            
                             switch(type)
                            {
                                case 1: $('#onImageAWS').val('<?php echo AMAZON_URL;?>'+result.fileName);
                                         $('.onImageAWS').attr('src','<?php echo AMAZON_URL;?>'+result.fileName);
                                        break;
                                case 2: $('#offImageAWS').val('<?php echo AMAZON_URL;?>'+result.fileName);
                                         $('.offImageAWS').attr('src','<?php echo AMAZON_URL;?>'+result.fileName);
                                         break;
                                case 3: $('#mapImageAWS').val('<?php echo AMAZON_URL;?>'+result.fileName);
                                        $('.mapImageAWS').attr('src','<?php echo AMAZON_URL;?>'+result.fileName);
                                         break;
                                 default : '' ;   
                                
                            }

                        },
                        error: function () {

                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
              }
       });

       
        $('#discrption_s').keypress(function (e) {
            var key = e.which;
            if (key == 13)  // the enter key code
            {
                $("#exx").trigger('click');
            }
        });

        $('.number').keypress(function (event) {
            if (event.which < 46
                    || event.which > 59) {
                event.preventDefault();
            } // prevent if not number/dot

            if (event.which == 46
                    && $(this).val().indexOf('.') != -1) {
                event.preventDefault();
            } // prevent if already dot
        });
        
    });

                function movetonext() {

                    var currenttabstatus = $("#mytabs li.active").attr('id');
                    if (currenttabstatus === "firstlitab")
                    {
                        firsttab('secondlitab', 'tab2');

                    }


                }

                function proceed(litabtoremove, divtabtoremove, litabtoadd, divtabtoadd)
                {
                    $("#" + litabtoremove).removeClass("active");
                    $("#" + divtabtoremove).removeClass("active");

                    $("#" + litabtoadd).addClass("active");
                    $("#" + divtabtoadd).addClass("active");
                }
//                                
//                                  
////
                function firsttab(litabtoremove, divtabtoremove)
                {
                    var pstatus = true;
                    $('.error-box').text('');
                    
                    var vtype = $("#vehicletypename").val();
                    var discription_s = $("#discrption").val();
                   
                    var vehicle_length = $("#vehicle_length").val();
                    var vehicle_width = $("#vehicle_width").val();
                    var vehicle_height = $("#vehicle_height").val();
                    var vehicle_capacity = $("#vehicle_capacity").val();

                    var type_on_image = $("#type_on_image").val();
                    var viewimage_on_image = $("#viewimage_on_image").val();
                    
                    var type_off_image = $("#type_off_image").val();
                    var viewimage_off_image = $("#viewimage_off_image").val();
                    
                    var type_map_image = $("#type_map_image").val();
                    var viewimage_map_image = $("#viewimage_map_image").val();

                    var number = /^[0-9-+]+$/;
                    var num = /^[0-9]+(\.[0-9][0-9]?)?$/;
                    var alphanumeric = /[a-zA-Z0-9\-\_]$/;


                    var text = /^[a-zA-Z ]*$/;

                    if (vtype == "" || vtype == null)
                    {
                        $("#vehicletype").text(<?php echo json_encode(POPUP_VEHICLETYPE_ENTER); ?>);
                         pstatus = false;
                    }
                     else if (vehicle_length == "")
                    {
                        $("#vehicle_lengthErr").text('Please enter length');
                         pstatus = false;
                    } 
                     else if (vehicle_width == "")
                    {
                        $("#vehicle_widthErr").text('Please enter width');
                         pstatus = false;
                    } 
                     else if (vehicle_height == "")
                    {
                        $("#vehicle_heightErr").text('Please enter height');
                         pstatus = false;
                    } 
                     else if (vehicle_capacity == "")
                    {
                        $("#vehicle_capacityErr").text('Please enter capacity');
                         pstatus = false;
                    }
                    else if (!$('.bookingType').is(':checked'))
                    {
                        $("#bookingTypeErr").text('Please select booking type');
                         pstatus = false;
                    } 
                     else if (!$('.checkbox1').is(':checked'))
                    {
                        $("#goodTypeErr").text('Please select good types');
                         pstatus = false;
                    } 
                     else if (type_on_image == "" && viewimage_on_image == '')
                    {
                        $("#type_on_imageErr").text(<?php echo json_encode(POPUP_VEHICLETYPE_ON_IMAGE); ?>);
                         pstatus = false;
                    } 
                    else if (type_off_image == "" && viewimage_off_image == '')
                    {
                        $("#type_off_imageErr").text(<?php echo json_encode(POPUP_VEHICLETYPE_OFF_IMAGE); ?>);
                         pstatus = false;
                    }

                    if (pstatus === false)
                    {
                        $("#tab1icon").removeClass("fs-14 fa fa-check");
                        return false;
                    }
                    $("#tab1icon").addClass("fs-14 fa fa-check");
                    $("#prevbutton").removeClass("hidden");
//                            $("#nextbutton").removeClass("hidden");
                    $("#finishbutton").removeClass("hidden");
                    proceed('firstlitab', 'tab1', 'secondlitab', 'tab2');
                    return true;
                }



                function movetoprevious()
                {
                    var currenttabstatus = $("#mytabs li.active").attr('id');
                    if (currenttabstatus === "secondlitab")
                    {

                        proceed('secondlitab', 'tab2', 'firstlitab', 'tab1');
                        $("#prevbutton").addClass("hidden");
                        return true;
                    }

                }

                function profiletab(litabtoremove, divtabtoremove)
                {

                    var pstatus = true;

                    if (isBlank($("#cname").val()) || isBlank($("#pass").val()) || isBlank($("#email").val()) || isBlank($("#addr").val()) || isBlank($("#city").val()) || isBlank($("#vnumber").val()))
                    {
                        pstatus = false;


                    }

                    if (pstatus === false)
                    {
                        setTimeout(function ()
                        {
                            proceed(litabtoremove, divtabtoremove, 'firstlitab', 'tab1');
                        }, 300);

                        alert("complete Company details tab properly");
                        $("#tab1icon").removeClass("fs-14 fa fa-check");
                        return false;

                    }
                    $("#tab1icon").addClass("fs-14 fa fa-check");
                    $("#prevbutton").removeClass("hidden");
                    $("#nextbutton").removeClass("hidden");
                    $("#finishbutton").addClass("hidden");
                    return true;
                }
                function managebuttonstate()
                {
                    $("#prevbutton").addClass("hidden");
                }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    
      function cancel(){
    
            window.location="<?php echo base_url('index.php?/superadmin') ?>/vehicle_type";
    }



</script>
<style>
   
</style>



<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <ul class="breadcrumb" style="margin-left: 0px;margin-top: 5%; ">
                    <li><a href="<?php echo base_url('index.php?/superadmin') ?>/vehicle_type" class=""><?PHP ECHO LIST_VEHICLETYPE; ?></a>
                    </li>

                    <li ><a href="#" class="active"><?php echo strtoupper($operation);?></a>
                    </li>
                 
                </ul>
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="bg-white" data-pages="parallax">
            

            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                     <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                        

                            <li class="active tabs_active" id="firstlitab" onclick="managebuttonstate()">
                                <a data-toggle="tab" href="#tab1" id="tb1" style="width:102%"><i id="tab1icon" class=""></i> <span>VEHICLE TYPE DETAILS</span></a>
                            </li>
                            <li class="tabs_active" id="secondlitab" onclick="managebuttonstate()" ><!--profiletab('secondlitab', 'tab2')-->
                                <a data-toggle="tab" href="#tab2" id="tb2"><i id="tab2icon" class=""></i> <span  > VEHICLE TYPE PRICING</span></a>
                            </li>
                    </ul>
                     <form id="updateVehicleTypeForm" method="post" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/superadmin/update_vehicletype/<?php echo $param;?>"  enctype="multipart/form-data">
                         <div class="tab-content">
                            
                            <div class="tab-pane padding-20 slide-left active" id="tab1">
                                <div class="row row-same-height">
                                    <div class="form-group" class="formexx">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_NAME; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="vehicletypename" name="vehicletypename" class="form-control" value="<?php echo $vehicleTypeName;?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicletype"></div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Length of Vehicle<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-6">
                                                <input type="text" id="vehicle_length" name="vehicle_length" class="form-control number" style="margin-left: -9px;" value="<?php echo $v_length;?>">
                                            </div>
                                           <div class="col-sm-2">
                                               <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="vehicle_length_metric">
                                                     <?php
                                                     
                                                  $m_selected = '';
                                                  $f_selected = '';
                                                   if($v_length_metric == 'M')
                                                       $m_selected = 'selected';
                                                   else 
                                                        $f_selected = 'selected';
                                                   ?>
                                                   <option value="M" <?php echo $m_selected?>>Meter</option>
                                                    <option value="F" <?php echo $f_selected?>>Feet</option>
                                                </select>
                                             </div>
                                        </div>
                             <div class="col-sm-3 error-box" id="vehicle_lengthErr"></div>

                                    </div>
                                    
                                    
                                     
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Width of Vehicle<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-6">
                                                <input type="text" id="vehicle_width" name="vehicle_width" class="form-control number"  style="margin-left: -9px" value="<?php echo $v_width;?>">
                                            </div>
                                           <div class="col-sm-2">
                                                <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="vehicle_width_metric">
                                                      <?php
                                                  $m_selected = '';
                                                  $f_selected = '';
                                                   if($v_width_metric == 'M')
                                                       $m_selected = 'selected';
                                                   else 
                                                        $f_selected = 'selected';
                                                   ?>  
                                                       <option value="M" <?php echo $m_selected?>>Meter</option>
                                                    <option value="F" <?php echo $f_selected?>>Feet</option>
                                                </select>
                                             </div>
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicle_widthErr"></div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Height of Vehicle<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                                 <div class="col-sm-6">
                                                    <input type="text" id="vehicle_height" name="vehicle_height" class="form-control number"  style="margin-left: -9px;" value="<?php echo $v_height;?>">
                                                </div>
                                             <div class="col-sm-2">
                                                <select class="form-control" style="height: 34px; font-size: 11px; display: block;  min-width: 85px;" name="vehicle_height_metric">
                                                      <?php
                                                  $m_selected = '';
                                                  $f_selected = '';
                                                   if($v_height_metric == 'M')
                                                       $m_selected = 'selected';
                                                   else 
                                                        $f_selected = 'selected';
                                                   ?> 
                                                     <option value="M" <?php echo $m_selected?>>Meter</option>
                                                    <option value="F" <?php echo $f_selected?>>Feet</option>
                                                </select>
                                             </div>
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicle_heightErr"></div>

                                    </div>
                                   


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Load Bearing Capacity<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 pos_relative">
                                           
                                                 <div class="col-sm-6">
                                                    <input type="text" id="vehicle_capacity" name="vehicle_capacity" class="form-control number" style="margin-left:-9px" value="<?php echo $vehicle_capacity;?>">
                                                      <span class="abs_textT"><?php echo unserialize(WeightMetric)[$weightMetric];?></span>
                                                </div>
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicle_capacityErr"></div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Booking Type<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6 row">
                                           
                                                
                                                    <label for="bookNow">
                                                        <input type="checkbox" class="bookingType" name="bookingType" id="bookNow"  value="1"/><span>Book Now</span>
                                               </label>
                                               
                                                
                                                    <label for="bookALater">
                                                        <input type="checkbox" class="bookingType" name="bookingType" id="bookALater" value="2"/><span>Book Later</span>
                                               </label>
                                                
                                        </div>
                                        <input type="hidden" name="bookingTypeSelected" id="bookingTypeSelected">
                                        <div class="col-sm-3 error-box" id="bookingTypeErr"></div>

                                    </div>
                                    
                                      <div class="form-group">
                                          <label for="address" class="col-sm-2 control-label">Good Types<span style="" class="MandatoryMarker"> *</span></label>
                                          <div class="col-sm-6">
                                              
                                              <div class="multiselect">
                                        <div class="selectBox " onclick="showCheckboxes()">
                                            <select class="form-control">
                                            <option>Select an option</option>
                                          </select>
                                          <div class="overSelect"></div>
                                        </div>
                                        <div id="checkboxes"> 
                                                   <?php
                                                   foreach ($speciality_data as $googType)
                                                   {
                                                        if(in_array((string)$googType['_id']['$oid'],$goodTypesArr))
                                                        {
                                                         ?>
                                                  <label for="">
                                                      <input type="checkbox" class=" checkbox1" name="goodType[]" id="<?php echo $googType['_id']['$oid'];?>" goodType="<?php echo $googType['name'];?>" checked value="<?php echo $googType['_id']['$oid'];?>"/><?php echo $googType['name'];?>
                                                  </label>

                                                    <?php
                                                      }
                                                      else{
                                                          ?>
                                             <label for="">
                                                      <input type="checkbox" class=" checkbox1" name="goodType[]" id="<?php echo $googType['_id']['$oid'];?>" goodType="<?php echo $googType['name'];?>" value="<?php echo $googType['_id']['$oid'];?>"/><?php echo $googType['name'];?>
                                                  </label>
                                                    
                                            <?php
                                                    }
                                                    }
                                                   ?>
                                        </div>
                                      </div>
                                     
                                        </div>
                                           <div class="col-sm-3 error-box" id="goodTypeErr"></div>
                                      </div> 
                                    
                                    <div class="form-group">
                                          <label for="address" class="col-sm-2 control-label"></label>
                                          <div class="col-sm-6">
                                              <div class="selectedGoodType" style="border-style:groove;min-height: 70px;padding: 6px;"></div>
                                          </div>
                                    </div>
                                   

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_ONIMAGE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-4">

                                            <input type="file" id="type_on_image" name="type_on_image" class="form-control" accept="image/*">
                                             <input type="hidden" id="onImageAWS" name="onImageAWS" class="form-control">
                                             <input type="hidden" value="<?php echo $vehicle_img; ?>" id="viewimage_on_image">

                                        </div>
                                        <div class="col-sm-2">
                                            <img style="width:35px;height:35px;" src="<?php echo $vehicle_img; ?>" alt="" class="onImageAWS style_prevu_kit"></div>
 
                                        <div class="col-sm-3 error-box" id="type_on_imageErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_OFFIMAGE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-4">
                                            <input type="file" id="type_off_image" name="type_off_image" class="form-control" accept="image/*">
                                             <input type="hidden" id="offImageAWS" name="offImageAWS" class="form-control">
                                             <input type="hidden" value="<?php echo $vehicle_img_off; ?>" id='viewimage_off_image'>
                                        </div>
                                         <div class="col-sm-2">
                                            <img style="width:35px;height:35px;" src="<?php echo $vehicle_img_off; ?>" alt="" class="offImageAWS style_prevu_kit"></div>
                                  
                                        <div class="col-sm-3 error-box" id="type_off_imageErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_MAPIMAGE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-4">
                                            <input type="file" id="type_map_image" name="type_map_image" class="form-control" accept="image/*">
                                               <input type="hidden" value="<?php echo $MapIcon; ?>" id='viewimage_map_image'>
                                               <input type="hidden" id="mapImageAWS" name="mapImageAWS" class="form-control">
                                        </div>
                                         <div class="col-sm-2">
                                            <img style="width:35px;height:35px;" src="<?php echo $MapIcon; ?>" alt="" class="mapImageAWS style_prevu_kit"></div>
                                         
                                        <div class="col-sm-3 error-box" id="type_map_imageErr"></div>

                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_DESCRIPTION; ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="discrption" name="descrption" class="form-control" value="<?php echo $desc;?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="disc"></div>

                                    </div>
                                            
                                     <div class="form-group"> 
                                          <div class="col-sm-9">
                                         <div class="pull-right m-t-10"> <button type="button"  id="next" class="btn btn-info btn-cons" onclick="movetonext()" style="margin-right: 0px;"><?php echo BUTTON_NEXT ?></button></div>

                                        
                                        <div class="pull-right m-t-10"> <button  type="button" class="btn btn-primary btn-cons" onclick="cancel()" id="back"><?php echo BUTTON_CANCEL; ?></button></div>
                                          </div>

                                    </div> 
                                    </div> 
                                </div>
                             <div class="tab-pane padding-20 slide-left" id="tab2">
                                  <div class="row row-same-height">
                                      
                                       <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Base Fare<span style="" class="MandatoryMarker"> *</span></label>
                                       
                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="baseFare" name="baseFare" class="form-control" value="<?php echo $baseFare;?>">
                                            <div class="input-group-addon">
                                                   <span style="color: #73879C;"> <?php echo $currency;?></span>
                                                </div>
                                        </div>
                                         <div class="col-sm-3 pos_relative2">
                                             
                                          </div>
                                        <div class="col-sm-3 error-box" id="baseFareErr"></div>

                                    </div>
                                 
                                      <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Mileage Price<span style="" class="MandatoryMarker"> *</span></label>
                                       
                                        
                                            <div class="input-group col-sm-3">
                                                <input type="text" id="mileage" name="mileage" class="form-control" placeholder="Enter mileage price" value="<?php echo $mileage_price_per_km_miles?>">
                                                 <div class="input-group-addon">
                                                   <span style="color: #73879C;"><?php echo $currency;?> / <?php echo unserialize(DistanceMetric)[$mileageMetric];?></span>
                                                </div>
                                             </div>
                                        
                                                <div <div class="col-sm-3 pos_relative2">
                                                    <span class="abs_textLeft">After</span>
                                                    <input type="text" id="mileage_after_x_km_mile" name="mileage_after_x_km_mile" class="form-control number" value="<?php echo $mileage_after_x_km_mile;?>">                                                     <span  class="abs_text Mileagemetric"><?php echo unserialize(DistanceMetric)[$mileageMetric];?></span>
                                                </div>

                                      
                                        <div class="col-sm-3 error-box" id="mileageErr"></div>

                                    </div>
                                      
                                      <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Time Fee<span style="" class="MandatoryMarker"> *</span></label>
                                       
                                        <div class="col-sm-3 input-group pos_relative">
                                           <input type="text" id="price_after_x_minutesTripDuration" name="price_after_x_minutesTripDuration" class="form-control number" placeholder="Enter Price per Minute" value="<?php echo $xmilage;?>">
                                            
                                             <div class="input-group-addon">
                                                   <span style="color: #73879C;"> <?php echo $currency;?> / Min</span>
                                                </div>
                                        </div>
                                         <div class="col-sm-3 pos_relative2"> 
                                             
                                             <span  class="abs_textLeft">After</span>
                                           <input type="text" id="x_minutesTripDuration" name="x_minutesTripDuration" class="form-control"  onkeypress="return isNumber(event)" placeholder="Enter Minutes" value="<?php echo $xminuts?>">
                                            <span  class="abs_text">Minutes</span>
                                         </div>
                                        <div class="col-sm-3 error-box" id="price_after_x_minutesTripDurationErr"></div>

                                    </div>
                                      
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Waiting Fee<span style="" class="MandatoryMarker"> *</span></label>
                                       
                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="price_after_x_minWaiting" name="price_after_x_minWaiting" class="form-control number" placeholder="Enter Price per Minute" value="<?php echo $waiting_charge_per_min?>">
                                       
                                        <div class="input-group-addon">
                                                   <span style="color: #73879C;"> <?php echo $currency;?> / Min</span>
                                                </div>
                                        </div>
                                         <div class="col-sm-3 pos_relative2"> 
                                             
                                             <span  class="abs_textLeft">After</span>
                                            <input type="text" id="x_minutesWaiting" name="x_minutesWaiting" class="form-control"  onkeypress="return isNumber(event)" placeholder="Enter Minutes" value="<?php echo $waiting_minutes?>">
                                            <span  class="abs_text">Minutes</span>
                                         </div>
                                        <div class="col-sm-3 error-box" id="price_after_x_minWaitingErr"></div>

                                    </div>
                                        <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_MINIMUMFARE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                       
                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="price_MinimumFee" name="price_MinimumFee" class="form-control"  onkeypress="return isNumber(event)" placeholder="Enter Price" value="<?php echo $min_fare?>">
                                             <div class="input-group-addon">
                                                   <span style="color: #73879C;"> <?php echo $currency;?></span>
                                                </div>
                                        </div>
                                         <div class="col-sm-3"> 
                                            
                                         </div>
                                        <div class="col-sm-3 error-box" id="price_MinimumFeeErr"></div>

                                    </div>
                                      <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_ON_DEMAND_VEHICLETYPE_CANCILATIONFEE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                       
                                        <div class="col-sm-3 input-group pos_relative">
                                             <input type="text" id="price_after_x_minCancel" name="price_after_x_minCancel" class="form-control number" placeholder="Enter Price" value="<?php echo $cancilation_fee?>">
                                           
                                            <div class="input-group-addon">
                                                   <span style="color: #73879C;"> <?php echo $currency;?></span>
                                                </div>
                                        </div>
                                         <div class="col-sm-3 pos_relative2"> 
                                             <span  class="abs_textLeft">After</span>
                                            <input type="text" id="x_minutesCancel" name="x_minutesCancel" class="form-control"  onkeypress="return isNumber(event)" placeholder="Enter Minutes" value="<?php echo $cancellation_minutes?>">
                                           <span  class="abs_text">Minutes</span>
                                         </div>
                                        <div class="col-sm-3 error-box" id="price_after_x_minCancelErr"></div>

                                    </div>
                                        
                                         <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_SCHEDULED_VEHICLETYPE_CANCILATIONFEE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                       
                                        <div class="col-sm-3 input-group pos_relative">
                                            <input type="text" id="price_after_x_minCancelScheduledBookings" name="price_after_x_minCancelScheduledBookings" class="form-control number" placeholder="Enter Price" value="<?php echo $scheduledBookingCancellationFee;?>">
                                            <div class="input-group-addon">
                                                   <span style="color: #73879C;"> <?php echo $currency;?></span>
                                                </div>
                                        </div>
                                         <div class="col-sm-3 pos_relative2"> 
                                              <input type="text" id="x_minutesCancelScheduledBookings" name="x_minutesCancelScheduledBookings" class="form-control"  onkeypress="return isNumber(event)" placeholder="Enter Minutes" value="<?php echo $scheduledBookingCancellationMin;?>">
                                               
                                             <span  class="abs_text">Minutes Before Pickup Time</span>
                                         </div>
                                        <div class="col-sm-3 error-box" id="price_after_x_minCancelScheduledBookingsErr"></div>

                                    </div>
                                      
                                        
                                        <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Long Haul Enable/Disable</label>
                                          <div class="col-sm-2">
                                          
                                           <div class="switch">
                                               <input id="longHaulEnDis" name="longHaulEnDis" class="cmn-toggle cmn-toggle-round" type="checkbox" style="display: none;">
                                                    <label for="longHaulEnDis"></label>
                                                  </div>
                                           </div>
                                    </div>
                                      
                                       <div class="form-group">
                                           <div class="col-sm-9">
                                               <div class="pull-right m-t-10"> <button type="button"  id="updateVehicleType" class="btn  btn-success btn-cons" style="margin-right: 0px;">Save</button></div>
                                        <div class="pull-right m-t-10"> <button type="button"  id="prevbutton" class="btn btn-default btn-cons" onclick="movetoprevious()"><?php echo BUTTON_PREVIOUS; ?></button></div>
                                     </div>
                                     </div>



                             </div>
                             </div>
                               
                            </div>
  </form>

                        </div>
                   

                </div>


            </div>



        </div>


    </div>

