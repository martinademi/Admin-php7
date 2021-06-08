<?php
//$this->load->database();
$activetab1 = $activetab2 = '';
?>


<style>
    .ui-autocomplete{
        z-index: 5000;
    }
    #selectedcity,#companyid{
        display: none;
    }

    .ui-menu-item{cursor: pointer;background: black;color:white;border-bottom: 1px solid white;width: 200px;}
</style>


<script>
       <?php
//        $pricingModel = '';
//            foreach ($pricingModelData as $row)
//            $pricingModel = $row['pricingModel'];
//                ?>
//        var pricingModel = '<?php echo $pricingModel?>';
       

    $(document).ready(function () {
        
        $('#mileage_metric').change(function ()
        {
            if($('#mileage_metric').val() == 1)
            {
                $('#mileage_after').attr("placeholder", "Price After x miles").blur();
                $('.pricePerMinLabel').text("Price Per Mile <?php echo "(".currency.")";?>");
                
            }
            else
            {
                $('#mileage_after').attr("placeholder", "Price After x km").blur();
                  $('.pricePerMinLabel').text("Price Per Km <?php echo "(".currency.")";?>");
            }
        });
        $('#edit_mileage_metric').change(function ()
        {
            if($('#edit_mileage_metric').val() == 1)
            {
                $('#edit_mileage_after').attr("placeholder", "Price After x miles").blur();
                $('.edit_pricePerMinLabel').text("Price Per Mile <?php echo "(".currency.")";?>");
                
            }
            else
            {
                $('#edit_mileage_after').attr("placeholder", "Price After x km").blur();
                  $('.edit_pricePerMinLabel').text("Price Per Km <?php echo "(".currency.")";?>");
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


        $("#cancel_s").click(function () {

            window.location = "<?php echo base_url('index.php?/vehicle') ?>/vehicle_type";
        });


        $("#type_on_image").change(function ()

        {
            var iSize = ($("#type_on_image")[0].files[0].size / 1024);

            if (iSize / 1024 > 1)

            {
                $("#type_on_imageErr").html("your file is too large");
            }
            else
            {
                iSize = (Math.round(iSize * 100) / 100)
                $("#type_on_imageErr").html(iSize + "kb");

            }
        });

        $("#type_off_image").change(function ()

        {
            var iSize = ($("#type_off_image")[0].files[0].size / 1024);

            if (iSize / 1024 > 1)

            {
                $("#type_off_imageErr").html("your file is too large");
            }
            else
            {
                iSize = (Math.round(iSize * 100) / 100)
                $("#type_off_imageErr").html(iSize + "kb");

            }
        });

        $("#type_map_image").change(function ()

        {
            var iSize = ($("#type_map_image")[0].files[0].size / 1024);

            if (iSize / 1024 > 1)

            {
                $("#type_map_imageErr").html("your file is too large");
            }
            else
            {
                iSize = (Math.round(iSize * 100) / 100)
                $("#type_map_imageErr").html(iSize + "kb");

            }
        });


        $("#addvehicle").click(function () {

            $(".error-box").text("");
            
            $("#vehicletype").text("");
            $("#seat").text("");
            $("#minimum").text("");
            $("#base").text("");
            $("#pricepermin").text("");
            $("#pricekm").text("");
            $("#disc").text("");
            $("#cities").text("");
            $("#cancilationf").text("");
            $("#waiting_chargeErr").text("");



            var vtype = $("#vehicletypename").val();
            var seating = $("#seating").val();
            var mfare = $("#minimumfare").val();
            var bfare = $("#basefare").val();
            var ppmnt = $("#priceperminute").val();
            var ppkm = $("#priceperkm").val();
            var cancilationfee = $("#cancilationfee").val();
            var discription_s = $("#discrption").val();
            
            var mileage = $("#mileage").val();
            var x_minutes = $("#x_minutes").val();
            var price_after_x_min = $("#price_after_x_min").val();
            var vehicle_length = $("#vehicle_length").val();
            var vehicle_width = $("#vehicle_width").val();
            var vehicle_height = $("#vehicle_height").val();
            var vehicle_capacity = $("#vehicle_capacity").val();

            var type_on_image = $("#type_on_image").val();
            var type_off_image = $("#type_off_image").val();
            var type_map_image = $("#type_map_image").val();
            var waiting_charge_per_min = $("#waiting_charge").val();
            
            var mileage_after = $("#mileage_after").val();

            var number = /^[0-9-+]+$/;
            var num = /^[0-9]+(\.[0-9][0-9]?)?$/;

            //  var phone = /^\d{10}$/;
            // var company = /^[-\w\s]+$/;
            var alphanumeric = /[a-zA-Z0-9\-\_]$/;

            // var email = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/; //^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            var text = /^[a-zA-Z ]*$/;

            if (vtype == "" || vtype == null)
            {
                $("#vehicletype").text(<?php echo json_encode(POPUP_VEHICLETYPE_ENTER); ?>);
            }else if (mileage == "" || mileage == null)
            {
                $("#mileageErr").text('Please enter the mileage for km/miles');
            }
            else if (!num.test(mileage))
            {
                $("#mileageErr").text('Please enter mileage as numeric');
            }
            else if (mileage_after == "" || mileage_after == null)
            {
//               
                $("#mileageErr").text('Please enter mileage price after x km/miles');
            }
            else if (!num.test(mileage_after))
            {
//               
                $("#mileageErr").text('Please enter mileage price as numeric');
            }
            else if (x_minutes == "" || x_minutes == null)
            {
//               
                $("#price_after_x_minErr").text('Please enter minutes');
            }
            else if (!num.test(x_minutes))
            {
//             
                $("#price_after_x_minErr").text('Please enter minutes in numeric');
            }
            else if (price_after_x_min == "" || price_after_x_min == null)
            {
//               
                $("#price_after_x_minErr").text('Please enter price after x minutes');
            }
            else if (!num.test(price_after_x_min))
            {
//             
                $("#price_after_x_minErr").text('Please enter price as numeric');
            }
            else if (mfare == ""  || mfare == null)
            {
                $("#minimum").text(<?php echo json_encode(POPUP_VEHICLETYPE_MINMUM); ?>);
            }
            else if (!num.test(mfare))
            {
                $("#minimum").text(<?php echo json_encode(POPUP_VEHICLETYPE_MINMUM_NUMBER); ?>);
            }
            
             else if (type_on_image == "" || type_on_image == null)
            {
               
                $("#type_on_imageErr").text(<?php echo json_encode(POPUP_VEHICLETYPE_ON_IMAGE); ?>);
            } 
            else if (type_off_image == "" || type_off_image == null)
            {
//                alert("enter the cost per kilometer");
                $("#type_off_imageErr").text(<?php echo json_encode(POPUP_VEHICLETYPE_OFF_IMAGE); ?>);
            }
            else
            {
                $('#addentity').submit();

            }
        });

        $("#exx").click(function () {


            $("#vehicle_type_name").text("");
            $("#vehicle_seating").text("");
            $("#vehicle_minimumfare").text("");
            $("#vehicletype_basefare").text("");
            $("#vehicletype_pricepermin").text("");
            $("#vehicletype_priceperkm").text("");
            $("#vehicletype_description").text("");
            $("#vehicletype_cities").text("");
            $("#waiting_charge_editErr").text("");


            var mileage_after = $("#edit_mileage_after").val();
            
            var x_minutes = $("#x_minutesEdit").val();
            var price_after_x_min = $("#price_after_x_minEdit").val();
            
            var vtype = $("#vehicletypename_s").val();
            var mileage = $("#edit_mileage").val();
            var mfare = $("#minimumfare_s").val();
            var bfare = $("#basefare_s").val();
            var ppmnt = $("#priceperminute_s").val();
            var ppkm = $("#priceperkm_s").val();
            var discription_s = $("#discrption_s").val();
            var city = $("#city_s").val();
            
            var waiting_charge_edit = $("#waiting_charge_edit").val();
            var type_on_image_edit = $("#type_on_image_edit").val();
            var type_off_image_edit = $("#type_off_image_edit").val();
            var type_map_image_edit = $("#type_map_image_edit").val();

            var number = /^[0-9-+]+$/;
            var num = /^[0-9]+(\.[0-9][0-9]?)?$/;
            var alphanumeric = /[a-zA-Z0-9\-\_]$/;
            var text = /^[a-zA-Z ]*$/;


            if (vtype == "" || vtype == null)
            {
                $("#vehicle_type_name").text(<?php echo json_encode(POPUP_VEHICLETYPE_ENTER); ?>);
            }else if (mileage == ""|| mileage == null)
            {
//                
                $("#edit_mileageErr").text('Please enter the mileage price');
            }
            else if (!num.test(mileage))
            {
//               
                $("#edit_mileageErr").text('Please enter mileage price as numeric value');
            }
            else if (mileage_after == ""|| mileage_after == null)
            {
//                
                $("#edit_mileageErr").text('Please enter mileage after x km/miles');
            }
            else if (!num.test(mileage_after))
            {
//               
                $("#edit_mileageErr").text('Please enter mileage price as numeric');
            }
             else if (x_minutes == "" || x_minutes == null)
            {
//               
                $("#price_after_x_minEditErr").text('Please enter minutes');
            }
            else if (!num.test(x_minutes))
            {
//             
                $("#price_after_x_minEditErr").text('Please enter minutes in numeric');
            }
            else if (price_after_x_min == "" || price_after_x_min == null)
            {
//               
                $("#price_after_x_minEditErr").text('Please enter price after x minutes');
            }
            else if (!num.test(price_after_x_min))
            {
//             
                $("#price_after_x_minEditErr").text('Please enter price as numeric');
            }
            else if (mfare == "" || mfare == null)
            {
                $("#vehicle_minimumfare").text(<?php echo json_encode(POPUP_VEHICLETYPE_MINMUM); ?>);

            }
            else if (!num.test(mfare))
            {
                $("#vehicle_minimumfare").text(<?php echo json_encode(POPUP_VEHICLETYPE_MINMUM_VALIDATION); ?>);

            }else
            {
                $('#updateentity').submit();
   
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


    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }


</script>
<style>
   
</style>


<div class="page-content-wrapper">
    <!-- START PAGE CONTENT -->
    <ul class="breadcrumb" style="margin-left: 0px;margin-top: 5%; ">
                    <li><a href="<?php echo base_url('index.php?/vehicle') ?>/vehicle_type" class=""><?PHP ECHO LIST_VEHICLETYPE; ?></a>
                    </li>

                    <li ><a href="#" class="active"><?php echo strtoupper($operation);?></a>
                    </li>
                 
                </ul>
    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="bg-white" data-pages="parallax">
            <div class="inner">
            
            </div>



            <div class="container-fluid container-fixed-lg bg-white">

                <div id="rootwizard" class="m-t-50">
                     <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" id="mytabs">
                        <?php
                        if ($param == '') {
                            $activetab1 = "active";
                            ?>

                            <li class="active tabs_active" id="firstlitab" onclick="managebuttonstate()">
                                <a data-toggle="tab" href="#tab1" id="tb1" style="width:102%"><i id="tab1icon" class=""></i> <span>VEHICLE TYPE DETAILS</span></a>
                            </li>
                            <li class="tabs_active" id="secondlitab" onclick="managebuttonstate()" ><!--profiletab('secondlitab', 'tab2')-->
                                <a data-toggle="tab" href="#tab2" id="tb2"><i id="tab2icon" class=""></i> <span  > VEHICLE TYPE PRICING</span></a>
                            </li>


                            <?php
                        } else {
                            $activetab2 = "active";
                            ?>
                            <li class="" id="thirdlitab">
                                <a data-toggle="tab" href="#tab3"  id="mtab2"><i id="tab3icon" class=""></i> <span><?php echo LIST_EDIT_COMPANY_DETAILS; ?></span></a>
                            </li>
                        <?php } ?>

                    </ul>
                         <div class="tab-content">
                            <div class="tab-pane padding-20 slide-left <?php echo $activetab1 ?>" id="tab1">

                                 <form id="addentity" method="post" class="form-horizontal" role="form" action="<?php echo base_url(); ?>index.php?/vehicle/insert_vehicletype"  enctype="multipart/form-data">

                  
                                <div class="row row-same-height">


<!--                                    <div class="form-group">
                                        <label for="address" class="col-sm-3 control-label"><?PHP ECHO FIELD_VEHICLETYPE_CITY; ?><span style="color:red;font-size: 18px">*</span></label>
                                        <div class="col-sm-6">


                                            <select id="city" name="country_select"  class="form-control" >
                                                <option value="0">Select city</option>
                                                <?php
                                                foreach ($city as $result) {

                                                    echo "<option value=" . $result->City_Id . ">" . $result->City_Name . "</option>";
                                                }
                                                ?>

                                            </select>

                                        </div>
                                        <div class="col-sm-3 error-box" id="cities"></div>

                                    </div>-->


                                    <div class="form-group" class="formexx">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_NAME; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="vehicletypename" name="vehicletypename" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicletype"></div>
                                    </div>
                                    <div class="form-group pricingModelSet">
                                        <label for="address" class="col-sm-2 control-label">Mileage Price<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-2">
                                            <input type="text" id="mileage" name="mileage" class="form-control"  onkeypress="return isNumber(event)" placeholder="Enter km">
                                        </div>
                                        <div class="col-sm-2">
                                         <select class="form-control" id="mileage_metric" name="mileage_metric">
                                                    <option value="0">Km</option>
                                                    <option value="1">Mile</option>
                                                </select> 
                                        </div>
                                         <div class="col-sm-2">
                                        <input type="text" id="mileage_after" name="mileage_after" class="form-control number"  placeholder="Price after x km">
                                         </div>
                                        <div class="col-sm-2 error-box" id="mileageErr"></div>

                                    </div>
                                    <div class="form-group pricingModelSet">
                                        <label for="address" class="col-sm-2 control-label">Price<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-2">
                                            <input type="text" id="x_minutes" name="x_minutes" class="form-control"  onkeypress="return isNumber(event)" placeholder="Enter minutes">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text"  class="form-control" value="Minutes" disabled>
                                        </div>
                                         <div class="col-sm-2">
                                            <input type="text" id="price_after_x_min" name="price_after_x_min" class="form-control number" placeholder="Price after x minutes">
                                         </div>
                                        <div class="col-sm-2 error-box" id="price_after_x_minErr"></div>

                                    </div>

                                    <div class="form-group pricingModelSet">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_MINIMUMFARE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="minimumfare" name="minimumfare" class="form-control number" >

                                        </div>
                                        <div class="col-sm-3 error-box" id="minimum"></div>
                                    </div>


                                    

                                    <div class="form-group pricingModelSet">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_WAITING_CHARGE; ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="waiting_charge" name="waiting_charge" class="form-control number">

                                        </div>
                                        <div class="col-sm-3 error-box" id="waiting_chargeErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_CANCILATIONFEE; ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="cancilationfee" name="cancilationfee" class="form-control number">

                                        </div>
                                        <div class="col-sm-3 error-box" id="cancilationf"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Length of Vehicle</label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-6">
                                                <input type="text" id="vehicle_length" name="vehicle_length" class="form-control number" style="margin-left: -9px;">
                                            </div>
                                           <div class="col-sm-2">
                                               <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="vehicle_length_metric">
                                                    <option value="M">Meter</option>
                                                    <option value="F">Feet</option>
                                                </select>
                                             </div>
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicle_lengthErr"></div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Width of Vehicle</label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-6">
                                                <input type="text" id="vehicle_width" name="vehicle_width" class="form-control number" style="margin-left: -9px">
                                            </div>
                                           <div class="col-sm-2">
                                                <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="vehicle_width_metric">
                                                      <option value="M">Meter</option>
                                                    <option value="F">Feet</option>
                                                </select>
                                             </div>
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicle_widthErr"></div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Height of Vehicle</label>
                                        <div class="col-sm-6">
                                                 <div class="col-sm-6">
                                                    <input type="text" id="vehicle_height" name="vehicle_height" class="form-control number" style="margin-left: -9px;">
                                                </div>
                                             <div class="col-sm-2">
                                                <select class="form-control" style="height: 34px; font-size: 11px; display: block;  min-width: 85px;" name="vehicle_height_metric">
                                                     <option value="M">Meter</option>
                                                    <option value="F">Feet</option>
                                                </select>
                                             </div>
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicle_heightErr"></div>

                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Load Bearing Capacity (Tonnes)</label>
                                        <div class="col-sm-6">
                                                 <div class="col-sm-6">
                                                    <input type="text" id="vehicle_capacity" name="vehicle_capacity" class="form-control number" style="margin-left:-9px">
                                                     
                                                </div>
<!--                                             <div class="col-sm-2">
                                                 
                                                    <button class="btn btn-default" type="button">Tones</button>
                                                
                                             </div>-->
                                        </div>
                                        <div class="col-sm-3 error-box" id="vehicle_heightErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_ONIMAGE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="file" id="type_on_image" name="type_on_image" class="form-control">

                                        </div>
                  
                                        <div class="col-sm-3 error-box" id="type_on_imageErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_OFFIMAGE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="file" id="type_off_image" name="type_off_image" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box" id="type_off_imageErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_MAPIMAGE; ?></label>
                                        <div class="col-sm-6">
                                            <input type="file" id="type_map_image" name="type_map_image" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box" id="type_map_imageErr"></div>

                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_DESCRIPTION; ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="discrption" name="descrption" class="form-control">

                                        </div>
                                        <div class="col-sm-3 error-box" id="disc"></div>

                                    </div>


                            <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"></label>
                                            <div class="col-sm-6">
                                       <button type="button"  id="addvehicle" class="btn btn-primary btn-cons">Add</button>
                                       <button  type="button" class="btn btn-default btn-cons" id="cancel"><?php echo BUTTON_CANCEL; ?></button></div>
                                         </div>
                                         </div>
 
                                </div>
                                 </form>
                            </div>



                            <div class="tab-pane slide-left padding-20 <?php echo $activetab2 ?>" id="tab2">
                                 <form id="updateentity" method="post" class="form-horizontal" role="form" action="<?php echo base_url('index.php?/vehicle') ?>/update_vehicletype/<?php echo $param;?>"  enctype="multipart/form-data">

                  
                                <div class="row row-same-height">
                                    <?php
                                    foreach ($editvehicletype as $value) {
                                        $v_length = substr($value->vehicle_length,0,-1);
                                        $v_length_metric =  substr($value->vehicle_length,-1);
                                        
                                        $v_width = substr($value->vehicle_width,0,-1);
                                        $v_width_metric = substr($value->vehicle_width,-1);
                                        
                                        $v_height = substr($value->vehicle_height,0,-1);
                                        $v_height_metric = substr($value->vehicle_height,-1);
                                       
                                        ?>
                                        <div class="form-group" class="formexx">
                                            <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_NAME; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="vehicletypename_s" name="vehicletypename_s" class="form-control" value="<?php echo $value->type_name; ?>">

                                            </div>
                                            <div class="col-sm-3 error-box" id="vehicle_type_name"></div>
                                        </div>

                                      <div class="form-group pricingModelSet">
                                        <label for="address" class="col-sm-2 control-label">Mileage Price<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-2">
                                            <input type="text" id="edit_mileage" name="edit_mileage" class="form-control"  onkeypress="return isNumber(event)" value="<?php echo $value->mileage_after_x_km_miles; ?>">
                                          
                                        </div>
                                        <div class="col-sm-2">
                                         <select class="form-control" id="edit_mileage_metric" name="edit_mileage_metric">
                                             <?php
                                                  $km = '';
                                                  $miles = '';
                                                   if($value->mileage_metric == '0')
                                                       $km = 'selected';
                                                   else 
                                                        $miles = 'selected';
                                                   ?>
                                                    <option value="0" <?php echo $km;?>>Km</option>
                                                    <option value="1" <?php echo $miles;?>>Miles</option>
                                                </select> 
                                        </div>
                                         <div class="col-sm-2">
                                        <input type="text" id="edit_mileage_after" name="edit_mileage_after" class="form-control number"  placeholder="Price after x km" value="<?php echo $value->mileage_price_after_x_km_miles; ?>">
                                         </div>
                                        <div class="col-sm-2 error-box" id="edit_mileageErr"></div>

                                    </div>
                                          <div class="form-group pricingModelSet">
                                        <label for="address" class="col-sm-2 control-label">Price<span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-2">
                                            <input type="text" id="x_minutesEdit" name="x_minutesEdit" class="form-control"  onkeypress="return isNumber(event)" placeholder="Enter minutes" value="<?php echo $value->x_minutes; ?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text"  class="form-control" value="Minutes" disabled>
                                        </div>
                                         <div class="col-sm-2">
                                            <input type="text" id="price_after_x_minEdit" name="price_after_x_minEdit" class="form-control  number"  placeholder="Price after x minutes" value="<?php echo $value->price_after_x_min; ?>">
                                         </div>
                                        <div class="col-sm-2 error-box" id="price_after_x_minEditErr"></div>

                                    </div>

                                    <div class="form-group pricingModelSet">
                                            <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_MINIMUMFARE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="minimumfare_s" name="minimumfare_s" class="form-control number" value="<?php echo $value->min_fare; ?>">

                                            </div>
                                            <div class="col-sm-3 error-box" id="vehicle_minimumfare"></div>

                                        </div>


                                     <div class="form-group pricingModelSet">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_WAITING_CHARGE; ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="waiting_charge_edit" name="waiting_charge_edit" class="form-control number" value="<?php echo $value->waiting_charge_per_min;?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="waiting_charge_editErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_CANCILATIONFEE; ?></label>
                                        <div class="col-sm-6">
                                            <input type="text" id="cancilationfee_s" name="cancilationfee_s" class="form-control number" value="<?php echo $value->cancilation_fee; ?>">

                                        </div>
                                        <div class="col-sm-3 error-box" id="cancilationf"></div>

                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Length of Vehicle</label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-6">
                                                <input type="text" id="edit_vehicle_length" name="edit_vehicle_length" class="form-control number" style="margin-left: -9px;"  value="<?php echo $v_length;?>">
                                            </div>
                                           <div class="col-sm-2">
                                               <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="edit_vehicle_length_metric">
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
                                        <div class="col-sm-3 error-box" id="edit_vehicle_lengthErr"></div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Width of Vehicle</label>
                                        <div class="col-sm-6">
                                            <div class="col-sm-6">
                                                <input type="text" id="edit_vehicle_width" name="edit_vehicle_width" class="form-control number" style="margin-left: -9px" value="<?php echo $v_width;?>">
                                            </div>
                                           <div class="col-sm-2">
                                                <select class="form-control" style="height: 34px; font-size: 11px; display: block;min-width: 85px;" name="edit_vehicle_width_metric">
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
                                        <div class="col-sm-3 error-box" id="edit_vehicle_widthErr"></div>

                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Height of Vehicle</label>
                                        <div class="col-sm-6">
                                                 <div class="col-sm-6">
                                                    <input type="text" id="edit_vehicle_height" name="edit_vehicle_height" class="form-control number" style="margin-left: -9px;" value="<?php echo $v_height;?>">
                                                </div>
                                             <div class="col-sm-2">
                                                 
                                                <select class="form-control" style="height: 34px; font-size: 11px; display: block;  min-width: 85px;" name="edit_vehicle_height_metric">
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
                                        <div class="col-sm-3 error-box" id="edit_vehicle_heightErr"></div>

                                    </div>


                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label">Load Bearing Capacity (Tonnes)</label>
                                        <div class="col-sm-6">
                                                 <div class="col-sm-6">
                                                    <input type="text" id="edit_vehicle_capacity" name="edit_vehicle_capacity" class="form-control number" style="margin-left:-9px" value="<?php echo $value->vehicle_capacity;?>">
                                                     
                                                </div>
<!--                                             <div class="col-sm-2">
                                                 
                                                    <button class="btn btn-default" type="button">Tones</button>
                                                
                                             </div>-->
                                        </div>
                                        <div class="col-sm-3 error-box" id="edit_vehicle_heightErr"></div>

                                    </div>

                                    
                                        
                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_ONIMAGE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">

                                            <input type="file" id="type_on_image_edit" name="type_on_image_edit" class="form-control">
                                            
                                         <input type="hidden" value="<?php echo $value->type_on_image; ?>" id='viewimage_on_image'>
                                                

                                        </div>
                                        <?php
                                                if ($value->vehicle_img != '') {
                                                    ?>
                                        <a class="pull-left" target="_blank" href="<?php echo base_url()?>../../pics/<?php echo $value->vehicle_img; ?>" style="color:royalblue">view</a> 

                                                <?php }
                                                ?>
                                        <div class="col-sm-3 error-box" id="type_on_image_editErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_OFFIMAGE; ?><span style="" class="MandatoryMarker"> *</span></label>
                                        <div class="col-sm-6">
                                            <input type="file" id="type_off_image_edit" name="type_off_image_edit" class="form-control">

                                             <input type="hidden" value="<?php echo $value->type_off_image; ?>" id='viewimage_off_image'>
                                               
                                        </div>
                                         <?php
                                                if ($value->vehicle_img_off != '') {
                                                    ?>
                                                    <a class="pull-left" style="color:royalblue" target="_blank" href="<?php echo base_url()?>../../pics/<?php echo $value->vehicle_img_off; ?>">view</a> 

                                                <?php }
                                                ?>
                                        <div class="col-sm-3 error-box" id="type_off_image_editErr"></div>

                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_MAPIMAGE; ?></label>
                                        <div class="col-sm-6">
                                            <input type="file" id="type_map_image_edit" name="type_map_image_edit" class="form-control">

                                           
                                        </div>
                                         <input type="hidden" value="<?php echo $value->map_icon; ?>" id='viewimage_map_image'>
                                                <?php
                                                if ($value->MapIcon != '') {
                                                    ?>
                                         <a class="pull-left" style="color:royalblue" target="_blank" href="<?php echo base_url()?>../../pics/<?php echo $value->MapIcon; ?>">view</a> 

                                                <?php }
                                                ?>
                                        <div class="col-sm-3 error-box" id="type_map_image_editErr"></div>

                                    </div>
                                    


                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label"><?PHP ECHO FIELD_VEHICLETYPE_DESCRIPTION; ?></label>
                                            <div class="col-sm-6">
                                                <input type="text" id="discrption_s" name="discrption_s" class="form-control" value="<?php echo $value->type_desc; ?>">

                                            </div>
                                            <div class="col-sm-3 error-box" id="vehicletype_description"></div>
                                        </div>


                                        <div class="form-group">
                                             <label for="address" class="col-sm-2 control-label"></label>
                                            <div class="col-sm-6">
                                                <button class="btn btn-success btn-cons" id="exx" type="button">Save</button>
                                                <button type="button" class="btn btn-default btn-cons" id="cancel_s"><?php echo BUTTON_CANCEL ?></button>
                                            </div>
                                            
                                        </div>
                                    <?php }
                                    ?>

                                </div>
                                      </form>
                            </div>
                             



                        </div>
                   

                </div>


            </div>



        </div>


    </div>
    <!-- END PANEL -->
</div>


<!-- END JUMBOTRON -->

<!-- START CONTAINER FLUID -->
<div class="container-fluid container-fixed-lg">
    <!-- BEGIN PlACE PAGE CONTENT HERE -->

    <!-- END PLACE PAGE CONTENT HERE -->
</div>
<!-- END CONTAINER FLUID -->


<!-- END PAGE CONTENT -->



<div class="modal fade stick-up" id="confirmmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdata" style="font-size: large;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmed" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade stick-up" id="confirmmodelsa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatasa" style="font-size: large;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-12" >
                        <button type="button" class="btn btn-primary pull-right" id="confirmedsa" ><?php echo BUTTON_OK; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="confirmmodels" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <div class=" clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>

                </div>

            </div>
            <br>
            <div class="modal-body">
                <div class="row">

                    <div class="error-box" id="errorboxdatas" style="font-size: large;text-align:center"><?php echo VEHICLEMODEL_DELETE; ?></div>

                </div>
            </div>

            <br>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4" ></div>
                    <div class="col-sm-4 pull-right"> <button type="button" class="btn btn-primary pull-right" id="no"><?php echo BUTTON_NO; ?></button></div>
                    <div class="col-sm-4 pull-right">
                        <button type="button" class="btn btn-primary pull-right" id="ok" ><?php echo BUTTON_YES; ?></button>
                    </div>
                </div>
            </div>


        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>